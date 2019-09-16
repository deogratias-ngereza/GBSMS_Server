<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class Pod extends El_Model{
	protected $table = "pods";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "manifest_track_no","receiver_name","receiver_email","receiver_phone","received_date","received_time","pic_name","created_date","worker_id","product_id",
    ];

}



?>