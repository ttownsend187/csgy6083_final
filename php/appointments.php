<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
include('base.php');

if(session_status() !== PHP_SESSION_ACTIVE) session_start();
include 'connectMySqlDB.php';
?>
<div class="container">
	<div>
		<form id="form" action="appointments.php" method="post">
			<select class="form-select" aria-label="Default select example" id="filter" name="filter" onchange="this.form.submit()">
			  <option selected value = "0">Please Select a Category</option>
			  <option value="Accepted">Upcoming Appointments</option>
			  <option value="Pending">Pending Appointments</option>
			  <option value="Declined">Declined Appointments</option>
			  <option value="Completed">Completed Appointments</option>
			  <option value="Missed">Missed Appointments</option>
                <option value="Cancelled">Cancelled Appointments</option>
			</select>
		</form>

    </div>

	<div class='col-lg-12'>
		<div id='appointments_list' class='row'>

<?php
if(isset($_POST['filter'])) {
	
	echo "
	<script type='text/javascript'>
		document.getElementById('filter').value = '".$_POST['filter']."';
	</script>
	";
}

// Patient appointments page
if ($_SESSION['identity'] == 0) {
	$statement = $conn->prepare("SELECT aid, prov_id, apptdate, appttime, status FROM AppointmentAvailable WHERE pat_id = :pat_id;");

    $statement->bindParam(':pat_id', $pat_id);
    $pat_id = $_SESSION['pat_id'];

    $statement -> execute();
    $data = $statement->fetchAll();
    $appt = array();
    for($i = 0; $i < count($data); $i++) {
    	if ($data[$i]['status'] == $_POST['filter']) {
    		array_push($appt, $data[$i]);
    	}
    }
    for ($i = 0; $i < count($appt); $i++) {
    	$provider = getProvider($conn, $appt[$i]['prov_id']);
    	$display = "
				<div class = 'col-sm-6 col-xl-4 mb-5 hover-animate'>
					<div class='card h-100 border-0 shadow'>
					  <img src='https://www.pbahealth.com/wp-content/uploads/2016/12/city_street_pharmacy_illustration.jpg' class='card-img-top' alt='...''>
					  <div class='card-body'>
					  <a href='provider_profile.php?".$provider['prov_id'];
		$display = $display."' class='card-link'>".$provider['name']."</a><p class='card-text'>Date: ".$appt[$i]['apptdate']."<br>Time: ".$appt[$i]['appttime']."-".getEndTime($appt[$i]['appttime'])."<br>Address: ".$provider['stnum']." ".$provider['stname'].", ".$provider['city'].", ".$provider['state']."</p>";
		if ($_POST['filter'] == "Pending") {
			$display = $display."<a href='accept_appointment.php?".$appt[$i]['aid']. "' class='card-link'>Accept</a>
								<a href='decline_appointment.php?".$appt[$i]['aid']. "' class='card-link'>Decline</a>";
		} else if ($_POST['filter'] == "Accepted") {
			$display = $display."<p style='color:green;'>Accepted</p>";
            $display = $display."<a href='cancel_appointment.php?".$appt[$i]['aid']. "' class='card-link'>Cancel</a>";
		} else {
			$display = $display."<p style='color:gray;'>".$_POST['filter']."</p>";
		}
		$display = $display."</div>
				  			</div>
							</div>";
    	echo $display;
    	;
    }
} else {
	$statement = $conn->prepare("SELECT aid, pat_id, apptdate, appttime, status FROM AppointmentAvailable WHERE prov_id = :prov_id;");

    $statement->bindParam(':prov_id', $prov_id);
    $prov_id = $_SESSION['prov_id'];

    $statement -> execute();
    $data = $statement->fetchAll();

    $appt = array();
    for($i = 0; $i < count($data); $i++) {
    	if ($data[$i]['status'] == $_POST['filter']) {
    		array_push($appt, $data[$i]);
    	}
    }
    for ($i = 0; $i < count($appt); $i++) {

    	$patient = getPatient($conn, $appt[$i]['pat_id']);
    	$display = "
					<div class = 'col-sm-6 col-xl-4 mb-5 hover-animate'>
						<div class='card h-100 border-0 shadow'>
						  <div class='card-body'>
						    <p class='card-text'>Name: ".$patient['firstname']."<br> Date: ".$appt[$i]['apptdate']."<br> Time: ".$appt[$i]['appttime']."-".getEndTime($appt[$i]['appttime'])."</p>";
		if ($_POST['filter'] == "Accepted") {
			$display = $display."<a href='confirm_appointment.php?".$appt[$i]['aid']."'class='card-link'>Compeleted</a>
			    				<a href='missed_appointment.php?".$appt[$i]['aid']."'class='card-link'>Missed</a>";
		} else if ($_POST['filter'] == "Compeleted") {
			$display = $display."<p style='color:green;'>Compeleted</p>";
		} else {
			$display = $display."<p style='color:gray;'>".$_POST['filter']."</p>";
		}
		$display = $display."</div>
				  			</div>
							</div>";
    	echo $display;
    	;
    }
}
?>
			</div>
</div>
</div>
