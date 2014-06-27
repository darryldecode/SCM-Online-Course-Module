<form method="post" action="<?php echo \SCM\Classes\SCMUtility::adminBuildUrl('?page=scmCourseModule&state=Users&action=update'); ?>">
    <div class="course-create">
        <table class="table table-bordered">
            <tr>
                <td colspan="2">
                    <b>USER:</b>
                </td>
            </tr>
            <tr>
                <td>First Name:</td>
                <td><input type="text" name="first_name" value="<?php echo (isset($scmData['data']['first_name'])) ? $scmData['data']['first_name'] : ''; ?>"></td>
            </tr>
            <tr>
                <td>Middle Name:</td>
                <td><input type="text" name="middle_name" value="<?php echo (isset($scmData['data']['middle_name'])) ? $scmData['data']['middle_name'] : ''; ?>"></td>
            </tr>
            <tr>
                <td>Last Name:</td>
                <td><input type="text" name="last_name" value="<?php echo (isset($scmData['data']['last_name'])) ? $scmData['data']['last_name'] : ''; ?>"></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><input type="email" name="email" value="<?php echo (isset($scmData['data']['email'])) ? $scmData['data']['email'] : ''; ?>"></td>
            </tr>
            <tr>
                <td>Suffix:</td>
                <td><input type="text" name="suffix" value="<?php echo (isset($scmData['data']['suffix'])) ? $scmData['data']['suffix'] : ''; ?>"></td>
            </tr>
            <tr>
                <td>Employers Company Name:</td>
                <td><input type="text" name="employers_company_name" value="<?php echo (isset($scmData['data']['employers_company_name'])) ? $scmData['data']['employers_company_name'] : ''; ?>"></td>
            </tr>
            <tr>
                <td>Home Mailing Adress 1:</td>
                <td><input type="text" name="home_mailing_address_1" value="<?php echo (isset($scmData['data']['home_mailing_address_1'])) ? $scmData['data']['home_mailing_address_1'] : ''; ?>"></td>
            </tr>
            <tr>
                <td>Home Mailing Adress 2:</td>
                <td><input type="text" name="home_mailing_address_2" value="<?php echo (isset($scmData['data']['home_mailing_address_2'])) ? $scmData['data']['home_mailing_address_2'] : ''; ?>"></td>
            </tr>
            <tr>
                <td>City:</td>
                <td><input type="text" name="city" value="<?php echo (isset($scmData['data']['city'])) ? $scmData['data']['city'] : ''; ?>"></td>
            </tr>
            <tr>
                <td>State:</td>
                <td><input type="text" name="state" value="<?php echo (isset($scmData['data']['state'])) ? $scmData['data']['state'] : ''; ?>"></td>
            </tr>
            <tr>
                <td>Zip Code:</td>
                <td><input type="text" name="zip_code" value="<?php echo (isset($scmData['data']['zip_code'])) ? $scmData['data']['zip_code'] : ''; ?>"></td>
            </tr>
            <tr>
                <td>Personal Cell Number:</td>
                <td><input type="text" name="personal_cell_number" value="<?php echo (isset($scmData['data']['personal_cell_number'])) ? $scmData['data']['personal_cell_number'] : ''; ?>"></td>
            </tr>
            <tr>
                <td colspan="2" class="text-right">
                    <input type="submit" value="Update User" class="btn btn-success">
                    <input type="hidden" name="_nonce" value="<?php echo \SCM\Classes\SCMUtility::generateNonce(); ?>">
                    <input type="hidden" name="studentID" value="<?php echo $scmData['data']['id']; ?>">
                </td>
            </tr>
        </table>
    </div>
</form>