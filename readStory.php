<!DOCTYPE html>
<html lang="en-GB">
<head>
  <meta charset = "utf-8">
	<title>Read Story</title>
  <link href = "CSS/phpStyle.css" rel = "stylesheet" type = "text/css">
</head>
<body>

<?php
	session_start();

	require 'database.php';

	if (!isset($_SESSION['user_id'])){ // If user visit the website without login
		echo "Please log in first";
		printf('<p><a href="login.html">Return to Login Page</a></p>'); // User has to login to delete comment
	}

  $story_id=$_GET['story_id']; // Get story_id
  $user_id=$_SESSION['user_id']; // Get user_id

	$stmt = $mysqli->prepare("select story_title, story_author_id, story_content, story_time,story_link,user.user_name from story join user on (story.story_author_id=user.user_id) where story_id like ?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('i', $story_id);
	$stmt->execute();

	$stmt->bind_result($story_title, $story_author_id, $story_content, $story_time, $story_link,$story_author_name);
	$stmt->fetch();
	$stmt->close();

	printf("<head>\n<title>story:%s</title>\n</head>\n",htmlspecialchars($story_title)); // Show the head of HTML

	printf ("<p><strong> Title: %s </strong></p>",htmlspecialchars($story_title)); // Show the title of story
    if ($_SESSION['user_id']){ // If user has logged in
        if ($_SESSION['user_id'] == $story_author_id) { // Editor has to be the original author
			printf("
				<form action='editStory.php' method='POST'>
					<input type='hidden' name='token' value=%s>
					<input type='hidden' name='story_id' value=%d>
					<input type='submit' value='edit This Story'>
				</form> ",$_SESSION['token'], $story_id);
			printf("<form action='deleteStory.php' method='POST'>
					<input type='hidden' name='token' value=%s>
					<input type='hidden' name='story_id' value=%d>
					<input type='submit' value='delete this story'>
				</form> ",$_SESSION['token'], $story_id);
		  }
    }  // If user is the original author, these two button would show in the webpage
		// If user is not the original author, this user cannot see these two button, so he/she cannot edit/delete this story

	printf("<p> Author: ".htmlspecialchars($story_author_name)."</p>\n"); // Show the author of this story
	printf("<p>Time Submit: ".htmlspecialchars($story_time)."</p>\n"); // Show the time that this story is submitted
    if (is_null($story_link)) { // If the author did not input a URL for this story
        echo "Cannot find a link for this story";
				printf('<p><a href="readStory.php">Return to the Story</a></p>');
    } else {
        printf("<p>URL:<a href='".htmlspecialchars($story_link)."'>".htmlspecialchars($story_link)."</a></p><br/>");
    }
	printf("<p>".htmlspecialchars($story_content)."</p>\n"); // Show the content of this story
	printf("\n");
	printf("\n");
	printf("\n");


	printf("<p><strong>Show Comments</strong></p>"); // Show Comments below
	printf("<form action='writeComment.php' method='POST'>
		  <input type='hidden' name='token' value=%s>
		  <input type='hidden' name='story_id' value=%d>
		  <input type='submit' value='submit Comment'>
	  </form> ",$_SESSION['token'], $story_id); // This button is used to submit comments for this story_id
		// Token is transferred through button post to prevent CSRF attacks

	require 'database.php';
  $comment_story_id=$_GET['story_id']; // Get comment_story_id through story_id

	$stmt = $mysqli->prepare("select comment_id, comment_author_id, comment_content,user.user_name from comment join user on (comment.comment_author_id = user.user_id) where comment_story_id = ? order by comment_id desc");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('i', $comment_story_id);
	$stmt->execute();

	$stmt->bind_result($comment_id, $comment_author_id, $comment_content, $comment_author_name);

	$numberOfComment = 1; // Use this variable to count the number of comments

	printf("<ul>\n"); // Show all comments one by one
	while($stmt->fetch()){
    printf("<li><p> Number %d Comment </p>",htmlspecialchars($numberOfComment)); // Show the number of this comment
		printf("<p>Comment Author: %s</p>",htmlspecialchars($comment_author_name)); // Show the author of this comment
		printf("<p>%s</p>", htmlspecialchars($comment_content)); // Show the content of this comment
    if($_SESSION['user_id']){
        if($_SESSION['user_id'] == $comment_author_id) { // If user is not the original author of this comment
        printf("
	       <form action='editComment.php' method='POST'>
		     <input type='hidden' name='token' value=%s>
		     <input type='hidden' name='comment_id' value=%d>
		     <input type='submit' value='edit this comment'>
	       </form>", $_SESSION['token'], $comment_id);

				printf("
	       <form action='deleteComment.php' method='POST'>
		     <input type='hidden' name='token' value=%s>
		     <input type='hidden' name='comment_id' value=%d>
		     <input type='submit' value='delete this comment'>
	       </form> ", $_SESSION['token'], $comment_id);// If user is the original author of this comment, these two button would show in the webpage
		 		// If user is not the original author, this user cannot see these two button, so he/she cannot edit/delete this comment
            }
        }
				printf("</li>");
				printf("<hr />");

     $numberOfComment = $numberOfComment + 1; // Show next comment
	}
	printf("</ul>\n");
	printf("\n");
	$stmt->close();
  printf('<p><a href="mainPage.html"> Return to Homepage</a></p>');

?>
</body>
</html>
