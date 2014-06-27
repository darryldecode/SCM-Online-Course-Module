<!-- Nav tabs -->
<ul id="settingsTabs" class="nav nav-tabs">
    <li class="active"><a id="mainOpen" href="#systemSettings" data-toggle="tab">System Settings</a></li>
    <li><a href="#payPalAdvancedSettings" data-toggle="tab">PayPal Advanced</a></li>
    <li><a href="#payPalExpressSettings" data-toggle="tab">PayPal Express</a></li>
    <li><a href="#smtpSettings" data-toggle="tab">SMTP Settings</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">

    <!-- system settings tab -->
    <div class="tab-pane active" id="systemSettings">
        <form method="post" action="<?php echo \SCM\Classes\SCMUtility::adminBuildUrl('?page=scmCourseModule&state=Settings&action=updateSystemSettings'); ?>">
            <table class="table table-bordered">
                <tr>
                    <td colspan="2"><b>SYSTEM SETTINGS</b></td>
                </tr>
                <tr>
                    <td>
                        Use built-in CSS?:
                        <br> <small>(By default this uses Twitter Bootstrap)</small>
                    </td>
                    <td>
                        <select name="scm_use_app_style">
                            <option <?php echo ($scmData['scm_settings']['scm_use_app_style'] == 1) ? 'selected' : ''; ?> value="1">yes</option>
                            <option <?php echo ($scmData['scm_settings']['scm_use_app_style'] == 0) ? 'selected' : ''; ?> value="0">no</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        Company Name:
                        <br> <small>(This will be use for emails and also in front end.)</small>
                    </td>
                    <td>
                        <input type="text" name="scm_company_name" value="<?php echo $scmData['scm_settings']['scm_company_name']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        Front Page Course URL:
                        <br> <small>(please follow the format properly.)</small>
                    </td>
                    <td>
                        <input type="text" name="scm_front_page_url" value="<?php echo $scmData['scm_settings']['scm_front_page_url']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        Safe Mode:
                        <br> <small><span class="glyphicon glyphicon-exclamation-sign"></span> (Warning! Disabling this will totally reset all database records during plugin deactivation of this module.)</small>
                    </td>
                    <td>
                        <select name="scm_safe_mode">
                            <option <?php echo ($scmData['scm_settings']['scm_safe_mode'] == 'enabled') ? 'selected' : ''; ?> value="enabled">enabled</option>
                            <option <?php echo ($scmData['scm_settings']['scm_safe_mode'] == 'disabled') ? 'selected' : ''; ?> value="disabled">disabled</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        System Debug Mode:
                        <br> <small>(This will throw informational errors on frontend. Enable only in development.)</small>
                    </td>
                    <td>
                        <select name="scm_debug_mode">
                            <option <?php echo ($scmData['scm_settings']['scm_debug_mode'] == 1) ? 'selected' : ''; ?> value="1">enabled</option>
                            <option <?php echo ($scmData['scm_settings']['scm_debug_mode'] == 0) ? 'selected' : ''; ?> value="0">disabled</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>System Log PayPal Transactions:</td>
                    <td>
                        <select name="scm_log_paypal_response">
                            <option <?php echo ($scmData['scm_settings']['scm_log_paypal_response'] == 1) ? 'selected' : ''; ?> value="1">enabled</option>
                            <option <?php echo ($scmData['scm_settings']['scm_log_paypal_response'] == 0) ? 'selected' : ''; ?> value="0">disabled</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        Active PayPal Payment Gateway:
                        <br> <small>(Choose you paypal gateway to handle payments. You will need to set PayPal settings below according to what you choose here.)</small>
                    </td>
                    <td>
                        <select name="scm_active_payment_gateway">
                            <?php foreach($scmData['scm_gateway_options'] as $pp_gateway_options): ?>
                                <option <?php echo ($scmData['scm_settings']['scm_active_payment_gateway'] == $pp_gateway_options) ? 'selected' : ''; ?> value="<?php echo $pp_gateway_options; ?>">
                                    <?php echo $pp_gateway_options; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        Admin Email:
                        <br> <small>(Emails for this module activities will send here.)</small>
                    </td>
                    <td>
                        <input type="text" name="scm_admin_email" value="<?php echo $scmData['scm_settings']['scm_admin_email']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        Email Engine:
                        <br> <small>(IF you choose SMTP, you will need to configure the SMTP settings below.)</small>
                    </td>
                    <td>
                        <select name="scm_mailer_engine">
                            <?php foreach($scmData['scm_mailer_engine_options'] as $mailer_engine_options): ?>
                                <option <?php echo ($scmData['scm_settings']['scm_mailer_engine'] == $mailer_engine_options) ? 'selected' : ''; ?> value="<?php echo $mailer_engine_options; ?>">
                                    <?php echo $mailer_engine_options; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-right">
                        <input type="submit" value="update" class="btn btn-primary">
                        <input type="hidden" name="_nonce" value="<?php echo wp_create_nonce('scm_nonce') ?>">
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <!-- paypal advanced settings tab -->
    <div class="tab-pane" id="payPalAdvancedSettings">
        <form method="post" action="<?php echo \SCM\Classes\SCMUtility::adminBuildUrl('?page=scmCourseModule&state=Settings&action=updatePayPalAdvancedSettings'); ?>">
            <table class="table table-bordered">
                <tr>
                    <td colspan="2"><b>PAYPAL ADVANCED SETTINGS (Configure this if you choose PayPal Advance as your Active PayPal Payment Gateway.)</b></td>
                </tr>
                <tr>
                    <td>MODE:</td>
                    <td>
                        <select name="mode">
                            <option <?php echo ($scmData['scm_paypal_advanced_settings']['mode'] == 'sandbox') ? 'selected' : ''; ?> value="sandbox">sandbox</option>
                            <option <?php echo ($scmData['scm_paypal_advanced_settings']['mode'] == 'live') ? 'selected' : ''; ?> value="live">live</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>CURRENCY:</td>
                    <td>
                        <input type="text" name="currency" value="<?php echo $scmData['scm_paypal_advanced_settings']['currency']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>USER:</td>
                    <td>
                        <input type="text" name="user" value="<?php echo $scmData['scm_paypal_advanced_settings']['user']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>VENDOR:</td>
                    <td>
                        <input type="text" name="vendor" value="<?php echo $scmData['scm_paypal_advanced_settings']['vendor']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>PARTNER:</td>
                    <td>
                        <input type="text" name="partner" value="<?php echo $scmData['scm_paypal_advanced_settings']['partner']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>PWD:</td>
                    <td>
                        <input type="password" name="pwd" value="<?php echo $scmData['scm_paypal_advanced_settings']['pwd']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>CREATE SECURE TOKEN:</td>
                    <td>
                        <select name="create_secure_token">
                            <option <?php echo ($scmData['scm_paypal_advanced_settings']['create_secure_token'] == 'Y') ? 'selected' : ''; ?> value="Y">Y</option>
                            <option <?php echo ($scmData['scm_paypal_advanced_settings']['create_secure_token'] == 'N') ? 'selected' : ''; ?> value="N">N</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>TRXTYPE:</td>
                    <td>
                        <select name="trxtype">
                            <option <?php echo ($scmData['scm_paypal_advanced_settings']['trxtype'] == 'S') ? 'selected' : ''; ?> value="S">S</option>
                            <option <?php echo ($scmData['scm_paypal_advanced_settings']['trxtype'] == 'A') ? 'selected' : ''; ?> value="A">A</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-right">
                        <input type="submit" value="update" class="btn btn-primary">
                        <input type="hidden" name="_nonce" value="<?php echo wp_create_nonce('scm_nonce') ?>">
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <!-- paypal express settings tab -->
    <div class="tab-pane" id="payPalExpressSettings">
        <form method="post" action="<?php echo \SCM\Classes\SCMUtility::adminBuildUrl('?page=scmCourseModule&state=Settings&action=updatePayPalExpressSettings'); ?>">
            <table class="table table-bordered">
                <tr>
                    <td colspan="2"><b>PAYPAL EXPRESS SETTINGS (Configure this if you choose PayPal Express Checkout as your Active PayPal Payment Gateway.)</b></td>
                </tr>
                <tr>
                    <td>MODE:</td>
                    <td>
                        <select name="mode">
                            <option <?php echo ($scmData['scm_paypal_express_settings']['mode'] == 'sandbox') ? 'selected' : ''; ?> value="sandbox">sandbox</option>
                            <option <?php echo ($scmData['scm_paypal_express_settings']['mode'] == 'live') ? 'selected' : ''; ?> value="live">live</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>CURRENCY:</td>
                    <td>
                        <input type="text" name="currency" value="<?php echo $scmData['scm_paypal_express_settings']['currency']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>USER:</td>
                    <td>
                        <input type="text" name="user" value="<?php echo $scmData['scm_paypal_express_settings']['user']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>PWD:</td>
                    <td>
                        <input type="password" name="pwd" value="<?php echo $scmData['scm_paypal_express_settings']['pwd']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>SIGNATURE:</td>
                    <td>
                        <input type="text" name="signature" value="<?php echo $scmData['scm_paypal_express_settings']['signature']; ?>">
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-right">
                        <input type="submit" value="update" class="btn btn-primary">
                        <input type="hidden" name="_nonce" value="<?php echo wp_create_nonce('scm_nonce') ?>">
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <!-- SMTP settings tab -->
    <div class="tab-pane" id="smtpSettings">
        <form method="post" action="<?php echo \SCM\Classes\SCMUtility::adminBuildUrl('?page=scmCourseModule&state=Settings&action=updateSMTPSettings'); ?>">
            <table class="table table-bordered">
                <tr>
                    <td colspan="2"><b>SMTP SETTINGS (Configure this if you choose SMTP as your mail engine.)</b></td>
                </tr>
                <tr>
                    <td>Host:</td>
                    <td>
                        <input type="text" name="host" value="<?php echo $scmData['scm_smtp_settings']['host']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Port:</td>
                    <td>
                        <input type="text" name="port" value="<?php echo $scmData['scm_smtp_settings']['port']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td>
                        <input type="text" name="username" value="<?php echo $scmData['scm_smtp_settings']['username']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td>
                        <input type="password" name="password" value="<?php echo $scmData['scm_smtp_settings']['password']; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Encryption:</td>
                    <td>
                        <input type="text" name="encryption" value="<?php echo $scmData['scm_smtp_settings']['encryption']; ?>">
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-right">
                        <input type="submit" value="update" class="btn btn-primary">
                        <input type="hidden" name="_nonce" value="<?php echo wp_create_nonce('scm_nonce') ?>">
                    </td>
                </tr>
            </table>
        </form>
    </div>

</div>