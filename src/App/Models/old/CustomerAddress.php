<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class CustomerAddress extends El_Model{
	protected $table = "customers_addresses";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "region","district","phone","location","created_at","customer_id","address_for"
    ];

}



?>