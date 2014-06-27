<?php
session_start();

define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','nate1990');
define('DB_DATABASE','quick_photo');
//database connection
$con = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_DATABASE);

if (mysqli_connect_errno()) {
	echo "Connection to the database failed: ";
	echo mysqli_connect_error();
	exit();
}
//return a username based off of user id
function getUsername($con,$id) {
	$query = "SELECT username FROM users WHERE id = {$id}";
	$result = mysqli_query($con,$query);
	$row = mysqli_fetch_assoc($result);
	return $row['username'];
}
//return list of users
function getUsers($con) {
	$query = "SELECT * FROM users";
	$result = mysqli_query($con,$query);
	$results = array();
	while ($row = mysqli_fetch_assoc($result)) {
		$results[] = $row;
	}
	return $results;
}
//picture class
class Picture {
	public $id;
	public $user_id;
	public $filename;
	//get comments for certain picture
	public function getComments($con){
		$query = "SELECT a.content as content,b.username as username FROM comments as a LEFT JOIN users as b ON a.user_id = b.id WHERE picture_id = {$this->id}";
		$result = mysqli_query($con,$query);
		$results = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$results[] = $row;
		}
		return $results;
	}
	//save picture to database
	public function save($con) {
		$query = "INSERT INTO pictures (user_id,filename) VALUES ({$this->user_id},'{$this->filename}')";
		mysqli_query($con,$query);
	}
	//add comment to a picture
	public function addComment($con,$content,$user){
		$query = "INSERT INTO comments (picture_id,user_id,content) VALUES ({$this->id},{$user},'{$content}')";
		mysqli_query($con,$query);
	}
	//get photos for a certain user
	function getPhotos($con) {
		$query = "SELECT * FROM pictures WHERE user_id = {$this->user_id}";
		$result = mysqli_query($con,$query);
		$results = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$results[] = $row;
		}
		return $results;
	}
}

?>