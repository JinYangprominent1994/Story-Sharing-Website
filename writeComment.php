<!DOCTYPE HTML>
<html lang = "en-GB">
<head>
	<meta charset = "utf-8">
	<title> Write Your Comment </title>
	<link href = "CSS/phpStyle.css" rel = "stylesheet" type = "text/css">
</head>
<body>
	<header class = "New Comment">
		<p class = "Title"> Please submit your comment here </p>
		</header>
	<main>
		<?php
		 session_start();
		 $story_id = $_POST['story_id'];
		 printf('
     <form action = "submitComment.php" method = "post">
			 <p class = "content"> Content: </P>
			 <p><textarea type = "text" name = "content" row="50" maxlength="1000"/></textarea><p>
			 <input type="hidden" name="story_id" value=%d>
			 <input type="hidden" name="token" value=%s>
			 <p><input class = "button" type = "submit" value = "submit" /></p>
     </form>
		 ',$story_id,$_SESSION['token']); // write new comment
		 ?>

  </main>

</body>
</html>
