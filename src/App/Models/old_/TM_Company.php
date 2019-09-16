<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class TM_Company extends El_Model{
	protected $table = "tm_companies";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "code","name","address_1","address_2","phone","email","tin","vrn","url","logo_name","region","country","p_o_box","created_at"
    ];


    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }

}



?>