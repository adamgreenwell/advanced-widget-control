<?php
/**
 * User Login State Settings Module
 * Settings > Advanced Widget Control :: User Login State
 *
 * @since       1.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Create Card Module for User Login State
 *
 * @since 1.0
 * @global $widget_control
 * @return void
 */
 
 /*
 * Note: Please add a class "no-settings" in the <li> card if the card has no additional configuration, if there are configuration please remove the class
 */

if( !class_exists( 'widgetcontrol_settings_state' ) ){
	function widgetcontrol_settings_state(){
	    global $widget_control;
		//avoid issue after update
        if( !isset( $widget_control['state'] ) ){
            $widget_control['state'] = '';
        }
		?>
	    <li class="widgetcontrol-module-card widgetcontrol-module-card-no-settings no-settings <?php echo ( $widget_control['state'] == 'activate' ) ? 'widgetcontrol-module-type-enabled' : 'widgetcontrol-module-type-disabled'; ?>" id="widgetcontrol-module-card-state" data-module-id="state">
			<div class="widgetcontrol-module-card-content">
				<h2><?php _e( 'User Login State', 'advanced-widget-control' );?></h2>
				<p class="widgetcontrol-module-desc">
					<?php _e( 'Show widgets only for logged-in or logged-out users easily instead of display logic feature.', 'advanced-widget-control' );?>
				</p>

				<div class="widgetcontrol-module-actions hide-if-no-js">
	                <?php if( $widget_control['state'] == 'activate' ){ ?>
						<button class="button button-secondary widgetcontrol-toggle-settings"><?php _e( 'Learn More', 'advanced-widget-control' );?></button>
						<button class="button button-secondary widgetcontrol-toggle-activation"><?php _e( 'Disable', 'advanced-widget-control' );?></button>
					<?php } else { ?>
						<button class="button button-secondary widgetcontrol-toggle-settings"><?php _e( 'Learn More', 'advanced-widget-control' );?></button>
						<button class="button button-primary widgetcontrol-toggle-activation"><?php _e( 'Enable', 'advanced-widget-control' );?></button>
					<?php } ?>

				</div>
			</div>

			<?php widgetcontrol_modal_start( $widget_control['state'] ); ?>
				<span class="dashicons widgetcontrol-dashicons widgetcontrol-no-top dashicons-admin-users"></span>
				<h3 class="widgetcontrol-modal-header"><?php _e( 'Logged-in or Logged-out Users Restriction', 'advanced-widget-control' );?></h3>
				<p>
					<?php _e( 'This feature will give you easier option to show specific widgets only for logged-in or logged-out users rather than using the Display Logic feature.', 'advanced-widget-control' );?>
				</p>
				<p class="widgetcontrol-settings-section">
					<?php _e( 'No additional settings available.', 'advanced-widget-control' );?>
				</p>
			<?php widgetcontrol_modal_end( $widget_control['state'] ); ?>

		</li>
	    <?php
	}
	add_action( 'widgetcontrol_module_cards', 'widgetcontrol_settings_state', 59 );
}
?>
