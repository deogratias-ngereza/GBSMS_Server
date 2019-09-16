<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class Centers_has_Bus_carriers extends El_Model{
	protected $table = "centers_has_bus_carriers";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "center_id","bus_carrier_id","name","route_arrival","route_departure","time_arrival","time_departure","working_days",
    ];


    //has one bus
    public function bus()
    {
        return $this->hasOne('App\Models\BusCarrier','id','bus_carrier_id');
    }

}



?>