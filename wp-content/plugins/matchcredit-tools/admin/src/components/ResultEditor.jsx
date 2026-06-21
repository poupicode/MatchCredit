const FORMATS = [ 'currency', 'percent', 'number', 'duration_years', 'text' ];

export default function ResultEditor( { results, onChange } ) {
	function update( index, patch ) {
		const next = results.slice();
		next[ index ] = { ...next[ index ], ...patch };
		onChange( next );
	}

	function addResult() {
		onChange( [ ...results, { key: '', label: '', format: 'currency', highlight: results.length === 0 } ] );
	}

	function removeResult( index ) {
		onChange( results.filter( ( _, i ) => i !== index ) );
	}

	return (
		<div className="mc-builder__section">
			<h3>Résultats</h3>
			{ results.map( ( result, index ) => (
				<div className="mc-builder__field-row" key={ index }>
					<input
						type="text"
						placeholder="clé (ex: capital)"
						value={ result.key }
						onChange={ ( e ) => update( index, { key: e.target.value.replace( /[^a-z0-9_]/g, '' ) } ) }
					/>
					<input
						type="text"
						placeholder="Label affiché"
						value={ result.label }
						onChange={ ( e ) => update( index, { label: e.target.value } ) }
					/>
					<select value={ result.format } onChange={ ( e ) => update( index, { format: e.target.value } ) }>
						{ FORMATS.map( ( f ) => (
							<option key={ f } value={ f }>{ f }</option>
						) ) }
					</select>
					<label className="mc-builder__checkbox-label">
						<input type="checkbox" checked={ !! result.highlight } onChange={ ( e ) => update( index, { highlight: e.target.checked } ) } />
						Mettre en avant
					</label>
					<button type="button" className="mc-builder__btn-danger" onClick={ () => removeResult( index ) }>Supprimer</button>
				</div>
			) ) }
			<button type="button" onClick={ addResult }>+ Ajouter un résultat</button>
		</div>
	);
}
