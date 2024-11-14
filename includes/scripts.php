<?php
/**
 * Scripts
 * File: includes/scripts.php
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Load Scripts
 *
 * Enqueues the required scripts.
 *
 * @since 1.0
 * @return void
 */

function widgetcontrol_load_scripts(){
	$css_dir = WIDGETCONTROL_PLUGIN_URL . 'assets/css/';
      wp_enqueue_style( 'widgetcontrol-styles', $css_dir . 'advanced-widget-control.css' , array(), null );
}
add_action( 'wp_enqueue_scripts', 'widgetcontrol_load_scripts' );
add_action( 'customize_controls_enqueue_scripts', 'widgetcontrol_load_scripts' );

/**
 * Load Admin Scripts
 *
 * Enqueues the required admin scripts.
 *
 * @since 1.0
 * @global $widget_control
 * @param string $hook Page hook
 * @return void
 */
if( !function_exists( 'widgetcontrol_load_admin_scripts' ) ):
      function widgetcontrol_load_admin_scripts( $hook ) {
            global $widget_control;

            $js_dir  = WIDGETCONTROL_PLUGIN_URL . 'assets/js/';
      		$css_dir = WIDGETCONTROL_PLUGIN_URL . 'assets/css/';

            // Use minified libraries if SCRIPT_DEBUG is turned off
      		$suffix  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

            wp_enqueue_style( 'widgetcontrol-admin-styles', $css_dir . 'admin.css' , array(), null );

            if( !in_array( $hook, apply_filters( 'widgetcontrol_exclude_jqueryui', array( 'toplevel_page_et_divi_options', 'toplevel_page_wpcf7', 'edit.php' ) ) ) ){
                 wp_enqueue_style( 'jquery-ui' );
            }

            if( in_array( $hook, apply_filters( 'widgetcontrol_load_liveFilter_scripts', array( 'widgets.php' ) ) ) ){
                  wp_enqueue_script(
                       'jquery-liveFilter',
                       plugins_url( 'assets/js/jquery.liveFilter.js' , dirname(__FILE__) ),
                       array( 'jquery' ),
                       '',
                       true
                  );
            }

            wp_enqueue_script(
                 'jquery-widgetcontrol-option-tabs',
                 plugins_url( 'assets/js/wpWidgetOpts.js' , dirname(__FILE__) ),
                 array( 'jquery', 'jquery-ui-core', 'jquery-ui-tabs', 'jquery-ui-datepicker'),
                 '',
                 true
            );


            wp_enqueue_style( 'jquery-widgetcontrol-select2-css', plugins_url( 'assets/css/select2.min.css' , dirname(__FILE__) ), array(), null );
            wp_enqueue_script(
                'jquery-widgetcontrol-select2-script',
                $js_dir .'select2.min.js',
                array( 'jquery' ),
                '',
                true
            );

            $form = '<div id="widgetcontrol-widgets-chooser">
              	<label class="screen-reader-text" for="widgetcontrol-search-chooser">'. __( 'Search Sidebar', 'advanced-widget-control' ) .'</label>
              	<input type="text" id="widgetcontrol-search-chooser" class="widgetcontrol-widgets-search" placeholder="'. __( 'Search sidebar&hellip;', 'advanced-widget-control' ) .'" />
                  <div class="widgetcontrol-search-icon" aria-hidden="true"></div>
                  <button type="button" class="widgetcontrol-clear-results"><span class="screen-reader-text">'. __( 'Clear Results', 'advanced-widget-control' ) .'</span></button>
                  <p class="screen-reader-text" id="widgetcontrol-chooser-desc">'. __( 'The search results will be updated as you type.', 'advanced-widget-control' ) .'</p>
              </div>';

            $btn_controls = '';
            if( isset( $widget_control['move'] ) && 'activate' == $widget_control['move'] ){
              $btn_controls .= ' | <button type="button" class="button-link widgetcontrol-control" data-action="move">'. __( 'Move', 'advanced-widget-control' ) .'</button>';
            }

            $sidebaropts = '';
            if( isset( $widget_control['widget_area'] ) && 'activate' == $widget_control['widget_area'] ){
                /* Updated by Haive Vistal - 04/20/2023 - Make sure no empty space in under the widgets if no activated links */
                $remove_widget_link = 0;
                $download_backup_link = 0;
                $delete_all_widget_link = 0;

                if( isset( $widget_control['settings']['widget_area'] ) && isset( $widget_control['settings']['widget_area']['remove'] ) && '1' == $widget_control['settings']['widget_area']['remove'] ){
                    $remove_widget_link = 1;
                }
                if( isset( $widget_control['settings']['widget_area'] ) && isset( $widget_control['settings']['widget_area']['backup'] ) && '1' == $widget_control['settings']['widget_area']['backup'] ){
                    $download_backup_link = 1;
                  }

                if( isset( $widget_control['settings']['widget_area'] ) && isset( $widget_control['settings']['widget_area']['remove'] ) && '1' == $widget_control['settings']['widget_area']['remove'] ){
                    $delete_all_widget_link = 1;
                }

                if( $remove_widget_link == 1 || $download_backup_link == 1 || $delete_all_widget_link == 1 ) {
                    $sidebaropts = '<div class="widgetcontrol-sidebaropts">';
                    if( $remove_widget_link == 1 ) {
                        $sidebaropts .= '<a href="#" class="sidebaropts-clear">
                            <span class="dashicons dashicons-warning"></span> '. __( 'Remove All Widgets', 'advanced-widget-control' ) .'
                        </a>';
                    }
                    if( $download_backup_link == 1 ) {
                        $sidebaropts .= '<a href="'. esc_url( wp_nonce_url( admin_url('tools.php?page=widgetcontrol_migrator_settings&action=export&single_sidebar=__sidebaropts__'), 'widgeopts_export', 'widgeopts_nonce_export') ) .'">
                            <span class="dashicons dashicons-download"></span> '. __( 'Download Backup', 'advanced-widget-control' ) .'
                        </a>';
                    }
                    if( $delete_all_widget_link == 1 ) {
                        $sidebaropts .= '<div class="sidebaropts-confirm"><p>
                          '. __( 'Are you sure you want to DELETE ALL widgets associated to __sidebar_opts__?', 'advanced-widget-control' ) .'
                          </p>
                          <button class="button">'. __( 'No', 'advanced-widget-control' ) .'</button>
                          <button class="button button-primary">'. __( 'Yes', 'advanced-widget-control' ) .'</button>
                        </div>';
                    }
                    $sidebaropts .= '</div>';
                }
            }

            /* Added by Haive Vistal - 04/20/2023 - Default link for all widgets to go through widget options panel settings */
            // $sidebaropts .= '<div class="widgetcontrol-super  widgetcontrol-sidebaropts">';
            //     $sidebaropts .= '<a href="'. esc_url( wp_nonce_url( admin_url('options-general.php?page=widgetcontrol_plugin_settings'), 'widgeopts_setings', 'widgeopts_nonce_settings') ) .'">
            //         <span class="dashicons dashicons-admin-settings"></span> '. __( 'Enable more Advanced Widget Control superpowers', 'advanced-widget-control' ) .'
            //       </a>';
            // $sidebaropts .= '</div>';

            wp_localize_script( 'jquery-widgetcontrol-option-tabs', 'widgetcontrol10n', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'opts_page' => esc_url( admin_url( 'options-general.php?page=widgetcontrol_plugin_settings' ) ), 'search_form' => $form, 'sidebaropts' => $sidebaropts, 'controls' => $btn_controls, 'translation' => array( 'manage_settings' => __( 'Manage Advanced Widget Control', 'advanced-widget-control' ), 'search_chooser' => __( 'Search sidebar&hellip;', 'advanced-widget-control' ) )) );

            if( in_array( $hook, apply_filters( 'widgetcontrol_load_settings_scripts', array( 'settings_page_widgetcontrol_plugin_settings' ) ) ) ){
                  wp_register_script(
                        'jquery-widgetcontrol-settings',
                        $js_dir .'settings'. $suffix .'.js',
                        array( 'jquery' ),
                        '',
                        true
                  );

                  $translation = array(
                        'save_settings'         => __( 'Save Settings', 'advanced-widget-control' ),
                        'close_settings'        => __( 'Close', 'advanced-widget-control' ),
                        'show_settings'         => __( 'Configure Settings', 'advanced-widget-control' ),
                        'hide_settings'         => __( 'Hide Settings', 'advanced-widget-control' ),
                        'show_description'      => __( 'Learn More', 'advanced-widget-control' ),
                        'hide_description'      => __( 'Hide Details', 'advanced-widget-control' ),
                        'show_information'      => __( 'Show Details', 'advanced-widget-control' ),
                        'activate'              => __( 'Enable', 'advanced-widget-control' ),
                        'deactivate'            => __( 'Disable', 'advanced-widget-control' ),
                        'successful_save'       => __( 'Settings saved successfully for %1$s.', 'advanced-widget-control' ),
                        'deactivate_btn'        => __( 'Deactivate License', 'advanced-widget-control' ),
                        'activate_btn'          => __( 'Activate License', 'advanced-widget-control' ),
                        'status_valid' 		=> __( 'Valid', 'advanced-widget-control' ),
                        'status_invalid'        => __( 'Invalid', 'advanced-widget-control' ),
                  );

                  wp_enqueue_script( 'jquery-widgetcontrol-settings' );
                  wp_localize_script( 'jquery-widgetcontrol-settings', 'widgetcontrol', array( 'translation' => $translation, 'ajax_action' => 'widgetcontrol_ajax_settings', 'ajax_nonce' => wp_create_nonce( 'widgetcontrol-settings-nonce' ), ) );
            }
      }
      add_action( 'admin_enqueue_scripts', 'widgetcontrol_load_admin_scripts', 100 );
endif;

if( !function_exists( 'widgetcontrol_widgets_footer' ) ){
      function widgetcontrol_widgets_footer(){
            global $widget_control;?>
            <div class="widgetsopts-chooser" style="display:none;">
                  <?php if( isset( $widget_control['search'] ) && 'activate' == $widget_control['search'] ): ?>
                        <div id="widgetcontrol-widgets-chooser">
                              <label class="screen-reader-text" for="widgetcontrol-search-chooser"><?php _e( 'Search Sidebar', 'advanced-widget-control' );?></label>
                              <input type="text" id="widgetsopts-widgets-search" class="widgetcontrol-widgets-search widgetsopts-widgets-search" placeholder="Search sidebar…">
                              <div class="widgetcontrol-search-icon" aria-hidden="true"></div>
                              <button type="button" class="widgetcontrol-clear-results"><span class="screen-reader-text"><?php _e( 'Clear Results', 'advanced-widget-control' );?></span></button>
                              <p class="screen-reader-text" id="widgetcontrol-chooser-desc"><?php _e( 'The search results will be updated as you type.', 'advanced-widget-control' );?></p>
                        </div>
                  <?php endif; ?>
                  <ul class="widgetcontrol-chooser-sidebars"></ul>
                  <div class="widgetsopts-chooser-actions">
                        <button class="button widgetsopts-chooser-cancel"><?php _e( 'Cancel', 'advanced-widget-control' ); ?></button>
                        <button class="button button-primary widgetcontrol-chooser-action"><span><?php _e( 'Move', 'advanced-widget-control' ); ?></span> <?php _e( 'Widget', 'advanced-widget-control' ); ?></button>
                  </div>
            </div>
      <?php }
      add_action( 'admin_footer-widgets.php', 'widgetcontrol_widgets_footer' );
}
?>
