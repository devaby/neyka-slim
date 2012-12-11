<?php

namespace library\capsule\layan\mvc;

use \DateTime;
use \Imagick;
use \framework\capsule;
use \framework\user;
use \framework\file;
use \framework\time;
use \framework\validation;
use \framework\database\oracle\select;
use \framework\database\oracle\insert;
use \framework\database\oracle\delete;
use \framework\database\oracle\update;
use \library\capsule\coresystem\mvc\model as coresystem;

class model extends capsule {

protected $data;
public $configuration = array (

						"jam buka" => "09:00",
						"jam tutup" => "15:00",
						"jam istirahat senin kamis" => "12:00/13:00",
						"jam istirahat jumat" => "11:00/13:00"
						
						);
public $filter = true;

	public function __construct () {
	
		parent::__construct(
		
		"Register",
		"Media Instrument, Inc Team",
		"This is the language capsule",
		"<link href='library/capsule/share/css/share.css' rel='stylesheet' type='text/css'/>",
		"<script src='library/capsule/share/js/share.js' type='text/javascript'></script>"
	
		);

	}
	
	public function getBrand() {
		
		$select = new select("*","CAP_LAYAN_BRANDING",array(array("CAP_LAY_BRA_ID","=","1")),"","");
		
		$select->execute();
		
		return $select->arrayResult;
		
	}
	
	public function saveGeneralSetting($id,$file) {
	
	//print_r($file);
			
	$select = new select("*","CAP_LAYAN_BRANDING",array(array("CAP_LAY_BRA_ID","=",1)),"","");
		
	$select->execute();
		
	$update = new update("","CAP_LAYAN_BRANDING",array(array("CAP_LAY_BRA_ID","=",1)),"","");
		
	$insert = new insert("","CAP_LAYAN_BRANDING","CAP_LAY_BRA_ID","","");
		
		if (!empty($select->arrayResult)) {
				
			$ext = pathinfo($_SESSION['LAYAN-FILES'], PATHINFO_EXTENSION);

			if (!empty($ext) && $ext != 'jpg' && $ext != 'png') {

				if (is_file(ROOT_PATH.'library/capsule/layan/images/temp/'.$_SESSION['LAYAN-FILES'])) {
					unlink(ROOT_PATH.'library/capsule/layan/images/temp/'.$_SESSION['LAYAN-FILES']);
				}
			
				echo 'Invalid File Extension';

				return false;

			}

			if  (!empty($_SESSION['LAYAN-FILES'])) {
						
				if (is_file(ROOT_PATH.'library/capsule/layan/images/temp/'.$_SESSION['LAYAN-FILES'])) {
				
					if (copy(ROOT_PATH.'library/capsule/layan/images/temp/'.$_SESSION['LAYAN-FILES'],ROOT_PATH.'library/capsule/layan/images/logo/'.$_SESSION['LAYAN-FILES'])) {
					
						unlink(ROOT_PATH.'library/capsule/layan/images/temp/'.$_SESSION['LAYAN-FILES']);
						  
						$array = array(
						"CAP_LAY_BRA_LOGO" 		=> 'library/capsule/layan/images/logo/'.$_SESSION['LAYAN-FILES'],
						"CAP_LAY_BRA_NAME" 		=> $id['nama-organisasi'],
						"CAP_LAY_BRA_ADDRESS" 	=> $id['alamat'],
						"CAP_LAY_BRA_TELEPHONE" => $id['telepon'],
						"CAP_LAY_BRA_FAX" 		=> $id['fax'],
						"CAP_LAY_BRA_EMAIL" 	=> $id['email'],
						"CAP_LAY_BRA_WEBSITE" 	=> $id['website'],
						"CAP_LAY_BRA_TAGLINE1" 	=> $id['tagline-1'],
						"CAP_LAY_BRA_TAGLINE2" 	=> $id['tagline-2'],
						"CAP_LAY_BRA_TAGLINE3" 	=> $id['tagline-3']
						);
						
						$update->column = $array;

						$status = $update->execute();

						if (!$status) {

							echo "Error processing data";

							return false;
								
						}
					  
					}
				
				}
				else {
					
					echo "Error processing upload data";

					return false;
					
				}

			}
			else {

				$array = array(
				"CAP_LAY_BRA_NAME" 		=> $id['nama-organisasi'],
				"CAP_LAY_BRA_ADDRESS" 	=> $id['alamat'],
				"CAP_LAY_BRA_TELEPHONE" => $id['telepon'],
				"CAP_LAY_BRA_FAX" 		=> $id['fax'],
				"CAP_LAY_BRA_EMAIL" 	=> $id['email'],
				"CAP_LAY_BRA_WEBSITE" 	=> $id['website'],
				"CAP_LAY_BRA_TAGLINE1" 	=> $id['tagline-1'],
				"CAP_LAY_BRA_TAGLINE2" 	=> $id['tagline-2'],
				"CAP_LAY_BRA_TAGLINE3" 	=> $id['tagline-3']
				);
						
				$update->column = $array;
				
				$status = $update->execute();
						
				if (!$status) {
								
					echo "Error processing data";

					return false;
								
				}

			}
							
		}
		else {

			$ext = pathinfo($_SESSION['LAYAN-FILES'], PATHINFO_EXTENSION);

			if (!empty($ext) && $ext != 'jpg' && $ext != 'png') {
			
				if (is_file(ROOT_PATH.'library/capsule/layan/images/temp/'.$_SESSION['LAYAN-FILES'])) {
					unlink(ROOT_PATH.'library/capsule/layan/images/temp/'.$_SESSION['LAYAN-FILES']);
				}
			
				echo 'Invalid File Extension';

				return false;

			}

			if  (!empty($_SESSION['LAYAN-FILES'])) {

				if (is_file(ROOT_PATH.'library/capsule/layan/images/temp/'.$_SESSION['LAYAN-FILES'])) {
				
					if (copy(ROOT_PATH.'library/capsule/layan/images/temp/'.$_SESSION['LAYAN-FILES'],ROOT_PATH.'library/capsule/layan/images/logo/'.$_SESSION['LAYAN-FILES'])) {
					
						unlink(ROOT_PATH.'library/capsule/layan/images/temp/'.$_SESSION['LAYAN-FILES']);
						  
						$array = array(
						"CAP_LAY_BRA_ID" 		=> 1,
						"CAP_LAY_BRA_LOGO" 		=> 'library/capsule/layan/images/logo/'.$_SESSION['LAYAN-FILES'],
						"CAP_LAY_BRA_NAME" 		=> $id['nama-organisasi'],
						"CAP_LAY_BRA_ADDRESS" 	=> $id['alamat'],
						"CAP_LAY_BRA_TELEPHONE" => $id['telepon'],
						"CAP_LAY_BRA_FAX" 		=> $id['fax'],
						"CAP_LAY_BRA_EMAIL" 	=> $id['email'],
						"CAP_LAY_BRA_WEBSITE" 	=> $id['website'],
						"CAP_LAY_BRA_TAGLINE1" 	=> $id['tagline-1'],
						"CAP_LAY_BRA_TAGLINE2" 	=> $id['tagline-2'],
						"CAP_LAY_BRA_TAGLINE3" 	=> $id['tagline-3']
						);
						
						$insert->column = $array;
						
						$insert->whereClause = "CAP_LAY_BRA_ID";
						
						$status = $insert->execute();
						
						if (!$status) {
								
							echo "Error processing data";

							return false;
								
						}
					  
					}
				
				}
				else {
					
					echo "Error processing upload data";

					return false;
					
				}

			}
			else {

				$array = array(
				"CAP_LAY_BRA_ID" 		=> 1,
				"CAP_LAY_BRA_NAME" 		=> $id['nama-organisasi'],
				"CAP_LAY_BRA_ADDRESS" 	=> $id['alamat'],
				"CAP_LAY_BRA_TELEPHONE" => $id['telepon'],
				"CAP_LAY_BRA_FAX" 		=> $id['fax'],
				"CAP_LAY_BRA_EMAIL" 	=> $id['email'],
				"CAP_LAY_BRA_WEBSITE" 	=> $id['website'],
				"CAP_LAY_BRA_TAGLINE1" 	=> $id['tagline-1'],
				"CAP_LAY_BRA_TAGLINE2" 	=> $id['tagline-2'],
				"CAP_LAY_BRA_TAGLINE3" 	=> $id['tagline-3']
				);
						
				$insert->column = $array;
				
				$insert->whereClause = "CAP_LAY_BRA_ID";
						
				$status = $insert->execute();
						
				if (!$status) {
								
					echo "Error processing data";

					return false;
								
				}

			}
				
		}

		if (!empty($id['history']) && $id['history'] == 1) {

			$brand = self::getBrand();

			$brand = $brand[0]['CAP_LAY_BRA_LOGO'];

			$array = array(
			"CAP_LAY_BRA_LOGO" 		=> $brand,
			"CAP_LAY_BRA_NAME" 		=> $id['nama-organisasi'],
			"CAP_LAY_BRA_ADDRESS" 	=> $id['alamat'],
			"CAP_LAY_BRA_TELEPHONE" => $id['telepon'],
			"CAP_LAY_BRA_FAX" 		=> $id['fax'],
			"CAP_LAY_BRA_EMAIL" 	=> $id['email'],
			"CAP_LAY_BRA_WEBSITE" 	=> $id['website'],
			"CAP_LAY_BRA_TAGLINE1" 	=> $id['tagline-1'],
			"CAP_LAY_BRA_TAGLINE2" 	=> $id['tagline-2'],
			"CAP_LAY_BRA_TAGLINE3" 	=> $id['tagline-3']
			);

			$update = new update($array,"CAP_LAYAN","","","");

			$status = $update->execute();
						
			if (!$status) {
								
				echo "Error processing data";

				return false;
								
			}

		}
	
	}
	
	public function timeToWorkValidation() {
			
		if (!$this->filter) {return true;}
		
		$todayDate = date("Y-m-d");
				
		$todayTime = date("Y-m-d H:i:s");
		
		$holidayDate = self::getHolidayDate($todayDate,date("Y-12-31"));		

			if (date("w") == 6) {
				$_SESSION['LAYAN-ERROR'] = "Hari ini adalah hari sabtu. Semua transaksi di pending hingga hari senin."; return false;
			}
			else if (date("w") == 0) {
				$_SESSION['LAYAN-ERROR'] = "Hari ini adalah hari minggu. Semua transaksi di pending hingga hari senin."; return false;
			}
			
			if (!empty($holidayDate)):
			
				foreach ($holidayDate as $key => $value):
	
					if ($todayDate == date("Y-m-d",strtotime($value['CAP_LAY_CAL_DATE']))):
						$_SESSION['LAYAN-ERROR'] = "Hari ini adalah hari libur ".$value['CAP_LAY_CAL_DESCRIPTION'].". Semua transaksi di pending."; return false;
					endif;
				
				endforeach;
			
			endif;
			
		return true;
		
	}
	
	public function getUserName() {
		
		$user 	= unserialize($_SESSION['user']); $userid = $user->getID(); $username = $user->getName();
		
		return $username;
		
	}
	
	public function getUserID() {
		
		$user 	= unserialize($_SESSION['user']); $userid = $user->getID();
		
		return $userid;
		
	}
	
	public function getIDTransaksi() {

	$select = new select("*","CAP_LAYAN_TEMPORARY_TABLE","","","CAP_LAY_TEM_TAB_DATE DESC"); $select->execute(); $date = $select->arrayResult[0]['CAP_LAY_TEM_TAB_DATE'];
	
	if (strtotime(date("Y-m-d")) > strtotime($date)) {$delete = new delete("","CAP_LAYAN_TEMPORARY_TABLE","","",""); $delete->deleteTable();}

		if (empty($_SESSION['layan-transaksiID'])) {
		$theDate = date("Y-m-d H:i:s");
		$select = new select("*","CAP_LAYAN_TEMPORARY_TABLE","","","CAP_LAY_TEM_TAB_ID DESC","1"); $select->execute();
		$lastID = $select->arrayResult[0]['CAP_LAY_TEM_TAB_ID']; if (empty($lastID)) {$lastID=1;} else {$lastID+=1;}
		
		$insert = new insert(
			array("CAP_LAY_TEM_TAB_ID"=>$lastID,"CAP_LAY_TEM_TAB_DATE"=>$theDate),
			"CAP_LAYAN_TEMPORARY_TABLE","","",""); 
			
		$insert->dateColumn = array('CAP_LAY_TEM_TAB_DATE'); 
		$insert->whereClause = "CAP_LAY_TEM_TAB_ID";
		$lastMaxID = $insert->execute();
		
		$_SESSION['layan-transaksiID'] = date("Ymd",strtotime($theDate)).$lastMaxID;
		}
		
	}
	
	public function preCheck($data) {
			
	$update = new update("","CAP_LAYAN","","","");
		
		foreach ($data as $key => $value) {
		
		$i = 0;
		
			if ($value['CAP_LAY_FINALSTATUS'] == 0) {
				
				$time  = $this->getTime($value['CAP_LAY_ID']);
		
				$dateTime = $this->getCurrentHolidayDateTime(date("Y-m-d"),date("Y-m-d",strtotime($value['CAP_LAY_DATECREATED'])));
		
				$dateTime2 =  strtotime ( '-'.$dateTime.' day' . date("Y-m-d H:i:s") );
		
				$date1 = new DateTime($time['DATETIME']);
				
				$date3 = date("Y-m-d H:i:s",$dateTime2);
		
				$date2 = new DateTime($date3);
				
				$interval = $date1->diff($date2);
						    
				$days = $interval->format('%d'); 
				
				if ($value['CAP_LAY_TIPEPEMOHON'] == 'PERORANGAN') {
				
					//if (!file_exists($value['CAP_LAY_FILE_PATH']."/1-FOTO/1-FOTO.jpg")) {
					//	$i++;
					//}
					if (!file_exists($value['CAP_LAY_FILE_PATH']."/2-KTP/2-KTP.jpg")) {
						$i++;
					}
					
				}
				else {

					//if (!file_exists($value['CAP_LAY_FILE_PATH']."/1-FOTO/1-FOTO.jpg")) {
					//	$i++;
					//}
					if (!file_exists($value['CAP_LAY_FILE_PATH']."/2-KTP/2-KTP.jpg")) {
						$i++;
					}
					if (!file_exists($value['CAP_LAY_FILE_PATH']."/3-AKTA/3-AKTA.jpg")) {
						$i++;
					}
					if (!file_exists($value['CAP_LAY_FILE_PATH']."/4-KUASA/4-KUASA.jpg")) {
						$i++;
					}
					//if (!file_exists($value['CAP_LAY_FILE_PATH']."/5-KTP-KUASA/5-KTP-KUASA.jpg")) {
					//	$i++;
					//}
					//if (!file_exists($value['CAP_LAY_FILE_PATH']."/6-NPWP/6-NPWP.jpg")) {
					//	$i++;
					//}
					
				}

				if ($days >= 3 && $i > 0 || $days >= 3 && $i == 0) {
					
					$update->column  = array("CAP_LAY_FINALSTATUS" => 2, "CAP_LAY_DATESTOPPED" => date("Y-m-d H:i:s"));
					
					$update->whereClause = array(array("CAP_LAY_ID","=",$value['CAP_LAY_ID']));
					
					$update->dateColumn = array("CAP_LAY_DATESTOPPED");
					
					$update->execute();
										
				}
				else if ($days <= 3 && $i == 0) {
					
					$update->column  = array("CAP_LAY_FINALSTATUS" => 1, "CAP_LAY_LAMPIRAN" => 1);
					
					$update->whereClause = array(array("CAP_LAY_ID","=",$value['CAP_LAY_ID']));
										
					$update->execute();
										
				}
				
			}
						
		}
				
	}

	public function setDelivered($data){

		if(!empty($data)){
			
			$select = new select("*","CAP_LAYAN",array(array("CAP_LAY_ID","=",$data)),"","");
			
			$select->execute();
			
				if ($select->arrayResult[0]['CAP_LAY_LAMPIRAN'] == 1) {
					$lastStatus = 3;
				}
				else {
					$lastStatus = 0;
				}
			
			$upd = array(
					"CAP_LAY_FINALSTATUS" => 3,
					"CAP_LAY_LAMPIRAN" => $lastStatus,
 					"CAP_LAY_DATESTOPPED" => date("Y-m-d H:i:s")
				);
			$update = new update($upd,"CAP_LAYAN",array(array("CAP_LAY_ID","=",$data)),"","");

			$update->dateColumn = array("CAP_LAY_DATESTOPPED");

			$update->execute();
			
		}else{

			echo "An error Occured";
			
		}

	}
	
	public function checkOrderNumber($data) {
				
		$select = new select("*","CAP_LAYAN_LIBRARY","","","");
		
		$i = 0;
		
		if (!empty($data)) {
		
			foreach ($data as $key => $value) {
				
				if (empty($value['id'])) {continue;}
				
				if (!is_numeric($value['id'])) {
				
					$condition [] = array("pages" => $value['id'], "fault" => "Nomor dokumen ".$value['id']." harus numeric antara 0-9");
					
					continue;
					
				}
				
				$select->whereClause = array(array("CAP_LAY_LIB_ID","=",$value['id']));
				
				$select->execute();
				
					if (empty($select->arrayResult)) {
						
						$condition [] = array("pages" => $value['id'], "fault" => "Tidak ada nomor order dokumen seperti ".$value['id']);
						
					}
				
			}
			
			if (empty($condition)) {
			
				echo json_encode(array("pages" => "all", "fault" => "pass"));
				
			}
			else {
			
				foreach ($condition as $value) {
					$errorAnnouncement .= "<li>- ".$value['fault']."</li>"; 
				}
				
				echo json_encode(array("pages" => "all", "fault" => $errorAnnouncement));
				
			}
		
		}
		else {
		
		echo json_encode(array("pages" => "all", "fault" => "pass"));
		
		}
		
	}
	
	public function insertPermohonan() {
			
	$user 	= unserialize($_SESSION['user']); $userid = $user->getID(); 
	
	//Validation Start ================================================================

		//Holiday checking
		if (empty($_SESSION['layan-transaksiID'])) {

			$selectDateOfHoliday = new select("*","","","","");

			$errorMessages [] = "ID transaksi tidak ada. Hubungi sistem administrator anda.";

		}

		//ID checking
		if (empty($_SESSION['layan-transaksiID'])) {

			$errorMessages [] = "ID transaksi tidak ada. Hubungi sistem administrator anda.";

		}
		//Name checking
		if (empty($this->data[0][0])) {

			$errorMessages [] = "Mohon isi nama pemohon";

		}
		//Job checking
		if (empty($this->data[0][1])) {

			$errorMessages [] = "Mohon isi pekerjaan pemohon";

		}
		//Requester type checking
		if (empty($this->data[0][2])) {

			$errorMessages [] = "Mohon pilih tipe pemohon";

		}
		//Corporate type checking
		if (strtoupper($this->data[0][3]) == 'BADAN HUKUM') {

			if (empty($this->data[0][3])) {

			$errorMessages [] = "Mohon isi nama badan";

			}

		}
		//KTP checking
		if (empty($this->data[0][4])) {

			$errorMessages [] = "Mohon isi nomor ktp pemohon";

		}
		//NPWP checking
		if (empty($this->data[0][5])) {

			//$errorMessages [] = "Mohon isi alamat pemohon";

		}
		//Address checking
		if (empty($this->data[0][6])) {

			$errorMessages [] = "Mohon isi alamat pemohon";

		}
		//Telepon checking
		if (empty($this->data[0][7])) {

			$errorMessages [] = "Mohon isi no telepon pemohon";

		}
		else if (preg_match('/[^0-9]/', $this->data[0][7])) {

			$errorMessages [] = "No telepon hanya boleh mengandung angka";

		}
		//Email checking
		$validate = new validation();

		if (empty($this->data[0][8])) {

			//if (!$validate->setData($this->data[0][8])->email($this->data[0][8], TRUE)) {

				$errorMessages [] = "Alamat email pemohon tidak valid";

			//}
		
		}
		//Information checking
		if (empty($this->data[0][9])) {

			$errorMessages [] = "Cara mendapatkan informasi tidak boleh kosong";

		}
		//Salinan checking
		if (empty($this->data[0][10])) {

			$errorMessages [] = "Cara mendapatkan salinan informasi tidak boleh kosong";

		}

		if (!empty($errorMessages)) {

			//Getting all the last input value to display on screen ====================

			foreach ($this->data[1] as $key => $value) {
			
				if (!empty($value[0])) {
			
					$dokumenList [] = array("nama-dokumen" => $value[0], "alasan" => $value[1]);
										
				}
								
			}

			$_SESSION['LAYAN-DATA'] = array(

			"nama" 		=> $this->data[0][0],
			"pekerjaan" => $this->data[0][1],
			"tipe" 		=> $this->data[0][2],
			"badan" 	=> $this->data[0][3],
			"ktp" 		=> $this->data[0][4],
			"npwp" 		=> $this->data[0][5],
			"alamat" 	=> $this->data[0][6],
			"telepon" 	=> $this->data[0][7],
			"email" 	=> $this->data[0][8],
			"informasi" => $this->data[0][9],
			"salinan" 	=> $this->data[0][10],
			"dokumen" 	=> $dokumenList

			);

			//==========================================================================

			$_SESSION['LAYAN-ERROR'] = $errorMessages;

			return array("response" => 0, "message" => "error data validation failed");

		}

	//Validation Stop ==================================================================
	
	$brand  = self::getBrand();
	
	$column = array(
			  "CAP_LAY_TRANSACTIONID" => $_SESSION['layan-transaksiID'],
			  "CAP_LAY_NAMA"		  => strtoupper($this->data[0][0]),
			  "CAP_LAY_PEKERJAAN"	  => strtoupper($this->data[0][1]),
			  "CAP_LAY_TIPEPEMOHON"	  => strtoupper($this->data[0][2]),
			  "CAP_LAY_NAMA_BADAN"	  => strtoupper($this->data[0][3]),
			  "CAP_LAY_KTP"		 	  => strtoupper($this->data[0][4]),
			  "CAP_LAY_NPWP"		  => strtoupper($this->data[0][5]),
			  "CAP_LAY_ALAMAT"		  => strtoupper($this->data[0][6]),
			  "CAP_LAY_TELEPON"		  => $this->data[0][7],
			  "CAP_LAY_EMAIL"		  => $this->data[0][8],
			  "CAP_LAY_INFORMASI"	  => strtoupper($this->data[0][9]),
			  "CAP_LAY_SALINAN"		  => strtoupper($this->data[0][10]),
			  "FK_CAP_USE_ID"	 	  => $userid,
			  "CAP_LAY_DATECREATED"	  => date("Y-m-d H:i:s"),
			  "CAP_LAY_BRA_LOGO" 	  => $brand[0]['CAP_LAY_BRA_LOGO'],
			  "CAP_LAY_BRA_NAME" 	  => $brand[0]['CAP_LAY_BRA_NAME'],
			  "CAP_LAY_BRA_ADDRESS"   => $brand[0]['CAP_LAY_BRA_ADDRESS'],
			  "CAP_LAY_BRA_TELEPHONE" => $brand[0]['CAP_LAY_BRA_TELEPHONE'],
			  "CAP_LAY_BRA_FAX" 	  => $brand[0]['CAP_LAY_BRA_FAX'],
			  "CAP_LAY_BRA_EMAIL" 	  => $brand[0]['CAP_LAY_BRA_EMAIL'],
			  "CAP_LAY_BRA_WEBSITE"   => $brand[0]['CAP_LAY_BRA_WEBSITE']
			  );
		
	$insert = new insert($column,"CAP_LAYAN","CAP_LAY_ID","",""); $insert->dateColumn = array('CAP_LAY_DATECREATED');
		
	$lastID = $insert->execute();

		if (is_numeric($lastID)):
		
		$insert->tableName	 = "CAP_LAYAN_DOCUMENT_REQUEST";
		
		$insert->whereClause = "CAP_LAY_DOC_REQ_ID";
		
			foreach ($this->data[1] as $key => $value):
			
				if (!empty($value[0])):
			
					$insert->column = array(
							  		  "CAP_LAY_DOC_REQ_DOCNAME" => $value[0],
							  		  "CAP_LAY_DOC_REQ_REASON"	=> $value[1],
							  		  "FK_CAP_LAY_ID"	 		=> $lastID
							  		  );
					
					$insert->execute();
					
				endif;
								
			endforeach;
		
		$folder = new file(ROOT_PATH."library/capsule/layan/data/".$_SESSION['layan-transaksiID']);

			if ($folder->checkFolderExistence() == 1 && $folder->createDirectory() == TRUE):

				$folder->setFile(ROOT_PATH."library/capsule/layan/data/".$_SESSION['layan-transaksiID']."/1-FOTO")->createDirectory();

				$folder->setFile(ROOT_PATH."library/capsule/layan/data/".$_SESSION['layan-transaksiID']."/2-KTP")->createDirectory();

				$folder->setFile(ROOT_PATH."library/capsule/layan/data/".$_SESSION['layan-transaksiID']."/3-AKTA")->createDirectory();

				$folder->setFile(ROOT_PATH."library/capsule/layan/data/".$_SESSION['layan-transaksiID']."/4-KUASA")->createDirectory();

				$folder->setFile(ROOT_PATH."library/capsule/layan/data/".$_SESSION['layan-transaksiID']."/5-KTP-KUASA")->createDirectory();

				$folder->setFile(ROOT_PATH."library/capsule/layan/data/".$_SESSION['layan-transaksiID']."/6-NPWP")->createDirectory();

				$update = new update(array("CAP_LAY_FILE_PATH" => ROOT_PATH."library/capsule/layan/data/".$_SESSION['layan-transaksiID']),"CAP_LAYAN",array(array("CAP_LAY_ID","=",$lastID)),"","");

				$status = $update->execute();

					if (!$status):

						$delete = new delete("","CAP_LAYAN","CAP_LAY_ID",$lastID,"");

						$delete->deleteRow();

						return array("response" => 0, "message" => "error update folder path failed");
					
					else:
						
						$this->log($lastID,"MENCIPTAKAN PERMOHONAN DENGAN TRANSAKSI NO. ".$_SESSION['layan-transaksiID']);

						$sessionID = $_SESSION['layan-transaksiID'];
						
						unset($_SESSION['layan-transaksiID']);
						
						return array("response" => 1, "message" => $lastID);

					endif;

			else:

				$delete = new delete("","CAP_LAYAN","CAP_LAY_ID",$lastID,"");

				$delete->deleteRow();

				return array("response" => 0, "message" => "error cannot create folder");

			endif;
				
		else:
			
		return array("response" => 0, "message" => "error cannot insert to table");
			
		endif;
			
	}
	
	public function updatePermohonan($data) {

		if (empty($data['id'])) {return false;}
		
		$selectPrime = new select("*","CAP_LAYAN",array(array("CAP_LAY_ID","=",$data['id'])),"","");

		$selectPrime->execute();

		$prime  = $selectPrime->arrayResult[0]['CAP_LAY_TRANSACTIONID'];

		$name   = $selectPrime->arrayResult[0]['CAP_LAY_NAMA'];
		$job 	= $selectPrime->arrayResult[0]['CAP_LAY_PEKERJAAN'];
		$type 	= $selectPrime->arrayResult[0]['CAP_LAY_TIPEPEMOHON'];
		$ktp 	= $selectPrime->arrayResult[0]['CAP_LAY_KTP'];
		$npwp 	= $selectPrime->arrayResult[0]['CAP_LAY_NPWP'];
		$add 	= $selectPrime->arrayResult[0]['CAP_LAY_ALAMAT'];
		$phone  = $selectPrime->arrayResult[0]['CAP_LAY_TELEPON'];
		$email  = $selectPrime->arrayResult[0]['CAP_LAY_EMAIL'];
		$inf 	= $selectPrime->arrayResult[0]['CAP_LAY_INFORMASI'];
		$sal 	= $selectPrime->arrayResult[0]['CAP_LAY_SALINAN'];
		$badan  = $selectPrime->arrayResult[0]['CAP_LAY_NAMA_BADAN'];
		$oriDa  = $selectPrime->arrayResult[0]['CAP_LAY_DATECREATED'];

		//Validation Start ================================================================

		//Primary checker for status
		if ($selectPrime->arrayResult[0]['CAP_LAY_FINALSTATUS'] == 2 || $selectPrime->arrayResult[0]['CAP_LAY_FINALSTATUS'] == 3 || $selectPrime->arrayResult[0]['CAP_LAY_FINALSTATUS'] == 5) {
			$errorMessages [] = "Permohonan sudah mencapai status final. Edit tidak diperbolehkan.";
		} 

		//Name checking

		if (empty($data['nama'])) {

			$errorMessages [] = "Mohon isi nama pemohon";

		}
		//Job checking
		if (empty($data['pekerjaan'])) {

			$errorMessages [] = "Mohon isi pekerjaan pemohon";

		}
		//Requester type checking
		if (empty($data['tipe_pemohon'])) {

			$errorMessages [] = "Mohon pilih tipe pemohon";

		}
		//KTP checking
		if (empty($data['ktp'])) {

			$errorMessages [] = "Mohon isi nomor KTP";

		}
		//Corporate type checking
		if (strtoupper($data['nama-badan']) == 'BADAN HUKUM') {

			if (empty($data['nama-badan'])) {

			$errorMessages [] = "Mohon isi nama badan";

			}

		}
		//Address checking
		if (empty($data['alamat'])) {

			$errorMessages [] = "Mohon isi alamat pemohon";

		}
		//Telepon checking
		if (empty($data['telepon'])) {

			$errorMessages [] = "Mohon isi no telepon pemohon";

		}
		else if (preg_match('/[^0-9]/', $data['telepon'])) {

			$errorMessages [] = "No telepon hanya boleh mengandung angka";

		}
		//Email checking
		$validate = new validation();

		if (empty($data['email'])) {

			//if (!$validate->setData($data['email'])->email($data['email'], TRUE)) {

				$errorMessages [] = "Alamat email pemohon tidak valid";

			//}
		
		}
		//Information checking
		if (empty($data['memperoleh'])) {

			$errorMessages [] = "Cara mendapatkan informasi tidak boleh kosong";

		}
		//Salinan checking
		if (empty($data['salinan'])) {

			$errorMessages [] = "Cara mendapatkan salinan informasi tidak boleh kosong";

		}
		
		
		/*==================================================================== Validation Start */

			if (!empty($data['tanggal-tanda-terima'])) {

				if (strtotime($data['tanggal-tanda-terima']) > strtotime($_SESSION['LAYAN-PERMOHONAN-MAX-DATE'])) {

					$errorMessages [] = "Tanggal tanggapan atas keberatan tidak boleh lebih dari tanggal ".date("d F, Y",strtotime($_SESSION['LAYAN-PERMOHONAN-MAX-DATE']));

				}
				else if (strtotime($data['tanggal-tanda-terima']) < strtotime(date("Y-m-d",strtotime($oriDa)))) {

					$errorMessages [] = "Tanggal tanggapan atas keberatan tidak boleh lebih kecil dari tanggal ".date("d F, Y",strtotime($oriDa));

				}

			}
			else {

				//$_SESSION['LAYAN-ERROR'][] = "Tanggal tanggapan atas keberatan tidak boleh kosong"; 

			}

			$weekDay = date('w', strtotime($data['tanggal-tanda-terima']));

				if ($weekDay == 0) {

					$errorMessages [] = "Tanggal tanggapan atas keberatan tidak boleh berada di hari minggu";

				}
				else if ($weekDay == 6) {

					$errorMessages [] = "Tanggal tanggapan atas keberatan tidak boleh berada di hari sabtu";

				}

			$selectHoliday = new select("*","CAP_LAYAN_CALENDAR",array(array("CAP_LAY_CAL_DATE","=",date("Y-m-d",strtotime($data['tanggal-tanda-terima'])))),"","");

			$selectHoliday->execute();

				if (!empty($selectHoliday->arrayResult)) {

					$errorMessages [] = "Tanggal tanggapan atas keberatan ada di hari libur ".ucwords(strtolower($selectHoliday->arrayResult[0]['CAP_LAY_CAL_DESCRIPTION']));

				}


		/*====================================================================================*/
		

		if (!empty($errorMessages)) {

			$_SESSION['LAYAN-ERROR'] = $errorMessages;

			return "error";

		}
		else {

			unset($_SESSION['LAYAN-PERMOHONAN-MAX-DATE']);

		}

		//Validation Stop ==================================================================

		if (!empty($data['layan-permohonan-dokumen-delete'])) {
		
		$data['layan-permohonan-dokumen-delete'] = substr($data['layan-permohonan-dokumen-delete'], 0, -1);
		
		$del    = explode(",",$data['layan-permohonan-dokumen-delete']);
		
		$delete = new delete("","CAP_LAYAN_DOCUMENT_REQUEST","CAP_LAY_DOC_REQ_ID","","");

		$select = new select("*","CAP_LAYAN_DOCUMENT_REQUEST","","","");
			
			foreach ($del as $key => $value) {
				
				$select->whereClause = array(array("CAP_LAY_DOC_REQ_ID","=",$value));

				$select->execute();

				$delete->whereID = $value;
				
				$delete->deleteRow();

				$this->log($data['id'],"MENGHAPUS INFORMASI PUBLIK BERJUDUL ".strtoupper($select->arrayResult[0]['CAP_LAY_DOC_REQ_DOCNAME']));
				
			}
			
		}
		
			if (!empty($data['tanggal-tanda-terima'])) {
				$dateTandaTerima = date("Y-m-d H:i:s",strtotime($data['tanggal-tanda-terima']));
			}
			else {
				unset($dateTandaTerima);
			}
		
		$layan  = array(
				  "CAP_LAY_NAMA" 		 => strtoupper($data['nama']), 
				  "CAP_LAY_PEKERJAAN" 	 => strtoupper($data['pekerjaan']), 
				  "CAP_LAY_TIPEPEMOHON"  => strtoupper($data['tipe_pemohon']),
				  "CAP_LAY_KTP" 		 => strtoupper($data['ktp']),
				  "CAP_LAY_NPWP" 		 => strtoupper($data['npwp']), 
				  "CAP_LAY_ALAMAT" 		 => strtoupper($data['alamat']), 
				  "CAP_LAY_TELEPON"	 	 => $data['telepon'],
				  "CAP_LAY_EMAIL" 		 => $data['email'],
				  "CAP_LAY_INFORMASI" 	 => strtoupper($data['memperoleh']),
				  "CAP_LAY_SALINAN" 	 => strtoupper($data['salinan']),
				  "CAP_LAY_NAMA_BADAN" 	 => strtoupper($data['nama-badan']),
				  "CAP_LAY_DATE_UPDATED" => date("Y-m-d H:i:s"),
				  "CAP_LAY_DATETANDAB" 	 => $dateTandaTerima
				  );
		
		$insert = new insert("","","","","");
		
		$update = new update($layan,"CAP_LAYAN",array(array("CAP_LAY_ID","=",$data['id'])),"","");
		
		$update->dateColumn = array('CAP_LAY_DATE_UPDATED','CAP_LAY_DATETANDAB');
		echo $update->query;
		$update->execute();
		
			//Data changes validation start from here
			if (strtoupper($name) != strtoupper($data['nama'])) {
				if (!empty($data['nama'])) {$data['nama'] = $data['nama'];} else {$data['nama'] = "KOSONG";}
				if (!empty($name))  {$name  = $selectPrime->arrayResult[0]['CAP_LAY_NAMA'];} else {$name = "KOSONG";}
				$this->log($data['id'],"MERUBAH NAMA PEMOHON DARI ".strtoupper($name)." MENJADI ".strtoupper($data['nama']));
			}
			if (strtoupper($job) != strtoupper($data['pekerjaan'])) {
				if (!empty($data['pekerjaan'])) {$data['pekerjaan'] = $data['pekerjaan'];} else {$data['pekerjaan'] = "KOSONG";}
				if (!empty($job))   {$job 	= $selectPrime->arrayResult[0]['CAP_LAY_PEKERJAAN'];} else {$job = "KOSONG";}
				$this->log($data['id'],"MERUBAH PEKERJAAN PEMOHON DARI ".strtoupper($job)." MENJADI ".strtoupper($data['pekerjaan']));
			}
			if (strtoupper($type) != strtoupper($data['tipe_pemohon'])) {
				if (!empty($data['tipe_pemohon'])) {$data['tipe_pemohon'] = $data['tipe_pemohon'];} else {$data['tipe_pemohon'] = "KOSONG";}
				if (!empty($type))  {$type 	= $selectPrime->arrayResult[0]['CAP_LAY_TIPEPEMOHON'];} else {$type = "KOSONG";}
				$this->log($data['id'],"MERUBAH TIPE PEMOHON DARI ".strtoupper($type)." MENJADI ".strtoupper($data['tipe_pemohon']));
			}
			if (strtoupper($ktp) != strtoupper($data['ktp'])) {
				if (!empty($data['ktp'])) {$data['ktp'] = $data['ktp'];} else {$data['ktp'] = "KOSONG";}
				if (!empty($ktp))   {$ktp 	= $selectPrime->arrayResult[0]['CAP_LAY_KTP'];} else {$ktp = "KOSONG";}
				$this->log($data['id'],"MERUBAH KTP PEMOHON DARI ".strtoupper($ktp)." MENJADI ".strtoupper($data['ktp']));
			}
			if (strtoupper($npwp) != strtoupper($data['npwp'])) {
				if (!empty($data['npwp'])) {$data['npwp'] = $data['npwp'];} else {$data['npwp'] = "KOSONG";}
				if (!empty($npwp))   {$npwp 	= $selectPrime->arrayResult[0]['CAP_LAY_NPWP'];} else {$npwp = "KOSONG";}
				$this->log($data['id'],"MERUBAH NPWP PEMOHON DARI ".strtoupper($npwp)." MENJADI ".strtoupper($data['npwp']));
			}
			if (strtoupper($add) != strtoupper($data['alamat'])) {
				if (!empty($data['alamat'])) {$data['alamat'] = $data['alamat'];} else {$data['alamat'] = "KOSONG";}
				if (!empty($add))   {$add 	= $selectPrime->arrayResult[0]['CAP_LAY_ALAMAT'];} else {$add = "KOSONG";}
				$this->log($data['id'],"MERUBAH ALAMAT PEMOHON DARI ".strtoupper($add)." MENJADI ".strtoupper($data['alamat']));
			}
			if (strtoupper($phone) != strtoupper($data['telepon'])) {
				if (!empty($data['telepon'])) {$data['telepon'] = $data['telepon'];} else {$data['telepon'] = "KOSONG";}
				if (!empty($phone)) {$phone = $selectPrime->arrayResult[0]['CAP_LAY_TELEPON'];} else {$phone = "KOSONG";}
				$this->log($data['id'],"MERUBAH TELEPON PEMOHON DARI ".$phone." MENJADI ".$data['telepon']);
			}
			if (strtoupper($email) != strtoupper($data['email'])) {
				if (!empty($data['email'])) {$data['email'] = $data['email'];} else {$data['email'] = "KOSONG";}
				if (!empty($email)) {$email = $selectPrime->arrayResult[0]['CAP_LAY_EMAIL'];} else {$email = "KOSONG";}
				$this->log($data['id'],"MERUBAH EMAIL PEMOHON DARI ".$email." MENJADI ".$data['email']);
			}
			if (strtoupper($inf) != strtoupper($data['memperoleh'])) {
				if (!empty($data['memperoleh'])) {$data['memperoleh'] = $data['memperoleh'];} else {$data['memperoleh'] = "KOSONG";}
				if (!empty($inf))   {$inf 	= $selectPrime->arrayResult[0]['CAP_LAY_INFORMASI'];} else {$inf = "KOSONG";}
				$this->log($data['id'],"MERUBAH CARA MEMPEROLEH INFORMASI PEMOHON DARI ".strtoupper($inf)." MENJADI ".strtoupper($data['memperoleh']));
			}
			if (strtoupper($sal) != strtoupper($data['salinan'])) {
				if (!empty($data['salinan'])) {$data['salinan'] = $data['salinan'];} else {$data['salinan'] = "KOSONG";}
				if (!empty($sal))   {$sal 	= $selectPrime->arrayResult[0]['CAP_LAY_SALINAN'];} else {$sal = "KOSONG";}
				$this->log($data['id'],"MERUBAH MEMPEROLEH SALINAN INFORMASI PUBLIK PEMOHON DARI ".strtoupper($sal)." MENJADI ".strtoupper($data['salinan']));
			}
			if (strtoupper($badan) != strtoupper($data['nama-badan'])) {
				if (!empty($data['nama-badan'])) {$data['nama-badan'] = $data['nama-badan'];} else {$data['nama-badan'] = "KOSONG";}
				if (!empty($badan)) {$badan = $selectPrime->arrayResult[0]['CAP_LAY_NAMA_BADAN'];} else {$badan = "KOSONG";}
				$this->log($data['id'],"MERUBAH NAMA BADAN PEMOHON DARI ".strtoupper($badan)." MENJADI ".strtoupper($data['nama-badan']));
			}

		$selectDocument = new select("*","CAP_LAYAN_DOCUMENT_REQUEST","","","");

		for ($i = 0, $c = count($data['idDokumen']); $i < $c; $i++) {
		
		$selectDocument->whereClause = array(array("CAP_LAY_DOC_REQ_ID","=",$data['idDokumen'][$i]));

		$selectDocument->execute();

		$documentName   = $selectDocument->arrayResult[0]['CAP_LAY_DOC_REQ_DOCNAME'];

		$documentReason = $selectDocument->arrayResult[0]['CAP_LAY_DOC_REQ_REASON'];

			if (!empty($data['idDokumen'][$i])) {
			
			$arrayDocuments 	 = array("CAP_LAY_DOC_REQ_DOCNAME" => $data['dokumen'][$i], "CAP_LAY_DOC_REQ_REASON" => $data['alasan'][$i]);
			
			$update->column      = $arrayDocuments;
			
			$update->tableName   = "CAP_LAYAN_DOCUMENT_REQUEST";
			
			$update->whereClause = array(array("CAP_LAY_DOC_REQ_ID","=",$data['idDokumen'][$i]));
						
			$update->execute();
			
				if (strtoupper($documentName) != strtoupper($data['dokumen'][$i])) {
				$this->log($data['id'],"MERUBAH NAMA INFORMASI PUBLIK PEMOHON DARI ".strtoupper($documentName)." MENJADI ".strtoupper($data['dokumen'][$i]));
				}
				if (strtoupper($documentReason) != strtoupper($data['alasan'][$i])) {
				$this->log($data['id'],"MERUBAH ALASAN INFORMASI PUBLIK PEMOHON DARI ".strtoupper($documentReason)." MENJADI ".strtoupper($data['alasan'][$i]));
				}

			}
			else {
			
			$arrayDocuments = array("CAP_LAY_DOC_REQ_DOCNAME" => $data['dokumen'][$i], "CAP_LAY_DOC_REQ_REASON" => $data['alasan'][$i], "FK_CAP_LAY_ID" => $data['id']);
			
			$insert->column      = $arrayDocuments;
			
			$insert->tableName   = "CAP_LAYAN_DOCUMENT_REQUEST";
			
			$insert->whereClause = "CAP_LAY_DOC_REQ_ID";
			
				if (!empty($data['dokumen'][$i])) {
						
					$insert->execute();

					$this->log($data['id'],"MEMASUKAN INFORMASI PUBLIK PERMOHONAN BARU BERNAMA ".strtoupper($data['dokumen'][$i])." DENGAN ALASAN ".strtoupper($data['alasan'][$i]));
					
				}
			
			}
			
		}
				
	}
	
	public function createPemberitahuan($data) {
				
		if (empty($data['id'])) {return false;}
		
		$user 	= unserialize($_SESSION['user']); $userid = $user->getID(); 
		
		end($data['id']);

		$y = key($data['id']);

		$select = new select("*","CAP_LAYAN_DOCUMENT_REQUEST LEFT JOIN CAP_LAYAN ON CAP_LAYAN_DOCUMENT_REQUEST.FK_CAP_LAY_ID = CAP_LAYAN.CAP_LAY_ID",array(array("CAP_LAY_DOC_REQ_ID","=",addslashes($data['id'][$y]))),"","");
		
		$select->execute();
		
		$permohonanID = $select->arrayResult[0]['CAP_LAY_ID'];
		
		$idNumber = $select->arrayResult[0]['CAP_LAY_TRANSACTIONID'];
		
		//Validation Start ================================================================
		
			if ($select->arrayResult[0]['CAP_LAY_FINALSTATUS'] == 2 || $select->arrayResult[0]['CAP_LAY_FINALSTATUS'] == 3 || $select->arrayResult[0]['CAP_LAY_FINALSTATUS'] == 5) {
				
				$condition [] = "Permohonan sudah mencapai status final. Edit tidak diperbolehkan.";
				
			}
		
		$select = new select("*","CAP_LAYAN_LIBRARY","","","");
		
		$i = 0;
		
			if (!empty($data)) {
		
			foreach ($data as $key => $value) {
				
				if (empty($value['id'])) {continue;}
				
				if (!is_numeric($value['id'])) {
				
					$condition [] = "Nomor dokumen ".$value['id']." harus numeric antara 0-9";
					
					continue;
					
				}
				
				$select->whereClause = array(array("CAP_LAY_LIB_ID","=",$value['id']));
				
				$select->execute();
				
					if (empty($select->arrayResult)) {
						
						$condition [] = "Tidak ada nomor order dokumen seperti ".$value['id'];
						
					}
				
			}
			
			if (!empty($condition)) {
			
			$_SESSION['LAYAN-ERROR'] = $condition;

			return "error";
			
			}

		}

	//Validation Stop ==================================================================
		
		$select = new select("COUNT(CAP_LAY_PEM_ID)","CAP_LAYAN_PEMBERITAHUAN",array(array("FK_CAP_LAY_ID","=",$permohonanID)),"","");
		
		$select->execute();
				
		$idNumber = $idNumber."/PEM/".$_SESSION['layan-transaksiID'];
		
		$pemberitahuan = array(
				  	     "CAP_LAY_PEM_NUMBER" 	   => $idNumber,
				  	     "FK_CAP_USE_ID" 	 	   => $userid,
				  	     "CAP_LAY_PEM_DATECREATED" => date("Y-m-d H:i:s"),
				  	     "FK_CAP_LAY_ID" 		   => $permohonanID
				  	     );
		
		$insert = new insert($pemberitahuan,"CAP_LAYAN_PEMBERITAHUAN","","","");
		
		$insert->dateColumn = array('CAP_LAY_PEM_DATECREATED');
		
		$insert->whereClause = "CAP_LAY_PEM_ID";
		
		$lastID = $insert->execute();
		
		$select = new select("*","CAP_LAYAN_DOCUMENT_REQUEST_TYP",array(array("CAP_LAY_DOC_REQ_TYP_NAME","=","PEMBERITAHUAN")),"","");
		
		$select->execute();
		
		$idType = $select->arrayResult[0]['CAP_LAY_DOC_REQ_TYP_ID'];
		
		$update = new update(array("FK_CAP_LAY_DOC_REQ_ID" => $idType),"CAP_LAYAN_DOCUMENT_REQUEST","CAP_LAY_DOC_REQ_ID","","");

		end($data['id']);

		$c = key($data['id']);

		$selectDocument = new select("*","CAP_LAYAN_DOCUMENT_REQUEST","","","");

		for ($i = 0; $i <= $c; $i++) {
		
		if (empty($data['id'][$i])) {continue;}
		
		$selectDocument->whereClause = array(array("CAP_LAY_DOC_REQ_ID","=",$data['id'][$i]));

		$selectDocument->execute();

			$insert->column = array(
						"FK_CAP_LAY_DOC_REQ_ID" => $data['id'][$i],
						"CAP_LAY_PEM_DOC_PPID" => $data['ppid'][$i],
						"CAP_LAY_PEM_DOC_LAIN" => $data['badan-publik-lain'][$i],
						"CAP_LAY_PEM_DOC_SOFT" => $data['softcopy'][$i],
						"CAP_LAY_PEM_DOC_HARD" => $data['hardcopy'][$i],
						"CAP_LAY_PEM_DOC_COST" => $data['harga'][$i],
						"CAP_LAY_PEM_DOC_LEMBAR" => $data['lembar'][$i],
						"CAP_LAY_PEM_DOC_KIRIM" => $data['pengiriman'][$i],
						"CAP_LAY_PEM_DOC_LAIN_LAIN" => $data['harga-lain-lain'][$i],
						"CAP_LAY_PEM_DOC_METODE" => $data['metode-penyampaian'][$i],
						"CAP_LAY_PEM_DOC_WAKTU" => $data['waktu-penyampaian'][$i],
						"CAP_LAY_PEM_DOC_KUASAI" => $data['belum-dikuasai'][$i],
						"CAP_LAY_PEM_DOC_DOKUMENTASI" => $data['belum-didokumentasi'][$i],
						"CAP_LAY_PEM_DOC_NOTES" => $data['notes'][$i],
						"FK_CAP_LAY_PEM_ID" => $lastID,
						"FK_CAP_LAY_LIB_ID" => $data['dokumen-order'][$i],
						"CAP_LAY_PEM_DOC_DATECREATED" => date("Y-m-d H:i:s")
						);
			
			$insert->dateColumn = array('CAP_LAY_PEM_DOC_DATECREATED');
		
			$insert->whereClause = "CAP_LAY_PEM_DOC_ID";
			
			$insert->tableName = "CAP_LAYAN_PEMBERITAHUAN_DOC";
		
			$theID = $insert->execute();
			
				if (!empty($theID) && is_numeric($theID)) {
				
				$documentArray [] = $selectDocument->arrayResult[0]['CAP_LAY_DOC_REQ_DOCNAME'];
				
				}
		
		}

		$i = 0;

		$c = count($documentArray);
		/*
		if (empty($documentArray)) {
			
			$delete = new delete("","CAP_LAYAN_PEMBERITAHUAN","CAP_LAY_PEM_ID",$lastID,"");
			
			$delete->deleteRow();
			
			return false;
			
		}
		*/
		if (!empty($documentArray)) {
		
			foreach ($documentArray as $key => $value) {
	
			$i++;
	
				if ($i == $c) {
	
					$documentLists .= strtoupper($value);
	
				}
				else {
	
					$documentLists .= strtoupper($value).", ";
	
				}
	
			}
		
		}
		else {
			
			$documentLists = "KOSONG";
			
		}

		if (!empty($lastID)) {

		$this->log($permohonanID,"MENCIPTAKAN PEMBERITAHUAN TERTULIS NO. ".$idNumber." DENGAN INFORMASI PUBLIK SEBAGAI BERIKUT: $documentLists");

		unset($_SESSION['layan-transaksiID']);

		}
		
	}

	public function createPerpanjangan($data) {
				
		if (empty($data['id'])) {return false;}

		$user 	= unserialize($_SESSION['user']); $userid = $user->getID(); 
		
		end($data['id']);

		$y = key($data['id']);

		$select = new select("*","CAP_LAYAN_DOCUMENT_REQUEST LEFT JOIN CAP_LAYAN ON CAP_LAYAN_DOCUMENT_REQUEST.FK_CAP_LAY_ID = CAP_LAYAN.CAP_LAY_ID",array(array("CAP_LAY_DOC_REQ_ID","=",addslashes($data['id'][$y]))),"","");
		
		$select->execute();
				
		$permohonanID = $select->arrayResult[0]['CAP_LAY_ID'];
		
		//Validation Start ================================================================
		
			if ($select->arrayResult[0]['CAP_LAY_FINALSTATUS'] == 2 || $select->arrayResult[0]['CAP_LAY_FINALSTATUS'] == 3 || $select->arrayResult[0]['CAP_LAY_FINALSTATUS'] == 5) {
				
				$errorMessages [] = "Permohonan sudah mencapai status final. Edit tidak diperbolehkan.";
				
			}
		
		$creationDate = $this->getPermohonanByID($permohonanID);

		$permohonanDate = date("Y-m-d",strtotime($creationDate[0]['CAP_LAY_DATECREATED']));

		$holidayDate = $this->getHolidayDate($permohonanDate,date("Y-12-31"));

		$endDate = $this->getEndDatePermohonan($permohonanDate,$holidayDate);

		$holidayArray = $this->getHolidayArrayNoWeekdays($holidayDate,$endDate);

		$IndonesianHoliday = $this->getIndonesianHolidayDatePicker($holidayDate,$endDate);

		$date1 = new DateTime($permohonanDate);
		
		$date3 = date("Y-m-d");
		
		$date2 = new DateTime($date3);
		
		$interval = $date1->diff($date2);
				    		    
		$days = $interval->format('%d'); 

		$maxDate = $this->getMaxDatePicker($permohonanDate,$holidayArray,$endDate,$days);

		$maxRealDate = $this->getMaxDatePickerDate($permohonanDate,$maxDate,$days);

			if (empty($data['tanggal-perpanjangan'])) {

				$errorMessages [] = "Tanggal perpanjangan tidak boleh kosong";

			}
			else {

				if (strtotime($data['tanggal-perpanjangan']) < strtotime($creationDate[0]['CAP_LAY_DATECREATED'])) {

					$errorMessages [] ="Tanggal perpanjangan tidak boleh lebih kecil dari tanggal ".date("d F Y",strtotime($creationDate[0]['CAP_LAY_DATECREATED']));

				}
				if (strtotime($maxRealDate) < strtotime(date("Y-m-d",strtotime($data['tanggal-perpanjangan'])))) {

					$errorMessages [] ="Tanggal perpanjangan tidak boleh lebih besar dari tanggal ".date("d F Y", strtotime($maxRealDate));

				}

			}

			$weekDay = date('w', strtotime($data['tanggal-perpanjangan']));

				if ($weekDay == 0) {

					$errorMessages [] = "Tanggal tanggapan atas keberatan tidak boleh berada di hari minggu";

				}
				else if ($weekDay == 6) {

					$errorMessages [] = "Tanggal tanggapan atas keberatan tidak boleh berada di hari sabtu";

				}
			$perpanjanganDate = date('Y-m-d',strtotime($data['tanggal-perpanjangan']));
			$selectHoliday = new select("*","CAP_LAYAN_CALENDAR",array(array("CAP_LAY_CAL_DATE","=",$perpanjanganDate)),"","");

			$selectHoliday->execute();

				if (!empty($selectHoliday->arrayResult)) {

					$errorMessages [] = "Tanggal tanggapan atas keberatan ada di hari libur ".ucwords(strtolower($selectHoliday->arrayResult[0]['CAP_LAY_CAL_DESCRIPTION']));

				}

			if (!empty($errorMessages)) {

				$_SESSION['LAYAN-ERROR'] = $errorMessages;

				return false;

			}

		//Validation Stop ==================================================================

		$idNumber = $select->arrayResult[0]['CAP_LAY_TRANSACTIONID'];
		
		$select = new select("COUNT(CAP_LAY_PER_ID)","CAP_LAYAN_PERPANJANGAN",array(array("FK_CAP_LAY_ID","=",$permohonanID)),"","");
		
		$select->execute();
				
		$idNumber = $idNumber."/PER/".$_SESSION['layan-transaksiID'];
		
		$perpanjangan = array(
				  	     "CAP_LAY_PER_NUMBER" 	   => $idNumber,
				  	     "FK_CAP_USE_ID" 	 	   => $userid,
				  	     "CAP_LAY_PER_DATECREATED" => date("Y-m-d H:i:s"),
				  	     "FK_CAP_LAY_ID" 		   => $permohonanID,
				  	     "CAP_LAY_PER_DATE_TO" 	   => date("Y-m-d 23:59:59",strtotime($data['tanggal-perpanjangan']))
				  	     );

		$insert = new insert($perpanjangan,"CAP_LAYAN_PERPANJANGAN","","","");
		
		$insert->dateColumn = array('CAP_LAY_PER_DATECREATED','CAP_LAY_PER_DATE_TO');
		
		$insert->whereClause = "CAP_LAY_PER_ID";
		
		$lastID = $insert->execute();
		
		$select = new select("*","CAP_LAYAN_DOCUMENT_REQUEST_TYP",array(array("CAP_LAY_DOC_REQ_TYP_NAME","=","PERPANJANGAN")),"","");
		
		$select->execute();
		
		$idType = $select->arrayResult[0]['CAP_LAY_DOC_REQ_TYP_ID'];
		
		$update = new update(array("FK_CAP_LAY_DOC_REQ_ID" => $idType),"CAP_LAYAN_DOCUMENT_REQUEST","CAP_LAY_DOC_REQ_ID","","");

		$selectDocument = new select("*","CAP_LAYAN_DOCUMENT_REQUEST","","","");

		for ($i = 0, $c = count($data['id']); $i < $c; $i++) {
				
		$selectDocument->whereClause = array(array("CAP_LAY_DOC_REQ_ID","=",$data['id'][$i]));

		$selectDocument->execute();

			$insert->column = array(
						"FK_CAP_LAY_DOC_REQ_ID" => $data['id'][$i],
						"CAP_LAY_PER_DOC_NOTES" => $data['notes'][$i],
						"FK_CAP_LAY_PER_ID" => $lastID,
						"CAP_LAY_PER_DOC_DATECREATED" => date("Y-m-d H:i:s")
						);
						
			$insert->dateColumn = array('CAP_LAY_PER_DOC_DATECREATED');
		
			$insert->whereClause = "CAP_LAY_PER_DOC_ID";
			
			$insert->tableName = "CAP_LAYAN_PERPANJANGAN_DOC";
		
			$theID = $insert->execute();
			
				if (!empty($theID) && is_numeric($theID)) {
				
				$documentArray [] = $selectDocument->arrayResult[0]['CAP_LAY_DOC_REQ_DOCNAME'];
				
				}
		
		}

		$i = 0;

		$c = count($documentArray);

		foreach ($documentArray as $key => $value) {

		$i++;

			if ($i == $c) {

				$documentLists .= strtoupper($value);

			}
			else {

				$documentLists .= strtoupper($value).", ";

			}

		}

		if (!empty($lastID)) {

		$this->log($permohonanID,"MENCIPTAKAN PERPANJANGAN NO. ".$idNumber." DENGAN INFORMASI PUBLIK SEBAGAI BERIKUT: $documentLists");

		unset($_SESSION['layan-transaksiID']);

		}

	}

	public function createPenolakan($data) {
				
		if (empty($data['id'])) {return false;}
		
		//print_r($data);
		
		//return false;
		
		$user = unserialize($_SESSION['user']); $userid = $user->getID(); 
		
		$data['id'] = array_values($data['id']);

		$data['pasal'] = array_values($data['pasal']);

		$data['undang-undang'] = array_values($data['undang-undang']);

		$data['uji-konsekuensi'] = array_values($data['uji-konsekuensi']);

		$data['notes'] = array_values($data['notes']);

		end($data['id']);

		$y = key($data['id']);

		$select = new select("*","CAP_LAYAN_DOCUMENT_REQUEST LEFT JOIN CAP_LAYAN ON CAP_LAYAN_DOCUMENT_REQUEST.FK_CAP_LAY_ID = CAP_LAYAN.CAP_LAY_ID",array(array("CAP_LAY_DOC_REQ_ID","=",addslashes($data['id'][$y]))),"","");
		
		$select->execute();
		
			if ($select->arrayResult[0]['CAP_LAY_FINALSTATUS'] == 2 || $select->arrayResult[0]['CAP_LAY_FINALSTATUS'] == 3 || $select->arrayResult[0]['CAP_LAY_FINALSTATUS'] == 5) {
				
				$errorMessages [] = "Permohonan sudah mencapai status final. Edit tidak diperbolehkan.";
				
			}
			
			if (!empty($errorMessages)) {

				$_SESSION['LAYAN-ERROR'] = $errorMessages;

				return false;

			}
				
		$permohonanID = $select->arrayResult[0]['CAP_LAY_ID'];
		
		$idNumber = $select->arrayResult[0]['CAP_LAY_TRANSACTIONID'];
		
		$select = new select("COUNT(CAP_LAY_PEN_ID)","CAP_LAYAN_PENOLAKAN",array(array("FK_CAP_LAY_ID","=",$permohonanID)),"","");
		
		$select->execute();
		
		$idNumber = $idNumber."/PEN/".$_SESSION['layan-transaksiID'];
		
		$perpanjangan = array(
				  	     "CAP_LAY_PEN_NUMBER" 	   => $idNumber,
				  	     "FK_CAP_USE_ID" 	 	   => $userid,
				  	     "CAP_LAY_PEN_DATECREATED" => date("Y-m-d H:i:s"),
				  	     "FK_CAP_LAY_ID" 		   => $permohonanID
				  	     );

		$insert = new insert($perpanjangan,"CAP_LAYAN_PENOLAKAN","","","");
		
		$insert->dateColumn = array('CAP_LAY_PEN_DATECREATED','CAP_LAY_PER_DATE_TO');
		
		$insert->whereClause = "CAP_LAY_PEN_ID";
		
		$lastID = $insert->execute();
		
		$select = new select("*","CAP_LAYAN_DOCUMENT_REQUEST_TYP",array(array("CAP_LAY_DOC_REQ_TYP_NAME","=","PENOLAKAN")),"","");
		
		$select->execute();
		
		$idType = $select->arrayResult[0]['CAP_LAY_DOC_REQ_TYP_ID'];
		
		$update = new update(array("FK_CAP_LAY_DOC_REQ_ID" => $idType),"CAP_LAYAN_DOCUMENT_REQUEST","CAP_LAY_DOC_REQ_ID","","");

		$selectDocument = new select("*","CAP_LAYAN_DOCUMENT_REQUEST","","","");

		for ($i = 0, $c = count($data['id']); $i < $c; $i++) {
		
		$selectDocument->whereClause = array(array("CAP_LAY_DOC_REQ_ID","=",$data['id'][$i]));

		$selectDocument->execute();

			$insert->column = array(
						"FK_CAP_LAY_DOC_REQ_ID" => $data['id'][$i],
						"CAP_LAY_PEN_DOC_NOTES" => $data['notes'][$i],
						"CAP_LAY_PEN_DOC_PSL" => $data['pasal'][$i],
						"CAP_LAY_PEN_DOC_UU" => $data['undang-undang'][$i],
						"CAP_LAY_PEN_DOC_UJI" => $data['uji-konsekuensi'][$i],
						"FK_CAP_LAY_PEN_ID" => $lastID,
						"CAP_LAY_PEN_DOC_DATECREATED" => date("Y-m-d H:i:s")
						);
						//print_r($insert->column);
			$insert->dateColumn = array('CAP_LAY_PEN_DOC_DATECREATED');
		
			$insert->whereClause = "CAP_LAY_PEN_DOC_ID";
			
			$insert->tableName = "CAP_LAYAN_PENOLAKAN_DOC";
		
			$theID = $insert->execute();
			
				if (!empty($theID) && is_numeric($theID)) {
				
				$documentArray [] = $selectDocument->arrayResult[0]['CAP_LAY_DOC_REQ_DOCNAME'];
				
				}
		
		}

		$i = 0;

		$c = count($documentArray);

		foreach ($documentArray as $key => $value) {

		$i++;

			if ($i == $c) {

				$documentLists .= strtoupper($value);

			}
			else {

				$documentLists .= strtoupper($value).", ";

			}

		}

		if (!empty($lastID)) {

		$this->log($permohonanID,"MENCIPTAKAN PENOLAKAN NO. ".$idNumber." DENGAN INFORMASI PUBLIK SEBAGAI BERIKUT: $documentLists");

		unset($_SESSION['layan-transaksiID']);

		}
		
	}

	public function createKeberatan($data) {
				
		if (empty($data['id'])) {return false;}

		$user = unserialize($_SESSION['user']); $userid = $user->getID(); 
		
		end($data['id']);

		$y = key($data['id']);
		
		$select = new select("*","CAP_LAYAN",array(array("CAP_LAY_TRANSACTIONID","=",base64_decode($data['permohonan-ID']))),"","");

		@$select->execute();
		
		/*==================================================================== Validation Start */
			
			if ($select->arrayResult[0]['CAP_LAY_FINALSTATUS'] == 5) {
				
				$_SESSION['LAYAN-ERROR'][] = "Permohonan sudah mencapai status final. Edit tidak diperbolehkan.";
				
			}
			
			if (!empty($data['tanggal-keberatan'])) {

				if (strtotime($data['tanggal-keberatan']) > strtotime($_SESSION['LAYAN-KEBERATAN-MAX-DATE'])) {

					$_SESSION['LAYAN-ERROR'][] = "Tanggal tanggapan atas keberatan tidak boleh lebih dari tanggal ".date("d F, Y",strtotime($_SESSION['LAYAN-KEBERATAN-MAX-DATE']));

				}
				else if (strtotime($data['tanggal-keberatan']) < strtotime(date("Y-m-d"))) {

					$_SESSION['LAYAN-ERROR'][] = "Tanggal tanggapan atas keberatan tidak boleh lebih kecil dari tanggal ".date("d F, Y");

				}

			}
			else {

				//$_SESSION['LAYAN-ERROR'][] = "Tanggal tanggapan atas keberatan tidak boleh kosong"; 

			}

			$weekDay = date('w', strtotime($data['tanggal-keberatan']));

				if ($weekDay == 0) {

					$_SESSION['LAYAN-ERROR'][] = "Tanggal tanggapan atas keberatan tidak boleh berada di hari minggu";

				}
				else if ($weekDay == 6) {

					$_SESSION['LAYAN-ERROR'][] = "Tanggal tanggapan atas keberatan tidak boleh berada di hari sabtu";

				}

			$selectHoliday = new select("*","CAP_LAYAN_CALENDAR",array(array("CAP_LAY_CAL_DATE","=",date("Y-m-d",strtotime($data['tanggal-keberatan'])))),"","");

			$selectHoliday->execute();

				if (!empty($selectHoliday->arrayResult)) {

					$_SESSION['LAYAN-ERROR'][] = "Tanggal tanggapan atas keberatan ada di hari libur ".ucwords(strtolower($selectHoliday->arrayResult[0]['CAP_LAY_CAL_DESCRIPTION']));

				}

			if (!empty($_SESSION['LAYAN-ERROR'])) {

				return false;

			}
			else {

				unset($_SESSION['LAYAN-KEBERATAN-MAX-DATE']);

			}



		/*====================================================================================*/


			if (!empty($select->arrayResult)) {

				$permohonanID = $select->arrayResult[0]['CAP_LAY_ID'];

				$idNumber = base64_decode($data['permohonan-ID'])."/KEB/".$_SESSION['layan-transaksiID'];
				
				if (!empty($data['tanggal-keberatan'])) {
					$keberatanDate = date("Y-m-d",strtotime($data['tanggal-keberatan']));
				}

				$keberatan = array(
						  	     "CAP_LAY_KEB_NUMBER" 	   => $idNumber,
						  	     "FK_CAP_USE_ID" 	 	   => $userid,
						  	     "CAP_LAY_KEB_DATECREATED" => date("Y-m-d H:i:s"),
						  	     "CAP_LAY_KEB_DATE_TO"	   => $keberatanDate,
						  	     "CAP_LAY_KEB_NAME"	   	   => $data['nama-kuasa'],
						  	     "CAP_LAY_KEB_ALAMAT"	   => $data['alamat-kuasa'],
						  	     "CAP_LAY_KEB_STATUS"	   => $data['penyelesaian-keberatan'],
						  	     "FK_CAP_LAY_ID" 		   => $permohonanID
						  	     );

				$insert = new insert($keberatan,"CAP_LAYAN_KEBERATAN","","","");
				
				$insert->dateColumn = array('CAP_LAY_KEB_DATECREATED','CAP_LAY_KEB_DATE_TO');
				
				$insert->whereClause = "CAP_LAY_KEB_ID";
				
				$lastID = $insert->execute();

				if (!empty($lastID) && is_numeric($lastID)) {
				
				//$updatePermohonan = new update(array("CAP_LAY_FINALSTATUS" => 5),"CAP_LAYAN","CAP_LAY_ID",$permohonanID,"");
									
				//$updatePermohonan->updateMultipleRowWhereID();

				$selectDocument = new select("*","","","","");

					for ($i = 0; $i <= $y; $i++) {
					
					unset($permohonan);
					unset($pemberitahuan);
					unset($penolakan);
					unset($perpanjangan);

					$type = preg_replace('/[^A-Za-z]/','',$data['id'][$i]);

					$real = preg_replace('/[^0-9]/','',$data['id'][$i]);

						if ($type == 'permohonan') {
							$permohonan = $real;
						}
						else if ($type == 'pemberitahuan') {
							$pemberitahuan = $real;
						}
						else if ($type == 'penolakan') {
							$penolakan = $real;
						}
						else if ($type == 'perpanjangan') {
							$perpanjangan = $real;
						}

						$insert->column = array(
									"FK_CAP_LAY_KEB_ID" 	=> $lastID,
									"CAP_LAY_KEB_DOC_A" 	=> $data['daftar-alasan'][$i][0],
									"CAP_LAY_KEB_DOC_B" 	=> $data['daftar-alasan'][$i][1],
									"CAP_LAY_KEB_DOC_C" 	=> $data['daftar-alasan'][$i][2],
									"CAP_LAY_KEB_DOC_D" 	=> $data['daftar-alasan'][$i][3],
									"CAP_LAY_KEB_DOC_E" 	=> $data['daftar-alasan'][$i][4],
									"CAP_LAY_KEB_DOC_F" 	=> $data['daftar-alasan'][$i][5],
									"CAP_LAY_KEB_DOC_G" 	=> $data['daftar-alasan'][$i][6],
									"CAP_LAY_KEB_DOC_NOTES" => $data['notes'][$i],
									"FK_CAP_LAY_ID" 		=> $permohonan,
									"FK_CAP_LAY_PEM_ID" 	=> $pemberitahuan,
									"FK_CAP_LAY_PEN_ID" 	=> $penolakan,
									"FK_CAP_LAY_PER_ID" 	=> $perpanjangan,
									"CAP_LAY_KEB_DOC_RESPONSE" 		=> $data['tanggapan'][$i],
									"CAP_LAY_KEB_DOC_RESPONSE_U" 	=> $data['respon-pemohon'][$i]
									);
																	
						$insert->tableName 	 = "CAP_LAYAN_KEBERATAN_DOC";

						$insert->whereClause = "CAP_LAY_KEB_DOC_ID";

						$insert->dateColumn  = array();
					
						$theID = $insert->execute();
						
							if (empty($theID) && !is_numeric($theID)) {
							
							$delete = new delete("","CAP_LAYAN_KEBERATAN","CAP_LAY_KEB_ID",$lastID,"");

							$delete->deleteRow();

							$true = false;

							break;
							
							}
							else {

								if ($type == 'permohonan') {
									$permohonan = $real;
									$selectDocument->tableName = "CAP_LAYAN";
									$selectDocument->whereClause = array(array("CAP_LAY_ID","=",$real));
									$selectDocument->execute();

									if (!empty($selectDocument->arrayResult)) {
										$documented = "PERMOHONAN NO. ".$selectDocument->arrayResult[0]['CAP_LAY_TRANSACTIONID'];
									}

								}
								else if ($type == 'pemberitahuan') {
									$pemberitahuan = $real;
									$selectDocument->tableName = "CAP_LAYAN_PEMBERITAHUAN";
									$selectDocument->whereClause = array(array("CAP_LAY_PEM_ID","=",$real));
									$selectDocument->execute();

									if (!empty($selectDocument->arrayResult)) {
										$documented = "PEMBERITAHUAN NO. ".$selectDocument->arrayResult[0]['CAP_LAY_PEM_NUMBER'];
									}
								}
								else if ($type == 'penolakan') {
									$penolakan = $real;
									$selectDocument->tableName = "CAP_LAYAN_PENOLAKAN WHERE CAP_LAY_PEN_ID = '$real'";
									$selectDocument->whereClause = array(array("CAP_LAY_PEN_ID","=",$real));
									$selectDocument->execute();

									if (!empty($selectDocument->arrayResult)) {
										$documented = "PENOLAKAN NO. ".$selectDocument->arrayResult[0]['CAP_LAY_PEN_NUMBER'];
									}
								}
								else if ($type == 'perpanjangan') {
									$perpanjangan = $real;
									$selectDocument->tableName = "CAP_LAYAN_PERPANJANGAN WHERE CAP_LAY_PER_ID = '$real'";
									$selectDocument->whereClause = array(array("CAP_LAY_PER_ID","=",$real));
									$selectDocument->execute();

									if (!empty($selectDocument->arrayResult)) {
										$documented = "PERPANJANGAN NO. ".$selectDocument->arrayResult[0]['CAP_LAY_PER_NUMBER'];
									}
								}

								$dokumenLists .= $documented.",";

							}
					
					}

					if (!empty($lastID) && !$true) {

					$dokumenLists = substr($dokumenLists, 0, -1);

					$this->log($permohonanID,"MENCIPTAKAN KEBERATAN NO. ".$idNumber." DENGAN DOKUMEN YANG DIBERATKAN SEBAGAI BERIKUT: $dokumenLists");

					unset($_SESSION['layan-transaksiID']);

					}

				}

			}
		
	}

	public function updatePemberitahuan($data) {

		if (empty($data['id'])) {return false;}

		$user 	= unserialize($_SESSION['user']); $userid = $user->getID(); 
		
		end($data['dokumen-id']);

		$u = key($data['dokumen-id']);

		$select = new select("*","CAP_LAYAN_PEMBERITAHUAN LEFT JOIN CAP_LAYAN ON CAP_LAYAN_PEMBERITAHUAN.FK_CAP_LAY_ID = CAP_LAYAN.CAP_LAY_ID",array(array("CAP_LAYAN_PEMBERITAHUAN.CAP_LAY_PEM_ID","=",addslashes($data['dokumen-id'][$u]))),"","");
		
		$select->execute();
				
			if ($select->arrayResult[0]['CAP_LAY_FINALSTATUS'] == 2 || $select->arrayResult[0]['CAP_LAY_FINALSTATUS'] == 3 || $select->arrayResult[0]['CAP_LAY_FINALSTATUS'] == 5) {
				
				$errorMessages [] = "Permohonan sudah mencapai status final. Edit tidak diperbolehkan.";
				
			}
			
			if (!empty($errorMessages)) {

			$_SESSION['LAYAN-ERROR'] = $errorMessages;

			return "error";
			
			}
		
		$permohonanID = $select->arrayResult[0]['CAP_LAY_ID'];
		
		$idNumber = $select->arrayResult[0]['CAP_LAY_TRANSACTIONID'];
		
		$select = new select("*","CAP_LAYAN_PEMBERITAHUAN",array(array("FK_CAP_LAY_ID","=",$permohonanID)),"","");
		
		$select->execute();
		
		$noPemberitahuan = $select->arrayResult[0]['CAP_LAY_PEM_NUMBER'];

		$insert = new insert("","","","","");

		$select = new select("*","CAP_LAYAN_DOCUMENT_REQUEST_TYP",array(array("CAP_LAY_DOC_REQ_TYP_NAME","=","PEMBERITAHUAN")),"","");
		
		$select->execute();
		
		$idType = $select->arrayResult[0]['CAP_LAY_DOC_REQ_TYP_ID'];
		
		$update = new update(array("FK_CAP_LAY_DOC_REQ_ID" => $idType),"CAP_LAYAN_DOCUMENT_REQUEST","","","");

		$selectDecide = new select("*","","","","");

		$selectDocument = new select("*","CAP_LAYAN_DOCUMENT_REQUEST","","","");

		end($data['id']);

		$c = key($data['id']);

		for ($i = 0; $i <= $c; $i++) {
		
		if (empty($data['id'][$i])) {continue;}
		
		$selectDecide->tableName = "CAP_LAYAN_PEMBERITAHUAN_DOC LEFT JOIN CAP_LAYAN_DOCUMENT_REQUEST ON CAP_LAYAN_PEMBERITAHUAN_DOC.FK_CAP_LAY_DOC_REQ_ID = CAP_LAYAN_DOCUMENT_REQUEST.CAP_LAY_DOC_REQ_ID";
		
		$selectDecide->whereClause = array(array("CAP_LAYAN_PEMBERITAHUAN_DOC.FK_CAP_LAY_DOC_REQ_ID","=",$data['id'][$i]));
		
		$selectDecide->execute();
		
		$selectDocument->whereClause = array(array("CAP_LAY_DOC_REQ_ID","=",$data['id'][$i]));

		$selectDocument->execute();

			if (empty($selectDecide->arrayResult)) {

			$insert->column = array(
						"FK_CAP_LAY_DOC_REQ_ID" => $data['id'][$i],
						"CAP_LAY_PEM_DOC_PPID" => $data['ppid'][$i],
						"CAP_LAY_PEM_DOC_LAIN" => $data['badan-publik-lain'][$i],
						"CAP_LAY_PEM_DOC_SOFT" => $data['softcopy'][$i],
						"CAP_LAY_PEM_DOC_HARD" => $data['hardcopy'][$i],
						"CAP_LAY_PEM_DOC_COST" => $data['harga'][$i],
						"CAP_LAY_PEM_DOC_LEMBAR" => $data['lembar'][$i],
						"CAP_LAY_PEM_DOC_KIRIM" => $data['pengiriman'][$i],
						"CAP_LAY_PEM_DOC_LAIN_LAIN" => $data['harga-lain-lain'][$i],
						"CAP_LAY_PEM_DOC_METODE" => $data['metode-penyampaian'][$i],
						"CAP_LAY_PEM_DOC_WAKTU" => $data['waktu-penyampaian'][$i],
						"CAP_LAY_PEM_DOC_KUASAI" => $data['belum-dikuasai'][$i],
						"CAP_LAY_PEM_DOC_DOKUMENTASI" => $data['belum-didokumentasi'][$i],
						"CAP_LAY_PEM_DOC_NOTES" => $data['notes'][$i],
						"FK_CAP_LAY_PEM_ID" => $data['dokumen-id'][$i],
						"FK_CAP_LAY_LIB_ID" => $data['dokumen-order'][$i],
						"CAP_LAY_PEM_DOC_DATECREATED" => date("Y-m-d H:i:s")
						);

			$insert->dateColumn = array('CAP_LAY_PEM_DOC_DATECREATED');
		
			$insert->whereClause = "CAP_LAY_PEM_DOC_ID";
			
			$insert->tableName = "CAP_LAYAN_PEMBERITAHUAN_DOC";
			
			$theID = $insert->execute();

				if (!empty($theID) && is_numeric($theID)) {

					$documentInsertArray [] = strtoupper($selectDocument->arrayResult[0]['CAP_LAY_DOC_REQ_DOCNAME']);

				}

			}
			else {

			$update->column = array(
						"CAP_LAY_PEM_DOC_PPID" => $data['ppid'][$i],
						"CAP_LAY_PEM_DOC_LAIN" => $data['badan-publik-lain'][$i],
						"CAP_LAY_PEM_DOC_SOFT" => $data['softcopy'][$i],
						"CAP_LAY_PEM_DOC_HARD" => $data['hardcopy'][$i],
						"CAP_LAY_PEM_DOC_COST" => $data['harga'][$i],
						"CAP_LAY_PEM_DOC_LEMBAR" => $data['lembar'][$i],
						"CAP_LAY_PEM_DOC_KIRIM" => $data['pengiriman'][$i],
						"CAP_LAY_PEM_DOC_LAIN_LAIN" => $data['harga-lain-lain'][$i],
						"CAP_LAY_PEM_DOC_METODE" => $data['metode-penyampaian'][$i],
						"CAP_LAY_PEM_DOC_WAKTU" => $data['waktu-penyampaian'][$i],
						"CAP_LAY_PEM_DOC_KUASAI" => $data['belum-dikuasai'][$i],
						"CAP_LAY_PEM_DOC_DOKUMENTASI" => $data['belum-didokumentasi'][$i],
						"CAP_LAY_PEM_DOC_NOTES" => $data['notes'][$i],
						"FK_CAP_LAY_LIB_ID" => $data['dokumen-order'][$i],
						"CAP_LAY_PEM_DOC_DATEUPDATED" => date("Y-m-d H:i:s")
						);

			$update->dateColumn = array('CAP_LAY_PEM_DOC_DATEUPDATED');
		
			$update->whereClause = array(array("FK_CAP_LAY_DOC_REQ_ID","=",$data['id'][$i]));
			
			$update->tableName = "CAP_LAYAN_PEMBERITAHUAN_DOC";
			
			$status = $update->execute();

				if ($status == 1) {

					//Data changes validation start from here
					if ($selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_PPID'] != $data['ppid'][$i]) {
						if (!empty($data['ppid'][$i])) {$ppid = "DIKUASAI DI PPID";} else {$ppid = "TIDAK DIKUASAI DI PPID";}
						$this->log($permohonanID,"MERUBAH STATUS INFORMASI PUBLIK ".strtoupper($selectDocument->arrayResult[0]['CAP_LAY_DOC_REQ_DOCNAME'])." MENJADI $ppid");
					}
					if ($selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_LAIN'] != $data['badan-publik-lain'][$i]) {
						if (!empty($data['badan-publik-lain'][$i])) {$data['badan-publik-lain'][$i] = "BERADA DI ".$data['badan-publik-lain'][$i];} else {$data['badan-publik-lain'][$i] = "TIDAK BERADA DI BADAN PUBLIK LAIN";}
						if (!empty($selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_LAIN']))  {$selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_LAIN'] = "BERADA DI ".$selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_LAIN'];} else {$selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_LAIN'] = "TIDAK BERADA DI BADAN PUBLIK LAIN";}
						$this->log($permohonanID,"MERUBAH INFORMASI PUBLIK ".strtoupper($selectDocument->arrayResult[0]['CAP_LAY_DOC_REQ_DOCNAME'])." DARI ".strtoupper($selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_LAIN'])." MENJADI ".strtoupper($data['badan-publik-lain'][$i]));
					}
					if ($selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_SOFT'] != $data['softcopy'][$i]) {
						if (!empty($data['softcopy'][$i])) {$ppid = "MEMILIKI SOFTCOPY";} else {$ppid = "TIDAK MEMILIKI SOFTCOPY";}
						$this->log($permohonanID,"MERUBAH STATUS INFORMASI PUBLIK ".strtoupper($selectDocument->arrayResult[0]['CAP_LAY_DOC_REQ_DOCNAME'])." MENJADI $ppid");
					}
					if ($selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_HARD'] != $data['hardcopy'][$i]) {
						if (!empty($data['hardcopy'][$i])) {$ppid = "MEMILIKI HARDCOPY";} else {$ppid = "TIDAK MEMILIKI HARDCOPY";}
						$this->log($permohonanID,"MERUBAH STATUS INFORMASI PUBLIK ".strtoupper($selectDocument->arrayResult[0]['CAP_LAY_DOC_REQ_DOCNAME'])." MENJADI $ppid");
					}
					if ($selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_COST'] != $data['harga'][$i]) {
						if (!empty($data['harga'][$i])) {$data['harga'][$i] = $data['harga'][$i];} else {$data['harga'][$i] = "0.00";}
						if (!empty($selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_COST']))  {$selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_COST'] = $selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_COST'];} else {$selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_COST'] = "0.00";}
						$this->log($permohonanID,"MERUBAH HARGA PER LEMBAR INFORMASI PUBLIK ".strtoupper($selectDocument->arrayResult[0]['CAP_LAY_DOC_REQ_DOCNAME'])." DARI ".number_format($selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_COST'],0)." MENJADI ".number_format($data['harga'][$i]));
					}
					if ($selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_LEMBAR'] != $data['lembar'][$i]) {
						if (!empty($data['lembar'][$i])) {$data['lembar'][$i] = $data['lembar'][$i];} else {$data['lembar'][$i] = "0";}
						if (!empty($selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_LEMBAR']))  {$selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_LEMBAR'] = $selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_LEMBAR'];} else {$selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_LEMBAR'] = "0";}
						$this->log($permohonanID,"MERUBAH CETAKAN INFORMASI PUBLIK ".strtoupper($selectDocument->arrayResult[0]['CAP_LAY_DOC_REQ_DOCNAME'])." DARI ".$selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_LEMBAR']." LEMBAR MENJADI ".$data['lembar'][$i]." LEMBAR");
					}
					if ($selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_KIRIM'] != $data['pengiriman'][$i]) {
						if (!empty($data['pengiriman'][$i])) {$data['pengiriman'][$i] = $data['pengiriman'][$i];} else {$data['pengiriman'][$i] = "0.00";}
						if (!empty($selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_KIRIM']))  {$selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_KIRIM'] = $selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_KIRIM'];} else {$selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_KIRIM'] = "0.00";}
						$this->log($permohonanID,"MERUBAH HARGA ONGKOS KIRIM INFORMASI PUBLIK ".strtoupper($selectDocument->arrayResult[0]['CAP_LAY_DOC_REQ_DOCNAME'])." DARI ".number_format($selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_KIRIM'],0)." MENJADI ".number_format($data['pengiriman'][$i]));
					}
					if ($selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_LAIN_LAIN'] != $data['harga-lain-lain'][$i]) {
						if (!empty($data['harga-lain-lain'][$i])) {$data['harga-lain-lain'][$i] = $data['harga-lain-lain'][$i];} else {$data['harga-lain-lain'][$i] = "0.00";}
						if (!empty($selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_LAIN_LAIN']))  {$selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_LAIN_LAIN'] = $selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_LAIN_LAIN'];} else {$selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_LAIN_LAIN'] = "0.00";}
						$this->log($permohonanID,"MERUBAH HARGA ONGKOS LAINNYA INFORMASI PUBLIK ".strtoupper($selectDocument->arrayResult[0]['CAP_LAY_DOC_REQ_DOCNAME'])." DARI ".number_format($selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_LAIN_LAIN'],0)." MENJADI ".number_format($data['harga-lain-lain'][$i]));
					}
					if ($selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_METODE'] != $data['metode-penyampaian'][$i]) {
						if (!empty($data['metode-penyampaian'][$i])) {$data['metode-penyampaian'][$i] = $data['metode-penyampaian'][$i];} else {$data['metode-penyampaian'][$i] = "KOSONG";}
						if (!empty($selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_METODE']))  {$selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_METODE'] = $selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_METODE'];} else {$selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_METODE'] = "KOSONG";}
						$this->log($permohonanID,"MERUBAH METODE PENYAMPAIAN INFORMASI PUBLIK ".strtoupper($selectDocument->arrayResult[0]['CAP_LAY_DOC_REQ_DOCNAME'])." DARI ".strtoupper($selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_METODE'])." MENJADI ".strtoupper($data['metode-penyampaian'][$i]));
					}
					if ($selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_WAKTU'] != $data['waktu-penyampaian'][$i]) {
						if (!empty($data['waktu-penyampaian'][$i])) {$data['waktu-penyampaian'][$i] = $data['waktu-penyampaian'][$i];} else {$data['waktu-penyampaian'][$i] = "KOSONG";}
						if (!empty($selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_WAKTU']))  {$selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_WAKTU'] = $selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_WAKTU'];} else {$selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_WAKTU'] = "KOSONG";}
						$this->log($permohonanID,"MERUBAH WAKTU PENYAMPAIAN INFORMASI PUBLIK ".strtoupper($selectDocument->arrayResult[0]['CAP_LAY_DOC_REQ_DOCNAME'])." DARI ".strtoupper($selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_WAKTU'])." MENJADI ".strtoupper($data['waktu-penyampaian'][$i]));
					}
					if ($selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_KUASAI'] != $data['belum-dikuasai'][$i]) {
						if (!empty($data['belum-dikuasai'][$i])) {$ppid = "SUDAH DIKUASAI";} else {$ppid = "BELUM DIKUASAI";}
						$this->log($permohonanID,"MERUBAH INFORMASI TIDAK DAPAT DIBERIKAN ATAS INFORMASI PUBLIK ".strtoupper($selectDocument->arrayResult[0]['CAP_LAY_DOC_REQ_DOCNAME'])." MENJADI $ppid");
					}
					if ($selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_DOKUMENTASI'] != $data['belum-didokumentasi'][$i]) {
						if (!empty($data['belum-didokumentasi'][$i])) {$ppid = "SUDAH DIDOKUMENTASI";} else {$ppid = "BELUM DIDOKUMENTASI";}
						$this->log($permohonanID,"MERUBAH INFORMASI TIDAK DAPAT DIBERIKAN ATAS INFORMASI PUBLIK ".strtoupper($selectDocument->arrayResult[0]['CAP_LAY_DOC_REQ_DOCNAME'])." MENJADI $ppid");
					}
					if ($selectDecide->arrayResult[0]['FK_CAP_LAY_LIB_ID'] != $data['dokumen-order'][$i]) {
						if (!empty($data['dokumen-order'][$i])) {$ppid = $data['dokumen-order'][$i];} else {$ppid = "KOSONG";}
						$this->log($permohonanID,"MERUBAH DOKUMEN ORDER INFORMASI PUBLIK ".strtoupper($selectDocument->arrayResult[0]['CAP_LAY_DOC_REQ_DOCNAME'])." MENJADI $ppid");
					}
					if ($selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_NOTES'] != $data['notes'][$i]) {
						if (!empty($data['notes'][$i])) {$data['notes'][$i] = $data['notes'][$i];} else {$data['notes'][$i] = "KOSONG";}
						if (!empty($selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_NOTES']))  {$selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_NOTES'] = $selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_NOTES'];} else {$selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_NOTES'] = "KOSONG";}
						$this->log($permohonanID,"MERUBAH CATATAN INFORMASI PUBLIK ".strtoupper($selectDocument->arrayResult[0]['CAP_LAY_DOC_REQ_DOCNAME'])." DARI ".strtoupper($selectDecide->arrayResult[0]['CAP_LAY_PEM_DOC_NOTES'])." MENJADI ".strtoupper($data['notes'][$i]));
					}

				}

			}
					
		}

	$i = 0;

	$c = count($documentInsertArray);

		if (!empty($documentInsertArray)) {

			foreach ($documentInsertArray as $key => $value) {

			$i++;

			if ($i == $c) {

				$documentInsertLists .= strtoupper($value);

			}
			else {

				$documentInsertLists .= strtoupper($value).", ";

			}

		}

		$this->log($permohonanID,"MEMASUKAN INFORMASI PUBLIK ".$documentInsertLists." KE DALAM PEMBERITAHUAN TERTULIS NO. ".$noPemberitahuan);

		}
		
	}

	public function updatePerpanjangan($data) {

		if (empty($data['id'])) {return false;}
		
		$user 	= unserialize($_SESSION['user']); $userid = $user->getID(); 
		
		end($data['dokumen-id']);

		$u = key($data['dokumen-id']);

		$select = new select("*","CAP_LAYAN_PERPANJANGAN LEFT JOIN CAP_LAYAN ON CAP_LAYAN_PERPANJANGAN.FK_CAP_LAY_ID = CAP_LAYAN.CAP_LAY_ID",array(array("CAP_LAYAN_PERPANJANGAN.CAP_LAY_PER_ID","=",addslashes($data['dokumen-id'][$u]))),"","");
		
		$select->execute();

		$permohonanID = $select->arrayResult[0]['CAP_LAY_ID'];

		//Validation Start ================================================================

		$creationDate = $this->getPermohonanByID($permohonanID);

		$permohonanDate = date("Y-m-d",strtotime($creationDate[0]['CAP_LAY_DATECREATED']));

		$holidayDate = $this->getHolidayDate($permohonanDate,date("Y-12-31"));

		$endDate = $this->getEndDatePermohonan($permohonanDate,$holidayDate);

		$holidayArray = $this->getHolidayArrayNoWeekdays($holidayDate,$endDate);

		$IndonesianHoliday = $this->getIndonesianHolidayDatePicker($holidayDate,$endDate);

		$date1 = new DateTime($permohonanDate);
		
		$date3 = date("Y-m-d");
		
		$date2 = new DateTime($date3);
		
		$interval = $date1->diff($date2);
				    		    
		$days = $interval->format('%d'); 

		$maxDate = $this->getMaxDatePicker($permohonanDate,$holidayArray,$endDate,$days);

		$maxRealDate = $this->getMaxDatePickerDate($permohonanDate,$maxDate,$days);

			if ($select->arrayResult[0]['CAP_LAY_FINALSTATUS'] == 2 || $select->arrayResult[0]['CAP_LAY_FINALSTATUS'] == 3 || $select->arrayResult[0]['CAP_LAY_FINALSTATUS'] == 5) {
				
				$errorMessages [] = "Permohonan sudah mencapai status final. Edit tidak diperbolehkan.";
				
			}

			if (empty($data['tanggal-perpanjangan'])) {

				$errorMessages [] = "Tanggal perpanjangan tidak boleh kosong";

			}
			else {

				if (strtotime($data['tanggal-perpanjangan']) < strtotime($creationDate[0]['CAP_LAY_DATECREATED'])) {

					$errorMessages [] ="Tanggal perpanjangan tidak boleh lebih kecil dari tanggal ".date("d F Y",strtotime($creationDate[0]['CAP_LAY_DATECREATED']));

				}
				if (strtotime($maxRealDate) < strtotime(date("Y-m-d",strtotime($data['tanggal-perpanjangan'])))) {

					$errorMessages [] ="Tanggal perpanjangan tidak boleh lebih besar dari tanggal ".date("d F Y", strtotime($maxRealDate));

				}

			}

			$weekDay = date('w', strtotime($data['tanggal-perpanjangan']));

				if ($weekDay == 0) {

					$errorMessages [] = "Tanggal tanggapan atas keberatan tidak boleh berada di hari minggu";

				}
				else if ($weekDay == 6) {

					$errorMessages [] = "Tanggal tanggapan atas keberatan tidak boleh berada di hari sabtu";

				}
			
			$selectHoliday = new select("*","CAP_LAYAN_CALENDAR",array(array("CAP_LAY_CAL_DATE","=",date("Y-m-d",strtotime($data['tanggal-perpanjangan'])))),"","");

			$selectHoliday->execute();
			
				if (!empty($selectHoliday->arrayResult)) {

					$errorMessages [] = "Tanggal tanggapan atas keberatan ada di hari libur ".ucwords(strtolower($selectHoliday->arrayResult[0]['CAP_LAY_CAL_DESCRIPTION']));

				}

			if (!empty($errorMessages)) {

				$_SESSION['LAYAN-ERROR'] = $errorMessages;

				return false;

			}

		//Validation Stop ==================================================================
		
		$idNumber = $select->arrayResult[0]['CAP_LAY_TRANSACTIONID'];
		
		$select = new select("*","CAP_LAYAN_PERPANJANGAN",array(array("FK_CAP_LAY_ID","=",$permohonanID)),"","");
		
		$select->execute();
		
		$noPemberitahuan = $select->arrayResult[0]['CAP_LAY_PER_NUMBER'];

		$insert = new insert("","","","","");

		$select = new select("*","CAP_LAYAN_DOCUMENT_REQUEST_TYP",array(array("CAP_LAY_DOC_REQ_TYP_NAME","=","PERPANJANGAN")),"","");
		
		$select->execute();
		
		$idType = $select->arrayResult[0]['CAP_LAY_DOC_REQ_TYP_ID'];
		
		$update = new update(array("FK_CAP_LAY_DOC_REQ_ID" => $idType),"CAP_LAYAN_DOCUMENT_REQUEST","CAP_LAY_DOC_REQ_ID","","");

		$selectDecide = new select("*","CAP_LAYAN_PERPANJANGAN_DOC","FK_CAP_LAY_DOC_REQ_ID","","");

		$selectDocument = new select("*","CAP_LAYAN_DOCUMENT_REQUEST","","","");

		end($data['id']);

		$c = key($data['id']);

		for ($i = 0; $i <= $c; $i++) {
		
		$select->tableName = "CAP_LAYAN_PERPANJANGAN";

		$select->whereClause = array(array("CAP_LAY_PER_ID","=",$data['dokumen-id'][$i]));

		$select->execute();

		$selectDocument->whereClause = array(array("CAP_LAY_DOC_REQ_ID","=",$data['id'][$i]));

		$selectDocument->execute();

		$originalDate = date("Y-m-d",strtotime($select->arrayResult[0]['CAP_LAY_PER_DATE_TO']));

		$updatedDate  = date("Y-m-d",strtotime($data['tanggal-perpanjangan']));

			if ($originalDate != $updatedDate) {

				$update->column = array("CAP_LAY_PER_DATE_TO" => date("Y-m-d h:i:s",strtotime($data['tanggal-perpanjangan'])));

				$update->tableName = "CAP_LAYAN_PERPANJANGAN";

				$update->whereClause = "CAP_LAY_PER_ID";

				$update->whereID = $data['dokumen-id'][$i];

				$update->dateColumn = array('CAP_LAY_PER_DATE_TO');

				$status = $update->execute();

					if ($status == 1) {

						$this->log($permohonanID,"MERUBAH TANGGAL AKHIR PERPANJANGAN NO. ".$noPemberitahuan." DARI TANGGAL ".date("d, F Y",strtotime($originalDate))." MENJADI TANGGAL ".date("d, F Y",strtotime($updatedDate))." ");

					}

			}

		if (empty($data['id'][$i])) {continue;}

		$selectDecide->tableName = "CAP_LAYAN_PERPANJANGAN_DOC";
		
		$selectDecide->whereClause = array(array("FK_CAP_LAY_DOC_REQ_ID","=",$data['id'][$i]),array("FK_CAP_LAY_PER_ID","=",$data['dokumen-id'][$i]));
		
		$selectDecide->execute();

			if (empty($selectDecide->arrayResult)) {

			$insert->column = array(
						"FK_CAP_LAY_DOC_REQ_ID" => $data['id'][$i],
						"CAP_LAY_PER_DOC_NOTES" => $data['notes'][$i],
						"FK_CAP_LAY_PER_ID" => $data['dokumen-id'][$i],
						"CAP_LAY_PER_DOC_DATECREATED" => date("Y-m-d H:i:s")
						);

			$insert->dateColumn = array('CAP_LAY_PER_DOC_DATECREATED');
		
			$insert->whereClause = "CAP_LAY_PER_DOC_ID";
			
			$insert->tableName = "CAP_LAYAN_PERPANJANGAN_DOC";
			
			$theID = $insert->execute();

				if (!empty($theID) && is_numeric($theID)) {

					$documentInsertArray [] = strtoupper($selectDocument->arrayResult[0]['CAP_LAY_DOC_REQ_DOCNAME']);

				}

			}
			else {

			$update->column = array(
						"FK_CAP_LAY_DOC_REQ_ID" => $data['id'][$i],
						"CAP_LAY_PER_DOC_NOTES" => $data['notes'][$i],
						"FK_CAP_LAY_PER_ID" => $data['dokumen-id'][$i],
						"CAP_LAY_PER_DOC_DATEUPDATED" => date("Y-m-d H:i:s")
						);

			$update->dateColumn = array('CAP_LAY_PER_DOC_DATEUPDATED');
		
			$update->whereClause = "FK_CAP_LAY_DOC_REQ_ID = '".$data['id'][$i]."' AND FK_CAP_LAY_PER_ID = '".$data['dokumen-id'][$i]."'";
			
			$update->tableName = "CAP_LAYAN_PERPANJANGAN_DOC";
			
			$status = $update->execute();

				if ($status == 1) {

					//Data changes validation start from here
					if ($selectDecide->arrayResult[0]['CAP_LAY_PER_DOC_NOTES'] != $data['notes'][$i]) {
						if (!empty($data['notes'][$i])) {$data['notes'][$i] = $data['notes'][$i];} else {$data['notes'][$i] = "KOSONG";}
						if (!empty($selectDecide->arrayResult[0]['CAP_LAY_PER_DOC_NOTES']))  {$selectDecide->arrayResult[0]['CAP_LAY_PER_DOC_NOTES'] = $selectDecide->arrayResult[0]['CAP_LAY_PER_DOC_NOTES'];} else {$selectDecide->arrayResult[0]['CAP_LAY_PER_DOC_NOTES'] = "KOSONG";}
						$this->log($permohonanID,"MERUBAH CATATAN INFORMASI PUBLIK ".strtoupper($selectDocument->arrayResult[0]['CAP_LAY_DOC_REQ_DOCNAME'])." DARI ".$selectDecide->arrayResult[0]['CAP_LAY_PER_DOC_NOTES']." MENJADI ".$data['notes'][$i]);
					}

				}

			}
					
		}

	$i = 0;

	$c = count($documentInsertArray);

		if (!empty($documentInsertArray)) {

			foreach ($documentInsertArray as $key => $value) {

			$i++;

			if ($i == $c) {

				$documentInsertLists .= strtoupper($value);

			}
			else {

				$documentInsertLists .= strtoupper($value).", ";

			}

		}

		$this->log($permohonanID,"MEMASUKAN INFORMASI PUBLIK ".$documentInsertLists." KE DALAM PERPANJANGAN NO. ".$noPemberitahuan);

		}
		
	}

	public function updatePenolakan($data) {

		if (empty($data['id'])) {return false;}
		
		$user 	= unserialize($_SESSION['user']); $userid = $user->getID(); 
				
		$data['dokumen-id'] = array_values($data['dokumen-id']);
		
		$data['id'] = array_values($data['id']);

		$data['pasal'] = array_values($data['pasal']);

		$data['undang-undang'] = array_values($data['undang-undang']);

		$data['uji-konsekuensi'] = array_values($data['uji-konsekuensi']);

		$data['notes'] = array_values($data['notes']);
		
		end($data['dokumen-id']);

		$u = key($data['dokumen-id']);
		
		//print_r($data);
		
		//return false;

		$select = new select("*","CAP_LAYAN_PENOLAKAN LEFT JOIN CAP_LAYAN ON CAP_LAYAN_PENOLAKAN.FK_CAP_LAY_ID = CAP_LAYAN.CAP_LAY_ID",array(array("CAP_LAYAN_PENOLAKAN.CAP_LAY_PEN_ID","=",addslashes($data['dokumen-id'][$u]))),"","");
		
		$select->execute();
		
			if ($select->arrayResult[0]['CAP_LAY_FINALSTATUS'] == 2 || $select->arrayResult[0]['CAP_LAY_FINALSTATUS'] == 3 || $select->arrayResult[0]['CAP_LAY_FINALSTATUS'] == 5) {
				
				$errorMessages [] = "Permohonan sudah mencapai status final. Edit tidak diperbolehkan.";
				
			}
			
			if (!empty($errorMessages)) {

			$_SESSION['LAYAN-ERROR'] = $errorMessages;

			return "error";
			
			}
		
		$permohonanID = $select->arrayResult[0]['CAP_LAY_ID'];
		
		$idNumber = $select->arrayResult[0]['CAP_LAY_TRANSACTIONID'];
		
		$select = new select("*","CAP_LAYAN_PENOLAKAN",array(array("FK_CAP_LAY_ID","=",$permohonanID)),"","");
		
		$select->execute();
		
		$noPemberitahuan = $select->arrayResult[0]['CAP_LAY_PEN_NUMBER'];

		$insert = new insert("","","","","");

		$select = new select("*","CAP_LAYAN_DOCUMENT_REQUEST_TYP",array(array("CAP_LAY_DOC_REQ_TYP_NAME","=","PENOLAKAN")),"","");
		
		$select->execute();
		
		$idType = $select->arrayResult[0]['CAP_LAY_DOC_REQ_TYP_ID'];
		
		$update = new update(array("FK_CAP_LAY_DOC_REQ_ID" => $idType),"CAP_LAYAN_DOCUMENT_REQUEST","CAP_LAY_DOC_REQ_ID","","");

		$selectDecide = new select("*","","","","");

		$selectDocument = new select("*","","","","");

		end($data['id']);

		$c = key($data['id']);

		for ($i = 0; $i <= $c; $i++) {
		
		if (empty($data['id'][$i])) {continue;}
		
		$selectDecide->tableName = "CAP_LAYAN_PENOLAKAN_DOC";
		
		$selectDecide->whereClause = array(array("FK_CAP_LAY_DOC_REQ_ID","=",$data['id'][$i]));

		$selectDecide->execute();
		
		$selectDocument->tableName = "CAP_LAYAN_DOCUMENT_REQUEST";
		
		$selectDocument->whereClause = array(array("CAP_LAY_DOC_REQ_ID","=",$data['id'][$i]));

		$selectDocument->execute();

			if (empty($selectDecide->arrayResult)) {

			$insert->column = array(
						"FK_CAP_LAY_DOC_REQ_ID" => $data['id'][$i],
						"CAP_LAY_PEN_DOC_NOTES" => $data['notes'][$i],
						"FK_CAP_LAY_PEN_ID" => $data['dokumen-id'][$i],
						"CAP_LAY_PEN_DOC_PSL" => $data['pasal'][$i],
						"CAP_LAY_PEN_DOC_UU" => $data['undang-undang'][$i],
						"CAP_LAY_PEN_DOC_UJI" => $data['uji-konsekuensi'][$i],
						"CAP_LAY_PEN_DOC_DATECREATED" => date("Y-m-d H:i:s")
						);

			$insert->dateColumn = array('CAP_LAY_PEN_DOC_DATECREATED');
		
			$insert->whereClause = "CAP_LAY_PEN_DOC_ID";
			
			$insert->tableName = "CAP_LAYAN_PENOLAKAN_DOC";
			
			$theID = $insert->execute();

				if (!empty($theID) && is_numeric($theID)) {

					$documentInsertArray [] = strtoupper($selectDocument->arrayResult[0]['CAP_LAY_DOC_REQ_DOCNAME']);

				}

			}
			else {

			$update->column = array(
						"FK_CAP_LAY_DOC_REQ_ID" => $data['id'][$i],
						"CAP_LAY_PEN_DOC_NOTES" => $data['notes'][$i],
						"FK_CAP_LAY_PEN_ID" => $data['dokumen-id'][$i],
						"CAP_LAY_PEN_DOC_PSL" => $data['pasal'][$i],
						"CAP_LAY_PEN_DOC_UU" => $data['undang-undang'][$i],
						"CAP_LAY_PEN_DOC_UJI" => $data['uji-konsekuensi'][$i],
						"CAP_LAY_PEN_DOC_DATEUPDATED" => date("Y-m-d H:i:s")
						);

			$update->dateColumn = array('CAP_LAY_PEN_DOC_DATEUPDATED');
		
			$update->whereClause = array(array("FK_CAP_LAY_DOC_REQ_ID","=",$data['id'][$i]));
			
			$update->tableName = "CAP_LAYAN_PENOLAKAN_DOC";
			
			$status = $update->execute();

				if ($status == 1) {
					//print_r($selectDecide->arrayResult);
					//Data changes validation start from here
					if ($selectDecide->arrayResult[0]['CAP_LAY_PEN_DOC_NOTES'] != $data['notes'][$i]) {
						if (!empty($data['notes'][$i])) {$data['notes'][$i] = $data['notes'][$i];} else {$data['notes'][$i] = "KOSONG";}
						if (!empty($selectDecide->arrayResult[0]['CAP_LAY_PEN_DOC_NOTES']))  {$selectDecide->arrayResult[0]['CAP_LAY_PEN_DOC_NOTES'] = $selectDecide->arrayResult[0]['CAP_LAY_PEN_DOC_NOTES'];} else {$selectDecide->arrayResult[0]['CAP_LAY_PEN_DOC_NOTES'] = "KOSONG";}
						$this->log($permohonanID,"MERUBAH CATATAN PENOLAKAN INFORMASI PUBLIK ".strtoupper($selectDocument->arrayResult[0]['CAP_LAY_DOC_REQ_DOCNAME'])." DARI ".$selectDecide->arrayResult[0]['CAP_LAY_PEN_DOC_NOTES']." MENJADI ".$data['notes'][$i]);
					}
					if ($selectDecide->arrayResult[0]['CAP_LAY_PEN_DOC_PSL'] != $data['pasal'][$i]) {
						if (!empty($data['pasal'][$i])) {$data['pasal'][$i] = "Pasal 17 UU KIP";} else {$data['pasal'][$i] = "KOSONG";}
						if (!empty($selectDecide->arrayResult[0]['CAP_LAY_PEN_DOC_PSL']))  {$selectDecide->arrayResult[0]['CAP_LAY_PEN_DOC_PSL'] = $selectDecide->arrayResult[0]['CAP_LAY_PEN_DOC_PSL'];} else {$selectDecide->arrayResult[0]['CAP_LAY_PEN_DOC_PSL'] = "KOSONG";}
						$this->log($permohonanID,"MERUBAH CATATAN PENOLAKAN INFORMASI PUBLIK ".strtoupper($selectDocument->arrayResult[0]['CAP_LAY_DOC_REQ_DOCNAME'])." DARI ".$selectDecide->arrayResult[0]['CAP_LAY_PEN_DOC_PSL']." MENJADI ".$data['pasal'][$i]);
					}
					if ($selectDecide->arrayResult[0]['CAP_LAY_PEN_DOC_UU'] != $data['undang-undang'][$i]) {
						if (!empty($data['undang-undang'][$i])) {$data['undang-undang'][$i] = $data['undang-undang'][$i];} else {$data['undang-undang'][$i] = "KOSONG";}
						if (!empty($selectDecide->arrayResult[0]['CAP_LAY_PEN_DOC_UU']))  {$selectDecide->arrayResult[0]['CAP_LAY_PEN_DOC_UU'] = $selectDecide->arrayResult[0]['CAP_LAY_PEN_DOC_UU'];} else {$selectDecide->arrayResult[0]['CAP_LAY_PEN_DOC_UU'] = "KOSONG";}
						$this->log($permohonanID,"MERUBAH CATATAN PENOLAKAN INFORMASI PUBLIK ".strtoupper($selectDocument->arrayResult[0]['CAP_LAY_DOC_REQ_DOCNAME'])." DARI ".$selectDecide->arrayResult[0]['CAP_LAY_PEN_DOC_UU']." MENJADI ".$data['undang-undang'][$i]);
					}
					if ($selectDecide->arrayResult[0]['CAP_LAY_PEN_DOC_UJI'] != $data['uji-konsekuensi'][$i]) {
						if (!empty($data['uji-konsekuensi'][$i])) {$data['uji-konsekuensi'][$i] = $data['uji-konsekuensi'][$i];} else {$data['uji-konsekuensi'][$i] = "KOSONG";}
						if (!empty($selectDecide->arrayResult[0]['CAP_LAY_PEN_DOC_UJI']))  {$selectDecide->arrayResult[0]['CAP_LAY_PEN_DOC_UJI'] = $selectDecide->arrayResult[0]['CAP_LAY_PEN_DOC_UJI'];} else {$selectDecide->arrayResult[0]['CAP_LAY_PEN_DOC_UJI'] = "KOSONG";}
						$this->log($permohonanID,"MERUBAH CATATAN PENOLAKAN INFORMASI PUBLIK ".strtoupper($selectDocument->arrayResult[0]['CAP_LAY_DOC_REQ_DOCNAME'])." DARI ".$selectDecide->arrayResult[0]['CAP_LAY_PEN_DOC_UJI']." MENJADI ".$data['uji-konsekuensi'][$i]);
					}

				}

			}
					
		}

	$i = 0;

	$c = count($documentInsertArray);

		if (!empty($documentInsertArray)) {

			foreach ($documentInsertArray as $key => $value) {

			$i++;

			if ($i == $c) {

				$documentInsertLists .= strtoupper($value);

			}
			else {

				$documentInsertLists .= strtoupper($value).", ";

			}

		}

		$this->log($permohonanID,"MEMASUKAN INFORMASI PUBLIK ".$documentInsertLists." KE DALAM PENOLAKAN NO. ".$noPemberitahuan);

		}
		
	}

	public function updateKeberatan($data) {
				
		if (empty($data['id'])) {return false;}

		$user = unserialize($_SESSION['user']); $userid = $user->getID(); 

		$data['keberatan-id'] = array_values(array_filter($data['keberatan-id']));

		$data['keberatan-id'] = $data['keberatan-id'][0];

		$data['id'] = array_values($data['id']);

		$data['document-id'] = array_values($data['document-id']);

		$data['daftar-alasan'] = array_values($data['daftar-alasan']);

		$data['notes'] = array_values($data['notes']);

		$data['tanggapan'] = array_values($data['tanggapan']);

		$data['respon-pemohon'] = array_values($data['respon-pemohon']);

		end($data['id']);

		$y = key($data['id']);
		
		$select = new select("*","CAP_LAYAN",array(array("CAP_LAY_TRANSACTIONID","=",base64_decode($data['permohonan-ID']))),"","");

		$select->execute();

		/*==================================================================== Validation Start */
			
			if ($select->arrayResult[0]['CAP_LAY_FINALSTATUS'] == 5) {
				
				$_SESSION['LAYAN-ERROR'][] = "Permohonan sudah mencapai status final. Edit tidak diperbolehkan.";
				
			}
		
			
			if (!empty($data['tanggal-keberatan'])) {

				if (strtotime($data['tanggal-keberatan']) > strtotime($_SESSION['LAYAN-KEBERATAN-MAX-DATE'])) {

					$_SESSION['LAYAN-ERROR'][] = "Tanggal tanggapan atas keberatan tidak boleh lebih dari tanggal ".date("d F, Y",strtotime($_SESSION['LAYAN-KEBERATAN-MAX-DATE']));

				}
				else if (strtotime($data['tanggal-keberatan']) < strtotime(date("Y-m-d"))) {

					$_SESSION['LAYAN-ERROR'][] = "Tanggal tanggapan atas keberatan tidak boleh lebih kecil dari tanggal ".date("d F, Y");

				}

			}
			else {

				//$_SESSION['LAYAN-ERROR'][] = "Tanggal tanggapan atas keberatan tidak boleh kosong"; 

			}

			$weekDay = date('w', strtotime($data['tanggal-keberatan']));

				if ($weekDay == 0) {

					$_SESSION['LAYAN-ERROR'][] = "Tanggal tanggapan atas keberatan tidak boleh berada di hari minggu";

				}
				else if ($weekDay == 6) {

					$_SESSION['LAYAN-ERROR'][] = "Tanggal tanggapan atas keberatan tidak boleh berada di hari sabtu";

				}

			$selectHoliday = new select("*","CAP_LAYAN_CALENDAR",array(array("CAP_LAY_CAL_DATE","=",date("Y-m-d",strtotime($data['tanggal-keberatan'])))),"","");

			$selectHoliday->execute();

				if (!empty($selectHoliday->arrayResult)) {

					$_SESSION['LAYAN-ERROR'][] = "Tanggal tanggapan atas keberatan ada di hari libur ".ucwords(strtolower($selectHoliday->arrayResult[0]['CAP_LAY_CAL_DESCRIPTION']));

				}

			if (!empty($_SESSION['LAYAN-ERROR'])) {

				return false;

			}
			else {

				unset($_SESSION['LAYAN-KEBERATAN-MAX-DATE']);

			}



		/*====================================================================================*/

		//print_r($data);

		//return false;

			if (!empty($select->arrayResult)) {

				$permohonanID = $select->arrayResult[0]['CAP_LAY_ID'];

				$idNumber = base64_decode($data['permohonan-ID'])."/KEB/".$_SESSION['layan-transaksiID'];
				
					if (!empty($data['tanggal-keberatan'])) {
						$keberatanDate = date("Y-m-d",strtotime($data['tanggal-keberatan']));
					}

				$keberatan = array(
						  	     "CAP_LAY_KEB_DATEUPDATED" => date("Y-m-d H:i:s"),
						  	     "CAP_LAY_KEB_DATE_TO"	   => $keberatanDate,
						  	     "CAP_LAY_KEB_NAME"	   	   => $data['nama-kuasa'],
						  	     "CAP_LAY_KEB_ALAMAT"	   => $data['alamat-kuasa'],
						  	     "CAP_LAY_KEB_STATUS"	   => $data['penyelesaian-keberatan'],
						  	     "FK_CAP_USE_ID_TGP"	   => $this->getUserID()
						  	     );

				$update = new update($keberatan,"CAP_LAYAN_KEBERATAN",array(array("CAP_LAY_KEB_ID","=",$data['keberatan-id'])),"","");
				
				$update->dateColumn = array('CAP_LAY_KEB_DATEUPDATED','CAP_LAY_KEB_DATE_TO');
				
				$selectDecide = new select("*","CAP_LAYAN_KEBERATAN",array(array("CAP_LAY_KEB_ID","=",$data['keberatan-id'])),"","");
				
				$selectDecide->execute();
				
					if (!empty($selectDecide->arrayResult[0]['CAP_LAY_KEB_DATE_TO'])) {
						$keberatanDateStart = date("Y-m-d",strtotime($selectDecide->arrayResult[0]['CAP_LAY_KEB_DATE_TO']));
					}
				
				$lastID = $update->execute();
				
					if (is_resource($lastID)) {
					
						if ($keberatanDateStart != $keberatanDate) {
							if (!empty($keberatanDate)) {$keberatanDate = $keberatanDate;} else {$keberatanDate = "KOSONG";}
							if (!empty($selectDecide->arrayResult[0]['CAP_LAY_KEB_DATE_TO']))  {$selectDecide->arrayResult[0]['CAP_LAY_KEB_DATE_TO'] = date("Y-m-d",strtotime($selectDecide->arrayResult[0]['CAP_LAY_KEB_DATE_TO']));} else {$selectDecide->arrayResult[0]['CAP_LAY_KEB_DATE_TO'] = "KOSONG";}
							$this->log($permohonanID,"MERUBAH TANGGAL KEBERATAN NO. ".$selectDecide->arrayResult[0]['CAP_LAY_KEB_NUMBER']." DARI TANGGAL ".$selectDecide->arrayResult[0]['CAP_LAY_KEB_DATE_TO']." MENJADI TANGGAL ".$keberatanDate);
									
						}
						if ($selectDecide->arrayResult[0]['CAP_LAY_KEB_NAME'] != $data['nama-kuasa']) {
							if (!empty($data['nama-kuasa'])) {$data['nama-kuasa'] = $data['nama-kuasa'];} else {$data['nama-kuasa'] = "KOSONG";}
							if (!empty($selectDecide->arrayResult[0]['CAP_LAY_KEB_NAME']))  {$selectDecide->arrayResult[0]['CAP_LAY_KEB_NAME'] = $selectDecide->arrayResult[0]['CAP_LAY_KEB_NAME'];} else {$selectDecide->arrayResult[0]['CAP_LAY_KEB_NAME'] = "KOSONG";}
							$this->log($permohonanID,"MERUBAH NAMA KUASA KEBERATAN NO. ".$selectDecide->arrayResult[0]['CAP_LAY_KEB_NUMBER']." DARI ".$selectDecide->arrayResult[0]['CAP_LAY_KEB_NAME']." MENJADI ".$data['nama-kuasa']);
									
						}
						if ($selectDecide->arrayResult[0]['CAP_LAY_KEB_ALAMAT'] != $data['alamat-kuasa']) {
							if (!empty($data['alamat-kuasa'])) {$data['alamat-kuasa'] = $data['alamat-kuasa'];} else {$data['alamat-kuasa'] = "KOSONG";}
							if (!empty($selectDecide->arrayResult[0]['CAP_LAY_KEB_ALAMAT']))  {$selectDecide->arrayResult[0]['CAP_LAY_KEB_ALAMAT'] = $selectDecide->arrayResult[0]['CAP_LAY_KEB_ALAMAT'];} else {$selectDecide->arrayResult[0]['CAP_LAY_KEB_ALAMAT'] = "KOSONG";}
							$this->log($permohonanID,"MERUBAH ALAMAT KUASA KEBERATAN NO. ".$selectDecide->arrayResult[0]['CAP_LAY_KEB_NUMBER']." DARI ".$selectDecide->arrayResult[0]['CAP_LAY_KEB_ALAMAT']." MENJADI ".$data['alamat-kuasa']);
									
						}
						if ($selectDecide->arrayResult[0]['CAP_LAY_KEB_STATUS'] != $data['penyelesaian-keberatan']) {
						
							if ($data['penyelesaian-keberatan'] == 0) {
								$hasilAkhirPenyelesaian = "BELUM DIPROSES";
							}
							else if ($data['penyelesaian-keberatan'] == 1) {
								$hasilAkhirPenyelesaian = "SELESAI SECARA INTERNAL";
							}
							else if ($data['penyelesaian-keberatan'] == 2) {
								$hasilAkhirPenyelesaian = "SENGKETA DI KOMISI INFORMASI";
							}
							
							if ($selectDecide->arrayResult[0]['CAP_LAY_KEB_STATUS'] == 0) {
								$hasilAkhirPenyelesaianAwal = "BELUM DIPROSES";
							}
							else if ($selectDecide->arrayResult[0]['CAP_LAY_KEB_STATUS'] == 1) {
								$hasilAkhirPenyelesaianAwal = "SELESAI SECARA INTERNAL";
							}
							else if ($selectDecide->arrayResult[0]['CAP_LAY_KEB_STATUS'] == 2) {
								$hasilAkhirPenyelesaianAwal = "SENGKETA DI KOMISI INFORMASI";
							}
						
							if (!empty($data['penyelesaian-keberatan'])) {$data['penyelesaian-keberatan'] = $hasilAkhirPenyelesaian;} else {$data['penyelesaian-keberatan'] = "KOSONG";}
							if (!empty($selectDecide->arrayResult[0]['CAP_LAY_KEB_STATUS']))  {$selectDecide->arrayResult[0]['CAP_LAY_KEB_STATUS'] = $selectDecide->arrayResult[0]['CAP_LAY_KEB_STATUS'];} else {$selectDecide->arrayResult[0]['CAP_LAY_KEB_STATUS'] = "KOSONG";}
							$this->log($permohonanID,"MERUBAH STATUS KEBERATAN NO. ".$selectDecide->arrayResult[0]['CAP_LAY_KEB_NUMBER']." DARI ".$hasilAkhirPenyelesaianAwal." MENJADI ".$hasilAkhirPenyelesaian);
									
						}
					
					}
				
				if (is_resource($lastID)) {
				
				$selectDecide = new select("*","CAP_LAYAN_KEBERATAN_DOC","","","");
				
				$selectDocument = new select("*","","","","");

				$insert = new insert("","","","","");

					for ($i = 0; $i <= $y; $i++) {
					
					unset($permohonan);
					unset($pemberitahuan);
					unset($penolakan);
					unset($perpanjangan);

					$type = preg_replace('/[^A-Za-z]/','',$data['id'][$i]);

					$real = preg_replace('/[^0-9]/','',$data['id'][$i]);

						if ($type == 'permohonan') {
							$permohonan = $real;
						}
						else if ($type == 'pemberitahuan') {
							$pemberitahuan = $real;
						}
						else if ($type == 'penolakan') {
							$penolakan = $real;
						}
						else if ($type == 'perpanjangan') {
							$perpanjangan = $real;
						}

						if (empty($data['document-id'][$i])) {

						$insert->column = array(
									"FK_CAP_LAY_KEB_ID" 	=> $data['keberatan-id'],
									"CAP_LAY_KEB_DOC_A" 	=> $data['daftar-alasan'][$i][0],
									"CAP_LAY_KEB_DOC_B" 	=> $data['daftar-alasan'][$i][1],
									"CAP_LAY_KEB_DOC_C" 	=> $data['daftar-alasan'][$i][2],
									"CAP_LAY_KEB_DOC_D" 	=> $data['daftar-alasan'][$i][3],
									"CAP_LAY_KEB_DOC_E" 	=> $data['daftar-alasan'][$i][4],
									"CAP_LAY_KEB_DOC_F" 	=> $data['daftar-alasan'][$i][5],
									"CAP_LAY_KEB_DOC_G" 	=> $data['daftar-alasan'][$i][6],
									"CAP_LAY_KEB_DOC_NOTES" => $data['notes'][$i],
									"FK_CAP_LAY_ID" 		=> $permohonan,
									"FK_CAP_LAY_PEM_ID" 	=> $pemberitahuan,
									"FK_CAP_LAY_PEN_ID" 	=> $penolakan,
									"FK_CAP_LAY_PER_ID" 	=> $perpanjangan,
									"CAP_LAY_KEB_DOC_RESPONSE" 		=> $data['tanggapan'][$i],
									"CAP_LAY_KEB_DOC_RESPONSE_U" 	=> $data['respon-pemohon'][$i]
									);
																	
						$insert->tableName 	 = "CAP_LAYAN_KEBERATAN_DOC";

						$insert->whereClause = "CAP_LAY_KEB_DOC_ID";

						$insert->dateColumn  = array();
					
						$theID = $insert->execute();
						
							if (!empty($theID) && is_numeric($theID)) {

								if ($type == 'permohonan') {
									$permohonan = $real;
									$selectDocument->tableName = "CAP_LAYAN";
									$selectDocument->whereClause = array(array("CAP_LAY_ID","=",$real));
									$selectDocument->execute();

									if (!empty($selectDocument->arrayResult)) {
										$documented = "PERMOHONAN NO. ".$selectDocument->arrayResult[0]['CAP_LAY_TRANSACTIONID'];
									}

								}
								else if ($type == 'pemberitahuan') {
									$pemberitahuan = $real;
									$selectDocument->tableName = "CAP_LAYAN_PEMBERITAHUAN";
									$selectDocument->whereClause = array(array("CAP_LAY_PEM_ID","=",$real));
									$selectDocument->execute();

									if (!empty($selectDocument->arrayResult)) {
										$documented = "PEMBERITAHUAN NO. ".$selectDocument->arrayResult[0]['CAP_LAY_PEM_NUMBER'];
									}
								}
								else if ($type == 'penolakan') {
									$penolakan = $real;
									$selectDocument->tableName = "CAP_LAYAN_PENOLAKAN";
									$selectDocument->whereClause = array(array("CAP_LAY_PEN_ID","=",$real));
									$selectDocument->execute();

									if (!empty($selectDocument->arrayResult)) {
										$documented = "PENOLAKAN NO. ".$selectDocument->arrayResult[0]['CAP_LAY_PEN_NUMBER'];
									}
								}
								else if ($type == 'perpanjangan') {
									$perpanjangan = $real;
									$selectDocument->tableName = "CAP_LAYAN_PERPANJANGAN";
									$selectDocument->whereClause = array(array("CAP_LAY_PER_ID","=",$real));
									$selectDocument->execute();

									if (!empty($selectDocument->arrayResult)) {
										$documented = "PERPANJANGAN NO. ".$selectDocument->arrayResult[0]['CAP_LAY_PER_NUMBER'];
									}
								}

							$dokumenListsInsertion .= $documented.",";
							$newInsertion++;

							}

						}
						else {
						
						
						
						$update->column = array(
									"CAP_LAY_KEB_DOC_A" 	=> $data['daftar-alasan'][$i][0],
									"CAP_LAY_KEB_DOC_B" 	=> $data['daftar-alasan'][$i][1],
									"CAP_LAY_KEB_DOC_C" 	=> $data['daftar-alasan'][$i][2],
									"CAP_LAY_KEB_DOC_D" 	=> $data['daftar-alasan'][$i][3],
									"CAP_LAY_KEB_DOC_E" 	=> $data['daftar-alasan'][$i][4],
									"CAP_LAY_KEB_DOC_F" 	=> $data['daftar-alasan'][$i][5],
									"CAP_LAY_KEB_DOC_G" 	=> $data['daftar-alasan'][$i][6],
									"CAP_LAY_KEB_DOC_NOTES" => $data['notes'][$i],
									"CAP_LAY_KEB_DOC_RESPONSE" 		=> $data['tanggapan'][$i],
									"CAP_LAY_KEB_DOC_RESPONSE_U" 	=> $data['respon-pemohon'][$i]
									);
																	
						$update->tableName 	 = "CAP_LAYAN_KEBERATAN_DOC";

						$update->whereClause = array(array("CAP_LAY_KEB_DOC_ID","=",$data['document-id'][$i]));
						
						$selectDecide->whereClause = array(array("CAP_LAY_KEB_DOC_ID","=",$data['document-id'][$i]));
							
						$selectDecide->execute();
						
						$theID = $update->execute();
												
							if (is_resource($theID)) {

								if ($type == 'permohonan') {
									$permohonan = $real;
									$selectDocument->tableName = "CAP_LAYAN";
									$selectDocument->whereClause = array(array("CAP_LAY_ID","=",$real));
									$selectDocument->execute();

									if (!empty($selectDocument->arrayResult)) {
										$documented = "PERMOHONAN NO. ".$selectDocument->arrayResult[0]['CAP_LAY_TRANSACTIONID'];
									}

								}
								else if ($type == 'pemberitahuan') {
									$pemberitahuan = $real;
									$selectDocument->tableName = "CAP_LAYAN_PEMBERITAHUAN";
									$selectDocument->whereClause = array(array("CAP_LAY_PEM_ID","=",$real));
									$selectDocument->execute();

									if (!empty($selectDocument->arrayResult)) {
										$documented = "PEMBERITAHUAN NO. ".$selectDocument->arrayResult[0]['CAP_LAY_PEM_NUMBER'];
									}
								}
								else if ($type == 'penolakan') {
									$penolakan = $real;
									$selectDocument->tableName = "CAP_LAYAN_PENOLAKAN";
									$selectDocument->whereClause = array(array("CAP_LAY_PEN_ID","=",$real));
									$selectDocument->execute();

									if (!empty($selectDocument->arrayResult)) {
										$documented = "PENOLAKAN NO. ".$selectDocument->arrayResult[0]['CAP_LAY_PEN_NUMBER'];
									}
								}
								else if ($type == 'perpanjangan') {
									$perpanjangan = $real;
									$selectDocument->tableName = "CAP_LAYAN_PERPANJANGAN";
									$selectDocument->whereClause = array(array("CAP_LAY_PER_ID","=",$real));
									$selectDocument->execute();

									if (!empty($selectDocument->arrayResult)) {
										$documented = "PERPANJANGAN NO. ".$selectDocument->arrayResult[0]['CAP_LAY_PER_NUMBER'];
									}

								}

							$dokumenListsUpdated .= $documented.",";
							$newUpdated++;

							}
							
							if (is_resource($theID)) {
						
								if ($selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_A'] != $data['daftar-alasan'][$i][0]) {
									if (!empty($data['daftar-alasan'][$i][0])) {$data['daftar-alasan'][$i][0] = "ya";} else {$data['daftar-alasan'][$i][0] = "KOSONG";}
									if (!empty($selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_A']))  {$selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_A'] = $selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_A'];} else {$selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_A'] = "KOSONG";}
									$this->log($permohonanID,"MERUBAH CATATAN KEBERATAN DOKUMEN $documented POIN ALASAN PENGECUALIAN PASA 17 UU NO. 14 TAHUN 2008 DARI ".$selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_A']." MENJADI ".$data['daftar-alasan'][$i][0]);
									
								}
								if ($selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_B'] != $data['daftar-alasan'][$i][1]) {
									if (!empty($data['daftar-alasan'][$i][1])) {$data['daftar-alasan'][$i][1] = "ya";} else {$data['daftar-alasan'][$i][1] = "KOSONG";}
									if (!empty($selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_B']))  {$selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_B'] = $selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_B'];} else {$selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_B'] = "KOSONG";}
									$this->log($permohonanID,"MERUBAH CATATAN KEBERATAN DOKUMEN $documented POIN TIDAK DISEDIAKAN INFORMASI BERKALA DARI ".$selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_B']." MENJADI ".$data['daftar-alasan'][$i][1]);
									
								}
								if ($selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_C'] != $data['daftar-alasan'][$i][2]) {
									if (!empty($data['daftar-alasan'][$i][2])) {$data['daftar-alasan'][$i][2] = "ya";} else {$data['daftar-alasan'][$i][2] = "KOSONG";}
									if (!empty($selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_C']))  {$selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_C'] = $selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_C'];} else {$selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_C'] = "KOSONG";}
									$this->log($permohonanID,"MERUBAH CATATAN KEBERATAN DOKUMEN $documented POIN TIDAK DITANGGAPINYA PERMINTAAN INFORMASI DARI ".$selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_C']." MENJADI ".$data['daftar-alasan'][$i][2]);
									
								}
								if ($selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_D'] != $data['daftar-alasan'][$i][3]) {
									if (!empty($data['daftar-alasan'][$i][3])) {$data['daftar-alasan'][$i][3] = "ya";} else {$data['daftar-alasan'][$i][3] = "KOSONG";}
									if (!empty($selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_D']))  {$selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_D'] = $selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_D'];} else {$selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_D'] = "KOSONG";}
									$this->log($permohonanID,"MERUBAH CATATAN KEBERATAN DOKUMEN $documented POIN TIDAK DITANGGAPI SEBAGAIMANA YANG DIMINTA DARI ".$selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_D']." MENJADI ".$data['daftar-alasan'][$i][3]);
									
								}
								if ($selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_E'] != $data['daftar-alasan'][$i][4]) {
									if (!empty($data['daftar-alasan'][$i][4])) {$data['daftar-alasan'][$i][4] = "ya";} else {$data['daftar-alasan'][$i][4] = "KOSONG";}
									if (!empty($selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_E']))  {$selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_E'] = $selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_E'];} else {$selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_E'] = "KOSONG";}
									$this->log($permohonanID,"MERUBAH CATATAN KEBERATAN DOKUMEN $documented POIN TIDAK DIPENUHINYA PERMINTAAN INFORMASI DARI ".$selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_E']." MENJADI ".$data['daftar-alasan'][$i][4]);
									
								}
								if ($selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_F'] != $data['daftar-alasan'][$i][5]) {
									if (!empty($data['daftar-alasan'][$i][5])) {$data['daftar-alasan'][$i][5] = "ya";} else {$data['daftar-alasan'][$i][5] = "KOSONG";}
									if (!empty($selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_F']))  {$selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_F'] = $selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_F'];} else {$selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_F'] = "KOSONG";}
									$this->log($permohonanID,"MERUBAH CATATAN KEBERATAN DOKUMEN $documented POIN PENGENAAN BIAYA YANG TIDAK WAJAR DARI ".$selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_F']." MENJADI ".$data['daftar-alasan'][$i][5]);
									
								}
								if ($selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_G'] != $data['daftar-alasan'][$i][6]) {
									if (!empty($data['daftar-alasan'][$i][6])) {$data['daftar-alasan'][$i][6] = "ya";} else {$data['daftar-alasan'][$i][6] = "KOSONG";}
									if (!empty($selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_G']))  {$selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_G'] = $selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_G'];} else {$selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_G'] = "KOSONG";}
									$this->log($permohonanID,"MERUBAH CATATAN KEBERATAN DOKUMEN $documented POIN PENYAMPAIAN INFORMASI MELEBIHI WAKTU YANG DIATUR DALAM UNDANG-UNDANG DARI ".$selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_G']." MENJADI ".$data['daftar-alasan'][$i][6]);
									
								}
								if ($selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_NOTES'] != $data['notes'][$i]) {
									if (!empty($data['notes'][$i])) {$data['notes'][$i] = $data['notes'][$i];} else {$data['notes'][$i] = "KOSONG";}
									if (!empty($selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_NOTES']))  {$selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_NOTES'] = $selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_NOTES'];} else {$selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_NOTES'] = "KOSONG";}
									$this->log($permohonanID,"MERUBAH CATATAN KEBERATAN DOKUMEN $documented POIN ALASAN KEBERATAN PEMOHON DARI ".$selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_NOTES']." MENJADI ".$data['notes'][$i]);
									
								}
								if ($selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_RESPONSE'] != $data['tanggapan'][$i]) {
									if (!empty($data['tanggapan'][$i])) {$data['tanggapan'][$i] = $data['tanggapan'][$i];} else {$data['tanggapan'][$i] = "KOSONG";}
									if (!empty($selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_RESPONSE']))  {$selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_RESPONSE'] = $selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_RESPONSE'];} else {$selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_RESPONSE'] = "KOSONG";}
									$this->log($permohonanID,"MERUBAH CATATAN KEBERATAN DOKUMEN $documented POIN TANGGAPAN PPID DARI ".$selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_RESPONSE']." MENJADI ".$data['tanggapan'][$i]);
									
								}
								if ($selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_RESPONSE_U'] != $data['respon-pemohon'][$i]) {
									if (!empty($data['respon-pemohon'][$i])) {$data['respon-pemohon'][$i] = $data['respon-pemohon'][$i];} else {$data['respon-pemohon'][$i] = "KOSONG";}
									if (!empty($selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_RESPONSE_U']))  {$selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_RESPONSE_U'] = $selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_RESPONSE_U'];} else {$selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_RESPONSE_U'] = "KOSONG";}
									$this->log($permohonanID,"MERUBAH CATATAN KEBERATAN DOKUMEN $documented POIN TANGGAPAN PEMOHON DARI ".$selectDecide->arrayResult[0]['CAP_LAY_KEB_DOC_RESPONSE_U']." MENJADI ".$data['respon-pemohon'][$i]);
									
								}
								
							}

						}
					
					}

					if (!empty($newInsertion)) {

					$dokumenListsInsertion = substr($dokumenListsInsertion, 0, -1);

					$this->log($permohonanID,"MEMASUKAN DOKUMEN SEBAGAI BERIKUT: $dokumenListsInsertion DALAM KEBERATAN NO. ".$idNumber."");

					}
					if (!empty($newUpdated)) {

					$dokumenListsUpdated = substr($dokumenListsUpdated, 0, -1);

					//$this->log($permohonanID,"MEMASUKAN DOKUMEN SEBAGAI BERIKUT: $dokumenListsUpdated DALAM KEBERATAN NO. ".$idNumber."");

					}

				}
				

			}
			
		
	}
	
	public function getStatusDokumen($id) {
		
		$select = new select("*","CAP_LAYAN_DOCUMENT_REQUEST_TYP",array(array("CAP_LAY_DOC_REQ_TYP_ID","=",$id)),"","");
		
		$select->execute();
		
		return $select->arrayResult;
	
	}

	public function getStatusDokumenHistory($id) {

		$select = new select("*","CAP_LAYAN_PEMBERITAHUAN_DOC",array(array("FK_CAP_LAY_DOC_REQ_ID","=",$id)),"","");
				
		$select->execute();

			if (!empty($select->arrayResult)) {

				return 1;

			}
			else {

				$select = new select("*","CAP_LAYAN_PENOLAKAN_DOC",array(array("FK_CAP_LAY_DOC_REQ_ID","=",$id)),"","");
				
				$select->execute();

				if (!empty($select->arrayResult)) {

				return 2;

				}
				else {

					$select = new select("*","","","","");
						
					$select->tableName = "CAP_LAYAN_PERPANJANGAN_DOC WHERE FK_CAP_LAY_DOC_REQ_ID = '$id' AND 
						CAP_LAY_PER_DOC_DATECREATED = (SELECT MAX(CAP_LAY_PER_DOC_DATECREATED) FROM ".$select->schema.".CAP_LAYAN_PERPANJANGAN_DOC WHERE FK_CAP_LAY_DOC_REQ_ID = $id )";
				
					$select->execute();

					if (!empty($select->arrayResult)) {

					return 3;

					}
					else {

					return 0;

					}

				}

			}
		
		//return $select->arrayResult;
		
	}
	
	public function getPermohonanLengkap() {
		
		$select = new select("*","CAP_LAYAN",array(array("CAP_LAY_ID","=",$this->data)),"","");
		
		$select->execute();
		
		return $select->arrayResult;
		
	}
	
	public function getPemberitahuanLengkap() {
		
		$select = new select("*","CAP_LAYAN_PEMBERITAHUAN LEFT JOIN CAP_LAYAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_PEMBERITAHUAN.FK_CAP_LAY_ID",array(array("CAP_LAYAN_PEMBERITAHUAN.FK_CAP_LAY_ID","=",$this->data)),"","");
		
		$select->execute();
		
		return $select->arrayResult;
		
	}

	public function getKeberatanLengkap() {
		
		$select = new select("*","CAP_LAYAN_KEBERATAN LEFT JOIN CAP_LAYAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_KEBERATAN.FK_CAP_LAY_ID",array(array("CAP_LAYAN_KEBERATAN.FK_CAP_LAY_ID","=",$this->data)),"","");
		
		$select->execute();
		
		return $select->arrayResult;
		
	}

	public function getPemberitahuanLengkapPrint() {
		
		foreach ($this->data as $key => $value) {
			
			$select = new select("*","CAP_LAYAN_PEMBERITAHUAN LEFT JOIN CAP_LAYAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_PEMBERITAHUAN.FK_CAP_LAY_ID",array(array("CAP_LAYAN_PEMBERITAHUAN.CAP_LAY_PEM_ID","=",$value)),"","");
			
			$select->execute();
			
			$pemberitahuan = $select->arrayResult;
			
			$returnArray [] = array('pemberitahuan' => $pemberitahuan) ;

		}

		return $returnArray;

	}

	public function getPerpanjanganLengkapPrint() {
		
		foreach ($this->data as $key => $value) {
			
			$select = new select("*","CAP_LAYAN_PERPANJANGAN LEFT JOIN CAP_LAYAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_PERPANJANGAN.FK_CAP_LAY_ID",array(array("CAP_LAYAN_PERPANJANGAN.CAP_LAY_PER_ID","=",$value)),"","");
			
			$select->execute();
			
			$pemberitahuan = $select->arrayResult;
			
			$returnArray [] = array('pemberitahuan' => $pemberitahuan) ;

			
		}
		return $returnArray;
	}
	

	public function getPenolakanLengkapPrint() {
		
		foreach ($this->data as $key => $value) {
			
			$select = new select("*"," CAP_LAYAN_PENOLAKAN LEFT JOIN CAP_LAYAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_PENOLAKAN.FK_CAP_LAY_ID",array(array("CAP_LAYAN_PENOLAKAN.CAP_LAY_PEN_ID","=",$value)),"","");
			
			$select->execute();
			
			$pemberitahuan = $select->arrayResult;
			
			$returnArray [] = array('pemberitahuan' => $pemberitahuan) ;

			
		}
		return $returnArray;
	}
	
	public function getKeberatanLengkapPrint() {
		
		foreach ($this->data as $key => $value) {
			
			$select = new select("*","CAP_LAYAN_KEBERATAN LEFT JOIN CAP_LAYAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_KEBERATAN.FK_CAP_LAY_ID",array(array("CAP_LAYAN_KEBERATAN.CAP_LAY_KEB_ID","=",$value)),"","");
			
			$select->execute();
			
			$keberatan = $select->arrayResult;
			
			$returnArray [] = array('keberatan' => $keberatan) ;

			
		}
		return $returnArray;
	}

	public function getPerpanjanganLengkap() {

		$select = new select("*","CAP_LAYAN_PERPANJANGAN LEFT JOIN CAP_LAYAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_PERPANJANGAN.FK_CAP_LAY_ID",array(array("CAP_LAYAN_PERPANJANGAN.FK_CAP_LAY_ID","=",$this->data)),"","");
		
		$select->execute();
		
		return $select->arrayResult;

	}

	public function getPenolakanLengkap() {

		$select = new select("*","CAP_LAYAN_PENOLAKAN LEFT JOIN CAP_LAYAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_PENOLAKAN.FK_CAP_LAY_ID",array(array("CAP_LAYAN_PENOLAKAN.FK_CAP_LAY_ID","=",$this->data)),"","");
		
		$select->execute();
		
		return $select->arrayResult;

	}

	public function getPemberitahuanByID($id) {
		
		$select = new select("*","CAP_LAYAN_PEMBERITAHUAN LEFT JOIN CAP_LAYAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_PEMBERITAHUAN.FK_CAP_LAY_ID",array(array("CAP_LAYAN_PEMBERITAHUAN.CAP_LAY_PEM_ID","=",$id)),"","");
		
		$select->execute();
		
		return $select->arrayResult;
		
	}

	public function getPenolakanByID($id) {
		
		$select = new select("*","CAP_LAYAN_PENOLAKAN LEFT JOIN CAP_LAYAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_PENOLAKAN.FK_CAP_LAY_ID",array(array("CAP_LAYAN_PENOLAKAN.CAP_LAY_PEN_ID","=",$id)),"","");
		
		$select->execute();
		
		return $select->arrayResult;
		
	}

	public function getPerpanjanganByID($id) {
		
		$select = new select("*","CAP_LAYAN_PERPANJANGAN LEFT JOIN CAP_LAYAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_PERPANJANGAN.FK_CAP_LAY_ID",array(array("CAP_LAYAN_PERPANJANGAN.CAP_LAY_PER_ID","=",$id)),"","");
		
		$select->execute();
		
		return $select->arrayResult;
		
	}

	public function getKeberatanByID($id) {
		
		$select = new select("*","CAP_LAYAN_KEBERATAN LEFT JOIN CAP_LAYAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_KEBERATAN.FK_CAP_LAY_ID",array(array("CAP_LAYAN_KEBERATAN.CAP_LAY_KEB_ID","=",$id)),"","");
		
		$select->execute();
		
		return $select->arrayResult;
		
	}

	public function getPerpanjanganByIDLayan($id) {
		
		$select = new select("*","CAP_LAYAN_PERPANJANGAN LEFT JOIN CAP_LAYAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_PERPANJANGAN.FK_CAP_LAY_ID",array(array("CAP_LAYAN_PERPANJANGAN.FK_CAP_LAY_ID","=",$id)),"","CAP_LAY_PER_DATECREATED DESC");
		
		$select->execute();
		
		return $select->arrayResult;
		
	}

	public function getPenolakanByIDLayan($id) {
		
		$select = new select("*","CAP_LAYAN_PENOLAKAN LEFT JOIN CAP_LAYAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_PENOLAKAN.FK_CAP_LAY_ID",
		array(array("CAP_LAYAN_PENOLAKAN.FK_CAP_LAY_ID","=",$id)),"","CAP_LAY_PEN_DATECREATED DESC");
		
		$select->execute();
		
		return $select->arrayResult;
		
	}

	public function getPemberitahuanByIDLayan($id) {
		
		$select = new select("*","CAP_LAYAN_PEMBERITAHUAN LEFT JOIN CAP_LAYAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_PEMBERITAHUAN.FK_CAP_LAY_ID",
		array(array("CAP_LAYAN_PEMBERITAHUAN.FK_CAP_LAY_ID","=",$id)),"","CAP_LAY_PEM_DATECREATED DESC");
		
		$select->execute();
		
		return $select->arrayResult;
		
	}
	
	public function getPemberitahuanDokumen($id) {
		
		$select = new select("*",
				"CAP_LAYAN_PEMBERITAHUAN 
				LEFT JOIN CAP_LAYAN_PEMBERITAHUAN_DOC ON CAP_LAYAN_PEMBERITAHUAN.CAP_LAY_PEM_ID = CAP_LAYAN_PEMBERITAHUAN_DOC.FK_CAP_LAY_PEM_ID 
				LEFT JOIN CAP_LAYAN_DOCUMENT_REQUEST ON CAP_LAYAN_PEMBERITAHUAN_DOC.FK_CAP_LAY_DOC_REQ_ID = CAP_LAYAN_DOCUMENT_REQUEST.CAP_LAY_DOC_REQ_ID",array(array("CAP_LAYAN_PEMBERITAHUAN.CAP_LAY_PEM_ID","=",$id)),"","");
		
		$select->execute();
		
		return $select->arrayResult;
		
	}

	public function getPerpanjanganDokumen($id) {
		
		$select = new select("*",
				"CAP_LAYAN_PERPANJANGAN
				LEFT JOIN CAP_LAYAN_PERPANJANGAN_DOC ON CAP_LAYAN_PERPANJANGAN.CAP_LAY_PER_ID = CAP_LAYAN_PERPANJANGAN_DOC.FK_CAP_LAY_PER_ID 
				LEFT JOIN CAP_LAYAN_DOCUMENT_REQUEST ON CAP_LAYAN_PERPANJANGAN_DOC.FK_CAP_LAY_DOC_REQ_ID = CAP_LAYAN_DOCUMENT_REQUEST.CAP_LAY_DOC_REQ_ID",array(array("CAP_LAYAN_PERPANJANGAN.CAP_LAY_PER_ID","=",$id)),"","");
		
		$select->execute();
		
		return $select->arrayResult;
		
	}

	public function getPenolakanDokumen($id) {
		
		$select = new select("*",
				"CAP_LAYAN_PENOLAKAN
				LEFT JOIN CAP_LAYAN_PENOLAKAN_DOC ON CAP_LAYAN_PENOLAKAN.CAP_LAY_PEN_ID = CAP_LAYAN_PENOLAKAN_DOC.FK_CAP_LAY_PEN_ID 
				LEFT JOIN CAP_LAYAN_DOCUMENT_REQUEST ON CAP_LAYAN_PENOLAKAN_DOC.FK_CAP_LAY_DOC_REQ_ID = CAP_LAYAN_DOCUMENT_REQUEST.CAP_LAY_DOC_REQ_ID",array(array("CAP_LAYAN_PENOLAKAN.CAP_LAY_PEN_ID","=",$id)),"","");
		
		$select->execute();
		
		return $select->arrayResult;
		
	}

	public function getKeberatanDokumen($id) {
		
		$select = new select("*",
				"CAP_LAYAN_KEBERATAN 
				LEFT JOIN CAP_LAYAN_KEBERATAN_DOC ON CAP_LAYAN_KEBERATAN.CAP_LAY_KEB_ID = CAP_LAYAN_KEBERATAN_DOC.FK_CAP_LAY_KEB_ID 
				LEFT JOIN CAP_LAYAN_PEMBERITAHUAN ON CAP_LAYAN_KEBERATAN_DOC.FK_CAP_LAY_PEM_ID = CAP_LAYAN_PEMBERITAHUAN.CAP_LAY_PEM_ID 
				LEFT JOIN CAP_LAYAN_PENOLAKAN ON CAP_LAYAN_KEBERATAN_DOC.FK_CAP_LAY_PEN_ID = CAP_LAYAN_PENOLAKAN.CAP_LAY_PEN_ID 
				LEFT JOIN CAP_LAYAN_PERPANJANGAN ON CAP_LAYAN_KEBERATAN_DOC.FK_CAP_LAY_PER_ID = CAP_LAYAN_PERPANJANGAN.CAP_LAY_PER_ID
				LEFT JOIN CAP_LAYAN ON CAP_LAYAN_KEBERATAN_DOC.FK_CAP_LAY_ID = CAP_LAYAN.CAP_LAY_ID",
				array(array("CAP_LAYAN_KEBERATAN.CAP_LAY_KEB_ID","=",$id)),"","");

		$select->execute();
		
		return $select->arrayResult;
		
	}
	
	public function getPermohonanUserSide() {
				
		$select = new select("*","CAP_LAYAN",array(array("CAP_LAY_FINALSTATUS","!=",2),array("CAP_LAY_FINALSTATUS","!=",3),array("CAP_LAY_FINALSTATUS","!=",4),array("CAP_LAY_FINALSTATUS","!=",5)),"","CAP_LAY_DATECREATED ASC");
		
		@$select->execute();
		//print_r($select->query);
		return $select->arrayResult;
		
	}
	
	public function getPermohonanAdminSide() {
				
		$select = new select("*","CAP_LAYAN",array(array("CAP_LAY_FINALSTATUS","=",1)),"","CAP_LAY_DATECREATED ASC");
		
		@$select->execute();
		
		return $select->arrayResult;
		
	}
	
	public function getPermohonanUserSideAjax() {
		
		$data = rtrim(ltrim(str_replace("'","''",$this->data)));
		
		if (!empty($data)) {
				
		$select = new select("*","CAP_LAYAN",array(array("CAP_LAY_FINALSTATUS","!=","4"),array("CAP_LAY_TRANSACTIONID","=",$data)),"","CAP_LAY_DATECREATED ASC");
		
		}
		else {
		
		$select = new select("*","CAP_LAYAN",array(array("CAP_LAY_FINALSTATUS","!=",2),array("","OR",""),array("CAP_LAY_FINALSTATUS","!=",3),array("CAP_LAY_FINALSTATUS","!=",4),array("CAP_LAY_FINALSTATUS","!=",5)),"","CAP_LAY_DATECREATED ASC");
		
		}
				
		@$select->execute();
						
		return $select->arrayResult;
		
	}
	
	public function getPermohonanAdminSideAjax() {
		
		$data = rtrim(ltrim(str_replace("'","''",$this->data)));
		
		if (!empty($data)) {
				
		$select = new select("*","CAP_LAYAN",array(array("CAP_LAY_FINALSTATUS","!=","4"),array("CAP_LAY_TRANSACTIONID","=",$data)),"","CAP_LAY_DATECREATED ASC");
		
		}
		else {
		
		$select = new select("*","CAP_LAYAN",array(array("CAP_LAY_FINALSTATUS","=",1)),"","CAP_LAY_DATECREATED ASC");
		
		}
		
		@$select->execute();
		
		return $select->arrayResult;
		
	}
	
	public function getDocument($id) {
				
		$select = new select("*","CAP_LAYAN_DOCUMENT_REQUEST",array(array("FK_CAP_LAY_ID","=",$id)),"","");
		
		$select->execute();
		
		return $select->arrayResult;
		
	}
	
	public function getSingleDocument() {
				
		$select = new select("*","CAP_LAYAN_DOCUMENT_REQUEST",array(array("CAP_LAY_DOC_REQ_ID","=",$this->data)),"","");
		
		$select->execute();
		
		return $select->arrayResult[0];
		
	}
	
	//user counter
	
	public function geJobTerlampirByCountUser() {
				
		$select = new select("COUNT(CAP_LAY_ID)","CAP_LAYAN",array(array("CAP_LAY_FINALSTATUS","=","1")),"","");
		
		$select->execute();
		
		return $select->arrayResult[0];
		
	}
	
	public function gePotentialJobTerlampirByCountUser() {
		
		$select = new select("COUNT(CAP_LAY_ID)","CAP_LAYAN",array(array("CAP_LAY_FINALSTATUS","=","00")),"","");
		
		$select->execute();
		
		return $select->arrayResult[0];
		
	}
	
	public function getDocumentTerlampirByCountUser() {
				
		$select = new select("COUNT(FK_CAP_LAY_ID)",
				  "CAP_LAYAN_DOCUMENT_REQUEST 
				  LEFT JOIN CAP_LAYAN ON CAP_LAYAN_DOCUMENT_REQUEST.FK_CAP_LAY_ID = CAP_LAYAN.CAP_LAY_ID",
				  array(array("CAP_LAY_FINALSTATUS","=","1")),"","");
		
		$select->execute();
		
		return $select->arrayResult[0];
		
	}
	
	public function getDocumentTerlampirNotFinalByCountUser() {
				
		$select = new select("COUNT(FK_CAP_LAY_ID)",
				  "CAP_LAYAN_DOCUMENT_REQUEST 
				  LEFT JOIN CAP_LAYAN ON CAP_LAYAN_DOCUMENT_REQUEST.FK_CAP_LAY_ID = CAP_LAYAN.CAP_LAY_ID",
				  array(array("CAP_LAY_FINALSTATUS","=","00")),"","");
		
		$select->execute();
		
		return $select->arrayResult[0];
		
	}
	
	//admin counter
	
	public function geJobTerlampirByCount() {
				
		$select = new select("COUNT(CAP_LAY_ID)","CAP_LAYAN",array(array("CAP_LAY_FINALSTATUS","=","1")),"","");
		
		$select->execute();
		
		return $select->arrayResult[0];
		
	}
	
	public function gePotentialJobTerlampirByCount() {
		
		$select = new select("COUNT(CAP_LAY_ID)","CAP_LAYAN",array(array("CAP_LAY_FINALSTATUS","=","00")),"","");
		
		$select->execute();
		
		return $select->arrayResult[0];
		
	}
	
	public function getDocumentTerlampirByCount() {
				
		$select = new select("COUNT(FK_CAP_LAY_ID)",
				  "CAP_LAYAN_DOCUMENT_REQUEST 
				  LEFT JOIN CAP_LAYAN ON CAP_LAYAN_DOCUMENT_REQUEST.FK_CAP_LAY_ID = CAP_LAYAN.CAP_LAY_ID",
				  array(array("CAP_LAY_FINALSTATUS","=","1")),"","");
		
		$select->execute();
		
		return $select->arrayResult[0];
		
	}
	
	public function getDocumentTerlampirNotFinalByCount() {
				
		$select = new select("COUNT(FK_CAP_LAY_ID)",
				  "CAP_LAYAN_DOCUMENT_REQUEST 
				  LEFT JOIN CAP_LAYAN ON CAP_LAYAN_DOCUMENT_REQUEST.FK_CAP_LAY_ID = CAP_LAYAN.CAP_LAY_ID",
				  array(array("CAP_LAY_FINALSTATUS","=","00")),"","");
		
		$select->execute();
		
		return $select->arrayResult[0];
		
	}


	//Overview methods start

	public function getTotalDocumentByCountByID() {
				
		$select = new select("COUNT(FK_CAP_LAY_ID)","CAP_LAYAN_DOCUMENT_REQUEST",array(array("FK_CAP_LAY_ID","=",$this->data)),"","");
		
		$select->execute();

		return $select->arrayResult[0];
		
	}

	public function getPemberitahuanByCountByID() {
				
		$select = new select("COUNT(FK_CAP_LAY_ID)","CAP_LAYAN_PEMBERITAHUAN",array(array("FK_CAP_LAY_ID","=",$this->data)),"","");
		
		$select->execute();

		return $select->arrayResult[0];
		
	}

	public function getPenolakanByCountByID() {
				
		$select = new select("COUNT(FK_CAP_LAY_ID)","CAP_LAYAN_PENOLAKAN",array(array("FK_CAP_LAY_ID","=",$this->data)),"","");
		
		$select->execute();
		
		return $select->arrayResult[0];
		
	}

	public function getPerpanjanganByCountByID() {
				
		$select = new select("COUNT(FK_CAP_LAY_ID)","CAP_LAYAN_PERPANJANGAN",array(array("FK_CAP_LAY_ID","=",$this->data)),"","");
		
		$select->execute();
		return $select->arrayResult[0];
		
	}
	
	public function getKeberatanByCountByID() {
				
		$select = new select("COUNT(FK_CAP_LAY_ID)","CAP_LAYAN_KEBERATAN",array(array("FK_CAP_LAY_ID","=",$this->data)),"","");
		
		$select->execute();
		
		return $select->arrayResult[0];
		
	}

	public function getJobTerlampirByCountByID() {
				
		$select = new select("COUNT(CAP_LAY_ID)","CAP_LAYAN",array(array("CAP_LAY_LAMPIRAN","=","1"),array("CAP_LAY_FINALSTATUS","=","0")),"","");
		
		$select->execute();
		
		return $select->arrayResult[0];
		
	}
	
	public function getPotentialJobTerlampirByCountById() {
				
		$select = new select("COUNT(CAP_LAY_ID)","CAP_LAYAN",array(array("CAP_LAY_LAMPIRAN","=","0"),array("CAP_LAY_FINALSTATUS","=","0")),"","");
		
		$select->execute();
		
		return $select->arrayResult[0];
		
	}
	
	public function getDocumentTerlampirNotFinalByCountByID() {
				
		$select = new select("COUNT(FK_CAP_LAY_ID)",
				  "CAP_LAYAN_DOCUMENT_REQUEST 
				  LEFT JOIN CAP_LAYAN ON CAP_LAYAN_DOCUMENT_REQUEST.FK_CAP_LAY_ID = CAP_LAYAN.CAP_LAY_ID",
				  array(array("CAP_LAY_LAMPIRAN","=","0"),array("CAP_LAY_FINALSTATUS","=","0")),"","");
		
		$select->execute();
		
		return $select->arrayResult[0];
		
	}

	//End of overview methods


	
	public function getDocumentByCount($id) {
				
		$select = new select("COUNT(FK_CAP_LAY_ID) ","CAP_LAYAN_DOCUMENT_REQUEST",array(array("FK_CAP_LAY_ID","=",$id)),"","");
		
		$select->execute();
		
		return $select->arrayResult[0];
		
	}
	
	public function getTime($id) {
				
		$select = new select("TO_CHAR(CAP_LAY_DATECREATED, 'YYYY-MM-DD HH24:MI:SS') AS DATETIME","CAP_LAYAN",array(array("CAP_LAY_ID","=",$id)),"","");
		
		$select->execute();
		
		return $select->arrayResult[0];
		
	}

	public function getTimeByTable($id,$column) {
				
		$select = new select("TO_CHAR($id, 'YYYY-MM-DD HH24:MI:SS') AS DATETIME","$column","","","");
		
		$select->execute();
		
		return $select->arrayResult[0];
		
	}
	
	public function getDokumenLengkap() {
				
		$select = new select("*","CAP_LAYAN",array(array("CAP_LAY_ID","=",$this->data)),"","");
		
		$select->execute();
				
		return $select->arrayResult[0];
		
	}


	
	public function getDokumenList($id) {
		
		$select = new select("*","CAP_LAYAN_DOCUMENT_REQUEST",array(array("FK_CAP_LAY_ID","=",$id)),"","");
		
		$select->execute();
		
		return $select->arrayResult;
		
	}

	public function getDokumenPemberitahuanList($id) {
		
		$select = new select("*","CAP_LAYAN_PEMBERITAHUAN_DOC LEFT JOIN CAP_LAYAN_DOCUMENT_REQUEST ON CAP_LAYAN_DOCUMENT_REQUEST.CAP_LAY_DOC_REQ_ID = CAP_LAYAN_PEMBERITAHUAN_DOC.FK_CAP_LAY_DOC_REQ_ID",array(array("CAP_LAYAN_PEMBERITAHUAN_DOC.FK_CAP_LAY_PEM_ID","=",$id)),"","");
		
		$select->execute();
		
		return $select->arrayResult;
		
	}

	public function getDokumenPerpanjanganList($id) {
		
		$select = new select("*","CAP_LAYAN_PERPANJANGAN_DOC LEFT JOIN CAP_LAYAN_DOCUMENT_REQUEST ON CAP_LAYAN_DOCUMENT_REQUEST.CAP_LAY_DOC_REQ_ID = CAP_LAYAN_PERPANJANGAN_DOC.FK_CAP_LAY_DOC_REQ_ID",array(array("CAP_LAYAN_PERPANJANGAN_DOC.FK_CAP_LAY_PER_ID","=",$id)),"","");
		
		$select->execute();
		
		return $select->arrayResult;
		
	}

	public function getDokumenPenolakanList($id) {
		
		$select = new select("*","CAP_LAYAN_PENOLAKAN_DOC LEFT JOIN CAP_LAYAN_DOCUMENT_REQUEST ON CAP_LAYAN_DOCUMENT_REQUEST.CAP_LAY_DOC_REQ_ID = CAP_LAYAN_PENOLAKAN_DOC.FK_CAP_LAY_DOC_REQ_ID",array(array("CAP_LAYAN_PENOLAKAN_DOC.FK_CAP_LAY_PEN_ID","=",$id)),"","");
		
		$select->execute();
		
		return $select->arrayResult;
		
	}

	public function getLayanPemberitahuanDocument($id) {

		$select = new select("*","CAP_LAYAN_PEMBERITAHUAN_DOC",array(array("FK_CAP_LAY_DOC_REQ_ID","=",$id)),"","");
		
		$select->execute();

		return $select->arrayResult;

	}

	public function getLayanPenolakanDocument($id) {

		$select = new select("*","CAP_LAYAN_PENOLAKAN_DOC",array(array("FK_CAP_LAY_DOC_REQ_ID","=",$id)),"","");
		
		$select->execute();

		return $select->arrayResult;

	}

	public function getLayanPerpanjanganDocument($id,$idPerpanjangan) {

		$select = new select("*","CAP_LAYAN_PERPANJANGAN_DOC LEFT JOIN CAP_LAYAN_PERPANJANGAN ON CAP_LAYAN_PERPANJANGAN_DOC.FK_CAP_LAY_PER_ID = CAP_LAYAN_PERPANJANGAN.CAP_LAY_PER_ID",array(array("CAP_LAYAN_PERPANJANGAN_DOC.FK_CAP_LAY_DOC_REQ_ID","=","$id"),array("CAP_LAYAN_PERPANJANGAN_DOC.FK_CAP_LAY_PER_ID","=",$idPerpanjangan)),"","");

		$select->execute();
		
		return $select->arrayResult;

	}

	public function getLayanKeberatanDocument($id,$fkid,$type) {

		if ($type == 'pemberitahuan') {

		$select = new select("*","CAP_LAYAN_KEBERATAN_DOC LEFT JOIN CAP_LAYAN_KEBERATAN ON CAP_LAYAN_KEBERATAN_DOC.FK_CAP_LAY_KEB_ID = CAP_LAYAN_KEBERATAN.CAP_LAY_KEB_ID WHERE",array(array("CAP_LAYAN_KEBERATAN_DOC.FK_CAP_LAY_KEB_ID","=",$id),array("CAP_LAYAN_KEBERATAN_DOC.FK_CAP_LAY_PEM_ID","=",$fkid)),"","");

		}
		else if ($type == 'penolakan') {
		
		$select = new select("*","CAP_LAYAN_KEBERATAN_DOC LEFT JOIN CAP_LAYAN_KEBERATAN ON CAP_LAYAN_KEBERATAN_DOC.FK_CAP_LAY_KEB_ID = CAP_LAYAN_KEBERATAN.CAP_LAY_KEB_ID WHERE",array(array("CAP_LAYAN_KEBERATAN_DOC.FK_CAP_LAY_KEB_ID","=",$id),array("CAP_LAYAN_KEBERATAN_DOC.FK_CAP_LAY_PEN_ID","=",$fkid)),"","");

		}
		else if ($type == 'perpanjangan') {
		
		$select = new select("*","CAP_LAYAN_KEBERATAN_DOC LEFT JOIN CAP_LAYAN_KEBERATAN ON CAP_LAYAN_KEBERATAN_DOC.FK_CAP_LAY_KEB_ID = CAP_LAYAN_KEBERATAN.CAP_LAY_KEB_ID WHERE",array(array("CAP_LAYAN_KEBERATAN_DOC.FK_CAP_LAY_KEB_ID","=",$id),array("CAP_LAYAN_KEBERATAN_DOC.FK_CAP_LAY_PER_ID","=",$fkid)),"","");

		}
		else if ($type == 'permohonan') {
		
		$select = new select("*","CAP_LAYAN_KEBERATAN_DOC LEFT JOIN CAP_LAYAN_KEBERATAN ON CAP_LAYAN_KEBERATAN_DOC.FK_CAP_LAY_KEB_ID = CAP_LAYAN_KEBERATAN.CAP_LAY_KEB_ID WHERE",array(array("CAP_LAYAN_KEBERATAN_DOC.FK_CAP_LAY_KEB_ID","=",$id),array("CAP_LAYAN_KEBERATAN_DOC.FK_CAP_LAY_ID","=",$fkid)),"","");

		}
		
		$select->execute();

		return $select->arrayResult;

	}

	public function getLayanKeberatanDocumentFiltered($id,$fkid,$type) {

		if ($type == 'pemberitahuan') {

		$select = new select("*","CAP_LAYAN_KEBERATAN_DOC LEFT JOIN CAP_LAYAN_KEBERATAN ON CAP_LAYAN_KEBERATAN_DOC.FK_CAP_LAY_KEB_ID = CAP_LAYAN_KEBERATAN.CAP_LAY_KEB_ID",array(array("CAP_LAYAN_KEBERATAN_DOC.FK_CAP_LAY_PEM_ID","=",$fkid)),"","");

		}
		else if ($type == 'penolakan') {

		$select = new select("*","CAP_LAYAN_KEBERATAN_DOC LEFT JOIN CAP_LAYAN_KEBERATAN ON CAP_LAYAN_KEBERATAN_DOC.FK_CAP_LAY_KEB_ID = CAP_LAYAN_KEBERATAN.CAP_LAY_KEB_ID",array(array("CAP_LAYAN_KEBERATAN_DOC.FK_CAP_LAY_PEN_ID","=",$fkid)),"","");

		}
		else if ($type == 'perpanjangan') {

		$select = new select("*","CAP_LAYAN_KEBERATAN_DOC LEFT JOIN CAP_LAYAN_KEBERATAN ON CAP_LAYAN_KEBERATAN_DOC.FK_CAP_LAY_KEB_ID = CAP_LAYAN_KEBERATAN.CAP_LAY_KEB_ID",array(array("CAP_LAYAN_KEBERATAN_DOC.FK_CAP_LAY_PER_ID","=",$fkid)),"","");

		}
		else if ($type == 'permohonan') {

		$select = new select("*","CAP_LAYAN_KEBERATAN_DOC LEFT JOIN CAP_LAYAN_KEBERATAN ON CAP_LAYAN_KEBERATAN_DOC.FK_CAP_LAY_KEB_ID = CAP_LAYAN_KEBERATAN.CAP_LAY_KEB_ID",array(array("CAP_LAYAN_KEBERATAN_DOC.FK_CAP_LAY_ID","=",$fkid)),"","");

		}
		
		$select->execute();

		return $select->arrayResult;

	}

	public function getLayanPerpanjanganDocumentOverview($id,$value) {

		$select = new select("*","CAP_LAYAN_PERPANJANGAN_DOC",array(array("FK_CAP_LAY_DOC_REQ_ID","=",$id),array("FK_CAP_LAY_PER_ID","=",$value)),"","");

		$select->execute();

		return $select->arrayResult;

	}

	public function getLayanPenolakanDocumentOverview($id,$value) {

		$select = new select("*","CAP_LAYAN_PENOLAKAN_DOC",array(array("FK_CAP_LAY_DOC_REQ_ID","=",$id),array("FK_CAP_LAY_PEN_ID","=",$value)),"","");

		$select->execute();

		return $select->arrayResult;

	}

	public function getDateBeforeThisPerpanjanganOverview($id,$date,$document) {

		$select = new select("*","CAP_LAYAN_PERPANJANGAN LEFT JOIN CAP_LAYAN_PERPANJANGAN_DOC ON CAP_LAYAN_PERPANJANGAN.CAP_LAY_PER_ID = CAP_LAYAN_PERPANJANGAN_DOC.FK_CAP_LAY_PER_ID",array(array("FK_CAP_LAY_ID","=",$id),array("FK_CAP_LAY_DOC_REQ_ID","=",$document),array("CAP_LAY_PER_DATE_TO","<",$date)),"","CAP_LAY_PER_DATE_TO DESC");

		$select->execute();

		return $select->arrayResult;

	}

	public function getLayanPemberitahuanDocumentOverview($id,$value) {

		$select = new select("*","CAP_LAYAN_PEMBERITAHUAN_DOC",array(array("FK_CAP_LAY_DOC_REQ_ID","=",$id),array("FK_CAP_LAY_PEM_ID","=",$value)),"","");

		$select->execute();

		return $select->arrayResult;

	}

	public function getPermohonanDocumentlistByID($id) {

		$select = new select("FK_CAP_LAY_DOC_REQ_ID","CAP_LAYAN_PEMBERITAHUAN_DOC",array(array("FK_CAP_LAY_PEM_ID","=",$id)),"","");
		
		$select->execute();

			if (!empty($select->arrayResult)) {

				foreach ($select->arrayResult as $key => $value) {

				$result [] = $value['FK_CAP_LAY_DOC_REQ_ID'];

				}

			}

		return $result;

	}

	public function getPenolakanDocumentlistByID($id) {

		$select = new select("FK_CAP_LAY_DOC_REQ_ID","CAP_LAYAN_PENOLAKAN_DOC",array(array("FK_CAP_LAY_PEN_ID","=",$id)),"","");
		
		$select->execute();

			if (!empty($select->arrayResult)) {

				foreach ($select->arrayResult as $key => $value) {

				$result [] = $value['FK_CAP_LAY_DOC_REQ_ID'];

				}

			}

		return $result;

	}

	public function getPerpanjanganDocumentlistByID($id) {

		$select = new select("FK_CAP_LAY_DOC_REQ_ID","CAP_LAYAN_PERPANJANGAN_DOC",array(array("FK_CAP_LAY_PER_ID","=",$id)),"","");
		
		$select->execute();

			if (!empty($select->arrayResult)) {

				foreach ($select->arrayResult as $key => $value) {

				$result [] = $value['FK_CAP_LAY_DOC_REQ_ID'];

				}

			}

		return $result;

	}

	public function getKeberatanDocumentlistByID($id) {

		$select = new select("*","CAP_LAYAN_KEBERATAN_DOC",array(array("FK_CAP_LAY_KEB_ID","=",$id)),"","");
		
		$select->execute();

			if (!empty($select->arrayResult)) {

				foreach ($select->arrayResult as $key => $value) {

					if (!empty($value['FK_CAP_LAY_ID'])) {

						$result ['permohonan'][] = $value['FK_CAP_LAY_ID'];

					}
					else if (!empty($value['FK_CAP_LAY_PEM_ID'])) {

						$result ['pemberitahuan'][] = $value['FK_CAP_LAY_PEM_ID'];
						
					}
					else if (!empty($value['FK_CAP_LAY_PEN_ID'])) {

						$result ['penolakan'][] = $value['FK_CAP_LAY_PEN_ID'];
						
					}
					else if (!empty($value['FK_CAP_LAY_PER_ID'])) {

						$result ['perpanjangan'][] = $value['FK_CAP_LAY_PER_ID'];
						
					}

				}

			}

		return $result;

	}

	public function getSejarahByPermohonanID() {
		
		$selectDate = new select("TO_CHAR(CAP_LAY_HIS_DATECREATED, 'YYYY-MM-DD') AS DATETIME,COUNT(*)","CAP_LAYAN_HISTORY WHERE FK_CAP_LAY_ID = '".$this->data."' AND CAP_LAY_HIS_DATECREATED >= NOW() - '7 day'::INTERVAL GROUP BY TO_CHAR(CAP_LAY_HIS_DATECREATED, 'YYYY-MM-DD') ORDER BY TO_CHAR(CAP_LAY_HIS_DATECREATED, 'YYYY-MM-DD') DESC","","","");

		$selectDate->execute();

		$select = new select("TO_CHAR(CAP_LAY_HIS_DATECREATED, 'YYYY-MM-DD HH24:MI:SS') AS DATETIME, TO_CHAR(CAP_LAY_HIS_DATECREATED, 'YYYY-MM-DD') AS GROUPING, CAP_LAY_HIS_TEXT, FK_CAP_USE_ID, FK_CAP_LAY_ID","CAP_LAYAN_HISTORY WHERE FK_CAP_LAY_ID = '".$this->data."' AND CAP_LAY_HIS_DATECREATED >= NOW() - '7 day'::INTERVAL ORDER BY TO_CHAR(CAP_LAY_HIS_DATECREATED, 'YYYY-MM-DD') DESC","","","");

		$select->execute();

		if (!empty($selectDate->arrayResult)) {

			foreach ($selectDate->arrayResult as $key => $value) {

				$dateGroup = $value['DATETIME'];

				foreach ($select->arrayResult as $key2 => $value2) {

					if ($value['DATETIME'] == $value2['GROUPING']) {

					$dateValue [] = array("DATETIME" => $value2['DATETIME'], "CAP_LAY_HIS_TEXT" => $value2['CAP_LAY_HIS_TEXT'], "FK_CAP_USE_ID" => $value2['FK_CAP_USE_ID'], "FK_CAP_LAY_ID" => $value2['FK_CAP_LAY_ID']);

					}

				}

			$finalGroup [] = array("DATE" => $dateGroup, "VALUE" => $dateValue);

			unset($dateValue);

			}

		}

		return $finalGroup;

	}
	
	public function getSejarahAllPermohonan() {

		$selectDate = new select("TO_CHAR(CAP_LAY_HIS_DATECREATED, 'YYYY-MM-DD') AS DATETIME,COUNT(*)","CAP_LAYAN_HISTORY WHERE CAP_LAY_HIS_DATECREATED >= NOW() - '7 day'::INTERVAL GROUP BY TO_CHAR(CAP_LAY_HIS_DATECREATED, 'YYYY-MM-DD') ORDER BY TO_CHAR(CAP_LAY_HIS_DATECREATED, 'YYYY-MM-DD') DESC","","","");

		$selectDate->execute();

		$select = new select("TO_CHAR(CAP_LAY_HIS_DATECREATED, 'YYYY-MM-DD HH24:MI:SS') AS DATETIME, TO_CHAR(CAP_LAY_HIS_DATECREATED, 'YYYY-MM-DD') AS GROUPING, CAP_LAY_HIS_TEXT, FK_CAP_USE_ID, FK_CAP_LAY_ID","CAP_LAYAN_HISTORY WHERE CAP_LAY_HIS_DATECREATED >= NOW() - '7 day'::INTERVAL ORDER BY CAP_LAY_HIS_DATECREATED DESC","","","");

		$select->execute();
		//print_r($selectDate->arrayResult);
		if (!empty($selectDate->arrayResult)) {

			foreach ($selectDate->arrayResult as $key => $value) {

				$dateGroup = $value['DATETIME'];

				foreach ($select->arrayResult as $key2 => $value2) {

					if ($value['DATETIME'] == $value2['GROUPING']) {

					$dateValue [] = array("DATETIME" => $value2['DATETIME'], "CAP_LAY_HIS_TEXT" => $value2['CAP_LAY_HIS_TEXT'], "FK_CAP_USE_ID" => $value2['FK_CAP_USE_ID'], "FK_CAP_LAY_ID" => $value2['FK_CAP_LAY_ID']);

					}

				}

			$finalGroup [] = array("DATE" => $dateGroup, "VALUE" => $dateValue);

			unset($dateValue);

			}

		}

		return $finalGroup;

	}
	
	public function getSejarahPermohonanByUser() {
		
		$user 	= unserialize($_SESSION['user']); $this->data = $user->getID();
		
		$selectDate = new select("TO_CHAR(CAP_LAY_HIS_DATECREATED, 'YYYY-MM-DD') AS DATETIME,COUNT(*)","CAP_LAYAN_HISTORY WHERE FK_CAP_USE_ID = '".$this->data."' AND CAP_LAY_HIS_DATECREATED >= NOW() - '7 day'::INTERVAL GROUP BY TO_CHAR(CAP_LAY_HIS_DATECREATED, 'YYYY-MM-DD') ORDER BY TO_CHAR(CAP_LAY_HIS_DATECREATED, 'YYYY-MM-DD') DESC","","","");

		$selectDate->execute();

		$select = new select("TO_CHAR(CAP_LAY_HIS_DATECREATED, 'YYYY-MM-DD HH24:MI:SS') AS DATETIME, TO_CHAR(CAP_LAY_HIS_DATECREATED, 'YYYY-MM-DD') AS GROUPING, CAP_LAY_HIS_TEXT, FK_CAP_USE_ID, FK_CAP_LAY_ID","CAP_LAYAN_HISTORY WHERE FK_CAP_USE_ID = '".$this->data."' AND CAP_LAY_HIS_DATECREATED >= NOW() - '7 day'::INTERVAL ORDER BY TO_CHAR(CAP_LAY_HIS_DATECREATED, 'YYYY-MM-DD') DESC","","","");

		$select->execute();
		
		if (!empty($selectDate->arrayResult)):

			foreach ($selectDate->arrayResult as $key => $value):

				$dateGroup = $value['DATETIME'];

				foreach ($select->arrayResult as $key2 => $value2):

					if ($value['DATETIME'] == $value2['GROUPING']):

					$dateValue [] = array("DATETIME" => $value2['DATETIME'], "CAP_LAY_HIS_TEXT" => $value2['CAP_LAY_HIS_TEXT'], "FK_CAP_USE_ID" => $value2['FK_CAP_USE_ID'], "FK_CAP_LAY_ID" => $value2['FK_CAP_LAY_ID']);

					endif;

				endforeach;

			$finalGroup [] = array("DATE" => $dateGroup, "VALUE" => $dateValue);

			unset($dateValue);

			endforeach;

		endif;

		return $finalGroup;

	}
	
	public function getPermohonanByID($id) {
		
		$select = new select("*","CAP_LAYAN",array(array("CAP_LAY_ID","=",$id)),"","");
		
		$select->execute();
		
		return $select->arrayResult;
	
	}

	public function getPermohonanFilePath() {

		$select = new select("*","CAP_LAYAN",array(array("CAP_LAY_ID","=",$this->data)),"","");
		
		$select->execute();
		
		return $select->arrayResult[0]['CAP_LAY_FILE_PATH'];

	}

	public function getTipePemohon() {
		
		$select = new select("*",
		"CAP_LAYAN_DATASTORE 
		LEFT JOIN CAP_LAYAN_DATASTORE_TYPE ON CAP_LAYAN_DATASTORE.CAP_LAY_DAT_TYPE = CAP_LAYAN_DATASTORE_TYPE.CAP_LAY_DAT_TYP_ID",
		array(array("CAP_LAYAN_DATASTORE_TYPE.CAP_LAY_DAT_TYP_NAME","=","TIPE PEMOHON"),array("CAP_LAYAN_DATASTORE.CAP_LAY_DAT_STATUS","=","1")),"","CAP_LAY_DAT_POSITION ASC");
		
		$select->execute();
		
		return $select->arrayResult;
		
	}
	
	public function getInformation() {
		
		$select = new select("*",
		"CAP_LAYAN_DATASTORE 
		LEFT JOIN CAP_LAYAN_DATASTORE_TYPE ON CAP_LAYAN_DATASTORE.CAP_LAY_DAT_TYPE = CAP_LAYAN_DATASTORE_TYPE.CAP_LAY_DAT_TYP_ID",
		array(array("CAP_LAYAN_DATASTORE_TYPE.CAP_LAY_DAT_TYP_NAME","=","CARA MEMPEROLEH INFORMASI"),array("CAP_LAYAN_DATASTORE.CAP_LAY_DAT_STATUS","=","1")),"","CAP_LAY_DAT_POSITION ASC");
		
		$select->execute();
		
		return $select->arrayResult;
		
	}
	
	public function getSalinan() {
		
		$select = new select("*",
		"CAP_LAYAN_DATASTORE 
		LEFT JOIN CAP_LAYAN_DATASTORE_TYPE ON CAP_LAYAN_DATASTORE.CAP_LAY_DAT_TYPE = CAP_LAYAN_DATASTORE_TYPE.CAP_LAY_DAT_TYP_ID",
		array(array("CAP_LAYAN_DATASTORE_TYPE.CAP_LAY_DAT_TYP_NAME","=","CARA MENDAPATKAN SALINAN INFORMASI"),array("CAP_LAYAN_DATASTORE.CAP_LAY_DAT_STATUS","=","1")),"","CAP_LAY_DAT_POSITION ASC");
		
		$select->execute();
		
		return $select->arrayResult;
		
	}

	public function getDocumentPemberitahuanCheck($id) {

		$select = new select("*","CAP_LAYAN_PEMBERITAHUAN_DOC",array(array("FK_CAP_LAY_DOC_REQ_ID","=",$id)),"","");

		$select->execute();

		return $select->arrayResult;

	}

	public function getDocumentPenolakanCheck($id) {

		$select = new select("*","CAP_LAYAN_PENOLAKAN_DOC",array(array("FK_CAP_LAY_DOC_REQ_ID","=",$id)),"","");

		$select->execute();

		return $select->arrayResult;

	}

	public function getAllHolidayDateGrouping() {

		$select = new select("*","CAP_LAYAN_CALENDAR","","","CAP_LAY_CAL_DATE ASC");

		$select->execute();

		$holiday = $select->arrayResult;

			$groupHoliday = array();

			foreach ($holiday as $value) {

				$i = 0;

				foreach ($holiday as $value2) {

					if ($value['CAP_LAY_CAL_GROUP'] == $value2['CAP_LAY_CAL_GROUP']) {
						$i++;
					}

				}

				if (@!in_array($value['CAP_LAY_CAL_GROUP'], $whiteList)) {

				$groupHoliday [] = array(

								   "CAP_LAY_CAL_ID" => $value['CAP_LAY_CAL_ID'],
								   "CAP_LAY_CAL_DATE" => $value['CAP_LAY_CAL_DATE'],
								   "CAP_LAY_CAL_DESCRIPTION" => $value['CAP_LAY_CAL_DESCRIPTION'],
								   "CAP_LAY_CAL_GROUP" => $value['CAP_LAY_CAL_GROUP'],
								   "COUNT" => $i

								   );

				$whiteList [] = $value['CAP_LAY_CAL_GROUP'];

				}

			}

		return $groupHoliday;

	}

	public function getAllHolidayDate() {

		$select = new select("*","CAP_LAYAN_CALENDAR","","","CAP_LAY_CAL_DATE ASC");

		$select->execute();

		return $select->arrayResult;

	}

	public function getHolidayDate($from,$to) {

		$select = new select("*","CAP_LAYAN_CALENDAR",array(array("CAP_LAY_CAL_DATE::DATE",">=",$from),array("CAP_LAY_CAL_DATE::DATE","<=",$to)),"","CAP_LAY_CAL_DATE ASC");

		$select->execute();
				
		return $select->arrayResult;

	}

	public function getEndDatePermohonan($permohonanDate,$holidayDate) {

	$time = new time(null);

		if (!empty($holidayDate)) {

				foreach ($holidayDate as $value) {

					$holidayArray [] = date("Y-m-d",strtotime($value['CAP_LAY_CAL_DATE']));

				}

			}

		$endDate = $time->addDays(strtotime($permohonanDate),18,array("Saturday", "Sunday"),$holidayArray);

		return date("Y-m-d",$endDate);

	}

	public function getHolidayArrayNoWeekdays($holidayDate,$endDate) {

	if (!empty($holidayDate)) {

		foreach ($holidayDate as $value) {

			if (strtotime($value['CAP_LAY_CAL_DATE']) > strtotime($endDate)) {

				break;

			} 

			$weekDay = date('w', strtotime($value['CAP_LAY_CAL_DATE']));

			if ($weekDay != 0 && $weekDay != 6) {

				$holidayArray [] = date("Y-m-d",strtotime($value['CAP_LAY_CAL_DATE']));

				}

			}

		}

	return $holidayArray;

	}

	public function getIndonesianHolidayDatePicker($holidayDate,$endDate) {

	if (!empty($holidayDate)) {

		foreach ($holidayDate as $value) {

			if (strtotime($value['CAP_LAY_CAL_DATE']) > strtotime($endDate)) {

				break;

			} 

			$weekDay = date('w', strtotime($value['CAP_LAY_CAL_DATE']));

			if ($weekDay != 0 && $weekDay != 6) {

				$dateValue = date("Y-m-d",strtotime($value['CAP_LAY_CAL_DATE']));

				$dateValue = new DateTime($dateValue);

				$year  = $dateValue->format("Y");

				$month = $dateValue->format("m"); $month -= 1;

				$day   = $dateValue->format("d");

				$IndonesianHoliday .= "new Date(".$year.", ".$month.", ".$day.").getTime(),";

				}

			}

		}

	$IndonesianHoliday = substr($IndonesianHoliday, 0, -1);

	return $IndonesianHoliday;

	}

	public function getMaxDatePicker($permohonanDate,$holidayArray,$endDate,$days) {

		$time = new time(null);

		$endDate = $time->addDays(strtotime($permohonanDate),17,array("Saturday", "Sunday"),$holidayArray);

		$endDate = date("Y-m-d",$endDate);

		$numberOfDays = $time->getWorkingDays($permohonanDate,$endDate,$holidayArray);

		$dateA = new DateTime($permohonanDate);
				
		$dateB = new DateTime($endDate);
		
		$intervalA = $dateA->diff($dateB);
		
		$AddHoliday = count($holidayArray);

		$maxDate = $intervalA->format('%d');

		$maxDate = ($maxDate-$days)+$AddHoliday;

	return $maxDate;

	}

	public function getMaxDatePickerDate($permohonanDate,$maxDate,$days) {

		$addDateTo = strtotime ( '+'.$maxDate+$days.' day' , strtotime ( $permohonanDate ) ) ;

		$addDateTo = date ( 'Y-m-d' , $addDateTo );

	return $addDateTo;

	}

	public function getMaxDatePickerNormal($permohonanDate,$holidayArray,$endDate,$days) {

		$time = new time(null);
				
		$endDate = $time->addDaysPlusHolidays(strtotime($permohonanDate),10,array("Saturday", "Sunday"),$holidayArray);

		$endDate = date("Y-m-d",$endDate);

	return $endDate;

	}

	public function getMaxDatePickerNormalNumber($permohonanDate,$holidayArray,$endDate,$days) {

		$time = new time(null);

		$workingDays = $time->getWorkingDays(date("y-m-d H:i:s",strtotime($permohonanDate)),date("y-m-d H:i:s",strtotime($endDate)),$holidayArray);

	return $workingDays-1;

	}

	public function getTimeLimitPermohonan() {

		$select = new select("*","CAP_LAYAN",array(array("CAP_LAY_ID","=",$this->data)),"","");

		$select->execute();

		$permohonanID = $select->arrayResult[0]['CAP_LAY_ID'];

		$selectDate = new select("*","CAP_LAYAN_PERPANJANGAN",array(array("FK_CAP_LAY_ID","=",$permohonanID)),"","CAP_LAY_PER_DATE_TO DESC");

		$selectDate->execute();

		$tanggalPerpanjangan = $selectDate->arrayResult[0]['CAP_LAY_PER_DATE_TO'];

			if (empty($tanggalPerpanjangan)) {

			$permohonanDate = date("Y-m-d",strtotime($select->arrayResult[0]['CAP_LAY_DATECREATED']));

			$holidayDate = $this->getHolidayDate($permohonanDate,date("Y-12-31")); 
			
			$endDate = $this->getEndDatePermohonan($permohonanDate,$holidayDate);

			$holidayArray = $this->getHolidayArrayNoWeekdays($holidayDate,$endDate);
						
			$maxDate = $this->getMaxDatePickerNormal($permohonanDate,$holidayArray,$endDate,$days);

			return $maxDate;

			}
			else {

			return $tanggalPerpanjangan;

			}

	}

	public function getPermohonanAttachment() {

		$fileArray = array();

		$select = new select("*","CAP_LAYAN",array(array("CAP_LAY_ID","=",$this->data)),"","");

		$select->execute();

		$absolutePath = $select->arrayResult[0]['CAP_LAY_FILE_PATH'];

		$path = explode("/",$absolutePath);

			if (file_exists($absolutePath."/1-FOTO/1-FOTO.pdf")) {
			$file ['FOTO'] = "library/capsule/layan/data/".$path[8]."/1-FOTO/1-FOTO.pdf";
			}
			else if (file_exists($absolutePath."/1-FOTO/1-FOTO.jpg")) {
			$file ['FOTO'] = "library/capsule/layan/data/".$path[8]."/1-FOTO/1-FOTO.jpg";
			}

			if (file_exists($absolutePath."/2-KTP/2-KTP.pdf")) {
			$file ['KTP'] = "library/capsule/layan/data/".$path[8]."/2-KTP/2-KTP.pdf";
			}
			else if (file_exists($absolutePath."/2-KTP/2-KTP.jpg")) {
			$file ['KTP'] = "library/capsule/layan/data/".$path[8]."/2-KTP/2-KTP.jpg";
			}

			if (file_exists($absolutePath."/3-AKTA/3-AKTA.pdf")) {
			$file ['AKTA'] = "library/capsule/layan/data/".$path[8]."/3-AKTA/3-AKTA.pdf";
			}
			else if (file_exists($absolutePath."/3-AKTA/3-AKTA.jpg")) {
			$file ['AKTA'] = "library/capsule/layan/data/".$path[8]."/3-AKTA/3-AKTA.jpg";
			}

			if (file_exists($absolutePath."/4-KUASA/4-KUASA.pdf")) {
			$file ['SURAT KUASA'] = "library/capsule/layan/data/".$path[8]."/4-KUASA/4-KUASA.pdf";
			}
			else if (file_exists($absolutePath."/4-KUASA/4-KUASA.jpg")) {
			$file ['SURAT KUASA'] = "library/capsule/layan/data/".$path[8]."/4-KUASA/4-KUASA.jpg";
			}

			if (file_exists($absolutePath."/5-KTP-KUASA/5-KTP-KUASA.pdf")) {
			$file ['KTP PEMBAWA KUASA'] = "library/capsule/layan/data/".$path[8]."/5-KTP-KUASA/5-KTP-KUASA.pdf";
			}
			else if (file_exists($absolutePath."/5-KTP-KUASA/5-KTP-KUASA.jpg")) {
			$file ['KTP PEMBAWA KUASA'] = "library/capsule/layan/data/".$path[8]."/5-KTP-KUASA/5-KTP-KUASA.jpg";
			}

			if (file_exists($absolutePath."/6-NPWP/6-NPWP.pdf")) {
			$file ['NPWP'] = "library/capsule/layan/data/".$path[8]."/6-NPWP/6-NPWP.pdf";
			}
			else if (file_exists($absolutePath."/6-NPWP/6-NPWP.jpg")) {
			$file ['NPWP'] = "library/capsule/layan/data/".$path[8]."/6-NPWP/6-NPWP.jpg";
			}

		return $file;

	}

	public function getTimeForDocument($id) {

		$select = new select("*","CAP_LAYAN_PERPANJANGAN_DOC LEFT JOIN CAP_LAYAN_PERPANJANGAN ON CAP_LAYAN_PERPANJANGAN_DOC.FK_CAP_LAY_PER_ID = CAP_LAYAN_PERPANJANGAN.CAP_LAY_PER_ID",array(array("CAP_LAYAN_PERPANJANGAN_DOC.FK_CAP_LAY_DOC_REQ_ID","=",$id)),"","CAP_LAYAN_PERPANJANGAN.CAP_LAY_PER_DATE_TO DESC");

		$select->execute();

		return $select->arrayResult;

	}

	public function checkEndTime() {

		$select = new select("*","CAP_LAYAN",array(array("CAP_LAY_ID","=",$this->data)),"","");

		$select->execute();

		return $select->arrayResult[0]['CAP_LAY_DATESTOPPED'];

	}

	public function getCurrentTime($startDate,$endDate) {
				
		$date1 = new DateTime($startDate);
		
		$date3 = date("Y-m-d",strtotime($endDate));

		$date2 = new DateTime($endDate);
		
		$interval = $date1->diff($date2);
				    		    
		$days = $interval->days;
		
		$holidayDate = $this->getHolidayDate($date3,date("Y-12-31"));

		$holidayArray = $this->getHolidayArrayNoWeekdays($holidayDate,$startDate);

		$c = count($holidayArray);
		
		$diff = strtotime($endDate) - strtotime(date("Y-m-d 00:00:00",strtotime($endDate)));

		$time;
						
			for ($i = 1; $i <= $days+1; $i++) {

				$newDate = strtotime($date3)+86400*$i;
								
					if (date('w',$newDate) == 6 || date('w',$newDate) == 0) {
						$z++;
					}
								

			}

		return $days-$z-$c;

	}
	
	public function getCurrentTimeOverviewStyle($startDate,$endDate) {
				
		$date1 = new DateTime($startDate);
		
		$date3 = date("Y-m-d",strtotime($endDate));
		
		$date4 = date("Y-m-d",strtotime($startDate));

		$date2 = new DateTime($endDate);
		
		$interval = $date1->diff($date2);
				    		    
		$days = $interval->days;
		
		$holidayDate = $this->getHolidayDate($date4,date("Y-12-31"));
		
		$holidayArray = $this->getHolidayArrayNoWeekdays($holidayDate,$endDate);

		$c = count($holidayArray);
		
		$diff = strtotime($endDate) - strtotime(date("Y-m-d 00:00:00",strtotime($endDate)));

		$time;
						
			for ($i = 1; $i <= $days+1; $i++) {

				$newDate = strtotime($date4)+86400*$i;
								
					if (date('w',$newDate) == 6 || date('w',$newDate) == 0) {
						$z++;
					}
								

			}

		return $days-$z-$c;

	}
	
	public function getCurrentHolidayDateTimeDashboard($startDate,$endDate) {

		$date1 = new DateTime($startDate);
		
		$date3 = $endDate;
		
		$date2 = new DateTime($date3);
		
		$interval = $date1->diff($date2);
				    		    
		$days = $interval->days;

		$holidayDate = $this->getHolidayDate(date("Y-m-d",strtotime($endDate)),date("Y-12-31"));

		$holidayArray = $this->getHolidayArrayNoWeekdays($holidayDate,date("Y-m-d",strtotime($startDate)));

		$c = count($holidayArray);

			for ($i = 1; $i <= $days+1; $i++) {

				$newDate = strtotime($endDate)+86400*$i;

				if (date('w',$newDate) == 6 || date('w',$newDate) == 0) {
					$z++;
				}

			}

		return $z+$c;

	}
	
	public function getCurrentHolidayDateTime($startDate,$endDate) {

		$date1 = new DateTime($startDate);
		
		$date3 = $endDate;
		
		$date2 = new DateTime($date3);
		
		$interval = $date1->diff($date2);
				    		    
		$days = $interval->days;

		$holidayDate = $this->getHolidayDate($endDate,date("Y-12-31"));

		$holidayArray = $this->getHolidayArrayNoWeekdays($holidayDate,$startDate);

		$c = count($holidayArray);

			for ($i = 1; $i <= $days+1; $i++) {

				$newDate = strtotime($endDate)+86400*$i;

				if (date('w',$newDate) == 6 || date('w',$newDate) == 0) {
					$z++;
				}

			}

		return $days+$z+$c;

	}
	
	public function saveDokumen($id) {
		
		foreach ($id as $key => $value) {
		
		$update = new update(array("CAP_LAY_DOC_REQ_STATUS" => $value[1], "CAP_LAY_DOC_REQ_COMMENT" => $value[2]),"CAP_LAYAN_DOCUMENT_REQUEST",array(array("CAP_LAY_DOC_REQ_ID","=",$value[0])),"","");
		
		$update->execute();
		
		}		
		
	}
	
	public function saveHoliday($id) {
		
			if (!empty($id['delete'])) {

				$delete = substr($id['delete'], 0, -1);

				$delete = explode(",",$delete);

					if (!empty($delete)) {

						$del = new delete("","CAP_LAYAN_CALENDAR","CAP_LAY_CAL_ID","","");

						foreach ($delete as $key => $value) {

							$del->whereID = $value;

							$del->deleteRow();

						}

					}

			}

			$insert = new insert("","CAP_LAYAN_CALENDAR","CAP_LAY_CAL_ID","","");

			$update = new update("","CAP_LAYAN_CALENDAR","","","");

			for ($i = 0, $c = count($id['date']); $i < $c; $i++) {

				if (empty($id['idDokumen'][$i])) {

					if (!empty($id['date'][$i])) {

						$insert->column = array("CAP_LAY_CAL_DATE" => date("Y-m-d 00:00:00",strtotime($id['date'][$i])), "CAP_LAY_CAL_DESCRIPTION" => $id['deskripsi'][$i]);

						$insert->dateColumn = array("CAP_LAY_CAL_DATE");

						$insert->execute();

					}

				}
				else {

					if (!empty($id['date'][$i])) {

						$update->column = array("CAP_LAY_CAL_DATE" => date("Y-m-d 00:00:00",strtotime($id['date'][$i])), "CAP_LAY_CAL_DESCRIPTION" => $id['deskripsi'][$i]);

						$update->whereClause = array(array("CAP_LAY_CAL_ID","=",$id['idDokumen'][$i]));

						$update->dateColumn = array("CAP_LAY_CAL_DATE");

						$update->execute();

					}

				}

			}
		
	}
	
	public function deletePermohonan($id) {
		
		$user = unserialize($_SESSION['user']); $userid = $user->getID();
		
		if (!empty($userid)) {
		
		$select = new select("*","CAP_LAYAN",array(array("CAP_LAY_ID","=",base64_decode($id))),"","");

		$select->execute();
		
		$noPermohonan = $select->arrayResult[0]['CAP_LAY_TRANSACTIONID'];
		
		$currentStatus = $select->arrayResult[0]['CAP_LAY_FINALSTATUS'];
			
			if ($currentStatus != 4 || $currentStatus != 2 || $currentStatus != 3 || $currentStatus != 5) {
			
			$update = new update(array("CAP_LAY_FINALSTATUS" => 4),"CAP_LAYAN",array(array("CAP_LAY_ID","=",base64_decode($id))),"","");
				
				if ($update->execute()) {
								
					model::log(base64_decode($id),"MENGHAPUS PERMOHONAN NO. $noPermohonan");
					
					return array(true,$user->getRole());
					
				}
				else {
					
					return array(false,$user->getRole());
					
				}
			
			}
			
		}
		
	}

	public function deletePemberitahuanDokumen($id) {
		
		$select = new select("*","CAP_LAYAN_PEMBERITAHUAN_DOC LEFT JOIN CAP_LAYAN_DOCUMENT_REQUEST ON CAP_LAYAN_PEMBERITAHUAN_DOC.FK_CAP_LAY_DOC_REQ_ID = CAP_LAYAN_DOCUMENT_REQUEST.CAP_LAY_DOC_REQ_ID",array(array("CAP_LAY_PEM_DOC_ID","=",$id)),"","");

		$select->execute();

		$documentName = $select->arrayResult[0]['CAP_LAY_DOC_REQ_DOCNAME'];

		$pemberitahuanID = $select->arrayResult[0]['FK_CAP_LAY_PEM_ID'];

		$select = new select("*","CAP_LAYAN_PEMBERITAHUAN",array(array("CAP_LAY_PEM_ID","=",$pemberitahuanID)),"","");

		$select->execute();

		$permohonanID = $select->arrayResult[0]['FK_CAP_LAY_ID'];
		
		$selectID = new select("*","CAP_LAYAN",array(array("CAP_LAY_ID","=",$permohonanID)),"","");
		
		$selectID->execute();
		
		$status = $selectID->arrayResult[0]['CAP_LAY_FINALSTATUS'];
				
			if ($status == 2 || $status == 3 || $status == 5) {
						
				echo "false";
						
				return false;
						
			}	

		$pemberitahuanNo = $select->arrayResult[0]['CAP_LAY_PEM_NUMBER'];

		$delete = new delete("","CAP_LAYAN_PEMBERITAHUAN_DOC","CAP_LAY_PEM_DOC_ID",$id,"");
		
		$status = $delete->deleteRow();

			//if (empty($status)) {

				model::log($permohonanID,"MENGHAPUS INFORMASI PUBLIK ".strtoupper($documentName)." DALAM PEMBERITAHUAN TERTULIS NO. ".$pemberitahuanNo);

			//}


				
	}

	public function deletePerpanjanganDokumen($id) {
		
		$select = new select("*","CAP_LAYAN_PERPANJANGAN_DOC LEFT JOIN CAP_LAYAN_DOCUMENT_REQUEST ON CAP_LAYAN_PERPANJANGAN_DOC.FK_CAP_LAY_DOC_REQ_ID = CAP_LAYAN_DOCUMENT_REQUEST.CAP_LAY_DOC_REQ_ID",array(array("CAP_LAY_PER_DOC_ID","=",$id)),"","");

		$select->execute();

		$documentName = $select->arrayResult[0]['CAP_LAY_DOC_REQ_DOCNAME'];

		$pemberitahuanID = $select->arrayResult[0]['FK_CAP_LAY_PER_ID'];

		$select = new select("*","CAP_LAYAN_PERPANJANGAN",array(array("CAP_LAY_PER_ID","=",$pemberitahuanID)),"","");

		$select->execute();

		$permohonanID = $select->arrayResult[0]['FK_CAP_LAY_ID'];
		
		$selectID = new select("*","CAP_LAYAN",array(array("CAP_LAY_ID","=",$permohonanID)),"","");
		
		$selectID->execute();
		
		$status = $selectID->arrayResult[0]['CAP_LAY_FINALSTATUS'];
				
			if ($status == 2 || $status == 3 || $status == 5) {
						
				echo "false";
						
				return false;
						
			}	
		
		$pemberitahuanNo = $select->arrayResult[0]['CAP_LAY_PER_NUMBER'];

		$delete = new delete("","CAP_LAYAN_PERPANJANGAN_DOC","CAP_LAY_PER_DOC_ID",$id,"");

		$status = $delete->deleteRow();

			//if (empty($status)) {

				model::log($permohonanID,"MENGHAPUS INFORMASI PUBLIK ".strtoupper($documentName)." DALAM PERPANJANGAN NO. ".$pemberitahuanNo);

			//}
				
	}

	public function deletePenolakanDokumen($id) {
		
		$select = new select("*","CAP_LAYAN_PENOLAKAN_DOC LEFT JOIN CAP_LAYAN_DOCUMENT_REQUEST ON CAP_LAYAN_PENOLAKAN_DOC.FK_CAP_LAY_DOC_REQ_ID = CAP_LAYAN_DOCUMENT_REQUEST.CAP_LAY_DOC_REQ_ID",array(array("CAP_LAY_PEN_DOC_ID","=",$id)),"","");

		$select->execute();

		$documentName = $select->arrayResult[0]['CAP_LAY_DOC_REQ_DOCNAME'];

		$pemberitahuanID = $select->arrayResult[0]['FK_CAP_LAY_PEN_ID'];

		$select = new select("*","CAP_LAYAN_PENOLAKAN",array(array("CAP_LAY_PEN_ID","=",$pemberitahuanID)),"","");

		$select->execute();

		$permohonanID = $select->arrayResult[0]['FK_CAP_LAY_ID'];
		
		$selectID = new select("*","CAP_LAYAN",array(array("CAP_LAY_ID","=",$permohonanID)),"","");
		
		$selectID->execute();
		
		$status = $selectID->arrayResult[0]['CAP_LAY_FINALSTATUS'];
				
			if ($status == 2 || $status == 3 || $status == 5) {
						
				echo "false";
						
				return false;
						
			}		
		
		$pemberitahuanNo = $select->arrayResult[0]['CAP_LAY_PEN_NUMBER'];

		$delete = new delete("","CAP_LAYAN_PENOLAKAN_DOC","CAP_LAY_PEN_DOC_ID",$id,"");

		$status = $delete->deleteRow();

			//if (empty($status)) {

				model::log($permohonanID,"MENGHAPUS INFORMASI PUBLIK ".strtoupper($documentName)." DALAM PENOLAKAN NO. ".$pemberitahuanNo);

			//}
				
	}

	public function deleteKeberatanDokumen($id) {
		
		$select = new select("*",
				"CAP_LAYAN_KEBERATAN_DOC
				LEFT JOIN CAP_LAYAN_KEBERATAN ON CAP_LAYAN_KEBERATAN.CAP_LAY_KEB_ID = CAP_LAYAN_KEBERATAN_DOC.FK_CAP_LAY_KEB_ID 
				LEFT JOIN CAP_LAYAN_PEMBERITAHUAN ON CAP_LAYAN_KEBERATAN_DOC.FK_CAP_LAY_PEM_ID = CAP_LAYAN_PEMBERITAHUAN.CAP_LAY_PEM_ID 
				LEFT JOIN CAP_LAYAN_PENOLAKAN ON CAP_LAYAN_KEBERATAN_DOC.FK_CAP_LAY_PEN_ID = CAP_LAYAN_PENOLAKAN.CAP_LAY_PEN_ID 
				LEFT JOIN CAP_LAYAN_PERPANJANGAN ON CAP_LAYAN_KEBERATAN_DOC.FK_CAP_LAY_PER_ID = CAP_LAYAN_PERPANJANGAN.CAP_LAY_PER_ID
				LEFT JOIN CAP_LAYAN ON CAP_LAYAN_KEBERATAN_DOC.FK_CAP_LAY_ID = CAP_LAYAN.CAP_LAY_ID",
				array(array("CAP_LAYAN_KEBERATAN_DOC.CAP_LAY_KEB_DOC_ID","=",$id)),"","");

		$select->execute();

			if (!empty($select->arrayResult[0]['FK_CAP_LAY_PEM_ID'])) {

			$documentName = "PEMBERITAHUAN NO. ".$select->arrayResult[0]['CAP_LAY_PEM_NUMBER'];

			}
			else if (!empty($select->arrayResult[0]['FK_CAP_LAY_PEN_ID'])) {

			$documentName = "PENOLAKAN NO. ".$select->arrayResult[0]['CAP_LAY_PEN_NUMBER'];

			}
			else if (!empty($select->arrayResult[0]['FK_CAP_LAY_PER_ID'])) {

			$documentName = "PERPANJANGAN NO. ".$select->arrayResult[0]['CAP_LAY_PER_NUMBER'];

			}
			else if (!empty($select->arrayResult[0]['CAP_LAY_ID'])) {

			$documentName = "PERMOHONAN NO. ".$select->arrayResult[0]['CAP_LAY_TRANSACTIONID'];

			}
		
		$keberatanID = $select->arrayResult[0]['CAP_LAY_KEB_ID'];
		
		$select->tableName = "CAP_LAYAN_KEBERATAN LEFT JOIN CAP_LAYAN ON CAP_LAYAN_KEBERATAN.FK_CAP_LAY_ID = CAP_LAYAN.CAP_LAY_ID";
		
		$select->whereClause = array(array("CAP_LAY_KEB_ID","=",$keberatanID));
		
		$select->execute();
		
		$permohonanID = $select->arrayResult[0]['CAP_LAY_ID'];
				
		$selectID = new select("*","CAP_LAYAN",array(array("CAP_LAY_ID","=",$permohonanID)),"","");
		
		$selectID->execute();
		
		$status = $selectID->arrayResult[0]['CAP_LAY_FINALSTATUS'];
				
			if ($status == 5) {
						
				echo "false";
						
				return false;
						
			}
		
		$pemberitahuanNo = $select->arrayResult[0]['CAP_LAY_KEB_NUMBER'];

		$delete = new delete("","CAP_LAYAN_KEBERATAN_DOC","CAP_LAY_KEB_DOC_ID",$id,"");

		$status = $delete->deleteRow();

			//if (empty($status)) {

				model::log($permohonanID,"MENGHAPUS DOKUMEN ".strtoupper($documentName)." DALAM KEBERATAN NO. ".$pemberitahuanNo);

			//}
				
	}

	public function deletePemberitahuanDokumenMaster($id) {
	
		$selectID = new select("*","CAP_LAYAN","","","");
		
		$select = new select("*","CAP_LAYAN_PEMBERITAHUAN","","","");

		$delete = new delete("","CAP_LAYAN_PEMBERITAHUAN","CAP_LAY_PEM_ID","","");
		
		if (is_array($id)) {

			foreach ($id as $key => $value) {

				$select->whereClause = array(array("CAP_LAY_PEM_ID","=",$value));

				$select->execute();

				$permohonanID = $select->arrayResult[0]['FK_CAP_LAY_ID'];
				
				$selectID->whereClause = array(array("CAP_LAY_ID","=",$permohonanID));
				
				$selectID->execute();
				
				$status = $selectID->arrayResult[0]['CAP_LAY_FINALSTATUS'];
				
					if ($status == 2 || $status == 3 || $status == 5) {
						
						echo "false";
						
						return false;
						
					}

				$pemberitahuanNo = $select->arrayResult[0]['CAP_LAY_PEM_NUMBER'];

				$delete->whereID = $value;

				$status = $delete->deleteRow();

				//if (empty($status)) {

					model::log($permohonanID,"MENGHAPUS PEMBERITAHUAN TERTULIS NO. ".strtoupper($pemberitahuanNo));

				//}

			}

		}
				
	}

	public function deletePerpanjanganDokumenMaster($id) {
		
		$selectID = new select("*","CAP_LAYAN","","","");
		
		$select   = new select("*","CAP_LAYAN_PERPANJANGAN","","","");

		$delete   = new delete("","CAP_LAYAN_PERPANJANGAN","CAP_LAY_PER_ID","","");

		if (is_array($id)) {

			foreach ($id as $key => $value) {
				
				$select->whereClause = array(array("CAP_LAY_PER_ID","=",$value));

				$select->execute();

				$permohonanID = $select->arrayResult[0]['FK_CAP_LAY_ID'];
				
				$selectID->whereClause = array(array("CAP_LAY_ID","=",$permohonanID));
				
				$selectID->execute();
				
				$status = $selectID->arrayResult[0]['CAP_LAY_FINALSTATUS'];
				
					if ($status == 2 || $status == 3 || $status == 5) {
						
						echo "false";
						
						return false;
						
					}

				$pemberitahuanNo = $select->arrayResult[0]['CAP_LAY_PER_NUMBER'];

				$delete->whereID = $value;

				$status = $delete->deleteRow();

				//if (empty($status)) {

					model::log($permohonanID,"MENGHAPUS PERPANJANGAN NO. ".strtoupper($pemberitahuanNo));

				//}

			}

		}
				
	}

	public function deletePenolakanDokumenMaster($id) {
		
		$selectID = new select("*","CAP_LAYAN","","","");
		
		$select = new select("*","CAP_LAYAN_PENOLAKAN","","","");

		$delete = new delete("","CAP_LAYAN_PENOLAKAN","CAP_LAY_PEN_ID","","");

		if (is_array($id)) {

			foreach ($id as $key => $value) {

				$select->whereClause = array(array("CAP_LAY_PEN_ID","=",$value));

				$select->execute();

				$permohonanID = $select->arrayResult[0]['FK_CAP_LAY_ID'];
				
				$selectID->whereClause = array(array("CAP_LAY_ID","=",$permohonanID));
				
				$selectID->execute();
				
				$status = $selectID->arrayResult[0]['CAP_LAY_FINALSTATUS'];
				
					if ($status == 2 || $status == 3 || $status == 5) {
						
						echo "false";
						
						return false;
						
					}
				
				$pemberitahuanNo = $select->arrayResult[0]['CAP_LAY_PEN_NUMBER'];

				$delete->whereID = $value;

				$status = $delete->deleteRow();

				//if (empty($status)) {

					model::log($permohonanID,"MENGHAPUS PENOLAKAN NO. ".strtoupper($pemberitahuanNo));

				//}

			}

		}
				
	}

	public function deleteKeberatanDokumenMaster($id) {
		
		$selectID = new select("*","","","","");
		
		$select = new select("*","","","","");

		$delete = new delete("","CAP_LAYAN_KEBERATAN","CAP_LAY_KEB_ID","","");

		if (is_array($id)) {

			foreach ($id as $key => $value) {
			
				$select->tableName = "CAP_LAYAN_KEBERATAN";

				$select->whereClause = array(array("CAP_LAY_KEB_ID","=",$value));

				$select->execute();

				$permohonanID = $select->arrayResult[0]['FK_CAP_LAY_ID'];
				
				$selectID->tableName = "CAP_LAYAN";
				
				$selectID->whereClause = array(array("CAP_LAY_ID","=",$permohonanID));
				
				$selectID->execute();
				
				$status = $selectID->arrayResult[0]['CAP_LAY_FINALSTATUS'];
				
					if ($status == 5) {
						
						echo "false";
						
						return false;
						
					}
				
				$pemberitahuanNo = $select->arrayResult[0]['CAP_LAY_KEB_NUMBER'];

				$delete->whereID = $value;

				$status = $delete->deleteRow();

				//if (empty($status)) {

					model::log($permohonanID,"MENGHAPUS KEBERATAN NO. ".strtoupper($pemberitahuanNo));

				//}

			}

		}
		
		$select = new select("*","CAP_LAYAN_KEBERATAN",array(array("FK_CAP_LAY_ID","=",$permohonanID)),"","");
		
		$select->execute();
		
		$select2 = new select("*","CAP_LAYAN",array(array("CAP_LAY_ID","=",$permohonanID)),"","");
		
		$select2->execute();
		
			if (empty($select->arrayResult) && $select2->arrayResult[0]['CAP_LAY_LAMPIRAN'] == 3 && $select2->arrayResult[0]['CAP_LAY_FINALSTATUS'] != 5) {
				
				$updatePermohonan = new update(array("CAP_LAY_FINALSTATUS" => 3),"CAP_LAYAN",array(array("CAP_LAY_ID","=",$permohonanID)),"","");
									
				$updatePermohonan->execute();
				
			}
			else if (empty($select->arrayResult) && $select2->arrayResult[0]['CAP_LAY_LAMPIRAN'] == 1 && $select2->arrayResult[0]['CAP_LAY_FINALSTATUS'] != 5) {
				
				$updatePermohonan = new update(array("CAP_LAY_FINALSTATUS" => 1),"CAP_LAYAN",array(array("CAP_LAY_ID","=",$permohonanID)),"","");
									
				$updatePermohonan->execute();
				
			}
			else if (empty($select->arrayResult) && $select2->arrayResult[0]['CAP_LAY_LAMPIRAN'] == 0 && $select2->arrayResult[0]['CAP_LAY_FINALSTATUS'] != 5) {
				
				$updatePermohonan = new update(array("CAP_LAY_FINALSTATUS" => 0),"CAP_LAYAN",array(array("CAP_LAY_ID","=",$permohonanID)),"","");
									
				$updatePermohonan->execute();
				
			}

				
	}
	
	public function trimming($str, $n, $delim='...') {
	
	   $len = strlen($str);
	   
	   if ($len > $n) {
	   
	       preg_match('/(.{' . $n . '}.*?)\b/', $str, $matches);
	       return rtrim($matches[1]) . $delim;
	       
	   }
	   else {
	   
	       return $str;
	       
	   }
	
	}

	public function log($id,$text) {

		$user 	= unserialize($_SESSION['user']); $userid = $user->getID(); $username = $user->getName();

		$insert = new insert("","CAP_LAYAN_HISTORY","","","");

		$text 	= strtoupper($username)." ".$text;

		$insert->column = array(
						  "CAP_LAY_HIS_TEXT" => $text,
						  "FK_CAP_USE_ID" => $userid,
						  "FK_CAP_LAY_ID" => $id,
						  "CAP_LAY_HIS_DATECREATED" => date("Y-m-d H:i:s")
						  );

		$insert->dateColumn = array('CAP_LAY_HIS_DATECREATED');
		
		$insert->whereClause = "CAP_LAY_HIS_ID";

		$lastID = $insert->execute();

		return $lastID;

	}

	public function uploadFile($file,$path,$id) {
	
	$folder = new file(null);
	
	$model = new model();

	$path = base64_decode($path);

	$location = explode("|", $path);

	$file = $file['file'];

	$ext = pathinfo($file['name'], PATHINFO_EXTENSION);

		if ($ext != 'jpg' && $ext != 'pdf') {
			echo json_encode('Invalid File Extension');
			die;
		}

	$select = new select("*","CAP_LAYAN",array(array("CAP_LAY_TRANSACTIONID","=",$location[0])),"","");

	$select->execute();

	$permohonanID = $select->arrayResult[0]['CAP_LAY_ID'];

		if ($location[1] == 'FOTO') {
			$path = '1-FOTO';
		}
		else if ($location[1] == 'KTP') {
			$path = '2-KTP';
		}
		else if ($location[1] == 'AKTA') {
			$path = '3-AKTA';
		}
		else if ($location[1] == 'KUASA') {
			$path = '4-KUASA';
		}
		else if ($location[1] == 'KTP-KUASA') {
			$path = '5-KTP-KUASA';
		}
		else if ($location[1] == 'NPWP') {
			$path = '6-NPWP';
		}

		if (is_dir(ROOT_PATH.'library/capsule/layan/data/'.$location[0]."/".$path."/")) {
			$folder->recursiveDelete(ROOT_PATH.'library/capsule/layan/data/'.$location[0]."/".$path."/");
		}

		if (!is_dir(ROOT_PATH.'library/capsule/layan/data/'.$location[0])) {

			if (!$folder->setFile(ROOT_PATH.'library/capsule/layan/data/'.$location[0])->createDirectory()) {
				echo json_encode('Directory failed to create');
				die;
			}
			
		}

		if (!is_dir(ROOT_PATH.'library/capsule/layan/data/'.$location[0]."/".$path)) {

			if (!$folder->setFile(ROOT_PATH.'library/capsule/layan/data/'.$location[0]."/".$path)->createDirectory()) {
				echo json_encode('Directory failed to create');
				die;
			}
			
		}

		$ext = pathinfo($file['name'], PATHINFO_EXTENSION);

		$split = explode("-", $path);

			if (!empty($split[2])) {
				$fileName = $split[1]." ".$split[2];
			}
			else {
				$fileName = $split[1];
			}

		if (move_uploaded_file($file['tmp_name'], ROOT_PATH.'library/capsule/layan/data/'.$location[0]."/".$path."/".$path.".".$ext)){
			model::log($permohonanID,"MEMASUKAN ATTACHMENT $fileName KEDALAM PERMOHONAN NO. ".$location[0]);

				if ($ext == 'pdf') {

				$im = new imagick();
				$im->readImage(ROOT_PATH.'library/capsule/layan/data/'.$location[0]."/".$path."/".$path.".".$ext."[0]");
							 $width=$im->getImageWidth();
							  if ($width > 300) { $im->thumbnailImage(300,null,0); }

							  $height=$im->getImageHeight();
							  if ($height > 300) { $im->thumbnailImage(null,300,0); }
				$im->setImageFormat( "jpg" );
				$im->writeImage(ROOT_PATH.'library/capsule/layan/data/'.$location[0]."/".$path."/".$path.".jpg"); 

				}
				
				$select = new select("*","CAP_LAYAN",array(array("CAP_LAY_ID","=",base64_decode($id))),"","");
				
				$select->execute();
				
					if (empty($select->arrayResult)) {
						error_log("Personal Warning: Select Failed. No Data on $id", 0);
					}
					else {
						$model->preCheck($select->arrayResult);
					}
				
        	echo json_encode('success');
    	}
    	else {
    		echo json_encode('Failed to upload to directory');
			die;
    	}


	}

	public function deleteAttachment($id) {

		$location = explode("|", base64_decode($id));
		
		$tran = $location[0];
		
		$select = new select("*","CAP_LAYAN",array(array("CAP_LAY_TRANSACTIONID","=",$tran)),"","");
		
		$select->execute();
				
		$permohonanID = $select->arrayResult[0]['CAP_LAY_ID'];

			if ($location[1] == 'FOTO') {
				$path = '1-FOTO';
			}
			else if ($location[1] == 'KTP') {
				$path = '2-KTP';
			}
			else if ($location[1] == 'AKTA') {
				$path = '3-AKTA';
			}
			else if ($location[1] == 'KUASA') {
				$path = '4-KUASA';
			}
			else if ($location[1] == 'KTP-KUASA') {
				$path = '5-KTP-KUASA';
			}
			else if ($location[1] == 'NPWP') {
				$path = '6-NPWP';
			}

			if (is_dir(ROOT_PATH.'library/capsule/layan/data/'.$location[0]."/".$path."/")) {
				$folder = new file(null);
				$folder->recursiveDelete(ROOT_PATH.'library/capsule/layan/data/'.$location[0]."/".$path."/");
				model::log($permohonanID,"MENGHAPUS ATTACHMENT ".ucwords(strtolower($location[1]))." DI PERMOHONAN NO. ".$location[0]);
				echo ucwords(strtolower($location[1]));

			}
			else {
				echo "Failed";
			}

	}
	
	public function klasifikasi() {
		
		$select = new select("*","CAP_PER_MT_KLA_LAN_COM LEFT JOIN CAP_LANGUAGE_COMBINE ON CAP_PER_MT_KLA_LAN_COM.FK_LAN_COM_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_ID",
		array(array("CAP_LANGUAGE_COMBINE.CAP_LAN_COM_PUBLISH","=","1")),"","CAP_LANGUAGE_COMBINE.CAP_LAN_COM_DATECREATED","100");
		
		$select->execute();
		
		$selectTag = new select("*","","","","");
		
		$selectMet = new select("*","","","","");
		
		$array = $select->arrayResult;
		
		$i = 0;
		
			if (!empty($array)):
		
				foreach ($array as $key => $value):
				
					$selectTag->tableName = "CAP_TAG_KEY LEFT JOIN CAP_TAG ON CAP_TAG_KEY.FK_TAG_ID = CAP_TAG.CAP_TAG_ID";
								
					$selectTag->whereClause = array(array("FK_LAN_COM_ID","=",$value['CAP_LAN_COM_ID']));
					
					$selectTag->execute();
					
					$selectMet->tableName = "CAP_CONTENT_METADATA";
					
					$selectMet->whereClause = array(array("FK_CAP_LAN_COM_ID","=",$value['CAP_LAN_COM_ID']));

					$selectMet->execute();
											
					$array[$i]['TAGGING']  = $selectTag->arrayResult;
					
					$array[$i]['METADATA'] = $selectMet->arrayResult;
					
					$i++;
					
				endforeach;
			
			endif;

		return $array;
		
	}
	
	public function klasifikasi_admin() {
		
		$select = new select("*","CAP_PER_MT_KLA_LAN_COM LEFT JOIN CAP_LANGUAGE_COMBINE ON CAP_PER_MT_KLA_LAN_COM.FK_LAN_COM_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_ID","","","CAP_LANGUAGE_COMBINE.CAP_LAN_COM_DATECREATED","100");
		
		$select->execute();
		
		$selectTag = new select("*","","","","");
		
		$selectMet = new select("*","","","","");
		
		$array = $select->arrayResult;
		
		$i = 0;
		
			if (!empty($array)):
		
				foreach ($array as $key => $value):
				
					$selectTag->tableName = "CAP_TAG_KEY LEFT JOIN CAP_TAG ON CAP_TAG_KEY.FK_TAG_ID = CAP_TAG.CAP_TAG_ID";
								
					$selectTag->whereClause = array(array("FK_LAN_COM_ID","=",$value['CAP_LAN_COM_ID']));
					
					$selectTag->execute();
					
					$selectMet->tableName = "CAP_CONTENT_METADATA";
					
					$selectMet->whereClause = array(array("FK_CAP_LAN_COM_ID","=",$value['CAP_LAN_COM_ID']));

					$selectMet->execute();
											
					$array[$i]['TAGGING']  = $selectTag->arrayResult;
					
					$array[$i]['METADATA'] = $selectMet->arrayResult;
					
					$i++;
					
				endforeach;
			
			endif;

		return $array;
		
	}
		
	
	public function getKlasifikasiRecursiveChild($id){
		
	
	$selectChild = new select("*","CAP_KLASIFIKASI",array(array("CAP_KLA_PARENT","=",$id)),"","");
	
	$selectChild->execute();
	
	if(!empty($selectChild->arrayResult)){
	
		foreach($selectChild->arrayResult as $key => $value){
		
			$array [] = $value['CAP_KLA_ID'];
			
			$child  = self::getKlasifikasiRecursiveChild($value['CAP_KLA_ID']);
			
			if(!empty($child)){
			
				if(is_array($child)){
					foreach($child as $keys => $values){
						$array [] =$values;
					}
				}else{
				$array [] = $child;
				}
			}
			
			
			unset($child);
		
		}
		
		return $array;
	}
	
	
	
	}
	
	
	
	
	
	
	public function klasifikasi_search() {
		
		if (!empty($this->data[0]['klasifikasi']) || !empty($this->data[0]['tag']) && $this->data[0]['tag'] != 'null' || !empty($this->data[0]['text'])) {
			$searchQuery .= " WHERE ";
		}
		
		if (!empty($this->data[0]['klasifikasi'])) {
			$searchQuery .= " CAP_KLA_ID = ".$this->data[0]['klasifikasi']." ";
			$searchQuery .= " OR CAST(CAP_KLA_PARENT AS INTEGER) IN (".$this->data[0]['klasifikasi'];
			
			
			$array = self::getKlasifikasiRecursiveChild($this->data[0]['klasifikasi']);
			
			
			
			if(!empty($array)){
			
			$count = count($array);
			$i = 1;
			
			//print_r($array);
				foreach($array as $key => $value){
				
					if($i <= $count){
						
					$searchQuery .= ",";
						
					}
					$searchQuery .= $value;
					
				}
			}
			
			$searchQuery .= ")";
		}

		if (!empty($this->data[0]['tag']) && $this->data[0]['tag'] != 'null') {
		
			if (!empty($this->data[0]['klasifikasi'])) {
				$searchQuery .= " AND ";
			}
			
		$i = 1;
		$c = count($this->data[0]['tag']);		
		
			foreach ($this->data[0]['tag'] as $value) {
				
			$tagID .= " CAP_TAG_KEY.FK_TAG_ID = ".str_replace("'","''",$value);
			
				if ($i < $c) {
					
					$tagID .= " OR ";
					
				}
				
			$i++;
			
			}		
		
		$searchQuery .=  "(".$tagID.")";
			
		}

		if (!empty($this->data[0]['text'])) {
		
			if (!empty($this->data[0]['klasifikasi']) || !empty($this->data[0]['tag'])  && $this->data[0]['tag'] != 'null') {
				$searchQuery .= " AND ";
			}
			
			
			
			
		$searchQuery .= " LOWER(CAP_CONTENT_METADATA.CAP_CON_MET_HEADER) = LOWER('".str_replace("'","''",$this->data[0]['metadata'])."') AND LOWER(CAP_CONTENT_METADATA.CAP_CON_MET_CONTENT) LIKE LOWER('%".str_replace("'","''",$this->data[0]['text'])."%')";
		}
		
		if (!empty($this->data[0]['klasifikasi']) || !empty($this->data[0]['tag']) && $this->data[0]['tag'] != 'null' || !empty($this->data[0]['text'])) {
		
		
		
		$select = new select(

		"DISTINCT CAP_LAN_COM_ID",
		"CAP_LANGUAGE_COMBINE
		LEFT JOIN CAP_TAG_KEY ON CAP_TAG_KEY.FK_LAN_COM_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_ID
		LEFT JOIN CAP_PER_MT_KLA_LAN_COM ON CAP_PER_MT_KLA_LAN_COM.FK_LAN_COM_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_ID
		LEFT JOIN CAP_KLASIFIKASI ON CAP_KLASIFIKASI.CAP_KLA_ID = CAP_PER_MT_KLA_LAN_COM.FK_KLA_ID
		LEFT JOIN CAP_CONTENT_METADATA ON CAP_LANGUAGE_COMBINE.CAP_LAN_COM_ID = CAP_CONTENT_METADATA.FK_CAP_LAN_COM_ID $searchQuery",
		"",
		"",
		"");
		
		}
		else {
				
		$select = new select("*","CAP_PER_MT_KLA_LAN_COM LEFT JOIN CAP_LANGUAGE_COMBINE ON CAP_PER_MT_KLA_LAN_COM.FK_LAN_COM_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_ID WHERE CAP_LANGUAGE_COMBINE.CAP_LAN_COM_PUBLISH = '1' ORDER BY CAP_LANGUAGE_COMBINE.CAP_LAN_COM_DATECREATED LIMIT 100","","","");
		
		}
		
		$select->execute();
		
		//print_r($select->query);
		
		if (!empty($select->arrayResult)) {
			
			$selectComplete = new select("*","","","","CAP_LANGUAGE_COMBINE.CAP_LAN_COM_DATECREATED ASC");
			
			foreach ($select->arrayResult as $key => $value) {
				
				$selectComplete->tableName = "CAP_PER_MT_KLA_LAN_COM LEFT JOIN CAP_LANGUAGE_COMBINE ON CAP_PER_MT_KLA_LAN_COM.FK_LAN_COM_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_ID";
				
				$selectComplete->whereClause = array(array("CAP_LAN_COM_ID","=",$value['CAP_LAN_COM_ID']));
				
				$selectComplete->execute();
				
				$newArray [] = $selectComplete->arrayResult[0];
			
			}
			
		}

		$select->arrayResult = $newArray;
		
		$array 	   = $select->arrayResult;
	
		$selectTag = new select("*","","","","");
		
		$selectMet = new select("*","","","","");
		
		$i = 0;
		
			if (!empty($array)) {
		
				foreach ($array as $key => $value) {
					
					$selectTag->tableName = "CAP_TAG_KEY LEFT JOIN CAP_TAG ON CAP_TAG_KEY.FK_TAG_ID = CAP_TAG.CAP_TAG_ID";
								
					$selectTag->whereClause = array(array("FK_LAN_COM_ID","=",$value['CAP_LAN_COM_ID']));
					
					$selectTag->execute();
					
					$selectMet->tableName = "CAP_CONTENT_METADATA";
								
					$selectMet->whereClause = array(array("FK_CAP_LAN_COM_ID","=",$value['CAP_LAN_COM_ID']));
					
					$selectMet->execute();
											
					$array[$i]['TAGGING']  = $selectTag->arrayResult;
							
					$array[$i]['METADATA'] = $selectMet->arrayResult;
					
					$i++;
					
				}
			
			}

			if (!empty($this->data[0]['tag']) && $this->data[0]['tag'] != 'null') {
			
				if (!empty($array)) {
					
				$countTag = count($this->data[0]['tag']);
					
					foreach ($array as $key => $value) {
					
					$count = count($value['TAGGING']);						
						
					$i = 0;
					
						if (!empty($value['TAGGING'])) {
					
							foreach ($value['TAGGING'] as $value3) {
								
								
								if (in_array($value3['FK_TAG_ID'],$this->data[0]['tag'])) {
									
									$i++;
									
								}
								
							}
						
						}
						
						if ($i >= $countTag) {
						
						$newArrayian [] = $value;
						
						}
						
					}
					
				$array = $newArrayian;
				
				}
							
			}	
		
		return $array;
		
	}
	
	public function klasifikasi_admin_search() {
		
		if (!empty($this->data[0]['klasifikasi']) || !empty($this->data[0]['tag']) && $this->data[0]['tag'] != 'null' || !empty($this->data[0]['text'])) {
			$searchQuery .= " WHERE ";
		}
		
		if (!empty($this->data[0]['klasifikasi'])) {
			$searchQuery .= " CAP_KLA_ID = ".$this->data[0]['klasifikasi']." ";
			$searchQuery .= " OR CAST(CAP_KLA_PARENT AS INTEGER) IN (".$this->data[0]['klasifikasi'];
			
			
			$array = self::getKlasifikasiRecursiveChild($this->data[0]['klasifikasi']);
			
			
			
			if(!empty($array)){
			
			$count = count($array);
			$i = 1;
			
			//print_r($array);
				foreach($array as $key => $value){
				
					if($i <= $count){
						
					$searchQuery .= ",";
						
					}
					$searchQuery .= $value;
					
				}
			}
			
			$searchQuery .= ")";
		}

		if (!empty($this->data[0]['tag']) && $this->data[0]['tag'] != 'null') {
		
			if (!empty($this->data[0]['klasifikasi'])) {
				$searchQuery .= " AND ";
			}
			
		$i = 1;
		$c = count($this->data[0]['tag']);		
		
			foreach ($this->data[0]['tag'] as $value) {
				
			$tagID .= " CAP_TAG_KEY.FK_TAG_ID = ".str_replace("'","''",$value);
			
				if ($i < $c) {
					
					$tagID .= " OR ";
					
				}
				
			$i++;
			
			}		
		
		$searchQuery .=  "(".$tagID.")";
			
		}

		if (!empty($this->data[0]['text'])) {
		
			if (!empty($this->data[0]['klasifikasi']) || !empty($this->data[0]['tag'])  && $this->data[0]['tag'] != 'null') {
				$searchQuery .= " AND ";
			}
			
			
			
			
		$searchQuery .= " LOWER(CAP_CONTENT_METADATA.CAP_CON_MET_HEADER) = LOWER('".str_replace("'","''",$this->data[0]['metadata'])."') AND LOWER(CAP_CONTENT_METADATA.CAP_CON_MET_CONTENT) LIKE LOWER('%".str_replace("'","''",$this->data[0]['text'])."%')";
		}
		
		if (!empty($this->data[0]['klasifikasi']) || !empty($this->data[0]['tag']) && $this->data[0]['tag'] != 'null' || !empty($this->data[0]['text'])) {
		
		
		
		$select = new select(

		"DISTINCT CAP_LAN_COM_ID",
		"CAP_LANGUAGE_COMBINE
		LEFT JOIN CAP_TAG_KEY ON CAP_TAG_KEY.FK_LAN_COM_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_ID
		LEFT JOIN CAP_PER_MT_KLA_LAN_COM ON CAP_PER_MT_KLA_LAN_COM.FK_LAN_COM_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_ID
		LEFT JOIN CAP_KLASIFIKASI ON CAP_KLASIFIKASI.CAP_KLA_ID = CAP_PER_MT_KLA_LAN_COM.FK_KLA_ID
		LEFT JOIN CAP_CONTENT_METADATA ON CAP_LANGUAGE_COMBINE.CAP_LAN_COM_ID = CAP_CONTENT_METADATA.FK_CAP_LAN_COM_ID $searchQuery",
		"",
		"",
		"");
		
		}
		else {
				
		$select = new select("*","CAP_PER_MT_KLA_LAN_COM LEFT JOIN CAP_LANGUAGE_COMBINE ON CAP_PER_MT_KLA_LAN_COM.FK_LAN_COM_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_ID ORDER BY CAP_LANGUAGE_COMBINE.CAP_LAN_COM_DATECREATED LIMIT 100","","","");
		
		}
		
		$select->execute();
		
		//print_r($select->query);
		
		if (!empty($select->arrayResult)) {
			
			$selectComplete = new select("*","","","","CAP_LANGUAGE_COMBINE.CAP_LAN_COM_DATECREATED ASC");
			
			foreach ($select->arrayResult as $key => $value) {
				
				$selectComplete->tableName = "CAP_PER_MT_KLA_LAN_COM LEFT JOIN CAP_LANGUAGE_COMBINE ON CAP_PER_MT_KLA_LAN_COM.FK_LAN_COM_ID = CAP_LANGUAGE_COMBINE.CAP_LAN_COM_ID";
				
				$selectComplete->whereClause = array(array("CAP_LAN_COM_ID","=",$value['CAP_LAN_COM_ID']));
				
				$selectComplete->execute();
				
				$newArray [] = $selectComplete->arrayResult[0];
			
			}
			
		}

		$select->arrayResult = $newArray;
		
		$array 	   = $select->arrayResult;
	
		$selectTag = new select("*","","","","");
		
		$selectMet = new select("*","","","","");
		
		$i = 0;
		
			if (!empty($array)) {
		
				foreach ($array as $key => $value) {
					
					$selectTag->tableName = "CAP_TAG_KEY LEFT JOIN CAP_TAG ON CAP_TAG_KEY.FK_TAG_ID = CAP_TAG.CAP_TAG_ID";
								
					$selectTag->whereClause = array(array("FK_LAN_COM_ID","=",$value['CAP_LAN_COM_ID']));
					
					$selectTag->execute();
					
					$selectMet->tableName = "CAP_CONTENT_METADATA";
								
					$selectMet->whereClause = array(array("FK_CAP_LAN_COM_ID","=",$value['CAP_LAN_COM_ID']));
					
					$selectMet->execute();
											
					$array[$i]['TAGGING']  = $selectTag->arrayResult;
							
					$array[$i]['METADATA'] = $selectMet->arrayResult;
					
					$i++;
					
				}
			
			}

			if (!empty($this->data[0]['tag']) && $this->data[0]['tag'] != 'null') {
			
				if (!empty($array)) {
					
				$countTag = count($this->data[0]['tag']);
					
					foreach ($array as $key => $value) {
					
					$count = count($value['TAGGING']);						
						
					$i = 0;
					
						if (!empty($value['TAGGING'])) {
					
							foreach ($value['TAGGING'] as $value3) {
								
								
								if (in_array($value3['FK_TAG_ID'],$this->data[0]['tag'])) {
									
									$i++;
									
								}
								
							}
						
						}
						
						if ($i >= $countTag) {
						
						$newArrayian [] = $value;
						
						}
						
					}
					
				$array = $newArrayian;
				
				}
							
			}	
		
		return $array;
		
	}
	
	public function klasifikasi_order_search() {
		
		$select = new select("","","","","");
		
		$select2 = new select("*","","","","");
		
		if (!empty($_SESSION['LAYAN-LIBRARY-ORDER'])) {
		
			foreach ($_SESSION['LAYAN-LIBRARY-ORDER'] as $value) {
			
				$select2->tableName = "CAP_LANGUAGE_COMBINE";
				
				$select2->whereClause = array(array("CAP_LAN_COM_ID","=",$value));
				
				$select2->execute();

				$array[] = $select2->arrayResult[0];
				
			}
					
		$selectTag = new select("*","","","","");
		
		$selectMet = new select("*","","","","");
		
		$i = 0;
		
			if (!empty($array)) {
		
				foreach ($array as $key => $value) {
					
					$selectTag->tableName = "CAP_TAG_KEY LEFT JOIN CAP_TAG ON CAP_TAG_KEY.FK_TAG_ID = CAP_TAG.CAP_TAG_ID";
							
					$selectTag->whereClause = array(array("FK_LAN_COM_ID","=",$value['CAP_LAN_COM_ID']));
					
					$selectTag->execute();
					
					$selectMet->tableName = "CAP_CONTENT_METADATA";
					
					$selectMet->whereClause = array(array("FK_CAP_LAN_COM_ID","=",$value['CAP_LAN_COM_ID']));

					$selectMet->execute();
											
					$array[$i]['TAGGING']  = $selectTag->arrayResult;
							
					$array[$i]['METADATA'] = $selectMet->arrayResult;
					
					$i++;
					
				}
			
			}
			
		}
		
		return $array;
		
	}
	
	public function getAllDocumentTagging() {
		
		$select = new select("*","CAP_TAG","","","");
		
		$select->execute();
		
		return $select->arrayResult;
		
		
	}
	
	public function getAllMetadataType() {
		
		$select1 = new select("DISTINCT CAP_CON_MET_HEADER","CAP_CONTENT_METADATA","","","");
		
		$select1->execute();
		
		$select2 = new select("CAP_MET_DEF_NAME","CAP_METADATA_DEFAULT","","","");
		
		$select2->execute();
		
			if (!empty($select1->arrayResult)) {
		
				$metaArray = array_merge($select1->arrayResult,$select2->arrayResult);
				
			}
		
		if (!empty($metaArray)) {
			foreach ($metaArray as $value) {
				if (!empty($value['CAP_CON_MET_HEADER'])) {
					$newMetaArray [] = $value['CAP_CON_MET_HEADER'];
				}
				else {
					$newMetaArray [] = $value['CAP_MET_DEF_NAME'];
				}
			}
		}
		
		if (!empty($newMetaArray)) {
		
		$newMetaArray = array_unique($newMetaArray);
		
		}
		
		return $newMetaArray;
		
		
	}
	
	public function storeOrder($id) {
		
		if (!empty($_SESSION['LAYAN-LIBRARY-ORDER'])) {
		
			if (!in_array(base64_decode($id), $_SESSION['LAYAN-LIBRARY-ORDER'])) {
			
			$_SESSION['LAYAN-LIBRARY-ORDER'][] = base64_decode($id);
			
			}
		
		}
		else {
		
			$_SESSION['LAYAN-LIBRARY-ORDER'][] = base64_decode($id);
		
		}
				
		echo count($_SESSION['LAYAN-LIBRARY-ORDER']);
		
	}
	
	public function cancelOrder($id) {
		
		if (!empty($_SESSION['LAYAN-LIBRARY-ORDER'])) {
				
		$id = base64_decode($id);
				
			foreach ($_SESSION['LAYAN-LIBRARY-ORDER'] as $key => $value) {
			
				if ($value != $id) {
					$newArray [] = $value;
				}
				
			}
			
		unset($_SESSION['LAYAN-LIBRARY-ORDER']);
		
		$_SESSION['LAYAN-LIBRARY-ORDER'] = $newArray;
			
		}
							
		echo count($_SESSION['LAYAN-LIBRARY-ORDER']);
		
	}
	
	public function resetOrder() {
		
		if (!empty($_SESSION['LAYAN-LIBRARY-ORDER'])) {
		
		unset($_SESSION['LAYAN-LIBRARY-ORDER']);
		
		}
				
		echo 0;
		
	}
	
	public function printOrder() {
	
	$insert = new insert("","CAP_LAYAN_LIBRARY","CAP_LAY_LIB_ID","","");
	
		if (!empty($_SESSION['layan-transaksiID'])):
			
			$insert->column = array("CAP_LAY_LIB_ID" => $_SESSION['layan-transaksiID'], "CAP_LAY_LIB_DATECREATED" => date("Y-m-d H:i:s"));
			
			$insert->dateColumn = array("CAP_LAY_LIB_DATECREATED");

			$lastID = $insert->execute();

				if (is_numeric($lastID) && $lastID != 'failed'):
				
				$select = new select("CAP_CON_MET_CONTENT","","","","");
				
				$insert->tableName = "CAP_LAYAN_LIBRARY_CONTENT";
				
				$insert->whereClause = "CAP_LAY_LIB_CON_ID";
				
					if (!empty($_SESSION['LAYAN-LIBRARY-ORDER'])):
							
						foreach ($_SESSION['LAYAN-LIBRARY-ORDER'] as $key => $value):
							
							$select->tableName = "CAP_CONTENT_METADATA";
													
							$select->whereClause = array(array("FK_CAP_LAN_COM_ID","=",$value),array("LOWER(CAP_CON_MET_HEADER)","=","LOWER('judul dokumen')"));
							
							$select->execute();
							
							$text = $select->arrayResult[0]['CAP_CON_MET_CONTENT'];
							
							$insert->column = array("FK_CAP_LAY_LIB_ID" => $lastID, "CAP_LAY_LIB_CON_TEXT" => $text, "FK_CAP_LAN_COM_ID" => $value);
														
							$insert->execute();
							
						endforeach;
					
					endif;
				
				endif;
			
				if (is_numeric($lastID) && $lastID != 'failed'):
				
					echo json_encode(array("status" => '1', "id" => "LIBTAN-ORD-".$lastID));
					
					unset($_SESSION['layan-transaksiID']);
				
					model::getIDTransaksi();
					
					unset($_SESSION['LAYAN-LIBRARY-ORDER']);
				
				else:
					
					echo json_encode(array("status" => '0'));
					
					return false;
					
				endif;
				
		else:
			
			echo json_encode(array("status" => '0'));
					
			return false;
			
		endif;
				
		
	}
	
}
?>