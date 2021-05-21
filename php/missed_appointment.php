<?php
if(session_status() !== PHP_SESSION_ACTIVE) session_start();

$aid = $_SERVER['QUERY_STRING'];
include 'connectMySqlDB.php';



$statement = $conn->prepare("
	UPDATE AppointmentAvailable
	SET status = 'Missed'
	WHERE aid = :aid;
");
$statement->bindParam(':aid', $aid);

$statement -> execute();
echo '<script>window.location.href = "appointments.php";</script>';