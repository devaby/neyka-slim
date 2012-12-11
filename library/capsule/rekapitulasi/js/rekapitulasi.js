jQuery.noConflict()(function($){
$(document).ready(function() {

$.urlParam = function(name){
    var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);
    return results[1] || 0;
    }

$('.featured-dado-button-rekap').live('click', function() { 
	dateFrom 	= $('.datepicker-rekap-from').val();
	dateTo 		= $('.datepicker-rekap-to').val();
	year 		= $('.rekapitulasi-dashboard-year').val();
	
	$.post('library/capsule/rekapitulasi/rekapitulasi.ajax.php',{control:'dashboardDate',year:year,dateFrom:dateFrom,dateTo:dateTo},function(result) {
		$('.container-below-div').html(result);
		$('.rekapitulasi-dashboard-year').chosen({disable_search_threshold: 100});
		});
});
$('.rekapitulasi-dashboard-year').live('change', function() { 
	year = $(this).val();
	//alert(year);
	$.post('library/capsule/rekapitulasi/rekapitulasi.ajax.php',{control:'dashboardYear',year:year},function(result) {

		$('.container-below-div').html(result);
		$('.rekapitulasi-dashboard-year').chosen({disable_search_threshold: 100});

		});
})

$('.print-rekap-pemberitahuan').live('click', function() { 
		var id =[];
		$(this).find('input[type="hidden"]').each(function(i) { 
		 id[i] = $(this).val();
		});
		 console.log(id);
		
			$.post('library/capsule/layan/layan.ajax.php', {control:'loading'}, function(loading) {
					
					html = $('body').html();
					//console.log(html);
					$('body').html(loading).hide().fadeIn('slow');
					
					$('.layan-processing').center();
					
					$('.layan-processing-progressbar').progressbar({value: 100});
					
					setTimeout(function(){
					
						$.post('library/capsule/layan/layan.ajax.php', {data:id,control:'printPemberitahuan'}, function(result) {
							//console.log(html);
							if (result != 0) {
								
								$('.layan-processing-text').html('Done! Waiting to display the document..');
									
									setTimeout(function(){
									
									$('.layan-processing').fadeIn('slow', function() {
									
									$('.layan-processing').remove();
									
									$('body').html(result).hide().fadeIn('slow');
									
									});
															
									}, 1000);
									console.log(html);		
																				
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

$('.print-rekap-perpanjangan').live('click', function() { 

	var id =[];
		$(this).find('input[type="hidden"]').each(function(i) { 
		 id[i] = $(this).val();
		});
		 console.log(id);
	
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
$('.print-rekap-penolakan').live('click', function() { 
		var id =[];
		$(this).find('input[type="hidden"]').each(function(i) { 
		 id[i] = $(this).val();
		});
		 console.log(id);
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
$('.print-rekap-keberatan').live('click', function() { 
			var id =[];
			$(this).find('input[type="hidden"]').each(function(i) { 
			 id[i] = $(this).val();
			});
			 console.log(id);
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

                

$('.featured-dado-button-rekap-report').live('click',function(){
	var from = $('.datepicker-rekap-from').val();
	var to 	 = $('.datepicker-rekap-to').val();
	var type = $('.type-of-report').val();
	type = $.base64.encode(type);
	console.log(from + "" + to + "" + type);
	if(from != undefined && to !=undefined){
		date = '&from='+$.base64.encode(from)+'&to='+$.base64.encode(to);
	}
	window.location='?id='+$.urlParam('id')+'&type='+type+date;
		
});

$('.rekapitulasi-dashboard-year').chosen({disable_search_threshold: 100});
$('.type-of-report').chosen({disable_search_threshold: 100});

$('.featured-dado-button-print').live('click',function() {
	
	$('.rekapitulasi-dashboard-all-wrapper').printElement({
	overrideElementCSS:['library/capsule/rekapitulasi/css/print.css']
	});
	
});

$('.rekapitulasi-print-detail').live('click',function() {
	
	$('.table-display').printElement({
	overrideElementCSS:['library/capsule/rekapitulasi/css/print.css']
	});
		
});

});


});