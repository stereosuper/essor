<?php
/*
Template Name: A propos
*/

get_header(); ?>

	<?php if ( have_posts() ) : the_post(); ?>

		<div class='container'>
            <div class='wrapper-content-sidebar'>

                <aside class='wrapper-sticky'>
                    <div class='wrapper-menu-aside <?php if( url_to_postid( get_field('aboutLink', 'options') ) == $post->ID ){ echo 'menu-no-current'; } ?>' id='blockSticky'>
                        <?php wp_nav_menu( array( 'theme_location' => 'about', 'container' => false, 'menu_class' => 'menu-aside' ) ); ?>
                    </div>
                </aside>

                <div class='content-sidebar content-about'>
                    <h1><?php the_title(); ?></h1>
                    <?php the_content(); ?>

                    <?php if( have_rows('module') ): ?>
                        <?php while( have_rows('module') ): the_row(); ?>

                            <?php if( get_row_layout() == 'skillsList' ): ?>
                                <?php if( have_rows('skills') ): ?>
                                    <ul class='list-skills'>
                                    <?php while( have_rows('skills') ): the_row(); ?>
                                        
                                        <li>
                                            <?php echo wp_get_attachment_image( get_sub_field('logo'), 'full' ); ?>
                                            <h2><?php the_sub_field('name'); ?></h2>
                                            <p><?php the_sub_field('text'); ?></p>
                                        </li>

                                    <?php endwhile; ?>
                                    </ul>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if( get_row_layout() == 'numbersList' ): ?>
                                <?php if( have_rows('numbers') ): ?>
                                    <ul class='list-numbers'>
                                    <?php while( have_rows('numbers') ): the_row(); ?>

                                        <li>
                                            <div>
                                                <?php echo wp_get_attachment_image( get_sub_field('img'), 'full' ); ?>
                                                <b><?php the_sub_field('number'); ?><span><?php the_sub_field('unit'); ?></span></b>
                                            </div>
                                            <?php the_sub_field('text'); ?>
                                        </li>

                                    <?php endwhile; ?>
                                    </ul>
                                <?php endif; ?>
                            <?php endif; ?>

                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
                
            </div>
		</div>
	
	<?php else : ?>

		<div class='container-small'>
			<h1>404</h1>
		</div>

	<?php endif; ?>

<?php get_footer(); ?>