<div class="course-create">
    <table class="table table-bordered">
        <tr>
            <td colspan="2">

                <b>COURSE INFO</b>

                <form method="post" action="<?php echo \SCM\Classes\SCMUtility::frontBuildURL('?page=scmCourseModule&state=Payment&action=registerOnCourse'); ?>">
                    <div class="btn-group pull-right">
                        <a href="?page=scmCourseModule&state=Front&action=index" class="btn btn-default">
                            <span class="glyphicon glyphicon-arrow-left"></span> Back to courses
                        </a>
                        <button class="btn btn-success">
                            <span class="glyphicon glyphicon-briefcase"></span> Enroll in this course
                        </button>
                    </div>
                    <input type="hidden" name="_nonce" value="<?php echo \SCM\Classes\SCMUtility::generateNonce(); ?>">
                    <input type="hidden" name="courseID" value="<?php echo $scmData['data']['id']; ?>">
                </form>

            </td>
        </tr>
        <tr>
            <td>Course Name:</td>
            <td><?php echo $scmData['data']['name']; ?></td>
        </tr>
        <tr>
            <td>Course Description:</td>
            <td><?php echo $scmData['data']['description']; ?></td>
        </tr>
        <tr>
            <td colspan="2">
                <b>COURSE META INFO</b>
            </td>
        </tr>
        <tr>
            <td>Location:</td>
            <td><?php echo $scmData['data']['location']; ?></td>
        </tr>
        <tr>
            <td>Dates:</td>
            <td><?php echo $scmData['data']['dates']; ?></td>
        </tr>
        <tr>
            <td>Times/Sessions:</td>
            <td><?php echo $scmData['data']['times']; ?></td>
        </tr>
        <tr>
            <td>Fee:</td>
            <td><?php echo ($scmData['data']['premium']==1) ? '$'.$scmData['data']['fee'] : 'Free'; ?></td>
        </tr>
        <tr>
            <td>Registration End Date:</td>
            <td><?php echo \SCM\Classes\SCMUtility::toReadableDateFormat($scmData['data']['registration_end_date']); ?></td>
        </tr>
    </table>
</div>
