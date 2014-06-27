<?php

if( ! function_exists('scmFrontMainPage') ) :

function scmFrontMainPage()
{
    ?>
    <!-- sorry for being slappy, just for now ! :-) -->

    <!-- Latest compiled and minified CSS -->
    <?php if( \SCM\Model\Settings::isUseBuiltInCSSEnabled() ): ?>
        <link rel="stylesheet" href="<?php echo SCM_URI_CSS.'bootstrap.min.css'; ?>">
    <?php endif; ?>

    <!-- scmFrontWrapper -->
    <div class="scm" id="scmFrontWrapper">

        <!-- main page display -->
        <div class="panel panel-default">

            <!-- title -->
            <div class="panel-heading">
                <h3 class="panel-title">
                    <?php echo \SCM\Model\Settings::getCompanyName(); ?>
                </h3>
            </div>

            <!-- body -->
            <div class="panel-body">

                <!-- master navigation -->
                <div id="mainNavWrapper">
                    <div class="btn-group">
                        <a href="?page=scmCourseModule&state=Front&action=index" type="button" class="btn btn-default">
                            <span class="glyphicon glyphicon-book"></span> See All Courses
                        </a>
                        <a href="?page=scmCourseModule&state=Front&action=myAccount" type="button" class="btn btn-default">
                            <span class="glyphicon glyphicon-user"></span> My Account <?php if(\SCM\Model\Session::isLoggedIn()){ $scmUserName = \SCM\Model\Session::getCurrentUserName(); echo "(Welcome: {$scmUserName})"; } ?>
                        </a>
                    </div>
                </div>

                <!-- global alert -->
                <?php if( \SCM\Classes\SCMUtility::hasFlashMessage() ): ?>
                    <div class="alert alert-<?php echo \SCM\Classes\SCMUtility::getFlashMessageMode(); ?> text-center">
                        <h4><?php echo \SCM\Classes\SCMUtility::getFlashMessage(); ?></h4>
                    </div>
                <?php endif; ?>

                <!-- dynamic view -->
                <div class="panel panel-default" id="dynamicView">
                    <div class="panel-body">

                        <?php SCM\Classes\View::render(); ?>

                    </div>
                </div>

            </div>

        </div>

    </div>



<?php
}

endif; //end function_exists