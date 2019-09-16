<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class Supplier extends El_Model{
	protected $table = "suppliers";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "name","phone","email","address","created_at"
    ];

}



?>