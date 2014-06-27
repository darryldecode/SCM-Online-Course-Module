<?php namespace SCM\Classes;

use Illuminate\Database\Capsule\Manager as Capsule;

class SCMInstaller2 {

    public function createSchema()
    {
        Capsule::schema()->dropIfExists('wp_scm_course');
        Capsule::schema()->create('wp_scm_course', function($table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->string('location');
            $table->string('dates');
            $table->string('times');
            $table->decimal('fee',10,2);
            $table->dateTime('registration_end_date');
            $table->boolean('premium')->default(0);
            $table->timestamps();
        });

        Capsule::schema()->dropIfExists('wp_scm_users');
        Capsule::schema()->create('wp_scm_users', function($table)
        {
            $table->increments('id');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('suffix');
            $table->string('employers_company_name');
            $table->string('home_mailing_address_1');
            $table->string('home_mailing_address_2');
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');
            $table->string('personal_cell_number');
            $table->string('password');
            $table->boolean('blocked')->default(0);
            $table->timestamps();
        });

        Capsule::schema()->dropIfExists('wp_scm_course_users');
        Capsule::schema()->create('wp_scm_course_users', function($table)
        {
            $table->increments('id');
            $table->integer('wp_scm_course_id');
            $table->integer('wp_scm_users_id');
            $table->timestamps();
        });

        Capsule::schema()->dropIfExists('wp_scm_payments');
        Capsule::schema()->create('wp_scm_payments', function($table)
        {
            $table->increments('id');
            $table->string('invoice_id');
            $table->integer('wp_scm_course_id')->unsigned();
            $table->integer('wp_scm_users_id')->unsigned();
            $table->boolean('paid')->default(0);
            $table->timestamps();
        });

        Capsule::schema()->dropIfExists('wp_scm_payments_transactions_data');
        Capsule::schema()->create('wp_scm_payments_transactions_data', function($table)
        {
            $table->increments('id');
            $table->integer('wp_scm_payment_id')->unsigned();
            $table->string('key');
            $table->string('value');
            $table->timestamps();
        });

        Capsule::Schema()->table('wp_scm_payments_transactions_data', function($table)
        {
            $table->foreign('wp_scm_payment_id')
                ->references('id')
                ->on('wp_scm_payments')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

    }

    public function dropSchema()
    {
        // must be on order for constraints workaround!
        Capsule::schema()->dropIfExists('wp_scm_course');
        Capsule::schema()->dropIfExists('wp_scm_users');
        Capsule::schema()->dropIfExists('wp_scm_course_users');
        Capsule::schema()->dropIfExists('wp_scm_payments_transactions_data');
        Capsule::schema()->dropIfExists('wp_scm_payments');
    }

    public function setOptions()
    {
        $options = array(
            'scm_paypal_advanced_settings' => array(
                'mode' => 'sandbox',
                'currency' => 'USD',
                'user' => '',
                'vendor' => '',
                'partner' => '',
                'pwd' => '',
                'create_secure_token' => 'Y',
                'trxtype' => 'S',
            ),
            'scm_paypal_express_settings' => array(
                'mode' => 'sandbox',
                'currency' => 'USD',
                'user' => '',
                'pwd' => '',
                'signature' => '',
            ),
            'scm_settings' => array(
                'scm_company_name' => 'My Company',
                'scm_safe_mode' => 'disabled',
                'scm_front_page_url' => '/course/',
                'scm_log_paypal_response' => 0,
                'scm_debug_mode' => 0,
                'scm_active_payment_gateway' => 'pp_express',
                'scm_admin_email' => 'webmaster@email.com',
                'scm_mailer_engine' => 'Default',
                'scm_use_app_style' => 1,
            ),
            'scm_smtp_settings' => array(
                'host' => 'smtp.gmail.com',
                'port' => '25',
                'username' => '',
                'password' => '',
                'encryption' => 'tls',
            )
        );

        foreach ($options as $key => $value){
            $value = serialize($value);
            add_option($key,$value );
        }
    }

    public function deleteOption()
    {
        delete_option('scm_paypal_advanced_settings');
        delete_option('scm_paypal_express_settings');
        delete_option('scm_settings');
        delete_option('scm_smtp_settings');
    }

}