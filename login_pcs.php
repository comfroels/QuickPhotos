<?php
require_once('functions.php');

if (isset($_POST)){
	//check to see if the user exists, compare passwords, redirect to landing page if errors
	$_SESSION['error']['login'] = [];
	$notMatch = false;
	$user = mysqli_real_escape_string($con,$_POST['user']);
	$password = md5(mysqli_real_escape_string($con, $_POST['password']));
	$query = "SELECT * FROM users where username = '{$user}'";
	$result = mysqli_query($con, $query);
	if ($row = mysqli_fetch_assoc($result)) {
		if ($row['password'] == $password) {
			$_SESSION['user']['name'] = $row['username'];
			$_SESSION['user']['id'] = $row['id'];
			header('Location: photo.php');
		}
		else {
			$notMatch = true;
		}
	}
	else {
		$_SESSION['error']['login'][] = "Username/Password is incorrect!";
		header('Location: index.php');
	}
	if ($notMatch) {
		$_SESSION['error']['login'][] = "Username/Password is incorrect!";
		header('Location: index.php');
	}
}

?>