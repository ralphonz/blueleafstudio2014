<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">
		
		<?php if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)) : // Google Chrome Frame for IE ?>	
			<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<?php endif; ?>
		
		<title><?php wp_title(''); ?></title>

		<?php // mobile meta (hooray!) ?>
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">

		<?php // icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/) ?>
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-touch.png">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<![endif]-->
		<?php // or, set /favicon.ico for IE10 win ?>
		<meta name="msapplication-TileColor" content="#f01d4f">
		<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
		
		<!-- Adaptive Images -->
		<script>document.cookie='resolution='+Math.max(screen.width,screen.height)+'; path=/';</script>
		
		
		<?php 
		// wordpress head functions 
		wp_head(); 
		// end of wordpress head 
		?>

	</head>

	<body <?php body_class(); ?>>

		<header class="header" role="banner">
			
			<div id="inner-header" class="wrap clearfix">

				<a href="<?php echo home_url(); ?>" rel="nofollow" id="logo" title="Home"><span class="blog-name"><?php bloginfo('name'); ?></span><svg version="1.1" id="vector-logo" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 28.761 29.243" enable-background="new 0 0 28.761 29.243" xml:space="preserve">
				<g>
					<path fill="#FFFFFF" d="M5.567,4.425C5.567-0.085,0,0,0,0s0,0.807,0,4.116c0,3.306,5.567,4.101,5.567,4.101
						C5.567,7.72,5.567,5.93,5.567,4.425z"></path>
				</g>
				<g>
					<path fill="#FFFFFF" d="M17.897,8.476H5.59L0.023,8.466v14.059c0,2.3,1.362,4.068,4.088,5.3c2.109,0.945,4.485,1.417,7.129,1.417
						h6.656c7.243,0,10.864-2.272,10.864-6.819v-7.23C28.761,10.714,25.139,8.476,17.897,8.476z M23.195,21.87
						c0,1.669-1.759,2.505-5.274,2.505h-6.173c-1.343,0-2.567-0.13-3.676-0.391c-1.654-0.396-2.481-1.026-2.481-1.891v-8.749h12.372
						c3.489,0,5.233,0.78,5.233,2.342V21.87z"></path>
				</g>
				</svg></a>

				<span class="blog-description"><?php bloginfo('description'); ?></span>
				<?php if ( is_active_sidebar('sidebar1') ) : ?>				
					<i id="sidebar-show" class="fa fa-bars fa-rotate-90 show-tooltip-e" title="Show/Hide the sidebar"></i>
				<?php endif; ?>
				
				<i id="nav-show" class="fa fa-bars hide-on-desktop hide-on-tablet"></i>

				<nav role="navigation">
					<div id="nav-hide" class="hide-on-desktop hide-on-tablet" ><i class="fa fa-arrow-down" ></i>&nbsp;<?php _e('Hide', 'blueleaf'); ?></div>
					<?php 
					if ( is_user_logged_in() ) { 
						bones_main_nav('header');
					} else {
						bones_main_nav_login('header');
					} ?>
				</nav>

			</div>

		</header>