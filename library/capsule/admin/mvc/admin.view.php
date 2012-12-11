<?php

namespace library\capsule\admin;

use \framework\misc;

class view {

public $data,$site;
	
	public function __construct($data) {
	$this->data = $data;
	$this->site = substr(APP, 0, -1);
	}
	
	public function showMenu($pageID,$page) {
		
	   if ($_SESSION['admin'] == 1):
	
	   		return "<div id='adminContainer' data-folder='".str_replace('/','',APP)."'><div class='adminTop'>" . self::menuSetGlobal($pageID,$page) . "</div></div><div id='admin-topHeader'></div>";
	   
	   elseif ($_SESSION['admin'] == 2):
	   
	   		return "<div id='adminContainer' data-folder='".str_replace('/','',APP)."'><div class='adminTop'>" . self::menuSetSites($pageID,$page) . "</div></div><div id='admin-topHeader'></div>";
	   
	   elseif ($_SESSION['admin'] == 3):
	   
	   		return "<div id='adminContainer' data-folder='".str_replace('/','',APP)."'><div class='adminTop'>" . self::menuSetPersonal($pageID,$page) . "</div></div><div id='admin-topHeader'></div>";
	   
	   endif;
	   
	}
		
	public function menuSetGlobal($pageID,$page) {
	$site = substr(APP, 0, -1);
	$menuSet  = "<div class='menuSet'>";
	$menuSet .= "<input name='pageID' type='hidden' value='$pageID'><input name='menuID' type='hidden' value='$page'>";
	$menuSet .= "<ul id='adminMenuSet'>";
	$menuSet .= "<li><span><img src='".$site."/library/capsule/admin/image/capsuleIcon.png'></span><a href='#'>Capsule</a></li>";
	$menuSet .= "<li><span><img src='".$site."/library/capsule/admin/image/setting.png'></span><a href='#'>Sites</a></li>";
	$menuSet .= "<li><span><img src='".$site."/library/capsule/admin/image/setting.png'></span><a href='#'>Menu</a></li>";
	//$menuSet .= "<li><span><img src='library/capsule/admin/image/content.png'></span><a core='content' href='#'>Content</a></li>";
	$menuSet .= "<li><span><img src='".$site."/library/capsule/admin/image/taxonomy.png'></span><a href='#'>Tagonomy</a></li>";
	$menuSet .= "<li><span><img src='".$site."/library/capsule/admin/image/user.png'></span><a href='#'>User</a></li>";
	$menuSet .= "<li><span><img src='".$site."/library/capsule/admin/image/role.png'></span><a href='#'>Role</a></li>";
	$menuSet .= "<li><span><img src='".$site."/library/capsule/admin/image/info.png'></span><a href='#'>Info</a></li>";
	$menuSet .= "</ul>";
	$menuSet .= "</div>";
	$menuSet .= "<a class='adminLogout' href='index.php?id=logout'>Logout</a>";
	$menuSet .= "<a class='adminDesign' href='#design'>Design</a>";
	$menuSet .= "<a class='adminExit' style='display:none;' href='#exit'>Close Panel</a>";
	return $menuSet;
	}
	
	public function menuSetSites($pageID,$page) {
	$site = substr(APP, 0, -1);
	$menuSet  = "<div class='menuSet'>";
	$menuSet .= "<input name='pageID' type='hidden' value='$pageID'><input name='menuID' type='hidden' value='$page'>";
	$menuSet .= "<ul id='adminMenuSet'>";
	$menuSet .= "<li><span><img src='".$site."/library/capsule/admin/image/capsuleIcon.png'></span><a href='#'>Capsule</a></li>";
	$menuSet .= "<li><span><img src='".$site."/library/capsule/admin/image/setting.png'></span><a href='#'>Menu</a></li>";
	//$menuSet .= "<li><span><img src='library/capsule/admin/image/content.png'></span><a core='content' href='#'>Content</a></li>";
	$menuSet .= "<li><span><img src='".$site."/library/capsule/admin/image/taxonomy.png'></span><a href='#'>Tagonomy</a></li>";
	$menuSet .= "<li><span><img src='".$site."/library/capsule/admin/image/user.png'></span><a href='#'>User</a></li>";
	$menuSet .= "<li><span><img src='".$site."/library/capsule/admin/image/role.png'></span><a href='#'>Role</a></li>";
	$menuSet .= "<li><span><img src='".$site."/library/capsule/admin/image/info.png'></span><a href='#'>Info</a></li>";
	$menuSet .= "</ul>";
	$menuSet .= "</div>";
	$menuSet .= "<a class='adminLogout' href='index.php?id=logout'>Logout</a>";
	$menuSet .= "<a class='adminDesign' href='#design'>Design</a>";
	$menuSet .= "<a class='adminExit' style='display:none;' href='#exit'>Close Panel</a>";
	return $menuSet;
	}
	
	public function menuSetPersonal($pageID,$page) {
	$site = substr(APP, 0, -1);
	$menuSet  = "<div class='menuSet'>";
	$menuSet .= "<input name='pageID' type='hidden' value='$pageID'><input name='menuID' type='hidden' value='$page'>";
	$menuSet .= "<ul id='adminMenuSet'>";
	$menuSet .= "<li><span><img src='".$site."/library/capsule/admin/image/capsuleIcon.png'></span><a href='#'>Capsule</a></li>";
	$menuSet .= "<li><span><img src='".$site."/library/capsule/admin/image/setting.png'></span><a href='#'>Menu</a></li>";
	//$menuSet .= "<li><span><img src='library/capsule/admin/image/content.png'></span><a core='content' href='#'>Content</a></li>";
	$menuSet .= "<li><span><img src='".$site."/library/capsule/admin/image/taxonomy.png'></span><a href='#'>Tagonomy</a></li>";
	$menuSet .= "<li><span><img src='".$site."/library/capsule/admin/image/info.png'></span><a href='#'>Info</a></li>";
	$menuSet .= "</ul>";
	$menuSet .= "</div>";
	$menuSet .= "<a class='adminLogout' href='index.php?id=logout'>Logout</a>";
	$menuSet .= "<a class='adminDesign' href='#design'>Design</a>";
	$menuSet .= "<a class='adminExit' style='display:none;' href='#exit'>Close Panel</a>";
	return $menuSet;
	}
	
	public function displayCapsuleOption() {
	$view  = "<span class='displayCapsuleOptionHeader'>Capsule " . ucwords(strtolower($this->data[name])) . " Option</span>";
	$view .= "<hr/><br/>";
	$view .= "<table class='displayCapsuleOptionContent'>";

		foreach ($this->data as $key => $value) {
		
			if (is_array($value)) {
			
					foreach ($value as $key2 => $value2) {
					$view .= "<tr><td class='optionHeader'>" . ucwords(strtolower($key2)) . "</td>";
					
						if ($value2[type] == 'select') {
						$view .= "<td class='optionContent optionLeft'><select>";
							if (is_array($value2[value])) {
								foreach ($value2[value] as $key3 => $value3) {
								$view .= "<option value='$value3'>" . ucwords(strtolower($value3)) . "</option>";
								}
							}
						$view .= "</select></td>";
						}
						
						else if ($value2[type] == 'input') {
						$view .= "<td class='optionContent optionLeft'>";
						$view .= "<input class='optionInput' type='text' value=''>";
						$view .= "</td>";
						}
						
						else if ($value2[type] == 'data select') {
						$func = call_user_func($value2[value]);
							if (is_array($func)) {
							$view .= "<td class='optionContent optionLeft'><select>";
								foreach ($func as $key => $value) {
								$view .= "<option value='$value[id]'>" . ucwords(strtolower($value[name])) . "</option>";
								}
							$view .= "</select></td>";
							}
						}
						
						else if ($value2[type] == 'data select multi') {
						$func = call_user_func($value2[value]);
							if (is_array($func)) {
							$view .= "<td class='optionContent optionLeft'>";
							$y     = count($func);
							$i     = 0;
								foreach ($func as $key => $value) {
								$i++; if ($i == 1) {$valJS .= "<li class=\"option-first-separator\"></li>";}
								$valJS .= "<li class=\"option-select-multi\"><input class=\"option-check\" type=\"checkbox\" value=\"$value[id]\">$value[name]</li>";  
								if ($y != $i) {$valJS .= "<hr/>";} else {$valJS .= "<li class=\"option-last-separator\"></li>";}
								}
							$view .= "<input id='optionContentMulti' class='optionInput' type='text'></td>";
							
							$view .=
							"
							<script type='text/javascript'>
							jQuery.noConflict()(function($){
							$(document).ready(function() {
								$('#optionContentMulti').focus(function() {
								if ($('.optionGearContentMulti').length == 0) {
								$('.optionGearPopUp').append('<div class=\'optionGearContentMulti\'><div class=\'optionGearContentMultiContent\'>".$valJS."</div><div class=\'optionGearContentMultiButton\'><button id=\'option-select-multi-cancel\'>Reset</button><button id=\'option-select-multi-button\'>Done</button></div></div>');
								$('.optionGearContentMulti').center();
								$('.optionGearContentMulti').css('top', + 181 + 'px').css('left', + 94 + 'px');
								$('.optionGearContentMulti').hide();
								
								var checked = $('#optionContentMulti').val(); var pattern  = checked.split(',');
								z = pattern.length;
								
								$('.option-check').each(function(i) {
								
									for (i=0;i<z;i++) {
										if (pattern[i] == $(this).val()) {
										$(this).attr('checked', true);
										break;
										}
									}
								
								});
																
								$('.optionGearContentMulti').slideDown('fast');
									
									$('.option-check').click(function() {
									var check = $(this).attr('checked');
									var id	  = $(this).val();
									var last  = $('#optionContentMulti').val();
										if (check == 'checked') {
										$('#optionContentMulti').val($('#optionContentMulti').val()+$(this).val()+',');
										}
										else {
										var pattern  = last.split(',');
										z = pattern.length;
										var result;
										$('#optionContentMulti').val('');
											for (i=0;i<z;i++) {
												if (pattern[i] != id && pattern[i] != '') {
												$('#optionContentMulti').val($('#optionContentMulti').val()+pattern[i]+',');
												}
											}
										}
									});
									
									
									$('#option-select-multi-button').click(function() {
									$('.optionGearContentMulti').remove();
									});
									
									$('#option-select-multi-cancel').click(function() {
									$('.option-check').attr('checked', false);
									$('#optionContentMulti').val('');
									//$('.optionGearContentMulti').remove();
									});
								
								}
								});
								$('#optionContentMulti').blur(function() {
								//$('.optionGearContentMulti').remove();
								});
																
							});
							});
							</script>
							";
							
							}
						}
						
						else if ($value2[type] == 'data folder') {
						$func = call_user_func($value2[value]);
							if (is_array($func)) {
							$view .= "<td class='optionContent optionLeft'><select>";
								foreach ($func as $key => $value) {
									if ($value != '.' && $value != '..') {
									$view .= "<option value='$value'>" . ucwords(strtolower($value)) . "</option>";
									}
								
								}
								
							$view .= "</select></td>";
							
							}
							
						}
											
					}
					
			}
			
		$view .= "</tr>";
		
		}
	
	$view .= "</table>";
	$view .= "<br/><hr/>";
	$view .= "<button class='capCancelOption'>Cancel</button>&nbsp;&nbsp;<button class='capSubmitOption'>Submit Option</button>";
	
	echo $view;
	
	}

	public function displaySitesList($page, $limit) {
		
		$sessionRole = $_SESSION['role'];
		
		$pagingData = $this->data['paging'];
		$this->data = $this->data['data'];
		
		$language  = admin::getCompleteLanguageList();
		
		$sitesAll  = admin::getSitesList(null,null);
		
		$whiteList = array("main.css.php","main.info.php","main.js.php","main.tmpl.php",".DS_Store");

		$list = @scandir(ROOT_PATH."view/pages/");

		if (!empty($list)):

			foreach ($list as $key => $value):

				if ($value == '.' || $value == '..'): continue; endif;
			
				if (in_array($value,$whiteList)): continue; endif;

				$option [] = $value;

			endforeach;

		endif;

		$delMenuLi = "<input class='deletedMenuList' type='hidden'><input class='deletedMenuSet' type='hidden'>";
			
		$tableSet .= "<div id='admin-sitesSet'></div><table id=admin-menuSet class='admin-sitesSet'>";
				
		$tableSet .= "<thead>";
				
		$tableSet .= "<tr>";
				
		$tableSet .= "<td class='admin-checkBox'><input type='checkbox'></td><td>Domain</td><td>Tagline</td><td>Template</td><td>Language</td><td>Status</td>";

		$tableSet .= "</tr>";
				
		$tableSet .= "</thead>";
				
		$tableSet .= "<tbody>";

		if (!empty($this->data)):

			foreach ($this->data as $value):
			
				$tableSet .= "<tr>";
								
				$tableSet .= "<td class='admin-checkBox'><input type='checkbox' value='" . $value['CAP_MAI_ID'] . "'></td>";
								
				$tableSet .= "<td><input class='admin-inputInherit' type='text' value='" . $value['CAP_MAI_DOMAIN'] . "'></td>";

				$tableSet .= "<td><input class='admin-inputInherit' type='text' value='" . $value['CAP_MAI_NAME'] . "'></td>";

				$tableSet .= "<td><select class='select-chosen'>";

					foreach ($option as $keys => $values):

						if ($value['CAP_MAI_TEMPLATE'] == $values):

							$tableSet .= "<option selected='selected' value='".$values."'>".$values."</option>";

						else:

							$tableSet .= "<option value='".$values."'>".$values."</option>";

						endif;

					endforeach;

				$tableSet .= "</select></td>";

				$tableSet .= "<td><select class='select-chosen'>";

					if (!empty($language)):

						foreach ($language as $keyss => $valuess):

							if ($value['CAP_MAI_LANGUAGE'] == $valuess['CAP_LAN_ID']):

								$tableSet .= "<option selected='selected' value='".$valuess['CAP_LAN_ID']."'>".$valuess['CAP_LAN_NAME']."</option>";

							else:

								$tableSet .= "<option value='".$valuess['CAP_LAN_ID']."'>".$valuess['CAP_LAN_NAME']."</option>";

							endif;

						endforeach;

					endif;

				$tableSet .= "</select></td>";

				$tableSet .= "<td><select class='select-chosen'>";

					if ($value['CAP_MAI_SITE_ACTIVE'] == 0):

						$tableSet .= "<option selected='selected' value='0'>Inactive</option>";
						$tableSet .= "<option value='1'>Active</option>";
						$tableSet .= "<option value='2'>Suspended</option>";

					elseif ($value['CAP_MAI_SITE_ACTIVE'] == 1):

						$tableSet .= "<option value='0'>Inactive</option>";
						$tableSet .= "<option selected='selected' value='1'>Active</option>";
						$tableSet .= "<option value='2'>Suspended</option>";

					elseif ($value['CAP_MAI_SITE_ACTIVE'] == 2):

						$tableSet .= "<option value='0'>Inactive</option>";
						$tableSet .= "<option value='1'>Active</option>";
						$tableSet .= "<option selected='selected' value='2'>Suspended</option>";

					endif;

				$tableSet .= "</select></td>";

				$tableSet .= "<td style='display:none;'><input type='hidden' value='".$value['CAP_MAI_PARENT']."'></td>";
					
				$tableSet .= "</tr>";
						
			endforeach;
			
			else:
			
			$tableSet .= "<tr>";
													
				$tableSet .= "</tr>";
		
		endif;

		$tableSet .= "</tbody>";
				
		$tableSet .= "</table><br/>";
		
		if ($sessionRole == 1):
		
		$sites .= "<select class='administrator-select administrator-select-global-site' >";
		
		$sites .= "<option selected='selected' value='allsites'>Sites List</option>";
		
			if (!empty($sitesAll)):
						
				foreach ($sitesAll as $user => $role):
					
					if ($currentDomain==$role['CAP_MAI_DOMAIN']):
		
						$sites .= "<option value='$role[CAP_MAI_ID]'> - ".ucwords($role['CAP_MAI_DOMAIN'])."</option>";
						$sites .= "<input type='text' value='".ucwords($role['CAP_MAI_DOMAIN'])."' class='administrator-input-global-site' style='display:none' disabled='disabled'>";
		
					else:
		
						$sites .= "<option value='$role[CAP_MAI_ID]'> - ".ucwords($role['CAP_MAI_DOMAIN'])."</option>";
		
					endif;
				
				endforeach;
					
			endif;
											
			$sites .= "</select>";
		
		endif;
							
		$completeTable .= "<div class='admin-actContainer'>";
		
		$completeTable .= "<div class='admin-actContainer-addSetButton'>Sites</div>";
		
		$completeTable .= "<div class='admin-actContainer-addMenuButton'><img src='".$this->site."/library/capsule/admin/image/plus.png'></div>";
		
		$completeTable .= "<div class='admin-actContainer-delMenuButton'><img src='".$this->site."/library/capsule/admin/image/minus.png'></div>";
		
		$completeTable .= "<div class='adminSites-actContainer-SaveMenuButton'><img src='".$this->site."/library/capsule/admin/image/save.png'></div>";
			
		$completeTable .= "</div>";

		$completeTable .= "	
			<div class='admin-menuContainer'>

				<div class='admin-popUpHeader'>Capsule Core // Sites</div>
				<div class='admin-popUpHeaderAction'>
					<div class='admin-menuChooserContainer'>$sites</div>
					

				</div>
			</div>";
		
		$paging .= "<div class='pagination'>";
		$paging .= '<input type="hidden" class="curent-adminPagging" value='.$pagingData[0]['currentPage'].'>';
		$paging .= '<input type="hidden" class="total-adminPagging" value="'.$pagingData[0]['totalPage'].'">';
		
		$paging .= "<a class='btn prev-adminPagging prev-adminPagging-sites'>Prev</a>";
		$paging .= "<a class='btn next-adminPagging next-adminPagging-sites'>Next</a>";
		$paging .= "";
		$paging .= "</div>";
		
		$jumpPage .=  self::getJumpPage($pagingData[0]['totalPage'],$pagingData[0]['currentPage'],"site");
		$toolBar = "<div class='admin-second-actionbar' style='clear:both; width:100%; height:50px;'>
						<div class='admin-paggingContainer'>
							<div class='input-append'>
							<input class='span2' id='appendedInputButton' type='text'>
							<button class='btn admin-search-dispatcher' type='button'>Go!</button>
							</div>
						</div>
						<div class='admin-jumpPageContainer'>$jumpPage</div>
						<div class='admin-jumpPageContainer'>$paging</div>
						<div class='admin-jumpPageContainer'><div style='margin: 5px;height: 20px;float: right;'>".$pagingData[0]['StartData']." - ".$pagingData[0]['EndData']." of ". $pagingData[0]['totalData']."</div></div>
					</div>";
		$completeTable .= "<div class='admin-sitesSet'>" . $toolBar.$tableSet . "</div>" . $delMenuLi . $menuSet;
			
		echo $completeTable;
			
	}
	
	public function displaySitesListSearched() {
		
		$sessionRole = $_SESSION['role'];
		
		$limit = 20;
		
		$paging = count($this->data);
				
		$pagingData = ['totalPage' => $paging, 'currentPage' => misc::getTotalPage($paging,20)];
				
		$language  = admin::getCompleteLanguageList();
		
		$sitesAll  = admin::getSitesList(null,null);
		
		$whiteList = array("main.css.php","main.info.php","main.js.php","main.tmpl.php",".DS_Store");

		$list = @scandir(ROOT_PATH."view/pages/");

		if (!empty($list)):

			foreach ($list as $key => $value):

				if ($value == '.' || $value == '..'): continue; endif;
			
				if (in_array($value,$whiteList)): continue; endif;

				$option [] = $value;

			endforeach;

		endif;

		$delMenuLi = "<input class='deletedMenuList' type='hidden'><input class='deletedMenuSet' type='hidden'>";
			
		$tableSet .= "<table id=admin-menuSet class='admin-sitesSet'>";
				
		$tableSet .= "<thead>";
				
		$tableSet .= "<tr>";
				
		$tableSet .= "<td class='admin-checkBox'><input type='checkbox'></td><td>Domain</td><td>Tagline</td><td>Template</td><td>Language</td><td>Status</td>";

		$tableSet .= "</tr>";
				
		$tableSet .= "</thead>";
				
		$tableSet .= "<tbody>";

		if (!empty($this->data)):

			foreach ($this->data as $value):
			
				$tableSet .= "<tr>";
								
				$tableSet .= "<td class='admin-checkBox'><input type='checkbox' value='" . $value['CAP_MAI_ID'] . "'></td>";
								
				$tableSet .= "<td><input class='admin-inputInherit' type='text' value='" . $value['CAP_MAI_DOMAIN'] . "'></td>";

				$tableSet .= "<td><input class='admin-inputInherit' type='text' value='" . $value['CAP_MAI_NAME'] . "'></td>";

				$tableSet .= "<td><select class='select-chosen'>";

					foreach ($option as $keys => $values):

						if ($value['CAP_MAI_TEMPLATE'] == $values):

							$tableSet .= "<option selected='selected' value='".$values."'>".$values."</option>";

						else:

							$tableSet .= "<option value='".$values."'>".$values."</option>";

						endif;

					endforeach;

				$tableSet .= "</select></td>";

				$tableSet .= "<td><select class='select-chosen'>";

					if (!empty($language)):

						foreach ($language as $keyss => $valuess):

							if ($value['CAP_MAI_LANGUAGE'] == $valuess['CAP_LAN_ID']):

								$tableSet .= "<option selected='selected' value='".$valuess['CAP_LAN_ID']."'>".$valuess['CAP_LAN_NAME']."</option>";

							else:

								$tableSet .= "<option value='".$valuess['CAP_LAN_ID']."'>".$valuess['CAP_LAN_NAME']."</option>";

							endif;

						endforeach;

					endif;

				$tableSet .= "</select></td>";

				$tableSet .= "<td><select class='select-chosen'>";

					if ($value['CAP_MAI_SITE_ACTIVE'] == 0):

						$tableSet .= "<option selected='selected' value='0'>Inactive</option>";
						$tableSet .= "<option value='1'>Active</option>";
						$tableSet .= "<option value='2'>Suspended</option>";

					elseif ($value['CAP_MAI_SITE_ACTIVE'] == 1):

						$tableSet .= "<option value='0'>Inactive</option>";
						$tableSet .= "<option selected='selected' value='1'>Active</option>";
						$tableSet .= "<option value='2'>Suspended</option>";

					elseif ($value['CAP_MAI_SITE_ACTIVE'] == 2):

						$tableSet .= "<option value='0'>Inactive</option>";
						$tableSet .= "<option value='1'>Active</option>";
						$tableSet .= "<option selected='selected' value='2'>Suspended</option>";

					endif;

				$tableSet .= "</select></td>";

				$tableSet .= "<td style='display:none;'><input type='hidden' value='".$value['CAP_MAI_PARENT']."'></td>";
					
				$tableSet .= "</tr>";
						
			endforeach;
			
			else:
			
			$tableSet .= "<tr>";
													
				$tableSet .= "</tr>";
		
		endif;

		$tableSet .= "</tbody>";
				
		$tableSet .= "</table><br/>";
		
		if ($sessionRole == 1):
		
		$sites .= "<select class='administrator-select administrator-select-global-site' >";
		
		$sites .= "<option selected='selected' value='allsites'>Sites List</option>";
		
			if (!empty($sitesAll)):
						
				foreach ($sitesAll as $user => $role):
					
					if ($currentDomain==$role['CAP_MAI_DOMAIN']):
		
						$sites .= "<option value='$role[CAP_MAI_ID]'> - ".ucwords($role['CAP_MAI_DOMAIN'])."</option>";
						$sites .= "<input type='text' value='".ucwords($role['CAP_MAI_DOMAIN'])."' class='administrator-input-global-site' style='display:none' disabled='disabled'>";
		
					else:
		
						$sites .= "<option value='$role[CAP_MAI_ID]'> - ".ucwords($role['CAP_MAI_DOMAIN'])."</option>";
		
					endif;
				
				endforeach;
					
			endif;
											
		$sites .= "</select>";
		
		endif;
							
		$completeTable .= "<div class='admin-actContainer'>";
		
		$completeTable .= "<div class='admin-actContainer-addSetButton'>Sites</div>";
		
		$completeTable .= "<div class='admin-actContainer-addMenuButton'><img src='".$this->site."/library/capsule/admin/image/plus.png'></div>";
		
		$completeTable .= "<div class='admin-actContainer-delMenuButton'><img src='".$this->site."/library/capsule/admin/image/minus.png'></div>";
		
		$completeTable .= "<div class='adminSites-actContainer-SaveMenuButton'><img src='".$this->site."/library/capsule/admin/image/save.png'></div>";
			
		$completeTable .= "</div>";

		$completeTable .= "	
			<div class='admin-menuContainer'>

				<div class='admin-popUpHeader'>Capsule Core // Sites</div>
				<div class='admin-popUpHeaderAction'>
					<div class='admin-menuChooserContainer'>$sites</div>
					

				</div>
			</div>";
		
		$paging .= "<div class='pagination'>";
		$paging .= '<input type="hidden" class="curent-adminPagging" value='.$pagingData[0]['currentPage'].'>';
		$paging .= '<input type="hidden" class="total-adminPagging" value="'.$pagingData[0]['totalPage'].'">';
		
		$paging .= "<a class='btn prev-adminPagging prev-adminPagging-sites'>Prev</a>";
		$paging .= "<a class='btn next-adminPagging next-adminPagging-sites'>Next</a>";
		$paging .= "";
		$paging .= "</div>";
		
		$jumpPage .=  self::getJumpPage($pagingData[0]['totalPage'],$pagingData[0]['currentPage'],"site");
		$toolBar = "<div class='admin-second-actionbar' style='clear:both; width:100%; height:50px;'>
						<div class='admin-paggingContainer'>
							<div class='input-append'>
							<input class='span2' id='appendedInputButton' type='text'>
							<button class='btn admin-search-dispatcher' type='button'>Go!</button>
							</div>
						</div>
						<div class='admin-jumpPageContainer'>$jumpPage</div>
						<div class='admin-jumpPageContainer'>$paging</div>
						<div class='admin-jumpPageContainer'><div style='margin: 5px;height: 20px;float: right;'>".$pagingData[0]['StartData']." - ".$pagingData[0]['EndData']." of ". $pagingData[0]['totalData']."</div></div>
					</div>";
		$completeTable = $tableSet;
			
		echo $completeTable;
			
	}
	
	public function displaySubSitesList($parentID,$isSubDomain = false,$page, $limit) {
		
		$sessionRole = $_SESSION['role'];
		
		$pagingData = $this->data['paging'];
		$this->data = $this->data['data'];
		
		$language  = admin::getCompleteLanguageList();
		
		$sitesAll  = admin::getSitesList(null,null);
		
		$whiteList = array("main.css.php","main.info.php","main.js.php","main.tmpl.php",".DS_Store");
		
		$list = @scandir(ROOT_PATH."view/pages/");

		if (!empty($list)):

			foreach ($list as $key => $value):

				if ($value == '.' || $value == '..'): continue; endif;
			
				if (in_array($value,$whiteList)): continue; endif;

				$option [] = $value;

			endforeach;

		endif;

		$whiteList = array("main.css.php","main.info.php","main.js.php","main.tmpl.php",".DS_Store");
				
		$tableSet .= "<div id='admin-sitesSet'></div><table id=admin-menuSet class='admin-subSitesSet'>";
		$tableSet .= "<thead>";
				
		$tableSet .= "<tr>";
		
		if($isSubDomain){		
			$tableSet .= "<td class='admin-checkBox'><input type='checkbox'></td><td>Sub Domain</td><td>Tagline</td><td>Template</td><td>Language</td><td>Status</td>";
		}else{
			$tableSet .= "<td class='admin-checkBox'><input type='checkbox'></td><td>Domain</td><td>Tagline</td><td>Template</td><td>Language</td><td>Status</td>";		
		}
		$tableSet .= "</tr>";
				
		$tableSet .= "</thead>";
				
		$tableSet .= "<tbody>";

		if (!empty($this->data)):

			foreach ($this->data as $value):
			
				$tableSet .= "<tr>";
								
				$tableSet .= "<td class='admin-checkBox'><input type='checkbox' value='" . $value['CAP_MAI_ID'] . "'></td>";
								
				$tableSet .= "<td><input class='admin-inputInherit' type='text' value='" . $value['CAP_MAI_DOMAIN'] . "'></td>";

				$tableSet .= "<td><input class='admin-inputInherit' type='text' value='" . $value['CAP_MAI_NAME'] . "'></td>";

				$tableSet .= "<td><select class='select-chosen'>";

					foreach ($option as $keys => $values):

						if ($value['CAP_MAI_TEMPLATE'] == $values):

							$tableSet .= "<option selected='selected' value='".$values."'>".$values."</option>";

						else:

							$tableSet .= "<option value='".$values."'>".$values."</option>";

						endif;

					endforeach;

				$tableSet .= "</select></td>";

				$tableSet .= "<td><select class='select-chosen'>";

					if (!empty($language)):

						foreach ($language as $keyss => $valuess):

							if ($value['CAP_MAI_LANGUAGE'] == $valuess['CAP_LAN_ID']):

								$tableSet .= "<option selected='selected' value='".$valuess['CAP_LAN_ID']."'>".$valuess['CAP_LAN_NAME']."</option>";

							else:

								$tableSet .= "<option value='".$valuess['CAP_LAN_ID']."'>".$valuess['CAP_LAN_NAME']."</option>";

							endif;

						endforeach;

					endif;

				$tableSet .= "</select></td>";

				$tableSet .= "<td><select class='select-chosen'>";

					if ($value['CAP_MAI_SITE_ACTIVE'] == 0):

						$tableSet .= "<option selected='selected' value='0'>Inactive</option>";
						$tableSet .= "<option value='1'>Active</option>";
						$tableSet .= "<option value='2'>Suspended</option>";

					elseif ($value['CAP_MAI_SITE_ACTIVE'] == 1):

						$tableSet .= "<option value='0'>Inactive</option>";
						$tableSet .= "<option selected='selected' value='1'>Active</option>";
						$tableSet .= "<option value='2'>Suspended</option>";

					elseif ($value['CAP_MAI_SITE_ACTIVE'] == 2):

						$tableSet .= "<option value='0'>Inactive</option>";
						$tableSet .= "<option value='1'>Active</option>";
						$tableSet .= "<option selected='selected' value='2'>Suspended</option>";

					endif;

				$tableSet .= "</select></td>";

				$tableSet .= "<td><input class='parentOfSubdomain' type='hidden' value='".$value['CAP_MAI_PARENT']."'></td>";
					
				$tableSet .= "</tr>";
						
			endforeach;
			
			else:
			
			$tableSet .= "<tr>";
								
				/*$tableSet .= "<td class='admin-checkBox'><input type='checkbox' value=''></td>";
								
				$tableSet .= "<td><input class='admin-inputInherit' type='text' value=''></td>";

				$tableSet .= "<td><input class='admin-inputInherit' type='text' value=''></td>";

				$tableSet .= "<td><select class='select-chosen'>";

					foreach ($option as $keys => $values):
						
						$tableSet .= "<option value='".$values."'>".$values."</option>";

					endforeach;

				$tableSet .= "</select></td>";

				$tableSet .= "<td><select class='select-chosen'>";

					if (!empty($language)):

						foreach ($language as $keyss => $valuess):

							$tableSet .= "<option value='".$valuess['CAP_LAN_ID']."'>".$valuess['CAP_LAN_NAME']."</option>";

						endforeach;

					endif;

				$tableSet .= "</select></td>";

				$tableSet .= "<td><select class='select-chosen'>";

						$tableSet .= "<option value='0'>Inactive</option>";
						$tableSet .= "<option selected='selected' value='1'>Active</option>";
						$tableSet .= "<option value='2'>Suspended</option>";

				$tableSet .= "</select></td>";

				$tableSet .= "<td><input type='hidden' value=''></td>";*/
					
				$tableSet .= "</tr>";
		
		endif;

		$tableSet .= "</tbody>";
		$tableSet .= "</table><br/>";
				
		//$tableSet .= "</table><br/>";
		
				
		$paging .= "<div class='pagination'>";
		$paging .= '<input type="hidden" class="curent-adminPagging" value='.$pagingData[0]['currentPage'].'>';
		$paging .= '<input type="hidden" class="total-adminPagging" value="'.$pagingData[0]['totalPage'].'">';
		
		$paging .= "<a class='btn prev-adminPagging prev-adminPagging-sites'>Prev</a>";
		$paging .= "<a class='btn next-adminPagging next-adminPagging-sites'>Next</a>";
		$paging .= "";
		$paging .= "</div>";
		
		$jumpPage .=  self::getJumpPage($pagingData[0]['totalPage'],$pagingData[0]['currentPage'],"subsite");	
		$toolBar = "<div class='admin-second-actionbar' style='clear:both; width:100%; height:50px;'>
						<div class='admin-paggingContainer'>
							<div class='input-append'>
							<input class='span2' id='appendedInputButton' type='text'>
							<button class='btn admin-search-dispatcher' type='button'>Go!</button>
							</div>
						</div>
						<div class='admin-jumpPageContainer'>$jumpPage</div>
						<div class='admin-jumpPageContainer'>$paging</div>
						<div class='admin-jumpPageContainer'><div style='margin: 5px;height: 20px;float: right;'>".$pagingData[0]['StartData']." - ".$pagingData[0]['EndData']." of ". $pagingData[0]['totalData']."</div></div>
					</div>";
		$completeTable = $toolBar.$tableSet;
			
		echo $completeTable;
			
	}
	
	public function displaySubSitesListSearched() {
		
		$limit = 20;
		
		$paging = count($this->data);
				
		$pagingData = ['totalPage' => $paging, 'currentPage' => misc::getTotalPage($paging,20)];
				
		$language  = admin::getCompleteLanguageList();
		
		$sitesAll  = admin::getSitesList(null,null);
		
		$whiteList = array("main.css.php","main.info.php","main.js.php","main.tmpl.php",".DS_Store");
		
		$list = @scandir(ROOT_PATH."view/pages/");

		if (!empty($list)):

			foreach ($list as $key => $value):

				if ($value == '.' || $value == '..'): continue; endif;
			
				if (in_array($value,$whiteList)): continue; endif;

				$option [] = $value;

			endforeach;

		endif;

		$whiteList = array("main.css.php","main.info.php","main.js.php","main.tmpl.php",".DS_Store");
				
		$tableSet .= "<table id=admin-menuSet class='admin-subSitesSet'>";
		$tableSet .= "<thead>";
				
		$tableSet .= "<tr>";
		
		if($isSubDomain){		
			$tableSet .= "<td class='admin-checkBox'><input type='checkbox'></td><td>Sub Domain</td><td>Tagline</td><td>Template</td><td>Language</td><td>Status</td>";
		}else{
			$tableSet .= "<td class='admin-checkBox'><input type='checkbox'></td><td>Domain</td><td>Tagline</td><td>Template</td><td>Language</td><td>Status</td>";		
		}
		$tableSet .= "</tr>";
				
		$tableSet .= "</thead>";
				
		$tableSet .= "<tbody>";

		if (!empty($this->data)):

			foreach ($this->data as $value):
			
				$tableSet .= "<tr>";
								
				$tableSet .= "<td class='admin-checkBox'><input type='checkbox' value='" . $value['CAP_MAI_ID'] . "'></td>";
								
				$tableSet .= "<td><input class='admin-inputInherit' type='text' value='" . $value['CAP_MAI_DOMAIN'] . "'></td>";

				$tableSet .= "<td><input class='admin-inputInherit' type='text' value='" . $value['CAP_MAI_NAME'] . "'></td>";

				$tableSet .= "<td><select class='select-chosen'>";

					foreach ($option as $keys => $values):

						if ($value['CAP_MAI_TEMPLATE'] == $values):

							$tableSet .= "<option selected='selected' value='".$values."'>".$values."</option>";

						else:

							$tableSet .= "<option value='".$values."'>".$values."</option>";

						endif;

					endforeach;

				$tableSet .= "</select></td>";

				$tableSet .= "<td><select class='select-chosen'>";

					if (!empty($language)):

						foreach ($language as $keyss => $valuess):

							if ($value['CAP_MAI_LANGUAGE'] == $valuess['CAP_LAN_ID']):

								$tableSet .= "<option selected='selected' value='".$valuess['CAP_LAN_ID']."'>".$valuess['CAP_LAN_NAME']."</option>";

							else:

								$tableSet .= "<option value='".$valuess['CAP_LAN_ID']."'>".$valuess['CAP_LAN_NAME']."</option>";

							endif;

						endforeach;

					endif;

				$tableSet .= "</select></td>";

				$tableSet .= "<td><select class='select-chosen'>";

					if ($value['CAP_MAI_SITE_ACTIVE'] == 0):

						$tableSet .= "<option selected='selected' value='0'>Inactive</option>";
						$tableSet .= "<option value='1'>Active</option>";
						$tableSet .= "<option value='2'>Suspended</option>";

					elseif ($value['CAP_MAI_SITE_ACTIVE'] == 1):

						$tableSet .= "<option value='0'>Inactive</option>";
						$tableSet .= "<option selected='selected' value='1'>Active</option>";
						$tableSet .= "<option value='2'>Suspended</option>";

					elseif ($value['CAP_MAI_SITE_ACTIVE'] == 2):

						$tableSet .= "<option value='0'>Inactive</option>";
						$tableSet .= "<option value='1'>Active</option>";
						$tableSet .= "<option selected='selected' value='2'>Suspended</option>";

					endif;

				$tableSet .= "</select></td>";

				$tableSet .= "<td><input class='parentOfSubdomain' type='hidden' value='".$value['CAP_MAI_PARENT']."'></td>";
					
				$tableSet .= "</tr>";
						
			endforeach;
			
			else:
			
			$tableSet .= "<tr>";
								
				/*$tableSet .= "<td class='admin-checkBox'><input type='checkbox' value=''></td>";
								
				$tableSet .= "<td><input class='admin-inputInherit' type='text' value=''></td>";

				$tableSet .= "<td><input class='admin-inputInherit' type='text' value=''></td>";

				$tableSet .= "<td><select class='select-chosen'>";

					foreach ($option as $keys => $values):
						
						$tableSet .= "<option value='".$values."'>".$values."</option>";

					endforeach;

				$tableSet .= "</select></td>";

				$tableSet .= "<td><select class='select-chosen'>";

					if (!empty($language)):

						foreach ($language as $keyss => $valuess):

							$tableSet .= "<option value='".$valuess['CAP_LAN_ID']."'>".$valuess['CAP_LAN_NAME']."</option>";

						endforeach;

					endif;

				$tableSet .= "</select></td>";

				$tableSet .= "<td><select class='select-chosen'>";

						$tableSet .= "<option value='0'>Inactive</option>";
						$tableSet .= "<option selected='selected' value='1'>Active</option>";
						$tableSet .= "<option value='2'>Suspended</option>";

				$tableSet .= "</select></td>";

				$tableSet .= "<td><input type='hidden' value=''></td>";*/
					
				$tableSet .= "</tr>";
		
		endif;

		$tableSet .= "</tbody>";
		$tableSet .= "</table>";
				
		//$tableSet .= "</table><br/>";
		
				
		$paging .= "<div class='pagination'>";
		$paging .= '<input type="hidden" class="curent-adminPagging" value='.$pagingData[0]['currentPage'].'>';
		$paging .= '<input type="hidden" class="total-adminPagging" value="'.$pagingData[0]['totalPage'].'">';
		
		$paging .= "<a class='btn prev-adminPagging prev-adminPagging-sites'>Prev</a>";
		$paging .= "<a class='btn next-adminPagging next-adminPagging-sites'>Next</a>";
		$paging .= "";
		$paging .= "</div>";
		
		$jumpPage .=  self::getJumpPage($pagingData[0]['totalPage'],$pagingData[0]['currentPage'],"subsite");	
		$toolBar = "<div class='admin-second-actionbar' style='clear:both; width:100%; height:50px;'>
						<div class='admin-paggingContainer'>
							<div class='input-append'>
							<input class='span2' id='appendedInputButton' type='text'>
							<button class='btn admin-search-dispatcher' type='button'>Go!</button>
							</div>
						</div>
						<div class='admin-jumpPageContainer'>$jumpPage</div>
						<div class='admin-jumpPageContainer'>$paging</div>
						<div class='admin-jumpPageContainer'><div style='margin: 5px;height: 20px;float: right;'>".$pagingData[0]['StartData']." - ".$pagingData[0]['EndData']." of ". $pagingData[0]['totalData']."</div></div>
					</div>";
		$completeTable = $tableSet;
			
		echo $completeTable;
			
	}

	
	public function displayTagonomyList($currentDomain=null) {

		$sessionRole = $_SESSION['role'];
		
		if(isset($this->data['paging'])){
			$pagingData = $this->data['paging'];
			$this->data = $this->data['data'];
		}
	
		$sitesAll  = admin::getSitesAllSites();
		
		$currentDomain = (empty($currentDomain))? $this->getDomain() : $currentDomain;	
				
		$delMenuLi = "<input class='deletedMenuList' type='hidden'><input class='deletedMenuSet' type='hidden'>";
			
		$tableSet .= "<div id='admin-tagonomySet'></div><table id=admin-menuSet class='admin-tagonomySet'>";
				
		$tableSet .= "<thead>";
				
		$tableSet .= "<tr>";
				
		$tableSet .= "<td class='admin-checkBox'><input type='checkbox'></td><td>Name</td>";
					  
		$tableSet .= "</tr>";
				
		$tableSet .= "</thead>";
				
		$tableSet .= "<tbody>";
		
		if(!empty($this->data)):
			foreach ($this->data as $value):
			
				$tableSet .= "<tr>";
								
				$tableSet .= "<td class='admin-checkBox'><input type='checkbox' value='" . $value[CAP_CON_CAT_ID] . "'></td>";
								
				$tableSet .= "<td><input class='admin-inputInherit' type='text' value='" . $value[CAP_CON_CAT_NAME] . "'><input type='hidden' value='".$currentDomain."' ></td>";
					
				$tableSet .= "</tr>";
						
			endforeach;
		endif;
			
		$tableSet .= "</tbody>";
				
		$tableSet .= "</table><br/>";
		
			if ($sessionRole == 1):
		
			$sites = self::getSitesView($sitesAll,$currentDomain,'tagonomy');
			
			endif;
														
		$completeTable .= "<div class='admin-actContainer'>";
		
		$completeTable .= "<div class='admin-actContainer-addSetButton'>Tagonomy</div>";
		
		$completeTable .= "<div class='admin-actContainer-addMenuButton'><img src='".$this->site."/library/capsule/admin/image/plus.png'></div>";
		
		$completeTable .= "<div class='admin-actContainer-delMenuButton'><img src='".$this->site."/library/capsule/admin/image/minus.png'></div>";
		
		$completeTable .= "<div class='adminTagonomy-actContainer-SaveMenuButton'><img src='".$this->site."/library/capsule/admin/image/save.png'></div>";
			
		$completeTable .= "</div>";
		
		$completeTable .= "	
			<div class='admin-menuContainer'>
				<div class='admin-popUpHeader'>Capsule Core // Tagonomy</div>
				<div class='admin-popUpHeaderAction'>
					<div class='admin-menuChooserContainer'>$sites</div>
				</div>

			</div>";
		
		$paging .= "<div class='pagination'>";
		$paging .= '<input type="hidden" class="curent-adminPagging" value='.$pagingData[0]['currentPage'].'>';
		$paging .= '<input type="hidden" class="total-adminPagging" value="'.$pagingData[0]['totalPage'].'">';
		
		$paging .= "<a class='btn prev-adminPagging prev-adminPagging-tag'>Prev</a>";
		$paging .= "<a class='btn next-adminPagging next-adminPagging-tag'>Next</a>";
		$paging .= "";
		$paging .= "</div>";
		
		$jumpPage = self::getJumpPage($pagingData[0]['totalPage'],$pagingData[0]['currentPage'],"tagonomy");	
		$toolBar = "<div class='admin-second-actionbar' style='clear:both; width:100%; height:50px;'>
						<div class='admin-paggingContainer'>
							<div class='input-append'>
							<input class='span2' id='appendedInputButton' type='text'>
							<button class='btn admin-search-dispatcher' type='button'>Go!</button>
							</div>
						</div>
						<div class='admin-jumpPageContainer'>$jumpPage</div>
						<div class='admin-jumpPageContainer'>$paging</div>
						<div class='admin-jumpPageContainer'><div style='margin: 5px;height: 20px;float: right;'>".$pagingData[0]['StartData']." - ".$pagingData[0]['EndData']." of ". $pagingData[0]['totalData']."</div></div>
					</div>";
		$completeTable .= $toolBar.$tableSet . $delMenuLi . $menuSet;
			
		echo $completeTable;
			
	}

	public function displayUserList($currentDomain = null) {
	
		$sessionRole = $_SESSION['role'];
	
		if(isset($this->data['paging'])){
			$pagingData = $this->data['paging'];
			$this->data = $this->data['data'];
		}
		$sitesAll  = admin::getSitesList(null,20);
			
		$userRole  = admin::getRoleList(); 
				
		$delMenuLi = "<input class='deletedMenuList' type='hidden'><input class='deletedMenuSet' type='hidden'>";
					
		$tableSet .= "<div id='admin-userAction'></div><div class='clearfix'></div><div id='admin-userContainer'><table id=admin-menuSet class='admin-userSet'>";
				
		$tableSet .= "<thead>";
							
		$tableSet .= "<tr>";
		
		$tableSet .= "
		
			<td class='admin-checkBox'><img src='".$this->site."/library/capsule/admin/image/roleDetail.png'></td>
			<td class='admin-checkBox'><input type='checkbox'></td>
			<td>Name</td>
			<td>Email</td>
			<td>User Name</td>
			<!--td>Password</td-->
			<td class='optionCenter small'>Status</td>
			<td class='optionCenter small'>Role</td>";
					  
		$tableSet .= "</tr>";
				
		$tableSet .= "</thead>";
				
		$tableSet .= "<tbody>";
		
		if(!empty($this->data)):
 
			foreach ($this->data as $value):
			
			
				$tableSet .= "<tr>";
				
				$tableSet .= "<td class='admin-checkBox'><img class='adminUserDetail' src='".$this->site."/library/capsule/admin/image/roleDetail.png'></td>";

				$tableSet .= "<td class='admin-checkBox'><input type='checkbox' value='" . $value['CAP_USE_ID'] . "'></td>";
				
				$tableSet .= "<td>" . $value['CAP_USE_FIRSTNAME']." ". $value['CAP_USE_LASTNAME']  . "</td>";
				
				$tableSet .= "<td>" . $value['CAP_USE_EMAIL'] . "</td>";
				
				$tableSet .= "<td>" . $value['CAP_USE_USERNAME'] . "</td>";
				
				//$tableSet .= "<td><input class='admin-inputInheritPassword' type='text' value='Change Password'></td>";
				
				$tableSet .= "<td class='optionCenter'>";
				
					/*$tableSet .= "<select>";*/
					
					if ($value['CAP_USE_STATUS'] == 'Active'):

					//$tableSet .= "<option selected='selected' value='Active'>Active</option><option value='Inactive'>Inactive</option>";
					$tableSet .= "Active";

					else:

					//$tableSet .= "<option value='Active'>Active</option><option selected='selected' value='Inactive'>Inactive</option>";
					$tableSet .= "Inactive";

					endif;
										
					/*$tableSet .= "</select>";*/
				
				$tableSet .= "</td>";
				
				$tableSet .= "<td class='optionCenter'>";
				
				//$tableSet .= implode(',', $value);
				
				$z = 1;
				
				$c = count($value['ROLES']);
				
				if(!empty($userRole)):
				
					foreach ($userRole as $user => $role):
					
						if (@in_array($role['CAP_USE_ROL_ID'], $value['ROLES'])):
						
						$tableSet .= $role['CAP_USE_ROL_NAME'];
						
							if ($z != $c): $tableSet .= ", "; endif; $z++;
							
						endif; 
					
					endforeach;
				endif;
					
					//$tableSet .= "' disabled='disabled'>";
										
					/*$tableSet .= "</select>";*/
				
				$tableSet .= "</td>";
					
				$tableSet .= "</tr>";
						
			endforeach;
			
			
		endif;
			
		$tableSet .= "</tbody>";
				
		$tableSet .= "</table><br/>";

		$tableSet .= "</div>";

			if ($sessionRole == 1):
			
			$sites .= "<select class='administrator-select administrator-select-global-site-user' >";
		
			$sites .= "<option selected='selected' value='allsites'>Sites List</option>";
			
				if (!empty($sitesAll)):
							
					foreach ($sitesAll as $user => $role):
						
						if ($currentDomain==$role['CAP_MAI_ID']):

							$sites .= "<option rel='".$role['CAP_MAI_ID']."' value='".$role['CAP_MAI_ID']."' selected='selected'> - ".ucwords($role['CAP_MAI_DOMAIN'])."</option>";
			
						else:
			
							$sites .= "<option rel='".$role['CAP_MAI_ID']."' value='".$role['CAP_MAI_ID']."'> - ".ucwords($role['CAP_MAI_DOMAIN'])."</option>";
			
						endif;
					
					endforeach;
						
				endif;
											
			$sites .= "</select>";
			
			//$sites = self::getSitesView($sitesAll,$currentDomain,'user',1);
			
			endif;
		
		$completeTable .= "<div class='admin-actContainer'>";
		
		$completeTable .= "<div class='admin-actContainer-addSetButton'>User</div>";
		
		$completeTable .= "<div class='admin-actContainer-addMenuButton'><img src='".$this->site."/library/capsule/admin/image/plus.png'></div>";
		
		$completeTable .= "<div class='admin-actContainer-delMenuButton'><img src='".$this->site."/library/capsule/admin/image/minus.png'></div>";
		
		$completeTable .= "<div class='adminUser-actContainer-SaveMenuButton'><img src='".$this->site."/library/capsule/admin/image/save.png'></div>";
			
		$completeTable .= "</div>";
		
		$completeTable .= "	
			<div class='admin-menuContainer'>
				<div class='admin-popUpHeader'>Capsule Core // Users</div>
				<div class='admin-popUpHeaderAction'>
					<div class='admin-menuChooserContainer'>$sites</div>
				</div>
			</div>";
		
		
		
		$completeTable .= 
		"<script type='text/javascript'>
		
		var newUserTableRowCreation = \"<tr><td><input type='checkbox' value=''></td><td><input class='admin-inputInherit' type='text'></td><td><input class='admin-inputInherit' type='text'></td><td><input class='admin-inputInherit' type='text'></td><td><input class='admin-inputInheritPassword' type='text' value='Change Password'></td><td class='optionCenter'><select><option value='Active'>Active</option><option selected='selected' value='Inactive'>Inactive</option></select></td><td class='optionCenter'>$userSetRowCreator</td></tr>\"
		jQuery.noConflict()(function($){
		$('.admin-inputInheritPassword').focus(function() {
			if ($(this).val() == 'Change Password') {
			$(this).val(''); $(this).removeClass(); $(this).addClass('admin-inputInheritPasswordActive');
			}
		});
		
		$('.admin-inputInheritPasswordActive').live('blur',function() {
			if ($(this).val() == '') {
			$(this).val('Change Password'); $(this).removeClass(); $(this).addClass('admin-inputInheritPassword');
			}
		});
		});
		
		</script>";
		
		$paging .= "<div class='pagination'>";
		$paging .= '<input type="hidden" class="curent-adminPagging" value='.$pagingData[0]['currentPage'].'>';
		$paging .= '<input type="hidden" class="total-adminPagging" value="'.$pagingData[0]['totalPage'].'">';
		
		$paging .= "<a class='btn prev-adminPagging prev-adminPagging-user'>Prev</a>";
		$paging .= "<a class='btn next-adminPagging next-adminPagging-user'>Next</a>";
		$paging .= "";
		$paging .= "</div>";
		
		$jumpPage .=  self::getJumpPage($pagingData[0]['totalPage'],$pagingData[0]['currentPage'],"user");	
		$toolBar = "<div class='admin-second-actionbar' style='clear:both; width:100%; height:50px;'>
						<div class='admin-paggingContainer'>
							<div class='input-append'>
							<input class='span2' id='appendedInputButton' type='text'>
							<button class='btn admin-search-dispatcher' type='button'>Go!</button>
							</div>
						</div>
						<div class='admin-jumpPageContainer'>$jumpPage</div>
						<div class='admin-jumpPageContainer'>$paging</div>
						<div class='admin-jumpPageContainer'><div style='margin: 5px;height: 20px;float: right;'>".$pagingData[0]['StartData']." - ".$pagingData[0]['EndData']." of ". $pagingData[0]['totalData']."</div></div>
					</div>";
		$container_open = "<div id='container-user'>";
		$container_close = "</div>";
		$completeTable .= $toolBar.$tableSet . $delMenuLi . $menuSet;
		
		echo $container_open.$completeTable.$container_close;
			
	}
	
	public function displayUserListSearched($currentDomain = null) {
		
		$sessionRole = $_SESSION['role'];
		
		if(isset($this->data['paging'])){
			$pagingData = $this->data['paging'];
			$this->data = $this->data['data'];
		}
		$sitesAll  = admin::getSitesAllSites();
			
		$userRole  = admin::getRoleList(); 
				
		$delMenuLi = "<input class='deletedMenuList' type='hidden'><input class='deletedMenuSet' type='hidden'>";
					
		$tableSet .= "<div id='admin-userAction'></div><div class='clearfix'></div><div id='admin-userContainer'><table id=admin-menuSet class='admin-userSet'>";
				
		$tableSet .= "<thead>";
							
		$tableSet .= "<tr>";
		
		$tableSet .= "
		
			<td class='admin-checkBox'><img src='".$this->site."/library/capsule/admin/image/roleDetail.png'></td>
			<td class='admin-checkBox'><input type='checkbox'></td>
			<td>Name</td>
			<td>Email</td>
			<td>User Name</td>
			<!--td>Password</td-->
			<td class='optionCenter small'>Status</td>
			<td class='optionCenter small'>Role</td>";
					  
		$tableSet .= "</tr>";
				
		$tableSet .= "</thead>";
				
		$tableSet .= "<tbody>";
		
		if(!empty($this->data)):
 
			foreach ($this->data as $value):
			
			
				$tableSet .= "<tr>";
				
				$tableSet .= "<td class='admin-checkBox'><img class='adminUserDetail' src='".$this->site."/library/capsule/admin/image/roleDetail.png'></td>";

				$tableSet .= "<td class='admin-checkBox'><input type='checkbox' value='" . $value['CAP_USE_ID'] . "'></td>";
				
				$tableSet .= "<td>" . $value['FULLNAME'] . "</td>";
				
				$tableSet .= "<td>" . $value['CAP_USE_EMAIL'] . "</td>";
				
				$tableSet .= "<td>" . $value['CAP_USE_USERNAME'] . "</td>";
				
				//$tableSet .= "<td><input class='admin-inputInheritPassword' type='text' value='Change Password'></td>";
				
				$tableSet .= "<td class='optionCenter'>";
				
					/*$tableSet .= "<select>";*/
					
					if ($value['CAP_USE_STATUS'] == 'Active'):

					//$tableSet .= "<option selected='selected' value='Active'>Active</option><option value='Inactive'>Inactive</option>";
					$tableSet .= "Active";

					else:

					//$tableSet .= "<option value='Active'>Active</option><option selected='selected' value='Inactive'>Inactive</option>";
					$tableSet .= "Inactive";

					endif;
										
					/*$tableSet .= "</select>";*/
				
				$tableSet .= "</td>";
				
				$tableSet .= "<td class='optionCenter'>";
				
				//$tableSet .= implode(',', $value);
				
				$z = 1;
				
				$c = count($value['ROLES']);
				
				if(!empty($userRole)):
				
					foreach ($userRole as $user => $role):
					
						if (@in_array($role['CAP_USE_ROL_ID'], $value['ROLES'])):
						
						$tableSet .= $role['CAP_USE_ROL_NAME'];
						
							if ($z != $c): $tableSet .= ", "; endif; $z++;
							
						endif; 
					
					endforeach;
				endif;
					
					//$tableSet .= "' disabled='disabled'>";
										
					/*$tableSet .= "</select>";*/
				
				$tableSet .= "</td>";
					
				$tableSet .= "</tr>";
						
			endforeach;
			
			
		endif;
			
		$tableSet .= "</tbody>";
				
		$tableSet .= "</table><br/>";

		$tableSet .= "</div>";
			
			if ($sessionRole == 1):
			
			//$sites = self::getSitesView($sitesAll,$currentDomain,'user',1);
			
			$sites .= "<select class='administrator-select administrator-select-global-site-user' >";
		
			$sites .= "<option selected='selected' value='allsites'>Sites List</option>";
			
				if (!empty($sitesAll)):
							
					foreach ($sitesAll as $user => $role):
						
						if ($currentDomain==$role['CAP_MAI_ID']):

							$sites .= "<option rel='".$role['CAP_MAI_ID']."' value='".$role['CAP_MAI_ID']."' selected='selected'> - ".ucwords($role['CAP_MAI_DOMAIN'])."</option>";
			
						else:
			
							$sites .= "<option rel='".$role['CAP_MAI_ID']."' value='".$role['CAP_MAI_ID']."'> - ".ucwords($role['CAP_MAI_DOMAIN'])."</option>";
			
						endif;
					
					endforeach;
						
				endif;
											
			$sites .= "</select>";
			
			endif;
		
		$completeTable .= "<div class='admin-actContainer'>";
		
		$completeTable .= "<div class='admin-actContainer-addSetButton'>User</div>";
		
		$completeTable .= "<div class='admin-actContainer-addMenuButton'><img src='".$this->site."/library/capsule/admin/image/plus.png'></div>";
		
		$completeTable .= "<div class='admin-actContainer-delMenuButton'><img src='".$this->site."/library/capsule/admin/image/minus.png'></div>";
		
		$completeTable .= "<div class='adminUser-actContainer-SaveMenuButton'><img src='".$this->site."/library/capsule/admin/image/save.png'></div>";
			
		$completeTable .= "</div>";
		
		$completeTable .= "	
			<div class='admin-menuContainer'>
				<div class='admin-popUpHeader'>Capsule Core // Users</div>
				<div class='admin-popUpHeaderAction'>
					<div class='admin-menuChooserContainer'>$sites</div>
				</div>
			</div>";
		
		
		
		$completeTable .= 
		"<script type='text/javascript'>
		
		var newUserTableRowCreation = \"<tr><td><input type='checkbox' value=''></td><td><input class='admin-inputInherit' type='text'></td><td><input class='admin-inputInherit' type='text'></td><td><input class='admin-inputInherit' type='text'></td><td><input class='admin-inputInheritPassword' type='text' value='Change Password'></td><td class='optionCenter'><select><option value='Active'>Active</option><option selected='selected' value='Inactive'>Inactive</option></select></td><td class='optionCenter'>$userSetRowCreator</td></tr>\"
		jQuery.noConflict()(function($){
		$('.admin-inputInheritPassword').focus(function() {
			if ($(this).val() == 'Change Password') {
			$(this).val(''); $(this).removeClass(); $(this).addClass('admin-inputInheritPasswordActive');
			}
		});
		
		$('.admin-inputInheritPasswordActive').live('blur',function() {
			if ($(this).val() == '') {
			$(this).val('Change Password'); $(this).removeClass(); $(this).addClass('admin-inputInheritPassword');
			}
		});
		});
		
		</script>";
		
		$paging .= "<div class='pagination'>";
		$paging .= '<input type="hidden" class="curent-adminPagging" value='.$pagingData[0]['currentPage'].'>';
		$paging .= '<input type="hidden" class="total-adminPagging" value="'.$pagingData[0]['totalPage'].'">';
		
		$paging .= "<a class='btn prev-adminPagging prev-adminPagging-user'>Prev</a>";
		$paging .= "<a class='btn next-adminPagging next-adminPagging-user'>Next</a>";
		$paging .= "";
		$paging .= "</div>";
		
		$jumpPage .=  self::getJumpPage($pagingData[0]['totalPage'],$pagingData[0]['currentPage'],"user");	
		$toolBar = "<div class='admin-second-actionbar' style='clear:both; width:100%; height:50px;'>
						<div class='admin-paggingContainer'>
							<div class='input-append'>
							<input class='span2' id='appendedInputButton' type='text'>
							<button class='btn admin-search-dispatcher' type='button'>Go!</button>
							</div>
						</div>
						<div class='admin-jumpPageContainer'>$jumpPage</div>
						<div class='admin-jumpPageContainer'>$paging</div>
						<div class='admin-jumpPageContainer'><div style='margin: 5px;height: 20px;float: right;'>".$pagingData[0]['StartData']." - ".$pagingData[0]['EndData']." of ". $pagingData[0]['totalData']."</div></div>
					</div>";
		$container_open = "<div id='container-user'>";
		$container_close = "</div>";
		$completeTable = $tableSet;
		
		echo $completeTable;
			
	}
	
	public function displayRoleList($currentDomain = null) {
		
		$sessionRole = $_SESSION['role'];
		
		if(isset($this->data['paging'])){
			$pagingData = $this->data['paging'];
			$this->data = $this->data['data'];
		}
		
		$sitesAll  = admin::getSitesAllSites(null,null);
		
		$userRole  = admin::getRoleList();
				
		$delMenuLi = "<input class='deletedMenuList' type='hidden'><input class='deletedMenuSet' type='hidden'>";
			
		$tableSet .= "<div id='admin-userSet'></div><table id=admin-menuSet class='admin-roleSet'>";
				
		$tableSet .= "<thead>";
				
		$tableSet .= "<tr>";
				
		$tableSet .= "
			<td class='admin-checkBox'><img src='".$this->site."/library/capsule/admin/image/roleDetail.png'></td>
			<td class='admin-checkBox'><input type='checkbox'></td>
			<td>Role</td>
			<td>Description</td>
			<td class='optionRight small'>Status</td>
			<td class='optionCenter small'>Landing Page</td>";
					  
		$tableSet .= "</tr>";
				
		$tableSet .= "</thead>";
				
		$tableSet .= "<tbody>";
		
		$menuStruc = $this->menuListOptionSelect(admin::getMenuList($_SESSION['language'],null,1),0,null);
		
		if(!empty($this->data)):

			foreach ($this->data as $value) {
				
				if (
				
				$value['CAP_USE_ROL_ID'] == 1 || 
				$value['CAP_USE_ROL_ID'] == 2 ||
				$value['CAP_USE_ROL_ID'] == 3 || 
				$value['CAP_USE_ROL_ID'] == 4
				) {continue;}
				
				$tableSet .= "<tr>";
				
				$tableSet .= "<td class='admin-checkBox'><img class='adminContentList' src='".$this->site."/library/capsule/admin/image/roleDetail.png'></td>";
				
				$tableSet .= "<td class='admin-checkBox'><input type='checkbox' value='" . $value['CAP_USE_ROL_ID'] . "'></td>";
				
				$tableSet .= "<td><input class='admin-inputInherit' type='text' value='" . $value['CAP_USE_ROL_NAME'] . "'></td>";
				
				$tableSet .= "<td><input class='admin-inputInherit' type='text' value='" . $value['CAP_USE_ROL_DESC'] . "'></td>";
								
				$tableSet .= "<td class='optionRight'>";
				
					$tableSet .= "<select class='administrator-select optionLeft small'>";
					
					if ($value['CAP_USE_ROL_STATUS'] == 'Active') {
					$tableSet .= "<option selected='selected' value='Active'>Active</option><option value='Inactive'>Inactive</option>";
					}
					else {
					$tableSet .= "<option value='Active'>Active</option><option selected='selected' value='Inactive'>Inactive</option>";
					}
										
					$tableSet .= "</select>";
				
				$tableSet .= "</td>";
				
				$tableSet .= "<td><select class='landing-page administrator-select'>";
				
				$tableSet .= "<option selected='selected' disabled='disabled'>Select Page</option>";
				
				
				
				$menuStruc = str_replace("selected='selected'", "", $menuStruc);

				$menuStruc = str_replace("value='".$value['FK_CAP_MEN_ID']."'", "selected='selected' value='".$value['FK_CAP_MEN_ID']."'", $menuStruc);

				//$menuStruc = $this->menuListOptionSelect(admin::getMenuList($_SESSION['language']),0,$value['FK_CAP_MEN_ID']);
				
				$tableSet .= $menuStruc;
				
				$tableSet .= "</select><input type='hidden' class='parentOfSubdomain' value='".$value['FK_CAP_MAI_ID']."'></td>";
				
				$tableSet .= "</tr>";
						
			}
		else:
		
								
				$tableSet .= "<tr>";
				
				$tableSet .= "<td class='admin-checkBox'><img class='adminContentList' src='".$this->site."/library/capsule/admin/image/roleDetail.png'></td>";
				
				$tableSet .= "<td class='admin-checkBox'><input type='checkbox' value=''></td>";
				
				$tableSet .= "<td><input class='admin-inputInherit' type='text' value=''></td>";
				
				$tableSet .= "<td><input class='admin-inputInherit' type='text' value=''></td>";
								
				$tableSet .= "<td class='optionRight'>";
				
					$tableSet .= "<select class='administrator-select optionLeft small'>";
					
					if ($value['CAP_USE_ROL_STATUS'] == 'Active') {
					$tableSet .= "<option selected='selected' value='Active'>Active</option><option value='Inactive'>Inactive</option>";
					}
					else {
					$tableSet .= "<option value='Active'>Active</option><option selected='selected' value='Inactive'>Inactive</option>";
					}
										
					$tableSet .= "</select>";
				
				$tableSet .= "</td>";
				
				$tableSet .= "<td><select class='landing-page administrator-select'>";
				
				$tableSet .= "<option selected='selected' disabled='disabled'>Select Page</option>";
				
				
				
				$menuStruc = str_replace("selected='selected'", "", $menuStruc);

				$menuStruc = str_replace("value='".$value['FK_CAP_MEN_ID']."'", "selected='selected' value='".$value['FK_CAP_MEN_ID']."'", $menuStruc);

				//$menuStruc = $this->menuListOptionSelect(admin::getMenuList($_SESSION['language']),0,$value['FK_CAP_MEN_ID']);
				
				$tableSet .= $menuStruc;
				
				$tableSet .= "</select><input type='hidden' class='parentOfSubdomain' value='".admin::getDomainID($currentDomain)."'></td>";
				
				$tableSet .= "</tr>";
						
			
				
		endif;
			
			if ($sessionRole == 1):
			
			$sites = self::getSitesView($sitesAll,$currentDomain,'role');
			
			endif;
			
		$tableSet .= "</tbody>";
				
		$tableSet .= "</table><br/>";
		
		$completeTable .= "<div class='admin-actContainer'>";
		
		$completeTable .= "<div class='admin-actContainer-addSetButton'>Roles</div>";
		
		$completeTable .= "<div class='admin-actContainer-addMenuButton'><img src='".$this->site."/library/capsule/admin/image/plus.png'></div>";
		
		$completeTable .= "<div class='admin-actContainer-delMenuButton'><img src='".$this->site."/library/capsule/admin/image/minus.png'></div>";
		
		$completeTable .= "<div class='adminRoles-actContainer-SaveMenuButton'><img src='".$this->site."/library/capsule/admin/image/save.png'></div>";
			
		$completeTable .= "</div>";
		
		$completeTable .= "	
			<div class='admin-menuContainer'>
				<div class='admin-popUpHeader'>Capsule Core // Roles</div>
				<div class='admin-popUpHeaderAction'>
					<div class='admin-menuChooserContainer'>$sites</div>
				</div>
			</div>";
		
		$userSetRowCreator .=  "<select>";
		
			if (!empty($userRole)) {
			
				foreach ($userRole as $user => $role) {
				
					$userSetRowCreator .= "<option value='$role[CAP_USE_ROL_ID]'>".ucwords($role['CAP_USE_ROL_NAME'])."</option>";
				
				}
				
			}
							
		$userSetRowCreator .= "</select>";
		
		$completeTable .= 
		"<script type='text/javascript'>
		jQuery.noConflict()(function($){
		var newUserTableRowCreation = \"<tr><td class='admin-checkBox'><img class='adminContentList' src='".$this->site."/library/capsule/admin/image/roleDetail.png'></td><td><input type='checkbox' value=''></td><td><input class='admin-inputInherit' type='text'></td><td class='optionRight'><select class='optionLeft small'><option value='Active'>Active</option><option selected='selected' value='Inactive'>Inactive</option></select></td><td><select class='landing-page'><option selected='selected' disabled='disabled'>Select Page</option>$menuStruc</select></td></tr>\"
		
		$('.admin-inputInheritPassword').focus(function() {
			if ($(this).val() == 'Change Password') {
			$(this).val(''); $(this).removeClass(); $(this).addClass('admin-inputInheritPasswordActive');
			}
		});
		
		$('.admin-inputInheritPasswordActive').live('blur',function() {
			if ($(this).val() == '') {
			$(this).val('Change Password'); $(this).removeClass(); $(this).addClass('admin-inputInheritPassword');
			}
		});
		});
		</script>";
		/*
		$paging .= "<div class='pagination'>";
		$paging .= '<input type="hidden" class="curent-adminPagging" value='.$pagingData[0]['currentPage'].'>';
		$paging .= '<input type="hidden" class="total-adminPagging" value="'.$pagingData[0]['totalPage'].'">';
		
		$paging .= "<a class='btn prev-adminPagging prev-adminPagging-role'>Prev</a>";
		$paging .= "<a class='btn next-adminPagging next-adminPagging-role'>Next</a>";
		$paging .= "";
		$paging .= "</div>";
		
		$jumpPage .= self::getJumpPage($pagingData[0]['totalPage'],$pagingData[0]['currentPage'],"role");	
		$toolBar = "<div class='admin-second-actionbar' style='clear:both; width:100%; height:50px;'>
						<div class='admin-paggingContainer'>
							<div class='input-append'>
							<input class='span2' id='appendedInputButton' type='text'>
							<button class='btn admin-search-dispatcher' type='button'>Go!</button>
							</div>
						</div>
						<div class='admin-jumpPageContainer'>$jumpPage</div>
						<div class='admin-jumpPageContainer'>$paging</div>
						<div class='admin-jumpPageContainer'><div style='margin: 5px;height: 20px;float: right;'>".$pagingData[0]['StartData']." - ".$pagingData[0]['EndData']." of ". $pagingData[0]['totalData']."</div></div>
					</div>";
		*/			
		$completeTable .= $toolBar.$tableSet . $delMenuLi . $menuSet;
		
		echo $completeTable;
		
	}

	public function menuListOptionSelect($menu,$num,$userRole) {
		$iterator = 0;
		foreach ($menu as $key => $value) {
				
			if(is_array($value)) {
				
				if($key == 'child') {
				
				$num++;

				}
				
				$menuBuild .= self::menuListOptionSelect($value,$num,$userRole);
				
			}
			else{
				
				if ($key == 'CAP_MEN_ID') {
				
					$id = $value;
					
				}
						
				if ($key == 'menuSetName') {
				
					//$menuBuild .= "<option disabled='disabled'>".$value."</option>";
					if($iterator!=0){
						$menuBuild .= "</optgroup>";
					}
					$menuBuild .= "<optgroup label='".$value."'>";
					
				}
				else if ($key == 'CAP_LAN_COM_VALUE') {
					
					for ($i = 1; $i < $num; $i++) {
						$sign .= "-";
					}

					
						if ($userRole == $id) {

							$menuBuild .= "<option selected='selected' value='".$id."'> $sign ".$value."</option>";

						}
						else {

							$menuBuild .= "<option  value='".$id."'> $sign ".$value."</option>";
							
						}
					
					
										
				}
				
				
			}
			
			
		}
	
	return $menuBuild;
	
	}
	
	public function displayContentList() {
	
	$dataContentCat  = admin::getContentCategoryList();
	
	$dataContentType = admin::getContentTypeList();
	
	$dataPages 		 = admin::getPagesList();
	
	$dataLanguage 	 = admin::getLanguageList();
	
	$langDefault	 = admin::defaultLanguage();
	
	$option .= "<option value='' selected='selected'>All</option>";
	
		foreach ($dataContentType as $value) {
		$option .= "<option value='$value[CAP_CON_TYP_ID]'>" . ucwords(strtolower($value[CAP_CON_TYP_TYPE])) . "</option>";
		}
			
	$delMenuLi = "<input class='deletedMenuList' type='hidden'><input class='deletedMenuSet' type='hidden'>";
	
	$tableSet .= "<script type='text/javascript'>" . adminJavascript::newContent($dataContentCat,$dataContentType,$dataPages,$dataLanguage,$langDefault) . "</script>";
		
	$tableSet .= "<div id='contentPlace'></div><table id=admin-menuSet class='contentTable'>";
			
	$tableSet .= "<thead>";
			
	$tableSet .= "<tr>";
			
	$tableSet .= "<td class='admin-checkBox'><img src='".$this->site."/library/capsule/admin/image/cloudUpload.png'></td>
				  <td class='admin-checkBox'><input type='checkbox'></td>
				  <td>Name</td>
				  <td class='optionCenter'>Published</td>
				  <td class='optionCenter'>Type</td>
				  <td class='optionCenter'>Category</td>
				  <td class='optionCenter'>Pages</td>";
				  
			
	$tableSet .= "</tr>";
			
	$tableSet .= "</thead>";
			
	$tableSet .= "<tbody>";

		foreach ($this->data as $value) {
		
			$tableSet .= "<tr>";
			
			$tableSet .= "<td class='admin-checkBox'><img class='adminContentList' src='".$this->site."/library/capsule/admin/image/cloudUpload.png'></td>";
			
			$tableSet .= "<td><input type='checkbox' value='" . $value[CAP_CON_ID] . "'></td>";
				/*
				if ($value[CAP_LAN_COM_COLUMN] == 'header') {
				$tableSet .= "<td class='admin-inputInherit'>" . $value[CAP_LAN_COM_VALUE] . "</td>";
				}
				*/
				//if ($value[CAP_LAN_COM_COLUMN] == 'header') {
				$tableSet .= "<td class='admin-inputInherit'>" . $value[CAP_CON_HEADER] . "</td>";
				//}
				
				if ($value[CAP_CON_PUBLISHED] == 'Y') {
				$tableSet .= "<td class='optionCenter'><img src='".$this->site."library/capsule/admin/image/checkbox.png'></td>";
				}
				else {
				$tableSet .= "<td class='optionCenter'><img src='".$this->site."library/capsule/admin/image/checkboxEmpty.png'></td>";
				}
			
				if ($value[CAP_CON_TYP_TYPE] == 'content') {
				$tableSet .= "<td class='optionCenter'><img  finder='here' type='content' src='".$this->site."library/capsule/admin/image/document.png'></td>";
				}
				else if ($value[CAP_CON_TYP_TYPE] == 'video') {
				$tableSet .= "<td class='optionCenter'><img  finder='here' type='video' src='".$this->site."library/capsule/admin/image/video.png'></td>";
				}
				else if ($value[CAP_CON_TYP_TYPE] == 'image') {
				$tableSet .= "<td class='optionCenter'><img  finder='here' type='image' src='".$this->site."library/capsule/admin/image/picture.png'></td>";
				}
				else if ($value[CAP_CON_TYP_TYPE] == 'file') {
				$tableSet .= "<td class='optionCenter'><img  finder='here' type='file' src='".$this->site."library/capsule/admin/image/file.png'></td>";
				}
				else if ($value[CAP_CON_TYP_TYPE] == 'audio') {
				$tableSet .= "<td class='optionCenter'><img  finder='here' type='audio' src='".$this->site."library/capsule/admin/image/audio.png'></td>";
				}
				
			$tableSet .= "<td class='optionCenter'><select>";
			
				foreach ($dataContentCat as $category) {
				
					if ($value[CAP_CON_CAT_ID] == $category[CAP_CON_CAT_ID]) {
					
					$tableSet .= "<option selected='selected' value='$category[CAP_CON_CAT_ID]'>" . $category[CAP_CON_CAT_NAME] . "</option>";
					
					}
					else {
					
					$tableSet .= "<option value='$category[CAP_CON_CAT_ID]'>" . $category[CAP_CON_CAT_NAME] . "</option>";
					
					}
								
				}
			
			$tableSet .= "</td></select>";
				
			$tableSet .= "<td class='optionCenter'><select>";
	
			$tableSet .= "<option selected='selected' value=''>Select Pages</option>";
	
				foreach ($dataPages as $pages) {
		
					if ($value[CAP_PAG_ID] == $pages[CAP_PAG_ID]) {
					$tableSet .= "<option selected='selected' value='" . $pages[CAP_PAG_ID] . "'>" . ucwords(strtolower($pages[CAP_PAG_NAME])) . "</option>";
					}
					else {
					$tableSet .= "<option value='" . $pages[CAP_PAG_ID] . "'>" . ucwords(strtolower($pages[CAP_PAG_NAME])) . "</option>";
					}
		
				}
	
			$tableSet .= "</select></td>";

			
			$tableSet .= "</tr>";
					
		}
		
	$tableSet .= "</tbody>";
			
	$tableSet .= "</table><br/>";
	
	$completeTable .= "<div class='admin-actContainer'>";
	
	$completeTable .= "<div class='admin-actContainer-addSetButton'>Contents</div>";
	
	$completeTable .= "<div class='admin-actContainer-addMenuButton'><img src='".$this->site."/library/capsule/admin/image/plus.png'></div>";
	
	$completeTable .= "<div class='admin-actContainer-delMenuButton'><img src='".$this->site."/library/capsule/admin/image/minus.png'></div>";
	
	$completeTable .= "<div class='adminContent-actContainer-SaveMenuButton'><img src='".$this->site."/library/capsule/admin/image/save.png'></div>";
		
	$completeTable .= "</div>";
		
	$completeTable .= "	
		<div class='admin-menuContainer'>
			<div class='admin-popUpHeader'>Capsule Core // Contents</div>
			<div class='admin-popUpHeaderAction'><select class='adminContent-menuChooser'>$option</select></div>
		</div>";
	
	$paging .= "<div class='pagination'>";
		
		$paging .= "<div class='pagination'>";
		$paging .= '<input type="hidden" class="curent-adminPagging" value='.$pagingData[0]['currentPage'].'>';
		$paging .= '<input type="hidden" class="total-adminPagging" value="'.$pagingData[0]['totalPage'].'">';
		
		$paging .= "<a class='btn prev-adminPagging prev-adminPagging-menu'>Prev</a>";
		$paging .= "<a class='btn next-adminPagging next-adminPagging-menu'>Next</a>";
		$paging .= "";
		$paging .= "</div>";
		
		$jumpPage .= "<div style='margin: 5px;height: 20px;float: left;'>Jump To :</div>";
		$jumpPage .= '<select class="administrator-select">';
		for($i=1;$i<=$pagingData[0]['totalPage'];$i++){
			
			if($i == $pagingData[0]['currentPage']){
				$jumpPage .= '<option value="'.$i.'" selected="selected">'.$i.'</option>';
			}else{
				$jumpPage .= '<option value="'.$i.'">'.$i.'</option>';
			}
			
		}
		$jumpPage .= '</select>';	
		$toolBar = "<div style='clear:both; width:100%; height:50px;'>
						<div class='admin-paggingContainer'>
							<div class='input-append'>
							<input class='span2' id='appendedInputButton' type='text'>
							<button class='btn admin-search-dispatcher' type='button'>Go!</button>
							</div>
						</div>
						<div class='admin-jumpPageContainer'>$jumpPage</div>
						<div class='admin-paggingContainer'>$paging</div>
						<div class='admin-paggingContainer'><div style='margin: 5px;height: 20px;float: right;'>".$pagingData[0]['StartData']." - ".$pagingData[0]['EndData']." of ". $pagingData[0]['totalData']."</div></div>
					</div>";
		$completeTable .= $toolBar.$tableSet . $delMenuLi . $menuSet;
		
	echo $completeTable;
		
	}
	
	public function displayMenuList($currentDomain=null) {
	
	$sessionRole = $_SESSION['role'];
	
	if(isset($this->data[0]['paging'])){
			$pagingData = $this->data[0]['paging'];
		}
		
	$dataPages = admin::getPagesList($currentDomain);
	
	$dataRole  = admin::getRoleList();
	
	$sitesAll  = admin::getSitesAllSites();
	
	$currentDomain = (empty($currentDomain))? $this->getDomain() : $currentDomain;	
	
	
	$delMenuLi = "<input class='deletedMenuList' type='hidden'><input class='deletedMenuSet' type='hidden'>";
	
	$menuSet   = "<table id='admin-menuSet' class='admin-MenuSet'>";
	
	$menuSet .= "<thead>";
	
	$menuSet .= "<tr>";
	
	$menuSet .= "<td class='admin-checkBox'><input type='checkbox'></td><td>Name</td>";
	
	$menuSet .= "</tr>";
			
	$menuSet .= "</thead>";
	
	$menuSet .= "<tbody>";
	
	
	
	$option   .= "<option value='$value[menuSetID]' tableID='admin-menuSet'>Menu Set</option>";
		
		if (!empty($this->data)) {
		
			foreach ($this->data as $key => $value) {
			
			$option   .= "<option value='$value[menuSetID]' tableID='$value[menuSetID]-" . str_replace(" ","",($value['menuSetName'])) . "'>- $value[menuSetName]</option>";
			
			$menuSet .= "<tr>
						 <td><input type='checkbox' value='$value[menuSetID]'></td>
						 <td><input class='admin-inputInherit' type='text' value='" . ucwords(strtolower($value['menuSetName'])) . "'><input type='hidden' value='".$currentDomain."'></td>
						 </tr>";
			
			}
		
		}
	
	$menuSet .= "</tbody>";
		
	$menuSet .= "</table>";
		
		if (!empty($this->data)) {
		
			foreach ($this->data as $key => $value) {
					
				if ($value['parentMenuSet']) {
				
				$tableSet .= "<table class='admin-MenuList' myTurn='$value[menuSetID]' id='$value[menuSetID]-" . str_replace(" ","",($value['menuSetName'])) . "'>";
				
				$tableSet .= "<thead>";
				
				$tableSet .= "<tr>";
				
				$tableSet .= "<td class='admin-checkBox'><img src='".$this->site."/library/capsule/admin/image/list.png'></td>
							  <td class='admin-checkBox'><input type='checkbox'></td>
							  <td>Name</td>
							  <td class='optionCenter'>Description</td>
							  <td class='optionCenter'>Image Path</td>
							  <td class='optionCenter'>Other URL</td>
							  <td class='optionCenter'>Access</td>
							  <td class='optionCenter'>Status</td>
							  <td class='optionCenter'>Pages</td>";
				
				$tableSet .= "</tr>";
				
				$tableSet .= "</thead>";
				
				$tableSet .= "<tbody class='sortableBody'>";
				
					foreach ($value['parentMenuSet'] as $keyParent => $valueParent) {
					
					$tableSet .= self::recursiveDisplayMenuList($valueParent,1,$value['menuSetID'],$dataPages,$dataRole);
					
					}
				
				$tableSet .= "</tbody>";
				
				$tableSet .= "</table>";
				
				}
				
				else {
				
				$tableSet .= "<table class='admin-MenuList' myTurn='$value[menuSetID]' id='$value[menuSetID]-" . str_replace(" ","",($value['menuSetName'])) . "'>";
				
				$tableSet .= "<thead>";
				
				$tableSet .= "<tr>";
				
				$tableSet .= "<td class='admin-checkBox'><img src='".$this->site."/library/capsule/admin/image/list.png'></td>
							  <td class='admin-checkBox'><input type='checkbox'></td>
							  <td>Name</td>
							  <td class='optionCenter'>Description</td>
							  <td class='optionCenter'>Image Path</td>
							  <td class='optionCenter'>Other URL</td>
							  <td class='optionCenter'>Access</td>
							  <td class='optionCenter'>Status</td>
							  <td class='optionCenter'>Pages</td>";
				
				$tableSet .= "</tr>";
				
				$tableSet .= "</thead>";
				
				$tableSet .= "<tbody class='sortableBody'>";
				
				$tableSet .= "</tbody>";
				
				$tableSet .= "</table>";
				
				}
			
			}
		
		}
	
		if ($sessionRole == 1):
	
		$sites = self::getSitesView($sitesAll,$currentDomain,'menu');
		
		endif;
	
	$completeTable .= "<div class='admin-actContainer'>";
	
	$completeTable .= "<div class='admin-actContainer-addSetButton'>Menu Set</div>";
	
	$completeTable .= "<div class='admin-actContainer-addMenuButton'><img src='".$this->site."/library/capsule/admin/image/plus.png'></div>";
	
	$completeTable .= "<div class='admin-actContainer-delMenuButton'><img src='".$this->site."/library/capsule/admin/image/minus.png'></div>";
	
	$completeTable .= "<div class='admin-actContainer-SaveMenuButton'><img src='".$this->site."/library/capsule/admin/image/save.png'></div>";
		
	$completeTable .= "</div>";
		
	$completeTable .= "	
		<div class='admin-menuContainer'>
			<div class='admin-popUpHeader'>Capsule Core // Menu</div>
			<div class='admin-popUpHeaderAction'>
				<div class='admin-menuChooserContainer'>$sites &nbsp;&nbsp;<select class='admin-menuChooser'>$option</select></div>
				<div class='admin-languageSelect'></div>
			</div>
		</div>";
		
		
	/*
		$paging .= "<div class='pagination'>";
		$paging .= '<input type="hidden" class="curent-adminPagging" value='.$pagingData[0]['currentPage'].'>';
		$paging .= '<input type="hidden" class="total-adminPagging" value="'.$pagingData[0]['totalPage'].'">';
		
		$paging .= "<a class='btn prev-adminPagging prev-adminPagging-menu'>Prev</a>";
		$paging .= "<a class='btn next-adminPagging next-adminPagging-menu'>Next</a>";
		$paging .= "";
		$paging .= "</div>";
	
	$jumpPage .=  self::getJumpPage($pagingData[0]['totalPage'],$pagingData[0]['currentPage'],"menu");
	$toolBar = "<div class='admin-second-actionbar' style='clear:both; width:100%; height:50px;'>
					<div class='admin-paggingContainer'>
						<div class='input-append'>
						<input class='span2' id='appendedInputButton' type='text'>
						<button class='btn admin-search-dispatcher' type='button'>Go!</button>
						</div>
					</div>
					<div class='admin-jumpPageContainer'>$jumpPage</div>
					<div class='admin-jumpPageContainer'>$paging</div>
					<div class='admin-jumpPageContainer'><div style='margin: 5px;height: 20px;float: right;'>".$pagingData[0]['StartData']." - ".$pagingData[0]['EndData']." of ". $pagingData[0]['totalData']."</div></div>
				</div>";
	*/
	$completeTable .= $toolBar.$tableSet . $delMenuLi . $menuSet;
		
	echo $completeTable;
	
	}
	
	
	
	public function recursiveDisplayMenuList($valueParent,$i,$menuSetID,$dataPages,$dataRole) {
	//print_r($dataPages);
	//print_r($valueParent);
	$padding = 0;
	
		for ($c = 1; $c <= $i; $c++) {
			
			if ($i == 1) {continue;} $padding += $i*2+2;
			
		}
	
	$table .= "<tr class='draggableMenu'>";
	$table .= "<td class='admin-draggableHandler'><img src='".$this->site."/library/capsule/admin/image/list.png'></td>";
	$table .= "<td><input type='checkbox' value='" . $valueParent['parent']['CAP_MEN_ID'] . "'></td>";
	
		if ($padding == 0) {
		$table .= "<td class='myStyle' padding='$padding' style='padding-left:" . $padding . "px'>
				  <input class='admin-inputInherit' type='text' value='" . $valueParent['parent']['CAP_LAN_COM_VALUE'] . "'></td>";
		}
		else {
		$table .= "<td class='myStyle' padding=$padding style='padding-left:" . $padding . "px'>
				   <img class='childMenu' src='".$this->site."/library/capsule/admin/image/rowChild.png'>
				   <input class='admin-inputInherit' type='text' value='" . $valueParent['parent']['CAP_LAN_COM_VALUE'] . "'></td>";
		}
		
	$table .= "<td><input class='admin-menu-class' type='text' value='" . $valueParent['parent']['CAP_LAN_COM_DESCRIPTION'] . "'></td>";
	
	$table .= "<td><input class='admin-menu-class' type='text' value='" . $valueParent['parent']['CAP_MEN_IMG'] . "'></td>";
	
	$table .= "<td><input class='admin-menu-class' type='text' value='" . $valueParent['parent']['CAP_MEN_OTHERURL'] . "'></td>";
	
	$table .= "<td class='optionCenter'><select class='admin-menu-class'>";
	//print_r($dataRole);
	
		foreach ($dataRole as $key => $value) {
			
			if ($valueParent['parent']['CAP_MEN_ACCESS'] == $value['CAP_USE_ROL_ID']) {
			$table .= "<option value='$value[CAP_USE_ROL_ID]' selected='selected'>".ucwords($value['CAP_USE_ROL_NAME'])."</option>";
			}
			else {
			$table .= "<option value='$value[CAP_USE_ROL_ID]'>".ucwords($value['CAP_USE_ROL_NAME'])."</option>";
			}
			
		}
			  	
	$table .= "</select></td>";
	
	$table .= "<td class='optionCenter'><select class='admin-menu-class'>";
	
		if ($valueParent['parent']['CAP_MEN_STATUS'] == 'Inactive') {
		$table .= "<option value='Active'>Active</option><option value='Inactive' selected='selected'>Inactive</option>";
		}
		else {
		$table .= "<option value='Active' selected='selected'>Active</option><option value='Inactive'>Inactive</option>";
		}

	$table .= "</select><input type='hidden' value='$menuSetID'></td>";
	
	$table .= "<td class='optionCenter'><input name='parentID' type='hidden' value='" . $valueParent['parent']['CAP_MEN_PARENT'] . "'>";
			   
	$table .= "<select class='admin-menu-class'>";
	
	$table .= "<option selected='selected' value=''>Select Pages</option>";
		
		if (!empty($dataPages)):

			foreach ($dataPages as $key => $value):
			
			
			
			$template = explode("/",$value['CAP_PAG_PATH']);
			
			//echo $template[2];
								
					if ($value['CAP_PAG_ID'] == $valueParent['parent']['CAP_PAG_ID']):
					
					$table .= "<option selected='selected' value='" . $value['CAP_PAG_ID'] . "'>" .$template[3]." - ". $value['CAP_PAG_NAME'] . "</option>";

					else:

					$table .= "<option value='" . $value['CAP_PAG_ID'] . "'>" . $template[3]." - ". $value['CAP_PAG_NAME'] . "</option>";
					
					endif;
				
				
			
			endforeach;

		endif;
	
	$table .= "</select>";
	
	$table .= "<input name='position' type='hidden' value=''>";
	
     
                
	$table .= "</td>";
			    
	$table .= "</tr>";		

		if (isset($valueParent['child'])) {
		$i++;
			foreach ($valueParent['child'] as $value) {
			$table .= self::recursiveDisplayMenuList($value,$i,$menuSetID,$dataPages,$dataRole);
			}
		
		}
		
	return $table;
		
	}
	
	public function getDomain(){
		
		return $_SERVER['HTTP_HOST'];
		
	}
	
	public function getUserToEdit() {
		
		$sessionRole = $_SESSION['role'];
		
		$userRole  = admin::getRoleList();
		
		$sitesAll  = admin::getSitesList(null,null);
		
		$template  = admin::getAllTemplate();
		
		$currentDomain = $this->getDomain();		

		$view  = "<hr class='admin-hr-class'>";
				
		$view .= "<form class='form-horizontal' id='administrator-user-edit'>";

			$view .= "<div class='control-group'>";

				$view .= "<label class='control-label administrator-label' for='name'>Full Name</label>";

				$view .= "<div class='controls administrator-controls'>";
				
				$view .= "<input type='hidden' id='id' value='".$this->data['CAP_USE_ID']."'>";
				
				$view .= "<input class='span6' type='text' id='name' value='".$this->data['CAP_USE_FIRSTNAME'].' '.$this->data['CAP_USE_LASTNAME']."'>";

				$view .= "</div>";

			$view .= "</div>";

			$view .= "<div class='control-group'>";

				$view .= "<label class='control-label administrator-label' for='email'>Email</label>";

				$view .= "<div class='controls administrator-controls'>";

				$view .= "<input class='span6' type='text' id='email' value='".$this->data['CAP_USE_EMAIL']."'>";

				$view .= "</div>";

			$view .= "</div>";

			$view .= "<div class='control-group'>";

				$view .= "<label class='control-label administrator-label' for='username'>Username</label>";

				$view .= "<div class='controls administrator-controls'>";

				$view .= "<input class='span6' type='text' id='username' value='".$this->data['CAP_USE_USERNAME']."'>";

				$view .= "</div>";

			$view .= "</div>";

			$view .= "<div class='control-group'>";

				$view .= "<label class='control-label administrator-label' for='password'>Password</label>";

				$view .= "<div class='controls administrator-controls'>";

				$view .= "<input class='span6' type='password' id='password'>";

				$view .= "</div>";

			$view .= "</div>";

			$view .= "<div class='control-group'>";

				$view .= "<label class='control-label administrator-label' for='status'>Status</label>";

				$view .= "<div class='controls administrator-controls'>";

				$view .= "<select id='status' class='administrator-select span6'>";
					
					if ($this->data['CAP_USE_STATUS'] == 'Active'):

					$view .= "<option selected='selected' value='Active'>Active</option><option value='Inactive'>Inactive</option>";

					else:

					$view .= "<option value='Active'>Active</option><option selected='selected' value='Inactive'>Inactive</option>";

					endif;
										
					$view .= "</select>";

				$view .= "</div>";

			$view .= "</div>";
			
			$view .= "<hr>";
			
			/*
			$view .= "<div class='control-group'>";

				$view .= "<label class='control-label administrator-label ' for='Global User'>Global User</label>";

				$view .= "<div class='controls administrator-controls'>";
				
					if (!empty($this->data['CAP_USE_GLOBAL'])):
				
					$view .= "<input id='global' checked='checked' class='administrator-checkbox administrator-checkbox-global' type='checkbox' value='1'> This user id can be used through all sites";
					
					else:
					
					$view .= "<input id='global' class='administrator-checkbox administrator-checkbox-global' type='checkbox' value='1'> This user id can be used through all sites";
					
					endif;
								
				$view .= "</div>";

			$view .= "</div>";
			*/
			
			$view .= "<div class='control-group'>";
				
				$view .= "<label class='control-label administrator-label' for='role'>Role</label>";
				
				$view .= "<div class='controls administrator-controls'>";
				
				$view .= "<select id='role' class='administrator-select span6' multiple='multiple'>";
				
				//if(!empty($this->data['CAP_USE_GLOBALSTATUS'])) {
				
					foreach ($userRole as $user => $role):
					    
					    if ($role['CAP_USE_ROL_ID'] == 4): continue; endif;
					    
					    if ($sessionRole == 2 && $role['CAP_USE_ROL_ID'] == 1 || $sessionRole == 2 && $role['CAP_USE_ROL_ID'] == 5): continue; endif;
					    
						if ($role['CAP_USE_ROL_ID'] == $this->data['CAP_USE_GLOBALSTATUS']):
						
							$checked = "checked='checked'";
						
						endif;
												
						if (@in_array($role['CAP_USE_ROL_ID'], $this->data['ROLES'])):

							$view .= "<option selected='selected' value='$role[CAP_USE_ROL_ID]'>".ucwords($role['CAP_USE_ROL_NAME'])."</option>";

						else:

							$view .= "<option value='$role[CAP_USE_ROL_ID]'>".ucwords($role['CAP_USE_ROL_NAME'])."</option>";

						endif;
											
					endforeach;
					
				//}
										
					$view .= "</select>";

				$view .= "</div>";

			$view .= "</div>";
			
			if ($sessionRole == 1):
			
				$view .= "<div class='control-group'>";
	
					$view .= "<label class='control-label administrator-label' for='location'>Location</label>";
	
					$view .= "<div class='controls administrator-controls'>";
													
					$view .= "<select id='location' class='administrator-select span6'>";
					
					$view .= "<option selected='selected' value=''></option>";
					
						foreach ($sitesAll as $user => $role):
							
							if ($this->data['FK_CAP_MAI_ID'] == $role['CAP_MAI_ID']):
	
								$view .= "<option selected='selected' value='$role[CAP_MAI_ID]'>".$role['CAP_MAI_DOMAIN']."</option>";
	
							else:
	
								$view .= "<option value='$role[CAP_MAI_ID]'>".$role['CAP_MAI_DOMAIN']."</option>";
	
							endif;
						
						endforeach;
																
					$view .= "</select>";
	
					$view .= "</div>";
	
				$view .= "</div>";
			
			endif;
			
			$view .= "<hr>";
			
			$view .= "<div class='control-group'>";

				$view .= "<label class='control-label administrator-label ' for='siteuser'>Site User</label>";

				$view .= "<div class='controls administrator-controls'>";
				
					if (empty($this->data['FK_CAP_MAI_ID_LOCATION'])):
				
					$view .= "<input id='siteuser' class='administrator-checkbox administrator-checkbox-global' type='checkbox' value='1'> This user have personal site";
					
					else:
					
					$view .= "<input id='siteuser' checked='checked' class='administrator-checkbox administrator-checkbox-global' type='checkbox' value='1'> This user have personal site";
					
					endif;
				
				$view .= "</div>";

			$view .= "</div>";

			$view .= "<div class='control-group'>";

				$view .= "<label class='control-label administrator-label' for='domain'>Personal Site</label>";

				$view .= "<div class='controls administrator-controls'>";
				
				$view .= "<input id='domain' class='span6' type='text' placeholder='Site' id='domain' value='".str_replace('.'.$this->data['PARENT_DOMAIN'],'',$this->data['CAP_MAI_DOMAIN'])."'>";
												
				$view .= "</div>";

			$view .= "</div>";
			
			$view .= "<div class='control-group'>";

				$view .= "<label class='control-label administrator-label' for='template'>Template</label>";

				$view .= "<div class='controls administrator-controls'>";
												
				$view .= "<select id='template' class='administrator-select span6'>";
				
				$view .= "<option selected='selected' value=''></option>";

					foreach ($template as $temp => $plate):
						
						if ($this->data['CAP_MAI_TEMPLATE'] == $plate):

							$view .= "<option selected='selected' value='$plate'>".$plate."</option>";

						else:

							$view .= "<option value='$plate'>".$plate."</option>";

						endif;
					
					endforeach;
															
				$view .= "</select>";

				$view .= "</div>";

			$view .= "</div>";
						
		$view .= "</form>";

		echo $view;

	}

	public function getContentToEdit() {
	
	header('Content-Type: application/json');
	
		foreach ($this->data as $key => $value) {
			
			if ($value['CAP_LAN_COM_COLUMN'] == 'header') {
				$header = $value['CAP_LAN_COM_VALUE'];
			}
			else if ($value['CAP_LAN_COM_COLUMN'] == 'content') {
				$content = $value['CAP_LAN_COM_VALUE'];
			}
			
		}
	
	$data = array(
	"id" 		=> $this->data[0][CAP_CON_ID],
	"category" 	=> $this->data[0][FK_CAP_CONTENT_CATEGORY],
	"published" => $this->data[0][CAP_CON_PUBLISHED],
	"pages" 	=> $this->data[0][CAP_CON_PAGES],
	"header" 	=> $header,
	"content" 	=> $content,
	"language"	=> $this->data[0][CAP_LAN_COM_LAN_ID]
	);
	
	echo json_encode($data);
	
	}
	
	public function getContentToEditAjax() {
	
	header('Content-Type: application/json');
		
	$data = array(
	"id" 		=> $this->data[0][CAP_CON_ID],
	"category" 	=> $this->data[0][FK_CAP_CONTENT_CATEGORY],
	"published" => $this->data[0][CAP_CON_PUBLISHED],
	"pages" 	=> $this->data[0][CAP_CON_PAGES],
	"header" 	=> $this->data[1][CAP_LAN_COM_VALUE],
	"content" 	=> $this->data[0][CAP_LAN_COM_VALUE],
	"language"	=> $this->data[0][CAP_LAN_COM_LAN_ID]
	);
	
	echo json_encode($data);
	
	}
	
	public function getFileToEdit() {
		//print_r($this->data);
		header('Content-Type: application/json');
		
		$count = count($this->data);
		
		$view  = "<table id='admin-fileContent'>";
		
		$i 	   = 0;
		
		$y	   = 0;
		
			for ($i; $i <= $count; $i++) {
			
			$x     = 0;
			
			$flag  = 'N';
			
			$view .= "<tr>";
			
				for ($z = $y; $z <= $count; $z++) {
				
				$x++;
				
				$break = explode("/",$this->data[$z][path]);
				
				$type  = strtolower($break[2]);
				
					if ($z == $count) {
				
					$flag = 'Y'; break;
				
					} 
				
					else if ($x == 6) {
					
						if ($type == 'video') {
						
							if (pathinfo($this->data[$z][path], PATHINFO_EXTENSION) != 'jpg') {
							
							$ext = pathinfo($this->data[$z][path], PATHINFO_DIRNAME)."/".pathinfo($this->data[$z][path], PATHINFO_FILENAME)."."."jpg";
							
							$view .= "
							<td>
							<input type='checkbox' class='image-floatLeft' value='".$this->data[$z][path]."'>
							<img class='image-floatLeftLink admin-image-link' src='".$this->site."library/capsule/admin/image/link.png' value='http://".$_SERVER['HTTP_HOST'].APP.$this->data[$z][path]."'/>
							<img class='image-floatLeftLink admin-image-metadata' src='".$this->site."library/capsule/admin/image/folder.png' value='http://".$_SERVER['HTTP_HOST'].APP.$this->data[$z][path]."' id='".$this->data[$z][id]."'/>
							<img src='framework/resize.class.php?src=" . $ext . "&h=90&w=120&zc=1' alt=''/>
							</td>"; 
							
							$y = $z+1; 
							break;
							
							}
	
						
						}
						else {
					
						$view .= "
						<td>
						<input type='checkbox' class='image-floatLeft' value='".$this->data[$z][path]."'>
						<img class='image-floatLeftLink admin-image-link' src='".$this->site."library/capsule/admin/image/link.png' value='http://".$_SERVER['HTTP_HOST'].APP.$this->data[$z][path]."'/>
						<img class='image-floatLeftLink admin-image-metadata' src='".$this->site."library/capsule/admin/image/folder.png' value='http://".$_SERVER['HTTP_HOST'].APP.$this->data[$z][path]."' id='".$this->data[$z][id]."'/>
						<img src='framework/resize.class.php?src=" . $this->data[$z][path] . "&h=90&w=120&zc=1' alt=''/>
						</td>"; 
					
						$y = $z+1; 
						break;
					
						}
					
					}
					
					else {
					
						if ($type == 'video') {
						
							if (pathinfo($this->data[$z][path], PATHINFO_EXTENSION) != 'jpg') {
							
							$ext = pathinfo($this->data[$z][path], PATHINFO_DIRNAME)."/".pathinfo($this->data[$z][path], PATHINFO_FILENAME)."."."jpg";
	
							$view .= "
							<td>
							<input type='checkbox' class='image-floatLeft' value='".$this->data[$z][path]."'>
							<img class='image-floatLeftLink admin-image-link' src='".$this->site."library/capsule/admin/image/link.png' value='http://".$_SERVER['HTTP_HOST'].APP.$this->data[$z][path]."'/>
							<img class='image-floatLeftLink admin-image-metadata' src='".$this->site."library/capsule/admin/image/folder.png' value='http://".$_SERVER['HTTP_HOST'].APP.$this->data[$z][path]."' id='".$this->data[$z][id]."'/>
							<img src='framework/resize.class.php?src=" . $ext . "&h=90&w=120&zc=1' alt=''/>
							</td>"; 
													
							}
	
						
						}
						else {
					
						$view .= "
						<td>
						<input type='checkbox' class='image-floatLeft' value='".$this->data[$z][path]."'>
						<img class='image-floatLeftLink admin-image-link' src='".$this->site."library/capsule/admin/image/link.png' value='http://".$_SERVER['HTTP_HOST'].APP.$this->data[$z][path]."'/>
						<img class='image-floatLeftLink admin-image-metadata' src='".$this->site."library/capsule/admin/image/folder.png' value='http://".$_SERVER['HTTP_HOST'].APP.$this->data[$z][path]."' id='".$this->data[$z][id]."'/>
						<img src='framework/resize.class.php?src=" . $this->data[$z][path] . "&h=90&w=120&zc=1' alt=''/>
						</td>";
					
						}
					
					}
				
				}
			
			if ($flag == 'Y') {
			
			$columnLeft = 6-$x;
			
				for ($t = 0; $t <= $columnLeft; $t++) {
				$view .= "<td></td>";
				}
			
			}
			
			$view .= "</tr>";
			
			if ($flag == 'Y') {break;}
			
			}
		
		$view  .= "</table>";
		
		$return = array(
		
		"id"		=> $this->data[0][id],
		"name"		=> $this->data[0][name],
		"category" 	=> $this->data[0][category],
		"published"	=> $this->data[0][published],
		"pages"		=> $this->data[0][pages],
		"type"		=> $this->data[0][type],
		"view"		=> $view
		
		);
		
		echo json_encode($return);
		
		}
	
	public function displayVideoContentType() {
	
	}
	
	public function displayMetadata($id,$idData) {
	
	$exploder   = explode("/",$id);
	$filename   = pathinfo($id, PATHINFO_FILENAME);
	$extension  = pathinfo($id, PATHINFO_EXTENSION);
	$realPath   = $exploder[4]."/".$exploder[5]."/".$exploder[6]."/".$exploder[7]."/".$filename.".".$extension;
	
	$view .= "<input class='admin-metadata-deleter-meta' type='hidden'>";
	
	$view .= "<table class='admin-administrator-content-metadata'>";
	
	$view .= "<thead>";
	
	$view .= "<tr><td colspan=2><span style='font-weight:bold'>Content Metadata</span></td><td class='admin-administrator-action'><img class='admin-administrator-itemDetailAdder' src='library/images/add.png'><img class='admin-administrator-itemDetailDeler' src='".$this->site."library/images/del.png'></td></tr>";
	
	$view .= "<tr><td colspan=3><hr></td></tr>";
	
	$view .= "</thead>";
	
	$view .= "<tbody>";
		
		if (empty($this->data)) {
				
		$view .= "<tr>";
		$view .= "<td><input type='checkbox'></td><td><input class='admin-hidden-metadata-idData' type='hidden' value='$idData'><input type='text'></td><td><input type='text'><input class='admin-hidden-metadata-realPath' type='hidden' value='$realPath'></td>";
		$view .= "</tr>";
		
		}
		else {
		
			foreach ($this->data as $key => $value) {
				
				$view .= "<tr>";
				$view .= "<td><input type='checkbox' value='$value[CAP_CON_MET_ID]'></td><td><input class='admin-hidden-metadata-idData' type='hidden' value='$value[FK_CAP_CON_ID]'><input type='text' value='$value[CAP_CON_MET_HEADER]'></td><td><input type='text' value='$value[CAP_CON_MET_CONTENT]'><input class='admin-hidden-metadata-realPath' type='hidden' value='$value[CAP_CON_MET_PATH]'></td>";
				$view .= "</tr>";
				
			}
		
		}
	
	$view .= "<tr><td colspan=3><hr></td></tr>";
			
	$view .= "</tbody>";
	
	$view .= "</table>";
	
	$view .= "<button class='admin-administrator-metadataSubmit'>Save</button><button class='admin-administrator-metadataCancel'>Cancel</button>";
	
	echo $view;
	
	}
	
	public function select() {
	
		$view .= "<td class='optionLeft'><select>";
					
		if (is_array($value2[value])) {
						
			foreach ($value2[value] as $key3 => $value3) {
							
			$view .= "<option value='$value3'>" . ucwords(strtolower($value3)) . "</option>";
							
			}
						
		}
					
		$view .= "</select></td>";
	
	}
	
	public function displayLanguageList($id) {
		
		if (empty($id)) {$lang = admin::defaultLanguage();} else {$lang = $id;}
				
		$view .= "<select>";

		if (is_array($this->data)) {
			
			foreach ($this->data as $key => $value) {
				
				if ($lang == $value[CAP_LAN_ID]) {
				$view .= "<option selected='selected' value='" . $value[CAP_LAN_ID] . "'>" . ucwords(strtolower($value[CAP_LAN_NAME])) . "</option>";
				}
				else {
				$view .= "<option value='" . $value[CAP_LAN_ID] . "'>" . ucwords(strtolower($value[CAP_LAN_NAME])) . "</option>";
				}
				
											
			}
						
		}
					
		$view .= "</select>";
		
		echo $view;
	
	}
	
	public function getSitesView($sitesAll,$currentDomain,$identity,$withSelectHeader = null){
		
		$sites .= "<select class='administrator-select administrator-select-global-site-$identity' >";
		
		
		if(!empty($withSelectHeader)):
		$sites .= "<option rel='' value=''>Select Sites</option>";
		endif;

		foreach ($sitesAll as $user => $role):
			
			if ($role['domain']==$currentDomain):

				$sites .= "<option rel='".$role['domain']."' selected='selected' value='".$role['domain']."'>&nbsp".ucwords($role['domain'])."</option>";
			else:

				$sites .= "<option rel='".$role['domain']."' value='".$role['domain']."'>&nbsp".ucwords($role['domain'])."</option>";

			endif;
			
			if(isset($role['subdomain'])):
			
				foreach($role['subdomain'] as $keys => $values):
					
					$buildDomain = $values.".".$role['domain'];
				
					if ($buildDomain==$currentDomain):
		
						$sites .= "<option rel='".$values."' selected='selected' value='$buildDomain'> -- ".ucwords($buildDomain)."</option>";
		
					else:
		
						$sites .= "<option rel='".$values."' value='$buildDomain'> -- ".ucwords($buildDomain)."</option>";
		
					endif;	
								
				endforeach;
				
			endif;
		
		endforeach;
										
	$sites .= "</select>";
	
	return $sites;
	}
	
	public function getJumpPage($total,$current,$param=null){
		$jumpPage .= "<div style='margin: 5px;height: 20px;float: left;'>Jump To :</div>";
		$jumpPage .= '<select rel="'.$param.'" class="administrator-select administrator-jumpToPage">';
		for($i=1;$i<=$total;$i++){
			
			if($i == $current){
				$jumpPage .= '<option value="'.$i.'" selected="selected">'.$i.'</option>';
			}else{
				$jumpPage .= '<option value="'.$i.'">'.$i.'</option>';
			}
			
		}
		$jumpPage .= '</select>';
		
		return $jumpPage;
	}

}

?>