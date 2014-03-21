<?php

/**
 * Represents the view for the administration dashboard.
 *
 * @package   Easy_Related_Posts
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
 */
erpPROPaths::requireOnce(erpPROPaths::$erpPROHTMLHelper);
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
					echo erpPROHTMLHelper::optArrayRenderer($erpPROOptions,  'checkbox', 'Activate plugin', 'activate' );
					echo erpPROHTMLHelper::optArrayRenderer($erpPROOptions,  'text', 'Title to display', 'title' );
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
							'size' => '2pt'
					) );
					echo erpPROHTMLHelper::optArrayRenderer($erpPROOptions,  'number', 'Offset', 'offset', array (
							'size' => '2pt'
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
					echo erpPROHTMLHelper::optArrayRenderer($erpPROOptions,  'checkbox', 'Crop thumbnail', 'cropThumbnail' );
					echo erpPROHTMLHelper::optArrayRenderer($erpPROOptions,  'number', 'Thumbnail height', 'thumbnailHeight', array (
							'size' => '2pt'
					) );
					echo erpPROHTMLHelper::optArrayRenderer($erpPROOptions,  'number', 'Thumbnail width (optional)', 'thumbnailWidth', array (
							'size' => '2pt'
					) );
					echo erpPROHTMLHelper::optArrayRenderer($erpPROOptions,  'number', 'Post title size (px)', 'postTitleFontSize', array (
							'size' => '2pt'
					) );
					echo erpPROHTMLHelper::optArrayRenderer($erpPROOptions,  'number', 'Post excerpt size (px)', 'excFontSize', array (
							'size' => '2pt'
					) );
					echo erpPROHTMLHelper::optArrayRenderer($erpPROOptions,  'number', 'Excerpt length (words)', 'excLength', array (
							'size' => '2pt'
					) );
					echo erpPROHTMLHelper::optArrayRenderer($erpPROOptions,  'text', 'Read more text', 'moreTxt' );
				?>
				</table>
				<?php
// 					erpPROHTMLHelper::requireFileHelper();
// 					$templates = erpPROFileHelper::dirToArray(erpPRODefaults::getPath('mainTemplates'));

					erpPROPaths::requireOnce(erpPROPaths::$erpPROMainTemplates);
					$temp = new erpPROMainTemplates();
					$templates = $temp->getTemplateNames();

					echo '<label for="dsplLayout">Display layout :</label>';
					echo '<select class="dsplLayout"  name="dsplLayout">';
					foreach ( $templates as $key => $val ) {
						$valLow = strtolower( str_replace( ' ', '_', $val ) );
						echo '<option value="' . $valLow . '"' . selected( $erpPROOptions['dsplLayout'], $valLow, FALSE ) . '>' . $val . '</option>';
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
						<td></td>
						<td><input type="checkbox" id="select-all-cat" class="select-all"></td>
					</tr>
					<?php
					$opts = array (
							'hide_empty' => 0
					);
					$cats = get_categories( $opts );
					$tags = get_tags( $opts );

					foreach ( $cats as $key => $value ) {
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
						<td></td>
						<td><input type="checkbox" id="select-all-tag" class="select-all"></td>
					</tr>
					<?php
					foreach ( $tags as $key => $value ) {
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
								Built in post types<span id="builtinwarn"
									style="color: #FF00FF; font-size: 140%;"> *</span>
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
		<input id="tab-spec" type="hidden" name="tab-spec">
		<script type="text/javascript">
			var templateRoot = "<?php echo $temp->getTemplatesBasePath(); ?>";
			var options = {};
			<?php
			if ( isset( $_GET [ 'tab-spec' ] ) && !empty( $_GET [ 'tab-spec' ] ) ) {
				echo 'options.active= ' . $_GET [ 'tab-spec' ] . ';';
			}
			?>
        </script>
	</form>
</div>
