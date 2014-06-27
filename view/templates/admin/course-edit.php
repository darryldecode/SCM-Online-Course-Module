<form method="post" action="<?php echo \SCM\Classes\SCMUtility::adminBuildUrl('?page=scmCourseModule&state=Course&action=update'); ?>">
    <div class="course-create">
        <table class="table table-bordered">
            <tr>
                <td colspan="2">
                    <b>COURSE INFO</b>
                </td>
            </tr>
            <tr>
                <td>Course Name:</td>
                <td><input type="text" name="name" value="<?php echo $scmData['data']['name']; ?>" class="form-control"></td>
            </tr>
            <tr>
                <td>Course Description:</td>
                <td><textarea name="description" class="form-control"><?php echo $scmData['data']['description']; ?></textarea></td>
            </tr>
            <tr>
                <td colspan="2">
                    <b>COURSE META INFO</b>
                </td>
            </tr>
            <tr>
                <td>Location:</td>
                <td><input type="text" name="location" value="<?php echo $scmData['data']['location']; ?>" class="form-control"></td>
            </tr>
            <tr>
                <td>Dates:</td>
                <td><input type="text" name="dates" value="<?php echo $scmData['data']['dates']; ?>" class="form-control"></td>
            </tr>
            <tr>
                <td>Times/Sessions:</td>
                <td><input type="text" name="times" value="<?php echo $scmData['data']['times']; ?>" class="form-control"></td>
            </tr>
            <tr>
                <td>Fee:</td>
                <td><input type="number" name="fee" value="<?php echo $scmData['data']['fee']; ?>" class="form-control"></td>
            </tr>
            <tr>
                <td>Premium?</td>
                <td><input type="checkbox" name="premium" <?php echo ($scmData['data']['premium']==true) ? 'checked' : ''; ?>></td>
            </tr>
            <tr>
                <td>Registration End Date:</td>
                <td><input type="text" name="registration_end_date" value="<?php echo $scmData['data']['registration_end_date']; ?>" class="form-control forDate"></td>
            </tr>
            <tr>
                <td colspan="2" class="text-right">
                    <input type="submit" value="Update" class="btn btn-success">
                    <input type="hidden" name="_nonce" value="<?php echo \SCM\Classes\SCMUtility::generateNonce(); ?>">
                    <input type="hidden" name="courseID" value="<?php echo $scmData['data']['id']; ?>">
                </td>
            </tr>
        </table>
    </div>
</form>
