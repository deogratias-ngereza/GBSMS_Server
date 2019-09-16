<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class SMSGroup extends El_Model{ 
	protected $table = "sms_groups";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
       "customer_id","group_name","created_at","deleted","color"
    ];

    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }
    

    public function contactIds(){
        return $this->hasMany('App\Models\SMSContactHasGrp','group_id');
    }

    public function contacts(){
        return $this->hasMany('App\Models\SMSContact','group_id');
    }

}



?>