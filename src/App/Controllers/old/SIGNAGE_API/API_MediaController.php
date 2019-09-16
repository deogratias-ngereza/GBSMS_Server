<?php
namespace App\Controllers\SIGNAGE_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Slim\Http\UploadedFile;

use App\Models\Media;
use App\Models\Channel;

class API_MediaController extends BaseController{

    //all
    public function all($req,$res,$args){
        $Media = Media::all();
        $data = [
            "msg_data" => $Media,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
        return $res->withJSON($Media,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $Media = Media::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $Media,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
		return $res->withJSON($Media,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$Media = Media::where('id','=',$args['id'])->first();
		if(sizeof($Media) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$Media->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){

		$channel_with_company_obj = Channel::where('id',$req->getParsedBody()["channel_id"])->with('company')->first();
		$channel_fcode = $channel_with_company_obj->fcode;
		$company_fcode = $channel_with_company_obj->company->fcode;
		//return $res->withJSON(["channel_fcode"=>$channel_fcode,"company_fcode"=>$company_fcode,"data"=>$channel_with_company_obj],200);

		$uploadedFiles = $req->getUploadedFiles();
        if (sizeof($uploadedFiles) == 0) {
            return $res->withJSON(["msg"=>"FILE NOT FOUND IN POSTED REQUEST!!"],405);
        }
        else{
        	$uploadedFile = $uploadedFiles['file'];
        	//$this->log("info",$uploadedFile->file."-FILES EXISTS->".json_encode($uploadedFile,true)." will go :: ".$this->get_media_uploads_path());
        	//$rand_code = bin2hex(random_bytes(8));
        	$extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);//eg song.mp4 - mp4
        	$file_name_without_ext = pathinfo($uploadedFile->getClientFilename(), PATHINFO_FILENAME);//eg song.mp4 -song
        	move_uploaded_file($uploadedFile->file, $this->get_media_uploads_path()."/".$company_fcode."/".$channel_fcode."/".$req->getParsedBody()['code']);

        	if(file_exists($this->get_media_uploads_path()."/".$company_fcode."/".$channel_fcode."/".$req->getParsedBody()['code'])){
        		//save entry to DB
        		$Media = Media::create($req->getParsedBody());
        		return $res->withJSON(Media::all()->last(),200);
        	}else{
        		return $res->withJSON(["msg"=>"FILE TO SAVE THE FILE"],405);
        	}
        	
        }
		
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = Media::where('id',$args['id'])
						->update($updates);
		$results = Media::where('id',$args['id'])->first();
		$data = [
			"msg_data" => $results,
			"msg_status" => $update_status == 1 ? "FAIL TO UPDATE" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($results,200);
	}

	//search
	public function search($req,$res,$args){
		$key = trim($req->getQueryParams()['key'],"'");
		$Media = Media::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $Media,
			"msg_status" => sizeof($Media) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($Media,200);
	}



	//for downloading media file
    public function download_media($req,$res,$args){ //company_fcode,channel_fcode,media_name
        $file_name = $this->get_media_uploads_path()."/".$args['company_fcode'].'/'.$args['channel_fcode'].'/'.$req->getQueryParams()['name'];

        //check if image do exists
        if(file_exists($file_name)){
	        $response = $res->withHeader('Content-Description', 'File Transfer')
			   ->withHeader('Content-Type', 'application/octet-stream')
			   ->withHeader('Content-Disposition', 'attachment;filename="'.basename($file_name).'"')
			   ->withHeader('Expires', '0')
			   ->withHeader('Cache-Control', 'must-revalidate')
			   ->withHeader('Pragma', 'public')
			   ->withHeader('Content-Length', filesize($file_name));

			readfile($file_name);
			return $response;
        }else{
			return $res->withJSON(["msg" => "FILE NOT FOUND!!"],405);
        }
    }
    //for downloading media file
    public function render_media($req,$res,$args){ //company_fcode,channel_fcode,media_name
        $file_name = $this->get_media_uploads_path()."/".$args['company_fcode'].'/'.$args['channel_fcode'].'/'.$req->getQueryParams()['name'];

        //check if image do exists
        if(file_exists($file_name)){
	 		$fh = fopen($file_name, 'rb');

	        $stream = new \Slim\Http\Stream($fh); // create a stream instance for the response body

	        return $res->withHeader('Content-Type', 'application/force-download')
	                        ->withHeader('Content-Type', 'application/octet-stream')
	                        ->withHeader('Content-Type', 'application/download')
	                        ->withHeader('Content-Description', 'File Transfer')
	                        ->withHeader('Content-Transfer-Encoding', 'binary')
	                        ->withHeader('Content-Disposition', 'attachment; filename="' . basename($file_name) . '"')
	                        ->withHeader('Expires', '0')
	                        ->withHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
	                        ->withHeader('Pragma', 'public')
	                        ->withBody($stream); // all stream contents will be sent to the response
        }else{
			return $res->withJSON(["msg" => "FILE NOT FOUND!!"],405);
        }
    }



}