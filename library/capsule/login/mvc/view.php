<?php

namespace library\capsule\login\mvc;

use \framework\encryption;
use \framework\server;

class view extends model {

protected $params;

    public function __construct($params) {
    
    parent::__construct("","");
    
    	if (isset($_SESSION['admin']) || !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    	$this->optionGear = "<span class='" . $this->params . "-optionGear'><img class='optionGear' src='library/capsule/admin/image/settingCap.png'></span>";
   	 	}
    
    $this->params = $params; if ($this->params == '{view}') {self::normal();} else {self::$params();}
    
    }
    
    public function normal(){
    
    $view .= $this->optionGear;
    
    $view .= "<div class='".$this->params."-logo'>";
        
    $view .= "</div>";
    
    $view .= "<form class ='form-horizontal-column ' name='form-horizontal' action='".htmlentities($_SERVER['PHP_SELF'])."?id=admin' method='post'>";
    
    $view .= "<div class='control-group'>";
    
    $view .= "<label class='control-label' for='inputUsername'>Email</label>";
    
    $view .= "<div class='controls'>";   
    
    $view .= "<div class='input-prepend'>";    
            
    $view .= "<span class='add-on'><i class='icon-user'></i></span><input class='text' type='text' name='username' placeholder='email' autocomplete='off'>";
    
    $view .= "</div>";
    
    $view .= "</div>";
    
    $view .= "</div>"; 
    
    $view .= "<div class='control-group'>";   
    
    $view .= "<label class='control-label' for='inputPassword'>Password</label>";
    
    $view .= "<div class='controls'>";
    
    $view .= " <div class='input-prepend'>";     
            
    $view .= "<span class='add-on'><i class='icon-lock'></i></span><input class='' id='inputPassword ' type='password' name='password' placeholder='password'>";
    
    $view .= "</div>"; 
    
    $view .= "</div>"; 
      
    $view .= "</div>"; 
    
    $view .= "<div class='control-group'>";   
    
    $view .= "<div class='controls'>"; 
    
    $view .= "<input class='btn btn-info' type='submit' value='Login'>";
       
    $view .= "</div>"; 
        
    $view .= "</div>"; 
    
    $view .= "<div class='control-group'>";   
    
    $view .= "<div class='controls'>"; 
       
    $view .= "</div>"; 
        
    $view .= "</div>"; 
    
           

    $view .= "</form>";
    
  
    
    echo $view;
    
	}
	
	public function staff(){
    
    $view .= $this->optionGear;
    
    $view .= "<div class='".$this->params."-logo'>";
        
    $view .= "</div>";
    
    $view .= "<form class ='form-horizontal-column ' name='form-horizontal' action='".htmlentities($_SERVER['PHP_SELF'])."?id=admin' method='post'>";
    
    $view .= "<div class='control-group'>";
    
    $view .= "<div class='controls'>";   
    
    $view .= "<div class='input-prepend'>";    
            
    $view .= "<span class='add-on'><i class='icon-user'></i></span><input class='text' type='text' name='username' placeholder='email' autocomplete='off'>";
    
    $view .= "</div>";
    
    $view .= "</div>";
    
    $view .= "</div>";
    
    $view .= "<p></p>";  
    
    $view .= "<div class='control-group'>";   
    
    $view .= "<div class='controls'>";
    
    $view .= " <div class='input-prepend'>";     
            
    $view .= "<span class='add-on'><i class='icon-lock'></i></span><input class='' id='inputPassword ' type='password' name='password' placeholder='password'>";
    
    $view .= "</div>"; 
    
    $view .= "</div>"; 
      
    $view .= "</div>"; 
    
    $view .= "<p></p>"; 
    
    $view .= "<div class='control-group'>";   
    
    $view .= "<div class='controls'>"; 
    
    $view .= "<input class='tinyButton roundButtonX right greenButton' type='submit' value='Login'>";
       
    $view .= "</div>"; 
        
    $view .= "</div>"; 
    
    $view .= "<div class='control-group'>";   
    
    $view .= "<div class='controls'>"; 
       
    $view .= "</div>"; 
        
    $view .= "</div>"; 
    
           

    $view .= "</form>";
    
  
    
    echo $view;
    
	}
	
	public function staffSite(){
	
	$view  = $this->optionGear;
	
	$view .= "<div class='account-container login stacked'>";
	
	$view .= "<div class='content clearfix'>";
		
	$view .= "<form action='".htmlentities($_SERVER['PHP_SELF'])."?id=admin' method='post'>";
		
	$view .= "<h1>Masuk</h1>";		
			
	$view .= "<div class='login-fields'>";
				
	$view .= "<p>Masuk dengan akun terdaftar Anda:</p>";
				
	$view .= "<div class='field'>";
					
	$view .= 	"<label for='username'>Username:</label>";
					
	$view .= 				"<input type='text' id='username' name='username' value='' placeholder='Username' class='login username-field'></div> 
				<div class='field'>
					<label for='password'>Password:</label>
					<input type='password' id='password' name='password' value='' placeholder='Password' class='login password-field'>
				</div> 
				
	 	</div> 
			
			<div class='login-actions'>
				
							
				<button class='button btn btn-primary btn-large'>Masuk</button>
				
			</div> 
			
			
			
		</form>
		
	</div> 
	
</div> 


<div class='login-extra'>
	</div> 

";
    echo $view;
		
	}
	
	public function pertanian(){
	
	$view  = $this->optionGear;
	
    $view .= '<div id="slide_widget_inner">
			<div class="widget campaign_email_capture_wrap">
				<h3 class="widgettitle">Sistem IP Online</h3>
				<span>Masukan username dan password anda untuk mengakses Sistem Informasi Publik Kementerian Pertanian.</span>
				<div id="campaign_email_capture">
					<form name="adminForm" action="'.htmlentities($_SERVER["PHP_SELF"]).'?id=admin" method="post" autocomplete="off">
						<div>
							<input type="text" class="campaign-email-capture-name campaign-email-capture-name-active" name="username" title="Username" />
							<input type="password" class="campaign-email-capture-email campaign-email-capture-email-active" name="password" title="Password" />
							<input type="hidden" name="system_last_url" value="'.htmlentities($_SERVER['QUERY_STRING']).'" />
							<input type="submit" class="campaign-email-capture-submit" value="Login">
						</div>
					</form>
				</div>
			</div>
		</div>';
    
    echo $view;
    
	}

	
	    
}

?>
