<!-- students -->
<div class="clearfix text-right button-wide-holder">
    <a href="?page=scmCourseModule&state=Users&action=create" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span> ADD NEW USER</a>
</div>

<!-- main user info table lists -->
<table class="table table-bordered table-striped">

    <tr>
        <td>First Name:</td>
        <td>M. Name:</td>
        <td>Last Name:</td>
        <td>Suffix:</td>
        <td>Email:</td>
        <td class="text-center"><b>USER ADDITIONAL DATA:</b></td>
    </tr>

    <?php $x = 0; foreach($scmData['data'] as $students): ?>
        <tr>
            <td><?php echo $students['first_name']; ?></td>
            <td><?php echo $students['middle_name']; ?></td>
            <td><?php echo $students['last_name']; ?></td>
            <td><?php echo $students['suffix']; ?></td>
            <td><?php echo $students['email']; ?></td>
            <td class="userMoreInfoData">
                <div class="panel panel-default">
                    <div class="panel-body">

                        <!-- view additional info button -->
                        <div class="clearfix text-center">
                            <form method="post" action="<?php echo \SCM\Classes\SCMUtility::adminBuildUrl('?page=scmCourseModule&state=Users&action=delete'); ?>">
                                <div class="btn-group">
                                    <a onclick="$('#userAdditionalInfoTable<?php echo $x; ?>').slideToggle()" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-search"></span> Quick info</a>
                                    <a href="?page=scmCourseModule&state=Users&action=show&studentID=<?php echo $students['id']; ?>" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-eye-open"></span> View</a>
                                    <button type="submit" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete</button>
                                </div>
                            <input type="hidden" name="_nonce" value="<?php echo \SCM\Classes\SCMUtility::generateNonce(); ?>">
                            <input type="hidden" name="studentID" value="<?php echo $students['id']; ?>">
                            </form>
                        </div>

                        <!-- additional info table -->
                        <table id="userAdditionalInfoTable<?php echo $x; ?>" class="table userAdditionalInfoTable">
                            <tr>
                                <td>Employer Company Name:</td>
                                <td><?php echo $students['employers_company_name']; ?></td>
                            </tr>
                            <tr>
                                <td>Home Mailing Address 1:</td>
                                <td><?php echo $students['home_mailing_address_1']; ?></td>
                            </tr>
                            <tr>
                                <td>Home Mailing Address 2:</td>
                                <td><?php echo $students['home_mailing_address_2']; ?></td>
                            </tr>
                            <tr>
                                <td>City:</td>
                                <td><?php echo $students['city']; ?></td>
                            </tr>
                            <tr>
                                <td>State:</td>
                                <td><?php echo $students['state']; ?></td>
                            </tr>
                            <tr>
                                <td>ZIP CODE:</td>
                                <td><?php echo $students['zip_code']; ?></td>
                            </tr>
                            <tr>
                                <td>Contact Number:</td>
                                <td><?php echo $students['personal_cell_number']; ?></td>
                            </tr>
                            <tr>
                                <td>Total Courses Enrolled:</td>
                                <td><span class="badge"><?php echo count($students['courses']); ?></span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </td>
        </tr>
    <?php $x++; endforeach; ?>

    <?php if(count($scmData['data'])==0): ?>
        <tr>
            <td colspan="6">
                <div class="well well-lg text-center">
                    No Students/Users yet..
                </div>
            </td>
        </tr>
    <?php endif; ?>

</table>