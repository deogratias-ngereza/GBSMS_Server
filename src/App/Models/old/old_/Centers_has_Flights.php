<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class Centers_has_Flights extends El_Model{
	protected $table = "centers_has_flights";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "center_id","flight_carrier_id","flight_no","name","route_arrival","route_departure","time_arrival","time_departure","working_days",
    ];

    //has one flight
    public function flight()
    {
        return $this->hasOne('App\Models\FlightCarrier','id','flight_carrier_id');
    }

}



?>