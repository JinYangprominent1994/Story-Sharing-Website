<!DOCTYPE html>
<html lang="en-GB">
<head>
  <meta charset = "utf-8">
	<title>Delete Personal Comment</title>
  <link href = "CSS/phpStyle.css" rel = "stylesheet" type = "text/css">
</head>
<body>
<?php
	session_start();
	$story_id =$_POST["story_id"];

	if (!isset($_SESSION['user_id'])){ // If user visits website without login
		echo "Please log in first";
		printf('<p><a href="login.html">Return to Login Page</a></p>'); // User has to log in to edit story
		exit;
	}

  if($_SESSION['token'] !== $_POST['token']){ // Use token to prevent CSRF attacks
    die("Request forgery detected");
  }

	if (empty($_POST['story_id']) ){ // If specific story cannot be found
      echo "Unexpected Errors";
		  printf('<p><a href="mainPage.html">Return to Homepage</a></p>');
		  exit;
	  }

	  require 'database.php';

	  $stmt = $mysqli->prepare("select story_title,story_author_id,story_content,story_time,story_link from story where story_id = ?");
	  if(!$stmt){
		  printf("Query Prep Failed: %s\n", $mysqli->error);
		  exit;
	  }
	  $stmt->bind_param('i', $story_id);
	  $stmt->execute();
	  $stmt->bind_result($story_title, $story_author_id, $story_content, $story_time, $story_link);
	  $stmt->fetch();
	  $stmt->close();

	if ($_SESSION['user_id'] !== $story_author_id){
    echo "You are not the author of this story. You cannot edit it";
		printf('<p><a href="mainPage.html">Return to Homepage</a></p>');
    exit;
  }
?>
	<form action="updateStory.php" method="POST">
		<p>
			<label for="story_title">Story Title</label>
			<input type="text" name="story_title" id="story_title" maxlength="100" value="<?php echo  htmlspecialchars($story_title)?>">
		</p>
		<p>
			<label for="story_link" >Story Link</label>
			<input type="text" name="story_link" id="story_link" maxlength="200" value="<?php echo  htmlspecialchars($story_link)?>">
		</p>
		<p>
      <label for="story_content" >Story Content</label>
			<textarea name="story_content" rows="5" maxlength="1000"><?php printf(htmlspecialchars($story_content)) ?></textarea>
		</p>
		<input type="hidden" name="token" value="<?php printf(htmlspecialchars($_SESSION['token'])) ?>">
    <input type="hidden" name="story_id" value="<?php printf(htmlspecialchars($story_id)) ?>">
		<p> <input class="button" type="submit" value="updateStory"> </p>
	</form>

	<p><a href="showStory.php"> Cancel Edit </a></p>
	<p><a href="mainPage.html"> Return To Homepage </a><p>
  </body>

</html>
