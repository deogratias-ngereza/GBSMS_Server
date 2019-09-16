<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;

use App\Models\TM_TripDestinationPoint;

class TM_TripFixedPckg extends El_Model{
	protected $table = "tm_trip_fixed_pckgs";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "source_point_id","destination_point_id","border_fee","border_fee_currency","driver_milleage","driver_milleage_currency","seal_fee","seal_currency","distance_kms","fuel_ltrs","fuel_price_per_ltr","fuel_fee_currency",
    ];

    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }


    public function source(){
        return $this->belongsTo('App\Models\TM_TripDestinationPoint','source_point_id')->select(['id','name']);
    }

    public function destination(){
        return $this->belongsTo('App\Models\TM_TripDestinationPoint','destination_point_id')->select(['id','name']);
    }

}



?>