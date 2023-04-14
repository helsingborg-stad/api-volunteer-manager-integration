<?php

namespace APIVolunteerManagerIntegration\Services\Volunteer;

use APIVolunteerManagerIntegration\Services\Volunteer\WpRestAdapter\PostsAdapter;
use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\PostType\Source\VQPosts;
use WP_Post;

class AssignmentService extends PostsAdapter implements VQPosts {
	public const TYPE = 'assignment';

	public function toPost( array $data ): WP_Post {
		return new WP_Post( (object) [
			'ID'                => $data['id'],
			'post_title'        => $data['title'],
			'post_name'         => $data['slug'],
			'post_content'      => $data['content']['rendered'] ?? $data['content'] ?? '',
			'post_excerpt'      => $data['content']['rendered'] ?? $data['content'] ?? '',
			'post_parent'       => 0,
			'menu_order'        => 0,
			'post_type'         => $data['type'],
			'post_status'       => 'publish',
			'comment_status'    => 'closed',
			'ping_status'       => 'closed',
			'comment_count'     => 0,
			'post_password'     => '',
			'to_ping'           => '',
			'pinged'            => '',
			'guid'              => '',
			'post_date'         => $data['date'] ?? current_time( 'mysql' ),
			'post_date_gmt'     => $data['date_gmt'] ?? current_time( 'mysql', 1 ),
			'post_modified'     => $data['modified'] ?? current_time( 'mysql' ),
			'post_modified_gmt' => $data['modified_gmt'] ?? current_time( 'mysql', 1 ),
			'post_author'       => is_user_logged_in() ? get_current_user_id() : 0,
			'is_virtual'        => true,
			'filter'            => 'raw'
		] );
	}
}