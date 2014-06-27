<?php namespace SCM\Classes\Mailers;

use SCM\Model\Settings;

class SmtpMailer implements MailerScmInterface {

    /**
     * sends the email
     *
     * @param $to
     * @param $subject
     * @param $body
     * @param $headers
     * @param $from
     * @param $fromName
     * @return mixed
     */
    public function send($to, $subject, $body, $headers, $from, $fromName)
    {
        // get SMTP settings
        $smtpSettings = Settings::getScmSMTPSettings();
        $host       = $smtpSettings['host'];
        $port       = $smtpSettings['port'];
        $username   = $smtpSettings['username'];
        $password   = $smtpSettings['password'];
        $encryption = $smtpSettings['encryption'];

        // create transport instance
        $transport = \Swift_SmtpTransport::newInstance($host,$port,$encryption);
        $transport->setUsername($username);
        $transport->setPassword($password);

        // build the message
        $message = \Swift_Message::newInstance();
        $message->setTo($to);
        $message->setSubject($subject);
        $message->setFrom($from, $fromName);
        $message->setBody($body, $headers);

        // send
        $mailer = \Swift_Mailer::newInstance($transport);
        $mailer->send($message, $failedRecipients);

    }
}