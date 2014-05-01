<?php
/**
 *
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
?>
<?php
/**
 * Giati to metro diabazetai mono otan den einai hidden?
 */
?>
<div id="metroW" style="width: 100%; "></div>
<div id="erpProContainer" class="{title:'<?php echo $title; ?>'}">
	<div id="erpProWraper">
		<?php
		if ( isset( $posts ) ) {
			foreach ( $posts as $k => $v ) {
// FIXME Not displaying properly
				if ($k % (int)$options['numOfPostsPerRow'] === 0){
					?>
					<div class="erpRow">
					<?php
				}
				?>
				<div class="erpProRelContainer erpCol-sm-<?php echo 12 / (int)$options['numOfPostsPerRow']; ?>">
					<a href="<?php echo $v->getPermalink() ?>" class="erpProPostLink" rel="nofollow">
						<?php
						foreach ($options['content'] as $key => $value) {
							include plugin_dir_path(__FILE__).'components/'.$value.'.php';
						}
						?>
					</a>
				</div>
				<?php
				if ($k % (int)$options['numOfPostsPerRow'] + 1 === (int)$options['numOfPostsPerRow'] || count($posts) === $k+1){
					?>
					</div>
					<?php
				}
				?>
			<?php
			} // foreach ($posts as $k => $v)
		} // if (isset($posts))
		?>
	</div>
</div>
<script type="text/javascript" >
	var position = "<?php echo $position; ?>";
	var triggerAfter = "<?php echo $triggerAfter; ?>";
</script>