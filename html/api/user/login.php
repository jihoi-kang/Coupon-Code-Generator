<?php

/* include database and object file */
include_once '../config/database.php';
include_once '../objects/user.php';

/* Get Database Connection */
$database = new Database();
$db = $database->getConnection();

/* Get User Object */
$user = new User($db);

/* SET ID & Password Properties */
$user->id = $_POST['id'];
$user->password = $_POST['password'];

/**
 * return true => success login & register session & go to main page
 * return false => failure login & go to signin page
 */
if($user->login()){
	session_start();
	$_SESSION['id'] = $user->id;
	$_SESSION['idx'] = $user->idx;

	http_response_code(200);

	echo "<meta http-equiv=\"refresh\" content=\"0;url=/main.php\" />";
} else {
	http_response_code(503);

	echo "<meta http-equiv=\"refresh\" content=\"0;url=/signin.php\" />";
}
 
?>
