<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Mailer
{
    public static function send(string $toEmail, string $subject, string $htmlBody, string $toName = '', string $textBody = ''): bool
    {
        try {
            $smtp = MailConfig::smtp();
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = $smtp['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $smtp['username'];
            $mail->Password = $smtp['password'];
            $mail->Port = (int) $smtp['port'];
            $mail->SMTPSecure = $smtp['encryption'];

            $mail->setFrom($smtp['from_email'], $smtp['from_name']);
            $mail->addAddress($toEmail, $toName ?: $toEmail);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $htmlBody;
            $mail->AltBody = $textBody !== '' ? $textBody : strip_tags($htmlBody);

            $sent = $mail->send();
            if ($sent) {
                error_log('PHPMailer send success: to=' . $toEmail . ' subject=' . $subject);
            } else {
                error_log('PHPMailer send failed: to=' . $toEmail . ' subject=' . $subject . ' error=' . $mail->ErrorInfo);
            }

            return $sent;
        } catch (Throwable $e) {
            error_log('PHPMailer send failed: to=' . $toEmail . ' subject=' . $subject . ' error=' . $e->getMessage());
            return false;
        }
    }
}
