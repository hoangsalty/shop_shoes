<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include_once LIBRARIES . "PHPMailer/PHPMailer.php";
include_once LIBRARIES . "PHPMailer/SMTP.php";
include_once LIBRARIES . "PHPMailer/Exception.php";

class Email
{
    private $d;

    function __construct($d)
    {
        $this->d = $d;
    }

    public function sendMail($mailAddress = "", $subject = "", $message = "")
    {
        $mail = new PHPMailer(true);
        //Server settings
        /* $mail->SMTPDebug  = SMTP::DEBUG_SERVER; */
        $mail->isSMTP();                                          //Send using SMTP
        $mail->CharSet    = 'utf-8';
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                 //Enable SMTP authentication
        $mail->Username   = '0306191026@caothang.edu.vn';                     //SMTP username
        $mail->Password   = 'dyatidayfmugcdrs';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('0306191026@caothang.edu.vn', 'no-reply');
        $mail->addAddress($mailAddress);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $message;

        if ($mail->send()) return true;
        else return false;
    }
}
