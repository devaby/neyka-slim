<?php

namespace library\capsule\accounting\mvc;

use \framework\user;
use \framework\encryption;
use \framework\token;
use \framework\misc;

class view extends model {

use \library\capsule\accounting\lib\cal;
protected $params,$optionGear,$site,$url;

	public function __construct($params = null,$data = null) {
	
	parent::__construct();
	
	$this->site = substr(APP, 0, -1);
	
	if (empty($this->url)): $this->url = $GLOBALS['_neyClass']['router']; endif;
	
	$this->params = $params;
	
		if (!empty($data)):
		
		$this->data = $data;
		
		endif;
		
		if (isset($_SESSION['admin']) || isset($_SESSION['admin']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'):
		
		$this->optionGear = "<span class='forex-optionGear'><img class='optionGear' src='".$this->site."/library/capsule/admin/image/settingCap.png'></span>";
		
		$this->ajax = true;
		
		endif;

		if ($params == "{view}" || empty($params)): 
	
		$this->params = 'normal'; 
		
		else: 
		
		$this->params = $params; 
		
		endif; 
	
	$params = $this->params; 
	
	$this->$params();
	
	}
	
    public function normal() {
	
	$view .= $this->optionGear;
	
    echo "Select a view ".$view;
                
    }
    
    public function actionbar_coa() {
	    
	    $view .= $this->optionGear;
	    	    
	    //Build action button, filter and input area
	    $view .= "<div>";
	    
	       $view .= "<input id='capsuleCSRFToken' type='hidden' value='".$_SESSION['xss']."'>";
		
		   $view .= "<div class='btn-group pull-left'>";
		   
		   	  	$view .= "<a class='btn btn-small btn-info' href='#accounting-".$this->params."-coaAdd'><i class='icon-plus icon-white'></i> Create Account</a>";
					  
		   	  	$view .= "<a class='btn btn-small btn-info' href='#accounting-".$this->params."-coaDelete'><i class='icon-remove icon-white'></i> Delete Account</a>";
					
		   $view .= "</div>";
							
		   //$view .= "<div class='input-append pull-right'>";
		
			  	//$view .= "<input class='span2' id='appendedInputButton' size='20' type='text'><button class='btn' type='button'>Search</button>";
					
		   //$view .= "</div>";
			    
		$view .= "</div>";    
			    
		$view .= "<div class='clearfix'></div>";
			    
		$view .= "<hr>";
			    
		//Build modal window for data entry
	    $view .= "<div class='modal hide' id='accounting-".$this->params."-coa' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>";

			$view .= "<div class='modal-header'><h5 id='myModalLabel'>Modal header</h5></div>";
			  			  			
			$view .= "<div class='modal-body'></div>";

			$view .= "<div class='modal-footer'>";
			  
			    $view .= "<button class='btn btn-small' data-dismiss='modal' aria-hidden='true'>Close</button>";
			    
			    $view .= "<button class='btn btn-info btn-small'>Save changes</button>";
			  
			$view .= "</div>";
			
		$view .= "</div>";
	    	    	    
	    echo $view;
	    
    }
    
    public function actionbar_item() {
	    
	    $view .= $this->optionGear;
	    	    
	    //Build action button, filter and input area
	    $view .= "<div>";
	    
	       $view .= "<input id='capsuleCSRFToken' type='hidden' value='".$_SESSION['xss']."'>";
	       
		   $view .= "<div class='btn-group pull-left'>";
		   
		   	  	$view .= "<a class='btn btn-small btn-info' href='#accounting-".$this->params."-itemAdd'><i class='icon-plus icon-white'></i> Create Item</a>";
					  
		   	  	$view .= "<a class='btn btn-small btn-info' href='#accounting-".$this->params."-itemDelete'><i class='icon-remove icon-white'></i> Delete Item</a>";
					
		   $view .= "</div>";
							
		   //$view .= "<div class='input-append pull-right'>";
		
			  	//$view .= "<input class='span2' id='appendedInputButton' size='20' type='text'><button class='btn' type='button'>Search</button>";
					
		   //$view .= "</div>";
		
		$view .= "</div>";    
		
		$view .= "<div class='clearfix'></div>";
		
		$view .= "<hr>";
		
		//Build modal window for data entry
	    $view .= "<div class='modal hide' id='accounting-".$this->params."-modal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>";

			$view .= "<div class='modal-header'><h5 id='myModalLabel'>Modal header</h5></div>";
			  			  			
			$view .= "<div class='modal-body'></div>";

			$view .= "<div class='modal-footer'>";
			  
			    $view .= "<button class='btn btn-small' data-dismiss='modal' aria-hidden='true'>Close</button>";
			    
			    $view .= "<button class='btn btn-info btn-small'>Save changes</button>";
			  
			$view .= "</div>";
			
		$view .= "</div>";
	    	    	    
	    echo $view;
	    
    }
    
    public function actionbar_transaction() {
	    
	    $view .= $this->optionGear;
	    
	    $randm = rand(0,100);
	    
	    $crypt = encryption::urlHashEncodingRinjndael($_SESSION['xss'],$randm);
	    
	    //Build action button, filter and input area
	    $view .= "<div>";
	    
	       $view .= "<input id='capsuleCSRFToken' type='hidden' value='".$_SESSION['xss']."'>";
	       
		   $view .= "<div class='btn-group pull-left'>";
		   
		   	  	$view .= "<a class='btn btn-info btn-small dropdown-toggle' data-toggle='dropdown' href='#accounting-".$this->params."-coaAdd'><i class='icon-list-alt icon-white'></i> Create Transaction <span class='caret'></span></a>";
		   	  	
		   	  		$view .= "<ul class='dropdown-menu'>";
		   	  		
		   	  			$view .= "<li><a href='".$this->url->builder(3801,'invoice')."?actio=new|||invoice|||".$crypt."&emblem=".$_SESSION['xss']."'><i class='icon-circle-arrow-left'></i> Invoice</a></li>";
		   	  			
		   	  			$view .= "<li><a href='".$this->url->builder(3802,'bill')."?actio=new|||bill|||".$crypt."&emblem=".$_SESSION['xss']."'><i class='icon-time'></i> Bill</a></li>";
		   	  			
		   	  			$view .= "<li class='divider'><</li>";
		   	  			
		   	  			$view .= "<li><a href='".$this->url->builder(3940,'sales-receipt')."?actio=new|||sales-receipt|||".$crypt."&emblem=".$_SESSION['xss']."'><i class='icon-file'></i> Sales Receipt</a></li>";
		   	  			
		   	  			$view .= "<li><a href='".$this->url->builder(3803,'receipt')."?actio=new|||receipt|||".$crypt."&emblem=".$_SESSION['xss']."'><i class='icon-file'></i> Receipt</a></li>";
		   	  			
		   	  			$view .= "<li class='divider'><</li>";
		   	  			
		   	  			$view .= "<li><a href='".$this->url->builder(3804,'transfer')."?actio=new|||transfer|||".$crypt."&emblem=".$_SESSION['xss']."'><i class='icon-share'></i> Transfer</a></li>";
		   	  			
		   	  			$view .= "<li class='divider'><</li>";
		   	  			
		   	  			$view .= "<li><a href='".$this->url->builder(3805,'payment')."?actio=new|||payment|||".$crypt."&emblem=".$_SESSION['xss']."'><i class='icon-download'></i> Payment</a></li>";
		   	  			
		   	  			$view .= "<li><a href='".$this->url->builder(3806,'pay-bill')."?actio=new|||pay-bill|||".$crypt."&emblem=".$_SESSION['xss']."'><i class='icon-upload'></i> Pay Bill</a></li>";
		   	  			
						$view .= "<li class='divider'><</li>";
		   	  			
		   	  			$view .= "<li><a href='#'><i class='icon-download'></i> Return Purchase</a></li>";
		   	  			
		   	  			$view .= "<li><a href='#'><i class='icon-upload'></i> Return Payment</a></li>";
		   	  					   	  		
		   	  		$view .= "</ul>";
									  					
		   $view .= "</div>";
										    
		$view .= "</div>";    
			    
		$view .= "<div class='clearfix'></div>";
			    
		$view .= "<br>";
			    
		//Build modal window for data entry
	    $view .= "<div class='modal hide' id='accounting-".$this->params."-modal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>";

			$view .= "<div class='modal-header'><h5 id='myModalLabel'>Modal header</h5></div>";
			  			  			
			$view .= "<div class='modal-body'></div>";

			$view .= "<div class='modal-footer'>";
			  
			    $view .= "<button class='btn btn-small' data-dismiss='modal' aria-hidden='true'>Close</button>";
			    
			    $view .= "<button class='btn btn-info btn-small'>Save changes</button>";
			  
			$view .= "</div>";
			
		$view .= "</div>";
	    	    	    
	    echo $view;
	    
    }
    
    public function table_coa() {
    	
    	$data  = json_decode($this->getCoa(), true);
    	
    	//print_r($data);
    	
    	$view .= $this->optionGear;

    	if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'):
    	    	
    	$view .= "<table id='accounting-".$this->params."-tableCoa' class='table table-hover table-striped table-small-font'>";
	    	
	    	$view .= "<thead class='table-header-blue table-header-bold'>";
	    			
	    		$view .= "<tr>";
	    			
		    		$view .= "<td class='table-valign-middle'><input type='checkbox'></td>";
		    			
		    		$view .= "<td class='table-valign-middle'>Num</td>";
		    			
		    		$view .= "<td class='table-valign-middle'>Name</td>";
		    		
		    		$view .= "<td class='table-valign-middle'>Description</td>";
		    				    			
		    		$view .= "<td class='table-valign-middle'>Type</td>";
		    		
		    		$view .= "<td class='table-valign-middle'>Category</td>";
		    			
		    		//$view .= "<td class='table-valign-middle'>Tax</td>";
		    			
		    		$view .= "<td class='table-align-right table-valign-middle'>Balance</td>";
	    			
	    		$view .= "</tr>";
	    			
	    	$view .= "</thead>";
	    		
	    	$view .= "<tbody>";

			if (!empty($data)):
			
			    foreach ($data as $key => $value):
			    
			    $debit  = (!empty($value['DEBIT'])) ? $value['DEBIT'] : 0;
			    
			    $credit = (!empty($value['CREDIT'])) ? $value['CREDIT'] : 0;

			    $view .= "<tr>";
			    	
			    	$view .= "<td class='table-valign-middle'><input type='checkbox' value='".$value['CAP_ACC_COA_ID']."'></td>";
				    
				    $view .= "<td class='table-valign-middle'>".$value['CAP_ACC_COA_CODE']."</td>";
				    
				    $view .= "<td class='table-valign-middle'><a href='#' class='accounting-".$this->params."-update'>".ucwords(strtolower($value['CAP_ACC_COA_NAME']))."</a></td>";
				    
					$view .= "<td class='table-valign-middle'>".ucwords(strtolower($value['CAP_ACC_COA_DESC']))."</td>";
					
					$view .= "<td class='table-valign-middle'>".ucwords(strtolower($value['CAP_ACC_COA_TYP_NAME']))."</td>";
				    
				    $view .= "<td class='table-valign-middle'>".ucwords(strtolower($value['CAP_ACC_COA_TYP_TYPE']))."</td>";
				    
				    //$view .= "<td class='table-valign-middle'></td>";
				    
				    $view .= "<td class='table-valign-middle table-align-right'>".number_format(bcsub($debit,$credit,3),2)."</td>";
				    
			    $view .= "</tr>";
			    
			    endforeach;
			
			else:
			
				$view .= "<tr>";
			    			
			    	$view .= "<td colspan='6'>Hey. It looks like you haven't got any account. Would you like <a href='#myModal' data-toggle='modal'>create one now?</a></td>";
				    							    						    			
			    $view .= "</tr>";
				    
			endif;
			    
			$view .= "</tbody>";
			    
			$view .= "<tfoot class='table-header-blue table-header-bold'>";
	    			
	    		$view .= "<tr>";
	    			
		    		$view .= "<td class='table-valign-middle'>Total</td>";
		    			
		    		$view .= "<td class='table-valign-middle'></td>";
		    			
		    		$view .= "<td class='table-valign-middle'></td>";
		    		
		    		$view .= "<td class='table-valign-middle'></td>";
		    			
		    		$view .= "<td class='table-valign-middle'></td>";
		    			
		    		//$view .= "<td class='table-valign-middle'></td>";
		    			
		    		$view .= "<td class='table-valign-middle'></td>";
	    			
	    		$view .= "</tr>";
	    			
	    	$view .= "</foot>";
	    		
	    $view .= "</table>";
	        	
    	else:
    	
    	$view .= "<div id='accounting-".$this->params."-tableContainer'>";
    	
	    $view .= "<table id='accounting-".$this->params."-tableCoa' class='table table-hover table-striped table-small-font'>";
	    	
	    	$view .= "<thead class='table-header-blue table-header-bold'>";
	    			
	    		$view .= "<tr>";
	    			
		    		$view .= "<td class='table-valign-middle'><input type='checkbox'></td>";
		    			
		    		$view .= "<td class='table-valign-middle'>Num</td>";
		    			
		    		$view .= "<td class='table-valign-middle'>Name</td>";
		    		
		    		$view .= "<td class='table-valign-middle'>Description</td>";
		    				    			
		    		$view .= "<td class='table-valign-middle'>Type</td>";
		    		
		    		$view .= "<td class='table-valign-middle'>Category</td>";
		    			
		    		//$view .= "<td class='table-valign-middle'>Tax</td>";
		    			
		    		$view .= "<td class='table-align-right table-valign-middle'>Balance</td>";
	    			
	    		$view .= "</tr>";
	    			
	    	$view .= "</thead>";
	    		
	    	$view .= "<tbody>";

			if (!empty($data)):
			
			    foreach ($data as $key => $value):
					    
			    $debit  = (!empty($value['DEBIT'])) ? $value['DEBIT'] : 0;
			    
			    $credit = (!empty($value['CREDIT'])) ? $value['CREDIT'] : 0;
			    
			    $type   = strtolower($value['CAP_ACC_COA_TYP_TYPE']);
			    
			    $view .= "<tr>";
			    	
			    	$view .= "<td class='table-valign-middle'><input type='checkbox' value='".$value['CAP_ACC_COA_ID']."'></td>";
				    
				    $view .= "<td class='table-valign-middle'>".$value['CAP_ACC_COA_CODE']."</td>";
				    
				    $view .= "<td class='table-valign-middle'><a href='#' class='accounting-".$this->params."-update'>".ucwords(strtolower($value['CAP_ACC_COA_NAME']))."</a></td>";
				    
					$view .= "<td class='table-valign-middle'>".ucwords(strtolower($value['CAP_ACC_COA_DESC']))."</td>";
					
					$view .= "<td class='table-valign-middle'>".ucwords(strtolower($value['CAP_ACC_COA_TYP_NAME']))."</td>";
				    
				    $view .= "<td class='table-valign-middle'>".ucwords($type)."</td>";
				    
				    //$view .= "<td class='table-valign-middle'></td>";
				    
				    //$view .= "<td class='table-valign-middle table-align-right'>".str_replace('-','',number_format(bcsub($debit,$credit,3),2))."</td>";
				    
				    if ($type == 'asset' || $type == 'bank' || $type == 'expense'):
				    
				    $view .= "<td class='table-valign-middle table-align-right'>".number_format(bcsub($debit,$credit,3),2)."</td>";
				    
				    else:
				    
				    $view .= "<td class='table-valign-middle table-align-right'>".number_format(bcsub($credit,$debit,3),2)."</td>";
				    
				    endif;
				    
			    $view .= "</tr>";
			    
			    endforeach;
			
			else:
			
				$view .= "<tr>";
			    			
			    	$view .= "<td colspan='6'>Hey. It looks like you haven't got any account. Would you like <a href='#myModal' data-toggle='modal'>create one now?</a></td>";
				    							    						    			
			    $view .= "</tr>";
				    
			endif;
			    
			$view .= "</tbody>";
			    
			$view .= "<tfoot class='table-header-blue table-header-bold'>";
	    			
	    		$view .= "<tr>";
	    			
		    		$view .= "<td class='table-valign-middle'>Total</td>";
		    			
		    		$view .= "<td class='table-valign-middle'></td>";
		    			
		    		$view .= "<td class='table-valign-middle'></td>";
		    		
		    		$view .= "<td class='table-valign-middle'></td>";
		    			
		    		$view .= "<td class='table-valign-middle'></td>";
		    			
		    		$view .= "<td class='table-valign-middle'></td>";
		    			
		    		//$view .= "<td class='table-valign-middle'></td>";
		    		
		    		$view .= "<td class='table-valign-middle'></td>";
	    			
	    		$view .= "</tr>";
	    			
	    	$view .= "</foot>";
	    		
	    $view .= "</table>";
	    
	    $view .= "</div>";
	    
	    endif;
	    
	    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'):
	    
	    echo json_encode(array("response" => "success", "token" => $_SESSION['xss'], "view" => $view));
	    
	   	else:
	   	  
	    echo $view;
	    
	    endif;
	    
    }
    
    public function table_item() {
    	
    	$data  = json_decode($this->getItem(), true);

    	$view .= $this->optionGear;

    	if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'):
    	    	
    	$view .= "<table id='accounting-".$this->params."-tableCoa' class='table table-hover table-striped table-small-font'>";
	    	
	    	$view .= "<thead class='table-header-blue table-header-bold'>";
	    			
	    		$view .= "<tr>";
	    			
		    		$view .= "<td class='table-valign-middle'><input type='checkbox'></td>";
		    			
		    		$view .= "<td class='table-valign-middle'>Num</td>";
		    			
		    		$view .= "<td class='table-valign-middle'>Name</td>";
		    		
		    		$view .= "<td class='table-valign-middle'>Description</td>";
		    			
		    		$view .= "<td class='table-valign-middle'>Type</td>";
		    				    			
	    		$view .= "</tr>";
	    			
	    	$view .= "</thead>";
	    		
	    	$view .= "<tbody>";

			if (!empty($data)):
			
			    foreach ($data as $key => $value):
					    
			    $view .= "<tr>";
			    			
			    	$view .= "<td class='table-valign-middle'><input type='checkbox' value='".$value['CAP_ACC_ITE_ID']."'></td>";
				    
				    $view .= "<td class='table-valign-middle'>".$value['CAP_ACC_ITE_CODE']."</td>";
				    
				    $view .= "<td class='table-valign-middle'>";
				    
					    $view .= "<a href='#' class='accounting-".$this->params."-update'>".$value['CAP_ACC_ITE_NAME']."</a>";
					    					
					$view .= "</td>";
					
					$view .= "<td class='table-valign-middle'>".ucwords(strtolower($value['CAP_ACC_ITE_DESC']))."</td>";
				    
				    $view .= "<td class='table-valign-middle'>".ucwords(strtolower($value['CAP_ACC_ITE_TYP_NAME']))."</td>";
				    				    				    
			    $view .= "</tr>";
			    
			    endforeach;
			
			else:
			
				$view .= "<tr>";
			    			
			    	$view .= "<td colspan='6'>Hey. It looks like you haven't got any item. Would you like <a href='#myModal' data-toggle='modal'>create one now?</a></td>";
				    							    						    			
			    $view .= "</tr>";
				    
			endif;
			    
			$view .= "</tbody>";
			    
			$view .= "<tfoot class='table-header-blue table-header-bold'>";
	    			
	    		$view .= "<tr>";
	    			
		    		$view .= "<td class='table-valign-middle'>Total</td>";
		    			
		    		$view .= "<td class='table-valign-middle'></td>";
		    			
		    		$view .= "<td class='table-valign-middle'></td>";
		    			
		    		$view .= "<td class='table-valign-middle'></td>";
		    			
		    		$view .= "<td class='table-valign-middle'></td>";
		    				    			
	    		$view .= "</tr>";
	    			
	    	$view .= "</foot>";
	    		
	    $view .= "</table>";
	        	
    	else:
    	
    	$view .= "<div id='accounting-".$this->params."-tableContainer'>";
    	
	    $view .= "<table id='accounting-".$this->params."-tableCoa' class='table table-hover table-striped table-small-font'>";
	    	
	    	$view .= "<thead class='table-header-blue table-header-bold'>";
	    			
	    		$view .= "<tr>";
	    			
		    		$view .= "<td class='table-valign-middle'><input type='checkbox'></td>";
		    			
		    		$view .= "<td class='table-valign-middle'>Num</td>";
		    			
		    		$view .= "<td class='table-valign-middle'>Name</td>";
		    		
		    		$view .= "<td class='table-valign-middle'>Description</td>";
		    			
		    		$view .= "<td class='table-valign-middle'>Type</td>";
		    			    			
	    		$view .= "</tr>";
	    			
	    	$view .= "</thead>";
	    		
	    	$view .= "<tbody>";

			if (!empty($data)):
			
			    foreach ($data as $key => $value):
					    
			    $view .= "<tr>";
			    			
			    	$view .= "<td class='table-valign-middle'><input type='checkbox' value='".$value['CAP_ACC_ITE_ID']."'></td>";
				    
				    $view .= "<td class='table-valign-middle'>".$value['CAP_ACC_ITE_CODE']."</td>";
				    
				    $view .= "<td class='table-valign-middle'>";
				    
					    $view .= "<a href='#' class='accounting-".$this->params."-update'>".$value['CAP_ACC_ITE_NAME']."</a>";
					    					
					$view .= "</td>";
					
					$view .= "<td class='table-valign-middle'>".ucwords(strtolower($value['CAP_ACC_ITE_DESC']))."</td>";
				    
				    $view .= "<td class='table-valign-middle'>".ucwords(strtolower($value['CAP_ACC_ITE_TYP_NAME']))."</td>";
				    				    				    
			    $view .= "</tr>";
			    
			    endforeach;
			
			else:
			
				$view .= "<tr>";
			    			
			    	$view .= "<td colspan='6'>Hey. It looks like you haven't got any item. Would you like <a href='#myModal' data-toggle='modal'>create one now?</a></td>";
				    							    						    			
			    $view .= "</tr>";
				    
			endif;
			    
			$view .= "</tbody>";
			    
			$view .= "<tfoot class='table-header-blue table-header-bold'>";
	    			
	    		$view .= "<tr>";
	    			
		    		$view .= "<td class='table-valign-middle'>Total</td>";
		    			
		    		$view .= "<td class='table-valign-middle'></td>";
		    			
		    		$view .= "<td class='table-valign-middle'></td>";
		    			
		    		$view .= "<td class='table-valign-middle'></td>";
		    			
		    		$view .= "<td class='table-valign-middle'></td>";
		    				    			
	    		$view .= "</tr>";
	    			
	    	$view .= "</foot>";
	    		
	    $view .= "</table>";
	    
	    $view .= "</div>";
	    
	    endif;
	    
	    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'):
	    
	    echo json_encode(array("response" => "success", "token" => $_SESSION['xss'], "view" => $view));
	    
	   	else:
	   	  
	    echo $view;
	    
	    endif;
	    
    }
    
    public function table_transaction() {
    	
    	$data  = json_decode($this->getItem(), true);
    	
    	$view .= $this->optionGear;
    	
    	$view .= "<div id='accounting-".$this->params."-table'>";
    	
	    	$view .= "<ul class='nav nav-tabs'>";
	    	
				$view .= "<li class='active'><a class='dropdown-toggle' data-toggle='tab' href='#table-transaction-all'>All</a></li>";
				
				$view .= "<li><a class='dropdown-toggle' data-toggle='tab' href='#table-transaction-invoice'>Invoice</a></li>";
				
				$view .= "<li><a class='dropdown-toggle' data-toggle='tab' href='#table-transaction-bill'>Bill</a></li>";
				
				$view .= "<li><a class='dropdown-toggle' data-toggle='tab' href='#table-transaction-salesreceipt'>Sales Receipt</a></li>";
				
				$view .= "<li><a class='dropdown-toggle' data-toggle='tab' href='#table-transaction-receipt'>Receipt</a></li>";
				
				$view .= "<li><a class='dropdown-toggle' data-toggle='tab' href='#table-transaction-transfer'>Transfer</a></li>";
				
				$view .= "<li><a class='dropdown-toggle' data-toggle='tab' href='#table-transaction-payment'>Payment</a></li>";
				
				$view .= "<li><a class='dropdown-toggle' data-toggle='tab' href='#table-transaction-paybill'>Pay Bill</a></li>";
				
				$view .= "<li><a class='dropdown-toggle' data-toggle='tab' href='#table-transaction-creditmemo'>Credit Memo</a></li>";
						   	  						
			$view .= "</ul>";
		
		$view .= "</div>";
		
		$view .= "<div class='tab-content'>";
		
			$view .= "<div class='tab-loader'>".$this->table_transaction_all()."</div>";
		
		$view .= "</div>";
	   	  
	    echo $view;
	    
    }
    
    public function table_transaction_all() {
    	
    	$data  = json_decode($this->getItem(), true);
    	    	
	    	$view .= "<table id='accounting-".$this->params."-tableCoa' class='table table-hover table-striped table-small-font'>";
	    	
	    	$view .= "<thead class='table-header-blue table-header-bold'>";
	    			
	    		$view .= "<tr>";
	    			
		    		$view .= "<td class='table-valign-middle'><input type='checkbox'></td>";
		    			
		    		$view .= "<td class='table-valign-middle'>Num</td>";
		    			
		    		$view .= "<td class='table-valign-middle'>Name</td>";
		    		
		    		$view .= "<td class='table-valign-middle'>Description</td>";
		    				    			
		    		$view .= "<td class='table-valign-middle'>Type</td>";
		    		
		    		$view .= "<td class='table-valign-middle'>Category</td>";
		    			
		    		$view .= "<td class='table-valign-middle'>Tax</td>";
		    			
		    		$view .= "<td class='table-align-right table-valign-middle'>Balance</td>";
	    			
	    		$view .= "</tr>";
	    			
	    	$view .= "</thead>";
	    		
	    	$view .= "<tbody>";
	    	
	    	$view .= "</tbody>";
	    	
	    	$view .= "<tfoot>";
	    	
	    	$view .= "</tfoot>";
	    	
	    $view .= "</table>";
		
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'):
		
	    	echo json_encode(array("response" => "success", "token" => $_SESSION['xss'], "view" => $view));
	    
	    else:
	    
	    	return $view;	
	    
	    endif;
	    
    }
    
    public function table_transaction_invoice() {
    	
    	$data  = json_decode($this->getAllInvoice(), true);
    	    	    
	    	$view .= "<table id='accounting-".$this->params."-tableCoa' class='table table-hover table-striped table-small-font'>";
	    	
	    	$view .= "<thead class='table-header-blue table-header-bold'>";
	    	
	    		$view .= "<tr>";
	    		
		    		$view .= "<td class='table-valign-middle'><input type='checkbox'></td>";
		    		
		    		$view .= "<td class='table-valign-middle'>Num</td>";
		    		
		    		$view .= "<td class='table-valign-middle'>To</td>";
		    		
		    		$view .= "<td class='table-valign-middle'>Date</td>";
		    		
		    		$view .= "<td class='table-valign-middle'>Due Date</td>";
		    		
		    		$view .= "<td class='table-valign-middle'>Status</td>";
		    		
		    		$view .= "<td class='table-valign-middle table-align-right'>Paid</td>";
		    		
		    		$view .= "<td class='table-valign-middle table-align-right'>Due</td>";
		    		
	    		$view .= "</tr>";
	    	
	    	$view .= "</thead>";
	    	
	    	$view .= "<tbody>";
	    	
	    		if (!empty($data)):
	    		
	    			foreach ($data as $key => $value):
	    				    			
	    			$crypt = encryption::urlHashEncodingRinjndael($_SESSION['xss'],$value['CAP_ACC_TRA_ID']);
	    			
	    			$numb  = (!empty($value['CAP_ACC_TRA_NUMBER'])) ? $value['CAP_ACC_TRA_NUMBER'] : 'Number Not Set';
	    			
	    			$view .= "<tr class='accounting-clickable'>";
	    				
	    				$view .= "<td><input type='checkbox' value='".$value['CAP_ACC_TRA_ID']."'></td>";
	    				
	    				$view .= "<td><a href='".$this->url->builder(3801,'invoice',true)."?actio=view|||invoice|||".$crypt."&emblem=".$_SESSION['xss']."'>".$numb."</a></td>";
	    				
	    				$view .= "<td>".ucwords(strtolower($value['CAP_ACC_CON_CONTACT']))."</td>";
	    				
	    				$view .= "<td>".date("d F Y",strtotime($value['CAP_ACC_TRA_DATE']))."</td>";
	    				
	    				$view .= "<td>".date("d F Y",strtotime($value['CAP_ACC_TRA_DUEDATE']))."</td>";
	    				
	    				$view .= "<td></td>";
	    					    					    				
	    				$view .= "<td class='table-align-right'>".number_format($value['CAP_ACC_TRA_TOTALLEFT'], 2)."</td>";
	    				
	    				$view .= "<td class='table-align-right'>".number_format($value['CAP_ACC_TRA_TOTAL'], 2)."</td>";
	    					    			
	    			$view .= "</tr>";
	    			
	    			endforeach;
	    		
	    		endif;
	    	
	    	$view .= "</tbody>";
	    	
	    	$view .= "<tfoot>";
	    	
	    	$view .= "</tfoot>";
	    	
	    $view .= "</table>";
			   	  
	    echo json_encode(array("response" => "success", "token" => $_SESSION['xss'], "view" => $view, "debug" => $data));
	    
    }
    
    public function table_transaction_bill() {
    	
    	$data  = json_decode($this->getAllBill(), true);
    	    	    
	    	$view .= "<table id='accounting-".$this->params."-tableCoa' class='table table-hover table-striped table-small-font'>";
	    	
	    	$view .= "<thead class='table-header-blue table-header-bold'>";
	    	
	    		$view .= "<tr>";
	    		
		    		$view .= "<td class='table-valign-middle'><input type='checkbox'></td>";
		    		
		    		$view .= "<td class='table-valign-middle'>Num</td>";
		    		
		    		$view .= "<td class='table-valign-middle'>To</td>";
		    		
		    		$view .= "<td class='table-valign-middle'>Date</td>";
		    		
		    		$view .= "<td class='table-valign-middle'>Due Date</td>";
		    		
		    		$view .= "<td class='table-valign-middle'>Status</td>";
		    		
		    		$view .= "<td class='table-valign-middle table-align-right'>Paid</td>";
		    		
		    		$view .= "<td class='table-valign-middle table-align-right'>Due</td>";
		    		
	    		$view .= "</tr>";
	    	
	    	$view .= "</thead>";
	    	
	    	$view .= "<tbody>";
	    	
	    		if (!empty($data)):
	    		
	    			foreach ($data as $key => $value):
	    				    			
	    			$crypt = encryption::urlHashEncodingRinjndael($_SESSION['xss'],$value['CAP_ACC_TRA_ID']);
	    			
	    			$numb  = (!empty($value['CAP_ACC_TRA_NUMBER'])) ? $value['CAP_ACC_TRA_NUMBER'] : 'Number Not Set';
	    			
	    			$view .= "<tr class='accounting-clickable'>";
	    				
	    				$view .= "<td><input type='checkbox' value='".$value['CAP_ACC_TRA_ID']."'></td>";
	    				
	    				$view .= "<td><a href='".$this->url->builder(3802,'bill',true)."?actio=view|||bill|||".$crypt."&emblem=".$_SESSION['xss']."'>".$numb."</a></td>";
	    				
	    				$view .= "<td>".ucwords(strtolower($value['CAP_ACC_CON_CONTACT']))."</td>";
	    				
	    				$view .= "<td>".date("d F Y",strtotime($value['CAP_ACC_TRA_DATE']))."</td>";
	    				
	    				$view .= "<td>".date("d F Y",strtotime($value['CAP_ACC_TRA_DUEDATE']))."</td>";
	    				
	    				$view .= "<td></td>";
	    					    					    				
	    				$view .= "<td class='table-align-right'>".number_format($value['CAP_ACC_TRA_TOTALLEFT'], 2)."</td>";
	    				
	    				$view .= "<td class='table-align-right'>".number_format($value['CAP_ACC_TRA_TOTAL'], 2)."</td>";
	    					    			
	    			$view .= "</tr>";
	    			
	    			endforeach;
	    		
	    		endif;
	    	
	    	$view .= "</tbody>";
	    	
	    	$view .= "<tfoot>";
	    	
	    	$view .= "</tfoot>";
	    	
	    $view .= "</table>";
			   	  
	    echo json_encode(array("response" => "success", "token" => $_SESSION['xss'], "view" => $view, "debug" => $data));
	    
    }
    
    public function table_transaction_salesreceipt() {
    	
    	$data  = json_decode($this->getAllSalesReceipt(), true);
    	    	    
	    	$view .= "<table id='accounting-".$this->params."-tableCoa' class='table table-hover table-striped table-small-font'>";
	    	
	    	$view .= "<thead class='table-header-blue table-header-bold'>";
	    	
	    		$view .= "<tr>";
	    		
		    		$view .= "<td class='table-valign-middle'><input type='checkbox'></td>";
		    		
		    		$view .= "<td class='table-valign-middle'>Num</td>";
		    		
		    		$view .= "<td class='table-valign-middle'>To</td>";
		    		
		    		$view .= "<td class='table-valign-middle'>Date</td>";
		    		
		    		$view .= "<td class='table-valign-middle'>Due Date</td>";
		    		
		    		$view .= "<td class='table-valign-middle'>Status</td>";
		    		
		    		$view .= "<td class='table-valign-middle table-align-right'>Paid</td>";
		    		
		    		$view .= "<td class='table-valign-middle table-align-right'>Due</td>";
		    		
	    		$view .= "</tr>";
	    	
	    	$view .= "</thead>";
	    	
	    	$view .= "<tbody>";
	    	
	    		if (!empty($data)):
	    		
	    			foreach ($data as $key => $value):
	    				    			
	    			$crypt = encryption::urlHashEncodingRinjndael($_SESSION['xss'],$value['CAP_ACC_TRA_ID']);
	    			
	    			$numb  = (!empty($value['CAP_ACC_TRA_NUMBER'])) ? $value['CAP_ACC_TRA_NUMBER'] : 'Number Not Set';
	    			
	    			$view .= "<tr class='accounting-clickable'>";
	    				
	    				$view .= "<td><input type='checkbox' value='".$value['CAP_ACC_TRA_ID']."'></td>";
	    				
	    				$view .= "<td><a href='".$this->url->builder(3940,'sales-receipt',true)."?actio=view|||sales-receipt|||".$crypt."&emblem=".$_SESSION['xss']."'>".$numb."</a></td>";
	    				
	    				$view .= "<td>".ucwords(strtolower($value['CAP_ACC_CON_CONTACT']))."</td>";
	    				
	    				$view .= "<td>".date("d F Y",strtotime($value['CAP_ACC_TRA_DATE']))."</td>";
	    				
	    				$view .= "<td>".date("d F Y",strtotime($value['CAP_ACC_TRA_DUEDATE']))."</td>";
	    				
	    				$view .= "<td></td>";
	    					    					    				
	    				$view .= "<td class='table-align-right'>".number_format($value['CAP_ACC_TRA_TOTALLEFT'], 2)."</td>";
	    				
	    				$view .= "<td class='table-align-right'>".number_format($value['CAP_ACC_TRA_TOTAL'], 2)."</td>";
	    					    			
	    			$view .= "</tr>";
	    			
	    			endforeach;
	    		
	    		endif;
	    	
	    	$view .= "</tbody>";
	    	
	    	$view .= "<tfoot>";
	    	
	    	$view .= "</tfoot>";
	    	
	    $view .= "</table>";
			   	  
	    echo json_encode(array("response" => "success", "token" => $_SESSION['xss'], "view" => $view, "debug" => $data));
	    
    }
    
    public function table_transaction_receipt() {
    	
    	$data  = json_decode($this->getAllReceipt(), true);
    	    	    
	    	$view .= "<table id='accounting-".$this->params."-tableCoa' class='table table-hover table-striped table-small-font'>";
	    	
	    	$view .= "<thead class='table-header-blue table-header-bold'>";
	    	
	    		$view .= "<tr>";
	    		
		    		$view .= "<td class='table-valign-middle'><input type='checkbox'></td>";
		    		
		    		$view .= "<td class='table-valign-middle'>Num</td>";
		    		
		    		$view .= "<td class='table-valign-middle'>To</td>";
		    		
		    		$view .= "<td class='table-valign-middle'>Date</td>";
		    		
		    		$view .= "<td class='table-valign-middle'>Due Date</td>";
		    		
		    		$view .= "<td class='table-valign-middle'>Status</td>";
		    		
		    		$view .= "<td class='table-valign-middle table-align-right'>Paid</td>";
		    		
		    		$view .= "<td class='table-valign-middle table-align-right'>Due</td>";
		    		
	    		$view .= "</tr>";
	    	
	    	$view .= "</thead>";
	    	
	    	$view .= "<tbody>";
	    	
	    		if (!empty($data)):
	    		
	    			foreach ($data as $key => $value):
	    				    			
	    			$crypt = encryption::urlHashEncodingRinjndael($_SESSION['xss'],$value['CAP_ACC_TRA_ID']);
	    			
	    			$numb  = (!empty($value['CAP_ACC_TRA_NUMBER'])) ? $value['CAP_ACC_TRA_NUMBER'] : 'Number Not Set';
	    			
	    			$view .= "<tr class='accounting-clickable'>";
	    				
	    				$view .= "<td><input type='checkbox' value='".$value['CAP_ACC_TRA_ID']."'></td>";
	    				
	    				$view .= "<td><a href='".$this->url->builder(3803,'receipt',true)."?actio=view|||receipt|||".$crypt."&emblem=".$_SESSION['xss']."'>".$numb."</a></td>";
	    				
	    				$view .= "<td>".ucwords(strtolower($value['CAP_ACC_CON_CONTACT']))."</td>";
	    				
	    				$view .= "<td>".date("d F Y",strtotime($value['CAP_ACC_TRA_DATE']))."</td>";
	    				
	    				$view .= "<td>".date("d F Y",strtotime($value['CAP_ACC_TRA_DUEDATE']))."</td>";
	    				
	    				$view .= "<td></td>";
	    					    					    				
	    				$view .= "<td class='table-align-right'>".number_format($value['CAP_ACC_TRA_TOTALLEFT'], 2)."</td>";
	    				
	    				$view .= "<td class='table-align-right'>".number_format($value['CAP_ACC_TRA_TOTAL'], 2)."</td>";
	    					    			
	    			$view .= "</tr>";
	    			
	    			endforeach;
	    		
	    		endif;
	    	
	    	$view .= "</tbody>";
	    	
	    	$view .= "<tfoot>";
	    	
	    	$view .= "</tfoot>";
	    	
	    $view .= "</table>";
			   	  
	    echo json_encode(array("response" => "success", "token" => $_SESSION['xss'], "view" => $view, "debug" => $data));
	    
    }
    
    public function table_transaction_transfer() {
    	
    	$data  = json_decode($this->getAllTransfer(), true);
    	    	    
	    	$view .= "<table id='accounting-".$this->params."-tableCoa' class='table table-hover table-striped table-small-font'>";
	    	
	    	$view .= "<thead class='table-header-blue table-header-bold'>";
	    	
	    		$view .= "<tr>";
	    		
		    		$view .= "<td class='table-valign-middle'><input type='checkbox'></td>";
		    		
		    		$view .= "<td class='table-valign-middle'>Num</td>";
		    				    		
		    		$view .= "<td class='table-valign-middle'>Date</td>";
		    				    		
		    		$view .= "<td class='table-valign-middle'>Status</td>";
		    				    		
		    		$view .= "<td class='table-valign-middle table-align-right'>Total</td>";
		    		
	    		$view .= "</tr>";
	    	
	    	$view .= "</thead>";
	    	
	    	$view .= "<tbody>";
	    	
	    		if (!empty($data)):
	    		
	    			foreach ($data as $key => $value):
	    				    			
	    			$crypt = encryption::urlHashEncodingRinjndael($_SESSION['xss'],$value['CAP_ACC_TRA_ID']);
	    			
	    			$numb  = (!empty($value['CAP_ACC_TRA_NUMBER'])) ? $value['CAP_ACC_TRA_NUMBER'] : 'Number Not Set';
	    			
	    			$view .= "<tr class='accounting-clickable'>";
	    				
	    				$view .= "<td><input type='checkbox' value='".$value['CAP_ACC_TRA_ID']."'></td>";
	    				
	    				$view .= "<td><a href='".$this->url->builder(3804,'transfer',true)."?actio=view|||transfer|||".$crypt."&emblem=".$_SESSION['xss']."'>".$numb."</a></td>";
	    					    				
	    				$view .= "<td>".date("d F Y",strtotime($value['CAP_ACC_TRA_DATE']))."</td>";
	    					    				
	    				$view .= "<td></td>";
	    					    					    					    				
	    				$view .= "<td class='table-align-right'>".number_format($value['CAP_ACC_TRA_TOTAL'], 2)."</td>";
	    					    			
	    			$view .= "</tr>";
	    			
	    			endforeach;
	    		
	    		endif;
	    	
	    	$view .= "</tbody>";
	    	
	    	$view .= "<tfoot>";
	    	
	    	$view .= "</tfoot>";
	    	
	    $view .= "</table>";
			   	  
	    echo json_encode(array("response" => "success", "token" => $_SESSION['xss'], "view" => $view, "debug" => $data));
	    
    }
    
    public function table_transaction_payment() {
    	
    	$data  = json_decode($this->getAllPayment(), true);
    	    	    
	    	$view .= "<table id='accounting-".$this->params."-tableCoa' class='table table-hover table-striped table-small-font'>";
	    	
	    	$view .= "<thead class='table-header-blue table-header-bold'>";
	    	
	    		$view .= "<tr>";
	    		
		    		$view .= "<td class='table-valign-middle'><input type='checkbox'></td>";
		    		
		    		$view .= "<td class='table-valign-middle'>Num</td>";
		    				    		
		    		$view .= "<td class='table-valign-middle'>Date</td>";
		    				    		
		    		$view .= "<td class='table-valign-middle'>Status</td>";
		    				    		
		    		$view .= "<td class='table-valign-middle table-align-right'>Total</td>";
		    		
	    		$view .= "</tr>";
	    	
	    	$view .= "</thead>";
	    	
	    	$view .= "<tbody>";
	    	
	    		if (!empty($data)):
	    		
	    			foreach ($data as $key => $value):
	    				    			
	    			$crypt = encryption::urlHashEncodingRinjndael($_SESSION['xss'],$value['CAP_ACC_TRA_ID']);
	    			
	    			$numb  = (!empty($value['CAP_ACC_TRA_NUMBER'])) ? $value['CAP_ACC_TRA_NUMBER'] : 'Number Not Set';
	    			
	    			$view .= "<tr class='accounting-clickable'>";
	    				
	    				$view .= "<td><input type='checkbox' value='".$value['CAP_ACC_TRA_ID']."'></td>";
	    				
	    				$view .= "<td><a href='".$this->url->builder(3805,'payment',true)."?actio=view|||payment|||".$crypt."&emblem=".$_SESSION['xss']."'>".$numb."</a></td>";
	    					    				
	    				$view .= "<td>".date("d F Y",strtotime($value['CAP_ACC_TRA_DATE']))."</td>";
	    					    				
	    				$view .= "<td></td>";
	    					    					    					    				
	    				$view .= "<td class='table-align-right'>".number_format($value['CAP_ACC_TRA_TOTAL'], 2)."</td>";
	    					    			
	    			$view .= "</tr>";
	    			
	    			endforeach;
	    		
	    		endif;
	    	
	    	$view .= "</tbody>";
	    	
	    	$view .= "<tfoot>";
	    	
	    	$view .= "</tfoot>";
	    	
	    $view .= "</table>";
			   	  
	    echo json_encode(array("response" => "success", "token" => $_SESSION['xss'], "view" => $view, "debug" => $data));
	    
    }
    
    public function table_transaction_paybill() {
    	
    	$data  = json_decode($this->getAllPaybill(), true);
    	    	    
	    	$view .= "<table id='accounting-".$this->params."-tableCoa' class='table table-hover table-striped table-small-font'>";
	    	
	    	$view .= "<thead class='table-header-blue table-header-bold'>";
	    	
	    		$view .= "<tr>";
	    		
		    		$view .= "<td class='table-valign-middle'><input type='checkbox'></td>";
		    		
		    		$view .= "<td class='table-valign-middle'>Num</td>";
		    				    		
		    		$view .= "<td class='table-valign-middle'>Date</td>";
		    				    		
		    		$view .= "<td class='table-valign-middle'>Status</td>";
		    				    		
		    		$view .= "<td class='table-valign-middle table-align-right'>Total</td>";
		    		
	    		$view .= "</tr>";
	    	
	    	$view .= "</thead>";
	    	
	    	$view .= "<tbody>";
	    	
	    		if (!empty($data)):
	    		
	    			foreach ($data as $key => $value):
	    				    			
	    			$crypt = encryption::urlHashEncodingRinjndael($_SESSION['xss'],$value['CAP_ACC_TRA_ID']);
	    			
	    			$numb  = (!empty($value['CAP_ACC_TRA_NUMBER'])) ? $value['CAP_ACC_TRA_NUMBER'] : 'Number Not Set';
	    			
	    			$view .= "<tr class='accounting-clickable'>";
	    				
	    				$view .= "<td><input type='checkbox' value='".$value['CAP_ACC_TRA_ID']."'></td>";
	    				
	    				$view .= "<td><a href='".$this->url->builder(3806,'pay-bill',true)."?actio=view|||paybill|||".$crypt."&emblem=".$_SESSION['xss']."'>".$numb."</a></td>";
	    					    				
	    				$view .= "<td>".date("d F Y",strtotime($value['CAP_ACC_TRA_DATE']))."</td>";
	    					    				
	    				$view .= "<td></td>";
	    					    					    					    				
	    				$view .= "<td class='table-align-right'>".number_format($value['CAP_ACC_TRA_TOTAL'], 2)."</td>";
	    					    			
	    			$view .= "</tr>";
	    			
	    			endforeach;
	    		
	    		endif;
	    	
	    	$view .= "</tbody>";
	    	
	    	$view .= "<tfoot>";
	    	
	    	$view .= "</tfoot>";
	    	
	    $view .= "</table>";
			   	  
	    echo json_encode(array("response" => "success", "token" => $_SESSION['xss'], "view" => $view, "debug" => $data));
	    
    }
    
    public function form_createCoa() {
	    
	    $account = json_decode($this->getCoaType(),true);
	    
	    $accgrp  = json_decode($this->getCoaTypeGroup(),true);
	    
	    $acccur  = json_decode($this->getCurrencyAccount(),true);
	    	    
	    $header  = "Add Account";
	    
	    $body  = "<form id='accounting-".$this->params."-form'>";
		
			$body .= "<div class='row'>";
			
				$body .= "<div class='span3 accounting-".$this->params."-leftForm'>";
				
					$body .= "<div class='control-group'>";
					
						$body .= "<label class='control-label bold-small control-label-form' for='type'>Account Type</label><span class='help-block muted small-font'>Type for this account <i class='icon-question-sign'></i></span>";
						
						$body .= "<div class='controls accounting-".$this->params."-selectContainer'>";
						
							$body .= "<select class='accounting-".$this->params."-select accounting-".$this->params."-mainSelector' id='type'>";
								
								$body .= "<option selected='selected' value=''></option>";
								
								if (!empty($accgrp)):
								
									foreach ($accgrp as $key => $value):
										
										if ($value['CAP_ACC_COA_TYP_TYPE'] == 'ASSET'):
										
										$body .= "<optgroup label='Asset'>";
										
										elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'BANK'):
										
										$body .= "<optgroup label='Bank'>";
										
										elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'LIABILITY'):
										
										$body .= "<optgroup label='Liability'>";
										
										elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'COST OF GOODS SOLD'):
										
										$body .= "<optgroup label='Cogs'>";
										
										elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'EXPENSE'):
										
										$body .= "<optgroup label='Expense'>";
										
										elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'EQUITY'):
										
										$body .= "<optgroup label='Equity'>";
										
										elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'REVENUE'):
										
										$body .= "<optgroup label='Revenue'>";
										
										endif;
										
										if (!empty($account)):
															
											foreach ($account as $key2 => $value2):
											
												if ($value['CAP_ACC_COA_TYP_TYPE'] == 'ASSET' && $value2['CAP_ACC_COA_TYP_TYPE'] == 'ASSET'):
																			
												$body .= "<option value='".$value2['CAP_ACC_COA_TYP_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_TYP_NAME']))."</option>";
												
												elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'BANK'  && $value2['CAP_ACC_COA_TYP_TYPE'] == 'BANK'):
												
												$body .= "<option value='".$value2['CAP_ACC_COA_TYP_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_TYP_NAME']))."</option>";
												
												elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'LIABILITY'  && $value2['CAP_ACC_COA_TYP_TYPE'] == 'LIABILITY'):
												
												$body .= "<option value='".$value2['CAP_ACC_COA_TYP_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_TYP_NAME']))."</option>";
												
												elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'COST OF GOODS SOLD'  && $value2['CAP_ACC_COA_TYP_TYPE'] == 'COST OF GOODS SOLD'):
												
												$body .= "<option value='".$value2['CAP_ACC_COA_TYP_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_TYP_NAME']))."</option>";
												
												elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'EXPENSE'  && $value2['CAP_ACC_COA_TYP_TYPE'] == 'EXPENSE'):
												
												$body .= "<option value='".$value2['CAP_ACC_COA_TYP_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_TYP_NAME']))."</option>";
												
												elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'EQUITY'  && $value2['CAP_ACC_COA_TYP_TYPE'] == 'EQUITY'):
												
												$body .= "<option value='".$value2['CAP_ACC_COA_TYP_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_TYP_NAME']))."</option>";
												
												elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'REVENUE'  && $value2['CAP_ACC_COA_TYP_TYPE'] == 'REVENUE'):
												
												$body .= "<option value='".$value2['CAP_ACC_COA_TYP_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_TYP_NAME']))."</option>";							
												endif;
											
											endforeach;
										
										endif;
																
									endforeach;
								
								endif;
							
							$body .= "</select>";
							
						$body .= "</div>";
						
					$body .= "</div>";
					
					$body .= "<div class='control-group'>";
					
						$body .= "<label class='control-label bold-small control-label-form' for='code'>Code</label><span class='help-block muted small-font'>Unique number for this account <i class='icon-question-sign'></i></span>";
						
						$body .= "<div class='controls'><input type='text' id='code'></div>";
						
					$body .= "</div>";
					
					$body .= "<div class='control-group'>";
					
						$body .= "<label class='control-label bold-small control-label-form' for='name'>Name</label><span class='help-block muted small-font'>Short title (limit 100 character) <i class='icon-question-sign'></i></span>";
						
						$body .= "<div class='controls'><input type='text' id='name'></div>";
						
					$body .= "</div>";
					
					$body .= "<div class='control-group'>";
					
						$body .= "<label class='control-label bold-small control-label-form' for='description'>Description (optional)</label><span class='help-block muted small-font'>How this account will be used <i class='icon-question-sign'></i></span>";
						
						$body .= "<div class='controls'><input type='text' id='description'></div>";
						
					$body .= "</div>";
										
				$body .= "</div>";
						
				$body .= "<div class='span3'>";
					
					/*
					
					$body .= "<div class='control-group'>";
					
						$body .= "<label class='control-label bold-small control-label-form' for='tax'>Tax</label><span class='help-block muted small-font'>Default tax setting for this account <i class='icon-question-sign'></i></span>";
						
						$body .= "<div class='controls accounting-".$this->params."-selectContainer'><select class='accounting-form_createCoa-select' id='tax'><option></option><option>Ppn</option></select></div>";
						
					$body .= "</div>";
					
					*/
					
					$body .= "<div class='control-group accounting-".$this->params."-bankAccount'>";
					
						$body .= "<label class='control-label bold-small control-label-form' for='currency'>Currency</label><span class='help-block muted small-font'>Bank account currency <i class='icon-question-sign'></i></span>";
						
						$body .= "<div class='controls accounting-".$this->params."-selectContainer'><select class='accounting-form_createCoa-select' id='currency'><option></option>";
						
						if (!empty($acccur)):
						
							foreach ($acccur as $key => $value):
							
								$body .= "<option value='".$value['CAP_ACC_USE_ACC_CUR_ID']."'>".$value['CAP_ACC_CUR_NAME']." ".$value['CAP_ACC_CUR_PREFIX']."</option>";
													
							endforeach;
						
						endif;
						
						$body .= "</select>";
						
						$body .= "</div>";
						
					$body .= "</div>";
					
					$body .= "<div class='control-group accounting-".$this->params."-bankAccount'>";
					
						$body .= "<label class='control-label bold-small control-label-form' for='number'>Account Number</label><span class='help-block muted small-font'>Bank account number <i class='icon-question-sign'></i></span>";
						
												
						$body .= "<div class='controls'><input type='text' id='number'></div>";
						
					$body .= "</div>";
				
				$body .= "</div>";
			
			$body .= "</div>";
			
		$body .= "</form>";
		
		$footer .= "<button class='btn btn-small' data-dismiss='modal' aria-hidden='true'>Cancel</button>";
			    
		$footer .= "<button id='accounting-".$this->params."-createCoa' class='btn btn-info btn-small'>Create account</button>";
		
		echo json_encode(array("response" => "success", "token" => $_SESSION['xss'], "viewHeader" => $header, "viewBody" => $body, "viewFooter" => $footer));
					    
    }
    
    public function form_updateCoa() {
	    
	    $account = json_decode($this->getCoaType(),true);
	    
	    $accgrp  = json_decode($this->getCoaTypeGroup(),true);
	    
	    $data    = json_decode($this->getCoaData(),true);
	    
	    $acccur  = json_decode($this->getCurrencyAccount(),true);
	    	    
	    $header  = "Edit Account";
	    
	    $body  = "<form id='accounting-".$this->params."-form'>";
		
		$body .= "<input type='hidden' id='id' value='".$this->data."'>";
		
			$body .= "<div class='row'>";
			
				$body .= "<div class='span3 accounting-".$this->params."-leftForm'>";
		
			$body .= "<div class='control-group'>";
			
				$body .= "<label class='control-label bold-small control-label-form' for='type'>Account Type</label><span class='help-block muted small-font'>Type for this account <i class='icon-question-sign'></i></span>";
				
				$body .= "<div class='controls accounting-".$this->params."-selectContainer''>";
				
					$body .= "<select disabled='disabled' class='accounting-".$this->params."-select accounting-".$this->params."-mainSelector' id='type'>";
						
						$body .= "<option selected='selected' value=''></option>";
						
						foreach ($accgrp as $key => $value):
							
							if ($value['CAP_ACC_COA_TYP_TYPE'] == 'ASSET'):
							
							$body .= "<optgroup label='Asset'>";
							
							elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'BANK'):
							
							$body .= "<optgroup label='Bank'>";
							
							elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'LIABILITY'):
							
							$body .= "<optgroup label='Liability'>";
							
							elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'EXPENSE'):
							
							$body .= "<optgroup label='Expense'>";
							
							elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'EQUITY'):
							
							$body .= "<optgroup label='Equity'>";
							
							elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'REVENUE'):
							
							$body .= "<optgroup label='Revenue'>";
							
							endif;
												
							foreach ($account as $key2 => $value2):
							
								if ($value['CAP_ACC_COA_TYP_TYPE'] == 'ASSET' && $value2['CAP_ACC_COA_TYP_TYPE'] == 'ASSET'):
									
									if ($data['FK_CAP_ACC_COA_TYP_ID'] == $value2['CAP_ACC_COA_TYP_ID']):
									
									$body .= "<option selected='selected' value='".$value2['CAP_ACC_COA_TYP_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_TYP_NAME']))."</option>";
									
									else:
									
									$body .= "<option value='".$value2['CAP_ACC_COA_TYP_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_TYP_NAME']))."</option>";
									
									endif;
																					
								elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'BANK'  && $value2['CAP_ACC_COA_TYP_TYPE'] == 'BANK'):
																		
									if ($data['FK_CAP_ACC_COA_TYP_ID'] == $value2['CAP_ACC_COA_TYP_ID']):
									
									$bank = true;
									
									$body .= "<option selected='selected' value='".$value2['CAP_ACC_COA_TYP_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_TYP_NAME']))."</option>";
									
									else:
									
									$body .= "<option value='".$value2['CAP_ACC_COA_TYP_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_TYP_NAME']))."</option>";
									
									endif;
								
								elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'LIABILITY'  && $value2['CAP_ACC_COA_TYP_TYPE'] == 'LIABILITY'):
								
									if ($data['FK_CAP_ACC_COA_TYP_ID'] == $value2['CAP_ACC_COA_TYP_ID']):
									
									$body .= "<option selected='selected' value='".$value2['CAP_ACC_COA_TYP_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_TYP_NAME']))."</option>";
									
									else:
									
									$body .= "<option value='".$value2['CAP_ACC_COA_TYP_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_TYP_NAME']))."</option>";
									
									endif;
								
								elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'EXPENSE'  && $value2['CAP_ACC_COA_TYP_TYPE'] == 'EXPENSE'):
								
									if ($data['FK_CAP_ACC_COA_TYP_ID'] == $value2['CAP_ACC_COA_TYP_ID']):
									
									$body .= "<option selected='selected' value='".$value2['CAP_ACC_COA_TYP_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_TYP_NAME']))."</option>";
									
									else:
									
									$body .= "<option value='".$value2['CAP_ACC_COA_TYP_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_TYP_NAME']))."</option>";
									
									endif;
								
								elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'EQUITY'  && $value2['CAP_ACC_COA_TYP_TYPE'] == 'EQUITY'):
								
									if ($data['FK_CAP_ACC_COA_TYP_ID'] == $value2['CAP_ACC_COA_TYP_ID']):
									
									$body .= "<option selected='selected' value='".$value2['CAP_ACC_COA_TYP_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_TYP_NAME']))."</option>";
									
									else:
									
									$body .= "<option value='".$value2['CAP_ACC_COA_TYP_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_TYP_NAME']))."</option>";
									
									endif;
								
								elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'REVENUE'  && $value2['CAP_ACC_COA_TYP_TYPE'] == 'REVENUE'):
								
									if ($data['FK_CAP_ACC_COA_TYP_ID'] == $value2['CAP_ACC_COA_TYP_ID']):
									
									$body .= "<option selected='selected' value='".$value2['CAP_ACC_COA_TYP_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_TYP_NAME']))."</option>";
									
									else:
									
									$body .= "<option value='".$value2['CAP_ACC_COA_TYP_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_TYP_NAME']))."</option>";
									
									endif;
																
								endif;
							
							endforeach;
													
						endforeach;
					
					$body .= "</select>";
					
				$body .= "</div>";
				
			$body .= "</div>";
			
			$body .= "<div class='control-group'>";
			
				$body .= "<label class='control-label bold-small control-label-form' for='code'>Code</label><span class='help-block muted small-font'>Unique number for this account <i class='icon-question-sign'></i></span>";
				
				$body .= "<div class='controls'><input type='text' id='code' value='".$data['CAP_ACC_COA_CODE']."'></div>";
				
			$body .= "</div>";
			
			$body .= "<div class='control-group'>";
			
				$body .= "<label class='control-label bold-small control-label-form' for='name'>Name</label><span class='help-block muted small-font'>Short title (limit 100 character) <i class='icon-question-sign'></i></span>";
				
				$body .= "<div class='controls'><input type='text' id='name' value='".ucwords(strtolower($data['CAP_ACC_COA_NAME']))."'></div>";
				
			$body .= "</div>";
			
			$body .= "<div class='control-group'>";
			
				$body .= "<label class='control-label bold-small control-label-form' for='description'>Description (optional)</label><span class='help-block muted small-font'>How this account will be used <i class='icon-question-sign'></i></span>";
				
				$body .= "<div class='controls'><input type='text' id='description' value='".ucwords(strtolower($data['CAP_ACC_COA_DESC']))."'></div>";
				
			$body .= "</div>";
			
			$body .= "</div>";
						
				$body .= "<div class='span3'>";
					
					/*
					
					$body .= "<div class='control-group'>";
					
						$body .= "<label class='control-label bold-small control-label-form' for='tax'>Tax</label><span class='help-block muted small-font'>Default tax setting for this account <i class='icon-question-sign'></i></span>";
						
						$body .= "<div class='controls accounting-".$this->params."-selectContainer'><select class='accounting-form_updateCoa-select' id='tax'><option></option><option>Ppn</option></select></div>";
						
					$body .= "</div>";
					
					*/
					
					if ($bank):
					
					$body .= "<div class='control-group accounting-".$this->params."-bankAccount'>";
					
						$body .= "<label class='control-label bold-small control-label-form' for='currency'>Currency</label><span class='help-block muted small-font'>Bank account currency <i class='icon-question-sign'></i></span>";
						
						$body .= "<div class='controls accounting-".$this->params."-selectContainer'><select disabled='disabled' class='accounting-form_updateCoa-select' id='currency'><option></option>";
						
						if (!empty($acccur)):
						
							foreach ($acccur as $key => $value):
								
								if ($data['FK_CAP_ACC_USE_ACC_CUR_ID'] == $value['CAP_ACC_USE_ACC_CUR_ID']):
								
								$body .= "<option selected='selected' value='".$value['CAP_ACC_USE_ACC_CUR_ID']."'>".$value['CAP_ACC_CUR_NAME']." ".$value['CAP_ACC_CUR_PREFIX']."</option>";
								
								else:
								
								$body .= "<option value='".$value['CAP_ACC_USE_ACC_CUR_ID']."'>".$value['CAP_ACC_CUR_NAME']." ".$value['CAP_ACC_CUR_PREFIX']."</option>";
								
								endif;
													
							endforeach;
						
						endif;
						
						$body .= "</select>";
						
						$body .= "</div>";
						
					$body .= "</div>";
					
					$body .= "<div class='control-group accounting-".$this->params."-bankAccount'>";
					
						$body .= "<label class='control-label bold-small control-label-form' for='number'>Account Number</label><span class='help-block muted small-font'>Bank account number <i class='icon-question-sign'></i></span>";
						
												
						$body .= "<div class='controls'><input type='text' id='number' value='".$data['CAP_ACC_COA_NUMBER']."'></div>";
						
					$body .= "</div>";
				
				$body .= "</div>";
				
				endif;
			
			$body .= "</div>";
			
		$body .= "</form>";
		
		$footer .= "<button class='btn btn-small' data-dismiss='modal' aria-hidden='true'>Cancel</button>";
			    
		$footer .= "<button id='accounting-".$this->params."-updateCoa' class='btn btn-info btn-small'>Update account</button>";
		
		echo json_encode(array("response" => "success", "token" => $_SESSION['xss'], "viewHeader" => $header, "viewBody" => $body, "viewFooter" => $footer));
					    
    }
    
    public function form_deleteCoa() {
	    
	    $account = json_decode($this->getCoaType(),true);
	    
	    $accgrp  = json_decode($this->getCoaTypeGroup(),true);
	    
	    $header  = "Delete Account";
	    			
		$body   .= "<div class='alert alert-error'>Warning!!! This action is irreversible. All related transaction will also be deleted.</div>";
		
		$body   .= "<div class='deleteAccountWarning'></div>";
		
		$footer .= "<button class='btn btn-small' data-dismiss='modal' aria-hidden='true'>Cancel</button>";
		
		$footer .= "<button id='accounting-".$this->params."-deleteCoa' class='btn btn-danger btn-small'>Delete account</button>";
		
		echo json_encode(array("response" => "success", "token" => $_SESSION['xss'], "viewHeader" => $header, "viewBody" => $body, "viewFooter" => $footer));
					    
    }
    
    public function form_createItem() {
	    
	    $account = json_decode($this->getAllCoaData(),true);
	    
	    $itemTyp = json_decode($this->getItemType(),true);
	    
	    $accgrp  = json_decode($this->getCoaTypeGroup(),true);
	    
	    $acccur  = json_decode($this->getCurrencyAccount(),true);
	    
	    $acctax  = json_decode($this->getItemTax(), true);
	    
	    $optiont = "<option selected='selected' value=''></option>";
	    
	    if (!empty($acctax)):
	    
	    	foreach ($acctax as $key => $value):
	    	
	    	$optiont .= "<option value='".$value['CAP_ACC_ITE_ID']."'>".ucwords(strtolower($value['CAP_ACC_ITE_NAME']))."</option>";
	    	
	    	endforeach;
	    
	    endif;
	    
	    $option = "<option selected='selected' value=''></option>";
	    
	    $optionc = "<option selected='selected' value=''></option>";
							
		if (!empty($accgrp)):
		
			foreach ($accgrp as $key => $value):
				
				if ($value['CAP_ACC_COA_TYP_TYPE'] == 'ASSET'):
				
				$option .= "<optgroup label='Asset'>";
				
				elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'BANK'):
				
				$option .= "<optgroup label='Bank'>";
				
				elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'LIABILITY'):
				
				$option .= "<optgroup label='Liability'>";
								
				elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'EXPENSE'):
				
				$option .= "<optgroup label='Expense'>";
				
				elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'EQUITY'):
				
				$option .= "<optgroup label='Equity'>";
				
				elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'REVENUE'):
				
				$option .= "<optgroup label='Revenue'>";
				
				endif;

				if (!empty($account)):
									
					foreach ($account as $key2 => $value2):
					
						if ($value['CAP_ACC_COA_TYP_TYPE'] == 'ASSET' && $value2['CAP_ACC_COA_TYP_TYPE'] == 'ASSET'):
													
						$option .= "<option value='".$value2['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_NAME']))."</option>";
						
						elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'BANK'  && $value2['CAP_ACC_COA_TYP_TYPE'] == 'BANK'):
						
						$option .= "<option value='".$value2['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_NAME']))."</option>";
						
						elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'LIABILITY'  && $value2['CAP_ACC_COA_TYP_TYPE'] == 'LIABILITY'):
						
						$option .= "<option value='".$value2['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_NAME']))."</option>";
																		
						elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'EXPENSE' && $value2['CAP_ACC_COA_TYP_TYPE'] == 'EXPENSE'):
						
							if ($value2['CAP_ACC_COA_TYP_NAME'] == 'COST OF GOODS SOLD'):
							
							$optionc .= "<option value='".$value2['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_NAME']))."</option>";
							
							else:
							
							$option .= "<option value='".$value2['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_NAME']))."</option>";
							
							endif;
												
						elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'EQUITY'  && $value2['CAP_ACC_COA_TYP_TYPE'] == 'EQUITY'):
						
						$option .= "<option value='".$value2['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_NAME']))."</option>";
						
						elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'REVENUE'  && $value2['CAP_ACC_COA_TYP_TYPE'] == 'REVENUE'):
						
						$option .= "<option value='".$value2['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_NAME']))."</option>";	
												
						endif;
					
					endforeach;
				
				endif;
										
			endforeach;
		
		endif;

	    $header  = "Add Item";
	    
	    $body  = "<form id='accounting-".$this->params."-form'>";
		
			$body .= "<div class='row'>";
			
				$body .= "<div class='span3 accounting-".$this->params."-leftForm'>";
				
					$body .= "<div class='control-group'>";
					
						$body .= "<label class='control-label bold-small control-label-form' for='type'>Item Type</label><span class='help-block muted small-font'>Type for this item <i class='icon-question-sign'></i></span>";
						
						$body .= "<div class='controls accounting-".$this->params."-selectContainer'>";
						
							$body .= "<select class='accounting-".$this->params."-select accounting-".$this->params."-mainSelector' id='type'>";
								
								$body .= "<option selected='selected' value=''></option>";
								
								if (!empty($itemTyp)):
								
									foreach ($itemTyp as $key => $value):
										
										$body .= "<option value='".$value['CAP_ACC_ITE_TYP_ID']."'>".ucwords(strtolower($value['CAP_ACC_ITE_TYP_NAME']))."</option>";
																																			
									endforeach;
								
								endif;
							
							$body .= "</select>";
							
						$body .= "</div>";
						
					$body .= "</div>";
					
					$body .= "<div class='control-group'>";
					
						$body .= "<label class='control-label bold-small control-label-form' for='code'>Code</label><span class='help-block muted small-font'>Unique number for this item <i class='icon-question-sign'></i></span>";
						
						$body .= "<div class='controls'><input type='text' id='code'></div>";
						
					$body .= "</div>";
					
					$body .= "<div class='control-group'>";
					
						$body .= "<label class='control-label bold-small control-label-form' for='name'>Name</label>
								  <span class='help-block muted small-font'>Short title (limit 100 character) 
								  	<i class='icon-question-sign'></i>
								  </span>";
						
						$body .= "<div class='controls'><input type='text' id='name'></div>";
						
					$body .= "</div>";
					
					$body .= "<div class='control-group'>";
					
						$body .= "<label class='control-label bold-small control-label-form' for='description'>Description (optional)</label><span class='help-block muted small-font'>How this item will be used <i class='icon-question-sign'></i></span>";
						
						$body .= "<div class='controls'><input type='text' id='description'></div>";
						
					$body .= "</div>";
										
				$body .= "</div>";
						
				$body .= "<div class='span3 accounting-".$this->params."-leftForm accounting-item-notexist-subtotal'>";
												
					$body .= "<div class='control-group'>";
					
						$body .= "<label class='control-label bold-small control-label-form' for='purchase-unit-price'>Purchase Unit Price</label><span class='help-block muted small-font'>Default unit buying price <i class='icon-question-sign'></i></span>";
						
						$body .= "<div class='controls'><input type='text' id='purchase-unit-price'></div>";
						
					$body .= "</div>";
					
					$body .= "<div class='control-group accounting-".$this->params."-bankAccount'>";
					
						$body .= "<label class='control-label bold-small control-label-form' for='account-purchase'>Purchase Account</label><span class='help-block muted small-font'>Default account for puchase <i class='icon-question-sign'></i></span>";
						
						$body .= "<div class='controls accounting-".$this->params."-selectContainer'>";
												
						$body .= "<select class='accounting-".$this->params."-select' id='account-purchase'>".$option."</select>";
						
						$body .= "</div>";
						
					$body .= "</div>";
					
					$body .= "<div class='control-group accounting-".$this->params."-bankAccount accounting-tax-notexist'>";
					
						$body .= "<label class='control-label bold-small control-label-form' for='purchase-tax'>Purchase Tax Rate</label><span class='help-block muted small-font'>Bank account number <i class='icon-question-sign'></i></span>";
						
						$body .= "<div class='controls accounting-".$this->params."-selectContainer'>";
						
						$body .= "<select class='accounting-".$this->params."-select' id='purchase-tax'>".$optiont."</select>";
						
						$body .= "</div>";
									
					$body .= "</div>";
					
				$body .= "<div class='control-group accounting-".$this->params."-bankAccount'>";
					
						$body .= "<label class='control-label bold-small control-label-form' for='unit-measurement'>Unit Measurement</label><span class='help-block muted small-font'>Default unit measurement (ex. Kg) <i class='icon-question-sign'></i></span>";
						
												
						$body .= "<div class='controls'><input type='text' id='unit-measurement'></div>";
						
					$body .= "</div>";
																								
				$body .= "</div>";
												
				
			$body .= "<div class='span3 accounting-item-notexist-subtotal'>";
				
					$body .= "<div class='control-group'>";
					
						$body .= "<label class='control-label bold-small control-label-form' for='sales-unit-price'>Sales Unit Price</label><span class='help-block muted small-font'>Default unit selling price <i class='icon-question-sign'></i></span>";
						
						$body .= "<div class='controls'><input type='text' id='sales-unit-price'></div>";
						
					$body .= "</div>";
					
					$body .= "<div class='control-group accounting-".$this->params."-bankAccount'>";
					
						$body .= "<label class='control-label bold-small control-label-form' for='account-sales'>Sales Account</label><span class='help-block muted small-font'>Default account for sales <i class='icon-question-sign'></i></span>";
						
						$body .= "<div class='controls accounting-".$this->params."-selectContainer'>";
												
						$body .= "<select class='accounting-".$this->params."-select' id='account-sales'>".$option."</select>";
						
						$body .= "</div>";
						
					$body .= "</div>";
					
					$body .= "<div class='control-group accounting-".$this->params."-bankAccount accounting-tax-notexist'>";
					
						$body .= "<label class='control-label bold-small control-label-form' for='sales-tax'>Sales Tax Rate</label><span class='help-block muted small-font'>Bank account number <i class='icon-question-sign'></i></span>";
						
						$body .= "<div class='controls accounting-".$this->params."-selectContainer'>";
												
						$body .= "<select class='accounting-".$this->params."-select' id='sales-tax'>".$optiont."</select>";
						
						$body .= "</div>";
						
					$body .= "</div>";
					
					$body .= "<div class='control-group accounting-".$this->params."-bankAccount accounting-other-charge-notexist'>";
					
						$body .= "<label class='control-label bold-small control-label-form' for='cogs'>COGS</label><span class='help-block muted small-font'>Cost of Goods Sold <i class='icon-question-sign'></i></span>";
						
						$body .= "<div class='controls accounting-".$this->params."-selectContainer'>";
												
						$body .= "<select class='accounting-".$this->params."-select accounting-".$this->params."-mainSelector' id='cogs'>".$optionc."</select>";
						
						$body .= "</div>";
						
					$body .= "</div>";
					
					$body .= "<div class='control-group accounting-".$this->params."-bankAccount accounting-other-charge-exist'>";	
					
						$body .= "<label class='control-label bold-small control-label-form' for='percentage'>Option</label><span class='help-block muted small-font'>Item option rate <i class='icon-question-sign'></i></span>";					
												
						$body .= "<div class='controls'><input type='checkbox' id='percentage' value='1'> This item has percentage rate</div>";
						
					$body .= "</div>";
									
				$body .= "</div>";
			
			$body .= "</div>";	
			
			$body .= "</div>";
			
		$body .= "</form>";
		
		$footer .= "<button class='btn btn-small' data-dismiss='modal' aria-hidden='true'>Cancel</button>";
			    
		$footer .= "<button id='accounting-".$this->params."-createItem' class='btn btn-info btn-small'>Create item</button>";
		
		echo json_encode(array("response" => "success", "token" => $_SESSION['xss'], "viewHeader" => $header, "viewBody" => $body, "viewFooter" => $footer));
					    
    }
    
    public function form_updateItem() {
	    	    
	    $account = json_decode($this->getAllCoaData(),true);
	    
	    $itemTyp = json_decode($this->getItemType(),true);
	    
	    $accgrp  = json_decode($this->getCoaTypeGroup(),true);
	    
	    $acccur  = json_decode($this->getCurrencyAccount(),true);
	    
	    $acctax  = json_decode($this->getItemTax(), true);
	    
	    $data    = json_decode($this->getItemData(),true);
	    
	    $optiont = "<option selected='selected' value=''></option>";
	    
	    $optiony = "<option selected='selected' value=''></option>";
	    
	    if (!empty($acctax)):
	    
	    	foreach ($acctax as $key => $value):
	    	
	    		if ($data['COA-PURCHASE'][0]['FK_CAP_ACC_ITE_TAX_ID'] == $value['CAP_ACC_ITE_ID']):
	    	
	    		$optiont .= "<option selected='selected' value='".$value['CAP_ACC_ITE_ID']."'>".ucwords(strtolower($value['CAP_ACC_ITE_NAME']))."</option>";
	    		
	    		else:
	    		
	    		$optiont .= "<option value='".$value['CAP_ACC_ITE_ID']."'>".ucwords(strtolower($value['CAP_ACC_ITE_NAME']))."</option>";
	    		
	    		endif;
	    		
	    		if ($data['COA-SELLING'][0]['FK_CAP_ACC_ITE_TAX_ID'] == $value['CAP_ACC_ITE_ID']):
	    	
	    		$optiony .= "<option selected='selected' value='".$value['CAP_ACC_ITE_ID']."'>".ucwords(strtolower($value['CAP_ACC_ITE_NAME']))."</option>";
	    		
	    		else:
	    		
	    		$optiony .= "<option value='".$value['CAP_ACC_ITE_ID']."'>".ucwords(strtolower($value['CAP_ACC_ITE_NAME']))."</option>";
	    		
	    		endif;
	    	
	    	endforeach;
	    
	    endif;
	    
	    $option  = "<option selected='selected' value=''></option>";
	    
	    $optionp = "<option selected='selected' value=''></option>";
	    
	    $optionc = "<option selected='selected' value=''></option>";
							
		if (!empty($accgrp)):
		
			foreach ($accgrp as $key => $value):
				
				if ($value['CAP_ACC_COA_TYP_TYPE'] == 'ASSET'):
				
				$option  .= "<optgroup label='Asset'>";
				
				$optionp .= "<optgroup label='Asset'>";
				
				elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'BANK'):
				
				$option  .= "<optgroup label='Bank'>";
				
				$optionp .= "<optgroup label='Bank'>";
				
				elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'LIABILITY'):
				
				$option  .= "<optgroup label='Liability'>";
				
				$optionp .= "<optgroup label='Liability'>";
								
				elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'EXPENSE'):
				
				$option  .= "<optgroup label='Expense'>";
				
				$optionp .= "<optgroup label='Expense'>";
				
				elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'EQUITY'):
				
				$option  .= "<optgroup label='Equity'>";
				
				$optionp .= "<optgroup label='Equity'>";
				
				elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'REVENUE'):
				
				$option  .= "<optgroup label='Revenue'>";
				
				$optionp .= "<optgroup label='Revenue'>";
				
				endif;

				if (!empty($account)):
									
					foreach ($account as $key2 => $value2):
					
						if ($value['CAP_ACC_COA_TYP_TYPE'] == 'ASSET' && $value2['CAP_ACC_COA_TYP_TYPE'] == 'ASSET'):
						
							if ($data['COA-SELLING'][0]['CAP_ACC_COA_ID'] == $value2['CAP_ACC_COA_ID']):
													
							$option .= "<option selected='selected' value='".$value2['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_NAME']))."</option>";
							
							else:
							
							$option .= "<option value='".$value2['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_NAME']))."</option>";
							
							endif;
							
							if ($data['COA-PURCHASE'][0]['CAP_ACC_COA_ID'] == $value2['CAP_ACC_COA_ID']):
													
							$optionp .= "<option selected='selected' value='".$value2['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_NAME']))."</option>";
							
							else:
							
							$optionp .= "<option value='".$value2['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_NAME']))."</option>";
							
							endif;
						
						elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'BANK'  && $value2['CAP_ACC_COA_TYP_TYPE'] == 'BANK'):
						
							if ($data['COA-SELLING'][0]['CAP_ACC_COA_ID'] == $value2['CAP_ACC_COA_ID']):
													
							$option .= "<option selected='selected' value='".$value2['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_NAME']))."</option>";
							
							else:
							
							$option .= "<option value='".$value2['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_NAME']))."</option>";
							
							endif;
							
							if ($data['COA-PURCHASE'][0]['CAP_ACC_COA_ID'] == $value2['CAP_ACC_COA_ID']):
													
							$optionp .= "<option selected='selected' value='".$value2['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_NAME']))."</option>";
							
							else:
							
							$optionp .= "<option value='".$value2['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_NAME']))."</option>";
							
							endif;
						
						elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'LIABILITY'  && $value2['CAP_ACC_COA_TYP_TYPE'] == 'LIABILITY'):
						
							if ($data['COA-SELLING'][0]['CAP_ACC_COA_ID'] == $value2['CAP_ACC_COA_ID']):
													
							$option .= "<option selected='selected' value='".$value2['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_NAME']))."</option>";
							
							else:
							
							$option .= "<option value='".$value2['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_NAME']))."</option>";
							
							endif;
							
							if ($data['COA-PURCHASE'][0]['CAP_ACC_COA_ID'] == $value2['CAP_ACC_COA_ID']):
													
							$optionp .= "<option selected='selected' value='".$value2['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_NAME']))."</option>";
							
							else:
							
							$optionp .= "<option value='".$value2['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_NAME']))."</option>";
							
							endif;
																		
						elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'EXPENSE' && $value2['CAP_ACC_COA_TYP_TYPE'] == 'EXPENSE'):
						
							if ($value2['CAP_ACC_COA_TYP_NAME'] == 'COST OF GOODS SOLD'):
							
								if ($data['COA-COGS'][0]['CAP_ACC_COA_ID'] == $value2['CAP_ACC_COA_ID']):
							
								$optionc .= "<option selected='selected' value='".$value2['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_NAME']))."</option>";
								
								else:
								
								$optionc .= "<option value='".$value2['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_NAME']))."</option>";
								
								endif;
							
							else:
							
								if ($data['COA-SELLING'][0]['CAP_ACC_COA_ID'] == $value2['CAP_ACC_COA_ID']):
													
								$option .= "<option selected='selected' value='".$value2['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_NAME']))."</option>";
								
								else:
								
								$option .= "<option value='".$value2['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_NAME']))."</option>";
								
								endif;
								
								if ($data['COA-PURCHASE'][0]['CAP_ACC_COA_ID'] == $value2['CAP_ACC_COA_ID']):
														
								$optionp .= "<option selected='selected' value='".$value2['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_NAME']))."</option>";
								
								else:
								
								$optionp .= "<option value='".$value2['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_NAME']))."</option>";
								
								endif;
														
							endif;
												
						elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'EQUITY'  && $value2['CAP_ACC_COA_TYP_TYPE'] == 'EQUITY'):
						
							if ($data['COA-SELLING'][0]['CAP_ACC_COA_ID'] == $value2['CAP_ACC_COA_ID']):
													
							$option .= "<option selected='selected' value='".$value2['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_NAME']))."</option>";
							
							else:
							
							$option .= "<option value='".$value2['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_NAME']))."</option>";
							
							endif;
							
							if ($data['COA-PURCHASE'][0]['CAP_ACC_COA_ID'] == $value2['CAP_ACC_COA_ID']):
													
							$optionp .= "<option selected='selected' value='".$value2['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_NAME']))."</option>";
							
							else:
							
							$optionp .= "<option value='".$value2['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_NAME']))."</option>";
							
							endif;
						
						elseif ($value['CAP_ACC_COA_TYP_TYPE'] == 'REVENUE'  && $value2['CAP_ACC_COA_TYP_TYPE'] == 'REVENUE'):
						
							if ($data['COA-SELLING'][0]['CAP_ACC_COA_ID'] == $value2['CAP_ACC_COA_ID']):
													
							$option .= "<option selected='selected' value='".$value2['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_NAME']))."</option>";
							
							else:
							
							$option .= "<option value='".$value2['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_NAME']))."</option>";
							
							endif;
							
							if ($data['COA-PURCHASE'][0]['CAP_ACC_COA_ID'] == $value2['CAP_ACC_COA_ID']):
													
							$optionp .= "<option selected='selected' value='".$value2['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_NAME']))."</option>";
							
							else:
							
							$optionp .= "<option value='".$value2['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value2['CAP_ACC_COA_NAME']))."</option>";
							
							endif;	
												
						endif;
					
					endforeach;
				
				endif;
										
			endforeach;
		
		endif;

	    $header  = "Add Item";
	    
	    $body  = "<form id='accounting-".$this->params."-form'>";
	    
	    $body .= "<input type='hidden' id='id' value='".$this->data."'>";
		
			$body .= "<div class='row'>";
			
				$body .= "<div class='span3 accounting-".$this->params."-leftForm'>";
				
					$body .= "<div class='control-group'>";
					
						$body .= "<label class='control-label bold-small control-label-form' for='type'>Item Type</label><span class='help-block muted small-font'>Type for this item <i class='icon-question-sign'></i></span>";
						
						$body .= "<div class='controls accounting-".$this->params."-selectContainer'>";
						
							$body .= "<select disabled='disabled' class='accounting-".$this->params."-select accounting-".$this->params."-mainSelector' id='type'>";
								
								$body .= "<option selected='selected' value=''></option>";
								
								if (!empty($itemTyp)):
								
									foreach ($itemTyp as $key => $value):
										
										if ($data['CAP_ACC_ITE_TYP_ID'] == $value['CAP_ACC_ITE_TYP_ID']):
										
										$body .= "<option selected='selected' value='".$value['CAP_ACC_ITE_TYP_ID']."'>".ucwords(strtolower($value['CAP_ACC_ITE_TYP_NAME']))."</option>";
										
										else:
										
										$body .= "<option value='".$value['CAP_ACC_ITE_TYP_ID']."'>".ucwords(strtolower($value['CAP_ACC_ITE_TYP_NAME']))."</option>";
										
										endif;
																																			
									endforeach;
								
								endif;
							
							$body .= "</select>";
							
						$body .= "</div>";
						
					$body .= "</div>";
					
					$body .= "<div class='control-group'>";
					
						$body .= "<label class='control-label bold-small control-label-form' for='code'>Code</label><span class='help-block muted small-font'>Unique number for this item <i class='icon-question-sign'></i></span>";
						
						$body .= "<div class='controls'><input type='text' id='code' value='".$data['CAP_ACC_ITE_CODE']."'></div>";
						
					$body .= "</div>";
					
					$body .= "<div class='control-group'>";
					
						$body .= "<label class='control-label bold-small control-label-form' for='name'>Name</label>
								  <span class='help-block muted small-font'>Short title (limit 100 character) 
								  	<i class='icon-question-sign'></i>
								  </span>";
						
						$body .= "<div class='controls'><input type='text' id='name' value='".$data['CAP_ACC_ITE_NAME']."'></div>";
						
					$body .= "</div>";
					
					$body .= "<div class='control-group'>";
					
						$body .= "<label class='control-label bold-small control-label-form' for='description'>Description (optional)</label><span class='help-block muted small-font'>How this item will be used <i class='icon-question-sign'></i></span>";
						
						$body .= "<div class='controls'><input type='text' id='description' value='".$data['CAP_ACC_ITE_DESC']."'></div>";
						
					$body .= "</div>";
										
				$body .= "</div>";
						
				$body .= "<div class='span3 accounting-".$this->params."-leftForm accounting-item-notexist-subtotal'>";
												
					$body .= "<div class='control-group'>";
					
						$body .= "<label class='control-label bold-small control-label-form' for='purchase-unit-price'>Purchase Unit Price</label><span class='help-block muted small-font'>Default unit buying price <i class='icon-question-sign'></i></span>";
						
						$body .= "<div class='controls'><input type='text' id='purchase-unit-price' value='".$data['COA-PURCHASE'][0]['CAP_ACC_ITE_COA_RATE']."'></div>";
						
					$body .= "</div>";
					
					$body .= "<div class='control-group accounting-".$this->params."-bankAccount'>";
					
						$body .= "<label class='control-label bold-small control-label-form' for='account-purchase'>Purchase Account</label><span class='help-block muted small-font'>Default account for puchase <i class='icon-question-sign'></i></span>";
						
						$body .= "<div class='controls accounting-".$this->params."-selectContainer'>";
												
						$body .= "<select class='accounting-".$this->params."-select' id='account-purchase'>".$optionp."</select>";
						
						$body .= "</div>";
						
					$body .= "</div>";
					
					$body .= "<div class='control-group accounting-".$this->params."-bankAccount accounting-tax-notexist'>";
					
						$body .= "<label class='control-label bold-small control-label-form' for='purchase-tax'>Purchase Tax Rate</label><span class='help-block muted small-font'>Bank account number <i class='icon-question-sign'></i></span>";
						
						$body .= "<div class='controls accounting-".$this->params."-selectContainer'>";
						
						$body .= "<select class='accounting-".$this->params."-select' id='purchase-tax'>".$optiont."</select>";
						
						$body .= "</div>";
									
					$body .= "</div>";
					
				$body .= "<div class='control-group accounting-".$this->params."-bankAccount'>";
					
						$body .= "<label class='control-label bold-small control-label-form' for='unit-measurement'>Unit Measurement</label><span class='help-block muted small-font'>Default unit measurement (ex. Kg) <i class='icon-question-sign'></i></span>";
						
												
						$body .= "<div class='controls'><input type='text' id='unit-measurement' value='".$data['CAP_ACC_ITE_MEASURE']."'></div>";
						
					$body .= "</div>";
																								
				$body .= "</div>";
												
				
			$body .= "<div class='span3 accounting-item-notexist-subtotal'>";
				
					$body .= "<div class='control-group'>";
					
						$body .= "<label class='control-label bold-small control-label-form' for='sales-unit-price'>Sales Unit Price</label><span class='help-block muted small-font'>Default unit selling price <i class='icon-question-sign'></i></span>";
						
						$body .= "<div class='controls'><input type='text' id='sales-unit-price' value='".$data['COA-SELLING'][0]['CAP_ACC_ITE_COA_RATE']."'></div>";
						
					$body .= "</div>";
					
					$body .= "<div class='control-group accounting-".$this->params."-bankAccount'>";
					
						$body .= "<label class='control-label bold-small control-label-form' for='account-sales'>Sales Account</label><span class='help-block muted small-font'>Default account for sales <i class='icon-question-sign'></i></span>";
						
						$body .= "<div class='controls accounting-".$this->params."-selectContainer'>";
												
						$body .= "<select class='accounting-".$this->params."-select' id='account-sales'>".$option."</select>";
						
						$body .= "</div>";
						
					$body .= "</div>";
					
					$body .= "<div class='control-group accounting-".$this->params."-bankAccount accounting-tax-notexist'>";
					
						$body .= "<label class='control-label bold-small control-label-form' for='sales-tax'>Sales Tax Rate</label><span class='help-block muted small-font'>Bank account number <i class='icon-question-sign'></i></span>";
						
						$body .= "<div class='controls accounting-".$this->params."-selectContainer'>";
												
						$body .= "<select class='accounting-".$this->params."-select' id='sales-tax'>".$optiony."</select>";
						
						$body .= "</div>";
						
					$body .= "</div>";
					
					$body .= "<div class='control-group accounting-".$this->params."-bankAccount accounting-other-charge-notexist'>";
					
						$body .= "<label class='control-label bold-small control-label-form' for='cogs'>COGS</label><span class='help-block muted small-font'>Cost of Goods Sold <i class='icon-question-sign'></i></span>";
						
						$body .= "<div class='controls accounting-".$this->params."-selectContainer'>";
												
						$body .= "<select class='accounting-".$this->params."-select accounting-".$this->params."-mainSelector' id='cogs'>".$optionc."</select>";
						
						$body .= "</div>";
						
					$body .= "</div>";
					
					$body .= "<div class='control-group accounting-".$this->params."-bankAccount accounting-other-charge-exist'>";	
					
						$body .= "<label class='control-label bold-small control-label-form' for='percentage'>Option</label><span class='help-block muted small-font'>Item option rate <i class='icon-question-sign'></i></span>";					
						
						if ($data['COA-SELLING'][0]['CAP_ACC_ITE_COA_PERCENT'] == 1):
						
						$body .= "<div class='controls'><input checked='checked' type='checkbox' id='percentage' value='1'> This item has percentage rate</div>";
						
						else:
												
						$body .= "<div class='controls'><input type='checkbox' id='percentage' value='1'> This item has percentage rate</div>";
						
						endif;
						
					$body .= "</div>";
									
				$body .= "</div>";
			
			$body .= "</div>";	
			
			$body .= "</div>";
			
		$body .= "</form>";
		
		$footer .= "<button class='btn btn-small' data-dismiss='modal' aria-hidden='true'>Cancel</button>";
			    
		$footer .= "<button id='accounting-".$this->params."-updateItem' class='btn btn-info btn-small' data-loading-text='Loading...'>Update item</button>";
		
		echo json_encode(array("response" => "success", "token" => $_SESSION['xss'], "viewHeader" => $header, "viewBody" => $body, "viewFooter" => $footer, "debug" => $data));
					    
    }
    
    public function form_deleteItem() {
	    	    
	    $header  = "Delete Account";
	    			
		$body   .= "<div class='alert alert-error'>Warning!!! This action is irreversible. All related transaction will also be deleted.</div>";
		
		$body   .= "<div class='deleteAccountWarning'></div>";
		
		$footer .= "<button class='btn btn-small' data-dismiss='modal' aria-hidden='true'>Cancel</button>";
		
		$footer .= "<button id='accounting-".$this->params."-deleteItem' class='btn btn-danger btn-small'>Delete account</button>";
		
		echo json_encode(array("response" => "success", "token" => $_SESSION['xss'], "viewHeader" => $header, "viewBody" => $body, "viewFooter" => $footer));
					    
    }
    
    public function form_invoice_controller() {
	    
	    $view   = $this->optionGear;
	    
	    $actio  = explode('|||',$_GET['actio']);
	    
	    $key    = $_GET['emblem'];
	    
	    $words  = $actio[0];
	    
	    $rjand  = encryption::urlHashDecodingRinjndael($key,$actio[2]);
	    
			if (!is_numeric($rjand)):

			//header('Location: http://www.asacreative.com');
								
			endif;
	    
		if ($words == 'new'): 
		
			echo $this->form_createInvoice(); 
		
		elseif ($words == 'view'):
			
			$this->data = $rjand;
						
			echo $this->form_viewInvoice();
			
		elseif ($words == 'edit'):
		
			$this->data = $rjand;
		
			echo $this->form_editInvoice();
		
		endif;
	
    }
    
    public function form_createInvoice() {
	    
	    $item   = json_decode($this->getItem(), true);
	    
	    $coa    = json_decode($this->getCoa(), true);
	    
	    $acccur = json_decode($this->getCurrencyAccount(),true);
	    
	    $user 	= unserialize($_SESSION['user']);
	    
    	$id		= $user->getID();

    	$cus	= json_decode($this->getContactCustomer($id),true);
	    	    
	    //print_r($cus);
	    
	    	if (!empty($cus)):
	    	
	    		foreach ($cus as $key => $value):
	    		
	    		$customer .= "<option value='".$value['CAP_ACC_CON_ID']."'>".ucwords(strtolower($value['CAP_ACC_CON_CONTACT']))."</option>";
	    		
	    		endforeach;
	    	
	    	endif;
	    
	    	if (!empty($acccur)):
	    	
	    		foreach ($acccur as $key => $value):
	    		
	    		$currency .= "<option value='".$value['CAP_ACC_USE_ACC_CUR_ID']."'>".$value['CAP_ACC_CUR_NAME']." ".$value['CAP_ACC_CUR_PREFIX']."</option>";
	    		
	    		endforeach;
	    	
	    	endif;
	    
	    	if (!empty($item)):
	    	
	    		foreach ($item as $key => $value):
	    		
	    			if ($value['CAP_ACC_ITE_TYP_NAME'] == 'TAX'):
	    			
	    			$itemTax [] = [
	    			
	    			"id"    => $value['CAP_ACC_ITE_ID'],
	    			"label" => $value['CAP_ACC_ITE_NAME'],
	    			"rate"  => $value['COA-SELLING'][0]['CAP_ACC_ITE_COA_RATE']
	    			
	    			];
	    				    			
	    			endif;
	    			
	    			if ($value['CAP_ACC_ITE_TYP_NAME'] == 'DISCOUNT'):
	    			
	    			$itemDisc [] = [
	    			
	    			"id"    => $value['CAP_ACC_ITE_ID'],
	    			"label" => $value['CAP_ACC_ITE_NAME'],
	    			"rate"  => $value['COA-SELLING'][0]['CAP_ACC_ITE_COA_RATE']
	    			
	    			];
	    			
	    			endif;
	    		
	    		endforeach;
	    
		    	foreach ($item as $key => $value):
		    	
		    	unset($taxInfo);
		    	
		    	$phpItem .= "<option value='".$value['CAP_ACC_ITE_ID']."'>".$value['CAP_ACC_ITE_NAME']."</option>";
		    	
		    	if (!empty($value['COA-SELLING'][0]['FK_CAP_ACC_ITE_TAX_ID'])):
		    	
		    	$i = 0;
		    	
		    		foreach ($itemTax as $taxKey => $taxValue):

		    			if ($value['COA-SELLING'][0]['FK_CAP_ACC_ITE_TAX_ID'] == $taxValue['id']): 
		    			
		    			$taxInfo = $itemTax[$i]; break; 
		    			
		    			endif;
		    		
		    		$i++;
		    		
		    		endforeach;

		    	endif;
		    	
		    	$autoCompleteItem [] = [
		    	
		    	"id"		=> $value['CAP_ACC_ITE_ID'],
		    	"label" 	=> $value['CAP_ACC_ITE_NAME'],
		    	"desc" 		=> $value['CAP_ACC_ITE_DESC'],
		    	"price" 	=> $value['COA-SELLING'][0]['CAP_ACC_ITE_COA_RATE'],
		    	"category" 	=> ucwords(strtolower($value['CAP_ACC_ITE_TYP_NAME'])),
		    	"account"	=> ucwords(strtolower($value['COA-SELLING'][0]['CAP_ACC_COA_NAME'])),
		    	"accountid"	=> $value['COA-SELLING'][0]['FK_CAP_ACC_COA_ID'],
		    	"taxid"		=> $taxInfo['id'],
		    	"taxname"	=> $taxInfo['label'],
		    	"taxrate"	=> $taxInfo['rate']
		    	
		    	];
		    			    	
		    	endforeach;
	    	
	    	endif;
	    		    	
	    	if (!empty($coa)):
	    	
	    		foreach ($coa as $key => $value):
	    		
	    		$phpCoa .= "<option value='".$value['CAP_ACC_ITE_ID']."'>".$value['CAP_ACC_ITE_NAME']."</option>";
	    			
	    		$autoCompleteCoa [] = [
		    	
		    	"id"		=> $value['CAP_ACC_COA_ID'],
		    	"label" 	=> ucwords(strtolower($value['CAP_ACC_COA_NAME'])),
		    	"desc" 		=> $value['CAP_ACC_COA_DESC'],
		    	"category" 	=> ucwords(strtolower($value['CAP_ACC_COA_TYP_NAME']))
		    	
		    	];
		    	
			    	if ($value['CAP_ACC_COA_TYP_NAME'] == 'ACCOUNT RECEIVABLE'):

			    	$accReceivable .= "<option value='".$value['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value['CAP_ACC_COA_NAME']))."</option>";

			    	endif;
	    		
	    		endforeach;
	    	
	    	endif;

	    $view .= "<script type='text/javascript'>";
	    	    	
	    	$view .= "function accountingInvoiceItem() {";
	    	
	    		$view .= "return ".json_encode($autoCompleteItem);
	    	
	    	$view .= "}";
	    		    	
	    	$view .= "function accountingInvoiceCoa() {";
	    	
	    		$view .= "return ".json_encode($autoCompleteCoa);
	    	
	    	$view .= "}";
	    	
	    	$view .= "function accountingInvoiceTax() {";
	    	
	    		$view .= "return ".json_encode($itemTax);
	    	
	    	$view .= "}";
	    	
	    	$view .= "function accountingInvoiceDiscount() {";
	    	
	    		$view .= "return ".json_encode($itemDisc);
	    	
	    	$view .= "}";
	    
	    $view .= "</script>";
	    
	    //$view .= $this->optionGear;
	    
	    $view .= "<div class='row accounting-".$this->params."-container'>";
	    
	    $view .= "<div class='span12'>";
	    
	    	$view .= "<h2 class=''>New Invoice</h2>";
	    
	    $view .= "</div>";
	    
	    	$view .= "<div class='span12 accounting-".$this->params."-formContainer'>";
	    		
	    	$view .= "<input id='capsuleCSRFToken' type='hidden' value='".$_SESSION['xss']."'>";
	    		
	    		$view .= "<form id='accounting-".$this->params."-form' data-form-type='invoice'>";
	    			
	    			$view .= "<div class='accounting-".$this->params."-form-transaction'>";
	    			
	    			$view .= "<div class='accounting-".$this->params."-form-top'>";
	    		
	    			$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='name'>To</label></span>";
						
						$view .= "<div class='controls'><select id='customer-id' class='span2 accounting-chosen'><option></option>$customer</select></div>";
																	
					$view .= "</div>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='account'>Account</label></span>";
						
						$view .= "<div class='controls'><select id='account' class='span2 accounting-chosen'>".$accReceivable."</select></div>";
																														
					$view .= "</div>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='date'>Date</label></span>";
						
						$view .= "<div class='controls'><input class='accounting-date-".md5(rand(0,100))." input-medium' type='text' id='date' value='".$data['CAP_ACC_ITE_NAME']."'></div>";
						
					$view .= "</div>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='due-date'>Due Date</label></span>";
						
						$view .= "<div class='controls'><input class='accounting-date-".md5(rand(0,100))." input-medium' type='text' id='due-date' value='".$data['CAP_ACC_ITE_NAME']."'></div>";
						
					$view .= "</div>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='number'>Invoice #</label></span>";
						
						$view .= "<div class='controls'><input class='input-large' type='text' id='number' value='".$item['CAP_ACC_ITE_NAME']."'></div>";
						
					$view .= "</div>";
																				
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
					
					$view .= "<hr class='accounting-create-hr'>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='currency'>Currency</label></span>";
						
						$view .= "<div class='controls'><select id='currency' class='span2 accounting-chosen'>".$currency."</select></div>";
						
					$view .= "</div>";
					
					$view .= "<div class='default-control-right'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='globaltax'>Tax</label></span>";
						
						$view .= "<div class='controls'><select id='globaltax' class='span2 accounting-chosen'><option value='exclude'>Tax Exclude</option><option value='include'>Tax Include</option><option value='nontaxable'>Non Taxable</option></select></div>";
						
					$view .= "</div>";
					
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
					
					$view .= "<br>";
					
					$view .= "<div class='span12 accounting-".$this->params."-form-table'>";
										
					$view .= "<table class='table accounting-transaction-table table-small-font'>";
					
						$view .= "<thead class='table-header-blue-transaction table-header-bold'>";
						
							$view .= "<tr>";
							
							    $view .= "<td class='table-valign-middle table-align-middle'></td>";
							    
								$view .= "<td class='table-valign-middle table-align-middle'>Item</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Description</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Qty</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Unit Price</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Disc%</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Account</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Tax</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Amount</td>";
								
								$view .= "<td></td>";
							
							$view .= "</tr>";
						
						$view .= "</thead>";
						
						$view .= "<tbody>";
						
						$i = 0;
						
						while ($i != 3):
						
						$i++;
						
							$view .= "<tr class='accounting-table-tr-type-one accounting-invoice-item-row'>";
							
							    $view .= "<td class='accounting-table-td-type-three'><i class='icon-align-justify'></i><input id='id' class='accounting-item-id' type='hidden' value=''><input id='accounting-item-category' class='accounting-item-category' type='hidden' value=''></td>";
							    
							    $view .= "<td class='accounting-table-td-type-one accounting-item'><input class='accounting-table-input-type-three' type='text' id='item' value=''></td>";
							    								
								$view .= "<td class='accounting-table-td-type-one accounting-description'><input class='accounting-table-input-type-two' type='text' id='description' value=''></td>";
								
								$view .= "<td class='accounting-table-td-type-one accounting-qty'><input class='accounting-table-input-type-one input-align-right' type='text' id='qty' value=''></td>";
								
								$view .= "<td class='accounting-table-td-type-one accounting-price'><input class='accounting-table-input-type-one input-align-right' type='text' id='price' value=''></td>";
								
								$view .= "<td class='accounting-table-td-type-one accounting-discount'><input class='accounting-table-input-type-one input-align-right accounting-discount-display' type='text' value=''><input class='accounting-discount-id' id='discount-id' type='hidden' value=''><input class='accounting-discount-value' type='hidden' id='discount' value=''></td>";
								
								$view .= "<td class='accounting-table-td-type-one accounting-account'><input class='accounting-table-input-type-one accounting-account-display' type='text' value=''><input class='accounting-account-value' type='hidden' id='account' value=''></td>";
								
								$view .= "<td class='accounting-table-td-type-one accounting-tax'><input class='accounting-table-input-type-one input-align-right accounting-tax-display' type='text' value=''><input class='accounting-tax-id' id='tax-id' type='hidden' value=''><input class='accounting-tax-value' type='hidden' id='tax' value=''></td>";
								
								$view .= "<td class='accounting-table-td-type-five accounting-amount'><input disabled='disabled' class='accounting-table-input-type-four input-align-right' type='text' id='amount' value=''></td>";
								
								$view .= "<td class='accounting-table-td-type-last '><input type='hidden' id='position' value=''><i class='icon-remove-circle accounting-table-del-line'></i></td>";
							$view .= "</tr>";
						
						endwhile;
						
						$view .= "</tbody>";
						
						$view .= "<tfoot>";
						
							$view .= "<tr class='accounting-table-tr-type-two'><td colspan='8' class='table-valign-middle table-align-right'><span class='accounting-foot-discount'></span> Sub Total</td><td class='table-align-right accounting-foot-subtotal'>0.00</td><td></td></tr>";
														
							$view .= "<tr class='accounting-table-tr-type-two'><td colspan='8' class='table-valign-middle table-align-right'>Vat</td><td class='table-align-right accounting-foot-tax'>0.00</td><td></td></tr>";
							
							$view .= "<tr class='accounting-table-tr-type-two'><td colspan='8' class='table-valign-middle table-align-right'>Grand Total</td><td class='table-align-right accounting-foot-total'>0.00</td><td></td></tr>";
																				
						$view .= "</tfoot>";
						
					$view .= "</table>";
					
					$view .= "<a class='pull-left btn btn-mini accounting-table-add-newline'><i class='icon-circle-arrow-right'></i> Add a new line</a>";
					
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
				
				$view .= "<br>";
				
				$view .= "<div class='accounting-action-final'>";
				
				$view .= "<div class='accounting-action-final-container'>";
				
					$view .= "<div class='pull-right default-control-form-final'>";
				
						$view .= "<button type='button' id='accounting-invoice-submit-new' class='btn btn-small btn-success' data-loading-text='Please Wait...'><i class='icon-ok icon-white'></i> Save & Back</button>";
						
					$view .= "</div>";
					
					$view .= "<div class='pull-right default-control-form-final'>";
				
						$view .= "<button class='btn btn-small btn-info'><i class='icon-circle-arrow-right icon-white'></i> Save & Create New</button>";
						
					$view .= "</div>";
					
					$view .= "<div class='pull-right default-control-form-final'>";
	    		
						$view .= "<a href='".$this->url->builder(3561,'transaction')."' class='btn btn-small'><i class='icon-remove'></i> Cancel</a>";
						
					$view .= "</div>";
	    		
	    		$view .= "</div>";
	    		
	    		$view .= "</div>";
					
	    		$view .= "</form>";
	    			    			    			    		
	    	$view .= "</div>";
	    
	    $view .= "</div>";
	    
	return $view;
		    
    }
    
    public function form_viewInvoice() {

    	$misc = new misc();
	    
	    $item   = json_decode($this->getItem(), true);
	    
	    $coa    = json_decode($this->getCoa(), true);
	    
	    $acccur = json_decode($this->getCurrencyAccount(),true);
	    
	    $user 	= unserialize($_SESSION['user']);
	    
    	$id		= $user->getID();

    	$cus	= json_decode($this->getContactCustomer($id),true);
    	
    	$data   = json_decode($this->getInvoiceByID(),true);
	    	    	    	    
	    $crypt = encryption::urlHashEncodingRinjndael($_SESSION['xss'],$data['CAP_ACC_TRA_ID']);
	    
	    $view .= "<div class='row accounting-".$this->params."-container'>";
	    
	    $view .= "<div class='span12'>";
	    
	    	$view .= "<h2 class=''>View Invoice</h2>";
	    
	    $view .= "</div>";
	    
	    	$view .= "<div class='span12 accounting-".$this->params."-formViewContainer'>";
	    	
	    	$view .= "<div class='span1 btn-group pull-left'>";
		   
		   	  	$view .= "<a class='btn btn-info btn-small dropdown-toggle' data-toggle='dropdown' href='#accounting-".$this->params."-coaAdd'><i class='icon-edit icon-white'></i> Options <span class='caret'></span></a>";
		   	  	
		   	  		$view .= "<ul class='dropdown-menu'>";
		   	  			
		   	  			$view .= "<li><a href='#'><i class='icon-ban-circle'></i> Void</a></li>";
		   	  			
		   	  			$view .= "<li><a href='".$this->url->builder(3801,'invoice')."?actio=edit|||invoice|||".$crypt."&emblem=".$_SESSION['xss']."'><i class='icon-pencil'></i> Edit</a></li>";
		   	  					   	  					   	  		
		   	  		$view .= "</ul>";
									  					
		   	$view .= "</div>";
		   
		    $view .= "<div class='clearfix'></div>";
	    	
	    	$view .= "<hr>";
	    		
	    	$view .= "<input id='capsuleCSRFToken' type='hidden' value='".$_SESSION['xss']."'>";
	    		
	    		$view .= "<form id='accounting-".$this->params."-form'>";
	    			
	    			$view .= "<div class='accounting-".$this->params."-form-transaction'>";
	    			
	    			$view .= "<div class='accounting-".$this->params."-form-top'>";
	    		
	    			$view .= "<div class='span-accounting-view-header default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='name'>To</label></span>";
						
						$view .= "<div class='controls'>".ucwords(strtolower($data['CAP_ACC_CON_CONTACT']))."</div>";
																	
					$view .= "</div>";
										
					$view .= "<div class='span-accounting-view-header default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='date'>Date</label></span>";
						
						$view .= "<div class='controls'>".date("d F Y",strtotime($data['CAP_ACC_TRA_DATE']))."</div>";
						
					$view .= "</div>";
					
					$view .= "<div class='span-accounting-view-header default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='due-date'>Due Date</label></span>";
						
						$view .= "<div class='controls'>".date("d F Y",strtotime($data['CAP_ACC_TRA_DUEDATE']))."</div>";
						
					$view .= "</div>";
					
					$view .= "<div class='span-accounting-view-header default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='number'>Invoice #</label></span>";
						
						$view .= "<div class='controls'>".$data['CAP_ACC_TRA_NUMBER']."</div>";
						
					$view .= "</div>";
					
					$view .= "<div class='span-accounting-view-header default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='number'>Tax</label></span>";
						
						$view .= "<div class='controls'>".ucwords(strtolower($data['FK_CAP_ACC_TRA_GLOBALTAX']))."</div>";
						
					$view .= "</div>";
					
					$view .= "<div class='span-accounting-view-header default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='number'>Currency</label></span>";
						
						$view .= "<div class='controls'>".$data['CAP_ACC_USE_ACC_CUR_NAME']." ".ucwords(strtolower($data['CAP_ACC_CUR_PREFIX']))."</div>";
						
					$view .= "</div>";
																				
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
					
					$view .= "<hr>";
															
					$view .= "</div>";
										
					$view .= "<div class='span12 accounting-".$this->params."-form-table'>";
										
					$view .= "<table class='table accounting-transaction-table-non-sortable table-small-font'>";
					
						$view .= "<thead class='table-header-grey-transaction table-header-bold'>";
						
							$view .= "<tr>";
														    
								$view .= "<td class='table-valign-middle table-align-middle'>Item</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Description</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Qty</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Unit Price</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Disc%</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Account</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Tax</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Amount</td>";
															
							$view .= "</tr>";
						
						$view .= "</thead>";
						
						$view .= "<tbody>";
						
						$c = (int)$data['CAP_ACC_TRA_ROW'];
						
						$i = 0;
						
						$y = 0;

						if (!empty($data['ITEM-TRANSACTION'])):
						
							while ($i != $c):
														
							$i++;

								if ($i == $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_POSITION']):
																
								unset($name); 
								unset($desc); 
								unset($coa); 
								unset($qty);
								unset($cat);
								unset($rate); 
								unset($amou);
								unset($disc);
								unset($discR);
								unset($discN); 
								unset($tax);
								unset($taxR);
								unset($taxA);
								
								$name  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_ITE_NAME'];
								$desc  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_DESC'];
								$coa   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_COA_NAME'];
								$qty   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_QTY'];
								$cat   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_ITE_TYP_NAME'];
								$rate  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_RATE'];
								$amou  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_AMOUNT'];

								$disc  = $data['ITEM-TRANSACTION'][$y]['DISCOUNT'][0]['CAP_ACC_ITE_NAME'];
								$discR = $data['ITEM-TRANSACTION'][$y]['DISCOUNT'][0]['CAP_ACC_TRA_ITE_RATE'];
								$discN = $data['ITEM-TRANSACTION'][$y]['DISCOUNT'][0]['CAP_ACC_TRA_ITE_AMOUNT'];
								
								$tax   = $data['ITEM-TRANSACTION'][$y]['TAX'][0]['CAP_ACC_ITE_NAME'];
								$taxR  = $data['ITEM-TRANSACTION'][$y]['TAX'][0]['CAP_ACC_TRA_ITE_RATE'];
								$taxA  = $data['ITEM-TRANSACTION'][$y]['TAX'][0]['CAP_ACC_TRA_ITE_AMOUNT'];
								
								$name  = (!empty($name)) ? $name : '&nbsp;' ;
								$desc  = (!empty($desc)) ? ucwords(strtolower($desc)) : '&nbsp;' ;
								$coa   = (!empty($coa))  ? ucwords(strtolower($coa)) : '&nbsp;' ;
								$qty   = (!empty($qty))  ? number_format($qty,$this->getDecimalLength($qty)) : null;	
								//$qty   = (!empty($qty))  ? number_format($qty,4) : null;		
																
								$realAmount  = ($rate + (($rate / 100) * $taxR)) * $qty;
								
								$realDiscount = ($realAmount / 100) * $discR;
																
								$realAmount  = $realAmount - $realDiscount;
																
									if (strtoupper($cat) != 'SUB TOTAL'):
																											
									$rate = round($rate,4,PHP_ROUND_HALF_UP);
									
									$rate = (!empty($rate)) ? round($rate,4) : null;
									
									else:
									
									$rate = null;
									
									endif;
								//$discN 	= self::noRoundingDecimal($discN,4); 															
								$discN  = (!empty($discN)) ? round($discN,3,PHP_ROUND_HALF_UP) : 0;
								$discL += (!empty($discN)) ? $discN : 0;
								
								$disc   = (!empty($disc))  ? $disc." (".$discR."%)" : null;
								$tax    = (!empty($tax))   ? $tax." (".$taxR."%)" : null;
								$amou   = (!empty($amou))  ? bcsub($amou,$discN,4) : null;
								//echo $discL.'<br>';round(round($moneyT,4),2,PHP_ROUND_HALF_EVEN)
								$money = round(bcdiv(bcmul($amou,bcadd(100,$taxR,4),4),100,4),4,PHP_ROUND_HALF_EVEN);

								//$money = $money/(100+$taxR)*100;
								$money =round($money/(100+$taxR)*100,4,PHP_ROUND_HALF_EVEN);
								
								list ($fund,$fundd) = explode('.',$money);
						
								$fund   = (!empty($fund))  ?  $fund :  '0';
								$fundd  = (!empty($fundd)) ?  substr($fundd,0,3) :  '00';
								//$funds  = (!empty($fund)) ?  $fund.'.'. substr($fundd,0,2) :  0.00;
								$funds  = (!empty($fund)) ?  $money :  0.00;

								$funds  = round($funds,2,PHP_ROUND_HALF_ODD);
								
								$moneyT += $money;

									if (strtoupper($data['ITEM-TRANSACTION'][$y]['CAP_ACC_ITE_TYP_NAME']) != 'SUB TOTAL'):

									$discT     = (!empty($discN)) ? bcadd($discN,$discT,3) 	: $discT;
									$taxT      = (!empty($taxA))  ? bcadd($taxT,$taxA,3) 		: $taxT;
									$total     = (!empty($amou))  ? bcadd($amou,$total,3) 		: $total;
									$totalSub  = (!empty($amou))  ? bcadd($amou,$totalSub,3) 	: $totalSub;
									$totalTax  = (!empty($taxA))  ? bcadd($taxA,$totalTax,3)	: $totalTax;

									elseif (strtoupper($cat) == 'SUB TOTAL'):

									$funds     = round($totalSub,2,PHP_ROUND_HALF_ODD);
									$totalSub  = 0;
									$totalTax  = 0;
									
									endif;

									$view .= "<tr class='accounting-table-tr-type-one'>";
																	    
									    $view .= "<td class='accounting-table-td-type-six table-valign-middle'>".$name."</td>";
									    								
										$view .= "<td class='accounting-table-td-type-six table-valign-middle'>".$desc."</td>";
										
										$view .= "<td class='accounting-table-td-type-six table-valign-middle table-align-right'>".$qty."</td>";
										
										$view .= "<td class='accounting-table-td-type-six table-valign-middle table-align-right'>".$rate."</td>";
																												
										$view .= "<td class='accounting-table-td-type-six table-valign-middle table-align-middle'>".$disc."</td>";
										
										$view .= "<td class='accounting-table-td-type-six table-valign-middle'>".$coa."</td>";
										
										$view .= "<td class='accounting-table-td-type-six table-valign-middle table-align-middle'>".$tax."</td>";
										
										$view .= "<td class='accounting-table-td-type-six table-valign-middle table-align-right'>".number_format($funds,2)."</td>";
										
									$view .= "</tr>";
									
								$y++;
								
								else:
								
									$view .= "<tr class='accounting-table-tr-type-one'>";
																	    
									    $view .= "<td class='accounting-table-td-type-six table-valign-middle'>&nbsp;</td>";
									    								
										$view .= "<td class='accounting-table-td-type-six table-valign-middle'></td>";
										
										$view .= "<td class='accounting-table-td-type-six table-valign-middle table-align-right'></td>";
										
										$view .= "<td class='accounting-table-td-type-six table-valign-middle table-align-right'></td>";
										
										$view .= "<td class='accounting-table-td-type-six table-valign-middle table-align-middle'></td>";
										
										$view .= "<td class='accounting-table-td-type-six table-valign-middle'></td>";
										
										$view .= "<td class='accounting-table-td-type-six table-valign-middle table-align-middle'></td>";
										
										$view .= "<td class='accounting-table-td-type-six table-valign-middle table-align-right'></td>";
										
									$view .= "</tr>";
								
								endif;
							
							endwhile;
						
						endif;
						
						$grandTotal = number_format(round(bcadd($moneyT,$taxT,3),3,PHP_ROUND_HALF_EVEN),2);
						
						$grandSubTotal = (!empty($moneyT)) ?  number_format($moneyT,2) :  number_format($total,2);
						
						//list ($fund,$fundd) = explode('.',$taxT);
						
						//$fund   = (!empty($fund))  ?  $fund :  '0';
						//$fundd  = (!empty($fundd)) ?  substr($fundd,0,2) :  '00';
						//$taxT  = (!empty($fund)) ?  number_format($fund).'.'. substr($fundd,0,2) :  0.00;
																		
						$view .= "</tbody>";
						
						$view .= "<tfoot>";

							if (!empty($discL)):  
							
							$view .= "<tr class='accounting-table-tr-type-six'><td colspan='7' class='table-valign-middle table-align-right'><span class='accounting-foot-discount'>(include discount ". number_format($discL,2) .") </span> Sub Total</td><td class='table-align-right accounting-foot-subtotal'>".$grandSubTotal."</td></tr>";
							
							else:
							
							$view .= "<tr class='accounting-table-tr-type-six'><td colspan='7' class='table-valign-middle table-align-right'><span class='accounting-foot-discount'></span> Sub Total</td><td class='table-align-right accounting-foot-subtotal'>".$grandSubTotal."</td></tr>";
							
							endif;
							
					
														
							$view .= "<tr class='accounting-table-tr-type-six'><td colspan='7' class='table-valign-middle table-align-right'>Vat</td><td class='table-align-right accounting-foot-tax'>".number_format($taxT,2)."</td></tr>";
							
							$view .= "<tr class='accounting-table-tr-type-six'><td colspan='7' class='table-valign-middle table-align-right'>Grand Total</td><td class='table-align-right accounting-foot-total'>".$grandTotal."</td></tr>";
																				
						$view .= "</tfoot>";
						
					$view .= "</table>";
										
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
				
				$view .= "<br>";

	    		$view .= "</form>";
	    			    			    			    		
	    	$view .= "</div>";
	    
	    $view .= "</div>";
	    
	return $view;
		    
    }
    
    public function form_editInvoice() {
	    
	    $item   = json_decode($this->getItem(), true);
	    
	    $coa    = json_decode($this->getCoa(), true);
	    
	    $acccur = json_decode($this->getCurrencyAccount(),true);
	    
	    $user 	= unserialize($_SESSION['user']);
	    
    	$id		= $user->getID();

    	$cus	= json_decode($this->getContactCustomer($id),true);
    	
    	$data   = json_decode($this->getInvoiceByID(),true);

	    //print_r($data);
	    	    	    
	    if (!empty($cus)):
	    	
    		foreach ($cus as $key => $value):
    		
    		$selected  = ($data['CAP_ACC_CON_ID'] == $value['CAP_ACC_CON_ID']) ? "selected='selected'" : null;
    		
    		$customer .= "<option $selected value='".$value['CAP_ACC_CON_ID']."'>".ucwords(strtolower($value['CAP_ACC_CON_CONTACT']))."</option>";
    		
    		endforeach;
	    	
	   endif;
	    
    	if (!empty($acccur)):
    	
    		foreach ($acccur as $key => $value):
    		
    		$selected  = ($data['FK_CAP_ACC_TRA_CURRENCY'] == $value['CAP_ACC_USE_ACC_CUR_ID']) ? "selected='selected'" : null;
    		
    		$currency .= "<option $selected value='".$value['CAP_ACC_USE_ACC_CUR_ID']."'>".$value['CAP_ACC_CUR_NAME']." ".$value['CAP_ACC_CUR_PREFIX']."</option>";
    		
    		endforeach;
    	
    	endif;
	    
	    	if (!empty($item)):
	    	
	    		foreach ($item as $key => $value):
	    		
	    			if ($value['CAP_ACC_ITE_TYP_NAME'] == 'TAX'):
	    			
	    			$itemTax [] = [
	    			
	    			"id"    => $value['CAP_ACC_ITE_ID'],
	    			"label" => $value['CAP_ACC_ITE_NAME'],
	    			"rate"  => $value['COA-SELLING'][0]['CAP_ACC_ITE_COA_RATE']
	    			
	    			];
	    				    			
	    			endif;
	    			
	    			if ($value['CAP_ACC_ITE_TYP_NAME'] == 'DISCOUNT'):
	    			
	    			$itemDisc [] = [
	    			
	    			"id"    => $value['CAP_ACC_ITE_ID'],
	    			"label" => $value['CAP_ACC_ITE_NAME'],
	    			"rate"  => $value['COA-SELLING'][0]['CAP_ACC_ITE_COA_RATE']
	    			
	    			];
	    			
	    			endif;
	    		
	    		endforeach;
	    
		    	foreach ($item as $key => $value):
		    	
		    	unset($taxInfo);
		    	
		    	$phpItem .= "<option value='".$value['CAP_ACC_ITE_ID']."'>".$value['CAP_ACC_ITE_NAME']."</option>";
		    	
		    	if (!empty($value['COA-SELLING'][0]['FK_CAP_ACC_ITE_TAX_ID'])):
		    	
		    	$i = 0;
		    	
		    		foreach ($itemTax as $taxKey => $taxValue):

		    			if ($value['COA-SELLING'][0]['FK_CAP_ACC_ITE_TAX_ID'] == $taxValue['id']): 
		    			
		    			$taxInfo = $itemTax[$i]; break; 
		    			
		    			endif;
		    		
		    		$i++;
		    		
		    		endforeach;

		    	endif;
		    	
		    	$autoCompleteItem [] = [
		    	
		    	"id"		=> $value['CAP_ACC_ITE_ID'],
		    	"label" 	=> $value['CAP_ACC_ITE_NAME'],
		    	"desc" 		=> $value['CAP_ACC_ITE_DESC'],
		    	"price" 	=> $value['COA-SELLING'][0]['CAP_ACC_ITE_COA_RATE'],
		    	"category" 	=> ucwords(strtolower($value['CAP_ACC_ITE_TYP_NAME'])),
		    	"account"	=> ucwords(strtolower($value['COA-SELLING'][0]['CAP_ACC_COA_NAME'])),
		    	"accountid"	=> $value['COA-SELLING'][0]['FK_CAP_ACC_COA_ID'],
		    	"taxid"		=> $taxInfo['id'],
		    	"taxname"	=> $taxInfo['label'],
		    	"taxrate"	=> $taxInfo['rate']
		    	
		    	];
		    			    	
		    	endforeach;
	    	
	    	endif;
	    		    	
	    	if (!empty($coa)):
	    	
	    		foreach ($coa as $key => $value):
	    		
	    		$phpCoa .= "<option value='".$value['CAP_ACC_ITE_ID']."'>".$value['CAP_ACC_ITE_NAME']."</option>";
	    			
	    		$autoCompleteCoa [] = [
		    	
		    	"id"		=> $value['CAP_ACC_COA_ID'],
		    	"label" 	=> ucwords(strtolower($value['CAP_ACC_COA_NAME'])),
		    	"desc" 		=> $value['CAP_ACC_COA_DESC'],
		    	"category" 	=> ucwords(strtolower($value['CAP_ACC_COA_TYP_NAME']))
		    	
		    	];
		    	
			    	if ($value['CAP_ACC_COA_TYP_NAME'] == 'ACCOUNT RECEIVABLE'):

			    	$accReceivable .= "<option value='".$value['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value['CAP_ACC_COA_NAME']))."</option>";

			    	endif;
	    		
	    		endforeach;
	    	
	    	endif;

	    $view .= "<script type='text/javascript'>";
	    	    	
	    	$view .= "function accountingInvoiceItem() {";
	    	
	    		$view .= "return ".json_encode($autoCompleteItem);
	    	
	    	$view .= "}";
	    		    	
	    	$view .= "function accountingInvoiceCoa() {";
	    	
	    		$view .= "return ".json_encode($autoCompleteCoa);
	    	
	    	$view .= "}";
	    	
	    	$view .= "function accountingInvoiceTax() {";
	    	
	    		$view .= "return ".json_encode($itemTax);
	    	
	    	$view .= "}";
	    	
	    	$view .= "function accountingInvoiceDiscount() {";
	    	
	    		$view .= "return ".json_encode($itemDisc);
	    	
	    	$view .= "}";
	    
	    $view .= "</script>";
	    	    
	    $crypt = encryption::urlHashEncodingRinjndael($_SESSION['xss'],$data['CAP_ACC_TRA_ID']);
	    
	    $view .= "<div class='row accounting-".$this->params."-container'>";
	    
	    $view .= "<div class='span12'>";
	    
	    	$view .= "<h2 class=''>Edit Invoice</h2>";
	    
	    $view .= "</div>";
	    
	    	$view .= "<div class='span12 accounting-".$this->params."-formContainer'>";
	    		
	    	$view .= "<input id='capsuleCSRFToken' type='hidden' value='".$_SESSION['xss']."'>";
	    		    		
	    		$view .= "<form id='accounting-".$this->params."-form' data-form-type='invoice'>";
	    			    			
	    			$view .= "<div class='accounting-".$this->params."-form-transaction'>";
	    			
	    			$view .= "<input id='transaction-pid' type='hidden' value='".$data['CAP_ACC_TRA_ID']."'>";
	    				    			
	    			$view .= "<div class='accounting-".$this->params."-form-top'>";
	    		
	    			$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='name'>To</label></span>";
						
						$view .= "<div class='controls'><select id='customer-id' class='span2 accounting-chosen'><option></option>$customer</select></div>";
																	
					$view .= "</div>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='account'>Account</label></span>";
						
						$view .= "<div class='controls'><select id='account' class='span2 accounting-chosen'>".$accReceivable."</select></div>";
																														
					$view .= "</div>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='date'>Date</label></span>";
						
						$view .= "<div class='controls'><input class='accounting-date-".md5(rand(0,100))." input-medium' type='text' id='date' value='".date("d-m-Y",strtotime($data['CAP_ACC_TRA_DATE']))."'></div>";
						
					$view .= "</div>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='due-date'>Due Date</label></span>";
						
						$view .= "<div class='controls'><input class='accounting-date-".md5(rand(0,100))." input-medium' type='text' id='due-date' value='".date("d-m-Y",strtotime($data['CAP_ACC_TRA_DUEDATE']))."'></div>";
						
					$view .= "</div>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='number'>Invoice #</label></span>";
						
						$view .= "<div class='controls'><input class='input-large' type='text' id='number' value='".$data['CAP_ACC_TRA_NUMBER']."'></div>";
						
					$view .= "</div>";
					
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
					
					$view .= "<hr>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='currency'>Currency</label></span>";
						
						$view .= "<div class='controls'><select id='currency' class='span2 accounting-chosen'>".$currency."</select></div>";
						
					$view .= "</div>";
					
					$view .= "<div class='default-control-right'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='globaltax'>Tax</label></span>";
						
						if ($data['FK_CAP_ACC_TRA_GLOBALTAX'] == 'include'):
						
						$globalTaxOption = "<option value='exclude'>Tax Exclude</option><option selected='selected' value='include'>Tax Include</option><option value='nontaxable'>Non Taxable</option>";
						
						elseif ($data['FK_CAP_ACC_TRA_GLOBALTAX'] == 'exclude'):
						
						$globalTaxOption = "<option selected='selected' value='exclude'>Tax Exclude</option><option value='include'>Tax Include</option><option value='nontaxable'>Non Taxable</option>";
						
						else:
						
						$globalTaxOption = "<option value='exclude'>Tax Exclude</option><option value='include'>Tax Include</option><option selected='selected' value='nontaxable'>Non Taxable</option>";
						
						endif;
						
						$view .= "<div class='controls'><select id='globaltax' class='span2 accounting-chosen'>$globalTaxOption</select></div>";
						
					$view .= "</div>";
					
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
					
					$view .= "<br>";
					
					$view .= "<div class='span12 accounting-".$this->params."-form-table'>";
										
					$view .= "<table class='table accounting-transaction-table table-small-font'>";
					
						$view .= "<thead class='table-header-blue-transaction table-header-bold'>";
						
							$view .= "<tr>";
							
							    $view .= "<td class='table-valign-middle table-align-middle'></td>";
							    
								$view .= "<td class='table-valign-middle table-align-middle'>Item</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Description</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Qty</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Unit Price</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Disc%</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Account</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Tax</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Amount</td>";
								
								$view .= "<td></td>";
							
							$view .= "</tr>";
						
						$view .= "</thead>";
						
						$view .= "<tbody>";
						
						$c = (int) $data['CAP_ACC_TRA_ROW'];
						
						$i = 0;
						
						$y = 0;
						
						if (!empty($data['ITEM-TRANSACTION'])):
						
							while ($i != $c):
														
							$i++;

								if ($i == $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_POSITION']):
								
								unset($name); unset($desc); unset($coa); unset($rate); unset($qty); unset($disc); unset($tax); unset($amou);
								
								unset($name); 
								unset($desc); 
								unset($coa); 
								unset($qty);
								unset($cat);
								unset($rate); 
								unset($amou);
								
								$pid   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_ID'];
								$id    = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_ITE_ID'];
								$name  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_ITE_NAME'];
								$desc  = ucwords(strtolower($data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_DESC']));
								$coa   = ucwords(strtolower($data['ITEM-TRANSACTION'][$y]['CAP_ACC_COA_NAME']));
								$coaID = $data['ITEM-TRANSACTION'][$y]['FK_CAP_ACC_COA_ID'];
								$qty   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_QTY'];
								$cat   = ucwords(strtolower($data['ITEM-TRANSACTION'][$y]['CAP_ACC_ITE_TYP_NAME']));

								$discN 		 = (!empty($data['ITEM-TRANSACTION'][$y]['DISCOUNT'])) ? $data['ITEM-TRANSACTION'][$y]['DISCOUNT'][0]['CAP_ACC_TRA_ITE_AMOUNT'] : 0;
								$discL		+= (!empty($data['ITEM-TRANSACTION'][$y]['DISCOUNT'])) ? $data['ITEM-TRANSACTION'][$y]['DISCOUNT'][0]['CAP_ACC_TRA_ITE_AMOUNT'] : 0;
								
								$discPID     = (!empty($data['ITEM-TRANSACTION'][$y]['DISCOUNT'])) ? $data['ITEM-TRANSACTION'][$y]['DISCOUNT'][0]['CAP_ACC_TRA_ITE_ID'] : null ;
								$discID		 = (!empty($data['ITEM-TRANSACTION'][$y]['DISCOUNT'])) ? $data['ITEM-TRANSACTION'][$y]['DISCOUNT'][0]['CAP_ACC_ITE_ID'] : null;
								$discDisplay = (!empty($data['ITEM-TRANSACTION'][$y]['DISCOUNT'])) ? $data['ITEM-TRANSACTION'][$y]['DISCOUNT'][0]['CAP_ACC_ITE_NAME'] : null;
								$discValue   = (!empty($data['ITEM-TRANSACTION'][$y]['DISCOUNT'])) ? $data['ITEM-TRANSACTION'][$y]['DISCOUNT'][0]['CAP_ACC_TRA_ITE_RATE'] : null;
								
								$taxPID      = (!empty($data['ITEM-TRANSACTION'][$y]['TAX'])) ? $data['ITEM-TRANSACTION'][$y]['TAX'][0]['CAP_ACC_TRA_ITE_ID'] : null ;
								$taxID		 = (!empty($data['ITEM-TRANSACTION'][$y]['TAX'])) ? $data['ITEM-TRANSACTION'][$y]['TAX'][0]['CAP_ACC_ITE_ID'] : null;
								$taxDisplay  = (!empty($data['ITEM-TRANSACTION'][$y]['TAX'])) ? $data['ITEM-TRANSACTION'][$y]['TAX'][0]['CAP_ACC_ITE_NAME'] : null;
								$taxValue    = (!empty($data['ITEM-TRANSACTION'][$y]['TAX'])) ? $data['ITEM-TRANSACTION'][$y]['TAX'][0]['CAP_ACC_TRA_ITE_RATE'] : null;
								
									if (strtoupper($data['ITEM-TRANSACTION'][$y]['CAP_ACC_ITE_TYP_NAME']) != 'SUB TOTAL'):
										
										$rateAdd  = round(bcdiv(bcmul($data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_AMOUNT'],$taxValue,4),100,4),2);
										$rateAddT = round(bcdiv(bcmul($data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_RATE'],$taxValue,4),100,4),2);
										
										if ($data['FK_CAP_ACC_TRA_GLOBALTAX'] == 'include'):
										
										$rate    = (!empty($data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_RATE'])) ? round(bcadd($data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_RATE'],$rateAddT,3),2) : null;
										
										else:
										
										$rate    = (!empty($data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_RATE'])) ? round($data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_RATE'],2) : null;
										
										endif;
										
									endif;
									
									if ($data['FK_CAP_ACC_TRA_GLOBALTAX'] == 'include'):
								
									$amou = (!empty($data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_AMOUNT'])) ? $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_AMOUNT']+$rateAdd : null;
									
									else:
									
									$amou = (!empty($data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_AMOUNT'])) ? $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_AMOUNT'] : null;
									
									endif;
								
									if (!empty($discValue)):
									
										if ($data['FK_CAP_ACC_TRA_GLOBALTAX'] == 'include'):
																												
										$discAddS += round(($rate*$qty) * $discValue / 100,2);
										
										$amou 	   = $rate*$qty - (($rate*$qty) * $discValue / 100);
										
										else:
										
										$discAdd   = bcdiv(bcmul($amou,$discValue,4),100,4);
																			
										$discAddS += round(bcdiv(bcmul($amou,$discValue,4),100,4),3);
										$amou 	   = (!empty($amou)) ? bcsub($amou,$discAdd,4) : null;
										
										endif;
																		
									else:
									
									$amou = (!empty($data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_AMOUNT'])) ? $amou : null;
									
									endif;
																
									if (strtoupper($data['ITEM-TRANSACTION'][$y]['CAP_ACC_ITE_TYP_NAME']) != 'SUB TOTAL'):
									
									$discT 	  += (!empty($data['ITEM-TRANSACTION'][$y]['DISCOUNT'])) ? $data['ITEM-TRANSACTION'][$y]['DISCOUNT'][0]['CAP_ACC_TRA_ITE_AMOUNT'] : 0;
									$taxT     += (!empty($data['ITEM-TRANSACTION'][$y]['TAX'])) ? $data['ITEM-TRANSACTION'][$y]['TAX'][0]['CAP_ACC_TRA_ITE_AMOUNT'] : 0;
									$total    += (!empty($data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_AMOUNT'])) ? $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_AMOUNT'] : 0;
									$totalSub += (!empty($data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_AMOUNT'])) ? str_replace(',','',$amou) : 0;
									$totalTax += (!empty($data['ITEM-TRANSACTION'][$y]['TAX'])) ? $data['ITEM-TRANSACTION'][$y]['TAX'][0]['CAP_ACC_TRA_ITE_AMOUNT'] : 0;
									$totalBot += $amou;
									$totalTxx += (!empty($data['ITEM-TRANSACTION'][$y]['TAX'])) ? $data['ITEM-TRANSACTION'][$y]['TAX'][0]['CAP_ACC_TRA_ITE_AMOUNT'] : 0;
									
										if ($data['FK_CAP_ACC_TRA_GLOBALTAX'] == 'include'):
										
										$grandTotal  = $totalBot;
										
										elseif ($data['FK_CAP_ACC_TRA_GLOBALTAX'] == 'exclude'):

										$grandTotal  = $totalBot+$totalTxx;
										
										else:
										
										$grandTotal  = $totalBot;
										
										endif;
									
									elseif (strtoupper($data['ITEM-TRANSACTION'][$y]['CAP_ACC_ITE_TYP_NAME']) == 'SUB TOTAL'):
									
									$amou     = $totalSub;
									$discL    = 0;
									$totalSub = 0;
									$totalTax = 0;
									
									endif;
																												
									$view .= "<tr class='accounting-table-tr-type-one accounting-invoice-item-row'>";
									
										$view .= "<td class='accounting-table-td-type-three'><i class='icon-align-justify'></i><input id='item-pid' class='accounting-item-pid' type='hidden' value='$pid'><input id='id' class='accounting-item-id' type='hidden' value='$id'><input id='accounting-item-category' class='accounting-item-category' type='hidden' value='$cat'></td>";
										
										 $view .= "<td class='accounting-table-td-type-one accounting-item'><input class='accounting-table-input-type-three' type='text' id='item' value='$name'></td>";
										 
										 $view .= "<td class='accounting-table-td-type-one accounting-description'><input class='accounting-table-input-type-two' type='text' id='description' value='$desc'></td>";
										 
										 $view .= "<td class='accounting-table-td-type-one accounting-qty'><input class='accounting-table-input-type-one input-align-right' type='text' id='qty' value='$qty'></td>";
										 
										 $view .= "<td class='accounting-table-td-type-one accounting-price'><input class='accounting-table-input-type-one input-align-right' type='text' id='price' value='$rate'></td>";
										 
										 $view .= "<td class='accounting-table-td-type-one accounting-discount'><input class='accounting-table-input-type-one input-align-right accounting-discount-display' type='text' value='$discDisplay'><input class='accounting-discount-pid' id='discount-pid' type='hidden' value='$discPID'><input class='accounting-discount-id' id='discount-id' type='hidden' value='$discID'><input class='accounting-discount-value' type='hidden' id='discount' value='$discValue'></td>";
										 
										 $view .= "<td class='accounting-table-td-type-one accounting-account'><input class='accounting-table-input-type-one accounting-account-display' type='text' value='$coa'><input class='accounting-account-value' type='hidden' id='account' value='$coaID'></td>";
										 
										 $view .= "<td class='accounting-table-td-type-one accounting-tax'><input class='accounting-table-input-type-one input-align-right accounting-tax-display' type='text' value='$taxDisplay'><input class='accounting-tax-pid' id='tax-pid' type='hidden' value='$taxPID'><input class='accounting-tax-id' id='tax-id' type='hidden' value='$taxID'><input class='accounting-tax-value' type='hidden' id='tax' value='$taxValue'></td>";
										 
										$view .= "<td class='accounting-table-td-type-five accounting-amount'><input disabled='disabled' class='accounting-table-input-type-four input-align-right' type='text' id='amount' value='".number_format($amou,2)."'><input type='hidden' class='amount-js' value=''></td>";
										
										$view .= "<td class='accounting-table-td-type-last '><input type='hidden' id='position' value=''><i class='icon-remove-circle accounting-table-del-line accounting-table-delete-invoice'></i></td>";																																																						
									$view .= "</tr>";
									
								$y++;
								
								else:
								
										$view .= "<tr class='accounting-table-tr-type-one accounting-invoice-item-row'>";
									
										$view .= "<td class='accounting-table-td-type-three'><i class='icon-align-justify'></i><input id='id' class='accounting-item-id' type='hidden' value=''><input id='accounting-item-category' class='accounting-item-category' type='hidden' value=''></td>";
										
										 $view .= "<td class='accounting-table-td-type-one accounting-item'><input class='accounting-table-input-type-three' type='text' id='item' value=''></td>";
										 
										 $view .= "<td class='accounting-table-td-type-one accounting-description'><input class='accounting-table-input-type-two' type='text' id='description' value=''></td>";
										 
										 $view .= "<td class='accounting-table-td-type-one accounting-qty'><input class='accounting-table-input-type-one input-align-right' type='text' id='qty' value=''></td>";
										 
										 $view .= "<td class='accounting-table-td-type-one accounting-price'><input class='accounting-table-input-type-one input-align-right' type='text' id='price' value=''></td>";
										 
										 $view .= "<td class='accounting-table-td-type-one accounting-discount'><input class='accounting-table-input-type-one input-align-right accounting-discount-display' type='text' value=''><input class='accounting-discount-id' id='discount-id' type='hidden' value=''><input class='accounting-discount-value' type='hidden' id='discount' value=''></td>";
										 
										 $view .= "<td class='accounting-table-td-type-one accounting-account'><input class='accounting-table-input-type-one accounting-account-display' type='text' value=''><input class='accounting-account-value' type='hidden' id='account' value=''></td>";
										 
										 $view .= "<td class='accounting-table-td-type-one accounting-tax'><input class='accounting-table-input-type-one input-align-right accounting-tax-display' type='text' value=''><input class='accounting-tax-id' id='tax-id' type='hidden' value=''><input class='accounting-tax-value' type='hidden' id='tax' value=''></td>";
										 
										$view .= "<td class='accounting-table-td-type-five accounting-amount'><input disabled='disabled' class='accounting-table-input-type-four input-align-right' type='text' id='amount' value=''><input type='hidden' class='amount-js' value=''></td>";
										
										$view .= "<td class='accounting-table-td-type-last '><input type='hidden' id='position' value=''><i class='icon-remove-circle accounting-table-del-line accounting-table-delete-invoice'></i></td>";																																																						
									$view .= "</tr>";
								
								endif;
														
							endwhile;
						
						else:
						
						$view .= "<tr class='accounting-table-tr-type-one accounting-invoice-item-row'>";
									
										$view .= "<td class='accounting-table-td-type-three'><i class='icon-align-justify'></i><input id='id' class='accounting-item-id' type='hidden' value=''><input id='accounting-item-category' class='accounting-item-category' type='hidden' value=''></td>";
										
										 $view .= "<td class='accounting-table-td-type-one accounting-item'><input class='accounting-table-input-type-three' type='text' id='item' value=''></td>";
										 
										 $view .= "<td class='accounting-table-td-type-one accounting-description'><input class='accounting-table-input-type-two' type='text' id='description' value=''></td>";
										 
										 $view .= "<td class='accounting-table-td-type-one accounting-qty'><input class='accounting-table-input-type-one input-align-right' type='text' id='qty' value=''></td>";
										 
										 $view .= "<td class='accounting-table-td-type-one accounting-price'><input class='accounting-table-input-type-one input-align-right' type='text' id='price' value=''></td>";
										 
										 $view .= "<td class='accounting-table-td-type-one accounting-discount'><input class='accounting-table-input-type-one input-align-right accounting-discount-display' type='text' value=''><input class='accounting-discount-id' id='discount-id' type='hidden' value=''><input class='accounting-discount-value' type='hidden' id='discount' value=''></td>";
										 
										 $view .= "<td class='accounting-table-td-type-one accounting-account'><input class='accounting-table-input-type-one accounting-account-display' type='text' value=''><input class='accounting-account-value' type='hidden' id='account' value=''></td>";
										 
										 $view .= "<td class='accounting-table-td-type-one accounting-tax'><input class='accounting-table-input-type-one input-align-right accounting-tax-display' type='text' value=''><input class='accounting-tax-id' id='tax-id' type='hidden' value=''><input class='accounting-tax-value' type='hidden' id='tax' value=''></td>";
										 
										$view .= "<td class='accounting-table-td-type-five accounting-amount'><input disabled='disabled' class='accounting-table-input-type-four input-align-right' type='text' id='amount' value=''><input type='hidden' class='amount-js' value=''></td>";
										
										$view .= "<td class='accounting-table-td-type-last '><input type='hidden' id='position' value=''><i class='icon-remove-circle accounting-table-del-line accounting-table-delete-invoice'></i></td>";																																																						
									$view .= "</tr>";
						
						endif;
						
						$view .= "</tbody>";
						
						$view .= "<tfoot>";
							
							if (!empty($discAddS)):
							
							$view .= "<tr class='accounting-table-tr-type-two'><td colspan='8' class='table-valign-middle table-align-right'><span class='accounting-foot-discount'>(Include discount ".number_format($discAddS,2).")</span> Sub Total</td><td class='table-align-right accounting-foot-subtotal'>".number_format($totalBot,2)."</td><td></td></tr>";
							
							else:
							
							$view .= "<tr class='accounting-table-tr-type-two'><td colspan='8' class='table-valign-middle table-align-right'><span class='accounting-foot-discount'></span> Sub Total</td><td class='table-align-right accounting-foot-subtotal'>".number_format($totalBot,2)."</td><td></td></tr>";
							
							endif;
																					
							$view .= "<tr class='accounting-table-tr-type-two'><td colspan='8' class='table-valign-middle table-align-right'>Vat</td><td class='table-align-right accounting-foot-tax'>".number_format($totalTxx,2)."</td><td></td></tr>";
							
							$view .= "<tr class='accounting-table-tr-type-two'><td colspan='8' class='table-valign-middle table-align-right'>Grand Total</td><td class='table-align-right accounting-foot-total'>".number_format($grandTotal,2)."</td><td></td></tr>";
																				
						$view .= "</tfoot>";
						
					$view .= "</table>";
					
					$view .= "<a class='pull-left btn btn-mini accounting-table-add-newline'><i class='icon-circle-arrow-right'></i> Add a new line</a>";
					
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
				
				$view .= "<br>";
				
				$view .= "<div class='accounting-action-final'>";
				
				$view .= "<div class='accounting-action-final-container'>";
				
					$view .= "<div class='pull-right default-control-form-final'>";
				
						$view .= "<button type='button' id='accounting-invoice-submit-edit' class='btn btn-small btn-success' data-loading-text='Please Wait...'><i class='icon-ok icon-white'></i> Update & Back</button>";
						
					$view .= "</div>";
										
					$view .= "<div class='pull-right default-control-form-final'>";
	    		
						$view .= "<a href='".$this->url->builder(3561,'transaction')."' class='btn btn-small'><i class='icon-remove'></i> Cancel</a>";
						
					$view .= "</div>";
	    		
	    		$view .= "</div>";
	    		
	    		$view .= "</div>";
					
	    		$view .= "</form>";
	    			    			    			    		
	    	$view .= "</div>";
	    
	    $view .= "</div>";
	    
	return $view;
		    
    }
    
    public function form_bill_controller() {
	    
	    $view   = $this->optionGear;
	    
	    $actio  = explode('|||',$_GET['actio']);
	    
	    $key    = $_GET['emblem'];
	    
	    $words  = $actio[0];
	    
	    $rjand  = encryption::urlHashDecodingRinjndael($key,$actio[2]);
	    
			if (!is_numeric($rjand)):

			//header('Location: http://www.asacreative.com');

			endif;
	    
		if ($words == 'new'): 
		
			echo $this->form_createBill(); 
		
		elseif ($words == 'view'):
			
			$this->data = $rjand;
						
			echo $this->form_viewBill();
			
		elseif ($words == 'edit'):
		
			$this->data = $rjand;
		
			echo $this->form_editBill();
		
		endif;
	
    }
    
    public function form_createBill() {
	    
	    $item   = json_decode($this->getItem(), true);
	    
	    $coa    = json_decode($this->getCoa(), true);
	    
	    $acccur = json_decode($this->getCurrencyAccount(),true);
	    
	    $user 	= unserialize($_SESSION['user']);
	    
    	$id		= $user->getID();

    	$cus	= json_decode($this->getContactCustomer($id),true);
	    	    
	    //print_r($cus);
	    
	    	if (!empty($cus)):
	    	
	    		foreach ($cus as $key => $value):
	    		
	    		$customer .= "<option value='".$value['CAP_ACC_CON_ID']."'>".ucwords(strtolower($value['CAP_ACC_CON_CONTACT']))."</option>";
	    		
	    		endforeach;
	    	
	    	endif;
	    
	    	if (!empty($acccur)):
	    	
	    		foreach ($acccur as $key => $value):
	    		
	    		$currency .= "<option value='".$value['CAP_ACC_USE_ACC_CUR_ID']."'>".$value['CAP_ACC_CUR_NAME']." ".$value['CAP_ACC_CUR_PREFIX']."</option>";
	    		
	    		endforeach;
	    	
	    	endif;
	    
	    	if (!empty($item)):
	    	
	    		foreach ($item as $key => $value):
	    		
	    			if ($value['CAP_ACC_ITE_TYP_NAME'] == 'TAX'):
	    			
	    			$itemTax [] = [
	    			
	    			"id"    => $value['CAP_ACC_ITE_ID'],
	    			"label" => $value['CAP_ACC_ITE_NAME'],
	    			"rate"  => $value['COA-PURCHASE'][0]['CAP_ACC_ITE_COA_RATE']
	    			
	    			];
	    				    			
	    			endif;
	    			
	    			if ($value['CAP_ACC_ITE_TYP_NAME'] == 'DISCOUNT'):
	    			
	    			$itemDisc [] = [
	    			
	    			"id"    => $value['CAP_ACC_ITE_ID'],
	    			"label" => $value['CAP_ACC_ITE_NAME'],
	    			"rate"  => $value['COA-PURCHASE'][0]['CAP_ACC_ITE_COA_RATE']
	    			
	    			];
	    			
	    			endif;
	    		
	    		endforeach;
	    
		    	foreach ($item as $key => $value):
		    	
		    	unset($taxInfo);
		    	
		    	$phpItem .= "<option value='".$value['CAP_ACC_ITE_ID']."'>".$value['CAP_ACC_ITE_NAME']."</option>";
		    	
		    	if (!empty($value['COA-PURCHASE'][0]['FK_CAP_ACC_ITE_TAX_ID'])):
		    	
		    	$i = 0;
		    	
		    		foreach ($itemTax as $taxKey => $taxValue):

		    			if ($value['COA-PURCHASE'][0]['FK_CAP_ACC_ITE_TAX_ID'] == $taxValue['id']): 
		    			
		    			$taxInfo = $itemTax[$i]; break; 
		    			
		    			endif;
		    		
		    		$i++;
		    		
		    		endforeach;

		    	endif;
		    	
		    	$autoCompleteItem [] = [
		    	
		    	"id"		=> $value['CAP_ACC_ITE_ID'],
		    	"label" 	=> $value['CAP_ACC_ITE_NAME'],
		    	"desc" 		=> $value['CAP_ACC_ITE_DESC'],
		    	"price" 	=> $value['COA-PURCHASE'][0]['CAP_ACC_ITE_COA_RATE'],
		    	"category" 	=> ucwords(strtolower($value['CAP_ACC_ITE_TYP_NAME'])),
		    	"account"	=> ucwords(strtolower($value['COA-PURCHASE'][0]['CAP_ACC_COA_NAME'])),
		    	"accountid"	=> $value['COA-PURCHASE'][0]['FK_CAP_ACC_COA_ID'],
		    	"taxid"		=> $taxInfo['id'],
		    	"taxname"	=> $taxInfo['label'],
		    	"taxrate"	=> $taxInfo['rate']
		    	
		    	];
		    			    	
		    	endforeach;
	    	
	    	endif;
	    		    	
	    	if (!empty($coa)):
	    	
	    		foreach ($coa as $key => $value):
	    		
	    		$phpCoa .= "<option value='".$value['CAP_ACC_ITE_ID']."'>".$value['CAP_ACC_ITE_NAME']."</option>";
	    			
	    		$autoCompleteCoa [] = [
		    	
		    	"id"		=> $value['CAP_ACC_COA_ID'],
		    	"label" 	=> ucwords(strtolower($value['CAP_ACC_COA_NAME'])),
		    	"desc" 		=> $value['CAP_ACC_COA_DESC'],
		    	"category" 	=> ucwords(strtolower($value['CAP_ACC_COA_TYP_NAME']))
		    	
		    	];
		    	
			    	if ($value['CAP_ACC_COA_TYP_NAME'] == 'ACCOUNT PAYABLE'):

			    	$accReceivable .= "<option value='".$value['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value['CAP_ACC_COA_NAME']))."</option>";

			    	endif;
	    		
	    		endforeach;
	    	
	    	endif;

	    $view .= "<script type='text/javascript'>";
	    	    	
	    	$view .= "function accountingInvoiceItem() {";
	    	
	    		$view .= "return ".json_encode($autoCompleteItem);
	    	
	    	$view .= "}";
	    		    	
	    	$view .= "function accountingInvoiceCoa() {";
	    	
	    		$view .= "return ".json_encode($autoCompleteCoa);
	    	
	    	$view .= "}";
	    	
	    	$view .= "function accountingInvoiceTax() {";
	    	
	    		$view .= "return ".json_encode($itemTax);
	    	
	    	$view .= "}";
	    	
	    	$view .= "function accountingInvoiceDiscount() {";
	    	
	    		$view .= "return ".json_encode($itemDisc);
	    	
	    	$view .= "}";
	    
	    $view .= "</script>";
	    
	    //$view .= $this->optionGear;
	    
	    $view .= "<div class='row accounting-".$this->params."-container'>";
	    
	    $view .= "<div class='span12'>";
	    
	    	$view .= "<h2 class=''>New Bill</h2>";
	    
	    $view .= "</div>";
	    
	    	$view .= "<div class='span12 accounting-".$this->params."-formContainer'>";
	    		
	    	$view .= "<input id='capsuleCSRFToken' type='hidden' value='".$_SESSION['xss']."'>";
	    		
	    		$view .= "<form id='accounting-".$this->params."-form' data-form-type='bill'>";
	    			
	    			$view .= "<div class='accounting-".$this->params."-form-transaction'>";
	    			
	    			$view .= "<div class='accounting-".$this->params."-form-top'>";
	    		
	    			$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='name'>From</label></span>";
						
						$view .= "<div class='controls'><select id='customer-id' class='span2 accounting-chosen'><option></option>$customer</select></div>";
																	
					$view .= "</div>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='account'>Account</label></span>";
						
						$view .= "<div class='controls'><select id='account' class='span2 accounting-chosen'>".$accReceivable."</select></div>";
																														
					$view .= "</div>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='date'>Date</label></span>";
						
						$view .= "<div class='controls'><input class='accounting-date-".md5(rand(0,100))." input-medium' type='text' id='date' value='".$data['CAP_ACC_ITE_NAME']."'></div>";
						
					$view .= "</div>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='due-date'>Due Date</label></span>";
						
						$view .= "<div class='controls'><input class='accounting-date-".md5(rand(0,100))." input-medium' type='text' id='due-date' value='".$data['CAP_ACC_ITE_NAME']."'></div>";
						
					$view .= "</div>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='number'>Reference #</label></span>";
						
						$view .= "<div class='controls'><input class='input-medium' type='text' id='number' value='".$item['CAP_ACC_ITE_NAME']."'></div>";
						
					$view .= "</div>";
																				
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
					
					$view .= "<hr>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='currency'>Currency</label></span>";
						
						$view .= "<div class='controls'><select id='currency' class='span2 accounting-chosen'>".$currency."</select></div>";
						
					$view .= "</div>";
										
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
					
					$view .= "<br>";
					
					$view .= "<div class='span12 accounting-".$this->params."-form-table'>";
					
					$view .= "<div id='accounting-".$this->params."-table'>";
    	
			    	$view .= "<ul class='nav nav-tabs'>";
			    	
						$view .= "<li class='active'><a data-toggle='tab' href='#item-tab'>Item</a></li>";
						
						$view .= "<li><a data-toggle='tab' href='#expense-tab'>Expense</a></li>";
																   	  						
					$view .= "</ul>";
				
					$view .= "</div>";
				
					$view .= "<div class='tab-content'>";
				
					$view .= "<div class='tab-pane active' id='item-tab'>";
										
						$view .= "<table class='table accounting-transaction-table table-small-font'>";
						
							$view .= "<thead class='table-header-blue-transaction table-header-bold'>";
							
								$view .= "<tr>";
								
								    $view .= "<td class='table-valign-middle table-align-middle'></td>";
								    
									$view .= "<td class='table-valign-middle table-align-middle'>Item</td>";
									
									$view .= "<td class='table-valign-middle table-align-middle'>Description</td>";
									
									$view .= "<td class='table-valign-middle table-align-middle'>Qty</td>";
									
									$view .= "<td class='table-valign-middle table-align-middle'>Unit Price</td>";
																		
									$view .= "<td class='table-valign-middle table-align-middle'>Account</td>";
																		
									$view .= "<td class='table-valign-middle table-align-middle'>Amount</td>";
									
									$view .= "<td></td>";
								
								$view .= "</tr>";
							
							$view .= "</thead>";
							
							$view .= "<tbody>";
							
							$i = 0;
																							
							while ($i != 3):
							
							$i++;
							
								$view .= "<tr class='accounting-table-tr-type-one accounting-bill-item-row'>";
								
								    $view .= "<td class='accounting-table-td-type-three'><i class='icon-align-justify'></i><input id='id' class='accounting-item-id' type='hidden' value=''><input id='accounting-item-category' class='accounting-item-category' type='hidden' value=''></td>";
								    
								    $view .= "<td class='accounting-table-td-type-one accounting-item'><input class='accounting-table-input-type-three' type='text' id='item' value=''></td>";
								    								
									$view .= "<td class='accounting-table-td-type-one accounting-description'><input class='accounting-table-input-type-five' type='text' id='description' value=''></td>";
									
									$view .= "<td class='accounting-table-td-type-one accounting-qty'><input class='accounting-table-input-type-one input-align-right' type='text' id='qty' value=''></td>";
									
									$view .= "<td class='accounting-table-td-type-one accounting-price'><input class='accounting-table-input-type-one input-align-right' type='text' id='price' value=''></td>";
																		
									$view .= "<td class='accounting-table-td-type-one accounting-account'><input class='accounting-table-input-type-one accounting-account-display' type='text' value=''><input class='accounting-account-value' type='hidden' id='account' value=''></td>";
																		
									$view .= "<td class='accounting-table-td-type-five accounting-amount'><input disabled='disabled' class='accounting-table-input-type-four input-align-right' type='text' id='amount' value=''></td>";
									
									$view .= "<td class='accounting-table-td-type-last '><input type='hidden' id='position' value=''><i class='icon-remove-circle accounting-table-del-line'></i></td>";
								$view .= "</tr>";
							
							endwhile;
							
							$view .= "</tbody>";
							
							$view .= "<tfoot>";
															
								$view .= "<tr class='accounting-table-tr-type-two'><td colspan='6' class='table-valign-middle table-align-right'>Grand Total</td><td class='table-align-right accounting-foot-total'>0.00</td><td></td></tr>";
																					
							$view .= "</tfoot>";
							
						$view .= "</table>";
					
					$view .= "</div>";
					
					$view .= "<div class='tab-pane' id='expense-tab'>";
					
						$view .= "<table class='table accounting-transaction-table table-small-font'>";
						
							$view .= "<thead class='table-header-blue-transaction table-header-bold'>";
							
								$view .= "<tr>";
								
								    $view .= "<td class='table-valign-middle table-align-middle'></td>";
								    
								    $view .= "<td class='table-valign-middle table-align-middle'>Account</td>";
								    									
									$view .= "<td class='table-valign-middle table-align-middle'>Description</td>";
									
									$view .= "<td class='table-valign-middle table-align-middle'>Qty</td>";
									
									$view .= "<td class='table-valign-middle table-align-middle'>Unit Price</td>";
																		
									$view .= "<td class='table-valign-middle table-align-middle'>Amount</td>";
									
									$view .= "<td></td>";
								
								$view .= "</tr>";
							
							$view .= "</thead>";
							
							$view .= "<tbody>";
							
							$i = 0;
																								
							while ($i != 3):
							
							$i++;
							
								$view .= "<tr class='accounting-table-tr-type-one accounting-bill-account-row'>";
									
									$view .= "<td class='accounting-table-td-type-three'><i class='icon-align-justify'></i><input id='id' class='accounting-item-id' type='hidden' value=''><input id='accounting-item-category' class='accounting-item-category' type='hidden' value=''></td>";
								    									
									$view .= "<td class='accounting-table-td-type-one accounting-account'><input class='accounting-table-input-type-six accounting-account-display' type='text' value=''><input class='accounting-account-value' type='hidden' id='account' value=''></td>";
								    								    								
									$view .= "<td class='accounting-table-td-type-one accounting-description'><input class='accounting-table-input-type-seven' type='text' id='description' value=''></td>";
									
									$view .= "<td class='accounting-table-td-type-one accounting-qty'><input class='accounting-table-input-type-one input-align-right' type='text' id='qty' value=''></td>";
									
									$view .= "<td class='accounting-table-td-type-one accounting-price'><input class='accounting-table-input-type-one input-align-right' type='text' id='price' value=''></td>";
																		
									$view .= "<td class='accounting-table-td-type-five accounting-amount'><input disabled='disabled' class='accounting-table-input-type-four input-align-right' type='text' id='amount' value=''></td>";
									
									$view .= "<td class='accounting-table-td-type-last '><input type='hidden' id='position' value=''><i class='icon-remove-circle accounting-table-del-line'></i></td>";
								$view .= "</tr>";
							
							endwhile;
							
							$view .= "</tbody>";
							
							$view .= "<tfoot>";
															
								$view .= "<tr class='accounting-table-tr-type-two'><td colspan='5' class='table-valign-middle table-align-right'>Grand Total</td><td class='table-align-right accounting-foot-total'>0.00</td><td></td></tr>";
																					
							$view .= "</tfoot>";
							
						$view .= "</table>";
						
					$view .= "</div>";
					
					$view .= "</div>";
					
					$view .= "<a class='pull-left btn btn-mini accounting-table-add-newline'><i class='icon-circle-arrow-right'></i> Add a new line</a>";
					
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
				
				$view .= "<br>";
				
				$view .= "<div class='accounting-action-final'>";
				
				$view .= "<div class='accounting-action-final-container'>";
				
					$view .= "<div class='pull-right default-control-form-final'>";
				
						$view .= "<button type='button' id='accounting-bill-submit-new' class='btn btn-small btn-success' data-loading-text='Please Wait...'><i class='icon-ok icon-white'></i> Save & Back</button>";
						
					$view .= "</div>";
					
					$view .= "<div class='pull-right default-control-form-final'>";
				
						$view .= "<button class='btn btn-small btn-info'><i class='icon-circle-arrow-right icon-white'></i> Save & Create New</button>";
						
					$view .= "</div>";
					
					$view .= "<div class='pull-right default-control-form-final'>";
	    		
						$view .= "<a href='".$this->url->builder(3561,'transaction')."' class='btn btn-small'><i class='icon-remove'></i> Cancel</a>";
						
					$view .= "</div>";
	    		
	    		$view .= "</div>";
	    		
	    		$view .= "</div>";
					
	    		$view .= "</form>";
	    			    			    			    		
	    	$view .= "</div>";
	    
	    $view .= "</div>";
	    
	return $view;
		    
    }
    
    public function form_viewBill() {

	    $item   = json_decode($this->getItem(), true);
	    
	    $coa    = json_decode($this->getCoa(), true);
	    
	    $acccur = json_decode($this->getCurrencyAccount(),true);
	    
	    $user 	= unserialize($_SESSION['user']);
	    
    	$id		= $user->getID();

    	$cus	= json_decode($this->getContactCustomer($id),true);
    	
    	$data   = json_decode($this->getBillByID(),true);

	    $crypt = encryption::urlHashEncodingRinjndael($_SESSION['xss'],$data['CAP_ACC_TRA_ID']);
	    
	    $view .= "<div class='row accounting-".$this->params."-container'>";
	    
	    $view .= "<div class='span12'>";
	    
	    	$view .= "<h2 class=''>View Bill</h2>";
	    
	    $view .= "</div>";
	    
	    	$view .= "<div class='span12 accounting-".$this->params."-formViewContainer'>";
	    	
	    	$view .= "<div class='span1 btn-group pull-left'>";
		   
		   	  	$view .= "<a class='btn btn-info btn-small dropdown-toggle' data-toggle='dropdown' href='#accounting-".$this->params."-coaAdd'><i class='icon-edit icon-white'></i> Options <span class='caret'></span></a>";
		   	  	
		   	  		$view .= "<ul class='dropdown-menu'>";
		   	  			
		   	  			$view .= "<li><a href='#'><i class='icon-ban-circle'></i> Void</a></li>";
		   	  			
		   	  			$view .= "<li><a href='".$this->url->builder(3802,'bill')."?actio=edit|||bill|||".$crypt."&emblem=".$_SESSION['xss']."'><i class='icon-pencil'></i> Edit</a></li>";
		   	  					   	  					   	  		
		   	  		$view .= "</ul>";
									  					
		   	$view .= "</div>";
		   
		    $view .= "<div class='clearfix'></div>";
	    	
	    	$view .= "<hr>";
	    		
	    	$view .= "<input id='capsuleCSRFToken' type='hidden' value='".$_SESSION['xss']."'>";
	    		
	    		$view .= "<form id='accounting-".$this->params."-form'>";
	    			
	    			$view .= "<div class='accounting-".$this->params."-form-transaction'>";
	    			
	    			$view .= "<div class='accounting-".$this->params."-form-top'>";
	    		
	    			$view .= "<div class='span-accounting-view-header default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='name'>To</label></span>";
						
						$view .= "<div class='controls'>".ucwords(strtolower($data['CAP_ACC_CON_CONTACT']))."</div>";
																	
					$view .= "</div>";
										
					$view .= "<div class='span-accounting-view-header default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='date'>Date</label></span>";
						
						$view .= "<div class='controls'>".date("d F Y",strtotime($data['CAP_ACC_TRA_DATE']))."</div>";
						
					$view .= "</div>";
					
					$view .= "<div class='span-accounting-view-header default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='due-date'>Due Date</label></span>";
						
						$view .= "<div class='controls'>".date("d F Y",strtotime($data['CAP_ACC_TRA_DUEDATE']))."</div>";
						
					$view .= "</div>";
					
					$view .= "<div class='span-accounting-view-header default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='number'>Invoice #</label></span>";
						
						$view .= "<div class='controls'>".$data['CAP_ACC_TRA_NUMBER']."</div>";
						
					$view .= "</div>";
										
					$view .= "<div class='span-accounting-view-header default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='number'>Currency</label></span>";
						
						$view .= "<div class='controls'>".$data['CAP_ACC_USE_ACC_CUR_NAME']." ".ucwords(strtolower($data['CAP_ACC_CUR_PREFIX']))."</div>";
						
					$view .= "</div>";
																				
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
					
					$view .= "<hr>";
															
					$view .= "</div>";
										
					$view .= "<div class='span12 accounting-".$this->params."-form-table'>";
										
					$view .= "<table class='table accounting-transaction-table-non-sortable table-small-font'>";
					
						$view .= "<thead class='table-header-grey-transaction table-header-bold'>";
						
							$view .= "<tr>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Type</td>";
														    
								$view .= "<td class='table-valign-middle table-align-middle'>Name</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Description</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Qty</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Unit Price</td>";
																
								$view .= "<td class='table-valign-middle table-align-middle'>Account</td>";
																
								$view .= "<td class='table-valign-middle table-align-middle'>Amount</td>";
															
							$view .= "</tr>";
						
						$view .= "</thead>";
						
						$view .= "<tbody>";
						
						$c = (int) reset(explode('/',$data['CAP_ACC_TRA_ROW']));

						$i = 0;
						
						$y = 0;

						if (!empty($data['ITEM-TRANSACTION'])):
												
							foreach ($data['ITEM-TRANSACTION'] as $value):
														
							$i++;
																
								unset($name); 
								unset($desc); 
								unset($coa); 
								unset($qty);
								unset($cat);
								unset($rate); 
								unset($amou);
								unset($disc);
								unset($discR);
								unset($discN); 
								unset($tax);
								unset($taxR);
								unset($taxA);

								$type  = (!empty($data['ITEM-TRANSACTION'][$y]['FK_CAP_ACC_ITE_ID'])) ? 'Item' : 'Expense';
								$name  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_ITE_NAME'];
								$desc  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_DESC'];
								$coa   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_COA_NAME'];
								$qty   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_QTY'];
								$cat   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_ITE_TYP_NAME'];
								$rate  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_RATE'];
								$amou  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_AMOUNT'];

								$disc  = $data['ITEM-TRANSACTION'][$y]['DISCOUNT'][0]['CAP_ACC_ITE_NAME'];
								$discR = $data['ITEM-TRANSACTION'][$y]['DISCOUNT'][0]['CAP_ACC_TRA_ITE_RATE'];
								$discN = $data['ITEM-TRANSACTION'][$y]['DISCOUNT'][0]['CAP_ACC_TRA_ITE_AMOUNT'];
								
								$tax   = $data['ITEM-TRANSACTION'][$y]['TAX'][0]['CAP_ACC_ITE_NAME'];
								$taxR  = $data['ITEM-TRANSACTION'][$y]['TAX'][0]['CAP_ACC_TRA_ITE_RATE'];
								$taxA  = $data['ITEM-TRANSACTION'][$y]['TAX'][0]['CAP_ACC_TRA_ITE_AMOUNT'];
								
								$name  = (!empty($name)) ? $name : '&nbsp;' ;
								$desc  = (!empty($desc)) ? ucwords(strtolower($desc)) : '&nbsp;' ;
								$coa   = (!empty($coa))  ? ucwords(strtolower($coa)) : '&nbsp;' ;
								$qty   = (!empty($qty))  ? number_format($qty,$this->getDecimalLength($qty)) : null;	
																
								$realAmount  = ($rate + (($rate / 100) * $taxR)) * $qty;
								
								$realDiscount = ($realAmount / 100) * $discR;
																
								$realAmount  = $realAmount - $realDiscount;
																
									if (strtoupper($cat) != 'SUB TOTAL'):
																											
									$rate = round($rate,4,PHP_ROUND_HALF_UP);
									
									$rate = (!empty($rate)) ? round($rate,4) : null;
									
									else:
									
									$rate = null;
									
									endif;

								$discN  = (!empty($discN)) ? round($discN,3,PHP_ROUND_HALF_UP) : 0;
								$discL += (!empty($discN)) ? $discN : 0;
								
								$disc   = (!empty($disc))  ? $disc." (".$discR."%)" : null;
								$tax    = (!empty($tax))   ? $tax." (".$taxR."%)" : null;
								$amou   = (!empty($amou))  ? bcsub($amou,$discN,4) : null;
								$money = round(bcdiv(bcmul($amou,bcadd(100,$taxR,4),4),100,4),4,PHP_ROUND_HALF_EVEN);

								$money =round($money/(100+$taxR)*100,4,PHP_ROUND_HALF_EVEN);
								
								list ($fund,$fundd) = explode('.',$money);
						
								$fund   = (!empty($fund))  ?  $fund :  '0';
								$fundd  = (!empty($fundd)) ?  substr($fundd,0,3) :  '00';
								$funds  = (!empty($fund)) ?  $money :  0.00;

								$funds  = round($funds,2,PHP_ROUND_HALF_ODD);
								
								$moneyT += $money;

									if (strtoupper($data['ITEM-TRANSACTION'][$y]['CAP_ACC_ITE_TYP_NAME']) != 'SUB TOTAL'):

									$discT     = (!empty($discN)) ? bcadd($discN,$discT,3) 	: $discT;
									$taxT      = (!empty($taxA))  ? bcadd($taxT,$taxA,3) 		: $taxT;
									$total     = (!empty($amou))  ? bcadd($amou,$total,3) 		: $total;
									$totalSub  = (!empty($amou))  ? bcadd($amou,$totalSub,3) 	: $totalSub;
									$totalTax  = (!empty($taxA))  ? bcadd($taxA,$totalTax,3)	: $totalTax;

									elseif (strtoupper($cat) == 'SUB TOTAL'):

									$funds     = round($totalSub,2,PHP_ROUND_HALF_ODD);
									$totalSub  = 0;
									$totalTax  = 0;
									
									endif;

									$view .= "<tr class='accounting-table-tr-type-one'>";
								        
								        $view .= "<td class='accounting-table-td-type-six table-valign-middle'>".ucwords(strtolower($type))."</td>";
								        						    
									    $view .= "<td class='accounting-table-td-type-six table-valign-middle'>".$name."</td>";
									    								
										$view .= "<td class='accounting-table-td-type-six table-valign-middle'>".$desc."</td>";
										
										$view .= "<td class='accounting-table-td-type-six table-valign-middle table-align-right'>".$qty."</td>";
										
										$view .= "<td class='accounting-table-td-type-six table-valign-middle table-align-right'>".$rate."</td>";
																																						
										$view .= "<td class='accounting-table-td-type-six table-valign-middle'>".$coa."</td>";
																				
										$view .= "<td class='accounting-table-td-type-six table-valign-middle table-align-right'>".number_format($funds,2)."</td>";
										
									$view .= "</tr>";
									
								$y++;
								
															
							endforeach;
						
						endif;
						
						$grandTotal = number_format(round(bcadd($moneyT,$taxT,3),3,PHP_ROUND_HALF_EVEN),2);
						
						$grandSubTotal = (!empty($moneyT)) ?  number_format($moneyT,2) :  number_format($total,2);
																								
						$view .= "</tbody>";
						
						$view .= "<tfoot>";
																												
						$view .= "<tr class='accounting-table-tr-type-six'><td colspan='6' class='table-valign-middle table-align-right'>Grand Total</td><td class='table-align-right accounting-foot-total'>".$grandTotal."</td></tr>";
																				
						$view .= "</tfoot>";
						
					$view .= "</table>";
										
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
				
				$view .= "<br>";

	    		$view .= "</form>";
	    			    			    			    		
	    	$view .= "</div>";
	    
	    $view .= "</div>";
	    
	return $view;
		    
    }
    
    public function form_editBill() {
	    
	    $item   = json_decode($this->getItem(), true);
	    
	    $coa    = json_decode($this->getCoa(), true);
	    
	    $acccur = json_decode($this->getCurrencyAccount(),true);
	    
	    $user 	= unserialize($_SESSION['user']);
	    
    	$id		= $user->getID();

    	$cus	= json_decode($this->getContactCustomer($id),true);
    	    	
    	$data   = json_decode($this->getbILLByID(),true);

	   if (!empty($cus)):
	    	
    		foreach ($cus as $key => $value):
    		
    		$selected  = ($data['CAP_ACC_CON_ID'] == $value['CAP_ACC_CON_ID']) ? "selected='selected'" : null;
    		
    		$customer .= "<option $selected value='".$value['CAP_ACC_CON_ID']."'>".ucwords(strtolower($value['CAP_ACC_CON_CONTACT']))."</option>";
    		
    		endforeach;
	    	
	   endif;
	    
    	if (!empty($acccur)):
    	
    		foreach ($acccur as $key => $value):
    		
    		$selected  = ($data['FK_CAP_ACC_TRA_CURRENCY'] == $value['CAP_ACC_USE_ACC_CUR_ID']) ? "selected='selected'" : null;
    		
    		$currency .= "<option $selected value='".$value['CAP_ACC_USE_ACC_CUR_ID']."'>".$value['CAP_ACC_CUR_NAME']." ".$value['CAP_ACC_CUR_PREFIX']."</option>";
    		
    		endforeach;
    	
    	endif;
	    
	    	if (!empty($item)):
	    	
	    		foreach ($item as $key => $value):
	    		
	    			if ($value['CAP_ACC_ITE_TYP_NAME'] == 'TAX'):
	    			
	    			$itemTax [] = [
	    			
	    			"id"    => $value['CAP_ACC_ITE_ID'],
	    			"label" => $value['CAP_ACC_ITE_NAME'],
	    			"rate"  => $value['COA-PURCHASE'][0]['CAP_ACC_ITE_COA_RATE']
	    			
	    			];
	    				    			
	    			endif;
	    			
	    			if ($value['CAP_ACC_ITE_TYP_NAME'] == 'DISCOUNT'):
	    			
	    			$itemDisc [] = [
	    			
	    			"id"    => $value['CAP_ACC_ITE_ID'],
	    			"label" => $value['CAP_ACC_ITE_NAME'],
	    			"rate"  => $value['COA-PURCHASE'][0]['CAP_ACC_ITE_COA_RATE']
	    			
	    			];
	    			
	    			endif;
	    		
	    		endforeach;
	    
		    	foreach ($item as $key => $value):
		    	
		    	unset($taxInfo);
		    	
		    	$phpItem .= "<option value='".$value['CAP_ACC_ITE_ID']."'>".$value['CAP_ACC_ITE_NAME']."</option>";
		    	
		    	if (!empty($value['COA-PURCHASE'][0]['FK_CAP_ACC_ITE_TAX_ID'])):
		    	
		    	$i = 0;
		    	
		    		foreach ($itemTax as $taxKey => $taxValue):

		    			if ($value['COA-PURCHASE'][0]['FK_CAP_ACC_ITE_TAX_ID'] == $taxValue['id']): 
		    			
		    			$taxInfo = $itemTax[$i]; break; 
		    			
		    			endif;
		    		
		    		$i++;
		    		
		    		endforeach;

		    	endif;
		    	
		    	$autoCompleteItem [] = [
		    	
		    	"id"		=> $value['CAP_ACC_ITE_ID'],
		    	"label" 	=> $value['CAP_ACC_ITE_NAME'],
		    	"desc" 		=> $value['CAP_ACC_ITE_DESC'],
		    	"price" 	=> $value['COA-PURCHASE'][0]['CAP_ACC_ITE_COA_RATE'],
		    	"category" 	=> ucwords(strtolower($value['CAP_ACC_ITE_TYP_NAME'])),
		    	"account"	=> ucwords(strtolower($value['COA-PURCHASE'][0]['CAP_ACC_COA_NAME'])),
		    	"accountid"	=> $value['COA-PURCHASE'][0]['FK_CAP_ACC_COA_ID'],
		    	"taxid"		=> $taxInfo['id'],
		    	"taxname"	=> $taxInfo['label'],
		    	"taxrate"	=> $taxInfo['rate']
		    	
		    	];
		    			    	
		    	endforeach;
	    	
	    	endif;
	    		    	
	    	if (!empty($coa)):
	    	
	    		foreach ($coa as $key => $value):
	    		
	    		$phpCoa .= "<option value='".$value['CAP_ACC_ITE_ID']."'>".$value['CAP_ACC_ITE_NAME']."</option>";
	    			
	    		$autoCompleteCoa [] = [
		    	
		    	"id"		=> $value['CAP_ACC_COA_ID'],
		    	"label" 	=> ucwords(strtolower($value['CAP_ACC_COA_NAME'])),
		    	"desc" 		=> $value['CAP_ACC_COA_DESC'],
		    	"category" 	=> ucwords(strtolower($value['CAP_ACC_COA_TYP_NAME']))
		    	
		    	];
		    	
			    	if ($value['CAP_ACC_COA_TYP_NAME'] == 'ACCOUNT PAYABLE'):

			    	$accReceivable .= "<option value='".$value['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value['CAP_ACC_COA_NAME']))."</option>";

			    	endif;
	    		
	    		endforeach;
	    	
	    	endif;

	    $view .= "<script type='text/javascript'>";
	    	    	
	    	$view .= "function accountingInvoiceItem() {";
	    	
	    		$view .= "return ".json_encode($autoCompleteItem);
	    	
	    	$view .= "}";
	    		    	
	    	$view .= "function accountingInvoiceCoa() {";
	    	
	    		$view .= "return ".json_encode($autoCompleteCoa);
	    	
	    	$view .= "}";
	    	
	    	$view .= "function accountingInvoiceTax() {";
	    	
	    		$view .= "return ".json_encode($itemTax);
	    	
	    	$view .= "}";
	    	
	    	$view .= "function accountingInvoiceDiscount() {";
	    	
	    		$view .= "return ".json_encode($itemDisc);
	    	
	    	$view .= "}";
	    
	    $view .= "</script>";
	    	    
	    $view .= "<div class='row accounting-".$this->params."-container'>";
	    
	    $view .= "<div class='span12'>";
	    
	    	$view .= "<h2 class=''>Edit Bill</h2>";
	    
	    $view .= "</div>";
	    
	    	$view .= "<div class='span12 accounting-".$this->params."-formContainer'>";
	    		
	    	$view .= "<input id='capsuleCSRFToken' type='hidden' value='".$_SESSION['xss']."'>";
	    		
	    		$view .= "<form id='accounting-".$this->params."-form' data-form-type='bill'>";
	    			    			
	    			$view .= "<div class='accounting-".$this->params."-form-transaction'>";
	    			
	    			$view .= "<input id='transaction-pid' type='hidden' value='".$data['CAP_ACC_TRA_ID']."'>";
	    			
	    			$view .= "<div class='accounting-".$this->params."-form-top'>";
	    		
	    			$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='name'>From</label></span>";
						
						$view .= "<div class='controls'><select id='customer-id' class='span2 accounting-chosen'><option></option>$customer</select></div>";
																	
					$view .= "</div>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='account'>Account</label></span>";
						
						$view .= "<div class='controls'><select id='account' class='span2 accounting-chosen'>".$accReceivable."</select></div>";
																														
					$view .= "</div>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='date'>Date</label></span>";
						
						$view .= "<div class='controls'><input class='accounting-date-".md5(rand(0,100))." input-medium' type='text' id='date' value='".date('d-m-Y',strtotime($data['CAP_ACC_TRA_DATE']))."'></div>";
						
					$view .= "</div>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='due-date'>Due Date</label></span>";
						
						$view .= "<div class='controls'><input class='accounting-date-".md5(rand(0,100))." input-medium' type='text' id='due-date' value='".date('d-m-Y',strtotime($data['CAP_ACC_TRA_DUEDATE']))."'></div>";
						
					$view .= "</div>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='number'>Reference #</label></span>";
						
						$view .= "<div class='controls'><input class='input-medium' type='text' id='number' value='".$data['CAP_ACC_TRA_NUMBER']."'></div>";
						
					$view .= "</div>";
																				
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
					
					$view .= "<hr>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='currency'>Currency</label></span>";
						
						$view .= "<div class='controls'><select id='currency' class='span2 accounting-chosen'>".$currency."</select></div>";
						
					$view .= "</div>";
										
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
					
					$view .= "<br>";
					
					$view .= "<div class='span12 accounting-".$this->params."-form-table'>";
					
					$view .= "<div id='accounting-".$this->params."-table'>";
    	
			    	$view .= "<ul class='nav nav-tabs'>";
			    	
						$view .= "<li class='active'><a data-toggle='tab' href='#item-tab'>Item</a></li>";
						
						$view .= "<li><a data-toggle='tab' href='#expense-tab'>Expense</a></li>";
																   	  						
					$view .= "</ul>";
				
					$view .= "</div>";
				
					$view .= "<div class='tab-content'>";
				
					$view .= "<div class='tab-pane active' id='item-tab'>";
										
						$view .= "<table class='table accounting-transaction-table table-small-font'>";
						
							$view .= "<thead class='table-header-blue-transaction table-header-bold'>";
							
								$view .= "<tr>";
								
								    $view .= "<td class='table-valign-middle table-align-middle'></td>";
								    
									$view .= "<td class='table-valign-middle table-align-middle'>Item</td>";
									
									$view .= "<td class='table-valign-middle table-align-middle'>Description</td>";
									
									$view .= "<td class='table-valign-middle table-align-middle'>Qty</td>";
									
									$view .= "<td class='table-valign-middle table-align-middle'>Unit Price</td>";
																		
									$view .= "<td class='table-valign-middle table-align-middle'>Account</td>";
																		
									$view .= "<td class='table-valign-middle table-align-middle'>Amount</td>";
									
									$view .= "<td></td>";
								
								$view .= "</tr>";
							
							$view .= "</thead>";
							
							$view .= "<tbody>";
							
							if (!empty($data['ITEM-TRANSACTION'])):
							
    							foreach ($data['ITEM-TRANSACTION'] as $value):
    							
    							     $total += $value['CAP_ACC_TRA_ITE_AMOUNT'];
    							
    							endforeach;
							
							endif;
							
							$c = (int) reset(explode('/',$data['CAP_ACC_TRA_ROW']));
							
    						$i = 0;
    						
    						$y = 0;

							while ($i != $c):
							
							$i++; 

    							if ($i == $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_POSITION'] && !empty($data['ITEM-TRANSACTION'][$y]['FK_CAP_ACC_ITE_ID'])):

    							$pid   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_ID'];
    							$id    = $data['ITEM-TRANSACTION'][$y]['FK_CAP_ACC_ITE_ID'];
								$name  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_ITE_NAME'];
								$desc  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_DESC'];
								$coa   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_COA_NAME'];
								$qty   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_QTY'];
								$cat   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_ITE_TYP_NAME'];
								$rate  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_RATE'];
								$amou  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_AMOUNT'];
								
								$name  = (!empty($name)) ? $name : '&nbsp;' ;
								$cat   = (!empty($cat)) ? ucwords(strtolower($cat)) : '&nbsp;' ;
								$desc  = (!empty($desc)) ? ucwords(strtolower($desc)) : '&nbsp;' ;
								$coa   = (!empty($coa))  ? ucwords(strtolower($coa)) : '&nbsp;' ;
								$coaID = $data['ITEM-TRANSACTION'][$y]['FK_CAP_ACC_COA_ID'];
    														
    								$view .= "<tr class='accounting-table-tr-type-one accounting-bill-item-row'>";
    								
    								    $view .= "<td class='accounting-table-td-type-three'><i class='icon-align-justify'></i><input id='item-pid' class='accounting-item-pid' type='hidden' value='$pid'><input id='id' class='accounting-item-id' type='hidden' value='$id'><input id='accounting-item-category' class='accounting-item-category' type='hidden' value='$cat'></td>";
    								    
    								    $view .= "<td class='accounting-table-td-type-one accounting-item'><input class='accounting-table-input-type-three' type='text' id='item' value='$name'></td>";
    								    								
    									$view .= "<td class='accounting-table-td-type-one accounting-description'><input class='accounting-table-input-type-five' type='text' id='description' value='$desc'></td>";
    									
    									$view .= "<td class='accounting-table-td-type-one accounting-qty'><input class='accounting-table-input-type-one input-align-right' type='text' id='qty' value='$qty'></td>";
    									
    									$view .= "<td class='accounting-table-td-type-one accounting-price'><input class='accounting-table-input-type-one input-align-right' type='text' id='price' value='$rate'></td>";
    																		
    									$view .= "<td class='accounting-table-td-type-one accounting-account'><input class='accounting-table-input-type-one accounting-account-display' type='text' value='$coa'><input class='accounting-account-value' type='hidden' id='account' value='$coaID'></td>";
    																		
    									$view .= "<td class='accounting-table-td-type-five accounting-amount'><input disabled='disabled' class='accounting-table-input-type-four input-align-right' type='text' id='amount' value='$amou'></td>";
    									
    									$view .= "<td class='accounting-table-td-type-last '><input type='hidden' id='position' value=''><i class='icon-remove-circle accounting-table-del-line'></i></td>";
    								$view .= "</tr>";
    							
    							$y++;
    							    							
    							else:
    							
    							    $view .= "<tr class='accounting-table-tr-type-one accounting-bill-item-row'>";
    								
    								    $view .= "<td class='accounting-table-td-type-three'><i class='icon-align-justify'></i><input id='id' class='accounting-item-id' type='hidden' value=''><input id='accounting-item-category' class='accounting-item-category' type='hidden' value=''></td>";
    								    
    								    $view .= "<td class='accounting-table-td-type-one accounting-item'><input class='accounting-table-input-type-three' type='text' id='item' value=''></td>";
    								    								
    									$view .= "<td class='accounting-table-td-type-one accounting-description'><input class='accounting-table-input-type-five' type='text' id='description' value=''></td>";
    									
    									$view .= "<td class='accounting-table-td-type-one accounting-qty'><input class='accounting-table-input-type-one input-align-right' type='text' id='qty' value=''></td>";
    									
    									$view .= "<td class='accounting-table-td-type-one accounting-price'><input class='accounting-table-input-type-one input-align-right' type='text' id='price' value=''></td>";
    																		
    									$view .= "<td class='accounting-table-td-type-one accounting-account'><input class='accounting-table-input-type-one accounting-account-display' type='text' value=''><input class='accounting-account-value' type='hidden' id='account' value=''></td>";
    																		
    									$view .= "<td class='accounting-table-td-type-five accounting-amount'><input disabled='disabled' class='accounting-table-input-type-four input-align-right' type='text' id='amount' value=''></td>";
    									
    									$view .= "<td class='accounting-table-td-type-last '><input type='hidden' id='position' value=''><i class='icon-remove-circle accounting-table-del-line'></i></td>";
    								$view .= "</tr>";
    							
    							endif;
																					
							endwhile;
							
							$view .= "</tbody>";
							
							$view .= "<tfoot>";
															
								$view .= "<tr class='accounting-table-tr-type-two'><td colspan='6' class='table-valign-middle table-align-right'>Grand Total</td><td class='table-align-right accounting-foot-total'>".number_format($total,2)."</td><td></td></tr>";
																					
							$view .= "</tfoot>";
							
						$view .= "</table>";
					
					$view .= "</div>";
					
					$view .= "<div class='tab-pane' id='expense-tab'>";
					
						$view .= "<table class='table accounting-transaction-table table-small-font'>";
						
							$view .= "<thead class='table-header-blue-transaction table-header-bold'>";
							
								$view .= "<tr>";
								
								    $view .= "<td class='table-valign-middle table-align-middle'></td>";
								    
								    $view .= "<td class='table-valign-middle table-align-middle'>Account</td>";
								    									
									$view .= "<td class='table-valign-middle table-align-middle'>Description</td>";
									
									$view .= "<td class='table-valign-middle table-align-middle'>Qty</td>";
									
									$view .= "<td class='table-valign-middle table-align-middle'>Unit Price</td>";
																		
									$view .= "<td class='table-valign-middle table-align-middle'>Amount</td>";
									
									$view .= "<td></td>";
								
								$view .= "</tr>";
							
							$view .= "</thead>";
							
							$view .= "<tbody>";
														
							$c = (int) end(explode('/',$data['CAP_ACC_TRA_ROW']));

    						$i = 0;
    																														
							while ($i != $c):
							
							$i++;

							    if ($i == $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_POSITION'] && empty($data['ITEM-TRANSACTION'][$y]['FK_CAP_ACC_ITE_ID'])):
							     
							    $pid   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_ID'];
    							$id    = $data['ITEM-TRANSACTION'][$y]['FK_CAP_ACC_ITE_ID'];
								$name  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_ITE_NAME'];
								$desc  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_DESC'];
								$coa   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_COA_NAME'];
								$qty   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_QTY'];
								$cat   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_ITE_TYP_NAME'];
								$rate  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_RATE'];
								$amou  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_AMOUNT'];
								
								$name  = (!empty($name)) ? $name : '&nbsp;' ;
								$cat   = (!empty($cat)) ? ucwords(strtolower($cat)) : '&nbsp;' ;
								$desc  = (!empty($desc)) ? ucwords(strtolower($desc)) : '&nbsp;' ;
								$coa   = (!empty($coa))  ? ucwords(strtolower($coa)) : '&nbsp;' ;
								$coaID = $data['ITEM-TRANSACTION'][$y]['FK_CAP_ACC_COA_ID'];
							     
								$view .= "<tr class='accounting-table-tr-type-one accounting-bill-account-row'>";
									
									$view .= "<td class='accounting-table-td-type-three'><i class='icon-align-justify'></i><input id='item-pid' class='accounting-item-pid' type='hidden' value='$pid'><input id='id' class='accounting-item-id' type='hidden' value='$id'><input id='accounting-item-category' class='accounting-item-category' type='hidden' value='$cat'></td>";
								    									
									$view .= "<td class='accounting-table-td-type-one accounting-account'><input class='accounting-table-input-type-six accounting-account-display' type='text' value='$coa'><input class='accounting-account-value' type='hidden' id='account' value='$coaID'></td>";
								    								    								
									$view .= "<td class='accounting-table-td-type-one accounting-description'><input class='accounting-table-input-type-seven' type='text' id='description' value='$desc'></td>";
									
									$view .= "<td class='accounting-table-td-type-one accounting-qty'><input class='accounting-table-input-type-one input-align-right' type='text' id='qty' value='$qty'></td>";
									
									$view .= "<td class='accounting-table-td-type-one accounting-price'><input class='accounting-table-input-type-one input-align-right' type='text' id='price' value='$rate'></td>";
																		
									$view .= "<td class='accounting-table-td-type-five accounting-amount'><input disabled='disabled' class='accounting-table-input-type-four input-align-right' type='text' id='amount' value='$amou'></td>";
									
									$view .= "<td class='accounting-table-td-type-last '><input type='hidden' id='position' value=''><i class='icon-remove-circle accounting-table-del-line'></i></td>";
								$view .= "</tr>";
								
								$y++;
																
								else:
								
								$view .= "<tr class='accounting-table-tr-type-one accounting-bill-account-row'>";
									
									$view .= "<td class='accounting-table-td-type-three'><i class='icon-align-justify'></i><input id='id' class='accounting-item-id' type='hidden' value=''><input id='accounting-item-category' class='accounting-item-category' type='hidden' value=''></td>";
								    									
									$view .= "<td class='accounting-table-td-type-one accounting-account'><input class='accounting-table-input-type-six accounting-account-display' type='text' value=''><input class='accounting-account-value' type='hidden' id='account' value=''></td>";
								    								    								
									$view .= "<td class='accounting-table-td-type-one accounting-description'><input class='accounting-table-input-type-seven' type='text' id='description' value=''></td>";
									
									$view .= "<td class='accounting-table-td-type-one accounting-qty'><input class='accounting-table-input-type-one input-align-right' type='text' id='qty' value=''></td>";
									
									$view .= "<td class='accounting-table-td-type-one accounting-price'><input class='accounting-table-input-type-one input-align-right' type='text' id='price' value=''></td>";
																		
									$view .= "<td class='accounting-table-td-type-five accounting-amount'><input disabled='disabled' class='accounting-table-input-type-four input-align-right' type='text' id='amount' value=''></td>";
									
									$view .= "<td class='accounting-table-td-type-last '><input type='hidden' id='position' value=''><i class='icon-remove-circle accounting-table-del-line'></i></td>";
								$view .= "</tr>";
								
								endif;
																							 
							endwhile;
							
							$view .= "</tbody>";
							
							$view .= "<tfoot>";

								$view .= "<tr class='accounting-table-tr-type-two'><td colspan='5' class='table-valign-middle table-align-right'>Grand Total</td><td class='table-align-right accounting-foot-total'>".number_format($total,2)."</td><td></td></tr>";
																					
							$view .= "</tfoot>";
							
						$view .= "</table>";
						
					$view .= "</div>";
					
					$view .= "</div>";
					
					$view .= "<a class='pull-left btn btn-mini accounting-table-add-newline'><i class='icon-circle-arrow-right'></i> Add a new line</a>";
					
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
				
				$view .= "<br>";
				
				$view .= "<div class='accounting-action-final'>";
				
				$view .= "<div class='accounting-action-final-container'>";
				
					$view .= "<div class='pull-right default-control-form-final'>";
				
						$view .= "<button id='accounting-bill-submit-edit' class='btn btn-small btn-success'><i class='icon-ok icon-white'></i> Save & Back</button>";
						
					$view .= "</div>";
					
					$view .= "<div class='pull-right default-control-form-final'>";
				
						$view .= "<button class='btn btn-small btn-info'><i class='icon-circle-arrow-right icon-white'></i> Save & Create New</button>";
						
					$view .= "</div>";
					
					$view .= "<div class='pull-right default-control-form-final'>";
	    		
						$view .= "<a href='".$this->url->builder(3561,'transaction')."' class='btn btn-small'><i class='icon-remove'></i> Cancel</a>";
						
					$view .= "</div>";
	    		
	    		$view .= "</div>";
	    		
	    		$view .= "</div>";
					
	    		$view .= "</form>";
	    			    			    			    		
	    	$view .= "</div>";
	    
	    $view .= "</div>";
	    
	return $view;
		    
    }
    
    public function form_salesreceipt_controller() {
	    
	    $view   = $this->optionGear;
	    
	    $actio  = explode('|||',$_GET['actio']);
	    
	    $key    = $_GET['emblem'];
	    
	    $words  = $actio[0];
	    
	    $rjand  = encryption::urlHashDecodingRinjndael($key,$actio[2]);
	    
			if (!is_numeric($rjand)):

			//header('Location: http://www.asacreative.com');
								
			endif;
	    
		if ($words == 'new'): 
		
			echo $this->form_createSalesReceipt(); 
		
		elseif ($words == 'view'):
			
			$this->data = $rjand;
						
			echo $this->form_viewSalesReceipt();
			
		elseif ($words == 'edit'):
		
			$this->data = $rjand;
		
			echo $this->form_editSalesReceipt();
		
		endif;
	
    }
    
    public function form_createSalesReceipt() {
	    
	    $item   = json_decode($this->getItem(), true);
	    
	    $coa    = json_decode($this->getCoa(), true);
	    
	    $acccur = json_decode($this->getCurrencyAccount(),true);
	    
	    $user 	= unserialize($_SESSION['user']);
	    
    	$id		= $user->getID();

    	$cus	= json_decode($this->getContactCustomer($id),true);
	    	    	    
	    	if (!empty($cus)):
	    	
	    		foreach ($cus as $key => $value):
	    		
	    		$customer .= "<option value='".$value['CAP_ACC_CON_ID']."'>".ucwords(strtolower($value['CAP_ACC_CON_CONTACT']))."</option>";
	    		
	    		endforeach;
	    	
	    	endif;
	    
	    	if (!empty($acccur)):
	    	
	    		foreach ($acccur as $key => $value):
	    		
	    		$currency .= "<option value='".$value['CAP_ACC_USE_ACC_CUR_ID']."'>".$value['CAP_ACC_CUR_NAME']." ".$value['CAP_ACC_CUR_PREFIX']."</option>";
	    		
	    		endforeach;
	    	
	    	endif;
	    
	    	if (!empty($item)):
	    	
	    		foreach ($item as $key => $value):
	    		
	    			if ($value['CAP_ACC_ITE_TYP_NAME'] == 'TAX'):
	    			
	    			$itemTax [] = [
	    			
	    			"id"    => $value['CAP_ACC_ITE_ID'],
	    			"label" => $value['CAP_ACC_ITE_NAME'],
	    			"rate"  => $value['COA-SELLING'][0]['CAP_ACC_ITE_COA_RATE']
	    			
	    			];
	    				    			
	    			endif;
	    			
	    			if ($value['CAP_ACC_ITE_TYP_NAME'] == 'DISCOUNT'):
	    			
	    			$itemDisc [] = [
	    			
	    			"id"    => $value['CAP_ACC_ITE_ID'],
	    			"label" => $value['CAP_ACC_ITE_NAME'],
	    			"rate"  => $value['COA-SELLING'][0]['CAP_ACC_ITE_COA_RATE']
	    			
	    			];
	    			
	    			endif;
	    		
	    		endforeach;
	    
		    	foreach ($item as $key => $value):
		    	
		    	unset($taxInfo);
		    	
		    	$phpItem .= "<option value='".$value['CAP_ACC_ITE_ID']."'>".$value['CAP_ACC_ITE_NAME']."</option>";
		    	
		    	if (!empty($value['COA-SELLING'][0]['FK_CAP_ACC_ITE_TAX_ID'])):
		    	
		    	$i = 0;
		    	
		    		foreach ($itemTax as $taxKey => $taxValue):

		    			if ($value['COA-SELLING'][0]['FK_CAP_ACC_ITE_TAX_ID'] == $taxValue['id']): 
		    			
		    			$taxInfo = $itemTax[$i]; break; 
		    			
		    			endif;
		    		
		    		$i++;
		    		
		    		endforeach;

		    	endif;
		    	
		    	$autoCompleteItem [] = [
		    	
		    	"id"		=> $value['CAP_ACC_ITE_ID'],
		    	"label" 	=> $value['CAP_ACC_ITE_NAME'],
		    	"desc" 		=> $value['CAP_ACC_ITE_DESC'],
		    	"price" 	=> $value['COA-SELLING'][0]['CAP_ACC_ITE_COA_RATE'],
		    	"category" 	=> ucwords(strtolower($value['CAP_ACC_ITE_TYP_NAME'])),
		    	"account"	=> ucwords(strtolower($value['COA-SELLING'][0]['CAP_ACC_COA_NAME'])),
		    	"accountid"	=> $value['COA-SELLING'][0]['FK_CAP_ACC_COA_ID'],
		    	"taxid"		=> $taxInfo['id'],
		    	"taxname"	=> $taxInfo['label'],
		    	"taxrate"	=> $taxInfo['rate']
		    	
		    	];
		    			    	
		    	endforeach;
	    	
	    	endif;
	    		    	
	    	if (!empty($coa)):
	    	
	    		foreach ($coa as $key => $value):
	    		
	    		$phpCoa .= "<option value='".$value['CAP_ACC_ITE_ID']."'>".$value['CAP_ACC_ITE_NAME']."</option>";
	    			
	    		$autoCompleteCoa [] = [
		    	
		    	"id"		=> $value['CAP_ACC_COA_ID'],
		    	"label" 	=> ucwords(strtolower($value['CAP_ACC_COA_NAME'])),
		    	"desc" 		=> $value['CAP_ACC_COA_DESC'],
		    	"category" 	=> ucwords(strtolower($value['CAP_ACC_COA_TYP_NAME']))
		    	
		    	];
		    	
			    	if ($value['CAP_ACC_COA_TYP_NAME'] == 'BANK'):

			    	$accReceivable .= "<option value='".$value['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value['CAP_ACC_COA_NAME']))."</option>";

			    	endif;
	    		
	    		endforeach;
	    	
	    	endif;

	    $view .= "<script type='text/javascript'>";
	    	    	
	    	$view .= "function accountingInvoiceItem() {";
	    	
	    		$view .= "return ".json_encode($autoCompleteItem);
	    	
	    	$view .= "}";
	    		    	
	    	$view .= "function accountingInvoiceCoa() {";
	    	
	    		$view .= "return ".json_encode($autoCompleteCoa);
	    	
	    	$view .= "}";
	    	
	    	$view .= "function accountingInvoiceTax() {";
	    	
	    		$view .= "return ".json_encode($itemTax);
	    	
	    	$view .= "}";
	    	
	    	$view .= "function accountingInvoiceDiscount() {";
	    	
	    		$view .= "return ".json_encode($itemDisc);
	    	
	    	$view .= "}";
	    
	    $view .= "</script>";
	    
	    //$view .= $this->optionGear;
	    
	    $view .= "<div class='row accounting-".$this->params."-container'>";
	    
	    $view .= "<div class='span12'>";
	    
	    	$view .= "<h2 class=''>New Sales Receipt</h2>";
	    
	    $view .= "</div>";
	    
	    	$view .= "<div class='span12 accounting-".$this->params."-formContainer'>";
	    		
	    	$view .= "<input id='capsuleCSRFToken' type='hidden' value='".$_SESSION['xss']."'>";
	    		
	    		$view .= "<form id='accounting-".$this->params."-form' data-form-type='invoice'>";
	    			
	    			$view .= "<div class='accounting-".$this->params."-form-transaction'>";
	    			
	    			$view .= "<div class='accounting-".$this->params."-form-top'>";
	    		
	    			$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='name'>To</label></span>";
						
						$view .= "<div class='controls'><select id='customer-id' class='span2 accounting-chosen'><option></option>$customer</select></div>";
																	
					$view .= "</div>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='account'>Account</label></span>";
						
						$view .= "<div class='controls'><select id='account' class='span2 accounting-chosen'>".$accReceivable."</select></div>";
																														
					$view .= "</div>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='date'>Date</label></span>";
						
						$view .= "<div class='controls'><input class='accounting-date-".md5(rand(0,100))." input-medium' type='text' id='date' value='".$data['CAP_ACC_ITE_NAME']."'></div>";
						
					$view .= "</div>";
										
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='number'>Sales Receipt #</label></span>";
						
						$view .= "<div class='controls'><input class='input-large' type='text' id='number' value='".$item['CAP_ACC_ITE_NAME']."'></div>";
						
					$view .= "</div>";
																				
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
					
					$view .= "<hr class='accounting-create-hr'>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='currency'>Currency</label></span>";
						
						$view .= "<div class='controls'><select id='currency' class='span2 accounting-chosen'>".$currency."</select></div>";
						
					$view .= "</div>";
					
					$view .= "<div class='default-control-right'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='globaltax'>Tax</label></span>";
						
						$view .= "<div class='controls'><select id='globaltax' class='span2 accounting-chosen'><option value='exclude'>Tax Exclude</option><option value='include'>Tax Include</option><option value='nontaxable'>Non Taxable</option></select></div>";
						
					$view .= "</div>";
					
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
					
					$view .= "<br>";
					
					$view .= "<div class='span12 accounting-".$this->params."-form-table'>";
										
					$view .= "<table class='table accounting-transaction-table table-small-font'>";
					
						$view .= "<thead class='table-header-blue-transaction table-header-bold'>";
						
							$view .= "<tr>";
							
							    $view .= "<td class='table-valign-middle table-align-middle'></td>";
							    
								$view .= "<td class='table-valign-middle table-align-middle'>Item</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Description</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Qty</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Unit Price</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Disc%</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Account</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Tax</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Amount</td>";
								
								$view .= "<td></td>";
							
							$view .= "</tr>";
						
						$view .= "</thead>";
						
						$view .= "<tbody>";
						
						$i = 0;
						
						while ($i != 3):
						
						$i++;
						
							$view .= "<tr class='accounting-table-tr-type-one accounting-salesreceipt-item-row'>";
							
							    $view .= "<td class='accounting-table-td-type-three'><i class='icon-align-justify'></i><input id='id' class='accounting-item-id' type='hidden' value=''><input id='accounting-item-category' class='accounting-item-category' type='hidden' value=''></td>";
							    
							    $view .= "<td class='accounting-table-td-type-one accounting-item'><input class='accounting-table-input-type-three' type='text' id='item' value=''></td>";
							    								
								$view .= "<td class='accounting-table-td-type-one accounting-description'><input class='accounting-table-input-type-two' type='text' id='description' value=''></td>";
								
								$view .= "<td class='accounting-table-td-type-one accounting-qty'><input class='accounting-table-input-type-one input-align-right' type='text' id='qty' value=''></td>";
								
								$view .= "<td class='accounting-table-td-type-one accounting-price'><input class='accounting-table-input-type-one input-align-right' type='text' id='price' value=''></td>";
								
								$view .= "<td class='accounting-table-td-type-one accounting-discount'><input class='accounting-table-input-type-one input-align-right accounting-discount-display' type='text' value=''><input class='accounting-discount-id' id='discount-id' type='hidden' value=''><input class='accounting-discount-value' type='hidden' id='discount' value=''></td>";
								
								$view .= "<td class='accounting-table-td-type-one accounting-account'><input class='accounting-table-input-type-one accounting-account-display' type='text' value=''><input class='accounting-account-value' type='hidden' id='account' value=''></td>";
								
								$view .= "<td class='accounting-table-td-type-one accounting-tax'><input class='accounting-table-input-type-one input-align-right accounting-tax-display' type='text' value=''><input class='accounting-tax-id' id='tax-id' type='hidden' value=''><input class='accounting-tax-value' type='hidden' id='tax' value=''></td>";
								
								$view .= "<td class='accounting-table-td-type-five accounting-amount'><input disabled='disabled' class='accounting-table-input-type-four input-align-right' type='text' id='amount' value=''></td>";
								
								$view .= "<td class='accounting-table-td-type-last '><input type='hidden' id='position' value=''><i class='icon-remove-circle accounting-table-del-line'></i></td>";
							$view .= "</tr>";
						
						endwhile;
						
						$view .= "</tbody>";
						
						$view .= "<tfoot>";
						
							$view .= "<tr class='accounting-table-tr-type-two'><td colspan='8' class='table-valign-middle table-align-right'><span class='accounting-foot-discount'></span> Sub Total</td><td class='table-align-right accounting-foot-subtotal'>0.00</td><td></td></tr>";
														
							$view .= "<tr class='accounting-table-tr-type-two'><td colspan='8' class='table-valign-middle table-align-right'>Vat</td><td class='table-align-right accounting-foot-tax'>0.00</td><td></td></tr>";
							
							$view .= "<tr class='accounting-table-tr-type-two'><td colspan='8' class='table-valign-middle table-align-right'>Grand Total</td><td class='table-align-right accounting-foot-total'>0.00</td><td></td></tr>";
																				
						$view .= "</tfoot>";
						
					$view .= "</table>";
					
					$view .= "<a class='pull-left btn btn-mini accounting-table-add-newline'><i class='icon-circle-arrow-right'></i> Add a new line</a>";
					
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
				
				$view .= "<br>";
				
				$view .= "<div class='accounting-action-final'>";
				
				$view .= "<div class='accounting-action-final-container'>";
				
					$view .= "<div class='pull-right default-control-form-final'>";
				
						$view .= "<button type='button' id='accounting-salesreceipt-submit-new' class='btn btn-small btn-success' data-loading-text='Please Wait...'><i class='icon-ok icon-white'></i> Save & Back</button>";
						
					$view .= "</div>";
					
					$view .= "<div class='pull-right default-control-form-final'>";
				
						$view .= "<button class='btn btn-small btn-info'><i class='icon-circle-arrow-right icon-white'></i> Save & Create New</button>";
						
					$view .= "</div>";
					
					$view .= "<div class='pull-right default-control-form-final'>";
	    		
						$view .= "<a href='".$this->url->builder(3561,'transaction')."' class='btn btn-small'><i class='icon-remove'></i> Cancel</a>";
						
					$view .= "</div>";
	    		
	    		$view .= "</div>";
	    		
	    		$view .= "</div>";
					
	    		$view .= "</form>";
	    			    			    			    		
	    	$view .= "</div>";
	    
	    $view .= "</div>";
	    
	return $view;
		    
    }
    
    public function form_viewSalesReceipt() {

    	$misc = new misc();
	    
	    $item   = json_decode($this->getItem(), true);
	    
	    $coa    = json_decode($this->getCoa(), true);
	    
	    $acccur = json_decode($this->getCurrencyAccount(),true);
	    
	    $user 	= unserialize($_SESSION['user']);
	    
    	$id		= $user->getID();

    	$cus	= json_decode($this->getContactCustomer($id),true);
    	
    	$data   = json_decode($this->getSalesReceiptByID(),true);
	    	    	    	    
	    $crypt = encryption::urlHashEncodingRinjndael($_SESSION['xss'],$data['CAP_ACC_TRA_ID']);
	    
	    $view .= "<div class='row accounting-".$this->params."-container'>";
	    
	    $view .= "<div class='span12'>";
	    
	    	$view .= "<h2 class=''>View Sales Receipt</h2>";
	    
	    $view .= "</div>";
	    
	    	$view .= "<div class='span12 accounting-".$this->params."-formViewContainer'>";
	    	
	    	$view .= "<div class='span1 btn-group pull-left'>";
		   
		   	  	$view .= "<a class='btn btn-info btn-small dropdown-toggle' data-toggle='dropdown' href='#accounting-".$this->params."-coaAdd'><i class='icon-edit icon-white'></i> Options <span class='caret'></span></a>";
		   	  	
		   	  		$view .= "<ul class='dropdown-menu'>";
		   	  			
		   	  			$view .= "<li><a href='#'><i class='icon-ban-circle'></i> Void</a></li>";
		   	  			
		   	  			$view .= "<li><a href='".$this->url->builder(3940,'sales-receipt')."?actio=edit|||sales-receipt|||".$crypt."&emblem=".$_SESSION['xss']."'><i class='icon-pencil'></i> Edit</a></li>";
		   	  					   	  					   	  		
		   	  		$view .= "</ul>";
									  					
		   	$view .= "</div>";
		   
		    $view .= "<div class='clearfix'></div>";
	    	
	    	$view .= "<hr>";
	    		
	    	$view .= "<input id='capsuleCSRFToken' type='hidden' value='".$_SESSION['xss']."'>";
	    		
	    		$view .= "<form id='accounting-".$this->params."-form'>";
	    			
	    			$view .= "<div class='accounting-".$this->params."-form-transaction'>";
	    			
	    			$view .= "<div class='accounting-".$this->params."-form-top'>";
	    		
	    			$view .= "<div class='span-accounting-view-header default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='name'>To</label></span>";
						
						$view .= "<div class='controls'>".ucwords(strtolower($data['CAP_ACC_CON_CONTACT']))."</div>";
																	
					$view .= "</div>";
										
					$view .= "<div class='span-accounting-view-header default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='date'>Date</label></span>";
						
						$view .= "<div class='controls'>".date("d F Y",strtotime($data['CAP_ACC_TRA_DATE']))."</div>";
						
					$view .= "</div>";
										
					$view .= "<div class='span-accounting-view-header default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='number'>Sales Receipt #</label></span>";
						
						$view .= "<div class='controls'>".$data['CAP_ACC_TRA_NUMBER']."</div>";
						
					$view .= "</div>";
					
					$view .= "<div class='span-accounting-view-header default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='number'>Tax</label></span>";
						
						$view .= "<div class='controls'>".ucwords(strtolower($data['FK_CAP_ACC_TRA_GLOBALTAX']))."</div>";
						
					$view .= "</div>";
					
					$view .= "<div class='span-accounting-view-header default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='number'>Currency</label></span>";
						
						$view .= "<div class='controls'>".$data['CAP_ACC_USE_ACC_CUR_NAME']." ".ucwords(strtolower($data['CAP_ACC_CUR_PREFIX']))."</div>";
						
					$view .= "</div>";
																				
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
					
					$view .= "<hr>";
															
					$view .= "</div>";
										
					$view .= "<div class='span12 accounting-".$this->params."-form-table'>";
										
					$view .= "<table class='table accounting-transaction-table-non-sortable table-small-font'>";
					
						$view .= "<thead class='table-header-grey-transaction table-header-bold'>";
						
							$view .= "<tr>";
														    
								$view .= "<td class='table-valign-middle table-align-middle'>Item</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Description</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Qty</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Unit Price</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Disc%</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Account</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Tax</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Amount</td>";
															
							$view .= "</tr>";
						
						$view .= "</thead>";
						
						$view .= "<tbody>";
						
						$c = (int)$data['CAP_ACC_TRA_ROW'];
						
						$i = 0;
						
						$y = 0;

						if (!empty($data['ITEM-TRANSACTION'])):
						
							while ($i != $c):
														
							$i++;

								if ($i == $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_POSITION']):
																
								unset($name); 
								unset($desc); 
								unset($coa); 
								unset($qty);
								unset($cat);
								unset($rate); 
								unset($amou);
								unset($disc);
								unset($discR);
								unset($discN); 
								unset($tax);
								unset($taxR);
								unset($taxA);
								
								$name  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_ITE_NAME'];
								$desc  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_DESC'];
								$coa   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_COA_NAME'];
								$qty   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_QTY'];
								$cat   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_ITE_TYP_NAME'];
								$rate  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_RATE'];
								$amou  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_AMOUNT'];

								$disc  = $data['ITEM-TRANSACTION'][$y]['DISCOUNT'][0]['CAP_ACC_ITE_NAME'];
								$discR = $data['ITEM-TRANSACTION'][$y]['DISCOUNT'][0]['CAP_ACC_TRA_ITE_RATE'];
								$discN = $data['ITEM-TRANSACTION'][$y]['DISCOUNT'][0]['CAP_ACC_TRA_ITE_AMOUNT'];
								
								$tax   = $data['ITEM-TRANSACTION'][$y]['TAX'][0]['CAP_ACC_ITE_NAME'];
								$taxR  = $data['ITEM-TRANSACTION'][$y]['TAX'][0]['CAP_ACC_TRA_ITE_RATE'];
								$taxA  = $data['ITEM-TRANSACTION'][$y]['TAX'][0]['CAP_ACC_TRA_ITE_AMOUNT'];
								
								$name  = (!empty($name)) ? $name : '&nbsp;' ;
								$desc  = (!empty($desc)) ? ucwords(strtolower($desc)) : '&nbsp;' ;
								$coa   = (!empty($coa))  ? ucwords(strtolower($coa)) : '&nbsp;' ;
								$qty   = (!empty($qty))  ? number_format($qty,$this->getDecimalLength($qty)) : null;	
								//$qty   = (!empty($qty))  ? number_format($qty,4) : null;		
																
								$realAmount  = ($rate + (($rate / 100) * $taxR)) * $qty;
								
								$realDiscount = ($realAmount / 100) * $discR;
																
								$realAmount  = $realAmount - $realDiscount;
																
									if (strtoupper($cat) != 'SUB TOTAL'):
																											
									$rate = round($rate,4,PHP_ROUND_HALF_UP);
									
									$rate = (!empty($rate)) ? round($rate,4) : null;
									
									else:
									
									$rate = null;
									
									endif;
								//$discN 	= self::noRoundingDecimal($discN,4); 															
								$discN  = (!empty($discN)) ? round($discN,3,PHP_ROUND_HALF_UP) : 0;
								$discL += (!empty($discN)) ? $discN : 0;
								
								$disc   = (!empty($disc))  ? $disc." (".$discR."%)" : null;
								$tax    = (!empty($tax))   ? $tax." (".$taxR."%)" : null;
								$amou   = (!empty($amou))  ? bcsub($amou,$discN,4) : null;
								//echo $discL.'<br>';round(round($moneyT,4),2,PHP_ROUND_HALF_EVEN)
								$money = round(bcdiv(bcmul($amou,bcadd(100,$taxR,4),4),100,4),4,PHP_ROUND_HALF_EVEN);

								//$money = $money/(100+$taxR)*100;
								$money =round($money/(100+$taxR)*100,4,PHP_ROUND_HALF_EVEN);
								
								list ($fund,$fundd) = explode('.',$money);
						
								$fund   = (!empty($fund))  ?  $fund :  '0';
								$fundd  = (!empty($fundd)) ?  substr($fundd,0,3) :  '00';
								//$funds  = (!empty($fund)) ?  $fund.'.'. substr($fundd,0,2) :  0.00;
								$funds  = (!empty($fund)) ?  $money :  0.00;

								$funds  = round($funds,2,PHP_ROUND_HALF_ODD);
								
								$moneyT += $money;

									if (strtoupper($data['ITEM-TRANSACTION'][$y]['CAP_ACC_ITE_TYP_NAME']) != 'SUB TOTAL'):

									$discT     = (!empty($discN)) ? bcadd($discN,$discT,3) 	: $discT;
									$taxT      = (!empty($taxA))  ? bcadd($taxT,$taxA,3) 		: $taxT;
									$total     = (!empty($amou))  ? bcadd($amou,$total,3) 		: $total;
									$totalSub  = (!empty($amou))  ? bcadd($amou,$totalSub,3) 	: $totalSub;
									$totalTax  = (!empty($taxA))  ? bcadd($taxA,$totalTax,3)	: $totalTax;

									elseif (strtoupper($cat) == 'SUB TOTAL'):

									$funds     = round($totalSub,2,PHP_ROUND_HALF_ODD);
									$totalSub  = 0;
									$totalTax  = 0;
									
									endif;

									$view .= "<tr class='accounting-table-tr-type-one'>";
																	    
									    $view .= "<td class='accounting-table-td-type-six table-valign-middle'>".$name."</td>";
									    								
										$view .= "<td class='accounting-table-td-type-six table-valign-middle'>".$desc."</td>";
										
										$view .= "<td class='accounting-table-td-type-six table-valign-middle table-align-right'>".$qty."</td>";
										
										$view .= "<td class='accounting-table-td-type-six table-valign-middle table-align-right'>".$rate."</td>";
																												
										$view .= "<td class='accounting-table-td-type-six table-valign-middle table-align-middle'>".$disc."</td>";
										
										$view .= "<td class='accounting-table-td-type-six table-valign-middle'>".$coa."</td>";
										
										$view .= "<td class='accounting-table-td-type-six table-valign-middle table-align-middle'>".$tax."</td>";
										
										$view .= "<td class='accounting-table-td-type-six table-valign-middle table-align-right'>".number_format($funds,2)."</td>";
										
									$view .= "</tr>";
									
								$y++;
								
								else:
								
									$view .= "<tr class='accounting-table-tr-type-one'>";
																	    
									    $view .= "<td class='accounting-table-td-type-six table-valign-middle'>&nbsp;</td>";
									    								
										$view .= "<td class='accounting-table-td-type-six table-valign-middle'></td>";
										
										$view .= "<td class='accounting-table-td-type-six table-valign-middle table-align-right'></td>";
										
										$view .= "<td class='accounting-table-td-type-six table-valign-middle table-align-right'></td>";
										
										$view .= "<td class='accounting-table-td-type-six table-valign-middle table-align-middle'></td>";
										
										$view .= "<td class='accounting-table-td-type-six table-valign-middle'></td>";
										
										$view .= "<td class='accounting-table-td-type-six table-valign-middle table-align-middle'></td>";
										
										$view .= "<td class='accounting-table-td-type-six table-valign-middle table-align-right'></td>";
										
									$view .= "</tr>";
								
								endif;
							
							endwhile;
						
						endif;
						
						$grandTotal = number_format(round(bcadd($moneyT,$taxT,3),3,PHP_ROUND_HALF_EVEN),2);
						
						$grandSubTotal = (!empty($moneyT)) ?  number_format($moneyT,2) :  number_format($total,2);
						
						//list ($fund,$fundd) = explode('.',$taxT);
						
						//$fund   = (!empty($fund))  ?  $fund :  '0';
						//$fundd  = (!empty($fundd)) ?  substr($fundd,0,2) :  '00';
						//$taxT  = (!empty($fund)) ?  number_format($fund).'.'. substr($fundd,0,2) :  0.00;
																		
						$view .= "</tbody>";
						
						$view .= "<tfoot>";

							if (!empty($discL)):  
							
							$view .= "<tr class='accounting-table-tr-type-six'><td colspan='7' class='table-valign-middle table-align-right'><span class='accounting-foot-discount'>(include discount ". number_format($discL,2) .") </span> Sub Total</td><td class='table-align-right accounting-foot-subtotal'>".$grandSubTotal."</td></tr>";
							
							else:
							
							$view .= "<tr class='accounting-table-tr-type-six'><td colspan='7' class='table-valign-middle table-align-right'><span class='accounting-foot-discount'></span> Sub Total</td><td class='table-align-right accounting-foot-subtotal'>".$grandSubTotal."</td></tr>";
							
							endif;
							
					
														
							$view .= "<tr class='accounting-table-tr-type-six'><td colspan='7' class='table-valign-middle table-align-right'>Vat</td><td class='table-align-right accounting-foot-tax'>".number_format($taxT,2)."</td></tr>";
							
							$view .= "<tr class='accounting-table-tr-type-six'><td colspan='7' class='table-valign-middle table-align-right'>Grand Total</td><td class='table-align-right accounting-foot-total'>".$grandTotal."</td></tr>";
																				
						$view .= "</tfoot>";
						
					$view .= "</table>";
										
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
				
				$view .= "<br>";

	    		$view .= "</form>";
	    			    			    			    		
	    	$view .= "</div>";
	    
	    $view .= "</div>";
	    
	return $view;
		    
    }
    
    public function form_editSalesReceipt() {
	    
	    $item   = json_decode($this->getItem(), true);
	    
	    $coa    = json_decode($this->getCoa(), true);
	    
	    $acccur = json_decode($this->getCurrencyAccount(),true);
	    
	    $user 	= unserialize($_SESSION['user']);
	    
    	$id		= $user->getID();

    	$cus	= json_decode($this->getContactCustomer($id),true);
    	
    	$data   = json_decode($this->getSalesReceiptByID(),true);

	    //print_r($data);
	    	    	    
	    if (!empty($cus)):
	    	
    		foreach ($cus as $key => $value):
    		
    		$selected  = ($data['CAP_ACC_CON_ID'] == $value['CAP_ACC_CON_ID']) ? "selected='selected'" : null;
    		
    		$customer .= "<option $selected value='".$value['CAP_ACC_CON_ID']."'>".ucwords(strtolower($value['CAP_ACC_CON_CONTACT']))."</option>";
    		
    		endforeach;
	    	
	   endif;
	    
    	if (!empty($acccur)):
    	
    		foreach ($acccur as $key => $value):
    		
    		$selected  = ($data['FK_CAP_ACC_TRA_CURRENCY'] == $value['CAP_ACC_USE_ACC_CUR_ID']) ? "selected='selected'" : null;
    		
    		$currency .= "<option $selected value='".$value['CAP_ACC_USE_ACC_CUR_ID']."'>".$value['CAP_ACC_CUR_NAME']." ".$value['CAP_ACC_CUR_PREFIX']."</option>";
    		
    		endforeach;
    	
    	endif;
	    
	    	if (!empty($item)):
	    	
	    		foreach ($item as $key => $value):
	    		
	    			if ($value['CAP_ACC_ITE_TYP_NAME'] == 'TAX'):
	    			
	    			$itemTax [] = [
	    			
	    			"id"    => $value['CAP_ACC_ITE_ID'],
	    			"label" => $value['CAP_ACC_ITE_NAME'],
	    			"rate"  => $value['COA-SELLING'][0]['CAP_ACC_ITE_COA_RATE']
	    			
	    			];
	    				    			
	    			endif;
	    			
	    			if ($value['CAP_ACC_ITE_TYP_NAME'] == 'DISCOUNT'):
	    			
	    			$itemDisc [] = [
	    			
	    			"id"    => $value['CAP_ACC_ITE_ID'],
	    			"label" => $value['CAP_ACC_ITE_NAME'],
	    			"rate"  => $value['COA-SELLING'][0]['CAP_ACC_ITE_COA_RATE']
	    			
	    			];
	    			
	    			endif;
	    		
	    		endforeach;
	    
		    	foreach ($item as $key => $value):
		    	
		    	unset($taxInfo);
		    	
		    	$phpItem .= "<option value='".$value['CAP_ACC_ITE_ID']."'>".$value['CAP_ACC_ITE_NAME']."</option>";
		    	
		    	if (!empty($value['COA-SELLING'][0]['FK_CAP_ACC_ITE_TAX_ID'])):
		    	
		    	$i = 0;
		    	
		    		foreach ($itemTax as $taxKey => $taxValue):

		    			if ($value['COA-SELLING'][0]['FK_CAP_ACC_ITE_TAX_ID'] == $taxValue['id']): 
		    			
		    			$taxInfo = $itemTax[$i]; break; 
		    			
		    			endif;
		    		
		    		$i++;
		    		
		    		endforeach;

		    	endif;
		    	
		    	$autoCompleteItem [] = [
		    	
		    	"id"		=> $value['CAP_ACC_ITE_ID'],
		    	"label" 	=> $value['CAP_ACC_ITE_NAME'],
		    	"desc" 		=> $value['CAP_ACC_ITE_DESC'],
		    	"price" 	=> $value['COA-SELLING'][0]['CAP_ACC_ITE_COA_RATE'],
		    	"category" 	=> ucwords(strtolower($value['CAP_ACC_ITE_TYP_NAME'])),
		    	"account"	=> ucwords(strtolower($value['COA-SELLING'][0]['CAP_ACC_COA_NAME'])),
		    	"accountid"	=> $value['COA-SELLING'][0]['FK_CAP_ACC_COA_ID'],
		    	"taxid"		=> $taxInfo['id'],
		    	"taxname"	=> $taxInfo['label'],
		    	"taxrate"	=> $taxInfo['rate']
		    	
		    	];
		    			    	
		    	endforeach;
	    	
	    	endif;
	    		    	
	    	if (!empty($coa)):
	    	
	    		foreach ($coa as $key => $value):
	    		
	    		$phpCoa .= "<option value='".$value['CAP_ACC_ITE_ID']."'>".$value['CAP_ACC_ITE_NAME']."</option>";
	    			
	    		$autoCompleteCoa [] = [
		    	
		    	"id"		=> $value['CAP_ACC_COA_ID'],
		    	"label" 	=> ucwords(strtolower($value['CAP_ACC_COA_NAME'])),
		    	"desc" 		=> $value['CAP_ACC_COA_DESC'],
		    	"category" 	=> ucwords(strtolower($value['CAP_ACC_COA_TYP_NAME']))
		    	
		    	];
		    	
			    	if ($value['CAP_ACC_COA_TYP_NAME'] == 'BANK'):

			    	$accReceivable .= "<option value='".$value['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value['CAP_ACC_COA_NAME']))."</option>";

			    	endif;
	    		
	    		endforeach;
	    	
	    	endif;

	    $view .= "<script type='text/javascript'>";
	    	    	
	    	$view .= "function accountingInvoiceItem() {";
	    	
	    		$view .= "return ".json_encode($autoCompleteItem);
	    	
	    	$view .= "}";
	    		    	
	    	$view .= "function accountingInvoiceCoa() {";
	    	
	    		$view .= "return ".json_encode($autoCompleteCoa);
	    	
	    	$view .= "}";
	    	
	    	$view .= "function accountingInvoiceTax() {";
	    	
	    		$view .= "return ".json_encode($itemTax);
	    	
	    	$view .= "}";
	    	
	    	$view .= "function accountingInvoiceDiscount() {";
	    	
	    		$view .= "return ".json_encode($itemDisc);
	    	
	    	$view .= "}";
	    
	    $view .= "</script>";
	    	    
	    $crypt = encryption::urlHashEncodingRinjndael($_SESSION['xss'],$data['CAP_ACC_TRA_ID']);
	    
	    $view .= "<div class='row accounting-".$this->params."-container'>";
	    
	    $view .= "<div class='span12'>";
	    
	    	$view .= "<h2 class=''>Edit Sales Receipt</h2>";
	    
	    $view .= "</div>";
	    
	    	$view .= "<div class='span12 accounting-".$this->params."-formContainer'>";
	    		
	    	$view .= "<input id='capsuleCSRFToken' type='hidden' value='".$_SESSION['xss']."'>";
	    		    		
	    		$view .= "<form id='accounting-".$this->params."-form' data-form-type='invoice'>";
	    			    			
	    			$view .= "<div class='accounting-".$this->params."-form-transaction'>";
	    			
	    			$view .= "<input id='transaction-pid' type='hidden' value='".$data['CAP_ACC_TRA_ID']."'>";
	    				    			
	    			$view .= "<div class='accounting-".$this->params."-form-top'>";
	    		
	    			$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='name'>To</label></span>";
						
						$view .= "<div class='controls'><select id='customer-id' class='span2 accounting-chosen'><option></option>$customer</select></div>";
																	
					$view .= "</div>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='account'>Account</label></span>";
						
						$view .= "<div class='controls'><select id='account' class='span2 accounting-chosen'>".$accReceivable."</select></div>";
																														
					$view .= "</div>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='date'>Date</label></span>";
						
						$view .= "<div class='controls'><input class='accounting-date-".md5(rand(0,100))." input-medium' type='text' id='date' value='".date("d-m-Y",strtotime($data['CAP_ACC_TRA_DATE']))."'></div>";
						
					$view .= "</div>";
										
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='number'>Sales Receipt #</label></span>";
						
						$view .= "<div class='controls'><input class='input-large' type='text' id='number' value='".$data['CAP_ACC_TRA_NUMBER']."'></div>";
						
					$view .= "</div>";
					
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
					
					$view .= "<hr>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='currency'>Currency</label></span>";
						
						$view .= "<div class='controls'><select id='currency' class='span2 accounting-chosen'>".$currency."</select></div>";
						
					$view .= "</div>";
					
					$view .= "<div class='default-control-right'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='globaltax'>Tax</label></span>";
						
						if ($data['FK_CAP_ACC_TRA_GLOBALTAX'] == 'include'):
						
						$globalTaxOption = "<option value='exclude'>Tax Exclude</option><option selected='selected' value='include'>Tax Include</option><option value='nontaxable'>Non Taxable</option>";
						
						elseif ($data['FK_CAP_ACC_TRA_GLOBALTAX'] == 'exclude'):
						
						$globalTaxOption = "<option selected='selected' value='exclude'>Tax Exclude</option><option value='include'>Tax Include</option><option value='nontaxable'>Non Taxable</option>";
						
						else:
						
						$globalTaxOption = "<option value='exclude'>Tax Exclude</option><option value='include'>Tax Include</option><option selected='selected' value='nontaxable'>Non Taxable</option>";
						
						endif;
						
						$view .= "<div class='controls'><select id='globaltax' class='span2 accounting-chosen'>$globalTaxOption</select></div>";
						
					$view .= "</div>";
					
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
					
					$view .= "<br>";
					
					$view .= "<div class='span12 accounting-".$this->params."-form-table'>";
										
					$view .= "<table class='table accounting-transaction-table table-small-font'>";
					
						$view .= "<thead class='table-header-blue-transaction table-header-bold'>";
						
							$view .= "<tr>";
							
							    $view .= "<td class='table-valign-middle table-align-middle'></td>";
							    
								$view .= "<td class='table-valign-middle table-align-middle'>Item</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Description</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Qty</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Unit Price</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Disc%</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Account</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Tax</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Amount</td>";
								
								$view .= "<td></td>";
							
							$view .= "</tr>";
						
						$view .= "</thead>";
						
						$view .= "<tbody>";
						
						$c = (int) $data['CAP_ACC_TRA_ROW'];
						
						$i = 0;
						
						$y = 0;
						
						if (!empty($data['ITEM-TRANSACTION'])):
						
							while ($i != $c):
														
							$i++;

								if ($i == $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_POSITION']):
								
								unset($name); unset($desc); unset($coa); unset($rate); unset($qty); unset($disc); unset($tax); unset($amou);
								
								unset($name); 
								unset($desc); 
								unset($coa); 
								unset($qty);
								unset($cat);
								unset($rate); 
								unset($amou);
								
								$pid   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_ID'];
								$id    = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_ITE_ID'];
								$name  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_ITE_NAME'];
								$desc  = ucwords(strtolower($data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_DESC']));
								$coa   = ucwords(strtolower($data['ITEM-TRANSACTION'][$y]['CAP_ACC_COA_NAME']));
								$coaID = $data['ITEM-TRANSACTION'][$y]['FK_CAP_ACC_COA_ID'];
								$qty   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_QTY'];
								$cat   = ucwords(strtolower($data['ITEM-TRANSACTION'][$y]['CAP_ACC_ITE_TYP_NAME']));

								$discN 		 = (!empty($data['ITEM-TRANSACTION'][$y]['DISCOUNT'])) ? $data['ITEM-TRANSACTION'][$y]['DISCOUNT'][0]['CAP_ACC_TRA_ITE_AMOUNT'] : 0;
								$discL		+= (!empty($data['ITEM-TRANSACTION'][$y]['DISCOUNT'])) ? $data['ITEM-TRANSACTION'][$y]['DISCOUNT'][0]['CAP_ACC_TRA_ITE_AMOUNT'] : 0;
								
								$discPID     = (!empty($data['ITEM-TRANSACTION'][$y]['DISCOUNT'])) ? $data['ITEM-TRANSACTION'][$y]['DISCOUNT'][0]['CAP_ACC_TRA_ITE_ID'] : null ;
								$discID		 = (!empty($data['ITEM-TRANSACTION'][$y]['DISCOUNT'])) ? $data['ITEM-TRANSACTION'][$y]['DISCOUNT'][0]['CAP_ACC_ITE_ID'] : null;
								$discDisplay = (!empty($data['ITEM-TRANSACTION'][$y]['DISCOUNT'])) ? $data['ITEM-TRANSACTION'][$y]['DISCOUNT'][0]['CAP_ACC_ITE_NAME'] : null;
								$discValue   = (!empty($data['ITEM-TRANSACTION'][$y]['DISCOUNT'])) ? $data['ITEM-TRANSACTION'][$y]['DISCOUNT'][0]['CAP_ACC_TRA_ITE_RATE'] : null;
								
								$taxPID      = (!empty($data['ITEM-TRANSACTION'][$y]['TAX'])) ? $data['ITEM-TRANSACTION'][$y]['TAX'][0]['CAP_ACC_TRA_ITE_ID'] : null ;
								$taxID		 = (!empty($data['ITEM-TRANSACTION'][$y]['TAX'])) ? $data['ITEM-TRANSACTION'][$y]['TAX'][0]['CAP_ACC_ITE_ID'] : null;
								$taxDisplay  = (!empty($data['ITEM-TRANSACTION'][$y]['TAX'])) ? $data['ITEM-TRANSACTION'][$y]['TAX'][0]['CAP_ACC_ITE_NAME'] : null;
								$taxValue    = (!empty($data['ITEM-TRANSACTION'][$y]['TAX'])) ? $data['ITEM-TRANSACTION'][$y]['TAX'][0]['CAP_ACC_TRA_ITE_RATE'] : null;
								
									if (strtoupper($data['ITEM-TRANSACTION'][$y]['CAP_ACC_ITE_TYP_NAME']) != 'SUB TOTAL'):
										
										$rateAdd  = round(bcdiv(bcmul($data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_AMOUNT'],$taxValue,4),100,4),2);
										$rateAddT = round(bcdiv(bcmul($data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_RATE'],$taxValue,4),100,4),2);
										
										if ($data['FK_CAP_ACC_TRA_GLOBALTAX'] == 'include'):
										
										$rate    = (!empty($data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_RATE'])) ? round(bcadd($data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_RATE'],$rateAddT,3),2) : null;
										
										else:
										
										$rate    = (!empty($data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_RATE'])) ? round($data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_RATE'],2) : null;
										
										endif;
										
									endif;
									
									if ($data['FK_CAP_ACC_TRA_GLOBALTAX'] == 'include'):
								
									$amou = (!empty($data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_AMOUNT'])) ? $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_AMOUNT']+$rateAdd : null;
									
									else:
									
									$amou = (!empty($data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_AMOUNT'])) ? $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_AMOUNT'] : null;
									
									endif;
								
									if (!empty($discValue)):
									
										if ($data['FK_CAP_ACC_TRA_GLOBALTAX'] == 'include'):
																												
										$discAddS += round(($rate*$qty) * $discValue / 100,2);
										
										$amou 	   = $rate*$qty - (($rate*$qty) * $discValue / 100);
										
										else:
										
										$discAdd   = bcdiv(bcmul($amou,$discValue,4),100,4);
																			
										$discAddS += round(bcdiv(bcmul($amou,$discValue,4),100,4),3);
										$amou 	   = (!empty($amou)) ? bcsub($amou,$discAdd,4) : null;
										
										endif;
																		
									else:
									
									$amou = (!empty($data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_AMOUNT'])) ? $amou : null;
									
									endif;
																
									if (strtoupper($data['ITEM-TRANSACTION'][$y]['CAP_ACC_ITE_TYP_NAME']) != 'SUB TOTAL'):
									
									$discT 	  += (!empty($data['ITEM-TRANSACTION'][$y]['DISCOUNT'])) ? $data['ITEM-TRANSACTION'][$y]['DISCOUNT'][0]['CAP_ACC_TRA_ITE_AMOUNT'] : 0;
									$taxT     += (!empty($data['ITEM-TRANSACTION'][$y]['TAX'])) ? $data['ITEM-TRANSACTION'][$y]['TAX'][0]['CAP_ACC_TRA_ITE_AMOUNT'] : 0;
									$total    += (!empty($data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_AMOUNT'])) ? $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_AMOUNT'] : 0;
									$totalSub += (!empty($data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_AMOUNT'])) ? str_replace(',','',$amou) : 0;
									$totalTax += (!empty($data['ITEM-TRANSACTION'][$y]['TAX'])) ? $data['ITEM-TRANSACTION'][$y]['TAX'][0]['CAP_ACC_TRA_ITE_AMOUNT'] : 0;
									$totalBot += $amou;
									$totalTxx += (!empty($data['ITEM-TRANSACTION'][$y]['TAX'])) ? $data['ITEM-TRANSACTION'][$y]['TAX'][0]['CAP_ACC_TRA_ITE_AMOUNT'] : 0;
									
										if ($data['FK_CAP_ACC_TRA_GLOBALTAX'] == 'include'):
										
										$grandTotal  = $totalBot;
										
										elseif ($data['FK_CAP_ACC_TRA_GLOBALTAX'] == 'exclude'):

										$grandTotal  = $totalBot+$totalTxx;
										
										else:
										
										$grandTotal  = $totalBot;
										
										endif;
									
									elseif (strtoupper($data['ITEM-TRANSACTION'][$y]['CAP_ACC_ITE_TYP_NAME']) == 'SUB TOTAL'):
									
									$amou     = $totalSub;
									$discL    = 0;
									$totalSub = 0;
									$totalTax = 0;
									
									endif;
																												
									$view .= "<tr class='accounting-table-tr-type-one accounting-salesreceipt-item-row'>";
									
										$view .= "<td class='accounting-table-td-type-three'><i class='icon-align-justify'></i><input id='item-pid' class='accounting-item-pid' type='hidden' value='$pid'><input id='id' class='accounting-item-id' type='hidden' value='$id'><input id='accounting-item-category' class='accounting-item-category' type='hidden' value='$cat'></td>";
										
										 $view .= "<td class='accounting-table-td-type-one accounting-item'><input class='accounting-table-input-type-three' type='text' id='item' value='$name'></td>";
										 
										 $view .= "<td class='accounting-table-td-type-one accounting-description'><input class='accounting-table-input-type-two' type='text' id='description' value='$desc'></td>";
										 
										 $view .= "<td class='accounting-table-td-type-one accounting-qty'><input class='accounting-table-input-type-one input-align-right' type='text' id='qty' value='$qty'></td>";
										 
										 $view .= "<td class='accounting-table-td-type-one accounting-price'><input class='accounting-table-input-type-one input-align-right' type='text' id='price' value='$rate'></td>";
										 
										 $view .= "<td class='accounting-table-td-type-one accounting-discount'><input class='accounting-table-input-type-one input-align-right accounting-discount-display' type='text' value='$discDisplay'><input class='accounting-discount-pid' id='discount-pid' type='hidden' value='$discPID'><input class='accounting-discount-id' id='discount-id' type='hidden' value='$discID'><input class='accounting-discount-value' type='hidden' id='discount' value='$discValue'></td>";
										 
										 $view .= "<td class='accounting-table-td-type-one accounting-account'><input class='accounting-table-input-type-one accounting-account-display' type='text' value='$coa'><input class='accounting-account-value' type='hidden' id='account' value='$coaID'></td>";
										 
										 $view .= "<td class='accounting-table-td-type-one accounting-tax'><input class='accounting-table-input-type-one input-align-right accounting-tax-display' type='text' value='$taxDisplay'><input class='accounting-tax-pid' id='tax-pid' type='hidden' value='$taxPID'><input class='accounting-tax-id' id='tax-id' type='hidden' value='$taxID'><input class='accounting-tax-value' type='hidden' id='tax' value='$taxValue'></td>";
										 
										$view .= "<td class='accounting-table-td-type-five accounting-amount'><input disabled='disabled' class='accounting-table-input-type-four input-align-right' type='text' id='amount' value='".number_format($amou,2)."'><input type='hidden' class='amount-js' value=''></td>";
										
										$view .= "<td class='accounting-table-td-type-last '><input type='hidden' id='position' value=''><i class='icon-remove-circle accounting-table-del-line accounting-table-delete-invoice'></i></td>";																																																						
									$view .= "</tr>";
									
								$y++;
								
								else:
								
										$view .= "<tr class='accounting-table-tr-type-one accounting-salesreceipt-item-row'>";
									
										$view .= "<td class='accounting-table-td-type-three'><i class='icon-align-justify'></i><input id='id' class='accounting-item-id' type='hidden' value=''><input id='accounting-item-category' class='accounting-item-category' type='hidden' value=''></td>";
										
										 $view .= "<td class='accounting-table-td-type-one accounting-item'><input class='accounting-table-input-type-three' type='text' id='item' value=''></td>";
										 
										 $view .= "<td class='accounting-table-td-type-one accounting-description'><input class='accounting-table-input-type-two' type='text' id='description' value=''></td>";
										 
										 $view .= "<td class='accounting-table-td-type-one accounting-qty'><input class='accounting-table-input-type-one input-align-right' type='text' id='qty' value=''></td>";
										 
										 $view .= "<td class='accounting-table-td-type-one accounting-price'><input class='accounting-table-input-type-one input-align-right' type='text' id='price' value=''></td>";
										 
										 $view .= "<td class='accounting-table-td-type-one accounting-discount'><input class='accounting-table-input-type-one input-align-right accounting-discount-display' type='text' value=''><input class='accounting-discount-id' id='discount-id' type='hidden' value=''><input class='accounting-discount-value' type='hidden' id='discount' value=''></td>";
										 
										 $view .= "<td class='accounting-table-td-type-one accounting-account'><input class='accounting-table-input-type-one accounting-account-display' type='text' value=''><input class='accounting-account-value' type='hidden' id='account' value=''></td>";
										 
										 $view .= "<td class='accounting-table-td-type-one accounting-tax'><input class='accounting-table-input-type-one input-align-right accounting-tax-display' type='text' value=''><input class='accounting-tax-id' id='tax-id' type='hidden' value=''><input class='accounting-tax-value' type='hidden' id='tax' value=''></td>";
										 
										$view .= "<td class='accounting-table-td-type-five accounting-amount'><input disabled='disabled' class='accounting-table-input-type-four input-align-right' type='text' id='amount' value=''><input type='hidden' class='amount-js' value=''></td>";
										
										$view .= "<td class='accounting-table-td-type-last '><input type='hidden' id='position' value=''><i class='icon-remove-circle accounting-table-del-line accounting-table-delete-invoice'></i></td>";																																																						
									$view .= "</tr>";
								
								endif;
														
							endwhile;
						
						else:
						
						$view .= "<tr class='accounting-table-tr-type-one accounting-salesreceipt-item-row'>";
									
										$view .= "<td class='accounting-table-td-type-three'><i class='icon-align-justify'></i><input id='id' class='accounting-item-id' type='hidden' value=''><input id='accounting-item-category' class='accounting-item-category' type='hidden' value=''></td>";
										
										 $view .= "<td class='accounting-table-td-type-one accounting-item'><input class='accounting-table-input-type-three' type='text' id='item' value=''></td>";
										 
										 $view .= "<td class='accounting-table-td-type-one accounting-description'><input class='accounting-table-input-type-two' type='text' id='description' value=''></td>";
										 
										 $view .= "<td class='accounting-table-td-type-one accounting-qty'><input class='accounting-table-input-type-one input-align-right' type='text' id='qty' value=''></td>";
										 
										 $view .= "<td class='accounting-table-td-type-one accounting-price'><input class='accounting-table-input-type-one input-align-right' type='text' id='price' value=''></td>";
										 
										 $view .= "<td class='accounting-table-td-type-one accounting-discount'><input class='accounting-table-input-type-one input-align-right accounting-discount-display' type='text' value=''><input class='accounting-discount-id' id='discount-id' type='hidden' value=''><input class='accounting-discount-value' type='hidden' id='discount' value=''></td>";
										 
										 $view .= "<td class='accounting-table-td-type-one accounting-account'><input class='accounting-table-input-type-one accounting-account-display' type='text' value=''><input class='accounting-account-value' type='hidden' id='account' value=''></td>";
										 
										 $view .= "<td class='accounting-table-td-type-one accounting-tax'><input class='accounting-table-input-type-one input-align-right accounting-tax-display' type='text' value=''><input class='accounting-tax-id' id='tax-id' type='hidden' value=''><input class='accounting-tax-value' type='hidden' id='tax' value=''></td>";
										 
										$view .= "<td class='accounting-table-td-type-five accounting-amount'><input disabled='disabled' class='accounting-table-input-type-four input-align-right' type='text' id='amount' value=''><input type='hidden' class='amount-js' value=''></td>";
										
										$view .= "<td class='accounting-table-td-type-last '><input type='hidden' id='position' value=''><i class='icon-remove-circle accounting-table-del-line accounting-table-delete-invoice'></i></td>";																																																						
									$view .= "</tr>";
						
						endif;
						
						$view .= "</tbody>";
						
						$view .= "<tfoot>";
							
							if (!empty($discAddS)):
							
							$view .= "<tr class='accounting-table-tr-type-two'><td colspan='8' class='table-valign-middle table-align-right'><span class='accounting-foot-discount'>(Include discount ".number_format($discAddS,2).")</span> Sub Total</td><td class='table-align-right accounting-foot-subtotal'>".number_format($totalBot,2)."</td><td></td></tr>";
							
							else:
							
							$view .= "<tr class='accounting-table-tr-type-two'><td colspan='8' class='table-valign-middle table-align-right'><span class='accounting-foot-discount'></span> Sub Total</td><td class='table-align-right accounting-foot-subtotal'>".number_format($totalBot,2)."</td><td></td></tr>";
							
							endif;
																					
							$view .= "<tr class='accounting-table-tr-type-two'><td colspan='8' class='table-valign-middle table-align-right'>Vat</td><td class='table-align-right accounting-foot-tax'>".number_format($totalTxx,2)."</td><td></td></tr>";
							
							$view .= "<tr class='accounting-table-tr-type-two'><td colspan='8' class='table-valign-middle table-align-right'>Grand Total</td><td class='table-align-right accounting-foot-total'>".number_format($grandTotal,2)."</td><td></td></tr>";
																				
						$view .= "</tfoot>";
						
					$view .= "</table>";
					
					$view .= "<a class='pull-left btn btn-mini accounting-table-add-newline'><i class='icon-circle-arrow-right'></i> Add a new line</a>";
					
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
				
				$view .= "<br>";
				
				$view .= "<div class='accounting-action-final'>";
				
				$view .= "<div class='accounting-action-final-container'>";
				
					$view .= "<div class='pull-right default-control-form-final'>";
				
						$view .= "<button type='button' id='accounting-salesreceipt-submit-edit' class='btn btn-small btn-success' data-loading-text='Please Wait...'><i class='icon-ok icon-white'></i> Update & Back</button>";
						
					$view .= "</div>";
										
					$view .= "<div class='pull-right default-control-form-final'>";
	    		
						$view .= "<a href='".$this->url->builder(3561,'transaction')."' class='btn btn-small'><i class='icon-remove'></i> Cancel</a>";
						
					$view .= "</div>";
	    		
	    		$view .= "</div>";
	    		
	    		$view .= "</div>";
					
	    		$view .= "</form>";
	    			    			    			    		
	    	$view .= "</div>";
	    
	    $view .= "</div>";
	    
	return $view;
		    
    }
    
    public function form_receipt_controller() {
	    
	    $view   = $this->optionGear;
	    
	    $actio  = explode('|||',$_GET['actio']);
	    
	    $key    = $_GET['emblem'];
	    
	    $words  = $actio[0];
	    
	    $rjand  = encryption::urlHashDecodingRinjndael($key,$actio[2]);
	    
			if (!is_numeric($rjand)):

			//header('Location: http://www.asacreative.com');

			endif;
	    
		if ($words == 'new'): 
		
			echo $this->form_createReceipt(); 
		
		elseif ($words == 'view'):
			
			$this->data = $rjand;
						
			echo $this->form_viewReceipt();
			
		elseif ($words == 'edit'):
		
			$this->data = $rjand;
		
			echo $this->form_editReceipt();
		
		endif;
	
    }
    
    public function form_createReceipt() {
	    
	    $item   = json_decode($this->getItem(), true);
	    
	    $coa    = json_decode($this->getCoa(), true);
	    
	    $acccur = json_decode($this->getCurrencyAccount(),true);
	    
	    $user 	= unserialize($_SESSION['user']);
	    
    	$id		= $user->getID();

    	$cus	= json_decode($this->getContactCustomer($id),true);
	    	    	    
	    	if (!empty($cus)):
	    	
	    		foreach ($cus as $key => $value):
	    		
	    		$customer .= "<option value='".$value['CAP_ACC_CON_ID']."'>".ucwords(strtolower($value['CAP_ACC_CON_CONTACT']))."</option>";
	    		
	    		endforeach;
	    	
	    	endif;
	    
	    	if (!empty($acccur)):
	    	
	    		foreach ($acccur as $key => $value):
	    		
	    		$currency .= "<option value='".$value['CAP_ACC_USE_ACC_CUR_ID']."'>".$value['CAP_ACC_CUR_NAME']." ".$value['CAP_ACC_CUR_PREFIX']."</option>";
	    		
	    		endforeach;
	    	
	    	endif;
	    
	    	if (!empty($item)):
	    	
	    		foreach ($item as $key => $value):
	    		
	    			if ($value['CAP_ACC_ITE_TYP_NAME'] == 'TAX'):
	    			
	    			$itemTax [] = [
	    			
	    			"id"    => $value['CAP_ACC_ITE_ID'],
	    			"label" => $value['CAP_ACC_ITE_NAME'],
	    			"rate"  => $value['COA-PURCHASE'][0]['CAP_ACC_ITE_COA_RATE']
	    			
	    			];
	    				    			
	    			endif;
	    			
	    			if ($value['CAP_ACC_ITE_TYP_NAME'] == 'DISCOUNT'):
	    			
	    			$itemDisc [] = [
	    			
	    			"id"    => $value['CAP_ACC_ITE_ID'],
	    			"label" => $value['CAP_ACC_ITE_NAME'],
	    			"rate"  => $value['COA-PURCHASE'][0]['CAP_ACC_ITE_COA_RATE']
	    			
	    			];
	    			
	    			endif;
	    		
	    		endforeach;
	    
		    	foreach ($item as $key => $value):
		    	
		    	unset($taxInfo);
		    	
		    	$phpItem .= "<option value='".$value['CAP_ACC_ITE_ID']."'>".$value['CAP_ACC_ITE_NAME']."</option>";
		    	
		    	if (!empty($value['COA-PURCHASE'][0]['FK_CAP_ACC_ITE_TAX_ID'])):
		    	
		    	$i = 0;
		    	
		    		foreach ($itemTax as $taxKey => $taxValue):

		    			if ($value['COA-PURCHASE'][0]['FK_CAP_ACC_ITE_TAX_ID'] == $taxValue['id']): 
		    			
		    			$taxInfo = $itemTax[$i]; break; 
		    			
		    			endif;
		    		
		    		$i++;
		    		
		    		endforeach;

		    	endif;
		    	
		    	$autoCompleteItem [] = [
		    	
		    	"id"		=> $value['CAP_ACC_ITE_ID'],
		    	"label" 	=> $value['CAP_ACC_ITE_NAME'],
		    	"desc" 		=> $value['CAP_ACC_ITE_DESC'],
		    	"price" 	=> $value['COA-PURCHASE'][0]['CAP_ACC_ITE_COA_RATE'],
		    	"category" 	=> ucwords(strtolower($value['CAP_ACC_ITE_TYP_NAME'])),
		    	"account"	=> ucwords(strtolower($value['COA-PURCHASE'][0]['CAP_ACC_COA_NAME'])),
		    	"accountid"	=> $value['COA-PURCHASE'][0]['FK_CAP_ACC_COA_ID'],
		    	"taxid"		=> $taxInfo['id'],
		    	"taxname"	=> $taxInfo['label'],
		    	"taxrate"	=> $taxInfo['rate']
		    	
		    	];
		    			    	
		    	endforeach;
	    	
	    	endif;
	    		    	
	    	if (!empty($coa)):
	    	
	    		foreach ($coa as $key => $value):
	    		
	    		$phpCoa .= "<option value='".$value['CAP_ACC_ITE_ID']."'>".$value['CAP_ACC_ITE_NAME']."</option>";
	    			
	    		$autoCompleteCoa [] = [
		    	
		    	"id"		=> $value['CAP_ACC_COA_ID'],
		    	"label" 	=> ucwords(strtolower($value['CAP_ACC_COA_NAME'])),
		    	"desc" 		=> $value['CAP_ACC_COA_DESC'],
		    	"category" 	=> ucwords(strtolower($value['CAP_ACC_COA_TYP_NAME']))
		    	
		    	];
		    	
			    	if ($value['CAP_ACC_COA_TYP_NAME'] == 'BANK'):

			    	$accReceivable .= "<option value='".$value['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value['CAP_ACC_COA_NAME']))."</option>";

			    	endif;
	    		
	    		endforeach;
	    	
	    	endif;

	    $view .= "<script type='text/javascript'>";
	    	    	
	    	$view .= "function accountingInvoiceItem() {";
	    	
	    		$view .= "return ".json_encode($autoCompleteItem);
	    	
	    	$view .= "}";
	    		    	
	    	$view .= "function accountingInvoiceCoa() {";
	    	
	    		$view .= "return ".json_encode($autoCompleteCoa);
	    	
	    	$view .= "}";
	    	
	    	$view .= "function accountingInvoiceTax() {";
	    	
	    		$view .= "return ".json_encode($itemTax);
	    	
	    	$view .= "}";
	    	
	    	$view .= "function accountingInvoiceDiscount() {";
	    	
	    		$view .= "return ".json_encode($itemDisc);
	    	
	    	$view .= "}";
	    
	    $view .= "</script>";
	    
	    //$view .= $this->optionGear;
	    
	    $view .= "<div class='row accounting-".$this->params."-container'>";
	    
	    $view .= "<div class='span12'>";
	    
	    	$view .= "<h2 class=''>New Receipt</h2>";
	    
	    $view .= "</div>";
	    
	    	$view .= "<div class='span12 accounting-".$this->params."-formContainer'>";
	    		
	    	$view .= "<input id='capsuleCSRFToken' type='hidden' value='".$_SESSION['xss']."'>";
	    		
	    		$view .= "<form id='accounting-".$this->params."-form' data-form-type='receipt'>";
	    			
	    			$view .= "<div class='accounting-".$this->params."-form-transaction'>";
	    			
	    			$view .= "<div class='accounting-".$this->params."-form-top'>";
	    		
	    			$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='name'>From</label></span>";
						
						$view .= "<div class='controls'><select id='customer-id' class='span2 accounting-chosen'><option></option>$customer</select></div>";
																	
					$view .= "</div>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='account'>Account</label></span>";
						
						$view .= "<div class='controls'><select id='account' class='span2 accounting-chosen'>".$accReceivable."</select></div>";
																														
					$view .= "</div>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='date'>Date</label></span>";
						
						$view .= "<div class='controls'><input class='accounting-date-".md5(rand(0,100))." input-medium' type='text' id='date' value='".$data['CAP_ACC_ITE_NAME']."'></div>";
						
					$view .= "</div>";
										
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='number'>Reference #</label></span>";
						
						$view .= "<div class='controls'><input class='input-medium' type='text' id='number' value='".$item['CAP_ACC_ITE_NAME']."'></div>";
						
					$view .= "</div>";
																				
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
					
					$view .= "<hr>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='currency'>Currency</label></span>";
						
						$view .= "<div class='controls'><select id='currency' class='span2 accounting-chosen'>".$currency."</select></div>";
						
					$view .= "</div>";
										
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
					
					$view .= "<br>";
					
					$view .= "<div class='span12 accounting-".$this->params."-form-table'>";
					
					$view .= "<div id='accounting-".$this->params."-table'>";
    	
			    	$view .= "<ul class='nav nav-tabs'>";
			    	
						$view .= "<li class='active'><a data-toggle='tab' href='#item-tab'>Item</a></li>";
						
						$view .= "<li><a data-toggle='tab' href='#expense-tab'>Expense</a></li>";
																   	  						
					$view .= "</ul>";
				
					$view .= "</div>";
				
					$view .= "<div class='tab-content'>";
				
					$view .= "<div class='tab-pane active' id='item-tab'>";
										
						$view .= "<table class='table accounting-transaction-table table-small-font'>";
						
							$view .= "<thead class='table-header-blue-transaction table-header-bold'>";
							
								$view .= "<tr>";
								
								    $view .= "<td class='table-valign-middle table-align-middle'></td>";
								    
									$view .= "<td class='table-valign-middle table-align-middle'>Item</td>";
									
									$view .= "<td class='table-valign-middle table-align-middle'>Description</td>";
									
									$view .= "<td class='table-valign-middle table-align-middle'>Qty</td>";
									
									$view .= "<td class='table-valign-middle table-align-middle'>Unit Price</td>";
																		
									$view .= "<td class='table-valign-middle table-align-middle'>Account</td>";
																		
									$view .= "<td class='table-valign-middle table-align-middle'>Amount</td>";
									
									$view .= "<td></td>";
								
								$view .= "</tr>";
							
							$view .= "</thead>";
							
							$view .= "<tbody>";
							
							$i = 0;
																							
							while ($i != 3):
							
							$i++;
							
								$view .= "<tr class='accounting-table-tr-type-one accounting-receipt-item-row'>";
								
								    $view .= "<td class='accounting-table-td-type-three'><i class='icon-align-justify'></i><input id='id' class='accounting-item-id' type='hidden' value=''><input id='accounting-item-category' class='accounting-item-category' type='hidden' value=''></td>";
								    
								    $view .= "<td class='accounting-table-td-type-one accounting-item'><input class='accounting-table-input-type-three' type='text' id='item' value=''></td>";
								    								
									$view .= "<td class='accounting-table-td-type-one accounting-description'><input class='accounting-table-input-type-five' type='text' id='description' value=''></td>";
									
									$view .= "<td class='accounting-table-td-type-one accounting-qty'><input class='accounting-table-input-type-one input-align-right' type='text' id='qty' value=''></td>";
									
									$view .= "<td class='accounting-table-td-type-one accounting-price'><input class='accounting-table-input-type-one input-align-right' type='text' id='price' value=''></td>";
																		
									$view .= "<td class='accounting-table-td-type-one accounting-account'><input class='accounting-table-input-type-one accounting-account-display' type='text' value=''><input class='accounting-account-value' type='hidden' id='account' value=''></td>";
																		
									$view .= "<td class='accounting-table-td-type-five accounting-amount'><input disabled='disabled' class='accounting-table-input-type-four input-align-right' type='text' id='amount' value=''></td>";
									
									$view .= "<td class='accounting-table-td-type-last '><input type='hidden' id='position' value=''><i class='icon-remove-circle accounting-table-del-line'></i></td>";
								$view .= "</tr>";
							
							endwhile;
							
							$view .= "</tbody>";
							
							$view .= "<tfoot>";
															
								$view .= "<tr class='accounting-table-tr-type-two'><td colspan='6' class='table-valign-middle table-align-right'>Grand Total</td><td class='table-align-right accounting-foot-total'>0.00</td><td></td></tr>";
																					
							$view .= "</tfoot>";
							
						$view .= "</table>";
					
					$view .= "</div>";
					
					$view .= "<div class='tab-pane' id='expense-tab'>";
					
						$view .= "<table class='table accounting-transaction-table table-small-font'>";
						
							$view .= "<thead class='table-header-blue-transaction table-header-bold'>";
							
								$view .= "<tr>";
								
								    $view .= "<td class='table-valign-middle table-align-middle'></td>";
								    
								    $view .= "<td class='table-valign-middle table-align-middle'>Account</td>";
								    									
									$view .= "<td class='table-valign-middle table-align-middle'>Description</td>";
									
									$view .= "<td class='table-valign-middle table-align-middle'>Qty</td>";
									
									$view .= "<td class='table-valign-middle table-align-middle'>Unit Price</td>";
																		
									$view .= "<td class='table-valign-middle table-align-middle'>Amount</td>";
									
									$view .= "<td></td>";
								
								$view .= "</tr>";
							
							$view .= "</thead>";
							
							$view .= "<tbody>";
							
							$i = 0;
																								
							while ($i != 3):
							
							$i++;
							
								$view .= "<tr class='accounting-table-tr-type-one accounting-receipt-account-row'>";
									
									$view .= "<td class='accounting-table-td-type-three'><i class='icon-align-justify'></i><input id='id' class='accounting-item-id' type='hidden' value=''><input id='accounting-item-category' class='accounting-item-category' type='hidden' value=''></td>";
								    									
									$view .= "<td class='accounting-table-td-type-one accounting-account'><input class='accounting-table-input-type-six accounting-account-display' type='text' value=''><input class='accounting-account-value' type='hidden' id='account' value=''></td>";
								    								    								
									$view .= "<td class='accounting-table-td-type-one accounting-description'><input class='accounting-table-input-type-seven' type='text' id='description' value=''></td>";
									
									$view .= "<td class='accounting-table-td-type-one accounting-qty'><input class='accounting-table-input-type-one input-align-right' type='text' id='qty' value=''></td>";
									
									$view .= "<td class='accounting-table-td-type-one accounting-price'><input class='accounting-table-input-type-one input-align-right' type='text' id='price' value=''></td>";
																		
									$view .= "<td class='accounting-table-td-type-five accounting-amount'><input disabled='disabled' class='accounting-table-input-type-four input-align-right' type='text' id='amount' value=''></td>";
									
									$view .= "<td class='accounting-table-td-type-last '><input type='hidden' id='position' value=''><i class='icon-remove-circle accounting-table-del-line'></i></td>";
								$view .= "</tr>";
							
							endwhile;
							
							$view .= "</tbody>";
							
							$view .= "<tfoot>";
															
								$view .= "<tr class='accounting-table-tr-type-two'><td colspan='5' class='table-valign-middle table-align-right'>Grand Total</td><td class='table-align-right accounting-foot-total'>0.00</td><td></td></tr>";
																					
							$view .= "</tfoot>";
							
						$view .= "</table>";
						
					$view .= "</div>";
					
					$view .= "</div>";
					
					$view .= "<a class='pull-left btn btn-mini accounting-table-add-newline'><i class='icon-circle-arrow-right'></i> Add a new line</a>";
					
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
				
				$view .= "<br>";
				
				$view .= "<div class='accounting-action-final'>";
				
				$view .= "<div class='accounting-action-final-container'>";
				
					$view .= "<div class='pull-right default-control-form-final'>";
				
						$view .= "<button type='button' id='accounting-receipt-submit-new' class='btn btn-small btn-success' data-loading-text='Please Wait...'><i class='icon-ok icon-white'></i> Save & Back</button>";
						
					$view .= "</div>";
					
					$view .= "<div class='pull-right default-control-form-final'>";
				
						$view .= "<button class='btn btn-small btn-info'><i class='icon-circle-arrow-right icon-white'></i> Save & Create New</button>";
						
					$view .= "</div>";
					
					$view .= "<div class='pull-right default-control-form-final'>";
	    		
						$view .= "<a href='".$this->url->builder(3561,'transaction')."' class='btn btn-small'><i class='icon-remove'></i> Cancel</a>";
						
					$view .= "</div>";
	    		
	    		$view .= "</div>";
	    		
	    		$view .= "</div>";
					
	    		$view .= "</form>";
	    			    			    			    		
	    	$view .= "</div>";
	    
	    $view .= "</div>";
	    
	return $view;
		    
    }
    
    public function form_viewReceipt() {

	    $item   = json_decode($this->getItem(), true);
	    
	    $coa    = json_decode($this->getCoa(), true);
	    
	    $acccur = json_decode($this->getCurrencyAccount(),true);
	    
	    $user 	= unserialize($_SESSION['user']);
	    
    	$id		= $user->getID();

    	$cus	= json_decode($this->getContactCustomer($id),true);
    	
    	$data   = json_decode($this->getReceiptByID(),true);

	    $crypt = encryption::urlHashEncodingRinjndael($_SESSION['xss'],$data['CAP_ACC_TRA_ID']);
	    
	    $view .= "<div class='row accounting-".$this->params."-container'>";
	    
	    $view .= "<div class='span12'>";
	    
	    	$view .= "<h2 class=''>View Receipt</h2>";
	    
	    $view .= "</div>";
	    
	    	$view .= "<div class='span12 accounting-".$this->params."-formViewContainer'>";
	    	
	    	$view .= "<div class='span1 btn-group pull-left'>";
		   
		   	  	$view .= "<a class='btn btn-info btn-small dropdown-toggle' data-toggle='dropdown' href='#accounting-".$this->params."-coaAdd'><i class='icon-edit icon-white'></i> Options <span class='caret'></span></a>";
		   	  	
		   	  		$view .= "<ul class='dropdown-menu'>";
		   	  			
		   	  			$view .= "<li><a href='#'><i class='icon-ban-circle'></i> Void</a></li>";
		   	  			
		   	  			$view .= "<li><a href='".$this->url->builder(3803,'receipt')."?actio=edit|||receipt|||".$crypt."&emblem=".$_SESSION['xss']."'><i class='icon-pencil'></i> Edit</a></li>";
		   	  					   	  					   	  		
		   	  		$view .= "</ul>";
									  					
		   	$view .= "</div>";
		   
		    $view .= "<div class='clearfix'></div>";
	    	
	    	$view .= "<hr>";
	    		
	    	$view .= "<input id='capsuleCSRFToken' type='hidden' value='".$_SESSION['xss']."'>";
	    		
	    		$view .= "<form id='accounting-".$this->params."-form'>";
	    			
	    			$view .= "<div class='accounting-".$this->params."-form-transaction'>";
	    			
	    			$view .= "<div class='accounting-".$this->params."-form-top'>";
	    		
	    			$view .= "<div class='span-accounting-view-header default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='name'>To</label></span>";
						
						$view .= "<div class='controls'>".ucwords(strtolower($data['CAP_ACC_CON_CONTACT']))."</div>";
																	
					$view .= "</div>";
										
					$view .= "<div class='span-accounting-view-header default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='date'>Date</label></span>";
						
						$view .= "<div class='controls'>".date("d F Y",strtotime($data['CAP_ACC_TRA_DATE']))."</div>";
						
					$view .= "</div>";
										
					$view .= "<div class='span-accounting-view-header default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='number'>Reference #</label></span>";
						
						$view .= "<div class='controls'>".$data['CAP_ACC_TRA_NUMBER']."</div>";
						
					$view .= "</div>";
										
					$view .= "<div class='span-accounting-view-header default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='number'>Currency</label></span>";
						
						$view .= "<div class='controls'>".$data['CAP_ACC_USE_ACC_CUR_NAME']." ".ucwords(strtolower($data['CAP_ACC_CUR_PREFIX']))."</div>";
						
					$view .= "</div>";
																				
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
					
					$view .= "<hr>";
															
					$view .= "</div>";
										
					$view .= "<div class='span12 accounting-".$this->params."-form-table'>";
										
					$view .= "<table class='table accounting-transaction-table-non-sortable table-small-font'>";
					
						$view .= "<thead class='table-header-grey-transaction table-header-bold'>";
						
							$view .= "<tr>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Type</td>";
														    
								$view .= "<td class='table-valign-middle table-align-middle'>Name</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Description</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Qty</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Unit Price</td>";
																
								$view .= "<td class='table-valign-middle table-align-middle'>Account</td>";
																
								$view .= "<td class='table-valign-middle table-align-middle'>Amount</td>";
															
							$view .= "</tr>";
						
						$view .= "</thead>";
						
						$view .= "<tbody>";
						
						$c = (int) reset(explode('/',$data['CAP_ACC_TRA_ROW']));

						$i = 0;
						
						$y = 0;

						if (!empty($data['ITEM-TRANSACTION'])):
												
							foreach ($data['ITEM-TRANSACTION'] as $value):
														
							$i++;
																
								unset($name); 
								unset($desc); 
								unset($coa); 
								unset($qty);
								unset($cat);
								unset($rate); 
								unset($amou);
								unset($disc);
								unset($discR);
								unset($discN); 
								unset($tax);
								unset($taxR);
								unset($taxA);

								$type  = (!empty($data['ITEM-TRANSACTION'][$y]['FK_CAP_ACC_ITE_ID'])) ? 'Item' : 'Expense';
								$name  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_ITE_NAME'];
								$desc  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_DESC'];
								$coa   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_COA_NAME'];
								$qty   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_QTY'];
								$cat   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_ITE_TYP_NAME'];
								$rate  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_RATE'];
								$amou  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_AMOUNT'];

								$disc  = $data['ITEM-TRANSACTION'][$y]['DISCOUNT'][0]['CAP_ACC_ITE_NAME'];
								$discR = $data['ITEM-TRANSACTION'][$y]['DISCOUNT'][0]['CAP_ACC_TRA_ITE_RATE'];
								$discN = $data['ITEM-TRANSACTION'][$y]['DISCOUNT'][0]['CAP_ACC_TRA_ITE_AMOUNT'];
								
								$tax   = $data['ITEM-TRANSACTION'][$y]['TAX'][0]['CAP_ACC_ITE_NAME'];
								$taxR  = $data['ITEM-TRANSACTION'][$y]['TAX'][0]['CAP_ACC_TRA_ITE_RATE'];
								$taxA  = $data['ITEM-TRANSACTION'][$y]['TAX'][0]['CAP_ACC_TRA_ITE_AMOUNT'];
								
								$name  = (!empty($name)) ? $name : '&nbsp;' ;
								$desc  = (!empty($desc)) ? ucwords(strtolower($desc)) : '&nbsp;' ;
								$coa   = (!empty($coa))  ? ucwords(strtolower($coa)) : '&nbsp;' ;
								$qty   = (!empty($qty))  ? number_format($qty,$this->getDecimalLength($qty)) : null;	
																
								$realAmount  = ($rate + (($rate / 100) * $taxR)) * $qty;
								
								$realDiscount = ($realAmount / 100) * $discR;
																
								$realAmount  = $realAmount - $realDiscount;
																
									if (strtoupper($cat) != 'SUB TOTAL'):
																											
									$rate = round($rate,4,PHP_ROUND_HALF_UP);
									
									$rate = (!empty($rate)) ? round($rate,4) : null;
									
									else:
									
									$rate = null;
									
									endif;

								$discN  = (!empty($discN)) ? round($discN,3,PHP_ROUND_HALF_UP) : 0;
								$discL += (!empty($discN)) ? $discN : 0;
								
								$disc   = (!empty($disc))  ? $disc." (".$discR."%)" : null;
								$tax    = (!empty($tax))   ? $tax." (".$taxR."%)" : null;
								$amou   = (!empty($amou))  ? bcsub($amou,$discN,4) : null;
								$money = round(bcdiv(bcmul($amou,bcadd(100,$taxR,4),4),100,4),4,PHP_ROUND_HALF_EVEN);

								$money =round($money/(100+$taxR)*100,4,PHP_ROUND_HALF_EVEN);
								
								list ($fund,$fundd) = explode('.',$money);
						
								$fund   = (!empty($fund))  ?  $fund :  '0';
								$fundd  = (!empty($fundd)) ?  substr($fundd,0,3) :  '00';
								$funds  = (!empty($fund)) ?  $money :  0.00;

								$funds  = round($funds,2,PHP_ROUND_HALF_ODD);
								
								$moneyT += $money;

									if (strtoupper($data['ITEM-TRANSACTION'][$y]['CAP_ACC_ITE_TYP_NAME']) != 'SUB TOTAL'):

									$discT     = (!empty($discN)) ? bcadd($discN,$discT,3) 	: $discT;
									$taxT      = (!empty($taxA))  ? bcadd($taxT,$taxA,3) 		: $taxT;
									$total     = (!empty($amou))  ? bcadd($amou,$total,3) 		: $total;
									$totalSub  = (!empty($amou))  ? bcadd($amou,$totalSub,3) 	: $totalSub;
									$totalTax  = (!empty($taxA))  ? bcadd($taxA,$totalTax,3)	: $totalTax;

									elseif (strtoupper($cat) == 'SUB TOTAL'):

									$funds     = round($totalSub,2,PHP_ROUND_HALF_ODD);
									$totalSub  = 0;
									$totalTax  = 0;
									
									endif;

									$view .= "<tr class='accounting-table-tr-type-one'>";
								        
								        $view .= "<td class='accounting-table-td-type-six table-valign-middle'>".ucwords(strtolower($type))."</td>";
								        						    
									    $view .= "<td class='accounting-table-td-type-six table-valign-middle'>".$name."</td>";
									    								
										$view .= "<td class='accounting-table-td-type-six table-valign-middle'>".$desc."</td>";
										
										$view .= "<td class='accounting-table-td-type-six table-valign-middle table-align-right'>".$qty."</td>";
										
										$view .= "<td class='accounting-table-td-type-six table-valign-middle table-align-right'>".$rate."</td>";
																																						
										$view .= "<td class='accounting-table-td-type-six table-valign-middle'>".$coa."</td>";
																				
										$view .= "<td class='accounting-table-td-type-six table-valign-middle table-align-right'>".number_format($funds,2)."</td>";
										
									$view .= "</tr>";
									
								$y++;
								
															
							endforeach;
						
						endif;
						
						$grandTotal = number_format(round(bcadd($moneyT,$taxT,3),3,PHP_ROUND_HALF_EVEN),2);
						
						$grandSubTotal = (!empty($moneyT)) ?  number_format($moneyT,2) :  number_format($total,2);
																								
						$view .= "</tbody>";
						
						$view .= "<tfoot>";
																												
						$view .= "<tr class='accounting-table-tr-type-six'><td colspan='6' class='table-valign-middle table-align-right'>Grand Total</td><td class='table-align-right accounting-foot-total'>".$grandTotal."</td></tr>";
																				
						$view .= "</tfoot>";
						
					$view .= "</table>";
										
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
				
				$view .= "<br>";

	    		$view .= "</form>";
	    			    			    			    		
	    	$view .= "</div>";
	    
	    $view .= "</div>";
	    
	return $view;
		    
    }
    
    public function form_editReceipt() {
	    
	    $item   = json_decode($this->getItem(), true);
	    
	    $coa    = json_decode($this->getCoa(), true);
	    
	    $acccur = json_decode($this->getCurrencyAccount(),true);
	    
	    $user 	= unserialize($_SESSION['user']);
	    
    	$id		= $user->getID();

    	$cus	= json_decode($this->getContactCustomer($id),true);
    	    	
    	$data   = json_decode($this->getReceiptByID(),true);

	   if (!empty($cus)):
	    	
    		foreach ($cus as $key => $value):
    		
    		$selected  = ($data['CAP_ACC_CON_ID'] == $value['CAP_ACC_CON_ID']) ? "selected='selected'" : null;
    		
    		$customer .= "<option $selected value='".$value['CAP_ACC_CON_ID']."'>".ucwords(strtolower($value['CAP_ACC_CON_CONTACT']))."</option>";
    		
    		endforeach;
	    	
	   endif;
	    
    	if (!empty($acccur)):
    	
    		foreach ($acccur as $key => $value):
    		
    		$selected  = ($data['FK_CAP_ACC_TRA_CURRENCY'] == $value['CAP_ACC_USE_ACC_CUR_ID']) ? "selected='selected'" : null;
    		
    		$currency .= "<option $selected value='".$value['CAP_ACC_USE_ACC_CUR_ID']."'>".$value['CAP_ACC_CUR_NAME']." ".$value['CAP_ACC_CUR_PREFIX']."</option>";
    		
    		endforeach;
    	
    	endif;
	    
	    	if (!empty($item)):
	    	
	    		foreach ($item as $key => $value):
	    		
	    			if ($value['CAP_ACC_ITE_TYP_NAME'] == 'TAX'):
	    			
	    			$itemTax [] = [
	    			
	    			"id"    => $value['CAP_ACC_ITE_ID'],
	    			"label" => $value['CAP_ACC_ITE_NAME'],
	    			"rate"  => $value['COA-PURCHASE'][0]['CAP_ACC_ITE_COA_RATE']
	    			
	    			];
	    				    			
	    			endif;
	    			
	    			if ($value['CAP_ACC_ITE_TYP_NAME'] == 'DISCOUNT'):
	    			
	    			$itemDisc [] = [
	    			
	    			"id"    => $value['CAP_ACC_ITE_ID'],
	    			"label" => $value['CAP_ACC_ITE_NAME'],
	    			"rate"  => $value['COA-PURCHASE'][0]['CAP_ACC_ITE_COA_RATE']
	    			
	    			];
	    			
	    			endif;
	    		
	    		endforeach;
	    
		    	foreach ($item as $key => $value):
		    	
		    	unset($taxInfo);
		    	
		    	$phpItem .= "<option value='".$value['CAP_ACC_ITE_ID']."'>".$value['CAP_ACC_ITE_NAME']."</option>";
		    	
		    	if (!empty($value['COA-PURCHASE'][0]['FK_CAP_ACC_ITE_TAX_ID'])):
		    	
		    	$i = 0;
		    	
		    		foreach ($itemTax as $taxKey => $taxValue):

		    			if ($value['COA-PURCHASE'][0]['FK_CAP_ACC_ITE_TAX_ID'] == $taxValue['id']): 
		    			
		    			$taxInfo = $itemTax[$i]; break; 
		    			
		    			endif;
		    		
		    		$i++;
		    		
		    		endforeach;

		    	endif;
		    	
		    	$autoCompleteItem [] = [
		    	
		    	"id"		=> $value['CAP_ACC_ITE_ID'],
		    	"label" 	=> $value['CAP_ACC_ITE_NAME'],
		    	"desc" 		=> $value['CAP_ACC_ITE_DESC'],
		    	"price" 	=> $value['COA-PURCHASE'][0]['CAP_ACC_ITE_COA_RATE'],
		    	"category" 	=> ucwords(strtolower($value['CAP_ACC_ITE_TYP_NAME'])),
		    	"account"	=> ucwords(strtolower($value['COA-PURCHASE'][0]['CAP_ACC_COA_NAME'])),
		    	"accountid"	=> $value['COA-PURCHASE'][0]['FK_CAP_ACC_COA_ID'],
		    	"taxid"		=> $taxInfo['id'],
		    	"taxname"	=> $taxInfo['label'],
		    	"taxrate"	=> $taxInfo['rate']
		    	
		    	];
		    			    	
		    	endforeach;
	    	
	    	endif;
	    		    	
	    	if (!empty($coa)):
	    	
	    		foreach ($coa as $key => $value):
	    		
	    		$phpCoa .= "<option value='".$value['CAP_ACC_ITE_ID']."'>".$value['CAP_ACC_ITE_NAME']."</option>";
	    			
	    		$autoCompleteCoa [] = [
		    	
		    	"id"		=> $value['CAP_ACC_COA_ID'],
		    	"label" 	=> ucwords(strtolower($value['CAP_ACC_COA_NAME'])),
		    	"desc" 		=> $value['CAP_ACC_COA_DESC'],
		    	"category" 	=> ucwords(strtolower($value['CAP_ACC_COA_TYP_NAME']))
		    	
		    	];
		    	
			    	if ($value['CAP_ACC_COA_TYP_NAME'] == 'BANK'):

			    	$accReceivable .= "<option value='".$value['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value['CAP_ACC_COA_NAME']))."</option>";

			    	endif;
	    		
	    		endforeach;
	    	
	    	endif;

	    $view .= "<script type='text/javascript'>";
	    	    	
	    	$view .= "function accountingInvoiceItem() {";
	    	
	    		$view .= "return ".json_encode($autoCompleteItem);
	    	
	    	$view .= "}";
	    		    	
	    	$view .= "function accountingInvoiceCoa() {";
	    	
	    		$view .= "return ".json_encode($autoCompleteCoa);
	    	
	    	$view .= "}";
	    	
	    	$view .= "function accountingInvoiceTax() {";
	    	
	    		$view .= "return ".json_encode($itemTax);
	    	
	    	$view .= "}";
	    	
	    	$view .= "function accountingInvoiceDiscount() {";
	    	
	    		$view .= "return ".json_encode($itemDisc);
	    	
	    	$view .= "}";
	    
	    $view .= "</script>";
	    	    
	    $view .= "<div class='row accounting-".$this->params."-container'>";
	    
	    $view .= "<div class='span12'>";
	    
	    	$view .= "<h2 class=''>Edit Receipt</h2>";
	    
	    $view .= "</div>";
	    
	    	$view .= "<div class='span12 accounting-".$this->params."-formContainer'>";
	    		
	    	$view .= "<input id='capsuleCSRFToken' type='hidden' value='".$_SESSION['xss']."'>";
	    		
	    		$view .= "<form id='accounting-".$this->params."-form' data-form-type='receipt'>";
	    			    			
	    			$view .= "<div class='accounting-".$this->params."-form-transaction'>";
	    			
	    			$view .= "<input id='transaction-pid' type='hidden' value='".$data['CAP_ACC_TRA_ID']."'>";
	    			
	    			$view .= "<div class='accounting-".$this->params."-form-top'>";
	    		
	    			$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='name'>From</label></span>";
						
						$view .= "<div class='controls'><select id='customer-id' class='span2 accounting-chosen'><option></option>$customer</select></div>";
																	
					$view .= "</div>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='account'>Account</label></span>";
						
						$view .= "<div class='controls'><select id='account' class='span2 accounting-chosen'>".$accReceivable."</select></div>";
																														
					$view .= "</div>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='date'>Date</label></span>";
						
						$view .= "<div class='controls'><input class='accounting-date-".md5(rand(0,100))." input-medium' type='text' id='date' value='".date('d-m-Y',strtotime($data['CAP_ACC_TRA_DATE']))."'></div>";
						
					$view .= "</div>";
										
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='number'>Reference #</label></span>";
						
						$view .= "<div class='controls'><input class='input-medium' type='text' id='number' value='".$data['CAP_ACC_TRA_NUMBER']."'></div>";
						
					$view .= "</div>";
																				
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
					
					$view .= "<hr>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='currency'>Currency</label></span>";
						
						$view .= "<div class='controls'><select id='currency' class='span2 accounting-chosen'>".$currency."</select></div>";
						
					$view .= "</div>";
										
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
					
					$view .= "<br>";
					
					$view .= "<div class='span12 accounting-".$this->params."-form-table'>";
					
					$view .= "<div id='accounting-".$this->params."-table'>";
    	
			    	$view .= "<ul class='nav nav-tabs'>";
			    	
						$view .= "<li class='active'><a data-toggle='tab' href='#item-tab'>Item</a></li>";
						
						$view .= "<li><a data-toggle='tab' href='#expense-tab'>Expense</a></li>";
																   	  						
					$view .= "</ul>";
				
					$view .= "</div>";
				
					$view .= "<div class='tab-content'>";
				
					$view .= "<div class='tab-pane active' id='item-tab'>";
										
						$view .= "<table class='table accounting-transaction-table table-small-font'>";
						
							$view .= "<thead class='table-header-blue-transaction table-header-bold'>";
							
								$view .= "<tr>";
								
								    $view .= "<td class='table-valign-middle table-align-middle'></td>";
								    
									$view .= "<td class='table-valign-middle table-align-middle'>Item</td>";
									
									$view .= "<td class='table-valign-middle table-align-middle'>Description</td>";
									
									$view .= "<td class='table-valign-middle table-align-middle'>Qty</td>";
									
									$view .= "<td class='table-valign-middle table-align-middle'>Unit Price</td>";
																		
									$view .= "<td class='table-valign-middle table-align-middle'>Account</td>";
																		
									$view .= "<td class='table-valign-middle table-align-middle'>Amount</td>";
									
									$view .= "<td></td>";
								
								$view .= "</tr>";
							
							$view .= "</thead>";
							
							$view .= "<tbody>";
							
							if (!empty($data['ITEM-TRANSACTION'])):
							
    							foreach ($data['ITEM-TRANSACTION'] as $value):
    							
    							     $total += $value['CAP_ACC_TRA_ITE_AMOUNT'];
    							
    							endforeach;
							
							endif;
							
							$c = (int) reset(explode('/',$data['CAP_ACC_TRA_ROW']));
							
    						$i = 0;
    						
    						$y = 0;

							while ($i != $c):
							
							$i++; 

    							if ($i == $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_POSITION'] && !empty($data['ITEM-TRANSACTION'][$y]['FK_CAP_ACC_ITE_ID'])):

    							$pid   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_ID'];
    							$id    = $data['ITEM-TRANSACTION'][$y]['FK_CAP_ACC_ITE_ID'];
								$name  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_ITE_NAME'];
								$desc  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_DESC'];
								$coa   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_COA_NAME'];
								$qty   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_QTY'];
								$cat   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_ITE_TYP_NAME'];
								$rate  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_RATE'];
								$amou  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_AMOUNT'];
								
								$name  = (!empty($name)) ? $name : '&nbsp;' ;
								$cat   = (!empty($cat)) ? ucwords(strtolower($cat)) : '&nbsp;' ;
								$desc  = (!empty($desc)) ? ucwords(strtolower($desc)) : '&nbsp;' ;
								$coa   = (!empty($coa))  ? ucwords(strtolower($coa)) : '&nbsp;' ;
								$coaID = $data['ITEM-TRANSACTION'][$y]['FK_CAP_ACC_COA_ID'];
    														
    								$view .= "<tr class='accounting-table-tr-type-one accounting-receipt-item-row'>";
    								
    								    $view .= "<td class='accounting-table-td-type-three'><i class='icon-align-justify'></i><input id='item-pid' class='accounting-item-pid' type='hidden' value='$pid'><input id='id' class='accounting-item-id' type='hidden' value='$id'><input id='accounting-item-category' class='accounting-item-category' type='hidden' value='$cat'></td>";
    								    
    								    $view .= "<td class='accounting-table-td-type-one accounting-item'><input class='accounting-table-input-type-three' type='text' id='item' value='$name'></td>";
    								    								
    									$view .= "<td class='accounting-table-td-type-one accounting-description'><input class='accounting-table-input-type-five' type='text' id='description' value='$desc'></td>";
    									
    									$view .= "<td class='accounting-table-td-type-one accounting-qty'><input class='accounting-table-input-type-one input-align-right' type='text' id='qty' value='$qty'></td>";
    									
    									$view .= "<td class='accounting-table-td-type-one accounting-price'><input class='accounting-table-input-type-one input-align-right' type='text' id='price' value='$rate'></td>";
    																		
    									$view .= "<td class='accounting-table-td-type-one accounting-account'><input class='accounting-table-input-type-one accounting-account-display' type='text' value='$coa'><input class='accounting-account-value' type='hidden' id='account' value='$coaID'></td>";
    																		
    									$view .= "<td class='accounting-table-td-type-five accounting-amount'><input disabled='disabled' class='accounting-table-input-type-four input-align-right' type='text' id='amount' value='$amou'></td>";
    									
    									$view .= "<td class='accounting-table-td-type-last '><input type='hidden' id='position' value=''><i class='icon-remove-circle accounting-table-del-line'></i></td>";
    								$view .= "</tr>";
    							
    							$y++;
    							    							
    							else:
    							
    							    $view .= "<tr class='accounting-table-tr-type-one accounting-receipt-item-row'>";
    								
    								    $view .= "<td class='accounting-table-td-type-three'><i class='icon-align-justify'></i><input id='id' class='accounting-item-id' type='hidden' value=''><input id='accounting-item-category' class='accounting-item-category' type='hidden' value=''></td>";
    								    
    								    $view .= "<td class='accounting-table-td-type-one accounting-item'><input class='accounting-table-input-type-three' type='text' id='item' value=''></td>";
    								    								
    									$view .= "<td class='accounting-table-td-type-one accounting-description'><input class='accounting-table-input-type-five' type='text' id='description' value=''></td>";
    									
    									$view .= "<td class='accounting-table-td-type-one accounting-qty'><input class='accounting-table-input-type-one input-align-right' type='text' id='qty' value=''></td>";
    									
    									$view .= "<td class='accounting-table-td-type-one accounting-price'><input class='accounting-table-input-type-one input-align-right' type='text' id='price' value=''></td>";
    																		
    									$view .= "<td class='accounting-table-td-type-one accounting-account'><input class='accounting-table-input-type-one accounting-account-display' type='text' value=''><input class='accounting-account-value' type='hidden' id='account' value=''></td>";
    																		
    									$view .= "<td class='accounting-table-td-type-five accounting-amount'><input disabled='disabled' class='accounting-table-input-type-four input-align-right' type='text' id='amount' value=''></td>";
    									
    									$view .= "<td class='accounting-table-td-type-last '><input type='hidden' id='position' value=''><i class='icon-remove-circle accounting-table-del-line'></i></td>";
    								$view .= "</tr>";
    							
    							endif;
																					
							endwhile;
							
							$view .= "</tbody>";
							
							$view .= "<tfoot>";
															
								$view .= "<tr class='accounting-table-tr-type-two'><td colspan='6' class='table-valign-middle table-align-right'>Grand Total</td><td class='table-align-right accounting-foot-total'>".number_format($total,2)."</td><td></td></tr>";
																					
							$view .= "</tfoot>";
							
						$view .= "</table>";
					
					$view .= "</div>";
					
					$view .= "<div class='tab-pane' id='expense-tab'>";
					
						$view .= "<table class='table accounting-transaction-table table-small-font'>";
						
							$view .= "<thead class='table-header-blue-transaction table-header-bold'>";
							
								$view .= "<tr>";
								
								    $view .= "<td class='table-valign-middle table-align-middle'></td>";
								    
								    $view .= "<td class='table-valign-middle table-align-middle'>Account</td>";
								    									
									$view .= "<td class='table-valign-middle table-align-middle'>Description</td>";
									
									$view .= "<td class='table-valign-middle table-align-middle'>Qty</td>";
									
									$view .= "<td class='table-valign-middle table-align-middle'>Unit Price</td>";
																		
									$view .= "<td class='table-valign-middle table-align-middle'>Amount</td>";
									
									$view .= "<td></td>";
								
								$view .= "</tr>";
							
							$view .= "</thead>";
							
							$view .= "<tbody>";
														
							$c = (int) end(explode('/',$data['CAP_ACC_TRA_ROW']));

    						$i = 0;
    																														
							while ($i != $c):
							
							$i++;

							    if ($i == $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_POSITION'] && empty($data['ITEM-TRANSACTION'][$y]['FK_CAP_ACC_ITE_ID'])):
							     
							    $pid   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_ID'];
    							$id    = $data['ITEM-TRANSACTION'][$y]['FK_CAP_ACC_ITE_ID'];
								$name  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_ITE_NAME'];
								$desc  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_DESC'];
								$coa   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_COA_NAME'];
								$qty   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_QTY'];
								$cat   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_ITE_TYP_NAME'];
								$rate  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_RATE'];
								$amou  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_AMOUNT'];
								
								$name  = (!empty($name)) ? $name : '&nbsp;' ;
								$cat   = (!empty($cat)) ? ucwords(strtolower($cat)) : '&nbsp;' ;
								$desc  = (!empty($desc)) ? ucwords(strtolower($desc)) : '&nbsp;' ;
								$coa   = (!empty($coa))  ? ucwords(strtolower($coa)) : '&nbsp;' ;
								$coaID = $data['ITEM-TRANSACTION'][$y]['FK_CAP_ACC_COA_ID'];
							     
								$view .= "<tr class='accounting-table-tr-type-one accounting-receipt-account-row'>";
									
									$view .= "<td class='accounting-table-td-type-three'><i class='icon-align-justify'></i><input id='item-pid' class='accounting-item-pid' type='hidden' value='$pid'><input id='id' class='accounting-item-id' type='hidden' value='$id'><input id='accounting-item-category' class='accounting-item-category' type='hidden' value='$cat'></td>";
								    									
									$view .= "<td class='accounting-table-td-type-one accounting-account'><input class='accounting-table-input-type-six accounting-account-display' type='text' value='$coa'><input class='accounting-account-value' type='hidden' id='account' value='$coaID'></td>";
								    								    								
									$view .= "<td class='accounting-table-td-type-one accounting-description'><input class='accounting-table-input-type-seven' type='text' id='description' value='$desc'></td>";
									
									$view .= "<td class='accounting-table-td-type-one accounting-qty'><input class='accounting-table-input-type-one input-align-right' type='text' id='qty' value='$qty'></td>";
									
									$view .= "<td class='accounting-table-td-type-one accounting-price'><input class='accounting-table-input-type-one input-align-right' type='text' id='price' value='$rate'></td>";
																		
									$view .= "<td class='accounting-table-td-type-five accounting-amount'><input disabled='disabled' class='accounting-table-input-type-four input-align-right' type='text' id='amount' value='$amou'></td>";
									
									$view .= "<td class='accounting-table-td-type-last '><input type='hidden' id='position' value=''><i class='icon-remove-circle accounting-table-del-line'></i></td>";
								$view .= "</tr>";
								
								$y++;
																
								else:
								
								$view .= "<tr class='accounting-table-tr-type-one accounting-receipt-account-row'>";
									
									$view .= "<td class='accounting-table-td-type-three'><i class='icon-align-justify'></i><input id='id' class='accounting-item-id' type='hidden' value=''><input id='accounting-item-category' class='accounting-item-category' type='hidden' value=''></td>";
								    									
									$view .= "<td class='accounting-table-td-type-one accounting-account'><input class='accounting-table-input-type-six accounting-account-display' type='text' value=''><input class='accounting-account-value' type='hidden' id='account' value=''></td>";
								    								    								
									$view .= "<td class='accounting-table-td-type-one accounting-description'><input class='accounting-table-input-type-seven' type='text' id='description' value=''></td>";
									
									$view .= "<td class='accounting-table-td-type-one accounting-qty'><input class='accounting-table-input-type-one input-align-right' type='text' id='qty' value=''></td>";
									
									$view .= "<td class='accounting-table-td-type-one accounting-price'><input class='accounting-table-input-type-one input-align-right' type='text' id='price' value=''></td>";
																		
									$view .= "<td class='accounting-table-td-type-five accounting-amount'><input disabled='disabled' class='accounting-table-input-type-four input-align-right' type='text' id='amount' value=''></td>";
									
									$view .= "<td class='accounting-table-td-type-last '><input type='hidden' id='position' value=''><i class='icon-remove-circle accounting-table-del-line'></i></td>";
								$view .= "</tr>";
								
								endif;
																							 
							endwhile;
							
							$view .= "</tbody>";
							
							$view .= "<tfoot>";

								$view .= "<tr class='accounting-table-tr-type-two'><td colspan='5' class='table-valign-middle table-align-right'>Grand Total</td><td class='table-align-right accounting-foot-total'>".number_format($total,2)."</td><td></td></tr>";
																					
							$view .= "</tfoot>";
							
						$view .= "</table>";
						
					$view .= "</div>";
					
					$view .= "</div>";
					
					$view .= "<a class='pull-left btn btn-mini accounting-table-add-newline'><i class='icon-circle-arrow-right'></i> Add a new line</a>";
					
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
				
				$view .= "<br>";
				
				$view .= "<div class='accounting-action-final'>";
				
				$view .= "<div class='accounting-action-final-container'>";
				
					$view .= "<div class='pull-right default-control-form-final'>";
				
						$view .= "<button id='accounting-receipt-submit-edit' class='btn btn-small btn-success'><i class='icon-ok icon-white'></i> Save & Back</button>";
						
					$view .= "</div>";
					
					$view .= "<div class='pull-right default-control-form-final'>";
				
						$view .= "<button class='btn btn-small btn-info'><i class='icon-circle-arrow-right icon-white'></i> Save & Create New</button>";
						
					$view .= "</div>";
					
					$view .= "<div class='pull-right default-control-form-final'>";
	    		
						$view .= "<a href='".$this->url->builder(3561,'transaction')."' class='btn btn-small'><i class='icon-remove'></i> Cancel</a>";
						
					$view .= "</div>";
	    		
	    		$view .= "</div>";
	    		
	    		$view .= "</div>";
					
	    		$view .= "</form>";
	    			    			    			    		
	    	$view .= "</div>";
	    
	    $view .= "</div>";
	    
	return $view;
		    
    }
    
    public function form_transfer_controller() {
	    
	    $view   = $this->optionGear;
	    
	    $actio  = explode('|||',$_GET['actio']);
	    
	    $key    = $_GET['emblem'];
	    
	    $words  = $actio[0];
	    
	    $rjand  = encryption::urlHashDecodingRinjndael($key,$actio[2]);
	    
			if (!is_numeric($rjand)):

			//header('Location: http://www.asacreative.com');

			endif;
	    
		if ($words == 'new'): 
		
			echo $this->form_createTransfer(); 
		
		elseif ($words == 'view'):
			
			$this->data = $rjand;
						
			echo $this->form_viewTransfer();
			
		elseif ($words == 'edit'):
		
			$this->data = $rjand;
		
			echo $this->form_editTransfer();
		
		endif;
	
    }
    
    public function form_createTransfer() {
	    
	    $item   = json_decode($this->getItem(), true);
	    
	    $coa    = json_decode($this->getCoa(), true);
	    
	    $acccur = json_decode($this->getCurrencyAccount(),true);
	    
	    $user 	= unserialize($_SESSION['user']);
	    
    	$id		= $user->getID();

    	$cus	= json_decode($this->getContactCustomer($id),true);
	    	    	    
	    	if (!empty($cus)):
	    	
	    		foreach ($cus as $key => $value):
	    		
	    		$customer .= "<option value='".$value['CAP_ACC_CON_ID']."'>".ucwords(strtolower($value['CAP_ACC_CON_CONTACT']))."</option>";
	    		
	    		endforeach;
	    	
	    	endif;
	    
	    	if (!empty($acccur)):
	    	
	    		foreach ($acccur as $key => $value):
	    		
	    		$currency .= "<option value='".$value['CAP_ACC_USE_ACC_CUR_ID']."'>".$value['CAP_ACC_CUR_NAME']." ".$value['CAP_ACC_CUR_PREFIX']."</option>";
	    		
	    		endforeach;
	    	
	    	endif;
	    
	    	if (!empty($item)):
	    	
	    		foreach ($item as $key => $value):
	    		
	    			if ($value['CAP_ACC_ITE_TYP_NAME'] == 'TAX'):
	    			
	    			$itemTax [] = [
	    			
	    			"id"    => $value['CAP_ACC_ITE_ID'],
	    			"label" => $value['CAP_ACC_ITE_NAME'],
	    			"rate"  => $value['COA-PURCHASE'][0]['CAP_ACC_ITE_COA_RATE']
	    			
	    			];
	    				    			
	    			endif;
	    			
	    			if ($value['CAP_ACC_ITE_TYP_NAME'] == 'DISCOUNT'):
	    			
	    			$itemDisc [] = [
	    			
	    			"id"    => $value['CAP_ACC_ITE_ID'],
	    			"label" => $value['CAP_ACC_ITE_NAME'],
	    			"rate"  => $value['COA-PURCHASE'][0]['CAP_ACC_ITE_COA_RATE']
	    			
	    			];
	    			
	    			endif;
	    		
	    		endforeach;
	    
		    	foreach ($item as $key => $value):
		    	
		    	unset($taxInfo);
		    	
		    	$phpItem .= "<option value='".$value['CAP_ACC_ITE_ID']."'>".$value['CAP_ACC_ITE_NAME']."</option>";
		    	
		    	if (!empty($value['COA-PURCHASE'][0]['FK_CAP_ACC_ITE_TAX_ID'])):
		    	
		    	$i = 0;
		    	
		    		foreach ($itemTax as $taxKey => $taxValue):

		    			if ($value['COA-PURCHASE'][0]['FK_CAP_ACC_ITE_TAX_ID'] == $taxValue['id']): 
		    			
		    			$taxInfo = $itemTax[$i]; break; 
		    			
		    			endif;
		    		
		    		$i++;
		    		
		    		endforeach;

		    	endif;
		    	
		    	$autoCompleteItem [] = [
		    	
		    	"id"		=> $value['CAP_ACC_ITE_ID'],
		    	"label" 	=> $value['CAP_ACC_ITE_NAME'],
		    	"desc" 		=> $value['CAP_ACC_ITE_DESC'],
		    	"price" 	=> $value['COA-PURCHASE'][0]['CAP_ACC_ITE_COA_RATE'],
		    	"category" 	=> ucwords(strtolower($value['CAP_ACC_ITE_TYP_NAME'])),
		    	"account"	=> ucwords(strtolower($value['COA-PURCHASE'][0]['CAP_ACC_COA_NAME'])),
		    	"accountid"	=> $value['COA-PURCHASE'][0]['FK_CAP_ACC_COA_ID'],
		    	"taxid"		=> $taxInfo['id'],
		    	"taxname"	=> $taxInfo['label'],
		    	"taxrate"	=> $taxInfo['rate']
		    	
		    	];
		    			    	
		    	endforeach;
	    	
	    	endif;
	    		    	
	    	if (!empty($coa)):
	    	
	    		foreach ($coa as $key => $value):
	    		
    	    		if ($value['CAP_ACC_COA_TYP_NAME'] == 'BANK'):
    	    		
    	    		$phpCoa .= "<option value='".$value['CAP_ACC_ITE_ID']."'>".$value['CAP_ACC_ITE_NAME']."</option>";
    	    			
    	    		$autoCompleteCoa [] = [
    		    	
    		    	"id"		=> $value['CAP_ACC_COA_ID'],
    		    	"label" 	=> ucwords(strtolower($value['CAP_ACC_COA_NAME'])),
    		    	"desc" 		=> $value['CAP_ACC_COA_DESC'],
    		    	"category" 	=> ucwords(strtolower($value['CAP_ACC_COA_TYP_NAME']))
    		    	
    		    	];
    		    	
    		    	endif;
		    	
			    	if ($value['CAP_ACC_COA_TYP_NAME'] == 'BANK'):

			    	$accReceivable .= "<option value='".$value['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value['CAP_ACC_COA_NAME']))."</option>";

			    	endif;
	    		
	    		endforeach;
	    	
	    	endif;

	    $view .= "<script type='text/javascript'>";
	    	    	
	    	$view .= "function accountingInvoiceItem() {";
	    	
	    		$view .= "return ".json_encode($autoCompleteItem);
	    	
	    	$view .= "}";
	    		    	
	    	$view .= "function accountingInvoiceCoa() {";
	    	
	    		$view .= "return ".json_encode($autoCompleteCoa);
	    	
	    	$view .= "}";
	    	
	    	$view .= "function accountingInvoiceTax() {";
	    	
	    		$view .= "return ".json_encode($itemTax);
	    	
	    	$view .= "}";
	    	
	    	$view .= "function accountingInvoiceDiscount() {";
	    	
	    		$view .= "return ".json_encode($itemDisc);
	    	
	    	$view .= "}";
	    
	    $view .= "</script>";
	    
	    //$view .= $this->optionGear;
	    
	    $view .= "<div class='row accounting-".$this->params."-container'>";
	    
	    $view .= "<div class='span12'>";
	    
	    	$view .= "<h2 class=''>New Transfer</h2>";
	    
	    $view .= "</div>";
	    
	    	$view .= "<div class='span12 accounting-".$this->params."-formContainer'>";
	    		
	    	$view .= "<input id='capsuleCSRFToken' type='hidden' value='".$_SESSION['xss']."'>";
	    		
	    		$view .= "<form id='accounting-".$this->params."-form' data-form-type='receipt'>";
	    			
	    			$view .= "<div class='accounting-".$this->params."-form-transaction'>";
	    			
	    			$view .= "<div class='accounting-".$this->params."-form-top'>";
	    							
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='account'>From</label></span>";
						
						$view .= "<div class='controls'><select id='account' class='span2 accounting-chosen'>".$accReceivable."</select></div>";
																														
					$view .= "</div>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='date'>Date</label></span>";
						
						$view .= "<div class='controls'><input class='accounting-date-".md5(rand(0,100))." input-medium' type='text' id='date' value='".$data['CAP_ACC_ITE_NAME']."'></div>";
						
					$view .= "</div>";
										
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='number'>Reference #</label></span>";
						
						$view .= "<div class='controls'><input class='input-medium' type='text' id='number' value='".$item['CAP_ACC_ITE_NAME']."'></div>";
						
					$view .= "</div>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='currency'>Currency</label></span>";
						
						$view .= "<div class='controls'><select id='currency' class='span2 accounting-chosen'>".$currency."</select></div>";
						
					$view .= "</div>";
																				
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
					
					$view .= "<hr>";
															
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
					
					$view .= "<br>";
					
					$view .= "<div class='span12 accounting-".$this->params."-form-table'>";
					
					$view .= "<div id='accounting-".$this->params."-table'>";
    						
						$view .= "<table class='table accounting-transaction-table table-small-font'>";
						
							$view .= "<thead class='table-header-blue-transaction table-header-bold'>";
							
								$view .= "<tr>";
								
								    $view .= "<td class='table-valign-middle table-align-middle'></td>";
								    
								    $view .= "<td class='table-valign-middle table-align-middle'>To</td>";
								    									
									$view .= "<td class='table-valign-middle table-align-middle'>Description</td>";
																		
									$view .= "<td class='table-valign-middle table-align-middle'>Amount</td>";
																		
									$view .= "<td class='table-valign-middle table-align-middle'>Total</td>";
									
									$view .= "<td></td>";
								
								$view .= "</tr>";
							
							$view .= "</thead>";
							
							$view .= "<tbody>";
							
							$i = 0;
																								
							while ($i != 3):
							
							$i++;
							
								$view .= "<tr class='accounting-table-tr-type-one accounting-transfer-item-row'>";
									
									$view .= "<td class='accounting-table-td-type-three'><i class='icon-align-justify'></i><input id='id' class='accounting-item-id' type='hidden' value=''><input id='accounting-item-category' class='accounting-item-category' type='hidden' value=''></td>";
								    									
									$view .= "<td class='accounting-table-td-type-one accounting-account'><input class='accounting-table-input-type-six accounting-account-display' type='text' value=''><input class='accounting-account-value' type='hidden' id='account' value=''></td>";
								    								    								
									$view .= "<td class='accounting-table-td-type-one accounting-description'><input class='accounting-table-input-type-seven' type='text' id='description' value=''></td>";
																		
									$view .= "<td class='accounting-table-td-type-one accounting-price'><input class='accounting-qty' type='hidden' id='qty' value='1'><input class='accounting-table-input-type-one input-align-right' type='text' id='price' value=''></td>";
																		
									$view .= "<td class='accounting-table-td-type-five accounting-amount'><input disabled='disabled' class='accounting-table-input-type-four input-align-right' type='text' id='amount' value=''></td>";
									
									$view .= "<td class='accounting-table-td-type-last '><input type='hidden' id='position' value=''><i class='icon-remove-circle accounting-table-del-line'></i></td>";
								$view .= "</tr>";
							
							endwhile;
							
							$view .= "</tbody>";
							
							$view .= "<tfoot>";
															
								$view .= "<tr class='accounting-table-tr-type-two'><td colspan='4' class='table-valign-middle table-align-right'>Grand Total</td><td class='table-align-right accounting-foot-total'>0.00</td><td></td></tr>";
																					
							$view .= "</tfoot>";
							
						$view .= "</table>";
											
					$view .= "</div>";
					
					$view .= "<a class='pull-left btn btn-mini accounting-table-add-newline'><i class='icon-circle-arrow-right'></i> Add a new line</a>";
					
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
				
				$view .= "<br>";
				
				$view .= "<div class='accounting-action-final'>";
				
				$view .= "<div class='accounting-action-final-container'>";
				
					$view .= "<div class='pull-right default-control-form-final'>";
				
						$view .= "<button type='button' id='accounting-transfer-submit-new' class='btn btn-small btn-success' data-loading-text='Please Wait...'><i class='icon-ok icon-white'></i> Save & Back</button>";
						
					$view .= "</div>";
					
					$view .= "<div class='pull-right default-control-form-final'>";
				
						$view .= "<button class='btn btn-small btn-info'><i class='icon-circle-arrow-right icon-white'></i> Save & Create New</button>";
						
					$view .= "</div>";
					
					$view .= "<div class='pull-right default-control-form-final'>";
	    		
						$view .= "<a href='".$this->url->builder(3561,'transaction')."' class='btn btn-small'><i class='icon-remove'></i> Cancel</a>";
						
					$view .= "</div>";
	    		
	    		$view .= "</div>";
	    		
	    		$view .= "</div>";
					
	    		$view .= "</form>";
	    			    			    			    		
	    	$view .= "</div>";
	    
	    $view .= "</div>";
	    
	return $view;
		    
    }
    
    public function form_viewTransfer() {

	    $item   = json_decode($this->getItem(), true);
	    
	    $coa    = json_decode($this->getCoa(), true);
	    
	    $acccur = json_decode($this->getCurrencyAccount(),true);
	    
	    $user 	= unserialize($_SESSION['user']);
	    
    	$id		= $user->getID();

    	$cus	= json_decode($this->getContactCustomer($id),true);
    	
    	$data   = json_decode($this->getTransferByID(),true);

	    $crypt = encryption::urlHashEncodingRinjndael($_SESSION['xss'],$data['CAP_ACC_TRA_ID']);

	    $view .= "<div class='row accounting-".$this->params."-container'>";
	    
	    $view .= "<div class='span12'>";
	    
	    	$view .= "<h2 class=''>View Transfer</h2>";
	    
	    $view .= "</div>";
	    
	    	$view .= "<div class='span12 accounting-".$this->params."-formViewContainer'>";
	    	
	    	$view .= "<div class='span1 btn-group pull-left'>";
		   
		   	  	$view .= "<a class='btn btn-info btn-small dropdown-toggle' data-toggle='dropdown' href='#accounting-".$this->params."-coaAdd'><i class='icon-edit icon-white'></i> Options <span class='caret'></span></a>";
		   	  	
		   	  		$view .= "<ul class='dropdown-menu'>";
		   	  			
		   	  			$view .= "<li><a href='#'><i class='icon-ban-circle'></i> Void</a></li>";
		   	  			
		   	  			$view .= "<li><a href='".$this->url->builder(3804,'transfer')."?actio=edit|||transfer|||".$crypt."&emblem=".$_SESSION['xss']."'><i class='icon-pencil'></i> Edit</a></li>";
		   	  					   	  					   	  		
		   	  		$view .= "</ul>";
									  					
		   	$view .= "</div>";
		   
		    $view .= "<div class='clearfix'></div>";
	    	
	    	$view .= "<hr>";
	    		
	    	$view .= "<input id='capsuleCSRFToken' type='hidden' value='".$_SESSION['xss']."'>";
	    		
	    		$view .= "<form id='accounting-".$this->params."-form'>";
	    			
	    			$view .= "<div class='accounting-".$this->params."-form-transaction'>";
	    			
	    			$view .= "<div class='accounting-".$this->params."-form-top'>";
	    		
	    			$view .= "<div class='span-accounting-view-header default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='name'>From</label></span>";
						
						$view .= "<div class='controls'>".ucwords(strtolower($data['ACCOUNT-TRANSACTION'][0]['CAP_ACC_COA_NAME']))."</div>";
																	
					$view .= "</div>";
										
					$view .= "<div class='span-accounting-view-header default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='date'>Date</label></span>";
						
						$view .= "<div class='controls'>".date("d F Y",strtotime($data['CAP_ACC_TRA_DATE']))."</div>";
						
					$view .= "</div>";
										
					$view .= "<div class='span-accounting-view-header default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='number'>Reference #</label></span>";
						
						$view .= "<div class='controls'>".$data['CAP_ACC_TRA_NUMBER']."</div>";
						
					$view .= "</div>";
										
					$view .= "<div class='span-accounting-view-header default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='number'>Currency</label></span>";
						
						$view .= "<div class='controls'>".$data['CAP_ACC_USE_ACC_CUR_NAME']." ".ucwords(strtolower($data['CAP_ACC_CUR_PREFIX']))."</div>";
						
					$view .= "</div>";
																				
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
					
					$view .= "<hr>";
															
					$view .= "</div>";
										
					$view .= "<div class='span12 accounting-".$this->params."-form-table'>";
										
					$view .= "<table class='table accounting-transaction-table-non-sortable table-small-font'>";
					
						$view .= "<thead class='table-header-grey-transaction table-header-bold'>";
						
							$view .= "<tr>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>To</td>";
								
								$view .= "<td class='table-valign-middle table-align-middle'>Description</td>";
																																								
								$view .= "<td class='table-valign-middle table-align-middle'>Amount</td>";
															
							$view .= "</tr>";
						
						$view .= "</thead>";
						
						$view .= "<tbody>";
						
						$c = (int) reset(explode('/',$data['CAP_ACC_TRA_ROW']));

						$i = 0;
						
						$y = 0;

						if (!empty($data['ITEM-TRANSACTION'])):
												
							foreach ($data['ITEM-TRANSACTION'] as $value):
														
							$i++;
																
								unset($name); 
								unset($desc); 
								unset($coa); 
								unset($qty);
								unset($cat);
								unset($rate); 
								unset($amou);
								unset($disc);
								unset($discR);
								unset($discN); 
								unset($tax);
								unset($taxR);
								unset($taxA);

								$type  = (!empty($data['ITEM-TRANSACTION'][$y]['FK_CAP_ACC_ITE_ID'])) ? 'Item' : 'Expense';
								$name  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_ITE_NAME'];
								$desc  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_DESC'];
								$coa   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_COA_NAME'];
								$qty   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_QTY'];
								$cat   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_ITE_TYP_NAME'];
								$rate  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_RATE'];
								$amou  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_AMOUNT'];

								$disc  = $data['ITEM-TRANSACTION'][$y]['DISCOUNT'][0]['CAP_ACC_ITE_NAME'];
								$discR = $data['ITEM-TRANSACTION'][$y]['DISCOUNT'][0]['CAP_ACC_TRA_ITE_RATE'];
								$discN = $data['ITEM-TRANSACTION'][$y]['DISCOUNT'][0]['CAP_ACC_TRA_ITE_AMOUNT'];
								
								$tax   = $data['ITEM-TRANSACTION'][$y]['TAX'][0]['CAP_ACC_ITE_NAME'];
								$taxR  = $data['ITEM-TRANSACTION'][$y]['TAX'][0]['CAP_ACC_TRA_ITE_RATE'];
								$taxA  = $data['ITEM-TRANSACTION'][$y]['TAX'][0]['CAP_ACC_TRA_ITE_AMOUNT'];
								
								$name  = (!empty($name)) ? $name : '&nbsp;' ;
								$desc  = (!empty($desc)) ? ucwords(strtolower($desc)) : '&nbsp;' ;
								$coa   = (!empty($coa))  ? ucwords(strtolower($coa)) : '&nbsp;' ;
								$qty   = (!empty($qty))  ? number_format($qty,$this->getDecimalLength($qty)) : null;	
																
								$realAmount  = ($rate + (($rate / 100) * $taxR)) * $qty;
								
								$realDiscount = ($realAmount / 100) * $discR;
																
								$realAmount  = $realAmount - $realDiscount;
																
									if (strtoupper($cat) != 'SUB TOTAL'):
																											
									$rate = round($rate,4,PHP_ROUND_HALF_UP);
									
									$rate = (!empty($rate)) ? round($rate,4) : null;
									
									else:
									
									$rate = null;
									
									endif;

								$discN  = (!empty($discN)) ? round($discN,3,PHP_ROUND_HALF_UP) : 0;
								$discL += (!empty($discN)) ? $discN : 0;
								
								$disc   = (!empty($disc))  ? $disc." (".$discR."%)" : null;
								$tax    = (!empty($tax))   ? $tax." (".$taxR."%)" : null;
								$amou   = (!empty($amou))  ? bcsub($amou,$discN,4) : null;
								$money = round(bcdiv(bcmul($amou,bcadd(100,$taxR,4),4),100,4),4,PHP_ROUND_HALF_EVEN);

								$money =round($money/(100+$taxR)*100,4,PHP_ROUND_HALF_EVEN);
								
								list ($fund,$fundd) = explode('.',$money);
						
								$fund   = (!empty($fund))  ?  $fund :  '0';
								$fundd  = (!empty($fundd)) ?  substr($fundd,0,3) :  '00';
								$funds  = (!empty($fund)) ?  $money :  0.00;

								$funds  = round($funds,2,PHP_ROUND_HALF_ODD);
								
								$moneyT += $money;

									if (strtoupper($data['ITEM-TRANSACTION'][$y]['CAP_ACC_ITE_TYP_NAME']) != 'SUB TOTAL'):

									$discT     = (!empty($discN)) ? bcadd($discN,$discT,3) 	: $discT;
									$taxT      = (!empty($taxA))  ? bcadd($taxT,$taxA,3) 		: $taxT;
									$total     = (!empty($amou))  ? bcadd($amou,$total,3) 		: $total;
									$totalSub  = (!empty($amou))  ? bcadd($amou,$totalSub,3) 	: $totalSub;
									$totalTax  = (!empty($taxA))  ? bcadd($taxA,$totalTax,3)	: $totalTax;

									elseif (strtoupper($cat) == 'SUB TOTAL'):

									$funds     = round($totalSub,2,PHP_ROUND_HALF_ODD);
									$totalSub  = 0;
									$totalTax  = 0;
									
									endif;

									$view .= "<tr class='accounting-table-tr-type-one'>";
								        
								        $view .= "<td class='accounting-table-td-type-six table-valign-middle'>".$coa."</td>";
									    								
										$view .= "<td class='accounting-table-td-type-six table-valign-middle'>".$desc."</td>";
										
										$view .= "<td class='accounting-table-td-type-six table-valign-middle table-align-right'>".number_format($funds,2)."</td>";
										
									$view .= "</tr>";
									
								$y++;
								
															
							endforeach;
						
						endif;
						
						$grandTotal = number_format(round(bcadd($moneyT,$taxT,3),3,PHP_ROUND_HALF_EVEN),2);
						
						$grandSubTotal = (!empty($moneyT)) ?  number_format($moneyT,2) :  number_format($total,2);
																								
						$view .= "</tbody>";
						
						$view .= "<tfoot>";
																												
						$view .= "<tr class='accounting-table-tr-type-six'><td colspan='2' class='table-valign-middle table-align-right'>Grand Total</td><td class='table-align-right accounting-foot-total'>".$grandTotal."</td></tr>";
																				
						$view .= "</tfoot>";
						
					$view .= "</table>";
										
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
				
				$view .= "<br>";

	    		$view .= "</form>";
	    			    			    			    		
	    	$view .= "</div>";
	    
	    $view .= "</div>";
	    
	return $view;
		    
    }
    
    public function form_editTransfer() {
	    
	    $item   = json_decode($this->getItem(), true);
	    
	    $coa    = json_decode($this->getCoa(), true);
	    
	    $acccur = json_decode($this->getCurrencyAccount(),true);
	    
	    $user 	= unserialize($_SESSION['user']);
	    
    	$id		= $user->getID();

    	$cus	= json_decode($this->getContactCustomer($id),true);
    	    	
    	$data   = json_decode($this->getTransferByID(),true);

	   if (!empty($cus)):
	    	
    		foreach ($cus as $key => $value):
    		
    		$selected  = ($data['CAP_ACC_CON_ID'] == $value['CAP_ACC_CON_ID']) ? "selected='selected'" : null;
    		
    		$customer .= "<option $selected value='".$value['CAP_ACC_CON_ID']."'>".ucwords(strtolower($value['CAP_ACC_CON_CONTACT']))."</option>";
    		
    		endforeach;
	    	
	   endif;
	    
    	if (!empty($acccur)):
    	
    		foreach ($acccur as $key => $value):
    		
    		$selected  = ($data['FK_CAP_ACC_TRA_CURRENCY'] == $value['CAP_ACC_USE_ACC_CUR_ID']) ? "selected='selected'" : null;
    		
    		$currency .= "<option $selected value='".$value['CAP_ACC_USE_ACC_CUR_ID']."'>".$value['CAP_ACC_CUR_NAME']." ".$value['CAP_ACC_CUR_PREFIX']."</option>";
    		
    		endforeach;
    	
    	endif;
	    
	    	if (!empty($item)):
	    	
	    		foreach ($item as $key => $value):
	    		
	    			if ($value['CAP_ACC_ITE_TYP_NAME'] == 'TAX'):
	    			
	    			$itemTax [] = [
	    			
	    			"id"    => $value['CAP_ACC_ITE_ID'],
	    			"label" => $value['CAP_ACC_ITE_NAME'],
	    			"rate"  => $value['COA-PURCHASE'][0]['CAP_ACC_ITE_COA_RATE']
	    			
	    			];
	    				    			
	    			endif;
	    			
	    			if ($value['CAP_ACC_ITE_TYP_NAME'] == 'DISCOUNT'):
	    			
	    			$itemDisc [] = [
	    			
	    			"id"    => $value['CAP_ACC_ITE_ID'],
	    			"label" => $value['CAP_ACC_ITE_NAME'],
	    			"rate"  => $value['COA-PURCHASE'][0]['CAP_ACC_ITE_COA_RATE']
	    			
	    			];
	    			
	    			endif;
	    		
	    		endforeach;
	    
		    	foreach ($item as $key => $value):
		    	
		    	unset($taxInfo);
		    	
		    	$phpItem .= "<option value='".$value['CAP_ACC_ITE_ID']."'>".$value['CAP_ACC_ITE_NAME']."</option>";
		    	
		    	if (!empty($value['COA-PURCHASE'][0]['FK_CAP_ACC_ITE_TAX_ID'])):
		    	
		    	$i = 0;
		    	
		    		foreach ($itemTax as $taxKey => $taxValue):

		    			if ($value['COA-PURCHASE'][0]['FK_CAP_ACC_ITE_TAX_ID'] == $taxValue['id']): 
		    			
		    			$taxInfo = $itemTax[$i]; break; 
		    			
		    			endif;
		    		
		    		$i++;
		    		
		    		endforeach;

		    	endif;
		    	
		    	$autoCompleteItem [] = [
		    	
		    	"id"		=> $value['CAP_ACC_ITE_ID'],
		    	"label" 	=> $value['CAP_ACC_ITE_NAME'],
		    	"desc" 		=> $value['CAP_ACC_ITE_DESC'],
		    	"price" 	=> $value['COA-PURCHASE'][0]['CAP_ACC_ITE_COA_RATE'],
		    	"category" 	=> ucwords(strtolower($value['CAP_ACC_ITE_TYP_NAME'])),
		    	"account"	=> ucwords(strtolower($value['COA-PURCHASE'][0]['CAP_ACC_COA_NAME'])),
		    	"accountid"	=> $value['COA-PURCHASE'][0]['FK_CAP_ACC_COA_ID'],
		    	"taxid"		=> $taxInfo['id'],
		    	"taxname"	=> $taxInfo['label'],
		    	"taxrate"	=> $taxInfo['rate']
		    	
		    	];
		    			    	
		    	endforeach;
	    	
	    	endif;
	    		    	
	    	if (!empty($coa)):
	    	
	    		foreach ($coa as $key => $value):
	    		
    	    		if ($value['CAP_ACC_COA_TYP_NAME'] == 'BANK'):
    	    		
    	    		$phpCoa .= "<option value='".$value['CAP_ACC_ITE_ID']."'>".$value['CAP_ACC_ITE_NAME']."</option>";
    	    			
    	    		$autoCompleteCoa [] = [
    		    	
    		    	"id"		=> $value['CAP_ACC_COA_ID'],
    		    	"label" 	=> ucwords(strtolower($value['CAP_ACC_COA_NAME'])),
    		    	"desc" 		=> $value['CAP_ACC_COA_DESC'],
    		    	"category" 	=> ucwords(strtolower($value['CAP_ACC_COA_TYP_NAME']))
    		    	
    		    	];
    		    	
    		    	endif;
		    	
			    	if ($value['CAP_ACC_COA_TYP_NAME'] == 'BANK'):

			    	$accReceivable .= "<option value='".$value['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value['CAP_ACC_COA_NAME']))."</option>";

			    	endif;
	    		
	    		endforeach;
	    	
	    	endif;

	    $view .= "<script type='text/javascript'>";
	    	    	
	    	$view .= "function accountingInvoiceItem() {";
	    	
	    		$view .= "return ".json_encode($autoCompleteItem);
	    	
	    	$view .= "}";
	    		    	
	    	$view .= "function accountingInvoiceCoa() {";
	    	
	    		$view .= "return ".json_encode($autoCompleteCoa);
	    	
	    	$view .= "}";
	    	
	    	$view .= "function accountingInvoiceTax() {";
	    	
	    		$view .= "return ".json_encode($itemTax);
	    	
	    	$view .= "}";
	    	
	    	$view .= "function accountingInvoiceDiscount() {";
	    	
	    		$view .= "return ".json_encode($itemDisc);
	    	
	    	$view .= "}";
	    
	    $view .= "</script>";
	    	    
	    $view .= "<div class='row accounting-".$this->params."-container'>";
	    
	    $view .= "<div class='span12'>";
	    
	    	$view .= "<h2 class=''>Edit Transfer</h2>";
	    
	    $view .= "</div>";
	    
	    	$view .= "<div class='span12 accounting-".$this->params."-formContainer'>";
	    		
	    	$view .= "<input id='capsuleCSRFToken' type='hidden' value='".$_SESSION['xss']."'>";
	    		
	    		$view .= "<form id='accounting-".$this->params."-form' data-form-type='receipt'>";
	    			    			
	    			$view .= "<div class='accounting-".$this->params."-form-transaction'>";
	    			
	    			$view .= "<input id='transaction-pid' type='hidden' value='".$data['CAP_ACC_TRA_ID']."'>";
	    			
	    			$view .= "<div class='accounting-".$this->params."-form-top'>";
	    							
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='account'>From</label></span>";
						
						$view .= "<div class='controls'><select id='account' class='span2 accounting-chosen'>".$accReceivable."</select></div>";
																														
					$view .= "</div>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='date'>Date</label></span>";
						
						$view .= "<div class='controls'><input class='accounting-date-".md5(rand(0,100))." input-medium' type='text' id='date' value='".date('d-m-Y',strtotime($data['CAP_ACC_TRA_DATE']))."'></div>";
						
					$view .= "</div>";
										
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='number'>Reference #</label></span>";
						
						$view .= "<div class='controls'><input class='input-medium' type='text' id='number' value='".$data['CAP_ACC_TRA_NUMBER']."'></div>";
						
					$view .= "</div>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='currency'>Currency</label></span>";
						
						$view .= "<div class='controls'><select id='currency' class='span2 accounting-chosen'>".$currency."</select></div>";
						
					$view .= "</div>";
																				
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
					
					$view .= "<hr>";
															
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
					
					$view .= "<br>";
					
					$view .= "<div class='span12 accounting-".$this->params."-form-table'>";
																				
						$view .= "<table class='table accounting-transaction-table table-small-font'>";
						
							$view .= "<thead class='table-header-blue-transaction table-header-bold'>";
							
								$view .= "<tr>";
								
								    $view .= "<td class='table-valign-middle table-align-middle'></td>";
								    
								    $view .= "<td class='table-valign-middle table-align-middle'>To</td>";
								    									
									$view .= "<td class='table-valign-middle table-align-middle'>Description</td>";
																		
									$view .= "<td class='table-valign-middle table-align-middle'>Amount</td>";
																		
									$view .= "<td class='table-valign-middle table-align-middle'>Total</td>";
									
									$view .= "<td></td>";
								
								$view .= "</tr>";
							
							$view .= "</thead>";
							
							$view .= "<tbody>";
														
							$c = $data['CAP_ACC_TRA_ROW'];
							
							$y = 0;

    						$i = 0;
    																														
							while ($i != $c):
							
							$i++;

							    if ($i == $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_POSITION']):
							     
							    $pid   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_ID'];
    							$id    = $data['ITEM-TRANSACTION'][$y]['FK_CAP_ACC_ITE_ID'];
								$name  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_ITE_NAME'];
								$desc  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_DESC'];
								$coa   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_COA_NAME'];
								$qty   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_QTY'];
								$cat   = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_ITE_TYP_NAME'];
								$rate  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_RATE'];
								$amou  = $data['ITEM-TRANSACTION'][$y]['CAP_ACC_TRA_ITE_AMOUNT'];
								
								$name  = (!empty($name)) ? $name : '&nbsp;' ;
								$cat   = (!empty($cat)) ? ucwords(strtolower($cat)) : '&nbsp;' ;
								$desc  = (!empty($desc)) ? ucwords(strtolower($desc)) : '&nbsp;' ;
								$coa   = (!empty($coa))  ? ucwords(strtolower($coa)) : '&nbsp;' ;
								$coaID = $data['ITEM-TRANSACTION'][$y]['FK_CAP_ACC_COA_ID'];
							     
								$view .= "<tr class='accounting-table-tr-type-one accounting-transfer-item-row'>";
									
									$view .= "<td class='accounting-table-td-type-three'><i class='icon-align-justify'></i><input id='item-pid' class='accounting-item-pid' type='hidden' value='$pid'><input id='id' class='accounting-item-id' type='hidden' value='$id'><input id='accounting-item-category' class='accounting-item-category' type='hidden' value='$cat'></td>";
								    									
									$view .= "<td class='accounting-table-td-type-one accounting-account'><input class='accounting-table-input-type-six accounting-account-display' type='text' value='$coa'><input class='accounting-account-value' type='hidden' id='account' value='$coaID'></td>";
								    								    								
									$view .= "<td class='accounting-table-td-type-one accounting-description'><input class='accounting-table-input-type-seven' type='text' id='description' value='$desc'></td>";
																		
									$view .= "<td class='accounting-table-td-type-one accounting-price'><input class='accounting-qty' type='hidden' id='qty' value='1'><input class='accounting-table-input-type-one input-align-right' type='text' id='price' value='$rate'></td>";
																		
									$view .= "<td class='accounting-table-td-type-five accounting-amount'><input disabled='disabled' class='accounting-table-input-type-four input-align-right' type='text' id='amount' value='$amou'></td>";
									
									$view .= "<td class='accounting-table-td-type-last '><input type='hidden' id='position' value=''><i class='icon-remove-circle accounting-table-del-line'></i></td>";
								$view .= "</tr>";
								
								$y++;
																
								else:
								
								$view .= "<tr class='accounting-table-tr-type-one accounting-transfer-item-row'>";
									
									$view .= "<td class='accounting-table-td-type-three'><i class='icon-align-justify'></i><input id='id' class='accounting-item-id' type='hidden' value=''><input id='accounting-item-category' class='accounting-item-category' type='hidden' value=''></td>";
								    									
									$view .= "<td class='accounting-table-td-type-one accounting-account'><input class='accounting-table-input-type-six accounting-account-display' type='text' value=''><input class='accounting-account-value' type='hidden' id='account' value=''></td>";
								    								    								
									$view .= "<td class='accounting-table-td-type-one accounting-description'><input class='accounting-table-input-type-seven' type='text' id='description' value=''></td>";
																		
									$view .= "<td class='accounting-table-td-type-one accounting-price'><input class='accounting-qty' type='hidden' id='qty' value='1'><input class='accounting-table-input-type-one input-align-right' type='text' id='price' value=''></td>";
																		
									$view .= "<td class='accounting-table-td-type-five accounting-amount'><input disabled='disabled' class='accounting-table-input-type-four input-align-right' type='text' id='amount' value=''></td>";
									
									$view .= "<td class='accounting-table-td-type-last '><input type='hidden' id='position' value=''><i class='icon-remove-circle accounting-table-del-line'></i></td>";
								$view .= "</tr>";
								
								endif;
																							 
							endwhile;
							
							$view .= "</tbody>";
							
							$view .= "<tfoot>";

								$view .= "<tr class='accounting-table-tr-type-two'><td colspan='4' class='table-valign-middle table-align-right'>Grand Total</td><td class='table-align-right accounting-foot-total'>".number_format($total,2)."</td><td></td></tr>";
																					
							$view .= "</tfoot>";
							
						$view .= "</table>";
																
					$view .= "<a class='pull-left btn btn-mini accounting-table-add-newline'><i class='icon-circle-arrow-right'></i> Add a new line</a>";
					
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
				
				$view .= "<br>";
				
				$view .= "<div class='accounting-action-final'>";
				
				$view .= "<div class='accounting-action-final-container'>";
				
					$view .= "<div class='pull-right default-control-form-final'>";
				
						$view .= "<button id='accounting-transfer-submit-edit' class='btn btn-small btn-success'><i class='icon-ok icon-white'></i> Save & Back</button>";
						
					$view .= "</div>";
					
					$view .= "<div class='pull-right default-control-form-final'>";
				
						$view .= "<button class='btn btn-small btn-info'><i class='icon-circle-arrow-right icon-white'></i> Save & Create New</button>";
						
					$view .= "</div>";
					
					$view .= "<div class='pull-right default-control-form-final'>";
	    		
						$view .= "<a href='".$this->url->builder(3561,'transaction')."' class='btn btn-small'><i class='icon-remove'></i> Cancel</a>";
						
					$view .= "</div>";
	    		
	    		$view .= "</div>";
	    		
	    		$view .= "</div>";
					
	    		$view .= "</form>";
	    			    			    			    		
	    	$view .= "</div>";
	    
	    $view .= "</div>";
	    
	return $view;
		    
    }
    
    public function form_payment_controller() {
	    
	    $view   = $this->optionGear;
	    
	    $actio  = explode('|||',$_GET['actio']);
	    
	    $key    = $_GET['emblem'];
	    
	    $words  = $actio[0];
	    
	    $rjand  = encryption::urlHashDecodingRinjndael($key,$actio[2]);
	    
			if (!is_numeric($rjand)):

			//header('Location: http://www.asacreative.com');

			endif;
	    
		if ($words == 'new'): 
		
			echo $this->form_createPayment(); 
		
		elseif ($words == 'view'):
			
			$this->data = $rjand;
						
			echo $this->form_viewPayment();
			
		elseif ($words == 'edit'):
		
			$this->data = $rjand;
		
			echo $this->form_editPayment();
		
		endif;
	
    }
    
    public function form_createPayment() {
        
        $item   = json_decode($this->getItem(), true);
	    
	    $coa    = json_decode($this->getCoa(), true);
	    
	    $acccur = json_decode($this->getCurrencyAccount(),true);
	    
	    $user 	= unserialize($_SESSION['user']);
	    
    	$id		= $user->getID();
        
        $cus = json_decode($this->getContactCustomerWithOpenInvoice($id),true);
                
        if (!empty($cus)):
	    	
	    		foreach ($cus as $key => $value):
	    		
	    		$customer .= "<option value='".$value['CAP_ACC_CON_ID']."'>".ucwords(strtolower($value['CAP_ACC_CON_CONTACT']))."</option>";
	    		
	    		endforeach;
	    	
	    	endif;
	    
	    	if (!empty($acccur)):
	    	
	    		foreach ($acccur as $key => $value):
	    		
	    		$currency .= "<option value='".$value['CAP_ACC_USE_ACC_CUR_ID']."'>".$value['CAP_ACC_CUR_NAME']." ".$value['CAP_ACC_CUR_PREFIX']."</option>";
	    		
	    		endforeach;
	    	
	    	endif;
	    
	    	if (!empty($item)):
	    	
	    		foreach ($item as $key => $value):
	    		
	    			if ($value['CAP_ACC_ITE_TYP_NAME'] == 'TAX'):
	    			
	    			$itemTax [] = [
	    			
	    			"id"    => $value['CAP_ACC_ITE_ID'],
	    			"label" => $value['CAP_ACC_ITE_NAME'],
	    			"rate"  => $value['COA-PURCHASE'][0]['CAP_ACC_ITE_COA_RATE']
	    			
	    			];
	    				    			
	    			endif;
	    			
	    			if ($value['CAP_ACC_ITE_TYP_NAME'] == 'DISCOUNT'):
	    			
	    			$itemDisc [] = [
	    			
	    			"id"    => $value['CAP_ACC_ITE_ID'],
	    			"label" => $value['CAP_ACC_ITE_NAME'],
	    			"rate"  => $value['COA-PURCHASE'][0]['CAP_ACC_ITE_COA_RATE']
	    			
	    			];
	    			
	    			endif;
	    		
	    		endforeach;
	    
		    	foreach ($item as $key => $value):
		    	
		    	unset($taxInfo);
		    	
		    	$phpItem .= "<option value='".$value['CAP_ACC_ITE_ID']."'>".$value['CAP_ACC_ITE_NAME']."</option>";
		    	
		    	if (!empty($value['COA-PURCHASE'][0]['FK_CAP_ACC_ITE_TAX_ID'])):
		    	
		    	$i = 0;
		    	
		    		foreach ($itemTax as $taxKey => $taxValue):

		    			if ($value['COA-PURCHASE'][0]['FK_CAP_ACC_ITE_TAX_ID'] == $taxValue['id']): 
		    			
		    			$taxInfo = $itemTax[$i]; break; 
		    			
		    			endif;
		    		
		    		$i++;
		    		
		    		endforeach;

		    	endif;
		    	
		    	$autoCompleteItem [] = [
		    	
		    	"id"		=> $value['CAP_ACC_ITE_ID'],
		    	"label" 	=> $value['CAP_ACC_ITE_NAME'],
		    	"desc" 		=> $value['CAP_ACC_ITE_DESC'],
		    	"price" 	=> $value['COA-PURCHASE'][0]['CAP_ACC_ITE_COA_RATE'],
		    	"category" 	=> ucwords(strtolower($value['CAP_ACC_ITE_TYP_NAME'])),
		    	"account"	=> ucwords(strtolower($value['COA-PURCHASE'][0]['CAP_ACC_COA_NAME'])),
		    	"accountid"	=> $value['COA-PURCHASE'][0]['FK_CAP_ACC_COA_ID'],
		    	"taxid"		=> $taxInfo['id'],
		    	"taxname"	=> $taxInfo['label'],
		    	"taxrate"	=> $taxInfo['rate']
		    	
		    	];
		    			    	
		    	endforeach;
	    	
	    	endif;
	    		    	
	    	if (!empty($coa)):
	    	
	    		foreach ($coa as $key => $value):
	    		
    	    		if ($value['CAP_ACC_COA_TYP_NAME'] == 'BANK'):
    	    		
    	    		$phpCoa .= "<option value='".$value['CAP_ACC_ITE_ID']."'>".$value['CAP_ACC_ITE_NAME']."</option>";
    	    			
    	    		$autoCompleteCoa [] = [
    		    	
    		    	"id"		=> $value['CAP_ACC_COA_ID'],
    		    	"label" 	=> ucwords(strtolower($value['CAP_ACC_COA_NAME'])),
    		    	"desc" 		=> $value['CAP_ACC_COA_DESC'],
    		    	"category" 	=> ucwords(strtolower($value['CAP_ACC_COA_TYP_NAME']))
    		    	
    		    	];
    		    	
    		    	endif;
		    	
			    	if ($value['CAP_ACC_COA_TYP_NAME'] == 'BANK'):

			    	$accReceivable .= "<option value='".$value['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value['CAP_ACC_COA_NAME']))."</option>";

			    	endif;
	    		
	    		endforeach;
	    	
	    	endif;

	    $view .= "<script type='text/javascript'>";
	    	    	
	    	$view .= "function accountingInvoiceItem() {";
	    	
	    		$view .= "return ".json_encode($autoCompleteItem);
	    	
	    	$view .= "}";
	    		    	
	    	$view .= "function accountingInvoiceCoa() {";
	    	
	    		$view .= "return ".json_encode($autoCompleteCoa);
	    	
	    	$view .= "}";
	    	
	    	$view .= "function accountingInvoiceTax() {";
	    	
	    		$view .= "return ".json_encode($itemTax);
	    	
	    	$view .= "}";
	    	
	    	$view .= "function accountingInvoiceDiscount() {";
	    	
	    		$view .= "return ".json_encode($itemDisc);
	    	
	    	$view .= "}";
	    
	    $view .= "</script>";
	    	    
	    $view .= "<div class='row accounting-".$this->params."-container'>";
	    
	    $view .= "<div class='span12'>";
	    
	    	$view .= "<h2 class=''>New Payment</h2>";
	    
	    $view .= "</div>";
	    
	    	$view .= "<div class='span12 accounting-".$this->params."-formContainer'>";
	    		
	    	$view .= "<input id='capsuleCSRFToken' type='hidden' value='".$_SESSION['xss']."'>";
	    		
	    		$view .= "<form id='accounting-".$this->params."-form' data-form-type='receipt'>";
	    			
	    			$view .= "<div class='accounting-".$this->params."-form-transaction'>";
	    			
	    			$view .= "<div class='accounting-".$this->params."-form-top'>";
	    			
	    			$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='name'>Customer</label></span>";
						
						$view .= "<div class='controls'><select id='customer-id' data-customer='customer-choser' class='span3 accounting-chosen-single-deselect'><option value=''></option>$customer</select></div>";
																	
					$view .= "</div>";
	    							
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='account'>Deposit To</label></span>";
						
						$view .= "<div class='controls'><select id='account' class='span2 accounting-chosen'>".$accReceivable."</select></div>";
																														
					$view .= "</div>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='date'>Date</label></span>";
						
						$view .= "<div class='controls'><input class='accounting-date-".md5(rand(0,100))." input-medium' type='text' id='date' value='".$data['CAP_ACC_ITE_NAME']."'></div>";
						
					$view .= "</div>";
										
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='number'>Reference #</label></span>";
						
						$view .= "<div class='controls'><input class='input-medium' type='text' id='number' value='".$item['CAP_ACC_ITE_NAME']."'></div>";
						
					$view .= "</div>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='currency'>Currency</label></span>";
						
						$view .= "<div class='controls'><select id='currency' class='span2 accounting-chosen'>".$currency."</select></div>";
						
					$view .= "</div>";
																				
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
					
					$view .= "<hr>";
															
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
					
					$view .= "<br>";
					
					$view .= "<div class='span12 accounting-".$this->params."-form-table'>";
					
					$view .= "<div id='accounting-".$this->params."-table'>";
    						
						$view .= "<table class='table accounting-transaction-table-payment table-small-font'>";
						
							$view .= "<thead class='table-header-blue-transaction table-header-bold'>";
							
								$view .= "<tr>";
								
								    $view .= "<td class='table-valign-middle table-align-middle'><input type='checkbox'></td>";
								    
								    $view .= "<td class='table-valign-middle table-align-left'>Date</td>";
								    									
									$view .= "<td class='table-valign-middle table-align-middle'>Number</td>";
									
									$view .= "<td class='table-valign-middle table-align-middle'>Description</td>";
																		
									$view .= "<td class='table-valign-middle table-align-middle'>Orig. Amount</td>";
									
									$view .= "<td class='table-valign-middle table-align-middle'>Due. Amount</td>";
									
									$view .= "<td class='table-valign-middle table-align-middle'>Payment</td>";
																																			
								$view .= "</tr>";
							
							$view .= "</thead>";
							
							$view .= "<tbody>";
							
							$i = 0;
							
							if (!empty($cus)):
														
    							foreach ($cus as $key => $value):

    							     if (!empty($value['TRANSACTION-LIST'])):
    								 
    								 $i++;
    								 																						
            							foreach ($value['TRANSACTION-LIST'] as $key2 => $value2):
            							
            							$date = (!empty($value2['CAP_ACC_TRA_DATE'])) ? date('d-m-Y',strtotime($value2['CAP_ACC_TRA_DATE'])) : null;
            							
            							$dueT = $value2['CAP_ACC_TRA_TOTALLEFT'];
            							
        								$view .= "<tr class='accounting-table-tr-type-one-hidden accounting-payment-item-row' data-customer='".$value['CAP_ACC_CON_ID']."'>";
        									
        									$view .= "<td class='accounting-table-td-type-three table-align-middle'><input id='id' type='checkbox' value='".$value2['CAP_ACC_TRA_ID']."'></td>";
        								    									
        									$view .= "<td class='accounting-table-td-type-one accounting-table-td-align-left accounting-account'>$date</td>";
        								    								    								
        									$view .= "<td class='accounting-table-td-type-one accounting-table-td-align-center accounting-table-td-align-center accounting-price'>".$value2['CAP_ACC_TRA_NUMBER']."</td>";
        								    
        								    $view .= "<td class='accounting-table-td-type-one accounting-description'><input class='accounting-table-input-type-six' type='text' id='description' value=''></td>";
        								    								    																		
        									$view .= "<td class='accounting-table-td-type-one accounting-table-td-align-right accounting-amount'>".number_format($value2['CAP_ACC_TRA_TOTAL'],2)."<input disabled='disabled' class='accounting-table-input-type-four input-align-right' type='hidden' id='amount-integer' value='".$value2['CAP_ACC_TRA_TOTAL']."'></td>";
        									
        									$view .= "<td class='accounting-table-td-type-one accounting-table-td-align-right accounting-price'>".number_format($dueT,2)."<input disabled='disabled' class='accounting-table-input-type-four input-align-right' type='hidden' id='price-integer' value='".$dueT."'></td>";
        									
        									$view .= "<td class='accounting-table-td-type-one accounting-amount'><input class='accounting-qty' type='hidden' id='qty' value='1'><input class='accounting-table-input-type-eight input-align-right accounting-payment-price' type='text' id='price' value='' autocomplete='off'></td>";
        									
        								$view .= "</tr>";
    							
    								    endforeach;
    								 
    							     endif;
    							
    							endforeach;
							
							endif;

							if ($i > 0):
							
							     $view .= "<tr class='accounting-table-tr-type-one accounting-transfer-item-row' data-customer=''>";
    									
    									$view .= "<td colspan='7' class='accounting-table-td-type-three table-align-middle'>- Please select a customer -</td>";
    								    									    									
    				             $view .= "</tr>";
    				             
    				        else:
    				        
    				            $view .= "<tr class='accounting-table-tr-type-one accounting-transfer-item-row' data-customer=''>";
    									
    									$view .= "<td colspan='7' class='accounting-table-td-type-three table-align-middle'>- All invoice are paid -</td>";
    								    									    									
    				             $view .= "</tr>";
							
							endif;
							
							$view .= "</tbody>";
							
							$view .= "<tfoot>";
															
								$view .= "<tr class='accounting-table-tr-type-two'><td colspan='6' class='table-valign-middle table-align-right'>Grand Total</td><td class='table-align-right accounting-foot-total'>0.00</td></tr>";
																					
							$view .= "</tfoot>";
							
						$view .= "</table>";
											
					$view .= "</div>";
										
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
				
				$view .= "<br>";
				
				$view .= "<div class='accounting-action-final'>";
				
				$view .= "<div class='accounting-action-final-container'>";
				
					$view .= "<div class='pull-right default-control-form-final'>";
				
						$view .= "<button type='button' id='accounting-payment-submit-new' class='btn btn-small btn-success' data-loading-text='Please Wait...'><i class='icon-ok icon-white'></i> Save & Back</button>";
						
					$view .= "</div>";
					
					$view .= "<div class='pull-right default-control-form-final'>";
				
						$view .= "<button class='btn btn-small btn-info'><i class='icon-circle-arrow-right icon-white'></i> Save & Create New</button>";
						
					$view .= "</div>";
					
					$view .= "<div class='pull-right default-control-form-final'>";
	    		
						$view .= "<a href='".$this->url->builder(3561,'transaction')."' class='btn btn-small'><i class='icon-remove'></i> Cancel</a>";
						
					$view .= "</div>";
	    		
	    		$view .= "</div>";
	    		
	    		$view .= "</div>";
					
	    		$view .= "</form>";
	    			    			    			    		
	    	$view .= "</div>";
	    
	    $view .= "</div>";
	   
    echo $view;
        
    }
    
    public function form_viewPayment() {
        
        $item   = json_decode($this->getItem(), true);
	    
	    $coa    = json_decode($this->getCoa(), true);
	    
	    $acccur = json_decode($this->getCurrencyAccount(),true);
	    
	    $user 	= unserialize($_SESSION['user']);
	    
    	$id		= $user->getID();
        
        $data   = json_decode($this->getPaymentByID(),true);
        
        $crypt  = encryption::urlHashEncodingRinjndael($_SESSION['xss'],$data['CAP_ACC_TRA_ID']);
                	    	    
        $date   = (!empty($data['CAP_ACC_TRA_DATE'])) ? date('d, F Y',strtotime($data['CAP_ACC_TRA_DATE'])) : null;
        
        $number = (!empty($data['CAP_ACC_TRA_NUMBER'])) ? $data['CAP_ACC_TRA_NUMBER'] : null;
        
        $curr   = (!empty($data['FK_CAP_ACC_TRA_CURRENCY'])) ? $data['CAP_ACC_USE_ACC_CUR_NAME']." ".ucwords(strtolower($data['CAP_ACC_CUR_PREFIX'])) : null;
        
        $acc    = (!empty($data['ACCOUNT-TRANSACTION'])) ? ucwords(strtolower($data['ACCOUNT-TRANSACTION'][0]['CAP_ACC_COA_NAME'])) : null;
        
        $cust   = (!empty($data['CAP_ACC_CON_FIRSTNAME'])) ? ucwords(strtolower($data['CAP_ACC_CON_FIRSTNAME'].' '.$data['CAP_ACC_CON_LASTNAME'])) : null;
        
	    $view .= "<div class='row accounting-".$this->params."-container'>";
	    
	    $view .= "<div class='span12'>";
	    
	    	$view .= "<h2 class=''>View Payment</h2>";
	    
	    $view .= "</div>";
	    
	    	$view .= "<div class='span12 accounting-".$this->params."-formViewContainer'>";
	    		
	    	$view .= "<div class='span1 btn-group pull-left'>";
		   
		   	  	$view .= "<a class='btn btn-info btn-small dropdown-toggle' data-toggle='dropdown' href='#accounting-".$this->params."-coaAdd'><i class='icon-edit icon-white'></i> Options <span class='caret'></span></a>";
		   	  	
		   	  		$view .= "<ul class='dropdown-menu'>";
		   	  			
		   	  			$view .= "<li><a href='#'><i class='icon-ban-circle'></i> Void</a></li>";
		   	  			
		   	  			$view .= "<li><a href='".$this->url->builder(3805,'payment')."?actio=edit|||payment|||".$crypt."&emblem=".$_SESSION['xss']."'><i class='icon-pencil'></i> Edit</a></li>";
		   	  					   	  					   	  		
		   	  		$view .= "</ul>";
									  					
		   	$view .= "</div>";
		   
		    $view .= "<div class='clearfix'></div>";
	    	
	    	$view .= "<hr>";
	    		
	    	$view .= "<input id='capsuleCSRFToken' type='hidden' value='".$_SESSION['xss']."'>";
	    		
	    		$view .= "<form id='accounting-".$this->params."-form' data-form-type='receipt'>";
	    			
	    			$view .= "<div class='accounting-".$this->params."-form-transaction'>";
	    			
	    			$view .= "<div class='accounting-".$this->params."-form-top'>";
	    			
	    			$view .= "<div class='default-control span3'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='name'>Customer</label></span>";
						
						$view .= "<div class='controls'>$cust</div>";
																	
					$view .= "</div>";
	    							
					$view .= "<div class='default-control span2'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='account'>Deposit To</label></span>";
						
						$view .= "<div class='controls'>$acc</div>";
																														
					$view .= "</div>";
					
					$view .= "<div class='default-control span2'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='date'>Date</label></span>";
						
						$view .= "<div class='controls'>$date</div>";
						
					$view .= "</div>";
										
					$view .= "<div class='default-control span2'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='number'>Reference #</label></span>";
						
						$view .= "<div class='controls'>$number</div>";
						
					$view .= "</div>";
					
					$view .= "<div class='default-control span2'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='currency'>Currency</label></span>";
						
						$view .= "<div class='controls'>$curr</div>";
						
					$view .= "</div>";
																				
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
					
					$view .= "<hr>";
					
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
					
					$view .= "<br>";
					
					$view .= "<div class='span12 accounting-".$this->params."-form-table'>";
					
					$view .= "<div id='accounting-".$this->params."-table'>";
    						
						$view .= "<table class='table accounting-transaction-table table-small-font'>";
						
							$view .= "<thead class='table-header-grey-transaction table-header-bold'>";
							
								$view .= "<tr>";
																    
								    $view .= "<td class='table-valign-middle table-align-middle'>Date</td>";
								    									
									$view .= "<td class='table-valign-middle table-align-middle'>Number</td>";
									
									$view .= "<td class='table-valign-middle table-align-middle'>Description</td>";
																		
									$view .= "<td class='table-valign-middle table-align-middle'>Orig. Amount</td>";
									
									//$view .= "<td class='table-valign-middle table-align-middle'>Due. Amount</td>";
									
									$view .= "<td class='table-valign-middle table-align-middle'>Payment</td>";
																																			
								$view .= "</tr>";
							
							$view .= "</thead>";
							
							$view .= "<tbody>";
							
							$i = 0;
							
							if (!empty($data['ITEM-TRANSACTION'])):
							
    							foreach ($data['ITEM-TRANSACTION'] as $key => $value):
    							
    							$date = (!empty($value['CAP_ACC_TRA_DATE'])) ? date('d-m-Y',strtotime($value['CAP_ACC_TRA_DATE'])) : null;
    							
    							$ori  = (!empty($value['CAP_ACC_TRA_TOTAL'])) ? number_format($value['CAP_ACC_TRA_TOTAL'],2) : null;
    							
    							$rate = (!empty($value['CAP_ACC_TRA_ITE_RATE'])) ? number_format($value['CAP_ACC_TRA_ITE_RATE'],2) : null;
    							
    							$amo  = (!empty($value['CAP_ACC_TRA_ITE_AMOUNT'])) ? number_format($value['CAP_ACC_TRA_ITE_AMOUNT'],2) : null;
    							
    							$ttl += $value['CAP_ACC_TRA_ITE_AMOUNT'];
    							
								$view .= "<tr class='accounting-table-tr-type-one accounting-payment-item-row' data-customer='".$value['CAP_ACC_CON_ID']."'>";
								
									$view .= "<td class='accounting-table-td-type-one accounting-table-td-align-center accounting-account'>$date</td>";
									
									$view .= "<td class='accounting-table-td-type-one accounting-table-td-align-center accounting-price'>".$value['CAP_ACC_TRA_NUMBER']."</td>";
				                    
				                    $view .= "<td class='accounting-table-td-type-one accounting-table-td-align-left accounting-price'>".ucwords(strtolower($value['CAP_ACC_TRA_ITE_DESC']))."</td>";
				                    																		    													
									//$view .= "<td class='accounting-table-td-type-one accounting-table-td-align-right accounting-amount'>".$ori."</td>";
									
									$view .= "<td class='accounting-table-td-type-one accounting-table-td-align-right accounting-price'>".$rate."</td>";
									
									$view .= "<td class='accounting-table-td-type-one accounting-table-td-align-right'>".$amo."</td>";
									
								$view .= "</tr>";
    							    							
    							endforeach;
							
							endif;
							
							$view .= "</tbody>";
							
							$view .= "<tfoot>";
															
								$view .= "<tr class='accounting-table-tr-type-two'><td colspan='4' class='table-valign-middle table-align-right'>Grand Total</td><td class='table-align-right accounting-foot-total'>".number_format($ttl,2)."</td></tr>";
																					
							$view .= "</tfoot>";
							
						$view .= "</table>";
											
					$view .= "</div>";
					
					//$view .= "<a class='pull-left btn btn-mini accounting-table-add-newline'><i class='icon-circle-arrow-right'></i> Add a new line</a>";
					
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
				
				$view .= "<br>";
				
	    		
	    		$view .= "</div>";
					
	    		$view .= "</form>";
	    			    			    			    		
	    	$view .= "</div>";
	    
	    $view .= "</div>";
	   
    echo $view;
        
    }
    
    public function form_editPayment() {
        
        $item   = json_decode($this->getItem(), true);
	    
	    $coa    = json_decode($this->getCoa(), true);
	    
	    $acccur = json_decode($this->getCurrencyAccount(),true);
	    
	    $user 	= unserialize($_SESSION['user']);
	    
    	$id		= $user->getID();
    	
    	$data   = json_decode($this->getPaymentByID(),true);
    	
    	//print_r($data); echo '<br><br>';
        
        $cus = json_decode($this->getContactCustomerWithOpenInvoiceEdited($id,$data['ITEM-TRANSACTION']),true);
        
        //print_r($cus);
                
        if (!empty($cus)):
	    	
	    		foreach ($cus as $key => $value):
	    		
                    if ($data['CAP_ACC_CON_ID'] == $value['CAP_ACC_CON_ID']):
                        
                        $selectedCustomer = $value['CAP_ACC_CON_ID'];
                        
                        $customer .= "<option selected='selected' value='".$value['CAP_ACC_CON_ID']."'>".ucwords(strtolower($value['CAP_ACC_CON_CONTACT']))."</option>";
                    
                    else:
                    
                        $customer .= "<option value='".$value['CAP_ACC_CON_ID']."'>".ucwords(strtolower($value['CAP_ACC_CON_CONTACT']))."</option>";
                    
                    endif;
	    			    		
	    		endforeach;
	    	
	    	endif;
	    
	    	if (!empty($acccur)):
	    	
	    		foreach ($acccur as $key => $value):
	    		
                    if ($data['FK_CAP_ACC_TRA_CURRENCY'] == $value['CAP_ACC_USE_ACC_CUR_ID']):
                    
                        $currency .= "<option selected='selected' value='".$value['CAP_ACC_USE_ACC_CUR_ID']."'>".$value['CAP_ACC_CUR_NAME']." ".$value['CAP_ACC_CUR_PREFIX']."</option>";
                    
                    else:
                    
                        $currency .= "<option value='".$value['CAP_ACC_USE_ACC_CUR_ID']."'>".$value['CAP_ACC_CUR_NAME']." ".$value['CAP_ACC_CUR_PREFIX']."</option>";
                    
                    endif;
	    			    		
	    		endforeach;
	    	
	    	endif;
	    
	    	if (!empty($item)):
	    	
	    		foreach ($item as $key => $value):
	    		
	    			if ($value['CAP_ACC_ITE_TYP_NAME'] == 'TAX'):
	    			
	    			$itemTax [] = [
	    			
	    			"id"    => $value['CAP_ACC_ITE_ID'],
	    			"label" => $value['CAP_ACC_ITE_NAME'],
	    			"rate"  => $value['COA-PURCHASE'][0]['CAP_ACC_ITE_COA_RATE']
	    			
	    			];
	    				    			
	    			endif;
	    			
	    			if ($value['CAP_ACC_ITE_TYP_NAME'] == 'DISCOUNT'):
	    			
	    			$itemDisc [] = [
	    			
	    			"id"    => $value['CAP_ACC_ITE_ID'],
	    			"label" => $value['CAP_ACC_ITE_NAME'],
	    			"rate"  => $value['COA-PURCHASE'][0]['CAP_ACC_ITE_COA_RATE']
	    			
	    			];
	    			
	    			endif;
	    		
	    		endforeach;
	    
		    	foreach ($item as $key => $value):
		    	
		    	unset($taxInfo);
		    	
		    	$phpItem .= "<option value='".$value['CAP_ACC_ITE_ID']."'>".$value['CAP_ACC_ITE_NAME']."</option>";
		    	
		    	if (!empty($value['COA-PURCHASE'][0]['FK_CAP_ACC_ITE_TAX_ID'])):
		    	
		    	$i = 0;
		    	
		    		foreach ($itemTax as $taxKey => $taxValue):

		    			if ($value['COA-PURCHASE'][0]['FK_CAP_ACC_ITE_TAX_ID'] == $taxValue['id']): 
		    			
		    			$taxInfo = $itemTax[$i]; break; 
		    			
		    			endif;
		    		
		    		$i++;
		    		
		    		endforeach;

		    	endif;
		    	
		    	$autoCompleteItem [] = [
		    	
		    	"id"		=> $value['CAP_ACC_ITE_ID'],
		    	"label" 	=> $value['CAP_ACC_ITE_NAME'],
		    	"desc" 		=> $value['CAP_ACC_ITE_DESC'],
		    	"price" 	=> $value['COA-PURCHASE'][0]['CAP_ACC_ITE_COA_RATE'],
		    	"category" 	=> ucwords(strtolower($value['CAP_ACC_ITE_TYP_NAME'])),
		    	"account"	=> ucwords(strtolower($value['COA-PURCHASE'][0]['CAP_ACC_COA_NAME'])),
		    	"accountid"	=> $value['COA-PURCHASE'][0]['FK_CAP_ACC_COA_ID'],
		    	"taxid"		=> $taxInfo['id'],
		    	"taxname"	=> $taxInfo['label'],
		    	"taxrate"	=> $taxInfo['rate']
		    	
		    	];
		    			    	
		    	endforeach;
	    	
	    	endif;
	    		    	
	    	if (!empty($coa)):
	    	
	    		foreach ($coa as $key => $value):
	    		
    	    		if ($value['CAP_ACC_COA_TYP_NAME'] == 'BANK'):
    	    		
    	    		$phpCoa .= "<option value='".$value['CAP_ACC_ITE_ID']."'>".$value['CAP_ACC_ITE_NAME']."</option>";
    	    			
    	    		$autoCompleteCoa [] = [
    		    	
    		    	"id"		=> $value['CAP_ACC_COA_ID'],
    		    	"label" 	=> ucwords(strtolower($value['CAP_ACC_COA_NAME'])),
    		    	"desc" 		=> $value['CAP_ACC_COA_DESC'],
    		    	"category" 	=> ucwords(strtolower($value['CAP_ACC_COA_TYP_NAME']))
    		    	
    		    	];
    		    	
    		    	endif;
		    	
			    	if ($value['CAP_ACC_COA_TYP_NAME'] == 'BANK'):
			    	    
			    	    if ($data['ACCOUNT-TRANSACTION'][0]['FK_CAP_ACC_COA_ID'] == $value['CAP_ACC_COA_ID']):
			    	    
			    	        $accReceivable .= "<option selected='selected' value='".$value['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value['CAP_ACC_COA_NAME']))."</option>";
			    	    
			    	    else:
			    	    
			    	        $accReceivable .= "<option value='".$value['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value['CAP_ACC_COA_NAME']))."</option>";
			    	    
			    	    endif;

			    	endif;
	    		
	    		endforeach;
	    	
	    	endif;

	    $view .= "<script type='text/javascript'>";
	    	    	
	    	$view .= "function accountingInvoiceItem() {";
	    	
	    		$view .= "return ".json_encode($autoCompleteItem);
	    	
	    	$view .= "}";
	    		    	
	    	$view .= "function accountingInvoiceCoa() {";
	    	
	    		$view .= "return ".json_encode($autoCompleteCoa);
	    	
	    	$view .= "}";
	    	
	    	$view .= "function accountingInvoiceTax() {";
	    	
	    		$view .= "return ".json_encode($itemTax);
	    	
	    	$view .= "}";
	    	
	    	$view .= "function accountingInvoiceDiscount() {";
	    	
	    		$view .= "return ".json_encode($itemDisc);
	    	
	    	$view .= "}";
	    
	    $view .= "</script>";
	    	    
	    $view .= "<div class='row accounting-".$this->params."-container'>";
	    
	    $view .= "<div class='span12'>";
	    
	    	$view .= "<h2 class=''>Edit Payment</h2>";
	    
	    $view .= "</div>";
	    
	    	$view .= "<div class='span12 accounting-".$this->params."-formContainer'>";
	    		
	    	$view .= "<input id='capsuleCSRFToken' type='hidden' value='".$_SESSION['xss']."'>";
	    		
	    		$view .= "<form id='accounting-".$this->params."-form' data-form-type='receipt'>";
	    			
	    			$view .= "<div class='accounting-".$this->params."-form-transaction'>";
	    			
	    			$view .= "<input id='transaction-pid' type='hidden' value='".$data['CAP_ACC_TRA_ID']."'>";
	    			
	    			$view .= "<div class='accounting-".$this->params."-form-top'>";
	    			
	    			$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='name'>Customer</label></span>";
						
						$view .= "<div class='controls'><select id='customer-id' data-customer='customer-choser' class='span3 accounting-chosen-single-deselect'><option value=''></option>$customer</select></div>";
																	
					$view .= "</div>";
	    							
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='account'>Deposit To</label></span>";
						
						$view .= "<div class='controls'><select id='account' class='span2 accounting-chosen'>".$accReceivable."</select></div>";
																														
					$view .= "</div>";
					
					$date  = (!empty($data['CAP_ACC_TRA_DATE'])) ? date('d-m-Y',strtotime($data['CAP_ACC_TRA_DATE'])) : null;
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='date'>Date</label></span>";
						
						$view .= "<div class='controls'><input class='accounting-date-".md5(rand(0,100))." input-medium' type='text' id='date' value='".$date."'></div>";
						
					$view .= "</div>";
					
					$num   = (!empty($data['CAP_ACC_TRA_NUMBER'])) ? $data['CAP_ACC_TRA_NUMBER'] : null;
										
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='number'>Reference #</label></span>";
						
						$view .= "<div class='controls'><input class='input-medium' type='text' id='number' value='".$num."'></div>";
						
					$view .= "</div>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='currency'>Currency</label></span>";
						
						$view .= "<div class='controls'><select id='currency' class='span2 accounting-chosen'>".$currency."</select></div>";
						
					$view .= "</div>";
																				
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
					
					$view .= "<hr>";
															
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
					
					$view .= "<br>";
					
					$view .= "<div class='span12 accounting-".$this->params."-form-table'>";
					
					$view .= "<div id='accounting-".$this->params."-table'>";
    						
						$view .= "<table class='table accounting-transaction-table-payment table-small-font'>";
						
							$view .= "<thead class='table-header-blue-transaction table-header-bold'>";
							
								$view .= "<tr>";
								
								    $view .= "<td class='table-valign-middle table-align-middle'><input type='checkbox'></td>";
								    
								    $view .= "<td class='table-valign-middle table-align-left'>Date</td>";
								    									
									$view .= "<td class='table-valign-middle table-align-middle'>Number</td>";
									
									$view .= "<td class='table-valign-middle table-align-middle'>Description</td>";
																		
									$view .= "<td class='table-valign-middle table-align-middle'>Orig. Amount</td>";
									
									$view .= "<td class='table-valign-middle table-align-middle'>Due. Amount</td>";
									
									$view .= "<td class='table-valign-middle table-align-middle'>Payment</td>";
																																			
								$view .= "</tr>";
							
							$view .= "</thead>";
							
							$view .= "<tbody>";
							
							$i = 0;
							
							if (!empty($cus)):
														
    							foreach ($cus as $key => $value):

    							     if (!empty($value['TRANSACTION-LIST'])):
    								 
    								 $i++;
    								 																						
            							foreach ($value['TRANSACTION-LIST'] as $key2 => $value2):
            							
            							$date = (!empty($value2['CAP_ACC_TRA_DATE'])) ? date('d-m-Y',strtotime($value2['CAP_ACC_TRA_DATE'])) : null;
            							
            							$dueT = $value2['CAP_ACC_TRA_TOTALLEFT'];
            							
                							if ($selectedCustomer == $value['CAP_ACC_CON_ID']):
                							 
                							unset($result);
                							
                								if (!empty($data['ITEM-TRANSACTION'])):
                							
		                                                foreach ($data['ITEM-TRANSACTION'] as $key3 => $value3):
		                                                
		                                                    if ($value3['FK_CAP_ACC_TRA_ID_PAYMENT'] == $value2['CAP_ACC_TRA_ID']):
		                                                    
		                                                        $result = $value3; break;
		                                                    
		                                                    endif;
		                                                
		                                                endforeach;
                                                
                                                endif;
                                            
                                            $chck   = (!empty($result)) ? "checked='checked'" : null;
                                            
                                            $total += (!empty($result['CAP_ACC_TRA_ITE_AMOUNT'])) ? $result['CAP_ACC_TRA_ITE_AMOUNT'] : 0;

            								$view .= "<tr class='accounting-table-tr-type-one accounting-payment-item-row' data-customer='".$value['CAP_ACC_CON_ID']."'>";
            									
            									$view .= "<td class='accounting-table-td-type-three table-align-middle'><input id='item-pid' type='hidden' value='".$result['CAP_ACC_TRA_ITE_ID']."'><input id='id' class='accounting-checkbox-checker' $chck type='checkbox' value='".$value2['CAP_ACC_TRA_ID']."'></td>";
            								    									
            									$view .= "<td class='accounting-table-td-type-one accounting-table-td-align-left accounting-account'>$date</td>";
            								    								    								
            									$view .= "<td class='accounting-table-td-type-one accounting-table-td-align-center accounting-table-td-align-center accounting-price'>".$value2['CAP_ACC_TRA_NUMBER']."</td>";
            								    
            								    $view .= "<td class='accounting-table-td-type-one accounting-description'><input class='accounting-table-input-type-six' type='text' id='description' value='".ucwords(strtolower($result['CAP_ACC_TRA_ITE_DESC']))."'></td>";
            								    								    																		
            									$view .= "<td class='accounting-table-td-type-one accounting-table-td-align-right accounting-amount'>".number_format($value2['CAP_ACC_TRA_TOTAL'],2)."<input disabled='disabled' class='accounting-table-input-type-four input-align-right' type='hidden' id='amount-integer' value='".$value2['CAP_ACC_TRA_TOTAL']."'></td>";
            									
            									$view .= "<td class='accounting-table-td-type-one accounting-table-td-align-right accounting-price'>".number_format($dueT,2)."<input disabled='disabled' class='accounting-table-input-type-four input-align-right' type='hidden' id='price-integer' value='".$dueT."'></td>";

            									$view .= "<td class='accounting-table-td-type-one accounting-amount'><input class='accounting-qty' type='hidden' id='qty' value='1'><input class='accounting-table-input-type-eight input-align-right accounting-payment-price' type='text' id='price' value='".$result['CAP_ACC_TRA_ITE_AMOUNT']."' autocomplete='off'></td>";
            									
            								$view .= "</tr>";
            								
            								else:
            								
            								$view .= "<tr class='accounting-table-tr-type-one-hidden accounting-payment-item-row' data-customer='".$value['CAP_ACC_CON_ID']."'>";
            									
            									$view .= "<td class='accounting-table-td-type-three table-align-middle'><input id='item-pid' type='hidden' value=''><input id='id' type='checkbox' value='".$value2['CAP_ACC_TRA_ID']."'></td>";
            								    									
            									$view .= "<td class='accounting-table-td-type-one accounting-table-td-align-left accounting-account'>$date</td>";
            								    								    								
            									$view .= "<td class='accounting-table-td-type-one accounting-table-td-align-center accounting-table-td-align-center accounting-price'>".$value2['CAP_ACC_TRA_NUMBER']."</td>";
            								    
            								    $view .= "<td class='accounting-table-td-type-one accounting-description'><input class='accounting-table-input-type-six' type='text' id='description' value='".$result['CAP_ACC_TRA_ITE_DESC']."'></td>";
            								    								    																		
            									$view .= "<td class='accounting-table-td-type-one accounting-table-td-align-right accounting-amount'>".number_format($value2['CAP_ACC_TRA_TOTAL'],2)."<input disabled='disabled' class='accounting-table-input-type-four input-align-right' type='hidden' id='amount-integer' value='".$value2['CAP_ACC_TRA_TOTAL']."'></td>";
            									
            									$view .= "<td class='accounting-table-td-type-one accounting-table-td-align-right accounting-price'>".number_format($dueT,2)."<input disabled='disabled' class='accounting-table-input-type-four input-align-right' type='hidden' id='price-integer' value='".$dueT."'></td>";
            									
            									$view .= "<td class='accounting-table-td-type-one accounting-amount'><input class='accounting-qty' type='hidden' id='qty' value='1'><input class='accounting-table-input-type-eight input-align-right accounting-payment-price' type='text' id='price' value='' autocomplete='off'></td>";
            									
            								$view .= "</tr>";
            								
            								endif;
    							
    								    endforeach;
    								 
    							     endif;
    							
    							endforeach;
							
							endif;

							if ($i > 0):
							
							     $view .= "<tr class='accounting-table-tr-type-one-hidden accounting-transfer-item-row' data-customer=''>";
    									
    									$view .= "<td colspan='7' class='accounting-table-td-type-three table-align-middle'>- Please select a customer -</td>";
    								    									    									
    				             $view .= "</tr>";
    				             
    				        else:
    				        
    				            $view .= "<tr class='accounting-table-tr-type-one-hidden accounting-transfer-item-row' data-customer=''>";
    									
    									$view .= "<td colspan='7' class='accounting-table-td-type-three table-align-middle'>- All invoice are paid -</td>";
    								    									    									
    				             $view .= "</tr>";
							
							endif;
							
							$view .= "</tbody>";
							
							$view .= "<tfoot>";
															
								$view .= "<tr class='accounting-table-tr-type-two'><td colspan='6' class='table-valign-middle table-align-right'>Grand Total</td><td class='table-align-right accounting-foot-total'>".number_format($total,2)."</td></tr>";
																					
							$view .= "</tfoot>";
							
						$view .= "</table>";
											
					$view .= "</div>";
										
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
				
				$view .= "<br>";
				
				$view .= "<div class='accounting-action-final'>";
				
				$view .= "<div class='accounting-action-final-container'>";
				
					$view .= "<div class='pull-right default-control-form-final'>";
				
						$view .= "<button type='button' id='accounting-payment-submit-edit' class='btn btn-small btn-success' data-loading-text='Please Wait...'><i class='icon-ok icon-white'></i> Save & Back</button>";
						
					$view .= "</div>";
					
					$view .= "<div class='pull-right default-control-form-final'>";
				
						$view .= "<button class='btn btn-small btn-info'><i class='icon-circle-arrow-right icon-white'></i> Save & Create New</button>";
						
					$view .= "</div>";
					
					$view .= "<div class='pull-right default-control-form-final'>";
	    		
						$view .= "<a href='".$this->url->builder(3561,'transaction')."' class='btn btn-small'><i class='icon-remove'></i> Cancel</a>";
						
					$view .= "</div>";
	    		
	    		$view .= "</div>";
	    		
	    		$view .= "</div>";
					
	    		$view .= "</form>";
	    			    			    			    		
	    	$view .= "</div>";
	    
	    $view .= "</div>";
	   
    echo $view;
        
    }
    
    public function form_paybill_controller() {
	    
	    $view   = $this->optionGear;
	    
	    $actio  = explode('|||',$_GET['actio']);
	    
	    $key    = $_GET['emblem'];
	    
	    $words  = $actio[0];
	    
	    $rjand  = encryption::urlHashDecodingRinjndael($key,$actio[2]);
	    
			if (!is_numeric($rjand)):

			//header('Location: http://www.asacreative.com');

			endif;
	    
		if ($words == 'new'): 
		
			echo $this->form_createPaybill(); 
		
		elseif ($words == 'view'):
			
			$this->data = $rjand;
						
			echo $this->form_viewPaybill();
			
		elseif ($words == 'edit'):
		
			$this->data = $rjand;
		
			echo $this->form_editPaybill();
		
		endif;
	
    }
    
    public function form_createPaybill() {
        
        $item   = json_decode($this->getItem(), true);
	    
	    $coa    = json_decode($this->getCoa(), true);
	    
	    $acccur = json_decode($this->getCurrencyAccount(),true);
	    
	    $user 	= unserialize($_SESSION['user']);
	    
    	$id		= $user->getID();
        
        $cus = json_decode($this->getContactCustomerWithOpenBill($id),true);
                
        if (!empty($cus)):
	    	
	    		foreach ($cus as $key => $value):
	    		
	    		$customer .= "<option value='".$value['CAP_ACC_CON_ID']."'>".ucwords(strtolower($value['CAP_ACC_CON_CONTACT']))."</option>";
	    		
	    		endforeach;
	    	
	    	endif;
	    
	    	if (!empty($acccur)):
	    	
	    		foreach ($acccur as $key => $value):
	    		
	    		$currency .= "<option value='".$value['CAP_ACC_USE_ACC_CUR_ID']."'>".$value['CAP_ACC_CUR_NAME']." ".$value['CAP_ACC_CUR_PREFIX']."</option>";
	    		
	    		endforeach;
	    	
	    	endif;
	    
	    	if (!empty($item)):
	    	
	    		foreach ($item as $key => $value):
	    		
	    			if ($value['CAP_ACC_ITE_TYP_NAME'] == 'TAX'):
	    			
	    			$itemTax [] = [
	    			
	    			"id"    => $value['CAP_ACC_ITE_ID'],
	    			"label" => $value['CAP_ACC_ITE_NAME'],
	    			"rate"  => $value['COA-PURCHASE'][0]['CAP_ACC_ITE_COA_RATE']
	    			
	    			];
	    				    			
	    			endif;
	    			
	    			if ($value['CAP_ACC_ITE_TYP_NAME'] == 'DISCOUNT'):
	    			
	    			$itemDisc [] = [
	    			
	    			"id"    => $value['CAP_ACC_ITE_ID'],
	    			"label" => $value['CAP_ACC_ITE_NAME'],
	    			"rate"  => $value['COA-PURCHASE'][0]['CAP_ACC_ITE_COA_RATE']
	    			
	    			];
	    			
	    			endif;
	    		
	    		endforeach;
	    
		    	foreach ($item as $key => $value):
		    	
		    	unset($taxInfo);
		    	
		    	$phpItem .= "<option value='".$value['CAP_ACC_ITE_ID']."'>".$value['CAP_ACC_ITE_NAME']."</option>";
		    	
		    	if (!empty($value['COA-PURCHASE'][0]['FK_CAP_ACC_ITE_TAX_ID'])):
		    	
		    	$i = 0;
		    	
		    		foreach ($itemTax as $taxKey => $taxValue):

		    			if ($value['COA-PURCHASE'][0]['FK_CAP_ACC_ITE_TAX_ID'] == $taxValue['id']): 
		    			
		    			$taxInfo = $itemTax[$i]; break; 
		    			
		    			endif;
		    		
		    		$i++;
		    		
		    		endforeach;

		    	endif;
		    	
		    	$autoCompleteItem [] = [
		    	
		    	"id"		=> $value['CAP_ACC_ITE_ID'],
		    	"label" 	=> $value['CAP_ACC_ITE_NAME'],
		    	"desc" 		=> $value['CAP_ACC_ITE_DESC'],
		    	"price" 	=> $value['COA-PURCHASE'][0]['CAP_ACC_ITE_COA_RATE'],
		    	"category" 	=> ucwords(strtolower($value['CAP_ACC_ITE_TYP_NAME'])),
		    	"account"	=> ucwords(strtolower($value['COA-PURCHASE'][0]['CAP_ACC_COA_NAME'])),
		    	"accountid"	=> $value['COA-PURCHASE'][0]['FK_CAP_ACC_COA_ID'],
		    	"taxid"		=> $taxInfo['id'],
		    	"taxname"	=> $taxInfo['label'],
		    	"taxrate"	=> $taxInfo['rate']
		    	
		    	];
		    			    	
		    	endforeach;
	    	
	    	endif;
	    		    	
	    	if (!empty($coa)):
	    	
	    		foreach ($coa as $key => $value):
	    		
    	    		if ($value['CAP_ACC_COA_TYP_NAME'] == 'BANK'):
    	    		
    	    		$phpCoa .= "<option value='".$value['CAP_ACC_ITE_ID']."'>".$value['CAP_ACC_ITE_NAME']."</option>";
    	    			
    	    		$autoCompleteCoa [] = [
    		    	
    		    	"id"		=> $value['CAP_ACC_COA_ID'],
    		    	"label" 	=> ucwords(strtolower($value['CAP_ACC_COA_NAME'])),
    		    	"desc" 		=> $value['CAP_ACC_COA_DESC'],
    		    	"category" 	=> ucwords(strtolower($value['CAP_ACC_COA_TYP_NAME']))
    		    	
    		    	];
    		    	
    		    	endif;
		    	
			    	if ($value['CAP_ACC_COA_TYP_NAME'] == 'BANK'):

			    	$accReceivable .= "<option value='".$value['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value['CAP_ACC_COA_NAME']))."</option>";

			    	endif;
	    		
	    		endforeach;
	    	
	    	endif;

	    $view .= "<script type='text/javascript'>";
	    	    	
	    	$view .= "function accountingInvoiceItem() {";
	    	
	    		$view .= "return ".json_encode($autoCompleteItem);
	    	
	    	$view .= "}";
	    		    	
	    	$view .= "function accountingInvoiceCoa() {";
	    	
	    		$view .= "return ".json_encode($autoCompleteCoa);
	    	
	    	$view .= "}";
	    	
	    	$view .= "function accountingInvoiceTax() {";
	    	
	    		$view .= "return ".json_encode($itemTax);
	    	
	    	$view .= "}";
	    	
	    	$view .= "function accountingInvoiceDiscount() {";
	    	
	    		$view .= "return ".json_encode($itemDisc);
	    	
	    	$view .= "}";
	    
	    $view .= "</script>";
	    	    
	    $view .= "<div class='row accounting-".$this->params."-container'>";
	    
	    $view .= "<div class='span12'>";
	    
	    	$view .= "<h2 class=''>New Paybill</h2>";
	    
	    $view .= "</div>";
	    
	    	$view .= "<div class='span12 accounting-".$this->params."-formContainer'>";
	    		
	    	$view .= "<input id='capsuleCSRFToken' type='hidden' value='".$_SESSION['xss']."'>";
	    		
	    		$view .= "<form id='accounting-".$this->params."-form' data-form-type='receipt'>";
	    			
	    			$view .= "<div class='accounting-".$this->params."-form-transaction'>";
	    			
	    			$view .= "<div class='accounting-".$this->params."-form-top'>";
	    			
	    			$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='name'>Vendor</label></span>";
						
						$view .= "<div class='controls'><select id='customer-id' data-customer='customer-choser' class='span3 accounting-chosen-single-deselect'><option value=''></option>$customer</select></div>";
																	
					$view .= "</div>";
	    							
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='account'>From Account</label></span>";
						
						$view .= "<div class='controls'><select id='account' class='span2 accounting-chosen'>".$accReceivable."</select></div>";
																														
					$view .= "</div>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='date'>Date</label></span>";
						
						$view .= "<div class='controls'><input class='accounting-date-".md5(rand(0,100))." input-medium' type='text' id='date' value='".$data['CAP_ACC_ITE_NAME']."'></div>";
						
					$view .= "</div>";
										
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='number'>Reference #</label></span>";
						
						$view .= "<div class='controls'><input class='input-medium' type='text' id='number' value='".$item['CAP_ACC_ITE_NAME']."'></div>";
						
					$view .= "</div>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='currency'>Currency</label></span>";
						
						$view .= "<div class='controls'><select id='currency' class='span2 accounting-chosen'>".$currency."</select></div>";
						
					$view .= "</div>";
																				
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
					
					$view .= "<hr>";
															
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
					
					$view .= "<br>";
					
					$view .= "<div class='span12 accounting-".$this->params."-form-table'>";
					
					$view .= "<div id='accounting-".$this->params."-table'>";
    						
						$view .= "<table class='table accounting-transaction-table-payment table-small-font'>";
						
							$view .= "<thead class='table-header-blue-transaction table-header-bold'>";
							
								$view .= "<tr>";
								
								    $view .= "<td class='table-valign-middle table-align-middle'><input type='checkbox'></td>";
								    
								    $view .= "<td class='table-valign-middle table-align-left'>Date</td>";
								    									
									$view .= "<td class='table-valign-middle table-align-middle'>Number</td>";
									
									$view .= "<td class='table-valign-middle table-align-middle'>Description</td>";
																		
									$view .= "<td class='table-valign-middle table-align-middle'>Orig. Amount</td>";
									
									$view .= "<td class='table-valign-middle table-align-middle'>Due. Amount</td>";
									
									$view .= "<td class='table-valign-middle table-align-middle'>Payment</td>";
																																			
								$view .= "</tr>";
							
							$view .= "</thead>";
							
							$view .= "<tbody>";
							
							$i = 0;
							
							if (!empty($cus)):
														
    							foreach ($cus as $key => $value):

    							     if (!empty($value['TRANSACTION-LIST'])):
    								 
    								 $i++;
    								 																						
            							foreach ($value['TRANSACTION-LIST'] as $key2 => $value2):
            							
            							$date = (!empty($value2['CAP_ACC_TRA_DATE'])) ? date('d-m-Y',strtotime($value2['CAP_ACC_TRA_DATE'])) : null;
            							
            							$dueT = $value2['CAP_ACC_TRA_TOTALLEFT'];
            							
        								$view .= "<tr class='accounting-table-tr-type-one-hidden accounting-payment-item-row' data-customer='".$value['CAP_ACC_CON_ID']."'>";
        									
        									$view .= "<td class='accounting-table-td-type-three table-align-middle'><input id='id' type='checkbox' value='".$value2['CAP_ACC_TRA_ID']."'></td>";
        								    									
        									$view .= "<td class='accounting-table-td-type-one accounting-table-td-align-left accounting-account'>$date</td>";
        								    								    								
        									$view .= "<td class='accounting-table-td-type-one accounting-table-td-align-center accounting-table-td-align-center accounting-price'>".$value2['CAP_ACC_TRA_NUMBER']."</td>";
        								    
        								    $view .= "<td class='accounting-table-td-type-one accounting-description'><input class='accounting-table-input-type-six' type='text' id='description' value=''></td>";
        								    								    																		
        									$view .= "<td class='accounting-table-td-type-one accounting-table-td-align-right accounting-amount'>".number_format($value2['CAP_ACC_TRA_TOTAL'],2)."<input disabled='disabled' class='accounting-table-input-type-four input-align-right' type='hidden' id='amount-integer' value='".$value2['CAP_ACC_TRA_TOTAL']."'></td>";
        									
        									$view .= "<td class='accounting-table-td-type-one accounting-table-td-align-right accounting-price'>".number_format($dueT,2)."<input disabled='disabled' class='accounting-table-input-type-four input-align-right' type='hidden' id='price-integer' value='".$dueT."'></td>";
        									
        									$view .= "<td class='accounting-table-td-type-one accounting-amount'><input class='accounting-qty' type='hidden' id='qty' value='1'><input class='accounting-table-input-type-eight input-align-right accounting-payment-price' type='text' id='price' value='' autocomplete='off'></td>";
        									
        								$view .= "</tr>";
    							
    								    endforeach;
    								 
    							     endif;
    							
    							endforeach;
							
							endif;

							if ($i > 0):
							
							     $view .= "<tr class='accounting-table-tr-type-one accounting-transfer-item-row' data-customer=''>";
    									
    									$view .= "<td colspan='7' class='accounting-table-td-type-three table-align-middle'>- Please select a customer -</td>";
    								    									    									
    				             $view .= "</tr>";
    				             
    				        else:
    				        
    				            $view .= "<tr class='accounting-table-tr-type-one accounting-transfer-item-row' data-customer=''>";
    									
    									$view .= "<td colspan='7' class='accounting-table-td-type-three table-align-middle'>- All invoice are paid -</td>";
    								    									    									
    				             $view .= "</tr>";
							
							endif;
							
							$view .= "</tbody>";
							
							$view .= "<tfoot>";
															
								$view .= "<tr class='accounting-table-tr-type-two'><td colspan='6' class='table-valign-middle table-align-right'>Grand Total</td><td class='table-align-right accounting-foot-total'>0.00</td></tr>";
																					
							$view .= "</tfoot>";
							
						$view .= "</table>";
											
					$view .= "</div>";
										
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
				
				$view .= "<br>";
				
				$view .= "<div class='accounting-action-final'>";
				
				$view .= "<div class='accounting-action-final-container'>";
				
					$view .= "<div class='pull-right default-control-form-final'>";
				
						$view .= "<button type='button' id='accounting-paybill-submit-new' class='btn btn-small btn-success' data-loading-text='Please Wait...'><i class='icon-ok icon-white'></i> Save & Back</button>";
						
					$view .= "</div>";
					
					$view .= "<div class='pull-right default-control-form-final'>";
				
						$view .= "<button class='btn btn-small btn-info'><i class='icon-circle-arrow-right icon-white'></i> Save & Create New</button>";
						
					$view .= "</div>";
					
					$view .= "<div class='pull-right default-control-form-final'>";
	    		
						$view .= "<a href='".$this->url->builder(3561,'transaction')."' class='btn btn-small'><i class='icon-remove'></i> Cancel</a>";
						
					$view .= "</div>";
	    		
	    		$view .= "</div>";
	    		
	    		$view .= "</div>";
					
	    		$view .= "</form>";
	    			    			    			    		
	    	$view .= "</div>";
	    
	    $view .= "</div>";
	   
    echo $view;
        
    }
    
    public function form_viewPaybill() {
        
        $item   = json_decode($this->getItem(), true);
	    
	    $coa    = json_decode($this->getCoa(), true);
	    
	    $acccur = json_decode($this->getCurrencyAccount(),true);
	    
	    $user 	= unserialize($_SESSION['user']);
	    
    	$id		= $user->getID();
        
        $data   = json_decode($this->getPaybillByID(),true);
        
        $crypt  = encryption::urlHashEncodingRinjndael($_SESSION['xss'],$data['CAP_ACC_TRA_ID']);
                	    	    
        $date   = (!empty($data['CAP_ACC_TRA_DATE'])) ? date('d, F Y',strtotime($data['CAP_ACC_TRA_DATE'])) : null;
        
        $number = (!empty($data['CAP_ACC_TRA_NUMBER'])) ? $data['CAP_ACC_TRA_NUMBER'] : null;
        
        $curr   = (!empty($data['FK_CAP_ACC_TRA_CURRENCY'])) ? $data['CAP_ACC_USE_ACC_CUR_NAME']." ".ucwords(strtolower($data['CAP_ACC_CUR_PREFIX'])) : null;
        
        $acc    = (!empty($data['ACCOUNT-TRANSACTION'])) ? ucwords(strtolower($data['ACCOUNT-TRANSACTION'][0]['CAP_ACC_COA_NAME'])) : null;
        
        $cust   = (!empty($data['CAP_ACC_CON_FIRSTNAME'])) ? ucwords(strtolower($data['CAP_ACC_CON_FIRSTNAME'].' '.$data['CAP_ACC_CON_LASTNAME'])) : null;
        
	    $view .= "<div class='row accounting-".$this->params."-container'>";
	    
	    $view .= "<div class='span12'>";
	    
	    	$view .= "<h2 class=''>View Paybill</h2>";
	    
	    $view .= "</div>";
	    
	    	$view .= "<div class='span12 accounting-".$this->params."-formViewContainer'>";
	    		
	    	$view .= "<div class='span1 btn-group pull-left'>";
		   
		   	  	$view .= "<a class='btn btn-info btn-small dropdown-toggle' data-toggle='dropdown' href='#accounting-".$this->params."-coaAdd'><i class='icon-edit icon-white'></i> Options <span class='caret'></span></a>";
		   	  	
		   	  		$view .= "<ul class='dropdown-menu'>";
		   	  			
		   	  			$view .= "<li><a href='#'><i class='icon-ban-circle'></i> Void</a></li>";
		   	  			
		   	  			$view .= "<li><a href='".$this->url->builder(3806,'pay-bill')."?actio=edit|||paybill|||".$crypt."&emblem=".$_SESSION['xss']."'><i class='icon-pencil'></i> Edit</a></li>";
		   	  					   	  					   	  		
		   	  		$view .= "</ul>";
									  					
		   	$view .= "</div>";
		   
		    $view .= "<div class='clearfix'></div>";
	    	
	    	$view .= "<hr>";
	    		
	    	$view .= "<input id='capsuleCSRFToken' type='hidden' value='".$_SESSION['xss']."'>";
	    		
	    		$view .= "<form id='accounting-".$this->params."-form' data-form-type='receipt'>";
	    			
	    			$view .= "<div class='accounting-".$this->params."-form-transaction'>";
	    			
	    			$view .= "<div class='accounting-".$this->params."-form-top'>";
	    			
	    			$view .= "<div class='default-control span3'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='name'>Vendor</label></span>";
						
						$view .= "<div class='controls'>$cust</div>";
																	
					$view .= "</div>";
	    							
					$view .= "<div class='default-control span2'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='account'>From Account</label></span>";
						
						$view .= "<div class='controls'>$acc</div>";
																														
					$view .= "</div>";
					
					$view .= "<div class='default-control span2'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='date'>Date</label></span>";
						
						$view .= "<div class='controls'>$date</div>";
						
					$view .= "</div>";
										
					$view .= "<div class='default-control span2'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='number'>Reference #</label></span>";
						
						$view .= "<div class='controls'>$number</div>";
						
					$view .= "</div>";
					
					$view .= "<div class='default-control span2'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='currency'>Currency</label></span>";
						
						$view .= "<div class='controls'>$curr</div>";
						
					$view .= "</div>";
																				
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
					
					$view .= "<hr>";
					
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
					
					$view .= "<br>";
					
					$view .= "<div class='span12 accounting-".$this->params."-form-table'>";
					
					$view .= "<div id='accounting-".$this->params."-table'>";
    						
						$view .= "<table class='table accounting-transaction-table table-small-font'>";
						
							$view .= "<thead class='table-header-grey-transaction table-header-bold'>";
							
								$view .= "<tr>";
																    
								    $view .= "<td class='table-valign-middle table-align-middle'>Date</td>";
								    									
									$view .= "<td class='table-valign-middle table-align-middle'>Number</td>";
									
									$view .= "<td class='table-valign-middle table-align-middle'>Description</td>";
																		
									$view .= "<td class='table-valign-middle table-align-middle'>Orig. Amount</td>";
									
									//$view .= "<td class='table-valign-middle table-align-middle'>Due. Amount</td>";
									
									$view .= "<td class='table-valign-middle table-align-middle'>Payment</td>";
																																			
								$view .= "</tr>";
							
							$view .= "</thead>";
							
							$view .= "<tbody>";
							
							$i = 0;
							
							if (!empty($data['ITEM-TRANSACTION'])):
							
    							foreach ($data['ITEM-TRANSACTION'] as $key => $value):
    							
    							$date = (!empty($value['CAP_ACC_TRA_DATE'])) ? date('d-m-Y',strtotime($value['CAP_ACC_TRA_DATE'])) : null;
    							
    							$ori  = (!empty($value['CAP_ACC_TRA_TOTAL'])) ? number_format($value['CAP_ACC_TRA_TOTAL'],2) : null;
    							
    							$rate = (!empty($value['CAP_ACC_TRA_ITE_RATE'])) ? number_format($value['CAP_ACC_TRA_ITE_RATE'],2) : null;
    							
    							$amo  = (!empty($value['CAP_ACC_TRA_ITE_AMOUNT'])) ? number_format($value['CAP_ACC_TRA_ITE_AMOUNT'],2) : null;
    							
    							$ttl += $value['CAP_ACC_TRA_ITE_AMOUNT'];
    							
								$view .= "<tr class='accounting-table-tr-type-one accounting-payment-item-row' data-customer='".$value['CAP_ACC_CON_ID']."'>";
								
									$view .= "<td class='accounting-table-td-type-one accounting-table-td-align-center accounting-account'>$date</td>";
									
									$view .= "<td class='accounting-table-td-type-one accounting-table-td-align-center accounting-price'>".$value['CAP_ACC_TRA_NUMBER']."</td>";
				                    
				                    $view .= "<td class='accounting-table-td-type-one accounting-table-td-align-left accounting-price'>".ucwords(strtolower($value['CAP_ACC_TRA_ITE_DESC']))."</td>";
				                    																		    													
									//$view .= "<td class='accounting-table-td-type-one accounting-table-td-align-right accounting-amount'>".$ori."</td>";
									
									$view .= "<td class='accounting-table-td-type-one accounting-table-td-align-right accounting-price'>".$rate."</td>";
									
									$view .= "<td class='accounting-table-td-type-one accounting-table-td-align-right'>".$amo."</td>";
									
								$view .= "</tr>";
    							    							
    							endforeach;
							
							endif;
							
							$view .= "</tbody>";
							
							$view .= "<tfoot>";
															
								$view .= "<tr class='accounting-table-tr-type-two'><td colspan='4' class='table-valign-middle table-align-right'>Grand Total</td><td class='table-align-right accounting-foot-total'>".number_format($ttl,2)."</td></tr>";
																					
							$view .= "</tfoot>";
							
						$view .= "</table>";
											
					$view .= "</div>";
					
					//$view .= "<a class='pull-left btn btn-mini accounting-table-add-newline'><i class='icon-circle-arrow-right'></i> Add a new line</a>";
					
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
				
				$view .= "<br>";
				
	    		
	    		$view .= "</div>";
					
	    		$view .= "</form>";
	    			    			    			    		
	    	$view .= "</div>";
	    
	    $view .= "</div>";
	   
    echo $view;
        
    }
    
    public function form_editPaybill() {
        
        $item   = json_decode($this->getItem(), true);
	    
	    $coa    = json_decode($this->getCoa(), true);
	    
	    $acccur = json_decode($this->getCurrencyAccount(),true);
	    
	    $user 	= unserialize($_SESSION['user']);
	    
    	$id		= $user->getID();
    	
    	$data   = json_decode($this->getPaybillByID(),true);
    	
    	//print_r($data); echo '<br><br>';
        
        $cus = json_decode($this->getContactCustomerWithOpenBillEdited($id,$data['ITEM-TRANSACTION']),true);
        
        //print_r($cus);
                
        if (!empty($cus)):
	    	
	    		foreach ($cus as $key => $value):
	    		
                    if ($data['CAP_ACC_CON_ID'] == $value['CAP_ACC_CON_ID']):
                        
                        $selectedCustomer = $value['CAP_ACC_CON_ID'];
                        
                        $customer .= "<option selected='selected' value='".$value['CAP_ACC_CON_ID']."'>".ucwords(strtolower($value['CAP_ACC_CON_CONTACT']))."</option>";
                    
                    else:
                    
                        $customer .= "<option value='".$value['CAP_ACC_CON_ID']."'>".ucwords(strtolower($value['CAP_ACC_CON_CONTACT']))."</option>";
                    
                    endif;
	    			    		
	    		endforeach;
	    	
	    	endif;
	    
	    	if (!empty($acccur)):
	    	
	    		foreach ($acccur as $key => $value):
	    		
                    if ($data['FK_CAP_ACC_TRA_CURRENCY'] == $value['CAP_ACC_USE_ACC_CUR_ID']):
                    
                        $currency .= "<option selected='selected' value='".$value['CAP_ACC_USE_ACC_CUR_ID']."'>".$value['CAP_ACC_CUR_NAME']." ".$value['CAP_ACC_CUR_PREFIX']."</option>";
                    
                    else:
                    
                        $currency .= "<option value='".$value['CAP_ACC_USE_ACC_CUR_ID']."'>".$value['CAP_ACC_CUR_NAME']." ".$value['CAP_ACC_CUR_PREFIX']."</option>";
                    
                    endif;
	    			    		
	    		endforeach;
	    	
	    	endif;
	    
	    	if (!empty($item)):
	    	
	    		foreach ($item as $key => $value):
	    		
	    			if ($value['CAP_ACC_ITE_TYP_NAME'] == 'TAX'):
	    			
	    			$itemTax [] = [
	    			
	    			"id"    => $value['CAP_ACC_ITE_ID'],
	    			"label" => $value['CAP_ACC_ITE_NAME'],
	    			"rate"  => $value['COA-PURCHASE'][0]['CAP_ACC_ITE_COA_RATE']
	    			
	    			];
	    				    			
	    			endif;
	    			
	    			if ($value['CAP_ACC_ITE_TYP_NAME'] == 'DISCOUNT'):
	    			
	    			$itemDisc [] = [
	    			
	    			"id"    => $value['CAP_ACC_ITE_ID'],
	    			"label" => $value['CAP_ACC_ITE_NAME'],
	    			"rate"  => $value['COA-PURCHASE'][0]['CAP_ACC_ITE_COA_RATE']
	    			
	    			];
	    			
	    			endif;
	    		
	    		endforeach;
	    
		    	foreach ($item as $key => $value):
		    	
		    	unset($taxInfo);
		    	
		    	$phpItem .= "<option value='".$value['CAP_ACC_ITE_ID']."'>".$value['CAP_ACC_ITE_NAME']."</option>";
		    	
		    	if (!empty($value['COA-PURCHASE'][0]['FK_CAP_ACC_ITE_TAX_ID'])):
		    	
		    	$i = 0;
		    	
		    		foreach ($itemTax as $taxKey => $taxValue):

		    			if ($value['COA-PURCHASE'][0]['FK_CAP_ACC_ITE_TAX_ID'] == $taxValue['id']): 
		    			
		    			$taxInfo = $itemTax[$i]; break; 
		    			
		    			endif;
		    		
		    		$i++;
		    		
		    		endforeach;

		    	endif;
		    	
		    	$autoCompleteItem [] = [
		    	
		    	"id"		=> $value['CAP_ACC_ITE_ID'],
		    	"label" 	=> $value['CAP_ACC_ITE_NAME'],
		    	"desc" 		=> $value['CAP_ACC_ITE_DESC'],
		    	"price" 	=> $value['COA-PURCHASE'][0]['CAP_ACC_ITE_COA_RATE'],
		    	"category" 	=> ucwords(strtolower($value['CAP_ACC_ITE_TYP_NAME'])),
		    	"account"	=> ucwords(strtolower($value['COA-PURCHASE'][0]['CAP_ACC_COA_NAME'])),
		    	"accountid"	=> $value['COA-PURCHASE'][0]['FK_CAP_ACC_COA_ID'],
		    	"taxid"		=> $taxInfo['id'],
		    	"taxname"	=> $taxInfo['label'],
		    	"taxrate"	=> $taxInfo['rate']
		    	
		    	];
		    			    	
		    	endforeach;
	    	
	    	endif;
	    		    	
	    	if (!empty($coa)):
	    	
	    		foreach ($coa as $key => $value):
	    		
    	    		if ($value['CAP_ACC_COA_TYP_NAME'] == 'BANK'):
    	    		
    	    		$phpCoa .= "<option value='".$value['CAP_ACC_ITE_ID']."'>".$value['CAP_ACC_ITE_NAME']."</option>";
    	    			
    	    		$autoCompleteCoa [] = [
    		    	
    		    	"id"		=> $value['CAP_ACC_COA_ID'],
    		    	"label" 	=> ucwords(strtolower($value['CAP_ACC_COA_NAME'])),
    		    	"desc" 		=> $value['CAP_ACC_COA_DESC'],
    		    	"category" 	=> ucwords(strtolower($value['CAP_ACC_COA_TYP_NAME']))
    		    	
    		    	];
    		    	
    		    	endif;
		    	
			    	if ($value['CAP_ACC_COA_TYP_NAME'] == 'BANK'):
			    	    
			    	    if ($data['ACCOUNT-TRANSACTION'][0]['FK_CAP_ACC_COA_ID'] == $value['CAP_ACC_COA_ID']):
			    	    
			    	        $accReceivable .= "<option selected='selected' value='".$value['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value['CAP_ACC_COA_NAME']))."</option>";
			    	    
			    	    else:
			    	    
			    	        $accReceivable .= "<option value='".$value['CAP_ACC_COA_ID']."'>".ucwords(strtolower($value['CAP_ACC_COA_NAME']))."</option>";
			    	    
			    	    endif;

			    	endif;
	    		
	    		endforeach;
	    	
	    	endif;

	    $view .= "<script type='text/javascript'>";
	    	    	
	    	$view .= "function accountingInvoiceItem() {";
	    	
	    		$view .= "return ".json_encode($autoCompleteItem);
	    	
	    	$view .= "}";
	    		    	
	    	$view .= "function accountingInvoiceCoa() {";
	    	
	    		$view .= "return ".json_encode($autoCompleteCoa);
	    	
	    	$view .= "}";
	    	
	    	$view .= "function accountingInvoiceTax() {";
	    	
	    		$view .= "return ".json_encode($itemTax);
	    	
	    	$view .= "}";
	    	
	    	$view .= "function accountingInvoiceDiscount() {";
	    	
	    		$view .= "return ".json_encode($itemDisc);
	    	
	    	$view .= "}";
	    
	    $view .= "</script>";
	    	    
	    $view .= "<div class='row accounting-".$this->params."-container'>";
	    
	    $view .= "<div class='span12'>";
	    
	    	$view .= "<h2 class=''>Edit Paybill</h2>";
	    
	    $view .= "</div>";
	    
	    	$view .= "<div class='span12 accounting-".$this->params."-formContainer'>";
	    		
	    	$view .= "<input id='capsuleCSRFToken' type='hidden' value='".$_SESSION['xss']."'>";
	    		
	    		$view .= "<form id='accounting-".$this->params."-form' data-form-type='receipt'>";
	    			
	    			$view .= "<div class='accounting-".$this->params."-form-transaction'>";
	    			
	    			$view .= "<input id='transaction-pid' type='hidden' value='".$data['CAP_ACC_TRA_ID']."'>";
	    			
	    			$view .= "<div class='accounting-".$this->params."-form-top'>";
	    			
	    			$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='name'>Vendor</label></span>";
						
						$view .= "<div class='controls'><select id='customer-id' data-customer='customer-choser' class='span3 accounting-chosen-single-deselect'><option value=''></option>$customer</select></div>";
																	
					$view .= "</div>";
	    							
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='account'>From Account</label></span>";
						
						$view .= "<div class='controls'><select id='account' class='span2 accounting-chosen'>".$accReceivable."</select></div>";
																														
					$view .= "</div>";
					
					$date  = (!empty($data['CAP_ACC_TRA_DATE'])) ? date('d-m-Y',strtotime($data['CAP_ACC_TRA_DATE'])) : null;
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='date'>Date</label></span>";
						
						$view .= "<div class='controls'><input class='accounting-date-".md5(rand(0,100))." input-medium' type='text' id='date' value='".$date."'></div>";
						
					$view .= "</div>";
					
					$num   = (!empty($data['CAP_ACC_TRA_NUMBER'])) ? $data['CAP_ACC_TRA_NUMBER'] : null;
										
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='number'>Reference #</label></span>";
						
						$view .= "<div class='controls'><input class='input-medium' type='text' id='number' value='".$num."'></div>";
						
					$view .= "</div>";
					
					$view .= "<div class='default-control'>";
					
						$view .= "<label class='control-label bold-small control-label-form' for='currency'>Currency</label></span>";
						
						$view .= "<div class='controls'><select id='currency' class='span2 accounting-chosen'>".$currency."</select></div>";
						
					$view .= "</div>";
																				
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
					
					$view .= "<hr>";
															
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
					
					$view .= "<br>";
					
					$view .= "<div class='span12 accounting-".$this->params."-form-table'>";
					
					$view .= "<div id='accounting-".$this->params."-table'>";
    						
						$view .= "<table class='table accounting-transaction-table-payment table-small-font'>";
						
							$view .= "<thead class='table-header-blue-transaction table-header-bold'>";
							
								$view .= "<tr>";
								
								    $view .= "<td class='table-valign-middle table-align-middle'><input type='checkbox'></td>";
								    
								    $view .= "<td class='table-valign-middle table-align-left'>Date</td>";
								    									
									$view .= "<td class='table-valign-middle table-align-middle'>Number</td>";
									
									$view .= "<td class='table-valign-middle table-align-middle'>Description</td>";
																		
									$view .= "<td class='table-valign-middle table-align-middle'>Orig. Amount</td>";
									
									$view .= "<td class='table-valign-middle table-align-middle'>Due. Amount</td>";
									
									$view .= "<td class='table-valign-middle table-align-middle'>Payment</td>";
																																			
								$view .= "</tr>";
							
							$view .= "</thead>";
							
							$view .= "<tbody>";
							
							$i = 0;
							
							if (!empty($cus)):
														
    							foreach ($cus as $key => $value):

    							     if (!empty($value['TRANSACTION-LIST'])):
    								 
    								 $i++;
    								 																						
            							foreach ($value['TRANSACTION-LIST'] as $key2 => $value2):
            							
            							$date = (!empty($value2['CAP_ACC_TRA_DATE'])) ? date('d-m-Y',strtotime($value2['CAP_ACC_TRA_DATE'])) : null;
            							
            							$dueT = $value2['CAP_ACC_TRA_TOTALLEFT'];
            							
                							if ($selectedCustomer == $value['CAP_ACC_CON_ID']):
                							 
                							unset($result);
                							
                								if (!empty($data['ITEM-TRANSACTION'])):

		                                                foreach ($data['ITEM-TRANSACTION'] as $key3 => $value3):
		                                                
		                                                    if ($value3['FK_CAP_ACC_TRA_ID_PAYMENT'] == $value2['CAP_ACC_TRA_ID']):
		                                                    
		                                                        $result = $value3; break;
		                                                    
		                                                    endif;
		                                                
		                                                endforeach;
                                                
                                                endif;
                                                
                                            $chck = (!empty($result)) ? "checked='checked'" : null;
                                            
                                            $total += (!empty($result['CAP_ACC_TRA_ITE_AMOUNT'])) ? $result['CAP_ACC_TRA_ITE_AMOUNT'] : 0;

            								$view .= "<tr class='accounting-table-tr-type-one accounting-payment-item-row' data-customer='".$value['CAP_ACC_CON_ID']."'>";
            									
            									$view .= "<td class='accounting-table-td-type-three table-align-middle'><input id='item-pid' type='hidden' value='".$result['CAP_ACC_TRA_ITE_ID']."'><input id='id' class='accounting-checkbox-checker' $chck type='checkbox' value='".$value2['CAP_ACC_TRA_ID']."'></td>";
            								    									
            									$view .= "<td class='accounting-table-td-type-one accounting-table-td-align-left accounting-account'>$date</td>";
            								    								    								
            									$view .= "<td class='accounting-table-td-type-one accounting-table-td-align-center accounting-table-td-align-center accounting-price'>".$value2['CAP_ACC_TRA_NUMBER']."</td>";
            								    
            								    $view .= "<td class='accounting-table-td-type-one accounting-description'><input class='accounting-table-input-type-six' type='text' id='description' value='".ucwords(strtolower($result['CAP_ACC_TRA_ITE_DESC']))."'></td>";
            								    								    																		
            									$view .= "<td class='accounting-table-td-type-one accounting-table-td-align-right accounting-amount'>".number_format($value2['CAP_ACC_TRA_TOTAL'],2)."<input disabled='disabled' class='accounting-table-input-type-four input-align-right' type='hidden' id='amount-integer' value='".$value2['CAP_ACC_TRA_TOTAL']."'></td>";
            									
            									$view .= "<td class='accounting-table-td-type-one accounting-table-td-align-right accounting-price'>".number_format($dueT,2)."<input disabled='disabled' class='accounting-table-input-type-four input-align-right' type='hidden' id='price-integer' value='".$dueT."'></td>";
            									
            									$view .= "<td class='accounting-table-td-type-one accounting-amount'><input class='accounting-qty' type='hidden' id='qty' value='1'><input class='accounting-table-input-type-eight input-align-right accounting-payment-price' type='text' id='price' value='".$result['CAP_ACC_TRA_ITE_AMOUNT']."' autocomplete='off'></td>";

            								$view .= "</tr>";
            								
            								else:
            								
            								$view .= "<tr class='accounting-table-tr-type-one-hidden accounting-payment-item-row' data-customer='".$value['CAP_ACC_CON_ID']."'>";
            									
            									$view .= "<td class='accounting-table-td-type-three table-align-middle'><input id='item-pid' type='hidden' value=''><input id='id' type='checkbox' value='".$value2['CAP_ACC_TRA_ID']."'></td>";
            								    									
            									$view .= "<td class='accounting-table-td-type-one accounting-table-td-align-left accounting-account'>$date</td>";
            								    								    								
            									$view .= "<td class='accounting-table-td-type-one accounting-table-td-align-center accounting-table-td-align-center accounting-price'>".$value2['CAP_ACC_TRA_NUMBER']."</td>";
            								    
            								    $view .= "<td class='accounting-table-td-type-one accounting-description'><input class='accounting-table-input-type-six' type='text' id='description' value='".$result['CAP_ACC_TRA_ITE_DESC']."'></td>";
            								    								    																		
            									$view .= "<td class='accounting-table-td-type-one accounting-table-td-align-right accounting-amount'>".number_format($value2['CAP_ACC_TRA_TOTAL'],2)."<input disabled='disabled' class='accounting-table-input-type-four input-align-right' type='hidden' id='amount-integer' value='".$value2['CAP_ACC_TRA_TOTAL']."'></td>";
            									
            									$view .= "<td class='accounting-table-td-type-one accounting-table-td-align-right accounting-price'>".number_format($dueT,2)."<input disabled='disabled' class='accounting-table-input-type-four input-align-right' type='hidden' id='price-integer' value='".$dueT."'></td>";
            									
            									$view .= "<td class='accounting-table-td-type-one accounting-amount'><input class='accounting-qty' type='hidden' id='qty' value='1'><input class='accounting-table-input-type-eight input-align-right accounting-payment-price' type='text' id='price' value='' autocomplete='off'></td>";
            									
            								$view .= "</tr>";
            								
            								endif;
    							
    								    endforeach;
    								 
    							     endif;
    							
    							endforeach;
							
							endif;

							if ($i > 0):
							
							     $view .= "<tr class='accounting-table-tr-type-one-hidden accounting-transfer-item-row' data-customer=''>";
    									
    									$view .= "<td colspan='7' class='accounting-table-td-type-three table-align-middle'>- Please select a customer -</td>";
    								    									    									
    				             $view .= "</tr>";
    				             
    				        else:
    				        
    				            $view .= "<tr class='accounting-table-tr-type-one-hidden accounting-transfer-item-row' data-customer=''>";
    									
    									$view .= "<td colspan='7' class='accounting-table-td-type-three table-align-middle'>- All invoice are paid -</td>";
    								    									    									
    				             $view .= "</tr>";
							
							endif;
							
							$view .= "</tbody>";
							
							$view .= "<tfoot>";
															
								$view .= "<tr class='accounting-table-tr-type-two'><td colspan='6' class='table-valign-middle table-align-right'>Grand Total</td><td class='table-align-right accounting-foot-total'>".number_format($total,2)."</td></tr>";
																					
							$view .= "</tfoot>";
							
						$view .= "</table>";
											
					$view .= "</div>";
										
					$view .= "</div>";
					
					$view .= "<div class='clearfix'></div>";
				
				$view .= "<br>";
				
				$view .= "<div class='accounting-action-final'>";
				
				$view .= "<div class='accounting-action-final-container'>";
				
					$view .= "<div class='pull-right default-control-form-final'>";
				
						$view .= "<button type='button' id='accounting-paybill-submit-edit' class='btn btn-small btn-success' data-loading-text='Please Wait...'><i class='icon-ok icon-white'></i> Save & Back</button>";
						
					$view .= "</div>";
					
					$view .= "<div class='pull-right default-control-form-final'>";
				
						$view .= "<button class='btn btn-small btn-info'><i class='icon-circle-arrow-right icon-white'></i> Save & Create New</button>";
						
					$view .= "</div>";
					
					$view .= "<div class='pull-right default-control-form-final'>";
	    		
						$view .= "<a href='".$this->url->builder(3561,'transaction')."' class='btn btn-small'><i class='icon-remove'></i> Cancel</a>";
						
					$view .= "</div>";
	    		
	    		$view .= "</div>";
	    		
	    		$view .= "</div>";
					
	    		$view .= "</form>";
	    			    			    			    		
	    	$view .= "</div>";
	    
	    $view .= "</div>";
	   
    echo $view;
        
    }
    
    public function menu_user() {
	
	$user  = unserialize($_SESSION['user']);
	
	$id    = $user->getID();
	
	$name  = $user->getName();
	
	$hook  = $user->getHook();
	
	$view  = $this->optionGear;
		
		if (empty($hook)):
		
		$hook = $this->attachAccountingUserHook($user);
				
		endif;
		
		if (empty($id) && $name == 'guest'):
			
		$view .= "<div class='pull-right btn-group'>";
		
		$view .= "<a class='btn btn-info btn-small dropdown-toggle' data-toggle='dropdown' href='#'><i class='icon-user icon-white'></i> ".ucwords($user->getName())."  <span class='caret'></span></a>";
		
			$view .= "<ul class='dropdown-menu'>";
			
				$view .= "<li><a href='?id=admin'>Login</a></li>";
				
				$view .= "<li><a href='?id=3761'>Registration</a></li>";
								
			$view .= "</ul>";
			
		$view .= "</div>";
						
		else:
		
		$check = $this->id = $id; $check = $this->checkUser();  $result = $check['CAP_USE_ROL_NAME'];
			
		$view .= "<div class='pull-right btn-group'>";
		
		$view .= "<a class='btn btn-info btn-small dropdown-toggle' data-toggle='dropdown' href='#' SSID='".$user->getID()."'>".ucwords($user->getName())." <span class='caret'></span></a>";
		
			$view .= "<ul class='dropdown-menu'>";
			
				$view .= "<li><a href='#'>Edit Profile</a></li>";
				
				$view .= "<li><a href='#'>Task <span class='badge badge-default'>30</span></a></li>";
				
				$view .= "<li><a href='#'>Messages <span class='badge badge-default'>2</span></a></li>";
								
				$view .= "<li><a href='#'>My Finance</a></li>";
									
					if (!empty($hook)):
										
					$view .= "<li class='divider'></li>";
				
					$view .= "<li><a href='3781-MyAccount.html'>My Account</a></li>";
					
						foreach ($hook as $key => $value):
						
							if ($value['CAP_ACC_USE_ACC_ID'] == $_SESSION['ACCOUNTING-ACCOUNT']):
							
							$view .= "<li><a class='accounting-".$this->params."-userMenuChooser' href='#' data-type='".base64_encode($value['CAP_ACC_USE_ACC_ID'])."'>".$value['CAP_ACC_USE_ACC_NAME']." <i class='icon-ok-sign'></i></a></li>";
							
							else:
							
							$view .= "<li><a class='accounting-".$this->params."-userMenuChooser' href='#' data-type='".base64_encode($value['CAP_ACC_USE_ACC_ID'])."'>".$value['CAP_ACC_USE_ACC_NAME']."</a></li>";
							
							endif;
												
						endforeach;
					
					endif;
				
				$view .= "<li class='divider'></li>";
				
				$view .= "<li><a href='index.php?id=logout'>Sign out</a></li>";
				
			$view .= "</ul>";
			
		$view .= "</div>";
		
		endif;
		
		$view .= "<form id='accounting-".$this->params."-userMenu' action='".$this->site."/library/capsule/accounting/process/process.php' method='post' style='display:none'>";
		
			$view .= "<input type='text' name='accounting-account-menu' value=''>";
		
		$view .= "</form>";

	echo $view;
	    
    }
    
	public function actionbar_contact_accounting(){
    

    	$view  = $this->optionGear;
		
		 $view .= "<div>";
	    
	       $view .= "<input id='capsuleCSRFToken' type='hidden' value='".$_SESSION['xss']."'>";
		
		   $view .= "<div class='btn-group pull-left'>";
		   
		   	  	$view .= "<a class='btn btn-small btn-info' href='#accounting-".$this->params."-coaAdd'><i class='icon-plus icon-white'></i> Create Contact</a>";
					  
		   	  	$view .= "<a class='btn btn-small btn-info' href='#accounting-".$this->params."-coaDelete'><i class='icon-remove icon-white'></i> Delete Contact</a>";
					
		   $view .= "</div>";
							
		   //$view .= "<div class='input-append pull-right'>";
		
			  	//$view .= "<input class='span2' id='appendedInputButton' size='20' type='text'><button class='btn' type='button'>Search</button>";
					
		   //$view .= "</div>";
			    
		$view .= "</div>";    
			    
		$view .= "<div class='clearfix'></div>";
			    
		$view .= "<hr>";
			    
		//Build modal window for data entry
	    $view .= "<div class='modal hide' id='accounting-".$this->params."-coa' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>";

			$view .= "<div class='modal-header'><h5 id='myModalLabel'>Modal header</h5></div>";
			  			  			
			$view .= "<div class='modal-body'></div>";

			$view .= "<div class='modal-footer'>";
			  
			    $view .= "<button class='btn btn-small' data-dismiss='modal' aria-hidden='true'>Close</button>";
			    
			    $view .= "<button class='btn btn-info btn-small'>Save changes</button>";
			  
			$view .= "</div>";
			
		$view .= "</div>";
		
    	$view .= '<div class="content-hanger">';
	    $view .= '<div class="row">';
	   
	    $view .= '    	<div class="span12">';
		$view .= '        	<ul class="nav nav-tabs content-text">';
		$view .= '			  <li class="active"><a href="#all" data-toggle="tab">All</a></li>';
		$view .= '			  <li><a href="#profile" data-toggle="tab">Customers</a></li>';
		$view .= '			  <li><a href="#messages" data-toggle="tab">Vendors</a></li>';
		$view .= '			  <li><a href="#settings" data-toggle="tab">Employee</a></li>';
		$view .= '			</ul>';
	    $view .= '    	</div>';
	    $view .= '    	<div class="span12">';
		$view .= '        	<div class="pagination content-text">';
		$view .= '			  <ul>';
		$view .= '			   	<li class="active"><a href="#">All</a></li>';
		
		$view .= '			    <li><a href="#">A</a></li>';
		$view .= '			    <li><a href="#">B</a></li>';
		$view .= '			    <li><a href="#">C</a></li>';
		$view .= '			    <li><a href="#">D</a></li>';
		$view .= '			    <li><a href="#">E</a></li>';
		$view .= '			    <li><a href="#">F</a></li>';
		$view .= '			    <li><a href="#">G</a></li>';
		$view .= '			    <li><a href="#">H</a></li>';
		$view .= '			    <li><a href="#">I</a></li>';
		$view .= '			    <li><a href="#">J</a></li>';
		$view .= '			    <li><a href="#">K</a></li>';
		$view .= '			    <li><a href="#">L</a></li>';
		$view .= '			    <li><a href="#">M</a></li>';
		$view .= '			    <li><a href="#">N</a></li>';
		$view .= '			    <li><a href="#">O</a></li>';
		$view .= '			    <li><a href="#">P</a></li>';
		$view .= '			    <li><a href="#">Q</a></li>';
		$view .= '			    <li><a href="#">R</a></li>';
		$view .= '			    <li><a href="#">S</a></li>';
		$view .= '			    <li><a href="#">T</a></li>';
		$view .= '			    <li><a href="#">U</a></li>';
		$view .= '			    <li><a href="#">V</a></li>';
		$view .= '			    <li><a href="#">W</a></li>';
		$view .= '			    <li><a href="#">X</a></li>';
		$view .= '			    <li><a href="#">Y</a></li>';
		$view .= '			    <li><a href="#">Z</a></li>';
		$view .= '			  </ul>';
		$view .= '			</div>';
		$view .= '			<div class="span3 offset9">';
		$view .= '			<div class="input-append">';
		$view .= '			  <input class="span2" id="appendedInputButton" size="16" type="text"><button class="btn" type="button">Go!</button>';
		$view .= '			</div>';
		$view .= '			</div>';
	    $view .= '    	</div>';
	    $view .= '    </div>';
	    $view .= '    </div>';
	    echo $view;
    }
	
    public function table_contact_accounting(){
    
    	$user 	= unserialize($_SESSION['user']);
    	$id		= $user->getID();
    	//$data	= json_decode($this->getContact($id)); 
    	$data	= $this->getContact($id);
    	//print_r($data);
    	$view  = $this->optionGear;
    	$view .= '<div class="content-hanger">';
	    $view .= '<div class="row">';
	   
	    
	    $view .= '    	<div class="span12">';
	        	   
	        	   
	    $view .= '    	   <table id="accounting-table_contact_acounting-tablecontact" class="table table-hover table-striped table-small-font">';
	        	   		
	    $view .= '    	   		<thead class="header-text table-header-blue table-header-bold">';
	    $view .= '    	   			<tr>';
		$view .= '        	   			<th class="table-valign-middle"><input type="checkbox" /></th>';
		$view .= '        	   			<th class="table-valign-middle">Name</th>';
		$view .= '        	   			<th class="table-valign-middle">Email Address</th>';
		$view .= '        	   			<th class="table-valign-middle">Phone Number</th>';
		$view .= '        	   			<th class="table-valign-middle">Payables Due</th>';
		$view .= '        	   			<th class="table-valign-middle">Overdue Payables</th>';
		$view .= '        	   			<th class="table-valign-middle">Receiveables Due</th>';
		$view .= '        	   			<th class="table-valign-middle">Overdue Receivables</th>';
	    $view .= '    	   			</tr>';
	        	   			
	    $view .= '   	   		</thead>';
	    $view .= '    	   		<tbody class="content-text">';
	    foreach($data['contact'] as $key => $value){
		    
	    
	    
	    $view .= '    	   			<tr>';
		$view .= '        	   			<td class="table-valign-middle"><input type="checkbox" /></td>';
	    $view .= '    	   				<td>'.ucwords($value[name]).'</td>';
	    $view .= '    	   				<td>'.ucwords($value[email]).'</td>';
	    $view .= '    	   				<td>'.ucwords($value[phone]).'</td>';
	    $view .= '   	   				<td></td>';
	    $view .= '    	   				<td></td>';
	    $view .= '    	   				<td></td>';
	    $view .= '    	   				<td></td>';
	    $view .= '    	   			</tr>';
	    
	    }
	    $view .= '    	   		</tbody>';
	    $view .= '    	   		<tfoot>';
		$view .= '        	   		<tr>';
		$view .= '	        	   		<td colspan="7">';
		$view .= '		        	   		<div class="pagination content-text">
									  <ul>
									    <li><a href="#">Prev</a></li>
									    <li><a href="#">1</a></li>
									    <li><a href="#">2</a></li>
									    <li><a href="#">3</a></li>
									    <li><a href="#">4</a></li>
									    <li><a href="#">Next</a></li>
									  </ul>
									</div>';
				        	   		
		$view .= '	        	   		</td>';
		$view .= '        	   		</tr>';
	    $view .= '    	   		</tfoot>';
	    $view .= '    	   </table>';
	        	   
	    $view .= '    	</div>';
	    $view .= '    </div>';
	    $view .= '    </div>';
	    echo $view;
    }
    
    
    public function subject_account(){
    	
    	$user = unserialize($_SESSION['user']);
    	
    	$id = $user->getID();
    	
    	$data = $this->getSubjectAccount($id);
    	
    	$data = $data;
    	//print_r($data);
	    $view .= '	    <div class="row-fluid '.$this->params.'-container">';
	    $view .= '    	<div class="span6 offset3" style="border:1px solid #000">';
	    $view .= '    		<div class="row-fluid">';
	    $view .= '        		<div class="span10 offset1 border-bottom"><h3>Change Account</h3></div>';
	    $view .= '    		</div>	     ';
	   
	    if(!empty($data)):
		    foreach($data as $key=>$values):
		     	$view .= '    		<div class="row-fluid">';
			    $view .= "        		<div class=\"span6 offset1 div-link\"><h5><span>$values[CAP_ACC_SUB_ACC_NAME]</span></h5></div>";
			    $view .= '   		</div>	   	';	
		    endforeach;
	    endif;
		
	    
	    $view .= '   	</div>';
	    $view .= '  </div>';
	   
	    
	    echo $view;
    }
    
    
    
    
    
    
    
    /*>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>*/
    /*>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>*/
    /*>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>*/
    /*>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 			      Kode Tambahan 			   >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>*/
    /*>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>*/
    /*>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>*/
    /*>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>*/
    
    
    public function form_user_account(){
		  
		  $token = $_SESSION['xss'];
		  
		  $view .= '<div>';
	      $view .= '        <form class="form-horizontal '.$this->params.'Add">';
	      $view .= '			<input id="capsuleCSRFToken" type="hidden" value="'.$token.'">';
	      $view .= '			<input id="capsuleCSRFToken" type="hidden" value="'.$token.'">';
	      $view .= '       		<legend>Create Company</legend>';
	      $view .= '			<div class="control-group">';
		  $view .= '				<label class="control-label" for="inputEmail">Company Name</label>';
		  $view .= '				<div class="controls">';
		  $view .= '  					<input type="text" id="inputEmail" placeholder="company name">';
		  $view .= '				</div>';
		  $view .= '			</div>';
		  $view .= '			<div class="control-group">';
		  $view .= '  				<label class="control-label" for="inputAuthor">Author</label>';
		  $view .= '  				<div class="controls">';
		  $view .= '    				<input type="text" id="inputAuthor" placeholder="author">';
		  $view .= '  				</div>';
		  $view .= '			</div>';
  
		  $view .= ' 			<div class="control-group">';
		  $view .= '   			<label class="control-label" for="inputTelphone">Telphone</label>';
		  $view .= '   				<div class="controls">';
		  $view .= '     				<input type="text" id="inputTelphone" placeholder="telphone">';
		  $view .= '   				</div>';
		  $view .= ' 			</div>';
		  $view .= ' 			<div class="control-group">';
		  $view .= '   				<div class="controls">';
		     
		  $view .= '     			<button type="button" class="btn btn-info" data-loading-text="Loading...">Create</button>';
		  $view .= '   				</div>';
		  $view .= ' 			</div>';
		  $view .= '		</form>';
		  $view .= '</div>';
		  
		  echo $view;
    }
    
    
    	
}

?>