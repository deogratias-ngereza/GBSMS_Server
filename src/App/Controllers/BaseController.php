<?php

namespace App\Controllers;

//use App\Controllers\POSTA\HelperController;
use Slim\Http\UploadedFile;

class BaseController{
	protected $container;
    //protected $helperController;
	public function __construct($container)
    {
        $this->container = $container;
        //$this->helperController = new HelperController();
    }
    //easy rendering process twig-view
    public function view($res,$page,$args){
        return $this->container->view->render($res, $page, $args); //twig
    }

    //php view
    public function render($res,$page,$args){
        return $this->container->renderer->render($res, $page, $args);//php view
    }

    public function log($type,$msg){
        switch ($type) {
            case 'info':
                return $this->container->logger->info($msg);
                break;
            case 'debug':
                return $this->container->logger->debug($msg);
                break;
            case 'warning':
                return $this->container->logger->warning($msg);
                break;
            default:
                return $this->container->logger->info($msg);
                break;
        }
        //logger
    }

    public function get_media_uploads_path(){
        return $this->container->media_upload_directory;//
    }

    /**
     * Moves the uploaded file to the upload directory and assigns it a unique name
     * to avoid overwriting an existing uploaded file.
     *
     * @param string $directory directory to which the file is moved
     * @param UploadedFile $uploaded file uploaded file to move
     * @return string filename of moved file
     */
    public function moveUploadedFile($directory, UploadedFile $uploadedFile)
    {
        try{
            $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
            $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
            $filename = sprintf('%s.%0.8s', $basename, $extension);

            $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

            return $filename;
        }catch(Exception $e){
            $this->container->logger->warning("ERROR DURRING SAVING THE FILE - ".$e->getMessage());
            return "";
        }
        
    }



    /*get current date*/
    public function get_current_date($format = "yyyy-mm-dd H:i:s"){
        switch ($format) {
            case 'yyyy-mm-dd':
                return date('Y-m-d');
                break;
            case 'yyyy-mm-dd H:i:s':
                return date('Y-m-d H:i:s');
                break;
            default:
                return date('Y-m-d H:i:s');
                break;
        }
    }

    public function get_current_time($format){
        return date("h:i:s");//a
    }
    public function get_current_date_time(){
        return date("Y-m-d h:i:s");//a
    }



    public function getLimitSize($opt){
        switch ($opt) {//S,M,L
            case 'S':return 100; break;
            case 'M':return 150; break;
            case 'L':return 200; break;
            case 'XL':return 400; break;
            case 'XXL':return 500; break;
            case 'XXXL':return 800; break;
            default:
                return 100;
                break;
        }
    }

    public function customerCarePhones($opt){
        switch ($opt) {
            case 'SECURITY':return "+255688059688"; break;
            default:
                return "+255688059688";
                break;
        }
    }

    /*return only this cols*/
    public function getCustomerApiSMSLogCols(){
        return [
             "id","sms_body","sent_date","sent_at","sent_time","status","contact_phone",
        "sys_ref","app_ref","api_ref","created_date","created_at","gq_sms_acc_no",
        "batch_id","sms_text_length","sender_name","sms_units","response_type","response_info",
        ];
    }

     public function getCustomerApiBatchSMSLogCols(){
        return [
             "batch_id","batch_no","status","recepients_json","created_date","created_at","msg","total_recepients",
            "total_units","sent_units","msg_length","response_type","response_info",
        ];
    }






    
}




?>