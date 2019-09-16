<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model as El_Model;


class TarrifPackage extends El_Model{
	protected $table = "tarrifs_packages";
    protected $connection = 'default';
    public $timestamps = false;
    protected $fillable = [ 
        "name","code","category","description"
    ];

}



?>