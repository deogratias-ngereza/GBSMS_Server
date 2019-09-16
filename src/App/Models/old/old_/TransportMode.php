<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class TransportMode extends El_Model{
	protected $table = "transport_modes";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "trans_mode_name",
    ];

}



?>