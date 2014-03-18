<?php

namespace display;

/**
 * Easy Related Posts PRO
 *
 * @package   Easy_Related_Posts_Core_display
 * @author    Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Panagiotis Vagenas
 */

/**
 * Renderer class.
 *
 * @package Easy_Related_Posts_Core_display
 * @author Your Name <email@example.com>
 */
class erpPROView {

	/**
	 * Renders a template
	 *
	 * @param string $filePath
	 *        	The path to markup file
	 * @param string $viewData
	 *        	Any data passed to markup file
	 * @param bool $echo If set to true echoes the out. Default is to return it
	 * @return string Rendered content
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public static function render( $filePath, $viewData = null, $echo = FALSE ) {
		( $viewData ) ? extract( $viewData ) : null;

		ob_start();
		include ( $filePath );
		$template = ob_get_contents();
		ob_end_clean();
		if (!$echo) {
			return $template;
		}
		echo $template;
	}
}