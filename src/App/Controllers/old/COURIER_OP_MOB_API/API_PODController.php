<?php
namespace App\Controllers\COURIER_OP_MOB_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\UploadedFile;


use App\Models\Manifest;
use App\Models\Pod;
use App\Models\ProductMovementHistory;
use App\Models\Customer;


use App\Notify\NotifierProvider;

class API_PODController extends BaseController{



	//mark as delivered
    public function mark_pod($req,$res,$args){
    	$uploadedFiles = $req->getUploadedFiles();
        if (sizeof($uploadedFiles) == 0) {
            return $res->withJSON(["msg_data"=>"FILE NOT FOUND IN POSTED REQUEST!!"],405);
        }
        else{
        	$rand_code = bin2hex(random_bytes(4));

        	$body = json_decode($req->getParsedBody()['data'],true);
        	$manifest_id = $body['manifest_id'];
        	$receiver_name = $body['receiver_name'];
        	$receiver_phone = $body['receiver_phone'];
        	$manifest_track_no = $body['manifest_track_no'];
        	$worker_id = $body['worker_id'];
        	$customer_id = $body['customer_id'];
        	$product_id = $body['product_id'];
        	$pic_name = $manifest_track_no."_".$rand_code;
        	$received_date = date('Y-m-d');
        	$received_time = date('h:m:sa');


        	$uploadedFile = $uploadedFiles['file'];
        	$extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);//eg song.mp4 - mp4
        	$file_name_without_ext = pathinfo($uploadedFile->getClientFilename(), PATHINFO_FILENAME);
        	//eg song.mp4 -song
        	move_uploaded_file($uploadedFile->file, $this->get_media_uploads_path()."/".$pic_name.".".$extension);
        	if(file_exists($this->get_media_uploads_path()."/".$pic_name.".".$extension)){
        		//save entry to DB
        		/*
        		:check if pod exists
        		*/
        		$prevPod = Pod::where('manifest_track_no',$manifest_track_no)->first();
        		if($prevPod != null){
        			$prevPod->delete();
        		}
        		$Pod = new Pod;
        		$Pod->manifest_track_no = $manifest_track_no;
        		$Pod->receiver_name = $receiver_name;
        		$Pod->receiver_phone = $receiver_phone;
        		$Pod->worker_id = $worker_id;
        		$Pod->product_id = $product_id;
        		$Pod->received_date = $received_date;
        		$Pod->received_time = $received_time;
        		$Pod->pic_name = $pic_name.".".$extension;
        		$Pod->save();

        		/**/
				$ManifestObj = Manifest::where('id',$manifest_id)->first();
				$ManifestObj->status = "DELIVERED";
				$ManifestObj->received_date = $received_date;
				$ManifestObj->remarks = "DELIVERED to ".$receiver_name . ' with '.$receiver_phone;
				$ManifestObj->save();


				/**/
				//create a mov history
				$mov_hist = new ProductMovementHistory;
				$mov_hist->track_no = $manifest_track_no;
				$mov_hist->manifest_id = $manifest_id;
				$mov_hist->worker_id = $worker_id;
				$mov_hist->status = "DELIVERED";
				$mov_hist->description = "[ DELIVERED ] to ".$receiver_name . ' with '.$receiver_phone;
				$mov_hist->save();

				//find the customer to send email/sms to
				$customer = Customer::where('id',$customer_id)->first();

				//send sms notification
				$notifier = new NotifierProvider();
				if($customer != null){
					$notifier->send_sms($customer->phone,"[ Delivered ] Your product with TRACK-ID (".$manifest_track_no.") is delivered safely to "
						.$receiver_name. '\nThank you for using our service.');
				}
				/**/
				$results = Manifest::where('id',$manifest_id)->first();
				return $res->withJSON(["msg_data"=>$results],200);
        		/**/
        	}else{
        		return $res->withJSON(["msg_data"=>"FILE TO SAVE THE FILE"],405);
        	}
        }
    }







}

?>