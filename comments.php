<?php
/*
The comments page for Bones
*/

// Do not delete these lines
	if ( ! empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) )
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<div class="alert alert-help">
			<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'blueleaf' ); ?></p>
		</div>
	<?php
		return;
	}
?>

<?php // You can start editing here. ?>

<?php if ( have_comments() ) : ?>

<section class="entry-comments">

	<i class="fa fa-comments page-icon"></i><h3 id="comments" class="h2 single-title"> <?php comments_number( __( '<span>No</span> Responses', 'blueleaf' ), __( '<span>One</span> Response', 'blueleaf' ), _n( '<span>%</span> Response', '<span>%</span> Responses', get_comments_number(), 'blueleaf' ) );?> to &#8220;<?php the_title(); ?>&#8221;</h3>

	<nav id="comment-nav">
		<ul class="clearfix">
				<li><?php previous_comments_link() ?></li>
				<li><?php next_comments_link() ?></li>
		</ul>
	</nav>

	<ol class="commentlist">
		<?php wp_list_comments( 'type=comment&callback=bones_comments' ); ?>
	</ol>

	<nav id="comment-nav">
		<ul class="clearfix">
				<li><?php previous_comments_link() ?></li>
				<li><?php next_comments_link() ?></li>
		</ul>
	</nav>

	<?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
			<?php // If comments are open, but there are no comments. ?>

	<?php else : // comments are closed ?>

	<?php // If comments are closed. ?>
	<!--p class="nocomments"><?php _e( 'Comments are closed.', 'blueleaf' ); ?></p-->

	<?php endif; ?>

</section>

<?php endif; ?>


<?php if ( comments_open() ) : ?>

<section id="respond" class="respond-form">

	<h3 id="comment-form-title" class="h2"><?php comment_form_title( __( 'Leave a Comment', 'blueleaf' ), __( 'Leave a Reply to %s', 'blueleaf' )); ?></h3>

	<div id="cancel-comment-reply">
		<p class="small"><?php cancel_comment_reply_link(); ?></p>
	</div>

	<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
		<div class="alert alert-help">
			<p><?php printf( __( 'You must be %1$slogged in%2$s to post a comment.', 'blueleaf' ), '<a href="<?php echo wp_login_url( get_permalink() ); ?>">', '</a>' ); ?></p>
		</div>
	<?php else : ?>

	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

	<?php if ( is_user_logged_in() ) : ?>

	<p class="comments-logged-in-as"><?php _e( 'Logged in as', 'blueleaf' ); ?> <a href="<?php echo get_option( 'siteurl' ); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url( get_permalink() ); ?>" title="<?php _e( 'Log out of this account', 'blueleaf' ); ?>"><?php _e( 'Log out', 'blueleaf' ); ?> <?php _e( '&raquo;', 'blueleaf' ); ?></a></p>

	<?php else : ?>

	<ul id="comment-form-elements" class="clearfix">

		<li>
			<label for="author"><?php _e( 'Name', 'blueleaf' ); ?> <?php if ($req) _e( '(required)', 'blueleaf'); ?></label>
			<input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" placeholder="<?php _e( 'Your Name*', 'blueleaf' ); ?>" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
		</li>

		<li>
			<label for="email"><?php _e( 'Mail', 'blueleaf' ); ?> <?php if ($req) _e( '(required)', 'blueleaf'); ?></label>
			<input type="email" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" placeholder="<?php _e( 'Your E-Mail*', 'blueleaf' ); ?>" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
			<small><?php _e("(will not be published)", 'blueleaf' ); ?></small>
		</li>

		<li>
			<label for="url"><?php _e( 'Website', 'blueleaf' ); ?></label>
			<input type="url" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" placeholder="<?php _e( 'Got a website?', 'blueleaf' ); ?>" tabindex="3" />
		</li>

	</ul>

	<?php endif; ?>

	<p><textarea name="comment" id="comment" placeholder="<?php _e( 'Your Comment here...', 'blueleaf' ); ?>" tabindex="4"></textarea></p>

	<p>
		<button name="submit" type="submit" id="submit" class="button" tabindex="5" ><i class="fa fa-comment"></i><?php _e( 'Submit', 'blueleaf' ); ?></button>
		<?php comment_id_fields(); ?>
	</p>

	<div class="alert alert-info">
		<p id="allowed_tags" class="small"><strong>Markup:</strong> <?php _e( 'You can use these XHTML tags in your comment', 'blueleaf' ); ?>: <code><?php echo allowed_tags(); ?></code></p>
	</div>

	<?php do_action( 'comment_form', $post->ID ); ?>

	</form>

	<?php endif; // If registration required and not logged in ?>
</section>

<?php endif; // if you delete this the sky will fall on your head ?>
