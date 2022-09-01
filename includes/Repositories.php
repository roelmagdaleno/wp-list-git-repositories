<?php

namespace Roel\WP\GitRepos;

use WP_Error;
use Roel\WP\GitRepos\Services\{
	Bitbucket,
	GitHub,
	GitLab,
};

class Repositories {
	/**
	 * Initialize the plugin functionality by registering action and filter hooks.
	 * It also registers the custom shortcode.
	 *
	 * @since 0.1.0
	 */
	public function hooks() {
		if ( is_admin() ) {
			return;
		}

		add_shortcode( 'git_repos', array( $this, 'render' ) );
	}

	/**
	 * Render the Git repositories table from shortcode.
	 * The shortcode accepts 2 parameters and can be used like this:
	 *
	 * [git_repos service="bitbucket" username="roelmagdaleno"]
	 * [git_repos service="github" username="roelmagdaleno"]
	 * [git_repos service="gitlab" username="roelmagdaleno"]
	 *
	 * If you don't specify the service and username, then these values
	 * will be filled from the settings.
	 *
	 * @since  0.1.0
	 *
	 * @param  array   $atts   The shortcode attributes.
	 * @return string
	 */
	public function render( array $atts ) : string {
		$settings   = get_option( 'gitrepos_settings', array() );
		$attributes = shortcode_atts( array(
			'service'  => $settings['service'] ?? 'github',
			'username' => $settings['username'] ?? '',
			'show'     => '-1',
		), $atts );

		if ( empty( $attributes['username'] ) ) {
			return $this->errors( 'username' );
		}

		$service  = strtolower( $attributes['service'] );
		$services = array(
			'bitbucket' => Bitbucket::class,
			'github'    => GitHub::class,
			'gitlab'    => GitLab::class,
		);

		if ( ! isset( $services[ $service ] ) ) {
			return $this->errors( 'service' );
		}

		$service      = new $services[ $service ];
		$repositories = $service->repositories( $attributes['username'] );

		if ( is_wp_error( $repositories ) ) {
			return $this->errors( $repositories );
		}

		wp_enqueue_style(
			'gitrepos-style',
			plugins_url( 'public/css/gitrepos.css', __DIR__ ),
			null,
			GITREPOS_VERSION
		);

		return $service->render( $attributes );
	}

	/**
	 * Get the error message.
	 *
	 * If you specify the `$error` as WP_Error instance then the error message
	 * will be used. Otherwise, if specify a string, that'll be appended to the full message.
	 *
	 * @since  0.1.0
	 *
	 * @param  string|WP_Error   $error   The error to show.
	 * @return string                     The full error message.
	 */
	protected function errors( $error ) : string {
		$msg = 'Git Repositories - Error: ';

		if ( is_wp_error( $error ) ) {
			return $msg . $error->get_error_message();
		}

		$errors = array(
			'username' => 'Missing username.',
			'service'  => 'Unknown service.',
		);

		return $msg . $errors[ $error ];
	}
}
