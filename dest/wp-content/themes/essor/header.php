<!DOCTYPE html>

<html <?php language_attributes(); ?> class='no-js'>
	<head>
		<meta charset='utf-8'>
		<meta name='viewport' content='width=device-width,initial-scale=1'>
		<meta name='format-detection' content='telephone=no'>

		<link rel='alternate' type='application/rss+xml' title='<?php bloginfo('sitename') ?> Feed' href='<?php echo get_bloginfo('rss2_url') ?>'>

		<?php wp_head(); ?>

		<script>document.getElementsByTagName('html')[0].className = 'js';</script>
	</head>

	<body <?php body_class(); ?>>

		<header role='banner'>
	
			<div class='container'>

				<a href='<?php echo home_url('/'); ?>' title='<?php bloginfo( 'name' ); ?>' rel='home'>
					<img src='<?php echo get_template_directory_uri(); ?>/layoutImg/essor.svg' alt='<?php bloginfo( 'name' ); ?>'>
				</a>

				<nav role='navigation'>
					<button type='button'>Nos métiers</button>
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'menu-main', 'depth' => 1 ) ); ?>

					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'menu-secondary', 'sub_menu' => true ) ); ?>

					<?php get_search_form(true); ?>

					<?php if( get_field('contactLink', 'options') ){ ?>
						<a href='<?php the_field('contactLink', 'options') ?>'>Contact</a>
					<?php } ?>
				</nav>

			</div>

		</header>

		<main role='main'>
