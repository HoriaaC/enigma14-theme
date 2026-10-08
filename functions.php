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
        // Material Symbols Outlined (display=block prevents FOUT / raw ligature text flashing)
    wp_enqueue_style(
        'enigma14-material-symbols',
        'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=block',
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

    // Inline Main Theme Styles (Compiled Tailwind CSS + style.css)
    // Inlining eliminates external render-blocking HTTP requests (600ms+ latency)
    $tailwind_file = get_template_directory() . '/assets/css/tailwind.css';
    $style_file    = get_stylesheet_directory() . '/style.css';

    wp_register_style('enigma14-theme-styles', false);
    wp_enqueue_style('enigma14-theme-styles');

    $combined_css = '';
    if (file_exists($tailwind_file)) {
        $combined_css .= file_get_contents($tailwind_file) . "\n";
    }
    if (file_exists($style_file)) {
        $combined_css .= file_get_contents($style_file) . "\n";
    }

    if (!empty($combined_css)) {
        wp_add_inline_style('enigma14-theme-styles', $combined_css);
    }

    // Main scripts
    wp_enqueue_script('enigma14-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.2', true);

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
require_once get_template_directory() . '/inc/catalog-importer.php';
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

/**
 * Customize sender name and email address for all outgoing WordPress emails.
 * Replaces default "WordPress <wordpress@domain.com>" with "Client - ENIGMA 14 <client@centruldechei.ro>".
 */
add_filter('wp_mail_from_name', function($name) {
    if (empty($name) || $name === 'WordPress') {
        return 'Client - ENIGMA 14';
    }
    return $name;
});

add_filter('wp_mail_from', function($email) {
    if (empty($email) || strpos($email, 'wordpress@') === 0) {
        return 'client@centruldechei.ro';
    }
    return $email;
});

/**
 * =========================================================================
 * CORE WEB VITALS & SPEED OPTIMIZATIONS (Preconnect, Async Fonts, Defer JS)
 * =========================================================================
 */

/**
 * 1. Resource Hints: Preconnect to Google Fonts and GStatic at top of <head>
 */
add_action('wp_head', function() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}, 1);

/**
 * 2. Asynchronously load Google Fonts & Material Symbols without blocking initial render
 */
add_filter('style_loader_tag', function($html, $handle, $href, $media) {
    if (in_array($handle, array('enigma14-google-fonts'), true)) {
        return '<link rel="preload" href="' . esc_url($href) . '" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">' . "\n"
             . '<noscript><link rel="stylesheet" href="' . esc_url($href) . '"></noscript>' . "\n";
    }
    return $html;
}, 10, 4);

/**
 * 3. Remove jQuery Migrate from frontend to eliminate unnecessary render-blocking script
 */
add_action('wp_default_scripts', function($scripts) {
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        if ($script->deps) {
            $script->deps = array_diff($script->deps, array('jquery-migrate'));
        }
    }
});

/**
 * 4. Defer non-critical scripts (jQuery, Cookie Law Info, enigma14-scripts) on frontend
 */
add_filter('script_loader_tag', function($tag, $handle, $src) {
    if (is_admin()) {
        return $tag;
    }

    $defer_handles = array(
        'jquery',
        'jquery-core',
        'enigma14-scripts',
        'cookie-law-info',
        'cli-style-script',
    );

    $should_defer = in_array($handle, $defer_handles, true)
        || (is_string($handle) && strpos($handle, 'cookie-law-info') !== false)
        || (is_string($src) && strpos($src, 'cookie-law-info') !== false);

    if ($should_defer) {
        if (strpos($tag, ' defer') === false && strpos($tag, ' async') === false) {
            $tag = str_replace('<script ', '<script defer ', $tag);
        }
    }

    return $tag;
}, 10, 3);

/**
 * 5. Dynamic SEO Meta Description & Social Open Graph Tags
 * Automatically outputs high-relevance, optimized meta descriptions across all page types,
 * resolving the Google Lighthouse SEO audit: "Document does not have a meta description".
 */
add_action('wp_head', function() {
    // If a dedicated SEO plugin is installed in the future (Yoast, Rank Math, AIOSEO), let it handle meta tags
    if (defined('WPSEO_VERSION') || function_exists('rank_math') || defined('AIOSEO_VERSION') || defined('SEOPRESS_VERSION')) {
        return;
    }

    $description = '';
    $site_name   = get_bloginfo('name') ?: 'ENIGMA 14';

    if (is_front_page() || is_home()) {
        if (function_exists('get_field')) {
            $description = get_field('site_meta_description', 'option');
            if (empty($description)) {
                $description = get_field('hero_subtitle');
            }
        }
        if (empty($description)) {
            $tagline = get_bloginfo('description');
            if (!empty($tagline) && stripos($tagline, 'WordPress') === false) {
                $description = $tagline;
            } else {
                $description = 'Centrul Tehnic Specializat ENIGMA 14 București Sector 1: Duplicare și programare chei auto cu cip, chei rezidențiale de înaltă siguranță, cartele interfon și mecatronică de precizie.';
            }
        }
    } elseif (is_singular('serviciu')) {
        $post_id = get_the_ID();
        if (function_exists('get_field')) {
            $description = get_field('service_hero_description', $post_id);
        }
        if (empty($description)) {
            $description = get_the_excerpt($post_id);
        }
        if (empty($description)) {
            $title = get_the_title($post_id);
            $description = "Servicii profesionale {$title} la centrul tehnic ENIGMA 14 București Sector 1. Echipamente CNC de înaltă precizie, decodare computerizată și execuție pe loc.";
        }
    } elseif (is_page('contact') || is_page_template('page-contact.php')) {
        $post_id = get_the_ID();
        if (function_exists('get_field')) {
            $description = get_field('contact_hero_desc', $post_id);
        }
        if (empty($description)) {
            $description = 'Contact & Localizare Atelier Mecatronic ENIGMA 14 în București Sector 1. Vino la atelier sau trimite fotografia cheii pentru diagnoză optică și estimare de preț.';
        }
    } elseif (is_tax('categorie_serviciu')) {
        $term = get_queried_object();
        if ($term && function_exists('get_field')) {
            $description = get_field('cat_hero_description', $term);
        }
        if (empty($description) && $term && !empty($term->description)) {
            $description = $term->description;
        }
        if (empty($description)) {
            $term_name = single_term_title('', false);
            $description = "Servicii mecatronice specializate pentru {$term_name} la ENIGMA 14 București Sector 1. Tehnologie CNC, decodare electronică și garanție tehnică.";
        }
    } elseif (is_singular()) {
        $post_id = get_the_ID();
        if (has_excerpt($post_id)) {
            $description = get_the_excerpt($post_id);
        } else {
            $content = get_post_field('post_content', $post_id);
            if (!empty($content)) {
                $description = wp_strip_all_tags(strip_shortcodes($content));
            }
        }
        if (empty($description)) {
            $description = get_the_title($post_id) . ' - Centrul Tehnic Specializat ENIGMA 14 București Sector 1.';
        }
    } elseif (is_category() || is_tag() || is_archive()) {
        $description = get_the_archive_description();
        if (empty($description)) {
            $description = 'Arhivă ' . get_the_archive_title() . ' - Atelier mecatronic ENIGMA 14 București Sector 1.';
        }
    } elseif (is_search()) {
        $description = 'Rezultate căutare pentru "' . get_search_query() . '" pe site-ul ENIGMA 14 Centrul Tehnic de Copiere Chei.';
    }

    if (empty($description)) {
        $description = 'ENIGMA 14 - Centrul Tehnic Specializat de Duplicare și Decodare Chei București Sector 1. Chei auto cu cip, chei rezidențiale, cartele interfon și mecatronică.';
    }

    // Clean, sanitize, and limit to ideal 155-160 chars for Google SERP snippet
    $description = wp_strip_all_tags($description);
    $description = trim(preg_replace('/\s+/', ' ', $description));
    if (mb_strlen($description) > 160) {
        $description = mb_substr($description, 0, 157);
        $description = preg_replace('/\s+?(\S+)?$/', '', $description) . '...';
    }

    $current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $page_title  = wp_get_document_title();

    // Output Meta Description & Open Graph Tags
    echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($description) . '">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr($page_title) . '">' . "\n";
    echo '<meta property="og:type" content="' . (is_singular() ? 'article' : 'website') . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url($current_url) . '">' . "\n";
    echo '<meta property="og:site_name" content="' . esc_attr($site_name) . '">' . "\n";
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr($description) . '">' . "\n";
}, 2);



