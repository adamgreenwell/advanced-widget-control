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
 * Called on 'extended_widget_opts_tabs'
 * create new tab navigation for alignment options
 */
function widgetcontrol_tab_state( $args ){ ?>
    <li class="extended-widget-opts-tab-roles">
        <a href="#extended-widget-opts-tab-<?php echo $args['id'];?>-roles" title="<?php _e( 'Roles', 'advanced-widget-control' );?>" ><span class="dashicons dashicons-admin-users"></span> <span class="tabtitle"><?php _e( 'Roles', 'advanced-widget-control' );?></span></a>
    </li>
<?php
}
add_action( 'extended_widget_opts_tabs', 'widgetcontrol_tab_state' );

/**
 * Called on 'extended_widget_opts_tabcontent'
 * create new tab content options for alignment options
 */
function widgetcontrol_tabcontent_state( $args ){
    $roles          = get_editable_roles();
    $state   = '';
    if( isset( $args['params']['roles'][ 'state' ] ) ){
        $state = $args['params']['roles'][ 'state' ];
    }
    ?>
    <div id="extended-widget-opts-tab-<?php echo $args['id'];?>-roles" class="extended-widget-opts-tabcontent extended-widget-opts-tabcontent-roles">
        <p class="widgetcontrol-subtitle"><?php _e( 'User Login State', 'advanced-widget-control' );?></p>
        <p>
            <select class="widefat" name="<?php echo $args['namespace'];?>[extended_widget_opts][roles][state]">
                <option value=""><?php _e( 'Select Visibility Option', 'advanced-widget-control' );?></option>
                <option value="in" <?php if( $state == 'in' ){ echo 'selected="selected"'; }?> ><?php _e( 'Show only for Logged-in Users', 'advanced-widget-control' );?></option>
                <option value="out" <?php if( $state == 'out' ){ echo 'selected="selected"'; }?>><?php _e( 'Show only for Logged-out Users', 'advanced-widget-control' );?></option>
            </select>
        </p>
        <p><small><?php _e( 'Restrict widget visibility for logged-in and logged-out users. ', 'advanced-widget-control' );?></small></p>

    </div>
<?php
}
add_action( 'extended_widget_opts_tabcontent', 'widgetcontrol_tabcontent_state'); ?>
