<?php
if(session_status() !== PHP_SESSION_ACTIVE) session_start();
include 'connectMySqlDB.php';

function checkLogin($conn, $email, $password) {
  $statement = $conn->prepare("SELECT pat_id, password FROM Patient WHERE email = :email;");
	$statement->bindParam(':email', $email);
	$statement -> execute();
	$data = $statement->fetchAll();
	if (count($data) == 1 && $data[0]['password'] == md5($password)) {
		$_SESSION['loggedin'] = true;
		$_SESSION['identity'] = 0;
	    $_SESSION['username'] = $email;
	    $_SESSION['pat_id'] = $data[0]['pat_id'];
	    return True;
	} else {
		return False;
	}
}

$email = $_POST['email'];
$password = $_POST['password'];
if (checkLogin($conn, $email, $password)) {
	// TODO: check user by sql
	echo '<script>window.location.href = "index.php";</script>';
} else {
	echo "Password incorrect";
	// echo '<script>window.location.href = "index.php";</script>';
}