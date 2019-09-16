<?php
namespace App\Utilities;
use Bcrypt\Bcrypt;


class G_PasswordUtility{

    private $bcrypt_version = '2a';//2y
    private $bcrypt;
    public function __construct(){
        $this->bcrypt = new Bcrypt();
    }

    public function encrypt($plaintext){
        $ciphertext = $this->bcrypt->encrypt($plaintext,$this->bcrypt_version);
        return $ciphertext;
    }

    public function verify($plaintext,$ciphertext){
        if($this->bcrypt->verify($plaintext, $ciphertext)){
            return true;
        }else{
            return false;
        }
    }


}
