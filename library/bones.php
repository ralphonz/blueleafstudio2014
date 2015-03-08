<?php
/* Welcome to Bones :)
This is the core Bones file where most of the
main functions & features reside. If you have
any custom functions, it's best to put them
in the functions.php file.

Developed by: Eddie Machado
URL: http://themble.com/bones/
*/

/*********************
LAUNCH BONES
Let's fire off all the functions
and tools. I put it up here so it's
right up top and clean.
*********************/

// we're firing all out initial functions at the start
add_action( 'after_setup_theme', 'bones_ahoy', 16 );

function bones_ahoy() {

	// launching operation cleanup
	add_action( 'init', 'bones_head_cleanup' );
	// remove WP version from RSS
	add_filter( 'the_generator', 'bones_rss_version' );
	// remove pesky injected css for recent comments widget
	add_filter( 'wp_head', 'bones_remove_wp_widget_recent_comments_style', 1 );
	// clean up comment styles in the head
	add_action( 'wp_head', 'bones_remove_recent_comments_style', 1 );
	// clean up gallery output in wp
	//add_filter( 'gallery_style', 'bones_gallery_style' );

	// enqueue base scripts and styles
	add_action( 'wp_enqueue_scripts', 'bones_scripts_and_styles', 999 );
	// ie conditional wrapper

	// launching this stuff after theme setup
	bones_theme_support();

	// adding sidebars to Wordpress (these are created in functions.php)
	add_action( 'widgets_init', 'bones_register_sidebars' );
	// adding the bones search form (created in functions.php)
	add_filter( 'get_search_form', 'bones_wpsearch' );

	// cleaning up random code around images
	add_filter( 'the_content', 'bones_filter_ptags_on_images' );
	// cleaning up excerpt
	add_filter( 'excerpt_more', 'bones_excerpt_more' );

} /* end bones ahoy */

/*********************
WP_HEAD GOODNESS
The default wordpress head is
a mess. Let's clean it up by
removing all the junk we don't
need.
*********************/

function bones_head_cleanup() {
	// category feeds
	// remove_action( 'wp_head', 'feed_links_extra', 3 );
	// post and comment feeds
	// remove_action( 'wp_head', 'feed_links', 2 );
	// EditURI link
	remove_action( 'wp_head', 'rsd_link' );
	// windows live writer
	remove_action( 'wp_head', 'wlwmanifest_link' );
	// index link
	remove_action( 'wp_head', 'index_rel_link' );
	// previous link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	// start link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	// links for adjacent posts
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	// WP version
	remove_action( 'wp_head', 'wp_generator' );
	// remove WP version from css
	add_filter( 'style_loader_src', 'bones_remove_wp_ver_css_js', 9999 );
	// remove Wp version from scripts
	add_filter( 'script_loader_src', 'bones_remove_wp_ver_css_js', 9999 );

} /* end bones head cleanup */

// remove WP version from RSS
function bones_rss_version() { return ''; }

// remove WP version from scripts
function bones_remove_wp_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}

// remove injected CSS for recent comments widget
function bones_remove_wp_widget_recent_comments_style() {
	if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
		remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
	}
}

// remove injected CSS from recent comments widget
function bones_remove_recent_comments_style() {
	global $wp_widget_factory;
	if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
		remove_action( 'wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style') );
	}
}

// remove injected CSS from gallery
function bones_gallery_style($css) {
	return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );
}

/*********************
SCRIPTS & ENQUEUEING
*********************/

// loading modernizr and jquery, and reply script
function bones_scripts_and_styles() {
	global $wp_styles; // call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way
	if (!is_admin()) {
		
		
		/*
		I recommend using a plugin to call jQuery
		using the google cdn. That way it stays cached
		and your site will load faster.
		*/
		
		//Making jQuery Google API
		if (!is_admin()) {
			// comment out the next two lines to load the local copy of jQuery
			wp_deregister_script('jquery');
			wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js', false, '1.11.0');
			
		}

		// modernizr (without media query polyfill)
		wp_register_script( 'bones-modernizr', get_stylesheet_directory_uri() . '/library/js/libs/modernizr.custom.min.js', array(), '2.5.3', false );

		// register main stylesheet
		wp_register_style( 'bones-stylesheet', get_stylesheet_directory_uri() . '/library/css/style.css', array(), '', 'all' );

		// ie-only style sheet
		wp_register_style( 'bones-ie-only', get_stylesheet_directory_uri() . '/library/css/ie.css', array(), '' );
		
		// fonts
		wp_register_style( 'roboto', 'http://fonts.googleapis.com/css?family=Roboto:300', array(), '' );		
		wp_register_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css', array(), '' );
		
		// comment reply script for threaded comments
		if ( is_single() AND comments_open() AND (get_option('thread_comments') == 1)) {
			wp_enqueue_script( 'comment-reply' );
		}

		//adding scripts file in the footer
		wp_register_script( 'jquery-animate-enhanced', get_stylesheet_directory_uri() . '/library/js/libs/jquery.animate-enhanced.min.js', array( 'jquery' ), '', true);
		//wp_register_script( 'tipsy', get_stylesheet_directory_uri() . '/library/js/libs/jquery.tipsy.js', array( 'jquery' ), '', true);
		wp_register_script( 'bones-js', get_stylesheet_directory_uri() . '/library/js/scripts.js', array( 'jquery', 'jquery-animate-enhanced' ), '', true );
		//wp_register_script( 'fullPage', get_stylesheet_directory_uri() . '/library/js/jquery.fullPage.min.js' , array( 'jquery' ), '', true);
		

		// enqueue styles and scripts
		wp_enqueue_script( 'bones-modernizr' );
		
		wp_enqueue_style( 'bones-stylesheet' );
		wp_enqueue_style( 'bones-ie-only' );
		wp_enqueue_style( 'roboto' );
		wp_enqueue_style( 'font-awesome' );

		$wp_styles->add_data( 'bones-ie-only', 'conditional', 'lt IE 9' ); // add conditional wrapper around ie stylesheet


		wp_enqueue_script( 'jquery' );
		//wp_enqueue_script( 'jquery-animate-enhanced' );  //required for horizontal slider pages
		//wp_enqueue_script( 'tipsy' ); //tooltip generator
		/*if( is_front_page() ){
			wp_enqueue_script( 'fullPage' );
		}*/
		wp_enqueue_script( 'bones-js' );
		
		//AJAX Login scripts
		wp_register_script('ajax-login-script', get_template_directory_uri() . '/library/js/ajax-login-script.js', array('jquery') ); 
		wp_enqueue_script('ajax-login-script');
		
	    // check if it's a blog page
	    global  $post;
	    $posttype = get_post_type($post);	
	    if ($posttype == 'post') {
	        $loginredirect = $_SERVER['REQUEST_URI'];
	    } else {
	        $loginredirect = '/services/clientarea';
	    }
	
	    wp_localize_script( 'ajax-login-script', 'bl_ajax_login_object', array( 
	        'ajaxurl' => admin_url( 'admin-ajax.php' ),
	        'redirecturl' => $loginredirect,
	        'loadingmessage' => __('<i class="fa fa-spinner fa-spin"></i> Signing in, please wait...')
	    ));
	
	}
}

add_filter( 'wp_default_scripts', 'dequeue_jquery_migrate' );

function dequeue_jquery_migrate( &$scripts){
	if(!is_admin()){
		$scripts->remove( 'jquery');
		$scripts->add( 'jquery', false, array( 'jquery-core' ), '1.10.2' );
	}
}

// defer scripts to increase load time
// Adapted from https://gist.github.com/toscho/1584783
//add_filter( 'clean_url', function( $url )
//{
//    if ( FALSE === strpos( $url, '.js' ) )
//    { // not our file
//        return $url;
//    }
//    // Must be a ', not "!
//    return "$url' defer='defer";
//}, 11, 1 );
/********************
AJAX LOGIN FORM
********************/

// it can be registered every time (it won't fire up unless there will be such AJAX request)
add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login' );

function ajax_login(){

    // First check the nonce, if it fails the function will break
    check_ajax_referer( 'ajax-login-nonce', 'security' );

    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = true;

    $user_signon = wp_signon( $info, false );
    if ( is_wp_error($user_signon) ){
        echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.')));
    } else {
        echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful, redirecting...')));
    }

    die();
}

/*********************
THEME SUPPORT
*********************/

// Adding WP 3+ Functions & Theme Support
function bones_theme_support() {

	// wp thumbnails (sizes handled in functions.php)
	add_theme_support( 'post-thumbnails' );

	// default thumb size
	set_post_thumbnail_size(125, 125, true);

	// wp custom background (thx to @bransonwerner for update)
	add_theme_support( 'custom-background',
		array(
		'default-image' => '',  // background image default
		'default-color' => '', // background color default (dont add the #)
		'wp-head-callback' => '_custom_background_cb',
		'admin-head-callback' => '',
		'admin-preview-callback' => ''
		)
	);

	// rss thingy
	add_theme_support('automatic-feed-links');

	// to add header image support go here: http://themble.com/support/adding-header-background-image-support/

	// adding post format support
//	add_theme_support( 'post-formats',
//		array(
//			'aside',             // title less blurb
//			'gallery',           // gallery of images
//			'link',              // quick link to other site
//			'image',             // an image
//			'quote',             // a quick quote
//			'status',            // a Facebook like status update
//			'video',             // video
//			'audio',             // audio
//			'chat'               // chat transcript
//		)
//	);

	// wp menus
	add_theme_support( 'menus' );

	// registering wp3+ menus
	register_nav_menus(
		array(
			'main-nav' => __( 'The Main Menu For Logged In Users', 'bonestheme' ),   // main nav in header for logged-in users
			'main-nav-login' => __( 'The Main Menu', 'blueleaf' ),
			'footer-links' => __( 'Footer Links', 'bonestheme' ) // secondary nav in footer
		)
	);
} /* end bones theme support */

/*********************
MENUS & NAVIGATION
*********************/
class Child_Wrap extends Walker_Nav_Menu
{
    function end_el(&$output, $item, $depth)
    {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</div></li>\n";
    }
}


// the main menu
function bones_main_nav() {
	// display the wp3 menu if available
	wp_nav_menu(array(
		'container' => false,                           // remove nav container
		'container_class' => 'menu clearfix',           // class of container (should you choose to use it)
		'menu' => __( 'The Main Menu', 'bonestheme' ),  // nav name
		'menu_class' => 'nav top-nav',         // adding custom nav class
		'theme_location' => 'main-nav',                 // where it's located in the theme
		'before' => '<div class="child-wrap">',                                 // before the menu
		'after' => '',                                  // after the menu
		'link_before' => '',                            // before each link
		'link_after' => '',                             // after each link
		'depth' => 0,                                   // limit the depth of the nav
		'fallback_cb' => 'bones_main_nav_fallback',      // fallback function
		'walker' => new Child_Wrap 
	));
} /* end bones main nav */

//the main menu with login button
function bones_main_nav_login() {
	// display the wp3 menu if available
	wp_nav_menu(array(
		'container' => false,                           // remove nav container
		'container_class' => 'menu clearfix',           // class of container (should you choose to use it)
		'menu' => __( 'The Main Menu', 'bonestheme' ),  // nav name
		'menu_class' => 'nav top-nav',         // adding custom nav class
		'theme_location' => 'main-nav-login',                 // where it's located in the theme
		'before' => '<div class="child-wrap">',                                 // before the menu
		'after' => '',                                  // after the menu
		'link_before' => '',                            // before each link
		'link_after' => '',                             // after each link
		'depth' => 0,                                   // limit the depth of the nav
		'fallback_cb' => 'bones_main_nav_fallback',		// fallback function
		'walker' => new Child_Wrap
	));
} /* end bones main nav */

function bones_main_nav_home() {
	// display the wp3 menu if available
	wp_nav_menu(array(
		'container' => false,                           // remove nav container
		'container_class' => 'menu clearfix',           // class of container (should you choose to use it)
		'menu' => __( 'The Home Page Scroll Menu', 'bonestheme' ),  // nav name
		'menu_class' => 'nav scroll-nav',         // adding custom nav class
		'theme_location' => 'scroll-nav-home',                 // where it's located in the theme
		'before' => '<div class="nav-wrap">',                                 // before the menu
		'after' => '</div>',                                  // after the menu
		'link_before' => '',                            // before each link
		'link_after' => '',                             // after each link
		'depth' => 0,                                   // limit the depth of the nav
		'fallback_cb' => 'bones_main_nav_fallback'      // fallback function
	));
} /* end bones main nav */

// the footer menu (should you choose to use one)
function bones_footer_links() {
	// display the wp3 menu if available
	wp_nav_menu(array(
		'container' => '',                              // remove nav container
		'container_class' => 'footer-links clearfix',   // class of container (should you choose to use it)
		'menu' => __( 'Footer Links', 'bonestheme' ),   // nav name
		'menu_class' => 'nav footer-nav clearfix',      // adding custom nav class
		'theme_location' => 'footer-links',             // where it's located in the theme
		'before' => '',                                 // before the menu
		'after' => '',                                  // after the menu
		'link_before' => '',                            // before each link
		'link_after' => '',                             // after each link
		'depth' => 0,                                   // limit the depth of the nav
		'fallback_cb' => 'bones_footer_links_fallback'  // fallback function
	));
} /* end bones footer link */

// this is the fallback for header menu
function bones_main_nav_fallback() {
	wp_page_menu( array(
		'show_home' => true,
		'menu_class' => 'nav top-nav clearfix',      // adding custom nav class
		'include'     => '',
		'exclude'     => '',
		'echo'        => true,
		'link_before' => '',                            // before each link
		'link_after' => ''                             // after each link
	) );
}

// this is the fallback for footer menu
function bones_footer_links_fallback() {
	/* you can put a default here if you like */
}

/*********************
POST NAVIGATION
*********************/
//Post navigation functions to add title attributes
add_filter('next_post_link','add_title_to_next_post_link');
function add_title_to_next_post_link($link) {
	
	$next_post = get_next_post();
	$title = $next_post->post_title;
	$link = str_replace("rel=", " title='".$title."' rel", $link);
	return $link;
}

add_filter('previous_post_link','add_title_to_previous_post_link');
function add_title_to_previous_post_link($link) {

	// Get the next/previous post object
	$post = get_adjacent_post();
	$title = get_the_title( $post->ID );
	$link = str_replace("rel=", " title='".$title."' rel", $link);
	return $link;
}


add_filter('next_posts_link_attributes', 'get_next_posts_link_attributes');
add_filter('previous_posts_link_attributes', 'get_previous_posts_link_attributes');

if (!function_exists('get_next_posts_link_attributes')){
	function get_next_posts_link_attributes($attr){
		$post_type = get_post_type();
		$attr = 'rel="myrel" title="Older '.$post_type.'s"';
		return $attr;
	}
}
if (!function_exists('get_previous_posts_link_attributes')){
	function get_previous_posts_link_attributes($attr){
		$post_type = get_post_type();
		$attr = 'rel="myrel" title="Newer '.$post_type.'s"';
		return $attr;
	}
}

/*********************
ORDER PROJECTS BY CUSTOM ORDER
*********************/
add_action( 'pre_get_posts', 'change_projects_sort_order'); 
function change_projects_sort_order($query){
    if(is_post_type_archive( 'project' )):
     //If you wanted it for the archive of a custom post type use: is_post_type_archive( $post_type )
       //Set the order ASC or DESC
       $query->set( 'order', 'ASC' );
       //Set the orderby
       $query->set( 'orderby', 'menu_order' );
    endif;    
};

/*********************
RELATED POSTS FUNCTION
*********************/

// Related Posts Function (call using bones_related_posts(); )
function bones_related_posts() {
	echo '<ul id="bones-related-posts">';
	global $post;
	$tags = wp_get_post_tags( $post->ID );
	if($tags) {
		foreach( $tags as $tag ) { 
			$tag_arr .= $tag->slug . ',';
		}
		$args = array(
			'tag' => $tag_arr,
			'numberposts' => 5, /* you can change this to show more */
			'post__not_in' => array($post->ID)
		);
		$related_posts = get_posts( $args );
		if($related_posts) {
			foreach ( $related_posts as $post ) : setup_postdata( $post ); ?>
				<li class="related_post"><a class="entry-unrelated" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
			<?php endforeach; }
		else { ?>
			<?php echo '<li class="no_related_post">' . __( 'No Related Posts Yet!', 'bonestheme' ) . '</li>'; ?>
		<?php }
	}
	wp_reset_query();
	echo '</ul>';
} /* end bones related posts function */

/*********************
PAGE NAVI
*********************/

// Numeric Page Navi (built into the theme by default)
function bones_page_navi() {
	global $wp_query;
	$bignum = 999999999;
	if ( $wp_query->max_num_pages <= 1 )
		return;
	
	echo '<nav class="pagination">';
	
		echo paginate_links( array(
			'base' 			=> str_replace( $bignum, '%#%', esc_url( get_pagenum_link($bignum) ) ),
			'format' 		=> '',
			'current' 		=> max( 1, get_query_var('paged') ),
			'total' 		=> $wp_query->max_num_pages,
			'prev_text' 	=> '&larr;',
			'next_text' 	=> '&rarr;',
			'type'			=> 'list',
			'end_size'		=> 3,
			'mid_size'		=> 3
		) );
	
	echo '</nav>';
} /* end page navi */


/*********************
RANDOM CLEANUP ITEMS
*********************/

// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function bones_filter_ptags_on_images($content){
	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

// This removes the annoying […] to a Read More link
function bones_excerpt_more($more) {
	global $post;
	// edit here if you like
	return '...  <a class="excerpt-read-more" href="'. get_permalink($post->ID) . '" title="'. __( 'Read', 'bonestheme' ) . get_the_title($post->ID).'">'. __( 'Read more &raquo;', 'bonestheme' ) .'</a>';
}

/*
 * This is a modified the_author_posts_link() which just returns the link.
 *
 * This is necessary to allow usage of the usual l10n process with printf().
 */
function bones_get_the_author_posts_link() {
	global $authordata;
	if ( !is_object( $authordata ) )
		return false;
	$link = sprintf(
		'<a href="%1$s" title="%2$s" rel="author">%3$s</a>',
		get_author_posts_url( $authordata->ID, $authordata->user_nicename ),
		esc_attr( sprintf( __( 'Posts by %s', 'blueleaf' ), get_the_author() ) ), // No further l10n needed, core will take care of this one
		get_the_author()
	);
	return $link;
}

function remove_jetpack_styles() {
	wp_deregister_style('sharedaddy'); // Sharedaddy
	wp_deregister_style('sharing'); // Sharedaddy Sharing	
}

add_action('wp_print_styles', 'remove_jetpack_styles');

function custom_excerpt_length( $length ) {
	return 100;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

//changejetpack related posts heding 

function related_posts_heading( $heading ) {
	$heading = '<h2 class="h2">Related Posts</h2>';
	return $heading;
}

add_filter( 'jetpack_relatedposts_filter_headline', 'related_posts_heading' );

/*********************
SHORTCODES
*********************/
function section_shortcode( $attrs, $content = null ){
	if (is_string($attrs)) {
		$attrs = array( 'box' => "false");
	}	
	if ($attrs['box'] == "true") {
		$box = 'section-box';
	}
	
	return '<section class="content-section clearfix '.$box.' '.$attrs['class'].'" itemprop="articleBody"><span class="section-anchor"><i class="fa fa-arrow-down"></i></span>' . do_shortcode($content) . '</section>'; // do_shortcode allows for nested Shortcodes
}
add_shortcode( 'section', 'section_shortcode' );

function web_hosting_ad_shortcode( $atts, $content = null ){
	return '<div class="web-hosting-ad clearfix"><span class="tag">A Carbon-free Cloud</span> <i>From</i> <span class="superhuge">&pound;'.$atts['price'].' / Year</span><a class="order-link button" href="'.$atts['orderlink'].'" title="Shopping Cart">'.$atts['linktext'].'</a></div>'; // do_shortcode allows for nested Shortcodes
}
add_shortcode( 'web-hosting-ad', 'web_hosting_ad_shortcode' );

?>
