<?php

namespace Roel\WP\GitRepos\Services;

use Roel\WP\GitRepos\Git;

class Bitbucket extends Git {
	/**
	 * The Git service name.
	 *
	 * @since 0.1.0
	 *
	 * @var   string   $name   The Git service name.
	 */
	public string $name = 'bitbucket';

	/**
	 * The index of the repositories.
	 *
	 * @since 0.1.0
	 *
	 * @var   string   $index   The index of the repositories.
	 */
	public string $index = 'values';

	/**
	 * Get the Git repository HTML URL.
	 *
	 * @since  0.1.0
	 *
	 * @param  array   $repository   The Git repository.
	 * @return string                The Git repository HTML URL.
	 */
	public function html_url( array $repository ) : string {
		return $repository['links']['html']['href'];
	}

	/**
	 * Get the Git repository topics.
	 *
	 * @since  0.1.0
	 *
	 * @param  array   $repository   The Git repository.
	 * @return array                 The Git repository topics.
	 */
	public function topics( array $repository ) : array {
		return array( $repository['language'] );
	}

	/**
	 * The Git API url to get the repositories.
	 *
	 * @since  0.1.0
	 *
	 * @return string   The Git API url to get the repositories.
	 */
	public function api_url() : string {
		return 'https://api.bitbucket.org/2.0/repositories/' . $this->username;
	}
}
