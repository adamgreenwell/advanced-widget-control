<?php
/**
 * Widget Logic Settings Module
 * Settings > Advanced Widget Control :: Display Logic
 *
 * @since       1.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Create Card Module for Display Logic Options
 *
 * @since 1.0
 * @global $widget_control
 * @return void
 */
if( !function_exists( 'widgetcontrol_settings_logic' ) ):
	function widgetcontrol_settings_logic(){
	    global $widget_control; ?>
		<li class="widgetcontrol-module-card <?php echo ( isset( $widget_control['logic'] ) && $widget_control['logic'] == 'activate' ) ? 'widgetcontrol-module-type-enabled' : 'widgetcontrol-module-type-disabled'; ?>" id="widgetcontrol-module-card-logic" data-module-id="logic">
			<div class="widgetcontrol-module-card-content">
				<h2><?php _e( 'Display Logic', 'advanced-widget-control' );?></h2>
				<p class="widgetcontrol-module-desc">
					<?php _e( 'Use WordPress PHP conditional tags to assign each widgets visibility.', 'advanced-widget-control' );?>
				</p>

				<div class="widgetcontrol-module-actions hide-if-no-js">
					<?php if( $widget_control['logic'] == 'activate' ){ ?>
						<button class="button button-secondary widgetcontrol-toggle-settings"><?php _e( 'Configure Settings', 'advanced-widget-control' );?></button>
						<button class="button button-secondary widgetcontrol-toggle-activation"><?php _e( 'Disable', 'advanced-widget-control' );?></button>
					<?php } else { ?>
						<button class="button button-secondary widgetcontrol-toggle-settings"><?php _e( 'Learn More', 'advanced-widget-control' );?></button>
						<button class="button button-primary widgetcontrol-toggle-activation"><?php _e( 'Enable', 'advanced-widget-control' );?></button>
					<?php } ?>

				</div>

			</div>

			<?php widgetcontrol_modal_start( $widget_control['logic'] ); ?>
				<span class="dashicons widgetcontrol-dashicons widgetcontrol-no-top dashicons-admin-generic"></span>
				<h3 class="widgetcontrol-modal-header"><?php _e( 'Display Logic', 'advanced-widget-control' );?></h3>
				<p>
					<?php _e( 'Display Widget Logic will let you control where you want the widgets to appear using WordPress conditional tags.', 'advanced-widget-control' );?>
				</p>
				<p>
					<?php _e( "<strong>Please note</strong> that the display logic you introduce is EVAL'd directly. Anyone who has access to edit widget appearance will have the right to add any code, including malicious and possibly destructive functions. There is an optional filter <code>widget_control_logic_override</code> which you can use to bypass the EVAL with your own code if needed.", 'advanced-widget-control' )?>
				</p>
				<table class="form-table widgetcontrol-settings-section">
					<tr>
						<th scope="row">
							<label for="widgetcontrol-logic-notice"><?php _e( 'Hide Notice', 'advanced-widget-control' );?></label>
						</th>
						<td>
							<input type="checkbox" id="widgetcontrol-logic-notice" name="logic[notice]" <?php echo ( isset( $widget_control['settings']['logic'] ) ) ? widgetcontrol_is_checked( $widget_control['settings']['logic'], 'notice' ) : ''; ?> value="1" />
							<label for="widgetcontrol-logic-notice"><?php _e( 'Disable Notice Toggler', 'advanced-widget-control' );?></label>
							<p class="description">
								<?php _e( 'Hide similar filter notice above on each widget display logic feature.', 'advanced-widget-control' );?>
							</p>
						</td>
					</tr>
				</table>
			<?php widgetcontrol_modal_end( $widget_control['logic'] ); ?>

		</li>
	    <?php
	}
	add_action( 'widgetcontrol_module_cards', 'widgetcontrol_settings_logic', 60 );
endif;
?>
