<?php
if (!$options['thumbCaption']) {
	?>
	<h4 class="<?php echo $titleClass; ?>"><strong><?php echo $v->getTitle();?></strong></h4>
	<?php
}
?>
<noscript><h4 class="<?php echo $titleClass; ?>"><strong><?php echo $v->getTitle();?></strong></h4></noscript>