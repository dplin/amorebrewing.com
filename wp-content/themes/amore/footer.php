				<?php if (!is_front_page()){ ?>
					</div>	
				<?php } ?>
			</div>
					
		</div>
			<div class="mobile_nav_container">
				<?php wp_nav_menu(array('theme_location' => 'secondary', 'container_class' => 'mobile-nav' , 'menu_class'=>'', 'container' => 'nav')); ?>								
			</div>			
		<footer>					

		</footer>				
		<?php wp_footer(); ?>
	</body>
</html>