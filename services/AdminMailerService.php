<?php namespace SCM\Services;

use SCM\Classes\Log;
use SCM\Classes\Mailer;
use SCM\Classes\SCMUtility;
use SCM\Model\Settings;

class AdminMailerService extends MailerService {

    /**
     * sends an email to administrator when there is a new user registration
     *
     * @param $userFullName
     * @param $userEmail
     */
    public function notifyForNewUserRegistration($userFullName, $userEmail)
    {
        // get admin email
        $adminEmail = Settings::getScmAdminEmail();

        $to = $adminEmail;
        $subject = "NEW USER/STUDENT REGISTRATION";
        $message = "A new user: {$userFullName} \n with email: {$userEmail} has registered.";
        $from = $adminEmail;
        $fromName = Settings::getCompanyName();

        $mailer = new Mailer();
        $mailer->setMailerEngine($this->mailerEngine);
        $mailer->setRecipient($to);
        $mailer->setTemplate('templates/emails/admin-notification-email.php',compact('message','fromName'));
        $mailer->setHeaders('text/html');
        $mailer->setSubject($subject);
        $mailer->setFrom($from);
        $mailer->setFromName($fromName);
        $mailer->send();
    }

    /**
     * sends an email to administrator when there is a new user payment registration
     *
     * @param $courseName
     * @param $invoiceID
     */
    public function notifyForNewStudentCoursePaymentRegistration($courseName, $invoiceID)
    {
        // get admin email
        $adminEmail = Settings::getScmAdminEmail();

        $to = $adminEmail;
        $subject = "NEW USER/STUDENT PAYMENT";
        $message = "A new payment with Invoice ID: {$invoiceID} has been generated for course: {$courseName}";
        $from = $adminEmail;
        $fromName = Settings::getCompanyName();

        $mailer = new Mailer();
        $mailer->setMailerEngine($this->mailerEngine);
        $mailer->setRecipient($to);
        $mailer->setTemplate('templates/emails/admin-notification-email.php',compact('message','fromName'));
        $mailer->setHeaders('text/html');
        $mailer->setSubject($subject);
        $mailer->setFrom($from);
        $mailer->setFromName($fromName);
        $mailer->send();
    }

}