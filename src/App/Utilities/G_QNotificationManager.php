<?php
namespace App\Utilities;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


class G_QNotificationManager{

	private $email_activated = true;
	private $sms_activated = true;




	//constructor
	public function __construct($email_ac = true,$sms_ac = true){
		$this->email_activated = $email_ac;
		$this->sms_activated = $sms_ac;
	}


	private function getSysRefToken($length = 3){
	     $token = "";
	     //$codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	     $codeAlphabet = "";
	     //$codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
	     $codeAlphabet.= "0123456789";
	     $max = strlen($codeAlphabet); // edited

	    for ($i=0; $i < $length; $i++) {
	        $token .= $codeAlphabet[random_int(0, $max-1)];

	    }

	    return date('dmYHis').''.$token;
	}




    
	public function sendEmail($acc,$receivers,$cc_list,$bcc_list,$header,$subject,$body,$is_html=1){


		if($this->email_activated == false) return;

		//echo "*** PHP R-MQ SENDER ***\n\n";  
		//error_reporting(E_ERROR | E_PARSE); 

 
		try{

			//create a connection
			$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
			$channel = $connection->channel();

			
			//channel declaration
			//$channel->queue_declare('gEmailNotifier', true, false, false, false);

			$channel->queue_declare(
			    'gEmailNotifier',    //queue - Queue names may be up to 255 bytes of UTF-8 characters
			    false,              //passive - can use this to check whether an exchange exists without modifying the server state
			    true,               //durable, make sure that RabbitMQ will never lose our queue if a crash occurs - the queue will survive a broker restart
			    false,              //exclusive - used by only one connection and the queue will be deleted when that connection closes
			    false               //auto delete - queue is deleted when last consumer unsubscribes
		    );
		    


		//$tpl_ui
			//send a message 
			$s = json_encode(
				[
					"account_no"=>$acc,//"0000001",//110011  0001 0000001
					"receivers" => $receivers,//["deograciousngereza@gmail.com"],//"komba.benjamin@gmail.com"
					"cc_list"=>$cc_list,//list of emails to cc
					"bcc_list"=>$bcc_list,
					"header" => $header, //eg Name of the company
					"subject" => $subject, 
					"body" => $body,//$tpl_ui,//"<h1>R-MQ-TEST Body</h1>",
					"is_html"=> $is_html
				]
			);
			//$msg = new AMQPMessage($s);
			$msg = new AMQPMessage(
		    	$s,
		    	array('delivery_mode' => 2) # make message persistent, so it is not lost if server crashes or quits
		    );
			$channel->basic_publish($msg, '', 'gEmailNotifier');

			//echo " [x] Msg Sent.'\n";


			$channel->close();
			$connection->close();

			//echo " \n[ Other tasks ] ";

		}
		catch(\Exception $x){
			//r-mq server is down
			//echo "[ R-MQ ERROR ]";
			//echo "Message:". $x->getMessage();
		}
	}



	/* 
		SEND SMS(single sms)
		- push sms to queue_background processir
	*/
	public function send_sms($acc,$receiver_phone,$sms_body,$_tag,$sender_name){

		//echo "*** PHP R-MQ SENDER ***\n\n";
		//error_reporting(E_ERROR | E_PARSE);

		$sys_ref = $this->getSysRefToken();
		$tag = $_tag;//just help sometimes to identify customer lateron

		if($this->sms_activated == false) return;
		try{

			//create a connection
			$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
			$channel = $connection->channel();

			
			//channel declaration
			//$channel->queue_declare('gSmsNotifier', true, false, false, false);

			$channel->queue_declare(
			    'gSmsNotifier',    //queue - Queue names may be up to 255 bytes of UTF-8 characters
			    false,              //passive - can use this to check whether an exchange exists without modifying the server state
			    true,               //durable, make sure that RabbitMQ will never lose our queue if a crash occurs - the queue will survive a broker restart
			    false,              //exclusive - used by only one connection and the queue will be deleted when that connection closes
			    false               //auto delete - queue is deleted when last consumer unsubscribes
		    );
		    


		//$tpl_ui
			//send a message 
			$s = json_encode(
				[ 
					"account_no"=>$acc,//"GMNXM01",//"MOVESMS01",
					"receiver_phone" => $receiver_phone,// "+255758083816",//"+255788449030",//"+254741067804",
					"message"=> $sms_body,
					"sys_ref" => $sys_ref,
					"tag"=> $tag,
					"sender_name"=> $sender_name,
				]
			);
			//$msg = new AMQPMessage($s);
			$msg = new AMQPMessage(
		    	$s,
		    	array('delivery_mode' => 2) # make message persistent, so it is not lost if server crashes or quits
		    );
			$channel->basic_publish($msg, '', 'gSmsNotifier');

			//echo " [x] Msg Sent.'\n";


			$channel->close();
			$connection->close();

			//echo " \n[ Other tasks ] ";

			return $sys_ref;

		}
		catch(\Exception $x){
			//r-mq server is down
			//echo "[ R-MQ ERROR ]";
			//echo "Message:". $x->getMessage();
			return null;
		}
	}

}