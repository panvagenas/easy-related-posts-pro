<?php
/**
 * Represents the view for the administration dashboard.
 *
 * @package   Easy_Related_Posts
 * @author    Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @link      http://erp.xdark.eu
 * @copyright 2014 Panagiotis Vagenas <pan.vagenas@gmail.com>
 */
if (!function_exists('erpPROTaxGrouping')) {

    function erpPROTaxGrouping(Array $input) {
        $out = array();
        foreach ($input as $key => $value) {
            $start = mb_substr($value->name, 0, 1);
            if (is_numeric($start)) {
                if (isset($out['0-9'])) {
                    array_push($out['0-9'], $value);
                } else {
                    $out['0-9'] = array($value);
                }
            } else {
                $start = strtoupper($start);
                if (isset($out[$start])) {
                    array_push($out[$start], $value);
                } else {
                    $out[$start] = array($value);
                }
            }
        }
        return $out;
    }

}
?>

<div id="erp-opt-general" class="wrap">
    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>
    <form method="post" action="admin-post.php">

        <input type="hidden" name="action" value="save_<?php echo EPR_PRO_MAIN_OPTIONS_ARRAY_NAME; ?>" />
        <div id="tabs-holder">
            <ul>
                <li><a href="#tabs-1">General Options</a></li>
                <li><a href="#tabs-2">Content Options</a></li>
                <li><a href="#tabs-3">Layout Options</a></li>
                <li><a href="#tabs-4">Excluded Categories</a></li>
                <li><a href="#tabs-5">Excluded Tags</a></li>
                <li><a href="#tabs-6">Excluded Post Types</a></li>
            </ul>
            <div id="tabs-1">
                <table class="gen-opt-table">
                    <tr>
                        <td>
                            <label for="activate"> Activate plugin : </label>
                        </td>
                        <td>
                            <input 
                                id="activate" 
                                class="erp-optchbx" 
                                type="checkbox" 
                                <?php checked($erpPROOptions ['activate']); ?> 
                                data-tooltip
                                title="From here you can prevent the plugin from spanning in main content area. When this is checked the plugin displays related posts in main content area. If you unchecked it then no related posts will be displayed in main content area. Please note that this option doesn’t prevent the plugin to display  related posts in other areas like in sidebar as a widget or wherever you have included shortcodes" 
                                value="true" 
                                name="activate">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="disableTrackingSystem">Disable tracking system : </label>
                        </td>
                        <td>
                            <input 
                                id="disableTrackingSystem" 
                                class="erp-optchbx" 
                                type="checkbox" 
                                <?php checked($erpPROOptions ['disableTrackingSystem']); ?> 
                                data-tooltip
                                title="When tracking system is disabled then plugin won’t store any info in user's browser (cookie)." 
                                value="true" 
                                name="disableTrackingSystem">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="title">Title to display : </label>
                        </td>
                        <td>
                            <input 
                                id="title" 
                                class="erp-opttxt" 
                                type="text" 
                                value="<?php echo $erpPROOptions['title']; ?>" 
                                data-tooltip
                                title="This is the title that is displayed above related posts. You can leave this blank if you don’t want a title to be displayed but keep in mind that templates may override this options and display a default title in this case" 
                                name="title">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="fetchBy">Rate posts by :</label>
                        </td>
                        <td>
                            <select 
                                class="erp-optsel" 
                                id="fetchBy" 
                                name="fetchBy"
                                data-tooltip 
                                title="This is a critical options for Easy Related Posts. Upon this is based the way Easy Related Posts builds the relations between your posts and affects the result that will be displayed in the end user.

                                Easy Related Posts uses a intuitive algorithm to rate the relations between the posts in your site (you can read more in how it works page). Two main parameters in this algorithm are post categories and tags. This option defines the weight that these two parameters will have in rating. So when you choose only Categories then any post tags will be ignored when it comes to rating, if you choose Categories first, then tags then post categories will have more weight than tags etc.

                                Consider which taxonomy you use the most, which one describes the best your posts and choose the right option for you."
                                >
                                    <?php
                                    foreach (erpPRODefaults::$fetchByOptions as $key => $value) {
                                        $valLow = strtolower(str_replace(',', '', str_replace(' ', '_', $value)));
                                        ?>
                                    <option 
                                        value="<?php echo $valLow; ?>" 
                                        <?php selected($erpPROOptions['fetchBy'], $valLow) ?>>
                                            <?php echo $value; ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div id="tabs-2">
                <!--<h3>Content Options</h3>-->
                <table class="con-opt-table">
                    <tr>
                        <td>
                            <label for="numberOfPostsToDisplay">Number of posts to display :</label>
                        </td>
                        <td>
                            <input 
                                class="erp-opttxt" 
                                id="numberOfPostsToDisplay" 
                                name="numberOfPostsToDisplay" 
                                size="2pt" 
                                data-tooltip
                                title="This is the number of posts that will be displayed (if there are enough of course). Please use integers to populate this field" 
                                value="<?php echo $erpPROOptions['numberOfPostsToDisplay']; ?>" 
                                type="number">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="offset">Offset :</label>
                        </td>
                        <td>
                            <input 
                                class="erp-opttxt" 
                                id="offset" 
                                name="offset" 
                                size="2pt" 
                                data-tooltip
                                title="If you set this field in an integer x above zero then the first x related posts will not be displayed. Please use only positive integer numbers or 0 if you don’t want any offset to occur." 
                                value="<?php echo $erpPROOptions['offset']; ?>" 
                                type="number">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="sortRelatedBy">Sort related by :</label>
                        </td>
                        <td>
                            <select 
                                class="erp-optsel" 
                                id="sortRelatedBy" 
                                name="sortRelatedBy"
                                data-tooltip 
                                title="This is another critical field in Easy Related Posts. It describes how related posts will be sorted in order to display them in the front-end. Options are very descriptive and you should be able to understand in a glance their scope.

                                Keep in mind that Number of posts to display and Offset options may affect the sort order."
                                >
                                    <?php
                                    foreach (erpPRODefaults::$sortKeys as $key => $value) {
                                        ?>
                                    <option 
                                        value="<?php echo $key; ?>" 
                                        <?php selected($erpPROOptions['sortRelatedBy'], $key) ?>>
                                            <?php echo ucwords(str_replace('_', ' ', $key)); ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div id="tabs-3">
                <table class="lay-opt-table">
                    <tr>
                        <th colspan="2">Content</th>
                    </tr>
                    <tr>
                        <td>
                            Position: 
                        </td>
                        <td>
                            <select 
                                class="" 
                                id="relPosition" 
                                name="relPosition"
                                data-tooltip 
                                title="Choose the position of the related posts in main content area"
                                >
                                <option
                                    value="top"
                                    <?php selected($erpPROOptions['relPosition'], 'top'); ?>>
                                    Top
                                </option>
                                <option
                                    value="bottom"
                                    <?php selected($erpPROOptions['relPosition'], 'bottom'); ?>>
                                    Bottom
                                </option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="content">Content to display: </label>
                        </td>
                        <td>
                            <select class="" 
                                    id="content" 
                                    name="content"
                                    data-tooltip 
                                    title="From here you can choose the content for each related posts that will be displayed in the front-end. You have 7 options so you can choose exactly the content to display.

                                    Please note that templates may override this option and not all options are suitable for all templates. In example a template that is build to display post titles as a list may not give the more elegant appearance if you choose to display thumbnails also. So make the choice taking into account the chosen template and the options it provides you."
                                    >
                                        <?php
                                        foreach (erpPRODefaults::$contentPositioningOptions as $key => $value) {
                                            $o = strtolower(str_replace(',', '', str_replace(' ', '-', $value)));
                                            ?>
                                    <option
                                        value="<?php echo $o; ?>"
                                        <?php selected(implode('-', (array) $erpPROOptions['content']), $o); ?>>
                                            <?php echo $value; ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                </table>
                <table class="lay-opt-table">
                    <tr>
                        <th colspan="2">Thumbnail</th>
                    </tr>
                    <tr>
                        <td>
                            <label for="cropThumbnail">Crop thumbnail :</label>
                        </td>
                        <td>
                            <input 
                                class="erp-optchbx" 
                                id="cropThumbnail" 
                                name="cropThumbnail" 
                                type="checkbox" 
                                <?php checked($erpPROOptions['cropThumbnail']); ?>
                                value="true" 
                                data-tooltip
                                title="Use this  option if you want the thumbnail to be cropped.

                                Setting the width in the next option, to some value above zero and the height to zero will result in hard cropped thumbnail. Setting both values above zero will result in soft cropped, more artistic, thumbnail.

                                If both height and width are above zero, then thumbnail will be soft cropped." 
                                >
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="thumbnailHeight">Thumbnail height :</label>
                        </td>
                        <td>
                            <input 
                                class="erp-opttxt" 
                                id="thumbnailHeight" 
                                name="thumbnailHeight" 
                                size="2pt" 
                                value="<?php echo $erpPROOptions['thumbnailHeight']; ?>" 
                                type="number"
                                data-tooltip
                                title="Here you can set the height of the thumbnail that will be displayed in related post content.If you set both height and width to a value above zero then the thumbnail will be soft cropped.

                                Please set this as low as possible to prevent slow page loading from big images and use only positive integers to populate the field."
                                >
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="thumbnailWidth">Thumbnail width (optional) :</label>
                        </td>
                        <td>
                            <input 
                                class="erp-opttxt" 
                                id="thumbnailWidth" 
                                name="thumbnailWidth" 
                                size="2pt" 
                                value="<?php echo $erpPROOptions['thumbnailWidth']; ?>" 
                                type="number"
                                data-tooltip 
                                title="Here you can set the width of the thumbnail that will be displayed in related post content.If height is set to zero then this will result  in an image scaling.

                                Please set this as low as possible to prevent slow page loading from big images and use only positive integers to populate the field."
                                >
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="defaultThumbnail"> <?php _e('Default thumbnail URL:'); ?></label>
                        </td>
                        <td>
                            <input class=""
                                   data-tooltip
                                   title="If you have chosen to display a thumbnail for related posts but none is available for a certain post, then this post will use the thumbnail you choose here. The default thumbnail value that is set here, is used by all Easy Related Posts components.

                                   Please note that using external URLs is not allowed, so you must select an image from your gallery or under you WordPress installation folder."
                                   id="defaultThumbnail"
                                   name="defaultThumbnail"
                                   size="30" type="text"
                                   value="<?php echo $erpPROOptions['defaultThumbnail']; ?>" />
                        </td>
                    </tr>
                </table>
                <table class="lay-opt-table">
                    <tr>
                        <th colspan="2">Text</th>
                    </tr>
                    <tr>
                        <td>
                            <label for="postTitleFontSize">Post title size (px) :</label>
                        </td>
                        <td>
                            <input 
                                class="erp-opttxt" 
                                id="postTitleFontSize" 
                                name="postTitleFontSize" 
                                size="2pt" 
                                data-tooltip
                                title="Given an integer above zero will set the title font size in this value" 
                                value="<?php echo $erpPROOptions['postTitleFontSize']; ?>" 
                                type="number">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="postTitleColor">Post title text color: </label>
                        </td>
                        <td>
                            <input class="wp-color-picker-field" data-default-color="#ffffff"
                                   size="3pt"
                                   id="postTitleColor"
                                   name="postTitleColor"
                                   type="text" value="<?php echo $erpPROOptions['postTitleColor']; ?>" 
                                   data-tooltip
                                   title="Set the colour if the post title. Default color is white. If white is selected your themes default color for h4 heading, will be used as related posts title color." 

                                   />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="excFontSize">Post excerpt size (px) :</label>
                        </td>
                        <td>
                            <input 
                                class="erp-opttxt" 
                                id="excFontSize" 
                                name="excFontSize" 
                                size="2pt" 
                                data-tooltip
                                title="Given an integer above zero will set the title font size in this value" 
                                value="<?php echo $erpPROOptions['excFontSize']; ?>" 
                                type="number">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="excColor">Post excerpt text color: </label>
                        </td>
                        <td>
                            <input class="wp-color-picker-field" data-default-color="#ffffff"
                                   size="3pt"
                                   id="excColor"
                                   name="excColor"
                                   type="text" value="<?php echo $erpPROOptions['excColor']; ?>" 
                                   data-tooltip 
                                   title="Set the colour if the post excerpt. Default color is white. If white is selected your themes default color for paragraphs, will be used as related posts title color"
                                   />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="excLength">Excerpt length (words) :</label>
                        </td>
                        <td>
                            <input 
                                class="erp-opttxt" 
                                id="excLength" 
                                name="excLength" 
                                data-tooltip
                                title="You can set the length of the excerpt text in words through this field. This is pretty useful when you want to decrease the text that will be displayed as a description in a related post, so you will have" 
                                value="<?php echo $erpPROOptions['excLength']; ?>" 
                                type="number">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="moreTxt">Read more text :</label>
                        </td>
                        <td>
                            <input 
                                class="erp-opttxt" 
                                id="moreTxt" 
                                name="moreTxt" 
                                tile="The text that will apear after each post excerpt, if you choose to display it" 
                                value="<?php echo $erpPROOptions['moreTxt']; ?>" 
                                type="text">
                        </td>
                    </tr>
                </table>
                <table class="lay-opt-table">
                    <tr>
                        <th colspan="2">Theme options</th>
                    </tr>
                    <tr>
                        <td>
                            <label for="dsplLayout">Theme :</label>
                        </td>
                        <td>
                            <select 
                                class="dsplLayout"  
                                name="dsplLayout"
                                data-tooltip 
                                title="From the dropdown you can define the appearance of the plugin in the main content area. When a theme is selected the additional options will show up bellow theme selection dropdown"
                                >
                                    <?php
                                    erpPROPaths::requireOnce(erpPROPaths::$VPluginThemeFactory);
                                    VPluginThemeFactory::registerThemeInPathRecursive(erpPROPaths::getAbsPath(erpPROPaths::$mainThemesFolder));
                                    $templates = VPluginThemeFactory::getThemesNames();
                                    foreach ($templates as $key => $val) {
                                        echo '<option value="' . $val . '"' . selected($erpPROOptions['dsplLayout'], $val, FALSE) . '>' . $val . '</option>';
                                    }
                                    ?>
                            </select>
                        </td>
                    </tr>
                </table>
                <div class="templateSettings"></div>
            </div>
            <div id="tabs-4">
                <!--<h3>Categories</h3>-->
                <p>
                    In this tab you specify categories that you don’t want to fetch from or show, related posts. 
                    In order to exclude a category, that post must have all categories that are specified in 
                    this settings section. That means that if a post has categories foo and bar, then you must 
                    check both in Categories tab of the settings page. If you choose only one of them, then 
                    the post won’t be excluded.<br>
                    Please note that the selections of Categories, Tags or Post Types tabs, affects the main content plugin as much as widget and shortcode section of plugin
                </p>
                <table class="cat-opt-table">
                    <tr>
                        <td><label for="select-all-cat">Check all :</label></td>
                        <td><input type="checkbox" id="select-all-cat" class="select-all" data-tooltip title="Select-deselect all"></td>
                    </tr>
                </table>
                <?php
                $opts = array(
                    'hide_empty' => 0
                );
                $cats = get_categories($opts);

                $tags = get_tags($opts);
                ?>
                <div class="<?php if (count($cats) > 30) echo 'erpAccordion'; ?>">
                    <?php
                    foreach (erpPROTaxGrouping($cats) as $key => $v) {
                        ?>
                        <?php if (count($cats) > 30) echo '<h3>' . $key . '</h3>'; ?>
                        <div>
                            <table class="cat-opt-table">
                                <?php
                                foreach ($v as $k => $value) {
                                    ?>

                                    <tr>
                                        <td><label for="categories-<?php echo $value->term_id; ?>"><?php echo $value->name; ?>
                                                :</label></td>
                                        <td><input class="erp-optchbx cat" id="categories-<?php echo $value->term_id; ?>"
                                                   name="categories[]" type="checkbox"
                                                   value="<?php echo $value->term_id; ?>"
                                                   <?php if (in_array($value->term_id, $erpPROOptions['categories'])) echo 'checked="checked"'; ?> />
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                        </div>
                        <?php
                    }
                    ?>
                </div>

            </div>
            <div id="tabs-5">
                <!--<h3>Tags</h3>-->
                <p>
                    This tab works pretty much the same as the Categories tab, 
                    only that it refers to tags. Please note that if a post is 
                    excluded by Categories then even if it’s tags are not in the 
                    excluded ones, no related post will show up.<br>
                    Please note that the selections of Categories, Tags or Post Types tabs, affects the main content plugin as much as widget and shortcode section of plugin
                </p>
                <table class="tag-opt-table">
                    <tr>
                        <td><label for="select-all-cat">Check all :</label></td>
                        <td><input type="checkbox" id="select-all-tag" class="select-all" data-tooltip title="Select-deselect all"></td>
                    </tr>
                </table>
                <div class="<?php if (count($tags) > 30) echo 'erpAccordion'; ?>">
                    <?php
                    foreach (erpPROTaxGrouping($tags) as $key => $v) {
                        ?>
                        <?php if (count($tags) > 30) echo '<h3>' . $key . '</h3>'; ?>
                        <div>
                            <table class="tag-opt-table">
                                <?php
                                foreach ($v as $k => $value) {
                                    ?>

                                    <tr>
                                        <td><label for="tags-<?php echo $value->term_id; ?>"><?php echo $value->name; ?> :</label></td>
                                        <td><input class="erp-optchbx tag" id="tags-<?php echo $value->term_id; ?>" name="tags[]"
                                                   type="checkbox" value="<?php echo $value->term_id; ?>"
                                                   <?php if (in_array($value->term_id, $erpPROOptions['tags'])) echo 'checked="checked"'; ?> />
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div id="tabs-6">
                <!--<h3>Tags</h3>-->
                <p>
                    Here you can define post types that you want to exclude from related posts. 
                    If a post is of type that is checked here, then no related post will be shown when user 
                    browsing this post and of course it wont appear in related post of any other post.<br>
                    Please note that the selections of Categories, Tags or Post Types tabs, affects the main 
                    content plugin as much as widget and shortcode section of plugin.<br>
                <strong>Built in post types should be left in default values. Please use them only if you are 
                    experiencing post types relative issues.</strong>
                </p>
                <table class="type-opt-table">
                    <tr>
                        <td><h4>Custom post types</h4></td>
                        <td><input type="checkbox" id="select-all-custom"
                                   class="select-all"></td>
                    </tr>
                    <?php
                    $post_types = get_post_types(array(
                        '_builtin' => false
                            ), 'objects');
                    if(!empty($post_types)){
                        ?>
                        <?php 
                        foreach ($post_types as $k => $v) {
                            ?>
                            <tr>
                                <td><label for="custom-post-types-<?php echo $k; ?>"><?php echo $v->name; ?>
                                        :</label></td>
                                <td><input class="erp-optchbx custom" id="custom-post-types-<?php echo $k; ?>"
                                           name="postTypes[]" type="checkbox" value="<?php echo $k; ?>"
                                           <?php if (in_array($k, $erpPROOptions['postTypes'])) echo 'checked="checked"'; ?> />
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                            <tr>
                                <td colspan="2" style="text-align: center;">
                                    You don't have any custom post types
                                </td>
                            </tr>    
                        <?php 
                    }
                    ?>
                    <tr>
                        <td><h4>
                                Built in post types
                            </h4></td>
                        <td><input type="checkbox" id="select-all-built-in"
                                   class="select-all"></td>
                    </tr>
                    <?php
                    $post_types = get_post_types(array(
                        '_builtin' => true
                            ), 'objects');
                    foreach ($post_types as $k => $v) {
                        ?>
                        <tr>
                            <td><label for="builtin-post-types-<?php echo $k; ?>"><?php echo $v->name; ?>
                                    :</label></td>
                            <td><input class="erp-optchbx built-in" id="builtin-post-types-<?php echo $k; ?>"
                                       name="postTypes[]" type="checkbox" value="<?php echo $k; ?>"
                                       <?php if (in_array($k, $erpPROOptions['postTypes'])) echo 'checked="checked"'; ?> />
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
            <!--</div>-->
        </div>
        <?php echo get_submit_button('Update options', 'primary large', 'Save'); ?>
        <input id="tab-spec" type="hidden" name="tab-spec" value="0">
        <input id="clearCacheButton" class="button" type="button" value="Clear cache" name="clearCacheButton">
        <?php //<input id="rebuildCacheButton" class="button" type="button" value="Rebuild cache" name="rebuildCacheButton"> ?>
        <script type="text/javascript">
            var templateRoot = "<?php echo erpPROPaths::getAbsPath(erpPROPaths::$mainThemesFolder); ?>";
            var options = {};
<?php
$tabSpec = filter_input(INPUT_GET, 'tab-spec');
if ($tabSpec !== null && $tabSpec !== false) {
    echo 'options.active= ' . (int) $tabSpec . ';';
}
?>
        </script>
    </form>
</div>
