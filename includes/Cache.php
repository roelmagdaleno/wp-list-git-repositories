<?php

namespace Roel\WP\GitRepos;

class Cache {
	/**
	 * The transient key.
	 *
	 * @since 0.1.0
	 *
	 * @var   string   $transient   The transient key.
	 */
	const TRANSIENT_KEY = 'gitrepos_for_';

	/**
	 * The transient expiration.
	 *
	 * @since 0.1.0
	 *
	 * @var   string   $transient   The transient expiration.
	 */
	const EXPIRATION = 86400;

	/**
	 * Set the cache to a transient.
	 *
	 * @since  0.1.0
	 *
	 * @param  string   $service    The Git service.
	 * @param  array    $response   The API response.
	 * @return array                The API response.
	 */
	public static function set( string $service, array $response ) : array {
		set_transient( self::TRANSIENT_KEY . $service, $response, self::EXPIRATION );
		return $response;
	}

	/**
	 * Get the cached data from a transient.
	 *
	 * @since  0.1.0
	 *
	 * @param  string   $service   The Git service.
	 * @return mixed               The cached data.
	 */
	public static function get( string $service ) {
		return get_transient( self::TRANSIENT_KEY . $service );
	}
}
