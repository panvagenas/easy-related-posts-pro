<?php

/**
 * Basic widget template settings.
 *
 * This file will be loaded in widget settings page
 * when basic template is sellected
 *
 * @package   Easy_Related_Posts_Templates_Widget
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
 */
?>
<br>
<label for="<?php echo $widgetInstance->get_field_id('carouselPauseHover'); ?>">Pause on hover: </label>
<input class="erp-optchbx" id="<?php echo $widgetInstance->get_field_id('carouselPauseHover'); ?>" name="<?php echo $widgetInstance->get_field_name('carouselPauseHover'); ?>" type="checkbox" <?php checked( (bool)$carouselPauseHover ); ?> />
<br>
<label for="<?php echo $widgetInstance->get_field_id('carouselAutoTime'); ?>">Auto rotation time: </label>
<input class="" id="<?php echo $widgetInstance->get_field_id('carouselAutoTime'); ?>" name="<?php echo $widgetInstance->get_field_name('carouselAutoTime'); ?>" type="number" value="<?php echo $carouselAutoTime; ?>" />
<br>
<label for="<?php echo $widgetInstance->get_field_id('carouselHeight'); ?>">Overall height: </label>
<input class="" id="<?php echo $widgetInstance->get_field_id('carouselHeight'); ?>" name="<?php echo $widgetInstance->get_field_name('carouselHeight'); ?>" type="number" value="<?php echo $carouselHeight; ?>" />
<br>