<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
if(session_status() !== PHP_SESSION_ACTIVE) session_start();

error_log(print_r($_SESSION['pat_id'], TRUE));
include 'connectMySqlDB.php';

$statement = $conn->prepare("
	UPDATE Patient
	SET maxDistance = :maxDistance
	WHERE pat_id = :pat_id;
");

$statement->bindParam(':maxDistance', $maxDistance);
$statement->bindParam(':pat_id', $pat_id);
$pat_id = $_SESSION['pat_id'];
$maxDistance = $_POST['maxDistance'];
error_log(print_r($_SESSION['pat_id'], TRUE));

$statement -> execute();
echo '<script>window.location.href = "Profile.php";</script>';