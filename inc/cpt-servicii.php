<?php
/**
 * Custom Post Type: Servicii (Catalog)
 */

if (!defined('ABSPATH')) {
    exit;
}

function enigma14_register_servicii_cpt() {
    $labels = array(
        'name'                  => _x('Servicii', 'Post type general name', 'enigma14'),
        'singular_name'         => _x('Serviciu', 'Post type singular name', 'enigma14'),
        'menu_name'             => _x('Servicii & Catalog', 'Admin Menu text', 'enigma14'),
        'name_admin_bar'        => _x('Serviciu', 'Add New on Toolbar', 'enigma14'),
        'add_new'               => __('Adaugă Serviciu', 'enigma14'),
        'add_new_item'          => __('Adaugă Serviciu Nou', 'enigma14'),
        'new_item'              => __('Serviciu Nou', 'enigma14'),
        'edit_item'             => __('Editează Serviciul', 'enigma14'),
        'view_item'             => __('Vezi Serviciul', 'enigma14'),
        'all_items'             => __('Toate Serviciile', 'enigma14'),
        'search_items'          => __('Caută Servicii', 'enigma14'),
        'parent_item_colon'     => __('Servicii Părinte:', 'enigma14'),
        'not_found'             => __('Nu au fost găsite servicii.', 'enigma14'),
        'not_found_in_trash'    => __('Nu au fost găsite servicii în coșul de gunoi.', 'enigma14'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'servicii'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-admin-tools',
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest'       => true, // Enable Gutenberg editor for this CPT
    );

    register_post_type('serviciu', $args);

    // Register Taxonomy
    $tax_labels = array(
        'name'              => _x('Categorii Servicii', 'taxonomy general name', 'enigma14'),
        'singular_name'     => _x('Categorie', 'taxonomy singular name', 'enigma14'),
        'search_items'      => __('Caută Categorii', 'enigma14'),
        'all_items'         => __('Toate Categoriile', 'enigma14'),
        'parent_item'       => __('Categorie Părinte', 'enigma14'),
        'parent_item_colon' => __('Categorie Părinte:', 'enigma14'),
        'edit_item'         => __('Editează Categoria', 'enigma14'),
        'update_item'       => __('Actualizează Categoria', 'enigma14'),
        'add_new_item'      => __('Adaugă Categorie Nouă', 'enigma14'),
        'new_item_name'     => __('Nume Categorie Nouă', 'enigma14'),
        'menu_name'         => __('Categorii Servicii', 'enigma14'),
    );

    $tax_args = array(
        'hierarchical'      => true,
        'labels'            => $tax_labels,
        'public'            => true,
        'publicly_queryable'=> true,
        'show_ui'           => true,
        'show_in_menu'      => true,
        'show_in_nav_menus' => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'categorie-serviciu'),
        'show_in_rest'      => true,
    );

    register_taxonomy('categorie_serviciu', array('serviciu'), $tax_args);
}
add_action('init', 'enigma14_register_servicii_cpt', 0);

/**
 * Ensure 'Categorii Servicii' and 'Servicii' are visible in Appearance -> Menus
 */
add_filter('hidden_meta_boxes', function($hidden, $screen) {
    if (isset($screen->id) && $screen->id === 'nav-menus' && is_array($hidden)) {
        $hidden = array_diff($hidden, array('add-categorie_serviciu', 'add-post-type-serviciu'));
    }
    return $hidden;
}, 10, 2);

add_filter('default_hidden_meta_boxes', function($hidden, $screen) {
    if (isset($screen->id) && $screen->id === 'nav-menus' && is_array($hidden)) {
        $hidden = array_diff($hidden, array('add-categorie_serviciu', 'add-post-type-serviciu'));
    }
    return $hidden;
}, 10, 2);

/**
 * Append category name in parentheses when displaying 'serviciu' items in Appearance -> Menus
 */
function enigma14_append_category_to_serviciu_menu_items($posts, $args = array(), $post_type = null) {
    if (empty($posts) || !is_array($posts)) {
        return $posts;
    }

    foreach ($posts as $post) {
        if (!empty($post->ID)) {
            $terms = get_the_terms($post->ID, 'categorie_serviciu');
            if (!empty($terms) && !is_wp_error($terms)) {
                $cat_names = wp_list_pluck($terms, 'name');
                $post->label = $post->post_title . ' (' . html_entity_decode(implode(', ', $cat_names)) . ')';
            }
        }
    }

    return $posts;
}
add_filter('nav_menu_items_serviciu', 'enigma14_append_category_to_serviciu_menu_items', 10, 3);
add_filter('nav_menu_items_serviciu_recent', 'enigma14_append_category_to_serviciu_menu_items', 10, 3);

/**
 * Handle Search tab and Quick Search AJAX in Appearance -> Menus
 */
add_filter('the_title', function($title, $post_id = 0) {
    global $pagenow;
    $is_nav_menus = is_admin() && isset($pagenow) && $pagenow === 'nav-menus.php';
    $is_quick_search = defined('DOING_AJAX') && DOING_AJAX && isset($_REQUEST['action']) && $_REQUEST['action'] === 'menu-quick-search';

    if (($is_nav_menus || $is_quick_search) && $post_id && get_post_type($post_id) === 'serviciu') {
        if (strpos($title, ' (') === false) {
            $terms = get_the_terms($post_id, 'categorie_serviciu');
            if (!empty($terms) && !is_wp_error($terms)) {
                $cat_names = wp_list_pluck($terms, 'name');
                $title .= ' (' . html_entity_decode(implode(', ', $cat_names)) . ')';
            }
        }
    }
    return $title;
}, 10, 2);

/**
 * Display category in the menu editor item badge on the right
 */
add_filter('wp_setup_nav_menu_item', function($menu_item) {
    if (is_admin() && isset($menu_item->object) && $menu_item->object === 'serviciu' && !empty($menu_item->object_id)) {
        $terms = get_the_terms($menu_item->object_id, 'categorie_serviciu');
        if (!empty($terms) && !is_wp_error($terms)) {
            $cat_names = wp_list_pluck($terms, 'name');
            $menu_item->type_label = 'Serviciu (' . html_entity_decode(implode(', ', $cat_names)) . ')';
        }
    }
    return $menu_item;
});


