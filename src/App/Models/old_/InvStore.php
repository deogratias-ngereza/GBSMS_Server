<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class InvStore extends El_Model{
	protected $table = "inv_stores";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "name","address","phone",
    ];

    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }

}



?>