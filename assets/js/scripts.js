var caldera_smtp_mailer_canvas = false,
	csmtp_get_config_object,
	csmtp_record_change,
	csmtp_canvas_init,
	csmtp_get_default_setting,
	csmtp_prepare_test,
	csmtp_end_test,
	config_object = {};

jQuery( function($){

	// ui display fincitons
	csmtp_prepare_test = function(){
		$('#csmtp_test_init_button').prop('disabled', true);
	}
	csmtp_end_test = function(){
		$('#csmtp_test_init_button').prop('disabled', false);
	}

	// internal function declarationas
	csmtp_get_config_object = function(el){

		var clicked 	= $(el),
			config 		= $('#caldera-smtp-mailer-live-config').val(),
			required 	= $('[required]'),
			clean		= true;

		for( var input = 0; input < required.length; input++ ){
			if( required[input].value.length <= 0 && $( required[input] ).is(':visible') ){
				$( required[input] ).addClass('caldera-smtp-mailer-input-error');
				clean = false;
			}else{
				$( required[input] ).removeClass('caldera-smtp-mailer-input-error');
			}
		}
		if( clean ){
			caldera_smtp_mailer_canvas = config;
		}
		clicked.data( 'config', config );
		return clean;
	}

	csmtp_record_change = function(){
		// hook and rebuild the fields list
		jQuery('#caldera_smtp_mailer-id').trigger('change');
		jQuery('#caldera-smtp-mailer-field-sync').trigger('refresh');
	}
	
	csmtp_canvas_init = function(){

		if( !caldera_smtp_mailer_canvas ){
			// bind changes
			jQuery('#caldera-smtp-mailer-main-canvas').on('keydown keyup change','input, select, textarea', function(e) {
				config_object = jQuery('#caldera-smtp-mailer-main-form').formJSON(); // perhaps load into memory to keep it live.
				jQuery('#caldera-smtp-mailer-live-config').val( JSON.stringify( config_object ) ).trigger('change');
			});
			// bind editor
			caldera_smtp_mailer_canvas = jQuery('#caldera-smtp-mailer-live-config').val();
			config_object = JSON.parse( caldera_smtp_mailer_canvas ); // perhaps load into memory to keep it live.
		}

	}
	csmtp_get_default_setting = function(obj){

		var id = 'node_' + Math.round(Math.random() * 99887766) + '_' + Math.round(Math.random() * 99887766),
			new_object = {},
			//config_object = JSON.parse( jQuery('#caldera-smtp-mailer-live-config').val() ), // perhaps load into memory to keep it live.
			trigger = ( obj.trigger ? obj.trigger : obj.params.trigger ),
			sub_id = ( trigger.data('group') ? trigger.data('group') : 'node_' + Math.round(Math.random() * 99887766) + '_' + Math.round(Math.random() * 99887766) );

		
		// add simple node
		if( trigger.data('addNode') ){
			// new node? add one
			if( !config_object[trigger.data('addNode')] ){
				config_object[trigger.data('addNode')] = {};
			}
			// add a new id to node
			config_object[trigger.data('addNode')][id] = {
				"_id" : id
			};
		}
		// remove simple node (all)
		if( trigger.data('removeNode') ){
			// new node? add one
			if( config_object[trigger.data('removeNode')] ){
				delete config_object[trigger.data('removeNode')];
			}

		}



		switch( trigger.data('script') ){
			case "add-to-object":
				// add to core object
				//config_object.entry_name = obj.data.value; // ajax method

				break;
		}

		jQuery('#caldera-smtp-mailer-live-config').val( JSON.stringify( config_object ) );
		jQuery('#caldera-smtp-mailer-field-sync').trigger('refresh');
	}

	// trash 
	$(document).on('click', '.caldera-smtp-mailer-card-actions .confirm a', function(e){
		e.preventDefault();
		var parent = $(this).closest('.caldera-smtp-mailer-card-content');
			actions = parent.find('.row-actions');

		actions.slideToggle(300);
	});

	// bind slugs
	$(document).on('keyup change', '[data-format="slug"]', function(e){

		var input = $(this);

		if( input.data('master') && input.prop('required') && this.value.length <= 0 && e.type === "change" ){
			this.value = $(input.data('master')).val().replace(/[^a-z0-9]/gi, '_').toLowerCase();
			if( this.value.length ){
				input.trigger('change');
			}
			return;
		}

		this.value = this.value.replace(/[^a-z0-9]/gi, '_').toLowerCase();
	});
	
	// bind label update
	$(document).on('keyup change', '[data-sync]', function(){
		var input = $(this),
			sync = $(input.data('sync'));
		if( sync.is('input') ){
			sync.val( input.val() ).trigger('change');
		}else{
			sync.text(input.val());
		}
	});

	// bind tabs
	$(document).on('click', '.caldera-smtp-mailer-nav-tabs > li > a', function(e){
		
		e.preventDefault();
		var clicked 	= $(this),
			tab_id 		= clicked.attr('href'),
			required 	= $('[required]'),
			clean		= true;

		for( var input = 0; input < required.length; input++ ){
			if( required[input].value.length <= 0 && $( required[input] ).is(':visible') ){
				$( required[input] ).addClass('caldera-smtp-mailer-input-error');
				clean = false;
			}else{
				$( required[input] ).removeClass('caldera-smtp-mailer-input-error');
			}
		}
		if( !clean ){
			return;
		}

		$('.caldera-smtp-mailer-nav-tab.active').removeClass('active');
		clicked.parent().addClass('active');

		$('.caldera-smtp-mailer-editor-panel').hide();
		$( tab_id ).show();

		jQuery('#caldera-smtp-mailer-active-tab').val(tab_id).trigger('change');

	});

	// row remover global neeto
	$(document).on('click', '[data-remove-parent]', function(e){
		var clicked = $(this),
			parent = clicked.closest(clicked.data('removeParent')).remove();
		
		csmtp_record_change();
	});
	
	// initialize live sync rebuild
	$(document).on('change', '[data-live-sync]', function(e){
		cye_record_change();
	});

	// initialise baldrick triggers
	$('.wp-baldrick').baldrick({
		request     : ajaxurl,
		method      : 'POST'
	});


	window.onbeforeunload = function(e) {
		if( caldera_smtp_mailer_canvas && caldera_smtp_mailer_canvas !== jQuery('#caldera-smtp-mailer-live-config').val() && e.explicitOriginalTarget.id !== 'primary-save-button' ){
			return true;
		}
	};


});


