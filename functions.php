<?php
/**
 * wpmaterialdesign functions and definitions
 *
 * @package wpmaterialdesign
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'wpmaterialdesign_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function wpmaterialdesign_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on wpmaterialdesign, use a find and replace
	 * to change 'wpmaterialdesign' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'wpmaterialdesign', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'wpmaterialdesign' ),
	) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );
	add_theme_support( 'post-thumbnails' );
	//add_image_size('post-header-image', 960, 300, true);
	
	
	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'wpmaterialdesign_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Enable support for HTML5 markup.
	add_theme_support( 'html5', array(
		'comment-list',
		'search-form',
		'comment-form',
		'gallery',
		'caption',
	) );
}
endif; // wpmaterialdesign_setup
add_action( 'after_setup_theme', 'wpmaterialdesign_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function wpmaterialdesign_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Left sidebar', 'wpmaterialdesign' ),
		'id'            => 'left-sidebar',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Main sidebar', 'wpmaterialdesign' ),
		'id'            => 'main-sidebar',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'wpmaterialdesign_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function wpmaterialdesign_scripts() {
	
	global $wpmaterialdesign_theme_settings;

	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css');
	//wp_enqueue_style( 'custom', get_template_directory_uri() . '/bootstrap/css/custom.min.css');

	/* load color sheme */
	
	//echo $wpmaterialdesign_theme_settings['color_scheme'];
	
	/* load shadows */
	if($wpmaterialdesign_theme_settings['shadows']){
		wp_enqueue_style( 'shadows', get_template_directory_uri() . '/bootstrap/css/color_schema_shadows.css');
	}

	/* load lines */
	if($wpmaterialdesign_theme_settings['lines']){
		wp_enqueue_style( 'lines', get_template_directory_uri() . '/bootstrap/css/color_schema_lines.css');
	}

	/* load tiled margins */
	if($wpmaterialdesign_theme_settings['tiled_margins']){
		wp_enqueue_style( 'tiled_margins', get_template_directory_uri() . '/bootstrap/css/color_schema_tiled_margins.css');
	}

	//wp_enqueue_style( 'roboto', get_template_directory_uri() . '/bootstrap/css/roboto.min.css');

	//wp_enqueue_style( 'material', get_template_directory_uri() . '/bootstrap/css/material.min.css');

	//wp_enqueue_style( 'ripples', get_template_directory_uri() . '/bootstrap/css/ripples.min.css');

	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/bootstrap/js/bootstrap.min.js', array('jquery'), '', true );
	
	wp_enqueue_script( 'custom-js', get_template_directory_uri() . '/bootstrap/js/custom.js', array(), '', true );

	wp_enqueue_style( 'wpmaterialdesign-style', get_stylesheet_uri() );
	
	//wp_enqueue_script( 'wpmaterialdesign-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	//wp_enqueue_script( 'wpmaterialdesign-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	//wp_enqueue_script( 'ripples', get_template_directory_uri() . '/js/ripples.min.js', array(), '', true );

	//wp_enqueue_script( 'material', get_template_directory_uri() . '/js/material.min.js', array(), '', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'wpmaterialdesign_scripts');

function get_theme_options(){	
	global $wpmaterialdesign_theme_settings;
	$wpmaterialdesign_theme_settings = get_option( 'wpmaterialdesign_theme_options' );

	
/*	global $wpmaterialdesign_theme_settings;
	$wpmaterialdesign_theme_settings = get_option( 'wpmaterialdesign_theme_options' );
	var_dump('generate_css > ',$wpmaterialdesign_theme_settings);
	$css_dir = get_stylesheet_directory() . '/'; // Shorten code, save 1 call
	ob_start(); // Capture all output (output buffering)
	require($css_dir . 'custom_style.php'); // Generate CSS
	$css = ob_get_clean(); // Get generated CSS (output buffering)
	file_put_contents($css_dir . 'custom_style.css', $css, LOCK_EX); // Save it*/
}
add_action('wp', 'get_theme_options');
	
/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
/**
 * Load bootstrap_navmenu_walker
 */
require get_template_directory() . '/inc/bootstrap_navmenu_walker.php';
/**
 * Template metabox
 */
require get_template_directory() . '/inc/template-metabox.php';

function new_excerpt_length($length) {
	return 10;
}
add_filter('excerpt_length', 'new_excerpt_length');

/**
 * Generate customize css 
 */
function wpmaterialdesign_generate_css() {
    require get_template_directory() . '/inc/custom_css.php';

    // Add specific CSS class by filter
	if( @$wpmaterialdesign_theme_settings['site_margins'] != 0	){ 
		add_filter( 'body_class', 'my_class_names' );
		function my_class_names( $classes ) {
			// add 'class-name' to the $classes array
			$classes[] = 'container';
			// return the $classes array
			return $classes;
		}
	}	
}
add_action( 'wp_head', 'wpmaterialdesign_generate_css' );
