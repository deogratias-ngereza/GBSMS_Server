<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class InvOperationalCost extends El_Model{
	protected $table = "inv_operational_costs";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "store_cat","purpose","description","store_id","worker_id","created_by_worker_id","currency","amt","remarks","created_date",
    ];

    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }

}



?>