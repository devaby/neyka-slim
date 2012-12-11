<?php

namespace library\capsule\content\mvc;

use \framework\simple_html_dom;
use \framework\image;
use \framework\resize;

class view extends model {

protected $data;
protected $category;
protected $userCategory;
protected $text;
protected $row;
protected $url;
protected $optionGear;
protected $params;
protected $optionSearch;

    public function __construct($text,$params,$rowDisplay,$category) {
        
    parent::__construct();
    
    if (empty($this->url)): $this->url = $GLOBALS['_neyClass']['router']; endif;
	
	$newCat = explode(",",$category);
	
    if ($rowDisplay == '{row display}') {$data = $this->fetchData();}else {$data = $this->fetchDataWithRowNumber($rowDisplay,$newCat[0]);}
    
    	if (preg_match("/[|]/", $text)) {

    	$text = explode("|", $text);

    		if ($_SESSION['language'] == 'id') {
    		$text = $text[0];
    		}
    		else {
    		$text = $text[1];
    		}
    	
    	}
    
    $this -> userCategory	= $newCat;
    $this -> category 		= $this->fetchDataForOptionCategory();
    $this -> text     		= $text;
    $this -> data     		= $data; 
    $this -> params   		= $params;
    $this -> row	  		= $rowDisplay;
    
    if (isset($_SESSION['admin']) || !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $this -> optionGear = "<span class='" . $this->params . "-optionGear'><img class='optionGear' src='/cornc/library/capsule/admin/image/settingCap.png'></span>";
    }
    
    $this -> $params();
    
    }
    function Custom() {
    	$view .= "<div class='" . $this->params . "'>" ;
    	$myText = explode(" ", $this -> text);
    		
    		
    		if (empty($this -> text)) {
    		$view .= "<span class='" . $this->params . "-HeadingLeft'>{text}</span> "; 
    		}
    		$view .= $this -> optionGear;
    		$view .= "<hr class='separator-line'/>";
    		if(!empty($this->data)){
    			foreach($this->data as $key => $value){
    				if(!empty($value[content])){
    					
    					$view .=$value[content];
    				}
    			}
    		}
    		
    		
    				$view .= " </div>";		
    		
    		
    	echo $view;
    	
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
    	$view .= "<span class='" . $this->params . "-HeadingLeft'>{Text}</span> "; 
    	}

    
    $view .= $this -> optionGear;
    
    $view .= "<table>";
	
	if (!empty($this->data)) {
	
    	foreach ($this->data as $key => $value) {
    		
    		if (!empty($value[content])) {
    		    		
    			if (strlen($value[content]) >= 100) {
    			$contentLength = substr(preg_replace('/<[^>]*>/', '', $value[content]), 0, 600);
    			$contentLength = substr($contentLength, 0, strrpos($contentLength, ' ')).'...';
    			}
    			else {
    			$contentLength = preg_replace('/<[^>]*>/', '', $value[content]);
    			}
    	
    		$view .= "<tr><td class='" . $this->params . "-NewsHeader'><a href='" . $this->url->builder($value['id'].'c',str_replace(" ","-",$value['header']))."/'>$value[header]</a></td></tr>";
    		$view .= "<tr><td class='" . $this->params . "-NewsContent'>$contentLength</td></tr>";
    		$view .= "<tr><td colspan=2><hr class='separator-line'/></td></tr>";
    	
    		}
    	
    	}
    	
    }
   	
   	$view .= "</table>";
    $view .= " </div>";
    
    echo $view;
    
    }
    
    
    
	public function single() {  

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
    $view .= "<hr class='separator-line-thick'/>";
    
    if (!empty($this->data)) {
    
    	foreach ($this->data as $key => $value) {
    		
    		if (!empty($value[content])) {
    		
    		$view .= $value[content];
    	
    		}
    		
    	break;
    	
    	}
    	
    }
   	
    $view .= " </div>";
    
    echo $view;
    
    }
    
    public function singleText() {  
    
    /*
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
        
       
    */
        $view .= $this -> optionGear;
     
        
        if (!empty($this->data)) {
        
        	foreach ($this->data as $key => $value) {
        		
        		if (!empty($value[content])) {
        		
        		$view .= $value[content];
        	
        		}
        		
        	break;
        	
        	}
       	
        }
        
        echo $view;
        
        }
        
    
    public function lists() {  
    
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
    $view .= "<hr class='separator-line'/>";
    $view .= "<table>";
    
    	if (!empty($this->data)) {
    
	    	foreach ($this->data as $key => $value) {
	    		
	    		if (!empty($value[content])) {
	    		
	    			if (strlen($value[content]) >= 20) {
	    			$contentLength = substr(preg_replace('/<[^>]*>/', '', $value[content]), 0, 70);
	    			$contentLength = substr($contentLength, 0, strrpos($contentLength, ' '));
	    			}
	    			else {
	    			$contentLength = preg_replace('/<[^>]*>/', '', $value[content]);
	    			}
	    	
	    		$view .= "<tr><td class='" . $this->params . "-NewsHeader'><a href='" . $this->url->builder($value['id'].'c',str_replace(" ","-",$value['header']))."/'>$value[header]</a></td></tr>";
	    		$view .= "<tr><td><hr class='separator-line'/></td></tr>";
	    	
	    		}
	    	
	    	}
    	
    	}
    	    	
    $view .= "</table>";
    $view .= " </div>";
    
    echo $view;
    
    }
    
    
    public function event() {  
    
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
    $view .= "<hr class='separator-line-event'/>";
    $view .= "<table>";
		
    	foreach ($this->data as $key => $value) {
    		
    		if (!empty($value[content])) {
    		
    			if (strlen($value[content]) >= 20) {
    			$contentLength = substr(preg_replace('/<[^>]*>/', '', $value[content]), 0, 70);
    			$contentLength = substr($contentLength, 0, strrpos($contentLength, ' '));
    			}
    			else {
    			$contentLength = preg_replace('/<[^>]*>/', '', $value[content]);
    			}
    	
    		$view .= "<tr><td><img class='" . $this->params . "-contentImage' src='library/capsule/content/image/cal.png'></td><td class='" . $this->params . "-NewsHeader'><a href='" . $this->url->builder($value['id'].'c',str_replace(" ","-",$value['header']))."/'>$value[header]</a></td></tr>";
    		$view .= "<tr><td colspan=2><hr class='separator-line-event'/></td></tr>";
    	
    		}
    	
    	}
    	   	
   	$view .= "</table>";
    $view .= " </div>";
    
    echo $view;
    
    }

 public function image () {  
    
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
    $view .= "<hr class='separator-line'/>";
    
    $view .= "<table class='" . $this->params . "-left'>";
	$view .= "<tr>";

    	foreach ($this->data as $key => $value) {
    	    	
    	$html = new simple_html_dom();
    	
    	$html->load($value[content]);
    		
    		if ($html->find('img')) {
    		
    			foreach($html->find('img') as $element) {
    		    $view .= "<td class='" . $this->params . "-boxImage'>
    		    <img src='framework/resize.class.php?src=" . $element->src . "&h=70&w=80&zc=1' alt=''/></td>";
    		    break; 			
    		    }
    		
    		}
    		else {
    		$view .= "<td class='" . $this->params . "-boxImage'><div class='" . $this->params . "-noImage'></div></td>";
    		}
    		
    					    		               
        $contentLength = substr(preg_replace('/<[^>]*>/', '', $value[content]), 0, 100);
    	$contentLength = substr($contentLength, 0, strrpos($contentLength, ' ')).'...';
    	
    		//if ($html->find('img')) {
    		
        	$view .= "<td>";
        	$view .= "<table class='" . $this->params . "-right'>";
        	$view .= "<tr><td class='" . $this->params . "-NewsHeader'><a href='" . $value['id'] . "c-".str_replace(" ","-",$value['header']).".html'>".substr(preg_replace('/<[^>]*>/', '', $value[header]), 0, 24)."</a></td></tr>";
        	$view .= "<tr><td class='" . $this->params . "-NewsContent'>$contentLength</td></tr>";
        	$view .= "</table>";
        	$view .= "</td>";
        	$view .= "<td>";
        	$view .= "<tr><td colspan=2><hr/></td></tr>";
    		$view .= "</tr>";
    		//}
        
        }
   	
   	$view .= "</table>";
    $view .= " </div>";
    
    echo $view;
    
 }

 
  public function imageBox() {  
    
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
        $view .= "<div class='" . $this->params . "-optionSearch'></div>";
        
        $view .= "<select class='" . $this->params . "-RightFloat'>";
        
        	foreach ($this->category as $cat) {
        	
        	$view .= "<option value='$cat[id]'>$cat[name]</option>";
        	
        	}
        
    $view .= "</select>";

    $view .= "<hr class='separator-line'/>";
    
    $i = 0;
    
    	foreach ($this->data as $key => $value) {
    	
    	$i++;
    	
    	$view .= "<div numbering='$i' class='" . $this->params . "-boxImageContent'>";
    	
    	$html = new simple_html_dom();
    	
    	$html->load($value[content]);
    		
    		if (strlen($value[content]) >= 20) {
    		
				foreach($html->find('img') as $element) {
       			$view .= "<div class='" . $this->params . "-imageUnder'><img src='framework/resize.class.php?src=" . $element->src . "&h=200&w=423&zc=1' alt=''/></div>";
       				if (!empty($element->src)) {break;}
       			}

    		}
    		else {
    		
    			foreach($html->find('img') as $element) {
       			$view .= "<div class='" . $this->params . "-imageUnder'><img src='framework/resize.class.php?src=" . $element->src . "&h=200&w=423&zc=1' alt=''/></div>";
       				if (!empty($element->src)) {break;}
       			}
    		
    		}
    		
       	$valueID = $value[id];
       	$valueHeader = $value[header];
       	
       	$contentLength = substr(preg_replace('/<[^>]*>/', '', $value[content]), 0, 60);
    	$contentLength = substr($contentLength, 0, strrpos($contentLength, ' ')).'...';
        
        $view .= "<div class='" . $this->params . "-NewsHeader'><a href='" . $value['id'] . "c-".str_replace(" ","-",$value['header']).".html'>$valueHeader</a></div>";
   		//$view .= "<div class='" . $this->params . "-NewsHeaderContent'><a href='?id=" . $valueID . "c'>$contentLength</a></div></div>";
        $view .= "</div>";
        
        $li   .= "<li class='" . $this->params . "-counterLi' value='$i'>$i</li>";
        
        }
   	
   		
    $view .= "<ul class='" . $this->params . "-counterUl'>" . $li . "</ul>" . "</div>";
    
    echo $view;
    
    }

 
 public function contentTag() {  
  
    $view .= "</br>";
    $view  .= "<div class='" . $this->params . "'>";
    
    $myText = explode(" ", $this -> text);
    	
    	foreach ($myText as $value) {
    	$i++;
    		if ($i == 1) {
    		$view .= "<span class='" . $this->params . "-HeadingLeft'>" . $value . "</span> "; 
    		}
    		else {
    		$view .= " <span class='" . $this->params . "-HeadingRight'>" . $value . "</span>";
    		}
    	
    	}
    	
    	if (empty($this -> text)) {
    	$view .= "<span class='" . $this->params . "-HeadingLeft'>{text}</span> "; 
    	}
    	
  	$view .= $this -> optionGear;
    
    $view .= "<table>";

    	foreach ($this->data as $key => $value) {
    		
    		if (strlen($value[content]) >= 20) {
    		$contentLength = substr(preg_replace('/<[^>]*>/', '', $value[content]), 0, 70);
    		$contentLength = substr($contentLength, 0, strrpos($contentLength, ' '));
    		}
    		else {
    		$contentLength = preg_replace('/<[^>]*>/', '', $value[content]);
    		}
    	    	
    	$view .= "<tr><td><td class='" . $this->params . "-NewsHeader'> - <a href='" . $this->url->builder($value['id'].'c',str_replace(" ","-",$value['header']))."/'>$value[header]</a></td></tr>";
    	$view .= "<tr><td></td></tr>";
    	
    	}
   	
   	$view .= "</table>";
    $view .= " </div>";
    
    echo $view;
    
    }
 
  public function verticon() {  
    
    $view  = "<div class='" . $this->params . "'>";
    
    /*
    
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
   */
    	
    	if (empty($this -> text)) {
    	$view .= "<span class='" . $this->params . "-HeadingLeft'></span> "; 
    	}
        
  		$view .= $this -> optionGear;
  		
        $view .= "<div class='" . $this->params . "-optionSearch'></div>";
        
            
    	
    	$view .= "<div class='" . $this->params . "-contentPlaceholder'>";
    	
    	$i = 0;
    	
    	if (!empty($this->data)) {
    	
	    	foreach ($this->data as $key => $value) {
	    	
	    	if ($i == 5) {break;}
	    	
	    	$i++;
	
	    	$view .= "<div numbering='$i' class='" . $this->params . "-boxImageContent'>";
	    	
	    	$html  = new simple_html_dom();
	    	
	    	$html -> load($value[content]);
	    	
	    	$img   = $html->find('img', 0);
	    	
	    		if (empty($img->src)) {
	    		$view .= "<div class='" . $this->params . "-noImage'></div>";
	    		}
	    		else {
	    		$view .= "<div class='" . $this->params . "-imageUnder'><img src='framework/resize.class.php?src=" .$img->src . "&h=45&w=260&zc=1' alt=''/></div>";
	    		}
	
	       	$valueID = $value[id];
	       	
	       	if (strlen($value[header]) >= 55) {
	       	$contentLength = substr(preg_replace('/<[^>]*>/', '', $value[header]), 0, 55);
	    	$contentLength = substr($contentLength, 0, strrpos($contentLength, ' ')).'..';
	    	}
	    	else {
	    	$contentLength = preg_replace('/<[^>]*>/', '', $value[header]);
	    	}
	        
	        $view .= "<div class='" . $this->params . "-NewsHeader'><a href='" . $this->url->builder($value['id'].'c',str_replace(" ","-",$value['header']))."/'>$contentLength</a></div>";
	        
	        $view .= "</div>";
	        
	        $li   .= "<li class='" . $this->params . "-counterLi' value='$i'>$i</li>";
	        
	        }
        
        }
   	
   		
   	$view .= "<ul class='" . $this->params . "-counterUl'>" . $li . "</ul>";
     
   	$view .= "<table class='" . $this->params . "-left'>";
	
	$view .= "<tr>";
		
	$y = 0;
		
		if (!empty($this->data)) {
		
	    	foreach ($this->data as $key => $value) {
	    	
	    	$y++;
	    	
	    	if ($y <= 5) {continue;}
	    	
	    	$i = 0;
	    	
	    		$html  = new simple_html_dom();
	    	
	    		$html -> load($value[content]);
	    		
	    		$img   = $html->find('img', 0);
	    		
	    		if (strlen($value[content]) >= 100) {
	    		
					if (empty($img->src)) {
					$view .= "<td class='" . $this->params . "-boxEmptyImage'><div class='" . $this->params . "-boxNoImage'></div></td>";
	       			} 
	       			else {
	       			$view .= "<td class='" . $this->params . "-boxImage'><img src='framework/resize.class.php?src=" . $img->src . "&h=100&w=130&zc=1' alt=''/></td>";
	       			}
				    		               
	            $contentLength = substr(preg_replace('/<[^>]*>/', '', $value[content]), 0, 100);
	    		$contentLength = substr($contentLength, 0, strrpos($contentLength, ' ')).'...';
	    		
	    		}
	    		else {
	
					if (empty($img->src)) {
					$view .= "<td class='" . $this->params . "-boxImage'><div class='" . $this->params . "-boxNoImage'></div></td>";
	       			break;
	       			} 
	       			else {
	       			$view .= "<td class='" . $this->params . "-boxImage'><img src='framework/resize.class.php?src=" . $img->src . "&h=100&w=130&zc=1' alt=''/></td>";
					break;
	       			}
	       			       		
	    		$contentLength = preg_replace('/<[^>]*>/', '', $value[content]);
	    		
	    		}
	    	
	    	
	        $view .= "<td>";
	        $view .= "<table class='" . $this->params . "-right'>";
	        $view .= "<tr><td class='" . $this->params . "-NewsHeader1'><a href='?id=" . $value[id] . "c'>$value[header]</a></td></tr>";
	        $view .= "<tr><td class='" . $this->params . "-NewsContent1'>$contentLength</td></tr>";
	        $view .= "</table>";
	        $view .= "</td>";
	        $view .= "<td>";
	        $view .= "<tr><td colspan=2><hr/></td></tr>";
	    	$view .= "</tr>";
	        
	        }
        
        }
   	
   	$view .= "</table>";
	
	$view .= "</div>";
	
	$view .= "</div>";
	
	$view .= "
	
	<script type='text/javascript'>
	jQuery.noConflict()(function($){
	var liActivate = '';
	
	$('.verticon-boxImageContent').hide();
	
	$('div.verticon-boxImageContent[numbering=1]').show();
	$('.verticon-counterUl li:first').addClass('verticon-counterLiActive');
	
		$('.verticon-counterUl li').click(function() {
		//liActivate  = 1;
		var id 		= $(this).val();
		var lastID  = $('.verticon-counterLiActive').val();
		
		$('.verticon-counterUl li').removeClass('verticon-counterLiActive'); 
		$(this).addClass('verticon-counterLiActive');
		
			$('div.verticon-boxImageContent').hide();
			$('div.verticon-boxImageContent[numbering='+id+']').fadeIn('slow');
		
		});
		
	$('.verticon-RightFloat').change(function() {
		var id 		= $(this).val();
		var params  = 'verticonContent';
		var row	  	= $(this).attr('row');
		
		$('.$this->params-contentPlaceholder').html('Loading...');
		
		$.post('library/capsule/content/content.ajax.php', {id:id,params:params,row:row,method:'getContentCategory',control:'getContentCategory'}, function(data) {
		$('.$this->params-contentPlaceholder').hide().html(data).fadeIn('slow');
		});
	
	});
	
	var liNow  = $('.verticon-counterLiActive').attr('value');
		
	setTimeout('update(liNow)', 10000);
	
	function update(id) { 
		if (id != 0) { 
	  	var nextID = $('.verticon-counterLiActive').attr('value')+1;
	  	}
	  	else {
	  	var nextID = 1;
	  	}
	  	$('.verticon-counterLi[value='+nextID+']').trigger('click');
	  	if (nextID == 6) {nextID = 0;}
	  	var check = $('.verticonContent-counterLi').length;
	  		if (check != 0) {
	  		setTimeout('updateContent('+nextID+')', 10000);
	  		}
	  		else {
	  		setTimeout('update('+nextID+')', 10000);
	  		}
	}
	
	function updateContent(id) { 
		if (id != 0) { 
	  	var nextID = $('.verticonContent-counterLiActive').attr('value')+1;
	  	}
	  	else {
	  	var nextID = 1;
	  	}
	  	$('.verticonContent-counterLi[value='+nextID+']').trigger('click');
	  	if (nextID == 6) {nextID = 0;}
	  	setTimeout('updateContent('+nextID+')', 10000);
	}
	});
	
	</script>
	
	";
	
    echo $view;
    
    }
    
    
    public function verticonContent() {  
                	        	
        	$i = 0;
        	
        	if (!empty($this->data)) {
        	
        	foreach ($this->data as $key => $value) {
        	
        	if ($i == 5) {break;}
        	
        	$i++;
    
        	$view .= "<div numbering='$i' class='" . $this->params . "-boxImageContent'>";
        	
        	$html  = new simple_html_dom();
        	
        	$html -> load($value[content]);
        	
        	$img   = $html->find('img', 0);
        	
        		if (empty($img->src)) {
        		$view .= "<div class='" . $this->params . "-noImage'></div>";
        		}
        		else {
        		$view .= "<div class='" . $this->params . "-imageUnder'><img src='framework/resize.class.php?src=" .$img->src . "&h=200&w=408&zc=1' alt=''/></div>";
        		}
    
           	$valueID = $value[id];
           	
           	if (strlen($value[header]) >= 55) {
           	$contentLength = substr(preg_replace('/<[^>]*>/', '', $value[header]), 0, 55);
        	$contentLength = substr($contentLength, 0, strrpos($contentLength, ' ')).'..';
        	}
        	else {
        	$contentLength = preg_replace('/<[^>]*>/', '', $value[header]);
        	}
            
            $view .= "<div class='" . $this->params . "-NewsHeader'><a href='?id=" . $valueID . "c'>$contentLength</a></div>";
            
            $view .= "</div>";
            
            $li   .= "<li class='" . $this->params . "-counterLi' value='$i'>$i</li>";
            
            }
            
            }
       	
       		
       	$view .= "<ul class='" . $this->params . "-counterUl'>" . $li . "</ul>";
         
       	$view .= "<table class='" . $this->params . "-left'>";
    	
    	$view .= "<tr>";
    		
    	$y = 0;
    		
    		if (!empty($this->data)) {
    		
        	foreach ($this->data as $key => $value) {
        	
        	$y++;
        	
        	if ($y <= 5) {continue;}
        	
        	$i = 0;
        	
        		$html  = new simple_html_dom();
        	
        		$html -> load($value[content]);
        		
        		$img   = $html->find('img', 0);
        		
        		if (strlen($value[content]) >= 100) {
        		
    				if (empty($img->src)) {
    				$view .= "<td class='" . $this->params . "-boxEmptyImage'><div class='" . $this->params . "-boxNoImage'></div></td>";
           			} 
           			else {
           			$view .= "<td class='" . $this->params . "-boxImage'><img src='framework/resize.class.php?src=" . $img->src . "&h=100&w=130&zc=1' alt=''/></td>";
           			}
    			    		               
                $contentLength = substr(preg_replace('/<[^>]*>/', '', $value[content]), 0, 100);
        		$contentLength = substr($contentLength, 0, strrpos($contentLength, ' ')).'...';
        		
        		}
        		else {
    
    				if (empty($img->src)) {
    				$view .= "<td class='" . $this->params . "-boxImage'><div class='" . $this->params . "-boxNoImage'></div></td>";
           			break;
           			} 
           			else {
           			$view .= "<td class='" . $this->params . "-boxImage'><img src='framework/resize.class.php?src=" . $img->src . "&h=100&w=130&zc=1' alt=''/></td>";
    				break;
           			}
           			       		
        		$contentLength = preg_replace('/<[^>]*>/', '', $value[content]);
        		
        		}
        	
        	
            $view .= "<td>";
            $view .= "<table class='" . $this->params . "-right'>";
            $view .= "<tr><td class='" . $this->params . "-NewsHeader1'><a href='" . $this->url->builder($value['id'].'c',str_replace(" ","-",$value['header']))."/'>$value[header]</a></td></tr>";
            $view .= "<tr><td class='" . $this->params . "-NewsContent1'>$contentLength</td></tr>";
            $view .= "</table>";
            $view .= "</td>";
            $view .= "<td>";
            $view .= "<tr><td colspan=2><hr/></td></tr>";
        	$view .= "</tr>";
            
            }
            
            }
       	
       	$view .= "</table>";
    	    	
    	$view .= "</div>";
    	
    	$view .= "
    	
    	<script type='text/javascript'>
    	
    	var liActivate = '';
    	
    	$('.verticonContent-boxImageContent').hide();
    	
    	$('div.verticonContent-boxImageContent[numbering=1]').show();
    	$('.verticonContent-counterUl li:first').addClass('verticonContent-counterLiActive');
    	
    		$('.verticonContent-counterUl li').click(function() {
    		
    		//liActivate  = 1;
    		var id 		= $(this).val();
    		var lastID  = $('.verticonContent-counterLiActive').val();
    		
    		$('.verticonContent-counterUl li').removeClass('verticonContent-counterLiActive'); 
    		$(this).addClass('verticonContent-counterLiActive');
    		
    			$('div.verticonContent-boxImageContent').hide();
    			$('div.verticonContent-boxImageContent[numbering='+id+']').show();
    		
    		});
    	
    	
    	</script>
    	
    	";
    	
    	
        echo $view;
        
        }
        
	public function table () {  
	    
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
	    $view .= "<hr class='separator-line'/>";
	    
	    $view .= "<table class='" . $this->params . "-left'>";
		$view .= "<tr>";
	
	    	foreach ($this->data as $key => $value) {
	    	    	
	    	$html = new simple_html_dom();
	    	
	    	$html->load($value[content]);
	    		
	    		if ($html->find('img')) {
	    		
	    			foreach($html->find('img') as $element) {
	    		    $view .= "<td class='" . $this->params . "-boxImage'>
	    		    <img src='framework/resize.class.php?src=" . $element->src . "&h=70&w=80&zc=1' alt=''/></td>";
	    		    break; 			
	    		    }
	    		
	    		}
	    		else {
	    		$view .= "<td class='" . $this->params . "-boxImage'><div class='" . $this->params . "-noImage'></div></td>";
	    		}
	    		
	    					    		               
	        $contentLength = substr(preg_replace('/<[^>]*>/', '', $value[content]), 0, 100);
	    	$contentLength = substr($contentLength, 0, strrpos($contentLength, ' ')).'...';
	    	
	    		//if ($html->find('img')) {
	        	$view .= "<td>";
	        	$view .= "<table class='" . $this->params . "-right'>";
	        	$view .= "<tr><td class='" . $this->params . "-NewsHeader'><a href='" . $this->url->builder($value['id'].'c',str_replace(" ","-",$value['header']))."/'>
	        		 	 ".substr(preg_replace('/<[^>]*>/', '', $value[header]), 0, 24)."</a></td></tr>";
	        	$view .= "<tr><td class='" . $this->params . "-NewsContent'>$contentLength</td></tr>";
	        	$view .= "</table>";
	        	$view .= "</td>";
	        	$view .= "<td>";
	        	$view .= "<tr><td colspan=2><hr/></td></tr>";
	    		$view .= "</tr>";
	    		//}
	        
	        }
	   	
	   	$view .= "</table>";
	    $view .= " </div>";
	    
	    echo $view;
	    
	 }
	
	  public function imageVerti() {  
	    
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
	    	$view .= "<span class='" . $this->params . "-HeadingLeft'></span> "; 
	    	}
	        
	  		$view .= $this -> optionGear;
	  		
	        $view .= "<div class='" . $this->params . "-optionSearch'></div>";
	        
	            
	    	
	    	$view .= "<div class='" . $this->params . "-contentPlaceholder'>";
	    	
	    	$i = 0;
	    
	    	foreach ($this->data as $key => $value) {
	    	
	    	if ($i == 5) {break;}
	    	
	    	$i++;
	
	    	$view .= "<div numbering='$i' class='" . $this->params . "-boxImageContent'>";
	    	
	    	$html  = new simple_html_dom();
	    	
	    	$html -> load($value[content]);
	    	
	    	$img   = $html->find('img', 0);
	    	
	    		if (empty($img->src)) {
	    		$view .= "<div class='" . $this->params . "-noImage'></div>";
	    		}
	    		else {
	    		$view .= "<div class='" . $this->params . "-imageUnder'><img src='framework/resize.class.php?src=" .$img->src . "&h=50&w=260&zc=2' alt=''/></div>";
	    		}
	
	       	$valueID = $value[id];
	       	
	       	if (strlen($value[header]) >= 55) {
	       	$contentLength = substr(preg_replace('/<[^>]*>/', '', $value[header]), 0, 55);
	    	$contentLength = substr($contentLength, 0, strrpos($contentLength, ' ')).'..';
	    	}
	    	else {
	    	$contentLength = preg_replace('/<[^>]*>/', '', $value[header]);
	    	}
	        
	        $view .= "<div class='" . $this->params . "-NewsHeader'></div>";
	        
	        $view .= "</div>";
	        
	        $li   .= "<li class='" . $this->params . "-counterLi' value='$i'>$i</li>";
	        
	        }
	   	
	 
	     
	   	$view .= "<table class='" . $this->params . "-left'>";
		
		$view .= "<tr>";
			
		$y = 0;
			
	    	foreach ($this->data as $key => $value) {
	    	
	    	$y++;
	    	
	    	if ($y <= 5) {continue;}
	    	
	    	$i = 0;
	    	
	    		$html  = new simple_html_dom();
	    	
	    		$html -> load($value[content]);
	    		
	    		$img   = $html->find('img', 0);
	    		
	    		if (strlen($value[content]) >= 100) {
	    		
					if (empty($img->src)) {
					$view .= "<td class='" . $this->params . "-boxEmptyImage'><div class='" . $this->params . "-boxNoImage'></div></td>";
	       			} 
	       			else {
	       			$view .= "<td class='" . $this->params . "-boxImage'><img src='framework/resize.class.php?src=" . $img->src . "&h=100&w=130&zc=1' alt=''/></td>";
	       			}
				    		               
	            $contentLength = substr(preg_replace('/<[^>]*>/', '', $value[content]), 0, 100);
	    		$contentLength = substr($contentLength, 0, strrpos($contentLength, ' ')).'...';
	    		
	    		}
	    		else {
	
					if (empty($img->src)) {
					$view .= "<td class='" . $this->params . "-boxImage'><div class='" . $this->params . "-boxNoImage'></div></td>";
	       			break;
	       			} 
	       			else {
	       			$view .= "<td class='" . $this->params . "-boxImage'><img src='framework/resize.class.php?src=" . $img->src . "&h=100&w=130&zc=1' alt=''/></td>";
					break;
	       			}
	       			       		
	    		$contentLength = preg_replace('/<[^>]*>/', '', $value[content]);
	    		
	    		}
	    	
	        $view .= "<td>";
	        $view .= "<table class='" . $this->params . "-right'>";
	        $view .= "<tr><td class='" . $this->params . "-NewsHeader1'><a href='" . $value['id'] . "c-".str_replace(" ","-",$value['header']).".html'>$value[header]</a></td></tr>";
	        $view .= "<tr><td class='" . $this->params . "-NewsContent1'>$contentLength</td></tr>";
	        $view .= "</table>";
	        $view .= "</td>";
	        $view .= "<td>";
	        $view .= "<tr><td colspan=2><hr/></td></tr>";
	    	$view .= "</tr>";
	        
	        }
	   	
	   	$view .= "</table>";
		
		$view .= "</div>";
		
		$view .= "</div>";
		
		$view .= "";
		
	    echo $view;
	    
	    }
	    
	    public function thumbnailContent(){
	    	/*<div class="sixteen columns row teasers">
	    	        	<div class="four columns alpha teaser">
	    	               <a href="#" data-text="» Visit Project" class="hovering"><img src="images/thumbs/home_teaser1.jpg" alt="" class="scale-with-grid" /></a>
	    	               <div class="pluswrap">
	    	                   <a href="#" class="bigplus"></a>
	    	                   <div class="topline"><a href="#">Desktopography</a></div>
	    	                   <div class="subline"><a href="#">Web Design</a></div>
	    	               </div>
	    	            </div>
	    				<div class="four columns teaser">
	    	                <a href="#" data-text="» Visit Project" class="hovering"><img src="images/thumbs/home_teaser2.jpg" alt="" class="scale-with-grid" /></a>
	    	                <div class="pluswrap">
	    	                    <a href="#" class="bigplus"></a>
	    	                    <div class="topline"><a href="#">Wurzburg</a></div>
	    	                    <div class="subline">Photoshop</div>
	    	                </div>
	    	            </div>
	    				<div class="four columns teaser">
	    	                <a href="#" data-text="» Visit Project" class="hovering"><img src="images/thumbs/home_teaser3.jpg" alt="" class="scale-with-grid" /></a>
	    	                <div class="pluswrap">
	    	                    <a href="#" class="bigplus"></a>
	    	                    <div class="topline"><a href="#">Frankfurt</a></div>
	    	                    <div class="subline">Concepts</div>
	    	                </div>
	    	            </div>
	    	            <div class="four columns omega teaser">
	    	            	<a href="#" data-text="» Visit Project" class="hovering"><img src="images/thumbs/home_teaser4.jpg" alt="" class="scale-with-grid" /></a>
	    	                <div class="pluswrap">
	    	                    <a href="#" class="bigplus"></a>
	    	                    <div class="topline"><a href="#">Amsterdam</a></div>
	    	                    <div class="subline">Print Design</div>
	    	                </div>
	    	            </div>
	    	            
	    	            <div class="clear"></div>
	    			</div>
	    	            
	    	            
	    	         */
	    	 $view .= $this -> optionGear;
	    	 $view .= "<hr style='border:0px;'/>";
	    	
	    	$html  = new simple_html_dom();
	    	
	    	
	    	if(count($this->data)>=5){
	    	$i=1;
	    	
	    	 foreach ($this->data as $key => $value) {
	    	 
	    	 
	    	 
	    	  	$mod = $i % 4;
	    	 	if($mod == 1){
	    	 		$view .= "<div class=\"sixteen columns row teasers\">";
	    	 		    	 		
	    	 	}
	    	 	
	    	 	$html -> load($value[content]);
	    	 	
	    	 	$img   = $html->find('img', 0);
	    	 	
	    	 		$view .='<div class="four columns';
	    	 		if($mod == 1){
	    	 		$view .=' alpha ';
	    	 		}elseif ($mod == 0) {
	    	 		$view .=' omega ';
	    	 		}
	    	 		$view .=' teaser" >';
	    	 		$view .='<a href="?id=' . $value[id] . 'c" data-text="» Visit Project" class="hovering" >';
		    	 		if(!empty($img->src)){
		    	 		$view .="<img src=\"framework/resize.class.php?src=" . $img->src . "&h=100&w=130&zc=1\" alt=\"\" class=\"scale-with-grid\" />";
		    	 		}
	    	 		$view .="</a>";
	    	 		$view .="<div class='pluswrap'>";
	    	 		$view .="<a href='?id=" . $value[id] . "c' class=\"bigplus\"></a>";
	    	 		$view .='<div class="topline"><a href=\'" . $value[\'id\'] . "c-".str_replace(" ","-",$value[\'header\']).".html\'>'. $value[header] .'</a></div>';
	    	 		$view .='</div>';
	    	 		$view .='</div>';
	    	 		//</a>
	    	 		  // <div class="pluswrap">
	    	 		    //   <a href="#" class="bigplus"></a>
	    	 		      // <div class="topline"><a href="#">Desktopography</a></div>
	    	 		      // <div class="subline"><a href="#">Web Design</a></div>
	    	 		   //</div>
	    	 	//	</div>
	    	 		if ($mod == 0) {
	    	 			    	 	
	    	 			$view .= "</div>";
	    	 		
	    	 		}
	    	 	
	    	 $i++;
	    	 }
	    	 $view .='</div>';
	    	 }else{
	    	 $view .= "<div class=\"sixteen columns row teasers\">";
	    	 $i=1;
	    	 	foreach ($this->data as $key => $value) {
	    	 	
	    	 	 	$html -> load($value[content]);
	    	 		
	    	 		$img   = $html->find('img', 0);
	    	 		
	    	 			$view .='<div class="four columns';
	    	 			if($i == 1){
	    	 			$view .=' alpha ';
	    	 			}elseif ($i==4) {
	    	 				$view .=' omega ';
	    	 			}
	    	 			$view .=' teaser">';
	    	 			$view .='<a href="?id=' . $value[id] . 'c" data-text="» Visit Project" class="hovering" style="text-align:center">';
	    	 		 		if(!empty($img->src)){
	    	 		 		$view .="<img width='100%' src=\"framework/resize.class.php?src=" . $img->src . "&h=100&w=130&zc=1\" alt=\"\" class=\"scale-with-grid\" />";
	    	 		 		}
	    	 			$view .="</a>";
	    	 			$view .="<div class='pluswrap'>";
	    	 			$view .="<a href='?id=" . $value[id] . "c' class=\"bigplus\"></a>";
	    	 			$view .='<div class="topline"><a href="?id=' . $value[id] . 'c">'. $value[header] .'</a></div>';
	    	 			$view .='</div>';
	    	 			$view .='</div>';
	    	 			//</a>
	    	 			  // <div class="pluswrap">
	    	 			    //   <a href="#" class="bigplus"></a>
	    	 			      // <div class="topline"><a href="#">Desktopography</a></div>
	    	 			      // <div class="subline"><a href="#">Web Design</a></div>
	    	 			   //</div>
	    	 		//	</div>
	    	 			
	    	 		$i++;
	    	 	}
	    	 	$view .= "</div>";
	    	 }
	    	 
	    
	    //print_r($this);
	    echo $view;
	    }
	    
	    public function slider() {
				
		$view  = "<div class='system-marquee-container'>";
        	
	    $view .= $this -> optionGear;
	    
	    $view .= "<div id='system-marquee' style='display:none;'><ul id='webticker'>";
	    
	    if (count($this->data) > 1) {
	    
	    	foreach ($this->data as $key => $value) {
	    		
	    		if (!empty($value[content])) {
	    		
	    			if (strlen($value[content]) >= 20) {
	    			$contentLength = substr(preg_replace('/<[^>]*>/', '', $value[content]), 0, 70);
	    			$contentLength = substr($contentLength, 0, strrpos($contentLength, ' '));
	    			}
	    			else {
	    			$contentLength = preg_replace('/<[^>]*>/', '', $value[content]);
	    			}

	    		$view .= "<li><a href='" . $this->url->builder($value['id'].'c',str_replace(" ","-",$value['header']))."/' class='system-marquee-a'>$value[header]</a></li>";
	    	
	    		}
	    	
	    	}
	    	
	    }
    	    	
	    $view .= "</ul>";
	    $view .= " </div>";
	    $view .= " </div>";
	    
	    if (count($this->data) > 1) {
	    
	    $view .= "<script type='text/javascript'>
	    
	    jQuery.noConflict()(function($){
	    
	    
	    	$(document).ready(function() {
	    	
	    		$('#system-marquee').fadeIn('slow');
		
	    		$('#webticker').webTicker();
	    	
	    	});
	    
	    
	    });
	    
	    
	    </script>";
	    
	    }
    
	    echo $view;
		    
	    }
	    
	    public function blog(){
			
			if(isset($_GET[page])){
				$startPage = $_GET[page];
			}else{
				$startPage = 1;
			}
			
			if(isset($_GET[tag])){
				$tag = $_GET[tag];
			}
			
			
			 $view .= $this -> optionGear;
			 
			 $dataVar = $this->fetchDataPaggingWithRowNumber($startPage,$this -> rowDisplay,$this -> category[0]['id'],$tag);
			 
			 
			 if(!empty($dataVar[0]["array"])){
			 
			 	foreach ($dataVar[0]['array'] as $key => $value) {
			 	
			 		if (!empty($value[content])) {
    		    		
		    			if (strlen($value[content]) >= 300) {
		    			$contentLength = substr(preg_replace('/<[^>]*>/', '', $value[content]), 0, 300);
		    			$contentLength = substr($contentLength, 0, strrpos($contentLength, ' ')).'...';
		    			}
		    			else {
		    			$contentLength = preg_replace('/<[^>]*>/', '', $value[content]);
		    			}
						$html  = new simple_html_dom();
        	
		        		$html -> load($value[content]);
		        		
		        		$img   = $html->find('img', 0);
		        		
				    }
				    
				    if (empty($img->src)) {
		    		$images = "<div class='content-" . $this->params . "-noImage'></div>";
		    		}
		    		else {
		    		$images = '<div class="post-img picture"><a href="'.$this->url->builder($value['id'].'c',str_replace(" ","-",$value['header'])).'.html"><img src="framework/resize.class.php?src=' . $img->src . '&h=320&w=700&zc=1" alt="" /><div class="image-overlay-link"></div></a></div>';
		    		}
	    		$totalComent = $this -> countCommentOfContent($value[id]);
					 $view .= '<div class="post">';
		$view .= $images;
		$view .= '<a href="#" class="post-icon standard"></a>';
		$view .= '<div class="post-content">';
		$view .= '	<div class="post-title"><h2><a href="'.$this->url->builder($value['id'].'c',str_replace(" ","-",$value['header'])).'.html">'.$value[header].'</a></h2></div>';
		$view .= '	<div class="post-meta"><span><i class="mini-ico-calendar"></i>On '.date('F d, Y', strtotime($value[tanggal])).'</span> <span><i class="mini-ico-user"></i>By <a href="#">'.$value[publisher].'</a></span> <span><i class="mini-ico-comment"></i>With <a href="#">'.$totalComent[0][COUNT].' Comments</a></span></div>';
		$view .= '	<div class="post-description">';
			
				
				
				$view .= '		<p>'.$contentLength.'</p>';
		
		
		$view .= '	</div>';
		$view .= '	<a class="post-entry" href="'.$this->url->builder($value['id'].'c',str_replace(" ","-",$value['header'])).'.html">Continue Reading</a>';
		$view .= '</div>';
		$view .= '</div>';
				 }
				if($dataVar[0][totalPage]>1){
					$view .= '<ul class="pagination">';
					
					for($i=1; $i<=$dataVar[0][totalPage]; $i++){
						if(isset($_GET[page])){
							$curPage = $_GET[page];
						}
						if($i == $dataVar[0][currentPage]){
							$view .= '<a href="'.$_SERVER[REQUEST_URI].'&page='.$i.'"><li class="current">'.$i.'</li></a>';
						}else{
							$view .= '<a href="'.$_SERVER[REQUEST_URI].'&page='.$i.'"><li>'.$i.'</li></a>';
						}
					}
					$view .= '</ul>';
				}
			}			
			
			echo $view;
		}

 
} 

?>
