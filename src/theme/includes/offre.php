<li class='isAnimated'>
    <a href='<?php the_permalink(); ?>'>
        <h2><?php the_title(); ?></h2>
        <div class='job-details'>
            <span><?php echo get_the_terms( $post->ID, 'lieu' )[0]->name; ?></span>
            <span><?php echo get_the_terms( $post->ID, 'contrat' )[0]->name; ?></span>
        </div>
        <?php the_excerpt(); ?>
    </a>
</li>