<!DOCTYPE html>
<html lang="en-GB">
<head>
  <meta charset = "utf-8">
	<title>Visit Show Story</title>
  <link href = "CSS/phpStyle.css" rel = "stylesheet" type = "text/css">
</head>
<body>

<?php
	session_start();

	require 'database.php';

	if (!empty($_POST['storyDate']) ) { // If a visitor has input a date, stories that submitted in this date would be selected from database and show them in the screen
	    $selectedDay=$_POST['storyDate'];
	    $startTime=$selectedDay." 00:00:00";
	    $endTime=$selectedDay." 23:59:59";

	    $stmt = $mysqli->prepare("select story_id, story_title, story_time from story where story_time between ? and ? order by story_time");
	    if(!$stmt){
	       printf("Query Prep Failed: %s\n", $mysqli->error);
	       exit;
	     }
	     $stmt->bind_param("ss", $startTime, $endTime); // Select stories whose submitted time is between start time and end time in this day

	    } else {
	     $stmt = $mysqli->prepare("select story_id, story_title, story_time from story order by story_time desc");
	     if(!$stmt){
	        printf("Query Prep Failed: %s\n", $mysqli->error);
	        exit;
	       }
	    }
		$stmt->execute(); // If user did not input a date, all stories would showed and ordered by submitted time

		$stmt->bind_result($story_id, $story_title, $story_time);
		//$_SESSION['story_id'] = $story_id;

		echo "<ul>\n";
		while($stmt->fetch()){ // Show all stories one by one
			printf("\t<li><p><a href='visitReadStory.php?story_id=%d'>%s.%s</a></p></li>\n",
				htmlspecialchars($story_id),htmlspecialchars($story_title),htmlspecialchars($story_time)
			);
		}
		echo "</ul>\n";

		$stmt->close();
		printf('<p><a href="visitMainPage.html">Return to Homepage</a></p>');

	?>
</body>
</html>
