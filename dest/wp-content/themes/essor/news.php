<?php 
/*
Template Name: Actualités
*/
get_header(); ?>

    <?php if ( have_posts() ) : the_post(); ?>
        <div class='container'>
            <div class='wrapper-title'>
                <div class='title'>
                    <h1>Actualités</h1>
                    <p>Retrouvez ici toutes les actualités qui ont fait et font l’histoire du Groupe Essor.</p>
                </div>
                <aside>
                    <span class='title-aside'>Réseaux sociaux :</span>
                    <?php if( have_rows('socialNetworks', 'options') ){ ?>
                        <ul class='menu-social'>
                            <?php while( have_rows('socialNetworks', 'options') ){ the_row(); ?>
                                <li><a href='<?php the_sub_field('link'); ?>'><?php the_sub_field('name'); ?> <svg class='icon icon-<?php the_sub_field('icon'); ?>'><use xlink:href='#icon-<?php the_sub_field('icon'); ?>'></use></svg></a></li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </aside>
            </div>
            <ul class='news'>
                <li>
                    <a href='#'>
                        <span class='wrapper-img'>
                            <span class='img' style='background-image: url("<?php echo get_stylesheet_directory_uri();?>/img/visuel-ref.jpg")'></span>
                        </span>
                        <span class='wrapper-txt'>
                            <h3>Delta Green est lauréat du prix immobilier d’entreprise 2017</h3>
                            <p>Groupe DPGDELTA, et sa filiale Delta Engineering, Maître d'Oeuvre sur l'opération DELTA GREEN, Lauréat du Prix Immobilier d'Entreprise.</p>
                        </span>
                    </a>
                </li>
                <li>
                    <a href='#'>
                        <span class='wrapper-img'>
                            <span class='img' style='background-image: url("<?php echo get_stylesheet_directory_uri();?>/img/visuel-ref.jpg")'></span>
                        </span>
                        <span class='wrapper-txt'>
                            <h3>Une politique de recrutement dynamique et ambitieuse pour le Groupe Essor</h3>
                            <p>ESSOR à la recherche de nouveaux talents.</p>
                        </span>
                    </a>
                </li>
                <li>
                    <a href='#'>
                        <span class='wrapper-img'>
                            <span class='img' style='background-image: url("<?php echo get_stylesheet_directory_uri();?>/img/visuel-ref.jpg")'></span>
                        </span>
                        <span class='wrapper-txt'>
                            <h3>Delta Green est lauréat du prix immobilier d’entreprise 2017</h3>
                            <p>Groupe DPGDELTA, et sa filiale Delta Engineering, Maître d'Oeuvre sur l'opération DELTA GREEN, Lauréat du Prix Immobilier d'Entreprise.</p>
                        </span>
                    </a>
                </li>
                <li>
                    <a href='#'>
                        <span class='wrapper-img'>
                            <span class='img' style='background-image: url("<?php echo get_stylesheet_directory_uri();?>/img/visuel-ref.jpg")'></span>
                        </span>
                        <span class='wrapper-txt'>
                            <h3>Une politique de recrutement dynamique et ambitieuse pour le Groupe Essor</h3>
                            <p>ESSOR à la recherche de nouveaux talents.</p>
                        </span>
                    </a>
                </li>
                <li>
                    <a href='#'>
                        <span class='wrapper-img'>
                            <span class='img' style='background-image: url("<?php echo get_stylesheet_directory_uri();?>/img/visuel-ref.jpg")'></span>
                        </span>
                        <span class='wrapper-txt'>
                            <h3>Une politique de recrutement dynamique et ambitieuse pour le Groupe Essor</h3>
                            <p>ESSOR à la recherche de nouveaux talents.</p>
                        </span>
                    </a>
                </li>
                <li class='load-more'>
                    <a href='#'>
                        <span class='txt-more'>Charger la suite<svg class='icon icon-arrow-bottom'><use xlink:href='#icon-arrow-bottom'></use></svg></span>
                    </a>
                </li>
            </ul>
        </div>
    <?php endif; ?>

<?php get_footer(); ?>