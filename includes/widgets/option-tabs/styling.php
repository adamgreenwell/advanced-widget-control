<?php
/**
 * Styling Advanced Widget Control
 *
 * @since       1.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Add Styling Advanced Widget Control Tab
 *
 * @since 1.0
 * @return void
 */

 /**
 * Called on 'extended_widget_opts_tabs'
 * create new tab navigation for alignment options
 */
function widgetcontrol_tab_styling( $args ){ ?>
    <li class="extended-widget-opts-tab-styling">
        <a href="#extended-widget-opts-tab-<?php echo $args['id'];?>-styling" title="<?php _e( 'Styling', 'advanced-widget-control' );?>" ><span class="dashicons dashicons-art"></span> <span class="tabtitle"><?php _e( 'Styling', 'advanced-widget-control' );?></span></a>
    </li>
<?php
}
add_action( 'extended_widget_opts_tabs', 'widgetcontrol_tab_styling' );

/**
 * Called on 'extended_widget_opts_tabcontent'
 * create new tab content options for alignment options
 */
function widgetcontrol_tabcontent_styling( $args ){
    global $widget_options;

    $selected               = 0;
    $bg_image               = '';
    $background             = '';
    $background_hover       = '';
    $heading                = '';
    $text                   = '';
    $links                  = '';
    $links_hover            = '';
    $border_color           = '';
    $border_width           = '';
    $border_type            = '';

    $background_input       = '';
    $text_input             = '';
    $border_color_input     = '';
    $border_width_input     = '';
    $border_type_input      = '';

    $background_submit      = '';
    $background_submit_hover  = '';
    $text_submit            = '';
    $border_color_submit    = '';
    $border_width_submit    = '';
    $border_type_submit     = '';

    $list_border_color      = '';
    $table_border_color     = '';

}
add_action( 'extended_widget_opts_tabcontent', 'widgetcontrol_tabcontent_styling'); ?>
