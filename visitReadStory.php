<!DOCTYPE html>
<html lang="en-GB">
<head>
  <meta charset = "utf-8">
	<title>Visit Read Story</title>
  <link href = "CSS/phpStyle.css" rel = "stylesheet" type = "text/css">
</head>
<body>

<?php
	session_start();

	require 'database.php';

  $story_id=$_GET['story_id']; // Get story_id
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
				printf("</li>");
				printf("<hr />");

     $numberOfComment = $numberOfComment + 1; // Show next comment
	}
	printf("</ul>\n");
	printf("\n");
	$stmt->close();
  printf('<p><a href="visitMainPage.html"> Return to Homepage</a></p>');

?>
</body>
</html>
