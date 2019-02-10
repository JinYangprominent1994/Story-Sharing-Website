<!DOCTYPE html>
<html lang="en-GB">
<head>
  <meta charset = "utf-8">
	<title>Search</title>
  <link href = "CSS/phpStyle.css" rel = "stylesheet" type = "text/css">
</head>
<body>

<?php
	$searchContent=$_POST["searchContent"]; // Get the content that user inputs and wants to search

	if (empty($_POST['searchContent'])){ // If users do not input search content, error
		echo "Null Search Content";
		printf('<p><a href="mainPage.html">Return to Homepage</a></p>');
		exit;
	}

	require 'database.php';
  $stmt=$mysqli->prepare("select story_id,story_title, story_author_id,story_content,story_time from story where story_title like '%$searchContent%'");
	if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
  }
  $stmt->execute();
  $stmt->bind_result($story_id,$story_title, $story_author_id,$story_content,$story_time); // Use %searchContent% to match the Content

	printf("<p>Search Result:</p>");
	printf("<ul>\n");
	while($stmt->fetch()){
		printf('<li><a href = "readStory.php?story_id=%s"> %s </a></li><br>',htmlspecialchars($story_id), htmlspecialchars($story_title));
		if(empty($story_id)){
			echo'cannot find your search content';
			printf('<p><a href="mainPage.html">Return to  Homepage</a></p>');
		}
	}
	printf("</ul>");
	$stmt->close(); // Show all Stories that match the serach content
?>
<p><a href="mainPage.html">Return to Homepage</a></p>
</body>
</html>
