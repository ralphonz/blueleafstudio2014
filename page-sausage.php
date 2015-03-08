<?php
/*
Template Name: Home Page
*/
?>
<?php get_header(); ?>

<div class="wide-container" role="main">

	<?php

	$slide1 = array(
					'image' => 'our-house.jpg',
					'content' => 'My place of design, development &amp; creativity for the web.  I provide inspiring and creative web design,web development and eco-friendly hosting <div class="text-center" ><a href="/#Slide2" class="large"><i class="fa fa-arrow-down"></i></a></div>',
					'title' => 'Welcome to Blueleaf Studio',
					'positionX' => 'center',
					'positionY' => 'center',
					'icon' => 'blueleaf'
					
			);
	$slide2 = array(
					'image' => 'hampi.jpg',
					'content' => 'I create inspiring designs and develop smooth, functional, web applications.<br><br><a class="button" href="/portfolio/"><i class="fa fa-folder"></i>See my full portfolio...</a>',
					'title' => 'Web Design &amp; Development',
					'positionX' => 'left',
					'positionY' => 'top',
					'icon' => 'laptop'
								 
			);
	$slide3 = array(
					'image' => 'green-leaf.jpg',
					'content' => 'I care about the world and try to have a minimal impact on the environment.  I supply environmentally friendly web hosting and domain name services.<br><br>
					<a class="button" href="/environmentally-friendly-web-hosting/"><i class="fa fa-cloud"></i>More about Eco Hosting...</a> <a class="order-link button" href="/services/cart/" title="Shopping Cart"><i class="fa fa-shopping-cart"></i> Order Green Web Hosting...</a>',
					'title' => 'Green Web Hosting',
					'positionX' => 'right',
					'positionY' => 'bottom',
					'icon' => 'cloud'
			);
	$slide4 = array(
					'image' => 'yellow-flower.jpg',
					'content' => 'Good design doesn\'t have to cost the earth. I try to make sure that my business has a minimal impact on the environment.  I hope that it will inspire others to do the same.<br><br>
					<a class="button" href="/eco-friendly-green-web-design/"><i class="fa fa-leaf"></i>Read about our green ethics...</a>',
					'title' => 'Eco Friendly',
					'positionX' => 'right',
					'positionY' => 'top',
					'icon' => 'leaf'
			);
	$slide5 = array(
					'image' => 'leaves.jpg',
					'content' => 'Whether you want to hire me for your next web project or simply have a question, select the right option and ask away!  I aim to get back to all queries within 24 hours.<br><br>
					<a class="button" href="/services/submitticket/?step=2&amp;deptid=4"><i class="fa fa-money"></i>I need a quote...</a> <a class="button" href="/services/submitticket/?step=2&amp;deptid=1"><i class="fa fa-question-circle"></i>I have a question...</a>',
					'title' => 'Contact',
					'positionX' => 'center',
					'positionY' => 'bottom',
					'icon' => 'comment'
			);
			
	$slides = array($slide1, $slide2, $slide3, $slide4, $slide5);?>
	
	<nav id="fullPage-menu">
		<ul>
		<?php foreach ($slides as $key => $slide) { ?>
			<li data-menuanchor="Slide<?php echo $key+1; ?>" class="<?php if ($key == 0) { echo 'active'; } ?>"  ><a href="/#Slide<?php echo $key+1; ?>" title="<?php echo $slide['title']; ?>" class="show-tooltip"><?php if ($slide['icon'] == 'blueleaf') : ?><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 28.761 29.243" enable-background="new 0 0 28.761 29.243" xml:space="preserve" class="fa blueleaf-fa">
			<g>
				<path fill="#FFFFFF" d="M5.567,4.425C5.567-0.085,0,0,0,0s0,0.807,0,4.116c0,3.306,5.567,4.101,5.567,4.101
					C5.567,7.72,5.567,5.93,5.567,4.425z"/>
			</g>
			<g>
				<path fill="#FFFFFF" d="M17.897,8.476H5.59L0.023,8.466v14.059c0,2.3,1.362,4.068,4.088,5.3c2.109,0.945,4.485,1.417,7.129,1.417
					h6.656c7.243,0,10.864-2.272,10.864-6.819v-7.23C28.761,10.714,25.139,8.476,17.897,8.476z M23.195,21.87
					c0,1.669-1.759,2.505-5.274,2.505h-6.173c-1.343,0-2.567-0.13-3.676-0.391c-1.654-0.396-2.481-1.026-2.481-1.891v-8.749h12.372
					c3.489,0,5.233,0.78,5.233,2.342V21.87z"/>
			</g>
			</svg>
			<?php else : ?><i class="fa fa-<?php echo $slide['icon']; ?>"></i><?php endif; ?></a></li>
		<?php } ?>
		</ul>
	</nav>
	
	<?php if ( !is_user_logged_in() ) { ?> 
		<a href="#" title="Log in" class="login_button" id="login-button"><i class="fa fa-sign-in"></i> <?php _e('Login', 'blueleaf') ?></a>
	<?php } else { ?>
		<a href="/services/clientarea" title="Go To Your Account" id="login-button"><i class="fa fa-dashboard"></i> <?php _e('Your Account', 'blueleaf') ?></a>	
	<?php } ?>
	
	<?php foreach ($slides as $key => $slide) : ?>
		<article class="section <?php echo $slide['icon'].$key ?>">
			<?php 
			
			$img480 = str_replace('.', '.480.', $slide['image']);
			$img768 = str_replace('.', '.768.', $slide['image']); 
			$img1024 = str_replace('.', '.1024.', $slide['image']); 
			$img1264 = str_replace('.', '.1264.', $slide['image']); 
			$img1920 = str_replace('.', '.1920.', $slide['image']);
			
			?>
			<style type="text/css">
				.<?php echo $slide['icon'].$key; ?> {
					background-image: url('<?php echo get_template_directory_uri(); ?>/library/images/front-page/<?php echo $img480; ?>');
				}
			    @media only screen and (min-width: 481px) { /* Change to whatever media query you require */
			        .<?php echo $slide['icon'].$key ?> {
			        	background-image: url('<?php echo get_template_directory_uri(); ?>/library/images/front-page/<?php echo $img768; ?>');
			        }
			    }
			    @media only screen and (min-width: 768px) { /* Change to whatever media query you require */
			        .<?php echo $slide['icon'].$key ?> {
			        	background-image: url('<?php echo get_template_directory_uri(); ?>/library/images/front-page/<?php echo $img1024; ?>');
			        }
			    }
			    @media only screen and (min-width: 1024px) { /* Change to whatever media query you require */
			        .<?php echo $slide['icon'].$key ?> {
			        	background-image: url('<?php echo get_template_directory_uri(); ?>/library/images/front-page/<?php echo $img1264; ?>');
			        }
			    }
			    @media only screen and (min-width: 1264px) { /* Change to whatever media query you require */
			        .<?php echo $slide['icon'].$key ?> {
			        	background-image: url('<?php echo get_template_directory_uri(); ?>/library/images/front-page/<?php echo $img1920; ?>');
			        }
			    }
			    @media only screen and (min-width: 1920px) { /* Change to whatever media query you require */
			        .<?php echo $slide['icon'].$key ?> {
			        	background-image: url('<?php echo get_template_directory_uri(); ?>/library/images/front-page/<?php echo $slide['image']; ?>');
			        }
			    }
			
			</style>
			<div class="wrap">
				<div class="fullPage-content <?php echo $slide['positionX'].'X '.$slide['positionY'].'Y'; ?>">
					<div class="fullPage-content-wrap">
						<h1 class="article-header"><i class="fa fa-<?php echo $slide['icon'] ?>"></i> <?php echo $slide['title']; ?></h1>
						<section>
							<?php echo $slide['content']; ?>
						</section>
						
					</div>
				</div>
			</div>
		</article>
	<?php endforeach;?>

</div><!--#main-->
<div id="loading-overlay">
	<div id="overlay-logo">
		<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 28.761 29.243" enable-background="new 0 0 28.761 29.243" xml:space="preserve">
			<g>
				<path fill="#FFFFFF" d="M5.567,4.425C5.567-0.085,0,0,0,0s0,0.807,0,4.116c0,3.306,5.567,4.101,5.567,4.101
					C5.567,7.72,5.567,5.93,5.567,4.425z"/>
			</g>
			<g>
				<path fill="#FFFFFF" d="M17.897,8.476H5.59L0.023,8.466v14.059c0,2.3,1.362,4.068,4.088,5.3c2.109,0.945,4.485,1.417,7.129,1.417
					h6.656c7.243,0,10.864-2.272,10.864-6.819v-7.23C28.761,10.714,25.139,8.476,17.897,8.476z M23.195,21.87
					c0,1.669-1.759,2.505-5.274,2.505h-6.173c-1.343,0-2.567-0.13-3.676-0.391c-1.654-0.396-2.481-1.026-2.481-1.891v-8.749h12.372
					c3.489,0,5.233,0.78,5.233,2.342V21.87z"/>
			</g>
		</svg>
		<i class="fa fa-spinner fa-spin"></i>
		<span><?php _e('Loading', 'blueleaf') ?>...</span>
	</div>
</div>

<?php get_footer(); ?>
