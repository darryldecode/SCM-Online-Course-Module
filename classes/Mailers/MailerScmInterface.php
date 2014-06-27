<?php namespace SCM\Classes\Mailers;

interface MailerScmInterface {

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
    public function send($to, $subject, $body, $headers, $from, $fromName);

}