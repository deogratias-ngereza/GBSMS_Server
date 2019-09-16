<?php
namespace App\Models\QueueApi;//

use \Illuminate\Database\Eloquent\Model as El_Model;

class LogSMSSchBatch extends El_Model{
	protected $table = "logs_sms_sch_batches";
    protected $connection = 'db2'; 
    public $timestamps = false;
    protected $fillable = [ 
        

        "batch_id","batch_no","status","recepients_json","created_date","created_at","msg","total_recepients",
        "total_units","sent_units","msg_length","response_type","response_info","error_info","exec_at",
        "sent_at","trials_count","on_lock","on_lock_since",
        "customer_id","customer_code","sms_gqaccount_no",
        "sender_name",

    ];
    /*return db-fields structure*/ 
    public function tbl_fields(){
    	return $this->fillable;
    } 

}
?>