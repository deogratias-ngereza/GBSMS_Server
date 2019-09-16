<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class SMSDraft extends El_Model{
	protected $table = "sms_drafts";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "sms_body","updated_at","customer_id","contact_id","is_contact_saved",
    ];

    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }
    

}



?>