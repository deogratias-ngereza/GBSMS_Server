<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class InvItemLease extends El_Model{
	protected $table = "inv_item_leases";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "item_id","purpose","description","created_date","requested_group","worker_id","created_by_worker_id","qty","currency","exchange_rate","lease_status","exp_returned_date","returned_date","received_by_worker_id","received_qty","exchange_rate_on_return","sign_on_issue_img","sign_on_return_img","recovery_status","revovered_amt","last_recovered_date"


    ];

    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }

}



?>