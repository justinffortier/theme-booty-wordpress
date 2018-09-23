<?php
/**
 * Bootstrap functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Bootstrap
 */

 /**
	* Sets up theme defaults and registers support for various WordPress features. Note that this function is hooked into the after_setup_theme hook, which runs before the init hook. The init hook is too late for some features, such as indicating support for post thumbnails.
*/
function bootstrap_setup() {
	load_theme_textdomain( 'bootstrap', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
}

add_action( 'after_setup_theme', 'bootstrap_setup' );

/**
 * Enqueue bootstrao scripts and styles.
 */
function bootstrap_assets() {
	wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js');
	wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css');
}
add_action( 'wp_enqueue_scripts', 'bootstrap_assets' );

/**
	* Removes frivolous scripts
*/
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
