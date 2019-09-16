<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class InvOrderPayment extends El_Model{
	protected $table = "inv_order_payments";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
       "order_no","invoice_no","paid_amt","paid_date","supplier_id","received_by_worker_id","status","created_date","summary","for","currency","exchange_rate",
    ];

    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }

}



?>