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
 * @copyright 2014 Your Name or Company Name
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