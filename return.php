<!DOCTYPE html>
<html lang="en-GB">
<head>
  <meta charset = "utf-8">
	<title>Return</title>
  <link href = "CSS/phpStyle.css" rel = "stylesheet" type = "text/css">
</head>
<body>
<?php

session_start();

echo "Cancel register";
header( 'Location: login.html' );
exit;
?>

</body>
</html>
