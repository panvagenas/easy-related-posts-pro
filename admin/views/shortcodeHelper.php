<?php
/**
 * Represents the view for the shortcode helper dialog.
 *
 * @package   Easy_Related_Posts_admin
 * @author    Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @license   // TODO Licence
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
<div id="erp-opt-general" class="erpModal-content">
    <!-- 	<form id="scForm" method="post" action="#"> -->
    <div id="tabs-holder">
        <ul>
            <li><a href="#tabs-0">Shortcode Profiles</a></li>
            <li><a href="#tabs-1">General Options</a></li>
            <li><a href="#tabs-2">Content Options</a></li>
            <li><a href="#tabs-3">Layout Options</a></li>
        </ul>
        <div id="tabs-0">
            <?php
            $profile = get_option($shortCodeProfilesArrayName);
            if ($profile === FALSE) {
                $profile = array('Basic' => erpPRODefaults::$comOpts + erpPRODefaults::$shortCodeOpts);
            }
            ?>
            <p>
                Profile: <select id="profile" class="erp-optsel" name="profile" style="min-width: 100px;">
                    <?php
                    foreach ((array) $profile as $key => $value) {
                        echo '<option value="' . $key . '" ' . selected($profileName, $key) . '>' . $key . '</option>';
                    }
                    ?>
                </select>
            </p>
            <?php
            $erpPROOptions = $erpPROOptions + erpPRODefaults::$comOpts + erpPRODefaults::$shortCodeOpts;
            ?>
            <p>
                <button type="submit" style=""id="saveProfile">Create new profile</button>
                <button type="submit" style="margin-left: 20px;"id="delProfile">Delete profile</button>
            </p>
        </div>
        <form id="scForm" method="post" action="#">
            <div id="tabs-1">
                <table class="gen-opt-table">
                    <tr>
                        <th colspan="2">General Options</th>
                    </tr>
                    <tr>
                        <td>
                            <label for="suppressOthers">Suppress others :</label>
                        </td>
                        <td>
                            <input 
                                class="erp-optchbx" 
                                id="suppressOthers" 
                                name="suppressOthers" 
                                <?php checked($erpPROOptions['suppressOthers']); ?>
                                value="true" 
                                type="checkbox">
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
                                title="The text that will appear above the posts" 
                                name="title">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="fetchBy">Rate posts by :</label>
                        </td>
                        <td>
                            <select class="erp-optsel" id="fetchBy" name="fetchBy">
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
                <table class="con-opt-table">
                    <tr>
                        <th colspan="2">Content Options</th>
                    </tr>
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
                                title="How many posts you'd like to display" 
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
                                title="If you set this as an integer x > 0, then the first x related posts will not be displayed" 
                                value="<?php echo $erpPROOptions['offset']; ?>" 
                                type="number">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="sortRelatedBy">Sort related by :</label>
                        </td>
                        <td>
                            <select class="erp-optsel" id="sortRelatedBy" name="sortRelatedBy">
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
                            <label for="content">Content to display: </label>
                        </td>
                        <td>
                            <select class="" id="content" name="content">
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
                                title="Use this if you want the thumbnail to be croped.
                                Setting the height to some value above zero and the width to zero will result in hard croped thumbnail.
                                Setting both values above zero will result in soft croped, more artistic, thumbnail." 
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
                                type="number">
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
                                type="number">
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
                                title="Here you can specify the text size of post title.If left zero you themes default h3 will be used." 
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
                                   type="text" value="<?php echo $erpPROOptions['postTitleColor']; ?>" />
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
                                title="Here you can specify the text size of post excerpt.If left zero you themes default paragraph will be used" 
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
                                   type="text" value="<?php echo $erpPROOptions['excColor']; ?>" />
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
                                size="2pt" 
                                data-tooltip
                                title="How many words post excerpt will span before the read more text. Extremely usefull if you want to cut off large excerpts" 
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
                            <select class="dsplLayout"  name="dsplLayout">
                                <?php
                erpPROPaths::requireOnce(erpPROPaths::$erpPROShortcodeTemplates);
                $temp = new erpPROShortcodeTemplates();
                                $templates = $temp->getTemplateNames();
                                foreach ($templates as $key => $val) {
                                    $valLow = strtolower(str_replace(' ', '_', $val));
                                    echo '<option value="' . $valLow . '"' . selected($erpPROOptions['dsplLayout'], $valLow, FALSE) . '>' . $val . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                </table>
                <div class="templateSettings"></div>
            </div>
        </form>
    </div>
    <!-- 	</form> -->
    <script type="text/javascript">
        (function($) {
            /***********************************************************************
             * tabs
             **********************************************************************/
            $('#tabs-holder').tabs();

            /***********************************************************************
             * init form
             **********************************************************************/
            // Store new profile functionality
            var formOptions = {
                url: ajaxurl,
                data: {action: 'erpsaveShortcodeProfile'},
                dataType: 'json'
            };
            $('#scForm').ajaxForm(formOptions);

            /***********************************************************************
             * Profile management
             **********************************************************************/
            $('#profile').change(function() {
                var dil = $('#erpDialogContent');
                var dialogContainer = $('#erpDialog');
                getData = {
                    action: 'erpgetShortCodeHelperContent',
                    profileName: $(this).val()
                };

                dil.html('');

                $.get(ajaxurl, getData, function(data) {
                    if (data.error !== undefined) {
                        alert('There was an error loading shortcode helper.');
                        dialogContainer.remove();
                        return;
                    }
                    dil.html(data);
                    dil.dialog('open');
                });
            });

            $('#saveProfile').click(function() {
                var profileName = prompt("Please enter profile name");
                if (profileName != null) {
                    var formOptionsNewProfile = formOptions;

                    formOptionsNewProfile.data.profileName = profileName;
                    formOptionsNewProfile.success = function(response) {
                        if (response.error !== undefined) {
                            alert(response.error);
                            return false;
                        }
                        $('#profile').append('<option value="' + response.profileName + '" selected>' + response.profileName + '</option>');
                        return true;
                    }
                    $('#scForm').ajaxSubmit(formOptionsNewProfile);
                } else {
                    alert('You must specify a profile name');
                }
            });

            $('#delProfile').click(function() {
                var r = confirm("Are you sure you want to delete profile " + $('#profile').val() + "?");
                if (r === false) {
                    return true;
                }
                var data = {
                    action: 'erpdeleteShortCodeProfile',
                    profileName: $('#profile').val()
                };
                $.post(
                        ajaxurl,
                        data,
                        function(response) {
                            if (response.error !== undefined) {
                                alert(response.error);
                                return false;
                            } else {
                                var dil = $('#erpDialogContent');
                                getData = {
                                    action: 'erpgetShortCodeHelperContent',
                                };
                                $.get(ajaxurl, getData, function(data) {
                                    if (data.error !== undefined) {
                                        alert('There was an error loading shortcode helper.');
                                        dialogContainer.remove();
                                        return;
                                    }
                                    dil.html(data);
                                });
                            }
                        },
                        'json');
            });
            /***********************************************************************
             * Load templates options
             **********************************************************************/
            $('.dsplLayout')
                .change(
                        function() {
                            var data = {
                                action: 'loadSCTemplateOptions',
                                template: $(this).val(),
                                profileName: $('#profile').val()
                            };

                            jQuery
                                    .post(
                                            ajaxurl,
                                            data,
                                            function(response) {
                                                if (response == false) {
                                                    alert('Template has no options or template folder couldn\'t be found');
                                                    $('.templateSettings').fadeOut('slow', null, function() {
                                                        $(this).html('');
                                                    });
                                                } else {
                                                    $('.templateSettings')
                                                            .html(
                                                                    response['content']).fadeIn('slow');
                                                }
                                            }, 'json');
                        });
        $('.dsplLayout').trigger('change');
        
        jQuery('#postTitleColor').wpColorPicker();
        jQuery('#excColor').wpColorPicker();
        
        $( document ).tooltip({ items: "[data-tooltip]" });
        })(jQuery);
    </script>
</div>