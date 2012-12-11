<?php

namespace framework;

class encryption {

	public static function base64Encoding($file) {
	return base64_encode(serialize($file));
	}
	
	public static function base64Decoding($file) {
	return unserialize(base64_decode($file));
	}
	
	public static function sha1Encoding($file) {
	return sha1($file);
	}
	
	public static function md5Encoding($file) {
	return md5($file);
	}
	
	public function safe_b64encode($string) {
    $data = base64_encode($string);
    $data = str_replace(array('+','/','='),array('-','_',''),$data);
    return $data;
    }

    public function safe_b64decode($string) {
    $data = str_replace(array('-','_'),array('+','/'),$string);
    $mod4 = strlen($data) % 4;
    if ($mod4) {
        $data .= substr('====', $mod4);
    }
    return base64_decode($data);
    }
	
	public function urlHashEncodingRinjndael($key,$value){ 
    if(!$value): return false; endif;
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $value, MCRYPT_MODE_ECB, $iv);
    return trim(self::safe_b64encode($crypttext)); 
    }

    public function urlHashDecodingRinjndael($key,$value){
    if(!$value): return false; endif;
    $crypttext = self::safe_b64decode($value); 
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), $crypttext, MCRYPT_MODE_ECB, $iv);
    return trim($decrypttext);
    }

}

?>