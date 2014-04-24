<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_VERSION', '1.0.0' );

//* Enqueue Google Fonts
add_action( 'wp_enqueue_scripts', 'wintersong_google_fonts' );
function wintersong_google_fonts() {
	wp_enqueue_style( 'google-font-roboto', '//fonts.googleapis.com/css?family=Roboto+Condensed:300|Roboto+Slab:300,400', array(), CHILD_THEME_VERSION );
}

//* Add HTML5 markup structure
add_theme_support( 'html5' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Force full-width-content layout setting
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

//* Unregister sidebars
unregister_sidebar( 'sidebar' );
unregister_sidebar( 'sidebar-alt' );

//* Unregister layout settings
genesis_unregister_layout( 'content-sidebar' );
genesis_unregister_layout( 'sidebar-content' );
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'admin-preview-callback'	=> 'wintersong_admin_header_callback',
	'default-text-color'			=> 'ffffff',
	'header-selector'			=> '.site-header .site-avatar img',
	'height'							=> 224,
	'width'							=> 224,
) );

function wintersong_admin_header_callback() {
	echo get_header_image() ? '<img src="' . get_header_image() . '" />' : get_avatar( get_option( 'admin_email' ), 224 );
}

//* Hook site avatar before site title
add_action( 'genesis_header', 'wintersong_site_gravatar', 5 );
function wintersong_site_gravatar() {

	$header_image = get_header_image() ? '<img alt="" src="' . get_header_image() . '" />' : get_avatar( get_option( 'admin_email' ), 224 );
	printf( '<div class="site-avatar"><a href="%s">%s</a></div>', home_url( '/' ), $header_image );

}

//* Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_nav' );

//* Unregister secondary navigation menu
add_theme_support( 'genesis-menus', array( 'primary' => __( 'Primary Navigation Menu', 'genesis' ) ) );

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'wintersong_author_box_gravatar_size' );
function wintersong_author_box_gravatar_size( $size ) {
	return '144';
}

//* Modify the size of the Gravatar in the entry comments
add_filter( 'genesis_comment_list_args', 'bg_comments_gravatar' );
function bg_comments_gravatar( $args ) {
    $args['avatar_size'] = 112;
	return $args;
}

//* Customize the footer
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );
add_action( 'genesis_header', 'genesis_footer_markup_open', 11 );
add_action( 'genesis_header', 'genesis_footer_markup_close', 13 );
add_action( 'genesis_header', 'wintersong_footer' );
	function wintersong_footer() { ?>
	<div class="site-footer"><div class="wrap">
		<p>Powered by <a href="http://www.studiopress.com/">Genesis</a>.</p>
	</div></div>
	<?php
}