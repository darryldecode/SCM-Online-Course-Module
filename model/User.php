<?php namespace SCM\Model;

use SCM\Classes\SCMModel;
use Hautelook\Phpass\PasswordHash;

class User extends SCMModel {

    protected $table = 'wp_scm_users';

    protected $fillable = array(
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'suffix',
        'employers_company_name',
        'home_mailing_address_1',
        'home_mailing_address_2',
        'city',
        'state',
        'zip_code',
        'personal_cell_number',
        'password',
        'blocked',
    );

    static $rulesForUpdate = array(
        'first_name' => 'required',
        'middle_name' => 'required',
        'last_name' => 'required',
        'email' => 'required|email',
        'suffix' => 'required',
        'home_mailing_address_1' => 'required',
        'city' => 'required',
        'state' => 'required',
        'zip_code' => 'required',
        'personal_cell_number' => 'required',
    );

    static $rules = array(
        'first_name' => 'required',
        'middle_name' => 'required',
        'last_name' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8',
        'suffix' => 'required',
        'home_mailing_address_1' => 'required',
        'city' => 'required',
        'state' => 'required',
        'zip_code' => 'required',
        'personal_cell_number' => 'required',
    );

    static $rulesPasswordChange = array(
        'password' => 'required|min:8',
    );

    static $rulesMessages = array(
        'first_name.required' => 'First name is required!',
        'middle_name.required' => 'Middle name is required!',
        'last_name.required' => 'Last name is required!',
        'email.required' => 'Email is required!',
        'email.email' => 'Email address must be a valid email!',
        'password.required' => 'Password is required!',
        'password.min' => 'Password must be atleast 8 characters!',
        'suffix.required' => 'Suffix is required!',
        'home_mailing_address_1.required' => 'Mailing address 1 is required!',
        'city.required' => 'City is required!',
        'state.required' => 'State is required!',
        'zip_code.required' => 'ZIP is required!',
        'personal_cell_number.required' => 'Personal Phone Number is required!',
    );

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password');

    /**
     * hash the password before any action like storing
     *
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        $passwordHasher = new PasswordHash(8,false);

        $this->attributes['password'] = $passwordHasher->HashPassword($password);
    }

    public function courses()
    {
        return $this->belongsToMany('SCM\Model\Course','wp_scm_course_users','wp_scm_course_id','wp_scm_users_id');
    }

    public function payments()
    {
        return $this->hasMany('SCM\Model\Payment','wp_scm_users_id');
    }


    public function isAlreadyEnrolledToCourse($courseID)
    {
        if( $this->courses->contains($courseID) ) return true;

        return false;
    }

}