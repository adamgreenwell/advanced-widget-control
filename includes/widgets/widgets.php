<?php
/**
 * Add Advanced Widget Control
 * Process Managing of Advanced Widget Control.
 * File: includes/widgets/widgets.php
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Output widget search filter textfield before widget lists
 *
 * @since  1.0
 */
if( !function_exists( 'widgetcontrol_add_search_input' ) ):
    function widgetcontrol_add_search_input() {
        global $widget_control;
        if( isset( $widget_control['search'] ) && 'activate' == $widget_control['search'] ): ?>
            <div id="widgetcontrol-widgets-filter">
            	<label class="screen-reader-text" for="widgetcontrol-widgets-search"><?php _e( 'Search Widgets', 'advanced-widget-control' ); ?></label>
            	<input type="text" id="widgetcontrol-widgets-search" class="widgetcontrol-widgets-search" placeholder="<?php esc_attr_e( 'Search widgets&hellip;', 'advanced-widget-control' ) ?>" />
                <div class="widgetcontrol-search-icon" aria-hidden="true"></div>
                <button type="button" class="widgetcontrol-clear-results"><span class="screen-reader-text"><?php _e( 'Clear Results', 'advanced-widget-control' ); ?></span></button>
                <p class="screen-reader-text" id="widgetcontrol-search-desc"><?php _e( 'The search results will be updated as you type.', 'advanced-widget-control' ); ?></p>
            </div>
        <?php 
        endif;
    }
    add_action( 'widgets_admin_page', 'widgetcontrol_add_search_input' );
endif;

/**
 * Add Options on in_widget_form action
 *
 * @since 1.0
 * @return void
 */

function widgetcontrol_in_widget_form( $widget, $return, $instance ){
    global $widget_control, $wp_registered_widget_controls;
    $width          = ( isset( $wp_registered_widget_controls[$widget->id]['width'] ) ) ? (int) $wp_registered_widget_controls[ $widget->id]['width' ]  : 250;
    $opts           = ( isset( $instance[ 'advanced_widget_control-'. $widget->id ] ) )    ? $instance[ 'advanced_widget_control-'. $widget->id ]             : array();

    if( isset( $widget->id ) && 'temp' == $widget->id ){
        $namespace  = 'widgets['. $widget->number .']';
        $optsname   = 'widgets['. $widget->number .'][advanced_widget_control_name]';
        $opts       = ( isset( $instance[ 'advanced_widget_control' ] ) ) ? $instance[ 'advanced_widget_control'] : array();
        $widget->id = $widget->number;

    } else {
        $namespace = 'advanced_widget_control-'. $widget->id;
        $optsname  = 'advanced_widget_control_name';
    }

    $args = array(
                'width'     =>  $width,
                'id'        =>  $widget->id,
                'params'    =>  $opts,
                'namespace' =>  $namespace
            );
    $selected = 0;
    if( isset( $opts['tabselect'] ) ){
        $selected = $opts['tabselect'];
    }

    ?>

    <input type="hidden" name="advanced_widget_control_name" value="advanced_widget_control-<?php echo $widget->id;?>">
    <input type="hidden" name="<?php echo $args['namespace'];?>[advanced_widget_control][id_base]" value="<?php echo $widget->id;?>" />
    <div class="advanced-widget-control-form <?php if( $width > 480 ){ echo 'advanced-widget-control-form-large'; }else if( $width <= 480 ){ echo 'advanced-widget-control-form-small'; }?>">
        <div class="advanced-widget-control-tabs">
            <ul class="advanced-widget-control-tabnav-ul">
                <?php do_action( 'advanced_widget_control_tabs', $args );?>
                <div class="advanced-widget-control-clearfix"></div>
            </ul>

            <?php do_action( 'advanced_widget_control_tabcontent', $args );?>
            <input type="hidden" id="advanced-widget-control-selectedtab" value="<?php echo $selected;?>" name="advanced_widget_control-<?php echo $args['id'];?>[advanced_widget_control][tabselect]" />
            <div class="advanced-widget-control-clearfix"></div>
        </div><!--  end .advanced-widget-control-tabs -->
    </div><!-- end .advanced-widget-control-form -->

    <?php
 }
 add_action( 'in_widget_form', 'widgetcontrol_in_widget_form', 10, 3 );

/*
 * Update Options
 */
function widgetcontrol_ajax_update_callback( $instance, $new_instance, $this_widget){
    global $widget_control;

    if( isset($_POST['advanced_widget_control_name']) ) {
        $name 		= strip_tags( $_POST['advanced_widget_control_name'] );
        $options 	= $_POST[ $name ];
        if( isset( $options['advanced_widget_control'] ) ){

            if( isset( $options['advanced_widget_control']['class']['link'] ) && !empty( $options['advanced_widget_control']['class']['link'] ) ){
                $options['advanced_widget_control']['class']['link'] = widgetcontrol_addhttp( $options['advanced_widget_control']['class']['link'] );
            }
            $instance[ $name ] = widgetcontrol_sanitize_array( $options['advanced_widget_control'] );

        }
    }
    return $instance;
}
add_filter( 'widget_update_callback', 'widgetcontrol_ajax_update_callback', 10, 3);

?>
