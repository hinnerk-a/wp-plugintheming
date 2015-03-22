<div class="col-md-3">
	<a href="<?php the_permalink(); ?>">
	    <?php the_post_thumbnail(); ?>
	</a>
</div>
<div class="col-md-9">
	<a href="<?php the_permalink(); ?>">
		<h2 class="movie"><?php the_title(); ?></h2>
	</a>
    <p><?php the_excerpt(); ?></p>
</div>
