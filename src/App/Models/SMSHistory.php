<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class SMSHistory extends El_Model{
	protected $table = "sms_histories";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "sms_inc_id","sms_out_id","created_at",
    ];

    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }
    

}



?>