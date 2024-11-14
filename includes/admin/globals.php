<?php
/**
 * Add values to global variables
 *
 * @since       1.0
 */

if( !function_exists( 'widgetcontrol_register_globals' ) ){
    add_action( 'init', 'widgetcontrol_register_globals', 90 );
    function widgetcontrol_register_globals(){
        global $widgetcontrol_taxonomies, $widgetcontrol_types, $widgetcontrol_categories;

        $widgetcontrol_taxonomies 	= widgetcontrol_global_taxonomies();
        $widgetcontrol_types 		= widgetcontrol_global_types();
        $widgetcontrol_categories 	= widgetcontrol_global_categories();

    }
}
?>
