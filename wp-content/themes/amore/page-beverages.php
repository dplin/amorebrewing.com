<?php
	/*Template Name: Page-Beverages*/
?>
<?php get_header(); ?>	
<div class="header_container">		
	<img src="<?php bloginfo('template_url'); ?>/images/header-beverages.png" />	
</div>		
<div class="content_wrapper">		
	<div>				
		<?php if(get_field('content_dialogs')): ?>						
			<?php while(has_sub_field('content_dialogs')): ?>					
				<h2><?php the_sub_field('subject');?></h2>										
				<?php the_sub_field('content'); break; ?>				
			<?php endwhile; ?>									
		<?php endif; ?>				
	</div>		
	<hr>		
	<div class="list_of_beverages">				
		<?php if(get_field('content_dialogs')): ?>						
			<?php while(has_sub_field('content_dialogs')):?>					
				<h2><?php the_sub_field('subject');?></h2>										
				<?php the_sub_field('content');?>				
			<?php endwhile; ?>								
		<?php endif; ?>				
	</div>			
	<div class="image_holder">				
		<?php if(get_field('image_holder')): ?>						
			<?php while(has_sub_field('image_holder')):?>					
				<img src="<?php the_sub_field('image');?>">										
			<?php endwhile; ?>									
		<?php endif; ?>					
	</div>	
</div>
<?php get_footer(); ?>