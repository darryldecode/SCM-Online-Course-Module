<?php namespace SCM\Controller;

use Carbon\Carbon;
use SCM\Classes\SCMUtility;
use SCM\Classes\Validator;
use SCM\Classes\View as View;
use SCM\Model\Course;
use SCM\Model\Session;
use SCM\Model\User;

/**
 * Class CourseController
 * @package SCM\Controller
 *
 * @since 1.0
 * @author Darryl Coder
 *
 * Controller use admin for Course Resource
 */
class CourseController {

    /**
     * object constructor
     */
    public function __construct()
    {
        // filter for admin only
        SCMUtility::addFilterAdminOnly();
    }

    /**
     * displays courses in admin page
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

        View::make('templates/admin/course-all.php',compact('data'));
    }

    /**
     * displays a single course in admin page
     *
     * @method GET
     */
    public function show()
    {
        $courseID = SCMUtility::cleanText($_GET['courseID']);

        // get course meta info
        $data = Course::with('students')->find($courseID);

        if( ! $data )
        {
            View::make('templates/system/error.php');
            return;
        }

        $data = $data->toArray();

        View::make('templates/admin/course-single.php',compact('data'));
    }

    /**
     * displays the create course page when creating new course
     *
     * @method GET
     */
    public function create()
    {
        $data = array();

        View::make('templates/admin/course-create.php',compact('data'));
    }

    /**
     * displays the edit page when editing a course
     *
     * @method GET
     */
    public function edit()
    {
        $courseID = SCMUtility::cleanText($_GET['courseID']);

        // get course meta info
        $data = Course::find($courseID);

        if( ! $data )
        {
            View::make('templates/system/error.php');
            return;
        }

        $data = $data->toArray();

        View::make('templates/admin/course-edit.php',compact('data'));
    }

    /**
     * stores the new course resource
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
            $inputs[$k] = SCMUtility::stripTags($v);
        }

        // validate Course info
        $validator = Validator::make($inputs,Course::$rules,Course::$rulesMessages);

        if($validator->fails())
        {
            SCMUtility::setFlashMessage($validator->messages()->first());
            View::make('templates/admin/course-create.php',compact('data'));
            return;
        }

        // store Course
        $Course = new Course();
        $Course->name = $inputs['name'];
        $Course->description = $inputs['description'];
        $Course->location = $inputs['location'];
        $Course->dates = $inputs['dates'];
        $Course->times = $inputs['times'];
        $Course->fee = $inputs['fee'];
        $Course->premium = (isset($inputs['premium'])) ? 1 : 0;
        $Course->registration_end_date = Carbon::createFromTimestamp(strtotime($inputs['registration_end_date']))->toDateString();

        if( ! $Course->save())
        {
            SCMUtility::setFlashMessage('Failed to store course');
        }

        // back to course lists
        SCMUtility::redirect('?page=scmCourseModule&state=Course&action=index');
    }

    /**
     * updates a specified course
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
            $inputs[$k] = SCMUtility::stripTags($v);
        }

        // validate Course info
        $validator = Validator::make($inputs,Course::$rules,Course::$rulesMessages);

        if($validator->fails())
        {
            SCMUtility::setFlashMessage($validator->messages()->first());
            return;
        }

        // update Course
        $course = Course::find($inputs['courseID']);

        if( ! $course)
        {
            SCMUtility::setFlashMessage('Resource specified does not exist!');
            View::make('templates/system/error.php');
            return;
        }

        $course->name = $inputs['name'];
        $course->description = $inputs['description'];
        $course->location = $inputs['location'];
        $course->dates = $inputs['dates'];
        $course->times = $inputs['times'];
        $course->fee = $inputs['fee'];
        $course->premium = (isset($inputs['premium'])) ? 1 : 0;
        $course->registration_end_date = Carbon::createFromTimestamp(strtotime($inputs['registration_end_date']))->toDateString();

        if( ! $course->save())
        {
            SCMUtility::setFlashMessage('Failed to store course');
        }

        SCMUtility::redirect("?page=scmCourseModule&state=Course&action=show&courseID={$inputs['courseID']}");
    }

    /**
     * deletes a specified course
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

        $courseID = SCMUtility::cleanText($_POST['courseID']);

        $course = Course::find($courseID);
        $course->delete();

        // back to course lists
        SCMUtility::setFlashMessage('Course successfully deleted!','success');
        SCMUtility::redirect('?page=scmCourseModule&state=Course&action=index');
    }

    /**
     * removes a student in a course
     *
     * @method POST
     */
    public function removeStudent()
    {
        // make sure request is post
        if( ! SCMUtility::requestIsPost())
        {
            View::make('templates/system/error.php',array());
            return;
        }

        $studentID  = SCMUtility::cleanText($_POST['studentID']);
        $courseID   = SCMUtility::cleanText($_POST['courseID']);

        $course = Course::find($courseID);
        $course->students()->detach($studentID);

        SCMUtility::setFlashMessage('Student successfully un-enrolled to the course.','success');
        SCMUtility::redirect("?page=scmCourseModule&state=Course&action=show&courseID={$courseID}");
    }

}