<?php

namespace Nick\SocialMediaStation\Service;

use Nick\SocialMediaStation\Helpers\SocialDeckClients;
use Nick\SocialMediaStation\Service\SocialMediaPosts;

/**
 * Posts posts to social media.
 */
class PostToSocialMedia {
  private $socialMediaPosts;

  private static $social_data = [];

  public function __construct() {
    $this->socialMediaPosts = new SocialMediaPosts();
  }

  final function postToSocials() {
    $posts = $this->socialMediaPosts->getSocialPosts();
	// Post multiple posts on social media, update details too in metafields.
    if (!isset($posts[0])) return;
    $is_posted = FALSE;
    $clients = new SocialDeckClients();

    $posts_info = [];
	foreach ($posts as $key => $post) {
		// Twitter
		$tweet = $clients->getTwitterInstance();
		if ($tweet) {
			$tweet_res = $tweet->post($post);
			// If posted add is posted true and save::
			// save tweet id for use later too
			if ($tweet_res) {
				$is_posted = TRUE;
				$posts_info[$key]['tweet_id'] = $tweet_res;

				// @TODO better for performance.
				$this->socialMediaPosts->updatePost(
					$post->ID,
					$is_posted,
					$post);

			} // else do nothing

		}

		$facebook = $clients->getFacebookInstance();
		if ($facebook) {
			$res = $facebook->post($post);
			if ($res) {
				$is_posted = TRUE;
				$posts_info[$key]['facebook_id'] = $res;

				$this->socialMediaPosts->updatePost(
					$post->ID,
					$is_posted,
					$post);
			}

		}
	}

//	foreach ($posts_info as $post_info) {
//		// Finally Update with data
//		$this->socialMediaPosts->updatePost(
//			$post['id'],
//			$is_posted,
//			$post_info);
//	}
  }
}
