<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;

use App\Models\TM_VehiclePermitType;
use App\Models\TM_Vehicle;
use App\Models\TM_Trailer;


class TM_VehiclePermit extends El_Model{
	protected $table = "tm_vehicle_permits";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "permit_id","vehicle_id","trailer_id","active","permit_for","start_date","end_date","licence_no","cover_note_no","file_ref_no","receipt_no","place_of_issue","date_of_issue","agency_code","amt","currency","created_at",
    ];

    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }

    public function permit(){
        return $this->belongsTo('App\Models\TM_VehiclePermitType','permit_id')->select(['id','name']);
    }
    public function truck(){
        return $this->belongsTo('App\Models\TM_Vehicle','vehicle_id')->select(['id','vehicle_reg_card']);
    }
    public function trailer(){
        return $this->belongsTo('App\Models\TM_Trailer','trailer_id')->select(['id','vehicle_reg_card']);
    }




}



?>