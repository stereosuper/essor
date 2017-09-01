<?php
/*
Template Name: Implantations
*/

// Source : https://wordpress.stackexchange.com/questions/33455/taxonomy-count-per-post-type
function essor_count_posts_in_term( $taxonomy, $term, $postType = 'post' ){
    $query = new WP_Query([
        'posts_per_page' => 0,
        'post_type' => $postType,
        'tax_query' => [
            [
                'taxonomy' => $taxonomy,
                'terms' => $term,
                'field' => 'slug'
            ]
        ]
    ]);

    return $query->found_posts;
}

function essor_get_terms_csv( $id, $taxonomy, $separator = ', ', $field = 'name' ){
    $output = '';
    $terms = wp_get_post_terms($id, $taxonomy);
    $sep = '';
    if($terms) {
        foreach ($terms as $term) {
            $output .= $sep . $term->$field;
            $sep = $separator;
        }
    }

    return $output;
}

function essor_get_field( $selector, $post_id = false, $format_value = true, $default = '' ){
    if (function_exists('get_field')) {
        $value = get_field($selector, $post_id, $format_value);
        if ($value) {
            return $value;
        }
    }
    return $default;
}

function essor_tpl_get_map_json( $features ){
    $implantation_query = new WP_Query(array('post_type' => 'implantation', 'posts_per_page' => -1));

    foreach( $implantation_query->posts as $post ){
        $loc = essor_get_field('geolocalisation', $post->ID);

        $lng = false;
        if (isset($loc['lng'])) {
            $lng = $loc['lng'];
        }

        $lat = false;
        if (isset($loc['lat'])) {
            $lat = $loc['lat'];
        }
        $address_l1 = '';
        $address_l2 = '';
        $phone = '';
        $email = '';

        $name = get_the_title($post->ID);

        if (essor_get_field('address', $post->ID, false)) {
            $address_l1 = essor_get_field('address', $post->ID, '');
        }
        if (essor_get_field('postal_code', $post->ID, false) || essor_get_field('city', $post->ID, false)) {
            $address_l2 = essor_get_field('postal_code', $post->ID, '').' '.essor_get_field('city', $post->ID, '');
        }
        if (essor_get_field('phone', $post->ID, false)) {
            $phone = __('Tél.', 'essor').': '.essor_get_field('phone', $post->ID, '');
        }
        if (essor_get_field('email', $post->ID, false)) {
            $email = '<a href="mailto:'.essor_get_field('email', $post->ID, '').'">'.essor_get_field('email', $post->ID, '').'</a>';
        }

        $metiers = explode(',', essor_get_terms_csv($post->ID, 'metier-implantation', ',', 'slug'));

        if ($lng && $lat) {
            $features[] = array(
                    'type' => 'Feature',
                    'geometry' => array(
                        'type' => 'Point',
                        'coordinates' => array($lng, $lat),
                    ),
                    'properties' => array_merge(
                        array(
                            'display'       => 'visible',
                            'name'          => $name,
                            'address_l1'    => $address_l1,
                            'address_l2'    => $address_l2,
                            'phone'         => $phone,
                            'email'         => $email,
                            'metiers'       => $metiers,
                        ),
                        array_fill_keys(array_keys(array_flip($metiers)), 1) // On merge les clés des métiers car le filter ['in', 'metiers', metier] de mapbox n'a pas l'air de trop fonctionner
                    ),
                );
        }
    }

    return $features;
}
add_filter('essor-get-map-features', 'essor_tpl_get_map_json', 10, 1);

function essor_get_implantations_page_by_metier(){
    $result = array();

    // Récupère les pages ayant le template Implantations
    // Cf. http://codex.wordpress.org/Class_Reference/WP_Query
    $query_args = array(
        // Type Parameters
        'post_type' => 'page',
        // Meta Parameters
        'meta_key'        => '_wp_page_template',
        'meta_value'      => 'implantations.php',
        // Pagination Parameters
        'posts_per_page' => -1,
    );
    $pages = get_posts($query_args);

    // Crée un tableau associatif ayant pour clé les métiers et valeur les posts
    if (is_array($pages)) {
        foreach($pages as $page) {
            $metier = essor_get_field('metier_associe', $page->ID);
            if ($metier && !isset($result[$metier->slug])) {
                $result[$metier->slug] = $page;
            } else if (!isset($result['--all--'])) {
                $result['--all--'] = $page;
            }
        }
    }

    return $result;
}

get_header();

?>

    <?php if ( have_posts() ) : the_post(); ?>

        <?php the_post_thumbnail('full'); ?>

        <div class='container-map-txt'>
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
            <form action='<?php the_permalink(); ?>' method='POST'>
                <?php
                    $default_metier = essor_get_field('metier_associe');
                    $pages_per_metier = essor_get_implantations_page_by_metier();

                    $terms = get_terms(array(
                            'taxonomy' => 'metier-implantation',
                            'hide_empty' => true,
                        ));
                    if ($terms) :
                ?>
                <label for='map-filter'>Filtrer</label>
                <div class='select'>
                    <select id='map-filter' name='map-filter'>
                        <option value='--all--' data-redirect="<?php echo (isset($pages_per_metier['--all--'])?get_permalink($pages_per_metier['--all--']):''); ?>" data-title="<?php echo (isset($pages_per_metier['--all--'])?esc_attr($pages_per_metier['--all--']->post_title):''); ?>" <?php echo (!$default_metier)?'selected':''; ?>
                        ><?php _e('Sélectionnez une expertise', 'essor'); ?></option>
                        <?php
                            foreach($terms as $term) :
                                $count = essor_count_posts_in_term('metier', $term, 'implantation');
                        ?>
                        <option value='<?php echo $term->slug; ?>' data-redirect="<?php echo (isset($pages_per_metier[$term->slug])?get_permalink($pages_per_metier[$term->slug]):''); ?>" data-title="<?php echo (isset($pages_per_metier[$term->slug])?esc_attr($pages_per_metier[$term->slug]->post_title):''); ?>" <?php echo ($default_metier->slug==$term->slug)?'selected':''; ?>
                        ><?php echo $term->name; ?> <?php printf(_n('(%s implantation)', '(%s implantations)', $count), $count); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <svg class='icon'><use xlink:href='#icon-down'></use></svg>
                </div>
                <?php endif; ?>
            </form>
        </div>

        <div class='container-map'><div id='map' class='map'></div></div>

    <?php else : ?>

        <div class='container-small'>
            <h1>404</h1>
        </div>

    <?php endif; ?>

<?php get_footer(); ?>
