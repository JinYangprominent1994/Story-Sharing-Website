<!DOCTYPE html>
<html lang="en-GB">
<head>
  <meta charset = "utf-8">
	<title>Visit Date</title>
  <link href = "CSS/phpStyle.css" rel = "stylesheet" type = "text/css">
</head>
<body>

<?php

session_start();

if(isset($_POST["date"])){
  date_default_timezone_set('America/Chicago'); // Set timezone to America/Chicago
  echo "Timezone: America/Chicago<br>";
  echo "Today is  " . date("Y/m/d H:i:s") . "<br>"; // Show the date for today
  printf('<p><a href="visitMainPage.html">Return to Homepage</a></p>');
}

?>
</body>
</html>
