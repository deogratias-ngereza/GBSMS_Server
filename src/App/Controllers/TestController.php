<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Illuminate\Database\Capsule\Manager as DB;

use App\Models\User;
use App\Utilities\G_JWT;


class TestController extends BaseController{
	public function test($req,$res,$args){
		$res = DB::connection('default')->table('users')->where('id','=','1')->first();
		return json_encode($res,true);
		//$m = new User;
		//return json_encode($m::all(),true);
		//$this->view($res, 'index.phtml', $args);
	}

	public function jwt_test($req,$res,$args){
		
		$u = new User();
		$u->first();
		$jo = new G_JWT;
		$en = $jo->get_token_for_user($u->first());
		//return json_encode($en,true);

		$token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOnsiaWQiOjEsIm5hbWUiOiJncmFuZCIsImVtYWlsIjoiZ3JhbmRAZ21haWwuY29tIiwicGFzc3dvcmQiOiJwYXNzd29yZCJ9LCJpYXQiOjE1MTY5MzAzNDMsImV4cCI6MTUxNjkzMDQ0MywidWlkIjoxfQ.inNZzudw_p06kxyGq5K4jo4aKHWY9DZRCTycosN7-gw";
		//$jo = new G_JWT;
		return json_encode($jo->get_decoded_token($token));
		//return json_encode($jo->is_token_valid($token));
	}


	public function free_token($req,$res,$args){
		$u = new User();
		$u->first();
		$jo = new G_JWT;
		$en = $jo->get_token_for_user($u->first());
		return json_encode($en,true);
	}

	


}


?>