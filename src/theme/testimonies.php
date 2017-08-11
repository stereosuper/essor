<?php
/*
Template Name: Témoignages
*/

get_header(); ?>

	<?php if ( have_posts() ) : the_post(); ?>

		<div class='container'>
            <div class='wrapper-content-sidebar'>
                <aside class='wrapper-sticky'>
                    <div class='wrapper-menu-aside' id='blockSticky'>
                        <?php wp_nav_menu( array( 'theme_location' => 'jobs', 'container' => false, 'menu_class' => 'menu-aside' ) ); ?>
                    </div>
                </aside>

                <div class='content-sidebar'>
                    <h1><?php the_title(); ?></h1>
                    <?php if(have_rows('testimonies')){ ?>
                        <ul class='testimonies'>
                            <?php while (have_rows('testimonies')){ the_row();?>
                                <li>
                                    <div class='testimonial-img' style='background-image: url(<?php  the_sub_field('photo'); ?>)'></div>
                                    <div class='content-txt'>
                                        <h2><?php the_sub_field('name'); ?></h2>
                                        <h3><?php the_sub_field('job'); ?></h3>
                                        <h4><?php the_sub_field('subtitle'); ?></h4>
                                        <blockquote><?php the_sub_field('quote'); ?></blockquote>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </div>
            </div>
		</div>
	
	<?php else : ?>

		<div class='container-small'>
			<h1>404</h1>
		</div>

	<?php endif; ?>

<?php get_footer(); ?>