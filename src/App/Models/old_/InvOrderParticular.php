<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;

use App\Models\InvItem;


class InvOrderParticular extends El_Model{
	protected $table = "inv_order_particulars";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "order_no","item_id","qty_ordered","qty_received","odered_date","status","unit_price","exp_purchase_price","actual_purchase_price","currency","exp_delivery_date","lead_time","received_by_worker_id","received_date","store_category","store_id","invoice_no",
    ];

    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }


    public function product(){
        return $this->belongsTo('App\Models\InvItem','item_id');
    }

}



?>