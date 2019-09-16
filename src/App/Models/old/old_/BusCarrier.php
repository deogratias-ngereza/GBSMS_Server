<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class BusCarrier extends El_Model{
	protected $table = "bus_carriers";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "name","description",
    ];

}



?>