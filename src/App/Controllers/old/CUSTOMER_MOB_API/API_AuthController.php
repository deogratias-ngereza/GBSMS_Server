<?php
namespace App\Controllers\CUSTOMER_MOB_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Customer;
use App\Models\OTP;

use App\Utilities\G_PasswordUtility;
use App\Utilities\G_HelperUtil;
use App\Utilities\G_JWT;
use App\Notify\NotifierProvider;
//check if email exists
		//$mailExists = Admin::where("email","email")->first();



class API_AuthController extends BaseController{//

	
	public function __construct(){
		
	}


	//login process
	public function login($req,$res,$args){
		//return json_encode($req->getParsedBody()['id'],true);

		$email = $req->getParsedBody()['identity'];
		$password = $req->getParsedBody()['password'];

		$Validator = new G_PasswordUtility(); 
		$G_JWT = new G_JWT();
		$user = Customer::where('email','=',$email)->with('warehouse')
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




	//login by phone process
	public function login_by_phone($req,$res,$args){
		$phone_no = trim($req->getParsedBody()['phone_no']);
		$password = $req->getParsedBody()['password'];

		$Validator = new G_PasswordUtility(); 
		$G_JWT = new G_JWT();
		$user = Customer::where('phone','=',$phone_no)
						  ->first();
		if($user != null){
			//verify password
			$isPasswordOK = $Validator->verify($password,$user->password);
			if(sizeof($user) == 1 && $isPasswordOK == true){
				$token = $G_JWT->get_token_for_user($user,$user->id);

				//check if phone is verified or not
				/*$phone_verified = $user->phone_verified;
				if($phone_verified == 0){
					$data = [
						"msg_data" => ["msg"=>"Phone not verified","data"=>$user->id],
						"msg_status" => "OK",
						"msg_type" => "STRING"
					];
					return $res->withJSON($data,400);
				}*/

				$data = [
					"msg_data" => [ "token" => $token,"user"=>$user],
					"msg_status" => "OK",
					"msg_type" => "STRING"
				];
				return $res->withJSON($data,200);
			}else{
				$data = [
					"msg_data" => "Invalid Credentials!",
					"msg_status" => "FAILED",
					"msg_type" => "STRING"
				];
				return $res->withJSON($data,401);
			}
		}else{
			$data = [
				"msg_data" => "Invalid user account!!",
				"msg_status" => "FAILED",
				"msg_type" => "STRING"
			];
			return $res->withJSON($data,401);
		}
	}






	//reset_password from profile view
	public function reset_password($req,$res,$args){
		$customer_id = $req->getParsedBody()['customer_id'];
		$old_password = $req->getParsedBody()['old_password'];
		$new_password = $req->getParsedBody()['new_password'];

		$Validator = new G_PasswordUtility(); 
		$G_JWT = new G_JWT();
		$user = Customer::where('id','=',$customer_id)->first();

		if($user != null){
			//verify password
			$isPasswordOK = $Validator->verify($old_password,$user->password);
			if(sizeof($user) == 1 && $isPasswordOK == true){
				$token = $G_JWT->get_token_for_user($user,$user->id);

				//set new password to the db
				$user->password = $Validator->encrypt($new_password);
				$user->update();
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





	/*
		SIGNUP
	*/
	public function register($req,$res,$args){
		$GHelperUtil = new G_HelperUtil;
		$PassUtil = new G_PasswordUtility();
		$auto_otp = $GHelperUtil->getFreeOTP(4);
		$valid_till = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." +10 minutes"));//waiting for 10 min
		//1) create the user and return the id of the user created' and assign opt to send to 
		$customer = Customer::create([
			"first_name" => $req->getParsedBody()['first_name'],
			"last_name" => $req->getParsedBody()['last_name'],
			"email" => $req->getParsedBody()['email'],
			"phone" => trim($req->getParsedBody()['phone_no']),
			"address" => $req->getParsedBody()['address'],
			"password" => $PassUtil->encrypt($req->getParsedBody()['password'])
		])->otps()->create([
			"secrete" => $auto_otp,
			"service_name" => "REGISTRATION",
			"valid_till"=>$valid_till
		]);
		//send sms notification
		$notifier = new NotifierProvider();//customerCarePhones
		if($customer != null){
			$sms_msg = "(Posta) Ngugu Mteja,ingiza ".$auto_otp." kuhakiki usajili,asante kwa kujiunga na huduma zetu.";
			//" kwa msaada piga ".$this->customerCarePhones("SECURITY");
			$notifier->send_sms($req->getParsedBody()['phone_no'],$sms_msg);
		}
		/**/

		$data = [
			"msg_data" => [ "customer_id"=>$customer->customer_id],
			"msg_status" => "OK"
		];
		return $res->withJSON($data,200);


	}
	


	//request_password_recovery
	public function request_password_recovery($req,$res,$args){
		$phone_no = $req->getParsedBody()['phone_no'];
		$GHelperUtil = new G_HelperUtil;
		$PassUtil = new G_PasswordUtility();
		$random_password = $GHelperUtil->getFreePassword(6);

		//check if phone no do exists
		$customer = Customer::where('phone',$phone_no)->first();
		if($customer != null){
			//create new OTP Entry(for recording only)
			$otp_obj = OTP::create([
				"secrete" => $random_password,
				"service_name" => "RECOVERY",
				"valid_till"=>$this->get_current_date_time(),
				"customer_id"=>$customer->id
			]);

			//resetting
			$customer->password = $PassUtil->encrypt($random_password);
			$customer->update();

			//send sms notification
			$notifier = new NotifierProvider();//customerCarePhones
			if($customer != null){
				$sms_msg = "(Posta) Ngugu Mteja,namba mpya ya siri ni ".$random_password." kwa msaada piga ".$this->customerCarePhones("SECURITY");
				$notifier->send_sms($customer->phone,$sms_msg);
			}
			/**/

			$data = [
				"msg_data" => [ "customer_id"=>$otp_obj->customer_id],
				"msg_status" => "OK"
			];
			return $res->withJSON($data,200);
			
		}else{
			$data = [
				"msg_data" => "Samahani namba hii bado haijasajiliwa!",
				"msg_status" => "OK"
			];
			return $res->withJSON($data,401);
		}
	}




	//verify_otp
	public function verify_otp($req,$res,$args){
		$given_otp = $req->getParsedBody()['otp'];
		$customer_id = $req->getParsedBody()['customer_id'];
		$otp_type = $req->getParsedBody()['otp_type'];

		$otp_obj = OTP::where('customer_id',$customer_id)
					->where('service_name',$otp_type)
					->orderBy('created_at','DESC')
					->first();


		if($otp_obj != null){
			//check if otp is valid
			if($this->get_current_date_time() < $otp_obj->valid_till){
                if($given_otp == $otp_obj->secrete){
					
					//mark phone verified 
                	Customer::where('id',$customer_id)->update([
                		"phone_verified"=>1
                	]);

					//--load user and new token
					$G_JWT = new G_JWT();
					$user = Customer::where('id','=',$customer_id)->first();
					$token = $G_JWT->get_token_for_user($user,$user->id);
					$data = [
						"msg_data" => [ "token" => $token,"user"=>$user],
						"msg_status" => "OK"
					];
					return $res->withJSON($data,200);

				}else{
					$data = [
						"msg_data" => "OTP si sahihi!",
						"msg_status" => "OK"
					];
					return $res->withJSON($data,401);
				}
			}else{
				$data = [
					"msg_data" => "Muda wa kuhakiki OTP umekwisha,jaribu kubonjeza kwenye resend ili uweze kutumiwa OTP mpya.",
					"msg_status" => "OK"
				];
				return $res->withJSON($data,401);
			}
		}
		else{
			$data = [
				"msg_data" => "Otp entry not found!",
				"msg_status" => "OK"
			];
			return $res->withJSON($data,401);
		}

	}

	//resend_reg_otp
	public function resend_reg_otp($req,$res,$args){
		$customer_id = $req->getParsedBody()['customer_id'];
		$otp_type = $req->getParsedBody()['otp_type'];

		$GHelperUtil = new G_HelperUtil;
		$auto_otp = $GHelperUtil->getFreeOTP(4);
		$valid_till = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." +10 minutes"));//waiting for 10 min

		$otp_obj = OTP::create([
			"secrete" => $auto_otp,
			"service_name" => "REGISTRATION_RESEND",
			"valid_till"=>$valid_till,
			"customer_id"=>$customer_id
		]);
		$customer = Customer::find($customer_id);
		//send sms notification
		$notifier = new NotifierProvider();//customerCarePhones
		if($customer != null){
			$sms_msg = "(Posta) Ngugu Mteja,ingiza ".$auto_otp." kuhakiki usajili,asante kwa kujiunga na huduma zetu.";
			//" kwa msaada piga ".$this->customerCarePhones("SECURITY");
			$notifier->send_sms($customer->phone,$sms_msg);

			//--load user and new token
			$G_JWT = new G_JWT();
			$token = $G_JWT->get_token_for_user($customer,$customer_id);
			$data = [
				"msg_data" => [ "token" => $token,"user"=>$customer],
				"msg_status" => "OK"
			];
			return $res->withJSON($data,200);
		}
		else{
			$data = [
				"msg_data" => "Samahani Mteja,Ombi lako linashughulikiwa!",
				"msg_status" => "OK"
			];
			return $res->withJSON($data,401);
		}
		/**/


	}






}