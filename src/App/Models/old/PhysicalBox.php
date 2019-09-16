<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class PhysicalBox extends El_Model{
	protected $table = "physical_boxes";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "vbox_id","box_no","owner","address",
    ];

}



?>