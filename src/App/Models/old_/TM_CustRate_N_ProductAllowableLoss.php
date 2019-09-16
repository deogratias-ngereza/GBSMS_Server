<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;

use App\Models\TM_Customer;
use App\Models\TM_TripDestinationPoint;


class TM_CustRate_N_ProductAllowableLoss extends El_Model{
	protected $table = "tm_cust_rates_n_product_allowable_losses";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "customer_id","destination_point_id","customer_rate","pms","ago","ik","jet","lpg","other","currency",
    ];

     /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }



    public function destination(){
        return $this->belongsTo('App\Models\TM_TripDestinationPoint','destination_point_id');
    }

    public function customer(){
        return $this->belongsTo('App\Models\TM_Customer','customer_id');
    }


}



?>