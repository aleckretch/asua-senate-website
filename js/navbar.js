$(function() {
	
	var  mn = $(".slide-header");
		mns = "main-nav-scrolled";
		hdr = $('#top-full-splash').height()+50;

	$(window).scroll(function() {
	  if( $(this).scrollTop() > hdr ) {
		mn.addClass(mns);
		$('#slide-images').css('display','block');
	  } else {
		mn.removeClass(mns);
		$('#slide-images').css('display','none');
	  }
	});
	
	$('#slide-wrapper').css("top", $('#top-full-splash').height() + 150);
	
	$(window).on('resize', function() {
		
		hdr = $('#top-full-splash').height() + 100;
		$('#slide-wrapper').css("top", $('#top-full-splash').height() + 150);
		
	});

});

