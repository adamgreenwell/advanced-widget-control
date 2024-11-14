<?php
/**
 * Admin Options Page
 * Settings > Advanced Widget Control
 *
 * @since       1.0
*/
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 *
 * @since 1.0
 * @return void
 */
if( !function_exists( 'widgetcontrol_add_options_link' ) ):
	function widgetcontrol_add_options_link() {
		add_options_page(
			__( 'Advanced Widget Control', 'advanced-widget-control' ),
			__( 'Advanced Widget Control', 'advanced-widget-control' ),
			'manage_options',
			'widgetcontrol_plugin_settings',
			'widgetcontrol_options_page'
		);
	}
	add_action( 'admin_menu', 'widgetcontrol_add_options_link', 10 );
endif;

/**
 * Options Page
 *
 * Renders the options page contents.
 *
 * @since 1.0
 * @return void
 */
if( !function_exists( 'widgetcontrol_options_page' ) ):
	function widgetcontrol_options_page(){
	     $view = 'grid'; //define so that we can add more views later on
	     ?>
	     <div class="wrap">
			<div id="widgetcontrol-settings-messages-container"></div>
			<div id="poststuff" class="widgetcontrol-poststuff">
				<div id="post-body" class="metabox-holder columns-2 hide-if-no-js">
					<div id="postbox-container-2" class="postbox-container">

						<div class="widgetcontrol-module-cards-container <?php echo $view; ?> hide-if-no-js">
							<form enctype="multipart/form-data" method="post" action="/wp-admin/admin.php?page=widgetcontrol_plugin_settings" id="widgetcontrol-module-settings-form">
								<ul class="widgetcontrol-module-cards">
									<?php echo do_action( 'widgetcontrol_module_cards' );?>
								</ul>
							</form>
						</div>
						<div class="widgetcontrol-modal-background"></div>
					</div>

					<div id="postbox-container-1" class="postbox-container">
						<?php echo do_action( 'widgetcontrol_module_sidebar' );?>
					</div>

				</div>
			</div>
		</div>
	     <?php
	 }
 endif;

 /**
  * Modal Wrapper
  *
  * Create callable modal wrappers to avoid writing same code again
  *
  * @since 1.0
  * @return void
  */
if( !function_exists( 'widgetcontrol_modal_start' ) ):
	function widgetcontrol_modal_start( $option = null ){ ?>
		<div class="widgetcontrol-module-settings-container">
			<div class="widgetcontrol-modal-navigation">
				<button class="dashicons widgetcontrol-close-modal"></button>
			</div>
			<div class="widgetcontrol-module-settings-content-container">
				<div class="widgetcontrol-module-settings-content">
	<?php }
endif;

if( !function_exists( 'widgetcontrol_modal_end' ) ):
	function widgetcontrol_modal_end( $option = null ){ ?>
				</div>
			</div>
			<div class="widgetcontrol-list-content-footer hide-if-no-js">
				<button class="button button-primary align-left widgetcontrol-module-settings-save"><?php _e( 'Save Settings', 'advanced-widget-control' );?></button>
				<button class="button button-secondary align-left widgetcontrol-module-settings-cancel"><?php _e( 'Cancel', 'advanced-widget-control' );?></button>
			</div>
			<div class="widgetcontrol-modal-content-footer">
				<?php if( $option == 'activate' ){ ?>
					<button class="button button-secondary align-right widgetcontrol-toggle-activation"><?php _e( 'Disable', 'advanced-widget-control' );?></button>
				<?php } else { ?>
					<button class="button button-primary align-right widgetcontrol-toggle-activation"><?php _e( 'Enable', 'advanced-widget-control' );?></button>
				<?php } ?>
				<button class="button button-primary align-left widgetcontrol-module-settings-save"><?php _e( 'Save Settings', 'advanced-widget-control' );?></button>
			</div>
		</div>
	<?php }
endif; ?>
