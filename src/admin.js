import domReady from '@wordpress/dom-ready';

import './admin.scss';
import { render } from '@wordpress/element';

import SettingsForm from './components/SettingsForm';

domReady( function () {
	const htmlOutput = document.getElementById(
		'social-media-station-plugin-settings'
	);
	const siteData = socialMediaData;

	if ( htmlOutput ) {
		render( <SettingsForm
			socialData = {siteData}
		/>, htmlOutput );
	}
} );
