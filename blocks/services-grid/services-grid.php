<?php
/**
 * Block: Divizii Mecatronice & Servicii Grid (ENIGMA 14)
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param (int|string) $post_id The post ID this block is saved to.
 */

// Section Header fields
$section_badge = get_field('section_badge') ?: 'DIVIZII MECATRONICE';
$section_title = get_field('section_title') ?: 'Alege un Serviciu';
$section_desc  = get_field('section_desc') ?: 'Catalog tehnic de multiplicare, decodare computerizată CNC și asistență de urgență disponibil în atelierul nostru din București.';
$section_note  = get_field('section_note') ?: 'Toate operațiunile se realizează cu verificare electronică a profilului.';

// Cards
$division_cards = get_field('division_cards');

// If no cards were added manually in block settings, auto-populate from categories taxonomy
if (empty($division_cards)) {
    $terms = get_terms(array(
        'taxonomy'   => 'categorie_serviciu',
        'hide_empty' => false,
        'number'     => 4,
    ));

    if (!empty($terms) && !is_wp_error($terms)) {
        $division_cards = array();
        foreach ($terms as $t) {
            $division_cards[] = array(
                'category_term'      => $t,
                'custom_title'       => '',
                'custom_desc'        => '',
                'custom_icon'        => '',
                'custom_time_badge'  => '',
                'custom_price_from'  => '',
                'selected_services'  => '',
                'button_text'        => 'Vezi detalii & compatibilitate',
                'button_url'         => ''
            );
        }
    }
}

// Bottom Showcase Strip
$showcase_image   = get_field('showcase_image') ?: 'https://lh3.googleusercontent.com/aida-public/AB6AXuDDiobZAUdIpP-RTBmJ-Bddy4CL_5t8roFn4b2pVj8jUJfo1Yk-V5-0UC3m_hqnpr02g11VRL9198u7AAYGUTyOs7Iho98_j9VQ5OYP1Gbc-x_4e_cxBFmWcShIKgE3yy0SskNE7yv4yocM1Sa1OOocv6c0R6SrXdCINuui92WlynOlbkUO7qrx_EGJ8kNSTBC-6b9Lw31IxLC7nhtalP5wcwmtJDbXaGCeGEN9TZcW0BodiYvk9dx7';
$showcase_title   = get_field('showcase_title') ?: 'Compatibilitate cu Peste 98% din Modelele Rulate în România';
$showcase_desc    = get_field('showcase_desc') ?: 'Dacia, Volkswagen Group, BMW, Mercedes-Benz, Renault, Ford, Toyota, Hyundai, Kia și utilitare.';
$showcase_badge_1 = get_field('showcase_badge_1') ?: 'GARANȚIE SCRISĂ 24 LUNI';
$showcase_badge_2 = get_field('showcase_badge_2') ?: 'TESTABILĂ PE LOC';
?>

<section class="w-full bg-surface py-space-3xl relative">
    <div class="max-w-[1280px] mx-auto px-gutter-desktop space-y-space-2xl">
        
        <!-- Section Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-space-md">
            <div class="space-y-space-2xs">
                <?php if ($section_badge): ?>
                <div class="flex items-center gap-space-2xs text-primary-container font-label-badge text-label-badge uppercase tracking-widest">
                    <span class="material-symbols-outlined text-[16px]">grid_view</span>
                    <?php echo esc_html($section_badge); ?>
                </div>
                <?php endif; ?>

                <?php if ($section_title): ?>
                <h2 class="font-headline-xl text-headline-xl uppercase font-bold text-on-surface tracking-tight">
                    <?php echo esc_html($section_title); ?>
                </h2>
                <?php endif; ?>

                <?php if ($section_desc): ?>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-2xl">
                    <?php echo nl2br(esc_html($section_desc)); ?>
                </p>
                <?php endif; ?>
            </div>

            <?php if ($section_note): ?>
            <div class="shrink-0 flex items-center gap-2 text-on-surface-variant font-body-sm text-body-sm">
                <span class="w-2 h-2 rounded-full bg-secondary-container"></span>
                <span><?php echo esc_html($section_note); ?></span>
            </div>
            <?php endif; ?>
        </div>

        <!-- 4-Card Master Grid -->
        <?php if (!empty($division_cards)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-space-md">
            <?php 
            foreach ($division_cards as $card): 
                $term = $card['category_term'];
                $term_id = 0;
                $term_obj = null;

                if (is_object($term)) {
                    $term_obj = $term;
                    $term_id = $term->term_id;
                } elseif (is_numeric($term)) {
                    $term_id = (int) $term;
                    $term_obj = get_term($term_id, 'categorie_serviciu');
                }

                // Title
                $card_title = !empty($card['custom_title']) ? $card['custom_title'] : ($term_obj ? $term_obj->name : 'Divizie Servicii');

                // Description
                $card_desc = !empty($card['custom_desc']) ? $card['custom_desc'] : ($term_obj && !empty($term_obj->description) ? $term_obj->description : 'Servicii complete de înaltă precizie mecatronică și electronică.');

                // Icon
                $card_icon = !empty($card['custom_icon']) ? $card['custom_icon'] : '';
                if (empty($card_icon) && $term_id) {
                    $card_icon = get_field('category_icon', 'categorie_serviciu_' . $term_id);
                }
                if (empty($card_icon)) {
                    $card_icon = 'directions_car';
                }

                // Time Badge
                $card_badge = !empty($card['custom_time_badge']) ? $card['custom_time_badge'] : '';
                if (empty($card_badge) && $term_id) {
                    $card_badge = get_field('category_time_badge', 'categorie_serviciu_' . $term_id);
                }
                if (empty($card_badge)) {
                    $card_badge = '10-20 min';
                }

                // Price "De la"
                $card_price = !empty($card['custom_price_from']) ? $card['custom_price_from'] : '';
                if (empty($card_price) && $term_id) {
                    $card_price = get_field('category_price_from', 'categorie_serviciu_' . $term_id);
                }

                // Button URL
                $btn_url = !empty($card['button_url']) ? $card['button_url'] : ($term_obj ? get_term_link($term_obj) : '#');
                $btn_text = !empty($card['button_text']) ? $card['button_text'] : 'Vezi detalii & compatibilitate';

                // Selected Services
                $services = !empty($card['selected_services']) ? $card['selected_services'] : array();
                if (empty($services) && $term_id) {
                    $services = get_posts(array(
                        'post_type'      => 'serviciu',
                        'posts_per_page' => 4,
                        'tax_query'      => array(
                            array(
                                'taxonomy' => 'categorie_serviciu',
                                'field'    => 'term_id',
                                'terms'    => $term_id,
                            ),
                        ),
                    ));
                }
            ?>
            <div class="group flex flex-col justify-between p-space-lg rounded-xl bg-surface-container-low hover:bg-surface-container transition-all duration-300 shadow-md hover:shadow-[0_8px_30px_rgba(255,119,0,0.15)] relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-primary-container to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                
                <div class="space-y-space-md">
                    <!-- Card Top: Icon, Price, Time Badge -->
                    <div class="flex items-center justify-between gap-2">
                        <div class="w-12 h-12 rounded-full bg-surface-container-high flex items-center justify-center text-primary-container group-hover:scale-110 transition-transform shrink-0">
                            <span class="material-symbols-outlined text-[26px]"><?php echo esc_html($card_icon); ?></span>
                        </div>
                        <div class="flex items-center gap-1.5 flex-wrap justify-end">
                            <?php if (!empty($card_price)): ?>
                            <span class="px-space-xs py-space-2xs rounded bg-surface-container text-primary-container font-label-badge text-[11px] font-bold uppercase tracking-wider">
                                <?php echo esc_html($card_price); ?>
                            </span>
                            <?php endif; ?>
                            <?php if (!empty($card_badge)): ?>
                            <span class="px-space-xs py-space-2xs rounded bg-surface-container-highest text-secondary-container font-label-badge text-label-badge uppercase">
                                <?php echo esc_html($card_badge); ?>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Title & Description -->
                    <div class="space-y-space-2xs">
                        <h3 class="font-headline-sm text-headline-sm uppercase text-on-surface group-hover:text-primary transition-colors">
                            <a href="<?php echo esc_url($btn_url); ?>">
                                <?php echo esc_html($card_title); ?>
                            </a>
                        </h3>
                        <?php if ($card_desc): ?>
                        <p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-3">
                            <?php echo esc_html($card_desc); ?>
                        </p>
                        <?php endif; ?>
                    </div>

                    <!-- Services Checkmark List -->
                    <?php if (!empty($services)): ?>
                    <ul class="space-y-space-xs pt-space-xs font-body-sm text-body-sm text-on-surface">
                        <?php 
                        foreach ($services as $srv): 
                            $srv_id    = is_object($srv) ? $srv->ID : (int) $srv;
                            $srv_title = get_the_title($srv_id);
                            $srv_link  = get_permalink($srv_id);
                        ?>
                        <li class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary-container text-[16px] shrink-0">check_circle</span>
                            <a href="<?php echo esc_url($srv_link); ?>" class="hover:text-primary transition-colors line-clamp-1">
                                <?php echo esc_html($srv_title); ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </div>

                <!-- Card Bottom Action Link -->
                <div class="pt-space-lg mt-space-md bg-surface-container/50 -mx-space-lg -mb-space-lg px-space-lg pb-space-lg">
                    <a class="inline-flex items-center justify-between w-full font-label-action text-label-action text-primary-container group-hover:text-secondary-container uppercase tracking-wider transition-colors" href="<?php echo esc_url($btn_url); ?>">
                        <span><?php echo esc_html($btn_text); ?></span>
                        <span class="material-symbols-outlined text-[18px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Workshop Keys Showcase Strip -->
        <?php if ($showcase_title || $showcase_image): ?>
        <div class="p-space-md rounded-xl bg-surface-container-lowest flex flex-col lg:flex-row items-center justify-between gap-space-md border border-surface-container-highest/40">
            <div class="flex items-center gap-space-md">
                <?php if ($showcase_image): ?>
                <div class="w-20 h-14 rounded bg-cover bg-center shrink-0 border border-surface-container-highest" style="background-image: url('<?php echo esc_url($showcase_image); ?>')"></div>
                <?php endif; ?>
                <div>
                    <?php if ($showcase_title): ?>
                    <p class="font-headline-sm text-headline-sm text-on-surface"><?php echo esc_html($showcase_title); ?></p>
                    <?php endif; ?>
                    <?php if ($showcase_desc): ?>
                    <p class="font-body-sm text-body-sm text-on-surface-variant"><?php echo esc_html($showcase_desc); ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="flex items-center gap-space-sm shrink-0">
                <?php if ($showcase_badge_1): ?>
                <span class="font-label-badge text-label-badge uppercase tracking-wider text-outline"><?php echo esc_html($showcase_badge_1); ?></span>
                <?php endif; ?>
                <?php if ($showcase_badge_2): ?>
                <span class="px-space-xs py-space-2xs rounded bg-surface-container-high text-primary-container font-label-badge text-label-badge"><?php echo esc_html($showcase_badge_2); ?></span>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

    </div>
</section>
