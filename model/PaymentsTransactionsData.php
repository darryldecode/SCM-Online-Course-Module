<?php namespace SCM\Model;

use SCM\Classes\SCMModel;

class PaymentsTransactionsData extends SCMModel {

    protected $table = 'wp_scm_payments_transactions_data';

    protected $fillable = array(
        'wp_scm_payment_id',
        'method',
        'type',
        'acct',
        'amt',
        'exp_date',
        'resp_msg',
        'auth_code',
        'country',
        'card_type',
    );

    public function payment()
    {
        return $this->belongsTo('SCM\Model\Payment','wp_scm_payment_id');
    }

}