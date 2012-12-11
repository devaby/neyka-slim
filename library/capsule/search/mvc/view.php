<?php

namespace library\capsule\search\mvc;

class view extends model {

protected $params;
protected $optionGear;

	public function __construct($params,$text) {

	parent::__construct(); $this->params = $params; 
	
	if ($params == 'search') {$this->data = self::getSearchData($text);}

	if (isset($_SESSION['admin']) || !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	$this -> optionGear = "<span class='share-optionGear'><img class='share-optionGear' src='library/capsule/admin/image/settingCap.png'></span>";
	}
	
	
	if ($params == "{view}") {$this->params = 'normal';} else {$this->params = $params;} $params = $this->params; $this->$params();
	}
	
     public function normal() {
        
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
    	
    $('.search-normal-input').focus(function() {
    
    	if ($(this).val() == 'Type to search...') {
    	$(this).val('');
    	$(this).removeClass(); $(this).addClass('search-normal-input-active');
    	}
    	
    });
    
    $('.search-normal-input').blur(function() {
    
    	if ($(this).val() == '') {
    	$(this).val('Type to search...');
    	$(this).removeClass(); $(this).addClass('search-normal-input');
    	$('.search-normal-result').slideUp('fast',function() {
    	$('.search-normal-result').remove();
    	});
    	}
    	
    });
    
    $('.search-normal-input').keyup(function() {
    
    var check = $('.search-normal-result').length;
    var text  = $('.search-normal-input-active').val();
    
    	if (check == 0) {
    	var position = $('.search-normal-input-active').offset();
    	$('body').append('<div class=\'search-normal-result\'><div class=\'search-normal-content\'></div><div class=\'search-normal-loader\'><img class=\'search-normal-ajaxLoader\' src=\'library/images/ajax-loader.gif\'> Loading..</div></div>');
    	$('.search-normal-result').hide();
    	$('.search-normal-result').css('top', position.top + 23 + 'px').css('left', position.left + 11 + 'px');
    	$('.search-normal-result').slideDown('fast');
    	}
    	
    	if ($('.search-normal-loader:hidden').length == 1) {
    	$('.search-normal-loader').show();
    	}
    	
    	delay(function(){
    		if (text != '') {
    			$.post('library/capsule/search/search.ajax.php',{control:'getSearchResult',text:text}, function(data) {
    			$('.search-normal-content').html(data); $('.search-normal-loader').hide();
    			});
    		}
    		else {
    		$('.search-normal-result').slideUp('fast',function() {
    		$('.search-normal-result').remove();
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
	
		foreach ($this->data as $key => $value) {
		
		$caption= str_replace(array('-',' '), '-', $value["header"]);
		
		$view .= "<tr><td><a href='".$value['id']."-".$caption.".html'>$value[header]</a></td></tr>";
				
		$view .= "<tr><td>".trim(preg_replace("/&#?[a-z0-9]{2,8};/i"," ",$value['content']))."..</td></tr>";
		
		$view .= "<tr><td><hr /></td></tr>";
		
		}
	
	}
	
	$view .= "</table>";
	
	echo $view;
	
    }

}

?>