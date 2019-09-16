<?php
namespace App\Controllers\COURIER_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Illuminate\Database\Capsule\Manager as DB;

use App\Models\Manifest;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Pod;
use App\Models\CashRequest;
use App\Models\ProductMovementHistory;

use App\Notify\NotifierProvider;

class API_TrackerController extends BaseController{


    //track all details
    public function track_custom_overall($req,$res,$args){
        $trackNo = $args['track_no'];
        $track_opt = trim($req->getQueryParams()['opt'],"'");

        if($track_opt == 'awb'){
            //by simply a track no
            //get manifest information
            $Manifest = Manifest::where('manifest_track_no',$trackNo)->orWhere('ref_no',$trackNo)->with(['customer','invoice'])->first();

            if($Manifest != null){
                $trackNo = $Manifest->manifest_track_no;//edit the track no
                $Pod = Pod::where('manifest_track_no',$trackNo)->first();
                $CashReqs = CashRequest::where('manifest_track_no',$trackNo)->with('worker')->get();
                $history = ProductMovementHistory::where('track_no',$trackNo)->get();

                return $res->withJSON([
                    "manifest" => $Manifest,
                    "pod"=>$Pod,
                    "cash_requests"=>$CashReqs,
                    "history" => $history
                ],200);
            }else{
                return $res->withJSON([
                    "manifest" => [],
                    "pod"=>[],
                    "cash_requests"=>[],
                    "history" => []
                ],200);
            }
            
        }else{
            //by simply a track no
            //get manifest information
            $Manifest = Manifest::where('manifest_track_no',$trackNo)->orWhere('ref_no',$trackNo)->with(['customer','invoice'])->first();
            $Pod = Pod::where('manifest_track_no',$trackNo)->first();
            $CashReqs = CashRequest::where('manifest_track_no',$trackNo)->with('worker')->get();
            $history = ProductMovementHistory::where('track_no',$trackNo)->get();

            return $res->withJSON([
                "manifest" => $Manifest,
                "pod"=>$Pod,
                "cash_requests"=>$CashReqs,
                "history" => $history
            ],200);
        }

       
    }



}
