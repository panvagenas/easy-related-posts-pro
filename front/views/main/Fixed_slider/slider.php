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
<div id="erpProWraper">
	<h2 class="erp_h2" style="margin: 0px 0px 7px 1%;"><?php echo $title; ?></h2>
	<?php
	if ( isset( $posts ) ) {
		$rowCounter = 0;
		foreach ( $posts as $k => $v ) {
			if ($k % $options['numOfPostsPerRow'] === 0){
				?>
				<div class="erpRow">
				<?php
			}
			?>
			<div class="erpProRelContainer erpCol-sm-<?php echo 12 / (int)$options['numOfPostsPerRow']; ?>">
				<a href="<?php echo $v->getPermalink() ?>" class="erpProPostLink">
					<?php
					foreach ($options['content'] as $key => $value) {
						include plugin_dir_path(__FILE__).'components/'.$value.'.php';
					}
					?>
				</a>
			</div>
			<?php
			if ($k % $options['numOfPostsPerRow'] + 1 === $options['numOfPostsPerRow'] || count($posts) === $k+1){
				?>
				</div>
				<?php
			}
			?>
		<?php
		$rowCounter++;
		} // foreach ($posts as $k => $v)
	} // if (isset($posts))
	?>
</div>
<script type="text/javascript" >
	var position = "<?php echo $position; ?>";
	var backgroundColor = "<?php echo $backgroundColor; ?>";
	var triggerAfter = <?php echo $triggerAfter; ?>;
	var backgroundTransparency = <?php echo $backgroundTransparency; ?>;
</script>