<?php
	/*Template Name: Page-Home*/
?>
<?php get_header(); ?>	
<div class="home_container">
	<div class="short_description">						
		<p><?php the_field('motto'); ?></p>			
		<a href="<?php echo get_option ('home');?>/systems"><img style="float:left;width:47%;" src="<?php bloginfo('template_url'); ?>/images/promo1.png" title="Systems"></a>
		<a href="<?php echo get_option ('home');?>/beverages"><img style="float:left;width:47%;margin-left:15px;" src="<?php bloginfo('template_url'); ?>/images/promo2.png" title="Beverages"></a>
	</div>
</div>
<?php get_footer(); ?>