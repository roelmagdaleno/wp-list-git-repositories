<?php

namespace Roel\WP\GitRepos\Services;

use Roel\WP\GitRepos\Git;

class GitLab extends Git {
	/**
	 * The Git service name.
	 *
	 * @since 0.1.0
	 *
	 * @var   string   $name   The Git service name.
	 */
	public string $name = 'gitlab';

	/**
	 * Get the Git repository HTML URL.
	 *
	 * @since  0.1.0
	 *
	 * @param  array   $repository   The Git repository.
	 * @return string                The Git repository HTML URL.
	 */
	public function html_url( array $repository ) : string {
		return $repository['web_url'];
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
			'stargazers' => $repository['star_count'],
			'forks'      => $repository['forks_count'],
		);
	}

	/**
	 * The Git API url to get the repositories.
	 *
	 * @since  0.1.0
	 *
	 * @return string   The Git API url to get the repositories.
	 */
	public function api_url() : string {
		return 'https://gitlab.com/api/v4/users/' . $this->username . '/projects';
	}
}
