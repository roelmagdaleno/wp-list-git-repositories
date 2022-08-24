<?php

namespace Roel\WP\GitRepos;

use WP_Error;

class API {
	/**
	 * Make API request to get the Git repositories.
	 *
	 * @since  0.1.0
	 *
	 * @param  string   $url     The Git service url to get the repositories.
	 * @param  string   $name    The Git service name.
	 * @param  string   $index   The index of the repositories.
	 * @return array|WP_Error    The Git repositories or WP_Error if fails.
	 */
	public function request( string $url, string $name, string $index ) {
		$cached = Cache::get( $name );

		if ( $cached ) {
			return $cached;
		}

		if ( empty( $url ) ) {
			return new WP_Error( 'empty_url', 'There is no URL to get the repositories.' );
		}

		$response = wp_remote_get( $url );

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		if ( $this->is_404( $response ) ) {
			return new WP_Error( 'is_404', 'The API request returned a 404 error.' );
		}

		$repositories = wp_remote_retrieve_body( $response );

		if ( empty( $repositories ) ) {
			return new WP_Error( 'empty', 'There is no response from current request.' );
		}

		$repositories = json_decode( $repositories, true );
		$repositories = empty( $index ) ? $repositories : $repositories[ $index ];

		return empty( $repositories )
			? new WP_Error( 'empty', 'There is no response from current request.' )
			: Cache::set( $name, $repositories );
	}

	/**
	 * Check if API response is HTTP 404.
	 *
	 * @since  0.1.0
	 *
	 * @param  array   $response   The API response.
	 * @return bool                Whether response is HTTP 404.
	 */
	protected function is_404( array $response ) : bool {
		return 404 === wp_remote_retrieve_response_code( $response );
	}
}
