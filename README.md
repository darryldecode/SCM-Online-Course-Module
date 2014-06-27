# SCM-Online-Course-Module
========================

An online Enrollment System plugin for WordPress that enables you to display you available courses. Your users may browse you courses and signup to enroll on a specific course.
A User will need to pay via PayPal if the course is premium.

###### DASHBOAD PREVIEW
![alt text](https://github.com/darryldecode/SCM-Online-Course-Module/blob/master/resources/img/previews/dashboard.png "Logo Title Text 1")
![alt text](https://github.com/darryldecode/SCM-Online-Course-Module/blob/master/resources/img/previews/admin_course_manage.png "Logo Title Text 1")

### FEATURES!

1.) Totally separate user system so you don't have to worry for your users to mess with your admin dashboard
2.) Supports PayPal Advanced and PayPal Express Payments
3.) Default Mail or SMTP for mail engine options
4.) Manager Courses, Students and Payments on your Dashboard
5.) Uses Twitter Bootstrap as fundamental CSS structure
6.) Uses Composer to manage Dependencies

### REQUIREMENTS!

1.) PHP 5.4 and above

### Installation Guide

------------------------------------------------------------------
STEP 1:

Clone this repository: git@github.com:darryldecode/SCM-Online-Course-Module.git
or download ZIP.

------------------------------------------------------------------
STEP 2:

Open your Git command line and navigate to this plugin directory and do:

`composer install`

######note: if you dont know about composer yet, head-on to: [Composer Website](https://getcomposer.org)

------------------------------------------------------------------
STEP 3:

after the successful installation of dependencies, you will have a new folder "vendor" which has all its dependencies.

now in your CLI, do:

`composer dump-autoload --optimize`

and you should be good to go, zip the directory and head on to you WordPress admin and install plugin and upload this zip.

------------------------------------------------------------------
STEP 4:

Once you have activated the plugin successfully, You may go now to Sky Course Module Tab then go to settings.
Setup things there and before you can have the front end, create first a wordpress page, name it whatever you want
and put shortcode there `[scm]` you must also update the plugin settings > System Settings > then update the (Front Page Course URL:) settings.

------------------------------------------------------------------
STEP 5:

Do several setup on settings page that meets you needs.
