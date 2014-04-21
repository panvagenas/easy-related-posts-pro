<?php
/**
 * Represents the view for the shortcode helper dialog.
 *
 * @package   Easy_Related_Posts_admin
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
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
	    <li><a href="#tabs-4">Categories</a></li>
	    <li><a href="#tabs-5">Tags</a></li>
	    <li><a href="#tabs-6">Post Types</a></li>
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
		<!--<h3>Content Options</h3>-->
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
			<th colspan="2">Layout Options</th>
		    </tr>
		    <tr>
			<td><label for="content">Content to display: </label></td>
			<td><select class="" id="content" name="content">
				<?php
				foreach (erpPRODefaults::$contentPositioningOptions as $key => $value) {
				    $o = strtolower(str_replace(',', '', str_replace(' ', '-', $value)));
				    ?>
    				<option value="<?php echo $o; ?>"
					    <?php selected(implode('-', (array) $erpPROOptions['content']), $o); ?>>
						<?php echo $value; ?>
    				</option>
				    <?php
				}
				?>
			    </select></td>
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
		    <tr>
			<td>
			    <label for="defaultThumbnail"> <?php _e('Default thumbnail URL:'); ?></label>
			</td>
			<td>
			    <input class=""
				   title="Enter the url to an image you want to use as a default thumbnail"
				   id="defaultThumbnail"
				   name="defaultThumbnail"
				   size="30" type="text"
				   value="<?php echo $erpPROOptions['defaultThumbnail']; ?>" />
			</td>
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
				title="Here you can specify the text size of post title.If left zero you themes default h3 will be used." 
				value="<?php echo $erpPROOptions['postTitleFontSize']; ?>" 
				type="number">
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
				title="Here you can specify the text size of post excerpt.If left zero you themes default paragraph will be used" 
				value="<?php echo $erpPROOptions['excFontSize']; ?>" 
				type="number">
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
		<?php
		erpPROPaths::requireOnce(erpPROPaths::$erpPROShortcodeTemplates);
		$temp = new erpPROShortcodeTemplates();
		$templates = $temp->getTemplateNames();

		echo '<label for="dsplLayout">Display layout :</label>';
		echo '<select class="dsplLayout"  name="dsplLayout">';
		foreach ($templates as $key => $val) {
		    $valLow = strtolower(str_replace(' ', '_', $val));
		    echo '<option value="' . $valLow . '"' . selected($erpPROOptions['dsplLayout'], $valLow, FALSE) . '>' . $val . '</option>';
		}
		echo '</select>';
		?>
		<div class="templateSettings"></div>
	    </div>
	    <div id="tabs-4">
		<!--<h3>Categories</h3>-->
		<p>
		    Any category you might choose here will be excluded from related
		    posts. Also when user reads posts from these categories won't see
		    any related post.<br>
		</p>
		<table class="cat-opt-table">
		    <tr>
			<td><label for="select-all-cat">Check all :</label></td>
			<td><input type="checkbox" id="select-all-cat" class="select-all"></td>
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
		?>
	    </div>
	    <div id="tabs-5">
		<!--<h3>Tags</h3>-->
		<p>
		    Any tag you might choose here will be excluded from related posts.
		    Also when user reads posts from these tags won't see any related
		    post.<br> Please note that you must select <em>Tags</em> for <em>Get
			posts by</em> option in <em>General options</em> tab.
		</p>
		<table class="tag-opt-table">
		    <tr>
			<td><label for="select-all-tag">Check all :</label></td>
			<td><input type="checkbox" id="select-all-tag" class="select-all"></td>
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
		    Any post type you might choose here will be excluded from related
		    posts. Also when user reads posts from these types won't see any
		    related post.<br>
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
		    foreach ($post_types as $k => $v) {
			?>
    		    <tr>
    			<td><label for="custom-post-types-<?php echo $k; ?>"><?php echo $v->name; ?>
    				:</label></td>
    			<td><input class="erp-optchbx custom"
    				   id="custom-post-types-<?php echo $k; ?>" name="postTypes[]"
    				   type="checkbox" value="<?php echo $k; ?>"
				       <?php if (in_array($k, $erpPROOptions['postTypes'])) echo 'checked="checked"'; ?> />
    			</td>
    		    </tr>
			<?php
		    }
		    ?>
		    <tr>
			<td><h4>
				Built in post types<span id="builtinwarn"
							 style="color: #FF00FF; font-size: 140%;"> *</span>
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
    			<td><input class="erp-optchbx built-in"
    				   id="builtin-post-types-<?php echo $k; ?>" name="postTypes[]"
    				   type="checkbox" value="<?php echo $k; ?>"
				       <?php if (in_array($k, $erpPROOptions['postTypes'])) echo 'checked="checked"'; ?> />
    			</td>
    		    </tr>
			<?php
		    }
		    ?>
		</table>
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
		console.log("MY");
		var dil = $('#erpDialogContent');
		var dialogContainer = $('#erpDialog');
		getData = {
		    action: 'erpgetShortCodeHelperContent',
		    profileName: $(this).val() // TODO Set this dynamicaly
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
		var r = confirm("Are you sure you want to delete profile "+$('#profile').val()+"?");
		if (r === false){
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
				    profileName: 'grid' // TODO Set this to a default value
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
				var that = $(this).parent().children('.templateSettings');
				jQuery
					.post(
						ajaxurl,
						data,
						function(response) {
						    if (response == false) {
							alert('Template has no options or template folder couldn\'t be found');
							that.fadeOut('slow', null, function() {
							    $(this).html('');
							});
						    } else {
							that
								.html(
									response['content']).fadeIn('slow');
						    }
						}, 'json');
			    });
	    $('.dsplLayout').trigger('change');

	    /***********************************************************************
	     * Check all checkboxes
	     **********************************************************************/
	    $('#select-all-custom').click(function() {
		if (!$(this).is(':checked')) {
		    $('.custom').attr('checked', false);
		} else {
		    $('.custom').attr('checked', 'checked');
		}
	    });

	    $('.custom').change(function() {
		if ($('.custom:checked').length === $('.custom').length) {
		    $('#select-all-custom').attr('checked', 'checked');
		} else {
		    $('#select-all-custom').attr('checked', false);
		}
	    });

	    $('#select-all-built-in').click(function() {
		if (!$(this).is(':checked')) {
		    $('.built-in').attr('checked', false);
		} else {
		    $('.built-in').attr('checked', 'checked');
		}
	    });

	    $('.built-in').change(function() {
		if ($('.built-in:checked').length === $('.built-in').length) {
		    $('#select-all-built-in').attr('checked', 'checked');
		} else {
		    $('#select-all-built-in').attr('checked', false);
		}
	    });

	    $('#select-all-tag').click(function() {
		if (!$(this).is(':checked')) {
		    $('.tag').attr('checked', false);
		} else {
		    $('.tag').attr('checked', 'checked');
		}
	    });

	    $('.tag').change(function() {
		if ($('.tag:checked').length === $('.tag').length) {
		    $('#select-all-tag').attr('checked', 'checked');
		} else {
		    $('#select-all-tag').attr('checked', false);
		}
	    });

	    $('#select-all-cat').click(function() {
		if (!$(this).is(':checked')) {
		    $('.cat').attr('checked', false);
		} else {
		    $('.cat').attr('checked', 'checked');
		}
	    });

	    $('.cat').change(function() {
		if ($('.cat:checked').length === $('.cat').length) {
		    $('#select-all-cat').attr('checked', 'checked');
		} else {
		    $('#select-all-cat').attr('checked', false);
		}
	    });

	    $(".erpAccordion").accordion({heightStyle: "content", collapsible: true});

	})(jQuery);
    </script>
</div>