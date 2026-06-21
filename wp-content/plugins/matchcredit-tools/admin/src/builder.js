import { render } from '@wordpress/element';
import App from './App';
import './style.css';

document.addEventListener( 'DOMContentLoaded', function () {
	const root = document.getElementById( 'mc-tools-builder-root' );
	if ( root ) {
		render( <App />, root );
	}
} );
