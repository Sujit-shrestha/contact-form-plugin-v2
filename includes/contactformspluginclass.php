<?php
namespace Themegrill\ContactFormPluginV2;

 defined( 'ABSPATH' ) || exit;
 

 /**
  * Main class for Contact Form PLugin.
  *
  *@version 1.0.1
  */
 
final class Contactformspluginclass {

    /**
     * Single instance of the main class.
     * 
     * @var Contactformspluginclass
     * 
     */
    private static $instance  = null;

    /**
     * Plugins Installation class instance.
     */
    private $installationInstance ;

    /**
     * Plugins deactivation class instance
     */
    private $deactivationInstance ;

    /**
     * Privating constructor to make single instance available for use i.e. ( Singleton pattern ).
     * 
     * @since 1.0.1
     */
    private function __construct() {

    $this->init_hooks();

    }

    /**
     * Function to return the instance if available.
     *
     * @return self
     * @since 1.0.1
     */
    public static function getInstance(): self {

      if( is_null( self::$instance ) ) {
        self::$instance = new self();
      }
      return self::$instance;
    }

    /**
     * Hook for actions and filters.
     * 
     * @since 1.0.1
     * @return void
     */
    private function init_hooks(): void {

      /**
       * Registrations
       */
     
      
       //activation hook registration
      register_activation_hook( CFP_PLUGIN_FILE , array( $this, 'activate_plugin' ) );

      //deactivation hook registration
      register_deactivation_hook( CFP_PLUGIN_FILE , array ( $this , 'deactivate_plugin' ) );

      /**
       * Actions
       */
      add_action( 'init' , array( 'Themegrill\ContactFormPluginV2\Admin\Adminmenu' , 'createInstance' ) );
      



      /**
       * Filters
       */


       /**
        * Initiate class
        */
        $this->classInstantionations ( );

    }

    /**
     * Gets installation instance form CFP_Install class
     * 
     */
    public function getInstallationInstance ( ) {
      
      $this->installationInstance = new Install();

    }


    /**
     * Plugin activation jobs : Handled by CFP_Install calss in includes/class-cfp-intall.php
     */
    public function activate_plugin() {
      
      $this -> getInstallationInstance ( );
      $this -> installationInstance -> install ( );

    }

    /**
     * Plugin deactivation jobs init : 
     */
    public function deactivate_plugin () {

      $this -> deactivationInstance = Deactivate :: getDeactivationInstance ( );
      $this -> deactivationInstance -> deactivate ( );
    }

    /**
     * Class instantiations
     */
    public function classInstantionations () {
      //shortcode class initialization
      error_log(print_r("reached class instance of shortcode" , true) );
      new Shortcode ( );

    }
    
  }