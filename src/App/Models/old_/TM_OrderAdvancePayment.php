<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class TM_OrderAdvancePayment extends El_Model{
	protected $table = "tm_order_advance_payments";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "order_id","amt_paid","paid_date","payment_type","cheque_no","payment_ref_no","description","amt_remained","created_at",
    ];

    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }

}



?>