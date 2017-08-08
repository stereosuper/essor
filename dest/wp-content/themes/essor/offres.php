<?php
/*
Template Name: Offres
*/

$contractTypeQuery = isset( $_GET['contrat'] ) ? $_GET['contrat'] : '';
$placeQuery = isset( $_GET['lieu'] ) ? $_GET['lieu'] : '';

get_header(); ?>

	<?php if ( have_posts() ) : the_post(); ?>

		<?php the_post_thumbnail('full'); ?>

		<div class='container-small'>
            <aside>
                <?php wp_nav_menu( array( 'theme_location' => 'jobs', 'container' => false, 'menu_class' => 'menu-aside' ) ); ?>
            </aside>

            <div class='dropdown'>
                <button type='button' class='dropdown-title'><svg class='icon icon-down'><use xlink:href='#icon-down'></use></svg></button>
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

            <div class='dropdown'>
                <button type='button' class='dropdown-title'><svg class='icon icon-down'><use xlink:href='#icon-down'></use></svg></button>
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

            $jobsQuery = new WP_Query( $jobsArgs );

            if( $jobsQuery->have_posts() ){ ?>
                <ul id='ajax-content'>
                    <?php while( $jobsQuery->have_posts() ){ $jobsQuery->the_post(); ?>
                        <li>
                            <a href='<?php the_permalink(); ?>'>
                                <h2><?php the_title(); ?></h2>
                                <?php echo get_the_terms( $post->ID, 'lieu' )[0]->name; ?>
                                <?php echo get_the_terms( $post->ID, 'contrat' )[0]->name; ?>
                                <?php the_excerpt(); ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
		</div>
	
	<?php else : ?>

		<div class='container-small'>
			<h1>404</h1>
		</div>

	<?php endif; ?>

<?php get_footer(); ?>