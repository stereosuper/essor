<?php
/*
Template Name: Implantations
*/

function essor_get_field($selector, $post_id=false, $format_value=true, $default='')
{
    if (function_exists('get_field')) {
        $value = get_field($selector, $post_id, $format_value);
        if ($value) {
            return $value;
        }
    }
    return $default;
}

function essor_query_all_implantation()
{
    // Cf. http://codex.wordpress.org/Class_Reference/WP_Query
    $query_args = array(
        // Type Parameters
        'post_type' => 'implantation',
        // Pagination Parameters
        'posts_per_page' => -1,
    );

    return new WP_Query($query_args);
}

function essor_tpl_get_map_json($collection)
{
    $implantation_query = essor_query_all_implantation();

    foreach($implantation_query->posts as $post) {
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

        if ($lng && $lat) {
            $collection['source']['data']['features'][] = array(
                    'type' => 'Feature',
                    'geometry' => array(
                        'type' => 'Point',
                        'coordinates' => array($lng, $lat),
                    ),
                    'properties' => array(
                        'display'       => 'visible',
                        'name'          => $name,
                        'address_l1'    => $address_l1,
                        'address_l2'    => $address_l2,
                        'phone'         => $phone,
                        'email'         => $email,
                    ),
                );
        }
    }

    return $collection;
}
add_filter('essor-get-map-features', 'essor_tpl_get_map_json', 10, 1);

get_header();

?>

    <?php if ( have_posts() ) : the_post(); ?>

        <?php the_post_thumbnail('full'); ?>

        <div class='container-small'>
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>

            <div id='map' class='map'>
                <div class='activeArea'></div>
            </div>

        </div>

    <?php else : ?>

        <div class='container-small'>
            <h1>404</h1>
        </div>

    <?php endif; ?>

<?php get_footer(); ?>
