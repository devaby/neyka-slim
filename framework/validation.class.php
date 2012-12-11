<?php

namespace framework;

class validation {

protected $data;

	public function setData($data) {
	$this->data = $data;
	return $this;
	}
	
	public function is_empty() {
	
	}
	
	public function email($email, $domainCheck = false) {
		if (preg_match('/^[a-zA-Z0-9\._-]+\@(\[?)[a-zA-Z0-9\-\.]+'.'\.([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/', $email)) {
	    	if ($domainCheck && function_exists('checkdnsrr')) {
	        	list (, $domain)  = explode('@', $email);
	            	if (checkdnsrr($domain, 'MX') || checkdnsrr($domain, 'A')) {
	                return true;
	                }
	        return false;
	        }
	    return true;
		}
	return false;
	}
	
	public function is_number() {
	return is_numeric($this->data);
	}
	
	public function size() {
	
	}
	
	public function setSizeLimit() {
	
	}
	function searchInArrayMultidimension($array, $key, $value)
	{
	    $results = array();
	
	    if (is_array($array))
	    {
	        if (isset($array[$key]) && $array[$key] == $value){
	            $results[] = $array;
	            }
	
	        foreach ($array as $subarray){
	            $results = array_merge($results, self::searchInArrayMultidimension($subarray, $key, $value));
	            }
	    }
	    
	   return $results;
	}

}

?>