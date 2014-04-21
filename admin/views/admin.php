<?php

/**
 * Represents the view for the administration dashboard.
 *
 * @package   Easy_Related_Posts
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Panagiotis Vagenas <pan.vagenas@gmail.com>
 */
erpPROPaths::requireOnce(erpPROPaths::$erpPROHTMLHelper);

function erpPROTaxGrouping(Array $input) {
	$out =  array();
	foreach ($input as $key => $value) {
		$start = mb_substr($value->name, 0, 1);
		if (is_numeric($start)) {
			if (isset($out['0-9'])) {
				array_push($out['0-9'], $value);
			}else{
				$out['0-9'] = array($value);
			}
		} else {
			$start = strtoupper($start);
			if (isset($out[$start])) {
				array_push($out[$start], $value);
			}else{
				$out[$start] = array($value);
			}
		}
	}
	return $out;
}
?>

<div id="erp-opt-general" class="wrap">
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
	<form method="post" action="admin-post.php">

		<input type="hidden" name="action" value="save_<?php echo EPR_PRO_MAIN_OPTIONS_ARRAY_NAME; ?>" />
		<div id="tabs-holder">
			<ul>
				<li><a href="#tabs-1">General Options</a></li>
				<li><a href="#tabs-2">Content Options</a></li>
				<li><a href="#tabs-3">Layout Options</a></li>
				<li><a href="#tabs-4">Categories</a></li>
				<li><a href="#tabs-5">Tags</a></li>
				<li><a href="#tabs-6">Post Types</a></li>
			</ul>
			<div id="tabs-1">
				<table class="gen-opt-table">
					<tr>
						<th colspan="2">General Options</th>
					</tr>
					<?php
					echo erpPROHTMLHelper::optArrayRenderer($erpPROOptions,  'checkbox', 'Activate plugin', 'activate', array('title'=>'If you want to use only the widget of this plugin, uncheck this') );
					echo erpPROHTMLHelper::optArrayRenderer($erpPROOptions,  'text', 'Title to display', 'title', array('title'=>'The text that will appear above the posts') );
					echo erpPROHTMLHelper::optArrayRenderer($erpPROOptions,  'select', 'Rate posts by', 'fetchBy', erpPRODefaults::$fetchByOptions );
					?>
				</table>
			</div>
			<div id="tabs-2">
				<!--<h3>Content Options</h3>-->
				<table class="con-opt-table">
					<tr>
						<th colspan="2">Content Options</th>
					</tr>
					<?php
					echo erpPROHTMLHelper::optArrayRenderer($erpPROOptions,  'number', 'Number of posts to display', 'numberOfPostsToDisplay', array (
							'size' => '2pt',
							'title' => 'How many posts you\'d like to display'
					) );
					echo erpPROHTMLHelper::optArrayRenderer($erpPROOptions,  'number', 'Offset', 'offset', array (
							'size' => '2pt',
							'title' => 'If you set this as an integer x > 0, then the first x related posts will not be displayed'
					) );
					echo erpPROHTMLHelper::optArrayRenderer($erpPROOptions,  'select', 'Sort related by', 'sortRelatedBy', array (
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
					) );
					?>
				</table>
			</div>
			<div id="tabs-3">
				<table class="lay-opt-table">
					<tr>
						<th colspan="2">Layout Options</th>
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
										<?php selected(implode('-',(array)$erpPROOptions['content']), $o); ?>>
										<?php echo $value; ?>
									</option>
									<?php
								}
								?>
							</select>
						</td>
					</tr>
					<?php
					echo erpPROHTMLHelper::optArrayRenderer($erpPROOptions,  'checkbox', 'Crop thumbnail', 'cropThumbnail', array(
						'title' => 'Use this if you want the thumbnail to be croped.
                    				Setting the height to some value above zero and the width to zero will result in hard croped thumbnail.
                    				Setting both values above zero will result in soft croped, more artistic, thumbnail.') );
					echo erpPROHTMLHelper::optArrayRenderer($erpPROOptions,  'number', 'Thumbnail height', 'thumbnailHeight', array (
							'size' => '2pt'
					) );
					echo erpPROHTMLHelper::optArrayRenderer($erpPROOptions,  'number', 'Thumbnail width (optional)', 'thumbnailWidth', array (
							'size' => '2pt'
					) );
					?>
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
					<?php
					echo erpPROHTMLHelper::optArrayRenderer($erpPROOptions,  'number', 'Post title size (px)', 'postTitleFontSize', array (
							'size' => '2pt',
							'title' => 'Here you can specify the text size of post title.If left zero you themes default h3 will be used.'
					) );
					echo erpPROHTMLHelper::optArrayRenderer($erpPROOptions,  'number', 'Post excerpt size (px)', 'excFontSize', array (
							'size' => '2pt',
							'title' => 'Here you can specify the text size of post excerpt.If left zero you themes default paragraph will be used'
					) );
					echo erpPROHTMLHelper::optArrayRenderer($erpPROOptions,  'number', 'Excerpt length (words)', 'excLength', array (
							'size' => '2pt',
							'title' => 'How many words post excerpt will span before the read more text. Extremely usefull if you want to cut off large excerpts'
					) );
					echo erpPROHTMLHelper::optArrayRenderer($erpPROOptions,  'text', 'Read more text', 'moreTxt', array('tile' => 'The text that will apear after each post excerpt, if you choose to display it') );
				?>
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
						    erpPROPaths::requireOnce(erpPROPaths::$erpPROMainTemplates);
						    $temp = new erpPROMainTemplates();
						    $templates = $temp->getTemplateNames();
						    foreach ( $templates as $key => $val ) {
							$valLow = strtolower( str_replace( ' ', '_', $val ) );
							echo '<option value="' . $valLow . '"' . selected( $erpPROOptions['dsplLayout'], $valLow, FALSE ) . '>' . $val . '</option>';
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
					Any category you might choose here will be excluded from related
					posts. Also when user reads posts from these categories won't see
					any related post.<br>
				</p>
				<table class="cat-opt-table">
					<tr>
						<td><label for="select-all-cat">Check all :</label></td>
						<td><input type="checkbox" id="select-all-cat" class="select-all" title="Select-deselect all"></td>
					</tr>
				</table>
					<?php
					$opts = array (
							'hide_empty' => 0
					);
					$cats = get_categories( $opts );

					$tags = get_tags( $opts );
					?>
					<div class="<?php if (count($cats) > 30) echo 'erpAccordion'; ?>">
					<?php
					foreach (erpPROTaxGrouping($cats) as $key => $v) {
						?>
						<?php if (count($cats) > 30) echo '<h3>'.$key.'</h3>'; ?>
						<div>
						<table class="cat-opt-table">
						<?php
						foreach ( $v as $k => $value ) {
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
					Any tag you might choose here will be excluded from related posts.
					Also when user reads posts from these tags won't see any related
					post.<br> Please note that you must select <em>Tags</em> for <em>Get
						posts by</em> option in <em>General options</em> tab.
				</p>
				<table class="tag-opt-table">
					<tr>
						<td><label for="select-all-cat">Check all :</label></td>
						<td><input type="checkbox" id="select-all-tag" class="select-all" title="Select-deselect all"></td>
					</tr>
				</table>
					<?php
					$opts = array (
							'hide_empty' => 0
					);
					$cats = get_categories( $opts );

					$tags = get_tags( $opts );
					?>
					<div class="<?php if (count($cats) > 30) echo 'erpAccordion'; ?>">
					<?php
					foreach (erpPROTaxGrouping($tags) as $key => $v) {
						?>
						<?php if (count($cats) > 30) echo '<h3>'.$key.'</h3>'; ?>
						<div>
						<table class="tag-opt-table">
						<?php
						foreach ( $v as $k => $value ) {
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
					$post_types = get_post_types( array (
							'_builtin' => false
					), 'objects' );
					foreach ( $post_types as $k => $v ) {
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
					?>
					<tr>
						<td><h4>
								Built in post types
							</h4></td>
						<td><input type="checkbox" id="select-all-built-in"
							class="select-all"></td>
					</tr>
					<?php
					$post_types = get_post_types( array (
							'_builtin' => true
					), 'objects' );
					foreach ( $post_types as $k => $v ) {
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
		<?php echo get_submit_button( 'Update options', 'primary large', 'Save' ); ?>
	<?php //echo get_submit_button('Rebuild cache', 'button', 'rebuidCacheButton', true, 'readonly'); ?>
<input id="clearCacheButton" class="button" type="button" value="Clear cache" name="clearCacheButton">
<input id="rebuildCacheButton" class="button" type="button" value="Rebuild cache" name="rebuildCacheButton">
<input id="tab-spec" type="hidden" name="tab-spec" value="0">
		<script type="text/javascript">
			var templateRoot = "<?php echo $temp->getTemplatesBasePath(); ?>";
			var options = {};
			<?php
                        $tabSpec = filter_input(INPUT_GET, 'tab-spec');
			if ( $tabSpec !== null && $tabSpec !== false ) {
				echo 'options.active= ' . (int)$tabSpec . ';';
			}
			?>
                            console.log(options.active);
        </script>
	</form>
</div>
