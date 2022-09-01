<?php

namespace Roel\WP\GitRepos;

class Render {
	/**
	 * Render the HTML for counters.
	 *
	 * @since  0.1.0
	 *
	 * @param  array   $repository   The Git repository.
	 * @return string                The HTML for counters.
	 */
	public static function counters( array $repository ) : string {
		if ( ! isset( $repository['counters'] ) ) {
			return '';
		}

		$html  = '<div class="gitrepos-counters">';

		foreach ( $repository['counters'] as $type => $counter ) {
			$html .= '<div class="gitrepos-count" title="' . $counter . ' ' . $type . '">';
			$html .= '<span class="gitrepos-count-value" aria-label="' . $counter . ' ' . $type . '">';
			$html .= $counter . '</span>';
			$html .= gitrepos_get_icon( $type ) . '</div>';
		}

		$html .= '</div>';

		return $html;
	}

	/**
	 * Render the HTML for description.
	 *
	 * @since  0.1.0
	 *
	 * @param  array   $repository   The Git repository.
	 * @return string                The HTML for description.
	 */
	public static function description( array $repository ) : string {
		if ( ! isset( $repository['description'] ) ) {
			return '';
		}

		$html  = '<p class="gitrepos-description">';
		$html .= $repository['description'];
		$html .= '</p>';

		return $html;
	}

	/**
	 * Render the HTML for topics.
	 *
	 * @since  0.1.0
	 *
	 * @param  array   $repository   The Git repository.
	 * @return string                The HTML for topics.
	 */
	public static function topics( array $repository ) : string {
		if ( ! isset( $repository['topics'] ) ) {
			return '';
		}

		$html = '<div class="gitrepos-topics">';

		foreach ( $repository['topics'] as $topic ) {
			$html .= '<span class="gitrepos-topic">' . $topic . '</span>';
		}

		$html .= '</div>';

		return $html;
	}
}
