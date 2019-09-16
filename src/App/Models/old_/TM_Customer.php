<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class TM_Customer extends El_Model{
	protected $table = "tm_customers";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "company_name","p_o_box","address","phone","email","person_of_contact","tin_no","vrn_no","password","color","currency"
    ];


    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }

}



?>