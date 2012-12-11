<?php

namespace library\capsule\staff;

/**
 * Staff Capsule
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
 * @package    Staff
 * @copyright  Copyright (c) 06-12-2012 Asacreative Technology Indonesia (http://www.asacreative.com)
 * @license    New BSD License
 * @version    Id: staff.main.php 100 Ridwan Abadi $
 * @since      Staff 0.1
 */

use \library\capsule\staff\mvc\model;
use \library\capsule\staff\mvc\view;
use \library\capsule\staff\mvc\controller;

class staff {

	/**
    * Main Static Function
    *
    * @return new view
    */
	public static function init($params=null, $domain=null) {
	
    	return new view($params,$domain);
    
   	}
   	
   	/**
    * Main Static Function
    *
    * @return new view
    */
	public static function getDomain() {
	
    	return model::getDomain();
    
   	}

}

?>