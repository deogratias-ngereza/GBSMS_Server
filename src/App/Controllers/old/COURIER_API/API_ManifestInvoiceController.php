<?php
namespace App\Controllers\COURIER_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Illuminate\Database\Capsule\Manager as DB;

use App\Models\Manifest;
use App\Models\Customer;
use App\Models\Invoice;

use App\Notify\NotifierProvider;

class API_ManifestInvoiceController extends BaseController{



    //filter by dates only
    public function get_manifests_2invoice_bydate($req,$res,$args){
        $Customer = Customer::where('id',$args['cust_id'])->first();
        $Manifest = Manifest::where('payment_status','PENDING')
                ->where('status','DELIVERED')
                ->where('customer_id',$args['cust_id'])
                ->where('created_date','>=',$args['start_date']." 00:00:00")
                ->where('created_date','<=',$args['end_date']." 23:59:59")
                ->where('invoice_no','NOT_SET')
                //->with(['product','source_warehouse','destination_warehouse','transporter'])
                ->orderBy('created_date', 'DESC')
                ->get();
        $data = [ "invoices" => $Manifest, "customer" => $Customer ];
        return $res->withJSON($data,200);//
    }

    //filter by dates only and source dest
    public function get_manifests_2invoice_bydateAndSrcDest($req,$res,$args){
        $wh_id = $args['wh_id'];
        $Customer = Customer::where('id',$args['cust_id'])->first();
        $Manifest = Manifest::where('payment_status','PENDING')
                ->where('status','DELIVERED')
                ->where('customer_id',$args['cust_id'])
                ->where('invoice_no','NOT_SET')
                ->where('created_date','>=',$args['start_date']." 00:00:00")
                ->where('created_date','<=',$args['end_date']." 23:59:59")
                ->whereRaw("(source_warehouse_id = ".$wh_id." OR destination_warehouse_id=".$wh_id.")")
                //->with(['product','source_warehouse','destination_warehouse','transporter'])
                ->orderBy('created_date', 'DESC')
                ->get();
        $data = [ "invoices" => $Manifest, "customer" => $Customer ];
        return $res->withJSON($data,200);//
    }

    //filter by source/destination
    public function get_manifests_2invoice_bySrcDest($req,$res,$args){
        $wh_id = $args['wh_id'];
        $Customer = Customer::where('id',$args['cust_id'])->first();
        $Manifest = Manifest::where('payment_status','PENDING')
                ->where('status','DELIVERED')
                ->where('customer_id',$args['cust_id'])
                ->where('invoice_no','NOT_SET')
                ->whereRaw("(source_warehouse_id = ".$wh_id." OR destination_warehouse_id=".$wh_id.")")
                //->with(['product','source_warehouse','destination_warehouse','transporter'])
                ->orderBy('created_date', 'DESC')
                ->get();
        $data = [ "invoices" => $Manifest, "customer" => $Customer ];
        return $res->withJSON($data,200);//
    }
    //filter by all pendings
    public function get_manifests_2invoice_byPending($req,$res,$args){
        $Customer = Customer::where('id',$args['cust_id'])->first();
        $Manifest = Manifest::where('payment_status','PENDING')
                ->where('customer_id',$args['cust_id'])
                ->where('status','DELIVERED')
                ->where('invoice_no','NOT_SET')
                //->with(['product','source_warehouse','destination_warehouse','transporter'])
                ->orderBy('created_date', 'DESC')
                ->get();
        $data = [ "invoices" => $Manifest, "customer" => $Customer ];
        return $res->withJSON($data,200);//
    }
    //get_manifests_2invoice_byProductId
    public function get_manifests_2invoice_byProductId($req,$res,$args){//
        $Customer = Customer::where('id',$args['cust_id'])->first();
        $Manifest = Manifest::where('payment_status','PENDING')
                ->where('customer_id',$args['cust_id'])
                ->where('product_id',$args['product_id'])
                ->where('status','DELIVERED')
                ->where('invoice_no','NOT_SET')
                //->with(['product','source_warehouse','destination_warehouse','transporter'])
                ->orderBy('created_date', 'DESC')
                ->get();
        $data = [ "invoices" => $Manifest, "customer" => $Customer ];
        return $res->withJSON($data,200);//
    }
     //get_manifests_2invoice_byProductId And source destination
    public function get_manifests_2invoice_byProductIdAndSrcDest($req,$res,$args){//
        $wh_id = $args['wh_id'];
        $Customer = Customer::where('id',$args['cust_id'])->first();
        $Manifest = Manifest::where('payment_status','PENDING')
                ->where('customer_id',$args['cust_id'])
                ->where('product_id',$args['product_id'])
                ->where('status','DELIVERED')
                ->where('invoice_no','NOT_SET')
                ->whereRaw("(source_warehouse_id = ".$wh_id." OR destination_warehouse_id=".$wh_id.")")
                //->with(['product','source_warehouse','destination_warehouse','transporter'])
                ->orderBy('created_date', 'DESC')
                ->get();
        $data = [ "invoices" => $Manifest, "customer" => $Customer ];
        return $res->withJSON($data,200);//
    }

     //get_manifests_2invoice_byProductId And source destinationcAndDate
    public function get_manifests_2invoice_byProductIdAndSrcDestAndDate($req,$res,$args){//
        $wh_id = $args['wh_id'];
        $Customer = Customer::where('id',$args['cust_id'])->first();
        $Manifest = Manifest::where('payment_status','PENDING')
                ->where('customer_id',$args['cust_id'])
                ->where('product_id',$args['product_id'])
                ->where('status','DELIVERED')
                ->where('invoice_no','NOT_SET')
                ->where('created_date','>=',$args['start_date']." 00:00:00")
                ->where('created_date','<=',$args['end_date']." 23:59:59")
                ->whereRaw("(source_warehouse_id = ".$wh_id." OR destination_warehouse_id=".$wh_id.")")
                //->with(['product','source_warehouse','destination_warehouse','transporter'])
                ->orderBy('created_date', 'DESC')
                ->get();
        $data = [ "invoices" => $Manifest, "customer" => $Customer ];
        return $res->withJSON($data,200);//
    }










    /*ASSIGN MANIFEST TO INVOICES*/
    public function assign_manifest_2_invoice($req,$res,$args){

        $manifestsIDs = $req->getParsedBody()['manifests_list'];
        $invoice_no = $req->getParsedBody()['invoice_no'];


        //create new invoice object
        $invoice = new Invoice();
        $invoice->invoice_no = $invoice_no;
        $invoice->req_amt = $req->getParsedBody()['req_amt'];
        $invoice->created_by = $req->getParsedBody()['created_by'];
        $invoice->due_amt = $req->getParsedBody()['req_amt'];
        $invoice->due_date = $req->getParsedBody()['due_date'];
        $invoice->customer_id = $req->getParsedBody()['customer_id'];
        $invoice->save();

        //updates manifests
        Manifest::whereIn("id",$manifestsIDs)
                  ->update([
                    'invoice_no' => $invoice_no
                  ]);
        return $res->withJSON(["data"=>$invoice],200);
    }

    //get manifests from assigned invoice no
    public function get_manifests_for_given_invoice($req,$res,$args){
        $invoice_no = $args['invoice_no'];
        $Manifests = Manifest::where('invoice_no',$invoice_no)->orderBy('created_date','DESC')->get();
        $Invoice = Invoice::where('invoice_no',$invoice_no)->with(['customer'])->first();
        return $res->withJSON(["manifests"=>$Manifests,"invoice"=>$Invoice],200);
    }

    //mark_invoice_as_paid
     public function mark_invoice_as_paid($req,$res,$args){

        $invoice_no = $req->getParsedBody()['invoice_no'];
        $invoice_id = $req->getParsedBody()['invoice_id'];
        $received_by = $req->getParsedBody()['receiver_id'];
        $req_amt = $req->getParsedBody()['req_amt'];
        $payment_mode = $req->getParsedBody()['payment_mode'];
        $cheque_no = $req->getParsedBody()['cheque_no'];
        $description = $req->getParsedBody()['description'];
        Invoice::where('id',$invoice_id)->update([
            "paid_amt"=>$req_amt,
            "due_amt"=>0,
            "cleared"=>1,
            "received_by"=>$received_by,
            "payment_mode" => $payment_mode,
            "cheque_no" => $cheque_no,
            "description" => $description,
            "paid_date"=>date('Y-m-d')
        ]);
        

        $q = "UPDATE manifests as M SET paid_amt= M.paid_amt,payment_status='PAID',payment_rec_by=".$received_by.",paid_date=".date('Y-m-d')." WHERE invoice_no='".$invoice_no."'";

        $results = DB::select(DB::raw($q));

        return $res->withJSON(["data"=>$results],200);


    }




















    /*********************************************************************/

	public function get_invoices_base_on_date($req,$res,$args){
		$Customer = Customer::where('id',$args['id'])->first();
		$Manifest = Manifest::where('payment_status','PENDING')
				->where('status','DELIVERED')
        		->where('created_date','>=',$args['start_date']." 12:00:01")
        		->where('created_date','<=',$args['end_date']." 11:59:59")
        		->with(['product','source_warehouse','destination_warehouse','transporter'])
        		->get();
       	$data = [ "invoices" => $Manifest, "customer" => $Customer ];
        return $res->withJSON($data,200);//
	}

    //
    public function get_customer_invoices($req,$res,$args){
    	$Customer = Customer::where('id',$args['id'])->first();
        $Manifest = Manifest::where('customer_id',$args['id'])
        		->where('status','DELIVERED')
        		->where('payment_status','PENDING')
        		->with(['product','source_warehouse','destination_warehouse','transporter'])
        		->get();
       	$data = [ "invoices" => $Manifest, "customer" => $Customer ];
        return $res->withJSON($data,200);
    }



    //mark_invoices_paid
    //TODO:: send confirmation email or sms on complation
    public function mark_invoices_paid($req,$res,$args){
    	$data = $req->getParsedBody();
    	/*$rec_ids = [];
    	for($i = 0; $i < sizeof($data); $i++){
    		//push 
    		array_push($rec_ids, $data[$i]['id']);
    	}
    	//return $req->getParsedBody();
    	return $res->withJSON(["data"=>$data,"size" =>sizeof($data),"[0]"=>$data[0]['id'],"arr"=>$rec_ids],200);*/
    	Manifest::whereIn("id",$data)
    			  ->update([
    			  	'payment_status' => 'PAID','payment_rec_by'=> $data['by']
    			  ]);
    	return $res->withJSON(["data"=>$data['invoices'],"size" =>sizeof($data['invoices'])],200);
    }



    /*
    PENDING
    CUSTOMER ID
    */
    public function overdue_invoices($req,$res,$args){
    	$Customer = Customer::where('id',$args['id'])->first();
    	$Today = date('Y-m-d');
        $Manifest = Manifest::where('customer_id',$args['id'])
        		->where('status','DELIVERED')
        		->where('due_date','>',$Today)
        		->where('payment_status','PENDING')
        		->with(['product','source_warehouse','destination_warehouse','transporter'])
        		->get();
       	$data = [ "invoices" => $Manifest, "customer" => $Customer ];
        return $res->withJSON($data,200);
    }



}