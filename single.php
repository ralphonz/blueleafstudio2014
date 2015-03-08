<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

					<div id="main" class="first clearfix" role="main">

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

								<header class="article-header">
									
									<i class="fa fa-<?php $values = get_field('icon');
									  if($values) {
									    echo $values;
									  } else {
									    echo 'leaf';
									  } ?> page-icon"></i>
									<h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
									<nav class="page-nav">
										<div class="prev-project fa fa-chevron-left"><?php previous_post_link(); ?></div>
										<div class="next-project fa fa-chevron-right"><?php next_post_link();  ?></div>
									</nav>
									<p class="byline vcard mobile-center"><?php
										printf( __( 'Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author fn">%3$s</span> <span class="amp">&amp;</span> filed under %4$s.', 'bonestheme' ), get_the_time( 'Y-m-j' ), get_the_time( get_option('date_format')), bones_get_the_author_posts_link(), get_the_category_list(', ') );
									?></p>

								</header>

								<section class="entry-content clearfix" itemprop="articleBody">
									<?php remove_filter( 'the_content', 'sharing_display', 19 ); ?>
									<?php remove_filter( 'the_excerpt', 'sharing_display', 19 ); ?>
									<?php the_content(); ?>
								</section>

								<footer class="article-footer">
									<div itemscope itemtype="http://schema.org/InteractAction" class="button alignright"><i class="fa fa-share"></i><?php echo sharing_display(); ?> </div>
									<?php the_tags( '<p class="tags"><i class="fa fa-tags"></i><span class="tags-title">' . __( 'Tags:', 'bonestheme' ) . '</span> ', ', ', '</p>' ); ?>
								</footer>

								<?php comments_template(); ?>

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
											<p><?php _e( 'This is the error message in the single.php template.', 'bonestheme' ); ?></p>
									</footer>
							</article>

						<?php endif; ?>

					</div>

					<?php get_sidebar(); ?>

				</div>

			</div>

<?php get_footer(); ?>
