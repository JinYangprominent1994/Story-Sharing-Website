<!DOCTYPE html>
<html lang="en-GB">
<head>
  <meta charset = "utf-8">
	<title>Delete Story</title>
  <link href = "CSS/phpStyle.css" rel = "stylesheet" type = "text/css">
</head>
<body>

<?php
	session_start();

	$user_id = $_SESSION['user_id']; // Get user's user_id
	$story_id = $_POST['story_id']; // Get user's story_id

	if (!isset($_SESSION['user_id'])){ // if user visits without login
		echo "Please log in first";
		printf('<p><a href="login.html">Return to Login Page</a></p>'); // User has to login to delete story
		exit;
	}

	if(empty($_POST['story_id'])){ // // If specific story cannot be found
		echo "Unexpected Errors";
	}

	if($_SESSION['token'] !== $_POST['token']){ // Use token to prevent CSRF attacks
		die("Request forgery detected");
	}

	require 'database.php';

	$stmt = $mysqli->prepare("select story_author_id from story where story_id = ?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('i', $story_id);
	$stmt->execute();

	$stmt->bind_result($story_author_id); // Get story_author_id through story_id
	$stmt->fetch();
	$stmt->close();

	if ($user_id != $story_author_id) { // If user_id that user use to login not equal to sotry_author_id
		echo "<p>You are not the author of this story,so you cannot delete it</p>";
		printf('<p><a href="mainPage.html">Return to Homepage</a></p>');
	}
	else {
		require 'database.php';
		//delete comments on this news from the databse
		$stmt = $mysqli->prepare("delete from comment where comment_story_id=?");
		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
		$stmt->bind_param('i', $story_id); // Delete this comment from database first,
		$stmt->execute();

		$stmt = $mysqli->prepare("delete from story where story_id=?");
		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
		$stmt->bind_param('i', $story_id); // Delete this story

		if ( $stmt->execute() ){
			echo "Delete Successfully.";
			printf('<p><a href="mainPage.html"> Return to Homepage</a></p>');
		}
		else{
			echo "Unexpected error";
			printf('<p><a href="mainPage.html">Return to Homepage</a></p>'); // Delete failed
		}
		$stmt->close();
	}
?>
</body>
</html>
