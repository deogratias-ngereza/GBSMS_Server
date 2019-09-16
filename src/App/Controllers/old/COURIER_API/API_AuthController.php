<?php
namespace App\Controllers\COURIER_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Worker;
use App\Utilities\G_PasswordUtility;
use App\Utilities\G_JWT;
//check if email exists
		//$mailExists = Admin::where("email","email")->first();

class API_AuthController extends BaseController{
	
	//login process
	public function login($req,$res,$args){
		//return json_encode($req->getParsedBody()['id'],true);

		$email = $req->getParsedBody()['email'];
		$password = $req->getParsedBody()['password'];

		$Validator = new G_PasswordUtility(); 
		$G_JWT = new G_JWT();
		$user = Worker::where('email','=',$email)->with('warehouse')
						  ->first();
		if($user != null){
			//verify password
			$isPasswordOK = $Validator->verify($password,$user->password);
			if(sizeof($user) == 1 && $isPasswordOK == true){
				$token = $G_JWT->get_token_for_user($user,$user->id);
				$data = [
					"msg_data" => [ "token" => $token,"user"=>$user],
					"msg_status" => "OK"
				];
				return $res->withJSON($data,200);
			}else{
				$data = [
					"msg_data" => "Invalid Credentials!",
					"msg_status" => "FAILED"
				];
				return $res->withJSON($data,401);
			}
		}else{
			$data = [
				"msg_data" => "Invalid user account!!",
				"msg_status" => "FAILED"
			];
			return $res->withJSON($data,401);
		}
	}
	//



	//login by phoneprocess
	public function login_by_phone($req,$res,$args){
		//return json_encode($req->getParsedBody()['id'],true);

		$phone = $req->getParsedBody()['phone'];
		$password = $req->getParsedBody()['password'];

		$Validator = new G_PasswordUtility(); 
		$G_JWT = new G_JWT();
		$user = Worker::where('phone','=',$phone)->with('warehouse')
						  ->first();
		if($user != null){
			//verify password
			$isPasswordOK = $Validator->verify($password,$user->password);
			if(sizeof($user) == 1 && $isPasswordOK == true){
				$token = $G_JWT->get_token_for_user($user,$user->id);
				$data = [
					"msg_data" => [ "token" => $token,"user"=>$user],
					"msg_status" => "OK"
				];
				return $res->withJSON($data,200);
			}else{
				$data = [
					"msg_data" => "Invalid Credentials!",
					"msg_status" => "FAILED"
				];
				return $res->withJSON($data,401);
			}
		}else{
			$data = [
				"msg_data" => "Invalid user account!!",
				"msg_status" => "FAILED"
			];
			return $res->withJSON($data,401);
		}
	}
	//


	//reset_password from profile view
	public function reset_password($req,$res,$args){
		//return json_encode($req->getParsedBody()['id'],true);

		$user_id = $req->getParsedBody()['user_id'];
		$old_password = $req->getParsedBody()['old_password'];
		$new_password = $req->getParsedBody()['new_password'];

		$Validator = new G_PasswordUtility(); 
		$G_JWT = new G_JWT();
		$user = Worker::where('id','=',$user_id)->first();

		if($user != null){
			//verify password
			$isPasswordOK = $Validator->verify($old_password,$user->password);
			if(sizeof($user) == 1 && $isPasswordOK == true){
				$token = $G_JWT->get_token_for_user($user,$user->id);

				//set new password to the db
				$user->password = $Validator->encrypt($new_password);
				$user->save();

				//
				$data = [
					"msg_data" => [ "token" => $token,"user"=>$user],
					"msg_status" => "OK"
				];
				return $res->withJSON($data,200);
			}else{
				$data = [
					"msg_data" => "Invalid Old Password!",
					"msg_status" => "FAILED"
				];
				return $res->withJSON($data,401);
			}
		}else{
			$data = [
				"msg_data" => "Invalid user account!!",
				"msg_status" => "FAILED"
			];
			return $res->withJSON($data,401);
		}
		
	}



	//by admin u give new passward and id it reset to it
	public function resetting_workers_password($req,$res,$args){

		//$user_id = $req->getParsedBody()['worker_id'];
		//$new_password = $req->getParsedBody()['new_password'];

		$user_id = trim($req->getQueryParams()['worker_id'],"'");
		$new_password = trim($req->getQueryParams()['new_password'],"'");

		$Validator = new G_PasswordUtility(); 
		$G_JWT = new G_JWT();
		$user = Worker::where('id','=',$user_id)->first();


		if($user != null){
			//set new password to the db
			$user->password = $Validator->encrypt($new_password);
			$user->save();

			//
			$data = [
				"msg_data" => [ "user"=>$user],
				"msg_status" => "OK"
			];
			return $res->withJSON($data,200);
		}else{
			$data = [
				"msg_data" => "Invalid user account!!",
				"msg_status" => "FAILED"
			];
			return $res->withJSON($data,401);
		}
		
	}





}