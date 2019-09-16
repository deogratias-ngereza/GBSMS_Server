<?php
namespace App\Utilities;

class G_HelperUtil{
	public function __construct(){
	}


	/*
		check if date is valid/not valid
	*/
	public function validateDate($date, $format = 'Y-m-d H:i:s') {
	    $d = \DateTime::createFromFormat($format, $date);
	    return $d && $d->format($format) == $date;
	}



	//todo
	public function hasNonNumericChars($sms){
    	return false;
    }


	public function totalSMSCountInBody($body){

    	$one_sms_size = 160;
    	$sms_len = strlen($body);

    	if($sms_len <= $one_sms_size){
    		return 1;//one sms
    	} 

    	$res = $sms_len / 160;
    	return 1 + round($res);//1 was default
    }
    public function getFreeBatchId($length = 7)
	{
	    $token = "";
	    $codeAlphabet = "";
	    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	    //$codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
	    $codeAlphabet.= "0123456789";
	    $max = strlen($codeAlphabet); // edited

	    for ($i=0; $i < $length; $i++) {
	        $token .= $codeAlphabet[$this->crypto_rand_secure(0, $max-1)];
	    }
	    return date('siHdmY').$token;
	}



	public function getFreeOTP($length)
	{
	    $token = "";
	    $codeAlphabet = "";
	    //$codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	    //$codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
	    $codeAlphabet.= "0123456789";
	    $max = strlen($codeAlphabet); // edited

	    for ($i=0; $i < $length; $i++) {
	        $token .= $codeAlphabet[$this->crypto_rand_secure(0, $max-1)];
	    }
	    return $token;
	}
	public function crypto_rand_secure($min, $max)
	{
	    $range = $max - $min;
	    if ($range < 1) return $min; // not so random...
	    $log = ceil(log($range, 2));
	    $bytes = (int) ($log / 8) + 1; // length in bytes
	    $bits = (int) $log + 1; // length in bits
	    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
	    do {
	        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
	        $rnd = $rnd & $filter; // discard irrelevant bits
	    } while ($rnd > $range);
	    return $min + $rnd;
	}
	public function getFreePassword($length)
	{
	    $token = "";
	    $codeAlphabet = "";
	    $codeAlphabet.= "0123456789";
	    $max = strlen($codeAlphabet); // edited

	    for ($i=0; $i < $length; $i++) {
	        $token .= $codeAlphabet[$this->crypto_rand_secure(0, $max-1)];
	    }
	    return $token;
	}
	public function getFreeRandomKeys($length)
	{
	    $token = "";
	    $codeAlphabet = "";
	    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
	    $codeAlphabet.= "0123456789";
	    $max = strlen($codeAlphabet); // edited

	    for ($i=0; $i < $length; $i++) {
	        $token .= $codeAlphabet[$this->crypto_rand_secure(0, $max-1)];
	    }
	    return $token;
	}

	

}

?>



