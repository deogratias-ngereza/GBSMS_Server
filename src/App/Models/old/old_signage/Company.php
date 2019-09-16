<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class Company extends El_Model{
	protected $table = "companies";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
       "name","address","created_at","max_channels","fcode","active"
    ];

}



?>