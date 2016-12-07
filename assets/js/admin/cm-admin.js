
jQuery( document ).on( 'click', "#dialog-recall a", function(e) {
	e.preventDefault();
	var link = jQuery( this );
	var href = link.attr( 'href' );
	var data = null;
	var input_user = prompt( 'Nouveau commentaire !' );
	var href = href + '&new_comment=' + input_user;
	jQuery.get( href, data, function() {
		link.closest( "tr" ).remove();
	});
});
jQuery( document ).on( 'click', "#dialog-will-recall a", function(e) {
	e.preventDefault();
	var link = jQuery( this );
	var href = link.attr( 'href' );
	var data = null;
	var input_user = prompt( 'Nouveau commentaire !' );
	var href = href + '&new_comment=' + input_user;
	jQuery.get( href, data, function() {
		link.closest( "tr" ).remove();
	});
});
jQuery( document ).ready( function( $ ) {
	function validateEmail( $email ) {
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,20})?$/;
		return emailReg.test( $email );
	}
	jQuery( "#wp-admin-bar-imputation .child_blame" ).click( function(e) {
		e.preventDefault();
		var a = jQuery( this ).find( 'a' );
		var href = a.attr( 'href' );
		var data = null;
		jQuery.get( href, data, function( response ) {
			jQuery( "#wp-admin-bar-imputation .ab-label" ).text( response.data.total );
			jQuery( "#wp-admin-bar-imputation .ab-retour_" + response.data.id_user ).text( response.data.count_current_user );
		});
	});
	jQuery( "#wp-admin-bar-imputation_tel .ab-action" ).click( function(){
		jQuery( "#dialog" ).dialog( "open" );
		var data = {
			'action': 'count_tel',
		};
		jQuery.post( ajaxurl, data, function( response ) {
			jQuery( "#wp-admin-bar-imputation_tel .ab-label" ).text( response )
		});
	});
	jQuery( "#wp-admin-bar-imputation_tel_moins .ab-action-moins" ).click( function(){
		var data = {
			'action': 'count_tel_moins',
		};
		jQuery.post( ajaxurl, data, function( response ) {
			jQuery( "#wp-admin-bar-imputation_tel .ab-label" ).text( response )
		});
	});
	jQuery( "#dialog" ).dialog( {
		autoOpen: false,
		resizable: false,
		height: "auto",
		width: "auto",
		modal: true,
		buttons: {
			Rechercher: function() {
				var emailCheck = jQuery( "#form-dialog #email_contact_call" ).val();
				if ( validateEmail( emailCheck ) ) {
					jQuery( "#form-dialog" ).click().attr( "method", "GET" ).ajaxSubmit( function( response ) {
						var name = response.data.name;
						jQuery( "#form-dialog #name_contact_call" ).attr( "value" , name );
						var society = response.data.society;
						jQuery( "#form-dialog #society_contact_call" ).attr( "value" , society );
						var email = response.data.mail;
						jQuery( "#form-dialog #email_contact_call" ).attr( "value" , email );
						var number = response.data.number;
						jQuery( "#form-dialog #number_contact_call" ).attr( "value" , number );
						var comment = response.data.commentcontent;
						if ( null === comment ) { var comment = "Inconnu / Not found" }
						jQuery( "#form-dialog #comment_content_call" ).attr( "value" , comment );
					});
				}	else {
					var comment = "E-mail non valide !";
					jQuery( "#form-dialog #comment_content_call" ).attr( "value" , comment );
				}
			},
			OK: function() {
				var emailCheck = jQuery( "#form-dialog #email_contact_call" ).val();
				if ( validateEmail( emailCheck ) ) {
					jQuery( "#form-dialog" ).click().attr( "method", "POST" ).ajaxSubmit();
					jQuery( "#form-dialog" )[0].reset();
					jQuery( "#dialog" ).dialog( "close" );
				}	else {
					var comment = "E-mail non valide !";
					jQuery( "#form-dialog #comment_content_call" ).attr( "value" , comment );
				}
			},
			Annuler: function() {
				var data = {
					'action': 'count_tel_moins',
				};
				jQuery.post( ajaxurl, data, function( response ) {
					jQuery( "#wp-admin-bar-imputation_tel .ab-label" ).text( response )
				});
				jQuery( "#form-dialog" )[0].reset();
				jQuery( "#dialog" ).dialog( "close" );
			}
		}
	});
	jQuery( "#dialog-recall" ).dialog( {
		autoOpen: false,
		resizable: false,
		height: "auto",
		width: "auto",
		modal: true,
		buttons: {
			Fermer: function() {
				$( this ).dialog( "close" );
			}
		}
	});
	jQuery( "#dialog-will-recall" ).dialog( {
		autoOpen: false,
		resizable: false,
		height: "auto",
		width: "auto",
		modal: true,
		buttons: {
			Fermer: function() {
				$( this ).dialog( "close" );
			}
		}
	});
	jQuery( "#wp-admin-bar-imputation_recall .ab-action-recall" ).click( function(){
		jQuery("#dialog-recall").dialog("open");
	});
	jQuery( "#wp-admin-bar-imputation_will_recall .ab-action-will-recall" ).click( function(){
		jQuery("#dialog-will-recall").dialog("open");
	});
	jQuery( ".ab-action-recap-call-monthly" ).click( function () {
		jQuery( "#cm-summary-call-recap-" + jQuery( this ).data( 'id') ).dialog( {
			autoOpen: true,
			resizable: true,
			height: "600",
			width: "auto",
			modal: true,
			buttons: {
				Fermer: function() {
					$( this ).dialog( "close" );
				}
			}
		});
	});
	jQuery( ".ab-action-recap-blame-monthly" ).click( function () {
		jQuery( "#cm-summary-blame-recap-" + jQuery( this ).data( 'id' ) ).dialog( {
			autoOpen: true,
			resizable: true,
			height: "auto",
			width: "auto",
			modal: true,
			buttons: {
				Fermer: function() {
					$( this ).dialog( "close" );
				}
			}
		});
	});
	jQuery( ".ab-action-recap-call-daily" ).click( function () {
		jQuery( "#cm-summary-call-recap-" + jQuery( this ).data( 'id' ) ).dialog( {
			autoOpen: true,
			resizable: true,
			height: "600",
			width: "auto",
			modal: true,
			buttons: {
				Fermer: function() {
					$( this ).dialog( "close" );
				}
			}
		});
	});
	jQuery( ".ab-action-recap-blame-daily" ).click( function () {
		jQuery( "#cm-summary-blame-recap-" + jQuery( this ).data( 'id' ) ).dialog( {
			autoOpen: true,
			resizable: true,
			height: "auto",
			width: "auto",
			modal: true,
			buttons: {
				Fermer: function() {
					$( this ).dialog( "close" );
				}
			}
		});
	});
	jQuery( document ).on( 'heartbeat-tick', function() {
		var data = {
			'action': 'display',
		};
		jQuery.post( ajaxurl, data, function( rep ) {
			jQuery( "#dialog-recall" ).find( "table" ).html( rep );
		});

		var data = {
			'action': 'display_button_recall',
		};
		jQuery.post( ajaxurl, data, function ( reponse ) {
			if ( "oui" === reponse.data.retour ) {
				jQuery( "#wp-admin-bar-imputation_recall #spanny" ).removeClass( "hidden" );
			}
			if ( "non" === reponse.data.retour ) {
				jQuery( "#wp-admin-bar-imputation_recall #spanny" ).addClass( "hidden" );
			}
		});

		var data = {
			'action': 'display_deux',
		};
		jQuery.post( ajaxurl, data, function( resp ) {
			jQuery( "#dialog-will-recall" ).find( "table" ).html( resp );
		});
		var data = {
			'action': 'display_button_will_recall',
		};
		jQuery.post( ajaxurl, data, function ( response ) {
			if ( "yes" === response.data.return ) {
				jQuery( "#wp-admin-bar-imputation_will_recall #spanny-deux" ).removeClass( "hidden" );
			}
			if ( "no" === response.data.return ) {
				jQuery( "#wp-admin-bar-imputation_will_recall #spanny-deux" ).addClass( "hidden" );
			}
		});
	});
});
