<?php if ( have_posts() ) : ?>
    <div class="movies">
        <?php while ( have_posts() ) : the_post(); ?>
            <div class="row">
                <?php parentplugin_get_template_part('archive/item', 'movie'); ?>
            </div>
        <?php endwhile; ?>
    </div>
<?php else : // else have_posts()?>
    <?php parentplugin_get_template_part('archive/noresult', 'movie'); ?>
<?php endif; // end have_posts()?>
