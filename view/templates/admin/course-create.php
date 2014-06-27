<form method="post" action="<?php echo \SCM\Classes\SCMUtility::adminBuildUrl('?page=scmCourseModule&state=Course&action=store'); ?>">
    <div class="course-create">
        <table class="table table-bordered">
            <tr>
                <td colspan="2">
                    <b>COURSE INFO</b>
                </td>
            </tr>
            <tr>
                <td>Course Name:</td>
                <td><input type="text" name="name" value="<?php echo (isset($_POST['name'])) ? $_POST['name'] : ''; ?>" class="form-control"></td>
            </tr>
            <tr>
                <td>Course Description:</td>
                <td><textarea name="description" class="form-control"><?php echo (isset($_POST['description'])) ? $_POST['description'] : ''; ?></textarea></td>
            </tr>
            <tr>
                <td colspan="2">
                    <b>COURSE META INFO</b>
                </td>
            </tr>
            <tr>
                <td>Location:</td>
                <td><input type="text" name="location" value="<?php echo (isset($_POST['location'])) ? $_POST['location'] : ''; ?>" class="form-control"></td>
            </tr>
            <tr>
                <td>Dates:</td>
                <td><input type="text" name="dates" value="<?php echo (isset($_POST['dates'])) ? $_POST['dates'] : ''; ?>" class="form-control"></td>
            </tr>
            <tr>
                <td>Times/Sessions:</td>
                <td><input type="text" name="times" value="<?php echo (isset($_POST['times'])) ? $_POST['times'] : ''; ?>" class="form-control"></td>
            </tr>
            <tr>
                <td>Fee:</td>
                <td><input type="number" name="fee" value="<?php echo (isset($_POST['fee'])) ? $_POST['fee'] : ''; ?>" class="form-control"></td>
            </tr>
            <tr>
                <td>Premium?</td>
                <td><input type="checkbox" name="premium" <?php echo (isset($_POST['premium'])) ? 'checked' : ''; ?>></td>
            </tr>
            <tr>
                <td>Registration End Date:</td>
                <td><input type="text" name="registration_end_date" value="<?php echo (isset($_POST['registration_end_date'])) ? $_POST['registration_end_date'] : ''; ?>" class="form-control forDate"></td>
            </tr>
            <tr>
                <td colspan="2" class="text-right">
                    <input type="submit" value="Create Course" class="btn btn-success">
                    <input type="hidden" name="_nonce" value="<?php echo \SCM\Classes\SCMUtility::generateNonce(); ?>">
                </td>
            </tr>
        </table>
    </div>
</form>
