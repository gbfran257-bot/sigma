<?php
require 'class.phpmailer.php';
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Mailer = 'smtp';
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;
$mail->Host = "smtp.gmail.com";
$mail->IsHTML(true);

$mail->SMTPAuth = true;
$mail->Username = "psu.sains@gmail.com";
$mail->Password = "zun4Qx8E6_3Mfd-LA@3Z";

//Sender Info
$mail->From = "psu.sains@gmail.com";
$mail->FromName = "ADMINISTRACION SISTEMA";
