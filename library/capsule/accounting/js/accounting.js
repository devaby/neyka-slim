
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

jQuery.noConflict()(function($){

	$(document).ready(function() {
		
	accountingInit();
		
		/*
	    * accountingInit - start the function after document ready
	    *
	    * @var    deleteAccount
	    * @param  void
	    * @return void
	    */
		function accountingInit() {
			
			var deleteAccount = '';
			var deleteItem = '';
			var deleteTransactionLineItem = [];
			
			/*
		    * Chosen Selector - bootstrap event starter
		    *
		    * @var    show
		    * @param  name,event
		    * @action controller for bootstrap event binder
		    * @return void
		    */
			$('.accounting-chosen').chosen();
						
			/*
		    * banker's rounding - rounding in compliance with the IEEE 754 rule
		    * created by Tim Down in stack overflow
		    *
		    * @param  num,decimalPlaces
		    * @action controller for bootstrap event binder
		    * @return float
		    */
			function bankerRound(num, decimalPlaces) {
			    var d = decimalPlaces || 0;
			    var m = Math.pow(10, d);
			    var n = +(d ? num * m : num).toFixed(8); // Avoid rounding errors
			    var i = Math.floor(n), f = n - i;
			    var r = (f == 0.5) ? ((i % 2 == 0) ? i : i + 1) : Math.round(n);
			    return d ? r / m : r;
			}
			
			/* bankers rounding - rounding in compliance with the IEEE 754 rule
		    * created by Tim Down in stack overflow
		    *
		    * @param  num,decimalPlaces
		    * @action controller for bootstrap event binder
		    * @return float
		    */
			
			function decimalPlaces(num) {
			  var match = (''+num).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
			  if (!match) { return 0; }
			  return Math.max(
			       0,
			       // Number of digits right of decimal point.
			       (match[1] ? match[1].length : 0)
			       // Adjust for scientific notation.
			       - (match[2] ? +match[2] : 0));
			}
			
			/**
			 * Function that could be used to round a number to a given decimal points. Returns the answer
			 * Arguments :  number - The number that must be rounded
			 *				decimal_points - The number of decimal points that should appear in the result
			 */
			function roundNumber(number,decimal_points) {
				if(!decimal_points) return Math.round(number);
				if(number == 0) {
					var decimals = "";
					for(var i=0;i<decimal_points;i++) decimals += "0";
					return "0."+decimals;
				}
			
				var exponent = Math.pow(10,decimal_points);
				var num = Math.round((number * exponent)).toString();
				return num.slice(0,-1*decimal_points) + "." + num.slice(-1*decimal_points)
			}
			
			/*
		    * banker's rounding - rounding in compliance with the IEEE 754 rule
		    * created by Tim Down in stack overflow
		    *
		    * @param  num,decimalPlaces
		    * @action controller for bootstrap event binder
		    * @return float
		    */
			function taxCalculation(amount, taxrate, decimal) {
			
			decimal = typeof decimal !== 'undefined' ? decimal : 2;
			
			var y = roundNumber( amount * taxrate / 100 , 3);

			    y = Number(y).toFixed(decimal);

			return y;
			    
			}
			
			/*
		    * Asa rounding - rounding in compliance with the IEEE 754 rule
		    * created by Tim Down in stack overflow
		    *
		    * @param  num,decimalPlaces
		    * @action controller for bootstrap event binder
		    * @return float
		    */
			function asaRounding(num,decimalPlaces) {
										 
			var d = decimalPlaces || 0;
		    var m = Math.pow(10, d);
		    var n = +(d ? num * m : num).toFixed(8); // Avoid rounding errors
		    var i = Math.floor(n), f = n - i;
		    var r = (f == 0.5) ? ((i % 1 == 0) ? i : i + 1) : Math.round(n);
		    return d ? r / m : r;
						
			}

			/*
		    * banker's rounding - rounding in compliance with the IEEE 754 rule
		    * created by Tim Down in stack overflow
		    *
		    * @param  num,decimalPlaces
		    * @action controller for bootstrap event binder
		    * @return float
		    */
			function discountCalculation(amount, discountrate) {
										 
			var totalDiscount = (amount) * ((100 - discountrate) / 100); 
			
			totalDiscount = Math.round(totalDiscount*100)/100;
						
			return Math.round((amount-totalDiscount)*100)/100;
						
			}
			
			/*
		    * displayModal - bootstrap event starter
		    *
		    * @var    show
		    * @param  name,event
		    * @action controller for bootstrap event binder
		    * @return void
		    */
			function displayModal(name,event) {
				
				var show = (event == 'show') ? true : false;
				
				$('#'+name).modal({
				
					keyboard : true,
					show	 : event
					
				}).css({
				
			        width: 'auto',
			        'margin-left': function () {return -($(this).width() / 2);}
			        
			    });
			
			}
			
			/*
		    * closeModal - bootstrap event starter
		    *
		    * @var    show
		    * @param  name,event
		    * @action controller for bootstrap event binder
		    * @return void
		    */
			function closeModal(name,event) {
				
				var hide = (event == 'hide') ? 'hide' : false;
				
				$('#'+name).modal(hide);
			
			}
			
			/*
		    * is_array - checking if object is an array
		    *
		    * @return true
		    */
			function is_array(input){
			    
			    return typeof (input) =='object' && (input instanceof Array);
			    
			}

			/*
		    * displayModal - bootstrap event starter
		    *
		    * @var    show
		    * @param  name,event
		    * @action controller for bootstrap event binder
		    * @return void
		    */
			$('a[class=accounting-menu_user-userMenuChooser]').live('click',function() {
				
				var data = $(this).attr('data-type');

				$('form[id=accounting-menu_user-userMenu] input[name=accounting-account-menu]').val(data);
				
				$('form[id=accounting-menu_user-userMenu]').submit();
			
			});
			
			/*
		    * Modal Draggable - bootstrap modal dragger
		    *
		    */
			$('div[id=accounting-actionbar_coa-coa], div[id=accounting-actionbar_item-modal]').draggable();

			
			/*
		    * tableReloader - Reload the table state after ajax
		    *
		    * @action ajax to designated control point and put the result into reload container
		    * @return void
		    */
			function tableReloader(control,reload) {
			    
			    var capsule = { "data":null, "control": control, "capsuleCSRFToken": $('#capsuleCSRFToken').val()};
			    
			    var request = $.ajax({
				
				  url: "/cornc/library/capsule/accounting/accounting.ajax.php",
				  
				  type: "POST",
				  
				  data: {data:capsule},
				  
				  dataType: "json"
				  
				});
				
				request.done(function(msg) {
					
					$('#capsuleCSRFToken').val(msg.token);
					
					$(reload).html(msg.view).fadeIn('fast');
					
					console.log(msg);
				
				});
				
				request.fail(function(jqXHR, textStatus) {
				
					console.log(jqXHR);
					
				});
			    
			}
			
			/*
		    * centeredModal - keep the modal in the center screen
		    *
		    */
			//$('div[id=accounting-actionbar_coa-coa]').draggable();
			function centeredModal(name) {
				
				$('#'+name).css({
				
			    	width: 'auto',
			        'margin-left': function () {return -($(this).width() / 2);}
			        
			    });
				
			}
						
			/*
		    * TableChecboxAll - check all tbody checkbox if thead checkbox is checked
		    *
		    */
		    function tableCheckboxAll(tableID) {
			    
			    var check = $('table[id='+tableID+'] thead input[type=checkbox]').prop("checked");

		    	if (check == true) {
		    	
		    	$('table[id='+tableID+'] tbody input[type=checkbox]').prop("checked",true);
		    	
		    	}
		    	else {
			    
			    $('table[id='+tableID+'] tbody input[type=checkbox]').prop("checked",false);
			    	
		    	}
			    
		    }
		    
		    /*
		    * Select Binder - Display new account bank account additional field when bank type is selected
		    *
		    * @selector tag .accounting-form_createCoa-mainSelector
		    * @function null
		    */
			function itemFieldNormalize(type) {

				if (type == 'Other Charge' || type == 'Discount') {
					
					$('.accounting-other-charge-notexist').hide();
					$('.accounting-other-charge-exist').show();
					$('.accounting-tax-notexist').show();
					$('.accounting-item-notexist-subtotal').css('visibility','visible')
															
				}
				else if (type == 'Tax') {
					
					$('.accounting-tax-notexist').hide();
					$('.accounting-other-charge-notexist').hide();
					$('.accounting-other-charge-exist').show();
					$('.accounting-item-notexist-subtotal').css('visibility','visible')
										
				}
				else if (type == 'Sub Total') {
					
					$('.accounting-item-notexist-subtotal').css('visibility','hidden')
										
				}
				else {
					
					$('.accounting-tax-notexist').show();
					$('.accounting-other-charge-notexist').show();
					$('.accounting-other-charge-exist').hide();
					$('.accounting-item-notexist-subtotal').css('visibility','visible')
										
				}
							
			};
			
			/*
		    * Chosen Selector - bootstrap event starter
		    *
		    * @var    show
		    * @param  name,event
		    * @action controller for bootstrap event binder
		    * @return void
		    */
			$('.accounting-chosen-single-deselect').chosen({allow_single_deselect: true}).change(function() {
    			        		    
        		    var id = $(this).val();
        		    
        		    $('.accounting-transaction-table-payment tbody tr').hide();
        		    
        		    $('.accounting-transaction-table-payment tbody tr[data-customer='+id+']').show();
        		    
        		    autoFatahCalculate();
        		        			        			
			});
			
			/*
		    * centeredModal - keep the modal in the center screen
		    *
		    */
		    function autoFatahCalculate() {
			    
			var table  = $('.accounting-transaction-table-payment');
			
			var amount = 0;
			    
			    $(table).find('tbody tr:visible').each(function(i) {
			    	
			    	var total = $(this).find('.accounting-payment-price').val();
			    	
			    	if (total != '') {
			    	
			    	amount = parseFloat(amount) + parseFloat($(this).find('.accounting-payment-price').val());
			    	
			    	}
			    
			    })
			    
			$(table).find('tfoot tr td.accounting-foot-total').text('').text(number_format(amount, 2, '.', ','));

		    }
		    
		    /*
		    * centeredModal - keep the modal in the center screen
		    *
		    */
		    $('.accounting-payment-price').live('keyup',function() {
			 
			 	autoFatahCalculate();
			    
		    })
			
			/*
		    * centeredModal - keep the modal in the center screen
		    *
		    */
		    function autoIpulCalculate() {
						
			var test;
			
			var subTotal = 0;
			
			var grandSubTotal = 0;
			
			var discount = 0;
			
			var tax = 0;
			
			var grandTotal = 0;

			var totales = 0;

			var totalor = 0;

			var table = $('.accounting-transaction-table');
			
			var globalTax = $('#globaltax').val();
			
			    $(table).find('tbody tr').each(function(i) {
			    
			    var total = 0;

			    var discountLineItem = 0;
			    
				var qty   = $(this).find('.accounting-qty input[type="text"]').val();
				
				    if (qty == undefined) {
    				    
    				    qty = $(this).find('.accounting-qty').val();
    				    
				    }
				    
			    var price = $(this).find('.accounting-price input[type="text"]').val();
			    
			    var disc  = $(this).find('.accounting-discount input[class="accounting-discount-value"]').val();
			    
			    var taxv  = $(this).find('.accounting-tax input[class="accounting-tax-value"]').val();
			    
			    var category = $(this).find('.accounting-item-category').val();

			    	if (disc == '' || disc == undefined) {
				    
				    	 total = price*qty;
				    	 
				    	 total = Math.round(total*100)/100;
				    
				    }
				    else {
						
						 discount += discountCalculation(price*qty,disc);
						 
						 var u = discountCalculation(price*qty,disc);
					     
					     total = (price*qty)-discountCalculation(price*qty,disc);
					     
					     total = Math.round(total*100)/100;
						 
				    }
				    				    
			    	if (typeof(total) == 'number' && total.toFixed(0) != 0 && category != 'Tax') {
				    	
				    	$(this).find('.accounting-amount input[type="text"]').val(number_format(total, 2, '.', ','));
				    	
				    }
				    else {
					
					    $(this).find('.accounting-amount input[type="text"]').val('');

				    }
				    				    
				    if (taxv != '') {
				    	
				    	if (globalTax == 'exclude') {
					    						    								
							tax += Number(taxCalculation(total,taxv,2));
														
						}
						else if (globalTax == 'include') {
    						    						
							var dpp = asaRounding(total / ((100+parseFloat(taxv))/100),2);
							
							tax  += asaRounding((dpp * (taxv / 100)),2);

							/**======================Include Calculation Start Here============================*/

							var newDecimal  = (100+parseFloat(taxv))/100;

							var newPrice    = parseFloat(price)/parseFloat(newDecimal);

							var newAmount   = asaRounding(price*qty,2);

							/**======================Include============================*/

							var newDiscount3 = discountCalculation(newAmount,disc);

							newDiscount2     = asaRounding(newAmount-newDiscount3,2);

							var newDpp2		 = asaRounding(total / newDecimal,2);

							var newTax2      = asaRounding((newDpp2 * (taxv / 100)),2);

							/**======================Original============================*/

							var newDiscount = (newAmount) * ((100 - disc) / 100); 
													
							newDiscount     = Math.round(((newAmount-newDiscount))*100000)/100000;

							var newDpp		= Math.round(((newAmount-newDiscount))*100000)/100000;

							var newTax      = Math.round((newDpp * (taxv / 100)) * 100000) / 100000;

							/**======================Result============================*/

							totales 	   += asaRounding(newDpp2,2);
							
							totalor 	   += Math.round((newDpp+newTax)*1000)/1000;
							
							var totalDiscount = (newDpp2) * ((100 - disc) / 100); 
			
                			totalDiscount = Math.round(totalDiscount*100) / 100;
                						 
                			//totalDiscount = Math.round((price*qty-totalDiscount)*100)/100;
							
							$(this).find('.amount-js').val(newTax2);

							/**==================================Stop Here=====================================*/
																																			
						}
						else {
							
							tax = 0;
							
						}
				    					    	
			    	}
			    
			    });
			    
			    $(table).find('.accounting-amount input[type="text"]').each(function(i) {

			    var amount   = $(this).val();
			    
			    var price    = $(this).parent().parent().find('.accounting-price input[id=price]').val();
			    
			    var category = $(this).parent().parent().find('.accounting-item-category').val();
			    
			    	if (amount != '' && category != 'Sub Total') {
				    	
				    	subTotal   	  = parseFloat(subTotal)+parseFloat(amount.replace(/\,/g,''));
				    	
				    	grandSubTotal = parseFloat(grandSubTotal)+parseFloat(amount.replace(/\,/g,''));
				    	
			    	}
			    	else if (category == 'Tax') {
				    
				    	$(this).parent().parent().prevAll().each(function() {
				    	
				    	var checker = $(this).find('.accounting-item-id').val();

				    		if (checker != '') {
				    		
				    		var amount = $(this).find('.accounting-amount input[id=amount]').val().replace(/\,/g,''); 
				    		
				    		amount = parseFloat(amount);
				    		
					    		total = amount*price/100;
					    		
					    		subTotal = parseFloat(subTotal)+parseFloat(total);
					    		grandSubTotal = parseFloat(grandSubTotal)+parseFloat(total);
					    						    	
					    	return false;
					    		
				    		}
				    					    	
				    	});
				    	
				    $(this).val(number_format(total, 2, '.', ','));
				    				    	
				    }
			    	else if (category == 'Sub Total') {
				    	
				    	if (typeof(subTotal) == 'number') {
				    	
				    	$(this).val(number_format(subTotal, 2, '.', ','));
				    	
				    	}
				    	
				    	subTotal = 0;
				    	
			    	}
			    			    
			    });
			    
			$('.accounting-foot-subtotal').text(number_format(grandSubTotal, 2, '.', ','));
			
				if (discount > 0) {
			
					$('.accounting-foot-discount').text('(Include discount '+number_format(discount, 2, '.', ',')+')');
					
				}
				else {
				
					$('.accounting-foot-discount').text('');
					
				}
				
			$('.accounting-foot-tax').text(number_format(tax, 2, '.', ','));
						
			//console.log('subtotal: '+grandSubTotal);
			//console.log('tax: '+ Math.round(tax*100)/100);
			//console.log('grand total: '+ totaliter );
			
				if (globalTax == 'exclude') {
			
					$('.accounting-foot-total').text(number_format(bankerRound(grandSubTotal+tax,2), 2, '.', ','));
					
				}
				else if (globalTax == 'include') {
					
					$('.accounting-foot-total').text(number_format(bankerRound(grandSubTotal,2), 2, '.', ','));
					
				}
				else {
					
					$('.accounting-foot-total').text(number_format(bankerRound(grandSubTotal,2), 2, '.', ','));
					
				}
																		    			    			    
		    }
		    
		    $('#globaltax').live('change', function() {
		    
		    	autoIpulCalculate();
		    
		    });
		    
		    /*
		    * centeredModal - keep the modal in the center screen
		    *
		    */
		    function tableDataRowPlacer(row,obj) {
			    
			    //console.log(obj);
			    
			    $(row).find('.accounting-item input[type="text"]').val(obj.label);
			    
				$(row).find('input.accounting-item-id').val(obj.id);
				
				$(row).find('input.accounting-item-category').val(obj.category);

				$(row).find('.accounting-description input[type="text"]').val(obj.desc);
				
				$(row).find('.accounting-price input[type="text"]').val(obj.price);
				
					if (obj.category != 'Sub Total') {
				
						$(row).find('.accounting-qty input[type="text"]').val(1.00);
						
					}
				
				$(row).find('input.accounting-account-display').val(obj.account);
				
				$(row).find('input.accounting-account-value').val(obj.accountid);
				
				$(row).find('input.accounting-tax-id').val(obj.taxid);
				
				$(row).find('input.accounting-tax-display').val(obj.taxname);
				
				$(row).find('input.accounting-tax-value').val(obj.taxrate);
				
				autoIpulCalculate();
			    			    			    
		    }
		    
		    /*
		    * centeredModal - keep the modal in the center screen
		    *
		    */
		    $.widget("custom.accountingautocomplete", $.ui.autocomplete, {
		    
			    _renderMenu: function(ul, items){
			    
			        var self = this;
			        
			        var currentCategory = "";
			        
			        $.each(items, function(index, item){
			        
			            if(item.category != currentCategory){
			            
			                ul.append(" <li class='ui-autocomplete-category'>" + item.category + "</li>");
			                
			                currentCategory = item.category;
			                
			            }
			            
			            self._renderItem(ul, item);
			            
			        });
			        
			    }
			    
			});
			
			/*
		    * centeredModal - keep the modal in the center screen
		    *
		    */
			$.widget("custom.accountingcoaautocomplete", $.ui.autocomplete, {
		    
			    _renderMenu: function(ul, items){
			    
			        var self = this;
			        
			        var currentCategory = "";
			        
			        $.each(items, function(index, item){
			        
			            if(item.category != currentCategory){
			            
			                ul.append(" <li class='ui-autocomplete-category'>" + item.category + "</li>");
			                
			                currentCategory = item.category;
			                
			            }
			            
			            self._renderItem(ul, item);
			            
			        });
			        
			    }
			    
			});
		    
		    /*
		    * centeredModal - keep the modal in the center screen
		    *
		    */
		    $(".accounting-item input[type='text']").live('focus',function(){
						
		    var loc = $(this);
		    
		    var row = $(this).parent().parent();

			    $(this).accountingautocomplete({
				    
			    	minLength: 0,
			    	
			        source: accountingInvoiceItem(),
			        
			        focus: function(event, ui){
	
			            return false;
			            
			        },
			        select: function(event, ui){
			        
			            tableDataRowPlacer(row,ui.item);
			            
		                return false;
		                
			        }
	
			    }).data("accountingautocomplete")._renderItem = function (ul, item) {
			    
			         return $("<li></li>")
			         
			            .data("item.autocomplete", item)
			            
			            .append("<a>" + item.label + "</a>")
			            
			            .appendTo(ul);
			            
			    };
		    
		    $(this).accountingautocomplete("search","");
			
			});
			
			/*
		    * centeredModal - keep the modal in the center screen
		    *
		    */
		    $(".accounting-account-display").live('focus',function(){
						
		    var loc = $(this);
		    
		    var row = $(this).parent().parent();

			    $(this).accountingcoaautocomplete({
				    
			    	minLength: 0,
			    	
			        source: accountingInvoiceCoa(),
			        
			        focus: function(event, ui){
	
			            return false;
			            
			        },
			        select: function(event, ui){
			        	
			        	$(loc).parent().find('.accounting-account-value').val(ui.item.id);
			        	
			        	$(loc).val(ui.item.label);
			        				            
		                return false;
		                
			        }
	
			    }).data("accountingcoaautocomplete")._renderItem = function (ul, item) {
			    
			         return $("<li></li>")
			         
			            .data("item.autocomplete", item)
			            
			            .append("<a>" + item.label + "</a>")
			            
			            .appendTo(ul);
			            
			    };
		    
		    $(this).accountingcoaautocomplete("search","");
			
			});
			
			/*
		    * centeredModal - keep the modal in the center screen
		    *
		    */
		    $(".accounting-tax-display").live('focus',function(){
						
		    var loc = $(this);
		    
		    var row = $(this).parent().parent();

			    $(this).autocomplete({
				    
			    	minLength: 0,
			    	
			        source: accountingInvoiceTax(),
			        
			        focus: function(event, ui){
	
			            return false;
			            
			        },
			        select: function(event, ui){
			        	
			        	$(loc).parent().find('.accounting-tax-id').val(ui.item.id);
			        	
			        	$(loc).parent().find('.accounting-tax-value').val(ui.item.rate);
			        	
			        	$(loc).val(ui.item.label);
			        	
			        	autoIpulCalculate();
			        				            
		                return false;
		                
			        },
	
			    }).data("autocomplete")._renderItem = function (ul, item) {
			    
			         return $("<li></li>")
			         
			            .data("item.autocomplete", item)
			            
			            .append("<a>" + item.label + "</a>")
			            
			            .appendTo(ul);
			            
			    };
		    
		    $(this).autocomplete("search","");
			
			});
			
			/*
		    * centeredModal - keep the modal in the center screen
		    *
		    */
		    $(".accounting-discount-display").live('focus',function(){
						
		    var loc = $(this);
		    
		    var row = $(this).parent().parent();

			    $(this).autocomplete({
				    
			    	minLength: 0,
			    	
			        source: accountingInvoiceDiscount(),
			        
			        focus: function(event, ui){
	
			            return false;
			            
			        },
			        select: function(event, ui){
			        	
			        	$(loc).parent().find('.accounting-discount-id').val(ui.item.id);
			        	
			        	$(loc).parent().find('.accounting-discount-value').val(ui.item.rate);
			        	
			        	$(loc).val(ui.item.label);
			        	
			        	autoIpulCalculate();
			        				            
		                return false;
		                
			        },
	
			    }).data("autocomplete")._renderItem = function (ul, item) {
			    
			         return $("<li></li>")
			         
			            .data("item.autocomplete", item)
			            
			            .append("<a>" + item.label + "</a>")
			            
			            .appendTo(ul);
			            
			    };
		    
		    $(this).autocomplete("search","");
			
			});
			
			$(".accounting-discount-display").live('keyup',function() {
			
				if ($(this).val() == '') {
					
					$(this).parent().find('.accounting-discount-id').val('');
					
					$(this).parent().find('.accounting-discount-value').val('');
					
					autoIpulCalculate();
					
				}
			
			});
			
			$(".accounting-tax-display").live('keyup',function() {
			
				if ($(this).val() == '') {
					
					$(this).parent().find('.accounting-tax-id').val('');
					
					$(this).parent().find('.accounting-tax-value').val('');
					
					autoIpulCalculate();
					
				}
			
			});
					    
		    /*
		    * Table row new line - add a new tr line to the bottom of the tbody table
		    *
		    */
		    $('.accounting-qty').live('keyup',function() {

			    autoIpulCalculate();
			    
		    });
		    
		    $('.accounting-price').live('keyup',function() {
		    
			    autoIpulCalculate();
			    
		    });
		    
		    $('.accounting-discount').live('keyup',function() {
		    
			    autoIpulCalculate();
			 
		    });

			/*
		    * Table row new line - add a new tr line to the bottom of the tbody table
		    *
		    */
		    $('a.accounting-table-add-newline').click(function() {
			    
    		    var tr  = $('.accounting-transaction-table:visible tbody tr:last').html();
    		    
    		    var loc = $('.accounting-transaction-table:visible tbody tr:last').attr('class');
    		        		        		    
    		    $('.accounting-transaction-table:visible tbody tr:last').after('<tr class="'+loc+'">'+tr+'</tr>');
        		          		    
    		    $('.accounting-transaction-table:visible tbody tr:last').find('input').val('');
			
			return false;
			
		    });
		    
		    /*
		    * Table row deleter - delete a table row
		    *
		    */	
		    $('.accounting-table-del-line').live('click', function() {
			    
			var check = $(this).parent().parent().parent().find('tr').length;
			var id    = $(this).parent().parent().find('.accounting-item-pid').val();

			    if (check > 1) {
			    
			    	if (id != '') {
				    	
				    	deleteTransactionLineItem.push(id);
				    					    	
			    	}
			    
				    $(this).parent().parent().remove();
				    
				    autoIpulCalculate();
				    
			    }
			    
		    });
			
			/*
		    * Table row sortable - tr positioning
		    *
		    */		
			$(".accounting-transaction-table tbody").sortable({
				
				revert	: false,
				helper	: 'clone',
			    handle	: 'td:first',
			    axis	: 'y',
			    update	: function(event, ui) { autoIpulCalculate(); }
							    
			});
			
			/*
		    * Invoice date picker - check all tbody checkbox if thead checkbox is checked
		    *
		    */
		    $('input[class^="accounting-date-"]').datepicker({
			    
			    dateFormat: "dd-mm-yy"
			    
		    });
			
			
			/*
		    * Table checbox - check all tbody checkbox if thead checkbox is checked
		    *
		    */
		    $('table[id=accounting-table_coa-tableCoa] thead input[type=checkbox]').live('click',function() {
		    
		    	tableCheckboxAll('accounting-table_coa-tableCoa');
		    
		    });
		    
		    /*
		    * Table checbox - check all tbody checkbox if thead checkbox is checked
		    *
		    */
		    $('table[id=accounting-table_contact_acounting-tablecontact] thead input[type=checkbox]').live('click',function() {
		    
		    	tableCheckboxAll('accounting-table_contact_acounting-tablecontact');
		    
		    });
		    
		    /*
		    * Table checbox - check all tbody checkbox if thead checkbox is checked
		    *
		    */
		    $('table[id=accounting-table_item-tableCoa] thead input[type=checkbox]').live('click',function() {
		    
		    	tableCheckboxAll('accounting-table_item-tableCoa');
		    
		    });
		    
		    /*
		    * Select Binder - Display new account bank account additional field when bank type is selected
		    *
		    * @selector tag .accounting-form_createCoa-mainSelector
		    * @function null
		    */
			$('.accounting-form_createCoa-mainSelector').chosen().live('change',function() {
				
				var obj  = $('.accounting-form_createCoa-bankAccount');
				
				var type = $('.accounting-form_createCoa-mainSelector option:selected').text();
								
				if (type == 'Bank') {
					
					$(obj).show();
					
				}
				else {
					
					$(obj).hide();
					
				}
			
			});
			
			/*
		    * Select Binder - Display new account bank account additional field when bank type is selected
		    *
		    * @selector tag .accounting-form_createCoa-mainSelector
		    * @function null
		    */
			$('.accounting-form_createItem-mainSelector').chosen().live('change',function() {
				
				var type = $('.accounting-form_createItem-mainSelector option:selected').text();
								
				if (type == 'Other Charge' || type == 'Discount') {
					
					$('.accounting-other-charge-notexist').hide();
					$('.accounting-other-charge-exist').show();
					$('.accounting-tax-notexist').show();
					$('.accounting-item-notexist-subtotal').css('visibility','visible')
															
				}
				else if (type == 'Tax') {
					
					$('.accounting-tax-notexist').hide();
					$('.accounting-other-charge-notexist').hide();
					$('.accounting-other-charge-exist').show();
					$('.accounting-item-notexist-subtotal').css('visibility','visible')
										
				}
				else if (type == 'Sub Total') {
					
					$('.accounting-item-notexist-subtotal').css('visibility','hidden')
										
				}
				else {
					
					$('.accounting-tax-notexist').show();
					$('.accounting-other-charge-notexist').show();
					$('.accounting-other-charge-exist').hide();
					$('.accounting-item-notexist-subtotal').css('visibility','visible')
										
				}
				
			centeredModal('accounting-actionbar_item-modal');
			
			});
			
			 /*
		    * Select Binder - Display update account bank account additional field when bank type is selected
		    *
		    * @selector tag .accounting-form_createCoa-mainSelector
		    * @function null
		    */
			$('.accounting-form_updateCoa-mainSelector').chosen().live('change',function() {
				
				var obj  = $('.accounting-form_updateCoa-bankAccount');
				
				var type = $('.accounting-form_updateCoa-mainSelector option:selected').text();
								
				if (type == 'Bank') {
					
					$(obj).show();
					
				}
				else {
					
					$(obj).hide();
					
				}
			
			});
			
			/*
		    * Button Binder - Display new form Chart of Account
		    *
		    * @selector tag a[href=#accounting-actionbar_coa-coa]
		    * @action show modal window
		    * @function displayModal
		    */
			$('a[href=#accounting-actionbar_coa-coaAdd]').live('click',function() {
								
				var capsule = { "data":null, "control": "form_createCoa", "capsuleCSRFToken": $('#capsuleCSRFToken').val()};
								
				var request = $.ajax({
				
				  url: "/cornc/library/capsule/accounting/accounting.ajax.php",
				  
				  type: "POST",
				  
				  data: {data:capsule},
				  
				  dataType: "json"
				  
				});
				
				request.done(function(msg) {
				
					if (msg.response == "success") {
					
						$('#accounting-actionbar_coa-coa').find('#myModalLabel').html(msg.viewHeader);
						
						$('#accounting-actionbar_coa-coa').find('.modal-body').html(msg.viewBody);
						
						$('#accounting-actionbar_coa-coa').find('.modal-footer').html(msg.viewFooter);
						
						$('#capsuleCSRFToken').val(msg.token);
						
						$('.accounting-form_createCoa-select').chosen({allow_single_deselect: true});
												
						displayModal('accounting-actionbar_coa-coa','show');
																		
					}
					
				});
				
				request.fail(function(jqXHR, textStatus) {
				
					console.log(jqXHR);
					
				});
								
			});
			
			/*
		    * Button Binder - Create new Chart of Account
		    *
		    * @selector tag button[id=accounting-form_createCoa-createCoa]
		    * @action close modal window after save
		    * @function null
		    */
			$('button[id=accounting-form_createCoa-createCoa]').live('click',function() {
			
				var data = {};
								
				$("#accounting-form_createCoa-form").find('input,select,textarea').each(function(i) {
					
					var id   = $(this).attr('id');
										
					if (typeof id !== "undefined") {
											
						data [id] = $(this).val();
					
					}
					
					$(this).parent().parent().removeClass('error');
					
				})
							
				var capsule = { "data":data, "control": "createCoa", "capsuleCSRFToken": $('#capsuleCSRFToken').val()};
								
				var request = $.ajax({
				
				  url: "/cornc/library/capsule/accounting/accounting.ajax.php",
				  
				  type: "POST",
				  
				  data: {data:capsule},
				  
				  dataType: "json"
				  
				});
				
				request.done(function(msg) {
				
					if (msg.response == "success") {
						
						$('#capsuleCSRFToken').val(msg.token);
									
						closeModal('accounting-actionbar_coa-coa','hide');	
						
						tableReloader('table_coa','#accounting-table_coa-tableContainer');			
																							
					}
					else {

						if (is_array(msg.error)) {

							$(msg.error).each(function (i) {
													
								$("#accounting-form_createCoa-form").find('label[for='+Object.keys(msg.error[i])+']').parent().addClass('error');
								
							});
							
						}
											
						$('#capsuleCSRFToken').val(msg.token);
						
					}
					
				//console.log(msg);
					
				});
				
				request.fail(function(jqXHR, textStatus) {
				
					console.log(jqXHR);
					
				});
								
			});
			
			/*
		    * Button Binder - Display update form Chart of Account
		    *
		    * @selector tag a[href=#accounting-actionbar_coa-coa]
		    * @action show modal window
		    * @function displayModal
		    */
			$('table a[class=accounting-table_coa-update]').live('click',function() {
				
				var data    = $(this).parent().parent().find('input[type=checkbox]').val();

				var capsule = { "data":data, "control": "form_updateCoa", "capsuleCSRFToken": $('#capsuleCSRFToken').val()};
								
				var request = $.ajax({
				
				  url: "/cornc/library/capsule/accounting/accounting.ajax.php",
				  
				  type: "POST",
				  
				  data: {data:capsule},
				  
				  dataType: "json"
				  
				});
				
				request.done(function(msg) {
				
					if (msg.response == "success") {
					
						$('#accounting-actionbar_coa-coa').find('#myModalLabel').html(msg.viewHeader);
						
						$('#accounting-actionbar_coa-coa').find('.modal-body').html(msg.viewBody);
						
						$('#accounting-actionbar_coa-coa').find('.modal-footer').html(msg.viewFooter);
						
						$('#capsuleCSRFToken').val(msg.token);
						
						$('.accounting-form_updateCoa-select').chosen({allow_single_deselect: true});
						
						displayModal('accounting-actionbar_coa-coa','show');
																		
					}
					
				});
				
				request.fail(function(jqXHR, textStatus) {
				
					console.log(jqXHR);
					
				});
								
			});
			
			/*
		    * Button Binder - Update data of the Chart of Account
		    *
		    * @selector tag button[id=accounting-form_createCoa-createCoa]
		    * @action close modal window after save
		    * @function null
		    */
			$('button[id=accounting-form_updateCoa-updateCoa]').live('click',function() {
			
				var data = {};
								
				$("#accounting-form_updateCoa-form").find('input,select,textarea').each(function(i) {
					
					var id   = $(this).attr('id');
										
					if (typeof id !== "undefined") {
											
						data [id] = $(this).val();
					
					}
					
					$(this).parent().parent().removeClass('error');
					
				})
							
				var capsule = { "data":data, "control": "updateCoa", "capsuleCSRFToken": $('#capsuleCSRFToken').val()};
								
				var request = $.ajax({
				
				  url: "/cornc/library/capsule/accounting/accounting.ajax.php",
				  
				  type: "POST",
				  
				  data: {data:capsule},
				  
				  dataType: "json"
				  
				});
				
				request.done(function(msg) {
				
					if (msg.response == "success") {
						
						$('#capsuleCSRFToken').val(msg.token);
									
						closeModal('accounting-actionbar_coa-coa','hide');
						
						tableReloader('table_coa','#accounting-table_coa-tableContainer');			
																							
					}
					else {

						if (is_array(msg.error)) {
							
							$(msg.error).each(function (i) {
													
								$("#accounting-form_updateCoa-form").find('label[for='+Object.keys(msg.error[i])+']').parent().addClass('error');
								
							});
							
						}
											
						$('#capsuleCSRFToken').val(msg.token);
						
					}
					
				console.log(msg);
					
				});
				
				request.fail(function(jqXHR, textStatus) {
				
					console.log(jqXHR);
					
				});
								
			});
			
			/*
		    * Button Binder - delete Chart of Account
		    *
		    * @selector tag a[href=#accounting-actionbar_coa-coa]
		    * @action show modal window
		    * @function displayModal
		    */
			$('a[href=#accounting-actionbar_coa-coaDelete]').live('click',function() {
			
				var check =  $('table[id=accounting-table_coa-tableCoa] tbody input[type=checkbox]:checked').length;
				
				if (check == 0) {return false;}
				
				var data  = [];
				
				$('table[id=accounting-table_coa-tableCoa] tbody input[type=checkbox]:checked').each(function(i) {
					
					data[i] = $(this).val();
					
				});
				
				deleteAccount = data;
				
				console.log(deleteAccount);
								
				var capsule = { "data":null, "control": "form_deleteCoa", "capsuleCSRFToken": $('#capsuleCSRFToken').val()};
								
				var request = $.ajax({
				
				  url: "/cornc/library/capsule/accounting/accounting.ajax.php",
				  
				  type: "POST",
				  
				  data: {data:capsule},
				  
				  dataType: "json"
				  
				});
				
				request.done(function(msg) {
				
					if (msg.response == "success") {
						
						var warning = '<div>Are you absolutely sure that you are going to delete '+ check +' account?</div>';
						
						$('#accounting-actionbar_coa-coa').find('#myModalLabel').html(msg.viewHeader);
						
						$('#accounting-actionbar_coa-coa').find('.modal-body').html(msg.viewBody+warning);
						
						$('#accounting-actionbar_coa-coa').find('.modal-footer').html(msg.viewFooter);
						
						$('#capsuleCSRFToken').val(msg.token);
												
						displayModal('accounting-actionbar_coa-coa','show');
						
						//console.log(deleteAccount);
																		
					}
					
				});
				
				request.fail(function(jqXHR, textStatus) {
				
					console.log(jqXHR);
					
				});				
								
			});
			
			/*
		    * Button Binder - delete Chart of Account
		    *
		    * @selector tag button[id=accounting-form_createCoa-createCoa]
		    * @action close modal window after save
		    * @function null
		    */
			$('button[id=accounting-form_deleteCoa-deleteCoa]').live('click',function() {

				var capsule = { "data":deleteAccount, "control": "deleteCoa", "capsuleCSRFToken": $('#capsuleCSRFToken').val()};
								
				var request = $.ajax({
				
				  url: "/cornc/library/capsule/accounting/accounting.ajax.php",
				  
				  type: "POST",
				  
				  data: {data:capsule},
				  
				  dataType: "json"
				  
				});
				
				request.done(function(msg) {
				
					if (msg.response == "success") {
						
						deleteAccount = '';
						
						$('#capsuleCSRFToken').val(msg.token);
									
						closeModal('accounting-actionbar_coa-coa','hide');
						
						tableReloader('table_coa','#accounting-table_coa-tableContainer');			
																							
					}
					else {
											
						$('#capsuleCSRFToken').val(msg.token);
						
					}
					
				//console.log(msg);
					
				});
				
				request.fail(function(jqXHR, textStatus) {
				
					console.log(jqXHR);
					
				});
								
			});
			
			/*
		    * Button Binder - Display new form item
		    *
		    * @selector tag a[href=#accounting-actionbar_item-coa]
		    * @action show modal window
		    * @function displayModal
		    */
			$('a[href=#accounting-actionbar_item-itemAdd]').live('click',function() {
								
				var capsule = { "data":null, "control": "form_createItem", "capsuleCSRFToken": $('#capsuleCSRFToken').val()};
								
				var request = $.ajax({
				
				  url: "/cornc/library/capsule/accounting/accounting.ajax.php",
				  
				  type: "POST",
				  
				  data: {data:capsule},
				  
				  dataType: "json"
				  
				});
				
				request.done(function(msg) {
					//console.log(msg);
					if (msg.response == "success") {
					
						$('#accounting-actionbar_item-modal').find('#myModalLabel').html(msg.viewHeader);
						
						$('#accounting-actionbar_item-modal').find('.modal-body').html(msg.viewBody);
						
						$('#accounting-actionbar_item-modal').find('.modal-footer').html(msg.viewFooter);
						
						$('#capsuleCSRFToken').val(msg.token);
						
						$('.accounting-form_createItem-select').chosen({allow_single_deselect: true});
												
						displayModal('accounting-actionbar_item-modal','show');
																		
					}
					
				});
				
				request.fail(function(jqXHR, textStatus) {
				
					console.log(jqXHR);
					
				});
								
			});
			
			
			/*
		    * Button Binder - Create new Item
		    *
		    * @selector tag button[id=accounting-form_createCoa-createCoa]
		    * @action close modal window after save
		    * @function null
		    */
			$('button[id=accounting-form_createItem-createItem]').live('click',function() {
			
				var data = {};
				
				$("#accounting-form_createItem-form").find('input[type="text"],input[type="checkbox"]:checked,select,textarea').each(function(i) {
					
					var id   = $(this).attr('id');
					
					if (typeof id !== "undefined") {
					
						data [id] = $(this).val();
					
					}
					
					$(this).parent().parent().removeClass('error');
				
				})
							
				var capsule = { "data":data, "control": "createItem", "capsuleCSRFToken": $('#capsuleCSRFToken').val()};
								
				var request = $.ajax({
				
				  url: "/cornc/library/capsule/accounting/accounting.ajax.php",
				  
				  type: "POST",
				  
				  data: {data:capsule},
				  
				  dataType: "json"
				
				});
				
				request.done(function(msg) {
								
					if (msg.response == "success") {
						
						$('#capsuleCSRFToken').val(msg.token);
									
						closeModal('accounting-actionbar_item-modal','hide');	
						
						tableReloader('table_item','#accounting-table_item-tableContainer');			
																							
					}
					else {

						if (is_array(msg.error)) {
							
							$(msg.error).each(function (i) {
								
								$("#accounting-form_createItem-form").find('label[for='+Object.keys(msg.error[i])+']').parent().addClass('error');
								
							});
							
						}
											
						$('#capsuleCSRFToken').val(msg.token);
						
					}

				console.log(msg);
					
				});
				
				request.fail(function(jqXHR, textStatus) {
				
					console.log(jqXHR);
					
				});
								
			});
			
			/*
		    * Button Binder - Display update form Item
		    *
		    * @selector tag a[href=#accounting-actionbar_coa-coa]
		    * @action show modal window
		    * @function displayModal
		    */
			$('table a[class=accounting-table_item-update]').live('click',function() {
				
				var data    = $(this).parent().parent().find('input[type=checkbox]').val();

				var capsule = { "data":data, "control": "form_updateItem", "capsuleCSRFToken": $('#capsuleCSRFToken').val()};
								
				var request = $.ajax({
				
				  url: "/cornc/library/capsule/accounting/accounting.ajax.php",
				  
				  type: "POST",
				  
				  data: {data:capsule},
				  
				  dataType: "json"
				  
				});
				
				request.done(function(msg) {
				
					if (msg.response == "success") {
					
						$('#accounting-actionbar_item-modal').find('#myModalLabel').html(msg.viewHeader);
						
						$('#accounting-actionbar_item-modal').find('.modal-body').html(msg.viewBody);
						
						$('#accounting-actionbar_item-modal').find('.modal-footer').html(msg.viewFooter);
						
						$('#capsuleCSRFToken').val(msg.token);
						
						$('.accounting-form_updateItem-select').chosen({allow_single_deselect: true});
												
						displayModal('accounting-actionbar_item-modal','show');
						
						var text = $('.accounting-form_updateItem-mainSelector option:selected').text();
						
						itemFieldNormalize(text);
																		
					}
				
				console.log(msg);
				
				});
				
				request.fail(function(jqXHR, textStatus) {
				
					console.log(jqXHR);
					
				});
								
			});
			
			/*
		    * Button Binder - Update data of the item
		    *
		    * @selector tag button[id=accounting-form_createCoa-createCoa]
		    * @action close modal window after save
		    * @function null
		    */
			$('button[id=accounting-form_updateItem-updateItem]').live('click',function() {
			
				var data = {};
				
				$("#accounting-form_updateItem-form").find('input[type="text"],input[type="hidden"],input[type="checkbox"]:checked,select,textarea').each(function(i) {
					
					var id   = $(this).attr('id');
										
					if (typeof id !== "undefined") {
											
						data [id] = $(this).val();
					
					}
					
					$(this).parent().parent().removeClass('error');
					
				})
							
				var capsule = { "data":data, "control": "updateItem", "capsuleCSRFToken": $('#capsuleCSRFToken').val()};
								
				var request = $.ajax({
				
				  url: "/cornc/library/capsule/accounting/accounting.ajax.php",
				  
				  type: "POST",
				  
				  data: {data:capsule},
				  
				  dataType: "json"
				  
				});
				
				request.done(function(msg) {
				
					if (msg.response == "success") {
						
						$('#capsuleCSRFToken').val(msg.token);
									
						closeModal('accounting-actionbar_item-modal','hide');
						
						tableReloader('table_item','#accounting-table_item-tableContainer');	
																							
					}
					else {

						if (is_array(msg.error)) {
							
							$(msg.error).each(function (i) {
													
								$("#accounting-form_updateItem-updateItem").find('label[for='+Object.keys(msg.error[i])+']').parent().addClass('error');
								
							});
							
						}
											
						$('#capsuleCSRFToken').val(msg.token);
						
					}
					
				console.log(msg);
					
				});
				
				request.fail(function(jqXHR, textStatus) {
				
					console.log(jqXHR);
					
				});
								
			});
			
			/*
		    * Button Binder - delete Chart of Account
		    *
		    * @selector tag a[href=#accounting-actionbar_coa-coa]
		    * @action show modal window
		    * @function displayModal
		    */
			$('a[href=#accounting-actionbar_item-itemDelete]').live('click',function() {
			
				var check =  $('table[id=accounting-table_item-tableCoa] tbody input[type=checkbox]:checked').length;
				
				if (check == 0) {return false;}
				
				var data  = [];
				
				$('table[id=accounting-table_item-tableCoa] tbody input[type=checkbox]:checked').each(function(i) {
					
					data[i] = $(this).val();
					
				});
				
				deleteItem = data;
				
				console.log(deleteAccount);
								
				var capsule = { "data":null, "control": "form_deleteItem", "capsuleCSRFToken": $('#capsuleCSRFToken').val()};
								
				var request = $.ajax({
				
				  url: "/cornc/library/capsule/accounting/accounting.ajax.php",
				  
				  type: "POST",
				  
				  data: {data:capsule},
				  
				  dataType: "json"
				  
				});
				
				request.done(function(msg) {
				
					if (msg.response == "success") {
						
						var warning = '<div>Are you absolutely sure that you are going to delete '+ check +' item?</div>';
						
						$('#accounting-actionbar_item-modal').find('#myModalLabel').html(msg.viewHeader);
						
						$('#accounting-actionbar_item-modal').find('.modal-body').html(msg.viewBody+warning);
						
						$('#accounting-actionbar_item-modal').find('.modal-footer').html(msg.viewFooter);
						
						$('#capsuleCSRFToken').val(msg.token);
												
						displayModal('accounting-actionbar_item-modal','show');
						
						//console.log(deleteAccount);
																		
					}
					
				});
				
				request.fail(function(jqXHR, textStatus) {
				
					console.log(jqXHR);
					
				});				
								
			});
			
			/*
		    * Button Binder - delete Chart of Account
		    *
		    * @selector tag button[id=accounting-form_createCoa-createCoa]
		    * @action close modal window after save
		    * @function null
		    */
			$('button[id=accounting-form_deleteItem-deleteItem]').live('click',function() {

				var capsule = { "data":deleteItem, "control": "deleteItem", "capsuleCSRFToken": $('#capsuleCSRFToken').val()};
								
				var request = $.ajax({
				
				  url: "/cornc/library/capsule/accounting/accounting.ajax.php",
				  
				  type: "POST",
				  
				  data: {data:capsule},
				  
				  dataType: "json"
				  
				});
				
				request.done(function(msg) {
				
					if (msg.response == "success") {
						
						deleteAccount = '';
						
						$('#capsuleCSRFToken').val(msg.token);
									
						closeModal('accounting-actionbar_item-modal','hide');
						
						tableReloader('table_item','#accounting-table_item-tableContainer');			
																							
					}
					else {
											
						$('#capsuleCSRFToken').val(msg.token);
						
					}
					
				//console.log(msg);
					
				});
				
				request.fail(function(jqXHR, textStatus) {
				
					console.log(jqXHR);
					
				});
								
			});
			
			/*
		    * Button Binder - create new invoice
		    *
		    * @selector tag button[id=accounting-invoice-submit-new]
		    * @action show modal window
		    * @function displayModal
		    */
			$('button[id=accounting-invoice-submit-new]').live('click',function() {
			
			$(this).button('loading');

			var inc = 0;
			
			var invoice = {};
			
				$('.accounting-form_invoice_controller-form-transaction').find('input,select').each(function(i) {
				
				var id = $(this).attr('id');

					if (typeof id !== "undefined") {
												
						invoice [id] = $(this).val();
						
					}
								
				});

				invoice['item-row']  = $('.accounting-transaction-table tbody').find('.accounting-invoice-item-row').length;

				invoice['line item'] = {};
				
				$('.accounting-transaction-table tbody tr').each(function(i) {
					
					++inc;
					
					$(this).find('input[id=position]').val(inc);
					
					invoice['line item'][i] = {};
					
					$(this).find('input').each(function(a) {
					
					var id = $(this).attr('id');
					
						if (typeof id !== "undefined") {
													
							invoice['line item'][i][id] = $(this).val();
							
						}
						
					});
													
				})
																			
				var capsule = {"data":invoice, "control": "invoice_create", "capsuleCSRFToken": $('#capsuleCSRFToken').val()};

				var request = $.ajax({
				
				  url: "/cornc/library/capsule/accounting/accounting.ajax.php",
				  
				  type: "post",
				  
				  data: {data:capsule},
				  
				  dataType: "json"
				  
				});
				
				request.done(function(msg) {
					
					if (msg.response == "success") {
												
						location.href = 'http://' + window.location.hostname + window.location.pathname + '?actio=view|||invoice|||' + msg.id + '&emblem=' + msg.token;
																		
					}
					else {

						$('#capsuleCSRFToken').val(msg.token);

					}

				console.log(msg);
					
				});
				
				request.fail(function(jqXHR, textStatus) {
				
					console.log(jqXHR);
					
				});		
				
			return false;		
							
			});
			
			/*
		    * Button Binder - edit bill
		    *
		    * @selector tag button[id=accounting-bill-submit-edit]
		    * @action show modal window
		    * @function displayModal
		    */
			$('button[id=accounting-invoice-submit-edit]').live('click',function() {
			
			$(this).button('loading');

			var inc = 0;
			
			var invoice = {};
			
				$('.accounting-form_invoice_controller-form-transaction').find('input,select').each(function(i) {
				
				var id = $(this).attr('id');

					if (typeof id !== "undefined") {
												
						invoice [id] = $(this).val();
						
					}
								
				});
				
				invoice['item-row']  = $('.accounting-transaction-table tbody').find('.accounting-invoice-item-row').length;

				invoice['line item'] = {};
				
				$('.accounting-transaction-table tbody tr').each(function(i) {
					
					++inc;
					
					$(this).find('input[id=position]').val(inc);
					
					invoice['line item'][i] = {};
					
					$(this).find('input').each(function(a) {
					
					var id = $(this).attr('id');
					
						if (typeof id !== "undefined") {
													
							invoice['line item'][i][id] = $(this).val();
							
						}
						
					});
													
				})
				
				invoice ['deleted-line-item'] = deleteTransactionLineItem;
																			
				var capsule = {"data":invoice, "control": "invoice_update", "capsuleCSRFToken": $('#capsuleCSRFToken').val()};

				var request = $.ajax({
				
				  url: "/cornc/library/capsule/accounting/accounting.ajax.php",
				  
				  type: "post",
				  
				  data: {data:capsule},
				  
				  dataType: "json"
				  
				});
				
				request.done(function(msg) {
				
					if (msg.response == "success") {
												
						invoice ['deleted-line-item'] = null;

						location.href = 'http://' + window.location.hostname + window.location.pathname + '?actio=view|||invoice|||' + msg.id + '&emblem=' + msg.token;
																		
					}
					else {

						//$('#capsuleCSRFToken').val(msg.token);

						invoice ['deleted-line-item'] = null;

					}

				console.log(msg);
					
				});
				
				request.fail(function(jqXHR, textStatus) {
				
					console.log(jqXHR);
					
				});		
				
			return false;		
							
			});
			
			/*
		    * Button Binder - create new bill
		    *
		    * @selector tag button[id=accounting-bill-submit-new]
		    * @action show modal window
		    * @function displayModal
		    */
			$('button[id=accounting-bill-submit-new]').live('click',function() {
			
			var inc  = 0;
			
			var u    = 0;
			
			var bill = {};
			
				$('.accounting-form_bill_controller-form-transaction').find('input,select').each(function(i) {
				
				var id = $(this).attr('id');

					if (typeof id !== "undefined") {
												
						bill [id] = $(this).val();
						
					}
								
				});
				
				bill['item-row'] = $('.accounting-transaction-table tbody').find('.accounting-bill-item-row').length;
				
				bill['account-row'] = $('.accounting-transaction-table tbody').find('.accounting-bill-account-row').length;
				
				bill['line item'] = {};
				
				$('.accounting-transaction-table tbody tr.accounting-bill-item-row').each(function(i) {
										
					++inc;
					
					$(this).find('input[id=position]').val(inc);
					
					bill['line item'][u] = {};
					
					$(this).find('input').each(function(a) {
					
					var id = $(this).attr('id');
					
						if (typeof id !== "undefined") {
													
							bill['line item'][u][id] = $(this).val();
							
						}
						
					});
					
					++u;
													
				})
				
				inc = 0;
				
				$('.accounting-transaction-table tbody tr.accounting-bill-account-row').each(function(i) {
										
					++inc;
					
					$(this).find('input[id=position]').val(inc);
					
					bill['line item'][u] = {};
					
					$(this).find('input').each(function(a) {
					
					var id = $(this).attr('id');
					
						if (typeof id !== "undefined") {
													
							bill['line item'][u][id] = $(this).val();
							
						}
						
					});
					
					++u;
													
				})
																			
				var capsule = {"data":bill, "control": "bill_create", "capsuleCSRFToken": $('#capsuleCSRFToken').val()};

				var request = $.ajax({
				
				  url: "/cornc/library/capsule/accounting/accounting.ajax.php",
				  
				  type: "post",
				  
				  data: {data:capsule},
				  
				  dataType: "json"
				  
				});
				
				request.done(function(msg) {
				
					if (msg.response == "success") {
												
						location.href = 'http://' + window.location.hostname + window.location.pathname + '?actio=view|||bill|||' + msg.id + '&emblem=' + msg.token;
																		
					}
					else {

						$('#capsuleCSRFToken').val(msg.token);

					}
					
				console.log(msg);
					
				});
				
				request.fail(function(jqXHR, textStatus) {
				
					console.log(jqXHR);
					
				});		
				
			return false;		
							
			});
			
			/*
		    * Button Binder - edit bill
		    *
		    * @selector tag button[id=accounting-bill-submit-new]
		    * @action show modal window
		    * @function displayModal
		    */
			$('button[id=accounting-bill-submit-edit]').live('click',function() {
			
			var inc  = 0;
			
			var u    = 0;
			
			var bill = {};
			
				$('.accounting-form_bill_controller-form-transaction').find('input,select').each(function(i) {
				
				var id = $(this).attr('id');

					if (typeof id !== "undefined") {
												
						bill [id] = $(this).val();
						
					}
								
				});
				
				bill['item-row'] = $('.accounting-transaction-table tbody').find('.accounting-bill-item-row').length;
				
				bill['account-row'] = $('.accounting-transaction-table tbody').find('.accounting-bill-account-row').length;
				
				bill['line item'] = {};
				
				$('.accounting-transaction-table tbody tr.accounting-bill-item-row').each(function(i) {
										
					++inc;
					
					$(this).find('input[id=position]').val(inc);
					
					bill['line item'][u] = {};
					
					$(this).find('input').each(function(a) {
					
					var id = $(this).attr('id');
					
						if (typeof id !== "undefined") {
													
							bill['line item'][u][id] = $(this).val();
							
						}
						
					});
					
					++u;
													
				})
				
				inc = 0;
				
				$('.accounting-transaction-table tbody tr.accounting-bill-account-row').each(function(i) {
										
					++inc;
					
					$(this).find('input[id=position]').val(inc);
					
					bill['line item'][u] = {};
					
					$(this).find('input').each(function(a) {
					
					var id = $(this).attr('id');
					
						if (typeof id !== "undefined") {
													
							bill['line item'][u][id] = $(this).val();
							
						}
						
					});
					
					++u;
													
				})
				
				bill ['deleted-line-item'] = deleteTransactionLineItem;
				console.log(bill);
				var capsule = {"data":bill, "control": "bill_update", "capsuleCSRFToken": $('#capsuleCSRFToken').val()};

				var request = $.ajax({
				
				  url: "/cornc/library/capsule/accounting/accounting.ajax.php",
				  
				  type: "post",
				  
				  data: {data:capsule},
				  
				  dataType: "json"
				  
				});
				
				request.done(function(msg) {
				
					if (msg.response == "success") {
												
						location.href = 'http://' + window.location.hostname + window.location.pathname + '?actio=view|||bill|||' + msg.id + '&emblem=' + msg.token;
																		
					}
					else {

						$('#capsuleCSRFToken').val(msg.token);

					}
					
				console.log(msg);
					
				});
				
				request.fail(function(jqXHR, textStatus) {
				
					console.log(jqXHR);
					
				});		
				
			return false;		
							
			});
			
			/*
		    * Button Binder - create new invoice
		    *
		    * @selector tag button[id=accounting-invoice-submit-new]
		    * @action show modal window
		    * @function displayModal
		    */
			$('button[id=accounting-salesreceipt-submit-new]').live('click',function() {
			
			$(this).button('loading');

			var inc = 0;
			
			var salesreceipt = {};
			
				$('.accounting-form_salesreceipt_controller-form-transaction').find('input,select').each(function(i) {
				
				var id = $(this).attr('id');

					if (typeof id !== "undefined") {
												
						salesreceipt [id] = $(this).val();
						
					}
								
				});

				salesreceipt['item-row']  = $('.accounting-transaction-table tbody').find('.accounting-salesreceipt-item-row').length;

				salesreceipt['line item'] = {};
				
				$('.accounting-transaction-table tbody tr').each(function(i) {
					
					++inc;
					
					$(this).find('input[id=position]').val(inc);
					
					salesreceipt['line item'][i] = {};
					
					$(this).find('input').each(function(a) {
					
					var id = $(this).attr('id');
					
						if (typeof id !== "undefined") {
													
							salesreceipt['line item'][i][id] = $(this).val();
							
						}
						
					});
													
				})
																			
				var capsule = {"data":salesreceipt, "control": "salesreceipt_create", "capsuleCSRFToken": $('#capsuleCSRFToken').val()};

				var request = $.ajax({
				
				  url: "/cornc/library/capsule/accounting/accounting.ajax.php",
				  
				  type: "post",
				  
				  data: {data:capsule},
				  
				  dataType: "json"
				  
				});
				
				request.done(function(msg) {
					
					if (msg.response == "success") {
												
						location.href = 'http://' + window.location.hostname + window.location.pathname + '?actio=view|||sales-receipt|||' + msg.id + '&emblem=' + msg.token;
																		
					}
					else {

						$('#capsuleCSRFToken').val(msg.token);

					}

				console.log(msg);
					
				});
				
				request.fail(function(jqXHR, textStatus) {
				
					console.log(jqXHR);
					
				});		
				
			return false;		
							
			});
			
			/*
		    * Button Binder - edit bill
		    *
		    * @selector tag button[id=accounting-bill-submit-edit]
		    * @action show modal window
		    * @function displayModal
		    */
			$('button[id=accounting-salesreceipt-submit-edit]').live('click',function() {
			
			$(this).button('loading');

			var inc = 0;
			
			var salesreceipt = {};
			
				$('.accounting-form_salesreceipt_controller-form-transaction').find('input,select').each(function(i) {
				
				var id = $(this).attr('id');

					if (typeof id !== "undefined") {
												
						salesreceipt [id] = $(this).val();
						
					}
								
				});
				
				salesreceipt['item-row']  = $('.accounting-transaction-table tbody').find('.accounting-salesreceipt-item-row').length;

				salesreceipt['line item'] = {};
				
				$('.accounting-transaction-table tbody tr').each(function(i) {
					
					++inc;
					
					$(this).find('input[id=position]').val(inc);
					
					salesreceipt['line item'][i] = {};
					
					$(this).find('input').each(function(a) {
					
					var id = $(this).attr('id');
					
						if (typeof id !== "undefined") {
													
							salesreceipt['line item'][i][id] = $(this).val();
							
						}
						
					});
													
				})
				
				salesreceipt ['deleted-line-item'] = deleteTransactionLineItem;
																			
				var capsule = {"data":salesreceipt, "control": "salesreceipt_update", "capsuleCSRFToken": $('#capsuleCSRFToken').val()};

				var request = $.ajax({
				
				  url: "/cornc/library/capsule/accounting/accounting.ajax.php",
				  
				  type: "post",
				  
				  data: {data:capsule},
				  
				  dataType: "json"
				  
				});
				
				request.done(function(msg) {
				
					if (msg.response == "success") {
												
						salesreceipt ['deleted-line-item'] = null;

						location.href = 'http://' + window.location.hostname + window.location.pathname + '?actio=view|||sales-receipt|||' + msg.id + '&emblem=' + msg.token;
																		
					}
					else {

						//$('#capsuleCSRFToken').val(msg.token);

						salesreceipt ['deleted-line-item'] = null;

					}

				console.log(msg);
					
				});
				
				request.fail(function(jqXHR, textStatus) {
				
					console.log(jqXHR);
					
				});		
				
			return false;		
							
			});
			
			/*
		    * Button Binder - create new receipt
		    *
		    * @selector tag button[id=accounting-bill-submit-new]
		    * @action show modal window
		    * @function displayModal
		    */
			$('button[id=accounting-receipt-submit-new]').live('click',function() {
			
			var inc  = 0;
			
			var u    = 0;
			
			var receipt = {};
			
				$('.accounting-form_receipt_controller-form-transaction').find('input,select').each(function(i) {
				
				var id = $(this).attr('id');

					if (typeof id !== "undefined") {
												
						receipt [id] = $(this).val();
						
					}
								
				});
				
				receipt['item-row'] = $('.accounting-transaction-table tbody').find('.accounting-receipt-item-row').length;
				
				receipt['account-row'] = $('.accounting-transaction-table tbody').find('.accounting-receipt-account-row').length;
				
				receipt['line item'] = {};
				
				$('.accounting-transaction-table tbody tr.accounting-receipt-item-row').each(function(i) {
										
					++inc;
					
					$(this).find('input[id=position]').val(inc);
					
					receipt['line item'][u] = {};
					
					$(this).find('input').each(function(a) {
					
					var id = $(this).attr('id');
					
						if (typeof id !== "undefined") {
													
							receipt['line item'][u][id] = $(this).val();
							
						}
						
					});
					
					++u;
													
				})
				
				inc = 0;
				
				$('.accounting-transaction-table tbody tr.accounting-receipt-account-row').each(function(i) {
										
					++inc;
					
					$(this).find('input[id=position]').val(inc);
					
					receipt['line item'][u] = {};
					
					$(this).find('input').each(function(a) {
					
					var id = $(this).attr('id');
					
						if (typeof id !== "undefined") {
													
							receipt['line item'][u][id] = $(this).val();
							
						}
						
					});
					
					++u;
													
				})
																			
				var capsule = {"data":receipt, "control": "receipt_create", "capsuleCSRFToken": $('#capsuleCSRFToken').val()};

				var request = $.ajax({
				
				  url: "/cornc/library/capsule/accounting/accounting.ajax.php",
				  
				  type: "post",
				  
				  data: {data:capsule},
				  
				  dataType: "json"
				  
				});
				
				request.done(function(msg) {
				
					if (msg.response == "success") {
												
						location.href = 'http://' + window.location.hostname + window.location.pathname + '?actio=view|||receipt|||' + msg.id + '&emblem=' + msg.token;
																		
					}
					else {

						$('#capsuleCSRFToken').val(msg.token);

					}
					
				console.log(msg);
					
				});
				
				request.fail(function(jqXHR, textStatus) {
				
					console.log(jqXHR);
					
				});		
				
			return false;		
							
			});
			
			/*
		    * Button Binder - edit receipt
		    *
		    * @selector tag button[id=accounting-bill-submit-new]
		    * @action show modal window
		    * @function displayModal
		    */
			$('button[id=accounting-receipt-submit-edit]').live('click',function() {
			
			var inc  = 0;
			
			var u    = 0;
			
			var receipt = {};
			
				$('.accounting-form_receipt_controller-form-transaction').find('input,select').each(function(i) {
				
				var id = $(this).attr('id');

					if (typeof id !== "undefined") {
												
						receipt [id] = $(this).val();
						
					}
								
				});
				
				receipt['item-row'] = $('.accounting-transaction-table tbody').find('.accounting-receipt-item-row').length;
				
				receipt['account-row'] = $('.accounting-transaction-table tbody').find('.accounting-receipt-account-row').length;
				
				receipt['line item'] = {};
				
				$('.accounting-transaction-table tbody tr.accounting-receipt-item-row').each(function(i) {
										
					++inc;
					
					$(this).find('input[id=position]').val(inc);
					
					receipt['line item'][u] = {};
					
					$(this).find('input').each(function(a) {
					
					var id = $(this).attr('id');
					
						if (typeof id !== "undefined") {
													
							receipt['line item'][u][id] = $(this).val();
							
						}
						
					});
					
					++u;
													
				})
				
				inc = 0;
				
				$('.accounting-transaction-table tbody tr.accounting-receipt-account-row').each(function(i) {
										
					++inc;
					
					$(this).find('input[id=position]').val(inc);
					
					receipt['line item'][u] = {};
					
					$(this).find('input').each(function(a) {
					
					var id = $(this).attr('id');
					
						if (typeof id !== "undefined") {
													
							receipt['line item'][u][id] = $(this).val();
							
						}
						
					});
					
					++u;
													
				})
				
				receipt ['deleted-line-item'] = deleteTransactionLineItem;
				
				var capsule = {"data":receipt, "control": "receipt_update", "capsuleCSRFToken": $('#capsuleCSRFToken').val()};

				var request = $.ajax({
				
				  url: "/cornc/library/capsule/accounting/accounting.ajax.php",
				  
				  type: "post",
				  
				  data: {data:capsule},
				  
				  dataType: "json"
				  
				});
				
				request.done(function(msg) {
				
					if (msg.response == "success") {
												
						location.href = 'http://' + window.location.hostname + window.location.pathname + '?actio=view|||receipt|||' + msg.id + '&emblem=' + msg.token;
																		
					}
					else {

						$('#capsuleCSRFToken').val(msg.token);

					}
					
				console.log(msg);
					
				});
				
				request.fail(function(jqXHR, textStatus) {
				
					console.log(jqXHR);
					
				});		
				
			return false;		
							
			});
			
			/*
		    * Button Binder - create new transfer
		    *
		    * @selector tag button[id=accounting-invoice-submit-new]
		    * @action show modal window
		    * @function displayModal
		    */
			$('button[id=accounting-transfer-submit-new]').live('click',function() {
			
			$(this).button('loading');

			var inc = 0;
			
			var transfer = {};
			
				$('.accounting-form_transfer_controller-form-transaction').find('input,select').each(function(i) {
				
				var id = $(this).attr('id');

					if (typeof id !== "undefined") {
												
						transfer [id] = $(this).val();
						
					}
								
				});

				transfer['item-row']  = $('.accounting-transaction-table tbody').find('.accounting-transfer-item-row').length;

				transfer['line item'] = {};
				
				$('.accounting-transaction-table tbody tr').each(function(i) {
					
					++inc;
					
					$(this).find('input[id=position]').val(inc);
					
					transfer['line item'][i] = {};
					
					$(this).find('input').each(function(a) {
					
					var id = $(this).attr('id');
					
						if (typeof id !== "undefined") {
													
							transfer['line item'][i][id] = $(this).val();
							
						}
						
					});
													
				})
																			
				var capsule = {"data":transfer, "control": "transfer_create", "capsuleCSRFToken": $('#capsuleCSRFToken').val()};

				var request = $.ajax({
				
				  url: "/cornc/library/capsule/accounting/accounting.ajax.php",
				  
				  type: "post",
				  
				  data: {data:capsule},
				  
				  dataType: "json"
				  
				});
				
				request.done(function(msg) {
					
					if (msg.response == "success") {
												
						location.href = 'http://' + window.location.hostname + window.location.pathname + '?actio=view|||transfer|||' + msg.id + '&emblem=' + msg.token;
																		
					}
					else {

						$('#capsuleCSRFToken').val(msg.token);

					}

				console.log(msg);
					
				});
				
				request.fail(function(jqXHR, textStatus) {
				
					console.log(jqXHR);
					
				});		
				
			return false;		
							
			});
			
			/*
		    * Button Binder - edit transfer
		    *
		    * @selector tag button[id=accounting-bill-submit-new]
		    * @action show modal window
		    * @function displayModal
		    */
			$('button[id=accounting-transfer-submit-edit]').live('click',function() {
			
			var inc  = 0;
			
			var u    = 0;
			
			var transfer = {};
			
				$('.accounting-form_transfer_controller-form-transaction').find('input,select').each(function(i) {
				
				var id = $(this).attr('id');

					if (typeof id !== "undefined") {
												
						transfer [id] = $(this).val();
						
					}
								
				});
				
				transfer['item-row'] = $('.accounting-transaction-table tbody').find('.accounting-transfer-item-row').length;
								
				transfer['line item'] = {};
				
				$('.accounting-transaction-table tbody tr.accounting-transfer-item-row').each(function(i) {
										
					++inc;
					
					$(this).find('input[id=position]').val(inc);
					
					transfer['line item'][u] = {};
					
					$(this).find('input').each(function(a) {
					
					var id = $(this).attr('id');
					
						if (typeof id !== "undefined") {
													
							transfer['line item'][u][id] = $(this).val();
							
						}
						
					});
					
					++u;
													
				})
								
				transfer ['deleted-line-item'] = deleteTransactionLineItem;

				var capsule = {"data":transfer, "control": "transfer_update", "capsuleCSRFToken": $('#capsuleCSRFToken').val()};

				var request = $.ajax({
				
				  url: "/cornc/library/capsule/accounting/accounting.ajax.php",
				  
				  type: "post",
				  
				  data: {data:capsule},
				  
				  dataType: "json"
				  
				});
				
				request.done(function(msg) {
				
					if (msg.response == "success") {
												
						location.href = 'http://' + window.location.hostname + window.location.pathname + '?actio=view|||transfer|||' + msg.id + '&emblem=' + msg.token;
																		
					}
					else {

						$('#capsuleCSRFToken').val(msg.token);

					}
					
				console.log(msg);
					
				});
				
				request.fail(function(jqXHR, textStatus) {
				
					console.log(jqXHR);
					
				});		
				
			return false;		
							
			});
			
			/*
		    * Button Binder - create new payment
		    *
		    * @selector tag button[id=accounting-payment-submit-new]
		    * @action show modal window
		    * @function displayModal
		    */
			$('.accounting-checkbox-checker').click(function() {
    			
    			var check = $(this).prop("checked");
    			
				if (check == true) {
				
				    var checknd = $(this).parent().find('#item-pid').val();
				    
				    if (checknd != '') {
    				        				    
    				    deleteTransactionLineItem.pop(checknd);
    				        				    
				    }
				
				}
				else {
    				
    				var checknd = $(this).parent().find('#item-pid').val();
				    
				    if (checknd != '') {
    				                                				    
    				    deleteTransactionLineItem.push(checknd);
    				    
				    }
    				
				}
				    			
			});
			
			/*
		    * Button Binder - create new payment
		    *
		    * @selector tag button[id=accounting-payment-submit-new]
		    * @action show modal window
		    * @function displayModal
		    */
			$('button[id=accounting-payment-submit-new]').live('click',function() {
			
			$(this).button('loading');

			var inc = 0;
			
			var payment = {};
			
				$('.accounting-form_payment_controller-form-transaction').find('input,select').each(function(i) {
				
				var id = $(this).attr('id');

					if (typeof id !== "undefined") {
												
						payment [id] = $(this).val();
						
					}
								
				});

				payment['item-row']  = $('.accounting-transaction-table-payment tbody').find('.accounting-payment-item-row:visible').length;

				payment['line item'] = {};
				
				$('.accounting-transaction-table-payment tbody tr:visible').each(function(i) {
					
					var check = $(this).find('input[type=checkbox]').prop("checked");

					if (check == true) { 
										
					++inc;
					
					$(this).find('input[id=position]').val(inc);
					
					payment['line item'][i] = {};
					
    					$(this).find('input').each(function(a) {
    					
    					var id = $(this).attr('id');
    					
    						if (typeof id !== "undefined") {
    													
    							payment['line item'][i][id] = $(this).val();
    							
    						}
    						
    					});
					
					}
													
				});
								
				var capsule = {"data":payment, "control": "payment_create", "capsuleCSRFToken": $('#capsuleCSRFToken').val()};

				var request = $.ajax({
				
				  url: "/cornc/library/capsule/accounting/accounting.ajax.php",
				  
				  type: "post",
				  
				  data: {data:capsule},
				  
				  dataType: "json"
				  
				});
				
				request.done(function(msg) {
					
					if (msg.response == "success") {
												
						location.href = 'http://' + window.location.hostname + window.location.pathname + '?actio=view|||payment|||' + msg.id + '&emblem=' + msg.token;
																		
					}
					else {

						$('#capsuleCSRFToken').val(msg.token);

					}

				console.log(msg);
					
				});
				
				request.fail(function(jqXHR, textStatus) {
				
					console.log(jqXHR);
					
				});		
				
			return false;		
							
			});
			
			/*
		    * Button Binder - create edit payment
		    *
		    * @selector tag button[id=accounting-payment-submit-edit]
		    * @action show modal window
		    * @function displayModal
		    */
			$('button[id=accounting-payment-submit-edit]').live('click',function() {
			
			$(this).button('loading');

			var inc = 0;
			
			var payment = {};
			
				$('.accounting-form_payment_controller-form-transaction').find('input,select').each(function(i) {
				
				var id = $(this).attr('id');

					if (typeof id !== "undefined") {
												
						payment [id] = $(this).val();
						
					}
								
				});

				payment['item-row']  = $('.accounting-transaction-table-payment tbody').find('.accounting-payment-item-row:visible').length;

				payment['line item'] = {};
				
				$('.accounting-transaction-table-payment tbody tr:visible').each(function(i) {
					
					var check = $(this).find('input[type=checkbox]:visible').prop("checked");

					if (check == true) { 
										
					++inc;
					
					$(this).find('input[id=position]').val(inc);
					
					payment['line item'][i] = {};
					
    					$(this).find('input').each(function(a) {
    					
    					var id = $(this).attr('id');
    					
    						if (typeof id !== "undefined") {
    													
    							payment['line item'][i][id] = $(this).val();
    							
    						}
    						
    					});
					
					}
													
				})
				
				payment ['deleted-line-item'] = deleteTransactionLineItem;
				
				var capsule = {"data":payment, "control": "payment_update", "capsuleCSRFToken": $('#capsuleCSRFToken').val()};

				var request = $.ajax({
				
				  url: "/cornc/library/capsule/accounting/accounting.ajax.php",
				  
				  type: "post",
				  
				  data: {data:capsule},
				  
				  dataType: "json"
				  
				});
				
				request.done(function(msg) {
					
					if (msg.response == "success") {
												
						location.href = 'http://' + window.location.hostname + window.location.pathname + '?actio=view|||payment|||' + msg.id + '&emblem=' + msg.token;
																		
					}
					else {

						$('#capsuleCSRFToken').val(msg.token);

					}

				console.log(msg);
					
				});
				
				request.fail(function(jqXHR, textStatus) {
				
					console.log(jqXHR);
					
				});		
				
			return false;		
							
			});
			
			/*
		    * Button Binder - create new paybill
		    *
		    * @selector tag button[id=accounting-payment-submit-new]
		    * @action show modal window
		    * @function displayModal
		    */
			$('button[id=accounting-paybill-submit-new]').live('click',function() {
			
			$(this).button('loading');

			var inc = 0;
			
			var payment = {};
			
				$('.accounting-form_paybill_controller-form-transaction').find('input,select').each(function(i) {
				
				var id = $(this).attr('id');

					if (typeof id !== "undefined") {
												
						payment [id] = $(this).val();
						
					}
								
				});

				payment['item-row']  = $('.accounting-transaction-table-payment tbody').find('.accounting-payment-item-row:visible').length;

				payment['line item'] = {};
				
				$('.accounting-transaction-table-payment tbody tr:visible').each(function(i) {
					
					var check = $(this).find('input[type=checkbox]').prop("checked");

					if (check == true) { 
										
					++inc;
					
					$(this).find('input[id=position]').val(inc);
					
					payment['line item'][i] = {};
					
    					$(this).find('input').each(function(a) {
    					
    					var id = $(this).attr('id');
    					
    						if (typeof id !== "undefined") {
    													
    							payment['line item'][i][id] = $(this).val();
    							
    						}
    						
    					});
					
					}
													
				});
								
				var capsule = {"data":payment, "control": "paybill_create", "capsuleCSRFToken": $('#capsuleCSRFToken').val()};

				var request = $.ajax({
				
				  url: "/cornc/library/capsule/accounting/accounting.ajax.php",
				  
				  type: "post",
				  
				  data: {data:capsule},
				  
				  dataType: "json"
				  
				});
				
				request.done(function(msg) {
					
					if (msg.response == "success") {
												
						location.href = 'http://' + window.location.hostname + window.location.pathname + '?actio=view|||paybill|||' + msg.id + '&emblem=' + msg.token;
																		
					}
					else {

						$('#capsuleCSRFToken').val(msg.token);

					}

				console.log(msg);
					
				});
				
				request.fail(function(jqXHR, textStatus) {
				
					console.log(jqXHR);
					
				});		
				
			return false;		
							
			});
			
			/*
		    * Button Binder - create edit paybill
		    *
		    * @selector tag button[id=accounting-payment-submit-edit]
		    * @action show modal window
		    * @function displayModal
		    */
			$('button[id=accounting-paybill-submit-edit]').live('click',function() {
			
			$(this).button('loading');

			var inc = 0;
			
			var payment = {};
			
				$('.accounting-form_paybill_controller-form-transaction').find('input,select').each(function(i) {
				
				var id = $(this).attr('id');

					if (typeof id !== "undefined") {
												
						payment [id] = $(this).val();
						
					}
								
				});

				payment['item-row']  = $('.accounting-transaction-table-payment tbody').find('.accounting-payment-item-row:visible').length;

				payment['line item'] = {};
				
				$('.accounting-transaction-table-payment tbody tr:visible').each(function(i) {
					
					var check = $(this).find('input[type=checkbox]:visible').prop("checked");

					if (check == true) { 
										
					++inc;
					
					$(this).find('input[id=position]').val(inc);
					
					payment['line item'][i] = {};
					
    					$(this).find('input').each(function(a) {
    					
    					var id = $(this).attr('id');
    					
    						if (typeof id !== "undefined") {
    													
    							payment['line item'][i][id] = $(this).val();
    							
    						}
    						
    					});
					
					}
													
				})
				
				payment ['deleted-line-item'] = deleteTransactionLineItem;
				
				var capsule = {"data":payment, "control": "paybill_update", "capsuleCSRFToken": $('#capsuleCSRFToken').val()};

				var request = $.ajax({
				
				  url: "/cornc/library/capsule/accounting/accounting.ajax.php",
				  
				  type: "post",
				  
				  data: {data:capsule},
				  
				  dataType: "json"
				  
				});
				
				request.done(function(msg) {
					
					if (msg.response == "success") {
												
						location.href = 'http://' + window.location.hostname + window.location.pathname + '?actio=view|||paybill|||' + msg.id + '&emblem=' + msg.token;
																		
					}
					else {

						$('#capsuleCSRFToken').val(msg.token);

					}

				console.log(msg);
					
				});
				
				request.fail(function(jqXHR, textStatus) {
				
					console.log(jqXHR);
					
				});		
				
			return false;		
							
			});
			
			/*
		    * Button Binder - Transaction table controller
		    *
		    * @selector tag #accounting-table_transaction-table ul li a
		    * @action show modal window
		    * @function displayModal
		    */
			$('#accounting-table_transaction-table ul li a').live('click',function (e) {
						
			var table = $(this).attr('href');
			
			var capsule = {"data":table, "control": "transaction_table", "capsuleCSRFToken": $('#capsuleCSRFToken').val()};

				var request = $.ajax({
				
				  url: "/cornc/library/capsule/accounting/accounting.ajax.php",
				  
				  type: "post",
				  
				  data: {data:capsule},
				  
				  dataType: "json"
				
				});
				
				request.done(function(msg) {
					
				console.log(msg.debug);
					
					if (msg.response == "success") {

						$('#capsuleCSRFToken').val(msg.token);
						
						$('.tab-loader').html(msg.view).show();
																								
					}
					else {
						
						$('#capsuleCSRFToken').val(msg.token);
						
					}
					
				});
				
				request.fail(function(jqXHR, textStatus) {
				
					console.log(jqXHR);
					
				});
			
		    e.preventDefault();
	
		    });
			
			$('form.form_user_accountAdd button.btn').find('').live('click', function(){
				console.log('why?');
				$(this).attr("disabled='disabled'");
				
				var data = [];
				
				$('.form_user_accountAdd input').each(function(i){
					data[i] = $(this).val();
				});		
				var capsule = {"data":data, "control": "form_user_accountAdd", "capsuleCSRFToken": $('#capsuleCSRFToken').val()};
				var request = $.ajax({
				
				  url: "/cornc/library/capsule/accounting/accounting.ajax.php",
				  
				  type: "POST",
				  
				  data: {data:capsule},
				  
				  dataType: "json"
				  
				});
				
				request.done(function(msg) {
				
					if (msg.response == "success") {
						
						deleteAccount = '';
						
						$('#capsuleCSRFToken').val(msg.token);
									
						closeModal('accounting-actionbar_coa-coa','hide');				
																							
					}
					else {
											
						$('#capsuleCSRFToken').val(msg.token);
						
					}
					
				//console.log(msg);
					
				});
				
				request.fail(function(jqXHR, textStatus) {
				
					console.log(jqXHR);
					
				});

				
			});
					
		}
	
	});
	
});