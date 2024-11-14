<?php
/**
 * Roles Advanced Widget Control
 *
 * @since       1.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Add Roles Advanced Widget Control Tab
 *
 * @since 1.0
 * @return void
 */

 /**
 * Called on 'advanced_widget_control_tabs'
 * create new tab navigation for alignment options
 */
function widgetcontrol_tab_state( $args ){ ?>
    <li class="advanced-widget-control-tab-roles">
        <a href="#advanced-widget-control-tab-<?php echo $args['id'];?>-roles" title="<?php _e( 'Roles', 'advanced-widget-control' );?>" ><span class="dashicons dashicons-admin-users"></span> <span class="tabtitle"><?php _e( 'Roles', 'advanced-widget-control' );?></span></a>
    </li>
<?php
}
add_action( 'advanced_widget_control_tabs', 'widgetcontrol_tab_state' );

/**
 * Called on 'advanced_widget_control_tabcontent'
 * create new tab content options for alignment options
 */
function widgetcontrol_tabcontent_state( $args ){
    $roles          = get_editable_roles();
    $state   = '';
    if( isset( $args['params']['roles'][ 'state' ] ) ){
        $state = $args['params']['roles'][ 'state' ];
    }
    ?>
    <div id="advanced-widget-control-tab-<?php echo $args['id'];?>-roles" class="advanced-widget-control-tabcontent advanced-widget-control-tabcontent-roles">
        <p class="widgetcontrol-subtitle"><?php _e( 'User Login State', 'advanced-widget-control' );?></p>
        <p>
            <select class="widefat" name="<?php echo $args['namespace'];?>[advanced_widget_control][roles][state]">
                <option value=""><?php _e( 'Select Visibility Option', 'advanced-widget-control' );?></option>
                <option value="in" <?php if( $state == 'in' ){ echo 'selected="selected"'; }?> ><?php _e( 'Show only for Logged-in Users', 'advanced-widget-control' );?></option>
                <option value="out" <?php if( $state == 'out' ){ echo 'selected="selected"'; }?>><?php _e( 'Show only for Logged-out Users', 'advanced-widget-control' );?></option>
            </select>
        </p>
        <p><small><?php _e( 'Restrict widget visibility for logged-in and logged-out users. ', 'advanced-widget-control' );?></small></p>

    </div>
<?php
}
add_action( 'advanced_widget_control_tabcontent', 'widgetcontrol_tabcontent_state'); ?>
