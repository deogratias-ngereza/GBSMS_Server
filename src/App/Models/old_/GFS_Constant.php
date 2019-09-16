<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class GFS_Constant extends El_Model{
	protected $table = "gfs_constants";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "key","value",
    ];
    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }

}



?>