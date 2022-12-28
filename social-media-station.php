<?php
/**
 * Plugin Name:       Social Media Station
	* Plugin URI:        https://wordpress.org/plugins/social-media-station/
 * Description:       Manage social media posts on a single platform.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Nicholas Babu
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       social-media-station
	* Tested up to:      6.1
 *
 * @package           social-media-station
 */

namespace Nick\SocialMediaStation;

if (!defined('ABSPATH')) {
	exit();
}

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'SOCIAL_MEDIA_STATION_PLUGIN_DIR', __DIR__ );
/**
	* Load composer dependencies.
	*/
require_once SOCIAL_MEDIA_STATION_PLUGIN_DIR . '/vendor/autoload.php';

use Nick\SocialMediaStation\Service\PostToSocialMedia;
class SocialMediaStation {
	use ConfigsTrait;

	public static $socialMediaStation;

	private function __construct() {
		$this->setup();
	}

	private function setup(){
		register_activation_hook ( __FILE__ , array ( $this , 'social_media_station_activate_setup' ) );

		register_deactivation_hook ( __FILE__ , array ( $this , 'social_media_station_deactivate_cleanup' ) );
		//add_action( 'init', 'create_block_social_media_station_block_init' );
		add_action('init', array ($this, 'social_media_station_register'));
		add_action('admin_menu', array ($this, 'social_media_station_menu'));
		add_filter( 'plugin_action_links_' . plugin_basename(__FILE__),array ($this,  'social_media_station_action_links' ));

		add_action( 'admin_enqueue_scripts', array ($this, 'social_media_station_admin_scripts'), 10 );
		// Get social media options.
		add_action ( 'wp_ajax_social_media_station_config_options' , array (
				$this ,
				'social_media_station_config_options'
		) );

		add_filter( 'cron_schedules', array ($this, 'social_media_station_add_cron_interval') );

		// Cron tasks for scheduled posts.
		if (!wp_next_scheduled('social_media_station_cron')) {
			wp_schedule_event(time(), 'five_minutes', array ($this, 'social_media_station_cron'));
		}
	}

	/**
		* Registers the block using the metadata loaded from the `block.json` file.
		* Behind the scenes, it registers also all assets so they can be enqueued
		* through the block editor in the corresponding context.
		*
		* @see https://developer.wordpress.org/reference/functions/register_block_type/
		*/

	public function social_media_station_activate_setup() {

	}

	/**
		* Clean up after uninstall.
		* @return void
		*/
	public function social_media_station_deactivate_cleanup() {
		// delete configurations
		delete_option('social_media_station_settings_section');
	}

	/**
		* Adds custom cron interval.
		* @param $schedules
		*
		* @return mixed
		*/
	public function social_media_station_add_cron_interval( $schedules ) {
		$schedules['five_minutes'] = array(
				'interval' => 5 * 60,
				'display'  => esc_html__( 'Every Five minutes' ), );
		return $schedules;
	}

	/**
		* Posts to social media during cron.
		* @return void
		*/
	public function social_media_station_cron() {
		$social_media = new PostToSocialMedia();
		$social_media->postToSocials();
	}

	/**
		* Requests related to configurations(options).
		* @return void
		*/
	public function social_media_station_config_options() {
		if (isset($_POST['configs'])) {
			// Sanitize all text input values.
			$data = $this->sanitizeConfigs($_POST['configs']);
			$data = serialize($data);
			update_option('social_media_station_settings_section', $data);
		}

		$data = get_option('social_media_station_settings_section');
		if ($data) {
			$data = unserialize($data);
		} else {

			$data = [
					'configs' => [
							'facebook' => [
									['key' => 'ACCESS_TOKEN',		'value' => ''],
									['key' => 'APP_ID',		'value' => ''],
									['key' => 'APP_SECRET',		'value' => ''],
									['key' => 'PAGE_POST_ID',		'value' => ''],
							],
							'tiktok' => [
									['key' => 'app_id',		'value' => ''],
									['key' => 'app_secret',		'value' => ''],
							],
							'twitter' => [
									['key' => 'CONSUMER_KEY',		'value' => ''],
									['key' => 'CONSUMER_SECRET',		'value' => ''],
									['key' => 'OAUTH_TOKEN',		'value' => ''],
									['key' => 'OAUTH_TOKEN_SECRET',		'value' => ''],
							],
					],
			];
		}

		wp_send_json_success ($data);
	}

	/**
		* Add settings page link with plugin.
		*/
	public function social_media_station_action_links( $links ){
		$plugin_action_links = array(
				'<a href="' . admin_url( 'admin.php?page=social_media_station' ) . '"> '. __('Settings', '') . '</a>',
		);
		return array_merge( $links, $plugin_action_links );
	}

	/**
		* Plugin settings page
		*/
	public function social_media_station_register() {

		register_block_type( __DIR__ . '/build' );

		// Register social media post
		register_post_type('social_media',
				array (
						'labels' => array(
								'name' => __( 'Social media', 'social-media-station' ),
								'singular_name' => __( 'Social media', 'social-media-station' ),
								'add_new' => __( 'New Social media post', 'social-media-station' ),
								'new_item' => __( 'New Book', 'social-media-station' ),
								'view_item' => __( 'View Books', 'social-media-station' ),
						),
						'description' => __('Social media posts entries.', 'social-media-station'),
						'has_archive' => true,
						'public' => true,
						'rewrite' => array('slug' => 'social_media'),
						'query_var' => true,
						'show_in_rest' => true,
						'publicly_queryable' => true,
						'exclude_from_search' => true,
						'supports' => array ('title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields', 'comments'),
						'template' => array (
							array ('social-media-station/content-block',
//									array (
//									'about' => 'A default about!!',
//									),
							),
						)
				)
		);


		// register a new section
		register_setting(
				'social_media_station_settings_section',
				'social_media_station_data',
				array(
						'default'      => '',
						'show_in_rest' => false,
						'type'         => 'string',
				)
		);
	}

//Register plugin admin menu
	public function social_media_station_menu() {
		add_menu_page(
				__('Social media station configuration', 'social-media-station'),
				__('Settings', 'social-media-station'),
				'manage_options',
				'social_media_station',
				array ( $this, 'social_media_station_admin_settings_output'),
				'dashicons-randomize');
	}


//Plugin options form
	public function social_media_station_admin_settings_output(){

		?>
		<div id="social-media-station-plugin-settings"></div>
	<?php

		$socials = [
				'facebook' => [
						'name' => 'Facebook',
						'config' => [
							['key' => 'ACCESS_TOKEN', 'name' => 'Access Token', 'description' => 'The Access token'],
							['key' => 'APP_ID', 'name' => 'App Id', 'description' => 'Facebook app id'],
							['key' => 'APP_SECRET', 'name' => 'App secret', 'description' => 'Facebook app secret'],
							['key' => 'PAGE_POST_ID', 'name' => 'Page Id', 'description' => 'The Facebook page id to post to'],
					]
				],
				'tiktok' => [
						'name' => 'Tiktok',
						'config' => [
								['key' => 'app_id', 'name' => 'App Id', 'description' => 'Tiktok app id'],
								['key' => 'app_secret', 'name' => 'App secret', 'description' => 'Tiktok app secret'],
						]
				],
				'twitter' => [
						'name' => 'Twitter',
						'config' => [
								['key' => 'CONSUMER_KEY', 'name' => 'Consumer key', 'description' => 'Twitter consumer key'],
								['key' => 'CONSUMER_SECRET', 'name' => 'Consumer secret', 'description' => 'Twitter consumer secret'],
								['key' => 'OAUTH_TOKEN', 'name' => 'Auth token', 'description' => 'Twitter oath token'],
								['key' => 'OAUTH_TOKEN_SECRET', 'name' => 'Auth token secret', 'description' => 'Twitter oath token secret'],
						]
				],
		];

		$data = [
				'socials' => $socials,
		];

		$admin_js     = plugins_url( '/', __FILE__ ) . 'build/admin.js';

				wp_enqueue_script(
				'social-media-station-admin',
				$admin_js,
				array('react', 'react-dom', 'wp-api', 'wp-components', 'wp-dom-ready', 'wp-element', 'wp-i18n'),
				1,
				true
		);

		wp_add_inline_script(
				'social-media-station-admin',
				'var socialMediaData = ' . wp_json_encode( $data ),
				'before'
		);

				$admin_css = 'build/admin.css';
		$dir = __DIR__;
		wp_enqueue_style(
				'social-media-station-admin',
				plugins_url( $admin_css, __FILE__ ),
				['wp-components'],
				filemtime( "$dir/$admin_css" )
		);

	}

// Register and enqueue admin scripts
	public function social_media_station_admin_scripts() {
		$dir = __DIR__;

		$script_asset_path = "$dir/build/admin.asset.php";

		if ( ! file_exists( $script_asset_path ) ) {
			throw new Error(
					'You need to run `npm start` or `npm run build` to build the asset files first.'
			);
		}

		$admin_js     = plugins_url( '/', __FILE__ ) . 'build/admin.js';
		wp_register_script(
				'social-media-station-admin',
				$admin_js,
				array('react', 'react-dom', 'wp-api', 'wp-components', 'wp-dom-ready', 'wp-element', 'wp-i18n'),
				1,
				false
		);

		wp_set_script_translations('social-media-station-admin', 'social-media-station'	);

	}


	public static function run() {
		if (!isset(self::$socialMediaStation)) {
			self::$socialMediaStation = new SocialMediaStation;
		}

		return self::$socialMediaStation;
	}
}

$app = SocialMediaStation::run();


