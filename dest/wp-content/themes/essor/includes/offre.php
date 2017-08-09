<li>
    <a href='<?php the_permalink(); ?>'>
        <h2><?php the_title(); ?></h2>
        <?php echo get_the_terms( $post->ID, 'lieu' )[0]->name; ?>
        <?php echo get_the_terms( $post->ID, 'contrat' )[0]->name; ?>
        <?php the_excerpt(); ?>
    </a>
</li>