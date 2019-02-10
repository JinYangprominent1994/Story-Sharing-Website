<!DOCTYPE html>
<html lang="en-GB">
<head>
  <meta charset = "utf-8">
	<title>Update Comemnt</title>
  <link href = "CSS/phpStyle.css" rel = "stylesheet" type = "text/css">
</head>
<body>

<?php
	session_start();

    if($_SESSION['token'] !== $_POST['token']){ // Use token to prevent CSRF attacks
      die("Request forgery detected");
    }

    if (empty($_POST['comment_content'])){ // If users do not input comment content, error
      echo "Null Content";
      printf('<p><a href="showStory.html">Return to Show Story Page</a></p>');
      exit;
    }

		$user_id = $_SESSION['user_id']; // Get user_id
	  $comment_id = $_POST['comment_id']; //Get commit_id
    $comment_content = $_POST['comment_content']; // Get comment_content

		if (!isset($_SESSION['user_id'])){ // If user visits website without login
			echo "Please log in first";
			printf('<p><a href="login.html"> Return to Login Page</a></p>'); // User has to log in to update a comment
			exit;
		}

	  require 'database.php';

	  $stmt = $mysqli->prepare("update comment set comment_content=? where comment_id=?");
	  if(!$stmt){
		  printf("Query Prep Failed: %s\n", $mysqli->error);
		  exit;
	  }

	  $stmt->bind_param('si', $comment_content, $comment_id); // Update comment_content through comment_id

	  if ($stmt->execute() ){
      echo "Edit Comment Successfully";
		  printf('<p><a href="showStory.php">Return to Story Page</a></p>');
	  }else{
		  echo "Unexpected Errors";
			printf('<p><a href="mainPage.html">Return to Homepage</a></p>'); //update fail
	  }
	  $stmt->close();

?>
</body>
</html>
