<?php
/**
 * Widget Classes Settings Module
 * Settings > Advanced Widget Control :: Classes & ID
 *
 * @since       1.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Create Card Module for Widget Classes Options
 *
 * @since 1.0
 * @global $widget_control
 * @return void
 *
 */
if( !function_exists( 'widgetcontrol_settings_classes' ) ):
	function widgetcontrol_settings_classes(){
		global $widget_control;
		$classes	= ( isset( $widget_control['settings']['classes'] ) ) ? $widget_control['settings']['classes'] : array();
		$classlists = ( isset( $classes['classlists'] ) && is_array( $classes['classlists'] ) ) ? $classes['classlists'] : array();?>
	    <li class="widgetcontrol-module-card <?php echo ( $widget_control['classes'] == 'activate' ) ? 'widgetcontrol-module-type-enabled' : 'widgetcontrol-module-type-disabled'; ?>" id="widgetcontrol-module-card-classes" data-module-id="classes">
			<div class="widgetcontrol-module-card-content">
				<h2><?php _e( 'Classes & ID', 'advanced-widget-control' );?></h2>
				<p class="widgetcontrol-module-desc">
					<?php _e( 'Assign custom css classes and ID on each widgets for element targeting.', 'advanced-widget-control' );?>
				</p>

				<div class="widgetcontrol-module-actions hide-if-no-js">
	                <?php if( $widget_control['classes'] == 'activate' ){ ?>
						<button class="button button-secondary widgetcontrol-toggle-settings"><?php _e( 'Configure Settings', 'advanced-widget-control' );?></button>
						<button class="button button-secondary widgetcontrol-toggle-activation"><?php _e( 'Disable', 'advanced-widget-control' );?></button>
					<?php } else { ?>
						<button class="button button-secondary widgetcontrol-toggle-settings"><?php _e( 'Learn More', 'advanced-widget-control' );?></button>
						<button class="button button-primary widgetcontrol-toggle-activation"><?php _e( 'Enable', 'advanced-widget-control' );?></button>
					<?php } ?>

				</div>

			</div>

			<?php widgetcontrol_modal_start( $widget_control['classes'] ); ?>
				<span class="dashicons widgetcontrol-dashicons widgetcontrol-no-top dashicons-admin-generic"></span>
				<h3 class="widgetcontrol-modal-header"><?php _e( 'Classes & ID', 'advanced-widget-control' );?></h3>
				<p>
					<?php _e( 'Custom alignment widget options will allow you to assign different content alignments for each widgets on specific devices. You can choose whether you want them to be left, right, justify or centered aligned on desktop, tablet or mobile devices.', 'advanced-widget-control' );?>
				</p>
				<table class="form-table widgetcontrol-settings-section">
					<tr>
						<th scope="row">
							<label for="widgetcontrol-classes-id"><?php _e( 'Show ID Field', 'advanced-widget-control' );?></label>
						</th>
						<td>
							<input type="checkbox" id="widgetcontrol-classes-id" name="classes[id]" <?php echo widgetcontrol_is_checked( $classes, 'id' ) ?> value="1" />
							<label for="widgetcontrol-classes-id"><?php _e( 'Enable ID Field', 'advanced-widget-control' );?></label>
							<p class="description">
								<?php _e( 'Allow user to add custom ID on each widgets. ', 'advanced-widget-control' );?>
							</p>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label><?php _e( 'Classes Field Type', 'advanced-widget-control' );?></label>
						</th>
						<td>
							<label for="widgetcontrol-classes-class-text">
								<input type="radio" value="text" id="widgetcontrol-classes-class-text" name="classes[type]" <?php if( isset( $classes['type'] ) && 'text' == $classes['type'] ){ echo 'checked="checked"'; }?> /><?php _e( 'Text Field', 'advanced-widget-control' );?>
							</label>&nbsp;&nbsp;

							<label for="widgetcontrol-classes-class-predefined">
								<input type="radio" value="predefined" id="widgetcontrol-classes-class-predefined" name="classes[type]" <?php if( isset( $classes['type'] ) && 'predefined' == $classes['type'] ){ echo 'checked="checked"'; }?> /><?php _e( 'Predefined Class Checkboxes', 'advanced-widget-control' );?>
							</label>&nbsp;&nbsp;

							<label for="widgetcontrol-classes-class-both">
								<input type="radio" value="both" id="widgetcontrol-classes-class-both" name="classes[type]" <?php if( isset( $classes['type'] ) && 'both' == $classes['type'] ){ echo 'checked="checked"'; }?> /><?php _e( 'Both', 'advanced-widget-control' );?>
							</label>&nbsp;&nbsp;

							<label for="widgetcontrol-classes-class-hide">
								<input type="radio" value="hide" id="widgetcontrol-classes-class-hide" name="classes[type]" <?php if( isset( $classes['type'] ) && 'hide' == $classes['type'] ){ echo 'checked="checked"'; }?> /><?php _e( 'Hide', 'advanced-widget-control' );?>
							</label>
							<p class="description">
								<?php _e( 'Select which field type you want to manage each widget classes option.', 'advanced-widget-control' );?>
							</p>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="widgetcontrol-classes-auto"><?php _e( 'Remove .widget Class', 'advanced-widget-control' );?></label>
						</th>
						<td>
							<input type="checkbox" id="widgetcontrol-classes-auto" name="classes[auto]" <?php echo widgetcontrol_is_checked( $classes, 'auto' ) ?> value="1" />
							<label for="widgetcontrol-classes-auto"><?php _e( 'Disable Additional Class', 'advanced-widget-control' );?></label>
							<p class="description">
								<?php _e( 'Check this box if you want to disable the automatic addition of .widget class', 'advanced-widget-control' );?>
							</p>
						</td>
					</tr>
				</table>
				<div class="widgetcontrol-settings-section">
					<h4><?php _e( 'Predefined Classes', 'advanced-widget-control' );?></h4>
					<p><?php _e( 'Set a class lists that you want to be available as pre-choices on the Class/ID Advanced Widget Control tab.', 'advanced-widget-control' );?></p>

					<div id="opts-predefined-classes">
						<ul>
							<li class="opts-hidden-placeholder"></li>
							<?php
								if( !empty( $classlists ) && is_array( $classlists ) ){
									$classlists = array_unique( $classlists );
									foreach ($classlists as $key => $value) {
										echo '<li><input type="hidden" name="classes[classlists][]" value="'. $value .'" /><span class"opts-li-value">'. $value .'</span> <a href="#" class="opts-remove-class-btn"><span class="dashicons dashicons-dismiss"></span></a></li>';
									}
								}
							?>
						</ul>
					</div>

					<table class="form-table">
						<tbody>
							<tr valign="top">
								<td scope="row" valign="middle">
									<input type="text" class="regular-text code opts-add-class-txtfld" />
									<a href="#" class="opts-add-class-btn widgetcontrol-add-class-btn"><span class="dashicons dashicons-plus-alt"></span></a><br />
									<small><em><?php _e( 'Note: Click the Plus icon to add the class.', 'advanced-widget-control' );?></em></small>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			<?php widgetcontrol_modal_end( $widget_control['classes'] ); ?>

		</li>
	    <?php
	}
	add_action( 'widgetcontrol_module_cards', 'widgetcontrol_settings_classes', 50 );
endif;
?>
