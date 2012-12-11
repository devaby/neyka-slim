<?php

namespace framework;

use \framework\database\oracle\select;

class misc{

	function search($array, $key, $value)
	{
	    $results = array();
	
	    if (is_array($array))
	    {
	        if (isset($array[$key]) && $array[$key] == $value)
	            $results[] = $array;
	
	        foreach ($array as $subarray)
	            $results = array_merge($results, self::search($subarray, $key, $value));
	    }
	
	    return $results;
	}
	
	
	function thousand_separator(){
		
	}
	
	public function pagging($limit, $page = 1)
	{
		if(!empty($limit)){
			$offset = ($page - 1) * $limit;
			return array('offset'=>$offset,'limit'=>$limit);
		}
	}
	
	public function paggingView($totalPage,$currentPage,$targetFile = "")
	{
		 
		 
		 	 
         $paging .= '               	<ul class="left">';
         $paging .= '                   	<li><h5 class="bold">Page</h5></li>';
		 
		 for($i = 1; $i <= $totalPage; $i++){
		 	
			if($i==$currentPage){
				$paging .= '                       <li><a href="'.$targetFile.'?page='.$i.'" class="backcolrhover backcolr">'.$i.'</a></li>';
			}else{
				$paging .= '                       <li><a href="'.$targetFile.'?page='.$i.'" class="backcolrhover">'.$i.'</a></li>';
			}
			
		 }
		 
         $paging .= '                   </ul>';
         $paging .= '                   <ul class="right">';
		 if($currentPage!=1){	
         	$paging .= '                   	<li><a href="'.$targetFile.'?page=1" class="prevbtn backcolrhover">Previous</a></li>';
		 }
		 if($currentPage!=$totalPage){
        	$paging .= '                       <li><a href="'.$targetFile.'?page='.$totalPage.'" class="nextbtn backcolrhover">Next</a></li>';
		 }
         $paging .= '                   </ul>';
        
		return $paging;
		//print_r($paging);
	}
	
	public function getTotalPage($totalData,$dataPerPage)
	{
		return ceil($totalData/$dataPerPage);
	}
	
	public function getPagging($rowDisplay,$page,$column,$tableName,$whereClause,$totalData = null){
		$misc			= new misc();
		$paging			= $misc->pagging($rowDisplay,$page);
		$offset			= $paging['offset'];
		$limit			= $paging['limit'];
		
		if(empty($totalData)){			
		$select 		= new select("COUNT(".$column.") AS TOTALDATA",$tableName,$whereClause,"","");$select->execute();
		$totalData 		= $select->arrayResult[0]['TOTALDATA'];
		}
		$totalPage 		= $misc->getTotalPage($totalData,$rowDisplay);
	 	$startDataOnPage		= (($page-1)*$limit)+1;
	 	$endDataOnPAge			= ($page*$limit);
	 	$endDataOnPAge			= ($endDataOnPAge <= $totalData)?$endDataOnPAge:$totalData%$endDataOnPAge;
		$newArray 	[] 	= array("totalPage" => $totalPage,"totalData"=>$totalData,"currentPage" => $page,"limit" => $limit,"offset" =>$offset,"StartData" => $startDataOnPage,"EndData" => $endDataOnPAge);
		//print_r($newArray);
		return $newArray;
	}
	
	public function thousandSeparator($nominal,$decimalPlace = null,$decimalSeparator=".",$thousandSeparator=","){
		
		
		/*-----------------------------------------------------------------------*/
		/*     Thousand Separator                            					 */
		/*																		 */
		/* Creator : Rendi Eka P.S (31 October 2012)							 */
		/*-----------------------------------------------------------------------*/
		
		/*Used to return number with thousand separator each 3 number after comma*/
		/*parameter to call this function :*/
		/*$nominal */ /*is the number which will use to process*/
		/*$decimalPlace*/ /*Number of returned decimal, default Null*/
		/*$decimalSeparator*/ /*use to seperate the number of decimal and integer*/
		/*$thousandSeparator*/ /*use to seperate the thousand number */
		
		/*-----------------------------------------------------------------------*/
		
		
		if(!empty($decimalPlace)):$nominal = number_format($nominal,$decimalPlace,$decimalSeparator,$thousandSeparator);
		else:
		list($number,$decimal) = explode('.', $nominal,2);
		$totalDecimal = strlen($decimal);
		
		$nominal = (pow(10 , $totalDecimal) * $number ) + $decimal;
		$nominal = $nominal / pow(10 , $totalDecimal);
		$nominal = number_format($nominal, $totalDecimal,$decimalSeparator,$thousandSeparator);		
		endif;
		
		return $nominal;
		
	}
	
	
}


?>