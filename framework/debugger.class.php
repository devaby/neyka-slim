<?php

namespace framework;

class debugger {

public $trace = array();

	public static function init() {
	
	$path = self::getPath();
		
		if (!file_exists($path)):
		
			$handle = fopen($path, "w"); fwrite($handle, serialize(new debugger()));
			
		
		else:
			
			 if(filesize($path) == 0):
				 
				 $handle = fopen($path, "w"); fwrite($handle, serialize(new debugger()));
				 
			 endif;
			
		endif;
				
	}
	
	public static function getPath() {
		
		$class = explode("\\",get_class());
	
		if (!empty($class)): 
		
		return PUBLIC_OBJECT.$class[1].".corn";
		
		else:
		
		return;
		
		endif;
		
	}
		    
    public function reincarnation() {

    	$path = self::getPath();
	    
	    return unserialize(file_get_contents($path));
	    	    
    }
    
    public function sleep() {
    
    	$path = self::getPath();

    	$handle = fopen($path, "w"); 
    	
    	fwrite($handle, serialize($this));
	    	    	    
    }
	
	public function write() {
		
		$vladimir = self::reincarnation();
		
	    if(!function_exists('debug_backtrace')) {
	    
	            $line .= 'function debug_backtrace does not exists'."\r\n";
	            
	            return;
	        }
	        
	        //echo '<pre>';
	        
	        $line .= "\r\n".'----------------'."\r\n";
	        $line .= 'Debug backtrace:'."\r\n";
	        $line .= '----------------'."\r\n";
	        
	        foreach(debug_backtrace() as $t) {
	        
	            $line .= "\t" . '@ ';
	            
	            if(isset($t['file'])) {
	            $line .= basename($t['file']) . ':' . $t['line'];
	            }
	            else{
	                $line .= '<PHP inner-code>';
	            }
	
	            $line .= ' -- ';
	
	            if(isset($t['class'])) {
	            $line .= $t['class'] . $t['type'];
	            }
	
	            $line .= $t['function'];
	
	            if(isset($t['args']) && sizeof($t['args']) > 0) {
	            
	            $line .= '(...)';
	            } 
	            else {
	            
	            $line .= '()';
	            
	            }
	
	            $line .= "\r\n";
	            
	        }
	        
	        $vladimir->trace [] = $line;
	        
	        $vladimir->sleep();
	        
	        error_log($line.PHP_EOL, 3, ROOT_PATH."/log/error.log");
	        	        
	 }
	         
}
         
?>