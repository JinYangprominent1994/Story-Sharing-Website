<!DOCTYPE html>
<html lang="en-GB">
<head>
  <meta charset = "utf-8">
	<title>Visit Login</title>
  <link href = "CSS/phpStyle.css" rel = "stylesheet" type = "text/css">
</head>
<body>

<?php
 session_start();
 printf("<p>You can use your account to log in</p>");
 printf("<p>If you don't have an account, you can register a new account</p>");
 printf('<p><a href="login.html">Return to Login Page</a></p>');
 ?>
</body>
</html>
