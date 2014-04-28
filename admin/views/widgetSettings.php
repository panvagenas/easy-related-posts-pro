<?php
/**
 * Represents the view for the widget settings.
 *
 * @package   Easy_Related_Posts
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Panagiotis Vagenas <pan.vagenas@gmail.com>
 */
?>
<input type="hidden" name="erpPRO_meta_box_nonce"
       value="<?php echo wp_create_nonce('erpPRO_meta_box_nonce'); ?>" />
<p>
    <label for="<?php echo $widgetInstance->get_field_id('title'); ?>"><?php _e('Title:'); ?>
        <input class="" size="39pt"
               id="<?php echo $widgetInstance->get_field_id('title'); ?>"
               name="<?php echo $widgetInstance->get_field_name('title'); ?>"
               type="text" value="<?php echo esc_attr($options['title']); ?>" /> </label>
</p>
<p>
    <label
        for="<?php echo $widgetInstance->get_field_id('numberOfPostsToDisplay'); ?>"><?php _e('Number of posts to show:'); ?>
        <input class="" size="3pt"
               id="<?php echo $widgetInstance->get_field_id('numberOfPostsToDisplay'); ?>"
               name="<?php echo $widgetInstance->get_field_name('numberOfPostsToDisplay'); ?>"
               type="number"
               value="<?php echo esc_attr($options['numberOfPostsToDisplay']); ?>" />
    </label> <label style="margin-left: 10px;"
                    for="<?php echo $widgetInstance->get_field_id('offset'); ?>"><?php _e('Offset:'); ?>
        <input class="" size="3pt"
               id="<?php echo $widgetInstance->get_field_id('offset'); ?>"
               name="<?php echo $widgetInstance->get_field_name('offset'); ?>"
               type="number" value="<?php echo esc_attr($options['offset']); ?>" />
    </label>
</p>
<p>
    <label for="<?php echo $widgetInstance->get_field_id('fetchBy'); ?>"><?php echo 'Rate posts by: '; ?>
        <select class=""
                id="<?php echo $widgetInstance->get_field_id('fetchBy'); ?>"
                name="<?php echo $widgetInstance->get_field_name('fetchBy'); ?>">
                    <?php
                    foreach (erpPRODefaults::$fetchByOptions as $k => $v) {
                        $valLow = strtolower(str_replace(',', '', str_replace(' ', '_', $v)));
                        ?>
                <option value="<?php echo $valLow; ?>" <?php selected($valLow, $options['fetchBy']); ?>><?php echo $v; ?></option>
                <?php
            }
            ?>
        </select> </label>
</p>
<p>
    <label
        for="<?php echo $widgetInstance->get_field_id('sortRelatedBy'); ?>"><?php echo 'Sort posts by: '; ?>
        <select class=""
                id="<?php echo $widgetInstance->get_field_id('sortRelatedBy'); ?>"
                name="<?php echo $widgetInstance->get_field_name('sortRelatedBy'); ?>">
                    <?php
                    $sortOptions = array(
                        'Date descending',
                        'Date ascending',
                        'Rating descending',
                        'Rating ascending',
                        'Date descending then Rating descending',
                        'Date ascending then Rating descending',
                        'Date descending then Rating ascending',
                        'Date ascending then Rating ascending',
                        'Rating descending then Date descending',
                        'Rating ascending then Date descending',
                        'Rating descending then Date ascending',
                        'Rating ascending then Date ascending',
                    );
                    foreach ($sortOptions as $key => $value) {
                        ?>
                <option
                    value="<?php echo strtolower(str_replace(' ', '_', $value)); ?>"
                    <?php selected($options['sortRelatedBy'], strtolower(str_replace(' ', '_', $value))); ?>>
                        <?php echo $value; ?>
                </option>
                <?php
            }
            ?>
        </select> </label>
</p>
<p>
    <label
        for="<?php echo $widgetInstance->get_field_id('wid_taxExlude'); ?>">
            <?php _e('Use taxonomies filter <span class="use-tax-filter erp-help-aster" id="excluder">*</span>'); ?>
        <input class=""
               id="<?php echo $widgetInstance->get_field_id('taxExclude'); ?>"
               name="<?php echo $widgetInstance->get_field_name('taxExclude'); ?>"
               type="checkbox" <?php echo checked($options['taxExclude']); ?> />
    </label>
</p>
<p>
    <label
        for="<?php echo $widgetInstance->get_field_id('ptypeExclude'); ?>">
            <?php _e('Use post type filter <span class="use-ptype-filter erp-help-aster" id="excluder-ptype">*</span>'); ?>
        <input class="erp_wid_opt5"
               id="<?php echo $widgetInstance->get_field_id('ptypeExclude'); ?>"
               name="<?php echo $widgetInstance->get_field_name('ptypeExclude'); ?>"
               type="checkbox" <?php echo checked($options['ptypeExclude']); ?> />
    </label>
</p>
<p>
    <label
        for="<?php echo $widgetInstance->get_field_id('hideIfNoPosts'); ?>">
        <?php _e('Hide if no posts to show:'); ?> <input class="erp_wid_opt5"
               id="<?php echo $widgetInstance->get_field_id('hideIfNoPosts'); ?>"
               name="<?php echo $widgetInstance->get_field_name('hideIfNoPosts'); ?>"
               type="checkbox" <?php echo checked($options['hideIfNoPosts']); ?> />
    </label>
</p>
<hr>
<p style="text-align: center">
    <strong>Content</strong>
</p>
<p>
    <label for="<?php echo $widgetInstance->get_field_id('content'); ?>"><?php echo 'Content to display: '; ?>
        <select class="" id="<?php echo $widgetInstance->get_field_id('content'); ?>"
                name="<?php echo $widgetInstance->get_field_name('content'); ?>">
                    <?php
                    foreach (erpPRODefaults::$contentPositioningOptions as $key => $value) {
                        $o = strtolower(str_replace(',', '', str_replace(' ', '-', $value)));
                        ?>
                <option
                    value="<?php echo $o; ?>"
                    <?php selected(implode('-', (array) $options['content']), $o); ?>>
                        <?php echo $value; ?>
                </option>
                <?php
            }
            ?>
        </select>
    </label>
</p>
<p style="text-align: center">
    <strong>Thumbnail</strong>
</p>
<p>
    <label
        for="<?php echo $widgetInstance->get_field_id('cropThumbnail'); ?>">
        <?php _e('Crop thumbnail:'); ?> <input class=""
               id="<?php echo $widgetInstance->get_field_id('cropThumbnail'); ?>"
               name="<?php echo $widgetInstance->get_field_name('cropThumbnail'); ?>"
               type="checkbox" <?php echo checked($options['cropThumbnail']); ?> />
    </label> <label style="margin-left: 1%;"
                    for="<?php echo $widgetInstance->get_field_id('thumbnailHeight'); ?>"><?php _e('Height:'); ?>
        <input class="" size="3pt"
               id="<?php echo $widgetInstance->get_field_id('thumbnailHeight'); ?>"
               name="<?php echo $widgetInstance->get_field_name('thumbnailHeight'); ?>"
               type="number"
               value="<?php echo esc_attr($options['thumbnailHeight']); ?>" /> </label> <label
        style="margin-left: 1%;"
        for="<?php echo $widgetInstance->get_field_id('thumbnailWidth'); ?>"><?php _e('Width:'); ?>
        <input class="erp_wid_opt2" size="3pt"
               id="<?php echo $widgetInstance->get_field_id('thumbnailWidth'); ?>"
               name="<?php echo $widgetInstance->get_field_name('thumbnailWidth'); ?>"
               type="number"
               value="<?php echo esc_attr($options['thumbnailWidth']); ?>" /> </label> <br>
    <label
        for="<?php echo $widgetInstance->get_field_id('defaultThumbnail'); ?>">
        <?php _e('Default thumbnail:'); ?> <input class=""
               id="<?php echo $widgetInstance->get_field_id('defaultThumbnail'); ?>"
               name="<?php echo $widgetInstance->get_field_name('defaultThumbnail'); ?>"
               size="24" type="text"
               value="<?php echo esc_attr($options['defaultThumbnail']); ?>" />
    </label>
</p>
<?php // TODO Thumbnail, title and exc and text mods should be configured per template basis ?>
<p style="text-align: center">
    <strong>Title</strong>
</p>
<table style="vertical-align: middle; width: auto;">
    <tr>
        <td>Post title size:</td>
        <td><label
                for="<?php echo $widgetInstance->get_field_id('postTitleFontSize'); ?>">
                <input size="1pt" class=""
                       id="<?php echo $widgetInstance->get_field_id('postTitleFontSize'); ?>"
                       name="<?php echo $widgetInstance->get_field_name('postTitleFontSize'); ?>"
                       type="number"
                       value="<?php echo esc_attr($options['postTitleFontSize']); ?>" />px
            </label></td>
            <td></td>
    </tr>
    <tr>
        <td>Post title color:</td>
        <td><label
                for="<?php echo $widgetInstance->get_field_id('postTitleColor'); ?>">
                <input class="wp-color-picker-field" data-default-color="#ffffff"
                       size="3pt"
                       id="<?php echo $widgetInstance->get_field_id('postTitleColor'); ?>"
                       name="<?php echo $widgetInstance->get_field_name('postTitleColor'); ?>"
                       type="text"
                       value="<?php echo esc_attr($options['postTitleColor']); ?>" />
            </label></td>
        <td><label
                for="<?php echo $widgetInstance->get_field_id('postTitleColorUse'); ?>"><?php _e('Use:'); ?>
                <input class="erp_wid_opt5"
                       id="<?php echo $widgetInstance->get_field_id('postTitleColorUse'); ?>"
                       name="<?php echo $widgetInstance->get_field_name('postTitleColorUse'); ?>"
                       type="checkbox"
                       <?php echo checked($options['postTitleColorUse']); ?> /> </label></td>
    </tr>
</table>
<p style="text-align: center">
    <strong>Excerpt</strong>
</p>
<table style="vertical-align: middle; width: auto;">
    <tr>
        <td>Excerpt text size:</td>
        <td><label
                for="<?php echo $widgetInstance->get_field_id('excFontSize'); ?>">
                <input size="1pt" class="zero-for-theme"
                       id="<?php echo $widgetInstance->get_field_id('excFontSize'); ?>"
                       name="<?php echo $widgetInstance->get_field_name('excFontSize'); ?>"
                       type="number"
                       value="<?php echo esc_attr($options['excFontSize']); ?>" />px
            </label></td>
            <td></td>
    </tr>
    <tr>
        <td>Excerpt text color:</td>
        <td><label
                for="<?php echo $widgetInstance->get_field_id('excColor'); ?>">
                <input class="wp-color-picker-field" data-default-color="#ffffff"
                       size="3pt"
                       id="<?php echo $widgetInstance->get_field_id('excColor'); ?>"
                       name="<?php echo $widgetInstance->get_field_name('excColor'); ?>"
                       type="text" value="<?php echo esc_attr($options['excColor']); ?>" />
            </label></td>
        <td><label
                for="<?php echo $widgetInstance->get_field_id('excColorUse'); ?>"><?php _e('Use:'); ?>
                <input class=""
                       id="<?php echo $widgetInstance->get_field_id('excColorUse'); ?>"
                       name="<?php echo $widgetInstance->get_field_name('excColorUse'); ?>"
                       type="checkbox" <?php echo checked($options['excColorUse']); ?> />
            </label></td>
    </tr>
</table>
<hr>
<p style="text-align: center">
    <strong>Themes</strong>
</p>
<p>
    <?php
    erpPROPaths::requireOnce(erpPROPaths::$erpPROWidTemplates);
    $temp = new erpPROWidTemplates();
    $templates = $temp->getTemplateNames();
    ?>
    <label for="<?php echo $widgetInstance->get_field_id('dsplLayout'); ?>">Template :</label>
    <select class="dsplLayout"
            data-widinst="<?php echo $widgetInstance->get_field_id('dsplLayout'); ?>"
            name="<?php echo $widgetInstance->get_field_name('dsplLayout'); ?>"
            id="<?php echo $widgetInstance->get_field_id('dsplLayout'); ?>">
                <?php
                foreach ($templates as $key => $val) {
                    $valLow = strtolower(str_replace(' ', '_', $val));
                    echo '<option value="' . $valLow . '"' . selected($options['dsplLayout'], $valLow, FALSE) . '>' . $val . '</option>';
                }
                ?>
    </select>
</p>
<p class="wid-inst-<?php echo $widgetInstance->get_field_id('dsplLayout'); ?>">
    <?php
    foreach ($templates as $key => $value) {
        $temp->load($value);
        $valLow = strtolower(str_replace(' ', '_', $value));
        echo '<span class="templateSettings" data-template="' . $valLow . '" hidden="hidden">';
        $temp->setOptions($options);
        echo $temp->renderSettings($widgetInstance);
        echo '</span>';
    }
    ?>

</p>
<script type="text/javascript">
	var templateRoot = "<?php echo $temp->getTemplatesBasePath(); ?>";
    jQuery(document).ready(function($) {

        jQuery('#<?php echo $widgetInstance->get_field_id("postTitleColor"); ?>').wpColorPicker();
        jQuery('#<?php echo $widgetInstance->get_field_id("excColor"); ?>').wpColorPicker();

    });
</script>