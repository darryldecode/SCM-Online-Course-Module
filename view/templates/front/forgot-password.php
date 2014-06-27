<form method="post" action="<?php echo \SCM\Classes\SCMUtility::frontBuildURL('?page=scmCourseModule&state=Front&action=resetPasswordSendEmail'); ?>">
    <table class="table">
        <tr>
            <td colspan="2">
                <div class="alert alert-info">
                    Please enter you email address. We will send you a link so you can reset your password.
                    Please do not close this browser during the process.
                </div>
            </td>
        </tr>
        <tr>
            <td>Email Address:</td>
            <td><input type="email" name="forgot_password_email" class="form-control" placeholder="email.."></td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" value="Reset Password" class="btn btn-sm btn-info pull-right">
                <input type="hidden" name="_nonce" value="<?php echo \SCM\Classes\SCMUtility::generateNonce(); ?>">
            </td>
        </tr>
    </table>
</form>