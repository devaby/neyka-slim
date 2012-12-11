<?php

namespace library\capsule\layan\mvc;

use \DateTime;
use \Imagick;
use \framework\time;
use \framework\date;
use \framework\server;
use \library\capsule\coresystem\mvc\view as core;

class view extends model {

protected $doc;
protected $params;
protected $optionGear;
protected $status = array(0 => '', 1 => "(Pemberitahuan)", 2 => "(Penolakan)", 3 => "(Perpanjangan)", 4 => "(Keberatan)");
	
	public function __construct($params,$doc) {
	
	$status = $this->timeToWorkValidation();
	
		if (!$status) {
						
			header("location: http://192.168.0.114/postgres/index.php?id=2204");
			
		}
							
		if (!empty($doc)) {$this->data = $doc;}
		
		parent::__construct(); 		
		
		if (base64_decode($_GET['log']) == 'destroy') {
			
			$destroy = $this->deletePermohonan($_GET['ref']);
			
			if ($destroy[0]) {
				
				if ($destroy[1] == 101) {
				
				header("location: http://192.168.0.114/postgres/index.php?id=1921");
				
				}
				else {
					
				header("location: http://192.168.0.114/postgres/index.php?id=1942");	
					
				}
					
			}
			else {
				
				if (isset($_SESSION['LAYAN-ERROR'])) {
				
				$_SESSION['LAYAN-ERROR'] = array();
				
				array_push($_SESSION['LAYAN-ERROR'], "Delete permohonan gagal");
				
				}
					
			}
			
		}
		
		if (isset($_SESSION['admin']) || !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		$this -> optionGear = "<span class='forex-optionGear'><img class='optionGear' src='library/capsule/admin/image/settingCap.png'></span>";
		}

		$this->getIDTransaksi();
		
		if ($params == "{view}") {$this->params = 'normal';} else {$this->params = $params;} $params = $this->params; $this->$params();
		
	}	
	
	public function normal(){
						
			if (!empty($_SESSION['LAYAN-ERROR'])) {

				$errorAnnouncement  = "<div class='layan-error-annoucement-permohonan'>";

				foreach ($_SESSION['LAYAN-ERROR'] as $key => $value) {
					
					$errorAnnouncement .= "<li>- $value</li>"; 

				}

				$errorAnnouncement .= "</div><br>";

				unset($_SESSION['LAYAN-ERROR']);

			}
  
  
			$view  = "<div class='layan-normal-form-container'>";
			
			$view .= $this->optionGear;
			
			$view .= "<div class='layan-normal-header-div'>";

				$view .= "Data Pemohon (".$_SESSION['layan-transaksiID'].")<hr class='layan-normal-form-hr'>";

			$view .= "</div>";

			$view .= $errorAnnouncement;

			$view .= "<form autocomplete='off'>";
			
				$view .= "<table class='layan-normal-table'>";
															
					$view .= "<tr class='layan-normal-table-tr-hover'>";
						
						//Nama Lengkap
						$view .= "<td class='layan-normal-form-td1st'>Nama Lengkap</td>";
						
						$view .= "<td>:</td>";
						
						$view .= "<td><input class='layan-normal-form-input' name='nama' type='text' value='".$_SESSION['LAYAN-DATA']['nama']."'></td>";
					
					$view .= "</tr>";
					
					$view .= "<tr class='layan-normal-table-tr-hover'>";
						
						//Pekerjaan
						$view .= "<td class='layan-normal-form-td1st'>Pekerjaan</td>";
						
						$view .= "<td>:</td>";
						
						$view .= "<td><input class='layan-normal-form-input' name='pekerjaan' type='text' value='".$_SESSION['LAYAN-DATA']['pekerjaan']."'></td>";
					
					$view .= "</tr>";
					
					$view .= "<tr class='layan-normal-table-tr-hover'>";
						
						//Tipe Pemohon
						$view .= "<td class='layan-normal-form-td1st'>Tipe Pemohon</td>";
						
						$view .= "<td>:</td>";
						
						if ($_SESSION['LAYAN-DATA']['tipe'] == 'perorangan') {

						$view .= "<td><select class='layan-normal-form-select layan-normal-form-instansi' name='tipe_pemohon'><option selected='selected' value='perorangan'>Perorangan</option><option value='badan hukum'>Badan Hukum</option></select></td>";
						
						}
						else if ($_SESSION['LAYAN-DATA']['tipe'] == 'badan hukum') {

						$view .= "<td><select class='layan-normal-form-select layan-normal-form-instansi' name='tipe_pemohon'><option value='perorangan'>Perorangan</option><option selected='selected' value='badan hukum'>Badan Hukum</option></select></td>";

						}
						else {

						$view .= "<td><select class='layan-normal-form-select layan-normal-form-instansi' name='tipe_pemohon'><option selected='selected' value='perorangan'>Perorangan</option><option value='badan hukum'>Badan Hukum</option></select></td>";

						}

					$view .= "</tr>";
					
					if ($_SESSION['LAYAN-DATA']['tipe'] == 'perorangan') {

					$view .= "<tr class='layan-normal-table-tr-hover layan-normal-form-hide'>";

					}
					else if ($_SESSION['LAYAN-DATA']['tipe'] == 'badan hukum') {

					$view .= "<tr class='layan-normal-table-tr-hover'>";

					}
					else {

					$view .= "<tr class='layan-normal-table-tr-hover layan-normal-form-hide'>";

					}
						
						//Nama Badan Hukum
						$view .= "<td class='layan-normal-form-td1st'>Nama Badan Hukum</td>";
						
						$view .= "<td>:</td>";
						
						$view .= "<td><input class='layan-normal-form-input' name='alamat' type='text' value='".$_SESSION['LAYAN-DATA']['badan']."'></td>";
					
					$view .= "</tr>";
										
					$view .= "<tr class='layan-normal-table-tr-hover'>";
						
						//Data KTP
						$view .= "<td class='layan-normal-form-td1st'>Nomor KTP</td>";
						
						$view .= "<td>:</td>";
						
						$view .= "<td><input class='layan-normal-form-input' name='ktp' type='text' value='".$_SESSION['LAYAN-DATA']['ktp']."'></td>";
					
					$view .= "</tr>";
					
					$view .= "<tr class='layan-normal-table-tr-hover'>";
						
						//Data NPWP
						$view .= "<td class='layan-normal-form-td1st'>NPWP</td>";
						
						$view .= "<td>:</td>";
						
						$view .= "<td><input class='layan-normal-form-input' name='npwp' type='text' value='".$_SESSION['LAYAN-DATA']['npwp']."'></td>";
					
					$view .= "</tr>";
					
					$view .= "<tr class='layan-normal-table-tr-hover'>";
						
						//Alamat Lengkap
						$view .= "<td class='layan-normal-form-td1st'>Alamat</td>";
						
						$view .= "<td>:</td>";
						
						$view .= "<td><input class='layan-normal-form-input' name='alamat' type='text' value='".$_SESSION['LAYAN-DATA']['alamat']."'></td>";
					
					$view .= "</tr>";
					
					$view .= "<tr class='layan-normal-table-tr-hover'>";
						
						//Nomor Telepon
						$view .= "<td class='layan-normal-form-td1st'>No Telepon/HP</td>";
						
						$view .= "<td>:</td>";
						
						$view .= "<td><input class='layan-normal-form-input' name='telepon' type='text' value='".$_SESSION['LAYAN-DATA']['telepon']."'></td>";
					
					$view .= "</tr>";
					
					$view .= "<tr class='layan-normal-table-tr-hover'>";
						
						//Email
						$view .= "<td class='layan-normal-form-td1st'>Email</td>";
						
						$view .= "<td>:</td>";
						
						$view .= "<td><input class='layan-normal-form-input' name='email' type='text' value='".$_SESSION['LAYAN-DATA']['email']."'></td>";
					
					$view .= "</tr>";
					
					$view .= "<tr class='layan-normal-table-tr-hover layan-normal-table-vertical-align'>";
						
						//Cara Memperoleh Informasi
						$view .= "<td class='layan-normal-form-td1st'>Cara Memperoleh Informasi</td>";
						
						$view .= "<td>:</td>";
						
						if ($_SESSION['LAYAN-DATA']['informasi'] == 'melihat/membaca/mendengarkan/mencatat') {

						$view .= "<td class='layan-normal-form-font12'>
									<input value='melihat/membaca/mendengarkan/mencatat' checked class='layan-normal-form-input' name='memperoleh' type='radio'> &nbsp;Melihat/Membaca/Mendengarkan/Mencatat<br/>
									<input value='mendapatkan informasi salinan hardcopy' class='layan-normal-form-input' name='memperoleh' type='radio'> &nbsp;Mendapatkan informasi salinan hardcopy<br/>
									<input value='mendapatkan informasi salinan softcopy' class='layan-normal-form-input' name='memperoleh' type='radio'> &nbsp;Mendapatkan informasi salinan softcopy
								  </td>";

						}
						else if ($_SESSION['LAYAN-DATA']['informasi'] == 'mendapatkan informasi salinan hardcopy') {

						$view .= "<td class='layan-normal-form-font12'>
									<input value='melihat/membaca/mendengarkan/mencatat' class='layan-normal-form-input' name='memperoleh' type='radio'> &nbsp;Melihat/Membaca/Mendengarkan/Mencatat<br/>
									<input value='mendapatkan informasi salinan hardcopy' checked class='layan-normal-form-input' name='memperoleh' type='radio'> &nbsp;Mendapatkan informasi salinan hardcopy<br/>
									<input value='mendapatkan informasi salinan softcopy' class='layan-normal-form-input' name='memperoleh' type='radio'> &nbsp;Mendapatkan informasi salinan softcopy
								  </td>";

						}
						else if ($_SESSION['LAYAN-DATA']['informasi'] == 'mendapatkan informasi salinan softcopy') {

						$view .= "<td class='layan-normal-form-font12'>
									<input value='melihat/membaca/mendengarkan/mencatat' class='layan-normal-form-input' name='memperoleh' type='radio'> &nbsp;Melihat/Membaca/Mendengarkan/Mencatat<br/>
									<input value='mendapatkan informasi salinan hardcopy' class='layan-normal-form-input' name='memperoleh' type='radio'> &nbsp;Mendapatkan informasi salinan hardcopy<br/>
									<input value='mendapatkan informasi salinan softcopy' checked class='layan-normal-form-input' name='memperoleh' type='radio'> &nbsp;Mendapatkan informasi salinan softcopy
								  </td>";

						}
						else {

						$view .= "<td class='layan-normal-form-font12'>
									<input value='melihat/membaca/mendengarkan/mencatat' class='layan-normal-form-input' name='memperoleh' type='radio'> &nbsp;Melihat/Membaca/Mendengarkan/Mencatat<br/>
									<input value='mendapatkan informasi salinan hardcopy' class='layan-normal-form-input' name='memperoleh' type='radio'> &nbsp;Mendapatkan informasi salinan hardcopy<br/>
									<input value='mendapatkan informasi salinan softcopy' class='layan-normal-form-input' name='memperoleh' type='radio'> &nbsp;Mendapatkan informasi salinan softcopy
								  </td>";

						}
					
					$view .= "</tr>";
					
					$view .= "<tr class='layan-normal-table-tr-hover layan-normal-table-vertical-align'>";
						
						//Cara Mendapatkan Salinan Informasi
						$view .= "<td class='layan-normal-form-td1st'>Cara Mendapatkan Salinan Informasi</td>";
						
						$view .= "<td>:</td>";                    
						
						if ($_SESSION['LAYAN-DATA']['salinan'] == 'mengambil langsung') {

						$view .= "<td class='layan-normal-form-font12'>
									<input value='mengambil langsung' checked class='layan-normal-form-input' name='salinan' type='radio'> &nbsp;Mengambil langsung<br/>
									<input value='dikirim melalui email' class='layan-normal-form-input' name='salinan' type='radio'> &nbsp;Dikirim melalui email<br/>
									<input value='lainnya' class='layan-normal-form-input' name='salinan' type='radio'> &nbsp;Lainnya
								  </td>";

						}
						else if ($_SESSION['LAYAN-DATA']['salinan'] == 'dikirim melalui email') {

						$view .= "<td class='layan-normal-form-font12'>
									<input value='mengambil langsung' class='layan-normal-form-input' name='salinan' type='radio'> &nbsp;Mengambil langsung<br/>
									<input value='dikirim melalui email' checked class='layan-normal-form-input' name='salinan' type='radio'> &nbsp;Dikirim melalui email<br/>
									<input value='lainnya' class='layan-normal-form-input' name='salinan' type='radio'> &nbsp;Lainnya
								  </td>";

						}
						else if ($_SESSION['LAYAN-DATA']['salinan'] == 'lainnya') {

						$view .= "<td class='layan-normal-form-font12'>
									<input value='mengambil langsung' class='layan-normal-form-input' name='salinan' type='radio'> &nbsp;Mengambil langsung<br/>
									<input value='dikirim melalui email' class='layan-normal-form-input' name='salinan' type='radio'> &nbsp;Dikirim melalui email<br/>
									<input value='lainnya' checked class='layan-normal-form-input' name='salinan' type='radio'> &nbsp;Lainnya
								  </td>";

						}
						else {

						$view .= "<td class='layan-normal-form-font12'>
									<input value='mengambil langsung' class='layan-normal-form-input' name='salinan' type='radio'> &nbsp;Mengambil langsung<br/>
									<input value='dikirim melalui email' class='layan-normal-form-input' name='salinan' type='radio'> &nbsp;Dikirim melalui email<br/>
									<input value='lainnya' class='layan-normal-form-input' name='salinan' type='radio'> &nbsp;Lainnya
								  </td>";

						}
					
					$view .= "</tr>";

				$view .= "</table>";
				
			$view .= "<br/><br/>";
							
				$view .= "<table class='layan-normal-table-multiple'>";
					
					$view .= "<tr>";
						
						$view .= "<td class='layan-normal-form-bold' colspan='2'>Informasi Publik Yang Diminta</td>";
												
						$view .= "<td class='layan-normal-form-action-button'></td>";
											
					$view .= "</tr>";
					
					$view .= "<tr>";
												
						$view .= "<td class='layan-normal-form-bold' colspan='3'><hr class='layan-normal-form-hr'></td>";
											
					$view .= "</tr>";
					
					$view .= "<tr>";
					
						$view .= "<td class='layan-normal-form-td2st'>Action</td>";
						
						$view .= "<td class='layan-normal-form-td3st'>Nama Informasi Publik</td>";
						
						$view .= "<td class='layan-normal-form-td3st'>Alasan Penggunaan Informasi</td>";
											
					$view .= "</tr>";
					
					$view .= "<tr>";
						
						$view .= "<td class='layan-normal-form-bold' colspan='3'><hr class='layan-normal-form-hr'></td>";
											
					$view .= "</tr>";
					
					if (!empty($_SESSION['LAYAN-DATA']['dokumen'])) {

							foreach ($_SESSION['LAYAN-DATA']['dokumen'] as $key => $value) {

								$view .= "<tr class='layan-normal-table-tr-hover'>";
					
									$view .= "<td class='layan-normal-form-td2st'><div class='layan-normal-plus-button'></div><div class='layan-normal-minus-button'></div></td>";
									
									$view .= "<td><input class='layan-normal-form-input' name='dokumen[]' type='text' value='".$value['nama-dokumen']."'></td>";
									
									$view .= "<td><input class='layan-normal-form-input' name='alasan[]' type='text' value='".$value['alasan']."'></td>";

								$view .= "</tr>";

						}

					}
					else {

					$view .= "<tr class='layan-normal-table-tr-hover'>";

						$view .= "<td class='layan-normal-form-td2st'><div class='layan-normal-plus-button'></div><div class='layan-normal-minus-button'></div></td>";
							
						$view .= "<td><input class='layan-normal-form-input' name='dokumen[]' type='text'></td>";
							
						$view .= "<td><input class='layan-normal-form-input' name='alasan[]' type='text'></td>";

					$view .= "</tr>";

					}
																
					$view .= "<tr>";
						
						$view .= "<td class='layan-normal-form-bold' colspan='3'><hr class='layan-normal-form-hr'></td>";
											
					$view .= "</tr>";
				
				$view .= "</table>";	
			
			$view .= "<br/>";
			
			$view .= "<input style='margin-left:5px;' class='layan-normal-create-permohonan' type='submit' value='Simpan dan Cetak Tanda Bukti Penerimaan'>";
			
			$view .= "<br/><br/>";
			
			$view .= "</form>";
			
			$view .= "</div>";
			
		$view .= "
		
		<script type='text/javascript'>
		
		jQuery.noConflict()(function($){
		
		$(document).ready(function(){	
		
		$('#layan-upload').uploadify({
    	'uploader'  	: 'library/plugins/uploadifyOld/uploadify.swf',
    	'script'  		: 'library/capsule/admin/admin.ajax.php',
    	'cancelImg' 	: 'library/plugins/uploadifyOld/uploadify-cancel.png',
  		'auto'      	: false,
  		'multi'			: false,
  		'buttonText'	: 'Select Files',
  		'queueID'       : 'layan-queue',
  		'scriptData'  	: 
  			{
  			'sessionID'	: '".session_id()."',
  			'control'	: 'admin/uploadItem',
       		'incl' 	 	: 'library/capsule/admin/admin.main.php',
       		'myFolder' 	: $('.adminContentHeader').val(),
  			},
  		'onComplete'  : function(event, ID, fileObj, response, data) {
  			notificationCenter(response);
      		//alert('There are ' + data.fileCount + ' files remaining in the queue.');
   		 	}

   		});
   		
   		});
   		
   		});
   		
   		</script>
		
		";	
		
		unset($_SESSION['LAYAN-DATA']);

		echo $view;
	
	}
	
	public function id() {
		
		$this->data = base64_decode($_GET['ref']); 
		
		$data  = $this->getDokumenLengkap();

		$time  = $this->getTime($this->data);
						
		$view .= $this->optionGear;

			if (!empty($data)) {
		
				$view .= "<div class='layan-id-float-left'>".strtoupper($data['CAP_LAY_NAMA'])." (".$data['CAP_LAY_TIPEPEMOHON'].")</div><div class='layan-id-float-right'>$data[CAP_LAY_TRANSACTIONID] | ".date("l d F Y | H:i:s",strtotime($time['DATETIME']))."</div>";
				
			}
	
		echo $view;
		
	}
	
	public function icon_admin() {
										
		$view  = $this->optionGear;
		
		$name  = $this->getUserName();
		
		$view .= "<div class='layan-icon-container'>";
		
		$view .= "<a href='index.php?id=1942'><div class='layan-icon-float-left-new-home' text='Home'>Dashboard</div></a>";
		
		$view .= "<a href='index.php?id=2384' target='_blank'><div class='layan-icon-float-left-new-dado' text='Buka Si Dado'>Si Dado</div></a>";

		$view .= "<a href='index.php?id=1943'><div class='layan-icon-float-left-new-setting' text='Settings'>Settings</div></a>";
		
		$view .= "</div>";
		
		$view .= "<a href='index.php?id=logout'><div class='layan-logout-container'>";
		
		$view .= "Logout";
				
		$view .= "</div></a>";
		
		$view .= "<div class='layan-icon_admin-name-container'>";
		
		$view .= ucwords(strtolower($name));
				
		$view .= "</div>";
					
		echo $view;
		
	}

	public function icon_user() {
										
		$view  = $this->optionGear;
		
		$name  = $this->getUserName();
		
		$view .= "<div class='layan-icon-container'>";
		
		$view .= "<a href='index.php?id=1921'><div class='layan-icon-float-left-new-home' text='Home'>Dashboard</div></a>";

		$view .= "<a href='index.php?id=1991'><div class='layan-icon-float-left-new-permohonan' text='Permohonan Baru'>Permohonan</div></a>";
		
		$view .= "<a href='index.php?id=3424' target='_blank'><div class='layan-icon-float-left-new-dado' text='Buka Si Dado'>Si Dado</div></a>";
		
		$view .= "</div>";

		$view .= "<a href='index.php?id=logout'><div class='layan-logout-container'>";
		
		$view .= "Logout";
				
		$view .= "</div></a>";
		
		$view .= "<div class='layan-icon_admin-name-container'>";
		
		$view .= ucwords(strtolower($name));
				
		$view .= "</div>";
					
		echo $view;
		
	}
	
	public function icon_library() {
										
		$view  = $this->optionGear;
		
		$name  = $this->getUserName();
		
		$view .= "<div class='layan-icon-container'>";
		
			if (!empty($_SESSION['LAYAN-LIBRARY-ORDER'])) {
			$docOrder = count($_SESSION['LAYAN-LIBRARY-ORDER']);
			}
			else {
			$docOrder = 0;
			}
		
		$view .= "<a><div class='layan-icon-float-left-library-order' text='order'>Library View (<span class='layan-icon-float-left-new-orderNumber'>$docOrder</span>)</div></a>";
		
		$view .= "<a><div class='layan-icon-float-left-new-order' text='order'>Order View (<span class='layan-icon-float-left-new-orderNumber'>$docOrder</span>)</div></a>";
				
		$view .= "<a><div class='layan-icon-float-left-cancel-order' text='order'>Reset Order</div></a>";
		
		//$view .= "<a><div class='layan-icon-float-left-new-orderPrint' text='orderPrint'>Checkout</div></a>";
		
		$view .= "</div>";
					
		echo $view;
		
	}
	
	public function icon_guest_library() {
										
		$view  = $this->optionGear;
		
		$name  = $this->getUserName();
		
		$view .= "<div class='layan-icon-container'>";
		
			if (!empty($_SESSION['LAYAN-LIBRARY-ORDER'])) {
			$docOrder = count($_SESSION['LAYAN-LIBRARY-ORDER']);
			}
			else {
			$docOrder = 0;
			}
		
		$view .= "<a href='index.php'><div class='layan-icon-float-left-library-order' text='order'>Beranda </div></a>";
				
		$view .= "</div>";
					
		echo $view;
		
	}

	public function admin_settings() {

		$view  = $this->optionGear;

			if (!empty($_SESSION['LAYAN-PERMOHONAN'])) {

				$post = $this->saveGeneralSetting($_SESSION['LAYAN-PERMOHONAN'],$_SESSION['LAYAN-FILES']);
				
				unset($_SESSION['LAYAN-PERMOHONAN']);
								
			}
			
			if (!empty($_SESSION['LAYAN-FILES'])) {

				unset($_SESSION['LAYAN-FILES']);

			}
		
		$brand = $this->getBrand();

		$view .= "<div class='layan-admin_settings-container'>";
		
			$view .= "<div class='layan-admin_settings-left'>";

				$view .= "<ul>";
					
					$view .= "<a href='index.php?id=1943'><li>Umum</li></a>";
					
					$view .= "<a href='index.php?id=2364'><li>Hari Libur</li></a>";

				$view .= "</ul>";

			$view .= "</div>";
			
		$view .= "<div class='layan-admin_settings-right'>";

			$view .= "<div class='layan-admin_settings-top-container'>";

			$view .= "<div class='layan-admin_settings-headers'>Umum</div>";

			$view .= "<div class='layan-admin_settings-table-container'>";

			$view .= "<form name='layan-admin_settings-time-table-form' action='library/capsule/layan/process/process.php' method='post' autocomplete='off' enctype='multipart/form-data'>";

				$view .= "<table class='layan-admin_settings-right-general-table'>";
					
					$view .= "<tr>";

						$view .= "<td colspan='2'><hr class='layan-admin_settings-hr'></td>";

					$view .= "</tr>";

					$view .= "<tr>";
					
						$view .= "<td style='vertical-align:middle' colspan='2'><img class='layan-admin_settings-images-container' src='framework/resize.class.php?src=".$brand[0]['CAP_LAY_BRA_LOGO']."&h=120&w=120&zc=1'></td>";
											
					$view .= "</tr>";
					
					$view .= "<tr>";
					
						$view .= "<td style='vertical-align:middle'>Logo</td>";
						
						$view .= "<td style='vertical-align:middle'><input class='layan-normal-form-input' type='file' value='".$brand[0]['CAP_LAY_BRA_ID']."' name='file'></td>";
					
					$view .= "</tr>";
					
					$view .= "<tr>";
					
						$view .= "<td style='vertical-align:middle'>Nama Organisasi</td>";
						
						$view .= "<td style='vertical-align:middle'><input class='layan-normal-form-input' type='text' value='".$brand[0]['CAP_LAY_BRA_NAME']."' name='nama-organisasi'></td>";
					
					$view .= "</tr>";
					
					$view .= "<tr>";
					
						$view .= "<td style='vertical-align:middle'>Tagline 1</td>";
						
						$view .= "<td style='vertical-align:middle'><input class='layan-normal-form-input' type='text' value='".$brand[0]['CAP_LAY_BRA_TAGLINE1']."' name='tagline-1'></td>";
					
					$view .= "</tr>";
					
					$view .= "<tr>";
					
						$view .= "<td style='vertical-align:middle'>Tagline 2</td>";
						
						$view .= "<td style='vertical-align:middle'><input class='layan-normal-form-input' type='text' value='".$brand[0]['CAP_LAY_BRA_TAGLINE2']."' name='tagline-2'></td>";
					
					$view .= "</tr>";
					
					$view .= "<tr>";
					
						$view .= "<td style='vertical-align:middle'>Tagline 3</td>";
						
						$view .= "<td style='vertical-align:middle'><input class='layan-normal-form-input' type='text' value='".$brand[0]['CAP_LAY_BRA_TAGLINE3']."' name='tagline-3'></td>";
					
					$view .= "</tr>";
					
					$view .= "<tr>";
					
						$view .= "<td style='vertical-align:middle'>Alamat</td>";
						
						$view .= "<td style='vertical-align:middle'><input class='layan-normal-form-input' type='text' value='".$brand[0]['CAP_LAY_BRA_ADDRESS']."' name='alamat'></td>";
					
					$view .= "</tr>";
					
					$view .= "<tr>";
					
						$view .= "<td style='vertical-align:middle'>Telepon</td>";
						
						$view .= "<td style='vertical-align:middle'><input class='layan-normal-form-input' type='text' value='".$brand[0]['CAP_LAY_BRA_TELEPHONE']."' name='telepon'></td>";
					
					$view .= "</tr>";
					
					$view .= "<tr>";
					
						$view .= "<td style='vertical-align:middle'>Fax</td>";
						
						$view .= "<td style='vertical-align:middle'><input class='layan-normal-form-input' type='text' value='".$brand[0]['CAP_LAY_BRA_FAX']."' name='fax'></td>";
					
					$view .= "</tr>";
					
					$view .= "<tr>";
					
						$view .= "<td style='vertical-align:middle'>Website</td>";
						
						$view .= "<td style='vertical-align:middle'><input class='layan-normal-form-input' type='text' value='".$brand[0]['CAP_LAY_BRA_WEBSITE']."' name='website'></td>";
					
					$view .= "</tr>";
					
					$view .= "<tr>";
					
						$view .= "<td style='vertical-align:middle'>Email</td>";
						
						$view .= "<td style='vertical-align:middle'><input class='layan-normal-form-input' type='text' value='".$brand[0]['CAP_LAY_BRA_EMAIL']."' name='email'></td>";
					
					$view .= "</tr>";
					
					$view .= "<tr>";
					
						$view .= "<td style='vertical-align:middle'>Ganti Semua History</td>";
						
						$view .= "<td style='vertical-align:middle'><input class='layan-normal-form-input' type='checkbox' value='1' name='history'>Ya</td>";
					
					$view .= "</tr>";
				
				$view .= "</table>";
			
			$view .= "<div class='layan-admin_settings-submit-container'><input type='submit' value='Save'></div>";

			$view .= "</form>";

			$view .= "</div>";
			
			$view .= "</div>";

		$view .= "</div>";
		
		echo $view;
		
	}
	
	public function admin_settings_holiday() {

		$view  = $this->optionGear;

			if (!empty($_SESSION['LAYAN-PERMOHONAN'])) {

				if (!empty($_SESSION['LAYAN-PERMOHONAN']['year'])) {

				$year = $_SESSION['LAYAN-PERMOHONAN']['year'];

				}
				else {

				$year = date("Y");

				}

				$post = $this->saveHoliday($_SESSION['LAYAN-PERMOHONAN']);
				
				unset($_SESSION['LAYAN-PERMOHONAN']);
				
			}
			else {

			$year = date("Y");

			}

		$holiday = $this->getHolidayDate(date("$year-01-01"),date("$year-12-31"));

		$view .= "<div class='layan-admin_settings-container'>";
		
			$view .= "<div class='layan-admin_settings-left'>";

				$view .= "<ul>";
					
					$view .= "<a href='index.php?id=1943'><li>Umum</li></a>";
					
					$view .= "<a href='index.php?id=2364'><li>Hari Libur</li></a>";

				$view .= "</ul>";

			$view .= "</div>";		

		$view .= "<div class='layan-admin_settings-right'>";

			$view .= "<div class='layan-admin_settings-top-container'>";

			$view .= "<div class='layan-admin_settings-headers'>Hari Libur</div>";

			$view .= "<div class='layan-admin_settings-yearPicker'>";

				$view .= "<select class='layan-admin_settings-year-select'>";

					for ($i = date("Y")-2, $c = $i + 15; $i < $c; $i++) {

						if ($year == $i) {

							$view .= "<option selected='selected' value='$i'>$i</option>";

						}
						else {

							$view .= "<option value='$i'>$i</option>";

						}

					}

				$view .= "<select>";

			$view .= "</div>";

			$view .= "</div>";

			$view .= "<div class='layan-admin_settings-table-container'>";

			$view .= "<form name='layan-admin_settings-time-table-form' action='library/capsule/layan/process/process.php' method='post' autocomplete='off'>";

			$view .= "<input type='hidden' name='year' value='$year'>";

			$view .= "<input type='hidden' name='delete' class='layan-permohonan-dokumen-delete' value=''>";

			$view .= "<table class='layan-admin_settings-right-time-table'>";

				$view .= "<thead>";

					$view .= "<tr>";

						$view .= "<td>Action</td>";

						$view .= "<td>Tanggal</td>";

						$view .= "<td>Deskripsi</td>";

					$view .= "</tr>";

					$view .= "<tr>";

						$view .= "<td colspan='3'><hr class='layan-admin_settings-hr'></td>";

					$view .= "</tr>";

				$view .= "</thead>";

				$view .= "<tbody>";

				if (!empty($holiday)) {

					foreach ($holiday as $key => $value) {

						$view .= "<tr class='layan-normal-table-tr-hover'>";

							$view .= "<td class='layan-admin_settings-holiday-action'><div class='layan-setting-plus-button'></div><div class='layan-setting-minus-button'></div><input type='hidden' name='idDokumen[]' value='".$value['CAP_LAY_CAL_ID']."'></td>";

							$view .= "<td><input class='layan-normal-form-input datepickerSetting' type='text' name='date[]' value='".date("d-m-Y",strtotime($value['CAP_LAY_CAL_DATE']))."'></td>";

							$view .= "<td><input class='layan-normal-form-input' type='text' name='deskripsi[]' value='".ucwords(strtolower($value['CAP_LAY_CAL_DESCRIPTION']))."'></td>";

						$view .= "</tr>";

					}

				}
				else {

					$view .= "<tr class='layan-normal-table-tr-hover'>";

						$view .= "<td class='layan-admin_settings-holiday-action'><div class='layan-normal-plus-button'></div><div class='layan-normal-minus-button'></div><input type='hidden' name='idDokumen[]' value=''></td>";

						$view .= "<td><input class='layan-normal-form-input datepickerSetting' type='text' name='date[]' value=''></td>";

						$view .= "<td><input class='layan-normal-form-input' type='text' name='deskripsi[]' value=''></td>";

					$view .= "</tr>";

				}

				$view .= "</tbody>";

			$view .= "</table>";

			$view .= "<div class='layan-admin_settings-submit-container'><input type='submit' value='Save'></div>";

			$view .= "</form>";

			$view .= "</div>";

		$view .= "</div>";
				
		$view .= "</div>";
					
		echo $view;
		
	}

	public function admin_settings_holiday_ajax() {

		$holiday = $this->getHolidayDate(date("".$this->data."-01-01"),date("".$this->data."-12-31"));

		$view .= "<form name='layan-admin_settings-time-table-form' action='library/capsule/layan/process/process.php' method='post' autocomplete='off'>";

		$view .= "<input type='hidden' name='year' value='".$this->data."'>";

		$view .= "<input type='hidden' name='delete' class='layan-permohonan-dokumen-delete' value=''>";

			$view .= "<table class='layan-admin_settings-right-time-table'>";

				$view .= "<thead>";

					$view .= "<tr>";

						$view .= "<td>Action</td>";

						$view .= "<td>Tanggal</td>";

						$view .= "<td>Deskripsi</td>";

					$view .= "</tr>";

					$view .= "<tr>";

						$view .= "<td colspan='3'><hr class='layan-admin_settings-hr'></td>";

					$view .= "</tr>";

				$view .= "</thead>";

				$view .= "<tbody>";

				if (!empty($holiday)) {

					foreach ($holiday as $key => $value) {

						$view .= "<tr class='layan-normal-table-tr-hover'>";

							$view .= "<td class='layan-admin_settings-holiday-action'><div class='layan-setting-plus-button'></div><div class='layan-setting-minus-button'></div><input type='hidden' name='idDokumen[]' value='".$value['CAP_LAY_CAL_ID']."'></td>";

							$view .= "<td><input class='layan-normal-form-input datepickerSetting' type='text' name='date[]' value='".date("d-m-Y",strtotime($value['CAP_LAY_CAL_DATE']))."'></td>";

							$view .= "<td><input class='layan-normal-form-input' type='text' name='deskripsi[]' value='".ucwords(strtolower($value['CAP_LAY_CAL_DESCRIPTION']))."'></td>";

						$view .= "</tr>";

					}

				}
				else {

					$view .= "<tr class='layan-normal-table-tr-hover'>";

						$view .= "<td class='layan-admin_settings-holiday-action'><div class='layan-normal-plus-button'></div><div class='layan-normal-minus-button'></div><input type='hidden' name='idDokumen[]' value=''></td>";

						$view .= "<td><input class='layan-normal-form-input datepickerSetting' type='text' name='date[]' value=''></td>";

						$view .= "<td><input class='layan-normal-form-input' type='text' name='deskripsi[]' value=''></td>";

					$view .= "</tr>";

				}

				$view .= "</tbody>";

			$view .= "</table>";

			$view .= "<div class='layan-admin_settings-submit-container'><input type='submit' value='Save'></div>";

		$view .= "</form>";

	echo $view;

	}
	
	public function overview() {

		$view .= $this->optionGear;
				
		$this->data = base64_decode($_GET['ref']); 
		
		$primeData  = $this->getDokumenLengkap();

		$document  = $this->getDocument($this->data); 

		$perpanjang  = $this->getPerpanjanganByIDLayan($this->data); 

		$penolakan   = $this->getPenolakanByIDLayan($this->data); 

		$pemberitahu = $this->getPemberitahuanByIDLayan($this->data); 

		$sejarah     = $this->getSejarahByPermohonanID($this->data); 

		$time  = $this->getTime($this->data);

		$data  = $this->getTotalDocumentByCountByID(); 

		$data2 = $this->getPemberitahuanByCountByID(); 
		
		$data3 = $this->getPenolakanByCountByID();
		
		$data4 = $this->getPerpanjanganByCountByID();
		
		$data6 = $this->getKeberatanByCountByID();
		
		$data5 = $this->getPotentialJobTerlampirByCountByID();
				
		$view .= "<div class='layan-overview-container'>";
		
			$view .= "<div class='layan-counter-container-1'>";
			
				$view .= "<div class='layan-counter-container-1-inside'>";
				
					$view .= "<div class='layan-counter-container-1-insideBottom1'>".$data['COUNT']."</div>";
					
					$view .= "<div class='layan-counter-container-1-insideBottom2'>Informasi Publik</div>";
					
				$view .= "</div>";
			
			$view .= "</div>";

			$view .= "<div class='layan-counter-container-1'>";
			
				$view .= "<div class='layan-counter-container-1-inside'>";
				
					$view .= "<div class='layan-counter-container-1-insideBottom1'>".$data2['COUNT']."</div>";
					
					$view .= "<div class='layan-counter-container-1-insideBottom2'>Pemberitahuan</div>";
					
				$view .= "</div>";
			
			$view .= "</div>";
			
			$view .= "<div class='layan-counter-container-2'>";
							
				$view .= "<div class='layan-counter-container-2-inside'>";
				
					$view .= "<div class='layan-counter-container-2-insideBottom1'>".$data3['COUNT']."</div>";
					
					$view .= "<div class='layan-counter-container-2-insideBottom2'>Penolakan</div>";
					
				$view .= "</div>";
			
			$view .= "</div>";
			
			$view .= "<div class='layan-counter-container-3'>";
							
				$view .= "<div class='layan-counter-container-3-inside'>";
				
					$view .= "<div class='layan-counter-container-3-insideBottom1'>".$data4['COUNT']."</div>";
					
					$view .= "<div class='layan-counter-container-3-insideBottom2'>Perpanjangan</div>";
					
				$view .= "</div>";
			
			$view .= "</div>";

			$view .= "<div class='layan-counter-container-3'>";
							
				$view .= "<div class='layan-counter-container-3-inside'>";
				
					$view .= "<div class='layan-counter-container-3-insideBottom1'>".$data6['COUNT']."</div>";
					
					$view .= "<div class='layan-counter-container-3-insideBottom2'>Keberatan</div>";
					
				$view .= "</div>";
			
			$view .= "</div>";
			
			$baseCal = @(100/$data['COUNT']);

			if (!empty($document)) {

				foreach ($document as $key => $value) {

					$resultOne = $this->getDocumentPemberitahuanCheck($value['CAP_LAY_DOC_REQ_ID']);

					$resultTwo = $this->getDocumentPenolakanCheck($value['CAP_LAY_DOC_REQ_ID']);

						if (!empty($resultOne) || !empty($resultTwo)) {

							$percentage += $baseCal;

						}

				}

			}

			$view .= "<div class='layan-counter-container-4'>";
							
				$view .= "<div class='layan-counter-container-4-inside'>";
				
					$view .= "<div class='layan-counter-container-4-insideBottom1'>".number_format($percentage,0)."</div>";
					
					$view .= "<div class='layan-counter-container-4-insideBottom2'>Persen</div>";
					
				$view .= "</div>";
			
			$view .= "</div>";
		
		$view .= "</div>";

		$view .= "<div class='layan-overview-separator'></div>";

		$view .= "<div class='layan-overview-timeline-total'>";

		$timeLimit = $this->getTimeLimitPermohonan();
		
		//$timeLimit  = $this->getCurrentTimeOverviewStyle(date("Y-m-d",strtotime($timeKeberatan['DATETIME'])),date("Y-m-d",strtotime($time2Keberatan['DATETIME'])));

		$checkEndTime = $this->checkEndTime();

			if (!empty($checkEndTime)) {
				$startDate = $checkEndTime;
			}
			else {
				$startDate = date("Y-m-d H:i:s");
			}

		$currentTime  = $this->getCurrentTime($startDate,date("Y-m-d H:i:s",strtotime($time['DATETIME'])));
		
			if ($currentTime < 0) {

			$currentTime = 0;

			}
		
		for ($j = 0; $j <= 17; $j++) {

			if ($currentTime == $j) {
				
				if ($currentTime < 4) {

				$view .= "<li class='layan-overview-li-time-green'>$j</li>";

				}
				else if ($currentTime > 4 || $currentTime < 10) {

				$view .= "<li class='layan-overview-li-time-yellow'>$j</li>";

				}
				else if ($currentTime > 10) {

				$view .= "<li class='layan-overview-li-time-red'>$j</li>";

				}

			}
			else {

			$view .= "<li class='layan-overview-li-time-normal'>$j</li>";

			}

		}

		$view .= "<div class='layan-overview-separator-floating'><hr class='layan-overview-hr'></div>";

		$view .= "</div>";

		$view .= "<div class='layan-overview-left-area'>";

			$view .= "<div class='layan-overview-left-area-chart-container'>";

				$view .= "<div class='layan-overview-chart-header layan-overview-header-portlet'>";

				$view .= "Timeline Dokumen";

				$view .= "</div>";

				$view .= "<div id='layan-overview-chart-1'></div>";

				$view .= "<div class='layan-overview-form-container-left'>";

					$view .= "<div class='layan-overview-sejarah-header layan-overview-header-portlet-right'>";

						$view .= "Sejarah 7 Hari Terakhir";

					$view .= "</div>";

					$view .= "<div class='layan-overview-sejarah-content'>";

						if (!empty($sejarah)) {

							foreach ($sejarah as $key => $value) {

							$view .= "<div class='layan-overview-sejarah-date-header'>".date("d, F Y",strtotime($value['DATE']))."</div>";

							$view .= "<hr class='layan-normal-form-hr'>";

							$view .= "<ul class='layan-overview-sejarah-ul'>";

								foreach ($value['VALUE'] as $key2 => $value2) {

								$view .= "<li>".ucfirst(strtolower($value2['CAP_LAY_HIS_TEXT']))." <br><span class='layan-overview-sejarah-span'>(".date("H:i:s",strtotime($value2['DATETIME'])).")</span></li>";

								$view .= "<hr class='layan-normal-form-hr'>";

								}

							$view .= "</ul>";

							$view .= "<br>";

							}

						}

					$view .= "</div>";

				$view .= "</div>";

			$view .= "</div>";

		$view .= "</div>";

		$view .= "<div class='layan-overview-right-area'>";
		
		$view .= "<div class='layan-overview-waktu-berakhir'>";

			$view .= "<div class='layan-overview-chart-header layan-overview-header-portlet-right'>";

			$view .= "Status Permohonan";

			$view .= "</div>";
			
			$view .= "<div class='layan-overview-form-container-status'>";
				
				if ($primeData['CAP_LAY_FINALSTATUS'] == 0) {
					$statusPermohonan = "Menunggu Data Attachment";
				}
				else if ($primeData['CAP_LAY_FINALSTATUS'] == 1) {
					$statusPermohonan = "Data Attachment Tersedia";
				}
				else if ($primeData['CAP_LAY_FINALSTATUS'] == 2) {
					$statusPermohonan = "Kadaluarsa Karena 3 Hari Belum ada Data Attachment";
				}
				else if ($primeData['CAP_LAY_FINALSTATUS'] == 3) {
					$statusPermohonan = "Dokumen Sudah diberikan Kepada Pemohon";
				}
				else if ($primeData['CAP_LAY_FINALSTATUS'] == 5) {
					$statusPermohonan = "Semua Dokumen Permohonan Bebas Dari Waktu Keberatan";
				}
				
				$view .= "<div style='text-align:left;margin-top:18px;padding-left:10px;font-weight:bold;font-size:13px;'>$statusPermohonan</div>";
			
			$view .= "</div>";
			
		$view .= "</div>";
		
		$keberatanDoc = $this->getKeberatanLengkap();
				
		$view .= "<div class='layan-overview-waktu-berakhir'>";

			$view .= "<div class='layan-overview-chart-header layan-overview-header-portlet-right'>";

			$view .= "Status Keberatan";

			$view .= "</div>";
			
			$view .= "<div class='layan-overview-form-container-status'>";

				$view .= "<table class='layan-overview-form-container-status-table'>";
				
				$view .= "<thead>";
				
					$view .= "<tr>";
						
						$view .= "<td>No. Keberatan</td>";
						
						$view .= "<td style='text-align:center;'>Tanggapan</td>";
													
						$view .= "<td style='text-align:center;'>Status</td>";
						
					$view .= "</tr>";
				
				$view .= "</thead>";
				
				$view .= "<tbody>";
				
				if (!empty($keberatanDoc)) {
				
					foreach ($keberatanDoc as $key => $value) {
									
						$timeKeberatan  = $this->getTimeByTable('CAP_LAY_KEB_DATECREATED',"CAP_LAYAN_KEBERATAN WHERE CAP_LAY_KEB_ID = '".$value['CAP_LAY_KEB_ID']."'");
						
							if (!empty($value['CAP_LAY_KEB_DATE_TO'])) {
						
								$time2Keberatan  = $this->getTimeByTable('CAP_LAY_KEB_DATE_TO',"CAP_LAYAN_KEBERATAN WHERE CAP_LAY_KEB_ID = '".$value['CAP_LAY_KEB_ID']."'");
								
							}
							else {
								
								$time2Keberatan  = array("DATETIME" => date("Y-m-d H:i:s"));
								
							}
												
						$daysKeberatan  = $this->getCurrentTimeOverviewStyle(date("Y-m-d",strtotime($timeKeberatan['DATETIME'])),date("Y-m-d",strtotime($time2Keberatan['DATETIME'])));
						
							$view .= "<tr>";
							
								$view .= "<td>".$value['CAP_LAY_KEB_NUMBER']."</td>";
								
								$view .= "<td style='text-align:center;'>$daysKeberatan Hari</td>";
								
								if ($value['CAP_LAY_KEB_STATUS'] == 0) {
									$statusKeberatan = "Belum di Proses";
								}
								else if ($value['CAP_LAY_KEB_STATUS'] == 1) {
									$statusKeberatan = "Selesai Internal";
								}
								else if ($value['CAP_LAY_KEB_STATUS'] == 2) {
									$statusKeberatan = "Daftar ke K.I";
								}
								else if ($value['CAP_LAY_KEB_STATUS'] == 3) {
									$statusKeberatan = "Tidak ditanggapi";
								}
								
								$view .= "<td style='text-align:center;'>".$statusKeberatan."</td>";
							
							$view .= "</tr>";
							
					}
				
				}
				
				$view .= "</tbody>";
				
				$view .= "</table>";
			
			$view .= "</div>";
			
		$view .= "</div>";

		$view .= "<div class='layan-overview-waktu-berakhir'>";

			$view .= "<div class='layan-overview-chart-header layan-overview-header-portlet-right'>";

			$view .= "Tanggal Berakhir Permohonan";

			$view .= "</div>";

			$view .= "<div class='layan-overview-form-container-waktu'>";

			$view .= date("d F, Y",strtotime($timeLimit));

			$view .= "</div>";

			$view .= "<div class='layan-overview-form-container-waktu-container'>";

			$view .= "<table class='layan-overview-form-container-waktu-dokumen'>";
		
		if (!empty($document)) {
				
			foreach ($document as $key => $value) {

			$docName = $value['CAP_LAY_DOC_REQ_DOCNAME'];

			$theDate = $this->getTimeForDocument($value['CAP_LAY_DOC_REQ_ID']);

				if (!empty($theDate[0]['CAP_LAY_PER_DATE_TO'])) {
					$realDate = date("d F, Y",strtotime($theDate[0]['CAP_LAY_PER_DATE_TO']));
				}
				else {
					$realDate = 'None';
				}

			$count   = count($theDate);

				$view .= "<tr>";

					$view .= "<td>".$value['CAP_LAY_DOC_REQ_DOCNAME']."</td>";

					$view .= "<td class='align-center'>".$count."</td>";

					$view .= "<td class='align-right'>".$realDate."</td>";

				$view .= "</tr>";

			}
			
		}

			$view .= "</table>";

			$view .= "</div>";

		$view .= "</div>";

		$view .= "<div class='layan-overview-document-list'>";

			$view .= "<div class='layan-overview-chart-header layan-overview-header-portlet-right'>";

			$view .= "List Dokumen";

			$view .= "</div>";

			$docu = $this->getPemberitahuanLengkap();
			
			if (!empty($docu)) {

			$view .= "<div class='layan-overview-form-container'>";
													
				$view .= "<span class='layan-overview-span-bold'>Pemberitahuan Tertulis</span><hr class='layan-normal-form-hr'>";

					foreach ($docu as $key => $value) {
					
					$documenta = $this->getPemberitahuanDokumen($value['CAP_LAY_PEM_ID']);
									
					$c = count($documenta);
					
					if (empty($c) || empty($documenta[0]['CAP_LAY_PEM_DOC_ID'])) {$c = 0;}
					
					$view .= "<li>+ ".$value['CAP_LAY_PEM_NUMBER']." - $c Dokumen - ".date("d F, Y",strtotime($documenta[0]['CAP_LAY_PEM_DATECREATED']));
					
						if (!empty($documenta)) {
							
							$view .= "<ul class='layan-overview-ul-secondary'>";

								foreach ($documenta as $key2 => $value2) {
								
									if (!empty($value2['CAP_LAY_PEM_DOC_ID'])) {

									$view .= "<li>- ".ucwords(strtolower($value2['CAP_LAY_DOC_REQ_DOCNAME']))."</li>";
									
									}

								}
							
							$view .= "</ul>";
							
						}

					$view .= "</li>";
					
					}
							
			$view .= "</ul>";
			
			$view .= "</div>";

			}

			$docu = $this->getPenolakanLengkap();
			
			if (!empty($docu)) {

			$view .= "<div class='layan-overview-form-container'>";
													
				$view .= "<span class='layan-overview-span-bold'>Penolakan</span><hr class='layan-normal-form-hr'>";

					foreach ($docu as $key => $value) {
					
					$documenta = $this->getPenolakanDokumen($value['CAP_LAY_PEN_ID']);
									
					$c = count($documenta);
					
					if (empty($c) || empty($documenta[0]['CAP_LAY_PEN_DOC_ID'])) {$c = 0;}
					
					$view .= "<li>+ ".$value['CAP_LAY_PEN_NUMBER']." - $c Dokumen - ".date("d F, Y",strtotime($documenta[0]['CAP_LAY_PEN_DATECREATED']));
					
						if (!empty($documenta)) {
							
							$view .= "<ul class='layan-overview-ul-secondary'>";

								foreach ($documenta as $key2 => $value2) {
								
									if (!empty($value2['CAP_LAY_PEN_DOC_ID'])) {

									$view .= "<li>- ".ucwords(strtolower($value2['CAP_LAY_DOC_REQ_DOCNAME']))."</li>";
									
									}

								}
							
							$view .= "</ul>";
							
						}

					$view .= "</li>";
					
					}
							
			$view .= "</ul>";
			
			$view .= "</div>";

			}

			$docu = $this->getPerpanjanganLengkap();
			
			if (!empty($docu)) {

			$view .= "<div class='layan-overview-form-container'>";
													
				$view .= "<span class='layan-overview-span-bold'>Perpanjangan</span><hr class='layan-normal-form-hr'>";

					foreach ($docu as $key => $value) {
					
					$documenta = $this->getPerpanjanganDokumen($value['CAP_LAY_PER_ID']);
									
					$c = count($documenta);
					
					if (empty($c) || empty($documenta[0]['CAP_LAY_PER_DOC_ID'])) {$c = 0;}
					
					$view .= "<li>+ ".$value['CAP_LAY_PER_NUMBER']." - $c Dokumen - ".date("d F, Y",strtotime($value['CAP_LAY_PER_DATE_TO']));
					
						if (!empty($documenta)) {
							
							$view .= "<ul class='layan-overview-ul-secondary'>";

								foreach ($documenta as $key2 => $value2) {
								
									if (!empty($value2['CAP_LAY_PER_DOC_ID'])) {

									$view .= "<li>- ".ucwords(strtolower($value2['CAP_LAY_DOC_REQ_DOCNAME']))."</li>";
									
									}

								}
							
							$view .= "</ul>";
							
						}

					$view .= "</li>";
					
					}
				
				
			
			$view .= "</ul>";
			
			$view .= "</div>";

			}
			
			$docu = $this->getKeberatanLengkap();
			
			if (!empty($docu)) {

			$view .= "<div class='layan-overview-form-container'>";
													
				$view .= "<span class='layan-overview-span-bold'>Keberatan</span><hr class='layan-normal-form-hr'>";

					foreach ($docu as $key => $value) {
					
					//$documenta = $this->getKeberatanDokumen($value['CAP_LAY_PER_ID']);
					
					$documenta = $this->getKeberatanDokumen($value['CAP_LAY_KEB_ID']);

					$c = 0;

						foreach ($documenta as $key2 => $value2) {

							if (!empty($value2['CAP_LAY_ID'])) {

							$c++;
									
							}
							else if (!empty($value2['CAP_LAY_PEM_ID'])) {

							$c++;
									
							}
							else if (!empty($value2['CAP_LAY_PEN_ID'])) {

							$c++;
									
							}
							else if (!empty($value2['CAP_LAY_PER_ID'])) {

							$c++;
									
							}

						}
					
					if (empty($c) || empty($documenta[0]['CAP_LAY_KEB_DOC_ID'])) {$c = 0;}
					
					//$view .= "<li><input type='checkbox' value='".$value['CAP_LAY_KEB_ID']."'> &nbsp;".$value['CAP_LAY_KEB_NUMBER']." - $c Dokumen";
									
					//$c = count($documenta);
					
					//if (empty($c) || empty($documenta[0]['CAP_LAY_PER_DOC_ID'])) {$c = 0;}
					
					$view .= "<li>+ ".$value['CAP_LAY_KEB_NUMBER']." - $c Dokumen - ".date("d F, Y",strtotime($value['CAP_LAY_KEB_DATECREATED']));
						
						if (!empty($documenta)) {
							
							$view .= "<ul class='layan-admin_pemberitahuan-ul-secondary'>";

								foreach ($documenta as $key2 => $value2) {
								
									if (!empty($value2['CAP_LAY_ID'])) {

									$view .= "<li>- Permohonan No. ".$value2['CAP_LAY_TRANSACTIONID']."</li>";
									
									}
									else if (!empty($value2['CAP_LAY_PEM_ID'])) {

									$view .= "<li>- Pemberitahuan No. ".$value2['CAP_LAY_PEM_NUMBER']."</li>";
									
									}
									else if (!empty($value2['CAP_LAY_PEN_ID'])) {

									$view .= "<li>- Penolakan No. ".$value2['CAP_LAY_PEN_NUMBER']."</li>";
									
									}
									else if (!empty($value2['CAP_LAY_PER_ID'])) {

									$view .= "<li>- Perpanjangan No. ".$value2['CAP_LAY_PER_NUMBER']."</li>";
									
									}


								}
							
							$view .= "</ul>";
							
						}
						/*
						if (!empty($documenta)) {
							
							$view .= "<ul class='layan-overview-ul-secondary'>";

								foreach ($documenta as $key2 => $value2) {
								
									if (!empty($value2['CAP_LAY_PER_DOC_ID'])) {

									$view .= "<li>- ".ucwords(strtolower($value2['CAP_LAY_DOC_REQ_DOCNAME']))."</li>";
									
									}

								}
							
							$view .= "</ul>";
							
						}
						*/
					$view .= "</li>";
					
					}
				
				
			
			$view .= "</ul>";
			
			$view .= "</div>";

			}

		$view .= "</div>";

		$attachment = $this->getPermohonanAttachment();

		$view .= "<div class='layan-overview-waktu-berakhir'>";

			$view .= "<div class='layan-overview-chart-header layan-overview-header-portlet-right'>";

			$view .= "List Attachment";

			$view .= "</div>";

			$view .= "<div class='layan-overview-form-container-waktu-container'>";

			$view .= "<table class='layan-overview-form-container-attachment-dokumen'>";

			$arrayFile = array("FOTO","KTP","AKTA","SURAT KUASA","KTP PEMBAWA KUASA","NPWP");

			if ($primeData['CAP_LAY_TIPEPEMOHON'] == 'BADAN HUKUM') {
						
				for ($l = 0; $l < 6; $l++) {

				$view .= "<tr>";

				$view .= "<td>".ucwords(strtolower($arrayFile[$l]))."</td>";

				if (!empty($attachment)) {

					foreach ($attachment as $key => $value) {

						if ($arrayFile[$l] == $key) {

							$list = "<td class='align-right'><a target='_blank' href='".$value."'>Link</a></td>";

							break;

						}
						else {

							$list = "<td class='align-right'>Empty</td>";

						}

					}

				}
				else {

				$list  = "<td class='align-right'>Empty</td>";

				}

				$view .= $list;

				$view .= "</tr>";

				}

			}
			else {

				for ($l = 0; $l < 2; $l++) {

				$view .= "<tr>";

				$view .= "<td>".ucwords(strtolower($arrayFile[$l]))."</td>";

				if (!empty($attachment)) {

					foreach ($attachment as $key => $value) {

						if ($arrayFile[$l] == $key) {

							$list = "<td class='align-right'><a target='_blank' href='".$value."'>Link</a></td>";

							break;

						}
						else {

							$list = "<td class='align-right'>Empty</td>";

						}

					}

				}
				else {

				$list  = "<td class='align-right'>Empty</td>";

				}

				$view .= $list;

				$view .= "</tr>";

				}

			}

			$view .= "</table>";

			$view .= "</div>";

		$view .= "</div>";

		$view .= "</div>";

		$view .= "<div class='layan-overview-separator'></div>";

		$categories  = "[";

			if (!empty($document)) {

				foreach ($document as $key => $value) {
					$categories .= "'".ucwords(strtolower($value['CAP_LAY_DOC_REQ_DOCNAME']))."',";
				}

			}

		$categories  = substr($categories, 0, -1);

		$categories .= "]";

		$series  = "[";
		
		$i = 0;
		
		$c = count($pemberitahu);

		if (!empty($pemberitahu)) {

			foreach ($pemberitahu as $value3) {

				$y = $c-$i++;

				$series  .= "{";

				$series  .= "name: 'Pem-".$y."',";

				$series  .= "data: [";

				if (!empty($document)) {

					foreach ($document as $value) {

					$penolakanan = $this->getLayanPemberitahuanDocumentOverview($value['CAP_LAY_DOC_REQ_ID'],$value3['CAP_LAY_PEM_ID']);

					$holidayDate = $this->getHolidayDate($value3['CAP_LAY_DATECREATED'],date("Y-12-31"));

					$endDate = $this->getEndDatePermohonan($value3['CAP_LAY_PEM_DATECREATED'],$holidayDate);

					$holidayArray = $this->getHolidayArrayNoWeekdays($holidayDate,$endDate);

					//$maxDate = $this->getMaxDatePickerNormalNumber($value3['CAP_LAY_DATECREATED'],$holidayArray,$value3['CAP_LAY_PEM_DATECREATED'],$days);
					
					$time  = $this->getTimeByTable('CAP_LAY_PEM_DATECREATED',"CAP_LAYAN_PEMBERITAHUAN WHERE CAP_LAY_PEM_ID = '".$value3['CAP_LAY_PEM_ID']."'");
					
					$time2 = $this->getTimeByTable('CAP_LAY_DATECREATED',"CAP_LAYAN WHERE CAP_LAY_ID = '".$primeData['CAP_LAY_ID']."'");
					
					$maxDate  = $this->getCurrentTimeOverviewStyle(date("Y-m-d H:i:s",strtotime($time2['DATETIME'])),date("Y-m-d H:i:s",strtotime($time['DATETIME'])));

					if ($maxDate != 0) {

					$days = $maxDate;

					}
					else {

					$days = 0.1;

					}

						if ($penolakanan[0]['FK_CAP_LAY_PEM_ID'] == $value3['CAP_LAY_PEM_ID']) {

						$series  .= $days.",";

						}
						else {

						$series  .= "0,";

						}

					}

				$series   = substr($series, 0,-1);

				}

				$series  .= "],";

				$series  .= "stack: 'Status'";

				$series  .= "},";

			}

		}

		$i = 0;

		$c = count($penolakan);

		if (!empty($penolakan)) {

			foreach ($penolakan as $value3) {

				$y = $c-$i++;

				$series  .= "{";

				$series  .= "name: 'Pen-".$y."',";

				$series  .= "data: [";

				if (!empty($document)) {

					foreach ($document as $value) {

					$penolakanan = $this->getLayanPenolakanDocumentOverview($value['CAP_LAY_DOC_REQ_ID'],$value3['CAP_LAY_PEN_ID']);

					$holidayDate = $this->getHolidayDate($value3['CAP_LAY_DATECREATED'],date("Y-12-31"));

					$endDate = $this->getEndDatePermohonan($value3['CAP_LAY_PEN_DATECREATED'],$holidayDate);

					$holidayArray = $this->getHolidayArrayNoWeekdays($holidayDate,$endDate);

					//$maxDate = $this->getMaxDatePickerNormalNumber($value3['CAP_LAY_DATECREATED'],$holidayArray,$value3['CAP_LAY_PEN_DATECREATED'],$days);
					
					$time  = $this->getTimeByTable('CAP_LAY_PEN_DATECREATED',"CAP_LAYAN_PENOLAKAN WHERE CAP_LAY_PEN_ID = '".$value3['CAP_LAY_PEN_ID']."'");
					
					$time2 = $this->getTimeByTable('CAP_LAY_DATECREATED',"CAP_LAYAN WHERE CAP_LAY_ID = '".$primeData['CAP_LAY_ID']."'");
					
					$maxDate  = $this->getCurrentTimeOverviewStyle(date("Y-m-d H:i:s",strtotime($time2['DATETIME'])),date("Y-m-d H:i:s",strtotime($time['DATETIME'])));
										
					if ($maxDate != 0) {

					$days = $maxDate;

					}
					else {

					$days = 0.1;

					}

						if ($penolakanan[0]['FK_CAP_LAY_PEN_ID'] == $value3['CAP_LAY_PEN_ID']) {

						$series  .= $days.",";

						}
						else {

						$series  .= "0,";

						}

					}

				}

				$series  .= "],";

				$series  .= "stack: 'Status'";

				$series  .= "},";

			}

		}

		$i = 0;

		$c = count($perpanjang);

		if (!empty($perpanjang)) {

			foreach ($perpanjang as $value3) {

				$y = $c-$i++;

				$series  .= "{";

				$series  .= "name: 'Per-".$y."',";

				$series  .= "data: [";

				if (!empty($document)) {

					foreach ($document as $value) {

					$lastDate = $this->getDateBeforeThisPerpanjanganOverview($value3['FK_CAP_LAY_ID'],$value3['CAP_LAY_PER_DATE_TO'],$value['CAP_LAY_DOC_REQ_ID']);

					if (empty($lastDate[0]['CAP_LAY_PER_DATE_TO'])) {
						$currentDate = $value3['CAP_LAY_DATECREATED'];
					}
					else {
						$currentDate = $lastDate[0]['CAP_LAY_PER_DATE_TO'];
					}

					$perpanjangan = $this->getLayanPerpanjanganDocumentOverview($value['CAP_LAY_DOC_REQ_ID'],$value3['CAP_LAY_PER_ID']);

					$holidayDate = $this->getHolidayDate($currentDate,date("Y-12-31"));

					$endDate = $this->getEndDatePermohonan($currentDate,$holidayDate);

					$holidayArray = $this->getHolidayArrayNoWeekdays($holidayDate,$endDate);

					//$maxDate = $this->getMaxDatePickerNormalNumber($currentDate,$holidayArray,$value3['CAP_LAY_PER_DATE_TO'],$days);
					
					$time  = $this->getTimeByTable('CAP_LAY_PER_DATE_TO',"CAP_LAYAN_PERPANJANGAN WHERE CAP_LAY_PER_ID = '".$value3['CAP_LAY_PER_ID']."'");
					
					$time2 = $this->getTimeByTable('CAP_LAY_DATECREATED',"CAP_LAYAN WHERE CAP_LAY_ID = '".$primeData['CAP_LAY_ID']."'");
					
					$maxDate  = $this->getCurrentTimeOverviewStyle(date("Y-m-d H:i:s",strtotime($time2['DATETIME'])),date("Y-m-d H:i:s",strtotime($time['DATETIME'])));

					$days = $maxDate;

						if ($perpanjangan[0]['FK_CAP_LAY_PER_ID'] == $value3['CAP_LAY_PER_ID']) {

						$series  .= $days.",";

						}
						else {

						$series  .= "0,";

						}

					}

				}

				$series   = substr($series, 0,-1);

				$series  .= "],";

				$series  .= "stack: 'Per-1'";

				$series  .= "},";

			}

		//$series  = substr($series, 0,-1);

		}

		if (empty($series)) {
		$series .= "[0]";	
		}
		else if ($series == '[') {
		$series .= "0]";	
		}
		else {
		$series .= "]";
		}

		$view .= "

		<script type='text/javascript'>
		jQuery.noConflict()(function($){
		 var chart;
		    $(document).ready(function() {


		        chart = new Highcharts.Chart({
		    
		            chart: {
		                renderTo: 'layan-overview-chart-1',
		                type: 'column'
		            },
		    
		            title: {
		                text: ' '
		            },
		    
		            xAxis: {
		                categories: $categories
		            },
		    
		            yAxis: {
		                allowDecimals: false,
		                min: 0,
		                title: {
		                    text: 'Jumlah Hari'
		                }
		            },
		    
		            tooltip: {
		            	enabled: true,
		                formatter: function() {
		                	var a = this.series.name.replace(/[^a-z]/gi,'');
		                	var b = this.series.name.replace(/[^0-9]/gi,'');

		                		if (a != 'Per') {

		                			if (a == 'Pem') {

		                			return '<b>Pemberitahuan</b><br/>'+ 
		                			'Di hari ke: '+ this.y +'<br/>';

		                			}
		                			else {

		                			return '<b>Penolakan</b><br/>'+ 
		                			'Di hari ke: '+ this.y +'<br/>';

		                			}

		                		}
		                		else {

		                    	return '<b>'+ this.x +'</b><br/>'+
		                        'Perpanjangan ke-'+b+': '+ this.y +' hari<br/>'+
		                        'Total: '+ this.point.stackTotal+' hari';

		                    	}
		                }
		            },
		    
		            plotOptions: {
		                column: {
		                    stacking: 'normal'
		                }
		            },
		    
		            series: $series
		        });
		    });
		});
		</script>

		";

		echo $view;

	}

	public function body() {
		
		$this->data = base64_decode($_GET['ref']); 
		
			if (!empty($_SESSION['LAYAN-PERMOHONAN'])) {
		
				$post = $this->updatePermohonan($_SESSION['LAYAN-PERMOHONAN']);

				unset($_SESSION['LAYAN-PERMOHONAN']);
				
			}

			if (!empty($_SESSION['LAYAN-ERROR'])) {

				$errorAnnouncement  = "<div class='layan-error-annoucement'>";

				foreach ($_SESSION['LAYAN-ERROR'] as $key => $value) {
					
					$errorAnnouncement .= "<li>- $value</li>"; 

				}

				$errorAnnouncement .= "</div><br>";

				unset($_SESSION['LAYAN-ERROR']);

			}

		$data = $this->getDokumenLengkap();

		$tipePemohon = $this->getTipePemohon();
		
		$information = $this->getInformation();
		
		$salinan	 = $this->getSalinan();
				
		$document = $this->getDocument($this->data);

			$view  = "<div class='layan-normal-form-container'>";
						
			$view .= $this->optionGear;
			
			$view .= "<div class='layan-permohonan-upper-menu-container'>";
			
			if ($data['CAP_LAY_FINALSTATUS'] == 1 || $data['CAP_LAY_FINALSTATUS'] == 0) {
			
			$view .= "<div class='layan-permohonan-icons-container'><div class='layan-permohonan-float-left-edit-permohonan qtip-upper' text='Edit Mode'></div>
					  <a href='?id=".$_GET['id']."&ref=".$_GET['ref']."&log=".base64_encode('destroy')."'><div class='layan-permohonan-float-left-delete-permohonan qtip-upper' text='Delete Seluruh Permohonan'></div></a>
					  <a href='#print'><div class='layan-permohonan-float-left-print-permohonan qtip-upper' text='Cetak Tanda Bukti'></div></a>
					  </div>";
					  
			}
			else {
			
			$view .= "<div class='layan-permohonan-icons-container'>
					  <a href='#print'><div class='layan-permohonan-float-left-print-permohonan qtip-upper' text='Cetak Tanda Bukti'></div></a>
					  </div>";
			
			}
			
			$view .= "</div>";

			$view .= "<table class='layan-normal-table'>";
					
					$view .= "<tr>";
						
						$view .= "<td colspan='3' class='layan-normal-form-bold'><hr class='layan-normal-form-hr'></td>";
											
					$view .= "</tr>";
														
				$view .= "</table>";

			$view .= $errorAnnouncement;

			$view .= "<form name='layan-permohonan-update' action='library/capsule/layan/process/process.php' method='post'>";
			
				$view .= "<table class='layan-normal-table'>";
									
					$view .= "<tr class='layan-normal-table-tr-hover'>";
						
						//Nama Lengkap
						$view .= "<td class='layan-normal-form-td1st'>Nama Lengkap</td>";
						
						$view .= "<td>:</td>";
						
						$view .= "<td><input name='id' type='hidden' value='".$data['CAP_LAY_ID']."'><input disabled='disabled' class='layan-normal-form-input' name='nama' type='text' value='".ucwords(strtolower($data['CAP_LAY_NAMA']))."'></td>";
					
					$view .= "</tr>";
					
					$view .= "<tr class='layan-normal-table-tr-hover'>";
						
						//Pekerjaan
						$view .= "<td class='layan-normal-form-td1st'>Pekerjaan</td>";
						
						$view .= "<td>:</td>";
						
						$view .= "<td><input disabled='disabled' class='layan-normal-form-input' name='pekerjaan' type='text' value='".ucwords(strtolower($data['CAP_LAY_PEKERJAAN']))."'></td>";
					
					$view .= "</tr>";
					
					$view .= "<tr class='layan-normal-table-tr-hover'>";
						
						//Tipe Pemohon
						$view .= "<td class='layan-normal-form-td1st'>Tipe Pemohon</td>";
						
						$view .= "<td>:</td>";
						
						$view .= "<td>";
						
							$view .= "<select disabled='disabled' class='layan-normal-form-select layan-normal-form-instansi' name='tipe_pemohon'>";
								
								foreach ($tipePemohon as $key => $value) {
									
									if (strtoupper($data['CAP_LAY_TIPEPEMOHON']) == strtoupper($value['CAP_LAY_DAT_NAME'])) {
								
									$view .= "<option selected='selected' value='$value[CAP_LAY_DAT_NAME]'>".ucwords(strtolower($value['CAP_LAY_DAT_NAME']))."</option>";
																		
									}
									else {
																				
										$view .= "<option value='$value[CAP_LAY_DAT_NAME]'>".ucwords(strtolower($value['CAP_LAY_DAT_NAME']))."</option>";
										
									}
									
								}
																								
							$view .= "</select>";
							
						$view .= "</td>";
					
					$view .= "</tr>";
					
					if (strtoupper($data['CAP_LAY_TIPEPEMOHON']) == 'BADAN HUKUM') {

					$view .= "<tr class='layan-normal-table-tr-hover layan-normal-form-hide' style='display: table-row;'>";

					}
					else {

					$view .= "<tr class='layan-normal-table-tr-hover layan-normal-form-hide'>";

					}
						
						//Nama Badan Hukum
						$view .= "<td class='layan-normal-form-td1st'>Nama Badan Hukum</td>";
						
						$view .= "<td>:</td>";
						
						$view .= "<td><input disabled='disabled' class='layan-normal-form-input' name='nama-badan' type='text' value='".ucwords(strtolower($data['CAP_LAY_NAMA_BADAN']))."'></td>";
					
					$view .= "</tr>";
					
					$view .= "<tr class='layan-normal-table-tr-hover'>";
						
						//Data KTP
						$view .= "<td class='layan-normal-form-td1st'>Nomor KTP</td>";
						
						$view .= "<td>:</td>";
						
						$view .= "<td><input disabled='disabled' class='layan-normal-form-input' name='ktp' type='text' value='".ucwords(strtolower($data['CAP_LAY_KTP']))."'></td>";
					
					$view .= "</tr>";
					
					$view .= "<tr class='layan-normal-table-tr-hover'>";
						
						//Alamat Lengkap
						$view .= "<td class='layan-normal-form-td1st'>NPWP</td>";
						
						$view .= "<td>:</td>";
						
						$view .= "<td><input disabled='disabled' class='layan-normal-form-input' name='npwp' type='text' value='".ucwords(strtolower($data['CAP_LAY_NPWP']))."'></td>";
					
					$view .= "</tr>";
					
					$view .= "<tr class='layan-normal-table-tr-hover'>";
						
						//Alamat Lengkap
						$view .= "<td class='layan-normal-form-td1st'>Alamat</td>";
						
						$view .= "<td>:</td>";
						
						$view .= "<td><input disabled='disabled' class='layan-normal-form-input' name='alamat' type='text' value='".ucwords(strtolower($data['CAP_LAY_ALAMAT']))."'></td>";
					
					$view .= "</tr>";
					
					$view .= "<tr class='layan-normal-table-tr-hover'>";
						
						//Nomor Telepon
						$view .= "<td class='layan-normal-form-td1st'>No Telepon/HP</td>";
						
						$view .= "<td>:</td>";
						
						$view .= "<td><input disabled='disabled' class='layan-normal-form-input' name='telepon' type='text' value='".$data['CAP_LAY_TELEPON']."'></td>";
					
					$view .= "</tr>";
					
					$view .= "<tr class='layan-normal-table-tr-hover'>";
						
						//Email
						$view .= "<td class='layan-normal-form-td1st'>Email</td>";
						
						$view .= "<td>:</td>";
						
						$view .= "<td><input disabled='disabled' class='layan-normal-form-input' name='email' type='text' value='".$data['CAP_LAY_EMAIL']."'></td>";
					
					$view .= "</tr>";
					
					$view .= "<tr class='layan-normal-table-tr-hover layan-normal-table-vertical-align'>";
						
						//Cara Memperoleh Informasi
						$view .= "<td class='layan-normal-form-td1st'>Cara Memperoleh Informasi</td>";
						
						$view .= "<td>:</td>";
						
						$view .= "<td class='layan-normal-form-font12'>";
						
							foreach ($information as $key => $value) {
								
								if (strtoupper($data['CAP_LAY_INFORMASI']) == strtoupper($value['CAP_LAY_DAT_NAME'])) {
								
								$view .= "<input checked disabled='disabled' value='".$value['CAP_LAY_DAT_NAME']."' class='layan-normal-form-input' name='memperoleh' type='radio'> &nbsp;".ucwords(strtolower($value['CAP_LAY_DAT_NAME']))."<br/>";
								
								}
								else {
									
								$view .= "<input disabled='disabled' value='".$value['CAP_LAY_DAT_NAME']."' class='layan-normal-form-input' name='memperoleh' type='radio'> &nbsp;".ucwords(strtolower($value['CAP_LAY_DAT_NAME']))."<br/>";	
									
								}
								
							}
							
						$view .= "</td>";
							
					$view .= "</tr>";
					
					$view .= "<tr class='layan-normal-table-tr-hover layan-normal-table-vertical-align'>";
						
						//Cara Mendapatkan Salinan Informasi
						$view .= "<td class='layan-normal-form-td1st'>Cara Mendapatkan Salinan Informasi</td>";
						
						$view .= "<td>:</td>";                    
						
						$view .= "<td class='layan-normal-form-font12'>";
						
							foreach ($salinan as $key => $value) {
								
								if (strtoupper($data['CAP_LAY_SALINAN']) == strtoupper($value['CAP_LAY_DAT_NAME'])) {
								
								$view .= "<input checked disabled='disabled' value='".$value['CAP_LAY_DAT_NAME']."' class='layan-normal-form-input' name='salinan' type='radio'> &nbsp;".ucwords(strtolower($value['CAP_LAY_DAT_NAME']))."<br/>";
								
								}
								else {
									
								$view .= "<input disabled='disabled' value='".$value['CAP_LAY_DAT_NAME']."' class='layan-normal-form-input' name='salinan' type='radio'> &nbsp;".ucwords(strtolower($value['CAP_LAY_DAT_NAME']))."<br/>";	
									
								}
								
							}
							
						$view .= "</td>";
						
								
					
					$view .= "</tr>";
					
					//$view .= "<tr class='layan-normal-table-tr-hover'>";
						
						//Lampiran Tersedia
						//$view .= "<td class='layan-normal-form-td1st'>Lampiran Tersedia</td>";
						
						//$view .= "<td>:</td>";
						
						//$view .= "<td><select disabled='disabled' class='layan-normal-form-select' name='lampiran'><option value='1'>Ya</option><option selected='selected' value='0'>Tidak</option></select></td>";
					
					//$view .= "</tr>";
				
				$view .= "</table>";
				
				$view .= "<br/><br/>";
							
				$view .= "<table class='layan-normal-table-multiple'>";
					
					$view .= "<tr>";
						
						$view .= "<td class='layan-normal-form-bold' colspan='2'>Tanggal Tanda Terima</td>";
												
						$view .= "<td class='layan-normal-form-action-button'></td>";
											
					$view .= "</tr>";
					
					$view .= "<tr>";
												
						$view .= "<td class='layan-normal-form-bold' colspan='3'><hr class='layan-normal-form-hr'></td>";
											
					$view .= "</tr>";
					
					$view .= "<tr class='layan-normal-table-tr-hover'>";
						
						//Data Tanggal
						
						if (!empty($data['CAP_LAY_DATETANDAB'])) {
							$tanggalTandaTerima = date("d-m-Y",strtotime($data['CAP_LAY_DATETANDAB']));
						}
						else {
							$tanggalTandaTerima = '';
						}
												
						$view .= "<td colspan='3'><input disabled='disabled' class='layan-normal-form-input-date' name='tanggal-tanda-terima' type='text' value='".$tanggalTandaTerima."'></td>";
					
					$view .= "</tr>";
					
				$view .= "</table>";
				
			$view .= "<br/><br/>";
							
				$view .= "<table class='layan-normal-table-multiple'>";
					
					$view .= "<tr>";
						
						$view .= "<td class='layan-normal-form-bold' colspan='2'>Informasi Publik Yang Diminta</td>";
												
						$view .= "<td class='layan-normal-form-action-button'></td>";
											
					$view .= "</tr>";
					
					$view .= "<tr>";
												
						$view .= "<td class='layan-normal-form-bold' colspan='3'><hr class='layan-normal-form-hr'></td>";
											
					$view .= "</tr>";
					
					$view .= "<tr>";
					
						$view .= "<td class='layan-normal-form-td2st'>Action</td>";
						
						$view .= "<td class='layan-normal-form-td3st'>Nama Informasi Publik</td>";
						
						$view .= "<td class='layan-normal-form-td3st'>Alasan Penggunaan Informasi</td>";
											
					$view .= "</tr>";
					
					$view .= "<tr>";
						
						$view .= "<td class='layan-normal-form-bold' colspan='3'><hr class='layan-normal-form-hr'></td>";
											
					$view .= "</tr>";
					
					if (!empty($document)) {
					
						foreach ($document as $key => $value) {
						
							$view .= "<tr class='layan-normal-table-tr-hover'>";
							
								$view .= "<td class='layan-normal-form-td2st'><div class='layan-normal-plus-button'></div><div class='layan-normal-minus-button'></div><input type='hidden' name='idDokumen[]' value='".$value['CAP_LAY_DOC_REQ_ID']."'></td>";
								
								$view .= "<td><input disabled='disabled' class='layan-normal-form-input' name='dokumen[]' type='text' value='".$value['CAP_LAY_DOC_REQ_DOCNAME']."'></td>";
								
								$view .= "<td><input disabled='disabled' class='layan-normal-form-input' name='alasan[]' type='text' value='".$value['CAP_LAY_DOC_REQ_REASON']."'></td>";
													
							$view .= "</tr>";
						
						}
						
					}
					else {

							$view .= "<tr class='layan-normal-table-tr-hover'>";
							
								$view .= "<td class='layan-normal-form-td2st'><div class='layan-normal-plus-button'></div><div class='layan-normal-minus-button'></div><input type='hidden' name='idDokumen[]' value='".$value['CAP_LAY_DOC_REQ_ID']."'></td>";
								
								$view .= "<td><input disabled='disabled' class='layan-normal-form-input' name='dokumen[]' type='text' value='".$value['CAP_LAY_DOC_REQ_DOCNAME']."'></td>";
								
								$view .= "<td><input disabled='disabled' class='layan-normal-form-input' name='alasan[]' type='text' value='".$value['CAP_LAY_DOC_REQ_REASON']."'></td>";
													
							$view .= "</tr>";

					}
					
					$view .= "<tr>";
						
						$view .= "<td class='layan-normal-form-bold' colspan='3'><hr class='layan-normal-form-hr'></td>";
											
					$view .= "</tr>";
				
				$view .= "</table>";	
			
			$view .= "<br/>";
			
			$view .= "<div class='layan-permohonan-update-container' style='margin-left:5px; display:none;'><input type='submit' value='Update Permohonan'></div>";
			
			$view .= "<br/><br/>";
			
			$view .= "<input type='hidden' class='layan-permohonan-dokumen-delete' name='layan-permohonan-dokumen-delete'>";
			
			$view .= "</form>";
			
			$view .= "</div>";
			
			$time = new time(null);

		$creationDate = $this->getPermohonanByID($this->data);

		$permohonanDate = date("Y-m-d",strtotime($creationDate[0]['CAP_LAY_DATECREATED']));

		$holidayDate = $this->getHolidayDate($permohonanDate,date("Y-12-31"));

			if (!empty($holidayDate)) {

				foreach ($holidayDate as $value) {

					$holidayArray [] = date("Y-m-d",strtotime($value['CAP_LAY_CAL_DATE']));

				}

			}

		$endDate = $time->addDays(strtotime($permohonanDate),4,array("Saturday", "Sunday"),$holidayArray);

		$endDate = date("Y-m-d",$endDate);

		unset($holidayArray);

			if (!empty($holidayDate)) {

				foreach ($holidayDate as $value) {

					if (strtotime($value['CAP_LAY_CAL_DATE']) > strtotime($endDate)) {

						break;

					} 

					$weekDay = date('w', strtotime($value['CAP_LAY_CAL_DATE']));

					if ($weekDay != 0 && $weekDay != 6) {

						$holidayArray [] = date("Y-m-d",strtotime($value['CAP_LAY_CAL_DATE']));

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

		$date1 = new DateTime($permohonanDate);
		
		$date3 = date("Y-m-d");
		
		$date2 = new DateTime($date3);
		
		$interval = $date1->diff($date2);
				    		    
		$days = $interval->days; //$days = $days+1;

		$time = new time(null);

		$endDate = $time->addDays(strtotime($permohonanDate),3,array("Saturday", "Sunday"),$holidayArray);

		$endDate = date("Y-m-d",$endDate);

		$numberOfDays = $time->getWorkingDays($permohonanDate,$endDate,$holidayArray);

		$dateA = new DateTime($permohonanDate);
				
		$dateB = new DateTime($endDate);
		
		$intervalA = $dateA->diff($dateB);
		
		$AddHoliday = count($holidayArray);

		$maxDate = $intervalA->days;

		$maxDate = ($maxDate-$days)+$AddHoliday; $maxDate2 = $maxDate+1;

		$addDateTo = strtotime ( '+'.$maxDate+$days.' day' , strtotime ( $permohonanDate ) ) ;

		$addDateTo = date ( 'Y-m-d' , $addDateTo );
		
		$newDate = $time->addDays(strtotime($permohonanDate),3,array("Saturday", "Sunday"),$holidayArray);
		
		$_SESSION['LAYAN-PERMOHONAN-MAX-DATE'] = $endDate;

 		$view .= "

		<script type='text/javascript'>

		jQuery.noConflict()(function($){

			$(document).ready(function() {

			var IndonesianHoliday = [$IndonesianHoliday];

				$('.layan-normal-form-input-date').datepicker({ 
					dateFormat: 'dd-mm-yy',
					minDate: -".$days.", 
					maxDate: '+".$maxDate."D',
					beforeShowDay: function(date) {
			            
			            var showDay = true;
			            
			            // disable sunday and saturday
			            if (date.getDay() == 0 || date.getDay() == 6) {
			                showDay = false;
			            }
			            			            
			            // jquery in array function
			            if ($.inArray(date.getTime(), IndonesianHoliday) > -1) {
			                showDay = false;
			            }
			            
			            
			            return [showDay];
			        },
					onSelect: function(dateText, inst) { 
						$('.layan-admin_perpanjangan_create-dokumen-biaya-form-input-full').val(dateText);
						$('.layan-admin_perpanjangan_create-dokumen-biaya-form-input-full').attr('value',dateText);
					}

				});

			});

		});
		</script>

		";
			
		$view .= "
		
		<script type='text/javascript'>
		
		jQuery.noConflict()(function($){
		
		$(document).ready(function(){	
		
		$('#layan-upload').uploadify({
    	'uploader'  	: 'library/plugins/uploadifyOld/uploadify.swf',
    	'script'  		: 'library/capsule/admin/admin.ajax.php',
    	'cancelImg' 	: 'library/plugins/uploadifyOld/uploadify-cancel.png',
  		'auto'      	: false,
  		'multi'			: false,
  		'buttonText'	: 'Select Files',
  		'queueID'       : 'layan-queue',
  		'scriptData'  	: 
  			{
  			'sessionID'	: '".session_id()."',
  			'control'	: 'admin/uploadItem',
       		'incl' 	 	: 'library/capsule/admin/admin.main.php',
       		'myFolder' 	: $('.adminContentHeader').val(),
  			},
  		'onComplete'  : function(event, ID, fileObj, response, data) {
  			notificationCenter(response);
      		//alert('There are ' + data.fileCount + ' files remaining in the queue.');
   		 	}

   		});
   		
   		});
   		
   		});
   		
   		</script>
		
		";	
			
		echo $view;
		
	}

	public function user_pemberitahuan() {
		
		$this->data = base64_decode($_GET['ref']); 
		
			if (!empty($_SESSION['LAYAN-PERMOHONAN'])) {
		
				$post = $this->updatePermohonan($_SESSION['LAYAN-PERMOHONAN']);
				
				unset($_SESSION['LAYAN-PERMOHONAN']);
				
			}
		
		$data = $this->getPemberitahuanLengkap();
						
			$view  = "<div class='layan-normal-form-container'>";
						
			$view .= $this->optionGear;
			
			$view .= "<div class='layan-permohonan-upper-menu-container'>";

			$view .= "<div class='layan-permohonan-icons-container' rel='pemberitahuan'>
							<div class='layan-pemberitahuan-float-left-print-pemberitahuan qtip-upper' text='Print Pemberitahuan Tertulis'></div>
					  </div>";
			
			$view .= "</div>";

			$view .= "<form name='layan-permohonan-update' action='library/capsule/layan/process/process.php' method='post'>";
			
				$view .= "<table class='layan-normal-table'>";
					
					$view .= "<tr>";
						
						$view .= "<td colspan='3' class='layan-normal-form-bold'><hr class='layan-normal-form-hr'></td>";
											
					$view .= "</tr>";
														
				$view .= "</table>";
							
			$view .= "</form>";
			
			$view .= "<ul class='layan-admin_pemberitahuan-ul'>";
			
				if (!empty($data)) {
			
					foreach ($data as $key => $value) {
					
					$document = $this->getPemberitahuanDokumen($value['CAP_LAY_PEM_ID']);
									
					$c = count($document);
					
					if (empty($c) || empty($document[0]['CAP_LAY_PEM_DOC_ID'])) {$c = 0;}
					
					$view .= "<li><input type='checkbox' value='".$value['CAP_LAY_PEM_ID']."'> &nbsp;".$value['CAP_LAY_PEM_NUMBER']." - $c Informasi Publik";
					
						if (!empty($document)) {
							
							$view .= "<ul class='layan-admin_pemberitahuan-ul-secondary'>";

								foreach ($document as $key2 => $value2) {
								
									if (!empty($value2['CAP_LAY_PEM_DOC_ID'])) {

									$view .= "<li>- ".ucwords(strtolower($value2['CAP_LAY_DOC_REQ_DOCNAME']))."</li>";
									
									}

								}
							
							$view .= "</ul>";
							
						}

					$view .= "</li>";
					
					}
				
				}
			
			$view .= "</ul>";
			
			$view .= "</div>";
			
		echo $view;
		
	}
	
	public function admin_pemberitahuan() {
		
		$this->data = base64_decode($_GET['ref']); 
		
			if (!empty($_SESSION['LAYAN-PERMOHONAN'])) {
		
				$post = $this->updatePermohonan($_SESSION['LAYAN-PERMOHONAN']);
				
				unset($_SESSION['LAYAN-PERMOHONAN']);
				
			}
		
		$data = $this->getPemberitahuanLengkap();
		
		$ch   = $this->getDokumenLengkap();
		
		//print_r($ch);
						
			$view  = "<div class='layan-normal-form-container'>";
						
			$view .= $this->optionGear;
			
			$view .= "<div class='layan-permohonan-upper-menu-container'>";
			
				if ($ch['CAP_LAY_FINALSTATUS'] == 3 || $ch['CAP_LAY_FINALSTATUS'] == 5 || $ch['CAP_LAY_FINALSTATUS'] == 2) {
					
				$view .= "<div class='layan-permohonan-icons-container' rel='pemberitahuan'>
								<div class='layan-pemberitahuan-float-left-print-pemberitahuan qtip-upper' text='Print Pemberitahuan Tertulis'></div>
						  </div>";
					
				}
				else {
				
				$view .= "<div class='layan-permohonan-icons-container' rel='pemberitahuan'>
							<a href='index.php?id=2004&ref=".$_GET['ref']."'>
								<div class='layan-admin_pemberitahuan-float-left-add-permohonan qtip-upper' text='Create Pemberitahuan'></div>
						 	</a>
						 	<a href='index.php?id=2044&ref=".$_GET['ref']."'>
								<div class='layan-admin_pemberitahuan-float-left-edit-permohonan qtip-upper' text='Edit Pemberitahuan'></div>
							</a>
								<div class='layan-admin_pemberitahuan-float-left-print-permohonan qtip-upper' text='Delete Pemberitahuan'></div>
								<div class='layan-pemberitahuan-float-left-print-pemberitahuan qtip-upper' text='Print Pemberitahuan Tertulis'></div>
						  </div>";
						  
				}
			
			$view .= "</div>";

			$view .= "<form name='layan-permohonan-update' action='library/capsule/layan/process/process.php' method='post'>";
			
				$view .= "<table class='layan-normal-table'>";
					
					$view .= "<tr>";
						
						$view .= "<td colspan='3' class='layan-normal-form-bold'><hr class='layan-normal-form-hr'></td>";
											
					$view .= "</tr>";
														
				$view .= "</table>";
							
			$view .= "</form>";
			
			$view .= "<ul class='layan-admin_pemberitahuan-ul'>";
			
				if (!empty($data)) {
			
					foreach ($data as $key => $value) {
					
					$document = $this->getPemberitahuanDokumen($value['CAP_LAY_PEM_ID']);
									
					$c = count($document);
					
					if (empty($c) || empty($document[0]['CAP_LAY_PEM_DOC_ID'])) {$c = 0;}
					
					$view .= "<li><input type='checkbox' value='".$value['CAP_LAY_PEM_ID']."'> &nbsp;".$value['CAP_LAY_PEM_NUMBER']." - $c Informasi Publik";
					
						if (!empty($document)) {
							
							$view .= "<ul class='layan-admin_pemberitahuan-ul-secondary'>";

								foreach ($document as $key2 => $value2) {
								
									if (!empty($value2['CAP_LAY_PEM_DOC_ID'])) {
									
										if ($ch['CAP_LAY_FINALSTATUS'] == 3 || $ch['CAP_LAY_FINALSTATUS'] == 5 || $ch['CAP_LAY_FINALSTATUS'] == 2) {
									
											$actionRemove = "";
											
										}
										else {
											
											$actionRemove = "(<a class='layan-admin_pemberitahuan-delete-document-front' rel='".$value2['CAP_LAY_PEM_DOC_ID']."' href='#'>remove</a>)";
											
										}
									
									$view .= "<li>- ".ucwords(strtolower($value2['CAP_LAY_DOC_REQ_DOCNAME']))." $actionRemove</li>";
																		
									}

								}
							
							$view .= "</ul>";
							
						}

					$view .= "</li>";
					
					}
				
				}
			
			$view .= "</ul>";
			
			$view .= "</div>";
			
		echo $view;
		
	}
	
	public function admin_pemberitahuan_create() {
		
		$this->data = base64_decode($_GET['ref']); 
		
			if (!empty($_SESSION['LAYAN-PERMOHONAN'])) {

				$post = $this->createPemberitahuan($_SESSION['LAYAN-PERMOHONAN']);
				
				unset($_SESSION['LAYAN-PERMOHONAN']);
				
			}
			
			if (!empty($_SESSION['LAYAN-ERROR'])) {

				$errorAnnouncement  = "<div class='layan-error-annoucement'>";

				foreach ($_SESSION['LAYAN-ERROR'] as $key => $value) {
					
					$errorAnnouncement .= "<li>- $value</li>"; 

				}

				$errorAnnouncement .= "</div>";

				unset($_SESSION['LAYAN-ERROR']);

			}
			else {
				$errorAnnouncement = "<div class='layan-error-annoucement' style='display:none;'></div>";
			}
		
		$data = $this->getDocument($this->data);

		$tipePemohon = $this->getTipePemohon();
		
		$information = $this->getInformation();
		
		$salinan	 = $this->getSalinan();
				
		$document = $this->getDocument($this->data);

			$view  = "<div class='layan-normal-form-container'>";
						
			$view .= $this->optionGear;
						
			$view .= "<input class='layan-drill-down-menu' type='hidden' value='1974'>";
			
			$view .= "<div class='layan-permohonan-upper-menu-container'>";

			$view .= "<div class='layan-permohonan-icons-container'><a href='?id=1974&ref=".$_GET['ref']."'><div class='layan-admin_pemberitahuan_create-float-left-edit-permohonan qtip-upper' text='Back'></div></a></div>";
			
			$view .= "<div class='layan-permohonan-icons-container-right'>Create Pemberitahuan Tertulis</div>";

			$view .= "</div>";

			$view .= "<form id='layan-permintaan-create' name='layan-permintaan-create' action='library/capsule/layan/process/process.php' method='post' autocomplete='off'>";
			
				$view .= "<table class='layan-normal-table'>";
					
					$view .= "<tr>";
						
						$view .= "<td colspan='3' class='layan-normal-form-bold'><hr class='layan-normal-form-hr'></td>";
											
					$view .= "</tr>";
														
				$view .= "</table>";
				
			$view .= $errorAnnouncement;
			
			$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-container'>";
			
			$view .= "<div class='layan-admin_pemberitahuan_create-dokumen'>";
			
				$view .= "<ul style='margin:0;padding:0;'>";
				
				if (!empty($data)) {
				
				$i = 0;

					foreach ($data as $key => $value) {

						$result = $this->getStatusDokumenHistory($value['CAP_LAY_DOC_REQ_ID']);

							if ($result == 1) {

							$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input disabled name='id[$i]' type='checkbox' value='".$value['CAP_LAY_DOC_REQ_ID']."'> &nbsp; ".ucwords(strtolower($this->trimming($value['CAP_LAY_DOC_REQ_DOCNAME'],25)))." ".$this->status[$result]."</li>";
						
							}
							else if ($result == 2) {

							$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input disabled name='id[$i]' type='checkbox' value='".$value['CAP_LAY_DOC_REQ_ID']."'> &nbsp; ".ucwords(strtolower($this->trimming($value['CAP_LAY_DOC_REQ_DOCNAME'],25)))." ".$this->status[$result]."</li>";

							}

							else if ($result == 3) {

							$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='".$value['CAP_LAY_DOC_REQ_ID']."'> &nbsp; ".ucwords(strtolower($this->trimming($value['CAP_LAY_DOC_REQ_DOCNAME'],25)))." ".$this->status[$result]."</li>";

							}
							else {

							$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='".$value['CAP_LAY_DOC_REQ_ID']."'> &nbsp; ".ucwords(strtolower($this->trimming($value['CAP_LAY_DOC_REQ_DOCNAME'],25)))."</li>";

							}
					
					$i++;

					}
					
				}
				
				$view .= "</ul>";
			
			$view .= "</div>";
			
			$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab'>";
			
			if (!empty($data)) {
			
			$i = 0;

				foreach ($data as $key => $value) {

				$result = $this->getStatusDokumenHistory($value['CAP_LAY_DOC_REQ_ID']);

				if ($result == 1 || $result == 2) {
																		
						$view .= "<div document='".$value['CAP_LAY_DOC_REQ_ID']."' class='layan-admin_pemberitahuan_create-dokumen-tab-inside displayNone'>";
				
						$view .= "<input name='tinggi-dokumen[]' class='layan-original-height' type='hidden' value='0'>";
							
							$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top full-width'>";
							
								$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header'>".$value['CAP_LAY_DOC_REQ_DOCNAME']." ".$this->status[$result]."</div>";
							
								$view .= "<div>Informasi Publik ini sudah memasuki proses final. Mohon pilih informasi publik lainnya untuk diproses.</div>";
							
							$view .= "</div>";
						
						$view .= "</div>";
				
				$i++;

				continue;
				
				}
				
				$view .= "<div document='".$value['CAP_LAY_DOC_REQ_ID']."' class='layan-admin_pemberitahuan_create-dokumen-tab-inside displayNone'>";
				
				$view .= "<input class='layan-original-height' type='hidden' value='0'>";
					
					$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top full-width'>";
					
						$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header'>".$value['CAP_LAY_DOC_REQ_DOCNAME']."</div>";
						
						$view .= "<div>".$value['CAP_LAY_DOC_REQ_REASON']."</div>";
										
					$view .= "</div>";
					
					$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
					
						$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Informasi Tidak Dapat Diberikan</div>";
						
						$view .= "<div>
						<input name='belum-dikuasai[$i]' type='hidden' value=''>
						<input name='belum-dikuasai[$i]' type='checkbox' class='layan-admin_pemberitahuan_create-dokumen-tab-inside-canceled' value='1'> Informasi yang diminta belum dikuasai</div>";
						
						$view .= "<div>
						<input name='belum-didokumentasi[$i]' type='hidden' value=''>
						<input name='belum-didokumentasi[$i]' type='checkbox' class='layan-admin_pemberitahuan_create-dokumen-tab-inside-canceled' value='1'> Informasi yang diminta belum didokumentasikan</div>";
					
					$view .= "</div>";
										
					$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
					
						$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Penguasaan Informasi</div>";
						
						$view .= "<div>
						<input name='ppid[$i]' type='hidden' value=''>
						<input name='ppid[$i]' type='checkbox' value='1'> Tersedia di PPID</div>";
						
						$view .= "<div>
						<input name='badan-publik-lain[$i]' type='hidden' value=''>
						<input class='layan-admin_pemberitahuan_create-dokumen-badan-publik-lain' name='badan-publik-lain[$i]' type='checkbox' value='1'> Badan Publik Lain <input type='text' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-border-bottom'></div>";
					
					$view .= "</div>";
					
				$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-middle'>";

					$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
					
						$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Bentuk Fisik Yang Tersedia</div>";
						
						$view .= "<div>
						<input name='softcopy[$i]' type='hidden' value=''>
						<input name='softcopy[$i]' type='checkbox' value='1'> Softcopy</div>";
						
						$view .= "<div>
						<input name='hardcopy[$i]' type='hidden' value=''>
						<input name='hardcopy[$i]' type='checkbox' value='1'> Hardcopy</div>";
					
					$view .= "</div>";
								
					$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
					
						$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Biaya Yang Dibutuhkan</div>";
						
						$view .= "<table class='layan-admin_pemberitahuan_create-dokumen-biaya'>";
						
							$view .= "<tr>";
							
								$view .= "<td class='layan-admin_pemberitahuan_create-biaya-tdst'>Penyalinan</td>";
								
								$view .= "<td><input type='text' name='lembar[$i]' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-lembar' placeholder='Lembar'></td>";
								
								$view .= "<td><input type='text' name='harga[$i]' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-harga' placeholder='Harga'></td>";
							
							$view .= "</tr>";
							
							$view .= "<tr>";
							
								$view .= "<td class='layan-admin_pemberitahuan_create-biaya-tdst'>Pengiriman</td>";
																
								$view .= "<td colspan='2'><input name='pengiriman[$i]' type='text' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input' placeholder='Harga'></td>";
							
							$view .= "</tr>";
							
							$view .= "<tr>";
							
								$view .= "<td class='layan-admin_pemberitahuan_create-biaya-tdst'>Lain-Lain</td>";
																
								$view .= "<td colspan='2'><input name='harga-lain-lain[$i]' type='text' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input' placeholder='Harga'></td>";
							
							$view .= "</tr>";
							
							$view .= "<tr>";
							
								$view .= "<td class='layan-admin_pemberitahuan_create-biaya-tdst' style='font-weight:bold;'>Total</td>";
																
								$view .= "<td colspan='2' style='font-weight:bold;'><input type='text' readonly='readonly' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-total' value='0'></td>";
							
							$view .= "</tr>";
						
						$view .= "</table>";
					
					$view .= "</div>";
								
					$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
					
						$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Metode Penyampaian</div>";
						
						$view .= "<div><input name='metode-penyampaian[$i]' type='text' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-full' placeholder='Metode'></div>";
										
					$view .= "</div>";
								
					$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
					
						$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Waktu Penyampaian</div>";
											
						$view .= "<div><input name='waktu-penyampaian[$i]' type='text' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-full' placeholder='Hari'></div>";
					
					$view .= "</div>";
					
				$view .= "</div>";
				
					$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
					
						$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Nomor Dokumen Order</div>";
						
						$view .= "<div><input name='dokumen-order[$i]' type='text' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-full' placeholder='Nomor Order'></div>";


					$view .= "</div>";
					
					$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
					
						$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Notes</div>";
											
						$view .= "<div><textarea name='notes[$i]' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-textarea'></textarea></div>";
					
					$view .= "</div>";
								
				$view .= "</div>";
				
				$i++;

				}
			
			}
			
			$view .= "</div>";
			
			$view .= "</div>";
						
			$view .= "<input style='margin-left:5px; margin-top:5px;' class='layan-normal-create-pemberitahuan' type='button' value='Create Pemberitahuan Tertulis'><input style='margin-left:5px; margin-top:5px;display:none;' type='submit' value='Create Pemberitahuan Tertulis'>";
			
			$view .= "</form>";
			
			$view .= "</div>";
			
		echo $view;
		
	}

	public function admin_pemberitahuan_edit() {
		
		$this->data = base64_decode($_GET['ref']); 

		$registrar  = base64_decode($_GET['reg']); 

			if (!empty($_SESSION['LAYAN-PERMOHONAN'])) {

				$post = $this->updatePemberitahuan($_SESSION['LAYAN-PERMOHONAN']);
				
				unset($_SESSION['LAYAN-PERMOHONAN']);
				
			}
			
			if (!empty($_SESSION['LAYAN-ERROR'])) {

				$errorAnnouncement  = "<div class='layan-error-annoucement'>";

				foreach ($_SESSION['LAYAN-ERROR'] as $key => $value) {
					
					$errorAnnouncement .= "<li>- $value</li>"; 

				}

				$errorAnnouncement .= "</div>";

				unset($_SESSION['LAYAN-ERROR']);

			}
			else {
				$errorAnnouncement = "<div class='layan-error-annoucement' style='display:none;'></div>";
			}
		
		$data = $this->getDocument($this->data);
		
		$document = $this->getDocument($this->data);

		$pemberitahuan = $this->getPemberitahuanByID($registrar);

		$documentList  = $this->getPermohonanDocumentlistByID($registrar);

			$view  = "<div class='layan-normal-form-container'>";
						
			$view .= $this->optionGear;
						
			$view .= "<input class='layan-drill-down-menu' type='hidden' value='1974'>";
			
			$view .= "<div class='layan-permohonan-upper-menu-container'>";

			$view .= "<div class='layan-permohonan-icons-container'><a href='?id=1974&ref=".$_GET['ref']."'><div class='layan-admin_pemberitahuan_create-float-left-edit-permohonan qtip-upper' text='Back'></div></a></div>";
			
			$view .= "<div class='layan-permohonan-icons-container-right'>Edit Pemberitahuan Tertulis No. ".$pemberitahuan[0]['CAP_LAY_PEM_NUMBER']."</div>";

			$view .= "</div>";

			$view .= "<form id='layan-permintaan-create' name='layan-permintaan-create' action='library/capsule/layan/process/process.php' method='post' autocomplete='off'>";
			
				$view .= "<table class='layan-normal-table'>";
					
					$view .= "<tr>";
						
						$view .= "<td colspan='3' class='layan-normal-form-bold'><hr class='layan-normal-form-hr'></td>";
											
					$view .= "</tr>";
														
				$view .= "</table>";
				
			$view .= $errorAnnouncement;
			
			$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-container'>";
			
			$view .= "<div class='layan-admin_pemberitahuan_create-dokumen'>";
			
				$view .= "<ul style='margin:0;padding:0;'>";

				if (!empty($data)) {

				$i = 0;

					foreach ($data as $key => $value) {

					$result  = $this->getStatusDokumenHistory($value['CAP_LAY_DOC_REQ_ID']);

						if (is_array($documentList)) {

							if (in_array($value['CAP_LAY_DOC_REQ_ID'], $documentList)) {

								$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' checked='checked' type='checkbox' value='".$value['CAP_LAY_DOC_REQ_ID']."'> &nbsp; ".ucwords(strtolower($this->trimming($value['CAP_LAY_DOC_REQ_DOCNAME'],25)))." ".$this->status[$result]."</li>";

							}
							else {

								if ($result == 3 || $result == 0) {

								$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='".$value['CAP_LAY_DOC_REQ_ID']."'> &nbsp; ".ucwords(strtolower($this->trimming($value['CAP_LAY_DOC_REQ_DOCNAME'],25)))." ".$this->status[$result]."</li>";

								}
								else {

								$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' disabled type='checkbox' value='".$value['CAP_LAY_DOC_REQ_ID']."'> &nbsp; ".ucwords(strtolower($this->trimming($value['CAP_LAY_DOC_REQ_DOCNAME'],25)))." ".$this->status[$result]."</li>";

								}

							}

						}
						else {

							if ($result == 3 || $result == 0) {

							$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='".$value['CAP_LAY_DOC_REQ_ID']."'> &nbsp; ".ucwords(strtolower($this->trimming($value['CAP_LAY_DOC_REQ_DOCNAME'],25)))." ".$this->status[$result]."</li>";

							}
							else {

							$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' disabled type='checkbox' value='".$value['CAP_LAY_DOC_REQ_ID']."'> &nbsp; ".ucwords(strtolower($this->trimming($value['CAP_LAY_DOC_REQ_DOCNAME'],25)))." ".$this->status[$result]."</li>";

							}

						}

					$i++;

					}
					
				}
				
				$view .= "</ul>";
			
			$view .= "</div>";
			
			$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab'>";
			
			if (!empty($data)) {

			$i = 0;

				foreach ($data as $key => $value) {
				
				unset($documents); unset($total);

				$result = $this->getStatusDokumenHistory($value['CAP_LAY_DOC_REQ_ID']);

				if ($result == 1 || $result == 2) {
												
					$documents = $this->getLayanPemberitahuanDocument($value['CAP_LAY_DOC_REQ_ID']);

				}
				
				$view .= "<div document='".$value['CAP_LAY_DOC_REQ_ID']."' class='layan-admin_pemberitahuan_create-dokumen-tab-inside displayNone'>";
				
				if (empty($documents[0]['CAP_LAY_PEM_DOC_HEIGHT'])) {$height = 0;} else {$height = $documents[0]['CAP_LAY_PEM_DOC_HEIGHT'];}

				$view .= "<input class='layan-original-height' type='hidden' value='$height'>";
				
				$view .= "<input name='dokumen-id[$i]' type='hidden' value='$registrar'>";

					$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top full-width'>";
					
						$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header'>".$value['CAP_LAY_DOC_REQ_DOCNAME']." ".$this->status[$result]."</div>";
						
						$view .= "<div>".$value['CAP_LAY_DOC_REQ_REASON']."</div>";
										
					$view .= "</div>";
					
					$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
					
						$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Informasi Tidak Dapat Diberikan</div>";
						
							if (!empty($documents[0]['CAP_LAY_PEM_DOC_KUASAI'])) {

							$view .= "<div>
							<input name='belum-dikuasai[$i]' type='hidden' value=''>
							<input name='belum-dikuasai[$i]' type='checkbox' class='layan-admin_pemberitahuan_create-dokumen-tab-inside-canceled' checked='checked' value='".$documents[0]['CAP_LAY_PEM_DOC_KUASAI']."'> Informasi yang diminta belum dikuasai</div>";

							}
							else {

							$view .= "<div>
							<input name='belum-dikuasai[$i]' type='hidden' value=''>
							<input name='belum-dikuasai[$i]' type='checkbox' class='layan-admin_pemberitahuan_create-dokumen-tab-inside-canceled' value='1'> Informasi yang diminta belum dikuasai</div>";

							}
						
							if (!empty($documents[0]['CAP_LAY_PEM_DOC_DOKUMENTASI'])) {

							$view .= "<div>
							<input name='belum-didokumentasi[$i]' type='hidden' value=''>
							<input name='belum-didokumentasi[$i]' type='checkbox' class='layan-admin_pemberitahuan_create-dokumen-tab-inside-canceled' checked='checked' value='".$documents[0]['CAP_LAY_PEM_DOC_DOKUMENTASI']."'> Informasi yang diminta belum didokumentasikan</div>";
							
							}
							else {

							$view .= "<div>
							<input name='belum-didokumentasi[$i]' type='hidden' value=''>
							<input name='belum-didokumentasi[$i]' type='checkbox' class='layan-admin_pemberitahuan_create-dokumen-tab-inside-canceled' value='1'> Informasi yang diminta belum didokumentasikan</div>";

							}

					$view .= "</div>";
				
					
					
					$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
					
						$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Penguasaan Informasi</div>";
						
						if (!empty($documents[0]['CAP_LAY_PEM_DOC_PPID'])) {

						$view .= "<div>
									<input name='ppid[$i]' type='hidden' value=''>
									<input name='ppid[$i]' type='checkbox' checked='checked' value='".$documents[0]['CAP_LAY_PEM_DOC_PPID']."'> Tersedia di PPID
								  </div>";

						}
						else {

						$view .= "<div>
									<input name='ppid[$i]' type='hidden' value=''>
									<input name='ppid[$i]' type='checkbox' value='1'> Tersedia di PPID
								  </div>";

						}
						
						if (!empty($documents[0]['CAP_LAY_PEM_DOC_LAIN'])) {

						$view .= "<div>
									<input name='badan-publik-lain[$i]' type='hidden' value=''>
									<input class='layan-admin_pemberitahuan_create-dokumen-badan-publik-lain' name='badan-publik-lain[$i]' type='checkbox' checked='checked' value='".$documents[0]['CAP_LAY_PEM_DOC_LAIN']."'> Badan Publik Lain <input type='text' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-border-bottom' value='".$documents[0]['CAP_LAY_PEM_DOC_LAIN']."'>
								  </div>";
						
						}
						else {

						$view .= "<div>
									<input name='badan-publik-lain[$i]' type='hidden' value=''>
									<input class='layan-admin_pemberitahuan_create-dokumen-badan-publik-lain' name='badan-publik-lain[$i]' type='checkbox' value=''> Badan Publik Lain <input type='text' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-border-bottom'>
								  </div>";

						}

					$view .= "</div>";
					
					if (empty($documents[0]['CAP_LAY_PEM_DOC_KUASAI']) && empty($documents[0]['CAP_LAY_PEM_DOC_DOKUMENTASI'])) {

					$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-middle'>";

					}
					else {

					$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-middle layan-admin_pemberitahuan_create-activeState' style='opacity: 0; height: 0px;'>";
 
					}

					$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
					
						$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Bentuk Fisik Yang Tersedia</div>";
						
						if (!empty($documents[0]['CAP_LAY_PEM_DOC_SOFT'])) {

						$view .= "<div>
									<input name='softcopy[$i]' type='hidden' value=''>
									<input name='softcopy[$i]' type='checkbox' checked='checked' value='".$documents[0]['CAP_LAY_PEM_DOC_SOFT']."'> Softcopy
								  </div>";

						}
						else {

						$view .= "<div>
									<input name='softcopy[$i]' type='hidden' value=''>
									<input name='softcopy[$i]' type='checkbox' value='1'> Softcopy
								  </div>";

						}
						
						if (!empty($documents[0]['CAP_LAY_PEM_DOC_HARD'])) {

						$view .= "<div>
									<input name='hardcopy[$i]' type='hidden' value=''>
									<input name='hardcopy[$i]' type='checkbox' checked='checked' value='".$documents[0]['CAP_LAY_PEM_DOC_HARD']."'> Hardcopy
								  </div>";

						}
						else {

						$view .= "<div>
						<input name='hardcopy[$i]' type='hidden' value=''>
						<input name='hardcopy[$i]' type='checkbox' value='1'> Hardcopy</div>";

						}
					
					$view .= "</div>";
								
					$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
					
						$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Biaya Yang Dibutuhkan</div>";
						
						$view .= "<table class='layan-admin_pemberitahuan_create-dokumen-biaya'>";
						
							$view .= "<tr>";
							
								$view .= "<td class='layan-admin_pemberitahuan_create-biaya-tdst'>Penyalinan</td>";

								if (!empty($documents[0]['CAP_LAY_PEM_DOC_LEMBAR'])) {

								$view .= "<td><input type='text' name='lembar[$i]' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-lembar' placeholder='Lembar' value='".$documents[0]['CAP_LAY_PEM_DOC_LEMBAR']."'></td>";
								
								}
								else {

								$view .= "<td><input type='text' name='lembar[$i]' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-lembar' placeholder='Lembar'></td>";

								}

								if (!empty($documents[0]['CAP_LAY_PEM_DOC_COST'])) {

								$view .= "<td><input type='text' name='harga[$i]' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-harga' placeholder='Harga' value='".$documents[0]['CAP_LAY_PEM_DOC_COST']."'></td>";
								
								}
								else {

								$view .= "<td><input type='text' name='harga[$i]' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-harga' placeholder='Harga'></td>";

								}

							$view .= "</tr>";
							
							$view .= "<tr>";
							
								$view .= "<td class='layan-admin_pemberitahuan_create-biaya-tdst'>Pengiriman</td>";

								if (!empty($documents[0]['CAP_LAY_PEM_DOC_KIRIM'])) {

								$view .= "<td colspan='2'><input name='pengiriman[$i]' type='text' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input' placeholder='Harga' value='".$documents[0]['CAP_LAY_PEM_DOC_KIRIM']."'></td>";
								
								}
								else {

								$view .= "<td colspan='2'><input name='pengiriman[$i]' type='text' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input' placeholder='Harga'></td>";

								}

							$view .= "</tr>";
							
							$view .= "<tr>";
							
								$view .= "<td class='layan-admin_pemberitahuan_create-biaya-tdst'>Lain-Lain</td>";
								
								if (!empty($documents[0]['CAP_LAY_PEM_DOC_LAIN_LAIN'])) {

								$view .= "<td colspan='2'><input name='harga-lain-lain[$i]' type='text' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input' placeholder='Harga' value='".$documents[0]['CAP_LAY_PEM_DOC_LAIN_LAIN']."'></td>";
							
								}
								else {

								$view .= "<td colspan='2'><input name='harga-lain-lain[$i]' type='text' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input' placeholder='Harga'></td>";

								}

							$view .= "</tr>";
							
							$view .= "<tr>";
							
								$view .= "<td class='layan-admin_pemberitahuan_create-biaya-tdst' style='font-weight:bold;'>Total</td>";
								
								$total = ($documents[0]['CAP_LAY_PEM_DOC_LEMBAR']*$documents[0]['CAP_LAY_PEM_DOC_COST'])+$documents[0]['CAP_LAY_PEM_DOC_KIRIM']+$documents[0]['CAP_LAY_PEM_DOC_LAIN_LAIN'];

								$view .= "<td colspan='2' style='font-weight:bold;'><input type='text' readonly='readonly' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-total' value='".number_format($total)."'></td>";
							
							$view .= "</tr>";
						
						$view .= "</table>";
					
					$view .= "</div>";
								
					$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
					
						$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Metode Penyampaian</div>";
						
						if (!empty($documents[0]['CAP_LAY_PEM_DOC_METODE'])) {

						$view .= "<div><input name='metode-penyampaian[$i]' type='text' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-full' placeholder='Metode' value='".$documents[0]['CAP_LAY_PEM_DOC_METODE']."'></div>";
						
						}
						else {

						$view .= "<div><input name='metode-penyampaian[$i]' type='text' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-full' placeholder='Metode'></div>";

						}

					$view .= "</div>";
								
					$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
					
						$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Waktu Penyampaian</div>";
						
						if (!empty($documents[0]['CAP_LAY_PEM_DOC_WAKTU'])) {

						$view .= "<div><input name='waktu-penyampaian[$i]' type='text' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-full' placeholder='Hari' value='".$documents[0]['CAP_LAY_PEM_DOC_WAKTU']."'></div>";
					
						}
						else {

						$view .= "<div><input name='waktu-penyampaian[$i]' type='text' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-full' placeholder='Hari'></div>";

						}

					$view .= "</div>";
					
				$view .= "</div>";
					
					$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
					
						$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Nomor Dokumen Order</div>";
						
						if (!empty($documents[0]['FK_CAP_LAY_LIB_ID'])) {
							
						$view .= "<div><input name='dokumen-order[$i]' type='text' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-full' placeholder='Nomor Order' value='".$documents[0]['FK_CAP_LAY_LIB_ID']."'></div>";
					
						}
						else {

						$view .= "<div><input name='dokumen-order[$i]' type='text' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-full' placeholder='Nomor Order'></div>";

						}

					$view .= "</div>";
					
					$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
					
						$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Notes</div>";
											
						$view .= "<div><textarea name='notes[$i]' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-textarea'>".$documents[0]['CAP_LAY_PEM_DOC_NOTES']."</textarea></div>";
					
					$view .= "</div>";
								
				$view .= "</div>";
				
				$i++;

				}
			
			}
			
			$view .= "</div>";
			
			$view .= "</div>";
						
			$view .= "<input style='margin-left:5px; margin-top:5px;' class='layan-normal-create-pemberitahuan' type='button' value='Update Pemberitahuan Tertulis'><input style='margin-left:5px; margin-top:5px;display:none;' type='submit' value='Update Pemberitahuan Tertulis'>";
			
			$view .= "</form>";
			
			$view .= "</div>";
			
		echo $view;
		
	}

	public function user_perpanjangan() {
		
		$this->data = base64_decode($_GET['ref']); 
		
			if (!empty($_SESSION['LAYAN-PERMOHONAN'])) {
		
				$post = $this->updatePermohonan($_SESSION['LAYAN-PERMOHONAN']);
				
				unset($_SESSION['LAYAN-PERMOHONAN']);
				
			}
		
		$data = $this->getPerpanjanganLengkap();
						
			$view  = "<div class='layan-normal-form-container'>";
						
			$view .= $this->optionGear;
			
			$view .= "<div class='layan-permohonan-upper-menu-container'>";

			$view .= "<div class='layan-permohonan-icons-container' rel='perpanjangan'>
							<div class='layan-admin_perpanjangan-float-left-print-perpanjangan qtip-upper' text='Print Perpanjangan'></div>
					  </div>";
			
			$view .= "</div>";

			$view .= "<form name='layan-permohonan-update' action='library/capsule/layan/process/process.php' method='post'>";
			
				$view .= "<table class='layan-normal-table'>";
					
					$view .= "<tr>";
						
						$view .= "<td colspan='3' class='layan-normal-form-bold'><hr class='layan-normal-form-hr'></td>";
											
					$view .= "</tr>";
														
				$view .= "</table>";
							
			$view .= "</form>";
			
			$view .= "<ul class='layan-admin_pemberitahuan-ul'>";

				if (!empty($data)) {
			
					foreach ($data as $key => $value) {
					
					$document = $this->getPerpanjanganDokumen($value['CAP_LAY_PER_ID']);
									
					$c = count($document);

					if (empty($c) || empty($document[0]['CAP_LAY_PER_DOC_ID'])) {$c = 0;}
					
					$view .= "<li><input type='checkbox' value='".$value['CAP_LAY_PER_ID']."'> &nbsp;".$value['CAP_LAY_PER_NUMBER']." - $c Informasi Publik";
					
						if (!empty($document)) {
							
							$view .= "<ul class='layan-admin_pemberitahuan-ul-secondary'>";
							
								foreach ($document as $key2 => $value2) {
								
									if (!empty($value2['CAP_LAY_PER_DOC_ID'])) {

									$view .= "<li>- ".ucwords(strtolower($value2['CAP_LAY_DOC_REQ_DOCNAME']))."</li>";
									
									}

								}
							
							$view .= "</ul>";
							
						}

					$view .= "</li>";
					
					}
				
				}
			
			$view .= "</ul>";
			
			$view .= "</div>";
			
		echo $view;
		
	}

	public function admin_perpanjangan() {
		
		$this->data = base64_decode($_GET['ref']); 
		
			if (!empty($_SESSION['LAYAN-PERMOHONAN'])) {
		
				$post = $this->updatePermohonan($_SESSION['LAYAN-PERMOHONAN']);
				
				unset($_SESSION['LAYAN-PERMOHONAN']);
				
			}
		
		$data = $this->getPerpanjanganLengkap();
		
		$ch   = $this->getDokumenLengkap();
								
			$view  = "<div class='layan-normal-form-container'>";
						
			$view .= $this->optionGear;
			
			$view .= "<div class='layan-permohonan-upper-menu-container'>";
			
				if ($ch['CAP_LAY_FINALSTATUS'] == 3 || $ch['CAP_LAY_FINALSTATUS'] == 5 || $ch['CAP_LAY_FINALSTATUS'] == 2) {

				$view .= "<div class='layan-permohonan-icons-container' rel='perpanjangan'>
								<div class='layan-admin_perpanjangan-float-left-print-perpanjangan qtip-upper' text='Print Perpanjangan'></div>
						  </div>";
						  
				}
				else {
					
				$view .= "<div class='layan-permohonan-icons-container' rel='perpanjangan'>
							<a href='index.php?id=2045&ref=".$_GET['ref']."'>
								<div class='layan-admin_pemberitahuan-float-left-add-permohonan qtip-upper' text='Create Perpanjangan'></div>
						 	</a>
						 	<a href='index.php?id=2046&ref=".$_GET['ref']."'>
								<div class='layan-admin_pemberitahuan-float-left-edit-permohonan qtip-upper' text='Edit Perpanjangan'></div>
							</a>
								<div class='layan-admin_pemberitahuan-float-left-print-permohonan qtip-upper' text='Delete Perpanjangan'></div>
								<div class='layan-admin_perpanjangan-float-left-print-perpanjangan qtip-upper' text='Print Perpanjangan'></div>
						  </div>";
					
				}
			
			$view .= "</div>";

			$view .= "<form name='layan-permohonan-update' action='library/capsule/layan/process/process.php' method='post'>";
			
				$view .= "<table class='layan-normal-table'>";
					
					$view .= "<tr>";
						
						$view .= "<td colspan='3' class='layan-normal-form-bold'><hr class='layan-normal-form-hr'></td>";
											
					$view .= "</tr>";
														
				$view .= "</table>";
							
			$view .= "</form>";
			
			$view .= "<ul class='layan-admin_pemberitahuan-ul'>";

				if (!empty($data)) {
			
					foreach ($data as $key => $value) {
					
					$document = $this->getPerpanjanganDokumen($value['CAP_LAY_PER_ID']);
									
					$c = count($document);

					if (empty($c) || empty($document[0]['CAP_LAY_PER_DOC_ID'])) {$c = 0;}
					
					$view .= "<li><input type='checkbox' value='".$value['CAP_LAY_PER_ID']."'> &nbsp;".$value['CAP_LAY_PER_NUMBER']." - $c Informasi Publik";
					
						if (!empty($document)) {
							
							$view .= "<ul class='layan-admin_pemberitahuan-ul-secondary'>";
							
								foreach ($document as $key2 => $value2) {
								
									if (!empty($value2['CAP_LAY_PER_DOC_ID'])) {
										
										if ($ch['CAP_LAY_FINALSTATUS'] == 3 || $ch['CAP_LAY_FINALSTATUS'] == 5 || $ch['CAP_LAY_FINALSTATUS'] == 2) {
									
											$actionRemove = "";
											
										}
										else {
											
											$actionRemove = "(<a class='layan-admin_perpanjangan-delete-document-front' rel='".$value2['CAP_LAY_PER_DOC_ID']."' href='#'>remove</a>)";
											
										}
										
									$view .= "<li>- ".ucwords(strtolower($value2['CAP_LAY_DOC_REQ_DOCNAME']))." $actionRemove</li>";
									
									}

								}
							
							$view .= "</ul>";
							
						}

					$view .= "</li>";
					
					}
				
				}
			
			$view .= "</ul>";
			
			$view .= "</div>";
			
		echo $view;
		
	}

	public function admin_perpanjangan_create() {
		
		$this->data = base64_decode($_GET['ref']); 
		
			if (!empty($_SESSION['LAYAN-PERMOHONAN'])) {
		
				$post = $this->createPerpanjangan($_SESSION['LAYAN-PERMOHONAN']);

				unset($_SESSION['LAYAN-PERMOHONAN']);
				
			}

			if (!empty($_SESSION['LAYAN-ERROR'])) {

				$errorAnnouncement  = "<div class='layan-error-annoucement'>";

				foreach ($_SESSION['LAYAN-ERROR'] as $key => $value) {
					
					$errorAnnouncement .= "<li>- $value</li>"; 

				}

				$errorAnnouncement .= "</div>";

				unset($_SESSION['LAYAN-ERROR']);

			}
		
		$data = $this->getDocument($this->data);

		$tipePemohon = $this->getTipePemohon();
		
		$information = $this->getInformation();
		
		$salinan	 = $this->getSalinan();
				
		$document = $this->getDocument($this->data);

			$view  = "<div class='layan-normal-form-container'>";
						
			$view .= $this->optionGear;
						
			$view .= "<input class='layan-drill-down-menu' type='hidden' value='1976'>";
			
			$view .= "<div class='layan-permohonan-upper-menu-container'>";

			$view .= "<div class='layan-permohonan-icons-container'><a href='?id=1976&ref=".$_GET['ref']."'><div class='layan-admin_pemberitahuan_create-float-left-edit-permohonan qtip-upper' text='Back'></div></a></div>";
			
			$view .= "<div class='layan-permohonan-icons-container-right'>Create Perpanjangan</div>";

			$view .= "</div>";

			$view .= "<form id='layan-permintaan-create' name='layan-permintaan-create' action='library/capsule/layan/process/process.php' method='post' autocomplete='off'>";
			
				$view .= "<table class='layan-normal-table'>";
					
					$view .= "<tr>";
						
						$view .= "<td colspan='3' class='layan-normal-form-bold'><hr class='layan-normal-form-hr'></td>";
											
					$view .= "</tr>";
														
				$view .= "</table>";
			
			$view .= $errorAnnouncement;

			$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-container'>";
			
			$view .= "<div class='layan-admin_pemberitahuan_create-dokumen'>";
			
				$view .= "<ul style='margin:0;padding:0;'>";
				
				if (!empty($data)) {
								
					foreach ($data as $key => $value) {

						if ($value['FK_CAP_LAY_DOC_REQ_ID'] == 1 || $value['FK_CAP_LAY_DOC_REQ_ID'] == 2 || $value['FK_CAP_LAY_DOC_REQ_ID'] == 3) {

						$result = $this->getStatusDokumenHistory($value['CAP_LAY_DOC_REQ_ID']);

							if ($result == 1) {

							$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[]' type='checkbox' value='".$value['CAP_LAY_DOC_REQ_ID']."'> &nbsp; ".ucwords(strtolower($this->trimming($value['CAP_LAY_DOC_REQ_DOCNAME'],25)))." (Pemberitahuan)</li>";
						
							}
							else if ($result == 2) {

							$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[]' type='checkbox' value='".$value['CAP_LAY_DOC_REQ_ID']."'> &nbsp; ".ucwords(strtolower($this->trimming($value['CAP_LAY_DOC_REQ_DOCNAME'],25)))." (Penolakan)</li>";

							}

							else if ($result == 3) {

							$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[]' type='checkbox' value='".$value['CAP_LAY_DOC_REQ_ID']."'> &nbsp; ".ucwords(strtolower($this->trimming($value['CAP_LAY_DOC_REQ_DOCNAME'],25)))." (Perpanjangan)</li>";

							}
							else {

							$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[]' type='checkbox' value='".$value['CAP_LAY_DOC_REQ_ID']."'> &nbsp; ".ucwords(strtolower($this->trimming($value['CAP_LAY_DOC_REQ_DOCNAME'],25)))."</li>";

							}

						}
						else {
						
						$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[]' type='checkbox' value='".$value['CAP_LAY_DOC_REQ_ID']."'> &nbsp; ".ucwords(strtolower($this->trimming($value['CAP_LAY_DOC_REQ_DOCNAME'],25)))."</li>";
						
						}
						
					}
					
				}
				
				$view .= "</ul>";
			
			$view .= "</div>";
			
			$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab'>";
			
			if (!empty($data)) {
			
				foreach ($data as $key => $value) {

				$result = $this->getStatusDokumenHistory($value['CAP_LAY_DOC_REQ_ID']);
				
				$view .= "<div document='".$value['CAP_LAY_DOC_REQ_ID']."' class='layan-admin_pemberitahuan_create-dokumen-tab-inside displayNone'>";
				
				$view .= "<input class='layan-original-height' type='hidden' value='0'>";
					
					$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top full-width'>";
					
						$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header'>".$value['CAP_LAY_DOC_REQ_DOCNAME']."</div>";
						
						$view .= "<div>".$value['CAP_LAY_DOC_REQ_REASON']."</div>";
										
					$view .= "</div>";
					
					$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
					
						$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Tanggal Perpanjangan Hingga</div>";
						
						$view .= "<div><input name='tanggal-perpanjangan' type='text' class='layan-admin_perpanjangan_create-dokumen-biaya-form-input-full' placeholder='Tanggal'></div>";
										
					$view .= "</div>";

					$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
					
						$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Notes</div>";
											
						$view .= "<div><textarea name='notes[]' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-textarea'></textarea></div>";
					
					$view .= "</div>";
								
				$view .= "</div>";
				
				}
			
			}
			
			$view .= "</div>";
			
			$view .= "</div>";
						
			$view .= "<input style='margin-left:5px; margin-top:5px;' class='layan-normal-create-perpanjangan' type='submit' value='Create Perpanjangan'>";
			
			$view .= "</form>";
			
			$view .= "</div>";
		
		$time = new time(null);

		$creationDate = $this->getPermohonanByID($this->data);

		$permohonanDate = date("Y-m-d",strtotime($creationDate[0]['CAP_LAY_DATECREATED']));

		$holidayDate = $this->getHolidayDate($permohonanDate,date("Y-12-31"));

			if (!empty($holidayDate)) {

				foreach ($holidayDate as $value) {

					$holidayArray [] = date("Y-m-d",strtotime($value['CAP_LAY_CAL_DATE']));

				}

			}

		$endDate = $time->addDays(strtotime($permohonanDate),18,array("Saturday", "Sunday"),$holidayArray);

		$endDate = date("Y-m-d",$endDate);

		unset($holidayArray);

			if (!empty($holidayDate)) {

				foreach ($holidayDate as $value) {

					if (strtotime($value['CAP_LAY_CAL_DATE']) > strtotime($endDate)) {

						break;

					} 

					$weekDay = date('w', strtotime($value['CAP_LAY_CAL_DATE']));

					if ($weekDay != 0 && $weekDay != 6) {

						$holidayArray [] = date("Y-m-d",strtotime($value['CAP_LAY_CAL_DATE']));

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

		$date1 = new DateTime($permohonanDate);
		
		$date3 = date("Y-m-d");
		
		$date2 = new DateTime($date3);
		
		$interval = $date1->diff($date2);
				    		    
		$days = $interval->days;

		$time = new time(null);

		$endDate = $time->addDays(strtotime($permohonanDate),17,array("Saturday", "Sunday"),$holidayArray);

		$endDate = date("Y-m-d",$endDate);

		$numberOfDays = $time->getWorkingDays($permohonanDate,$endDate,$holidayArray);

		$dateA = new DateTime($permohonanDate);
				
		$dateB = new DateTime($endDate);
		
		$intervalA = $dateA->diff($dateB);
		
		$AddHoliday = count($holidayArray);

		$maxDate = $intervalA->days;

		$maxDate = ($maxDate-$days)+$AddHoliday; $maxDate2 = $maxDate+1;

		$addDateTo = strtotime ( '+'.$maxDate+$days.' day' , strtotime ( $permohonanDate ) ) ;

		$addDateTo = date ( 'Y-m-d' , $addDateTo );

 		$view .= "

		<script type='text/javascript'>

		jQuery.noConflict()(function($){

			$(document).ready(function() {

			var IndonesianHoliday = [$IndonesianHoliday];

				$('.layan-admin_perpanjangan_create-dokumen-biaya-form-input-full').datepicker({ 
					dateFormat: 'dd-mm-yy',
					minDate: -".$days.", 
					maxDate: '+".$maxDate."D',
					beforeShowDay: function(date) {
			            
			            var showDay = true;
			            
			            // disable sunday and saturday
			            if (date.getDay() == 0 || date.getDay() == 6) {
			                showDay = false;
			            }
			            			            
			            // jquery in array function
			            if ($.inArray(date.getTime(), IndonesianHoliday) > -1) {
			                showDay = false;
			            }
			            
			            
			            return [showDay];
			        },
					onSelect: function(dateText, inst) { 
						$('.layan-admin_perpanjangan_create-dokumen-biaya-form-input-full').val(dateText);
						$('.layan-admin_perpanjangan_create-dokumen-biaya-form-input-full').attr('value',dateText);
					}

				});

			});

		});
		</script>

		";

		echo $view;
		
	}

	public function admin_perpanjangan_edit() {
		
		$this->data = base64_decode($_GET['ref']); 

		$registrar  = base64_decode($_GET['reg']);

			if (!empty($_SESSION['LAYAN-PERMOHONAN'])) {

				$post = $this->updatePerpanjangan($_SESSION['LAYAN-PERMOHONAN']);

				unset($_SESSION['LAYAN-PERMOHONAN']);
				
			}

			if (!empty($_SESSION['LAYAN-ERROR'])) {

				$errorAnnouncement  = "<div class='layan-error-annoucement'>";

				foreach ($_SESSION['LAYAN-ERROR'] as $key => $value) {
					
					$errorAnnouncement .= "<li>- $value</li>"; 

				}

				$errorAnnouncement .= "</div>";

				unset($_SESSION['LAYAN-ERROR']);

			}
		
		$data = $this->getDocument($this->data);
		
		$document = $this->getDocument($this->data);

		$perpanjangan = $this->getPerpanjanganByID($registrar);

		$documentList  = $this->getPerpanjanganDocumentlistByID($registrar);

			$view  = "<div class='layan-normal-form-container'>";
						
			$view .= $this->optionGear;
						
			$view .= "<input class='layan-drill-down-menu' type='hidden' value='1976'>";
			
			$view .= "<div class='layan-permohonan-upper-menu-container'>";

			$view .= "<div class='layan-permohonan-icons-container'><a href='?id=1976&ref=".$_GET['ref']."'><div class='layan-admin_pemberitahuan_create-float-left-edit-permohonan qtip-upper' text='Back'></div></a></div>";
			
			$view .= "<div class='layan-permohonan-icons-container-right'>Edit Perpanjangan No. ".$perpanjangan[0]['CAP_LAY_PER_NUMBER']."</div>";

			$view .= "</div>";

			$view .= "<form id='layan-permintaan-create' name='layan-permintaan-create' action='library/capsule/layan/process/process.php' method='post' autocomplete='off'>";
			
				$view .= "<table class='layan-normal-table'>";
					
					$view .= "<tr>";
						
						$view .= "<td colspan='3' class='layan-normal-form-bold'><hr class='layan-normal-form-hr'></td>";
											
					$view .= "</tr>";
														
				$view .= "</table>";
			
			$view .= $errorAnnouncement;

			$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-container'>";
			
			$view .= "<div class='layan-admin_pemberitahuan_create-dokumen'>";
			
				$view .= "<ul style='margin:0;padding:0;'>";
				
				if (!empty($data)) {

					foreach ($data as $key => $value) {
						
					$result  = $this->getStatusDokumenHistory($value['CAP_LAY_DOC_REQ_ID']);

						if (is_array($documentList)) {

							if (in_array($value['CAP_LAY_DOC_REQ_ID'], $documentList)) {

								$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' checked='checked' type='checkbox' value='".$value['CAP_LAY_DOC_REQ_ID']."'> &nbsp; ".ucwords(strtolower($this->trimming($value['CAP_LAY_DOC_REQ_DOCNAME'],25)))." ".$this->status[$result]."</li>";

							}
							else {

								if ($result == 3 || $result == 0) {

								$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='".$value['CAP_LAY_DOC_REQ_ID']."'> &nbsp; ".ucwords(strtolower($this->trimming($value['CAP_LAY_DOC_REQ_DOCNAME'],25)))." ".$this->status[$result]."</li>";

								}
								else {

								$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='".$value['CAP_LAY_DOC_REQ_ID']."'> &nbsp; ".ucwords(strtolower($this->trimming($value['CAP_LAY_DOC_REQ_DOCNAME'],25)))." ".$this->status[$result]."</li>";

								}

							}

						}
						else {

							if ($result == 3 || $result == 0) {

							$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='".$value['CAP_LAY_DOC_REQ_ID']."'> &nbsp; ".ucwords(strtolower($this->trimming($value['CAP_LAY_DOC_REQ_DOCNAME'],25)))." ".$this->status[$result]."</li>";

							}
							else {

							$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='".$value['CAP_LAY_DOC_REQ_ID']."'> &nbsp; ".ucwords(strtolower($this->trimming($value['CAP_LAY_DOC_REQ_DOCNAME'],25)))." ".$this->status[$result]."</li>";

							}

						}
						
					}
					
				}
				
				$view .= "</ul>";
			
			$view .= "</div>";
			
			$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab'>";
			
			if (!empty($data)) {

				foreach ($data as $key => $value) {

				unset($documents);

				$result = $this->getStatusDokumenHistory($value['CAP_LAY_DOC_REQ_ID']);
				
				$documents = $this->getLayanPerpanjanganDocument($value['CAP_LAY_DOC_REQ_ID'],$registrar);
				
				/*
				if ($result == 1 || $result == 2) {
												
					$documents = $this->getLayanPerpanjanganDocument($value['CAP_LAY_DOC_REQ_ID'],$registrar);
					
				}
				*/

				$view .= "<div document='".$value['CAP_LAY_DOC_REQ_ID']."' class='layan-admin_pemberitahuan_create-dokumen-tab-inside displayNone'>";
				
				$view .= "<input class='layan-original-height' type='hidden' value='0'>";

				$view .= "<input name='dokumen-id[]' type='hidden' value='$registrar'>";
					
					$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top full-width'>";
					
						$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header'>".$value['CAP_LAY_DOC_REQ_DOCNAME']."</div>";
						
						$view .= "<div>".$value['CAP_LAY_DOC_REQ_REASON']."</div>";
										
					$view .= "</div>";
					
					$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
					
						$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Tanggal Perpanjangan Hingga</div>";
							
						$view .= "<div><input name='tanggal-perpanjangan' type='text' class='layan-admin_perpanjangan_create-dokumen-biaya-form-input-full' placeholder='Tanggal' value='".date("d-m-Y",strtotime($perpanjangan[0]['CAP_LAY_PER_DATE_TO']))."'></div>";

					$view .= "</div>";

					$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
					
						$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Notes</div>";
											
						$view .= "<div><textarea name='notes[]' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-textarea'>".$documents[0]['CAP_LAY_PER_DOC_NOTES']."</textarea></div>";
					
					$view .= "</div>";
								
				$view .= "</div>";
				
				}
			
			}
			
			$view .= "</div>";
			
			$view .= "</div>";
						
			$view .= "<input style='margin-left:5px; margin-top:5px;' class='layan-normal-create-perpanjangan' type='submit' value='Update Perpanjangan'>";
			
			$view .= "</form>";
			
			$view .= "</div>";
		
		$creationDate = $this->getPermohonanByID($this->data);

		$permohonanDate = date("Y-m-d",strtotime($creationDate[0]['CAP_LAY_DATECREATED']));

		$holidayDate = $this->getHolidayDate($permohonanDate,date("Y-12-31"));

		$endDate = $this->getEndDatePermohonan($permohonanDate,$holidayDate);

		$holidayArray = $this->getHolidayArrayNoWeekdays($holidayDate,$endDate);

		$IndonesianHoliday = $this->getIndonesianHolidayDatePicker($holidayDate,$endDate);

		$date1 = new DateTime($permohonanDate);
		
		$date3 = date("Y-m-d");
		
		$date2 = new DateTime($date3);
		
		$interval = $date1->diff($date2);
				    		    
		$days = $interval->days; 

		$maxDate = $this->getMaxDatePicker($permohonanDate,$holidayArray,$endDate,$days);

		$maxRealDate = $this->getMaxDatePickerDate($permohonanDate,$maxDate,$days);

		$view .= "

		<script type='text/javascript'>

		jQuery.noConflict()(function($){

			$(document).ready(function() {

			var IndonesianHoliday = [$IndonesianHoliday];

				$('.layan-admin_perpanjangan_create-dokumen-biaya-form-input-full').datepicker({ 
					dateFormat: 'dd-mm-yy',
					minDate: -".$days.", 
					maxDate: '+".$maxDate."D',
					beforeShowDay: function(date) {
			            
			            var showDay = true;
			            
			            // disable sunday and saturday
			            if (date.getDay() == 0 || date.getDay() == 6) {
			                showDay = false;
			            }
			            			            
			            // jquery in array function
			            if ($.inArray(date.getTime(), IndonesianHoliday) > -1) {
			                showDay = false;
			            }
			            
			            
			            return [showDay];
			        },
					onSelect: function(dateText, inst) { 
						$('.layan-admin_perpanjangan_create-dokumen-biaya-form-input-full').val(dateText);
						$('.layan-admin_perpanjangan_create-dokumen-biaya-form-input-full').attr('value',dateText);
					}

				});

			});

		});
		</script>

		";

		echo $view;
		
	}

	public function user_penolakan() {
		
		$this->data = base64_decode($_GET['ref']); 
		
			if (!empty($_SESSION['LAYAN-PERMOHONAN'])) {
		
				$post = $this->updatePenolakan($_SESSION['LAYAN-PERMOHONAN']);
				
				unset($_SESSION['LAYAN-PERMOHONAN']);
				
			}
		
		$data = $this->getPenolakanLengkap();
						
			$view  = "<div class='layan-normal-form-container'>";
						
			$view .= $this->optionGear;
			
			$view .= "<div class='layan-permohonan-upper-menu-container'>";

			$view .= "<div class='layan-permohonan-icons-container' rel='penolakan'>
							<div class='layan-penolakan-float-left-print-penolakan qtip-upper' text='Print Penolakan'></div>
					  </div>";
			
			$view .= "</div>";

			$view .= "<form name='layan-permohonan-update' action='library/capsule/layan/process/process.php' method='post'>";
			
				$view .= "<table class='layan-normal-table'>";
					
					$view .= "<tr>";
						
						$view .= "<td colspan='3' class='layan-normal-form-bold'><hr class='layan-normal-form-hr'></td>";
											
					$view .= "</tr>";
														
				$view .= "</table>";
							
			$view .= "</form>";
			
			$view .= "<ul class='layan-admin_pemberitahuan-ul'>";

				if (!empty($data)) {
			
					foreach ($data as $key => $value) {
					
					$document = $this->getPenolakanDokumen($value['CAP_LAY_PEN_ID']);
									
					$c = count($document);

					if (empty($c) || empty($document[0]['CAP_LAY_PEN_DOC_ID'])) {$c = 0;}
					
					$view .= "<li><input type='checkbox' value='".$value['CAP_LAY_PEN_ID']."'> &nbsp;".$value['CAP_LAY_PEN_NUMBER']." - $c Informasi Publik";

						if (!empty($document)) {
							
							$view .= "<ul class='layan-admin_pemberitahuan-ul-secondary'>";
							
								foreach ($document as $key2 => $value2) {
								
									if (!empty($value2['CAP_LAY_PEN_DOC_ID'])) {

									$view .= "<li>- ".ucwords(strtolower($value2['CAP_LAY_DOC_REQ_DOCNAME']))."</li>";
								
									}

								}
							
							$view .= "</ul>";
							
						}

					$view .= "</li>";
					
					}
				
				}
			
			$view .= "</ul>";
			
			$view .= "</div>";
			
		echo $view;
		
	}

	public function admin_penolakan() {
		
		$this->data = base64_decode($_GET['ref']); 
		
			if (!empty($_SESSION['LAYAN-PERMOHONAN'])) {
		
				$post = $this->updatePenolakan($_SESSION['LAYAN-PERMOHONAN']);
				
				unset($_SESSION['LAYAN-PERMOHONAN']);
				
			}
					
		$data = $this->getPenolakanLengkap();
		
		$ch   = $this->getDokumenLengkap();
								
			$view  = "<div class='layan-normal-form-container'>";
						
			$view .= $this->optionGear;
			
			$view .= "<div class='layan-permohonan-upper-menu-container'>";
			
				if ($ch['CAP_LAY_FINALSTATUS'] == 3 || $ch['CAP_LAY_FINALSTATUS'] == 5 || $ch['CAP_LAY_FINALSTATUS'] == 2) {

				$view .= "<div class='layan-permohonan-icons-container' rel='penolakan'>
								<div class='layan-penolakan-float-left-print-penolakan qtip-upper' text='Print Penolakan'></div>
						  </div>";
						  
				}
				else {
					
				$view .= "<div class='layan-permohonan-icons-container' rel='penolakan'>
							<a href='index.php?id=2064&ref=".$_GET['ref']."'>
								<div class='layan-admin_pemberitahuan-float-left-add-permohonan qtip-upper' text='Create Penolakan'></div>
						 	</a>
						 	<a href='index.php?id=2065&ref=".$_GET['ref']."'>
								<div class='layan-admin_pemberitahuan-float-left-edit-permohonan qtip-upper' text='Edit Penolakan'></div>
							</a>
								<div class='layan-admin_pemberitahuan-float-left-print-permohonan qtip-upper' text='Delete Penolakan'></div>
								<div class='layan-penolakan-float-left-print-penolakan qtip-upper' text='Print Penolakan'></div>
						  </div>";
					
				}
			
			$view .= "</div>";

			$view .= "<form name='layan-permohonan-update' action='library/capsule/layan/process/process.php' method='post'>";
			
				$view .= "<table class='layan-normal-table'>";
					
					$view .= "<tr>";
						
						$view .= "<td colspan='3' class='layan-normal-form-bold'><hr class='layan-normal-form-hr'></td>";
											
					$view .= "</tr>";
														
				$view .= "</table>";
											
			$view .= "</form>";
			
			$view .= "<ul class='layan-admin_pemberitahuan-ul'>";

				if (!empty($data)) {
			
					foreach ($data as $key => $value) {
					
					$document = $this->getPenolakanDokumen($value['CAP_LAY_PEN_ID']);
									
					$c = count($document);

					if (empty($c) || empty($document[0]['CAP_LAY_PEN_DOC_ID'])) {$c = 0;}
					
					$view .= "<li><input type='checkbox' value='".$value['CAP_LAY_PEN_ID']."'> &nbsp;".$value['CAP_LAY_PEN_NUMBER']." - $c Informasi Publik";

						if (!empty($document)) {
							
							$view .= "<ul class='layan-admin_pemberitahuan-ul-secondary'>";
							
								foreach ($document as $key2 => $value2) {
								
									if (!empty($value2['CAP_LAY_PEN_DOC_ID'])) {
										
										if ($ch['CAP_LAY_FINALSTATUS'] == 3 || $ch['CAP_LAY_FINALSTATUS'] == 5 || $ch['CAP_LAY_FINALSTATUS'] == 2) {
									
											$actionRemove = "";
											
										}
										else {
											
											$actionRemove = "(<a class='layan-admin_penolakan-delete-document-front' rel='".$value2['CAP_LAY_PEN_DOC_ID']."' href='#'>remove</a>)";
											
										}
										
									$view .= "<li>- ".ucwords(strtolower($value2['CAP_LAY_DOC_REQ_DOCNAME']))." $actionRemove</li>";
								
									}

								}
							
							$view .= "</ul>";
							
						}

					$view .= "</li>";
					
					}
				
				}
			
			$view .= "</ul>";
			
			$view .= "</div>";
			
		echo $view;
		
	}

	public function admin_penolakan_create() {
		
		$this->data = base64_decode($_GET['ref']); 
		
			if (!empty($_SESSION['LAYAN-PERMOHONAN'])) {
		
				$post = $this->createPenolakan($_SESSION['LAYAN-PERMOHONAN']);

				unset($_SESSION['LAYAN-PERMOHONAN']);
				
			}
			
			if (!empty($_SESSION['LAYAN-ERROR'])) {

				$errorAnnouncement  = "<div class='layan-error-annoucement'>";

				foreach ($_SESSION['LAYAN-ERROR'] as $key => $value) {
					
					$errorAnnouncement .= "<li>- $value</li>"; 

				}

				$errorAnnouncement .= "</div>";

				unset($_SESSION['LAYAN-ERROR']);

			}
		
		$data = $this->getDocument($this->data);

		$tipePemohon = $this->getTipePemohon();
		
		$information = $this->getInformation();
		
		$salinan	 = $this->getSalinan();
				
		$document = $this->getDocument($this->data);

			$view  = "<div class='layan-normal-form-container'>";
						
			$view .= $this->optionGear;
						
			$view .= "<input class='layan-drill-down-menu' type='hidden' value='1975'>";
			
			$view .= "<div class='layan-permohonan-upper-menu-container'>";

			$view .= "<div class='layan-permohonan-icons-container'><a href='?id=1975&ref=".$_GET['ref']."'><div class='layan-admin_pemberitahuan_create-float-left-edit-permohonan qtip-upper' text='Back'></div></a></div>";
			
			$view .= "<div class='layan-permohonan-icons-container-right'>Create Penolakan</div>";

			$view .= "</div>";

			$view .= "<form id='layan-permintaan-create' name='layan-permintaan-create' action='library/capsule/layan/process/process.php' method='post' autocomplete='off'>";
			
				$view .= "<table class='layan-normal-table'>";
					
					$view .= "<tr>";
						
						$view .= "<td colspan='3' class='layan-normal-form-bold'><hr class='layan-normal-form-hr'></td>";
											
					$view .= "</tr>";
														
				$view .= "</table>";
				
			$view .= $errorAnnouncement;
			
			$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-container'>";
			
			$view .= "<div class='layan-admin_pemberitahuan_create-dokumen'>";
			
				$view .= "<ul style='margin:0;padding:0;'>";
				
				if (!empty($data)) {

				$i = 0;

					foreach ($data as $key => $value) {

						$result = $this->getStatusDokumenHistory($value['CAP_LAY_DOC_REQ_ID']);

							if ($result == 1) {

							$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input disabled name='id[]' type='checkbox' value='".$value['CAP_LAY_DOC_REQ_ID']."'> &nbsp; ".ucwords(strtolower($this->trimming($value['CAP_LAY_DOC_REQ_DOCNAME'],25)))." ".$this->status[$result]."</li>";
						
							}
							else if ($result == 2) {

							$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input disabled name='id[]' type='checkbox' value='".$value['CAP_LAY_DOC_REQ_ID']."'> &nbsp; ".ucwords(strtolower($this->trimming($value['CAP_LAY_DOC_REQ_DOCNAME'],25)))." ".$this->status[$result]."</li>";

							}

							else if ($result == 3) {

							$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[]' type='checkbox' value='".$value['CAP_LAY_DOC_REQ_ID']."'> &nbsp; ".ucwords(strtolower($this->trimming($value['CAP_LAY_DOC_REQ_DOCNAME'],25)))." ".$this->status[$result]."</li>";

							}
							else {

							$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[]' type='checkbox' value='".$value['CAP_LAY_DOC_REQ_ID']."'> &nbsp; ".ucwords(strtolower($this->trimming($value['CAP_LAY_DOC_REQ_DOCNAME'],25)))."</li>";

							}
					
					$i++;
						
					}
					
				}
				
				$view .= "</ul>";
			
			$view .= "</div>";
			
			$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab'>";
			
			if (!empty($data)) {
			
			$i = 0;

				foreach ($data as $key => $value) {

				$result = $this->getStatusDokumenHistory($value['CAP_LAY_DOC_REQ_ID']);

				if ($result == 1 || $result == 2) {
																		
						$view .= "<div document='".$value['CAP_LAY_DOC_REQ_ID']."' class='layan-admin_pemberitahuan_create-dokumen-tab-inside displayNone'>";
				
						$view .= "<input name='tinggi-dokumen[]' class='layan-original-height' type='hidden' value='0'>";
							
							$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top full-width'>";
							
								$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header'>".$value['CAP_LAY_DOC_REQ_DOCNAME']." ".$this->status[$result]."</div>";
							
								$view .= "<div>Dokumen ini sudah memasuki proses final. Mohon pilih dokumen lainnya untuk diproses.</div>";
							
							$view .= "</div>";
						
						$view .= "</div>";
				
				$i++;

				continue;
				
				}
				
				$view .= "<div document='".$value['CAP_LAY_DOC_REQ_ID']."' class='layan-admin_pemberitahuan_create-dokumen-tab-inside displayNone'>";
				
				$view .= "<input class='layan-original-height' type='hidden' value='0'>";
				
					$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top full-width'>";
					
						$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header'>".$value['CAP_LAY_DOC_REQ_DOCNAME']."</div>";
						
						$view .= "<div>".$value['CAP_LAY_DOC_REQ_REASON']."</div>";
					
					$view .= "</div>";
					
					$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
					
						$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Pengecualian Informasi Berdasarkan Pada Alasan</div>";
						
						$view .= "<div>
						<input name='pasal[$i]' type='hidden' value='0'>
						<input name='pasal[$i]' type='checkbox' value='1'> Pasal 17 UU KIP</div>";
						
						$view .= "<div>
						<input name='undang-undang[$i]' type='hidden' value=''>
						<input class='layan-admin_pemberitahuan_create-dokumen-badan-publik-lain-uu' name='undang-undang[$i]' type='checkbox' value='1'> Pasal <input type='text' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-border-bottom-keberatan-1'> Undang-Undang <input type='text' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-border-bottom-keberatan-2'></div>";
						
						$view .= "<div>
						<input name='uji-konsekuensi[$i]' type='hidden' value=''>
						<input class='layan-admin_pemberitahuan_create-dokumen-badan-publik-lain-uji' name='uji-konsekuensi[$i]' type='checkbox' value='1'> Uji Konsekuensi Kementerian Pertanian No. <input type='text' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-border-bottom-keberatan'></div>";
					
					$view .= "</div>";
					
					$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
					
						$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Notes</div>";
											
						$view .= "<div><textarea name='notes[$i]' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-textarea'></textarea></div>";
					
					$view .= "</div>";
								
				$view .= "</div>";
				
				$i++;
				
				}
			
			}
			
			$view .= "</div>";
			
			$view .= "</div>";
						
			$view .= "<input style='margin-left:5px; margin-top:5px;' class='layan-normal-create-perpanjangan' type='submit' value='Create Penolakan'>";
			
			$view .= "</form>";
			
			$view .= "</div>";
			
		echo $view;
		
	}

	public function admin_penolakan_edit() {
		
		$this->data = base64_decode($_GET['ref']); 

		$registrar  = base64_decode($_GET['reg']); 
		
			if (!empty($_SESSION['LAYAN-PERMOHONAN'])) {
		
				$post = $this->updatePenolakan($_SESSION['LAYAN-PERMOHONAN']);

				unset($_SESSION['LAYAN-PERMOHONAN']);
				
			}
			
			if (!empty($_SESSION['LAYAN-ERROR'])) {

				$errorAnnouncement  = "<div class='layan-error-annoucement'>";

				foreach ($_SESSION['LAYAN-ERROR'] as $key => $value) {
					
					$errorAnnouncement .= "<li>- $value</li>"; 

				}

				$errorAnnouncement .= "</div>";

				unset($_SESSION['LAYAN-ERROR']);

			}
		
		$data = $this->getDocument($this->data);

		$document = $this->getDocument($this->data);

		$penolakan = $this->getPenolakanByID($registrar);

		$documentList  = $this->getPenolakanDocumentlistByID($registrar);

			$view  = "<div class='layan-normal-form-container'>";
						
			$view .= $this->optionGear;
						
			$view .= "<input class='layan-drill-down-menu' type='hidden' value='1975'>";
			
			$view .= "<div class='layan-permohonan-upper-menu-container'>";

			$view .= "<div class='layan-permohonan-icons-container'><a href='?id=1975&ref=".$_GET['ref']."'><div class='layan-admin_pemberitahuan_create-float-left-edit-permohonan qtip-upper' text='Back'></div></a></div>";
			
			$view .= "<div class='layan-permohonan-icons-container-right'>Edit Penolakan No. ".$penolakan[0]['CAP_LAY_PEN_NUMBER']."</div>";

			$view .= "</div>";

			$view .= "<form id='layan-permintaan-create' name='layan-permintaan-create' action='library/capsule/layan/process/process.php' method='post' autocomplete='off'>";
			
				$view .= "<table class='layan-normal-table'>";
					
					$view .= "<tr>";
						
						$view .= "<td colspan='3' class='layan-normal-form-bold'><hr class='layan-normal-form-hr'></td>";
											
					$view .= "</tr>";
														
				$view .= "</table>";
				
			$view .= $errorAnnouncement;
			
			$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-container'>";
			
			$view .= "<div class='layan-admin_pemberitahuan_create-dokumen'>";
			
				$view .= "<ul style='margin:0;padding:0;'>";
				
				if (!empty($data)) {

					foreach ($data as $key => $value) {

						
					$result  = $this->getStatusDokumenHistory($value['CAP_LAY_DOC_REQ_ID']);

						if (is_array($documentList)) {

							if (in_array($value['CAP_LAY_DOC_REQ_ID'], $documentList)) {

								$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' checked='checked' type='checkbox' value='".$value['CAP_LAY_DOC_REQ_ID']."'> &nbsp; ".ucwords(strtolower($this->trimming($value['CAP_LAY_DOC_REQ_DOCNAME'],25)))." ".$this->status[$result]."</li>";

							}
							else {

								if ($result == 3 || $result == 0) {

								$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='".$value['CAP_LAY_DOC_REQ_ID']."'> &nbsp; ".ucwords(strtolower($this->trimming($value['CAP_LAY_DOC_REQ_DOCNAME'],25)))." ".$this->status[$result]."</li>";

								}
								else {

								$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' disabled type='checkbox' value='".$value['CAP_LAY_DOC_REQ_ID']."'> &nbsp; ".ucwords(strtolower($this->trimming($value['CAP_LAY_DOC_REQ_DOCNAME'],25)))." ".$this->status[$result]."</li>";

								}

							}

						}
						else {

							if ($result == 3 || $result == 0) {

							$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='".$value['CAP_LAY_DOC_REQ_ID']."'> &nbsp; ".ucwords(strtolower($this->trimming($value['CAP_LAY_DOC_REQ_DOCNAME'],25)))." ".$this->status[$result]."</li>";

							}
							else {

							$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' disabled type='checkbox' value='".$value['CAP_LAY_DOC_REQ_ID']."'> &nbsp; ".ucwords(strtolower($this->trimming($value['CAP_LAY_DOC_REQ_DOCNAME'],25)))." ".$this->status[$result]."</li>";

							}

						}
						
					}
					
				}
				
				$view .= "</ul>";
			
			$view .= "</div>";
			
			$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab'>";
			
			if (!empty($data)) {
			
			$i = 0;
			
				foreach ($data as $key => $value) {
				
				unset($documents); unset($theText);

				$result = $this->getStatusDokumenHistory($value['CAP_LAY_DOC_REQ_ID']);

				if ($result == 1 || $result == 2) {
												
					$documents = $this->getLayanPenolakanDocument($value['CAP_LAY_DOC_REQ_ID']);

				}
				
				//print_r($documents);

				$view .= "<div document='".$value['CAP_LAY_DOC_REQ_ID']."' class='layan-admin_pemberitahuan_create-dokumen-tab-inside displayNone'>";
				
				$view .= "<input class='layan-original-height' type='hidden' value='0'>";
				
				$view .= "<input name='dokumen-id[$i]' type='hidden' value='$registrar'>";
				
					$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top full-width'>";
					
						$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header'>".$value['CAP_LAY_DOC_REQ_DOCNAME']."</div>";
						
						$view .= "<div>".$value['CAP_LAY_DOC_REQ_REASON']."</div>";
					
					$view .= "</div>";
					
					$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
					
						$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Pengecualian Informasi Berdasarkan Pada Alasan</div>";
						if ($documents[0]['CAP_LAY_PEN_DOC_PSL'] == 1) {
						$view .= "<div>
						<input name='pasal[$i]' type='hidden' value='0'>
						<input name='pasal[$i]' type='checkbox' checked='checked' value='1'> Pasal 17 UU KIP</div>";
						}
						else {
						$view .= "<div>
						<input name='pasal[$i]' type='hidden' value='0'>
						<input name='pasal[$i]' type='checkbox' value='1'> Pasal 17 UU KIP</div>";
						}
							if (!empty($documents[0]['CAP_LAY_PEN_DOC_UU'])) {
								
								$theText = explode("|",$documents[0]['CAP_LAY_PEN_DOC_UU']);
								
								$pasal = str_replace("PASAL","",strtoupper($theText[0]));
								
								$undang = str_replace("UNDANG-UNDANG","",strtoupper($theText[1]));
								
							}
						
						if (!empty($documents[0]['CAP_LAY_PEN_DOC_UU'])) {					
						$view .= "<div>
						<input name='undang-undang[$i]' type='hidden' value=''>
						<input class='layan-admin_pemberitahuan_create-dokumen-badan-publik-lain-uu' name='undang-undang[$i]' type='checkbox' checked='checked' value='1'> Pasal <input type='text' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-border-bottom-keberatan-1' value='$pasal'> Undang-Undang <input type='text' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-border-bottom-keberatan-2' value='$undang'></div>";
						}
						else {
						$view .= "<div>
						<input name='undang-undang[$i]' type='hidden' value=''>
						<input class='layan-admin_pemberitahuan_create-dokumen-badan-publik-lain-uu' name='undang-undang[$i]' type='checkbox' value='1'> Pasal <input type='text' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-border-bottom-keberatan-1' value='$pasal'> Undang-Undang <input type='text' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-border-bottom-keberatan-2' value='$undang'></div>";
						}
						
						if (!empty($documents[0]['CAP_LAY_PEN_DOC_UJI'])) {
						$view .= "<div>
						<input name='uji-konsekuensi[$i]' type='hidden' value=''>
						<input class='layan-admin_pemberitahuan_create-dokumen-badan-publik-lain-uji' name='uji-konsekuensi[$i]' type='checkbox' checked='checked' value=''> Uji Konsekuensi Kementerian Pertanian No. <input type='text' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-border-bottom-keberatan' value='".$documents[0]['CAP_LAY_PEN_DOC_UJI']."'></div>";
						}
						else {
						$view .= "<div>
						<input name='uji-konsekuensi[$i]' type='hidden' value=''>
						<input class='layan-admin_pemberitahuan_create-dokumen-badan-publik-lain-uji' name='uji-konsekuensi[$i]' type='checkbox' value=''> Uji Konsekuensi Kementerian Pertanian No. <input type='text' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-border-bottom-keberatan' value='".$documents[0]['CAP_LAY_PEN_DOC_UJI']."'></div>";
						}
					
					$view .= "</div>";
					
					$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
					
						$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Notes</div>";
											
						$view .= "<div><textarea name='notes[$i]' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-textarea'>".$documents[0]['CAP_LAY_PEN_DOC_NOTES']."</textarea></div>";
					
					$view .= "</div>";
								
				$view .= "</div>";
				
				$i++;
				
				}
			
			}
			
			$view .= "</div>";
			
			$view .= "</div>";
						
			$view .= "<input style='margin-left:5px; margin-top:5px;' class='layan-normal-create-perpanjangan' type='submit' value='Update Penolakan'>";
			
			$view .= "</form>";
			
			$view .= "</div>";
			
		echo $view;
		
	}
	
	public function admin_keberatan() {
		
		$this->data = base64_decode($_GET['ref']); 
		
			if (!empty($_SESSION['LAYAN-PERMOHONAN'])) {
		
				$post = $this->updatePermohonan($_SESSION['LAYAN-PERMOHONAN']);
				
				unset($_SESSION['LAYAN-PERMOHONAN']);
				
			}
		
		$data = $this->getKeberatanLengkap();
		
		$ch   = $this->getDokumenLengkap();
								
			$view  = "<div class='layan-normal-form-container'>";
						
			$view .= $this->optionGear;
			
			$view .= "<div class='layan-permohonan-upper-menu-container'>";
			
				if ($ch['CAP_LAY_FINALSTATUS'] == 5) {

				$view .= "<div class='layan-permohonan-icons-container' rel='keberatan'>
								<div class='layan-pemberitahuan-float-left-print-keberatan qtip-upper' text='Print Keberatan'></div>
						  </div>";
						  
				}
				else {
					
				$view .= "<div class='layan-permohonan-icons-container' rel='keberatan'>
							<!--<a href='index.php?id=2305&ref=".$_GET['ref']."'>
								<div class='layan-admin_pemberitahuan-float-left-add-permohonan qtip-upper' text='Create Keberatan'></div>
						 	</a>-->
						 	<a href='index.php?id=2306&ref=".$_GET['ref']."'>
								<div class='layan-admin_pemberitahuan-float-left-edit-permohonan qtip-upper' text='Edit Keberatan'></div>
							</a>
								<div class='layan-admin_pemberitahuan-float-left-print-permohonan qtip-upper' text='Delete Keberatan'></div>
								<div class='layan-pemberitahuan-float-left-print-keberatan qtip-upper' text='Print Keberatan'></div>
						  </div>";
					
				}
			
			$view .= "</div>";

			$view .= "<form name='layan-permohonan-update' action='library/capsule/layan/process/process.php' method='post'>";
			
				$view .= "<table class='layan-normal-table'>";
					
					$view .= "<tr>";
						
						$view .= "<td colspan='3' class='layan-normal-form-bold'><hr class='layan-normal-form-hr'></td>";
											
					$view .= "</tr>";
														
				$view .= "</table>";
							
			$view .= "</form>";
			
			$view .= "<ul class='layan-admin_pemberitahuan-ul'>";
			
				if (!empty($data)) {
			
					foreach ($data as $key => $value) {
					
					$document = $this->getKeberatanDokumen($value['CAP_LAY_KEB_ID']);

					$z = 0;

						foreach ($document as $key2 => $value2) {

							if (!empty($value2['CAP_LAY_ID'])) {

							$z++;
									
							}
							else if (!empty($value2['CAP_LAY_PEM_ID'])) {

							$z++;
									
							}
							else if (!empty($value2['CAP_LAY_PEN_ID'])) {

							$z++;
									
							}
							else if (!empty($value2['CAP_LAY_PER_ID'])) {

							$z++;
									
							}

						}
					
					if (empty($z) || empty($document[0]['CAP_LAY_KEB_DOC_ID'])) {$z = 0;}
					
					$view .= "<li><input type='checkbox' value='".$value['CAP_LAY_KEB_ID']."'> &nbsp;".$value['CAP_LAY_KEB_NUMBER']." - $z Dokumen";
					
						if (!empty($document)) {
							
							$view .= "<ul class='layan-admin_pemberitahuan-ul-secondary'>";

								foreach ($document as $key2 => $value2) {
								
									if ($ch['CAP_LAY_FINALSTATUS'] == 5) {
										
										$actionRemove = "";
										
									}
									else {
										
										$actionRemove = "(<a class='layan-admin_keberatan-delete-document-front' rel='".$value2['CAP_LAY_KEB_DOC_ID']."' href='#'>remove</a>)";
										
									}
								
									if (!empty($value2['CAP_LAY_ID'])) {
										
									$view .= "<li>- Permohonan No. ".ucwords(strtolower($value2['CAP_LAY_TRANSACTIONID']))." $actionRemove</li>";
									
									}
									else if (!empty($value2['CAP_LAY_PEM_ID'])) {
										
									$view .= "<li>- Pemberitahuan No. ".ucwords(strtolower($value2['CAP_LAY_PEM_NUMBER']))." $actionRemove</li>";
									
									}
									else if (!empty($value2['CAP_LAY_PEN_ID'])) {

									$view .= "<li>- Penolakan No. ".ucwords(strtolower($value2['CAP_LAY_PEN_NUMBER']))." $actionRemove</li>";
									
									}
									else if (!empty($value2['CAP_LAY_PER_ID'])) {

									$view .= "<li>- Perpanjangan No. ".ucwords(strtolower($value2['CAP_LAY_PER_NUMBER']))." $actionRemove</li>";
									
									}


								}
							
							$view .= "</ul>";
							
						}

					$view .= "</li>";
					
					}
				
				}
			
			$view .= "</ul>";
			
			$view .= "</div>";
			
		echo $view;
		
	}
	
	public function admin_keberatan_create() {
		
		$this->data = base64_decode($_GET['ref']); 
		
			if (!empty($_SESSION['LAYAN-PERMOHONAN'])) {
		
				$post = $this->createKeberatan($_SESSION['LAYAN-PERMOHONAN']);

				unset($_SESSION['LAYAN-PERMOHONAN']);
				
			}

			if (!empty($_SESSION['LAYAN-ERROR'])) {

				$errorAnnouncement  = "<div class='layan-error-annoucement'>";

				foreach ($_SESSION['LAYAN-ERROR'] as $key => $value) {
					
					$errorAnnouncement .= "<li>- $value</li>"; 

				}

				$errorAnnouncement .= "</div>";

				unset($_SESSION['LAYAN-ERROR']);

			}

		$pemohonanID = $this->getDokumenLengkap();
		
		$data ['permohonan'] = $this->getPermohonanLengkap();
		
		$data ['pemberitahuan'] = $this->getPemberitahuanLengkap();
		
		$data ['penolakan'] = $this->getPenolakanLengkap();
		
		$data ['perpanjangan'] = $this->getPerpanjanganLengkap();
		
		$tipePemohon = $this->getTipePemohon();
		
		$information = $this->getInformation();
		
		$salinan	 = $this->getSalinan();
				
		$document  = $this->getDocument($this->data);

			$view  = "<div class='layan-normal-form-container'>";
						
			$view .= $this->optionGear;
						
			$view .= "<input class='layan-drill-down-menu' type='hidden' value='1977'>";
			
			$view .= "<div class='layan-permohonan-upper-menu-container'>";

			$view .= "<div class='layan-permohonan-icons-container'><a href='?id=1977&ref=".$_GET['ref']."'><div class='layan-admin_pemberitahuan_create-float-left-edit-permohonan qtip-upper' text='Back'></div></a></div>";
			
			$view .= "<div class='layan-permohonan-icons-container-right'>Create Keberatan</div>";

			$view .= "</div>";

			$view .= "<form id='layan-keberatan-create' name='layan-permintaan-create' action='library/capsule/layan/process/process.php' method='post' autocomplete='off'>";
			
				$view .= "<table class='layan-normal-table'>";
					
					$view .= "<tr>";
						
						$view .= "<td colspan='3' class='layan-normal-form-bold'><hr class='layan-normal-form-hr'></td>";
											
					$view .= "</tr>";
														
				$view .= "</table>";

			$view .= $errorAnnouncement;
			
			$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-container'>";
			
			$view .= "<div class='layan-admin_pemberitahuan_create-dokumen'>";
			
				$view .= "<ul style='margin:0;padding:0;'>";
				
				if (!empty($data)) {

				$i = 0;

					foreach ($data as $key2 => $value2) {
					
						if (!empty($value2)) {
					
							foreach ($value2 as $key => $value) {
							
							unset($documents);
							
								if (!empty($value['CAP_LAY_PEM_ID'])) {
								
								$time  = $this->getTimeByTable('CAP_LAY_PEM_DATECREATED',"CAP_LAYAN_PEMBERITAHUAN WHERE CAP_LAY_PEM_ID = '".$value['CAP_LAY_PEM_ID']."'");

								}
								else if (!empty($value['CAP_LAY_PEN_ID'])) {
	
								$time  = $this->getTimeByTable('CAP_LAY_PEN_DATECREATED',"CAP_LAYAN_PENOLAKAN WHERE CAP_LAY_PEN_ID = '".$value['CAP_LAY_PEN_ID']."'");
									
								}
								else if (!empty($value['CAP_LAY_PER_ID'])) {
	
								$time  = $this->getTimeByTable('CAP_LAY_PER_DATECREATED',"CAP_LAYAN_PERPANJANGAN WHERE CAP_LAY_PER_ID = '".$value['CAP_LAY_PER_ID']."'");
									
								}
								else {
								
								$time  = $this->getTimeByTable('CAP_LAY_DATECREATED',"CAP_LAYAN WHERE CAP_LAY_ID = '".$value['CAP_LAY_ID']."'");
								
								}
								
								$time  = $this->getTimeByTable('CAP_LAY_PEM_DATECREATED',"CAP_LAYAN_PEMBERITAHUAN WHERE CAP_LAY_PEM_ID = '".$value['CAP_LAY_PEM_ID']."'");
								
								$dateTime = $this->getCurrentHolidayDateTimeDashboard(date("Y-m-d"),date("Y-m-d",strtotime($time['DATETIME'])));

								$dateTime2 =  strtotime ( '-'.$dateTime.' day' . date("Y-m-d H:i:s") );
								
								$date1 = new DateTime($time['DATETIME']);
								
								$date3 = date("Y-m-d H:i:s",$dateTime2);
								
								$date2 = new DateTime($date3);
								
								$interval = $date1->diff($date2);
								    
								$days = $interval->days;
								
								if (!empty($value['CAP_LAY_PEM_ID'])) {
								
								$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_PEM_ID'],'pemberitahuan');
									
									if (empty($documents)) {
									
										if ($days > 30) {

										$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' disabled='disabled' type='checkbox' value='pemberitahuan".$value['CAP_LAY_PEM_ID']."'> &nbsp; Pemberitahuan ".$value['CAP_LAY_PEM_NUMBER']."</li>";
										
										}
										else {
											
										$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='pemberitahuan".$value['CAP_LAY_PEM_ID']."'> &nbsp; Pemberitahuan ".$value['CAP_LAY_PEM_NUMBER']."</li>";
											
										}

									}
									else {
									
									$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' disabled='disabled' type='checkbox' value='pemberitahuan".$value['CAP_LAY_PEM_ID']."'> &nbsp; Pemberitahuan ".$value['CAP_LAY_PEM_NUMBER']."</li>";

									}
									
								}
								else if (!empty($value['CAP_LAY_PEN_ID'])) {

									$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_PEN_ID'],'penolakan');
									
									if (empty($documents)) {
									
										if ($days > 30) {

										$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' disabled='disabled' type='checkbox' value='penolakan".$value['CAP_LAY_PEN_ID']."'> &nbsp; Penolakan ".$value['CAP_LAY_PEN_NUMBER']."</li>";	
										
										}
										else {
											
										$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='penolakan".$value['CAP_LAY_PEN_ID']."'> &nbsp; Penolakan ".$value['CAP_LAY_PEN_NUMBER']."</li>";
											
										}

									}
									else {

									$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' disabled='disabled' type='checkbox' value='penolakan".$value['CAP_LAY_PEN_ID']."'> &nbsp; Penolakan ".$value['CAP_LAY_PEN_NUMBER']."</li>";

									}
									
								}
								else if (!empty($value['CAP_LAY_PER_ID'])) {
									
									$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_PER_ID'],'perpanjangan');

									if (empty($documents)) {
										
										if ($days > 30) {
										
										$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' disabled='disabled' type='checkbox' value='perpanjangan".$value['CAP_LAY_PER_ID']."'> &nbsp; Perpanjangan ".$value['CAP_LAY_PER_NUMBER']."</li>";
									
										}
										else {
											
										$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='perpanjangan".$value['CAP_LAY_PER_ID']."'> &nbsp; Perpanjangan ".$value['CAP_LAY_PER_NUMBER']."</li>";	
											
										}

									}
									else {

									$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' disabled='disabled' type='checkbox' value='perpanjangan".$value['CAP_LAY_PER_ID']."'> &nbsp; Perpanjangan ".$value['CAP_LAY_PER_NUMBER']."</li>";

									}
									
								}
								else {

									$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_ID'],'permohonan');
									
									if (empty($documents)) {
										
										if ($days > 30) {
										
										$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' disabled='disabled' type='checkbox' value='permohonan".$value['CAP_LAY_ID']."'> &nbsp; Permohonan ".$value['CAP_LAY_TRANSACTIONID']."</li>";
										
										}
										else {
											
										$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='permohonan".$value['CAP_LAY_ID']."'> &nbsp; Permohonan ".$value['CAP_LAY_TRANSACTIONID']."</li>";
											
										}

									}
									else {

									$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' disabled='disabled' type='checkbox' value='permohonan".$value['CAP_LAY_ID']."'> &nbsp; Permohonan ".$value['CAP_LAY_TRANSACTIONID']."</li>";

									}
								
								}
														
							$i++;
								
							}
						
						}
											
					}
					
				}
				
				$view .= "</ul>";
			
			$view .= "</div>";
			
			$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab'>";

			if (!empty($data)) {
			
			$i = 0;

				foreach ($data as $key2 => $value2) {
					
					if (!empty($value2)) {
					
						foreach ($value2 as $key => $value) {
						
						unset($documents);

								if (!empty($value['CAP_LAY_PEM_ID'])) {
								
								$numberID = "pemberitahuan".$value['CAP_LAY_PEM_ID'];
								$headerID = "Pemberitahuan No. ".$value['CAP_LAY_PEM_NUMBER'];
								$time  = $this->getTimeByTable('CAP_LAY_PEM_DATECREATED',"CAP_LAYAN_PEMBERITAHUAN WHERE CAP_LAY_PEM_ID = '".$value['CAP_LAY_PEM_ID']."'");
								$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_PEM_ID'],'pemberitahuan');

								}
								else if (!empty($value['CAP_LAY_PEN_ID'])) {
	
								$numberID = "penolakan".$value['CAP_LAY_PEN_ID'];
								$headerID = "Penolakan No. ".$value['CAP_LAY_PEN_NUMBER'];
								$time  = $this->getTimeByTable('CAP_LAY_PEN_DATECREATED',"CAP_LAYAN_PENOLAKAN WHERE CAP_LAY_PEN_ID = '".$value['CAP_LAY_PEN_ID']."'");
								$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_PEN_ID'],'penolakan');
									
								}
								else if (!empty($value['CAP_LAY_PER_ID'])) {
	
								$numberID = "perpanjangan".$value['CAP_LAY_PER_ID'];
								$headerID = "Perpanjangan No. ".$value['CAP_LAY_PER_NUMBER'];
								$time  = $this->getTimeByTable('CAP_LAY_PER_DATECREATED',"CAP_LAYAN_PERPANJANGAN WHERE CAP_LAY_PER_ID = '".$value['CAP_LAY_PER_ID']."'");
								$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_PER_ID'],'perpanjangan');
									
								}
								else {
								
								$numberID = "permohonan".$value['CAP_LAY_ID'];
								$headerID = "Permohonan No. ".$value['CAP_LAY_TRANSACTIONID'];
								$time  = $this->getTimeByTable('CAP_LAY_DATECREATED',"CAP_LAYAN WHERE CAP_LAY_ID = '".$value['CAP_LAY_ID']."'");
								$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_ID'],'permohonan');
								
								}

							$dateTime = $this->getCurrentHolidayDateTimeDashboard(date("Y-m-d"),date("Y-m-d",strtotime($time['DATETIME'])));

							$dateTime2 =  strtotime ( '-'.$dateTime.' day' . date("Y-m-d H:i:s") );
							
							$date1 = new DateTime($time['DATETIME']);
							
							$date3 = date("Y-m-d H:i:s",$dateTime2);
							
							$date2 = new DateTime($date3);
							
							$interval = $date1->diff($date2);
							
							$years = $interval->format('%y');
							    
							$months = $interval->format('%m');
							    
							$days = $interval->format('%d'); 
							    
							$hour = $interval->format('%H'); 
							    
							$minute = $interval->format('%i'); 
							    
							$second = $interval->format('%s');

							unset($waktu);
		    
							if ($years != 0) {
							    $waktu  = $years." Tahun ";
						    }
						    if ($months != 0) {
							    $waktu  .= $months." Bulan ";
						    }
							if ($days != 0) {
							    $waktu  .= $days." Hari ";
						    }
						    if ($hour != 0) {
							   	$waktu .= $hour." Jam ";
						    }
						    if ($minute != 0) {
							   	$waktu .= $minute." Menit ";
						    }
						    if ($second != 0) {
							   	$waktu .= $second." Detik ";
						    }
							
							if ($days > 30) {
																					
									$view .= "<div document='".$numberID."' class='layan-admin_pemberitahuan_create-dokumen-tab-inside displayNone'>";
							
									$view .= "<input name='tinggi-dokumen[$i]' class='layan-original-height' type='hidden' value='0'>";
										
										$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top full-width'>";
										
											$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header'>".$headerID."</div>";
										
											$view .= "<div>Dokumen ini sudah melebihi jangka waktu 30 hari sejak diciptakan. Dan oleh karenanya sesuai dengan UU No. 14 tahun 2008 tentang keterbukaan informasi publik pasal 35, dokumen ini sudah tidak dapat di lakukan keberatan.</div>";
										
										$view .= "</div>";
									
									$view .= "</div>";
							
							$i++;
			
							continue;
							
							}
							else if (!empty($documents)) {

								$view .= "<div document='".$numberID."' class='layan-admin_pemberitahuan_create-dokumen-tab-inside displayNone'>";
							
									$view .= "<input name='tinggi-dokumen[$i]' class='layan-original-height' type='hidden' value='0'>";
										
										$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top full-width'>";
										
											$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header'>".$headerID."</div>";
										
											$view .= "<div>Dokumen ini sudah pernah diberatkan dalam keberatan no. ".$documents[0]['CAP_LAY_KEB_NUMBER']." sebelumnya dan oleh karenanya tidak dapat diberatkan lagi.</div>";
										
										$view .= "</div>";
									
									$view .= "</div>";
							
							$i++;
			
							continue;

							}							
							
							$view .= "<div document='".$numberID."' class='layan-admin_pemberitahuan_create-dokumen-tab-inside displayNone'>";
							
							$view .= "<input class='layan-original-height' type='hidden' value='0'>";

							$view .= "<input name='permohonan-ID' type='hidden' value='".base64_encode($pemohonanID['CAP_LAY_TRANSACTIONID'])."'>";
								
								$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top full-width'>";
								
									$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header'>".$headerID."</div>";
									
									$view .= "<div>".$waktu."</div>";
													
								$view .= "</div>";
								
								$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
								
									$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Nama</div>";
														
									$view .= "<div><input name='nama-kuasa' type='text' class='layan-admin_perpanjangan_create-dokumen-biaya-form-input-full-kuasa-pemohon' placeholder='Nama Lengkap Kuasa Pemohon'></div>";
								
								$view .= "</div>";

								$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
								
									$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Alamat</div>";
														
									$view .= "<div><input name='alamat-kuasa' type='text' class='layan-admin_perpanjangan_create-dokumen-biaya-form-input-full-alamat-pemohon' placeholder='Alamat Lengkap Kuasa Pemohon'></div>";
								
								$view .= "</div>";

								$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
								
									$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Tanggal Tanggapan</div>";
														
									$view .= "<div><input name='tanggal-keberatan' type='text' class='layan-admin_perpanjangan_create-dokumen-biaya-form-input-full' placeholder='Tanggal'></div>";
								
								$view .= "</div>";
								
								$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
								
									$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Daftar Alasan</div>";
														
										$view .= "<div>";
										
											$view .= "<li><input name='daftar-alasan[$i][0]' type='hidden' value='0'><input name='daftar-alasan[$i][0]' type='checkbox' value='1'> &nbsp; (a) &nbsp;Alasan pengecualian pasal 17 UU No. 14 tahun 2008</li>";
											
											$view .= "<li><input name='daftar-alasan[$i][1]' type='hidden' value='0'><input name='daftar-alasan[$i][1]' type='checkbox' value='1'> &nbsp; (b) &nbsp;Tidak disediakan informasi berkala</li>";
											
											$view .= "<li><input name='daftar-alasan[$i][2]' type='hidden' value='0'><input name='daftar-alasan[$i][2]' type='checkbox' value='1'> &nbsp; (c) &nbsp;Tidak ditanggapinya permintaan informasi</li>";
											
											$view .= "<li><input name='daftar-alasan[$i][3]' type='hidden' value='0'><input name='daftar-alasan[$i][3]' type='checkbox' value='1'> &nbsp; (d) &nbsp;Tidak ditanggapi sebagaimana yang diminta</li>";
											
											$view .= "<li><input name='daftar-alasan[$i][4]' type='hidden' value='0'><input name='daftar-alasan[$i][4]' type='checkbox' value='1'> &nbsp; (e) &nbsp;Tidak dipenuhinya permintaan informasi</li>";
											
											$view .= "<li><input name='daftar-alasan[$i][5]' type='hidden' value='0'><input name='daftar-alasan[$i][5]' type='checkbox' value='1'> &nbsp; (f) &nbsp;Pengenaan biaya yang tidak wajar</li>";
											
											$view .= "<li><input name='daftar-alasan[$i][6]' type='hidden' value='0'><input name='daftar-alasan[$i][6]' type='checkbox' value='1'> &nbsp; (g) &nbsp;Penyampaian informasi melebihi waktu yang diatur dalam Undang-Undang</li>";
										
										$view .= "</div>";
								
								$view .= "</div>";
								
								$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
								
									$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Notes</div>";
														
									$view .= "<div><textarea name='notes[$i]' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-textarea'></textarea></div>";
								
								$view .= "</div>";
											
							$view .= "</div>";

							$i++;
							
							}
						
						}
				
				}
			
			}
			
			$view .= "</div>";
			
			$view .= "</div>";
						
			$view .= "<input style='margin-left:5px; margin-top:5px;' class='layan-normal-create-keberatan' type='submit' value='Create Keberatan'>";
			
			$view .= "</form>";
			
			$view .= "</div>";

			$holidayDate = $this->getHolidayDate(date("Y-m-d"),date("Y-12-31"));

				if (!empty($holidayDate)) {

					foreach ($holidayDate as $value) {

						$holidayArray [] = date("Y-m-d",strtotime($value['CAP_LAY_CAL_DATE']));

					}

				}

				$AddHoliday = count($holidayArray);

				$time = new time(null);

				$endDate = $time->addDays(strtotime(date("Y-m-d")),30+$AddHoliday,array("Saturday", "Sunday"),$holidayArray);

				$endDate = date("Y-m-d",$endDate);

				unset($holidayArray);

				if (!empty($holidayDate)) {

					foreach ($holidayDate as $value) {

						if (strtotime($value['CAP_LAY_CAL_DATE']) > strtotime($endDate)) {

							break;

						} 

						$weekDay = date('w', strtotime($value['CAP_LAY_CAL_DATE']));

						if ($weekDay != 0 && $weekDay != 6) {

							$holidayArray [] = date("Y-m-d",strtotime($value['CAP_LAY_CAL_DATE']));

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

			$numberOfDays = $time->getWorkingDays(date("Y-m-d"),$endDate,$holidayArray);

			$dateA = new DateTime(date("Y-m-d"));
					
			$dateB = new DateTime($endDate);
			
			$intervalA = $dateA->diff($dateB);
			
			$maxDate = $intervalA->days;

			$_SESSION['LAYAN-KEBERATAN-MAX-DATE'] = date("Y-m-d",strtotime("+".$maxDate."day".date("Y-m-d")));

			$view .= "

			<script type='text/javascript'>

				jQuery.noConflict()(function($){

					$(document).ready(function() {

						var IndonesianHoliday = [$IndonesianHoliday];

						$('.layan-admin_perpanjangan_create-dokumen-biaya-form-input-full').datepicker({ 
						dateFormat: 'dd-mm-yy',
						minDate: 0, 
						maxDate: '+".$maxDate."D',
						beforeShowDay: function(date) {
								            
						var showDay = true;
								            
						// disable sunday and saturday
						if (date.getDay() == 0 || date.getDay() == 6) {
							showDay = false;
					    }
								            			            
						// jquery in array function
						if ($.inArray(date.getTime(), IndonesianHoliday) > -1) {
							showDay = false;
						}
								            
								            
							return [showDay];
						},
						onSelect: function(dateText, inst) { 
							$('.layan-admin_perpanjangan_create-dokumen-biaya-form-input-full').val(dateText);
							$('.layan-admin_perpanjangan_create-dokumen-biaya-form-input-full').attr('value',dateText);
						}

					});

				});

			});
			</script>

			";
			
		echo $view;
		
	}

	public function admin_keberatan_edit() {
		
		$this->data = base64_decode($_GET['ref']); 

		$registrar  = base64_decode($_GET['reg']);

			if (!empty($_SESSION['LAYAN-PERMOHONAN'])) {

				$post = $this->updateKeberatan($_SESSION['LAYAN-PERMOHONAN']);

				unset($_SESSION['LAYAN-PERMOHONAN']);
				
			}

			if (!empty($_SESSION['LAYAN-ERROR'])) {

				$errorAnnouncement  = "<div class='layan-error-annoucement'>";

				foreach ($_SESSION['LAYAN-ERROR'] as $key => $value) {
					
					$errorAnnouncement .= "<li>- $value</li>"; 

				}

				$errorAnnouncement .= "</div>";

				unset($_SESSION['LAYAN-ERROR']);

			}
		
		$pemohonanID = $this->getDokumenLengkap();
		
		$data ['permohonan'] = $this->getPermohonanLengkap();
		
		$data ['pemberitahuan'] = $this->getPemberitahuanLengkap();
		
		$data ['penolakan'] = $this->getPenolakanLengkap();
		
		$data ['perpanjangan'] = $this->getPerpanjanganLengkap();
		
		$tipePemohon = $this->getTipePemohon();
		
		$information = $this->getInformation();
		
		$salinan	 = $this->getSalinan();
						
		$document = $this->getDocument($this->data);

		$keberatan = $this->getKeberatanByID($registrar);

		$documentList  = $this->getKeberatanDocumentlistByID($registrar);

			$view  = "<div class='layan-normal-form-container'>";
						
			$view .= $this->optionGear;
						
			$view .= "<input class='layan-drill-down-menu' type='hidden' value='1977'>";
			
			$view .= "<div class='layan-permohonan-upper-menu-container'>";

			$view .= "<div class='layan-permohonan-icons-container'><a href='?id=1977&ref=".$_GET['ref']."'><div class='layan-admin_pemberitahuan_create-float-left-edit-permohonan qtip-upper' text='Back'></div></a></div>";
			
			$view .= "<div class='layan-permohonan-icons-container-right'>Edit Keberatan No. ".$keberatan[0]['CAP_LAY_KEB_NUMBER']."</div>";

			$view .= "</div>";

			$view .= "<form id='layan-keberatan-create' name='layan-permintaan-create' action='library/capsule/layan/process/process.php' method='post' autocomplete='off'>";
			
				$view .= "<table class='layan-normal-table'>";

					$view .= "<tr>";

						$view .= "<td colspan='3' class='layan-normal-form-bold'><hr class='layan-normal-form-hr'></td>";
											
					$view .= "</tr>";
														
				$view .= "</table>";
			
			$view .= $errorAnnouncement;

			$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-container'>";
			
			$view .= "<div class='layan-admin_pemberitahuan_create-dokumen'>";
			
				$view .= "<ul style='margin:0;padding:0;'>";

				if (!empty($data)) {

				$i = 0;

					foreach ($data as $key2 => $value2) {
					
						if (!empty($value2)) {
					
							foreach ($value2 as $key => $value) {
							
							unset($documents);

								if (!empty($value['CAP_LAY_PEM_ID'])) {

								$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_PEM_ID'],'pemberitahuan');

									if (is_array($documentList)) {

										if (is_array($documentList['pemberitahuan'])) {

											if (in_array($value['CAP_LAY_PEM_ID'], $documentList['pemberitahuan'])) {

												$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' checked type='checkbox' value='pemberitahuan".$value['CAP_LAY_PEM_ID']."'> &nbsp; Pemberitahuan ".$value['CAP_LAY_PEM_NUMBER']."</li>";

											}
											else {
												$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='pemberitahuan".$value['CAP_LAY_PEM_ID']."'> &nbsp; Pemberitahuan ".$value['CAP_LAY_PEM_NUMBER']."</li>";
											}

										}
										else {

											if (!empty($documents) && $keberatan[0]['CAP_LAY_KEB_ID'] != $documents[0]['FK_CAP_LAY_KEB_ID']) {

											$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' disabled='disabled' type='checkbox' value='pemberitahuan".$value['CAP_LAY_PEM_ID']."'> &nbsp; Pemberitahuan ".$value['CAP_LAY_PEM_NUMBER']."</li>";

											}
											else {

											$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='pemberitahuan".$value['CAP_LAY_PEM_ID']."'> &nbsp; Pemberitahuan ".$value['CAP_LAY_PEM_NUMBER']."</li>";

											}

										}

									}
									else {

										$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_PEM_ID'],'pemberitahuan');

										if (empty($documents)) {

										$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='pemberitahuan".$value['CAP_LAY_PEM_ID']."'> &nbsp; Pemberitahuan ".$value['CAP_LAY_PEM_NUMBER']."</li>";

										}
										else {

										$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' disabled='disabled' type='checkbox' value='pemberitahuan".$value['CAP_LAY_PEM_ID']."'> &nbsp; Pemberitahuan ".$value['CAP_LAY_PEM_NUMBER']."</li>";

										}

									}
										
								}
								else if (!empty($value['CAP_LAY_PEN_ID'])) {
								
								$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_PEN_ID'],'penolakan');

									if (is_array($documentList)) {

										if (is_array($documentList['penolakan'])) {

											if (in_array($value['CAP_LAY_PEN_ID'], $documentList['penolakan'])) {

												$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' checked type='checkbox' value='penolakan".$value['CAP_LAY_PEN_ID']."'> &nbsp; Penolakan ".$value['CAP_LAY_PEN_NUMBER']."</li>";

											}
											else {
												$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='penolakan".$value['CAP_LAY_PEN_ID']."'> &nbsp; Penolakan ".$value['CAP_LAY_PEN_NUMBER']."</li>";
											}

										}
										else {

											if (!empty($documents) && $keberatan[0]['CAP_LAY_KEB_ID'] != $documents[0]['FK_CAP_LAY_KEB_ID']) {

											$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' disabled='disabled' type='checkbox' value='penolakan".$value['CAP_LAY_PEN_ID']."'> &nbsp; Penolakan ".$value['CAP_LAY_PEN_NUMBER']."</li>";

											}
											else {

											$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='penolakan".$value['CAP_LAY_PEN_ID']."'> &nbsp; Penolakan ".$value['CAP_LAY_PEN_NUMBER']."</li>";

											}

										}

									}
									else {

										$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_PEN_ID'],'penolakan');

										if (empty($documents)) {

										$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='penolakan".$value['CAP_LAY_PEN_ID']."'> &nbsp; Penolakan ".$value['CAP_LAY_PEN_NUMBER']."</li>";

										}
										else {

										$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' disabled='disabled' type='checkbox' value='penolakan".$value['CAP_LAY_PEN_ID']."'> &nbsp; Penolakan ".$value['CAP_LAY_PEN_NUMBER']."</li>";

										}
										
									}		

								}
								else if (!empty($value['CAP_LAY_PER_ID'])) {
								
								$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_PER_ID'],'perpanjangan');

									if (is_array($documentList)) {

										if (is_array($documentList['perpanjangan'])) {

											if (in_array($value['CAP_LAY_PER_ID'], $documentList['perpanjangan'])) {

												$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' checked type='checkbox' value='perpanjangan".$value['CAP_LAY_PER_ID']."'> &nbsp; Perpanjangan ".$value['CAP_LAY_PER_NUMBER']."</li>";

											}
											else {
												$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='perpanjangan".$value['CAP_LAY_PER_ID']."'> &nbsp; Perpanjangan ".$value['CAP_LAY_PER_NUMBER']."</li>";
											}

										}
										else {

											if (!empty($documents) && $keberatan[0]['CAP_LAY_KEB_ID'] != $documents[0]['FK_CAP_LAY_KEB_ID']) {

											$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' disabled='disabled' type='checkbox' value='perpanjangan".$value['CAP_LAY_PER_ID']."'> &nbsp; Perpanjangan ".$value['CAP_LAY_PER_NUMBER']."</li>";

											}
											else {

											$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='perpanjangan".$value['CAP_LAY_PER_ID']."'> &nbsp; Perpanjangan ".$value['CAP_LAY_PER_NUMBER']."</li>";

											}

										}

									}
									else {

										$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_PER_ID'],'perpanjangan');

										if (empty($documents)) {

										$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='perpanjangan".$value['CAP_LAY_PER_ID']."'> &nbsp; Perpanjangan ".$value['CAP_LAY_PER_NUMBER']."</li>";

										}
										else {

										$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' disabled='disabled' type='checkbox' value='perpanjangan".$value['CAP_LAY_PER_ID']."'> &nbsp; Perpanjangan ".$value['CAP_LAY_PER_NUMBER']."</li>";

										}
										
									}

								}
								else {
								
								$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_ID'],'permohonan');

									if (is_array($documentList)) {

										if (is_array($documentList['permohonan'])) {

											if (in_array($value['CAP_LAY_ID'], $documentList['permohonan'])) {

												$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' checked type='checkbox' value='permohonan".$value['CAP_LAY_ID']."'> &nbsp; Permohonan ".$value['CAP_LAY_TRANSACTIONID']."</li>";

											}
											else {
												$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='permohonan".$value['CAP_LAY_ID']."'> &nbsp; Permohonan ".$value['CAP_LAY_TRANSACTIONID']."</li>";
											}

										}
										else {

											if (!empty($documents) && $keberatan[0]['CAP_LAY_KEB_ID'] != $documents[0]['FK_CAP_LAY_KEB_ID']) {

											$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' disabled='disabled' type='checkbox' value='permohonan".$value['CAP_LAY_ID']."'> &nbsp; Permohonan ".$value['CAP_LAY_TRANSACTIONID']."</li>";

											}
											else {

											$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='permohonan".$value['CAP_LAY_ID']."'> &nbsp; Permohonan ".$value['CAP_LAY_TRANSACTIONID']."</li>";

											}

										}

									}
									else {

										$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_ID'],'permohonan');

										if (empty($documents)) {

										$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='permohonan".$value['CAP_LAY_ID']."'> &nbsp; Permohonan ".$value['CAP_LAY_TRANSACTIONID']."</li>";

										}
										else {

										$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' disabled='disabled' type='checkbox' value='permohonan".$value['CAP_LAY_ID']."'> &nbsp; Permohonan ".$value['CAP_LAY_TRANSACTIONID']."</li>";

										}
										
									}

								}
														
							$i++;
								
							}
						
						}
											
					}
					
				}
				
				$view .= "</ul>";
			
			$view .= "</div>";
			
			$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab'>";
			
			if (!empty($data)) {
			
			$i = 0;

				foreach ($data as $key2 => $value2) {
					
					if (!empty($value2)) {
					
						foreach ($value2 as $key => $value) {
						
						unset($documents);

								if (!empty($value['CAP_LAY_PEM_ID'])) {
								
								$numberID = "pemberitahuan".$value['CAP_LAY_PEM_ID'];
								$headerID = "Pemberitahuan No. ".$value['CAP_LAY_PEM_NUMBER'];
								$time  = $this->getTimeByTable('CAP_LAY_PEM_DATECREATED',"CAP_LAYAN_PEMBERITAHUAN WHERE CAP_LAY_PEM_ID = '".$value['CAP_LAY_PEM_ID']."'");
								$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_PEM_ID'],'pemberitahuan');
									
								}
								else if (!empty($value['CAP_LAY_PEN_ID'])) {
	
								$numberID = "penolakan".$value['CAP_LAY_PEN_ID'];
								$headerID = "Penolakan No. ".$value['CAP_LAY_PEN_NUMBER'];
								$time  = $this->getTimeByTable('CAP_LAY_PEN_DATECREATED',"CAP_LAYAN_PENOLAKAN WHERE CAP_LAY_PEN_ID = '".$value['CAP_LAY_PEN_ID']."'");
								$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_PEN_ID'],'penolakan');
									
								}
								else if (!empty($value['CAP_LAY_PER_ID'])) {
	
								$numberID = "perpanjangan".$value['CAP_LAY_PER_ID'];
								$headerID = "Perpanjangan No. ".$value['CAP_LAY_PER_NUMBER'];
								$time  = $this->getTimeByTable('CAP_LAY_PER_DATECREATED',"CAP_LAYAN_PERPANJANGAN WHERE CAP_LAY_PER_ID = '".$value['CAP_LAY_PER_ID']."'");
								$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_PER_ID'],'perpanjangan');
									
								}
								else {
								
								$numberID = "permohonan".$value['CAP_LAY_ID'];
								$headerID = "Permohonan No. ".$value['CAP_LAY_TRANSACTIONID'];
								$time  = $this->getTimeByTable('CAP_LAY_DATECREATED',"CAP_LAYAN WHERE CAP_LAY_ID = '".$value['CAP_LAY_ID']."'");
								$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_ID'],'permohonan');
								
								}
							
							$dateTime = $this->getCurrentHolidayDateTimeDashboard(date("Y-m-d H:i:s"),date("Y-m-d H:i:s",strtotime($time['DATETIME'])));

							$dateTime2 =  strtotime ( '-'.$dateTime.' day' . date("Y-m-d H:i:s") );
							
							$date1 = new DateTime($time['DATETIME']);
							
							$date3 = date("Y-m-d H:i:s",$dateTime2);
							
							$date2 = new DateTime($date3);
							
							$interval = $date1->diff($date2);
							
							$years = $interval->format('%y');
							    
							$months = $interval->format('%m');
							    
							$days = $interval->format('%d'); 
							    
							$hour = $interval->format('%H'); 
							    
							$minute = $interval->format('%i'); 
							    
							$second = $interval->format('%s');

							unset($waktu);
		    				
		    				//print_r($dateTime."-".$time['DATETIME']); echo "<br>";
							
							if ($years != 0) {
							    $waktu  = $years." Tahun ";
						    }
						    if ($months != 0) {
							    $waktu  .= $months." Bulan ";
						    }
							if ($days != 0) {
							    $waktu  .= $days." Hari ";
						    }
						    if ($hour != 0) {
							   	$waktu .= $hour." Jam ";
						    }
						    if ($minute != 0) {
							   	$waktu .= $minute." Menit ";
						    }
						    if ($second != 0) {
							   	$waktu .= $second." Detik ";
						    }
							
						    //print_r($keberatan[0]['CAP_LAY_KEB_ID']."-".$documents[0]['FK_CAP_LAY_KEB_ID']."<br>");

							if ($days > 30) {
																					
									$view .= "<div document='".$numberID."' class='layan-admin_pemberitahuan_create-dokumen-tab-inside displayNone'>";
							
									$view .= "<input name='tinggi-dokumen[$i]' class='layan-original-height' type='hidden' value='0'>";
										
										$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top full-width'>";
										
											$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header'>".$headerID."</div>";
										
											$view .= "<div>Dokumen ini sudah melebihi jangka waktu 30 hari sejak diciptakan. Dan oleh karenanya sesuai dengan UU No. 14 tahun 2008 tentang keterbukaan informasi publik pasal 35, dokumen ini sudah tidak dapat di lakukan keberatan.</div>";
										
										$view .= "</div>";
									
									$view .= "</div>";
							
							$i++;
			
							continue;
							
							}
							else if (!empty($documents) && $keberatan[0]['CAP_LAY_KEB_ID'] != $documents[0]['FK_CAP_LAY_KEB_ID']) {

								$view .= "<div document='".$numberID."' class='layan-admin_pemberitahuan_create-dokumen-tab-inside displayNone'>";
							
									$view .= "<input name='tinggi-dokumen[$i]' class='layan-original-height' type='hidden' value='0'>";
										
										$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top full-width'>";
										
											$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header'>".$headerID."</div>";
										
											$view .= "<div>Dokumen ini sudah pernah diberatkan dalam keberatan no. ".$documents[0]['CAP_LAY_KEB_NUMBER']." sebelumnya dan oleh karenanya tidak dapat diberatkan lagi.</div>";
										
										$view .= "</div>";
									
									$view .= "</div>";
							
							$i++;
			
							continue;

							}					

							$view .= "<div document='".$numberID."' class='layan-admin_pemberitahuan_create-dokumen-tab-inside displayNone'>";
							
							$view .= "<input class='layan-original-height' type='hidden' value='0'>";

							$view .= "<input name='keberatan-id[$i]' type='hidden' value='".$keberatan[0]['CAP_LAY_KEB_ID']."'>";

							$view .= "<input name='document-id[$i]' type='hidden' value='".$documents[0]['CAP_LAY_KEB_DOC_ID']."'>";

							$view .= "<input name='permohonan-ID' type='hidden' value='".base64_encode($pemohonanID['CAP_LAY_TRANSACTIONID'])."'>";
								
								$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top full-width'>";
								
									$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header'>".$headerID."</div>";
									
									$view .= "<div>".$waktu."</div>";
													
								$view .= "</div>";
								
								$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
								
									$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Penyelesaian</div>";
														
									$view .= "<div>";
									
										$view .= "<select name='penyelesaian-keberatan' class='layan-keberatan-select-finish'>";
										
											if ($keberatan[0]['CAP_LAY_KEB_STATUS'] == 1) {
										
											$view .= "<option value='0'>Pilih Penyelesaian</option>";
										
											$view .= "<option selected='selected' value='1'>Selesai Secara Internal</option>";
											
											$view .= "<option value='2'>Sengketa di Komisi Informasi</option>";
											
											}
											else if ($keberatan[0]['CAP_LAY_KEB_STATUS'] == 2) {
												
											$view .= "<option value='0'>Pilih Penyelesaian</option>";
										
											$view .= "<option value='1'>Selesai Secara Internal</option>";
											
											$view .= "<option selected='selected' value='2'>Sengketa di Komisi Informasi</option>";
												
											}
											else {
												
											$view .= "<option selected='selected' value='0'>Pilih Penyelesaian</option>";
										
											$view .= "<option value='1'>Selesai Secara Internal</option>";
											
											$view .= "<option value='2'>Sengketa di Komisi Informasi</option>";
												
											}
										
										$view .= "</select>";
									
									$view .= "</div>";
								
								$view .= "</div>";

								$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
								
									$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Nama</div>";
														
									$view .= "<div><input name='nama-kuasa' type='text' class='layan-admin_perpanjangan_create-dokumen-biaya-form-input-full-kuasa-pemohon' placeholder='Nama Lengkap Kuasa Pemohon' value='".$documents[0]['CAP_LAY_KEB_NAME']."' readonly='true'></div>";
								
								$view .= "</div>";

								$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
								
									$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Alamat</div>";
														
									$view .= "<div><input name='alamat-kuasa' type='text' class='layan-admin_perpanjangan_create-dokumen-biaya-form-input-full-alamat-pemohon' placeholder='Alamat Lengkap Kuasa Pemohon' value='".$documents[0]['CAP_LAY_KEB_ALAMAT']."' readonly='true'></div>";
								
								$view .= "</div>";
								
								$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
								
									$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Tanggal Tanggapan</div>";
														
										if (!empty($keberatan[0]['CAP_LAY_KEB_DATE_TO'])) {

										$view .= "<div><input name='tanggal-keberatan' type='text' class='layan-admin_perpanjangan_create-dokumen-biaya-form-input-full' placeholder='Tanggal' value='".date("d-m-Y",strtotime($keberatan[0]['CAP_LAY_KEB_DATE_TO']))."'></div>";
										
										}
										else {

										$view .= "<div><input name='tanggal-keberatan' type='text' class='layan-admin_perpanjangan_create-dokumen-biaya-form-input-full' placeholder='Tanggal' value=''></div>";

										}	

								$view .= "</div>";
								
								$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
								
									$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Daftar Alasan</div>";
														
										$view .= "<div>";
											
											if ($documents[0]['CAP_LAY_KEB_DOC_A'] == 1) {

											$view .= "<li><input name='daftar-alasan[$i][0]' type='hidden' value='0'><input name='daftar-alasan[$i][0]' checked type='checkbox' value='1'> &nbsp; (a) &nbsp;Alasan pengecualian pasal 17 UU No. 14 tahun 2008</li>";

											}
											else {

											$view .= "<li><input name='daftar-alasan[$i][0]' type='hidden' value='0'><input name='daftar-alasan[$i][0]' type='checkbox' value='1'> &nbsp; (a) &nbsp;Alasan pengecualian pasal 17 UU No. 14 tahun 2008</li>";

											}
											
											if ($documents[0]['CAP_LAY_KEB_DOC_B'] == 1) {

											$view .= "<li><input name='daftar-alasan[$i][1]' type='hidden' value='0'><input name='daftar-alasan[$i][1]' checked type='checkbox' value='1'> &nbsp; (b) &nbsp;Tidak disediakan informasi berkala</li>";
											
											}
											else {

											$view .= "<li><input name='daftar-alasan[$i][1]' type='hidden' value='0'><input name='daftar-alasan[$i][1]' type='checkbox' value='1'> &nbsp; (b) &nbsp;Tidak disediakan informasi berkala</li>";

											}

											if ($documents[0]['CAP_LAY_KEB_DOC_C'] == 1) {

											$view .= "<li><input name='daftar-alasan[$i][2]' type='hidden' value='0'><input name='daftar-alasan[$i][2]' checked type='checkbox' value='1'> &nbsp; (c) &nbsp;Tidak ditanggapinya permintaan informasi</li>";
											
											}
											else {

											$view .= "<li><input name='daftar-alasan[$i][2]' type='hidden' value='0'><input name='daftar-alasan[$i][2]' type='checkbox' value='1'> &nbsp; (c) &nbsp;Tidak ditanggapinya permintaan informasi</li>";

											}

											if ($documents[0]['CAP_LAY_KEB_DOC_D'] == 1) {

											$view .= "<li><input name='daftar-alasan[$i][3]' type='hidden' value='0'><input name='daftar-alasan[$i][3]' checked type='checkbox' value='1'> &nbsp; (d) &nbsp;Tidak ditanggapi sebagaimana yang diminta</li>";
											
											}
											else {

											$view .= "<li><input name='daftar-alasan[$i][3]' type='hidden' value='0'><input name='daftar-alasan[$i][3]' type='checkbox' value='1'> &nbsp; (d) &nbsp;Tidak ditanggapi sebagaimana yang diminta</li>";

											}

											if ($documents[0]['CAP_LAY_KEB_DOC_E'] == 1) {

											$view .= "<li><input name='daftar-alasan[$i][4]' type='hidden' value='0'><input name='daftar-alasan[$i][4]' checked type='checkbox' value='1'> &nbsp; (e) &nbsp;Tidak dipenuhinya permintaan informasi</li>";
											
											}
											else {

											$view .= "<li><input name='daftar-alasan[$i][4]' type='hidden' value='0'><input name='daftar-alasan[$i][4]' type='checkbox' value='1'> &nbsp; (e) &nbsp;Tidak dipenuhinya permintaan informasi</li>";

											}

											if ($documents[0]['CAP_LAY_KEB_DOC_F'] == 1) {

											$view .= "<li><input name='daftar-alasan[$i][5]' type='hidden' value='0'><input name='daftar-alasan[$i][5]' checked type='checkbox' value='1'> &nbsp; (f) &nbsp;Pengenaan biaya yang tidak wajar</li>";
											
											}
											else {

											$view .= "<li><input name='daftar-alasan[$i][5]' type='hidden' value='0'><input name='daftar-alasan[$i][5]' type='checkbox' value='1'> &nbsp; (f) &nbsp;Pengenaan biaya yang tidak wajar</li>";

											}

											if ($documents[0]['CAP_LAY_KEB_DOC_G'] == 1) {

											$view .= "<li><input name='daftar-alasan[$i][6]' type='hidden' value='0'><input name='daftar-alasan[$i][6]' checked type='checkbox' value='1'> &nbsp; (g) &nbsp;Penyampaian informasi melebihi waktu yang diatur dalam Undang-Undang</li>";
											
											}
											else {

											$view .= "<li><input name='daftar-alasan[$i][6]' type='hidden' value='0'><input name='daftar-alasan[$i][6]' type='checkbox' value='1'> &nbsp; (g) &nbsp;Penyampaian informasi melebihi waktu yang diatur dalam Undang-Undang</li>";

											}

										$view .= "</div>";
								
								$view .= "</div>";
								
								$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
								
									$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Alasan Pengajuan Keberatan</div>";
														
									$view .= "<div><textarea name='notes[$i]' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-textarea' readonly='true'>".$documents[0]['CAP_LAY_KEB_DOC_NOTES']."</textarea></div>";
								
								$view .= "</div>";

								$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
								
									$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Tanggapan</div>";
														
									$view .= "<div><textarea name='tanggapan[$i]' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-textarea'>".$documents[0]['CAP_LAY_KEB_DOC_RESPONSE']."</textarea></div>";
								
								$view .= "</div>";

								$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
									
									$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Respon Pemohon</div>";
															
									$view .= "<div><textarea name='respon-pemohon[$i]' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-textarea' readonly='true'>".$documents[0]['CAP_LAY_KEB_DOC_RESPONSE_U']."</textarea></div>";
									
								$view .= "</div>";
											
							$view .= "</div>";

							$i++;
							
							}
						
						}
				
				}
			
			}
			
			$view .= "</div>";
			
			$view .= "</div>";
						
			$view .= "<input style='margin-left:5px; margin-top:5px;' class='layan-normal-create-keberatan' type='submit' value='Update Keberatan'>";
			
			$view .= "</form>";
			
			$view .= "</div>";

			$holidayDate = $this->getHolidayDate(date("Y-m-d"),date("Y-12-31"));

				if (!empty($holidayDate)) {

					foreach ($holidayDate as $value) {

						$holidayArray [] = date("Y-m-d",strtotime($value['CAP_LAY_CAL_DATE']));

					}

				}

				$AddHoliday = count($holidayArray);

				$time = new time(null);

				$endDate = $time->addDays(strtotime(date("Y-m-d")),30+$AddHoliday,array("Saturday", "Sunday"),$holidayArray);

				$endDate = date("Y-m-d",$endDate);

				unset($holidayArray);

				if (!empty($holidayDate)) {

					foreach ($holidayDate as $value) {

						if (strtotime($value['CAP_LAY_CAL_DATE']) > strtotime($endDate)) {

							break;

						} 

						$weekDay = date('w', strtotime($value['CAP_LAY_CAL_DATE']));

						if ($weekDay != 0 && $weekDay != 6) {

							$holidayArray [] = date("Y-m-d",strtotime($value['CAP_LAY_CAL_DATE']));

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

			$numberOfDays = $time->getWorkingDays(date("Y-m-d"),$endDate,$holidayArray);

			$dateA = new DateTime(date("Y-m-d"));
					
			$dateB = new DateTime($endDate);
			
			$intervalA = $dateA->diff($dateB);
			
			$maxDate = $intervalA->days;

			$_SESSION['LAYAN-KEBERATAN-MAX-DATE'] = date("Y-m-d",strtotime("+".$maxDate."day".date("Y-m-d")));

			$view .= "

			<script type='text/javascript'>

				jQuery.noConflict()(function($){

					$(document).ready(function() {

						var IndonesianHoliday = [$IndonesianHoliday];

						$('.layan-admin_perpanjangan_create-dokumen-biaya-form-input-full').datepicker({ 
						dateFormat: 'dd-mm-yy',
						minDate: 0, 
						maxDate: '+".$maxDate."D',
						beforeShowDay: function(date) {
								            
						var showDay = true;
								            
						// disable sunday and saturday
						if (date.getDay() == 0 || date.getDay() == 6) {
							showDay = false;
					    }
								            			            
						// jquery in array function
						if ($.inArray(date.getTime(), IndonesianHoliday) > -1) {
							showDay = false;
						}
								            
								            
							return [showDay];
						},
						onSelect: function(dateText, inst) { 
							$('.layan-admin_perpanjangan_create-dokumen-biaya-form-input-full').val(dateText);
							$('.layan-admin_perpanjangan_create-dokumen-biaya-form-input-full').attr('value',dateText);
						}

					});

				});

			});
			</script>

			";
			
		echo $view;
		
	}

	public function user_keberatan() {
		
		$this->data = base64_decode($_GET['ref']); 
		
			if (!empty($_SESSION['LAYAN-PERMOHONAN'])) {
		
				$post = $this->updatePermohonan($_SESSION['LAYAN-PERMOHONAN']);
				
				unset($_SESSION['LAYAN-PERMOHONAN']);
				
			}
		
		$data = $this->getKeberatanLengkap();
		
		$ch   = $this->getDokumenLengkap();
								
			$view  = "<div class='layan-normal-form-container'>";
						
			$view .= $this->optionGear;
			
			$view .= "<div class='layan-permohonan-upper-menu-container'>";
			
				if ($ch['CAP_LAY_FINALSTATUS'] == 5) {

				$view .= "<div class='layan-permohonan-icons-container' rel='keberatan'>
								<div class='layan-pemberitahuan-float-left-print-keberatan qtip-upper' text='Print Keberatan'></div>
						  </div>";
						  
				}
				else {
				
				$view .= "<div class='layan-permohonan-icons-container' rel='keberatan'>
							<a href='index.php?id=2284&ref=".$_GET['ref']."'>
								<div class='layan-admin_pemberitahuan-float-left-add-permohonan qtip-upper' text='Create Keberatan'></div>
						 	</a>
						 	<a href='index.php?id=2285&ref=".$_GET['ref']."'>
								<div class='layan-admin_pemberitahuan-float-left-edit-permohonan qtip-upper' text='Edit Keberatan'></div>
							</a>
								<div class='layan-admin_pemberitahuan-float-left-print-permohonan qtip-upper' text='Delete Keberatan'></div>
								<div class='layan-pemberitahuan-float-left-print-keberatan qtip-upper' text='Print Keberatan'></div>
						  </div>";
				
				}
			
			$view .= "</div>";

			$view .= "<form name='layan-permohonan-update' action='library/capsule/layan/process/process.php' method='post'>";
			
				$view .= "<table class='layan-normal-table'>";
					
					$view .= "<tr>";
						
						$view .= "<td colspan='3' class='layan-normal-form-bold'><hr class='layan-normal-form-hr'></td>";
											
					$view .= "</tr>";
														
				$view .= "</table>";
							
			$view .= "</form>";
			
			$view .= "<ul class='layan-admin_pemberitahuan-ul'>";
			
				if (!empty($data)) {
			
					foreach ($data as $key => $value) {
					
					$document = $this->getKeberatanDokumen($value['CAP_LAY_KEB_ID']);

					$z = 0;

						foreach ($document as $key2 => $value2) {

							if (!empty($value2['CAP_LAY_ID'])) {

							$z++;
									
							}
							else if (!empty($value2['CAP_LAY_PEM_ID'])) {

							$z++;
									
							}
							else if (!empty($value2['CAP_LAY_PEN_ID'])) {

							$z++;
									
							}
							else if (!empty($value2['CAP_LAY_PER_ID'])) {

							$z++;
									
							}

						}
					
					if (empty($z) || empty($document[0]['CAP_LAY_KEB_DOC_ID'])) {$z = 0;}
					
					$view .= "<li><input type='checkbox' value='".$value['CAP_LAY_KEB_ID']."'> &nbsp;".$value['CAP_LAY_KEB_NUMBER']." - $z Dokumen";
					
						if (!empty($document)) {
							
							$view .= "<ul class='layan-admin_pemberitahuan-ul-secondary'>";

								foreach ($document as $key2 => $value2) {
								
									if ($ch['CAP_LAY_FINALSTATUS'] == 5) {
										
										$actionRemove = "";
										
									}
									else {
										
										$actionRemove = "(<a class='layan-admin_keberatan-delete-document-front' rel='".$value2['CAP_LAY_KEB_DOC_ID']."' href='#'>remove</a>)";
										
									}
								
									if (!empty($value2['CAP_LAY_ID'])) {

									$view .= "<li>- Permohonan No. ".ucwords(strtolower($value2['CAP_LAY_TRANSACTIONID']))." $actionRemove</li>";
									
									}
									else if (!empty($value2['CAP_LAY_PEM_ID'])) {

									$view .= "<li>- Pemberitahuan No. ".ucwords(strtolower($value2['CAP_LAY_PEM_NUMBER']))." $actionRemove</li>";
									
									}
									else if (!empty($value2['CAP_LAY_PEN_ID'])) {

									$view .= "<li>- Penolakan No. ".ucwords(strtolower($value2['CAP_LAY_PEN_NUMBER']))." $actionRemove</li>";
									
									}
									else if (!empty($value2['CAP_LAY_PER_ID'])) {

									$view .= "<li>- Perpanjangan No. ".ucwords(strtolower($value2['CAP_LAY_PER_NUMBER']))." $actionRemove</li>";
									
									}


								}
							
							$view .= "</ul>";
							
						}

					$view .= "</li>";
					
					}
				
				}
			
			$view .= "</ul>";
			
			$view .= "</div>";
			
		echo $view;
		
	}

	public function user_keberatan_create() {
		
		$this->data = base64_decode($_GET['ref']);
		
			if (!empty($_SESSION['LAYAN-PERMOHONAN'])) {
		
				$post = $this->createKeberatan($_SESSION['LAYAN-PERMOHONAN']);

				unset($_SESSION['LAYAN-PERMOHONAN']);
				
			}

			if (!empty($_SESSION['LAYAN-ERROR'])) {

				$errorAnnouncement  = "<div class='layan-error-annoucement'>";

				foreach ($_SESSION['LAYAN-ERROR'] as $key => $value) {
					
					$errorAnnouncement .= "<li>- $value</li>"; 

				}

				$errorAnnouncement .= "</div>";

				unset($_SESSION['LAYAN-ERROR']);

			}

		$pemohonanID = $this->getDokumenLengkap();
		
		$data ['permohonan'] = $this->getPermohonanLengkap();
		
		$data ['pemberitahuan'] = $this->getPemberitahuanLengkap();
		
		$data ['penolakan'] = $this->getPenolakanLengkap();
		
		$data ['perpanjangan'] = $this->getPerpanjanganLengkap();
		
		$tipePemohon = $this->getTipePemohon();
		
		$information = $this->getInformation();
		
		$salinan	 = $this->getSalinan();
				
		$document  = $this->getDocument($this->data);

			$view  = "<div class='layan-normal-form-container'>";
						
			$view .= $this->optionGear;
						
			$view .= "<input class='layan-drill-down-menu' type='hidden' value='1989'>";
			
			$view .= "<div class='layan-permohonan-upper-menu-container'>";

			$view .= "<div class='layan-permohonan-icons-container'><a href='index.php?id=1989&ref=".$_GET['ref']."'><div class='layan-admin_pemberitahuan_create-float-left-edit-permohonan qtip-upper' text='Back'></div></a></div>";
			
			$view .= "<div class='layan-permohonan-icons-container-right'>Create Keberatan</div>";

			$view .= "</div>";

			$view .= "<form id='layan-keberatan-create' name='layan-permintaan-create' action='library/capsule/layan/process/process.php' method='post' autocomplete='off'>";
			
				$view .= "<table class='layan-normal-table'>";
					
					$view .= "<tr>";
						
						$view .= "<td colspan='3' class='layan-normal-form-bold'><hr class='layan-normal-form-hr'></td>";
											
					$view .= "</tr>";
														
				$view .= "</table>";

			$view .= $errorAnnouncement;
			
			$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-container'>";
			
			$view .= "<div class='layan-admin_pemberitahuan_create-dokumen'>";
			
				$view .= "<ul style='margin:0;padding:0;'>";
				
				if (!empty($data)) {

				$i = 0;

					foreach ($data as $key2 => $value2) {
					
						if (!empty($value2)) {
					
							foreach ($value2 as $key => $value) {
							
							unset($documents);
							
								if (!empty($value['CAP_LAY_PEM_ID'])) {
								
								$time  = $this->getTimeByTable('CAP_LAY_PEM_DATECREATED',"CAP_LAYAN_PEMBERITAHUAN WHERE CAP_LAY_PEM_ID = '".$value['CAP_LAY_PEM_ID']."'");

								}
								else if (!empty($value['CAP_LAY_PEN_ID'])) {
	
								$time  = $this->getTimeByTable('CAP_LAY_PEN_DATECREATED',"CAP_LAYAN_PENOLAKAN WHERE CAP_LAY_PEN_ID = '".$value['CAP_LAY_PEN_ID']."'");
									
								}
								else if (!empty($value['CAP_LAY_PER_ID'])) {
	
								$time  = $this->getTimeByTable('CAP_LAY_PER_DATECREATED',"CAP_LAYAN_PERPANJANGAN WHERE CAP_LAY_PER_ID = '".$value['CAP_LAY_PER_ID']."'");
									
								}
								else {
								
								$time  = $this->getTimeByTable('CAP_LAY_DATECREATED',"CAP_LAYAN WHERE CAP_LAY_ID = '".$value['CAP_LAY_ID']."'");
								
								}
								
								//$time  = $this->getTimeByTable('CAP_LAY_PEM_DATECREATED',"CAP_LAYAN_PEMBERITAHUAN WHERE CAP_LAY_PEM_ID = '".$value['CAP_LAY_PEM_ID']."'");
								
								$dateTime = $this->getCurrentHolidayDateTimeDashboard(date("Y-m-d"),date("Y-m-d",strtotime($time['DATETIME'])));

								$dateTime2 =  strtotime ( '-'.$dateTime.' day' . date("Y-m-d H:i:s") );
								
								$date1 = new DateTime($time['DATETIME']);
								
								$date3 = date("Y-m-d H:i:s",$dateTime2);
								
								$date2 = new DateTime($date3);
								
								$interval = $date1->diff($date2);
								    
								$days = $interval->days;
								
								if (!empty($value['CAP_LAY_PEM_ID'])) {
								
								$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_PEM_ID'],'pemberitahuan');

									if (empty($documents)) {

										if ($days > 30) {

										$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' disabled='disabled' type='checkbox' value='pemberitahuan".$value['CAP_LAY_PEM_ID']."'> &nbsp; Pemberitahuan ".$value['CAP_LAY_PEM_NUMBER']."</li>";
										
										}
										else {
											
										$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='pemberitahuan".$value['CAP_LAY_PEM_ID']."'> &nbsp; Pemberitahuan ".$value['CAP_LAY_PEM_NUMBER']."</li>";
											
										}

									}
									else {
									
									$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' disabled='disabled' type='checkbox' value='pemberitahuan".$value['CAP_LAY_PEM_ID']."'> &nbsp; Pemberitahuan ".$value['CAP_LAY_PEM_NUMBER']."</li>";

									}
									
								}
								else if (!empty($value['CAP_LAY_PEN_ID'])) {

									$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_PEN_ID'],'penolakan');
									
									if (empty($documents)) {
									
										if ($days > 30) {

										$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' disabled='disabled' type='checkbox' value='penolakan".$value['CAP_LAY_PEN_ID']."'> &nbsp; Penolakan ".$value['CAP_LAY_PEN_NUMBER']."</li>";	
										
										}
										else {
											
										$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='penolakan".$value['CAP_LAY_PEN_ID']."'> &nbsp; Penolakan ".$value['CAP_LAY_PEN_NUMBER']."</li>";
											
										}

									}
									else {

									$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' disabled='disabled' type='checkbox' value='penolakan".$value['CAP_LAY_PEN_ID']."'> &nbsp; Penolakan ".$value['CAP_LAY_PEN_NUMBER']."</li>";

									}
									
								}
								else if (!empty($value['CAP_LAY_PER_ID'])) {
									
									$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_PER_ID'],'perpanjangan');

									if (empty($documents)) {
										
										if ($days > 30) {
										
										$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' disabled='disabled' type='checkbox' value='perpanjangan".$value['CAP_LAY_PER_ID']."'> &nbsp; Perpanjangan ".$value['CAP_LAY_PER_NUMBER']."</li>";
									
										}
										else {
											
										$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='perpanjangan".$value['CAP_LAY_PER_ID']."'> &nbsp; Perpanjangan ".$value['CAP_LAY_PER_NUMBER']."</li>";	
											
										}

									}
									else {

									$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' disabled='disabled' type='checkbox' value='perpanjangan".$value['CAP_LAY_PER_ID']."'> &nbsp; Perpanjangan ".$value['CAP_LAY_PER_NUMBER']."</li>";

									}
									
								}
								else {

									$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_ID'],'permohonan');
									
									if (empty($documents)) {

										if ($days > 30) {
										
										$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' disabled='disabled' type='checkbox' value='permohonan".$value['CAP_LAY_ID']."'> &nbsp; Permohonan ".$value['CAP_LAY_TRANSACTIONID']."</li>";
										
										}
										else {
											
										$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='permohonan".$value['CAP_LAY_ID']."'> &nbsp; Permohonan ".$value['CAP_LAY_TRANSACTIONID']."</li>";
											
										}

									}
									else {

										$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' disabled='disabled' type='checkbox' value='permohonan".$value['CAP_LAY_ID']."'> &nbsp; Permohonan ".$value['CAP_LAY_TRANSACTIONID']."</li>";

									}
								
								}
														
							$i++;
								
							}
						
						}
											
					}
					
				}
				
				$view .= "</ul>";
			
			$view .= "</div>";
			
			$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab'>";

			if (!empty($data)) {
			
			$i = 0;

				foreach ($data as $key2 => $value2) {
					
					if (!empty($value2)) {
					
						foreach ($value2 as $key => $value) {
						
						unset($documents);

								if (!empty($value['CAP_LAY_PEM_ID'])) {
								
								$numberID = "pemberitahuan".$value['CAP_LAY_PEM_ID'];
								$headerID = "Pemberitahuan No. ".$value['CAP_LAY_PEM_NUMBER'];
								$time  = $this->getTimeByTable('CAP_LAY_PEM_DATECREATED',"CAP_LAYAN_PEMBERITAHUAN WHERE CAP_LAY_PEM_ID = '".$value['CAP_LAY_PEM_ID']."'");
								$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_PEM_ID'],'pemberitahuan');

								}
								else if (!empty($value['CAP_LAY_PEN_ID'])) {
	
								$numberID = "penolakan".$value['CAP_LAY_PEN_ID'];
								$headerID = "Penolakan No. ".$value['CAP_LAY_PEN_NUMBER'];
								$time  = $this->getTimeByTable('CAP_LAY_PEN_DATECREATED',"CAP_LAYAN_PENOLAKAN WHERE CAP_LAY_PEN_ID = '".$value['CAP_LAY_PEN_ID']."'");
								$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_PEN_ID'],'penolakan');
									
								}
								else if (!empty($value['CAP_LAY_PER_ID'])) {
	
								$numberID = "perpanjangan".$value['CAP_LAY_PER_ID'];
								$headerID = "Perpanjangan No. ".$value['CAP_LAY_PER_NUMBER'];
								$time  = $this->getTimeByTable('CAP_LAY_PER_DATECREATED',"CAP_LAYAN_PERPANJANGAN WHERE CAP_LAY_PER_ID = '".$value['CAP_LAY_PER_ID']."'");
								$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_PER_ID'],'perpanjangan');
									
								}
								else {
								
								$numberID = "permohonan".$value['CAP_LAY_ID'];
								$headerID = "Permohonan No. ".$value['CAP_LAY_TRANSACTIONID'];
								$time  = $this->getTimeByTable('CAP_LAY_DATECREATED',"CAP_LAYAN WHERE CAP_LAY_ID = '".$value['CAP_LAY_ID']."'");
								$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_ID'],'permohonan');
								
								}

							$dateTime = $this->getCurrentHolidayDateTimeDashboard(date("Y-m-d"),date("Y-m-d",strtotime($time['DATETIME'])));

							$dateTime2 =  strtotime ( '-'.$dateTime.' day' . date("Y-m-d H:i:s") );
							
							$date1 = new DateTime($time['DATETIME']);
							
							$date3 = date("Y-m-d H:i:s",$dateTime2);
							
							$date2 = new DateTime($date3);
							
							$interval = $date1->diff($date2);
							
							$years = $interval->format('%y');
							    
							$months = $interval->format('%m');
							    
							$days = $interval->format('%d'); 
							    
							$hour = $interval->format('%H'); 
							    
							$minute = $interval->format('%i'); 
							    
							$second = $interval->format('%s');

							unset($waktu);
		    
							if ($years != 0) {
							    $waktu  = $years." Tahun ";
						    }
						    if ($months != 0) {
							    $waktu  .= $months." Bulan ";
						    }
							if ($days != 0) {
							    $waktu  .= $days." Hari ";
						    }
						    if ($hour != 0) {
							   	$waktu .= $hour." Jam ";
						    }
						    if ($minute != 0) {
							   	$waktu .= $minute." Menit ";
						    }
						    if ($second != 0) {
							   	$waktu .= $second." Detik ";
						    }

							if ($days > 30) {

									$view .= "<div document='".$numberID."' class='layan-admin_pemberitahuan_create-dokumen-tab-inside displayNone'>";
							
									$view .= "<input name='tinggi-dokumen[$i]' class='layan-original-height' type='hidden' value='0'>";
										
										$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top full-width'>";
										
											$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header'>".$headerID."</div>";
										
											$view .= "<div>Dokumen ini sudah melebihi jangka waktu 30 hari sejak diciptakan. Dan oleh karenanya sesuai dengan UU No. 14 tahun 2008 tentang keterbukaan informasi publik pasal 35, dokumen ini sudah tidak dapat di lakukan keberatan.</div>";
										
										$view .= "</div>";
									
									$view .= "</div>";
							
							$i++;
			
							continue;
							
							}
							else if (!empty($documents)) {

								$view .= "<div document='".$numberID."' class='layan-admin_pemberitahuan_create-dokumen-tab-inside displayNone'>";
							
									$view .= "<input name='tinggi-dokumen[$i]' class='layan-original-height' type='hidden' value='0'>";
										
										$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top full-width'>";
										
											$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header'>".$headerID."</div>";
										
											$view .= "<div>Dokumen ini sudah pernah diberatkan dalam keberatan no. ".$documents[0]['CAP_LAY_KEB_NUMBER']." sebelumnya dan oleh karenanya tidak dapat diberatkan lagi.</div>";
										
										$view .= "</div>";
									
									$view .= "</div>";
							
							$i++;
			
							continue;

							}							
							
							$view .= "<div document='".$numberID."' class='layan-admin_pemberitahuan_create-dokumen-tab-inside displayNone'>";
							
							$view .= "<input class='layan-original-height' type='hidden' value='0'>";

							$view .= "<input name='permohonan-ID' type='hidden' value='".base64_encode($pemohonanID['CAP_LAY_TRANSACTIONID'])."'>";
								
								$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top full-width'>";
								
									$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header'>".$headerID."</div>";
									
									$view .= "<div>".$waktu."</div>";
													
								$view .= "</div>";
								
								$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top' style='display:none;'>";
								
									$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Penyelesaian</div>";
														
									$view .= "<div>";
									
										$view .= "<select name='penyelesaian-keberatan' class='layan-keberatan-select-finish'>";
										
											$view .= "<option selected='selected' value='0'>Pilih Penyelesaian</option>";
										
											$view .= "<option value='1'>Selesai Secara Internal</option>";
											
											$view .= "<option value='2'>Sengketa di Komisi Informasi</option>";
										
										$view .= "</select>";
									
									$view .= "</div>";
								
								$view .= "</div>";
								
								$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
								
									$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Nama</div>";
														
									$view .= "<div><input name='nama-kuasa' type='text' class='layan-admin_perpanjangan_create-dokumen-biaya-form-input-full-kuasa-pemohon' placeholder='Nama Lengkap Kuasa Pemohon'></div>";
								
								$view .= "</div>";

								$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
								
									$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Alamat</div>";
														
									$view .= "<div><input name='alamat-kuasa' type='text' class='layan-admin_perpanjangan_create-dokumen-biaya-form-input-full-alamat-pemohon' placeholder='Alamat Lengkap Kuasa Pemohon'></div>";
								
								$view .= "</div>";

								$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top' style='display:none;'>";
								
									$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Tanggal Tanggapan</div>";
														
									$view .= "<div><input name='tanggal-keberatan' type='text' class='layan-admin_perpanjangan_create-dokumen-biaya-form-input-full' placeholder='Tanggal'></div>";
								
								$view .= "</div>";
								
								$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top' style='display:none;'>";
								
									$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Daftar Alasan</div>";
														
										$view .= "<div>";
										
											$view .= "<li><input name='daftar-alasan[$i][0]' type='hidden' value='0'><input name='daftar-alasan[$i][0]' type='checkbox' value='1'> &nbsp; (a) &nbsp;Alasan pengecualian pasal 17 UU No. 14 tahun 2008</li>";
											
											$view .= "<li><input name='daftar-alasan[$i][1]' type='hidden' value='0'><input name='daftar-alasan[$i][1]' type='checkbox' value='1'> &nbsp; (b) &nbsp;Tidak disediakan informasi berkala</li>";
											
											$view .= "<li><input name='daftar-alasan[$i][2]' type='hidden' value='0'><input name='daftar-alasan[$i][2]' type='checkbox' value='1'> &nbsp; (c) &nbsp;Tidak ditanggapinya permintaan informasi</li>";
											
											$view .= "<li><input name='daftar-alasan[$i][3]' type='hidden' value='0'><input name='daftar-alasan[$i][3]' type='checkbox' value='1'> &nbsp; (d) &nbsp;Tidak ditanggapi sebagaimana yang diminta</li>";
											
											$view .= "<li><input name='daftar-alasan[$i][4]' type='hidden' value='0'><input name='daftar-alasan[$i][4]' type='checkbox' value='1'> &nbsp; (e) &nbsp;Tidak dipenuhinya permintaan informasi</li>";
											
											$view .= "<li><input name='daftar-alasan[$i][5]' type='hidden' value='0'><input name='daftar-alasan[$i][5]' type='checkbox' value='1'> &nbsp; (f) &nbsp;Pengenaan biaya yang tidak wajar</li>";
											
											$view .= "<li><input name='daftar-alasan[$i][6]' type='hidden' value='0'><input name='daftar-alasan[$i][6]' type='checkbox' value='1'> &nbsp; (g) &nbsp;Penyampaian informasi melebihi waktu yang diatur dalam Undang-Undang</li>";
										
										$view .= "</div>";
								
								$view .= "</div>";
								
								$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
								
									$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Alasan Pengajuan Keberatan</div>";
														
									$view .= "<div><textarea name='notes[$i]' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-textarea'></textarea></div>";
								
								$view .= "</div>";

								$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top' style='display:none;'>";
								
									$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Tanggapan</div>";
														
									$view .= "<div><textarea name='tanggapan[$i]' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-textarea'>".$documents[0]['CAP_LAY_KEB_DOC_NOTES']."</textarea></div>";
								
								$view .= "</div>";

								$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top' style='display:none;'>";
									
									$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Respon Pemohon</div>";
															
									$view .= "<div><textarea name='respon-pemohon[$i]' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-textarea'>".$documents[0]['CAP_LAY_KEB_DOC_NOTES']."</textarea></div>";
									
								$view .= "</div>";
											
							$view .= "</div>";

							$i++;
							
							}
						
						}
				
				}
			
			}
			
			$view .= "</div>";
			
			$view .= "</div>";
						
			$view .= "<input style='margin-left:5px; margin-top:5px;' class='layan-normal-create-keberatan' type='submit' value='Create Keberatan'>";
			
			$view .= "</form>";
			
			$view .= "</div>";

			$holidayDate = $this->getHolidayDate(date("Y-m-d"),date("Y-12-31"));

				if (!empty($holidayDate)) {

					foreach ($holidayDate as $value) {

						$holidayArray [] = date("Y-m-d",strtotime($value['CAP_LAY_CAL_DATE']));

					}

				}

				$AddHoliday = count($holidayArray);

				$time = new time(null);

				$endDate = $time->addDays(strtotime(date("Y-m-d")),30+$AddHoliday,array("Saturday", "Sunday"),$holidayArray);

				$endDate = date("Y-m-d",$endDate);

				unset($holidayArray);

				if (!empty($holidayDate)) {

					foreach ($holidayDate as $value) {

						if (strtotime($value['CAP_LAY_CAL_DATE']) > strtotime($endDate)) {

							break;

						} 

						$weekDay = date('w', strtotime($value['CAP_LAY_CAL_DATE']));

						if ($weekDay != 0 && $weekDay != 6) {

							$holidayArray [] = date("Y-m-d",strtotime($value['CAP_LAY_CAL_DATE']));

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

			$numberOfDays = $time->getWorkingDays(date("Y-m-d"),$endDate,$holidayArray);

			$dateA = new DateTime(date("Y-m-d"));
					
			$dateB = new DateTime($endDate);
			
			$intervalA = $dateA->diff($dateB);
			
			$maxDate = $intervalA->days;

			$_SESSION['LAYAN-KEBERATAN-MAX-DATE'] = date("Y-m-d",strtotime("+".$maxDate."day".date("Y-m-d")));

			$view .= "

			<script type='text/javascript'>

				jQuery.noConflict()(function($){

					$(document).ready(function() {

						var IndonesianHoliday = [$IndonesianHoliday];

						$('.layan-admin_perpanjangan_create-dokumen-biaya-form-input-full').datepicker({ 
						dateFormat: 'dd-mm-yy',
						minDate: 0, 
						maxDate: '+".$maxDate."D',
						beforeShowDay: function(date) {
								            
						var showDay = true;
								            
						// disable sunday and saturday
						if (date.getDay() == 0 || date.getDay() == 6) {
							showDay = false;
					    }
								            			            
						// jquery in array function
						if ($.inArray(date.getTime(), IndonesianHoliday) > -1) {
							showDay = false;
						}
								            
								            
							return [showDay];
						},
						onSelect: function(dateText, inst) { 
							$('.layan-admin_perpanjangan_create-dokumen-biaya-form-input-full').val(dateText);
							$('.layan-admin_perpanjangan_create-dokumen-biaya-form-input-full').attr('value',dateText);
						}

					});

				});

			});
			</script>

			";
			
		echo $view;
		
	}

	public function user_keberatan_edit() {
		
		$this->data = base64_decode($_GET['ref']); 

		$registrar  = base64_decode($_GET['reg']);

			if (!empty($_SESSION['LAYAN-PERMOHONAN'])) {

				$post = $this->updateKeberatan($_SESSION['LAYAN-PERMOHONAN']);

				unset($_SESSION['LAYAN-PERMOHONAN']);
				
			}

			if (!empty($_SESSION['LAYAN-ERROR'])) {

				$errorAnnouncement  = "<div class='layan-error-annoucement'>";

				foreach ($_SESSION['LAYAN-ERROR'] as $key => $value) {
					
					$errorAnnouncement .= "<li>- $value</li>"; 

				}

				$errorAnnouncement .= "</div>";

				unset($_SESSION['LAYAN-ERROR']);

			}
		
		$pemohonanID = $this->getDokumenLengkap();
		
		$data ['permohonan'] = $this->getPermohonanLengkap();
		
		$data ['pemberitahuan'] = $this->getPemberitahuanLengkap();
		
		$data ['penolakan'] = $this->getPenolakanLengkap();
		
		$data ['perpanjangan'] = $this->getPerpanjanganLengkap();
		
		$tipePemohon = $this->getTipePemohon();
		
		$information = $this->getInformation();
		
		$salinan	 = $this->getSalinan();
						
		$document = $this->getDocument($this->data);

		$keberatan = $this->getKeberatanByID($registrar);

		$documentList  = $this->getKeberatanDocumentlistByID($registrar);

			$view  = "<div class='layan-normal-form-container'>";
						
			$view .= $this->optionGear;
						
			$view .= "<input class='layan-drill-down-menu' type='hidden' value='1989'>";
			
			$view .= "<div class='layan-permohonan-upper-menu-container'>";

			$view .= "<div class='layan-permohonan-icons-container'><a href='index.php?id=1989&ref=".$_GET['ref']."'><div class='layan-admin_pemberitahuan_create-float-left-edit-permohonan qtip-upper' text='Back'></div></a></div>";
			
			$view .= "<div class='layan-permohonan-icons-container-right'>Edit Keberatan No. ".$keberatan[0]['CAP_LAY_KEB_NUMBER']."</div>";

			$view .= "</div>";

			$view .= "<form id='layan-keberatan-create' name='layan-permintaan-create' action='library/capsule/layan/process/process.php' method='post' autocomplete='off'>";
			
				$view .= "<table class='layan-normal-table'>";

					$view .= "<tr>";

						$view .= "<td colspan='3' class='layan-normal-form-bold'><hr class='layan-normal-form-hr'></td>";
											
					$view .= "</tr>";
														
				$view .= "</table>";
			
			$view .= $errorAnnouncement;

			$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-container'>";
			
			$view .= "<div class='layan-admin_pemberitahuan_create-dokumen'>";
			
				$view .= "<ul style='margin:0;padding:0;'>";

				if (!empty($data)) {

				$i = 0;

					foreach ($data as $key2 => $value2) {
					
						if (!empty($value2)) {
					
							foreach ($value2 as $key => $value) {
							
							unset($documents);

								if (!empty($value['CAP_LAY_PEM_ID'])) {

								$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_PEM_ID'],'pemberitahuan');

									if (is_array($documentList)) {

										if (is_array($documentList['pemberitahuan'])) {

											if (in_array($value['CAP_LAY_PEM_ID'], $documentList['pemberitahuan'])) {

												$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' checked type='checkbox' value='pemberitahuan".$value['CAP_LAY_PEM_ID']."'> &nbsp; Pemberitahuan ".$value['CAP_LAY_PEM_NUMBER']."</li>";

											}
											else {
												$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='pemberitahuan".$value['CAP_LAY_PEM_ID']."'> &nbsp; Pemberitahuan ".$value['CAP_LAY_PEM_NUMBER']."</li>";
											}

										}
										else {

											if (!empty($documents) && $keberatan[0]['CAP_LAY_KEB_ID'] != $documents[0]['FK_CAP_LAY_KEB_ID']) {

											$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' disabled='disabled' type='checkbox' value='pemberitahuan".$value['CAP_LAY_PEM_ID']."'> &nbsp; Pemberitahuan ".$value['CAP_LAY_PEM_NUMBER']."</li>";

											}
											else {

											$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='pemberitahuan".$value['CAP_LAY_PEM_ID']."'> &nbsp; Pemberitahuan ".$value['CAP_LAY_PEM_NUMBER']."</li>";

											}

										}

									}
									else {

										$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_PEM_ID'],'pemberitahuan');

										if (empty($documents)) {

										$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='pemberitahuan".$value['CAP_LAY_PEM_ID']."'> &nbsp; Pemberitahuan ".$value['CAP_LAY_PEM_NUMBER']."</li>";

										}
										else {

										$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' disabled='disabled' type='checkbox' value='pemberitahuan".$value['CAP_LAY_PEM_ID']."'> &nbsp; Pemberitahuan ".$value['CAP_LAY_PEM_NUMBER']."</li>";

										}

									}
										
								}
								else if (!empty($value['CAP_LAY_PEN_ID'])) {
								
								$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_PEN_ID'],'penolakan');

									if (is_array($documentList)) {

										if (is_array($documentList['penolakan'])) {

											if (in_array($value['CAP_LAY_PEN_ID'], $documentList['penolakan'])) {

												$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' checked type='checkbox' value='penolakan".$value['CAP_LAY_PEN_ID']."'> &nbsp; Penolakan ".$value['CAP_LAY_PEN_NUMBER']."</li>";

											}
											else {
												$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='penolakan".$value['CAP_LAY_PEN_ID']."'> &nbsp; Penolakan ".$value['CAP_LAY_PEN_NUMBER']."</li>";
											}

										}
										else {

											if (!empty($documents) && $keberatan[0]['CAP_LAY_KEB_ID'] != $documents[0]['FK_CAP_LAY_KEB_ID']) {

											$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' disabled='disabled' type='checkbox' value='penolakan".$value['CAP_LAY_PEN_ID']."'> &nbsp; Penolakan ".$value['CAP_LAY_PEN_NUMBER']."</li>";

											}
											else {

											$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='penolakan".$value['CAP_LAY_PEN_ID']."'> &nbsp; Penolakan ".$value['CAP_LAY_PEN_NUMBER']."</li>";

											}

										}

									}
									else {

										$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_PEN_ID'],'penolakan');

										if (empty($documents)) {

										$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='penolakan".$value['CAP_LAY_PEN_ID']."'> &nbsp; Penolakan ".$value['CAP_LAY_PEN_NUMBER']."</li>";

										}
										else {

										$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' disabled='disabled' type='checkbox' value='penolakan".$value['CAP_LAY_PEN_ID']."'> &nbsp; Penolakan ".$value['CAP_LAY_PEN_NUMBER']."</li>";

										}
										
									}		

								}
								else if (!empty($value['CAP_LAY_PER_ID'])) {
								
								$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_PER_ID'],'perpanjangan');

									if (is_array($documentList)) {

										if (is_array($documentList['perpanjangan'])) {

											if (in_array($value['CAP_LAY_PER_ID'], $documentList['perpanjangan'])) {

												$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' checked type='checkbox' value='perpanjangan".$value['CAP_LAY_PER_ID']."'> &nbsp; Perpanjangan ".$value['CAP_LAY_PER_NUMBER']."</li>";

											}
											else {
												$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='perpanjangan".$value['CAP_LAY_PER_ID']."'> &nbsp; Perpanjangan ".$value['CAP_LAY_PER_NUMBER']."</li>";
											}

										}
										else {

											if (!empty($documents) && $keberatan[0]['CAP_LAY_KEB_ID'] != $documents[0]['FK_CAP_LAY_KEB_ID']) {

											$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' disabled='disabled' type='checkbox' value='perpanjangan".$value['CAP_LAY_PER_ID']."'> &nbsp; Perpanjangan ".$value['CAP_LAY_PER_NUMBER']."</li>";

											}
											else {

											$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='perpanjangan".$value['CAP_LAY_PER_ID']."'> &nbsp; Perpanjangan ".$value['CAP_LAY_PER_NUMBER']."</li>";

											}

										}

									}
									else {

										$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_PER_ID'],'perpanjangan');

										if (empty($documents)) {

										$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='perpanjangan".$value['CAP_LAY_PER_ID']."'> &nbsp; Perpanjangan ".$value['CAP_LAY_PER_NUMBER']."</li>";

										}
										else {

										$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' disabled='disabled' type='checkbox' value='perpanjangan".$value['CAP_LAY_PER_ID']."'> &nbsp; Perpanjangan ".$value['CAP_LAY_PER_NUMBER']."</li>";

										}
										
									}

								}
								else {
								
								$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_ID'],'permohonan');

									if (is_array($documentList)) {

										if (is_array($documentList['permohonan'])) {

											if (in_array($value['CAP_LAY_ID'], $documentList['permohonan'])) {

												$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' checked type='checkbox' value='permohonan".$value['CAP_LAY_ID']."'> &nbsp; Permohonan ".$value['CAP_LAY_TRANSACTIONID']."</li>";

											}
											else {
												$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='permohonan".$value['CAP_LAY_ID']."'> &nbsp; Permohonan ".$value['CAP_LAY_TRANSACTIONID']."</li>";
											}

										}
										else {

											if (!empty($documents) && $keberatan[0]['CAP_LAY_KEB_ID'] != $documents[0]['FK_CAP_LAY_KEB_ID']) {

											$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' disabled='disabled' type='checkbox' value='permohonan".$value['CAP_LAY_ID']."'> &nbsp; Permohonan ".$value['CAP_LAY_TRANSACTIONID']."</li>";

											}
											else {

											$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='permohonan".$value['CAP_LAY_ID']."'> &nbsp; Permohonan ".$value['CAP_LAY_TRANSACTIONID']."</li>";

											}

										}

									}
									else {

										$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_ID'],'permohonan');

										if (empty($documents)) {

										$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' type='checkbox' value='permohonan".$value['CAP_LAY_ID']."'> &nbsp; Permohonan ".$value['CAP_LAY_TRANSACTIONID']."</li>";

										}
										else {

										$view .= "<li class='layan-admin_pemberitahuan-dokumen-list'><input name='id[$i]' disabled='disabled' type='checkbox' value='permohonan".$value['CAP_LAY_ID']."'> &nbsp; Permohonan ".$value['CAP_LAY_TRANSACTIONID']."</li>";

										}
										
									}

								}
														
							$i++;
								
							}
						
						}
											
					}
					
				}
				
				$view .= "</ul>";
			
			$view .= "</div>";
			
			$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab'>";
			
			if (!empty($data)) {
			
			$i = 0;

				foreach ($data as $key2 => $value2) {
					
					if (!empty($value2)) {
					
						foreach ($value2 as $key => $value) {
						
						unset($documents);

								if (!empty($value['CAP_LAY_PEM_ID'])) {
								
								$numberID = "pemberitahuan".$value['CAP_LAY_PEM_ID'];
								$headerID = "Pemberitahuan No. ".$value['CAP_LAY_PEM_NUMBER'];
								$time  = $this->getTimeByTable('CAP_LAY_PEM_DATECREATED',"CAP_LAYAN_PEMBERITAHUAN WHERE CAP_LAY_PEM_ID = '".$value['CAP_LAY_PEM_ID']."'");
								$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_PEM_ID'],'pemberitahuan');
									
								}
								else if (!empty($value['CAP_LAY_PEN_ID'])) {
	
								$numberID = "penolakan".$value['CAP_LAY_PEN_ID'];
								$headerID = "Penolakan No. ".$value['CAP_LAY_PEN_NUMBER'];
								$time  = $this->getTimeByTable('CAP_LAY_PEN_DATECREATED',"CAP_LAYAN_PENOLAKAN WHERE CAP_LAY_PEN_ID = '".$value['CAP_LAY_PEN_ID']."'");
								$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_PEN_ID'],'penolakan');
									
								}
								else if (!empty($value['CAP_LAY_PER_ID'])) {
	
								$numberID = "perpanjangan".$value['CAP_LAY_PER_ID'];
								$headerID = "Perpanjangan No. ".$value['CAP_LAY_PER_NUMBER'];
								$time  = $this->getTimeByTable('CAP_LAY_PER_DATECREATED',"CAP_LAYAN_PERPANJANGAN WHERE CAP_LAY_PER_ID = '".$value['CAP_LAY_PER_ID']."'");
								$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_PER_ID'],'perpanjangan');
									
								}
								else {
								
								$numberID = "permohonan".$value['CAP_LAY_ID'];
								$headerID = "Permohonan No. ".$value['CAP_LAY_TRANSACTIONID'];
								$time  = $this->getTimeByTable('CAP_LAY_DATECREATED',"CAP_LAYAN WHERE CAP_LAY_ID = '".$value['CAP_LAY_ID']."'");
								$documents = $this->getLayanKeberatanDocumentFiltered($registrar,$value['CAP_LAY_ID'],'permohonan');
								
								}
							
							$dateTime = $this->getCurrentHolidayDateTimeDashboard(date("Y-m-d H:i:s"),date("Y-m-d H:i:s",strtotime($time['DATETIME'])));

							$dateTime2 =  strtotime ( '-'.$dateTime.' day' . date("Y-m-d H:i:s") );
							
							$date1 = new DateTime($time['DATETIME']);
							
							$date3 = date("Y-m-d H:i:s",$dateTime2);
							
							$date2 = new DateTime($date3);
							
							$interval = $date1->diff($date2);
							
							$years = $interval->format('%y');
							    
							$months = $interval->format('%m');
							    
							$days = $interval->format('%d'); 
							    
							$hour = $interval->format('%H'); 
							    
							$minute = $interval->format('%i'); 
							    
							$second = $interval->format('%s');

							unset($waktu);
		    				
		    				//print_r($dateTime."-".$time['DATETIME']); echo "<br>";
							
							if ($years != 0) {
							    $waktu  = $years." Tahun ";
						    }
						    if ($months != 0) {
							    $waktu  .= $months." Bulan ";
						    }
							if ($days != 0) {
							    $waktu  .= $days." Hari ";
						    }
						    if ($hour != 0) {
							   	$waktu .= $hour." Jam ";
						    }
						    if ($minute != 0) {
							   	$waktu .= $minute." Menit ";
						    }
						    if ($second != 0) {
							   	$waktu .= $second." Detik ";
						    }
							
						    //print_r($keberatan[0]['CAP_LAY_KEB_ID']."-".$documents[0]['FK_CAP_LAY_KEB_ID']."<br>");

							if ($days > 30) {
																					
									$view .= "<div document='".$numberID."' class='layan-admin_pemberitahuan_create-dokumen-tab-inside displayNone'>";
							
									$view .= "<input name='tinggi-dokumen[$i]' class='layan-original-height' type='hidden' value='0'>";
										
										$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top full-width'>";
										
											$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header'>".$headerID."</div>";
										
											$view .= "<div>Dokumen ini sudah melebihi jangka waktu 30 hari sejak diciptakan. Dan oleh karenanya sesuai dengan UU No. 14 tahun 2008 tentang keterbukaan informasi publik pasal 35, dokumen ini sudah tidak dapat di lakukan keberatan.</div>";
										
										$view .= "</div>";
									
									$view .= "</div>";
							
							$i++;
			
							continue;
							
							}
							else if (!empty($documents) && $keberatan[0]['CAP_LAY_KEB_ID'] != $documents[0]['FK_CAP_LAY_KEB_ID']) {

								$view .= "<div document='".$numberID."' class='layan-admin_pemberitahuan_create-dokumen-tab-inside displayNone'>";
							
									$view .= "<input name='tinggi-dokumen[$i]' class='layan-original-height' type='hidden' value='0'>";
										
										$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top full-width'>";
										
											$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header'>".$headerID."</div>";
										
											$view .= "<div>Dokumen ini sudah pernah diberatkan dalam keberatan no. ".$documents[0]['CAP_LAY_KEB_NUMBER']." sebelumnya dan oleh karenanya tidak dapat diberatkan lagi.</div>";
										
										$view .= "</div>";
									
									$view .= "</div>";
							
							$i++;
			
							continue;

							}					

							$view .= "<div document='".$numberID."' class='layan-admin_pemberitahuan_create-dokumen-tab-inside displayNone'>";
							
							$view .= "<input class='layan-original-height' type='hidden' value='0'>";

							$view .= "<input name='keberatan-id[$i]' type='hidden' value='".$keberatan[0]['CAP_LAY_KEB_ID']."'>";

							$view .= "<input name='document-id[$i]' type='hidden' value='".$documents[0]['CAP_LAY_KEB_DOC_ID']."'>";

							$view .= "<input name='permohonan-ID' type='hidden' value='".base64_encode($pemohonanID['CAP_LAY_TRANSACTIONID'])."'>";
								
								$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top full-width'>";
								
									$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header'>".$headerID."</div>";
									
									$view .= "<div>".$waktu."</div>";
													
								$view .= "</div>";
								
								$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top' style='display:none;'>";
								
									$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Penyelesaian</div>";
														
									$view .= "<div>";
									
										$view .= "<select name='penyelesaian-keberatan' class='layan-keberatan-select-finish'>";
										
											if ($keberatan[0]['CAP_LAY_KEB_STATUS'] == 1) {
										
											$view .= "<option value='0'>Pilih Penyelesaian</option>";
										
											$view .= "<option selected='selected' value='1'>Selesai Secara Internal</option>";
											
											$view .= "<option value='2'>Sengketa di Komisi Informasi</option>";
											
											}
											else if ($keberatan[0]['CAP_LAY_KEB_STATUS'] == 2) {
												
											$view .= "<option value='0'>Pilih Penyelesaian</option>";
										
											$view .= "<option value='1'>Selesai Secara Internal</option>";
											
											$view .= "<option selected='selected' value='2'>Sengketa di Komisi Informasi</option>";
												
											}
											else {
												
											$view .= "<option selected='selected' value='0'>Pilih Penyelesaian</option>";
										
											$view .= "<option value='1'>Selesai Secara Internal</option>";
											
											$view .= "<option value='2'>Sengketa di Komisi Informasi</option>";
												
											}
										
										$view .= "</select>";
									
									$view .= "</div>";
								
								$view .= "</div>";
								
								$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
								
									$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Nama</div>";
														
									$view .= "<div><input name='nama-kuasa' type='text' class='layan-admin_perpanjangan_create-dokumen-biaya-form-input-full-kuasa-pemohon' placeholder='Nama Lengkap Kuasa Pemohon' value='".$documents[0]['CAP_LAY_KEB_NAME']."'></div>";
								
								$view .= "</div>";

								$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
								
									$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Alamat</div>";
														
									$view .= "<div><input name='alamat-kuasa' type='text' class='layan-admin_perpanjangan_create-dokumen-biaya-form-input-full-alamat-pemohon' placeholder='Alamat Lengkap Kuasa Pemohon' value='".$documents[0]['CAP_LAY_KEB_ALAMAT']."'></div>";
								
								$view .= "</div>";
								
								$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top' style='display:none;'>";
								
									$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Tanggal Tanggapan</div>";
									
										if (!empty($keberatan[0]['CAP_LAY_KEB_DATE_TO'])) {

										$view .= "<div><input name='tanggal-keberatan' type='text' class='layan-admin_perpanjangan_create-dokumen-biaya-form-input-full' placeholder='Tanggal' value='".date("d-m-Y",strtotime($keberatan[0]['CAP_LAY_KEB_DATE_TO']))."'></div>";
										
										}
										else {

										$view .= "<div><input name='tanggal-keberatan' type='text' class='layan-admin_perpanjangan_create-dokumen-biaya-form-input-full' placeholder='Tanggal' value=''></div>";

										}

								$view .= "</div>";
								
								$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top' style='display:none;'>";
								
									$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Daftar Alasan</div>";
														
										$view .= "<div>";
											
											if ($documents[0]['CAP_LAY_KEB_DOC_A'] == 1) {

											$view .= "<li><input name='daftar-alasan[$i][0]' type='hidden' value='0'><input name='daftar-alasan[$i][0]' checked type='checkbox' value='1'> &nbsp; (a) &nbsp;Alasan pengecualian pasal 17 UU No. 14 tahun 2008</li>";

											}
											else {

											$view .= "<li><input name='daftar-alasan[$i][0]' type='hidden' value='0'><input name='daftar-alasan[$i][0]' type='checkbox' value='1'> &nbsp; (a) &nbsp;Alasan pengecualian pasal 17 UU No. 14 tahun 2008</li>";

											}
											
											if ($documents[0]['CAP_LAY_KEB_DOC_B'] == 1) {

											$view .= "<li><input name='daftar-alasan[$i][1]' type='hidden' value='0'><input name='daftar-alasan[$i][1]' checked type='checkbox' value='1'> &nbsp; (b) &nbsp;Tidak disediakan informasi berkala</li>";
											
											}
											else {

											$view .= "<li><input name='daftar-alasan[$i][1]' type='hidden' value='0'><input name='daftar-alasan[$i][1]' type='checkbox' value='1'> &nbsp; (b) &nbsp;Tidak disediakan informasi berkala</li>";

											}

											if ($documents[0]['CAP_LAY_KEB_DOC_C'] == 1) {

											$view .= "<li><input name='daftar-alasan[$i][2]' type='hidden' value='0'><input name='daftar-alasan[$i][2]' checked type='checkbox' value='1'> &nbsp; (c) &nbsp;Tidak ditanggapinya permintaan informasi</li>";
											
											}
											else {

											$view .= "<li><input name='daftar-alasan[$i][2]' type='hidden' value='0'><input name='daftar-alasan[$i][2]' type='checkbox' value='1'> &nbsp; (c) &nbsp;Tidak ditanggapinya permintaan informasi</li>";

											}

											if ($documents[0]['CAP_LAY_KEB_DOC_D'] == 1) {

											$view .= "<li><input name='daftar-alasan[$i][3]' type='hidden' value='0'><input name='daftar-alasan[$i][3]' checked type='checkbox' value='1'> &nbsp; (d) &nbsp;Tidak ditanggapi sebagaimana yang diminta</li>";
											
											}
											else {

											$view .= "<li><input name='daftar-alasan[$i][3]' type='hidden' value='0'><input name='daftar-alasan[$i][3]' type='checkbox' value='1'> &nbsp; (d) &nbsp;Tidak ditanggapi sebagaimana yang diminta</li>";

											}

											if ($documents[0]['CAP_LAY_KEB_DOC_E'] == 1) {

											$view .= "<li><input name='daftar-alasan[$i][4]' type='hidden' value='0'><input name='daftar-alasan[$i][4]' checked type='checkbox' value='1'> &nbsp; (e) &nbsp;Tidak dipenuhinya permintaan informasi</li>";
											
											}
											else {

											$view .= "<li><input name='daftar-alasan[$i][4]' type='hidden' value='0'><input name='daftar-alasan[$i][4]' type='checkbox' value='1'> &nbsp; (e) &nbsp;Tidak dipenuhinya permintaan informasi</li>";

											}

											if ($documents[0]['CAP_LAY_KEB_DOC_F'] == 1) {

											$view .= "<li><input name='daftar-alasan[$i][5]' type='hidden' value='0'><input name='daftar-alasan[$i][5]' checked type='checkbox' value='1'> &nbsp; (f) &nbsp;Pengenaan biaya yang tidak wajar</li>";
											
											}
											else {

											$view .= "<li><input name='daftar-alasan[$i][5]' type='hidden' value='0'><input name='daftar-alasan[$i][5]' type='checkbox' value='1'> &nbsp; (f) &nbsp;Pengenaan biaya yang tidak wajar</li>";

											}

											if ($documents[0]['CAP_LAY_KEB_DOC_G'] == 1) {

											$view .= "<li><input name='daftar-alasan[$i][6]' type='hidden' value='0'><input name='daftar-alasan[$i][6]' checked type='checkbox' value='1'> &nbsp; (g) &nbsp;Penyampaian informasi melebihi waktu yang diatur dalam Undang-Undang</li>";
											
											}
											else {

											$view .= "<li><input name='daftar-alasan[$i][6]' type='hidden' value='0'><input name='daftar-alasan[$i][6]' type='checkbox' value='1'> &nbsp; (g) &nbsp;Penyampaian informasi melebihi waktu yang diatur dalam Undang-Undang</li>";

											}

										$view .= "</div>";
								
								$view .= "</div>";
								
								$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
								
									$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Alasan Pengajuan Keberatan</div>";
														
									$view .= "<div><textarea name='notes[$i]' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-textarea'>".$documents[0]['CAP_LAY_KEB_DOC_NOTES']."</textarea></div>";
								
								$view .= "</div>";

								$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
								
									$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Tanggapan</div>";
														
									$view .= "<div><textarea name='tanggapan[$i]' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-textarea' readonly='true'>".$documents[0]['CAP_LAY_KEB_DOC_RESPONSE']."</textarea></div>";
								
								$view .= "</div>";

								if (empty($documents[0]['CAP_LAY_KEB_DOC_RESPONSE'])) {

									$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top' style='display:none;'>";
									
										$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Respon Pemohon</div>";
															
										$view .= "<div><textarea name='respon-pemohon[$i]' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-textarea'>".$documents[0]['CAP_LAY_KEB_DOC_RESPONSE_U']."</textarea></div>";
									
									$view .= "</div>";

								}
								else {

									$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top'>";
									
										$view .= "<div class='layan-admin_pemberitahuan_create-dokumen-tab-inside-top-header noBold'>Respon Pemohon</div>";
															
										$view .= "<div><textarea name='respon-pemohon[$i]' class='layan-admin_pemberitahuan_create-dokumen-biaya-form-input-textarea'>".$documents[0]['CAP_LAY_KEB_DOC_RESPONSE_U']."</textarea></div>";
									
									$view .= "</div>";

								}
											
							$view .= "</div>";

							$i++;
							
							}
						
						}
				
				}
			
			}
			
			$view .= "</div>";
			
			$view .= "</div>";
						
			$view .= "<input style='margin-left:5px; margin-top:5px;' class='layan-normal-create-keberatan' type='submit' value='Update Keberatan'>";
			
			$view .= "</form>";
			
			$view .= "</div>";

			$holidayDate = $this->getHolidayDate(date("Y-m-d"),date("Y-12-31"));

				if (!empty($holidayDate)) {

					foreach ($holidayDate as $value) {

						$holidayArray [] = date("Y-m-d",strtotime($value['CAP_LAY_CAL_DATE']));

					}

				}

				$AddHoliday = count($holidayArray);

				$time = new time(null);

				$endDate = $time->addDays(strtotime(date("Y-m-d")),30+$AddHoliday,array("Saturday", "Sunday"),$holidayArray);

				$endDate = date("Y-m-d",$endDate);

				unset($holidayArray);

				if (!empty($holidayDate)) {

					foreach ($holidayDate as $value) {

						if (strtotime($value['CAP_LAY_CAL_DATE']) > strtotime($endDate)) {

							break;

						} 

						$weekDay = date('w', strtotime($value['CAP_LAY_CAL_DATE']));

						if ($weekDay != 0 && $weekDay != 6) {

							$holidayArray [] = date("Y-m-d",strtotime($value['CAP_LAY_CAL_DATE']));

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

			$numberOfDays = $time->getWorkingDays(date("Y-m-d"),$endDate,$holidayArray);

			$dateA = new DateTime(date("Y-m-d"));
					
			$dateB = new DateTime($endDate);
			
			$intervalA = $dateA->diff($dateB);
			
			$maxDate = $intervalA->days;

			$_SESSION['LAYAN-KEBERATAN-MAX-DATE'] = date("Y-m-d",strtotime("+".$maxDate."day".date("Y-m-d")));

			$view .= "

			<script type='text/javascript'>

				jQuery.noConflict()(function($){

					$(document).ready(function() {

						var IndonesianHoliday = [$IndonesianHoliday];

						$('.layan-admin_perpanjangan_create-dokumen-biaya-form-input-full').datepicker({ 
						dateFormat: 'dd-mm-yy',
						minDate: 0, 
						maxDate: '+".$maxDate."D',
						beforeShowDay: function(date) {
								            
						var showDay = true;
								            
						// disable sunday and saturday
						if (date.getDay() == 0 || date.getDay() == 6) {
							showDay = false;
					    }
								            			            
						// jquery in array function
						if ($.inArray(date.getTime(), IndonesianHoliday) > -1) {
							showDay = false;
						}
								            
								            
							return [showDay];
						},
						onSelect: function(dateText, inst) { 
							$('.layan-admin_perpanjangan_create-dokumen-biaya-form-input-full').val(dateText);
							$('.layan-admin_perpanjangan_create-dokumen-biaya-form-input-full').attr('value',dateText);
						}

					});

				});

			});
			</script>

			";
			
		echo $view;
		
	}
	
	public function global_sejarah() {
		
		$this->data = base64_decode($_GET['ref']); 
		
		$sejarah = $this->getSejarahAllPermohonan(); 
								
			$view  = "<div class='layan-normal-form-container'>";
						
			$view .= $this->optionGear;
			
			$view .= "<div class='layan-permohonan-upper-menu-container'>";

			$view .= "<div class='layan-permohonan-icons-container-global'>Sejarah 7 Hari Terakhir</div>";
			
			$view .= "</div>";

			$view .= "<table class='layan-normal-table'>";
					
					$view .= "<tr>";
						
						$view .= "<td colspan='3' class='layan-normal-form-bold'><hr class='layan-normal-form-hr'></td>";
											
					$view .= "</tr>";
														
				$view .= "</table>";

			if (!empty($sejarah)) {

				$view .= "<div class='layan-admin_sejarah-container-global'>";

				foreach ($sejarah as $key => $value) {

				$view .= "<div class='layan-overview-sejarah-date-header-global'>".date("d, F Y",strtotime($value['DATE']))."</div>";

				$view .= "<hr class='layan-normal-form-hr2'>";

				$view .= "<ul class='layan-admin_sejarah-sejarah-ul'>";
				
				if (!empty($value['VALUE'])):
				
					foreach ($value['VALUE'] as $key2 => $value2) {

						$view .= "<li><span class='layan-admin_sejarah-sejarah-span'>(".date("H:i:s",strtotime($value2['DATETIME'])).")</span> ".ucfirst(strtolower($value2['CAP_LAY_HIS_TEXT']))."</li>";

						$view .= "<hr class='layan-normal-form-hr2'>";

					}
					
				endif;

				$view .= "</ul>";

				$view .= "<br>";

				}

			$view .= "</div>";

			}
			
		echo $view;
		
	}
	
	public function user_sejarah() {
		
		$this->data = base64_decode($_GET['ref']); 
		
		$sejarah = $this->getSejarahPermohonanByUser(); 
								
			$view  = "<div class='layan-normal-form-container'>";
						
			$view .= $this->optionGear;
			
			$view .= "<div class='layan-permohonan-upper-menu-container'>";

			$view .= "<div class='layan-permohonan-icons-container-global'>Sejarah 7 Hari Terakhir</div>";
			
			$view .= "</div>";

			$view .= "<table class='layan-normal-table'>";
					
					$view .= "<tr>";
						
						$view .= "<td colspan='3' class='layan-normal-form-bold'><hr class='layan-normal-form-hr'></td>";
											
					$view .= "</tr>";
														
				$view .= "</table>";

			if (!empty($sejarah)) {

				$view .= "<div class='layan-admin_sejarah-container-global'>";

				foreach ($sejarah as $key => $value) {

				$view .= "<div class='layan-overview-sejarah-date-header-global'>".date("d, F Y",strtotime($value['DATE']))."</div>";

				$view .= "<hr class='layan-normal-form-hr2'>";

				$view .= "<ul class='layan-admin_sejarah-sejarah-ul'>";

					foreach ($value['VALUE'] as $key2 => $value2) {

						$view .= "<li><span class='layan-admin_sejarah-sejarah-span'>(".date("H:i:s",strtotime($value2['DATETIME'])).")</span> ".ucfirst(strtolower($value2['CAP_LAY_HIS_TEXT']))."</li>";

						$view .= "<hr class='layan-normal-form-hr2'>";

					}

				$view .= "</ul>";

				$view .= "<br>";

				}

			$view .= "</div>";

			}
			
		echo $view;
		
	}

	public function admin_sejarah() {
		
		$this->data = base64_decode($_GET['ref']); 
		
		$sejarah = $this->getSejarahByPermohonanID();
				
			$view  = "<div class='layan-normal-form-container'>";
						
			$view .= $this->optionGear;
			
			$view .= "<div class='layan-permohonan-upper-menu-container'>";

			$view .= "<div class='layan-permohonan-icons-container' rel='penolakan'>
							<div class='layan-admin_sejarah-float-left-print-permohonan qtip-upper' text='Print Sejarah'></div>
					  </div>";
			
			$view .= "</div>";

			$view .= "<table class='layan-normal-table'>";
					
					$view .= "<tr>";
						
						$view .= "<td colspan='3' class='layan-normal-form-bold'><hr class='layan-normal-form-hr'></td>";
											
					$view .= "</tr>";
														
				$view .= "</table>";

			if (!empty($sejarah)) {

				$view .= "<div class='layan-admin_sejarah-container'>";

				foreach ($sejarah as $key => $value) {

				$view .= "<div class='layan-overview-sejarah-date-header'>".date("d, F Y",strtotime($value['DATE']))."</div>";

				$view .= "<hr class='layan-normal-form-hr'>";

				$view .= "<ul class='layan-admin_sejarah-sejarah-ul'>";

					foreach ($value['VALUE'] as $key2 => $value2) {

						$view .= "<li><span class='layan-admin_sejarah-sejarah-span'>(".date("H:i:s",strtotime($value2['DATETIME'])).")</span> ".ucfirst(strtolower($value2['CAP_LAY_HIS_TEXT']))."</li>";

						$view .= "<hr class='layan-normal-form-hr'>";

					}

				$view .= "</ul>";

				$view .= "<br>";

				}

			$view .= "</div>";

			}
			
		echo $view;
		
	}

	public function user_attachment() {
		
		$this->data = base64_decode($_GET['ref']); 
		
		$view .= $this->optionGear;

		$data  = $this->getDokumenLengkap();
				
		$path = $this->getPermohonanFilePath();

		$path = explode("/", $path);

		$foto = base64_encode($path[8]."|FOTO");

		$ktp = base64_encode($path[8]."|KTP");

		$akta = base64_encode($path[8]."|AKTA");

		$kuasa = base64_encode($path[8]."|KUASA");

		$ktpKuasa = base64_encode($path[8]."|KTP-KUASA");

		$npwp = base64_encode($path[8]."|NPWP");

		$view  = "<div class='layan-admin_attachment-container'>";

			if ($data['CAP_LAY_TIPEPEMOHON'] == 'BADAN HUKUM') {
		
			$view .= "<div class='layan-admin_attachment-foto-container' title='foto' rel='$foto'>";
						
				if (file_exists("library/capsule/layan/".$path[7]."/".$path[8]."/1-FOTO/1-FOTO.jpg")) {

				$view .= "<div class='layan-admin_attachment-inside-delete-icon'></div>";

				$view .= "<div class='layan-admin_attachment-inside-exist'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/1-FOTO/1-FOTO.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-inside-hidden' style='display:none'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/1-FOTO/1-FOTO.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-progressBar-exist' rel='foto'></div>";

				}
				
				else {

				$view .= "<div class='layan-admin_attachment-inside-delete-icon' style='display:none'></div>";

				$view .= "<div class='layan-admin_attachment-inside'>Foto</div>";

				$view .= "<div class='layan-admin_attachment-inside-hidden' style='display:none'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/1-FOTO/1-FOTO.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-progressBar' rel='foto'></div>";

				}	

			$view .= "</div>";

			$view .= "<div id='' class='layan-admin_attachment-ktp-container' title='ktp' rel='$ktp'>";

				if (file_exists("library/capsule/layan/".$path[7]."/".$path[8]."/2-KTP/2-KTP.jpg")) {

				$view .= "<div class='layan-admin_attachment-inside-delete-icon'></div>";

				$view .= "<div class='layan-admin_attachment-inside-exist'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/2-KTP/2-KTP.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-inside-hidden' style='display:none'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/2-KTP/2-KTP.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-progressBar-exist' rel='ktp'></div>";

				}
				else {

				$view .= "<div class='layan-admin_attachment-inside-delete-icon' style='display:none'></div>";

				$view .= "<div class='layan-admin_attachment-inside'>KTP</div>";

				$view .= "<div class='layan-admin_attachment-inside-hidden' style='display:none'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/2-KTP/2-KTP.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-progressBar' rel='ktp'></div>";

				}

			$view .= "</div>";

			$view .= "<div class='layan-admin_attachment-akta-container' title='akta' rel='$akta'>";

				if (file_exists("library/capsule/layan/".$path[7]."/".$path[8]."/3-AKTA/3-AKTA.jpg")) {

				$view .= "<div class='layan-admin_attachment-inside-delete-icon'></div>";

				$view .= "<div class='layan-admin_attachment-inside-exist'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/3-AKTA/3-AKTA.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-inside-hidden' style='display:none'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/3-AKTA/3-AKTA.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-progressBar-exist' rel='akta'></div>";

				}
				else {

				$view .= "<div class='layan-admin_attachment-inside-delete-icon' style='display:none'></div>";

				$view .= "<div class='layan-admin_attachment-inside'>Akta</div>";

				$view .= "<div class='layan-admin_attachment-inside-hidden' style='display:none'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/3-AKTA/3-AKTA.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-progressBar' rel='akta'></div>";

				}

			$view .= "</div>";

			$view .= "<div class='layan-admin_attachment-kuasa-container' title='kuasa' rel='$kuasa'>";

				if (file_exists("library/capsule/layan/".$path[7]."/".$path[8]."/4-KUASA/4-KUASA.jpg")) {

				$view .= "<div class='layan-admin_attachment-inside-delete-icon'></div>";

				$view .= "<div class='layan-admin_attachment-inside-exist'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/4-KUASA/4-KUASA.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-inside-hidden' style='display:none'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/4-KUASA/4-KUASA.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-progressBar-exist' rel='kuasa'></div>";

				}
				else {

				$view .= "<div class='layan-admin_attachment-inside-delete-icon' style='display:none'></div>";

				$view .= "<div class='layan-admin_attachment-inside'>Surat Kuasa</div>";

				$view .= "<div class='layan-admin_attachment-inside-hidden' style='display:none'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/4-KUASA/4-KUASA.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-progressBar' rel='kuasa'></div>";

				}

			$view .= "</div>";

			$view .= "<div class='layan-admin_attachment-ktpKuasa-container' title='ktp-kuasa' rel='$ktpKuasa'>";

				if (file_exists("library/capsule/layan/".$path[7]."/".$path[8]."/5-KTP-KUASA/5-KTP-KUASA.jpg")) {

				$view .= "<div class='layan-admin_attachment-inside-delete-icon'></div>";

				$view .= "<div class='layan-admin_attachment-inside-exist'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/5-KTP-KUASA/5-KTP-KUASA.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-inside-hidden' style='display:none'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/5-KTP-KUASA/5-KTP-KUASA.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-progressBar-exist' rel='ktp-kuasa'></div>";

				}
				else {

				$view .= "<div class='layan-admin_attachment-inside-delete-icon' style='display:none'></div>";

				$view .= "<div class='layan-admin_attachment-inside'>KTP Kuasa</div>";

				$view .= "<div class='layan-admin_attachment-inside-hidden' style='display:none'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/5-KTP-KUASA/5-KTP-KUASA.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-progressBar' rel='ktp-kuasa'></div>";

				}

			$view .= "</div>";

			$view .= "<div class='layan-admin_attachment-npwp-container' title='npwp' rel='$npwp'>";

				if (file_exists("library/capsule/layan/".$path[7]."/".$path[8]."/6-NPWP/6-NPWP.jpg")) {

				$view .= "<div class='layan-admin_attachment-inside-delete-icon'></div>";

				$view .= "<div class='layan-admin_attachment-inside-exist'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/6-NPWP/6-NPWP.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-inside-hidden' style='display:none'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/6-NPWP/6-NPWP.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-progressBar-exist' rel='npwp'></div>";

				}
				else {

				$view .= "<div class='layan-admin_attachment-inside-delete-icon' style='display:none'></div>";

				$view .= "<div class='layan-admin_attachment-inside'>NPWP</div>";

				$view .= "<div class='layan-admin_attachment-inside-hidden' style='display:none'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/6-NPWP/6-NPWP.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-progressBar' rel='npwp'></div>";

				}

			$view .= "</div>";
			
			}
			else {
				
				$view .= "<div class='layan-admin_attachment-foto-container' title='foto' rel='$foto'>";
						
				if (file_exists("library/capsule/layan/".$path[7]."/".$path[8]."/1-FOTO/1-FOTO.jpg")) {

				$view .= "<div class='layan-admin_attachment-inside-delete-icon'></div>";

				$view .= "<div class='layan-admin_attachment-inside-exist'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/1-FOTO/1-FOTO.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-inside-hidden' style='display:none'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/1-FOTO/1-FOTO.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-progressBar-exist' rel='foto'></div>";

				}
				
				else {

				$view .= "<div class='layan-admin_attachment-inside-delete-icon' style='display:none'></div>";

				$view .= "<div class='layan-admin_attachment-inside'>Foto</div>";

				$view .= "<div class='layan-admin_attachment-inside-hidden' style='display:none'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/1-FOTO/1-FOTO.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-progressBar' rel='foto'></div>";

				}	

			$view .= "</div>";

			$view .= "<div id='' class='layan-admin_attachment-ktp-container' title='ktp' rel='$ktp'>";

				if (file_exists("library/capsule/layan/".$path[7]."/".$path[8]."/2-KTP/2-KTP.jpg")) {

				$view .= "<div class='layan-admin_attachment-inside-delete-icon'></div>";

				$view .= "<div class='layan-admin_attachment-inside-exist'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/2-KTP/2-KTP.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-inside-hidden' style='display:none'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/2-KTP/2-KTP.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-progressBar-exist' rel='ktp'></div>";

				}
				else {

				$view .= "<div class='layan-admin_attachment-inside-delete-icon' style='display:none'></div>";

				$view .= "<div class='layan-admin_attachment-inside'>KTP</div>";

				$view .= "<div class='layan-admin_attachment-inside-hidden' style='display:none'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/2-KTP/2-KTP.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-progressBar' rel='ktp'></div>";

				}

			$view .= "</div>";
				
			}

		$view .= "</div>";
			
		echo $view;
		
	}

	public function admin_attachment() {
		
		$this->data = base64_decode($_GET['ref']); 
		
		$data  = $this->getDokumenLengkap();
				
		$path = $this->getPermohonanFilePath();

		$path = explode("/", $path);

		$foto = base64_encode($path[8]."|FOTO");

		$ktp = base64_encode($path[8]."|KTP");

		$akta = base64_encode($path[8]."|AKTA");

		$kuasa = base64_encode($path[8]."|KUASA");

		$ktpKuasa = base64_encode($path[8]."|KTP-KUASA");

		$npwp = base64_encode($path[8]."|NPWP");

		$view  = "<div class='layan-admin_attachment-container'>";

		$view .= $this->optionGear;

			if ($data['CAP_LAY_TIPEPEMOHON'] == 'BADAN HUKUM') {
		
			$view .= "<div class='layan-admin_attachment-foto-container' title='foto' rel='$foto'>";
						
				if (file_exists("library/capsule/layan/".$path[7]."/".$path[8]."/1-FOTO/1-FOTO.jpg")) {

				$view .= "<div class='layan-admin_attachment-inside-exist'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/1-FOTO/1-FOTO.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-inside-hidden' style='display:none'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/1-FOTO/1-FOTO.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-progressBar-exist' rel='foto'></div>";

				}
				
				else {

				$view .= "<div class='layan-admin_attachment-inside'>Foto</div>";

				$view .= "<div class='layan-admin_attachment-inside-hidden' style='display:none'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/1-FOTO/1-FOTO.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-progressBar' rel='foto'></div>";

				}	

			$view .= "</div>";

			$view .= "<div id='' class='layan-admin_attachment-ktp-container' title='ktp' rel='$ktp'>";

				if (file_exists("library/capsule/layan/".$path[7]."/".$path[8]."/2-KTP/2-KTP.jpg")) {

				$view .= "<div class='layan-admin_attachment-inside-exist'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/2-KTP/2-KTP.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-inside-hidden' style='display:none'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/2-KTP/2-KTP.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-progressBar-exist' rel='ktp'></div>";

				}
				else {

				$view .= "<div class='layan-admin_attachment-inside'>KTP</div>";

				$view .= "<div class='layan-admin_attachment-inside-hidden' style='display:none'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/2-KTP/2-KTP.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-progressBar' rel='ktp'></div>";

				}

			$view .= "</div>";

			$view .= "<div class='layan-admin_attachment-akta-container' title='akta' rel='$akta'>";

				if (file_exists("library/capsule/layan/".$path[7]."/".$path[8]."/3-AKTA/3-AKTA.jpg")) {

				$view .= "<div class='layan-admin_attachment-inside-exist'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/3-AKTA/3-AKTA.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-inside-hidden' style='display:none'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/3-AKTA/3-AKTA.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-progressBar-exist' rel='akta'></div>";

				}
				else {

				$view .= "<div class='layan-admin_attachment-inside'>Akta</div>";

				$view .= "<div class='layan-admin_attachment-inside-hidden' style='display:none'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/3-AKTA/3-AKTA.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-progressBar' rel='akta'></div>";

				}

			$view .= "</div>";

			$view .= "<div class='layan-admin_attachment-kuasa-container' title='kuasa' rel='$kuasa'>";

				if (file_exists("library/capsule/layan/".$path[7]."/".$path[8]."/4-KUASA/4-KUASA.jpg")) {

				$view .= "<div class='layan-admin_attachment-inside-exist'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/4-KUASA/4-KUASA.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-inside-hidden' style='display:none'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/4-KUASA/4-KUASA.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-progressBar-exist' rel='kuasa'></div>";

				}
				else {

				$view .= "<div class='layan-admin_attachment-inside'>Surat Kuasa</div>";

				$view .= "<div class='layan-admin_attachment-inside-hidden' style='display:none'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/4-KUASA/4-KUASA.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-progressBar' rel='kuasa'></div>";

				}

			$view .= "</div>";

			$view .= "<div class='layan-admin_attachment-ktpKuasa-container' title='ktp-kuasa' rel='$ktpKuasa'>";

				if (file_exists("library/capsule/layan/".$path[7]."/".$path[8]."/5-KTP-KUASA/5-KTP-KUASA.jpg")) {

				$view .= "<div class='layan-admin_attachment-inside-exist'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/5-KTP-KUASA/5-KTP-KUASA.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-inside-hidden' style='display:none'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/5-KTP-KUASA/5-KTP-KUASA.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-progressBar-exist' rel='ktp-kuasa'></div>";

				}
				else {

				$view .= "<div class='layan-admin_attachment-inside'>KTP Kuasa</div>";

				$view .= "<div class='layan-admin_attachment-inside-hidden' style='display:none'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/5-KTP-KUASA/5-KTP-KUASA.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-progressBar' rel='ktp-kuasa'></div>";

				}

			$view .= "</div>";

			$view .= "<div class='layan-admin_attachment-npwp-container' title='npwp' rel='$npwp'>";

				if (file_exists("library/capsule/layan/".$path[7]."/".$path[8]."/6-NPWP/6-NPWP.jpg")) {

				$view .= "<div class='layan-admin_attachment-inside-exist'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/6-NPWP/6-NPWP.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-inside-hidden' style='display:none'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/6-NPWP/6-NPWP.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-progressBar-exist' rel='npwp'></div>";

				}
				else {

				$view .= "<div class='layan-admin_attachment-inside'>NPWP</div>";

				$view .= "<div class='layan-admin_attachment-inside-hidden' style='display:none'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/6-NPWP/6-NPWP.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-progressBar' rel='npwp'></div>";

				}

			$view .= "</div>";
			
			}
			else {
				
				$view .= "<div class='layan-admin_attachment-foto-container' title='foto' rel='$foto'>";
						
				if (file_exists("library/capsule/layan/".$path[7]."/".$path[8]."/1-FOTO/1-FOTO.jpg")) {

				$view .= "<div class='layan-admin_attachment-inside-exist'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/1-FOTO/1-FOTO.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-inside-hidden' style='display:none'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/1-FOTO/1-FOTO.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-progressBar-exist' rel='foto'></div>";

				}
				
				else {

				$view .= "<div class='layan-admin_attachment-inside'>Foto</div>";

				$view .= "<div class='layan-admin_attachment-inside-hidden' style='display:none'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/1-FOTO/1-FOTO.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-progressBar' rel='foto'></div>";

				}	

			$view .= "</div>";

			$view .= "<div id='' class='layan-admin_attachment-ktp-container' title='ktp' rel='$ktp'>";

				if (file_exists("library/capsule/layan/".$path[7]."/".$path[8]."/2-KTP/2-KTP.jpg")) {

				$view .= "<div class='layan-admin_attachment-inside-exist'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/2-KTP/2-KTP.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-inside-hidden' style='display:none'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/2-KTP/2-KTP.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-progressBar-exist' rel='ktp'></div>";

				}
				else {

				$view .= "<div class='layan-admin_attachment-inside'>KTP</div>";

				$view .= "<div class='layan-admin_attachment-inside-hidden' style='display:none'><img src='framework/resize.class.php?src=library/capsule/layan/".$path[7]."/".$path[8]."/2-KTP/2-KTP.jpg&h=90&w=123&zc=1'></div>";

				$view .= "<div class='layan-admin_attachment-progressBar' rel='ktp'></div>";

				}

			$view .= "</div>";
				
			}

		$view .= "</div>";
			
		echo $view;
		
	}
	
	public function loading() {
	
		$view .= "<div class='layan-processing'>";
			
			$view .= "<div class='layan-processing-text'>Mohon tunggu, permohonan sedang diproses..</div>";
			
			$view .= "<div class='layan-processing-progressbar'></div>";
		
		$view .= "</div>";
		
	echo $view;
		
	}
	
	public function permohonan() {
	
	$response = $this->insertPermohonan();

		if ($response['response'] == 1):
			
			$view ['response'] = 1;

			$view ['url'] = 'http://'.$_SERVER['HTTP_HOST'].APP.'?id=1984&ref=' .base64_encode($response['message']);

			$view ['result'] = $response['message'];
		
		else:
			
			$view ['response'] = 0;

			$view ['url'] = 'http://'.$_SERVER['HTTP_HOST'].APP.'?id=1991';

			$view ['result'] = $response['message'];
			
		endif;
		
	echo json_encode($view);
		
	}
		
	public function user_dashboard() {
		
	$data  = $this->getPermohonanUserSide();

		if (!empty($data)) {	
			$this->preCheck($data);
		}
		
	$data  = $this->getPermohonanUserSide();

	$view .= $this->optionGear;
	
	$view .= "<div class='layan-overview-container-search'>";
		
		$view .= "<input type='text' class='layan-general-dashboard-input-search' placeholder='Search Permohonan'>";
		
	$view .= "</div>";
	
	$view .= "<div class='layan-dashboard-box-container'>";
	
	if (!empty($data)) {
		$view .= '<div id="dialog-confirm" style="display:none;" title="Anda yakin akan mengubah status menjadi terkirim?">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0; "></span>Dengan mengubah status menjadi terkirim akan menghilangkan permohonan dari sidebar.</p>
</div>';
		foreach ($data as $key => $value ) {
				
		$time  = $this->getTime($value['CAP_LAY_ID']);
		
		$dateTime = $this->getCurrentHolidayDateTimeDashboard(date("Y-m-d"),date("Y-m-d",strtotime($time['DATETIME'])));
		
		$dateTime2 =  strtotime ( '-'.$dateTime.' day' . date("Y-m-d H:i:s") );

		$date1 = new DateTime($time['DATETIME']);
		
		$date3 = date("Y-m-d H:i:s",$dateTime2);

		$date2 = new DateTime($date3);
		
		$interval = $date1->diff($date2);
		
		$years = $interval->format('%y');
		    
		$months = $interval->format('%m');
		    
		$days = $interval->format('%d'); 
		    
		$hour = $interval->format('%H'); 
		    
		$minute = $interval->format('%i'); 
		    
		$second = $interval->format('%s');

		unset($waktu);
		    
		    if ($years != 0) {
			    $waktu  = $years." Tahun ";
		    }
		    if ($months != 0) {
			    $waktu  .= $months." Bulan ";
		    }
			if ($days != 0) {
			    $waktu  .= $days." Hari ";
		    }
		    if ($hour != 0) {
			   	$waktu .= $hour." Jam ";
		    }
		    if ($minute != 0) {
			   	$waktu .= $minute." Menit ";
		    }
		    if ($second != 0) {
			   	$waktu .= $second." Detik ";
		    }
		
		$this->data = $value['CAP_LAY_ID']; 

		$z = 0;

		$document  = $this->getDocument($value['CAP_LAY_ID']);
		
		$count     = $this->getDocumentByCount($value['CAP_LAY_ID']);
		
		$data  = $this->getTotalDocumentByCountByID(); 

		$data2 = $this->getPemberitahuanByCountByID(); 

		$data3 = $this->getPenolakanByCountByID();
		
		$data4 = $this->getPerpanjanganByCountByID();
		
		$data6 = $this->getKeberatanByCountByID();
		
		$data5 = $this->getPotentialJobTerlampirByCountByID();
		
		$baseCal = @(100/$data['COUNT']);
		
		if (!empty($document)) {

			foreach ($document as $keyLa => $valueLa) {

				$resultOne = $this->getDocumentPemberitahuanCheck($valueLa['CAP_LAY_DOC_REQ_ID']);

				$resultTwo = $this->getDocumentPenolakanCheck($valueLa['CAP_LAY_DOC_REQ_ID']);

				if (!empty($resultOne) || !empty($resultTwo)) {

					$percentage += $baseCal;

					$z++;

				}

			}

		}

		$view .= "<div class='layan-dashboard-box'>";
			
			$view .= "<div class='layan-dashboard-box-header'>";   
			
				$view .= "<div class='layan-dashboard-box-header-name'><div class='layan-dashboard-box-header-name-left'>".ucwords(strtolower($value['CAP_LAY_NAMA']))."</div>";

				$view .= "<input type='hidden' name='cap-lay-id' value='".$value['CAP_LAY_ID']."'>";
				
				$view .= "<div class='layan-dashboard-box-header-name-right-arrow-down'></div>";
				
				if (number_format($percentage,0) == 100 && $value['CAP_LAY_FINALSTATUS'] != 3 && $value['CAP_LAY_FINALSTATUS'] != 2 && $value['CAP_LAY_FINALSTATUS'] != 5) {
				
				$view .= "<div class='layan-dashboard-box-header-set-delivered'></div>";
				
				}
				
				$view .= "<a class='layan-dashboard-box-header-name-right-document' href='?id=1984&ref=".base64_encode($value['CAP_LAY_ID'])."'></a>";
				
				$view .= "</div>";
				
				$view .= "<div class='layan-dashboard-box-header-name-header-container'>";
				
				$view .= "<div class='layan-dashboard-box-header-document-header-left'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>".$value['CAP_LAY_TRANSACTIONID']."</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>Nomor</span></div>";
				
				$view .= "</div>";
				
				$view .= "<div class='layan-dashboard-box-header-document-header-right'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>".ucwords(strtolower($value['CAP_LAY_TIPEPEMOHON']))."</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>Tipe</span></div>";
				
				$view .= "</div>";
				
				$view .= "</div>";
				
				$view .= "<div class='layan-dashboard-box-content'>";
				
					if (!empty($document)) {
					
					$docuCount = count($document);
					
					$r = 0;
					
					$view .= "<ul>";
					
						foreach ($document as $key => $value) {
							
							$r++;
							
							if ($r == $docuCount) {
							$view .= "<li class='layan-dashboard-lastLI'>".$value['CAP_LAY_DOC_REQ_DOCNAME']."</li>";
							}
							else {
							$view .= "<li>".$value['CAP_LAY_DOC_REQ_DOCNAME']."</li>";
							}
							
						}
					
					$view .= "</ul>";
					
					}
					else {
						
						$view .= "-- No request found --";
						
					}
				
				$view .= "</div>";
								
				$view .= "<div class='layan-dashboard-box-header-document'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>".$count['COUNT']."</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>IP</span></div>";
				
				$view .= "</div>";
				
				$view .= "<div class='layan-dashboard-box-header-document'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>$z</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>Diproses</span></div>";
				
				$view .= "</div>";

				$view .= "<div class='layan-dashboard-box-header-document-last'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>".number_format($percentage,0)."%</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>Selesai</span></div>";
				
				$view .= "</div>";
				
				$view .= "<div class='layan-dashboard-box-header-document-end'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>$waktu</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>Waktu Berlalu</span></div>";
				
				$view .= "</div>";

				$view .= "<div class='layan-dashboard-box-header-document-bottom'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>".$data2['COUNT']."</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>Pem</span></div>";
				
				$view .= "</div>";
				
				$view .= "<div class='layan-dashboard-box-header-document-bottom'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>".$data3['COUNT']."</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>Pen</span></div>";
				
				$view .= "</div>";

				$view .= "<div class='layan-dashboard-box-header-document-bottom'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>".$data4['COUNT']."</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>Per</span></div>";
				
				$view .= "</div>";

				$view .= "<div class='layan-dashboard-box-header-document-bottom-end'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>".$data6['COUNT']."</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>Keb</span></div>";
				
				$view .= "</div>";
			
			$view .= "</div>";
						
		$view .= "</div>";

		unset($percentage);
		
		}

	}
	else {
	
		$view .= "<div style='font-size:12px;text-align:center;'>Record Tidak Ditemukan</div>";
	
	}
	
	$view .= "</div>";
			
	echo $view;
		
	}
	
	public function user_dashboard_ajax() {
		
	$data  = $this->getPermohonanUserSideAjax();
	
	if (!empty($data)) {
		$view .= '<div id="dialog-confirm" style="display:none;" title="Anda yakin akan mengubah status menjadi terkirim?">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0; "></span>Dengan mengubah status menjadi terkirim akan menghilangkan permohonan dari sidebar.</p>
</div>';
		foreach ($data as $key => $value ) {
				
		$time  = $this->getTime($value['CAP_LAY_ID']);
		
		$dateTime = $this->getCurrentHolidayDateTimeDashboard(date("Y-m-d"),date("Y-m-d",strtotime($time['DATETIME'])));
		
		$dateTime2 =  strtotime ( '-'.$dateTime.' day' . date("Y-m-d H:i:s") );

		$date1 = new DateTime($time['DATETIME']);
		
		$date3 = date("Y-m-d H:i:s",$dateTime2);

		$date2 = new DateTime($date3);
		
		$interval = $date1->diff($date2);
		
		$years = $interval->format('%y');
		    
		$months = $interval->format('%m');
		    
		$days = $interval->format('%d'); 
		    
		$hour = $interval->format('%H'); 
		    
		$minute = $interval->format('%i'); 
		    
		$second = $interval->format('%s');

		unset($waktu);
		    
			if ($years != 0) {
			    $waktu  = $years." Tahun ";
		    }
		    if ($months != 0) {
			    $waktu  .= $months." Bulan ";
		    }
			if ($days != 0) {
			    $waktu  .= $days." Hari ";
		    }
		    if ($hour != 0) {
			   	$waktu .= $hour." Jam ";
		    }
		    if ($minute != 0) {
			   	$waktu .= $minute." Menit ";
		    }
		    if ($second != 0) {
			   	$waktu .= $second." Detik ";
		    }
		
		$this->data = $value['CAP_LAY_ID']; 

		$z = 0;

		$document  = $this->getDocument($value['CAP_LAY_ID']);
		
		$count     = $this->getDocumentByCount($value['CAP_LAY_ID']);
		
		$data  = $this->getTotalDocumentByCountByID(); 

		$data2 = $this->getPemberitahuanByCountByID(); 
		
		$data3 = $this->getPenolakanByCountByID();
		
		$data4 = $this->getPerpanjanganByCountByID();
		
		$data6 = $this->getKeberatanByCountByID();
		
		$data5 = $this->getPotentialJobTerlampirByCountByID();
		
		$baseCal = @(100/$data['COUNT']);
		
		if (!empty($document)) {

			foreach ($document as $keyLa => $valueLa) {

				$resultOne = $this->getDocumentPemberitahuanCheck($valueLa['CAP_LAY_DOC_REQ_ID']);

				$resultTwo = $this->getDocumentPenolakanCheck($valueLa['CAP_LAY_DOC_REQ_ID']);

				if (!empty($resultOne) || !empty($resultTwo)) {

					$percentage += $baseCal;

					$z++;

				}

			}

		}
		
		$view .= "<div class='layan-dashboard-box'>";
			
			$view .= "<div class='layan-dashboard-box-header'>";   
			
				$view .= "<div class='layan-dashboard-box-header-name'><div class='layan-dashboard-box-header-name-left'>".ucwords(strtolower($value['CAP_LAY_NAMA']))."</div>";

				$view .= "<input type='hidden' name='cap-lay-id' value='".$value['CAP_LAY_ID']."'>";
				
				$view .= "<div class='layan-dashboard-box-header-name-right-arrow-down'></div>";
				
				if (number_format($percentage,0) == 100 && $value['CAP_LAY_FINALSTATUS'] != 3 && $value['CAP_LAY_FINALSTATUS'] != 2 && $value['CAP_LAY_FINALSTATUS'] != 5) {
				
				$view .= "<div class='layan-dashboard-box-header-set-delivered'></div>";
				
				}
				
				$view .= "<a class='layan-dashboard-box-header-name-right-document' href='?id=1984&ref=".base64_encode($value['CAP_LAY_ID'])."'></a>";
				
				$view .= "</div>";
				
				$view .= "<div class='layan-dashboard-box-header-name-header-container'>";
				
				$view .= "<div class='layan-dashboard-box-header-document-header-left'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>".$value['CAP_LAY_TRANSACTIONID']."</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>Nomor</span></div>";
				
				$view .= "</div>";
				
				$view .= "<div class='layan-dashboard-box-header-document-header-right'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>".ucwords(strtolower($value['CAP_LAY_TIPEPEMOHON']))."</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>Tipe</span></div>";
				
				$view .= "</div>";
				
				$view .= "</div>";
				
				$view .= "<div class='layan-dashboard-box-content'>";
				
					if (!empty($document)) {
					
					$docuCount = count($document);
					
					$r = 0;
					
					$view .= "<ul>";
					
						foreach ($document as $key => $value) {
							
							$r++;
							
							if ($r == $docuCount) {
							$view .= "<li class='layan-dashboard-lastLI'>".$value['CAP_LAY_DOC_REQ_DOCNAME']."</li>";
							}
							else {
							$view .= "<li>".$value['CAP_LAY_DOC_REQ_DOCNAME']."</li>";
							}
							
						}

					
					$view .= "</ul>";
					
					}
					else {
						
						$view .= "-- No request found --";
						
					}
				
				$view .= "</div>";
				
				$view .= "<div class='layan-dashboard-box-header-document'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>".$count['COUNT']."</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>IP</span></div>";
				
				$view .= "</div>";
				
				$view .= "<div class='layan-dashboard-box-header-document'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>$z</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>Diproses</span></div>";
				
				$view .= "</div>";

				$view .= "<div class='layan-dashboard-box-header-document-last'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>".number_format($percentage,0)."%</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>Selesai</span></div>";
				
				$view .= "</div>";
				
				$view .= "<div class='layan-dashboard-box-header-document-end'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>$waktu</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>Waktu Berlalu</span></div>";
				
				$view .= "</div>";

				$view .= "<div class='layan-dashboard-box-header-document-bottom'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>".$data2['COUNT']."</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>Pem</span></div>";
				
				$view .= "</div>";
				
				$view .= "<div class='layan-dashboard-box-header-document-bottom'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>".$data3['COUNT']."</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>Pen</span></div>";
				
				$view .= "</div>";

				$view .= "<div class='layan-dashboard-box-header-document-bottom'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>".$data4['COUNT']."</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>Per</span></div>";
				
				$view .= "</div>";

				$view .= "<div class='layan-dashboard-box-header-document-bottom-end'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>".$data6['COUNT']."</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>Keb</span></div>";
				
				$view .= "</div>";
			
			$view .= "</div>";
						
		$view .= "</div>";

		unset($percentage);
		
		}

	}
	else {
		
		$view .= "<div class='layan-failed-result'>Record <span style='font-weight:bold;'>$this->data</span> Tidak Ditemukan</div>";
		
	}
			
	echo $view;
		
	}

	public function admin_dashboard() {
	
	$data  = $this->getPermohonanAdminSide();
	
		if (!empty($data)) {	
			$this->preCheck($data);
		}
		
	$data  = $this->getPermohonanAdminSide();

	$view .= $this->optionGear;
	
	$view .= "<div class='layan-overview-container-search'>";
		
		$view .= "<input type='text' class='layan-general-dashboard-input-search-admin' placeholder='Search Permohonan'>";
		
	$view .= "</div>";
	
	$view .= "<div class='layan-dashboard-box-container'>";
	
	if (!empty($data)) {
		$view .= '<div id="dialog-confirm" style="display:none;" title="Anda yakin akan mengubah status menjadi terkirim?">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0; "></span>Dengan mengubah status menjadi terkirim akan menghilangkan permohonan dari sidebar.</p>
</div>';
		foreach ($data as $key => $value ) {
				
		$time  = $this->getTime($value['CAP_LAY_ID']);
		
		$dateTime = $this->getCurrentHolidayDateTimeDashboard(date("Y-m-d"),date("Y-m-d",strtotime($time['DATETIME'])));

		$dateTime2 =  strtotime ( '-'.$dateTime.' day' . date("Y-m-d H:i:s") );
		
		$date1 = new DateTime($time['DATETIME']);
		
		$date3 = date("Y-m-d H:i:s",$dateTime2);
		
		$date2 = new DateTime($date3);
		
		$interval = $date1->diff($date2);
		
		$years = $interval->format('%y');
		    
		$months = $interval->format('%m');
		    
		$days = $interval->format('%d'); 
		    
		$hour = $interval->format('%H'); 
		    
		$minute = $interval->format('%i'); 
		    
		$second = $interval->format('%s');
				
		unset($waktu);
		    
			if ($years != 0) {
			    $waktu  = $years." Tahun ";
		    }
		    if ($months != 0) {
			    $waktu  .= $months." Bulan ";
		    }
			if ($days != 0) {
			    $waktu  .= $days." Hari ";
		    }
		    if ($hour != 0) {
			   	$waktu .= $hour." Jam ";
		    }
		    if ($minute != 0) {
			   	$waktu .= $minute." Menit ";
		    }
		    if ($second != 0) {
			   	$waktu .= $second." Detik ";
		    }
		
		$this->data = $value['CAP_LAY_ID']; 

		$z = 0;

		$document  = $this->getDocument($value['CAP_LAY_ID']);
		
		$count     = $this->getDocumentByCount($value['CAP_LAY_ID']);
		
		$data  = $this->getTotalDocumentByCountByID(); 

		$data2 = $this->getPemberitahuanByCountByID(); 
		
		$data3 = $this->getPenolakanByCountByID();
		
		$data4 = $this->getPerpanjanganByCountByID();
		
		$data6 = $this->getKeberatanByCountByID();
		
		$data5 = $this->getPotentialJobTerlampirByCountByID();
		
		$baseCal = @(100/$data['COUNT']);
		
		if (!empty($document)) {

			foreach ($document as $keyLa => $valueLa) {

				$resultOne = $this->getDocumentPemberitahuanCheck($valueLa['CAP_LAY_DOC_REQ_ID']);

				$resultTwo = $this->getDocumentPenolakanCheck($valueLa['CAP_LAY_DOC_REQ_ID']);

				if (!empty($resultOne) || !empty($resultTwo)) {

					$percentage += $baseCal;

					$z++;

				}

			}

		}

		$view .= "<div class='layan-dashboard-box'>";
			
			$view .= "<div class='layan-dashboard-box-header'>";   
			
				$view .= "<div class='layan-dashboard-box-header-name'><div class='layan-dashboard-box-header-name-left'>".ucwords(strtolower($value['CAP_LAY_NAMA']))."</div>";

				$view .= "<input type='hidden' name='cap-lay-id' value='".$value['CAP_LAY_ID']."'>";
				
				$view .= "<div class='layan-dashboard-box-header-name-right-arrow-down'></div>";

				if (number_format($percentage,0) == 100 && $value['CAP_LAY_FINALSTATUS'] != 3 && $value['CAP_LAY_FINALSTATUS'] != 2 && $value['CAP_LAY_FINALSTATUS'] != 5) {
				
				$view .= "<div class='layan-dashboard-box-header-set-delivered'></div>";
				
				}
				
				$view .= "<a class='layan-dashboard-box-header-name-right-document' href='?id=1971&ref=".base64_encode($value['CAP_LAY_ID'])."'></a>";
				
				$view .= "</div>";
				
				$view .= "<div class='layan-dashboard-box-header-name-header-container'>";
				
				$view .= "<div class='layan-dashboard-box-header-document-header-left'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>".$value['CAP_LAY_TRANSACTIONID']."</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>Nomor</span></div>";
				
				$view .= "</div>";
				
				$view .= "<div class='layan-dashboard-box-header-document-header-right'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>".ucwords(strtolower($value['CAP_LAY_TIPEPEMOHON']))."</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>Tipe</span></div>";
				
				$view .= "</div>";
				
				$view .= "</div>";
				
				$view .= "<div class='layan-dashboard-box-content'>";
				
					if (!empty($document)) {
					
					$docuCount = count($document);
					
					$r = 0;
					
					$view .= "<ul>";
					
						foreach ($document as $key => $value) {
							
							$r++;
							
							if ($r == $docuCount) {
							$view .= "<li class='layan-dashboard-lastLI'>".$value['CAP_LAY_DOC_REQ_DOCNAME']."</li>";
							}
							else {
							$view .= "<li>".$value['CAP_LAY_DOC_REQ_DOCNAME']."</li>";
							}
						
						}
					
					$view .= "</ul>";
					
					}
					else {
						
						$view .= "-- No request found --";
						
					}
				
				$view .= "</div>";
				
				$view .= "<div class='layan-dashboard-box-header-document'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>".$count['COUNT']."</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>IP</span></div>";
				
				$view .= "</div>";
				
				$view .= "<div class='layan-dashboard-box-header-document'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>$z</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>Diproses</span></div>";
				
				$view .= "</div>";

				$view .= "<div class='layan-dashboard-box-header-document-last'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>".number_format($percentage,0)."%</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>Selesai</span></div>";
				
				$view .= "</div>";
				
				$view .= "<div class='layan-dashboard-box-header-document-end'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>$waktu</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>Waktu Berlalu</span></div>";
				
				$view .= "</div>";

				$view .= "<div class='layan-dashboard-box-header-document-bottom'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>".$data2['COUNT']."</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>Pem</span></div>";
				
				$view .= "</div>";
				
				$view .= "<div class='layan-dashboard-box-header-document-bottom'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>".$data3['COUNT']."</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>Pen</span></div>";
				
				$view .= "</div>";

				$view .= "<div class='layan-dashboard-box-header-document-bottom'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>".$data4['COUNT']."</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>Per</span></div>";
				
				$view .= "</div>";

				$view .= "<div class='layan-dashboard-box-header-document-bottom-end'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>".$data6['COUNT']."</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>Keb</span></div>";
				
				$view .= "</div>";
			
			$view .= "</div>";
						
		$view .= "</div>";

		unset($percentage);
		
		}

	}
	else {
	
		$view .= "<div style='font-size:12px;text-align:center;'>Record Tidak Ditemukan</div>";
	
	}
	
	$view .= "</div>";
			
	echo $view;
		
	}
	
	public function admin_dashboard_ajax() {
		
	$data  = $this->getPermohonanAdminSideAjax();
	
	if (!empty($data)) {
		$view .= '<div id="dialog-confirm" style="display:none;" title="Anda yakin akan mengubah status menjadi terkirim?">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0; "></span>Dengan mengubah status menjadi terkirim akan menghilangkan permohonan dari sidebar.</p>
</div>';
		foreach ($data as $key => $value ) {
				
		$time  = $this->getTime($value['CAP_LAY_ID']);
		
		$dateTime = $this->getCurrentHolidayDateTimeDashboard(date("Y-m-d"),date("Y-m-d",strtotime($time['DATETIME'])));
		
		$dateTime2 =  strtotime ( '-'.$dateTime.' day' . date("Y-m-d H:i:s") );

		$date1 = new DateTime($time['DATETIME']);
		
		$date3 = date("Y-m-d H:i:s",$dateTime2);

		$date2 = new DateTime($date3);
		
		$interval = $date1->diff($date2);
		
		$years = $interval->format('%y');
		    
		$months = $interval->format('%m');
		    
		$days = $interval->format('%d'); 
		    
		$hour = $interval->format('%H'); 
		    
		$minute = $interval->format('%i'); 
		    
		$second = $interval->format('%s');

		unset($waktu);
		    
			if ($years != 0) {
			    $waktu  = $years." Tahun ";
		    }
		    if ($months != 0) {
			    $waktu  .= $months." Bulan ";
		    }
			if ($days != 0) {
			    $waktu  .= $days." Hari ";
		    }
		    if ($hour != 0) {
			   	$waktu .= $hour." Jam ";
		    }
		    if ($minute != 0) {
			   	$waktu .= $minute." Menit ";
		    }
		    if ($second != 0) {
			   	$waktu .= $second." Detik ";
		    }
		
		$this->data = $value['CAP_LAY_ID']; 

		$z = 0;

		$document  = $this->getDocument($value['CAP_LAY_ID']);
		
		$count     = $this->getDocumentByCount($value['CAP_LAY_ID']);
		
		$data  = $this->getTotalDocumentByCountByID(); 

		$data2 = $this->getPemberitahuanByCountByID(); 
		
		$data3 = $this->getPenolakanByCountByID();
		
		$data4 = $this->getPerpanjanganByCountByID();
		
		$data6 = $this->getKeberatanByCountByID();
		
		$data5 = $this->getPotentialJobTerlampirByCountByID();
		
		$baseCal = @(100/$data['COUNT']);
		
		if (!empty($document)) {

			foreach ($document as $keyLa => $valueLa) {

				$resultOne = $this->getDocumentPemberitahuanCheck($valueLa['CAP_LAY_DOC_REQ_ID']);

				$resultTwo = $this->getDocumentPenolakanCheck($valueLa['CAP_LAY_DOC_REQ_ID']);

				if (!empty($resultOne) || !empty($resultTwo)) {

					$percentage += $baseCal;

					$z++;

				}

			}

		}
		
		$view .= "<div class='layan-dashboard-box'>";
			
			$view .= "<div class='layan-dashboard-box-header'>";   
			
				$view .= "<div class='layan-dashboard-box-header-name'><div class='layan-dashboard-box-header-name-left'>".ucwords(strtolower($value['CAP_LAY_NAMA']))."</div>";

				$view .= "<input type='hidden' name='cap-lay-id' value='".$value['CAP_LAY_ID']."'>";
				
				$view .= "<div class='layan-dashboard-box-header-name-right-arrow-down'></div>";

				if (number_format($percentage,0) == 100 && $value['CAP_LAY_FINALSTATUS'] != 3 && $value['CAP_LAY_FINALSTATUS'] != 2 && $value['CAP_LAY_FINALSTATUS'] != 5) {
				
				$view .= "<div class='layan-dashboard-box-header-set-delivered'></div>";
				
				}
				
				$view .= "<a class='layan-dashboard-box-header-name-right-document' href='?id=1971&ref=".base64_encode($value['CAP_LAY_ID'])."'></a>";
				
				$view .= "</div>";
				
				$view .= "<div class='layan-dashboard-box-header-name-header-container'>";
				
				$view .= "<div class='layan-dashboard-box-header-document-header-left'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>".$value['CAP_LAY_TRANSACTIONID']."</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>Nomor</span></div>";
				
				$view .= "</div>";
				
				$view .= "<div class='layan-dashboard-box-header-document-header-right'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>".ucwords(strtolower($value['CAP_LAY_TIPEPEMOHON']))."</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>Tipe</span></div>";
				
				$view .= "</div>";
				
				$view .= "</div>";
				
				$view .= "<div class='layan-dashboard-box-content'>";
				
					if (!empty($document)) {
					
					$docuCount = count($document);
					
					$r = 0;
					
					$view .= "<ul>";
					
						foreach ($document as $key => $value) {
							
							$r++;
							
							if ($r == $docuCount) {
							$view .= "<li class='layan-dashboard-lastLI'>".$value['CAP_LAY_DOC_REQ_DOCNAME']."</li>";
							}
							else {
							$view .= "<li>".$value['CAP_LAY_DOC_REQ_DOCNAME']."</li>";
							}
							
						}
					
					$view .= "</ul>";
					
					}
					else {
						
						$view .= "-- No request found --";
						
					}
				
				$view .= "</div>";
				
				$view .= "<div class='layan-dashboard-box-header-document'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>".$count['COUNT']."</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>IP</span></div>";
				
				$view .= "</div>";
				
				$view .= "<div class='layan-dashboard-box-header-document'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>$z</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>Diproses</span></div>";
				
				$view .= "</div>";

				$view .= "<div class='layan-dashboard-box-header-document-last'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>".number_format($percentage,0)."%</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>Selesai</span></div>";
				
				$view .= "</div>";
				
				$view .= "<div class='layan-dashboard-box-header-document-end'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>$waktu</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>Waktu Berlalu</span></div>";
				
				$view .= "</div>";

				$view .= "<div class='layan-dashboard-box-header-document-bottom'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>".$data2['COUNT']."</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>Pem</span></div>";
				
				$view .= "</div>";
				
				$view .= "<div class='layan-dashboard-box-header-document-bottom'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>".$data3['COUNT']."</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>Pen</span></div>";
				
				$view .= "</div>";

				$view .= "<div class='layan-dashboard-box-header-document-bottom'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>".$data4['COUNT']."</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>Per</span></div>";
				
				$view .= "</div>";

				$view .= "<div class='layan-dashboard-box-header-document-bottom-end'>";
				
					$view .= "<div class='layan-dashboard-box-header-document-large'>".$data6['COUNT']."</div>";
					
					$view .= "<div class='layan-dashboard-box-header-document-small'><span class='not-bold'>Keb</span></div>";
				
				$view .= "</div>";
			
			$view .= "</div>";
						
		$view .= "</div>";

		unset($percentage);
		
		}

	}
	else {
		
		$view .= "<div class='layan-failed-result'>Record <span style='font-weight:bold;'>$this->data</span> Tidak Ditemukan</div>";
		
	}
			
	echo $view;
		
	}
	
	public function counter() {
		
		$view .= $this->optionGear;
		
		$data  = $this->getDocumentTerlampirByCount(); 
		
		$data2 = $this->getDocumentTerlampirNotFinalByCount();
		
		$data3 = $this->geJobTerlampirByCount();
		
		$data4 = $this->gePotentialJobTerlampirByCount();
		
		$view .= "<div class='layan-counter-container'>";
		
			$view .= "<div class='layan-counter-container-1'>";
			
				$view .= "<div class='layan-counter-container-1-inside'>";
				
					$view .= "<div class='layan-counter-container-1-insideBottom1'>".$data3['COUNT']."</div>";
					
					$view .= "<div class='layan-counter-container-1-insideBottom2'>Permohonan</div>";
					
				$view .= "</div>";
			
			$view .= "</div>";
			
			$view .= "<div class='layan-counter-container-2'>";
							
				$view .= "<div class='layan-counter-container-2-inside'>";
				
					$view .= "<div class='layan-counter-container-2-insideBottom1'>".$data['COUNT']."</div>";
					
					$view .= "<div class='layan-counter-container-2-insideBottom2'>Informasi Publik</div>";
					
				$view .= "</div>";
			
			$view .= "</div>";
			
			$view .= "<div class='layan-counter-container-3'>";
							
				$view .= "<div class='layan-counter-container-3-inside'>";
				
					$view .= "<div class='layan-counter-container-3-insideBottom1'>".$data4['COUNT']."</div>";
					
					$view .= "<div class='layan-counter-container-3-insideBottom2'>Next Permohonan</div>";
					
				$view .= "</div>";
			
			$view .= "</div>";
			
			$view .= "<div class='layan-counter-container-4'>";
							
				$view .= "<div class='layan-counter-container-4-inside'>";
				
					$view .= "<div class='layan-counter-container-4-insideBottom1'>".$data2['COUNT']."</div>";
					
					$view .= "<div class='layan-counter-container-4-insideBottom2'>Next Informasi Publik</div>";
					
				$view .= "</div>";
			
			$view .= "</div>";
		
		$view .= "</div>";
		
		echo $view;
		
	}

	public function user_counter() {
		
		$view .= $this->optionGear;
		
		$data  = $this->getDocumentTerlampirByCountUser(); 
		
		$data2 = $this->getDocumentTerlampirNotFinalByCountUser();
		
		$data3 = $this->geJobTerlampirByCountUser();
		
		$data4 = $this->gePotentialJobTerlampirByCountUser();
		
		$view .= "<div class='layan-counter-container'>";
		
			$view .= "<div class='layan-counter-container-1'>";
			
				$view .= "<div class='layan-counter-container-1-inside'>";
				
					$view .= "<div class='layan-counter-container-1-insideBottom1'>".$data3['COUNT']."</div>";
					
					$view .= "<div class='layan-counter-container-1-insideBottom2'>Permohonan</div>";
					
				$view .= "</div>";
			
			$view .= "</div>";
			
			$view .= "<div class='layan-counter-container-2'>";
							
				$view .= "<div class='layan-counter-container-2-inside'>";
				
					$view .= "<div class='layan-counter-container-2-insideBottom1'>".$data['COUNT']."</div>";
					
					$view .= "<div class='layan-counter-container-2-insideBottom2'>Informasi Publik</div>";
					
				$view .= "</div>";
			
			$view .= "</div>";
			
			$view .= "<div class='layan-counter-container-3'>";
							
				$view .= "<div class='layan-counter-container-3-inside'>";
				
					$view .= "<div class='layan-counter-container-3-insideBottom1'>".$data4['COUNT']."</div>";
					
					$view .= "<div class='layan-counter-container-3-insideBottom2'>Next Permohonan</div>";
					
				$view .= "</div>";
			
			$view .= "</div>";
			
			$view .= "<div class='layan-counter-container-4'>";
							
				$view .= "<div class='layan-counter-container-4-inside'>";
				
					$view .= "<div class='layan-counter-container-4-insideBottom1'>".$data2['COUNT']."</div>";
					
					$view .= "<div class='layan-counter-container-4-insideBottom2'>Next Informasi Publik</div>";
					
				$view .= "</div>";
			
			$view .= "</div>";
		
		$view .= "</div>";
		
		echo $view;
		
	}

	public function admin_counter() {
		
		$view .= $this->optionGear;
		
		$data  = $this->getDocumentTerlampirByCount(); 
		
		$data2 = $this->getDocumentTerlampirNotFinalByCount();
		
		$data3 = $this->geJobTerlampirByCount();
		
		$data4 = $this->gePotentialJobTerlampirByCount();
		
		$view .= "<div class='layan-counter-container'>";
		
			$view .= "<div class='layan-counter-container-1'>";
			
				$view .= "<div class='layan-counter-container-1-inside'>";
				
					$view .= "<div class='layan-counter-container-1-insideBottom1'>".$data3['COUNT']."</div>";
					
					$view .= "<div class='layan-counter-container-1-insideBottom2'>Permohonan</div>";
					
				$view .= "</div>";
			
			$view .= "</div>";
			
			$view .= "<div class='layan-counter-container-2'>";
							
				$view .= "<div class='layan-counter-container-2-inside'>";
				
					$view .= "<div class='layan-counter-container-2-insideBottom1'>".$data['COUNT']."</div>";
					
					$view .= "<div class='layan-counter-container-2-insideBottom2'>Informasi Publik</div>";
					
				$view .= "</div>";
			
			$view .= "</div>";
			
			$view .= "<div class='layan-counter-container-3'>";
							
				$view .= "<div class='layan-counter-container-3-inside'>";
				
					$view .= "<div class='layan-counter-container-3-insideBottom1'>".$data4['COUNT']."</div>";
					
					$view .= "<div class='layan-counter-container-3-insideBottom2'>Next Permohonan</div>";
					
				$view .= "</div>";
			
			$view .= "</div>";
			
			$view .= "<div class='layan-counter-container-4'>";
							
				$view .= "<div class='layan-counter-container-4-inside'>";
				
					$view .= "<div class='layan-counter-container-4-insideBottom1'>".$data2['COUNT']."</div>";
					
					$view .= "<div class='layan-counter-container-4-insideBottom2'>Next Informasi Publik</div>";
					
				$view .= "</div>";
			
			$view .= "</div>";
		
		$view .= "</div>";
		
		echo $view;
		
	}
	
	public function detailDokumen() {
		
		$data  = $this->getSingleDocument();
				
		$view  = "<div class='layan-detailDokumen-container'>";
		
			$view .= "<div class='layan-detailDokumen-container-header'>";
			
				$view .= "<div class='layan-detailDokumen-container-header-name'></div>";
				
				$view .= "<div class='layan-detailDokumen-container-header-document'>".strtoupper($data['CAP_LAY_DOC_REQ_DOCNAME'])."</div>";
				
				$view .= "<div class='layan-detailDokumen-container-header-reason'><div class='layan-detailDokumen-container-header-reason-inside'>".ucfirst(strtolower($data['CAP_LAY_DOC_REQ_REASON']))."</div></div>";
						
			$view .= "</div>";
			
			$view .= "<div class='layan-detailDokumen-container-header-action'>";
			
				$view .= "<div><div class='layan-detailDokumen-pemberitahuan-button qtip-upper' text='Form Pemberitahuan Tertulis'></div></div>";
				
				$view .= "<div><div class='layan-detailDokumen-perpanjangan-button qtip-upper' text='Form Perpanjangan Waktu'></div></div>";
				
				$view .= "<div><div class='layan-detailDokumen-penolakan-button qtip-upper' text='Form Penolakan'></div></div>";
						
			$view .= "</div>";
			
			$view .= "<div class='layan-detailDokumen-container-header-form'>";
									
			$view .= "</div>";
		
		$view .= "</div>";
		
		echo $view;
		
	}
	
	public function dashboard_old() {
	
	$data  = $this->getPermohonan();
	
	$view .= $this->optionGear;
	
	$view .= "<table class='layan-normal-table-multiple'>";
										
	$view .= "<tr>";
												
		$view .= "<td class='layan-normal-form-bold' colspan='4'><hr class='layan-normal-form-hr'></td>";
											
	$view .= "</tr>";
					
	$view .= "<tr>";
					
		$view .= "<td class='layan-normal-form-td2st'>Action</td>";
						
		$view .= "<td class='layan-normal-form-td3st layan-dashboard-left'>ID</td>";
						
		$view .= "<td class='layan-normal-form-td3st'>Jumlah</td>";
		
		$view .= "<td class='layan-normal-form-td3st layan-dashboard-right'>Waktu</td>";
											
	$view .= "</tr>";
					
	$view .= "<tr>";
						
		$view .= "<td class='layan-normal-form-bold' colspan='4'><hr class='layan-normal-form-hr'></td>";
											
	$view .= "</tr>";

		foreach ($data as $key => $value ) {
		
		$time  = $this->getTime($value['CAP_LAY_ID']);
		
		$date1 = new DateTime($time['DATETIME']);
	    $date2 = new DateTime("now");
	    $interval = $date1->diff($date2);
	    $years = $interval->format('%y');
	    $months = $interval->format('%m');
	    $days = $interval->format('%d'); 
	    $hour = $interval->format('%h'); 
	    $minute = $interval->format('%i'); 
	    $second = $interval->format('%s');
	    unset($waktu);
	    
	    	if ($years != 0) {
			    $waktu  = $years." Tahun ";
		    }
		    if ($months != 0) {
			    $waktu  .= $months." Bulan ";
		    }
			if ($days != 0) {
			    $waktu  .= $days." Hari ";
		    }
		    if ($hour != 0) {
			   	$waktu .= $hour." Jam ";
		    }
		    if ($minute != 0) {
			   	$waktu .= $minute." Menit ";
		    }
		    if ($second != 0) {
			   	$waktu .= $second." Detik ";
		    }
		
		$document  = $this->getDocumentByCount($value['CAP_LAY_ID']);
				
			$view .= "<tr class='layan-normal-table-tr-hover'>";
							
			$view .= "<td class='layan-normal-form-td2st'><div class='layan-normal-inside-button'></div></div></td>";
						
			$view .= "<td><input class='layan-dashboard-id-row' type='hidden' value='".$value['CAP_LAY_ID']."'>".$value['CAP_LAY_TRANSACTIONID']."</td>";
							
			$view .= "<td class='layan-dashboard-center'>".$document['COUNT(FK_CAP_LAY_ID)']."</td>";
			
			$view .= "<td class='layan-dashboard-right'>$waktu</td>";
			
			$view .= "</tr>";
										
		}
										
	$view .= "<tr>";
						
		$view .= "<td class='layan-normal-form-bold' colspan='4'><hr class='layan-normal-form-hr'></td>";
											
	$view .= "</tr>";
				
	$view .= "</table>";
			
	echo $view;
		
	}
	
	public function dokumen() {
	
	$data  = $this->getDokumenLengkap();

	$namaPemohonIP = ucwords(strtolower($data['CAP_LAY_NAMA']));

	
	    $view .= "<div class='layan-permohonan-print'><div class='layan-permohonan-back-button'></div><div class='layan-permohonan-print-button'></div></div>";
		
		$view .= "<div class='layan-permohonan-container'>";
				
			$view .= "<div class='layan-permohonan-main-header'>
					  <br/>
					  <span class='layan-permohonan-print-header-0'><img class='layan-permohonan-print-header-img' style='width:75px;height:75px;' src='".$data['CAP_LAY_BRA_LOGO']."'/></span>
					  <span class='layan-permohonan-print-header-1'>".$data['CAP_LAY_BRA_NAME']."</span><br/>
					  <span class='layan-permohonan-print-header-2'>".$data['CAP_LAY_BRA_TAGLINE1']."</span><br/>
					  <span class='layan-permohonan-print-header-2'>".$data['CAP_LAY_BRA_TAGLINE2']."</span><br/><br/>
			
					 </div>";
						
			$view .= "<div class='layan-permohonan-main-header-secondary'>
			
					  <span class='layan-permohonan-print-header-3'>".$data['CAP_LAY_BRA_ADDRESS']."</span><br/>
					  <span class='layan-permohonan-print-header-3'>Telp. ".$data['CAP_LAY_BRA_TELEPHONE'].", Fax. ".$data['CAP_LAY_BRA_FAX']."</span><br/>
					  <span class='layan-permohonan-print-header-3'>Website ".$data['CAP_LAY_BRA_WEBSITE']." Email: ".$data['CAP_LAY_BRA_EMAIL']."</span>
			
					 </div>";
							
		$view .= "<br/>";
		
			
			$view .= "<div class='layan-permohonan-main-header-tertiary'>
			
					  <span class='layan-permohonan-print-fourtiary'></span><br/>
					  <span class='layan-permohonan-print-fourtiary'>FORM PERMOHONAN INFORMASI PUBLIK</span><br/>
					  <span class='layan-permohonan-print-fourtiary'>  ".ucwords(strtolower($data['CAP_LAY_TIPEPEMOHON']))."</span><br/>

					
					  <span class='layan-permohonan-print-fifthiary'>No. Pendaftaran: ".$data['CAP_LAY_TRANSACTIONID']."</span>
			
					 </div>";
					 
		$view .= "<br/>";
		
					 
			$view .= "<div class='layan-permohonan-main-header-sixthtiary'>
			
					 	<table class='layan-permohonan-table'>
					 	
					 		
					 		<tr>
					 			
					 			<td class='layan-permohonan-td-header'>Nama Lengkap</td>
					 			
					 			<td>:</td>
					 			
					 			<td>".ucwords(strtolower($data['CAP_LAY_NAMA']))."</td>
					 		
					 		</tr>";
					 		
			$view .=		"
							
							<tr>
					 			
					 			<td class='layan-permohonan-td-header'>Pekerjaan</td>
					 			
					 			<td>:</td>
					 			
					 			<td>".ucwords(strtolower($data['CAP_LAY_PEKERJAAN']))."</td>
					 		
					 		</tr>
							
							<tr>
					 			
					 			<td class='layan-permohonan-td-header'>Alamat Lengkap</td>
					 			
					 			<td>:</td>
					 			
					 			<td>".ucwords(strtolower($data['CAP_LAY_ALAMAT']))."</td>
					 		
					 		</tr>
					 		
					 		<tr>
					 			
					 			<td class='layan-permohonan-td-header'>Nomor KTP</td>
					 			
					 			<td>:</td>
					 			
					 			<td>".$data['CAP_LAY_KTP']."</td>
					 		
					 		</tr>
					 		
					 		<tr>
					 			
					 			<td class='layan-permohonan-td-header'>Nomor Telepon/HP </td>
					 			
					 			<td>:</td>
					 			
					 			<td>".ucwords(strtolower($data['CAP_LAY_TELEPON']))."</td>
					 	
					 	   </tr>
					 	    <tr>
					 		
					 			<td class='layan-permohonan-td-header'>E-mail</td>
					 			
					 			<td>:</td>
					 			
					 			<td>".ucwords(strtolower($data['CAP_LAY_EMAIL']))."</td>
					 		
					 		</tr>
					 	   
					 	   <tr>
					 		
					 			<td class='layan-permohonan-td-header'>Cara Memperoleh Informasi</td>
					 			
					 			<td style='vertical-align: text-top;' >:</td><td><span>";
					 			
					 			
					 			if($data['CAP_LAY_INFORMASI'] == 'MELIHAT/MEMBACA/MENDENGARKAN/MENCATAT'){
						 			$view .= "<img src='view/pages/system/images/checkbox_checked.png' width='12px' height='12px' style='margin-top:1px; margin-right:5px; float:left;' />";
					 			}
					 			else{$view .= "<img src='view/pages/system/images/checkbox_unchecked.png' width='12px' height='12px' style='margin-top:1px; margin-right:5px; float:left;' />";}
					 			 
					 			
					 			$view .=" Melihat/membaca/mendengarkan/mecatat</span></br>
					 			<span>";
					 			
					 			
					 			if($data['CAP_LAY_INFORMASI'] == 'MENDAPATKAN INFORMASI SALINAN HARDCOPY'){
						 				$view .= "<img src='view/pages/system/images/checkbox_checked.png' width='12px' height='12px' style='margin-top:1px; margin-right:5px; float:left;' />";
					 			}
					 			else{$view .= "<img src='view/pages/system/images/checkbox_unchecked.png' width='12px' height='12px' style='margin-top:1px; margin-right:5px; float:left;' />";}
					 			 
					 			
					 			$view .=" Mendapatkan salinan informasi hardcopy</span></br>
					 			<span>";
					 			
					 			
					 			if($data['CAP_LAY_INFORMASI'] == 'MENDAPATKAN INFORMASI SALINAN SOFTCOPY'){
						 				$view .= "<img src='view/pages/system/images/checkbox_checked.png' width='12px' height='12px' style='margin-top:1px; margin-right:5px; float:left;' />";
					 			}
					 			else{$view .= "<img src='view/pages/system/images/checkbox_unchecked.png' width='12px' height='12px' style='margin-top:1px; margin-right:5px; float:left;' />";}
					 			 
					 			
					 			$view .=" Mendapatkan salinan informasi softcopy</span></td>
					 		
					 		</tr>
					 		<tr>
					 		
					 			<td class='layan-permohonan-td-header'>Cara Mendapatkan Salinan Informasi</td>
					 			
					 			<td style='vertical-align: text-top;' >:</td>
					 			
					 			<td>";
					 			
					 			
					 			if($data['CAP_LAY_SALINAN'] == 'MENGAMBIL LANGSUNG'){
						 				$view .= "<img src='view/pages/system/images/checkbox_checked.png' width='12px' height='12px' style='margin-top:1px; margin-right:5px; float:left;' />";
					 			}
					 			else{$view .= "<img src='view/pages/system/images/checkbox_unchecked.png' width='12px' height='12px' style='margin-top:1px; margin-right:5px; float:left;' />";}
					 			 
					 			
					 			$view .=" Mengambil langsung</span></br>
					 			<span>";
					 			
					 			
					 			if($data['CAP_LAY_SALINAN'] == 'DIKIRIM MELALUI EMAIL'){
						 				$view .= "<img src='view/pages/system/images/checkbox_checked.png' width='12px' height='12px' style='margin-top:1px; margin-right:5px; float:left;' />";
					 			}
					 			else{$view .= "<img src='view/pages/system/images/checkbox_unchecked.png' width='12px' height='12px' style='margin-top:1px; margin-right:5px; float:left;' />";}
					 			 
					 			
					 			$view .=" Dikirim melalui email</span></br>
					 			<span>";
					 			
					 			
					 			if($data['CAP_LAY_SALINAN'] == 'LAINNYA'){
						 				$view .= "<img src='view/pages/system/images/checkbox_checked.png' width='12px' height='12px' style='margin-top:1px; margin-right:5px; float:left;' />";
					 			}
					 			else{$view .= "<img src='view/pages/system/images/checkbox_unchecked.png' width='12px' height='12px' style='margin-top:1px; margin-right:5px; float:left;' />";}
					 			 
					 			
					 			$view .=" Lainnya</span></td>
					 		
					 		</tr>
					 		
					 	
					 	</table>	
					 				
					 </div>";
			$view .="<span style='margin-left:30px;font-size:13px;'>Informasi Publik Yang diminta</span>";
					 
					 
					 
					 
			$view .= "<br/>";
			 $view .= " <table class='layan-permohonan-table-list twitters-style-table'>
		    		   
		    		  <thead>
		    		   
		              <tr>
		              
		              <td style='width: 20px; border-right: 1px solid #000; border-bottom: 1px solid #000; font-weight:bold;'>No</td>
		              
		              <td style='border-bottom: 1px solid #000; font-weight:bold;'>Nama Informasi Publik</td>
		              
		              <td style='border-bottom: 1px solid #000; text-align:left; font-weight:bold;'>Alasan Pengunaan Informasi</td>
		              
		              <td style='border-bottom: 1px solid #000; text-align:center; font-weight:bold;'></td></tr>
		              
		              </thead>
		              
		              <tbody>
		              
		              ";
		    $datecreated = date::indonesianMonth($data['CAP_LAY_DATECREATED']);          
		$i = 1;           			 
		
			if (!empty($data['CAP_LAY_DATETANDAB'])) {
		
				$dateTandaTerima = date::indonesianMonth($data['CAP_LAY_DATETANDAB']);
				
			}
			else {
				
				$dateTandaTerima = '[isi Tanggal Tanda Terima]';
				
			}
		
		$data = $this->getDokumenList($data['CAP_LAY_ID']);
		
		if (!empty($data)) {
		
		//print_r($data);
			foreach ($data as $key => $value ) {
				
				if (!empty($value['CAP_LAY_DOC_REQ_ID'])) {
				
				$view .=  "<tr class='layan-document-tr-clickables' style='border-bottom: 1px solid #000;'>
							<td style='width: 20px; border-right: 1px solid #000; text-align:center;'>".$i++."</td>
							<td><input type='hidden' value='".$value['CAP_LAY_DOC_REQ_ID']."'>".$value['CAP_LAY_DOC_REQ_DOCNAME']."</td>
							<td ><input type='hidden' value='".$value['CAP_LAY_DOC_REQ_ID']."'>".$value['CAP_LAY_DOC_REQ_REASON']."</td>
							<td style='text-align:center;'></td>
						   </tr>";
				
				}
							
			}   	
		
		}
		
		$view .= "</tbody>";			 
			
		$view .= "</table>";	
			$view .= "<br/><br/></br>";
		
		//print_r($data);
		$view .="<div class='layan-form-detail-perpanjangan-container'>
		<div style='float:right;width:200px;text-align:left; font-size:12px;'>Jakarta, ".$datecreated."</div>
		</br>
		<div style='float:left;width:250px;text-align:center; font-size:12px;'>Petugas Pelayanan Informasi</div>
		
		<div style='float:right;width:250px;text-align:center; font-size:12px;'>Pemohon Informasi</div>
		
		</div>";
		
		$view .= "<br/>";
		
		$view .= "<br/>";

		$view .= "<br/>";

				
		$view .= "<br/>";
		
			if (!empty($datas['CAP_LAY_KEB_NAME'])) {
				$namaPengaju = ucwords(strtolower($datas['CAP_LAY_KEB_NAME']));
			}
			else {
				$namaPengaju = ucwords(strtolower($datas['CAP_LAY_NAMA']));
			}
		
		$view .="<div class='layan-form-detail-perpanjangan-container'>
		
		<div style='float:left;width:250px;text-align:center; font-size:12px;' >".$this->getUserName()."</div>
		
		<div style='float:right;width:250px;text-align:center;font-size:12px;'>".$namaPemohonIP."</div>
		
		</div>";
		
		$view .= "<br/>";
		
		$view .="<div class='layan-form-detail-perpanjangan-container'>
		
		<div style='float:left;width:250px;text-align:center; line-height:0px;'>.........................................</div>
		
		<div style='float:right;width:250px;text-align:center; line-height:0px;'>.........................................</div>
		
		</div>";
		
		$view .= "<br/>";
		
		$view .="<div class='layan-form-detail-perpanjangan-container'>
		
		<div style='float:left;width:250px;text-align:center; line-height:0px; font-size:12px;'>Nama dan Tanda Tangan</div>
		
		<div style='float:right;width:250px;text-align:center; line-height:0px; font-size:12px;'>Nama dan Tanda Tangan</div>
		
		</div>";
		
		$view .= "<br/>";
			
		$view .= "</div>";
			
			
					 
            $view .= "</div>";
 
 $datas  = $this->getDokumenLengkap();
		$view .= "<div class='layan-permohonan-print'><div class='layan-permohonan-back-button'></div><div class='layan-permohonan-print-button-ex'></div></div>";
		
		$view .= "<div class='layan-permohonan-container-2'>";
				
			$view .= "<div class='layan-permohonan-main-header'>
					  <br/>
					  <span class='layan-permohonan-print-header-0'><img class='layan-permohonan-print-header-img' style='width:70px;height:70px;' src='".$datas['CAP_LAY_BRA_LOGO']."'/></span>
					  <span class='layan-permohonan-print-header-1'>".$datas['CAP_LAY_BRA_NAME']."</span><br/>
					  <span class='layan-permohonan-print-header-2'>".$datas['CAP_LAY_BRA_TAGLINE1']."</span><br/>
					  <span class='layan-permohonan-print-header-2'>".$datas['CAP_LAY_BRA_TAGLINE2']."</span><br/><br/>
			
					 </div>";
						
			$view .= "<div class='layan-permohonan-main-header-secondary'>
			
					   <span class='layan-permohonan-print-header-3'>".$datas['CAP_LAY_BRA_ADDRESS']."</span><br/>
					  <span class='layan-permohonan-print-header-3'>Telp. ".$datas['CAP_LAY_BRA_TELEPHONE'].", Fax. ".$datas['CAP_LAY_BRA_FAX']."</span><br/>
					  <span class='layan-permohonan-print-header-3'>Website ".$datas['CAP_LAY_BRA_WEBSITE']." Email: ".$datas['CAP_LAY_BRA_EMAIL']."</span>
			
					 </div>";
							
		$view .= "<br/>";
			
			$view .= "<div class='layan-permohonan-main-header-tertiary'>
			
					  <span class='layan-permohonan-print-fourtiary'>TANDA BUKTI</span><br/>
					  <span class='layan-permohonan-print-fourtiary'>PENERIMAAN PERMINTAAN INFORMASI PUBLIK</span><br/>
					  <span class='layan-permohonan-print-fifthiary'>No. Pendaftaran: ".$datas['CAP_LAY_TRANSACTIONID']."</span>
			
					 </div>";
					 
		$view .= "<br/>";
			
			$view .= "<div class='layan-permohonan-main-header-sixthtiary'>
			
					 	<table class='layan-permohonan-table'>
					 	
					 		<tr>
					 			
					 			<td class='layan-permohonan-td-header'>Tipe Pemohon</td>
					 			
					 			<td>:</td>
					 			
					 			<td>".ucwords(strtolower($datas['CAP_LAY_TIPEPEMOHON']))."</td>
					 			
					 		</tr>
					 		
					 		<tr>
					 			
					 			<td class='layan-permohonan-td-header'>Nama</td>
					 			
					 			<td>:</td>
					 			
					 			<td>".ucwords(strtolower($datas['CAP_LAY_NAMA']))."</td>
					 		
					 		</tr>";
					 		
			
			if (!empty($datas['CAP_LAY_NAMA_BADAN'])) {
					 		
			$view .=		"<tr>
					 			
					 			<td class='layan-permohonan-td-header'>Nama Badan</td>
					 			
					 			<td>:</td>
					 			
					 			<td>".ucwords(strtolower($datas['CAP_LAY_NAMA_BADAN']))."</td>
					 		
					 		</tr>";
			
			}
					 		
			$view .=		"
							
							<tr>
					 			
					 			<td class='layan-permohonan-td-header'>Alamat</td>
					 			
					 			<td>:</td>
					 			
					 			<td>".ucwords(strtolower($datas['CAP_LAY_ALAMAT']))."</td>
					 		
					 		</tr>
							
							<tr>
					 			
					 			<td class='layan-permohonan-td-header'>Telepon</td>
					 			
					 			<td>:</td>
					 			
					 			<td>".$datas['CAP_LAY_TELEPON']."</td>
					 		
					 		</tr>
					 		
					 		<tr>
					 			
					 			<td class='layan-permohonan-td-header'>Email</td>
					 			
					 			<td>:</td>
					 			
					 			<td>".$datas['CAP_LAY_EMAIL']."</td>
					 		
					 		</tr>
					 		
					 		<tr>
					 			
					 			<td class='layan-permohonan-td-header'>Cara memperoleh informasi </td>
					 			
					 			<td>:</td>
					 			
					 			<td>".ucwords(strtolower($datas['CAP_LAY_INFORMASI']))."</td>
					 	
					 	   </tr>
					 	   
					 	   <tr>
					 		
					 			<td class='layan-permohonan-td-header'>Cara mendapatkan salinan informasi</td>
					 			
					 			<td>:</td>
					 			
					 			<td>".ucwords(strtolower($datas['CAP_LAY_SALINAN']))."</td>
					 		
					 		</tr>
					 		
					 	
					 	</table>	
					 				
					 </div>";
					 
			$view .= "<br/>";
					 
		    $view .= " <table class='layan-permohonan-table-list twitters-style-table'>
		    		   
		    		  <thead>
		    		   
		              <tr>
		              
		              <td style='width: 20px; border-right: 1px solid #000; border-bottom: 1px solid #000; font-weight:bold;'>No</td>
		              
		              <td style='border-bottom: 1px solid #000; font-weight:bold;'>Nama Informasi Publik</td>
		              
		              <td style='border-bottom: 1px solid #000; text-align:left; font-weight:bold;'>Alasan Pengunaan Informasi</td>
		              
		              <td style='border-bottom: 1px solid #000; text-align:center; font-weight:bold;'></td></tr>
		              
		              </thead>
		              
		              <tbody>
		              
		              ";
		              
		$i = 1;           			 
		
			if (!empty($datas['CAP_LAY_DATETANDAB'])) {
		
				$dateTandaTerima = date::indonesianMonth($datas['CAP_LAY_DATETANDAB']);
				
			}
			else {
				
				$dateTandaTerima = '[isi Tanggal Tanda Terima]';
				
			}
		
		$datas = $this->getDokumenList($datas['CAP_LAY_ID']);
		
		if (!empty($datas)) {
		
		//print_r($data);
			foreach ($datas as $key => $value ) {
				
				if (!empty($value['CAP_LAY_DOC_REQ_ID'])) {
				
				$view .=  "<tr class='layan-document-tr-clickables' style='border-bottom: 1px solid #000;'>
							<td style='width: 20px; border-right: 1px solid #000; text-align:center;'>".$i++."</td>
							<td><input type='hidden' value='".$value['CAP_LAY_DOC_REQ_ID']."'>".$value['CAP_LAY_DOC_REQ_DOCNAME']."</td>
							<td ><input type='hidden' value='".$value['CAP_LAY_DOC_REQ_ID']."'>".$value['CAP_LAY_DOC_REQ_REASON']."</td>
							<td style='text-align:center;'></td>
						   </tr>";
				
				}
							
			}   	
		
		}
		
		$view .= "</tbody>";			 
			
		$view .= "</table>";	
		
		$view .= "<br/><br/></br>";
		
		//print_r($data);
		$view .="<div class='layan-form-detail-perpanjangan-container'>
		<div style='float:right;width:200px;text-align:left; font-size:12px;'>Jakarta, ".$dateTandaTerima."</div>
		</br>
		<div style='float:left;width:250px;text-align:center; font-size:12px;'>Petugas Pelayanan Informasi</div>
		
		<div style='float:right;width:250px;text-align:center; font-size:12px;'>Pemohon Informasi</div>
		
		</div>";
		
		$view .= "<br/>";
		
		$view .= "<br/>";

		$view .= "<br/>";

				
		$view .= "<br/>";
		
			if (!empty($datas['CAP_LAY_KEB_NAME'])) {
				$namaPengaju = ucwords(strtolower($datas['CAP_LAY_KEB_NAME']));
			}
			else {
				$namaPengaju = ucwords(strtolower($datas['CAP_LAY_NAMA']));
			}
		
		$view .="<div class='layan-form-detail-perpanjangan-container'>
		
		<div style='float:left;width:250px;text-align:center; font-size:12px;' >".$this->getUserName()."</div>
		
		<div style='float:right;width:250px;text-align:center;font-size:12px;'>".$namaPemohonIP."</div>
		
		</div>";
		
		$view .= "<br/>";
		
		$view .="<div class='layan-form-detail-perpanjangan-container'>
		
		<div style='float:left;width:250px;text-align:center; line-height:0px;'>.........................................</div>
		
		<div style='float:right;width:250px;text-align:center; line-height:0px;'>.........................................</div>
		
		</div>";
		
		$view .= "<br/>";
		
		$view .="<div class='layan-form-detail-perpanjangan-container'>
		
		<div style='float:left;width:250px;text-align:center; line-height:0px; font-size:12px;'>Nama dan Tanda Tangan</div>
		
		<div style='float:right;width:250px;text-align:center; line-height:0px; font-size:12px;'>Nama dan Tanda Tangan</div>
		
		</div>";
		
		$view .= "<br/>";
			
		$view .= "</div>";
			
		$view .= "</div>";
		
	echo $view;

	
	}

	public function printPemberitahuan() {
	
	$arrayData  = $this->getPemberitahuanLengkapPrint();

	//print_r($arrayData);
	foreach ($arrayData as $key => $value) {
	
foreach ($value['pemberitahuan'] as $key => $data ) {

		$view .= "<div>";
			$view .= "<div class='layan-permohonan-print'>
						
						<div class='layan-permohonan-back-button'></div>
						<div class='layan-pemberitahuan-print-button'></div>
					</div>";
					
			$view .= "<div class='layan-pemberitahuan-container'>";
			$view .= "<div class='layan-permohonan-container-inside'>";
				
				$view .= "<div class='layan-permohonan-main-header'>
					  <br/>
					  <span class='layan-permohonan-print-header-0'><img class='layan-permohonan-print-header-img' style='width:70px;height:70px;' src='".$data['CAP_LAY_BRA_LOGO']."'/></span>
					  <span class='layan-permohonan-print-header-1'>".$data['CAP_LAY_BRA_NAME']."</span><br/>
					  <span class='layan-permohonan-print-header-2'>".$data['CAP_LAY_BRA_TAGLINE1']."</span><br/>
					  <span class='layan-permohonan-print-header-2'>".$data['CAP_LAY_BRA_TAGLINE2']."</span><br/><br/>
			
					 </div>";
						
			$view .= "<div class='layan-permohonan-main-header-secondary'>
			
					  <span class='layan-permohonan-print-header-3'>".$data['CAP_LAY_BRA_ADDRESS']."</span><br/>
					  <span class='layan-permohonan-print-header-3'>Telp. ".$data['CAP_LAY_BRA_TELEPHONE'].", Fax. ".$data['CAP_LAY_BRA_FAX']."</span><br/>
					  <span class='layan-permohonan-print-header-3'>Website ".$data['CAP_LAY_BRA_WEBSITE']." Email: ".$data['CAP_LAY_BRA_EMAIL']."</span>
			
					 </div>";
							
					 	 $view .= "<br/>";
				
				$view .= "<div class='layan-permohonan-main-header-tertiary'>
			
					  
					 	 	<span class='layan-permohonan-print-fourtiary'>FORMULIR PEMBERITAHUAN TERTULIS</span><br/>
					 	 	<span class='layan-permohonan-print-fifthiary'>Nomor: ".$data['CAP_LAY_PEM_NUMBER']."</span>
			
					 	 </div>";
					 
		
					 	 $view .= "<br/>";
		
		
					 	 $view .="<div class='layan-form-detail-perpanjangan-container'><span style='font-size:12px;'>Berdasarkan Permohonan Informasi pada tanggal ".date::indonesianMonth($data['CAP_LAY_DATECREATED'])." dengan Nomor Pendaftaran ".$data['CAP_LAY_TRANSACTIONID']." , bersama ini disampaikan kepada Saudara/i :</span></div>";	
				$view .= "<div class='layan-permohonan-main-header-sixthtiary'>
			
					 		<table class='layan-permohonan-table'>
					 			<tr>
					 			
					 			<td class='layan-permohonan-td-header'>Nama</td>
					 			
					 			<td>:</td>
					 			
					 			<td>".ucwords(strtolower($data['CAP_LAY_NAMA']))."</td>
					 		
					 			</tr>";
			
								 		
					 			$view .=		"
							
							<tr>
					 			
					 			<td class='layan-permohonan-td-header'>Alamat</td>
					 			
					 			<td>:</td>
					 			
					 			<td>".ucwords(strtolower($data['CAP_LAY_ALAMAT']))."</td>
					 		
					 		</tr>
							
							<tr>
					 			
					 			<td class='layan-permohonan-td-header'>Telepon</td>
					 			
					 			<td>:</td>
					 			
					 			<td>".$data['CAP_LAY_TELEPON']."</td>
					 		
					 		</tr>
					 		
					 		<tr>
					 			
					 			<td class='layan-permohonan-td-header'>Email</td>
					 			
					 			<td>:</td>
					 			
					 			<td>".$data['CAP_LAY_EMAIL']."</td>
					 		
					 		</tr>
					 		
					 							 	   
					 	  
					 		
					 	
					 	</table>	
					 				
					 </div>";
					 $view .= "<br/>";
					 $view .= "<div class='layan-form-detail-perpanjangan-container'><span style='font-size:12px;'> Pemberitahuan sebagai berikut:</span></div>";
					 
						 $view .="<br/>";
						 $view .="<div class='layan-form-detail-perpanjangan-container'><span style='font-size:12px;'>A. Informasi dapat diberikan</span></div>";
						 $view .="<br/>";
						     $view .= " <table class='layan-permohonan-table-list twitters-style-table'>
		    		   
		    		  <thead>
		    		   
		              <tr>
		              
		              <td style='width: 20px; border-right: 1px solid #000; border-bottom: 1px solid #000; font-weight:bold;'>No</td>
		              
		              <td style='border-bottom: 1px solid #000; font-weight:bold;'>Hal-hal terkait Informasi Publik</td>
		              
		             
		              
		              <td style='border-bottom: 1px solid #000; text-align:center; font-weight:bold; width:350px;'>Keterangan</td></tr>
		              
		              </thead>
		              
		              <tbody>
		              
		              ";

				
							
		
						    $view .=  "<tr class='layan-document-tr-clickables' style='border-bottom: 1px solid #000;'>
							<td style='width: 20px; border-right: 1px solid #000; text-align:center;'>1</td>
						
							<td>Penguasaan Informasi</td>
								<td ><span><span class='layan-checkbox-print'></span>Tersedia di PPID</span><br/>
								<span><span class='layan-checkbox-print'></span>Badan Publik lain,</span><br/>
								<span><span class='layan-checkbox-print' style='visibility:hidden'></span>yaitu..............</span></td>
						   </tr>";	
						   
						    
		              $view .=  "<tr class='layan-document-tr-clickable' style='border-bottom: 1px solid #000;'>
							<td style='width: 20px; border-right: 1px solid #000; text-align:center;'>2</td>
						
							<td>Bentuk fisik yang tersedia</td>
								<td ><span><span class='layan-checkbox-print'></span>Softcopy</span><br/>
								<span><span class='layan-checkbox-print'></span>Hardcopy</span></td>
						   </tr>";	
						   
					 $view .=  "<tr class='layan-document-tr-clickable' style='border-bottom: 1px solid #000;'>
							<td style='width: 20px; border-right: 1px solid #000; text-align:center;'>3</td>
						
							<td>Biaya yang dibutuhkan</td>
								<td><span class='layan-checkbox-print'></span>Penyalinan Rp. ........ x ........ Lembar = <span style=' text-align:right; float:right;'>Rp. ........</span> </br>
								<span class='layan-checkbox-print'></span>Pengiriman <span style=' text-align:right; float:right;'>Rp. ........</span>
								</br>
								<span class='layan-checkbox-print'></span>Lain-lain <span style='text-align:right; float:right;'>Rp. ........</span></br>
								 <span style='text-align:right; float:right; border-top:1px solid black;'> Jumlah Total  Rp. ........
							</td>
						   </tr>";
						    $view .=  "<tr class='layan-document-tr-clickable' style='border-bottom: 1px solid #000;'>
							<td style='width: 20px; border-right: 1px solid #000; text-align:center;'>4</td>
						
							<td>Metode Penyampaian</td>
								<td style='text-align:center;'>							</td>
						   </tr>";	
						    $view .=  "<tr class='layan-document-tr-clickable' style='border-bottom: 1px solid #000;'>
							<td style='width: 20px; border-right: 1px solid #000; text-align:center;'>5</td>
						
							<td>Waktu Penyampaian</td>
								<td><span class='layan-checkbox-print'></span>........ hari</td>
						   </tr>";
						   
						   	
						   
	
		
		$view .= "<tr><td style='width: 20px; border-right: 1px solid #000; text-align:center;'>6</td><td colspan='2'>Penjelasan informasi yang dimohon (tambahan kertas bila perlu) :</br> Terlampir dibelakang</td></tr>";
		$view .= "</tbody>";			 
			
		$view .= "</table>";
					 
			
					
			$view .= "<br/>";
			$view .= "<div class='layan-form-detail-perpanjangan-container'><span style='font-size:12px;'>B. Informasi tidak dapat diberikan</span></div>";
			$view .= "<div class='layan-form-detail-perpanjangan-container'><span class='layan-checkbox-print' style='margin-left:0px; font-size:12px;' ></span><span style='font-size:12px;'>Informasi yang diminta belum dikuasai</span><br/></div>";
		
			
		$view .= "<div class='layan-form-detail-perpanjangan-container'><span class='layan-checkbox-print' style='margin-left:0px; font-size:12px;'></span><span style='font-size:12px;'>Informasi yang diminta belum didokumentasi</span><br/></div>"	;
		
		$view .= "<br/>";
				
		$view .="<div class='layan-form-detail-perpanjangan-container'>
		
		<div style='float:right;width:200px;text-align:left;font-size:12px;'>Jakarta, ".date::indonesianMonth($data['CAP_LAY_DATECREATED'])."</div>
		
		<br>
		
		<div style='float:right;width:200px;text-align:left; font-size:12px;'>Pejabat Pengelola Informasi dan Dokumentasi (PPID) Sekretariat Jenderal</div>
		
		</div>";
		
		$view .= "<br/>";
		
		$view .= "<br/>";
				
		$view .= "<br/>";
		
		$view .= "<br/>";
		
		$view .="<div class='layan-form-detail-perpanjangan-container'>
		
		<div style='float:right;width:200px;text-align:left; font-size:12px;'>".$this->getUserName()."</div>
				
		</div>";
		
		$view .= "<br/>";
		
		$view .="<div class='layan-form-detail-perpanjangan-container'>
				
		<div style='float:right;width:200px;text-align:left; line-height:0px;'>.........................................</div>
		
		</div>";
										
		$view .= "<br/><br/></div>";
		
		//Lampiran Pemberitahuan tertulis
		
				
			$view .= "<div style='page-break-before:always;'> <div class='layan-permohonan-container-inside'>
			<div class='layan-permohonan-main-header'>
					  <br/>
					  <span class='layan-permohonan-print-header-0'><img class='layan-permohonan-print-header-img' style='width:70px;height:70px;' src='".$data['CAP_LAY_BRA_LOGO']."'/></span>
					  <span class='layan-permohonan-print-header-1'>".$data['CAP_LAY_BRA_NAME']."</span><br/>
					  <span class='layan-permohonan-print-header-2'>".$data['CAP_LAY_BRA_TAGLINE1']."</span><br/>
					  <span class='layan-permohonan-print-header-2'>".$data['CAP_LAY_BRA_TAGLINE2']."</span><br/><br/>
			
					 </div>";
						
			$view .= "<div class='layan-permohonan-main-header-secondary'>
			
					  <span class='layan-permohonan-print-header-3'>".$data['CAP_LAY_BRA_ADDRESS']."</span><br/>
					  <span class='layan-permohonan-print-header-3'>Telp. ".$data['CAP_LAY_BRA_TELEPHONE'].", Fax. ".$data['CAP_LAY_BRA_FAX']."</span><br/>
					  <span class='layan-permohonan-print-header-3'>Website ".$data['CAP_LAY_BRA_WEBSITE']." Email: ".$data['CAP_LAY_BRA_EMAIL']."</span>
			
					 </div>";
							
		$view .= "<br/>";
				
			$view .= "<div class='layan-permohonan-main-header-tertiary'>
			
					  
					  <span class='layan-permohonan-print-fourtiary'>LAMPIRAN PEMBERITAHUAN TERTULIS</span><br/>
					  <span class='layan-permohonan-print-fifthiary'>Nomor: ".$data['CAP_LAY_PEM_NUMBER']."</span>
			
					 </div>";
					 
		

		
	
					 $view .= "<br/>";
					
					 
						 $view .="<br/>";
						 $view .="<div class='layan-form-detail-perpanjangan-container'><span style='font-size:12px;'>A. Informasi dapat diberikan</span></div>";
						 $view .="<br/>";
						     $view .= " <table class='layan-permohonan-table-list twitter-style-table'>
		    		   
		    		  <thead>
		    		   
		              <tr>
		              
		              <td style='width: 20px; border-right: 1px solid #000; border-bottom: 1px solid #000; font-weight:bold;'>No</td>
		              
		              <td style='border-bottom: 1px solid #000; font-weight:bold;'>Hal-hal terkait Informasi Publik</td>
		              
		             
		              
		              <td style='border-bottom: 1px solid #000; text-align:center; font-weight:bold; width:350px;'>Keterangan</td></tr>
		              
		              </thead>
		              
		              <tbody>
		              
		              ";
		              
		             						$data1 = $this->getDokumenPemberitahuanList($data['CAP_LAY_PEM_ID']);
		             						

		              
		$i = 1;           			 
		
		
		
		if (!empty($data1)) {
		
			foreach ($data1 as $key => $value ) {
			
				//print_r($value);
				if (!empty($value['CAP_LAY_DOC_REQ_ID'])) {
				$a = $value['CAP_LAY_PEM_DOC_COST'];
				
				$b = $value['CAP_LAY_PEM_DOC_LEMBAR'];
				$s = $a*$b;
				$c = $value['CAP_LAY_PEM_DOC_KIRIM'];
				$d = $value['CAP_LAY_PEM_DOC_LAIN_LAIN'];
				$e = ($a*$b)+$c+$d;
				$total = number_format($e);
				if ($value['CAP_LAY_PEM_DOC_KUASAI'] != 1 && $value['CAP_LAY_PEM_DOC_DOKUMENTASI'] != 1){			
				$view .=  "<tr class='layan-document-tr-clickable' style='border-bottom: 1px solid #000; page-break-inside:avoid;'>";
				
				
				
						$view .= "<td style='width: 20px; border-right: 1px solid #000; text-align:center;'>".$i++."</td>
							<td style='font-weight:bold;'><input type='hidden' value='".$value['CAP_LAY_DOC_REQ_ID']."'>".$value['CAP_LAY_DOC_REQ_DOCNAME']."</td>
							<td></td>
							
						   </tr>";
						    $view .=  "<tr class='layan-document-tr-clickable' style='border-bottom: 1px solid #000;'>
							<td style='width: 20px; border-right: 1px solid #000; text-align:center;'></td>
						
							<td>Penguasaan Informasi</td>
								<td>";
							if($value['CAP_LAY_PEM_DOC_PPID'] != ''){
							
							$view .="Tersedia di PPID";}
							if($value['CAP_LAY_PEM_DOC_LAIN'] != ''){
							$view .= "Badan Publik lain : ";
							$view .= $value['CAP_LAY_PEM_DOC_LAIN'];}
							$view .="</td>
						   </tr>";	
						   
						    
		              $view .=  "<tr class='layan-document-tr-clickable' style='border-bottom: 1px solid #000;'>
							<td style='width: 20px; border-right: 1px solid #000; text-align:center;'></td>
						
							<td>Bentuk fisik yang tersedia</td>
								<td>";
								if($value['CAP_LAY_PEM_DOC_SOFT'] != ''){
							$view .="Softcopy";}
							if($value['CAP_LAY_PEM_DOC_SOFT'] != '' && $value['CAP_LAY_PEM_DOC_HARD'] != ''){
								$view .=" & ";
							}

						if($value['CAP_LAY_PEM_DOC_HARD'] != ''){
							$view .= "Hardcopy";}
							$view .="</td>
						   </tr>";	
						   
					 $view .=  "<tr class='layan-document-tr-clickable' style='border-bottom: 1px solid #000;'>
							<td style='width: 20px; border-right: 1px solid #000; text-align:center;'></td>
						
							<td>Biaya yang dibutuhkan</td>
								<td>Penyalinan Rp. ".number_format($a)." x $b Lembar = <span style=' text-align:right; float:right;'>".number_format($s)."</span> </br>
								Pengiriman <span style=' text-align:right; float:right;'>".number_format($c)."</span>
								</br>
								Lain-lain <span style='text-align:right; float:right;'>".number_format($d)."</span></br>
								Jumlah Total <span style='text-align:right; float:right; border-top:1px solid black;'>Rp. $total</div>
								 ";
								
					$view .= "
							</td>
						   </tr>";
						    $view .=  "<tr class='layan-document-tr-clickable' style='border-bottom: 1px solid #000;'>
							<td style='width: 20px; border-right: 1px solid #000; text-align:center;'></td>
						
							<td>Metode Penyampaian</td>
								<td>";
					$view .= $value['CAP_LAY_PEM_DOC_METODE'];			
					$view .= "
							</td>
						   </tr>";	
						    $view .=  "<tr class='layan-document-tr-clickable' style='border-bottom: 1px solid #000;'>
							<td style='width: 20px; border-right: 1px solid #000; text-align:center;'></td>
						
							<td>Waktu Penyampaian</td>
								<td>";
					if ($value['CAP_LAY_PEM_DOC_WAKTU'] !=''){$view .= $value['CAP_LAY_PEM_DOC_WAKTU'];			
					$view .= " Hari";}
					$view .= "</td>";
				
						   $view .= "</tr>";		
						   
							   
						
						   }
						   

				
				}
							
			}   	
		
		}
		
		$view .= "</tbody>";			 
			
		$view .= "</table>";
					 
			
					
			$view .= "<br/>";
			$view .= "<div class='layan-form-detail-perpanjangan-container'><span style='font-size:12px;'>B. Informasi tidak dapat diberikan</span></div>";
			$view .= " <table class='layan-permohonan-table-list twitter-style-table'>
		    		   
		    		  <thead>
		    		   
		              <tr>
		              
		              <td style='width: 20px; border-right: 1px solid #000; border-bottom: 1px solid #000; font-weight:bold;'>No</td>
		              
		              <td style='border-bottom: 1px solid #000; font-weight:bold;'>Nama Informasi Publik</td>
		              
		             
		              
		              <td style='border-bottom: 1px solid #000; text-align:center; font-weight:bold; width:350px;'>Keterangan</td></tr>
		              
		              </thead>
		              
		              <tbody>
		              
		              ";
		              $data2 = $this->getDokumenPemberitahuanList($data['CAP_LAY_PEM_ID']);
		              $i = 1;
					 
		if (!empty($data2)) {
			
			foreach ($data2 as $key => $value ) {	
			//print_r($value);
			if ($value['CAP_LAY_PEM_DOC_KUASAI'] !='' or $value['CAP_LAY_PEM_DOC_DOKUMENTASI'] !=''){
			$view .=  "<tr class='layan-document-tr-clickables' >
							<td style='width: 20px; border-right: 1px solid #000; text-align:center;'>".$i++."</td>
							<td><input type='hidden' value='".$value['CAP_LAY_DOC_REQ_ID']."'>".$value['CAP_LAY_DOC_REQ_DOCNAME']."</td>
							<td >";
							if ($value['CAP_LAY_PEM_DOC_KUASAI'] != ''){
							$view .= "Informasi yang diminta belum dikuasai";}
								
							
							if ($value['CAP_LAY_PEM_DOC_KUASAI'] != '' && $value['CAP_LAY_PEM_DOC_DOKUMENTASI'] != ''){
			$view .= "</br>";}
			 
							if ($value['CAP_LAY_PEM_DOC_DOKUMENTASI'] != ''){
								$view .= "Informasi yang diminta belum didokumentasi";
							}
						$view .=  "</td></tr>";	
						}	 
		
	}
	}
	
		$view .= "</tbody></table>"	;
		
		$view .= "<br/><br/>";		
		
		$view .= "</div>";
		$view .= "</div>";	
		$view .= "</div>";
		$view .= "</div>";
		}
	}
	echo $view;

	
	}

	public function printPenolakan() {
	
	$arrayData  = $this->getPenolakanLengkapPrint();

	//print_r($arrayData);
foreach ($arrayData[0]['pemberitahuan'] as $key => $data ) {	
		$view .= "<div>";
		$view .= "<div class='layan-permohonan-print'><div class='layan-permohonan-back-button'></div><div class='layan-permohonan-print-button'></div></div>";
		
		$view .= "<div class='layan-permohonan-container'>";
				
			$view .= "<div class='layan-permohonan-main-header'>
					  <br/>
					  <span class='layan-permohonan-print-header-0'><img class='layan-permohonan-print-header-img' style='width:70px;height:70px;' src='".$data['CAP_LAY_BRA_LOGO']."'/></span>
					  <span class='layan-permohonan-print-header-1'>".$data['CAP_LAY_BRA_NAME']."</span><br/>
					  <span class='layan-permohonan-print-header-2'>".$data['CAP_LAY_BRA_TAGLINE1']."</span><br/>
					  <span class='layan-permohonan-print-header-2'>".$data['CAP_LAY_BRA_TAGLINE2']."</span><br/><br/>
			
					 </div>";
						
			$view .= "<div class='layan-permohonan-main-header-secondary'>
			
					  <span class='layan-permohonan-print-header-3'>".$data['CAP_LAY_BRA_ADDRESS']."</span><br/>
					  <span class='layan-permohonan-print-header-3'>Telp. ".$data['CAP_LAY_BRA_TELEPHONE'].", Fax. ".$data['CAP_LAY_BRA_FAX']."</span><br/>
					  <span class='layan-permohonan-print-header-3'>Website ".$data['CAP_LAY_BRA_WEBSITE']." Email: ".$data['CAP_LAY_BRA_EMAIL']."</span>
			
					 </div>";
							
		$view .= "<br/>";
				
			$view .= "<div class='layan-permohonan-main-header-tertiary'>
			
					  
					  <span class='layan-permohonan-print-fourtiary'>PERNYATAAN PENOLAKAN ATAS PERMOHONAN INFORMASI PUBLIK</span><br/>
					  <span class='layan-permohonan-print-fifthiary'>No. Pendaftaran: ".$data['CAP_LAY_PEN_NUMBER']."</span>
			
					 </div>";
					 
		$view .= "<br/>";
			
			$view .= "<div class='layan-form-detail-perpanjangan-container'>";
		
		$view .="<span class='layan-form-detail-perpanjangan'>Berdasarkan Permohonan Informasi pada tanggal ".date::indonesianMonth($data['CAP_LAY_DATECREATED'])." dengan Nomor Pendaftaran ".$data['CAP_LAY_TRANSACTIONID'].", bersama ini disampaikan kepada Saudara/i :</span>";
		
		$view .="</div>";
		
		$view .= "<br/>";
			
			$view .= "<div class='layan-permohonan-main-header-sixthtiary'>
			
					 	<table class='layan-permohonan-table'>
					 		
					 		<tr>
					 			
					 			<td class='layan-permohonan-td-header'>Nama</td>
					 			
					 			<td>:</td>
					 			
					 			<td>".ucwords(strtolower($data['CAP_LAY_NAMA']))."</td>
					 		
					 		</tr>";
			
			if (!empty($data['CAP_LAY_NAMA_BADAN'])) {
					 		
			$view .=		"<tr>
					 			
					 			<td class='layan-permohonan-td-header'>Nama Badan</td>
					 			
					 			<td>:</td>
					 			
					 			<td>".ucwords(strtolower($data['CAP_LAY_NAMA_BADAN']))."</td>
					 		
					 		</tr>";
			
			}
					 		
			$view .=		"
							
							<tr>
					 			
					 			<td class='layan-permohonan-td-header'>Alamat</td>
					 			
					 			<td>:</td>
					 			
					 			<td>".ucwords(strtolower($data['CAP_LAY_ALAMAT']))."</td>
					 		
					 		</tr>
							
							<tr>
					 			
					 			<td class='layan-permohonan-td-header'>Telepon</td>
					 			
					 			<td>:</td>
					 			
					 			<td>".$data['CAP_LAY_TELEPON']."</td>
					 		
					 		</tr>
					 		
					 		<tr>
					 			
					 			<td class='layan-permohonan-td-header'>Email</td>
					 			
					 			<td>:</td>
					 			
					 			<td>".$data['CAP_LAY_EMAIL']."</td>
					 		
					 		</tr>
					 		
					 	   
					 	   <tr>
					 		
					 			<td class='layan-permohonan-td-header'>Informasi yang dibutuhkan</td>
					 			
					 			<td>:</td>
					 			
					 			
					 		
					 		</tr>
					 		
					 	
					 	</table>	
					 				
					 </div>";
					 
			$view .= "<br/>";
					 
		    $view .= " <table class='layan-permohonan-table-list twitter-style-table'>
		    		   
		    		  <thead>
		    		   
		              <tr>
		              
		              <td style='width: 20px; border-right: 1px solid #000; border-bottom: 1px solid #000; font-weight:bold;'>No</td>
		              
		              <td style='border-bottom: 1px solid #000; font-weight:bold;'>Nama Informasi Publik</td>
		              
		             </tr>
		              
		              </thead>
		              
		              <tbody>
		              
		              ";
		              
		$i = 1;           			 
		
		$datas = $this->getDokumenPenolakanList($data['CAP_LAY_PEN_ID']);
		
		if (!empty($datas)) {
		
			foreach ($datas as $key => $value ) {
				
				if (!empty($value['CAP_LAY_DOC_REQ_ID'])) {
				
				$view .=  "<tr class='layan-document-tr-clickable' style='border-bottom: 1px solid #000;'>
							<td style='width: 20px; border-right: 1px solid #000; text-align:center;'>".$i++."</td>
							<td><input type='hidden' value='".$value['CAP_LAY_DOC_REQ_ID']."'>".$value['CAP_LAY_DOC_REQ_DOCNAME']."</td>
							
						   </tr>";
				
				}
							
			}   	
		
		}
		
		$view .= "</tbody>";			 
			
		$view .= "</table></br>";
		$view .= "<div class='layan-form-detail-perpanjangan-container'>";
		
		$view .="<span class='layan-form-detail-perpanjangan'>PPID memutuskan bahwa informasi yang dimohon adalah</span></br>";
		$view .="<div style='margin:0 auto; border:1px solid #000; width:300px; padding:5px; text-align:center; margin-top:10px; font-size:12px;'>INFORMASI DIKECUALIKAN</div>";
	
		$view .= "</div>";
		
		
		
		//$view .= "</div>";
		
		$view .= "<br/>";
		$view .= " <table class='layan-permohonan-table-list twitters-style-table'>";
		 $view .= " <thead>
		    		   
		              <tr>
		              
		              <td style='width: 20px; border-right: 1px solid #000; border-bottom: 1px solid #000; font-weight:bold;'>No</td>
		              
		              <td style='border-bottom: 1px solid #000; font-weight:bold;'>Pengecualian Informasi Berdasarkan pada alasan</td>
		              
		             </tr>
		              
		              </thead>
		              
		              <tbody>";   		   
		$i = 1;           			 
		
		$dataa = $this->getDokumenPenolakanList($data['CAP_LAY_PEN_ID']);
		//print_r($dataa);
		if (!empty($dataa)) {
		
			foreach ($dataa as $key => $value ) {
				
				if (!empty($value['CAP_LAY_DOC_REQ_ID'])) {
				
				$theStrongReason = '';
		
		//$view .= "<div class='layan-form-detail-perpanjangan-container'>";
		
			//$view .= "Pengecualian Informasi Berdasarkan Pada Alasan";
			
			if (!empty($value['CAP_LAY_PEN_DOC_UU'])) {
								
								$theText = explode("|",$value['CAP_LAY_PEN_DOC_UU']);
								
								$pasal = str_replace("PASAL","",strtoupper($theText[0]));
								
								$undang = str_replace("UNDANG-UNDANG","",strtoupper($theText[1]));
								
							}
			
				if ($value['CAP_LAY_PEN_DOC_PSL'] == 1) {
				$theStrongReason .= "Pasal 17 UU KIP,";
				//$view .= "<li><input type='checkbox' checked='checked'> Pasal 17 UU KIP</li>";
				}
				else {
				//$view .= "<li><input type='checkbox'> Pasal 17 UU KIP</li>";
				}
				
				if (!empty($value['CAP_LAY_PEN_DOC_UU'])) {
				$theStrongReason .= "Pasal ".$pasal." Undang-Undang $undang,";
				//$view .= "<li><input type='checkbox' checked='checked'> Pasal ".$pasal." Undang-Undang $undang</li>";
				}
				else {
				//$view .= "<li><input type='checkbox'> Pasal ............... Undang-Undang ...............</li>";
				}
				
				if (!empty($value['CAP_LAY_PEN_DOC_UJI'])) {
				$theStrongReason .= "Uji Konsekuensi Kementerian Pertanian No. ".$value['CAP_LAY_PEN_DOC_UJI'].",";
				//$view .= "<li><input type='checkbox' checked='checked'> Uji Konsekuensi Kementerian Pertanian No. ".$value['CAP_LAY_PEN_DOC_UJI']."</li>";
				}
				else {
				//$view .= "<li><input type='checkbox'> Uji Konsekuensi Kementerian Pertanian No. </li>";
				}
				
					if (!empty($value['CAP_LAY_PEN_DOC_NOTES'])) {
						$unixian .= strtolower($value['CAP_LAY_PEN_DOC_NOTES']).", ";
					}
					else {
						$unixian .= "";
					}
				
				$theStrongReason = substr($theStrongReason, 0, -1);
				
				$view .=  "<tr class='layan-document-tr-clickables' >
							<td style='width: 20px; border-right: 1px solid #000; text-align:center;'>".$i++."</td>
							<td><input type='hidden' value='".$value['CAP_LAY_DOC_REQ_ID']."'>Alasan Untuk Informasi Publik \"".$value['CAP_LAY_DOC_REQ_DOCNAME']."\" yaitu : $theStrongReason</td>
						
						   </tr>";
				
				}
							
			}   	
		
		}
		
		$view .= "</tbody>";			 
			
		$view .= "</table>";	
		
		$view .= "<br/>";
		
		$view .= "<div class='layan-form-detail-perpanjangan-container'>";
		
		$unixian = substr($unixian, 0, -2);
		
		$view .="<span class='layan-form-detail-perpanjangan'>Bahwa berdasarkan pasal-pasal di atas, membuka informasi tersebut dapat menimbulkan konsekuensi 
sebagai berikut: ".$unixian."</span></br>";
		
		$view .="<span class='layan-form-detail-perpanjangan'>Dengan demikian dinyatakan bahwa : </span></br>";
		
		$view .="<div style='margin:0 auto; border:1px solid #000; width:300px; padding:5px; text-align:center; margin-top:10px; font-size:12px;'>PERMOHONAN INFORMASI DITOLAK</div>";

		$view .= "</div";
		

		$view .= "<br/>";
		
		$view .= "<br/>";
		
		$view .="<div class='layan-form-detail-perpanjangan-container'>
		
		<div style='float:right;width:200px;text-align:left; font-size: 12px;'>Jakarta, ".date::indonesianMonth($data['CAP_LAY_PEN_DATECREATED'])."</div>
		
		<br>
		
		<div style='float:right;width:200px;text-align:left; font-size: 12px;'>Pejabat Pengelola Informasi dan Dokumentasi (PPID) Sekretariat Jenderal</div>
		
		</div>";
		
		$view .= "<br/>";
		
		$view .= "<br/>";
		
		$view .= "<br/>";
						
		$view .= "<br/>";
		
		$view .= "<br/>";
		
		$view .="<div class='layan-form-detail-perpanjangan-container'>
		
		<div style='float:right;width:200px;text-align:left; font-size: 12px;'>".$this->getUserName()."</div>
				
		</div>";
		
		$view .= "<br/>";
		
		$view .="<div class='layan-form-detail-perpanjangan-container'>
				
		<div style='float:right;width:200px;text-align:left; line-height:0px;'>.........................................</div>
		
		</div>";
						
		$view .= "<br/>";
		
		$view .= "<br/>";
		
		$view .= "<br/>";
					
		$view .= "</div>";

		$view .= "</div>";
		}
	echo $view;

	
	}

	public function printPerpanjangan() {
	
	$arrayData  = $this->getPerpanjanganLengkapPrint();

	//print_r($arrayData);
	foreach ($arrayData as $key => $value) {
		
foreach ($value['pemberitahuan'] as $key => $data ) {
		$view .= "<div>";

		$view .= "<div class='layan-permohonan-print'><div class='layan-permohonan-back-button'></div><div class='layan-permohonan-print-button'></div></div>";
		
		$view .= "<div class='layan-permohonan-container'>";
				
			$view .= "<div class='layan-permohonan-main-header'>
					  <br/>
					  <span class='layan-permohonan-print-header-0'><img class='layan-permohonan-print-header-img' style='width:70px;height:70px;' src='".$data['CAP_LAY_BRA_LOGO']."'/></span>
					  <span class='layan-permohonan-print-header-1'>".$data['CAP_LAY_BRA_NAME']."</span><br/>
					  <span class='layan-permohonan-print-header-2'>".$data['CAP_LAY_BRA_TAGLINE1']."</span><br/>
					  <span class='layan-permohonan-print-header-2'>".$data['CAP_LAY_BRA_TAGLINE2']."</span><br/><br/>
			
					 </div>";
						
			$view .= "<div class='layan-permohonan-main-header-secondary'>
			
					  <span class='layan-permohonan-print-header-3'>".$data['CAP_LAY_BRA_ADDRESS']."</span><br/>
					  <span class='layan-permohonan-print-header-3'>Telp. ".$data['CAP_LAY_BRA_TELEPHONE'].", Fax. ".$data['CAP_LAY_BRA_FAX']."</span><br/>
					  <span class='layan-permohonan-print-header-3'>Website ".$data['CAP_LAY_BRA_WEBSITE']." Email: ".$data['CAP_LAY_BRA_EMAIL']."</span>
			
					 </div>";
							
		$view .= "<br/>";
				
			$view .= "<div class='layan-permohonan-main-header-tertiary'>
			
					  <span class='layan-permohonan-print-fourtiary'>FORMULIR PERPANJANGAN WAKTU PENYAMPAIAN INFORMASI PUBLIK</span><br/>
					  <span class='layan-permohonan-print-fifthiary'>No. Pendaftaran: ".$data['CAP_LAY_PER_NUMBER']."</span>
			
					 </div>";
					 
		$view .= "<br/>";
		
		$view .= "<div class='layan-form-detail-perpanjangan-container'>";
		
		$view .="<span class='layan-form-detail-perpanjangan'>Berdasarkan Permohonan Informasi pada tanggal ".date::indonesianMonth($data['CAP_LAY_DATECREATED'])." dengan Nomor Pendaftaran ".$data['CAP_LAY_TRANSACTIONID'].", bersama ini disampaikan kepada Saudara/i :</span>";
		
		$view .="</div>";
		
		$view .= "<br/>";
			
			$view .= "<div class='layan-permohonan-main-header-sixthtiary'>
			
					 	<table class='layan-permohonan-table'>
					 		
					 		<tr>
					 			
					 			<td class='layan-permohonan-td-header'>Nama</td>
					 			
					 			<td>:</td>
					 			
					 			<td>".ucwords(strtolower($data['CAP_LAY_NAMA']))."</td>
					 		
					 		</tr>";
			
			if (!empty($data['CAP_LAY_NAMA_BADAN'])) {
					 		
			$view .=		"<tr>
					 			
					 			<td class='layan-permohonan-td-header'>Nama Badan</td>
					 			
					 			<td>:</td>
					 			
					 			<td>".ucwords(strtolower($data['CAP_LAY_NAMA_BADAN']))."</td>
					 		
					 		</tr>";
			
			}
					 		
			$view .=		"
							
							<tr>
					 			
					 			<td class='layan-permohonan-td-header'>Alamat</td>
					 			
					 			<td>:</td>
					 			
					 			<td>".ucwords(strtolower($data['CAP_LAY_ALAMAT']))."</td>
					 		
					 		</tr>
							
							<tr>
					 			
					 			<td class='layan-permohonan-td-header'>Telepon</td>
					 			
					 			<td>:</td>
					 			
					 			<td>".$data['CAP_LAY_TELEPON']."</td>
					 		
					 		</tr>
					 		
					 		<tr>
					 			
					 			<td class='layan-permohonan-td-header'>Email</td>
					 			
					 			<td>:</td>
					 			
					 			<td>".$data['CAP_LAY_EMAIL']."</td>
					 		
					 		</tr>
					 		
					 	   
					 	   <tr>
					 		
					 			<td class='layan-permohonan-td-header'>Informasi yang dibutuhkan</td>
					 			
					 			<td>:</td>
					 			
					 			
					 		
					 		</tr>
					 		
					 	
					 	</table>	
					 				
					 </div>";
					 
			$view .= "<br/>";
					 
		    $view .= " <table class='layan-permohonan-table-list twitters-style-table'>
		    		   
		    		  <thead>
		    		   
		              <tr>
		              
		              <td style='width: 20px; border-right: 1px solid #000; border-bottom: 1px solid #000; font-weight:bold;'>No</td>
		              
		              <td style='border-bottom: 1px solid #000; font-weight:bold;'>Nama Informasi Publik</td>
		              
		              <td style='border-bottom: 1px solid #000; text-align:center; font-weight:bold;'></td>
		              
		              <td style='border-bottom: 1px solid #000; text-align:center; font-weight:bold;'></td></tr>
		              
		              </thead>
		              
		              <tbody>
		              
		              ";
		              
		$i = 1;           			 
		
		$datas = $this->getDokumenPerpanjanganList($data['CAP_LAY_PER_ID']);

		if (!empty($datas)) {
		
			foreach ($datas as $key => $value ) {
				
				if (!empty($value['CAP_LAY_DOC_REQ_ID'])) {
				
				$view .=  "<tr class='layan-document-tr-clickables' style='border-bottom: 1px solid #000;'>
							<td style='width: 20px; border-right: 1px solid #000; text-align:center;'>".$i++."</td>
							<td><input type='hidden' value='".$value['CAP_LAY_DOC_REQ_ID']."'>".$value['CAP_LAY_DOC_REQ_DOCNAME']."</td>
							<td style='text-align:center;'></td>
							<td style='text-align:center;'></td>
						   </tr>";
				
				}
							
			}   	
		
		}
		
		$view .= "</tbody>";			 
			
		$view .= "</table>";
		
		$view .= "<br/>";
		
		$view .= "<div class='layan-form-detail-perpanjangan-container'>";
		
		$view .="<span class='layan-form-detail-perpanjangan'>Dengan ini disampaikan bahwa waktu penyampaian informasi publik sebagaimana yang dimohonkan diperpanjang, waktu penyampaian hingga ".date::indonesianMonth($data['CAP_LAY_PER_DATE_TO'])." dengan alasan sebagai berikut :</span>";
	
		$view .= "</div>";
		
		$view .= "<br/>";
		
		$view .= " <table class='layan-permohonan-table-list twitters-style-table'>";
		    		   
		$i = 1;           			 
		
		$datasi = $this->getDokumenPerpanjanganList($data['CAP_LAY_PER_ID']);
		
		if (!empty($datasi)) {
		
			foreach ($datasi as $key => $value ) {
				
				if (!empty($value['CAP_LAY_DOC_REQ_ID'])) {
				
				$view .=  "<tr class='layan-document-tr-clickables' >
							<td style='width: 20px; border-right: 1px solid #000; text-align:center;'>".$i++."</td>
							<td><input type='hidden' value='".$value['CAP_LAY_DOC_REQ_ID']."'>Alasan Untuk Informasi Publik \"".$value['CAP_LAY_DOC_REQ_DOCNAME']."\" diperpanjang yaitu : \"".strtolower($value['CAP_LAY_PER_DOC_NOTES']). "\"</td>
							<td style='text-align:center;'></td>
							<td style='text-align:center;'></td>
						   </tr>";
				
				}
							
			}   	
		
		}
		
		$view .= "</tbody>";			 
			
		$view .= "</table>";		
				
		$view .= "<br/>";
		
		$view .= "<br/>";
		
		$view .="<div class='layan-form-detail-perpanjangan-container'>
		
		<div style='float:right;width:200px;text-align:left; font-size:12px;'>Jakarta, ".date::indonesianMonth($data['CAP_LAY_PER_DATECREATED'])."</div>
		
		<br>
		
		<div style='float:right;width:200px;text-align:left;font-size:12px;'>Pejabat Pengelola Informasi dan Dokumentasi (PPID) Sekretariat Jenderal</div>
		
		</div>";
		
		$view .= "<br/>";
		
		$view .= "<br/>";
		
		$view .= "<br/>";
		
		$view .= "<br/>";
		
		$view .= "<br/>";
		$view .= "<br/>";
		
		$view .="<div class='layan-form-detail-perpanjangan-container'>
		
		<div style='float:right;width:200px;text-align:left; font-size:12px;'>".$this->getUserName()."</div>
				
		</div>";
		
		$view .= "<br/>";
		
		$view .="<div class='layan-form-detail-perpanjangan-container'>
				
		<div style='float:right;width:200px;text-align:left; line-height:0px;'>.........................................</div>
		
		</div>";
						
		$view .= "<br/>";
		
		$view .= "<br/>";
		
		$view .= "<br/>";
		
		$view .= "</div>";
		
		}
	}
	echo $view;

	
	}
	
	
	public function printKeberatan() {
	
	$arrayData  = $this->getKeberatanLengkapPrint();
	
	//$document = $this->getKeberatanDokumen($arrayData[0]['keberatan'][0]['CAP_LAY_KEB_ID']);

	foreach ($arrayData as $key => $value) {
		
		foreach ($value['keberatan'] as $key => $data ) {
		$view .= "<div>";

		$view .= "<div class='layan-permohonan-print'><div class='layan-permohonan-back-button'></div><div class='layan-permohonan-print-button'></div></div>";
		
		$view .= "<div class='layan-permohonan-container'>";
				
		$view .= "<div class='layan-permohonan-main-header'>
					  <br/>
					  <span class='layan-permohonan-print-header-0'><img class='layan-permohonan-print-header-img' style='width:70px;height:70px;' src='".$data['CAP_LAY_BRA_LOGO']."'/></span>
					  <span class='layan-permohonan-print-header-1'>".$data['CAP_LAY_BRA_NAME']."</span><br/>
					  <span class='layan-permohonan-print-header-2'>".$data['CAP_LAY_BRA_TAGLINE1']."</span><br/>
					  <span class='layan-permohonan-print-header-2'>".$data['CAP_LAY_BRA_TAGLINE2']."</span><br/><br/>
			
					 </div>";
						
			$view .= "<div class='layan-permohonan-main-header-secondary'>
			
					  <span class='layan-permohonan-print-header-3'>".$data['CAP_LAY_BRA_ADDRESS']."</span><br/>
					  <span class='layan-permohonan-print-header-3'>Telp. ".$data['CAP_LAY_BRA_TELEPHONE'].", Fax. ".$data['CAP_LAY_BRA_FAX']."</span><br/>
					  <span class='layan-permohonan-print-header-3'>Website ".$data['CAP_LAY_BRA_WEBSITE']." Email: ".$data['CAP_LAY_BRA_EMAIL']."</span>
			
					 </div>";
							
		$view .= "<br/>";
				
			$view .= "<div class='layan-permohonan-main-header-tertiary'>
			
					  <span class='layan-permohonan-print-fourtiary'>PERNYATAAN KEBERATAN ATAS PERMOHONAN INFORMASI PUBLIK</span><br/>
			
					 </div>";
					 
		$view .= "<br/>";
		
		$view .= "<div class='layan-form-detail-perpanjangan-container'>";
				
		$view .="</div>";
		
		$view .= "<br/>";
			
			$view .= "<div class='layan-permohonan-main-header-sixthtiary'>
			
					 	<table class='layan-permohonan-table'>
					 		
					 		<tr>
					 			
					 			<td class='layan-permohonan-td-header' colspan='4'>A. INFORMASI PENGAJUAN KEBERATAN</td>
					 								 		
					 		</tr>
					 		
					 		<tr>
					 			<td>&nbsp; </td>
					 			<td class='layan-permohonan-td-header' style='vertical-align:text-top;'>Nomor registrasi keberatan</td>
					 			
					 			<td style='vertical-align:text-top;'>:</td>
					 			
					 			<td style='vertical-align:text-top;'>".$data['CAP_LAY_KEB_NUMBER']."</td>
					 		
					 		</tr>
					 		
					 		<tr>
					 			<td>&nbsp; </td>
					 			<td class='layan-permohonan-td-header' style='vertical-align:text-top;'>Nomor dan tanggal pendaftaran Pemohon Informasi</td>
					 			
					 			<td style='vertical-align:text-top;'>:</td>
					 			
					 			<td style='vertical-align:text-top;'>".$data['CAP_LAY_TRANSACTIONID']." / ".date::indonesianMonth($data['CAP_LAY_DATECREATED'])."</td>
					 		
					 		</tr>";
					 		
			$view .= 		"
							
							<tr>
					 			<td>&nbsp; </td>
					 		
					 		</tr>
							
							<tr>
					 			<td>&nbsp; </td>
					 			<td class='layan-permohonan-td-header' colspan='4'>Identitas Pemohon</td>
					 		
					 		</tr>
							
							<tr>
					 			<td>&nbsp; </td>
					 			<td class='layan-permohonan-td-header'>Nama</td>
					 			
					 			<td>:</td>
					 			
					 			<td>".ucwords(strtolower($data['CAP_LAY_NAMA']))."</td>
					 		
					 		</tr>";
			
			if (!empty($data['CAP_LAY_NAMA_BADAN'])) {
					 		
			$view .=		"<tr>
					 			<td>&nbsp; </td>
					 			<td class='layan-permohonan-td-header'>Nama Badan</td>
					 			
					 			<td>:</td>
					 			
					 			<td>".ucwords(strtolower($data['CAP_LAY_NAMA_BADAN']))."</td>
					 		
					 		</tr>";
			
			}
					 		
			$view .=		"
							
							<tr>
					 			<td>&nbsp; </td>
					 			<td class='layan-permohonan-td-header'>Alamat</td>
					 			
					 			<td>:</td>
					 			
					 			<td>".ucwords(strtolower($data['CAP_LAY_ALAMAT']))."</td>
					 		
					 		</tr>
					 		
					 		<tr>
					 			<td>&nbsp; </td>
					 			<td class='layan-permohonan-td-header'>Pekerjaan</td>
					 			
					 			<td>:</td>
					 			
					 			<td>".ucwords(strtolower($data['CAP_LAY_PEKERJAAN']))."</td>
					 		
					 		</tr>
					 		
					 		<tr>
					 			<td>&nbsp; </td>
					 			<td class='layan-permohonan-td-header'>NPWP</td>
					 			
					 			<td>:</td>
					 			
					 			<td>".ucwords(strtolower($data['CAP_LAY_NPWP']))."</td>
					 		
					 		</tr>
							
							<tr>
					 			<td>&nbsp; </td>
					 			<td class='layan-permohonan-td-header'>Telepon</td>
					 			
					 			<td>:</td>
					 			
					 			<td>".$data['CAP_LAY_TELEPON']."</td>
					 		
					 		</tr>
					 		
					 		<tr>
					 			<td>&nbsp; </td>
					 			<td class='layan-permohonan-td-header'>Email</td>
					 			
					 			<td>:</td>
					 			
					 			<td>".$data['CAP_LAY_EMAIL']."</td>
					 		
					 		</tr>					 	  
							
							<tr>
					 			<td>&nbsp; </td>
					 			<td class='layan-permohonan-td-header' colspan='4'>Identitas Kuasa Pemohon</td>
					 		
					 		</tr>
							
							<tr>
					 			<td>&nbsp; </td>
					 			<td class='layan-permohonan-td-header'>Nama</td>
					 			
					 			<td>:</td>
					 			
					 			<td>".ucwords(strtolower($data['CAP_LAY_KEB_NAME']))."</td>
					 		
					 		</tr>
					 		
					 		<tr>
					 			<td>&nbsp; </td>
					 			<td class='layan-permohonan-td-header'>Alamat</td>
					 			
					 			<td>:</td>
					 			
					 			<td>".ucwords(strtolower($data['CAP_LAY_KEB_ALAMAT']))."</td>
					 		
					 		</tr>
					 		
					 	
					 	</table>	
					 				
					 </div>";
					 
			$view .= "<br/>";
			
			$view .= "
			
						<table class='layan-permohonan-table'>
						
						 <tr>
					 			
					 			<td class='layan-permohonan-td-header' colspan='4'>B. ALASAN PENGAJUAN KEBERATAN</td>
					 								 		
					 		</tr>
					 		
					 	</table>
			
			";
			
		    $view .= " <table class='layan-permohonan-table-list twitters-style-table'>
		    		   
		    		  <thead>
		    		  		    		   
		              <tr>
		              
		              <td style='width: 20px; border-right: 1px solid #000; border-bottom: 1px solid #000; font-weight:bold;'>No</td>
		              
		              <td style='border-bottom: 1px solid #000; font-weight:bold;'>Nama Dokumen</td>
		              
		              <td style='border-bottom: 1px solid #000; text-align:center; font-weight:bold;'>Alasan</td>
		              
		              <td style='border-bottom: 1px solid #000; border-right: 1px solid #000; text-align:center; font-weight:bold;'></td>
		              		              
		              </tr>
		              
		              </thead>
		              
		              <tbody>
		              
		              ";
		              
		$i = 1;           			 
		
		unset($document);
		
		$document = $this->getKeberatanDokumen($data['CAP_LAY_KEB_ID']);

		if (!empty($document)) {
		
			foreach ($document as $key2 => $value2) {
								
				if (!empty($value2['CAP_LAY_ID'])) {
				
				$number = "Permohonan No. ".$value2['CAP_LAY_TRANSACTIONID'];
				
				$view .=  "<tr class='layan-document-tr-clickables' style='border-bottom: 1px solid #000;'>
							<td style='width: 20px; border-right: 1px solid #000; text-align:center;'>".$i++."</td>
							<td>".$number."</td>
							<td style='text-align:left;'>".$value2['CAP_LAY_KEB_DOC_NOTES']."</td>
							<td style='text-align:center;'></td>
						   </tr>";
													
				}
				else if (!empty($value2['CAP_LAY_PEM_ID'])) {
					
				$number = "Pemberitahuan No. ".$value2['CAP_LAY_PEM_NUMBER'];
				
				$view .=  "<tr class='layan-document-tr-clickables' style='border-bottom: 1px solid #000;'>
							<td style='width: 20px; border-right: 1px solid #000; text-align:center;'>".$i++."</td>
							<td>".$number."</td>
							<td style='text-align:left;'>".$value2['CAP_LAY_KEB_DOC_NOTES']."</td>
							<td style='text-align:center;'></td>
						   </tr>";
														
				}
				else if (!empty($value2['CAP_LAY_PEN_ID'])) {
					
				$number = "Penolakan No. ".$value2['CAP_LAY_PEN_NUMBER'];
				
				$view .=  "<tr class='layan-document-tr-clickables' style='border-bottom: 1px solid #000;'>
							<td style='width: 20px; border-right: 1px solid #000; text-align:center;'>".$i++."</td>
							<td>".$number."</td>
							<td style='text-align:left;'>".$value2['CAP_LAY_KEB_DOC_NOTES']."</td>
							<td style='text-align:center;'></td>
						   </tr>";
														
				}
				else if (!empty($value2['CAP_LAY_PER_ID'])) {
					
				$number = "Perpanjangan No. ".$value2['CAP_LAY_PER_NUMBER'];
				
				$view .=  "<tr class='layan-document-tr-clickables' style='border-bottom: 1px solid #000;'>
							<td style='width: 20px; border-right: 1px solid #000; text-align:center;'>".$i++."</td>
							<td>".$number."</td>
							<td style='text-align:left;'>".$value2['CAP_LAY_KEB_DOC_NOTES']."</td>
							<td style='text-align:center;'></td>
						   </tr>";
														
				}
								
						   											
			}   	
		
		}
		
		$view .= "</tbody>";			 
			
		$view .= "</table>";
		
		$view .= "<br/>";
		
		$view .= "<div class='layan-form-detail-perpanjangan-container'>";
		
		$view .= "
			
						<table class='layan-permohonan-table'>
						
						 <tr>
					 			
					 			<td class='layan-permohonan-td-header' colspan='4'>C. HARI/TANGGAL TANGGAPAN ATAS KEBERATAN</td>
					 								 		
					 		</tr>
					 		
					 	</table>
			
			";
		
			if (!empty($data['CAP_LAY_KEB_DATE_TO'])) {
				$theDateTo = date::indonesianMonth($data['CAP_LAY_KEB_DATE_TO']);
			}
			else {
				$theDateTo = '..............................';
			}
		
		$view .="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='layan-form-detail-perpanjangan'>Akan diberikan pada:  ".$theDateTo." (tanggal/bulan/tahun)</span>";
	
		$view .= "</div>";
		
		$view .= "<br/>";	
		
		$view .="<div class='layan-form-detail-perpanjangan-container' style='font-size:12px;'>Demikian keberatan ini saya sampaikan, atas perhatiannya diucapkan terima kasih.</div>";
		
		$view .= "<br/>";
		
		$view .= "<br/>";
		
		$view .="<div class='layan-form-detail-perpanjangan-container'>
		
		<div style='float:left;width:250px;text-align:center;font-size:12px;'>Petugas Pelayanan Informasi</div>
		
		<div style='float:right;width:250px;text-align:center;font-size:12px;'>Pengaju Keberatan</div>
		
		</div>";
		
		$view .= "<br/>";
		
		$view .= "<br/>";
		$view .= "<br/>";
		$view .= "<br/>";
			if (!empty($data['CAP_LAY_KEB_NAME'])) {
				$namaPengaju = ucwords(strtolower($data['CAP_LAY_KEB_NAME']));
			}
			else {
				$namaPengaju = ucwords(strtolower($data['CAP_LAY_NAMA']));
			}
		
		
		$view .="<div class='layan-form-detail-perpanjangan-container'>
		
		<div style='float:left;width:250px;text-align:center;font-size:12px;'>".$this->getUserName()."</div>
		
		<div style='float:right;width:250px;text-align:center;font-size:12px;'>$namaPengaju</div>
		
		</div>";
		
		$view .= "<br/>";
		
		$view .="<div class='layan-form-detail-perpanjangan-container'>
		
		<div style='float:left;width:250px;text-align:center;font-size:12px; line-height:0px;'>.........................................</div>
		
		<div style='float:right;width:250px;text-align:center;font-size:12px; line-height:0px'>.........................................</div>
		
		</div>";
		
		$view .= "<br/>";
		
		$view .="<div class='layan-form-detail-perpanjangan-container'>
		
		<div style='float:left;width:250px;text-align:center;font-size:12px; line-height:0px'>Nama dan Tanda Tangan</div>
		
		<div style='float:right;width:250px;text-align:center;font-size:12px; line-height:0px'>Nama dan Tanda Tangan</div>
		
		</div>";
		
		$view .= "<br/>";
			
		$view .= "</div>";
		
		$view .= "</div>";
		
		$view .= "<br/>";
		
		}
	}
	echo $view;

	
	}
	
	
	
	
	public function formPemberitahuan() {
	
	    $view .="<form>";
		
		$view .="<div class='layan-form-pemberitahuanTertulis'>Form Pemberitahuan Tertulis</div>";
		
		$view .="<form>";
		
		$view .= "<table class='layan-table-form-pemberitahuanTertulis' >";
		
		$view .= "<tr class='layan-table-tr-form-pemberitahuanTertulis-verticalAlign'>";
		
		$view .= "<td >Nomor</td>";
		
		$view .= "<td>:</td>";
		
	    $view .= "<td><input class='layan-form-pemberitahuantertulis-input' name='no' type='text'>";
		
		$view .="</tr>";
		
		$view .= "<tr class='layan-table-tr-form-pemberitahuanTertulis-verticalAlign'>";
		
		$view .= "<td class='layan-td-form-pemberitahuanTertulisHeader'>Penguasaan informasi</td>";
		
		$view .= "<td>:</td>";
		
	    $view .= "<td><input type='checkbox' name='penguasaan' value='tersedia' /> Tersedia di PPID<br /><input type='checkbox' name='penguasaan' value='lain' /> Badan Publik Lain, </td>";
		
		$view .="</tr>";
		
	    $view .= "<tr class='layan-table-tr-form-pemberitahuanTertulis-verticalAlign'>";
		
		$view .= "<td class='layan-td-form-pemberitahuanTertulisHeader'>Bentuk fisik yang tersedia</td>";
		
		$view .= "<td>:</td>";
		
	    $view .= "<td><input type='checkbox' name='fisik' value='softcopy' /> Softcopy<br /><input type='checkbox' name='fisik' value='hardcopy' /> Hardcopy </td>";
		
		$view .="</tr>";
		
		$view .= "<tr class='layan-table-tr-form-pemberitahuanTertulis-verticalAlign'>";
		
		$view .= "<td class='layan-td-form-pemberitahuanTertulisHeader'>Biaya yang dibutuhkan</td>";
		
		$view .= "<td>:</td>";
		
	    $view .= "<td><input type='checkbox' name='biaya' value='salin' /> Penyalinan<br /><input type='checkbox' name='biaya' value='kirim' /> Pengiriman<br /><input type='checkbox' name='biaya' value='lain' /> Lain-lainnya</td></td>";
		
		$view .="</tr>";
		
		$view .= "<tr class='layan-table-tr-form-pemberitahuanTertulis-verticalAlign'>";
		
		$view .= "<td >Metode penyampaian</td>";
		
		$view .= "<td>:</td>";
		
	    $view .= "<td><input class='layan-form-pemberitahuantertulis-input' name='metode' type='text'>";
		
		$view .="</tr>";
		
		$view .= "<tr class='layan-table-tr-form-pemberitahuanTertulis-verticalAlign'>";
		
		$view .= "<td >Waktu Penyampaian </td>";
		
		$view .= "<td>:</td>";
		
	    $view .= "<td><input class='layan-form-pemberitahuantertulis-input-hari' name='waktu' type='text'>";
		
		$view .="</tr>";
		
		$view .= "<tr class=''>";
		
		$view .= "<td colspan='3'>Pejelasan penghitaman/pengaburan informasi yang dimohon :</td>";
		
		$view .="</tr>";
		

		$view .="</table>";
		
        $view .="<form>";
		
		
		echo $view;
		
	}
	
	public function formPenolakan() {
		
		echo "Penolakan";
		
	}
	
	public function formPerpanjangan() {
		
		echo "Perpanjangan";
		
	}
	
	public function library() {
		
		//$pdf = new Zend_Pdf();
		
		//$m = zend('Zend_Pdf');
		
		//print_r($m);
		
		$tag  = $this->getAllDocumentTagging();
		
		$metatype = model::getAllMetadataType();
							
		$view .= $this->optionGear;
		
		$view .= "<div class='layan-libraryFilter-container-header'>Library View</div>";
		
		$view .= "<div class='layan-libraryFilter-container'>";
		
			$view .= "<div class='layan-libraryFilter-1'>";
			
				$view .= "<select data-placeholder='Pilih klasifikasi...' class='layan-libraryFilter-1-select'>";
					
					$view .= "<option selected value=''>Semua Klasifikasi</option>";
					
					$view .= core::getKlasifikasi(null);
					
				$view .= "</select>";
			
			$view .= "</div>";
			
			$view .= "<div class='layan-libraryFilter-2'>";
			
				$view .= "<select data-placeholder='Pilih Subyek...' class='layan-libraryFilter-2-select' multiple>";
				
					foreach ($tag as $key => $value) {
					
						$view .= "<option class='layan-libraryFilter-2-select-option' value='".$value['CAP_TAG_ID']."'>".ucwords(strtolower($value['CAP_TAG_VALUE']))."</option>";
					
					}
				
				$view .= "</select>";
			
			$view .= "</div>";
			
			$view .= "<div class='layan-libraryFilter-5'>";
			
				$view .= "<select data-placeholder='Pilih Metadata...' class='layan-libraryFilter-5-select'>";
					if (!empty($metatype)) {		
						foreach ($metatype as $key => $value) {
							
							if (strtoupper($value) == 'JUDUL DOKUMEN') {
							
							$view .= "<option selected class='layan-libraryFilter-5-select-option' value='".$value."'>".$value."</option>";	
							
							}
							else {
							
							$view .= "<option class='layan-libraryFilter-5-select-option' value='".$value."'>".$value."</option>";
							
							}
						
					}
					}
				
				$view .= "</select>";
			
			$view .= "</div>";
			
			$view .= "<div class='layan-libraryFilter-3'>";
			
				$view .= "<input placeholder='Text...' type='text' class='layan-libraryFilter-2-input'>";
			
			$view .= "</div>";
						
			$view .= "<div class='layan-libraryFilter-4'>";
			
				$view .= "<input type='submit' class='layan-libraryFilter-4-input-layan' value='Cari'>";
			
			$view .= "</div>";
		
		$view .= "</div>";
		
		
		$view .= "<div class='layan-libraryFilter-container-header2' style='display:none;'>Order View</div>";
		
		$view .= "<div class='layan-libraryFilter-container2' style='display:none;'>";
		
			$view .= "<div class='layan-libraryFilter-1'>";
			
				$view .= "<li class='layan-library_content-action-horizontal'><a class='layan-library_content-action-printCheckout'>Checkout dan Print</a></li>";
			
			$view .= "</div>";
		
		$view .= "</div>";
		
		$view .= "<div class='layan-library-content-container'>";
		
		$view .= self::library_content();
		
		$view .= "</div>";
		
	echo $view;
		
	}
	
	public function library_content() {
	
		$library = model::klasifikasi_admin();
		//print_r($library);
		if (!empty($library)) {
				
			foreach ($library as $key => $value) {
				
				if (!empty($value['CAP_LAN_COM_ID'])) {
				
				$view .= "<div class='layan-library-li'><img class='layan-library-image' rel='layanLibrary".$value['CAP_LAN_COM_ID']."' src='framework/resize.class.php?src=library/content/thumb/".$value['CAP_LAN_COM_ID'].".png&h=151&w=151&zc=1'></div>";
				
					if (!empty($value['METADATA'])) {
					
					asort($value['METADATA']);
					
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."=\"";
						
						$javascript .= "<table class=\'layan-library_content-table\'>";
						
						foreach ($value['METADATA'] as $key2 => $value2) {
							
							if (empty($value2['CAP_CON_MET_CONTENT']) || strtoupper($value2['CAP_CON_MET_CONTENT']) == '[BELUM DITENTUKAN]') {
								$content = '[belum ditentukan]';
							}
							else {
								$content = ucwords(strtolower($value2['CAP_CON_MET_CONTENT']));
							}
							
							$javascript .= "<tr><td class=\'layan-library_content-table-vertical\'>".$value2['CAP_CON_MET_HEADER']."</td><td class=\'layan-library_content-table-vertical2\'>:</td><td>".$content."</td></tr>";
							
						}
						
						$javascript .= "<table>";
						
						$javascript .= "\";";
						
						
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."tag=\"";
												
						if (!empty($value['TAGGING'])) {
						
						$i = 1;
						$c = count($value['TAGGING']);
						
							foreach ($value['TAGGING'] as $key2 => $value2) {

								$javascript .= "<li class=\'layan-library_content-li-horizontal\'>".ucwords(strtolower($value2['CAP_TAG_VALUE']));
								
								if ($i < $c) {
									$javascript .= ",</li>";
								}
								else {
									$javascript .= "</li>";
								}
							
							$i++;
								
							}
						
						}
												
						$javascript .= "\";";
						
						
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."link=\"";
						
						$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';
						$hostName = $_SERVER['HTTP_HOST'];
						$hostName = $protocol.$hostName.APP;
						
						if (!empty($value['CAP_LAN_COM_VALUE'])) {
												
						$javascript .= "<input type='text' class=\'layan-library_content-link-horizontal\' value='".$hostName.str_replace(" ","%20",$value['CAP_LAN_COM_VALUE'])."'>";
						
						}
						
						$javascript .= "\";";
						
						
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."action=\"";
																		
						$javascript .= "<li class=\'layan-library_content-action-horizontal\'><a class=\'layan-library_content-action-orderDokumen\' rel=\'".base64_encode($value['CAP_LAN_COM_ID'])."\'>Order</a></li><li class=\'layan-library_content-action-horizontal\'><a target=\'_blank\' href=\'".$hostName.str_replace(" ","%20",$value['CAP_LAN_COM_VALUE'])."\' class=\'layan-library_content-action-download\' rel=\'".base64_encode($value['CAP_LAN_COM_ID'])."\'>Download</a></li>";
												
						$javascript .= "\";";
												
					}
				
				}
				else {
					
					
					
				}
								
			}
					
		}
		
		if (!empty($javascript)) {
			
			$view .= "<script type='text/javascript'>";
			
			$view .= 'jQuery.noConflict()(function($){$(document).ready(function(){';
						
			$view .= $javascript;
			
			$view .= "
			
			$('.layan-library-image').click(function() {
				
				var layanLibraryScript = $(this).attr('rel');
				
				var layanLibraryScriptTag = $(this).attr('rel')+'tag';
				
				var layanLibraryScriptLink = $(this).attr('rel')+'link';
				
				var layanLibraryScriptAction = $(this).attr('rel')+'action';
				
				layanLibraryScript = eval(layanLibraryScript);
				
				layanLibraryScriptTag = eval(layanLibraryScriptTag);
				
				layanLibraryScriptLink = eval(layanLibraryScriptLink);
				
				layanLibraryScriptAction = eval(layanLibraryScriptAction);
							
				$('#layan-libraryMetadata-metaContainer-content').html(layanLibraryScript);
				
				$('#layan-libraryMetadata-tagContainer-content').html(layanLibraryScriptTag);
				
				$('#layan-libraryMetadata-linkContainer-content').html(layanLibraryScriptLink);
				
				$('#layan-libraryMetadata-actionContainer-content').html(layanLibraryScriptAction);
			
			}); 
			
						
			});
			
			});
			
			";
			
			$view .= "</script>";
			
		}
		
		return $view;
		
	}
	
	public function library_content_ajax() {

		$library = model::klasifikasi_admin_search();

		if (!empty($library)) {
				//print_r($library);
			foreach ($library as $key => $value) {
				
				if (!empty($value['CAP_LAN_COM_ID'])) {
				
				$view .= "<div class='layan-library-li'><img class='layan-library-image' rel='layanLibrary".$value['CAP_LAN_COM_ID']."' src='framework/resize.class.php?src=library/content/thumb/".$value['CAP_LAN_COM_ID'].".png&h=151&w=151&zc=1'></div>";
				
					if (!empty($value['METADATA'])) {

					asort($value['METADATA']);
					
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."=\"";
						
						$javascript .= "<table class=\'layan-library_content-table\'>";
						
						if (!empty($value['METADATA'])) {
						
							foreach ($value['METADATA'] as $key2 => $value2) {
								
								if (empty($value2['CAP_CON_MET_CONTENT']) || strtoupper($value2['CAP_CON_MET_CONTENT']) == '[BELUM DITENTUKAN]') {
									$content = '[belum ditentukan]';
								}
								else {
									$content = ucwords(strtolower($value2['CAP_CON_MET_CONTENT']));
								}
								
								$javascript .= "<tr><td class=\'layan-library_content-table-vertical\'>".$value2['CAP_CON_MET_HEADER']."</td><td class=\'layan-library_content-table-vertical2\'>:</td><td>".$content."</td></tr>";
								
							}
						
						}
						
						$javascript .= "<table>";
						
						$javascript .= "\";";
						
						
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."tag=\"";
						
						if (!empty($value['TAGGING'])) {
						
						$i = 1;
						$c = count($value['TAGGING']);
						
							foreach ($value['TAGGING'] as $key2 => $value2) {

								$javascript .= "<li class=\'layan-library_content-li-horizontal\'>".ucwords(strtolower($value2['CAP_TAG_VALUE']));
								
								if ($i < $c) {
									$javascript .= ",</li>";
								}
								else {
									$javascript .= "</li>";
								}
							
							$i++;
								
							}
						
						}
						
						$javascript .= "\";";
						
						
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."link=\"";
						
						$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';
						$hostName = $_SERVER['HTTP_HOST'];
						$hostName = $protocol.$hostName.APP;
						
						if (!empty($value['CAP_LAN_COM_VALUE'])) {
												
						$javascript .= "<input type='text' class=\'layan-library_content-link-horizontal\' value='".$hostName.str_replace(" ","%20",$value['CAP_LAN_COM_VALUE'])."'>";
						
						}
						
						$javascript .= "\";";
						
						
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."action=\"";
																		
						$javascript .= "<li class=\'layan-library_content-action-horizontal\'><a class=\'layan-library_content-action-orderDokumen\' rel=\'".base64_encode($value['CAP_LAN_COM_ID'])."\'>Order</a></li><li class=\'layan-library_content-action-horizontal\'><a target=\'_blank\' href=\'".$hostName.str_replace(" ","%20",$value['CAP_LAN_COM_VALUE'])."\' class=\'layan-library_content-action-download\' rel=\'".base64_encode($value['CAP_LAN_COM_ID'])."\'>Download</a></li>";
												
						$javascript .= "\";";
												
					}
				
				}
				else {
					
					
					
				}
								
			}
					
		}
		
		if (!empty($javascript)) {
			
			$view .= "<script type='text/javascript'>";
			
			$view .= 'jQuery.noConflict()(function($){$(document).ready(function(){';
			
			$view .= $javascript;
			
			$view .= "
			
			$('.layan-library-image').click(function() {
				
				var layanLibraryScript = $(this).attr('rel');
				
				var layanLibraryScriptTag = $(this).attr('rel')+'tag';
				
				var layanLibraryScriptLink = $(this).attr('rel')+'link';
				
				var layanLibraryScriptAction = $(this).attr('rel')+'action';
				
				layanLibraryScript = eval(layanLibraryScript);
				
				layanLibraryScriptTag = eval(layanLibraryScriptTag);
				
				layanLibraryScriptLink = eval(layanLibraryScriptLink);
				
				layanLibraryScriptAction = eval(layanLibraryScriptAction);
							
				$('#layan-libraryMetadata-metaContainer-content').html(layanLibraryScript);
				
				$('#layan-libraryMetadata-tagContainer-content').html(layanLibraryScriptTag);
				
				$('#layan-libraryMetadata-linkContainer-content').html(layanLibraryScriptLink);
				
				$('#layan-libraryMetadata-actionContainer-content').html(layanLibraryScriptAction);
			
			});
			
			});
			
			});
			
			";
			
			$view .= "</script>";
			
		}
		
		echo $view;
		
	}
	
	public function library_content_order_ajax() {

		$library = model::klasifikasi_order_search();

		if (!empty($library)) {
				
			foreach ($library as $key => $value) {
				
				if (!empty($value['CAP_LAN_COM_ID'])) {
				
				$view .= "<div class='layan-library-li'><img class='layan-library-image' rel='layanLibrary".$value['CAP_LAN_COM_ID']."' ord='".$value['CAP_LAN_COM_ID']."' src='framework/resize.class.php?src=library/content/thumb/".$value['CAP_LAN_COM_ID'].".png&h=151&w=151&zc=1'></div>";
				
					if (!empty($value['METADATA'])) {

					asort($value['METADATA']);
					
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."=\"";
						
						$javascript .= "<table class=\'layan-library_content-table\'>";
						
						if (!empty($value['METADATA'])) {
						
						$u++;
									
							foreach ($value['METADATA'] as $key2 => $value2) {
															
								if (strtoupper($value2['CAP_CON_MET_HEADER']) == 'JUDUL DOKUMEN') {
								
								$printView .= "<tr><td style='vertical-align:text-top;'>".$u.".</td><td style='vertical-align:text-top;'> ".ucwords(strtolower($value2['CAP_CON_MET_CONTENT']))."</td></tr>";
								}
								
								if (empty($value2['CAP_CON_MET_CONTENT']) || strtoupper($value2['CAP_CON_MET_CONTENT']) == '[BELUM DITENTUKAN]') {
									$content = '[belum ditentukan]';
								}
								else {
									$content = ucwords(strtolower($value2['CAP_CON_MET_CONTENT']));
								}
								
								$javascript .= "<tr><td class=\'layan-library_content-table-vertical\'>".$value2['CAP_CON_MET_HEADER']."</td><td class=\'layan-library_content-table-vertical2\'>:</td><td>".$content."</td></tr>";
								
							}
							
							
						
						}
						
						$javascript .= "<table>";
						
						$javascript .= "\";";
						
						
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."tag=\"";
						
						if (!empty($value['TAGGING'])) {
						
						$i = 1;
						$c = count($value['TAGGING']);
						
							foreach ($value['TAGGING'] as $key2 => $value2) {

								$javascript .= "<li class=\'layan-library_content-li-horizontal\'>".ucwords(strtolower($value2['CAP_TAG_VALUE']));
								
								if ($i < $c) {
									$javascript .= ",</li>";
								}
								else {
									$javascript .= "</li>";
								}
							
							$i++;
								
							}
						
						}
						
						$javascript .= "\";";
						
						
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."link=\"";
						
						$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';
						$hostName = $_SERVER['HTTP_HOST'];
						$hostName = $protocol.$hostName.APP;
						
						if (!empty($value['CAP_LAN_COM_VALUE'])) {
												
						$javascript .= "<input type='text' class=\'layan-library_content-link-horizontal\' value='".$hostName.str_replace(" ","%20",$value['CAP_LAN_COM_VALUE'])."'>";
						
						}
						
						$javascript .= "\";";
						
						
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."action=\"";
																		
						$javascript .= "<li class=\'layan-library_content-action-horizontal\'><a class=\'layan-library_content-action-cancel-order\' rel=\'".base64_encode($value['CAP_LAN_COM_ID'])."\'>Cancel Order</a></li><li class=\'layan-library_content-action-horizontal\'><a target=\'_blank\' href=\'".$hostName.str_replace(" ","%20",$value['CAP_LAN_COM_VALUE'])."\' class=\'layan-library_content-action-download\' rel=\'".base64_encode($value['CAP_LAN_COM_ID'])."\'>Download</a></li>";
												
						$javascript .= "\";";
												
					}
				
				}
				else {
					
					
					
				}
								
			}
					
		}
		
		if (!empty($javascript)) {
			
			$view .= "<script type='text/javascript'>";
			
			$view .= 'jQuery.noConflict()(function($){$(document).ready(function(){';
			
			$view .= $javascript;
			
			$view .= "
			
			$('.layan-library-image').click(function() {
				
				var layanLibraryScript = $(this).attr('rel');
				
				var layanLibraryScriptTag = $(this).attr('rel')+'tag';
				
				var layanLibraryScriptLink = $(this).attr('rel')+'link';
				
				var layanLibraryScriptAction = $(this).attr('rel')+'action';
				
				layanLibraryScript = eval(layanLibraryScript);
				
				layanLibraryScriptTag = eval(layanLibraryScriptTag);
				
				layanLibraryScriptLink = eval(layanLibraryScriptLink);
				
				layanLibraryScriptAction = eval(layanLibraryScriptAction);
							
				$('#layan-libraryMetadata-metaContainer-content').html(layanLibraryScript);
				
				$('#layan-libraryMetadata-tagContainer-content').html(layanLibraryScriptTag);
				
				$('#layan-libraryMetadata-linkContainer-content').html(layanLibraryScriptLink);
				
				$('#layan-libraryMetadata-actionContainer-content').html(layanLibraryScriptAction);
			
			}); 
			
			});
			
			});
			
			";
			
			$view .= "</script>";
			
		}
		
		//$view .= "<div style='display:none;'>";
		
		$view .= "<div class='layan-print-order-stub' style='width:200px;border:1px solid black;padding:15px;'>";
		
		$view .= "<div class='layan-print-order-stub-header' style='text-align:center;font-weight:bold;font-size:11px;'>Kementerian Pertanian</div>";
		
		$view .= "<div class='layan-print-order-stub-sub-header' style='text-align:center;margin-bottom:10px;font-size:10px;width:100%;border-bottom:3px double black;padding-bottom:10px;'>Library Order No.</div>";
		
		$view .= "<div class='layan-print-order-stub-sub-content' style='margin-bottom:10px;'>";
						
		$view .= "<table style='border-collapse:collapse;font-size:10px;'>";
		
		$view .= $printView;
		
		$view .= "</table>";
		
		$view .= "</div>";
		
		$view .= "<div class='layan-print-order-stub-footer' style='text-align:center;font-size:11px;border-top:3px double black;padding-top:10px;'>".date("d F, Y H:i:s")."</div>";
							
		$view .= "</div>";
		
		echo $view;
		
	}
	
	public function library_guest() {
		
		//$pdf = new Zend_Pdf();
		
		//$m = zend('Zend_Pdf');
		
		//print_r($m);
		
		$tag  = $this->getAllDocumentTagging();
		
		$metatype = model::getAllMetadataType();
							
		$view .= $this->optionGear;
		
		$view .= "<div class='layan-libraryFilter-container-header'>Library View</div>";
		
		$view .= "<div class='layan-libraryFilter-container'>";
		
			$view .= "<div class='layan-libraryFilter-1'>";
			
				$view .= "<select data-placeholder='Pilih klasifikasi...' class='layan-libraryFilter-1-select'>";
					
					$view .= "<option selected value=''>Semua Klasifikasi</option>";
					
					$view .= core::getKlasifikasi(null);
					
				$view .= "</select>";
			
			$view .= "</div>";
			
			$view .= "<div class='layan-libraryFilter-2'>";
			
				$view .= "<select data-placeholder='Pilih Subyek...' class='layan-libraryFilter-2-select' multiple>";
				
					foreach ($tag as $key => $value) {
					
						$view .= "<option class='layan-libraryFilter-2-select-option' value='".$value['CAP_TAG_ID']."'>".ucwords(strtolower($value['CAP_TAG_VALUE']))."</option>";
					
					}
				
				$view .= "</select>";
			
			$view .= "</div>";
			
			$view .= "<div class='layan-libraryFilter-5'>";
			
				$view .= "<select data-placeholder='Pilih Metadata...' class='layan-libraryFilter-5-select'>";
					if (!empty($metatype)) {		
						foreach ($metatype as $key => $value) {
							
							if (strtoupper($value) == 'JUDUL DOKUMEN') {
							
							$view .= "<option selected class='layan-libraryFilter-5-select-option' value='".$value."'>".$value."</option>";	
							
							}
							else {
							
							$view .= "<option class='layan-libraryFilter-5-select-option' value='".$value."'>".$value."</option>";
							
							}
						
					}
					}
				
				$view .= "</select>";
			
			$view .= "</div>";
			
			$view .= "<div class='layan-libraryFilter-3'>";
			
				$view .= "<input placeholder='Text...' type='text' class='layan-libraryFilter-2-input'>";
			
			$view .= "</div>";
						
			$view .= "<div class='layan-libraryFilter-4'>";
			
				$view .= "<input type='submit' class='layan-libraryFilter-4-input-layan-guest' value='Cari'>";
			
			$view .= "</div>";
		
		$view .= "</div>";
		
		
		$view .= "<div class='layan-libraryFilter-container-header2' style='display:none;'>Order View</div>";
		
		$view .= "<div class='layan-libraryFilter-container2' style='display:none;'>";
		
			$view .= "<div class='layan-libraryFilter-1'>";
			
				$view .= "<li class='layan-library_content-action-horizontal'><a class='layan-library_content-action-printCheckout'>Checkout dan Print</a></li>";
			
			$view .= "</div>";
		
		$view .= "</div>";
		
		$view .= "<div class='layan-library-content-container'>";
		
		$view .= self::library_guest_content();
		
		$view .= "</div>";
		
	echo $view;
		
	}
	
	public function library_guest_content() {
	
		$library = model::klasifikasi();
		//print_r($library);
		if (!empty($library)) {
				
			foreach ($library as $key => $value) {
				
				if (!empty($value['CAP_LAN_COM_ID']) && !empty($value['CAP_LAN_COM_PUBLISH'])) {
				
				$view .= "<div class='layan-library-li'><img class='layan-library-image' rel='layanLibrary".$value['CAP_LAN_COM_ID']."' src='framework/resize.class.php?src=library/content/thumb/".$value['CAP_LAN_COM_ID'].".png&h=151&w=151&zc=1'></div>";
				
					if (!empty($value['METADATA'])) {
					
					asort($value['METADATA']);
					
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."=\"";
						
						$javascript .= "<table class=\'layan-library_content-table\'>";
						
						foreach ($value['METADATA'] as $key2 => $value2) {
							
							if (empty($value2['CAP_CON_MET_CONTENT']) || strtoupper($value2['CAP_CON_MET_CONTENT']) == '[BELUM DITENTUKAN]') {
								$content = '[belum ditentukan]';
							}
							else {
								$content = ucwords(strtolower($value2['CAP_CON_MET_CONTENT']));
							}
							
							$javascript .= "<tr><td class=\'layan-library_content-table-vertical\'>".$value2['CAP_CON_MET_HEADER']."</td><td class=\'layan-library_content-table-vertical2\'>:</td><td>".$content."</td></tr>";
							
						}
						
						$javascript .= "<table>";
						
						$javascript .= "\";";
						
						
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."tag=\"";
												
						if (!empty($value['TAGGING'])) {
						
						$i = 1;
						$c = count($value['TAGGING']);
						
							foreach ($value['TAGGING'] as $key2 => $value2) {

								$javascript .= "<li class=\'layan-library_content-li-horizontal\'>".ucwords(strtolower($value2['CAP_TAG_VALUE']));
								
								if ($i < $c) {
									$javascript .= ",</li>";
								}
								else {
									$javascript .= "</li>";
								}
							
							$i++;
								
							}
						
						}
												
						$javascript .= "\";";
						
						
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."link=\"";
						
						$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';
						$hostName = $_SERVER['HTTP_HOST'];
						$hostName = $protocol.$hostName.APP;
						
						if (!empty($value['CAP_LAN_COM_VALUE'])) {
												
						$javascript .= "<input type='text' class=\'layan-library_content-link-horizontal\' value='".str_replace(" ","%20",$value['CAP_LAN_COM_VALUE'])."'>";
						
						}
						
						$javascript .= "\";";
						
						
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."action=\"";
						
							if (!empty($value['CAP_LAN_COM_DOWNLOADABLE'])) {
													
							$javascript .= "<li class=\'layan-library_content-action-horizontal\'><a target=\'_blank\' href=\'".str_replace(" ","%20",$value['CAP_LAN_COM_VALUE'])."\' class=\'layan-library_content-action-download\' rel=\'".base64_encode($value['CAP_LAN_COM_ID'])."\'>Download</a></li>";
						
							}
												
						$javascript .= "\";";
												
					}
				
				}
				else {
					
					
					
				}
								
			}
					
		}
		
		if (!empty($javascript)) {
			
			$view .= "<script type='text/javascript'>";
			
			$view .= 'jQuery.noConflict()(function($){$(document).ready(function(){';
						
			$view .= $javascript;
			
			$view .= "
			
			$('.layan-library-image').click(function() {
				
				var layanLibraryScript = $(this).attr('rel');
				
				var layanLibraryScriptTag = $(this).attr('rel')+'tag';
				
				var layanLibraryScriptLink = $(this).attr('rel')+'link';
				
				var layanLibraryScriptAction = $(this).attr('rel')+'action';
				
				layanLibraryScript = eval(layanLibraryScript);
				
				layanLibraryScriptTag = eval(layanLibraryScriptTag);
				
				layanLibraryScriptLink = eval(layanLibraryScriptLink);
				
				layanLibraryScriptAction = eval(layanLibraryScriptAction);
							
				$('#layan-libraryMetadata-metaContainer-content').html(layanLibraryScript);
				
				$('#layan-libraryMetadata-tagContainer-content').html(layanLibraryScriptTag);
				
				$('#layan-libraryMetadata-linkContainer-content').html(layanLibraryScriptLink);
				
				$('#layan-libraryMetadata-actionContainer-content').html(layanLibraryScriptAction);
			
			}); 
			
						
			});
			
			});
			
			";
			
			$view .= "</script>";
			
		}
		
		return $view;
		
	}
	
	public function library_guest_content_ajax() {

		$library = model::klasifikasi_search();

		if (!empty($library)) {

			foreach ($library as $key => $value) {
				
				if (!empty($value['CAP_LAN_COM_ID']) && !empty($value['CAP_LAN_COM_PUBLISH'])) {
				
				$view .= "<div class='layan-library-li'><img class='layan-library-image' rel='layanLibrary".$value['CAP_LAN_COM_ID']."' src='framework/resize.class.php?src=library/content/thumb/".$value['CAP_LAN_COM_ID'].".png&h=151&w=151&zc=1'></div>";
				
					if (!empty($value['METADATA'])) {

					asort($value['METADATA']);
					
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."=\"";
						
						$javascript .= "<table class=\'layan-library_content-table\'>";
						
						if (!empty($value['METADATA'])) {
						
							foreach ($value['METADATA'] as $key2 => $value2) {
								
								if (empty($value2['CAP_CON_MET_CONTENT']) || strtoupper($value2['CAP_CON_MET_CONTENT']) == '[BELUM DITENTUKAN]') {
									$content = '[belum ditentukan]';
								}
								else {
									$content = ucwords(strtolower($value2['CAP_CON_MET_CONTENT']));
								}
								
								$javascript .= "<tr><td class=\'layan-library_content-table-vertical\'>".$value2['CAP_CON_MET_HEADER']."</td><td class=\'layan-library_content-table-vertical2\'>:</td><td>".$content."</td></tr>";
								
							}
						
						}
						
						$javascript .= "<table>";
						
						$javascript .= "\";";
						
						
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."tag=\"";
						
						if (!empty($value['TAGGING'])) {
						
						$i = 1;
						$c = count($value['TAGGING']);
						
							foreach ($value['TAGGING'] as $key2 => $value2) {

								$javascript .= "<li class=\'layan-library_content-li-horizontal\'>".ucwords(strtolower($value2['CAP_TAG_VALUE']));
								
								if ($i < $c) {
									$javascript .= ",</li>";
								}
								else {
									$javascript .= "</li>";
								}
							
							$i++;
								
							}
						
						}
						
						$javascript .= "\";";
						
						
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."link=\"";
						
						$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';
						$hostName = $_SERVER['HTTP_HOST'];
						$hostName = $protocol.$hostName.APP;
						
						if (!empty($value['CAP_LAN_COM_VALUE'])) {
												
						$javascript .= "<input type='text' class=\'layan-library_content-link-horizontal\' value='".str_replace(" ","%20",$value['CAP_LAN_COM_VALUE'])."'>";
						
						}
						
						$javascript .= "\";";
						
						
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."action=\"";
						
							if (!empty($value['CAP_LAN_COM_DOWNLOADABLE'])) {
										
							$javascript .= "<li class=\'layan-library_content-action-horizontal\'><a target=\'_blank\' href=\'".str_replace(" ","%20",$value['CAP_LAN_COM_VALUE'])."\' class=\'layan-library_content-action-download\' rel=\'".base64_encode($value['CAP_LAN_COM_ID'])."\'>Download</a></li>";			
							}
												
						$javascript .= "\";";
												
					}
				
				}
				else {
					
					
					
				}
								
			}
					
		}
		
		if (!empty($javascript)) {
			
			$view .= "<script type='text/javascript'>";
			
			$view .= 'jQuery.noConflict()(function($){$(document).ready(function(){';
			
			$view .= $javascript;
			
			$view .= "
			
			$('.layan-library-image').click(function() {
				
				var layanLibraryScript = $(this).attr('rel');
				
				var layanLibraryScriptTag = $(this).attr('rel')+'tag';
				
				var layanLibraryScriptLink = $(this).attr('rel')+'link';
				
				var layanLibraryScriptAction = $(this).attr('rel')+'action';
				
				layanLibraryScript = eval(layanLibraryScript);
				
				layanLibraryScriptTag = eval(layanLibraryScriptTag);
				
				layanLibraryScriptLink = eval(layanLibraryScriptLink);
				
				layanLibraryScriptAction = eval(layanLibraryScriptAction);
							
				$('#layan-libraryMetadata-metaContainer-content').html(layanLibraryScript);
				
				$('#layan-libraryMetadata-tagContainer-content').html(layanLibraryScriptTag);
				
				$('#layan-libraryMetadata-linkContainer-content').html(layanLibraryScriptLink);
				
				$('#layan-libraryMetadata-actionContainer-content').html(layanLibraryScriptAction);
			
			});
			
			});
			
			});
			
			";
			
			$view .= "</script>";
			
		}
		
		echo $view;
		
	}
	
	public function library_user() {
		
		//$pdf = new Zend_Pdf();
		
		//$m = zend('Zend_Pdf');
		
		//print_r($m);
		
		$tag  = $this->getAllDocumentTagging();
		
		$metatype = model::getAllMetadataType();
							
		$view .= $this->optionGear;
		
		$view .= "<div class='layan-libraryFilter-container-header'>Library View</div>";
		
		$view .= "<div class='layan-libraryFilter-container'>";
		
			$view .= "<div class='layan-libraryFilter-1'>";
			
				$view .= "<select data-placeholder='Pilih klasifikasi...' class='layan-libraryFilter-1-select'>";
					
					$view .= "<option selected value=''>Semua Klasifikasi</option>";
					
					$view .= core::getKlasifikasi(null);
					
				$view .= "</select>";
			
			$view .= "</div>";
			
			$view .= "<div class='layan-libraryFilter-2'>";
			
				$view .= "<select data-placeholder='Pilih Subyek...' class='layan-libraryFilter-2-select' multiple>";
				
					foreach ($tag as $key => $value) {
					
						$view .= "<option class='layan-libraryFilter-2-select-option' value='".$value['CAP_TAG_ID']."'>".ucwords(strtolower($value['CAP_TAG_VALUE']))."</option>";
					
					}
				
				$view .= "</select>";
			
			$view .= "</div>";
			
			$view .= "<div class='layan-libraryFilter-5'>";
			
				$view .= "<select data-placeholder='Pilih Metadata...' class='layan-libraryFilter-5-select'>";
					if (!empty($metatype)) {	
						
						foreach ($metatype as $key => $value) {
							
							if (strtoupper($value) == 'JUDUL DOKUMEN') {
							
							$view .= "<option selected class='layan-libraryFilter-5-select-option' value='".$value."'>".$value."</option>";	
							
							}
							else {
							
							$view .= "<option class='layan-libraryFilter-5-select-option' value='".$value."'>".$value."</option>";
							
							}
						
						}
					
					}
				
				$view .= "</select>";
			
			$view .= "</div>";
			
			$view .= "<div class='layan-libraryFilter-3'>";
			
				$view .= "<input placeholder='Text...' type='text' class='layan-libraryFilter-2-input'>";
			
			$view .= "</div>";
						
			$view .= "<div class='layan-libraryFilter-4'>";
			
				$view .= "<input type='submit' class='layan-libraryFilter-4-input-layan-user' value='Cari'>";
			
			$view .= "</div>";
		
		$view .= "</div>";
		
		
		$view .= "<div class='layan-libraryFilter-container-header2' style='display:none;'>Order View</div>";
		
		$view .= "<div class='layan-libraryFilter-container2' style='display:none;'>";
		
			$view .= "<div class='layan-libraryFilter-1'>";
			
				$view .= "<li class='layan-library_content-action-horizontal'><a class='layan-library_content-action-printCheckout'>Checkout dan Print</a></li>";
			
			$view .= "</div>";
		
		$view .= "</div>";
		
		$view .= "<div class='layan-library-content-container'>";
		
		$view .= self::library_user_content();
		
		$view .= "</div>";
		
	echo $view;
		
	}
	
	public function library_user_content() {
		
		$library = model::klasifikasi();

		if (!empty($library)) {
				
			foreach ($library as $key => $value) {
				
				if (!empty($value['CAP_LAN_COM_ID']) && !empty($value['CAP_LAN_COM_PUBLISH'])) {
				
				$view .= "<div class='layan-library-li'><img class='layan-library-image' rel='layanLibrary".$value['CAP_LAN_COM_ID']."' src='framework/resize.class.php?src=library/content/thumb/".$value['CAP_LAN_COM_ID'].".png&h=151&w=151&zc=1'></div>";
				
					if (!empty($value['METADATA'])) {
					
					asort($value['METADATA']);
					
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."=\"";
						
						$javascript .= "<table class=\'layan-library_content-table\'>";
						
						foreach ($value['METADATA'] as $key2 => $value2) {
							
							if (empty($value2['CAP_CON_MET_CONTENT']) || strtoupper($value2['CAP_CON_MET_CONTENT']) == '[BELUM DITENTUKAN]') {
								$content = '[belum ditentukan]';
							}
							else {
								$content = ucwords(strtolower($value2['CAP_CON_MET_CONTENT']));
							}
							
							$javascript .= "<tr><td class=\'layan-library_content-table-vertical\'>".$value2['CAP_CON_MET_HEADER']."</td><td class=\'layan-library_content-table-vertical2\'>:</td><td>".$content."</td></tr>";
							
						}
						
						$javascript .= "<table>";
						
						$javascript .= "\";";
						
						
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."tag=\"";
												
						if (!empty($value['TAGGING'])) {
						
						$i = 1;
						$c = count($value['TAGGING']);
						
							foreach ($value['TAGGING'] as $key2 => $value2) {

								$javascript .= "<li class=\'layan-library_content-li-horizontal\'>".ucwords(strtolower($value2['CAP_TAG_VALUE']));
								
								if ($i < $c) {
									$javascript .= ",</li>";
								}
								else {
									$javascript .= "</li>";
								}
							
							$i++;
								
							}
						
						}
												
						$javascript .= "\";";
						
						
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."link=\"";
						
						$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';
						$hostName = $_SERVER['HTTP_HOST'];
						$hostName = $protocol.$hostName.APP;
						
						if (!empty($value['CAP_LAN_COM_VALUE'])) {
												
						$javascript .= "<input type='text' class=\'layan-library_content-link-horizontal\' value='".str_replace(" ","%20",$value['CAP_LAN_COM_VALUE'])."'>";
						
						}
						
						$javascript .= "\";";
						
						
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."action=\"";
																			
						$javascript .= "<li class=\'layan-library_content-action-horizontal\'><a class=\'layan-library_content-action-orderDokumen\' rel=\'".base64_encode($value['CAP_LAN_COM_ID'])."\'>Order</a></li><li class=\'layan-library_content-action-horizontal\'><a target=\'_blank\' href=\'".str_replace(" ","%20",$value['CAP_LAN_COM_VALUE'])."\' class=\'layan-library_content-action-download\' rel=\'".base64_encode($value['CAP_LAN_COM_ID'])."\'>Download</a></li>";
																		
						$javascript .= "\";";
												
					}
				
				}
				else {
					
					
					
				}
								
			}
					
		}
		
		if (!empty($javascript)) {
			
			$view .= "<script type='text/javascript'>";
			
			$view .= 'jQuery.noConflict()(function($){$(document).ready(function(){';
						
			$view .= $javascript;
			
			$view .= "
			
			$('.layan-library-image').click(function() {
				
				var layanLibraryScript = $(this).attr('rel');
				
				var layanLibraryScriptTag = $(this).attr('rel')+'tag';
				
				var layanLibraryScriptLink = $(this).attr('rel')+'link';
				
				var layanLibraryScriptAction = $(this).attr('rel')+'action';
				
				layanLibraryScript = eval(layanLibraryScript);
				
				layanLibraryScriptTag = eval(layanLibraryScriptTag);
				
				layanLibraryScriptLink = eval(layanLibraryScriptLink);
				
				layanLibraryScriptAction = eval(layanLibraryScriptAction);
							
				$('#layan-libraryMetadata-metaContainer-content').html(layanLibraryScript);
				
				$('#layan-libraryMetadata-tagContainer-content').html(layanLibraryScriptTag);
				
				$('#layan-libraryMetadata-linkContainer-content').html(layanLibraryScriptLink);
				
				$('#layan-libraryMetadata-actionContainer-content').html(layanLibraryScriptAction);
			
			}); 
			
						
			});
			
			});
			
			";
			
			$view .= "</script>";
			
		}
		
		return $view;
		
	}
	
	public function library_user_content_ajax() {

		$library = model::klasifikasi_search();

		if (!empty($library)) {
				//print_r($library);
			foreach ($library as $key => $value) {
				
				if (!empty($value['CAP_LAN_COM_ID']) && !empty($value['CAP_LAN_COM_PUBLISH'])) {
				
				$view .= "<div class='layan-library-li'><img class='layan-library-image' rel='layanLibrary".$value['CAP_LAN_COM_ID']."' src='framework/resize.class.php?src=library/content/thumb/".$value['CAP_LAN_COM_ID'].".png&h=151&w=151&zc=1'></div>";
				
					if (!empty($value['METADATA'])) {

					asort($value['METADATA']);
					
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."=\"";
						
						$javascript .= "<table class=\'layan-library_content-table\'>";
						
						if (!empty($value['METADATA'])) {
						
							foreach ($value['METADATA'] as $key2 => $value2) {
								
								if (empty($value2['CAP_CON_MET_CONTENT']) || strtoupper($value2['CAP_CON_MET_CONTENT']) == '[BELUM DITENTUKAN]') {
									$content = '[belum ditentukan]';
								}
								else {
									$content = ucwords(strtolower($value2['CAP_CON_MET_CONTENT']));
								}
								
								$javascript .= "<tr><td class=\'layan-library_content-table-vertical\'>".$value2['CAP_CON_MET_HEADER']."</td><td class=\'layan-library_content-table-vertical2\'>:</td><td>".$content."</td></tr>";
								
							}
						
						}
						
						$javascript .= "<table>";
						
						$javascript .= "\";";
						
						
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."tag=\"";
						
						if (!empty($value['TAGGING'])) {
						
						$i = 1;
						$c = count($value['TAGGING']);
						
							foreach ($value['TAGGING'] as $key2 => $value2) {

								$javascript .= "<li class=\'layan-library_content-li-horizontal\'>".ucwords(strtolower($value2['CAP_TAG_VALUE']));
								
								if ($i < $c) {
									$javascript .= ",</li>";
								}
								else {
									$javascript .= "</li>";
								}
							
							$i++;
								
							}
						
						}
						
						$javascript .= "\";";
						
						
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."link=\"";
						
						$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';
						$hostName = $_SERVER['HTTP_HOST'];
						$hostName = $protocol.$hostName.APP;
						
						if (!empty($value['CAP_LAN_COM_VALUE'])) {
												
						$javascript .= "<input type='text' class=\'layan-library_content-link-horizontal\' value='".str_replace(" ","%20",$value['CAP_LAN_COM_VALUE'])."'>";
						
						}
						
						$javascript .= "\";";
						
						
						$javascript .= "var layanLibrary".$value['CAP_LAN_COM_ID']."action=\"";
																
						$javascript .= "<li class=\'layan-library_content-action-horizontal\'><a class=\'layan-library_content-action-orderDokumen\' rel=\'".base64_encode($value['CAP_LAN_COM_ID'])."\'>Order</a></li><li class=\'layan-library_content-action-horizontal\'><a target=\'_blank\' href=\'".$hostName.str_replace(" ","%20",$value['CAP_LAN_COM_VALUE'])."\' class=\'layan-library_content-action-download\' rel=\'".base64_encode($value['CAP_LAN_COM_ID'])."\'>Download</a></li>";			
																		
						$javascript .= "\";";
												
					}
				
				}
				else {
					
					
					
				}
								
			}
					
		}
		
		if (!empty($javascript)) {
			
			$view .= "<script type='text/javascript'>";
			
			$view .= 'jQuery.noConflict()(function($){$(document).ready(function(){';
			
			$view .= $javascript;
			
			$view .= "
			
			$('.layan-library-image').click(function() {
				
				var layanLibraryScript = $(this).attr('rel');
				
				var layanLibraryScriptTag = $(this).attr('rel')+'tag';
				
				var layanLibraryScriptLink = $(this).attr('rel')+'link';
				
				var layanLibraryScriptAction = $(this).attr('rel')+'action';
				
				layanLibraryScript = eval(layanLibraryScript);
				
				layanLibraryScriptTag = eval(layanLibraryScriptTag);
				
				layanLibraryScriptLink = eval(layanLibraryScriptLink);
				
				layanLibraryScriptAction = eval(layanLibraryScriptAction);
							
				$('#layan-libraryMetadata-metaContainer-content').html(layanLibraryScript);
				
				$('#layan-libraryMetadata-tagContainer-content').html(layanLibraryScriptTag);
				
				$('#layan-libraryMetadata-linkContainer-content').html(layanLibraryScriptLink);
				
				$('#layan-libraryMetadata-actionContainer-content').html(layanLibraryScriptAction);
			
			});
			
			});
			
			});
			
			";
			
			$view .= "</script>";
			
		}
		
		echo $view;
		
	}
	
	public function libraryMetadata() {
		
		$view .= $this->optionGear;
		
		$view .= "<div id='layan-libraryMetadata'>";
		
			$view .= "<div id='layan-libraryMetadata-metaContainer'>";
			
				$view .= "<div id='layan-libraryMetadata-metaContainer-header'>Dokumen Metadata</div>";
				
				$view .= "<div id='layan-libraryMetadata-metaContainer-content'></div>";
			
			$view .= "</div>";
			
			$view .= "<div id='layan-libraryMetadata-tagContainer'>";
			
				$view .= "<div id='layan-libraryMetadata-tagContainer-header'>Subyek</div>";
				
				$view .= "<div id='layan-libraryMetadata-tagContainer-content'></div>";
			
			$view .= "</div>";
			
			$view .= "<div id='layan-libraryMetadata-linkContainer'>";
			
				$view .= "<div id='layan-libraryMetadata-linkContainer-header'>Link</div>";
				
				$view .= "<div id='layan-libraryMetadata-linkContainer-content'></div>";
			
			$view .= "</div>";
			
			$view .= "<div id='layan-libraryMetadata-actionContainer'>";
			
				$view .= "<div id='layan-libraryMetadata-actionContainer-header'>Action</div>";
				
				$view .= "<div id='layan-libraryMetadata-actionContainer-content'></div>";
			
			$view .= "</div>";
		
		$view .= "</div>";
		
		echo $view;
		
	}
	
	public function libraryGuestMetadata() {
		
		$view .= $this->optionGear;
		
		$view .= "<div id='layan-libraryMetadata'>";
		
			$view .= "<div id='layan-libraryMetadata-metaContainer'>";
			
				$view .= "<div id='layan-libraryMetadata-metaContainer-header'>Dokumen Metadata</div>";
				
				$view .= "<div id='layan-libraryMetadata-metaContainer-content'></div>";
			
			$view .= "</div>";
			
			$view .= "<div id='layan-libraryMetadata-tagContainer'>";
			
				$view .= "<div id='layan-libraryMetadata-tagContainer-header'>Subyek</div>";
				
				$view .= "<div id='layan-libraryMetadata-tagContainer-content'></div>";
			
			$view .= "</div>";
			
			$view .= "<div id='layan-libraryMetadata-linkContainer'>";
			
				$view .= "<div id='layan-libraryMetadata-linkContainer-header'>Link</div>";
				
				$view .= "<div id='layan-libraryMetadata-linkContainer-content'></div>";
			
			$view .= "</div>";
			
			$view .= "<div id='layan-libraryMetadata-actionContainer'>";
			
				$view .= "<div id='layan-libraryMetadata-actionContainer-header'>Action</div>";
				
				$view .= "<div id='layan-libraryMetadata-actionContainer-content'></div>";
			
			$view .= "</div>";
		
		$view .= "</div>";
		
		echo $view;
		
	}
	
	public function libraryUserMetadata() {
		
		$view .= $this->optionGear;
		
		$view .= "<div id='layan-libraryMetadata'>";
		
			$view .= "<div id='layan-libraryMetadata-metaContainer'>";
			
				$view .= "<div id='layan-libraryMetadata-metaContainer-header'>Dokumen Metadata</div>";
				
				$view .= "<div id='layan-libraryMetadata-metaContainer-content'></div>";
			
			$view .= "</div>";
			
			$view .= "<div id='layan-libraryMetadata-tagContainer'>";
			
				$view .= "<div id='layan-libraryMetadata-tagContainer-header'>Subyek</div>";
				
				$view .= "<div id='layan-libraryMetadata-tagContainer-content'></div>";
			
			$view .= "</div>";
			
			$view .= "<div id='layan-libraryMetadata-linkContainer'>";
			
				$view .= "<div id='layan-libraryMetadata-linkContainer-header'>Link</div>";
				
				$view .= "<div id='layan-libraryMetadata-linkContainer-content'></div>";
			
			$view .= "</div>";
			
			$view .= "<div id='layan-libraryMetadata-actionContainer'>";
			
				$view .= "<div id='layan-libraryMetadata-actionContainer-header'>Action</div>";
				
				$view .= "<div id='layan-libraryMetadata-actionContainer-content'></div>";
			
			$view .= "</div>";
		
		$view .= "</div>";
		
		echo $view;
		
	}
			
}

?>