<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class ServingArea extends El_Model{
	protected $table = "serving_areas";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "name","level",
    ];

}



?>