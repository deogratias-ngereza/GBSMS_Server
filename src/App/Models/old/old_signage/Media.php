<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class Media extends El_Model{
	protected $table = "medias";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "channel_id","name","ext","size","type","description","duration","duration_in_s","code","created_at","uploaded_by","corrupted"
    ];

}



?>