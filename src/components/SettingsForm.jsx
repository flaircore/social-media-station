import React from 'react';
import Select from 'react-select';
import api from '@wordpress/api';
import { __ } from '@wordpress/i18n';
import {
	Icon,
	Dashicon,
	TextControl,
	Button,
	Flex,
	FlexBlock,
	FlexItem,
	Card,
	CardHeader,
	CardBody,
	CardFooter,
	CardDivider,
	__experimentalText as Text,
} from '@wordpress/components';

import { useState, useEffect } from '@wordpress/element';

import FetchSettings from './FetchSettings';

const SettingsForm = ( { socialData } ) => {
	const { socials } = socialData
	const [ configs, setConfigs ] = useState( {} );
	const { data, error } = FetchSettings(socials);

	useEffect( () => {
		setConfigs( data );
	}, [ data ] );

	const updateValuesFromInputs = ( socialId, index, key, value ) => {
		const newConfigs = { ...configs };
		if ( newConfigs[socialId][index].key === key ) {
			newConfigs[socialId][index].value = value
		}
		//newConfigs[socialId][index].value
		setConfigs( newConfigs );
	};

	const handleSave = async ( e ) => {
		e.preventDefault();
		const urlParams = new URLSearchParams ( {
			action : 'social_media_station_config_options',
			configs:  JSON.stringify({configs})
		} )

		const res = await fetch ( '/wp-admin/admin-ajax.php' , {
			method : 'POST' ,
			headers : {
				'Content-Type' : 'application/x-www-form-urlencoded' ,
			} ,
			body : urlParams,
		} )

		if ( res.status === 200 ) {
			const { data } = await res.json()
			setConfigs(data.configs)
		}
	};

	return (
		<>
			<div className="">
				<h1>
					{ __(
						'Social media station settings.',
						'social-media-station'
					) }{ ' ' }
					<Icon icon="admin-plugins" />
				</h1>
				<div className="login-logout-settings-form">
					<div>
						<Card
							className="wp-login-logout-settings-form"
							elevation={ 3 }
							isRounded={ true }
							size="medium"
						>
							{ socials &&
								Object.entries(socials).map(( [key, value], index) => {
									const socialId = key
									return (
										<>
											<CardHeader>
												<Text><strong>{value.name}</strong></Text>
											</CardHeader>
											<CardBody
												size="small"
												elevation={ 5 }
											>
												<Flex key={socialId} gap={4}>
													<FlexItem>

													</FlexItem>
													<FlexBlock>
														{ configs[socialId] &&
															value?.config.map(({ key, name, description}, index) => {
																return (
																	<FlexItem>
																		<TextControl
																			help={ description }
																			label={ name}
																			placeholder=""
																			type="text"
																			width="4"
																			onChange={ (
																				value
																			) =>
																				updateValuesFromInputs( socialId, index, key,value )
																			}
																			value={ configs[socialId][index].value }
																		/>
																	</FlexItem>
																)
															})
														}
													</FlexBlock>
												</Flex>
											</CardBody>
											<CardDivider />
										</>
									)
								})

							}
						</Card>
						<Button isPrimary isLarge onClick={ handleSave }>
							{ __( 'Save Configs', 'social-media-station' ) }
						</Button>
					</div>
				</div>
			</div>
		</>
	);
};

export default SettingsForm;
