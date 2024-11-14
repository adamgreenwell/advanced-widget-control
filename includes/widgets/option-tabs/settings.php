<?php
/**
 * Settings Advanced Widget Control
 *
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Add Settings Advanced Widget Control Tab
 *
 * @since 1.0
 * @return void
 */

 /**
 * Called on 'advanced_widget_control_tabs'
 * create new tab navigation for alignment options
 */
if( !function_exists( 'widgetcontrol_tab_settings' ) ):
   function widgetcontrol_tab_settings( $args ){ ?>
       <li class="advanced-widget-control-tab-class">
          <a href="#advanced-widget-control-tab-<?php echo $args['id'];?>-class" title="<?php _e( 'Class, ID & Logic', 'advanced-widget-control' );?>" ><span class="dashicons dashicons-admin-generic"></span> <span class="tabtitle"><?php _e( 'Other Settings', 'advanced-widget-control' );?></span></a>
      </li>
   <?php
   }
   add_action( 'advanced_widget_control_tabs', 'widgetcontrol_tab_settings' );
endif;

/**
 * Called on 'advanced_widget_control_tabcontent'
 * create new tab content options for alignment options
 */
if( !function_exists( 'widgetcontrol_tabcontent_settings' ) ):
   function widgetcontrol_tabcontent_settings( $args ){
       global $widget_control;

       $id         = '';
       $classes    = '';
       $logic      = '';
       $selected   = 0;
       $check      = '';
       if( isset( $args['params'] ) && isset( $args['params']['class'] ) ){
           if( isset( $args['params']['class']['id'] ) ){
               $id = $args['params']['class']['id'];
           }
           if( isset( $args['params']['class']['classes'] ) ){
               $classes = $args['params']['class']['classes'];
           }
           if( isset( $args['params']['class']['selected'] ) ){
               $selected = $args['params']['class']['selected'];
           }
           if( isset( $args['params']['class']['logic'] ) ){
               $logic = $args['params']['class']['logic'];
           }
           if( isset( $args['params']['class']['title'] ) && $args['params']['class']['title'] == '1' ){
               $check = 'checked="checked"';
           }
       }

       $predefined = array();
       if( isset( $widget_control['settings']['classes'] ) && isset( $widget_control['settings']['classes']['classlists'] ) && !empty( $widget_control['settings']['classes']['classlists'] ) ){
           $predefined = $widget_control['settings']['classes']['classlists'];
       }
       ?>
       <div id="advanced-widget-control-tab-<?php echo $args['id'];?>-class" class="advanced-widget-control-tabcontent advanced-widget-control-inside-tabcontent advanced-widget-control-tabcontent-class">

           <div class="advanced-widget-control-settings-tabs advanced-widget-control-inside-tabs">
               <input type="hidden" id="advanced-widget-control-settings-selectedtab" value="<?php echo $selected;?>" name="<?php echo $args['namespace'];?>[advanced_widget_control][class][selected]" />
               <!--  start tab nav -->
               <ul class="advanced-widget-control-settings-tabnav-ul">
                   <?php if( 'activate' == $widget_control['hide_title'] ){ ?>
                       <li class="advanced-widget-control-settings-tab-title">
                           <a href="#advanced-widget-control-settings-tab-<?php echo $args['id'];?>-title" title="<?php _e( 'Misc', 'advanced-widget-control' );?>" ><?php _e( 'Misc', 'advanced-widget-control' );?></a>
                       </li>
                   <?php } ?>

                   <?php if( 'activate' == $widget_control['classes'] ){ ?>
                       <li class="advanced-widget-control-settings-tab-class">
                           <a href="#advanced-widget-control-settings-tab-<?php echo $args['id'];?>-class" title="<?php _e( 'Class & ID', 'advanced-widget-control' );?>" ><?php _e( 'Class & ID', 'advanced-widget-control' );?></a>
                       </li>
                   <?php } ?>

                   <?php if( 'activate' == $widget_control['logic'] ){ ?>
                       <li class="advanced-widget-control-settings-tab-logic">
                           <a href="#advanced-widget-control-settings-tab-<?php echo $args['id'];?>-logic" title="<?php _e( 'Display Logic', 'advanced-widget-control' );?>" ><?php _e( 'Logic', 'advanced-widget-control' );?></a>
                       </li>
                   <?php } ?>
                   <div class="advanced-widget-control-clearfix"></div>
               </ul><!--  end tab nav -->
               <div class="advanced-widget-control-clearfix"></div>

               <?php if( 'activate' == $widget_control['hide_title'] ){ ?>
                   <!--  start title tab content -->
                   <div id="advanced-widget-control-settings-tab-<?php echo $args['id'];?>-title" class="advanced-widget-control-settings-tabcontent advanced-widget-control-inner-tabcontent">
                       <div class="widget-ctrl-title">
                           <?php if( 'activate' == $widget_control['hide_title'] ){ ?>
                               <p class="widgetcontrol-subtitle"><?php _e( 'Hide Widget Title', 'advanced-widget-control' );?></p>
                               <p>
                                   <input type="checkbox" name="<?php echo $args['namespace'];?>[advanced_widget_control][class][title]" id="opts-class-title-<?php echo $args['id'];?>" value="1" <?php echo $check;?> />
                                   <label for="opts-class-title-<?php echo $args['id'];?>"><?php _e( 'Check to hide widget title', 'advanced-widget-control' );?></label>
                               </p>
                           <?php } ?>
                       </div>
                   </div><!--  end title tab content -->
               <?php } ?>

               <?php if( 'activate' == $widget_control['classes'] ){ ?>
                   <!--  start class tab content -->
                   <div id="advanced-widget-control-settings-tab-<?php echo $args['id'];?>-class" class="advanced-widget-control-settings-tabcontent advanced-widget-control-inner-tabcontent">
                       <div class="widget-ctrl-class">
                           <table class="form-table">
                           <tbody>
                               <?php if( isset( $widget_control['settings']['classes'] ) && ( isset( $widget_control['settings']['classes']['id'] ) && '1' == $widget_control['settings']['classes']['id'] ) ){?>
                                   <tr valign="top" class="widgetcontrol_id_fld">
                                       <td scope="row">
                                           <strong><?php _e( 'Widget CSS ID:', 'advanced-widget-control' );?></strong><br />
                                           <input type="text" id="opts-class-id-<?php echo $args['id'];?>" class="widefat" name="<?php echo $args['namespace'];?>[advanced_widget_control][class][id]" value="<?php echo $id;?>" />
										   <small><em><?php _e( 'Make sure custom widget zones have the "id" field called during theme registration.', 'advanced-widget-control' );?></em></small>
                                       </td>
                                   </tr>
                               <?php } ?>

                               <?php if( !isset( $widget_control['settings']['classes'] ) ||
                                        ( isset( $widget_control['settings']['classes'] ) && isset( $widget_control['settings']['classes']['type'] ) && !in_array( $widget_control['settings']['classes']['type'] , array( 'hide', 'predefined' ) ) ) ){?>
                                   <tr valign="top">
                                       <td scope="row">
                                           <strong><?php _e( 'Widget CSS Classes:', 'advanced-widget-control' );?></strong><br />
                                           <input type="text" id="opts-class-classes-<?php echo $args['id'];?>" class="widefat" name="<?php echo $args['namespace'];?>[advanced_widget_control][class][classes]" value="<?php echo $classes;?>" />
                                           <small><em><?php _e( 'Separate each class with space.', 'advanced-widget-control' );?></em></small>
                                       </td>
                                   </tr>
                               <?php } ?>
                               <?php if( !isset( $widget_control['settings']['classes'] ) ||
                                        ( isset( $widget_control['settings']['classes'] ) && isset( $widget_control['settings']['classes']['type'] ) && !in_array( $widget_control['settings']['classes']['type'] , array( 'hide', 'text' ) ) ) ){?>
                                   <?php if( is_array( $predefined ) && !empty( $predefined ) ){
                                       $predefined = array_unique( $predefined ); //remove dups
                                       ?>
                                           <tr valign="top">
                                               <td scope="row">
                                                   <strong><?php _e( 'Available Widget Classes:', 'advanced-widget-control' );?></strong><br />
                                                   <div class="advanced-widget-control-class-lists" style="max-height: 230px;padding: 5px;overflow:auto;">
                                                       <?php foreach ($predefined as $key => $value) {
                                                           if(  isset( $args['params']['class']['predefined'] ) &&
                                                                is_array( $args['params']['class']['predefined'] ) &&
                                                                in_array( $value , $args['params']['class']['predefined'] ) ){
                                                               $checked = 'checked="checked"';
                                                           } else {
                                                               $checked = '';
                                                           }
                                                           ?>
                                                           <p>
                                                               <input type="checkbox" name="<?php echo $args['namespace'];?>[advanced_widget_control][class][predefined][]" id="<?php echo $args['id'];?>-opts-class-<?php echo $key;?>" value="<?php echo $value;?>" <?php echo $checked;?> />
                                                               <label for="<?php echo $args['id'];?>-opts-class-<?php echo $key;?>"><?php echo $value;?></label>
                                                           </p>
                                                       <?php } ?>
                                                   </div>
                                               </td>
                                           </tr>
                                       <?php } ?>
                               <?php } ?>
                           </tbody>
                           </table>
                       </div>
                   </div><!--  end class tab content -->
               <?php } ?>

               <?php if( 'activate' == $widget_control['logic'] ){ ?>
                   <!--  start logic tab content -->
                   <div id="advanced-widget-control-settings-tab-<?php echo $args['id'];?>-logic" class="advanced-widget-control-settings-tabcontent advanced-widget-control-inner-tabcontent">
                       <div class="widget-ctrl-logic">
                           <p><small><?php _e( 'The text field lets you use <a href="http://codex.wordpress.org/Conditional_Tags" target="_blank">WP Conditional Tags</a>, or any general PHP code.', 'advanced-widget-control' );?></small></p>
                           <textarea class="widefat" name="<?php echo $args['namespace'];?>[advanced_widget_control][class][logic]"><?php echo stripslashes( $logic );?></textarea>

                           <?php if( !isset( $widget_control['settings']['logic'] ) ||
                                    ( isset( $widget_control['settings']['logic']  ) && !isset( $widget_control['settings']['logic']['notice']  ) ) ){ ?>
                                         <p><a href="#" class="widget-ctrl-toggler-note"><?php _e( 'Click to Toggle Note', 'advanced-widget-control' );?></a></p>
                                         <p class="widget-ctrl-toggle-note"><small><?php _e( 'PLEASE NOTE that the display logic you introduce is EVAL\'d directly. Anyone who has access to edit widget appearance will have the right to add any code, including malicious and possibly destructive functions. There is an optional filter <em>"widget_control_logic_override"</em> which you can use to bypass the EVAL with your own code if needed.', 'advanced-widget-control' );?></small></p>
                           <?php } ?>
                       </div>
                   </div><!--  end logiv tab content -->
               <?php } ?>

           </div><!-- end .advanced-widget-control-settings-tabs -->

       </div>
   <?php
   }
   add_action( 'advanced_widget_control_tabcontent', 'widgetcontrol_tabcontent_settings');
endif; ?>
