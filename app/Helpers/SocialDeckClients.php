<?php

namespace Nick\SocialMediaStation\Helpers;

use Nick\SocialMediaStation\ConfigsTrait;
use Nick\SocialMediaStation\Helpers\Clients\TwitterClient;
use Nick\SocialMediaStation\Helpers\Clients\FacebookClient;

class SocialDeckClients {

	use ConfigsTrait;

  /** @var array */
  protected $settings;

  protected $twitter;

  protected $facebook;

  public function __construct() {

    $this->settings = [
      'twitter' => [],
      'facebook' => [],
    ];

    $this->setup();
  }

  protected function setup() {
	  // Load options.
	  $config = get_option('social_media_station_settings_section');

	  $config = unserialize($config);
	  $config = $this->cleanConfigs($config);

    if (isset($config['twitter']['CONSUMER_KEY']) && $config['twitter']['CONSUMER_KEY']) {

      $this->settings['twitter'] = $config['twitter'];

      // 'CONSUMER_KEY', 'CONSUMER_SECRET', 'OAUTH_TOKEN', 'OAUTH_TOKEN_SECRET'
      $this->twitter = new TwitterClient($this->settings['twitter']);
    }

    if (isset($config['facebook']['APP_SECRET']) && $config['facebook']['APP_SECRET']) {
      $this->settings['facebook'] = $config['facebook'];

      //$this->facebook = new FacebookClient($this->settings['facebook']);
    }

	// @TODO for tiktok

  }


  /**
   * @return \Nick\SocialMediaStation\Helpers\Clients\FacebookClient
   */
  public function getFacebookInstance(){
    return $this->facebook;

  }

  /**
   * @return \Nick\SocialMediaStation\Helpers\Clients\TwitterClient;
   */
  public function getTwitterInstance(){
    return $this->twitter;
  }



}
