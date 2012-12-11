<?php

/**
 * Neyka Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@asacreative.com so we can send you a copy immediately.
 *
 * @category   Neyka
 * @package    Tokenizer
 * @copyright  Copyright (c) 2012 Asacreative Technology Indonesia (http://www.asacreative.com)
 * @license    New BSD License
 * @version    $Id: token.class.php 100 rendi eka putra suherman $
 * @since      neyka 0.3
 */

namespace framework;

class token{
	
	/*
    * __construct - magic method
    *
    * @param  void
    * @return void
    */
	public function __construct(){
	
		/* 
		* checking and adding token into session 
		* the token have a lifetime value of +1 hour since it's created
		*/
		
		if (empty($_SESSION['xss'])):
		
		$_SESSION['xss'] = hash('sha256',time().rand(0,100));
		
		else:
		
		$_SESSION['lss'][] = array("token" => $_SESSION['xss'],"time" => date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')." +1 hour")));

		$_SESSION['xss']   = hash('sha256',time().rand(0,100));
		
		endif;
		
	}	
	
	/*
    * init - factory design pattern returning object of token
    *
    * @param  void
    * @return object
    */
	public function init(){
	
		/* 
		* returning object token 
		*/
		
		return new token();
		
	}	
	
	/*
    * getToken - returning freshly created token from the stored session
    *
    * @param  void
    * @return string
    */
	public function getToken(){
	
		/* 
		* returning generated token
		*/
		
		return $_SESSION['xss'];
		
	}
	
	/*
    * checkToken - checking the available token in the array
    *
    * @param  string $token - the string of token
    * @return string $lastToken
    */
	public function checkToken($token){
	
		/* 
		* checking age of token
		* deleting the value of expired token 
		*/
		$i = 0;
		
		foreach($_SESSION['lss'] as $key => $value):

			if(!empty($value['time'])):
			
				if (strtotime($value['time']) <= strtotime(date('Y-m-d H:i:s'))):
				
					unset($_SESSION['lss'][$i]);
					
				elseif ($token == $value['token']):
				
				$lastToken = $value['token'];
				
				unset($_SESSION['lss'][$i]);
								
				endif;
						
			endif;
		
		$i++;
		
		endforeach;
				
		$_SESSION['lss'] = array_values($_SESSION['lss']);

		return $lastToken;
		
		//return defFunction::search($_SESSION['lss'],"token",$token);
				
	}
	
}

?>