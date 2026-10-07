<?php
/**
 * Template Name: Contact - ENIGMA 14
 * Description: Șablon de pagină dedicat pentru Contact & Localizare Atelier Mecatronic.
 *
 * @package Enigma14
 */

$post_id = get_the_ID();

// Helper to resolve ACF image fields (array, ID, or URL)
if (!function_exists('enigma_contact_img_url')) {
    function enigma_contact_img_url($img, $fallback = '') {
        if (is_array($img) && !empty($img['url'])) {
            return $img['url'];
        }
        if (is_numeric($img)) {
            $url = wp_get_attachment_url($img);
            if ($url) return $url;
        }
        if (is_string($img) && !empty(trim($img))) {
            return $img;
        }
        return $fallback;
    }
}

// Global Site Options (Fallback)
$opt_phone_1    = function_exists('get_field') ? get_field('phone_1', 'option') : '0722 000 114';
$opt_phone_2    = function_exists('get_field') ? get_field('phone_2', 'option') : '021 9988';
$opt_email      = function_exists('get_field') ? get_field('email', 'option') : 'contact@enigma14.ro';
$opt_address    = function_exists('get_field') ? get_field('address', 'option') : 'Calea Victoriei 14 / Str. Atelierului 14';
$opt_weekdays   = function_exists('get_field') ? get_field('schedule_weekdays', 'option') : '08:30 - 19:30';
$opt_saturday   = function_exists('get_field') ? get_field('schedule_saturday', 'option') : '09:00 - 15:00';
$opt_whatsapp   = function_exists('get_field') ? (get_field('whatsapp_number', 'option') ?: $opt_phone_1) : $opt_phone_1;

$clean_phone_1  = preg_replace('/[^0-9]/', '', $opt_phone_1 ?: '0722000114');
$clean_phone_2  = preg_replace('/[^0-9]/', '', $opt_phone_2 ?: '0219988');
$clean_wa       = preg_replace('/[^0-9]/', '', $opt_whatsapp ?: '40722000114');
if (strlen($clean_wa) === 10 && substr($clean_wa, 0, 2) === '07') {
    $clean_wa = '4' . $clean_wa;
}

// 1. Hero & Breadcrumb Ribbon
$live_badge   = get_field('contact_live_badge', $post_id) ?: 'Punct Fizic Atelier București Sector 1 • Deschise Comenzile Rapide';
$hero_badge   = get_field('contact_hero_badge', $post_id) ?: 'Consolă Diagnostic & Recepție Tehnică';
$hero_title   = get_field('contact_hero_title', $post_id) ?: 'CONTACT & LOCALIZARE ATELIER';
$hero_desc    = get_field('contact_hero_desc', $post_id) ?: 'Vino direct la centrul nostru tehnic din Sectorul 1 sau trimite-ne o fotografie a cheii tale pentru confirmare pe loc, identificare de profil CNC și estimare de tarif în câteva minute.';

// 2. Atelier Info & Facade
$address_hint   = get_field('contact_address_hint', $post_id) ?: 'Sector 1, București • Reper: Zonă centrală, acces direct din bulevard cu parcare dedicată clienților.';
$sunday_note    = get_field('contact_sunday_note', $post_id) ?: 'Urgențe Deblocări Non-Stop';
$facade_caption = get_field('contact_facade_caption', $post_id) ?: 'Căutați caseta luminoasă portocalie ENIGMA 14 la intrare.';
$facade_img_raw = get_field('contact_facade_image', $post_id);
$facade_fallback = 'https://lh3.googleusercontent.com/aida-public/AB6AXuAdY2FcDehMub4ixVNZnzXwfJ_hd0nH2_rhVcKZEZpErgwAdDrY9WcarCqfPl6ih_9f6n9lTbB5srTre-iFGzy79BnKcUZsm2R8XQYvXf2G9gvDRI3TdmbdWN8leXh-EwsRV-9PcgSzPHb_0TG6C2CKhUrEbL69QTAayHl14eFtor7MbwMECk8-GjhKWzHJKO8UgtfCeKxwm7XLk5L2ygYCPN19YkUUh1xC4d6AGxI';
$facade_img     = enigma_contact_img_url($facade_img_raw, $facade_fallback);

// 3. Form Config & Service Options
$form_badge     = get_field('contact_form_badge', $post_id) ?: 'Răspuns Tehnic Garantat < 5 Minute';
$form_title     = get_field('contact_form_title', $post_id) ?: 'CERE O OFERTĂ SAU TRIMITE FOTOGRAFIA CHEII';
$form_desc      = get_field('contact_form_desc', $post_id) ?: 'Fotografiază ambele fețe ale cheii sau carcasei și îți răspundem prompt cu disponibilitatea profilului brut, compatibilitatea cipului și tariful exact.';
$services_raw   = get_field('contact_form_services', $post_id);

if (!empty(trim((string)$services_raw))) {
    $service_options = array_filter(array_map('trim', explode("\n", (string)$services_raw)));
} else {
    $service_options = array(
        'Chei Auto & Moto (Duplicare, Cip Transponder, Carcasă)',
        'Chei Rezidențiale / Amprentă / Yale de Înaltă Siguranță',
        'Cartele Interfon & Telecomenzi Porți / Garaj',
        'Reparații Butuci Uși, Carcase Sparte sau Urgențe Deblocări',
        'Înlocuire Baterie Cheie Auto & Testare Frecvență RF'
    );
}

// 4. Map & GPS
$map_title      = get_field('contact_map_title', $post_id) ?: 'HARTA INTERACTIVĂ & GHID TRASEU GPS';
$map_desc       = get_field('contact_map_desc', $post_id) ?: 'Punct central în Sectorul 1, conectat rapid prin marile artere rutiere și la doar 4 minute de mers pe jos de la stațiile principale.';
$gmaps_url      = get_field('contact_google_maps_url', $post_id) ?: 'https://maps.google.com/?q=Calea+Victoriei+14+Bucuresti';
$waze_url       = get_field('contact_waze_url', $post_id) ?: 'https://waze.com/ul?q=Calea+Victoriei+14+Bucuresti';
$map_embed      = get_field('contact_map_embed', $post_id);
$map_img_raw    = get_field('contact_map_image', $post_id);
$map_img_fallback = 'https://lh3.googleusercontent.com/aida-public/AB6AXuDEf6PI0L6aL-SuBto_WI87kQpXtRLxaGn7OPG_NgUNsOQms46_SzlQGSGoVOSOk99aKbYzp1vRZOBXdcn-bQO23aFdlZnvUr_OnxbZrM-Q6a5_Y_YGLphpIWWRhA_BlYdiDtEsW5k9y69KUzYPODxHv0K_yt-MquPPD5sRS71LYCE-cNGsH72ivelrkEiVGtazYOiZBibvkEbLzXYoUu3CuvESwz6ftYaCM8zFnFE';
$map_img        = enigma_contact_img_url($map_img_raw, $map_img_fallback);
$hud_title      = get_field('contact_hud_title', $post_id) ?: 'ENIGMA 14 SECTOR 1';
$hud_coords     = get_field('contact_hud_coords', $post_id) ?: 'Coordonate: 44.4323° N, 26.0969° E';

// 5. Emergency 24/7 Callout
$em_badge       = get_field('contact_em_badge', $post_id) ?: 'SERVICIU DEBLOCĂRI NON-STOP 24/7';
$em_title       = get_field('contact_em_title', $post_id) ?: 'AI RĂMAS BLOCAT AFARĂ SAU AI PIERDUT SINGURA CHEIE?';
$em_desc        = get_field('contact_em_desc', $post_id) ?: 'Echipa mobilă ENIGMA 14 intervine prompt în Sectorul 1 și împrejurimi pentru deschideri nedistructive de uși rezidențiale sau deblocare mașină cu generare cip pe loc.';
$em_phone       = get_field('contact_em_phone', $post_id) ?: $opt_phone_1;
$em_note        = get_field('contact_em_note', $post_id) ?: 'Disponibil 24/7 • Sosire medie în 20-30 minute';
$clean_em_phone = preg_replace('/[^0-9]/', '', $em_phone ?: '0722000114');

$current_page_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
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

<!-- Original Theme FSE Header Part -->
<?php echo do_blocks('<!-- wp:template-part {"slug":"header"} /-->'); ?>

<main class="w-full bg-surface min-h-[calc(100vh-80px)] pt-28">
    <div class="flex flex-col w-full text-on-surface">

        <!-- ========================================== -->
        <!-- 1. BREADCRUMB & LIVE STATUS RIBBON         -->
        <!-- ========================================== -->
        <section class="w-full bg-surface-container-lowest border-b border-surface-container-highest/30">
            <div class="max-w-[1280px] mx-auto px-gutter-mobile lg:px-gutter-desktop py-space-sm flex flex-col sm:flex-row sm:items-center justify-between gap-space-sm">
                <nav aria-label="Breadcrumb" class="flex items-center gap-space-xs text-body-sm font-body-sm text-outline flex-wrap">
                    <a class="hover:text-primary transition-colors flex items-center gap-1" href="<?php echo esc_url(home_url('/')); ?>">
                        <span class="material-symbols-outlined text-[16px]">home</span>
                        <span>Acasă</span>
                    </a>
                    <span class="text-surface-container-highest">/</span>
                    <span class="text-primary font-semibold">Contact &amp; Localizare</span>
                </nav>

                <?php if ($live_badge): ?>
                <div class="inline-flex items-center gap-space-xs px-space-sm py-1 bg-surface-container-high rounded self-start sm:self-auto shadow-sm">
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-secondary-container opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-secondary-container"></span>
                    </span>
                    <span class="font-label-badge text-label-badge uppercase text-secondary font-bold tracking-wider">
                        <?php echo esc_html($live_badge); ?>
                    </span>
                </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- 2. EDITORIAL PAGE HEADER                   -->
        <!-- ========================================== -->
        <section class="w-full bg-surface-container-low border-b border-surface-container-highest/30">
            <div class="max-w-[1280px] mx-auto px-gutter-mobile lg:px-gutter-desktop py-space-xl lg:py-space-2xl">
                <div class="max-w-4xl space-y-space-xs">
                    <div class="flex items-center gap-space-xs">
                        <span class="h-0.5 w-8 bg-primary-container"></span>
                        <span class="font-label-badge text-label-badge uppercase tracking-[0.18em] text-primary font-bold">
                            <?php echo esc_html($hero_badge); ?>
                        </span>
                    </div>
                    <h1 class="font-headline-xl text-headline-xl uppercase text-on-surface font-extrabold tracking-wide">
                        <?php 
                        // Style the word "ATELIER" with brand accent if present in title
                        if (stripos($hero_title, 'ATELIER') !== false) {
                            echo wp_kses_post(preg_replace('/ATELIER/i', '<span class="text-primary-container">ATELIER</span>', esc_html($hero_title)));
                        } else {
                            echo esc_html($hero_title);
                        }
                        ?>
                    </h1>
                    <p class="font-body-lg text-body-lg text-on-surface-variant max-w-3xl leading-relaxed pt-space-2xs">
                        <?php echo nl2br(esc_html($hero_desc)); ?>
                    </p>
                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- 3. MAIN DUAL PANEL: DATE CONTACT & FORM    -->
        <!-- ========================================== -->
        <section class="w-full bg-surface">
            <div class="max-w-[1280px] mx-auto px-gutter-mobile lg:px-gutter-desktop py-space-xl lg:py-space-2xl">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg lg:gap-space-xl items-start">
                    
                    <!-- COLUMN 1: Info Centru Tehnic & Vitrină (5 cols) -->
                    <div class="lg:col-span-5 flex flex-col space-y-space-lg">
                        
                        <!-- Card Info Locație & Date -->
                        <div class="bg-surface-container-low p-space-lg rounded shadow-sm space-y-space-lg border border-surface-container-highest/40">
                            
                            <!-- Adresă -->
                            <div class="space-y-space-2xs">
                                <div class="flex items-center gap-space-xs text-primary-container">
                                    <span class="material-symbols-outlined text-[22px]">location_on</span>
                                    <span class="font-label-badge text-label-badge uppercase tracking-wider text-on-surface font-bold">Adresă Fizică Atelier</span>
                                </div>
                                <p class="text-on-surface font-headline-sm text-headline-sm font-semibold pl-7">
                                    <?php echo esc_html($opt_address); ?>
                                </p>
                                <p class="text-on-surface-variant font-body-md text-body-md pl-7">
                                    <?php echo esc_html($address_hint); ?>
                                </p>
                            </div>

                            <!-- Telefoane & WhatsApp -->
                            <div class="space-y-space-xs bg-surface-container p-space-md rounded border border-surface-container-highest/50">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-space-xs text-primary-container">
                                        <span class="material-symbols-outlined text-[20px]">headset_mic</span>
                                        <span class="font-label-badge text-label-badge uppercase tracking-wider text-on-surface font-bold">Linii Tehnice Directe</span>
                                    </div>
                                    <span class="font-label-badge text-label-badge text-secondary font-bold uppercase tracking-wider">Foto WhatsApp Activ</span>
                                </div>

                                <div class="space-y-space-2xs pt-space-2xs">
                                    <a class="flex items-center justify-between p-space-xs rounded bg-surface-container-high hover:bg-surface-container-highest transition-colors group" href="tel:<?php echo esc_attr($clean_phone_1); ?>">
                                        <span class="font-headline-sm text-headline-sm text-on-surface font-bold tracking-wide group-hover:text-primary transition-colors">
                                            <?php echo esc_html($opt_phone_1); ?>
                                        </span>
                                        <span class="font-label-action text-label-action text-primary-container uppercase flex items-center gap-1 font-bold">
                                            <span>APEL DIRECT</span>
                                            <span class="material-symbols-outlined text-[16px]">phone_forwarded</span>
                                        </span>
                                    </a>

                                    <?php if ($opt_phone_2): ?>
                                    <a class="flex items-center justify-between p-space-xs rounded bg-surface-container-high hover:bg-surface-container-highest transition-colors group" href="tel:<?php echo esc_attr($clean_phone_2); ?>">
                                        <span class="font-headline-sm text-headline-sm text-on-surface font-bold tracking-wide group-hover:text-primary transition-colors">
                                            <?php echo esc_html($opt_phone_2); ?>
                                        </span>
                                        <span class="font-label-action text-label-action text-on-surface-variant uppercase flex items-center gap-1 font-bold">
                                            <span>DISPECERAT</span>
                                            <span class="material-symbols-outlined text-[16px]">call</span>
                                        </span>
                                    </a>
                                    <?php endif; ?>
                                </div>

                                <div class="pt-space-2xs flex items-center gap-space-xs text-body-sm font-body-sm text-on-surface-variant">
                                    <span class="material-symbols-outlined text-[18px] text-outline">mail</span>
                                    <a href="mailto:<?php echo esc_attr($opt_email); ?>" class="hover:text-primary transition-colors"><?php echo esc_html($opt_email); ?></a>
                                </div>
                            </div>

                            <!-- Program de Lucru -->
                            <div class="space-y-space-xs">
                                <div class="flex items-center gap-space-xs text-primary-container">
                                    <span class="material-symbols-outlined text-[22px]">calendar_clock</span>
                                    <span class="font-label-badge text-label-badge uppercase tracking-wider text-on-surface font-bold">Program de Lucru &amp; Intervenții</span>
                                </div>
                                <div class="space-y-1.5 pl-7 text-body-md font-body-md">
                                    <div class="flex items-center justify-between py-1 bg-surface-container px-space-xs rounded">
                                        <span class="text-on-surface font-medium">Luni - Vineri</span>
                                        <span class="text-on-surface font-bold tracking-wide"><?php echo esc_html($opt_weekdays); ?></span>
                                    </div>
                                    <div class="flex items-center justify-between py-1 bg-surface-container px-space-xs rounded">
                                        <span class="text-on-surface font-medium">Sâmbătă</span>
                                        <span class="text-on-surface font-bold tracking-wide"><?php echo esc_html($opt_saturday); ?></span>
                                    </div>
                                    <div class="flex items-center justify-between py-1 bg-on-tertiary-fixed-variant px-space-xs rounded text-tertiary-fixed">
                                        <span class="font-semibold flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[16px]">fmd_bad</span> Duminică
                                        </span>
                                        <span class="font-bold tracking-wider uppercase text-[12px]"><?php echo esc_html($sunday_note); ?></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Repere Accesibilitate & Facilități -->
                            <div class="bg-surface-container p-space-md rounded space-y-space-xs border border-surface-container-highest/40">
                                <span class="font-label-badge text-label-badge uppercase tracking-wider text-outline font-bold">Facilități &amp; Acces Atelier</span>
                                <div class="grid grid-cols-2 gap-space-xs text-body-sm font-body-sm">
                                    <div class="flex items-center gap-1.5 text-on-surface">
                                        <span class="material-symbols-outlined text-[18px] text-primary">directions_subway</span>
                                        <span>Metrou la 4 min</span>
                                    </div>
                                    <div class="flex items-center gap-1.5 text-on-surface">
                                        <span class="material-symbols-outlined text-[18px] text-primary">local_parking</span>
                                        <span>Parcare clienți</span>
                                    </div>
                                    <div class="flex items-center gap-1.5 text-on-surface">
                                        <span class="material-symbols-outlined text-[18px] text-primary">accessible</span>
                                        <span>Rampă acces facil</span>
                                    </div>
                                    <div class="flex items-center gap-1.5 text-on-surface">
                                        <span class="material-symbols-outlined text-[18px] text-primary">credit_card</span>
                                        <span>Plată Card / POS</span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Showcase Fațadă Atelier Dark Mode -->
                        <div class="bg-surface-container-low p-space-md rounded shadow-sm space-y-space-xs border border-surface-container-highest/40">
                            <div class="flex items-center justify-between">
                                <span class="font-label-badge text-label-badge uppercase text-primary font-bold tracking-wider">Identificare Vizuală Fațadă</span>
                                <span class="font-body-sm text-body-sm text-outline">Vitrina Sector 1</span>
                            </div>
                            <div class="overflow-hidden rounded relative group">
                                <img class="w-full h-52 object-cover transition-transform duration-500 group-hover:scale-105" src="<?php echo esc_url($facade_img); ?>" alt="Fațadă Atelier ENIGMA 14 Sector 1" />
                                <div class="absolute inset-0 bg-gradient-to-t from-surface-container-lowest via-surface-container-lowest/30 to-transparent flex items-end p-space-sm">
                                    <p class="font-body-sm text-body-sm text-on-surface font-medium"><?php echo esc_html($facade_caption); ?></p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- COLUMN 2: Formular Rapid & Upload Cheie (7 cols) -->
                    <div class="lg:col-span-7 flex flex-col space-y-space-md">
                        <div class="bg-surface-container-low p-space-lg lg:p-space-xl rounded shadow-md border border-surface-container-highest/40" id="solicita-oferta">
                            
                            <div class="space-y-space-2xs pb-space-md">
                                <div class="inline-flex items-center gap-space-2xs px-space-xs py-1 rounded bg-surface-container-high text-primary font-label-badge text-label-badge uppercase font-bold tracking-wider">
                                    <span class="material-symbols-outlined text-[16px]">bolt</span>
                                    <span><?php echo esc_html($form_badge); ?></span>
                                </div>
                                <h2 class="font-headline-md text-headline-md text-on-surface uppercase font-bold tracking-wide">
                                    <?php echo esc_html($form_title); ?>
                                </h2>
                                <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                                    <?php echo nl2br(esc_html($form_desc)); ?>
                                </p>
                            </div>

                            <!-- Interactive Diagnostic & Contact Form -->
                            <form id="enigma-contact-page-form" class="space-y-space-md" enctype="multipart/form-data">
                                <?php wp_nonce_field('enigma14_contact_action', 'contact_nonce'); ?>
                                <input type="hidden" name="page_url" value="<?php echo esc_url($current_page_url); ?>">
                                <input type="hidden" name="uploaded_photo_url" id="uploaded-photo-url" value="">

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md">
                                    <!-- Nume -->
                                    <div class="space-y-1">
                                        <label class="font-label-action text-label-action uppercase text-on-surface font-semibold tracking-wide" for="contact-name">
                                            Nume &amp; Prenume *
                                        </label>
                                        <div class="relative">
                                            <input class="w-full bg-surface-container-lowest text-on-surface placeholder:text-outline font-body-md text-body-md px-space-sm py-2.5 rounded border border-surface-container-highest/60 focus:border-primary-container focus:outline-none focus:bg-surface-container transition-colors" id="contact-name" name="contact_name" placeholder="ex: Andrei Popescu" required type="text" />
                                        </div>
                                    </div>

                                    <!-- Telefon -->
                                    <div class="space-y-1">
                                        <label class="font-label-action text-label-action uppercase text-on-surface font-semibold tracking-wide" for="contact-phone">
                                            Număr Telefon (Mobil) *
                                        </label>
                                        <div class="relative">
                                            <input class="w-full bg-surface-container-lowest text-on-surface placeholder:text-outline font-body-md text-body-md px-space-sm py-2.5 rounded border border-surface-container-highest/60 focus:border-primary-container focus:outline-none focus:bg-surface-container transition-colors" id="contact-phone" name="contact_phone" placeholder="ex: 07xx xxx xxx" required type="tel" />
                                        </div>
                                    </div>
                                </div>

                                <!-- Tip Serviciu -->
                                <div class="space-y-1">
                                    <label class="font-label-action text-label-action uppercase text-on-surface font-semibold tracking-wide" for="service-type">
                                        Tip Serviciu Mecatronic / Solicitat *
                                    </label>
                                    <div class="relative">
                                        <select class="w-full bg-surface-container-lowest text-on-surface font-body-md text-body-md px-space-sm py-2.5 rounded border border-surface-container-highest/60 focus:border-primary-container focus:outline-none focus:bg-surface-container appearance-none cursor-pointer pr-10 transition-colors" id="service-type" name="service_type">
                                            <?php foreach ($service_options as $opt_text): ?>
                                                <option value="<?php echo esc_attr($opt_text); ?>"><?php echo esc_html($opt_text); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span class="material-symbols-outlined text-outline pointer-events-none absolute right-3 top-2.5 text-[20px]">
                                            arrow_drop_down
                                        </span>
                                    </div>
                                </div>

                                <!-- Drag & Drop Container Cheie -->
                                <div class="space-y-1">
                                    <label class="font-label-action text-label-action uppercase text-on-surface font-semibold tracking-wide flex items-center justify-between">
                                        <span>Încarcă Poza Cheii Tale</span>
                                        <span class="text-primary text-[11px] font-bold tracking-wider">OPȚIONAL DAR RECOMANDAT</span>
                                    </label>
                                    
                                    <div class="bg-surface-container-lowest border-2 border-dashed border-surface-container-highest hover:border-primary-container/70 p-space-lg rounded flex flex-col items-center justify-center text-center cursor-pointer transition-all group relative overflow-hidden" id="drop-zone">
                                        <input accept="image/*" class="hidden" id="key-upload-input" name="key_photo" type="file" />
                                        
                                        <div class="w-12 h-12 rounded-full bg-surface-container flex items-center justify-center text-primary-container group-hover:bg-primary-container group-hover:text-on-primary-container transition-colors mb-space-2xs shadow-inner">
                                            <span class="material-symbols-outlined text-[28px]">photo_camera</span>
                                        </div>
                                        <p class="text-on-surface font-headline-sm text-headline-sm font-semibold">
                                            Încarcă poza cheii pentru identificare exactă
                                        </p>
                                        <p class="text-on-surface-variant font-body-sm text-body-sm max-w-sm mt-1">
                                            Trage fișierul aici sau apasă pentru a deschide camera telefonului / galeria. Formate: JPG, PNG, WEBP, HEIC (max. 10MB).
                                        </p>
                                        
                                        <div class="mt-space-xs font-label-badge text-label-badge text-secondary font-bold" id="upload-status"></div>
                                    </div>
                                </div>

                                <!-- Mesaj Detalii -->
                                <div class="space-y-1">
                                    <label class="font-label-action text-label-action uppercase text-on-surface font-semibold tracking-wide" for="contact-notes">
                                        Detalii Suplimentare (Model mașină / An fabricație / Marcă cilindru)
                                    </label>
                                    <textarea class="w-full bg-surface-container-lowest text-on-surface placeholder:text-outline font-body-md text-body-md p-space-sm rounded border border-surface-container-highest/60 focus:border-primary-container focus:outline-none focus:bg-surface-container transition-colors" id="contact-notes" name="contact_notes" placeholder="ex: Cheie tip briceag pentru Skoda Octavia 2018 sau cheie Mottura cu amprentă..." rows="3"></textarea>
                                </div>

                                <!-- Indicator Garanție Mecatronică -->
                                <div class="flex items-center gap-space-xs bg-surface-container p-space-xs rounded text-body-sm font-body-sm text-on-surface-variant border border-surface-container-highest/40">
                                    <span class="material-symbols-outlined text-primary text-[20px] shrink-0">verified_user</span>
                                    <span>Datele și fotografiile tale sunt folosite exclusiv pentru calculul ofertei tehnice și confirmarea comenzii.</span>
                                </div>

                                <!-- Action Buttons (Submit + Instant WhatsApp) -->
                                <div class="pt-space-xs space-y-space-xs">
                                    <button class="w-full bg-primary-container hover:bg-secondary-container text-on-primary-container font-label-action text-label-action uppercase font-bold py-space-sm px-space-md rounded transition-all shadow-md flex items-center justify-center gap-space-xs tracking-wider" type="submit">
                                        <span class="material-symbols-outlined text-[20px]">send</span>
                                        <span>TRIMITE SOLICITAREA ACUM</span>
                                    </button>

                                    <!-- Quick WhatsApp Direct Action Link -->
                                    <a class="w-full py-2.5 px-space-md rounded bg-[#25D366]/15 hover:bg-[#25D366]/25 border border-[#25D366]/40 text-[#25D366] font-label-action text-label-action uppercase tracking-wider font-bold transition-all flex items-center justify-center gap-2 group" href="https://wa.me/<?php echo esc_attr($clean_wa); ?>?text=<?php echo rawurlencode('Buna ziua, doresc o evaluare rapida de cheie la atelierul ENIGMA 14'); ?>" target="_blank" rel="noopener noreferrer">
                                        <span class="material-symbols-outlined text-[18px]">chat</span>
                                        <span>SAU TRIMITE PE WHATSAPP CU UN CLIC</span>
                                    </a>
                                </div>

                                <!-- Error Feedback Container -->
                                <div class="hidden p-space-sm rounded bg-error-container text-on-error-container text-body-md font-body-md flex items-center gap-space-xs" id="form-feedback-error"></div>
                            </form>

                            <!-- Mesaj Feedback Succes -->
                            <div class="hidden p-space-md sm:p-space-lg rounded bg-surface-container-high border border-primary-container text-center space-y-space-sm mt-space-md" id="form-feedback">
                                <div class="w-12 h-12 mx-auto rounded-full bg-primary-container/20 flex items-center justify-center text-primary-container shadow-[0_0_20px_rgba(255,119,0,0.3)]">
                                    <span class="material-symbols-outlined text-[32px]">check_circle</span>
                                </div>
                                <h3 class="font-headline-sm uppercase text-on-surface font-bold text-[18px] tracking-wide">
                                    Solicitarea a fost recepționată!
                                </h3>
                                <p class="font-body-md text-on-surface-variant max-w-md mx-auto leading-relaxed">
                                    Un tehnician ENIGMA 14 analizează profilul cheii și te va apela în cel mai scurt timp pentru confirmarea disponibilității și ofertei exacte.
                                </p>
                                <div class="pt-space-2xs">
                                    <a id="contact-success-wa-link" href="https://wa.me/<?php echo esc_attr($clean_wa); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2 w-full max-w-sm mx-auto py-space-sm px-space-md rounded bg-[#25D366] hover:bg-[#20ba59] text-white font-label-action text-label-action uppercase tracking-wider font-bold transition-all shadow-lg hover:shadow-[#25D366]/30">
                                        <span class="material-symbols-outlined text-[18px]">chat</span>
                                        <span>Deschide și conversația WhatsApp</span>
                                    </a>
                                </div>
                            </div>

                        </div>

                        <!-- Quick Work In Action Preview Mini Cards -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-md">
                            <div class="bg-surface-container-low p-space-md rounded flex items-center gap-space-sm border border-surface-container-highest/40">
                                <div class="w-12 h-12 rounded bg-surface-container flex items-center justify-center shrink-0 text-primary">
                                    <span class="material-symbols-outlined text-[26px]">precision_manufacturing</span>
                                </div>
                                <div>
                                    <p class="font-headline-sm text-headline-sm text-on-surface font-bold uppercase">Duplicare CNC</p>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">Frezare digitală cu toleranță zero pe loc.</p>
                                </div>
                            </div>

                            <div class="bg-surface-container-low p-space-md rounded flex items-center gap-space-sm border border-surface-container-highest/40">
                                <div class="w-12 h-12 rounded bg-surface-container flex items-center justify-center shrink-0 text-primary">
                                    <span class="material-symbols-outlined text-[26px]">settings_remote</span>
                                </div>
                                <div>
                                    <p class="font-headline-sm text-headline-sm text-on-surface font-bold uppercase">Clonare Transponder</p>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">Programare cipuri crypto și telecomenzi.</p>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- 4. FULL-WIDTH: HARTA INTERACTIVĂ & GPS     -->
        <!-- ========================================== -->
        <section class="w-full bg-surface-container-low border-t border-b border-surface-container-highest/40">
            <div class="max-w-[1280px] mx-auto px-gutter-mobile lg:px-gutter-desktop py-space-xl lg:py-space-2xl space-y-space-md">
                
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-space-md">
                    <div>
                        <div class="flex items-center gap-space-xs">
                            <span class="h-0.5 w-6 bg-primary-container"></span>
                            <span class="font-label-badge text-label-badge uppercase tracking-wider text-primary font-bold">Navigație prin Satelit</span>
                        </div>
                        <h2 class="font-headline-xl text-headline-xl text-on-surface uppercase font-bold tracking-wide">
                            <?php echo esc_html($map_title); ?>
                        </h2>
                        <p class="font-body-md text-body-md text-on-surface-variant max-w-xl">
                            <?php echo esc_html($map_desc); ?>
                        </p>
                    </div>

                    <!-- Butoane GPS -->
                    <div class="flex flex-wrap items-center gap-space-xs shrink-0">
                        <?php if ($gmaps_url): ?>
                        <a class="inline-flex items-center gap-space-2xs bg-surface-container-highest hover:bg-surface-bright text-on-surface font-label-action text-label-action uppercase px-space-md py-2.5 rounded transition-colors font-bold shadow-sm" href="<?php echo esc_url($gmaps_url); ?>" rel="noopener noreferrer" target="_blank">
                            <span class="material-symbols-outlined text-primary text-[20px]">near_me</span>
                            <span>DESCHIDE ÎN GOOGLE MAPS</span>
                        </a>
                        <?php endif; ?>

                        <?php if ($waze_url): ?>
                        <a class="inline-flex items-center gap-space-2xs bg-surface-container hover:bg-surface-container-high text-on-surface font-label-action text-label-action uppercase px-space-md py-2.5 rounded transition-colors font-bold shadow-sm" href="<?php echo esc_url($waze_url); ?>" rel="noopener noreferrer" target="_blank">
                            <span class="material-symbols-outlined text-secondary text-[20px]">navigation</span>
                            <span>DESCHIDE ÎN WAZE</span>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Map Display Container -->
                <div class="relative w-full rounded overflow-hidden shadow-lg bg-surface-container-lowest border border-surface-container-highest/40">
                    <?php if (!empty($map_embed)): ?>
                        <div class="w-full h-96 lg:h-[460px] relative z-0 [&>iframe]:w-full [&>iframe]:h-full [&>iframe]:border-0">
                            <?php echo wp_kses($map_embed, array('iframe' => array('src' => true, 'width' => true, 'height' => true, 'style' => true, 'allowfullscreen' => true, 'loading' => true, 'referrerpolicy' => true))); ?>
                        </div>
                    <?php else: ?>
                        <!-- Static Map Graphic with Location Marker Background -->
                        <div class="w-full h-96 lg:h-[460px] bg-cover bg-center" style="background-image: url('<?php echo esc_url($map_img); ?>')"></div>
                    <?php endif; ?>

                    <!-- Dark HUD Map Overlay Indicator -->
                    <div class="absolute top-space-md left-space-md bg-surface-container-lowest/90 backdrop-blur-md p-space-md rounded max-w-sm shadow-xl space-y-space-xs border border-surface-container-highest/70 z-10 pointer-events-none">
                        <div class="flex items-center justify-between">
                            <span class="font-label-badge text-label-badge uppercase tracking-wider text-primary font-bold">PIN GPS CONFIRMAT</span>
                            <span class="h-2 w-2 rounded-full bg-secondary-container animate-pulse"></span>
                        </div>
                        <p class="font-headline-sm text-headline-sm text-on-surface font-bold uppercase">
                            <?php echo esc_html($hud_title); ?>
                        </p>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">
                            <?php echo esc_html($opt_address); ?>. Atelier dotat cu bancuri mecatronice și utilaje CNC computerizate.
                        </p>
                        <div class="pt-space-2xs flex items-center justify-between text-body-sm font-body-sm text-outline">
                            <span><?php echo esc_html($hud_coords); ?></span>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- ========================================== -->
        <!-- 5. SECȚIUNE URGENȚE & INTERVENȚII 24/7     -->
        <!-- ========================================== -->
        <section class="w-full bg-surface">
            <div class="max-w-[1280px] mx-auto px-gutter-mobile lg:px-gutter-desktop py-space-xl lg:py-space-2xl">
                <div class="bg-gradient-to-r from-surface-container-low via-surface-container to-surface-container-low p-space-lg lg:p-space-xl rounded shadow-xl relative overflow-hidden border border-surface-container-highest/40">
                    <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-space-lg">
                        
                        <div class="space-y-space-xs max-w-2xl">
                            <div class="inline-flex items-center gap-space-2xs px-space-xs py-1 rounded bg-on-tertiary-fixed-variant text-tertiary font-label-badge text-label-badge uppercase font-bold tracking-wider">
                                <span class="material-symbols-outlined text-[16px]">emergency</span>
                                <span><?php echo esc_html($em_badge); ?></span>
                            </div>
                            <h3 class="font-headline-xl text-headline-xl text-on-surface uppercase font-extrabold tracking-wide">
                                <?php echo esc_html($em_title); ?>
                            </h3>
                            <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed">
                                <?php echo nl2br(esc_html($em_desc)); ?>
                            </p>
                        </div>

                        <div class="flex flex-col sm:flex-row lg:flex-col gap-space-xs shrink-0">
                            <a class="inline-flex items-center justify-center gap-space-xs bg-primary-container hover:bg-secondary-container text-on-primary-container font-label-action text-label-action uppercase font-extrabold px-space-xl py-space-sm rounded transition-all duration-200 shadow-[0_0_24px_rgba(255,119,0,0.5)] tracking-wider" href="tel:<?php echo esc_attr($clean_em_phone); ?>">
                                <span class="material-symbols-outlined text-[24px]">e911_emergency</span>
                                <span>APEL DE URGENȚĂ (<?php echo esc_html($em_phone); ?>)</span>
                            </a>
                            <div class="text-center font-body-sm text-body-sm text-on-surface-variant">
                                <span><?php echo esc_html($em_note); ?></span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

    </div>
</main>

<!-- Original Theme Footer -->
<?php get_footer(); ?>

