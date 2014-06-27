<?php namespace SCM\Model;

use Hautelook\Phpass\PasswordHash;

class Session {

    /**
     * authenticate a user
     *
     * @param $email
     * @param $password
     * @return bool
     */
    public static function Auth($email, $password)
    {
        $user = User::where('email',$email)->first();

        if( ! $user ) return false;

        $PW = new PasswordHash(8,false);

        if( ! $PW->CheckPassword($password, $user->password) ) return false;

        $_SESSION['scm_logged_in']  = true;
        $_SESSION['scm_user_id']    = $user->id;
        $_SESSION['scm_user_name']  = $user->first_name;

        return true;
    }

    /**
     * manuallly login a user using email
     *
     * @param $email
     * @return bool
     */
    public static function loginUserByEmail($email)
    {
        $user = User::where('email',$email)->first();

        $_SESSION['scm_logged_in']  = true;
        $_SESSION['scm_user_id']    = $user->id;
        $_SESSION['scm_user_name']  = $user->first_name;

        return true;
    }

    /**
     * returns the user object if user is logged in, or false is not
     *
     * @return bool
     */
    public static function getCurrentUserID()
    {
        if(isset($_SESSION['scm_user_id'])) return $_SESSION['scm_user_id'];

        return false;
    }

    /**
     * returns the current User name
     *
     * @return bool
     */
    public static function getCurrentUserName()
    {
        if(isset($_SESSION['scm_user_name'])) return $_SESSION['scm_user_name'];

        return false;
    }

    /**
     * logout a user
     */
    public static function logout()
    {
        unset($_SESSION['scm_logged_in']);
        unset($_SESSION['scm_user_id']);
        unset($_SESSION['scm_user_name']);
    }

    /**
     * check if the user is sign in
     *
     * @return bool
     */
    public static function isLoggedIn()
    {
        if( (isset($_SESSION['scm_logged_in'])) && ($_SESSION['scm_logged_in']===true) ) return true;

        return false;
    }

    /**
     * sets a session with key value pair
     *
     * @param $key
     * @param $value
     */
    public static function set($key, $value)
    {
        if(isset($_SESSION[$key])) unset($_SESSION[$key]);

        $_SESSION[$key] = $value;
    }

    /**
     * get session if exist or return false if not set
     *
     * @param $key
     * @return bool
     */
    public static function get($key)
    {
        if(isset($_SESSION[$key])) return $_SESSION[$key];

        return false;
    }

    /**
     * removes a session using key
     *
     * @param $key
     */
    public static function forget($key)
    {
        unset($_SESSION[$key]);
    }

}