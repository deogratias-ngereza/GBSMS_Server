<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class Wh_Inventory extends El_Model{
	protected $table = "wh_inventory";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "warehouse_id","product_id","actual_qty","received_qty","issued_qty","imp_exp_option","received_date","received_time","received_worker_id","issued_date","issued_time","issued_worker_id","created_at"
    ];

}



?>