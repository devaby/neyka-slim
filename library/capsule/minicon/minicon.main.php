<?php

namespace library\capsule\minicon;

/**
 * Minicon Capsule
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
 * @package    Minicon
 * @copyright  Copyright (c) 09-12-2012 Asacreative Technology Indonesia (http://www.asacreative.com)
 * @license    New BSD License
 * @version    Id: minicon.main.php 100 Ridwan Abadi $
 * @since      Minicon 0.1
 */

use \library\capsule\minicon\mvc\model;
use \library\capsule\minicon\mvc\view;
use \library\capsule\minicon\mvc\controller;

class minicon {

	/**
    * Main Static Function
    *
    * @return new view
    */
	public static function init($params=null) {
	
    	return new view($params);
    
   	}

}

?>

