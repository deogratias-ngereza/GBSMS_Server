<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class Payment extends El_Model{
	protected $table = "payments";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "mode","ref_no","manifest_track_no","paid_date","paid_amt","status","valid_till","payment_for","payment_ref","customer_id","created_at",
    ];

}



?>