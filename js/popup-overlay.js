
$(document).ready(function() {
	// Initialize the plugin
	$('.popup').popup({
		opacity: 0.5
	});
});
	
$(function() {
	$('.overlayIt').on('click',function(e) {
		e.preventDefault();
		$('.popup').popup('show');
		//openOverlay();
	});
	$('.popup_close').on('click',function(e){
		e.preventDefault();
		$('.popup').popup('hide');
	})
});