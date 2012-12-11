<?php

namespace library\capsule\register\mvc;

use \framework\time;

class view extends model {

protected $params;
protected $optionGear;
protected $time;
protected $month;
protected $date;
protected $months;

	public function __construct($params) {
	
	parent::__construct(); $this->params = $params; 
		
		if (isset($_SESSION['admin']) || !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'):
		
		$this -> optionGear = "<span class='forex-optionGear'><img class='optionGear' src='library/capsule/admin/image/settingCap.png'></span>";
		
		endif;

		if ($params == "{view}"): 
	
		$this->params = 'normal'; 
		
		else: 
		
		$this->params = $params; 
		
		endif; 
		
	$params = $this->params; 
		
	$this->$params();
	
	}
	
    public function normal() {
		
    $view .= "<div class='register-".$this->params."-formContainer'>";

    $view .= $this->optionGear;
    
    $view .= "<div class='register-".$this->params."-nameFontTitle'>Trading Account </div>";
    
    $view .= "<div class='register-".$this->params."-formContainer-profile'>";
    
    	$view .= "<table>";

   	 		$view .= "<tbody>";

                $view .= "<tr><td class='register-".$this->params."-nameFont'>Personal Details</td></tr>";

    			$view .= "<tr><td class='headerInput1'>Full Name</td></tr>";
    			
    			$view .= "<tr><td><input class='register-".$this->params."-fullName' type='text' name='fullName'></td><td class='register-normal-info'>?</td></tr>";
    			    			
    			$view .= "<tr><td class='headerInput'>Birthdate</td></tr>";
    			    			
    			$view .= "<tr><td><input class='register-".$this->params."-input' type='text' name='address'></td><td class='register-normal-info'>?</td></tr>";
				
			    $view .= "<tr><td class='headerInput'>Address</td></tr>";
			    
			    $view .= "<tr><td><input class='register-".$this->params."-input' type='text' name='address'></td><td class='register-normal-info'>?</td></tr>";
			    
			    $view .= "<tr><td class='headerInput'>Country</td></tr>";
			    
			    $view .= "<tr>";
			    			    
			    	$view .= "<td><select class='register-normal-moth' name='month'>";
			    	    				
			    		foreach ($this->getCountryList() as $key => $value) {
			    		
			    			$view .= "<option value='$value[CAP_COU_ID]'>".ucwords(strtolower($value[CAP_COU_NAME_EN]))."</option>";
			    		
			    		}
			    	
			    	$view .= "</select></td>";
			    	
			    $view .= "<td class='register-normal-info'>?</td></tr>";
			    
			    $view .= "<tr><td class='headerInput'>City</td></tr>";
			    
			    $view .= "<tr><td ><input class='register-".$this->params."-input' type='text' name='city'><td class='register-normal-info'>?</td></td></tr>";
			    
			    $view .= "<tr><td class='headerInput'>Province</td></tr>";
			    
			    $view .= "<tr><td ><input class='register-".$this->params."-input' type='text' name='province'></td><td class='register-normal-info'>?</td></tr>";
			    
			    $view .= "<tr><td class='headerInput'>Postal Code</td></tr>";
			    
			    $view .= "<tr><td><input class='register-".$this->params."-input' type='text' name='postal'></td><td class='register-normal-info'>?</td></tr>";
			        
    		$view .= "</body>";
    
   	 	$view .= "</table>";
    
    $view .= "</div>";
    
    $view .= "<br />";
    
    $view .= "<div class='register-".$this->params."-formContainer-password'>";
        
        	$view .= "<table>";
    
       	 		$view .= "<tbody>";
       	 		
       	 		    $view .= "<tr><td class='register-".$this->params."-nameFont'>Shega Access</td></tr>";
        			
        			$view .= "<tr><td class='headerInput1'>Email (Shegaforex ID)</td></tr>";
        			
        			$view .= "<tr><td><input class='register-".$this->params."-fullName' type='text' name='fullName'></td><td class='register-normal-info'>?</td></tr>";
        			
    			    $view .= "<tr><td class='headerInput'>Password</td></tr>";
    			    
    			    $view .= "<tr><td><input class='register-".$this->params."-password' type='text' name='password'></td><td class='register-normal-info'>?</td></tr>";
    			    
    			    $view .= "<tr><td class='headerInput'>Re-enter Password</td></tr>";
    			    
    			    $view .= "<tr><td><input class='register-".$this->params."-password' type='text' name='rpassword'></td><td class='register-normal-info'>?</td></tr>";
        
        		$view .= "</body>";
        
       	 	$view .= "</table>";
        
        $view .= "</div>";
        
    $view .= "<br />";
    
    $view .= "<div class='register-".$this->params."-formContainer-account'>";
        
        	$view .= "<table>";
    
       	 		$view .= "<tbody>";
        			    		
        		  $view .= "<tr><td class='register-".$this->params."-nameFont'>Financial Information</td></tr>";	    		
        			    			    
    			    $view .= "<tr><td class='headerInput1'>Leverage</td></tr>";
    			    
    			    $view .= "<tr>";
    			    			    
    			    	$view .= "<td><select class='register-normal-leverage' name='month'>";
    			    	    				
    			    		foreach ($this->getLeverageList() as $key => $value) {
    			    		
    			    			$view .= "<option value='$value[CAP_FOR_LEV_ID]'>".strtoupper($value[CAP_FOR_LEV_NAME])."</option>";
    			    		
    			    		}
    			    	
    			    	$view .= "</select></td>";
    			    	
    			    $view .= "<td class='register-normal-info'>?</td></tr>";
    			    
    			    $view .= "<tr><td class='headerInput'>Account Currency</td></tr>";
    			    
    			    $view .= "<tr>";
    			    			    
    			    	$view .= "<td><select class='register-normal-currency' name='month'>";
    			    	    				
    			    		foreach ($this->getCurrencyList() as $key => $value):
    			    			
    			    			$view .= "<option value='$value[CAP_CUR_ID]'>".strtoupper($value[CAP_CUR_NAME])."</option>";
    			    		
    			    		endforeach;
    			    	
    			    	$view .= "</select></td>";
    			    	
    			    $view .= "<td class='register-normal-info'>?</td></tr>";
        
        		$view .= "</body>";
        
       	 	$view .= "</table>";
        
               
        $view .= "</div>";
        
     $view .= "<div class='register-normal-submit'>Register Now!</div>";
    
    $view .= "</div>";
    
    echo $view;
    
    }
    
    public function accounting_register() {
	   	
	   	if (!empty($_SESSION['CAPSULE_REGISTER'])):
	   	
	   		$this->setParams('data',$_SESSION['CAPSULE_REGISTER'])->processAccReg();
	   			   		
	   	endif;
	   	
	   	/*
	   	// Here we received the result from the registration process 
		// and we are gonna build the error if the session register contain error 
		// is not empty
		*/

	   	if (!empty($_SESSION['accounting_register_error'])):
		   	
		   	$firstname = !empty($_SESSION['accounting_register_error']['firstname']) ? [' error',$_SESSION['accounting_register_error']['firstname']."<br>",] : null;
		   	$lastname  = !empty($_SESSION['accounting_register_error']['lastname'])  ? [' error',$_SESSION['accounting_register_error']['lastname']."<br>"]   : null;
		   	$email	   = !empty($_SESSION['accounting_register_error']['email']) 	 ? [' error',$_SESSION['accounting_register_error']['email']."<br>"] 	  : null;
		   	$password  = !empty($_SESSION['accounting_register_error']['password'])  ? [' error',$_SESSION['accounting_register_error']['password']."<br>"]   : null;
		   	$phone	   = !empty($_SESSION['accounting_register_error']['phone']) 	 ? [' error',$_SESSION['accounting_register_error']['phone']."<br>"] 	  : null;
		   	$country   = !empty($_SESSION['accounting_register_error']['country']) 	 ? [' error',$_SESSION['accounting_register_error']['country']."<br>"] 	  : null;
		   	
		   	$query     = !empty($_SESSION['accounting_register_error']['query-failed']) ? [' error',$_SESSION['accounting_register_error']['query-failed']."<br>"] : null;
		   												
		   	$alerts  = "<div class='register-".$this->params."-error'>";
		   	
		   		$alerts .= "<div class='alert alert-error'>";
		   		
		   			$alerts .= $firstname[1].$lastname[1].$email[1].$password[1].$phone[1].$country[1].$query[1];
		   			
		   		$alerts .= "</div>";
		   		
		   	$alerts .= "</div>";		   	
		   	
	   	endif;
	   	
	   	/*
	   	// We are gonna put the third value in each of the array  
		// so the last user input value will be displayed in the form 
		*/
	   	
	   	if (!empty($_SESSION['accounting_register_value'])):
	   		
	   		$firstname[2] = $_SESSION['accounting_register_value']['firstname'];
	   		$lastname [2] = $_SESSION['accounting_register_value']['lastname'];
	   		$email	  [2] = $_SESSION['accounting_register_value']['email'];
	   		$password [2] = $_SESSION['accounting_register_value']['password'];
	   		$phone	  [2] = $_SESSION['accounting_register_value']['phone'];
	   		$country  [2] = $_SESSION['accounting_register_value']['country'];
	   		
	   	endif;
	   	
	   	/*
	   	// unset the last post form value so the next time user refresh the page 
		// all the last error will be gone for good 
		*/
	   	
	   	unset($_SESSION['CAPSULE_REGISTER']);
	   	
	   	unset($_SESSION['accounting_register_error']);
	   	
	   	/*
	   	// fetch the country list data as an array to populate our country selection field 
		*/
	   	
	    $town  = $this->getCountryList();
	    
	    /*
	   	// finally we build the accounting capsule registration form to be displayed for the user ;) 
		*/
	    
	    $view  = $this->optionGear;
	    	    
	    $view .= "<div class='register-".$this->params."-formContainer'>";
	    
	    $view .= $alerts;
	    
	    $view .= "<form class='form-horizontal form-horizontal-column' action='library/capsule/register/process/process.php' method='post'>";
	    	
	    	$view .= "<input name='CapsuleCSRFToken' type='hidden' value='".$_SESSION['xss']."'>";
	    		    	
	    	$view .= "<div class='control-group$firstname[0]'>";
	    	
		    	$view .= "<label class='control-label' for='inputFirstname'>First Name <span class='cap-register-asterisk'>*</span></label>";
		    	
		    	$view .= "<div class='controls'><input type='text' id='inputFirstname' name='firstname' placeholder='First Name' autocomplete='off' value='$firstname[2]'></div>";
		    		    	
	    	$view .= "</div>";
	    	
	    	$view .= "<div class='control-group$lastname[0]'>";
	    	
		    	$view .= "<label class='control-label' for='inputLastname'>Last Name <span class='cap-register-asterisk'>*</span></label>";
		    	
		    	$view .= "<div class='controls'><input type='text' id='inputLastname' name='lastname' placeholder='Last Name' autocomplete='off' value='$lastname[2]'></div>";
		    		    	
	    	$view .= "</div>";
	    	
	    	$view .= "<div class='control-group$email[0]'>";
	    	
		    	$view .= "<label class='control-label' for='inputEmail'>Email <span class='cap-register-asterisk'>*</span></label>";
		    	
		    	$view .= "<div class='controls'>";
		    	
		    	$view .= "<input type='text' id='inputEmail' name='email' placeholder='Email' autocomplete='off' value='$email[2]'>";
		    	
		    	$view .= "<span class='help-block'>All of your email will be sent to this address</span>";
	    	
		    	$view .= "</div>";
	    	
	    	$view .= "</div>";
	    	
	    	$view .= "<div class='control-group$password[0]'>";
	    	
		    	$view .= "<label class='control-label' for='inputPassword'>Password <span class='cap-register-asterisk'>*</span></label>";
		    	
		    	$view .= "<div class='controls'><input type='password' id='inputPassword' name='password' placeholder='Password' autocomplete='off'></div>";
		    		    	
	    	$view .= "</div>";
	    	
	    	$view .= "<div class='control-group$phone[0]'>";
	    	
		    	$view .= "<label class='control-label' for='inputPhone'>Phone Number <span class='cap-register-asterisk'>*</span></label>";
		    	
		    	$view .= "<div class='controls'><input type='text' id='inputPhone' name='phone' placeholder='Phone Number' autocomplete='off' value='$phone[2]'></div>";
		    		    	
	    	$view .= "</div>";
	    	
	    	$view .= "<div class='control-group$country[0]'>";
	    	
		    	$view .= "<label class='control-label' for='inputCountry'>Country <span class='cap-register-asterisk'>*</span></label>";
		    	
		    	$view .= "<div class='controls'>";
		    	
		    	$view .= "<select name='country' id='inputCountry'>";
		    	
		    		$view .= "<option>-- Select a country --</option>";
		    	
		    		foreach ($town as $key => $value):
		    			
		    			if (!empty($country[2]) && $value['CAP_COU_ID'] == $country[2]):
		    			
		    			$view .= "<option value='".$value['CAP_COU_ID']."' selected='selected'>".ucwords(strtolower($value['CAP_COU_NAME_EN']))."</option>"; 
		    					    			
		    			elseif (strtolower($value['CAP_COU_NAME_EN']) == 'indonesia' && empty($country[2])):
		    			
		    			$view .= "<option value='".$value['CAP_COU_ID']."' selected='selected'>".ucwords(strtolower($value['CAP_COU_NAME_EN']))."</option>";
		    			
		    			else:
		    			
		    			$view .= "<option value='".$value['CAP_COU_ID']."'>".ucwords(strtolower($value['CAP_COU_NAME_EN']))."</option>";
		    			
		    			endif;
		    					    		
		    		endforeach;
		    	
		    	$view .= "</select>";
	    	
		    	$view .= "</div>";
	    	
	    	$view .= "</div>";
	    	
	    	$view .= "<hr>";
	    	
	    	$view .= "<div class='control-group'>";
	    	
		    	$view .= "<div class='controls'>";
		    	
		    	$view .= "<button type='submit' class='btn btn-large btn-success'>Sign up now <i class='icon-forward icon-white'></i></button>";
		    		    	
		    	$view .= "</div>";
	    	
	    	$view .= "</div>";
	    	
	    $view .= "</form>";
	    	    
	    $view .= "</div>";
	    
	    echo $view;
	    
    }

}

?>