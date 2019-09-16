<?php
namespace App\Controllers\POSTA;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Illuminate\Database\Capsule\Manager as DB;

use App\Models\Center;
use App\Models\IOArrival;
use App\Models\IODeparture;

class API_BoardsController extends BaseController{

	/*for displaying boards*/
	public function custom_board_player($req,$res,$args){
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
	/*
	* ARRIVALS (buses,flights,trains,ships) 
	*/
	public function get_board_arrivals($req,$res,$args){
		$io_mode = $this->helperController->get_io_with_connector_for_arrival_departure_from_io_mode($args['io_mode']);
		$IOArrival = IOArrival::where('date_exp_arrival','>=',$args['start_date'])
		 				->where('date_exp_arrival','<=',$args['end_date'])
		 				->where('io_mode','=',$args['io_mode'])
		 				->where('id_center_to','=',$args['center_id'])
		 				->where('rec_department_id','=',$args['dep_id'])
		 				->with($io_mode)//dynamically connect to a given table
		 				->orderby('date_exp_arrival','DESC')
		 				->get();
		$data = [
			"msg_data" => $IOArrival,
			"msg_status" => "OK"
		];
		return $res->withJSON($data,200);
	}
	public function get_board_departures($req,$res,$args){
		$io_mode = $this->helperController->get_io_with_connector_for_arrival_departure_from_io_mode($args['io_mode']);
		$IODeparture = IODeparture::where('date_exp_departure','>=',$args['start_date'])
		 				->where('date_exp_departure','<=',$args['end_date'])
		 				->where('io_mode','=',$args['io_mode'])
		 				->where('id_center_from','=',$args['center_id'])
		 				->where('rec_department_id','=',$args['dep_id'])
		 				->with($io_mode)//dynamically connect to a given table
		 				->orderby('date_exp_departure','DESC')
		 				->orderby('id','DESC')
		 				->get();
		$data = [
			"msg_data" => $IODeparture,
			"msg_status" => "OK"
		];
		return $res->withJSON($data,200);
	}

}