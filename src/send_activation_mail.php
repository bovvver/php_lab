<?php
declare(strict_types=1);
include_once __DIR__ ."/redirect_to_main.php";

require_once "../PHPMailer/src/PHPMailer.php";
require_once "../PHPMailer/src/SMTP.php";
require_once "../PHPMailer/src/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

function send_activation_mail(string $email, string $token) {
    $env = parse_ini_file(".env");

    $fromName = "PHP Site Contact";
    $body = "Hello! We're glad that you've joined our community on PHP Site!\r\nPlease activate your account by clicking the link below:\r\n\r\n" . $env["SITE_URL"] . "/activate_email.php?token=$token";

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Host = $env["MAIL_SERVER"];
    $mail->Port = $env["MAIL_PORT"];
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Username = $env["MAIL_USERNAME"];
    $mail->Password = $env["MAIL_PASSWORD"];
    $mail->From = $env["FROM_MAIL"];
    $mail->FromName = $fromName;
    $mail->AddAddress($email);

    $mail->Subject = "Activate your account - $email";
    $mail->Body = $body;
    $mail->AltBody = $body;
    $mail->WordWrap = 50;

    if(!$mail->Send()) {
        echo 'Message was not sent. ';
        exit;
    } else {
        echo 'Message has been sent.';
    }
}