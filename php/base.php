<?php
if(session_status() !== PHP_SESSION_ACTIVE) session_start();
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
?>

<!-- Bootstrap CSS -->
<header>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous">
    </script>
</header>



<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <div>
      <a class="navbar-brand" href="index.php">Vaccination</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav ms-auto navbar-right">
		  <li class="nav-item" id = "login"><a class="nav-link" href="PatientLogin.html">Log in</a></li>
		  <li class="nav-item" id = "register"><a class="nav-link" href="PatientRegistration.html">Register</a></li>
		  <li class="nav-item" id = "appointments" style="display: none"><a class="nav-link" href="Appointments.php">Appointments</a></li>
		  <li class="nav-item" id = "preference_time" style="display: none"><a class="nav-link" href="Preference.php">Preference</a></li>
		  <li class="nav-item" id = "available_time" style="display: none"><a class="nav-link" href="Available.php">Available Time</a></li>
		  <li class="nav-item" id = "logout" style="display: none"><a class="nav-link" href="logout.php">Log out</a></li>
		  <li class="nav-item" id = "profile" style="display: none"><a id="username" class="nav-link" href="profile.php" style="color:#38b5eb; font-weight:bold;">CVS</a></li>
      </ul>
    </div>
  </div>

</nav>

<?php
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  	if ($_SESSION['identity'] == 0) {
  		echo '<script type="text/javascript"> 
  			document.getElementById("available_time").style.display = "none"
			document.getElementById("preference_time").style.display = "block"
			</script>';
  	} else {
  		echo '<script type="text/javascript"> 
  			document.getElementById("available_time").style.display = "block"
			document.getElementById("preference_time").style.display = "none"
			</script>';
  	}
    echo '<script type="text/javascript">
      document.getElementById("login").style.display = "none";
      document.getElementById("register").style.display = "none";
      document.getElementById("appointments").style.display = "block";
      document.getElementById("logout").style.display = "block";
      document.getElementById("profile").style.display = "block";
      document.getElementById("username").innerHTML = "'.$_SESSION['username'].'"; </script>';
  } else {
      echo '<script type="text/javascript">
      document.getElementById("login").style.display = "block";
      document.getElementById("register").style.display = "block";
      document.getElementById("appointments").style.display = "none";
      document.getElementById("available_time").style.display = "none";
      document.getElementById("logout").style.display = "none";
      document.getElementById("profile").style.display = "none";
    </script>';
  }
?>

<?php

include 'connectMySqlDB.php';

function getEndTime($startTime) {
	$endTime = array();
	$endTime['08:00:00'] = '12:00:00';
	$endTime['12:00:00'] = '16:00:00';
	$endTime['16:00:00'] = '20:00:00';
	return $endTime[$startTime];
}

function getPatient($conn, $patId) {

	$pat_id = intval($patId);
	$stmt = $conn->prepare("SELECT * FROM Patient WHERE pat_id = :pat_id;");
    $stmt -> bindParam(':pat_id', $pat_id);
    
    $stmt -> execute();
    $data = $stmt->fetchAll();
    if (count($data) > 0) {
    	return $data[0];
    }
    return Null;
}

function getProvider($conn, $provId) {

	$prov_id = intval($provId);
	$stmt = $conn->prepare("SELECT * FROM Provider WHERE prov_id = :prov_id;");
    $stmt -> bindParam(':prov_id', $prov_id);
    
    $stmt -> execute();
    $data = $stmt->fetchAll();
    if (count($data) > 0) {
    	return $data[0];
    }
    return Null;
}

?>