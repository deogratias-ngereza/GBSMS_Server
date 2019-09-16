<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class TM_Worker extends El_Model{
	protected $table = "tm_workers";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
       "first_name","last_name","email","phone_no","address","password","role","department","created_at","e_sign"
    ];

    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }

}



?>