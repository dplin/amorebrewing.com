$(function(){	
	$('.accordion > dd').hide();
		
	$('.accordion > dt > a').click(function() {
		var anchor = $(this);
			
		if($(this).parent().next().is(':hidden')) {							
			
			$('.accordion dd:visible').slideUp("fast", function(){
				$('.accordion i').removeClass('fa-caret-up').addClass('fa-caret-down');	
			});
			
			// hide
			$(this).parent().next().css({visibility: "hidden"});
			
			// Slide down current menu category
			$(this).parent().next().slideDown("fast", function(){
				// Move current menu category to top
				$('.accordion').animate({				
					top: $('.accordion').parent().offset().top - $(anchor).parent().offset().top
				}, 250);		
				
				// Change current panel icon to "Up"
				$('i', $(anchor)).removeClass('fa-caret-down').addClass('fa-caret-up');
				
				// Show content
				$(this).css({visibility: "visible", opacity: 0}).animate({opacity:1}, 250);	
			})			
		}else{
			// Close current panel
			$(this).parent().next().slideUp("fast");		
			// Change current panel icon to "Down"
			$('.accordion i').removeClass('fa-caret-up').addClass('fa-caret-down');		
			
			// Move accordion back to original position
			$('.accordion').animate({				
				top: "0"
			}, 200);		
		}	
			
		return false;
	});  

});


