<?php
?>
	<span>
		<?php
		echo $v->getExcerpt();
		?>
	</span>
	<small>
		<?php echo 'Rating: ' . $v->getRating() . ' Post date: ' . $v->getTheTime(); ?>
	</small>