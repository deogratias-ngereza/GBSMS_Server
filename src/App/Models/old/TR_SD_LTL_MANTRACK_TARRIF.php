<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class TR_SD_LTL_MANTRACK_TARRIF extends El_Model{
	protected $table = "tr_s_d_ltl_mantrack_tarrifs";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "source_warehouse","destination_warehouse","category","package_name","0","0p5","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31","32","33","34","35","36","37","38","39","40","a41_49","50","a51_499","500","a501_999","1000","a1000","lead_time","created_at"
    ];

    //apply range here

}



?>