<?php

namespace library\capsule\menu\mvc;

use \framework\simple_html_dom;


class view extends model {

protected $menu;
protected $params,$site,$role;
protected $optionGear;
	
	
	public function __construct($set,$params) {

		$this->site = substr(APP, 0, -1);
		
		$this->role = $this->getRole();

		$this->data = ($set != '{set}') ? $set : null;

		$this->menu = $this->getMenuSet();

		if (isset($_SESSION['admin']) || !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		$this -> optionGear = "<span class='forex-optionGear'><img class='optionGear' src='".$this->site."/library/capsule/admin/image/settingCap.png'></span>";
		}
		
		if ($params == "{view}" || empty($params)) {$this->params = 'normal';} else {$this->params = $params;} $params = $this->params; $this->$params();
		
	}	
	
	
	public function normal(){
						
	$view .= $this->optionGear;

		if (!empty($this->menu)) {

			$view .= $this->menuBuilder($this->menu,$this->role);

		}

	echo $view;
	
	}
	
	public function bootstrap(){
						
	$view .= $this->optionGear;
	
	$menu  = $this->menu;

		if (!empty($menu)):
						
			for ($i = 0, $c = count($this->menu); $i < $c; $i++):
			
				foreach ($this->menu as $key => $value):
			
					if ($menu[$i]['CAP_MEN_ID'] == $value['CAP_MEN_PARENT']): 
						
						$menu[$i]["HAS_CHILD"] = true;
											
					endif;
			
				endforeach;
			
			endfor;

			$view .= $this->menuBuilderBootstrap($menu,$this->role);
			
		endif;
		
	echo $view;
	
	}
	
		public function staff(){
						
	$view .= $this->optionGear;
	
	$menu  = $this->menu;

		if (!empty($menu)):
						
			for ($i = 0, $c = count($this->menu); $i < $c; $i++):
			
				foreach ($this->menu as $key => $value):
			
					if ($menu[$i]['CAP_MEN_ID'] == $value['CAP_MEN_PARENT']): 
						
						$menu[$i]["HAS_CHILD"] = true;
											
					endif;
			
				endforeach;
			
			endfor;

			$view .= $this->menuBuilderBootstrap($menu,$this->role);
			
		endif;
		
	echo $view;
	
	}
	
	
	public function centum(){
						
	$view .= $this->optionGear;

		if (!empty($this->menu)) {

			$view .= $this->menuBuilder($this->menu);

		}

	echo $view;
	
	}
	
	public function campaign(){
						
	$view .= $this->optionGear;

		if (!empty($this->menu)) {

			$view .= $this->menuBuilder($this->menu);

		}

	echo $view;
	
	}
	
	public function menuBuilderBootstrap($results, $role = null, $master = 0, $cond = false, $child = null) {
		
    $open = array();
    
    $menu = NULL;
    
    $i    = 0;
    
    $c 	  = count($results);
        
    foreach($results as $result):

    $i++;

    	$id = strtolower($result["CAP_MEN_ID"]);
    	    	
    	$rol= $role[$result['CAP_MEN_ACCESS']];
    	
    	$rol= ($rol == 'guest') ? 'public' : $rol;

		$caption= strtolower(str_replace(array('-',' '), '-', $result["CAP_MEN_NAME"]));

        if ($result['CAP_MEN_PARENT'] == $master):

            if (!$open):

            	if (empty($result['CAP_MEN_PARENT'])):

            	$menu .= '<ul class="nav">';
            	
            	else:
            	
            	$child = $id;

                $menu .= '<ul class="dropdown-menu">';
                                                
            	endif;

                $open = true;

            endif;
            
            $active = (!empty($child) && $_SESSION['_Neyka_Menu'] == $child) ? ' active' : null;	    

        		if (!empty($results[$l+1]['CAP_MEN_PARENT'])) {

        			if (empty($result['CAP_MEN_PARENT'])) {
        			        			
			        	if (empty($results[$l+1]['CAP_MEN_PARENT'])) {
				            
				            $menu .= '<li class="dropdown'. $active .'"><a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$result['CAP_LAN_COM_VALUE']." <b class='caret'></b></a>";
				            
			            }
			            else {
			            
			            	if (!empty($result['CAP_MEN_OTHERURL'])) {

				            	$menu .= '<li class="dropdown'. $active .'"><a href="'.$result['CAP_MEN_OTHERURL'].'" class="dropdown-toggle" data-toggle="dropdown">'.$result['CAP_LAN_COM_VALUE']." <b class='caret'></b></a>";
				            
				            }
				            else {
					            echo $child;
					            $menu .= '<li class="dropdown'. $active .'"><a href="'.APP.$rol.'/'.$id.'/'.$caption.'/" class="dropdown-toggle" data-toggle="dropdown">'.$result['CAP_LAN_COM_VALUE']." <b class='caret'></b></a>";
					            
				            }
				            
			            }
			            
			        }
   			        else if (!empty($result['CAP_MEN_PARENT'])) {
				        
				        if (!empty($result['HAS_CHILD'])) {
				        
				        	if (empty($result['CAP_PAGES_CAP_PAG_ID'])) {
					            
					            if (!empty($result['CAP_MEN_OTHERURL'])) {
				            
				            		$menu .= '<li class="dropdown-submenu"><a href="'.$result['CAP_MEN_OTHERURL'].'">'.$result['CAP_LAN_COM_VALUE']."</a>";
				            
					            }
					            else {
						            
						           	$menu .= '<li class="dropdown-submenu"><a href="#">'.$result['CAP_LAN_COM_VALUE']."</a>";
						            
					            }
					            					            
				            }
				            else {
					            
					            if (!empty($result['CAP_MEN_OTHERURL'])) {
				            
				            		$menu .= '<li class="dropdown-submenu"><a href="'.$result['CAP_MEN_OTHERURL'].'">'.$result['CAP_LAN_COM_VALUE']."</a>";
				            
					            }
					            else {
						            
						            $menu .= '<li class="dropdown-submenu"><a href="'.APP.$rol.'/'.$id.'/'.$caption.'/">'.$result['CAP_LAN_COM_VALUE']."</a>";
						            
					            }
					            					            
				            }
			            
			            }
			            else {
				            
				            if (empty($result['CAP_PAGES_CAP_PAG_ID'])) {
				            	
				            	if (!empty($result['CAP_MEN_OTHERURL'])) {
				            
				            		$menu .= '<li><a href="'.$result['CAP_MEN_OTHERURL'].'">'.$result['CAP_LAN_COM_VALUE']."</a>";
				            
					            }
					            else {
						            
						           $menu .= '<li><a href="#">'.$result['CAP_LAN_COM_VALUE']."</a>";
						            
					            }
				            					            
				            }
				            else {
					            
					            if (!empty($result['CAP_MEN_OTHERURL'])) {
				            
				            		$menu .= '<li><a href="'.$result['CAP_MEN_OTHERURL'].'">'.$result['CAP_LAN_COM_VALUE']."</a>";
				            
					            }
					            else {
						            
						            $menu .= '<li><a href="'.APP.$rol.'/'.$id.'/'.$caption.'/">'.$result['CAP_LAN_COM_VALUE']."</a>";
						            
					            }
					            					            
				            }
				            
			            }
			            
			        }
			        else {
		        	
			        	if (empty($result['CAP_PAGES_CAP_PAG_ID'])) {
				            
				            if (!empty($result['CAP_MEN_OTHERURL'])) {
				            
				            	$menu .= '<li><a href="'.$result['CAP_MEN_OTHERURL'].'">'.$result['CAP_LAN_COM_VALUE']."</a>";
				            
				            }
				            else {
					           
					           $menu .= '<li><a href="#">'.$result['CAP_LAN_COM_VALUE']."</a>";
					           
				            }
				            				            
			            }
			            else {
				            
				            if (!empty($result['CAP_MEN_OTHERURL'])) {

				            	$menu .= '<li><a href="'.$result['CAP_MEN_OTHERURL'].'">'.$result['CAP_LAN_COM_VALUE']."</a>";
				            
				            }
				            else {
					            
					            $menu .= '<li><a href="'.APP.$rol.'/'.$id.'/'.$caption.'/">'.$result['CAP_LAN_COM_VALUE']."</a>";
					            
				            }
				            				            
			            }
		            
		            }
		            
		        }
		        else {
			    
			    $active = ($_SESSION['_Neyka_Menu'] == $id) ? ' class="active"' : null;	
			    
		        	if (empty($result['CAP_PAGES_CAP_PAG_ID'])) {
			            
			            if (!empty($result['CAP_MEN_OTHERURL'])) {
			            
			            $menu .= '<li'. $active .'><a href="'.$result['CAP_MEN_OTHERURL'].'">'.$result['CAP_LAN_COM_VALUE']."</a>";
			            
			            }
			            else {
				            
				           $menu .= '<li'. $active .'><a href="#">'.$result['CAP_LAN_COM_VALUE']."</a>";
				            
			            }
			            				            
		            }
		            else {

			            if (!empty($result['CAP_MEN_OTHERURL'])) {
			            
			            	$menu .= '<li'. $active .'><a href="'.$result['CAP_MEN_OTHERURL'].'">'.$result['CAP_LAN_COM_VALUE']."</a>";
			            
			            }
			            else {
				            
				            $menu .= '<li'. $active .'><a href="'.APP.$rol.'/'.$id.'/'.$caption.'/">'.$result['CAP_LAN_COM_VALUE']."</a>";
				            
			            }
			            				            
		            }
	        	
			     }
        	        	
            $menu .= self::menuBuilderBootstrap($results, $role, $result['CAP_MEN_ID'],$cond,$child);
            
            if ($result['CAP_MEN_IMG'] == 'divider'):
	            	
	            $menu .= '<li class="divider"></li>';
	            	
            endif;
            
            $menu .= '</li>';

        endif;
        
    $l++;

    endforeach;

    if ($open) { $menu .= '</ul>'; }

    return $menu;

	}	
	
	public function menuBuilder($results, $role = null, $master = 0, $cond = false) {

    $open = array();

    $menu = NULL;

    $i    = 0;

    $c 	  = count($results);

    foreach($results as $result) {

    $i++;

    	$id = strtolower($result["CAP_MEN_ID"]);
    	
    	$rol= $role[$result['CAP_MEN_ACCESS']];
    	
    	$rol= ($rol == 'guest') ? 'public' : $rol;

		$caption= strtolower(str_replace(array('-',' '), '-', $result["CAP_MEN_NAME"]));

        if ($result['CAP_MEN_PARENT'] == $master) {

            if (!$open) {

            	if (empty($result['CAP_MEN_PARENT'])) {

            	$menu .= '<ul class="nav nav-tabs nav-stacked">';

            	}
            	else {

                $menu .= '<ul class="dropdown">';

            	}

                $open    = true;

            }
            
            if (!empty($results[$l+1]['CAP_MEN_PARENT'])) {
        			
        			if (empty($result['CAP_MEN_PARENT'])) {
        			
			        	if (empty($results[$l+1]['CAP_MEN_PARENT'])) {
				            
				            $menu .= '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$result['CAP_LAN_COM_VALUE']." <b class='caret'></b></a>";
				            
			            }
			            else {
				            
				            $menu .= '<li class="dropdown"><a href="'.APP.$rol.'/'.$id.'/'.$caption.'/" class="dropdown-toggle" data-toggle="dropdown">'.$result['CAP_LAN_COM_VALUE']." <b class='caret'></b></a>";
				            
			            }
			            
			        }
			        
			        }

            if ($i == 1) {
	            
	            if (empty($result['CAP_PAGES_CAP_PAG_ID'])) {
		            
		            $menu .= '<li><a href="#">'.$result['CAP_LAN_COM_VALUE']."</a>";
		            
	            }
	            else {
		            
		            $menu .= '<li ><a href="'.APP.$rol.'/'.$id.'/'.$caption.'/"><i class="icon icon-caret-right"></i>'.$result['CAP_LAN_COM_VALUE']."</a>";
		            
	            }
	            
        	}          else if ($i == $c) {
            
            	if (empty($result['CAP_PAGES_CAP_PAG_ID'])) {
            	
            	if (!empty($result['CAP_MEN_OTHERURL'])) {
				            
				            	$menu .= '<li><a href="'.$result['CAP_MEN_OTHERURL'].'"><i class="icon icon-caret-right"></i>'.$result['CAP_LAN_COM_VALUE']."</a>";
				            
				            }
				            else {
					            
					            $menu .= '<li><a href="#"><i class="icon icon-caret-right"></i>'.$result['CAP_LAN_COM_VALUE']."</a>";
					            
				            }
		            
	            }
	            else {
		            
		            $menu .= '<li><a href="'.APP.$rol.'/'.$id.'/'.$caption.'/"><i class="icon icon-caret-right"></i>'.$result['CAP_LAN_COM_VALUE']."</a>";
		            
	            }

        	}
        	else {
	        	
	        	if (empty($result['CAP_PAGES_CAP_PAG_ID'])) {
		            
		            $menu .= '<li><a href="#"><i class="icon icon-caret-right"></i>'.$result['CAP_LAN_COM_VALUE']."</a>";
		            
	            }
	            else {
		            
		            $menu .= '<li><a href="'.APP.$rol.'/'.$id.'/'.$caption.'/"><i class="icon icon-caret-right"></i>'.$result['CAP_LAN_COM_VALUE']."</a>";
		            
	            }
	        	

        	}

            $menu .= self::menuBuilder($results,$role, $result['CAP_MEN_ID']);

            $menu .= '</li>';

        }

    }

    if ($open) {

    $menu .= '</ul>';

	}

    return $menu;

	}
				
}

?>