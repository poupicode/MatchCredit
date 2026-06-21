import { useEffect, useState } from '@wordpress/element';
import { fetchTool, fetchPresets, saveTool, computePreview } from './api';
import FieldEditor from './components/FieldEditor';
import ResultEditor from './components/ResultEditor';

const EMPTY_CONFIG = {
	type: 'calculette',
	preset: 'pret_amortissable',
	fields: [],
	results: [],
	cta: { text: '', url: '' },
};

export default function App() {
	const [ config, setConfig ] = useState( EMPTY_CONFIG );
	const [ presets, setPresets ] = useState( [] );
	const [ loading, setLoading ] = useState( true );
	const [ saving, setSaving ] = useState( false );
	const [ status, setStatus ] = useState( null );
	const [ preview, setPreview ] = useState( null );
	const [ previewError, setPreviewError ] = useState( null );

	useEffect( () => {
		Promise.all( [ fetchTool(), fetchPresets() ] )
			.then( ( [ tool, presetList ] ) => {
				setConfig( { ...EMPTY_CONFIG, ...tool.config } );
				setPresets( presetList );
				setLoading( false );
			} )
			.catch( ( e ) => {
				setStatus( { type: 'error', message: e.message } );
				setLoading( false );
			} );
	}, [] );

	useEffect( () => {
		if ( loading || ! config.fields.length || ! config.results.length ) {
			return;
		}
		const values = {};
		config.fields.forEach( ( f ) => {
			values[ f.id ] = f.default ?? 0;
		} );
		const timer = setTimeout( () => {
			computePreview( config, values )
				.then( ( data ) => {
					setPreview( data.results );
					setPreviewError( null );
				} )
				.catch( ( e ) => setPreviewError( e.message ) );
		}, 300 );
		return () => clearTimeout( timer );
	}, [ config, loading ] );

	function handleSave() {
		setSaving( true );
		setStatus( null );
		saveTool( config )
			.then( () => setStatus( { type: 'success', message: 'Calculette enregistrée.' } ) )
			.catch( ( e ) => setStatus( { type: 'error', message: e.message } ) )
			.finally( () => setSaving( false ) );
	}

	if ( loading ) {
		return <p>Chargement…</p>;
	}

	const currentPreset = presets.find( ( p ) => p.slug === config.preset );

	return (
		<div className="mc-builder">
			<div className="mc-builder__section">
				<h3>Type</h3>
				<div className="mc-builder__radio-group">
					<label className="mc-builder__checkbox-label">
						<input
							type="radio"
							name="mc-type"
							checked={ config.type === 'calculette' }
							onChange={ () => setConfig( { ...config, type: 'calculette' } ) }
						/> Calculette (réponse rapide)
					</label>
					<label className="mc-builder__checkbox-label">
						<input
							type="radio"
							name="mc-type"
							checked={ config.type === 'simulation' }
							onChange={ () => setConfig( { ...config, type: 'simulation' } ) }
						/> Simulation (aide à la décision)
					</label>
				</div>
			</div>

			<div className="mc-builder__section">
				<h3>Formule</h3>
				<select value={ config.preset } onChange={ ( e ) => setConfig( { ...config, preset: e.target.value } ) }>
					{ presets.map( ( p ) => (
						<option key={ p.slug } value={ p.slug }>{ p.label }</option>
					) ) }
					<option value="custom">Formule personnalisée (avancé)</option>
				</select>
				{ currentPreset && <p className="mc-builder__hint">{ currentPreset.help }</p> }
				{ 'custom' === config.preset && (
					<textarea
						placeholder="ex: (montant * taux/12) / (1 - (1+taux/12)^-duree)"
						value={ config.formula || '' }
						onChange={ ( e ) => setConfig( { ...config, formula: e.target.value } ) }
					/>
				) }
			</div>

			<FieldEditor
				fields={ config.fields }
				presetVariables={ currentPreset ? currentPreset.variables : [] }
				isCustom={ 'custom' === config.preset }
				onChange={ ( fields ) => setConfig( { ...config, fields } ) }
			/>

			<ResultEditor
				results={ config.results }
				onChange={ ( results ) => setConfig( { ...config, results } ) }
			/>

			<div className="mc-builder__section mc-builder__warning">
				<h3>Note interne (visible admin uniquement, jamais sur le site public)</h3>
				<textarea
					placeholder="ex: démo technique, vérifier le statut ORIAS avant publication réelle"
					value={ config.admin_note || '' }
					onChange={ ( e ) => setConfig( { ...config, admin_note: e.target.value } ) }
				/>
			</div>

			<div className="mc-builder__section">
				<h3>CTA de sortie</h3>
				<input
					type="text"
					placeholder="Texte du bouton"
					value={ config.cta?.text || '' }
					onChange={ ( e ) => setConfig( { ...config, cta: { ...config.cta, text: e.target.value } } ) }
				/>
				<input
					type="text"
					placeholder="/rendez-vous"
					value={ config.cta?.url || '' }
					onChange={ ( e ) => setConfig( { ...config, cta: { ...config.cta, url: e.target.value } } ) }
				/>
			</div>

			<div className="mc-builder__section mc-builder__preview">
				<h3>Aperçu live (valeurs par défaut)</h3>
				{ previewError && <p className="mc-builder__error">{ previewError }</p> }
				{ preview && (
					<ul>
						{ Object.entries( preview ).map( ( [ key, value ] ) => (
							<li key={ key }>{ key } : { value }</li>
						) ) }
					</ul>
				) }
				{ ! preview && ! previewError && <p>Ajoutez des champs et résultats pour voir l'aperçu.</p> }
			</div>

			<div className="mc-builder__actions">
				<button type="button" className="button button-primary" disabled={ saving } onClick={ handleSave }>
					{ saving ? 'Enregistrement…' : 'Enregistrer la calculette' }
				</button>
				{ status && (
					<span className={ 'mc-builder__status mc-builder__status--' + status.type }>{ status.message }</span>
				) }
			</div>
		</div>
	);
}
