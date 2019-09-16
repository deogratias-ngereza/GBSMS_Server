<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class StoreProduct extends El_Model{
	protected $table = "store_products";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "name","description","code","pic_name","created_at","warehouse_id"
    ];

}



?>