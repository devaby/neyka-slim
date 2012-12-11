<?php

namespace library\capsule\minicon\mvc;

/**
 * Minicon Capsule
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@asacreative.com so we can send you a copy immediately.
 *
 * @category   Capsule View
 * @package    Minicon
 * @copyright  Copyright (c) 09-12-2012 Asacreative Technology Indonesia (http://www.asacreative.com)
 * @license    New BSD License
 * @version    Id: view.php 100 Ridwan Abadi $
 * @since      Minicon 0.1
 */
 
class view extends model {

/**
* 
* @var null
* 
*/
protected $params = null;

/**
* 
* @var null
* 
*/
protected $site = null;

	/**
    * Object Constructor
    *
    * @return void
    */
	public function __construct($params = null) {
	
		parent::__construct();
		
		$this->site = substr(APP, 0, -1);
		
		if (isset($_SESSION['admin']) || isset($_SESSION['admin']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'):
		
		$this->optionGear = '<span class=forex-optionGear><img class=optionGear src="' . $this->site . '/library/capsule/admin/image/settingCap.png"></span>';
		
		$this->ajax = true;
		
		endif;

		$params = ($params == '{view}' || empty($params))  ? 'normal' : $params; 
		
		$this->$params();
			
	}
	
	/**
    * Object normal view
    *
    * @echo view
    */
	public function normal() {
	
		$view .= $this->optionGear;
	
		echo 'Select a Minicon view ' . $view;
                
    }
    
    public function content() {

	    if (isset($_SESSION['admin'])):
	    
	    $tagonomy = $this->getTagonomy();
	    
	    //print_r($tagonomy);
	    
	    	$view .= '<div class="minicon-content-main">';
	    	
	    		$view .= '<div class="minicon-content-action tabbable">';
	    		
	    			$view .= '<ul class="nav nav-tabs">';
	    				
	    				$view .= '<li class="active minicon-content-action-li"><a href="#minicon-content-status" data-toggle="tab">Status Updates</a></li>';
	    				
		    			$view .= '<li class="minicon-content-action-li"><a href="#minicon-content-article" data-toggle="tab">Article</a></li>';
		    			
		    			$view .= '<li class="minicon-content-action-li"><a href="#minicon-content-photo" data-toggle="tab">Photo</a></li>';
		    			
		    			$view .= '<li class="minicon-content-action-li"><a href="#minicon-content-document" data-toggle="tab">Document</a></li>';
	    			
	    			$view .= '</ul>';
	    				    		
	    		$view .= '</div>';
	    		
	    		$view .= '<div class="minicon-tab-content tab-content">';
	    		
	    			$view .= '<div class="tab-pane active" id="minicon-content-status">';
	    			
	    				$view .= '<div>';

	    					$view .= '<form id="minicon-content-form">';
	    					
	    						$view .= "<input id='capsuleCSRFToken' type='hidden' value='".$_SESSION['xss']."'>";
	    					
	    						$view .= '<div class="control-group">';
	    						
	    							$view .= '<div class="controls">';
	    					
			    						$view .= '<input type="text" name="header" id="minicon-content-input" class="minicon-post minicon-content-input" placeholder="Insert header..." data-post="header">';
			    								    						
		    						$view .= '</div>';
		    						
		    						$view .= '<div class="controls">';
		    							    								
			    						$view .= '<textarea name="content2" id="minicon-content-textarea-nonic" class="minicon-post minicon-content-textarea" placeholder="Insert content..." data-post="content"></textarea>';
		    						
		    						$view .= '</div>';
	    						
	    						$view .= '</div>';
	    						
	    						$view .= '<button id="minicon-content-status-submit" class="pull-right btn btn-info btn-small">Post</button>';
	    					
	    					$view .= '</form>';
	    				
	    				$view .= '</div>';
	    			
	    			$view .= '</div>';
	    			
	    			$view .= '<div class="tab-pane" id="minicon-content-article">';
	    			
	    				$view .= '<div>';

	    					$view .= '<form>';
	    					
	    						$view .= '<div class="control-group">';
	    							
	    							$view .= '<div class="controls">';
	    								
	    								$view .= '<input type="text" name="header" id="minicon-content-date" class="minicon-content-input-small" placeholder="Insert publish date...">';
	    								
	    								if (!empty($tagonomy)):
	    									
	    									$view .= '<select class="minicon-content-select">';
	    									
	    									foreach ($tagonomy as $key => $value):
	    									
	    										$view .= '<option value='. $value['CAP_CON_CAT_ID'] .'>'. $value['CAP_CON_CAT_NAME'] .'</option>';
	    									
	    									endforeach;
	    									
	    									$view .= '</select>';
	    								
	    								endif;
	    							
		    						$view .= '</div>';
	    							
	    							$view .= '<div class="controls">';
	    					
			    						$view .= '<input type="text" name="header" id="minicon-content-input" class="minicon-content-input" placeholder="Insert header...">';
			    								    						
		    						$view .= '</div>';
		    						
		    						$view .= '<div class="controls">';
		    						
		    							$view .= '<div id="minicon-content-textarea-panel" style="width:99.7%;"></div>';
	    								
			    						$view .= '<textarea name="content" id="minicon-content-textarea" style="width:99.7%; background-color:white;"></textarea>';
		    						
		    						$view .= '</div>';
	    						
	    						$view .= '</div>';
	    						
	    						$view .= '<button id="minicon-content-article-submit" class="pull-right btn btn-info btn-small">Post</button>';
	    					
	    					$view .= '</form>';
	    				
	    				$view .= '</div>';
	    			
	    			$view .= '</div>';
	    			
	    			$view .= '<div class="tab-pane" id="minicon-content-photo">';
	    			
	    				$view .= '<p>tab photo</p>';
	    			
	    			$view .= '</div>';
	    			
	    			$view .= '<div class="tab-pane" id="minicon-content-document">';
	    			
	    				$view .= '<p>tab document</p>';
	    			
	    			$view .= '</div>';
	    		
	    		$view .= '</div>';
	    	
	    	$view .= '<div class="clearfix"></div>';
	    			    		    	
	    	$view .= '</div>';
	    
	    endif;
	    
	echo $view;
	    
    }

}

?>

