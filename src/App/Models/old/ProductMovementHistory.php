<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class ProductMovementHistory extends El_Model{
	protected $table = "product_movements_history";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
       "track_no","wh_import_id","manifest_id","worker_id","status","description","created_at","current_wh_id"
    ];


    public function worker(){
        return $this->belongsTo('App\Models\Worker','worker_id');
    }

    public function manifest(){
        return $this->belongsTo('App\Models\Manifest','manifest_track_no','track_no');
    }

    public function current_warehouse(){
        return $this->belongsTo('App\Models\Warehouse','current_wh_id');
    }

}



?>