#!/bin/sh

# Include all capsule script helper
source /srv/www/$1/incl/sh_helper/capsule/parameters.sh  

CAPSULE_INFO="<?php

\$info = [
		'execute' => '\library\capsule\\$CAPSULE_NAME\\$CAPSULE_NAME::init(\"{view}\");',
		'option'  => ['view' => ['type' => 'select', 'value' => ['normal']]]
		];

return \$info;

?>
"

CAPSULE_MAIN="<?php

namespace library\capsule\\$CAPSULE_NAME;

/**
 * ${CAPSULE_NAME[@]^} Capsule
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@asacreative.com so we can send you a copy immediately.
 *
 * @category   Capsule Primary Class
 * @package    ${CAPSULE_NAME[@]^}
 * @copyright  Copyright (c) $CURRENT_TIME Asacreative Technology Indonesia (http://www.asacreative.com)
 * @license    New BSD License
 * @version    Id: $CAPSULE_NAME.main.php 100 Ridwan Abadi $
 * @since      ${CAPSULE_NAME[@]^} 0.1
 */

use \library\capsule\\$CAPSULE_NAME\mvc\model;
use \library\capsule\\$CAPSULE_NAME\mvc\view;
use \library\capsule\\$CAPSULE_NAME\mvc\controller;

class $CAPSULE_NAME {

	/**
    * Main Static Function
    *
    * @return new view
    */
	public static function init(\$params=null) {
	
    	return new view(\$params);
    
   	}

}

?>
"

CAPSULE_AJAX="<?php

//Declaring namespace
namespace library\capsule\\$CAPSULE_NAME;

//Including Global Configuration
include_once('../../../config.php');

//Including Singleton Static Instance
include_once ROOT_PATH.'framework/neyka.class.php'; 

//Gentlemen, Start Your Engine!
use \framework\token;
use \library\capsule\\$CAPSULE_NAME\lib\log;

//Gentlemen, Start Your Engine!
\framework\neyka::startAjax();

//Starting Session
session_start();

\$data     = \$_POST['data']['data'];

\$token    = \$_POST['data']['capsuleCSRFToken'];

\$control  = \$_POST['data']['control'];

\$getToken = token::checkToken(\$token);

\$error    = (\$getToken != \$token) ? 'You may be a victim of a CSRF attack' : null;

if (!empty(\$error)): echo json_encode(array('response' => 'error', 'view' => 'You may be a victim of a CSRF attack')); log::logEvent('event',\$error); return false; endif;

switch(\$control):
	
	/*
	* Default ajax response
	*/
	default:
	echo json_encode(array('response' => 'error', 'view' => 'no available controller'));
	break;
	
endswitch;

?>
"

CAPSULE_MVC_MODEL="<?php

namespace library\capsule\\$CAPSULE_NAME\mvc;

/**
 * ${CAPSULE_NAME[@]^} Capsule
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@asacreative.com so we can send you a copy immediately.
 *
 * @category   Capsule Model
 * @package    ${CAPSULE_NAME[@]^}
 * @copyright  Copyright (c) $CURRENT_TIME Asacreative Technology Indonesia (http://www.asacreative.com)
 * @license    New BSD License
 * @version    Id: model.php 100 Ridwan Abadi $
 * @since      ${CAPSULE_NAME[@]^} 0.1
 */
 
use \framework\capsule;
 
class model extends capsule {
	
	/**
    * Object Constructor
    *
    * @return void
    */
	public function __construct() {
	
		parent::__construct();
			
	}

}

?>
"

CAPSULE_MVC_VIEW="<?php

namespace library\capsule\\$CAPSULE_NAME\mvc;

/**
 * ${CAPSULE_NAME[@]^} Capsule
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@asacreative.com so we can send you a copy immediately.
 *
 * @category   Capsule View
 * @package    ${CAPSULE_NAME[@]^}
 * @copyright  Copyright (c) $CURRENT_TIME Asacreative Technology Indonesia (http://www.asacreative.com)
 * @license    New BSD License
 * @version    Id: view.php 100 Ridwan Abadi $
 * @since      ${CAPSULE_NAME[@]^} 0.1
 */
 
class view extends model {

/**
* 
* @var null
* 
*/
protected \$params = null;

/**
* 
* @var null
* 
*/
protected \$site = null;

	/**
    * Object Constructor
    *
    * @return void
    */
	public function __construct(\$params) {
	
		parent::__construct();
		
		\$this->site = substr(APP, 0, -1);
		
		if (isset(\$_SESSION['admin']) || isset(\$_SESSION['admin']) && !empty(\$_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower(\$_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'):
		
		\$this->optionGear = '<span class="forex-optionGear"><img class="optionGear" src=\"' . \$this->site . '/library/capsule/admin/image/settingCap.png\"></span>';
		
		\$this->ajax = true;
		
		endif;
	
		\$this->params = (\$params == '{view}' || empty(\$params))  ? 'normal' : \$this->params = \$params; 
		
		\$this->\$params();
			
	}
	
	/**
    * Object normal view
    *
    * @echo view
    */
	public function normal() {
	
		\$view .= \$this->optionGear;
	
		echo 'Select a ${CAPSULE_NAME[@]^} view ' . \$view;
                
    }

}

?>
"

CAPSULE_MVC_CONTROLLER="<?php

namespace library\capsule\\$CAPSULE_NAME\mvc;

/**
 * ${CAPSULE_NAME[@]^} Capsule
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@asacreative.com so we can send you a copy immediately.
 *
 * @category   Capsule Controller
 * @package    ${CAPSULE_NAME[@]^}
 * @copyright  Copyright (c) $CURRENT_TIME Asacreative Technology Indonesia (http://www.asacreative.com)
 * @license    New BSD License
 * @version    Id: controller.php 100 Ridwan Abadi $
 * @since      ${CAPSULE_NAME[@]^} 0.1
 */

class controller {

	/**
    * Object Constructor
    *
    * @return void
    */
	public function __construct() {
	
		parent::__construct();
			
	}

}

?>
"

CAPSULE_JS="/**
 * ${CAPSULE_NAME[@]^} Capsule
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@asacreative.com so we can send you a copy immediately.
 *
 * @category   Capsule Javascript
 * @package    ${CAPSULE_NAME[@]^}
 * @copyright  Copyright (c) $CURRENT_TIME Asacreative Technology Indonesia (http://www.asacreative.com)
 * @license    New BSD License
 * @version    Id: $CAPSULE_NAME.js 100 Ridwan Abadi $
 * @since      ${CAPSULE_NAME[@]^} 0.1
 */
"

CAPSULE_CSS="/**
 * ${CAPSULE_NAME[@]^} Capsule
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@asacreative.com so we can send you a copy immediately.
 *
 * @category   Capsule CSS
 * @package    ${CAPSULE_NAME[@]^}
 * @copyright  Copyright (c) $CURRENT_TIME Asacreative Technology Indonesia (http://www.asacreative.com)
 * @license    New BSD License
 * @version    Id: $CAPSULE_NAME.css 100 Ridwan Abadi $
 * @since      ${CAPSULE_NAME[@]^} 0.1
 */
"