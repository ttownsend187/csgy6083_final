<?php
if(session_status() !== PHP_SESSION_ACTIVE) session_start();
//session_start();
include 'connectMySqlDB.php';

function checkLogin($conn, $email, $password) {
    $statement = $conn->prepare("SELECT prov_id, password FROM Provider WHERE email = :email;");
    $statement->bindParam(':email', $email);
    $statement -> execute();
    $data = $statement->fetchAll();
    if (count($data) == 1 && $data[0]['password'] == md5($password)) {
        $_SESSION['loggedin'] = true;
        $_SESSION['identity'] = 1;
        $_SESSION['username'] = $email;
        $_SESSION['prov_id'] = $data[0]['prov_id']; // hardcode for testing
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