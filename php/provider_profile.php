<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
include 'base.php';
include 'connectMySqlDB.php';
session_start();
?>
</br>
<div class="container">
    <h5>Provider Profile</h5>
<?php
    $stmt = $conn->prepare("SELECT * FROM Provider WHERE prov_id = :prov_id");
    $stmt -> bindParam(':prov_id', $prov_id);
    $prov_id = $_SERVER['QUERY_STRING'];
    $stmt -> execute();
    $data = $stmt->fetchAll();
    for($i = 0; $i < count($data); $i++) {
        echo "Name: ".$data[$i]['name']."</br>";
        echo "Type: ".$data[$i]['providerType']."</br>";
        echo "Email: ".$data[$i]['email']."</br>";
        echo "Address: ".$data[$i]['stnum']." ".$data[$i]['stname'].", ".$data[$i]['city'].", ".$data[$i]['state'].", ".$data[$i]['zip']."</br>";
        echo "Phone: ".$data[$i]['areacode']."-".$data[$i]['phone']."</br>";
    }
?>