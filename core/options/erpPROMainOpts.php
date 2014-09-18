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
 * Main plugin options class.
 *
 * @package Easy_Related_Posts_Options
 * @author    Panagiotis Vagenas <pan.vagenas@gmail.com>
 */
class erpPROMainOpts extends erpPROOptions
{

    public function __construct()
    {
        parent::__construct();
        $this->optionsArrayName = EPR_PRO_MAIN_OPTIONS_ARRAY_NAME;
        $this->defaults = erpPRODefaults::$mainOpts + erpPRODefaults::$comOpts;
        $this->loadOptions();
    }

    public function loadOptions()
    {
        $opt = get_option($this->optionsArrayName);
        if ($opt) {
            $this->options = $opt;
        } else {
            $this->options = $this->defaults;
        }
    }

    /**
     * Deletes a single option from options array in DB
     *
     * @param string $optionName
     *            Option name
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    public function deleteOption($optionName)
    {
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
    public function validateMainOptions(Array $options)
    {
        return $this->switchValidationTypes($options, erpPRODefaults::$mainOptsValidations);
    }

    public function setLic($lic, $save = true)
    {
        $this->setOptions(array('licence' => $lic));
        if ($save) {
            $this->saveOptions($this->options);
        }
    }

    public function validLic($value = false)
    {
        return $this->chkLicence($value);
    }

    public function setRechkLic($chk, $save = true)
    {
        $this->options['rechkLic'] = $chk;
        if ($save) {
            $this->saveOptions($this->options);
        }
    }

    public function killLic($save = true)
    {
        $this->setLicStatus(false, $save);
    }

    public function setLicStatus($status, $save = TRUE)
    {
        $this->setOptions(array('licenceStatus' => $status));
        if ($save) {
            $this->saveOptions($this->options);
        }
    }

    public function saveOptions($newOptions)
    {
        $this->options = array_merge($this->options, $this->validateCommonOptions($newOptions) + $this->validateMainOptions($newOptions));
        update_option($this->optionsArrayName, $this->options);
    }

    /*     * **********************************************************************
     * Geters for options
     * ********************************************************************** */

    public function getActivate()
    {
        return $this->getValue('activate');
    }

    public function getCategories()
    {
        return $this->getValue('categories');
    }

    public function getTags()
    {
        return $this->getValue('tags');
    }

    public function getPostTypes()
    {
        return $this->getValue('postTypes');
    }

    public function getPosition()
    {
        return $this->getValue('relPosition');
    }

    public function getLicStatus()
    {
        return $this->getValue('licenceStatus');
    }

    public function getLic()
    {
        return $this->getValue('licence');
    }

    public function getRechkLic()
    {
        return $this->getValue('rechkLic');
    }

    public function getDisableTrackingSystem()
    {
        return $this->getValue('disableTrackingSystem');
    }

    public function chkLicence($lic = false)
    {
        erpPROPaths::includeUpdater();
        global $wp_version;

        $license = trim($lic ? $lic : $this->getLic());

        $api_params = array(
            'edd_action' => 'check_license',
            'license' => $license,
            'item_name' => urlencode(EDD_SL_ERP_PRO_ITEM_NAME),
            'url' => home_url()
        );

        // Call the custom API.
        $response = wp_remote_get(add_query_arg($api_params, EDD_SL_ERP_PRO_STORE_URL), array('timeout' => 15, 'sslverify' => false));


        if (is_wp_error($response)) {
            return 2;
        }

        $license_data = json_decode(wp_remote_retrieve_body($response));

        if ($license_data->license == 'valid') {
            return 1;
        } else {
            return 0;
        }
    }

}
