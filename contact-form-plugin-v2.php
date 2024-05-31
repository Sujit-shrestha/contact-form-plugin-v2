<?php 

/**
 * Plugin Name: Contact Form Plugin CFP v2
 * Description: User can add the form anywhere using shortcode provided by this plugin and view the entries and filter through the entries.
 * Version: 1.0.2
 * Author: Sujit Shrestha
 * Author URI: https://linked.com/in/mrsujiit
 * Text Domain: 'contact-form-plugin-cfp-themegrill'
 * License: GPLv2 or Later
 */


 //custom file includer to include files 
// require_once __DIR__ .'/file-includer.php';

 if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

//Defining Contact Form Plugin File  i.e. CFP_PLUGIN_FILE.
if ( ! defined( 'CFP_PLUGIN_FILE' ) ) {
	define( 'CFP_PLUGIN_FILE', __FILE__);
 
}

//defineing Contact Form Plugin text domain
if( ! defined( 'CFP_TEXT_DOMAIN' ) ){
  define ( 'CFP_TEXT_DOMAIN' , 'contact-form-plugin-cfp-themegrill' );

}

 /**
  * Main instance for Contact Form Plugin
  *
  * Gets the main instance
  *
  */
  require __DIR__ . '/vendor/autoload.php';
  Themegrill\ContactFormPluginV2\Contactformspluginclass::getInstance();

