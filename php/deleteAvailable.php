<?php
if(session_status() !== PHP_SESSION_ACTIVE) session_start();

$aid = $_POST['aid'];
error_log(print_r($aid, TRUE));
include 'connectMySqlDB.php';


$stmt = $conn->prepare("
SELECT * FROM AppointmentAvailable WHERE aid = :aid
");
$stmt->bindParam(':aid', $aid);
$stmt -> execute();

$data = $stmt->fetchAll();
if (count($data) > 0) {
	$appt = $data[0];
	if($appt['status'] != 'Available') {
		$res['stat'] = "Invalid";
		error_log(print_r($res, TRUE));
		$res = json_encode($res);
		
		echo $res;
	} else {
		$statement = $conn->prepare("
		DELETE FROM AppointmentAvailable WHERE aid = :aid
		");
		$statement->bindParam(':aid', $aid);

		$statement -> execute();
		$res['stat'] = "Success";
		error_log(print_r($res, TRUE));
		$res = json_encode($res);
		error_log(print_r($res, TRUE));
		echo $res;
	}
}
?>
