<?php

namespace library\capsule\user\mvc;

use \framework\capsule;
use \framework\encryption;
use \framework\database\oracle\select;
use \framework\database\oracle\insert;
use \library\capsule\user\lib\log;
class model extends capsule {

protected $image;
protected $name;
protected $id;

    public function __construct () {
	
		parent::__construct(
	
		"Login Capsule",
		"Erwin + Aby",
		"This is Login capsule for everything",
		"<link href='library/capsule/user/css/user.css' rel='stylesheet' type='text/css' />",
		"<script src='library/capsule/user/js/user.js' type='text/javascript'></script>"

        );
                        
    }
    
    public function checkUser() {
    
    $user 	= unserialize($_SESSION['user']); $userName = $user->getID(); $loginType = $user->getLoginType();
    
    	if ($loginType == 'internal') {
    	$select = new select("*","CAP_USER LEFT JOIN CAP_USER_ROLE ON CAP_USER.CAP_USE_ROLE = CAP_USER_ROLE.CAP_USE_ROL_ID",[["CAP_USE_ID","=",$userName]],"","");
    	}
    	else {
    	$select = new select("*","CAP_USER LEFT JOIN CAP_USER_ROLE ON CAP_USER.CAP_USE_ROLE = CAP_USER_ROLE.CAP_USE_ROL_ID",[["CAP_USE_ID_FACEBOOK","=",$userName]],"","");
    	}
    
    $select->execute();
    return $select->arrayResult[0];
        
    }
    
    public function getRole($role){
	    $select = new select("*","CAP_USER_ROLE",[["CAP_USE_ROL_NAME","=",$role]],"","","2");$select->execute();
	    return $select->arrayResult;
    }
    
    public function integrasiData(){
    	/*$data['insert'] = new insert("","","");
	    $data['select'] = new select("CAP_USE_ID","cap_user",[["cap_use_datecreated",">","2012-11-24 06:06:00"]]);
	    $data['select'] ->execute();
	    $data['insert']->transactionStart();
	    $error=0;
	    $roleUser = [143,3];
	    foreach($data['select']->arrayResult as $key => $value){
   		    $lastIDU = $value['CAP_USE_ID'];
	   		foreach($roleUser as $keys => $values){
		   		$data['insert']->column = ["FK_CAP_USE_ID"=>$lastIDU,"FK_CAP_USE_ROL_ID"=>$values];
		    	$data['insert']->tableName = "CAP_USER_ROLE_COMBINE";
		    	$data['insert']->whereClause = "CAP_USE_ROL_COM_ID";
		    	$lastID = $data['insert']->execute();
		    	if(is_numeric($lastID)):
		    	
			    	log::setLog('all','role combine id no. '. $lastID . ' created',[__FILE__,__CLASS__,__FUNCTION__,__LINE__]);
		   		
		   		else:
		   		
		   			$error ++;

		   			log::setLog('all','role combine id failed to create, reason: ' . $lastID,[__FILE__,__CLASS__,__FUNCTION__,__LINE__]);
		  
		   		endif;
		   		
		   	}
		   	
	    }
    	
    	if($error != 0 ){
		    $data['insert']->transactionFailed();
		    return true;
	    }else{
		    $data['insert']->transactionSuccess();
		    
		    return false;
	    }
	        $handle = @fopen(ROOT_PATH."library/capsule/user/data/pegawai.sql", "r");
	    
	    if ($handle) {
	    		$referenceArray = [null];
			    while (($buffer = fgets($handle)) !== false) {
			    		
			         $exp = explode("\t",$buffer);
			         
			         $name = explode(" ",$exp[4],2);
			         $i = 0;
			         do{
				         $sites = strtolower(str_replace(" ","-",$exp[4]));
				         if($i > 0){
					         $sites .= $i;
				         }
				         $i++;
				         $valueArray = null;
				         $valueArray = array_search($sites,$referenceArray);
			         }while(!empty($valueArray));
			         
			         $newarray  [] = [
			         				'FIRSTNAME'=>trim($exp[3]." ".$name[0]),
			         				'LASTNAME'=>trim($name[1].", ".$exp[5]),
			         				'REALNAME'=>$exp[4],
			         				'EMAIL'=>$exp[22],
			         				'USERNAME'=>$exp[1],
			         				'PASSWORD'=>hash('sha512',$exp[1]),
			         				'SITES'=>$sites];
			         				
			        $referenceArray [] = $sites;
			    }
			    if (!feof($handle)) {
			        echo "Error: unexpected fgets() fail\n";
			    }

			    fclose($handle);
			}	
			
			//print_r($newarray);
			
			//$newarray = include(ROOT_PATH."library/capsule/user/data/array.php");
	    
	    $data['insert'] = new insert("","","");
	    $data['select'] = new select("","","");
	    $data['insert']->transactionStart();
	    $error = 0;
	    if(!empty($newarray)){
		    foreach($newarray as $key=>$value){
		    	$data['insert']->column = ['CAP_MAI_NAME' => $value['REALNAME'],"CAP_MAI_LANGUAGE"=>'id',"CAP_MAI_TEMPLATE"=>'locahost',"CAP_MAI_DOMAIN"=>$value['SITES'],"CAP_MAI_SITE_ACTIVE"=>1,'CAP_MAI_PARENT'=>21,'CAP_MAI_TYPE'=>'SUB DOMAIN',"CAP_MAI_DATECREATED"=>date('Y-m-d H:i:s')];
		    	$data['insert']->tableName = "CAP_MAIN";
		    	$data['insert']->whereClause = "CAP_MAI_ID";
		    	$data['insert']->dateColumn = ['CAP_MAI_DATECREATED'];
		    	$mainID = $data['insert']->execute();
		    	$query  = $data['insert']->query;
		    	if(is_numeric($mainID)):
		    	
			    	log::setLog('all','sites id no. '. $mainID . ' created',[__FILE__,__CLASS__,__FUNCTION__,__LINE__]);
		   		    
		  
		   		else:
		   			$error ++; 

		   			log::setLog('all','sites id failed to create, reason: ' . implode(',',$data['insert']->column),[__FILE__,__CLASS__,__FUNCTION__,__LINE__]);
		    
		   			
		  
		   		endif;
		   		
		    	$data['insert']->column = ["CAP_USE_FIRSTNAME" => $value['FIRSTNAME'],"CAP_USE_LASTNAME" => $value['LASTNAME'],"CAP_USE_EMAIL"=>$value['EMAIL'],"CAP_USE_USERNAME"=>$value['USERNAME'],"CAP_USE_PASSWORD"=>$value['PASSWORD'],"CAP_USE_STATUS"=>'Active',"CAP_USE_ROLE"=>143,"FK_CAP_MAI_ID"=>21,"FK_CAP_MAI_ID_LOCATION"=>$mainID,"CAP_USE_DATECREATED"=>date('Y-m-d H:i:s')];
		    	$data['insert']->tableName = "CAP_USER";
		    	$data['insert']->whereClause = "CAP_USE_ID";
		    	$data['insert']->dateColumn = ['CAP_USE_DATECREATED'];
		    	$lastID = $data['insert']->execute();
		    	if(is_numeric($lastID)):
		    	
			    	log::setLog('all','user id no. '. $lastID . ' created',[__FILE__,__CLASS__,__FUNCTION__,__LINE__]);
		   		    
		  
		   		else:
		   			$error ++; 

		   			log::setLog('all','user id failed to create, reason: ' . $lastID,[__FILE__,__CLASS__,__FUNCTION__,__LINE__]);
		    
		   			
		  
		   		endif;	    
		   		
		   		$roleUser = [143,3];
		   		foreach($roleUser as $keys => $values){
			   		$data['insert']->column = ["FK_CAP_USE_ID"=>$lastID,"FK_CAP_USE_ROL_ID"=>$values];
			    	$data['insert']->tableName = "CAP_USER_ROLE_COMBINE";
			    	$data['insert']->whereClause = "CAP_USE_ROL_COM_ID";
			    	$roleID = $data['insert']->execute();
			    	if(is_numeric($roleID)):
			    	
				    	log::setLog('all','role combine id no. '. $roleID . ' created',[__FILE__,__CLASS__,__FUNCTION__,__LINE__]);
			   		    
			  
			   		else:
			   			$error ++; 
	
			   			log::setLog('all','role combine id failed to create, reason: ' . $roleID,[__FILE__,__CLASS__,__FUNCTION__,__LINE__]);
			    
			   			
			  
			   		endif;
		   		}
			    
	
		    }
	    }
	    echo $error;
	    if($error != 0 ){
		    $data['insert']->transactionFailed();
		    return true;
	    }else{
		    $data['insert']->transactionSuccess();
		 
		    return false;
	    }
	    */
    }
    
}

?>