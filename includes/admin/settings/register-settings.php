<?php
/**
 * Register Settings
 * @since   1.0
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Get an option
 *
 * Looks to see if the specified setting exists, returns default if not
 *
 * @since 1.0
 * @global $widget_options Array of all the Advanced Widget Control
 * @return mixed
 */
if( !function_exists( 'widgetcontrol_get_option' ) ):
	function widgetcontrol_get_option( $key = '', $default = false ) {
		global $widget_options;

		$value = ! empty( $widget_options[ $key ] ) ? $widget_options[ $key ] : $default;
		$value = apply_filters( 'widgetcontrol_get_option', $value, $key, $default );

		return apply_filters( 'widgetcontrol_get_option_' . $key, $value, $key, $default );
	}
endif;

/**
 * Update an option
 *
 * Updates a widgetcontrol setting value in both the db and the global variable.
 * Warning: Passing in an empty, false or null string value will remove
 *          the key from the widget_options array.
 *
 * @since 1.0
 * @param string $key The Key to update
 * @param string|bool|int $value The value to set the key to
 * @global $widget_options Array of all the Advanced Widget Control
 * @return boolean True if updated, false if not.
 */
if( !function_exists( 'widgetcontrol_update_option' ) ):
	function widgetcontrol_update_option( $key = '', $value = false ) {

		// If no key, exit
		if ( empty( $key ) ){
			return false;
		}

		if ( empty( $value ) ) {
			$remove_option = widgetcontrol_delete_option( $key );
			return $remove_option;
		}

		// First let's grab the current settings
		$options = get_option( 'widgetcontrol_settings' );

		// Let's let devs alter that value coming in
		$value = apply_filters( 'widgetcontrol_update_option', $value, $key );

		// Next let's try to update the value
		$options[ $key ] = $value;

		$did_update = update_option( 'widgetcontrol_settings', $options );
		// If it updated, let's update the global variable
		if ( $did_update ){
			global $widget_options;
			$widget_options[ $key ] = $value;
		}
		return $did_update;
	}
endif;

/**
 * Remove an option
 *
 * Removes widget options setting value in both the db and the global variable.
 *
 * @since 1.0
 * @param string $key The Key to delete
 * @global $widget_options Array of all the Advanced Widget Control
 * @return boolean True if removed, false if not.
 */
if( !function_exists( 'widgetcontrol_delete_option' ) ):
	function widgetcontrol_delete_option( $key = '' ) {
		// If no key, exit
		if ( empty( $key ) ){
			return false;
		}
		// First let's grab the current settings
		$options = get_option( 'widgetcontrol_settings' );

		// Next let's try to update the value
		if( isset( $options[ $key ] ) ) {
			unset( $options[ $key ] );
		}
		$did_update = update_option( 'widgetcontrol_settings', $options );

		// If it updated, let's update the global variable
		if ( $did_update ){
			global $edd_options;
			$edd_options = $options;
		}
		return $did_update;
	}
endif;

/**
 * Get Settings
 *
 * Retrieves all plugin settings
 *
 * @since 1.0
 * @return array WIDGETCONTROL settings
 */
if( !function_exists( 'widgetcontrol_get_settings' ) ):
	function widgetcontrol_get_settings() {
		if (is_multisite()) {
			$settings = get_blog_option(get_current_blog_id(), 'widgetcontrol_settings');
		} else {
			$settings = get_option( 'widgetcontrol_settings' );
		}

		if( empty( $settings ) ) {

			$opts_settings 		= get_option( 'widgetcontrol_tabmodule-settings' );
			//fallback to prevent error
			if( is_serialized( $opts_settings ) ){
				$opts_settings = maybe_unserialize( $opts_settings );
			}

			// Update old settings with new single option
			$settings 			= !empty( $opts_settings ) ?  $opts_settings : array();
			$visibility 		= array( 'visibility' 		=> get_option( 'widgetcontrol_tabmodule-visibility' ) );
			$devices 			= array( 'devices' 			=> get_option( 'widgetcontrol_tabmodule-devices' ) );
			$alignment 			= array( 'alignment' 		=> get_option( 'widgetcontrol_tabmodule-alignment' ) );
			$hide_title 		= array( 'hide_title' 		=> get_option( 'widgetcontrol_tabmodule-hide_title' ) );
			$classes 			= array( 'classes' 			=> get_option( 'widgetcontrol_tabmodule-classes' ) );
			$logic 				= array( 'logic' 			=> get_option( 'widgetcontrol_tabmodule-logic' ) );
			$search 			= array( 'search' 			=> get_option( 'widgetcontrol_tabmodule-search' ) );
			$move 				= array( 'move' 			=> get_option( 'widgetcontrol_tabmodule-move' ) );
			$widget_area 		= array( 'widget_area' 		=> get_option( 'widgetcontrol_tabmodule-widget_area' ) );
			$import_export 		= array( 'import_export' 	=> get_option( 'widgetcontrol_tabmodule-import_export' ) );
			$state 				= array( 'state' 			=> get_option( 'widgetcontrol_tabmodule-state' ) );
			$classic_widgets_screen = array( 'state' 			=> get_option( 'widgetcontrol_tabmodule-classic_widgets_screen' ) );

			$settings = array_merge( array( 'settings' => $settings ), $visibility, $devices, $alignment, $hide_title, $classes, $logic, $search, $move, $widget_area, $import_export, $state,$classic_widgets_screen );

			$value = apply_filters( 'widgetcontrol_update_settings', $settings );

			update_option( 'widgetcontrol_settings', $settings );
		}

		$default = array('settings' => array(),
			'visibility' => '',
			'devices' => '',
			'alignment' => '',
			'columns' => '',
			'dates' => '',
			'styling' => '',
			'roles' => '',
			'hide_title' => '',
			'classes' => '',
			'logic' => '',
			'links' => '',
			'search' => '',
			'disable_widgets' => '',
			'permission' => '',
			'move' => '',
			'widget_area' => '',
			'import_export' => '',
			'urls' => '',
			'state' => '',
			'classic_widgets_screen'=>'activate');
		$settings = shortcode_atts($default, $settings);

		return apply_filters( 'widgetcontrol_get_settings', $settings );
	}
endif;
?>
