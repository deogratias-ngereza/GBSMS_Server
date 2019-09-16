<?php
namespace App\Controllers\GB_SMS_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\CustomerAccount as Account;
use App\Models\SMSOutgoing as SMSLog;
use App\Utilities\GKeyUtility;

use App\Utilities\G_QNotificationManager;
use App\Utilities\G_HelperUtil;

use App\Models\QueueApi\LogSMSSchBatch;


class API_GeneralController extends BaseController{


	/*validate the account and the given api key*/
	private function checkAccountStatus($account,$key){
		if($account == null){
			return [
				"status"=>false,
				"data"=>[
					"code"=>4004,
					"code_msg"=>"Invalid Account!",
					"msg_status" => "Invalid Account!"
				]
			];
		}
		if($account->api_key != $key){
			return [
				"status"=>false,
				"data"=>[
					"code"=>4003,
					"code_msg"=>"Invalid Api-Key!",
					"msg_status" => "Invalid Api-Key!"
				]
			];
		}
		if($account->suspended == 1){
			return [
				"status"=>false,
				"data"=>[
					"code"=>4005,
					"code_msg"=>"Account Suspended.",
					"msg_status" => "Account Suspended."
				]
			];
		}
		return ['status'=>true,'data'=>[]];//if oky
	}





	/*
		SEND SMS
	*/
	public function send_sms($req,$res,$args){
		
		$helper = new G_HelperUtil();

		$accountInput = $req->getParsedBody()['account'];
		$messageObj = $req->getParsedBody()['message'];
		$account = Account::where('code',$accountInput['account_no'])->first();
		$acc_status = $this->checkAccountStatus($account,$accountInput['api_key']);
 		if($acc_status['status'] == false) return $res->withJSON($acc_status['data'],200);

 		//grab the clean inputs
 		$account_no = $account->code;
 		$sms_text = $messageObj['text'];
 		$sms_rec_phone = $messageObj['recepient_phone'];
 		$sms_sender_name = isset($messageObj['sender_name']) ? $messageObj['sender_name'] : 'INFO';
 		$sms_total_units = $helper->totalSMSCountInBody($sms_text);
 		$sms_total_chars = strlen($sms_text);

 		//if max characters reached 480 -> 3 sms ::TODO-check non numeric chats
 		if($sms_total_chars >= 480 || $helper->hasNonNumericChars($sms_text)){
 			return $res->withJson([
				"code"=>4012,
				"code_status" => "Message too long (max 480 characters)",
				"msg_status" => "ERROR"
			])->withStatus(200); 
 		}

 		//check if current quota allows
 		if($sms_total_units >= $account->sms_quota){
 			return $res->withJson([
				"code"=>4007,
				"code_status" => "Insufficient units - $account->sms_quota units remained and $sms_total_units units was requested.",
				"msg_status" => "ERROR"
			])->withStatus(200);
 		}



 		//send_sms($acc,$receiver_phone,$sms_body,$_tag = '')
 		$notifier = new G_QNotificationManager(true,true);
 		$queue_response = $notifier->send_sms($account->sms_gqaccount_no,$sms_rec_phone,$sms_text,$account->code,$sms_sender_name); 
 		if($queue_response == null){
 			return $res->withJson([
				"code"=>5001,
				"code_status" => "Sms Registration Error!",
				"msg_status" => "ERROR"
			])->withStatus(200); 
 		}


 		//create the entry
 		$smsLog = new SMSLog();
 		$smsLog->sms_body = $sms_text;
 		$smsLog->contact_phone = $sms_rec_phone;
 		$smsLog->customer_id = $account->id;
 		$smsLog->sys_ref = $queue_response;
 		//$smsLog->app_ref = $queue_response;
 		//$smsLog->api_ref = $queue_response;
 		$smsLog->created_date = date('Y-m-d');
 		$smsLog->created_at = date('Y-m-d H:i:s');
 		$smsLog->gq_sms_acc_no = $account->sms_gqaccount_no;
 		//$smsLog->batch_id = $sms_rec_phone;
 		$smsLog->sms_text_length = $sms_total_chars;
 		$smsLog->sender_name = $sms_sender_name;
 		$smsLog->sms_units = $sms_total_units;
 		$smsLog->queued_date = date('Y-m-d');
 		$smsLog->queued_at = date('Y-m-d H:i:s');
 		$smsLog->save();


 		//reduce no of sms from quota
 		$older_quota_count = $account->sms_quota;
 		$new_sms_quota = $older_quota_count - ($sms_total_units);
 		$account->sms_quota = $new_sms_quota;
 		$account->update();

 		//add sms quota
		return $res->withJson([
			"code"=>0001, 
			"code_status" => "Sms Queued For delivery",
			"msg_status" => "OK",
			"reference" => $queue_response,
			"sms_quota" => $new_sms_quota,
			"units_consumed" => $sms_total_units,
		])->withStatus(200); 
	}

	/*
		SEND BULKY SMS
		recepients[array of string(phone numbers)]
	*/
	public function send_bulky_sms($req,$res,$args){
		$helper = new G_HelperUtil();

		$accountInput = $req->getParsedBody()['account'];
		$messageObj = $req->getParsedBody()['message'];
		$receiversListInString = $req->getParsedBody()['recepients'];
		$account = Account::where('code',$accountInput['account_no'])->first();
		$acc_status = $this->checkAccountStatus($account,$accountInput['api_key']);
 		if($acc_status['status'] == false) return $res->withJSON($acc_status['data'],200);

 		//grab the clean inputs
 		$account_no = $account->code;
 		$sms_text = $messageObj['text'];
 		$sms_sender_name = isset($messageObj['sender_name']) ? $messageObj['sender_name'] : 'INFO';
 		$sms_total_units = ($helper->totalSMSCountInBody($sms_text)) * sizeof($receiversListInString);
 		$sms_total_chars = strlen($sms_text);


 		//if max characters reached 480 -> 3 sms ::TODO-check non numeric chats
 		if($sms_total_chars >= 480 || $helper->hasNonNumericChars($sms_text)){
 			return $res->withJson([
				"code"=>4012,
				"code_status" => "Message too long (max 480 characters)",
				"msg_status" => "ERROR"
			])->withStatus(200); 
 		}

 		//check if current quota allows
 		if($sms_total_units >= $account->sms_quota){
 			return $res->withJson([
				"code"=>4007,
				"code_status" => "Insufficient units - $account->sms_quota units remained and $sms_total_units units was requested.",
				"msg_status" => "ERROR"
			])->withStatus(200);
 		}

 		$main_batch_id = $helper->getFreeBatchId();


 		//create the entry
 		$smsLog = new SMSLog();
 		$smsLog->sms_body = $sms_text;
 		$smsLog->contact_phone = 'BULKY';
 		$smsLog->customer_id = $account->id;
 		$smsLog->sys_ref = $main_batch_id;
 		//$smsLog->app_ref = $queue_response;
 		//$smsLog->api_ref = $queue_response;
 		$smsLog->created_date = date('Y-m-d');
 		$smsLog->created_at = date('Y-m-d H:i:s');
 		$smsLog->gq_sms_acc_no = $account->sms_gqaccount_no;
 		$smsLog->batch_id = $main_batch_id;
 		$smsLog->sms_text_length = $sms_total_chars;
 		$smsLog->sender_name = $sms_sender_name;
 		$smsLog->sms_units = $sms_total_units;
 		$smsLog->queued_date = date('Y-m-d');
 		$smsLog->queued_at = date('Y-m-d H:i:s');
 		$smsLog->save();


 		//reduce no of sms from quota
 		$older_quota_count = $account->sms_quota;
 		$new_sms_quota = $older_quota_count - ($sms_total_units);
 		$account->sms_quota = $new_sms_quota;
 		$account->update();


 		//
 		//put in small chunks batches
 		try{
 			$batch_groups = array_chunk($receiversListInString, $account->sms_chunk_capacity);
	 		//save chunks to batches db
	 		for($i = 0; $i < sizeof($batch_groups);$i++){

	 			$batchLog = new LogSMSSchBatch();
	 			$batchLog->batch_id = $main_batch_id;
	 			$batchLog->batch_no = $i + 1;
	 			$batchLog->recepients_json = json_encode($batch_groups[$i],true);
	 			$batchLog->created_date = date('Y-m-d');
	 			$batchLog->created_at = date('Y-m-d H:i:s');
	 			$batchLog->msg = $sms_text;
	 			$batchLog->total_recepients = sizeof($batch_groups[$i]);
	 			$batchLog->total_units = sizeof($batch_groups[$i]) * ($helper->totalSMSCountInBody($sms_text));
	 			//$batchLog->sent_units = "";
	 			$batchLog->msg_length = strlen($sms_text);
	 			//$batchLog->response_type = "";
	 			//$batchLog->response_info = "";
	 			//$batchLog->error_info = "";
	 			//$batchLog->exec_at = "";
	 			$batchLog->sent_at = "";
	 			//$batchLog->trials_count = "";
	 			$batchLog->on_lock = 0;
	 			//$batchLog->on_lock_since = "";
	 			$batchLog->customer_id = $account->id;
	 			$batchLog->customer_code = $account->code;
	 			$batchLog->sms_gqaccount_no = $account->sms_gqaccount_no;
	 			$batchLog->sender_name = $sms_sender_name;
	 			$batchLog->save();
	 		}
 		}catch(\Exception $ex){
 			//handle error on fail to make batches
 		}
 		

 		


 		//add sms quota
		return $res->withJson([
			"code"=>0001, 
			"code_status" => "Batch Queued For delivery",
			"msg_status" => "OK",
			"reference" => $main_batch_id,
			"sms_quota" => $new_sms_quota,
			"units_consumed" => $sms_total_units,
		])->withStatus(200);





		/*return $res->withJSON([
			"chunks" => $batch_groups,
			"msg"=>"Send bulky sms",
			'sms_count'=>$helper->totalSMSCountInBody($sms_text),
			'char_len'=>$sms_total_chars,
			"units"=>$sms_total_units,
			"rec"=>sizeof($receiversListInString)
		],200);*/ 
	}






	/*
		SENT SMS REPORT
	*/
	public function sent_sms_report($req,$res,$args){
		return $res->withJSON(["msg"=>"SMS SENT REPORTS"],200);
	}


	/*
		FAILED SMS REPORT
	*/
	public function failed_sms_report($req,$res,$args){
		return $res->withJSON(["msg"=>"SMS FAILED REPORTS"],200);
	}


	/*
		TRACK SMS WITH RECEIPT
	*/
	public function track_sms($req,$res,$args){
		return $res->withJSON(["msg"=>"TRACK SMS"],200);
	}










	//insert
	public function xinsert($req,$res,$args){
		$CustomerAccount = CustomerAccount::create($req->getParsedBody());
		$data = [
			"msg_data" => CustomerAccount::all()->last(),
			"msg_status" => $CustomerAccount == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(CustomerAccount::all()->last(),200);
	}

	public function xxxsend_sms($req,$res,$args){

		$Validator = new GKeyUtility();

		$data = [
			"d"=>$Validator->encrypt("password"),
			"v"=>$Validator->verify("passwordxdsdsd",$Validator->encrypt("password"))
		];

		return $res->withJSON($data,200);
	}

	
}