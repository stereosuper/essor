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

get_header();

?>

    <?php if ( have_posts() ) : the_post(); ?>

        <?php the_post_thumbnail('full'); ?>

        <div class='container-map-txt'>
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>

            <span class='dropdown-title'>Filtrer</span>
            <div class='dropdown'>
                <button type='button' class='dropdown-title'><svg class='icon icon-down'><use xlink:href='#icon-down'></use></svg></button>
                <?php
                $allSectors = get_terms('metier-implantation');
                if( $allSectors ){ ?>
                    <ul id='map-filter'>
                        <li <?php if( get_the_permalink() === get_field('mapLink', 'options') ){ echo "class='active'"; } ?> data-value='--all--'><a href='<?php the_field('mapLink', 'options'); ?>'>Sélectionnez une expertise</a></li>
                        <?php foreach( $allSectors as $sector ){ ?>
                            <?php
                            $mapPageID = get_posts(array('post_type' => 'page', 'posts_per_page' => 1, 'meta_query' => array(array('key' => 'metier_associe', 'compare' => 'LIKE', 'value' => $sector->term_id))))[0]->ID;
                            ?>
                            <li <?php if( $mapPageID === $post->ID ){ echo "class='active'"; } ?> data-value='<?php echo $sector->slug; ?>'><a href='<?php echo get_the_permalink($mapPageID); ?>'><?php echo $sector->name; ?></a></li>
                        <?php } ?>
                    </ul>
                <?php } ?>
            </div>
        </div>

        <div class='container-map'><div id='map' class='map'></div></div>

    <?php else : ?>

        <div class='container-small'>
            <h1>404</h1>
        </div>

    <?php endif; ?>

<?php get_footer(); ?>
