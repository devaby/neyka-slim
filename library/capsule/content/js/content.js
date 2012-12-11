jQuery.noConflict()(function($){

$('.imageBox-boxImageContent').hide();

	$(document).ready(function() {

		$('div.imageBox-boxImageContent[numbering=1]').show();
		$('.imageBox-counterUl li:first').addClass('imageBox-counterLiActive');

		$('.imageBox-counterUl li').click(function() {
		$('.imageBox-counterUl li').removeClass('imageBox-counterLiActive');
		$(this).addClass('imageBox-counterLiActive');
		var id = $(this).val();
		$('.imageBox-boxImageContent').hide();
		$('div.imageBox-boxImageContent[numbering='+id+']').show();
		});

		$('.white-box-left a').qtip({
		content: {
		      attr: 'text' // Notice that content.text is long-hand for simply declaring content as a string
		   },
		position: {
		      my: 'left center',  // Position my top left...
		      at: 'right center' // at the bottom right of...
		   },
		style: {
		      classes: 'ui-tooltip-dark ui-tooltip-shadow'
		   }
		});
	/*
	$('.two-column-container-left').waypoint({
   		handler: function(event, direction) {
      	var top_spacing = 15;
		var waypoint_offset = 50;
      		if (direction == 'down') {
  			$(this).css("position","fixed").css("top","15px").stop()
         .css("top", -$(this).outerHeight())
         .animate({"top" : top_spacing});
  			}
			else {
  			$(this).attr("style","");
      		}
  	 	}
	
	});
	*/
	
	//$('.system-marquee').marquee();
	
	//$('#system-marquee').fadeIn('slow');
	
	//$('#system-marquee').show();
	
	//$('#webticker').webTicker();
	/*
	$('.system-marquee').marquee().mouseover(function () {
            $(this).trigger('stop');
        }).mouseout(function () {
            $(this).trigger('start');
        }).mousemove(function (event) {
            if ($(this).data('drag') == true) {
                this.scrollLeft = $(this).data('scrollX') + ($(this).data('x') - event.clientX);
            }
        }).mousedown(function (event) {
            $(this).data('drag', true).data('x', event.clientX).data('scrollX', this.scrollLeft);
        }).mouseup(function () {
            $(this).data('drag', false);
        });
    */

});

});