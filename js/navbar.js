$(function() {
	
	var  mn = $(".slide-header");
		mns = "main-nav-scrolled";
		hdr = $('#top-full-splash').height()+50;
	//This controls the sticky behavior of the navbar and toggles the red bit with the logos above it.
	$(window).scroll(function() {
	  if( $(this).scrollTop() > hdr ) {
		mn.addClass(mns);
		$('#slide-images').css('display','block');
	  } else {
		mn.removeClass(mns);
		$('#slide-images').css('display','none');
	  }
	});
	//This sets our nav bar to the bottom of our image, because it scales responsively with the width. 
	$(window).load(function() {
		hdr = $('#top-full-splash').height()+50;
		$('#slide-wrapper').css("top", $('#top-full-splash').height() + 150);

	
	});
		
		//This makes sure that if the size changes on-the-fly that the navbar sticks to the bottom of our senate splash picture.
	$(window).on('resize', function() {
		hdr = $('#top-full-splash').height() + 100;
		$('#slide-wrapper').css("top", $('#top-full-splash').height() + 150);
		
	});

});

