<?php
include 'connectMySqlDB.php';
$password1 = $_POST['password1'];
$password2 = $_POST['password2'];
$email = $_GET['email'];
$token = $_GET['token'];
$identity = $_GET['identity'];
//get token from db
if ($identity == 0) {
    $stmt = $conn->prepare("SELECT * from PatientToken WHERE email = :email;");
    $stmt -> bindParam(':email', $email);
    $stmt -> execute();
    $data = $stmt->fetchAll();
    $token_real = NULL;
    if (count($data) > 0) {
        $token_real = $data[0]['token'];
    }
} else {
    $stmt = $conn->prepare("SELECT * from ProviderToken WHERE email = :email;");
    $stmt -> bindParam(':email', $email);
    $stmt -> execute();
    $data = $stmt->fetchAll();
    $token_real = NULL;
    if (count($data) > 0) {
        $token_real = $data[0]['token'];
    }
}

if ($password1 == $password2 && isset($token_real) && $token == $token_real) {
    if ($identity == 1) {
        $stmt = $conn->prepare("
		UPDATE provider
		SET password = :password
		WHERE email = :email;
		");
        $stmt -> bindParam(':email', $email);
        $stmt -> bindParam(':password', md5($password1));
        $stmt -> execute();
    } else {
        $stmt = $conn->prepare("
		UPDATE patient
		SET password = :password
		WHERE email = :email;
		");
        $stmt -> bindParam(':email', $email);
        $stmt -> bindParam(':password', md5($password1));
        $stmt -> execute();
    }
}

echo '<script>window.location.href = "index.php";</script>';