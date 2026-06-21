( function () {
	'use strict';

	function debounce( fn, delay ) {
		var timer = null;
		return function () {
			var args = arguments;
			clearTimeout( timer );
			timer = setTimeout( function () {
				fn.apply( null, args );
			}, delay );
		};
	}

	function collectValues( form, config ) {
		var values = {};
		config.fields.forEach( function ( field ) {
			var input = form.querySelector( '[name="mc_field_' + field.id + '"]' );
			if ( ! input ) {
				return;
			}
			if ( 'checkbox' === input.type ) {
				values[ field.id ] = input.checked ? 1 : 0;
			} else {
				values[ field.id ] = input.value;
			}
		} );
		return values;
	}

	function formatResult( value, format ) {
		var num = parseFloat( value );
		if ( isNaN( num ) ) {
			return '—';
		}
		switch ( format ) {
			case 'currency':
				return num.toLocaleString( 'fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 } ) + ' €';
			case 'percent':
				return num.toLocaleString( 'fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 } ) + ' %';
			case 'duration_years':
				return ( num / 12 ).toLocaleString( 'fr-FR', { minimumFractionDigits: 1, maximumFractionDigits: 1 } ) + ' ans';
			default:
				return num.toLocaleString( 'fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 } );
		}
	}

	function updateResults( form, config, results ) {
		config.results.forEach( function ( result ) {
			var el = form.querySelector( '[data-mc-result="' + result.key + '"] .mc-tool__result-value' );
			if ( ! el ) {
				return;
			}
			el.textContent = Object.prototype.hasOwnProperty.call( results, result.key )
				? formatResult( results[ result.key ], result.format )
				: '—';
		} );
	}

	function compute( form, config ) {
		var values = collectValues( form, config );
		var errorEl = form.querySelector( '.mc-tool__error' );

		fetch( window.mcToolsSettings.restUrl + 'compute', {
			method: 'POST',
			headers: { 'Content-Type': 'application/json' },
			body: JSON.stringify( { slug: form.dataset.slug, values: values } ),
		} )
			.then( function ( response ) {
				return response.json().then( function ( data ) {
					return { ok: response.ok, data: data };
				} );
			} )
			.then( function ( payload ) {
				if ( payload.ok ) {
					if ( errorEl ) {
						errorEl.remove();
					}
					updateResults( form, config, payload.data.results );
				} else if ( errorEl ) {
					errorEl.textContent = payload.data.message;
				}
			} )
			.catch( function () {
				// Silencieux : le fallback no-JS (submit serveur) reste disponible.
			} );
	}

	function initWidget( form ) {
		var config = JSON.parse( form.dataset.config );
		var debounced = debounce( function () {
			compute( form, config );
		}, 250 );

		form.addEventListener( 'input', function ( event ) {
			var slider = event.target.closest( '.mc-tool__slider' );
			if ( slider ) {
				var display = slider.parentElement.querySelector( '[data-mc-slider-value]' );
				if ( display ) {
					var field = config.fields.filter( function ( f ) {
						return slider.name === 'mc_field_' + f.id;
					} )[ 0 ];
					display.textContent = slider.value + ( field && field.unit ? field.unit : '' );
				}
			}
			debounced();
		} );

		form.addEventListener( 'submit', function ( event ) {
			// Le fallback no-JS POST normalement ; ici JS est actif donc on
			// court-circuite le rechargement de page et on recalcule en place.
			event.preventDefault();
			compute( form, config );
		} );

		// Calcul initial avec les valeurs par défaut.
		compute( form, config );
	}

	document.addEventListener( 'DOMContentLoaded', function () {
		document.querySelectorAll( '[data-mc-tool]' ).forEach( initWidget );
	} );
} )();
