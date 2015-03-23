<!-- This file overrides the parent plugin's template /themes/bootstrap3/archive/item-movie.php -->
<div class="col-xs-12">
<a href="<?php the_permalink(); ?>">
	<h2 class="movie"><?php the_title(); ?></h2>
</a>
</div>
<div class="col-md-3">
	<a href="<?php the_permalink(); ?>">
	    <?php the_post_thumbnail(); ?>
	</a>
</div>
<div class="col-md-9">
    <p><?php the_excerpt(); ?></p>
</div>
