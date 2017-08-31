<li class='isAnimated'>
    <a href='<?php the_permalink(); ?>'>
        <span class='wrapper-img'>
            <span class='img' style='background-image:url("<?php echo get_the_post_thumbnail_url(); ?>")'></span>
        </span>
        <h3><?php the_title(); ?><span><?php the_field('place'); ?></span></h3>
    </a>
    <ul>
        <li>
            <?php
            $sectors = get_the_terms( $post->ID, 'metier' );
            if( $sectors ){
                foreach( $sectors as $sector ){ ?>
                    <a href='<?php echo get_the_permalink(get_posts(array('post_type' => 'page', 'posts_per_page' => 1, 'meta_query' => array(array('key' => 'sector', 'compare' => 'LIKE', 'value' => $sector->term_id))))[0]->ID); ?>'><?php echo $sector->name; ?></a>
                <?php }
            }
            ?>
        </li>
        <li>
            <?php
            $buildingTypes = get_the_terms( $post->ID, 'batiment' );
            if( $buildingTypes ){
                foreach( $buildingTypes as $buildingType ){ ?>
                    <a href='<?php echo $currentPageLink; ?>?batiment=<?php echo $buildingType->slug; ?>'><?php echo $buildingType->name; ?></a>
                <?php }
            }
            ?>
        </li>
    </ul>
</li>