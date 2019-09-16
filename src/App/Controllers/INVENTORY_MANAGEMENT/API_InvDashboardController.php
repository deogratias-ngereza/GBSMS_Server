<?php
namespace App\Controllers\INVENTORY_MANAGEMENT;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use App\Models\TM_Worker;
use App\Models\InvItem;
use App\Models\InvOrder;
use App\Models\InvSupplier;
use App\Models\InvOrderParticular;

class API_InvDashboardController extends BaseController{



    //summary
    public function summary($req,$res,$args){

        $total_suppliers = InvSupplier::count();
        $total_items = InvItem::count();
        $total_orders = InvOrder::count();

        //calc total wealth --> multiple currency.

        $sample_orders = InvOrder::with(['supplier'])->skip(0)->take(5)->get();
        $sample_ofs_items = InvItem::where('current_stock_qty',0)->skip(0)->take(5)->get();
        $total_ofs_items = InvItem::where('current_stock_qty',0)->count();
        
        $data = [
            "msg_data" => [
            	"total_items"=>$total_items,
            	"total_orders"=>$total_orders,
            	"total_ofs_items"=>$total_ofs_items,
            	//"total_wealth"=>$total_deliveries, 
            	"total_suppliers"=>$total_suppliers,
            	"sample_orders"=>$sample_orders,
            	"sample_ofs_items"=>$sample_ofs_items
            ],
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }






}