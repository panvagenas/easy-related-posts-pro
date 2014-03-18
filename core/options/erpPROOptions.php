<?php

/**
 * Easy related posts PRO.
 *
 * @package   Easy_Related_Posts_Options
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
 */

/**
 * Options abstract class.
 *
 * @package Easy_Related_Posts_Options
 * @author Your Name <email@example.com>
 */
abstract class erpPROOptions {

	protected $options = NULL;

	protected $ratingSytem = NULL;

	protected $optionsArrayName = NULL;

	public function __construct( ) {
		$this->ratingSytem = isset( $this->options [ 'sortRelatedBy' ] ) ? ( bool ) strpos( $this->options [ 'sortRelatedBy' ], 'rating' ) : false;
	}

	// public function getTemplatePath($templatesPath){
	// erpPROPaths::requireOnce(erpPROPaths::$erpPROFileHelper);
	// $templates = erpPROFileHelper::dirToArray(erpPRODefaults::getPath('mainTemplates'));
	// $templateFolder = '';
	// foreach ($templates as $key => $value) {
	// if (strcasecmp(str_replace('_', ' ', $this->options['dsplLayout']), $value) === 0) {
	// $templateFolder = $value;
	// break;
	// }
	// }
	// return $templatesPath . '/' . $templateFolder . '/' . $this->options['dsplLayout'] . '.php';
	// }

	/**
	 * Loads the options from DB
	 *
	 * @return erpPROOptions
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function loadOptions(  ) {}

	/**
	 * Get option array
	 *
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 * @return array Options array
	 */
	public function getOptions( ) {
		return $this->options;
	}

	/**
	 * Sets options in instance options array.
	 * !IMPORTAND! Won't update options in DB, just sets them in instance options array.
	 *
	 * @param array $options
	 *        	New options as associative array
	 * @return erpPROOptions
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function setOptions( $options ) {
		$this->options = array_merge( $this->options, $options );
		return $this;
	}

	public function getSortRelatedBy( ) {
		if ( isset( $this->options [ 'sortRelatedBy' ] ) ) {
			return erpPRODefaults::$sortRelatedByOptionSerialized [ erpPRODefaults::$sortKeys [ $this->options [ 'sortRelatedBy' ] ] ];
		}
		return erpPRODefaults::$sortRelatedByOptionSerialized [ 0 ];
	}

	/**
	 * Get the value of given option.
	 *
	 * @param string $optionName
	 * @return null string NULL if option not found, option value otherwise
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function getValue( $optionName ) {
		return isset( $this->options [ $optionName ] ) ? $this->options [ $optionName ] : NULL;
	}

	/**
	 * Just unsets option value if present in objects instance options array
	 *
	 * @return boolean Deleted option value if exists, NULL otherwise
	 * @since 1.0.0
	 */
	public function deleteOption( $optionName ) {
		if ( array_key_exists( $optionName, $this->options ) ) {
			$this->options [ $optionName ] = $value;
			unset( $this->options [ $optionName ] );
			return $value;
		}
		return NULL;
	}

	/**
	 * Returns rating system field value.
	 * Instance scope
	 *
	 * @return boolean
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function isRatingSystemOn( ) {
		return $this->ratingSytem === NULL ? FALSE : $this->ratingSytem;
	}

	/**
	 * Checks if specified option exists
	 *
	 * @param string $optName
	 * @return boolean True if option is set, false otherwise
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since
	 *
	 *
	 *
	 *
	 */
	public function isOptionSet( $optName ) {
		return isset( $this->options [ $optName ] ) ? TRUE : FALSE;
	}
}