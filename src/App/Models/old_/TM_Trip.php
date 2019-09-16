<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class TM_Trip extends El_Model{
	protected $table = "tm_trips";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "order_no","trip_no","trip_date","vehicle_id","vehicle_name","destinations","status","created_by","created_date"
    ];

    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }
    

}



?>