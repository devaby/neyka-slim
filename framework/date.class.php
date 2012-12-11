<?php

namespace framework;

class date {
	
	public static function indonesianMonth($theDate) {
		
		$local = array(
		
		"Jan" => "Januari",
		"Feb" => "Februari",
		"Mar" => "Maret",
		"Apr" => "April",
		"May" => "Mei",
		"Jun" => "Juni",
		"Jul" => "Juli",
		"Aug" => "Agustus",
		"Sep" => "September",
		"Okt" => "Oktober",
		"Nov" => "November",
		"Dec" => "Desember"
		
		);
		
		$date  = date("d",strtotime($theDate));
		
		$month = date("M",strtotime($theDate));
		
		$year  = date("Y",strtotime($theDate));
		
			foreach ($local as $key => $value) {
				
				if ($key == $month) {
					
					$month = $value;
					
					break;
					
				}
				
			}
			
		return $date." ".$month.", ".$year;
		
	}

}

?>