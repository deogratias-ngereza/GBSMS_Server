<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class TM_SYS_History extends El_Model{
	protected $table = "tm_sys_history";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "history_for","order_id","trip_id","driver_id","worker_id","customer_id","adv_payment_id","invoice_id","action","description","created_date",
    ];

    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }

}



?>