<?php

namespace library\capsule\accounting\lib;

trait cal {
        
	public static function noRoundingDecimal($number = null, $decimal = 0) {

    	list($int,$dec) = explode('.', (string) $number);                                            
    	
    	$dec = substr($dec,0, (int) $decimal);
    	    	
    	return (float) $int . '.' . $dec;
	
	}
	
	public static function floatToInteger($number = null, $int = 10000) {
		
		if (!empty($number)):
		
			if (is_array($number)):
		
				foreach ($number as $value):
				
					$numbered [] = $value * $int;
				
				endforeach;
			
			else:
			
			$numbered = $number * $int;
			
			endif;
		
		endif;
		
	return $numbered;
		
	}
	
	public static function floatToNormal( $number = null, $int = 10000 ) {

		if (!empty($number)):
		
			if (is_array($number)):
		
				foreach ($number as $value):
				
					$numbered [] = $value / $int;
				
				endforeach;
			
			else:
			
			$numbered = $number / $int;
			
			endif;
		
		endif;

		
	return $numbered;
		
	}
	
}

?>