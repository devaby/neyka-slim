<?php

namespace library\capsule\staff\mvc;

/**
 * Staff Capsule
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
 * @package    Staff
 * @copyright  Copyright (c) 06-12-2012 Asacreative Technology Indonesia (http://www.asacreative.com)
 * @license    New BSD License
 * @version    Id: view.php 100 Ridwan Abadi $
 * @since      Staff 0.1
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
protected $domain = null;

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
	public function __construct($params,$domain = null) {
	
		parent::__construct();
		
		$mainID = $GLOBALS['_neyClass']['sites']->domain();
						
		$this->site = substr(APP, 0, -1);
		
		if (isset($_SESSION['admin']) || isset($_SESSION['admin']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'):
		
		$this->optionGear = '<span class=forex-optionGear><img class=optionGear src="' . $this->site . '/library/capsule/admin/image/settingCap.png"></span>';
		
		$this->ajax = true;
		
		endif;
	
		$this->params = ($params == '{view}' || empty($params))  ? 'normal' : $this->params = $params; 
		
		$this->domain = ($domain == '{domain}' || empty($domain))  ? $mainID : $this->domain = $domain;
		
		$this->$params();
			
	}
	
	/**
    * Object normal view
    *
    * @echo view
    */
	public function normal() {
	
		$view .= $this->optionGear;
	
		echo 'Select a Staff view ' . $view;
                
    }
    
    /**
    * Object normal view
    *
    * @echo view
    */
	public function profile() {
	
		$view .= $this->optionGear;
		
		$data  = $this->getStaffProfile($this->domain);
			
			if (!empty($data)):
			
			$view .= '<div class="row">';
								
					if (file_exists(ROOT_PATH . '/library/capsule/core/images/profile/'. $data[0]['CAP_USE_ID'] .'.png')):
					
						$view .= '<div class="span2">';
				
							$view .= '<img src="'. substr(APP,0, -1) .'/framework/resize.class.php?src=/library/capsule/core/images/profile/'. $data[0]['CAP_USE_ID'] .'.png&h=120&w=120&zc=1">';
						
						$view .= '</div>';
											
					endif;
													
				$view .= '<div class="span8">';
				
					$view .= '<h2>' . $data[0]['FULLNAME'] . '</h2>';
				
					$view .= '<p>' . $data[0]['CAP_USE_EMAIL'] . '</p>';
				
				$view .= '</div>';
			
			$view .= '</div>';
			
			endif;
					
		echo $view;
                
    }
    
    /**
    * Object normal view
    *
    * @echo view
    */
	public function table() {
			
		$char  = (empty($_GET['staff'])) ? 'a' : strtolower($_GET['staff']);
		
		$data  = $this->getAllStaffDomainBased($this->domain,$char);
			
		$view .= $this->optionGear;
		
		$view .= '<div><br></div>';
		
		$view .= '<div class="row">';
					
			$view .= '<div class="span3">';
			
			$view .= '<form name="staff_search" action="' . $_SERVER['REQUEST_URI'] . '" method="get">';
								
				$view .= '<div class="input-append">';
					
					if (strlen($char) > 1):
					
						$view .= '<input class="span2" id="appendedInputButton" name="staff" type="text" value="'. $char .'" autocomplete="off">';
					
					else:
					
						$view .= '<input class="span2" id="appendedInputButton" name="staff" type="text" value="" autocomplete="off">';
					
					endif;
					
					$view .= '<button type="submit" class="btn btn-info" type="button">Search</button>';
					
				$view .= '</div>';
										
			$view .= '</form>';
			
			$view .= '</div>';
					
		$view .= '</div>';
		
		$paging .= '<div class="paginations">';
		
		$az    = 'a';
		
		$char  = (strlen($char) > 1) ? substr($char, 0,1) : $char;
		
			$paging .= '<ul class="pagination">';
		
				for($i = 1; $i <= 26; $i++):
					
					if ($char == $az):
									
						$paging .= '<a href="?staff=' . $az . '"><li class="current">' . $az . '</li></a>';
					
					else:
					
						$paging .= '<a href="?staff=' . $az . '"><li>' . $az . '</li></a>';
					
					endif;
					
					$az++;
		
				endfor;
				
			$paging .= '</ul>';
			
		$paging .= '</div>';
		
		$view .= $paging;
		
			if (!empty($data)):
			
			$view .= '<table class="staff-table-all-staff">';
			
				foreach ($data as $key => $value):
					
					if (!is_numeric($key)): continue; endif;
					
					$view .= '<tr class="staff-table-tr">';

						if (file_exists(ROOT_PATH . '/library/capsule/core/images/profile/'. $value['CAP_USE_ID'] .'.png')):
				
							$view .= '<td class="staff-table-td-pic"><div class="staff-table-image"><img src="'. substr(APP,0, -1) .'/framework/resize.class.php?src=library/capsule/core/images/profile/'. $value['CAP_USE_ID'] .'.png&h=80&w=80&zc=1"></div></td>';
						
						else:
						
							$view .= '<td class="staff-table-td-pic"><div class="staff-table-image"><img src=""></div></td>';
						
						endif;
						
						$view .= '<td>';
						
							$view .= '<dd><b>' . $value['FULLNAME'] . '</b></dd>';
							
							$view .= '<dd><a target="_blank" href="http://' . $value['CAP_MAI_DOMAIN'] . '.' . $data['DOMAIN_NAME'] . APP . '">http://' . $value['CAP_MAI_DOMAIN'] . '.' . $data['DOMAIN_NAME'] . APP . '</a></dd>';
							
						$view .= '</td>';
					
					$view .= '</tr>';
					
				endforeach;
				
			$view .= '</table>';
			
			endif;
			
			if (count($data) > 20 ):
			
			$view .= $paging;
			
			endif;
	
		echo $view;
                
    }

}

?>

