<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class ZonalTarrif extends El_Model{
	protected $table = "tr_zonal_tarrifs";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "package_name","destination_zone","weight_in_kg","price","add_price_per_kg","remarks","created_at"
    ];



}



?>