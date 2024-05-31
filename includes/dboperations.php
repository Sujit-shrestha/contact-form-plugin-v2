<?php
namespace Themegrill\ContactFormPluginV2;

/**
 * Handles all the dtabase operaitons
 * 
 * @version 1.0.1
 */

defined('ABSPATH') || die;

class Dboperations {
  
  /**
   * Instance of CFP_DbOperations
   */
  public static $instance = null  ;

  /**
   * CFP form main table name
   */
  private $entriesTablenameSuffix   = "cfp_form_entries";

  /**
   * Constructor privated to make use of singgel instance of database operator
   */
  private function __construct(){

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
   * Saving in database
   * 
   * @param array
   * @return mixed
   */
  public function save( array $data ) {

    global $wpdb ;
    $tableName = $wpdb->prefix . $this->entriesTablenameSuffix;

    //data to insert in ( colummn : data ) format
    $to_insert =  array( 
        "form_id"   => $data['form_id'],
        "user_id"   => get_current_user_id(),
        "name"      => $data['name'],
        "email"     => $data['email'],
        "subject"   => $data['subject'],
        "message"   => $data['message'],

    );
     
    //insertion
    $wpdb -> insert (
        $tableName,
        $to_insert
    );
    //return true if no error
    if( ! $wpdb->last_error ){
      return true;
    }
    return "Something went wrong. Please reload and submit the form agian. Thank you.";
    
  }

  /**
   * Gets the columns available in the table
   * 
   * @return array
   */
  public function get_columns () : array {

    global $wpdb;
    $tableName = $wpdb->prefix . $this->entriesTablenameSuffix;

    $colums_available = $wpdb->get_col(" DESC $tableName");

    return $colums_available;

  }

  /**
   * Gets all the data from database
   * 
   * @return mixed
   */
  public function get_data ( $options)  {
    global $wpdb;
    $tableName = $wpdb->prefix . $this->entriesTablenameSuffix;

    $defaultConstraints = array( 
      "orderby" => 'entry_id' ,
      "sortorder"   => 'ASC' ,
      "limit"       => 5,
    );

    $parameter = array_merge($defaultConstraints , $options);

    $query = "
    SELECT * FROM $tableName 
    WHERE true 
    ";

    $searchKeyword = $parameter["searchKeyword"] ?? null;
    $searchColumns = ['entry_id', 'form_id', 'user_id', 'name', 'email', 'subject', 'message'];


    $whereClause = "";
    if ( ! empty( $searchKeyword ) ) {
        foreach ( $searchColumns as $column ) {
          $whereClause .= "$column LIKE '%$searchKeyword%' OR ";
        }
        $whereClause = rtrim( $whereClause, " OR " );

        if ( ! empty( $whereClause ) ) {
          $query .= " AND 
         ( $whereClause )
        ";
        }
      }

    $query .= " ORDER BY `$parameter[orderby]` $parameter[sortorder] ";


    $data = $wpdb->get_results( $query );

    return $data;
  }
}