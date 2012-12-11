/**
 * Minicon Capsule
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@asacreative.com so we can send you a copy immediately.
 *
 * @category   Capsule Javascript
 * @package    Minicon
 * @copyright  Copyright (c) 09-12-2012 Asacreative Technology Indonesia (http://www.asacreative.com)
 * @license    New BSD License
 * @version    Id: minicon.js 100 Ridwan Abadi $
 * @since      Minicon 0.1
 */		
			
jQuery.noConflict()(function($){

	$(document).ready(function() {
	
	/*
    * accountingInit - start the function after document ready
    *
    * @var    deleteAccount
    * @param  void
    * @return void
    */	
	miniconInit();
		
		/*
	    * accountingInit - start the function after document ready
	    *
	    * @var    deleteAccount
	    * @param  void
	    * @return void
	    */
		function miniconInit() {
			
			/*
		    * accountingInit - start the function after document ready
		    *
		    * @var    deleteAccount
		    * @param  void
		    * @return void
		    */
			var path = $('#adminContainer').attr('data-folder');
			
			/*
		    * accountingInit - start the function after document ready
		    *
		    * @var    deleteAccount
		    * @param  void
		    * @return void
		    */
			bkLib.onDomLoaded(function() {
			
				var myNicEditor = new nicEditor({
				
					iconsPath: '/' + path + '/library/plugins/nicEdit/nicEditorIcons.gif',
					
					buttonList: ['bold', 'italic', 'underline', 'left', 'center', 'right', 'justify', 'ol', 'ul', 'fontSize', 'fontFamily', 'fontFormat', 'image', 'link', 'forecolor', 'xhtml']
					
				});
				
				myNicEditor.setPanel('minicon-content-textarea-panel');
				
				myNicEditor.addInstance('minicon-content-textarea');
				
				$('#minicon-content-textarea').parent().find('div.nicEdit-main').width('99.7%');
				
				$('#minicon-content-textarea').parent().find('div.nicEdit-main').parent().width('99.7%');
				
				$('#minicon-content-textarea').parent().find('div.nicEdit-main').parent().css('background-color','white');
												
			})
			
			/*
		    * accountingInit - start the function after document ready
		    *
		    * @var    deleteAccount
		    * @param  void
		    * @return void
		    */
			$('.minicon-content-select').chosen();
			
			/*
		    * accountingInit - start the function after document ready
		    *
		    * @var    deleteAccount
		    * @param  void
		    * @return void
		    */
			$('#minicon-content-date').datepicker();
			
			/*
		    * accountingInit - start the function after document ready
		    *
		    * @var    deleteAccount
		    * @param  void
		    * @return void
		    */
			$('#minicon-content-status-submit').live('click',function() {
				
				var arr  = [];
				
				$('form#minicon-content-form .minicon-post:visible').each(function(i) {
					
					var id = $(this).attr('data-post');
					console.log(id);
					if (typeof id !== 'undefined') {
					
						arr[id] = $(this).val();
					
					}
										
				});
				
				console.log(arr);
				
				var capsule = { "data":arr, "control": "status_update", "capsuleCSRFToken": $('#capsuleCSRFToken').val()};
								
				var request = $.ajax({
				
				  url: "/cornc/library/capsule/minicon/minicon.ajax.php",
				  
				  type: "POST",
				  
				  data: {data:capsule},
				  
				  dataType: "json"
				  
				});
				
				request.done(function(msg) {
				
					console.log(msg);
										
				});
				
				request.fail(function(jqXHR, textStatus) {
				
					console.log(jqXHR);
					
				});
				
				return false;
				
			})
			
			/*
		    * accountingInit - start the function after document ready
		    *
		    * @var    deleteAccount
		    * @param  void
		    * @return void
		    */
			$('#minicon-content-article-submit').live('click',function() {
				
				return false;
				
			})
		
		}
		
	})
	
})