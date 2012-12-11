jQuery.noConflict()(function($){
$(document).ready(function() {


	$('.contact-normal-send').click(function() {
	
	$('.contact-normal-input').removeClass('contact-normal-falseinput');
	
	var message = [];
	
	function validateEmail(elementValue){
	var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
	return emailPattern.test(elementValue);
	}
	
	function isNumber(n) {
	return !isNaN(parseFloat(n)) && isFinite(n);
	}
	
	$.fn.centerFixed = function () {
	    this.css("position","fixed");
	    this.css("top", (($(window).height() - this.outerHeight()) / 2) + $(window).scrollTop() + "px");
	    this.css("left", (($(window).width() - this.outerWidth()) / 2) + $(window).scrollLeft() + "px");
	    return this;
	}
	
		$('.contact-normal-table').find('input,textarea').each(function(i) {
		
		message[i] = $(this).val();
		
		});
	
	var init = $(this).parent().parent().parent().find('input[type="hidden"][name="initWithOption"]').val();
	
		$('.contact-normal-notificationContainer').remove();
	
		var container = "<div class='contact-normal-notificationContainer'></div>";
		
		$.post('library/capsule/contact/contact.ajax.php', {message:message,init:init,control:'sendMessage'}, function(data) {
		
		var result = $.parseJSON(data);
		
			if (result != null) {
			
				$(result).each(function(i) {
				
				$('.contact-normal-input[name="'+result[i]+'"]').addClass('contact-normal-falseinput');
				
				});
			
			return false;
			
			}
		
		$('.contact-normal-input,.contact-normal-textarea').val('');
				
		$('body').append(container); 
		$('.contact-normal-notificationContainer').centerFixed();
		$('.contact-normal-notificationContainer').html(data);
		
		});
			
		return false;
	
	});
	
	
	$('.contact-quickBlackContact-send').click(function() {
	
	$('.contact-quickBlackContact-input').removeClass('contact-quickBlackContact-falseinput');
	
	var message = [];
	
	function validateEmail(elementValue){
	var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
	return emailPattern.test(elementValue);
	}
	
	function isNumber(n) {
	return !isNaN(parseFloat(n)) && isFinite(n);
	}
	
	$.fn.centerFixed = function () {
	    this.css("position","fixed");
	    this.css("top", (($(window).height() - this.outerHeight()) / 2) + $(window).scrollTop() + "px");
	    this.css("left", (($(window).width() - this.outerWidth()) / 2) + $(window).scrollLeft() + "px");
	    return this;
	}
	
		$('.contact-quickBlackContact-table').find('input,textarea').each(function(i) {
		
		message[i] = $(this).val();
		
		});
	
	var init = $(this).parent().parent().parent().find('input[type="hidden"][name="initWithOption"]').val();
	
		$('.contact-quickBlackContact-notificationContainer').remove();
	
		var container = "<div class='contact-quickBlackContact-notificationContainer'></div>";
		
		$.post('library/capsule/contact/contact.ajax.php', {message:message,init:init,control:'sendMessage'}, function(data) {
		
		var result = $.parseJSON(data);
		
			if (result != null) {
			
				$(result).each(function(i) {
				
				$('.contact-quickBlackContact-input[name="'+result[i]+'"]').addClass('contact-normal-falseinput');
				
				});
			
			return false;
			
			}
		
		$('.contact-quickBlackContact-input,.contact-quickBlackContact-textarea').val('');
				
		$('body').append(container); 
		$('.contact-quickBlackContact-notificationContainer').centerFixed();
		$('.contact-quickBlackContact-notificationContainer').html(data);
		
		});
			
		return false;
	
	});
	

});
});