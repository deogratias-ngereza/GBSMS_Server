<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class Manifest extends El_Model{
	protected $table = "manifests";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [
        "vbox_id","to_vbox_id","from_phy_box_no","to_phy_box_no","department_name","destination_warehouse_id","source_warehouse_id","source_address","destination_address","manifest_track_no","ref_no","customer_id","receiver_customer_id","sender_name","sender_phone","sender_email","receiver_name","receiver_phone","receiver_email","item_name","product_id","product_qty","product_weight","product_weight_og","product_height","product_width","product_length","product_description","product_verified","created_by_worker_id","transported_by_worker_id","received_by_worker_id","created_date","sent_date","exp_delivery_date","received_date","status","service_type","payment_type","freight","lead_time","tax_cost","processing_cost","discount_cost","transportation_cost","req_amt","paid_amt","paid_date","payment_status","payment_rec_by","vehicle_no","trans_vehicle_no","trans_driver_no","remarks","due_date","invoice_no"
    ];



    public function product(){
        return $this->belongsTo('App\Models\Wh_Product','product_id');
    }

    public function source_warehouse(){
        return $this->belongsTo('App\Models\Warehouse','source_warehouse_id');
    }
    public function destination_warehouse(){
        return $this->belongsTo('App\Models\Warehouse','destination_warehouse_id');
    }

    public function customer(){
        return $this->belongsTo('App\Models\Customer','customer_id');
    }

    public function sender_worker(){
        return $this->belongsTo('App\Models\Worker','created_by_worker_id');
    }

    public function receiver_worker(){
        return $this->belongsTo('App\Models\Worker','received_by_worker_id');
    }

    public function transporter(){
        return $this->belongsTo('App\Models\Worker','transported_by_worker_id');
    }
    public function pod(){
        return $this->belongsTo('App\Models\Pod','manifest_track_no','manifest_track_no');
    }

    public function invoice(){
        return $this->belongsTo('App\Models\Invoice','invoice_no','invoice_no');
    }

    public function cash_requests(){
        return $this->hasMany('App\Models\CashRequest','manifest_track_no','manifest_track_no');
    }

    public function prod_history(){
        return $this->hasMany('App\Models\ProductMovementHistory','manifest_id');
    }



}



?>