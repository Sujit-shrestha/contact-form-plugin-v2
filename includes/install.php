<?php
namespace Themegrill\ContactFormPluginV2;


/**
 * Handles the functions that need to be run in installation of the CFP plugin
 * 
 * @version 1.0.1
 */

 defined( 'ABSPATH' ) || exit;

 /**
  * CFP_Install class
  */
  class Install {
   
   /**
    * Installation  or Activtion of plugin starts form here
    */
    public function install() {

     $this -> flushRewriteRules();
     $this -> setOption();
     $this -> tableCreation ();
   //   $this -> insertDefaultValues ();

   }
   
   /**
    * Flushes rewrite rules and recreates it.
    *
    * @return void
    */
   private function flushRewriteRules() {
     
      flush_rewrite_rules();
   }
   /**
    * Set activation key in options table
    *
    * @return void
    */

    private function setOption ( ) {
       //set plugin activated denotation in option table
     if ( ! get_option( "cfp_plugin_activated" ) ) {

      add_option( "cfp_plugin_activated", "true" );

      }
    }

   /**
    * Create table if not exists
    *
    * Simple table creation logic which can be further made better by checking the individual columns of already existing table in case already existing table is missing an  cokumsn
    */
    private function tableCreation ( ) {

      global $wpdb;

      $entriesTablename     = $wpdb->prefix ."cfp_form_entries";
      $entriesMetaTablename = $wpdb->prefix ."cfp_form_entriesmeta";

      $entriesTableCreationQuery = "
         CREATE TABLE IF NOT EXISTS $entriesTablename (
            entry_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            form_id varchar(100) NOT NULL,
            user_id INT UNSIGNED ,
            name varchar(40) NOT NULL,
            email varchar(40) NOT NULL,
            subject varchar(400) ,
            message TEXT,
            form_created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
         )
         ";

      $entryMetaTableCreationQuery = "
         CREATE TABLE IF NOT EXISTS $entriesMetaTablename (
            meta_id INT UNSIGNED NOT NULL AUTO_INCREMENT
            PRIMARY KEY,
            validation_key varchar(40) ,
            value varchar(500)
         )
         ";
      

      require_once ABSPATH . 'wp-admin/includes/upgrade.php';

      dbDelta( $entriesTableCreationQuery    , true );
      dbDelta( $entryMetaTableCreationQuery  , true );

    }

    /**
     * Inserts default validation values into meta table
     * 
     * @return void
     */
   
   private function insertDefaultValues () {
      global $wpdb;

      $metaTableName = $wpdb->prefix ."cfp_form_entriesmeta";

      $validationData =  array( 
         'default_invalid_input'          => "Enter a valid input", 

         'email_invalid_input_format'     => "Please enter a valid email.", 
         'name_invalid_input_format'      => "Please enter a valid name.",
         'subject_invalid_input_format'   => "Please enter proper subject.",
         'message_invalid_input_format'   => "Please enter a valid message",

         'email_invalid_input_length'     => "Length of email should be in range of 1 to 40 characters.",
         'name_invalid_input_length'      => "Length of name should be in range of 1 to 40 characters.",
         'subject_invalid_input_length'   => "Length of subbject should be in range of 1 to 100 characters.",
         'message_invalid_input_length'   => "Length of message should be in range of 0 to 3000.",

         'default_required'               => "This is a required field",
         'email_required'                 => "Email is a required field.",
         'name_required'                  => "Name is a required field.",
         'subject_required'               => "Subject is a required field.",
         'message_required'               => "Message is a required field."

      ) ;

      foreach( $validationData as $k => $v ){

         $checkIfExists = $wpdb->get_results( "SELECT 'meta_id'  from $metaTableName WHERE validation_key = '$k'" );
        
         if ( ! empty( $checkIfExists ) ) {
         
         continue;
         }
        
         $wpdb->insert(
            $metaTableName,
            array(
               "validation_key"  => $k,
               "value"           => $v
            )
         );
      }
   } 

  }