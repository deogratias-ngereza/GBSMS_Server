<?php
namespace App\Models;
use App\Models\BoardConstant;
use \Illuminate\Database\Eloquent\Model as El_Model;


class Center extends El_Model{
	protected $table = "centers";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
      "center_code","center_name","address","phone1","phone2","email","region","country","manager_name","motto","short_story","img","services_list",
    ];

    //has one board constant
    public function board_constants()
    {
        return $this->hasOne('App\Models\BoardConstant','center_id','id');
    }

}



?>