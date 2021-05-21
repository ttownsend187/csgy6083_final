<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);

include 'connectMySqlDB.php';

$statement = $conn->prepare("INSERT into Provider (name, providerType, email, stnum, stname, zip, city, state, areacode, phone, lon, lat, password)
VALUES (:name, :providerType, :email, :stnum, :stname, :zip, :city, :state, :areacode, :phone, :lon, :lat, :password)");
$statement->bindParam(':name', $name);
$statement->bindParam(':providerType', $providerType);
$statement->bindParam(':email', $email);
$statement->bindParam(':stnum', $stnum);
$statement->bindParam(':stname', $stname);
$statement->bindParam(':zip', $zip);
$statement->bindParam(':city', $city);
$statement->bindParam(':state', $state);
$statement->bindParam(':areacode', $areacode);
$statement->bindParam(':phone', $phone);
$statement->bindParam(':lon', $lon);
$statement->bindParam(':lat', $lat);
$statement->bindParam(':password', $password);


$name = htmlspecialchars($_POST['name']);
$providerType = htmlspecialchars($_POST['providerType']);
$email = htmlspecialchars($_POST['email']);
$stnum = htmlspecialchars($_POST['stnum']);
$stname = htmlspecialchars($_POST['stname']);
$zip = htmlspecialchars($_POST['zip']);
$city = htmlspecialchars($_POST['city']);
$state = htmlspecialchars($_POST['state']);
$areacode = htmlspecialchars($_POST['areacode']);
$phone = htmlspecialchars($_POST['phone']);


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


$statement->execute();

echo "Sign up succesfully";
echo '<script>window.location.href = "providerLogin.html";</script>';