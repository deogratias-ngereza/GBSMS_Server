<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Illuminate\Database\Capsule\Manager as DB;
use App\Models\User;


class UserController extends BaseController{

	//retrieve all the users from the db
	public function get_all_users($req,$res,$args){
		$m = new User();
		return $res->withJson($m::all(),200);
	}



	public function test($req,$res,$args){
		$res = DB::connection('default')->table('users')->where('id','=','1')->first();
		return json_encode($res,true);
	}

	
}


?>