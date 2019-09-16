<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class PickupRequest extends El_Model{
	protected $table = "pickup_requests";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "customer_id","vbox_id","sch_date","sch_time","description","status","assigned_to","picked_date","product_type","product_description","estimated_weight","img_name","created_at","region","district","phone","location","product_qty"
    ];

}



?>