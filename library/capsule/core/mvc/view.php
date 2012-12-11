<?php

namespace library\capsule\core\mvc;

use \framework\encryption;
use \framework\time;
use \framework\database\oracle\select;
use \framework\user;
class view extends model {
protected $app = APP;
protected $params,$data;
public $type;
public $model = array("content" => "Content", "image" => "Image", "file" => "File", "audio" => "Audio", "video" => "Video");

    public function __construct($params,$data = null,$type = null,$error = null) {
    
    parent::__construct("","");
    
    	if (isset($_SESSION['admin']) || !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    	$this->optionGear = "<span class='" . $this->params . "-optionGear'><img class='optionGear' src='".APP."library/capsule/admin/image/settingCap.png'></span>";
   	 	}
    
    	if ($data != null) {$this->data = $data;} if ($type != null) {$this->type = $type;}
    
    $this->params = $params; if ($this->params == '{view}') {self::normal();} else {self::$params();}
    
    }
    
    public function normal(){
    
    $view  .= $this->optionGear;
    
    $view  .= "Please Select a View";  
    
    echo $view;
    
	}
	
	public function icon_admin() {
										
		$view  = $this->optionGear;
		
		$name  = $this->getUserName();
		
		$user  = unserialize($_SESSION['user']); $id = $user->getID();
		
		$role = $this->getRole();
		    	
    	$rol= $role[$_SESSION['role']];
    	
    	$caption= strtolower(str_replace(array('-',' '), '-', $result["CAP_MEN_NAME"]));
    	
    	$rol= ($rol == 'guest') ? 'public' : $rol;
		
		$view .= "<div class='layan-icon-container' data-folder='".trim($this->app,'/')."'>";
		
		$view .= "<a href='".APP.$rol.'/'."2185"."/Dashboard'><div class='core-icon-float-left-new-home' text='Home'>Dashboard</div></a>";
		
		$view .= "<a href='".APP.$rol.'/'."3860"."/Profil' ><div class='core-icon-float-left-new-dado' text='Buka Si Dado'>Profil</div></a>";
		
		//$view .= "<a href='3840' ><div class='core-icon-float-left-new-dado' text='Buka Si Dado'>Menu</div></a>";
		
		//$view .= "<a href='index.php?id=2186' ><div class='core-icon-float-left-new-dado' text='Buka Si Dado'>Library</div></a>";
		
		$view .= "<a href='".APP.$rol.'/'."2188"."/Document' ><div class='core-icon-float-left-new-document' text='Buka Si Dado'>Document</div></a>";
		
		$view .= "<a href='".APP.$rol.'/'."2189"."/History' ><div class='core-icon-float-left-new-history' text='Buka Si Dado'>History</div></a>";

		$view .= "<a href='".APP.$rol.'/'."2244"."/Settings'><div class='core-icon-float-left-new-setting' text='Settings'>Settings</div></a>";
		
		$view .= "</div>";
		
		$view .= "<span class='user-name-normal' login='yes'  SSID='".$user->getID()."'><a href='index.php?id=logout'><div class='layan-logout-container-core'>";
		
		$view .= "Logout";
				
		$view .= "</div></a>";
		
		$view .= "<div class='layan-icon_admin-name-container-core'>";
		
		$view .= ucwords(strtolower($name));
				
		$view .= "</div>";
					
		echo $view;
		
	}
	
	public function icon_user() {
										
		$view  = $this->optionGear;
		
		$name  = $this->getUserName();
		
		$user  = unserialize($_SESSION['user']); $id = $user->getID();
		
		$role = $this->getRole();
		
    	$rol= $role[$_SESSION['role']];
    	
    	$caption= strtolower(str_replace(array('-',' '), '-', $result["CAP_MEN_NAME"]));
    	
    	$rol= ($rol == 'guest') ? 'public' : $rol;
		
		$view .= "<div class='layan-icon-container' data-folder='".trim($this->app,'/')."'>";
		
		$view .= "<a href='".APP.$rol.'/'."2226".'/'.$caption."'><div class='core-icon-float-left-new-home' text='Home'>Dashboard</div></a>";
		$view .= "<a href='".APP.$rol.'/'."4200".'/'.$caption."' ><div class='core-icon-float-left-new-dado' text='Buka Si Dado'>Profil</div></a>";
		//$view .= "<a href='index.php?id=2344' ><div class='core-icon-float-left-new-dado' text='Buka Si Dado'>Library</div></a>";
		$view .= "<a href='".APP.$rol.'/'."2227".'/'.$caption."' ><div class='core-icon-float-left-new-document' text='Buka Si Dado'>Document</div></a>";
		$view .= "<a href='".APP.$rol.'/'."2264".'/'.$caption."' ><div class='core-icon-float-left-new-history' text='Buka Si Dado'>History</div></a>";
		
		
		$view .= "</div>";
		
		$view .= "<span class='user-name-normal' login='yes'  SSID='".$user->getID()."'><a href='index.php?id=logout'><div class='layan-logout-container-core'>";
		
		$view .= "Logout";
				
		$view .= "</div></a>";
		
		$view .= "<div class='layan-icon_admin-name-container-core'>";
		
		$view .= ucwords(strtolower($name));
				
		$view .= "</div>";
					
		echo $view;
		
	}
	
	public function icon_personal_sites() {
										
		$view  = $this->optionGear;
		
		$name  = $this->getUserName();
		
		$user  = unserialize($_SESSION['user']); $id = $user->getID();
		
		$role = $this->getRole();
		
    	$rol= $role[$_SESSION['role']];
    	
    	$caption= strtolower(str_replace(array('-',' '), '-', $result["CAP_MEN_NAME"]));
    	
    	$rol= ($rol == 'guest') ? 'public' : $rol;
		
		$view .= "<div class='layan-icon-container' data-folder='".trim($this->app,'/')."'>";
		
		$view .= "<a href='".APP.$rol.'/'."4320"."/Dashboard'><div class='core-icon-float-left-new-home' text='Home'>Dashboard</div></a>";
		$view .= "<a href='".APP.$rol.'/'."4321".'/'.$caption."' ><div class='core-icon-float-left-new-dado' text='Buka Si Dado'>Profil</div></a>";
		//$view .= "<a href='index.php?id=2344' ><div class='core-icon-float-left-new-dado' text='Buka Si Dado'>Library</div></a>";
		$view .= "<a href='".APP.$rol.'/'."4322"."/Document' ' ><div class='core-icon-float-left-new-document' text='Buka Si Dado'>Document</div></a>";
		$view .= "<a href='".APP.$rol.'/'."4323".'/'.$caption."' ><div class='core-icon-float-left-new-history' text='Buka Si Dado'>History</div></a>";
		
		
		$view .= "</div>";
		
		$view .= "<span class='user-name-normal' login='yes'  SSID='".$user->getID()."'><a href='index.php?id=logout'><div class='layan-logout-container-core'>";
		
		$view .= "Logout";
				
		$view .= "</div></a>";
		
		$view .= "<div class='layan-icon_admin-name-container-core'>";
		
		$view .= ucwords(strtolower($name));
				
		$view .= "</div>";
					
		echo $view;
		
	}
	
	public function sub_menu_content_global(){
	
		$menu  = $this->optionGear;
		
		$name  = $this->getUserName();
		
		$user  = unserialize($_SESSION['user']); $id = $user->getID();
		
		$role = $this->getRole();
		
    	$rol= $role[$_SESSION['role']];
    	    	
    	$rol= ($rol == 'guest') ? 'public' : $rol;
    	
		$menu  .= '<ul class="nav">';
		$menu  .= '	<li>';
		$menu  .= '		<a href="'.APP.$rol.'/'.'2191'.'/Teks">Teks</b></a>';
		$menu  .= '	</li>';
		$menu  .= '	<li>';
		$menu  .= '		<a href="'.APP.$rol.'/'.'2192'.'/File">File</a>';
		$menu  .= '	</li>';
		$menu  .= '	<li>';
		$menu  .= '		<a href="'.APP.$rol.'/'.'2193'.'/Image" >Image</a>';
		$menu  .= '	</li>';
		$menu  .= '	<li>';
		$menu  .= '		<a href="'.APP.$rol.'/'.'2194'.'/Video" >Video</a>';
		$menu  .= '	</li>';
		$menu  .= '	<li>';
		$menu  .= '		<a href="'.APP.$rol.'/'.'2195'.'/Audio" >Audio</a>';
		$menu  .= '	</li>';
		$menu  .= '</ul>';
		
		echo $menu;
	}
	
	public function sub_menu_content_sites_administrator(){
	
		$menu  = $this->optionGear;
		
		$name  = $this->getUserName();
		
		$user  = unserialize($_SESSION['user']); $id = $user->getID();
		
		$role = $this->getRole();
		
    	$rol= $role[$_SESSION['role']];
    	    	
    	$rol= ($rol == 'guest') ? 'public' : $rol;
    	
		$menu  .= '<ul class="nav">';
		$menu  .= '	<li>';
		$menu  .= '		<a href="'.APP.$rol.'/'.'1903'.'/Teks">Teks</b></a>';
		$menu  .= '	</li>';
		$menu  .= '	<li>';
		$menu  .= '		<a href="'.APP.$rol.'/'.'1904'.'/File">File</a>';
		$menu  .= '	</li>';
		$menu  .= '	<li>';
		$menu  .= '		<a href="'.APP.$rol.'/'.'1906'.'/Image" >Image</a>';
		$menu  .= '	</li>';
		$menu  .= '	<li>';
		$menu  .= '		<a href="'.APP.$rol.'/'.'1908'.'/Video" >Video</a>';
		$menu  .= '	</li>';
		$menu  .= '	<li>';
		$menu  .= '		<a href="'.APP.$rol.'/'.'1907'.'/Audio" >Audio</a>';
		$menu  .= '	</li>';
		$menu  .= '</ul>';
		
		echo $menu;
	}
	
	public function sub_menu_content_personal_sites(){
	
		$menu  = $this->optionGear;
		
		$name  = $this->getUserName();
		
		$user  = unserialize($_SESSION['user']); $id = $user->getID();
		
		$role = $this->getRole();
		
    	$rol= $role[$_SESSION['role']];
    	    	
    	$rol= ($rol == 'guest') ? 'public' : $rol;
    	
		$menu  .= '<ul class="nav">';
		$menu  .= '	<li>';
		$menu  .= '		<a href="'.APP.$rol.'/'.'4324'.'/Teks">Teks</b></a>';
		$menu  .= '	</li>';
		$menu  .= '	<li>';
		$menu  .= '		<a href="'.APP.$rol.'/'.'4325'.'/File">File</a>';
		$menu  .= '	</li>';
		$menu  .= '	<li>';
		$menu  .= '		<a href="'.APP.$rol.'/'.'4326'.'/Image" >Image</a>';
		$menu  .= '	</li>';
		$menu  .= '	<li>';
		$menu  .= '		<a href="'.APP.$rol.'/'.'4327'.'/Video" >Video</a>';
		$menu  .= '	</li>';
		$menu  .= '	<li>';
		$menu  .= '		<a href="'.APP.$rol.'/'.'4328'.'/Audio" >Audio</a>';
		$menu  .= '	</li>';
		$menu  .= '</ul>';
		
		echo $menu;
	}

	
	public function contentPersonal(){
		 $perPageSet = 20;
    $contentList = $this->getContentListContentPersonalSites(1,$perPageSet);

    $contentCat  = $this->getContentCategoryList();
    $count = count($contentList);
    $dataPages 	 = $this->getPagesList();
    
    $view  .= $this->optionGear;
    $view .= "<div class='core-image-container'>";
    $view .= '<div class="dado-core-file-container">
					<div class="dado-core-file-header" style="position:relative">
						
						<div class="dado-id-float-left">
						<div class="core-container-contentInsideActionButton"><button class="core-button-setCompletedContentPersonal"></button></div>
					</div>
					
						';
			 		if ($count > 49){	
	$view .='<div class="dado-id-float-right">
						
							<input type="hidden" class="pageAtThisTime" value="1"><input type="hidden" class="totalPage" value="'.ceil($count[0][COUNT]/$perPageSet).'">
							<div class="core-container-contentInsideActionButton" style="float:left;"><button class="coreUser-button-prev qtip-upper" text="Halaman Sebelumnya"></button></div>
							<div class="core-container-contentInsideActionButton" style="float:left;"><button class="coreUser-button-next qtip-upper" text="Halaman Selanjutnya"></button></div>
						</div>';}
	$view .= '
					</div>
					<div class="dado-core-file-body" >';
     $view .= "<div class='core-image-container'>"; 
    
    	//$view .= "<div class='core-image-container-inside'><span class='core-headerOfContent'></span><input type='hidden' class='core-headerOfContentInput' value=''><input type='hidden' class='core-headerOfContentInputTypeOfFile' value='content'></div>"; 
    	
        $view .= "<div class='core-container-contentInside'></div>";
        
        
        $view .= "<div class='core-image-container-content'>";
        
        $view .= "<table class='core-image-table table table-hover table-stripped'>";
        
        $view .= "<thead>";
        
        	$view .= "<tr>";
        		
        		$view .= "<td class='core-align-center'>Aksi</td>";
        		
        		$view .= "<td class='core-align-left'>Nama</td>";
        		
        		$view .= "<td class='core-align-center'>Category</td>";
        		
        		$view .= "<td class='core-align-center'>Halaman</td>";
        		
        		$view .= "<td class='core-align-center'>Publisher</td>";
        		        	
        	$view .= "</tr>";
        
        $view .= "</thead>";
        
        $view .= "<tbody>";
        
        if (!empty($contentList)) {
        
        	foreach ($contentList as $key => $value) {
        	        	
        		$view .= "<tr>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall'><input type='hidden' name='contentID' value='$value[CAP_CON_ID]'><span class='core-image-actionDelete'></span><span class='core-image-actionNextContentPersonal'></span></td>";
        			
        			$view .= "<td class='core-image-container-tableContentHuge'>$value[CAP_CON_HEADER]</td>";
        			
        			$view .= "<td class='core-align-center'><select>";
			
						foreach ($contentCat as $category) {
				
							if ($value['CAP_CON_CAT_ID'] == $category['CAP_CON_CAT_ID']) {
					
							$view .= "<option selected='selected' value='$category[CAP_CON_CAT_ID]'>" . ucwords(strtolower($category['CAP_CON_CAT_NAME'])) . "</option>";
					
							}
							else {
					
							$view .= "<option value='$category[CAP_CON_CAT_ID]'>" . ucwords(strtolower($category['CAP_CON_CAT_NAME'])) . "</option>";
					
							}
								
						}
			
					$view .= "</td></select>";
        			
        			$view .= "<td class='core-align-center'><select>";
	
					$view .= "<option selected='selected' value=''>Select Pages</option>";
	
						foreach ($dataPages as $pages) {
								$template = explode("/",$pages['CAP_PAG_PATH']);
								
								
									if ($value['CAP_PAG_ID']  == $pages['CAP_PAG_ID']) {
				
									$view .= "<option selected='selected' value='$pages[CAP_PAG_ID]'> ".$template[3]." - ".$pages[CAP_PAG_NAME]."</option>";
									
									}
									else {
									
									$view .= "<option value='$pages[CAP_PAG_ID]'>".$template[3]." - ".$pages[CAP_PAG_NAME]."</option>";
									
									}
								
						}
	
				$view .= "</select><input type='hidden' name='contentType' value='content'></td>";
				
				$view .= "<td class='core-image-container-tableContentSmall'>$value[CAP_USE_FIRSTNAME]<input type='hidden' name='FKID' value='".$value['CAP_LAN_COM_ID']."'></td>";
        		        		
        		$view .= "</tr>";

        	}
        	
        }
       
        $view .= "</tbody>";
        
        
        
        $view .= "</table>";
        
        $view .= "<input type='submit' class='core-profil-submit' value='Update'>";
        
        $view .= "</div></div></div></div>";
        
    echo $view;
    
	}

	
	public function imagePersonal(){
       
    $this->params = "image";
	
    $contentList = $this->getContentListImagePersonalSites();
    $contentListTotal = $this->getContentListImageUserTotal();
    //print_r($contentList);
    
    $contentCat  = $this->getContentCategoryList();
    $count = count($contentList);
    $dataPages 	 = $this->getPagesList();
    $view  .= $this->optionGear;
    $view .= "<div class='core-image-container'>";
     $view .= '<div class="dado-core-file-container">
					<div class="dado-core-file-header" style="position:relative">
						<div class="dado-id-float-left">
						<div class="core-container-contentInsideActionButton"><button class="core-button-setCompletedPersonal"></button></div>
						</div>';
			 		if ($count > 200){	
	$view .='<div class="dado-id-float-right">
						
							<input type="hidden" class="pageAtThisTime" value="0">
							<div class="core-container-contentInsideActionButton" style="float:left;"><button class="coreUser-button-prev qtip-upper" text="Halaman Sebelumnya""></button></div>
							<div class="core-container-contentInsideActionButton" style="float:left;"><button class="coreUser-button-next qtip-upper" text="Halaman Selanjutnya"></button></div>
						</div>';}
	$view .= '
					</div>
					<div class="dado-core-file-body" >';
     $view .= "<div class='core-".$this->params."-container'>"; 
    
    	$view .= "<div class='core-".$this->params."-container-inside'><span class='pagesOfView'>Image Manager </span><span class='core-headerOfContent'></span><input type='hidden' class='core-headerOfContentInput' value=''><input type='hidden' class='core-headerOfContentInputTypeOfFile' value='image'></div>"; 
    	
        $view .= "<div class='core-container-contentInside'></div>";
        
       
        
        $view .= "<div class='core-".$this->params."-container-content'>";
        
        $view .= "<table class='core-".$this->params."-table table table-hover table-stripped'>";
        
        $view .= "<thead>";
        
        	$view .= "<tr>";
        		
        		$view .= "<td class='core-align-center'>Aksi</td>";
        		
        		$view .= "<td class='core-align-left'>Nama</td>";
        		
        		$view .= "<td class='core-align-left'>Publisher</td>";
        		
        		$view .= "<td class='core-align-left'>Sites</td>";
        		        	
        	$view .= "</tr>";
        
        $view .= "</thead>";
        
        $view .= "<tbody>";
        
        if (!empty($contentList)) {
        
        	foreach ($contentList as $key => $value) {
        	
        	$domainName = $this->getDomainName($value[CAP_MAI_ID]);
        	
        		$view .= "<tr>";
        			
        			$view .= "<td class='core-".$this->params."-container-tableContentSmall'><input type='hidden' name='contentID' value='$value[CAP_CON_ID]'><span class='core-".$this->params."-actionDelete'></span><span class='core-".$this->params."-actionNextUser'></span></td>";
        			
        			$view .= "<td class='core-".$this->params."-container-tableContentHuge'>$value[CAP_CON_HEADER]</td>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall'>$value[CAP_USE_FIRSTNAME]</td>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall' data-domain=$domainName>$domainName</td>"; 
        		        		
        		$view .= "</tr>";
        	
        	}
        
        }
        
        $view .= "</tbody>";
        
                
        $view .= "</table>";
        
        $view .= "<input type='submit' class='core-profil-submit' value='Update'>";
        
        $view .= "</div></div></div></div>";
        
    echo $view;
    
	}
	
	public function filePersonal(){
        
    $contentList = $this->getContentListFilePersonalSites();
    $count = count($contentList);
    $contentCat  = $this->getContentCategoryList();
    
    $view  .= $this->optionGear;
    
     $view .= "<div class='core-image-container'>";
     $view .= '<div class="dado-core-file-container">
					<div class="dado-core-file-header" style="position:relative">
						<div class="dado-id-float-left">
						<div class="core-container-contentInsideActionButton"><button class="core-button-setCompletedPersonal qtip-upper" text="Tambah Folder Baru"></button></div>
					</div>
					
						';
			 		if ($count > 200){	
	$view .='<div class="dado-id-float-right">
						
							<input type="hidden" class="pageAtThisTime" value="0">
							<div class="core-container-contentInsideActionButton" style="float:left;"><button class="coreUser-button-prev qtip-upper" text="Halaman Sebelumnya"></button></div>
							<div class="core-container-contentInsideActionButton" style="float:left;"><button class="coreUser-button-next qtip-upper" text="Halaman Selanjutnya""></button></div>
						</div>';}
	$view .= '
					</div>
					<div class="dado-core-file-body" >'; 
    
    	$view .= "<div class='core-image-container-inside'>File Manager <span class='core-headerOfContent'></span><input type='hidden' class='core-headerOfContentInput' value=''><input type='hidden' class='core-headerOfContentInputTypeOfFile' value='file'></div>"; 
    	
        $view .= "<div class='core-container-contentInside'></div>";
        
              
        $view .= "<div class='core-image-container-content'>";
        
        $view .= "<table class='core-image-table table table-hover table-stripped table table-hover table-stripped'>";
        
        $view .= "<thead>";
        
        	$view .= "<tr>";
        		
        		$view .= "<td class='core-align-center'>Aksi</td>";
        		
        		$view .= "<td class='core-align-left'>Nama</td>";
        		
        		$view .= "<td class='core-align-left'>Publisher</td>";
        		
        		$view .= "<td class='core-align-left'>Sites</td>";
        		        	
        	$view .= "</tr>";
        
        $view .= "</thead>";
        
        $view .= "<tbody>";
        
        if (!empty($contentList)) {
        
        	foreach ($contentList as $key => $value) {
        	
        	$domainName = $this->getDomainName($value[CAP_MAI_ID]);
        	        	
        		$view .= "<tr>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall'><input type='hidden' name='contentID' value='$value[CAP_CON_ID]'><span class='core-image-actionDelete qtip-upper' text='Hapus Folder'></span><span class='core-image-actionNextUser qtip-upper' text='Masuk Kedalam Folder'></span></td>";
        			
        			$view .= "<td class='core-image-container-tableContentHuge'>$value[CAP_CON_HEADER]</td>";
        			   			
        			$view .= "<td class='core-image-container-tableContentSmall'>$value[CAP_USE_FIRSTNAME]</td>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall' data-domain=$domainName>$domainName</td>";        				        			
        		        		
        		$view .= "</tr>";

        	}
        	
        }
       
        $view .= "</tbody>";
        
       
        
        $view .= "</table>";
        
        $view .= "<input type='submit' class='core-profil-submit' value='Update'>";
        
        $view .= "</div></div></div>
				</div>";
        
    echo $view;
    
	}
	
	public function audioPersonal(){
        
    $contentList = $this->getContentListAudioPersonalSites();
    $count = count($contentList);
    $contentCat  = $this->getContentCategoryList();
    
    $dataPages 	 = $this->getPagesList();
    
    $view  .= $this->optionGear;
    $view .= "<div class='core-image-container'>";
     $view .= '<div class="dado-core-file-container">
					<div class="dado-core-file-header" style="position:relative">
						<div class="dado-id-float-left">
						<div class="core-container-contentInsideActionButton"><button class="core-button-setCompletedPersonal"></button></div>
					</div>
						';
			 		if ($count > 200){	
	$view .='<div class="dado-id-float-right">
						
							<input type="hidden" class="pageAtThisTime" value="0">
							<div class="core-container-contentInsideActionButton" style="float:left;"><button class="coreUser-button-prev qtip-upper" text="Halaman Sebelumnya"></button></div>
							<div class="core-container-contentInsideActionButton" style="float:left;"><button class="coreUser-button-next qtip-upper" text="Halaman Selanjutnya"></button></div>
						</div>';}
	$view .= '
					</div>
					<div class="dado-core-file-body" >';
     $view .= "<div class='core-image-container'>"; 
    
    	$view .= "<div class='core-image-container-inside'>Audio Manager <span class='core-headerOfContent'></span><input type='hidden' class='core-headerOfContentInput' value=''><input type='hidden' class='core-headerOfContentInputTypeOfFile' value='audio'></div>"; 
    	
        $view .= "<div class='core-container-contentInside'></div>";
        
      
        
        $view .= "<div class='core-image-container-content'>";
        
        $view .= "<table class='core-image-table table table-hover table-stripped'>";
        
        $view .= "<thead>";
        
        	$view .= "<tr>";
        		
        		$view .= "<td class='core-align-center'>Aksi</td>";
        		
        		$view .= "<td class='core-align-left'>Nama</td>";
        		
        		$view .= "<td class='core-align-left'>Publisher</td>";
        		
        		$view .= "<td class='core-align-left'>Sites</td>";
        		
        		        	
        	$view .= "</tr>";
        
        $view .= "</thead>";
        
        $view .= "<tbody>";
        
        if (!empty($contentList)) {
        
        	foreach ($contentList as $key => $value) {
        	
        	$domainName = $this->getDomainName($value[CAP_MAI_ID]);
        	        	
        		$view .= "<tr>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall'><input type='hidden' name='contentID' value='$value[CAP_CON_ID]'><span class='core-image-actionDelete'></span><span class='core-image-actionNextUser'></span></td>";
        			
        			$view .= "<td class='core-image-container-tableContentHuge'>$value[CAP_CON_HEADER]</td>";
        			        			
        			$view .= "<td class='core-image-container-tableContentSmall'>$value[CAP_USE_FIRSTNAME]</td>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall' data-domain=$domainName>$domainName</td>";
        			
				$view .= "</td>";
        		        		
        		$view .= "</tr>";

        	}
        	
        }
       
        $view .= "</tbody>";
        
     
        
        $view .= "</table>";
        
        $view .= "<input type='submit' class='core-profil-submit' value='Update'>";
        
        $view .= "</div></div></div></div>";
        
    echo $view;
    
	}
	
	public function moviePersonal(){
        
    $contentList = $this->getContentListVideoPersonalSites();
    $count = count($contentList);
    $contentCat  = $this->getContentCategoryList();
    
    $dataPages 	 = $this->getPagesList();
    
    $view  .= $this->optionGear;
    $view .= "<div class='core-image-container'>";
     $view .= '<div class="dado-core-file-container">
					<div class="dado-core-file-header" style="position:relative">
						<div class="dado-id-float-left">
						<div class="core-container-contentInsideActionButton"><button class="core-button-setCompletedPersonal"></button></div>
					</div>
						';
			 		if ($count > 200){	
	$view .='<div class="dado-id-float-right">
						
							<input type="hidden" class="pageAtThisTime" value="0">
							<div class="core-container-contentInsideActionButton" style="float:left;"><button class="coreUser-button-prev qtip-upper" text="Halaman Sebelumnya"></button></div>
							<div class="core-container-contentInsideActionButton" style="float:left;"><button class="coreUser-button-next qtip-upper" text="Halaman Selanjutnya"></button></div>
						</div>';}
	$view .= '
					</div>
					<div class="dado-core-file-body" >';
     $view .= "<div class='core-image-container'>"; 
    
    	$view .= "<div class='core-image-container-inside'>Video Manager <span class='core-headerOfContent'></span><input type='hidden' class='core-headerOfContentInput' value=''><input type='hidden' class='core-headerOfContentInputTypeOfFile' value='video'></div>"; 
    	
        $view .= "<div class='core-container-contentInside'></div>";
        
              
        $view .= "<div class='core-image-container-content'>";
        
        $view .= "<table class='core-image-table table table-hover table-stripped'>";
        
        $view .= "<thead>";
        
        	$view .= "<tr>";
        		
        		$view .= "<td class='core-align-center'>Aksi</td>";
        		
        		$view .= "<td class='core-align-left'>Nama</td>";
        		
        		$view .= "<td class='core-align-left'>Publisher</td>";
        		
        		$view .= "<td class='core-align-left'>Sites</td>";
        		        	
        	$view .= "</tr>";
        
        $view .= "</thead>";
        
        $view .= "<tbody>";
        
        if (!empty($contentList)) {
        
        	foreach ($contentList as $key => $value) {
        	
        	$domainName = $this->getDomainName($value[CAP_MAI_ID]);
        	        	
        		$view .= "<tr>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall'><input type='hidden' name='contentID' value='$value[CAP_CON_ID]'><span class='core-image-actionDelete'></span><span class='core-image-actionNextUser'></span></td>";
        			
        			$view .= "<td class='core-image-container-tableContentHuge'>$value[CAP_CON_HEADER]</td>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall'>$value[CAP_USE_FIRSTNAME]</td>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall' data-domain=$domainName>$domainName</td>";        			
        		        		
        		$view .= "</tr>";

        	}
        	
        }
       
        $view .= "</tbody>";
        
              
        $view .= "</table>";
        
        $view .= "<input type='submit' class='core-profil-submit' value='Update'>";
        
        $view .= "</div></div></div></div>";
        
    echo $view;
    
	}
			
	public function contentUser(){
		 $perPageSet = 20;
    $contentList = $this->getContentListContentUser(1,$perPageSet);

    $contentCat  = $this->getContentCategoryList();
    $count = count($contentList);
    $dataPages 	 = $this->getPagesList();
    
    $view  .= $this->optionGear;
    $view .= "<div class='core-image-container'>";
    $view .= '<div class="dado-core-file-container">
					<div class="dado-core-file-header" style="position:relative">
						
						<div class="dado-id-float-left">
						<div class="core-container-contentInsideActionButton"><button class="core-button-setCompletedContent"></button></div>
					</div>
					
						';
			 		if ($count > 49){	
	$view .='<div class="dado-id-float-right">
						
							<input type="hidden" class="pageAtThisTime" value="1"><input type="hidden" class="totalPage" value="'.ceil($count[0][COUNT]/$perPageSet).'">
							<div class="core-container-contentInsideActionButton" style="float:left;"><button class="coreUser-button-prev qtip-upper" text="Halaman Sebelumnya"></button></div>
							<div class="core-container-contentInsideActionButton" style="float:left;"><button class="coreUser-button-next qtip-upper" text="Halaman Selanjutnya"></button></div>
						</div>';}
	$view .= '
					</div>
					<div class="dado-core-file-body" >';
     $view .= "<div class='core-image-container'>"; 
    
    	//$view .= "<div class='core-image-container-inside'><span class='core-headerOfContent'></span><input type='hidden' class='core-headerOfContentInput' value=''><input type='hidden' class='core-headerOfContentInputTypeOfFile' value='content'></div>"; 
    	
        $view .= "<div class='core-container-contentInside'></div>";
        
        
        $view .= "<div class='core-image-container-content'>";
        
        $view .= "<table class='core-image-table table table-hover table-stripped'>";
        
        $view .= "<thead>";
        
        	$view .= "<tr>";
        		
        		$view .= "<td class='core-align-center'>Aksi</td>";
        		
        		$view .= "<td class='core-align-left'>Nama</td>";
        		
        		$view .= "<td class='core-align-center'>Category</td>";
        		
        		$view .= "<td class='core-align-center'>Halaman</td>";
        		
        		$view .= "<td class='core-align-center'>Publisher</td>";
        		        	
        	$view .= "</tr>";
        
        $view .= "</thead>";
        
        $view .= "<tbody>";
        
        if (!empty($contentList)) {
        
        	foreach ($contentList as $key => $value) {
        	        	
        		$view .= "<tr>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall'><input type='hidden' name='contentID' value='$value[CAP_CON_ID]'><span class='core-image-actionDelete'></span><span class='core-image-actionNextContent'></span></td>";
        			
        			$view .= "<td class='core-image-container-tableContentHuge'>$value[CAP_CON_HEADER]</td>";
        			
        			$view .= "<td class='core-align-center'><select>";
			
						foreach ($contentCat as $category) {
				
							if ($value['CAP_CON_CAT_ID'] == $category['CAP_CON_CAT_ID']) {
					
							$view .= "<option selected='selected' value='$category[CAP_CON_CAT_ID]'>" . ucwords(strtolower($category['CAP_CON_CAT_NAME'])) . "</option>";
					
							}
							else {
					
							$view .= "<option value='$category[CAP_CON_CAT_ID]'>" . ucwords(strtolower($category['CAP_CON_CAT_NAME'])) . "</option>";
					
							}
								
						}
			
					$view .= "</td></select>";
        			
        			$view .= "<td class='core-align-center'><select>";
	
					$view .= "<option selected='selected' value=''>Select Pages</option>";
	
						foreach ($dataPages as $pages) {
								$template = explode("/",$pages['CAP_PAG_PATH']);
								
								
									if ($value['CAP_PAG_ID']  == $pages['CAP_PAG_ID']) {
				
									$view .= "<option selected='selected' value='$pages[CAP_PAG_ID]'> ".$template[3]." - ".$pages[CAP_PAG_NAME]."</option>";
									
									}
									else {
									
									$view .= "<option value='$pages[CAP_PAG_ID]'>".$template[3]." - ".$pages[CAP_PAG_NAME]."</option>";
									
									}
								
						}
	
				$view .= "</select><input type='hidden' name='contentType' value='content'></td>";
				
				$view .= "<td class='core-image-container-tableContentSmall'>$value[CAP_USE_FIRSTNAME]<input type='hidden' name='FKID' value='".$value['CAP_LAN_COM_ID']."'></td>";
        		        		
        		$view .= "</tr>";

        	}
        	
        }
       
        $view .= "</tbody>";
        
        
        
        $view .= "</table>";
        
        $view .= "<input type='submit' class='core-profil-submit' value='Update'>";
        
        $view .= "</div></div></div></div>";
        
    echo $view;
    
	}

	
	public function imageUser(){
       
    $this->params = "image";
	
    $contentList = $this->getContentListImageUser();
    $contentListTotal = $this->getContentListImageUserTotal();
    //print_r($contentList);
    
    $contentCat  = $this->getContentCategoryList();
    $count = count($contentList);
    $dataPages 	 = $this->getPagesList();
    $view  .= $this->optionGear;
    $view .= "<div class='core-image-container'>";
     $view .= '<div class="dado-core-file-container">
					<div class="dado-core-file-header" style="position:relative">
						<div class="dado-id-float-left">
						<div class="core-container-contentInsideActionButton"><button class="core-button-setCompleted"></button></div>
						</div>';
			 		if ($count > 200){	
	$view .='<div class="dado-id-float-right">
						
							<input type="hidden" class="pageAtThisTime" value="0">
							<div class="core-container-contentInsideActionButton" style="float:left;"><button class="coreUser-button-prev qtip-upper" text="Halaman Sebelumnya""></button></div>
							<div class="core-container-contentInsideActionButton" style="float:left;"><button class="coreUser-button-next qtip-upper" text="Halaman Selanjutnya"></button></div>
						</div>';}
	$view .= '
					</div>
					<div class="dado-core-file-body" >';
     $view .= "<div class='core-".$this->params."-container'>"; 
    
    	$view .= "<div class='core-".$this->params."-container-inside'><span class='pagesOfView'>Image Manager </span><span class='core-headerOfContent'></span><input type='hidden' class='core-headerOfContentInput' value=''><input type='hidden' class='core-headerOfContentInputTypeOfFile' value='image'></div>"; 
    	
        $view .= "<div class='core-container-contentInside'></div>";
        
       
        
        $view .= "<div class='core-".$this->params."-container-content'>";
        
        $view .= "<table class='core-".$this->params."-table table table-hover table-stripped'>";
        
        $view .= "<thead>";
        
        	$view .= "<tr>";
        		
        		$view .= "<td class='core-align-center'>Aksi</td>";
        		
        		$view .= "<td class='core-align-left'>Nama</td>";
        		
        		$view .= "<td class='core-align-left'>Publisher</td>";
        		
        		$view .= "<td class='core-align-left'>Sites</td>";
        		        	
        	$view .= "</tr>";
        
        $view .= "</thead>";
        
        $view .= "<tbody>";
        
        if (!empty($contentList)) {
        
        	foreach ($contentList as $key => $value) {
        	
        	$domainName = $this->getDomainName($value[CAP_MAI_ID]);
        	
        		$view .= "<tr>";
        			
        			$view .= "<td class='core-".$this->params."-container-tableContentSmall'><input type='hidden' name='contentID' value='$value[CAP_CON_ID]'><span class='core-".$this->params."-actionDelete'></span><span class='core-".$this->params."-actionNextUser'></span></td>";
        			
        			$view .= "<td class='core-".$this->params."-container-tableContentHuge'>$value[CAP_CON_HEADER]</td>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall'>$value[CAP_USE_FIRSTNAME]</td>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall' data-domain=$domainName>$domainName</td>"; 
        		        		
        		$view .= "</tr>";
        	
        	}
        
        }
        
        $view .= "</tbody>";
        
                
        $view .= "</table>";
        
        $view .= "<input type='submit' class='core-profil-submit' value='Update'>";
        
        $view .= "</div></div></div></div>";
        
    echo $view;
    
	}
	
	public function fileUser(){
        
    $contentList = $this->getContentListFileUser();
    $count = count($contentList);
    $contentCat  = $this->getContentCategoryList();
    
    $view  .= $this->optionGear;
    
     $view .= "<div class='core-image-container'>";
     $view .= '<div class="dado-core-file-container">
					<div class="dado-core-file-header" style="position:relative">
						<div class="dado-id-float-left">
						<div class="core-container-contentInsideActionButton"><button class="core-button-setCompleted qtip-upper" text="Tambah Folder Baru"></button></div>
					</div>
					
						';
			 		if ($count > 200){	
	$view .='<div class="dado-id-float-right">
						
							<input type="hidden" class="pageAtThisTime" value="0">
							<div class="core-container-contentInsideActionButton" style="float:left;"><button class="coreUser-button-prev qtip-upper" text="Halaman Sebelumnya"></button></div>
							<div class="core-container-contentInsideActionButton" style="float:left;"><button class="coreUser-button-next qtip-upper" text="Halaman Selanjutnya""></button></div>
						</div>';}
	$view .= '
					</div>
					<div class="dado-core-file-body" >'; 
    
    	$view .= "<div class='core-image-container-inside'>File Manager <span class='core-headerOfContent'></span><input type='hidden' class='core-headerOfContentInput' value=''><input type='hidden' class='core-headerOfContentInputTypeOfFile' value='file'></div>"; 
    	
        $view .= "<div class='core-container-contentInside'></div>";
        
              
        $view .= "<div class='core-image-container-content'>";
        
        $view .= "<table class='core-image-table table table-hover table-stripped table table-hover table-stripped'>";
        
        $view .= "<thead>";
        
        	$view .= "<tr>";
        		
        		$view .= "<td class='core-align-center'>Aksi</td>";
        		
        		$view .= "<td class='core-align-left'>Nama</td>";
        		
        		$view .= "<td class='core-align-left'>Publisher</td>";
        		
        		$view .= "<td class='core-align-left'>Sites</td>";
        		        	
        	$view .= "</tr>";
        
        $view .= "</thead>";
        
        $view .= "<tbody>";
        
        if (!empty($contentList)) {
        
        	foreach ($contentList as $key => $value) {
        	
        	$domainName = $this->getDomainName($value[CAP_MAI_ID]);
        	        	
        		$view .= "<tr>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall'><input type='hidden' name='contentID' value='$value[CAP_CON_ID]'><span class='core-image-actionDelete qtip-upper' text='Hapus Folder'></span><span class='core-image-actionNextUser qtip-upper' text='Masuk Kedalam Folder'></span></td>";
        			
        			$view .= "<td class='core-image-container-tableContentHuge'>$value[CAP_CON_HEADER]</td>";
        			   			
        			$view .= "<td class='core-image-container-tableContentSmall'>$value[CAP_USE_FIRSTNAME]</td>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall' data-domain=$domainName>$domainName</td>";        				        			
        		        		
        		$view .= "</tr>";

        	}
        	
        }
       
        $view .= "</tbody>";
        
       
        
        $view .= "</table>";
        
        $view .= "<input type='submit' class='core-profil-submit' value='Update'>";
        
        $view .= "</div></div></div>
				</div>";
        
    echo $view;
    
	}
	
	public function audioUser(){
        
    $contentList = $this->getContentListAudioUser();
    $count = count($contentList);
    $contentCat  = $this->getContentCategoryList();
    
    $dataPages 	 = $this->getPagesList();
    
    $view  .= $this->optionGear;
    $view .= "<div class='core-image-container'>";
     $view .= '<div class="dado-core-file-container">
					<div class="dado-core-file-header" style="position:relative">
						<div class="dado-id-float-left">
						<div class="core-container-contentInsideActionButton"><button class="core-button-setCompleted"></button></div>
					</div>
						';
			 		if ($count > 200){	
	$view .='<div class="dado-id-float-right">
						
							<input type="hidden" class="pageAtThisTime" value="0">
							<div class="core-container-contentInsideActionButton" style="float:left;"><button class="coreUser-button-prev qtip-upper" text="Halaman Sebelumnya"></button></div>
							<div class="core-container-contentInsideActionButton" style="float:left;"><button class="coreUser-button-next qtip-upper" text="Halaman Selanjutnya"></button></div>
						</div>';}
	$view .= '
					</div>
					<div class="dado-core-file-body" >';
     $view .= "<div class='core-image-container'>"; 
    
    	$view .= "<div class='core-image-container-inside'>Audio Manager <span class='core-headerOfContent'></span><input type='hidden' class='core-headerOfContentInput' value=''><input type='hidden' class='core-headerOfContentInputTypeOfFile' value='audio'></div>"; 
    	
        $view .= "<div class='core-container-contentInside'></div>";
        
      
        
        $view .= "<div class='core-image-container-content'>";
        
        $view .= "<table class='core-image-table table table-hover table-stripped'>";
        
        $view .= "<thead>";
        
        	$view .= "<tr>";
        		
        		$view .= "<td class='core-align-center'>Aksi</td>";
        		
        		$view .= "<td class='core-align-left'>Nama</td>";
        		
        		$view .= "<td class='core-align-left'>Publisher</td>";
        		
        		$view .= "<td class='core-align-left'>Sites</td>";
        		
        		        	
        	$view .= "</tr>";
        
        $view .= "</thead>";
        
        $view .= "<tbody>";
        
        if (!empty($contentList)) {
        
        	foreach ($contentList as $key => $value) {
        	
        	$domainName = $this->getDomainName($value[CAP_MAI_ID]);
        	        	
        		$view .= "<tr>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall'><input type='hidden' name='contentID' value='$value[CAP_CON_ID]'><span class='core-image-actionDelete'></span><span class='core-image-actionNextUser'></span></td>";
        			
        			$view .= "<td class='core-image-container-tableContentHuge'>$value[CAP_CON_HEADER]</td>";
        			        			
        			$view .= "<td class='core-image-container-tableContentSmall'>$value[CAP_USE_FIRSTNAME]</td>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall' data-domain=$domainName>$domainName</td>";
        			
				$view .= "</td>";
        		        		
        		$view .= "</tr>";

        	}
        	
        }
       
        $view .= "</tbody>";
        
     
        
        $view .= "</table>";
        
        $view .= "<input type='submit' class='core-profil-submit' value='Update'>";
        
        $view .= "</div></div></div></div>";
        
    echo $view;
    
	}
	
	public function movieUser(){
        
    $contentList = $this->getContentListVideoUser();
    $count = count($contentList);
    $contentCat  = $this->getContentCategoryList();
    
    $dataPages 	 = $this->getPagesList();
    
    $view  .= $this->optionGear;
    $view .= "<div class='core-image-container'>";
     $view .= '<div class="dado-core-file-container">
					<div class="dado-core-file-header" style="position:relative">
						<div class="dado-id-float-left">
						<div class="core-container-contentInsideActionButton"><button class="core-button-setCompleted"></button></div>
					</div>
						';
			 		if ($count > 200){	
	$view .='<div class="dado-id-float-right">
						
							<input type="hidden" class="pageAtThisTime" value="0">
							<div class="core-container-contentInsideActionButton" style="float:left;"><button class="coreUser-button-prev qtip-upper" text="Halaman Sebelumnya"></button></div>
							<div class="core-container-contentInsideActionButton" style="float:left;"><button class="coreUser-button-next qtip-upper" text="Halaman Selanjutnya"></button></div>
						</div>';}
	$view .= '
					</div>
					<div class="dado-core-file-body" >';
     $view .= "<div class='core-image-container'>"; 
    
    	$view .= "<div class='core-image-container-inside'>Video Manager <span class='core-headerOfContent'></span><input type='hidden' class='core-headerOfContentInput' value=''><input type='hidden' class='core-headerOfContentInputTypeOfFile' value='video'></div>"; 
    	
        $view .= "<div class='core-container-contentInside'></div>";
        
              
        $view .= "<div class='core-image-container-content'>";
        
        $view .= "<table class='core-image-table table table-hover table-stripped'>";
        
        $view .= "<thead>";
        
        	$view .= "<tr>";
        		
        		$view .= "<td class='core-align-center'>Aksi</td>";
        		
        		$view .= "<td class='core-align-left'>Nama</td>";
        		
        		$view .= "<td class='core-align-left'>Publisher</td>";
        		
        		$view .= "<td class='core-align-left'>Sites</td>";
        		        	
        	$view .= "</tr>";
        
        $view .= "</thead>";
        
        $view .= "<tbody>";
        
        if (!empty($contentList)) {
        
        	foreach ($contentList as $key => $value) {
        	
        	$domainName = $this->getDomainName($value[CAP_MAI_ID]);
        	        	
        		$view .= "<tr>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall'><input type='hidden' name='contentID' value='$value[CAP_CON_ID]'><span class='core-image-actionDelete'></span><span class='core-image-actionNextUser'></span></td>";
        			
        			$view .= "<td class='core-image-container-tableContentHuge'>$value[CAP_CON_HEADER]</td>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall'>$value[CAP_USE_FIRSTNAME]</td>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall' data-domain=$domainName>$domainName</td>";        			
        		        		
        		$view .= "</tr>";

        	}
        	
        }
       
        $view .= "</tbody>";
        
              
        $view .= "</table>";
        
        $view .= "<input type='submit' class='core-profil-submit' value='Update'>";
        
        $view .= "</div></div></div></div>";
        
    echo $view;
    
	}
	public function profilAdmin(){
    
    $userRole  = $this->getRoleList();
    
    $user = unserialize($_SESSION['user']);
    
    $userID = $user->getID();
	
	$userData	= $this->getUserData($userID);
		
		$sitesAll  = $this->getSitesList(null,null);
		
		$template  = $this->getAllTemplate();
		
		$currentDomain = $_SERVER['SERVER_NAME'];	
		
		$view .= "<script>
			
		</script>";	

		$view  .= "<hr>";
				
		$view .= "<form class='form-horizontal' id='administrator-user-edit'>";
		
		
			$view .= "<div class='control-group'>";

				$view .= "<label class='control-label administrator-label' for='name'>Photo</label>";
				
				$view .= "<div class='controls administrator-controls controls-row'>";
				
				$view .= "<div class='core-image-handler span2' ><img src='".APP."framework/resize.class.php?src="."library/capsule/core/images/profile/$userID.png&h=200&w=200&zc=1' width='200' height='200' class='core-image-handler'></div>";
								
				$view .= "<div class='core-container-container-action span3'>";
				
				$view .= "<div id='core-container-file-uploadPhoto'></div>";  
		                        
		        $view .= "</div>";

				$view .= "</div>";

			$view .= "</div>";
			
			$view .= '<hr>';
			
			$view .= "<div class='control-group'>";

				$view .= "<label class='control-label administrator-label' for='name'>Full Name</label>";

				$view .= "<div class='controls administrator-controls'>";
				
				$view .= "<input type='hidden' id='id' value='".$userData['CAP_USE_ID']."'>";
				
				$view .= "<input class='span6' type='text' id='name' value='".$userData['CAP_USE_FIRSTNAME'].' '.$userData['CAP_USE_LASTNAME']."'>";

				$view .= "</div>";

			$view .= "</div>";

			$view .= "<div class='control-group'>";

				$view .= "<label class='control-label administrator-label' for='email'>Email</label>";

				$view .= "<div class='controls administrator-controls'>";

				$view .= "<input class='span6' type='text' id='email' value='".$userData['CAP_USE_EMAIL']."'>";

				$view .= "</div>";

			$view .= "</div>";

			$view .= "<div class='control-group'>";

				$view .= "<label class='control-label administrator-label' for='username'>Username</label>";

				$view .= "<div class='controls administrator-controls'>";

				$view .= "<input class='span6' type='text' id='username' value='".$userData['CAP_USE_USERNAME']."'>";

				$view .= "</div>";

			$view .= "</div>";

			$view .= "<div class='control-group'>";

				$view .= "<label class='control-label administrator-label' for='password'>Password</label>";

				$view .= "<div class='controls administrator-controls'>";

				$view .= "<input class='span6' type='password' id='password'>";

				$view .= "</div>";

			$view .= "</div>";
			
			$view .= "<hr>";
			
			$view .= "<div class='control-group'>";

				$view .= "<label class='control-label administrator-label ' for='siteuser'>Site User</label>";

				$view .= "<div class='controls administrator-controls'>";
				
					if (empty($userData['FK_CAP_MAI_ID_LOCATION'])):
				
					$view .= "<input id='siteuser' class='administrator-checkbox administrator-checkbox-global' type='checkbox' value='1'> This user have personal site";
					
					else:
					
					$view .= "<input id='siteuser' checked='checked' class='administrator-checkbox administrator-checkbox-global' type='checkbox' value='1'> This user have personal site";
					
					endif;
				
				$view .= "</div>";

			$view .= "</div>";
								
			$view .= "<div class='control-group'>";

				$view .= "<label class='control-label administrator-label' for='domain'>Personal Site</label>";

				$view .= "<div class='controls administrator-controls'>";
				
				$view .= "<input id='domain' class='span6' type='text' placeholder='Site' id='domain' value='".str_replace('.'.$userData['PARENT_DOMAIN'],'',$userData['CAP_MAI_DOMAIN'])."'>";
												
				$view .= "</div>";

			$view .= "</div>";
			
			$view .= "<div class='control-group'>";

				$view .= "<label class='control-label administrator-label' for='template'>Template</label>";

				$view .= "<div class='controls administrator-controls'>";
												
				$view .= "<select id='template' class='administrator-select span6 adminCore-select'>";
				
				$view .= "<option selected='selected' value=''></option>";
				
					foreach ($template as $temp => $plate):
						
						if ($userData['CAP_MAI_TEMPLATE'] == $plate):

							$view .= "<option selected='selected' value='$plate'>".$plate."</option>";

						else:

							$view .= "<option value='$plate'>".$plate."</option>";

						endif;
					
					endforeach;
															
				$view .= "</select>";

				$view .= "</div>";

			$view .= "</div>";
			
			$view .= "<hr>";
			
			$view .= "<div class='control-group'>";

				$view .= "<div class='controls administrator-controls'>";
				
				$view .= "<a class='btn btn-inverse core-profil-saveButton'>Save</a>";
												
				$view .= "</div>";

			$view .= "</div>";
						
		$view .= "</form>";

		echo $view;
    
	}
	
	public function getImageUploaded($userID){
		$return = "<img src='".APP."framework/resize.class.php?src="."library/capsule/core/images/profile/$userID.png&h=200&w=200&zc=1' width='200' height='200' class='core-image-handler'>";
		
		echo $return;
	}
	
	public function profilUser(){
    
    $userRole  = $this->getRoleList();
    		
		$sitesAll  = $this->getSitesList(null,null);
		
		$template  = $this->getAllTemplate();
    
    $user = unserialize($_SESSION['user']);
    
    $userID = $user->getID();
	
	$userData	= $this->getUserData($userID);
	
	print_r($userData);
		
		$sitesAll  = $this->getSitesList(null,null);
		
		$template  = $this->getAllTemplate();
		
		$currentDomain = $_SERVER['SERVER_NAME'];	
		
		$view .= "<script>
			
		</script>";	

		$view  .= "<hr>";
				
		$view .= "<form class='form-horizontal' id='administrator-user-edit'>";
		
		
			$view .= "<div class='control-group'>";

				$view .= "<label class='control-label administrator-label' for='name'>Photo</label>";
				
				$view .= "<div class='controls administrator-controls controls-row'>";
				
				$view .= "<div class='core-image-handler span2' ><img src='".APP."framework/resize.class.php?src="."library/capsule/core/images/profile/$userID.png&h=200&w=200&zc=1' width='200' height='200' class='core-image-handler'></div>";
								
				$view .= "<div class='core-container-container-action span3'>";
				
				$view .= "<div id='core-container-file-uploadPhoto'></div>";  
		                        
		        $view .= "</div>";

				$view .= "</div>";

			$view .= "</div>";
			
			$view .= '<hr>';
			
			$view .= "<div class='control-group'>";

				$view .= "<label class='control-label administrator-label' for='name'>Full Name</label>";

				$view .= "<div class='controls administrator-controls'>";
				
				$view .= "<input type='hidden' id='id' value='".$userData['CAP_USE_ID']."'>";
				
				$view .= "<input class='span6' type='text' id='name' value='".$userData['CAP_USE_FIRSTNAME'].' '.$userData['CAP_USE_LASTNAME']."'>";

				$view .= "</div>";

			$view .= "</div>";

			$view .= "<div class='control-group'>";

				$view .= "<label class='control-label administrator-label' for='email'>Email</label>";

				$view .= "<div class='controls administrator-controls'>";

				$view .= "<input class='span6' type='text' id='email' value='".$userData['CAP_USE_EMAIL']."'>";

				$view .= "</div>";

			$view .= "</div>";

			$view .= "<div class='control-group'>";

				$view .= "<label class='control-label administrator-label' for='username'>Username</label>";

				$view .= "<div class='controls administrator-controls'>";

				$view .= "<input class='span6' type='text' id='username' value='".$userData['CAP_USE_USERNAME']."'>";

				$view .= "</div>";

			$view .= "</div>";

			$view .= "<div class='control-group'>";

				$view .= "<label class='control-label administrator-label' for='password'>Password</label>";

				$view .= "<div class='controls administrator-controls'>";

				$view .= "<input class='span6' type='password' id='password'>";

				$view .= "</div>";

			$view .= "</div>";
			
			$view .= "<hr>";
			
			$view .= "<div class='control-group'>";
			
				$view .= "<label class='control-label administrator-label ' for='siteuser'>Site User</label>";

				$view .= "<div class='controls administrator-controls'>";
				
					if (empty($userData['FK_CAP_MAI_ID_LOCATION'])):
				
					$view .= "<input id='siteuser' class='administrator-checkbox administrator-checkbox-global' type='checkbox' value='1'> This user have personal site";
					
					else:
					
					$view .= "<input id='siteuser' checked='checked' class='administrator-checkbox administrator-checkbox-global' type='checkbox' value='1'> This user have personal site";
					
					endif;
				
				$view .= "</div>";

			$view .= "</div>";
								
			$view .= "<div class='control-group'>";

				$view .= "<label class='control-label administrator-label' for='domain'>Personal Site</label>";

				$view .= "<div class='controls administrator-controls'>";
				
				$view .= "<input id='domain' class='span6' type='text' placeholder='Site' id='domain' value='".str_replace('.'.$userData['PARENT_DOMAIN'],'',$userData['CAP_MAI_DOMAIN'])."'>";
												
				$view .= "</div>";

			$view .= "</div>";
			
			$view .= "<div class='control-group'>";

				$view .= "<label class='control-label administrator-label' for='template'>Template</label>";

				$view .= "<div class='controls administrator-controls'>";
												
				$view .= "<select id='template' class='administrator-select span6 adminCore-select'>";
				
				$view .= "<option selected='selected' value=''></option>";
				
					foreach ($template as $temp => $plate):
						
						if ($userData['CAP_MAI_TEMPLATE'] == $plate):

							$view .= "<option selected='selected' value='$plate'>".$plate."</option>";

						else:

							$view .= "<option value='$plate'>".$plate."</option>";

						endif;
					
					endforeach;
															
				$view .= "</select>";

				$view .= "</div>";

			$view .= "</div>";
			
			$view .= "<hr>";
			
			$view .= "<div class='control-group'>";

				$view .= "<div class='controls administrator-controls'>";
				
				$view .= "<a class='btn btn-inverse core-profil-saveButton'>Save</a>";
												
				$view .= "</div>";

			$view .= "</div>";
						
		$view .= "</form>";

		echo $view;
    
	}

	
	public function menuAdmin(){
    
    $pages = $this->pages();
    
    $data  = $this->getSubMainMenu();
    
    $menu  = $this->getSubMenu();
    
    //print_r($menu);
    
    $lag   = $this->language();

    $view .= $this->optionGear;
    
    $view .= "<div class='core-".$this->params."-container'>"; 
    
    	$view .= "<div class='core-".$this->params."-container-inside'>Menu Divisi</div>"; 
    	
    	$view .= "<div class='core-container-contentInsideActionButton'>";
        
        $view .= "<button class='core-".$this->params."-actionAdd'></button>";
        
        $view .= "<select class='core-menu-select core-filled-field'>";
			
					$view .= "<option selected='selected' value=''>-- Select Language --</option>";
   	 				
   	 				foreach ($lag as $key => $value) {
				
						if ($_SESSION[language] == $value['CAP_LAN_ID']) {
				
						$view .= "<option selected='selected' value='$value[CAP_LAN_ID]'>$value[CAP_LAN_NAME]</option>";
					
						}
						else {
					
						$view .= "<option value='$value[CAP_LAN_ID]'>$value[CAP_LAN_NAME]</option>";
						
						}
				
					}
   	 				
   	 	$view .= "</select>";
        
        $view .= "</div>";
                
        $view .= "<div class='core-".$this->params."-container-content'>";
        
        	$view .= "<table class='core-".$this->params."-table'>";
        	
        		$view .= "<thead>";
        	
        			$view .= "<tr>";
        				
        				$view .= "<td class='core-".$this->params."-container-tableHeader-action core-align-center'>Aksi</td>";
        				        				
   	 					$view .= "<td class='core-".$this->params."-container-tableHeader core-align-center'>Nama Menu</td>";
   	 					
   	 					$view .= "<td class='core-".$this->params."-container-tableHeader core-align-center'>External URL</td>";
   	 					
   	 					$view .= "<td class='core-".$this->params."-container-tableHeader core-align-center'>Berat</td>";
   	 					
   	 					$view .= "<td class='core-".$this->params."-container-tableHeader core-align-center'>Halaman</td>";
   	 		
   	 				$view .= "</tr>";
        	
        		$view .= "</thead>";
        	
        		$view .= "<tbody>";
        		
        		if (!empty($menu)) {
        		
        			foreach ($menu as $key => $value) {
        	
       	 				$view .= "<tr>";
        				
        					$view .= "<td class='core-".$this->params."-container-tableContent core-align-center'><span class='core-".$this->params."-actionDelete'></span><input type='hidden' class='core-".$this->params."-inputRealID' value='".$value['CAP_MEN_ID']."'><input type='hidden' class='core-".$this->params."-input' value='".$data[0]['CAP_MEN_ID']."'></td>";
        				        				
   	 						$view .= "<td class='core-".$this->params."-container-tableContent'><input type='text' class='core-".$this->params."-input' value='".$value['CAP_LAN_COM_VALUE']."'></td>";
   	 					
   	 						$view .= "<td class='core-".$this->params."-container-tableContent'><input type='text' class='core-".$this->params."-input' value='".$value['CAP_MEN_OTHERURL']."'></td>";
   	 					
   	 						$view .= "<td class='core-".$this->params."-container-tableContent'><input type='text' class='core-".$this->params."-input' value='".$value['CAP_MEN_POSITION']."'></td>";
   	 					
   	 						$view .= "<td class='core-".$this->params."-container-tableContent'><select class='core-".$this->params."-input'>";
   	 					
   	 						foreach ($pages as $key => $value) {
   	 					
   	 						$view .= "<option value = '$value[CAP_PAG_ID]'>$value[CAP_PAG_NAME]</option>";
   	 					
   	 						}
   	 					
   	 						$view .= "</select></td>";
   	 					   	 		
   	 					$view .= "</tr>";
   	 				
   	 				}
   	 			
   	 			}
   	 			else {
   	 			
   	 			$view .= "<tr>";
        				
        			$view .= "<td class='core-".$this->params."-container-tableContent core-align-center'><span class='core-".$this->params."-actionDelete'></span><input type='hidden' class='core-".$this->params."-input' value='".$value['CAP_MEN_ID']."'><input type='hidden' class='core-".$this->params."-input' value='".$data[0]['CAP_MEN_ID']."'></td>";
        				        				
   	 				$view .= "<td class='core-".$this->params."-container-tableContent'><input type='text' class='core-".$this->params."-input' value='".$value['CAP_LAN_COM_VALUE']."'></td>";
   	 					
   	 				$view .= "<td class='core-".$this->params."-container-tableContent'><input type='text' class='core-".$this->params."-input' value='".$value['CAP_MEN_OTHERURL']."'></td>";
   	 					
   	 				$view .= "<td class='core-".$this->params."-container-tableContent'><input type='text' class='core-".$this->params."-input' value='".$value['CAP_MEN_POSITION']."'></td>";
   	 					
   	 				$view .= "<td class='core-".$this->params."-container-tableContent'><select class='core-".$this->params."-input'>";
   	 					
   	 				foreach ($pages as $key => $value) {
   	 					
   	 				$view .= "<option value = '$value[CAP_PAG_ID]'>$value[CAP_PAG_NAME]</option>";
   	 					
   	 				}
   	 					
   	 				$view .= "</select></td>";
   	 					   	 		
   	 			$view .= "</tr>";
   	 			
   	 			}
   	 			
   	 		
   	 			$view .= "</tbody>";
   	 			
   	 			$view .= "<tfoot>";
        	
       	 			$view .= "<tr>";
        
   	 					$view .= "<td class='core-".$this->params."-container-tableContent'>&nbsp;</td>";
   	 					   	 					
   	 					$view .= "<td class='core-".$this->params."-container-tableContent'></td>";
   	 					
   	 					$view .= "<td class='core-".$this->params."-container-tableContent'></td>";
   	 					
   	 					$view .= "<td class='core-".$this->params."-container-tableContent'></td>"; 
   	 					
   	 					$view .= "<td class='core-".$this->params."-container-tableContent'></td>";
   	 		
   	 				$view .= "</tr>";
   	 		
   	 			$view .= "</tfoot>";
   	 		
   	 		$view .= "</table>";
   	 	
   	 	$view .= "</div>";
    
    $view .= "<div class='core-".$this->params."-information'>";
    
    $view .= "
        
        		<dl>
          			<dt>Penggunaan</dt>
            			<dd>Input field diatas akan ditempatkan pada sub menu E-Gov</dd>
            		<dt>Hasil </dt>
            			<dd>Nama / singkatan yang anda masukan pada input field diatas akan dapat dilihat oleh semua pengunjung website core</dd>
           		</dl>";
        
        $view .= "<br />";
    
    $view .= "</div>";
    
    $view .= "<input type='submit' class='core-menu-submit' value='Update'>";
    
    $view .= "</div>";
    
    echo $view;
    
	}
	
	public function contentAdmin(){
    $perPageSet = 20;
    $contentList = $this->getContentListContentAdmin(1,$perPageSet);
    $count = $this->countTotalOfContent();
    $contentCat  = $this->getContentCategoryList();
	//print_r($contentList[0]);
   
		
		 
    
   
    $view  .= $this->optionGear;
    $view .= "<div class='core-image-container'>";
     $view .= '<div class="dado-core-file-container">';
	$view .= '				<div class="dado-core-file-header" style="position:relative">';
						
	$view .= '					<div class="dado-id-float-left">';
	//$view .= '					<div class="core-container-contentInsideActionButton"><button class="core-button-setCompletedContentAdmin"></button></div>';
	$view .= '				</div>';
								
			 			
	$view .='<div class="dado-id-float-right">
						
							<input type="hidden" class="pageAtThisTime" value="1"><input type="hidden" class="totalPage" value="'.ceil($count[0][COUNT]/$perPageSet).'">';
							if(ceil($count[0][COUNT]/$perPageSet) > 1){
		$view .= '					<div class="core-container-contentInsideActionButton" style="float:left;"><button style="display:none" class="core-button-prev-text qtip-upper" text="Halaman Sebelumnya"></button></div>';
		$view .= '					<div style="float:left;margin:5px 10px 5px 0px">Page : 1</div>';
		$view .= '					<div class="core-container-contentInsideActionButton" style="float:left;"><button class="core-button-next-text qtip-upper" text="Halaman Selanjutnya"></button></div>';
		}
		$view .= '				</div>';
		
	$view .= '
					</div>
					<div class="dado-core-file-body" >';
     $view .= "<div class='core-image-container'>"; 
    
    	
        $view .= "<div class='core-container-contentInside'></div>";
        
       
        
        $view .= "<div class='core-image-container-content'>";
        
        $view .= "<table class='core-image-table table table-hover table-stripped'>";
        
        $view .= "<thead>";
        
        	$view .= "<tr>";
        		
        		$view .= "<td class='core-align-center'>Aksi</td>";
        		
        		$view .= "<td class='core-align-left'>Nama</td>";
        		
        		$view .= "<td class='core-align-center'>Category</td>";
        		
        		$view .= "<td class='core-align-center'>Halaman</td>";
        		
        		$view .= "<td class='core-align-center'>Publisher</td>";
        		
        		$view .= "<td class='core-align-center'>Sites</td>";
        		        	
        	$view .= "</tr>";
        
        $view .= "</thead>";
        
        $view .= "<tbody>";
        
        if (!empty($contentList)) {
        
        	foreach ($contentList as $key => $value) {
        	    $dataPages 	 = $this->getPagesList('FK_CAP_MAI_ID');
        		
        		$view .= "<tr>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall'><input type='hidden' name='contentID' value='$value[CAP_CON_ID]'><span class='core-image-actionDelete'></span><span class='core-image-actionNextContentAdmin'></span></td>";
        			
        			$view .= "<td class='core-image-container-tableContentHuge'>$value[CAP_CON_HEADER]</td>";
        			
        			$view .= "<td class='core-align-center'><select>";
			
						foreach ($contentCat as $category) {
				
							if ($value['CAP_CON_CAT_ID'] == $category['CAP_CON_CAT_ID']) {
					
							$view .= "<option selected='selected' value='$category[CAP_CON_CAT_ID]'>" . ucwords(strtolower($category['CAP_CON_CAT_NAME'])) . "</option>";
					
							}
							else {
					
							$view .= "<option value='$category[CAP_CON_CAT_ID]'>" . ucwords(strtolower($category['CAP_CON_CAT_NAME'])) . "</option>";
					
							}
								
						}
			
					$view .= "</td></select>";
        			
        			$view .= "<td class='core-align-center'><select>";
	
					$view .= "<option selected='selected' value=''>Select Pages</option>";
					
						foreach ($dataPages as $pages) {
								$template = explode("/",$pages['CAP_PAG_PATH']);
								
									if ($value['CAP_PAG_ID']  == $pages['CAP_PAG_ID']) {
				
									$view .= "<option selected='selected' value='$pages[CAP_PAG_ID]'> ".$template[3]." - ".$pages[CAP_PAG_NAME]."</option>";
									
									}
									else {
									
									$view .= "<option value='$pages[CAP_PAG_ID]'>".$template[3]." - ".$pages[CAP_PAG_NAME]."</option>";
									
									}
								
							
						}
	
				$view .= "</select><input type='hidden' name='contentType' value='content'></td>";
				
				$view .= "<td class='core-image-container-tableContentSmall'>$value[CAP_USE_FIRSTNAME]</td>";
				
				$view .= "<td class='core-image-container-tableContentSmall'>".$this->getDomainName($value[CAP_MAI_ID])."<input type='hidden' name='FKID' value='".$value['CAP_LAN_COM_ID']."'></td>";
        		        		
        		$view .= "</tr>";

        	}
        	
        }
       
        $view .= "</tbody>";
        
        
        
        $view .= "</table>";
        
        $view .= "<input type='submit' class='core-profil-submit' value='Update'>";
        
        $view .= "</div></div></div></div>";
        
    echo $view;
    
	}
	public function eventAdmin(){
    $perPageSet = 20;
    $contentList = $this->getContentListEventAdmin();
    $count = $this->countTotalOfContent();
    //$contentCat  = $this->getContentCategoryList();
	//print_r($contentList);
    if(!empty($contentList)){}		
		 
    $dataPages 	 = $this->getPagesList();
   
    $view  .= $this->optionGear;
     $view .= "<div class='core-image-container'>";
     $view .= '<div class="dado-core-file-container">';
	 $view .= '				<div class="dado-core-file-header" style="position:relative">';
	 $view .= '					<div class="dado-id-float-left">';
	//$view .= '					<div class="core-container-contentInsideActionButton"><button class="core-button-setCompletedAdmin qtip-upper" text="Tambah Folder Baru"></button></div>';
	$view .= '				</div>';
			 			
	$view .='<div class="dado-id-float-right">
						
							<input type="hidden" class="pageAtThisTime" value="0"><input type="hidden" class="totalPage" value="'.ceil($count[0][COUNT]/$perPageSet).'">';
							if(ceil($count[0][COUNT]/$perPageSet) > 1){
		$view .= '					<div class="core-container-eventInsideActionButton" style="float:left;"><button style="display:none" class="core-button-prev-text qtip-upper" text="Halaman Sebelumnya"></button></div>';
							
		$view .= '					<div class="core-container-eventInsideActionButton" style="float:left;"><button class="core-button-next-text qtip-upper" text="Halaman Selanjutnya"></button></div>';
		}
		$view .= '				</div>';
		
	$view .= '
					</div>
					<div class="dado-core-file-body" >';
     $view .= "<div class='core-image-container'>"; 
    
    	
        $view .= "<div class='core-container-eventInside'></div>";
        
       
        
        $view .= "<div class='core-image-container-event'>";
        
        $view .= "<table class='core-image-table table table-hover table-stripped'>";
        
        $view .= "<thead>";
        
        	$view .= "<tr>";
        		
        		$view .= "<td class='core-align-center'>Aksi</td>";
        		
        		$view .= "<td class='core-align-left'>Nama</td>";
        		
        		$view .= "<td class='core-align-center'>Event Date</td>";
        		
        		$view .= "<td class='core-align-center'>Halaman</td>";
        		
        		$view .= "<td class='core-align-center'>Publisher</td>";
        		        	
        	$view .= "</tr>";
        
        $view .= "</thead>";
        
        $view .= "<tbody>";
        
        if (!empty($contentList)) {
        
        	foreach ($contentList as $key => $value) {
        	        	
        		$view .= "<tr>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall'><input type='hidden' name='contentID' value='$value[CAP_CON_ID]'><span class='core-image-actionDelete'></span><span class='core-image-actionNextEventAdmin'></span></td>";
        			
        			$view .= "<td class='core-image-container-tableContentHuge'>$value[CAP_CON_HEADER]</td>";
        			
        			/*$view .= "<td class='core-align-center'><select>";
			
						foreach ($contentCat as $category) {
				
							if ($value['CAP_CON_CAT_ID'] == $category['CAP_CON_CAT_ID']) {
					
							$view .= "<option selected='selected' value='$category[CAP_CON_CAT_ID]'>" . ucwords(strtolower($category['CAP_CON_CAT_NAME'])) . "</option>";
					
							}
							else {
					
							$view .= "<option value='$category[CAP_CON_CAT_ID]'>" . ucwords(strtolower($category['CAP_CON_CAT_NAME'])) . "</option>";
					
							}
								
						}
			
					$view .= "</select></td>";*/
					
					$view .= "<td class='core-image-container-tableContentSmall core-align-center'>".date('d-m-Y', strtotime($value[CAP_CON_DATEPUBLISHED]));
					
					$view .= "</td>";
        			
        			$view .= "<td class='core-align-center'><select>";
	
					$view .= "<option selected='selected' value=''>Select Pages</option>";
					
						foreach ($dataPages as $pages) {
								$template = explode("/",$pages['CAP_PAG_PATH']);
								
								if ($template[2] == DEFAULT_TEMPLATE) {
								
									if ($value['CAP_PAG_ID']  == $pages['CAP_PAG_ID']) {
				
									$view .= "<option selected='selected' value='$pages[CAP_PAG_ID]'> ".$template[3]." - ".$pages[CAP_PAG_NAME]."</option>";
									
									}
									else {
									
									$view .= "<option value='$pages[CAP_PAG_ID]'>".$template[3]." - ".$pages[CAP_PAG_NAME]."</option>";
									
									}
								
							}
						}
	
				$view .= "</select><input type='hidden' name='contentType' value='event'></td>";
				
				$view .= "<td class='core-image-container-tableContentSmall'>$value[CAP_USE_FIRSTNAME]<input type='hidden' name='FKID' value='".$value['CAP_LAN_COM_ID']."'></td>";
        		        		
        		$view .= "</tr>";

        	}
        	
        }
       
        $view .= "</tbody>";
        
        
        
        $view .= "</table>";
        
        $view .= "<input type='submit' class='core-profil-submit-event' value='Update'>";
        
        $view .= "</div></div></div></div>";
        
    echo $view;
    
	}
	
	public function imageAdmin(){
       
    $this->params = "image";
	
    $contentList = $this->getContentListImageAdmin();
    $contentListTotal = $this->getContentListImageAdminTotal();
    //print_r($contentList);
    $perPageSet = 20;
    $count = $this->countTotalOfFile("image");
    $contentCat  = $this->getContentCategoryList();
    
    $dataPages 	 = $this->getPagesList();
    
    $view  .= $this->optionGear;
    $view .= "<div class='core-image-container'>";
    
    
   
      $view .= "<div class='core-image-container'>";
     $view .= '<div class="dado-core-file-container">';
	 $view .= '				<div class="dado-core-file-header" style="position:relative">';
	 $view .= '					<div class="dado-id-float-left">';
	//$view .= '					<div class="core-container-contentInsideActionButton"><button class="core-button-setCompletedAdmin qtip-upper" text="Tambah Folder Baru"></button></div>';
	$view .= '				</div>';
			 		$view .='<div class="dado-id-float-right">
						
							<input type="hidden" class="pageAtThisTime" value="0"><input type="hidden" class="totalPage" value="'.ceil($count[0][COUNT]/$perPageSet).'">';
							if(ceil($count[0][COUNT]/$perPageSet) > 1){
		$view .= '					<div class="core-container-contentInsideActionButton" style="float:left;"><button style="display:none" class="core-button-prev qtip-upper" text="Halaman Sebelumnya"></button></div>';
							
		$view .= '					<div class="core-container-contentInsideActionButton" style="float:left;"><button class="core-button-next qtip-upper" text="Halaman Selanjutnya"></button></div>';
		}
		$view .= '				</div>';
	$view .= '
					</div>
					<div class="dado-core-file-body" >';
     $view .= "<div class='core-".$this->params."-container'>"; 
    
    	$view .= "<div class='core-".$this->params."-container-inside'><span class='pagesOfView'>Image Manager </span><span class='core-headerOfContent'></span><input type='hidden' class='core-headerOfContentInput' value=''><input type='hidden' class='core-headerOfContentInputTypeOfFile' value='image'></div>"; 
    	
        $view .= "<div class='core-container-contentInside'></div>";
        
       
        
        $view .= "<div class='core-".$this->params."-container-content'>";
        
        $view .= "<table class='core-".$this->params."-table table table-hover table-stripped''>";
        
        $view .= "<thead>";
        
        	$view .= "<tr>";
        		
        		$view .= "<td class='core-align-center'>Aksi</td>";
        		
        		$view .= "<td class='core-align-left'>Nama</td>";
        		
        		$view .= "<td class='core-align-left'>Publisher</td>";
        		
        		$view .= "<td class='core-align-left'>Sites</td>";
        		        	
        	$view .= "</tr>";
        
        $view .= "</thead>";
        
        $view .= "<tbody>";
        
        if (!empty($contentList)) {
        
        	foreach ($contentList as $key => $value) {
        	
        		$view .= "<tr>";
        			
        			$view .= "<td class='core-".$this->params."-container-tableContentSmall'><input type='hidden' name='contentID' value='$value[CAP_CON_ID]'><span class='core-".$this->params."-actionDelete'></span><span class='core-".$this->params."-actionNextAdmin'></span></td>";
        			
        			$view .= "<td class='core-".$this->params."-container-tableContentHuge'>$value[CAP_CON_HEADER]</td>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall'>$value[CAP_USE_FIRSTNAME]</td>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall'>".$this->getDomainName($value[CAP_MAI_ID])."</td>";
        		        		
        		$view .= "</tr>";
        	
        	}
        
        }
        
        $view .= "</tbody>";
        
                
        $view .= "</table>";
        
        $view .= "<input type='submit' class='core-profil-submit' value='Update'>";
        
        $view .= "</div></div></div></div>";
        
    echo $view;
    
	}
	
	public function fileAdmin(){
       
    $contentList = $this->getContentListFileAdmin();
    $perPageSet = 20;
    $count = $this->countTotalOfFile('file');
    $contentCat  = $this->getContentCategoryList();
    
    $view  .= $this->optionGear;
     $view .= "<div class='core-image-container'>";
     $view .= '<div class="dado-core-file-container">';
	 $view .= '				<div class="dado-core-file-header" style="position:relative">';
	 $view .= '					<div class="dado-id-float-left">';
	//$view .= '					<div class="core-container-contentInsideActionButton"><button class="core-button-setCompletedAdmin qtip-upper" text="Tambah Folder Baru"></button></div>';
	$view .= '				</div>';
					
			 		$view .='<div class="dado-id-float-right">
	
							<input type="hidden" class="pageAtThisTime" value="0"><input type="hidden" class="totalPage" value="'.ceil($count[0][COUNT]/$perPageSet).'">';
							if(ceil($count[0][COUNT]/$perPageSet) > 1){
		$view .= '					<div class="core-container-contentInsideActionButton" style="float:left;"><button style="display:none" class="core-button-prev qtip-upper" text="Halaman Sebelumnya"></button></div>';
							
		$view .= '					<div class="core-container-contentInsideActionButton" style="float:left;"><button class="core-button-next qtip-upper" text="Halaman Selanjutnya"></button></div>';
		}
		$view .= '				</div>';
	$view .= '
					</div>
					<div class="dado-core-file-body" >'; 
    
    	$view .= "<div class='core-image-container-inside'>File Manager <span class='core-headerOfContent'></span><input type='hidden' class='core-headerOfContentInput' value=''><input type='hidden' class='core-headerOfContentInputTypeOfFile' value='file'></div>"; 
    	
        $view .= "<div class='core-container-contentInside'></div>";
        
              
        $view .= "<div class='core-image-container-content'>";
        
        $view .= "<table class='core-image-table table table-hover table-stripped'>";
        
        $view .= "<thead>";
        
        	$view .= "<tr>";
        		
        		$view .= "<td class='core-align-center'>Aksi</td>";
        		
        		$view .= "<td class='core-align-left'>Nama</td>";
        		
        		$view .= "<td class='core-align-left'>Publisher</td>";
        		
        		$view .= "<td class='core-align-center'>Sites</td>";
        		        	
        	$view .= "</tr>";
        
        $view .= "</thead>";
        
        $view .= "<tbody>";
        
        if (!empty($contentList)) {
        
        	foreach ($contentList as $key => $value) {
        	
        		$domainName = $this->getDomainName($value[CAP_MAI_ID]);
        	        	
        		$view .= "<tr>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall'><input type='hidden' name='contentID' value='$value[CAP_CON_ID]'><span class='core-image-actionDelete qtip-upper' text='Hapus Folder'></span><span class='core-image-actionNextAdmin qtip-upper' text='Masuk Kedalam Folder'></span></td>";
        			
        			$view .= "<td class='core-image-container-tableContentHuge'>$value[CAP_CON_HEADER]</td>";
        			   			
        			$view .= "<td class='core-image-container-tableContentSmall'>$value[CAP_USE_FIRSTNAME]</td>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall' data-domain=$domainName>$domainName</td>";
        				        			
        		        		
        		$view .= "</tr>";

        	}
        	
        }
       
        $view .= "</tbody>";
        
       
        
        $view .= "</table>";
        
        $view .= "<input type='submit' class='core-profil-submit' value='Update'>";
        
        $view .= "</div></div></div>
				</div>";
        
    echo $view;
    
	}
	
	public function audioAdmin(){
        
    $contentList = $this->getContentListAudioAdmin();
    $perPageSet = 20;
    $count = $this->countTotalOfFile('audio');
    $contentCat  = $this->getContentCategoryList();
    
    $dataPages 	 = $this->getPagesList();
    
    $view  .= $this->optionGear;
    $view .= "<div class='core-image-container'>";
     $view .= '<div class="dado-core-file-container">
					<div class="dado-core-file-header" style="position:relative">
						<div class="dado-id-float-left">
						<div class="core-container-contentInsideActionButton"><button class="core-button-setCompletedAdmin"></button></div>
					</div>
								';
			 		$view .='<div class="dado-id-float-right">
						
							<input type="hidden" class="pageAtThisTime" value="0"><input type="hidden" class="totalPage" value="'.ceil($count[0][COUNT]/$perPageSet).'">';
							if(ceil($count[0][COUNT]/$perPageSet) > 1){
		$view .= '					<div class="core-container-contentInsideActionButton" style="float:left;"><button style="display:none" class="core-button-prev qtip-upper" text="Halaman Sebelumnya"></button></div>';
							
		$view .= '					<div class="core-container-contentInsideActionButton" style="float:left;"><button class="core-button-next qtip-upper" text="Halaman Selanjutnya"></button></div>';
		}
		$view .= '				</div>';
	$view .= '
					</div>
					<div class="dado-core-file-body" >';
     $view .= "<div class='core-image-container'>"; 
    
    	$view .= "<div class='core-image-container-inside'>Audio Manager <span class='core-headerOfContent'></span><input type='hidden' class='core-headerOfContentInput' value=''><input type='hidden' class='core-headerOfContentInputTypeOfFile' value='audio'></div>"; 
    	
        $view .= "<div class='core-container-contentInside'></div>";
        
      
        
        $view .= "<div class='core-image-container-content'>";
        
        $view .= "<table class='core-image-table table table-hover table-stripped'>";
        
        $view .= "<thead>";
        
        	$view .= "<tr>";
        		
        		$view .= "<td class='core-align-center'>Aksi</td>";
        		
        		$view .= "<td class='core-align-left'>Nama</td>";
        		
        		$view .= "<td class='core-align-left'>Publisher</td>";
        		
        		$view .= "<td class='core-align-left'>Sites</td>";
        		
        		        	
        	$view .= "</tr>";
        
        $view .= "</thead>";
        
        $view .= "<tbody>";
        
        if (!empty($contentList)) {
        
        	foreach ($contentList as $key => $value) {
        	        	
        		$view .= "<tr>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall'><input type='hidden' name='contentID' value='$value[CAP_CON_ID]'><span class='core-image-actionDelete'></span><span class='core-image-actionNextAdmin'></span></td>";
        			
        			$view .= "<td class='core-image-container-tableContentHuge'>$value[CAP_CON_HEADER]</td>";
        			        			
        			$view .= "<td class='core-image-container-tableContentSmall'>$value[CAP_USE_FIRSTNAME]</td>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall'>".$this->getDomainName($value[CAP_MAI_ID])."</td>";
        			
				$view .= "</td>";
        		        		
        		$view .= "</tr>";

        	}
        	
        }
       
        $view .= "</tbody>";
        
     
        
        $view .= "</table>";
        
        $view .= "<input type='submit' class='core-profil-submit' value='Update'>";
        
        $view .= "</div></div></div></div>";
        
    echo $view;
    
	}
	
	public function movieAdmin(){
        
    $contentList = $this->getContentListVideoAdmin();
    $perPageSet = 20;
    $count = $this->countTotalOfFile('video');
    $contentCat  = $this->getContentCategoryList();
    
    $dataPages 	 = $this->getPagesList();
    
    $view  .= $this->optionGear;
    $view .= "<div class='core-image-container'>";
     $view .= '<div class="dado-core-file-container">
					<div class="dado-core-file-header" style="position:relative">
						<div class="dado-id-float-left">
						<div class="core-container-contentInsideActionButton"><button class="core-button-setCompletedAdmin"></button></div>
					</div>
								';
			 		$view .='<div class="dado-id-float-right">
						
							<input type="hidden" class="pageAtThisTime" value="0"><input type="hidden" class="totalPage" value="'.ceil($count[0][COUNT]/$perPageSet).'">';
							if(ceil($count[0][COUNT]/$perPageSet) > 1){
		$view .= '					<div class="core-container-contentInsideActionButton" style="float:left;"><button style="display:none" class="core-button-prev qtip-upper" text="Halaman Sebelumnya"></button></div>';
							
		$view .= '					<div class="core-container-contentInsideActionButton" style="float:left;"><button class="core-button-next qtip-upper" text="Halaman Selanjutnya"></button></div>';
		}
		$view .= '				</div>';
	$view .= '
					</div>
					<div class="dado-core-file-body" >';
     $view .= "<div class='core-image-container'>"; 
    
    	$view .= "<div class='core-image-container-inside'>Video Manager <span class='core-headerOfContent'></span><input type='hidden' class='core-headerOfContentInput' value=''><input type='hidden' class='core-headerOfContentInputTypeOfFile' value='video'></div>"; 
    	
        $view .= "<div class='core-container-contentInside'></div>";
        
              
        $view .= "<div class='core-image-container-content'>";
        
        $view .= "<table class='core-image-table table table-hover table-stripped'>";
        
        $view .= "<thead>";
        
        	$view .= "<tr>";
        		
        		$view .= "<td class='core-align-center'>Aksi</td>";
        		
        		$view .= "<td class='core-align-left'>Nama</td>";
        		
        		$view .= "<td class='core-align-left'>Publisher</td>";
        		
        		$view .= "<td class='core-align-left'>Sites</td>";
        		        	
        	$view .= "</tr>";
        
        $view .= "</thead>";
        
        $view .= "<tbody>";
        
        if (!empty($contentList)) {
        
        	foreach ($contentList as $key => $value) {
        	        	
        		$view .= "<tr>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall'><input type='hidden' name='contentID' value='$value[CAP_CON_ID]'><span class='core-image-actionDelete'></span><span class='core-image-actionNextAdmin'></span></td>";
        			
        			$view .= "<td class='core-image-container-tableContentHuge'>$value[CAP_CON_HEADER]</td>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall'>$value[CAP_USE_FIRSTNAME]</td>"; 
        			
        			$view .= "<td class='core-image-container-tableContentSmall'>".$this->getDomainName($value[CAP_MAI_ID])."</td>";       			
        		        		
        		$view .= "</tr>";

        	}
        	
        }
       
        $view .= "</tbody>";
              
        $view .= "</table>";
        
        $view .= "<input type='submit' class='core-profil-submit' value='Update'>";
        
        $view .= "</div></div></div></div>";
        
    echo $view;
    
	}
	
	public function originalContentAdmin($start = null, $perPage = null) {
      
      if(!empty($this->data)){
          $start = $this->data;
      }
		$perPageSet = 20;
    	foreach ($this->model as $key => $value) {
    
    		if ($key == $this->type) {
    		$headerType = $value; $method = "getContentList".$value."Admin"; break;
    		}
    
    	}
    
    
    
    $contentList = $this->$method($start, $perPage);

    $count = $this->countTotalOfContent();
    $contentCat  = $this->getContentCategoryList();
    
    $dataPages 	 = $this->getPagesList();
        
    $view .= "<div class='core-image-container'>"; 
     $view .= '<div class="dado-core-file-container">
					<div class="dado-core-file-header" style="position:relative">
						<div class="dado-id-float-left">';
	 /*$view .= "<div class='core-container-contentInsideActionButton'>";
        
        	
        
       	 	$view .= "<button class='core-button-setCompletedAdmin'></button>";
       	 	
       	 	
        
        $view .= "</div>";*/
	$view .= '</div>
								';
			 	
	$view .='<div class="dado-id-float-right">
						
							<input type="hidden" class="pageAtThisTime" value="1"><input type="hidden" class="totalPage" value="'.ceil($count[0][COUNT]/$perPageSet).'">';
							if(ceil($count[0][COUNT]/$perPageSet) > 1){
		$view .= '
							<div class="core-container-contentInsideActionButton" style="float:left;"><button class="core-button-prev qtip-upper" text="Halaman Sebelumnya"></button></div>
							<div class="core-container-contentInsideActionButton" style="float:left;"><button class="core-button-next qtip-upper" text="Halaman Selanjutnya"></button></div>';
		}
			$view .= '				</div>';
	$view .= '
					</div>
					<div class="dado-core-file-body" >'; 
    

    	$view .= "<div class='core-image-container-inside'>".$headerType." Manager <span class='core-headerOfContent'></span><input type='hidden' class='core-headerOfContentInput' value=''><input type='hidden' class='core-headerOfContentInputTypeOfFile' value='".$this->type."'></div>";
    	
        $view .= "<div class='core-container-contentInside'></div>";
        
       
        
        $view .= "<div class='core-image-container-content'>";
        
        $view .= "<table class='core-image-table table table-hover table-stripped'>";
        
        $view .= "<thead>";
        
        	$view .= "<tr>";
        		
        		$view .= "<td class='core-align-center'>Aksi</td>";
        		
        		$view .= "<td class='core-align-left'>Nama</td>";
        		
        		$view .= "<td class='core-align-left'>Publisher</td>";
        		
        		$view .= "<td class='core-align-left'>Sites</td>";
        		        	
        	$view .= "</tr>";
        
        $view .= "</thead>";
        
        $view .= "<tbody>";
        
        if (!empty($contentList)) {
        
        	foreach ($contentList as $key => $value) {
        	
        		if ($value['CAP_CON_TYP_TYPE'] == $this->type) {
        	
        		$view .= "<tr>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall'><input type='hidden' name='contentID' value='$value[CAP_CON_ID]'><span class='core-image-actionDelete'></span>";
        			        				
        				$view .= "<span class='core-image-actionNextAdmin'></span></td>";
        				
        				
        			
        			$view .= "<td class='core-image-container-tableContentHuge'>$value[CAP_CON_HEADER]</td>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall'>$value[CAP_USE_FIRSTNAME]</td>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall'>".$this->getDomainName($value[CAP_MAI_ID])."</td>";
        			
	        		        		
        		$view .= "</tr>";
        		
        		}
        		else {
        		continue;
        		}
        	
        	}
        	
        }
       
        $view .= "</tbody>";
        
     
        $view .= "</table>";
        
        $view .= "<input type='submit' class='core-profil-submit' value='Update'>";
        
        $view .= "</div></div>";
        
    echo $view;
    
	}
	
	
	
	public function originalTextContentAdmin($start = 1, $perPage = 20) {
    
		 if(!empty($this->data)){
          $start = $this->data;
      }
    	$contentList = $this->getContentListContentAdmin($start, $perPage);
    	$count = $this->countTotalOfContent();
    $contentCat  = $this->getContentCategoryList();
    
   
   
    
     $view .= "<div class='core-image-container'>"; 
       $view .= '<div class="dado-core-file-container">';
    $view .= '				<div class="dado-core-file-header" style="position:relative">';
						
	$view .= '					<div class="dado-id-float-left">';
	//$view .= '					<div class="core-container-contentInsideActionButton"><button class="core-button-setCompletedContentAdmin"></button></div>';
	$view .= '				</div>';
			 			
	$view .='<div class="dado-id-float-right">
						
							<input type="hidden" class="pageAtThisTime" value="1"><input type="hidden" class="totalPage" value="'.ceil($count[0][COUNT]/$perPage).'">';
							if(ceil($count[0][COUNT]/$perPage) > 1){
		$view .= '
							<div class="core-container-contentInsideActionButton" style="float:left;"><button class="core-button-prev-text qtip-upper" text="Halaman Sebelumnya"></button></div>
							<div style="float:left;margin:5px 10px 5px 0px">Page : '.$start.'</div>
							<div class="core-container-contentInsideActionButton" style="float:left;"><button class="core-button-next-text qtip-upper" text="Halaman Selanjutnya"></button></div>';
		}
			$view .= '					</div>';
	$view .= '
					</div>
					<div class="dado-core-file-body" >';
    	
        $view .= "<div class='core-container-contentInside'></div>";
        
        
        
        $view .= "<div class='core-image-container-content'>";
        
        $view .= "<table class='core-image-table table table-hover table-stripped'>";
        
        $view .= "<thead>";
        
        	$view .= "<tr>";
        		
        		$view .= "<td class='core-align-center'>Aksi</td>";
        		
        		$view .= "<td class='core-align-left'>Nama</td>";
        		
        		$view .= "<td class='core-align-center'>Category</td>";
        		
        		$view .= "<td class='core-align-center'>Halaman</td>";
        		
        		$view .= "<td class='core-align-center'>Publisher</td>";
        		
        		$view .= "<td class='core-align-center'>Sites</td>";
        		        	
        	$view .= "</tr>";
        
        $view .= "</thead>";
        
        $view .= "<tbody>";
        
        if (!empty($contentList)) {
        
        	foreach ($contentList as $key => $value) {
        	    $dataPages 	 = $this->getPagesList($value[FK_CAP_MAI_ID]);
        		$view .= "<tr>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall'><input type='hidden' name='contentID' value='$value[CAP_CON_ID]'><span class='core-image-actionDelete'></span><span class='core-image-actionNextContentAdmin'></span></td>";
        			
        			$view .= "<td class='core-image-container-tableContentHuge'>$value[CAP_CON_HEADER]</td>";
        			
        			$view .= "<td class='core-align-center'><select>";
			
						foreach ($contentCat as $category) {
				
							if ($value['CAP_CON_CAT_ID'] == $category['CAP_CON_CAT_ID']) {
					
							$view .= "<option selected='selected' value='$category[CAP_CON_CAT_ID]'>" . ucwords(strtolower($category['CAP_CON_CAT_NAME'])) . "</option>";
					
							}
							else {
					
							$view .= "<option value='$category[CAP_CON_CAT_ID]'>" . ucwords(strtolower($category['CAP_CON_CAT_NAME'])) . "</option>";
					
							}
								
						}
			
					$view .= "</td></select>";
        			
        			$view .= "<td class='core-align-center'><select>";
	
					$view .= "<option selected='selected' value=''>Select Pages</option>";
	
						foreach ($dataPages as $pages) {
								$template = explode("/",$pages['CAP_PAG_PATH']);
																								
									if ($value['CAP_PAG_ID']  == $pages['CAP_PAG_ID']) {
				
									$view .= "<option selected='selected' value='$pages[CAP_PAG_ID]'> ".$template[3]." - ".$pages[CAP_PAG_NAME]."</option>";
									
									}
									else {
									
									$view .= "<option value='$pages[CAP_PAG_ID]'>".$template[3]." - ".$pages[CAP_PAG_NAME]."</option>";
									
									}
								
						}
	
				$view .= "</select><input type='hidden' name='contentType' value='content'></td>";
				
				$view .= "<td class='core-image-container-tableContentSmall'>$value[CAP_USE_FIRSTNAME]</td>";
				
				$view .= "<td class='core-image-container-tableContentSmall'>".$this->getDomainName($value[CAP_MAI_ID])."<input type='hidden' name='FKID' value='".$value['CAP_LAN_COM_ID']."'></td>";
        		        		
        		$view .= "</tr>";

        	}
        	
        }
       
        $view .= "</tbody>";
        
               
        $view .= "</table>";
        
        $view .= "<input type='submit' class='core-profil-submit' value='Update'>";
        
        $view .= "</div></div></div></div>";
        
    echo $view;
    

    
	}
	
	public function originalEventAdmin($start = null, $perPage = null) {
    
		 if(!empty($this->data)){
          $start = $this->data;
      }
    	$contentList = $this->getContentListEventAdmin($start, $perPage);
    	$count = $this->countTotalOfContent();
    //$contentCat  = $this->getContentCategoryList();
    $perPageSet = 20;
    $dataPages 	 = $this->getPagesList();
    
   
    
     $view .= "<div class='core-image-container'>"; 
      $view .= '<div class="dado-core-file-container">
					<div class="dado-core-file-header">
						<div class="dado-id-float-left">
						<div class="core-container-eventInsideActionButton"><button class="core-button-setCompletedEventAdmin"></button></div>
					</div>
								';
			 			
	$view .='<div class="dado-id-float-right">
						
							<input type="hidden" class="pageAtThisTime" value="0"><input type="hidden" class="totalPage" value="'.ceil($count[0][COUNT]/$perPageSet).'">';
							if(ceil($count[0][COUNT]/$perPageSet) > 1){
		$view .= '
							<div class="core-container-eventInsideActionButton" style="float:left;"><button class="core-button-prev-text qtip-upper" text="Halaman Sebelumnya"></button></div>
							<div class="core-container-eventInsideActionButton" style="float:left;"><button class="core-button-next-text qtip-upper" text="Halaman Selanjutnya"></button></div>';
		}
			$view .= '					</div>';
	$view .= '
					</div>
					<div class="dado-core-file-body" >';
    	
        $view .= "<div class='core-container-eventInside'></div>";
        
        
        
        $view .= "<div class='core-image-container-event'>";
        
        $view .= "<table class='core-image-table table table-hover table-stripped'>";
        
        $view .= "<thead>";
        
        	$view .= "<tr>";
        		
        		$view .= "<td class='core-align-center'>Aksi</td>";
        		
        		$view .= "<td class='core-align-left'>Nama</td>";
        		
        		$view .= "<td class='core-align-center'>Category</td>";
        		
        		$view .= "<td class='core-align-center'>Halaman</td>";
        		
        		$view .= "<td class='core-align-center'>Publisher</td>";
        		        	
        	$view .= "</tr>";
        
        $view .= "</thead>";
        
        $view .= "<tbody>";
        
        if (!empty($contentList)) {
        
        	foreach ($contentList as $key => $value) {
        	        	
        		$view .= "<tr>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall'><input type='hidden' name='contentID' value='$value[CAP_CON_ID]'><span class='core-image-actionDelete'></span><span class='core-image-actionNextEventAdmin'></span></td>";
        			
        			$view .= "<td class='core-image-container-tableContentHuge'>$value[CAP_CON_HEADER]</td>";
        			
        			/*$view .= "<td class='core-align-center'><select>";
			
						foreach ($contentCat as $category) {
				
							if ($value['CAP_CON_CAT_ID'] == $category['CAP_CON_CAT_ID']) {
					
							$view .= "<option selected='selected' value='$category[CAP_CON_CAT_ID]'>" . ucwords(strtolower($category['CAP_CON_CAT_NAME'])) . "</option>";
					
							}
							else {
					
							$view .= "<option value='$category[CAP_CON_CAT_ID]'>" . ucwords(strtolower($category['CAP_CON_CAT_NAME'])) . "</option>";
					
							}
								
						}
			
					$view .= "</td></select>";*/
					
					$view .= "<td class='core-image-container-tableContentSmall core-align-center'>".date('d-m-Y', strtotime($value[CAP_CON_DATEPUBLISHED]));
					
					$view .= "</td>";
        			
        			$view .= "<td class='core-align-center'><select>";
	
					$view .= "<option selected='selected' value=''>Select Pages</option>";
	
						foreach ($dataPages as $pages) {
								$template = explode("/",$pages['CAP_PAG_PATH']);
								
								if ($template[2] == DEFAULT_TEMPLATE) {
								
									if ($value['CAP_PAG_ID']  == $pages['CAP_PAG_ID']) {
				
									$view .= "<option selected='selected' value='$pages[CAP_PAG_ID]'> ".$template[3]." - ".$pages[CAP_PAG_NAME]."</option>";
									
									}
									else {
									
									$view .= "<option value='$pages[CAP_PAG_ID]'>".$template[3]." - ".$pages[CAP_PAG_NAME]."</option>";
									
									}
								
							}
						}
	
				$view .= "</select><input type='hidden' name='contentType' value='content'></td>";
				
				$view .= "<td class='core-image-container-tableContentSmall'>$value[CAP_USE_FIRSTNAME]<input type='hidden' name='FKID' value='".$value['CAP_LAN_COM_ID']."'></td>";
        		        		
        		$view .= "</tr>";

        	}
        	
        }
       
        $view .= "</tbody>";
        
               
        $view .= "</table>";
        
        $view .= "<input type='submit' class='core-profil-submit-event' value='Update'>";
        
        $view .= "</div></div></div></div>";
        
    echo $view;
    

    
	}

	
	
	
	public function contentInsideAdmin() {
	
	$cat   = $this->getContentCategoryList();
	
	
	
	$count = count($this->data);

		if (empty($this->data)) {$this->data = $this->getFileToEditEmpty($this->type[0],$this->type[1]);}
		
		/*$path = explode("/",$this->data[0]['path']);
		
		$path = explode("-",$path[3]);*/
		
		$user = unserialize($_SESSION['user']);
		
		$userID  = $user->getID();
		
		$mainID = $this->data[0]['siteid'];
		
		$view .= "<script>
		
			jQuery('.qtip-upper').qtip({
			content: {
			attr: 'text' // Notice that content.text is long-hand for simply declaring content as a string
			},
			position: {
			my: 'bottom center',  // Position my top left...
			at: 'top center' // at the bottom right of...
			},
			style: {classes: 'ui-tooltip-dark ui-tooltip-shadow'}
			});
			
		</script>";
		
		
		
		$view .= "<input class='core-contentInside-inputOld core-filled-field' type='hidden' value='".$this->data[0]['name']."'>";
		
		$view .= "<div class='core-container-container-top'>";
		
		$view .= "<div class='core-container-container-actionInputField'>";
				
		$view .= "<label for='title'>Title</label>";
						
		$view .= "<input name='title' class='core-contentInside-input core-filled-field' type='text' value='".$this->data[0]['name']."'>";
		
		$view .= "<input class='core-container-container-path' type='hidden' value='".$userID."'>";
		
		$view .= "<input class='core-container-container-mainid' type='hidden' value='".$mainID."'>";
						
		$view .= "</div>";
		
		$view .= "<div class='core-container-container-action'>";
        
		$view .= "<div id='core-container-file-upload'></div>";  
                        
        $view .= "</div>";
        
        $view .= "</div>";

        
        $view .= "<div class='core-container-container-contentInside'>";
        
        $view .= "<input class='core-container-container-idContent' type='hidden' value='".$this->data[0]['id']."'>";
		
		$view .= "<input class='core-container-container-idContentFKID' type='hidden' value='".$this->data[0]['id']."'>";
					
		$view .= "<table class='core-image-table table table-hover table-stripped'>";
        
        $view .= "<thead>";
        
        	$view .= "<tr>";
        		
        		$view .= "<td class='core-align-center'>Aksi</td>";
        		
        		$view .= "<td class='core-align-center'>Nama</td>";
        		
        		//$view .= "<td class='core-align-center'>Klasifikasi</td>";
        		
        		$view .= "<td class='core-align-center'>Link</td>";
        		
        		$view .= "<td class='core-align-center'>Thumbnail</td>";
        		        	
        	$view .= "</tr>";
        
        $view .= "</thead>";
        
        $view .= "<tbody>";
        
        
        if(!empty($this->data)){
	        $loop = $this->getItemToEdit($this->data[0]['id']);
	        if(!empty($loop)){
		        
	        
			      foreach( $loop as $keys => $values){
				        
                $data = model::getJudulDokumen($values['CAP_LAN_COM_ID']);
				        
				        if(empty($values[CAP_LAN_COM_TIME])){
					       	$stateTime = '';
				       	}else{
				       		$totalTime = (strtotime($values[CAP_LAN_COM_TIME]) - strtotime(date('Y-m-d').' 00:00:00'))/86400;
							if($totalTime >7){
								$stateTime = 'core-time-normal';
							}elseif($totalTime < 7 && $totalTime >2){
								$stateTime = 'core-time-warning';
							}elseif($totalTime < 2 && $totalTime >0){
								$stateTime = 'core-time-urgent';
							}else{
								$stateTime = 'core-time-died';
							}
												       	
				       	}
				       	
				        $view .= "<tr class='".$stateTime."'>";
		        			
		        			$view .= "<td class='core-image-container-tableActionHuge core-align-center'><input type='hidden' name='contentID' value='".$values['CAP_LAN_COM_VALUE']."'><input type='hidden' name='FKID' value='".$values['CAP_LAN_COM_ID']."'>
                  <span class='core-image-actionDeleteContent qtip-upper' text='Menghapus Dokumen'></span>
                  <span class='core-image-actionMetaData core-image-metadata qtip-upper' text='Menambahkan Metadata'></span>
                  <span class='core-image-actionTagging core-image-tagging qtip-upper' text='Menambahkan Tagging'></span>
                  <span class='core-image-actionClassification core-image-classification qtip-upper' text='Menambahkan Klasifikasi Dokumen'></span>
                  <span class='core-image-content-actionSetTime qtip-upper' text='Menentukan Retensi Waktu Aktif Dokumen'></span>
                  <span class='core-image-content-actionSetShow qtip-upper' text='Mengubah Visibilitas Dokumen Untuk Publik'></span></td>";
		        			
		        			$view .= "<td class='core-image-container-tableContentHugeContent2'>".$data[0]['CAP_CON_MET_CONTENT']."</td>";
		        			
		        			$view .= "<td class='core-image-container-tableContentSmall core-align-center'><img class='core-image-link' src='../../library/capsule/admin/image/link.png' value='http://".$_SERVER['HTTP_HOST'].APP.$values['CAP_LAN_COM_VALUE']."'/></td>";
		        			
		        			$view .= "<td class='core-align-center'><img class='core-image-thumbnail' text='".APP."library/content/thumb/".htmlspecialchars($values['CAP_LAN_COM_ID']).".png' src='".APP."framework/resize.class.php?src=library/content/thumb/" . $values['CAP_LAN_COM_ID'] . ".png&h=15&w=15&zc=1' alt=''/></td>";	
		        		
		        		$view .= "</tr>";
		
				        
			      }
	        
	        
		     }
		        
		        
        }       
              
        $view .= "</tbody>";
        
        $view .= "<tfoot>";
        	
       	 	$view .= "<tr>";
        		
   	 			$view .= "<td class='core-image-container-tableContent' colspan='4'>
   	 			<div class='core-indikator'>
   	 				<div>
   	 					Keterangan:<br />
   	 				</div>
	   	 			<div>
	   	 				<span class='core-die-indicator'></span>
	   	 				<span>Sudah melewati retensi waktu yang di tentukan</span>
	   	 			</div>
	   	 			<div>
	   	 				<span class='core-urgent-indicator'></span>
	   	 				<span>Retensi waktu kurang dari 2 hari</span>
	   	 			</div>
	   	 			<div>
	   	 				<span class='core-warning-indicator'></span>
	   	 				<span>Retensi waktu kurang dari 7 hari</span>
	   	 			</div><br/>
	   	 			<div>
	   	 				<span class='core-normal-indicator'></span>
	   	 				<span>Retensi waktu lebih dari 7 hari</span>
	   	 			</div>
	   	 		<div>
   	 			</td>";
   	 					   	 					
   	 					   	 					   	 		
   	 		$view .= "</tr>";
   	 		
   	 	$view .= "</tfoot>";
        
        $view .= "</table>";
        
        $view .= "</div>";
		
		$view .= "<div class='core-contentInsideAdmin-action-update'>";
		
		$view .= "<input type='submit' class='core-contentInsideAdmin-back' value='Back' url='".$_SERVER['HTTP_REFERER']."'>&nbsp;&nbsp;";
		
		$view .= "<input type='submit' class='core-contentInside-submit' value='Update'>";
        
        $view .= "</div>";
        		
	echo $view;
	
	}
	
	public function contentInside() {
	
	$cat   = $this->getContentCategoryList();
	$user = unserialize($_SESSION['user']);
		
	$userID  = $user->getID();
	
	$mainID = $this->data[0]['siteid'];
	
	$count = count($this->data);

		if (empty($this->data)) {$this->data = $this->getFileToEditEmpty($this->type[0],$this->type[1]);}
		
		$path = explode("/",$this->data[0]['path']);
		
		$path = explode("-",$path[3]);
		
		$view .= "<script>
		
			jQuery('.qtip-upper').qtip({
			content: {
			attr: 'text' // Notice that content.text is long-hand for simply declaring content as a string
			},
			position: {
			my: 'bottom center',  // Position my top left...
			at: 'top center' // at the bottom right of...
			},
			style: {classes: 'ui-tooltip-dark ui-tooltip-shadow'}
			
			});
						
		</script>";
		
		$view .= "<input class='core-contentInside-inputOld core-filled-field' type='hidden' value='".$this->data[0]['name']."'>";
		
		$view .= "<div class='core-container-container-actionInputField'>";
						
		$view .= "<input class='core-contentInside-input core-filled-field' type='text' value='".$this->data[0]['name']."'>";
		
		$view .= "<input class='core-container-container-path' type='hidden' value='".$userID."'>";		
		
		$view .= "<input class='core-container-container-mainid' type='hidden' value='".$mainID."'>";
						
		$view .= "</div>";
		
		$view .= "<div class='core-container-container-action'>";
        
		$view .= "<div id='core-container-file-upload'></div>";  
                        
        $view .= "</div>";
        
        $view .= "<div class='core-container-container-contentInside'>";
        
        $view .= "<input class='core-container-container-idContent' type='hidden' value='".$this->data[0]['id']."'>";
		
		$view .= "<input class='core-container-container-idContentFKID' type='hidden' value='".$this->data[0]['id']."'>";
					
		$view .= "<table class='core-image-table table table-hover table-stripped'>";
        
        $view .= "<thead>";
        
        	$view .= "<tr>";
        		
        		$view .= "<td class='core-align-center'>Aksi</td>";
        		
        		$view .= "<td class='core-align-center'>Nama</td>";
        		
        		//$view .= "<td class='core-align-center'>Klasifikasi</td>";
        		
        		$view .= "<td class='core-align-center'>Link</td>";
        		
        		$view .= "<td class='core-align-center'>Thumbnail</td>";
        		        	
        	$view .= "</tr>";
        
        $view .= "</thead>";
        
        $view .= "<tbody>";
        
        
        if(!empty($this->data)){
	        $loop = $this->getItemToEdit($this->data[0]['id']);
	        if(!empty($loop)){
		        
	        
			      foreach( $loop as $keys => $values){
				        
                $data = model::getJudulDokumen($values['CAP_LAN_COM_ID']);
				        
				       if(empty($values[CAP_LAN_COM_TIME])){
					       	$stateTime = '';
				       	}else{
				       		$totalTime = (strtotime($values[CAP_LAN_COM_TIME]) - strtotime(date('Y-m-d').' 00:00:00'))/86400;
							if($totalTime >7){
								$stateTime = 'core-time-normal';
							}elseif($totalTime < 7 && $totalTime >2){
								$stateTime = 'core-time-warning';
							}elseif($totalTime < 2 && $totalTime >0){
								$stateTime = 'core-time-urgent';
							}else{
								$stateTime = 'core-time-died';
							}
												       	
				       	}
				       	
				        $view .= "<tr class='".$stateTime."'>";
		        			
		        			$view .= "<td class='core-image-container-tableActionHuge core-align-center'><input type='hidden' name='contentID' value='".$values['CAP_LAN_COM_VALUE']."'><input type='hidden' name='FKID' value='".$values['CAP_LAN_COM_ID']."'>
                  <span class='core-image-actionDeleteContent qtip-upper' text='Menghapus Dokumen'></span>
                  <span class='core-image-actionMetaData core-image-metadata qtip-upper' text='Menambahkan Metadata'></span>
                  <span class='core-image-actionTagging core-image-tagging qtip-upper' text='Menambahkan Tagging'></span>
                  <span class='core-image-actionClassification core-image-classification qtip-upper' text='Menambahkan Klasifikasi Dokumen'></span>
                  <span class='core-image-content-actionSetTime qtip-upper' text='Menentukan Retensi Waktu Aktif Dokumen'></span>
                  <span class='core-image-content-actionSetShow qtip-upper' text='Mengubah Visibilitas Dokumen Untuk Publik'></span></td>";
		        			
		        			$view .= "<td class='core-image-container-tableContentHugeContent2'>".$data[0]['CAP_CON_MET_CONTENT']."</td>";
		        			
		        			$view .= "<td class='core-image-container-tableContentSmall core-align-center'><img class='core-image-link' src='../../library/capsule/admin/image/link.png' value='http://".$_SERVER['HTTP_HOST'].APP.$values['CAP_LAN_COM_VALUE']."'/></td>";
		        			
		        			$view .= "<td class='core-align-center'><img class='core-image-thumbnail' text='".APP."library/content/thumb/".htmlspecialchars($values['CAP_LAN_COM_ID']).".png' src='".APP."framework/resize.class.php?src=library/content/thumb/" . $values['CAP_LAN_COM_ID'] . ".png&h=15&w=15&zc=1' alt=''/></td>";	
		        		
		        		$view .= "</tr>";
		
				        
			      }
	        
	        
		     }
		        
		        
        }       
              
        $view .= "</tbody>";
        
        $view .= "<tfoot>";
        	
       	 	$view .= "<tr>";
        
   	 			$view .= "<td class='core-image-container-tableContent' colspan='4'>
   	 			<div class='core-indikator'>
   	 				<div>
   	 					Keterangan:<br />
   	 				</div>
	   	 			<div>
	   	 				<span class='core-die-indicator'></span>
	   	 				<span>Sudah melewati retensi waktu yang di tentukan</span>
	   	 			</div>
	   	 			<div>
	   	 				<span class='core-urgent-indicator'></span>
	   	 				<span>Retensi waktu kurang dari 2 hari</span>
	   	 			</div>
	   	 			<div>
	   	 				<span class='core-warning-indicator'></span>
	   	 				<span>Retensi waktu kurang dari 7 hari</span>
	   	 			</div><br/>
	   	 			<div>
	   	 				<span class='core-normal-indicator'></span>
	   	 				<span>Retensi waktu lebih dari 7 hari</span>
	   	 			</div>
	   	 		<div>
   	 			</td>";
   	 					   	 					   	 		
   	 		$view .= "</tr>";
   	 		
   	 	$view .= "</tfoot>";
        
        $view .= "</table>";
        
        $view .= "</div>";
		
		$view .= "<div class='core-contentInsideAdmin-action-update'>";
		
		$view .= "<input type='submit' class='core-contentInside-back' value='Back' url='".$_SERVER['HTTP_REFERER']."'>&nbsp;&nbsp;";
		
		$view .= "<input type='submit' class='core-contentInside-submit' value='Update'>";
        
        $view .= "</div>";
        		
	echo $view;
	
	}
	
	public function contentInsidePersonalSites() {
	
	$cat   = $this->getContentCategoryList();
	$user = unserialize($_SESSION['user']);
		
	$userID  = $user->getID();
	$mainID = model::getPersonalSiteID();
	
	$count = count($this->data);

		if (empty($this->data)) {$this->data = $this->getFileToEditEmpty($this->type[0],$this->type[1]);}
		
		$path = explode("/",$this->data[0]['path']);
		
		$path = explode("-",$path[3]);
		
		$view .= "<script>
		
			jQuery('.qtip-upper').qtip({
			content: {
			attr: 'text' // Notice that content.text is long-hand for simply declaring content as a string
			},
			position: {
			my: 'bottom center',  // Position my top left...
			at: 'top center' // at the bottom right of...
			},
			style: {classes: 'ui-tooltip-dark ui-tooltip-shadow'}
			
			});
						
		</script>";
		
		$view .= "<input class='core-contentInside-inputOld core-filled-field' type='hidden' value='".$this->data[0]['name']."'>";
		
		$view .= "<div class='core-container-container-actionInputField'>";
						
		$view .= "<input class='core-contentInside-input core-filled-field' type='text' value='".$this->data[0]['name']."'>";
		
		$view .= "<input class='core-container-container-path' type='hidden' value='".$userID."'>";		
		
		$view .= "<input class='core-container-container-mainid' type='hidden' value='".$mainID."'>";
						
		$view .= "</div>";
		
		$view .= "<div class='core-container-container-action'>";
        
		$view .= "<div id='core-container-file-upload'></div>";  
                        
        $view .= "</div>";
        
        $view .= "<div class='core-container-container-contentInside'>";
        
        $view .= "<input class='core-container-container-idContent' type='hidden' value='".$this->data[0]['id']."'>";
		
		$view .= "<input class='core-container-container-idContentFKID' type='hidden' value='".$this->data[0]['id']."'>";
					
		$view .= "<table class='core-image-table table table-hover table-stripped'>";
        
        $view .= "<thead>";
        
        	$view .= "<tr>";
        		
        		$view .= "<td class='core-align-center'>Aksi</td>";
        		
        		$view .= "<td class='core-align-center'>Nama</td>";
        		
        		//$view .= "<td class='core-align-center'>Klasifikasi</td>";
        		
        		$view .= "<td class='core-align-center'>Link</td>";
        		
        		$view .= "<td class='core-align-center'>Thumbnail</td>";
        		        	
        	$view .= "</tr>";
        
        $view .= "</thead>";
        
        $view .= "<tbody>";
        
        
        if(!empty($this->data)){
	        $loop = $this->getItemToEdit($this->data[0]['id']);
	        if(!empty($loop)){
		        
	        
			      foreach( $loop as $keys => $values){
				        
                $data = model::getJudulDokumen($values['CAP_LAN_COM_ID']);
				        
				       if(empty($values[CAP_LAN_COM_TIME])){
					       	$stateTime = '';
				       	}else{
				       		$totalTime = (strtotime($values[CAP_LAN_COM_TIME]) - strtotime(date('Y-m-d').' 00:00:00'))/86400;
							if($totalTime >7){
								$stateTime = 'core-time-normal';
							}elseif($totalTime < 7 && $totalTime >2){
								$stateTime = 'core-time-warning';
							}elseif($totalTime < 2 && $totalTime >0){
								$stateTime = 'core-time-urgent';
							}else{
								$stateTime = 'core-time-died';
							}
												       	
				       	}
				       	
				        $view .= "<tr class='".$stateTime."'>";
		        			
		        			$view .= "<td class='core-image-container-tableActionHuge core-align-center'><input type='hidden' name='contentID' value='".$values['CAP_LAN_COM_VALUE']."'><input type='hidden' name='FKID' value='".$values['CAP_LAN_COM_ID']."'>
                  <span class='core-image-actionDeleteContent qtip-upper' text='Menghapus Dokumen'></span>
                  <span class='core-image-actionMetaData core-image-metadata qtip-upper' text='Menambahkan Metadata'></span>
                  <span class='core-image-actionTagging core-image-tagging qtip-upper' text='Menambahkan Tagging'></span>
                  <span class='core-image-actionClassification core-image-classification qtip-upper' text='Menambahkan Klasifikasi Dokumen'></span>
                  <span class='core-image-content-actionSetTime qtip-upper' text='Menentukan Retensi Waktu Aktif Dokumen'></span>
                  <span class='core-image-content-actionSetShow qtip-upper' text='Mengubah Visibilitas Dokumen Untuk Publik'></span></td>";
		        			
		        			$view .= "<td class='core-image-container-tableContentHugeContent2'>".$data[0]['CAP_CON_MET_CONTENT']."</td>";
		        			
		        			$view .= "<td class='core-image-container-tableContentSmall core-align-center'><img class='core-image-link' src='../../library/capsule/admin/image/link.png' value='http://".$_SERVER['HTTP_HOST'].APP.$values['CAP_LAN_COM_VALUE']."'/></td>";
		        			
		        			$view .= "<td class='core-align-center'><img class='core-image-thumbnail' text='".APP."library/content/thumb/".htmlspecialchars($values['CAP_LAN_COM_ID']).".png' src='".APP."framework/resize.class.php?src=library/content/thumb/" . $values['CAP_LAN_COM_ID'] . ".png&h=15&w=15&zc=1' alt=''/></td>";	
		        		
		        		$view .= "</tr>";
		
				        
			      }
	        
	        
		     }
		        
		        
        }       
              
        $view .= "</tbody>";
        
        $view .= "<tfoot>";
        	
       	 	$view .= "<tr>";
        
   	 			$view .= "<td class='core-image-container-tableContent' colspan='4'>
   	 			<div class='core-indikator'>
   	 				<div>
   	 					Keterangan:<br />
   	 				</div>
	   	 			<div>
	   	 				<span class='core-die-indicator'></span>
	   	 				<span>Sudah melewati retensi waktu yang di tentukan</span>
	   	 			</div>
	   	 			<div>
	   	 				<span class='core-urgent-indicator'></span>
	   	 				<span>Retensi waktu kurang dari 2 hari</span>
	   	 			</div>
	   	 			<div>
	   	 				<span class='core-warning-indicator'></span>
	   	 				<span>Retensi waktu kurang dari 7 hari</span>
	   	 			</div><br/>
	   	 			<div>
	   	 				<span class='core-normal-indicator'></span>
	   	 				<span>Retensi waktu lebih dari 7 hari</span>
	   	 			</div>
	   	 		<div>
   	 			</td>";
   	 					   	 					   	 		
   	 		$view .= "</tr>";
   	 		
   	 	$view .= "</tfoot>";
        
        $view .= "</table>";
        
        $view .= "</div>";
		
		$view .= "<div class='core-contentInsideAdmin-action-update'>";
		
		$view .= "<input type='submit' class='core-contentInside-back' value='Back' url='".$_SERVER['HTTP_REFERER']."'>&nbsp;&nbsp;";
		
		$view .= "<input type='submit' class='core-contentInside-submit' value='Update'>";
        
        $view .= "</div>";
        		
	echo $view;
	
	}

	
	public function contentInsideContentAdmin() {
	
	//print_r($this->data);

	$cat  = $this->getContentCategoryList();
	
	$dataPages  = $this->pages($this->data[0]['siteid']);
	
	$lag  = $this->language();
	
	$count = count($this->data);

  $publish = $this->data[0][published];
	
	if (!empty($this->data)) {
	
		foreach ($this->data as $key => $value) {
        	
        	if ($value['whoami'] == 'header') {
        	$header  = $value['content'];
        	}
        	else {
        	$content = $value['content'];
        	}
        	
        }
        
    }
        
	
		$view .= "<input class='core-container-container-idContent' type='hidden' value='".$this->data[0]['id']."'>";
		
		$view .= "<input class='core-contentInside-inputOld core-filled-field' type='hidden' value='".$header."'>";
		
		$view .= "<div class='core-container-container-top'>";

		$view .= "<div class='core-container-container-actionInputField'>";
			
			$view .= "<div class=\"core-input-container-left-float\"><label for='category'>Category</label><select name='category' class='core-contentInside-select-publish core-filled-field'>";
			
			$view .= "<option selected='selected' value=''>-- Select Category --</option>";
			
				foreach ($cat as $key => $value) {
				
					if ($this->data[0]['category'] == $value['CAP_CON_CAT_ID']) {
				
					$view .= "<option selected='selected' value='$value[CAP_CON_CAT_ID]'>$value[CAP_CON_CAT_NAME]</option>";
					
					}
					else {
					
					$view .= "<option value='$value[CAP_CON_CAT_ID]'>$value[CAP_CON_CAT_NAME]</option>";
					
					}
				
				}
			
			$view .= "</select></div>";
			
			$view .= "<div class=\"core-input-container-left-float\"><label for='pages'>Pages</label><select name='pages' class='core-contentInside-select-publish core-filled-field'>";
			
			$view .= "<option selected='selected' value=''>-- Select Pages --</option>";
			if(!empty($dataPages)){
				foreach ($dataPages as $pages) {
								$template = explode("/",$pages['CAP_PAG_PATH']);
								
																	if ($this->data[0]['pages']  == $pages['CAP_PAG_ID']) {
				
									$view .= "<option selected='selected' value='$pages[CAP_PAG_ID]'> ".$template[3]." - ".$pages[CAP_PAG_NAME]."</option>";
									
									}
									else {
									
									$view .= "<option value='$pages[CAP_PAG_ID]'>".$template[3]." - ".$pages[CAP_PAG_NAME]."</option>";
									
									}
								
							
						}
			}
			$view .= "</select></div>";
			
			$view .= "<div class=\"core-input-container-left-float\"><label for='language'>Language</label><select name='language' class='core-contentInside-select core-filled-field'>";
			
			$view .= "<option selected='selected' value=''>-- Select Pages --</option>";
			
				foreach ($lag as $key => $value) {
				
					if ($_SESSION[language] == $value['CAP_LAN_ID']) {
				
					$view .= "<option selected='selected' value='$value[CAP_LAN_ID]'>$value[CAP_LAN_NAME]</option>";
					
					}
					else {
					
					$view .= "<option value='$value[CAP_LAN_ID]'>$value[CAP_LAN_NAME]</option>";
					
					}
				
				}
			
			$view .= "</select></div>";
			
			$view .= "<div class=\"core-input-container-left-float\"><label for='publish'>Publish</label><select name='publish' class='core-contentInside-select-publish core-filled-field'>";
				
				$view .= "<option value=''>-- Publish --</option>";
						
						if($publish == 'Y'){
						
						$view .= "<option selected='selected' value='Y'>Yes</option>";
						$view .= "<option value='N'>NO</option>";
						
						}else{
						$view .= "<option value='Y'>YES</option>";
						$view .= "<option selected='selected' value='N'>No</option>";
						
						}
				
			$view .= "</select></div>";
			
				
		$view .= "</div>";
		
		$view .= "<div class='core-container-container-actionInputFieldHeader'>";
		
		$view .= "<label for='title'>Title</label>";

		$view .= "<input name='title' class='core-contentInside-inputContent core-filled-field' type='text' value='".$this->data[0]['name']."'>";
		
		$view .= "</div>";

		//print_r($this->data);

		$view .= "<div class='core-container-container-actionInputFieldHeader'>";
		
		$view .= "<label for='description'>Description</label>";

		$view .= "<input name='description' class='core-contentInside-inputContent core-filled-field' type='text' value='".$this->data[0]['desc']."'>";
		
		$view .= "</div>";

		$view .= "</div>";
        
        $view .= "<div class='core-container-container-contentInside'>";
		
		$view .= "<div id='core-nic-panel'></div>";
		
		$view .= "<div class='core-textarea-container'><textarea id='core-textarea-content'>$content</textarea></div>";
		
        $view .= "</div>";
		
		$view .= "<div class='core-contentInside-action-update'>";
		
		$view .= "<input type='submit' class='core-contentInsideContentAdmin-back' value='Back' url='".$_SERVER['HTTP_REFERER']."'>&nbsp;&nbsp;";
		
		$view .= "<input type='submit' class='core-contentInside-submitContent' value='Update'>";
        
        $view .= "</div>";
        		
	echo $view;
	
	}

		
	public function eventInsideEventAdmin() {
	
	//print_r($this->data);

	//$cat  = $this->getContentCategoryList();
	
	$dataPages  = $this->pages();
	
	$lag  = $this->language();
	
	$count = count($this->data);

  $publish = $this->data[0]['published'];
  
	if (!empty($this->data)) {
	
		foreach ($this->data as $key => $value) {
        	
        	if ($value['whoami'] == 'header') {
        	$header  = $value['content'];
        	}
        	else {
        	$content = $value['content'];
        	}
        	
        }
        
    }
        
	
		$view .= "<input class='core-container-container-idContent' type='hidden' value='".$this->data[0]['id']."'>";
		
		$view .= "<input class='core-contentInside-inputOld core-filled-field' type='hidden' value='".$header."'>";
		
		$view .= "<div class='core-container-container-top'>";

		$view .= "<div class='core-container-container-actionInputField'>";
			
			/*$view .= "<div class=\"core-input-container-left-float\"><label for='category'>Category</label><select name='category' class='core-contentInside-select-publish core-filled-field'>";
			
			$view .= "<option selected='selected' value=''>-- Select Category --</option>";
			
				foreach ($cat as $key => $value) {
				
					if ($this->data[0]['category'] == $value['CAP_CON_CAT_ID']) {
				
					$view .= "<option selected='selected' value='$value[CAP_CON_CAT_ID]'>$value[CAP_CON_CAT_NAME]</option>";
					
					}
					else {
					
					$view .= "<option value='$value[CAP_CON_CAT_ID]'>$value[CAP_CON_CAT_NAME]</option>";
					
					}
				
				}
			
			$view .= "</select></div>";*/
			
			$view .= "<div class=\"core-input-container-left-float\"><label for='pages'>Pages</label><select name='pages' class='core-eventInside-select-publish core-filled-field'>";
			
			$view .= "<option selected='selected' value=''>-- Select Pages --</option>";
			
				foreach ($dataPages as $pages) {
								$template = explode("/",$pages['CAP_PAG_PATH']);
								
								if ($template[2] == DEFAULT_TEMPLATE) {
								
									if ($this->data[0]['pages']  == $pages['CAP_PAG_ID']) {
				
									$view .= "<option selected='selected' value='$pages[CAP_PAG_ID]'> ".$template[3]." - ".$pages[CAP_PAG_NAME]."</option>";
									
									}
									else {
									
									$view .= "<option value='$pages[CAP_PAG_ID]'>".$template[3]." - ".$pages[CAP_PAG_NAME]."</option>";
									
									}
								
							}
						}
			
			$view .= "</select></div>";
			
			$view .= "<div class=\"core-input-container-left-float\"><label for='language'>Language</label><select name='language' class='core-eventInside-select core-filled-field'>";
			
			$view .= "<option selected='selected' value=''>-- Select Language --</option>";
			
				foreach ($lag as $key => $value) {
				
					if ($_SESSION[language] == $value['CAP_LAN_ID']) {
				
					$view .= "<option selected='selected' value='$value[CAP_LAN_ID]'>$value[CAP_LAN_NAME]</option>";
					
					}
					else {
					
					$view .= "<option value='$value[CAP_LAN_ID]'>$value[CAP_LAN_NAME]</option>";
					
					}
				
				}
			
			$view .= "</select></div>";
			
			$view .= "<div class=\"core-input-container-left-float\"><label for='publish'>Publish</label><select name='publish' class='core-eventInside-select-publish core-filled-field'>";
				
				$view .= "<option value=''>-- Publish --</option>";
						
						if($publish == 'Y'){
						
						$view .= "<option selected='selected' value='Y'>Yes</option>";
						$view .= "<option value='N'>NO</option>";
						
						}else{
						$view .= "<option value='Y'>YES</option>";
						$view .= "<option selected='selected' value='N'>No</option>";
						
						}
				
			$view .= "</select></div>";
			
				
		$view .= "</div>";
		
		$view .= "<div class='core-container-container-actionInputFieldHeader'>";
		
		$view .= "<label for='title'>Title</label>";

		$view .= "<input name='title' class='core-eventInside-inputEvent core-filled-field' type='text' value='".$this->data[0]['name']."'>";
		
		$view .= "</div>";

		//print_r($this->data);
		$view .= "<div class='core-container-container-actionInputFieldHeader'>";
		
		$view .= "<label for='title'>Event Date</label>";
		
		$view .= "<input name='title' class='core-eventInside-inputEvent event-date  core-filled-field' type='text' value='".date('d-m-Y', strtotime($this->data[0]['datepublished']))."'>";
		
		$view .= "</div>";

		$view .= "<div class='core-container-container-actionInputFieldHeader'>";
		
		$view .= "<label for='description'>Description</label>";

		$view .= "<input name='description' class='core-eventInside-inputEvent core-filled-field' type='text' value='".$this->data[0]['desc']."'>";
		
		$view .= "</div>";

		$view .= "</div>";
        
        $view .= "<div class='core-container-container-contentInside'>";
		
		$view .= "<div id='core-nic-panel'></div>";
		
		$view .= "<div class='core-textarea-container'><textarea id='core-textarea-event'>$content</textarea></div>";
		
        $view .= "</div>";
		
		$view .= "<div class='core-contentInside-action-update'>";
		
		$view .= "<input type='submit' class='core-eventInsideEventAdmin-back' value='Back' url='".$_SERVER['HTTP_REFERER']."'>&nbsp;&nbsp;";
		
		$view .= "<input type='submit' class='core-eventInside-submitEvent' value='Update'>";
        
        $view .= "</div>";
        		
	echo $view;
	
	}
	
	public function contentInsideAdminNew() {
	
	$cat   = $this->getContentCategoryList();
	
	$count = count($this->data);
	 /**$view .= '<div class="dado-core-file-container">
					<div class="dado-core-file-header">
						<div class="dado-id-float-left">'; */
	 $view .= "<div class='core-container-container-actionInputField'>";
		
		$view .= "<input class='core-contentInside-input core-filled-field' type='text'>";
		
		$view .= "<input class='core-container-container-path' type='hidden' value=''>";
		
		$view .= "</div>";

	/* $view .= '</div>
						
					</div>
					<div class="dado-core-file-body" >'; */
		$view .= "<input type='hidden' class='core-headerOfContentInput' value=''><input type='hidden' class='core-headerOfContentInputTypeOfFile' value='image'><input type='hidden' class='core-typeOfTransaction' value='new'>";
		
				
		$view .= "<div class='core-container-container-action'>";
        
		$view .= "<div id='core-container-file-upload'></div>";  
                        
        $view .= "</div>"; 
             
        $view .= "<div class='core-container-container-contentInside'>";
        
        $view .= "<input class='core-container-container-idContent' type='hidden' value=''>";
		
		$view .= "<table class='core-image-table table table-hover table-stripped'>";
        
        $view .= "<thead>";
        
        	$view .= "<tr>";
        		
        		$view .= "<td class='core-align-center'>Aksi</td>";
        		
        		$view .= "<td class='core-align-left'>Nama</td>";
        		
        		$view .= "<td class='core-align-center'>Link</td>";
        		
        		$view .= "<td class='core-align-center'>Thumbnail</td>";
        		        	
        	$view .= "</tr>";
        
        $view .= "</thead>";
        
        $view .= "<tbody>";
                    
        $view .= "</tbody>";
        
        $view .= "<tfoot>";
        	
       	 	$view .= "<tr>";
        
   	 			$view .= "<td class='core-image-container-tableContent'>&nbsp;</td>";
   	 					   	 					
   	 			$view .= "<td class='core-image-container-tableContent'></td>";
   	 			
   	 			$view .= "<td class='core-image-container-tableContent'></td>";
   	 					
   	 			$view .= "<td class='core-image-container-tableContent'></td>";
   	 					   	 					   	 		
   	 		$view .= "</tr>";
   	 		
   	 	$view .= "</tfoot>";
        
        $view .= "</table>";
        
        $view .= "</div>";
				
		$view .= "<div class='core-contentInside-action-update'>";
		
		$view .= "<input type='submit' class='core-contentInsideAdmin-back' value='Back' value='Back' url='".$_SERVER['HTTP_REFERER']."'>&nbsp;&nbsp;";
		
		$view .= "<input type='submit' class='core-contentInside-submit' value='Create'>";
        
        $view .= "</div>";
       /* $view .= "</div>";
        $view .= "</div>";*/
        
        		
	echo $view;
	
	}
	
	
	
	public function contentTextInsideAdminNew() {
	
	$user = unserialize($_SESSION['user']);
	
	$cat  = $this->getContentCategoryList();
	
	$dataPages  = $this->pages($user->getSiteID());
	
	$lag  = $this->language();

	$count = count($this->data);        
	
	//print_r($dataPages);
	
		$view .= "<input class='core-container-container-idContent' type='hidden' value='".$this->data[0]['id']."'><input type='hidden' class='core-headerOfContentInputTypeOfFile' value='content'>";
		
		$view .= "<input class='core-contentInside-inputOld core-filled-field' type='hidden' value='".$header."'>";
		
		$view .= "<div class='core-container-container-top'>";
		
		$view .= "<div class='core-container-container-actionInputField'>";
		
		$view .= "<div class=\"core-input-container-left-float\"><label for='category'>Category</label><select name='category' class='core-contentInside-select-publish core-filled-field'>";

			
			$view .= "<option selected='selected' value=''>-- Select Category --</option>";
			
				foreach ($cat as $key => $value) {
				
					if ($this->data[0]['category'] == $value['CAP_CON_CAT_ID']) {
				
					$view .= "<option selected='selected' value='$value[CAP_CON_CAT_ID]'>$value[CAP_CON_CAT_NAME]</option>";
					
					}
					else {
					
					$view .= "<option value='$value[CAP_CON_CAT_ID]'>$value[CAP_CON_CAT_NAME]</option>";
					
					}
				
				}
			
			$view .= "</select></div>";
			
			$view .= "<div class=\"core-input-container-left-float\"><label for='pages'>Pages</label><select name='pages' class='core-contentInside-select-publish core-filled-field'>";
			
			$view .= "<option selected='selected' value=''>-- Select Pages --</option>";
			
				foreach ($dataPages as $pages) {
								$template = explode("/",$pages['CAP_PAG_PATH']);
								
								
								
									if ($value['CAP_PAG_ID']  == $pages['CAP_PAG_ID']) {
				
									$view .= "<option selected='selected' value='$pages[CAP_PAG_ID]'> ".$template[3]." - ".$pages[CAP_PAG_NAME]."</option>";
									
									}
									else {
									
									$view .= "<option value='$pages[CAP_PAG_ID]'>".$template[3]." - ".$pages[CAP_PAG_NAME]."</option>";
									
									}
								
							
						}
			
			$view .= "</select></div>";
			
			$view .= "<div class=\"core-input-container-left-float\"><label for='language'>Language</label><select name='language' class='core-contentInside-select core-filled-field'>";
			
			$view .= "<option selected='selected' value=''>-- Select Pages --</option>";
			
				foreach ($lag as $key => $value) {
				
					if ($_SESSION[language] == $value['CAP_LAN_ID']) {
				
					$view .= "<option selected='selected' value='$value[CAP_LAN_ID]'>$value[CAP_LAN_NAME]</option>";
					
					}
					else {
					
					$view .= "<option value='$value[CAP_LAN_ID]'>$value[CAP_LAN_NAME]</option>";
					
					}
				
				}
			
			$view .= "</select></div>";

	 $view .= "<div class=\"core-input-container-left-float\"><label for='publish'>Publish</label><select name='publish' class='core-contentInside-select-publish core-filled-field'>";
        
        $view .= "<option selected='selected' value=''>-- Publish --</option>";
            
            if($value['CAP_CON_PUBLISHED'] == 'Y'){
            
            $view .= "<option selected='selected' value='Y'>Yes</option>";
            $view .= "<option value='N'>NO</option>";
            
            }else{
            $view .= "<option value='Y'>YES</option>";
            $view .= "<option selected='selected' value='N'>No</option>";
            
            }
        
      $view .= "</select></div>";
				
		$view .= "</div>";
		
		$view .= "<div class='core-container-container-actionInputFieldHeader'>";
		
		$view .= "<label for='title'>Title</label>";
		
		$view .= "<input name='title' class='core-contentInside-inputContent core-filled-field' type='text' value='".$this->data[0]['name']."'>";
		
		$view .= "</div>";

		$view .= "<div class='core-container-container-actionInputFieldHeader'>";
		
		$view .= "<label for='description'>Description</label>";

		$view .= "<input name='description' class='core-contentInside-inputContent core-filled-field' type='text' value='".$this->data[0]['desc']."'>";
		
		$view .= "</div>";
		
		$view .= "</div>";
        
        $view .= "<div class='core-container-container-contentInside'>";
		
		$view .= "<div id='core-nic-panel'></div>";
		
		$view .= "<div class='core-textarea-container'><textarea id='core-textarea-content'>$content</textarea></div>";
		
        $view .= "</div>";
		
		$view .= "<div class='core-contentInside-action-update'>";
		
		$view .= "<input type='submit' class='core-contentInsideContentAdmin-back' value='Back' url='".$_SERVER['HTTP_REFERER']."'>&nbsp;&nbsp;";
		
		$view .= "<input type='submit' class='core-contentInside-submitContent' value='Create'>";
        
        $view .= "</div>";
        		
	echo $view;
	
	}
	
	public function eventInsideAdminNew() {
	
	//$cat  = $this->getContentCategoryList();
	
	$dataPages  = $this->pages();
	
	$lag  = $this->language();

	$count = count($this->data);        
	
	//print_r($this->data);
	
		$view .= "<input class='core-container-container-idContent' type='hidden' value='".$this->data[0]['id']."'><input type='hidden' class='core-headerOfContentInputTypeOfFile' value='content'>";
		
		$view .= "<input class='core-eventInside-inputOld core-filled-field' type='hidden' value='".$header."'>";
		
		$view .= "<div class='core-container-container-top'>";
		
		$view .= "<div class='core-container-container-actionInputField'>";
		
		/*$view .= "<div class=\"core-input-container-left-float\"><label for='category'>Category</label><select name='category' class='core-contentInside-select-publish core-filled-field'>";

			
			$view .= "<option selected='selected' value=''>-- Select Category --</option>";
			
				foreach ($cat as $key => $value) {
				
					if ($this->data[0]['category'] == $value['CAP_CON_CAT_ID']) {
				
					$view .= "<option selected='selected' value='$value[CAP_CON_CAT_ID]'>$value[CAP_CON_CAT_NAME]</option>";
					
					}
					else {
					
					$view .= "<option value='$value[CAP_CON_CAT_ID]'>$value[CAP_CON_CAT_NAME]</option>";
					
					}
				
				}
			
			$view .= "</select></div>";*/
			
			$view .= "<div class=\"core-input-container-left-float\"><label for='pages'>Pages</label><select name='pages' class='core-eventInside-select-publish core-filled-field'>";
			
			$view .= "<option selected='selected' value=''>-- Select Pages --</option>";
			
				foreach ($dataPages as $pages) {
				
								$template = explode("/",$pages['CAP_PAG_PATH']);
								
								if ($template[2] == DEFAULT_TEMPLATE) {
								
									if ($value['CAP_PAG_ID']  == $pages['CAP_PAG_ID']) {
				
									$view .= "<option selected='selected' value='$pages[CAP_PAG_ID]'> ".$template[3]." - ".$pages[CAP_PAG_NAME]."</option>";
									
									}
									else {
									
									$view .= "<option value='$pages[CAP_PAG_ID]'>".$template[3]." - ".$pages[CAP_PAG_NAME]."</option>";
									
									}
									
							}
							
						}
			
			$view .= "</select></div>";
			
			$view .= "<div class=\"core-input-container-left-float\"><label for='language'>Language</label><select name='language' class='core-eventInside-select core-filled-field'>";
			
			$view .= "<option selected='selected' value=''>-- Select Pages --</option>";
			
				foreach ($lag as $key => $value) {
				
					if ($_SESSION[language] == $value['CAP_LAN_ID']) {
				
					$view .= "<option selected='selected' value='$value[CAP_LAN_ID]'>$value[CAP_LAN_NAME]</option>";
					
					}
					else {
					
					$view .= "<option value='$value[CAP_LAN_ID]'>$value[CAP_LAN_NAME]</option>";
					
					}
				
				}
			
			$view .= "</select></div>";

	    $view .= "<div class=\"core-input-container-left-float\"><label for='publish'>Publish</label><select name='publish' class='core-eventInside-select-publish core-filled-field'>";
        
        $view .= "<option selected='selected' value=''>-- Publish --</option>";
            
            if($value['CAP_CON_PUBLISHED'] == 'Y'){
            
	            $view .= "<option selected='selected' value='Y'>Yes</option>";
	            $view .= "<option value='N'>NO</option>";
            
            }else{
            
	            $view .= "<option value='Y'>YES</option>";
	            $view .= "<option selected='selected' value='N'>No</option>";
            
            }
        
        $view .= "</select></div>";
				
		$view .= "</div>";
		
		$view .= "<div class='core-container-container-actionInputFieldHeader'>";
		
		$view .= "<label for='title'>Title</label>";
		
		$view .= "<input name='title' class='core-eventInside-inputEvent core-filled-field' type='text' value='".$this->data[0]['name']."'>";
		
		$view .= "</div>";
		
		$view .= "<div class='core-container-container-actionInputFieldHeader'>";
		
		$view .= "<label for='title'>Event Date</label>";
		
		$view .= "<input name='title' class='core-eventInside-inputEvent event-date  core-filled-field' type='text' value='".$this->data[0]['eventDate']."'>";
		
		$view .= "</div>";

		$view .= "<div class='core-container-container-actionInputFieldHeader'>";
		
		$view .= "<label for='description'>Description</label>";

		$view .= "<input name='description' class='core-eventInside-inputEvent core-filled-field' type='text' value='".$this->data[0]['desc']."'>";
		
		$view .= "</div>";
		
		$view .= "</div>";
        
        $view .= "<div class='core-container-container-eventInside'>";
		
		$view .= "<div id='core-nic-panel'></div>";
		
		$view .= "<div class='core-textarea-container'><textarea id='core-textarea-event'>$content</textarea></div>";
		
        $view .= "</div>";
		
		$view .= "<div class='core-eventInside-action-update'>";
		
		$view .= "<input type='submit' class='core-eventInsideEventAdmin-back' value='Back' url='".$_SERVER['HTTP_REFERER']."'>&nbsp;&nbsp;";
		
		$view .= "<input type='submit' class='core-eventInside-submitEvent' value='Create'>";
        
        $view .= "</div>";
        		
	echo $view;
	
	}
	
	public function contentInsideAjaxAdmin() {
		
		$view .= "<script>
		
			jQuery('.qtip-upper').qtip({
			content: {
			attr: 'text' // Notice that content.text is long-hand for simply declaring content as a string
			},
			position: {
			my: 'bottom center',  // Position my top left...
			at: 'top center' // at the bottom right of...
			},
			style: {classes: 'ui-tooltip-dark ui-tooltip-shadow'}
			});
			
		</script>";
		
		 $view .= "<input class='core-container-container-idContent' type='hidden' value='".$this->data[0]['id']."'>";
		 
		 $view .= "<input class='core-container-container-idContentFKID' type='hidden' value='".$this->data[0]['id']."'>";
		
		$view .= "<input class='core-contentInside-inputNew' type='hidden' value='".$this->data[0]['name']."'><input class='core-container-container-idContentAfter' type='hidden' value='".$this->type."'>";
		
		$view .= "<table class='core-image-table table table-hover table-stripped'>";
        
        $view .= "<thead>";
        
        	$view .= "<tr>";
        		
        		$view .= "<td class='core-align-center'>Aksi</td>";
        		
        		$view .= "<td class='core-align-center'>Nama</td>";
        		
        		//$view .= "<td class='core-align-center'>Klasifikasi</td>";
        		
        		$view .= "<td class='core-align-center'>Link</td>";
        		
        		$view .= "<td class='core-align-center'>Thumbnail</td>";
        		        	
        	$view .= "</tr>";
        
        $view .= "</thead>";
        
        $view .= "<tbody>";
        
        
        if(!empty($this->data)){
	        $loop = $this->getItemToEdit($this->data[0]['id']);
	        if(!empty($loop)){
		        
	        
			      foreach( $loop as $keys => $values){
				        
                $data = model::getJudulDokumen($values['CAP_LAN_COM_ID']);
				        
				        if(empty($values[CAP_LAN_COM_TIME])){
					       	$stateTime = '';
				       	}else{
				       		$totalTime = (strtotime($values[CAP_LAN_COM_TIME]) - strtotime(date('Y-m-d').' 00:00:00'))/86400;
							if($totalTime >7){
								$stateTime = 'core-time-normal';
							}elseif($totalTime < 7 && $totalTime >2){
								$stateTime = 'core-time-warning';
							}elseif($totalTime < 2 && $totalTime >0){
								$stateTime = 'core-time-urgent';
							}else{
								$stateTime = 'core-time-died';
							}
												       	
				       	}
				       	
				        $view .= "<tr class='".$stateTime."'>";
		        			
		        			$view .= "<td class='core-image-container-tableActionHuge core-align-center'><input type='hidden' name='contentID' value='".$values['CAP_LAN_COM_VALUE']."'><input type='hidden' name='FKID' value='".$values['CAP_LAN_COM_ID']."'>
                  <span class='core-image-actionDeleteContent qtip-upper' text='Menghapus Dokumen'></span>
                  <span class='core-image-actionMetaData core-image-metadata qtip-upper' text='Menambahkan Metadata'></span>
                  <span class='core-image-actionTagging core-image-tagging qtip-upper' text='Menambahkan Tagging'></span>
                  <span class='core-image-actionClassification core-image-classification qtip-upper' text='Menambahkan Klasifikasi Dokumen'></span>
                  <span class='core-image-content-actionSetTime qtip-upper' text='Menentukan Retensi Waktu Aktif Dokumen'></span>
                  <span class='core-image-content-actionSetShow qtip-upper' text='Mengubah Visibilitas Dokumen Untuk Publik'></span></td>";
		        			
		        			$view .= "<td class='core-image-container-tableContentHugeContent2'>".$data[0]['CAP_CON_MET_CONTENT']."</td>";
		        			
		        			$view .= "<td class='core-image-container-tableContentSmall core-align-center'><img class='core-image-link' src='".APP."library/capsule/admin/image/link.png' value='http://".$_SERVER['HTTP_HOST'].APP.$values['CAP_LAN_COM_VALUE']."'/></td>";
		        			
		        			$view .= "<td class='core-align-center'><img class='core-image-thumbnail' text='".APP."library/content/thumb/".htmlspecialchars($values['CAP_LAN_COM_ID']).".png' src='".APP."framework/resize.class.php?src=library/content/thumb/" . $values['CAP_LAN_COM_ID'] . ".png&h=15&w=15&zc=1' alt=''/></td>";	
		        		
		        		$view .= "</tr>";
		
				        
			      }
	        
	        
		     }
		        
		        
        }       
              
        $view .= "</tbody>";
        
        $view .= "<tfoot>";
        	
       	 	$view .= "<tr>";
        
   	 			$view .= "<td class='core-image-container-tableContent' colspan='4'>
   	 			<div class='core-indikator'>
   	 				<div>
   	 					Keterangan:<br />
   	 				</div>
	   	 			<div>
	   	 				<span class='core-die-indicator'></span>
	   	 				<span>Sudah melewati retensi waktu yang di tentukan</span>
	   	 			</div>
	   	 			<div>
	   	 				<span class='core-urgent-indicator'></span>
	   	 				<span>Retensi waktu kurang dari 2 hari</span>
	   	 			</div>
	   	 			<div>
	   	 				<span class='core-warning-indicator'></span>
	   	 				<span>Retensi waktu kurang dari 7 hari</span>
	   	 			</div><br/>
	   	 			<div>
	   	 				<span class='core-normal-indicator'></span>
	   	 				<span>Retensi waktu lebih dari 7 hari</span>
	   	 			</div>
	   	 		<div>
   	 			</td>";
   	 					   	 					   	 		
   	 		$view .= "</tr>";
   	 		
   	 	$view .= "</tfoot>";
        
        $view .= "</table>";        
        
    echo $view;
	
	}
	
		public function originalContentUser($start = null, $perPage = null) {
      
      if(!empty($this->data)){
          $start = $this->data;
      }

    	foreach ($this->model as $key => $value) {
    
    		if ($key == $this->type) {
    		$headerType = $value; $method = "getContentList".$value."User"; break;
    		}
    
    	}
    
    
    
    $contentList = $this->$method($start, $perPage);
    $count = count($contentList);
    $contentCat  = $this->getContentCategoryList();
    
    $dataPages 	 = $this->getPagesList();
        
    $view .= "<div class='core-image-container'>"; 
     $view .= '<div class="dado-core-file-container">
					<div class="dado-core-file-header" style="position:relative">
						<div class="dado-id-float-left">';
	 $view .= "<div class='core-container-contentInsideActionButton'>";
        
        	
        
       	 	$view .= "<button class='core-button-setCompleted'></button>";
       	 	
       	 	
        
        $view .= "</div>";
	$view .= '</div>
						';
			 		if ($count > 200){	
	$view .='<div class="dado-id-float-right">
						
							<input type="hidden" class="pageAtThisTime" value="0">
							<div class="core-container-contentInsideActionButton" style="float:left;"><button class="coreUser-button-prev qtip-upper" text="Halaman Sebelumnya""></button></div>
							<div class="core-container-contentInsideActionButton" style="float:left;"><button class="coreUser-button-next qtip-upper" text="Halaman Selanjutnya"></button></div>
						</div>';}
	$view .= '
					</div>
					<div class="dado-core-file-body" >'; 
    

    	$view .= "<div class='core-image-container-inside'>".$headerType." Manager <span class='core-headerOfContent'></span><input type='hidden' class='core-headerOfContentInput' value=''><input type='hidden' class='core-headerOfContentInputTypeOfFile' value='".$this->type."'></div>";
    	
        $view .= "<div class='core-container-contentInside'></div>";
        
       
        
        $view .= "<div class='core-image-container-content'>";
        
        $view .= "<table class='core-image-table table table-hover table-stripped'>";
        
        $view .= "<thead>";
        
        	$view .= "<tr>";
        		
        		$view .= "<td class='core-align-center'>Aksi</td>";
        		
        		$view .= "<td class='core-align-left'>Nama</td>";
        		
        		$view .= "<td class='core-align-left'>Publisher</td>";
        		        	
        	$view .= "</tr>";
        
        $view .= "</thead>";
        
        $view .= "<tbody>";
        
        if (!empty($contentList)) {
        
        	foreach ($contentList as $key => $value) {
        	
        		if ($value['CAP_CON_TYP_TYPE'] == $this->type) {
        	
        		$view .= "<tr>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall'><input type='hidden' name='contentID' value='$value[CAP_CON_ID]'><span class='core-image-actionDelete'></span>";
        			        				
        				$view .= "<span class='core-image-actionNextUser'></span></td>";
        				
        				
        			
        			$view .= "<td class='core-image-container-tableContentHuge'>$value[CAP_CON_HEADER]</td>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall'>$value[CAP_USE_FIRSTNAME]</td>";
        			
	        		        		
        		$view .= "</tr>";
        		
        		}
        		else {
        		continue;
        		}
        	
        	}
        	
        }
       
        $view .= "</tbody>";
        
     
        $view .= "</table>";
        
        $view .= "<input type='submit' class='core-profil-submit' value='Update'>";
        
        $view .= "</div></div>";
        
    echo $view;
    
	}
	
	
	
	public function originalTextContentUser() {
    
    	$contentList = $this->getContentListContentUser();
$count = count($contentList);
    $contentCat  = $this->getContentCategoryList();
    
    $dataPages 	 = $this->getPagesList();
    
   
    
     $view .= "<div class='core-image-container'>"; 
      $view .= '<div class="dado-core-file-container">
					<div class="dado-core-file-header">
						<div class="dado-id-float-left">
						<div class="core-container-contentInsideActionButton"><button class="core-button-setCompletedContent"></button></div>
					</div>
						';
			 		if ($count > 200){	
	$view .='<div class="dado-id-float-right">
						
							<input type="hidden" class="pageAtThisTime" value="0">
							<div class="core-container-contentInsideActionButton" style="float:left;"><button class="coreUser-button-prev qtip-upper" text="Halaman Sebelumnya"></button></div>
							<div class="core-container-contentInsideActionButton" style="float:left;"><button class="coreUser-button-next qtip-upper" text="Halaman Selanjutnya"></button></div>
						</div>';}
	$view .= '
					</div>
					<div class="dado-core-file-body" >';

    	$view .= "<div class='core-image-container-inside'>Content Manager <span class='core-headerOfContent'></span><input type='hidden' class='core-headerOfContentInput' value=''><input type='hidden' class='core-headerOfContentInputTypeOfFile' value='content'></div>"; 
    	
        $view .= "<div class='core-container-contentInside'></div>";
        
        
        
        $view .= "<div class='core-image-container-content'>";
        
        $view .= "<table class='core-image-table table table-hover table-stripped'>";
        
        $view .= "<thead>";
        
        	$view .= "<tr>";
        		
        		$view .= "<td class='core-align-center'>Aksi</td>";
        		
        		$view .= "<td class='core-align-left'>Nama</td>";
        		
        		$view .= "<td class='core-align-center'>Category</td>";
        		
        		$view .= "<td class='core-align-center'>Halaman</td>";
        		
        		$view .= "<td class='core-align-center'>Publisher</td>";
        		        	
        	$view .= "</tr>";
        
        $view .= "</thead>";
        
        $view .= "<tbody>";
        
        if (!empty($contentList)) {
        
        	foreach ($contentList as $key => $value) {
        	        	
        		$view .= "<tr>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall'><input type='hidden' name='contentID' value='$value[CAP_CON_ID]'><span class='core-image-actionDelete'></span><span class='core-image-actionNextContent'></span><span class='core-image-actionTagging core-image-tagging qtip-upper' text='Menambahkan Tagging'></span></td>";
        			
        			$view .= "<td class='core-image-container-tableContentHuge'>$value[CAP_CON_HEADER]</td>";
        			
        			$view .= "<td class='core-align-center'><select>";
			
						foreach ($contentCat as $category) {
				
							if ($value['CAP_CON_CAT_ID'] == $category['CAP_CON_CAT_ID']) {
					
							$view .= "<option selected='selected' value='$category[CAP_CON_CAT_ID]'>" . ucwords(strtolower($category['CAP_CON_CAT_NAME'])) . "</option>";
					
							}
							else {
					
							$view .= "<option value='$category[CAP_CON_CAT_ID]'>" . ucwords(strtolower($category['CAP_CON_CAT_NAME'])) . "</option>";
					
							}
								
						}
			
					$view .= "</td></select>";
        			
        			$view .= "<td class='core-align-center'><select>";
	
					$view .= "<option selected='selected' value=''>Select Pages</option>";
	
						foreach ($dataPages as $pages) {
								$template = explode("/",$pages['CAP_PAG_PATH']);
								
								if ($template[2] == DEFAULT_TEMPLATE) {
								
									if ($value['CAP_PAG_ID']  == $pages['CAP_PAG_ID']) {
				
									$view .= "<option selected='selected' value='$pages[CAP_PAG_ID]'> ".$template[3]." - ".$pages[CAP_PAG_NAME]."</option>";
									
									}
									else {
									
									$view .= "<option value='$pages[CAP_PAG_ID]'>".$template[3]." - ".$pages[CAP_PAG_NAME]."</option>";
									
									}
								
							}
						}
	
				$view .= "</select><input type='hidden' name='contentType' value='content'></td>";
				
				$view .= "<td class='core-image-container-tableContentSmall'>$value[CAP_USE_FIRSTNAME]<input type='hidden' name='FKID' value='".$value['CAP_LAN_COM_ID']."'></td>";
        		        		
        		$view .= "</tr>";

        	}
        	
        }
       
        $view .= "</tbody>";
        
               
        $view .= "</table>";
        
        $view .= "<input type='submit' class='core-profil-submit' value='Update'>";
        
        $view .= "</div></div></div></div>";
        
    echo $view;
    

    
	}
	
	

	
	public function contentInsideContentUser() {
	
	//print_r($this->data);

	$cat  = $this->getContentCategoryList();
	
	$dataPages  = $this->pages($this->data[0]['siteid']);
	
	$lag  = $this->language();
	
	$count = count($this->data);

  $publish = $this->data[0][published];
	
	if (!empty($this->data)) {
	
		foreach ($this->data as $key => $value) {
        	
        	if ($value['whoami'] == 'header') {
        	$header  = $value['content'];
        	}
        	else {
        	$content = $value['content'];
        	}
        	
        }
        
    }
        
	
		$view .= "<input class='core-container-container-idContent' type='hidden' value='".$this->data[0]['id']."'>";
		
		$view .= "<input class='core-contentInside-inputOld core-filled-field' type='hidden' value='".$header."'>";
		
		$view .= "<div class='core-container-container-top'>";
		
		$view .= "<div class='core-container-container-actionInputField'>";
				
			$view .= "<select class='core-contentInside-select-category core-filled-field'>";
			
			$view .= "<option selected='selected' value=''>-- Select Category --</option>";
			
				foreach ($cat as $key => $value) {
				
					if ($this->data[0]['category'] == $value['CAP_CON_CAT_ID']) {
				
					$view .= "<option selected='selected' value='$value[CAP_CON_CAT_ID]'>$value[CAP_CON_CAT_NAME]</option>";
					
					}
					else {
					
					$view .= "<option value='$value[CAP_CON_CAT_ID]'>$value[CAP_CON_CAT_NAME]</option>";
					
					}
				
				}
			
			$view .= "</select>";
			
			//print_r($this->data); 
			
			$view .= "<select class='core-contentInside-select-pages core-filled-field'>";
			
			$view .= "<option selected='selected' value=''>-- Select Pages --</option>";
			
				foreach ($dataPages as $pages) {
								$template = explode("/",$pages['CAP_PAG_PATH']);
								
								
									if ($this->data[0]['pages']  == $pages['CAP_PAG_ID']) {
				
									$view .= "<option selected='selected' value='$pages[CAP_PAG_ID]'> ".$template[3]." - ".$pages[CAP_PAG_NAME]."</option>";
									
									}
									else {
									
									$view .= "<option value='$pages[CAP_PAG_ID]'>".$template[3]." - ".$pages[CAP_PAG_NAME]."</option>";
									
									}
								
						}
			
			$view .= "</select>";
			
			$view .= "<select class='core-contentInside-select core-filled-field'>";
			
			$view .= "<option selected='selected' value=''>-- Select Pages --</option>";
			
				foreach ($lag as $key => $value) {
				
					if ($_SESSION[language] == $value['CAP_LAN_ID']) {
				
					$view .= "<option selected='selected' value='$value[CAP_LAN_ID]'>$value[CAP_LAN_NAME]</option>";
					
					}
					else {
					
					$view .= "<option value='$value[CAP_LAN_ID]'>$value[CAP_LAN_NAME]</option>";
					
					}
				
				}
			
			$view .= "</select>";
			
			$view .= "<input type='hidden' value='N' class='core-contentInside-select-publish'>";
			
			/*$view .= "<select class='core-contentInside-select-publish core-filled-field'>";
				
				$view .= "<option value=''>-- Publish --</option>";
						
						if($publish == 'Y'){
						
						$view .= "<option selected='selected' value='Y'>Yes</option>";
						$view .= "<option value='N'>NO</option>";
						
						}else{
						$view .= "<option value='Y'>YES</option>";
						$view .= "<option selected='selected' value='N'>No</option>";
						
						}
				
			$view .= "</select>";*/
			
				
		$view .= "</div>";
		
		$view .= "<div class='core-container-container-actionInputFieldHeader'>";
		
		$view .= "<label for='title'>Title</label>";

		$view .= "<input name='title' class='core-contentInside-inputContent core-filled-field' type='text' value='".$this->data[0]['name']."'>";
		
		$view .= "</div>";

		//print_r($this->data);

		$view .= "<div class='core-container-container-actionInputFieldHeader'>";
		
		$view .= "<label for='description'>Description</label>";

		$view .= "<input name='description' class='core-contentInside-inputContent core-filled-field' type='text' value='".$this->data[0]['desc']."'>";
		
		$view .= "</div>";

        
        $view .= "</div>";
        
        $view .= "<div class='core-container-container-contentInside'>";
		
		$view .= "<div id='core-nic-panel'></div>";
		
		$view .= "<div class='core-textarea-container'><textarea id='core-textarea-content'>$content</textarea></div>";
		
        $view .= "</div>";
		
		$view .= "<div class='core-contentInside-action-update'>";
		
		$view .= "<input type='submit' class='core-contentInsideContent-back' value='Back' url='".$_SERVER['HTTP_REFERER']."'>&nbsp;&nbsp;";
		
		$view .= "<input type='submit' class='core-contentInside-submitContent' value='Update'>";
        
        $view .= "</div>";
        		
	echo $view;
	
	}

		
	
	
	public function contentInsideUserNew() {
	
	$cat   = $this->getContentCategoryList();
	
	$mainID = model::getUserSiteID();
	
	$count = count($this->data);
	 /**$view .= '<div class="dado-core-file-container">
					<div class="dado-core-file-header">
						<div class="dado-id-float-left">'; */
	 $view .= "<div class='core-container-container-actionInputField'>";
		
		$view .= "<input class='core-contentInside-input core-filled-field' type='text'>";
		
		$view .= "<input class='core-container-container-path' type='hidden' value=''>";
		
		$view .= "<input class='core-container-container-mainid' type='hidden' value='".$mainID."'>";
		
		$view .= "</div>";

	/* $view .= '</div>
						
					</div>
					<div class="dado-core-file-body" >'; */
		$view .= "<input type='hidden' class='core-headerOfContentInput' value=''><input type='hidden' class='core-headerOfContentInputTypeOfFile' value='image'><input type='hidden' class='core-typeOfTransaction' value='new'>";
		
				
		$view .= "<div class='core-container-container-action'>";
        
		$view .= "<div id='core-container-file-upload'></div>";  
                        
        $view .= "</div>";
        
        $view .= "<div class='core-container-container-contentInside'>";
        
        $view .= "<input class='core-container-container-idContent' type='hidden' value=''>";
		
		$view .= "<table class='core-image-table table table-hover table-stripped'>";
        
        $view .= "<thead>";
        
        	$view .= "<tr>";
        		
        		$view .= "<td class='core-align-center'>Aksi</td>";
        		
        		$view .= "<td class='core-align-left'>Nama</td>";
        		
        		$view .= "<td class='core-align-center'>Link</td>";
        		
        		$view .= "<td class='core-align-center'>Thumbnail</td>";
        		        	
        	$view .= "</tr>";
        
        $view .= "</thead>";
        
        $view .= "<tbody>";
                    
        $view .= "</tbody>";
        
        $view .= "<tfoot>";
        	
       	 	$view .= "<tr>";
        
   	 			$view .= "<td class='core-image-container-tableContent'>&nbsp;</td>";
   	 					   	 					
   	 			$view .= "<td class='core-image-container-tableContent'></td>";
   	 			
   	 			$view .= "<td class='core-image-container-tableContent'></td>";
   	 					
   	 			$view .= "<td class='core-image-container-tableContent'></td>";
   	 					   	 					   	 		
   	 		$view .= "</tr>";
   	 		
   	 	$view .= "</tfoot>";
        
        $view .= "</table>";
        
        $view .= "</div>";
				
		$view .= "<div class='core-contentInside-action-update'>";
		
		$view .= "<input type='submit' class='core-contentInside-back' value='Back' value='Back' url='".$_SERVER['HTTP_REFERER']."'>&nbsp;&nbsp;";
		
		$view .= "<input type='submit' class='core-contentInside-submitUser' value='Create'>";
        
        $view .= "</div>";
       /* $view .= "</div>";
        $view .= "</div>";*/
        
        		
	echo $view;
	
	}
	
	
	public function contentInsidePersonalNew() {
	
	$cat   = $this->getContentCategoryList();
	
	$mainID = model::getPersonalSiteID();
	
	$count = count($this->data);
	 /**$view .= '<div class="dado-core-file-container">
					<div class="dado-core-file-header">
						<div class="dado-id-float-left">'; */
	 $view .= "<div class='core-container-container-actionInputField'>";
		
		$view .= "<input class='core-contentInside-input core-filled-field' type='text'>";
		
		$view .= "<input class='core-container-container-path' type='hidden' value=''>";
		
		$view .= "<input class='core-container-container-mainid' type='hidden' value='".$mainID."'>";
		
		$view .= "</div>";

	/* $view .= '</div>
						
					</div>
					<div class="dado-core-file-body" >'; */
		$view .= "<input type='hidden' class='core-headerOfContentInput' value=''><input type='hidden' class='core-headerOfContentInputTypeOfFile' value='image'><input type='hidden' class='core-typeOfTransaction' value='new'>";
		
				
		$view .= "<div class='core-container-container-action'>";
        
		$view .= "<div id='core-container-file-upload'></div>";  
                        
        $view .= "</div>";
        
        $view .= "<div class='core-container-container-contentInside'>";
        
        $view .= "<input class='core-container-container-idContent' type='hidden' value=''>";
		
		$view .= "<table class='core-image-table table table-hover table-stripped'>";
        
        $view .= "<thead>";
        
        	$view .= "<tr>";
        		
        		$view .= "<td class='core-align-center'>Aksi</td>";
        		
        		$view .= "<td class='core-align-left'>Nama</td>";
        		
        		$view .= "<td class='core-align-center'>Link</td>";
        		
        		$view .= "<td class='core-align-center'>Thumbnail</td>";
        		        	
        	$view .= "</tr>";
        
        $view .= "</thead>";
        
        $view .= "<tbody>";
                    
        $view .= "</tbody>";
        
        $view .= "<tfoot>";
        	
       	 	$view .= "<tr>";
        
   	 			$view .= "<td class='core-image-container-tableContent'>&nbsp;</td>";
   	 					   	 					
   	 			$view .= "<td class='core-image-container-tableContent'></td>";
   	 			
   	 			$view .= "<td class='core-image-container-tableContent'></td>";
   	 					
   	 			$view .= "<td class='core-image-container-tableContent'></td>";
   	 					   	 					   	 		
   	 		$view .= "</tr>";
   	 		
   	 	$view .= "</tfoot>";
        
        $view .= "</table>";
        
        $view .= "</div>";
				
		$view .= "<div class='core-contentInside-action-update'>";
		
		$view .= "<input type='submit' class='core-contentInside-back' value='Back' value='Back' url='".$_SERVER['HTTP_REFERER']."'>&nbsp;&nbsp;";
		
		$view .= "<input type='submit' class='core-contentInside-submitUser' value='Create'>";
        
        $view .= "</div>";
       /* $view .= "</div>";
        $view .= "</div>";*/
        
        		
	echo $view;
	
	}

	
	public function contentTextInsideUserNew() {
			
	$cat  = $this->getContentCategoryList();
	
	$dataPages  = $this->pages($this->getUserSiteID());
		
	$lag  = $this->language();

	$count = count($this->data);        
	
	$view .= "<input class='core-container-container-idContent' type='hidden' value='".$this->data[0]['id']."'><input type='hidden' class='core-headerOfContentInputTypeOfFile' value='content'>";
		
		$view .= "<input class='core-contentInside-inputOld core-filled-field' type='hidden' value='".$header."'>";
		
		$view .= "<div class='core-container-container-top'>";
		
		$view .= "<div class='core-container-container-actionInputField'>";
				
			$view .= "<select class='core-contentInside-select core-filled-field'>";
			
			$view .= "<option selected='selected' value=''>-- Select Category --</option>";
			
				foreach ($cat as $key => $value) {
				
					if ($this->data[0]['category'] == $value['CAP_CON_CAT_ID']) {
				
					$view .= "<option selected='selected' value='$value[CAP_CON_CAT_ID]'>$value[CAP_CON_CAT_NAME]</option>";
					
					}
					else {
					
					$view .= "<option value='$value[CAP_CON_CAT_ID]'>$value[CAP_CON_CAT_NAME]</option>";
					
					}
				
				}
			
			$view .= "</select>";
			
			$view .= "<select class='core-contentInside-select core-filled-field'>";
			
			$view .= "<option selected='selected' value=''>-- Select Pages --</option>";
			
				foreach ($dataPages as $pages) {
								$template = explode("/",$pages['CAP_PAG_PATH']);
								
								
									if ($value['CAP_PAG_ID']  == $pages['CAP_PAG_ID']) {
				
									$view .= "<option selected='selected' value='$pages[CAP_PAG_ID]'> ".$template[3]." - ".$pages[CAP_PAG_NAME]."</option>";
									
									}
									else {
									
									$view .= "<option value='$pages[CAP_PAG_ID]'>".$template[3]." - ".$pages[CAP_PAG_NAME]."</option>";
									
									}
								
						}
			
			$view .= "</select>";
			
			$view .= "<select class='core-contentInside-select core-filled-field'>";
			
			$view .= "<option selected='selected' value=''>-- Select Pages --</option>";
			
				foreach ($lag as $key => $value) {
				
					if ($_SESSION[language] == $value['CAP_LAN_ID']) {
				
					$view .= "<option selected='selected' value='$value[CAP_LAN_ID]'>$value[CAP_LAN_NAME]</option>";
					
					}
					else {
					
					$view .= "<option value='$value[CAP_LAN_ID]'>$value[CAP_LAN_NAME]</option>";
					
					}
				
				}
			
			$view .= "</select>";
			$view .= "<input class='core-contentInside-inputContent' type='hidden' value='N' />";
     /* $view .= "<select class='core-contentInside-select core-filled-field'>";
        
        $view .= "<option selected='selected' value=''>-- Publish --</option>";
            
            if($value['CAP_CON_PUBLISHED'] == 'Y'){
            
            $view .= "<option selected='selected' value='Y'>Yes</option>";
            $view .= "<option value='N'>NO</option>";
            
            }else{
            $view .= "<option value='Y'>YES</option>";
            $view .= "<option selected='selected' value='N'>No</option>";
            
            }
        
      $view .= "</select>";*/
				
		$view .= "</div>";
		
		$view .= "<div class='core-container-container-actionInputFieldHeader'>";
		
		$view .= "<label for='title'>Title</label>";
		
		$view .= "<input name='title' class='core-contentInside-inputContent core-filled-field' type='text' value='".$this->data[0]['name']."'>";
		
		$view .= "</div>";

		$view .= "<div class='core-container-container-actionInputFieldHeader'>";
		
		$view .= "<label for='description'>Description</label>";

		$view .= "<input name='description' class='core-contentInside-inputContent core-filled-field' type='text' value='".$this->data[0]['desc']."'>";
		
		$view .= "</div>";
		
		$view .= "</div>";
        
        $view .= "<div class='core-container-container-contentInside'>";
		
		$view .= "<div id='core-nic-panel'></div>";
		
		$view .= "<div class='core-textarea-container'><textarea id='core-textarea-content'>$content</textarea></div>";
		
        $view .= "</div>";
		
		$view .= "<div class='core-contentInside-action-update'>";
		
		$view .= "<input type='submit' class='core-contentInsideContent-back' value='Back' url='".$_SERVER['HTTP_REFERER']."'>&nbsp;&nbsp;";
		
		$view .= "<input type='submit' class='core-contentInside-submitContent' value='Create'>";
        
        $view .= "</div>";
        		
	echo $view;
	
	}
	
	
	public function contentInsideContentPersonalSites() {
	
	//print_r($this->data);

	$cat  = $this->getContentCategoryList();
	
	$dataPages  = $this->pages($this->data[0]['siteid']);
	
	$lag  = $this->language();
	
	$count = count($this->data);

  $publish = $this->data[0][published];
	
	if (!empty($this->data)) {
	
		foreach ($this->data as $key => $value) {
        	
        	if ($value['whoami'] == 'header') {
        	$header  = $value['content'];
        	}
        	else {
        	$content = $value['content'];
        	}
        	
        }
        
    }
        
	
		$view .= "<input class='core-container-container-idContent' type='hidden' value='".$this->data[0]['id']."'>";
		
		$view .= "<input class='core-contentInside-inputOld core-filled-field' type='hidden' value='".$header."'>";
		
		$view .= "<div class='core-container-container-top'>";
		
		$view .= "<div class='core-container-container-actionInputField'>";
				
			$view .= "<select class='core-contentInside-select-category core-filled-field'>";
			
			$view .= "<option selected='selected' value=''>-- Select Category --</option>";
			
				foreach ($cat as $key => $value) {
				
					if ($this->data[0]['category'] == $value['CAP_CON_CAT_ID']) {
				
					$view .= "<option selected='selected' value='$value[CAP_CON_CAT_ID]'>$value[CAP_CON_CAT_NAME]</option>";
					
					}
					else {
					
					$view .= "<option value='$value[CAP_CON_CAT_ID]'>$value[CAP_CON_CAT_NAME]</option>";
					
					}
				
				}
			
			$view .= "</select>";
			
			//print_r($this->data); 
			
			$view .= "<select class='core-contentInside-select-pages core-filled-field'>";
			
			$view .= "<option selected='selected' value=''>-- Select Pages --</option>";
			
				foreach ($dataPages as $pages) {
								$template = explode("/",$pages['CAP_PAG_PATH']);
								
								
									if ($this->data[0]['pages']  == $pages['CAP_PAG_ID']) {
				
									$view .= "<option selected='selected' value='$pages[CAP_PAG_ID]'> ".$template[3]." - ".$pages[CAP_PAG_NAME]."</option>";
									
									}
									else {
									
									$view .= "<option value='$pages[CAP_PAG_ID]'>".$template[3]." - ".$pages[CAP_PAG_NAME]."</option>";
									
									}
								
						}
			
			$view .= "</select>";
			
			$view .= "<select class='core-contentInside-select core-filled-field'>";
			
			$view .= "<option selected='selected' value=''>-- Select Pages --</option>";
			
				foreach ($lag as $key => $value) {
				
					if ($_SESSION[language] == $value['CAP_LAN_ID']) {
				
					$view .= "<option selected='selected' value='$value[CAP_LAN_ID]'>$value[CAP_LAN_NAME]</option>";
					
					}
					else {
					
					$view .= "<option value='$value[CAP_LAN_ID]'>$value[CAP_LAN_NAME]</option>";
					
					}
				
				}
			
			$view .= "</select>";
			
			$view .= "<input type='hidden' value='N' class='core-contentInside-select-publish'>";
			
			/*$view .= "<select class='core-contentInside-select-publish core-filled-field'>";
				
				$view .= "<option value=''>-- Publish --</option>";
						
						if($publish == 'Y'){
						
						$view .= "<option selected='selected' value='Y'>Yes</option>";
						$view .= "<option value='N'>NO</option>";
						
						}else{
						$view .= "<option value='Y'>YES</option>";
						$view .= "<option selected='selected' value='N'>No</option>";
						
						}
				
			$view .= "</select>";*/
			
				
		$view .= "</div>";
		
		$view .= "<div class='core-container-container-actionInputFieldHeader'>";
		
		$view .= "<label for='title'>Title</label>";

		$view .= "<input name='title' class='core-contentInside-inputContent core-filled-field' type='text' value='".$this->data[0]['name']."'>";
		
		$view .= "</div>";

		//print_r($this->data);

		$view .= "<div class='core-container-container-actionInputFieldHeader'>";
		
		$view .= "<label for='description'>Description</label>";

		$view .= "<input name='description' class='core-contentInside-inputContent core-filled-field' type='text' value='".$this->data[0]['desc']."'>";
		
		$view .= "</div>";

        
        $view .= "</div>";
        
        $view .= "<div class='core-container-container-contentInside'>";
		
		$view .= "<div id='core-nic-panel'></div>";
		
		$view .= "<div class='core-textarea-container'><textarea id='core-textarea-content'>$content</textarea></div>";
		
        $view .= "</div>";
		
		$view .= "<div class='core-contentInside-action-update'>";
		
		$view .= "<input type='submit' class='core-contentInsideContent-back' value='Back' url='".$_SERVER['HTTP_REFERER']."'>&nbsp;&nbsp;";
		
		$view .= "<input type='submit' class='core-contentInside-submitContent' value='Update'>";
        
        $view .= "</div>";
        		
	echo $view;
	
	}
	
	
	public function contentTextInsidePersonalSitesNew() {
			
	$cat  = $this->getContentCategoryList();
	
	$siteID = model::getPersonalSiteID();
	
	$dataPages  = $this->pages($this->getPersonalSiteID());
		
	$lag  = $this->language();

	$count = count($this->data);        
	
	$view .= "<input class='core-container-container-idContent' type='hidden' value='".$this->data[0]['id']."'><input class='core-container-container-siteID' type='hidden' value='".$siteID."'><input type='hidden' class='core-headerOfContentInputTypeOfFile' value='content'>";
		
		$view .= "<input class='core-contentInside-inputOld core-filled-field' type='hidden' value='".$header."'>";
		
		$view .= "<div class='core-container-container-top'>";
		
		$view .= "<div class='core-container-container-actionInputField'>";
				
			$view .= "<select class='core-contentInside-select core-filled-field'>";
			
			$view .= "<option selected='selected' value=''>-- Select Category --</option>";
			
				foreach ($cat as $key => $value) {
				
					if ($this->data[0]['category'] == $value['CAP_CON_CAT_ID']) {
				
					$view .= "<option selected='selected' value='$value[CAP_CON_CAT_ID]'>$value[CAP_CON_CAT_NAME]</option>";
					
					}
					else {
					
					$view .= "<option value='$value[CAP_CON_CAT_ID]'>$value[CAP_CON_CAT_NAME]</option>";
					
					}
				
				}
			
			$view .= "</select>";
			
			$view .= "<select class='core-contentInside-select core-filled-field'>";
			
			$view .= "<option selected='selected' value=''>-- Select Pages --</option>";
			
				foreach ($dataPages as $pages) {
								$template = explode("/",$pages['CAP_PAG_PATH']);
								
								
									if ($value['CAP_PAG_ID']  == $pages['CAP_PAG_ID']) {
				
									$view .= "<option selected='selected' value='$pages[CAP_PAG_ID]'> ".$template[3]." - ".$pages[CAP_PAG_NAME]."</option>";
									
									}
									else {
									
									$view .= "<option value='$pages[CAP_PAG_ID]'>".$template[3]." - ".$pages[CAP_PAG_NAME]."</option>";
									
									}
								
						}
			
			$view .= "</select>";
			
			$view .= "<select class='core-contentInside-select core-filled-field'>";
			
			$view .= "<option selected='selected' value=''>-- Select Pages --</option>";
			
				foreach ($lag as $key => $value) {
				
					if ($_SESSION[language] == $value['CAP_LAN_ID']) {
				
					$view .= "<option selected='selected' value='$value[CAP_LAN_ID]'>$value[CAP_LAN_NAME]</option>";
					
					}
					else {
					
					$view .= "<option value='$value[CAP_LAN_ID]'>$value[CAP_LAN_NAME]</option>";
					
					}
				
				}
			
			$view .= "</select>";
			$view .= "<input class='core-contentInside-inputContent' type='hidden' value='N' />";
     /* $view .= "<select class='core-contentInside-select core-filled-field'>";
        
        $view .= "<option selected='selected' value=''>-- Publish --</option>";
            
            if($value['CAP_CON_PUBLISHED'] == 'Y'){
            
            $view .= "<option selected='selected' value='Y'>Yes</option>";
            $view .= "<option value='N'>NO</option>";
            
            }else{
            $view .= "<option value='Y'>YES</option>";
            $view .= "<option selected='selected' value='N'>No</option>";
            
            }
        
      $view .= "</select>";*/
				
		$view .= "</div>";
		
		$view .= "<div class='core-container-container-actionInputFieldHeader'>";
		
		$view .= "<label for='title'>Title</label>";
		
		$view .= "<input name='title' class='core-contentInside-inputContent core-filled-field' type='text' value='".$this->data[0]['name']."'>";
		
		$view .= "</div>";

		$view .= "<div class='core-container-container-actionInputFieldHeader'>";
		
		$view .= "<label for='description'>Description</label>";

		$view .= "<input name='description' class='core-contentInside-inputContent core-filled-field' type='text' value='".$this->data[0]['desc']."'>";
		
		$view .= "</div>";
		
		$view .= "</div>";
        
        $view .= "<div class='core-container-container-contentInside'>";
		
		$view .= "<div id='core-nic-panel'></div>";
		
		$view .= "<div class='core-textarea-container'><textarea id='core-textarea-content'>$content</textarea></div>";
		
        $view .= "</div>";
		
		$view .= "<div class='core-contentInside-action-update'>";
		
		$view .= "<input type='submit' class='core-contentInsideContentPersonal-back' value='Back' url='".$_SERVER['HTTP_REFERER']."'>&nbsp;&nbsp;";
		
		$view .= "<input type='submit' class='core-contentInside-submitContentPersonal' value='Create'>";
        
        $view .= "</div>";
        		
	echo $view;
	
	}
		
	public function contentInsideAjaxUser() {

		
		 $view .= "<input class='core-container-container-idContent' type='hidden' value='".$this->data[0]['id']."'>";
		 
		 $view .= "<input class='core-container-container-idContentFKID' type='hidden' value='".$this->data[0]['id']."'>";
		
		$view .= "<input class='core-contentInside-inputNew' type='hidden' value='".$this->data[0]['name']."'><input class='core-container-container-idContentAfter' type='hidden' value='".$this->type."'>";
		
		$view .= "<table class='core-image-table table table-hover table-stripped'>";
        
        $view .= "<thead>";
        
        	$view .= "<tr>";
        		
        		$view .= "<td class='core-image-container-tableContent' colspan='4'>
   	 			<div class='core-indikator'>
   	 				<div>
   	 					Keterangan:<br />
   	 				</div>
	   	 			<div>
	   	 				<span class='core-die-indicator'></span>
	   	 				<span>Sudah melewati retensi waktu yang di tentukan</span>
	   	 			</div>
	   	 			<div>
	   	 				<span class='core-urgent-indicator'></span>
	   	 				<span>Retensi waktu kurang dari 2 hari</span>
	   	 			</div>
	   	 			<div>
	   	 				<span class='core-warning-indicator'></span>
	   	 				<span>Retensi waktu kurang dari 7 hari</span>
	   	 			</div><br/>
	   	 			<div>
	   	 				<span class='core-normal-indicator'></span>
	   	 				<span>Retensi waktu lebih dari 7 hari</span>
	   	 			</div>
	   	 		<div>
   	 			</td>";
        		        	
        	$view .= "</tr>";
        
        $view .= "</thead>";
        
        $view .= "<tbody>";
        
        
        if(!empty($this->data)){
	        $loop = $this->getItemToEdit($this->data[0]['id']);
	        if(!empty($loop)){
		        
	        
	        foreach( $loop as $keys => $values){
		        
                $data = model::getJudulDokumen($values['CAP_LAN_COM_ID']);
		                       
                if(empty($values[CAP_LAN_COM_TIME])){
					       	$stateTime = '';
				       	}else{
				       		$totalTime = (strtotime($values[CAP_LAN_COM_TIME]) - strtotime(date('Y-m-d').' 00:00:00'))/86400;
							if($totalTime >7){
								$stateTime = 'core-time-normal';
							}elseif($totalTime < 7 && $totalTime >2){
								$stateTime = 'core-time-warning';
							}elseif($totalTime < 2 && $totalTime >0){
								$stateTime = 'core-time-urgent';
							}else{
								$stateTime = 'core-time-died';
							}
												       	
				       	}
				       	
				        $view .= "<tr class='".$stateTime."'>";
                  
                  $view .= "<td class='core-image-container-tableContentSmall core-align-center'><input type='hidden' name='contentID' value='".$values['CAP_LAN_COM_VALUE']."'><input type='hidden' name='FKID' value='".$values['CAP_LAN_COM_ID']."'><span class='core-image-actionDeleteContent'></span><span class='core-image-actionMetaData core-image-metadata'></span><span class='core-image-actionTagging core-image-tagging'></span><span class='core-image-actionClassification core-image-classification'></span></td>";
                  
                  $view .= "<td class='core-image-container-tableContentHugeContent2'>".$data[0]['CAP_CON_MET_CONTENT']."</td>";
                  
                  $view .= "<td class='core-image-container-tableContentSmall core-align-center'><img class='core-image-link' src='library/capsule/admin/image/link.png' value='http://".$_SERVER['HTTP_HOST'].APP.$values['CAP_LAN_COM_VALUE']."'/></td>";
                  
                  $view .= "<td class='core-align-center'><img class='core-image-thumbnail' text='library/content/thumb/".htmlspecialchars($values['CAP_LAN_COM_ID']).".jpg' src='framework/resize.class.php?src=library/content/thumb/" . $values['CAP_LAN_COM_ID'] . ".jpg&h=15&w=15&zc=1' alt=''/></td>";  
                
                $view .= "</tr>";

		        
	        }
	        
	        
        }
        }

        

        /*if (!empty($this->data)) {
        
        	foreach ($this->data as $key => $value) {
        	
        	$ext = pathinfo($value['path'], PATHINFO_DIRNAME)."/".pathinfo($value['path'], PATHINFO_FILENAME)."."."jpg";
        	
        	$rootCheck = explode("/",$value['path']); //print_r($rootCheck);
        	
        		if (!empty($rootCheck[4]) && $rootCheck[4] != '.' && $rootCheck[4] != '..') {
        	
        		$view .= "<tr>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall core-align-center'><input type='hidden' name='contentID' value='".htmlspecialchars($value[path],ENT_QUOTES)."'><input type='hidden' name='FKID' value='".$itemData."'><span class='core-image-actionDeleteContent'></span><span class='core-image-actionMetaData core-image-metadata'></td>";
        			
        			$view .= "<td class='core-image-container-tableContentHugeContent2'>".pathinfo($value['path'], PATHINFO_FILENAME)."</td>";
        			
        			$view .= "<td class='core-image-container-tableContentSmall core-align-center'><img class='core-image-link' src='library/capsule/admin/image/link.png' value='http://".$_SERVER['HTTP_HOST'].APP.$value[path]."'/></td>";
        			
        			$view .= "<td class='core-align-center'>"."<img src='framework/resize.class.php?src=" . $value['path'] . "&h=15&w=15&zc=1' alt=''/></td>";
        									        			        		        		
        		$view .= "</tr>";
        	
        		}
        	
        	}
        	
        }*/
       
        $view .= "</tbody>";
        
        $view .= "<tfoot>";
        	
       	 	$view .= "<tr>";
        
   	 			$view .= "<td class='core-image-container-tableContent'>&nbsp;</td>";
   	 					   	 					
   	 			$view .= "<td class='core-image-container-tableContent'></td>";
   	 			
   	 			$view .= "<td class='core-image-container-tableContent'></td>";
   	 					
   	 			$view .= "<td class='core-image-container-tableContent'></td>";
   	 					   	 					   	 		
   	 		$view .= "</tr>";
   	 		
   	 	$view .= "</tfoot>";
        
        $view .= "</table>";
        
        
    echo $view;
	
	}
	
	public function displayMetadata($data,$realPath,$idData) {
	
	
	
	$view .= "<input class='core-metadata-deleter-meta' type='hidden'>";
	
	$view .= "<table class='core-administrator-content-metadata'>";
	
	$view .= "<thead>";
	
	$view .= "<tr><td colspan=2><span style='font-weight:bold'>Content Metadata</span></td><td class='core-administrator-action'><img class='core-administrator-itemDetailAdder' src='library/images/add.png'><img class='core-administrator-itemDetailDeler' src='library/images/del.png'></td></tr>";
	
	$view .= "<tr><td colspan=3><hr></td></tr>";
	
	$view .= "</thead>";
	
	$view .= "<tbody>";
		
		if (empty($data)) {
				
		$view .= "<tr>";
		$view .= "<td><input type='checkbox'></td><td><input class='core-hidden-metadata-idData' type='hidden' value='$idData'><input type='text'></td><td><input type='text'><input class='core-hidden-metadata-realPath' type='hidden' value='$realPath'></td>";
		$view .= "</tr>";
		
		}
		else {
		
			foreach ($data as $key => $value) {
				
												
				$view .= "<tr>";
				$view .= "<td><input type='checkbox' value='$value[CAP_CON_MET_ID]'></td><td><input class='core-hidden-metadata-idData' type='hidden' value='$value[FK_CAP_CON_ID]'><input type='text' value='$value[CAP_CON_MET_HEADER]'></td><td><input type='text' value='$value[CAP_CON_MET_CONTENT]'><input class='core-hidden-metadata-realPath' type='hidden' value='$value[CAP_CON_MET_PATH]'></td>";
				$view .= "</tr>";
				
				
				
			}
		
		}
	
	$view .= "<tr><td colspan=3><hr></td></tr>";
			
	$view .= "</tbody>";
	
	$view .= "</table>";
	
	$view .= "<button class='core-administrator-metadataSubmit'>Save</button><button class='core-administrator-metadataCancel'>Cancel</button>";
	
	echo $view;
	
	}
	
	/*public function displayClassification($id,$idLanCom) {
	


	
	
	$view .= "<table class='core-administrator-content-classification'>";
	
	$view .= "<thead>";
	
	$view .= "<tr><td colspan=2><span style='font-weight:bold'>Content Klasifikasi</span></td></tr>";
	
	$view .= "<tr><td colspan=2><hr></td></tr>";
	
	$view .= "</thead>";
	
	$view .= "<tbody>";
		
		
				
		$view .= "<tr>";
		
		$view .= "<td class='core-align-left' style='padding-right:10px;'>Klasifikasi </td><td class='core-align-center'>";
		
		$view .= "<input type='hidden' name='idLanCom' value='".$idLanCom."'>";
		
		$view .= "<input type='hidden' name='idSelect' value='".$id[0]['FK_PER_KLA_NAM_ID']."'><select>";
		
		$view .="<option disabled='disabled' selected='selected'>Pilih Klasifikasi...</option>";
		
		$getKlas=model::getKlas();
		
		if(!empty($getKlas)){
			
			foreach($getKlas as $key => $value){
				
				$view .= "<optgroup label='".$value['CAP_PER_KLA_NAME']."'>";
				
				$getKlaTipe = model::getKlaTipe($value['CAP_PER_KLA_ID']);
				
			
				if(!empty($getKlaTipe)){
					foreach($getKlaTipe as $key2 => $value2){
						$view .="<option disabled='disabled'>".$value2['CAP_PER_KLA_TIP_NAME']."</option>";
						
						$getKlaName = model::getKlaName($value2['CAP_PER_KLA_TIP_ID']);
						
						if(!empty($getKlaName)){
							foreach($getKlaName as $key3 => $value3){
								$selected ="";
								if($value3['CAP_PER_KLA_NAM_ID']==$id[0]['FK_PER_KLA_NAM_ID']){
									$selected=" selected='selected' ";
								}
								$view .= "<option ".$selected." value='".$value3['CAP_PER_KLA_NAM_ID']."'> &nbsp;&nbsp;&nbsp;".$value3['CAP_PER_KLA_NAM_NAME']."</option>";
								
							}
						}
						
						$view .="</optgroup>";
					}
				}
				
				$view .= "</optgroup>";
				
			}
			
		}
		
		$view .="</select></td>";
		$view .= "</tr>";
		
				
	
	$view .= "<tr><td colspan=2><hr></td></tr>";
			
	$view .= "</tbody>";
	
	$view .= "</table>";
	
	$view .= "<button class='core-administrator-classificationSubmit'>Save</button><button class='core-administrator-classificationCancel'>Cancel</button>";
	
	echo $view;
	
	}*/
	
	public function displayClassification($id,$idLanCom,$publisher) {
	
	$view .= '<script type="text/javascript">jQuery(".select-with-choosen").chosen();</script>';
	
	$view .= "<table class='core-administrator-content-classification'>";
	
	$view .= "<thead>";
	
	$view .= "<tr><td colspan=2><span style='font-weight:bold'>Content Klasifikasi</span></td></tr>";
	
	$view .= "<tr><td colspan=2><hr></td></tr>";
	
	$view .= "</thead>";
	
	$view .= "<tbody>";
		
		
				
		$view .= "<tr>";
		
		$view .= "<td class='core-align-left' style='padding-right:10px;'>Klasifikasi </td><td class='core-align-left'>";
		
		$view .= "<input type='hidden' name='idLanCom' value='".$idLanCom."'>";
		
		$view .= "<input type='hidden' name='idSelect' value='".$id[0]['FK_KLA_ID']."'>";
		$view .= " <select class='select-with-choosen' style='width:250px' data-placeholder='Pilih Klasifikasi...'>";
		$view .="<option disabled='disabled' selected='selected'>Pilih Klasifikasi...</option>";
		
		
		$view .= view::getKlasifikasi($id[0]['FK_KLA_ID']);				
		
		
		$view .="</select></td>";
		$view .= "</tr>";
		
		$view .= "<tr>";
		
		$view .= "<td class='core-align-left' style='padding-right:10px;'>Penerbit </td><td class='core-align-left'>";
		
		$view .= "<input type='hidden' name='idSelect' value='".$publisher[0]['FK_PER_PUB_ID']."'>";
		
		$view .= " <select class='select-with-choosen' style='width:250px' data-placeholder='Pilih Penerbit...'>";
		
		$view .="<option value=''>Pilih Penerbit...</option>";
		
		
		$view .= view::getPublisher($publisher[0]['FK_PER_PUB_ID']);				
		
		
		$view .="</select></td>";
		$view .= "</tr>";
		
					
	$view .= "<tr><td colspan=2><hr></td></tr>";
			
	$view .= "</tbody>";
	
	$view .= "</table>";
	
	$view .= "<button class='core-administrator-classificationSubmit'>Save</button><button class='core-administrator-classificationCancel'>Cancel</button>";
	
	echo $view;
	
	}
	
	public function getKlasifikasi($value=null){
		$klasifikasi = model::klasifikasi();
		
		if(!empty($klasifikasi)){
			
				
			foreach($klasifikasi[0]['klasifikasi'] as $keys => $values){
				
				$set .= view::getRecursiveKlasifikasi($values,1,$value);
			
			}
				
			
		}
		//print_r($klasifikasi);
		
		return $set;
		
	}
	
	public function getRecursiveKlasifikasi($array,$i,$value){
		
		$padding=0;
		
		for($j=1;$j <= $i; $j++){
			if($i==1){continue;}$padding=$i*5;
				for($k=0;$k <= $i;$k++){
					$nbsp .= "&nbsp;";
				}
			}
			if(!empty($value)){
				$klaID = $array['parent']['CAP_KLA_ID'];
				if($klaID == $value){
					$selected ="selected='selected'";
				}else{
					$selected="";
			}
		}
		
			
			$set .= "<option ".$selected." value='".$array['parent']['CAP_KLA_ID']."'><b style='padding='".$padding."''>".$nbsp.$array['parent']['CAP_KLA_NAME']."</b></option>";
			
			
			if(isset($array['child'])){
					$i++;
					foreach($array['child'] as $valuesItem){
						
						$set .=self::getRecursiveKlasifikasi($valuesItem,$i,$value);
					
					}
					
			}
				
		return $set;
		
	}
	
	
	public function getPublisher($value=null){
		$klasifikasi = model::publisher();
		
		if(!empty($klasifikasi)){
			
				
			foreach($klasifikasi[0]['publisher'] as $keys => $values){
				
				$set .= view::getRecursivePublisher($values,1,$value);
			
			}
				
			
		}
		//print_r($klasifikasi);
		
		return $set;
		
	}
	
	public function getRecursivePublisher($array,$i,$value){
				
		$padding=0;
		
		for($j=1;$j <= $i; $j++){
			if($i==1){continue;}$padding=$i*5;
			for($k=0;$k <= $i;$k++){
				$nbsp .= "&nbsp;";
			}
		}
		if(!empty($value)){
			$klaID = $array['parent']['CAP_PER_PUB_ID'];
			if($klaID == $value){
				$selected ="selected='selected'";
			}else{
				$selected="";
		}
		}
		
			
			$set .= "<option ".$selected." value='".$array['parent']['CAP_PER_PUB_ID']."'>".$nbsp.$array['parent']['CAP_PER_PUB_NAME']."</option>";
			
			
			if(isset($array['child'])){
					$i++;
					foreach($array['child'] as $valuesItem){
						
						$set .=self::getRecursivePublisher($valuesItem,$i,$value);
					
					}
			}
		
		
		
		return $set;
	}
	


	public function displaytagging($data,$idData) {
	
	$view .= "<input class='core-tagging-deleter-meta' type='hidden'>";
	
	$view .= "<table class='core-administrator-content-tagging'>";
	
	$view .= "<thead>";
	
	$view .= "<tr><td colspan=1><span style='font-weight:bold'>Content Tagging</span></td><td class='core-administrator-action'></tr>";
	
	$view .= "<tr><td colspan=3><hr></td></tr>";
	
	$view .= "</thead>";
	
	$view .= "<tbody>";
		
	$view .= "<tr>";
	
	$view .= "<td>";
	
	//print_r($data);
	
	if(!empty($data)){
	
		foreach($data as $key => $value){
			
			$taggingValue .= $value['CAP_TAG_VALUE'].", ";
			
		}
		
		$taggingValue= substr($taggingValue, 0,-2);
	
	}
	
	$view .= "<input type='text' class='core-tagging-contentValue' value='".$taggingValue."'>";
	
	$view .= "<input type='hidden' class='core-tagging-contentFKID' value='".$idData."'>";
	
	
	$view .= "</td>";
	
	$view .= "</tr>";	
			
	$view .= "<tr><td colspan=3><hr></td></tr>";
			
	$view .= "</tbody>";
	
	$view .= "</table>";
	
	$view .= "<button class='core-administrator-taggingSubmit'>Save</button><button class='core-administrator-taggingCancel'>Cancel</button>";
	
	echo $view;
	
	}
	
	public function showTagging($data,$idData) {
	
	
	
	$view .= "<input class='core-tagging-deleter-meta' type='hidden'>";
	
	$view .= "<table class='core-administrator-content-tagging'>";
	
	$view .= "<thead>";
	
	$view .= "<tr><td colspan=1><span style='font-weight:bold'>Content Tagging</span></td><td class='core-administrator-action'></tr>";
		
  $view .= "<tr><td colspan=3><hr></td></tr>";

	$view .= "</thead>";
	
	$view .= "<tbody>";
	
			
	if(!empty($data)){
	   $i = 1;
		foreach($data as $key => $value){
			$view .= "<tr>";
	
			$view .= "<td>";

			$view .= $i.". ".$value['CAP_TAG_VALUE'];
			
			$view .= "</td>";
	
			$view .= "</tr>";

      $i++;
	
		}
	
	}
	
	
	
	$view .= "<tr><td colspan=3><hr></td></tr>";
	
	$view .= "</tbody>";
	
	$view .= "</table>";
	
	$view .= "<button class='core-administrator-taggingCancel'>Cancel</button>";
	
	echo $view;
	
	}


	public function searchOnTheFly(){
		$view .= "<div class='searchOnTheFly-container'>";
		
		$view .= "<div class='searchOnTheFly-searchContainer'>";
		
		$view .= "<input type='text' name='searchOnTheFly-searchInput' class='searchOnTheFly-searchInput not-bold' value='Search...'> ";
		
		$view .= "</div>";
		
		$view .= "<div class='searchOnTheFly-resultContainer'></div>";
		
		$view .= "</div>";
		
		echo $view;
	}
	public function resultSearchOnTheFly($data){
		//print_r($data);
		if(!empty($data)){
		foreach($data as $key=>$value){
			$view .= "<div>".pathinfo($value["CAP_LAN_COM_VALUE"],PATHINFO_BASENAME)."</div>";
		}
		}
		
		echo $view;
		
	}

  public function chartDado($setDateFrom = null, $setDateTO = null, $typeOfDate = null, $year = null){
	if(!empty($year)){
		$data = model::getDadoStats($year,null,null, 'year');
		//print_r($data[0][file]);
		$setDateFrom = $year.'-01-01';
		$setDateTO   = $year.'-12-31';
		
			foreach ($data[0][file] as $key => $value) {
				if(empty($value[COUNT])){
				$file [] =  0 ;	
				}	else{
				$file [] = $value[COUNT]; 
				}
			}
			foreach ($data[0][image] as $key => $value) {
				if(empty($value[COUNT])){
				$image [] =  0 ;	
				}	else{
				$image [] = $value[COUNT]; 
				}
			}
			foreach ($data[0][audio] as $key => $value) {
				if(empty($value[COUNT])){
				$audio [] =  0 ;	
				}	else{
				$audio [] = $value[COUNT]; 
				}
			}
			foreach ($data[0][video] as $key => $value) {
				if(empty($value[COUNT])){
				$video [] =  0 ;	
				}	else{
				$video [] = $value[COUNT]; 
				}
			}
			
			foreach ($data[0][content] as $key => $value) {
				if(empty($value[COUNT])){
				$content [] = 0 ;	
				}	else{
				$content [] = $value[COUNT]; 
				}
			}
			
			
			$resultfile 	= array_sum($file);
		    $resultaudio 	= array_sum($audio);
		    $resultvideo 	= array_sum($video);
		    $resultgambar 	= array_sum($image);
		    $resultdokumen 	= array_sum($content);
			
			$file = "".implode(",", $file)."";
			$image = "".implode(",", $image)."";
			$audio = "".implode(",", $audio)."";
			$video = "".implode(",", $video)."";
			$content = "".implode(",", $content)."";
			
			$setDate = "'Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'";
			//echo $setDate;
		
		
	}else{
    	$data = model::getDadoStats($setDateFrom, $setDateTO, $typeOfDate);
	
	    switch ($typeOfDate) {
	      	      
	      default:
	        $time = new time('Y-m-d');
	        $rangeDate = $time -> createDateRangeArray(date('Y-m-d',strtotime($setDateFrom)),date('Y-m-d',strtotime($setDateTO)));
	        if(count($rangeDate) > 10){
	            $setDateFrom = strtotime($setDateTO . " -10 days" );
	            $setDateFrom = date('Y-m-d',$setDateFrom);
	            $rangeDate = $time -> createDateRangeArray(date('Y-m-d',strtotime($setDateFrom)),date('Y-m-d',strtotime($setDateTO)));
	        }
	        break;
	    }
    
	    //print_r($rangeDate);
	    foreach ($rangeDate as $key => $value) {
	      $fileValue = 0; 
	      $imageValue = 0; 
	      $audioValue = 0; 
	      $videoValue = 0; 
	      $contentValue = 0; 
	      if(!empty($data[0][file])){
	        
	        foreach ($data[0][file] as $keyFile => $valueFile) {
	          
	          if($valueFile[DATETIME] == $value){
	             $fileValue = $valueFile[COUNT];
	             $forSumfile [] = $valueFile[COUNT];
	          }
			 
	          
	        }
	        
	      }
	      $file .= $fileValue.",";
	
	      if(!empty($data[0][image])){
	       //print_r($data[0][image]);
	       
	        foreach ($data[0][image] as $keyFile => $valueFile) {
	          
	          if(strtotime($valueFile[DATETIME]) == strtotime($value)){
	            $imageValue = $valueFile[COUNT]; 
	            $forSumimage [] = $valueFile[COUNT];
	          }
	          
	           
	          
	        }
	         
	      }
	      $image .= $imageValue.",";
	      if(!empty($data[0][audio])){
	        
	        foreach ($data[0][audio] as $keyFile => $valueFile) {
	          
	          if(date('Y-m-d', strtotime($valueFile[DATETIME])) == $value){
	            $audioValue = $valueFile[COUNT];
	            $forSumaudio [] = $valueFile[COUNT];
	          }
	          
	            
	        }
	        
	      }
	      $audio .= $audioValue.",";
	
	      if(!empty($data[0][video])){
	        
	        foreach ($data[0][video] as $keyFile => $valueFile) {
	          
	          if($valueFile[DATETIME] == $value){
	            $videoValue = $valueFile[COUNT];
	            $forSumvideo [] = $valueFile[COUNT];
	          }
	          
	            
	        }
	        
	      }
	      $video .= $videoValue.",";
	      if(!empty($data[0][content])){
	       
	        foreach ($data[0][content] as $keyFile => $valueFile) {
	          
	          if($valueFile[DATETIME] == $value){
	            $contentValue = $valueFile[COUNT];
	            $forSumcontent [] = $valueFile[COUNT];
	          }
	          
	            
	       }
	       
	      }
	      $content .= $contentValue.",";
	      $setDate .= '\''.date('d/m',strtotime($value)).'\',';
	    }
			/*if(!empty($forSumfile)){
				$resultfile = array_sum($forSumfile);
			}else{
				$resultfile = 0;
			}
			if(!empty($forSumaudio)){
				$resultaudio = array_sum($forSumaudio);
			}else{
				$resultaudio = 0;
			}
			if(!empty($resultvideo)){
				$resultvideo = array_sum($forSumvideo);
			}else{
				$resultvideo = 0;
			}
			if(!empty($forSumvideo)){
				$resultgambar = array_sum($forSumimage);
			}else{
				$resultgambar = 0;
			}
			if(!empty($forSumvideo)){
				$resultdokumen = array_sum($forSumcontent);
			}else{
				$resultdokumen = 0;
			}*/
		    
			
	        $file = substr($file, 0, -1);
	        $image = substr($image, 0, -1);
	        $video = substr($video, 0, -1);
	        $audio = substr($audio, 0, -1);
	        $content = substr($content, 0, -1);
	        $setDate = substr($setDate, 0, -1);
	      	
			$resultfile = array_sum(explode(",", $file));
		    $resultaudio = array_sum(explode(",", $audio));
		    $resultvideo = array_sum(explode(",", $video));
		    $resultgambar = array_sum(explode(",", $image));
		    $resultdokumen = array_sum(explode(",", $content));
    }
    $view .= "<script type='text/javascript'> jQuery.noConflict()(function($){var totalDokumen = parseFloat($('.totalDokumen').text());
      var fileDokumen = $resultfile;
      var audioDokumen = $resultaudio;
      var videoDokumen = $resultvideo;
      var gambarDokumen = $resultgambar;
      var contentDokumen = $resultdokumen;
  
      var chart;
      $(document).ready(function() {
        chart = new Highcharts.Chart({
          chart: {
            renderTo: 'dado-chart'
          },
          title: {
            text: 'Statistik Dokumen dari ".$setDateFrom." sampai tanggal ".$setDateTO." '
          },
          xAxis: {
            categories: [".$setDate."]
          },
          tooltip: {
            formatter: function() {
              var s;
              if (this.point.name) { // the pie chart
                s = ''+
                  this.y +' Dokumen';
              } else {
                s = ''+
                  this.y;
              }
              return s;
            }
          },
          labels: {
            items: [{
              html: 'Statistik Total Dokumen',
              style: {
                left: '40px',
                top: '8px',
                color: 'black'
              }
            }]
          },
          series: [{
            type: 'column',
            name: 'File',
            data: [".$file."]
          }, {
            type: 'column',
            name: 'Gambar',
            data: [".$image."]
          }, {
            type: 'column',
            name: 'Audio',
            data: [".$audio."]
          }, {
            type: 'column',
            name: 'Video',
            data: [".$video."]
          }, {
            type: 'column',
            name: 'Konten Teks',
            data: [".$content ."]
          }, {
            type: 'pie',
            name: 'Statistik Pembagian Dokumen',
            data: [{
              name: 'File',
              y: fileDokumen,
              color: '#4572A7' // Jane's color
            }, {
              name: 'Gambar',
              y: gambarDokumen,
              color: '#AA4643' // John's color
            }, {
              name: 'Audio',
              y: audioDokumen,
              color: '#89A54E' // Joe's color
            }, {
              name: 'Video',
              y: videoDokumen,
              color: '#816A9C' // Joe's color
            }, {
              name: 'Konten Teks',
              y: contentDokumen,
              color: '#3D95AD' // Joe's color
            }],
            center: [100, 80],
            size: 100,
            showInLegend: false,
            dataLabels: {
              enabled: false
            }
          }]
        });
      });
          

          
      });
      </script>


    ";

     $view .= '<div class="dado-core-chart-body" id="dado-chart"></div>';

    echo $view;

  }
      
  public function dashboard($setDateFrom = null, $setDateTO = null, $typeOfDate = null){
  	
  	if(empty($setDateFrom)){
  		$setDateFrom = date('Y-m-d', strtotime(date('Y-m-d')." -7 days"));
  	}
  	if(empty($setDateTO)){
  		$setDateTO = date('Y-m-d');
  	}
  	
    $data = $this->getDadoStats($setDateFrom, $setDateTO, 'days');
    //print_r($data);
    
    


    for($i = 6; $i >= 0; $i--){

      $jeda = $i * 86400;
      $date = strtotime(date('Y-m-d'))-$jeda;
      $date = date('Y-m-d', $date);
      $setDate .= "'".date('d/m',strtotime($date))."', ";
      if($i == 6){
        $dateFrom = date('d-m-Y',strtotime($date));
        $dateTo = date('d-m-Y');
      }
      $found = null; 
      if(!empty($data[0]['file'])){
            foreach ($data[0]['file'] as $key => $value) {
                
              $dateVal = $value['DATETIME'];
              if($date == $dateVal){
                $file .= $value['COUNT'].',';
                $found = 1;
              }

            }
        
        if(empty($found)){
          $file .= '0,';
          
        }
      
    }

  }
     if(!empty($data[0]['image'])){
    for($i = 6; $i >= 0; $i--){
      $jeda = $i * 86400;
      $date = strtotime(date('Y-m-d'))-$jeda;
      $date = date('Y-m-d', $date);
      $found = null;
            foreach ($data[0]['image'] as $key => $value) {
                
              $dateVal = $value['DATETIME'];
              if($date == $dateVal){
                $image .= $value['COUNT'].',';
                $found = 1;
              }

            }
        
        if(empty($found)){
          $image .= '0,';
          
        }
      
    }
}

     if(!empty($data[0]['video'])){
     for($i = 6; $i >= 0; $i--){
      $jeda = $i * 86400;
      $date = strtotime(date('Y-m-d'))-$jeda;
      $date = date('Y-m-d', $date);
      $found = null;
            foreach ($data[0]['video'] as $key => $value) {
                
              $dateVal = $value['DATETIME'];
              if($date == $dateVal){
                $video .= $value['COUNT'].',';
                $found = 1;
              }

            }
        
        if(empty($found)){
          $video .= '0,';
          
        }
      
    }

}
     if(!empty($data[0]['audio'])){
    for($i = 6; $i >= 0; $i--){
      $jeda = $i * 86400;
      $date = strtotime(date('Y-m-d'))-$jeda;
      $date = date('Y-m-d', $date);
      $found = null;
            foreach ($data[0]['audio'] as $key => $value) {
                
              $dateVal = $value['DATETIME'];
              if($date == $dateVal){
                $audio .= $value['COUNT'].',';
                $found = 1;
              }

            }
        
        if(empty($found)){
          $audio .= '0,';
          
        }
      
    }
}

     if(!empty($data[0]['content'])){
    for($i = 6; $i >= 0; $i--){
      $jeda = $i * 86400;
      $date = strtotime(date('Y-m-d'))-$jeda;
      $date = date('Y-m-d', $date);
      $found = null;
            foreach ($data[0]['content'] as $key => $value) {
                
              $dateVal = $value['DATETIME'];
              if($date == $dateVal){
                $content .= $value['COUNT'].',';
                $found = 1;
              }

            }
        
        if(empty($found)){
          $content .= '0,';
          
        }
      
    }
  }

     $file = substr($file, 0, -1);
     $image = substr($image, 0, -1);
     $video = substr($video, 0, -1);
     $audio = substr($audio, 0, -1);
     $content = substr($content, 0, -1);
     $setDate = substr($setDate, 0, -1);


    $view .= '<div class="core-dashboard-all-wrapper">';
    $view .= '<div class="dado-counter-container">';
    
           $view .= '<div class="dado-counter-container-1">';
          
                  $view .= '<div class="dado-counter-container-1-inside">

                    <div class="dado-counter-container-1-insideBottom1 contentDokumen">'.model::getDataCount('CAP_LANGUAGE_COMBINE','CAP_LAN_COM_COLUMN = \'content\'').'</div>
                    <div class="dado-counter-container-1-insideBottom2">Konten</div>

                  </div>';
            $view.='</div>';
          
            $view .= '<div class="dado-counter-container-2">';
      
            $view .= '<div class="dado-counter-container-2-inside">
                <div class="dado-counter-container-2-insideBottom1 fileDokumen">'.model::getDataCount('CAP_LANGUAGE_COMBINE','CAP_LAN_COM_COLUMN = \'file\'').'</div>
                <div class="dado-counter-container-1-insideBottom2">File</div>
              </div>';
            $view.='</div>';
        
            $view .= '<div class="dado-counter-container-3">';
      
          $view .= '<div class="dado-counter-container-3-inside">
            <div class="dado-counter-container-3-insideBottom1 gambarDokumen">'.model::getDataCount('CAP_LANGUAGE_COMBINE','CAP_LAN_COM_COLUMN = \'image\'').'</div>
            <div class="dado-counter-container-3-insideBottom2">Gambar</div>
            </div>';
          $view.='</div>';        
            $view .= '<div class="dado-counter-container-4">';
      
          $view .= '<div class="dado-counter-container-4-inside">
          <div class="dado-counter-container-4-insideBottom1 videoDokumen">'.model::getDataCount('CAP_LANGUAGE_COMBINE','CAP_LAN_COM_COLUMN = \'video\'').'</div>
          <div class="dado-counter-container-4-insideBottom2">Video</div>
          </div>';
        
          $view.='</div>';

            $view .= '<div class="dado-counter-container-5">';
      
          $view .= '<div class="dado-counter-container-5-inside">
          <div class="dado-counter-container-5-insideBottom1 audioDokumen">'.model::getDataCount('CAP_LANGUAGE_COMBINE','CAP_LAN_COM_COLUMN = \'audio\'').'</div>
          <div class="dado-counter-container-5-insideBottom2">Audio</div>
          </div>';

          $view.='</div>';           


            $view .= '<div class="dado-counter-container-last">';
      
                    $view .= '<div class="dado-counter-container-last-inside">
                    <div class="dado-counter-container-last-insideBottom1 totalDokumen">'.model::getDataCount('CAP_LANGUAGE_COMBINE','CAP_LAN_COM_COLUMN = \'content\' OR CAP_LAN_COM_COLUMN = \'file\' OR CAP_LAN_COM_COLUMN = \'image\' OR CAP_LAN_COM_COLUMN = \'audio\' OR CAP_LAN_COM_COLUMN = \'video\'').'</div>
                    <div class="dado-counter-container-last-insideBottom2">Total Dokumen</div></div>';
                    $view.='</div>';
             $view .= '</div>';

      

          $view .= '<div class="dado-core-chart-container">';
      
                          $view .= '<div class="dado-core-chart-header">';
                              
                                          $view .= '<div class="dado-id-float-left">';
                                                      $view .= '<div class="software-dashboard-container-menu-left">';
                                                                  $view .= '<ul id="featured-date">
                                                                            <li class="menuDateList"><span class="days-button core-date-dashboard-button ">Day</a></li>
                                                                            <!--li class="menuDateList"><span class=" year-button">Year</a></li-->
                                                                          </ul>'; 
                                                      $view .= '</div>';
                                          $view .= '</div>';
                                          $view .= '<div class="core-dashboard-print"> <button type="submit"  value="Go" class="featured-dado-button-print-chart">Print</button></div>';
                                          $view .= '<div class="dado-id-float-right">';
                                                        $view .= '<div class="core-dashboard-right">';
															$view .= '<div class="core-dashboard-action-container select-year" style="display:none">';
																  $view .= '<select class="core-dashboard-year-container">';
																  for($i=date('Y'); $i >= 2012;$i--){
																  	$view .= "<option value='".$i."'>$i</option>";
																  }
																  $view .= '</select>';
																  
	                                                              $view .='  <input type="submit"  value="Go" class="featured-dado-button-year" />';                                                                
															$view .= '</div>';
	                                                        $view .= '<div class="core-dashboard-action-container select-days">';
	                                                                $view .= ' <span class="core-input-container-left-float"><input type="text" class="dado-featured-form-input datepicker-from datepicker-content-handler-from" value="'.$dateFrom.'" /></span>
	                                                                  <span class="core-input-container-left-float">To</span>
	                                                                  <span class="core-input-container-left-float"><input type="text" class="dado-featured-form-input datepicker-to datepicker-content-handler-to" value="'.$dateTo.'" />
	                                                                  <input type="hidden" value="days" class="typeOfdate"></span>';  
	                                                                  $view .='  <button type="submit"  value="Go" class="featured-dado-button" />Go</button>'; 
															$view .= '  </div>';
																	                                                                  
	                                                          
                                                                
                                                            
                                                         $view .= '  </div>';
																
                                            
                                           $view .= ' </div>';
                              
                            $view .= '</div>';
                            $view .= "<div class='javascript-container'> ";

     
    $resultfile = array_sum(explode(",", $file));
    $resultaudio = array_sum(explode(",", $audio));
    $resultvideo = array_sum(explode(",", $video));
    $resultgambar = array_sum(explode(",", $image));
    $resultdokumen = array_sum(explode(",", $content));
    $view .= "<script type='text/javascript'> jQuery.noConflict()(function($){var totalDokumen = parseFloat($('.totalDokumen').text());
      var fileDokumen = $resultfile;
      var audioDokumen = $resultaudio;
      var videoDokumen = $resultvideo;
      var gambarDokumen = $resultgambar;
      var contentDokumen = $resultdokumen;
  
      var chart;
      $(document).ready(function() {
        chart = new Highcharts.Chart({
          chart: {
            renderTo: 'dado-chart'
          },
          title: {
            text: 'Statistik Dokumen dari ".$dateFrom." sampai tanggal ".$dateTo." '
          },
          xAxis: {
            categories: [".$setDate."]
          },
          tooltip: {
            formatter: function() {
              var s;
              if (this.point.name) { // the pie chart
                s = ''+
                  this.y +' Dokumen';
              } else {
                s = ''+
                  this.y;
              }
              return s;
            }
          },
          labels: {
            items: [{
              html: 'Statistik Total Dokumen',
              style: {
                left: '40px',
                top: '8px',
                color: 'black'
              }
            }]
          },
          series: [{
            type: 'column',
            name: 'File',
            data: [".$file."]
          }, {
            type: 'column',
            name: 'Gambar',
            data: [".$image."]
          }, {
            type: 'column',
            name: 'Audio',
            data: [".$audio."]
          }, {
            type: 'column',
            name: 'Video',
            data: [".$video."]
          }, {
            type: 'column',
            name: 'Konten Teks',
            data: [".$content ."]
          }, {
            type: 'pie',
            name: 'Statistik Pembagian Dokumen',
            data: [{
              name: 'File',
              y: fileDokumen,
              color: '#4572A7' // Jane's color
            }, {
              name: 'Gambar',
              y: gambarDokumen,
              color: '#AA4643' // John's color
            }, {
              name: 'Audio',
              y: audioDokumen,
              color: '#89A54E' // Joe's color
            }, {
              name: 'Video',
              y: videoDokumen,
              color: '#816A9C' // Joe's color
            }, {
              name: 'Konten Teks',
              y: contentDokumen,
              color: '#3D95AD' // Joe's color
            }],
            center: [100, 80],
            size: 100,
            showInLegend: false,
            dataLabels: {
              enabled: false
            }
          }]
        });
      });
          
      
      
});
      </script>
    ";
    
  $view .= '<div class="dado-core-chart-body" id="dado-chart"></div>';   
  $view .= "</div>";
            $view .= '</div>';
        $view .= '</div>';  
        $view .= '<div class="dado-core-desc-left">';
      
                     $view .= '<div class="dado-core-desc-left-header">
                            Daftar IP
                             </div>';
        
        
                          $view .= '<div class="dado-core-desc-left-body">';
                          $data = model::klasifikasi();
                          //print_r($data);
                          $view .= "<table cellpadding='0' cellspacing='0' class='core-listInformasiPublik-table'>";
                                      $view .= "<thead>";
                                                $view .= "<tr class='core-listInformasiPublik-thead-tr'>";
                                                $view .= "  <td colspan='3'>Klasifikasi Informasi Publik</td>";
                                                $view .= "  <td class='align-center'>Keterangan</td>  ";
                                                $view .= "</tr>";
                                      $view .= "</thead>";
                                      $view .= "<tbody>";

                                    //print_r($data[0]['klasifikasi']);
                                    if(!empty($data[0]['klasifikasi'])){
                                      foreach ($data[0]['klasifikasi'] as $key => $value) {
                                      
                                        $view .= $this->recursiveIP($value,0);

                                     }
                                   }
   
                                $view .= "</tbody>";
                              $view .= "<tfoot>";
                              $view .= "<tr>";
                              $view .= "  <td style='width:20px;'></td>";
                              $view .= "  <td style='min-width:15%; max-width:100px;'></td>";
                              $view .= "  <td ></td>";
                              $view .= "  <td style='min-width:25%; '></td>";
                              $view .= "</tr>";
                              $view .= "</tfoot>";
                              $view .= "</table>";

                                 $view .= '</div>';
      
      $view .= '</div>';


      $view .= '<div class="dado-core-desc-right">';

                $view .= '<div class="dado-core-desc-right-header">
                      Sejarah 7 Hari Terakhir
                    </div>';
    
                $view .= '<div class="dado-core-desc-right-body">';
    
                        $view .= self::historyDado();
    
                  $view .= '</div>
      </div>
      
                            
                            ';
    
      echo $view;
    
  }


  public function historyDado(){

    $sejarah = $this->getDadoHistory();

         

         

            if (!empty($sejarah)) {

              foreach ($sejarah as $key => $value) {

              $view .= "<div class='dado-core-sejarah-date-header'>".date("d, F Y",strtotime($value['DATE']))."</div>";

              $view .= "<hr class='dado-normal-hr'>";

              $view .= "<ul class='dado-core-sejarah-ul'>";

                if(!empty($value['VALUE'] )){

                  foreach ($value['VALUE'] as $key2 => $value2) {

                  $view .= "<li>(".date("H:i:s",strtotime($value2['DATETIME'])).")".ucfirst(strtolower($value2['CAP_PER_HIS_EVENT']))." <br><span class='dado-core-sejarah-span'></span></li>";

                  $view .= "<hr class='dado-normal-hr'>";

                  }
                }

              $view .= "</ul>";

              $view .= "<br>";

              }

            }

      

          return $view;
  }
	
  public function sejarahDado(){

    $sejarah = $this->getDadoHistory($user = false);

            if (!empty($sejarah)) {

              foreach ($sejarah as $key => $value) {
	              
	          $view .= "<hr class='dado-normal-hr'>";
	          
              $view .= "<div class='dado-core-sejarah-date-header'>".date("d, F Y",strtotime($value['DATE']))."</div>";

              $view .= "<hr class='dado-normal-hr'>";

              $view .= "<ul class='dado-core-sejarah-ul'>";

                if(!empty($value['VALUE'] )){

                  foreach ($value['VALUE'] as $key2 => $value2) {

                  $view .= "<li><i>(".date("H:i:s",strtotime($value2['DATETIME'])).")</i> ".ucfirst(strtolower($value2['CAP_PER_HIS_EVENT']))." <br><span class='dado-core-sejarah-span'></span></li>";

                  $view .= "<hr class='dado-normal-hr'>";

                  }
                }

              $view .= "</ul>";

              $view .= "<br>";

              }

            }

   

          echo $view;
  }
  
  
  public function chartDadoUser($setDateFrom = null, $setDateTO = null, $typeOfDate = null, $year = null){
	  if(!empty($year)){
		$data = model::getDadoUserStats($year,null,null, 'year');
		//print_r($data);
		$setDateFrom = "1 Januari ".$year;
		$setDateTO   = "31 Desember ".$year;
		
			foreach ($data[0][file] as $key => $value) {
				if(empty($value[COUNT])){
				$file [] =  0 ;	
				}	else{
				$file [] = $value[COUNT]; 
				}
			}
			foreach ($data[0][image] as $key => $value) {
				if(empty($value[COUNT])){
				$image [] =  0 ;	
				}	else{
				$image [] = $value[COUNT]; 
				}
			}
			foreach ($data[0][audio] as $key => $value) {
				if(empty($value[COUNT])){
				$audio [] =  0 ;	
				}	else{
				$audio [] = $value[COUNT]; 
				}
			}
			foreach ($data[0][video] as $key => $value) {
				if(empty($value[COUNT])){
				$video [] =  0 ;	
				}	else{
				$video [] = $value[COUNT]; 
				}
			}
			
			foreach ($data[0][content] as $key => $value) {
				if(empty($value[COUNT])){
				$content [] = 0 ;	
				}	else{
				$content [] = $value[COUNT]; 
				}
			}
			
			
			$resultfile 	= array_sum($file);
		    $resultaudio 	= array_sum($audio);
		    $resultvideo 	= array_sum($video);
		    $resultgambar 	= array_sum($image);
		    $resultdokumen 	= array_sum($content);
			
			$file = "".implode(",", $file)."";
			$image = "".implode(",", $image)."";
			$audio = "".implode(",", $audio)."";
			$video = "".implode(",", $video)."";
			$content = "".implode(",", $content)."";
			
			$setDate = "'Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'";
			//echo $setDate;
		
		
	}else{
    $data = model::getDadoUserStats($setDateFrom, $setDateTO, $typeOfDate);
    //print_r($data );
    switch ($typeOfDate) {
      case 'month':
        $time = new time('F Y');
        print_r($time->get_months(strtotime(date('Y-m',strtotime($setDateFrom)).'-1'),strtotime('-1 second',strtotime(date('Y-m',strtotime('+1 month',$setDateTo)).'-1'))));
         $addingTime = strtotime('+1 month') - strtotime(date('F Y'));
        $rangeDate = $time -> createDateRangeArray(date('Y-m-d',strtotime($setDateFrom)),date('Y-m-d',strtotime($setDateTO)),strtotime('+1 month'));
        if(count($rangeDate) > 10){
            $setDateFrom = strtotime($setDateTO . " -10 days" );
            $setDateFrom = date('F Y',$setDateFrom);
            $rangeDate = $time -> createDateRangeArray(date('Y-m-d',strtotime($setDateFrom)),date('Y-m-d',strtotime($setDateTO)),strtotime('+1 month'));
        }
        break;
      
      default:
        $time = new time('Y-m-d');
        $rangeDate = $time -> createDateRangeArray(date('Y-m-d',strtotime($setDateFrom)),date('Y-m-d',strtotime($setDateTO)));
        if(count($rangeDate) > 10){
            $setDateFrom = strtotime($setDateTO . " -10 days" );
            $setDateFrom = date('Y-m-d',$setDateFrom);
            $rangeDate = $time -> createDateRangeArray(date('Y-m-d',strtotime($setDateFrom)),date('Y-m-d',strtotime($setDateTO)));
        }
        break;
    }
    
    //print_r($rangeDate);
    foreach ($rangeDate as $key => $value) {
      $fileValue = 0; 
      $imageValue = 0; 
      $audioValue = 0; 
      $videoValue = 0; 
      $contentValue = 0; 
      if(!empty($data[0][file])){
        
        foreach ($data[0][file] as $keyFile => $valueFile) {
          
          if($valueFile[DATETIME] == $value){
             $fileValue = $valueFile[COUNT];
            
          }
          
        }
        
      }
      $file .= $fileValue.",";

      if(!empty($data[0][image])){
       //print_r($data[0][image]);
       
        foreach ($data[0][image] as $keyFile => $valueFile) {
          
          if(strtotime($valueFile[DATETIME]) == strtotime($value)){
            $imageValue = $valueFile[COUNT]; 
            
          }
          
           
          
        }
         
      }
      $image .= $imageValue.",";
      if(!empty($data[0][audio])){
        
        foreach ($data[0][audio] as $keyFile => $valueFile) {
          
          if(date('Y-m-d', strtotime($valueFile[DATETIME])) == $value){
            $audioValue = $valueFile[COUNT];
            
          }
          
            
        }
        
      }
      $audio .= $audioValue.",";

      if(!empty($data[0][video])){
        
        foreach ($data[0][video] as $keyFile => $valueFile) {
          
          if($valueFile[DATETIME] == $value){
            $videoValue = $valueFile[COUNT];
            
          }
          
            
        }
        
      }
      $video .= $videoValue.",";
      if(!empty($data[0][content])){
       
        foreach ($data[0][content] as $keyFile => $valueFile) {
          
          if($valueFile[DATETIME] == $value){
            $contentValue = $valueFile[COUNT];
            
          }
          
            
       }
       
      }
      $content .= $contentValue.",";
      $setDate .= '\''.date('d/m',strtotime($value)).'\',';
    }

        $file = substr($file, 0, -1);
        $image = substr($image, 0, -1);
        $video = substr($video, 0, -1);
        $audio = substr($audio, 0, -1);
        $content = substr($content, 0, -1);
        $setDate = substr($setDate, 0, -1);
$resultfile = array_sum(explode(",", $file));
    $resultaudio = array_sum(explode(",", $audio));
    $resultvideo = array_sum(explode(",", $video));
    $resultgambar = array_sum(explode(",", $image));
    $resultdokumen = array_sum(explode(",", $content));
    }
      $view .= "<script type='text/javascript'> jQuery.noConflict()(function($){var totalDokumen = parseFloat($('.totalDokumen').text());
      var fileDokumen = $resultfile;
      var audioDokumen = $resultaudio;
      var videoDokumen = $resultvideo;
      var gambarDokumen = $resultgambar;
      var contentDokumen = $resultdokumen;
  
      var chart;
      $(document).ready(function() {
        chart = new Highcharts.Chart({
          chart: {
            renderTo: 'dado-chart'
          },
          title: {
            text: 'Statistik Dokumen dari ".$setDateFrom." sampai tanggal ".$setDateTO." '
          },
          xAxis: {
            categories: [".$setDate."]
          },
          tooltip: {
            formatter: function() {
              var s;
              if (this.point.name) { // the pie chart
                s = ''+
                  this.y +' Dokumen';
              } else {
                s = ''+
                  this.y;
              }
              return s;
            }
          },
          labels: {
            items: [{
              html: 'Statistik Total Dokumen',
              style: {
                left: '40px',
                top: '8px',
                color: 'black'
              }
            }]
          },
          series: [{
            type: 'column',
            name: 'File',
            data: [".$file."]
          }, {
            type: 'column',
            name: 'Gambar',
            data: [".$image."]
          }, {
            type: 'column',
            name: 'Audio',
            data: [".$audio."]
          }, {
            type: 'column',
            name: 'Video',
            data: [".$video."]
          }, {
            type: 'column',
            name: 'Konten Teks',
            data: [".$content ."]
          }, {
            type: 'pie',
            name: 'Statistik Pembagian Dokumen',
            data: [{
              name: 'File',
              y: fileDokumen,
              color: '#4572A7' // Jane's color
            }, {
              name: 'Gambar',
              y: gambarDokumen,
              color: '#AA4643' // John's color
            }, {
              name: 'Audio',
              y: audioDokumen,
              color: '#89A54E' // Joe's color
            }, {
              name: 'Video',
              y: videoDokumen,
              color: '#816A9C' // Joe's color
            }, {
              name: 'Konten Teks',
              y: contentDokumen,
              color: '#3D95AD' // Joe's color
            }],
            center: [100, 80],
            size: 100,
            showInLegend: false,
            dataLabels: {
              enabled: false
            }
          }]
        });
      });
          

          
      });
      </script>


    ";

     $view .= '<div class="dado-core-chart-body" id="dado-chart"></div>';

    echo $view;

  }
      
  public function dashboardUser($setDateFrom = null, $setDateTO = null, $typeOfDate = null){
    if(empty($setDateFrom)){
  		$setDateFrom = date('Y-m-d', strtotime(date('Y-m-d')." -7 days"));
  	}
  	if(empty($setDateTO)){
  		$setDateTO = date('Y-m-d');
  	}	
    $data = $this->getDadoUserStats($setDateFrom, $setDateTO, $typeOfDate);
    
//print_r($data);
    
    


    for($i = 6; $i >= 0; $i--){

      $jeda = $i * 86400;
      $date = strtotime(date('Y-m-d'))-$jeda;
      $date = date('Y-m-d', $date);
      $setDate .= "'".date('d/m',strtotime($date))."', ";
      if($i == 6){
        $dateFrom = date('d-M-Y',strtotime($date));
        $dateTo = date('d-M-Y');
      }
      $found = null; 
      if(!empty($data[0]['file'])){
            foreach ($data[0]['file'] as $key => $value) {
                
              $dateVal = $value['DATETIME'];
              if($date == $dateVal){
                $file .= $value['COUNT'].',';
                $found = 1;
              }

            }
        
        if(empty($found)){
          $file .= '0,';
          
        }
      
    }

  }
     if(!empty($data[0]['image'])){
    for($i = 6; $i >= 0; $i--){
      $jeda = $i * 86400;
      $date = strtotime(date('Y-m-d'))-$jeda;
      $date = date('Y-m-d', $date);
      $found = null;
            foreach ($data[0]['image'] as $key => $value) {
                
              $dateVal = $value['DATETIME'];
              if($date == $dateVal){
                $image .= $value['COUNT'].',';
                $found = 1;
              }

            }
        
        if(empty($found)){
          $image .= '0,';
          
        }
      
    }
}

     if(!empty($data[0]['video'])){
     for($i = 6; $i >= 0; $i--){
      $jeda = $i * 86400;
      $date = strtotime(date('Y-m-d'))-$jeda;
      $date = date('Y-m-d', $date);
      $found = null;
            foreach ($data[0]['video'] as $key => $value) {
                
              $dateVal = $value['DATETIME'];
              if($date == $dateVal){
                $video .= $value['COUNT'].',';
                $found = 1;
              }

            }
        
        if(empty($found)){
          $video .= '0,';
          
        }
      
    }

}
     if(!empty($data[0]['audio'])){
    for($i = 6; $i >= 0; $i--){
      $jeda = $i * 86400;
      $date = strtotime(date('Y-m-d'))-$jeda;
      $date = date('Y-m-d', $date);
      $found = null;
            foreach ($data[0]['audio'] as $key => $value) {
                
              $dateVal = $value['DATETIME'];
              if($date == $dateVal){
                $audio .= $value['COUNT'].',';
                $found = 1;
              }

            }
        
        if(empty($found)){
          $audio .= '0,';
          
        }
      
    }
}

     if(!empty($data[0]['content'])){
    for($i = 6; $i >= 0; $i--){
      $jeda = $i * 86400;
      $date = strtotime(date('Y-m-d'))-$jeda;
      $date = date('Y-m-d', $date);
      $found = null;
            foreach ($data[0]['content'] as $key => $value) {
                
              $dateVal = $value['DATETIME'];
              if($date == $dateVal){
                $content .= $value['COUNT'].',';
                $found = 1;
              }

            }
        
        if(empty($found)){
          $content .= '0,';
          
        }
      
    }
  }

     $file = substr($file, 0, -1);
     $image = substr($image, 0, -1);
     $video = substr($video, 0, -1);
     $audio = substr($audio, 0, -1);
     $content = substr($content, 0, -1);
     $setDate = substr($setDate, 0, -1);


       $view .= '<div class="core-dashboard-all-wrapper">';
    $view .= '<div class="dado-counter-container">';
    
           $view .= '<div class="dado-counter-container-1">';
          
                  $view .= '<div class="dado-counter-container-1-inside">

                    <div class="dado-counter-container-1-insideBottom1 contentDokumen">'.model::getDataCountUser('CAP_LANGUAGE_COMBINE','CAP_LAN_COM_COLUMN = \'content\'').'</div>
                    <div class="dado-counter-container-1-insideBottom2">Konten</div>

                  </div>';
            $view.='</div>';
          
            $view .= '<div class="dado-counter-container-2">';
      
            $view .= '<div class="dado-counter-container-2-inside">
                <div class="dado-counter-container-2-insideBottom1 fileDokumen">'.model::getDataCountUser('CAP_LANGUAGE_COMBINE','CAP_LAN_COM_COLUMN = \'file\'').'</div>
                <div class="dado-counter-container-1-insideBottom2">File</div>
              </div>';
            $view.='</div>';
        
            $view .= '<div class="dado-counter-container-3">';
      
          $view .= '<div class="dado-counter-container-3-inside">
            <div class="dado-counter-container-3-insideBottom1 gambarDokumen">'.model::getDataCountUser('CAP_LANGUAGE_COMBINE','CAP_LAN_COM_COLUMN = \'image\'').'</div>
            <div class="dado-counter-container-3-insideBottom2">Gambar</div>
            </div>';
          $view.='</div>';        
            $view .= '<div class="dado-counter-container-4">';
      
          $view .= '<div class="dado-counter-container-4-inside">
          <div class="dado-counter-container-4-insideBottom1 videoDokumen">'.model::getDataCountUser('CAP_LANGUAGE_COMBINE','CAP_LAN_COM_COLUMN = \'video\'').'</div>
          <div class="dado-counter-container-4-insideBottom2">Video</div>
          </div>';
        
          $view.='</div>';

            $view .= '<div class="dado-counter-container-5">';
      
          $view .= '<div class="dado-counter-container-5-inside">
          <div class="dado-counter-container-5-insideBottom1 audioDokumen">'.model::getDataCountUser('CAP_LANGUAGE_COMBINE','CAP_LAN_COM_COLUMN = \'audio\'').'</div>
          <div class="dado-counter-container-5-insideBottom2">Audio</div>
          </div>';

          $view.='</div>';           


            $view .= '<div class="dado-counter-container-last">';
      
                    $view .= '<div class="dado-counter-container-last-inside">
                    <div class="dado-counter-container-last-insideBottom1 totalDokumen">'.model::getDataCountUser('CAP_LANGUAGE_COMBINE','(CAP_LAN_COM_COLUMN = \'content\' OR CAP_LAN_COM_COLUMN = \'file\' OR CAP_LAN_COM_COLUMN = \'image\' OR CAP_LAN_COM_COLUMN = \'audio\' OR CAP_LAN_COM_COLUMN = \'video\')').'</div>
                    <div class="dado-counter-container-last-insideBottom2">Total Dokumen</div></div>';
                    $view.='</div>';
             $view .= '</div>';

$view .= '</div>';
      

          $view .= '<div class="dado-core-chart-container">';
      
                          $view .= '<div class="dado-core-chart-header">';
                              
                                          $view .= '<div class="dado-id-float-left">';
                                                      $view .= '<div class="software-dashboard-container-menu-left">';
                                                                  $view .= '<ul id="featured-date">
                                                                            <li class="menuDateList"><span class="days-button core-date-dashboard-button ">Day</a></li>
                                                                            <!--li class="menuDateList"><span class=" year-button">Year</a></li-->
                                                                          </ul>'; 
                                                      $view .= '</div>';
                                          $view .= '</div>';
                                          $view .= '<div class="core-dashboard-print"> <button type="submit"  value="Go" class="featured-dado-button-print-chart">Print</button></div>';
                                          $view .= '<div class="dado-id-float-right">';
                                                        $view .= '<div class="core-dashboard-right">';
															$view .= '<div class="core-dashboard-action-container select-year" style="display:none">';
																  $view .= '<select class="core-dashboard-year-container">';
																  for($i=date('Y'); $i >= 2012;$i--){
																  	$view .= "<option value='".$i."'>$i</option>";
																  }
																  $view .= '</select>';
																  
	                                                              $view .='  <input type="submit"  value="Go" class="featured-dado-button-user-year" />';                                                                
															$view .= '</div>';
	                                                        $view .= '<div class="core-dashboard-action-container select-days">';
	                                                                $view .= ' <span class="core-input-container-left-float"><input type="text" class="dado-featured-form-input datepicker-from datepicker-content-handler-from" value="'.$dateFrom.'" /></span>
	                                                                  <span class="core-input-container-left-float">To</span>
	                                                                  <span class="core-input-container-left-float"><input type="text" class="dado-featured-form-input datepicker-to datepicker-content-handler-to" value="'.$dateTo.'" />
	                                                                  <input type="hidden" value="days" class="typeOfdate"></span>';  
	                                                                  $view .='  <input type="submit"  value="Go" class="featured-dado-button-user" />'; 
															$view .= '  </div>';
																	                                                                  
	                                                          
                                                                
                                                            
                                                         $view .= '  </div>';
																
                                            
                                           $view .= ' </div>';
                              
                            $view .= '</div>';

                            $view .= "<div class='javascript-container'> ";

    $resultfile = array_sum(explode(",", $file));
    $resultaudio = array_sum(explode(",", $audio));
    $resultvideo = array_sum(explode(",", $video));
    $resultgambar = array_sum(explode(",", $image));
    $resultdokumen = array_sum(explode(",", $content));
    $view .= "<script type='text/javascript'> jQuery.noConflict()(function($){var totalDokumen = parseFloat($('.totalDokumen').text());
      var fileDokumen = $resultfile;
      var audioDokumen = $resultaudio;
      var videoDokumen = $resultvideo;
      var gambarDokumen = $resultgambar;
      var contentDokumen = $resultdokumen;
  
      var chart;
      $(document).ready(function() {
        chart = new Highcharts.Chart({
          chart: {
            renderTo: 'dado-chart'
          },
          title: {
            text: 'Statistik Dokumen dari ".$dateFrom." sampai tanggal ".$dateTo." '
          },
          xAxis: {
            categories: [".$setDate."]
          },
          tooltip: {
            formatter: function() {
              var s;
              if (this.point.name) { // the pie chart
                s = ''+
                  this.y +' Dokumen';
              } else {
                s = ''+
                  this.y;
              }
              return s;
            }
          },
          labels: {
            items: [{
              html: 'Statistik Total Dokumen',
              style: {
                left: '40px',
                top: '8px',
                color: 'black'
              }
            }]
          },
          series: [{
            type: 'column',
            name: 'File',
            data: [".$file."]
          }, {
            type: 'column',
            name: 'Gambar',
            data: [".$image."]
          }, {
            type: 'column',
            name: 'Audio',
            data: [".$audio."]
          }, {
            type: 'column',
            name: 'Video',
            data: [".$video."]
          }, {
            type: 'column',
            name: 'Konten Teks',
            data: [".$content."]
          }, {
            type: 'pie',
            name: 'Statistik Pembagian Dokumen',
            data: [{
              name: 'File',
              y: fileDokumen,
              color: '#4572A7' // Jane's color
            }, {
              name: 'Gambar',
              y: gambarDokumen,
              color: '#AA4643' // John's color
            }, {
              name: 'Audio',
              y: audioDokumen,
              color: '#89A54E' // Joe's color
            }, {
              name: 'Video',
              y: videoDokumen,
              color: '#816A9C' // Joe's color
            }, {
              name: 'Konten Teks',
              y: contentDokumen,
              color: '#3D95AD' // Joe's color
            }],
            center: [100, 80],
            size: 100,
            showInLegend: false,
            dataLabels: {
              enabled: false
            }
          }]
        });
      });
          
      
      
});
      </script>
    ";
 
 
  $view .= "$result";  
  $view .= '<div class="dado-core-chart-body" id="dado-chart"></div>';   
  $view .= "</div>";
            $view .= '</div>';
       $view .= '</div>';  
        $view .= '<div class="dado-core-desc-left">';
      
                     $view .= '<div class="dado-core-desc-left-header">
                            Daftar IP
                             </div>';
        
        
                          $view .= '<div class="dado-core-desc-left-body">';
                          $data = model::klasifikasi();
                          //print_r($data);
                          $view .= "<table cellpadding='0' cellspacing='0' class='core-listInformasiPublik-table'>";
                                      $view .= "<thead>";
                                                $view .= "<tr class='core-listInformasiPublik-thead-tr'>";
                                                $view .= "  <td colspan='3'>Klasifikasi Informasi Publik</td>";
                                                $view .= "  <td class='align-center'>Keterangan</td>  ";
                                                $view .= "</tr>";
                                      $view .= "</thead>";
                                      $view .= "<tbody>";

                                    //print_r($data[0]['klasifikasi']);
                                    if(!empty($data[0]['klasifikasi'])){
                                      foreach ($data[0]['klasifikasi'] as $key => $value) {
                                      
                                        $view .= $this->recursiveIP($value,0);

                                     }
                                   }
   
                                $view .= "</tbody>";
                              $view .= "<tfoot>";
                              $view .= "<tr>";
                              $view .= "  <td style='width:20px;'></td>";
                              $view .= "  <td style='min-width:15%; max-width:100px;'></td>";
                              $view .= "  <td ></td>";
                              $view .= "  <td style='min-width:25%; '></td>";
                              $view .= "</tr>";
                              $view .= "</tfoot>";
                              $view .= "</table>";

                                 $view .= '</div>';
      
      $view .= '</div>';


      $view .= '<div class="dado-core-desc-right">';

                $view .= '<div class="dado-core-desc-right-header">
                      Sejarah 7 Hari Terakhir
                    </div>';
    
                $view .= '<div class="dado-core-desc-right-body">';
    
                        $view .= self::historyUserDado();
    
                  $view .= '</div>
      </div>
                            
                            ';
    
      echo $view;
    
  }



  public function historyUserDado(){

    $sejarah = $this->getDadoHistory($user = true);

         

         

            if (!empty($sejarah)) {

              foreach ($sejarah as $key => $value) {

              $view .= "<div class='dado-core-sejarah-date-header'>".date("d, F Y",strtotime($value['DATE']))."</div>";

              $view .= "<hr class='dado-normal-hr'>";

              $view .= "<ul class='dado-core-sejarah-ul'>";

                if(!empty($value['VALUE'] )){

                  foreach ($value['VALUE'] as $key2 => $value2) {

                  $view .= "<li>".ucfirst(strtolower($value2['CAP_PER_HIS_EVENT']))." <br><span class='dado-core-sejarah-span'>(".date("H:i:s",strtotime($value2['DATETIME'])).")</span></li>";

                  $view .= "<hr class='dado-normal-hr'>";

                  }
                }

              $view .= "</ul>";

              $view .= "<br>";

              }

            }

        

          return $view;
  }
	
  public function sejarahUserDado(){

    $sejarah = $this->getDadoHistory($user = true);
    $view .="<div style='padding:15px;'>";
            if (!empty($sejarah)) {

              foreach ($sejarah as $key => $value) {

              $view .= "<div class='dado-core-sejarah-date-header'>".date("d, F Y",strtotime($value['DATE']))."</div>";

              $view .= "<hr class='dado-normal-hr'>";

              $view .= "<ul class='dado-core-sejarah-ul'>";

                if(!empty($value['VALUE'] )){

                  foreach ($value['VALUE'] as $key2 => $value2) {

                  $view .= "<li>".ucfirst(strtolower($value2['CAP_PER_HIS_EVENT']))." <br><span class='dado-core-sejarah-span'>(".date("H:i:s",strtotime($value2['DATETIME'])).")</span></li>";

                  $view .= "<hr class='dado-normal-hr'>";

                  }
                }

              $view .= "</ul>";

              $view .= "<br>";

              }

            }

        $view .= "</div>";

          echo $view;
  }
  
  

	public function klasifikasi(){
    
    
    $data  = $this->getSubMainMenu();
    
    $klasifikasi  = model::klasifikasi();
    
    //print_r($menu);
    

    $view .= $this->optionGear;
            	
        	$view .= "<table class='core-klasifikasi-table'>";
        	
        		$view .= "<thead>";
        	
        			
                $view .= "<tr>
        							<td colspan=5><span style='font-weight:bold'>Klasifikasi Dokumen</span></td>
        							<td class='admin-administrator-action'><button class='core-".$this->params."-actionAdd'></button></td>
        					  </tr>";
        			$view .= "<tr><td colspan=6><hr></td></tr>";
        			$view .= "<tr>";
        				$view .= "<td class='core-".$this->params."-container-tableHeader-action core-align-center' colspan='2'>Action</td>";
        				
        				$view .= "<td class='core-".$this->params."-container-tableHeader-action core-align-center'>Struktur</td>";
        				
   	 					$view .= "<td class='core-".$this->params."-container-tableHeader core-align-center'>Nama Klasifikasi</td>";
   	 					
   	 					$view .= "<td class='core-".$this->params."-container-tableHeader core-align-center'>Keterangan</td>";
 	 					  
   	 					$view .= "<td class='core-".$this->params."-container-tableHeader core-align-center'>Kode Klasifikasi</td>";

   	 				$view .= "</tr>";
   	 				$view .= "<tr><td colspan=6><hr></td></tr>";
        	
        		$view .= "</thead>";
        	
        		$view .= "<tbody class='sortableBody'>";
        		
        		
        		
        		$view .= view::listKlasifikasi();
        			
        		
        		
   	 		
   	 			$view .= "</tbody>";
   	 			
   	 			$view .= "<tfoot>";
       	 			$view .= "<tr>";
        
   	 					$view .= "<td class='core-".$this->params."-container-tableContent' colspan='2'>&nbsp;</td>";
   	 					   	 					
   	 					$view .= "<td class='core-".$this->params."-container-tableContent' colspan='2'></td>";
   	 					
   	 					$view .= "<td class='core-".$this->params."-container-tableContent' colspan='2'></td>";
   	 					
   	 		
   	 				$view .= "</tr>";

   	 		     
   	 			$view .= "</tfoot>";
   	 		
   	 		$view .= "</table>";
   	 	
   	 	//$view .= "</div>";
    
    
    
    $view .= "<input type='submit' class='core-klasifikasi-submit' value='Update'>";
    
    
    echo $view;
    
	}
	
	public function listKlasifikasi(){
		$klasifikasi = model::klasifikasi();
		
		if(!empty($klasifikasi[0]['klasifikasi'])){
			
				
			foreach($klasifikasi[0]['klasifikasi'] as $keys => $values){
				
				$set .= view::recursiveKlasifikasi($values,0);
			
			}
				
			
		}else{
				$set .= "<tr class='draggableKlasifikasi'><td class='core-draggableHandler' style='width:16px'><img src='library/capsule/core/images/list.png'></td>";
				
				$set .= "<td class='core-".$this->params."-container-tableContent core-align-center' style='width:100px;'>
				 <span class='core-".$this->params."-actionDelete'></span>
				 <input type='hidden' name='currentID' class='core-".$this->params."-inputRealID' value='insert-1'><input type='hidden' name='parentID' class='core-".$this->params."-input' value='".$value['parent']['CAP_KLA_PARENT']."'></td>";
			     $set .= "<td class='myStyles' padding='".$padding."' style='padding-left:".$padding."px;'>".$arrow."</td>";
				$set .= "<td class='core-".$this->params."-container-tableContent' ><input  type='text' class='core-".$this->params."-input  core-inputInherit' value='".$value['parent']['CAP_KLA_NAME']."'></td>";
					
				$set .= "<td class='core-".$this->params."-container-tableContent'>".$space."<input type='text' class='core-".$this->params."-input core-inputInherit1' value='".$value['parent']['CAP_KLA_NOTE']."'></td>";
					  
        $set .= "<td class='core-".$this->params."-container-tableContent'>".$space."<input type='text' class='core-".$this->params."-input core-inputInherit2' value='".$value['parent']['CAP_KLA_CODE']."'></td>";

			$set .= "</tr>";
			
		}
		
		return $set;
		
	}

	
	public function recursiveKlasifikasi($value,$i){
		$padding = 10;
		for($l=1;$l<=$i;$l++){
			
			$padding = $l*20;
		}
		$arrow="";
		if($i>0){
				$arrow .= '<img class="childKlasifikasi" src="library/capsule/core/images/rowChild.png" />';
		}else{
			$arrow .= '<img class="parentKlasifikasi" src="library/capsule/core/images/parent.png" />';
		}
				
			$set .= "<tr class='draggableKlasifikasi'><td class='core-draggableHandler' style='width:16px'><img src='library/capsule/core/images/list.png'></td>";
				
				$set .= "<td class='core-".$this->params."-container-tableContent core-align-center' style='width:100px;'><span class='core-".$this->params."-actionDelete'></span>
                 
                 <input type='hidden' name='currentID' class='core-".$this->params."-inputRealID' value='".$value['parent']['CAP_KLA_ID']."'><input type='hidden' name='parentID' class='core-".$this->params."-input' value='".$value['parent']['CAP_KLA_PARENT']."'></td>";
			     $set .= "<td class='myStyles' padding='".$padding."' style='padding-left:".$padding."px;'>".$arrow."</td>";
				$set .= "<td class='core-".$this->params."-container-tableContent' ><input  type='text' class='core-".$this->params."-input  core-inputInherit' value='".$value['parent']['CAP_KLA_NAME']."'></td>";
					
				$set .= "<td class='core-".$this->params."-container-tableContent'>".$space."<input type='text' class='core-".$this->params."-input core-inputInherit1' value='".$value['parent']['CAP_KLA_NOTE']."'></td>";
					  
        $set .= "<td class='core-".$this->params."-container-tableContent'>".$space."<input type='text' class='core-".$this->params."-input core-inputInherit' value='".$value['parent']['CAP_KLA_CODE']."'></td>";

			$set .= "</tr>";
			
			if(isset($value['child'])&& !empty($value['child'])){
					$i++;
					foreach($value['child'] as $valuesItem){
						
						$set .=self::recursiveKlasifikasi($valuesItem,$i);
					
					}
			}
			
			
		return $set;
	
		
		
	}
	
	public function publisher(){
    
    
    $data  = $this->getSubMainMenu();
    
    $klasifikasi  = model::publisher();
    
    //print_r($menu);
    

    $view .= $this->optionGear;
    
    $view .= "<div class='core-".$this->params."-container'>"; 
    
	    	$view .= "<table>";
     				
        	$view .= "</table>";
        	
        	$view .= "<table class='core-".$this->params."-table'>";
        	
        		$view .= "<thead>";
        	
        			
                $view .= "<tr>
        							<td colspan=4><span style='font-weight:bold'>Publisher Dokumen</span></td>
        							<td class='admin-administrator-action'><button class='core-".$this->params."-actionAdd'></button></td>
        					  </tr>";
        			$view .= "<tr><td colspan=5><hr></td></tr>";
        			$view .= "<tr>";
        				$view .= "<td class='core-".$this->params."-container-tableHeader-action core-align-center' colspan='2'>Aksi</td>";
        				
        				$view .= "<td class='core-".$this->params."-container-tableHeader-action core-align-center'>Struktur</td>";
        				
   	 					$view .= "<td class='core-".$this->params."-container-tableHeader core-align-center'>Nama Publisher</td>";
 	 					  
   	 					$view .= "<td class='core-".$this->params."-container-tableHeader core-align-center'>Kode Publisher</td>";

   	 				$view .= "</tr>";
   	 				$view .= "<tr><td colspan=6><hr></td></tr>";
        	
        		$view .= "</thead>";
        	
        		$view .= "<tbody class='sortableBody'>";
        		
        		
        		
        		$view .= view::listPublisher();
        			
        		
        		
   	 		
   	 			$view .= "</tbody>";
   	 			
   	 			$view .= "<tfoot>";
       	 			$view .= "<tr>";
        
   	 					$view .= "<td class='core-".$this->params."-container-tableContent' colspan='2'>&nbsp;</td>";
   	 					   	 					
   	 					$view .= "<td class='core-".$this->params."-container-tableContent' colspan='2'></td>";
   	 					
   	 					$view .= "<td class='core-".$this->params."-container-tableContent' colspan='1'></td>";
   	 					
   	 		
   	 				$view .= "</tr>";

   	 		     
   	 			$view .= "</tfoot>";
   	 		
   	 		$view .= "</table>";
   	 	
   	 	$view .= "</div>";
    
    
    
    $view .= "<input type='submit' class='core-publisher-submit' value='Update'>";
    
    $view .= "</div>";
    
    echo $view;
    
	}
	
	public function listPublisher(){
		$klasifikasi = model::publisher();
		
		if(!empty($klasifikasi[0]['publisher'])){
			
				
			foreach($klasifikasi[0]['publisher'] as $keys => $values){
				
				$set .= view::recursivePublisher($values,0);
			
			}
				
			
		}else{
				$arrow .= '<img class="parentKlasifikasi" src="library/capsule/core/images/parent.png" />';
				$set .= "<tr class='draggableKlasifikasi'><td class='core-draggableHandler' style='width:16px'><img src='library/capsule/core/images/list.png'></td>";
				
				$set .= "<td class='core-klasifikasi-container-tableContent core-align-center' style='width:100px;'>
				 <span class='core-klasifikasi-actionDelete'></span>
                 <input type='hidden' name='currentID' class='core-klasifikasi-inputRealID' value='insert-1'><input type='hidden' name='parentID' class='core-klasifikasi-input' value='".$value['parent']['CAP_PER_PUB_PARENT']."'></td>";
			     $set .= "<td class='myStyles' padding='".$padding."' style='padding-left:".$padding."px;'>".$arrow."</td>";
				$set .= "<td class='core-klasifikasi-container-tableContent' ><input  type='text' class='core-klasifikasi-input  core-inputInherit' value='".$value['parent']['CAP_PER_PUB_NAME']."'></td>";
					
				$set .= "<td class='core-klasifikasi-container-tableContent'>".$space."<input type='text' class='core-klasifikasi-input core-inputInherit1' value='".$value['parent']['CAP_PER_PUB_CODE']."'></td>";

			$set .= "</tr>";
			
		}
		
		return $set;
		
	}

	
	public function recursivePublisher($value,$i){
		$padding = 10;
		for($l=1;$l<=$i;$l++){
			
			$padding = $l*20;
		}
		$arrow="";
		if($i>0){
				$arrow .= '<img class="childKlasifikasi" src="library/capsule/core/images/rowChild.png" />';
		}else{
			$arrow .= '<img class="parentKlasifikasi" src="library/capsule/core/images/parent.png" />';
		}
				
			$set .= "<tr class='draggableKlasifikasi'><td class='core-draggableHandler' style='width:16px'><img src='library/capsule/core/images/list.png'></td>";
				
				$set .= "<td class='core-klasifikasi-container-tableContent core-align-center' style='width:100px;'>
				 <span class='core-klasifikasi-actionDelete'></span>
                 <input type='hidden' name='currentID' class='core-klasifikasi-inputRealID' value='".$value['parent']['CAP_PER_PUB_ID']."'><input type='hidden' name='parentID' class='core-klasifikasi-input' value='".$value['parent']['CAP_PER_PUB_PARENT']."'></td>";
			     $set .= "<td class='myStyles' padding='".$padding."' style='padding-left:".$padding."px;'>".$arrow."</td>";
				$set .= "<td class='core-klasifikasi-container-tableContent' ><input  type='text' class='core-klasifikasi-input  core-inputInherit' value='".$value['parent']['CAP_PER_PUB_NAME']."'></td>";
					
					  
        $set .= "<td class='core-klasifikasi-container-tableContent'>".$space."<input type='text' class='core-klasifikasi-input core-inputInherit1' value='".$value['parent']['CAP_PER_PUB_CODE']."'></td>";

			$set .= "</tr>";			
			if(isset($value['child'])&& !empty($value['child'])){
					$i++;
					foreach($value['child'] as $valuesItem){
						
						$set .=self::recursivePublisher($valuesItem,$i);
					
					}
			}
			
			
		return $set;
	
		
		
	}
	
	public function grouping(){
       
    $data  = $this->getSubMainMenu();
    
    $klasifikasi  = model::grouping();
    
    //print_r($menu);
    

    $view .= $this->optionGear;
    
    $view .= "<div class='core-".$this->params."-container'>"; 
    
	    	$view .= "<table>";
     				
        	$view .= "</table>";
        	
        	$view .= "<table class='core-".$this->params."-table'>";
        	
        		$view .= "<thead>";
        	
        			
                $view .= "<tr>
        							<td colspan=4><span style='font-weight:bold'>Grouping Dokumen</span></td>
        							<td class='admin-administrator-action'><button class='core-grouping-actionAdd'></button></td>
        					  </tr>";
        			$view .= "<tr><td colspan=5><hr></td></tr>";
        			$view .= "<tr>";
        				$view .= "<td class='core-publisher-container-tableHeader-action core-align-center' colspan='2'>Aksi</td>";
        				
        				$view .= "<td class='core-publisher-container-tableHeader-action core-align-center'>Struktur</td>";
        				
   	 					$view .= "<td class='core-publisher-container-tableHeader core-align-center'>Nama Group</td>";
 	 					  
   	 					$view .= "<td class='core-publisher-container-tableHeader core-align-center'>Keterangan</td>";

   	 				$view .= "</tr>";
   	 				$view .= "<tr><td colspan=6><hr></td></tr>";
        	
        		$view .= "</thead>";
        	
        		$view .= "<tbody class='sortableBody'>";
        		
        		
        		
        		$view .= view::listGrouping();
        			
        		
        		
   	 		
   	 			$view .= "</tbody>";
   	 			
   	 			$view .= "<tfoot>";
       	 			$view .= "<tr>";
        
   	 					$view .= "<td class='core-".$this->params."-container-tableContent' colspan='2'>&nbsp;</td>";
   	 					   	 					
   	 					$view .= "<td class='core-".$this->params."-container-tableContent' colspan='2'></td>";
   	 					
   	 					$view .= "<td class='core-".$this->params."-container-tableContent' colspan='1'></td>";
   	 					
   	 		
   	 				$view .= "</tr>";

   	 		     
   	 			$view .= "</tfoot>";
   	 		
   	 		$view .= "</table>";
   	 	
   	 	$view .= "</div>";
    
    
    
    $view .= "<input type='submit' class='core-grouping-submit' value='Update'>";
    
    $view .= "</div>";
    
    echo $view;
    
	}
	
	public function listGrouping(){
		$klasifikasi = model::grouping();
		
		if(!empty($klasifikasi[0]['grouping'])){
			
				
			foreach($klasifikasi[0]['grouping'] as $keys => $values){
				
				$set .= view::recursiveGrouping($values,0);
			
			}
				
			
		}else{
				$arrow .= '<img class="parentKlasifikasi" src="library/capsule/core/images/parent.png" />';
				$set .= "<tr class='draggableKlasifikasi'><td class='core-draggableHandler' style='width:16px'><img src='library/capsule/core/images/list.png'></td>";
				
				$set .= "<td class='core-klasifikasi-container-tableContent core-align-center' style='width:100px;'>
				 <span class='core-klasifikasi-actionDelete'></span>
				 <!--span class='core-klasifikasi-actionSetTime'></span>
                 <span class='core-klasifikasi-actionSetShow'></span>
                 <input type='hidden' name='currentID' class='core-klasifikasi-inputRealID' value='insert-1'><input type='hidden' name='parentID' class='core-klasifikasi-input' value=''></td>";
			     $set .= "<td class='myStyles' padding='".$padding."' style='padding-left:10px;'>".$arrow."</td>";
				$set .= "<td class='core-klasifikasi-container-tableContent' ><input  type='text' class='core-klasifikasi-input  core-inputInherit' value=''></td>";
					
				$set .= "<td class='core-klasifikasi-container-tableContent'>".$space."<input type='text' class='core-klasifikasi-input core-inputInherit1' value=''></td>";

			$set .= "</tr>";
			
		}
		
		return $set;
		
	}

	
	public function recursiveGrouping($value,$i){
		$padding = 10;
		for($l=1;$l<=$i;$l++){
			
			$padding = $l*20;
		}
		$arrow="";
		if($i>0){
				$arrow .= '<img class="childKlasifikasi" src="library/capsule/core/images/rowChild.png" />';
		}else{
			$arrow .= '<img class="parentKlasifikasi" src="library/capsule/core/images/parent.png" />';
		}
				
			$set .= "<tr class='draggableKlasifikasi'><td class='core-draggableHandler' style='width:16px'><img src='library/capsule/core/images/list.png'></td>";
				
				$set .= "<td class='core-klasifikasi-container-tableContent core-align-center' style='width:100px;'>
				 <span class='core-klasifikasi-actionDelete'></span>
				 <!--span class='core-klasifikasi-actionSetTime'></span-->
                 <span class='core-klasifikasi-actionSetShow'></span>
                 <input type='hidden' name='currentID' class='core-klasifikasi-inputRealID' value='".$value['parent']['CAP_GRO_ID']."'><input type='hidden' name='parentID' class='core-klasifikasi-input' value='".$value['parent']['CAP_GRO_PARENT']."'></td>";
			     $set .= "<td class='myStyles' padding='".$padding."' style='padding-left:".$padding."px;'>".$arrow."</td>";
				$set .= "<td class='core-klasifikasi-container-tableContent' ><input  type='text' class='core-klasifikasi-input  core-inputInherit' value='".$value['parent']['CAP_GRO_NAME']."'></td>";
					
					  
        $set .= "<td class='core-klasifikasi-container-tableContent'>".$space."<input type='text' class='core-klasifikasi-input core-inputInherit1' value='".$value['parent']['CAP_GRO_NOTE']."'></td>";

			$set .= "</tr>";			
			if(isset($value['child'])&& !empty($value['child'])){
					$i++;
					foreach($value['child'] as $valuesItem){
						
						$set .=self::recursiveGrouping($valuesItem,$i);
					
					}
			}
			
			
		return $set;
	
		
		
	}


	public function listInformasiPublik(){
		$data = model::klasifikasi();
    //print_r($data);
    $view .= "<table cellpadding='0' cellspacing='0' class='core-listInformasiPublik-table'>";
		$view .= "<thead>";
		$view .= "<tr class='core-listInformasiPublik-thead-tr'>";
		$view .= "	<td colspan='3'>Klasifikasi Informasi Publik</td>";
		$view .= "	<td class='align-center'>Keterangan</td>	";
		$view .= "</tr>";
		$view .= "</thead>";
		$view .= "<tbody>";

    print_r($data[0]['klasifikasi']);
    if(!empty($data[0]['klasifikasi'])){
      foreach ($data[0]['klasifikasi'] as $key => $value) {
      
        $view .= $this->recursiveIP($value,0);

     }
   }
   
   

/*
		$view .= "<tr class='core-listInformasiPublik-tbody-tr-klas'>";
		$view .= "<td class='core-listInformasiPublik-collapse '><span class='core-image-actionPlus core-image-plus'></span><input type='hidden' name='child' value=''><input type='hidden' name='currentID' value='1'><input type='hidden' name='parentID' value=''></td>";
		$view .= "<td class='core-listInformasiPublik-klas' colspan=\"2\">Informasi Publik yang di dapatkan secara serta merta</td>";
		$view .= "<td class='core-listInformasiPublik-ket align-center'>3 Tahun</td>";
		$view .= "</tr>";
			$view .= "<tr class='core-listInformasiPublik-tbody-tr-file' style='display:none'>";
			$view .= "<td ><input type='hidden' name='parentID' value='1'></td>";
			$view .= "<td class='core-listInformasiPublik-no align-center'>1</td>";
			$view .= "<td class='core-listInformasiPublik-file border-left'>Sejarah Singkat.pdf</td>";
			$view .= "<td class='core-listInformasiPublik-action border-left align-center'><span class='core-image-actionTagging core-image-taggingShow'></span><span class='core-image-actionClassification core-image-classificationShow'></span><span class='core-image-actionFolder core-image-folderShow'></span><span class='core-image-actionDownload core-image-download'></span></td>";
			$view .= "</tr>";
			$view .= "<tr class='core-listInformasiPublik-tbody-tr-file-2' style='display:none'>";
			$view .= "<td><input type='hidden' name='parentID' value='1'></td>";
			$view .= "<td class='core-listInformasiPublik-no align-center'>2</td>";
			$view .= "<td class='core-listInformasiPublik-file border-left'>Sejarah Singkat.pdf</td>";
			$view .= "<td class='core-listInformasiPublik-action border-left align-center'>sfg sdfs d sd sd sdf s</td>";
			$view .= "</tr>";
			$view .= "<tr class='core-listInformasiPublik-tbody-tr-klas' style='display:none'>";
			$view .= "<td class='core-listInformasiPublik-collapse'><span class='core-image-actionPlus core-image-plus'></span><input type='hidden' name='child' value=''><input type='hidden' name='currentID' value='2'><input type='hidden' name='parentID' value='1'></td>";
			$view .= "<td class='core-listInformasiPublik-klas' colspan=\"2\">Informasi Publik yang di dapatkan secara serta merta</td>";
			$view .= "<td class='core-listInformasiPublik-ket align-center'>3 Tahun</td>";
			$view .= "</tr>";
				$view .= "<tr class='core-listInformasiPublik-tbody-tr-file' style='display:none'>";
				$view .= "<td ><input type='hidden' name='parentID' value='2'></td>";
				$view .= "<td class='core-listInformasiPublik-no align-center'>1</td>";
				$view .= "<td class='core-listInformasiPublik-file border-left'>Sejarah Singkat.pdf</td>";
				$view .= "<td class='core-listInformasiPublik-action border-left align-center'><span class='core-image-actionClassification core-image-classificationShow'></span></td>";
				$view .= "</tr>";
				$view .= "<tr class='core-listInformasiPublik-tbody-tr-file-2' style='display:none'>";
				$view .= "<td><input type='hidden' name='parentID' value='2'></td>";
				$view .= "<td class='core-listInformasiPublik-no align-center'>2</td>";
				$view .= "<td class='core-listInformasiPublik-file border-left'>Sejarah Singkat.pdf</td>";
				$view .= "<td class='core-listInformasiPublik-action border-left align-center'>sfg sdfs d sd sd sdf s</td>";
				$view .= "</tr>";
				$view .= "<tr class='core-listInformasiPublik-tbody-tr-klas' style='display:none'>";
				$view .= "<td class='core-listInformasiPublik-collapse'><span class='core-image-actionPlus core-image-plus'></span><input type='hidden' name='child' value=''><input type='hidden' name='currentID' value='3'><input type='hidden' name='parentID' value='2'></td>";
				$view .= "<td class='core-listInformasiPublik-klas' colspan=\"2\">Informasi Publik yang di dapatkan secara serta merta</td>";
				$view .= "<td class='core-listInformasiPublik-ket align-center'>3 Tahun</td>";
				$view .= "</tr>";
					$view .= "<tr class='core-listInformasiPublik-tbody-tr-file' style='display:none'>";
					$view .= "<td ><input type='hidden' name='parentID' value='3'></td>";
					$view .= "<td class='core-listInformasiPublik-no align-center'>1</td>";
					$view .= "<td class='core-listInformasiPublik-file border-left'>Sejarah Singkat.pdf</td>";
					$view .= "<td class='core-listInformasiPublik-action border-left align-center'>asdasdasd</td>";
					$view .= "</tr>";
					$view .= "<tr class='core-listInformasiPublik-tbody-tr-file-2' style='display:none'>";
					$view .= "<td><input type='hidden' name='parentID' value='3'></td>";
					$view .= "<td class='core-listInformasiPublik-no align-center'>2</td>";
					$view .= "<td class='core-listInformasiPublik-file border-left'>Sejarah Singkat.pdf</td>";
					$view .= "<td class='core-listInformasiPublik-action border-left align-center'>sfg sdfs d sd sd sdf s</td>";
					$view .= "</tr>";*/


		$view .= "</tbody>";
		$view .= "<tfoot>";
		$view .= "<tr>";
		$view .= "	<td style='width:20px;'></td>";
		$view .= "	<td style='min-width:15%; max-width:100px;'></td>";
		$view .= "	<td ></td>";
		$view .= "	<td style='min-width:25%; '></td>";
		$view .= "</tr>";
		$view .= "</tfoot>";
		$view .= "</table>";
		
		echo $view;
	}

  public function recursiveIP($data,$i){
      if(!empty($data)){
        if(empty($i) || $i == 0){
        
          $i = 0;
        
          $padding = $i ;
          $rowChild ="";
          $display ="";
        }else{
        
          $padding = $i * 20;
          $rowChild = "<img src='library/capsule/core/images/rowChild.png' style='padding-left:".$padding."px; margin-right:5px;'>";   
          $display = "style='display:none'";
        }
       
        
          $view .= "<tr class='core-listInformasiPublik-tbody-tr-klas' ".$display.">";
          $view .= "<td class='core-listInformasiPublik-collapse '><span class='core-image-actionPlus core-image-plus'></span>
                    <input type='hidden' name='child' value=''><input type='hidden' name='currentID' value='".$data['parent']['CAP_KLA_ID']."'>
                    <input type='hidden' name='parentID' value='".$data['parent']['CAP_KLA_PARENT']."'></td>";
          $view .= "<td class='core-listInformasiPublik-klas' colspan=\"2\">".$rowChild."<span>".$data['parent']['CAP_KLA_NAME']."</span></td>";
          $view .= "<td class='core-listInformasiPublik-ket align-center'>".$data['parent']['CAP_KLA_NOTE']."</td>";
          $view .= "</tr>";


           if(isset($data['item'])){
            $n=1;
            foreach ($data['item'] as $key => $value) {
              
              $view .= self::setItem($value,$n);
              $n++;
           }
         }

          if(isset($data['child'])){
             $i++;
            foreach ($data['child'] as $keys => $values) {
                          
              $view .= self::recursiveIP($values,$i);
              
            }


          }

          
       
        }
      
      

      return $view;
  }

  

  public function setItem($value,$i){
    $c=$i%2;
    if($c==0){
      $n='-2';
    }else{
      $n='';
    }

    $view .= "<tr class='core-listInformasiPublik-tbody-tr-file".$n."' style='display:none'>";
      $view .= "<td><input type='hidden' name='parentID' value='".$value[CAP_KLA_ID]."'>";
      $view .= "<input type='hidden' name='itemID' value='".$value[CAP_LAN_COM_ID]."'></td>";
      $view .= "<td class='core-listInformasiPublik-no align-center'>".$i."</td>";
      $view .= "<td class='core-listInformasiPublik-file border-left' colspan=\"2\">".$value[CAP_CON_MET_CONTENT]."</td>";
     
      /*$view .= "<td class='core-listInformasiPublik-action border-left align-center'><span class='core-image-actionTagging core-image-showTagging'></span><span class='core-image-actionClassification core-image-classificationShow'></span><span class='core-image-actionFolder core-image-folderShow'></span><span class='core-image-actionDownload core-image-download'></span></td>";*/
      $view .= "</tr>";
      
      return $view;

  }
  
  public function sidadoSearch(){
	  $view .= "<div class='search-". $this->params ."-container'><input class='search-". $this->params ."-input' type='text' value='Type to search...'></div>";
	
    $view .= "
    
    <script type='text/javascript'>
    
    jQuery.noConflict()(function($){
    
    var delay = (function(){
    var timer = 0;
    return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
    };
    })();
    	
    $('.search-sidadoSearch-input').focus(function() {
    
    	if ($(this).val() == 'Type to search...') {
    	$(this).val('');
    	$(this).removeClass(); $(this).addClass('search-sidadoSearch-input-active');
    	}
    	
    });
    
    $('.search-sidadoSearch-input').blur(function() {
    
    	if ($(this).val() == '') {
    	$(this).val('Type to search...');
    	$(this).removeClass(); $(this).addClass('search-sidadoSearch-input');
    	$('.search-sidadoSearch-result').slideUp('fast',function() {
    	$('.search-sidadoSearch-result').remove();
    	});
    	}
    	
    });
    
    $('.search-sidadoSearch-input').keyup(function() {
    
    var check = $('.search-sidadoSearch-result').length;
    var text  = $('.search-sidadoSearch-input-active').val();
    
    	if (check == 0) {
    	var position = $('.search-sidadoSearch-input-active').offset();
    	$('body').append('<div class=\'search-sidadoSearch-result\'><div class=\'search-sidadoSearch-content\'></div><div class=\'search-sidadoSearch-loader\'><img class=\'search-sidadoSearch-ajaxLoader\' src=\'library/images/ajax-loader.gif\'> Loading..</div></div>');
    	$('.search-sidadoSearch-result').hide();
    	$('.search-sidadoSearch-result').css('top', position.top + 23 + 'px').css('left', position.left + 11 + 'px');
    	$('.search-sidadoSearch-result').slideDown('fast');
    	}
    	
    	if ($('.search-sidadoSearch-loader:hidden').length == 1) {
    	$('.search-sidadoSearch-loader').show();
    	}
    	
    	delay(function(){
    		if (text != '') {
    			$.post('library/capsule/core/core.ajax.php',{control:'getSearchResult',text:text}, function(data) {
    			$('.search-sidadoSearch-content').html(data); $('.search-sidadoSearch-loader').hide();
    			});
    		}
    		else {
    		$('.search-sidadoSearch-result').slideUp('fast',function() {
    		$('.search-sidadoSearch-result').remove();
    		});
    		}
    	}, 500 );
    	
    });
    
    });
    
    </script>";
    
    echo $view;

  }
    public function sidadoSearchUser(){
     $this->params = "sidadoSearch";
	  $view .= "<div class='search-". $this->params ."-container'><input class='search-". $this->params ."-input' type='text' value='Type to search...'></div>";
	
    $view .= "
    
    <script type='text/javascript'>
    
    jQuery.noConflict()(function($){
    
    var delay = (function(){
    var timer = 0;
    return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
    };
    })();
    	
    $('.search-sidadoSearch-input').focus(function() {
    
    	if ($(this).val() == 'Type to search...') {
    	$(this).val('');
    	$(this).removeClass(); $(this).addClass('search-sidadoSearch-input-active');
    	}
    	
    });
    
    $('.search-sidadoSearch-input').blur(function() {
    
    	if ($(this).val() == '') {
    	$(this).val('Type to search...');
    	$(this).removeClass(); $(this).addClass('search-sidadoSearch-input');
    	$('.search-sidadoSearch-result').slideUp('fast',function() {
    	$('.search-sidadoSearch-result').remove();
    	});
    	}
    	
    });
    
    $('.search-sidadoSearch-input').keyup(function() {
    
    var check = $('.search-sidadoSearch-result').length;
    var text  = $('.search-sidadoSearch-input-active').val();
    
    	if (check == 0) {
    	var position = $('.search-sidadoSearch-input-active').offset();
    	$('body').append('<div class=\'search-sidadoSearch-result\'><div class=\'search-sidadoSearch-content\'></div><div class=\'search-sidadoSearch-loader\'><img class=\'search-sidadoSearch-ajaxLoader\' src=\'library/images/ajax-loader.gif\'> Loading..</div></div>');
    	$('.search-sidadoSearch-result').hide();
    	$('.search-sidadoSearch-result').css('top', position.top + 23 + 'px').css('left', position.left + 11 + 'px');
    	$('.search-sidadoSearch-result').slideDown('fast');
    	}
    	
    	if ($('.search-sidadoSearch-loader:hidden').length == 1) {
    	$('.search-sidadoSearch-loader').show();
    	}
    	
    	delay(function(){
    		if (text != '') {
    			$.post('library/capsule/core/core.ajax.php',{control:'getSearchResultUser',text:text}, function(data) {
    			$('.search-sidadoSearch-content').html(data); $('.search-sidadoSearch-loader').hide();
    			});
    		}
    		else {
    		$('.search-sidadoSearch-result').slideUp('fast',function() {
    		$('.search-sidadoSearch-result').remove();
    		});
    		}
    	}, 500 );
    	
    });
    
    });
    
    </script>";
    
    echo $view;

  }
  public function search() {
		
	$view = "<table class='search-". $this->params ."-table'>";
		
	if (!empty($this->data)) {
    //print_r($this->data);
		foreach ($this->data as $key => $value) {

  		if(!empty($value[header]) && !empty($value[header]) && !empty($value[id])){

        if($value[type] == 'header' || $value[type] == 'content'){

          $value[type] = "content";

          $admin = "actionNextContentAdmin";

        }else{
          $admin = "actionNextAdmin";
        }

    		$view .= "<tr><td><input type='hidden' name='contentID' value='$value[id]'><input type='hidden' class='core-headerOfContentInputTypeOfFile-search' value='$value[type]'><span class='core-image-".$admin."'></span><a class='core-image-container-tableContentHuge'>$value[header]</a></td></tr>";
    				
    		$view .= "<tr><td>".trim(preg_replace("/&#?[a-z0-9]{2,8};/i"," ",$value['content']))."..</td></tr>";
    		
    		$view .= "<tr><td><hr /></td></tr>";

  		}

		}
	
	}

	$view .= "</table>";
	
	echo $view;
	
  }
   public function searchuser() {
		
	$view = "<table class='search-". $this->params ."-table'>";
		
	if (!empty($this->data)) {
    //print_r($this->data);
		foreach ($this->data as $key => $value) {

  		if(!empty($value[header]) && !empty($value[header]) && !empty($value[id])){

        if($value[type] == 'header' || $value[type] == 'content'){

          $value[type] = "content";

          $admin = "actionNextContent";

        }else{
          $admin = "actionNextUser";
        }

    		$view .= "<tr><td><input type='hidden' name='contentID' value='$value[id]'><input type='hidden' class='core-headerOfContentInputTypeOfFile-search' value='$value[type]'><span class='core-image-".$admin."'></span><a class='core-image-container-tableContentHuge'>$value[header]</a></td></tr>";
    				
    		$view .= "<tr><td>".trim(preg_replace("/&#?[a-z0-9]{2,8};/i"," ",$value['content']))."..</td></tr>";
    		
    		$view .= "<tr><td height=10px><hr /></td></tr>";

  		}

		}
	
	}

	$view .= "</table>";
	
	echo $view;
	
  }

  public function setRetensiWaktu(){
    
 

  if(!empty($this->data[0]['CAP_GRO_TIME'])){
     $data = date('d-m-Y', strtotime($this->data[0]['CAP_GRO_TIME']));
  }  

  $view .= "<input class='core-tagging-deleter-meta' type='hidden'>";
  
  $view .= "<table class='core-administrator-content-tagging'>";
  
  $view .= "<thead>";
  
  $view .= "<tr><td colspan=1><span style='font-weight:bold'>Set Retensi Waktu</span></td><td class='core-administrator-action'></tr>";
  
  $view .= "<tr><td colspan=3><hr></td></tr>";
  
  $view .= "</thead>";
  
  $view .= "<tbody>";
    
  $view .= "<tr>";
  
  $view .= "<td>
  ";
 
  
  $view .= "<input type='text' class='datepicker' value='' />";
  
  $view .= "<input type='hidden' class='core-tagging-contentFKID' value='".$idData."'>";
  
  $view .= "</td>";
  
  $view .= "</tr>"; 
      
  $view .= "<tr><td colspan=3><hr></td></tr>";
      
  $view .= "</tbody>";
  
  $view .= "</table>
  <script type='text/javascript'>
  jQuery.noConflict()(function($){
    $('.datepicker').datepicker();
  $('.datepicker').datepicker('option','dateFormat','dd-mm-yy');
  $('.datepicker').val('".$data."');
});</script>";
  
  $view .= "<button class='core-administrator-retensiSubmit'>Save</button>
            <button class='core-administrator-setShowCancel'>Cancel</button>";
  
  echo $view;
  }

  public function setRetensiWaktuContent(){
    
 

  if(!empty($this->data[0]['CAP_LAN_COM_TIME'])){
     $data = date('d-m-Y', strtotime($this->data[0]['CAP_LAN_COM_TIME']));
  }  

  $view .= "<input class='core-tagging-deleter-meta' type='hidden'>";
  
  $view .= "<table class='core-administrator-content-tagging'>";
  
  $view .= "<thead>";
  
  $view .= "<tr><td colspan=1><span style='font-weight:bold'>Set Retensi Waktu</span></td><td class='core-administrator-action'></tr>";
  
  $view .= "<tr><td colspan=3><hr></td></tr>";
  
  $view .= "</thead>";
  
  $view .= "<tbody>";
    
  $view .= "<tr>";
  
  $view .= "<td>
  ";
 
  
  $view .= "<input type='text' class='datepicker' value='' />";
  
  $view .= "<input type='hidden' class='core-tagging-contentFKID' value='".$idData."'>";
  
  $view .= "</td>";
  
  $view .= "</tr>"; 
      
  $view .= "<tr><td colspan=3><hr></td></tr>";
      
  $view .= "</tbody>";
  
  $view .= "</table>
  <script type='text/javascript'>
  jQuery.noConflict()(function($){
    $('.datepicker').datepicker();
  $('.datepicker').datepicker('option','dateFormat','dd-mm-yy');
  $('.datepicker').val('".$data."');
});</script>";
  
  $view .= "<button class='core-administrator-retensiContentSubmit'>Save</button>
            <button class='core-administrator-setShowCancel'>Cancel</button>";
  
  echo $view;
  }
  
  public function setShow(){
    
		  if(!empty($this->data[0]['CAP_GRO_SHOW'])){
		     $data = $this->data[0]['CAP_GRO_SHOW'];
		  }  
		
		  $view .= "<input class='core-tagging-deleter-meta' type='hidden'>";
		  
		  $view .= "<table class='core-administrator-content-setShow'>";
		  
		  $view .= "<thead>";
		  
		  $view .= "<tr><td colspan=2><span style='font-weight:bold'>Set Grouping Visibility</span></td></tr>";
		  
		  $view .= "<tr><td colspan=3><hr></td></tr>";
		  
		  $view .= "</thead>";
		  
		  $view .= "<tbody>";
		    
		  $view .= "<tr>";
		  
		  $view .= "<td>";
		  
		  $view .= "Tampilkan Group?";
		  
		  $view .= "</td>";
		  
		  $view .= "<td>";
		  
		  $view .= "<select class=''>";
		  
		  if($data == 0){
			  $view .= '<option value="0" selected="selected">Tidak</option>';
			  $view .= '<option value="1">Ya</option>';
		  }else{
			  $view .= '<option value="0">Tidak</option>';
			  $view .= '<option value="1" selected="selected">Ya</option>';
		  }
		  
		  $view .= "</view>";
		  
		  $view .= "<input type='hidden' class='core-tagging-contentFKID' value=''>";
		  
		  $view .= "</td>";
		  
		  $view .= "</tr>"; 
		      
		  $view .= "<tr><td colspan=3><hr></td></tr>";
		      
		  $view .= "</tbody>";
		  
		  $view .= "</table>";
		  
		  $view .= "<button class='core-administrator-showSubmit'>Save</button>
		            <button class='core-administrator-showCancel'>Cancel</button>";
		  
		  echo $view;
  }
  
  public function setShowContent(){
    
		  if(!empty($this->data[0]['CAP_LAN_COM_PUBLISH'])){
		     $data = $this->data[0]['CAP_LAN_COM_PUBLISH'];
		  }  
		  if(!empty($this->data[0]['CAP_LAN_COM_DOWNLOADABLE'])){
			 $down = $this->data[0]['CAP_LAN_COM_DOWNLOADABLE']; 
		  }
		  
		  
		  $view .= '<script type="text/javascript">jQuery(".select-with-choosen").chosen();</script>';
		  
		  $view .= "<input class='core-tagging-deleter-meta' type='hidden'>";
		  
		  $view .= "<table class='core-administrator-content-setShow'>";
		  
		  $view .= "<thead>";
		  
		  $view .= "<tr><td colspan=2><span style='font-weight:bold'>Set Visibilitas</span></td></tr>";
		  
		  $view .= "<tr><td colspan=3><hr></td></tr>";
		  
		  $view .= "</thead>";
		  
		  $view .= "<tbody>";
		    
		  $view .= "<tr>";
		  
		  $view .= "<td>";
		  
		  $view .= "Show Document";
		  
		  $view .= "</td>";
		  
		  $view .= "<td>";
		  
		  $view .= " <select class='select-with-choosen' style='width:250px' data-placeholder='Select Visibility...'>";
		 // print_r($data);
		  if($data == 0){
			  $view .= '<option value="0" selected="selected">Tidak</option>';
			  $view .= '<option value="1">Ya</option>';
		  }else{
			  $view .= '<option value="0">Tidak</option>';
			  $view .= '<option value="1" selected="selected">Ya</option>';
		  }
		  
		  $view .= "</select>";
		  
		  $view .= "<input type='hidden' class='core-tagging-contentFKID' value=''>";
		  
		  $view .= "</td>";
		  
		  $view .= "</tr>"; 
		  
		  $view .= "<tr>";
		  
		  $view .= "<td>";
		  
		  $view .= "Downloadable";
		  
		  $view .= "</td>";
		  
		  $view .= "<td>";
		  
		  $view .= " <select class='select-with-choosen' style='width:250px' data-placeholder='Set Downloadable...'>";
		  
		  if($down == 0){
			  $view .= '<option value="0" selected="selected">Tidak</option>';
			  $view .= '<option value="1">Ya</option>';
		  }else{
			  $view .= '<option value="0">Tidak</option>';
			  $view .= '<option value="1" selected="selected">Ya</option>';
		  }
		  
		  $view .= "</select>";
		  
		  $view .= "</td>";
		  
		  $view .= "</tr>"; 
		  
		  $view .= "<tr>";
		  
		  $view .= "<td>";
		  
		  $view .= "Group";
		  
		  $view .= "</td>";
		  
		  $view .= "<td>";
		  
		  $view .= " <select class='select-with-choosen' style='width:250px' data-placeholder='Select Group...'>";
		  
		  $view .="<option value=''>Pilih Group...</option>";
		
		  $view .= view::getGrouping($this->data[0]['FK_GRO_ID']);			  
		
		  $view .= "</select>";
		  
		  
		  $view .= "</td>";
		  
		  $view .= "</tr>"; 
		  		      
		  $view .= "<tr><td colspan=3><hr></td></tr>";
		      
		  $view .= "</tbody>";
		  
		  $view .= "</table>";
		  
		  $view .= "<button class='core-administrator-showSubmitContent'>Save</button>
		            <button class='core-administrator-showCancel'>Cancel</button>";
		  
		  echo $view;
  }
  
  public function getGrouping($value=null){
		$klasifikasi = model::grouping();
		
		if(!empty($klasifikasi)){
			
				
			foreach($klasifikasi[0]['grouping'] as $keys => $values){
				
				$set .= view::getRecursiveGrouping($values,1,$value);
			
			}
				
			
		}
		//print_r('grouping');
		
		return $set;
		
	}
	
	public function getRecursiveGrouping($array,$i,$value){
				
		$padding=0;
		
		for($j=1;$j <= $i; $j++){
			if($i==1){continue;}$padding=$i*5;
			for($k=0;$k <= $i;$k++){
				$nbsp .= "&nbsp;";
			}
		}
		if(!empty($value)){
			$klaID = $array['parent']['CAP_GRO_ID'];
			if($klaID == $value){
				$selected ="selected='selected'";
			}else{
				$selected="";
		}
		}
		
			
			$set .= "<option ".$selected." padding='".$padding."' value='".$array['parent']['CAP_GRO_ID']."'>".$nbsp.$array['parent']['CAP_GRO_NAME']."</option>";
			
			
			if(isset($array['child'])){
					$i++;
					foreach($array['child'] as $valuesItem){
						
						$set .=self::getRecursiveGrouping($valuesItem,$i,$value);
					
					}
			}
		
		
		
		return $set;
	}

  public function tracking($setDateFrom = null, $setDateTO = null, $typeOfDate = null){
    $data = $this->getDadoStats($setDateFrom, $setDateTO, $typeOfDate);
    //print_r($data);
    
    


    for($i = 6; $i >= 0; $i--){

      $jeda = $i * 86400;
      $date = strtotime(date('Y-m-d'))-$jeda;
      $date = date('Y-m-d', $date);
      $setDate .= "'".date('d/m',strtotime($date))."', ";
      if($i == 6){
        $dateFrom = date('d M Y',strtotime($date));
        $dateTo = date('d M Y');
      }
      $found = null; 
      if(!empty($data[0]['file'])){
            foreach ($data[0]['file'] as $key => $value) {
                
              $dateVal = $value['DATETIME'];
              if($date == $dateVal){
                $file .= $value['COUNT'].',';
                $found = 1;
              }

            }
        
        if(empty($found)){
          $file .= '0,';
          
        }
      
    }

  }
     if(!empty($data[0]['image'])){
    for($i = 6; $i >= 0; $i--){
      $jeda = $i * 86400;
      $date = strtotime(date('Y-m-d'))-$jeda;
      $date = date('Y-m-d', $date);
      $found = null;
            foreach ($data[0]['image'] as $key => $value) {
                
              $dateVal = $value['DATETIME'];
              if($date == $dateVal){
                $image .= $value['COUNT'].',';
                $found = 1;
              }

            }
        
        if(empty($found)){
          $image .= '0,';
          
        }
      
    }
}

     if(!empty($data[0]['video'])){
     for($i = 6; $i >= 0; $i--){
      $jeda = $i * 86400;
      $date = strtotime(date('Y-m-d'))-$jeda;
      $date = date('Y-m-d', $date);
      $found = null;
            foreach ($data[0]['video'] as $key => $value) {
                
              $dateVal = $value['DATETIME'];
              if($date == $dateVal){
                $video .= $value['COUNT'].',';
                $found = 1;
              }

            }
        
        if(empty($found)){
          $video .= '0,';
          
        }
      
    }

}
     if(!empty($data[0]['audio'])){
    for($i = 6; $i >= 0; $i--){
      $jeda = $i * 86400;
      $date = strtotime(date('Y-m-d'))-$jeda;
      $date = date('Y-m-d', $date);
      $found = null;
            foreach ($data[0]['audio'] as $key => $value) {
                
              $dateVal = $value['DATETIME'];
              if($date == $dateVal){
                $audio .= $value['COUNT'].',';
                $found = 1;
              }

            }
        
        if(empty($found)){
          $audio .= '0,';
          
        }
      
    }
}

     if(!empty($data[0]['content'])){
    for($i = 6; $i >= 0; $i--){
      $jeda = $i * 86400;
      $date = strtotime(date('Y-m-d'))-$jeda;
      $date = date('Y-m-d', $date);
      $found = null;
            foreach ($data[0]['content'] as $key => $value) {
                
              $dateVal = $value['DATETIME'];
              if($date == $dateVal){
                $content .= $value['COUNT'].',';
                $found = 1;
              }

            }
        
        if(empty($found)){
          $content .= '0,';
          
        }
      
    }
  }

     $file = substr($file, 0, -1);
     $image = substr($image, 0, -1);
     $video = substr($video, 0, -1);
     $audio = substr($audio, 0, -1);
     $content = substr($content, 0, -1);
     $setDate = substr($setDate, 0, -1);


     
    $view .= '<div class="dado-counter-container">';
    
           $view .= '<div class="dado-counter-container-1">';
          
                  $view .= '<div class="dado-counter-container-1-inside">

                    <div class="dado-counter-container-1-insideBottom1 contentDokumen">'.model::getDataCount('CAP_LANGUAGE_COMBINE','CAP_LAN_COM_COLUMN = \'content\'').'</div>
                    <div class="dado-counter-container-1-insideBottom2">Konten</div>

                  </div>';
            $view.='</div>';
          
            $view .= '<div class="dado-counter-container-2">';
      
            $view .= '<div class="dado-counter-container-2-inside">
                <div class="dado-counter-container-2-insideBottom1 fileDokumen">'.model::getDataCount('CAP_LANGUAGE_COMBINE','CAP_LAN_COM_COLUMN = \'file\'').'</div>
                <div class="dado-counter-container-1-insideBottom2">File</div>
              </div>';
            $view.='</div>';
        
            $view .= '<div class="dado-counter-container-3">';
      
          $view .= '<div class="dado-counter-container-3-inside">
            <div class="dado-counter-container-3-insideBottom1 gambarDokumen">'.model::getDataCount('CAP_LANGUAGE_COMBINE','CAP_LAN_COM_COLUMN = \'image\'').'</div>
            <div class="dado-counter-container-3-insideBottom2">Gambar</div>
            </div>';
          $view.='</div>';        
            $view .= '<div class="dado-counter-container-4">';
      
          $view .= '<div class="dado-counter-container-4-inside">
          <div class="dado-counter-container-4-insideBottom1 videoDokumen">'.model::getDataCount('CAP_LANGUAGE_COMBINE','CAP_LAN_COM_COLUMN = \'video\'').'</div>
          <div class="dado-counter-container-4-insideBottom2">Video</div>
          </div>';
        
          $view.='</div>';

            $view .= '<div class="dado-counter-container-5">';
      
          $view .= '<div class="dado-counter-container-5-inside">
          <div class="dado-counter-container-5-insideBottom1 audioDokumen">'.model::getDataCount('CAP_LANGUAGE_COMBINE','CAP_LAN_COM_COLUMN = \'audio\'').'</div>
          <div class="dado-counter-container-5-insideBottom2">Audio</div>
          </div>';

          $view.='</div>';           


            $view .= '<div class="dado-counter-container-last">';
      
                    $view .= '<div class="dado-counter-container-last-inside">
                    <div class="dado-counter-container-last-insideBottom1 totalDokumen">'.model::getDataCount('CAP_LANGUAGE_COMBINE','CAP_LAN_COM_COLUMN = \'content\' OR CAP_LAN_COM_COLUMN = \'file\' OR CAP_LAN_COM_COLUMN = \'image\' OR CAP_LAN_COM_COLUMN = \'audio\' OR CAP_LAN_COM_COLUMN = \'video\'').'</div>
                    <div class="dado-counter-container-last-insideBottom2">Total Dokumen</div></div>';
                    $view.='</div>';
             $view .= '</div>';

$view .= '</div>';
      

          $view .= '<div class="dado-core-chart-container">';
      
                          $view .= '<div class="dado-core-chart-header">';
                              
                                          $view .= '<div class="dado-id-float-left">';
                                                      $view .= '<div class="software-dashboard-container-menu-left">';
                                                                  $view .= '<ul id="featured-date">
                                                                            <li class="menuDateList"><span class="days-button core-date-dashboard-button ">Day</a></li>
                                                                            <li class="menuDateList"><span class=" month-button">Month</a></li>
                                                                            <li class="menuDateList"><span class=" year-button">Year</a></li>
                                                                          </ul>'; 
                                                      $view .= '</div>';
                                          $view .= '</div>';
                                          $view .= '<div class="dado-id-float-right">';
                                                          $view .= '<div class="software-dashboard-container-menu-right">';
                                                      
                                                                $view .= ' <input type="text" class="dado-featured-form-input datepicker-from datepicker-content-handler-from" value="'.$dateFrom.'" />
                                                                  TO
                                                                  <input type="text" class="dado-featured-form-input datepicker-to datepicker-content-handler-to" value="'.$dateTo.'" />
                                                                  <input type="hidden" value="days" class="typeOfdate">
                                                                  <input type="submit"  value="Go" class="featured-dado-button" />';
                                                            
                                                                $view .= '  </div>';
                                            
                                                $view .= ' </div>';
                              
                            $view .= '</div>';
                            $view .= "<div class='javascript-container'> ";

     
    $view .= "<script type='text/javascript'> jQuery.noConflict()(function($){var totalDokumen = parseFloat($('.totalDokumen').text());
      var fileDokumen = parseFloat($('.fileDokumen').text());
      var audioDokumen = parseFloat($('.audioDokumen').text());
      var videoDokumen = parseFloat($('.videoDokumen').text());
      var gambarDokumen = parseFloat($('.gambarDokumen').text());
      var contentDokumen = parseFloat($('.contentDokumen').text());
  
      var chart;
      $(document).ready(function() {
        chart = new Highcharts.Chart({
          chart: {
            renderTo: 'dado-chart'
          },
          title: {
            text: 'Statistik Dokumen dari ".$dateFrom." sampai tanggal ".$dateTo." '
          },
          xAxis: {
            categories: [".$setDate."]
          },
          tooltip: {
            formatter: function() {
              var s;
              if (this.point.name) { // the pie chart
                s = ''+
                  this.y +' Dokumen';
              } else {
                s = ''+
                  this.y;
              }
              return s;
            }
          },
          labels: {
            items: [{
              html: 'Statistik Total Dokumen',
              style: {
                left: '40px',
                top: '8px',
                color: 'black'
              }
            }]
          },
          series: [{
            type: 'column',
            name: 'File',
            data: [".$file."]
          }, {
            type: 'column',
            name: 'Gambar',
            data: [".$image."]
          }, {
            type: 'column',
            name: 'Audio',
            data: [".$audio."]
          }, {
            type: 'column',
            name: 'Video',
            data: [".$video."]
          }, {
            type: 'column',
            name: 'Konten Teks',
            data: [".$content ."]
          }, {
            type: 'pie',
            name: 'Statistik Pembagian Dokumen',
            data: [{
              name: 'File',
              y: fileDokumen,
              color: '#4572A7' // Jane's color
            }, {
              name: 'Gambar',
              y: gambarDokumen,
              color: '#AA4643' // John's color
            }, {
              name: 'Audio',
              y: audioDokumen,
              color: '#89A54E' // Joe's color
            }, {
              name: 'Video',
              y: videoDokumen,
              color: '#816A9C' // Joe's color
            }, {
              name: 'Konten Teks',
              y: contentDokumen,
              color: '#3D95AD' // Joe's color
            }],
            center: [100, 80],
            size: 100,
            showInLegend: false,
            dataLabels: {
              enabled: false
            }
          }]
        });
      });
          
      
      
});
      </script>
    ";
    
  $view .= '<div class="dado-core-chart-body" id="dado-chart"></div>';   
  $view .= "</div>";
            $view .= '</div>';
        
        $view .= '<div class="dado-core-desc-left">';
      
                     $view .= '<div class="dado-core-desc-left-header">
                            Daftar IP
                             </div>';
        
        
                          $view .= '<div class="dado-core-desc-left-body">';
                          $data = model::klasifikasi();
                          //print_r($data);
                          $view .= "<table cellpadding='0' cellspacing='0' class='core-listInformasiPublik-table'>";
                                      $view .= "<thead>";
                                                $view .= "<tr class='core-listInformasiPublik-thead-tr'>";
                                                $view .= "  <td colspan='3'>Klasifikasi Informasi Publik</td>";
                                                $view .= "  <td class='align-center'>Keterangan</td>  ";
                                                $view .= "</tr>";
                                      $view .= "</thead>";
                                      $view .= "<tbody>";

                                    //print_r($data[0]['klasifikasi']);
                                    if(!empty($data[0]['klasifikasi'])){
                                      foreach ($data[0]['klasifikasi'] as $key => $value) {
                                      
                                        $view .= $this->recursiveIP($value,0);

                                     }
                                   }
   
                                $view .= "</tbody>";
                              $view .= "<tfoot>";
                              $view .= "<tr>";
                              $view .= "  <td style='width:20px;'></td>";
                              $view .= "  <td style='min-width:15%; max-width:100px;'></td>";
                              $view .= "  <td ></td>";
                              $view .= "  <td style='min-width:25%; '></td>";
                              $view .= "</tr>";
                              $view .= "</tfoot>";
                              $view .= "</table>";

                                 $view .= '</div>';
      
      $view .= '</div>';


      $view .= '<div class="dado-core-desc-right">';

                $view .= '<div class="dado-core-desc-right-header">
                      Sejarah 7 Hari Terakhir
                    </div>';
    
                $view .= '<div class="dado-core-desc-right-body">';
    
                        $view .= self::historyDado();
    
                  $view .= '</div>
      </div>
                            
                            ';
    
      echo $view;
    
  }

  public function setMetadata(){

        $data = model::getSetableMetadata();
             
        $view .= "<input class='admin-metadata-deleter-meta' type='hidden'>";
  
        $view .= "<table class='admin-administrator-content-setmetadata'>";
        
        $view .= "<thead>";
        
   	 				
        $view .= "<tr><td colspan=2><span style='font-weight:bold;'>Set Default Metadata</span></td><td class='admin-administrator-action'><button class='core-setMetadata-actionAdd'><img src='library/capsule/core/images/add.png'></button></td></tr>";
        
        $view .= "<tr><td colspan=3><hr></td></tr>";
        
        
        			$view .= "<tr>";
        				$view .= "<td class='core-".$this->params."-container-tableHeader-action core-align-center'>Aksi</td>";
        				
        				$view .= "<td class='core-".$this->params."-container-tableHeader-action core-align-center'>Header Metadata</td>";
        				
   	 					$view .= "<td class='core-".$this->params."-container-tableHeader core-align-center'>Konten Metadata</td>";

   	 				$view .= "</tr>";
   	 				$view .= "<tr><td colspan=6><hr></td></tr>";
        
        $view .= "</thead>";
        
        $view .= "<tbody>";
          
          if (empty($data)) {
              
              $view .= "<tr>";
              $view .= "<td class='core-".$this->params."-container-tableContent core-align-center'>
                          <span class='core-".$this->params."-actionDelete'></span>
                          <input type='hidden' class='core-setMetadata-inputRealID' name='core-setMetadata-inputRealID' value=''></td>";
              $view .= "<td class='core-".$this->params."-container-tableContent' ><input  type='text' class='core-".$this->params."-input core-inputInherit' value='".$value['CAP_MET_DEF_NAME']."'></td>";
            
              $view .= "<td class='core-".$this->params."-container-tableContent'><input type='text' class='core-".$this->params."-input' value='".$value['CAP_MET_DEF_VALUE']."'></td>";
              $view .= "</tr>";
          
          }
          else {

            
          
            foreach ($data as $key => $value) {
              
              

              $view .= "<tr>";
              $view .= "<td class='core-".$this->params."-container-tableContent core-align-center'>
                          <span class='core-".$this->params."-actionDelete'></span>
                          <input type='hidden' class='core-setMetadata-inputRealID' name='core-setMetadata-inputRealID' value='$value[CAP_MET_DEF_ID]'></td>";
              $view .= "<td class='core-".$this->params."-container-tableContent' ><input  type='text' class='core-".$this->params."-input core-inputInherit' value='".$value['CAP_MET_DEF_NAME']."'></td>";
            
              $view .= "<td class='core-".$this->params."-container-tableContent'><input type='text' class='core-".$this->params."-input' value='".$value['CAP_MET_DEF_VALUE']."'></td>";
              $view .= "</tr>";
              
            }
          
          }
         
            
        $view .= "</tbody>";
        
        $view .= "</table>";
        
        $view .= "<input type='submit' class='admin-".$this->params."-setMetadataSubmit' value='Update'>";
        
        echo $view;

    }
    
  public function library() {
		
		//$pdf = new Zend_Pdf();
		
		//$m = zend('Zend_Pdf');
		
		//print_r($m);

		$tag  = model::getAllDocumentTagging();
		
		$metatype = model::getAllMetadataType();
							
		$view .= $this->optionGear;
		
		$view .= "<div class='layan-libraryFilter-container-header'>Library View</div>";
		
		$view .= "<div class='layan-libraryFilter-container'>";
		
			$view .= "<div class='layan-libraryFilter-1'>";
			
				$view .= "<select data-placeholder='Pilih klasifikasi...' class='layan-libraryFilter-1-select'>";
					
					$view .= "<option selected value=''>Semua Klasifikasi</option>";
					
					$view .= view::getKlasifikasi(null);
					
				$view .= "</select>";
			
			$view .= "</div>";
			
			$view .= "<div class='layan-libraryFilter-2'>";
			
				$view .= "<select data-placeholder='Pilih Subyek...' class='layan-libraryFilter-2-select' multiple>";
				
					foreach ($tag as $key => $value) {
					
						$view .= "<option class='layan-libraryFilter-2-select-option' value='".$value['CAP_TAG_ID']."'>".ucwords(strtolower($value['CAP_TAG_VALUE']))."</option>";
					
					}
				
				$view .= "</select>";
			
			$view .= "</div>";
			
			$view .= "<div class='layan-libraryFilter-5'>";
			
				$view .= "<select data-placeholder='Pilih Metadata...' class='layan-libraryFilter-5-select'>";
					if (!empty($metatype)) {		
						foreach ($metatype as $key => $value) {
							
							if (strtoupper($value) == 'JUDUL DOKUMEN') {
							
							$view .= "<option selected class='layan-libraryFilter-5-select-option' value='".$value."'>".$value."</option>";	
							
							}
							else {
							
							$view .= "<option class='layan-libraryFilter-5-select-option' value='".$value."'>".$value."</option>";
							
							}
						
					}
					}
				
				$view .= "</select>";
			
			$view .= "</div>";
			
			$view .= "<div class='layan-libraryFilter-3'>";
			
				$view .= "<input placeholder='Text...' type='text' class='layan-libraryFilter-2-input'>";
			
			$view .= "</div>";
						
			$view .= "<div class='layan-libraryFilter-4'>";
			
				$view .= "<input type='submit' class='layan-libraryFilter-4-input-core' value='Cari'>";
			
			$view .= "</div>";
		
		$view .= "</div>";
		
		
		$view .= "<div class='layan-libraryFilter-container-header2' style='display:none;'>Order View</div>";
		
		$view .= "<div class='layan-libraryFilter-container2' style='display:none;'>";
		
			$view .= "<div class='layan-libraryFilter-1'>";
			
				$view .= "<li class='layan-library_content-action-horizontal'><a class='layan-library_content-action-printCheckout'>Checkout dan Print</a></li>";
			
			$view .= "</div>";
		
		$view .= "</div>";
		
		$view .= "<div class='layan-library-content-container'>";
		
		$view .= self::library_content();
		
		$view .= "</div>";
		
	echo $view;
		
	}
	
	public function library_content() {
	
		$library = model::klasifikasi_lib();
		//print_r($library);
		if (!empty($library)) {
				
			foreach ($library as $key => $value) {
				
				if (!empty($value['CAP_LAN_COM_ID'])) {
				
				$view .= "<div class='layan-library-li'><img class='layan-library-image' rel='layanLibrary".$value['CAP_LAN_COM_ID']."' src='framework/resize.class.php?src=library/content/thumb/".$value['CAP_LAN_COM_ID'].".png&h=151&w=151&zc=1'></div>";
				
					if (!empty($value['METADATA'])) {
					
					asort($value['METADATA']);
					
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."=\"";
						
						$javascript .= "<table class=\'layan-library_content-table\'>";
						
						foreach ($value['METADATA'] as $key2 => $value2) {

							if (empty($value2['CAP_CON_MET_CONTENT']) || strtoupper($value2['CAP_CON_MET_CONTENT']) == '[BELUM DITENTUKAN]') {
								$content = '[belum ditentukan]';
							}
							else {
								$content = ucwords(strtolower($value2['CAP_CON_MET_CONTENT']));
							}
							
							$javascript .= "<tr><td class=\'layan-library_content-table-vertical\'>".$value2['CAP_CON_MET_HEADER']."</td><td class=\'layan-library_content-table-vertical2\'>:</td><td>".$content."</td></tr>";
							
						}
						
						$javascript .= "<table>";
						
						$javascript .= "\";";
						
						
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."tag=\"";
												
						if (!empty($value['TAGGING'])) {
						
						$i = 1;
						$c = count($value['TAGGING']);
						
							foreach ($value['TAGGING'] as $key2 => $value2) {

								$javascript .= "<li class=\'layan-library_content-li-horizontal\'>".ucwords(strtolower($value2['CAP_TAG_VALUE']));
								
								if ($i < $c) {
									$javascript .= ",</li>";
								}
								else {
									$javascript .= "</li>";
								}
							
							$i++;
								
							}
						
						}
												
						$javascript .= "\";";
						
						
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."link=\"";
						
						$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';
						$hostName = $_SERVER['HTTP_HOST'];
						$hostName = $protocol.$hostName.APP;
						
						if (!empty($value['CAP_LAN_COM_VALUE'])) {
												
						$javascript .= "<input type='text' class=\'layan-library_content-link-horizontal\' value='".$hostName.str_replace(" ","%20",$value['CAP_LAN_COM_VALUE'])."'>";
						
						}
						
						$javascript .= "\";";
						
						
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."action=\"";
																		
						$javascript .= "<li class=\'layan-library_content-action-horizontal\'><a target=\'_blank\' href=\'".$hostName.str_replace(" ","%20",$value['CAP_LAN_COM_VALUE'])."\' class=\'layan-library_content-action-download\' rel=\'".base64_encode($value['CAP_LAN_COM_ID'])."\'>Download</a></li>";
												
						$javascript .= "\";";
												
					}
				
				}
				else {
					
					
					
				}
								
			}
					
		}
		
		if (!empty($javascript)) {
			
			$view .= "<script type='text/javascript'>";
			
			$view .= 'jQuery.noConflict()(function($){$(document).ready(function(){';
						
			$view .= $javascript;
			
			$view .= "
			
			$('.layan-library-image').click(function() {
				
				var layanLibraryScript = $(this).attr('rel');
				
				var layanLibraryScriptTag = $(this).attr('rel')+'tag';
				
				var layanLibraryScriptLink = $(this).attr('rel')+'link';
				
				var layanLibraryScriptAction = $(this).attr('rel')+'action';
				
				layanLibraryScript = eval(layanLibraryScript);
				
				layanLibraryScriptTag = eval(layanLibraryScriptTag);
				
				layanLibraryScriptLink = eval(layanLibraryScriptLink);
				
				layanLibraryScriptAction = eval(layanLibraryScriptAction);
							
				$('#layan-libraryMetadata-metaContainer-content').html(layanLibraryScript);
				
				$('#layan-libraryMetadata-tagContainer-content').html(layanLibraryScriptTag);
				
				$('#layan-libraryMetadata-linkContainer-content').html(layanLibraryScriptLink);
				
				$('#layan-libraryMetadata-actionContainer-content').html(layanLibraryScriptAction);
			
			}); 
			
						
			});
			
			});
			
			";
			
			$view .= "</script>";
			
		}
		
		return $view;
		
	}
	
	public function library_content_ajax() {

		$library = model::klasifikasi_search();

		if (!empty($library)) {
				//print_r($library);
			foreach ($library as $key => $value) {
				
				if (!empty($value['CAP_LAN_COM_ID'])) {
				
				$view .= "<div class='layan-library-li'><img class='layan-library-image' rel='layanLibrary".$value['CAP_LAN_COM_ID']."' src='framework/resize.class.php?src=library/content/thumb/".$value['CAP_LAN_COM_ID'].".png&h=151&w=151&zc=1'></div>";
				
					if (!empty($value['METADATA'])) {

					asort($value['METADATA']);
					
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."=\"";
						
						$javascript .= "<table class=\'layan-library_content-table\'>";
						
						if (!empty($value['METADATA'])) {
						
							foreach ($value['METADATA'] as $key2 => $value2) {
								
								if (empty($value2['CAP_CON_MET_CONTENT']) || strtoupper($value2['CAP_CON_MET_CONTENT']) == '[BELUM DITENTUKAN]') {
									$content = '[belum ditentukan]';
								}
								else {
									$content = ucwords(strtolower($value2['CAP_CON_MET_CONTENT']));
								}
								
								$javascript .= "<tr><td class=\'layan-library_content-table-vertical\'>".$value2['CAP_CON_MET_HEADER']."</td><td class=\'layan-library_content-table-vertical2\'>:</td><td>".$content."</td></tr>";
								
							}
						
						}
						
						$javascript .= "<table>";
						
						$javascript .= "\";";
						
						
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."tag=\"";
						
						if (!empty($value['TAGGING'])) {
						
						$i = 1;
						$c = count($value['TAGGING']);
						
							foreach ($value['TAGGING'] as $key2 => $value2) {

								$javascript .= "<li class=\'layan-library_content-li-horizontal\'>".ucwords(strtolower($value2['CAP_TAG_VALUE']));
								
								if ($i < $c) {
									$javascript .= ",</li>";
								}
								else {
									$javascript .= "</li>";
								}
							
							$i++;
								
							}
						
						}
						
						$javascript .= "\";";
						
						
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."link=\"";
						
						$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';
						$hostName = $_SERVER['HTTP_HOST'];
						$hostName = $protocol.$hostName.APP;
						
						if (!empty($value['CAP_LAN_COM_VALUE'])) {
												
						$javascript .= "<input type='text' class=\'layan-library_content-link-horizontal\' value='".$hostName.str_replace(" ","%20",$value['CAP_LAN_COM_VALUE'])."'>";
						
						}
						
						$javascript .= "\";";
						
						
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."action=\"";
																		
						$javascript .= "<li class=\'layan-library_content-action-horizontal\'><a target=\'_blank\' href=\'".$hostName.str_replace(" ","%20",$value['CAP_LAN_COM_VALUE'])."\' class=\'layan-library_content-action-download\' rel=\'".base64_encode($value['CAP_LAN_COM_ID'])."\'>Download</a></li>";
												
						$javascript .= "\";";
												
					}
				
				}
				else {
					
					
					
				}
								
			}
					
		}
		
		if (!empty($javascript)) {
			
			$view .= "<script type='text/javascript'>";
			
			$view .= 'jQuery.noConflict()(function($){$(document).ready(function(){';
			
			$view .= $javascript;
			
			$view .= "
			
			$('.layan-library-image').click(function() {
				
				var layanLibraryScript = $(this).attr('rel');
				
				var layanLibraryScriptTag = $(this).attr('rel')+'tag';
				
				var layanLibraryScriptLink = $(this).attr('rel')+'link';
				
				var layanLibraryScriptAction = $(this).attr('rel')+'action';
				
				layanLibraryScript = eval(layanLibraryScript);
				
				layanLibraryScriptTag = eval(layanLibraryScriptTag);
				
				layanLibraryScriptLink = eval(layanLibraryScriptLink);
				
				layanLibraryScriptAction = eval(layanLibraryScriptAction);
							
				$('#layan-libraryMetadata-metaContainer-content').html(layanLibraryScript);
				
				$('#layan-libraryMetadata-tagContainer-content').html(layanLibraryScriptTag);
				
				$('#layan-libraryMetadata-linkContainer-content').html(layanLibraryScriptLink);
				
				$('#layan-libraryMetadata-actionContainer-content').html(layanLibraryScriptAction);
			
			});
			
			});
			
			});
			
			";
			
			$view .= "</script>";
			
		}
		
		echo $view;
		
	}
	
	
	
	public function libraryMetadata() {
		
		$view .= $this->optionGear;
		
		$view .= "<div id='layan-libraryMetadata'>";
		
			$view .= "<div id='layan-libraryMetadata-metaContainer'>";
			
				$view .= "<div id='layan-libraryMetadata-metaContainer-header'>Dokumen Metadata</div>";
				
				$view .= "<div id='layan-libraryMetadata-metaContainer-content'></div>";
			
			$view .= "</div>";
			
			$view .= "<div id='layan-libraryMetadata-tagContainer'>";
			
				$view .= "<div id='layan-libraryMetadata-tagContainer-header'>Subyek</div>";
				
				$view .= "<div id='layan-libraryMetadata-tagContainer-content'></div>";
			
			$view .= "</div>";
			
			$view .= "<div id='layan-libraryMetadata-linkContainer'>";
			
				$view .= "<div id='layan-libraryMetadata-linkContainer-header'>Link</div>";
				
				$view .= "<div id='layan-libraryMetadata-linkContainer-content'></div>";
			
			$view .= "</div>";
			
			$view .= "<div id='layan-libraryMetadata-actionContainer'>";
			
				$view .= "<div id='layan-libraryMetadata-actionContainer-header'>Action</div>";
				
				$view .= "<div id='layan-libraryMetadata-actionContainer-content'></div>";
			
			$view .= "</div>";
		
		$view .= "</div>";
		
		echo $view;
		
	}  	
		
public function library_contentUser() {
	
		$library = model::klasifikasi_lib_user();
		//print_r($library);
		if (!empty($library)) {
				
			foreach ($library as $key => $value) {
				
				if (!empty($value['CAP_LAN_COM_ID'])) {
				
				$view .= "<div class='layan-library-li'><img class='layan-library-image' rel='layanLibrary".$value['CAP_LAN_COM_ID']."' src='framework/resize.class.php?src=library/content/thumb/".$value['CAP_LAN_COM_ID'].".png&h=151&w=151&zc=1'></div>";
				
					if (!empty($value['METADATA'])) {
					
					asort($value['METADATA']);
					
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."=\"";
						
						$javascript .= "<table class=\'layan-library_content-table\'>";
						
						foreach ($value['METADATA'] as $key2 => $value2) {
							
							if (empty($value2['CAP_CON_MET_CONTENT']) || strtoupper($value2['CAP_CON_MET_CONTENT']) == '[BELUM DITENTUKAN]') {
								$content = '[belum ditentukan]';
							}
							else {
								$content = ucwords(strtolower($value2['CAP_CON_MET_CONTENT']));
							}
							
							$javascript .= "<tr><td class=\'layan-library_content-table-vertical\'>".$value2['CAP_CON_MET_HEADER']."</td><td class=\'layan-library_content-table-vertical2\'>:</td><td>".$content."</td></tr>";
							
						}
						
						$javascript .= "<table>";
						
						$javascript .= "\";";
						
						
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."tag=\"";
												
						if (!empty($value['TAGGING'])) {
						
						$i = 1;
						$c = count($value['TAGGING']);
						
							foreach ($value['TAGGING'] as $key2 => $value2) {

								$javascript .= "<li class=\'layan-library_content-li-horizontal\'>".ucwords(strtolower($value2['CAP_TAG_VALUE']));
								
								if ($i < $c) {
									$javascript .= ",</li>";
								}
								else {
									$javascript .= "</li>";
								}
							
							$i++;
								
							}
						
						}
												
						$javascript .= "\";";
						
						
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."link=\"";
						
						$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';
						$hostName = $_SERVER['HTTP_HOST'];
						$hostName = $protocol.$hostName.APP;
						
						if (!empty($value['CAP_LAN_COM_VALUE'])) {
												
						$javascript .= "<input type='text' class=\'layan-library_content-link-horizontal\' value='".$hostName.str_replace(" ","%20",$value['CAP_LAN_COM_VALUE'])."'>";
						
						}
						
						$javascript .= "\";";
						
						
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."action=\"";
																		
						$javascript .= "<li class=\'layan-library_content-action-horizontal\'><a target=\'_blank\' href=\'".$hostName.str_replace(" ","%20",$value['CAP_LAN_COM_VALUE'])."\' class=\'layan-library_content-action-download\' rel=\'".base64_encode($value['CAP_LAN_COM_ID'])."\'>Download</a></li>";
												
						$javascript .= "\";";
												
					}
				
				}
				else {
					
					
					
				}
								
			}
					
		}
		
		if (!empty($javascript)) {
			
			$view .= "<script type='text/javascript'>";
			
			$view .= 'jQuery.noConflict()(function($){$(document).ready(function(){';
						
			$view .= $javascript;
			
			$view .= "
			
			$('.layan-library-image').click(function() {
				
				var layanLibraryScript = $(this).attr('rel');
				
				var layanLibraryScriptTag = $(this).attr('rel')+'tag';
				
				var layanLibraryScriptLink = $(this).attr('rel')+'link';
				
				var layanLibraryScriptAction = $(this).attr('rel')+'action';
				
				layanLibraryScript = eval(layanLibraryScript);
				
				layanLibraryScriptTag = eval(layanLibraryScriptTag);
				
				layanLibraryScriptLink = eval(layanLibraryScriptLink);
				
				layanLibraryScriptAction = eval(layanLibraryScriptAction);
							
				$('#layan-libraryMetadata-metaContainer-content').html(layanLibraryScript);
				
				$('#layan-libraryMetadata-tagContainer-content').html(layanLibraryScriptTag);
				
				$('#layan-libraryMetadata-linkContainer-content').html(layanLibraryScriptLink);
				
				$('#layan-libraryMetadata-actionContainer-content').html(layanLibraryScriptAction);
			
			}); 
			
						
			});
			
			});
			
			";
			
			$view .= "</script>";
			
		}
		
		return $view;
		
	}
public function libraryUser() {
		
		//$pdf = new Zend_Pdf();
		
		//$m = zend('Zend_Pdf');
		
		//print_r($m);
		
		$tag  = model::getAllDocumentTagging();
		
		$metatype = model::getAllMetadataType();
							
		$view .= $this->optionGear;
		
		$view .= "<div class='layan-libraryFilter-container-header'>Library View</div>";
		
		$view .= "<div class='layan-libraryFilter-container'>";
		
			$view .= "<div class='layan-libraryFilter-1'>";
			
				$view .= "<select data-placeholder='Pilih klasifikasi...' class='layan-libraryFilter-1-select'>";
					
					$view .= "<option selected value=''>Semua Klasifikasi</option>";
					
					$view .= view::getKlasifikasi(null);
					
				$view .= "</select>";
			
			$view .= "</div>";
			
			$view .= "<div class='layan-libraryFilter-2'>";
			
				$view .= "<select data-placeholder='Pilih Subyek...' class='layan-libraryFilter-2-select' multiple>";
				
					foreach ($tag as $key => $value) {
					
						$view .= "<option class='layan-libraryFilter-2-select-option' value='".$value['CAP_TAG_ID']."'>".ucwords(strtolower($value['CAP_TAG_VALUE']))."</option>";
					
					}
				
				$view .= "</select>";
			
			$view .= "</div>";
			
			$view .= "<div class='layan-libraryFilter-5'>";
			
				$view .= "<select data-placeholder='Pilih Metadata...' class='layan-libraryFilter-5-select'>";
					if (!empty($metatype)) {		
						foreach ($metatype as $key => $value) {
							
							if (strtoupper($value) == 'JUDUL DOKUMEN') {
							
							$view .= "<option selected class='layan-libraryFilter-5-select-option' value='".$value."'>".$value."</option>";	
							
							}
							else {
							
							$view .= "<option class='layan-libraryFilter-5-select-option' value='".$value."'>".$value."</option>";
							
							}
						
					}
					}
				
				$view .= "</select>";
			
			$view .= "</div>";
			
			$view .= "<div class='layan-libraryFilter-3'>";
			
				$view .= "<input placeholder='Text...' type='text' class='layan-libraryFilter-2-input'>";
			
			$view .= "</div>";
						
			$view .= "<div class='layan-libraryFilter-4'>";
			
				$view .= "<input type='submit' class='layan-libraryFilter-4-input-core' value='Cari'>";
			
			$view .= "</div>";
		
		$view .= "</div>";
		
		
		$view .= "<div class='layan-libraryFilter-container-header2' style='display:none;'>Order View</div>";
		
		$view .= "<div class='layan-libraryFilter-container2' style='display:none;'>";
		
			$view .= "<div class='layan-libraryFilter-1'>";
			
				$view .= "<li class='layan-library_content-action-horizontal'><a class='layan-library_content-action-printCheckout'>Checkout dan Print</a></li>";
			
			$view .= "</div>";
		
		$view .= "</div>";
		
		$view .= "<div class='layan-library-content-container'>";
		
		$view .= self::library_contentUser();
		
		$view .= "</div>";
		
	echo $view;
		
	}
public function libraryMetadataUser() {
		
		$view .= $this->optionGear;
		
		$view .= "<div id='layan-libraryMetadata'>";
		
			$view .= "<div id='layan-libraryMetadata-metaContainer'>";
			
				$view .= "<div id='layan-libraryMetadata-metaContainer-header'>Dokumen Metadata</div>";
				
				$view .= "<div id='layan-libraryMetadata-metaContainer-content'></div>";
			
			$view .= "</div>";
			
			$view .= "<div id='layan-libraryMetadata-tagContainer'>";
			
				$view .= "<div id='layan-libraryMetadata-tagContainer-header'>Subyek</div>";
				
				$view .= "<div id='layan-libraryMetadata-tagContainer-content'></div>";
			
			$view .= "</div>";
			
			$view .= "<div id='layan-libraryMetadata-linkContainer'>";
			
				$view .= "<div id='layan-libraryMetadata-linkContainer-header'>Link</div>";
				
				$view .= "<div id='layan-libraryMetadata-linkContainer-content'></div>";
			
			$view .= "</div>";
			
			$view .= "<div id='layan-libraryMetadata-actionContainer'>";
			
				$view .= "<div id='layan-libraryMetadata-actionContainer-header'>Aksi</div>";
				
				$view .= "<div id='layan-libraryMetadata-actionContainer-content'></div>";
			
			$view .= "</div>";
		
		$view .= "</div>";
		
		echo $view;
		
	}

	public function displayListDokumen(){
		$data = model::groupingPublik();
		$view .= $this->optionGear;
                          //print_r($data);
                          $view .= "<table cellpadding='0' cellspacing='0' class='core-listInformasiPublik-publik-table'>";
                                      $view .= "<thead>";
                                                $view .= "<tr class='core-listInformasiPublik-publik-thead-tr'>";
                                                $view .= "  <td colspan='4'>Klasifikasi Informasi Publik</td>";
                                                $view .= "  <td class='align-center'>Penerbit Dokumen</td>  ";
                                                $view .= "</tr>";
                                      $view .= "</thead>";
                                      $view .= "<tbody>";

                                    //print_r($data[0]['grouping']);
                                    if(!empty($data[0]['grouping'])){
                                      foreach ($data[0]['grouping'] as $key => $value) {
                                      	///print_r($value[item]);
                                        $view .= $this->recursiveGroupIP($value,0);

                                     }
                                   }
   
                                $view .= "</tbody>";
                              $view .= "<tfoot>";
                              $view .= "<tr>";
                              $view .= "  <td style='width:20px;'></td>";
                              $view .= "  <td style='min-width:15%; max-width:100px;'></td>";
                              $view .= "  <td ></td>";
                              $view .= "  <td style='min-width:25%; '></td>";
                              $view .= "</tr>";
                              $view .= "</tfoot>";
                              $view .= "</table>";
							  
		echo $view;
	}

	public function recursiveGroupIP($data,$i){
      if(!empty($data)){
        if(empty($i) || $i == 0){
        
          $i = 0;
        
          $padding = $i ;
          $rowChild ="";
          $display ="";
        }else{
        
          $padding = $i * 20;
          $rowChild = "<img src='library/capsule/core/images/rowChild.png' style='padding-left:".$padding."px; margin-right:5px;'>";   
          $display = "style='display:none'";
        }
       
        
          $view .= "<tr class='core-listInformasiPublik-tbody-tr-klas' ".$display.">";
          $view .= "<td class='core-listInformasiPublik-collapse '><span class='core-image-actionPlus core-image-plus'></span>
                    <input type='hidden' name='child' value=''><input type='hidden' name='currentID' value='".$data['parent']['CAP_GRO_ID']."'>
                    <input type='hidden' name='parentID' value='".$data['parent']['CAP_GRO_PARENT']."'></td>";
          $view .= "<td class='core-listInformasiPublik-klas' colspan=\"3\">".$rowChild."<span>".$data['parent']['CAP_GRO_NAME']."</span></td>";
          $view .= "<td class='core-listInformasiPublik-ket align-center'></td>";
          $view .= "</tr>";


           if(isset($data['item'])){
            $n=1;
            foreach ($data['item'] as $key => $value) {
              
              $view .= self::setGroupItem($value,$n);
              $n++;
           }
         }

          if(isset($data['child'])){
             $i++;
            foreach ($data['child'] as $keys => $values) {
                          
              $view .= self::recursiveGroupIP($values,$i);
              
            }


          }

          
       
        }
      
      

      return $view;
  }

  

  public function setGroupItem($value,$i){
    $c=$i%2;
    if($c==0){
      $n='-2';
    }else{
      $n='';
    }

    $view .= "<tr class='core-listInformasiPublik-tbody-tr-file".$n."' style='display:none'>";
      $view .= "<td><input type='hidden' name='parentID' value='".$value[CAP_GRO_ID]."'>";
      $view .= "<input type='hidden' name='itemID' value='".$value[CAP_LAN_COM_ID]."'></td>";
      $view .= "<td class='core-listInformasiPublik-no align-center'>".$i."</td>";
      $view .= "<td class='core-listInformasiPublik-file border-left' colspan=\"2\">".$value[CAP_CON_MET_CONTENT]."</td>";
      $view .= "<td class='core-listInformasiPublik-file border-left' colspan=\"2\">".$value[CAP_PER_PUB_NAME]."</td>";
      /*$view .= "<td class='core-listInformasiPublik-action border-left align-center'><span class='core-image-actionTagging core-image-showTagging'></span><span class='core-image-actionClassification core-image-classificationShow'></span><span class='core-image-actionFolder core-image-folderShow'></span><span class='core-image-actionDownload core-image-download'></span></td>";*/
      $view .= "</tr>";
      
      return $view;

  }
  
  public function commentManagement(){
	  $data = $this->data;
	//print_r($contentList);
    
   
    $view .= "adasdasd";
    	
        
        
    echo $view;
  }
  
  public function profil(){
   
	$data  = $this->getSubMainMenu();
    
    $lag   = $this->language();

    $view .= $this->optionGear;
    
    $view .= "<div class='minerba-".$this->params."-container'>"; 
    
    	$view .= "<div class='minerba-".$this->params."-container-inside'>Profil Divisi</div>"; 
        
        $view .= "<div class='minerba-".$this->params."-container-content'>";
        
        	$view .= "<table class='minerba-".$this->params."-table'>";
        	
        		$view .= "<tr>";
        
   	 				$view .= "<td class='minerba-".$this->params."-container-tableHeader'>Nama / Singkatan Divisi</td>";
   	 		
   	 			$view .= "</tr>";
        	
       	 		$view .= "<tr>";
        		
        		$view .= "<td><select class='minerba-profil-select minerba-filled-field'>";
			
					$view .= "<option selected='selected' value=''>-- Select Pages --</option>";
   	 				
   	 				foreach ($lag as $key => $value) {
				
						if ($_SESSION[language] == $value['CAP_LAN_ID']) {
				
						$view .= "<option selected='selected' value='$value[CAP_LAN_ID]'>$value[CAP_LAN_NAME]</option>";
					
						}
						else {
					
						$view .= "<option value='$value[CAP_LAN_ID]'>$value[CAP_LAN_NAME]</option>";
						
						}
				
					}
   	 				
   	 				$view .= "</select></td>";
        		
   	 				$view .= "<td class='minerba-".$this->params."-container-tableContent'><input type='hidden' class='minerba-".$this->params."-inputID' value='".$data[0]['CAP_MEN_ID']."'><input type='text' class='minerba-".$this->params."-input' value='".$data[0]['CAP_MEN_NAME']."'></td>";
   	 				   	 		
   	 			$view .= "</tr>";
   	 	
   	 		$view .= "</table>";
   	 	
   	 	$view .= "</div>";
    
    $view .= "<div class='minerba-".$this->params."-information'>";
    
    $view .= "
        
        		<dl>
          			<dt>Penggunaan</dt>
            			<dd>Input field diatas akan ditempatkan pada sub menu E-Gov</dd>
            		<dt>Hasil </dt>
            			<dd>Nama / singkatan yang anda masukan pada input field diatas akan dapat dilihat oleh semua pengunjung website Minerba</dd>
           		</dl>";
        
        $view .= "<br />";
    
    $view .= "</div>";
    
    $view .= "<input type='submit' class='minerba-profil-submit-main-submenu' value='Update'>";
    
    $view .= "</div>";
    
    echo $view;
    
	}

}