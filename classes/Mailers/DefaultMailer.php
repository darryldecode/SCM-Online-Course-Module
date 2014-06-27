<?php namespace SCM\Classes\Mailers;

class DefaultMailer implements MailerScmInterface {

    /**
     * sends the email
     *
     * @param $to
     * @param $subject
     * @param $body
     * @param $headers
     * @param string $from
     * @param string $fromName
     * @return mixed
     */
    public function send($to, $subject, $body, $headers, $from = '', $fromName = '')
    {
        $staticHeaders = "MIME-Version: 1.0" . "\r\n";
        $staticHeaders .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
        $staticHeaders .= 'From: <'.$fromName.'>' . "\r\n";

        mail($to, $subject, $body, $staticHeaders);
    }

}