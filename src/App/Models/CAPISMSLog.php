<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


/*
	note: same asl SMSOutgoing model
	helps to hide sys cols from the end user 
*/

class CAPISMSLog extends El_Model{
	protected $table = "sms_outgoings";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [  
        "sms_body","sent_date","sent_at","sent_time","status","contact_phone",
        "sys_ref","app_ref","api_ref","created_date","created_at","gq_sms_acc_no",
        "batch_id","sms_text_length","sender_name","sms_units","response_type","response_info",


    ]; 

    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }
    

}



?>