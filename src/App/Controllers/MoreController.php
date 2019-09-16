<?php
namespace App\Controllers;



use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class MoreController extends BaseController{
	public function test_resp($req,$res,$args){
		return $this->render($res,'test.phtml', $args);
	}
}


?>