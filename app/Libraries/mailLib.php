<?php

namespace App\Libraries;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class mailLib
{
    public function __construct()
    {
        require_once APPPATH . 'ThirdParty/phpmailer/Exception.php';
        require_once APPPATH . 'ThirdParty/phpmailer/PHPMailer.php';
        require_once APPPATH . 'ThirdParty/phpmailer/SMTP.php';
        $this->mail = new PHPMailer(true);
        $this->mail = new PHPMailer(true);
        $this->dbL = new \App\Libraries\dbLib();
        $this->db = $this->dbL->db;
        $this->dtL = new \App\Libraries\datetimeLib();
        $this->utilL = new \App\Libraries\utilLib();
        $this->settingM = new \App\Models\Setting();
    }
    public function send($email = "", $header = "Header", $subject = "Subject", $message = "Message")
    {
        echo "Sending email. Please wait a moment";
        $receiver = $email;

        try {
            // //Server settings
            // $this->mail->SMTPDebug = 2;                                       // Enable verbose debug output
            // $this->mail->isSMTP();                                            // Set mailer to use SMTP
            // $this->mail->Host       = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
            // $this->mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            // $this->mail->Username   = 'maxtam642@gmail.com';                  // SMTP username
            // $this->mail->Password   = 'bgbzsqbjgjjumeut';                     // SMTP password
            // $this->mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
            // $this->mail->Port       = 587;                                    // TCP port to connect to

            // //Recipients
            // $this->mail->setFrom('maxtam642@gmail.com', 'Booking');
            // $this->mail->addAddress($receiver);     // Add a recipient // Name is optional
            // $this->mail->addReplyTo('maxtam642@yahoo.com.hk', 'Information');
            // $this->mail->addCC('maxtam642@yahoo.com.hk');
            // $this->mail->addBCC('maxtam642@yahoo.com.hk');

            // Attachments
            //$this->mail->addAttachment('');         // Add attachments

            //Server settings
            $this->mail->CharSet = "UTF-8";
            $this->mail->Encoding = 'base64';
            $this->mail->SMTPDebug = 2;                                       // Enable verbose debug output
            $this->mail->isSMTP();                                            // Set mailer to use SMTP
            $this->mail->Host       = $this->getSetting("host");              // Specify main and backup SMTP servers
            $this->mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $this->mail->Username   = $this->getSetting("username");          // SMTP username
            $this->mail->Password   = $this->getSetting("password");          // SMTP password
            $this->mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
            $this->mail->Port       = 587;                                    // TCP port to connect to

            //Recipients
            $this->mail->ClearAllRecipients();
            $this->mail->setFrom($this->getSetting("sender"), 'Booking');
            $this->mail->addAddress($receiver);                               // Add a recipient // Name is optional
            $this->mail->addReplyTo($this->getSetting("addReplyTo"), 'Information');
            $this->mail->addCC($this->getSetting("addCC"));
            $this->mail->addBCC($this->getSetting("addBCC"));

            // Content
            $this->mail->isHTML(true);                                        // Set email format to HTML
            $this->mail->addCustomHeader($header);
            $this->mail->Subject = $subject;
            $this->mail->Body    = $message;

            $this->mail->send();
            echo 'Message has been sent';
            return true;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error:{$this->mail->ErrorInfo}";
            return false;
        }
    }

    public function getSetting($field)
    {
        return $this->settingM->get("email", $field);
    }

    public function getSendMailToken($userid)
    {
        $params = [
            "data" => [
                [
                    "action" => "mail",
                    "where" => [
                        "user_id" => $userid,
                    ]
                ]
            ]
        ];
        return $this->tokenM->getNumber($params);
    }
}
