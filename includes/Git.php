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
	 * Prepare the repositories' data.
	 *
	 * This function should run after the API request. Since all Git services
	 * return different API data, we should return the same data for all services.
	 *
	 * Cache the data, so we only store the data we need. Do not store the entire JSON data.
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
			$new_repositories[] = array(
				'counters'    => $this->counters( $repository ),
				'description' => $repository['description'],
				'fork'        => $this->fork( $repository ),
				'name'        => $repository['name'],
				'topics'      => $this->topics( $repository ),
				'url'         => $this->html_url( $repository ),
			);
		}

		return Cache::set( $this->name, $new_repositories );
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
		$cached = Cache::get( $this->name );

		if ( $cached ) {
			$this->repositories = $cached;
			return $this->repositories;
		}

		$this->username = $username;
		$api            = new API();
		$repositories   = $api->request( $this->api_url(), $this->index );

		if ( is_wp_error( $repositories ) ) {
			return $repositories;
		}

		$this->repositories = $this->prepare_repositories( $repositories );

		return $this->repositories;
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
	 * @param  array   $attributes   The shortcode attributes.
	 * @return string                The table's HTML.
	 */
	public function render( array $attributes ) : string {
		// Set the `$repositories` variable, so we can pass it to HTML template.
		$repositories = $this->repositories;

		/**
		 * Change the repositories' data before render in frontend.
		 *
		 * This filter hook will only change for the specific Git service,
		 * where `$this->name` is the Git service.
		 *
		 * Example:
		 * `add_filter( 'gr_github_repositories', 'filter' );`
		 *
		 * @since 0.1.0
		 *
		 * @param array   $repositories   The Git repositories.
		 */
		$repositories = apply_filters( 'gr_' . $this->name . '_repositories', $repositories );

		/**
		 * Change the repositories' data before render in frontend.
		 *
		 * This filter hook will change all Git services' data. If you want
		 * to change data for a specific service, then use the previous filter.
		 *
		 * @since 0.1.0
		 *
		 * @param array   $repositories   The Git repositories.
		 */
		$repositories = apply_filters( 'git_repositories', $repositories );

		if ( empty( $repositories ) ) {
			return 'Git Repositories - Error: There is no response from current request.';
		}

		if ( '-1' !== $attributes['show'] ) {
			$repositories = array_slice( $repositories, 0, (int) $attributes['show'] );
		}

		$view   = $attributes['as'];
		$layout = GITREPOS_PLUGIN_PATH . '/public/views/' . $view . '.php';

		if ( ! file_exists( $layout ) ) {
			return 'Git Repositories - Error: The render view does not exist.';
		}

		ob_start();
		include $layout;
		return ob_get_clean();
	}
}
