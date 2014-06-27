<form method="post" action="<?php echo \SCM\Classes\SCMUtility::frontBuildURL('?page=scmCourseModule&state=Front&action=updatePassword'); ?>">
    <table class="table">
        <tr>
            <td colspan="2"><b><span class="glyphicon glyphicon-lock"></span> Change Password:</b></td>
        </tr>
        <tr>
            <td>Current Password:</td>
            <td><input type="password" name="current_password" class="form-control"></td>
        </tr>
        <tr>
            <td>New Password:</td>
            <td><input type="password" name="new_password" class="form-control"></td>
        </tr>
        <tr>
            <td colspan="2" class="text-right">
                <button class="btn btn-primary pull-right">
                    <span class="glyphicon glyphicon-check"></span> Update Password
                </button>
                <input type="hidden" name="_nonce" value="<?php echo \SCM\Classes\SCMUtility::generateNonce(); ?>">
            </td>
        </tr>
    </table>
</form>
