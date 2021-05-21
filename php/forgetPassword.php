<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
include 'connectMySqlDB.php';

//Load Composer's autoloader
require 'vendor/autoload.php';

//Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);
$email = $_POST['email'];
$token = md5($email).rand(10, 9999);
$identity = $_GET['identity'];

if ($identity == 0) {
    //Check if email exist
    $statement = $conn->prepare("
    SELECT * FROM PatientToken 
    WHERE email = :email
    ");
    $statement->bindParam(':email', $email);
    $statement->execute();
    $data = $statement->fetchAll();
    if (count($data) > 0) {
        $stmt = $conn->prepare("
        UPDATE PatientToken
        SET token = :token
        WHERE email = :email;
        ");
        $stmt -> bindParam(':email', $email);
        $stmt -> bindParam(':token', $token);
        $stmt -> execute();
    } else {
        $stmt = $conn->prepare("
        INSERT INTO PatientToken (email, token) 
        VALUES (:email, :token);
        ");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
    }
} else {
    //Check if email exist
    $statement = $conn->prepare("
    SELECT * FROM ProviderToken 
    WHERE email = :email
    ");
    $statement->bindParam(':email', $email);
    $statement->execute();
    $data = $statement->fetchAll();
    if (count($data) > 0) {
        $stmt = $conn->prepare("
        UPDATE ProviderToken
        SET token = :token
        WHERE email = :email;
        ");
        $stmt -> bindParam(':email', $email);
        $stmt -> bindParam(':token', $token);
        $stmt -> execute();
    } else {
        $stmt = $conn->prepare("
        INSERT INTO ProviderToken (email, token) 
        VALUES (:email, :token);
        ");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
    }
}


try {
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'trevorunittester@gmail.com';                     //SMTP username
    $mail->Password   = '#TestPW01';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail-> SetFrom('trevorunittester@gmail.com', 'Vaccination Administrator');
    $mail -> addAddress($email,'user');     //Add a recipient

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Reset your password';
    $mail->Body    = 'This is the link to reset your password: http://localhost:63342/CovidVaccination/resetPassword.html?email='.$email.'&token='.$token.'&identity='.$identity.'</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'A reset password email has been sent to your email';
    echo '<script>window.location.href = "index.php";</script>';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

}