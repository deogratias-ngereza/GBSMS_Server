<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class VirtualBox extends El_Model{
	protected $table = "virtual_boxes";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
       "vbox_no","binded_phone","customer_id","status","created_at","created_by",
    ];

}



?>