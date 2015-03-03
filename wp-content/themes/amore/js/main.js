$(function(){			
	// Initialize menu plugin
	var menu_primary = $('#menu-primary').superfish({
		//add options here if required
	});		
		
	// Highlight menu. Will also work for relative and absolute hrefs
	var url = window.location.href;	
	
	$('.sf-menu a').filter(function() {			
		return this.href == url;
	}).addClass('active');	
});