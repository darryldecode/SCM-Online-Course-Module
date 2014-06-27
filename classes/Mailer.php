<?php namespace SCM\Classes;

use SCM\Classes\Mailers\MailerScmInterface;

class MailerException extends \Exception{};

class Mailer {

    /**
     * the recipient
     *
     * @var
     */
    protected $to;

    /**
     * the subject
     *
     * @var
     */
    protected $subject;

    /**the body
     *
     * @var
     */
    protected $body;

    /**
     * the headers
     *
     * @var
     */
    protected $headers;

    /**
     * email from
     *
     * @var
     */
    protected $from;

    /**
     * email from name
     *
     * @var
     */
    protected $fromName;

    /**
     * the mail engine to be use, should implement ScmMailerInterface
     *
     * @var
     */
    protected $mailerEngine;

    public function setMailerEngine($engine)
    {
        if( ! $engine instanceof MailerScmInterface) throw new MailerException('Engine Mailer Object should be an implementation of SCM\Classes\MailerScmInterface');

        $this->mailerEngine = $engine;
    }

    public function setRecipient($recipient)
    {
        $this->to = $recipient;
    }

    public function setSubject($subject = 'New Email')
    {
        $this->subject = $subject;
    }

    public function setTemplate($path, $data)
    {
        $this->body = SCMUtility::templateBuffer($path, $data);
    }

    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    public function setFrom($from = '')
    {
        $this->from = $from;
    }

    public function setFromName($fromName = '')
    {
        $this->fromName = $fromName;
    }

    public function send()
    {
        $this->mailerEngine->send(
            $this->to,
            $this->subject,
            $this->body,
            $this->headers,
            $this->from,
            $this->fromName
        );
    }

}