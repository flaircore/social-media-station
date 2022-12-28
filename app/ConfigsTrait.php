<?php

namespace Nick\SocialMediaStation;

trait ConfigsTrait {
	/**
	 * Cleans saved configs for use by parts of the app later.
	 */
	protected function cleanConfigs($config) {

		$configs = [];
		if (isset($config->configs->facebook)) {
			foreach ($config->configs->facebook as $settings) {
				$configs['facebook'][$settings->key] = $settings->value;
			}

		}
		if (isset($config->configs->twitter)) {
			foreach ($config->configs->twitter as $settings) {
				$configs['twitter'][$settings->key] = $settings->value;
			}
		}
		if (isset($config->configs->tiktok)) {
			foreach ($config->configs->tiktok as $settings) {
				$configs['tiktok'][$settings->key] = $settings->value;
			}
		}

		return $configs;
	}

	/**
	 * Sanitizes settings from admin dashboard settings form.
	 * @param string $configs
	 *
	 * @return mixed
	 */
	protected function sanitizeConfigs($configs) {
		$data = str_replace(array ('\\'), '', $configs);
		$data = json_decode($data);

		// Reset configs var for re-use below.
		if (isset($data->configs->facebook)) {
			foreach ($data->configs->facebook as $key => $settings) {
				$data->configs->facebook[$key]->value = sanitize_text_field($settings->value);
			}

		}
		if (isset($data->configs->twitter)) {
			foreach ($data->configs->twitter as $key => $settings) {
				$data->configs->twitter[$key]->value = sanitize_text_field($settings->value);
			}
		}
		if (isset($data->configs->tiktok)) {
			foreach ($data->configs->tiktok as $key => $settings) {
				$data->configs->tiktok[$key]->value = sanitize_text_field($settings->value);
			}
		}
		return $data;
	}
}
