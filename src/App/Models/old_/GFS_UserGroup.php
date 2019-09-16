<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class GFS_UserGroup extends El_Model{
	protected $table = "gfs_user_groups";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "name"
    ];

    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }

}



?>