<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class InvItemTransaction extends El_Model{
	protected $table = "inv_item_transactions";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
       "item_id","issue_note_no","ref_no","for","action","created_by_worker_id","created_date","trans_amt","currency","exchange_rate","status","given_by_worker_id","given_date","sign_img","vehicle_id","driver_id","store_id","worker_id","customer_id","department",
    ];


   	/*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }






}



?>