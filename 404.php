<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

					<div id="main" class="first clearfix" role="main">

						<article id="post-not-found" class="hentry clearfix">

							<header class="article-header">

								<h1><?php _e( 'Epic 404 - An Elephant Ate This Page!', 'bonestheme' ); ?></h1>

							</header>

							<section class="entry-content">
								<img src="<?php echo get_template_directory_uri(); ?>/library/images/404.jpg" alt="" class="aligncenter">
								<p><?php _e( 'The article you were looking for was not found, maybe try searching for it!', 'bonestheme' ); ?></p>

							</section>

							<section class="search">

									<p><?php get_search_form(); ?></p>

							</section>

						</article>

					</div>

				</div>

			</div>

<?php get_footer(); ?>
