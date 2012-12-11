<?php

namespace library\capsule\layan\crontab\jobStatus;

use \DateTime;
use \Imagick;
use \framework\user;
use \framework\file;
use \framework\time;
use \framework\database\oracle\select;
use \framework\database\oracle\insert;
use \framework\database\oracle\delete;
use \framework\database\oracle\update;
use \library\capsule\layan\mvc\model;

class jobStatusLogic {

	public static function execute() {
				
		$select = new select("*","CAP_LAYAN WHERE CAP_LAY_FINALSTATUS = 3","","","");
		
		$pemberitahuan = new select("*","","","","");
		
		$penolakan = new select("*","","","","");
		
		$perpanjangan = new select("*","","","","");
		
		$select->selectSingleTable();

			if (!empty($select->arrayResult)) {
			
			$pemberitahuan = new select("*","","","","");
			
			$update = new update(array("CAP_LAY_FINALSTATUS" => 5),"CAP_LAYAN","CAP_LAY_ID","","");
			
			$model = new model();
		
				foreach ($select->arrayResult as $key => $value) {
					
					$i = 0;
									
					$timeKeberatan  = $model->getTimeByTable('CAP_LAY_DATECREATED',"CAP_LAYAN WHERE CAP_LAY_ID = '".$value['CAP_LAY_ID']."'");
							
					$daysKeberatan  = $model->getCurrentTimeOverviewStyle(date("Y-m-d",strtotime($timeKeberatan['DATETIME'])),date("Y-m-d H:i:s"));
					
						if ($daysKeberatan < 30) {
														
							$i++;
							
						}
					
					$pemberitahuan->tableName = "CAP_LAYAN_PEMBERITAHUAN WHERE FK_CAP_LAY_ID = ".$value['CAP_LAY_ID'];
					
					$pemberitahuan->selectSingleTable();
					
					if (!empty($pemberitahuan->arrayResult)) {
					
						foreach ($pemberitahuan->arrayResult as $keyPem => $valuePem) {
							
							$timeKeberatan  = $model->getTimeByTable('CAP_LAY_PEM_DATECREATED',"CAP_LAYAN_PEMBERITAHUAN WHERE CAP_LAY_PEM_ID = '".$valuePem['CAP_LAY_PEM_ID']."'");
							
							$daysKeberatan  = $model->getCurrentTimeOverviewStyle(date("Y-m-d",strtotime($timeKeberatan['DATETIME'])),date("Y-m-d H:i:s"));
							
							if ($daysKeberatan < 30) {
														
							$i++;
								
							}
							
						}
					
					}
					
					$penolakan->tableName = "CAP_LAYAN_PENOLAKAN WHERE FK_CAP_LAY_ID = ".$value['CAP_LAY_ID'];
					
					$penolakan->selectSingleTable();
					
					if (!empty($penolakan->arrayResult)) {
					
						foreach ($penolakan->arrayResult as $keyPen => $valuePen) {
							
							$timeKeberatan  = $model->getTimeByTable('CAP_LAY_PEN_DATECREATED',"CAP_LAYAN_PENOLAKAN WHERE CAP_LAY_PEN_ID = '".$valuePen['CAP_LAY_PEN_ID']."'");
							
							$daysKeberatan  = $model->getCurrentTimeOverviewStyle(date("Y-m-d",strtotime($timeKeberatan['DATETIME'])),date("Y-m-d H:i:s"));
							
							if ($daysKeberatan < 30) {
								
							$i++;
								
							}
							
						}
					
					}
					
					$perpanjangan->tableName = "CAP_LAYAN_PERPANJANGAN WHERE FK_CAP_LAY_ID = ".$value['CAP_LAY_ID'];
					
					$perpanjangan->selectSingleTable();
					
					if (!empty($perpanjangan->arrayResult)) {
					
						foreach ($perpanjangan->arrayResult as $keyPer => $valuePer) {
							
							$timeKeberatan  = $model->getTimeByTable('CAP_LAY_PER_DATECREATED',"CAP_LAYAN_PERPANJANGAN WHERE CAP_LAY_PER_ID = '".$valuePer['CAP_LAY_PEN_ID']."'");
							
							$daysKeberatan  = $model->getCurrentTimeOverviewStyle(date("Y-m-d",strtotime($timeKeberatan['DATETIME'])),date("Y-m-d H:i:s"));
							
							if ($daysKeberatan < 30) {
								
							$i++;
								
							}
							
						}
					
					}
					
					echo "Before i = ".$i."\n";
					
					if ($i == 0) {
					
						$update->whereID = $value['CAP_LAY_ID'];
						
						$update->updateMultipleRowWhereID();
					
					}
					
					$i = 0;
										
				}
				
				
			}
		
	}

}

?>