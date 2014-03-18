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
 * Activator class.
 *
 * @package Easy_Related_Posts
 * @author Your Name <email@example.com>
 */
 class erpPROActivator {
 	/**
 	 * Creates ERP PRO related table to DB
 	 *
 	 * @param string $tablePrefix The table prefix, default to current blog table prefix.
 	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
 	 * @since 1.0.0
 	 */
 	public static function createERPTable( $tablePrefix = FALSE) {
 		if (!$tablePrefix) {
 			global $wpdb;
 			$tablePrefix  = $wpdb->prefix;
 		}
 		/**
 		 * TODO Maybe we need a  more elegant way to add the table
 		 */
 		require_once ( ABSPATH . 'wp-admin/includes/upgrade.php' );

 		$sql = "CREATE TABLE IF NOT EXISTS " . $tablePrefix . ERP_PRO_RELATIVE_TABLE . " (
			pid1 bigint(20) NOT NULL,
 			post_date1 NOT NULL,
			score1_cats float NOT NULL,
			score1_tags float NOT NULL,
			displayed1 int(11) DEFAULT 0 NOT NULL,
			clicks1 int(11) DEFAULT 0 NOT NULL,
			pid2 bigint(20) NOT NULL,
 			post_date2 NOT NULL,
			score2_cats float NOT NULL,
			score2_tags float NOT NULL,
			clicks2 int(11) DEFAULT 0 NOT NULL,
			displayed2 int(11) DEFAULT 0 NOT NULL,
			time TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
			UNIQUE KEY id (pid1,pid2),
			PRIMARY KEY (pid1,pid2) );";

 		dbDelta( $sql );
 	}

	/**
	 * Checks the options names from array1 if they are pressent in array2
	 *
	 * @param array $array1 Associative options array (optionName => optionValue)
	 * @param array $array2 Associative options array (optionName => optionValue)
	 * @return array An array containing the options names that are present only in array1
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
 	public static function optionArraysDiff(Array $array1, Array $array2) {
 		$keys1 = array_keys($array1);
 		$keys2 = array_keys($array2);
 		return array_diff($keys1, $keys2);
 	}

	/**
	 * Inserts to main options array in DB values that are present in $newOpts and not in $oldOpts
	 *
	 * @param array $newOpts New options array
	 * @param array $oldOpts Old options array, default to main options present in DB
	 * @param string $optsName Options name, default to erp pro main options array
	 * @return boolean True if operation was succefull, false otherwise
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
 	public static function addNonExistingMainOptions(Array $newOpts, Array $oldOpts = NULL, $optsName = EPR_PRO_MAIN_OPTIONS_ARRAY_NAME) {
 		if (!is_string($optsName)) {
 			return FALSE;
 		}
 		if (empty($oldOpts)) {
 			$oldOpts = get_option($optsName);
 		}
 		$merged = is_array($oldOpts) ? $oldOpts+$newOpts : $newOpts;
 		return update_option($optsName, $merged);
 	}

 	/**
 	 * Inserts non existing widget options in DB that are present in $newOpts and not in $oldOpts
 	 * @param array $newOpts New options array
 	 * @param array $oldOpts Old options array, default to widget options present in DB
 	 * @param string $optsName Options name, default to erp pro widget options array
 	 * @return boolean False if operation was successfull, false otherwise
 	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
 	 * @since 1.0.0
 	 */
 	public static function addNonExistingWidgetOptions(Array $newOpts, Array $oldOpts = NULL, $optsName = 'widget_erpprowidget' ) {
 		if (!is_string($optsName)) {
 			return FALSE;
 		}
 		if (empty($oldOpts)) {
 			$oldOpts = get_option($optsName);
 		}
 		if (empty($oldOpts)) {
 			return add_option($optsName, array(1=>$newOpts));
 		}
 		foreach ($oldOpts as $k => $v){
 			if (is_array($v) && isset($v['title'])) {
 				$oldOpts[$k] = $oldOpts[$k]+$newOpts;
 			}
 		}
 		return update_option($optsName, $oldOpts);
 	}
 }