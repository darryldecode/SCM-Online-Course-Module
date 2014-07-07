<?php namespace SCM\Controller;

use SCM\Classes\SCMUtility;
use SCM\Classes\Validator;
use SCM\Classes\View;
use SCM\Model\Payment;
use SCM\Model\User;

/**
 * Class UsersController
 * @package SCM\Controller
 *
 * @since 1.0
 * @author Darryl Coder
 */
class UsersController {

    /**
     * object constructor
     */
    public function __construct()
    {
        // filter for admin only
        SCMUtility::addFilterAdminOnly();
    }

    /**
     * displays all list of student/users in admin
     *
     * @method GET
     */
    public function index()
    {
        // get courses
        $offset = SCMUtility::cleanText( SCMUtility::issetOrAssign($_GET['offset'],0) );
        $limit  = SCMUtility::cleanText( SCMUtility::issetOrAssign($_GET['limit'],15) );

        $data = User::with('courses')->skip($offset)->take($limit)->orderBy('created_at','DESC')->get();
        $data = $data->toArray();

        View::make('templates/admin/students-all.php',compact('data'));
    }

    /**
     * displays a single user/student in admin
     *
     * @method GET
     */
    public function show()
    {
        $studentID = SCMUtility::cleanText($_GET['studentID']);

        // get course meta info
        $user = User::with(array('courses'=>function($query) use ($studentID) {

                $query->with(array('payments'=>function($query) use ($studentID) {

                        $query->where('wp_scm_users_id',$studentID);

                    }))->orderBy('updated_at','DESC');

            }))->find( $studentID );

        $user = $user->toArray();

        View::make('templates/admin/student-single.php',compact('user'));
    }

    /**
     * displays create page when creating a new user
     *
     * @method GET
     */
    public function create()
    {
        View::make('templates/admin/student-create.php',array());
    }

    /**
     * handles storing the new created user
     *
     * @method POST
     */
    public function store()
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
            if($k == 'email') // don't strip email
            {
                $inputs[$k] = $v;
            } else {
                $inputs[$k] = SCMUtility::cleanText($v);
            }
        }

        // validate Course info
        $validator = Validator::make($inputs,User::$rules,User::$rulesMessages);

        if($validator->fails())
        {
            SCMUtility::setFlashMessage($validator->messages()->first());
            View::make('templates/admin/student-create.php',compact('data'));
            return;
        }

        if( SCMUtility::emailExists($inputs['email']) )
        {
            SCMUtility::setFlashMessage('Email is already used!');
            View::make('templates/admin/student-create.php',compact('data'));
            return;
        }

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
            SCMUtility::setFlashMessage('Failed to store user');
        }

        // back to course lists
        SCMUtility::redirect('?page=scmCourseModule&state=Users&action=index');
    }

    /**
     * displays edit page when editing a user
     *
     * @method GET
     */
    public function edit()
    {
        $studentID = SCMUtility::cleanText($_GET['studentID']);

        // get course meta info
        $data = User::find($studentID);
        $data = $data->toArray();

        View::make('templates/admin/student-edit.php',compact('data'));
    }

    /**
     * handles updating a user
     *
     * @method POST
     */
    public function update()
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
            if($k == 'email') // don't strip email
            {
                $inputs[$k] = $v;
            } else {
                $inputs[$k] = SCMUtility::cleanText($v);
            }
        }

        // validate Course info
        $validator = Validator::make($inputs,User::$rulesForUpdate,User::$rulesMessages);

        if($validator->fails())
        {
            SCMUtility::setFlashMessage($validator->messages()->first());
            return;
        }

        // begin update the user
        $user = User::find($inputs['studentID']);
        $user->first_name = $inputs['first_name'];
        $user->middle_name = $inputs['middle_name'];
        $user->last_name = $inputs['last_name'];
        $user->email = $inputs['email'];
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
            SCMUtility::setFlashMessage('Failed to store user');
        }

        // back to course lists
        SCMUtility::redirect("?page=scmCourseModule&state=Users&action=show&studentID={$inputs['studentID']}");
    }

    /**
     * handles deleting a user
     *
     * @method POST
     */
    public function delete()
    {
        // make sure request is post
        if( ! SCMUtility::requestIsPost())
        {
            View::make('templates/system/error.php',array());
            return;
        }

        $studentID = SCMUtility::cleanText($_POST['studentID']);

        $course = User::find($studentID);
        $course->delete();

        // back to course lists
        SCMUtility::setFlashMessage('Student/User successfully deleted.','success');
        SCMUtility::redirect('?page=scmCourseModule&state=Users&action=index');
    }


}