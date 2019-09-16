<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class TR_SD_FTL_MANTRACK_TARRIF extends El_Model{
	protected $table = "tr_s_d_ftl_mantrack_tarrifs";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "source_warehouse","destination_warehouse","category","package_name","0","3000","5000","10000","15000","20000","25000","lead_time","created_at"
    ];

    //apply range here

}



?>