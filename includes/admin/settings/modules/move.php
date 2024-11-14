<?php
/**
 * Move Widgets Module
 * Settings > Advanced Widget Control :: Move Widget
 *
 * @since       1.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Create Card Module for Move Widget Feature
 *
 * @since 1.0
 * @global $widget_control
 * @return void
 */
 
  /*
 * Note: Please add a class "no-settings" in the <li> card if the card has no additional configuration, if there are configuration please remove the class
 */

if( !function_exists( 'widgetcontrol_settings_move' ) ):
    function widgetcontrol_settings_move(){
        global $widget_control;

        //avoid issue after update
        if( !isset( $widget_control['move'] ) ){
            $widget_control['move'] = '';
        }
        ?>
        <li class="widgetcontrol-module-card widgetcontrol-module-card-no-settings no-settings <?php echo ( $widget_control['move'] == 'activate' ) ? 'widgetcontrol-module-type-enabled' : 'widgetcontrol-module-type-disabled'; ?>" id="widgetcontrol-module-card-move" data-module-id="move">
    		<div class="widgetcontrol-module-card-content">
    			<h2><?php _e( 'Move Widget', 'advanced-widget-control' );?></h2>
    			<p class="widgetcontrol-module-desc">
    				<?php _e( 'Easily move widgets to any sidebar widget area without drag and drop.', 'advanced-widget-control' );?>
    			</p>

    			<div class="widgetcontrol-module-actions hide-if-no-js">
                    <?php if( $widget_control['move'] == 'activate' ){ ?>
    					<button class="button button-secondary widgetcontrol-toggle-settings"><?php _e( 'Learn More', 'advanced-widget-control' );?></button>
    					<button class="button button-secondary widgetcontrol-toggle-activation"><?php _e( 'Disable', 'advanced-widget-control' );?></button>
    				<?php } else { ?>
    					<button class="button button-secondary widgetcontrol-toggle-settings"><?php _e( 'Learn More', 'advanced-widget-control' );?></button>
    					<button class="button button-primary widgetcontrol-toggle-activation"><?php _e( 'Enable', 'advanced-widget-control' );?></button>
    				<?php } ?>

    			</div>

    		</div>

    		<?php widgetcontrol_modal_start( $widget_control['move'] ); ?>
    			<span class="dashicons widgetcontrol-dashicons widgetcontrol-no-top dashicons-image-rotate-right"></span>
    			<h3 class="widgetcontrol-modal-header"><?php _e( 'Move Widget', 'advanced-widget-control' );?></h3>
    			<p>
    				<?php _e( 'Move Widget feature will automatically add <strong>Move</strong> button that will let you easily move any widgets to any sidebar widget areas without dragging them. This will definitely increase your productivity and widget management specially on smaller screen devices such as mobile phones. You can check how this feature works on this <a href="https://vimeo.com/229112330" target="_blank">video</a>. Thanks!', 'advanced-widget-control' );?>
    			</p>
    			<p class="widgetcontrol-settings-section">
    				<?php _e( 'No additional settings available.', 'advanced-widget-control' );?>
    			</p>
    		<?php widgetcontrol_modal_end( $widget_control['move'] ); ?>

    	</li>
        <?php
    }
    add_action( 'widgetcontrol_module_cards', 'widgetcontrol_settings_move', 64 );
endif;
?>
