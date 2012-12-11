<?php

namespace library\capsule\accounting\lib;

trait format {
	
	public function locale() {
    	
    	return setlocale(LC_MONETARY, 'id_ID.UTF-8');
    	
	}
		
	public function setLocaleUser( $number, $isMoney, $lg='en_US.utf8') {

	    $ret = setLocale(LC_ALL, $lg);
	    setLocale(LC_TIME, 'Asia/Jakarta');
	    if ($ret===FALSE) {
	        echo "Language '$lg' is not supported by this system.\n";
	        return;
	    }
	    $LocaleConfig = localeConv();
	    forEach($LocaleConfig as $key => $val) $$key = $val;
	
	    // Sign specifications:
	    if ($number>0) {
	        $sign = $positive_sign;
	        $sign_posn = $p_sign_posn;
	        $sep_by_space = $p_sep_by_space;
	        $cs_precedes = $p_cs_precedes;
	    } else {
	        $sign = $negative_sign;
	        $sign_posn = $n_sign_posn;
	        $sep_by_space = $n_sep_by_space;
	        $cs_precedes = $n_cs_precedes;
	    }
	
	    // Number format:
	    $n = number_format(abs($number), $frac_digits,
	        $decimal_point, $thousands_sep);
	    $n = str_replace(' ', '&nbsp;', $n);
	    switch($sign_posn) {
	        case 0: $n = "($n)"; break;
	        case 1: $n = "$sign$n"; break;
	        case 2: $n = "$n$sign"; break;
	        case 3: $n = "$sign$n"; break;
	        case 4: $n = "$n$sign"; break;
	        default: $n = "$n [error sign_posn=$sign_posn&nbsp;!]";
	    }
	
	    // Currency format:
	    $m = number_format(abs($number), $frac_digits,
	        $mon_decimal_point, $mon_thousands_sep);
	    if ($sep_by_space) $space = ' '; else $space = '';
	    if ($cs_precedes) $m = "$currency_symbol$space$m";
	    else $m = "$m$space$currency_symbol";
	    $m = str_replace(' ', '&nbsp;', $m);
	    switch($sign_posn) {
	        case 0: $m = "($m)"; break;
	        case 1: $m = "$sign$m"; break;
	        case 2: $m = "$m$sign"; break;
	        case 3: $m = "$sign$m"; break;
	        case 4: $m = "$m$sign"; break;
	        default: $m = "$m [error sign_posn=$sign_posn&nbsp;!]";
	    }
	    if ($isMoney) return $m; else return $n;
	}

		
}

?>