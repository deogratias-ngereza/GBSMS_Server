<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class TM_VehiclePermitType extends El_Model{
	protected $table = "tm_vehicle_permits_types";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
       "name",
    ];


    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }

}



?>