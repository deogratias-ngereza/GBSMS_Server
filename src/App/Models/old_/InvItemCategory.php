<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class InvItemCategory extends El_Model{
	protected $table = "inv_item_categories";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "name",
    ];
    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }

}



?>