<?php 
namespace Themegrill\ContactFormPluginV2;


/**
 * Handles the form data
 * 
 * @version 1.0.1
 */

 defined( 'ABSPATH' ) || exit;
class Handleforms {

  /**
   * Constructor
   */
  public function __construct ( ) {

  }

  /**
   * Handles the form data 
   * 
   * Parses , sanitizes , validates and sends a escaped & translated result
   * 
   * @param none
   * @return void
   */
  public static function handleForm () {

    //parsing the serialized form data
    parse_str( $_POST["data"] ,$formData );

    //sanitization of fields
    $name    = sanitize_text_field($formData["name"]);
    $email   = sanitize_text_field( $formData["email"] );
    $subject = sanitize_text_field( $formData["subject"] );
    $message = sanitize_textarea_field( $formData["message"] );
    $nonce   = $_POST["nonce"] ?? null;
    $form_id = $formData["form_id"] ?? null;
    
    //formating user data for further processing
    $dataFromUser = array(
      'name'      => $name,
      'email'     => $email,
      'subject'   => $subject,
      'message'   => $message,
      'nonce'     => $nonce,
      'form_id'   => $form_id
    );


    //nonce check
    self :: verify_nonce ( $nonce );


    //keys definition to check different validations
    $keys = array( 
      'name'    => array( 'required' , 'empty' , 'maxLength' , 'minLength' ) ,
      'email'   => array( 'required' , 'empty' , 'emailFormat' , 'maxLength' , 'minLength' ),
      'subject' => array( 'maxLength'  ),
      'message' => array( 'maxLength'  )
    );

      //validate data
    $validationResponseIsTrue = Validation :: validate_data ( $dataFromUser  , $keys );


    //save in database

    if( $validationResponseIsTrue ) {
      $dbOperationInstance = Dboperations :: getInstance();

      $responseFromDatabase = $dbOperationInstance -> save( $dataFromUser );
    }

  
    if(  $responseFromDatabase  != 1){
      //despite its an eror message  , following funciotn is used to send the message directly on the place of form.
      wp_send_json_success(
        array(
          "message"   => esc_html__( $responseFromDatabase , 'contact-form-plugin-cfp-themegrill' ),
          "data"      => $dataFromUser
        )
      );
    }

    //reaches here if everything is on par : success
    wp_send_json_success(
      array(
        "message" => esc_html__( "Thanks for submission of the form. We are glad to get your thoughts. We will get back to you soon." , 'contact-form-plugin-cfp-themegrill' ),
        "data"    => $dataFromUser
      )
    );
  }
 
  

  /**
   * Verifies the nonce provided to the form
   */
  private static function verify_nonce ( $nonce) {

    if ( ! wp_verify_nonce( $nonce , 'wp_ajax_submit_cfp_form_action_secure_themegrill9988') ) {
      wp_send_json_error( 
        array ( 
          "message"                 => esc_html__ ( "Nonce not verified. Please reload."  , 'contact-form-plugin-cfp-themegrill' ),
          "display_div_id_suffix"   => esc_html( "default" )
         )
       );
       exit;
    }

  }
}