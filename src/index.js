/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
import { registerBlockType } from '@wordpress/blocks';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * All files containing `style` keyword are bundled together. The code used
 * gets applied both to the front of your site and to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './style.scss';

/**
 * Internal dependencies
 */
import Edit from './edit';
import save from './save';
import metadata from './block.json';

const current = new Date();
current.setMinutes(current.getMinutes() + 60 )

const attributes = {
	about: {
		type: 'string',
		default: '',
		description: 'The description to include with the social post.'
	},
	postAt: {
		type: 'string',
		description: 'Time to post to social media',
		default: current
	},
	mediaFiles: {
		type: 'array',
		default: [],
		description: 'The media files associated with this social media post.'
	},
	url: {
		type: 'string',
		description: 'Url to include with this post on social media.',
		default: ''
	},
	details: {
		type: 'string',
		description: 'Includes ids of social media post as a reference to relate' +
			'this post this the respective social media posts.',
		default: ''
	},
}

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
registerBlockType( metadata.name, {
	attributes,
	/**
	 * @see ./edit.js
	 */
	edit: (props) => {
		return <Edit {...props} />
	},

	/**
	 * @see ./save.js
	 */
	save,
} );
