<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
include 'base.php';
include 'connectMySqlDB.php';
session_start();
?>
</br>
<div class="container">
    <h5 class="display-5">Information</h5>
<?php
if ($_SESSION['identity'] == 0) {
    echo "Identity: Patient</br>";
    $stmt = $conn->prepare("SELECT * FROM Patient WHERE pat_id = :pat_id");
    $stmt -> bindParam(':pat_id', $pat_id);
    $pat_id = $_SESSION['pat_id'];
    $stmt -> execute();
    $data = $stmt->fetchAll();
    $isPreE = "No";
    $isFirst = "No";
    $isEssential = "No";

    for($i = 0; $i < count($data); $i++) {
        if ($data[$i]['preexisting_conditions'] == 1) {
            $isPreE = "Yes";
        }
        if ($data[$i]['FirstResponder'] == 1) {
            $isFirst = "Yes";
        }
        if ($data[$i]['EssentialWorker'] == 1) {
            $isEssential = "Yes";
        }
        echo "Name: ".$data[$i]['firstname']." ".$data[$i]['lastname']."</br>";
        echo "Email: ".$data[$i]['email']."</br>";
        echo "Address: ".$data[$i]['stnum']." ".$data[$i]['stname'].", ".$data[$i]['city'].", ".$data[$i]['state'].", ".$data[$i]['zip']."</br>";
        echo "Phone: ".$data[$i]['areacode']."-".$data[$i]['phone']."</br>";
        echo "Max Distance: ".$data[$i]['maxDistance']." miles"."</br>";
        echo "Have Preexisting Conditions: ".$isPreE."</br>";
        echo "Is First Responder: ".$isFirst."</br>";
        echo "Is Essential Worker: ".$isEssential."</br>";
        echo "
         <p>
                 <br>
             <form id='form' action='setMaxDistance.php' method='post'>
               <label for ='maxDistance'>Max Distance</label>
               <select id = 'maxDistance' name = 'maxDistance' datatype='int'>
                 <option></option>
                 <option value='10'>10</option>
                 <option value='15'>15</option>
                 <option value='20'>20</option>
                 <option value='25'>25</option>
                 <option value='30'>30</option>
                 <option value='35'>35</option>
                 <option value='40'>40</option>
                 <option value='45'>45</option>
                 <option value='50'>50</option>
               </select>
             </p>
             <button class='btn btn-primary' type='submit' id='submit'> Reset </button>
         </form>
         
         ";
    }
}
if ($_SESSION['identity'] == 1) {
    echo "Identity: Provider</br>";
    $stmt = $conn->prepare("SELECT * FROM Provider WHERE prov_id = :prov_id");
    $stmt -> bindParam(':prov_id', $prov_id);
    $prov_id = $_SESSION['prov_id'];
    $stmt -> execute();
    $data = $stmt->fetchAll();
    for($i = 0; $i < count($data); $i++) {
        echo "Name: ".$data[$i]['name']."</br>";
        echo "Type: ".$data[$i]['providerType']."</br>";
        echo "Email: ".$data[$i]['email']."</br>";
        echo "Address: ".$data[$i]['stnum']." ".$data[$i]['stname'].", ".$data[$i]['city'].", ".$data[$i]['state'].", ".$data[$i]['zip']."</br>";
        echo "Phone: ".$data[$i]['areacode']."-".$data[$i]['phone']."</br>";
    }
}
?>
</br>
<h5 class="display-5">Reset the password</h5>
<form action ='ChangePassword.php' method="post" id="form">
    <div class="mb-3" id="name">
        <label for="password1" class="form-label">New Password</label>
        <input type="text" class="form-control" name="password1">
    </div>

    <div class="mb-3" id="providerType">
        <label for="password2" class="form-label">Confirm Password</label>
        <input type="text" class="form-control" name="password2">
    </div>
    <!-- Submit-->
    <button class="btn btn-block btn-primary" type="submit">Reset</button>

</div>