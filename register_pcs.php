<?php
require_once('functions.php');


if (isset($_POST)) {
	//check if user exists, check if passwords match and at least 8 characters,redirect to landing page
	$_SESSION['error']['registration'] = [];
	$query = "SELECT username FROM users";
	$result = mysqli_query($con, $query);
	$used = false;
	while ($row = mysqli_fetch_assoc($result)) {
		if ($_POST['user'] == $row['username']) {
			$used = true;
		}
	}
	if ($used) {
		$_SESSION['error']['registration'][] = "That username is already taken!";
	}
	if ($_POST['password'] != $_POST['confirm']) {
		$_SESSION['error']['registration'][] = "Those passwords don't match!";
	}
	if (strlen($_POST['password']) < 8)
	{
		$_SESSION['error']['registration'][] = "The password must be at least 8 characters!";
	}
	if (count($_SESSION['error']['registration']) > 0) {
		header('Location: index.php');
	}
	else {
		$user = mysqli_real_escape_string($con,$_POST['user']);
		$password = md5(mysqli_real_escape_string($con,$_POST['password']));
		$query = "INSERT INTO users (username, password) VALUES ('{$user}','{$password}')";
		$result = mysqli_query($con,$query);
		$_SESSION['success'][] = "You have successfully registered!";
		header('Location: index.php');
	}




}

?>