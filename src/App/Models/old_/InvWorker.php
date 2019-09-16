<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class InvWorker extends El_Model{//tm_workers
	//protected $table = "inv_workers";
    protected $table = "tm_workers";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
     	"first_name","last_name","phone","password","role",
    ];

    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }

}



?>