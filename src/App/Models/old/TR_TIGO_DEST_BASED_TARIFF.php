<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class TR_TIGO_DEST_BASED_TARIFF extends El_Model{
	protected $table = "tr_dest_based_tarrifs";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "destination_warehouse","category","package_name","0p5_10","5p1_15","15p1_30","30p1_50","50p1_100","lead_time","created_at"
    ];

    //apply range here

}



?>