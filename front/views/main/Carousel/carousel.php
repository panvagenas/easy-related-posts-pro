<?php
/**
 *
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
$containerClass = $uniqueID.'Container';
$thumbClass = $uniqueID.'Thumbnail';
$titleClass = $uniqueID.'PostTitle';
$excClass = $uniqueID.'Exc';
$wraperClass = $uniqueID.'Wraper';
$navLeft = $uniqueID.'NavLeft';
$navRight = $uniqueID.'NavRight';
?>
<div class="metroW" style="display: none; width: 100%;"></div>
<div class="erpProContainer <?php echo $containerClass; ?>">
	<h2 class="erpProTitle" style="position:relative;"><?php if(isset($title)) echo $title; ?></h2>
	<div class="erpProWraper <?php echo $wraperClass; ?>">
		<?php
		if ( isset( $posts ) ) {
			foreach ( $posts as $k => $v ) {
				?>
				<div class="erpProRelContainer" style="">
					<a href="<?php echo $v->getPermalink() ?>" class="erpProPostLink">
						<?php
						foreach ($options['content'] as $key => $value) {
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
	<div class="erpCarouPrev erpNavArrow erpNavArrowLeft  <?php echo $navLeft; ?>"
		style="width:50px;height:50px;background-image:url(<?php echo plugin_dir_url(__FILE__) . '/assets/arrow-left.png'; ?> ); border-radius:0px 0 0 0px;"></div>
	<div class="erpCarouNext erpNavArrow erpNavArrowRight <?php echo $navRight; ?>"
		style="width:50px;height:50px;background-image:url(<?php echo plugin_dir_url(__FILE__) . '/assets/arrow-right.png'; ?> ); border-radius:0 0px 0px 0;"></div>
</div>
<script type="text/javascript" >
	(function ( $ ) {
		$(function () {
			$(".<?php echo $wraperClass; ?>").carouFredSel({
				prev: $(".<?php echo $navLeft; ?>"),
				next: $(".<?php echo $navRight; ?>"),
			    responsive: true,
				width: "100%",
				auto: <?php echo $options['carouselAutoTime'] > 0 ? $options['carouselAutoTime']*1000 : 'false'; ?>,
				items:{
					width: $("#metroW").width()/<?php echo $options['carouselMinVisible']; ?>,
					height: "100%",
					visible: {
						min: <?php echo $options['carouselMinVisible']; ?>,
						max: <?php echo $options['carouselMaxVisible']; ?>
					}
				},
				scroll: {
					pauseOnHover: <?php echo (bool)$options['carouselPauseHover'] ? 'true' : 'false'; ?>
				},
			});
		});
	}(jQuery));
</script>