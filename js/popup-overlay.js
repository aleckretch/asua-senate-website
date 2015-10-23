
$(document).ready(function() {
	// Initialize the plugin
	$('#popup').popup({
		opacity: 0.5,
		scrolllock: true
	});
});
	
$(function() {
	$('.overlayIt').on('click',function(e) {
		e.preventDefault();
		$('#popup').popup('show');
		//openOverlay();
	});
});