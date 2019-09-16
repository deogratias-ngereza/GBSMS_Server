<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class SMSIncoming extends El_Model{
	protected $table = "sms_incomings";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "sms_body","received_at","received_time","status","contact_phone","contact_id","is_contact_saved","customer_id",
    ];

    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }
    

}



?>