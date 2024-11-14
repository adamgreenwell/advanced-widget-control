<?php
/**
 * Alignment Advanced Widget Control
 *
 * @since       1.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Add Alignment Advanced Widget Control Tab
 *
 * @since 1.0
 * @return void
 */

 /**
 * Called on 'extended_widget_opts_tabs'
 * create new tab navigation for alignment options
 */

function widgetcontrol_tabcontent_alignment( $args ){
    $desktop = '';
    if( isset( $args['params'] ) && isset( $args['params']['alignment'] ) ){
        if( isset( $args['params']['alignment']['desktop'] ) ){
            $desktop = $args['params']['alignment']['desktop'];
        }
    }
    ?>
    <div id="extended-widget-opts-tab-<?php echo $args['id'];?>-alignment" class="extended-widget-opts-tabcontent extended-widget-opts-tabcontent-alignment">
        <table class="form-table">
            <tbody>
                <tr valign="top">
                    <td scope="row"><strong><?php _e( 'Devices', 'advanced-widget-control' );?></strong></td>
                    <td><strong><?php _e( 'Alignment', 'advanced-widget-control' );?></strong></td>
                </tr>
                <tr valign="top">
                    <td scope="row"><span class="dashicons dashicons-desktop"></span> <?php _e( 'All Devices', 'advanced-widget-control' );?></td>
                    <td>
                        <select class="widefat" name="<?php echo $args['namespace'];?>[extended_widget_opts][alignment][desktop]">
                            <option value="default"><?php _e( 'Default', 'advanced-widget-control' );?></option>
                            <option value="center" <?php if( $desktop == 'center' ){ echo 'selected="selected"'; }?> ><?php _e( 'Center', 'advanced-widget-control' );?></option>
                            <option value="left" <?php if( $desktop == 'left' ){ echo 'selected="selected"'; }?>><?php _e( 'Left', 'advanced-widget-control' );?></option>
                            <option value="right" <?php if( $desktop == 'right' ){ echo 'selected="selected"'; }?>><?php _e( 'Right', 'advanced-widget-control' );?></option>
                            <option value="justify" <?php if( $desktop == 'justify' ){ echo 'selected="selected"'; }?>><?php _e( 'Justify', 'advanced-widget-control' );?></option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
<?php
}
add_action( 'extended_widget_opts_tabcontent', 'widgetcontrol_tabcontent_alignment'); ?>
