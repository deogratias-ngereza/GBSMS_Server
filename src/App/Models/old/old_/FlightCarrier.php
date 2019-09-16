<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class FlightCarrier extends El_Model{
	protected $table = "flight_carriers";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "name","flight_no","flight_description",
    ];

}



?>