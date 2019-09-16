<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class TM_Driver extends El_Model{
	protected $table = "tm_drivers";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "first_name","last_name","full_name","license_no","passport_no","dob","phone_no","img_name","password","date_of_contract","emargency_contact","referees_details","license_exp_date","passport_exp_date","alloc_status","created_at",
    ];

    
    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }

}



?>