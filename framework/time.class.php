<?php

namespace framework;

class time {

const oneday = 86400; // 86400 seconds = 1 Day
const weekend = 172800; // 172800 seconds = 2 Days
public $format,$holidays;

	public function __construct($format) {
	$this->format  = $format;
	}

	public function setHoliday($holiday) {
	$this->holiday = $holiday;
	return $this;
	}

	public function getYearNow() {
	return date('Y');
	}
	
	public function getMonthNow() {
	return date('m');
	}
	
	public function getDateNow() {
	return date('d');
	}
	
	public function getMonthList() {
	return array(1=>'january',2=>'february',3=>'march',4=>'april',5=>'may',6=>'june',7=>'july',8=>'august',9=>'september',10=>'october',11=>'november',12=>'december');
	}
	
	public function firstDateOfThisMonth() {
	return date("d".$this->format."", strtotime(date('m').'/01/'.date('Y').' 00:00:00'));
	}
	
	public function lastDateOfThisMonth() {
	return date("d", strtotime('-1 second',strtotime('+1 month',strtotime(date('m').'/01/'.date('Y').' 00:00:00'))));
	}
	
	public function nowCompleteTime() {
	return date("".$this->format."", strtotime('-1 second',strtotime('+1 month',strtotime(date('m').'/01/'.date('Y').' 00:00:00'))));
	}

	//The function returns the no. of business days between two dates and it skips the holidays
	public function getWorkingDays($startDate,$endDate,$holidays){
	    // do strtotime calculations just once
	    $endDate = strtotime($endDate);
	    $startDate = strtotime($startDate);


	    //The total number of days between the two dates. We compute the no. of seconds and divide it to 60*60*24
	    //We add one to include both dates in the interval.
	    $days = ($endDate - $startDate) / 86400 + 1;

	    $no_full_weeks = floor($days / 7);
	    $no_remaining_days = fmod($days, 7);

	    //It will return 1 if it's Monday,.. ,7 for Sunday
	    $the_first_day_of_week = date("N", $startDate);
	    $the_last_day_of_week = date("N", $endDate);

	    //---->The two can be equal in leap years when february has 29 days, the equal sign is added here
	    //In the first case the whole interval is within a week, in the second case the interval falls in two weeks.
	    if ($the_first_day_of_week <= $the_last_day_of_week) {
	        if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
	        if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
	    }
	    else {
	        // (edit by Tokes to fix an edge case where the start day was a Sunday
	        // and the end day was NOT a Saturday)

	        // the day of the week for start is later than the day of the week for end
	        if ($the_first_day_of_week == 7) {
	            // if the start date is a Sunday, then we definitely subtract 1 day
	            $no_remaining_days--;

	            if ($the_last_day_of_week == 6) {
	                // if the end date is a Saturday, then we subtract another day
	                $no_remaining_days--;
	            }
	        }
	        else {
	            // the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
	            // so we skip an entire weekend and subtract 2 days
	            $no_remaining_days -= 2;
	        }
	    }

	    //The no. of business days is: (number of weeks between the two dates) * (5 working days) + the remainder
	//---->february in none leap years gave a remainder of 0 but still calculated weekends between first and last day, this is one way to fix it
	   $workingDays = $no_full_weeks * 5;
	    if ($no_remaining_days > 0 )
	    {
	      $workingDays += $no_remaining_days;
	    }

	    //We subtract the holidays
	    if (!empty($holidays)) {
		    foreach($holidays as $holiday){
		        $time_stamp=strtotime($holiday);
		        //If the holiday doesn't fall in weekend
		        if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N",$time_stamp) != 6 && date("N",$time_stamp) != 7)
		            $workingDays--;
		    }
		}

	    return $workingDays;
	}

	function addDays($timestamp, $days, $skipdays = array("Saturday", "Sunday"), $skipdates = NULL) {
        // $skipdays: array (Monday-Sunday) eg. array("Saturday","Sunday")
        // $skipdates: array (YYYY-mm-dd) eg. array("2012-05-02","2015-08-01");
        //timestamp is strtotime of ur $startDate
        $i = 1;

        while ($days >= $i) {
            $timestamp = strtotime("+1 day", $timestamp);
            if (in_array(date("l", $timestamp), $skipdays)) {
                $days++;
            }
            $i++;
        }

        return $timestamp;
        //return date("m/d/Y",$timestamp);
    }

    function addDaysPlusHolidays($timestamp, $days, $skipdays = array("Saturday", "Sunday"), $skipdates = NULL) {
        // $skipdays: array (Monday-Sunday) eg. array("Saturday","Sunday")
        // $skipdates: array (YYYY-mm-dd) eg. array("2012-05-02","2015-08-01");
        //timestamp is strtotime of ur $startDate
        $i = 1;
        
        if (empty($skipdates)) {$skipdates = array();}
        
        while ($days >= $i) {
            $timestamp = strtotime("+1 day", $timestamp);
                        
	            if (in_array(date("l", $timestamp), $skipdays) || in_array(date("Y-m-d", $timestamp), $skipdates)) {
	                $days++;
	            }
            
            $i++;
        }

        return $timestamp;
        //return date("m/d/Y",$timestamp);
    }

    function addDaysPlusHolidaysNumber($timestamp, $days, $skipdays = array("Saturday", "Sunday"), $skipdates = NULL) {
        // $skipdays: array (Monday-Sunday) eg. array("Saturday","Sunday")
        // $skipdates: array (YYYY-mm-dd) eg. array("2012-05-02","2015-08-01");
        //timestamp is strtotime of ur $startDate
        $i = 1;
        $u = 0;
        
        if (empty($skipdates)) {$skipdates = array();}
        
        while ($days >= $i) {
            $timestamp = strtotime("+1 day", $timestamp);
            if (in_array(date("l", $timestamp), $skipdays) || in_array(date("Y-m-d", $timestamp), $skipdates)) {
            	$u++;
                $days++;
            }
            $i++;
        }

        return $u;
        //return date("m/d/Y",$timestamp);
    }

    function createDateRangeArray($strDateFrom,$strDateTo,$addingTime = null){
	    // takes two dates formatted as YYYY-MM-DD and creates an
	    // inclusive array of the dates between the from and to dates.

	    // could test validity of dates here but I'm already doing
	    // that in the main script
    	$format = $this->format;

    	if(empty($addingTime)){
    		$addingTime = 86400;
    	}

	    $aryRange=array();

	    $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
	    $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

	    if ($iDateTo>=$iDateFrom)
	    {
	        array_push($aryRange,date($format,$iDateFrom)); // first entry
	        while ($iDateFrom<$iDateTo)
	        {
	            $iDateFrom+=$addingTime; // add 24 hours
	            array_push($aryRange,date($format,$iDateFrom));
	        }
	    }
	    return $aryRange;
	}
	function get_months($date1, $date2) { 
	   $time1  = strtotime($date1); 
	   $time2  = strtotime($date2); 
	   $my     = date('mY', $time2); 

	   $months = array(date('F', $time1)); 
	   $f      = ''; 

	   while($time1 < $time2) { 
	      $time1 = strtotime((date('Y-m-d', $time1).' +15days')); 
	      if(date('F', $time1) != $f) { 
	         $f = date('F', $time1); 
	         if(date('mY', $time1) != $my && ($time1 < $time2)) 
	            $months[] = date('F', $time1); 
	      } 
	   } 

	   $months[] = date('F', $time2); 
	   return $months; 
	} 
	function returnIndonesianDate($num, $tipe){  
        $str;  
        switch($tipe){  
            case "month":  
                $month_name = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");  
                $str = $month_name[floor($num)];  
                break;  
            case "day":  
                $day_name = array("", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu");  
                $str = $day_name[floor($num)];  
                break;  
        }  
  
        return $str;  
    }  

}
?>