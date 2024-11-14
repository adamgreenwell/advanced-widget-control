<?php
/**
 * Devices Settings Module
 * Settings > Advanced Widget Control :: Devices Restriction
 *
 * @since       1.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Create Card Module for Devices Visibility Options
 *
 * @since 1.0
 * @global $widget_options
 * @return void
 */
 
 /*
 * Note: Please add a class "no-settings" in the <li> card if the card has no additional configuration, if there are configuration please remove the class
 */
 
if( !function_exists( 'widgetcontrol_settings_devices' ) ):
	function widgetcontrol_settings_devices(){
	    global $widget_options; ?>
		<li class="widgetcontrol-module-card widgetcontrol-module-card-no-settings no-settings <?php echo ( $widget_options['devices'] == 'activate' ) ? 'widgetcontrol-module-type-enabled' : 'widgetcontrol-module-type-disabled'; ?>" id="widgetcontrol-module-card-devices" data-module-id="devices">
			<div class="widgetcontrol-module-card-content">
				<h2><?php _e( 'Devices Restriction', 'advanced-widget-control' );?></h2>
				<p class="widgetcontrol-module-desc">
					<?php _e( 'Show or hide specific WordPress widgets on desktop, tablet and/or mobile screen sizes.', 'advanced-widget-control' );?>
				</p>

				<div class="widgetcontrol-module-actions hide-if-no-js">
					<?php if( $widget_options['devices'] == 'activate' ){ ?>
						<button class="button button-secondary widgetcontrol-toggle-settings"><?php _e( 'Learn More', 'advanced-widget-control' );?></button>
						<button class="button button-secondary widgetcontrol-toggle-activation"><?php _e( 'Disable', 'advanced-widget-control' );?></button>
					<?php } else { ?>
						<button class="button button-secondary widgetcontrol-toggle-settings"><?php _e( 'Learn More', 'advanced-widget-control' );?></button>
						<button class="button button-primary widgetcontrol-toggle-activation"><?php _e( 'Enable', 'advanced-widget-control' );?></button>
					<?php } ?>

				</div>
			</div>

			<?php widgetcontrol_modal_start( $widget_options['devices'] ); ?>
				<span class="dashicons widgetcontrol-dashicons widgetcontrol-no-top dashicons-smartphone"></span>
				<h3 class="widgetcontrol-modal-header"><?php _e( 'Devices Restriction', 'advanced-widget-control' );?></h3>
				<p>
					<?php _e( 'This feature will allow you to display different sidebar widgets for each devices. You can restrict visibility on desktop, tablet and/or mobile device screen sizes at ease via checkboxes.', 'advanced-widget-control' );?>
				</p>
				<p class="widgetcontrol-settings-section">
					<?php _e( 'No additional settings available.', 'advanced-widget-control' );?>
				</p>
			<?php widgetcontrol_modal_end( $widget_options['devices'] ); ?>

		</li>
	    <?php
	}
	add_action( 'widgetcontrol_module_cards', 'widgetcontrol_settings_devices', 20 );
endif;
?>
