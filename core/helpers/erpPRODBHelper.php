<?php

/**
 *
 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
 */
class erpPRODBHelper {

	/**
	 */
	function __construct( ) { }

	/**
	 */
	function __destruct( ) { }

	/**
	 * Increases displayed values for given pids
	 *
	 * @param int $pid
	 * @param array $pids
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public static function addDisplayed( $pid, Array $pids ) {
		erpPROPaths::requireOnce(erpPROPaths::$erpPRODBActions);
		$db = erpPRODBActions::getInstance();
		$db->addDisplayed( $pid, $pids );
	}
}

?>