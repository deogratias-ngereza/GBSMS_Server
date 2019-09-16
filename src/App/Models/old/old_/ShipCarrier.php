<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class ShipCarrier extends El_Model{
	protected $table = "ship_carriers";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "name","ship_no","ship_description",
    ];

}



?>