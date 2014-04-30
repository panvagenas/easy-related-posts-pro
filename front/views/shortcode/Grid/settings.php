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
<label for="numOfPostsPerRow">Number of posts per row: </label>
<input class="erp-opttxt" id="numOfPostsPerRow" name="numOfPostsPerRow" type="number"value="<?php echo $numOfPostsPerRow; ?>"/>
</p>
<p>
<label for="thumbCaption">Use thumbnail captions: </label>
<input class="erp-optchbx" id="thumbCaption" name="thumbCaption" type="checkbox" <?php checked( (bool)$thumbCaption ); ?> />
</p>