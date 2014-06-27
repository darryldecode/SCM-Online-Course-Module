<form method="post" action="<?php echo \SCM\Classes\SCMUtility::frontBuildURL('?page=scmCourseModule&state=Front&action=doResetPassword'); ?>">
    <table class="table">
        <tr>
            <td colspan="2"><b><span class="glyphicon glyphicon-lock"></span> Reset Password:</b></td>
        </tr>
        <tr>
            <td>Enter New Password:</td>
            <td><input type="password" name="new_reset_password" class="form-control"></td>
        </tr>
        <tr>
            <td colspan="2" class="text-right">
                <button class="btn btn-primary pull-right">
                    <span class="glyphicon glyphicon-check"></span> Reset Password
                </button>
                <input type="hidden" name="_nonce" value="<?php echo \SCM\Classes\SCMUtility::generateNonce(); ?>">
                <input type="hidden" name="userID" value="<?php echo $scmData['userID']; ?>">
            </td>
        </tr>
    </table>
</form>
