<?php

namespace Roel\WP\GitRepos\Services;

use Roel\WP\GitRepos\Git;

class GitHub extends Git {
	public string $name = 'github';

	public function repositories() : array {
		$repositories = $this->request( $this->url() );

		if ( is_wp_error( $repositories ) ) {
			return $repositories;
		}

		$this->repositories = $repositories;

		return $repositories;
	}

	/**
	 * The Git service url to get the repositories.
	 *
	 * @since  0.1.0
	 *
	 * @return string   The Git service url to get the repositories.
	 */
	public function url() : string {
		return 'https://api.github.com/users/' . $this->username() . '/repos';
	}

	/**
	 * The GitHub username.
	 * The class will retrieve the repositories from this user.
	 *
	 * @since  0.1.0
	 *
	 * @return string   The GitHub username.
	 */
	protected function username() : string {
		return 'roelmagdaleno';
	}
}
