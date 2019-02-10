<!DOCTYPE html>
<html lang="en-GB">
<head>
  <meta charset = "utf-8">
	<title>Change Username</title>
  <link href = "CSS/phpStyle.css" rel = "stylesheet" type = "text/css">
</head>
<body>

<?php

session_start();

$username = $_POST['username']; // Get user's name
$password = $_POST['password']; // Get user's user_id
$newUsername = $_POST['newUsername']; // Get user's new username

if (!isset($_SESSION['user_id'])){ // If user visit website without login
  echo "Please log in first";
  header("Location: login.html"); // User has to login to change the username
  exit;
}

if (empty($_POST['username'])){ // If users do not input a username, error
  echo "Null Username";
  printf('<p><a href="changeUsername.html">Return to Change Username Page</a></p>');
  exit;
}

if (empty($_POST['password'])){ // If users do not input a password, error
  echo "Null Password";
  printf('<p><a href="changeUsername.html">Return to Change Username Page</a></p>');
  exit;
}

if (empty($_POST['newUsername'])){ // If users do not input a new username, error
  echo "Null New Username";
  printf('<p><a href="changeUsername.html">Return to Change Username Page</a></p>');
  exit;
}

$cnt=1;
require 'database.php';

$stmt = $mysqli->prepare("select user_id, user_password from user where user_name = ?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->bind_result($user_id, $user_password); // Get user's user_id and user_password
$stmt->fetch();
$stmt->close();


if( $cnt == 1 && password_verify($_POST['password'],$user_password)){ // Compare the submitted password to the actual password hash
      $stmt = $mysqli->prepare("select user_name from user");
      if(!$stmt){
          printf("Query Prep Failed: %s\n", $mysqli->error);
          exit;
      }
      $stmt->execute();
      $stmt->bind_result($name);
      while($stmt->fetch()){
        if($_POST['newUsername'] === $name){
          echo 'exist username';
          printf('<p><a href="changeUsername.html">Return to Username Change Page</a></p>'); // If new username has been used, user has to select other usernames
          exit;
         }
      }
      $stmt->close();

    $stmt = $mysqli->prepare("update user set user_name = ? where user_id = ?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
     }
    $stmt->bind_param("si", $newUsername, $user_id);
    if($stmt->execute()){
      echo "Change Username Successfully";
      printf('<p><a href="mainPage.html">Return to Homepage</a></p>');
    };
    $stmt->close();
	  } else {
			echo "Error Username and Password";
      printf('<p><a href="mainPage.html">Return to Homepage</a></p>');
	  }
?>
</body>
</html>
