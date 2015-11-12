
$(document).ready(function() {
	// Initialize the plugin
	$('.s1').popup({
		opacity: 0.5
	});
	$('.s2').popup({
		opacity: 0.5
	});
	$('.s3').popup({
		opacity: 0.5
	});
	$('.s4').popup({
		opacity: 0.5
	});
	$('.s5').popup({
		opacity: 0.5
	});
	$('.s6').popup({
		opacity: 0.5
	});
	$('.s7').popup({
		opacity: 0.5
	});
	$('.s8').popup({
		opacity: 0.5
	});
	$('.s9').popup({
		opacity: 0.5
	});
	$('.s10').popup({
		opacity: 0.5
	});
});
	
$(function() {
	$('.overlayIt1').on('click',function(e) {
		e.preventDefault();
		$('.s1').popup('show');
		//openOverlay();
	});
	$('.overlayIt2').on('click',function(e) {
		e.preventDefault();
		$('.s2').popup('show');
		//openOverlay();
	});
	$('.overlayIt3').on('click',function(e) {
		e.preventDefault();
		$('.s3').popup('show');
		//openOverlay();
	});
	$('.overlayIt4').on('click',function(e) {
		e.preventDefault();
		$('.s4').popup('show');
		//openOverlay();
	});
	$('.overlayIt5').on('click',function(e) {
		e.preventDefault();
		$('.s5').popup('show');
		//openOverlay();
	});
	$('.overlayIt6').on('click',function(e) {
		e.preventDefault();
		$('.s6').popup('show');
		//openOverlay();
	});
	$('.overlayIt7').on('click',function(e) {
		e.preventDefault();
		$('.s7').popup('show');
		//openOverlay();
	});
	$('.overlayIt8').on('click',function(e) {
		e.preventDefault();
		$('.s8').popup('show');
		//openOverlay();
	});
	$('.overlayIt9').on('click',function(e) {
		e.preventDefault();
		$('.s9').popup('show');
		//openOverlay();
	});
	$('.overlayIt10').on('click',function(e) {
		e.preventDefault();
		$('.s10').popup('show');
		//openOverlay();
	});
	$('.popup_close').on('click',function(e){
		e.preventDefault();
		$('.popup').popup('hide');
	})
});