<?php
/**
 * Devices Visibility Advanced Widget Control
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
 * Called on 'advanced_widget_control_tabs'
 * create new tab navigation for alignment options
 */
 function widgetcontrol_tab_devices( $args ){ ?>
         <li class="advanced-widget-control-tab-devices">
             <a href="#advanced-widget-control-tab-<?php echo $args['id'];?>-devices" title="<?php _e( 'Devices', 'advanced-widget-control' );?>" ><span class="dashicons dashicons-smartphone"></span> <span class="tabtitle"><?php _e( 'Devices', 'advanced-widget-control' );?></span></a>
         </li>
     <?php
     }
add_action( 'advanced_widget_control_tabs', 'widgetcontrol_tab_devices' );

/**
 * Called on 'advanced_widget_control_tabcontent'
 * create new tab content options for devices visibility options
 */
function widgetcontrol_tabcontent_devices( $args ){
    $desktop        = '';
    $tablet         = '';
    $mobile         = '';
    $options_role   = '';
    if( isset( $args['params'] ) && isset( $args['params']['devices'] ) ){
        if( isset( $args['params']['devices']['options'] ) ){
            $options_role = $args['params']['devices']['options'];
        }
        if( isset( $args['params']['devices']['desktop'] ) ){
            $desktop = $args['params']['devices']['desktop'];
        }
        if( isset( $args['params']['devices']['tablet'] ) ){
            $tablet = $args['params']['devices']['tablet'];
        }
        if( isset( $args['params']['devices']['mobile'] ) ){
            $mobile = $args['params']['devices']['mobile'];
        }
    }
    ?>
    <div id="advanced-widget-control-tab-<?php echo $args['id'];?>-devices" class="advanced-widget-control-tabcontent advanced-widget-control-tabcontent-devices">
        <p>
            <strong><?php _e( 'Hide or Show', 'advanced-widget-control' );?></strong>
            <select class="widefat" name="<?php echo $args['namespace'];?>[advanced_widget_control][devices][options]">
                <option value="hide" <?php if( $options_role == 'hide' ){ echo 'selected="selected"'; }?> ><?php _e( 'Hide on checked devices', 'advanced-widget-control' );?></option>
                <option value="show" <?php if( $options_role == 'show' ){ echo 'selected="selected"'; }?>><?php _e( 'Show on checked devices', 'advanced-widget-control' );?></option>
            </select>
        </p>
        <table class="form-table">
            <tbody>
                 <tr valign="top">
                    <td scope="row"><strong><?php _e( 'Devices', 'advanced-widget-control' );?></strong></td>
                    <td>&nbsp;</td>
                </tr>
                <tr valign="top">
                    <td scope="row"><span class="dashicons dashicons-desktop"></span> <label for="advanced_widget_control-<?php echo $args['id'];?>-devices-desktop"><?php _e( 'Desktop', 'advanced-widget-control' );?></label></td>
                    <td>
                        <input type="checkbox" name="<?php echo $args['namespace'];?>[advanced_widget_control][devices][desktop]" value="1" id="advanced_widget_control-<?php echo $args['id'];?>-devices-desktop" <?php  if( !empty( $desktop ) ){ echo 'checked="checked"'; }?> />
                    </td>
                </tr>
                <tr valign="top">
                    <td scope="row"><span class="dashicons dashicons-tablet"></span> <label for="advanced_widget_control-<?php echo $args['id'];?>-devices-table"><?php _e( 'Tablet', 'advanced-widget-control' );?></label></td>
                    <td>
                        <input type="checkbox" name="<?php echo $args['namespace'];?>[advanced_widget_control][devices][tablet]" value="1" id="advanced_widget_control-<?php echo $args['id'];?>-devices-table" <?php  if( !empty( $tablet ) ){ echo 'checked="checked"'; }?> />
                    </td>
                </tr>
                <tr valign="top">
                    <td scope="row"><span class="dashicons dashicons-smartphone"></span> <label for="advanced_widget_control-<?php echo $args['id'];?>-devices-mobile"><?php _e( 'Mobile', 'advanced-widget-control' );?></label></td>
                    <td>
                        <input type="checkbox" name="<?php echo $args['namespace'];?>[advanced_widget_control][devices][mobile]" value="1" id="advanced_widget_control-<?php echo $args['id'];?>-devices-mobile" <?php  if( !empty( $mobile ) ){ echo 'checked="checked"'; }?> />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
<?php
}
add_action( 'advanced_widget_control_tabcontent', 'widgetcontrol_tabcontent_devices'); ?>
