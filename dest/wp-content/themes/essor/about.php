<?php
/*
Template Name: A propos
*/

get_header(); ?>

	<?php if ( have_posts() ) : the_post(); ?>

		<div class='container'>
            <div class='wrapper-content-sidebar'>

                <aside class='wrapper-sticky'>
                    <div class='wrapper-menu-aside' id='blockSticky'>
                        <?php wp_nav_menu( array( 'theme_location' => 'about', 'container' => false, 'menu_class' => 'menu-aside' ) ); ?>
                    </div>
                </aside>

                <div class='content-sidebar'>
                    <h1><?php the_title(); ?></h1>
                    <?php the_content(); ?>
                </div>
                
            </div>
		</div>
	
	<?php else : ?>

		<div class='container-small'>
			<h1>404</h1>
		</div>

	<?php endif; ?>

<?php get_footer(); ?>