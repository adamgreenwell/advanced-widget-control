/*global ajaxurl, isRtl */
var wpWidgetOpts;
(function($) {
	var $document = $( document );

wpWidgetOpts = {
	/**
	 * A closed Sidebar that gets a Widget dragged over it.
	 *
	 * @var element|null
	 */
	hoveredSidebar: null,

	init : function() {
		var self  			= this,
			title 			= $( '.wp-admin.widgets-php .wrap a.page-title-action' ),
			tabs  			= $( '.advanced-widget-control-tabs' ),
			chooser 		= $( '.widgetsopts-chooser' ),
			selectSidebar 	= chooser.find( '.widgetcontrol-chooser-sidebars' );
			// ta = chooser.find('.widgets-chooser-sidebars'),
			// sidebars = $('div.widgets-sortables'),
			// isRTL = !! ( 'undefined' !== typeof isRtl && isRtl );

			if( tabs.length > 0 ){
				self.loaded( '', 'loaded' );
			}

			//runs on customizer
			$( '.widget-liquid-right .widget, .inactive-sidebar .widget, #accordion-panel-widgets .customize-control-widget_form' ).each(function (i, widget) {
				self.loaded( '', 'loaded' );
			});

			//fires when widget added
			$document.on( 'widget-added', function( event, widget ) {
			    self.loaded( widget, 'added' );
			});

			//fires when widget updated
			$document.on( 'widget-updated', function( event, widget ) {
			    self.loaded( widget, 'updated' );
			});

			//toggle accordions
			$document.on( 'click', '.advanced-widget-control-inner-lists h4',function(){
				var getid = $(this).attr('id');
				$( '.advanced-widget-control-inner-lists .'+ getid ).slideToggle(250);
			} );

			//toggle widget logic notice
			$document.on( 'click', '.widget-ctrl-toggler-note',function(e){
				$( this ).parent( 'p' ).parent( '.widget-ctrl-logic' ).find( '.widget-ctrl-toggle-note' ).slideToggle( 250 );
				e.preventDefault();
				e.stopPropagation();
			} );

			//live search filter
			self.live_search();

			//append move and clone button to .widget-control-actions
			$( '.widget-control-actions .alignleft .widget-control-remove' ).after( widgetcontrol10n.controls );

			//chooser for move and clone action
			self.do_chooser( chooser, selectSidebar );

			//add sidebar options
			self.sidebarOptions();
			self.removeSidebarWidgets();
			self.initPageDropdown('');
			self.initTaxonomyDropdown('');

	},
	loaded : function( widget, action ){
		var widget_id,
		selected 			= 0,
		selected_styling 	= 0,
		selected_main 		= 0,
		selected_visibility = 0,
		selected_settings 	= 0,
		in_customizer 		= false,
		tabs 				= '.advanced-widget-control-tabs',
		styling_tabs 		= '.advanced-widget-control-styling-tabs',
		visibility_main 	= '.advanced-widget-control-visibility-m-tabs',
		visibility_tabs 	= '.advanced-widget-control-visibility-tabs',
		settings_tabs 		= '.advanced-widget-control-settings-tabs',
		selectedtab			= '#advanced-widget-control-selectedtab',
		selectedstyling		= '#advanced-widget-control-styling-selectedtab',
		selectedmain		= '#advanced-widget-control-visibility-m-selectedtab',
		selectedvisibility	= '#advanced-widget-control-visibility-selectedtab',
		selectedsettings	= '#advanced-widget-control-settings-selectedtab';

		// check for wp.customize return boolean
	    if ( typeof wp !== 'undefined' ) {
	        in_customizer =  typeof wp.customize !== 'undefined' ? true : false;
	    }
		if( ''	!=	widget ){
			widget_id = '#' + widget.attr('id');

			if( $( widget_id ).find( selectedtab ).length > 0 ){
				selected = $( '#' + widget.attr('id') ).find( selectedtab ).val();
				selected = parseInt( selected );
			}

			if( $( widget_id ).find( selectedvisibility ).length > 0 ){
				selected_visibility = $( '#' + widget.attr('id') ).find( selectedvisibility ).val();
				selected_visibility = parseInt( selected_visibility );
			}

			if( $( widget_id ).find( selectedmain ).length > 0 ){
				selected_main = $( '#' + widget.attr('id') ).find( selectedmain ).val();
				selected_main = parseInt( selected_main );
			}

			if( $( widget_id ).find( selectedsettings ).length > 0 ){
				selected_settings = $( '#' + widget.attr('id') ).find( selectedsettings ).val();
				selected_settings = parseInt( selected_settings );
			}
			// console.log( in_customizer );
		}
		if( action == 'added' ){
			selected 			= 0;
			selected_main 		= 0,
			selected_visibility = 0;
			selected_settings 	= 0;
		}

	    if( '' != widget ){
	    	if( $( widget_id ).find( tabs ).length > 0 ){
	    		$( widget_id ).find( tabs ).tabs({ active: selected });
	    	}
	    	if( $( widget_id ).find( visibility_main ).length > 0 ){
	    		$( widget_id ).find( visibility_main ).tabs({ active: selected_main });
	    	}
	    	if( $( widget_id ).find( visibility_tabs ).length > 0 ){
	    		$( widget_id ).find( visibility_tabs ).tabs({ active: selected_visibility });
	    	}
	    	if( $( widget_id ).find( settings_tabs ).length > 0 ){
	    		$( widget_id ).find( settings_tabs ).tabs({ active: selected_settings });
	    	}
	    } else {
	    	$( tabs ).tabs({ active: selected });
	    	$( styling_tabs ).tabs({ active: selected_styling });
	    	$( visibility_main ).tabs({ active: selected_main });
	    	$( visibility_tabs ).tabs({ active: selected_visibility });
	    	$( settings_tabs ).tabs({ active: selected_settings });
	    }

	    $( tabs ).click('tabsselect', function (event, ui) {
			if( $(this).find( selectedtab ).length > 0 ){
				$(this).find( selectedtab ).val( $(this).tabs('option', 'active') );
			}
		});

		$( visibility_tabs ).click('tabsselect', function (event, ui) {
			if( $(this).find( selectedvisibility ).length > 0 ){
				$(this).find( selectedvisibility ).val( $(this).tabs('option', 'active') );
			}
		});

		$( visibility_main ).click('tabsselect', function (event, ui) {
			if( $(this).find( selectedmain ).length > 0 ){
				$(this).find( selectedmain ).val( $(this).tabs('option', 'active') );
			}
		});

		$( settings_tabs ).click('tabsselect', function (event, ui) {
			if( $(this).find( selectedsettings ).length > 0 ){
				$(this).find( selectedsettings ).val( $(this).tabs('option', 'active') );
			}
		});

		this.initPageDropdown(widget_id);
		this.initTaxonomyDropdown(widget_id);
	},
	live_search : function(){
		if ( typeof $.fn.liveFilter !== 'undefined' && $( '#widgetcontrol-widgets-search' ).length > 0 ) {
			// Add separator to distinguish between visible and hidden widgets
			$('.widget:last-of-type').after('<div class="widgetcontrol-separator" />');

			// Add data attribute for order to each widget
			$('#widgets-left .widget').each(function() {
				var index = $(this).index() + 1;
				$(this).attr( 'data-widget-index', index );
			});

			// Add liveFilter : credits to https://wordpress.org/plugins/widget-search-filter/ plugin
			$('#widgets-left').liveFilter('#widgetcontrol-widgets-search', '.widget', {
				filterChildSelector: '.widget-title h4, .widget-title h3',
				after: function(contains, containsNot) {

					// Move all hidden widgets to end.
					containsNot.each(function() {
						$(this).insertAfter($(this).parent().find('.widgetcontrol-separator'));
					});

					// Sort all visible widgets by original index
					contains.sort(function(a,b) {
						return a.getAttribute('data-widget-index') - b.getAttribute('data-widget-index');
					});

					// Move all visible back
					contains.each(function() {
						$(this).insertBefore($(this).parent().find('.widgetcontrol-separator'));
					});

				}
			});

			//add clear search
			$( '#wpbody-content' ).on( 'keyup', '.widgetcontrol-widgets-search', function(e){
				p = $(this).parent().find( '.widgetcontrol-clear-results' );
				if ( '' !== $(this).val() ) {
					p.addClass( 'widgetcontrol-is-visible' );
				} else {
					p.removeClass( 'widgetcontrol-is-visible' );
				}
			} );

			$( '#wpbody-content' ).on( 'click', '.widgetcontrol-clear-results', function(e){
				s = $(this).parent().find( '.widgetcontrol-widgets-search' );
				s.val( '' ).focus().trigger( 'keyup' );

				if( s.attr( 'id' ) == 'widgetcontrol-search-chooser' ){
					$( '.widgets-chooser-sidebars li:not(:first)' ).removeClass( 'widgets-chooser-selected' );
				}else if( s.hasClass('widgetsopts-widgets-search') ){
					$( '.widgetcontrol-chooser-sidebars li:not(:first)' ).removeClass( 'widgetcontrol-chooser-selected' );
				}

				e.preventDefault();
				e.stopPropagation();
				return false;
			} );

			//add sidebar chooser search field
			$('.widgets-chooser').prepend( widgetcontrol10n.search_form );
			//live filter
			$('.widgets-chooser').liveFilter('#widgetcontrol-search-chooser', '.widgets-chooser-sidebars li', {
				// filterChildSelector: 'li',
				after: function( contains, containsNot ) {
					//hide
					containsNot.each(function() {
						$(this).addClass( 'widgetcontrol-is-hidden' ).removeClass( 'widgets-chooser-selected' );
					});
					contains.each(function() {
						$(this).removeClass( 'widgetcontrol-is-hidden' ).removeClass( 'widgets-chooser-selected' );
					});
					if( contains.length > 0 ){
						$( contains[0] ).addClass( 'widgets-chooser-selected' );
					}

				}
			});

		}
	},
	do_chooser : function( chooser, selectSidebar ){
		var self = this;

		//add sidebar lists on chooser
		$( '#widgets-right .widgets-holder-wrap' ).each( function( index, element ) {
			var $element 	= $( element ),
				name 		= $element.find( '.sidebar-name h2' ).text(),
				id 			= $element.find( '.widgets-sortables' ).attr( 'id' ),
				li 			= $('<li tabindex="0">').text(name.trim());

			if ( index === 0 ) {
				li.addClass( 'widgetcontrol-chooser-selected' );
			}

			selectSidebar.append( li );
			li.attr( 'data-sidebarId', id );
		});

		//do click
		$document.on( 'click', '.widgetcontrol-control', function(e){
			var lbl = $(this).text(),
			action  = $( this ).attr( 'data-action' );

			if( $(this).hasClass( 'widgetcontrol-control-open' ) ){
				self.closeChooser();
				$( '.widgetcontrol-control-open' ).removeClass( 'widgetcontrol-control-open' );
			} else {

				chooser.find( '.widgetcontrol-chooser-action span' ).text( lbl );
				chooser.find( '.widgetcontrol-chooser-action' ).attr( 'data-action', action );
	            $(this).parents('.widget-control-actions').find('.clear').after( chooser );

				chooser.slideDown( 300, function() {
					selectSidebar.find('.widgets-chooser-selected').focus();
				});
				$( '.widgetcontrol-control-open' ).removeClass( 'widgetcontrol-control-open' );
				$(this).addClass( 'widgetcontrol-control-open' );

				self.chooserSearch();
			}

            e.preventDefault();
        } );

		//add selected on click
		$document.on( 'click', '.widgetcontrol-chooser-sidebars li', function(e){
            selectSidebar.find('.widgetcontrol-chooser-selected').removeClass( 'widgetcontrol-chooser-selected' );
			$(this).addClass( 'widgetcontrol-chooser-selected' );
        } );

		//do action
		$document.on( 'click', '.widgetsopts-chooser .widgetcontrol-chooser-action', function(e){
            var $container 	= $( 'html,body' ),
			$action 		= $( this ).attr( 'data-action' ),
			parentSidebar 	= $( this ).parents('.widgets-sortables').attr('id'),
            widgetID 		= $( this ).parents('.widget').attr('id'),
			$widget			= $( '#'+ widgetID );
            sidebarID 		= $( '.widgetcontrol-chooser-selected' ).attr('data-sidebarId');
			// console.log( $action + ' ' + parentSidebar +' ' + widgetID + ' ' + sidebarID);
			//remove chooser
			$( '#'+ widgetID + ' .widgetsopts-chooser' ).remove();
			$widget.find(' .widgetcontrol-control-open' ).removeClass( 'widgetcontrol-control-open' );

			switch ( $action ) {
				case 'move':
					$( '#' + parentSidebar ).find( '#' + widgetID ).appendTo( '#' + sidebarID );

					$('#' + sidebarID).sortable('refresh');
		            $widget.addClass( 'widgetcontrol-move-ds' );
		            $( '#' + sidebarID ).parent('.widgets-holder-wrap').removeClass( 'closed' );
					wpWidgets.save( $( '#' + widgetID ), 0, 0, 1 );
					break;
				default:
					break;

			}

			var $scrollTo = $( '.widgetcontrol-move-ds' );

            $container.animate({ scrollTop: $scrollTo.offset().top - ( $container.offset().top + $container.scrollTop() + 60 ) }, 200 );
			$( '.widgetcontrol-move-ds' ).removeClass( '.widgetcontrol-move-ds' );
            e.preventDefault();
        } );

		//cancel chooser
		$document.on( 'click', '.widgetsopts-chooser .widgetsopts-chooser-cancel', function(e){
			self.closeChooser( chooser );
			e.preventDefault();
		} );
	},
	closeChooser : function( chooser ) {
		var self = this;

		$( '.widgetsopts-chooser' ).slideUp( 200, function() {
			$( '.widgetcontrol-control' ).removeClass( 'widgetcontrol-control-open' );
			$( '#wpbody-content' ).append( this );
		});
	},
	chooserSearch : function(){
		//add livefilter
		if( $( '#widgetsopts-widgets-search' ).length > 0 ){
			$('.widgetsopts-chooser').liveFilter('#widgetsopts-widgets-search', '.widgetcontrol-chooser-sidebars li', {
				// filterChildSelector: 'li',
				after: function( contains, containsNot ) {
					//hide
					containsNot.each(function() {
						$(this).addClass( 'widgetcontrol-is-hidden' ).removeClass( 'widgetcontrol-chooser-selected' );
					});
					contains.each(function() {
						$(this).removeClass( 'widgetcontrol-is-hidden' ).removeClass( 'widgetcontrol-chooser-selected' );
					});
					if( contains.length > 0 ){
						$( contains[0] ).addClass( 'widgetcontrol-chooser-selected' );
					}

				}
			});
		}
	},
	sidebarOptions : function(){
		var self = this;
		if( widgetcontrol10n.sidebaropts.length > 0 ){
			$( '#widgets-right .widgets-holder-wrap' ).each( function( index, element ) {
				var sidebar_opts_h2 = $(this).find('.widgets-sortables h2').text();
				dl_link = widgetcontrol10n.sidebaropts.replace( '__sidebaropts__', $(this).find('.widgets-sortables').attr('id') );
				dl_link = dl_link.replace( '__sidebar_opts__', sidebar_opts_h2.trim() );
				$(this).append( dl_link );
			});
		}
	},
	removeSidebarWidgets : function(){
		var self = this;
		var $container 	= $( 'html,body' );
		$document.on( 'click', '.sidebaropts-clear', function(e){
			//show confirmation
			$(this).parent().find( '.sidebaropts-confirm' ).addClass( 'sidebaropts-confirmed' );
			$(this).parent().find( '.sidebaropts-confirm' ).slideToggle(250);

			e.preventDefault();
		});

		$document.on( 'click', '.sidebaropts-confirmed .button', function(e){
			sidebar_id = $(this).parent().parent().parent().find('.widgets-sortables');
			
			if( $(this).hasClass( 'button-primary' ) ){
				var $scrollTo = sidebar_id;

				$(this).parent().slideToggle(50);
				$container.animate({ scrollTop: $scrollTo.offset().top - 50 }, 200 );

				sidebar_id.find( '.widget' ).each( function( index, element ) {
					$( element ).fadeOut();
					wpWidgets.save( $( element ), 1, 1, 0 );
				});

			} else {
				$(this).parent().slideToggle(250);
			}

			e.preventDefault();
		});
	},
	initPageDropdown : function(widget_id) {
		var args = {
			ajax: {
		    	url: widgetcontrol10n.ajax_url,
		    	dataType: 'json',
		    	delay: 250,
		    	type: 'POST',
		    	data: function (params) {
			    	var query = {
			        	action: 'widgetcontrol_ajax_page_search',
			        	term: params.term
			      	}

			      	return query;
			    }
		  	},
		  	placeholder: 'Search for Pages',
		  	minimumInputLength: 3,
		  	language: {
		        searching: function() {
		            return 'Searching...';
		        }
		    },
		}

		if ( widget_id != '' ) {
			$( widget_id ).find( '.advanced-widget-control-select2-page-dropdown' ).select2(args);
		}
		else {
			$( '.widget-liquid-right .advanced-widget-control-select2-page-dropdown' ).select2(args);
		}
	},
	initTaxonomyDropdown : function(widget_id) {
		var args = {
			ajax: {
		    	url: widgetcontrol10n.ajax_url,
		    	dataType: 'json',
		    	delay: 250,
		    	type: 'POST',
		    	data: function (params) {
			    	var query = {
			        	action: 'widgetcontrol_ajax_taxonomy_search',
			        	term: params.term,
			        	taxonomy: $(this).data('taxonomy')
			      	}

			      	return query;
			    }
		  	},
		  	placeholder: 'Search for Terms',
		  	minimumInputLength: 3,
		  	language: {
		        searching: function() {
		            return 'Searching...';
		        }
		    },
		}

		if ( widget_id != '' ) {
			$( widget_id ).find( '.advanced-widget-control-select2-taxonomy-dropdown' ).select2(args);
		}
		else {
			$( '.widget-liquid-right .advanced-widget-control-select2-taxonomy-dropdown' ).select2(args);
		}
	}
};

$document.ready( function(){ wpWidgetOpts.init(); } );

})(jQuery);
