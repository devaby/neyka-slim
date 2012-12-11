<?php

namespace library\capsule\contact\mvc;

class view extends model {

protected $text;
protected $email;
protected $params;
protected $optionGear;

	public function __construct($text,$email,$params) {
	parent::__construct(); $this->params = $params; 
	
	if (isset($_SESSION['admin']) || !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	$this -> optionGear = "<span class='contact-optionGear'><img class='optionGear' src='library/capsule/admin/image/settingCap.png'></span>";
	}
	
		if (preg_match("/[|]/", $text)) {

    	$text = explode("|", $text);

    		if ($_SESSION['language'] == 'id') {
    		$text = $text[0];
    		}
    		else {
    		$text = $text[1];
    		}
    	
    	}
	
	$this->text = $text;
	
	
	if ($params == "{view}") {$this->params = 'normal';} 
	else {$this->params = $params;} $params = $this->params; $this->$params();
	}

    public function normal() {
            
    $view .= "<div class='contact-normal-textheader'>";
    
    $view .= "<span class='contact-" . $this->params . "-heading'>" . $this->text . "</span>";
    	
    	if (empty($this->text)) {
    	$view .= "<span class='" . $this->params . "-HeadingLeft'>{text}</span> "; 
    	}
    
    $view .= $this->optionGear;
    
   $view .= "</div>";
    
    
    $view  .= "<div class='contact-normal-container'>";
    $view .= "<form>";
    
   		$view .= "<table class='contact-normal-table'>";
    		
    		$view .= "<tr>"; $view .= "<td>Name</td>"; $view .= "</tr>"; $view .= "<tr><td><input class='contact-normal-input' type='text' name='name' maxlength='50'></td></tr>";
    		
    		$view .= "<tr>"; $view .= "<td>Email</td>"; $view .= "</tr>"; $view .= "<tr><td><input class='contact-normal-input' type='text' name='email'></td></tr>";
    		
    		$view .= "<tr>"; $view .= "<td>Telephone</td>"; $view .= "</tr>"; $view .= "<tr><td><input class='contact-normal-input' type='text' name='telephone' maxlength='12'></td></tr>";
    		
   			$view .= "<tr>"; $view .= "<td>Message</td>"; $view .= "</tr>"; $view .= "<tr><td><textarea class='contact-normal-textarea'></textarea></td></tr>";		
   
    	$view .= "</table>";
   
    $view .= "<input class='contact-normal-send' type='submit' value='Send'>";
    
    $view .= "</form>";
    
   $view .= "</div>";
    
    echo $view;
    }
    public function quickBlackContact() {
             
     /*$view .= "<div class='contact-normal-textheader'>";
     
     $view .= "<span class='contact-" . $this->params . "-heading'>" . $this->text . "</span>";
     	
     	if (empty($this->text)) {
     	$view .= "<span class='" . $this->params . "-HeadingLeft'>{text}</span> "; 
     	}
     */
     $view .= $this->optionGear;
     
     //$view .= "</div>";
     
     
     //$view  .= "<div class='contact-normal-container'>";
     $view .= "<h5>Quick Contact</h5>";
     $view .= "<form id=\"quickcontact\" class=\"contact-normal-table\">";
     
    		//$view .= "<table class='contact-normal-table'>";
     		$view .= "<input type=\"text\" name=\"name\" id=\"quickcontact_name\" class=\"requiredfield contact-normal-input\" onFocus=\"if(this.value == 'Name *') { this.value = ''; }\" onBlur=\"if(this.value == '') { this.value = 'Name *'; }\" value='Name *'/>";
     		//$view .= "<tr>"; $view .= "<td>Name</td>"; $view .= "</tr>"; $view .= "<tr><td><input class='contact-normal-input' type='text' name='name' maxlength='50'></td></tr>";
     		$view .= "<input type=\"text\" name=\"email\" id=\"quickcontact_email\" class=\"requiredfield contact-normal-input\" onFocus=\"if(this.value == 'Email *') { this.value = ''; }\" onBlur=\"if(this.value == '') { this.value = 'Email *'; }\" value='Email *'/>";
     		//$view .= "<tr>"; $view .= "<td>Email</td>"; $view .= "</tr>"; $view .= "<tr><td><input class='contact-normal-input' type='text' name='email'></td></tr>";
     		$view .= "<input type='hidden' name='telephone' value=''>";
     		$view .= "<textarea name=\"message\" id=\"quickcontact_message\" class=\"requiredfield contact-normal-input\" onFocus=\"if(this.value == 'Message *') { this.value = ''; }\" onBlur=\"if(this.value == '') { this.value = 'Message *'; }\">Message *</textarea>";
     		//$view .= "<tr>"; $view .= "<td>Telephone</td>"; $view .= "</tr>"; $view .= "<tr><td><input class='contact-normal-input' type='text' name='telephone' maxlength='12'></td></tr>";
     		
    			//$view .= "<tr>"; $view .= "<td>Message</td>"; $view .= "</tr>"; $view .= "<tr><td><textarea class='contact-normal-textarea'></textarea></td></tr>";		
    
     	//$view .= "</table>";
     $view .= '<button class=\'contact-normal-send\' type="submit" name="send">Send</button>
     <span class="errormessage">Error! Please correct marked fields.</span>
     <span class="successmessage">Message send successfully!</span>
     <span class="sendingmessage">Sending...</span> ';
     //$view .= "<input class='contact-normal-send' type='submit' value='Send'>";
     
     $view .= "</form>";
     
     //$view .= "</div>";
     
     echo $view;
     }
    

}

?>