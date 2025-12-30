<?php

namespace Fosa\Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Class Email
 * @package Fosa\Core
 */

class Email
{
    /**
     * PHPMailer instance
     * 
     * @var PHPMailer
     */
    private $mail;

    function __construct()
    {
        $this->mail = new PHPMailer(true);
        try {
            $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $this->mail->isSMTP();
            $this->mail->SMTPAuth = true;
            $this->mail->Host = getenv('SMTP_HOST');
            $this->mail->Port = getenv('SMTP_PORT');
            $this->mail->Username = getenv('SMTP_USERNAME');
            $this->mail->Password = getenv('SMTP_PASSWORD');
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        } catch (Exception $e) {
            die("Can not instantiate PHPMailer. Mailer error : {$this->mail->ErrorInfo}");
        }
    }

    public function send($to, $subject, $body, $from, $alias, $altBody = NULL, $isHTML = TRUE, $files = [])
    {
        try {
            $this->mail->setFrom($from, $alias);
            $this->mail->addAddress($to);
            $this->mail->isHTML($isHTML);
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;
            $this->mail->AltBody = $body;
            if (!empty($fils)) {
                foreach ($files as $file) {
                    $this->mail->addStringAttachment(file_get_contents($file['path']), $file['name']);
                }
            }
            $this->mail->send();
            return TRUE;
        } catch (Exception $e) {
            die("Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}");
        }
    }
}