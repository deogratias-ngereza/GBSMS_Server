<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class GPS_VehicleRecord extends El_Model{
	protected $table = "gps_vehicles_records";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "device_ref_id","latitude","longitude","mile_in_km","speed","created_date",
    ];

    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }

}



?>