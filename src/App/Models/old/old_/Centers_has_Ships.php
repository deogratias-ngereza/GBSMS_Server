<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class Centers_has_Ships extends El_Model{
	protected $table = "centers_has_ships";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "center_id","ship_carrier_id","name","route_arrival","route_departure","time_arrival","time_departure","working_days",
    ];
    //has one ship
    public function ship()
    {
        return $this->hasOne('App\Models\ShipCarrier','id','ship_carrier_id');
    }

}



?>