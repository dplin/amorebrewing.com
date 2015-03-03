<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">                
		<title>
			<?php 
				echo get_bloginfo("name"); wp_title(' | ', true, 'left');
			?>
		</title>
		<meta name="description" content="Amore Brewing Co. imports high-end Italian espresso brewing systems that deliver barista quality coffee at the touch of a button">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<?php wp_head(); ?>		
	</head>
	<body>	
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->	
		<div class="bar"></div>
		<div class="container">			
			<header>				
				<div class="nav_container sixteen columns">
					<a href="<?php echo get_option ('home');?>">
						<img id="img_logo" src="<?php bloginfo('template_url'); ?>/images/logo.png" title="<?php bloginfo('title'); ?>">						
						<img id="img_logo_mobile" src="<?php bloginfo('template_url'); ?>/images/mobile-logo.png" title="<?php bloginfo('title'); ?>">						
					</a>			
					<?php wp_nav_menu(array('theme_location' => 'primary', 'container_class' => 'main-nav' , 'menu_class'=>'sf-menu sf-vertical', 'container' => 'nav')); ?>
				</div>			
			</header>				
			<div class="content sixteen columns">
				<?php if (!is_front_page()){ ?>
				<div class="header_container"></div>
				
				<div class="content_wrapper">			
				<?php } ?>
		
