<?php
/*
Template Name: Offres
*/

$contractTypeQuery = isset( $_GET['contrat'] ) ? $_GET['contrat'] : '';
$placeQuery = isset( $_GET['lieu'] ) ? $_GET['lieu'] : '';

get_header(); ?>

	<?php if ( have_posts() ) : the_post(); ?>
        <div class='wrapper-top-img small'>
            <div class='top-img' style='background-image:url("<?php echo get_the_post_thumbnail_url();?>")'></div>
        </div>

        <div class='wrapper-sticky wrapper-page'>

            <div class='container'>
                <div class='wrapper-content-sidebar'>

                    <aside class='over-img wrapper-sticky'>
                        <div class='wrapper-menu-aside' id='blockStickyJobs'>
                            <?php wp_nav_menu( array( 'theme_location' => 'jobs', 'container' => false, 'menu_class' => 'menu-aside' ) ); ?>
                        </div>
                    </aside>

                    <div class='content-sidebar'>

                        <div class='wrapper-dropdowns' id='dropdownsSticky'>
                            <div class='container'>
                                <div class='dropdowns'>

                                    <div class='dropdown white'>
                                        <button type='button' class='dropdown-title'>
                                            <svg class='icon icon-down'><use xlink:href='#icon-down'></use></svg>
                                        </button>
                                        <?php
                                        $allContractTypes = get_terms('contrat');
                                        if( $allContractTypes ){ ?>
                                            <ul>
                                                <li <?php if( !$contractTypeQuery ){ echo 'class="active"'; } ?>><a href='<?php the_permalink(); ?>?lieu=<?php echo $placeQuery; ?>'>Contrat</a></li>
                                                <?php foreach( $allContractTypes as $contractType ){ ?>
                                                    <?php
                                                    $link = get_the_permalink() . '?contrat=' . $contractType->slug;
                                                    if( $placeQuery ){
                                                        $link .= '&lieu=' . $placeQuery;
                                                    }
                                                    ?>
                                                    <li <?php if( $contractTypeQuery === $contractType->slug){ echo 'class="active"'; } ?>><a href='<?php echo $link; ?>'><?php echo $contractType->name; ?></a></li>
                                                <?php } ?>
                                            </ul>
                                        <?php } ?>
                                    </div>

                                    <div class='dropdown white'>
                                        <button type='button' class='dropdown-title'>
                                            <svg class='icon icon-down'><use xlink:href='#icon-down'></use></svg>
                                        </button>
                                        <?php
                                        $allPlaces = get_terms('lieu');
                                        if( $allPlaces ){ ?>
                                            <ul>
                                                <li <?php if( !$placeQuery ){ echo 'class="active"'; } ?>><a href='<?php the_permalink(); ?>?contrat=<?php echo $contractTypeQuery; ?>'>Région</a></li>
                                                <?php foreach( $allPlaces as $place ){ ?>
                                                    <?php
                                                    $link = get_the_permalink() . '?lieu=' . $place->slug;
                                                    if( $contractTypeQuery ){
                                                        $link .= '&contrat=' . $contractTypeQuery;
                                                    }
                                                    ?>
                                                    <li <?php if( $placeQuery === $place->slug){ echo 'class="active"'; } ?>><a href='<?php echo $link; ?>'><?php echo $place->name; ?></a></li>
                                                <?php } ?>
                                            </ul>
                                        <?php } ?>
                                    </div>

                                    <div class='dropdown white'>
                                        <button type='button' class='dropdown-title'><svg class='icon icon-down'><use xlink:href='#icon-down'></use></svg></button>
                                        <?php
                                        $allSectors = get_terms('metier-offre');
                                        if( $allSectors ){ ?>
                                            <ul>
                                                <li <?php if( get_permalink() === get_field('jobLink', 'options') ){ echo "class='active'"; } ?>><a href='<?php the_field('jobLink', 'options'); ?>'>Secteur</a></li>
                                                <?php foreach( $allSectors as $sector ){ ?>
                                                    <?php
                                                    $sectorPageID = get_posts(array('post_type' => 'page', 'posts_per_page' => 1, 'meta_query' => array(array('key' => 'sector', 'compare' => 'LIKE', 'value' => $sector->term_id))))[0]->ID;
                                                    ?>
                                                    <li <?php if( $sectorPageID === $post->ID ){ echo "class='active'"; } ?>><a href='<?php echo get_the_permalink($sectorPageID); ?>'><?php echo $sector->name; ?></a></li>
                                                <?php } ?>
                                            </ul>
                                        <?php } ?>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <h1><?php the_title(); ?></h1>
                        <?php the_content(); ?>

                        <?php
                        $jobsArgs = array('post_type' => 'offre', 'posts_per_page' => 4, 'tax_query' => array('relation' => 'AND'), 'post_status' => 'publish');

                        if( $contractTypeQuery ){
                            array_push($jobsArgs['tax_query'], array('taxonomy' => 'contrat', 'field' => 'slug', 'terms' => $contractTypeQuery));
                        }

                        if( $placeQuery ){
                            array_push($jobsArgs['tax_query'], array('taxonomy' => 'lieu', 'field' => 'slug', 'terms' => $placeQuery));
                        }
                        
                        if( get_field('sector') ){
                            array_push($jobsArgs['tax_query'], array('taxonomy' => 'metier-offre', 'field' => 'slug', 'terms' => get_term(get_field('sector'))->slug));
                        }

                        $jobsQuery = new WP_Query( $jobsArgs );

                        if( $jobsQuery->have_posts() ){ ?>
                            <ul class='jobs' id='ajax-content'>
                                <?php while( $jobsQuery->have_posts() ){ $jobsQuery->the_post(); ?>
                                    <?php get_template_part( 'includes/offre' ); ?>
                                <?php } ?>
                            </ul>
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