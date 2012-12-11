<?php

/** 
 * Bismillahirohmanirohim…
 *
 * Capsule Menu
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://capsule.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@neyka.com so we can send you a copy immediately.
 *
 * @category   Neyka
 * @package    Capsule
 * @copyright  Copyright (c) 2005-2012 Neyka
 * @license    http://neyka.com/license/new-bsd     New BSD License
 * @version    $Id: Acl.php 24772 2012-05-07 01:16:52Z Ridwan Abadi $
 */

namespace library\capsule\menu\mvc;

use \framework\capsule;
use \framework\database\oracle\select;
use \framework\database\oracle\insert;
use \framework\database\oracle\delete;
use \framework\database\oracle\update;

class model extends capsule {

/**
* Set the database handler for CRUD operation
*
* @return this object
*/
protected $data;
    
    /**
    * Set the database handler for CRUD operation
    *
    * @return this object
    */
	public function __construct () {
	
		parent::__construct(
		
		"Register",
		"Media Instrument, Inc Team",
		"This is the language capsule",
		"<link href='library/capsule/share/css/share.css' rel='stylesheet' type='text/css'/>",
		"<script src='library/capsule/share/js/share.js' type='text/javascript'></script>"
	
		);

	}
	
	/**
    * Set the database handler for CRUD operation
    *
    * @return this object
    */
	public function getMenuSet() {
    	
    	$domain = $GLOBALS['_neyClass']['sites']->domain();
		
		if (empty($_SESSION['role'])):
	   		
		$role = new select("*","CAP_USER_ROLE",[["CAP_USE_ROL_NAME","=","guest"]],"",""); 
		
		$role->execute(); 
		
		$role = $role->arrayResult[0]['CAP_USE_ROL_ID'];
		   		
		$_SESSION['role'] = $role;
	   		
	   	else:
	   	
	   	$role = new select("*","CAP_USER_ROLE",[["CAP_USE_ROL_NAME","=","guest"]],"",""); 
	   	
	   	$role->execute(); 
	   	
	   	$role = $role->arrayResult[0]['CAP_USE_ROL_ID'];

	   	endif;
			
		if ($_SESSION['roleName'] == 'global administrator'):

		$select = new select(
		'*',
		'CAP_MENU 
		LEFT JOIN CAP_LANGUAGE_COMBINE ON CAP_MENU.CAP_MEN_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID
		LEFT JOIN CAP_MENU_PAGES ON CAP_MENU.CAP_MEN_ID = CAP_MENU_PAGES.CAP_MENU_CAP_MEN_ID
		LEFT JOIN CAP_MENU_TYPE ON CAP_MENU.CAP_MENU_TYPE_CAP_MEN_TYP_ID = CAP_MENU_TYPE.CAP_MEN_TYP_ID',
		[
			['CAP_LAN_COM_TYPE','=','menu'],
			['CAP_MENU_TYPE_CAP_MEN_TYP_ID','=',$this->data],
			['CAP_LAN_COM_LAN_ID','=',$_SESSION['language']],
			['FK_CAP_MAI_ID','=',$domain],
		],
		'',
		'CAP_MEN_POSITION2 ASC');

		else:

		$select = new select(
		'*',
		'CAP_MENU 
		LEFT JOIN CAP_LANGUAGE_COMBINE ON CAP_MENU.CAP_MEN_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_FKID
		LEFT JOIN CAP_MENU_PAGES ON CAP_MENU.CAP_MEN_ID = CAP_MENU_PAGES.CAP_MENU_CAP_MEN_ID
		LEFT JOIN CAP_MENU_TYPE ON CAP_MENU.CAP_MENU_TYPE_CAP_MEN_TYP_ID = CAP_MENU_TYPE.CAP_MEN_TYP_ID',
		[
			['CAP_LAN_COM_TYPE','=','menu'],
			['CAP_MENU_TYPE_CAP_MEN_TYP_ID','=',$this->data],
			['CAP_LAN_COM_LAN_ID','=',$_SESSION['language']],
			['CAP_MEN_ACCESS','=',$role],
			['CAP_MEN_STATUS','=','Active'],
			['FK_CAP_MAI_ID','=',$domain],
			['','OR',''],
			['CAP_LAN_COM_TYPE','=','menu'],
			['CAP_MENU_TYPE_CAP_MEN_TYP_ID','=',$this->data],
			['CAP_LAN_COM_LAN_ID','=',$_SESSION['language']],
			['CAP_MEN_ACCESS','=',$_SESSION['role']],
			['CAP_MEN_STATUS','=','Active'],
			['FK_CAP_MAI_ID','=',$domain],
		],
		'',
		'CAP_MEN_POSITION2 ASC');

		endif;

    	$select->execute();
    
    	return $select->arrayResult;

	}
	
	/**
    * Set the database handler for CRUD operation
    *
    * @return this object
    */
	public function getMenuSetForOption() {
		
		$domain = $GLOBALS['_neyClass']['sites']->domain();
		
    	$select = new select('*','CAP_MENU_TYPE',[['FK_CAP_MAI_ID','=',$domain]],'','CAP_MEN_TYP_ID ASC'); 
    	
    	$select->execute();
    	
    	if (!empty($select->arrayResult)):
    	
    		foreach ($select->arrayResult as $value):
    		
    		  $array [] = ['id' => $value['CAP_MEN_TYP_ID'], 'name' => $value['CAP_MEN_TYP_TYPE']];
    		
    		endforeach;
    		
    	endif;
    	
    	return $array;

	}
	
	/**
    * Set the database handler for CRUD operation
    *
    * @return this object
    */
	public function getRole() {
    	
        $select = new select("*","CAP_USER_ROLE ORDER BY CAP_USE_ROL_ID ASC","","",""); $select->execute();
    	
    		foreach ($select->arrayResult as $value):
    		
    		  $array [$value['CAP_USE_ROL_ID']] = strtolower(str_replace(' ','-',$value['CAP_USE_ROL_NAME']));
    		
    		endforeach;
    	
    	return $array;	
    	
	}
	
}

?>