<?php
/**
 * Widget Title Settings Module
 * Settings > Advanced Widget Control :: Hide Title
 *
 * @since       1.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Create Card Module for Hide Widget Title
 *
 * @since 1.0
 * @global $widget_options
 * @return void
 */
 
/*
 * Note: Please add a class "no-settings" in the <li> card if the card has no additional configuration, if there are configuration please remove the class
 */
 
if( !function_exists( 'widgetcontrol_settings_title' ) ):
	function widgetcontrol_settings_title(){
	    global $widget_options; ?>
	    <li class="widgetcontrol-module-card widgetcontrol-module-card-no-settings no-settings <?php echo ( $widget_options['hide_title'] == 'activate' ) ? 'widgetcontrol-module-type-enabled' : 'widgetcontrol-module-type-disabled'; ?>" id="widgetcontrol-module-card-hide_title" data-module-id="hide_title">
			<div class="widgetcontrol-module-card-content">
				<h2><?php _e( 'Hide Title', 'advanced-widget-control' );?></h2>
				<p class="widgetcontrol-module-desc">
					<?php _e( 'Allows you to hide widget title on the front-end but keep them on the backend.', 'advanced-widget-control' );?>
				</p>

				<div class="widgetcontrol-module-actions hide-if-no-js">
	                <?php if( $widget_options['hide_title'] == 'activate' ){ ?>
						<button class="button button-secondary widgetcontrol-toggle-settings"><?php _e( 'Learn More', 'advanced-widget-control' );?></button>
						<button class="button button-secondary widgetcontrol-toggle-activation"><?php _e( 'Disable', 'advanced-widget-control' );?></button>
					<?php } else { ?>
						<button class="button button-secondary widgetcontrol-toggle-settings"><?php _e( 'Learn More', 'advanced-widget-control' );?></button>
						<button class="button button-primary widgetcontrol-toggle-activation"><?php _e( 'Enable', 'advanced-widget-control' );?></button>
					<?php } ?>

				</div>
			</div>

			<?php widgetcontrol_modal_start( $widget_options['hide_title'] ); ?>
				<span class="dashicons widgetcontrol-dashicons widgetcontrol-no-top dashicons-admin-generic"></span>
				<h3 class="widgetcontrol-modal-header"><?php _e( 'Hide Title', 'advanced-widget-control' );?></h3>
				<p>
					<?php _e( 'Easily hide each widget title via checkbox. No need for PHP snippet to hide them per widgets.', 'advanced-widget-control' );?>
				</p>
				<p class="widgetcontrol-settings-section">
					<?php _e( 'No additional settings available.', 'advanced-widget-control' );?>
				</p>
			<?php widgetcontrol_modal_end( $widget_options['hide_title'] ); ?>

		</li>
	    <?php
	}
	add_action( 'widgetcontrol_module_cards', 'widgetcontrol_settings_title', 40 );
endif;
?>
