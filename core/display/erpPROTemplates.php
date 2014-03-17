<?php

namespace options;

use helpers\erpPROFileHelper;
use helpers\erpPROPaths;
use helpers\erpPRODBHelper;
/**
 *
 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
 */
abstract class erpPROTemplates {
	protected $templatesBasePath;
	protected $name;
	protected $description;
	protected $settingsFilePath;
	protected $viewFilePath;
	protected $options = array();
	protected $optionsArrayName;
	protected $cssFilePath;
	protected $jsFilePath;
	protected $optionSaveValidation;
	protected $templateBasePath;
	protected $uniqueInstanceID;

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

	public function getTemplatePath($templateName){
		$templates = self::dirToArray($this->templatesBasePath);
		foreach ($templates as $k => $v){
			if (strnatcasecmp($v, $templateName) == 0) {
				return $this->templatesBasePath . '/'.$v;
			}
		}
	}

	public function getTemplateXMLPath($templateName){
		if (empty($templateName) || empty($this->templatesBasePath)) {
			return false;
		}
		$templatePath = self::getTemplatePath($templateName, $this->templatesBasePath);
		$xmlFilePath = '';
		$dirContents = self::filesToArray($templatePath);

		foreach ($dirContents as $k => $v){
			if (strpos($v, '.xml')) {
				$xmlFilePath = $templatePath.'/'.$v;
			}
		}
		return $xmlFilePath;
	}

	public function getTemplateNames() {
		require_once erpPROPaths::requireOnce(erpPROPaths::$erpPROFileHelper);
		return erpPROFileHelper::dirToArray($this->templatesBasePath);
	}

	public function load($templateName){
		if (!in_array($templateName, $this->getTemplateNames())) {
			wp_die('Template not found!');
		}
		$templateXMLPath = $this->getTemplateXMLPath($templateName);
		if (empty($templateXMLPath)) {
			wp_die('Template XML not found!');
		}
		// initialize template components
		// TODO Remove debug
		do_action('debug',__FUNCTION__.__CLASS__);
		try {
			$contents = file_get_contents($templateXMLPath);
			$xml = new SimpleXMLElement($contents);
		} catch (Exception $e) {
			$er = new WP_Error();
			$er->add($e->getCode(), $e->getMessage());
		}
		// TODO Remove debug
		do_action('debug',__FUNCTION__.' reading options');
		$this->templateBasePath = pathinfo($templateXMLPath,PATHINFO_DIRNAME);
		if (isset($xml->name)) {
			$this->name = (string)$xml->name;
		}

		$this->uniqueInstanceID = uniqid($this->name);

		if (isset($xml->description)) {
			$this->description = (string)$xml->description;
		}
		if (isset($xml->options)) {
			$this->options = $this->xmlToArray($xml->options);
		}
		if (isset($xml->optionsArrayName)) {
			$this->optionsArrayName = (string)$xml->optionsArrayName;
			$optionsInDB = get_option($this->optionsArrayName);
			$this->setOptions($optionsInDB ? $optionsInDB : array());
		} elseif (isset($xml->options)){
			$this->optionsArrayName = $this->name . 'TemplateOptions';
			$optionsInDB = get_option($this->optionsArrayName);
			$this->setOptions($optionsInDB ? $optionsInDB : array());
		}
		if (isset($xml->viewFilePath)) {
			$this->viewFilePath = dirname($templateXMLPath).DIRECTORY_SEPARATOR.(string)$xml->viewFilePath;
		}
		if (isset($xml->settingsPageFilePath)) {
			$this->settingsFilePath = dirname($templateXMLPath).DIRECTORY_SEPARATOR.(string)$xml->settingsPageFilePath;
		}
		if (isset($xml->cssFilePath)) {
			$this->cssFilePath = $this->xmlToArray($xml->cssFilePath);
			$this->enqueCSS();
		}
		if (isset($xml->jsFilePath)) {
			$this->jsFilePath = $this->xmlToArray($xml->jsFilePath);
			$this->enqueJS();
		}
		if (isset($xml->optionSaveValidation)) {
			$this->optionSaveValidation = $this->xmlToArray($xml->optionSaveValidation);
			if (isset($this->optionSaveValidation['file']) && isset($this->optionSaveValidation['function'])) {
				require_once dirname($templateXMLPath).DIRECTORY_SEPARATOR.$this->optionSaveValidation['file'];
				add_filter('erpPROTemplateOptionsSaveValidation', $this->optionSaveValidation['function']);
			}
		}
	}

	protected function xmlToArray($xml){
		$json = json_encode($xml);
		return json_decode($json,TRUE);
	}

	protected function enqueCSS(){
		if (isset($this->cssFilePath) && is_array($this->cssFilePath) && is_admin_bar_showing() && !is_admin() || !is_admin()) {
			$plugin = easyRelatedPostsPRO::get_instance();
			foreach ($this->cssFilePath as $key => $value) {
				wp_enqueue_style(
				$key,
				$this->getUrl($value),
				array (), easyRelatedPostsPRO::VERSION );
			}

		}
		return $this;
	}

	protected function getUrl($templateFileRelativePath){
		$fullPath = $this->templateBasePath.DIRECTORY_SEPARATOR.$templateFileRelativePath;
		$templateParts = explode(DIRECTORY_SEPARATOR, $fullPath);
		$baseParts = explode(DIRECTORY_SEPARATOR, rtrim(EPR_PRO_BASE_PATH, '/ '));
		array_pop($baseParts);
		$relativeToPluginBase = array_diff($templateParts, $baseParts);
		return plugins_url(implode(DIRECTORY_SEPARATOR, $relativeToPluginBase));
	}

	protected function enqueJS(){
		if (isset($this->jsFilePath) && is_array($this->jsFilePath) && is_admin_bar_showing() && !is_admin() || !is_admin()) {
			$plugin = easyRelatedPostsPRO::get_instance();
			foreach ($this->jsFilePath as $key => $value) {
				if (is_array($value)) {
					wp_enqueue_script(
					$key,
					$this->getUrl($value['path']),
					$value['deps'],
					easyRelatedPostsPRO::VERSION );
				} else {
					wp_enqueue_script(
					$key,
					$this->getUrl($value),
					array ( ),
					easyRelatedPostsPRO::VERSION );
				}

			}
		}
		return $this;
	}

	public function renderSettings($echo = false) {
		// TODO Remove debug
		do_action('debug',__FUNCTION__.' rendering');
		if (isset($this->settingsFilePath)) {
			return erpPROView::render($this->settingsFilePath, $this->options, $echo);
		}
		return null;
	}

	public function render($postData, $echo = FALSE){
		// TODO Remove debug
		do_action('debug',__FUNCTION__.' rendering');
		if (isset($this->viewFilePath) && !empty($this->options) && !empty($postData)) {
			return erpPROView::render($this->viewFilePath, $this->options+$postData, $echo);
		} elseif (!empty($postData)){
			return erpPROView::render($this->viewFilePath, $postData, $echo);
		}
		return null;
	}

	public function display(WP_Query $wpq, $additionalOptions = array(), $ratings = array()){
		// TODO Remove debug
		do_action('debug',__FUNCTION__.' starting display');
		require_once erpPROPaths::requireOnce(erpPROPaths::$erpPROPostData);
		require_once erpPROPaths::requireOnce(erpPROPaths::$erpPRODBHelper);
		// TODO Remove debug
		do_action('debug',__FUNCTION__.' adding displayed');
		$from = get_the_ID();
		erpPRODBHelper::addDisplayed($from, array_keys($ratings));
		// TODO Remove debug
		do_action('debug',__FUNCTION__.' setting additional options');
		$this->setOptions($additionalOptions);

		$data = array();
		$data['title'] = $this->options['title'];
		$data['options'] = $this->options;
		$data['posts'] = array();
		$data['uniqueID'] = $this->uniqueInstanceID;
		// TODO Remove debug
		do_action('debug',__FUNCTION__.' forming postdata');
		while ($wpq->have_posts()) {
			$wpq->the_post();
			$rating = isset($ratings[get_the_ID()]) ? $ratings[get_the_ID()] : null;
			$postData = new erpPROPostData($wpq->post, $this->options, $rating, $from);
			array_push($data['posts'], $postData);
		}

		wp_reset_postdata();
		return $this->render($data);
	}

	public function saveTemplateOptions($newOptions) {
		if (empty($newOptions)) {
			return false;
		}
		foreach ($newOptions as $k => $v){
			if (!array_key_exists($k, $this->options)) {
				unset($newOptions[$k]);
			}
		}
		if (!isset($this->optionsArrayName)) {
			$this->optionsArrayName = $this->name . 'TemplateOptions';
		}
		$this->setOptions(apply_filters('erpPROTemplateOptionsSaveValidation', $newOptions));
		update_option($this->optionsArrayName, $this->options);
	}

	public function setOptions($options){
		$this->options = array_merge($this->options, $options);
		return $this;
	}

	public function getName() {
		return $this->name;
	}

	public function getDescription() {
		return $this->description;
	}

	public function getSettingsFilePath() {
		return $this->settingsFilePath;
	}

	public function getViewFilePath() {
		return $this->viewFilePath;
	}

	public function getOptions() {
		return $this->options;
	}
}

?>