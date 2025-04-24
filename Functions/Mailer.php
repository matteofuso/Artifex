<?php
namespace Functions;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Config\Mailer as Config;

require 'vendor/autoload.php';
require 'Config/Mailer.php';
require_once 'Log.php';

class Mailer extends Config{
    static function send($to, $subject, $body, $html = true){
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = self::$host;
            $mail->SMTPAuth = self::$auth;
            $mail->Username = self::$email;
            $mail->Password = self::$password;
            $mail->SMTPSecure = self::$secure ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = self::$port;
            $mail->setFrom(self::$email, self::$name);
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->isHTML($html);
            $mail->addAddress($to);
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->send();
            return true;
        } catch (Exception $e) {
            Log::write($e);
            return false;
        }
    }
}