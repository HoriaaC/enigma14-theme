<?php
/**
 * Taxonomy Template: Categorie Servicii (ENIGMA 14)
 * Based on stich/chei_auto_moto.html
 */

$current_term = get_queried_object();
$term_id = $current_term && isset($current_term->term_id) ? $current_term->term_id : 0;
$term_name = $current_term && isset($current_term->name) ? $current_term->name : 'Categorii Servicii';
$term_desc = $current_term && isset($current_term->description) ? $current_term->description : '';

// Helper to get ACF term field with fallback
function enigma_get_term_field($field, $term) {
    if (!$term) return '';
    $val = get_field($field, $term);
    if (empty($val) && isset($term->term_id)) {
        $val = get_field($field, 'term_' . $term->term_id);
    }
    return $val;
}

// Hero Ribbon & Background
$ribbon_text = enigma_get_term_field('cat_status_ribbon_text', $current_term) ?: 'DIAGNOZĂ OBD & DECODARE PE LOC';
$hero_bg_image = enigma_get_term_field('cat_hero_bg_image', $current_term) ?: 'https://lh3.googleusercontent.com/aida-public/AB6AXuB6Y7TO9Ewtk4-8ME5zCTQMgb5h4old54ti5hqnVlXsi5Bltk4-CEp6ShJQ5rS_jFiR_2Z8GhEjBV9E-yqwmpkd1noeipakuLibqfQSpTMu-i6R_ptQY9hA9MqokAnhTJ26pxDTPu5GVQXVqQ_14ReiNW3sxeJxYo2pmMjq4snKNon3XfgObN2UIhbsPZz-Q5NcxiZd1srx9ZwjggKffw2XtKkQr_zvS04AXwLQZCdgpuvjVid33pA5';

// Hero Content (Left)
$hero_badge_icon = enigma_get_term_field('cat_hero_badge_icon', $current_term) ?: 'key';
$hero_badge_text = enigma_get_term_field('cat_hero_badge_text', $current_term) ?: 'ATELIER MECATRONIC SECTOR 1';
$hero_title = enigma_get_term_field('cat_hero_title', $current_term);
if (empty($hero_title)) {
    $hero_title = 'Servicii <span class="text-primary-container">' . esc_html($term_name) . '</span>';
}
$hero_description = enigma_get_term_field('cat_hero_description', $current_term) ?: ($term_desc ?: 'Programare cip, scutere și intervenții rapide. Multiplicare de precizie, decodare transponder crypto și tăiere laser CNC direct în atelier.');

// CTAs
$hero_btn1_text = enigma_get_term_field('cat_hero_btn1_text', $current_term) ?: 'CERE O EVALUARE ACUM';
$hero_btn1_url  = enigma_get_term_field('cat_hero_btn1_url', $current_term) ?: '#solicita-evaluare';
$hero_btn2_text = enigma_get_term_field('cat_hero_btn2_text', $current_term) ?: '0722 000 114 — SUPORT DIRECT';
$hero_btn2_url  = enigma_get_term_field('cat_hero_btn2_url', $current_term) ?: 'tel:0722000114';

// 4 Quick Specs
$spec1_label = enigma_get_term_field('cat_spec1_label', $current_term) ?: 'TOLERANȚĂ CNC';
$spec1_val   = enigma_get_term_field('cat_spec1_val', $current_term) ?: '±0.02 mm';
$spec2_label = enigma_get_term_field('cat_spec2_label', $current_term) ?: 'DECODARE CIP';
$spec2_val   = enigma_get_term_field('cat_spec2_val', $current_term) ?: 'ID46 / MQB';
$spec3_label = enigma_get_term_field('cat_spec3_label', $current_term) ?: 'EXECUȚIE RAPIDĂ';
$spec3_val   = enigma_get_term_field('cat_spec3_val', $current_term) ?: '10 - 25 min';
$spec4_label = enigma_get_term_field('cat_spec4_label', $current_term) ?: 'FRECVENȚĂ RF';
$spec4_val   = enigma_get_term_field('cat_spec4_val', $current_term) ?: '433 / 868 MHz';

// CNC Equipment Console (Right)
$console_icon  = enigma_get_term_field('cat_console_icon', $current_term) ?: 'precision_manufacturing';
$console_title = enigma_get_term_field('cat_console_title', $current_term) ?: 'Stand Mecatronic Atelier';
$console_badge = enigma_get_term_field('cat_console_badge', $current_term) ?: 'ONLINE';

$eq1_name = enigma_get_term_field('cat_console_eq1_name', $current_term) ?: 'Silca Futura Edge CNC';
$eq1_tag  = enigma_get_term_field('cat_console_eq1_tag', $current_term) ?: 'LAME LASER / AMPRENTĂ';
$eq2_name = enigma_get_term_field('cat_console_eq2_name', $current_term) ?: 'Keyline Gymkana 994';
$eq2_tag  = enigma_get_term_field('cat_console_eq2_tag', $current_term) ?: 'DECODARE AUTOMATĂ';
$eq3_name = enigma_get_term_field('cat_console_eq3_name', $current_term) ?: 'Tango Programmer & VVDI';
$eq3_tag  = enigma_get_term_field('cat_console_eq3_tag', $current_term) ?: 'TRANSPONDER EEPROM';
$eq4_name = enigma_get_term_field('cat_console_eq4_name', $current_term) ?: 'Tester Frecvență RF / LF';
$eq4_tag  = enigma_get_term_field('cat_console_eq4_tag', $current_term) ?: 'SMART KEYLESS GO';

$guarantee_title = enigma_get_term_field('cat_guarantee_title', $current_term) ?: 'Garanție Mecatronică 24 Luni';
$guarantee_sub   = enigma_get_term_field('cat_guarantee_subtitle', $current_term) ?: 'Testare pornire motor și telecomandă pe stand direct la predare';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class('bg-surface font-body-md text-on-surface antialiased selection:bg-primary-container selection:text-on-primary-container'); ?>>
<?php wp_body_open(); ?>

<?php echo do_blocks('<!-- wp:template-part {"slug":"header"} /-->'); ?>

<main class="w-full bg-surface min-h-[calc(100vh-110px)] pt-36 md:pt-[145px]">
    <div class="flex flex-col w-full">

        <!-- ========================================== -->
        <!-- 1. BREADCRUMB & LIVE STATUS RIBBON         -->
        <!-- ========================================== -->
        <section class="w-full bg-surface-container-lowest border-b border-surface-container-highest/30">
            <div class="max-w-[1280px] mx-auto px-gutter-mobile lg:px-gutter-desktop py-space-sm flex flex-col sm:flex-row sm:items-center justify-between gap-space-sm">
                <nav aria-label="Breadcrumb" class="flex items-center gap-space-xs text-body-sm font-body-sm text-outline flex-wrap">
                    <a class="hover:text-primary transition-colors" href="<?php echo esc_url(home_url('/')); ?>">Acasă</a>
                    <span class="text-surface-container-highest">/</span>
                    <span class="text-primary font-semibold"><?php echo esc_html($term_name); ?></span>
                </nav>
                
                <?php if ($ribbon_text): ?>
                <div class="inline-flex items-center gap-space-xs px-space-sm py-1 bg-surface-container-high rounded self-start sm:self-auto">
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-container opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-primary-container"></span>
                    </span>
                    <span class="font-label-badge text-label-badge uppercase text-primary tracking-wider"><?php echo esc_html($ribbon_text); ?></span>
                </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- 2. CATEGORY HERO SECTION                   -->
        <!-- ========================================== -->
        <section class="relative w-full overflow-hidden bg-surface-container-lowest py-space-2xl lg:py-space-3xl">
            <!-- Macro Studio Photography Background Overlay -->
            <?php if ($hero_bg_image): ?>
            <div class="absolute inset-0 z-0 opacity-20 pointer-events-none mix-blend-luminosity">
                <img class="w-full h-full object-cover object-center" src="<?php echo esc_url($hero_bg_image); ?>" alt="" />
            </div>
            <?php endif; ?>
            <div class="absolute inset-0 z-0 bg-gradient-to-r from-surface-container-lowest via-surface-container-lowest/90 to-surface-container-lowest/70 pointer-events-none"></div>

            <div class="relative z-10 max-w-[1280px] mx-auto px-gutter-mobile lg:px-gutter-desktop">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-xl items-center">
                    
                    <!-- Left Hero Content (7 cols) -->
                    <div class="lg:col-span-7 flex flex-col space-y-space-lg">
                        
                        <?php if ($hero_badge_text): ?>
                        <div class="inline-flex items-center gap-2 px-space-sm py-1 bg-surface-container rounded w-fit">
                            <span class="material-symbols-outlined text-primary-container text-[18px]"><?php echo esc_html($hero_badge_icon); ?></span>
                            <span class="font-label-badge text-label-badge uppercase tracking-wider text-on-surface"><?php echo esc_html($hero_badge_text); ?></span>
                        </div>
                        <?php endif; ?>

                        <div class="space-y-space-xs">
                            <h1 class="font-display-lg text-display-lg text-on-surface uppercase tracking-tight">
                                <?php echo wp_kses_post($hero_title); ?>
                            </h1>
                            <?php if ($hero_description): ?>
                            <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed max-w-2xl">
                                <?php echo nl2br(esc_html($hero_description)); ?>
                            </p>
                            <?php endif; ?>
                        </div>

                        <!-- Action Buttons (CTAs) -->
                        <div class="flex flex-wrap items-center gap-space-md pt-space-xs">
                            <?php if ($hero_btn1_text): ?>
                            <a class="inline-flex items-center gap-2 bg-primary-container hover:bg-secondary-container text-on-primary-container font-label-action text-label-action px-space-lg py-space-sm rounded uppercase tracking-wider transition-all duration-200 shadow-lg shadow-primary-container/20 font-bold" href="<?php echo esc_url($hero_btn1_url); ?>">
                                <span class="material-symbols-outlined text-[18px]">bolt</span>
                                <span><?php echo esc_html($hero_btn1_text); ?></span>
                            </a>
                            <?php endif; ?>

                            <?php if ($hero_btn2_text): ?>
                            <a class="inline-flex items-center gap-2 bg-surface-container hover:bg-surface-container-high text-on-surface font-label-action text-label-action px-space-lg py-space-sm rounded uppercase tracking-wider transition-colors duration-200" href="<?php echo esc_url($hero_btn2_url); ?>">
                                <span class="material-symbols-outlined text-primary-container text-[18px]">phone_in_talk</span>
                                <span><?php echo esc_html($hero_btn2_text); ?></span>
                            </a>
                            <?php endif; ?>
                        </div>

                        <!-- Quick Tech Specs Badges (4 boxes) -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-space-xs pt-space-md">
                            <div class="p-space-xs bg-surface-container rounded flex flex-col">
                                <span class="font-label-badge text-[10px] text-outline uppercase"><?php echo esc_html($spec1_label); ?></span>
                                <span class="font-headline-sm text-headline-sm text-on-surface font-bold"><?php echo esc_html($spec1_val); ?></span>
                            </div>
                            <div class="p-space-xs bg-surface-container rounded flex flex-col">
                                <span class="font-label-badge text-[10px] text-outline uppercase"><?php echo esc_html($spec2_label); ?></span>
                                <span class="font-headline-sm text-headline-sm text-primary font-bold"><?php echo esc_html($spec2_val); ?></span>
                            </div>
                            <div class="p-space-xs bg-surface-container rounded flex flex-col">
                                <span class="font-label-badge text-[10px] text-outline uppercase"><?php echo esc_html($spec3_label); ?></span>
                                <span class="font-headline-sm text-headline-sm text-on-surface font-bold"><?php echo esc_html($spec3_val); ?></span>
                            </div>
                            <div class="p-space-xs bg-surface-container rounded flex flex-col">
                                <span class="font-label-badge text-[10px] text-outline uppercase"><?php echo esc_html($spec4_label); ?></span>
                                <span class="font-headline-sm text-headline-sm text-on-surface font-bold"><?php echo esc_html($spec4_val); ?></span>
                            </div>
                        </div>

                    </div>

                    <!-- Right Side: CNC Equipment Console Panel (5 cols) -->
                    <div class="lg:col-span-5">
                        <div class="bg-surface-container p-space-lg rounded shadow-xl relative overflow-hidden border border-surface-container-highest/40">
                            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-primary-container via-secondary to-primary-container"></div>
                            
                            <div class="flex items-center justify-between pb-space-sm mb-space-sm bg-surface-container-high p-space-xs rounded">
                                <div class="flex items-center gap-space-xs">
                                    <span class="material-symbols-outlined text-primary-container text-[20px]"><?php echo esc_html($console_icon); ?></span>
                                    <span class="font-headline-sm text-[14px] uppercase text-on-surface tracking-wider font-bold"><?php echo esc_html($console_title); ?></span>
                                </div>
                                <span class="font-label-badge text-[10px] px-2 py-0.5 bg-primary-container text-on-primary-container rounded font-bold"><?php echo esc_html($console_badge); ?></span>
                            </div>

                            <!-- Live Equipment Status List -->
                            <div class="space-y-space-xs text-body-sm font-body-sm text-on-surface-variant">
                                <div class="flex items-center justify-between p-space-2xs bg-surface-container-low rounded">
                                    <span class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[16px] text-primary">circle</span>
                                        <span class="font-semibold text-on-surface"><?php echo esc_html($eq1_name); ?></span>
                                    </span>
                                    <span class="font-label-badge text-outline"><?php echo esc_html($eq1_tag); ?></span>
                                </div>
                                <div class="flex items-center justify-between p-space-2xs bg-surface-container-low rounded">
                                    <span class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[16px] text-primary">circle</span>
                                        <span class="font-semibold text-on-surface"><?php echo esc_html($eq2_name); ?></span>
                                    </span>
                                    <span class="font-label-badge text-outline"><?php echo esc_html($eq2_tag); ?></span>
                                </div>
                                <div class="flex items-center justify-between p-space-2xs bg-surface-container-low rounded">
                                    <span class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[16px] text-primary">circle</span>
                                        <span class="font-semibold text-on-surface"><?php echo esc_html($eq3_name); ?></span>
                                    </span>
                                    <span class="font-label-badge text-outline"><?php echo esc_html($eq3_tag); ?></span>
                                </div>
                                <div class="flex items-center justify-between p-space-2xs bg-surface-container-low rounded">
                                    <span class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[16px] text-primary">circle</span>
                                        <span class="font-semibold text-on-surface"><?php echo esc_html($eq4_name); ?></span>
                                    </span>
                                    <span class="font-label-badge text-outline"><?php echo esc_html($eq4_tag); ?></span>
                                </div>
                            </div>

                            <!-- Certified Guarantee Footer -->
                            <div class="mt-space-md p-space-xs bg-surface-container-highest rounded flex items-center gap-space-xs">
                                <span class="material-symbols-outlined text-primary-container text-[24px] shrink-0">verified_user</span>
                                <div class="text-body-sm font-body-sm">
                                    <span class="text-on-surface font-semibold block"><?php echo esc_html($guarantee_title); ?></span>
                                    <span class="text-outline text-[11px] block"><?php echo esc_html($guarantee_sub); ?></span>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- 3. DETAILED SERVICES CATALOG GRID          -->
        <!-- ========================================== -->
        <?php
        $catalog_badge_icon = enigma_get_term_field('cat_services_badge_icon', $current_term) ?: 'build_circle';
        $catalog_badge_text = enigma_get_term_field('cat_services_badge_text', $current_term) ?: 'SERVICII SPECIALIZATE';
        $catalog_title      = enigma_get_term_field('cat_services_title', $current_term);
        if (empty($catalog_title)) {
            $catalog_title = 'Soluții ' . esc_html($term_name) . ' Complete';
        }
        $catalog_desc       = enigma_get_term_field('cat_services_desc', $current_term) ?: 'Catalog tehnic dedicat multiplicării și programării electronice pentru toate mărcile auto și moto. Fără coș de cumpărături — execuție pe stand în atelier sau asistență rapidă.';

        // 1. Check for manual selected services with icon (New Repeater in Category)
        $cat_services_list = enigma_get_term_field('cat_services_list', $current_term);
        $services_items = array();

        if (!empty($cat_services_list) && is_array($cat_services_list)) {
            foreach ($cat_services_list as $row) {
                $srv_obj = isset($row['service']) ? $row['service'] : null;
                $srv_id  = is_object($srv_obj) ? $srv_obj->ID : (int)$srv_obj;
                if ($srv_id > 0) {
                    $post_found = get_post($srv_id);
                    if ($post_found && $post_found->post_status === 'publish') {
                        $services_items[] = array(
                            'post'          => $post_found,
                            'override_icon' => isset($row['icon']) && !empty($row['icon']) ? $row['icon'] : '',
                        );
                    }
                }
            }
        }

        // 2. Check for legacy selected services (Relationship field)
        if (empty($services_items)) {
            $selected_services = enigma_get_term_field('cat_selected_services', $current_term);
            if (!empty($selected_services) && is_array($selected_services)) {
                foreach ($selected_services as $srv_obj) {
                    $srv_id = is_object($srv_obj) ? $srv_obj->ID : (int)$srv_obj;
                    if ($srv_id > 0) {
                        $post_found = get_post($srv_id);
                        if ($post_found && $post_found->post_status === 'publish') {
                            $services_items[] = array(
                                'post'          => $post_found,
                                'override_icon' => '',
                            );
                        }
                    }
                }
            }
        }

        // 3. Fallback: Query all services assigned to this taxonomy category
        if (empty($services_items) && $term_id > 0) {
            $tax_query_services = new WP_Query(array(
                'post_type'      => 'serviciu',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'categorie_serviciu',
                        'field'    => 'term_id',
                        'terms'    => $term_id,
                    ),
                ),
            ));
            if ($tax_query_services->have_posts()) {
                foreach ($tax_query_services->posts as $p) {
                    $services_items[] = array(
                        'post'          => $p,
                        'override_icon' => '',
                    );
                }
            }
        }

        $has_services = !empty($services_items);
        ?>
        <section class="w-full py-space-3xl bg-surface">
            <div class="max-w-[1280px] mx-auto px-gutter-mobile lg:px-gutter-desktop">
                <div class="flex flex-col space-y-space-xs mb-space-xl">
                    <div class="flex items-center gap-2 text-primary-container">
                        <span class="material-symbols-outlined text-[18px]"><?php echo esc_html($catalog_badge_icon); ?></span>
                        <span class="font-label-badge text-label-badge uppercase tracking-widest"><?php echo esc_html($catalog_badge_text); ?></span>
                    </div>
                    <h2 class="font-headline-xl text-headline-xl text-on-surface uppercase tracking-wide">
                        <?php echo esc_html($catalog_title); ?>
                    </h2>
                    <p class="font-body-md text-body-md text-on-surface-variant max-w-3xl leading-relaxed">
                        <?php echo nl2br(esc_html($catalog_desc)); ?>
                    </p>
                </div>

                <!-- Technical Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-space-lg">
                    <?php if ($has_services): ?>
                        <?php foreach ($services_items as $item): 
                            $srv = $item['post'];
                            $srv_id = $srv->ID;
                            $srv_title = get_the_title($srv_id);
                            $srv_permalink = get_permalink($srv_id);

                            // Icon: Category row icon takes precedence, then service's icon, then fallback 'memory'
                            $srv_icon = !empty($item['override_icon']) ? $item['override_icon'] : (get_field('service_card_icon', $srv_id) ?: 'memory');
                            $srv_badge = get_field('service_card_badge', $srv_id) ?: '15-25 MIN • TEST PE STAND';

                            // Description: Text field on service
                            $srv_desc = get_field('service_card_desc', $srv_id);
                            if (empty($srv_desc)) {
                                $srv_desc = get_the_excerpt($srv_id) ?: 'Oferim servicii de decodare optico-laser și programare transponder pe banc pentru orice cheie auto. Timp de execuție rapid (15 minute) folosind echipamente de precizie Silca și Keyline.';
                            }

                            // Bullet points: ACF Repeater on service
                            $bullets_repeater = get_field('service_card_bullets', $srv_id);
                            $srv_bullets = array();
                            if (!empty($bullets_repeater) && is_array($bullets_repeater)) {
                                foreach ($bullets_repeater as $b_row) {
                                    if (is_array($b_row) && !empty($b_row['bullet_text'])) {
                                        $srv_bullets[] = $b_row['bullet_text'];
                                    } elseif (is_string($b_row) && !empty(trim($b_row))) {
                                        $srv_bullets[] = trim($b_row);
                                    }
                                }
                            }
                            if (empty($srv_bullets)) {
                                $srv_bullets = array(
                                    'Generare cheie completă chiar și în caz de pierdere totală',
                                    'Sincronizare frecvență telecomandă închidere centralizată'
                                );
                            }

                            $srv_footer_note = get_field('service_card_footer_note', $srv_id) ?: 'Verificare instant atelier';
                            $srv_btn_text = get_field('service_card_btn_text', $srv_id) ?: 'Verifică Compatibilitate Cip';
                            $srv_btn_url = get_field('service_card_btn_url', $srv_id) ?: $srv_permalink;
                        ?>
                        <article class="group bg-surface-container hover:bg-surface-container-high rounded p-space-lg flex flex-col justify-between transition-all duration-200 shadow-md">
                            <div class="space-y-space-md">
                                <div class="flex items-start justify-between gap-space-sm">
                                    <div class="w-12 h-12 rounded bg-surface-container-highest flex items-center justify-center text-primary-container">
                                        <span class="material-symbols-outlined text-[28px]"><?php echo esc_html($srv_icon); ?></span>
                                    </div>
                                    <span class="px-space-xs py-1 bg-surface-container-highest text-primary font-label-badge text-label-badge rounded uppercase tracking-wider">
                                        <?php echo esc_html($srv_badge); ?>
                                    </span>
                                </div>
                                <div>
                                    <h3 class="font-headline-md text-headline-md text-on-surface group-hover:text-primary transition-colors uppercase mb-space-2xs">
                                        <?php echo esc_html($srv_title); ?>
                                    </h3>
                                    <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                                        <?php echo nl2br(esc_html($srv_desc)); ?>
                                    </p>
                                </div>
                                <?php if (!empty($srv_bullets)): ?>
                                <div class="p-space-xs bg-surface-container-low rounded space-y-1 text-body-sm font-body-sm text-outline">
                                    <?php foreach ($srv_bullets as $bullet): ?>
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[14px] text-primary">check_circle</span>
                                        <span><?php echo esc_html($bullet); ?></span>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="pt-space-md mt-space-md bg-surface-container-high p-space-xs rounded flex items-center justify-between">
                                <span class="font-label-action text-[12px] text-on-surface uppercase font-bold"><?php echo esc_html($srv_footer_note); ?></span>
                                <a class="inline-flex items-center gap-1 font-label-action text-label-action text-primary hover:text-primary-container uppercase tracking-wider transition-colors" href="<?php echo esc_url($srv_btn_url); ?>">
                                    <span><?php echo esc_html($srv_btn_text); ?></span>
                                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                </a>
                            </div>
                        </article>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Default 4 Technical Cards from chei_auto_moto.html -->
                        <!-- Card 1: Copiere cu Cip & Programare -->
                        <article class="group bg-surface-container hover:bg-surface-container-high rounded p-space-lg flex flex-col justify-between transition-all duration-200 shadow-md">
                            <div class="space-y-space-md">
                                <div class="flex items-start justify-between gap-space-sm">
                                    <div class="w-12 h-12 rounded bg-surface-container-highest flex items-center justify-center text-primary-container">
                                        <span class="material-symbols-outlined text-[28px]">memory</span>
                                    </div>
                                    <span class="px-space-xs py-1 bg-surface-container-highest text-primary font-label-badge text-label-badge rounded uppercase tracking-wider">
                                        15-25 MIN • TEST PE STAND
                                    </span>
                                </div>
                                <div>
                                    <h3 class="font-headline-md text-headline-md text-on-surface group-hover:text-primary transition-colors uppercase mb-space-2xs">
                                        Copiere cu Cip &amp; Programare
                                    </h3>
                                    <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                                        Chei auto speciale cu carcasă briceag sau Smart Keyless Go. Locaș cip transponder compatibil ID46, Megamos Crypto, Hitag Pro, PCF79xx și platforme MQB VAG. Procedură completă de programare electronică pe mufa OBD a mașinii, testare sincronizare imobilizator și pornire garantată.
                                    </p>
                                </div>
                                <div class="p-space-xs bg-surface-container-low rounded space-y-1 text-body-sm font-body-sm text-outline">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[14px] text-primary">check_circle</span>
                                        <span>Generare cheie completă chiar și în caz de pierdere totală</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[14px] text-primary">check_circle</span>
                                        <span>Sincronizare frecvență telecomandă închidere centralizată</span>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-space-md mt-space-md bg-surface-container-high p-space-xs rounded flex items-center justify-between">
                                <span class="font-label-action text-[12px] text-on-surface uppercase font-bold">Verificare instant atelier</span>
                                <a class="inline-flex items-center gap-1 font-label-action text-label-action text-primary hover:text-primary-container uppercase tracking-wider transition-colors" href="#solicita-evaluare">
                                    <span>Verifică Compatibilitate Cip</span>
                                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                </a>
                            </div>
                        </article>

                        <!-- Card 2: Chei Motociclete & Scutere -->
                        <article class="group bg-surface-container hover:bg-surface-container-high rounded p-space-lg flex flex-col justify-between transition-all duration-200 shadow-md">
                            <div class="space-y-space-md">
                                <div class="flex items-start justify-between gap-space-sm">
                                    <div class="w-12 h-12 rounded bg-surface-container-highest flex items-center justify-center text-primary-container">
                                        <span class="material-symbols-outlined text-[28px]">two_wheeler</span>
                                    </div>
                                    <span class="px-space-xs py-1 bg-surface-container-highest text-primary font-label-badge text-label-badge rounded uppercase tracking-wider">
                                        PE LOC • REZISTENȚĂ MAXIMĂ
                                    </span>
                                </div>
                                <div>
                                    <h3 class="font-headline-md text-headline-md text-on-surface group-hover:text-primary transition-colors uppercase mb-space-2xs">
                                        Chei Motociclete &amp; Scutere
                                    </h3>
                                    <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                                        Soluții dedicate pentru livratori urbani (Glovo, Tazz, Bolt Food, Bringo), scutere și motociclete touring / maxi-scutere. Suport Piaggio, Honda, Yamaha, Vespa, Kymco, BMW Motorrad. Decodare mecanică a lamelor uzate, strâmbe sau torsionate, chei speciale contact și bușon rezervor / topcase.
                                    </p>
                                </div>
                                <div class="p-space-xs bg-surface-container-low rounded space-y-1 text-body-sm font-body-sm text-outline">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[14px] text-primary">check_circle</span>
                                        <span>Copiere pe loc pentru curieri și livratori (sub 10 minute)</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[14px] text-primary">check_circle</span>
                                        <span>Lame ultra-rezistente din aliaj tratat antirotire</span>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-space-md mt-space-md bg-surface-container-high p-space-xs rounded flex items-center justify-between">
                                <span class="font-label-action text-[12px] text-on-surface uppercase font-bold">Asistență flote livrări</span>
                                <a class="inline-flex items-center gap-1 font-label-action text-label-action text-primary hover:text-primary-container uppercase tracking-wider transition-colors" href="#solicita-evaluare">
                                    <span>Detalii Chei Moto &amp; Scutere</span>
                                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                </a>
                            </div>
                        </article>

                        <!-- Card 3: Chei Auto Simple -->
                        <article class="group bg-surface-container hover:bg-surface-container-high rounded p-space-lg flex flex-col justify-between transition-all duration-200 shadow-md">
                            <div class="space-y-space-md">
                                <div class="flex items-start justify-between gap-space-sm">
                                    <div class="w-12 h-12 rounded bg-surface-container-highest flex items-center justify-center text-primary-container">
                                        <span class="material-symbols-outlined text-[28px]">vpn_key</span>
                                    </div>
                                    <span class="px-space-xs py-1 bg-surface-container-highest text-primary font-label-badge text-label-badge rounded uppercase tracking-wider">
                                        5 MIN • MATRIȚE ORIGINALE
                                    </span>
                                </div>
                                <div>
                                    <h3 class="font-headline-md text-headline-md text-on-surface group-hover:text-primary transition-colors uppercase mb-space-2xs">
                                        Chei Auto Simple
                                    </h3>
                                    <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                                        Copiere chei auto simple, exclusiv mecanică fără cip transponder electronic. Ideală ca cheie de rezervă pentru portbagaj, portiere sau acces mecanic de siguranță. Tăiere laser CNC pe cod bitting de fabrică, lamă frezată din aliaj siliciu-alamă rezistent la torsiune extremă.
                                    </p>
                                </div>
                                <div class="p-space-xs bg-surface-container-low rounded space-y-1 text-body-sm font-body-sm text-outline">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[14px] text-primary">check_circle</span>
                                        <span>Lame oarbe brute din stoc pentru peste 500 de profile auto</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[14px] text-primary">check_circle</span>
                                        <span>Fără risc de decodare falsă datorită calibrării optice laser</span>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-space-md mt-space-md bg-surface-container-high p-space-xs rounded flex items-center justify-between">
                                <span class="font-label-action text-[12px] text-on-surface uppercase font-bold">Tăiere mecanică CNC</span>
                                <a class="inline-flex items-center gap-1 font-label-action text-label-action text-primary hover:text-primary-container uppercase tracking-wider transition-colors" href="#solicita-evaluare">
                                    <span>Solicită Duplicare Mecanică</span>
                                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                </a>
                            </div>
                        </article>

                        <!-- Card 4: Virginizat Chei Auto -->
                        <article class="group bg-surface-container hover:bg-surface-container-high rounded p-space-lg flex flex-col justify-between transition-all duration-200 shadow-md">
                            <div class="space-y-space-md">
                                <div class="flex items-start justify-between gap-space-sm">
                                    <div class="w-12 h-12 rounded bg-surface-container-highest flex items-center justify-center text-primary-container">
                                        <span class="material-symbols-outlined text-[28px]">restart_alt</span>
                                    </div>
                                    <span class="px-space-xs py-1 bg-surface-container-highest text-primary font-label-badge text-label-badge rounded uppercase tracking-wider">
                                        LABORATOR ELECTRONIC
                                    </span>
                                </div>
                                <div>
                                    <h3 class="font-headline-md text-headline-md text-on-surface group-hover:text-primary transition-colors uppercase mb-space-2xs">
                                        Virginizat Chei Auto
                                    </h3>
                                    <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                                        Resetare și virginizare chei auto pentru reprogramare. Reabilitare electronică la nivel de componente, deblocare chei SH pentru refolosire, rescriere memorie EEPROM, reabilitare microcontacte și carcase de înaltă densitate, schimb acumulatori sudabili (BMW diamant, Ford, Land Rover).
                                    </p>
                                </div>
                                <div class="p-space-xs bg-surface-container-low rounded space-y-1 text-body-sm font-body-sm text-outline">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[14px] text-primary">check_circle</span>
                                        <span>Deblocare cipuri OEM blocate de imobilizatorul inițial</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[14px] text-primary">check_circle</span>
                                        <span>Micro-lipituri de precizie la microscop electronic</span>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-space-md mt-space-md bg-surface-container-high p-space-xs rounded flex items-center justify-between">
                                <span class="font-label-action text-[12px] text-on-surface uppercase font-bold">Refolosire chei second-hand</span>
                                <a class="inline-flex items-center gap-1 font-label-action text-label-action text-primary hover:text-primary-container uppercase tracking-wider transition-colors" href="#solicita-evaluare">
                                    <span>Programează Virginizare Cheie</span>
                                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                </a>
                            </div>
                        </article>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- 4. QUICK ASSESSMENT & DIAGNOSTIC FUNNEL    -->
        <!-- ========================================== -->
        <?php 
        include get_template_directory() . '/blocks/assessment/assessment.php'; 
        ?>

    </div>
</main>

<?php get_footer(); ?>

