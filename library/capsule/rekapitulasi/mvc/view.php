<?php
namespace library\capsule\rekapitulasi\mvc;

use \DateTime;
use \framework\time;
use \framework\date;
use \framework\server;
use \framework\user;
use \framework\encryption;
use \library\capsule\layan\mvc\model as layan;

class view extends model {

protected $params,$data;
public $error;

    public function __construct($params,$data = null,$error = null) {
    
    parent::__construct("","");
    
    	if (isset($_SESSION['admin']) || !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    	$this->optionGear = "<span class='" . $this->params . "-optionGear'><img class='optionGear' src='library/capsule/admin/image/settingCap.png'></span>";
   	 	}
   	 	
   	 	if($params == null){
	   	 self::emptyMethod();	
   	 	}else{
   	 	
   	 	$this->params = $params; if ($this->params == '{view}') {self::normal();} else {self::$params();}
   	 	
   	 	}
    }
    
    public function normal(){
    
    $view  .= $this->optionGear;
    
    $view  .= "Please Select a View";  
    
    echo $view;
    
	}
	
	public function icon_rekap() {
										
		$view  = $this->optionGear;
		
		//$name  = $this->getUserName();
		
		//$user  = unserialize($_SESSION['user']); $id = $user->getID();
		
		$view .= "<div class='layan-icon-container'>";
		
		$view .= "<a href='index.php?id=2265'><div class='coresystem-icon-float-left-new-home' text='print'>Dashboard</div></a>";
		
		$view .= "<a href='index.php?id=2304' ><div class='coresystem-icon-float-left-new-document' text='Buka Si Dado'>Report</div></a>";
		/*
		$view .= "<a href='?id=2188' ><div class='rekapitulasi-icon-float-left-new-document' text='Buka Si Dado'>Document</div></a>";
		
		$view .= "<a href='?id=2189' ><div class='rekapitulasi-icon-float-left-new-history' text='Buka Si Dado'>History</div></a>";

		$view .= "<a href='?id=2244'><div class='rekapitulasi-icon-float-left-new-setting' text='Settings'>Settings</div></a>";
		*/
		
		$view .= "</div>";
		
		$view .= "<span class='user-name-normal' login='yes'  SSID='"./*$user->getID()*/$i."'><a href='index.php?id=logout'><div class='rekapitulasi-logout-container'>";
		
		$view .= "Logout";
				
		$view .= "</div></a>";
		
		$view .= "<div class='layan-icon_admin-name-container'>";
		
		$view .= ucwords(strtolower($name));
				
		$view .= "</div>";
					
		echo $view;
		
	}
	
	public function emptyMethod(){
		
	}
	
	public function dashboard($year = null, $dateFrom = null, $dateTo = null){
		//$view  .= $this->optionGear;
		$view .="<div class='container-below-div'>";
		$layan = new layan();
		if($year == null){
			$year = date('Y');
		}
		if($dateFrom == null && $dateTo == null){
			
			$dateFrom 	= $year.'-01-01 00:00:00';	
			$dateTo 	= $year.'-12-31 23:59:59';	
			
			$captionDate = "'Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'";
		}else{
			
			$dateFrom 	= date('Y-m-d',strtotime($dateFrom)).' 00:00:00';
			$dateTo		= date('Y-m-d',strtotime($dateTo)).' 23:59:59';
			
			$displayDateF = date('d-m-Y',strtotime($dateFrom));
			$displayDateT = date('d-m-Y',strtotime($dateTo)); 
			for($i= strtotime($dateFrom); $i <= strtotime($dateTo); $i += 86400){
			
			$captionDate .="'".date('d/m', $i)."',";	
			} 
			$captionDate = substr($captionDate,0,-1);
		}
		
		$stats = $this->getStatsRekap($dateFrom, $dateTo);
		//print_r($stats); 
		if(!empty($stats)){
		for($i=0; $i<count($stats[0]['permohonan']); $i++){
			$spline []= ($stats[0]['permohonan'][$i] + $stats[0]['pemberitahuan'][$i] +$stats[0]['perpanjangan'][$i] +$stats[0]['penolakan'][$i] +$stats[0]['keberatan'][$i] )/5;
			
		}
		//print_r($spline);
		$permohonanStats 	= implode(",", $stats[0]['permohonan']);
		$pemberitahuanStats = implode(",", $stats[0]['pemberitahuan']);
		$perpanjanganStats 	= implode(",", $stats[0]['perpanjangan']);
		$penolakanStats 	= implode(",", $stats[0]['penolakan']);
		$keberatanStats 	= implode(",", $stats[0]['keberatan']);		
		$spline				= implode(",", $spline);
		}
		$permohonan 	= $this->getPermohonanDetail($year, $dateFrom, $dateTo);
		$pemberitahuan 	= $this->getPemberitahuanDetail($year, $dateFrom, $dateTo);
		$perpanjangan 	= $this->getPerpanjanganDetail($year, $dateFrom, $dateTo);
		$penolakan 		= $this->getPenolakanDetail($year, $dateFrom, $dateTo);		
		$keberatan 		= $this->getKeberatanDetail($year, $dateFrom, $dateTo);
		$minDate 		= ($this->getMinRangeDate($year, $dateFrom, $dateTo));
		$maxDate 		= ($this->getMaxRangeDate($year, $dateFrom, $dateTo));
		$avgDate 		= ($this->getAvgRangeDate($year, $dateFrom, $dateTo));
		$rangeDate 		= $this->getRangeDate($year, $dateFrom, $dateTo);
		//print_r($maxDate); 
		//echo date('i',strtotime($maxDate[0][DAYS]));
		$IPDays 		= strtotime($minDate[0][DAYS]);
		$IPDaysMax		= strtotime($maxDate[0][DAYS]);
		$IPDaysAvg		= strtotime($avgDate[0][DAYS]);
		if(!empty($rangeDate)){
		foreach($rangeDate as $keyDateIP => $valueDateIP){
			if($valueDateIP[DAYS] == $minDate[0][DAYS]){
				 $startDateIP 	= $valueDateIP[CAP_LAY_DATECREATED];
				 $endDateIP		= $valueDateIP[CAP_LAY_DATESTOPPED];
			}
			if($valueDateIP[DAYS] == $maxDate[0][DAYS]){
				  $startDateIPMax 	= $valueDateIP[CAP_LAY_DATECREATED];
				  $endDateIPMax		= $valueDateIP[CAP_LAY_DATESTOPPED];
			}
			$bulitArrayMin [] = $valueDateIP[CAP_LAY_DATECREATED];
			$bulitArrayMax [] = $valueDateIP[CAP_LAY_DATESTOPPED];
		}
		
		
		 $minDateDays = $layan->getCurrentTimeOverviewStyle(date('Y-m-d',strtotime($startDateIP)),date('Y-m-d',strtotime($endDateIP)));
		 $maxDateDays = $layan->getCurrentTimeOverviewStyle(date('Y-m-d',strtotime($startDateIPMax)),date('Y-m-d',strtotime($endDateIPMax)));
		 $avgDateDays = $layan->getCurrentTimeOverviewStyle(date('Y-m-d',strtotime(min($bulitArrayMin))),date('Y-m-d',strtotime(max($bulitArrayMax))));
		}
		if(!empty($avgDateDays) && !empty($rangeDate)){
		$avgDateDays = ceil($avgDateDays/count($rangeDate));
		}
		if($minDateDays > 0 ){
			$timeForMinDate .= $minDateDays . ' Hari ';
		}
		if(date('H', $IPDays) > 0){
			$timeForMinDate .= date('H', $IPDays) . ' Jam ';
		}   
		if(date('i', $IPDays) > 0){
			$timeForMinDate .= date('i', $IPDays) . ' Menit '; 
		}
		if($maxDateDays > 0 ){
			$timeForMaxDate .= $maxDateDays . ' Hari ';
		}
		if(date('H', $IPDaysMax) > 0){
			$timeForMaxDate .= date('H', $IPDaysMax) . ' Jam ';
		}
		if(date('i', $IPDaysMax) > 0){
			$timeForMaxDate .= date('i', $IPDaysMax) . ' Menit '; 
		}
		if($avgDateDays > 0 ){
			$timeForAvgDate .= $avgDateDays . ' Hari ';
		}
		if(date('H', $IPDaysAvg) > 0){
			$timeForAvgDate .= date('H', $IPDaysAvg) . ' Jam ';
		}
		if(date('i', $IPDaysMax) > 0){
			$timeForAvgDate .= date('i', $IPDaysAvg) . ' Menit '; 
		}
		//echo $timeForMaxDate;
		//count Keberatan
		$minDateKeb 		= $this->getMinRangeDateKeb($year, $dateFrom, $dateTo);
		$maxDateKeb 		= $this->getMaxRangeDateKeb($year, $dateFrom, $dateTo);
		$avgDateKeb 		= $this->getAvgRangeDateKeb($year, $dateFrom, $dateTo);
		$rangeDateKeb 		= $this->getRangeDateKeb($year, $dateFrom, $dateTo);
		
		$KebDays 			= strtotime($minDateKeb[0][DAYS]);
		$KebDaysMax			= strtotime($maxDateKeb[0][DAYS]);
		$KebDaysAvg			= strtotime($avgDateKeb[0][DAYS]);
		//print_r($rangeDateKeb);
		if(!empty($rangeDateKeb)){
		foreach($rangeDateKeb as $keyDateKeb => $valueDateKeb){
			if($valueDateKeb[DAYS] == $minDateKeb[0][DAYS]){
				$startDateKeb		= $valueDateKeb[CAP_LAY_KEB_DATECREATED];
				$endDateKeb			= $valueDateKeb[CAP_LAY_KEB_DATE_TO];
			}
			
			if($valueDateKeb[DAYS] == $maxDateKeb[0][DAYS]){
				$startDateKebMax	= $valueDateKeb[CAP_LAY_KEB_DATECREATED];
				$endDateKebMax		= $valueDateKeb[CAP_LAY_KEB_DATE_TO];
			}
			$bulitArrayKebMin	[]	= $valueDateKeb[CAP_LAY_KEB_DATECREATED];
			$builtArrayKebMax	[]	= $valueDateKeb[CAP_LAY_KEB_DATE_TO];
		}
		
		$minDateDaysKeb = $layan->getCurrentTimeOverviewStyle(date('Y-m-d',strtotime($startDateKeb)),date('Y-m-d',strtotime($endDateKeb)));
		$maxDateDaysKeb = $layan->getCurrentTimeOverviewStyle(date('Y-m-d',strtotime($startDateKebMax)),date('Y-m-d',strtotime($endDateKebMax)));
		$avgDateDaysKeb = $layan->getCurrentTimeOverviewStyle(date('Y-m-d',strtotime(min($bulitArrayKebMin))),date('Y-m-d',strtotime(max($builtArrayKebMax))));
		
		$avgDateDaysKeb = ceil(($avgDateDaysKeb)/count($rangeDateKeb));
		}
		
		if($minDateDaysKeb > 1 ){
			$timeForMinDateKeb .= $minDateDaysKeb . ' Hari ';
		}
		
		if(!empty($KebDays)){
			if(date('H', $KebDays) > 0){
				$timeForMinDateKeb .= date('H', $KebDays) . ' Jam ';
			}
			if(date('i', $KebDays) > 0){
				$timeForMinDateKeb .= date('i', $KebDays) . ' Menit '; 
			}
		}else{
			$timeForMinDateKeb .= "";
		}
		
		if($maxDateDaysKeb > 0 ){
			$timeForMaxDateKeb .= $maxDateDaysKeb . ' Hari ';
		}
		if(!empty($KebDaysMax)){
			if(date('H', $KebDaysMax) > 0){
				$timeForMaxDateKeb .= date('H', $KebDaysMax) . ' Jam ';
			}
			if(date('i', $KebDaysMax) > 0){
				$timeForMaxDateKeb .= date('i', $KebDaysMax) . ' Menit '; 
			}
		}else{
			$timeForMaxDateKeb .= "";
		}
		
		if($avgDateDaysKeb > 0 ){
			$timeForAvgDateKeb .= $avgDateDaysKeb . ' Hari ';
		}
		if(!empty($KebDaysAvg)){
			if(date('H', $KebDaysAvg) > 0){
				$timeForAvgDateKeb .= date('H', $KebDaysAvg) . ' Jam ';
			}
			if(date('i', $KebDaysAvg) > 0){
				$timeForAvgDateKeb .= date('i', $KebDaysAvg) . ' Menit '; 
			}
		}else{
			$timeForAvgDateKeb .= "";
		}
		
		$timeForMinDate 	.= date('s', $IPDays) . ' Detik';
		$timeForMaxDate 	.= date('s', $IPDaysMax) . ' Detik';
		$timeForAvgDate 	.= date('s', $IPDaysAvg) . ' Detik';
		$timeForMinDateKeb 	.= date('s', $KebDays) . ' Detik';
		$timeForMaxDateKeb 	.= date('s', $KebDaysMax) . ' Detik';
		$timeForAvgDateKeb 	.= date('s', $KebDaysAvg) . ' Detik';
		
		
		
		$view .= "<script type=\"text/javascript\">
						jQuery.noConflict()(function($){
							

						
							var chart;
							$(document).ready(function() {
								chart = new Highcharts.Chart({
									chart: {
										renderTo: 'rekapitulasi-dashboard-chart-container',
										type: 'column'
									},
									title: {
										text: ''
									},
									xAxis: {
										categories: [
											".$captionDate."
										]
									},
									yAxis: {
										min: 0,
										title: {
											text: 'Jumlah Dokumen'
										}
									},
									legend: {
										layout: 'vertical',
										backgroundColor: '#FFFFFF',
										align: 'right',
										verticalAlign: 'left',
										x: 0,
										y: 50,
										floating: true,
										shadow: true
									},
									tooltip: {
										formatter: function() {
											return ''+
												this.x +': '+ this.y +' dokumen';
										}
									},
									plotOptions: {
										column: {
											pointPadding: 0.2,
											borderWidth: 0
										}
									},
										series: [{
										name: 'Permohonan',
										data: [$permohonanStats]
							
									}, {
										name: 'Pemberitahuan',
										data: [$pemberitahuanStats]
							
									}, {
										name: 'Perpanjangan',
										data: [$perpanjanganStats]
							
									}, {
										name: 'Penolakan',
										data: [$penolakanStats]
							
									}, {
										name: 'Keberatan',
										data: [$keberatanStats]
							
									},{
										type: 'spline',
										name: 'Rata - rata Dokumen',
										data: [$permohonanStats]
									}]
								});
							});
							var chart;
$(document).ready(function() {
	chart = new Highcharts.Chart({
		chart: {
			renderTo: 'rekapitulasi-dashboard-pie-container',
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false
		},
		title: {
			text: ''
		},
		
		
		series: [{
			type: 'pie',
			name: 'Jumlah',
			data: [{
				name: 'Permohonan',
				y: ".$permohonan[0]['PERMOHONAN'].",
				color: '#4572A7' // Jane's color
			}, {
				name: 'Pemberitahuan',
				y: ".$pemberitahuan[0]['PEMBERITAHUAN'].",
				color: '#AA4643' // John's color
			}, {
				name: 'Perpanjangan',
				y: ".$perpanjangan[0]['PERPANJANGAN'].",
				color: '#89A54E' // Joe's color
			}, {
				name: 'Penolakan',
				y: ".$penolakan[0]['PENOLAKAN'].",
				color: '#816a9c' // Joe's color
			}, {
				name: 'Keberatan',
				y: ".$keberatan[0]['KEBERATAN'].",
				color: '#4096AD' // Joe's color
			}],
			center: [75, 140],
			size: 150,
			showInLegend: false,
			dataLabels: {
				enabled: false
			}
		}]
	});
	$('.datepicker-rekap-from').click().datepicker({  
                    //defaultDate: '-7d',
                    changeMonth: true,
                    changeYear: true,
                    numberOfMonths: 1,
                    dateFormat: 'dd-mm-yy',
                    showOtherMonths: true,
			selectOtherMonths: true,
                    onSelect: function( selectedDate ) {
                      $( '.datepicker-to' ).datepicker( 'option', 'minDate', selectedDate );
                     // $( '.datepicker-from' ).datepicker( 'option', 'maxDate', '+1w' );
                     //$('.datepicker-to').datepicker({  
                     //     minDate: selectedDate,
                    //      maxDate: '+7d'
                        
                    // });
                    }
                  });
                  
                $('.datepicker-rekap-to').click().datepicker({  
                   // defaultDate: '+1d -1d',
                  changeMonth: true,
                  changeYear: true,
                  dateFormat: 'dd-mm-yy',
                  numberOfMonths: 1,
                  showOtherMonths: true,
			selectOtherMonths: true,
                  onSelect: function( selectedDate ) {
                    $( '.datepicker-from' ).datepicker( 'option', 'maxDate', selectedDate );
                    //$( '.datepicker-to' ).datepicker( 'option', 'minDate', '-1w' );
                    //$('.datepicker-to').datepicker({  
                    //      maxDate: selectedDate,
                    //      minDate: '-7d'
                        
                    //  });
                  }
                });

	
});
						});
						</script>";
						$view .= '<div style="margin:20px;">';
						$view .= '	<div class="rekapitulasi-dashboard-chart-header">';
						$view .= '<div  class="rekapitulasi-dashboard-input-container">';		
						$view .= '		  <input type="text" class="dado-featured-form-input datepicker-rekap-from datepicker-content-handler-from" value="'.$displayDateF.'" />';
		                $view .= '          <span class="rekapitulasi-dashboard-text">To</span>';
		                $view .= '          <input type="text" class="dado-featured-form-input datepicker-rekap-to datepicker-content-handler-to" value="'.$displayDateT.'" />';
		                $view .= '          <input type="hidden" value="days" class="typeOfdate">';
		                $view .= '</div>';
		                $view .= '          <div class="rekapitulasi-dashboard-go"><button type="submit"  value="Go" class="featured-dado-button-rekap">Go</button></div>';
		                $view .= '          <div class="rekapitulasi-dashboard-print"><button type="submit"  value="Go" class="featured-dado-button-print">Print</button></div>'; 
		                
		                $view .= '          <div class="rekapitulasi-dashboard-select-year">';
			            $view .= '              <select class="rekapitulasi-dashboard-year">';
			            for($i =2009; $i <= date('Y'); $i++ ){
			            	
			            	if($i == $year){
				            	$view .= '<option selected="selected" value="'.$i.'">'.$i.'</option>';
			            	}else{
			            		$view .= '<option value="'.$i.'">'.$i.'</option>';
				            }
			            }
			            $view .= '              </select>';
		                $view .= '          </div>';
						$view .= '	</div>';
						$view .= '	<div class="rekapitulasi-dashboard-all-wrapper">';
						$view .= '	<div class="rekapitulasi-dashboard-container-chart">';
						$view .= '     		<div class="rekapitulasi-dashboard-title" >Rekapitulasi Pelayananan Informasi Publik tahun '.$year.'</div>';
						$view .= '		<div class="rekapitulasi-dashboard-chart-container"><div id="rekapitulasi-dashboard-chart-container" ></div></div>';
						$view .= '	</div>';
						
						
						
						$view .= '	<div  class="rekapitulasi-dashboard-detail-container">';
						$view .= '     		';
						$view .= '		<div class="rekapitulasi-dashboard-pie-left"><div class="rekapitulasi-dashboard-title" >Statistik IP</div><div class="rekapitulasi-dashboard-pie-container"><div id="rekapitulasi-dashboard-pie-container"></div></div></div>';
						$view .= '		<div  class="rekapitulasi-dashboard-container-counter">';
						$view .= '			<div class="rekapitulasi-dashboard-counter">';
						$view .= '				<a href="index.php?id=2304&type='.base64_encode('Permohonan').'&from='.base64_encode($dateFrom).'&to='.base64_encode($dateTo).'"><div class="box-hover">';
						$view .= '					<div class = "rekap-dashboard-stats-number"> ';
						$view .= '						'.$permohonan[0]['PERMOHONAN'];
						$view .= '					</div>';
						$view .= '					<div class = "rekap-dashboard-stats-teks";> ';
						$view .= '						Permohonan';
						$view .= '					</div>';
						$view .= '				</div></a>';
						$view .= '				<a href="index.php?id=2304&type='.base64_encode('Pemberitahuan').'&from='.base64_encode($dateFrom).'&to='.base64_encode($dateTo).'"><div style="" class="box-hover">';
						$view .= '					<div class = "rekap-dashboard-stats-number"> ';
						$view .= '						'.$pemberitahuan[0]['PEMBERITAHUAN'];
						$view .= '					</div>';
						$view .= '					<div class = "rekap-dashboard-stats-teks";> ';
						$view .= '						Pemberitahuan';
						$view .= '					</div>';
						$view .= '				</div></a>';
						$view .= '				<a href="index.php?id=2304&type='.base64_encode('Perpanjangan').'&from='.base64_encode($dateFrom).'&to='.base64_encode($dateTo).'"><div style="" class="box-hover">';
						$view .= '					<div class = "rekap-dashboard-stats-number"> ';
						$view .= '						'.$perpanjangan[0]['PERPANJANGAN'];
						$view .= '					</div>';
						$view .= '					<div class = "rekap-dashboard-stats-teks";> ';
						$view .= '						Perpanjangan';
						$view .= '					</div>';
						$view .= '				</div></a>';
						$view .= '				<a href="index.php?id=2304&type='.base64_encode('Penolakan').'&from='.base64_encode($dateFrom).'&to='.base64_encode($dateTo).'"><div style="" class="box-hover">';
						$view .= '					<div class = "rekap-dashboard-stats-number"> ';
						$view .= '						'.$penolakan[0]['PENOLAKAN'];
						$view .= '					</div>';
						$view .= '					<div class = "rekap-dashboard-stats-teks";> ';
						$view .= '						Penolakan';
						$view .= '					</div>';
						$view .= '				</div></a>';
						$view .= '				<a href="index.php?id=2304&type='.base64_encode('Keberatan').'&from='.base64_encode($dateFrom).'&to='.base64_encode($dateTo).'"><div style="" class="box-hover-last">';
						$view .= '					<div class = "rekap-dashboard-stats-number"> ';
						$view .= '						'.$keberatan[0]['KEBERATAN'];
						$view .= '					</div>';
						$view .= '					<div class = "rekap-dashboard-stats-teks";> ';
						$view .= '						Keberatan';
						$view .= '					</div>';
						$view .= '				</div></a>';
						$view .= '			</div>';
						$view .= '			<div  class="rekapitulasi-dashboard-title-container">';
						$view .= '     		<div class="rekapitulasi-dashboard-title">Pelayanan Informasi Publik</div>';
						$view .= '			<div class="rekapitulasi-dashboard-wrapper">';
						$view .= '				<div class="rekapitulasi-dashboard-div-container">';
						$view .= '					<div class = "rekap-dashboard-stats-number-time"> ';
						$view .= '						'.$timeForAvgDate;
						$view .= '					</div>';
						$view .= '					<div class = "rekap-dashboard-stats-teks-time";> ';
						$view .= '						Average';
						$view .= '					</div>';
						$view .= '				</div>';
						$view .= '				<div class="rekapitulasi-dashboard-div-container">';
						$view .= '					<div class = "rekap-dashboard-stats-number-time"> ';
						$view .= '						'.$timeForMaxDate;
						$view .= '					</div>';
						$view .= '					<div class = "rekap-dashboard-stats-teks-time";> ';
						$view .= '						Maximum';
						$view .= '					</div>';
						$view .= '				</div>';
						$view .= '				<div class="rekapitulasi-dashboard-div-container-last">';
						$view .= '					<div class = "rekap-dashboard-stats-number-time"> ';
						$view .= '						'.$timeForMinDate;
						$view .= '					</div>';
						$view .= '					<div class = "rekap-dashboard-stats-teks-time";> ';
						$view .= '						Minimum';
						$view .= '					</div>';
						$view .= '				</div>';
						$view .= '			</div>';
						$view .= '			</div>';
						$view .= '			<div class="rekapitulasi-dashboard-title-container">';
						$view .= '     		<div class="rekapitulasi-dashboard-title">Pelayanan Keberatan</div>';
						$view .= '			<div  class="rekapitulasi-dashboard-wrapper">';
						$view .= '				<div class="rekapitulasi-dashboard-div-container">';
						$view .= '					<div class = "rekap-dashboard-stats-number-time"> ';
						$view .= '						'.$timeForAvgDateKeb;
						$view .= '					</div>';
						$view .= '					<div class = "rekap-dashboard-stats-teks-time";> ';
						$view .= '						Average';
						$view .= '					</div>';
						$view .= '				</div>';
						$view .= '				<div class="rekapitulasi-dashboard-div-container">';
						$view .= '					<div class = "rekap-dashboard-stats-number-time"> ';
						$view .= '						'.$timeForMaxDateKeb;
						$view .= '					</div>';
						$view .= '					<div class = "rekap-dashboard-stats-teks-time";> ';
						$view .= '						Maximum';
						$view .= '					</div>';
						$view .= '				</div>';
						$view .= '				<div class="rekapitulasi-dashboard-div-container-last">';
						$view .= '					<div class = "rekap-dashboard-stats-number-time"> ';
						$view .= '						'.$timeForMinDateKeb;
						$view .= '					</div>';
						$view .= '					<div class = "rekap-dashboard-stats-teks-time";> ';
						$view .= '						Minimum';
						$view .= '					</div>';
						$view .= '				</div>';
						$view .= '			</div>';
						$view .= '			</div>';
						$view .= '		</div>';
								
						$view .= '	</div>';
							
						$view .= '	</div>';
						$view .= '</div>';
						
						$view .= '</div>';
						
						echo $view;
	}
	
	public function detail(){
	
	$dayIN = new time('N'); 
	
	if(!empty($_GET['type'])){
		
		$nameType = base64_decode($_GET['type']);
	
		$type 	= "get".base64_decode($_GET['type'])."Data"; 
		
		if(isset($_GET['from']) && isset($_GET['to'])){
			$dateFrom = date('Y-m-d',strtotime(base64_decode($_GET['from']))).' 00:00:00';
			$dateTo   = date('Y-m-d',strtotime(base64_decode($_GET['to']))).' 23:59:59';
			$displayDateF = date('d-m-Y',strtotime($dateFrom));
			$displayDateT = date('d-m-Y',strtotime($dateTo)); 
		}else{
			$dateFrom = date('Y').'-01-01 00:00:00';
			$dateTo   = date('Y').'-12-31 23:59:59';
		}
		$view .= "<script type='text/javascript'>
				jQuery.noConflict()(function($){
				$('.datepicker-rekap-from').click().datepicker({  
                    //defaultDate: '-7d',
                    changeMonth: true,
                    changeYear: true,
                    numberOfMonths: 1,
                    dateFormat: 'dd-mm-yy',
                    showOtherMonths: true,
			selectOtherMonths: true,
                    onSelect: function( selectedDate ) {
                      $( '.datepicker-to' ).datepicker( 'option', 'minDate', selectedDate );
                     // $( '.datepicker-from' ).datepicker( 'option', 'maxDate', '+1w' );
                     //$('.datepicker-to').datepicker({  
                     //     minDate: selectedDate,
                    //      maxDate: '+7d'
                        
                    // });
                    }
                  });
                  
                $('.datepicker-rekap-to').click().datepicker({  
                   // defaultDate: '+1d -1d',
                  changeMonth: true,
                  changeYear: true,
                  dateFormat: 'dd-mm-yy',
                  numberOfMonths: 1,
                  showOtherMonths: true,
			selectOtherMonths: true,
                  onSelect: function( selectedDate ) {
                    $( '.datepicker-from' ).datepicker( 'option', 'maxDate', selectedDate );
                    //$( '.datepicker-to' ).datepicker( 'option', 'minDate', '-1w' );
                    //$('.datepicker-to').datepicker({  
                    //      maxDate: selectedDate,
                    //      minDate: '-7d'
                        
                    //  });
                  }
                });
                });
                </script>
";
		$view  .= "<div style='margin:25px;'>";
			
			$view  .= $this->optionGear;
			
			$view  .= "<div class='rekapitulasi-detail-action-container'>";
		
					$view .= "<div class='layan-permohonan-icons-container'><a href='index.php?id=2265'><div class='layan-admin_pemberitahuan_create-float-left-edit-permohonan qtip-upper' text='Back'></div></a></div>";
					$view .= "<div class=\"layan-pemberitahuan-float-left-print-pemberitahuan rekapitulasi-print-detail\"></div>
								<div class=\"rekapitulasi-dashboard-input-container\"><input type=\"text\" placeholder=\"Date From\" class=\"dado-featured-form-input datepicker-rekap-from datepicker-content-handler-from\" value=\"".$displayDateF."\" />
								<span class=\"rekapitulasi-dashboard-text\">To</span>
								<input type=\"text\" placeholder=\"Date From\"  class=\"dado-featured-form-input datepicker-rekap-to datepicker-content-handler-to\" value=\"".$displayDateT."\" /></div>";
					$view .= "<span style=\"margin-left:10px;\"><select class=\"type-of-report\" style=\"width:150px; margin-right:10px;\">";
					$view .= "<option value=\"\">Rekap Pelayanan IP</option>";
					$view .= "<option value=\"WaktuPelayananIP\">Rekap Waktu Pelayanan</option>";
					$view .= "<option value=\"Permohonan\">Permohonan</option>";
					$view .= "<option value=\"Pemberitahuan\">Pemberitahuan</option>";
					$view .= "<option value=\"Perpanjangan\">Perpanjangan</option>";
					$view .= "<option value=\"Penolakan\">Penolakan</option>";
					$view .= "<option value=\"Keberatan\">Keberatan</option>";
					$view .= "</select></span>";
					
					$view .= "<input type=\"submit\"  value=\"Go\" class=\"featured-dado-button-rekap-report\" />";
					$view .= "<div class='layan-permohonan-icons-container-right'>Daftar Rekapitulasi - ".$nameType."</div>";
		
					$view .= "</div><hr /><br />";
					$view .= "<table class=\"table-display table-display-custom1\">";
					if($nameType == 'Permohonan'){
					$view .= "			<thead>";
					$view .= "				<tr class=\"table-row-header table-row-header-custom1\">";
					$view .= "					<td class=\"table-cell\" rowspan=\"2\">No.</td>";
					$view .= "					<td class=\"table-cell\" rowspan=\"2\">Tanggal <br />".$nameType."</td>";
					$view .= "					<td class=\"table-cell\" rowspan=\"2\">Tanggal <br /> Selesai ".$nameType."</td>";
					$view .= "					<td class=\"table-cell\" rowspan=\"2\">No ".$nameType."</td>";
					$view .= "					<td class=\"table-cell\" rowspan=\"2\">Nama Pemohon</td>";
					$view .= "					<td class=\"table-cell\" rowspan=\"2\">Tipe <br />Pemohon</td>";
					$view .= "					<td class=\"table-cell\" colspan=\"2\" >Informasi Publik</td>";
					$view .= "					<td class=\"table-cell\" rowspan=\"2\">Tindak Lanjut</td>";
					$view .= "					<td class=\"table-cell\" rowspan=\"2\">Status</td>";
					$view .= "				</tr>";
					$view .= "				<tr class=\"table-row-header table-row-header-custom1\">";
					$view .= "					<td class=\"table-cell\">Informasi Publik</td>";
					$view .= "					<td class=\"table-cell\">Alasan</td>";
					$view .= "				</tr>";
					$view .= "			</thead>";
					}elseif($nameType == 'Keberatan'){
					$view .= "			<thead>";
					$view .= "				<tr class=\"table-row-header table-row-header-custom1\">";
					$view .= "					<td class=\"table-cell\" rowspan=\"2\">No.</td>";
					$view .= "					<td class=\"table-cell\" rowspan=\"2\">No ".$nameType."</td>";
					$view .= "					<td class=\"table-cell\" rowspan=\"2\">Tanggal <br />(dd/mm/yyyy)</td>";
					
					$view .= "					<td class=\"table-cell\" rowspan=\"2\">Nama Pemohon / Alamat / Pekerjaan</td>";
					$view .= "					<td class=\"table-cell\" rowspan=\"2\">No. Telp <br />Pemohon</td>";
					$view .= "					<td class=\"table-cell\" rowspan=\"2\" >E-mail</td>";					
					$view .= "					<td class=\"table-cell\" rowspan=\"2\">Rincian Informasi Yang Dibutuhkan</td>";
					$view .= "					<td class=\"table-cell\" rowspan=\"2\">Tujuan Penggunaan Informasi</td>";
					$view .= "					<td class=\"table-cell\" rowspan=\"1\" colspan=\"7\">Alasan Pengajuan Keberatan <br /> (pasal 35 ayat (1) UU KIP)</td>";
					$view .= "					<td class=\"table-cell\" rowspan=\"2\">Keputusan Atasan PPID</td>";
					$view .= "					<td class=\"table-cell\" rowspan=\"2\">Hari dan Tanggal <br /> Pemberian tanggapan <br /> atas keberatan</td>";
					$view .= "					<td class=\"table-cell\" rowspan=\"2\">Nama dan Posisi Atasan PPID</td>";
					$view .= "					<td class=\"table-cell\" rowspan=\"2\">Tanggapan Pemohon Informasi</td>";
					$view .= "				</tr>";
					$view .= "				<tr class=\"table-row-header table-row-header-custom1\">";
					$view .= "					<td class=\"table-cell\">a</td>";
					$view .= "					<td class=\"table-cell\">b</td>";
					$view .= "					<td class=\"table-cell\">c</td>";
					$view .= "					<td class=\"table-cell\">d</td>";
					$view .= "					<td class=\"table-cell\">e</td>";
					$view .= "					<td class=\"table-cell\">f</td>";
					$view .= "					<td class=\"table-cell\">g</td>";
					$view .= "				</tr>";
					$view .= "			</thead>";
					}elseif($nameType == 'Pemberitahuan'){
					$view .= "			<thead>";
					$view .= "				<tr class=\"table-row-header table-row-header-custom1\">";
					$view .= "					<td class=\"table-cell\" >No.</td>";
					$view .= "					<td class=\"table-cell\" >Tanggal <br />".$nameType."</td>";
					$view .= "					<td class=\"table-cell\" >No ".$nameType."</td>";
					$view .= "					<td class=\"table-cell\" >Nama Pemohon</td>";
					$view .= "					<td class=\"table-cell\" >Tipe <br />Pemohon</td>";
					$view .= "					<td class=\"table-cell\" >Informasi Publik</td>";
					$view .= "					<td class=\"table-cell\" >Penguasaan Informasi</td>";
					$view .= "					<td class=\"table-cell\" >Bentuk Informasi</td>";
					$view .= "					<td class=\"table-cell\" >Biaya</td>";
					$view .= "					<td class=\"table-cell\" >Metode&nbsp;<br />Penyampaian&nbsp;<br />Informasi</td>";
					$view .= "					<td class=\"table-cell\" >Waktu&nbsp;<br />Penyampaian&nbsp;<br />Informasi</td>";
					$view .= "					<td class=\"table-cell\" >Nomor&nbsp;<br />Dokumen&nbsp;<br />Order</td>";
					$view .= "					<td class=\"table-cell\" >Notes</td>";
					$view .= "				</tr>";
					$view .= "			</thead>";
					}elseif($nameType == 'Perpanjangan'){
					$view .= "			<thead>";
					$view .= "				<tr class=\"table-row-header table-row-header-custom1\">";
					$view .= "					<td class=\"table-cell\" >No.</td>";
					$view .= "					<td class=\"table-cell\" >Tanggal <br />".$nameType."</td>";
					$view .= "					<td class=\"table-cell\" >No ".$nameType."</td>";
					$view .= "					<td class=\"table-cell\" >Nama Pemohon</td>";
					$view .= "					<td class=\"table-cell\" >Tipe <br />Pemohon</td>";
					$view .= "					<td class=\"table-cell\" >Informasi Publik</td>";
					//$view .= "					<td class=\"table-cell\" >Penguasaan Informasi</td>";
					$view .= "					<td class=\"table-cell\" >Tanggal Perpanjangan</td>";
					$view .= "					<td class=\"table-cell\" >Perpanjangan Ke</td>";
					$view .= "					<td class=\"table-cell\" >Notes</td>";
					$view .= "				</tr>";
					$view .= "			</thead>";
					}elseif($nameType == 'Penolakan'){
					$view .= "			<thead>";
					$view .= "				<tr class=\"table-row-header table-row-header-custom1\">";
					$view .= "					<td class=\"table-cell\" >No.</td>";
					$view .= "					<td class=\"table-cell\" >Tanggal <br />".$nameType."</td>";
					$view .= "					<td class=\"table-cell\" >No ".$nameType."</td>";
					$view .= "					<td class=\"table-cell\" >Nama Pemohon</td>";
					$view .= "					<td class=\"table-cell\" >Tipe <br />Pemohon</td>";
					$view .= "					<td class=\"table-cell\" >Informasi Publik</td>";
					$view .= "					<td class=\"table-cell\" >Alasan Pengecualian</td>";
					$view .= "					<td class=\"table-cell\" >Notes</td>";
					$view .= "				</tr>";
					$view .= "			</thead>";
					}elseif($nameType == 'WaktuPelayananIP'){
					$view .= "			<thead>";
					$view .= "				<tr class=\"table-row-header table-row-header-custom1\">";
					$view .= "					<td class=\"table-cell\" rowspan=\"3\">No.</td>";
					$view .= "					<td class=\"table-cell\" rowspan=\"3\">Uraian</td>";
					$view .= "					<td class=\"table-cell\" rowspan=\"3\">IP yang Dipenuhi</td>";
					$view .= "					<td class=\"table-cell\" colspan=\"5\">Waktu Pemenuhan IP</td>";
					$view .= "				</tr>";
					$view .= "				<tr class=\"table-row-header table-row-header-custom1\">";
					$view .= "					<td class=\"table-cell\">1 - 2 Hari (Baik Sekali)</td>";
					$view .= "					<td class=\"table-cell\">3 - 5 Hari (Baik) </td>";
					$view .= "					<td class=\"table-cell\">6 - 10 (Cukup)</td>";
					$view .= "					<td class=\"table-cell\">11 - 17 Hari (Buruk)</td>";
					$view .= "					<td class=\"table-cell\">> 17 Hari (Buruk Sekali)</td>";
					$view .= "				</tr>";
					$view .= "			</thead>";
					}
					if(method_exists($this,$type)){
			$data 	= $this->$type($dateFrom,$dateTo);
			//print_r($data);
			if($nameType == 'Permohonan'){
					if(!empty($data)){
						$i=1;
						$view .= "			<tbody>";
						foreach($data as $key => $value){
							
							$typeDetail 			= "get".$nameType."DataDetail"; 
							$dataDetail 			= $this->$typeDetail($value['NO']);
							$dataDetailCount 		= count($dataDetail) + 1;
							
							$typeDetailPem 			= "get".$nameType."DataDetailPem"; 
							$dataDetailPem 			= $this->$typeDetailPem($value['NO']);
							$dataDetailCountPem 	= count($dataDetailPem) ;
														
							$typeDetailPer 			= "get".$nameType."DataDetailPer"; 
							$dataDetailPer 			= $this->$typeDetailPer($value['NO']);
							$dataDetailCountPer		= count($dataDetailPer) ;
														
							$typeDetailPen 			= "get".$nameType."DataDetailPen"; 
							$dataDetailPen 			= $this->$typeDetailPen($value['NO']);
							$dataDetailCountPen		= count($dataDetailPen) ;
							
							$typeDetailKeb 			= "get".$nameType."DataDetailKeb"; 
							$dataDetailKeb 			= $this->$typeDetailKeb($value['NO']);
							$dataDetailCountKeb		= count($dataDetailKeb) ;							
							
							if(!empty($value[TANGGAL])){
								
							if($value[STATUS] == 0){
								$status = "Dokumen Baru Diciptakan";
							}
							elseif($value[STATUS] == 1){
								$status = "Dokumen Tidak Lengkap";
							}
							elseif($value[STATUS] == 2){
								$status = "Sedang Diproses";
							}
							elseif($value[STATUS] == 3 || $value[STATUS] == 5 ){
								$status = "Telah Selesai Diproses";
							}

								$tgl = $dayIN->returnIndonesianDate(date('N', strtotime($value[TANGGAL])),'day').date(', d/m/Y', strtotime($value[TANGGAL]));
							}else{
								$tgl = "";
							}
							if(!empty($value[STOPDATE])){
								
								$tgl_s = $dayIN->returnIndonesianDate(date('N', strtotime($value[STOPDATE])),'day').date(', d/m/Y', strtotime($value[STOPDATE]));
							}else{
								$tgl_s = "";
							}
							
							$view .= "				<tr class=\"table-row\">";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">$i</td>";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".$tgl."</td>";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".$tgl_s."</td>";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\"><input type=\"hidden\" value=\"".$value['NO']."\">".$value['KODE']."</td>";
							$view .= "					<td class=\"table-cell\" rowspan =\"".$dataDetailCount."\">".ucwords(strtolower($value['NAMA']))."</td>";
							$view .= "					<td class=\"table-cell\" rowspan =\"".$dataDetailCount."\">".ucwords(strtolower($value['TIPE']))."</td>";
							$view .= "					<td ></td>";
							$view .= "					<td ></td>";
							
														
							$view .= "					<td class=\"table-cell\" rowspan =\"".$dataDetailCount."\">";
							
							
							if(!empty($dataDetailPem)){
							
							$view .= "						Pemberitahuan ($dataDetailCountPem)";
							$view .= "<ul class=\"li-Detail-Ul\">";
								foreach($dataDetailPem as $keyPem => $valuePem){
								
								$view .= "							<li  class=\"li-Detail-Ul print-rekap-pemberitahuan\" style=\"display:block;cursor:pointer\"><input type=\"hidden\" class=\"pemberitahuan-id\" value=\" $valuePem[ID]\">$valuePem[PEMDATE] &nbsp; $valuePem[PEMNUM]</li>";
								
								}
							
							$view .= "</ul>";
							
							}
							
							
							
							if(!empty($dataDetailPer)){
							
							$view .= "						Perpanjangan ($dataDetailCountPer)";
							$view .= "<ul class=\"li-Detail-Ul\">";
								foreach($dataDetailPer as $keyPer => $valuePer){
								
								$view .= "							<li class=\"li-Detail-Ul print-rekap-perpanjangan\" style=\"display:block;cursor:pointer\"><input type=\"hidden\" class=\"perpanjangan-id\" value=\" $valuePer[ID]\">$valuePer[PERDATE] &nbsp; $valuePer[PERNUM] &nbsp; </li>";
								
								}
							$view .= "</ul>";
							}
							
							
							
							if(!empty($dataDetailPen)){
							
							$view .= "						Penolakan ($dataDetailCountPen)";
							$view .= "<ul class=\"li-Detail-Ul\">";
								foreach($dataDetailPen as $keyPen => $valuePen){
								
								$view .= "							<li class=\"li-Detail-Ul print-rekap-penolakan\" style=\"display:block;cursor:pointer\"><input type=\"hidden\" class=\"penolakan-id\" value=\" $valuePen[ID]\">$valuePen[PENDATE] &nbsp; $valuePen[PENNUM]</li>";
								
								}
							$view .= "</ul>";
							}
							
							if(!empty($dataDetailKeb)){
							
							$view .= "						Keberatan ($dataDetailCountKeb)";
							$view .= "<ul class=\"li-Detail-Ul\">";
								foreach($dataDetailKeb as $keyKeb => $valueKeb){
								
								$view .= "							<li class=\"li-Detail-Ul print-rekap-keberatan\" style=\"display:block;cursor:pointer\"><input type=\"hidden\" class=\"keberatan-id\" value=\" $valueKeb[ID]\">$valueKeb[KEBDATE] &nbsp; $valueKeb[KEBNUM]</li>";
								
								}
							$view .= "</ul>";
							}
							
							$view .= "					</td>";
							
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".ucwords($status)."</td>";
							$view .= "				</tr>";
							foreach($dataDetail as $keys => $values){
								$view .= "				<tr class=\"table-row\">";
								$view .= "					<td class=\"table-cell align-left\">".$values['IP']."</td>";
								$view .= "					<td class=\"table-cell align-left\">".$values['REASON']."</td>";
								$view .= "			</tr>";
							}
							
							
							
							$i++;
							
						}
								
						$view .= "			</tbody>";
						
					}
				}elseif($nameType == 'Keberatan'){
				
					//print_r($data);
					if(!empty($data)){
						$i=1;
						$view .= "			<tbody>";
						foreach($data as $key => $value){
							
							$typeDetail 			= "get".$nameType."DataDetail"; 
							$dataDetail 			= $this->$typeDetail($value['NO']);
							$dataDetailCount 		= count($dataDetail) + 1;
							
							if(!empty($value[TGL_T])){
								
								$tgl_t = $dayIN->returnIndonesianDate(date('N', strtotime($value[TGL_T])),'day').date(', d/m/Y', strtotime($value[TGL_T]));
							}else{
								$tgl_t = "";
							}
							if(!empty($value[TGL])){
								
								$tgl = $dayIN->returnIndonesianDate(date('N', strtotime($value[TGL])),'day').date(', d/m/Y', strtotime($value[TGL]));
							}else{
								$tgl = "";
							}

							$view .= "				<tr class=\"table-row\">";
							$view .= "					<td rowspan =\"".$dataDetailCount."\" class=\"table-cell align-center\">$i</td>";
							$view .= "					<td rowspan =\"".$dataDetailCount."\" class=\"table-cell  align-left\">$value[KODE]</td>";
							$view .= "					<td rowspan =\"".$dataDetailCount."\" class=\"table-cell align-center\">".$tgl."</td>";
							$view .= "					<td rowspan =\"".$dataDetailCount."\" class=\"table-cell align-left\" style=\"max-width:150px;\">$value[NAMA] / $value[ALAMAT] / $value[PEKERJAAN]</td>";
							$view .= "					<td rowspan =\"".$dataDetailCount."\" class=\"table-cell align-center\" style=\"max-width:150px;\">$value[TELE]</td>";
							$view .= "					<td rowspan =\"".$dataDetailCount."\" class=\"table-cell align-center\" style=\"max-width:150px;\">$value[EMAIL]</td>";
							$view .= "					<td class=\"table-cell-nodata\"></td>";
							$view .= "					<td class=\"table-cell-nodata\"></td>";
							$view .= "					<td class=\"table-cell-nodata\"></td>";
							$view .= "					<td class=\"table-cell-nodata\"></td>";
							$view .= "					<td class=\"table-cell-nodata\"></td>";
							$view .= "					<td class=\"table-cell-nodata\"></td>";
							$view .= "					<td class=\"table-cell-nodata\"></td>";
							$view .= "					<td class=\"table-cell-nodata\"></td>";
							$view .= "					<td class=\"table-cell-nodata\"></td>";
							$view .= "					<td class=\"table-cell-nodata\"></td>";
							$view .= "					<td rowspan =\"".$dataDetailCount."\" class=\"table-cell align-center\">".$tgl_t."</td>";
							$view .= "					<td rowspan =\"".$dataDetailCount."\" class=\"table-cell align-center\">$value[NAMA_PPID] <br />$value[POSISI_PPID]</td>";
							$view .= "					<td class=\"table-cell-nodata\"></td>";
							
														
							
							$view .= "				</tr>";
							if(!empty($dataDetail)){
							$d = 0;
							$dataDetailCount -= 1;
								foreach($dataDetail as $keys => $values){
									$view .= "				<tr class=\"table-row\">";
									
									$view .= "					<td class=\"table-cell align-left\">".$values['IP']."</td>";
									$view .= "					<td class=\"table-cell align-left\">".$values['REASON']."</td>";
									if($d==0){
										if($values[A]==1){
											$A = "<img src=\"library/images/check.png\">";
										}else{
											$A = "";
										}
										if($values[B]==1){
											$B = "<img src=\"library/images/check.png\">";
										}else{
											$B = "";
										}
			
										if($values[C]==1){
											$C = "<img src=\"library/images/check.png\">";
										}else{
											$C = "";
										}
			
										if($values[D]==1){
											$D = "<img src=\"library/images/check.png\">";
										}else{
											$D = "";
										}
			
										if($values[E]==1){
											$E = "<img src=\"library/images/check.png\">";
										}else{
											$E = "";
										}
			
										if($values[F]==1){
											$F = "<img src=\"library/images/check.png\">";
										}else{
											$F = "";
										}
			
										if($values[G]==1){
											$G = "<img src=\"library/images/check.png\">";
										}else{
											$G = "";
										}

										$view .= "					<td rowspan =\"".$dataDetailCount."\" class=\"table-cell align-center\" style=\"width:16px; vertical-align:middle\">$A</td>";
										$view .= "					<td rowspan =\"".$dataDetailCount."\" class=\"table-cell align-center\" style=\"width:16px; vertical-align:middle\">$B</td>";
										$view .= "					<td rowspan =\"".$dataDetailCount."\" class=\"table-cell align-center\" style=\"width:16px; vertical-align:middle\">$C</td>";
										$view .= "					<td rowspan =\"".$dataDetailCount."\" class=\"table-cell align-center\" style=\"width:16px; vertical-align:middle\">$D</td>";
										$view .= "					<td rowspan =\"".$dataDetailCount."\" class=\"table-cell align-center\" style=\"width:16px; vertical-align:middle\">$E</td>";
										$view .= "					<td rowspan =\"".$dataDetailCount."\" class=\"table-cell align-center\" style=\"width:16px; vertical-align:middle\">$F</td>";
										$view .= "					<td rowspan =\"".$dataDetailCount."\" class=\"table-cell align-center\" style=\"width:16px; vertical-align:middle\">$G</td>";									
										$view .= "					<td rowspan =\"". $dataDetailCount ."\" class=\"table-cell align-center\">$values[T_PPID]</td>";
										$view .= "					<td rowspan =\"". $dataDetailCount ."\" class=\"table-cell align-center\">$values[T_U]</td>";
									}
									$view .= "			</tr>";
									$d++;
									
								}
								
							}
							
							$i++;
							
						}
								
						$view .= "			</tbody>";
						
					}
				}elseif($nameType == 'Pemberitahuan'){
					if(!empty($data)){
						$i=1;
						$view .= "			<tbody>";
						foreach($data as $key => $value){
							
							$typeDetail 			= "get".$nameType."DataDetail"; 
							$dataDetail 			= $this->$typeDetail($value['NO']);
							$dataDetailCount 		= count($dataDetail) + 1;
							
							if(!empty($value[TANGGAL])){
								
								$tgl = $dayIN->returnIndonesianDate(date('N', strtotime($value[TANGGAL])),'day').date(', d/m/Y', strtotime($value[TANGGAL]));
							}else{
								$tgl = "";
							}
							
							$view .= "				<tr class=\"table-row\">";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">$i</td>";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".$tgl."</td>";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\"><input type=\"hidden\" value=\"".$value['NO']."\">".$value['KODE']."</td>";
							$view .= "					<td class=\"table-cell\" rowspan =\"".$dataDetailCount."\">".ucwords(strtolower($value['NAMA']))."</td>";
							$view .= "					<td class=\"table-cell\" rowspan =\"".$dataDetailCount."\">".ucwords(strtolower($value['TIPE']))."</td>";
							$view .= "					<td ></td>";
							$view .= "					<td ></td>";
							$view .= "					<td ></td>";
							$view .= "					<td ></td>";
							$view .= "					<td ></td>";
							$view .= "					<td ></td>";							
							$view .= "					<td ></td>";
							$view .= "					<td ></td>";
							
							
							$view .= "					</td>";
							
							//print_r($dataDetail);
							$view .= "				</tr>";
							
							
							if(!empty($dataDetail)){
								foreach($dataDetail as $keys => $values){
									
									if($values['SOFT']==1){
										$soft = 'Softcopy';
									}else{
										$soft = '';
									}
									if($values['HARD']==1){
										$hard = 'Hardcopy';
									}else{
										$hard = '';
									}
									    
									$biaya = ($values[COST] * $values[LEMBAR]) + $values[KIRIM] + $values[LAIN];
									$biaya = number_format($biaya, 2, ',', '.');
									$view .= "				<tr class=\"table-row\">";
									$view .= "					<td class=\"table-cell align-left\">".$values['IP']."</td>";
									$view .= "					<td class=\"table-cell align-left\">".$values['REASON']."</td>";
									$view .= "					<td class=\"table-cell align-left\">".$soft."<br />".$hard."</td>";
									$view .= "					<td class=\"table-cell align-left\" style=\"width:100px;\">Rp ".$biaya."</td>";
									$view .= "					<td class=\"table-cell align-left\">".$values['METODE']."</td>";
									$view .= "					<td class=\"table-cell align-center\">".$values['WAKTU']."</td>";
									$view .= "					<td class=\"table-cell align-left\">".$values['LIB']."</td>";
									$view .= "					<td class=\"table-cell align-left\">".$values['NOTES']."</td>";
									$view .= "			</tr>";
								}
							}
							
							
							$i++;
							
						}
								
						$view .= "			</tbody>";
						
					}
				}elseif($nameType == 'Perpanjangan'){
					if(!empty($data)){
						$i=1;
						$ke = 1;
						$lay_id = "";
						$view .= "			<tbody>";
						foreach($data as $key => $value){
							
							$typeDetail 			= "get".base64_decode($_GET['type'])."DataDetail"; 
							$dataDetail 			= $this->$typeDetail($value['NO']);
							$dataDetailCount 		= count($dataDetail) + 1;
							
							
							if($value[LAY_ID]==$lay_id){
								$ke ++;
							}else{
								$ke = 1;
							}
							$lay_id=$value[LAY_ID];
							
							if(!empty($value[TANGGAL])){
								
								$tgl = $dayIN->returnIndonesianDate(date('N', strtotime($value[TANGGAL])),'day').date(', d/m/Y', strtotime($value[TANGGAL]));
							}else{
								$tgl = "";
							}
							
							if(!empty($value[TGL_TO])){
								
								$tgl_to = $dayIN->returnIndonesianDate(date('N', strtotime($value[TGL_TO])),'day').date(', d/m/Y', strtotime($value[TGL_TO]));
							}else{
								$tgl_to = "";
							}
							
							$view .= "				<tr class=\"table-row\">";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">$i</td>";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".$tgl."</td>";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\"><input type=\"hidden\" value=\"".$value['NO']."\">".$value['KODE']."</td>";
							$view .= "					<td class=\"table-cell\" rowspan =\"".$dataDetailCount."\">".ucwords(strtolower($value['NAMA']))."</td>";
							$view .= "					<td class=\"table-cell\" rowspan =\"".$dataDetailCount."\">".ucwords(strtolower($value['TIPE']))."</td>";
							$view .= "					<td ></td>";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".$tgl_to."</td>";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">$ke</td>";
							$view .= "					<td ></td>";							
							
							
							$view .= "					</td>";
							
							
							$view .= "				</tr>";
							foreach($dataDetail as $keys => $values){
								$view .= "				<tr class=\"table-row\">";
								$view .= "					<td class=\"table-cell align-left\">".$values['IP']."</td>";
								//$view .= "					<td class=\"table-cell align-left\">".$values['REASON']."</td>";
								$view .= "					<td class=\"table-cell align-left\">".$values['NOTES']."</td>";
								$view .= "			</tr>";
							}
							
							
							
							$i++;
							
						}
								
						$view .= "			</tbody>";
						
					}
				}elseif($nameType == 'Penolakan'){
					if(!empty($data)){
						$i=1;
						$view .= "			<tbody>";
						foreach($data as $key => $value){
							
							$typeDetail 			= "get".$nameType."DataDetail"; 
							$dataDetail 			= $this->$typeDetail($value['NO']);
							$dataDetailCount 		= count($dataDetail) + 1;
							
							if(!empty($value[TANGGAL])){
								
								$tgl = $dayIN->returnIndonesianDate(date('N', strtotime($value[TANGGAL])),'day').date(', d/m/Y', strtotime($value[TANGGAL]));
							}else{
								$tgl = "";
							}
														
							
							$view .= "				<tr class=\"table-row\">";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">$i</td>";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".$tgl."</td>";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\"><input type=\"hidden\" value=\"".$value['NO']."\">".$value['KODE']."</td>";
							$view .= "					<td class=\"table-cell\" rowspan =\"".$dataDetailCount."\">".ucwords(strtolower($value['NAMA']))."</td>";
							$view .= "					<td class=\"table-cell\" rowspan =\"".$dataDetailCount."\">".ucwords(strtolower($value['TIPE']))."</td>";
							$view .= "					<td ></td>";
							$view .= "					<td ></td>";
							$view .= "					<td ></td>";
							
							
							
							
							$view .= "				</tr>";
							if(!empty($dataDetail)){
								$ii = 0;
								foreach($dataDetail as $keys => $values){
									
									if($value[PSL]==1){
										$psl = "<li class=\"li-Detail-Ul\">Pasal 17 UU KIP</li>";
									}else{
										$psl = "";
									}
									if($values[NO]==1){
										$psl .= $plsQuery;
									}else{
										
									}
									
									$alasan = "<ul>";
									
									$alasan .= "$psl";
									if(!empty($values[UU])){
									$alasan .= "<li class=\"li-Detail-Ul\">$values[UU]</li>";
									}
									if(!empty($values[UJI])){
									$alasan .= "<li class=\"li-Detail-Ul\"$values[UJI]</li>";
									}
									$alasan .= "</ul>";
									
									$view .= "				<tr class=\"table-row\">";
									$view .= "					<td class=\"table-cell align-left\">".$values['IP']."</td>";
									$view .= "					<td class=\"table-cell align-left\">".$alasan."</td>";
									$view .= "					<td class=\"table-cell align-left\">".$values['NOTES']."</td>";
									$view .= "			</tr>";
								}
								$ii++;
							}
							
							
							
							$i++;
							
						}
								
						$view .= "			</tbody>";
						
					}
				}elseif($nameType == 'WaktuPelayananIP'){
					if(!empty($data)){
						$i=1;
						$ke = 1;
						$lay_id = "";
						$view .= "			<tbody>";
						//print_r($data);
						foreach($data as $key => $value){
																				
							if($value[LAY_ID]==$lay_id){
								$ke ++;
							}else{
								$ke = 1;
							}
							$lay_id=$value[LAY_ID];
							$builtArrayIP	 		[]	= $value['IP']; 
							$builtArrayDipenuhi 	[]	= $value['DIPENUHI']; 
							$builtArrayBS		 	[]	= $value['BS']; 
							$builtArrayB		 	[]	= $value['B']; 
							$builtArrayC		 	[]	= $value['C']; 
							$builtArrayBr		 	[]	= $value['Br']; 
							$builtArrayBrS		 	[]	= $value['BrS']; 
							
							$view .= "				<tr class=\"table-row\">";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">$i</td>";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".$value['URAIAN']."</td>";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".$value['DIPENUHI']."</td>";					
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".$value['BS']."</td>";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".$value['B']."</td>";		
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".$value['C']."</td>";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".$value['Br']."</td>";		
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".$value['BrS']."</td>";														
							$view .= "				</tr>";
							
							$i++;
							
						}
						//print_r($builtArrayDipenuhi);
						$view .= "				<tr class=\"table-row\" style=\"font-weight:bold\">";
							$view .= "					<td class=\"table-cell align-center\" colspan =\"2\">TOTAL</td>";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".array_sum($builtArrayDipenuhi)."</td>";					
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".array_sum($builtArrayBS)."</td>";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".array_sum($builtArrayB)."</td>";		
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".array_sum($builtArrayC)."</td>";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".array_sum($builtArrayBr)."</td>";		
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".array_sum($builtArrayBrS)."</td>";
							$view .= "				</tr>";
							$view .= "				<tr class=\"table-row\" style=\"font-weight:bold\">";
							$view .= "					<td class=\"table-cell align-center\" colspan =\"2\">Prosentase</td>";			
							/*$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".array_sum($builtArrayTotal)." (100%)</td>";	*/
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".@number_format(array_sum($builtArrayDipenuhi)/array_sum($builtArrayIP)*(100),2) ."%  (dari ".array_sum($builtArrayIP)." IP)</td>";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".@number_format(array_sum($builtArrayBS)/array_sum($builtArrayDipenuhi)*(100),2) ."%</td>";		
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".@number_format(array_sum($builtArrayB)/array_sum($builtArrayDipenuhi)*(100),2) ."%</td>";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".@number_format(array_sum($builtArrayC)/array_sum($builtArrayDipenuhi)*(100),2) ."%</td>";		
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".@number_format(array_sum($builtArrayBr)/array_sum($builtArrayDipenuhi)*(100),2) ."%</td>";		
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".@number_format(array_sum($builtArrayBrS)/array_sum($builtArrayDipenuhi)*(100),2) ."%</td>";							$view .= "				
							</tr>";
								
						$view .= "			</tbody>";
						
					}

				}
				
		}
		else{
			
		}
		$view .= "			</div>";
		
		$view .= "</div>";
	}else{
		$type 	= "getPelayananIPData"; 
		$view .= "<script type='text/javascript'>
				jQuery.noConflict()(function($){
				$('.datepicker-rekap-from').click().datepicker({  
                    //defaultDate: '-7d',
                    changeMonth: true,
                    changeYear: true,
                    numberOfMonths: 1,
                    dateFormat: 'dd-mm-yy',
                    showOtherMonths: true,
			selectOtherMonths: true,
                    onSelect: function( selectedDate ) {
                      $( '.datepicker-to' ).datepicker( 'option', 'minDate', selectedDate );
                     // $( '.datepicker-from' ).datepicker( 'option', 'maxDate', '+1w' );
                     //$('.datepicker-to').datepicker({  
                     //     minDate: selectedDate,
                    //      maxDate: '+7d'
                        
                    // });
                    }
                  });
                  
                $('.datepicker-rekap-to').click().datepicker({  
                   // defaultDate: '+1d -1d',
                  changeMonth: true,
                  changeYear: true,
                  dateFormat: 'dd-mm-yy',
                  numberOfMonths: 1,
                  showOtherMonths: true,
			selectOtherMonths: true,
                  onSelect: function( selectedDate ) {
                    $( '.datepicker-from' ).datepicker( 'option', 'maxDate', selectedDate );
                    //$( '.datepicker-to' ).datepicker( 'option', 'minDate', '-1w' );
                    //$('.datepicker-to').datepicker({  
                    //      maxDate: selectedDate,
                    //      minDate: '-7d'
                        
                    //  });
                  }
                });
                });
                </script>
";
		if(isset($_GET['from']) && isset($_GET['to'])){
			$dateFrom = date('Y-m-d',strtotime(base64_decode($_GET['from']))).' 00:00:00';
			$dateTo   = date('Y-m-d',strtotime(base64_decode($_GET['to']))).' 23:59:59';
			$displayDateF = date('d-m-Y',strtotime($dateFrom));
			$displayDateT = date('d-m-Y',strtotime($dateTo)); 
		}else{
			$dateFrom = date('Y').'-01-01 00:00:00';
			$dateTo   = date('Y').'-12-31 23:59:59';
			$displayDateF = date('d-m-Y',strtotime($dateFrom));
			$displayDateT = date('d-m-Y',strtotime($dateTo)); 
		}
		$view  .= "<div style='margin:25px;'>";
			
			$view  .= $this->optionGear;
			
			$view  .= "<div class='rekapitulasi-detail-action-container'>";
		
					$view .= "<div class='layan-permohonan-icons-container'><a href='index.php?id=2265'><div class='layan-admin_pemberitahuan_create-float-left-edit-permohonan qtip-upper' text='Back'></div></a>";
					$view .= "<div class=\"layan-pemberitahuan-float-left-print-pemberitahuan rekapitulasi-print-detail\"></div>
								<div class=\"rekapitulasi-dashboard-input-container\"><input type=\"text\" placeholder=\"Date From\" class=\"dado-featured-form-input datepicker-rekap-from datepicker-content-handler-from\" value=\"".$displayDateF."\" />
								<span class=\"rekapitulasi-dashboard-text\">To</span>
								<input type=\"text\" placeholder=\"Date From\"  class=\"dado-featured-form-input datepicker-rekap-to datepicker-content-handler-to\" value=\"".$displayDateT."\" /></div>";
					$view .= "<span style=\"margin-left:10px;\"><select class=\"type-of-report\" >";
					$view .= "<option value=\"\">Rekap Pelayanan IP</option>";
					$view .= "<option value=\"WaktuPelayananIP\">Rekap Waktu Pelayanan</option>";
					$view .= "<option value=\"Permohonan\">Permohonan</option>";
					$view .= "<option value=\"Pemberitahuan\">Pemberitahuan</option>";
					$view .= "<option value=\"Perpanjangan\">Perpanjangan</option>";
					$view .= "<option value=\"Penolakan\">Penolakan</option>";
					$view .= "<option value=\"Keberatan\">Keberatan</option>";
					$view .= "</select></span>";
					
					$view .= "<input type=\"submit\"  value=\"Go\" class=\"featured-dado-button-rekap-report\" />";
					$view .= "<div class='layan-permohonan-icons-container-right'>Daftar Rekapitulasi - Rekapitulasi Pelayanan Informasi Publik</div>";
		
					$view .= "</div></div><br />";
					$view .= "<table class=\"table-display table-display-custom1\">";
					
					$view .= "			<thead>";
					$view .= "				<tr class=\"table-row-header table-row-header-custom1\">";
					$view .= "					<td class=\"table-cell\" rowspan=\"3\">No.</td>";
					$view .= "					<td class=\"table-cell\" rowspan=\"3\">Uraian</td>";
					$view .= "					<td class=\"table-cell\" rowspan=\"3\">Jumlah Pemohon Informasi</td>";
					$view .= "					<td class=\"table-cell\" colspan=\"8\">Proses Layanan IP (Informasi Publik)</td>";
					$view .= "				</tr>";
					$view .= "				<tr class=\"table-row-header table-row-header-custom1\">";
					$view .= "					<td class=\"table-cell\" rowspan=\"2\">Dipenuhi</td>";
					$view .= "					<td class=\"table-cell\" rowspan=\"2\">Dialihkan</td>";
					$view .= "					<td class=\"table-cell\" rowspan=\"2\">Ditolak</td>";
					$view .= "					<td class=\"table-cell\" colspan=\"5\">Alasan Penolakan</td>";
					$view .= "				</tr>";
					$view .= "				<tr class=\"table-row-header table-row-header-custom1\">";
					$view .= "					<td class=\"table-cell\">Pasal 17</td>";
					$view .= "					<td class=\"table-cell\">UU lain</td>";
					$view .= "					<td class=\"table-cell\">Uji Konsekuensi</td>";
					$view .= "					<td class=\"table-cell\">Bukan IP</td>";
					$view .= "					<td class=\"table-cell\">Belum Dikuasai</td>";
					$view .= "				</tr>";
					$view .= "			</thead>";
					if(method_exists($this,$type)){
						$data 	= $this->$type($dateFrom,$dateTo);
						//print_r($data);
					if(!empty($data)){
						$i=1;
						$ke = 1;
						$lay_id = "";
						$view .= "			<tbody>";
						foreach($data as $key => $value){
							
							if($value[LAY_ID]==$lay_id){
								$ke ++;
							}else{
								$ke = 1;
							}
							$lay_id=$value[LAY_ID];
							$builtArrayTotal	 		[]	= $value['TOTAL']; 
							$builtArrayIP	 			[]	= $value['IP']; 
							$builtArrayDipenuhi 		[]	= $value['DIPENUHI']; 
							$builtArrayDiAlihkan	 	[]	= $value['DIALIHKAN']; 
							$builtArrayDiTolak		 	[]	= $value['DITOLAK']; 
							$builtArrayPasal		 	[]	= $value['PASAL']; 
							$builtArrayUU		 		[]	= $value['UU']; 
							$builtArrayUji		 		[]	= $value['UJI']; 
							$builtArrayBukan		 	[]	= $value['BUKAN']; 
							$builtArrayKuasai		 	[]	= $value['KUASAI'];
							
							$view .= "				<tr class=\"table-row\">";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">$i</td>";
							$view .= "					<td class=\"table-cell\" rowspan =\"".$dataDetailCount."\">".$value['URAIAN']."</td>";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".$value['TOTAL']."</td>";					
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".$value['DIPENUHI']."</td>";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".$value['DIALIHKAN']."</td>";		
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".$value['DITOLAK']."</td>";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".$value['PASAL']."</td>";		
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".$value['UU']."</td>";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".$value['UJI']."</td>";		
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".$value['BUKAN']."</td>";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".$value['KUASAI']."</td>";		
							$view .= "				</tr>";
							
							
							$i++;
							
						}
						
							$view .= "				<tr class=\"table-row\" style=\"font-weight:bold\">";
							$view .= "					<td class=\"table-cell align-center\" colspan =\"2\">TOTAL</td>";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".array_sum($builtArrayTotal)."</td>";					
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".array_sum($builtArrayDipenuhi)."</td>";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".array_sum($builtArrayDiAlihkan)."</td>";		
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".array_sum($builtArrayDiTolak)."</td>";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".array_sum($builtArrayPasal)."</td>";		
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".array_sum($builtArrayUU)."</td>";		
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".array_sum($builtArrayUji)."</td>";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".array_sum($builtArrayBukan)."</td>";		
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".array_sum($builtArrayKuasai)."</td>";
							$view .= "				</tr>";
							$view .= "				<tr class=\"table-row\" style=\"font-weight:bold\">";
							$view .= "					<td class=\"table-cell align-center\" colspan =\"2\">Prosentase</td>";			
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".array_sum($builtArrayTotal)." Pemohon (".array_sum($builtArrayIP)." Informasi Publik) </td>";	
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".@number_format(array_sum($builtArrayDipenuhi)/array_sum($builtArrayIP)*(100),2) ."%</td>";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".@number_format(array_sum($builtArrayDiAlihkan)/array_sum($builtArrayIP)*(100),2) ."%</td>";		
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".@number_format(array_sum($builtArrayDiTolak)/array_sum($builtArrayIP)*(100),2) ."%</td>";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".@number_format(array_sum($builtArrayPasal)/array_sum($builtArrayIP)*(100),2) ."%</td>";		
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".@number_format(array_sum($builtArrayUU)/array_sum($builtArrayIP)*(100),2) ."%</td>";		
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".@number_format(array_sum($builtArrayUji)/array_sum($builtArrayIP)*(100),2) ."%</td>";
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".@number_format(array_sum($builtArrayBukan)/array_sum($builtArrayIP)*(100),2) ."%</td>";		
							$view .= "					<td class=\"table-cell align-center\" rowspan =\"".$dataDetailCount."\">".@number_format(array_sum($builtArrayKuasai)/array_sum($builtArrayIP)*(100),2) ."%</td>";
							$view .= "				</tr>";
								
						$view .= "			</tbody></div>";
						
					}
					}
					
	}
	echo $view;
		
	}
}


?>