<?php
namespace Core;

use Mailer;

class Email
{

    /**
     * Send email
     * @param $subject
     * @param $message
     * @param null|string $email - receivers email
     * @param array $files - attachments
     * @return bool
     * @throws Mailer\MException
     */
    public static function send($subject, $message, $email = NULL, $files = array())
    {
        $from = Config::get('mail.sender_email') ?: Config::get('mail.admin_email');
        if (!$email) {
            $to = $from;
        } else {
            $to = $email;
        }
        $mail = new Mailer\PHPMailer;
        if (
            (boolean)Config::get('mail.smtp') &&
            Config::get('mail.host') && Config::get('mail.login') && Config::get('mail.pass') &&
            Config::get('mail.secure') && Config::get('mail.port')
        ) {
            $mail->isSMTP();
            $mail->Host = Config::get('mail.host');
            $mail->SMTPAuth = true;
            $mail->Username = Config::get('mail.login');
            $mail->Password = Config::get('mail.pass');
            $mail->SMTPSecure = Config::get('mail.secure');
            $mail->Port = Config::get('mail.port');
        }
        $mail->setFrom($from, Config::get('mail.name'));
        $mail->addReplyTo($from, Config::get('mail.name'));
        $mail->Subject = $subject;
        $mail->msgHTML($message);
        $mail->addAddress($to);

        if (is_array($files) && count($files)) {
            foreach ($files as $file) {
                if (is_file($file)) {
                    $mail->addAttachment($file);
                }
            }
        }

        return $mail->Send();
    }

}