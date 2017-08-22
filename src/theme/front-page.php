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
            <?php the_field('refText2'); ?>
        </div>

        <div class='container'>
            <h2><?php the_field('sectorsTitle'); ?></h2>
            <?php the_field('sectorsText'); ?>
        </div>

        <div class='container-small'>
            <h2><?php echo get_field('about')->post_title; ?></h2>
            <?php echo custom_wp_trim_excerpt( get_field('about')->post_content ); ?>
        </div>
	
	<?php else : ?>

		<div class='container-small'>
			<h1>404</h1>
		</div>

	<?php endif; ?>

<?php get_footer(); ?>