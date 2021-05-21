<?php
if(session_status() !== PHP_SESSION_ACTIVE) session_start();

$datetime = $_POST['datetime'];
$datetime_array = explode(" ", $datetime);
include 'connectMySqlDB.php';



$statement = $conn->prepare("
INSERT INTO AppointmentAvailable ( prov_id, apptdate, appttime, status) 
VALUES (:prov_id, :apptdate, :appttime, 'Available')
");
$statement->bindParam(':prov_id', $prov_id);
$statement->bindParam(':apptdate', $apptdate);
$statement->bindParam(':appttime', $appttime);
$prov_id = $_SESSION['prov_id'];
$apptdate = $datetime_array[0];
$appttime = $datetime_array[1];

$statement -> execute();