<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class DeliveryRequest extends El_Model{
	protected $table = "deliveries_requests";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "customer_id","vbox_id","region","district","phone","location","manifest_id","track_no","req_date","status","description","created_at",
    ];

}



?>