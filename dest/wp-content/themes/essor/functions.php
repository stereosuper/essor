<?php

define( 'ESSOR_VERSION', 1.0 );


/*-----------------------------------------------------------------------------------*/
/* General
/*-----------------------------------------------------------------------------------*/
// Plugins updates
add_filter( 'auto_update_plugin', '__return_true' );

// Theme support
add_theme_support( 'html5', array(
    'comment-list',
    'comment-form',
    'search-form',
    'gallery',
    'caption',
    'widgets'
) );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'title-tag' );

// Admin bar
show_admin_bar(false);

// Disable Tags
function essor_unregister_tags(){
    unregister_taxonomy_for_object_type('post_tag', 'post');
}
add_action( 'init', 'essor_unregister_tags' );


/*-----------------------------------------------------------------------------------*/
/* Clean WordPress head and remove some stuff for security
/*-----------------------------------------------------------------------------------*/
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
add_filter( 'emoji_svg_url', '__return_false' );

// remove api rest links
remove_action( 'wp_head', 'rest_output_link_wp_head' );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

// remove comment author class
function essor_remove_comment_author_class( $classes ){
	foreach( $classes as $key => $class ){
		if(strstr($class, 'comment-author-')) unset( $classes[$key] );
	}
	return $classes;
}
add_filter( 'comment_class' , 'essor_remove_comment_author_class' );

// remove login errors
add_filter( 'login_errors', create_function('$a', "return null;") );


/*-----------------------------------------------------------------------------------*/
/* Admin
/*-----------------------------------------------------------------------------------*/
// Remove some useless admin stuff
function essor_remove_submenus(){
    $page = remove_submenu_page( 'themes.php', 'themes.php' );
}
add_action( 'admin_menu', 'essor_remove_submenus', 999 );
function essor_remove_top_menus( $wp_admin_bar ){
    $wp_admin_bar->remove_node( 'wp-logo' );
}
add_action( 'admin_bar_menu', 'essor_remove_top_menus', 999 );

// Enlever le lien par défaut autour des images
function essor_imagelink_setup(){
	if(get_option( 'image_default_link_type' ) !== 'none') update_option('image_default_link_type', 'none');
}
add_action( 'admin_init', 'essor_imagelink_setup' );

// Enlever les <p> autour des images
function essor_remove_p_around_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}
add_filter( 'the_content', 'essor_remove_p_around_images' );

// Allow svg in media library
function essor_mime_types($mimes){
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'essor_mime_types' );

// Custom posts in the dashboard
function essor_right_now_custom_post() {
    $post_types = get_post_types(array( '_builtin' => false ) , 'objects' , 'and');
    foreach($post_types as $post_type){
        $cpt_name = $post_type->name;
        if($cpt_name !== 'acf-field-group' && $cpt_name !== 'acf-field'){
            $num_posts = wp_count_posts($post_type->name);
            $num = number_format_i18n($num_posts->publish);
            $text = _n($post_type->labels->name, $post_type->labels->name , intval($num_posts->publish));
            echo '<li class="'. $cpt_name .'-count"><tr><a class="'.$cpt_name.'" href="edit.php?post_type='.$cpt_name.'"><td></td>' . $num . ' <td>' . $text . '</td></a></tr></li>';
        }
    }
}
add_action( 'dashboard_glance_items', 'essor_right_now_custom_post' );

// News styles in wysiwyg
function essor_wysiwyg_styleselect( $buttons ){
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}
add_filter( 'mce_buttons_2', 'essor_wysiwyg_styleselect' );

// Customize a bit the wysiwyg editor
function essor_mce_before_init( $styles ){
    // Add custom styles
    $style_formats = array(
        array(
            'title' => 'Citation avec auteur',
            'selector' => 'blockquote',
            'classes' => 'with-cite'
        ),
        array(
            'title' => 'Auteur de la citation',
            'inline' => 'cite'
        )
    );
    $styles['style_formats'] = json_encode( $style_formats );
    // Remove h1 and code
    $styles['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6';
    // Let only the colors you want
    $styles['textcolor_map'] = '[' . "'000000', 'Noir', '646a74', 'Texte', 'e5512c', 'Orange'" . ']';
    return $styles;
}
add_filter( 'tiny_mce_before_init', 'essor_mce_before_init' );

// Add Options Page
if( function_exists('acf_add_options_page') ){
    acf_add_options_page( array(
        'position'   => 2,
        'page_title' => 'Paramètres du thème',
        'menu_title' => 'Paramètres',
        'redirect'   => false
    ) );
}

// Excerpt
function essor_excerpt_length( $length ){
    return 25;
}
add_filter( 'excerpt_length', 'essor_excerpt_length' );

function essor_wp_trim_excerpt($wpse_excerpt) {
    $wpse_excerpt = strip_shortcodes( $wpse_excerpt );
    $wpse_excerpt = apply_filters('the_content', $wpse_excerpt);
    $wpse_excerpt = str_replace(']]>', ']]&gt;', $wpse_excerpt);
    $wpse_excerpt = strip_tags($wpse_excerpt, '<p>,<h2>,<h3>,<h4>,<h5>,<em>,<i>,<a>,<strong>,<b>,<img>,<noscript>');

    $excerpt_length = 109;
    $tokens = array();
    $excerptOutput = '';
    $count = 0;

    preg_match_all('/(<[^>]+>|[^<>\s]+)\s*/u', $wpse_excerpt, $tokens);

    foreach($tokens[0] as $token){

        if($count >= $excerpt_length /*&& preg_match('/[\,\;\?\.\!]\s*$/uS', $token)*/){ //pour arreter l'extrait a un point ou une virgule, etc
            $excerptOutput .= trim($token);
            break;
        }

        $count++;
        $excerptOutput .= $token;
    }

    $wpse_excerpt = trim(force_balance_tags($excerptOutput));

    $excerpt_end = ' <a href="'. get_the_permalink() .'" class="link" title="'. 'Lire ' . get_the_title() .'">Lire toute l\'histoire</a>';
    $excerpt_more = apply_filters('excerpt_more', ' ' . $excerpt_end);
    $wpse_excerpt .= $excerpt_more;

    return $wpse_excerpt;
}

// Add a div around iframes in wysiwyg
function essor_wrap_embed( $html, $url, $attr ){
    return '<div class="wrapper-video">' . $html . '</div>';
}
add_filter( 'embed_oembed_html', 'essor_wrap_embed', 10, 3 );


/*-----------------------------------------------------------------------------------*/
/* Menus
/*-----------------------------------------------------------------------------------*/
register_nav_menus(
	array(
		'primary' => 'Primary Menu',
        'secondary' => 'Secondary Menu',
        'jobs' => 'Jobs Menu',
        'about' => 'About Menu'
	)
);

// Get current submenu
function essort_get_current_submenu( $sorted_menu_items, $args ){
    if( isset( $args->sub_menu ) ){
        $root_id = 0;
        // find the current menu item
        foreach( $sorted_menu_items as $menu_item ){
            if( $menu_item->current ){
                // set the root id based on whether the current menu item has a parent or not
                $root_id = $menu_item->menu_item_parent ? $menu_item->menu_item_parent : $menu_item->ID;
                break;
            }
        }

        if( $root_id == 0){
            $root_id = $sorted_menu_items[1]->ID;
        }
  
        // find the top level parent
        if( ! isset( $args->direct_parent ) ){
            $prev_root_id = $root_id;
            while( $prev_root_id != 0 ){
                foreach( $sorted_menu_items as $menu_item ){
                    if( $menu_item->ID == $prev_root_id ){
                        $prev_root_id = $menu_item->menu_item_parent;
                        // don't set the root_id to 0 if we've reached the top of the menu
                        if( $prev_root_id != 0 ) $root_id = $menu_item->menu_item_parent;
                        break;
                    }
                }
            }
        }

        $menu_item_parents = array();
        foreach( $sorted_menu_items as $key => $item ){
            // init menu_item_parents
            if( $item->ID == $root_id ) $menu_item_parents[] = $item->ID;

            if( in_array( $item->menu_item_parent, $menu_item_parents ) ){
                // part of sub-tree: keep!
                $menu_item_parents[] = $item->ID;
            }else if( !(isset( $args->show_parent ) && in_array( $item->ID, $menu_item_parents )) ){
                // not part of sub-tree: away with it!
                unset( $sorted_menu_items[$key] );
            }
        }
    }

    return $sorted_menu_items;
}
add_filter( 'wp_nav_menu_objects', 'essort_get_current_submenu', 10, 2 );

// Display descriptions in menu
function essort_menu_display_desc( $item_output, $item, $depth, $args ){
    if( isset( $args->desc ) ){
        $item_output = preg_replace( '/<\/a>/', '<span>' . $item->description . '</span></a>', $item_output );
    }

    return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'essort_menu_display_desc', 10, 4 );

// Custom posts parents marked as current + filter css class in wp nav menu
function essor_custom_post_nav_class( $classes, $item, $args ){
	if( is_singular( 'reference' ) ){
        if( $item->object_id == url_to_postid( get_field('refsLink', 'options') ) || $item->object_id == get_option( 'page_on_front' ) ){
            $classes[] = 'current_page_parent';
        }else{
            $classes = array_diff( $classes, array( 'current_page_parent' ) );
        }
    }

    if( is_singular( 'offre' ) ){
        if( $item->object_id == url_to_postid( get_field('offersLink', 'options') ) || $item->object_id == get_option( 'page_on_front' ) ){
            $classes[] = 'current_page_parent';
        }else{
            $classes = array_diff( $classes, array( 'current_page_parent' ) );
        }
    }

    if( $args->menu_id == 'menuSecondary' ){
        if( is_page_template('application.php') || is_page_template('testimonies.php') ){
            if( $item->object_id == url_to_postid( get_field('offersLink', 'options') ) ){
                $classes[] = 'current_page_parent';
            }else{
                $classes = array_diff( $classes, array( 'current_page_parent' ) );
            }
        }
    }

    if( is_page_template('about.php') ){
        if( $item->object_id == url_to_postid( get_field('aboutLink', 'options') ) ){
            $classes[] = 'current_page_parent';
        }else{
            $classes = array_diff( $classes, array( 'current_page_parent' ) );
        }
    }

    if( is_page_template('contact.php') ){
        if( $item->object_id == get_option( 'page_on_front' ) ){
            $classes[] = 'current_page_parent';
        }else{
            $classes = array_diff( $classes, array( 'current_page_parent' ) );
        }
    }

    if( is_search() || is_404() ){
        $classes = array_diff( $classes, array( 'current_page_parent' ) );
    }
	
	return is_array( $classes ) ? array_intersect( $classes, array('current-menu-item', 'current_page_parent', 'current_page_ancestor', 'link-download') ) : '';
}
add_action( 'nav_menu_css_class', 'essor_custom_post_nav_class', 10, 3 );


/*-----------------------------------------------------------------------------------*/
/* Post types
/*-----------------------------------------------------------------------------------*/
function essor_post_type(){
    register_post_type( 'reference', array(
        'label' => 'Références',
        'singular_label' => 'Référence',
        'public' => true,
        'menu_icon' => 'dashicons-portfolio',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions'),
    ) );

    register_post_type( 'offre', array(
        'label' => 'Offres d\'emploi',
        'singular_label' => 'Offre d\'emploi',
        'public' => true,
        'menu_icon' => 'dashicons-businessman',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions')
    ) );
}
add_action( 'init', 'essor_post_type' );

function essor_taxonomies(){
    register_taxonomy( 'metier', 'reference', array(
        'label' => 'Métiers',
        'singular_label' => 'Métier',
        'hierarchical' => true,
        'show_admin_column' => true
    ) );

    register_taxonomy( 'batiment', 'reference', array(
        'label' => 'Types de bâtiment',
        'singular_label' => 'Type de bâtiment',
        'hierarchical' => true,
        'show_admin_column' => true
    ) );

    register_taxonomy( 'contrat', 'offre', array(
        'label' => 'Types de contrat',
        'singular_label' => 'Type de contrat',
        'hierarchical' => true,
        'show_admin_column' => true
    ) );

    register_taxonomy( 'lieu', 'offre', array(
        'label' => 'Lieux',
        'singular_label' => 'Lieu',
        'hierarchical' => true,
        'show_admin_column' => true
    ) );
}
add_action( 'init', 'essor_taxonomies' );


// /*-----------------------------------------------------------------------------------*/
// /* Sidebar & Widgets
// /*-----------------------------------------------------------------------------------*/
// function essor_register_sidebars(){
// 	register_sidebar( array(
// 		'id' => 'sidebar',
// 		'name' => 'Sidebar',
// 		'description' => 'Take it on the side...',
// 		'before_widget' => '',
// 		'after_widget' => '',
// 		'before_title' => '',
// 		'after_title' => '',
// 		'empty_title'=> ''
// 	) );
// }
// add_action( 'widgets_init', 'essor_register_sidebars' );

// // Deregister default widgets
// function essor_unregister_default_widgets(){
//     unregister_widget( 'WP_Widget_Pages' );
//     unregister_widget( 'WP_Widget_Calendar' );
//     unregister_widget( 'WP_Widget_Archives' );
//     unregister_widget( 'WP_Widget_Links' );
//     unregister_widget( 'WP_Widget_Meta' );
//     unregister_widget( 'WP_Widget_Search' );
//     unregister_widget( 'WP_Widget_Text' );
//     unregister_widget( 'WP_Widget_Categories' );
//     unregister_widget( 'WP_Widget_Recent_Posts' );
//     unregister_widget( 'WP_Widget_Recent_Comments' );
//     unregister_widget( 'WP_Widget_RSS' );
//     unregister_widget( 'WP_Widget_Tag_Cloud' );
//     unregister_widget( 'WP_Nav_Menu_Widget' );
// }
// add_action( 'widgets_init', 'essor_unregister_default_widgets' );


/*-----------------------------------------------------------------------------------*/
/* Enqueue Styles and Scripts
/*-----------------------------------------------------------------------------------*/
function essor_load_more(){
    if( !isset($_REQUEST) ) return;

    $postType = isset( $_POST['postType'] ) ? $_POST['postType'] : '';
    $postNb = isset( $_POST['offset'] ) ? $_POST['offset'] : '';
    $args = isset( $_POST['queryArgs'] ) ? $_POST['queryArgs'] : '';

    if( !$postType || !$postNb ) return;

    $args['post_type'] = $postType;
    $args['posts_per_page'] = $postNb;
    $args['offset'] = $postNb;
        
    $loop = new WP_Query( $args );
    while( $loop->have_posts() ){
        $loop->the_post();
        if( $postType === 'reference' ){
            get_template_part( 'includes/reference' );
        }else if( $postType === 'offre' ){
            get_template_part( 'includes/offre' );
        }else{
            get_template_part( 'includes/post' );
        }
    }

    wp_die();
}
add_action( 'wp_ajax_essor_load_more', 'essor_load_more' );
add_action( 'wp_ajax_nopriv_essor_load_more', 'essor_load_more' );

function essor_scripts(){
    // header
	wp_enqueue_style( 'essor-style', get_template_directory_uri() . '/css/main.css', array(), ESSOR_VERSION );

	// footer
	wp_deregister_script( 'jquery' );
	wp_enqueue_script( 'essor-scripts', get_template_directory_uri() . '/js/main.js', array(), ESSOR_VERSION, true );

    wp_deregister_script( 'wp-embed' );

    // load more posts
    $postType = is_home() || is_category() ? get_field('postType', get_option( 'page_for_posts' )) : get_field('postType');
    $args = $postType ? array('post_type' => $postType, 'tax_query' => array('relation' => 'AND'), 'post_status' => 'publish', 'posts_per_page' => -1) : '';
    
    // if post type is reference
    if( get_field('sector') && $args ){
        array_push($args['tax_query'], array('taxonomy' => 'metier', 'field' => 'slug', 'terms' => get_term(get_field('sector'))->slug));
    }
    $refBuildingType = isset( $_GET['batiment'] ) ? $_GET['batiment'] : '';
    if( $refBuildingType && $args ){
        array_push($args['tax_query'], array('taxonomy' => 'batiment', 'field' => 'slug', 'terms' => $refBuildingType));
    }
    $refDate = isset( $_GET['year'] ) ? $_GET['year'] : '';
    if( $refDate && $args ){
        $args['date_query'] = array(array('year'  => $refDate)); 
    }

    // if post type is offre
    $offerContractType = isset( $_GET['contrat'] ) ? $_GET['contrat'] : '';
    if( $offerContractType && $args ){
        array_push($args['tax_query'], array('taxonomy' => 'contrat', 'field' => 'slug', 'terms' => $offerContractType));
    }
    $offerPlace = isset( $_GET['lieu'] ) ? $_GET['lieu'] : '';
    if( $offerPlace && $args ){
        array_push($args['tax_query'], array('taxonomy' => 'lieu', 'field' => 'slug', 'terms' => $offerPlace));
    }

    // if post is post
    if( is_category() && $args ){
        $args['cat'] = get_query_var('cat');
    }

    $query = $args ? new WP_Query( $args ) : '';
    $postNb = $query ? $query->found_posts : '';

    wp_localize_script( 'essor-scripts', 'wp', array(
        'adminAjax' => site_url( '/wp-admin/admin-ajax.php' ),
        'postType' => $postType,
        'postNb' => $postNb,
        'queryArgs' => $args
    ) );
}
add_action( 'wp_enqueue_scripts', 'essor_scripts' );

?>
