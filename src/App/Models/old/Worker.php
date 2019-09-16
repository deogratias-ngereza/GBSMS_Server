<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class Worker extends El_Model{
	protected $table = "workers";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
       "warehouse_id","first_name","last_name","password","role","phone","email","address","created_at"
    ];

    public function warehouse(){
        return $this->belongsTo('App\Models\Warehouse','warehouse_id');
    }

}



?>