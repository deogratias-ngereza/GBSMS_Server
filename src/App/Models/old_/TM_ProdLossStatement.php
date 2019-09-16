<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class TM_ProdLossStatement extends El_Model{
	protected $table = "tm_prod_loss_statements";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "trip_id","driver_id","net_prod_qty_loss","rate","net_prod_loss_amt","recovered_amt","last_recovered_date","status","created_date",
    ];
    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }
}



?>