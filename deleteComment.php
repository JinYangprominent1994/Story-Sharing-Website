<!DOCTYPE html>
<html lang="en-GB">
<head>
  <meta charset = "utf-8">
	<title>Delete Comemnt</title>
  <link href = "CSS/phpStyle.css" rel = "stylesheet" type = "text/css">
</head>
<body>

<?php
	session_start();
	$user_id = $_SESSION['user_id']; // Get user's user_id
	$comment_id = $_POST['comment_id']; // Get comment_id for the comment that user want to delete

	  // prevent directly visit
	  if (!isset($_SESSION['user_id'])){ // If user visit the website without login
			echo "Please log in first";
		  printf('<p><a href="login.html">Return to Login Page</a></p>'); // User has to login to delete comment
	  }

		if(empty($_POST['comment_id'])){
			echo "Unexpected Errors"; // If specific comment cannot be found
			printf('<p><a href="mainPage.html"> Return to Homepage</a></p>');
			exit;
		}

    if($_SESSION['token'] !== $_POST['token']){ // Use token to prevent CSRF attacks
      die("Request forgery detected");
    }

	  require 'database.php';

	  $stmt = $mysqli->prepare("select comment_author_id, comment_story_id from comment where comment_id = ?");
	  if(!$stmt){
		  printf("Query Prep Failed: %s\n", $mysqli->error);
		  exit;
	  }
	  $stmt->bind_param('i', $comment_id);
	  $stmt->execute();

	  $stmt->bind_result($comment_author_id, $comment_story_id); // Get comment_author_id and comment_story_id through comment_id
	  $stmt->fetch();
	  $stmt->close();

    if ($user_id != $comment_author_id) { // If user_id that user use to login not equal to comment_author_id
      echo "You are not the author of this comment.You can delete it";
    } else {
		  require 'database.php';

		  $stmt = $mysqli->prepare("delete from comment where comment_id = ?");
		  if(!$stmt){
			  printf("Query Prep Failed: %s\n", $mysqli->error);
			  exit;
		  }
		  $stmt->bind_param('i', $comment_id); // Delete comments

		  if ($stmt->execute() ){
			  echo "Delete Successfully";
        printf('<p><a href="mainPage.html"> Return to Homepage</a></p>');
		  }else{
				echo "Unexpected error";
				printf('<p><a href="readStory.php"> Return to Story Page</a></p>');
      }
		  $stmt->close();
	  }
?>

</body>

</html>
