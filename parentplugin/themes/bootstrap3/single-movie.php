<?php parentplugin_get_template_part('header', 'movie'); ?>

	<?php wp_reset_query(); ?>

        <div class="movie-single parentplugin">
			<div class="row">
				<div class="col-xs-6">
			        <?php parentplugin_get_template_part('single/title', 'movie'); ?>
				    <?php parentplugin_get_template_part('single/content', 'movie'); ?>
		        </div>
			    <div class="col-xs-6">
				    <?php the_post_thumbnail(); ?>
			    </div>
	        </div>
		</div>

<?php parentplugin_get_template_part('footer', 'movie'); ?>
