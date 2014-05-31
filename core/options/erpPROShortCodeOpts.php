<?php

/**
 * Easy related posts PRO.
 *
 * @package   Easy_Related_Posts_Options
 * @author    Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @link      http://erp.xdark.eu
 * @copyright 2014 Panagiotis Vagenas <pan.vagenas@gmail.com>
 */
erpPROPaths::requireOnce(erpPROPaths::$erpPROOptions);

/**
 * Shortcode options class.
 *
 * @package Easy_Related_Posts_Options
 * @author  Panagiotis Vagenas <pan.vagenas@gmail.com>
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

    public function __construct() {
        parent::__construct();
        $this->optionsArrayName = erpPROShortCodeOpts::$shortCodeProfilesArrayName;
        $profiles = get_option(erpPROShortCodeOpts::$shortCodeProfilesArrayName);
        $this->profiles = is_array($profiles) ? $profiles : array();
        $this->defaults = erpPRODefaults::$shortCodeOpts + erpPRODefaults::$comOpts;
    }

    public function loadOptions($profileName) {
        $this->options = isset($this->profiles[$profileName]) ? $this->profiles[$profileName] : erpPRODefaults::$comOpts + erpPRODefaults::$shortCodeOpts;
        $this->profileName = $profileName;
        return $this;
    }

    public function isProfileLoaded() {
        return isset($this->profileName) && !empty($this->options);
    }

    /**
     * Validates shortcode options
     *
     * @param array $options New options
     * @return array Assoc array containg only the validated options
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    public function validateShortcodeOptions(Array $options) {
        return $this->switchValidationTypes($options, erpPRODefaults::$shortcodeOptsValidations);
    }

    public function saveOptions($newOptions) {
        // Validate template options
        $dsplLayout = isset($newOptions ['dsplLayout']) ? $newOptions ['dsplLayout'] : 'Grid';
        erpPROPaths::requireOnce(erpPROPaths::$VPluginThemeFactory);
        VPluginThemeFactory::registerThemeInPathRecursive(erpPROPaths::getAbsPath(erpPROPaths::$scThemesFolder), $dsplLayout);

        $theme = VPluginThemeFactory::getThemeByName($dsplLayout);
        $templateOptions = array();
        if ($theme) {
            $templateOptions = $theme->saveSettings($newOptions);
            foreach ($theme->getDefOptions() as $key => $value) {
                unset($newOptions [$key]);
            }
        }

        $this->options = $templateOptions + $this->validateCommonOptions($newOptions) + $this->validateShortcodeOptions($newOptions);

        if (isset($this->profileName)) {
            $this->profiles[$this->profileName] = array_merge(erpPRODefaults::$comOpts + erpPRODefaults::$shortCodeOpts, $this->options);
            return update_option(self::$shortCodeProfilesArrayName, $this->profiles);
        } else {
            return array_merge(erpPRODefaults::$comOpts + erpPRODefaults::$shortCodeOpts, $this->options);
        }
    }

    /*     * **********************************************************************
     * Geters for options
     * ********************************************************************** */

    public function getSuppressOthers() {
        return isset($this->options['suppressOthers']) ? $this->options['suppressOthers'] : erpPRODefaults::$shortCodeOpts['suppressOthers'];
    }

    public function getPostTitleColor() {
        return $this->getValue('postTitleColor');
    }

    public function getExcColor() {
        return $this->getValue('excColor');
    }

    public function getHideIfNoPosts() {
        return $this->getValue('hideIfNoPosts');
    }

}
