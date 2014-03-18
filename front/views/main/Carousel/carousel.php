<?php
/**
 *
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
?>
<div id="metroW" style="display: none; width: 100%;"></div>
<div id="erpProContainer">
	<h2 class="erpProTitle" style="position:relative;"><?php if(isset($title)) echo $title; ?></h2>
	<div id="erpProWraper">
		<?php
		if ( isset( $posts ) ) {
			foreach ( $posts as $k => $v ) {
				?>
				<div class="erpProRelContainer" style="">
					<a href="<?php echo $v->getPermalink() ?>" class="erpProPostLink">
						<?php
						foreach ($options['contentPositioning'] as $key => $value) {
							include plugin_dir_path(__FILE__).'components/'.$value.'.php';
						}
						?>
					</a>
				</div>
			<?php
			} // foreach ($posts as $k => $v)
		} // if (isset($posts))
		?>
	</div>
	<div class="erpCarouPrev erpNavArrow erpNavArrowLeft"
		style="width:50px;height:50px;background-image:url(<?php echo plugin_dir_url(__FILE__) . '/assets/arrow-left.png'; ?> ); border-radius:0px 0 0 0px;"></div>
	<div class="erpCarouNext erpNavArrow erpNavArrowRight"
		style="width:50px;height:50px;background-image:url(<?php echo plugin_dir_url(__FILE__) . '/assets/arrow-right.png'; ?> ); border-radius:0 0px 0px 0;"></div>
</div>
<script type="text/javascript" >
	var carouselAutoTime = <?php echo $options['carouselAutoTime'] > 0 ? $options['carouselAutoTime']*1000 : 'false'; ?>;
	var carouselMinVisible = <?php echo $options['carouselMinVisible']; ?>;
	var carouselMaxVisible = <?php echo $options['carouselMaxVisible']; ?>;
	var carouselPauseHover = <?php echo (bool)$options['carouselPauseHover'] ? 'true' : 'false'; ?>;
</script>