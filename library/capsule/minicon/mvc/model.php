<?php

namespace library\capsule\minicon\mvc;

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
 * @category   Capsule Model
 * @package    Minicon
 * @copyright  Copyright (c) 09-12-2012 Asacreative Technology Indonesia (http://www.asacreative.com)
 * @license    New BSD License
 * @version    Id: model.php 100 Ridwan Abadi $
 * @since      Minicon 0.1
 */
 
use \framework\capsule;
use \framework\database\oracle\select;
use \framework\database\oracle\insert;
use \framework\database\oracle\update;
use \framework\database\oracle\delete;
use \library\capsule\accounting\lib\log;
 
class model extends capsule {

/**
* Object Constructor
*
* @return void
*/
protected $db;

	/**
    * Object Constructor
    *
    * @return void
    */
	public function __construct() {
	
		parent::__construct();
		
		$this->db = ['select' => new select(), 'insert' => new insert(), 'update' => new update(), 'delete' => new delete()];
			
	}
	
	public function getTagonomy() {
		
		$domain = $GLOBALS['_neyClass']['sites']->domain();
		
		$this->db['select']->column = '*';
		
		$this->db['select']->tableName = 'cap_content_category';
		
		$this->db['select']->whereClause = [['fk_cap_mai_id','=',$domain]];
		
		$this->db['select']->orderClause = 'cap_con_cat_name';
				
		$this->db['select']->execute();
		
		return $this->db['select']->arrayResult;
		
	}

}

?>

