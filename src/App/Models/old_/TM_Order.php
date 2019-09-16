<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class TM_Order extends El_Model{
	protected $table = "tm_orders";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "order_no","customer_id","dests_with_qty_json","qty_pms","qty_ago","qty_ik","qty_jet","qty_lpg","qty_other","total_qty","vehicles_drivers_json","current_exch_rate","currency","calc_freight_amt","ordered_date","status","source_id","destination_id","is_single_destination","attended_status","attended_by","attended_date","exp_veh_comp_fills_json","created_at","checked","checked_by","checked_date","approved","approved_by","approved_date","authorized","authorized_by","authorized_date","is_trip_set"
    ];

    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }

    public function customer(){
        return $this->belongsTo('App\Models\TM_Customer','customer_id');
    }

    public function checker(){
        return $this->belongsTo('App\Models\TM_Worker','checked_by')->select(['id','first_name','last_name','e_sign']);
    }
    public function approver(){
        return $this->belongsTo('App\Models\TM_Worker','approved_by')->select(['id','first_name','last_name','e_sign']);
    }
    public function authorizer(){
        return $this->belongsTo('App\Models\TM_Worker','authorized_by')->select(['id','first_name','last_name','e_sign']);
    }
    public function attender(){
        return $this->belongsTo('App\Models\TM_Worker','attended_by')->select(['id','first_name','last_name','e_sign']);
    }

}



?>