<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class TM_TripOffload extends El_Model{
	protected $table = "tm_trip_offloads";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "vehicle_id","order_no","trip_base_no","trip_no","dest_id","dest_address","exp_offload_pms","exp_offload_ago","exp_offload_ik","exp_offload_jet","exp_offload_lpg","exp_offload_other","offloaded_pms","offloaded_ago","offloaded_jet","offloaded_ik","offloaded_lpg","offloaded_other","offloaded_date","created_by","created_date","offload_summary","status",
    ];

    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }
    

}



?>