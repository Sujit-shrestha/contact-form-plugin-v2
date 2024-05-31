<?php 
namespace Themegrill\ContactFormPluginV2;

/**
 * Handles validation of the data based on the keys provided as a constraint to validate the give data
 * 
 * @version 1.0.1
 */

 defined ( 'ABSPATH' ) || exit;

 /**
  * Class definition
  */

  class Validation {
    
     /**
    * Validates the data based on keys provided
    * 
    * data are provided by the user
    * keys are array of constraints for each attribute
    * 
    * @param array
    * 
    */
   public static function validate_data ( $data , $keys) {
 
     $validation = [];
    
     foreach ( $keys as $k => $v ) {
 
       //validation for requried field chceck
       if ( in_array ( 'required' , $v ) ){
         if ( ! isset ( $data[$k] ) ) {
          
           $validation[$k] = array(
             "message"               => esc_html__( "This is a requried field."  , 'contact-form-plugin-cfp-themegrill' ),
             "display_div_id_suffix" => $k
           );
         }
       }
 
       //validaiton for empty field
       if ( in_array ( 'empty' , $v ) ){
         if (  empty ( $data[$k] ) ) {
           
           $validation[$k] = array(
             "message"               => esc_html__( "The field cannot be empty." , 'contact-form-plugin-cfp-themegrill' ),
             "display_div_id_suffix" => $k
           );
         }
       }
 
       //validation for max length
       if ( in_array( 'maxLength' , $v ) ) {
         $maxAllowedLength = array ( 
           'name'    => 40 ,
           'email'   => 40 ,
           'subject' => 100 ,
           'message' => 3000
         );
 
         $inputLength = strlen( $data[$k] ) ;
 
         if ( $inputLength > $maxAllowedLength[$k] ) {
        
           $validation[$k] = array(
             "message"               => esc_html__( "The field has exceeded max length." , 'contact-form-plugin-cfp-themegrill' ),
             "display_div_id_suffix" => $k
           );
         }
       }
 
       //validation for min length
       if ( in_array( 'minLength' , $v ) ) {
         $minAllowedLength = array ( 
           'name'    => 1 ,
           'email'   => 7 ,
           'subject' => 0 ,
           'message' => 0
         );
 
         $inputLength = strlen( $data[$k] ) ;
 
         if ( $inputLength < $minAllowedLength[$k] ) {
 
           $validation[$k] = array(
             "message"               => esc_html__( "The field should have at least length of $minAllowedLength[$k]." , 'contact-form-plugin-cfp-themegrill' ),
             "display_div_id_suffix" => $k
           );
         }
       } 
 
       //email validation
       if ( in_array( "emailFormat" , $v ) ){
         function isValidEmail ( $email ) {
           $tempp = filter_var( $email , FILTER_VALIDATE_EMAIL );
 
           if ( $tempp !== false ) {
             $temp = explode ( '@' , $email );
             if ( substr( $temp[0] , -1 ) === '+' ) {
              return false;
             }
 
             return true;
           } else {
             return false;
           }
         }
 
         isValidEmail( $data[$k] ) ? array( ) : 
         $validation[$k] = array(
           "message"               => esc_html__( "Email is not valid" , 'contact-form-plugin-cfp-themegrill' ),
           "display_div_id_suffix" => $k
         );
         continue;
       }
       
     }
     if ( count( $validation ) > 0 ){
       //sending all validation data at once
       wp_send_json_error(
               array(
                 "message"          => esc_html__( "Validation errors foind." , 'contact-form-plugin-cfp-themegrill' ),
                 "validation_error" => $validation,
                 "data"             => $data
               )
             );  
     }
     
     return true;
   
   }

     
  }
