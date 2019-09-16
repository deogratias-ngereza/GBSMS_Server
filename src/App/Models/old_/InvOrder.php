<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;
use App\Models\InvSupplier;
use App\Models\TM_Worker;

class InvOrder extends El_Model{
	protected $table = "inv_orders";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "supplier_id","order_no","total_exp_amt","total_amt","currency","exchange_rate","orders","created_by_worker_id","exp_delivery_date","created_date","status"
    ];



    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }


    public function supplier(){
        return $this->belongsTo('App\Models\InvSupplier','supplier_id');
    }


    public function creator(){
        return $this->belongsTo('App\Models\TM_Worker','created_by_worker_id');
    }






}



?>