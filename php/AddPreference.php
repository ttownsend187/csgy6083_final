<?php
if(session_status() !== PHP_SESSION_ACTIVE) session_start();
error_log(print_r($_SESSION['pat_id'], TRUE));
include 'connectMySqlDB.php';

$weekdayMap = array();
$weekdayMap['Monday'] = 0;
$weekdayMap['Tuesday'] = 1;
$weekdayMap['Wednesday'] = 2;
$weekdayMap['Thursday'] = 3;
$weekdayMap['Friday'] = 4;
$weekdayMap['Saturday'] = 5;
$weekdayMap['Sunday'] = 6;


//$statement = $conn->prepare("
//INSERT INTO Calendar ( day, starttime, endtime)
//VALUES (:day, :starttime, :endtime)
//");
//$statement -> execute();
//$last_id = $conn->lastInsertId();

$statement = $conn->prepare("
INSERT INTO PatientPreference ( pat_id, cid) 
VALUES (:pat_id, (Select cid from calendar where day = :day and starttime = :starttime ))
");
$statement->bindParam(':day', $day);
$statement->bindParam(':starttime', $starttime);
//$statement->bindParam(':endtime', $endtime);
$day = $weekdayMap[$_POST['day']];
$starttime = $_POST['starttime'];
//$endtime = $_POST['endtime'];
$statement->bindParam(':pat_id', $pat_id);
//$statement->bindParam(':cid', $last_id);
$pat_id = $_SESSION['pat_id'];
$statement -> execute();
