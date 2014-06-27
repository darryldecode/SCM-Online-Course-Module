<form method="post" action="<?php echo \SCM\Classes\SCMUtility::adminBuildUrl('?page=scmCourseModule&state=Users&action=store'); ?>">
    <div class="course-create">
        <table class="table table-bordered">
            <tr>
                <td colspan="2">
                    <b>USER:</b>
                </td>
            </tr>
            <tr>
                <td>First Name:</td>
                <td><input type="text" name="first_name" value="<?php echo (isset($_POST['first_name'])) ? $_POST['first_name'] : ''; ?>"></td>
            </tr>
            <tr>
                <td>Middle Name:</td>
                <td><input type="text" name="middle_name" value="<?php echo (isset($_POST['middle_name'])) ? $_POST['middle_name'] : ''; ?>"></td>
            </tr>
            <tr>
                <td>Last Name:</td>
                <td><input type="text" name="last_name" value="<?php echo (isset($_POST['last_name'])) ? $_POST['last_name'] : ''; ?>"></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><input type="email" name="email" value="<?php echo (isset($_POST['email'])) ? $_POST['email'] : ''; ?>"></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" name="password" value=""></td>
            </tr>
            <tr>
                <td>Suffix:</td>
                <td><input type="text" name="suffix" value="<?php echo (isset($_POST['suffix'])) ? $_POST['suffix'] : ''; ?>"></td>
            </tr>
            <tr>
                <td>Employers Company Name:</td>
                <td><input type="text" name="employers_company_name" value="<?php echo (isset($_POST['employers_company_name'])) ? $_POST['employers_company_name'] : ''; ?>"></td>
            </tr>
            <tr>
                <td>Home Mailing Adress 1:</td>
                <td><input type="text" name="home_mailing_address_1" value="<?php echo (isset($_POST['home_mailing_address_1'])) ? $_POST['home_mailing_address_1'] : ''; ?>"></td>
            </tr>
            <tr>
                <td>Home Mailing Adress 2:</td>
                <td><input type="text" name="home_mailing_address_2" value="<?php echo (isset($_POST['home_mailing_address_2'])) ? $_POST['home_mailing_address_2'] : ''; ?>"></td>
            </tr>
            <tr>
                <td>City:</td>
                <td><input type="text" name="city" value="<?php echo (isset($_POST['city'])) ? $_POST['city'] : ''; ?>"></td>
            </tr>
            <tr>
                <td>State:</td>
                <td><input type="text" name="state" value="<?php echo (isset($_POST['state'])) ? $_POST['state'] : ''; ?>"></td>
            </tr>
            <tr>
                <td>Zip Code:</td>
                <td><input type="text" name="zip_code" value="<?php echo (isset($_POST['zip_code'])) ? $_POST['zip_code'] : ''; ?>"></td>
            </tr>
            <tr>
                <td>Personal Cell Number:</td>
                <td><input type="text" name="personal_cell_number" value="<?php echo (isset($_POST['personal_cell_number'])) ? $_POST['personal_cell_number'] : ''; ?>"></td>
            </tr>
            <tr>
                <td colspan="2" class="text-right">
                    <input type="submit" value="Create User" class="btn btn-success">
                    <input type="hidden" name="_nonce" value="<?php echo \SCM\Classes\SCMUtility::generateNonce(); ?>">
                </td>
            </tr>
        </table>
    </div>
</form>