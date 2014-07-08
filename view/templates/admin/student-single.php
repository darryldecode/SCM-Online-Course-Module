<div class="course-create">
    <table class="table table-bordered">
        <tr>
            <td colspan="2">
                <b>USER:</b>
                <a href="?page=scmCourseModule&state=Users&action=edit&studentID=<?php echo $scmData['user']['id']; ?>" class="btn btn-sm btn-warning pull-right"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
            </td>
        </tr>
        <tr>
            <td>First Name:</td>
            <td><?php echo (isset($scmData['user']['first_name'])) ? $scmData['user']['first_name'] : ''; ?></td>
        </tr>
        <tr>
            <td>Middle Initial:</td>
            <td><?php echo (isset($scmData['user']['middle_name'])) ? $scmData['user']['middle_name'] : ''; ?></td>
        </tr>
        <tr>
            <td>Last Name:</td>
            <td><?php echo (isset($scmData['user']['last_name'])) ? $scmData['user']['last_name'] : ''; ?></td>
        </tr>
        <tr>
            <td>Suffix:</td>
            <td><?php echo (isset($scmData['user']['suffix'])) ? $scmData['user']['suffix'] : ''; ?></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><?php echo (isset($scmData['user']['email'])) ? $scmData['user']['email'] : ''; ?></td>
        </tr>
        <tr>
            <td>Employer's Company Name:</td>
            <td><?php echo (isset($scmData['user']['employers_company_name'])) ? $scmData['user']['employers_company_name'] : ''; ?></td>
        </tr>
        <tr>
            <td>Home Mailing Adress 1:</td>
            <td><?php echo (isset($scmData['user']['home_mailing_address_1'])) ? $scmData['user']['home_mailing_address_1'] : ''; ?></td>
        </tr>
        <tr>
            <td>Home Mailing Adress 2:</td>
            <td><?php echo (isset($scmData['user']['home_mailing_address_2'])) ? $scmData['user']['home_mailing_address_2'] : ''; ?></td>
        </tr>
        <tr>
            <td>City:</td>
            <td><?php echo (isset($scmData['user']['city'])) ? $scmData['user']['city'] : ''; ?></td>
        </tr>
        <tr>
            <td>State:</td>
            <td><?php echo (isset($scmData['user']['state'])) ? $scmData['user']['state'] : ''; ?></td>
        </tr>
        <tr>
            <td>Zip Code:</td>
            <td><?php echo (isset($scmData['user']['zip_code'])) ? $scmData['user']['zip_code'] : ''; ?></td>
        </tr>
        <tr>
            <td>Personal Cell Number:</td>
            <td><?php echo (isset($scmData['user']['personal_cell_number'])) ? $scmData['user']['personal_cell_number'] : ''; ?></td>
        </tr>
        <tr>
            <td>Total Enrolled Courses:</td>
            <td>
                <span class="badge"><?php echo (isset($scmData['user']['personal_cell_number'])) ? count($scmData['user']['courses']) : ''; ?></span>
            </td>
        </tr>
    </table>

    <!-- Enrolled Courses -->
    <div class="list-group text-left">
        <a href="#" class="list-group-item active">
            <span class="glyphicon glyphicon-book"></span> ENROLLED COURSES
        </a>

        <?php if(empty($scmData['user']['courses'])): ?>
            <a class="list-group-item">
                <div class="well text-center">
                    No courses enrolled.
                </div>
            </a>
        <?php else: ?>
            <?php foreach($scmData['user']['courses'] as $course): ?>
                <a href="?page=scmCourseModule&state=Course&action=show&courseID=<?php echo $course['id']; ?>" class="list-group-item">

                    <?php echo $course['name']; ?>

                    <?php if($course['premium']==1): ?>

                        <?php if($course['payment'][0]['paid']==0): ?>
                            <span class="label label-warning pull-right">
                                <span class="glyphicon glyphicon-time"></span> Waiting For Confirmation
                            </span>
                        <?php else: ?>
                            <span class="label label-primary pull-right">
                                <span class="glyphicon glyphicon-thumbs-up"></span> Confirmed
                            </span>
                        <?php endif; ?>

                    <?php else: ?>

                        <span class="label label-primary pull-right">
                            <span class="glyphicon glyphicon-thumbs-up"></span> Free Course
                        </span>

                    <?php endif; ?>

                </a>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>

</div>