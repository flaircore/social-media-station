<?php
namespace Nick\SocialMediaStation\Service;

class SocialMediaPosts {

  public function getSocialPosts(){
	  // @TODO query against postAt block attr.
	  $args = array(
		  'post_type' => 'social_media',
		  'posts_per_page' => 20,
		  's' => 'social-media-station/content-block',
		  'meta_query' => array(
			  'relation' => 'AND',
			  // These posts don;t have _social_post_details updated yet.
			  array(
				  'key'     => '_social_post_details',
				  'compare' => 'NOT EXISTS',
			  ),
		  ),
	  );

	  $posts = new \WP_Query($args);

	  // Only posts whose post time is due.
	  if (!$posts->have_posts()) return;
	  $items = [];
	  /**
	   * @var  $index
	   * @var \WP_Post $post
	   */
	  foreach ($posts->get_posts() as $index => $post) {
		  // Posted posts have _social_post_details data, get those without,
		  // that the post time is due (past).

		  // Only first block
		  $block = parse_blocks($post->post_content)[0]['attrs']; //['mediaFiles'][0]
		  /** @var \DateTimeImmutable $now */
		  $now = new \DateTimeImmutable('now');
		  $postAt = new \DateTimeImmutable($block['postAt']);
		  if ($now->diff($postAt)->invert == 1) {
			  $post = [
				  'id' => $post->ID,
				  //'title' => $post->getTitle(),
				  'status' => $block['about'],
				  'link' => $block['url'],
				  'media' => $this->getMedia($block)
			  ];
			  $items[] = $post;
		  }
	  }

	return $items;

  }

	private function attachment_url_to_path( $url )
	{
		$parsed_url = parse_url( $url );
		if(empty($parsed_url['path'])) return false;
		$file = ABSPATH . ltrim( $parsed_url['path'], '/');
		if (file_exists( $file)) return $file;
		return false;
	}

  private function getMedia($blockData) {
    $media = [];
    foreach ($blockData['mediaFiles'] as $item) {
      $media[] = $this->attachment_url_to_path($item['url']);
    }
    return $media;
  }

  final public function updatePost($id, $is_posted, $data) {
   $data = serialize($data);
	  add_post_meta($id, '_social_post_details', $data, false);
  }
}
