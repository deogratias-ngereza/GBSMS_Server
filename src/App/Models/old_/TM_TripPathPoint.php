<?php
namespace App\Models;


use \Illuminate\Database\Eloquent\Model as El_Model;

use App\Models\TM_TripDestinationPoint;

class TM_TripPathPoint extends El_Model{
	protected $table = "tm_trip_path_points";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "source_point_id","destination_point_id","point_name","order_no","latitude","longitude",
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