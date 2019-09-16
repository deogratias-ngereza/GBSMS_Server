<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class SMSOutgoingHistory extends El_Model{
	protected $table = "sms_outgoings";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "sms_body","sent_date","sent_at","sent_time","status","contact_phone","customer_id",

        "sys_ref","app_ref","api_ref","created_date","created_at",
        "batch_id","sms_text_length","sms_units","response_type","response_info"
        //,"error_info",
        //"queued_date","queued_at",

    ];

    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }
    

}



?>