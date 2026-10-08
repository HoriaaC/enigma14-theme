<?php
/**
 * Hero Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Load values and assign defaults.
$top_status     = get_field('hero_badge') ?: 'ATELIER MECATRONIC ACTIV • CNC SILCA & KEYLINE ONLINE';
$top_location   = get_field('hero_location') ?: 'BUCUREȘTI SECTOR 1';
$top_time       = get_field('hero_time') ?: 'EXECUȚIE MEDIE 8 MIN';

$badge          = get_field('hero_pre_title') ?: 'CENTRUL TEHNIC SPECIALIZAT DE DUPLICARE ȘI DECODARE';
$title_1        = get_field('hero_title_1') ?: 'Servicii Complete';
$title_2        = get_field('hero_title_2') ?: 'de Copiere Chei';
$description    = get_field('hero_desc') ?: (get_field('hero_subtitle') ?: 'Precizie și calitate garantată prin mecatronică de înaltă finețe, decodare optico-laser computerizată și programare transponder pe banc.');
$bg_image       = get_field('hero_bg_image') ?: (get_field('hero_bg_desktop') ?: 'https://lh3.googleusercontent.com/aida-public/AB6AXuBFFy1PJxzQo-0awYNLMGqeeGNVYWOXxvMcvUE3xhn_ylgeiXZZ3hbksn8CJx1fch_WYiU6kgc8Kpbi9M-VEAepkb4aQFuTlagQlf0SkDuHLGYGt-hY2g1wd4b8NXCp5YsxHwiBJBltjzRhAfZgzwe5LFT4b04QhOiQZ6SIdx4c0wo9mhDuVa3d2G2OOhVl0nMde30FR1Wa1xZcloPWZR442fiDmtCNlXz7qMq3nuSJs3MXdZNuNztF');

// 3 Box Features
$box1_icon      = get_field('hero_box1_icon') ?: 'straighten';
$box1_title     = get_field('hero_box1_title') ?: 'Toleranță CNC';
$box1_sub       = get_field('hero_box1_subtitle') ?: '±0.02 mm Precizie';

$box2_icon      = get_field('hero_box2_icon') ?: 'bolt';
$box2_title     = get_field('hero_box2_title') ?: 'Execuție Rapidă';
$box2_sub       = get_field('hero_box2_subtitle') ?: '5 – 15 min pe loc';

$box3_icon      = get_field('hero_box3_icon') ?: 'inventory_2';
$box3_title     = get_field('hero_box3_title') ?: 'Depozit Matrițe';
$box3_sub       = get_field('hero_box3_subtitle') ?: '5.000+ Blank-uri';

// Buttons
$btn1_arr       = get_field('hero_button_primary');
$btn_1_text     = !empty($btn1_arr['title']) ? $btn1_arr['title'] : (get_field('hero_btn_1_text') ?: 'CERE O OFERTĂ ACUM');
$btn_1_link     = !empty($btn1_arr['url']) ? $btn1_arr['url'] : (get_field('hero_btn_1_link') ?: '#solicita-oferta');

$phone_btn_suffix = get_field('hero_phone_btn_suffix') ?: 'SUPORT TEHNIC';

// Bottom Metrology & Partners
$equipment      = get_field('hero_equipment') ?: 'Echipamente: Silca Futura Edge, Keyline Gymkana 994, Tango Transponder Programmer';
$partners_label = get_field('hero_partners_label') ?: 'PARTENERI HARDWARE:';
$partners_text  = get_field('hero_partners_text') ?: 'SILCA • KEYLINE • JMA • ERREBI';

// Pull global phone from options (if ACF options exists)
$phone_1 = function_exists('get_field') ? get_field('phone_1', 'option') : '0722 000 114';
if (!$phone_1) $phone_1 = '0722 000 114';

// Create a clean phone link (strip spaces)
$phone_clean = str_replace(' ', '', $phone_1);

?>

<section class="relative w-full overflow-hidden bg-surface-container-lowest">
    <!-- Atmospheric Ambient Overlays -->
    <div class="absolute inset-0 bg-gradient-to-r from-surface-container-lowest via-surface-container-lowest/90 to-transparent z-10"></div>
    <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-primary-container/10 blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 right-0 w-[500px] h-[500px] rounded-full bg-secondary-container/5 blur-3xl pointer-events-none"></div>
    
    <!-- Workshop Master Photography Background (Discoverable LCP Image with fetchpriority=high) -->
    <img src="<?php echo esc_url($bg_image); ?>" 
         alt="<?php echo esc_attr($title_1 . ' ' . $title_2); ?>" 
         fetchpriority="high" 
         loading="eager" 
         decoding="async" 
         class="absolute inset-0 w-full h-full object-cover object-center opacity-40 z-0 pointer-events-none select-none">
    
    <div class="relative z-20 max-w-[1280px] mx-auto px-gutter-desktop py-space-3xl flex flex-col justify-between min-h-[620px]">
        
        <!-- Top Technical Status Line -->
        <div class="flex flex-wrap items-center justify-between gap-space-sm pb-space-lg">
            <div class="flex items-center gap-space-xs bg-surface-container-high/90 px-space-sm py-space-2xs rounded backdrop-blur-md">
                <span class="inline-block w-2.5 h-2.5 rounded-full bg-primary-container shadow-[0_0_10px_#ff7700] animate-pulse"></span>
                <span class="font-label-badge text-[11px] font-bold uppercase tracking-[0.12em] text-on-surface"><?php echo esc_html($top_status); ?></span>
            </div>
            <div class="hidden lg:flex items-center gap-space-md text-[12px] text-on-surface-variant">
                <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-primary-container text-[18px]">verified</span> <?php echo esc_html($top_location); ?></span>
                <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-primary-container text-[18px]">timer</span> <?php echo esc_html($top_time); ?></span>
            </div>
        </div>
        
        <!-- Center Headline Block -->
        <div class="max-w-3xl space-y-space-md my-auto">
            
            <div class="inline-flex items-center gap-2 px-space-xs py-space-2xs rounded bg-surface-container text-primary font-bold text-[11px] uppercase tracking-wider">
                <span class="material-symbols-outlined text-[16px] text-primary-container">lock_reset</span>
                <?php echo esc_html($badge); ?>
            </div>
            
            <h1 class="text-[48px] md:text-[56px] font-extrabold uppercase text-on-surface tracking-tight leading-none" style="font-family: var(--wp--preset--font-family--montserrat);">
                <?php echo esc_html($title_1); ?> <br>
                <span class="text-primary-container enigma-glow-primary"><?php echo esc_html($title_2); ?></span>
            </h1>
            
            <p class="text-[16px] text-on-surface-variant leading-relaxed max-w-2xl" style="font-family: var(--wp--preset--font-family--inter);">
                <?php echo esc_html($description); ?>
            </p>
            
            <!-- Hardware Badges Group -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-space-xs pt-space-xs">
                <div class="flex items-center gap-space-xs p-space-xs rounded bg-surface-container/80 backdrop-blur-sm">
                    <span class="material-symbols-outlined text-primary-container text-[22px] shrink-0"><?php echo esc_html($box1_icon); ?></span>
                    <div>
                        <p class="text-[11px] font-bold uppercase text-on-surface tracking-wider"><?php echo esc_html($box1_title); ?></p>
                        <p class="text-[12px] text-secondary-container font-semibold"><?php echo esc_html($box1_sub); ?></p>
                    </div>
                </div>
                <div class="flex items-center gap-space-xs p-space-xs rounded bg-surface-container/80 backdrop-blur-sm">
                    <span class="material-symbols-outlined text-primary-container text-[22px] shrink-0"><?php echo esc_html($box2_icon); ?></span>
                    <div>
                        <p class="text-[11px] font-bold uppercase text-on-surface tracking-wider"><?php echo esc_html($box2_title); ?></p>
                        <p class="text-[12px] text-secondary-container font-semibold"><?php echo esc_html($box2_sub); ?></p>
                    </div>
                </div>
                <div class="flex items-center gap-space-xs p-space-xs rounded bg-surface-container/80 backdrop-blur-sm">
                    <span class="material-symbols-outlined text-primary-container text-[22px] shrink-0"><?php echo esc_html($box3_icon); ?></span>
                    <div>
                        <p class="text-[11px] font-bold uppercase text-on-surface tracking-wider"><?php echo esc_html($box3_title); ?></p>
                        <p class="text-[12px] text-secondary-container font-semibold"><?php echo esc_html($box3_sub); ?></p>
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-space-sm pt-space-sm">
                <a class="inline-flex items-center justify-center gap-space-xs bg-primary-container hover:bg-secondary-container text-on-primary-container font-bold text-[13px] px-8 py-3 rounded uppercase tracking-wider transition-all duration-200 enigma-glow-primary" href="<?php echo esc_url($btn_1_link); ?>">
                    <span><?php echo esc_html($btn_1_text); ?></span>
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </a>
                <a class="inline-flex items-center justify-center gap-space-xs bg-surface-container-high hover:bg-surface-bright text-on-surface font-bold text-[13px] px-6 py-3 rounded uppercase tracking-wider transition-all duration-200 shadow-md" href="tel:<?php echo esc_attr($phone_clean); ?>">
                    <span class="material-symbols-outlined text-primary-container text-[20px]">phone_in_talk</span>
                    <span><?php echo esc_html($phone_1); ?> – <?php echo esc_html($phone_btn_suffix); ?></span>
                </a>
            </div>
        </div>
        
        <!-- Subtle Key Metrology Line -->
        <div class="pt-space-xl flex flex-wrap items-center justify-between gap-space-md text-on-surface-variant text-[12px]">
            <div class="flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-primary-container"></span>
                <span><?php echo esc_html($equipment); ?></span>
            </div>
            <?php if ($partners_text): ?>
            <div class="hidden sm:flex items-center gap-2 text-on-surface-variant/80">
                <span class="text-primary font-bold text-[10px] uppercase tracking-wider"><?php echo esc_html($partners_label); ?></span>
                <span class="font-medium text-[11px] tracking-wide"><?php echo esc_html($partners_text); ?></span>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
