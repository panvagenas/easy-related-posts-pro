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
	<ul id="erpProWraper">
		<?php
		if ( isset( $posts ) ) {
			foreach ( $posts as $k => $v ) {
				?>
				<li class="erpProRelContainer erpRow">
					<a href="<?php echo $v->getPermalink() ?>" class="erpProPostLink">
						<?php
						foreach ($options['content'] as $key => $value) {
							include plugin_dir_path(__FILE__).'components/'.$value.'.php';
						}
						?>
					</a>
				</li>
			<?php
			} // foreach ($posts as $k => $v)
		} // if (isset($posts))
		?>
	</ul>
