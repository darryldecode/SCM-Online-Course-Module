<?php namespace SCM\Model;

class Settings {

    static $payment_gateway_options = array(
        'pp_advanced',
        'pp_express',
    );

    static $mailerEngineOptions = array(
        'Default',
        'Smtp'
    );

    /**
     * get the Company Name | uses in emails, etc
     *
     * @return string
     */
    public static function getCompanyName()
    {
        $option = get_option( 'scm_settings' );

        $res    = unserialize( $option );
        return $res['scm_company_name'];
    }

    /**
     * get SCM System settings
     *
     * @return bool|mixed
     */
    public static function getScmSystemSettings()
    {
        $option = get_option( 'scm_settings' );

        $res    = unserialize( $option );
        return $res;
    }

    /**
     * get paypal advanced settings
     *
     * @return bool|mixed
     */
    public static function getScmPayPalAdvancedSettings()
    {
        $option = get_option( 'scm_paypal_advanced_settings' );

        $res    = unserialize( $option );
        return $res;
    }

    /**
     * get paypal express settings
     *
     * @return bool|mixed
     */
    public static function getScmPayPalExpressSettings()
    {
        $option = get_option( 'scm_paypal_express_settings' );

        $res    = unserialize( $option );
        return $res;
    }

    /**
     * get SMTP settings
     *
     * @return bool|mixed
     */
    public static function getScmSMTPSettings()
    {
        $option = get_option( 'scm_smtp_settings' );

        $res    = unserialize( $option );
        return $res;
    }

    /**
     * get SCM Admin Email
     *
     * @return bool|mixed
     */
    public static function getScmAdminEmail()
    {
        $option = get_option( 'scm_settings' );

        $res    = unserialize( $option );
        return $res['scm_admin_email'];
    }

    /**
     * get SCM Mailer Engine
     *
     * @return bool|mixed
     */
    public static function getScmMailEngine()
    {
        $option = get_option( 'scm_settings' );

        $res    = unserialize( $option );
        return $res['scm_mailer_engine'];
    }

    /**
     * check if system is in debug mode
     *
     * @return bool
     */
    public static function isDebugMode()
    {
        if( (isset($_SESSION['scm_debug_mode'])) && ($_SESSION['scm_debug_mode']==true) ) return true;

        if( (isset($_SESSION['scm_debug_mode'])) && ($_SESSION['scm_debug_mode']==false) ) return false;

        $option = get_option( 'scm_settings' );

        $res    = unserialize( $option );

        if($res['scm_debug_mode']==0) return false;

        return true;
    }

    /**
     * check if paypal logging transactions is enabled
     *
     * @return bool
     */
    public static function isPayPalLoggingEnabled()
    {
        $option = get_option( 'scm_settings' );

        $res    = unserialize( $option );

        if($res['scm_log_paypal_response']==0) return false;

        return true;
    }

    /**
     * check if use app style is enable
     *
     * @return bool
     */
    public static function isUseBuiltInCSSEnabled()
    {
        if( (isset($_SESSION['scm_use_app_style'])) && ($_SESSION['scm_use_app_style']==true) ) return true;

        if( (isset($_SESSION['scm_use_app_style'])) && ($_SESSION['scm_use_app_style']==false) ) return false;

        $option = get_option( 'scm_settings' );

        $res    = unserialize( $option );

        if($res['scm_use_app_style']==0) return false;

        return true;
    }

    /**
     * updates the system settings
     *
     * @param $data
     * @return bool
     */
    public static function updateSystemSettings($data)
    {
        $_SESSION['scm_debug_mode']     = ($data['scm_debug_mode']==0) ? false : true;
        $_SESSION['scm_use_app_style']  = ($data['scm_use_app_style']==0) ? false : true;

        $data = serialize($data);
        $res = update_option('scm_settings',$data);

        return $res;
    }

    /**
     * updates the paypal settings
     *
     * @param $data
     * @return bool
     */
    public static function updatePayPalAdvancedSettings($data)
    {
        $data = serialize($data);
        $res = update_option('scm_paypal_advanced_settings',$data);

        return $res;
    }

    /**
     * updates the paypal settings
     *
     * @param $data
     * @return bool
     */
    public static function updatePayPalExpressSettings($data)
    {
        $data = serialize($data);
        $res = update_option('scm_paypal_express_settings',$data);

        return $res;
    }

    /**
     * updates SMTP settings
     *
     * @param $data
     * @return bool
     */
    public static function updateSMTPSettings($data)
    {
        $data = serialize($data);
        $res = update_option('scm_smtp_settings',$data);

        return $res;
    }

    /**
     * get payment gateway options
     *
     * @return array
     */
    public static function getPaymentGatewayOptions()
    {
        return static::$payment_gateway_options;
    }

}