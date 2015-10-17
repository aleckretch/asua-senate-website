$(function() {
	//config variables
	var menuFadeTime = 300	
	var slideHeight = 50;	
	var hdrOffset = 0;		
	
	
	var  mn = $(".slide-header");
	var mns = "main-nav-scrolled";

	var	hdr = $('#top-full-splash').height() + hdrOffset;
	var menuFlag = false;
	
	//These two functions were going to be for the animation of the opacity on the navbar. Keeping them
	//just in case we decide to use them. If we do set hdrOffset = 20
	function showMenu() {
		$('#slide-images').animate({'opacity': 1.00}, menuFadeTime);
		menuFlag = true;
	}
	function hideMenu() {
		$('#slide-images').animate({'opacity': 0}, menuFadeTime);
		menuFlag = false;
	}
	
	//This controls the sticky behavior of the navbar and toggles the red bit with the logos above it.
	$(window).scroll(function() {
	  if( $(this).scrollTop() > hdr ) {
		mn.addClass(mns);
		$('#slide-images').css('opacity','1');
// 		if(!menuFlag)
// 			showMenu();
	  } else {
		mn.removeClass(mns);
		$('#slide-images').css('opacity','0');
// 		if(menuFlag)
// 			hideMenu();
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

