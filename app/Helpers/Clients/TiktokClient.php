<?php

namespace Nick\SocialMediaStation\Helpers\Clients;

/**
 * curl --location --request POST 'https://open-api.tiktok.com/share/video/upload/?access_token=<ACCESS_TOKEN>&open_id=<OPEN_ID>' \
--form 'video=@"/Users/tiktok/Downloads/video.mp4"'
 */
class TiktokClient {

	const BASE_URL = 'https://open-api.tiktok.com/share/video/upload/';

	private $tiktok;

	public function __construct($settings) {
		// App ID
		// Client key
		// Client Secret


		// After
		//open_id from /oauth/access_token/
		//access_token from /oauth/access_token/
	}

	final public function post($content){

		$url = self::BASE_URL. '?access_token=<ACCESS_TOKEN>&open_id=<OPEN_ID>';

		$args = array(
			'body'        =>  array (
				'video'=> '/Users/tiktok/Downloads/video.mp4'
			),
			'timeout'     => '5',
			'redirection' => '5',
			'httpversion' => '1.0',
			'blocking'    => true,
			'headers'     => array(
				'Authorization' => 'Basic ' . base64_encode( '@TODO' . ':' . '@TODO' )
			),
			'cookies'     => array(),
		);

		$res = wp_remote_get( $url, $args );

		// @TODO:: get post id from tiktok and save.


	}

}
