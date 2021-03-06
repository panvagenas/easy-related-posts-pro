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
class erpPROCarouselWidTheme extends erpPROTheme{

    /**
     * The name of the theme
     * @var string 
     */
    protected $name = 'Carousel';

    /**
     * A description for theme
     * @var string
     */
    protected $description = 'Carousel theme';

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
        'carouselAutoTime' => 3,
        'carouselPauseHover' => true,
        'carouselHeight' => 600
    );
    protected $css = array('assets/carousel.css');
    protected $js = array('assets/carousel.js');
    protected $preregScripts = array(
        'css' => array('erp_pro-bootstrap-text', 'erp_pro-erpPROCaptionCSS'),
        'js' => array('erp_pro-erpPROCaptionJS')
    );
    
    /**
     * Type of theme eg main, widget etc
     * @var string
     */
    protected $type = 'widget';
    
    /**
     * Always call the parent constructor at child classes
     */
    public function __construct() {
        $this->basePath = plugin_dir_path(__FILE__);        
        parent::__construct();
    }

    public function validateSettings($options){
        $newOptions = array (
			'carouselPauseHover' => isset( $options [ 'carouselPauseHover' ] ) ? true : false
	);
	if (isset($options['carouselAutoTime']) && $options['carouselAutoTime'] >= 0) {
		$newOptions['carouselAutoTime'] = $options['carouselAutoTime'] > 0 ? $options['carouselAutoTime'] : false;
	}
	if (isset($options['carouselHeight']) && $options['carouselHeight'] >= 0) {
		$newOptions['carouselHeight'] = $options['carouselHeight'];
	}
	return $newOptions;
    }

    public function renderW($widIDNumber, $path = '', Array $data = array(), $echo = false) {
        $this->setAdditionalViewData(array('widIDNumber' => $widIDNumber));
        return parent::render(plugin_dir_path(__FILE__).'carousel.php', $data, $echo);
    }
    
    public function renderSettings($widgetInstance, $filePath = '', $echo = false) {
        $this->options['widgetInstance'] = $widgetInstance;
        return parent::renderSettings(plugin_dir_path(__FILE__).'settings.php', $echo);
    }
}
