<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class Channel extends El_Model{
	protected $table = "channels";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "company_id","name","code","description","created_date","update_code","update_level","location","fcode"
    ];

    //has many media
    public function medias()
    {
        return $this->hasMany('App\Models\Media','channel_id');
    }

    public function company(){
        return $this->belongsTo('App\Models\Company','company_id');
    }



}



?>