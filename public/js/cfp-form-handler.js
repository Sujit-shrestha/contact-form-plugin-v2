
jQuery( document).on("submit", '#cfp_form_template_101',
	function (event) {
		event.preventDefault();
		var formid = jQuery(this).closest("form[id]").attr('id');

		var form = jQuery('#cfp_form_template_101').serialize() + '&form_id=' + formid;

		jQuery.ajax({

			url: cfp_jquery_object.ajax_url,

			data: {
				'data': form,
				'action': 'submit_cfp_form_action',
				'author': cfp_jquery_object.current_user_id,
				'nonce': cfp_jquery_object.cfp_nonce

			},
			type: 'post',

			success: function (result) {

				if (!result.success) {

					//displays the validation messages dynamically in the respective hidden fields
					validationArray = result.data.validation_error;
					
					jQuery(".cfp_validation_message_display_frontend" ).text("");

					for (const key in validationArray) {

						jQuery("#cfp_validation_message_displayer_" + validationArray[key].display_div_id_suffix).html(validationArray[key].message);

					}

				} else {

					//Providing success message to the user
					jQuery("#cfp_form_template_101").html('<h2> ' + result.data.message + '</h2>');

				}

			}
		});
	});