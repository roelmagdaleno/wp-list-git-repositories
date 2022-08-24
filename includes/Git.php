<?php

namespace Roel\WP\GitRepos;

use WP_Error;

abstract class Git {
	/**
	 * The index of the repositories.
	 *
	 * @since 0.1.0
	 *
	 * @var   string   $index   The index of the repositories.
	 */
	public string $index = '';

	/**
	 * The Git username.
	 *
	 * @since 0.1.0
	 *
	 * @var   string   $username   The Git username.
	 */
	public string $username = '';

	/**
	 * The Git repositories.
	 *
	 * @since 0.1.0
	 *
	 * @var   array   $repositories   The Git repositories.
	 */
	public array $repositories;

	/**
	 * The Git API url to get the repositories.
	 *
	 * @since  0.1.0
	 *
	 * @return string   The Git API url to get the repositories.
	 */
	abstract public function api_url() : string;

	/**
	 * Sort the Git repositories by stargazers.
	 *
	 * @since  0.1.0
	 *
	 * @param  array   $repositories   The raw Git repositories.
	 * @return array                   The sorted Git repositories.
	 */
	public function sort( array $repositories ) : array {
		return $repositories;
	}

	/**
	 * Prepare the repositories' data.
	 *
	 * This function should run after the API request. Since all Git services
	 * return different API data, we should return the same data for all services.
	 *
	 * @since  0.1.0
	 *
	 * @param  array   $repositories   The Git repositories.
	 * @return array                   Prepare the repositories' data.
	 */
	public function prepare_repositories( array $repositories ) : array {
		if ( empty( $repositories ) ) {
			return $repositories;
		}

		$new_repositories = array();

		foreach ( $repositories as $repository ) {
			$new_repositories[] = [
				'counters'    => $this->counters( $repository ),
				'description' => $repository['description'],
				'fork'        => $this->fork( $repository ),
				'name'        => $repository['name'],
				'topics'      => $this->topics( $repository ),
				'url'         => $this->html_url( $repository ),
			];
		}

		return $new_repositories;
	}

	/**
	 * Get the Git repositories.
	 *
	 * @since  0.1.0
	 *
	 * @param  string   $username   The Git username.
	 * @return array|WP_Error       The Git repositories.
	 */
	public function repositories( string $username ) {
		$this->username = $username;

		$api          = new API();
		$repositories = $api->request( $this->api_url(), $this->name, $this->index );

		if ( is_wp_error( $repositories ) ) {
			return $repositories;
		}

		$repositories       = $this->prepare_repositories( $repositories );
		$repositories       = $this->sort( $repositories );
		$this->repositories = $repositories;

		return $repositories;
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
		return array();
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
		return false;
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
		return $repository['topics'];
	}

	/**
	 * Get the table's HTML.
	 * The `$repositories` variable should be set before calling this function.
	 *
	 * @since  0.1.0
	 *
	 * @return string   The table's HTML.
	 */
	public function render() : string {
		$repositories = $this->repositories;

		ob_start();
		include GITREPOS_PLUGIN_PATH . '/public/views/table.php';
		return ob_get_clean();
	}
}
