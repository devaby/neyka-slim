
/**
 * Accounting Capsule
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@asacreative.com so we can send you a copy immediately.
 *
 * @category   Capsule
 * @package    Accounting
 * @copyright  Copyright (c) 2012 Asacreative Technology Indonesia (http://www.asacreative.com)
 * @license    New BSD License
 * @version    $Id: accounting.js 100 Ridwan Abadi $
 * @since      Accounting 0.1
 */

jQuery.noConflict()(function($) {

	$(document).ready(function() {
		
	adminInit();
		
		/*
	    * adminInit - start the function after document ready
	    *
	    * @var    deleteAccount
	    * @param  void
	    * @return void
	    */
		function adminInit() {
			
			/*
		    * ajax - start the function after document ready
		    *
		    * @var    deleteAccount
		    * @param  void
		    * @return void
		    */
			function ajax(data,fetch,type,control,async) {
							
				var respons = [];

				var async   = (typeof async === 'undefined') ? false : async;
																	
				var absPath = $('#adminContainer').attr('data-folder');
				
				var include	= 'library/capsule/admin/admin.main.php';
				
				var request = $.ajax({
					
					url  	 : '/' + absPath + '/library/capsule/admin/admin.ajax.php',
					
					type 	 : fetch,
					
					async	 : async,
					
					data 	 : {id:data,incl:include,control:control},
					
					dataType : type
				
				})
				
				request.done(function(data,textStatus,jqXHR) {
										
					respons.push({'done':data});		
																
				})
				
				request.fail(function(jqXHR,textStatus) {
				
					respons.push({'fail':textStatus});			
				
				})
													
			return respons;
			
			}
			
			/*
		    * search method - start the function after document ready
		    *
		    * @var    deleteAccount
		    * @param  void
		    * @return void
		    */
			$('.admin-search-dispatcher').live('click', function() {
				
				var texts  = $(this).parent().find('input').val();
				
				var locate = $('.admin-popUpMenu table').attr('class');

				if (locate == 'admin-sitesSet') {
					
					var result = ajax(texts,'post','html','admin/search' + locate);
				
					$('.admin-popUpMenu table').replaceWith(result[0]['done']);
				
				}
				
				else if (locate == 'admin-subSitesSet') {
					
					var sites  = $('.admin-menuChooserContainer .administrator-select-global-site').val();
					
					var result = ajax([texts,sites],'post','html','admin/search' + locate);
				
					$('.admin-popUpMenu table').replaceWith(result[0]['done']);
					
				}
				
				else if (locate == 'admin-userSet') {
					
					var sites  = $('.admin-menuChooserContainer .administrator-select-global-site-user').val();
					
					var result = ajax([texts,sites],'post','html','admin/search' + locate);

					$('.admin-popUpMenu table').replaceWith(result[0]['done']);
					
				}
																		
			})
					
		}
			
	})
	
})