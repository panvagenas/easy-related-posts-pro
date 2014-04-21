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
	    <label for="numOfPostsPerRow">Number of posts per row: </label>
	</td>
	<td>
	    <input class="erp-opttxt" id="numOfPostsPerRow" name="numOfPostsPerRow" type="number"value="<?php echo $numOfPostsPerRow; ?>"/>
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