<?php
/**
 * Visibility Settings Module
 * Settings > Advanced Widget Control :: Pages Visibility
 *
 * @since       1.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Create Card Module for Pages Visibility Options
 *
 * @since 1.0
 * @global $widget_control
 * @return void
 */
if( !function_exists( 'widgetcontrol_settings_visibility' ) ):
	function widgetcontrol_settings_visibility(){
	    global $widget_control; ?>
	    <li class="widgetcontrol-module-card <?php echo ( $widget_control['visibility'] == 'activate' ) ? 'widgetcontrol-module-type-enabled' : 'widgetcontrol-module-type-disabled'; ?>" id="widgetcontrol-module-card-visibility" data-module-id="visibility">
			<div class="widgetcontrol-module-card-content">
				<h2><?php _e( 'Pages Visibility', 'advanced-widget-control' );?></h2>
				<p class="widgetcontrol-module-desc">
					<?php _e( 'Easily restrict any widgets visibility on specific WordPress pages.', 'advanced-widget-control' );?>
				</p>
				<div class="widgetcontrol-module-actions hide-if-no-js">
					<?php if( $widget_control['visibility'] == 'activate' ){ ?>
						<button class="button button-secondary widgetcontrol-toggle-settings"><?php _e( 'Configure Settings', 'advanced-widget-control' );?></button>
						<button class="button button-secondary widgetcontrol-toggle-activation"><?php _e( 'Disable', 'advanced-widget-control' );?></button>
					<?php } else { ?>
						<button class="button button-secondary widgetcontrol-toggle-settings"><?php _e( 'Learn More', 'advanced-widget-control' );?></button>
						<button class="button button-primary widgetcontrol-toggle-activation"><?php _e( 'Enable', 'advanced-widget-control' );?></button>
					<?php } ?>

				</div>
			</div>

			<?php widgetcontrol_modal_start( $widget_control['visibility'] ); ?>
				<span class="dashicons widgetcontrol-dashicons dashicons-visibility"></span>
				<h3 class="widgetcontrol-modal-header"><?php _e( 'Pages Visibility', 'advanced-widget-control' );?></h3>
				<p>
					<?php _e( 'Visibility tab allows you to completely control each widgets visibility and restrict them on any WordPress pages. You can turn on/off the underlying tabs for post types, taxonomies and miscellanous options using the options below when this feature is enabled.', 'advanced-widget-control' );?>
				</p>
				<table class="form-table widgetcontrol-settings-section">
					<tr>
						<th scope="row">
							<label for="widgetcontrol-visibility-post_types"><?php _e( 'Post Types Tab', 'advanced-widget-control' );?></label>
						</th>
						<td>
							<input type="checkbox" id="widgetcontrol-visibility-post_types" name="visibility[post_type]" <?php echo ( isset( $widget_control['settings']['visibility'] ) ) ? widgetcontrol_is_checked( $widget_control['settings']['visibility'], 'post_type' ) : ''; ?> value="1" />
							<label for="widgetcontrol-visibility-post_types"><?php _e( 'Enable Post Types Restriction', 'advanced-widget-control' );?></label>
							<p class="description">
								<?php _e( 'This feature will allow visibility restriction of every widgets per post types and per pages.', 'advanced-widget-control' );?>
							</p>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="widgetcontrol-visibility-taxonomies"><?php _e( 'Taxonomies Tab', 'advanced-widget-control' );?></label>
						</th>
						<td>
							<input type="checkbox" id="widgetcontrol-visibility-taxonomies" name="visibility[taxonomies]" <?php echo ( isset( $widget_control['settings']['visibility'] ) ) ? widgetcontrol_is_checked( $widget_control['settings']['visibility'], 'taxonomies' ) : ''; ?> value="1" />
							<label for="widgetcontrol-visibility-taxonomies"><?php _e( 'Enable Taxonomies Restriction', 'advanced-widget-control' );?></label>
							<p class="description">
								<?php _e( 'This tab option will allow you to control visibility via taxonomy and terms archive pages.', 'advanced-widget-control' );?>
							</p>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="widgetcontrol-visibility-misc"><?php _e( 'Miscellaneous Tab', 'advanced-widget-control' );?></label>
						</th>
						<td>
							<input type="checkbox" id="widgetcontrol-visibility-misc" name="visibility[misc]" <?php echo ( isset( $widget_control['settings']['visibility'] ) ) ? widgetcontrol_is_checked( $widget_control['settings']['visibility'], 'misc' ) : ''; ?> value="1" />
							<label for="widgetcontrol-visibility-misc"><?php _e( 'Enable Miscellaneous Options', 'advanced-widget-control' );?></label>
							<p class="description">
								<?php _e( 'Restrict widgets visibility on WordPress miscellanous pages such as home page, blog page, 404, search, etc.', 'advanced-widget-control' );?>
							</p>
						</td>
					</tr>
				</table>
			<?php widgetcontrol_modal_end( $widget_control['visibility'] ); ?>
		</li>
	    <?php
	}
	add_action( 'widgetcontrol_module_cards', 'widgetcontrol_settings_visibility', 10 );
endif;
?>
