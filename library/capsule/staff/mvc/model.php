<?php

namespace library\capsule\staff\mvc;

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
 * @category   Capsule Model
 * @package    Staff
 * @copyright  Copyright (c) 06-12-2012 Asacreative Technology Indonesia (http://www.asacreative.com)
 * @license    New BSD License
 * @version    Id: model.php 100 Ridwan Abadi $
 * @since      Staff 0.1
 */
 
use \framework\capsule;
use \framework\database\oracle\select;
 
class model extends capsule {
	
	/**
    * Object Constructor
    *
    * @return void
    */
	public function __construct() {
	
		parent::__construct();
			
	}
	
	/**
    * Object Constructor
    *
    * @return void
    */
	public function getDomain() {
		
		$select = new select('*','CAP_MAIN',[['CAP_MAI_PARENT','','IS NULL']]);
		
		$select->execute();
			
			if (!empty($select->arrayResult)):

				foreach ($select->arrayResult as $key => $value):
				
					$array [] = array("id" => $value['CAP_MAI_ID'], "name" => $value['CAP_MAI_DOMAIN']);
				
				endforeach;
			
			endif;

		return $array;
		
	}
	
	/**
    * Object Constructor
    *
    * @return void
    */
	public function getStaffProfile($domain) {
	
		$select = new select();
		
		$select->column = '*, (CAP_USE_FIRSTNAME || \' \' || CAP_USE_LASTNAME) AS FULLNAME';
		
		$select->tableName = 'CAP_USER LEFT JOIN CAP_MAIN ON CAP_USER.FK_CAP_MAI_ID_LOCATION = CAP_MAIN.CAP_MAI_ID';
		
		$select->whereClause = [['FK_CAP_MAI_ID_LOCATION','=',$domain]];
				
		$select->execute();
										
		return $select->arrayResult;
		
	}
	
	/**
    * Object Constructor
    *
    * @return void
    */
	public function getAllStaffDomainBased($domain = null,$prefix = null) {
	
		$select = new select();
		
		$select->column = '*, (CAP_USE_FIRSTNAME || \' \' || CAP_USE_LASTNAME) AS FULLNAME';
		
		$select->tableName = 'CAP_USER LEFT JOIN CAP_MAIN ON CAP_USER.FK_CAP_MAI_ID_LOCATION = CAP_MAIN.CAP_MAI_ID';
		
		$select->whereClause = [['(LOWER(CAP_USE_FIRSTNAME) || \' \' || LOWER(CAP_USE_LASTNAME))','LIKE',$prefix.'%'],['CAP_MAI_PARENT','=',$domain]];
		
		$select->oderClause = '(CAP_USE_FIRSTNAME || \' \' || CAP_USE_LASTNAME) AS FULLNAME ASC';
		
		$select->execute();
		
			if (!empty($select->arrayResult)):
			
				$data = $select->arrayResult;
				
				$select->column = 'CAP_MAI_DOMAIN';
		
				$select->tableName = 'CAP_MAIN';
				
				$select->whereClause = [['CAP_MAI_ID','=',$domain]];
				
				$select->oderClause = null;
				
				$select->execute();
				
				if (!empty($select->arrayResult)):
				
					$data['DOMAIN_NAME'] = $select->arrayResult[0]['CAP_MAI_DOMAIN'];
				
				endif;
			
			endif;
								
		return $data;
		
	}

}

?>

