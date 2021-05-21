<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
if(session_status() !== PHP_SESSION_ACTIVE) session_start();
include 'connectMySqlDB.php';
$password1 = htmlspecialchars($_POST['password1']);
$password2 = htmlspecialchars($_POST['password2']);

if ($password1 == $password2) {
	if ($_SESSION['identity'] == 1) {
		$stmt = $conn->prepare("
		UPDATE provider
		SET password = :password
		WHERE prov_id = :prov_id;
		");
		$stmt -> bindParam(':prov_id', $prov_id);
    	$prov_id = $_SESSION['prov_id'];
    	$stmt -> bindParam(':password', md5($password1));
    	$stmt -> execute();
	} else {
		$stmt = $conn->prepare("
		UPDATE patient
		SET password = :password
		WHERE pat_id = :pat_id;
		");
		$stmt -> bindParam(':pat_id', $pat_id);
    	$pat_id = $_SESSION['pat_id'];
    	$stmt -> bindParam(':password', md5($password1));
    	$stmt -> execute();
	}
	echo '<script>window.location.href = "logout.php";</script>';
}