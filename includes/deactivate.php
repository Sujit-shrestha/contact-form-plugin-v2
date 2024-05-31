<?php 
namespace Themegrill\ContactFormPluginV2;

defined('ABSPATH') || exit;
/**
 * Class for handling deactivation jobs in the CFP plugin
 * 
 * @version 1.0.1
 * 
 */

 class Deactivate {
  /**
   * Deactivation instance
   */
  private static $deactivationInstance = null ;

  /**
   * Constructor
   * 
   * Privatizing the construct for deactivaiton to prevent others to deactivate this without use of proper deactivation method
   * 
   * @since 1.0.1
   */

  private function __construct ( ) {

   }

   /**
    * Creates the object of self and returns it
    *
    *@return self
    */
  public static function getDeactivationInstance ( ) : self {

   if( is_null( self :: $deactivationInstance ) ) {
          $deactivationInstance = new self();
        }
    
        return $deactivationInstance;
      }

 /**       
  * DEactivation jobs handler
       * 
       * @return void
       */
  public function deactivate ( ) {

    $this -> flushRewriteRules ( );

    $this -> updateOption ( );

  }

  /**
   * flush rewrite
   * 
   */
  public function flushRewriteRules () {

    flush_rewrite_rules (  ) ;

  }

  /**
   * Delete the option on deactivation
   */
  public function updateOption () {
    
    //set plugin deactivation denotation in option table

    delete_option( "cfp_plugin_activated" );
    

  }


  

}

 