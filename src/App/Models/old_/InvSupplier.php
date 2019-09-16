<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class InvSupplier extends El_Model{
	protected $table = "inv_suppliers";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "name","email","phone","address",
    ];

    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }

}



?>