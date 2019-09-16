<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;

class BoardConstant extends El_Model{
	protected $table = "boards_constants";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
       "center_id","grp_counts","page_delay","pull_delay"
    ];

}


?>