<!DOCTYPE html>
<html lang="en-GB">
<head>
  <meta charset = "utf-8">
	<title>Update Story</title>
  <link href = "CSS/phpStyle.css" rel = "stylesheet" type = "text/css">
</head>
<body>

<?php
	session_start();

	if (!isset($_SESSION['user_id']) ){ // If user visits website without login or specific story cannot be found
    echo "Please login first";
		printf('<p><a href="login.html">Return to Login Page</a></p>');
		exit;
	}

	if($_SESSION['token'] !== $_POST['token']){ // Use token to prevent CSRF attacks
		die("Request forgery detected");
	}

  if (empty($_POST['story_title'])){ // If users do not input a title for the story, error
		echo "Null Title";
		printf('<p><a href="showStory.html">Return to Show Story Page</a></p>');
		exit;
	}

	if (empty($_POST['story_content'])){ // If users do not input content for the story, error
		echo "Null Content";
		printf('<p><a href="showStory.html">Return to Show Story Page</a></p>');
		exit;
	}

	date_default_timezone_set('America/Chicago'); // Set timezone to America/Chicago
	$story_id = $_POST['story_id']; // Get story_id that user inputs
	$story_title = $_POST['story_title']; //Get story_title that user inputs
	$story_content = $_POST['story_content']; // Get story_content that user inputs
  $story_link = $_POST['story_link']; // Get story_link that user inputs
	$story_time = date('Y-m-d H:i:s'); // Get current time that story are submitted

	require 'database.php';

	$stmt = $mysqli->prepare("update story set story_title= ?,  story_content= ? , story_link= ? where story_id= ?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$stmt->bind_param('sssi', $story_title,$story_content, $story_link, $story_id);
	$stmt->execute();
	$stmt->close();

	echo "Edit Story Successfully";
	printf('<p><a href="showStory.html">Return to Story Page</a></p>');
	exit;

?>
</body>
</html>
