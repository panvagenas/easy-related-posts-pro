<?php

/*
 * Copyright (C) 2014 Panagiotis Vagenas <pan.vagenas@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * @copyright 2014 Panagiotis Vagenas <pan.vagenas@gmail.com>
 */
erpPROPaths::requireOnce(erpPROPaths::$erpPROTheme);

/**
 * Description of erpTheme
 * 
 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
 */
class erpPROSCCarouselTheme extends erpPROTheme {

    /**
     * The name of the theme
     * @var string 
     */
    protected $name = 'Float';

    /**
     * A description for theme
     * @var string
     */
    protected $description = 'Float theme';

    /**
     * An array name if you are going  to save options to DB
     * If no array name is defined then options wont get stored in DB. 
     * Instead they are validated and returned as an assoc array.
     * @var string Default is null 
     */
    protected $optionsArrayName;

    /**
     * An assoc array containing default theme options if any
     * @var array
     */
    protected $defOptions = array(
        'thumbCaption' => false,
        'backgroundColor' => '#ffffff',
        'borderColor' => '#ffffff',
        'borderRadius' => 0,
        'borderWeight' => 0,
        'showTitle' => false,
        'floatedAlign' => 'left',
        'floatedWidth' => 50
    );
    protected $css = array('assets/floated.css');
    protected $js = array();
    protected $preregScripts = array(
        'css' => array('erp_pro-bootstrap-text', 'erp_pro-erpPROCaptionCSS'),
        'js' => array('erp_pro-erpPROCaptionJS')
    );

    /**
     * Type of theme eg main, widget etc
     * @var string
     */
    protected $type = 'shortcode';

    /**
     * Always call the parent constructor at child classes
     */
    public function __construct() {
        $this->basePath = plugin_dir_path(__FILE__);
        parent::__construct();
    }

    public function validateSettings($options) {
        $newOptions = array(
            'showTitle' => isset($options ['showTitle']) ? true : false,
            'thumbCaption' => isset($options ['thumbCaption']) ? true : false,
            'backgroundColor' => isset($options['backgroundColor']) ? wp_strip_all_tags($options['backgroundColor']) : '#ffffff',
            'borderColor' => isset($options['borderColor']) ? wp_strip_all_tags($options['borderColor']) : '#ffffff',
            'floatedAlign' => isset($options['floatedAlign']) && ($options['floatedAlign'] == 'left' || $options['floatedAlign'] == 'right') ? wp_strip_all_tags($options['floatedAlign']) : 'left',
            'borderRadius' => isset($options ['borderRadius']) && (int) $options['borderRadius'] >= 0 ? (int) $options ['borderRadius'] : 0,
            'borderWeight' => isset($options ['borderWeight']) && (int) $options['borderWeight'] >= 0 ? (int) $options ['borderWeight'] : 0,
            'floatedWidth' => (isset($options ['floatedWidth']) && (int) $options['floatedWidth'] >= 10 && (int) $options['floatedWidth'] <= 100) ? (int) $options ['floatedWidth'] : 50
        );
        return $newOptions;
    }

    public function render($path = '', Array $data = array(), $echo = false) {
        return parent::render(plugin_dir_path(__FILE__) . 'floated.php', $data, $echo);
    }

    public function renderSettings($filePath = '', $echo = false) {
        return parent::renderSettings(plugin_dir_path(__FILE__) . 'settings.php', $echo);
    }

}
