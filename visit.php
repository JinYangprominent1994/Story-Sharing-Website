<!DOCTYPE html>
<html lang="en-GB">
<head>
  <meta charset = "utf-8">
	<title>Visit</title>
  <link href = "CSS/phpStyle.css" rel = "stylesheet" type = "text/css">
</head>
<body>

<?php

session_start();

 $_SESSION['token'] = substr(md5(rand()), 0, 10); // Create Token to prevent CSRF attacks

  echo "Visit Successfully"; // If user only want to visit this website without login
  printf('<p><a href="visitMainPage.html">Go To Homepage</a></p>');
  exit;

?>
</body>
</html>
