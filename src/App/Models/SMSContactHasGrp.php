<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class SMSContactHasGrp extends El_Model{
	protected $table = "sms_contacts_has_groups";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "contact_id","group_id","created_at",
    ];

    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }
     

    public function contact(){
        return $this->belongsTo('App\Models\SMSContact','contact_id','id');
    }

    public function group(){
        return $this->belongsTo('App\Models\SMSGroup','group_id','id')->select(['id','group_name','color']);
    }

    public function groups(){ 
        return $this->belongsToMany('App\Models\SMSGroup','group_id','id')->select(['id','group_name','color']); 
    }

}



?>