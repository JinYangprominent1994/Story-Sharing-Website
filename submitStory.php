<!DOCTYPE html>
<html lang="en-GB">
<head>
  <meta charset = "utf-8">
	<title>Submit Story</title>
  <link href = "CSS/phpStyle.css" rel = "stylesheet" type = "text/css">
</head>
<body>

<?php

session_start();

if($_SESSION['token'] !== $_POST['token']){ // Use token to prevent CSRF attacks
		die("Request forgery detected");
	}

	if(empty($_SESSION['user_id'])){ // If user visit website without login
		echo "Please log in";
		printf('<p><a href="mainPage.html">Return to Homepage</a></p>'); // User has to log in to submit story
		exit;
	}

	if (empty($_POST['title'])){ // If users do not input a title for the story, error
		echo "Null Title";
		printf('<p><a href="mainPage.html">Return to Homepage</a></p>');
		exit;
	}

	if (empty($_POST['content'])){ // If users do not input content for the story, error
		echo "Null Content";
		printf('<p><a href="mainPage.html">Return to Homepage</a></p>');
		exit;
	}

	require 'database.php';
	date_default_timezone_set('America/Chicago');

  $story_title = $_POST['title']; // Get story_title through title that user inputs
  $story_content = $_POST['content']; // Get story_content through content that user inputs
  $story_time = date('Y/m/d H:i:s'); // Get story_time through date that user inputs
	$story_link = $_POST['link']; // Get story_link through link that user inputs

  $stmt = $mysqli->prepare("Insert into story (story_title,story_author_id,story_content,story_time,story_link) values (?,?,?,?,?)");
  if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
  }

  $stmt->bind_param('sisss',$story_title,$_SESSION['user_id'],$story_content,$story_time,$story_link);
	if($stmt->execute()){
     $stmt->close();
    echo'Submit New Story Successfully';
		printf('<p><a href="mainPage.html">Return to Homepage</a></p>');
		exit;
  } else {
		echo "Unexpected Errors";
		printf('<p><a href="writeStory.php">Write Story Again</a></p>');
		exit;
	}

?>
</body>
</html>
