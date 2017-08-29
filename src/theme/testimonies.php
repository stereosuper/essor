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
                                <li id='<?php the_sub_field('anchor'); ?>'>
                                    <?php if( get_sub_field('photo') ){ ?>
                                        <div class='testimonial-img' style='background-image: url(<?php  the_sub_field('photo'); ?>)'></div>
                                    <?php } ?>
                                    <div class='content-txt'>
                                        <h2><?php the_sub_field('name'); ?></h2>
                                        <?php if( get_sub_field('job') ){ ?>
                                            <h3><?php the_sub_field('job'); ?></h3>
                                        <?php } ?>
                                        <?php if( get_sub_field('subtitle') ){ ?>
                                            <h4><?php the_sub_field('subtitle'); ?></h4>
                                        <?php } ?>
                                        <?php if( get_sub_field('quote') ){ ?>
                                            <blockquote><?php the_sub_field('quote'); ?></blockquote>
                                        <?php } ?>
                                        <?php if( get_sub_field('wysiwyg') ){ ?>
                                            <div class='additionnal-content'><?php the_sub_field('wysiwyg'); ?></div>
                                        <?php } ?>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>

                    <?php
                        $menu = wp_get_nav_menu_object( get_nav_menu_locations()['jobs'] );
                        $menuitems = wp_get_nav_menu_items( $menu->term_id );

                        $id = get_post_meta( $menuitems[1]->ID, '_menu_item_object_id', true );

                    ?>
                            
                    <div class='about-nav'>
                        <a href='<?php echo get_page_link( $id ); ?>' class='btn'>
                            <?php echo get_the_title( $id ); ?>
                            <svg class='icon'><use xlink:href='#icon-right'></use></svg>
                        </a>
                    </div>

                </div>
            </div>
		</div>
	
	<?php else : ?>

		<div class='container-small'>
			<h1>404</h1>
		</div>

	<?php endif; ?>

<?php get_footer(); ?>