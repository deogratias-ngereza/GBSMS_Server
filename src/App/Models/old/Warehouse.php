<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class Warehouse extends El_Model{
	protected $table = "warehouses";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "name","code","region","phone","email","address","pic_name","zone","created_at"
    ];

}



?>