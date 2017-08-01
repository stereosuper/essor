<?php 
/*
Template Name: Référence détail
*/

get_header(); ?>

	<?php if ( have_posts() ) : the_post(); ?>
        <div class='wrapper-top-img'>
            <div class='top-img' style='background-image: url("<?php echo get_stylesheet_directory_uri();?>/img/visuel-ref.jpg")'></div>

        </div>
        <div class='container'>
            <div class='grid'>
                <div class='col-2'>
                    <ul class='side-infos'>
                        <li>
                            <span class='info-title'>Surface</span>
                            <span class='info-content'>4 600 m²</span>
                        </li>
                        <li>
                            <span class='info-title'>Maître d'ouvrage</span>
                            <span class='info-content'>GALEO Promotion</span>
                        </li>
                        <li>
                            <span class='info-title'>Contractant général</span>
                            <span class='info-content'>ESSOR INGÉNIERIE</span>
                        </li>
                        <li>
                            <span class='info-title'>Livraison</span>
                            <span class='info-content'>Début 2017</span>
                        </li>
                        <li>
                            <span class='info-title'>Architecte</span>
                            <span class='info-content'>CR&ON Architectes - Grenoble</span>
                        </li>
                    </ul>
                </div>
                <div class='col-6'>
                    <div class='bloc-title'>
                        <div class='wrapper-title-links'>
                            <h1><span>Saint-Herblain (44)</span>Delta Green</h1>
                            <ul>
                                <li><a href='#'>2017</a></li>
                                <li><a href='#'>Bureaux</a></li>
                                <li><a href='#'>Essor Ingénierie</a></li>
                            </ul>
                        </div>
                        <p>Privilégier les orientations Sud et Nord (propres à l’optimisation des ressources naturelles), développer la flexibilité du bâtiment (aménagements et système constructif) pour accueillir les gens et les accompagner dans leurs besoins d’évolution, dimensionner les espaces de travail en fonction de la pénétration idéale de la lumières : tels étaient les 3 axes de réflexion qui ont guidés la construction de l’immeuble de bureaux Delta Green...</p>
                    </div>
                    <h3>Énergie positive</h3>
                    <p>La société GALEO porte DELTAGREEN, un projet de bâtiment tertiaire innovant d’une surface de 4 608 m² dont la livraison est prévue début 2017. Labellisé projet innovant 2013-2014 par le Cluster NovaBuild et la Région Pays de la Loire, DELTAGREEN est né du constat qu’aujourd’hui, nous concevons des bâtiments théoriquement de plus en plus performants (en phase avec la Réglementation Thermique en vigueur) mais que dans la réalité les consommations énergétiques réelles ne sont pas maîtrisées.</p>
                    <p><strong>La nécessité de compenser les besoins énergétiques du bâtiment par des énergies renouvelables et de produire de l’énergie ont été identifiés dès la conception.</strong></p>
                    <blockquote><p>Ce programme de bureaux devrait obtenir le label allemand PassivHaus dans les semaines qui viennent, sorte de consécration de la construction verte. Ces 4 600 m² seront occupés en grande partie par le cabinet d'avocats Fidal, à partir du 10 mars. Les deux premiers étages sont encore en cours de commercialisation.</p></blockquote>
                    <img class='alignleft' src='<?php echo get_stylesheet_directory_uri();?>/img/ref-img.jpg'>
                    <p>Installé dans la zone Armor à Saint-Herblain, le Deltagreen a la particularité d'être un bâtiment à énergie positive, qui stockera son surplus de production photovoltaïque dans une zone hydrogène. Une première en France.</p>
                    <p>Ce projet devra répondre à quatre enjeux: éviter de consommer (le label PassivHaus est visé), produire de l’énergie (1 100 m2 de panneaux photovoltaïques et cogénération gaz et huiles alimentaires usagées en réflexion), stocker l’énergie (batteries lithium) et maîtriser les usages. Venez visiter le bâtiment au Parc Ar Mor Tertiaire, à Saint-Herblain (44)</p>
                </div>
            </div>
            <h2>Projets similaires</h2>
            <ul class='projects'>
                <li>
                    <h3>Parc de stationnement pour le groupe Total<span>Pau (64)</span></h3>
                    <ul>
                        <li><a href='#'>Essor immobilière</a></li>
                        <li><a href='#'>Bureaux</a></li>
                        <li><a href='#'>2016</a></li>
                    </ul>
                </li>
                <li>
                    <h3>Oceanet<span>Saint-Herblain (44)</span></h3>
                    <ul>
                        <li><a href='#'>Essor immobilière</a></li>
                        <li><a href='#'>Bureaux</a></li>
                        <li><a href='#'>2014</a></li>
                    </ul>
                </li>
                <li>
                    <h3>Agence Pôle Emploi à Pau Blum<span>Pau Blum (64)</span></h3>
                    <ul>
                        <li><a href='#'>Essor immobilière</a></li>
                        <li><a href='#'>Bureaux</a></li>
                        <li><a href='#'>2015</a></li>
                    </ul>
                </li>
                <li>
                    <h3>Siège de Varel Europe à Pau<span>Pau (64)</span></h3>
                    <ul>
                        <li><a href='#'>Essor immobilière</a></li>
                        <li><a href='#'>Bureaux</a></li>
                        <li><a href='#'>2011</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    <?php endif; ?>

<?php get_footer(); ?>