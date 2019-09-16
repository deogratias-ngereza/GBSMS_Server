<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class TmExchangeRate extends El_Model{
	protected $table = "tm_exchange_rates";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "id","from","to","unit","amt","last_updated_date",
    ];

    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }

}



?>