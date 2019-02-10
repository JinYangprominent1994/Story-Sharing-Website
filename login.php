<?php
session_start();

require 'database.php';

if (empty($_POST['username'])){ // If users do not input a username, error
  echo "Null Username";
  printf('<p><a href="login.html">Return to Login Page</a></p>');
	exit;
}

if (empty($_POST['password'])){ // If user do not inout a password, error
  echo "Null Password";
  printf('<p><a href="login.html">Return to Login Page</a></p>');
	exit;
}

$user_name = $_POST['username'];

$cnt=1;
$stmt = $mysqli->prepare("select user_id, user_password from user where user_name = ?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('s', $user_name);
$stmt->execute();
$stmt->bind_result($user_id, $user_password);
$stmt->fetch();
$stmt->close();

	$password = $_POST['password'];

	if( $cnt == 1 && password_verify($_POST['password'],$user_password)){ // Compare the submitted password to the actual password hash
		  $_SESSION['user_id'] = $user_id; // Transfer user_id to session
		  $_SESSION['user_name'] = $_POST['username']; // Transfer user_name to session
		  $_SESSION['token'] = substr(md5(rand()), 0, 10); // Create Token to prevent CSRF attacks

			echo "Redirecting...";
		  header("Location: mainPage.html");
		  exit;
	  } else {
			echo "Error Username and Password";  // Login failed
			printf('<p><a href="login.html">Return to Login Page</a></p>');
	  }

?>
