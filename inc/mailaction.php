<?php

include 'mailer/Exception.php';
include 'mailer/PHPMailer.php';
include 'mailer/SMTP.php';
// PHP Mailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//create instance
$mail = new PHPMailer();
$mail->SMTPDebug = SMTP::DEBUG_SERVER; 
$mail->isSMTP();
$mail->Host       = 'smtp.gmail.com';
$mail->SMTPAuth   = true;
$mail->Username   = 'sltcbrs@gmail.com';
$mail->Password   = 'bbqtawizqbghmhbl';
$mail->SMTPSecure = "tls";
$mail->Port       = 587;
//Recipients
 $mail->setFrom('sltcbrs@gmail.com', "SLTC BRS");
 $mail->addAddress($_SESSION['user_data']['email'], $_SESSION['user_data']['username']);
 $mail->Subject = 'Here is the subject';
 $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
 if($mail->send()){
    echo  "Email Send";
 }else{
  echo "Error";
 }
 $mail->smtpClose();