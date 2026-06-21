const settings = window.mcToolsBuilder || {};

function request( path, options = {} ) {
	return fetch( settings.restUrl + path, {
		...options,
		cache: 'no-store',
		headers: {
			'Content-Type': 'application/json',
			'X-WP-Nonce': settings.nonce,
			...( options.headers || {} ),
		},
	} ).then( ( response ) => {
		return response.json().then( ( data ) => {
			if ( ! response.ok ) {
				throw new Error( data.message || 'Erreur serveur' );
			}
			return data;
		} );
	} );
}

export function fetchTool() {
	return request( 'tools/' + settings.postId );
}

export function saveTool( config ) {
	return request( 'tools/' + settings.postId, {
		method: 'POST',
		body: JSON.stringify( { config } ),
	} );
}

export function fetchPresets() {
	return request( 'presets' );
}

export function computePreview( config, values ) {
	return request( 'preview', {
		method: 'POST',
		body: JSON.stringify( { config, values } ),
	} );
}
