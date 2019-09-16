<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class TR_ZANZ_INS_TARIFF extends El_Model{
	protected $table = "tr_dest_based_tarrifs";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "destination_warehouse","category","package_name","0","0p5","1","1p5","2","2p5","3","3p5","4","4p5","5","5p5","6","6p5","7","7p5","8","8p5","9","9p5","10","lead_time","created_at"
    ];

    //apply range here

}



?>