<?php namespace SCM\Services;

use SCM\Model\Settings;

abstract class MailerService {

    protected $mailerEngine;

    public function __construct()
    {
        $mailerEngine = Settings::getScmMailEngine();
        $mailerEngineClass = "SCM\\Classes\\Mailers\\".$mailerEngine."Mailer";

        $this->mailerEngine = new $mailerEngineClass();
    }

}