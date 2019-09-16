<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class TM_Vehicle extends El_Model{
	protected $table = "tm_vehicles";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "vehicle_reg_card","img_name","make","model","manufactured_year","color","chasis_no","engine_no","vehicle_type","body_type","fuel_type","plate_no","odometer_readings","active","date_of_aquisition","odometer_aquisition","value_aquisition","axles_no","has_builtin_trailer","unit","total_capacity","total_capacity_pms","total_capacity_ago","total_capacity_ik","total_capacity_jet","total_capacity_lpg","total_capacity_other","tanker_comp1","tanker_comp2","tanker_comp3","tanker_comp4","tanker_comp5","tanker_total_comp_capacity","gps_ref_id","vehicle_status","is_vehicle_hired","owner_id","current_vehicle_status","alloc_status","current_named_loc","current_longitude","current_latitude","current_driver_id"
    ];

    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }

    public function driver(){
        return $this->hasOne('App\Models\TM_Driver','id','current_driver_id')->select(['id','full_name','license_no','passport_no']);
    }

    public function trailers(){
        return $this->hasMany('App\Models\TM_Trailer','truck_id');
    }


}



?>