const FIELD_TYPES = [ 'number', 'slider', 'select', 'radio_cards', 'toggle' ];

function makeOption() {
	return { value: '', label: '' };
}

export default function FieldEditor( { fields, presetVariables, isCustom, onChange } ) {
	function update( index, patch ) {
		const next = fields.slice();
		next[ index ] = { ...next[ index ], ...patch };
		onChange( next );
	}

	function addField() {
		onChange( [ ...fields, { id: '', label: '', type: 'number', default: 0 } ] );
	}

	function removeField( index ) {
		onChange( fields.filter( ( _, i ) => i !== index ) );
	}

	function move( index, dir ) {
		const next = fields.slice();
		const target = index + dir;
		if ( target < 0 || target >= next.length ) {
			return;
		}
		[ next[ index ], next[ target ] ] = [ next[ target ], next[ index ] ];
		onChange( next );
	}

	return (
		<div className="mc-builder__section">
			<h3>Champs d'entrée</h3>
			{ ! isCustom && presetVariables && presetVariables.length > 0 && (
				<p className="mc-builder__hint">
					Associez chaque champ à une variable attendue par le preset (celles marquées "requis" doivent être associées à un champ).
				</p>
			) }
			{ fields.map( ( field, index ) => (
				<div className="mc-builder__field-row" key={ index }>
					<div className="mc-builder__field-row-main">
						{ isCustom || ! presetVariables || presetVariables.length === 0 ? (
							<input
								type="text"
								placeholder="id (ex: capital)"
								value={ field.id }
								onChange={ ( e ) => update( index, { id: e.target.value.replace( /[^a-z0-9_]/g, '' ) } ) }
							/>
						) : (
							<select
								value={ field.id }
								onChange={ ( e ) => update( index, { id: e.target.value } ) }
							>
								<option value="">— Choisir une variable —</option>
								{ presetVariables.map( ( v ) => (
									<option key={ v.id } value={ v.id }>
										{ v.label }{ v.required ? ' (requis)' : '' }
									</option>
								) ) }
							</select>
						) }
						<input
							type="text"
							placeholder="Label affiché"
							value={ field.label }
							onChange={ ( e ) => update( index, { label: e.target.value } ) }
						/>
						<select value={ field.type } onChange={ ( e ) => update( index, { type: e.target.value } ) }>
							{ FIELD_TYPES.map( ( t ) => (
								<option key={ t } value={ t }>{ t }</option>
							) ) }
						</select>
						<button type="button" className="mc-builder__btn-icon" onClick={ () => move( index, -1 ) } aria-label="Monter">↑</button>
						<button type="button" className="mc-builder__btn-icon" onClick={ () => move( index, 1 ) } aria-label="Descendre">↓</button>
						<button type="button" className="mc-builder__btn-danger" onClick={ () => removeField( index ) }>Supprimer</button>
					</div>

					{ ( 'slider' === field.type || 'number' === field.type ) && (
						<div className="mc-builder__field-row-extra">
							<label>Min <input type="number" value={ field.min ?? '' } onChange={ ( e ) => update( index, { min: Number( e.target.value ) } ) } /></label>
							<label>Max <input type="number" value={ field.max ?? '' } onChange={ ( e ) => update( index, { max: Number( e.target.value ) } ) } /></label>
							<label>Pas <input type="number" value={ field.step ?? 1 } onChange={ ( e ) => update( index, { step: Number( e.target.value ) } ) } /></label>
							<label>Défaut <input type="number" value={ field.default ?? 0 } onChange={ ( e ) => update( index, { default: Number( e.target.value ) } ) } /></label>
							<label>Unité <input type="text" value={ field.unit ?? '' } onChange={ ( e ) => update( index, { unit: e.target.value } ) } /></label>
						</div>
					) }

					{ ( 'select' === field.type || 'radio_cards' === field.type ) && (
						<div className="mc-builder__field-row-extra">
							{ ( field.options || [] ).map( ( opt, oi ) => (
								<span key={ oi } className="mc-builder__option">
									<input type="text" placeholder="valeur" value={ opt.value } onChange={ ( e ) => {
										const options = ( field.options || [] ).slice();
										options[ oi ] = { ...options[ oi ], value: e.target.value };
										update( index, { options } );
									} } />
									<input type="text" placeholder="label" value={ opt.label } onChange={ ( e ) => {
										const options = ( field.options || [] ).slice();
										options[ oi ] = { ...options[ oi ], label: e.target.value };
										update( index, { options } );
									} } />
								</span>
							) ) }
							<button type="button" onClick={ () => update( index, { options: [ ...( field.options || [] ), makeOption() ] } ) }>+ option</button>
						</div>
					) }
				</div>
			) ) }
			<button type="button" onClick={ addField }>+ Ajouter un champ</button>
		</div>
	);
}
