<?php

namespace library\capsule\share\mvc;

use \framework\capsule;

class model extends capsule {

protected $data;

    public function __construct () {
	
		parent::__construct(
		
		"Language",
		"Media Instrument, Inc Team",
		"This is the language capsule",
		"<link href='library/capsule/share/css/share.css' rel='stylesheet' type='text/css'/>",
		"<script src='library/capsule/share/js/share.js' type='text/javascript'></script>"
	
		);
	
	$this->init();
		
	}
	
	public function init() {
	
	$this->data = array(
	
	"facebook" 	=> "<a name='fb_share'></a><script src='http://static.ak.fbcdn.net/connect.php/js/FB.Share' type='text/javascript'></script>",
	
	"twitter" 	=> "<a href='https://twitter.com/share' class='twitter-share-button' data-count='horizontal' data-via='shegaforex'>Tweet</a>
					<script type='text/javascript' src='//platform.twitter.com/widgets.js'></script>"
	);
				
	}
	
	public function model2nd() {
	
	return array(
		
	"facebook" 	=> "<div id='fb-root'></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = '//connect.facebook.net/en_US/all.js#xfbml=1&appId=193808020175';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script><div class='fb-like' data-send='false' data-layout='box_count' data-width='50' data-show-faces='false'></div>",
	
	"twitter" 	=> "<a href='https://twitter.com/share' class='twitter-share-button' data-lang='en' data-count='vertical' data-via='shegaforex'>Tweet</a>

    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='//platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','twitter-wjs');</script>",
    
    "googleplus" => "<script type='text/javascript'>
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script><g:plusone size='tall'></g:plusone>"
    
	);
				
	}
	
}

?>