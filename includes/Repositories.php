<?php

namespace Roel\WP\GitRepos;

use Roel\WP\GitRepos\Services\Bitbucket;
use Roel\WP\GitRepos\Services\GitHub;
use WP_Error;

class Repositories {
	public function hooks() {
		if ( is_admin() ) {
			return;
		}

		add_shortcode( 'git_repos', array( $this, 'render' ) );
	}

	public function render( $atts ) {
		$settings   = get_option( 'gitrepos_settings', array() );
		$attributes = shortcode_atts( array(
			'service'  => $settings['service'] ?? 'github',
			'username' => $settings['username'] ?? '',
		), $atts );

		if ( empty( $attributes['username'] ) ) {
			return $this->errors( 'username' );
		}

		$services = array(
			'bitbucket' => Bitbucket::class,
			'github'    => GitHub::class,
		);

		$service = strtolower( $attributes['service'] );

		if ( ! isset( $services[ $service ] ) ) {
			return $this->errors( 'service' );
		}

		$service      = new $services[ $service ];
		$repositories = $service->repositories();

		return is_wp_error( $repositories )
			? $this->errors( $repositories )
			: $service->render();
	}

	/**
	 * @param string|WP_Error   $error
	 * @return string
	 */
	protected function errors( $error ) : string {
		$msg = 'Git Repositories - Error: ';

		if ( is_wp_error( $error ) ) {
			return $msg . $error->get_error_message();
		}

		$errors = array(
			'username' => 'Missing username.',
			'service'  => 'Unknown service.',
		);

		return $msg . $errors[ $error ];
	}
}
