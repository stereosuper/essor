<?php 
/*
Template Name: Références
*/

$buildingTypeQuery = isset( $_GET['batiment'] ) ? $_GET['batiment'] : '';

$currentPageLink = get_the_permalink();
$archives = get_field('archives');

get_header(); ?>

    <?php if ( have_posts() ) : the_post(); ?>
        <div class='container'>
            <div class='wrapper-title'>
                <div class='title'>
                    <h1><?php the_title(); ?></h1>
                    <?php the_content(); ?>
                </div>

                <aside>
                    <span class='title-aside'>Filtrer</span>
                    <div class='dropdown'>
                        <button type='button' class='dropdown-title'><svg class='icon icon-down'><use xlink:href='#icon-down'></use></svg></button>
                        <?php
                        $allBuildingTypes = get_terms('batiment');
                        if( $allBuildingTypes ){ ?>
                            <ul>
                                <li <?php if( !$buildingTypeQuery ){ echo 'class="active"'; } ?>><a href='<?php the_permalink(); ?>'>Tout type de bâtiment</a></li>
                                <?php foreach( $allBuildingTypes as $buildingType ){ ?>
                                    <li <?php if( $buildingTypeQuery === $buildingType->slug){ echo 'class="active"'; } ?>><a href='<?php the_permalink(); ?>?batiment=<?php echo $buildingType->slug; ?>'><?php echo $buildingType->name; ?></a></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </div>
                    <div class='dropdown'>
                        <button type='button' class='dropdown-title'><svg class='icon icon-down'><use xlink:href='#icon-down'></use></svg></button>
                        <?php
                        $allSectors = get_terms('metier');
                        if( $allSectors ){ ?>
                            <ul>
                                <li <?php if( $currentPageLink === get_field('refsLink', 'options') ){ echo "class='active'"; } ?>><a href='<?php the_field('refsLink', 'options'); ?>'>Tous les métiers</a></li>
                                <?php foreach( $allSectors as $sector ){ ?>
                                    <?php
                                    $sectorPageID = get_posts(array('post_type' => 'page', 'posts_per_page' => 1, 'meta_query' => array(array('key' => 'sector', 'compare' => 'LIKE', 'value' => $sector->term_id))))[0]->ID;
                                    ?>
                                    <?php if( $buildingTypeQuery ){ ?>
                                        <li <?php if( $sectorPageID === $post->ID ){ echo "class='active'"; } ?>><a href='<?php echo get_the_permalink($sectorPageID); ?>?batiment=<?php echo $buildingTypeQuery; ?>'><?php echo $sector->name; ?></a></li>
                                    <?php }else{ ?>
                                        <li <?php if( $sectorPageID === $post->ID ){ echo "class='active'"; } ?>><a href='<?php echo get_the_permalink($sectorPageID); ?>'><?php echo $sector->name; ?></a></li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </div>
                </aside>
            </div>

            <?php
            $projectsArgs = array('post_type' => 'reference', 'posts_per_page' => 15, 'tax_query' => array('relation' => 'AND'), 'post_status' => 'publish');
            
            if( get_field('sector') ){
                array_push($projectsArgs['tax_query'], array('taxonomy' => 'metier', 'field' => 'slug', 'terms' => get_term(get_field('sector'))->slug));
            }

            if( $buildingTypeQuery ){
                array_push($projectsArgs['tax_query'], array('taxonomy' => 'batiment', 'field' => 'slug', 'terms' => $buildingTypeQuery));
            }
            
            $projectsQuery = new WP_Query( $projectsArgs );

            if( $projectsQuery->have_posts() ) {
            $count = 0;
            ?>
                <ul class='projects complete' id='ajax-content'>
                    <?php while( $projectsQuery->have_posts() ) : $projectsQuery->the_post(); ?>
                        <?php get_template_part( 'includes/reference' ); ?>
                    <?php $count ++; endwhile; ?>
                    <?php if($count === $projectsQuery->post_count && $count > 15){ ?>
                        <li class="load-more isAnimated js-none"><a href='<?php echo $archives; ?>'><span class="txt-more"><span>Voir toutes les références</span><svg class="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-right"></use></svg></span></a></li>
                    <?php } ?>
                </ul>
            <?php }else{ ?>
                <p>Il n'y a pas encore de références correspondant à vos critères de recherche!</p>
            <?php } ?>
        </div>
    <?php endif; ?>

<?php get_footer(); ?>