<li class='isAnimated'>
    <a href='<?php the_permalink(); ?>'>
        <span class='wrapper-img'>
            <span class='img' style='background-image: url("<?php echo get_the_post_thumbnail_url(); ?>")'></span>
        </span>
        <span class='wrapper-txt'>
            <h3><?php the_title(); ?></h3>
            <?php the_excerpt(); ?>
        </span>
    </a>
</li>