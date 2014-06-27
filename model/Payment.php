<?php namespace SCM\Model;

use SCM\Classes\SCMModel;

class Payment extends SCMModel {

    protected $table = 'wp_scm_payments';

    protected $fillable = array(
        'invoice_id',
        'wp_scm_course_id',
        'wp_scm_users_id',
        'paid',
    );

    public function student()
    {
        return $this->belongsTo('SCM\Model\User','wp_scm_users_id');
    }

    public function course()
    {
        return $this->belongsTo('SCM\Model\Course','wp_scm_course_id');
    }

    public function data()
    {
        return $this->hasMany('SCM\Model\PaymentsTransactionsData','wp_scm_payment_id');
    }

    public function scopeOfStudent($query, $studentID)
    {
        return $query->where('wp_scm_users_id',$studentID);
    }

    public function scopeOfCourse($query, $courseID)
    {
        return $query->where('wp_scm_course_id',$courseID);
    }

    public function isPaid()
    {
        return ($this->paid==1);
    }

    public function scopeOfPaid($query)
    {
        return $query->where('paid',1);
    }

    public function scopeOfUnPaid($query)
    {
        return $query->where('paid',0);
    }

}