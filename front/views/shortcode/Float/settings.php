<?php
/**
 * Grid template settings.
 *
 * This file will be loaded in plugin settings page
 * when floated template is sellected
 *
 * @package   Easy_Related_Posts_Templates_Shortcode
 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @link      http://erp.xdark.eu
 * @copyright 2014 Panagiotis Vagenas <pan.vagenas@gmail.com>
 */
?>
<table class="lay-opt-table">
    <tr>
        <td>
            <label for="floatedWidth">Container width: </label>
        </td>
        <td>
            <input class="erp-opttxt" id="floatedWidth" name="floatedWidth" type="number" min="10" max="100" value="<?php echo $floatedWidth; ?>"/>%
        </td>
    </tr>
    <tr>
        <td>
            <label for="floatedAlign">Align: </label>
        </td>
        <td>
            <select id="floatedAlign" name="floatedAlign">
                <option value="left" <?php selected($floatedAlign, 'left'); ?>>Left</option>
                <option value="right" <?php selected($floatedAlign, 'right'); ?>>Right</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>
            <label for="showTitle">Show title: </label>
        </td>
        <td>
            <input class="erp-optchbx" id="showTitle" name="showTitle" type="checkbox" value="true" <?php checked((bool) $showTitle); ?> />
        </td>
    </tr>
    <tr>
        <td>
            <label for="thumbCaption">Use thumbnail captions: </label>
        </td>
        <td>
        <?php 
        if (class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'photon' ) ){
        	?>
        	<input class="erp-optchbx" id="thumbCaption" name="thumbCaption" type="checkbox" disabled="disabled" /> <small><i>Disable Jetpack Photon plugin to use this option</i></small>
        	<?php 
        } else {
        	?>
        	<input class="erp-optchbx" id="thumbCaption" name="thumbCaption" type="checkbox" <?php checked((bool) $thumbCaption); ?> />
        	<?php 
        }
        ?>
    </td>
    </tr>
    <tr>
        <td>
            <label for="backgroundColor">Background color: </label>
        </td>
        <td>
            <input class="erp-opttxt wp-color-picker-field" data-default-color="#ffffff" id="backgroundColor" name="backgroundColor" type="text" value="<?php echo $backgroundColor; ?>" />
        </td>
    </tr>
    <tr>
        <td>
            <label for="borderColor">Border color: </label>
        </td>
        <td>
            <input class="erp-opttxt wp-color-picker-field" data-default-color="#ffffff" id="borderColor" name="borderColor" type="text" value="<?php echo $borderColor; ?>" />
        </td>
    </tr>
    <tr>
        <td>
            <label for="borderWeight">Border weight: </label>
        </td>
        <td>
            <input class="erp-opttxt" id="borderWeight" name="borderWeight" type="number" min="0" value="<?php echo $borderWeight; ?>" />
        </td>
    </tr>
    <tr>
        <td>
            <label for="borderRadius">Border radius: </label>
        </td>
        <td>
            <input class="erp-opttxt" id="borderRadius" name="borderRadius" type="number" min="0" value="<?php echo $borderRadius; ?>" />
        </td>
    </tr>
</table>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#backgroundColor').wpColorPicker();
        $('#borderColor').wpColorPicker();
    });
</script>