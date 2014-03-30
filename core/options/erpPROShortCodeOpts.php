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
erpPROPaths::requireOnce(erpPROPaths::$erpPROOptions);
/**
 * Shortcode options class.
 *
 * @package Easy_Related_Posts_Options
 * @author Your Name <email@example.com>
 */
class erpPROShortCodeOpts extends erpPROOptions {
	public static $shortCodeProfilesArrayName = 'erpPROShortCodeProfiles';

	/**
	 * Profiles array as stored in DB
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $profiles;

	private $profileName;

	public function __construct( ) {
		parent::__construct();
		$this->optionsArrayName = erpPROShortCodeOpts::$shortCodeProfilesArrayName;
		$profiles = get_option(erpPROShortCodeOpts::$shortCodeProfilesArrayName);
		$this->profiles = is_array($profiles) ? $profiles : array();
	}

	public function loadOptions( $profileName ) {
		$this->options = isset($this->profiles[$profileName]) ? $this->profiles[$profileName] : erpPRODefaults::$comOpts+erpPRODefaults::$shortCodeOpts;
		$this->profileName = $profileName;
		return $this;
	}

	public function saveOptions( $newOptions ) {
		if ( isset( $newOptions [ 'title' ] ) ) {
			$this->options [ 'title' ] = strip_tags( $newOptions [ 'title' ] );
		}
		if ( isset( $newOptions [ 'numberOfPostsToDisplay' ] ) && $newOptions [ 'numberOfPostsToDisplay' ] > 0 ) {
			$this->options [ 'numberOfPostsToDisplay' ] = ( int ) $newOptions [ 'numberOfPostsToDisplay' ];
		}
		if ( isset( $newOptions [ 'fetchBy' ] ) ) {
			$this->options [ 'fetchBy' ] = strip_tags( $newOptions [ 'fetchBy' ] );
		}
		if ( isset( $newOptions [ 'offset' ] ) && $newOptions [ 'offset' ] >= 0 ) {
			$this->options [ 'offset' ] = ( int ) $newOptions [ 'offset' ];
		}
		if ( isset( $newOptions [ 'content' ] ) ) {
			$this->options [ 'content' ] = explode('-', strip_tags($newOptions [ 'content' ]) );
		}
		if ( isset( $newOptions [ 'sortRelatedBy' ] ) ) {
			$this->options [ 'sortRelatedBy' ] = strip_tags( $newOptions [ 'sortRelatedBy' ] );
		}
		if ( isset( $newOptions [ 'postTitleFontSize' ] ) && $newOptions [ 'postTitleFontSize' ] >= 0 ) {
			$this->options [ 'postTitleFontSize' ] = ( int ) $newOptions [ 'postTitleFontSize' ];
		}
		if ( isset( $newOptions [ 'excFontSize' ] ) && $newOptions [ 'excFontSize' ] >= 0 ) {
			$this->options [ 'excFontSize' ] = ( int ) $newOptions [ 'excFontSize' ];
		}
		if ( isset( $newOptions [ 'excLength' ] ) && $newOptions [ 'excLength' ] > 0 ) {
			$this->options [ 'excLength' ] = ( int ) $newOptions [ 'excLength' ];
		}
		if ( isset( $newOptions [ 'moreTxt' ] ) ) {
			$this->options [ 'moreTxt' ] = strip_tags( $newOptions [ 'moreTxt' ] );
		}
		if ( isset( $newOptions [ 'thumbnailHeight' ] ) && $newOptions [ 'thumbnailHeight' ] > 0 ) {
			$this->options [ 'thumbnailHeight' ] = ( int ) $newOptions [ 'thumbnailHeight' ];
		}
		if ( isset( $newOptions [ 'thumbnailWidth' ] ) && $newOptions [ 'thumbnailWidth' ] > 0 ) {
			$this->options [ 'thumbnailWidth' ] = ( int ) $newOptions [ 'thumbnailWidth' ];
		}
		if ( isset( $newOptions [ 'cropThumbnail' ] ) ) {
			$this->options [ 'cropThumbnail' ] = true;
		} else {
			$this->options [ 'cropThumbnail' ] = false;
		}

		if ( isset( $newOptions [ 'suppressOthers' ] ) ) {
			$this->options [ 'suppressOthers' ] = true;
		} else {
			$this->options [ 'suppressOthers' ] = false;
		}

		if ( isset( $newOptions [ 'popPos' ] ) ) {
			$this->options [ 'popPos' ] = strip_tags( $newOptions [ 'popPos' ] );
		}
		if ( isset( $newOptions [ 'popColor' ] ) ) {
			$this->options [ 'popColor' ] = strip_tags( $newOptions [ 'popColor' ] );
		}
		if ( isset( $newOptions [ 'popTriger' ] ) && $newOptions [ 'popTriger' ] > 0 ) {
			$this->options [ 'popTriger' ] = ( float ) $newOptions [ 'popTriger' ];
		}
		if ( isset( $newOptions [ 'popBkgTrns' ] ) && $newOptions [ 'popBkgTrns' ] > 0 ) {
			$this->options [ 'popBkgTrns' ] = ( float ) $newOptions [ 'popBkgTrns' ];
		}
		if ( isset( $newOptions [ 'dsplLayout' ] ) ) {
			$this->options [ 'dsplLayout' ] = strip_tags( $newOptions [ 'dsplLayout' ] );
			$templateOptions = (array)$this->getTemplateOptions($this->options [ 'dsplLayout' ], $newOptions);
			$this->options['templateOptions'] = $templateOptions;

		}
		if ( isset( $newOptions [ 'categories' ] ) ) {
			$this->options [ 'categories' ] = ( array ) $newOptions [ 'categories' ];
		} else {
			$this->options [ 'categories' ] = array();
		}
		if ( isset( $newOptions [ 'tags' ] ) ) {
			$this->options [ 'tags' ] = ( array ) $newOptions [ 'tags' ];
		} else {
			$this->options [ 'tags' ] = array();
		}
		if ( isset( $newOptions [ 'postTypes' ] ) ) {
			$this->options [ 'postTypes' ] = ( array ) $newOptions [ 'postTypes' ];
		} else {
			$this->options [ 'postTypes' ] = array();
		}

		if (isset($this->profileName)) {
			$this->profiles[$this->profileName] = array_merge(erpPRODefaults::$comOpts+erpPRODefaults::$shortCodeOpts, $this->options);
			return update_option(self::$shortCodeProfilesArrayName, $this->profiles);
		} else {
			return array_merge(erpPRODefaults::$comOpts+erpPRODefaults::$shortCodeOpts, $this->options);
		}
	}

	public function getTemplateOptions($templateName, $newOptions) {
		erpPROPaths::requireOnce(erpPROPaths::$erpPROShortcodeTemplates);
		$template = new erpPROShortcodeTemplates();
		$template->load($templateName);

		if ($template->isLoaded()) {
			return $template->saveTemplateOptions($newOptions);
		} else {
			return array();
		}
	}
}