<?php

namespace Roel\WP\GitRepos\Services;

use Roel\WP\GitRepos\Git;

class GitHub extends Git {
	/**
	 * The Git service name.
	 *
	 * @since 0.1.0
	 *
	 * @var   string   $name   The Git service name.
	 */
	public string $name = 'github';

	/**
	 * Sort the GitHub repositories by stargazers.
	 *
	 * @since  0.1.0
	 *
	 * @param  array   $repositories   The raw GitHub repositories.
	 * @return array                   The sorted GitHub repositories.
	 */
	public function sort( array $repositories ) : array {
		usort( $repositories, function ( $a, $b ) {
			return ( $a['counters']['stargazers'] < $b['counters']['stargazers'] ) ? 1 : -1;
		} );

		return $repositories;
	}

	/**
	 * Get the Git repository HTML URL.
	 *
	 * @since  0.1.0
	 *
	 * @param  array   $repository   The Git repository.
	 * @return string                The Git repository HTML URL.
	 */
	public function html_url( array $repository ) : string {
		return $repository['html_url'];
	}

	/**
	 * Check if Git repository is from a fork.
	 *
	 * @since  0.1.0
	 *
	 * @param  array   $repository   The Git repository.
	 * @return bool                  Whether the Git repository is from a fork.
	 */
	public function fork( array $repository ) : bool {
		return $repository['fork'];
	}

	/**
	 * Get the Git repository counters.
	 * The counters can be the stargazers, forks, and more.
	 *
	 * @since  0.1.0
	 *
	 * @param  array   $repository   The Git repository.
	 * @return array                 The Git repository counters.
	 */
	public function counters( array $repository ) : array {
		return array(
			'stargazers' => $repository['stargazers_count'],
			'forks'      => $repository['forks_count'],
		);
	}

	/**
	 * The Git service url to get the repositories.
	 *
	 * @since  0.1.0
	 *
	 * @return string   The Git service url to get the repositories.
	 */
	public function api_url() : string {
		return 'https://api.github.com/users/' . $this->username . '/repos';
	}
}
