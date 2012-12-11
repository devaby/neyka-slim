jQuery.noConflict()(function($){
$(document).ready(function() {

$(function(){
	
	$('.core-dashboard-tab').tabs();
	$('.core-dashboard-tab').fadeIn('slow');
});

var myNicEditor;

var coreDeletedMenu = [];
var coreDeletedKlasifikasi = [];
var adminCoreFolder = $('.layan-icon-container').attr('data-folder');



	$('.core-menu-actionAdd').live('click',function() {
		var row = $(this).parent().parent().parent().parent().find('tbody tr:last').html();
		$(this).parent().parent().parent().parent().find('tbody tr:last').after('<tr>'+row+'</tr>');
		$(this).parent().parent().parent().parent().find('tbody tr:last input').val('');
	});

	$('.core-setMetadata-actionAdd').live('click',function() {
		var row = $(this).parent().parent().parent().parent().find('tbody tr:last').html();
		$(this).parent().parent().parent().parent().find('tbody tr:last').after('<tr>'+row+'</tr>');
		$(this).parent().parent().parent().parent().find('tbody tr:last input').val('');
	});
	
	$('.core-klasifikasi-actionAdd').live('click',function() {
		var row = "<td class='core-draggableHandler'><img src='/'+adminCoreFolder+'/library/capsule/core/images/list.png'></td><td class='core-klasifikasi-container-tableContent core-align-center'><span class='core-klasifikasi-actionDelete'></span><input type='hidden' name='currentID' class='core-klasifikasi-inputRealID' value=''><input type='hidden' name='parentID' class='core-klasifikasi-input' value=''></td><td class='myStyles' padding='10' style='padding-left:10px;'><img class=\"parentKlasifikasi\" src=\"library/capsule/core/images/parent.png\" /></td><td class='core-klasifikasi-container-tableContent' ><input  type='text' class='core-klasifikasi-input  core-inputInherit' value=''></td><td class='core-klasifikasi-container-tableContent'><input type='text' class='core-klasifikasi-input core-inputInherit1' value=''></td><td class='core-klasifikasi-container-tableContent'><input type='text' class='core-klasifikasi-input core-inputInherit2' value=''></td>";
		var last =$(this).parent().parent().parent().parent().find('tbody tr:last input[name=currentID]').val();
		if(last == undefined) {
		var lastIDToInsert = 1; lastID = 'insert-'+lastIDToInsert;
		}
		else{
		last = last.replace('insert-', '');
		var lastIDToInsert = parseInt(last)+1; lastID = 'insert-'+lastIDToInsert;
		}
		$(this).parent().parent().parent().parent().find('tbody tr:last').after('<tr class="draggableKlasifikasi ui-draggable ui-droppable">'+row+'</tr>');
		$(this).parent().parent().parent().parent().find('tbody tr:last input').val('');
		$(this).parent().parent().parent().parent().find('tbody tr:last input[name=currentID]').val(lastID);
		
	});

	$('.core-publisher-actionAdd').live('click',function() {
		var row = "<td class='core-draggableHandler'><img src='/'+adminCoreFolder+'/library/capsule/core/images/list.png'></td><td class='core-klasifikasi-container-tableContent core-align-center'><span class='core-klasifikasi-actionDelete'></span><input type='hidden' name='currentID' class='core-klasifikasi-inputRealID' value=''><input type='hidden' name='parentID' class='core-klasifikasi-input' value=''></td><td class='myStyles' padding='10' style='padding-left:10px;'><img class=\"parentKlasifikasi\" src=\"library/capsule/core/images/parent.png\" /></td><td class='core-klasifikasi-container-tableContent' ><input  type='text' class='core-klasifikasi-input  core-inputInherit' value=''></td><td class='core-klasifikasi-container-tableContent'><input type='text' class='core-klasifikasi-input core-inputInherit1' value=''></td>";
		var last =$(this).parent().parent().parent().parent().find('tbody tr:last input[name=currentID]').val();
		if(last == undefined) {
		var lastIDToInsert = 1; lastID = 'insert-'+lastIDToInsert;
		}
		else{
		last = last.replace('insert-', '');
		var lastIDToInsert = parseInt(last)+1; lastID = 'insert-'+lastIDToInsert;
		}
		$(this).parent().parent().parent().parent().find('tbody tr:last').after('<tr class="draggableKlasifikasi ui-draggable ui-droppable">'+row+'</tr>');
		$(this).parent().parent().parent().parent().find('tbody tr:last input').val('');
		$(this).parent().parent().parent().parent().find('tbody tr:last input[name=currentID]').val(lastID);
		
	});
		
	$('.core-grouping-actionAdd').live('click',function() {
		var row = "<td class='core-draggableHandler'><img src='/'+adminCoreFolder+'/library/capsule/core/images/list.png'></td><td class='core-klasifikasi-container-tableContent core-align-center'><span class='core-klasifikasi-actionDelete'></span><span class='core-klasifikasi-actionSetShow'></span><input type='hidden' name='currentID' class='core-klasifikasi-inputRealID' value=''><input type='hidden' name='parentID' class='core-klasifikasi-input' value=''></td><td class='myStyles' padding='10' style='padding-left:10px;'><img class=\"parentKlasifikasi\" src=\"library/capsule/core/images/parent.png\" /></td><td class='core-klasifikasi-container-tableContent' ><input  type='text' class='core-klasifikasi-input  core-inputInherit' value=''></td><td class='core-klasifikasi-container-tableContent'><input type='text' class='core-klasifikasi-input core-inputInherit1' value=''></td>";
		var last =$(this).parent().parent().parent().parent().find('tbody tr:last input[name=currentID]').val();
		if(last == undefined) {
		var lastIDToInsert = 1; lastID = 'insert-'+lastIDToInsert;
		}
		else{
		last = last.replace('insert-', '');
		var lastIDToInsert = parseInt(last)+1; lastID = 'insert-'+lastIDToInsert;
		}
		$(this).parent().parent().parent().parent().find('tbody tr:last').after('<tr class="draggableKlasifikasi ui-draggable ui-droppable">'+row+'</tr>');
		$(this).parent().parent().parent().parent().find('tbody tr:last input').val('');
		$(this).parent().parent().parent().parent().find('tbody tr:last input[name=currentID]').val(lastID);
		
	});
	
	$('.core-menu-actionDelete').live('click',function() {
		var row = $(this).parent().parent().parent().parent().find('tbody tr').length;
		
		var id  = $(this).parent().parent().find('.core-menu-inputRealID').val();
		
		if (row == 1) {
		$(this).parent().parent().parent().parent().find('tbody tr:last input[type="text"]').val('');
		}
		else {
		$(this).parent().parent().remove();
		}
		
	coreDeletedMenu.push(id); 
			
	});
	
	$('.core-klasifikasi-actionDelete').live('click',function() {
		var row = $(this).parent().parent().parent().parent().find('tbody tr').length;
		
		var id  = $(this).parent().parent().find('.core-klasifikasi-inputRealID').val();
		var idSplited = id.split('-');
		
		
		
		if (row == 1) {
		$(this).parent().parent().parent().parent().find('tbody tr:last input[type="text"]').val('');
		}
		else {
		$(this).parent().parent().remove();
		}
		if(idSplited[0] != 'insert' && idSplited[0] != undefined ){
			coreDeletedKlasifikasi.push(id); 
			console.log(coreDeletedKlasifikasi);
		}
	
			
	});
	
	$('.core-image-table tbody tr:even').addClass('core-image-table-even');
	
	$('.core-image-actionNext').live('click',function() {
	var id = $(this).parent().parent().find('input[type="hidden"]').val();
	var na = $(this).parent().parent().find('.core-image-container-tableContentHuge').text();
	$('.core-container-contentInside').html('Loading...');
	$('.core-image-container-content').hide();
	$('.core-container-contentInsideActionButton').hide();
	 
	 	$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:id,type:'image',control:'getContentNotContent'}, function(data) {
		$('.core-container-contentInside').html(data);
		uploader('core-container-file-upload',$('.core-headerOfContentInputTypeOfFile').val());
		$('.core-headerOfContent').text('- '+na);
		$('.core-headerOfContentInput').val(na);
		$('.core-image-table tbody tr:even').addClass('core-image-table-even');
		$('.core-container-contentInside').show();
				
				$('.core-image-thumbnail').qtip({
				content: {
		      			text: function(api) {
						// Retrieve content from custom attribute of the $('.selector') elements.
						return "<img class='core-image-thumbnail-inside' src='"+$(this).attr('text')+"' alt='Loading...'>";
						} // Notice that content.text is long-hand for simply declaring content as a string
		   			},
				position: {
		      	my: 'top center',  // Position my top left...
		      	at: 'bottom center', // at the bottom right of...
		      	viewport: $(window)
		  	 	},
				style: {
           	 	classes: 'ui-tooltip-light ui-tooltip-shadow',
           	 	width: 160
         		}
	
				});
				
		});
	 
	});
	
	$('.core-button-next').live('click', function() {  
		var next 		= $('.pageAtThisTime').val();
		var totalPage 	= $('.totalPage').val();
		next 			= parseInt(next);
		totalPage 		= parseInt(totalPage);
		console.log(totalPage);
		console.log(next);
		
		next = next + 1;
		
		//console.log(next);
		$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php',{control:'nextPage',id:next,type:$('.core-headerOfContentInputTypeOfFile').val()},function(data){

			$('.core-image-container').html(data);
			$('.core-image-table tbody tr:even').addClass('core-image-table-even');
			$('.pageAtThisTime').val(next);
			if(next >= totalPage){
			$('.core-button-next').hide();
			}
			if(totalPage > 0 ){
				$('.core-button-prev').show();
			}
		});
			
		
	});

	$('.core-button-prev').live('click', function() {  
		var next = $('.pageAtThisTime').val();
		var totalPage = $('.totalPage').val();
		next = parseInt(next);
		totalPage = parseInt(totalPage);
		
		next = next - 1;
		
		$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php',{control:'nextPage',id:next,type:$('.core-headerOfContentInputTypeOfFile').val()},function(data){
			
			$('.core-image-container').html(data);
			$('.core-image-table tbody tr:even').addClass('core-image-table-even');
			$('.pageAtThisTime').val(next);
			
			if(next < totalPage){
			$('.core-button-next').show();
			}
			if(next <= 0 ){
				$('.core-button-prev').hide();
			}
			console.log(next);
		});
			
		
	});
	$('.core-button-next-text').live('click', function() {  
		var next = $('.pageAtThisTime').val();
		var totalPage = $('.totalPage').val();
		next = parseInt(next);
		totalPage = parseInt(totalPage);
		console.log(totalPage);
		console.log(next);
		
		next = next + 1;
		
		//console.log(next);
		$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php',{control:'nextPageText',id:next,type:$('.core-headerOfContentInputTypeOfFile').val()},function(data){

			$('.core-image-container').html(data);
			$('.core-image-table tbody tr:even').addClass('core-image-table-even');
			$('.pageAtThisTime').val(next);
			if(next >= totalPage){
			$('.core-button-next-text').hide();
			}
			if(totalPage > 1 ){
				$('.core-button-prev-text').show();
			}
		});
			
		
	});

	$('.core-button-prev-text').live('click', function() {  
		var next = $('.pageAtThisTime').val();
		var totalPage = $('.totalPage').val();
		next = parseInt(next);
		totalPage = parseInt(totalPage);
		
		next = next - 1;
		
		$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php',{control:'nextPageText',id:next,type:$('.core-headerOfContentInputTypeOfFile').val()},function(data){
			
			$('.core-image-container').html(data);
			$('.core-image-table tbody tr:even').addClass('core-image-table-even');
			$('.pageAtThisTime').val(next);
			if(next < totalPage){
			$('.core-button-next-text').show();
			}
			if(next <= 1 ){
				$('.core-button-prev-text').hide();
			}
			console.log(next);
		});
			
		
	});
	$('.coreUser-button-next').live('click', function() {  
		var next = $('.pageAtThisTime').val();
		next = parseInt(next);
		next = next + 1;
		console.log(next);
		$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php',{control:'nextPage',id:next,type:$('.core-headerOfContentInputTypeOfFile').val()},function(data){

			$('.core-image-container').html(data);
			$('.core-image-table tbody tr:even').addClass('core-image-table-even');
			$('.pageAtThisTime').val(next);
		});
			
		
	});

	$('.coreUser-button-prev').live('click', function() {  
		var next = $('.pageAtThisTime').val();
		next = parseInt(next);
		next = next - 1;
		
		$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php',{control:'nextPage',id:next,type:$('.core-headerOfContentInputTypeOfFile').val()},function(data){
			
			$('.core-image-container').html(data);
			$('.core-image-table tbody tr:even').addClass('core-image-table-even');
			$('.pageAtThisTime').val(next);
			console.log(next);
		});
			
		
	});
	
	$('.core-image-actionNextAdmin').live('click',function() {
	var id = $(this).parent().parent().find('input[type="hidden"]').val();
	var na = $(this).parent().parent().find('.core-image-container-tableContentHuge').text();
	$('.core-container-contentInside').html('Loading...');
	$('.core-image-container-content').hide();
	$('.core-container-contentInsideActionButton').hide();

	var headerOfContent = $(this).parent().find('.core-headerOfContentInputTypeOfFile-search').val();
	if(headerOfContent !== undefined){
		$('.core-image-container-inside span:first').text(headerOfContent+" Manager ");
		$('.core-headerOfContentInputTypeOfFile').val(headerOfContent);
	}else{

	}
	 	$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:id,type:'image',control:'getContentNotContentAdmin'}, function(data) {
	 	
		$('.core-container-contentInside').html(data);
		uploader('core-container-file-upload',$('.core-headerOfContentInputTypeOfFile').val());
		$('.core-headerOfContent').text('- '+na);
		$('.core-headerOfContentInput').val(na);
		$('.core-image-table tbody tr:even').addClass('core-image-table-even');
		$('.core-container-contentInside').show();
				
				$('.core-image-thumbnail').qtip({
				content: {
		      			text: function(api) {
						// Retrieve content from custom attribute of the $('.selector') elements.
						return "<img class='core-image-thumbnail-inside' src='"+$(this).attr('text')+"' alt='Loading...'>";
						} // Notice that content.text is long-hand for simply declaring content as a string
		   			},
				position: {
		      	my: 'top center',  // Position my top left...
		      	at: 'bottom center', // at the bottom right of...
		      	viewport: $(window)
		  	 	},
				style: {
           	 	classes: 'ui-tooltip-light ui-tooltip-shadow',
           	 	width: 160
         		}
	
				});
				
		});
	 
	});
	$('.core-image-actionNextUser').live('click',function() {
	var id = $(this).parent().parent().find('input[type="hidden"]').val();
	var na = $(this).parent().parent().find('.core-image-container-tableContentHuge').text();
	$('.core-container-contentInside').html('Loading...');
	$('.core-image-container-content').hide();
	$('.core-container-contentInsideActionButton').hide();

	var headerOfContent = $(this).parent().find('.core-headerOfContentInputTypeOfFile-search').val();
	if(headerOfContent !== undefined){
		$('.core-image-container-inside span:first').text(headerOfContent+" Manager ");
		$('.core-headerOfContentInputTypeOfFile').val(headerOfContent);
	}else{

	}
	 	$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:id,type:'image',control:'getContentNotContent'}, function(data) {
		$('.core-container-contentInside').html(data);
		uploader('core-container-file-upload',$('.core-headerOfContentInputTypeOfFile').val());
		$('.core-headerOfContent').text('- '+na);
		$('.core-headerOfContentInput').val(na);
		$('.core-image-table tbody tr:even').addClass('core-image-table-even');
		$('.core-container-contentInside').show();
				
				$('.core-image-thumbnail').qtip({
				content: {
		      			text: function(api) {
						// Retrieve content from custom attribute of the $('.selector') elements.
						return "<img class='core-image-thumbnail-inside' src='"+$(this).attr('text')+"' alt='Loading...'>";
						} // Notice that content.text is long-hand for simply declaring content as a string
		   			},
				position: {
		      	my: 'top center',  // Position my top left...
		      	at: 'bottom center', // at the bottom right of...
		      	viewport: $(window)
		  	 	},
				style: {
           	 	classes: 'ui-tooltip-light ui-tooltip-shadow',
           	 	width: 160
         		}
	
				});
				
		});
	 
	});

	
	//For content only action
	$('.core-image-actionNextContent').live('click',function() {
	var id = $(this).parent().parent().find('input[type="hidden"]').val();
	var na = $(this).parent().parent().find('.core-image-container-tableContentHuge').text();
	$('.core-container-contentInside').html('Loading...');
	$('.core-image-container-content').hide();
	$('.core-container-contentInsideActionButton').hide();
	 
	 	$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:id,type:'image',control:'getContent'}, function(data) {
		$('.core-container-contentInside').html(data);
		$('.core-headerOfContent').text('- '+na);
		$('.core-headerOfContentInput').val(na);
		$('.core-container-contentInside').show();
		$('#core-textarea-content').elastic();

		myNicEditor = new nicEditor({
		iconsPath : '/'+adminCoreFolder+'/library/plugins/nicEdit/nicEditorIcons.gif',
		buttonList : ['bold','italic','underline','left','center','right','justify','ol','ul','fontSize','fontFamily','fontFormat','image','link','forecolor','xhtml']});
		myNicEditor.setPanel('core-nic-panel');
    	myNicEditor.addInstance('core-textarea-content');
		});

	});
	
	$('.core-image-actionNextContentPersonal').live('click',function() {
	var id = $(this).parent().parent().find('input[type="hidden"]').val();
	var na = $(this).parent().parent().find('.core-image-container-tableContentHuge').text();
	$('.core-container-contentInside').html('Loading...');
	$('.core-image-container-content').hide();
	$('.core-container-contentInsideActionButton').hide();
	 
	 	$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:id,type:'image',control:'getContent'}, function(data) {
		$('.core-container-contentInside').html(data);
		$('.core-headerOfContent').text('- '+na);
		$('.core-headerOfContentInput').val(na);
		$('.core-container-contentInside').show();
		$('#core-textarea-content').elastic();

		myNicEditor = new nicEditor({
		iconsPath : '/'+adminCoreFolder+'/library/plugins/nicEdit/nicEditorIcons.gif',
		buttonList : ['bold','italic','underline','left','center','right','justify','ol','ul','fontSize','fontFamily','fontFormat','image','link','forecolor','xhtml']});
		myNicEditor.setPanel('core-nic-panel');
    	myNicEditor.addInstance('core-textarea-content');
		});

	});

	$('.core-image-actionNextContentAdmin').live('click',function() {
	var id = $(this).parent().parent().find('input[type="hidden"]').val();
	var na = $(this).parent().parent().find('.core-image-container-tableContentHuge').text();
	$('.core-container-contentInside').html('Loading...');
	$('.core-image-container-content').hide();
	$('.core-container-contentInsideActionButton').hide();
	var headerOfContent = $('.software-dashboard-container-header .dado-id-float-left').text();
	if(headerOfContent !== undefined){
		$('.core-headerOfContentInput').text(headerOfContent);
		$('.core-headerOfContentInputTypeOfFile').val(headerOfContent);
	}else{
		
	}
	 	$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:id,type:'image',control:'getContentAdmin'}, function(data) {
		$('.core-container-contentInside').html(data);
		$('.dado-core-file-header').html("<div class='core-container-container-top-head'>"+headerOfContent+" - "+na+"</div>");
		$('.core-headerOfContentInput').val(na);
		$('.core-container-contentInside').show();
		$('#core-textarea-content').elastic();

		myNicEditor = new nicEditor({
		iconsPath : '/'+adminCoreFolder+'/library/plugins/nicEdit/nicEditorIcons.gif',
		buttonList : ['bold','italic','underline','left','center','right','justify','ol','ul','fontSize','fontFamily','fontFormat','image','link','forecolor','xhtml']});
		myNicEditor.setPanel('core-nic-panel');
    	myNicEditor.addInstance('core-textarea-content');
		});
	
	});

	
	$('.core-button-setCompletedContent').live('click',function() {
	var id = $(this).parent().parent().find('input[type="hidden"]').val();
	//alert(id);
	//var na = $(this).parent().parent().find('.core-image-container-tableContentHuge').text();
	$('.core-container-contentInside').html('Loading...');
	$('.core-image-container-content').hide();
	$('.core-container-contentInsideActionButton').hide();
	var headerOfContent = $('.software-dashboard-container-header .dado-id-float-left').text();

	 	$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:id,type:'content',control:'getContentNew'}, function(data) {
		$('.core-container-contentInside').html(data);
		$('.dado-core-file-header').html("<div class='core-container-container-top-head'>"+headerOfContent+" - "+'New'+"</div>");
		$('.core-container-contentInside').show();
		$('#core-textarea-content').elastic();
		
		myNicEditor = new nicEditor({
		iconsPath : '/'+adminCoreFolder+'/library/plugins/nicEdit/nicEditorIcons.gif',
		buttonList : ['bold','italic','underline','left','center','right','justify','ol','ul','fontSize','fontFamily','fontFormat','image','link','forecolor','xhtml']});
		myNicEditor.setPanel('core-nic-panel');
    	myNicEditor.addInstance('core-textarea-content');
		});
	 
	});
	
	$('.core-button-setCompletedContentPersonal').live('click',function() {
	var id = $(this).parent().parent().find('input[type="hidden"]').val();
	//alert(id);
	//var na = $(this).parent().parent().find('.core-image-container-tableContentHuge').text();
	$('.core-container-contentInside').html('Loading...');
	$('.core-image-container-content').hide();
	$('.core-container-contentInsideActionButton').hide();
	var headerOfContent = $('.software-dashboard-container-header .dado-id-float-left').text();

	 	$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:id,type:'content',control:'getContentPersonalNew'}, function(data) {
		$('.core-container-contentInside').html(data);
		$('.dado-core-file-header').html("<div class='core-container-container-top-head'>"+headerOfContent+" - "+'New'+"</div>");
		$('.core-container-contentInside').show();
		$('#core-textarea-content').elastic();
		
		myNicEditor = new nicEditor({
		iconsPath : '/'+adminCoreFolder+'/library/plugins/nicEdit/nicEditorIcons.gif',
		buttonList : ['bold','italic','underline','left','center','right','justify','ol','ul','fontSize','fontFamily','fontFormat','image','link','forecolor','xhtml']});
		myNicEditor.setPanel('core-nic-panel');
    	myNicEditor.addInstance('core-textarea-content');
		});
	 
	});

	$('.core-button-setCompletedContentAdmin').live('click',function() {
	var id = $(this).parent().parent().find('input[type="hidden"]').val();
	//alert(id);
	//var na = $(this).parent().parent().find('.core-image-container-tableContentHuge').text();
	$('.core-container-contentInside').html('Loading...');
	$('.core-image-container-content').hide();
	$('.core-container-contentInsideActionButton').hide();
	var headerOfContent = $('.software-dashboard-container-header .dado-id-float-left').text();
	 	
	 	$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:id,type:'content',control:'getContentAdminNew'}, function(data) {
		$('.core-container-contentInside').html(data);
		$('.dado-core-file-header').html("<div class='core-container-container-top-head'>"+headerOfContent+" - "+'New'+"</div>");
		$('.core-container-contentInside').show();
		$('#core-textarea-content').elastic();
		
		myNicEditor = new nicEditor({
		iconsPath : '/'+adminCoreFolder+'/library/plugins/nicEdit/nicEditorIcons.gif',
		buttonList : ['bold','italic','underline','left','center','right','justify','ol','ul','fontSize','fontFamily','fontFormat','image','link','forecolor','xhtml']});
		myNicEditor.setPanel('core-nic-panel');
    	myNicEditor.addInstance('core-textarea-content');
		});
	 
	});
	

		
	$('.core-button-setCompleted').live('click',function() {
	var id = $(this).parent().parent().find('input[type="hidden"]').val();
	
	//var na = $(this).parent().parent().find('.core-image-container-tableContentHuge').text();
	$('.core-container-contentInside').html('Loading...');
	$('.core-image-container-content').hide();
	$('.core-container-contentInsideActionButton').hide();
	 
	 	$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:id,type:'image',control:'getContentNotContentNew'}, function(data) {
		$('.core-container-contentInside').html(data);
		//uploader('core-container-file-upload',$('.core-headerOfContentInputTypeOfFile').val());
		//$('.core-headerOfContent').text('- '+na);
		//$('.core-headerOfContentInput').val(na);
		$('.core-image-table tbody tr:even').addClass('core-image-table-even');
		$('.core-container-contentInside').show();
		
			$('.core-container-container-action').hide();
			$('.core-container-container-contentInside').hide();
		
		});
	 
	});
	
	$('.core-button-setCompletedPersonal').live('click',function() {
	var id = $(this).parent().parent().find('input[type="hidden"]').val();
	
	//var na = $(this).parent().parent().find('.core-image-container-tableContentHuge').text();
	$('.core-container-contentInside').html('Loading...');
	$('.core-image-container-content').hide();
	$('.core-container-contentInsideActionButton').hide();
	 
	 	$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:id,type:'image',control:'getContentNotContentPersonalNew'}, function(data) {
		$('.core-container-contentInside').html(data);
		//uploader('core-container-file-upload',$('.core-headerOfContentInputTypeOfFile').val());
		//$('.core-headerOfContent').text('- '+na);
		//$('.core-headerOfContentInput').val(na);
		$('.core-image-table tbody tr:even').addClass('core-image-table-even');
		$('.core-container-contentInside').show();
		
			$('.core-container-container-action').hide();
			$('.core-container-container-contentInside').hide();
		
		});
	 
	});
	
	$('.core-button-setCompletedAdmin').live('click',function() {
	var id = $(this).parent().parent().find('input[type="hidden"]').val();
	
	

	//var na = $(this).parent().parent().find('.core-image-container-tableContentHuge').text();
	$('.core-container-contentInside').html('Loading...');
	$('.core-image-container-content').hide();
	$('.core-container-contentInsideActionButton').hide();
	 
	 	$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:id,type:'image',control:'getContentNotContentAdminNew'}, function(data) {
		$('.core-container-contentInside').html(data);
		//uploader('core-container-file-upload',$('.core-headerOfContentInputTypeOfFile').val());
		//$('.core-headerOfContent').text('- '+na);
		//$('.core-headerOfContentInput').val(na);
		$('.core-image-table tbody tr:even').addClass('core-image-table-even');
		$('.core-container-contentInside').show();
		
			$('.core-container-container-action').hide();
			$('.core-container-container-contentInside').hide();
		
		});
	 
	});
	
	
	$('.core-contentInside-back').live('click', function() {
	coreImageDeletedContent = [];
	myNicEditor = '';
		$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:$('.core-container-container-idContent').val(),type:$('.core-headerOfContentInputTypeOfFile').val(),control:'originalContent'}, function(data) {
		$('.core-image-container').html(data);
		$('.core-image-table tbody tr:even').addClass('core-image-table-even');
		});
	});
	
	$('.core-contentInsideAdmin-back').live('click', function() {
	coreImageDeletedContent = [];
	myNicEditor = '';
		$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:$('.core-container-container-idContent').val(),type:$('.core-headerOfContentInputTypeOfFile').val(),control:'originalContentAdmin'}, function(data) {
		$('.core-image-container').html(data);
		$('.core-image-table tbody tr:even').addClass('core-image-table-even');
		});
	});
	
	$('.core-contentInsideContent-back').live('click', function() {
	coreImageDeletedContent = [];
	myNicEditor = '';
		$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:$('.core-container-container-idContent').val(),type:$('.core-headerOfContentInputTypeOfFile').val(),control:'originalTextContent'}, function(data) {
		$('.core-image-container').html(data);
		$('.core-image-table tbody tr:even').addClass('core-image-table-even');
		});
	});
	
	$('.core-contentInsideContentPersonal-back').live('click', function() {
	coreImageDeletedContent = [];
	myNicEditor = '';
		$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:$('.core-container-container-idContent').val(),type:$('.core-headerOfContentInputTypeOfFile').val(),control:'originalTextContent'}, function(data) {
		$('.core-image-container').html(data);
		$('.core-image-table tbody tr:even').addClass('core-image-table-even');
		});
	});
	
	$('.core-contentInsideContentAdmin-back').live('click', function() {
	coreImageDeletedContent = [];
	myNicEditor = '';
		$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:$('.core-container-container-idContent').val(),type:$('.core-headerOfContentInputTypeOfFile').val(),control:'originalTextContentAdmin'}, function(data) {
		$('.core-image-container').html(data);
		$('.core-image-table tbody tr:even').addClass('core-image-table-even');
		});
	});

	
var coreImageDeletedContent = [];
var coreImageDeletedContentFkid = [];
	
	$('.core-image-actionDeleteContent').live('click',function() {
		var id   = $(this).parent().find('input[type="hidden"]').val();
		var fkid = $(this).parent().find('input[name="FKID"]').val();
		$(this).parent().parent().remove();
		coreImageDeletedContent.push(id); 
		coreImageDeletedContentFkid.push(fkid); 
	});
	
	$('.core-contentInside-submitContent').live('click', function() {
	var type = $(this).val();
	var data = [];
	
		$('.core-image-container').find('.core-container-container-idContent,.core-contentInside-select-category,.core-contentInside-select-pages, .core-contentInside-select, .core-contentInside-select-publish,  .core-contentInside-inputContent').each(function(i) {
		
		data[i] = $(this).val();
		
		});
		
		
		data.push(nicEditors.findEditor('core-textarea-content').getContent());
		console.log(data);
		$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {data:data,control:'updateContent'}, function(data) {
			console.log(data);
		var obj = $.parseJSON(data);
			//alert(obj.id);
			if (coreNumber(obj.id)) {
				var na = $('.core-contentInside-inputContent').val();
				$('.core-container-container-idContent').val(obj.id);
				$('.core-contentInside-submitContent').val('Update');
				$('.core-headerOfContent').text('- '+na);
				notificationCentercore("Content Saved!");
			}
			else {
			notificationCentercore("Saved Content failed!");
			}
		
		
		});
		if(type=='Update'){
			notificationCentercore("Content Saved!");
			
		}
	
	});
	$('.core-contentInside-submitContentUser').live('click', function() {
	var type = $(this).val();
	var data = [];
	
		$('.core-image-container').find('.core-container-container-idContent, .core-select, .core-contentInside-select, .core-contentInside-select-publish,  .core-contentInside-inputContent').each(function(i) {
		
		data[i] = $(this).val();
		
		});
		
		
		data.push(nicEditors.findEditor('core-textarea-content').getContent());
		console.log(data);
		$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {data:data,control:'updateContent'}, function(data) {
			
		var obj = $.parseJSON(data);
			//alert(obj.id);
			if (coreNumber(obj.id)) {
				var na = $('.core-contentInside-inputContent').val();
				$('.core-container-container-idContent').val(obj.id);
				$('.core-contentInside-submitContentUser').val('Update');
				$('.core-headerOfContent').text('- '+na);
				notificationCentercore("Content Saved!");
			}
			else {
			notificationCentercore("Saved Content failed!");
			}
		
		
		});
		if(type=='Update'){
			notificationCentercore("Content Saved!");
			
		}
	
	});
	
	$('.core-contentInside-submitContentPersonal').live('click', function() {
	var type = $(this).val();
	var data = [];
	
		$('.core-image-container').find('.core-container-container-idContent, .core-select, .core-contentInside-select, .core-contentInside-select-publish,  .core-contentInside-inputContent').each(function(i) {
		
		data[i] = $(this).val();
		
		});
		
		
		data.push(nicEditors.findEditor('core-textarea-content').getContent());
		data.push($('.core-container-container-siteID').val());
		console.log(data);
		$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {data:data,control:'updateContent'}, function(data) {
			
		var obj = $.parseJSON(data);
			//alert(obj.id);
			if (coreNumber(obj.id)) {
				var na = $('.core-contentInside-inputContent').val();
				$('.core-container-container-idContent').val(obj.id);
				$('.core-contentInside-submitContentUser').val('Update');
				$('.core-headerOfContent').text('- '+na);
				notificationCentercore("Content Saved!");
			}
			else {
			notificationCentercore("Saved Content failed!");
			}
		
		
		});
		if(type=='Update'){
			notificationCentercore("Content Saved!");
			
		}
	
	});


	
	$('.core-contentInside-submit').live('click', function() {
		//console.log(coreImageDeletedContent);
	var deLength = coreImageDeletedContent.length;
	
		var folMainId = $('.core-container-container-mainid').val();
		console.log(folMainId);
	
	if(deLength == "0"){
		a = true;
	}else{
		a = confirm("Anda Yakin Akan Menghapus "+deLength + " Dokumen?");
	}
	
	
		if (a == false) {
			return false;
		}else{
		var status;

		var counter = 0;
	
		$('.core-container-container-actionInputField').find('input').each(function(i) {
			if ($(this).val() == '') {counter += 1; $(this).removeClass('core-filled-field').addClass('core-empty-field');} else {$(this).removeClass('core-empty-field').addClass('core-filled-field');}
		});
		
		if ($('.core-container-container-actionInputField').find('input').val()=="") {notificationCentercore('Some Field is Empty'); return false;}
		
		var folName = $('.core-container-container-actionInputField').find('input').val();
		var folUserId = $('.core-container-container-path').val();
		if($.isNumeric(folUserId)){

		}else{
			folUserId = "";
		}
		var folType = $('.core-headerOfContentInputTypeOfFile').val();
		$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php',{control:"checkDirectory",userID:folUserId,mainID:folMainId,data:folName,type:folType},function(status){
			var transactionType = $('.core-typeOfTransaction').val();
			
			if (transactionType == 'new') {
				var id = $('.core-container-container-idContent').val();
			}
			else if (transactionType == 'after') {
				var id = $('.core-container-container-idContentAfter').val();
				
			}else {
				var id = $('.core-container-container-idContent').val();
				
			}
			
			if(status == 0 && transactionType == 'new'){
				notificationCentercore('Directory Exist, please chose another name !');
				return false;

			}else{
				
				if (id == '' && status != '0' && transactionType == 'new') {
				
					var coreContent2 = [];
				
					$('.core-container-container-actionInputField').find('input,select').each(function(i) {
						coreContent2[i] = $(this).val();
					});
				
					$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {type:$('.core-headerOfContentInputTypeOfFile').val(),content:coreContent2,mainID:folMainId,control:'createDirectory'}, function(data) {
						
						if (data != 1) {
							notificationCentercore('Directory failed to create');  return false;
						}else{
							status = 0;

						}
						
					});

				}

				if ($('.uploadifyQueueItem').length != 0  ) {
						if(status == 0){
					
							var newData = $('.core-contentInside-input').val();
							var oldData = $('.core-headerOfContentInput').val();
							
								if (newData == oldData) {coreData = oldData;} else if (oldData == '') {coreData = newData;} else {coreData = oldData;}

							$('#core-container-file-upload').uploadifySettings( 'scriptData' , { 'myFolder' : coreData});
							var upload = $('#core-container-file-upload').uploadifyUpload();
							
						}

				}else {

					var coreContent = [];
					
					$('.core-container-container-actionInputField').find('input,select').each(function(i) {
					coreContent[i] = $(this).val();
					});
					
					
					 
						if (id != '') {

			      			$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:id,type:$('.core-headerOfContentInputTypeOfFile').val(),del:coreImageDeletedContent,fkid:coreImageDeletedContentFkid,mainID:folMainId,content:coreContent,control:'deleteContentNotContent'}, function(data) {
			      			var lastData = $('.core-contentInside-input core-filled-field').val();
			      			
							$('.core-container-container-contentInside').html(data);
							$('.core-image-table tbody tr:even').addClass('core-image-table-even');
							notificationCentercore('Data was saved !');
							coreImageDeletedContent = [];
							var na = $('.core-contentInside-inputNew').val();
								$('.core-contentInside-input').val(na);
								$('.core-headerOfContent').text('- '+na);
								$('.core-image-table tr td input[value="'+id+'"]').parent().parent().find('.core-image-container-tableContentHuge').text(na);
							$('.core-container-file-uploadQueue').remove();	
							var transactionType = $('.core-typeOfTransaction').val();
								if (transactionType == 'new') {
								$('.core-contentInside-submit').val('Update');
								uploader('core-container-file-upload',$('.core-headerOfContentInputTypeOfFile').val());
								$('.core-container-container-action').show();
								$('.core-container-container-contentInside').show();
								$('.core-typeOfTransaction').val('after');
								}
								
							});
					
						}
						else if (id == '' && $('.core-typeOfTransaction').val() == 'new' ) {

							$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:id,type:$('.core-headerOfContentInputTypeOfFile').val(),del:coreImageDeletedContent,mainID:folMainId,content:coreContent,control:'deleteContentNotContent'}, function(data) {
			      			var lastData = $('.core-contentInside-input core-filled-field').val();
			      			
							$('.core-container-container-contentInside').html(data);
							$('.core-image-table tbody tr:even').addClass('core-image-table-even');
							notificationCentercore('Data was saved !');
							coreImageDeletedContent = [];
							var na = $('.core-contentInside-inputNew').val();
								$('.core-contentInside-input').val(na);
								$('.core-headerOfContent').text('- '+na);
								$('.core-image-table tr td input[value="'+id+'"]').parent().parent().find('.core-image-container-tableContentHuge').text(na);
							$('.core-container-file-uploadQueue').remove();	
							var transactionType = $('.core-typeOfTransaction').val();
								if (transactionType == 'new') {
								$('.core-contentInside-submit').val('Update');
								uploader('core-container-file-upload',$('.core-headerOfContentInputTypeOfFile').val());
								$('.core-container-container-action').show();
								$('.core-container-container-contentInside').show();
								$('.core-typeOfTransaction').val('after');
								
								}					
								
							});
						
						}
					 
				}
			
			}
		});
		}
	
	});
	
	$('.core-contentInside-submitUser').live('click', function() {
		//console.log(coreImageDeletedContent);
		var status;

		var counter = 0;
		
		var folMainId = $('.core-container-container-mainid').val();
		console.log(folMainId);
	
		$('.core-container-container-actionInputField').find('input').each(function(i) {
			if ($(this).val() == '') {counter += 1; $(this).removeClass('core-filled-field').addClass('core-empty-field');} else {$(this).removeClass('core-empty-field').addClass('core-filled-field');}
		});
		
		if ($('.core-container-container-actionInputField').find('input').val()=="") {notificationCentercore('Some Field is Empty'); return false;}
		
		var folName = $('.core-container-container-actionInputField').find('input').val();
		var folUserId = $('.core-container-container-path').val();

		if($.isNumeric(folUserId)){

		}else{
			folUserId = "";
		}
		var folType = $('.core-headerOfContentInputTypeOfFile').val();
		$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php',{control:"checkDirectory",data:folName,userID:folUserId,mainID:folMainId,type:folType},function(status){
			var transactionType = $('.core-typeOfTransaction').val();
			
			if (transactionType == 'new') {
				var id = $('.core-container-container-idContent').val();
			}
			else if (transactionType == 'after') {
				var id = $('.core-container-container-idContentAfter').val();
				
			}else {
				var id = $('.core-container-container-idContent').val();
				
			}
			
			if(status == 0 && transactionType == 'new'){
				notificationCentercore('Directory Exist, please chose another name !');
				return false;

			}else{
				
				if (id == '' && status != '0' && transactionType == 'new') {
				
					var coreContent2 = [];
				
					$('.core-container-container-actionInputField').find('input,select').each(function(i) {
						coreContent2[i] = $(this).val();
					});
				
					$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {type:$('.core-headerOfContentInputTypeOfFile').val(),content:coreContent2,mainID:folMainId,control:'createDirectory'}, function(data) {
						
						if (data != 1) {
							notificationCentercore('Directory failed to create');  return false;
						}else{
							status = 0;

						}
						
					});

				}

				if ($('.uploadifyQueueItem').length != 0  ) {
						if(status == 0){
					
							var newData = $('.core-contentInside-input').val();
							var oldData = $('.core-headerOfContentInput').val();
							
								if (newData == oldData) {coreData = oldData;} else if (oldData == '') {coreData = newData;} else {coreData = oldData;}

							$('#core-container-file-upload').uploadifySettings( 'scriptData' , { 'myFolder' : coreData});
							var upload = $('#core-container-file-upload').uploadifyUpload();
							
						}

				}else {

					var coreContent = [];
					
					$('.core-container-container-actionInputField').find('input,select').each(function(i) {
					coreContent[i] = $(this).val();
					});
					
					
					 
						if (id != '') {

			      			$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:id,type:$('.core-headerOfContentInputTypeOfFile').val(),del:coreImageDeletedContent,mainID:folMainId,fkid:coreImageDeletedContentFkid,content:coreContent,control:'deleteContentNotContentUser'}, function(data) {
			      			var lastData = $('.core-contentInside-input core-filled-field').val();
			      			
							$('.core-container-container-contentInside').html(data);
							$('.core-image-table tbody tr:even').addClass('core-image-table-even');
							notificationCentercore('Data was saved !');
							coreImageDeletedContent = [];
							var na = $('.core-contentInside-inputNew').val();
								$('.core-contentInside-input').val(na);
								$('.core-headerOfContent').text('- '+na);
								$('.core-image-table tr td input[value="'+id+'"]').parent().parent().find('.core-image-container-tableContentHuge').text(na);
							$('.core-container-file-uploadQueue').remove();	
							var transactionType = $('.core-typeOfTransaction').val();
								if (transactionType == 'new') {
								$('.core-contentInside-submitUser').val('Update');
								uploader('core-container-file-upload',$('.core-headerOfContentInputTypeOfFile').val());
								$('.core-container-container-action').show();
								$('.core-container-container-contentInside').show();
								$('.core-typeOfTransaction').val('after');
								}
								
							});
					
						}
						else if (id == '' && $('.core-typeOfTransaction').val() == 'new' ) {

							$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:id,type:$('.core-headerOfContentInputTypeOfFile').val(),del:coreImageDeletedContent,content:coreContent,control:'deleteContentNotContentUser'}, function(data) {
			      			var lastData = $('.core-contentInside-input core-filled-field').val();
			      			
							$('.core-container-container-contentInside').html(data);
							$('.core-image-table tbody tr:even').addClass('core-image-table-even');
							notificationCentercore('Data was saved !');
							coreImageDeletedContent = [];
							var na = $('.core-contentInside-inputNew').val();
								$('.core-contentInside-input').val(na);
								$('.core-headerOfContent').text('- '+na);
								$('.core-image-table tr td input[value="'+id+'"]').parent().parent().find('.core-image-container-tableContentHuge').text(na);
							$('.core-container-file-uploadQueue').remove();	
							var transactionType = $('.core-typeOfTransaction').val();
								if (transactionType == 'new') {
								$('.core-contentInside-submitUser').val('Update');
								uploader('core-container-file-upload',$('.core-headerOfContentInputTypeOfFile').val());
								$('.core-container-container-action').show();
								$('.core-container-container-contentInside').show();
								$('.core-typeOfTransaction').val('after');
								
								}					
								
							});
						
						}
					 
				}
			
			}
		});
		
	
	});
	
$('.datepicker-from').live('hover',function() {
$('.datepicker-from').datepicker({  
                    defaultDate: '-7d',
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
                       //   minDate: selectedDate,
                       //   maxDate: '+7d'
                        
                      //});
                    }
                  });
            });      
            $('.datepicker-to').live('hover',function() {
                $('.datepicker-to').datepicker({  
                    defaultDate: '+1d -1d',
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
                $('.days-button').live('click', function(){
                $('.core-dashboard-action-container').hide();
                $('.select-days').show();
                  $('.menuDateList span').removeClass('core-date-dashboard-button');
                  $(this).addClass('core-date-dashboard-button');
                  console.log('days');
                });
      
                $('.year-button').live('click', function(){
                $('.core-dashboard-action-container').hide();
                $('.select-year').show();
                $('.core-dashboard-year-container').chosen({disable_search_threshold: 100});
                  $('.menuDateList span').removeClass('core-date-dashboard-button');
                  $(this).addClass('core-date-dashboard-button');
                  console.log('year');
                  });
                  
                $('.featured-dado-button').live('click', function(){
                  var from  = $('.datepicker-content-handler-from').val();
                  var to    = $('.datepicker-content-handler-to').val();
                  var typeOfdate = "days";
      
                  $.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php',{control:'getDadoDashboard', from:from, to:to,typeOfdate:typeOfdate},function(result){
                    $('.javascript-container').html('');
                    $('.javascript-container').html(result);
                  });
                });
               
                $('.featured-dado-button-year').live('click', function(){
                  
                  var year    = $('.core-dashboard-year-container').val();
      
                  $.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php',{control:'getDadoDashboardYear', year:year},function(result){
                    $('.javascript-container').html('');
                    $('.javascript-container').html(result);
                  });
                });
                
                $('.featured-dado-button-user').live('click', function(){
                  var from  = $('.datepicker-content-handler-from').val();
                  var to    = $('.datepicker-content-handler-to').val();
                  var typeOfdate = $('.typeOfdate').val();
      
                  $.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php',{control:'getDadoDashboardUser', from:from, to:to,typeOfdate:'days'},function(result){
                    $('.javascript-container').html('');
                    $('.javascript-container').html(result);
                  });
                });
                
                 $('.featured-dado-button-user-year').live('click', function(){
                 var year    = $('.core-dashboard-year-container').val();
      				
                  $.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php',{control:'getDadoDashboardUserYear', year:year},function(result){
                    $('.javascript-container').html('');
                    $('.javascript-container').html(result);
                  });
                });
                
var coreImageDeletedContent2 = [];

	$('.core-image-actionDelete').live('click', function() {
		var id = $(this).parent().find('input[type="hidden"]').val(); coreImageDeletedContent2.push(id); 
		$(this).parent().parent().remove();
		
	});

	$('.core-profil-submit').live('click', function() {
	
	var array = [];
	
		$('.core-image-container-content table tr').each(function(i) {
		
		array [i] = {};
		
			$(this).find('input,select').each(function(y) {
			
			array [i][y] = $(this).val();
			
			});
		
		});
	
		$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {data:array,del:coreImageDeletedContent2,control:'updateContentNotContent'}, function(data) {		
		coreImageDeletedContent2 = [];
		if(data==""){
			notificationCentercore('Saved !');
		}else{
			notificationCentercore('There was an error ocured ! : \''+data +'\'');
		}
		});
	
	});
	
	$('.core-contentInside-select').live('change',function() {
	
	var data = [];
	
	data[0] = $('.core-container-container-idContent').val();
	data[1] = $(this).val();
	
		$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {data:data,control:'getMultipleLanguageContent'}, function(data) {		
		var result = $.parseJSON(data); 
		$('.core-container-contentInside').find('.core-contentInside-inputContent').val(result.header);
		$('.core-container-contentInside').find('.core-contentInside-inputContent[name="description"]').val(result.desc);
		$('.core-container-contentInside').find('.nicEdit-main').html(result.content);
		});
	
	});
	
	$('.core-profil-submit-main-submenu').live('click',function() {
	
		var value = [];
		value[0]  = $('.core-profil-inputID').val();
		value[1]  = $('.core-profil-input').val();
		value[2]  = $('.core-profil-select').val();
		
		$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {data:value,control:'insertMainSubMenu'}, function(data) {		
		
			if (coreNumber(data)) {
			$('.core-profil-inputID').val(data);
			}
		
		});
	
	});
	
	$('.core-profil-select').live('change',function() {
	
	var value = [];
	value[0]  = $('.core-profil-inputID').val();
	value[1]  = $(this).val();
	
		$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {data:value,control:'getMultipleLanguageMenu'}, function(data) {		
		var result = $.parseJSON(data); 
		$('.core-profil-input').val(result.content);
		//$('.core-container-contentInside').find('.nicEdit-main').html(result.content);
		});

	
	});
	
	$('.core-menu-submit').live('click',function() {
	
	var data = [];
	
		$('.core-menu-table tbody tr').each(function(i) {
		
		data[i] = {};
		
			$(this).find('input,select').each(function(y) {
			
			data[i][y] = $(this).val();
			
			});
		
		data[i][6] = 1;
		data[i][7] = 4;
		data[i][8] = $('.core-menu-select').val();
		
		});
		
		$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {data:data,del:coreDeletedMenu,control:'insertSubMenu'}, function(data) {		
		coreDeletedMenu = [];
		alert(data);
		});
	
	});
	
	$('.core-klasifikasi-submit').live('click',function() {
	
	var data = [];
	
		$('.core-klasifikasi-table tbody tr').each(function(i) {
		
		data[i] = {};
		
			$(this).find('input').each(function(y) {
			
			data[i][y] = $(this).val();
			
			});
		
		data[i][6] = 1;
		data[i][7] = 4;
		data[i][8] = $('.core-klasifikasi-select').val();
		
		});
		console.log(data);
		
		$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {data:data,del:coreDeletedKlasifikasi,control:'insertSubKlasifikasi'}, function(data) {		
		coreDeletedKlasifikasi = [];
		$('.core-klasifikasi-table').parent().html(data);
		if(data.length != 0){
			notificationCentercore("Data Was Saved !!");
		}else{
		notificationCentercore("An Error Occured !!");
		}
		});
	
	});
	
	$('.core-publisher-submit').live('click',function() {
	
	var data = [];
	
		$('.core-publisher-table tbody tr').each(function(i) {
		
		data[i] = {};
		
			$(this).find('input').each(function(y) {
			
			data[i][y] = $(this).val();
			
			});
		
		});
		console.log(data);
		
		$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {data:data,del:coreDeletedKlasifikasi,control:'insertSubPublisher'}, function(data) {		
		coreDeletedKlasifikasi = [];
		$('.core-publisher-container').parent().html(data);
		if(data.length != 0){
			notificationCentercore("Data Was Saved !!");
		}else{
		    notificationCentercore("An Error Occured !!");
		}
		});
	
	});
	
	$('.core-grouping-submit').live('click',function() {
	
	var data = [];
	
		$('.core-grouping-table tbody tr').each(function(i) {
		
		data[i] = {};
		
			$(this).find('input').each(function(y) {
			
			data[i][y] = $(this).val();
			
			});
		
		});
		console.log(data);
		
		$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {data:data,del:coreDeletedKlasifikasi,control:'insertSubGrouping'}, function(data) {		
		coreDeletedKlasifikasi = [];
		$('.core-grouping-container').parent().html(data);
		if(data.length != 0){
			notificationCentercore("Data Was Saved !!");
		}else{
		notificationCentercore("An Error Occured !!");
		}
		});
	
	});
	
$('.core-image-link').live('click',function() {
	var link = $(this).attr('value');
	notificationCentercore(link);
});

/*begin of metadata*/

$('.core-image-metadata').live('click',function() {
//alert('reren');
$('.core-metadata-container').remove();

$('body').append('<div class="core-metadata-container"></div>');

$('.core-metadata-container').hide();
$(this).parent().parent().removeClass('core-image-table-even');
$(this).parent().parent().addClass('coresysten-image-table-tr-hover');

var id 			= $(this).parent().find('input[name="contentID"]').val();;
var idData 		= $('.core-container-container-idContent').val();;
var position 	= $(this).offset();
//alert(idData);

	$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:id,idData:idData,control:'metadata'}, function(data) {	
	
	$('.core-metadata-container').css('top', position.top + 25 + 'px').css('left', position.left - 125 + 'px').draggable().html(data).show();
	
	});

});

var coreMetadataDeleter = [];

$('.core-administrator-itemDetailDeler').live('click',function() {

	$('.core-administrator-content-metadata tr input[type=checkbox]:checked').each(function(i) {
		if ($(this).val() != 'on') {
		coreMetadataDeleter [i] = $(this).val();
		}
	});
$('.core-administrator-content-metadata tr input[type=checkbox]:checked').parent().parent().remove();

});

$('.core-administrator-itemDetailAdder').live('click',function() {
var id   = $('.core-administrator-content-metadata tbody tr:first').find('.core-hidden-metadata-idData').val();
var path = $('.core-administrator-content-metadata tbody tr:first').find('.core-hidden-metadata-realPath').val();

$('.core-administrator-content-metadata tr:last').after("<tr><td><input type='checkbox'></td><td><input class='core-hidden-metadata-idData' type='hidden' value='"+id+"'><input type='text'></td><td><input type='text'><input class='core-hidden-metadata-realPath' type='hidden' value='"+path+"'></td></tr><tr><td colspan=3><hr></td></tr>");
});

$('.core-administrator-metadataCancel').live('click',function() {
$('.core-metadata-container').remove();
$('.coresysten-image-table-tr-hover').addClass('core-image-table-even');
$('.core-image-table tbody tr').removeClass('coresysten-image-table-tr-hover');
});

$('.core-administrator-setShowCancel').live('click',function() {

	$('.core-klasifikasi-actionSetTime-container').remove();
$('.coresysten-image-table-tr-hover').addClass('core-image-table-even');
$('.core-image-table tbody tr').removeClass('coresysten-image-table-tr-hover');
});

$('.core-administrator-metadataSubmit').live('click',function() {

var id = getInputDataFromTableRow('.core-administrator-content-metadata tbody');

	$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:id,del:coreMetadataDeleter,control:'saveMetadata'}, function(data) {
	coreMetadataDeleter = [];
	
	$('.core-metadata-container').remove();
	});

});




/*end of metadata*/

/*begin of tagging*/

$('.core-image-tagging').live('click',function() {
//alert('reren');
$('.core-tagging-container').remove();

$('body').append('<div class="core-tagging-container"></div>');

$('.core-tagging-container').hide();

var id 			= $(this).parent().parent().find('input[name="FKID"]').val();;
var position 	= $(this).offset();
//alert(idData);
$(this).parent().parent().removeClass('core-image-table-even');
$(this).parent().parent().addClass('coresysten-image-table-tr-hover');
	$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:id,control:'tagging'}, function(data) {	
	
	$('.core-tagging-container').css('top', position.top + 25 + 'px').css('left', position.left - 125 + 'px').draggable().html(data).show();
	
	});

});

$('.core-image-showTagging').live('click',function() {
//alert('reren');
$('.core-tagging-container').remove();

$('body').append('<div class="core-tagging-container"></div>');

$('.core-tagging-container').hide();

var id 			= $(this).parent().parent().find('input[name="itemID"]').val();;
var position 	= $(this).offset();
//alert(idData);

	$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:id,control:'showTagging'}, function(data) {	
	
	$('.core-tagging-container').css('top', position.top + 25 + 'px').css('left', position.left - 125 + 'px').draggable().html(data).show();
	
	});

});

$('.core-image-tagging').live('click',function() {
//alert('reren');
$('.core-tagging-container').remove();

$('body').append('<div class="core-tagging-container"></div>');

$('.core-tagging-container').hide();

var id 			= $(this).parent().parent().find('input[name="FKID"]').val();;
var position 	= $(this).offset();
//alert(idData);

	$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:id,control:'tagging'}, function(data) {	
	
	$('.core-tagging-container').css('top', position.top + 25 + 'px').css('left', position.left - 125 + 'px').draggable().html(data).show();
	
	});

});

$('.core-klasifikasi-actionSetTime').live('click',function() {
//alert('reren');
$('.core-klasifikasi-actionSetTime-container').remove();

$('body').append('<div class="core-klasifikasi-actionSetTime-container"></div>');

$('.core-klasifikasi-actionSetTime-container').hide();

var id 			= $(this).parent().find('.core-klasifikasi-inputRealID').val();;
var position 	= $(this).offset();
//alert(idData);
console.log(id);
	$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:id,control:'setRetensiWaktu'}, function(data) {	
	
	$('.core-klasifikasi-actionSetTime-container').css('top', position.top + 25 + 'px').css('left', position.left - 125 + 'px').draggable().html(data).show();
	
	$('.core-tagging-contentFKID').val(id);
	
	});

});

$('.core-klasifikasi-actionSetShow').live('click',function() {
//alert('reren');
$('.core-klasifikasi-actionSetShow-container').remove();

$('body').append('<div class="core-klasifikasi-actionSetShow-container"></div>');

$('.core-klasifikasi-actionSetShow-container').hide();

var id 			= $(this).parent().find('.core-klasifikasi-inputRealID').val();;
var position 	= $(this).offset();
//alert(idData);
console.log(id);
	$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:id,control:'setShow'}, function(data) {	
	
	$('.core-klasifikasi-actionSetShow-container').css('top', position.top + 25 + 'px').css('left', position.left - 125 + 'px').draggable().html(data).show();
	
	$('.core-tagging-contentFKID').val(id);
	
	});

});

$('.core-image-content-actionSetShow').live('click',function() {
//alert('reren');
$('.core-klasifikasi-actionSetShow-container').remove();

$('body').append('<div class="core-klasifikasi-actionSetShow-container"></div>');

$('.core-klasifikasi-actionSetShow-container').hide();

var id 			= $(this).parent().find('input[name="FKID"]').val();;
var position 	= $(this).offset();
//alert(idData);
console.log(id);

$(this).parent().parent().removeClass('core-image-table-even');
$(this).parent().parent().addClass('coresysten-image-table-tr-hover');
	$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:id,control:'setShowContent'}, function(data) {	
	
	$('.core-klasifikasi-actionSetShow-container').css('top', position.top + 25 + 'px').css('left', position.left - 125 + 'px').draggable().html(data).show();
	
	$('.core-tagging-contentFKID').val(id);
	
	});

});

$('.core-administrator-showCancel').live('click',function() {
$('.core-klasifikasi-actionSetShow-container').remove();
$('.coresysten-image-table-tr-hover').addClass('core-image-table-even');
$('.core-image-table tbody tr').removeClass('coresysten-image-table-tr-hover');
});

$('.core-administrator-showSubmit').live('click', function(){

	var data = []; 
	
	$('.core-administrator-content-setShow').find('input,select').each(function(i){
		data [i] = $(this).val();
	});
	
	var id = $('.core-tagging-contentFKID').val();
	
	console.log(data);
	
	$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:id,data:data,control:'saveSetShow'}, function(data) {	
	
	$('.core-klasifikasi-actionSetShow-container').remove();
	
	});
	
});

$('.core-administrator-showSubmitContent').live('click', function(){

	var data = []; 
	
	$('.core-administrator-content-setShow').find('input,select').each(function(i){
		data [i] = $(this).val();
	});
	
	var id = $('.core-tagging-contentFKID').val();
	
	console.log(data);
	
	$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:id,data:data,control:'saveSetShowContent'}, function(data) {	
	
	if(data == ""){
		notificationCentercore("Data Was Saved !");
	}else{
		notificationCentercore(data);
	}
	
	
	$('.core-klasifikasi-actionSetShow-container').remove();
	
	});
	
});

$('.core-administrator-retensiSubmit').live('click', function(){

	var data = []; 
	
	$('.core-administrator-content-tagging').find('input').each(function(i){
		data [i] = $(this).val();
	});
	var id = $('.core-tagging-contentFKID').val();
	console.log(data);
	
	$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:id,data:data,control:'saveRetensiWaktu'}, function(data) {	
	
	$('.core-klasifikasi-actionSetTime-container').remove();
	
	});
	
});

$('.core-administrator-retensiContentSubmit').live('click', function(){

	var data = []; 
	
	$('.core-administrator-content-tagging').find('input').each(function(i){
		data [i] = $(this).val();
	});
	var id = $('.FKID').val();
	console.log(data);
	
	$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:id,data:data,control:'saveRetensiWaktuContent'}, function(data) {	
	
	
	
	$('.core-klasifikasi-actionSetTime-container').remove();
	
	
	});
	
});



$('.core-image-content-actionSetTime').live('click',function() {
//alert('reren');
$('.core-klasifikasi-actionSetTime-container').remove();

$('body').append('<div class="core-klasifikasi-actionSetTime-container"></div>');

$('.core-klasifikasi-actionSetTime-container').hide();

var id 			= $(this).parent().find('input[name="FKID"]').val();;
var position 	= $(this).offset();
//alert(idData);
console.log(id);


$(this).parent().parent().removeClass('core-image-table-even');
$(this).parent().parent().addClass('coresysten-image-table-tr-hover');
	$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:id,control:'setRetensiWaktuContent'}, function(data) {	
	
	$('.core-klasifikasi-actionSetTime-container').css('top', position.top + 25 + 'px').css('left', position.left - 125 + 'px').draggable().html(data).show();
	$('.core-tagging-contentFKID').val(id);
	});

});





$('.core-image-showTagging').live('click',function() {
//alert('reren');
$('.core-tagging-container').remove();

$('body').append('<div class="core-tagging-container"></div>');

$('.core-tagging-container').hide();

var id 			= $(this).parent().parent().find('input[name="itemID"]').val();;
var position 	= $(this).offset();
//alert(idData);

	$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:id,control:'showTagging'}, function(data) {	
	
	$('.core-tagging-container').css('top', position.top + 25 + 'px').css('left', position.left - 125 + 'px').draggable().html(data).show();
	
	});

});
var coreMetadataDeleter = [];

$('.core-administrator-itemDetailDeler').live('click',function() {

	$('.core-administrator-content-tagging tr input[type=checkbox]:checked').each(function(i) {
		if ($(this).val() != 'on') {
		coreMetadataDeleter [i] = $(this).val();
		}
	});
$('.core-administrator-content-tagging tr input[type=checkbox]:checked').parent().parent().remove();

});

$('.core-administrator-itemDetailAdder').live('click',function() {
var id   = $('.core-administrator-content-tagging tbody tr:first').find('.core-hidden-tagging-idData').val();
var path = $('.core-administrator-content-tagging tbody tr:first').find('.core-hidden-tagging-realPath').val();

$('.core-administrator-content-tagging tr:last').after("<tr><td><input type='checkbox'></td><td><input class='core-hidden-tagging-idData' type='hidden' value='"+id+"'><input type='text'></td><td><input type='text'><input class='core-hidden-tagging-realPath' type='hidden' value='"+path+"'></td></tr><tr><td colspan=3><hr></td></tr>");
});

$('.core-administrator-taggingCancel').live('click',function() {
$('.core-tagging-container').remove();
$('.coresysten-image-table-tr-hover').addClass('core-image-table-even');
$('.core-image-table tbody tr').removeClass('coresysten-image-table-tr-hover');
});


$('.core-administrator-taggingSubmit').live('click',function() {

var id = getInputDataFromTableRow('.core-administrator-content-tagging tbody');

	$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:id,control:'saveTagging'}, function(data) {
	
	
	$('.core-tagging-container').remove();
	});

});



/*end of tagging*/




/*LibraryDado*/

$('.layan-libraryFilter-4-input-core').live('click', function() {
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
		
		$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {data:data,control:'getLibraryContent'}, function(result) {
				
			console.log(result);
			
			$(ths).val('Cari');
			
			$('.layan-library-content-container').html(result);
							
		});
		
	return false;	
	
	});

/*EndLibrary*/





/*begin of klasifikasi*/

$('.core-image-classification').live('click',function() {
//alert('reren');
$('.core-classification-container').remove();

$('body').append('<div class="core-classification-container"></div>');

$('.core-classification-container').hide();

var id = $(this).parent().find('input[name="FKID"]').val();
var position 	= $(this).offset();

$(this).parent().parent().removeClass('core-image-table-even');
$(this).parent().parent().addClass('coresysten-image-table-tr-hover');
	
	$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:id,control:'classification'}, function(data) {	
	
	$('.core-classification-container').css('top', position.top + 25 + 'px').css('left', position.left - 125 + 'px').draggable().html(data).show();
	
	});

});

$('.core-administrator-classificationCancel').live('click',function() {
$('.core-classification-container').remove();
$('.coresysten-image-table-tr-hover').addClass('core-image-table-even');
$('.core-image-table tbody tr').removeClass('coresysten-image-table-tr-hover');
});

$('.core-administrator-classificationSubmit').live('click',function() {

var id = [];
 $('.core-administrator-content-classification tbody').find('input, select').each(function(i){
	id [i] = $(this).val();
});

	$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:id,control:'saveClassification'}, function(data) {
	
	
	$('.core-classification-container').remove();
	});

});

function getInputDataFromTableRow (tableName) {

var array = [];	
	
	$(tableName).find('tr').each(function(i) {
	array [i] = {};
	
		$(this).find('input,select').each(function(y) {
		array [i][y] = $(this).val();
		});

	});
	
return array;

}

$('.draggableKlasifikasi').live('mouseover', function() {

	$(".draggableKlasifikasi").draggable({
		helper: 'clone',
		handle: '.core-draggableHandler',
		revert: 'invalid',
		axis: 'y',
		containment: 'parent',
		start: function (e, ui) {
		var myID 		= $(this).find('input[type=checkbox]').val();
		var childNumber = $('input[name="parentID"][value='+myID+']').length;
		},
		stop: function (e, ui) {
		
		}
	}).disableSelection();
		
	$('.draggableKlasifikasi').droppable({
		hoverClass: "capsuleContainerHover",
		accept: ".draggableKlasifikasi",
		drop: function (e, ui) {
			
			var helperParent = ui.helper.find('input[name="parentID"]').val();
			var helperText   = ui.helper.find('input.core-inputInherit').val();
			var helperText1   = ui.helper.find('input.core-inputInherit1').val();
			var helperText2   = ui.helper.find('input.core-inputInherit2').val();
			var helperText3   = ui.helper.find('input.core-inputInherit3').val();
			var helperID	 = ui.helper.find('input[name=currentID]').val();
			var myID 		 = ui.helper.find('input[name=currentID]').val();
			var childNumber  = $('input[name="parentID"][value='+myID+']').length;
			
				if (childNumber != 0) {
				notificationCentercore('Warning! '+ui.helper.find('.core-inputInherit').val()+' has child. Remove all the child if you want to move it.');
				return false;
				}
			
			if (ui.helper.find('img.childKlasifikasi').length != 1) {
			var helperHTML	 = ui.helper.find('.myStyles').html('');
			
			var	helperHTML 	 = ui.helper.find('.myStyles').html("<img class='childKlasifikasi' src='/'+adminCoreFolder+'/library/capsule/core/images/rowChild.png'>");
			}
			
			var theID		 = $(this).find('input[name=currentID]').val();
			var isChild 	 = $(this).find('td.myStyles img').length;
			
			if (helperID == theID) {return false;}
			
			//Setting new parent id
			var parentID = $(this).find('input[name="currentID"]').val();
			var myStyles = $(this).find('td.myStyles').attr('padding');
			if (myStyles == '0') {var myStyles = 10;} else {var myStyles = parseInt(myStyles)+10;}
			ui.helper.find('td.myStyles').attr('style','padding-left: '+myStyles+'px'); ui.helper.find('td.myStyles').attr('padding',myStyles);
			var final	= "<tr class='draggableKlasifikasi'>"+ui.helper.html()+"</tr>";
			var locate	= $(this).closest("tr.draggableKlasifikasi").prevAll("tr.draggableKlasifikasi").length ; 
			$(this).parent().parent().find('tr.draggableKlasifikasi').eq(locate).after(final); 
			$(this).parent().parent().find('tr.draggableKlasifikasi').eq(locate+1).find('input[name="parentID"]').val(parentID);
			$(this).parent().parent().find('tr.draggableKlasifikasi').eq(locate+1).find('input.core-inputInherit').val(helperText);
			
			$(this).parent().parent().find('tr.draggableKlasifikasi').eq(locate+1).find('input.core-inputInherit1').val(helperText1);
			
			$(this).parent().parent().find('tr.draggableKlasifikasi').eq(locate+1).find('input.core-inputInherit2').val(helperText2);
			
			$(this).parent().parent().find('tr.draggableKlasifikasi').eq(locate+1).find('input.core-inputInherit3').val(helperText3);
			
			ui.helper.remove(); ui.draggable.remove();
			}
		});
});


/*end of klasifikasi*/


/*list IP*/
$('.core-listInformasiPublik-tbody-tr-klas').live('click', function() {  
	var currentID = $(this).find('input[name="currentID"]').val();
	var lenthChild = $('input[value='+currentID+'][name="parentID"]').parent().find('input[name="currentID"]').length;
	var getChildId = $('input[value='+currentID+'][name="parentID"]').parent().find('input[name="currentID"]').map(function(){return $(this).val();}).get();
	//alert(getChildId);
	$('input[value='+currentID+'][name="parentID"]').parent().parent().toggle('fast');
	$('input[value='+currentID+'][name="currentID"]').parent().find('span').toggleClass('core-image-actionMinus core-image-minus');
	var i;
	for(i = 0; i <= lenthChild; i++){
		$('input[value='+getChildId[i]+'][name="parentID"]').parent().parent().hide('fast');
		
		var lenthChildinChild = $('input[value='+getChildId[i]+'][name="parentID"]').parent().find('input[name="currentID"]').length;
		if(lenthChildinChild > 0){
			
			var getChildIdChild = $('input[value='+currentID+'][name="parentID"]').parent().find('input[name="currentID"]').map(function(){return $(this).val();}).get();
			recursiveCollapse(getChildIdChild, lenthChildinChild);
		}
	}
});
function recursiveCollapse(data, length) {
	var i; 
	for(i = 0; i <= length; i++){
		$('input[value='+data[i]+'][name="parentID"]').parent().parent().hide('fast');
		var lenthChildinChild = $('input[value='+data[i]+'][name="parentID"]').parent().find('input[name="currentID"]').length;
		if(lenthChildinChild > 0){
			var getChildId = $('input[value='+data[i]+'][name="parentID"]').parent().find('input[name="currentID"]').map(function(){return $(this).val();}).get();
			recursiveCollapse(getChildId, lenthChildinChild);
		}	
	}
}
/*end list IP*/



$(".searchOnTheFly-searchInput").live('keyup',function() { 

	var inputSearch = $('input[name="searchOnTheFly-searchInput"]').val();
	
	$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php',{data:inputSearch,control:'searchOnTheFly'},function(result){
		$('.searchOnTheFly-resultContainer').html(result);
	});

 });
var setDeletedMetadata = [];
$('.admin-setMetadata-setMetadataSubmit').live('click', function(){
	var data = [];

	$('.admin-administrator-content-setmetadata tbody tr').each(function(i){
		data[i] = {};

		$(this).find('input').each(function(y){
			data[i][y] = $(this).val();
		});
	});
	console.log(data);
	$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php',{control:'setDefaultMetadata',data:data,del:setDeletedMetadata},function(result){
		$('.admin-administrator-content-setmetadata').parent().html(result);
		if(result != ""){
			notificationCentercore('Data Was Saved !');
		}else{
			notificationCentercore('There is an error ocurred !');
		}
	});
});

$('.core-setMetadata-actionDelete').live('click',function() {
		var row = $(this).parent().parent().parent().parent().find('tbody tr').length;
		
		var id  = $(this).parent().parent().find('.core-setMetadata-inputRealID').val();
		
		if (row == 1) {
		$(this).parent().parent().parent().parent().find('tbody tr:last input[type="text"]').val('');
		}
		else {
		$(this).parent().parent().remove();
		}
		if(id != undefined || id != ""){
			setDeletedMetadata.push(id); 
			//console.log(setDeletedMetadata);
		}
	
			
	});

$('.core-profil-saveButton').live('click',function(){
	var control = 'editUser';
	var id 		= getInputDataFromForm('#administrator-user-edit');

	$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:id,control:control}, function(data) {
	console.log(data);
		if (data == 'New User Email, Username and Password Cannot be Empty!' || data == 'Existing User Email, Username and Password Cannot be Empty!') {
		notificationCentercore(data); return false;
		}
	notificationCentercore("Users saved!"); //$('.admin-popUpMenu').html(data);
	$('.administrator-select').chosen();
	});
});

function getInputDataFromForm (formName) {

var array = {};	
var name  = '';

	$(formName).find('input[type=text],input[type=hidden],input[type=password],input[type=checkbox]:checked,select').each(function(i) {
	
		if ($(this).attr('id') != undefined) {
		
			array [$(this).attr('id')] = $(this).val();
			
		}
	
	});
	
return array;

}

function uploader(id,type) {
	//alert($('.core-container-container-idContentFKID').val());
	
	var idUser = $('.core-container-container-path').val();
	var domain = $('.core-container-container-mainid').val();
	/*if(idUser == undefined || idUser == '' ||idUser == null ){
	
		idUser = $('.user-name-normal').attr('SSID');
	}
	console.log(idUser);*/
	console.log(domain);
	
	$('#'+id).uploadify({
	    	'uploader'  	: '/'+adminCoreFolder+'/library/plugins/uploadifyOld/uploadify.swf',
	    	'script'  		: '/'+adminCoreFolder+'/library/capsule/core/core.ajax.php',
	    	'cancelImg' 	: '/'+adminCoreFolder+'/library/plugins/uploadify/uploadify-cancel.png',
	  		'auto'      	: false,
	  		'multi'			: true,
	  		'buttonText'	: 'Select Files',
	  		'scriptData'  	: 
	  			{
	  			"control"	: 'uploadItem',
	       		"type"	 	: type,
	       		"myID"		: idUser,
	       		"myMainID"	: domain,
	       		"myFolder" 	: $('.core-contentInside-input').val(),
	       		"conId"		: $('.core-container-container-idContentFKID').val()
	  			},
	  		'onComplete'  : function(event, ID, fileObj, response, data) {
	  			notificationCentercore(response);
	      		//alert('There are ' + data.fileCount + ' files remaining in the queue.');
	   		 	},
	  		'onAllComplete' : function(event,data) {
	  		var coreContent = [];
		
			$('.core-container-container-actionInputField').find('input,select').each(function(i) {
			coreContent[i] = $(this).val();
			});
			
			var transactionType = $('.core-typeOfTransaction').val();
		
			if (transactionType == 'new') {
			var id = $('.core-container-container-idContent').val();
			}
			//else if (transactionType == 'after') {
			//var id = $('.core-container-container-idContentAfter').val();
			//}
			else {
			var id = $('.core-container-container-idContent').val();
			}
			
			$('.core-container-container-contentInside').html('Loading..')
				//alert(transactionType); alert(id);
      		$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {id:id,type:type,del:coreImageDeletedContent,content:coreContent,control:'deleteContentNotContent'}, function(data) {		
      		//if (data == 'failed') {notificationCentercore('Update Failed'); return false;}
			$('.core-container-container-contentInside').html(data);
			$('.core-image-table tbody tr:even').addClass('core-image-table-even');
			coreImageDeletedContent = [];
			var na = $('.core-contentInside-inputNew').val();
				$('.core-contentInside-input').val(na);
				$('.core-headerOfContent').text('- '+na);
				$('.core-image-table tr td input[value="'+id+'"]').parent().parent().find('.core-image-container-tableContentHuge').text(na);
			$('.core-container-file-uploadQueue').remove();		
			var transactionType = $('.core-typeOfTransaction').val();
					if (transactionType == 'new') {
					$('.core-contentInside-submit').val('Update');
					$('.core-typeOfTransaction').val('after');
					}
			});
    		}

	});
	
}
$(document).ready(function(){			
				uploaderPhoto('core-container-file-uploadPhoto');
				$('.adminCore-select').chosen();
			});
function uploaderPhoto(id) {
	//alert($('.core-container-container-idContentFKID').val());
	var idUser = $('.core-container-container-path').val();
	if(idUser == undefined || idUser == '' ||idUser == null ){
	
		idUser = $('.user-name-normal').attr('SSID');
	}
	console.log(idUser);
	
	$('#'+id).uploadify({
	    	'uploader'  	: '/'+adminCoreFolder+'/library/plugins/uploadifyOld/uploadify.swf',
	    	'script'  		: '/'+adminCoreFolder+'/library/capsule/core/core.ajax.php',
	    	'cancelImg' 	: '/'+adminCoreFolder+'/library/plugins/uploadify/uploadify-cancel.png',
	  		'auto'      	: true,
	  		'multi'			: false,
	  		'buttonText'	: 'Select Files',
	  		'scriptData'  	: 
	  			{
	  			"control"	: 'uploadPhotoProfil',
	       		"myID" 	 	: idUser,
	       		"myFolder" 	: $('.core-contentInside-input').val(),
	       		"conId"		: $('.core-container-container-idContentFKID').val()
	  			},
	  		'onComplete'  : function(event, ID, fileObj, response, data) {
	  			notificationCentercore(response);
	      		//alert('There are ' + data.fileCount + ' files remaining in the queue.');
	   		 	},
	  		'onAllComplete' : function(event,data) {
	  				
			$('.core-image-handler').html('Loading..')
				//alert(transactionType); alert(id);
      		$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php', {userID:idUser,control:'getImageUploaded'}, function(data) {		
      		//if (data == 'failed') {notificationCentercore('Update Failed'); return false;}
			$('.core-image-handler').html(data);
			});
    		}

	});
	
}

function notificationCentercore(notification) {
var container = "<div class='globalNotificationCenter'>"+notification+"</div>";
$('.globalNotificationCenter').remove(); $('body').append(container); 
	$('.globalNotificationCenter').hide().fadeIn('slow',function () {
		setTimeout(function() {
 		$('.globalNotificationCenter').fadeOut(3000);
		}, 5000 );
	});
}

function coreNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}



$('.featured-dado-button-print-chart').live('click',function() {
	
	$('.core-dashboard-all-wrapper').printElement({
	overrideElementCSS:['/'+adminCoreFolder+'/library/capsule/core/css/print.css']
	});
	
});

$('.core-image-comment').live('click', function(){
	
	var id = $(this).parent().find('contentID').val();
	console.log(id);
	
	$('.core-container-contentInside').html('Loading...');
	$('.core-image-container-content').hide();
	$('.core-container-contentInsideActionButton').hide();
	$.post('/'+adminCoreFolder+'/library/capsule/core/core.ajax.php',{control:'commentManagement', data:id},function(data){
		$('.core-container-contentInside').html(data);
		$('.core-container-contentInside').show();
	});
	
});

});

	
});
