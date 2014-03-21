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
	<div class="erpNavArrow erpWidCarouPrev-<?php echo $widIDNumber; ?>"
		style="width:100%;height:50px;background-image:url(<?php echo plugin_dir_url(__FILE__) . '/assets/arrow-up.png'; ?> ); border-radius:5px 5px 0 0;"></div>
	<ul class="erpProWidCarousel erpProWidUl-<?php echo $widIDNumber; ?>" style="width:100%;"
		data-carouselAutoTime="<?php echo $options['carouselAutoTime'] > 0 ? $options['carouselAutoTime']*1000 : 'false'; ?>"
		data-carouselHeight="<?php echo $options['carouselHeight']; ?>"
		data-carouselPauseHover="<?php echo (bool)$options['carouselPauseHover'] ? 'true' : 'false'; ?>">
		<?php
		if ( isset( $posts ) ) {
			foreach ( $posts as $k => $v ) {
				?>
				<li class="erpProWidRelContainer">
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
	<div class="erpNavArrow erpWidCarouNext-<?php echo $widIDNumber; ?>"
		style="width:100%;height:50px;background-image:url(<?php echo plugin_dir_url(__FILE__) . '/assets/arrow-down.png'; ?> ); border-radius:0 0 5px 5px;"></div>

<script type="text/javascript" >
</script>