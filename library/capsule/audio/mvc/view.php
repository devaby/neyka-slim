<?php

namespace library\capsule\audio\mvc;

class view extends model {

protected $data;
protected $category;
protected $text;
protected $optionGear;
protected $params;
protected $optionSearch;
protected $row;
    
    public function __construct($text,$params,$rowDisplay,$category,$folder) {
    
    parent::__construct(); 
		
    if ($folder == '{folder}') {$data = $this->fetchData();} else {$data = $this->fetchAudioFromFolder($folder);}
    
    $this -> category = $this->fetchDataForOptionCategory();
    $this -> text     = $text;
    $this -> data     = $data; 
    $this -> params   = $params; 
    $this -> row 	  = $rowDisplay;
    
    if (isset($_SESSION['admin']) || !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $this -> optionGear = "<span class='" . $this->params . "-optionGear'><img class='optionGear' src='library/capsule/admin/image/settingCap.png'></span>";
    }
    
    $this -> $params();
    
    }
    
    public function normal() {  
    
    $view  = "<div class='" . $this->params . "'>";
    
    $myText = explode(" ", $this -> text);
    	
    	foreach ($myText as $value) {
    	$i++;
    		if ($i == 1) {
    		$view .= "<span class='" . $this->params . "-HeadingLeft'>" . $value . "</span> "; 
    		}
    		else {
    		$view .= "<span class='" . $this->params . "-HeadingRight'>" . $value . "</span>";
    		}
    	
    	}
    	
    	if (empty($this -> text)) {
    	$view .= "<span class='" . $this->params . "-HeadingLeft'>{text}</span> "; 
    	}
    
    $view .= $this -> optionGear;
    $view .= "<hr />";
    $view .= "<table>";

    	foreach ($this->data as $key => $value) {
    		
    		if (strlen($value[content]) >= 100) {
    		$contentLength = substr(preg_replace('/<[^>]*>/', '', $value[content]), 0, 100);
    		$contentLength = substr($contentLength, 0, strrpos($contentLength, ' ')).'...';
    		}
    		else {
    		$contentLength = preg_replace('/<[^>]*>/', '', $value[content]);
    		}
    	
    	$view .= "<tr><td class='" . $this->params . "-NewsHeader'><a href='index.php?id=" . $value[id] . "c'>$value[header]</a></td></tr>";
    	$view .= "<tr><td class='" . $this->params . "-NewsContent'>$contentLength</td></tr>";
    	$view .= "<tr><td></td></tr>";
    	
    	}
   	
   	$view .= "</table>";
    $view .= " </div>";
    
    echo $view;
    
    }
    public function horizontal() {  
    
    $view  = "<div class='" . $this->params . "'>";
    
    $myText = explode(" ", $this -> text);
    	
    	foreach ($myText as $value) {
    	$i++;
    		if ($i == 1) {
    		$view .= "<span class='" . $this->params . "-HeadingLeft'>" . $value . "</span> "; 
    		}
    		else {
    		$view .= "<span class='" . $this->params . "-HeadingRight'>" . $value . "</span>";
    		}
    	
    	}
    	
    	if (empty($this -> text)) {
    	$view .= "<span class='" . $this->params . "-HeadingLeft'>{text}</span> "; 
    	}
    
    $view .= $this -> optionGear;
    $view .= "<hr />";
    $view .= "<table>";
	
	$i = 0;
	$z = 1;
	$c = count($this->data);
	
	for ($i; $i < $this->row; $i++) {
	
	if ($c - $y <= 3) {break;}
	
	$view .= "<tr>";
	
		for ($y = $z; $y < $c; $y++) {
        $view .= "<td class='" . $this->params . "-NewsHeader'><audio class='" . $this->params . "-daImage'src='".$this->data[$y]." controls='controls'></audio></td>";

    	if ($y != 0 && $y % 3 == 0) {$z = $y+1; break;}
    	
    	}
    	
    $view .= "<tr>";
    	
    }
   	
   	$view .= "</table>";
        $view .= "<hr />";
        $view .= " </div>";
    
    echo $view;
    
    }
    
    
    public function table() {  
        
    $view  = "<div class='" . $this->params . "'>";
    
    $myText = explode(" ", $this->text);
    	
    	foreach ($myText as $value) {
    	$i++;
    		if ($i == 1) {
    		$view .= "<span class='" . $this->params . "-HeadingLeft'>" . $value . "</span> "; 
    		}
    		else {
    		$view .= "<span class='" . $this->params . "-HeadingRight'>" . $value . "</span>";
    		}
    	
    	}
    	
    	if (empty($this -> text)) {
    	$view .= "<span class='" . $this->params . "-HeadingLeft'>{text}</span> ";
    	}
    
    $view .= $this->optionGear; $view .= "<hr class='separator-line'/>"; $view .= "<table>";
    
    $i = 0;
    $z = 1;
    $c = count($this->data);
    
    	for ($i; $i <= $this->row; $i++) {
    	
    	$filename = ucwords(strtolower(pathinfo($this->data[$i], PATHINFO_FILENAME)));
    	$filesize = filesize($this->data[$i]); $filesize = number_format($filesize/1000) . " Kb";
    	    	
    	$view .= "
    	
    	<tr>
    		<td>
    			<object type='application/x-shockwave-flash' data='library/plugins/dewplayer/dewplayer-playlist.swf' width='100%' height='20' id='dewplayer' name='dewplayer'>
    			<param name='flashvars' value='mp3=".$this->data[$i]."' />
    			<param name='wmode' value='transparent' />
    			</object>
    		</td>";
        
        $view .= "<tr><td colspan=2><hr/></td></tr>";
        
        $y++; if ($y == $c) {break;}
        
    	}
    	
    $view .= "</table>";
    $view .= " </div>";
    
    echo $view;
    
    }
    
    
    
}















?>
