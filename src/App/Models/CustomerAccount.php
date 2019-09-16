<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class CustomerAccount extends El_Model{
	protected $table = "customer_accounts";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "code","username","email","phone_no","address","password","profile_pic","created_at",
        "api_key","sms_quota","deleted","sms_gqaccount_no","suspended","sms_chunk_capacity"
    ];

    protected $hidden = [ 
        "password","deleted","suspended","sms_chunk_capacity","api_key"
    ];


    
    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }
    

}



?>