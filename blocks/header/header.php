<?php
/**
 * Header Block Template.
 * 
 * @param   array $block The block settings and attributes.
 */

// Pull global options from ACF Site Settings
$phone_1 = function_exists('get_field') ? get_field('phone_1', 'option') : '0722 000 114';
if (!$phone_1) $phone_1 = '0722 000 114';

$schedule_weekdays = function_exists('get_field') ? get_field('schedule_weekdays', 'option') : '08:30 - 19:30';
if (!$schedule_weekdays) $schedule_weekdays = '08:30 - 19:30';

$schedule_saturday = function_exists('get_field') ? get_field('schedule_saturday', 'option') : '09:00 - 15:00';
if (!$schedule_saturday) $schedule_saturday = '09:00 - 15:00';

$site_logo = function_exists('get_field') ? get_field('site_logo', 'option') : null; 
$logo_url = $site_logo ? $site_logo['url'] : '';

$header_branding_display = function_exists('get_field') ? get_field('header_branding_display', 'option') : 'logo';
if (empty($header_branding_display)) {
    $header_branding_display = 'logo';
}

// Header Top Bar CTA Button Options
$header_cta_enable = function_exists('get_field') ? get_field('header_cta_enable', 'option') : true;
if ($header_cta_enable === null) $header_cta_enable = true;

$header_cta_action = function_exists('get_field') ? get_field('header_cta_action', 'option') : 'popup';
if (empty($header_cta_action)) $header_cta_action = 'popup';

$header_cta_text = function_exists('get_field') ? get_field('header_cta_text', 'option') : 'PROGRAMARE ACUM';
if (empty($header_cta_text)) $header_cta_text = 'PROGRAMARE ACUM';

$header_cta_icon = function_exists('get_field') ? get_field('header_cta_icon', 'option') : 'calendar_month';
if (empty($header_cta_icon)) $header_cta_icon = 'calendar_month';

$header_cta_custom_url = function_exists('get_field') ? get_field('header_cta_custom_url', 'option') : '#solicita-oferta';
if (empty($header_cta_custom_url)) $header_cta_custom_url = '#solicita-oferta';

// WhatsApp number fallback
$whatsapp_num = function_exists('get_field') ? (get_field('whatsapp_number', 'option') ?: $phone_1) : $phone_1;
$whatsapp_clean = preg_replace('/[^0-9]/', '', $whatsapp_num ?: '40722000114');
if (strlen($whatsapp_clean) === 10 && substr($whatsapp_clean, 0, 2) === '07') {
    $whatsapp_clean = '4' . $whatsapp_clean;
}

// Compute href, target, and class for CTA
$cta_href = '#';
$cta_target = '';
$cta_class = 'inline-flex items-center gap-1.5 bg-primary-container hover:bg-secondary-container text-on-primary-container font-bold text-[11px] px-space-sm py-1 rounded uppercase tracking-wider transition-all duration-200 shadow-[0_0_16px_rgba(255,119,0,0.4)] cursor-pointer';

if ($header_cta_action === 'popup') {
    $cta_href = 'javascript:void(0);';
    $cta_class .= ' enigma-open-booking-modal';
} elseif ($header_cta_action === 'phone') {
    $cta_href = 'tel:' . preg_replace('/[^0-9]/', '', $phone_1);
} elseif ($header_cta_action === 'whatsapp') {
    $cta_href = 'https://wa.me/' . $whatsapp_clean . '?text=' . rawurlencode('Buna ziua, doresc o programare / evaluare la atelierul ENIGMA 14');
    $cta_target = ' target="_blank" rel="noopener noreferrer"';
} elseif ($header_cta_action === 'custom_link') {
    $cta_href = esc_url($header_cta_custom_url);
}

?>
<header class="fixed top-0 left-0 right-0 w-full z-50 bg-surface-container-lowest/95 backdrop-blur-md shadow-[0_4px_24px_rgba(0,0,0,0.6)] border-b border-surface-container-highest" style="font-family: var(--wp--preset--font-family--inter);">
    <!-- Top Status Bar -->
    <div class="w-full bg-surface-container-lowest border-b border-surface-container-high/90 text-on-surface-variant text-[12px]">
        <div class="max-w-[1280px] mx-auto px-space-md lg:px-space-xl py-space-2xs flex items-center justify-between gap-space-sm">
            
            <!-- Live Status & Schedule -->
            <div class="flex items-center gap-space-sm flex-wrap">
                <div class="scheduleHeader flex items-center gap-2" data-weekdays="<?php echo esc_attr($schedule_weekdays); ?>" data-saturday="<?php echo esc_attr($schedule_saturday); ?>">
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#10b981] opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-[#10b981] shadow-[0_0_10px_#10b981]"></span>
                    </span>
                    <span class="font-bold text-[11px] uppercase tracking-wider text-white" style="font-family: var(--wp--preset--font-family--montserrat);">DESCHIS ACUM - Atelier Mecatronic Sector 1</span>
                </div>
                <span class="hidden md:inline-block text-outline font-bold">|</span>
                <span class="hidden md:inline-flex items-center gap-1.5 text-on-surface-variant text-[12px]">
                    <span class="material-symbols-outlined text-[16px] text-primary-container inline-flex items-center justify-center w-4 h-4 shrink-0">schedule</span>
                    <span>Luni - Vineri: <?php echo esc_html($schedule_weekdays); ?> &nbsp;|&nbsp; Sâmbăta: <?php echo esc_html($schedule_saturday); ?></span>
                </span>
            </div>
            
            <!-- Top Bar Button -->
            <?php if ($header_cta_enable): ?>
            <div class="flex items-center gap-space-sm shrink-0">
                <a class="<?php echo esc_attr($cta_class); ?>" href="<?php echo $cta_href; ?>"<?php echo $cta_target; ?> style="font-family: var(--wp--preset--font-family--montserrat);">
                    <span class="material-symbols-outlined text-[16px] inline-flex items-center justify-center w-4 h-4 shrink-0"><?php echo esc_html($header_cta_icon); ?></span>
                    <span><?php echo esc_html($header_cta_text); ?></span>
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Main Navbar -->
    <div class="min-h-[110px] h-[110px] max-w-[1280px] mx-auto px-space-md lg:px-space-xl flex items-center justify-between gap-2 lg:gap-space-sm flex-nowrap">
        
        <!-- Logo Area -->
        <div class="flex items-center gap-space-xs shrink-0 py-1">
            <a class="flex items-center gap-space-xs group" href="<?php echo esc_url(home_url('/')); ?>">
                <?php if ($header_branding_display === 'text' || (!$logo_url && $header_branding_display === 'logo')): ?>
                    <?php if (!$logo_url && $header_branding_display === 'logo'): ?>
                        <div class="h-10 w-10 bg-primary-container rounded flex items-center justify-center text-on-primary-container font-bold text-xl shrink-0">E</div>
                    <?php endif; ?>
                    <div class="flex flex-col">
                        <span class="font-bold text-[18px] md:text-[20px] uppercase tracking-wider text-on-surface flex items-center gap-0.5" style="font-family: var(--wp--preset--font-family--montserrat);">
                            EN<span class="text-primary-container">I</span>GMA <span class="text-primary-container ml-0.5">14</span>
                        </span>
                        <span class="text-[10px] md:text-[11px] uppercase tracking-[0.16em] text-on-surface-variant font-bold" style="font-family: var(--wp--preset--font-family--montserrat);">CENTRUL DE COPIERE CHEI</span>
                    </div>
                <?php else: ?>
                    <img alt="<?php echo esc_attr(get_bloginfo('name') ?: 'ENIGMA 14 logo'); ?>" width="104" height="95" fetchpriority="high" loading="eager" decoding="async" class="h-[95px] max-h-[95px] w-auto object-contain transition-transform duration-200 group-hover:scale-[1.02]" src="<?php echo esc_url($logo_url); ?>" style="height: 95px; width: auto; aspect-ratio: 1600/1461;">
                <?php endif; ?>
            </a>
        </div>
        
        <!-- Navigation Menu -->
        <nav class="hidden lg:flex items-center gap-2 xl:gap-4 h-full shrink-0 flex-nowrap whitespace-nowrap">
            <?php 
            $primary_menu = has_nav_menu('primary') ? 'primary' : '';
            if (!$primary_menu) {
                $all_menus = wp_get_nav_menus();
                if (!empty($all_menus)) {
                    foreach ($all_menus as $m) {
                        if ($m->slug === 'main-menu' || stripos($m->name, 'main') !== false || stripos($m->name, 'header') !== false) {
                            $primary_menu = $m->term_id;
                            break;
                        }
                    }
                    if (!$primary_menu && !empty($all_menus[0])) {
                        $primary_menu = $all_menus[0]->term_id;
                    }
                }
            }

            if ($primary_menu) {
                $nav_args = array(
                    'container'   => false,
                    'menu_class'  => 'flex items-center gap-2 xl:gap-4 h-full',
                    'fallback_cb' => false,
                    'items_wrap'  => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    'walker'      => new Enigma_Tailwind_Nav_Walker()
                );
                if (is_numeric($primary_menu)) {
                    $nav_args['menu'] = $primary_menu;
                } else {
                    $nav_args['theme_location'] = 'primary';
                }
                wp_nav_menu($nav_args); 
            } else {
                // Fallback exact design if no menu created yet
            ?>
                <a class="h-full flex items-center px-space-2xs uppercase tracking-wider transition-colors duration-150 text-primary-container font-bold border-b-2 border-primary-container text-[12px] whitespace-nowrap shrink-0" href="/">ACASĂ</a>
                <a class="h-full flex items-center px-space-2xs text-on-surface-variant hover:text-on-surface text-[12px] font-semibold uppercase tracking-wider transition-colors duration-150 whitespace-nowrap shrink-0" href="/servicii/">CHEI AUTO &amp; MOTO</a>
                <a class="h-full flex items-center px-space-2xs text-on-surface-variant hover:text-on-surface text-[12px] font-semibold uppercase tracking-wider transition-colors duration-150 whitespace-nowrap shrink-0" href="/servicii/">CHEI REZIDENȚIALE &amp; LACĂTE</a>
                <a class="h-full flex items-center px-space-2xs text-on-surface-variant hover:text-on-surface text-[12px] font-semibold uppercase tracking-wider transition-colors duration-150 whitespace-nowrap shrink-0" href="/servicii/">TELECOMENZI &amp; INTERFOANE</a>
                <a class="h-full flex items-center px-space-2xs text-on-surface-variant hover:text-on-surface text-[12px] font-semibold uppercase tracking-wider transition-colors duration-150 whitespace-nowrap shrink-0" href="/servicii/">REPARAȚII &amp; URGENȚE</a>
                <a class="h-full flex items-center px-space-2xs text-on-surface-variant hover:text-on-surface text-[12px] font-semibold uppercase tracking-wider transition-colors duration-150 whitespace-nowrap shrink-0" href="#contact">CONTACT</a>
            <?php } ?>
        </nav>
        
        <!-- Mobile Menu Toggle Button -->
        <div class="lg:hidden flex items-center">
            <button type="button" id="enigma-mobile-menu-toggle" class="p-2 -mr-2 text-on-surface hover:text-primary-container transition-colors rounded-lg focus:outline-none cursor-pointer" aria-label="Deschide meniul" aria-expanded="false">
                <span id="enigma-mobile-menu-icon" class="material-symbols-outlined text-[30px]">menu</span>
            </button>
        </div>
        
    </div>

    <!-- Mobile Menu Drawer / Dropdown Panel -->
    <div id="enigma-mobile-menu" class="lg:hidden hidden border-t border-surface-container-highest bg-surface-container-lowest/98 backdrop-blur-xl shadow-2xl transition-all duration-300 max-h-[calc(100dvh-110px)] max-h-[calc(100vh-110px)] overflow-y-auto overscroll-contain">
        <div class="max-w-[1280px] mx-auto px-space-md py-space-md flex flex-col gap-space-md">
            
            <!-- Mobile Navigation Links -->
            <nav class="flex flex-col gap-1" style="font-family: var(--wp--preset--font-family--montserrat);">
                <?php 
                if ($primary_menu) {
                    $mob_args = array(
                        'container'   => false,
                        'menu_class'  => 'flex flex-col gap-1 w-full',
                        'fallback_cb' => false,
                        'items_wrap'  => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                        'walker'      => new Enigma_Tailwind_Mobile_Nav_Walker()
                    );
                    if (is_numeric($primary_menu)) {
                        $mob_args['menu'] = $primary_menu;
                    } else {
                        $mob_args['theme_location'] = 'primary';
                    }
                    wp_nav_menu($mob_args); 
                } else {
                    // Fallback exact design if no menu created yet
                ?>
                    <a class="flex items-center justify-between py-2.5 px-3 rounded-lg uppercase tracking-wider text-[13px] font-bold text-primary-container bg-surface-container-high border-l-2 border-primary-container" href="<?php echo esc_url(home_url('/')); ?>">
                        <span>ACASĂ</span>
                        <span class="material-symbols-outlined text-[18px]">home</span>
                    </a>
                    <a class="flex items-center justify-between py-2.5 px-3 rounded-lg uppercase tracking-wider text-[13px] font-bold text-on-surface hover:text-primary-container hover:bg-surface-container" href="/servicii/">
                        <span>CHEI AUTO &amp; MOTO</span>
                        <span class="material-symbols-outlined text-[18px] text-outline">directions_car</span>
                    </a>
                    <a class="flex items-center justify-between py-2.5 px-3 rounded-lg uppercase tracking-wider text-[13px] font-bold text-on-surface hover:text-primary-container hover:bg-surface-container" href="/servicii/">
                        <span>CHEI REZIDENȚIALE &amp; LACĂTE</span>
                        <span class="material-symbols-outlined text-[18px] text-outline">vpn_key</span>
                    </a>
                    <a class="flex items-center justify-between py-2.5 px-3 rounded-lg uppercase tracking-wider text-[13px] font-bold text-on-surface hover:text-primary-container hover:bg-surface-container" href="/servicii/">
                        <span>TELECOMENZI &amp; INTERFOANE</span>
                        <span class="material-symbols-outlined text-[18px] text-outline">settings_remote</span>
                    </a>
                    <a class="flex items-center justify-between py-2.5 px-3 rounded-lg uppercase tracking-wider text-[13px] font-bold text-on-surface hover:text-primary-container hover:bg-surface-container" href="/servicii/">
                        <span>REPARAȚII &amp; URGENȚE</span>
                        <span class="material-symbols-outlined text-[18px] text-outline">handyman</span>
                    </a>
                    <a class="flex items-center justify-between py-2.5 px-3 rounded-lg uppercase tracking-wider text-[13px] font-bold text-on-surface hover:text-primary-container hover:bg-surface-container" href="#contact">
                        <span>CONTACT</span>
                        <span class="material-symbols-outlined text-[18px] text-outline">pin_drop</span>
                    </a>
                <?php } ?>
            </nav>

            <!-- Quick Action Buttons for Mobile -->
            <div class="pt-space-xs border-t border-surface-container-highest/60 flex flex-col gap-2">
                
                <!-- CTA Button -->
                <?php if ($header_cta_enable): ?>
                <a class="w-full justify-center <?php echo esc_attr($cta_class); ?> py-2.5 text-[12px]" href="<?php echo $cta_href; ?>"<?php echo $cta_target; ?> style="font-family: var(--wp--preset--font-family--montserrat);">
                    <span class="material-symbols-outlined text-[18px]"><?php echo esc_html($header_cta_icon); ?></span>
                    <span><?php echo esc_html($header_cta_text); ?></span>
                </a>
                <?php endif; ?>

                <div class="grid grid-cols-2 gap-2 pt-1">
                    <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone_1)); ?>" class="inline-flex items-center justify-center gap-1.5 py-2 px-3 rounded bg-surface-container-high hover:bg-surface-container-highest text-on-surface text-[11px] font-bold uppercase tracking-wider transition-colors">
                        <span class="material-symbols-outlined text-primary-container text-[16px]">call</span>
                        <span>APELEAZĂ</span>
                    </a>
                    <a href="https://wa.me/<?php echo esc_attr($whatsapp_clean); ?>" target="_blank" rel="noopener noreferrer" class="enigma-wa-btn inline-flex items-center justify-center gap-1.5 py-2 px-3 rounded bg-[#25D366] hover:bg-[#20ba59] text-[#072410] hover:text-black text-[11px] font-extrabold uppercase tracking-wider transition-colors">
                        <span class="material-symbols-outlined text-[16px]">chat</span>
                        <span>WHATSAPP</span>
                    </a>
                </div>

                <!-- Schedule Note -->
                <div class="pt-2 text-center text-on-surface-variant text-[11px]">
                    <span class="flex items-center justify-center gap-1 text-outline">
                        <span class="material-symbols-outlined text-[14px] text-primary-container">schedule</span>
                        <span>Lun - Vin: <?php echo esc_html($schedule_weekdays); ?> | Sâm: <?php echo esc_html($schedule_saturday); ?></span>
                    </span>
                </div>
            </div>

        </div>
    </div>
</header>

