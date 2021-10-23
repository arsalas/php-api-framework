<?php

namespace App\Email;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader

class EmailController
{

    private $host;
    private $username;
    private $password;

    function __construct()
    {
        $this->host = $_ENV['MAIL_HOST'];
        $this->username =  $_ENV['MAIL_USERNAME'];
        $this->password =  $_ENV['MAIL_PASSWORD'];
        $this->port =  $_ENV['MAIL_PORT'];
    }

    public function sendEmail($email, $subject, $message)
    {

        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                       // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = $this->host;                            // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = $this->username;                        // SMTP username
            $mail->Password   =  $this->password;                       // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = $this->port;                            // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            if (isset($email)) {
                $mail->setFrom($this->username, $_ENV['MAIL_FROM_NAME']);
                $mail->addAddress($email);        // Add a recipient
            } else {
                throw new Exception(1);
            }
            // Content
            $mail->isHTML(true);                                        // Set email format to HTML
            $mail->CharSet = 'UTF-8';
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->AltBody = $message;

            $mail->send();

            $response['status'] = 'OK';
        } catch (Exception $e) {
            $response['status'] = 'KO';
        }

        return $response;
    }

  
}
