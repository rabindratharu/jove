<?php
/**
 * Theme Functions.
 *
 * @package Jove
 */


if ( ! defined( 'JOVE_VERSION' ) ) {
	define( 'JOVE_VERSION', '1.0.0' );
}

if ( ! defined( 'JOVE_DIR_PATH' ) ) {
	define( 'JOVE_DIR_PATH', untrailingslashit( get_template_directory() ) );
}

if ( ! defined( 'JOVE_DIR_URI' ) ) {
	define( 'JOVE_DIR_URI', untrailingslashit( get_template_directory_uri() ) );
}

if ( ! defined( 'JOVE_BUILD_URI' ) ) {
	define( 'JOVE_BUILD_URI', untrailingslashit( get_template_directory_uri() ) . '/build' );
}

if ( ! defined( 'JOVE_BUILD_PATH' ) ) {
	define( 'JOVE_BUILD_PATH', untrailingslashit( get_template_directory() ) . '/build' );
}

require_once JOVE_DIR_PATH . '/inc/helpers/custom-functions.php';
require_once JOVE_DIR_PATH . '/inc/helpers/autoloader.php';

function jove_get_instance() {
	\Jove\Inc\Jove::get_instance();
}

jove_get_instance();