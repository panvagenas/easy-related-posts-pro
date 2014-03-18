<?php

namespace helpers;

use cache\erpPRODBActions;
use helpers\erpPROPaths;

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
		require_once erpPROPaths::requireOnce(erpPROPaths::$erpPRODBActions);
		$db = erpPRODBActions::getInstance();
		$db->addDisplayed( $pid, $pids );
	}
}

?>