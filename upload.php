<?php
require_once('functions.php');

if (isset($_FILES['pic']['name'])) {
	//upload picture
	move_uploaded_file($_FILES['pic']['tmp_name'], 'upload/'. $_FILES['pic']['name']);
	$data['name'] = "upload" . "/" . $_FILES['pic']['name'];
	$pic = new Picture();
	$pic->user_id = $_SESSION['user']['id'];
	$pic->filename = $data['name'];
	$pic->save($con);
	echo json_encode($data);
}

?>