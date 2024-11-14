<?php
/**
 * Import & Export Settings Module
 * Settings > Advanced Widget Control :: Import & Export
 *
 * @since       1.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Create Card Module for Import & Export
 *
 * @since 1.0
 * @global $widget_control
 * @return void
 */
 
 /*
 * Note: Please add a class "no-settings" in the <li> card if the card has no additional configuration, if there are configuration please remove the class
 */

function widgetcontrol_settings_import_export(){
    global $widget_control; 
    //avoid issue after update
    if( !isset( $widget_control['import_export'] ) ){
        $widget_control['import_export'] = '';
    }
    ?>
    <li class="widgetcontrol-module-card widgetcontrol-module-card-no-settings no-settings <?php echo ( $widget_control['import_export'] == 'activate' ) ? 'widgetcontrol-module-type-enabled' : 'widgetcontrol-module-type-disabled'; ?>" id="widgetcontrol-module-card-import_export" data-module-id="import_export">
		<div class="widgetcontrol-module-card-content">
			<h2><?php _e( 'Import & Export Widgets', 'advanced-widget-control' );?></h2>
			<p class="widgetcontrol-module-desc">
				<?php _e( 'Import or Export all your widgets with associated sidebar widget area easily.', 'advanced-widget-control' );?>
			</p>

			<div class="widgetcontrol-module-actions hide-if-no-js">
                <?php if( $widget_control['import_export'] == 'activate' ){ ?>
					<button class="button button-secondary widgetcontrol-toggle-settings"><?php _e( 'Learn More', 'advanced-widget-control' );?></button>
					<button class="button button-secondary widgetcontrol-toggle-activation"><?php _e( 'Disable', 'advanced-widget-control' );?></button>
				<?php } else { ?>
					<button class="button button-secondary widgetcontrol-toggle-settings"><?php _e( 'Learn More', 'advanced-widget-control' );?></button>
					<button class="button button-primary widgetcontrol-toggle-activation"><?php _e( 'Enable', 'advanced-widget-control' );?></button>
				<?php } ?>

			</div>

		</div>

		<?php widgetcontrol_modal_start( $widget_control['import_export'] ); ?>
			<span class="dashicons widgetcontrol-dashicons widgetcontrol-no-top dashicons-download"></span>
			<h3 class="widgetcontrol-modal-header"><?php _e( 'Import & Export Widgets', 'advanced-widget-control' );?></h3>
			<p>
				<?php _e( 'Enabling this feature will give you additional menu under <a href="'. esc_url( admin_url( 'tools.php?page=widgetcontrol_migrator_settings' ) ) .'"><strong>Tools > Import/Export Widgets</strong></a>. This will give you the easiest option to export and import your widgets. Creating backup and restore of your widgets can be done really simple!', 'advanced-widget-control' );?>
			</p>
			<p class="widgetcontrol-settings-section">
				<?php _e( 'No additional settings available.', 'advanced-widget-control' );?>
			</p>
		<?php widgetcontrol_modal_end( $widget_control['import_export'] ); ?>

	</li>
    <?php
}
add_action( 'widgetcontrol_module_cards', 'widgetcontrol_settings_import_export', 64 );
?>
