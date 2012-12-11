jQuery.noConflict()(function($){
$(document).ready(function() {

var check = $('.user-name-normal').attr('login');

	if (check == 'yes') {

	//$(".menuList a[href='?id=862'], .menuList a[href='?id=925']").parent().parent().parent().parent().remove();
	
	$("nav a[href='?id=862'],nav a[href='?id=925']").parent().remove();
	
		$('.user-name-menu').hover(function() {
		$(this).toggleClass('user-name-menu-hover');
		});
	
	}

});
});