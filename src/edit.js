/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import {
	useBlockProps,
	InspectorControls,
	MediaUpload,
	MediaUploadCheck
} from '@wordpress/block-editor';

import {
	Card,
	CardHeader,
	CardBody,
	CardDivider,
	CardFooter,
	Button,
	DateTimePicker,
	TextControl,
	TextareaControl,
	__experimentalText as Text,
	__experimentalHeading as Heading,
	__experimentalDivider as Divider,
} from '@wordpress/components';

import { useState } from '@wordpress/element';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';
import RenderMedia from "./components/RenderMedia";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
// set current date to 60 mins ahead
const current = new Date();
current.setMinutes(current.getMinutes() + 60 )

const Edit = (props) => {

	const {
		attributes: {
			about, postAt, mediaFiles, url, details
		},
		clientId,
		setAttributes,
		context,
	} = props;

	return (
		<>
			<Card>
				<CardHeader>
					<Text>{ __(
						'Social Media Station – Schedule A post.',
						'social-media-station'
					) }</Text>
				</CardHeader>
				<CardBody>

					<TextareaControl
						label={__('Post about', 'social-media-station')}
						value={about}
						placeholder={__('Description about this social media post.', 'social-media-station')}
						help={__('Description about this social media post.', 'social-media-station')}
						onChange={(value) => setAttributes({about: value})}
					/>

					<TextControl
						label={__('Url to include', 'social-media-station')}
						placeholder={__('https://www.example.com/.', 'social-media-station')}
						help={__('Url to include with this post on social media.', 'social-media-station')}
						value={url}
						type="url"
						onChange={(value) => setAttributes({url: value})}
					/>


				</CardBody>
				<CardDivider />
				<CardBody>
					<Text>{__('The time to post on social media.', 'social-media-station')}</Text>
					<DateTimePicker
						currentDate={ postAt }
						onChange={ ( value ) => setAttributes({postAt: value}) }
						is12Hour={ true }
						__nextRemoveHelpButton
						__nextRemoveResetButton
					/>
				</CardBody>
				<CardDivider />
				<CardBody>
					<MediaUploadCheck>
						<MediaUpload
							title={__('Media files', 'social-media-station')}
							onSelect={ ( files ) => {
								const mediaFiles = files?.map((media) => {
									return  {
										mime: media.mime,
										type: media.type,
										url: media.url,
										id: media.id,
										alt: media.alt,
										caption: media.caption,
									}
								})
								setAttributes({mediaFiles})

							}}
							multiple={true}
							value={ mediaFiles.map(file => file.id) }
							gallery={true}
							addToGallery={true}
							autoOpen={true}
							render={ ( { open } ) => (
								<Button
									label={__('Add media files to share', 'social-media-station')}
									variant="secondary"
									onClick={ open }
								>
									Add/Edit media files to share
								</Button>
							) }
						/>
						<RenderMedia files={mediaFiles}/>
					</MediaUploadCheck>
				</CardBody>
				<CardFooter>
					<Text> Post will be posted at : {postAt.toLocaleString()}</Text>
				</CardFooter>
			</Card>
		</>
	);
}

export default Edit;
