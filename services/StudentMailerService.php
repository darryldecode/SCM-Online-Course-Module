<?php namespace SCM\Services;

use SCM\Classes\Log;
use SCM\Classes\Mailer;
use SCM\Classes\SCMUtility;
use SCM\Model\Settings;

class StudentMailerService extends MailerService {

    /**
     * sends the user an sign up thank you email
     *
     * @param $email | the student email also use as recipeint
     * @param $password | the student password
     */
    public function sendSignUpEmailToStudent($email, $password)
    {
        $to = $email;
        $subject = "NEW ACCOUNT REGISTRATION";
        $message = "Thank You for signing-up! Your login info is listed below:";
        $from = Settings::getScmAdminEmail();
        $fromName = Settings::getCompanyName();
        $loginUrl = SCMUtility::frontBuildURL('?page=scmCourseModule&state=Front&action=myAccount');

        $mailer = new Mailer();
        $mailer->setMailerEngine($this->mailerEngine);
        $mailer->setRecipient($to);
        $mailer->setTemplate('templates/emails/welcome-email.php',compact('message','email','password','fromName','loginUrl'));
        $mailer->setHeaders('text/html');
        $mailer->setSubject($subject);
        $mailer->setFrom($from);
        $mailer->setFromName($fromName);
        $mailer->send();
    }

    /**
     * send the registrant/user/student an email about his registration and payment
     *
     * @param $courseName
     * @param $invoiceID
     * @param $emailTo
     */
    public function sendPaymentAndRegistrationEmailToStudent($courseName, $invoiceID, $emailTo)
    {
        $message = 'Thank you for your payment registration. We will get back to you as soon as we have confirmed your payment. You should received a call within 24 hours. If you don\'t please contact Us.';
        $from = Settings::getScmAdminEmail();
        $fromName = Settings::getCompanyName();
        $subject = 'Registration Payment::'.$fromName;

        $mailer = new Mailer();
        $mailer->setMailerEngine($this->mailerEngine);
        $mailer->setRecipient($emailTo);
        $mailer->setTemplate('templates/emails/payment-registration-email.php',compact('from','invoiceID','courseName','message','fromName'));
        $mailer->setFrom($from);
        $mailer->setFromName($fromName);
        $mailer->setSubject($subject);
        $mailer->setHeaders('text/html');
        $mailer->send();
    }

    /**
     * sends the forgot password link email to user
     *
     * @param $emailTo
     * @param $token
     * @param $userID
     */
    public function sendResetPasswordLink($emailTo,$token,$userID)
    {
        $message = 'You have requested reset password. Please follow this link to reset your password.';
        $from = Settings::getScmAdminEmail();
        $fromName = Settings::getCompanyName();
        $subject = 'Password Reset Request :: '.$fromName;

        // build reset URL
        $resetLink = SCMUtility::frontBuildURL("?page=scmCourseModule&state=Front&action=showResetForm&userID={$userID}&token={$token}");

        $mailer = new Mailer();
        $mailer->setMailerEngine($this->mailerEngine);
        $mailer->setRecipient($emailTo);
        $mailer->setTemplate('templates/emails/password-reset.php',compact('resetLink','message','fromName'));
        $mailer->setFrom($from);
        $mailer->setFromName($fromName);
        $mailer->setSubject($subject);
        $mailer->setHeaders('text/html');
        $mailer->send();
    }

}