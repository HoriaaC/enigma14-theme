<?php
/**
 * ENIGMA 14 Theme Functions and Definitions
 *
 * Full Site Editing (FSE) & Modern Gutenberg Block Theme Configuration
 *
 * @package Enigma14
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Sets up theme defaults and registers modern Gutenberg theme supports.
 */
function enigma14_setup()
{
    // Make theme available for translation
    load_theme_textdomain('enigma14', get_template_directory() . '/languages');

    // Add modern Gutenberg & FSE theme supports
    add_theme_support('block-templates');
    add_theme_support('wp-block-styles');
    add_theme_support('editor-styles');

    // Enqueue editor styles to match the frontend design system
    add_editor_style(array(
        'style.css',
        'assets/css/tailwind.css',
        'assets/css/editor-blocks.css',
        'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,700&family=Inter:wght@400;500;600;700&display=swap',
        'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap'
    ));

    // Support responsive embedded content (YouTube, Vimeo, etc.)
    add_theme_support('responsive-embeds');

    // Let WordPress manage document title tag
    add_theme_support('title-tag');

    // Enable Featured Images (Post Thumbnails)
    add_theme_support('post-thumbnails');

    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Switch default core markup to output valid HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ));

    // Align wide and full support for blocks
    add_theme_support('align-wide');
}
add_action('after_setup_theme', 'enigma14_setup');

/**
 * Enqueue scripts and styles for frontend.
 */
function enigma14_scripts()
{
        // Material Symbols Outlined
    wp_enqueue_style(
        'enigma14-material-symbols',
        'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap',
        array(),
        null
    );

    // Google Fonts: Montserrat (Headings & Badges) & Inter (Body)
    wp_enqueue_style(
        'enigma14-google-fonts',
        'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,700&family=Inter:wght@400;500;600;700&display=swap',
        array(),
        null
    );

    // Main Theme Stylesheet
    wp_enqueue_style(
        'enigma14-style',
        get_stylesheet_uri(),
        array(),
        wp_get_theme()->get('Version')
    );

    // Main scripts
    wp_enqueue_script('enigma14-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.0', true);

    wp_localize_script('enigma14-scripts', 'enigma14_ajax', array(
        'ajax_url'      => admin_url('admin-ajax.php'),
        'nonce'         => wp_create_nonce('enigma14_assessment_action'),
        'upload_nonce'  => wp_create_nonce('enigma14_photo_upload_action'),
        'contact_nonce' => wp_create_nonce('enigma14_contact_action'),
    ));
}
add_action('wp_enqueue_scripts', 'enigma14_scripts');

/**
 * Backward compatibility helpers for legacy templates during transition.
 */
if (!function_exists('enigma14_nav')) {
    function enigma14_nav() {
        wp_nav_menu(array('container' => false, 'fallback_cb' => 'wp_page_menu'));
    }
}

if (!function_exists('enigma14_pagination')) {
    function enigma14_pagination() {
        the_posts_pagination(array(
            'mid_size'  => 2,
            'prev_text' => __('&laquo; Previous', 'enigma14'),
            'next_text' => __('Next &raquo;', 'enigma14'),
        ));
    }
}

if (!function_exists('enigma14_excerpt')) {
    function enigma14_excerpt($length_callback = '', $more_callback = '') {
        the_excerpt();
    }
}

if (!function_exists('enigma14_comments')) {
    function enigma14_comments($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        ?>
        <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
            <div class="comment-body">
                <div class="comment-author vcard">
                    <?php echo get_avatar($comment, 48); ?>
                    <cite class="fn"><?php echo get_comment_author_link(); ?></cite>
                </div>
                <div class="comment-meta">
                    <a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>"><?php printf(__('%1$s at %2$s', 'enigma14'), get_comment_date(), get_comment_time()); ?></a>
                </div>
                <?php comment_text(); ?>
                <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
            </div>
        <?php
    }
}

/**
 * Include ACF Site Identity Fields
 */
require_once get_template_directory() . '/inc/acf-site-identity.php';


/**
 * Register Servicii CPT
 */
require_once get_template_directory() . '/inc/cpt-servicii.php';
require_once get_template_directory() . '/inc/ajax-assessment.php';
require_once get_template_directory() . '/inc/ajax-contact.php';
require_once get_template_directory() . '/inc/modal-booking.php';


/**
 * Register ACF Custom Blocks
 */
require_once get_template_directory() . '/inc/acf-blocks.php';
require_once get_template_directory() . '/inc/acf-auto-sync.php';


/**
 * Register Menu Location & Nav Walker
 */
register_nav_menus(array(
    'primary'           => __('Meniul Principal (Header)', 'enigma14'),
    'footer_categories' => __('Meniu Footer Categorii', 'enigma14'),
    'footer_legal'      => __('Meniu Footer Legal', 'enigma14'),
));
require_once get_template_directory() . '/inc/nav-walker.php';





/**
 * Add Tailwind CDN to wp_head
 */



add_action('wp_enqueue_scripts', function() {
    wp_enqueue_style('enigma14-tailwind', get_template_directory_uri() . '/assets/css/tailwind.css', array(), '1.0');
});

/**
 * Enqueue styles and fonts for the Gutenberg Block Editor canvas
 */
add_action('enqueue_block_editor_assets', function() {
    // Google Fonts: Montserrat & Inter
    wp_enqueue_style(
        'enigma14-editor-fonts',
        'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,700&family=Inter:wght@400;500;600;700&display=swap',
        array(),
        null
    );

    // Material Symbols Outlined
    wp_enqueue_style(
        'enigma14-editor-symbols',
        'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap',
        array(),
        null
    );

    // Compiled Tailwind CSS
    wp_enqueue_style(
        'enigma14-editor-tailwind',
        get_template_directory_uri() . '/assets/css/tailwind.css',
        array(),
        wp_get_theme()->get('Version')
    );

    // Custom Editor Block Styling & Visual Boundaries
    wp_enqueue_style(
        'enigma14-editor-blocks',
        get_template_directory_uri() . '/assets/css/editor-blocks.css',
        array('enigma14-editor-tailwind'),
        wp_get_theme()->get('Version')
    );
});



/**
 * ACF JSON save and load points
 */
add_filter('acf/settings/save_json', function( $path ) {
    return get_stylesheet_directory() . '/acf-json';
});
add_filter('acf/settings/load_json', function( $paths ) {
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
});

/**
 * Admin styles for full-width ACF metaboxes under Gutenberg editor
 */
add_action('admin_head', 'enigma14_admin_metabox_styles');
function enigma14_admin_metabox_styles() {
    ?>
    <style>
        /* Make Gutenberg bottom metabox area 100% wide and nicely centered */
        .edit-post-layout__metaboxes {
            width: 100% !important;
            max-width: 1280px !important;
            margin: 30px auto !important;
            padding: 0 20px !important;
            box-sizing: border-box !important;
        }
        .edit-post-layout__metaboxes #poststuff {
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
        }
        .edit-post-layout__metaboxes #poststuff #post-body {
            margin-right: 0 !important;
            width: 100% !important;
            display: block !important;
        }
        .edit-post-layout__metaboxes #poststuff #post-body.columns-2 #postbox-container-2,
        .edit-post-layout__metaboxes #poststuff #post-body.columns-2 #postbox-container-1 {
            width: 100% !important;
            float: none !important;
            margin: 0 0 24px 0 !important;
            min-width: 0 !important;
        }
        .edit-post-layout__metaboxes .postbox {
            width: 100% !important;
            box-sizing: border-box !important;
            border-radius: 8px !important;
            overflow: hidden !important;
            border: 1px solid #c3c4c7 !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06) !important;
        }
        .edit-post-layout__metaboxes .postbox .postbox-header {
            background: #f6f7f7 !important;
            padding: 12px 16px !important;
        }
        .edit-post-layout__metaboxes .postbox .postbox-header h2 {
            font-size: 15px !important;
            font-weight: 700 !important;
        }
        .acf-postbox .acf-fields.-top > .acf-field {
            padding: 14px 18px !important;
        }
    </style>
    <?php
}

/**
 * Force Homepage Hero & Service Details metaboxes to be 'normal' (under the editor) instead of 'side'
 */
add_action('add_meta_boxes', 'enigma14_force_hero_metabox_under_editor', 9999, 2);
function enigma14_force_hero_metabox_under_editor($post_type, $post) {
    global $wp_meta_boxes;

    $metabox_keys = array('acf-group_homepage_hero', 'acf-group_service_details');

    if (isset($wp_meta_boxes[$post_type]['side'])) {
        foreach ($wp_meta_boxes[$post_type]['side'] as $priority => $boxes) {
            foreach ($metabox_keys as $key) {
                if (isset($boxes[$key])) {
                    $box = $boxes[$key];
                    unset($wp_meta_boxes[$post_type]['side'][$priority][$key]);
                    $wp_meta_boxes[$post_type]['normal']['high'][$key] = $box;
                }
            }
        }
    }
}

// Reset user's saved drag-and-drop order for these metaboxes so they are never stuck in the side panel
function enigma14_fix_metabox_order($order) {
    $metabox_keys = array('acf-group_homepage_hero', 'acf-group_service_details');
    if (is_array($order) && !empty($order['side'])) {
        foreach ($metabox_keys as $key) {
            if (strpos($order['side'], $key) !== false) {
                $order['side'] = trim(str_replace(array($key . ',', ',' . $key, $key), '', $order['side']), ',');
                if (empty($order['normal'])) {
                    $order['normal'] = $key;
                } else {
                    $order['normal'] = $key . ',' . $order['normal'];
                }
            }
        }
    }
    return $order;
}
add_filter('get_user_option_meta-box-order_page', 'enigma14_fix_metabox_order');
add_filter('get_user_option_meta-box-order_serviciu', 'enigma14_fix_metabox_order');

// Update database post for group_homepage_hero to normal
add_action('init', function() {
    if (!is_admin()) return;
    $groups = get_posts(array(
        'post_type' => 'acf-field-group',
        'numberposts' => -1,
        'post_status' => 'any'
    ));
    foreach ($groups as $g) {
        if ($g->post_excerpt === 'group_homepage_hero' || $g->post_name === 'group_homepage_hero') {
            $data = maybe_unserialize($g->post_content);
            if (is_array($data) && (!isset($data['position']) || $data['position'] !== 'normal')) {
                $data['position'] = 'normal';
                $data['style'] = 'default';
                wp_update_post(array(
                    'ID' => $g->ID,
                    'post_content' => maybe_serialize($data)
                ));
            }
        }
    }
}, 30);

/**
 * Under Construction / Maintenance Mode Interceptor
 */
function enigma14_under_construction_interceptor() {
    if (!function_exists('get_field')) {
        return;
    }

    $is_enabled = get_field('under_construction_enabled', 'option');
    $is_preview = isset($_GET['preview_maintenance']) && $_GET['preview_maintenance'] == '1';

    // If not enabled and not preview, exit
    if (!$is_enabled && !$is_preview) {
        return;
    }

    // Allow administrators to navigate normal pages UNLESS previewing
    if (current_user_can('manage_options') && !$is_preview) {
        return;
    }

    // Skip AJAX, Cron, REST API, or WP-Login
    if (wp_doing_ajax() || wp_doing_cron()) {
        return;
    }

    if (defined('REST_REQUEST') && REST_REQUEST) {
        return;
    }

    $pagenow = isset($GLOBALS['pagenow']) ? $GLOBALS['pagenow'] : '';
    if ($pagenow === 'wp-login.php' || is_admin()) {
        return;
    }

    // Set 503 HTTP status header (maintenance) if not previewing
    if (!$is_preview) {
        status_header(503);
        header('Retry-After: 3600');
    }

    $template = get_template_directory() . '/template-under-construction.php';
    if (file_exists($template)) {
        include $template;
        exit;
    }
}
add_action('template_redirect', 'enigma14_under_construction_interceptor', 1);

/**
 * Visual Admin Bar Alert & Preview Link when Under Construction is active
 */
function enigma14_under_construction_admin_bar($wp_admin_bar) {
    if (function_exists('get_field') && get_field('under_construction_enabled', 'option')) {
        $wp_admin_bar->add_node(array(
            'id'    => 'enigma14_under_construction_badge',
            'title' => '<span style="background:#ff7700;color:#000;font-weight:800;padding:3px 10px;border-radius:4px;font-size:11px;letter-spacing:0.05em;display:inline-flex;align-items:center;gap:4px;">🚧 SITE ÎN MENTENANȚĂ (Previzualizează)</span>',
            'href'  => home_url('/?preview_maintenance=1'),
            'meta'  => array('target' => '_blank', 'title' => 'Apasă pentru a previzualiza ecranul de mentenanță')
        ));
    }
}
add_action('admin_bar_menu', 'enigma14_under_construction_admin_bar', 100);

/**
 * Admin Notice in Dashboard when Under Construction is active
 */
function enigma14_under_construction_admin_notice() {
    if (function_exists('get_field') && get_field('under_construction_enabled', 'option')) {
        if (current_user_can('manage_options')) {
            ?>
            <div class="notice notice-warning is-dismissible" style="border-left-color: #ff7700;">
                <p><strong>[ENIGMA 14] Modul „Under Construction” este ACTIV.</strong> Doar administratorii autentificați pot naviga pe site; toți ceilalți vizitatori văd afișul centrat de mentenanță. Poți vedea cum arată ecranul accesând <a href="<?php echo esc_url(home_url('/?preview_maintenance=1')); ?>" target="_blank"><strong>Previzualizează Pagina de Mentenanță</strong></a> sau îl poți dezactiva din <a href="<?php echo admin_url('admin.php?page=enigma14-settings'); ?>"><strong>Setări Site</strong></a>.</p>
            </div>
            <?php
        }
    }
}
/**
 * Route Block Templates to Theme PHP Template Files
 */
add_filter('template_include', function($template) {
    if (is_front_page()) {
        $front_file = get_template_directory() . '/front-page.php';
        if (file_exists($front_file)) {
            return $front_file;
        }
    }
    if (is_page()) {
        $slug = get_page_template_slug();
        if ($slug === 'page-contact' || $slug === 'page-contact.php') {
            $php_file = get_template_directory() . '/page-contact.php';
            if (file_exists($php_file)) {
                return $php_file;
            }
        }
        if ($slug === 'front-page' || $slug === 'front-page.php') {
            $php_file = get_template_directory() . '/front-page.php';
            if (file_exists($php_file)) {
                return $php_file;
            }
        }
        if ($slug === 'template-demo' || $slug === 'template-demo.php') {
            $php_file = get_template_directory() . '/template-demo.php';
            if (file_exists($php_file)) {
                return $php_file;
            }
        }
    }
    return $template;
}, 99);
