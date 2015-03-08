		<?php if (!is_front_page()) : ?>
			<footer class="footer wrap" role="contentinfo">
				
				<a class="page-top-link show-tooltip-w" href="<?php echo wp_get_referer(); ?>" title="<?php _e('Go back to the previous page', 'blueleaf'); ?>"><i class="fa fa-arrow-left"></i></a>
				
				<a class="page-top-link show-tooltip-w" href="#top" title="<?php _e('Go to the top of this page', 'blueleaf'); ?>"><i class="fa fa-arrow-up"></i></a>
				
				<nav role="navigation">
						<?php bones_footer_links(); ?>
				</nav>
				
				<!--social networks and buttons -->
				<div class="social-networks hide-on-mobile">
					<?php $options = get_option('company_details'); ?>
					
					<?php if($options['company_google']) { ?>
						<a href="<?php echo $options['company_google']; ?>" title="<?php echo $options['company_name'];?> Google Page" class="social-icon googleplus-icon show-tooltip-s" target="_blank"><i class="fa fa-google-plus"></i></a>
					<?php } ?>
				
					<?php if($options['company_twitter']) { ?>
						<a href="<?php echo $options['company_twitter']; ?>" title="<?php echo $options['company_name'];?> Twitter Profile" class="social-icon twitter-icon  show-tooltip-s" target="_blank"><i class="fa fa-twitter"></i></a>
					<?php } ?>
				
					<?php if($options['company_facebook']) { ?>
						<a href="<?php echo $options['company_facebook']; ?>" title="<?php echo $options['company_name'];?> Facebook Page" class="social-icon facebook-icon  show-tooltip-s" target="_blank"><i class="fa fa-facebook"></i></a>
					<?php } ?>
	
				</div>
				<!-- /networks-->
		
				<p class="source-org copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>.</p>
	
			</footer>
		<?php endif; ?>
		
		<form id="login" action="login" method="post">
		
			<div id="login-inner">
		
			    <h3 class="h1"><?php _e('Login To', 'blueleaf') ?> <?php bloginfo('name'); ?></h3>
			    
			    <p class="status"></p>
			    
			    <label for="username"><?php _e('Email', 'blueleaf'); ?></label>
			    <input id="username" type="text" name="username">
			    
			    <label for="password"><?php _e('Password', 'blueleaf'); ?></label>
			    <input id="password" type="password" name="password">
			    
			    <div class="text-center">
			    
				    <button type="submit" value="<?php _e('Login', 'blueleaf') ?>" name="submit"><i class="fa fa-sign-in"></i><?php _e('Login', 'blueleaf'); ?></button> 
				    <a class="register button" href="<?php echo esc_url(home_url()); ?>/services/register/"><i class="fa fa-pencil"></i><?php _e('Register...', 'blueleaf'); ?></a><br>
				    
				    <a class="lost small" href="<?php echo wp_lostpassword_url(); ?>"><?php _e('Lost your password?' , 'blueleaf'); ?></a>
				    
				</div>
			    
			    <a class="close show-tooltip" href="" title="close"><i class="fa fa-times-circle"></i></a>
			    
			    <?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
		    
		    </div>
		    
		</form>
		<?php if (!is_front_page()) : ?>
			<span id="floral-left"></span>
			<span id="floral-right"></span>
		<?php endif; ?>
		
		<?php // all js scripts are loaded in library/bones.php ?>
		<?php wp_footer(); ?>
		
	</body>

</html>
