<div class="course-create">
    <table class="table table-bordered">
        <tr>
            <td colspan="2">
                <b>COURSE INFO</b>
                <a href="?page=scmCourseModule&state=Course&action=index" class="btn btn-default pull-right"><span class="glyphicon glyphicon-arrow-left"></span> Back to courses</a>
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
            <td>$<?php echo $scmData['data']['fee']; ?></td>
        </tr>
        <tr>
            <td>Premium:</td>
            <td><?php echo ($scmData['data']['premium']==1) ? 'Premium' : 'Free'; ?></td>
        </tr>
        <tr>
            <td>Registration End Date:</td>
            <td><?php echo \SCM\Classes\SCMUtility::toReadableDateFormat($scmData['data']['registration_end_date']); ?></td>
        </tr>
    </table>

    <!-- students -->
    <ul class="list-group">

        <li class="list-group-item active">
            <b><span class="glyphicon glyphicon-user"></span> STUDENTS IN THIS COURSE:</b>
        </li>

        <li class="list-group-item">
            <ul class="list-group">
                <?php foreach($scmData['data']['students'] as $student): ?>
                    <li class="list-group-item clearfix">
                        <a href="?page=scmCourseModule&state=Users&action=show&studentID=<?php echo $student['id']; ?>">
                            <span class="glyphicon glyphicon-user"></span> <?php echo $student['first_name'].' '.$student['middle_name'].' '.$student['last_name']; ?>
                        </a>
                        <form method="post" class="pull-right" action="<?php echo \SCM\Classes\SCMUtility::adminBuildUrl('?page=scmCourseModule&state=Course&action=removeStudent'); ?>">
                            <button class="btn btn-sm btn-danger">
                                <span class="glyphicon glyphicon-remove-circle"></span> Remove user on this course
                            </button>
                            <input type="hidden" name="_nonce" value="<?php echo \SCM\Classes\SCMUtility::generateNonce(); ?>">
                            <input type="hidden" name="studentID" value="<?php echo $student['id']; ?>">
                            <input type="hidden" name="courseID" value="<?php echo $scmData['data']['id']; ?>">
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        </li>

        <?php if(count($scmData['data']['students'])==0): ?>
        <li class="list-group-item">
            <div class="well well-lg text-center">
                No enrolled students yet..
            </div>
        </li>
        <?php endif; ?>

    </ul>

</div>
