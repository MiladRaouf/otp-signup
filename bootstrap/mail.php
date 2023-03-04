<?php

$mail = new PHPMailer\PHPMailer\PHPMailer();

$mail->isSMTP();
$mail->Host = 'sandbox.smtp.mailtrap.io';
$mail->SMTPAuth = true;
$mail->Port = 2525;
$mail->Username = '3f4a24c88c9a22';
$mail->Password = '0ee31224152ead';
$mail->setFrom('auth@auth.mr', 'auth project');
$mail->isHTML(true);