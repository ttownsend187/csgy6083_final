<?php
if(session_status() !== PHP_SESSION_ACTIVE) session_start();

$cid = $_POST['cid'];
error_log(print_r($cid, TRUE));
include 'connectMySqlDB.php';



$statement = $conn->prepare("
DELETE FROM PatientPreference WHERE cid = :cid
");
$statement->bindParam(':cid', $cid);

$statement -> execute();