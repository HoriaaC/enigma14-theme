<?php
/**
 * Global Footer Template for ENIGMA 14
 * Managed via ACF "Setari Site" (enigma14-settings) & WP Nav Menus
 */

// 1. Column 1: Despre Noi
$about_icon  = function_exists('get_field') ? get_field('footer_about_icon', 'option') : 'verified';
if (!$about_icon) $about_icon = 'verified';

$about_title = function_exists('get_field') ? get_field('footer_about_title', 'option') : 'Despre Noi';
if (!$about_title) $about_title = 'Despre Noi';

$about_text  = function_exists('get_field') ? get_field('footer_about_text', 'option') : '';
if (!$about_text) {
    $about_text = 'Atelier specializat de copiere chei de înaltă precizie, programare transpondere auto, cartele de interfon și mentenanță sisteme de securitate mecanică. Standarde industriale de calibrare micrometrică.';
}

$badge1 = function_exists('get_field') ? get_field('footer_badge1_text', 'option') : 'SERVICIU RAPID';
if (!$badge1) $badge1 = 'SERVICIU RAPID';

$badge2 = function_exists('get_field') ? get_field('footer_badge2_text', 'option') : 'CALITATE GARANTATĂ';
if (!$badge2) $badge2 = 'CALITATE GARANTATĂ';

// 2. Column 2: Contact & Atelier
$contact_icon  = function_exists('get_field') ? get_field('footer_contact_icon', 'option') : 'store';
if (!$contact_icon) $contact_icon = 'store';

$contact_title = function_exists('get_field') ? get_field('footer_contact_title', 'option') : 'Contact & Atelier';
if (!$contact_title) $contact_title = 'Contact & Atelier';

$address = function_exists('get_field') ? get_field('footer_address', 'option') : '';
if (!$address && function_exists('get_field')) {
    $address = get_field('address', 'option');
}
if (!$address) $address = 'Str. Atelierului 14 / Calea Victoriei 14, București';

$phone = function_exists('get_field') ? get_field('footer_phone', 'option') : '';
if (!$phone && function_exists('get_field')) {
    $phone = get_field('phone_1', 'option');
}
if (!$phone) $phone = '+40 720 000 014';

$schedule = function_exists('get_field') ? get_field('footer_schedule', 'option') : '';
if (!$schedule && function_exists('get_field')) {
    $weekdays = get_field('schedule_weekdays', 'option') ?: '08:30 - 19:30';
    $sat      = get_field('schedule_saturday', 'option') ?: '09:00 - 15:00';
    $schedule = "Luni - Vineri: {$weekdays} | Sâmbătă: {$sat}";
}
if (!$schedule) $schedule = 'Luni - Vineri: 08:30 - 19:30 | Sâmbătă: 09:00 - 15:00';

$emergency = function_exists('get_field') ? get_field('footer_emergency_text', 'option') : 'Urgențe Deblocări 24/7 Disponibil';
if (!$emergency) $emergency = 'Urgențe Deblocări 24/7 Disponibil';

// 3. Column 3: Categorii Servicii Meniu (Înlocuire CARPAT GUARD)
$cats_icon  = function_exists('get_field') ? get_field('footer_cats_icon', 'option') : 'category';
if (!$cats_icon) $cats_icon = 'category';

$cats_title = function_exists('get_field') ? get_field('footer_cats_title', 'option') : 'Categorii Servicii';
if (!$cats_title) $cats_title = 'Categorii Servicii';

$cats_note  = function_exists('get_field') ? get_field('footer_cats_note', 'option') : 'Sisteme agreate conform normelor europene de securitate fizică EN 1303.';

// 4. Subsol: Copyright & Legal
$copyright = function_exists('get_field') ? get_field('footer_copyright', 'option') : '';
if (!$copyright) {
    $copyright = '© {year} ENIGMA 14 CENTRUL DE COPIERE CHEI. Toate drepturile rezervate.';
}
$copyright_formatted = str_replace('{year}', date('Y'), $copyright);

$legal_links = function_exists('get_field') ? get_field('footer_legal_links', 'option') : array();
?>
<footer class="w-full bg-surface-container-lowest border-t border-surface-container-highest mt-space-3xl" style="font-family: var(--wp--preset--font-family--inter);">
    <div class="max-w-[1280px] mx-auto px-gutter-mobile lg:px-gutter-desktop py-space-2xl">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-space-xl pb-space-xl border-b border-surface-container-high">
            
            <!-- Col 1: Despre Noi -->
            <div class="flex flex-col gap-space-xs">
                <div class="flex items-center gap-space-xs mb-space-2xs">
                    <span class="material-symbols-outlined text-primary-container text-[20px]"><?php echo esc_html($about_icon); ?></span>
                    <span class="font-headline-sm text-headline-sm uppercase text-on-surface" style="font-family: var(--wp--preset--font-family--montserrat);"><?php echo esc_html($about_title); ?></span>
                </div>
                <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                    <?php echo nl2br(esc_html($about_text)); ?>
                </p>
                <?php if ($badge1 || $badge2): ?>
                <div class="flex flex-wrap items-center gap-space-xs mt-space-xs">
                    <?php if ($badge1): ?>
                    <span class="inline-flex items-center px-space-xs py-space-2xs rounded-lg border border-primary-container bg-surface-container-high font-label-badge text-label-badge text-primary uppercase">
                        <?php echo esc_html($badge1); ?>
                    </span>
                    <?php endif; ?>
                    <?php if ($badge2): ?>
                    <span class="inline-flex items-center px-space-xs py-space-2xs rounded-lg border border-surface-container-highest bg-surface-container-high font-label-badge text-label-badge text-on-surface-variant uppercase">
                        <?php echo esc_html($badge2); ?>
                    </span>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Col 2: Contact & Atelier -->
            <div class="flex flex-col gap-space-xs">
                <div class="flex items-center gap-space-xs mb-space-2xs">
                    <span class="material-symbols-outlined text-primary-container text-[20px]"><?php echo esc_html($contact_icon); ?></span>
                    <span class="font-headline-sm text-headline-sm uppercase text-on-surface" style="font-family: var(--wp--preset--font-family--montserrat);"><?php echo esc_html($contact_title); ?></span>
                </div>
                <?php if ($address): ?>
                <p class="font-body-md text-body-md text-on-surface-variant"><?php echo esc_html($address); ?></p>
                <?php endif; ?>
                <div class="flex flex-col gap-space-2xs mt-space-2xs font-body-md text-body-md text-on-surface-variant">
                    <?php if ($phone): ?>
                    <div class="flex items-center gap-space-xs">
                        <span class="material-symbols-outlined text-primary text-[18px]">call</span>
                        <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>" class="text-on-surface font-semibold hover:text-primary-container transition-colors"><?php echo esc_html($phone); ?></a>
                    </div>
                    <?php endif; ?>
                    <?php if ($schedule): ?>
                    <div class="flex items-center gap-space-xs">
                        <span class="material-symbols-outlined text-primary text-[18px]">schedule</span>
                        <span><?php echo esc_html($schedule); ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if ($emergency): ?>
                    <div class="flex items-center gap-space-xs">
                        <span class="material-symbols-outlined text-primary-container text-[18px]">lock_reset</span>
                        <span class="text-primary-container font-semibold"><?php echo esc_html($emergency); ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Col 3: Categorii Servicii Meniu (Înlocuire CARPAT GUARD) -->
            <div class="flex flex-col gap-space-xs">
                <div class="flex items-center gap-space-xs mb-space-2xs">
                    <span class="material-symbols-outlined text-primary-container text-[20px]"><?php echo esc_html($cats_icon); ?></span>
                    <span class="font-headline-sm text-headline-sm uppercase text-on-surface" style="font-family: var(--wp--preset--font-family--montserrat);"><?php echo esc_html($cats_title); ?></span>
                </div>
                
                <!-- Navigation menu editable from Appearance -> Menus -->
                <nav aria-label="Meniu Categorii Footer" class="mt-space-2xs">
                    <?php 
                    if (has_nav_menu('footer_categories')) {
                        wp_nav_menu(array(
                            'theme_location' => 'footer_categories',
                            'container'      => false,
                            'menu_class'     => 'flex flex-col gap-2 font-body-md text-body-md text-on-surface-variant',
                            'fallback_cb'    => false,
                            'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                            'walker'         => new Enigma_Footer_Nav_Walker(),
                        ));
                    } else {
                        // Automatic fallback from taxonomy 'categorie_serviciu'
                        $terms = get_terms(array(
                            'taxonomy'   => 'categorie_serviciu',
                            'hide_empty' => false,
                            'number'     => 6,
                        ));
                        if (!empty($terms) && !is_wp_error($terms)) {
                            echo '<ul class="flex flex-col gap-2 font-body-md text-body-md text-on-surface-variant">';
                            foreach ($terms as $term) {
                                echo '<li><a class="hover:text-primary-container transition-colors inline-flex items-center gap-1.5 group" href="' . esc_url(get_term_link($term)) . '"><span class="w-1.5 h-1.5 rounded-full bg-primary-container/60 group-hover:bg-primary-container transition-colors"></span><span>' . esc_html($term->name) . '</span></a></li>';
                            }
                            echo '</ul>';
                        }
                    }
                    ?>
                </nav>

                <?php if ($cats_note): ?>
                <div class="mt-space-md pt-space-xs border-t border-surface-container-high/60">
                    <span class="font-body-sm text-body-sm text-on-surface-variant/80 block leading-normal"><?php echo esc_html($cats_note); ?></span>
                </div>
                <?php endif; ?>
            </div>

        </div>

        <!-- Subsol: Copyright & Legal Links -->
        <div class="pt-space-md flex flex-col md:flex-row items-center justify-between gap-space-md">
            <span class="font-body-sm text-body-sm text-on-surface-variant text-center md:text-left">
                <?php echo esc_html($copyright_formatted); ?>
            </span>
            
            <div class="flex flex-wrap items-center justify-center gap-space-lg">
                <?php 
                if (!empty($legal_links) && is_array($legal_links)) {
                    foreach ($legal_links as $link) {
                        $l_title = '';
                        $l_url   = '';

                        // Check if selected via page dropdown (post_object)
                        if (!empty($link['legal_page'])) {
                            $page_item = $link['legal_page'];
                            $page_id   = is_object($page_item) ? $page_item->ID : (int) $page_item;
                            if ($page_id) {
                                $l_url   = get_permalink($page_id);
                                $l_title = !empty($link['custom_title']) ? $link['custom_title'] : get_the_title($page_id);
                            }
                        } elseif (!empty($link['link_title'])) {
                            // Fallback for manual link_title / link_url
                            $l_title = $link['link_title'];
                            $l_url   = isset($link['link_url']) ? $link['link_url'] : '#';
                        }

                        if ($l_title && $l_url) {
                            echo '<a class="font-body-sm text-body-sm text-on-surface-variant hover:text-on-surface transition-colors" href="' . esc_url($l_url) . '">' . esc_html($l_title) . '</a>';
                        }
                    }
                } else {
                ?>
                    <a class="font-body-sm text-body-sm text-on-surface-variant hover:text-on-surface transition-colors" href="#termeni-si-conditii">Termeni și Condiții</a>
                    <a class="font-body-sm text-body-sm text-on-surface-variant hover:text-on-surface transition-colors" href="#politica-de-confidentialitate">Politica de Confidențialitate</a>
                    <a class="font-body-sm text-body-sm text-on-surface-variant hover:text-on-surface transition-colors" href="#autorizatii-tehnice">Autorizații Tehnice</a>
                <?php } ?>
            </div>
        </div>
    </div>
</footer>
