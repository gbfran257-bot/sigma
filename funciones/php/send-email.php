<?php
require 'class.phpmailer.php';
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Mailer = 'smtp';
$mail->SMTPSecure = null;
$mail->Port = 587;
$mail->Host = "preunisains.com";
$mail->IsHTML(true);

$mail->SMTPAuth = true;
$mail->Username = "info@preunisains.com";
$mail->Password = "CAFF9511";

//Sender Info
$mail->From = "info@preunisains.com";
$mail->FromName = "ADMINISTRACION SISTEMA";
