<?php

namespace helpers;

/**
 *
 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
 */
class erpPRODBHelper {
	// TODO - Insert your code here

	/**
	 */
	function __construct( ) {

		// TODO - Insert your code here
	}

	/**
	 */
	function __destruct( ) {

		// TODO - Insert your code here
	}

	/**
	 * Increases displayed values for given pids
	 *
	 * @param int $pid
	 * @param array $pids
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public static function addDisplayed( $pid, Array $pids ) {
		require_once erpPRODefaults::getPath( 'db_actions' );
		$db = erpPRODBActions::getInstance();
		$db->addDisplayed( $pid, $pids );
	}
}

?>