<!DOCTYPE HTML>
<html lang = "en-GB">
<head>
	<meta charset = "utf-8">
	<title> Write Your Story </title>
	<link href = "CSS/phpStyle.css" rel = "stylesheet" type = "text/css">
</head>
<body>
	<header class = "New Story">
		<p class = "Title"> Wirte Your Story Here</p>
		</header>
	<main>
		<?php
		session_start();
		printf('
    <form class = "StorySubmit" name = "input" action = "submitStory.php" method = "post">
       <p class = "content"> Title: <input type = "text" class = "Inputbox" name = "title"/> </p>
			 <p class = "content"> Link: <input type="url" name="link" size="50" maxlength="120"></p>
			 <p class = "content"> Content: </p>
			 <p><textarea type = "text" name = "content" size = "200" row="10"/> </textarea></p>
			 <p><input type="hidden" name="token" value=%s></p>
       <p class = "content"> <input class = "button" type = "submit" value = "submit" /> </p>
    </form>
		', $_SESSION['token']);
		?>

	</main>
	<p><a href="mainPage.html"> Return To Homepage</a></p>

</body>
</html>
