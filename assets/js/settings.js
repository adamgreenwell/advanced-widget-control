"use strict";

var widgetcontrolSettingsModule = {
	init: function() {
		var self 	= this;
        jQuery( '.widgetcontrol-module-settings-container' ).hide();

		self.bindEvents();
    },

	bindEvents: function() {
		var self 	= this;
		var $wpcontent = jQuery( '#wpcontent' );

		$wpcontent.on( 'click', '.widgetcontrol-toggle-settings, .widgetcontrol-module-settings-cancel', self.openModal );
		$wpcontent.on( 'click', '.widgetcontrol-close-modal, .widgetcontrol-modal-background', self.closeModal );
		$wpcontent.on( 'keyup', self.closeModal );
		$wpcontent.on( 'click', '.widgetcontrol-toggle-activation', self.moduleToggle );
		$wpcontent.on( 'click', '.widgetcontrol-module-settings-save', self.saveSettings );
		$wpcontent.on( 'click', '.opts-add-class-btn', self.toggleCustomClass );
		$wpcontent.on( 'click', '.opts-remove-class-btn', self.removeCustomClass );
		$wpcontent.on( 'click', '.widgetcontrol-delete-cache', self.clearWidgetCache );
		$wpcontent.on( 'click', '.widgetcontrol-license_deactivate', self.deactivationHandler );

	},

	openModal: function( e ) {
		e.preventDefault();

		var $container = jQuery(this).parents( '.widgetcontrol-module-card' ).find( '.widgetcontrol-module-settings-container' ),
			$modalBg = jQuery( '.widgetcontrol-modal-background' );

		$modalBg.show();
		$container
			.show();

		jQuery( 'body' ).addClass( 'widgetcontrol-modal-open' );
	},

	closeModal: function( e ) {
		if ( 'undefined' !== typeof e ) {
			e.preventDefault();

			// For keyup events, only process esc
			if ( 'keyup' === e.type && 27 !== e.which ) {
				return;
			}
		}

		jQuery( '.widgetcontrol-modal-background' ).hide();
		jQuery( '.widgetcontrol-module-settings-container' ).hide();
		jQuery( 'body' ).removeClass( 'widgetcontrol-modal-open' );
	},

	moduleToggle: function( e ) {
		e.preventDefault();
		e.stopPropagation();

		var $button = jQuery(this),
			$card = $button.parents( '.widgetcontrol-module-card' ),
			$buttons = $card.find( '.widgetcontrol-toggle-activation' ),
			module = $card.attr( 'data-module-id' );

		$buttons.prop( 'disabled', true );

		if ( $button.html() == widgetcontrol.translation.activate ) {
			var method = 'activate';
		} else {
			var method = 'deactivate';
		}

		widgetcontrolSettingsModule.ajaxRequest( module, method, {}, widgetcontrolSettingsModule.moduleCallback );
	},

	moduleCallback: function( results ) {
		var module = results.module;
		var method = results.method;

		var $card = jQuery( '#widgetcontrol-module-card-' + module ),
			$buttons = $card.find( '.widgetcontrol-toggle-activation' );

		if ( results.errors.length > 0 ) {
			$buttons
				.html( widgetcontrol.translations.error )
				.addClass( 'button-secondary' )
				.removeClass( 'button-primary' );

			setTimeout( function() {
				widgetcontrolSettingsModule.isModuleActive( module );
			}, 1000 );

			return;
		}

		if ( 'activate' === method ) {
			$buttons
				.html( widgetcontrol.translation.deactivate )
				.addClass( 'button-secondary' )
				.removeClass( 'button-primary' )
				.prop( 'disabled', false );

			$card
				.addClass( 'widgetcontrol-module-type-enabled' )
				.removeClass( 'widgetcontrol-module-type-disabled' );
                
            if( $card.hasClass('no-settings') ) {
                var newToggleSettingsLabel = widgetcontrol.translation.show_description;
            } else {
                var newToggleSettingsLabel = widgetcontrol.translation.show_settings;
            }
			
		} else {
			$buttons
				.html( widgetcontrol.translation.activate )
				.addClass( 'button-primary' )
				.removeClass( 'button-secondary' )
				.prop( 'disabled', false );

			$card
				.addClass( 'widgetcontrol-module-type-disabled' )
				.removeClass( 'widgetcontrol-module-type-enabled' );
            
			var newToggleSettingsLabel = widgetcontrol.translation.show_description;
		}
        
		// if( !$card.hasClass('widgetcontrol-module-card-no-settings') ){
			$card.find( '.widgetcontrol-toggle-settings' ).html( newToggleSettingsLabel );
		// }
	},

	saveSettings: function( e ) {
		e.preventDefault();

		var $button = jQuery(this);

		if ( $button.hasClass( 'widgetcontrol-module-settings-save' ) ) {
			var module = $button.parents( '.widgetcontrol-module-card' ).attr( 'data-module-id' );
		} else {
			var module = '';
		}

		$button.prop( 'disabled', true );

		var data = {
			'--widgetcontrol-form-serialized-data': jQuery( '#widgetcontrol-module-settings-form' ).serialize()
		};

		widgetcontrolSettingsModule.ajaxRequest( module, 'save', data, widgetcontrolSettingsModule.savingCallback );
	},

	savingCallback: function( results ) {
		if ( '' === results.module ) {
			jQuery( '#widgetcontrol-save' ).prop( 'disabled', false );
		} else {
			jQuery( '#widgetcontrol-module-card-' + results.module + ' button.widgetcontrol-module-settings-save' ).prop( 'disabled', false );
		}

		var $container = jQuery( '.widgetcontrol-module-cards-container' );
		var view = 'grid';

		// console.log( results );
		widgetcontrolSettingsModule.clearMessages();
		if ( results.errors.length > 0 || ! results.closeModal ) {
			widgetcontrolSettingsModule.showMessages( results.messages, results.module, 'open' );
			$container.find( '.widgetcontrol-module-settings-content-container:visible' ).animate( {'scrollTop': 0}, 'fast' );

		} else {
			widgetcontrolSettingsModule.showMessages( results.messages, results.module, 'closed' );
			$container.find( '.widgetcontrol-module-settings-content-container:visible' ).scrollTop( 0 );
			widgetcontrolSettingsModule.closeModal();
		}
	},

	clearMessages: function() {
		jQuery( '#widgetcontrol-settings-messages-container, .widgetcontrol-module-messages-container' ).empty();
	},

	showMessages: function( messages, module, containerStatus ) {
		jQuery.each( messages, function( index, message ) {
			widgetcontrolSettingsModule.showMessage( message, module, containerStatus );
		} );
	},

	showMessage: function( message, module, containerStatus ) {
		var view = 'grid';

		if ( 'closed' !== containerStatus && 'open' !== containerStatus ) {
			containerStatus = 'closed';
		}

		if ( 'string' !== typeof module ) {
			module = '';
		}

		if ( 'closed' === containerStatus || '' === module ) {
			var container = jQuery( '#widgetcontrol-settings-messages-container' );

			setTimeout( function() {
				container.removeClass( 'visible' );
				setTimeout( function() {
					container.find( 'div' ).remove();
				}, 500 );
			}, 4000 );
		} else {
			var container = jQuery( '#widgetcontrol-module-card-' + module + ' .widgetcontrol-module-messages-container' );
		}

		container.append( '<div class="updated fade"><p><strong>' + message + '</strong></p></div>' ).addClass( 'visible' );
	},


	ajaxRequest: function( module, method, data, callback ) {
		var postData = {
			'action': widgetcontrol.ajax_action,
			'nonce':  widgetcontrol.ajax_nonce,
			'module': module,
			'method': method,
			'data':   data,
		};

		jQuery.post( ajaxurl, postData )
			.always(function( a, status, b ) {
				widgetcontrolSettingsModule.processAjaxResponse( a, status, b, module, method, data, callback );
			});
	},

	processAjaxResponse: function( a, status, b, module, method, data, callback ) {
		var results = {
			'module':        module,
			'method':        method,
			'data':          data,
			'status':        status,
			'license_status': null,
			'jqxhr':         null,
			'success':       false,
			'response':      null,
			'button':      	 null,
			'errors':        [],
			'messages':      [],
			'functionCalls': [],
			'redirect':      false,
			'closeModal':    true
		};
		// console.log( a );

		a = jQuery.parseJSON( a  );

		if ( 'WIDGETCONTROL_Response' === a.source && 'undefined' !== a.response ) {
			// Successful response with a valid format.
			results.jqxhr = b;
			results.success = a.success;
			results.response = a.response;
			results.errors = a.errors;
			results.messages = a.messages;
			results.functionCalls = a.functionCalls;
			results.redirect = a.redirect;
			results.closeModal = a.closeModal;
			results.button = a.button;

			if( typeof results.license_status != 'undefined' ){
				results.license_status = a.license_status;
			}
		}

		if ( 'function' === typeof callback ) {
			callback( results );
		} else if ( 'function' === typeof console.log ) {
			console.log( 'ERROR: Unable to handle settings AJAX request due to an invalid callback:', callback, {'data': postData, 'results': results} );
		}

	},

	toggleCustomClass: function(e){
		var getVal = jQuery('.opts-add-class-txtfld').val();
		var fname = 'extwopts_class_settings[classlists][]';
		if( jQuery(this).hasClass('widgetcontrol-add-class-btn') ){
			fname = 'classes[classlists][]';
		}
		if( getVal.length > 0 ){
			jQuery('#opts-predefined-classes ul').append('<li><input type="hidden" name="'+ fname +'" value="'+ getVal +'" /><span class"opts-li-value">'+ getVal +'</span> <a href="#" class="opts-remove-class-btn"><span class="dashicons dashicons-dismiss"></span></a></li>');
			jQuery('.opts-add-class-txtfld').val('');
		}

		e.preventDefault();
		e.stopPropagation();
	},

	removeCustomClass: function(e){
		jQuery(this).parent('li').fadeOut('fast',function(){
			jQuery(this).remove();
		});
		e.preventDefault();
		e.stopPropagation();
	},

	clearWidgetCache: function( e ){
		var $button = jQuery(this);
		$button.prop( 'disabled', true );

		widgetcontrolSettingsModule.ajaxRequest( 'clear_cache', 'clear_cache', '', widgetcontrolSettingsModule.clearWidgetCacheCallback );
		return false;
	},
	clearWidgetCacheCallback: function( results ){
		if( typeof results.response != 'undefined' ){
			jQuery( '.widgetcontrol-delete-cache' ).after( '<span class="dashicons dashicons-yes widgetcontrol-cache-dashicons"></span>' );
			jQuery( '.widgetcontrol-cache-dashicons' ).delay(2000).fadeOut(400);
			jQuery( '.widgetcontrol-delete-cache' ).prop( 'disabled', false );
		}
	},

	deactivationHandler: function(e){
		e.preventDefault();

		var fld;
		var $button = jQuery(this);
		$button.prop( 'disabled', true );

		fld = jQuery( '#' + $button.attr('data-target') );
		if( fld.val() != '' ){
			var data = {
				'license-data': fld.val(),
				'license-action': 'deactivate',
				'shortname' : $button.attr('data-shortname'),
				'button': $button.attr('id')
			};

			widgetcontrolSettingsModule.ajaxRequest( 'license_key', 'deactivate_license', data, widgetcontrolSettingsModule.licenseDeactivationCallback );
		} else {
			fld.css({ 'border' : '1px solid red' });
			$button.prop( 'disabled', false );
		}
	},

	licenseDeactivationCallback: function( results ){
		// console.log( results ); widgetcontrol-license-extended-response
		if( typeof results.response != 'undefined' && typeof results.messages != 'undefined' && typeof results.button != 'undefined' ){
			var $button = jQuery( '#' + results.button );

			jQuery( '#' + $button.attr('data-target') ).before( '<span>' + results.messages[0] + '</span>' );
			if( results.success == 'deactivated' ){
				$button.parent('td').parent('tr').fadeOut();
				jQuery( '#' + $button.attr('data-target') ).val('');
			}
		} else {
			// jQuery('.widgetcontrol-license-key').css({ 'border' : '1px solid red' });
			// jQuery('.widgetcontrol-license-status').fadeIn();
		}

		$button.prop( 'disabled', false );

	}
}

jQuery(document).ready(function() {
	widgetcontrolSettingsModule.init();
});
