<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class GFS_FuelRefill extends El_Model{
	protected $table = "gfs_fuel_refills";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "tank_name","fuel_type","refill_date","issue_note_no","ref","qty_refilled","stock_qty_b4_refill","stock_qty_after_refill","worker_id","created_at",
    ];

    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }

}



?>