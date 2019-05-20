<?php
/*
Template Name: Nos métiers
*/

get_header(); ?>

<?php if ( have_posts() ) : the_post(); ?>

    <div class='sectors-bg' style='background-image: url(<?php the_post_thumbnail_url('full'); ?>)'></div>

    <div class='container clearfix'>
        <div class='sectors-page'>
            <div>
                <h1><?php the_title(); ?></h1>
                <?php the_content(); ?>
            </div>

            <?php if( have_rows('sectors') ) : ?>
                <ul class='sectors-list'>
                    <?php while( have_rows('sectors') ) : the_row(); ?>
                    <li>
                        <a href='<?php the_sub_field('page'); ?>'>
                            <?php echo wp_get_attachment_image(get_sub_field('img'), 'medium'); ?>
                            <p><?php the_sub_field('name'); ?></p>
                            <p><?php the_sub_field('desc'); ?></p>
                            <div><span>Voir la page <svg class='icon'><use xlink:href='#icon-right'></use></svg></span></div>
                        </a>
                    </li>
                    <?php endwhile; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>

    <?php else : ?>

    <div class='container-small'>
        <h1>404</h1>
    </div>

<?php endif; ?>

<?php get_footer(); ?>