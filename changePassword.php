<!DOCTYPE html>
<html lang="en-GB">
<head>
  <meta charset = "utf-8">
	<title>Change Password</title>
  <link href = "CSS/phpStyle.css" rel = "stylesheet" type = "text/css">
</head>
<body>

<?php

session_start();

$username = $_POST['username']; // Get user's name
$password = $_POST['oldPassword']; // Get user's old password
$newPassword = $_POST['newPassword']; // Get user's new password
$newpasswordAgain = $_POST['newPasswordAgain']; // Input new password twice, make sure two new passwords match

if (!isset($_SESSION['user_id'])){ // If user visit website without logging in
  echo "Please log in first";
  header("Location: login.html"); // User has to log in to change password
  exit;
}

if (empty($_POST['username'])){ //If user do not input a username,error
  echo "Null Username";
  printf('<p><a href="changePassword.html">Return to Change Password Page</a></p>');
  exit;
}

if (empty($_POST['oldPassword'])){ // If users do not input a old password, error
  echo "Null Old Password";
  printf('<p><a href="changePassword.html">Return to Change Password Page</a></p>');
  exit;
}

if (empty($_POST['newPassword'])){ //If users do not input a new password, error
  echo "Null New Password";
  printf('<p><a href="changePassword.html">Return to Change Password Page</a></p>');
  exit;
}

if (empty($_POST['newPasswordAgain'])){ // If user do not input a new password again, error
  echo "Null New Password Again";
  printf('<p><a href="changePassword.html">Return to Change Password Page</a></p>');
  exit;
}

$cnt=1;
require 'database.php'; // Link to database

$stmt = $mysqli->prepare("select user_id, user_password from user where user_name = ?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->bind_result($user_id, $user_password); // Get user's user_id and old password
$stmt->fetch();
$stmt->close();

if( $cnt == 1 && password_verify($_POST['oldPassword'],$user_password)){ // Compare the submitted password to the actual hashed password
      if($newPassword == $newpasswordAgain){ // Login successfully
        $hashed_newPassword = password_hash($newPassword,PASSWORD_DEFAULT); //Hash the new password
        $stmt = $mysqli->prepare("update user set user_password = ? where user_id = ?");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param("ss", $hashed_newPassword, $user_id); // Save the new hashed password into database
        if($stmt->execute()){
          echo "Change Password Successfully";
          printf('<p><a href="mainPage.html">Return to Homepage</a></p>');
        };
        $stmt->close();
      } else {
        echo "Your two new passwords not match ";
        printf('<p><a href="changePassword.html">Return to Password Change Page</a></p>'); // Input new password again
      }
	  } else {
			echo "Error Username and Password";
      printf('<p><a href="mainPage.html">Return to Homepage</a></p>');
	  }
?>
</body>
</html>
