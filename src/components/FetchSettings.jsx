import React from 'react';
import { useState, useEffect } from '@wordpress/element';

const FetchSettings = (socials) => {
	const [ configs, setConfigs ] = useState({});

	const [ error, setError ] = useState( null );

	useEffect( async () => {
		const paramsObj = { action : 'social_media_station_config_options'}
		const urlParams = new URLSearchParams ( paramsObj )

		const res = await fetch ( '/wp-admin/admin-ajax.php' , {
			method : 'POST' ,
			headers : {
				'Content-Type' : 'application/x-www-form-urlencoded' ,
			} ,
			body : new URLSearchParams ( urlParams )
		} )
		if ( res.status === 200 ) {
			const { data } = await res.json()
			setConfigs(data.configs)
		}
	}, [] );

	return { data: configs, error };
};

export default FetchSettings;
