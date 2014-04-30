<?php

/**
 * Grid template settings.
 *
 * This file will be loaded in plugin settings page
 * when grid template is sellected
 *
 * @package   Easy_Related_Posts_Templates_Main
 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @license   // TODO Licence
 * @link      http://erp.xdark.eu
 * @copyright 2014 Panagiotis Vagenas <pan.vagenas@gmail.com>
 */
?>
<p>
<label for="position">Possition: </label>
<select class="" id="position" name="position">
	<option value="top" <?php echo selected($position, 'top'); ?>>Top</option>
	<option value="right" <?php echo selected($position, 'right'); ?>>Right</option>
	<option value="bottom" <?php echo selected($position, 'bottom'); ?>>Bottom</option>
	<option value="left" <?php echo selected($position, 'left'); ?>>Left</option>
</select>
</p>
<p>
<label for="numOfPostsPerRow">Number of posts per row: </label>
<input class="erp-opttxt" id="numOfPostsPerRow" name="numOfPostsPerRow" type="number"value="<?php echo $numOfPostsPerRow; ?>"/>
</p>
<p>
<label for="backgroundColor">Background color: </label>
<input class="erp-opttxt" id="carouselMinVisible" name="carouselMinVisible" type="number"value="<?php echo $backgroundColor; ?>"/>
</p>
<p>
<label for="backgroundTransparency">Background transparency: </label>
<input class="erp-opttxt" id="backgroundTransparency" name="backgroundTransparency" type="number"value="<?php echo $backgroundTransparency; ?>"/>
</p>
<p>
<label for="triggerAfter">Trigger after: </label>
<input class="erp-opttxt" id="triggerAfter" name="triggerAfter" type="number"value="<?php echo $triggerAfter; ?>"/>
</p>