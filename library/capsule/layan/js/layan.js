
var html;

jQuery.noConflict()(function($){

$.fn.center = function () {
    this.css("position","absolute");
    this.css("top", (($(window).height() - this.outerHeight()) / 2) + $(window).scrollTop() + "px");
    this.css("left", (($(window).width() - this.outerWidth()) / 2) + $(window).scrollLeft() + "px");
    return this;
}

jQuery.fn.extend({
  slideRight: function() {
    return this.each(function() {
      jQuery(this).animate({width: 'show'}, 250);
    });
  },
  slideLeft: function() {
    return this.each(function() {
      jQuery(this).animate({width: 'hide'}, 250);
    });
  },
  slideToggleWidth: function() {
    return this.each(function() {
      var el = jQuery(this);
      if (el.css('display') == 'none') {
        el.slideRight();
      } else {
        el.slideLeft();
      }
    });
  }
});

	$(document).ready(function(){		
				
		$('.qtip-upper').qtip({
			content: {
			attr: 'text' // Notice that content.text is long-hand for simply declaring content as a string
			},
			position: {
			my: 'bottom center',  // Position my top left...
			at: 'top center' // at the bottom right of...
			},
			style: {classes: 'ui-tooltip-dark ui-tooltip-shadow'}
		});

		$('.qtip-bottom').qtip({
			content: {
			attr: 'text' // Notice that content.text is long-hand for simply declaring content as a string
			},
			position: {
			my: 'top center',  // Position my top left...
			at: 'bottom center' // at the bottom right of...
			},
			style: {classes: 'ui-tooltip-dark ui-tooltip-shadow'}
		});
		
		$('.layan-normal-form-container').removeAttr('style').hide().fadeIn('slow');
		
		$('.layan-normal-plus-button').live('click',function() {
			
			if ($('.layan-permohonan-float-left-edit-permohonan').length == 1 && $('.layan-permohonan-float-left-edit-permohonan').attr('text') == "Edit Mode") {
				alert("Mohon masuk ke dalam mode 'Edit' untuk merubah data ini");
				return false;
			}
			
			var row = $(this).parent().parent().html();
			
			$(this).parent().parent().after("<tr class='layan-normal-table-tr-hover' last='yes'>"+row+"</tr>");
			
			$('.layan-normal-table-tr-hover[last="yes"] input').val('');
			
			$('.layan-normal-table-tr-hover[last="yes"]').removeAttr('last');
					
		});
		
		$('.layan-normal-minus-button').live('click',function() {
			
			if ($('.layan-permohonan-float-left-edit-permohonan').length == 1 && $('.layan-permohonan-float-left-edit-permohonan').attr('text') == "Edit Mode") {
				alert("Mohon masuk ke dalam mode 'Edit' untuk merubah data ini");
				return false;
			}
			
			var count = $('.layan-normal-minus-button').length;

				if (count != 1) { 
								
					var id  = $('.layan-permohonan-dokumen-delete').val();

					var cur = $(this).parent().find('input[name="idDokumen[]"]').val();
					
						if (cur != '' && cur != undefined) {
					
							$('.layan-permohonan-dokumen-delete').val(id+cur+",");
							
						}
					
					$(this).parent().parent().remove();
					
				}
				else {
					
					var id  = $('.layan-permohonan-dokumen-delete').val();

					var cur = $(this).parent().find('input[name="idDokumen[]"]').val();
					
						if (cur != '' && cur != undefined) {
					
							$('.layan-permohonan-dokumen-delete').val(id+cur+",");
							
						}
					
					$(this).parent().parent().find('input').val('');
					
				}
		
		});
		
		$('.layan-normal-form-instansi').live('change', function() {
		
			if ($(this).val() == 'badan hukum' || $(this).val() == 'BADAN HUKUM') {
				$('.layan-normal-form-hide').fadeIn('slow');
			}
			else {
				$('.layan-normal-form-hide').fadeOut('fast');	
			}
		
		});
		
		$('.layan-permohonan-back-button').live('click', function() {

			$('body').html(html).hide().fadeIn('slow');
			//[id^=jander]
			$('[id^=ui-tooltip-]').remove();
			
										$('.qtip-upper').qtip({
											content: {
											attr: 'text' // Notice that content.text is long-hand for simply declaring content as a string
											},
											position: {
											my: 'bottom center',  // Position my top left...
											at: 'top center' // at the bottom right of...
											},
											style: {classes: 'ui-tooltip-dark ui-tooltip-shadow'}
										});
																									
		});
		
		/*
		
		$('.layan-permohonan-save-button').live('click', function() {
		
		var data = [];
		
			$('.layan-permohonan-table-list tr').each(function(i) {
			
			data[i] = {};
			
				$(this).find('select,input').each(function(y) {
				
				data[i][y] = $(this).val();
				
				});
			
			});
			
			$.post('library/capsule/layan/layan.ajax.php', {data:data,control:'saveDokumen'}, function(result) {
				alert(result);
				if (result != 0) {
							
					$('.layan-processing-text').html('Done! Waiting to display the document..');
						
						setTimeout(function(){
										
						$('.layan-processing').fadeIn('slow', function() {
										
						$('.layan-processing').remove();
										
						$('body').html(result).hide().fadeIn('slow');
										
						});
																											
					});
				
				}
			
			});
			
			//$('body').html(html).hide().fadeIn('slow');
																									
		});
		
		*/
		
		$('.layan-dashboard-box-header-name-right-arrow-down').live('click', function() {
			
			$(this).parent().parent().find('.layan-dashboard-box-content').slideToggle('fast');
			
		});
		$('.layan-dashboard-box-header-set-delivered').live('click', function() {
						
			var id  = $(this).parent().find('input').val();

			var obj = $(this).parent().parent().parent();
			
			$( "#dialog:ui-dialog" ).dialog( "destroy" );
	
			$( "#dialog-confirm" ).dialog({
				resizable: false,
				minHeight:150,
				minWidth:500,
				modal: true,
				buttons: {
					"Yes": function() {

						
						$.post('library/capsule/layan/layan.ajax.php', {data:id, control:'setDelivered'}, function(result){
							if(result == ''){
								obj.remove();

							}
						});
						console.log(id);


						
						$(this).dialog( "close" );

					},
					Cancel: function() {
						$( this ).dialog( "close" );
					}
				}
			});

			
			
		});

		$('.layan-detailDokumen-pemberitahuan-button').live('click', function() {
		
			$.post('library/capsule/layan/layan.ajax.php', {control:'getFormPemberitahuan'}, function(data) {
				
				$('.layan-detailDokumen-container-header-form').html(data);
																
			});
		
		});
		
		$('.layan-detailDokumen-penolakan-button').live('click', function() {
			
			$.post('library/capsule/layan/layan.ajax.php', {control:'getFormPenolakan'}, function(data) {
				
				$('.layan-detailDokumen-container-header-form').html(data);
																
			});
		
		});
		
		$('.layan-detailDokumen-perpanjangan-button').live('click', function() {
		
			$.post('library/capsule/layan/layan.ajax.php', {control:'getFormPerpanjangan'}, function(data) {
				
				$('.layan-detailDokumen-container-header-form').html(data);
																
			});
		
		});
		
		$('.layan-detailDokumen-container-header-name-close').live('click', function() {
			
			if ($('.software-dashboard-right-container-inside:visible').length == 1) {
								
				$('.layan-detailDokumen-container').remove();
				
				$('.software-dashboard-right-container-inside').slideToggleWidth();
							
			}
			
		});
		
		/*
		$('.layan-dashboard-box-content a').live('click', function() {
		
		var name = $(this).parent().parent().parent().parent().find('.layan-dashboard-box-header-name-left').text();
		
		$('.software-dashboard-right-container').removeAttr('style');
		
			if ($('.software-dashboard-right-container-inside:visible').length == 0) {
								
				$('.software-dashboard-right-container-inside').slideToggleWidth();
				
				var id = $(this).attr('value');
			
			}
			else {
				
				var id = $(this).attr('value');
				
			}
		
		$('.software-dashboard-right-container-inside').html('Loading...');
		
		setTimeout(function(){
			
			$.post('library/capsule/layan/layan.ajax.php', {data:id,control:'getDokumen'}, function(data) {
				
				$('.software-dashboard-right-container-inside').html(data);
								
				$('.layan-detailDokumen-container-header-name').html("<div class='layan-detailDokumen-container-header-name-inside'>"+name+"</div><div class='layan-detailDokumen-container-header-name-close'></div>");
				
				$('.qtip-upper').qtip({
				content: {
				      attr: 'text' // Notice that content.text is long-hand for simply declaring content as a string
				   },
				position: {
				      my: 'bottom center',  // Position my top left...
				      at: 'top center' // at the bottom right of...
				   },
				style: {classes: 'ui-tooltip-dark ui-tooltip-shadow'}
				});
				
			});
			
		}, 500);
		
		return false;
		
		});
		*/
		/*
		$('.twitter-style-table tbody tr').live('click', function() {
		
		var id    = $(this).find('input[type="hidden"]').val();
		
		var check = $('.layan-document-'+id).length;
		
		var div   = $(this).find('div').length;
		
			if (check == 0 && div == 0) {
		
			$(this).after('<tr class="layan-document-'+id+'"><td style="border-right: 1px solid #000; border-bottom: 1px solid #000"><div class="layan-permohonan-save-button"></div></td><td colspan="3" class="layan-document-container"><div class="layan-document-container-div">asa</div></td></tr>');
							
			}
			else {
			
			$('.layan-document-'+id).remove();
			
			}
		
		});
		*/
		$('.layan-normal-form-container form .layan-normal-create-permohonan').live('click',function() {
				
		var pemohon = [];
		
		var dokumen = [];
		
			$('.layan-normal-table').find('input[type="text"],select,input[type="radio"]:checked').each(function(i) {
			
			pemohon[i] = {};
			pemohon[i] = $(this).val();
			
			});
		
			$('.layan-normal-table-multiple tr.layan-normal-table-tr-hover').each(function(x) {
						
			dokumen[x] = {};
			
				$(this).find('input[type="text"]').each(function(y) {
			
					dokumen[x][y] = $(this).val();
					
					});
			
			});
		
		var data = [pemohon,dokumen];
		
			$.post('library/capsule/layan/layan.ajax.php', {control:'loading'}, function(loading) {
				
				html = $('body').html();
								
				$('body').html(loading).hide().fadeIn('slow');
				
				$('.layan-processing').center();
				
				$('.layan-processing-progressbar').progressbar({value: 100});
				
				setTimeout(function(){
				
					$.post('library/capsule/layan/layan.ajax.php', {data:data,control:'permohonan'}, function(result) {

						var obj = $.parseJSON(result);

						if (obj.response == 1) {
							
							$('.layan-processing-text').html('Selesai! Membuka pratinjau permohonan..');
							
								setTimeout(function(){
								
								window.location = obj.url;
																					
							}, 1000);
																			
						}
						else {

							$('.layan-processing-text').html('Validasi gagal. Mohon cek ulang data anda..');
							
								setTimeout(function(){
								
								window.location = obj.url;
																					
							}, 1000);

						}
						/*
						else {
						
							$('.layan-processing-text').html('System error. We cannot process your document..');
							
								setTimeout(function(){
								
								$('.layan-processing').fadeIn('slow', function() {
								
								$('.layan-processing').remove();
								
								$('body').html(html).hide().fadeIn('slow');
								
								});
														
								}, 1000);
												
						}
						*/
						
					});
												
				},1500);
				
			});
		
		return false;
				
		});

	});
	
	$('.layan-permohonan-print-button').live('click', function() {
	
		$(this).parent().parent().find('.layan-permohonan-container').printElement({
		leaveOpen:true,
		printMode:'popup',
	    overrideElementCSS:['library/capsule/layan/css/print.css']
	
	    });
	
	});
	$('.layan-permohonan-print-button-ex').live('click', function() {
	
		$(this).parent().parent().find('.layan-permohonan-container-2').printElement({
		leaveOpen:true,
		printMode:'popup',
	    overrideElementCSS:['library/capsule/layan/css/print.css']
	
	    });
	
	});
	$('.layan-pemberitahuan-print-button').live('click', function() {
	
	
		$(this).parent().parent().find('.layan-pemberitahuan-container').printElement({
		leaveOpen:true,
		printMode:'popup',
	    overrideElementCSS:['library/capsule/layan/css/print.css']
	    });
	
	});
	
	$('.layan-permohonan-float-left-print-permohonan').live('click', function() {
	
	var id = $('.layan-normal-table').find('input[name="id"]').val();

		$.post('library/capsule/layan/layan.ajax.php', {control:'loading'}, function(loading) {
				
				html = $('body').html();

				$('body').html(loading).hide().fadeIn('slow');
				
				$('.layan-processing').center();
				
				$('.layan-processing-progressbar').progressbar({value: 100});
				
				setTimeout(function(){
				
					$.post('library/capsule/layan/layan.ajax.php', {data:id,control:'dokumen'}, function(result) {

						if (result != 0) {
							
							$('.layan-processing-text').html('Done! Waiting to display the document..');
							
								setTimeout(function(){
								
								$('.layan-processing').fadeIn('slow', function() {
								
								$('.layan-processing').remove();
								
								$('body').html(result).hide().fadeIn('slow');
								
								});
														
								}, 1000);
										
																			
						}
						else {
						
							$('.layan-processing-text').html('System error. We cannot process your document..');
							
								setTimeout(function(){
								
								$('.layan-processing').fadeIn('slow', function() {
								
								$('.layan-processing').remove();
								
								$('body').html(html).hide().fadeIn('slow');
								
									$('.qtip-upper').qtip({
										content: {
										attr: 'text' // Notice that content.text is long-hand for simply declaring content as a string
										},
										position: {
										my: 'bottom center',  // Position my top left...
										at: 'top center' // at the bottom right of...
										},
										style: {classes: 'ui-tooltip-dark ui-tooltip-shadow'}
									});
								
								});
											
								}, 1000);
												
							}
						
					});
												
				},1500);
			
		});
	
	});
	

	$('.layan-pemberitahuan-float-left-print-pemberitahuan').live('click', function() {
		//alert('asa');
		
		var id =[];

		 $('.layan-admin_pemberitahuan-ul').find('input[type="checkbox"]:checked').each(function(i){

		 	id[i] = $(this).val();

		 });
		 //console.log(id);
		if(id.length >= 1){
			$.post('library/capsule/layan/layan.ajax.php', {control:'loading'}, function(loading) {
					
					html = $('body').html();

					$('body').html(loading).hide().fadeIn('slow');
					
					$('.layan-processing').center();
					
					$('.layan-processing-progressbar').progressbar({value: 100});
					
					setTimeout(function(){
					
						$.post('library/capsule/layan/layan.ajax.php', {data:id,control:'printPemberitahuan'}, function(result) {

							if (result != 0) {
								
								$('.layan-processing-text').html('Done! Waiting to display the document..');
								
									setTimeout(function(){
									
									$('.layan-processing').fadeIn('slow', function() {
									
									$('.layan-processing').remove();
									
									$('body').html(result).hide().fadeIn('slow');
									
									});
															
									}, 1000);
											
																				
							}
							else {
							
								$('.layan-processing-text').html('System error. We cannot process your document..');
								
									setTimeout(function(){
									
									$('.layan-processing').fadeIn('slow', function() {
									
									$('.layan-processing').remove();
									
									$('body').html(html).hide().fadeIn('slow');
									
										$('.qtip-upper').qtip({
											content: {
											attr: 'text' // Notice that content.text is long-hand for simply declaring content as a string
											},
											position: {
											my: 'bottom center',  // Position my top left...
											at: 'top center' // at the bottom right of...
											},
											style: {classes: 'ui-tooltip-dark ui-tooltip-shadow'}
										});
									
									});
												
									}, 1000);
													
								}
							
						});
													
					},1500);
				
			});
		}
	});
	$('.layan-penolakan-float-left-print-penolakan').live('click', function() {
		//alert('asa');
		
		var id =[];

		 $('.layan-admin_pemberitahuan-ul').find('input[type="checkbox"]:checked').each(function(i){

		 	id[i] = $(this).val();

		 });
		 //console.log(id);
		if(id.length >= 1){
			$.post('library/capsule/layan/layan.ajax.php', {control:'loading'}, function(loading) {
					
					html = $('body').html();

					$('body').html(loading).hide().fadeIn('slow');
					
					$('.layan-processing').center();
					
					$('.layan-processing-progressbar').progressbar({value: 100});
					
					setTimeout(function(){
					
						$.post('library/capsule/layan/layan.ajax.php', {data:id,control:'printPenolakan'}, function(result) {

							if (result != 0) {
								
								$('.layan-processing-text').html('Done! Waiting to display the document..');
								
									setTimeout(function(){
									
									$('.layan-processing').fadeIn('slow', function() {
									
									$('.layan-processing').remove();
									
									$('body').html(result).hide().fadeIn('slow');
									
									});
															
									}, 1000);
											
																				
							}
							else {
							
								$('.layan-processing-text').html('System error. We cannot process your document..');
								
									setTimeout(function(){
									
									$('.layan-processing').fadeIn('slow', function() {
									
									$('.layan-processing').remove();
									
									$('body').html(html).hide().fadeIn('slow');
									
										$('.qtip-upper').qtip({
											content: {
											attr: 'text' // Notice that content.text is long-hand for simply declaring content as a string
											},
											position: {
											my: 'bottom center',  // Position my top left...
											at: 'top center' // at the bottom right of...
											},
											style: {classes: 'ui-tooltip-dark ui-tooltip-shadow'}
										});
									
									});
												
									}, 1000);
													
								}
							
						});
													
					},1500);
				
			});
		}
	});

	$('.layan-admin_perpanjangan-float-left-print-perpanjangan').live('click', function() {
		//alert('asa');
		
		var id =[];

		 $('.layan-admin_pemberitahuan-ul').find('input[type="checkbox"]:checked').each(function(i){

		 	id[i] = $(this).val();

		 });
		 //console.log(id);
		if(id.length >= 1){
			$.post('library/capsule/layan/layan.ajax.php', {control:'loading'}, function(loading) {
					
					html = $('body').html();

					$('body').html(loading).hide().fadeIn('slow');
					
					$('.layan-processing').center();
					
					$('.layan-processing-progressbar').progressbar({value: 100});
					
					setTimeout(function(){
					
						$.post('library/capsule/layan/layan.ajax.php', {data:id,control:'printPerpanjangan'}, function(result) {

							if (result != 0) {
								
								$('.layan-processing-text').html('Done! Waiting to display the document..');
								
									setTimeout(function(){
									
									$('.layan-processing').fadeIn('slow', function() {
									
									$('.layan-processing').remove();
									
									$('body').html(result).hide().fadeIn('slow');
									
									});
															
									}, 1000);
											
																				
							}
							else {
							
								$('.layan-processing-text').html('System error. We cannot process your document..');
								
									setTimeout(function(){
									
									$('.layan-processing').fadeIn('slow', function() {
									
									$('.layan-processing').remove();
									
									$('body').html(html).hide().fadeIn('slow');
									
										$('.qtip-upper').qtip({
											content: {
											attr: 'text' // Notice that content.text is long-hand for simply declaring content as a string
											},
											position: {
											my: 'bottom center',  // Position my top left...
											at: 'top center' // at the bottom right of...
											},
											style: {classes: 'ui-tooltip-dark ui-tooltip-shadow'}
										});
									
									});
												
									}, 1000);
													
								}
							
						});
													
					},1500);
				
			});
		}
	});
	
	
	
	$('.layan-pemberitahuan-float-left-print-keberatan').live('click', function() {
		//alert('asa');
		
		var id =[];

		 $('.layan-admin_pemberitahuan-ul').find('input[type="checkbox"]:checked').each(function(i){

		 	id[i] = $(this).val();

		 });
		 //console.log(id);
		if(id.length >= 1){
			$.post('library/capsule/layan/layan.ajax.php', {control:'loading'}, function(loading) {
					
					html = $('body').html();

					$('body').html(loading).hide().fadeIn('slow');
					
					$('.layan-processing').center();
					
					$('.layan-processing-progressbar').progressbar({value: 100});
					
					setTimeout(function(){
					
						$.post('library/capsule/layan/layan.ajax.php', {data:id,control:'printKeberatan'}, function(result) {

							if (result != 0) {
								
								$('.layan-processing-text').html('Done! Waiting to display the document..');
								
									setTimeout(function(){
									
									$('.layan-processing').fadeIn('slow', function() {
									
									$('.layan-processing').remove();
									
									$('body').html(result).hide().fadeIn('slow');
									
									});
															
									}, 1000);
											
																				
							}
							else {
							
								$('.layan-processing-text').html('System error. We cannot process your document..');
								
									setTimeout(function(){
									
									$('.layan-processing').fadeIn('slow', function() {
									
									$('.layan-processing').remove();
									
									$('body').html(html).hide().fadeIn('slow');
									
										$('.qtip-upper').qtip({
											content: {
											attr: 'text' // Notice that content.text is long-hand for simply declaring content as a string
											},
											position: {
											my: 'bottom center',  // Position my top left...
											at: 'top center' // at the bottom right of...
											},
											style: {classes: 'ui-tooltip-dark ui-tooltip-shadow'}
										});
									
									});
												
									}, 1000);
													
								}
							
						});
													
					},1500);
				
			});
		}
	});
	
	
	
	$('.layan-permohonan-float-left-edit-permohonan').live('click', function() {
	
	var ini = $(this).attr('text');
	
		$('.layan-normal-table, .layan-normal-table-multiple').each(function(i) {
		
			if (ini != 'Read Only Mode') {
		
				$(this).find('input,select,radio').removeAttr('disabled');
				
			}
			else {
				
				$(this).find('input,select,radio').attr('disabled','disabled');
				
			}
				
		});
		
			if (ini != 'Read Only Mode') {
		
				$('.layan-permohonan-update-container').fadeIn('slow');
		
				$(this).attr('text','Read Only Mode');
				
			}
			else {
				
				$('.layan-permohonan-update-container').fadeOut('slow');
		
				$(this).attr('text','Edit Mode');
				
			}
				
		$('.qtip-upper').qtip({
			content: {
			attr: 'text' // Notice that content.text is long-hand for simply declaring content as a string
			},
			position: {
			my: 'bottom center',  // Position my top left...
			at: 'top center' // at the bottom right of...
			},
			style: {classes: 'ui-tooltip-dark ui-tooltip-shadow'}
		});
	
	});
	
	var menuCheckerLayan = $('.software-dashboard-right-container-history-menu').length;
	
	
	$('.layan-admin_pemberitahuan_create-dokumen-biaya-form-input,.layan-admin_pemberitahuan_create-dokumen-biaya-form-input-lembar,.layan-admin_pemberitahuan_create-dokumen-biaya-form-input-harga').keyup(function() {
	
	var lmbr = $('.layan-admin_pemberitahuan_create-dokumen-biaya-form-input-lembar:visible').val(); //alert(lmbr)
	var hrga = $('.layan-admin_pemberitahuan_create-dokumen-biaya-form-input-harga:visible').val();
	var ttla = 0;
	
	$('.layan-admin_pemberitahuan_create-dokumen-biaya-form-input').each(function(i) {
	
		if ($(this).val() != '') {
	
			ttla += parseInt($(this).val());
		
		}
		
	});
		
		if (lmbr == '') {lmbr = 1;}
	
	var first = addCommas((hrga*lmbr)+ttla); 

	function addCommas(nStr) {
    nStr += '';
    var x = nStr.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
    }
	
	$('.layan-admin_pemberitahuan_create-dokumen-biaya-form-input-total').val(first);
	
	});
	
//var originalHeight = 0;
	
	$('.layan-admin_pemberitahuan_create-dokumen-tab-inside-canceled:visible').live('click', function() {

	var a = false;
	
		$('.layan-admin_pemberitahuan_create-dokumen-tab-inside-canceled:visible').each(function() {
		
			if ($(this).is(':checked') == true) {
				a = true;
			}
		
		});

		if (a == true) {
		
		r = $('.layan-admin_pemberitahuan_create-dokumen-tab-inside-middle:visible').height();

			if ($('.layan-admin_pemberitahuan_create-dokumen-tab-inside:visible .layan-original-height').val() == 0) {
		
				$('.layan-admin_pemberitahuan_create-dokumen-tab-inside:visible .layan-original-height').val(r);
		
			}
			
			$('.layan-admin_pemberitahuan_create-dokumen-tab-inside-middle:visible').addClass('layan-admin_pemberitahuan_create-activeState').animate({
			    opacity: 0.0,
			    height: 0
			}, 300, function() {
			   
			   $(this).find('input,select').attr('disabled','disabled');
			   			   
			});
		
		}
		else {
		
		var o = $('.layan-admin_pemberitahuan_create-dokumen-tab-inside:visible .layan-original-height').val();

			$('.layan-admin_pemberitahuan_create-dokumen-tab-inside-middle:visible').removeClass('layan-admin_pemberitahuan_create-activeState').animate({
			    opacity: 1,
			    height: o
			}, 300, function() {
			   
			   $(this).find('input,select').removeAttr('disabled');
			   			   			   
			});
			
			
		}
	
	});
	
	$('.layan-admin_pemberitahuan_create-dokumen ul li:first').addClass('layan-admin_pemberitahuan-dokumen-list-active');
	
	var firstID = $('.layan-admin_pemberitahuan_create-dokumen ul li:first').find('input[type="checkbox"]').val();
	
	$('.layan-admin_pemberitahuan_create-dokumen-tab-inside[document='+firstID+']').show();
	
	$('.layan-admin_pemberitahuan_create-dokumen-badan-publik-lain').click(function() {
	
		if ($(this).is(':checked') == true) {
		
			$(this).val($('.layan-admin_pemberitahuan_create-dokumen-biaya-form-input-border-bottom').val());
		
		}
		else {
		
			$(this).val('badan publik lain');
		
		}
	
	});
	
	$('.layan-admin_pemberitahuan_create-dokumen-badan-publik-lain-uu').click(function() {
	
		if ($(this).is(':checked') == true) {
			
			var value = "Pasal "+$(this).parent().find('.layan-admin_pemberitahuan_create-dokumen-biaya-form-input-border-bottom-keberatan-1').val()+"|Undang-Undang "+$(this).parent().find('.layan-admin_pemberitahuan_create-dokumen-biaya-form-input-border-bottom-keberatan-2').val();
			
			$(this).val(value);
		
		}
		else {
		
			$(this).val('');
		
		}
	
	});
	
	$('.layan-admin_pemberitahuan_create-dokumen-badan-publik-lain-uji').click(function() {
	
		if ($(this).is(':checked') == true) {
		
			$(this).val($('.layan-admin_pemberitahuan_create-dokumen-biaya-form-input-border-bottom-keberatan').val());
		
		}
		else {
		
			$(this).val('');
		
		}
	
	});
	
	$('.layan-admin_pemberitahuan_create-dokumen-tab-inside-top .layan-admin_pemberitahuan_create-dokumen-biaya-form-input-border-bottom').keyup(function() {
	
		var value = $(this).val();
		
		if ($(this).parent().find('input[type="checkbox"]').is(':checked') == true) {
		
		$(this).parent().find('input[type="checkbox"]').val(value);
		
		}
	
	});
	
	$('.layan-admin_pemberitahuan_create-dokumen-tab-inside-top .layan-admin_pemberitahuan_create-dokumen-biaya-form-input-border-bottom-keberatan').keyup(function() {
	
		var value = $(this).val();
		
		if ($(this).parent().find('input[type="checkbox"]').is(':checked') == true) {
		
		$(this).parent().find('input[type="checkbox"]').val(value);
		
		}
	
	});
	
	$('.layan-admin_pemberitahuan_create-dokumen-tab-inside-top .layan-admin_pemberitahuan_create-dokumen-biaya-form-input-border-bottom-keberatan-1, .layan-admin_pemberitahuan_create-dokumen-tab-inside-top .layan-admin_pemberitahuan_create-dokumen-biaya-form-input-border-bottom-keberatan-2').keyup(function() {
	
		var value = "Pasal "+$(this).parent().find('.layan-admin_pemberitahuan_create-dokumen-biaya-form-input-border-bottom-keberatan-1').val()+"|Undang-Undang "+$(this).parent().find('.layan-admin_pemberitahuan_create-dokumen-biaya-form-input-border-bottom-keberatan-2').val();
		
		if ($(this).parent().find('input[type="checkbox"]').is(':checked') == true) {
		
		$(this).parent().find('input[type="checkbox"]').val(value);
		
		}
	
	});
	
if (menuCheckerLayan == 1) {
	
	$.urlParam = function(name){
    var results = new RegExp('[\\&]' + name + '=([^&#]*)').exec(window.location.href);
    
    	if (results == undefined) {
    	
    	return null;
    	
    	}
    	else {
	    
	    return results[1] || 0;
	    
	    }
    }
    var drillDown = $('.layan-drill-down-menu').val();

    	if ($('.layan-drill-down-menu').length == 1) {
	    	
	    	$('.software-dashboard-right-container-history-menu li a[href="?id='+drillDown+'"]').addClass('menu-active-primary');
	    	
    	}
    	else {
    	
		$('.software-dashboard-right-container-history-menu li a[href="?id='+$.urlParam('id')+'"]').addClass('menu-active-primary');
		
		}
	
		$('.software-dashboard-right-container-history-menu li a').each(function(i) {
		
			var href = $(this).attr('href');
			
			$(this).attr('href',href+"&ref="+$.urlParam('ref'));
		
		});
	
	}
	
	$('.layan-admin_pemberitahuan-dokumen-list').live('click', function() {
		
		var id = $(this).find('input[type="checkbox"]').val();
		
		$('.layan-admin_pemberitahuan-dokumen-list').removeClass('layan-admin_pemberitahuan-dokumen-list-active');
		
		$(this).toggleClass('layan-admin_pemberitahuan-dokumen-list-active');

		$('.layan-admin_pemberitahuan_create-dokumen-tab-inside').hide();
		
		$('.layan-admin_pemberitahuan_create-dokumen-tab-inside[document='+id+']').show();
	
	});

	$('#layan-keberatan-create').submit(function() {

	var numbers = $('.layan-admin_pemberitahuan-dokumen-list input[type="checkbox"]:checked').length;
		
		if (numbers == 0) {
			
			alert('Mohon centang dokumen yang akan dimasukan ke dalam permintaan tertulis ini');
			
			return false;
		}
		
	var x = confirm('Anda akan memasukan dokumen sebanyak '+numbers+'?');
			
		if (x != true) {
		
			return false;
			
		}

		$('.layan-admin_pemberitahuan-dokumen-list input[type="checkbox"]').not(':checked').each(function() {

			$('.layan-admin_pemberitahuan_create-dokumen-tab-inside[document="'+$(this).val()+'"]').remove();

		});

		$('.layan-admin_pemberitahuan-dokumen-list input[type="checkbox"]').not(':checked').parent().remove();

	});

	$('#layan-permintaan-create .layan-normal-create-perpanjangan').click(function() {

	var numbers = $('.layan-admin_pemberitahuan-dokumen-list input[type="checkbox"]:checked').length;
		
		if (numbers == 0) {
			
			alert('Mohon centang dokumen yang akan dimasukan ke dalam permintaan tertulis ini');
			
			return false;
		}
		
	var x = confirm('Anda akan memasukan dokumen sebanyak '+numbers+'?');
			
		if (x != true) {
		
			return false;
			
		}

		$('.layan-admin_pemberitahuan-dokumen-list input[type="checkbox"]').not(':checked').each(function() {

			$('.layan-admin_pemberitahuan_create-dokumen-tab-inside[document="'+$(this).val()+'"]').remove();

		});

		$('.layan-admin_pemberitahuan-dokumen-list input[type="checkbox"]').not(':checked').parent().remove();

	});

	$('#layan-permintaan-create .layan-normal-create-pemberitahuan').click(function() {

	var numbers = $('.layan-admin_pemberitahuan-dokumen-list input[type="checkbox"]:checked').length;
		
		if (numbers == 0) {
			
			alert('Mohon centang dokumen yang akan dimasukan ke dalam permintaan tertulis ini');
			
			return false;
		}
		
	var x = confirm('Anda akan memasukan dokumen sebanyak '+numbers+'?');
			
		if (x != true) {
		
			return false;
			
		}
		
		var data = [];
						
		$('.layan-admin_pemberitahuan-dokumen-list input[type="checkbox"]:checked').each(function(i) {
		
			data [i] = {};
			data [i]['id'] = $('div[document="'+$(this).val()+'"]').find('input[name*="dokumen-order"]').val();
			data [i]['pages'] = $(this).val();
		
		});
		
		  $.post('library/capsule/layan/layan.ajax.php', {data:data,control:'checkOrderNumber'}, function(result) {
					
				var obj = $.parseJSON(result);
									  
					  if (obj.fault != 'pass') {
						  
						  $('.layan-error-annoucement').show().html(obj.fault);
						  						  						  						  						  
					  }
					  else {
						  
						  $('.layan-admin_pemberitahuan-dokumen-list input[type="checkbox"]').not(':checked').each(function() {
		
							var firstID = $(this).val();
							
							$('.layan-admin_pemberitahuan_create-dokumen-tab-inside[document='+firstID+']').remove();
							
							$(this).parent().remove();
																				
						});	
						
						$('#layan-permintaan-create').submit();
						  
					  }
					
				
			});
			
	});
	

	$('.layan-admin_pemberitahuan-float-left-delete-permohonan').live('click', function() {

		var length = $('.layan-admin_pemberitahuan-ul li input[type="checkbox"]:checked').length;

		if (length == 0) {
			alert('Mohon pilih pemberitahuan tertulis yang akan anda proses');
			return false;
		}
		else if (length > 1) {
			alert('Mohon pilih satu pemberitahuan tertulis yang akan anda proses')
			return false;
		} 
		else {
			var id = $('.layan-admin_pemberitahuan-ul li input[type="checkbox"]:checked').val();
		}

	})

	$('.layan-admin_perpanjangan_create-dokumen-biaya-form-input-full').keyup(function() {

		if ($(this).val() == '') {
			$('.layan-admin_perpanjangan_create-dokumen-biaya-form-input-full').val('');
		}
		else {
			$('.layan-admin_perpanjangan_create-dokumen-biaya-form-input-full:hidden').attr('value',$(this).val());
		}

	})

	$('.layan-admin_perpanjangan_create-dokumen-biaya-form-input-full-kuasa-pemohon').keyup(function() {

		if ($(this).val() == '') {
			$('.layan-admin_perpanjangan_create-dokumen-biaya-form-input-full-kuasa-pemohon').val('');
		}
		else {
			$('.layan-admin_perpanjangan_create-dokumen-biaya-form-input-full-kuasa-pemohon:hidden').attr('value',$(this).val());
		}

	});

	$('.layan-admin_perpanjangan_create-dokumen-biaya-form-input-full-alamat-pemohon').keyup(function() {

		if ($(this).val() == '') {
			$('.layan-admin_perpanjangan_create-dokumen-biaya-form-input-full-alamat-pemohon').val('');
		}
		else {
			$('.layan-admin_perpanjangan_create-dokumen-biaya-form-input-full-alamat-pemohon:hidden').attr('value',$(this).val());
		}

	});
	
	$('.layan-keberatan-select-finish').change(function() {
		
		$('.layan-keberatan-select-finish').val($(this).val());

	})

	jQuery(function($){
	$.datepicker.regional['id'] = {
		closeText: 'Tutup',
		prevText: '&#x3c;mundur',
		nextText: 'maju&#x3e;',
		currentText: 'hari ini',
		monthNames: ['Januari','Februari','Maret','April','Mei','Juni',
		'Juli','Agustus','September','Oktober','Nopember','Desember'],
		monthNamesShort: ['Jan','Feb','Mar','Apr','Mei','Jun',
		'Jul','Agus','Sep','Okt','Nop','Des'],
		dayNames: ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'],
		dayNamesShort: ['Min','Sen','Sel','Rab','kam','Jum','Sab'],
		dayNamesMin: ['Mg','Sn','Sl','Rb','Km','jm','Sb'],
		weekHeader: 'Mg',
		dateFormat: 'dd/mm/yy',
		firstDay: 0,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['id']);
	
	
	});
	
	$('.datepickerSetting').datepicker({
        changeMonth: true,
        changeYear: false,
        numberOfMonths: 1,
        showOtherMonths: true,
		selectOtherMonths: true,
        dateFormat: 'dd-mm-yy'
    });

	$('.layan-setting-plus-button').live('click',function() {
			
			var row = $(this).parent().parent().html();
			
			$(this).parent().parent().after("<tr class='layan-normal-table-tr-hover' last='yes'>"+row+"</tr>");
			
			$('.layan-normal-table-tr-hover[last="yes"] input').val('');
			
			$('.layan-normal-table-tr-hover[last="yes"] .datepickerSetting').removeAttr('id').removeClass('hasDatepicker');
						
			$('.layan-normal-table-tr-hover[last="yes"] .datepickerSetting').datepicker({
	        changeMonth: true,
	        changeYear: false,
	        numberOfMonths: 1,
	        showOtherMonths: true,
			selectOtherMonths: true,
	        dateFormat: 'dd-mm-yy'
	        });
			
			$('.layan-normal-table-tr-hover[last="yes"]').removeAttr('last');
					
	});
		
	$('.layan-setting-minus-button').live('click',function() {
			
		if ($('.layan-permohonan-float-left-edit-permohonan').length == 1 && $('.layan-permohonan-float-left-edit-permohonan').attr('text') == "Edit Mode") {
			alert("Mohon masuk ke dalam mode 'Edit' untuk merubah data ini");
			return false;
		}
			
		var count = $('.layan-normal-minus-button').length;

			if (count != 1) { 
								
				var id  = $('.layan-permohonan-dokumen-delete').val();

				var cur = $(this).parent().find('input[name="idDokumen[]"]').val();
					
					if (cur != '' && cur != undefined) {
					
						$('.layan-permohonan-dokumen-delete').val(id+cur+",");
							
					}
					
				$(this).parent().parent().remove();
					
			}
			else {
					
				var id  = $('.layan-permohonan-dokumen-delete').val();

				var cur = $(this).parent().find('input[name="idDokumen[]"]').val();
					
					if (cur != '' && cur != undefined) {
					
						$('.layan-permohonan-dokumen-delete').val(id+cur+",");
							
					}
					
				$(this).parent().parent().find('input').val('');
					
			}
		
		});

	$('.layan-admin_pemberitahuan-delete-document-front').live('click', function() {

		var conf = confirm('Anda yakin akan menghapus dokumen ini?');

			if (conf != true) {
				return false;
			}
		
		var thisis = $(this);

		$.post('library/capsule/layan/layan.ajax.php', {data:$(this).attr('rel'),control:'deletePemberitahuanDokumen'}, function(result) {

			if (result == '') {
				$(thisis).parent().fadeOut('fast',function() {
					$(this).remove();
				});
			}
			
		});

	})

	$('.layan-admin_perpanjangan-delete-document-front').live('click', function() {

		var conf = confirm('Anda yakin akan menghapus dokumen ini?');

			if (conf != true) {
				return false;
			}

		var thisis = $(this);

		$.post('library/capsule/layan/layan.ajax.php', {data:$(this).attr('rel'),control:'deletePerpanjanganDokumen'}, function(result) {
			
			if (result == '') {
				$(thisis).parent().fadeOut('fast',function() {
					$(this).remove();
				});
			}
			
		});

	})

	$('.layan-admin_penolakan-delete-document-front').live('click', function() {

		var conf = confirm('Anda yakin akan menghapus dokumen ini?');

			if (conf != true) {
				return false;
			}

		var thisis = $(this);

		$.post('library/capsule/layan/layan.ajax.php', {data:$(this).attr('rel'),control:'deletePenolakanDokumen'}, function(result) {
			
			if (result == '') {
				$(thisis).parent().fadeOut('fast',function() {
					$(this).remove();
				});
			}
			
		});

	})

	$('.layan-admin_keberatan-delete-document-front').live('click', function() {

		var conf = confirm('Anda yakin akan menghapus dokumen ini?');

			if (conf != true) {
				return false;
			}

		var thisis = $(this);

		$.post('library/capsule/layan/layan.ajax.php', {data:$(this).attr('rel'),control:'deleteKeberatanDokumen'}, function(result) {

			if (result == '') {
				$(thisis).parent().fadeOut('fast',function() {
					$(this).remove();
				});
			}
			
		});

	})

var layanLastValue = '';

	$('.layan-admin_pemberitahuan-float-left-edit-permohonan').live('click', function() {
		
		var qty = $('.layan-admin_pemberitahuan-ul li input[type="checkbox"]:checked').length;

			if (qty == 0) {return false;}

			if (qty > 1) {
				alert('Mohon pilih satu dokumen yang akan di edit');
				return false;
			}
			else {
				var parentID = $(this).parent().attr('href');
				var value = $.base64.encode($('.layan-admin_pemberitahuan-ul li input[type="checkbox"]:checked').val());
				var combine = parentID+'&reg='+value;

					if (value != layanLastValue) {

					layanLastValue = value;

					$(this).parent().attr('href',""+combine+"");


					}

			}

	})

	$('.layan-admin_pemberitahuan-float-left-print-permohonan').live('click',function() {

	var id = [];
	var control = '';

		if ($('.layan-admin_pemberitahuan-ul li input[type="checkbox"]:checked').length == 0) {return false;}

		var check = confirm('Anda yakin akan menghapus '+$('.layan-admin_pemberitahuan-ul li input[type="checkbox"]:checked').length+' dokumen?');

			if (check == false) {return false;}

		if ($(this).parent().attr('rel') == 'pemberitahuan') {control = 'deletePemberitahuanDokumenMaster';}
		else if ($(this).parent().attr('rel') == 'penolakan') {control = 'deletePenolakanDokumenMaster';}
		else if ($(this).parent().attr('rel') == 'perpanjangan') {control = 'deletePerpanjanganDokumenMaster';}
		else if ($(this).parent().attr('rel') == 'keberatan') {control = 'deleteKeberatanDokumenMaster';}

		$('.layan-admin_pemberitahuan-ul li input[type="checkbox"]:checked').each(function(i) {

			id[i] = $(this).val();
			$(this).parent().attr('rel','delete');

		})

		$.post('library/capsule/layan/layan.ajax.php', {data:id,control:control}, function(result) {

			if (result == '') {
				
				$('.layan-admin_pemberitahuan-ul li[rel="delete"]').fadeOut('fast',function() {
				$(this).remove();
				})	

			}
			
		});

	})

	$('.layan-admin_attachment-inside-delete-icon').live('click',function() {

	var data = $(this).parent().attr('rel');

	var ori = $(this);

	var confirmation = confirm("Anda yakin mau menghapus file ini?");

		if (!confirmation) {
			return false;
		}

		$.post('library/capsule/layan/layan.ajax.php', {data:data,control:'deleteAttachment'}, function(result) {

			if (result != 'Failed') {

				$(ori).parent().find('.layan-admin_attachment-inside-exist img').remove();

				$(ori).parent().find('.layan-admin_attachment-inside-exist').removeClass('layan-admin_attachment-inside-exist').addClass('layan-admin_attachment-inside');

				$(ori).parent().find('.layan-admin_attachment-inside').html(result);

				$(ori).parent().find('layan-admin_attachment-inside-hidden').remove();

				$(ori).hide();

			}

		});

	});

$(function(){

var $foo;
var $ktp;
var $akta;
var $kuasa;
var $ktpKuasa;
var $npwp;
var layanLastValue = '';
var layanActiveTransfer = '';

$.urlParam = function(name){
var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);
return results[1] || 0;
}

	function file_get_ext(filename) {
	return typeof filename != "undefined" ? filename.substring(filename.lastIndexOf(".")+1, filename.length).toLowerCase() : false;
	}

	$('.layan-admin_attachment-foto-container').upchunk({
	    fallback_id: 'upload_button',    // an identifier of a standard file input element
	    url: 'library/capsule/layan/layan.ajax.php',              // upload handler, handles each file separately
	    paramname: 'file',          // POST parameter name used on serverside to reference file
	    data: {
	        control: 'upload',
	        rel: function(){
            	 return layanLastValue; // calculate data at time of upload
       			 },
       		ref: function(){
            	 return $.urlParam('ref'); // calculate data at time of upload
       			 },
	                // send POST variables
	        
	    },
	    headers: {          // Send additional request headers
	        'header': 'value'
	    },
	    error: function(err, file) {
	        switch(err) {
	            case 'BrowserNotSupported':
	                alert('browser does not support html5 drag and drop')
	                break;
	            case 'TooManyFiles':
	                // user uploaded more than 'maxfiles'
	                break;
	            case 'FileTooLarge':
	                // program encountered a file whose size is greater than 'maxfilesize'
	                // FileTooLarge also has access to the file which was too large
	                // use file.name to reference the filename of the culprit file
	                alert(file.name+' filesize is too large')
	                break;
	            case 'FileTypeNotAllowed':
	            	alert('File type not allowed')
	            	break;
	            default:
	                break;
	        }
	    },
	    allowedfiletypes: ['image/jpg','image/jpeg','image/png','image/gif','application/pdf','audio/mp3'],    // filetypes allowed by Content-Type.  Empty array means no restrictions
	    queue_size: 1,
	    max_file_size: 20,    // max file size in MBs
	    dragOver: function(dom) {
	        // user dragging files over #dropzone
	        $(dom).prop('currentTarget').setAttribute("class","layan-admin_attachment-foto-container layan-admin_attachment-hover");
	    },
	    dragLeave: function(dom) {
	        // user dragging files out of #dropzone
	        $(dom).prop('currentTarget').setAttribute("class","layan-admin_attachment-foto-container");
	    },
	    drop: function(dom) {
	    	$foo = $(dom);
			layanLastValue = $foo.prop('currentTarget').getAttribute("rel");
			layanActiveTransfer = $foo.prop('currentTarget').getAttribute("title");
	    },
	    uploadStarted: function(i, file, len){
	        // a file began uploading
	        // i = index => 0, 1, 2, 3, 4 etc
	        // file is the actual file of the index
	        // len = total files user dropped
	        //console.log(i);
	    },
	    uploadFinished: function(i, file, response, time) {
	        // response is the data you got back from server in JSON format.
	        //console.log(response);
	        if (response == 'success') {
	        	$($foo.prop('currentTarget')).find('.layan-admin_attachment-progressBar,.layan-admin_attachment-progressBar-exist').text('Success');

	        	var check = $($foo.prop('currentTarget')).find('.layan-admin_attachment-inside-exist').length;

		        	if (check == 1) {

		        	var last = $($foo.prop('currentTarget')).find('.layan-admin_attachment-inside-exist').html();
		        	$($foo.prop('currentTarget')).find('.layan-admin_attachment-inside-exist').html(last);

		        	}
		        	else {

		        	var last = $($foo.prop('currentTarget')).find('.layan-admin_attachment-inside-hidden').html();
		        	$($foo.prop('currentTarget')).find('.layan-admin_attachment-inside').html(last);
		        	$($foo.prop('currentTarget')).find('.layan-admin_attachment-inside').addClass('layan-admin_attachment-inside-exist').removeClass('layan-admin_attachment-inside');
		        	$($foo.prop('currentTarget')).find('.layan-admin_attachment-inside-delete-icon').removeAttr('style');

		        	}

	        	var locate = $($foo.prop('currentTarget')).attr('title');

	        	setTimeout(function(){

	        		$('.layan-admin_attachment-progressBar[rel="'+locate+'"],.layan-admin_attachment-progressBar-exist[rel="'+locate+'"]').text('');

	        	}, 1000);
				
	        }

	    $($foo.prop('currentTarget')).removeClass('layan-admin_attachment-hover');

	    },
	    progressUpdated: function(file, i, progress) {
	        // this function is used for large files and updates intermittently
	        // progress is the integer value of file being uploaded percentage to completion
	        //console.log($(event));
	        var locate = '';
	       	layanActiveTransfer = $foo.prop('currentTarget').getAttribute("title");
			locate = $foo;

				if (file.type == 'image/jpeg' || file.type == 'application/pdf') {

	        	$('.layan-admin_attachment-progressBar[rel="'+$(locate.prop('currentTarget')).attr('title')+'"],.layan-admin_attachment-progressBar-exist[rel="'+$(locate.prop('currentTarget')).attr('title')+'"]').text(progress);

	        	}

	    },
	    beforeEach: function(file) {

	        	if (file.type != 'image/jpeg' && file.type != 'application/pdf') {

	        		alert('Hanya file PDF dan JPEG yang diperbolehkan');

	        		return false;

	        	}

	    }

	});

	$('.layan-admin_attachment-ktp-container').upchunk({
	    fallback_id: 'upload_button',    // an identifier of a standard file input element
	    url: 'library/capsule/layan/layan.ajax.php',              // upload handler, handles each file separately
	    paramname: 'file',          // POST parameter name used on serverside to reference file
	    data: {
	        control: 'upload',
	        rel: function(){
            	 return layanLastValue; // calculate data at time of upload
       			 },
       		ref: function(){
            	 return $.urlParam('ref'); // calculate data at time of upload
       			 },
	                // send POST variables
	        
	    },
	    headers: {          // Send additional request headers
	        'header': 'value'
	    },
	    error: function(err, file) {
	        switch(err) {
	            case 'BrowserNotSupported':
	                alert('browser does not support html5 drag and drop')
	                break;
	            case 'TooManyFiles':
	                // user uploaded more than 'maxfiles'
	                break;
	            case 'FileTooLarge':
	                // program encountered a file whose size is greater than 'maxfilesize'
	                // FileTooLarge also has access to the file which was too large
	                // use file.name to reference the filename of the culprit file
	                alert(file.name+' filesize is too large')
	                break;
	            case 'FileTypeNotAllowed':
	            	alert('File type not allowed')
	            	break;
	            default:
	                break;
	        }
	    },
	    allowedfiletypes: ['image/jpg','image/jpeg','image/png','image/gif','application/pdf','audio/mp3'],    // filetypes allowed by Content-Type.  Empty array means no restrictions
	    maxfiles: 1,
	    maxfilesize: 20,    // max file size in MBs
	    dragOver: function(dom) {
	        // user dragging files over #dropzone
	        $(dom).prop('currentTarget').setAttribute("class","layan-admin_attachment-foto-container layan-admin_attachment-hover");
	    },
	    dragLeave: function(dom) {
	        // user dragging files out of #dropzone
	        $(dom).prop('currentTarget').setAttribute("class","layan-admin_attachment-foto-container");
	    },
	    drop: function(dom) {
	    	$ktp = $(dom);
			layanLastValue = $ktp.prop('currentTarget').getAttribute("rel");
			layanActiveTransfer = $ktp.prop('currentTarget').getAttribute("title");
	    },
	    uploadStarted: function(i, file, len){
	        // a file began uploading
	        // i = index => 0, 1, 2, 3, 4 etc
	        // file is the actual file of the index
	        // len = total files user dropped
	    },
	    uploadFinished: function(i, file, response, time) {
	        // response is the data you got back from server in JSON format.
	        //console.log(response);
	        if (response == 'success') {
	        	$($ktp.prop('currentTarget')).find('.layan-admin_attachment-progressBar,.layan-admin_attachment-progressBar-exist').text('Success');

	        	var check = $($ktp.prop('currentTarget')).find('.layan-admin_attachment-inside-exist').length;

		        	if (check == 1) {

		        	var last = $($ktp.prop('currentTarget')).find('.layan-admin_attachment-inside-exist').html();
		        	$($ktp.prop('currentTarget')).find('.layan-admin_attachment-inside-exist').html(last);

		        	}
		        	else {

		        	var last = $($ktp.prop('currentTarget')).find('.layan-admin_attachment-inside-hidden').html();
		        	$($ktp.prop('currentTarget')).find('.layan-admin_attachment-inside').html(last);
		        	$($ktp.prop('currentTarget')).find('.layan-admin_attachment-inside').addClass('layan-admin_attachment-inside-exist').removeClass('layan-admin_attachment-inside');
		        	$($ktp.prop('currentTarget')).find('.layan-admin_attachment-inside-delete-icon').removeAttr('style');

		        	}

	        	var locate = $($ktp.prop('currentTarget')).attr('title');

	        	setTimeout(function(){

	        		$('.layan-admin_attachment-progressBar[rel="'+locate+'"],.layan-admin_attachment-progressBar-exist[rel="'+locate+'"]').text('');

	        	}, 1000);
				
	        }

	    $($ktp.prop('currentTarget')).removeClass('layan-admin_attachment-hover');

	    },
	    progressUpdated: function(file, i, progress) {
	        // this function is used for large files and updates intermittently
	        // progress is the integer value of file being uploaded percentage to completion
	        //console.log($(event));
	        var locate = '';
	       	layanActiveTransfer = $ktp.prop('currentTarget').getAttribute("title");
			locate = $ktp;

				if (file.type == 'image/jpeg' || file.type == 'application/pdf') {

	        	$('.layan-admin_attachment-progressBar[rel="'+$(locate.prop('currentTarget')).attr('title')+'"],.layan-admin_attachment-progressBar-exist[rel="'+$(locate.prop('currentTarget')).attr('title')+'"]').text(progress);

	        	}

	    },
	    beforeEach: function(file) {

	        	if (file.type != 'image/jpeg' && file.type != 'application/pdf') {

	        		alert('Hanya file PDF dan JPEG yang diperbolehkan');

	        		return false;

	        	}

	    }

	});

	$('.layan-admin_attachment-akta-container').upchunk({
	    fallback_id: 'upload_button',    // an identifier of a standard file input element
	    url: 'library/capsule/layan/layan.ajax.php',              // upload handler, handles each file separately
	    paramname: 'file',          // POST parameter name used on serverside to reference file
	    data: {
	        control: 'upload',
	        rel: function(){
            	 return layanLastValue; // calculate data at time of upload
       			 },
       		ref: function(){
            	 return $.urlParam('ref'); // calculate data at time of upload
       			 },
	                // send POST variables
	        
	    },
	    headers: {          // Send additional request headers
	        'header': 'value'
	    },
	    error: function(err, file) {
	        switch(err) {
	            case 'BrowserNotSupported':
	                alert('browser does not support html5 drag and drop')
	                break;
	            case 'TooManyFiles':
	                // user uploaded more than 'maxfiles'
	                break;
	            case 'FileTooLarge':
	                // program encountered a file whose size is greater than 'maxfilesize'
	                // FileTooLarge also has access to the file which was too large
	                // use file.name to reference the filename of the culprit file
	                alert(file.name+' filesize is too large')
	                break;
	            case 'FileTypeNotAllowed':
	            	alert('File type not allowed')
	            	break;
	            default:
	                break;
	        }
	    },
	    allowedfiletypes: ['image/jpg','image/jpeg','image/png','image/gif','application/pdf','audio/mp3'],    // filetypes allowed by Content-Type.  Empty array means no restrictions
	    maxfiles: 1,
	    maxfilesize: 20,    // max file size in MBs
	    dragOver: function(dom) {
	        // user dragging files over #dropzone
	        $(dom).prop('currentTarget').setAttribute("class","layan-admin_attachment-foto-container layan-admin_attachment-hover");
	    },
	    dragLeave: function(dom) {
	        // user dragging files out of #dropzone
	        $(dom).prop('currentTarget').setAttribute("class","layan-admin_attachment-foto-container");
	    },
	    drop: function(dom) {
	    	$akta = $(dom);
			layanLastValue = $akta.prop('currentTarget').getAttribute("rel");
			layanActiveTransfer = $akta.prop('currentTarget').getAttribute("title");
	    },
	    uploadStarted: function(i, file, len){
	        // a file began uploading
	        // i = index => 0, 1, 2, 3, 4 etc
	        // file is the actual file of the index
	        // len = total files user dropped
	    },
	    uploadFinished: function(i, file, response, time) {
	        // response is the data you got back from server in JSON format.
	        //console.log(response);
	        if (response == 'success') {
	        	$($akta.prop('currentTarget')).find('.layan-admin_attachment-progressBar,.layan-admin_attachment-progressBar-exist').text('Success');

	        	var check = $($akta.prop('currentTarget')).find('.layan-admin_attachment-inside-exist').length;

		        	if (check == 1) {

		        	var last = $($akta.prop('currentTarget')).find('.layan-admin_attachment-inside-exist').html();
		        	$($akta.prop('currentTarget')).find('.layan-admin_attachment-inside-exist').html(last);

		        	}
		        	else {

		        	var last = $($akta.prop('currentTarget')).find('.layan-admin_attachment-inside-hidden').html();
		        	$($akta.prop('currentTarget')).find('.layan-admin_attachment-inside').html(last);
		        	$($akta.prop('currentTarget')).find('.layan-admin_attachment-inside').addClass('layan-admin_attachment-inside-exist').removeClass('layan-admin_attachment-inside');
		        	$($akta.prop('currentTarget')).find('.layan-admin_attachment-inside-delete-icon').removeAttr('style');

		        	}

	        	var locate = $($akta.prop('currentTarget')).attr('title');

	        	setTimeout(function(){

	        		$('.layan-admin_attachment-progressBar[rel="'+locate+'"],.layan-admin_attachment-progressBar-exist[rel="'+locate+'"]').text('');

	        	}, 1000);
				
	        }

	    $($akta.prop('currentTarget')).removeClass('layan-admin_attachment-hover');

	    },
	    progressUpdated: function(file, i, progress) {
	        // this function is used for large files and updates intermittently
	        // progress is the integer value of file being uploaded percentage to completion
	        //console.log($(event));
	        var locate = '';
	       	layanActiveTransfer = $akta.prop('currentTarget').getAttribute("title");
			locate = $akta;
			if (file.type == 'image/jpeg' || file.type == 'application/pdf') {

	        	$('.layan-admin_attachment-progressBar[rel="'+$(locate.prop('currentTarget')).attr('title')+'"],.layan-admin_attachment-progressBar-exist[rel="'+$(locate.prop('currentTarget')).attr('title')+'"]').text(progress);

	        	}

	    },
	    beforeEach: function(file) {

	        	if (file.type != 'image/jpeg' && file.type != 'application/pdf') {

	        		alert('Hanya file PDF dan JPEG yang diperbolehkan');

	        		return false;

	        	}

	    }

	});

	$('.layan-admin_attachment-kuasa-container').upchunk({
	    fallback_id: 'upload_button',    // an identifier of a standard file input element
	    url: 'library/capsule/layan/layan.ajax.php',              // upload handler, handles each file separately
	    paramname: 'file',          // POST parameter name used on serverside to reference file
	    data: {
	        control: 'upload',
	        rel: function(){
            	 return layanLastValue; // calculate data at time of upload
       			 },
       		ref: function(){
            	 return $.urlParam('ref'); // calculate data at time of upload
       			 },
	                // send POST variables
	        
	    },
	    headers: {          // Send additional request headers
	        'header': 'value'
	    },
	    error: function(err, file) {
	        switch(err) {
	            case 'BrowserNotSupported':
	                alert('browser does not support html5 drag and drop')
	                break;
	            case 'TooManyFiles':
	                // user uploaded more than 'maxfiles'
	                break;
	            case 'FileTooLarge':
	                // program encountered a file whose size is greater than 'maxfilesize'
	                // FileTooLarge also has access to the file which was too large
	                // use file.name to reference the filename of the culprit file
	                alert(file.name+' filesize is too large')
	                break;
	            case 'FileTypeNotAllowed':
	            	alert('File type not allowed')
	            	break;
	            default:
	                break;
	        }
	    },
	    allowedfiletypes: ['image/jpg','image/jpeg','image/png','image/gif','application/pdf','audio/mp3'],    // filetypes allowed by Content-Type.  Empty array means no restrictions
	    maxfiles: 1,
	    maxfilesize: 20,    // max file size in MBs
	    dragOver: function(dom) {
	        // user dragging files over #dropzone
	        $(dom).prop('currentTarget').setAttribute("class","layan-admin_attachment-foto-container layan-admin_attachment-hover");
	    },
	    dragLeave: function(dom) {
	        // user dragging files out of #dropzone
	        $(dom).prop('currentTarget').setAttribute("class","layan-admin_attachment-foto-container");
	    },
	    drop: function(dom) {
	    	$kuasa = $(dom);
			layanLastValue = $kuasa.prop('currentTarget').getAttribute("rel");
			layanActiveTransfer = $kuasa.prop('currentTarget').getAttribute("title");
	    },
	    uploadStarted: function(i, file, len){
	        // a file began uploading
	        // i = index => 0, 1, 2, 3, 4 etc
	        // file is the actual file of the index
	        // len = total files user dropped
	    },
	     uploadFinished: function(i, file, response, time) {
	        // response is the data you got back from server in JSON format.
	        //console.log(response);
	        if (response == 'success') {
	        	$($kuasa.prop('currentTarget')).find('.layan-admin_attachment-progressBar,.layan-admin_attachment-progressBar-exist').text('Success');

	        	var check = $($kuasa.prop('currentTarget')).find('.layan-admin_attachment-inside-exist').length;

		        	if (check == 1) {

		        	var last = $($kuasa.prop('currentTarget')).find('.layan-admin_attachment-inside-exist').html();
		        	$($kuasa.prop('currentTarget')).find('.layan-admin_attachment-inside-exist').html(last);

		        	}
		        	else {

		        	var last = $($kuasa.prop('currentTarget')).find('.layan-admin_attachment-inside-hidden').html();
		        	$($kuasa.prop('currentTarget')).find('.layan-admin_attachment-inside').html(last);
		        	$($kuasa.prop('currentTarget')).find('.layan-admin_attachment-inside').addClass('layan-admin_attachment-inside-exist').removeClass('layan-admin_attachment-inside');
		        	$($kuasa.prop('currentTarget')).find('.layan-admin_attachment-inside-delete-icon').removeAttr('style');

		        	}

	        	var locate = $($kuasa.prop('currentTarget')).attr('title');

	        	setTimeout(function(){

	        		$('.layan-admin_attachment-progressBar[rel="'+locate+'"],.layan-admin_attachment-progressBar-exist[rel="'+locate+'"]').text('');

	        	}, 1000);
				
	        }

	    $($kuasa.prop('currentTarget')).removeClass('layan-admin_attachment-hover');

	    },
	    progressUpdated: function(file, i, progress) {
	        // this function is used for large files and updates intermittently
	        // progress is the integer value of file being uploaded percentage to completion
	        //console.log($(event));
	        var locate = '';
	       	layanActiveTransfer = $kuasa.prop('currentTarget').getAttribute("title");
			locate = $kuasa;
			
			if (file.type == 'image/jpeg' || file.type == 'application/pdf') {

	        	$('.layan-admin_attachment-progressBar[rel="'+$(locate.prop('currentTarget')).attr('title')+'"],.layan-admin_attachment-progressBar-exist[rel="'+$(locate.prop('currentTarget')).attr('title')+'"]').text(progress);

	        	}

	    },
	    beforeEach: function(file) {

	        	if (file.type != 'image/jpeg' && file.type != 'application/pdf') {

	        		alert('Hanya file PDF dan JPEG yang diperbolehkan');

	        		return false;

	        	}

	    }

	});

	$('.layan-admin_attachment-ktpKuasa-container').upchunk({
	    fallback_id: 'upload_button',    // an identifier of a standard file input element
	    url: 'library/capsule/layan/layan.ajax.php',              // upload handler, handles each file separately
	    paramname: 'file',          // POST parameter name used on serverside to reference file
	    data: {
	        control: 'upload',
	        rel: function(){
            	 return layanLastValue; // calculate data at time of upload
       			 },
       		ref: function(){
            	 return $.urlParam('ref'); // calculate data at time of upload
       			 },
	                // send POST variables
	        
	    },
	    headers: {          // Send additional request headers
	        'header': 'value'
	    },
	    error: function(err, file) {
	        switch(err) {
	            case 'BrowserNotSupported':
	                alert('browser does not support html5 drag and drop')
	                break;
	            case 'TooManyFiles':
	                // user uploaded more than 'maxfiles'
	                break;
	            case 'FileTooLarge':
	                // program encountered a file whose size is greater than 'maxfilesize'
	                // FileTooLarge also has access to the file which was too large
	                // use file.name to reference the filename of the culprit file
	                alert(file.name+' filesize is too large')
	                break;
	            case 'FileTypeNotAllowed':
	            	alert('File type not allowed')
	            	break;
	            default:
	                break;
	        }
	    },
	    allowedfiletypes: ['image/jpg','image/jpeg','image/png','image/gif','application/pdf','audio/mp3'],    // filetypes allowed by Content-Type.  Empty array means no restrictions
	    maxfiles: 1,
	    maxfilesize: 20,    // max file size in MBs
	    dragOver: function(dom) {
	        // user dragging files over #dropzone
	        $(dom).prop('currentTarget').setAttribute("class","layan-admin_attachment-foto-container layan-admin_attachment-hover");
	    },
	    dragLeave: function(dom) {
	        // user dragging files out of #dropzone
	        $(dom).prop('currentTarget').setAttribute("class","layan-admin_attachment-foto-container");
	    },
	    drop: function(dom) {
	    	$ktpKuasa = $(dom);
			layanLastValue = $ktpKuasa.prop('currentTarget').getAttribute("rel");
			layanActiveTransfer = $ktpKuasa.prop('currentTarget').getAttribute("title");
	    },
	    uploadStarted: function(i, file, len){
	        // a file began uploading
	        // i = index => 0, 1, 2, 3, 4 etc
	        // file is the actual file of the index
	        // len = total files user dropped
	    },
	    uploadFinished: function(i, file, response, time) {
	        // response is the data you got back from server in JSON format.
	        //console.log(response);
	        if (response == 'success') {
	        	$($ktpKuasa.prop('currentTarget')).find('.layan-admin_attachment-progressBar,.layan-admin_attachment-progressBar-exist').text('Success');

	        	var check = $($ktpKuasa.prop('currentTarget')).find('.layan-admin_attachment-inside-exist').length;

		        	if (check == 1) {

		        	var last = $($ktpKuasa.prop('currentTarget')).find('.layan-admin_attachment-inside-exist').html();
		        	$($ktpKuasa.prop('currentTarget')).find('.layan-admin_attachment-inside-exist').html(last);

		        	}
		        	else {

		        	var last = $($ktpKuasa.prop('currentTarget')).find('.layan-admin_attachment-inside-hidden').html();
		        	$($ktpKuasa.prop('currentTarget')).find('.layan-admin_attachment-inside').html(last);
		        	$($ktpKuasa.prop('currentTarget')).find('.layan-admin_attachment-inside').addClass('layan-admin_attachment-inside-exist').removeClass('layan-admin_attachment-inside');
		        	$($ktpKuasa.prop('currentTarget')).find('.layan-admin_attachment-inside-delete-icon').removeAttr('style');

		        	}

	        	var locate = $($ktpKuasa.prop('currentTarget')).attr('title');

	        	setTimeout(function(){

	        		$('.layan-admin_attachment-progressBar[rel="'+locate+'"],.layan-admin_attachment-progressBar-exist[rel="'+locate+'"]').text('');

	        	}, 1000);
				
	        }

	    $($ktpKuasa.prop('currentTarget')).removeClass('layan-admin_attachment-hover');

	    },
	    progressUpdated: function(file, i, progress) {
	        // this function is used for large files and updates intermittently
	        // progress is the integer value of file being uploaded percentage to completion
	        //console.log($(event));
	        var locate = '';
	       	layanActiveTransfer = $ktpKuasa.prop('currentTarget').getAttribute("title");
			locate = $ktpKuasa;
			
			if (file.type == 'image/jpeg' || file.type == 'application/pdf') {

	        	$('.layan-admin_attachment-progressBar[rel="'+$(locate.prop('currentTarget')).attr('title')+'"],.layan-admin_attachment-progressBar-exist[rel="'+$(locate.prop('currentTarget')).attr('title')+'"]').text(progress);

	        	}

	    },
	    beforeEach: function(file) {

	        	if (file.type != 'image/jpeg' && file.type != 'application/pdf') {

	        		alert('Hanya file PDF dan JPEG yang diperbolehkan');

	        		return false;

	        	}

	    }

	});

	$('.layan-admin_attachment-npwp-container').upchunk({
	    fallback_id: 'upload_button',    // an identifier of a standard file input element
	    url: 'library/capsule/layan/layan.ajax.php',              // upload handler, handles each file separately
	    paramname: 'file',          // POST parameter name used on serverside to reference file
	    data: {
	        control: 'upload',
	        rel: function(){
            	 return layanLastValue; // calculate data at time of upload
       			 },
       		ref: function(){
            	 return $.urlParam('ref'); // calculate data at time of upload
       			 },
	                // send POST variables
	        
	    },
	    headers: {          // Send additional request headers
	        'header': 'value'
	    },
	    error: function(err, file) {
	        switch(err) {
	            case 'BrowserNotSupported':
	                alert('browser does not support html5 drag and drop')
	                break;
	            case 'TooManyFiles':
	                // user uploaded more than 'maxfiles'
	                break;
	            case 'FileTooLarge':
	                // program encountered a file whose size is greater than 'maxfilesize'
	                // FileTooLarge also has access to the file which was too large
	                // use file.name to reference the filename of the culprit file
	                alert(file.name+' filesize is too large')
	                break;
	            case 'FileTypeNotAllowed':
	            	alert('File type not allowed')
	            	break;
	            default:
	                break;
	        }

	    $(dom).prop('currentTarget').setAttribute("class","layan-admin_attachment-foto-container");

	    },
	    allowedfiletypes: ['image/jpg','image/jpeg','image/png','image/gif','application/pdf','audio/mp3'],    // filetypes allowed by Content-Type.  Empty array means no restrictions
	    maxfiles: 1,
	    maxfilesize: 20,    // max file size in MBs
	    dragOver: function(dom) {
	        // user dragging files over #dropzone
	        $(dom).prop('currentTarget').setAttribute("class","layan-admin_attachment-foto-container layan-admin_attachment-hover");
	    },
	    dragLeave: function(dom) {
	        // user dragging files out of #dropzone
	        $(dom).prop('currentTarget').setAttribute("class","layan-admin_attachment-foto-container");
	    },
	    drop: function(dom) {
	    	$npwp = $(dom);
			layanLastValue = $npwp.prop('currentTarget').getAttribute("rel");
			layanActiveTransfer = $npwp.prop('currentTarget').getAttribute("title");
	    },
	    uploadStarted: function(i, file, len){
	        // a file began uploading
	        // i = index => 0, 1, 2, 3, 4 etc
	        // file is the actual file of the index
	        // len = total files user dropped
	    },
	    uploadFinished: function(i, file, response, time) {
	        // response is the data you got back from server in JSON format.
	        //console.log(response);
	        if (response == 'success') {
	        	$($npwp.prop('currentTarget')).find('.layan-admin_attachment-progressBar,.layan-admin_attachment-progressBar-exist').text('Success');

	        	var check = $($npwp.prop('currentTarget')).find('.layan-admin_attachment-inside-exist').length;

		        	if (check == 1) {

		        	var last = $($npwp.prop('currentTarget')).find('.layan-admin_attachment-inside-exist').html();
		        	$($npwp.prop('currentTarget')).find('.layan-admin_attachment-inside-exist').html(last);

		        	}
		        	else {

		        	var last = $($npwp.prop('currentTarget')).find('.layan-admin_attachment-inside-hidden').html();
		        	$($npwp.prop('currentTarget')).find('.layan-admin_attachment-inside').html(last);
		        	$($npwp.prop('currentTarget')).find('.layan-admin_attachment-inside').addClass('layan-admin_attachment-inside-exist').removeClass('layan-admin_attachment-inside');
		        	$($npwp.prop('currentTarget')).find('.layan-admin_attachment-inside-delete-icon').removeAttr('style');

		        	}

	        	var locate = $($npwp.prop('currentTarget')).attr('title');

	        	setTimeout(function(){

	        		$('.layan-admin_attachment-progressBar[rel="'+locate+'"],.layan-admin_attachment-progressBar-exist[rel="'+locate+'"]').text('');

	        	}, 1000);
				
	        }

	    $($npwp.prop('currentTarget')).removeClass('layan-admin_attachment-hover');

	    },
	    progressUpdated: function(file, i, progress) {
	        // this function is used for large files and updates intermittently
	        // progress is the integer value of file being uploaded percentage to completion
	        //console.log($(event));
	        var locate = '';
	       	layanActiveTransfer = $npwp.prop('currentTarget').getAttribute("title");
			locate = $npwp;
			
			if (file.type == 'image/jpeg' || file.type == 'application/pdf') {

	        	$('.layan-admin_attachment-progressBar[rel="'+$(locate.prop('currentTarget')).attr('title')+'"],.layan-admin_attachment-progressBar-exist[rel="'+$(locate.prop('currentTarget')).attr('title')+'"]').text(progress);

	        	}

	    },
	    beforeEach: function(file) {

	        	if (file.type != 'image/jpeg' && file.type != 'application/pdf') {

	        		alert('Hanya file PDF dan JPEG yang diperbolehkan');

	        		return false;

	        	}

	    }

	});
	

});

	$('.layan-admin_settings-year-select').change(function() {
	

		$.post('library/capsule/layan/layan.ajax.php', {data:$(this).val(),control:'getHoliday'}, function(data) {
				
			$('.layan-admin_settings-table-container').html(data);
			
			$('.datepickerSetting').removeAttr('id').removeClass('hasDatepicker');
						
			$('.datepickerSetting').datepicker({
	        changeMonth: true,
	        changeYear: false,
	        numberOfMonths: 1,
	        showOtherMonths: true,
			selectOtherMonths: true,
	        dateFormat: 'dd-mm-yy'
	        });
	});
	
	});
	
	$('.layan-logout-container, .rekapitulasi-logout-container').live('click', function() {
	
	var a = confirm("Anda yakin hendak keluar dari SIP?");
	
		if (a == false) {
			return false;
		}
	
	});
	
	$('.layan-permohonan-float-left-delete-permohonan').live('click', function() {
	
		var check = confirm("Anda yakin akan menghapus permohonan ini dan seluruh data yang telah terjadi didalamnya? Tindakan ini akan direkam dalam sistem.");
		
			if (check == false) {
				return false;
			}
	
	});
	
	$(".layan-libraryFilter-1-select, .layan-libraryFilter-2-select, .layan-libraryFilter-5-select").chosen({
	allow_single_deselect: true
	});
	
	$('.layan-libraryFilter-4-input-layan').live('click', function() {
		//console.log($('.layan-library-content-container').height());
		var ths = $(this);
		
		var chk = $(this).val();

			if (chk != 'CARI') {
				$(this).val('..........')
			}
			else {
				return false;
			}
		
		var kla = $('.layan-libraryFilter-1-select').val();
		
		var tag = $('.layan-libraryFilter-2-select').val();
				
		var met = $('.layan-libraryFilter-5-select').val();
			
		var tex = $('.layan-libraryFilter-2-input').val();
		
		var data = [{'klasifikasi':kla,'tag':tag,'metadata':met,'text':tex}];
		
		//console.log(tag);
		
		$.post('library/capsule/layan/layan.ajax.php', {data:data,control:'getLibraryContent'}, function(result) {
				
			console.log(result);
			
			$(ths).val('Cari');
			
			$('.layan-library-content-container').html(result);
							
		});
		
	return false;	
	
	});
	
	$('.layan-libraryFilter-4-input-layan-guest').live('click', function() {
		//console.log($('.layan-library-content-container').height());
		var ths = $(this);
		
		var chk = $(this).val();

			if (chk != 'CARI') {
				$(this).val('..........')
			}
			else {
				return false;
			}
		
		var kla = $('.layan-libraryFilter-1-select').val();
		
		var tag = $('.layan-libraryFilter-2-select').val();
				
		var met = $('.layan-libraryFilter-5-select').val();
			
		var tex = $('.layan-libraryFilter-2-input').val();
		
		var data = [{'klasifikasi':kla,'tag':tag,'metadata':met,'text':tex}];
		
		//console.log(tag);
		
		$.post('library/capsule/layan/layan.ajax.php', {data:data,control:'getGuestLibraryContent'}, function(result) {
				
			console.log(result);
			
			$(ths).val('Cari');
			
			$('.layan-library-content-container').html(result);
							
		});
		
	return false;	
	
	});
	
	$('.layan-libraryFilter-4-input-layan-user').live('click', function() {
		//console.log($('.layan-library-content-container').height());
		var ths = $(this);
		
		var chk = $(this).val();

			if (chk != 'CARI') {
				$(this).val('..........')
			}
			else {
				return false;
			}
		
		var kla = $('.layan-libraryFilter-1-select').val();
		
		var tag = $('.layan-libraryFilter-2-select').val();
				
		var met = $('.layan-libraryFilter-5-select').val();
			
		var tex = $('.layan-libraryFilter-2-input').val();
		
		var data = [{'klasifikasi':kla,'tag':tag,'metadata':met,'text':tex}];
		
		//console.log(tag);
		
		$.post('library/capsule/layan/layan.ajax.php', {data:data,control:'getUserLibraryContent'}, function(result) {
				
			console.log(result);
			
			$(ths).val('Cari');
			
			$('.layan-library-content-container').html(result);
							
		});
		
	return false;	
	
	});
	
	$('.layan-icon-float-left-library-order').click(function() {
		
		var ths = $(this);
				
		$.post('library/capsule/layan/layan.ajax.php', {control:'getLibraryContent'}, function(result) {
							
			$('.layan-libraryFilter-container-header, .layan-libraryFilter-container').show();
			
			$('.layan-libraryFilter-container-header2, .layan-libraryFilter-container2').hide();
						
			$('.layan-library-content-container').hide().html(result).fadeIn('fast');
				
		});
	
	});
	
	$('.layan-library-image').live('click', function() {
	
		$('.layan-library-image-active').removeClass('layan-library-image-active');
		
		$(this).addClass('layan-library-image-active');
	
	});
	
	$('.layan-library_content-action-orderDokumen').live('click', function() {
	
	var dom = $(this);
		
		$.post('library/capsule/layan/layan.ajax.php', {data:$(dom).attr('rel'),control:'storeOrder'}, function(result) {
				
			//console.log(result);
						
			$('.layan-icon-float-left-new-orderNumber').text(result);
				
		});
	
	});
	
	$('.layan-library_content-action-cancel-order').live('click', function() {
	
		function isNumber(n) {
			return !isNaN(parseFloat(n)) && isFinite(n);
		}
	
	var dom = $(this);
	
	var ord = $(this).attr('ord');
	
		$.post('library/capsule/layan/layan.ajax.php', {data:$(dom).attr('rel'),control:'cancelOrder'}, function(result) {
				
			//console.log(result);
			
			if (isNumber(result)) {
						
			$('.layan-icon-float-left-new-orderNumber').text(result);
			
			$('.layan-library-image-active').parent().remove();
			
			}
				
		});
	
	});
		
	$('.layan-icon-float-left-new-order').click(function() {
	
	var dom = $(this);
	
	var chk = $('.layan-icon-float-left-new-orderNumber').text();

		if (chk == '00') {
			alert('Anda tidak memiliki order untuk ditampilkan');
			return false;
		}
	
		$.post('library/capsule/layan/layan.ajax.php', {control:'getOrderLibraryContent'}, function(result) {
				
			//console.log(result);
			
			$('.layan-libraryFilter-container-header, .layan-libraryFilter-container').hide();
			
			$('.layan-libraryFilter-container-header2, .layan-libraryFilter-container2').show();
						
			$('.layan-library-content-container').hide().html(result).fadeIn('fast');
				
		});
	
	});
	
	$('.layan-icon-float-left-cancel-order').live('click', function() {
	
	var dom = $(this);
	
	var chk = $('.layan-icon-float-left-new-orderNumber').text();

		if (chk == '00') {
			//alert('Anda tidak memiliki order untuk ditampilkan');
			return false;
		}
	
	var check = confirm('Anda yakin akan menghapus order anda? Anda harus memilih ulang dokumen yang akan anda print nanti.');
	
		if (check == true) {
		
			$.post('library/capsule/layan/layan.ajax.php', {data:$(dom).attr('rel'),control:'resetOrder'}, function(result) {
												
				$('.layan-icon-float-left-new-orderNumber').text(result);

					if ($('.layan-libraryFilter-container-header2:visible').text() != '') {
				
						$('.layan-library-content-container').html('');
						
					}
					
			});
		
		}
	
	});
	
	$('.layan-library_content-action-printCheckout').live('click', function() {
	
	var chk = confirm('Anda setuju untuk mencetak dan menghapus seluruh order anda?');
	
	var res = ''; var id = '';
		
		if (chk != true) {return false;}
		
			$.post('library/capsule/layan/layan.ajax.php', {control:'printOrder'}, function(result) {
				//console.log(result);
				var obj = $.parseJSON(result);
				res = obj.status;
				id  = obj.id;
				
				if (res == '1') {
				
					$('.layan-icon-float-left-new-orderNumber').text('0');
						
					$('.layan-print-order-stub-sub-header').text(id);
					
					$('.layan-print-order-stub').printElement();
						
					$('.layan-library-content-container').html('');
					
					$('.layan-icon-float-left-library-order').trigger('click');
				
				}
				else {
							
					alert('Maaf, sistem tidak dapat melayani permintaan anda saat ini');
							
				}
				
									
			});
		
			
	});
	
	var layanLeftContainer  = $('.software-dashboard-middle-container').height();
	var layanLeftContainer2 = parseInt($('.software-dashboard-middle-container').css('min-height'),10);
	
	//console.log(layanLeftContainer2);
	
	layanLeftContainer = layanLeftContainer-175;
	
	if (layanLeftContainer > layanLeftContainer2) {
	
	$('.layan-admin_sejarah-container-global').height(layanLeftContainer);
	
	}
	
	$('.layan-general-dashboard-input-search').keyup(function() {
	
	clearTimeout($.data(this, 'timer'));
	var wait = setTimeout(layanSearch, 500);
	$(this).data('timer', wait);
	
	});
	
	$('.layan-general-dashboard-input-search-admin').keyup(function() {
	
	clearTimeout($.data(this, 'timer'));
	var wait = setTimeout(layanSearchAdmin, 500);
	$(this).data('timer', wait);
	
	});
	
	function layanSearch() {
	$('.layan-dashboard-box-container').html("<div class='layan-ajax-loader'>Searching Record(s)...</div>");
	  $.post('library/capsule/layan/layan.ajax.php', {data:$('.layan-general-dashboard-input-search').val(),control:'layanSearchPermohonan'}, function(result) {
	  console.log(result);
	    if(result.length > 0) {
	      $('.layan-dashboard-box-container').html(result);
	    }
	  });
	}
	
	function layanSearchAdmin() {
	$('.layan-dashboard-box-container').html("<div class='layan-ajax-loader'>Searching Record(s)...</div>");
	  $.post('library/capsule/layan/layan.ajax.php', {data:$('.layan-general-dashboard-input-search-admin').val(),control:'layanSearchPermohonanAdmin'}, function(result) {
	  console.log(result);
	    if(result.length > 0) {
	      $('.layan-dashboard-box-container').html(result);
	    }
	  });
	}
	

});