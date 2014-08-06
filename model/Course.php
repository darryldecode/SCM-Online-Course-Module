<?php namespace SCM\Model;

use Carbon\Carbon;
use SCM\Classes\SCMModel;

class Course extends SCMModel {

    protected $table = 'wp_scm_course';

    protected $fillable = array(
        'name',
        'description',
        'location',
        'dates',
        'times',
        'fee',
        'premium',
        'registration_end_date',
    );

    static $rules = array(
        'name' => 'required',
        'description' => 'required',
        'location' => 'required',
        'dates' => 'required',
        'times' => 'required',
        'fee' => 'required|numeric',
        'registration_end_date' => 'required',
    );

    static $rulesMessages = array(
        'name.required' => 'Course Name is required!',
        'description.required' => 'Course Description is required!',
        'location.required' => 'Course location is required!',
        'dates.required' => 'Course dates is required!',
        'times.required' => 'Course times is required!',
        'fee.required' => 'Course fee is required!',
        'fee.numeric' => 'Course fee should be numeric!',
        'registration_end_date.required' => 'Course registration deadline date is required!',
    );

    public function students()
    {
        return $this->belongsToMany('SCM\Model\User','wp_scm_course_users','wp_scm_users_id','wp_scm_course_id');
    }

    public function payments()
    {
        return $this->hasMany('SCM\Model\Payment','wp_scm_course_id');
    }

    public function isFree()
    {
        if( $this->premium == 1 ) return false;
        return true;
    }

}