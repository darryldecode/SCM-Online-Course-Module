<div class="row">

    <!-- login form -->
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div id="scmLoginFormWrapper" class="clearfix text-left">

            <h1 class="text-center login-title">LOGIN</h1>

            <form method="post" action="<?php echo \SCM\Classes\SCMUtility::frontBuildURL('?page=scmCourseModule&state=Front&action=login'); ?>">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password <a href="?page=scmCourseModule&state=Front&action=forgotPassword">(forgot password)</a></label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-sm btn-primary pull-left">Sign in</button>
                <input type="hidden" name="_nonce" value="<?php echo \SCM\Classes\SCMUtility::generateNonce(); ?>">
            </form>

        </div>
    </div>

    <!-- register form -->
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div id="scmRegisterFormWrapper" class="clearfix text-left">

            <h1 class="text-center login-title">REGISTER</h1>

            <form method="post" action="<?php echo \SCM\Classes\SCMUtility::frontBuildURL('?page=scmCourseModule&state=Front&action=register'); ?>">
                <div class="form-group">
                    <label>First Name:</label>
                    <input type="text" name="first_name" value="<?php echo (isset($_POST['first_name'])) ? $_POST['first_name'] : ''; ?>" class="form-control" placeholder="First Name">
                </div>
                <div class="form-group">
                    <label>Middle Initial:</label>
                    <input type="text" name="middle_name" value="<?php echo (isset($_POST['middle_name'])) ? $_POST['middle_name'] : ''; ?>" class="form-control" placeholder="Middle Initial">
                </div>
                <div class="form-group">
                    <label>Last Name:</label>
                    <input type="text" name="last_name" value="<?php echo (isset($_POST['last_name'])) ? $_POST['last_name'] : ''; ?>" class="form-control" placeholder="Last Name">
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="text" name="email" value="<?php echo (isset($_POST['email'])) ? $_POST['email'] : ''; ?>" class="form-control" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label>Password:</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter Password">
                </div>
                <div class="form-group">
                    <label>Suffix:</label>
                    <input type="text" name="suffix" value="<?php echo (isset($_POST['suffix'])) ? $_POST['suffix'] : ''; ?>" class="form-control" placeholder="Suffix">
                </div>
                <div class="form-group">
                    <label>Company Name:</label>
                    <input type="text" name="employers_company_name" value="<?php echo (isset($_POST['employers_company_name'])) ? $_POST['employers_company_name'] : ''; ?>" class="form-control" placeholder="Company Name">
                </div>
                <div class="form-group">
                    <label>Mailing Address 1:</label>
                    <input type="text" name="home_mailing_address_1" value="<?php echo (isset($_POST['home_mailing_address_1'])) ? $_POST['home_mailing_address_1'] : ''; ?>" class="form-control" placeholder="Mailing Address 1">
                </div>
                <div class="form-group">
                    <label>Mailing Address 2:</label>
                    <input type="text" name="home_mailing_address_2" value="<?php echo (isset($_POST['home_mailing_address_2'])) ? $_POST['home_mailing_address_2'] : ''; ?>" class="form-control" placeholder="Mailing Address 2">
                </div>
                <div class="form-group">
                    <label>City:</label>
                    <input type="text" name="city" value="<?php echo (isset($_POST['city'])) ? $_POST['city'] : ''; ?>" class="form-control" placeholder="City">
                </div>
                <div class="form-group">
                    <label>State:</label>
                    <input type="text" name="state" value="<?php echo (isset($_POST['state'])) ? $_POST['state'] : ''; ?>" class="form-control" placeholder="State">
                </div>
                <div class="form-group">
                    <label>ZIP Code:</label>
                    <input type="text" name="zip_code" value="<?php echo (isset($_POST['zip_code'])) ? $_POST['zip_code'] : ''; ?>" class="form-control" placeholder="ZIP Code">
                </div>
                <div class="form-group">
                    <label>Phone Number:</label>
                    <input type="number" name="personal_cell_number" value="<?php echo (isset($_POST['personal_cell_number'])) ? $_POST['personal_cell_number'] : ''; ?>" class="form-control" placeholder="Phone Number">
                </div>
                <div class="form-group text-right">
                    <button class="btn btn-success">Register</button>
                </div>
                <input type="hidden" name="_nonce" value="<?php echo \SCM\Classes\SCMUtility::generateNonce(); ?>">
            </form>
        </div>
    </div>

</div>