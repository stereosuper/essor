<?php 
/*
Template Name: Références Archives
*/

$currentPageLink = get_the_permalink();

get_header(); ?>

    <?php if ( have_posts() ) : the_post(); ?>
        <div class='container'>
            <div class='wrapper-title'>
                <div class='title'>
                    <h1><?php the_title(); ?></h1>
                    <?php the_content(); ?>
                </div>
            </div>

            <?php
            $projectsArgs = array('post_type' => 'reference', 'posts_per_page' => -1, 'tax_query' => array('relation' => 'AND'), 'post_status' => 'publish');
            
            if( get_field('sector-ref-archives') ){
                array_push($projectsArgs['tax_query'], array('taxonomy' => 'metier', 'field' => 'slug', 'terms' => get_term(get_field('sector-ref-archives'))->slug));
            }

            $projects = get_posts( $projectsArgs );
            $projects = array_slice($projects, 15);

            if(!empty($projects)){ ?>
                <ul class='projects complete'>
                    <?php foreach($projects as $post): setup_postdata( $post ); ?>
                        <?php get_template_part( 'includes/reference' ); ?>
                    <?php endforeach; ?>
                </ul>
            <?php }else{ ?>
                <p>Il n'y a pas encore de références dans les archives!</p>
            <?php } ?>
        </div>
    <?php endif; ?>

<?php get_footer(); ?>