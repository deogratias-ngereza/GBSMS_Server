<?php
namespace App\Controllers\GB_CSMS_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\CustomerAccount as Account;
use App\Models\SMSOutgoing as SMSLog;
//use App\Models\SMSOutgoingHistory as SMSLog; 
use App\Utilities\GKeyUtility;

use App\Utilities\G_QNotificationManager;
use App\Utilities\G_HelperUtil;

use App\Models\QueueApi\LogSMSSchBatch;


class API_ReportController extends BaseController{
	

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


	//account information
	public function account($req,$res,$args){
		$accountInput = $req->getParsedBody()['account'];
		$account = Account::where('code',$accountInput['account_no'])->first();
		$acc_status = $this->checkAccountStatus($account,$accountInput['api_key']);
 		if($acc_status['status'] == false) return $res->withJSON($acc_status['data'],200);
 		return $res->withJson([
 				"account" => $account,
				"code"=>1001,
				"code_status" => "Account details",
				"msg_status" => "INFO"
			])->withStatus(200);
	}



	/*delivery report <receiptNO>*/
	public function dlr($req,$res,$args){
		$accountInput = $req->getParsedBody()['account'];
		$account = Account::where('code',$accountInput['account_no'])->first();
		$acc_status = $this->checkAccountStatus($account,$accountInput['api_key']);
 		if($acc_status['status'] == false) return $res->withJSON($acc_status['data'],200);

 		$receipt_no = $args['receipt_no'];

 		$Reports = SMSLog::where('sys_ref','=',$receipt_no)
	 			->get($this->getCustomerApiSMSLogCols()); 

	 	return $res->withJson([
			"receipt_no"=>$receipt_no,
			"code"=>1002,
			"code_status" => "Report details",
			"msg_status" => "REPORT",
			"receipt" => sizeof($Reports) != 0 ? $Reports[0] : null,
		])->withStatus(200);
 	}



 	/*batch_dlr delivery report <receiptNO>*/
	public function batch_dlr($req,$res,$args){ 
		$accountInput = $req->getParsedBody()['account'];
		$account = Account::where('code',$accountInput['account_no'])->first();
		$acc_status = $this->checkAccountStatus($account,$accountInput['api_key']);
 		if($acc_status['status'] == false) return $res->withJSON($acc_status['data'],200);
 		$batch_no = $args['batch_no'];

 		$BatchInfo = SMSLog::where('sys_ref','=',$batch_no)
	 			->get($this->getCustomerApiSMSLogCols()); 

	 	$batchEntriesHistory = LogSMSSchBatch::where('batch_id',$batch_no)->get($this->getCustomerApiBatchSMSLogCols());

	 	return $res->withJson([
			"receipt_no"=>$batch_no,
			"code"=>1002,
			"code_status" => "Report details",
			"msg_status" => "REPORT",
			"batch_info" => sizeof($BatchInfo) != 0 ? $BatchInfo[0] : null,
			"batch_entries" => $batchEntriesHistory
		])->withStatus(200);
 	}




	//sms history <start_date/end date/ status>
	public function sms_history($req,$res,$args){
		$accountInput = $req->getParsedBody()['account'];
		$account = Account::where('code',$accountInput['account_no'])->first();
		$acc_status = $this->checkAccountStatus($account,$accountInput['api_key']);
 		if($acc_status['status'] == false) return $res->withJSON($acc_status['data'],200);

 		$start_date = $args['start_date'];
 		$end_date = $args['end_date'];
 		$status_category = strtoupper($args['status']);

 		$helper = new G_HelperUtil();
 		$startDateValid = $helper->validateDate($start_date,'Y-m-d');
 		$endDateValid = $helper->validateDate($end_date,'Y-m-d');

 		//check if input dates are all fine b4 proceed.
 		if(!$startDateValid || !$endDateValid){
 			return $res->withJson([
				"code"=>5010,
				"code_status" => "Start Date /End date Format is invalid!",
				"msg_status" => "ERROR"
			])->withStatus(200);
 		}


 		//query from here....
 		$Reports = null;
 		switch ($status_category) {
 			case 'ALL':
 				$Reports = SMSLog::where('created_date','>=',$start_date)
	 			->where('created_date','<=',$end_date)
	 			->where('customer_id',$account->id)
	 			->get($this->getCustomerApiSMSLogCols()); 
 				break;
 			case 'BULKY':
 				$Reports = SMSLog::where('created_date','>=',$start_date)
	 			->where('created_date','<=',$end_date)
	 			->where('status',$status_category)
	 			->where('customer_id',$account->id)
	 			->get($this->getCustomerApiSMSLogCols()); 
 				break;
 			case 'TRIAL':
 				$Reports = SMSLog::where('created_date','>=',$start_date)
	 			->where('created_date','<=',$end_date)
	 			->where('status',$status_category)
	 			->where('customer_id',$account->id)
	 			->get($this->getCustomerApiSMSLogCols()); 
 				break;
 			case 'ERROR':
 				$Reports = SMSLog::where('created_date','>=',$start_date)
	 			->where('created_date','<=',$end_date)
	 			->where('status',$status_category)
	 			->where('customer_id',$account->id)
	 			->get($this->getCustomerApiSMSLogCols()); 
 				break;
 			case 'SENT':
 				$Reports = SMSLog::where('created_date','>=',$start_date)
	 			->where('created_date','<=',$end_date)
	 			->where('status',$status_category)
	 			->where('customer_id',$account->id)
	 			->get($this->getCustomerApiSMSLogCols()); 
 				break;
 			case 'OK':
 				$Reports = SMSLog::where('created_date','>=',$start_date)
	 			->where('created_date','<=',$end_date)
	 			->where('status',$status_category)
	 			->where('customer_id',$account->id)
	 			->get($this->getCustomerApiSMSLogCols()); 
 				break;
 			case 'NULL':
 				$Reports = SMSLog::where('created_date','>=',$start_date)
	 			->where('created_date','<=',$end_date)
	 			->where('status',null)
	 			->where('customer_id',$account->id)
	 			->get($this->getCustomerApiSMSLogCols()); 
 				break;
 			case 'EMPTY':
 				$Reports = SMSLog::where('created_date','>=',$start_date)
	 			->where('created_date','<=',$end_date)
	 			->where('status','')
	 			->where('customer_id',$account->id)
	 			->get($this->getCustomerApiSMSLogCols()); 
 				break;
 			default:
 				$Reports = SMSLog::where('created_date','>=',$start_date)
	 			->where('created_date','<=',$end_date)
	 			->where('customer_id',$account->id)
	 			->get($this->getCustomerApiSMSLogCols()); 
	 			break;
 		}

 		return $res->withJson([
			"start_date"=>$start_date,
			"end_date"=>$end_date,
			"counts"=>sizeof($Reports),
			"query"=> $status_category,
			"code"=>1002,
			"code_status" => "Report details",
			"msg_status" => "REPORT",
			"reports" => $Reports,
		])->withStatus(200);
	}



}