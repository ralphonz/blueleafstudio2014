<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

					<div id="main" class="first clearfix" role="main">
						
						<header class="article-header">
						
							<?php get_search_form(); ?>
						
							<i class="fa fa-search page-icon"></i>
							<h1 class="archive-title"><span><?php _e( 'Search Results', 'bonestheme' ); ?></span></h1>
								
								<nav class="page-nav">
									<div class="prev-project fa fa-chevron-left"><?php previous_posts_link( __( '&laquo; Newer Posts', 'bonestheme' )); ?></div>
									<div class="next-project fa fa-chevron-right"><?php next_posts_link( __( 'Older Posts &raquo;', 'bonestheme' )); ?></div>
								</nav>
							
						</header>

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

								<header class="article-header">
								
									<i class="fa fa-<?php $values = get_field('icon');
									  if($values) {
									    echo $values;
									  } else {
									    echo 'leaf';
									  } ?> page-icon"></i>
									<h1 class="h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
									<p class="byline vcard"><?php
										printf( __( 'Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span> <span class="amp">&</span> filed under %4$s.', 'bonestheme' ), get_the_time( 'Y-m-j' ), get_the_time(get_option('date_format')), bones_get_the_author_posts_link(), get_the_category_list(', ') );
									?></p>

								</header>

								<section class="entry-content clearfix">
									<div class="alignleft rightmargin mobile-center"><?php the_post_thumbnail(); ?></div>
									<?php echo get_the_excerpt(); ?>
								</section>

								<footer class="article-footer">
									<p class="tags"><?php the_tags( '<i class="fa fa-tags"></i> <span class="tags-title">' . __( 'Tags:', 'bonestheme' ) . '</span> ', ', ', '' ); ?></p>
								</footer>

							</article>

						<?php endwhile; ?>

								<?php if (function_exists('bones_page_navi')) { ?>
										<?php bones_page_navi(); ?>
								<?php } else { ?>
										<nav class="wp-prev-next">
												<ul class="clearfix">
													<li class="prev-link"><?php next_posts_link( __( '&laquo; Older Entries', 'bonestheme' )) ?></li>
													<li class="next-link"><?php previous_posts_link( __( 'Newer Entries &raquo;', 'bonestheme' )) ?></li>
												</ul>
										</nav>
								<?php } ?>

							<?php else : ?>

									<article id="post-not-found" class="hentry clearfix">
										<header class="article-header">
											<h1><?php _e( 'Sorry, No Results.', 'bonestheme' ); ?></h1>
										</header>
										<section class="entry-content">
											<p><?php _e( 'Try your search again.', 'bonestheme' ); ?></p>
										</section>
										<footer class="article-footer">
												<p><?php get_search_form(); ?></p>
										</footer>
									</article>

							<?php endif; ?>

						</div>

							<?php get_sidebar(); ?>

					</div>

			</div>

<?php get_footer(); ?>