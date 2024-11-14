<?php
/**
 * Add Advanced Widget Control
 *
 * Process Managing of Advanced Widget Control.
 *
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
        global $widget_options;
        if( isset( $widget_options['search'] ) && 'activate' == $widget_options['search'] ): ?>
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
    global $widget_options, $wp_registered_widget_controls;
    $width          = ( isset( $wp_registered_widget_controls[$widget->id]['width'] ) ) ? (int) $wp_registered_widget_controls[ $widget->id]['width' ]  : 250;
    $opts           = ( isset( $instance[ 'extended_widget_opts-'. $widget->id ] ) )    ? $instance[ 'extended_widget_opts-'. $widget->id ]             : array();

    if( isset( $widget->id ) && 'temp' == $widget->id ){
        $namespace  = 'widgets['. $widget->number .']';
        $optsname   = 'widgets['. $widget->number .'][extended_widget_opts_name]';
        $opts       = ( isset( $instance[ 'extended_widget_opts' ] ) ) ? $instance[ 'extended_widget_opts'] : array();
        $widget->id = $widget->number;

    } else {
        $namespace = 'extended_widget_opts-'. $widget->id;
        $optsname  = 'extended_widget_opts_name';
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

    <input type="hidden" name="extended_widget_opts_name" value="extended_widget_opts-<?php echo $widget->id;?>">
    <input type="hidden" name="<?php echo $args['namespace'];?>[extended_widget_opts][id_base]" value="<?php echo $widget->id;?>" />
    <div class="extended-widget-opts-form <?php if( $width > 480 ){ echo 'extended-widget-opts-form-large'; }else if( $width <= 480 ){ echo 'extended-widget-opts-form-small'; }?>">
        <div class="extended-widget-opts-tabs">
            <ul class="extended-widget-opts-tabnav-ul">
                <?php do_action( 'extended_widget_opts_tabs', $args );?>
                <div class="extended-widget-opts-clearfix"></div>
            </ul>

            <?php do_action( 'extended_widget_opts_tabcontent', $args );?>
            <input type="hidden" id="extended-widget-opts-selectedtab" value="<?php echo $selected;?>" name="extended_widget_opts-<?php echo $args['id'];?>[extended_widget_opts][tabselect]" />
            <div class="extended-widget-opts-clearfix"></div>
        </div><!--  end .extended-widget-opts-tabs -->
    </div><!-- end .extended-widget-opts-form -->

    <?php
 }
 add_action( 'in_widget_form', 'widgetcontrol_in_widget_form', 10, 3 );

/*
 * Update Options
 */
function widgetcontrol_ajax_update_callback( $instance, $new_instance, $this_widget){
    global $widget_options;

    if( isset($_POST['extended_widget_opts_name']) ) {
        $name 		= strip_tags( $_POST['extended_widget_opts_name'] );
        $options 	= $_POST[ $name ];
        if( isset( $options['extended_widget_opts'] ) ){

            if( isset( $options['extended_widget_opts']['class']['link'] ) && !empty( $options['extended_widget_opts']['class']['link'] ) ){
                $options['extended_widget_opts']['class']['link'] = widgetcontrol_addhttp( $options['extended_widget_opts']['class']['link'] );
            }
            $instance[ $name ] = widgetcontrol_sanitize_array( $options['extended_widget_opts'] );

        }
    }
    return $instance;
}
add_filter( 'widget_update_callback', 'widgetcontrol_ajax_update_callback', 10, 3);

?>
