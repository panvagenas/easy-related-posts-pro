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
<table class="lay-opt-table">
    <tr>
        <td>
            <label for="numOfPostsPerRow">Number of posts per row: </label>
        </td>
        <td>
            <input class="erp-opttxt" id="numOfPostsPerRow" name="numOfPostsPerRow" type="number"value="<?php echo $numOfPostsPerRow; ?>" readonly>
            <div id="numOfPostsPerRowSlider"></div>
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
<script type="text/javascript">
    jQuery(document).ready(function($) {
        var valMap = [1,2,3,4,6,12];
        $("#numOfPostsPerRowSlider").slider({
            value: valMap.indexOf(<?php echo $numOfPostsPerRow; ?>),
            min: 0,
            max: valMap.length - 1,
            slide: function(event, ui) {
                $("#numOfPostsPerRow").val(valMap[ui.value]);
            }
        });
    });
</script>