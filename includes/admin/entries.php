<?php 
namespace Themegrill\ContactFormPluginV2\Admin;
use Themegrill\ContactFormPluginV2\Dboperations;

defined('ABSPATH') || exit;
/**
 * Handles display of table data
 */

 class Entries {
  /**
   * Single instance of entries class
   *
   * @var Entries
   */
  private static $instance  = null;

  /**
   * Stores column number
   */
  public static $columnNumber  ;
  /**
   * Constructor
   */
  public function __construct ( ) {

    add_action( 'cfp_admin_entires_during_table_columns_filling' , array( $this , 'render_sorting_button' ) );
    add_action( 'cfp_admin_entries_render_search_template' , array( $this , 'render_search_template' ) );
  }

  /**
   * Function to return the instance if available
   *
   * @return self
   * @since 1.0.1
   */
  public static function getInstance () : self {
    if( is_null( self::$instance ) ) {
      self::$instance = new self();
    }
    return self::$instance;
    }
  
  /**
   * Inititates the table rendering , data pulling task
   *
   * @return void
   */
  public function init () {

   //render search area
    do_action( 'cfp_admin_entries_render_search_template'  );

   //render table
    $this -> render_table_template ();
  

  }

  /**
   * Display search area
   */
  public function render_search_template (){

    ?>
    <label for="Search" ><?php  _e("Search:" , CFP_TEXT_DOMAIN) ?></label>
    <input id="cfp_form_entry_search" type="text" placeholder="<?php  _e("Type here to search..." , CFP_TEXT_DOMAIN) ?>" />
  
    </br></br>
    <?php

  }


  /**
   * Table displaying
   */
  public function render_table_template (  $constraints=[]  ) {

    $dbOps           = Dboperations :: getInstance ( ) ;
    $columsAvailable = $dbOps -> get_columns ( ) ;
    self :: $columnNumber = count( $columsAvailable );

    $displayName = array( 
      "entry_id"        => "Entry ID" ,
      "form_id"         => "Form ID" ,
      "user_id"         => "User ID" ,
      "name"            => "Name" ,
      "subject"         => "Subject" ,
      "message"         => "Message" ,
      "form_created_at" => "Form Created At"
    );

  ?>

<!DOCTYPE html>
<html>
  <span id="cfp_show_nonce_error_message"></span>
  <table id="cfp_table_entries">
    <tr>
    <th>
        SN.
    </th>
      <?php 
      foreach( $columsAvailable as $col){
      ?>
      
        <th id="cfp_table_entries_<?php echo $col ?>" >
          <?php
           esc_html_e($displayName[$col] ?? $col , CFP_TEXT_DOMAIN );
           do_action('cfp_admin_entires_during_table_columns_filling' , $col);
          ?>
        </th>

      <?php
      }
      ?>
    </tr>
    <tbody id="cfp_table_rows" >
      <?php 
      $this->render_table_rows( $constraints );
      ?>
    </tbody>
  </table>
</body>

</html>
<?php

  }

  /**
   * Render table rows
   */
  public function render_table_rows( $constraints){
    $dbOps           = Dboperations :: getInstance ( ) ;
    $dataAvailable   = $dbOps -> get_data ( $constraints ) ;
    if( empty( $dataAvailable ) ){
      $this -> display_empty_table_message( ) ;
      exit;
    }

    $count = 0;
    foreach( $dataAvailable as $row ){
      $count ++;
    ?>
      <tr class="table_class_row">
        <td>
          <?php esc_html_e($count , CFP_TEXT_DOMAIN) ?>
        </td>
        <?php
        foreach( $row as $unit ) {
        ?> 
          <td>
            <?php 
            esc_html_e($unit , CFP_TEXT_DOMAIN);
            ?>
          </td>
      
        <?php
        }
        ?>
      </tr>
    <?php
    }
   
  }
  /**
   * Displays empty table message
   */
  public function display_empty_table_message ( ) {

    ?>
    <tr id="cfp_no_entries_available_message">
      <td align="center" colspan="<?php echo self:: $columnNumber ?? 9 ?>">
        No entries available.
      </td>
    </tr>
    <?php
  }

  /**
   * Enqueue scripts and css
   */
  public static function admin_enqueuing () {

    //script
    wp_enqueue_script( 'admin_search_js' , plugins_url( 'contact-form-plugin/includes/admin/js/cfp-admin-display-handler.js' , 'contact-form-plugin' ) , [ 'jquery' ] , '1.0.1' );

    //styles
    wp_enqueue_style('entries_table_css' , plugins_url( 'contact-form-plugin/includes/admin/css/cfp-admin-entries.css' , 'contact-form-plugin' ) ) ;

    //localization for ajax request 
    wp_localize_script(
      'admin_search_js' ,
      'cfp_jquery_object',
      array (  
        'ajax_url'         => admin_url( 'admin-ajax.php' ),
        'cfp_nonce_search' => wp_create_nonce ( 'wp_ajax_admin_search_sort_secure_themegrill9988' )
      )
    );
  }

  /**
   * Handles search in the admin entries display
   * 
   */
  public static function handle_search() {

    self:: verify_nonce(
      $_POST["nonce"]
    );
      
    $formEntriesDisplay = Entries :: getInstance ( ) ;
    
          $formEntriesDisplay -> render_table_rows (
            array(
              "searchKeyword" => esc_html__( 
                   sanitize_text_field($_POST["searchKeyword"] ) ,
                CFP_TEXT_DOMAIN  ),
            )
          ); 
  }
  /**
   * Handles sorting in the admin entries
   * 
   */
  public static function handle_sort () {
    self:: verify_nonce(
      $_POST["nonce"]
    );
    $formEntriesDisplay = Entries :: getInstance ( ) ;
    
    $formEntriesDisplay -> render_table_rows(
      array(
        "orderby"       => sanitize_text_field($_POST["orderby"]),
        "sortorder"     => sanitize_text_field($_POST["sortby"]),
        "searchKeyword" => sanitize_text_field($_POST["searchKeyword"])
      )
    );
  }

  /**
   * Conditionally reders soritng button on the required column id as provided in $args
   * 
   */
  public function render_sorting_button($args){
    
    $addSortingButtonOn = array( 'name' , 'email' );
    
    if( in_array( $args , $addSortingButtonOn ) ) {
       ?><span class="cfp_sorting_unit" id="<?php echo $args ?>">
        <svg id="svg_cfp" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M137.4 41.4c12.5-12.5 32.8-12.5 45.3 0l128 128c9.2 9.2 11.9 22.9 6.9 34.9s-16.6 19.8-29.6 19.8H32c-12.9 0-24.6-7.8-29.6-19.8s-2.2-25.7 6.9-34.9l128-128zm0 429.3l-128-128c-9.2-9.2-11.9-22.9-6.9-34.9s16.6-19.8 29.6-19.8H288c12.9 0 24.6 7.8 29.6 19.8s2.2 25.7-6.9 34.9l-128 128c-12.5 12.5-32.8 12.5-45.3 0z"/></svg>
       </span>
       <?php
    }
  }

    /**
   * Verifies the nonce provided to the form
   */
  private static function verify_nonce ( $nonce) {

    if ( ! wp_verify_nonce( $nonce , 'wp_ajax_admin_search_sort_secure_themegrill9988') ) {
      wp_send_json_error( 
        array ( 
          "message"                 => esc_html__ ( "* Nonce not verified. Please reload."  , 'contact-form-plugin-cfp-themegrill' ),
         )
       );
       exit;
    }

  }
 }