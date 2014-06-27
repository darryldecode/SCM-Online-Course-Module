<?php namespace SCM\Controller;

use SCM\Classes\View as View;
use SCM\Model\Settings;
use SCM\Classes\SCMUtility;

/**
 * Class SettingsController
 * @package SCM\Controller
 *
 * @since 1.0
 * @author Darryl Coder
 */
class SettingsController {

    /**
     * object constructor
     */
    public function __construct()
    {
        // filter for admin only
        SCMUtility::addFilterAdminOnly();
    }

    /**
     * displays the settings page
     *
     * @method GET
     */
    public function index()
    {
        // get settings
        $scm_settings = Settings::getScmSystemSettings();
        $scm_paypal_advanced_settings = Settings::getScmPayPalAdvancedSettings();
        $scm_paypal_express_settings = Settings::getScmPayPalExpressSettings();
        $scm_smtp_settings = Settings::getScmSMTPSettings();
        $scm_gateway_options = Settings::$payment_gateway_options;
        $scm_mailer_engine_options = Settings::$mailerEngineOptions;

        if( isset($_GET['updated']) ) SCMUtility::setFlashMessage('Settings Updated!');

        View::make('templates/admin/settings.php',compact('scm_settings','scm_paypal_advanced_settings','scm_paypal_express_settings','scm_gateway_options','scm_mailer_engine_options','scm_smtp_settings'));
    }

    /**
     * handle update system settings
     *
     * @method POST
     */
    public function updateSystemSettings()
    {
        // make sure request is post
        if( ! SCMUtility::requestIsPost())
        {
            View::make('templates/system/error.php',array());
            return;
        }

        $data = array();
        foreach($_POST as $k => $v)
        {
            $data[$k] = SCMUtility::stripTags($v);
        }

        $result = Settings::updateSystemSettings($data);

        if($result)
        {
            SCMUtility::redirect('?page=scmCourseModule&state=Settings&action=index&updated');
        }

        SCMUtility::setFlashMessage('Failed to update settings!');
        SCMUtility::redirect('?page=scmCourseModule&state=Settings&action=index');
    }

    /**
     * handles updating PayPal Advance Settings
     *
     * @method POST
     */
    public function updatePayPalAdvancedSettings()
    {
        // make sure request is post
        if( ! SCMUtility::requestIsPost())
        {
            View::make('templates/system/error.php',array());
            return;
        }

        $data = array();
        foreach($_POST as $k => $v)
        {
            $data[$k] = SCMUtility::stripTags($v);
        }

        $result = Settings::updatePayPalAdvancedSettings($data);

        if($result)
        {
            SCMUtility::setFlashMessage('Settings Updated!');

            SCMUtility::redirect('?page=scmCourseModule&state=Settings&action=index&updated');
        }

        SCMUtility::setFlashMessage('Failed to update settings!');
        SCMUtility::redirect('?page=scmCourseModule&state=Settings&action=index');
    }

    /**
     * handles updating PayPal Express settings
     *
     * @method POST
     */
    public function updatePayPalExpressSettings()
    {
        // make sure request is post
        if( ! SCMUtility::requestIsPost())
        {
            View::make('templates/system/error.php',array());
            return;
        }

        $data = array();
        foreach($_POST as $k => $v)
        {
            $data[$k] = SCMUtility::stripTags($v);
        }

        $result = Settings::updatePayPalExpressSettings($data);

        if($result)
        {
            SCMUtility::setFlashMessage('Settings Updated!');

            SCMUtility::redirect('?page=scmCourseModule&state=Settings&action=index&updated');
        }

        SCMUtility::setFlashMessage('Failed to update settings!');
        SCMUtility::redirect('?page=scmCourseModule&state=Settings&action=index');
    }

    /**
     * handles updating SMTP Settings
     *
     * @method POST
     */
    public function updateSMTPSettings()
    {
        // make sure request is post
        if( ! SCMUtility::requestIsPost())
        {
            View::make('templates/system/error.php',array());
            return;
        }

        $data = array();
        foreach($_POST as $k => $v)
        {
            $data[$k] = SCMUtility::stripTags($v);
        }

        $result = Settings::updateSMTPSettings($data);

        if($result)
        {
            SCMUtility::setFlashMessage('Settings Updated!');

            SCMUtility::redirect('?page=scmCourseModule&state=Settings&action=index&updated');
        }

        SCMUtility::setFlashMessage('Failed to update settings!');
        SCMUtility::redirect('?page=scmCourseModule&state=Settings&action=index');
    }

}