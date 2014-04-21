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
<table class="lay-opt-table">
    <tr>
	<td>
	    <label for="position">Possition: </label>
	</td>
	<td>
	    <select class="" id="position" name="position">
		<option value="top" <?php echo selected($position, 'top'); ?>>Top</option>
		<option value="right" <?php echo selected($position, 'right'); ?>>Right</option>
		<option value="bottom" <?php echo selected($position, 'bottom'); ?>>Bottom</option>
		<option value="left" <?php echo selected($position, 'left'); ?>>Left</option>
	    </select>
	</td>
    </tr>
    <tr>
	<td>
	    <label for="numOfPostsPerRow">Number of posts per row: </label>
	</td>
	<td>
	    <input class="erp-opttxt" id="numOfPostsPerRow" name="numOfPostsPerRow" type="number"value="<?php echo $numOfPostsPerRow; ?>"/>
	</td>
    </tr>
    <tr>
	<td>
	    <label for="backgroundColor">Background color: </label>
	</td>
	<td>
	    <input class="erp-opttxt" id="backgroundColor" name="backgroundColor" type="number"value="<?php echo $backgroundColor; ?>"/>
	</td>
    </tr>
    <tr>
	<td>
	    <label for="backgroundTransparency">Background transparency: </label>
	</td>
	<td>
	    <input class="erp-opttxt" id="backgroundTransparency" name="backgroundTransparency" type="number"value="<?php echo $backgroundTransparency; ?>"/>
	</td>
    </tr>
    <tr>
	<td>
	    <label for="triggerAfter">Trigger after: </label>
	</td>
	<td>
	    <input class="erp-opttxt" id="triggerAfter" name="triggerAfter" type="number"value="<?php echo $triggerAfter; ?>"/>
	</td>
    </tr>
    <tr>
	<td>
	    <label for="thumbCaption">Use thumbnail captions: </label>
	</td>
	<td>
	    <input class="erp-optchbx" id="thumbCaption" name="thumbCaption" type="checkbox" <?php checked((bool) $thumbCaption); ?> />
	</td>
    </tr>
</table>