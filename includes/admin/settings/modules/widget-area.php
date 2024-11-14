<?php
/**
 * Widget Area Options Settings Module
 * Settings > Advanced Widget Control :: Widget Area Options
 *
 * @since       1.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Create Card Module for Widget Area Options
 *
 * @since 1.0
 * @global $widget_options
 * @return void
 */
if( !function_exists( 'widgetcontrol_settings_widget_area' ) ):
	function widgetcontrol_settings_widget_area(){
	    global $widget_options;
	    //avoid issue after update
	    if( !isset( $widget_options['widget_area'] ) ){
	        $widget_options['widget_area'] = '';
	    }

		$widget_area = ( isset( $widget_options['settings']['widget_area'] ) ) ? $widget_options['settings']['widget_area'] : array();?>
	    <li class="widgetcontrol-module-card <?php echo ( $widget_options['widget_area'] == 'activate' ) ? 'widgetcontrol-module-type-enabled' : 'widgetcontrol-module-type-disabled'; ?>" id="widgetcontrol-module-card-widget_area" data-module-id="widget_area">
			<div class="widgetcontrol-module-card-content">
				<h2><?php _e( 'Widget Area Options', 'advanced-widget-control' );?></h2>
				<p class="widgetcontrol-module-desc">
					<?php _e( 'Extra helpful management options below each sidebar widget areas.', 'advanced-widget-control' );?>
				</p>

				<div class="widgetcontrol-module-actions hide-if-no-js">
					<?php if( $widget_options['widget_area'] == 'activate' ){ ?>
						<button class="button button-secondary widgetcontrol-toggle-settings"><?php _e( 'Configure Settings', 'advanced-widget-control' );?></button>
						<button class="button button-secondary widgetcontrol-toggle-activation"><?php _e( 'Disable', 'advanced-widget-control' );?></button>
					<?php } else { ?>
						<button class="button button-secondary widgetcontrol-toggle-settings"><?php _e( 'Learn More', 'advanced-widget-control' );?></button>
						<button class="button button-primary widgetcontrol-toggle-activation"><?php _e( 'Enable', 'advanced-widget-control' );?></button>
					<?php } ?>

				</div>
			</div>

			<?php widgetcontrol_modal_start( $widget_options['widget_area'] ); ?>
				<span class="dashicons widgetcontrol-dashicons widgetcontrol-no-top dashicons-art"></span>
				<h3 class="widgetcontrol-modal-header"><?php _e( 'Widget Area Options', 'advanced-widget-control' );?></h3>
				<p>
					<?php _e( 'Enable <strong>Remove All Widgets</strong> and/or <strong>Download Backup</strong> link options below each sidebar widget areas. This will help you manage your widgets better as always.', 'advanced-widget-control' );?>
				</p>

				<table class="form-table widgetcontrol-settings-section">
					<tr>
						<th scope="row">
							<label for="widgetcontrol-widget-area-remove"><?php _e( 'Remove Widgets Link', 'advanced-widget-control' );?></label>
						</th>
						<td>
							<input type="checkbox" id="widgetcontrol-widget-area-remove" name="widget_area[remove]" <?php echo widgetcontrol_is_checked( $widget_area, 'remove' ) ?> value="1" />
							<label for="widgetcontrol-widget-area-remove"><?php _e( 'Remove Widgets Link', 'advanced-widget-control' );?></label>
							<p class="description">
								<?php _e( 'Show "Remove All Widgets" link below each widget areas.', 'advanced-widget-control' );?>
							</p>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="widgetcontrol-widget-area-backup"><?php _e( 'Download Backup', 'advanced-widget-control' );?></label>
						</th>
						<td>
							<input type="checkbox" id="widgetcontrol-widget-area-backup" name="widget_area[backup]" <?php echo widgetcontrol_is_checked( $widget_area, 'backup' ) ?> value="1" />
							<label for="widgetcontrol-widget-area-backup"><?php _e( 'Enable Download Backup', 'advanced-widget-control' );?></label>
							<p class="description">
								<?php _e( 'Show "Download Backup" link below each sidebar widget area.', 'advanced-widget-control' );?>
							</p>
						</td>
					</tr>
				</table>
			<?php widgetcontrol_modal_end( $widget_options['widget_area'] ); ?>

		</li>
	    <?php
	}
	add_action( 'widgetcontrol_module_cards', 'widgetcontrol_settings_widget_area', 64 );
endif;
?>
