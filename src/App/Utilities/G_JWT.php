<?php
namespace App\Utilities;
use \Firebase\JWT\JWT;

class G_JWT{

	private $key = 'your_secret_key_here';
	private $algorithm = 'HS256';
	public function __construct(){
	}




	public function get_token_for_user($user_obj,$user_id){
		$time = time();
		$token = [
		    "iss" => $user_obj,     // you may load user data when you validate, as user database name
		    "iat" => $time,             // when user claim this token/request
		    "exp" => ($time + 100),  //($time + 604800) 7 days expiration
		    "uid" => $user_id,             // it's a custom key in the token, kept user id for some purpose
		];
		$jwt = JWT::encode($token, $this->key);
		//$decoded = JWT::decode($jwt, $key, array('HS256'));
		return $jwt;
	}

	//
	public function is_token_valid($token){
		try{
			$decoded = JWT::decode($token, $this->key, array($this->algorithm));
			return true;
		}catch(\Firebase\JWT\ExpiredException $e){
			return false;
		}
	}
	public function get_decoded_token($token){
		try{
			$decoded = JWT::decode($token, $this->key, array($this->algorithm));
			return $decoded;
		}catch(\Firebase\JWT\ExpiredException $e){
			return null;
		}
	}

}



	/*
		$time = time();

		$key = 'your_secret_key_here';
		$token = [
		    "iss" => 'Johnny Cash',     // you may load user data when you validate, as user database name
		    "iat" => $time,             // when user claim this token/request
		    "exp" => ($time + 604800),  // 7 days expiration
		    "uid" => '123',             // it's a custom key in the token, kept user id for some purpose
		];
		$jwt = JWT::encode($token, $key);
		$decoded = JWT::decode($jwt, $key, array('HS256'));
		return json_encode($decoded,true);
		//print_r($decoded);*/

		/*
		 NOTE: This will now be an object instead of an associative array. To get
		 an associative array, you will need to cast it as such:
		*/

		//$decoded_array = (array) $decoded;

		/**
		 * You can add a leeway to account for when there is a clock skew times between
		 * the signing and verifying servers. It is recommended that this leeway should
		 * not be bigger than a few minutes.
		 *
		 * Source: http://self-issued.info/docs/draft-ietf-oauth-json-web-token.html#nbfDef
		 */
		//JWT::$leeway = 60; // $leeway in seconds
		//$decoded = JWT::decode($jwt, $key, array('HS256'));
		//return "jwt test";
?>



