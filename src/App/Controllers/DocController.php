<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Illuminate\Database\Capsule\Manager as DB;

use App\Models\User;
use App\Utilities\G_JWT;


class DocController extends BaseController{

    public function get_api_documentation($req,$res,$args){

        $free_api=
[


["name" => "customer_accounts" ,"url"=>"/customer_accountss/","doc"=>"","method"=>"GET"],
["name" => "customer_accounts" ,"url"=>"/customer_accounts/{id}","doc"=>"","method"=>"GET"],
["name" => "customer_accounts" ,"url"=>"/customer_accounts_insert/","doc"=>"","method"=>"POST"],
["name" => "customer_accounts" ,"url"=>"/customer_accounts_update/{id}","doc"=>"","method"=>"POST"],
["name" => "customer_accounts" ,"url"=>"/customer_accounts_delete/{id}","doc"=>"","method"=>"GET"],
["name" => "" ,"url"=>"","doc"=>"","method"=>""],["name" => "" ,"url"=>"","doc"=>"","method"=>""],

["name" => "sms_contacts_list" ,"url"=>"/sms_contacts_lists/","doc"=>"","method"=>"GET"],
["name" => "sms_contacts_list" ,"url"=>"/sms_contacts_list/{id}","doc"=>"","method"=>"GET"],
["name" => "sms_contacts_list" ,"url"=>"/sms_contacts_list_insert/","doc"=>"","method"=>"POST"],
["name" => "sms_contacts_list" ,"url"=>"/sms_contacts_list_update/{id}","doc"=>"","method"=>"POST"],
["name" => "sms_contacts_list" ,"url"=>"/sms_contacts_list_delete/{id}","doc"=>"","method"=>"GET"],
["name" => "" ,"url"=>"","doc"=>"","method"=>""],["name" => "" ,"url"=>"","doc"=>"","method"=>""],

["name" => "sms_drafts" ,"url"=>"/sms_draftss/","doc"=>"","method"=>"GET"],
["name" => "sms_drafts" ,"url"=>"/sms_drafts/{id}","doc"=>"","method"=>"GET"],
["name" => "sms_drafts" ,"url"=>"/sms_drafts_insert/","doc"=>"","method"=>"POST"],
["name" => "sms_drafts" ,"url"=>"/sms_drafts_update/{id}","doc"=>"","method"=>"POST"],
["name" => "sms_drafts" ,"url"=>"/sms_drafts_delete/{id}","doc"=>"","method"=>"GET"],
["name" => "" ,"url"=>"","doc"=>"","method"=>""],["name" => "" ,"url"=>"","doc"=>"","method"=>""],

["name" => "sms_groups" ,"url"=>"/sms_groupss/","doc"=>"","method"=>"GET"],
["name" => "sms_groups" ,"url"=>"/sms_groups/{id}","doc"=>"","method"=>"GET"],
["name" => "sms_groups" ,"url"=>"/sms_groups_insert/","doc"=>"","method"=>"POST"],
["name" => "sms_groups" ,"url"=>"/sms_groups_update/{id}","doc"=>"","method"=>"POST"],
["name" => "sms_groups" ,"url"=>"/sms_groups_delete/{id}","doc"=>"","method"=>"GET"],
["name" => "" ,"url"=>"","doc"=>"","method"=>""],["name" => "" ,"url"=>"","doc"=>"","method"=>""],

["name" => "sms_histories" ,"url"=>"/sms_historiess/","doc"=>"","method"=>"GET"],
["name" => "sms_histories" ,"url"=>"/sms_histories/{id}","doc"=>"","method"=>"GET"],
["name" => "sms_histories" ,"url"=>"/sms_histories_insert/","doc"=>"","method"=>"POST"],
["name" => "sms_histories" ,"url"=>"/sms_histories_update/{id}","doc"=>"","method"=>"POST"],
["name" => "sms_histories" ,"url"=>"/sms_histories_delete/{id}","doc"=>"","method"=>"GET"],
["name" => "" ,"url"=>"","doc"=>"","method"=>""],["name" => "" ,"url"=>"","doc"=>"","method"=>""],

["name" => "sms_incommings" ,"url"=>"/sms_incommingss/","doc"=>"","method"=>"GET"],
["name" => "sms_incommings" ,"url"=>"/sms_incommings/{id}","doc"=>"","method"=>"GET"],
["name" => "sms_incommings" ,"url"=>"/sms_incommings_insert/","doc"=>"","method"=>"POST"],
["name" => "sms_incommings" ,"url"=>"/sms_incommings_update/{id}","doc"=>"","method"=>"POST"],
["name" => "sms_incommings" ,"url"=>"/sms_incommings_delete/{id}","doc"=>"","method"=>"GET"],
["name" => "" ,"url"=>"","doc"=>"","method"=>""],["name" => "" ,"url"=>"","doc"=>"","method"=>""],

["name" => "sms_outgoings" ,"url"=>"/sms_outgoingss/","doc"=>"","method"=>"GET"],
["name" => "sms_outgoings" ,"url"=>"/sms_outgoings/{id}","doc"=>"","method"=>"GET"],
["name" => "sms_outgoings" ,"url"=>"/sms_outgoings_insert/","doc"=>"","method"=>"POST"],
["name" => "sms_outgoings" ,"url"=>"/sms_outgoings_update/{id}","doc"=>"","method"=>"POST"],
["name" => "sms_outgoings" ,"url"=>"/sms_outgoings_delete/{id}","doc"=>"","method"=>"GET"],
["name" => "" ,"url"=>"","doc"=>"","method"=>""],["name" => "" ,"url"=>"","doc"=>"","method"=>""],


]

;

        $data["all"] = $free_api;
        $data["web"] = $free_api;
        $data["auth"] = $free_api;
        //return json_encode($data);
        $this->view($res,'App/doc.phtml', $data);
    }


    

}