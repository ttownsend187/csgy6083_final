<?php

$pw= '';
$user = 'root';
$host = '127.0.0.1';
$dbname = 'covidVaccination';

$conn = mysqli_connect("$host", "$user", "$pw", "$dbname" );
if (!$conn) {
    echo "Failed to connect to MySQL:".mysqli_connect_error();
};
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';



$sql = "SELECT * FROM emailQueue WHERE executed = 'N'";
//$stmt = $conn->prepare($sql);
$result = $conn->query($sql);

$mail = new \PHPMailer\PHPMailer\PHPMailer(true);

if($result->num_rows >0) {


//    echo !extension_loaded('openssl')?"Not Available":"Available";
    echo "\n";
    $mail -> isSMTP();
//    $mail->SMTPDebug= 3;
    $mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
    $mail->SMTPAuth = true; // enable SMTP authentication
//    $mail->SMTPSecure = "tls"; // sets the prefix to the server
    $mail->Port = 587; // set the SMTP port for the GMAIL server
    $mail->SMTPKeepAlive =true;

    $mail->Mailer ="smtp";
    $mail->Username = 'trevorunittester@gmail.com'; // GMAIL username
    $mail->Password = "#TestPW01"; // GMAIL password


    $mail-> SetFrom('trevorunittester@gmail.com', 'Vaccination Administrator');
    $mail -> Subject = 'New Appointment Offered';
    $mail->WordWrap = 50;

    while ($row = $result->fetch_array()) {
        $body = " \n "
            . "Hello " . $row['firstname'] . "  "
            . $row['lastname'] .", ". " \n " . "\n"
            . "You have been offered a new appointment in your patient portal with " . $row['prov_name'] .
            " at " . $row['appttime'] . " on " . $row['apptdate'] . " \n" .
            "Please be sure to accept the appointment within the next seven days or it will be automatically declined.";
        $to = $row['email'];

        $mail -> addAddress($to);
        $mail -> Body = $body;
        $sql_update = "UPDATE emailQueue Set executed  = 'Y' where emailQueue.eid =". $row['eid'];
        $conn->query($sql_update);

        try{
            $mail->send();
            echo 'Mail sent';
        }catch(Exception $e)
        {
            echo 'message couldn not be sent';
            echo 'mailer error: '.$mail->ErrorInfo;
        }


    }

}

