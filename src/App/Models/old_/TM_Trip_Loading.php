<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class TM_Trip_Loading extends El_Model{
	protected $table = "tm_trip_loadings";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "order_no","trip_no","vehicle_id","loaded_pms","loaded_ago","loaded_ik","loaded_lpg","loaded_jet","loaded_other","loaded_date","created_by","created_date",
    ];

    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }
    

}



?>