<?php namespace SCM\Controller;

use SCM\Classes\Log;
use SCM\Classes\SCMUtility;
use SCM\Classes\Validator;
use SCM\Classes\View as View;
use SCM\Model\Course;
use SCM\Model\Payment;
use SCM\Model\Session;
use SCM\Model\Settings;
use SCM\Model\User;
use SCM\Services\AdminMailerService;
use SCM\Services\StudentMailerService;
use Hautelook\Phpass\PasswordHash;

/**
 * Class FrontController
 * @package SCM\Controller
 *
 * @since 1.0
 * @author Darryl Coder
 */
class FrontController {

    /**
     * displays the course list on front end
     *
     * @method GET
     */
    public function index()
    {
        // get courses
        $offset = SCMUtility::cleanText( SCMUtility::issetOrAssign($_GET['offset'],0) );
        $limit  = SCMUtility::cleanText( SCMUtility::issetOrAssign($_GET['limit'],15) );

        $data = Course::with('students')->skip($offset)->take($limit)->orderBy('created_at','DESC')->get();
        $data = $data->toArray();

        View::make('templates/front/course-list.php',compact('data'));
    }

    /**
     * displays a single course on front end
     *
     * @method GET
     */
    public function viewCourse()
    {
        $courseID = SCMUtility::cleanText($_GET['courseID']);

        // get the current logged in user
        if(Session::isLoggedIn())
        {
            // get current logged in user
            $current_user_id = Session::getCurrentUserID();
            $user = User::with('courses')->find($current_user_id);

            // check if the course being vied is already on his enrolled courses so we can flash a message
            if( $user->isAlreadyEnrolledToCourse($courseID) )
            {
                SCMUtility::setFlashMessage('You have already enrolled to this course.','info');
            }
        }

        // get course meta info
        $data = Course::with('students')->find($courseID);

        if( ! $data )
        {
            View::make('templates/system/error.php',array());
            return;
        }

        $data = $data->toArray();

        View::make('templates/front/course-view.php',compact('data'));
    }

    /**
     * displays my account page in front end
     *
     * @method GET
     */
    public function myAccount()
    {
        if( ! Session::isLoggedIn() )
        {

            View::make('templates/front/account-login-register-form.php',array());

        } else {

            // get course meta info
            $user = User::with(array('courses'=>function($query){

                    $query->with(array('payments'=>function($query){

                            $query->where('wp_scm_users_id',Session::getCurrentUserID());

                        }))->orderBy('updated_at','DESC');

                }))->find( Session::getCurrentUserID() );

            $user = $user->toArray();

            View::make('templates/front/my-account.php',compact('user'));
        }
    }

    /**
     * shows the users payment history
     *
     * @method GET
     */
    public function paymentHistory()
    {
        // if user is not logged in let him logged in or register
        if( ! Session::isLoggedIn() )
        {
            SCMUtility::frontRedirectTo('?page=scmCourseModule&state=Front&action=myAccount');
            return;
        }

        // get user's payment history
        $userPayments = Payment::OfStudent(Session::getCurrentUserID())->get();

        View::make('templates/front/payment-history.php',compact('userPayments'));
    }

    /**
     * displays the forget password page
     *
     * @method GET
     */
    public function forgotPassword()
    {
        // if user is logged in, do not let him access this page
        if( Session::isLoggedIn() )
        {
            SCMUtility::frontRedirectTo('?page=scmCourseModule&state=Front&action=myAccount');
            return;
        }

        View::make('templates/front/forgot-password.php',array());
    }

    /**
     * handles reset password send email
     *
     * @method POST
     */
    public function resetPasswordSendEmail()
    {
        // if user is logged in, do not let him access this page
        if( Session::isLoggedIn() )
        {
            SCMUtility::frontRedirectTo('?page=scmCourseModule&state=Front&action=myAccount');
            return;
        }

        $studentEmail = SCMUtility::stripTags($_POST['forgot_password_email']);

        // create token
        $token = uniqid('',true);

        // start session reset password
        $this->resetPasswordSessionActivate($token);

        // get student
        $student = User::where('email',$studentEmail)->first();

        if( ! $student )
        {
            SCMUtility::setFlashMessage('Sorry, we cannot find any user associated with that email address.','danger');
            SCMUtility::frontRedirectTo('?page=scmCourseModule&state=Front&action=myAccount');
            return;
        }

        // send password reset link to email
        $studentMailerService = new StudentMailerService();
        $studentMailerService->sendResetPasswordLink($student->email,$token,$student->id);

        SCMUtility::setFlashMessage('A reset password link has been sent to your email. Open your email and follow the link to reset your account password. Please do not close this browser during the process.');
        SCMUtility::frontRedirectTo('?page=scmCourseModule&state=Front&action=myAccount');
        return;
    }

    /**
     * displays the reset password form link from Email sent to user | final stage
     *
     * @method GET
     */
    public function showResetForm()
    {
        // if user is logged in, do not let him access this page
        if( Session::isLoggedIn() )
        {
            SCMUtility::frontRedirectTo('?page=scmCourseModule&state=Front&action=myAccount');
            return;
        }

        $userID = SCMUtility::cleanText($_GET['userID']);
        $token  = SCMUtility::stripTags($_GET['token']);

        if( ! $this->isOnResetPasswordSession($token) )
        {
            $this->resetPasswordSessionDeactivate();

            SCMUtility::setFlashMessage('Invalid Token or token has expired!');
            SCMUtility::frontRedirectTo('?page=scmCourseModule&state=Front&action=myAccount');
            return;
        }

        $this->resetPasswordSessionDeactivate();

        View::make('templates/front/reset-password-form.php',compact('userID'));
    }

    /**
     * handles final stage in reset password, finally process update password with the new user password
     *
     * @method POST
     */
    public function doResetPassword()
    {
        // if user is logged in, do not let him access this page
        if( Session::isLoggedIn() )
        {
            SCMUtility::frontRedirectTo('?page=scmCourseModule&state=Front&action=myAccount');
            return;
        }

        $userID = SCMUtility::cleanText($_POST['userID']);
        $userNewPassword = SCMUtility::stripTags($_POST['new_reset_password']);

        // validate
        $validator = Validator::make(array('password'=>$userNewPassword),User::$rulesPasswordChange,User::$rulesMessages);

        if($validator->fails())
        {
            SCMUtility::setFlashMessage('Password reset failed. Error: '.$validator->messages()->first(),'danger');
            SCMUtility::frontRedirectTo('?page=scmCourseModule&state=Front&action=myAccount');
            return;
        }

        // update user password
        $user = User::find($userID);

        if( ! $user )
        {
            SCMUtility::setFlashMessage('Sorry, we cannot find any user associated with that email address.','danger');
            SCMUtility::frontRedirectTo('?page=scmCourseModule&state=Front&action=myAccount');
            return;
        }

        $user->password = $userNewPassword;
        $user->save();

        SCMUtility::setFlashMessage('Your password have been reset. You can now login using your new password.','success');
        SCMUtility::frontRedirectTo('?page=scmCourseModule&state=Front&action=myAccount');
        return;
    }

    /**
     * handles student/user new registrations
     *
     * @method POST
     */
    public function register()
    {
        // make sure request is post
        if( ! SCMUtility::requestIsPost())
        {
            View::make('templates/system/error.php',array());
            return;
        }

        // get inputs and clean
        $inputs = array();
        foreach($_POST as $k => $v)
        {
            $inputs[$k] = SCMUtility::stripTags($v);
        }

        // validate Course info
        $validator = Validator::make($inputs,User::$rules,User::$rulesMessages);

        if($validator->fails())
        {
            SCMUtility::setFlashMessage($validator->messages()->first(),'danger');
            View::make('templates/front/account-login-register-form.php',array());
            return;
        }

        if( SCMUtility::emailExists($inputs['email']) )
        {
            SCMUtility::setFlashMessage('Email is already used!','danger');
            View::make('templates/front/account-login-register-form.php',array());
            return;
        }

        // begin create the new user registration
        $user = new User();
        $user->first_name = $inputs['first_name'];
        $user->middle_name = $inputs['middle_name'];
        $user->last_name = $inputs['last_name'];
        $user->email = $inputs['email'];
        $user->password = $inputs['password'];
        $user->suffix = $inputs['suffix'];
        $user->employers_company_name = $inputs['employers_company_name'];
        $user->home_mailing_address_1 = $inputs['home_mailing_address_1'];
        $user->home_mailing_address_2 = $inputs['home_mailing_address_2'];
        $user->city = $inputs['city'];
        $user->state = $inputs['state'];
        $user->zip_code = $inputs['zip_code'];
        $user->personal_cell_number = $inputs['personal_cell_number'];

        if( ! $user->save())
        {
            SCMUtility::setFlashMessage('Failed to store user','danger');
            View::make('templates/front/account-login-register-form.php',array());
            return;
        }

        // login the new registered user
        if( ! Session::loginUserByEmail($user->email) )
        {
            SCMUtility::setFlashMessage('Failed to automatically logged in.','danger');
            View::make('templates/front/account-login-register-form.php',array());
            return;
        }

        // send sign up thank you email
        $studentMailerService = new StudentMailerService();
        try {
            $studentMailerService->sendSignUpEmailToStudent($user->email,$inputs['password']);
        } catch (\Exception $e){
            $log = new Log();
            $log->systemLog("\nFailed to notify user/student about its welcome sign up. \nError: {$e}");
        }

        // notify admin for the new user registration
        $adminMailerService = new AdminMailerService();
        try {
            $adminMailerService->notifyForNewUserRegistration(
                $user->first_name.' '.$user->middle_name.' '.$user->last_name,
                $user->email
            );
        } catch (\Exception $e) {
            $log = new Log();
            $log->systemLog("\nFailed to notify admin about the new user registration. \nError: {$e}");
        }


        SCMUtility::frontRedirectTo('?page=scmCourseModule&state=Front&action=myAccount');
    }

    /**
     * handles when a user logs in
     *
     * @method POST
     */
    public function login()
    {
        // make sure request is post
        if( ! SCMUtility::requestIsPost())
        {
            View::make('templates/system/error.php',array());
            return;
        }

        $email      = SCMUtility::stripTags( (isset($_POST['email'])) ? $_POST['email'] : '' );
        $password   = SCMUtility::stripTags( (isset($_POST['password'])) ? $_POST['password'] : '' );

        if( ! Session::Auth($email,$password) )
        {
            SCMUtility::setFlashMessage('Invalid email/password.','danger');
            SCMUtility::frontRedirectTo('?page=scmCourseModule&state=Front&action=myAccount');
            return;
        }

        SCMUtility::frontRedirectTo('?page=scmCourseModule&state=Front&action=myAccount');
    }

    /**
     * logout a user
     *
     * @method GET
     */
    public function logout()
    {
        Session::logout();

        SCMUtility::frontRedirectTo('?page=scmCourseModule&state=Front&action=myAccount');
    }

    /**
     * handles change password display
     *
     * @method GET
     */
    public function changePassword()
    {
        if( ! Session::isLoggedIn() )
        {
            SCMUtility::frontRedirectTo('?page=scmCourseModule&state=Front&action=myAccount');
            return;
        }

        $user = User::find(Session::getCurrentUserID());

        View::make('templates/front/change-password.php',array());
    }

    /**
     * handles change password
     *
     * @method POST
     */
    public function updatePassword()
    {
        // make sure request is post
        if( ! SCMUtility::requestIsPost())
        {
            View::make('templates/system/error.php',array());
            return;
        }

        $current_password   = SCMUtility::stripTags( (isset($_POST['current_password'])) ? $_POST['current_password'] : '' );
        $new_password       = SCMUtility::stripTags( (isset($_POST['new_password'])) ? $_POST['new_password'] : '' );
        $user               = User::find(Session::getCurrentUserID());

        $PH = new PasswordHash(8,true);

        if( ! $PH->CheckPassword($current_password,$user->password) )
        {
            SCMUtility::setFlashMessage('Invalid Old Password!','danger');
            SCMUtility::frontRedirectTo('?page=scmCourseModule&state=Front&action=changePassword');
            return;
        }

        // validate
        $validator = Validator::make(array('password'=>$new_password),User::$rulesPasswordChange,User::$rulesMessages);

        if($validator->fails())
        {
            SCMUtility::setFlashMessage($validator->messages()->first(),'danger');
            SCMUtility::frontRedirectTo('?page=scmCourseModule&state=Front&action=changePassword');
            return;
        }

        $user->password = $new_password;
        $user->save();

        SCMUtility::setFlashMessage('Password successfully updated!','success');
        SCMUtility::frontRedirectTo('?page=scmCourseModule&state=Front&action=changePassword');

    }

    /**
     * activates reset password session
     */
    protected function resetPasswordSessionActivate($token)
    {
        Session::set('scm_reset_password',$token);
    }

    /**
     * ends reset password session
     */
    protected function resetPasswordSessionDeactivate()
    {
        Session::forget('scm_reset_password');
    }

    /**
     * check if reset password session is activated
     *
     * @param $token
     * @return bool
     */
    protected function isOnResetPasswordSession($token)
    {
        if( (Session::get('scm_reset_password')) && (Session::get('scm_reset_password')==$token) ) return true;

        return false;
    }

}