<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;

use App\Models\TM_Vehicle;
use App\Models\TM_Trailer;


class TM_VehicleHasTrailer extends El_Model{
	protected $table = "tm_vehicle_has_trailers";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "vehicle_id","trailer_id","created_at",
    ];

    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }

    public function truck(){
        return $this->belongsTo('App\Models\TM_Vehicle','vehicle_id')->select(['id','vehicle_reg_card']);
    }
    public function trailer(){
        return $this->belongsTo('App\Models\TM_Trailer','trailer_id')->select(['id','vehicle_reg_card']);
    }

    

}



?>