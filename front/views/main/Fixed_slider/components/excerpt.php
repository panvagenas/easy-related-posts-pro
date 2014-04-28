<?php
?>
<p  class="text-justify">
	<small>
		<?php
		echo $v->getExcerpt();
		?>
	</small>
</p>
<p>
	<small>
		<?php echo 'Rating: ' . $v->getRating() . ' Post date: ' . $v->getTheTime(); ?>
	</small>
</p>