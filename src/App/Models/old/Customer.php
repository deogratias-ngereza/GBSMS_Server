<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class Customer extends El_Model{
	protected $table = "customers";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "vbox_id","first_name","last_name","email","phone","address","is_company","company_name","tin","vrn","created_at","manager_id","tarrif_package","tarrif_type","rec_due_date","phone_verified"
    ];


    public function manager(){
        return $this->belongsTo('App\Models\Worker','manager_id');
    }

    public function otps(){
        return $this->hasMany('App\Models\OTP','customer_id');
    }


    //check if customer exists
    public static function is_phone_exists($phone_no){
    	$customer = Customer::where('phone',$phone_no)->first();
    	if($customer == null) return false;
    	else return true;
    }

    //check if customer exists ::TODO
    public static function is_blocked($user_id){
    	$customer = Customer::where('phone',$user_id)->first();
    	if($customer == null) return false;
    	else return true;
    }





}



?>