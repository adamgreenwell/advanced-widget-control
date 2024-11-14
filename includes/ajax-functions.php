<?php
/**
 * AJAX Functions
 *
 * Process AJAX actions.
 *
 */
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Save Options
 *
 * @since 1.0
 * @return void
 */
function widgetcontrol_ajax_save_settings(){
    $response = array( 'errors' => array() );

	if( !isset( $_POST['method'] ) ) return;
	if( !isset( $_POST['nonce'] ) ) return;

	if ( ! wp_verify_nonce( $_POST['nonce'], 'widgetcontrol-settings-nonce' ) ) {
		return;
	}

	switch ( $_POST['method'] ) {
		case 'activate':
		case 'deactivate':
				if( !isset( $_POST['module'] ) ) return;

				//update options
				update_option( 'widgetcontrol_tabmodule-' . sanitize_text_field( $_POST['module'] ), sanitize_text_field( $_POST['method'] ) );

				//update global variable
				widgetcontrol_update_option( sanitize_text_field( $_POST['module'] ), sanitize_text_field( $_POST['method'] ) );
			break;

		case 'save':
				$response['messages'] = array( __( 'Settings saved successfully.', 'advanced-widget-control' ) );
				if( !isset( $_POST['data'] ) ) return;
				parse_str( $_POST['data']['--widgetcontrol-form-serialized-data'], $params );
				$sanitized = widgetcontrol_sanitize_array( $params );
				update_option( 'widgetcontrol_tabmodule-settings', maybe_serialize( $sanitized ) );

				//reset options
				widgetcontrol_update_option( 'settings', $sanitized );
			break;

		default:
			# code...
			break;
	}
	$response['source'] 	= 'WIDGETCONTROL_Response';
	$response['response'] 	= 'success';
	$response['closeModal'] = true;
	$response 				= (object) $response;

	//let devs do there action
	do_action( 'widget_options_before_ajax_print', sanitize_text_field( $_POST['method'] ) );

	echo json_encode( $response );
	die();
}
add_action( 'wp_ajax_widgetcontrol_ajax_settings',  'widgetcontrol_ajax_save_settings' );
