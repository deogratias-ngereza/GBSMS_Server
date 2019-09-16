<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class Department extends El_Model{
	protected $table = "departments";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "dep_name","dep_description","dep_b64_brand_img",
    ];

}



?>