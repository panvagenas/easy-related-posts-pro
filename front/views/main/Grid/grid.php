<?php
/**
 * @title Grid
 * @description This is the template description
 * @options gridOptions.php
 * @settings gridSettings.php
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
?>
<div id="erpProContainer">
	<h2 class="erpProTitle" style="position:relative;"><?php if(isset($title)) echo $title; ?></h2>
	<div id="erpProWraper">
		<?php
		if ( isset( $posts ) ) {
			foreach ( $posts as $k => $v ) {
				if ($k % $options['numOfPostsPerRow'] === 0){
					?>
					<div class="erpRow">
					<?php
				}
				?>
				<div class="erpProRelContainer erpCol-sm-<?php echo 12 / $options['numOfPostsPerRow']; ?>">
					<a href="<?php echo $v->getPermalink() ?>" class="erpProPostLink">
						<?php
						foreach ($options['contentPositioning'] as $key => $value) {
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
			} // foreach ($posts as $k => $v)
		} // if (isset($posts))
		?>
	</div>
</div>