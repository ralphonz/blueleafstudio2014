<?php get_header(); ?>

	<div id="content">

		<div id="inner-content" class="wrap clearfix">

			<div id="main" class="first clearfix" role="main">
			
				<div id="slider-page">
				<header class="archive-header">
				
					<i class="fa fa-folder page-icon"></i>
					<h1 class="archive-title h2"><?php post_type_archive_title(); ?></h1>
					
						<nav class="page-nav">
							<div class="prev-project fa fa-chevron-left"><?php previous_posts_link( __( '&laquo; Newer Projects', 'bonestheme' )); ?></div>
							<div class="next-project fa fa-chevron-right"><?php next_posts_link( __( 'Older Projects &raquo;', 'bonestheme' )); ?></div>
						</nav>
					
				</header>
				<?php $i = 0; ?>
				
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article">
	
						<header class="article-header blue<?php echo $i+1; ?>">
	
							<h3><?php the_title(); ?></h3>
							<time class="updated text-center" datetime="<?php the_field( 'project_date' ); ?>" pubdate ><?php the_field( 'project_date' ); ?></time>
	
						</header>
	
						<section class="entry-content clearfix">
							
							<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'large'); ?></a>
							
							<?php the_excerpt(); ?>
							
							<a class="readmore button" href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php _e('Read More...', 'blueleaf') ?></a>
	
						</section>
	
					</article>
					<?php 
					
					$i++;
					
					if ($i == 5) {
						$i = 0;
					}
					
				endwhile; ?>

				<?php else : ?>

					<article id="post-not-found" class="hentry clearfix">
						<header class="article-header">
							<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
						</header>
						<section class="entry-content">
							<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
						</section>
						<footer class="article-footer">
								<p><?php _e( 'This is the error message in the custom posty type archive template.', 'bonestheme' ); ?></p>
						</footer>
					</article>

				<?php endif; ?>
				
				</div>
				
			</div>

			<?php get_sidebar(); ?>

		</div>

	</div>

<?php get_footer(); ?>
