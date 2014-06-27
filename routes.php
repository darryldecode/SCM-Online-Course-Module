<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use SCM\Model\Settings;

// WP bug in calling verify_nonce | this should not be like this! sohai la WordPress!
require_once(ABSPATH .'wp-includes/pluggable.php');

// set Defaults system environment to session vars for performance
$_SESSION['scm_debug_mode']     = ( Settings::isDebugMode() ) ? true : false;
$_SESSION['scm_use_app_style']  = ( Settings::isUseBuiltInCSSEnabled() ) ? true : false;

// boot routing
$router = new \SCM\Classes\Router();
$router->addCSRFExemptedActions(array(
    'scmSilentPost',
    'paySuccess',
    'payError',
));
$router->boot();

