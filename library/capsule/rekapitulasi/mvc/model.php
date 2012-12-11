<?php
namespace library\capsule\rekapitulasi\mvc;

use \framework\capsule;
use \framework\database\oracle\select;
use \framework\database\oracle\insert;
use \framework\database\oracle\delete;
use \framework\database\oracle\update;
use \DateTime;
use \framework\time;
use \framework\validation;
use \framework\user;
use \library\capsule\layan\mvc\model as layan;

class model extends capsule {
	protected $data;

    public function __construct () {
	
		parent::__construct(
		
		"Rekapitulasi",
		"Media Instrument, Inc Team",
		"This is the language capsule",
		"<link href='library/capsule/share/css/share.css' rel='stylesheet' type='text/css'/>",
		"<script src='library/capsule/share/js/share.js' type='text/javascript'></script>"
	
		);
			
	}
	
	public function setData($data) {
	$this->data = $data;
	return $this;
	}
	
	public function getPermohonanDetail($year, $dateFrom = null, $dateTo = null){
		$select = new select("COUNT(CAP_LAY_ID) AS PERMOHONAN",
		"CAP_LAYAN WHERE CAP_LAY_FINALSTATUS != 4 AND (CAP_LAY_DATECREATED >= TO_DATE('".$dateFrom."','YYYY-MM-DD HH24:MI:SS') AND CAP_LAY_DATECREATED <= TO_DATE('".$dateTo."','YYYY-MM-DD HH24:MI:SS') )",
		"",
		"",
		"");
		
		$select -> execute();
		return $select->arrayResult;
	}
	
	public function getPemberitahuanDetail($year, $dateFrom = null, $dateTo = null){
		$select = new select("COUNT(CAP_LAY_PEM_ID) AS PEMBERITAHUAN","CAP_LAYAN_PEMBERITAHUAN LEFT JOIN CAP_LAYAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_PEMBERITAHUAN.FK_CAP_LAY_ID WHERE CAP_LAY_FINALSTATUS != 4 AND (CAP_LAY_PEM_DATECREATED >= TO_DATE('".$dateFrom."','YYYY-MM-DD HH24:MI:SS') AND CAP_LAY_PEM_DATECREATED <= TO_DATE('".$dateTo."','YYYY-MM-DD HH24:MI:SS') )","","","");
		
		$select -> execute();
		return $select->arrayResult;
	}
	
	public function getPerpanjanganDetail($year, $dateFrom = null, $dateTo = null){
		$select = new select("COUNT(CAP_LAY_PER_ID) AS PERPANJANGAN","CAP_LAYAN_PERPANJANGAN LEFT JOIN CAP_LAYAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_PERPANJANGAN.FK_CAP_LAY_ID WHERE CAP_LAY_FINALSTATUS != 4 AND (CAP_LAY_PER_DATECREATED >= TO_DATE('".$dateFrom."','YYYY-MM-DD HH24:MI:SS') AND CAP_LAY_PER_DATECREATED <= TO_DATE('".$dateTo."','YYYY-MM-DD HH24:MI:SS') )","","","");
		
		$select -> execute();
		return $select->arrayResult;
	}
	
	public function getKeberatanDetail($year, $dateFrom = null, $dateTo = null){
		$select = new select("COUNT(CAP_LAY_KEB_ID) AS KEBERATAN","CAP_LAYAN_KEBERATAN LEFT JOIN CAP_LAYAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_KEBERATAN.FK_CAP_LAY_ID WHERE CAP_LAY_FINALSTATUS != 4 AND (CAP_LAY_KEB_DATECREATED >= TO_DATE('".$dateFrom."','YYYY-MM-DD HH24:MI:SS') AND CAP_LAY_KEB_DATECREATED <= TO_DATE('".$dateTo."','YYYY-MM-DD HH24:MI:SS') )","","","");
		
		$select -> execute();
		return $select->arrayResult;
	}
	
	public function getPenolakanDetail($year, $dateFrom = null, $dateTo = null){
		$select = new select("COUNT(CAP_LAY_PEN_ID) AS PENOLAKAN","CAP_LAYAN_PENOLAKAN LEFT JOIN CAP_LAYAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_PENOLAKAN.FK_CAP_LAY_ID WHERE CAP_LAY_FINALSTATUS != 4 AND (CAP_LAY_DATECREATED >= TO_DATE('".$dateFrom."','YYYY-MM-DD HH24:MI:SS') AND CAP_LAY_DATECREATED <= TO_DATE('".$dateTo."','YYYY-MM-DD HH24:MI:SS') )","","","");
		
		$select -> execute();
		return $select->arrayResult;
	}
	public function getMinRangeDate($year, $dateFrom = null, $dateTo = null){		
		$select = new select("MIN(CAP_LAY_DATESTOPPED - CAP_LAY_DATECREATED) AS DAYS","CAP_LAYAN WHERE CAP_LAY_DATESTOPPED IS NOT NULL AND (CAP_LAY_DATECREATED >= TO_DATE('".$dateFrom."','YYYY-MM-DD HH24:MI:SS') AND CAP_LAY_DATECREATED <= TO_DATE('".$dateTo."','YYYY-MM-DD HH24:MI:SS') )","","","");
		$select -> execute(); 
		return $select -> arrayResult;
	}
	public function getMaxRangeDate($year, $dateFrom = null, $dateTo = null){		
		$select = new select("MAX(CAP_LAY_DATESTOPPED - CAP_LAY_DATECREATED) AS DAYS","CAP_LAYAN WHERE CAP_LAY_DATESTOPPED IS NOT NULL AND (CAP_LAY_DATECREATED >= TO_DATE('".$dateFrom."','YYYY-MM-DD HH24:MI:SS') AND CAP_LAY_DATECREATED <= TO_DATE('".$dateTo."','YYYY-MM-DD HH24:MI:SS') )","","","");
		$select -> execute(); 
		return $select -> arrayResult;
		//echo $select -> query;
	}
	public function getAvgRangeDate($year, $dateFrom = null, $dateTo = null){		
		$select = new select("AVG(CAP_LAY_DATESTOPPED - CAP_LAY_DATECREATED) AS DAYS","CAP_LAYAN WHERE CAP_LAY_DATESTOPPED IS NOT NULL AND (CAP_LAY_DATECREATED >= TO_DATE('".$dateFrom."','YYYY-MM-DD HH24:MI:SS') AND CAP_LAY_DATECREATED <= TO_DATE('".$dateTo."','YYYY-MM-DD HH24:MI:SS') )","","","");
		$select -> execute(); 
		return $select -> arrayResult;
	}
	public function getRangeDate($year, $dateFrom = null, $dateTo = null){		
		$select = new select("TO_CHAR(CAP_LAY_DATESTOPPED, 'YYYY-MM-DD') \"CAP_LAY_DATESTOPPED\", TO_CHAR(CAP_LAY_DATECREATED,'YYYY-MM-DD') \"CAP_LAY_DATECREATED\",
		CAP_LAY_DATESTOPPED - CAP_LAY_DATECREATED \"DAYS\"","CAP_LAYAN WHERE CAP_LAY_FINALSTATUS != 4 AND CAP_LAY_DATESTOPPED IS NOT NULL AND (CAP_LAY_DATECREATED >= TO_DATE('".$dateFrom."','YYYY-MM-DD HH24:MI:SS') AND CAP_LAY_DATECREATED <= TO_DATE('".$dateTo."','YYYY-MM-DD HH24:MI:SS') )","","","");
		$select -> execute(); 
		return $select -> arrayResult;
		//echo $select -> query;
	}
	
	//Keberatan
	public function getMinRangeDateKeb($year, $dateFrom = null, $dateTo = null){		
		$select = new select("MIN(CAP_LAY_KEB_DATE_TO - CAP_LAY_KEB_DATECREATED) AS DAYS","CAP_LAYAN_KEBERATAN LEFT JOIN CAP_LAYAN ON CAP_LAYAN_KEBERATAN.FK_CAP_LAY_ID = CAP_LAYAN.CAP_LAY_ID WHERE CAP_LAY_KEB_DATE_TO IS NOT NULL AND (CAP_LAY_KEB_DATECREATED >= TO_DATE('".$dateFrom."','YYYY-MM-DD HH24:MI:SS') AND CAP_LAY_KEB_DATECREATED <= TO_DATE('".$dateTo."','YYYY-MM-DD HH24:MI:SS') )","","","");
		$select -> execute(); 
		return $select -> arrayResult;
	}
	public function getMaxRangeDateKeb($year, $dateFrom = null, $dateTo = null){		
		$select = new select("MAX(CAP_LAY_KEB_DATE_TO - CAP_LAY_KEB_DATECREATED) AS DAYS","CAP_LAYAN_KEBERATAN LEFT JOIN CAP_LAYAN ON CAP_LAYAN_KEBERATAN.FK_CAP_LAY_ID = CAP_LAYAN.CAP_LAY_ID WHERE CAP_LAY_KEB_DATE_TO IS NOT NULL AND (CAP_LAY_KEB_DATECREATED >= TO_DATE('".$dateFrom."','YYYY-MM-DD HH24:MI:SS') AND CAP_LAY_KEB_DATECREATED <= TO_DATE('".$dateTo."','YYYY-MM-DD HH24:MI:SS') )","","","");
		$select -> execute(); 
		return $select -> arrayResult;
		//echo $select->query;
	}
	public function getAvgRangeDateKeb($year, $dateFrom = null, $dateTo = null){		
		$select = new select("AVG(CAP_LAY_KEB_DATE_TO - CAP_LAY_KEB_DATECREATED) AS DAYS","CAP_LAYAN_KEBERATAN LEFT JOIN CAP_LAYAN ON CAP_LAYAN_KEBERATAN.FK_CAP_LAY_ID = CAP_LAYAN.CAP_LAY_ID WHERE CAP_LAY_KEB_DATE_TO IS NOT NULL AND (CAP_LAY_KEB_DATECREATED >= TO_DATE('".$dateFrom."','YYYY-MM-DD HH24:MI:SS') AND CAP_LAY_KEB_DATECREATED <= TO_DATE('".$dateTo."','YYYY-MM-DD HH24:MI:SS') )","","","");
		$select -> execute(); 
		return $select -> arrayResult;
	}
	public function getRangeDateKeb($year, $dateFrom = null, $dateTo = null){		
		$select = new select("CAP_LAY_KEB_DATE_TO, CAP_LAY_KEB_DATECREATED,
		CAP_LAY_KEB_DATE_TO - CAP_LAY_KEB_DATECREATED \"DAYS\"","CAP_LAYAN_KEBERATAN LEFT JOIN CAP_LAYAN ON CAP_LAYAN_KEBERATAN.FK_CAP_LAY_ID = CAP_LAYAN.CAP_LAY_ID WHERE CAP_LAY_KEB_DATE_TO IS NOT NULL AND (CAP_LAY_KEB_DATECREATED >= TO_DATE('".$dateFrom."','YYYY-MM-DD HH24:MI:SS') AND CAP_LAY_KEB_DATECREATED <= TO_DATE('".$dateTo."','YYYY-MM-DD HH24:MI:SS') )","","","");
		$select -> execute(); 
		return $select -> arrayResult;
		//echo $select -> query;
	}
	
		
	public function getStatsRekap($timeFrom = null, $timeUntil = null){

		$type = array('permohonanan','pemberitahuan','perpanjangan','penolakan');
		
			$file = self::countRekap('permohonan',$timeFrom , $timeUntil  );

			$gambar = self::countRekap('pemberitahuan',$timeFrom , $timeUntil );

			$audio = self::countRekap('perpanjangan',$timeFrom , $timeUntil );

			$video = self::countRekap('penolakan',$timeFrom , $timeUntil );
			
			$content = self::countRekap('keberatan',$timeFrom , $timeUntil );

			$returnArray [] = array('permohonan' => $file, 'pemberitahuan' => $gambar,'perpanjangan' => $audio,'penolakan' => $video,'keberatan' => $content);
			//echo(' | ');
		return $returnArray;

	} 
	
	public function countRekap($type, $timeFrom = null, $timeUntil = null){
			$dateParam = 'YYYY-MM';
			$totalDays = ceil((strtotime($timeUntil)-strtotime($timeFrom))/86400);
			$year = date('Y', strtotime($timeFrom) );
			if($totalDays > 31){
				$timeFrom 	= $year.'-01-01 00:00:00';	
				$timeUntil 	= $year.'-12-31 23:59:59';	
				for($i = 0;$i<=12; $i++){
					$dateRange [] = date('Y-m', strtotime($timeFrom.' +'.$i.' month')); 
				}
			}else{
			$dateParam = 'DD/MM';
				//$dateRange [] = date('d/m', strtotime($timeFrom)); 
				for($i = 0;$i<=$totalDays; $i++){
					$dateRange [] = date('d/m', strtotime($timeFrom.' +'.$i.'days')); 
				}
			}
			
			//print_r($dateRange);
			if(empty($timeFrom) && empty($timeUntil)){
				$timeFrom 	= date('Y').'-01-01';
				$timeUntil 	= date('Y').'-12-31';
				
				$dateParam	= 'YYYY';
			}elseif($timeFrom == null && $timeUntil != null){
				$timeFrom 	= strtotime($timeUntil)-604800;
				$timeFrom 	= date('Y-m-d', $timeFrom);
				$timeUntil 	= date('Y-m-d', strtotime($timeUntil));
			}elseif($timeFrom != null && $timeUntil == null){
				$timeUntil 	= strtotime($timeFrom)+604800;
				$timeUntil 	= date('Y-m-d', $timeUntil);
				$timeFrom 	= date('Y-m-d', strtotime($timeFrom));
			}else{
				$timeFrom 	= date('Y-m-d', strtotime($timeFrom));
				$timeUntil 	= date('Y-m-d', strtotime($timeUntil));
			}
			
			switch($type){
				case 'permohonan':
				$select = new select("TO_CHAR(CAP_LAY_DATECREATED, '".$dateParam."') AS DATETIME,COUNT(*) AS COUNT","CAP_LAYAN 
						WHERE CAP_LAY_DATECREATED >= TO_DATE('".$timeFrom." 00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND CAP_LAY_DATECREATED <= TO_DATE('".$timeUntil." 23:59:59', 'YYYY-MM-DD HH24:MI:SS') AND CAP_LAY_FINALSTATUS != 4
						GROUP BY TO_CHAR(CAP_LAY_DATECREATED, '".$dateParam."') ORDER BY TO_CHAR(CAP_LAY_DATECREATED, '".$dateParam."') DESC","","","");

			$select->execute();
			
			
			
			$result =  $select->arrayResult;
			//echo $select->query;
			//return $result;
				break;
				
				case 'pemberitahuan':
				$select = new select("TO_CHAR(CAP_LAY_PEM_DATECREATED, '".$dateParam."') AS DATETIME,COUNT(*) AS COUNT","CAP_LAYAN_PEMBERITAHUAN LEFT JOIN CAP_LAYAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_PEMBERITAHUAN.FK_CAP_LAY_ID
						WHERE CAP_LAYAN_PEMBERITAHUAN.CAP_LAY_PEM_DATECREATED >= TO_DATE('".$timeFrom." 00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND CAP_LAYAN_PEMBERITAHUAN.CAP_LAY_PEM_DATECREATED <= TO_DATE('".$timeUntil." 23:59:59', 'YYYY-MM-DD HH24:MI:SS') AND CAP_LAYAN.CAP_LAY_FINALSTATUS != 4
						GROUP BY TO_CHAR(CAP_LAYAN_PEMBERITAHUAN.CAP_LAY_PEM_DATECREATED, '".$dateParam."') ORDER BY TO_CHAR(CAP_LAYAN_PEMBERITAHUAN.CAP_LAY_PEM_DATECREATED, '".$dateParam."') DESC","","","");

			$select->execute();
			
			
			
			$result =  $select->arrayResult;
			//echo $select->query;
			//return $result;
				break;
				
				case 'perpanjangan':
				$select = new select("TO_CHAR(CAP_LAY_PER_DATECREATED, '".$dateParam."') AS DATETIME,COUNT(*) AS COUNT","CAP_LAYAN_PERPANJANGAN LEFT JOIN CAP_LAYAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_PERPANJANGAN.FK_CAP_LAY_ID
						WHERE CAP_LAYAN_PERPANJANGAN.CAP_LAY_PER_DATECREATED >= TO_DATE('".$timeFrom." 00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND CAP_LAYAN_PERPANJANGAN.CAP_LAY_PER_DATECREATED <= TO_DATE('".$timeUntil." 23:59:59', 'YYYY-MM-DD HH24:MI:SS') AND CAP_LAYAN.CAP_LAY_FINALSTATUS != 4
						GROUP BY TO_CHAR(CAP_LAYAN_PERPANJANGAN.CAP_LAY_PER_DATECREATED, '".$dateParam."') ORDER BY TO_CHAR(CAP_LAYAN_PERPANJANGAN.CAP_LAY_PER_DATECREATED, '".$dateParam."') DESC","","","");

			$select->execute();
			
			
			
			$result =  $select->arrayResult;
			//echo $select->query;
			//return $result;
				break;
				
				case 'penolakan':
				$select = new select("TO_CHAR(CAP_LAY_PEN_DATECREATED, '".$dateParam."') AS DATETIME,COUNT(*) AS COUNT","CAP_LAYAN_PENOLAKAN LEFT JOIN CAP_LAYAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_PENOLAKAN.FK_CAP_LAY_ID
						WHERE CAP_LAYAN_PENOLAKAN.CAP_LAY_PEN_DATECREATED >= TO_DATE('".$timeFrom." 00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND CAP_LAYAN_PENOLAKAN.CAP_LAY_PEN_DATECREATED <= TO_DATE('".$timeUntil." 23:59:59', 'YYYY-MM-DD HH24:MI:SS') AND CAP_LAYAN.CAP_LAY_FINALSTATUS != 4
						GROUP BY TO_CHAR(CAP_LAYAN_PENOLAKAN.CAP_LAY_PEN_DATECREATED, '".$dateParam."') ORDER BY TO_CHAR(CAP_LAYAN_PENOLAKAN.CAP_LAY_PEN_DATECREATED, '".$dateParam."') DESC","","","");

			$select->execute();
			
			
			
			$result =  $select->arrayResult;
			//echo $select->query;
			//return $result;
				break;
				
				case 'keberatan':
				$select = new select("TO_CHAR(CAP_LAY_KEB_DATECREATED, '".$dateParam."') AS DATETIME,COUNT(*) AS COUNT","CAP_LAYAN_KEBERATAN
						WHERE CAP_LAY_KEB_DATECREATED >= TO_DATE('".$timeFrom." 00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND CAP_LAY_KEB_DATECREATED <= TO_DATE('".$timeUntil." 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
						GROUP BY TO_CHAR(CAP_LAY_KEB_DATECREATED, '".$dateParam."') ORDER BY TO_CHAR(CAP_LAY_KEB_DATECREATED, '".$dateParam."') DESC","","","");

			$select->execute();
			
			
			
			$result =  $select->arrayResult;
			//echo $select->query;
			//return $result;
				break;
			}
					 			
				$array = new validation();
				//print_r($dateRange);
				if (is_array($dateRange))	{		
				
					foreach($dateRange as $key => $value){
					
					$arrays = $array->searchInArrayMultidimension($result,'DATETIME',$value);
					//print_r($result);
					//print_r($arrays);
						if(isset($arrays[0])){
							if(in_array($value,$arrays[0])){
								$returnArray [] = $arrays[0]['COUNT'];
							}else{
								$returnArray [] = '0';
							}
						}else{
								$returnArray [] = '0';
							}
					}
				}
			
			return $returnArray;
			
	}
	
	public function getPermohonanData($timeFrom,$timeUntil){
		$select = new select("DISTINCT CAP_LAY_ID \"NO\", CAP_LAY_FINALSTATUS AS STATUS, CAP_LAY_DATECREATED AS TANGGAL, CAP_LAY_DATESTOPPED \"STOPDATE\",CAP_LAY_TRANSACTIONID \"KODE\",CAP_LAY_NAMA AS NAMA,CAP_LAY_TIPEPEMOHON \"TIPE\"","CAP_LAYAN LEFT JOIN CAP_LAYAN_DOCUMENT_REQUEST ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_DOCUMENT_REQUEST.FK_CAP_LAY_ID WHERE CAP_LAY_FINALSTATUS != 4 AND CAP_LAY_DATECREATED >= TO_DATE('".$timeFrom."', 'YYYY-MM-DD HH24:MI:SS') AND CAP_LAY_DATECREATED <= TO_DATE('".$timeUntil."', 'YYYY-MM-DD HH24:MI:SS') ORDER BY TANGGAL ASC","","","");
		$select->execute();
		return $select->arrayResult;
		//echo $select->query;
	}
	
	public function getPermohonanDataDetail($id){
		$select = new select(" CAP_LAY_DOC_REQ_DOCNAME AS IP, CAP_LAY_DOC_REQ_REASON \"REASON\"","CAP_LAYAN_DOCUMENT_REQUEST  WHERE FK_CAP_LAY_ID = '$id'","","","");
		$select->execute();
		return $select->arrayResult;
		//echo $select->query;
	}
	
	public function getPermohonanDataDetailPem($id){
		$select = new select("CAP_LAY_PEM_ID \"ID\", CAP_LAY_PEM_DATECREATED \"PEMDATE\", CAP_LAY_PEM_NUMBER \"PEMNUM\"","CAP_LAYAN_PEMBERITAHUAN  WHERE FK_CAP_LAY_ID = '$id'","","","");
		$select->execute();
		return $select->arrayResult;
		//echo $select->query;
	}
	/*public function getKeberatanDataDetail($id){
		$select = new select(" CAP_LAY_DOC_REQ_DOCNAME \"IP\", CAP_LAY_DOC_REQ_REASON \"REASON\"","CAP_LAYAN_DOCUMENT_REQUEST  WHERE FK_CAP_LAY_ID = '$id'","","","");
		$select->execute();
		return $select->arrayResult;
		//echo $select->query;
	}*/
	public function getPenolakanDataDetail($id){
		$select = new select("CAP_LAY_DOC_REQ_DOCNAME AS IP, CAP_LAY_PEN_DOC_NOTES \"NOTES\", CAP_LAY_PEN_DOC_PSL \"PSL\", CAP_LAY_PEN_DOC_UU \"UU\", CAP_LAY_PEN_DOC_UJI \"UJI\"","CAP_LAYAN_PENOLAKAN_DOC LEFT JOIN CAP_LAYAN_DOCUMENT_REQUEST ON CAP_LAYAN_PENOLAKAN_DOC.FK_CAP_LAY_DOC_REQ_ID = CAP_LAYAN_DOCUMENT_REQUEST.CAP_LAY_DOC_REQ_ID  WHERE CAP_LAYAN_PENOLAKAN_DOC.FK_CAP_LAY_PEN_ID = '$id'","","","");
		$select->execute();
		return $select->arrayResult;
		//echo $select->query;
	}
	public function getPerpanjanganDataDetail($id){
		$select = new select("  CAP_LAY_DOC_REQ_DOCNAME \"IP\", CAP_LAY_PER_DOC_NOTES \"NOTES\"","CAP_LAYAN_PERPANJANGAN_DOC LEFT JOIN CAP_LAYAN_DOCUMENT_REQUEST ON CAP_LAYAN_PERPANJANGAN_DOC.FK_CAP_LAY_DOC_REQ_ID = CAP_LAYAN_DOCUMENT_REQUEST.CAP_LAY_DOC_REQ_ID WHERE CAP_LAYAN_PERPANJANGAN_DOC.FK_CAP_LAY_PER_ID = '$id' ","","","");
		$select->execute();
		return $select->arrayResult;
		//echo $select->query;
	}
	public function getPemberitahuanDataDetail($id){
		$select = new select("CAP_LAY_DOC_REQ_DOCNAME AS IP, CAP_LAY_DOC_REQ_REASON \"REASON\", CAP_LAY_PEM_DOC_HARD \"HARD\", CAP_LAY_PEM_DOC_SOFT \"SOFT\", CAP_LAY_PEM_DOC_COST \"COST\", CAP_LAY_PEM_DOC_LEMBAR \"LEMBAR\", CAP_LAY_PEM_DOC_KIRIM \"KIRIM\", CAP_LAY_PEM_DOC_LAIN_LAIN \"LAIN\", CAP_LAY_PEM_DOC_METODE \"METODE\", CAP_LAY_PEM_DOC_WAKTU \"WAKTU\", CAP_LAY_PEM_DOC_NOTES \"NOTES\", FK_CAP_LAY_LIB_ID \"LIB\"","CAP_LAYAN_PEMBERITAHUAN_DOC LEFT JOIN CAP_LAYAN_DOCUMENT_REQUEST ON CAP_LAYAN_PEMBERITAHUAN_DOC.FK_CAP_LAY_DOC_REQ_ID = CAP_LAYAN_DOCUMENT_REQUEST.CAP_LAY_DOC_REQ_ID LEFT JOIN CAP_LAYAN_LIBRARY ON CAP_LAYAN_LIBRARY.CAP_LAY_LIB_ID = CAP_LAYAN_PEMBERITAHUAN_DOC.FK_CAP_LAY_LIB_ID WHERE CAP_LAYAN_PEMBERITAHUAN_DOC.FK_CAP_LAY_PEM_ID = '$id'","","","");
		$select->execute();
		return $select->arrayResult;
		//echo $select->query;
	}
	public function getKeberatanDataDetail($id){
		$select = new select("DISTINCT CAP_LAY_DOC_REQ_DOCNAME AS IP, CAP_LAY_DOC_REQ_REASON \"REASON\", CAP_LAY_KEB_DOC_RESPONSE \"T_PPID\", CAP_LAY_KEB_DOC_RESPONSE_U \"T_U\", CAP_LAY_KEB_DOC_A \"A\", CAP_LAY_KEB_DOC_B \"B\", CAP_LAY_KEB_DOC_C \"C\", CAP_LAY_KEB_DOC_D \"D\", CAP_LAY_KEB_DOC_E \"E\", CAP_LAY_KEB_DOC_F \"F\", CAP_LAY_KEB_DOC_G \"G\"","CAP_LAYAN_KEBERATAN_DOC LEFT JOIN CAP_LAYAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_KEBERATAN_DOC.FK_CAP_LAY_ID LEFT JOIN CAP_LAYAN_DOCUMENT_REQUEST ON CAP_LAYAN_DOCUMENT_REQUEST.FK_CAP_LAY_ID = CAP_LAYAN.CAP_LAY_ID WHERE FK_CAP_LAY_KEB_ID = '$id' AND CAP_LAY_DOC_REQ_DOCNAME IS NOT NULL AND CAP_LAY_DOC_REQ_REASON IS NOT NULL","","","");
		$select->execute();
		return $select->arrayResult;
		//echo $select->query;
	}
	public function getKeberatanDataDetailPem($id){
		$select = new select(" CAP_LAY_PEM_DATECREATED \"PEMDATE\", CAP_LAY_PEM_NUMBER \"PEMNUM\"","CAP_LAYAN_PEMBERITAHUAN  WHERE FK_CAP_LAY_ID = '$id'","","","");
		$select->execute();
		return $select->arrayResult;
		//echo $select->query;
	}
	
	public function getPermohonanDataDetailPer($id){
		$select = new select("CAP_LAY_PER_ID \"ID\", CAP_LAY_PER_DATECREATED \"PERDATE\", CAP_LAY_PER_NUMBER \"PERNUM\"","CAP_LAYAN_PERPANJANGAN  WHERE FK_CAP_LAY_ID = '$id'","","","");
		$select->execute();
		return $select->arrayResult;
		//echo $select->query;
	}
	
	public function getPermohonanDataDetailPen($id){
		$select = new select("CAP_LAY_PEN_ID \"ID\",CAP_LAY_PEN_DATECREATED \"PENDATE\", CAP_LAY_PEN_NUMBER \"PENNUM\"","CAP_LAYAN_PENOLAKAN  WHERE FK_CAP_LAY_ID = '$id'","","","");
		$select->execute();
		return $select->arrayResult;
		//echo $select->query;
	}
	
	public function getPermohonanDataDetailKeb($id){
		$select = new select("CAP_LAY_KEB_ID \"ID\", CAP_LAY_KEB_DATECREATED \"KEBDATE\", CAP_LAY_KEB_NUMBER \"KEBNUM\"","CAP_LAYAN_KEBERATAN  WHERE FK_CAP_LAY_ID = '$id'","","","");
		$select->execute();
		return $select->arrayResult;
		//echo $select->query;
	}
	
	public function getPemberitahuanData($timeFrom,$timeUntil){
		$select = new select("CAP_LAY_PEM_ID \"NO\",CAP_LAY_PEM_DATECREATED \"TANGGAL\",CAP_LAY_PEM_NUMBER \"KODE\",CAP_LAY_NAMA AS NAMA,CAP_LAY_TIPEPEMOHON \"TIPE\"","CAP_LAYAN LEFT JOIN CAP_LAYAN_PEMBERITAHUAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_PEMBERITAHUAN.FK_CAP_LAY_ID WHERE CAP_LAY_FINALSTATUS != 4 AND CAP_LAY_PEM_ID IS NOT NULL AND CAP_LAY_DATECREATED >= TO_DATE('".$timeFrom."', 'YYYY-MM-DD HH24:MI:SS') AND CAP_LAY_DATECREATED <= TO_DATE('".$timeUntil."', 'YYYY-MM-DD HH24:MI:SS') ORDER BY NAMA ASC","","","");
		$select->execute();
		return $select->arrayResult;
		//echo $select->query;
	}
	
	public function getPerpanjanganData($timeFrom,$timeUntil){
		$select = new select("CAP_LAY_PER_ID AS NO, FK_CAP_LAY_ID \"LAY_ID\",CAP_LAY_PER_DATECREATED \"TANGGAL\", CAP_LAY_PER_DATE_TO \"TGL_TO\",CAP_LAY_PER_NUMBER \"KODE\",CAP_LAY_NAMA AS NAMA,CAP_LAY_TIPEPEMOHON \"TIPE\"","CAP_LAYAN LEFT JOIN CAP_LAYAN_PERPANJANGAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_PERPANJANGAN.FK_CAP_LAY_ID WHERE CAP_LAY_FINALSTATUS != 4 AND CAP_LAY_PER_ID IS NOT NULL AND CAP_LAY_DATECREATED >= TO_DATE('".$timeFrom."', 'YYYY-MM-DD HH24:MI:SS') AND CAP_LAY_DATECREATED <= TO_DATE('".$timeUntil."', 'YYYY-MM-DD HH24:MI:SS') ORDER BY NO ASC","","","");
		$select->execute();
		return $select->arrayResult;
		//echo $select->query;
	}
	
	public function getPenolakanData($timeFrom,$timeUntil){
		$select = new select("CAP_LAY_PEN_ID \"NO\",CAP_LAY_PEN_DATECREATED \"TANGGAL\",CAP_LAY_PEN_NUMBER \"KODE\",CAP_LAY_NAMA AS NAMA,CAP_LAY_TIPEPEMOHON \"TIPE\"","CAP_LAYAN LEFT JOIN CAP_LAYAN_PENOLAKAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_PENOLAKAN.FK_CAP_LAY_ID WHERE CAP_LAY_FINALSTATUS != 4 AND CAP_LAY_PEN_ID IS NOT NULL AND CAP_LAY_DATECREATED >= TO_DATE('".$timeFrom."', 'YYYY-MM-DD HH24:MI:SS') AND CAP_LAY_DATECREATED <= TO_DATE('".$timeUntil."', 'YYYY-MM-DD HH24:MI:SS') ORDER BY NAMA ASC","","","");
		$select->execute();
		return $select->arrayResult;
		//echo $select->query;
	}
	
	public function getKeberatanData($timeFrom,$timeUntil,$status = null){
		$select = new select("DISTINCT CAP_LAY_KEB_ID \"NO\",CAP_LAY_KEB_DATECREATED \"TGL\",CAP_LAY_KEB_DATE_TO \"TGL_T\", CAP_USE_FIRSTNAME \"NAMA_PPID\", CAP_USE_LASTNAME \"POSISI_PPID\", CAP_LAY_PEKERJAAN \"PEKERJAAN\", CAP_LAY_ALAMAT \"ALAMAT\", CAP_LAY_TELEPON \"TELE\", CAP_LAY_EMAIL \"EMAIL\",CAP_LAY_KEB_NUMBER \"KODE\",CAP_LAY_NAMA AS NAMA,CAP_LAY_TIPEPEMOHON \"TIPE\"","CAP_LAYAN LEFT JOIN CAP_LAYAN_KEBERATAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_KEBERATAN.FK_CAP_LAY_ID LEFT JOIN CAP_USER ON CAP_LAYAN_KEBERATAN.FK_CAP_USE_ID_TGP = CAP_USER.CAP_USE_ID WHERE CAP_LAY_FINALSTATUS != 4 AND CAP_LAY_KEB_ID IS NOT NULL AND CAP_LAY_DATECREATED >= TO_DATE('".$timeFrom."', 'YYYY-MM-DD HH24:MI:SS') AND CAP_LAY_DATECREATED <= TO_DATE('".$timeUntil."', 'YYYY-MM-DD HH24:MI:SS') ORDER BY NAMA ASC","","","");
		$select->execute();
		return $select->arrayResult;
		//echo $select->query;
	}
	
	public function getPelayananIPData($timeFrom,$timeUntil,$status = null){
		if(empty($timeFrom) && empty($timeUntil)){
			
			unset($month);

			$year = date('Y');
						
			$month = array("0","1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12");

			$totalDays = 365;
			
		}else{
		
			$totalDays = ceil((strtotime($timeUntil)-strtotime($timeFrom))/86400);
			
			if($totalDays < 365){
			
				unset($month);
			
				for($i = strtotime($timeFrom); $i < strtotime($timeUntil); $i += 86400){
				
					$month []= date('Y-m-d', $i);
				
				}
				
				
				//print_r($month);
			
			}else{
				
				unset($month);

				$year = date('Y', strtotime($timeUntil));
				
				$month = array("0","1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12");
				
				
			
			}
			
		}
				
		$select = new select("","","","","");
		
		$time = new time('m');
		
		$i = 0;
		
		foreach($month as $key => $value){
		
			if($value != 0){
			
				if($totalDays < 365){
				 
					$timeFrom 		= date('Y-m-d', strtotime($value)).' 00:00:00';
					
					$timeUntil 		= date('Y-m-d', strtotime($value)).' 23:59:59';
					
					$i++;
					
					$bulan = $value;
					
				}else{
				
					$timeFrom 	= date('Y-m-d', strtotime($year.'-'.$value.'-01 00:00:00'));
					
					$timeUntil 	= date('Y-m-d', strtotime($timeFrom . ' +1 month -1 day')).' 23:59:59';
					
					$bulan = $time->returnIndonesianDate($value,'month');
					
				}
			
			$select->column = "COUNT(*) AS TOTAL";
			$select ->tableName = "CAP_LAYAN  WHERE (CAP_LAY_FINALSTATUS = 3 OR CAP_LAY_FINALSTATUS = 5) AND CAP_LAY_DATECREATED >= TO_DATE('".$timeFrom."', 'YYYY-MM-DD HH24:MI:SS') AND CAP_LAY_DATECREATED <= TO_DATE('".$timeUntil."', 'YYYY-MM-DD HH24:MI:SS')";
			$select->execute();
			$jmlPemohon = $select->arrayResult[0][TOTAL];
			$select->query;


			$select->column = "COUNT(*) AS TOTAL";
			$select ->tableName = "CAP_LAYAN_PEMBERITAHUAN_DOC LEFT JOIN CAP_LAYAN_PEMBERITAHUAN ON CAP_LAYAN_PEMBERITAHUAN_DOC.FK_CAP_LAY_PEM_ID = CAP_LAYAN_PEMBERITAHUAN.CAP_LAY_PEM_ID LEFT JOIN CAP_LAYAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_PEMBERITAHUAN.FK_CAP_LAY_ID WHERE (CAP_LAY_FINALSTATUS = 3 OR CAP_LAY_FINALSTATUS = 5) AND CAP_LAY_PEM_DOC_PPID = 1 AND CAP_LAY_DATECREATED >= TO_DATE('".$timeFrom."', 'YYYY-MM-DD HH24:MI:SS') AND CAP_LAY_DATECREATED <= TO_DATE('".$timeUntil."', 'YYYY-MM-DD HH24:MI:SS')";
			$select->execute();
			$jmlDikuasai = $select->arrayResult[0][TOTAL];
			
			$select->column = "COUNT(*) AS TOTAL";
			$select ->tableName = "CAP_LAYAN_PEMBERITAHUAN_DOC LEFT JOIN CAP_LAYAN_PEMBERITAHUAN ON CAP_LAYAN_PEMBERITAHUAN_DOC.FK_CAP_LAY_PEM_ID = CAP_LAYAN_PEMBERITAHUAN.CAP_LAY_PEM_ID LEFT JOIN CAP_LAYAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_PEMBERITAHUAN.FK_CAP_LAY_ID WHERE (CAP_LAY_FINALSTATUS = 3 OR CAP_LAY_FINALSTATUS = 5) AND CAP_LAY_PEM_DOC_LAIN IS NOT NULL AND CAP_LAY_DATECREATED >= TO_DATE('".$timeFrom."', 'YYYY-MM-DD HH24:MI:SS') AND CAP_LAY_DATECREATED <= TO_DATE('".$timeUntil."', 'YYYY-MM-DD HH24:MI:SS')";
			$select->execute();
			$jmlDialihkan = $select->arrayResult[0][TOTAL];
			
			
			$select->column = "COUNT(*) AS TOTAL";
			$select ->tableName = "CAP_LAYAN_PENOLAKAN_DOC LEFT JOIN CAP_LAYAN_PENOLAKAN ON CAP_LAYAN_PENOLAKAN_DOC.FK_CAP_LAY_PEN_ID = CAP_LAYAN_PENOLAKAN.CAP_LAY_PEN_ID LEFT JOIN CAP_LAYAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_PENOLAKAN.FK_CAP_LAY_ID WHERE (CAP_LAY_FINALSTATUS = 3 OR CAP_LAY_FINALSTATUS = 5) AND CAP_LAY_DATECREATED >= TO_DATE('".$timeFrom."', 'YYYY-MM-DD HH24:MI:SS') AND CAP_LAY_DATECREATED <= TO_DATE('".$timeUntil."', 'YYYY-MM-DD HH24:MI:SS')";
			$select->execute();
			$jmlDiTolak = $select->arrayResult[0][TOTAL];
			
			$select->column = "COUNT(*) AS TOTAL";
			$select ->tableName = "CAP_LAYAN_PENOLAKAN_DOC LEFT JOIN CAP_LAYAN_PENOLAKAN ON CAP_LAYAN_PENOLAKAN_DOC.FK_CAP_LAY_PEN_ID = CAP_LAYAN_PENOLAKAN.CAP_LAY_PEN_ID LEFT JOIN CAP_LAYAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_PENOLAKAN.FK_CAP_LAY_ID WHERE (CAP_LAY_FINALSTATUS = 3 OR CAP_LAY_FINALSTATUS = 5) AND CAP_LAY_PEN_DOC_PSL = 1 AND CAP_LAY_DATECREATED >= TO_DATE('".$timeFrom."', 'YYYY-MM-DD HH24:MI:SS') AND CAP_LAY_DATECREATED <= TO_DATE('".$timeUntil."', 'YYYY-MM-DD HH24:MI:SS')";
			$select->execute();
			$jmlPasal = $select->arrayResult[0][TOTAL];
			
			$select->column = "COUNT(*) AS TOTAL";
			$select ->tableName = "CAP_LAYAN_PENOLAKAN_DOC LEFT JOIN CAP_LAYAN_PENOLAKAN ON CAP_LAYAN_PENOLAKAN_DOC.FK_CAP_LAY_PEN_ID = CAP_LAYAN_PENOLAKAN.CAP_LAY_PEN_ID LEFT JOIN CAP_LAYAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_PENOLAKAN.FK_CAP_LAY_ID WHERE (CAP_LAY_FINALSTATUS = 3 OR CAP_LAY_FINALSTATUS = 5) AND CAP_LAY_PEN_DOC_UU IS NOT NULL AND CAP_LAY_DATECREATED >= TO_DATE('".$timeFrom."', 'YYYY-MM-DD HH24:MI:SS') AND CAP_LAY_DATECREATED <= TO_DATE('".$timeUntil."', 'YYYY-MM-DD HH24:MI:SS')";
			$select->execute();
			$jmlUU = $select->arrayResult[0][TOTAL];
			
			$select->column = "COUNT(*) AS TOTAL";
			$select ->tableName = "CAP_LAYAN_PENOLAKAN_DOC LEFT JOIN CAP_LAYAN_PENOLAKAN ON CAP_LAYAN_PENOLAKAN_DOC.FK_CAP_LAY_PEN_ID = CAP_LAYAN_PENOLAKAN.CAP_LAY_PEN_ID LEFT JOIN CAP_LAYAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_PENOLAKAN.FK_CAP_LAY_ID WHERE (CAP_LAY_FINALSTATUS = 3 OR CAP_LAY_FINALSTATUS = 5) AND CAP_LAY_PEN_DOC_UJI IS NOT NULL AND CAP_LAY_DATECREATED >= TO_DATE('".$timeFrom."', 'YYYY-MM-DD HH24:MI:SS') AND CAP_LAY_DATECREATED <= TO_DATE('".$timeUntil."', 'YYYY-MM-DD HH24:MI:SS')";
			$select->execute();
			$jmlUji = $select->arrayResult[0][TOTAL];
			
			$select->column = "COUNT(*) AS TOTAL";
			$select ->tableName = "CAP_LAYAN_PEMBERITAHUAN_DOC LEFT JOIN CAP_LAYAN_PEMBERITAHUAN ON CAP_LAYAN_PEMBERITAHUAN_DOC.FK_CAP_LAY_PEM_ID = CAP_LAYAN_PEMBERITAHUAN.CAP_LAY_PEM_ID LEFT JOIN CAP_LAYAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_PEMBERITAHUAN.FK_CAP_LAY_ID WHERE (CAP_LAY_FINALSTATUS = 3 OR CAP_LAY_FINALSTATUS = 5) AND CAP_LAY_PEM_DOC_KUASAI = 1 AND CAP_LAY_DATECREATED >= TO_DATE('".$timeFrom."', 'YYYY-MM-DD HH24:MI:SS') AND CAP_LAY_DATECREATED <= TO_DATE('".$timeUntil."', 'YYYY-MM-DD HH24:MI:SS')";
			$select->execute();
			$jmlKuasai = $select->arrayResult[0][TOTAL];

			$select->column = "COUNT(*) AS TOTAL";
			$select ->tableName = "CAP_LAYAN_PEMBERITAHUAN_DOC LEFT JOIN CAP_LAYAN_PEMBERITAHUAN ON CAP_LAYAN_PEMBERITAHUAN_DOC.FK_CAP_LAY_PEM_ID = CAP_LAYAN_PEMBERITAHUAN.CAP_LAY_PEM_ID LEFT JOIN CAP_LAYAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_PEMBERITAHUAN.FK_CAP_LAY_ID WHERE (CAP_LAY_FINALSTATUS = 3 OR CAP_LAY_FINALSTATUS = 5) AND CAP_LAY_PEM_DOC_DOKUMENTASI = 1 AND CAP_LAY_DATECREATED >= TO_DATE('".$timeFrom."', 'YYYY-MM-DD HH24:MI:SS') AND CAP_LAY_DATECREATED <= TO_DATE('".$timeUntil."', 'YYYY-MM-DD HH24:MI:SS')";
			$select->execute();
			$jmlDokumentasi = $select->arrayResult[0][TOTAL];
			
			$select->column = "COUNT(CAP_LAY_DOC_REQ_ID) AS TOTAL";
			$select ->tableName = "CAP_LAYAN_DOCUMENT_REQUEST LEFT JOIN CAP_LAYAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_DOCUMENT_REQUEST.FK_CAP_LAY_ID WHERE (CAP_LAY_FINALSTATUS = 3 OR CAP_LAY_FINALSTATUS = 5) AND CAP_LAY_DATECREATED >= TO_DATE('".$timeFrom."', 'YYYY-MM-DD HH24:MI:SS') AND CAP_LAY_DATECREATED <= TO_DATE('".$timeUntil."', 'YYYY-MM-DD HH24:MI:SS')";
			$select->execute();
			$jmlIP = $select->arrayResult[0][TOTAL];
			
			$jmlDiTolak += $jmlKuasai+$jmlDokumentasi;

			
			$builtArray [] = array('URAIAN'=> $bulan, 'TOTAL'=>$jmlPemohon, 'DIPENUHI' => $jmlDikuasai, 'DIALIHKAN' => $jmlDialihkan, 'DITOLAK' => $jmlDiTolak, 'PASAL' => $jmlPasal,'UU' => $jmlUU,'UJI' => $jmlUji,'BUKAN' => $jmlDokumentasi ,'KUASAI' => $jmlKuasai, 'IP' => $jmlIP);
			}
		}
		
		
		return $builtArray;
		//echo $select->query;
	}
	
	public function getWaktuPelayananIPData($timeFrom,$timeUntil,$status = null){
		$layan = new layan();
		$year = date('Y', strtotime($timeUntil));
		
		$month = array("0","1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12");
		
		$select = new select("","","","","");
		$select1 = new select("","","","","");
		
		$time = new time('m');
		
		
		
		$timeFromOri = $timeFrom;
		$timeUntilOri = $timeUntil;
		
		foreach($month as $key => $value){
			if($value != 0){
				$timeFrom 	= date('Y-m-d', strtotime($year.'-'.$value.'-01 00:00:00'));
				$timeUntil 	= date('Y-m-d', strtotime($timeFrom . ' +1 month -1 day')).' 23:59:59';
				
				$select->column = "COUNT(CAP_LAY_DOC_REQ_ID) AS TOTAL";
				$select ->tableName = "CAP_LAYAN_DOCUMENT_REQUEST LEFT JOIN CAP_LAYAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_DOCUMENT_REQUEST.FK_CAP_LAY_ID WHERE (CAP_LAY_FINALSTATUS = 3 OR CAP_LAY_FINALSTATUS = 5) AND CAP_LAY_DATECREATED >= TO_DATE('".$timeFrom."', 'YYYY-MM-DD HH24:MI:SS') AND CAP_LAY_DATECREATED <= TO_DATE('".$timeUntil."', 'YYYY-MM-DD HH24:MI:SS')";
				$select->execute();
				$jmlIP = $select->arrayResult[0][TOTAL];
				
				$select->column = "COUNT(*) AS TOTAL";
				$select ->tableName = "CAP_LAYAN_PEMBERITAHUAN_DOC LEFT JOIN CAP_LAYAN_PEMBERITAHUAN ON CAP_LAYAN_PEMBERITAHUAN_DOC.FK_CAP_LAY_PEM_ID = CAP_LAYAN_PEMBERITAHUAN.CAP_LAY_PEM_ID LEFT JOIN CAP_LAYAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_PEMBERITAHUAN.FK_CAP_LAY_ID WHERE (CAP_LAY_FINALSTATUS = 3 OR CAP_LAY_FINALSTATUS = 5) AND CAP_LAY_PEM_DOC_PPID = 1 AND CAP_LAY_DATECREATED >= TO_DATE('".$timeFrom."', 'YYYY-MM-DD HH24:MI:SS') AND CAP_LAY_DATECREATED <= TO_DATE('".$timeUntil."', 'YYYY-MM-DD HH24:MI:SS')";
				$select->execute();
				$jmlDikuasai = $select->arrayResult[0][TOTAL];
				
				$select	-> column = "CAP_LAY_DATESTOPPED, CAP_LAY_DATECREATED, (CAP_LAY_DATESTOPPED - CAP_LAY_DATECREATED) as DAYS";
				$select -> tableName = "CAP_LAYAN_PEMBERITAHUAN_DOC LEFT JOIN CAP_LAYAN_PEMBERITAHUAN ON CAP_LAYAN_PEMBERITAHUAN_DOC.FK_CAP_LAY_PEM_ID = CAP_LAYAN_PEMBERITAHUAN.CAP_LAY_PEM_ID LEFT JOIN CAP_LAYAN ON CAP_LAYAN.CAP_LAY_ID = CAP_LAYAN_PEMBERITAHUAN.FK_CAP_LAY_ID WHERE (CAP_LAY_FINALSTATUS = 3 OR CAP_LAY_FINALSTATUS = 5) AND CAP_LAY_PEM_DOC_PPID = 1 AND CAP_LAY_DATECREATED >= TO_DATE('".$timeFrom."', 'YYYY-MM-DD HH24:MI:SS') AND CAP_LAY_DATECREATED <= TO_DATE('".$timeUntil."', 'YYYY-MM-DD HH24:MI:SS')";
				$select->execute();
				//echo $select->query;
				$a = 0;
				$b = 0;
				$c = 0;
				$d = 0;
				$e = 0;

				if(!empty($select->arrayResult)){
					foreach($select->arrayResult as $keys => $values){
						
						$days = $layan->getCurrentTimeOverviewStyle($values[CAP_LAY_DATECREATED],$values[CAP_LAY_DATESTOPPED]);
						//echo $days.' | ';
						//$days = $values[DAYS] - $days;
						
						//echo $days.' | ';
						if($days <3){
							$a++;
						}
						elseif($days >=3 && $days < 6){
							$b++;
						}
						elseif($days >=6 && $days < 11){
							$c++;
						}
						elseif($days >=11 && $days < 17){
							$d++;
						}
						elseif($days >=17){
							$e++;
						}
						
					}
				}
				$jmlBS = $a;
				$jmlB = $b;
				$jmlC = $c;
				$jmlBr = $d;
				$jmlBrs = $e;
				
				
				//echo $select->query;
				$bulan = $time->returnIndonesianDate($value,'month');
				$builtArray [] = array('URAIAN'=> $bulan, 'TOTAL'=>$jmlPemohon, 'DIPENUHI' => $jmlDikuasai, 'BS' => $jmlBS, 'B' => $jmlB, 'C' => $jmlC,'Br' => $jmlBr,'BrS' => $jmlBrs, 'IP' => $jmlIP);
				
			}
			
		}
		
		return $builtArray;
		//echo $select->query;
	}
}

?>