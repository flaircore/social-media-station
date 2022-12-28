/**
 * Generates a media div, depending on the file type(s).
 * eg img for images
 */


// todo debug other files
const mediaDiv = (file) => {
	const { id, type, mime, url, alt, caption } = file
	let markup = <div>media file</div>
	switch (type) {
		case 'image':
			markup = <img
				src={url}
				alt={alt}
				title="Image"
				width="300"
				height="231"
			/>

			break

		case 'document':
			console.log("document")
			break

		case 'audio':
			markup =
				<audio controls>
					<source src={ url } type={ mime } />
				</audio>
			break

		case 'video':
			markup =
				<video width="100%" src={ url } controls>
					Your browser does not support the video tag.
				</video>
			break

		default:
			markup = <a
				href={ url }
				type={ type }
				title="file"
			>
				Download file (. {mime} )
			</a>
			break
	}
	return (
		<div>{markup}</div>
	)

}

export {
	mediaDiv
}
