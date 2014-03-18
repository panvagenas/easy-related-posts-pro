<?php
/**
 * Easy related posts PRO.
 *
 * @package   Easy_Related_Posts
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
 */

/**
 * Tracker class.
 *
 * @package Easy_Related_Posts
 * @author Your Name <email@example.com>
 */

class erpPROTracker {
	/**
	 * DB actions object
	 * @var erpPRODBActions
	 */
	private $db;

	private $wpSession;

	/**
	 * Constructor
	 *
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	function __construct( erpPRODBActions $dbActions, $wpSession ) {
		$this->db = $dbActions;
		$this->wpSession = $wpSession;
	}

	/**
	 * Tracking logic
	 *
	 * @since 1.0.0
	 */
	public function tracker( ) {
		if ( is_admin() ) {
			return;
		}

		$refererName = $this->getRefererName( isset( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : '' );
		$request = $this->getRequestString();
		$id = url_to_postid( $request );

		if ($id > 0) {
			$this->setAsVisited($id);
		}

		if (easyRelatedPostsPRO::get_instance()->isRatingSystemOn() && $refererName === 'local'){
			$parsedReq = $this->parseSearchQuery( $request );
			if ( isset($parsedReq['erp_from']) && $id > 0) {
				$this->db->addClick($parsedReq['erp_from'], $id);
			}
		}
	}

	/**
	 * Sets curent post as visited
	 *
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	private function setAsVisited( $pid ) {
		if ( isset( $this->wpSession [ 'visited' ] ) ) {
			$push = unserialize( $this->wpSession [ 'visited' ] );
			if ( !in_array( $pid, $push ) ) {
				array_push( $push, $pid );
				$this->wpSession [ 'visited' ] = serialize( $push );
			}
		} else {
			$this->wpSession [ 'visited' ] = serialize( array (
					$pid
			) );
		}
	}

	/**
	 * Get the referer string from server
	 *
	 * @return string $_SERVER['HTTP_REFERER'] if is set, empty string otherwise
	 * @since 1.0.0
	 */
	private function getRequestString( ) {
		return isset( $_SERVER['REQUEST_URI'] ) ? urldecode( $_SERVER['REQUEST_URI'] ) : '';
	}

	/**
	 * Get the referer
	 *
	 * @param string $refString
	 *        	The referer string ( $_SERVER [ 'HTTP_REFERER' ] like )
	 * @return string or boolean. The referer if found (local for local navigation) or false if ref not found
	 * @since 1.0.0
	 */
	private function getRefererName( $refString ) {
		if ( is_int( strpos( $refString, site_url() ) ) )
			return 'local';

		return 'unknown';
	}

	/**
	 * Parses a string and returns the PHP_URL_QUERY vars as assosiative array
	 *
	 * @param string $request
	 * @return array An assosiative array containing the search vars
	 * @since 1.0.0
	 */
	private function parseSearchQuery( $request ) {
		parse_str( parse_url( $request, PHP_URL_QUERY ), $out );
		if (!isset($out['p'])) {
			$out['p']=null;
		}
		return $out;
	}
}