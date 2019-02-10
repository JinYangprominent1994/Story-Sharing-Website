<!DOCTYPE html>
<html lang="en-GB">
<head>
  <meta charset = "utf-8">
	<title>Submit Comemnt</title>
  <link href = "CSS/phpStyle.css" rel = "stylesheet" type = "text/css">
</head>
<body>

<?php

session_start();

	if (!isset($_SESSION['user_id'])){ // If user visits website without login
		echo "Please log in first";
		printf('<p><a href="login.html"> Return to Login Page</a></p>'); // User has to log in to submit a comment
		exit;
	}

	if($_SESSION['token'] !== $_POST['token']){ // Use token to prevent CSRF attacks
		die("Request forgery detected");
	}

	if (empty($_POST['content'])){ // If users do not input comment content, error
		echo "Null Content";
		printf('<p><a href="showStory.html">Return to Show Story Page</a></p>');
		exit;
	}

  $comment_author_id = $_SESSION['user_id']; // Get comment_author_id through user_id
  $comment_story_id = $_POST['story_id']; // Get comment_story_id through story_id
  $comment_content = $_POST['content']; // Get comment_content through comment that user inputs

  require 'database.php';
	$stmt = $mysqli->prepare("insert into comment (comment_author_id, comment_story_id, comment_content) values (?, ?, ?)");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$stmt->bind_param('iis', $comment_author_id,$comment_story_id,$comment_content);

	$stmt->execute();
	$stmt->close();
	echo "Submit Comment Successfully";
	printf('<p><a href="showStory.php">Return to Story Page</a></p>');
	exit;

?>
</body>
</html>
