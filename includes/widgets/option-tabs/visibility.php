<?php

/**
 * Pages Visibility Advanced Widget Control
 *
 * @since       1.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Add Visibility Advanced Widget Control Tab
 *
 * @since 1.0
 * @return void
 */

/**
 * Called on 'advanced_widget_control_tabs'
 * create new tab navigation for visibility options
 */
function widgetcontrol_tab_visibility($args)
{ ?>
    <li class="advanced-widget-control-tab-visibility">
        <a href="#advanced-widget-control-tab-<?php echo $args['id']; ?>-visibility" title="<?php _e('Visibility', 'advanced-widget-control'); ?>"><span class="dashicons dashicons-visibility"></span> <span class="tabtitle"><?php _e('Visibility', 'advanced-widget-control'); ?></span></a>
    </li>
<?php
}
add_action('advanced_widget_control_tabs', 'widgetcontrol_tab_visibility');

/**
 * Called on 'advanced_widget_control_tabcontent'
 * create new tab content options for visibility options
 */
function widgetcontrol_tabcontent_visibility($args)
{
    global $widget_control, $widgetcontrol_taxonomies, $widgetcontrol_pages, $widgetcontrol_types, $widgetcontrol_categories;

    $checked    = "";
    $main       = "";
    $selected   = 0;
    $tax_opts   = (array) get_option('extwopts_taxonomy_settings');
    $pages      = (!empty($widgetcontrol_pages))       ? $widgetcontrol_pages         : array();
    $taxonomies = (!empty($widgetcontrol_taxonomies))  ? $widgetcontrol_taxonomies    : array();
    $types      = (!empty($widgetcontrol_types))       ? $widgetcontrol_types         : array();
    $categories = (!empty($widgetcontrol_categories))  ? $widgetcontrol_categories    : array();

    //declare miscellaneous pages - wordpress default pages
    $misc       = array(
        'home'      =>  __('Home/Front', 'advanced-widget-control'),
        'blog'      =>  __('Blog', 'advanced-widget-control'),
        'archives'  =>  __('Archives', 'advanced-widget-control'),
        // 'single'    =>  __( 'Single Post', 'advanced-widget-control' ),
        '404'       =>  __('404', 'advanced-widget-control'),
        'search'    =>  __('Search', 'advanced-widget-control')
    );

    //unset builtin post types
    foreach (array('revision', 'attachment', 'nav_menu_item') as $unset) {
        unset($types[$unset]);
    }

    //pro version only
    // $get_terms = array();
    // if( !empty( $widget_control['settings']['taxonomies'] ) && is_array( $widget_control['settings']['taxonomies'] ) ){
    //     foreach ( $widget_control['settings']['taxonomies'] as $tax_opt => $vall ) {
    //         $tax_name = 'widgetcontrol_taxonomy_'. $tax_opt;
    //         global $$tax_name;
    //         $get_terms[ $tax_opt ] = $$tax_name;
    //     }
    // }


    //get save values
    $options_values = '';
    $misc_values    = array();
    $pages_values   = array();
    $types_values   = array();
    $cat_values     = array();
    $tax_values     = array();
    if (isset($args['params']) && isset($args['params']['visibility'])) {

        if (isset($args['params']['visibility']['options'])) {
            $options_values = $args['params']['visibility']['options'];
        }

        if (isset($args['params']['visibility']['misc'])) {
            $misc_values = $args['params']['visibility']['misc'];
        }

        if (isset($args['params']['visibility']['pages'])) {
            $pages_values = $args['params']['visibility']['pages'];
        }

        if (isset($args['params']['visibility']['types'])) {
            $types_values = $args['params']['visibility']['types'];
        }

        if (isset($args['params']['visibility']['categories'])) {
            $cat_values = $args['params']['visibility']['categories'];
        }

        if (isset($args['params']['visibility']['taxonomies'])) {
            $tax_values = $args['params']['visibility']['taxonomies'];
        }

        if (isset($args['params']['visibility']['tax_terms'])) {
            $terms_values = $args['params']['visibility']['tax_terms'];
        }

        if (isset($args['params']['visibility']['selected'])) {
            $selected = $args['params']['visibility']['selected'];
        }

        if (isset($args['params']['visibility']['main'])) {
            $main = $args['params']['visibility']['main'];
        }
    }

    // fix values for older settings
    $tmpPages_values = array();
    foreach ($pages_values as $objKey => $objPage) {
        if (isset($pages_values[$objKey]) && $pages_values[$objKey] == '1') {
            $tmpPages_values[] = $objKey;
        } else {
            $tmpPages_values[] = $objPage;
        }
    }
    $pages_values = $tmpPages_values;

    // fix values for older settings
    $tmpTerms_values = array();
    foreach ($cat_values as $objKey => $objTerm) {
        if (isset($cat_values[$objKey]) && $cat_values[$objKey] == '1') {
            $_objKey = $objKey;
            if (is_numeric($objKey)) {
                if (intval($objKey) == 0) {
                    $_objKey = 1;
                }
            }

            $tmpTerms_values[] = $_objKey;
        } else {
            $_objTerm = $objTerm;
            if (is_numeric($objTerm)) {
                if (intval($objTerm) == 0) {
                    $_objTerm = 1;
                }
            }

            $tmpTerms_values[] = $_objTerm;
        }
    }
    $term_values = $tmpTerms_values;
?>
    <div id="advanced-widget-control-tab-<?php echo $args['id']; ?>-visibility" class="advanced-widget-control-tabcontent advanced-widget-control-tabcontent-visibility">

        <div class="advanced-widget-control-styling-tabs advanced-widget-control-inside-tabs">
            <input type="hidden" id="advanced-widget-control-visibility-m-selectedtab" value="<?php echo $main; ?>" name="<?php echo $args['namespace']; ?>[advanced_widget_control][visibility][main]" />

            <p class="widgetcontrol-subtitle"><?php _e('WordPress Pages', 'advanced-widget-control'); ?></p>
            <div id="advanced-widget-control-visibility-tab-<?php echo $args['id']; ?>-main" class="advanced-widget-control-visibility-tabcontent advanced-widget-control-inside-tabcontent advanced-widget-control-inner-tabcontent">
                <p><strong><?php _e('Hide or Show', 'advanced-widget-control'); ?></strong>
                    <select class="widefat" name="<?php echo $args['namespace']; ?>[advanced_widget_control][visibility][options]">
                        <option value="hide" <?php if ($options_values == 'hide') {
                                                    echo 'selected="selected"';
                                                } ?>><?php _e('Hide on checked pages', 'advanced-widget-control'); ?></option>
                        <option value="show" <?php if ($options_values == 'show') {
                                                    echo 'selected="selected"';
                                                } ?>><?php _e('Show on checked pages', 'advanced-widget-control'); ?></option>
                    </select>
                </p>

                <div class="advanced-widget-control-visibility-tabs advanced-widget-control-inside-tabs">
                    <input type="hidden" id="advanced-widget-control-visibility-selectedtab" value="<?php echo $selected; ?>" name="<?php echo $args['namespace']; ?>[advanced_widget_control][visibility][selected]" />
                    <!--  start tab nav -->
                    <ul class="advanced-widget-control-visibility-tabnav-ul">
                        <?php if (
                            isset($widget_control['settings']['visibility']) &&
                            isset($widget_control['settings']['visibility']['misc']) &&
                            '1' == $widget_control['settings']['visibility']['misc']
                        ) { ?>
                            <li class="advanced-widget-control-visibility-tab-visibility">
                                <a href="#advanced-widget-control-visibility-tab-<?php echo $args['id']; ?>-misc" title="<?php _e('Home, Blog, Search, etc..', 'advanced-widget-control'); ?>"><?php _e('Misc', 'advanced-widget-control'); ?></a>
                            </li>
                        <?php } ?>

                        <?php if (
                            isset($widget_control['settings']['visibility']) &&
                            isset($widget_control['settings']['visibility']['post_type']) &&
                            '1' == $widget_control['settings']['visibility']['post_type']
                        ) { ?>
                            <li class="advanced-widget-control-visibility-tab-visibility">
                                <a href="#advanced-widget-control-visibility-tab-<?php echo $args['id']; ?>-types" title="<?php _e('Pages & Custom Post Types', 'advanced-widget-control'); ?>"><?php _e('Post Types', 'advanced-widget-control'); ?></a>
                            </li>
                        <?php } ?>

                        <?php if (
                            isset($widget_control['settings']['visibility']) &&
                            isset($widget_control['settings']['visibility']['taxonomies']) &&
                            '1' == $widget_control['settings']['visibility']['taxonomies']
                        ) { ?>
                            <li class="advanced-widget-control-visibility-tab-visibility">
                                <a href="#advanced-widget-control-visibility-tab-<?php echo $args['id']; ?>-tax" title="<?php _e('Categories, Tags & Taxonomies', 'advanced-widget-control'); ?>"><?php _e('Taxonomies', 'advanced-widget-control'); ?></a>
                            </li>
                        <?php } ?>
                        <div class="advanced-widget-control-clearfix"></div>
                    </ul><!--  end tab nav -->
                    <div class="advanced-widget-control-clearfix"></div>

                    <?php if (
                        isset($widget_control['settings']['visibility']) &&
                        isset($widget_control['settings']['visibility']['misc']) &&
                        '1' == $widget_control['settings']['visibility']['misc']
                    ) { ?>
                        <!--  start misc tab content -->
                        <div id="advanced-widget-control-visibility-tab-<?php echo $args['id']; ?>-misc" class="advanced-widget-control-visibility-tabcontent advanced-widget-control-inner-tabcontent">
                            <div class="advanced-widget-control-misc">
                                <?php foreach ($misc as $key => $value) {
                                    if (isset($misc_values[$key]) && $misc_values[$key] == '1') {
                                        $checked = 'checked="checked"';
                                    } else {
                                        $checked = '';
                                    }
                                ?>
                                    <p>
                                        <input type="checkbox" name="<?php echo $args['namespace']; ?>[advanced_widget_control][visibility][misc][<?php echo $key; ?>]" id="<?php echo $args['id']; ?>-opts-misc-<?php echo $key; ?>" value="1" <?php echo $checked; ?> />
                                        <label for="<?php echo $args['id']; ?>-opts-misc-<?php echo $key; ?>"><?php echo $value; ?></label>
                                    </p>
                                <?php } ?>
                            </div>
                        </div><!--  end misc tab content -->
                    <?php } ?>

                    <?php if (
                        isset($widget_control['settings']['visibility']) &&
                        isset($widget_control['settings']['visibility']['post_type']) &&
                        '1' == $widget_control['settings']['visibility']['post_type']
                    ) { ?>
                        <!--  start types tab content -->
                        <div id="advanced-widget-control-visibility-tab-<?php echo $args['id']; ?>-types" class="advanced-widget-control-visibility-tabcontent advanced-widget-control-inner-tabcontent advanced-widget-control-tabcontent-pages">
                            <div class="advanced-widget-control-inner-lists" style="height: 230px;padding: 5px;overflow:auto;">
                                <h4 id="advanced-widget-control-pages"><?php _e('Pages', 'advanced-widget-control'); ?><br>
                                    <small>Type at least 3 characters to initiate the search</small>
                                </h4>
                                <div class="advanced-widget-control-pages">
                                    <select class="widefat advanced-widget-control-select2-dropdown advanced-widget-control-select2-page-dropdown" name="<?php echo $args['namespace']; ?>[advanced_widget_control][visibility][pages][]" data-namespace="<?php echo $args['namespace']; ?>" multiple="multiple">
                                        <?php if (!empty($pages_values)) {
                                            $pageLoop  = get_pages(['hierarchical' => false, 'include' => $pages_values]);
                                            foreach ($pageLoop as $objPage) {
                                                echo '<option value="' . $objPage->ID . '" selected>' . $objPage->post_title . '</option>';
                                            }
                                        } ?>
                                    </select>


                                    <?php
                                    // $page_class = new WidgetOpts_Pages_Checkboxes();
                                    // $page_checkboxes = $page_class->walk( $widgetcontrol_pages, 0, $args );
                                    // if ( $page_checkboxes ) {
                                    //     echo '<div class="widgetcontrol-ul-pages">' . $page_checkboxes . '</div>';
                                    // }
                                    ?>
                                </div>

                                <h4 id="advanced-widget-control-types"><?php _e('Post Types', 'advanced-widget-control'); ?></h4>
                                <div class="advanced-widget-control-types">
                                    <?php foreach ($types as $ptype => $type) {

                                        if (isset($types_values[$ptype]) && $types_values[$ptype] == '1') {
                                            $checked = 'checked="checked"';
                                        } else {
                                            $checked = '';
                                        }
                                    ?>
                                        <p>
                                            <input type="checkbox" name="<?php echo $args['namespace']; ?>[advanced_widget_control][visibility][types][<?php echo $ptype; ?>]" id="<?php echo $args['id']; ?>-opts-types-<?php echo $ptype; ?>" value="1" <?php echo $checked; ?> />
                                            <label for="<?php echo $args['id']; ?>-opts-types-<?php echo $ptype; ?>"><?php echo stripslashes($type->labels->name); ?></label>
                                        </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div><!--  end types tab content -->
                    <?php } ?>

                    <?php if (
                        isset($widget_control['settings']['visibility']) &&
                        isset($widget_control['settings']['visibility']['taxonomies']) &&
                        '1' == $widget_control['settings']['visibility']['taxonomies']
                    ) { ?>
                        <!--  start tax tab content -->
                        <div id="advanced-widget-control-visibility-tab-<?php echo $args['id']; ?>-tax" class="advanced-widget-control-visibility-tabcontent advanced-widget-control-inner-tabcontent advanced-widget-control-tabcontent-taxonomies">
                            <div class="advanced-widget-control-inner-lists" style="height: 230px;padding: 5px;overflow:auto;">
                                <h4 id="advanced-widget-control-categories"><?php _e('Categories', 'advanced-widget-control'); ?><br>
                                    <small>Type at least 3 characters to initiate the search for a Category term</small>
                                </h4>
                                <div class="advanced-widget-control-categories">
                                    <select class="widefat advanced-widget-control-select2-dropdown advanced-widget-control-select2-taxonomy-dropdown" name="<?php echo $args['namespace']; ?>[advanced_widget_control][visibility][categories][]" data-taxonomy="category" data-namespace="<?php echo $args['namespace']; ?>" multiple="multiple">
                                        <?php if (!empty($term_values)) {
                                            $taxLoop  = get_terms(['taxonomy' => 'category', 'include' => $term_values, 'hide_empty' => false]);
                                            foreach ($taxLoop as $objTax) {
                                                echo '<option value="' . $objTax->term_id . '" selected>' . $objTax->name . '</option>';
                                            }
                                        } ?>
                                    </select>
                                </div>

                                <h4 id="advanced-widget-control-taxonomies"><?php _e('Taxonomies', 'advanced-widget-control'); ?></h4>
                                <div class="advanced-widget-control-taxonomies">
                                    <?php foreach ($taxonomies as $taxonomy) {
                                        if (isset($tax_values[$taxonomy->name]) && $tax_values[$taxonomy->name] == '1') {
                                            $checked = 'checked="checked"';
                                        } else {
                                            $checked = '';
                                        }
                                    ?>
                                        <p>
                                            <input type="checkbox" name="<?php echo $args['namespace']; ?>[advanced_widget_control][visibility][taxonomies][<?php echo $taxonomy->name; ?>]" id="<?php echo $args['id']; ?>-opts-taxonomies-<?php echo $taxonomy->name; ?>" value="1" <?php echo $checked; ?> />
                                            <label for="<?php echo $args['id']; ?>-opts-taxonomies-<?php echo $taxonomy->name; ?>"><?php echo $taxonomy->label; ?></label> <?php if (isset($taxonomy->object_type) && isset($taxonomy->object_type[0])) {
                                                                                                                                                                                echo ' <small>- ' . $taxonomy->object_type[0] . '</small>';
                                                                                                                                                                            } ?>
                                        </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div><!--  end tax tab content -->
                    <?php } ?>
                </div><!--  end .advanced-widget-control-visibility-tabs -->
            </div><!-- End WordPress Pages tab -->
        </div><!--  end main tab -->

    </div>
<?php
}
add_action('advanced_widget_control_tabcontent', 'widgetcontrol_tabcontent_visibility');

// Page Options
function widgetcontrol_ajax_page_search()
{
    $response = [
        'results' => [],
        'pagination' => ['more' => false]
    ];

    if (!empty($_POST['term'])) {
        $args = array(
            'post_type'     => 'page',
            'post_status'   => 'publish',
            's' => $_POST['term'],
        );

        $query = new WP_Query($args);
        while ($query->have_posts()) {
            $query->the_post();
            $response['results'][] = [
                'id' => get_the_ID(),
                'text' => get_the_title()
            ];
        }
    }

    echo json_encode($response);
    die();
}
add_action('wp_ajax_widgetcontrol_ajax_page_search',  'widgetcontrol_ajax_page_search');

// Taxonomy Options
function widgetcontrol_ajax_taxonomy_search()
{
    $response = [
        'results' => [],
        'pagination' => ['more' => false]
    ];

    if (!empty($_POST['term']) && $_POST['taxonomy']) {
        $args = array(
            'taxonomy'      => array($_POST['taxonomy']),
            'fields'        => 'all',
            'name__like'    => $_POST['term'],
            'hide_empty' => false
        );

        $terms = get_terms($args);
        foreach ($terms as $term) {
            $response['results'][] = [
                'id' => $term->term_id,
                'text' => $term->name
            ];
        }
    }

    echo json_encode($response);
    die();
}
add_action('wp_ajax_widgetcontrol_ajax_taxonomy_search',  'widgetcontrol_ajax_taxonomy_search'); ?>
