<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class TR_FULL_FLAT extends El_Model{
	protected $table = "tr_full_flat";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "source_warehouse","destination_warehouse","category","package_name","weight","price","add_price_per_kg","lead_time","created_at"
    ];

    //apply range here

}



?>