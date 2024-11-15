<?php
/**
 * Advanced Widget Control Importer
 *
 * @category Widgets
 * @version 1.0
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'WP_Advanced_Widget_Control_Importer' ) ) :

/**
 * Main WP_Advanced_Widget_Control_Importer Class.
 *
 * @since 1.0
 */
class WP_Advanced_Widget_Control_Importer {

	protected $imported = array();

    function __construct(){
    	global $widget_control;
    	if( ( isset( $widget_control['import_export'] ) && 'activate' == $widget_control['import_export'] ) ||
    		( isset( $widget_control['widget_area'] ) && 'activate' == $widget_control['widget_area'] )
    	 ){
    		add_action( 'admin_menu', array( &$this, 'options_page' ), 10 );
	        add_action( 'wp_ajax_widgetcontrol_migrator', array( &$this, 'ajax_migration' ) );
	        add_action( 'load-tools_page_widgetcontrol_migrator_settings', array( &$this, 'export_json_file' ) );
	        add_action( 'load-tools_page_widgetcontrol_migrator_settings', array( &$this, 'import_json_file' ) );

	        if( !isset( $widget_control['import_export'] ) || ( isset( $widget_control['import_export'] ) && 'activate' != $widget_control['import_export']  ) ){
	        	add_action( 'admin_footer', array( &$this, 'admin_footer' ), 10 );
	        }
	        
    	}
    }

    function options_page() {
		add_management_page(
			__( 'Import / Export Widgets', 'advanced-widget-control' ),
			__( 'Import / Export Widgets', 'advanced-widget-control' ),
			'manage_options',
			'widgetcontrol_migrator_settings',
            array( &$this, 'settings_page' )
		);
	}

    function settings_page() {
		?>
        <div class="wrap">
			<h1>
				<?php _e( 'Import or Export Widgets', 'advanced-widget-control' ); ?>
				<a href="<?php echo esc_url( admin_url( 'options-general.php?page=widgetcontrol_plugin_settings' ) );?>" class="page-title-action"><?php _e( 'Manage Advanced Widget Control', 'advanced-widget-control' );?></a>
			</h1>
			<div class="widgetcontrol-imex">
				<?php if( !empty( $this->imported ) ){ 
						global $wp_registered_sidebars;

						//move inactive widgets to bottom
						if( isset( $this->imported['wp_inactive_widgets'] ) ){
							$inactive = $this->imported['wp_inactive_widgets'];
							unset( $this->imported['wp_inactive_widgets'] );
							$this->imported['wp_inactive_widgets'] = $inactive;
						} ?>
						<div class="widgetcontrol-imex-imported-widgets widgetcontrol-imex-col">
							<h3><?php _e( 'Widget Import Results', 'advanced-widget-control' ); ?></h3>
							<p><?php 
								printf(
									wp_kses(
										__( 'Imported widgets displayed in their respective widget areas. Please take note that whenever the widget area is not available, the widget will be assigned automatically to Inactive Sidebar & Widgets for you to be able to still use them. To check and manage imported widgets go to <a href="%1$s">Appearance > Widgets</a>.', 'advanced-widget-control' ),
										array(
											'a' => array(
												'href' => array(),
											),
										)
									),
									esc_url( admin_url( 'widgets.php' ) )
								); ?></p>
							<?php foreach ( $this->imported as $sidebar_id => $sidebar ) {
								if( $sidebar_id == 'sidebars' ) continue;
								if ( !isset( $wp_registered_sidebars[ $sidebar_id ] ) && $sidebar_id != 'wp_inactive_widgets' ){
									continue;
								}
								if( isset( $sidebar['name'] ) ){
									echo '<h4>'. $sidebar['name'] .'</h4>';
								}
								if( isset( $sidebar['widgets'] ) && !empty( $sidebar['widgets'] ) ){
									echo '<ul>';
									foreach ( $sidebar['widgets'] as $widget_id => $widget ) { 

										?>
										
										<li class="widgetcontrol-imex-imported-<?php echo $widget['message_type'];?>">
											<span class="dashicons dashicons-<?php echo $widget['message_type'];?>"></span>
											<span class="widgetcontrol-imex-imported">
												<?php echo ( isset( $widget['title'] ) ) ? $widget['title'] : '';?>
												<span class="widgetcontrol-imex-wid"><?php echo $widget_id;?></span>
												<span class="widgetcontrol-imex-msg"><?php echo $widget['message'];?></span>
											</span>
										</li>

									<?php }
									echo '</ul>';
								}
							} ?>

						</div>
					<?php } ?>

				<div class="widgetcontrol-imex-col widgetcontrol-imex-col-1">
					<h3><?php _e( 'Export Widgets', 'advanced-widget-control' ); ?></h3>
					<p><?php _e( 'Click the button below to export all your website\'s widgets.', 'advanced-widget-control' ); ?></p>
					<form action="<?php echo esc_url( admin_url( basename( $_SERVER['PHP_SELF'] ) ) ); ?>" method="GET">
						<input type="hidden" name="page" value="<?php echo ( isset( $_GET['page'] ) ) ? sanitize_text_field( $_GET['page'] ) : 'widgetcontrol_migrator_settings';?>" />
						<input type="hidden" name="action" value="export" />
						<?php wp_nonce_field( 'widgeopts_export', 'widgeopts_nonce_export' ); ?>
						<p>
							<input type="checkbox" value="1" name="inactive" id="widgetcontrol-imex-ex" />
							<label for="widgetcontrol-imex-ex"><?php _e( 'Check this option if you wish to include inactive widgets', 'advanced-widget-control' ); ?></label>
						</p>
						<input type="submit" class="button button-primary" value="<?php _e( 'Export Widgets', 'advanced-widget-control' ); ?>" />
					</form>

				</div>


				<div class="widgetcontrol-imex-col">
					<h3><?php _e( 'Import Widgets', 'advanced-widget-control' ); ?></h3>
					<p><?php _e( 'Upload <strong>.json</strong> file that\'s generated by this plugin. Then manage the widgets to be imported.', 'advanced-widget-control' ); ?></p>
					
					<form method="POST" enctype="multipart/form-data">
						<input type="hidden" name="page" value="<?php echo ( isset( $_GET['page'] ) ) ? sanitize_text_field( $_GET['page'] ) : 'widgetcontrol_migrator_settings';?>" />
						<input type="hidden" name="action" value="import" />
						<?php wp_nonce_field( 'widgeopts_import', 'widgeopts_nonce_import' ); ?>
						<p>
							<input type="file" name="widgeopts_file" id="widgetcontrol-imex-file"/>
						</p>
						<input type="submit" class="button button-primary" value="<?php _e( 'Upload', 'advanced-widget-control' ); ?>" />
					</form>
				</div>

			</div>

		</div>
		<style type="text/css">
			.widgetcontrol-imex-col{ 
				float: left; 
				width: 48%; 
				background: #fff;
				border: 1px solid #e5e5e5;
				padding: 25px;
				box-sizing: border-box;
				margin-top: 30px; 
				min-height: 250px;
			}
			.widgetcontrol-imex-col-1{
				margin-right: 1.5%;
			}
			.widgetcontrol-imex-col.widgetcontrol-imex-imported-widgets{
				width: 97.5%;
				position: relative;
			}
			.widgetcontrol-imex-col h3{
				margin-top: 0px;
			}
			.widgetcontrol-imex-col p{
				margin-bottom: 25px;
			}
			.widgetcontrol-imex-col .button{
				font-size: 14px; 
				padding: 5px 20px;
			}
			.widgetcontrol-imex-imported-widgets li{
				padding-bottom: 10px;
			}
			.widgetcontrol-imex-imported-widgets li .dashicons{
				float: left;
			    font-size: 26px;
			    line-height: 40px;
			    height: 50px;
			    width: 31px;
			}
			.widgetcontrol-imex-imported-widgets .dashicons-no-alt{
				color:  #a53e3e;
			}
			.widgetcontrol-imex-imported-widgets .dashicons-warning{
				color:  #ec6c3b;
			}
			.widgetcontrol-imex-imported-widgets .dashicons-yes{
				color:  #46b450;
			}
			.widgetcontrol-imex-imported-widgets li .widgetcontrol-imex-wid,
			.widgetcontrol-imex-imported-widgets li .widgetcontrol-imex-msg{
				/* padding-left: 8px; */
				font-size: 12px;
				color:  #999;
			}
			.widgetcontrol-imex-imported-widgets li.widgetcontrol-imex-imported-yes .widgetcontrol-imex-msg{
				color:  #46b450;
			}
			.widgetcontrol-imex-imported-widgets li .widgetcontrol-imex-msg{
				display: block;
				color:  #a53e3e;
			}
			.widgetcontrol-imex-imported-widgets li label{
				vertical-align: unset;
			}
		</style>
    <?php }

    function admin_footer(){ ?>
    	<script type="text/javascript">
    		jQuery( document ).ready( function(){
    			jQuery( '#adminmenu .menu-icon-tools a[href="tools.php?page=widgetcontrol_migrator_settings"]' ).hide();
    		} );
    	</script>
    <?php }

    /**
	 * Generate export data
	 *
	 * @since 1.0
	 * @return string Export file contents
	 */
	function generate_export_data( $inactive = false , $single_sidebar = false ) {

		global $wp_registered_widgets;
	    $checked 		= array();
	    $sidebars_dummy = array();
	    
	    // Store all widgets in array
		$widget_instances = $this->get_widget_instances();

		// print_r( $this->get_available_widgets() );

		// get all sidebar widgets
		$sidebars_widgets 			= get_option( 'sidebars_widgets' );
		$sidebars_widget_instances 	= array();

		if( $single_sidebar && isset( $sidebars_widgets[ $single_sidebar ] ) ){
			$sidebars_dummy[ $single_sidebar ] = $sidebars_widgets[ $single_sidebar ];

			//switch to single sidebar
			$sidebars_widgets = $sidebars_dummy;
		}

		foreach ( $sidebars_widgets as $sidebar_id => $widgetids ) {

			// Skip inactive widgets.
			if ( !$inactive && 'wp_inactive_widgets' === $sidebar_id ) {
				continue;
			}

			// Skip not array or empty data
			if ( ! is_array( $widgetids ) || empty( $widgetids ) ) {
				continue;
			}

			// Loop widget IDs for this sidebar.
			foreach ( $widgetids as $widgetid ) {

				// Is there an instance for this widget ID?
				if ( isset( $widget_instances[ $widgetid ] ) ) {

					// Add to array.
					$sidebars_widget_instances[ $sidebar_id ][ $widgetid ] = $widget_instances[ $widgetid ];

				}

			}

		}

		$sidebars_widget_instances['widgetcontrol_exported'] = true;

		$data 		= apply_filters( 'widgetcontrol_unencoded_export_data', $sidebars_widget_instances );
		$encoded 	= wp_json_encode( $data );

		return apply_filters( 'widgetcontrol_exported_data', $encoded );
	}

	/**
	 * Export .json file with widgets data
	 */
	function export_json_file() {

		// Export requested.
		if ( isset( $_GET['action'] ) && 'export' == sanitize_text_field( $_GET['action'] ) ) {

			// Check referer before doing anything else.
			check_admin_referer( 'widgeopts_export', 'widgeopts_nonce_export' );

			$inactive 		= false;
			$single_sidebar = false;

			if( isset( $_GET['inactive'] ) && !empty( $_GET['inactive'] ) ){
				$inactive 	= true;
			}

			if ( isset( $_GET['single_sidebar'] ) && !empty( $_GET['single_sidebar'] ) ) {
				$single_sidebar = sanitize_text_field( $_GET['single_sidebar'] );
			}

			// Build filename similar with Widget Importer & Exporter Plugin but on json extension
			// Single Site: yoursite.com-widgets.json
			// Multisite: site.multisite.com-widgets.json or multisite.com-site-widgets.json.
			$site_url = site_url( '', 'http' );
			$site_url = trim( $site_url, '/\\' ); // Remove trailing slash.
			$filename = str_replace( 'http://', '', $site_url ); // Remove http://.
			$filename = str_replace( array( '/', '\\' ), '-', $filename ); // Replace slashes with - .

			if( $single_sidebar ){
				$filename .= '-' . $single_sidebar;
			}

			$filename .= '-widgets.json'; // Append.
			$filename = apply_filters( 'widgetcontrol_exported_file', $filename );


			$file_contents 	= $this->generate_export_data( $inactive, $single_sidebar );
			$filesize 		= strlen( $file_contents );

			// Headers to prompt "Save As".
			header( 'Content-Type: application/octet-stream' );
			header( 'Content-Disposition: attachment; filename=' . $filename );
			header( 'Expires: 0' );
			header( 'Cache-Control: must-revalidate' );
			header( 'Pragma: public' );
			header( 'Content-Length: ' . $filesize );

			// Clear buffering just in case.
			// @codingStandardsIgnoreLine
			@ob_end_clean();
			flush();

			// Output file contents.
			echo $file_contents;

			// Stop execution.
			exit;

		}

	}

	/**
	 * Import .json file with widgets data
	 */
	function import_json_file() {
		// Export requested.
		if ( !empty( $_POST ) && isset( $_POST['action'] ) && 'import' == sanitize_text_field( $_POST['action']  ) && check_admin_referer( 'widgeopts_import', 'widgeopts_nonce_import' ) ) {

			//allow .json upload
			add_filter( 'wp_check_filetype_and_ext', array( &$this, 'disable_real_mime_check' ), 10 , 4 );
			add_filter( 'upload_mimes', array( &$this, 'add_mime_types' ) );
			
			$uploaded_file  = $_FILES['widgeopts_file'];
			$wp_filetype 	= wp_check_filetype_and_ext( $uploaded_file['tmp_name'], $uploaded_file['name'], false );
			
			if ( 'json' !== $wp_filetype['ext'] && ! wp_match_mime_types( 'json', $wp_filetype['type'] ) ) {

				wp_die(
					wp_kses(
						__( 'Invalid File! Please upload Advanced Widget Control exported data.' . $wp_filetype['ext'], 'advanced-widget-control' ),
						array(
							'b' => array(),
						)
					),
					'',
					array(
						'back_link' => true,
					)
				);

			}

			// Check and move file to uploads directory
			$file_data = wp_handle_upload( $uploaded_file, array(
				'test_form' => false,
			) );

			if ( isset( $file_data['error'] ) ) {
				wp_die(
					esc_html( $file_data['error'] ),
					'',
					array(
						'back_link' => true,
					)
				);
			}

			// Check if file exists?
			if ( ! file_exists( $file_data['file'] ) ) {
				wp_die(
					esc_html__( 'Import file could not be found. Please try again.', 'advanced-widget-control' ),
					'',
					array(
						'back_link' => true,
					)
				);
			}

			// Get file contents and decode.
			$data = implode( '', file( $file_data['file'] ) );
			$data = json_decode( $data, true );

			// Delete import file.
			unlink( $file_data['file'] );

			if ( !is_array( $data ) || !isset( $data['widgetcontrol_exported'] ) ) {
				wp_die(
					esc_html__( 'Imported file invalid and not generated by Advanced Widget Control Plugin.', 'advanced-widget-control' ),
					'',
					array(
						'back_link' => true,
					)
				);
			}

			//assign to variable to be able to used on frontend
			$this->imported = $this->organized_imported_data( $data );
		}
	}

	/**
	 * 
	 * Parse imported data and compares to existing widgets
	 *
	 */
	function organized_imported_data( $data ){
		global $wp_registered_sidebars, $wp_registered_widgets;
	    
		//variables
	    $checked 			= array();
	    $inactive 			= false;
	    $supported_widgets 	= $this->supported_widgets();

	    //Add Inactive Widgets
	    $wpregistered_sidebars = $wp_registered_sidebars;
	    $wpregistered_sidebars['wp_inactive_widgets'] = array( 'name' => __( 'Inactive Sidebars & Widgets', 'advanced-widget-control'  ), 'id' => 'wp_inactive_widgets' );

		// Hook before import.
		do_action( 'widgetcontrol_before_render_import' );

		//create filter for developers
		$data = apply_filters( 'widgetcontrol_imported_data', $data );

		if( isset( $data['wp_inactive_widgets'] ) && !empty( $data['wp_inactive_widgets'] ) ){
			$inactive = true;
		}

		$widget_instances 	= json_decode( $this->generate_export_data( $inactive ), true );

		//remove placeholder
		unset( $data['widgetcontrol_exported'] );

		// Begin results.
		$results = array();

		// Loop imported data's sidebars.
		foreach ( $data as $sidebar => $widgets ) {

			// Check if sidebar is available on this site.
			if ( isset( $wpregistered_sidebars[ $sidebar ] ) ) {
				$is_sidebar_available = true;
				$sidebar_id       	  = $sidebar;
				$sidebar_message_type = 'yes';
				$sidebar_message      = '';
			} else {
				//add to inactive if sidebar not available
				$is_sidebar_available = false;
				$sidebar_id       	  = 'wp_inactive_widgets'; // Add to inactive if sidebar does not exist in theme.
				$sidebar_message_type = 'error';
				$sidebar_message      = esc_html__( 'Widget area does not exist in theme (using Inactive)', 'advanced-widget-control' );
			}

			// Result for sidebar
			// Sidebar name if theme supports it; otherwise ID.
			$results[ $sidebar ]['name']         = ! empty( $wpregistered_sidebars[ $sidebar ]['name'] ) ? $wpregistered_sidebars[ $sidebar ]['name'] : $sidebar;
			$results[ $sidebar ]['message_type'] = $sidebar_message_type;
			$results[ $sidebar ]['message']      = $sidebar_message;
			$results[ $sidebar ]['widgets']      = array();
			$results['sidebars'][ $sidebar ]     = $results[ $sidebar ]['name'];

			//Loop assigned widgets
			foreach ( $widgets as $widget_id => $widget ) {
				$fail = false;

				// Get id_base (remove -# from end) and instance ID number.
				$id_base            = preg_replace( '/-[0-9]+$/', '', $widget_id );
				$instance_id_number = str_replace( $id_base . '-', '', $widget_id );

				// Does site support this widget?
				if ( ! $fail && ! isset( $supported_widgets[ $id_base ] ) ) {
					$fail                = true;
					$widget_message_type = 'error';
					$widget_message 	 = esc_html__( 'Widget Type not available.', 'advanced-widget-control' ); // Explain why widget not imported.
				}

				//check if same widget already available
				if ( ! $fail && isset( $widget_instances[ $sidebar ][ $widget_id ] ) ) {
					//compare if same sidebar and widget id have same contents too
					if( $widget === $widget_instances[ $sidebar ][ $widget_id ] ){
						$fail 				 = true;
						$widget_message_type = 'no-alt';
						$widget_message 	 = esc_html__( 'Widget already exists', 'advanced-widget-control' );
					}
				}

				//double check if values exists with different widget keys
				if ( ! $fail && isset( $widget_instances[ $sidebar ] ) && is_array( $widget_instances[ $sidebar ] ) && in_array( $widget, $widget_instances[ $sidebar ] ) ) {
					$in_array_key 		 = array_search( $widget, $widget_instances[ $sidebar ] );
					$in_array_id_base    = preg_replace( '/-[0-9]+$/', '', $in_array_key );

					if( $id_base == $in_array_id_base ){
						$fail = true;
						$widget_message_type = 'no-alt';
						$widget_message 	 = esc_html__( 'Widget already exists', 'advanced-widget-control' );
					}
				}

				// No failure.
				if ( ! $fail ) {
					$get_widget_instances = get_option( 'widget_' . $id_base ); 
					$get_widget_instances = ! empty( $get_widget_instances ) ? $get_widget_instances : array(
						'_multiwidget' => 1,
					);

					// add widget values to instances - to update later
					$get_widget_instances[] = $widget;

					// Get the given key
					end( $get_widget_instances );
					$new_instance_number = key( $get_widget_instances );

					// Change number to 1 when it's 0 to avoid issues
					if ( '0' === strval( $new_instance_number ) ) {
						$new_instance_number = 1;
						$get_widget_instances[ $new_instance_number ] = $get_widget_instances[0];
						unset( $get_widget_instances[0] );
					}

					// Change widget options key to the given id_base and number to work perfectly
					if( isset( $get_widget_instances[ $new_instance_number ] ) && isset( $get_widget_instances[ $new_instance_number ]['advanced_widget_control'] ) ){
						$get_widget_instances[ $new_instance_number ]['advanced_widget_control-' . $id_base . '-' . $new_instance_number] = $get_widget_instances[ $new_instance_number ]['advanced_widget_control'];
						unset( $get_widget_instances[ $new_instance_number ]['advanced_widget_control'] );
					}

					// Move _multiwidget to the end
					if ( isset( $get_widget_instances['_multiwidget'] ) ) {
						$multiwidget = $get_widget_instances['_multiwidget'];
						unset( $get_widget_instances['_multiwidget'] );
						$get_widget_instances['_multiwidget'] = $multiwidget;
					}

					// Update option with new widget.
					update_option( 'widget_' . $id_base, $get_widget_instances );

					// Get sidebar widgets
					$sidebars_widgets = get_option( 'sidebars_widgets' );

					// Avoid error when empty
					if ( ! $sidebars_widgets ) {
						$sidebars_widgets = array();
					}

					// Use ID number from new widget instance.
					$new_instance_id = $id_base . '-' . $new_instance_number;

					// Add new instance to sidebar.
					$sidebars_widgets[ $sidebar ][] = $new_instance_id;

					// Save new sidebar widgets options
					update_option( 'sidebars_widgets', $sidebars_widgets );

					// Success message.
					if ( $is_sidebar_available ) {
						$widget_message_type = 'yes';
						$widget_message      = esc_html__( 'Successfully Imported', 'advanced-widget-control' );
					} else {
						$widget_message_type = 'warning';
						$widget_message      = esc_html__( 'Sidebar Widget Area Not Available', 'advanced-widget-control' );
					}
				}

				// Result for widget instance
				$results[ $sidebar_id ]['widgets'][ $widget_id ]['name'] = isset( $available_widgets[ $id_base ]['name'] ) ? $available_widgets[ $id_base ]['name'] : $id_base; 
				$results[ $sidebar_id ]['widgets'][ $widget_id ]['title']        = ! empty( $widget['title'] ) ? $widget['title'] : esc_html__( 'No Title', 'advanced-widget-control' );
				$results[ $sidebar_id ]['widgets'][ $widget_id ]['message_type'] = $widget_message_type;
				$results[ $sidebar_id ]['widgets'][ $widget_id ]['message']      = $widget_message;

			}

		} //endforeach

		// Hook after import.
		do_action( 'widgetcontrol_after_render_import' );

		// Return results.
		return $this->imported = apply_filters( 'widgetcontrol_imported_results', $results );

	}

	function get_widget_instances(){
		global $wp_registered_widgets;
	    $checked = array();
	    
	    // Store all widgets in array
		$widget_instances = array();

	   	foreach ( $wp_registered_widgets as $widget ) {
		   $id_base = is_array( $widget['callback'] ) ? $widget['callback'][0]->id_base : '';
		   $opts = array();
			if( !empty( $id_base ) ){
				$instance = get_option( 'widget_' . $id_base );
			}

			$number = $widget['params'][0]['number'];
			if ( ! isset( $instance[ $number ] ) ) {
				continue;
			}

			$widget_id = $id_base . '-' . $number;

			//bypass if widget id already checked
			if ( isset( $checked[ $widget_id ] ) ) {
			   	continue;
		   	}
		   	$checked[ $widget_id ] = '1';
		   	$k = 'advanced_widget_control-'. $widget_id;
			if( isset( $instance[ $number ][ $k ] ) ){

				//unset id_base
				if( isset( $instance[ $number ][ $k ]['id_base'] ) ){
					unset( $instance[ $number ][ $k ]['id_base']  );
				}

				$instance[ $number ]['advanced_widget_control'] = $instance[ $number ][ $k ];
				unset( $instance[ $number ][ $k ] );
			}
			$widget_instances[ $widget_id ] = $instance[ $number ];
		}

		return apply_filters( 'widgetcontrol_widget_instances', $widget_instances );
	}

	function supported_widgets() {

		global $wp_registered_widget_controls;

		$widget_controls = $wp_registered_widget_controls;

		$available_widgets = array();

		foreach ( $widget_controls as $widget ) {

			// No duplicates.
			if ( ! empty( $widget['id_base'] ) && ! isset( $available_widgets[ $widget['id_base'] ] ) ) {
				$available_widgets[ $widget['id_base'] ]['id_base'] = $widget['id_base'];
				$available_widgets[ $widget['id_base'] ]['name']    = $widget['name'];
			}

		}

		return apply_filters( 'widgetcontrol_supported_widgets', $available_widgets );

	}

	/**
	 * Add mime type for upload
	 *
	 * Make sure the WordPress install will accept .json uploads.
	 *
	 */
	function add_mime_types( $mime_types ) {

		$mime_types['json'] = 'application/json';

		return $mime_types;

	}

	function disable_real_mime_check( $data, $file, $filename, $mimes ) {
		$wp_version = get_bloginfo( 'version' );
		
		if ( version_compare( $wp_version, '4.7', '<=' ) ) {
			return $data;
		}
		$wp_filetype = wp_check_filetype( $filename, $mimes );
		$ext             = $wp_filetype['ext'];
		$type            = $wp_filetype['type'];
		$proper_filename = $data['proper_filename'];
		return compact( 'ext', 'type', 'proper_filename' );
	}
}

new WP_Advanced_Widget_Control_Importer();

endif;
