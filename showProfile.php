<!DOCTYPE html>
<html lang="en-GB">
<head>
  <meta charset = "utf-8">
	<title>Show Profile</title>
  <link href = "CSS/phpStyle.css" rel = "stylesheet" type = "text/css">
</head>
<body>

<?php
	$searchUser=$_POST["searchUser"]; // Get the username and show his/her profile

	if (empty($_POST['searchUser'])){ // If users do not input a username that they want to search, error
		echo "Null Username Input";
		printf('<p><a href="mainPage.html">Return to Homepage</a></p>');
		exit;
	}

	require 'database.php';

  $stmt=$mysqli->prepare("select story_id,story_title, story_time from story join user on (story.story_author_id=user.user_id) where user_name like ? ");
	if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
  }
	$stmt->bind_param("s", $searchUser);
  $stmt->execute();
  $stmt->bind_result($story_id,$story_title,$story_time); // Select user's stories

	printf("<ul>\n");
	printf("This person's stories:"); // Show this user's all stories
  while($stmt->fetch()){
		printf("<li>");
		printf("<p><a href = 'readStory.php?story_id=%s'>%s  %s</a></p>",htmlspecialchars($story_id), htmlspecialchars($story_title),htmlspecialchars($story_time));
		printf("</li>");
		if(empty($story_id)){
			echo'cannot find your content';
		}
	}
	printf("</ul>\n");
	$stmt->close();

	require 'database.php';

	$stmt=$mysqli->prepare("select comment_content from comment join user on (comment.comment_author_id=user.user_id) where user_name like ?");
	if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
	}
	$stmt->bind_param("s", $searchUser);
	$stmt->execute();
	$stmt->bind_result($comment_content); // Get user's all comments

	printf("\n");
	printf("<hr />");
	printf("<ul>\n");
	printf("This person's comments:"); // Show this user's all comments
	while($stmt->fetch()){
		printf("<li>");
		printf("<p>%s</p>",htmlspecialchars($comment_content));
		printf("</li>");
	}
	printf("</ul>\n");
	$stmt->close();
	printf('<p><a href="mainPage.html">Return to Homepage</a></p>');

?>
</body>
</html>
