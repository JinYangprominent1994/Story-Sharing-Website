<!DOCTYPE html>
<html lang="en-GB">
<head>
  <meta charset = "utf-8">
	<title>Edit Comment</title>
  <link href = "CSS/phpStyle.css" rel = "stylesheet" type = "text/css">
</head>
<body>
<?php
	session_start();

	$user_id = $_SESSION['user_id'];
	$comment_id = $_POST['comment_id'];

	if (!isset($_SESSION['user_id'])){ // If user visits without login
		echo "Please log in first";
		printf('<p><a href="login.html">Return to login page</a></p>'); // User has to log in to edit comment
		exit;
	}

  if($_SESSION['token'] !== $_POST['token']){ // Use token to prevent CSRF attacks
    die("Request forgery detected");
  }

	  if (empty($_POST['comment_id'])){ // If specific comment cannot be found
      echo "Unexpected Errors";
		  printf('<p><a href="login.html">Return to login page</a></p>');
	    exit;
	  }

	  //get comment data from database
	  require 'database.php';

	  $stmt = $mysqli->prepare("select comment_author_id,comment_story_id,comment_content from comment where comment_id = ?");
	  if(!$stmt){
		  printf("Query Prep Failed: %s\n", $mysqli->error);
		  exit;
	  }
	  $stmt->bind_param('i', $comment_id);
	  $stmt->execute();

	  $stmt->bind_result($comment_author_id,$comment_story_id,$comment_content);
	  $stmt->fetch();
	  $stmt->close();

	if ($_SESSION['user_id'] != $comment_author_id){ // If user_id that user use to log in not equal to comment_author_id
    echo "You are not the author of this comment. You cannot edit it";
		printf('<p><a href="mainPage.html">Return to Homepage</a></p>');
    exit;
  }
?>
	<form action="updateComment.php" method="POST">
		<p><textarea name="comment_content" rows="5" maxlength="500" value=%s><?php echo htmlspecialchars($comment_content) ?></textarea></p>
		<input type="hidden" name="token" value="<?php echo htmlspecialchars($_SESSION['token'])?>">
		<input type="hidden" name="comment_id" value="<?php echo htmlspecialchars($comment_id)?>">
		<p> <input class = "button" type="submit" name="Update Comment" value="updateComment"> </p>
	</form>

	<p><a href="showStory.php">Cancel Edit</a></p>
</body>

</html>
