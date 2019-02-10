<!DOCTYPE html>
<html lang="en-GB">
<head>
  <meta charset = "utf-8">
	<title>Register</title>
  <link href = "CSS/phpStyle.css" rel = "stylesheet" type = "text/css">
</head>
<body>


<?php
session_start();

require 'database.php';

if(empty($_POST['username'])){ // If user did not input a username, he/she cannot register
  echo "Null username";
  printf('<p><a href="register.html">Return to Register Page</a></p>');
  exit;
}

if(empty($_POST['password'])){ // If user did not input a username, he/she cannot register
  echo "Null password";
  printf('<p><a href="register.html">Return to Register Page</a></p>');
  exit;
}

if (isset($_POST['username']) && isset($_POST['password'])) { // If user input username and password
    $username = $_POST['username']; // Get username
    $password = $_POST['password']; // Get password
    $hashed_password = password_hash($password,PASSWORD_DEFAULT); // Hash the password and store this hashed password in database

    $stmt = $mysqli->prepare("select user_name from user");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->execute();
    $stmt->bind_result($name);
    while($stmt->fetch()){
	  if($_POST['username'] === $name){ // If username has been used, user has to select other usernames
	     echo 'exist username';
	     printf('<p><a href="register.html">Return to Register Page</a></p>');
	     exit;
    	}
    }

    $stmt = $mysqli->prepare("INSERT INTO user (user_name, user_password) VALUES (?, ?)");
    if (!$stmt) {
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param("ss", $username, $hashed_password); // Insert username and password into database
    if ($stmt->execute()) { // If user register successfully
        echo "register successfully";
        printf('<p><a href="login.html">Return to Login Page</a></p>');
        exit;
    }else{
        echo "Unexpected Errors";
    }
    $stmt->close();
 }
?>

</body>
</html>
