        </main>

        <footer role='contentinfo'>
            <div class='container'>
                
                <?php the_field('offersTitle', 'options'); ?>
                <?php the_field('offersSubtitle', 'options'); ?>
                <a href='<?php the_field('offersPage', 'options'); ?>' class='btn'><?php the_field('offersBtn', 'options'); ?></a>

                <?php the_field('newsTitle', 'options'); ?>
                <?php the_field('newsSubtitle', 'options'); ?>

                <?php the_field('officesTitle', 'options'); ?>
                <?php the_field('officesSubtitle', 'options'); ?>
                <a href='<?php the_field('officesPage', 'options'); ?>' class='btn'><?php the_field('officesBtn', 'options'); ?></a>

                <span>&copy;<?php echo get_the_date('Y'); ?> - Groupe Essor</span>

                <?php wp_nav_menu( array( 'theme_location' => 'secondary', 'container' => false, 'menu_class' => 'menu-main' ) ); ?>

            </div>
        </footer>

        <?php wp_footer(); ?>

        </body>
    </html>
