import { mediaDiv } from "../utils/mediaRenderer";

const RenderMedia = ({ files }) => {
	if (!files) return <div> Post has no files/media attachments. </div>
	return (
		<>
			{
				files.map((file) => {
					return (
						<div>
							{mediaDiv(file)}
						</div>
					)
				})
			}

		</>
	);
};

export default RenderMedia;
