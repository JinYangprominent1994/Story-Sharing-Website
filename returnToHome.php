<!DOCTYPE html>
<html lang="en-GB">
<head>
  <meta charset = "utf-8">
	<title>Return To Homepage</title>
  <link href = "CSS/phpStyle.css" rel = "stylesheet" type = "text/css">
</head>
<body>
<?php

session_start();

echo "Cancel";
header( 'Location: mainPage.html' );
exit;

?>

</body>
</html>
