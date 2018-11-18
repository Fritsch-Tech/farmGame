<?php

require_once "util/DBConnection.php";

session_start();
$_SESSION['login'] = false;


error_reporting(E_ALL ^ E_NOTICE);


if(isset($_POST['form_username'])){
	$form_username = $_POST['form_username'];

	$db = DBConnection::getConnection();
	$stmt = $db->prepare("SELECT * FROM user WHERE username = :username");
	$stmt->bindParam(':username',	$form_username);
	$stmt->execute();

	$data = $stmt->fetch(PDO::FETCH_OBJ);
	$_SESSION['username'] = $data->username;

	if(password_verify((string)$_POST['form_pw'],(string)$data->passwort)){
		$_SESSION['login'] = true;
		header('LOCATION:admin.php');
		die();
	}
}
?>

<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<title>Login</title>
</head>
<body>
	<h1>Login Klasse</h1>

	<form class="form-inline" action="login.php" method="post">
		<div class="form-group mx-sm-3 mb-2">
			<label for="inputPassword2" class="sr-only">Password</label>
			<input type="text" class="form-control" name="form_username" placeholder="Username">
			<input type="password" class="form-control" id="inputPassword2" name="form_pw" placeholder="Password">
		</div>
		<button type="submit" class="btn btn-primary mb-2">Login</button>
	</form>
</body>
</html>
