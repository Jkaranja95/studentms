$(document).ready(function() {
	//for fading in elements
	$(window).scroll( function(){
		$('.fadein').each( function(i){
			var bottom_of_element = $(this).offset().top + ($(this).outerHeight()/4);
			var bottom_of_window = $(window).scrollTop() + $(window).height();

			if( bottom_of_window > bottom_of_element ){
				$(this).animate({'opacity':'1'},1000);
			}

		}); 
	});

	//for sliding in elements
	$(window).scroll( function(){
		$('.slideinleft').each( function(i){

			var bottom_of_element = $(this).offset().top + ($(this).outerHeight()/4);
			var bottom_of_window = $(window).scrollTop() + $(window).height();

			if( bottom_of_window > bottom_of_element ){
				$(this).animate({'margin-left':'0px'},1000);
			}

		}); 
	});
	//for sliding in elements
	$(window).scroll( function(){
		$('.slideintop').each( function(i){

			var bottom_of_element = $(this).offset().top + ($(this).outerHeight()/8);
			var bottom_of_window = $(window).scrollTop() + $(window).height();

			if( bottom_of_window > bottom_of_element ){
				$(this).animate({'margin-top':'0px'},1000);
			}

		}); 
	});

	//on loading a document
	$('.slideinleft').each( function(i){

		var bottom_of_element = $(this).offset().top + ($(this).outerHeight()/4);
		var bottom_of_window = $(window).scrollTop() + $(window).height();

		if( bottom_of_window > bottom_of_element ){
			$(this).animate({'margin-left':'0px'},1000);
		}

	}); 

	$('.slideintop').each( function(i){

		var bottom_of_element = $(this).offset().top + ($(this).outerHeight()/8);
		var bottom_of_window = $(window).scrollTop() + $(window).height();

		if( bottom_of_window > bottom_of_element ){
			$(this).animate({'margin-top':'0px'},1000);
		}

	}); 
$('.fadein').each( function(i){
			var bottom_of_element = $(this).offset().top + ($(this).outerHeight()/4);
			var bottom_of_window = $(window).scrollTop() + $(window).height();

			if( bottom_of_window > bottom_of_element ){
				$(this).animate({'opacity':'1'},1000);
			}

		}); 
	
});