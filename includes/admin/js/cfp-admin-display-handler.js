
jQuery( document ).on( "keyup" , '#cfp_form_entry_search', function( e ) {
  

  jQuery.ajax({
    url:cfp_jquery_object.ajax_url,

    data: {
      'searchKeyword'   : this.value,
      'action' : 'admin_entries_search_action',
      'nonce'  : cfp_jquery_object.cfp_nonce_search
    },
    type: 'post',

    success : function ( result ) {

      if(typeof(result.success) != "undefined" && result.success !== null) {

        jQuery("#cfp_show_nonce_error_message").text(result.data.message  );
  
      }else{
       
        jQuery("#cfp_table_rows").html( result  );
       
      }
    }
  });
});

jQuery( document ).on( "click" , '.cfp_sorting_unit' ,
function ( e ) {
  $orderby = jQuery(e.currentTarget).attr('id');
  
  $sortstatus = jQuery(e.currentTarget).attr('sortStatus');

  if( $sortstatus == 'ASC' ){
     jQuery(e.currentTarget).attr("sortStatus", 'DESC');
  }
  else{
    $sortstatus = jQuery(e.currentTarget).attr("sortStatus", 'ASC');

  }
  $sortstatus = jQuery(e.currentTarget).attr('sortStatus');

  //getitng the search area value as well
  $searchValue = jQuery('#cfp_form_entry_search').val();
 


jQuery.ajax({
  url:cfp_jquery_object.ajax_url,

  data: {
    'searchKeyword' : $searchValue,
    'sortby'        : $sortstatus,
    'orderby'       : $orderby,
    'action'        : 'admin_entries_sort_action',
    'nonce'         : cfp_jquery_object.cfp_nonce_search
  },
  type: 'post',

  success : function ( result ) {
   
    if(typeof(result.success) != "undefined" && result.success !== null) {

      jQuery("#cfp_show_nonce_error_message").text(result.data.message  );

    }else{
        jQuery("#cfp_table_rows").html( result  );
    }
  }
});

});
