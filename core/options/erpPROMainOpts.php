<?php

/**
 * Easy related posts PRO.
 *
 * @package   Easy_Related_Posts_Options
 * @author    Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @license   // TODO Licence
 * @link      http://erp.xdark.eu
 * @copyright 2014 Panagiotis Vagenas <pan.vagenas@gmail.com>
 */
erpPROPaths::requireOnce(erpPROPaths::$erpPROOptions);

/**
 * Main plugin options class.
 *
 * @package Easy_Related_Posts_Options
 * @author    Panagiotis Vagenas <pan.vagenas@gmail.com>
 */
class erpPROMainOpts extends erpPROOptions {

    public function __construct() {
        parent::__construct();
        $this->optionsArrayName = EPR_PRO_MAIN_OPTIONS_ARRAY_NAME;
        $this->loadOptions();
        $this->defaults = erpPRODefaults::$mainOpts + erpPRODefaults::$comOpts;
    }

    public function loadOptions() {
        $this->options = get_option($this->optionsArrayName);
    }

    /**
     * Deletes a single option from options array in DB
     *
     * @param string $optionName
     *        	Option name
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    public function deleteOption($optionName) {
        if ($this->optionsArrayName === NULL) {
            return FALSE;
        }
        $value = parent::deleteOption($optionName);
        if ($value !== NULL) {
            if (update_option($this->optionsArrayName, $this->options)) {
                return TRUE;
            }
            $this->options [$optionName] = $value;
        }
        return FALSE;
    }

    /**
     * Validates main options
     *
     * @param array $options New options
     * @return array Assoc array containg only the validated options
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    public function validateMainOptions(Array $options) {
        return $this->switchValidationTypes($options, erpPRODefaults::$mainOptsValidations);
    }

    public function saveOptions($newOptions) {
        $this->options = $this->validateCommonOptions($newOptions) + $this->validateMainOptions($newOptions);

        update_option($this->optionsArrayName, $this->options);
    }

    /*     * **********************************************************************
     * Geters for options
     * ********************************************************************** */

    public function getActivate() {
        return $this->getValue('activate');
    }

    public function getCategories() {
        return $this->getValue('categories');
    }

    public function getTags() {
        return $this->getValue('tags');
    }

    public function getPostTypes() {
        return $this->getValue('postTypes');
    }

    public function getPosition() {
        return $this->getValue('relPosition');
    }

    public function getDisableTrackingSystem() {
        return $this->getValue('disableTrackingSystem');
    }

}
