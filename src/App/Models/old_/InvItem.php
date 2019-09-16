<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class InvItem extends El_Model{
	protected $table = "inv_items";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
       "name","description","category_id","code","unit","current_stock_qty","last_stock_update_date","re_order_level","balance_level","chk_qty_b4_use","lead_time","buying_price_per_unit","selling_price_per_unit","buying_price_currency","selling_price_currency","loc_dep_area","loc_section","loc_shelf","supplier_info","supplier_id","created_date",
    ];

    /*return db-fields structure*/
    public function tbl_fields(){
    	return $this->fillable;
    }





}



?>