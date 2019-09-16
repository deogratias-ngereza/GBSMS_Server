<?php
namespace App\Controllers\COURIER_BOARDS_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Customer;

class API_BoardsController extends BaseController{


	/*BOARDS ACTUAL JSON API*/
    //all for warehouse
    public function all_for_warehouse($req,$res,$args){
    	$Manifest = null;
    	if($args['opt'] == "in"){//incomming
    		$Manifest = Manifest::where('destination_warehouse_id',$args['id'])
        		->with(['product','customer','sender_worker','receiver_worker','source_warehouse','destination_warehouse','transporter'])
        		->orderBy('id', 'DESC')
                ->take(50)
        		->get();
    	}else{
    		$Manifest = Manifest::where('source_warehouse_id',$args['id'])
        		->with(['product','customer','sender_worker','receiver_worker','source_warehouse','destination_warehouse','transporter'])
        		->orderBy('id','DESC')
                ->take(50)
        		->get();
    	}
        return $res->withJSON($Manifest,200);
    }
	/**/






    //render the board with the given ui
    public function custom_board_player($req,$res,$args){
    	$data = ["warehouse_id" => $args['warehouse_id'] ];
      	return $this->render($res,'courier_boards/index.php', $data);
        exit;
    }

    /*for displaying boards*/
	public function xcustom_board_player($req,$res,$args){
		$center_info = Center::where("center_code",(string)$args['center_code'])->with('board_constants')->first();
		$data = ["center_info" => $center_info,"department_id" =>$args['dep_id'],"io_mode"=>$args['io_mode']];

		switch($args['io_mode']){
			case 'LAND-BUSES' : return $this->render($res,'posta_boards/buses_board.php', $data); break;
			case 'MARINES' : return $this->render($res,'posta_boards/ships_board.php', $data); break;
			case 'FLIGHTS' : return $this->render($res,'posta_boards/flights_board.php',$data); break;
			case 'LAND-TRAINS' : return $this->render($res,'posta_boards/trains_board.php', $data); break;
			case 'default' : return $this->render($res,'posta_boards/buses_board.php', $data); break;
		}
		exit;
	}









    //find from given id
    public function find($req,$res,$args){
        $Customer = Customer::where("id","=",$args['id'])->first();
		return $res->withJSON($Customer,200);
    }


}