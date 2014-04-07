<?php

/**
 * Grid template settings.
 *
 * This file will be loaded in plugin settings page
 * when grid template is sellected
 *
 * @package   Easy_Related_Posts_Templates_Main
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Panagiotis Vagenas <pan.vagenas@gmail.com>
 */
?>
<p>
<label for="carouselAutoTime">Auto scroll time: </label>
<input class="erp-opttxt" id="carouselAutoTime" name="carouselAutoTime" type="number"value="<?php echo $carouselAutoTime; ?>"/>
</p>
<p>
<label for="carouselMinVisible">Minimum visible items: </label>
<input class="erp-opttxt" id="carouselMinVisible" name="carouselMinVisible" type="number"value="<?php echo $carouselMinVisible; ?>"/>
</p>
<p>
<label for="carouselMaxVisible">Max visible items: </label>
<input class="erp-opttxt" id="carouselMaxVisible" name="carouselMaxVisible" type="number"value="<?php echo $carouselMaxVisible; ?>"/>
</p>
<p>
<label for="carouselPauseHover">Pause on hover: </label>
<input class="erp-optchbx" id="carouselPauseHover" name="carouselPauseHover" type="checkbox" <?php checked( (bool)$carouselPauseHover ); ?> />
</p>