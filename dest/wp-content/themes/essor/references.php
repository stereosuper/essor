<?php 
/*
Template Name: Références
*/

$buildingTypeQuery = isset( $_GET['batiment'] ) ? $_GET['batiment'] : '';
$dateQuery = isset( $_GET['year'] ) ? $_GET['year'] : '';

$currentPageLink = get_the_permalink();

get_header(); ?>

    <?php if ( have_posts() ) : the_post(); ?>
        <div class='container'>
            <div class='wrapper-title'>
                <div class='title'>
                    <h1><?php the_title(); ?></h1>
                    <?php the_content(); ?>
                </div>

                <aside>
                    <span class='title-aside'>Filter</span>
                    <div class='dropdown'>
                        <button type='button' class='dropdown-title'><svg class='icon icon-down'><use xlink:href='#icon-down'></use></svg></button>
                        <?php
                        $allBuildingTypes = get_terms('batiment');
                        if( $allBuildingTypes ){ ?>
                            <ul>
                                <li <?php if( !$buildingTypeQuery ){ echo 'class="active"'; } ?>><a href='<?php the_field('refsLink', 'options'); ?>'>Tout type de bâtiment</a></li>
                                <?php foreach( $allBuildingTypes as $buildingType ){ ?>
                                    <li <?php if( $buildingTypeQuery === $buildingType->slug){ echo 'class="active"'; } ?>><a href='<?php the_field('refsLink', 'options'); ?>?batiment=<?php echo $buildingType->slug; ?>'><?php echo $buildingType->name; ?></a></li>
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
                                    <li <?php if( $sectorPageID === $post->ID ){ echo "class='active'"; } ?>><a href='<?php echo get_the_permalink($sectorPageID); ?>'><?php echo $sector->name; ?></a></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </div>
                </aside>
            </div>

            <?php
            $projectsArgs = array('post_type' => 'reference', 'posts_per_page' => 1, 'tax_query' => array('relation' => 'AND'));
            
            if( get_field('sector') ){
                array_push($projectsArgs['tax_query'], array('taxonomy' => 'metier', 'field' => 'slug', 'terms' => get_term(get_field('sector'))->slug));
            }

            if( $buildingTypeQuery ){
                array_push($projectsArgs['tax_query'], array('taxonomy' => 'batiment', 'field' => 'slug', 'terms' => $buildingTypeQuery));
            }

            if( $dateQuery ){
                $projectsArgs['date_query'] = array(array('year'  => $dateQuery)); 
            }
            
            $projectsQuery = new WP_Query( $projectsArgs );

            if( $projectsQuery->have_posts() ) :
            ?>
                <ul class='projects complete' id='ajax-content'>
                    <?php while( $projectsQuery->have_posts() ) : $projectsQuery->the_post(); ?>
                        <?php get_template_part( 'includes/reference' ); ?>
                    <?php $countProjects ++; endwhile; ?>
                </ul>
            <?php endif; ?>
        </div>
    <?php endif; ?>

<?php get_footer(); ?>