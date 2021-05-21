<?php

include 'connectMySqlDB.php';

$statement = $conn->prepare("INSERT INTO patient (firstname, lastname, email,
                     SSN, DOB, stnum, stname, zip, city, state, areacode, 
                     phone, lon, lat, preexisting_conditions, 
                     FirstResponder, EssentialWorker, password, maxDistance, priority)
					VALUES (:firstname, :lastname, :email,
                     :SSN, :DOB, :stnum, :stname, :zip, :city, :state, :areacode, 
                     :phone, :lon, :lat, :preexisting_conditions,:FirstResponder,
                     :EssentialWorker,:password, :maxDistance, :priority)");
$statement->bindParam(':firstname', $firstname);
$statement->bindParam(':lastname', $lastname);
$statement->bindParam(':email', $email);
$statement->bindParam(':SSN', $SSN);
$statement->bindParam(':DOB', $DOB);
$statement->bindParam(':stnum', $stnum);
$statement->bindParam(':stname', $stname);
$statement->bindParam(':zip', $zip);
$statement->bindParam(':city', $city);
$statement->bindParam(':state', $state);
$statement->bindParam(':areacode', $areacode);
$statement->bindParam(':phone', $phone);
$statement->bindParam(':lon', $lon);
$statement->bindParam(':lat', $lat);
$statement->bindParam(':preexisting_conditions', $preexisting_conditions);
$statement->bindParam(':FirstResponder', $FirstResponder);
$statement->bindParam(':EssentialWorker', $EssentialWorker);
$statement->bindParam(':password', $password);
$statement->bindParam(':maxDistance', $maxDistance);
$statement->bindParam(':priority', $priority);

$firstname = htmlspecialchars($_POST['firstname']);
$lastname = htmlspecialchars($_POST['lastname']);
$email = htmlspecialchars($_POST['email']);
$SSN = htmlspecialchars($_POST['SSN']);
$DOB = htmlspecialchars($_POST['DOB']);
$stnum = htmlspecialchars($_POST['stnum']);
$stname = htmlspecialchars($_POST['stname']);
$zip = htmlspecialchars($_POST['zip']);
$city = htmlspecialchars($_POST['city']);
$state = htmlspecialchars($_POST['state']);
$areacode = htmlspecialchars($_POST['areacode']);
$phone = htmlspecialchars($_POST['phone']);
// hardcode the log and lat temporarily
// $lon = $_POST['long'];
// $lat = $_POST['lat'];

require 'vendor/autoload.php';
use Geocoder\Query\GeocodeQuery;
use Geocoder\Query\ReverseQuery;

$httpClient = new \Http\Adapter\Guzzle6\Client();
$provider = new \Geocoder\Provider\GoogleMaps\GoogleMaps($httpClient, null, 'AIzaSyBzPuWxNzn8BkKIS5GK9QxAZ0Q554fnWF0');
$geocoder = new \Geocoder\StatefulGeocoder($provider, 'en');

$result = $geocoder->geocodeQuery(GeocodeQuery::create($stnum." ". $stname. ", ".$city.", ".$state));
$lat = $result->first()->getCoordinates()->getLatitude();
$lon = $result->first()->getCoordinates()->getLongitude();;
$password = md5($_POST['password']);

$preexisting_conditions = "0";
if ($_POST['preexisting_conditions']== "1") {
	$preexisting_conditions = $_POST['preexisting_conditions'];
}
$EssentialWorker = "0";
if ($_POST['EssentialWorker']== "1") {
	$EssentialWorker = $_POST['EssentialWorker'];
}
$FirstResponder = "0";
if ($_POST['FirstResponder']== "1") {
	$FirstResponder = $_POST['FirstResponder'];
}
$maxDistance = 50;
if ($_POST['maxDistance'] != Null) {
	$maxDistance = $_POST['maxDistance'];
}

// Set priority
$priority = 7;
$date1=date_create($DOB);
$date2=date_create(date("Y-m-d"));
$diff = date_diff($date1, $date2);
$years = intval($diff->format("%y"));
if ($FirstResponder == "1") {
	$priority = 1;
} else if ($EssentialWorker == "1") {
	$priority = 2;
} else if ($preexisting_conditions == "1") {
	$priority = 3;
} else if ($years >= 65 && $priority > 4) {
	$priority = 4;
} else if ($years >= 55 && $priority > 5) {
	$priority = 5;
} else if ($years >= 45 && $priority > 6) {
	$priority = 6;
}

$statement->execute();


echo "Sign up succesfully";
echo '<script>window.location.href = "PatientLogin.html";</script>';