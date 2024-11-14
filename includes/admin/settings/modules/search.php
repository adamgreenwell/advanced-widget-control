<?php
/**
 * Live Search Settings Module
 * Settings > Advanced Widget Control :: Live Widget Search
 *
 * @since       1.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Create Card Module for Live Widget Search
 *
 * @since 1.0
 * @global $widget_control
 * @return void
 */
 
 /*
 * Note: Please add a class "no-settings" in the <li> card if the card has no additional configuration, if there are configuration please remove the class
 */
 
if( !function_exists( 'widgetcontrol_settings_search' ) ):
	function widgetcontrol_settings_search(){
	    global $widget_control;
		//prevent undefined index error on upgrade
		if( !isset( $widget_control['search'] ) ){
			$widget_control['search'] = '';
		}
		?>
		<li class="widgetcontrol-module-card widgetcontrol-module-card-no-settings no-settings <?php echo ( $widget_control['search'] == 'activate' ) ? 'widgetcontrol-module-type-enabled' : 'widgetcontrol-module-type-disabled'; ?>" id="widgetcontrol-module-card-search" data-module-id="search">
			<div class="widgetcontrol-module-card-content">
				<h2><?php _e( 'Live Widget Search', 'advanced-widget-control' );?></h2>
				<p class="widgetcontrol-module-desc">
					<?php _e( 'Add live widget and sidebar search option on widgets.php admin dashboard.', 'advanced-widget-control' );?>
				</p>

				<div class="widgetcontrol-module-actions hide-if-no-js">
					<?php if( $widget_control['search'] == 'activate' ){ ?>
						<button class="button button-secondary widgetcontrol-toggle-settings"><?php _e( 'Learn More', 'advanced-widget-control' );?></button>
						<button class="button button-secondary widgetcontrol-toggle-activation"><?php _e( 'Disable', 'advanced-widget-control' );?></button>
					<?php } else { ?>
						<button class="button button-secondary widgetcontrol-toggle-settings"><?php _e( 'Learn More', 'advanced-widget-control' );?></button>
						<button class="button button-primary widgetcontrol-toggle-activation"><?php _e( 'Enable', 'advanced-widget-control' );?></button>
					<?php } ?>

				</div>
			</div>

			<?php widgetcontrol_modal_start( $widget_control['search'] ); ?>
				<span class="dashicons widgetcontrol-dashicons widgetcontrol-no-top dashicons-search"></span>
				<h3 class="widgetcontrol-modal-header"><?php _e( 'Live Widget & Sidebar Search', 'advanced-widget-control' );?></h3>
				<p>
					<?php _e( 'This feature will add search box before available widgets area that will let you filter the widgets for better widget handling. This will also add search box above the sidebar chooser when you click each widgets for you to assign them easily.', 'advanced-widget-control' );?>
				</p>
				<p class="widgetcontrol-settings-section">
					<?php _e( 'No additional settings available.', 'advanced-widget-control' );?>
				</p>
			<?php widgetcontrol_modal_end( $widget_control['search'] ); ?>

		</li>
	    <?php
	}
	add_action( 'widgetcontrol_module_cards', 'widgetcontrol_settings_search', 64 );
endif;
?>
