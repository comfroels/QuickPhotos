<?php 
require_once('functions.php');
//if get request get pictures for that user's page
if (isset($_GET['id'])) {
	$pic = new Picture();
	$pic->user_id = $_GET['id'];	
	$result = $pic->getPhotos($con);
}
//if not a get, get session user's page
else {
	$pic = new Picture();
	$pic->user_id = $_SESSION['user']['id'];
	$result = $pic->getPhotos($con);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Quick Photo</title>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
	<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<script>
		$(document).ready(function(e){
			//ajax call for submitting an image and adding to the page
			$('.uploadImage').on('submit',(function(e){
				
				var formData = new FormData(this);

				$.ajax({
					type:'POST',
					url:$(this).attr('action'),
					data:formData,
					cache:false,
					contentType:false,
					processData:false,
					success:function(data){
						console.log("success!");
						var fixed = jQuery.parseJSON(data);
						console.log(fixed);
						var str = '<div class="imageSet" style="display:inline-block;"><img src="' + fixed.name + '" class="img-thumbnail" style="width:30%;"><form role="form" class="form-inline cmt" style="display:inline;" action="comment.php" method="post"><input type="hidden" name="id" value="'+ fixed.pic +'"><div class="form-group"><textarea name="comment" cols="30" rows="3" class="form-control" placeholder="Comment..."></textarea></div><button type="submit" class="btn btn-success">Post</button></form><div class="allComments" id="allComments'+ fixed.pic +'"></div></div>';
						console.log(str);
						$('#PicturesHere').append(str);
					},
					error: function(data){
						console.log("error!");
						console.log(data);
					}
				});
				return false;
			}));
		//keep comments scrolled to the bottom
		var element = $('.allComments');
		for (var i = 0; i < element.length; i++){
			element[i].scrollTop = element[i].scrollHeight;
		}
		
		});
		//ajax call to add comments
		$(document).on('submit',".cmt",function(){
				$.post(
					$(this).attr('action'),
					$(this).serialize(),
					function(data) {
						$('#allComments'+data.pic).append('<p class="insideComment"><span class="author">' + data.name + ' said: </span> ' + data.content + '</p>');
						//keep scrolled to the bottom of comments even when ajax adds
						var element = $('.allComments');
						for (var i = 0; i < element.length; i++){
							element[i].scrollTop = element[i].scrollHeight;
						}
					},
					"json"
				);
				return false;

		});
	</script>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1>Your photos <small>Check those out!</small></h1>
				<a href="logout.php"><button class="btn pull-right btn-danger">Logout</button></a>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-md-4">
<?php
				//if it's the users page, allow them to upload an image
				if (!isset($_GET['id']) || $_GET['id'] == $_SESSION['user']['id']){
?>
				<h3>Upload a picture!</h3>
				<form role="form" class="uploadImage" enctype="multipart/form-data" action="upload.php" method="post">
					<input type="hidden" name="id" value="<?= $_SESSION['user']['id'] ?>">
					<div class="form-group">
						<label for="pic">Picture File:</label>
						<input type="file" class="form-control" name="pic">
					</div>
					<button class="btn btn-primary">Upload</button>
				</form>
<?php 			} ?>
				<h4>Users</h4>
				<div class="userList">
<?php
				//get list of users and display the links
				$users = getUsers($con);
				foreach ($users as $user) {
					?>
					<p class="user"><a href="photo.php?id=<?= $user['id'] ?>"><?= $user['username'] ?></a></p>
<?php
				}
?>
				</div>
			</div>
			<div class="col-md-8" id="PicturesHere">
<?php
				//get display the pictures of the user
				foreach ($result as $row) {
					?>
					<div class="imageSet" style="display:inline-block;">
						<img src="<?= $row['filename'] ?>" class="img-thumbnail" style="width:30%;">
						<form role="form" class="form-inline cmt" style="display:inline;" action="comment.php" method="post">
							<input type="hidden" name="id" value="<?= $row['id'] ?>">
							<div class="form-group">
								<textarea name="comment" cols="30" rows="3" class="form-control" placeholder="Comment..."></textarea>
							</div>
							<button type="submit" class="btn btn-success">Post</button>
						</form>
						<div class="allComments" id="allComments<?= $row['id'] ?>">
<?php
							//get comments for the picture
							$picture = new Picture();
							$picture->id = $row['id'];
							$comments = $picture->getComments($con);
							foreach ($comments as $value) {
								?>
								<p class="insideComment"><span class="author"><?= $value['username'] ?> said: </span><?= $value['content'] ?></p>
<?php						}
?>
						</div>
					</div>
<?php			}
?>
			</div>
		</div>
	</div>
</body>
</html>