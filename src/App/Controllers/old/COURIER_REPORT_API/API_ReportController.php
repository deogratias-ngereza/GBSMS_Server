<?php
namespace App\Controllers\COURIER_REPORT_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Wh_Product;
use App\Models\Warehouse;
use App\Models\Manifest;
use App\Models\ProductMovementHistory;
use App\Models\Customer;
use App\Notify\NotifierProvider;




class API_ReportController extends BaseController{
//
    //all
    public function all_customers($req,$res,$args){
        $Customer = Customer::where('is_company',1)->with('manager')->orderBy('id','desc')->get();
        $data = [
            "msg_data" => $Customer,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }



    public function all_wh_products($req,$res,$args){
        $Wh_Product = Wh_Product::all();
        $data = [
            "msg_data" => $Wh_Product,
            "msg_status" => "OK"
        ];
        
        $data = [
            "msg_data" => $Wh_Product,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }


    //all
    public function all_warehouses($req,$res,$args){
        $Warehouse = Warehouse::all();
        $data = [
            "msg_data" => $Warehouse,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }




    //manifests
    public function search_manifests($req,$res,$args){
    	$Manifest = null;

    	$start_date = trim($req->getQueryParams()['start_dt'],"'");
    	$end_date = trim($req->getQueryParams()['end_dt'],"'");
    	$customer_id = trim($req->getQueryParams()['cust_id'],"'");


    	$Manifest = Manifest::where('customer_id',$customer_id)
    			->where('created_date','>=',$start_date." 00:00:00")
                ->where('created_date','<=',$end_date." 23:59:59")
        		->with(['product','customer','sender_worker','receiver_worker','source_warehouse','destination_warehouse','transporter','pod','cash_requests'])
        		->orderBy('id', 'DESC')
        		->get();
        $data = [
            "msg_data" => $Manifest,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }

    //search by date/customer
    public function search_manifests_by_cust_date($req,$res,$args){
        $Manifest = null;

        $start_date = trim($req->getQueryParams()['start_dt'],"'");
        $end_date = trim($req->getQueryParams()['end_dt'],"'");
        $customer_id = trim($req->getQueryParams()['cust_id'],"'");


        $Manifest = Manifest::where('customer_id',$customer_id)
                ->where('created_date','>=',$start_date." 00:00:00")
                ->where('created_date','<=',$end_date." 23:59:59")
                ->with(['product','customer','sender_worker','receiver_worker','source_warehouse','destination_warehouse','transporter','pod','cash_requests'])
                ->orderBy('id', 'DESC')
                ->get();
        $data = [
            "msg_data" => $Manifest,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }
    //search by date/customer/sd
    public function search_manifests_by_cust_date_sd($req,$res,$args){
        $Manifest = null;

        $start_date = trim($req->getQueryParams()['start_dt'],"'");
        $end_date = trim($req->getQueryParams()['end_dt'],"'");
        $customer_id = trim($req->getQueryParams()['cust_id'],"'");
        $wh_id = trim($req->getQueryParams()['wh_id'],"'");


        $Manifest = Manifest::where('customer_id',$customer_id)
                ->where('created_date','>=',$start_date." 00:00:00")
                ->where('created_date','<=',$end_date." 23:59:59")
                ->with(['product','customer','sender_worker','receiver_worker','source_warehouse','destination_warehouse','transporter','pod','cash_requests'])
                ->whereRaw("(source_warehouse_id = ".$wh_id." OR destination_warehouse_id=".$wh_id.")")
                ->orderBy('id', 'DESC')
                ->get();
        $data = [
            "msg_data" => $Manifest,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }
    //search by date/customer/product
    public function search_manifests_by_cust_date_product($req,$res,$args){
        $Manifest = null;

        $start_date = trim($req->getQueryParams()['start_dt'],"'");
        $end_date = trim($req->getQueryParams()['end_dt'],"'");
        $customer_id = trim($req->getQueryParams()['cust_id'],"'");
        $product_id = trim($req->getQueryParams()['product_id'],"'");


        $Manifest = Manifest::where('customer_id',$customer_id)
                ->where('created_date','>=',$start_date." 00:00:00")
                ->where('created_date','<=',$end_date." 23:59:59")
                ->where('product_id','=',$product_id)
                ->with(['product','customer','sender_worker','receiver_worker','source_warehouse','destination_warehouse','transporter','pod','cash_requests'])
                ->orderBy('id', 'DESC')
                ->get();
        $data = [
            "msg_data" => $Manifest,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }

    //search by date/customer/product/warehouse
    public function search_manifests_by_cust_date_product_warehouse($req,$res,$args){
        $Manifest = null;

        $start_date = trim($req->getQueryParams()['start_dt'],"'");
        $end_date = trim($req->getQueryParams()['end_dt'],"'");
        $customer_id = trim($req->getQueryParams()['cust_id'],"'");
        $product_id = trim($req->getQueryParams()['product_id'],"'");
        $wh_id = trim($req->getQueryParams()['wh_id'],"'");


        $Manifest = Manifest::where('customer_id',$customer_id)
                ->where('created_date','>=',$start_date." 00:00:00")
                ->where('created_date','<=',$end_date." 23:59:59")
                ->where('product_id','=',$product_id)
                ->whereRaw("(source_warehouse_id = ".$wh_id." OR destination_warehouse_id=".$wh_id.")")
                ->with(['product','customer','sender_worker','receiver_worker','source_warehouse','destination_warehouse','transporter','pod','cash_requests'])
                ->orderBy('id', 'DESC')
                ->get();
        $data = [
            "msg_data" => $Manifest,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }






}

?>