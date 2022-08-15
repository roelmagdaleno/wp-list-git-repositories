<?php

namespace Roel\WP\GitRepos;

use WP_Error;

abstract class Git {
	public array $repositories;

	/**
	 * The Git service url to get the repositories.
	 *
	 * @since  0.1.0
	 *
	 * @return string   The Git service url to get the repositories.
	 */
	abstract public function url() : string;

	/**
	 * Get the Git repositories.
	 *
	 * @since  0.1.0
	 *
	 * @return array|WP_Error   The Git repositories.
	 */
	abstract public function repositories() : array;

	public function request( string $url = '' ) {
		$cached = Cache::get( $this->name );

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

		$body = wp_remote_retrieve_body( $response );

		return empty( $body )
			? new WP_Error( 'empty_body', 'There is no response from current request.' )
			: Cache::set( $this->name, $body );
	}
}
