<?php
/*
Template Name: Accueil
*/

get_header(); ?>

	<?php if ( have_posts() ) : the_post(); ?>

		<?php if( function_exists('gacfai_get_field') && gacfai_get_field('img') ){ ?>
            <div><?php echo gacfai_get_field('img', $post->ID, 'full', false, ''); ?></div>
        <?php }else if( has_post_thumbnail() ){ ?>
            <div class='wrapper-top-img'>
                <div class='top-img' style='background-image:url("<?php echo get_the_post_thumbnail_url(); ?>")'></div>
            </div>
        <?php } ?>

		<div class='container-small bloc-title-img' id='blocTitle'>
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
        </div>
        
        <div class='container-small'>
            <h2><?php the_field('refTitle'); ?></h2>
            <?php the_field('refText'); ?>
        </div>
        <div class='container'>
            <ul class='projects complete'>
            <?php $buildingTypes = get_terms('batiment');
                foreach( $buildingTypes as $buildingType ){ ?>
                    <li class='isAnimated'>
                        <a href="<?php echo get_field('refsLink', 'options') . '?batiment=' . $buildingType->slug; ?>">
                            <span class='wrapper-img small'>
                                <span class='img' style='background-image:url("<?php echo wp_get_attachment_image_url( get_field('img', $buildingType), 'medium' ); ?>")'></span>
                            </span>
                            <h3><?php echo $buildingType->name; ?></h3>
                        </a>
                    </li>
            <?php } ?>
            </ul>
        </div>
        <div class='container-small' id='metiers'>
            <?php the_field('refText2'); ?>
        </div>

        <div class='bg-full'>
            <div class='container'>
                <div class='bloc-title-small'>
                    <h2><?php the_field('sectorsTitle'); ?></h2>
                    <p><?php the_field('sectorsText'); ?></p>
                </div>

                <?php if( have_rows('sectors') ){ ?>
                    <ul class='list-sectors'>
                        <?php while( have_rows('sectors') ){ the_row(); ?>
                            <li>
                                <a href='<?php the_sub_field('page'); ?>'>
                                    <?php echo wp_get_attachment_image( get_sub_field('img'), 'medium' ); ?>
                                    <div>
                                        <h3><?php the_sub_field('title'); ?></h3>
                                        <p><?php the_sub_field('text'); ?></p>
                                    </div>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } ?>
            </div>
        </div>

        <?php if( get_field('about') ){ ?>
            <div class='container-small clearfix'>
                <h2><?php echo get_field('about')->post_title; ?></h2>
                <?php echo essor_wp_trim_excerpt( get_field('about')->post_content ); ?>
            </div>
        <?php } ?>

        <div class='wrapper-map <?php if( get_field('mapImg') ){ echo "has-img"; } ?>'>
            <div class='container'>
                <h2><?php the_field('mapTitle'); ?></h2>
                <?php the_field('mapText'); ?>
            </div>
            <?php echo wp_get_attachment_image( get_field('mapImg'), 'full' ); ?>
        </div>
	
	<?php else : ?>

		<div class='container-small'>
			<h1>404</h1>
		</div>

	<?php endif; ?>

<?php get_footer(); ?>