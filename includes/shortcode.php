<?php 
namespace Themegrill\ContactFormPluginV2;


/**
 *  CFM shortcodes
 * 
 * @version 1.0.1
 */

 defined( 'ABSPATH' ) || exit;

 /**
  * Contact form plugin shortcodes
  */

 class Shortcode { 

  /**
   * Constructor
   */

   public function __construct (  ) {
    /**
     * Actions
     */

    add_action( 'init' , array( $this , 'shortcode_define' ) );
    add_action( 'wp_enqueue_scripts' , array( $this , 'enqueueCpfFormHandlerScripts' ) );

    //form action handler
    add_action( 'wp_ajax_submit_cfp_form_action' , array ( 'Handleforms' , 'handleForm'  ) );
    add_action( 'wp_ajax_nopriv_submit_cfp_form_action' , array ( 'Handleforms' , 'handleForm'  ) );

   }

  /**
   * Defining shortcode as [Cfp_form_code]
   * 
   * @since 1.0.1
   */
  public function shortcode_define (  ) {
    
    add_shortcode( 'CFP_form_code' , array( $this , 'getCFPFormTemplate' ) );
  }

  /**
   * Gets template for the form
   * 
   * Returns a php file with html template
   * 
   * @since 1.0.1
   * @return mixed
   */

   public function getCFPFormTemplate ( ) {

    $templateFile = file_get_contents( dirname(CFP_PLUGIN_FILE) . '/templates/cfp-form-template.php' );

    return $templateFile;
   }

   /**
    * Gets the form handling scripts

    * @since 1.0.1
    * @return void
    */
    public function enqueueCpfFormHandlerScripts () {

      //script for the form
      wp_enqueue_script( 'customjs' , plugins_url( 'contact-form-plugin/public/js/cfp-form-handler.js' , 'contact-form-plugin' ) , [ 'jquery' ] , '1.0.1' );

      //style
      wp_enqueue_style( 'frontend_form_css' , plugins_url( 'contact-form-plugin/public/css/cfp-form-handler.css' , 'contact-form-plugin' ));

      //localization for ajax request 
      wp_localize_script(
        'customjs' ,
        'cfp_jquery_object',
        array (  
          'ajax_url' => admin_url( 'admin-ajax.php' ),
          'current_user_id' => get_current_user_id(),
          'cfp_nonce' => wp_create_nonce ( 'wp_ajax_submit_cfp_form_action_secure_themegrill9988' )
        )
      );

    }
 }