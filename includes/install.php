<?php
/**
 * Install Function
 *
 * @since       1.0
*/
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

//add settings link on plugin page
if( !function_exists( 'widgetcontrol_filter_plugin_actions' ) ){
  add_action( 'plugin_action_links_' . plugin_basename( WIDGETCONTROL_PLUGIN_FILE ) , 'widgetcontrol_filter_plugin_actions' );
  function widgetcontrol_filter_plugin_actions($links){

  	if( !is_array( $links ) ){
  		$links = array();
  	}

    $links[]  = '<a href="'. esc_url( admin_url( 'options-general.php?page=widgetcontrol_plugin_settings' ) ) .'">' . __( 'Settings', 'advanced-widget-control' ) . '</a>';
    return $links;
  }
}

//register default values
if( !function_exists( 'widgetcontrol_register_defaults' ) ){
	register_activation_hook( WIDGETCONTROL_PLUGIN_FILE, 'widgetcontrol_register_defaults' );
  	add_action( 'plugins_loaded', 'widgetcontrol_register_defaults' );
	function widgetcontrol_register_defaults(){
		if( is_admin() ){

			if( !get_option( 'widgetcontrol_installDate' ) ){
				add_option( 'widgetcontrol_installDate', date( 'Y-m-d h:i:s' ) );
			}

			if( !get_option( '_widgetcontrol_default_registered_' ) ){

				add_option( 'widgetcontrol_tabmodule-visibility', 'activate' );
				add_option( 'widgetcontrol_tabmodule-devices', 'activate' );
				add_option( 'widgetcontrol_tabmodule-alignment', 'activate' );
				add_option( 'widgetcontrol_tabmodule-hide_title', 'activate' );
				add_option( 'widgetcontrol_tabmodule-classes', 'activate' );
				add_option( 'widgetcontrol_tabmodule-logic', 'activate' );
				add_option( 'widgetcontrol_tabmodule-state', 'activate' );
				add_option( 'widgetcontrol_tabmodule-classic_widgets_screen', 'activate' );

				$defaults = array(
						'visibility' 	=> 	array(
							'post_type'		=> '1',
							'taxonomies'	=> '1',
							'misc'			=> '1'
						),
						'classes' 		=> 	array(
							'id'			=> '1',
							'type'			=> 'both'
						),
				);

				$options    = get_option('extwopts_class_settings');
				if( isset( $options['class_field'] ) ){
					$defaults['classes']['type'] = $options['class_field'];
				}
				if( isset( $options['classlists'] ) ){
					$defaults['classes']['classlists'] = $options['classlists'];
				}
				add_option( 'widgetcontrol_tabmodule-settings', serialize( $defaults ) );
				add_option( '_widgetcontrol_default_registered_', '1' );
				delete_transient( 'widgetcontrol_tabs_transient' );
				delete_option( 'widgetcontrol_settings' );
			}

			if( !get_option( 'widgetcontrol_removed_global_pages' ) ){
				delete_option( 'widgetcontrol_global_pages' );		
				add_option( 'widgetcontrol_removed_global_pages', 1 );
			}

		}
	}
}

?>
