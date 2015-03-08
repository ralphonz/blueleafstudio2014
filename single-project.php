<?php
/*
This is the custom post type post template.
If you edit the post type name, you've got
to change the name of this template to
reflect that name change.

i.e. if your custom post type is called
register_post_type( 'bookmarks',
then your single template should be
single-bookmarks.php

*/
?>

<?php get_header(); ?>

<div id="content">

	<div id="inner-content" class="wrap clearfix">

		<div id="main" class="first clearfix" role="main">
			
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/Product" content="Freelance Web Development">

				<header class="article-header clearfix">
					
					<i class="fa fa-folder-open page-icon"></i>
					<h1 itemprop="name" class="single-title custom-post-type-title"><?php the_title(); ?></h1>
					<nav class="page-nav">
						<div class="prev-project fa fa-chevron-left"><?php previous_post_link(); ?></div>
						<div class="next-project fa fa-chevron-right"><?php next_post_link();  ?></div>
					</nav>
					<time itemscope itemprop="date" itemtype="http://schema.org/Date" class="project-date" datetime="<?php the_field( 'project_date' ); ?>"><?php the_field( 'project_date' ); ?></time>

				</header>
				
				<section class="entry-gallery clearfix">
					<?php echo do_shortcode('[gallery link="file" type="rectangular"]'); ?>
				</section>
				
				<section class="entry-content clearfix">
					
					<?php $testimonial = get_field('testimonial');
					if ($testimonial) { ?>
						<blockquote class="testimonial" itemprop="review" itemscope itemtype="http://schema.org/Review"><span class="bighuge">&ldquo;</span>&nbsp;<?php echo $testimonial; ?> <span class="bighuge">&rdquo;</span> <cite class="testimonial-author" itemprop="author">- <?php the_field( 'testimonial_author' ); ?></cite></blockquote>
					<?php } ?>
					<?php remove_filter( 'the_content', 'sharing_display', 19 ); ?>
					<?php remove_filter( 'the_excerpt', 'sharing_display', 19 ); ?>
					<?php the_content(); ?>
					<div class="entry-links">
						<a class="button" href="<?php echo esc_url(home_url()); ?>/portfolio" title="<?php _e('Go back to the portfolio page.', 'blueleaf'); ?>"><i class="fa fa-arrow-left"></i><?php _e('Back to Portfolio', 'blueleaf'); ?></a>
					
						<?php if (get_field( 'website_url' )) : ?>
							<a class="button" itemscope itemprop="website" itemtype="http://schema.org/URL" href="http://<?php the_field( 'website_url' ); ?>" title="<?php the_field( 'website_url'); ?>" target="_blank"><i class="fa fa-external-link"></i><?php _e('Visit Website', 'blueleaf') ?></a>
						<?php endif; ?>
						
						<a class="button" itemscope itemtype="http://schema.org/QuoteAction" href="<?php echo esc_url(home_url()); ?>/services/submitticket/?step=2&deptid=4" title="<?php _e('Contact us to get a quote for a site like this one.', 'blueleaf'); ?>"><i class="fa fa-comment "></i><?php _e('Get A Quote', 'blueleaf'); ?></a>
						
						<div itemscope itemtype="http://schema.org/InteractAction" class="button"><i class="fa fa-share"></i><?php echo sharing_display(); ?> </div>
						
						
					</div>
				</section>

				<footer class="article-footer">
				
					<p class="tags"><?php echo get_the_term_list( get_the_ID(), 'post_tag', '<span class="tags-title">' . __( 'Tags:', 'bonestheme' ) . '</span> ', ', ' ) ?></p>

				</footer>

			</article>

			<?php endwhile; ?>

			<?php else : ?>

					<article id="post-not-found" class="hentry clearfix">
						<header class="article-header">
							<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
						</header>
						<section class="entry-content">
							<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
						</section>
						<footer class="article-footer">
								<p></p>
						</footer>
					</article>

			<?php endif; ?>

		</div><!--#main-->

		<?php get_sidebar(); ?>

	</div><!--#inner-content-->

</div><!--#content-->

<?php get_footer(); ?>
