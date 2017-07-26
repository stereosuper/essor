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

                <?php wp_nav_menu( array( 'theme_location' => 'secondary', 'container' => false, 'menu_class' => 'menu-footer' ) ); ?>

            </div>
        </footer>

        <svg style='position:absolute;width:0;height:0;overflow:hidden' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
            <defs>
                <symbol id='icon-mail' viewBox='0 0 41 32'>
                    <title>Contact</title>
                    <path d='M34.987 0h-29.44c-2.987 0-5.547 2.347-5.547 5.333v21.333c0 2.987 2.56 5.333 5.547 5.333h29.44c2.987 0 5.547-2.347 5.547-5.333v-21.333c0-2.987-2.56-5.333-5.547-5.333zM34.987 3.627c0.213 0 0.427 0 0.64 0l-15.36 11.947-15.36-11.947c0.213 0 0.427 0 0.64 0h29.44zM34.987 28.373h-29.44c-1.067 0-1.92-0.853-1.92-1.707 0 0 0 0 0 0v-19.413l15.573 11.947c0.64 0.427 1.493 0.427 2.133 0l15.36-11.947v19.413c0.213 1.067-0.64 1.707-1.707 1.707 0 0 0 0 0 0z'/>
                </symbol>

                <!--<symbol id='icon-quote' viewBox='0 0 34 32'>
                    <title>Citation</title>
                    <path d='M33.6 19.022h-7.111v-4.267c0-5.511 2.489-8.356 7.289-8.356v-6.4c-9.6 0-14.578 5.333-14.578 15.822 0 5.511 0.533 10.844 1.422 16.178h12.978v-12.978zM14.4 19.022h-7.289v-4.267c0-5.511 2.489-8.356 7.289-8.356v-6.4c-9.6 0-14.4 5.333-14.4 15.822 0 5.333 0.533 10.844 1.422 16.178h12.978v-12.978z'/>
                </symbol>-->

                <symbol id='icon-search' viewBox='0 0 34 32'>
                    <title>Recherche</title>
                    <path d='M33.179 29.305l-7.242-6.905c2.021-2.358 3.2-5.389 3.2-8.589-0.505-8.084-7.411-14.147-15.326-13.811-7.411 0.337-13.474 6.4-13.811 13.811 0.168 7.747 6.737 13.979 14.484 13.811 3.2 0 6.4-1.011 9.095-3.032l7.242 6.905c0.337 0.337 0.674 0.505 1.179 0.505s0.842-0.168 1.179-0.505c0.505-0.505 0.674-1.516 0-2.189 0 0.168 0 0.168 0 0zM14.484 24.589c-6.063 0.168-11.116-4.716-11.284-10.779 0.337-6.232 5.558-11.116 11.789-10.779 5.726 0.337 10.442 4.884 10.779 10.779-0.168 6.063-5.221 10.947-11.284 10.779z'/>
                </symbol>

                <symbol id='icon-close' viewBox='0 0 32 32'>
                    <title>Fermer</title>
                    <path d='M0 4.073l3.2-3.491 28.8 27.345-3.2 3.491-28.8-27.345zM4.073 32l-3.782-3.2 27.636-28.8 3.491 3.2-27.345 28.8z'/>
                </symbol>

                <symbol id='icon-down' viewBox='0 0 54 32'>
                    <path d='M23.437 18.479h6.761v0.451l18.93-18.93 4.958 4.958-27.042 27.042-27.042-27.042 4.958-4.958 18.479 18.479z'/>
                </symbol>
            </defs>
        </svg>

        <?php wp_footer(); ?>

        </body>
    </html>
