<?php

/**
 * Router Class
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@asacreative.com so we can send you a copy immediately.
 *
 * @category   Framework
 * @package    Singleton
 * @copyright  Copyright (c) 2012 Asacreative Technology Indonesia (http://www.asacreative.com)
 * @license    New BSD License
 * @version    $Id: router.class.php 100 Ridwan Abadi $
 * @since      Router 0.1
 */

namespace framework\pattern\_singleton;

class router {

use \framework\pattern\singleton;

/**
* 
* @var boolean
* 
*/
private $folder = false; 

/**
* 
* @var array
* 
*/
private $type = ['public','administrator','admin']; 


/**
* 
* @var integer
* 
*/
private $id = null;

/**
* 
* @var string
* 
*/
private $path = null;
    
    
    /**
    * Set the database handler for CRUD operation
    *
    * @return this object
    */
    public function __construct() {
        
        $sub_folder = APP;
        
        $this->path = explode('/',$_SERVER['REQUEST_URI']);
        
        $this->folder = (empty($sub_folder)) ? true : false;

        foreach ($this->type as $value):
            
            if (!is_array($_SESSION['__neyKa_router_type'])) : $_SESSION['__neyKa_router_type'] = []; endif;
            
            if (!in_array($value, $_SESSION['__neyKa_router_type'])):
            
            $_SESSION['__neyKa_router_type'][] = $value;
            
            endif;
        
        endforeach;
                
    }
    
    /**
    * Set the database handler for CRUD operation
    *
    * @return this object
    */
    public static function init() {

	   return self::getInstance();
	    		            	    	    
    }
    
    /**
    * Set the database handler for CRUD operation
    *
    * @return this object
    */
    public function register($type) {
       
       $type = strtolower(str_replace(' ', '-', $type));
       
       if (!in_array($type, $_SESSION['__neyKa_router_type'])):
           
           $array = $_SESSION['__neyKa_router_type'];
           
           end($array);
    
           $key = key($array)+1;
           
           $_SESSION['__neyKa_router_type'][$key] = $type;

        return $type;
           
       endif;

    return false;
       	    		            	    	    
    }
    
    /**
    * Set the database handler for CRUD operation
    *
    * @return this object
    */
    public function determinator() {
        
        $type = self::getType();
        
        if ($type == 'administrator' || $_GET['id'] == 'admin'):
        
            $this->id = $this->routeAdmin();
                
        elseif ($_GET['id'] == 'role'):
        
            $this->id = $this->routeRole();
            
        elseif ($_GET['id'] == 'logout'):
        
            $this->id = $this->routeLogout();
            
        else:

            $this->id = $this->routeID();

        endif;

    return $this->id;

    }
    
    /**
    * Set the database handler for CRUD operation
    *
    * @return this object
    */
    public function getPath() {

        return $this->path;

    }
    
     /**
    * Set the database handler for CRUD operation
    *
    * @return this object
    */
    public function getID() {

        return $this->routeID();

    }
    
    /**
    * Set the database handler for CRUD operation
    *
    * @return this object
    */
    public function getType() {
            
        $array = $_SESSION['__neyKa_router_type']; 
        
        $path = array_values(array_filter($this->path));
        
        $app   = APP;
        //print_r($path);
        if (!empty($app)):
            
            $key = array_search($path[1], $array,true);

            if (@array_key_exists($key, $array)):
            
            $type = $array[$key];
            
            endif;
                    
        else:
        
            $key = array_search($path[0], $array,true);

            if (@array_key_exists($key, $array)):
            
            $type = $array[$key];
            
            endif;
                              
        endif;
    
        return $type;

    }
        
    /**
    * Set the database handler for CRUD operation
    *
    * @return this object
    */
    public function routeID() {
                
        foreach ($_SESSION['__neyKa_router_type'] as $value):
        
            if ($key = array_search($value, $this->path)): $id = $this->path[$key+1]; break; endif;
        
        endforeach;
            
        return $id;

    }
    
    /**
    * Set the database handler for CRUD operation
    *
    * @return this object
    */
    public function routeAdmin() {
        
        return 'admin';

    }
    
    /**
    * Set the database handler for CRUD operation
    *
    * @return this object
    */
    public function routeRole() {
        
        return 'role';

    }
    
    /**
    * Set the database handler for CRUD operation
    *
    * @return this object
    */
    public function routeLogout() {
        
        return 'logout';

    }
    
    /**
    * Set the database handler for CRUD operation
    *
    * @return this object
    */
    public function builder($id,$name = null,$ajax = false) {
        
        if (!$ajax):
        
            return APP . self::getType() . '/' . $id . '/' . $name;
        
        else:
        
            return APP . strtolower(str_replace(' ','-',$_SESSION['roleName'])) . '/' . $id . '/' . $name;
        
        endif;

    }
    
}

?>