<?php

namespace library\capsule\user\lib;

use \framework\user;

class log {

public static $logging = true;
public static $path,$prim,$text,$flush;
public static $fileSizeLimit = 40000; // In kilobytes
public static $logType = ['error' => 'log.error.corn', 'event' => 'log.event.corn', 'user' => 'log.user.corn', 'all' => 'log.all.corn'];

	public static function logEvent($type = null, $info = null, $text = null) {

	if (!empty(self::$logType[$type])):
	    
	    self::$prim  = ROOT_PATH."library/capsule/user/etc/log/". self::$logType['all'];
	    
	    self::$path  = ROOT_PATH."library/capsule/user/etc/log/". self::$logType[$type];
	    		
		self::checkFileSize();
		
		if (!empty($text)):
		
		  if (is_array($text)):
		  
		      foreach ($text as $key => $value):
		      
		          $newLog .= $i++ . '. ' . $value . PHP_EOL;
		      
		      endforeach;
		  
		  else:
		  
		  $newLog = $text;
		  
		  endif;
		
		endif;
	
	self::$text = $info . ' By ' . self::getCreature() . ' -- ' . $newLog . PHP_EOL;
	
	self::logIt();
                
    self::logItAll();
	
	endif;
    
    }
    
    public static function getCreature() {

	    return user::getUser()->getName();

    }
    
    public static function checkFileSize() {
    
        foreach (self::$logType as $key => $value):
        
        self::$flush = ROOT_PATH."library/capsule/user/etc/log/". self::$logType[$key];
        
            if (filesize(self::$flush) > self::$fileSizeLimit):
                
                self::flushLog();
                            
            endif;
            
        endforeach;
                
    }
    
    public static function logIt() {
        
        $open  = fopen(self::$path,"a+");
	    
	    $puts  = fputs($open,self::$text); 
	    
	    $close = fclose($open); 
	    
		if (!$open || !$puts || !$close): return false; else: return true; endif;
        
    }
    
    public static function logItAll() {
        
        $open  = fopen(self::$prim,"a+");
	    
	    $puts  = fputs($open,self::$text); 
	    
	    $close = fclose($open); 
	    
		if (!$open || !$puts || !$close): return false; else: return true; endif;
        
    }
    
    public static function flushLog() {
        
        $open  = fopen(self::$flush,"w");
	    
	    $puts  = fputs($open,''); 
	    
	    $close = fclose($open); 
	    
		if (!$open || !$puts || !$close): return false; else: return true; endif;
        
    }
    
    public static function setLog($type,$log,$from = [__FILE__,__CLASS__,__FUNCTION__,__LINE__]) {
		
		if (static::$logging):
		
		$file = end(explode('/',$from[0]));
		
		$clas = end(explode('\\', $from[1]));
		
		$func = end(explode('\\', $from[2]));
		
		$line = end(explode('\\', $from[3]));
				
		$info = ucwords($type).' log: '. $file . ':' . $line . ' ' . $clas . '::' . $func . ' ' .date("d:m:Y-H:i:s");
		
		self::logEvent($type,$info,$log);
			
		endif;
		
	}
    
}
    
?>