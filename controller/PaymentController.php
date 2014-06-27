<?php namespace SCM\Controller;

use Carbon\Carbon;
use SCM\Classes\Log;
use SCM\Classes\Payments\PayPalAdvanced;
use SCM\Classes\SCMUtility;
use SCM\Classes\Validator;
use SCM\Classes\View as View;
use SCM\Model\Course;
use SCM\Model\Payment;
use SCM\Model\PaymentsTransactionsData;
use SCM\Model\Session;
use SCM\Model\Settings;
use SCM\Model\User;
use Omnipay\Omnipay;
use SCM\Services\AdminMailerService;
use SCM\Services\StudentMailerService;

/**
 * Class PaymentController
 * @package SCM\Controller
 *
 * @since 1.0
 * @author Darryl Coder
 */
class PaymentController {

    /**
     * use in admin display all payments
     *
     * @method GET
     */
    public function index()
    {
        SCMUtility::addFilterAdminOnly();

        $offset = SCMUtility::cleanText( SCMUtility::issetOrAssign($_GET['offset'],0) );
        $limit  = SCMUtility::cleanText( SCMUtility::issetOrAssign($_GET['limit'],15) );

        $payments = Payment::with(array('student','course','data'))->skip($offset)->take($limit)->get();
        $payments = $payments->toArray();

        View::make('templates/admin/payments.php',compact('payments'));
    }

    /**
     * show single payment item | use in admin display a single payment
     *
     * @method GET
     */
    public function show()
    {
        SCMUtility::addFilterAdminOnly();

        $paymentID = SCMUtility::cleanText( SCMUtility::issetOrAssign($_GET['paymentID'],'') );

        $payment = Payment::with(array('student','course','data'))->find($paymentID);
        $payment = $payment->toArray();

        View::make('templates/admin/payment-single.php',compact('payment'));
    }

    /**
     * deletes a payment in admin
     *
     * @method POST
     */
    public function delete()
    {
        SCMUtility::addFilterAdminOnly();

        if( ! SCMUtility::requestIsPost())
        {
            View::make('templates/system/error.php',array());
            return;
        }

        $paymentID = SCMUtility::cleanText( (isset($_POST['paymentID'])) ? $_POST['paymentID'] : '' );

        // delete payment
        $payment = Payment::find($paymentID);
        $payment->delete();

        SCMUtility::setFlashMessage('Payment successfully deleted!','success');
        SCMUtility::redirect("?page=scmCourseModule&state=Payment&action=index");
    }

    /**
     * use in front end when a user registers for a course
     *
     * @method POST
     */
    public function registerOnCourse()
    {
        $courseID = SCMUtility::cleanText( (isset($_POST['courseID'])) ? $_POST['courseID'] : '' );

        // if user is not logged in let him logged in or register
        if( ! Session::isLoggedIn() )
        {
            SCMUtility::setFlashMessage('Please login first or create an account to enroll on a course.','info');
            SCMUtility::frontRedirectTo('?page=scmCourseModule&state=Front&action=myAccount');
            return;
        }

        // get the course
        $course = Course::find($courseID);

        // check registration end date
        if( Carbon::now()->toDateTimeString() > $course->registration_end_date )
        {
            SCMUtility::setFlashMessage('Registration of this course is not available.','warning');
            SCMUtility::frontRedirectTo("?page=scmCourseModule&state=Front&action=viewCourse&courseID={$courseID}");
            return;
        }

        // get settings company name
        $companyName = strtoupper( str_replace(' ','',Settings::getCompanyName()) );

        // check if it's free
        if( $course->isFree() )
        {

            // get the current logged in user
            $current_user_id = Session::getCurrentUserID();
            $user = User::with('courses')->find($current_user_id);

            // check if current user is already enrolled with this course
            if( $user->isAlreadyEnrolledToCourse($courseID) )
            {

                SCMUtility::setFlashMessage('You are already enrolled to this course.','warning');
                SCMUtility::frontRedirectTo("?page=scmCourseModule&state=Front&action=viewCourse&courseID={$courseID}");

            } else {

                $user->courses()->attach($courseID);
                SCMUtility::setFlashMessage('You have successfully enrolled to this course.','success');
                SCMUtility::frontRedirectTo("?page=scmCourseModule&state=Front&action=viewCourse&courseID={$courseID}");

            }

        } else {

            // get the current logged in user
            $current_user_id = Session::getCurrentUserID();
            $user = User::with('courses')->find($current_user_id);

            // check if current user is already enrolled with this course
            if( $user->isAlreadyEnrolledToCourse($courseID) )
            {

                SCMUtility::setFlashMessage('You are already enrolled to this course.','warning');
                SCMUtility::frontRedirectTo("?page=scmCourseModule&state=Front&action=viewCourse&courseID={$current_user_id}");

            } else {

                // check what paypal gateway is set
                $scmSystemSettings = Settings::getScmSystemSettings();

                // if set to PayPal Express, process this block
                if( $scmSystemSettings['scm_active_payment_gateway'] == 'pp_express' )
                {
                    // get paypal express settings
                    $scmPayPalExpressSettings = Settings::getScmPayPalExpressSettings();
                    $mode = ($scmPayPalExpressSettings['mode'] == 'sandbox') ? true : false;

                    // prepare pay pal express processor
                    $gateway = Omnipay::create('PayPal_Express');
                    $gateway->setUsername($scmPayPalExpressSettings['user']);
                    $gateway->setPassword($scmPayPalExpressSettings['pwd']);
                    $gateway->setSignature($scmPayPalExpressSettings['signature']);
                    $gateway->setTestMode($mode);

                    // call
                    $response = $gateway->purchase(array(
                        'cancelUrl' => SCMUtility::frontBuildURL("?page=scmCourseModule&state=Payment&action=cancel&courseID={$course->id}"),
                        'returnUrl' => SCMUtility::frontBuildURL("?page=scmCourseModule&state=Payment&action=success&courseID={$course->id}&studentID={$user->id}"),
                        'description' => $course->name,
                        'amount' => $course->fee,
                        'currency' => $scmPayPalExpressSettings['currency'],
                        'transactionId' => uniqid('SCM',true),
                        'noshipping' => '1',
                        'allownote' => '0',
                    ))->send();

                    // get the response data
                    $data = $response->getData();

                    // if acknowledgment is success we will store the session
                    // to be used in success and cancel page, so we can be sure that the transaction is original
                    // and only this transaction will be accepted in our success and cancel page processor
                    if($data['ACK']=='Success')
                    {
                        // activate payment session
                        $this->paymentSessionActivate();

                        Session::set('scm_ec_token',$data['TOKEN']);
                    }

                    // send to paypal for payment
                    $response->redirect();
                }

                // if set to PayPal Advanced, process this block
                if( $scmSystemSettings['scm_active_payment_gateway'] == 'pp_advanced' )
                {
                    // get paypal advance settings
                    $scmPayPalAdvanceSettings = Settings::getScmPayPalAdvancedSettings();

                    // check settings environments
                    if($scmPayPalAdvanceSettings['mode']=='sandbox')
                    {
                        $scmPFMODE      = 'TEST';
                        $scmPFENDPOINT  = 'https://pilot-payflowpro.paypal.com';
                    } else {
                        $scmPFMODE      = 'LIVE';
                        $scmPFENDPOINT  = 'https://payflowpro.paypal.com';
                    }

                    // call payflow endpoint and prepare for payment
                    $payPalAdvanced = new PayPalAdvanced();
                    $payPalAdvanced->setEndPointUrl($scmPFENDPOINT);
                    $payPalAdvanced->setMode($scmPFMODE);
                    $payPalAdvanced->setPartner($scmPayPalAdvanceSettings['partner']);
                    $payPalAdvanced->setVendor($scmPayPalAdvanceSettings['vendor']);
                    $payPalAdvanced->setUser($scmPayPalAdvanceSettings['user']);
                    $payPalAdvanced->setPWD($scmPayPalAdvanceSettings['pwd']);
                    $payPalAdvanced->setTrxType($scmPayPalAdvanceSettings['trxtype']);
                    $payPalAdvanced->setAmount($course->fee);
                    $payPalAdvanced->setCreateSecureToken('Y');
                    $payPalAdvanced->setSecureTokenID(uniqid('',true));
                    $response = $payPalAdvanced->callPayFlowServer();

                    // if approve render the form for payment
                    if($response->isApproved())
                    {
                        // hit this on our session so we can make sure that the communication in our success page is originally from PayPal
                        // and only this transaction is valid
                        $this->paymentSessionActivate();

                        // get course data to be pass on the view
                        $courseData = $course->toArray();

                        $data = array(
                            'ENDPOINTURL' => 'https://payflowlink.paypal.com',
                            'MODE' => $payPalAdvanced->getMode(),
                            'SECURETOKENID' => $payPalAdvanced->getResponseSecureTokenID(),
                            'SECURETOKEN' => $payPalAdvanced->getResponseSecureToken(),
                            'USERID' => Session::getCurrentUserID(),
                            'COURSEID' => $course->id,
                            'INVOICEID' => uniqid($companyName,true),
                        );
                        View::make('templates/front/payments/paypal-advanced.php',compact('data','courseData'));
                    } else {

                        SCMUtility::setFlashMessage('An error was occurred while trying to communicate with PayPal. Please contact the administrator about this. Thank You.');

                    }
                }

            }

        }

    }

    /**
     * triggered by PayPal Advanced Silent Post
     *
     * @gateway PayPalAdvanced
     * @method POST
     */
    public function scmSilentPost()
    {
        // clean data posts
        $req = '';
        foreach ($_POST as $key => $value) {
            $value = urlencode(stripslashes($value));
            $req .= "&$key=$value";
        }

        // parse for processing
        parse_str($req,$output);

        // get custom vars
        $STUDENTID        = $output['USER1'];
        $COURSEID         = $output['USER2'];
        $INVOICEID        = $output['USER3'];

        // check if result is ok | 0 means ok
        if($output['RESULT']==0)
        {
            // check if response message from PayPal is approved
            if($output['RESPMSG']=='Approved')
            {

                // enrol|register the student on the course
                $course = Course::find($COURSEID);
                $course->students()->attach($STUDENTID);

                // store payment data
                $payment = new Payment();
                $payment->invoice_id = $INVOICEID;
                $payment->wp_scm_course_id = $COURSEID;
                $payment->wp_scm_users_id = $STUDENTID;
                $payment->paid = 0;
                $payment->save();

                // store payment transaction data
                foreach($output as $k => $v)
                {
                    $paymentsTransactionsData = new PaymentsTransactionsData();
                    $paymentsTransactionsData->wp_scm_payment_id = $payment->id;
                    $paymentsTransactionsData->key = $k;
                    $paymentsTransactionsData->value = $v;
                    $paymentsTransactionsData->save();
                }

            } else {

                $log = new Log();
                $log->systemLog("Payment Result was good, but payment Response Message was not approved. RESPMSG: {$output['RESPMSG']}");

            }

        } else {
            $log = new Log();
            $log->systemLog("\nPayment Transaction Failed with request: {$req}");
        }

        // debugging
        if( Settings::isPayPalLoggingEnabled() )
        {
            $message = "Res: $req";
            ob_start();
            print_r($output);
            $out = ob_get_clean();

            $log = new Log();
            $log->payPalLog("\n");
            $log->payPalLog('--------Start PayPal logging debug--------');
            $log->payPalLog($message);
            $log->payPalLog('the silent post route is triggered!');
            $log->payPalLog($out);
            $log->payPalLog('--------End PayPal logging debug--------');
        }

    }

    /**
     * handles return URL for successful payPal Advance transactions
     * this will redirect to actual visible payment page
     *
     * @gateway PayPalAdvanced
     * @method POST
     */
    public function paySuccess()
    {
        // clean data posts
        $req = '';
        foreach ($_POST as $key => $value) {
            $value = urlencode(stripslashes($value));
            $req .= "&$key=$value";
        }

        // parse for processing
        parse_str($req,$output);

        // get custom vars
        $STUDENTID        = $output['USER1'];
        $COURSEID         = $output['USER2'];
        $INVOICEID        = $output['USER3'];

        // get student and course it has purchased
        $student = User::find($STUDENTID);
        $course = Course::find($COURSEID);

        // notify student via email
        $studentMailerService = new StudentMailerService();
        try {
            $studentMailerService->sendPaymentAndRegistrationEmailToStudent($course->name,$INVOICEID,$student->email);
        } catch (\Exception $e){
            $log = new Log();
            $log->systemLog("Failed to notify user/student about its payment. \nError: {$e}");
        }

        // notify admin about this payment
        $adminMailerService = new AdminMailerService();
        try {
            $adminMailerService->notifyForNewStudentCoursePaymentRegistration($course->name,$INVOICEID);
        } catch (\Exception $e){
            $log = new Log();
            $log->systemLog("Failed to notify admin about the new payment. \nError: {$e}");
        }

        // debugging
        if( Settings::isPayPalLoggingEnabled() )
        {
            $log = new Log();
            $log->payPalLog('--------Start PayPal logging debug--------');
            $log->payPalLog('invoice is: '.$INVOICEID);
            $log->payPalLog('student UD is: '.$STUDENTID);
            $log->payPalLog('course ID is: '.$COURSEID);
            $log->payPalLog('--------End PayPal logging debug--------');
        }

        // redirect to my account
        $myAccountUrl = SCMUtility::frontBuildURL('?page=scmCourseModule&state=Payment&action=afterSuccessPaymentPage');
        ?>
        <script type="text/javascript">
            parent.location = "<?php echo $myAccountUrl; ?>";
        </script>
        <?php
    }

    /**
     * displays thank you message
     *
     * @gateway PayPalAdvanced
     * @method GET
     */
    public function afterSuccessPaymentPage()
    {
        if( ($this->isPaymentSessionActive()) && (Session::isLoggedIn()) )
        {

            $this->paymentSessionDeactivate();

            // get course meta info
            $user = User::with(array('courses'=>function($query){

                    $query->with(array('payments'=>function($query){

                            $query->where('wp_scm_users_id',Session::getCurrentUserID());

                        }))->orderBy('updated_at','DESC');

                }))->find( Session::getCurrentUserID() );

            $user = $user->toArray();

            $flashMessage = 'Thank you for you payment. Please check you email for payment information. You should see now the course you have enrolled/registered on your enrolled courses list on MY ACCOUNT PAGE.';
            SCMUtility::setFlashMessage($flashMessage,'success');
            View::make('templates/front/my-account.php',compact('user'));

        } else {

            SCMUtility::setFlashMessage('Ops! looks like something went wrong!','info');

        }
    }

    /**
     * handles PayPal advance error transactions
     *
     * @gateway PayPalAdvanced
     * @method GET
     */
    public function payError()
    {
        if( ($this->isPaymentSessionActive()) && (Session::isLoggedIn()) )
        {

            $this->paymentSessionDeactivate();

            SCMUtility::setFlashMessage('An Error has occurred while processing your payment.','danger');

        } else {

            SCMUtility::setFlashMessage('Ops! looks like something went wrong!','info');

        }

        // debugging
        if( Settings::isPayPalLoggingEnabled() )
        {
            $log = new Log();
            $log->payPalLog('--------Start PayPal logging debug--------');
            $log->payPalLog('Pay Pal Advanced Error Handle was triggered!');
            $log->payPalLog('--------End PayPal logging debug--------');
        }
    }

    /**
     * handles PayPal advance canceled transactions
     *
     * @gateway PayPalAdvanced
     * @method GET
     */
    public function payCancel()
    {
        if( ($this->isPaymentSessionActive()) && (Session::isLoggedIn()) )
        {

            $this->paymentSessionDeactivate();

            SCMUtility::setFlashMessage('You have cancelled your payment.','info');

        } else {

            SCMUtility::setFlashMessage('Ops! looks like something went wrong!','info');

        }

        // debugging
        if( Settings::isPayPalLoggingEnabled() )
        {
            $log = new Log();
            $log->payPalLog('--------Start PayPal logging debug--------');
            $log->payPalLog('Pay Pal Advanced Cancel Handle was triggered!');
            $log->payPalLog('--------End PayPal logging debug--------');
        }
    }

    /**
     * use in handling success transactions using paypal express
     *
     * @gateway PayPal Express
     * @method GET
     */
    public function success()
    {
        $token      = SCMUtility::stripTags( (isset($_GET['token'])) ? $_GET['token'] : '');
        $courseID   = SCMUtility::stripTags( (isset($_GET['courseID'])) ? $_GET['courseID'] : '');
        $studentID  = SCMUtility::stripTags( (isset($_GET['studentID'])) ? $_GET['studentID'] : '');

        // make sure the scm_ec_token token is present before processing things
        if( Session::get('scm_ec_token') )
        {
            // check if token matched
            if( $token == Session::get('scm_ec_token') )
            {
                // get course
                $course = Course::find($courseID);
                $course->students()->attach($studentID);

                // create payment data
                $payment = new Payment();
                $payment->invoice_id = 'N/A';
                $payment->wp_scm_course_id = $courseID;
                $payment->wp_scm_users_id = $studentID;
                $payment->paid = 0;
                $payment->save();

                $paymentsTransactionData = array(
                    'METHOD'  => 'PP',
                    'GATEWAY' => 'PayPal Express',
                    'ECTOKEN' => $token,
                );

                // store payment transaction data
                foreach($paymentsTransactionData as $k => $v)
                {
                    $paymentsTransactionsData = new PaymentsTransactionsData();
                    $paymentsTransactionsData->wp_scm_payment_id = $payment->id;
                    $paymentsTransactionsData->key = $k;
                    $paymentsTransactionsData->value = $v;
                    $paymentsTransactionsData->save();
                }

                $message    = 'Thank You for paying. You are now register for this course. We will email you once we have confirmed your payments.';
                View::make('templates/front/payments/success.php',compact('course','message'));

            } else {

                // show something fishy
                SCMUtility::setFlashMessage('Ops! looks like something went wrong!','info');

                // log this
                $log = new Log();
                $log->systemLog("\nToken Mismatch triggered in ".__CLASS__.'::'.__METHOD__);

            }
        } else {

            // show something fishy
            SCMUtility::setFlashMessage('Ops! looks like something went wrong!','info');

            // log this
            $log = new Log();
            $log->systemLog("\nToken Not Set triggered in ".__CLASS__.'::'.__METHOD__);

        }

        // remove session for this transaction
        Session::forget('scm_ec_token');
    }

    /**
     * use in handling cancel transaction using paypal express
     *
     * @gateway PayPal Express
     * @method GET
     */
    public function cancel()
    {
        $token      = SCMUtility::stripTags( (isset($_GET['token'])) ? $_GET['token'] : '');
        $courseID   = SCMUtility::stripTags( (isset($_GET['courseID'])) ? $_GET['courseID'] : '');

        // make sure the scm_ec_token token is present before processing things
        if( Session::get('scm_ec_token') )
        {
            // check if token matched
            if( $token == Session::get('scm_ec_token') )
            {

                $course = Course::find($courseID);
                $message    = 'You have canceled your registration payment for this course.';
                View::make('templates/front/payments/cancel.php',compact('course','message'));

            } else {

                $course = Course::find($courseID);
                $message    = 'An error has occurred while paying for this course.';
                View::make('templates/front/payments/error.php',compact('course','message'));

            }
        } else {

            // show something fishy
            SCMUtility::setFlashMessage('Ops! looks like something went wrong!','info');

        }

        // remove session for this transaction
        Session::forget('scm_ec_token');
    }

    /**
     * use in admin to set a course payment to be confirmed
     *
     * @method POST
     */
    public function setPaid()
    {
        SCMUtility::addFilterAdminOnly();

        // make sure request is post
        if( ! SCMUtility::requestIsPost())
        {
            View::make('templates/system/error.php',array());
            return;
        }

        $paymentID = SCMUtility::cleanText($_POST['paymentID']);

        $payment = Payment::find($paymentID);
        $payment->paid = 1;

        if( ! $payment->save() )
        {
            SCMUtility::setFlashMessage('Failed to update payment!','danger');
            SCMUtility::redirect('?page=scmCourseModule&state=Payment&action=index');
        }

        SCMUtility::setFlashMessage('Payment successfully updated!','success');
        SCMUtility::redirect('?page=scmCourseModule&state=Payment&action=index');
    }

    /**
     * use in admin to set a course payment in un-confirm status
     *
     * @method POST
     */
    public function setUnPaid()
    {
        SCMUtility::addFilterAdminOnly();

        // make sure request is post
        if( ! SCMUtility::requestIsPost())
        {
            View::make('templates/system/error.php',array());
            return;
        }

        $paymentID = SCMUtility::cleanText($_POST['paymentID']);

        $payment = Payment::find($paymentID);
        $payment->paid = 0;

        if( ! $payment->save() )
        {
            SCMUtility::setFlashMessage('Failed to update payment!','danger');
            SCMUtility::redirect('?page=scmCourseModule&state=Payment&action=index');
        }

        SCMUtility::setFlashMessage('Payment successfully updated!','success');
        SCMUtility::redirect('?page=scmCourseModule&state=Payment&action=index');
    }

    /**
     * activates payment session
     */
    protected function paymentSessionActivate()
    {
        Session::set('scm_payment_session',true);
    }

    /**
     * check if there is current payment session happening
     *
     * @return bool
     */
    protected function isPaymentSessionActive()
    {
        if( (Session::get('scm_payment_session')) && (Session::get('scm_payment_session')==true) ) return true;

        return false;
    }

    /**
     * end payment session
     */
    protected function paymentSessionDeactivate()
    {
        Session::forget('scm_payment_session');
    }


}