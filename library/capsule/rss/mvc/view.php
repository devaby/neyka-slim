<?php

namespace library\capsule\rss\mvc;

use \framework\rss;
use \framework\simple_html_dom;
use \framework\image;
use \framework\resize;

class view extends model {

protected $data;
protected $category;
protected $userCategory;
protected $text;
protected $row;
protected $optionGear;
protected $params;
protected $optionSearch;

    public function __construct($text,$params,$rowDisplay,$url) {
        
    parent::__construct();

	
    if ($rowDisplay == '{row display}') {
    $data = $this->fetchData();
    }
    else {
    $rss = new rss;
    
    // setup transparent cache
    //$rss->cache_dir = './cache';
    //$rss->cache_time = 300; // one hour
    
    // load some RSS file
    if ($data = $rss->get("$url")) {
    }
    else {
    var_dump($data);
    }
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
    
    $this -> userCategory	= $newCat;
    $this -> category 		= $this->fetchDataForOptionCategory();
    $this -> text     		= $text;
    $this -> data     		= $data; 
    $this -> params   		= $params;
    $this -> row	  		= $rowDisplay;
    
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
    $view .= "<hr class='separator-line'/>";
    $view .= "<table>";

    	foreach ($this->data as $key => $value) {
    		
    		if (!empty($value[content])) {
    		    		
    			if (strlen($value[content]) >= 500) {
    			$contentLength = substr(preg_replace('/<[^>]*>/', '', $value[content]), 0, 100);
    			$contentLength = substr($contentLength, 0, strrpos($contentLength, ' ')).'...';
    			}
    			else {
    			$contentLength = preg_replace('/<[^>]*>/', '', $value[content]);
    			}
    	
    		$view .= "<tr><td class='" . $this->params . "-NewsHeader'><a href='" . $value[site] . "' target='_blank'>".str_replace("+0000","",$value[date])."</a></td></tr>";
    		$view .= "<tr><td class='" . $this->params . "-NewsContent'>$contentLength</td></tr>";
    		$view .= "<tr><td colspan=2><hr/></td></tr>";
    	
    		}
    	
    	}
   	
   	$view .= "</table>";
    $view .= " </div>";
    
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
        
    	foreach ($this->data as $key => $value) {
    		
    		if (!empty($value[content])) {
    		
    			if (strlen($value[content]) >= 20) {
    			$contentLength = substr(preg_replace('/<[^>]*>/', '', $value[content]), 0, 70);
    			$contentLength = substr($contentLength, 0, strrpos($contentLength, ' '));
    			}
    			else {
    			$contentLength = preg_replace('/<[^>]*>/', '', $value[content]);
    			}
    	
    		$view .= "<tr><td class='" . $this->params . "-NewsHeader'><a href='index.php?id=" . $value[id] . "c'>$value[header]</a></td></tr>";
    		$view .= "<tr><td><hr/></td></tr>";
    	
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
    $view .= "<hr class='separator-line'/>";
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
    	
    		$view .= "<tr><td><img class='" . $this->params . "-contentImage' src='library/capsule/content/image/cal.png'></td><td class='" . $this->params . "-NewsHeader'><a href='index.php?id=" . $value[id] . "c'>$value[header]</a></td></tr>";
    		$view .= "<tr><td colspan=2><hr/></td></tr>";
    	
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
        	$view .= "<tr><td class='" . $this->params . "-NewsHeader'><a href='index.php?id=" . $value[id] . "c'>
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
        
        $view .= "<div class='" . $this->params . "-NewsHeader'><a href='index.php?id=" . $valueID . "c'>$valueHeader</a></div>";
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
    	
    	$view .= "<tr><td><td class='" . $this->params . "-NewsHeader'> - <a href='index.php?id=" . $value[id] . "c'>$value[header]</a></td></tr>";
    	$view .= "<tr><td></td></tr>";
    	
    	}
   	
   	$view .= "</table>";
    $view .= " </div>";
    
    echo $view;
    
    }
 
  public function verticon() {  
    
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
        
        $view .= "<select class='" . $this->params . "-RightFloat' row='" . $this->row . "'>";
        
        	foreach ($this->category as $cat) {

        		if ($cat[id] == $this->userCategory[0]) {
        		$view .= "<option selected='selected' value='$cat[id]'>$cat[name]</option>";
        		}
        		else if (in_array($cat[id],$this->userCategory)) {
        		$view .= "<option value='$cat[id]'>$cat[name]</option>";
        		}
        	
        	}
        
    	$view .= "</select>";
				
    	$view .= "<hr class='separator-line'/>";
    	
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
        
        $view .= "<div class='" . $this->params . "-NewsHeader'><a href='index.php?id=" . $valueID . "c'>$contentLength</a></div>";
        
        $view .= "</div>";
        
        $li   .= "<li class='" . $this->params . "-counterLi' value='$i'>$i</li>";
        
        }
   	
   		
   	$view .= "<ul class='" . $this->params . "-counterUl'>" . $li . "</ul>";
     
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
        $view .= "<tr><td class='" . $this->params . "-NewsHeader1'><a href='index.php?id=" . $value[id] . "c'>$value[header]</a></td></tr>";
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
	
	$view .= "
	
	<script type='text/javascript'>
	
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
            
            $view .= "<div class='" . $this->params . "-NewsHeader'><a href='index.php?id=" . $valueID . "c'>$contentLength</a></div>";
            
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
            $view .= "<tr><td class='" . $this->params . "-NewsHeader1'><a href='index.php?id=" . $value[id] . "c'>$value[header]</a></td></tr>";
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
	        	$view .= "<tr><td class='" . $this->params . "-NewsHeader'><a href='index.php?id=" . $value[id] . "c'>
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
	 
	 public function forex () {  
	     //print_r($this->data);
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
	         	$view .= "<tr><td class='" . $this->params . "-NewsHeader'><a href='" . $value[site] . "'>
	         		 	 ".substr(preg_replace('/<[^>]*>/', '', $value[header]), 0, 24)."</a></td></tr>";
	         	$view .= "<tr><td class='" . $this->params . "-NewsContent'>$value[content]</td></tr>";
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
	
 
} 

?>
