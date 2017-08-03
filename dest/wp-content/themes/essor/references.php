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

                <div class='filters'>
                    <span class='title'>Filter</span>
                    <form>
                        <div class='select'>
                            <select>
                                <option value='' selected>Tout type de bâtiment</option>
                                <option value=''>Bureaux</option>
                                <option value=''>Usines</option>
                                <option value=''>Locaux d'activités</option>
                                <option value=''>Entrepôts</option>
                                <option value=''>Hôtels</option>
                                <option value=''>Hypermarchés</option>
                                <option value=''>Centres commerciaux</option>
                                <option value=''>Zones d'activités</option>
                            </select>
                            <svg class='icon icon-down'><use xlink:href='#icon-down'></use></svg>
                        </div>
                        <div class='select'>
                            <select>
                                <option value='' selected>Tous les métiers</option>
                                <option value=''>Usines</option>
                                <option value=''>Locaux d'activités</option>
                                <option value=''>Entrepôts</option>
                                <option value=''>Hôtels</option>
                                <option value=''>Hypermarchés</option>
                                <option value=''>Centres commerciaux</option>
                                <option value=''>Zones d'activités</option>
                            </select>
                            <svg class='icon icon-down'><use xlink:href='#icon-down'></use></svg>
                        </div>
                    </form>
                </div>
            </div>

            <?php
            $projectsArgs = array('post_type' => 'reference', 'posts_per_page' => 10, 'tax_query' => array('relation' => 'AND'));
            
            if( get_field('sector') ){
                array_push($projectsArgs['tax_query'], array('taxonomy' => 'metier', 'field' => 'slug', 'terms' => get_field('sector')->slug));
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
                <ul class='projects complete'>
                    <?php while( $projectsQuery->have_posts() ) : $projectsQuery->the_post(); ?>
                        <li>
                            <a href='<?php the_permalink(); ?>'>
                                <span class='wrapper-img'>
                                    <span class='img' style='background-image:url("<?php echo get_the_post_thumbnail_url(); ?>")'></span>
                                </span>
                                <h3><?php the_title(); ?><span><?php the_field('place'); ?></span></h3>
                            </a>
                            <ul>
                                <li>
                                    <?php
                                    $sectors = get_the_terms( $post->ID, 'metier' );
                                    if( $sectors ){
                                        foreach( $sectors as $sector ){ ?>
                                            <a href='#'><?php echo $sector->name; ?></a>
                                        <?php }
                                    }
                                    ?>
                                </li>
                                <li>
                                    <?php
                                    $buildingTypes = get_the_terms( $post->ID, 'batiment' );
                                    if( $buildingTypes ){
                                        foreach( $buildingTypes as $buildingType ){ ?>
                                            <a href='<?php echo $currentPageLink; ?>?batiment=<?php echo $buildingType->slug; ?>'><?php echo $buildingType->name; ?></a>
                                        <?php }
                                    }
                                    ?>
                                </li>
                                <li><a href='<?php echo $currentPageLink; ?>?year=<?php echo get_the_date( 'Y' ); ?>'><?php echo get_the_date( 'Y' ); ?></a></li>
                            </ul>
                        </li>
                    <?php endwhile; ?>
                    <li class='load-more'>
                        <a href='#'><span class='txt-more'>Charger la suite<svg class='icon icon-arrow-bottom'><use xlink:href='#icon-arrow-bottom'></use></svg></span></a>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    <?php endif; ?>

<?php get_footer(); ?>