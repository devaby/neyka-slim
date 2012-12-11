jQuery.noConflict()(function($){
$(document).ready(function() {
var iterationChecker;
var theMagnifitoCategory = $('.image-gallery-category li:first a').text();
$('.image-gallery-iterationImageContainer').hide();

imageIteration(theMagnifitoCategory);

$('.image-gallery-images').live('click', function() {
          var linkalita = $(this).attr('link');
          $('.image-gallery-fullImageContainer').remove();
          $('body').append('<div class=\'image-gallery-fullImageContainer\'><img class=\'image-gallery-fullImageContainerItem\' src=\"\"/><img class=\'image-gallery-fullImageContainerDel\' src=\'library/images/del.png\'/> </div><div class=\'totalOverlay\'></div>');
          		  
		  $('.image-gallery-fullImageContainerItem').attr('src', 'framework/resize.class.php?src='+linkalita+'&h=700&w=700&zc=3').load(function() {  
		     $('.image-gallery-fullImageContainer').hide().center().show(); 
		  }); 
		  
		   $('.image-gallery-fullImageContainer').draggable();
		   });
		   
		   $('.image-gallery-fullImageContainerDel').live('click', function() {
		   $('.image-gallery-fullImageContainer').remove();
		   $('.totalOverlay').remove();
		   });
		   
                $('.totalOverlay').live('click', function() {
		        
				 $('.image-gallery-fullImageContainer').remove();
				 				
			     $('.totalOverlay').remove();
				
				 });
	
	$('.image-gallery-category li a').click(function() {
		
		var qty = $('.image-gallery-iterationImageContainer img[category="'+iterationChecker+'"]').length; 
		var visible = $('.image-gallery-iterationImageContainer img[category="'+iterationChecker+'"]:visible').length;
		
		//if (qty != visible) {return false;}
		
		iterationChecker = 'dones';
								
		var category = $(this).text();
		
		$('.image-gallery-iterationImageContainer').hide();
		
		imageIteration(category);
				
	});
	
	$("a[rel^='prettyPhoto']").prettyPhoto({social_tools:false,show_title: false});
	
	function imageIteration(category) {
	iterationChecker = category;
	$('div[category="'+category+'"]').show(); $('div[category="'+category+'"] img').hide();
		$('.image-gallery-iterationImageContainer img[category="'+category+'"]').each(function(i) {
		i = i+1; 
		var next = $(this+'[position='+i+'][category="'+category+'"]');
		$(next).delay(i*50).fadeIn('fast');
		});
	}


});

});