<?php

namespace Drupal\social_deck\Helpers;

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
		$data = array (
			'video'=> '/Users/tiktok/Downloads/video.mp4'
		);

		$ch = curl_init();

		$options = array (
			CURLOPT_URL => self::BASE_URL. '?access_token=<ACCESS_TOKEN>&open_id=<OPEN_ID>',
			CURLOPT_POST => 1,// make async callback function or Guzzle
			CURLOPT_POSTFIELDS => $data,
			CURLOPT_RETURNTRANSFER => 1
		);

		curl_setopt_array($ch, $options);

		$res = curl_exec($ch);
		$err = curl_error($ch);

		curl_close($ch);

		if ($err) {
			throw new \Exception("cURL Error #:".$err);
		} else {
			return json_decode($res, true);
		}

	}

}
