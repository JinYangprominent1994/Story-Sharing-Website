<!DOCTYPE html>
<html lang="en-GB">
<head>
  <meta charset = "utf-8">
	<title>Delete Personal Comment</title>
  <link href = "CSS/phpStyle.css" rel = "stylesheet" type = "text/css">
</head>
<body>

<?php

session_start();

$user_name = $_POST['username']; // Get user's username

if (!isset($_SESSION['user_id'])){ // If user visit website without login
  echo "Please log in first";
  printf('<p><a href="login.html">Return to login page</a></p>'); // User has to login to delete all comments
  exit;
}

if (empty($_POST['username'])){ // If users do not input a username, error
  echo "Null Username";
  printf('<p><a href="deletePersonalComment.html">Return to Delete Comment Page</a></p>');
  exit;
}

if (empty($_POST['password'])){ // If users do not input a password,error
  echo "Null Password";
  printf('<p><a href="deletePersonalComment.html">Return to Delete Comment Page</a></p>');
  exit;
}

$cnt=1;
require 'database.php';

$stmt = $mysqli->prepare("select user_id, user_password from user where user_name = ?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('s', $user_name);
$stmt->execute();
$stmt->bind_result($user_id, $user_password); // Get user's user_id and user_password
$stmt->fetch();
$stmt->close();

if($cnt == 1 && password_verify($_POST['password'],$user_password)){ // Compare the submitted password to the actual password hash
  $stmt = $mysqli->prepare("delete from comment where comment_author_id = ?");
  $stmt->bind_param('i', $user_id);
  if(!$stmt){
  	printf("Query Prep Failed: %s\n", $mysqli->error); // Delete this user's all comments
  	exit;
  }
  if($stmt->execute()){
    $stmt->close();
    echo "Delete All Comments Successfully";
    printf('<p><a href="mainPage.html">Return to Homepage</a></p>');
    exit;
  }

} else {
		echo "Error Username and Password"; // Login failed
    printf('<p><a href="deletePersonalComment.html">Delete All Comments Again</a></p>');
	 }

?>

</body>
</html>
