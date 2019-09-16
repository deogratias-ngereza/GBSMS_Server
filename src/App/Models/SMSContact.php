<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class SMSContact extends El_Model{
	protected $table = "sms_contacts_list";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
       "customer_id","phone_no","name","email","created_date","deleted"
    ];

    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }

    public function groups(){
        return $this->hasMany('App\Models\SMSContactHasGrp','contact_id');//;//]->select(['id','group_id']);
    }
    

}



?>