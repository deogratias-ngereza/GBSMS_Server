<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;

//"destination_warehouse","package_name","0","0_5","1","2","3","4","5","0_5_10","11_20","21_50","51_100","101_200","lead_time","created_at"


class TR_DEST_TOYOTA_TARIFF extends El_Model{
	protected $table = "tr_dest_based_tarrifs";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "destination_warehouse","category","package_name","0","0p5","1","2","3","4","5","lead_time","created_at"
    ];

    //apply range here

}



?>