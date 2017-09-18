<?php
/*
Template Name: Offres Archives
*/

get_header(); ?>

	<?php if ( have_posts() ) : the_post(); ?>
        <div class='wrapper-top-img small'>
            <div class='top-img' style='background-image:url("<?php echo get_the_post_thumbnail_url();?>")'></div>
        </div>

        <div class='wrapper-sticky wrapper-page'>

            <div class='container'>
                <div class='wrapper-content-sidebar'>

                    <aside class='over-img wrapper-sticky wrapper-menu'>
                        <div class='wrapper-menu-aside' id='blockSticky'>
                            <?php wp_nav_menu( array( 'theme_location' => 'jobs', 'container' => false, 'menu_class' => 'menu-aside' ) ); ?>
                        </div>
                    </aside>

                    <div class='content-sidebar'>

                        <h1><?php the_title(); ?></h1>
                        <?php the_content(); ?>

                        <?php
                        $jobsArgs = array('post_type' => 'offre', 'posts_per_page' => -1, 'tax_query' => array('relation' => 'AND'), 'post_status' => 'publish');
                        
                        if( get_field('sector-offer-archives') ){
                            array_push($jobsArgs['tax_query'], array('taxonomy' => 'metier-offre', 'field' => 'slug', 'terms' => get_term(get_field('sector-offer-archives'))->slug));
                        }

                        $jobs = get_posts( $jobsArgs );
                        $jobs = array_slice($jobs, 4);

                        if(!empty($jobs)){ ?>
                            <ul class='jobs'>
                                <?php foreach($jobs as $post): setup_postdata( $post ); ?>
                                    <?php get_template_part( 'includes/offre' ); ?>
                                <?php endforeach; ?>
                            </ul>
                        <?php }else{ ?>
                            <p>Il n'y a pas d'offres disponibles en ce moment pour ce métier!</p>
                        <?php } ?>
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