<?php

namespace Roel\WP\GitRepos;

class Cache {
	protected static string $transient = 'gitrepos_for_';

	public static function set( string $service, $response ) {
		set_transient( self::$transient . $service, $response, 86400 );
		return $response;
	}

	public static function get( string $service ) {
		return get_transient( self::$transient . $service );
	}
}
