<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class OTP extends El_Model{
	protected $table = "otps";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
       "customer_id","secrete","service_name","valid_till","created_at",
    ];

}

?>