<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class Subscription extends El_Model{
	protected $table = "subscriptions";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "customer_id","start_date","end_date","payment_id","service_name","created_at",
    ];

}



?>