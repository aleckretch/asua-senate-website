$(function() {
	
	var  mn = $(".slide-header");
	var mns = "main-nav-scrolled";
	var slideHeight = 150;
	hdrOffset = 20;
	var	hdr = $('#top-full-splash').height() + hdrOffset;
	
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
		hdr = $('#top-full-splash').height() + hdrOffset;
		$('#slide-wrapper').css("top", $('#top-full-splash').height() + slideHeight );

		//Scrolls the page down a little so that the nav bar gets shown on large resolutions
		$( 'html,body').animate( {
			scrollTop: $( '#top-full-splash' ).height() - 515
		}, 75);

		//This adds smooth scrolling for each of the nav links, excluding the blog link
		$( 'nav a:not(#blogLink)' ).click( function() {
			var headID = $( this ).attr( "href" );
			var newPosition = $( headID ).offset().top - 100;
			console.log( newPosition );
			$('html,body').animate( {
			  scrollTop: newPosition
			}, 750);
			return false;
		});

	
	});
	//This makes sure that if the size changes on-the-fly that the navbar sticks to the bottom of our senate splash picture.
	$(window).on('resize', function() {
		hdr = $('#top-full-splash').height() + hdrOffset;
		$('#slide-wrapper').css("top", $('#top-full-splash').height() + slideHeight );
		
	});

});

