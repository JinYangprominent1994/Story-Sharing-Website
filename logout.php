<!DOCTYPE html>
<html lang="en-GB">
<head>
  <meta charset = "utf-8">
	<title>Log Out</title>
  <link href = "CSS/phpStyle.css" rel = "stylesheet" type = "text/css">
</head>
<body>

<?php

session_start();

if(isset($_POST["logout"])){
  session_destroy(); // If log out, clear all session
  echo "Logout Successfully";
  printf('<p><a href="login.html">Return to Login Page</a></p>'); // After log out, the page would jump to login page
}
?>

</body>
</html>
