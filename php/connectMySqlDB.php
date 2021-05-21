<?php


$pw= '';
$user = 'root';
$host = 'localhost';
$dbname = 'covidVaccination';



$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pw);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// $conn = mysqli_connect("$host", "$user", "$pw", "$dbname" );
if (!$conn) {
    echo "Failed to connect to MySQL:".mysqli_connect_error();
};
