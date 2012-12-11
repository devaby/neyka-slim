<?php 

namespace framework;

use \framework\capsule;
use \framework\user;
use \library\capsule\admin\admin;
use \framework\database\oracle\menu as routing;
use \framework\database\oracle\select;
use \framework\simple_html_dom as dom;

class pages {

public $capName;
public $capCreator;
public $capDescription;
public $capCSS;
public $capJS;

	public function __construct ($capName,$capCreator,$capDescription,$capCSS,$capJS) {
	
		$this -> capName 		= $capName;
		$this -> capCreator 	= $capCreator;
		$this -> capDescription = $capDescription;
		$this -> capCSS 		= $capCSS;
		$this -> capJS 			= $capJS;
                
        self::declareCSSAndJS();
	
	}
        
    public function declareCSSAndJS () {
    
        echo $this -> capCSS;
        echo $this -> capJS;
        
    }
	
	public function init ($object) {
    	
    	$id = $GLOBALS['_neyClass']['router']->determinator();

		$page   = $id; $lang = $_GET["lang"];
		
		$domain = $GLOBALS['_neyClass']['sites']->domain();
		                		
		if (BUFFERING): ob_start(); endif;
		
		$language = self::checkLanguage($lang);
		
		server::sessionChecker($page);

		if (empty($page)): $page = ''; endif;
			
			if (!isset($_SESSION['admin'])):
			
			$memcache = $GLOBALS['_neyClass']['memcache'];
						
			$cache = $memcache->engine->get(hash('sha256',ROOT_PATH.$page.$domain));

				if ($cache !== false):

				eval ("?>".$cache."<?");
				
				die;
				
				else:
				
				$cacheReload = true;
				
				endif;
			
			endif;

		$webs   = new select("*","CAP_MAIN",[["CAP_MAI_ID","=",$domain]]); 

		$webs->execute(); 

		$webs   = $webs->arrayResult[0]['CAP_MAI_NAME'];
		
		$data   = new routing ("","CAP_MENU","CAP_MEN_ID",$page);

		$data->selectFindMenuPath($page,$lang);
		
		if (!empty($data->page)): $_SESSION['_Neyka_Menu'] = $data->page; endif;

		if (isset($_SESSION['admin'])) {$javascript = admin::init($data->contentID,$data->page); }
		
		$core  = $GLOBALS['_neyClass']['sites']->pages($data->pageID);

		if (empty($core) && $data->type): $GLOBALS['_neyClass']['sites']->setTemplate('core'); endif;
		
		$cont  = file_get_contents($data->singleResult);
		
		if (isset($_SESSION['admin'])) { 
        $cont  = str_replace('{replaceWithContentHeader}', $data->header, $cont);
        }
        else {
        $cont  = str_replace('{replaceWithContentHeader}', "", $cont);
        }
		        	
        $cont  = str_replace('{replaceWithContent}', $data->content, $cont); $container = encryption::base64Decoding($data->pagesContainer);
 		
 			if (!empty($container)) {

        		foreach ($container as $key => $value) {

        			if ($value != 'undefined') {
        			
        			$cname  = (is_array($value)) ? $value['capsuleName'] : null;
        			$init	=  new select("*","CAP_LIST",array(array("CAP_LIS_NAME","=",$cname)),"","");
					$init	-> execute();
					$cont 	= self::option($cont,$init,$value);
        			}
        			
        		}
        	
        	}
		
		$admin  = $javascript[1];
		$admin .= "<input type='hidden' id='core-capsule-unique-page-id' value='" . $data->whereID . "'>"; 
				
        if (isset($_SESSION['admin'])) { 
        $admin .= "<input type='hidden' name='pagePathToFile' value='" . $data->pageID . "'>"; 
        $admin .= "<input type='hidden' name='contentLanguageDeterminator' value='" . $data->check . "'>";
        }        
        
        $object->template  = self::openingTemplateHeader($object,$data->header,$cont,$admin,$webs,$data->menu,$data->description,$javascript[0]); 

        capsule::init();

        if (!isset($_SESSION['admin'])):
        
        	if ($cacheReload):
        
        	//$memcache->engine->set(hash('sha256',ROOT_PATH.$page.$domain), $object->template, false, 30);

        	endif;
        
        endif;
                                
        eval ("?>".$object->template);
                        					
	}
	
	public function openingTemplateHeader($object,$title,$cont,$admin,$webs,$menu,$description,$javascript) {

		if (!empty($menu)) {
		$theTitle = "<title>".$webs." - ".$menu."</title>";
		}
		else {
		$theTitle = "<title>".$webs."</title>";
		}
				
		$object->meta  	  = str_replace('{META-KEYWORDS}', "", $object->meta);
		
		$object->meta  	  = str_replace('{META-DESCRIPTION}', $description, $object->meta);
		
		$object->meta  	  = str_replace('{META-AUTHOR}', "", $object->meta);
		
		$object->template = str_replace('{$OPENING}', $object->htmlHeader. PHP_EOL . '<html>' . PHP_EOL . '<head>'. PHP_EOL .$object->meta, $object->template);
		
		$object->template = str_replace('{$TITLE}', $theTitle, $object->template);
				
		$object->template = str_replace('{$LINK}', $object->link, $object->template);
				
		$object->template = str_replace('{$SCRIPT}', '', $object->template);
		
		$html = new simple_html_dom();
		
		$html->load($admin.$cont); $body = $html->find('body', 0);
		
		if (empty($body)): $bodyOpen = '<body>'; $bodyClose = '</body>'; endif;
		
		$object->template = str_replace('{$BODY}', '</head>' . PHP_EOL . $bodyOpen . PHP_EOL . $admin . PHP_EOL . $cont . PHP_EOL . $bodyClose, $object->template);
				
		$object->template = str_replace('{$CLOSING}', $javascript . PHP_EOL . self::googleAnalytic() . PHP_EOL . $object->script . PHP_EOL . '</html>', $object->template);
	
		return $object->template;
	
	}
	
	public static function checkLanguage($lang) {
	
		if (empty($_SESSION['language'])) {
		$init =  new select("*","CAP_MAIN","","",""); $init->execute(); $language = $init->arrayResult[0]['CAP_MAI_LANGUAGE'];
		server::setDefaultLanguage($language);
		}
	
	}
	
	public static function option($cont,$init,$value) {

		$text	  =  (is_array($value)) ? "{"."capsuleID" . $value['containerNo'] . "}" : "{capsuleID}";

		$command  = $init->arrayResult[0]['CAP_LIS_INIT'];
				
		$file     = substr(str_replace('\\','/',reset(explode(':',$command))),1);
		
		$class    = reset(explode(':',$command));
        
        $method   = end(explode(':',$command));

            if (isset($value['capsuleOption'])) {
            
            $option = encryption::base64Decoding($value['capsuleOption']);
            
            	if (!empty($option)) {
            	
            		foreach ($option as $key => $theValue) {
            		
            			foreach ($theValue as $key2 => $value2) {
            			
            			$command = str_replace("\"{" . strtolower($key2) . "}\"","\"$value2\"",$command);
            			            			
            			}
            			
            		}
            		
            	}
            	
            }
            else {
            
            $command = str_replace("\"{view}\"","\"normal\"",$init->arrayResult[0]['CAP_LIS_INIT']);
            
            }

            if (is_callable([$class,'init']) && file_exists(ROOT_PATH.$file.'.main.php')) {
                                    
	        $cont = str_replace($text, "<input type=\"hidden\" name=\"capsuleID\" value='" . $value['capsuleID'] . "'><input type='hidden' name='initWithOption' value='$value[capsuleOption]'><?php " .  $command . " ?>", $cont);
		
		    }
		
		return $cont;
	
	}
	
	public static function googleAnalytic() {
	/*
	return "<script type=\"text/javascript\">

  	var _gaq = _gaq || [];
  	_gaq.push(['_setAccount', 'UA-30243039-1']);
  	_gaq.push(['_trackPageview']);

  	(function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  	})();

	</script>";
	*/
	}
	
}


?>