<?php
require_once('functions.php');
//if session stuff isn't set, set up the arrays, so no undefined index appears
if (!isset($_SESSION['error']['login'])){
	$_SESSION['error']['login'] = [];
}
if (!isset($_SESSION['error']['registration'])) {
	$_SESSION['error']['registration'] = [];
}
if (!isset($_SESSION['success'])) {
	$_SESSION['success'] = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Quick Photo</title>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<h1>Quick Photo <small>Throw up some quick photos!</small></h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4 col-md-offset-2">
				<h3>Login</h3>
<?php
				//show login errors
				if (count($_SESSION['error']['login']) > 0){
					foreach ($_SESSION['error']['login'] as $value) {
						?>
						<h4 class="bg-danger"><?= $value ?></h4>
<?php				}
				}
				?>
				<form role="form" action="login_pcs.php" method="post">
					<div class="form-group">
						<label for="user">Username:</label>
						<input type="text" name="user" placeholder="Username..." class="form-control">
					</div>
					<div class="form-group">
						<label for="password">Password:</label>
						<input type="password" name="password" placeholder="Password..." class="form-control">
					</div>
					<button class="btn btn-lg btn-success btn-block" type="submit">Login</button>
				</form>
			</div>
			<div class="col-md-4">
				<h3>Register</h3>
<?php
				//show registration errors
				if (count($_SESSION['error']['registration']) > 0) {
					foreach ($_SESSION['error']['registration'] as $value) {
						?>
						<h4 class="bg-danger"><?= $value ?></h4>
<?php				}
				}
				//show registration success
				if (count($_SESSION['success']) > 0) {
					foreach ($_SESSION['success'] as $value) {
						?>
						<h4 class="bg-success"><?= $value ?></h4>
<?php
					}
				}
?>
				<form role="form" action="register_pcs.php" method="post">
					<div class="form-group">
						<label for="user">Username:</label>
						<input type="text" name="user" placeholder="Username..." class="form-control">
					</div>
					<div class="form-group">
						<label for="password">Password:</label>
						<input type="password" name="password" placeholder="Password..." class="form-control">
					</div>
					<div class="form-group">
						<label for="confirm">Confirm Password:</label>
						<input type="password" name="confirm" placeholder="Confirm Password..." class="form-control">
					</div>
					<button class="btn btn-lg btn-block btn-primary">Register</button>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
<?php
//reset messages
$_SESSION['error']['login'] = [];
$_SESSION['error']['registration'] = [];
$_SESSION['success'] = [];
?>