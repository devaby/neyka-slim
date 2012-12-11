<?php

/** 
 * Bismillahirohmanirohim…
 *
 * Capsule Login
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

namespace library\capsule\login\mvc;

use \framework\capsule;
use \framework\encryption;
use \framework\database\oracle\select;

class model extends capsule {

/**
* Set the database handler for CRUD operation
*
* @return this object
*/
protected $loginUsername;

/**
* Set the database handler for CRUD operation
*
* @return this object
*/
protected $loginPassword;
    
    /**
    * Set the database handler for CRUD operation
    *
    * @return this object
    */
    public function __construct ($username,$password) {
	
		parent::__construct(
	
		"Login Capsule",
		"Erwin + Aby",
		"This is Login capsule for everything",
		"<link href='library/capsule/login/css/login.css' rel='stylesheet' type='text/css' />",
		"<script src='library/capsule/login/js/login.js' type='text/javascript'></script>"

        );
        
        $this->loginUsername = $username;
        
        $this->loginPassword = $password;
                        
    }
    
    /**
    * Set the database handler for CRUD operation
    *
    * @return this object
    */
    public function check() {
        
        $user = new select ('*,CAP_USER.FK_CAP_MAI_ID as FK_MAI_ID','CAP_USER LEFT JOIN CAP_USER_ROLE ON CAP_USER.CAP_USE_ROLE = CAP_USER_ROLE.CAP_USE_ROL_ID',
                            [
                             ['CAP_USE_USERNAME','=',$this->loginUsername],
                             ['CAP_USE_PASSWORD','=',hash('sha512',$this->loginPassword)],
                            ]);
        
        $user->execute();

        if (!empty($user->arrayResult)):
                        
            $data = $user->arrayResult;
            
            $user->column      = 'FK_CAP_USE_ROL_ID,CAP_USE_ROL_NAME';

            $user->tableName   = 'CAP_USER_ROLE_COMBINE LEFT JOIN CAP_USER_ROLE ON CAP_USER_ROLE_COMBINE.FK_CAP_USE_ROL_ID = CAP_USER_ROLE.CAP_USE_ROL_ID';

            $user->whereClause = [['FK_CAP_USE_ID','=',$user->arrayResult[0]['CAP_USE_ID']]];

            $user->execute();

            if (!empty($user->arrayResult)):

                foreach ($user->arrayResult as $value):

                    $role [] = $value['FK_CAP_USE_ROL_ID'];
                    
                    if (strtolower($value['CAP_USE_ROL_NAME']) == 'global administrator'): 
                    
                        $globalAdmin = $value['FK_CAP_USE_ROL_ID'];
                    
                    endif;

                endforeach;

            endif;

            $data[0]['CAP_USE_ROLE'] = (!empty($role)) ? $role : null;

        endif;
        
        $domain = $GLOBALS['_neyClass']['sites']->domain();
       
        if ($domain != $data[0]['FK_CAP_MAI_ID_LOCATION'] && in_array($globalAdmin, $data[0]['CAP_USE_ROLE'])):

            return $data;
        
        elseif ($domain != $data[0]['FK_CAP_MAI_ID_LOCATION'] && !in_array($globalAdmin, $data[0]['CAP_USE_ROLE'])):

            $data = null;
                        
            return $data;
            
        else:

            return $data;
        
        endif;
                
    }
    
}

?>
