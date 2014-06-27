<?php namespace SCM\Classes;

class Log {

    /**
     * the view instance
     *
     * @var
     */
    static $instance;

    const PAYPAL_LOG_DESTINATION = 'paypal.log';

    const SYSTEM_LOG_DESTINATION = 'scm.log';

    const LOG_TYPE = 3;

    /**
     * singleton instance
     *
     * @return View
     */
    public static function getInstance()
    {
        if( !(self::$instance instanceof self) )
        {
            return self::$instance = new self();
        } else {
            return self::$instance;
        }
    }

    /**
     * paypal logging
     *
     * @param $message
     */
    public function payPalLog($message)
    {
        error_log($message.PHP_EOL, self::LOG_TYPE, SCM_PATH.self::PAYPAL_LOG_DESTINATION);
    }

    /**
     * logging for system
     *
     * @param $message
     */
    public function systemLog($message)
    {
        error_log($message.PHP_EOL, self::LOG_TYPE, SCM_PATH.self::SYSTEM_LOG_DESTINATION);
    }

}