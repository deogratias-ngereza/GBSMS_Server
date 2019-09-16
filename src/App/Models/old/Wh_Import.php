<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class Wh_Import extends El_Model{
	protected $table = "wh_imports";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "product_id","supplier_id","source_warehouse_id","destination_warehouse_id","customer_id","track_no","by_worker_id","product_cost","other_cost","prod_supplier_ref","product_details","prod_height","prod_width","prod_weight","prod_qty","status","receiver_worker_id","received_date","received_time","received_remarks","created_at"
    ];


    public function product(){
        return $this->belongsTo('App\Models\Wh_Product','product_id');
    }

    public function supplier(){
        return $this->belongsTo('App\Models\Supplier','supplier_id');
    }

    public function source_warehouse(){
        return $this->belongsTo('App\Models\Warehouse','source_warehouse_id');
    }
    public function destination_warehouse(){
        return $this->belongsTo('App\Models\Warehouse','destination_warehouse_id');
    }

    public function warehouse(){
        return $this->belongsTo('App\Models\Warehouse','destination_warehouse_id');
    }

    public function customer(){
        return $this->belongsTo('App\Models\Customer','customer_id');
    }

    public function worker(){
        return $this->belongsTo('App\Models\Worker','by_worker_id');
    }

    public function receiver(){
        return $this->belongsTo('App\Models\Worker','receiver_worker_id');
    }



}



?>