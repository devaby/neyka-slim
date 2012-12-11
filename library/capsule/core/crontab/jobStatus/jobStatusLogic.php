<?php

namespace library\capsule\core\crontab\jobStatus;

use \DateTime;
use \Imagick;
use \framework\user;
use \framework\file;
use \framework\time;
use \framework\database\oracle\select;
use \framework\database\oracle\insert;
use \framework\database\oracle\delete;
use \framework\database\oracle\update;
use \library\capsule\core\mvc\model;

class jobStatusLogic {
	
	public static function execute() {
		
		$select = new select("*","CAP_LANGUAGE_COMBINE WHERE CAP_LAN_COM_TIME <= TO_DATE('".date('Y-m-d')." 00:00:00','YYYY-MM-DD HH24:MI:SS') AND CAP_LAN_COM_TIME IS NOT NULL","","","");
		
		$select -> selectSingleTable();
		
		$result = $select -> arrayResult;
						
		if(!empty($result)){
		
		$update = new update("","","","","");
		
			foreach($result as $key => $value){
				
				$update -> column = array("CAP_LAN_COM_PUBLISH" => 0, "CAP_LAN_COM_TIME" => NULL);
				
				$update -> tableName = "CAP_LANGUAGE_COMBINE";
				
				$update -> whereClause = "CAP_LAN_COM_ID";
				
				$update -> whereID = $value['CAP_LAN_COM_ID'];
				
				$status = $update -> updateMultipleRowWhereID();
				
				if($status){
					$log = "DOKUMEN :".$value['CAP_LAN_COM_ID']."\n";
				}
				
			}
			
			echo $log;
		}
		
		
	}
}


?>