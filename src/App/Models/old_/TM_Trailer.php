<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class TM_Trailer extends El_Model{
	protected $table = "tm_trailers";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "vehicle_reg_card","truck_id","img_name","make","model","manufactured_year","color","chasis_no","body_type","plate_no","active","date_of_aquisition","value_aquisition","axles_no","unit","total_capacity","total_capacity_pms","total_capacity_ago","total_capacity_ik","total_capacity_jet","total_capacity_lpg","total_capacity_other","tanker_comp1","tanker_comp2","tanker_comp3","tanker_comp4","tanker_comp5","tanker_comp6","tanker_comp7","tanker_comp8","tanker_comp9","tanker_comp10","tanker_total_comp_capacity","trailer_status","is_vehicle_hired","owner_id","current_vehicle_status","current_named_loc"
    ];

    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;//0685608508
    }

    public function truck(){
        return $this->belongsTo('App\Models\TM_Vehicle','truck_id');
    }

}



?>