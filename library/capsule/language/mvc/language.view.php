<?php

namespace library\capsule\language;

class view {

public $data;

	public function __construct($data) {
	$this->data = $data;
	}

    public function normal() {

    $language  = "<select id='languageSelectMain'>";
    
    	foreach ($this->data as $value) {
    		if ($_SESSION['language'] == $value[CAP_LAN_ID]) {
    		$language .= "<option selected='selected' value='" . $value[CAP_LAN_ID] . "'>" . $value[CAP_LAN_NAME] . "</option>";
    		}
    		else {
    		$language .= "<option value='" . $value[CAP_LAN_ID] . "'>" . $value[CAP_LAN_NAME] . "</option>";
    		}
    	
    	}
    	
    $language .= "</select>";
    
    
    echo $language;
    
    }

}

?>