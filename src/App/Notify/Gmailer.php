<?php
namespace App\Notify;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


 set_time_limit(0);
 ini_set('display_errors',1);
 ini_set('display_startup_errors',1);
 error_reporting(0);

class GMailer{
    public function __construct() {
    }


    public function SEND_BASIC_EMAIL(){
    	//C:\Program Files\app_certificates\
    	/*$ch = curl_init();
    	$certificate_location = "C:\Program Files (x86)\EasyPHP-Devserver-16.1\ca-bundle.crt"; // modify this lineaccordingly (may need to be absolute)
		curl_setopt($ch, CURLOPT_CAINFO, $certificate_location);
		curl_setopt($ch, CURLOPT_CAPATH, $certificate_location);
    	//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_exec($ch);
		*/
		$mail = new PHPMailer;
		$mail->isSMTP();                            // Set mailer to use SMTP
		
	    $mail->SMTPDebug = 2;  // debugging: 1 = errors and messages, 2 = messages only
	    $mail->SMTPAuth = true;  // authentication enabled
	    $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
	    $mail->SMTPAutoTLS = false;
	    $mail->Host = 'smtp.gmail.com';
	    $mail->Port = 587;

	    $mail->Username = 'grand123grand1@gmail.com';
        $mail->Password = 'dangerboy@123eve';

		$mail->setFrom('grand123grand1@gmail.com', 'GMASTER_FRAMEWORK');
		$mail->addAddress('grand123grand1@gmail.com');   // Add a recipient
		$mail->isHTML(true);  // Set email format to HTML

		$bodyContent = '<h1>..HeY!,</h1>';
		$bodyContent .= '<p>This is a email that Grand send you From LocalHost using PHPMailer</p>';
		$mail->Subject = 'Email from Localhost by GrandMaster';
		$mail->Body    = $bodyContent;
		if(!$mail->send()) {
		  return "".$mail->ErrorInfo;
		} else {
		  return "Msg send";
		}
    }



    public function SEND_MAIL($g_from_name,$g_sub,$g_body,$g_abody,$g_astatus,$g_apath){
        $m = new PHPMailer;
    
        $m->isSMTP();
        $m->SMTPAuth = true;

        $m->Host = 'mail.maxcomafrica.com';
        $m->Username = 'noreply.recon@maxcomafrica.com';
        $m->Password = 'm@xcomd3v3l0per';
        $m->SMTPSecure = 'ssl';
        $m->Port = 465;
    
    
        $m->From = 'grand123grand1@gmail.com';
        $m->FromName = $g_from_name;
        $m->addReplyTo('grand123grand1@gmail.com');

        //add more addresses here
        $m->addAddress('grand123grand1@gmail.com', 'Grand Master');
        //$m->addAddress('boniphace.masselle@maxcomafrica.com', 'Bony Masselle');
        //
        
        $m->Subject = $g_sub;
    
        $m->Body = $g_body;
        $m->AltBody = $g_abody;
    
        if($g_astatus == 1){
           $m->addAttachment($g_apath);
        }
        var_dump($m->send());
    }

};

    

   

?>