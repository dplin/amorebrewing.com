$(function(){
	$('.models_container div').hover(function(){	
		// Hoever In
		$(this).children('.model_overlay').fadeIn();		
	}, function(){
		// Hover Out
		$(this).children('.model_overlay').fadeOut(200);		
	});	
});
