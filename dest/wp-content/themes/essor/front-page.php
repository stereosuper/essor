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

		<div class='container-small'>
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
        </div>
        
        <div class='container-small'>
            <h2><?php the_field('refTitle'); ?></h2>
            <?php the_field('refText'); ?>
            <ul>
            <?php $buildingTypes = get_terms('batiment');
                foreach( $buildingTypes as $buildingType ){ ?>
                    <li>
                        <a href="<?php echo get_field('refsLink', 'options') . '?batiment=' . $buildingType->slug; ?>">
                            <?php echo $buildingType->name; ?>
                            <?php echo wp_get_attachment_image( get_field('img', $buildingType), 'medium' ); ?>
                        </a>
                    </li>
            <?php } ?>
            </ul>
            <?php the_field('refText2'); ?>
        </div>

        <div class='container'>
            <h2><?php the_field('sectorsTitle'); ?></h2>
            <?php the_field('sectorsText'); ?>

            <?php if( have_rows('sectors') ){ ?>
                <ul>
                    <?php while( have_rows('sectors') ){ the_row(); ?>
                        <li>
                            <a href='<?php the_sub_field('page'); ?>'>
                                <?php echo wp_get_attachment_image( get_sub_field('img'), 'medium' ); ?>
                                <?php the_sub_field('title'); ?>
                                <?php the_sub_field('text'); ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>

        <?php if( get_field('about') ){ ?>
            <div class='container-small'>
                <h2><?php echo get_field('about')->post_title; ?></h2>
                <?php echo essor_wp_trim_excerpt( get_field('about')->post_content ); ?>
            </div>
        <?php } ?>

        <div class='container'>
            <h2><?php the_field('mapTitle'); ?></h2>
            <?php the_field('mapText'); ?>
            <?php echo wp_get_attachment_image( get_field('mapImg'), 'full' ); ?>
        </div>
	
	<?php else : ?>

		<div class='container-small'>
			<h1>404</h1>
		</div>

	<?php endif; ?>

<?php get_footer(); ?>