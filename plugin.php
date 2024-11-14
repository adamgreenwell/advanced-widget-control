<?php
/**
 * Plugin Name: Advanced Widget Control
 * Description: Additional widget options for better widget management, placement and manipulation.
 * Version: 1.0
 * Author: Adam Greenwell
 * Text Domain: advanced-widget-control
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'WP_Advanced_Widget_Control' ) ) :

/**
 * Main WP_Advanced_Widget_Control Class.
 *
 * @since 1.0
 */
final class WP_Advanced_Widget_Control {
	/**
	 * @var WP_Advanced_Widget_Control
	 * @since 1.0
	 */
	private static $instance;

	/**
	 * Main WP_Advanced_Widget_Control Instance.
	 *
	 * Insures that only one instance of WP_Advanced_Widget_Control exists in memory at any one
	 * time. Also prevents needing to define globals all over the place.
	 *
	 * @since 1.0
	 * @static
	 * @staticvar array $instance
	 * @uses WP_Advanced_Widget_Control::setup_constants() Set up the constants needed.
	 * @uses WP_Advanced_Widget_Control::includes() Include the required files.
	 * @uses WP_Advanced_Widget_Control::load_textdomain() load the language files.
	 * @see WIDGETCONTROL()
	 * @return object|WP_Advanced_Widget_Control
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof WP_Advanced_Widget_Control ) ) {
			self::$instance = new WP_Advanced_Widget_Control;
			self::$instance->setup_constants();

			// add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );

			self::$instance->includes();
			// self::$instance->roles         = new WIDGETCONTROL_Roles();
			add_filter( 'use_widgets_block_editor', array(self::$instance,'widget_options_use_widgets_block_editor') );
		}
		return self::$instance;
	}

	/**
	 * REVERT classic widgets screen
	 */
	public function widget_options_use_widgets_block_editor( $use_widgets_block_editor ) {
		global $widget_options;
		if(!empty($widget_options['classic_widgets_screen']) && $widget_options['classic_widgets_screen'] == 'activate' ){
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Setup plugin constants.
	 *
	 * @access private
	 * @return void
	 */
	private function setup_constants() {

		// Plugin version.
		if ( ! defined( 'WIDGETCONTROL_PLUGIN_NAME' ) ) {
			define( 'WIDGETCONTROL_PLUGIN_NAME', 'Advanced Widget Control' );
		}

		// Plugin version.
		if ( ! defined( 'WIDGETCONTROL_VERSION' ) ) {
			define( 'WIDGETCONTROL_VERSION', '1.0.0' );
		}

		// Plugin Folder Path.
		if ( ! defined( 'WIDGETCONTROL_PLUGIN_DIR' ) ) {
			define( 'WIDGETCONTROL_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		}

		// Plugin Folder URL.
		if ( ! defined( 'WIDGETCONTROL_PLUGIN_URL' ) ) {
			define( 'WIDGETCONTROL_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		}

		// Plugin Root File.
		if ( ! defined( 'WIDGETCONTROL_PLUGIN_FILE' ) ) {
			define( 'WIDGETCONTROL_PLUGIN_FILE', __FILE__ );
		}
		
	}

	/**
	 * Include required files.
	 *
	 * @access private
	 * @since 1.0
	 * @return void
	 */
	private function includes() {
		global $widget_options, $widgetcontrol_taxonomies, $widgetcontrol_pages, $widgetcontrol_types, $widgetcontrol_categories, $pagenow;

		require_once WIDGETCONTROL_PLUGIN_DIR . 'includes/admin/settings/register-settings.php';
		$widget_options = widgetcontrol_get_settings();

		require_once WIDGETCONTROL_PLUGIN_DIR . 'includes/extras.php';
		require_once WIDGETCONTROL_PLUGIN_DIR . 'includes/scripts.php';

		//call admin only resources
		if ( is_admin() ) {

			//other global variables to prevent duplicate and faster calls
			$widgetcontrol_pages 		= widgetcontrol_global_pages();

			//admin settings
			require_once WIDGETCONTROL_PLUGIN_DIR . 'includes/admin/globals.php';
			require_once WIDGETCONTROL_PLUGIN_DIR . 'includes/admin/settings/display-settings.php';

			if( in_array( $pagenow, array( 'options-general.php' ) ) ){
				require_once WIDGETCONTROL_PLUGIN_DIR . 'includes/admin/settings/modules/visibility.php';
				require_once WIDGETCONTROL_PLUGIN_DIR . 'includes/admin/settings/modules/devices.php';
				require_once WIDGETCONTROL_PLUGIN_DIR . 'includes/admin/settings/modules/title.php';
				require_once WIDGETCONTROL_PLUGIN_DIR . 'includes/admin/settings/modules/classes.php';
				require_once WIDGETCONTROL_PLUGIN_DIR . 'includes/admin/settings/modules/logic.php';
				require_once WIDGETCONTROL_PLUGIN_DIR . 'includes/admin/settings/modules/search.php';
				require_once WIDGETCONTROL_PLUGIN_DIR . 'includes/admin/settings/modules/move.php';
				require_once WIDGETCONTROL_PLUGIN_DIR . 'includes/admin/settings/modules/import-export.php';
				require_once WIDGETCONTROL_PLUGIN_DIR . 'includes/admin/settings/modules/widget-area.php';
				require_once WIDGETCONTROL_PLUGIN_DIR . 'includes/admin/settings/modules/state.php';
			}

			// if( in_array( $pagenow, array( 'widgets.php' ) ) ){
				//widget callbacks
				require_once WIDGETCONTROL_PLUGIN_DIR . 'includes/widgets/widgets.php';

				//add visibility tab if activated
				if( $widget_options['visibility'] == 'activate' ){
					require_once WIDGETCONTROL_PLUGIN_DIR . 'includes/widgets/option-tabs/visibility.php';
				}
				//add devices tab if activated
				if( $widget_options['devices'] == 'activate' ){
					require_once WIDGETCONTROL_PLUGIN_DIR . 'includes/widgets/option-tabs/devices.php';
				}

				//add alignment tab if activated
				if( $widget_options['alignment'] == 'activate' ){
					require_once WIDGETCONTROL_PLUGIN_DIR . 'includes/widgets/option-tabs/alignment.php';
				}

				//add alignment tab if activated
				if( isset( $widget_options['state'] ) && $widget_options['state'] == 'activate' ){
					require_once WIDGETCONTROL_PLUGIN_DIR . 'includes/widgets/option-tabs/state.php';
				}

				require_once WIDGETCONTROL_PLUGIN_DIR . 'includes/widgets/option-tabs/styling.php';

				//add settings tab if activated
				if( 'activate' == $widget_options['hide_title'] ||
			        'activate' == $widget_options['classes'] ||
			        'activate' == $widget_options['logic'] ){
					require_once WIDGETCONTROL_PLUGIN_DIR . 'includes/widgets/option-tabs/settings.php';
				}

				if( ( isset( $widget_options['import_export'] ) && 'activate' == $widget_options['import_export'] ) ||
					( isset( $widget_options['widget_area'] ) && 'activate' == $widget_options['widget_area'] )
				 ){
					require_once WIDGETCONTROL_PLUGIN_DIR . 'includes/admin/import-export.php';
				}
			// }

		} //end is_admin condition

		require_once WIDGETCONTROL_PLUGIN_DIR . 'includes/widgets/extras.php';
		require_once WIDGETCONTROL_PLUGIN_DIR . 'includes/widgets/display.php';
		require_once WIDGETCONTROL_PLUGIN_DIR . 'includes/ajax-functions.php';

		require_once WIDGETCONTROL_PLUGIN_DIR . 'includes/install.php';
	}

}

endif; // End if class_exists check.

/**
 * The main function for that returns WP_Advanced_Widget_Control
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $widgetcontrol = WP_Advanced_Widget_Control(); ?>
 *
 * @since 1.0
 * @return object|WP_Advanced_Widget_Control   Instance.
 */
if( !function_exists( 'WIDGETCONTROL' ) ){
	function WIDGETCONTROL() {
		return WP_Advanced_Widget_Control::instance();
	}
	// Get Plugin Running.
	if( function_exists( 'is_multisite' ) && is_multisite() ){
		//loads on plugins_loaded action to avoid issue on multisite
		add_action( 'plugins_loaded', 'WIDGETCONTROL', apply_filters( 'widgetcontrol_priority', 90 ) );
	} else {
		WIDGETCONTROL();
	}
}
