jQuery.noConflict()(function($){
$(document).ready(function() {

	$('.normal-submit').live('click',function() {
	
	var check;
	
		$('form[name=adminForm] input').each(function(i) {
		
			if ($(this).val() == '') {
			check = 0;
			}
		
		});
	
		if (check == 0) {
		alert('Username or Password cannot be empty'); return false;
		}
	
	});

});
});