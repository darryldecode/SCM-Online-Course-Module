<?php namespace SCM\Classes;

class SCMInstaller {

    /**
     *------------------------------------------------------
     * Syntax to create SCM Schema
     *------------------------------------------------------
     */
    static $tables = array(

        'wp_scm_course' => '(
          `id` INT NOT NULL AUTO_INCREMENT ,
          `name` VARCHAR(45) NULL ,
          `description` VARCHAR(45) NULL ,
          `created_at` DATETIME NULL ,
          `updated_at` DATETIME NULL ,
          `location` TEXT NULL ,
          `dates` TEXT NULL ,
          `times` TEXT NULL ,
          `fee` DECIMAL(10,2) NULL ,
          `registration_end_date` DATETIME NULL ,
          PRIMARY KEY (`id`) )
        ENGINE = InnoDB;',

        'wp_scm_users' => '(
          `id` INT NOT NULL AUTO_INCREMENT ,
          `first_name` VARCHAR(45) NULL ,
          `middle_name` VARCHAR(45) NULL ,
          `last_name` VARCHAR(45) NULL ,
          `email` VARCHAR(45) NULL ,
          `created_at` DATETIME NULL ,
          `updated_at` DATETIME NULL ,
          `suffix` VARCHAR(45) NULL ,
          `employers_company_name` VARCHAR(255) NULL ,
          `home_mailing_address_1` VARCHAR(45) NULL ,
          `home_mailing_address_2` VARCHAR(45) NULL ,
          `city` VARCHAR(45) NULL ,
          `state` VARCHAR(45) NULL ,
          `zip_code` VARCHAR(45) NULL ,
          `personal_cell_number` VARCHAR(45) NULL ,
          PRIMARY KEY (`id`) )
        ENGINE = InnoDB;',

        'wp_scm_course_users' => '(
          `id` INT NOT NULL AUTO_INCREMENT ,
          `paid` TINYINT(1) NULL DEFAULT 0 ,
          `wp_scm_course_id` INT NOT NULL ,
          `wp_scm_users_id` INT NOT NULL ,
          `created_at` DATETIME NULL ,
          `updated_at` DATETIME NULL ,
          PRIMARY KEY (`id`) ,
          INDEX `fk_wp_scm_course_users_wp_scm_course1_idx` (`wp_scm_course_id` ASC) ,
          INDEX `fk_wp_scm_course_users_wp_scm_users1_idx` (`wp_scm_users_id` ASC) ,
          CONSTRAINT `fk_wp_scm_course_users_wp_scm_course1`
            FOREIGN KEY (`wp_scm_course_id` )
            REFERENCES `wp_scm_course` (`id` )
            ON DELETE NO ACTION
            ON UPDATE NO ACTION,
          CONSTRAINT `fk_wp_scm_course_users_wp_scm_users1`
            FOREIGN KEY (`wp_scm_users_id` )
            REFERENCES `wp_scm_users` (`id` )
            ON DELETE NO ACTION
            ON UPDATE NO ACTION)
        ENGINE = InnoDB;',

    );

    public static function dropSchema(){
        foreach(self::$tables as $table => $def){
            $query = "drop table if exists " . $table;
            self::process($query);
        }
    }

    public static function createSchema(){
        foreach(self::$tables as $table => $def){
            $query = "create table IF NOT EXISTS " . $table . " " . $def;
            self::process($query);
        }
    }

    public static function process( $query ){
        $dbcon = Connection::getInstance();
        $dbcon->query($query);
        $dbcon->execute();
        $dbcon->resetData();
    }

    public static function setOptions(){

        $options = array(
            'scm_paypal_advanced_settings' => array(
                'mode' => 'sandbox',
                'currency' => 'USD',
                'user' => '',
                'vendor' => '',
                'partner' => '',
                'pwd' => 'USD',
                'create_secure_token' => 'USD',
                'trxtype' => 'USD',
            ),
            'scm_settings' => array(
                'version' => '1.0',
                'scm_safe_mode' => 'disabled',
            )
        );

        foreach ($options as $key => $value){
            $value = serialize($value);
            add_option($key,$value );
        }

    }

}