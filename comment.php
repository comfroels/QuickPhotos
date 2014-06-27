<?php
require('functions.php');

if (isset($_POST)) {
	//create instance of picture and add comment, return json
	$pic = new Picture();
	$pic->id = $_POST['id'];
	$pic->addComment($con,mysqli_real_escape_string($con,$_POST['comment']),$_SESSION['user']['id']);
	$postName = getUsername($con,$_SESSION['user']['id']);
	$data['content'] = $_POST['comment'];
	$data['name'] = $postName;
	$data['pic'] = $pic->id;
	echo json_encode($data);
}


?>