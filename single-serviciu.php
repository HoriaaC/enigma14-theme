<?php
/**
 * Single Template: Serviciu (ENIGMA 14)
 * Based on stich/service.html
 */

$post_id = get_the_ID();

// Category Taxonomy Association for Breadcrumbs
$categories = get_the_terms($post_id, 'categorie_serviciu');
$primary_cat = (!empty($categories) && !is_wp_error($categories)) ? $categories[0] : null;

// 1. Status Band
$status_left  = get_field('service_status_band_left', $post_id) ?: 'STAND MECATRONIC ACTIV • DECODARE LA MICRON';
$status_right = get_field('service_status_band_right', $post_id) ?: 'BUCUREȘTI SECTOR 1';

// 2. Hero Content (Left)
$hero_badge_icon = get_field('service_hero_badge_icon', $post_id) ?: 'verified_user';
$hero_badge_text = get_field('service_hero_badge_text', $post_id) ?: 'SISTEME DE BLOCARE DE ÎNALTĂ SECURITATE';

$hero_title = get_field('service_hero_title', $post_id);
if (empty($hero_title)) {
    $hero_title = get_the_title();
}

$hero_description = get_field('service_hero_description', $post_id);
if (empty($hero_description)) {
    $hero_description = get_the_excerpt() ?: 'Securitate maximă și duplicare computerizată pe mașini CNC de înaltă finețe. Asigurăm multiplicare fidelă pentru chei cu amprentă (dimple keys), profile reversibile patentate, tăiere laser de precizie și duplicare exclusiv pe baza cartelei de proprietate codificate pentru uși blindate și locuințe rezidențiale.';
}

// Hero CTAs
$btn1_text = get_field('service_btn1_text', $post_id) ?: 'SOLICITĂ DUPLICARE PE COD';
$btn1_url  = get_field('service_btn1_url', $post_id) ?: '#solicita-duplicare';
$btn2_text = get_field('service_btn2_text', $post_id) ?: '0722 000 114 — SUPORT DIRECT';
$btn2_url  = get_field('service_btn2_url', $post_id) ?: 'tel:0722000114';

// 4 Micro-spec Pills
$spec1_icon  = get_field('service_spec1_icon', $post_id) ?: 'precision_manufacturing';
$spec1_label = get_field('service_spec1_label', $post_id) ?: 'Toleranță Mecanică';
$spec1_val   = get_field('service_spec1_val', $post_id) ?: '±0.01 mm (Frezare Laser Silca)';

$spec2_icon  = get_field('service_spec2_icon', $post_id) ?: 'badge';
$spec2_label = get_field('service_spec2_label', $post_id) ?: 'Duplicare pe Card';
$spec2_val   = get_field('service_spec2_val', $post_id) ?: 'Cod Bitting Original';

$spec3_icon  = get_field('service_spec3_icon', $post_id) ?: 'timer';
$spec3_label = get_field('service_spec3_label', $post_id) ?: 'Execuție Rapidă';
$spec3_val   = get_field('service_spec3_val', $post_id) ?: '3 - 10 Min (Direct la Ghișeu)';

$spec4_icon  = get_field('service_spec4_icon', $post_id) ?: 'task_alt';
$spec4_label = get_field('service_spec4_label', $post_id) ?: 'Matrițe Originale';
$spec4_val   = get_field('service_spec4_val', $post_id) ?: '100% Compatibilitate Miez';

// 3. Hero Visual Component (Right)
$hero_img = get_field('service_hero_image', $post_id);
if (empty($hero_img)) {
    $hero_img = get_the_post_thumbnail_url($post_id, 'large') ?: 'https://lh3.googleusercontent.com/aida-public/AB6AXuAAn4AnpuF-F1E89paKQ5NOXZHeWI7nW-bFyOMdCq08PK5SXv-K6XO5HcQGPb4VqSyi9AmFU1DdQO0EwKvoPpZOF3pQSmxGgncNJc9OVlZ8sFIDmSwQo8asM9OjQcoB5AQst1S0KRjyB83ZoBPBQanBlCpvV_8s-6u_vLFATXKofnXbXuWTDxMtcWDB4lbns-AQ97Z0WtycFpfwjvBVaoc-9oF-Yse9IoNjU0exRDyPq7Yr7BqOacCK';
}

$floating_badge = get_field('service_hero_floating_badge', $post_id) ?: 'CILINDRU CALIBRAT • ISO 9001';
$panel_title    = get_field('service_hero_panel_title', $post_id) ?: 'STAND MECATRONIC';
$panel_code     = get_field('service_hero_panel_code', $post_id) ?: 'CALIBRATION ID: #EN-9942';
$panel_desc     = get_field('service_hero_panel_desc', $post_id) ?: 'Echipamente active: Silca Futura Pro (frezare adâncime laser), decodare optică profil, toleranță 0.01mm.';
$guarantee_text = get_field('service_guarantee_text', $post_id) ?: 'Garanție Execuție 24 Luni';
$partner_text   = get_field('service_partner_text', $post_id) ?: 'Profile Protejate Silca';

// 4. Products / Models Section
$prod_badge_icon = get_field('service_products_badge_icon', $post_id) ?: 'lock_open';
$prod_badge_text = get_field('service_products_badge_text', $post_id) ?: 'CATALOG PROFILE DE SECURITATE';
$prod_title      = get_field('service_products_title', $post_id) ?: 'MODELE ȘI PROFILE DISPONIBILE';
$prod_desc       = get_field('service_products_desc', $post_id) ?: 'Catalog informativ de profile uzuale prelucrate în atelierul mecatronic ENIGMA 14. Prețurile variază în funcție de complexitatea frezării, prezența pinilor activi și autorizarea pe baza cardului de proprietate.';

$products_repeater = get_field('service_products', $post_id);
if (empty($products_repeater) || !is_array($products_repeater)) {
    // Default 6 technical products from service.html
    $products_list = array(
        array(
            'image'       => 'https://lh3.googleusercontent.com/aida/AEtjO1WnE3uDoEGGmGd_FhAJg85_jdQJWd6Gz77emqUWA0ejVofTSpACQa-KkstnAgqmVZe5NMopeT0_r8LfI6MPlGKtvxA11xdwoPMN0UYyPluHky6dl578-vkzoxVh0dxLDMvr2-weddkU23tMLr4k8jvwEmzC2mLp6Cv-878A6CCqjtUX9X_wcROMDXNs3hZcapO14BlJfEc9qtOMEAFNNAwd9Jz4QaIJeZT-3279v36-M-R663g0XKAfCkE',
            'badge'       => 'PIN TELESCOPIC',
            'icon'        => 'vpn_key',
            'title'       => 'Cheie Amprentă Mul-T-Lock',
            'series'      => 'Seria Interactive+ / Classic / MT5+',
            'description' => 'Copiere profil de înaltă securitate cu amprente laterale și pin mobil telescopic integrat în cheie. Necesită card de proprietate pentru profilele patentate.',
            'tags'        => array('Amprentă 3D', 'Protecție Bumping', 'Cod Securizat'),
            'price'       => '60 - 120 RON',
            'button_text' => 'Cere detalii',
            'button_url'  => '#solicita-duplicare',
        ),
        array(
            'image'       => 'https://lh3.googleusercontent.com/aida/AEtjO1WwqoZu0yAMRCNfT-sQx2JsnOytKPtovAUtAqwUQrutTCVE0mURcf6zn7NV_GwYznPPY8DTkDYs5iNJMgbGx7oRU7wo_h4vA792cdP-Cz4S55CaLxwVoq5uGhirzCaBDyAff9WobJVq8gl5WhY-qJnv5y752YfndwjFyTWF_WEQQ91HnguVY-srM6J3bl7V2sI6cGoafgY9M2c0dc7cdNJoAw5fnLsceWmbAjf1CeVPDrnw83DPBL3Cv5Q',
            'badge'       => 'PIN MAGNETIC',
            'icon'        => 'key_visualizer',
            'title'       => 'Cheie Specială Mottura',
            'series'      => 'Seria Champions C28 / C38 / C48',
            'description' => 'Duplicare chei cu profil controlat, pini magnetici și frezare continuă tip undă (laser bitting). Execuție pe mașină computerizată Silca.',
            'tags'        => array('Canelură Undă', 'Cartelă Securitate', 'Pastilă Neodim'),
            'price'       => '80 - 160 RON',
            'button_text' => 'Cere detalii',
            'button_url'  => '#solicita-duplicare',
        ),
        array(
            'image'       => 'https://lh3.googleusercontent.com/aida/AEtjO1UoGnSjfSlulc_Pus2pz75LCJhEs4VWtSjxOzKsK2U5v5v3ReB1DkQTv7N1i9BGBu32To53CbTUv8NphSqwg27d4JycIyYKWbYa81QfbSqtFlwxj_UL5uSt7dhZwJr8k2GUy69cCU0EIBEPuDtrGUP9T2AdfgPWF5DLhr5fCktQhz1_MveZYIXI0mkCimyJI7G7sfB_Vqi3e0AY3p61p1OkHO1CaG5P2Yun3XuxuRebaUpspyfUQ-It0is',
            'badge'       => 'DUBLĂ AMPRENTĂ',
            'icon'        => 'lock',
            'title'       => 'Cheie Amprentă Cisa',
            'series'      => 'Seria Astral / Astral S / AP4 S',
            'description' => 'Copiere pe mașini electronice calibrate, profil cu protecție antipicking și amprentă adâncă pe 10 pini. Asigură fluiditate la rotire în butuc.',
            'tags'        => array('Clasa 6 Securitate', 'Bitting Decodat', 'Cilindru Sigilat'),
            'price'       => '50 - 95 RON',
            'button_text' => 'Cere detalii',
            'button_url'  => '#solicita-duplicare',
        ),
        array(
            'image'       => 'https://lh3.googleusercontent.com/aida/AEtjO1UE3MRXJiOilyLbQPhKpQlwf_MrHOn9THjmdf791zHXCeVg6d-ZxeNs7Hdt1KzbFSReX2MzXZ5JsXjhsZxiHJBXL5CtN_mfBgZBz9XqHBXsQ1JVAfQea1x9XszGAmdobDwsM-KRfhKPjTV0pCvlhapMaw5ui8IrsC5EbRO3Who5eurUY_RqQNkInjJDN5YEwWADZGwjOWHRFVBAiZyVMGADnXYB4g-5k5Jjc5WCxzTjmMRstO1aCLxNiZc',
            'badge'       => 'UȘI BLINDATE',
            'icon'        => 'door_front',
            'title'       => 'Cheie Seif & Barbă Dublă',
            'series'      => 'Securemme / Dierre / Mottura / Sab / Potent',
            'description' => 'Frezare chei lungi tip fluture / barbă dublă pentru seifuri și uși blindate grele. Reconstituire dinți uzați și aliniere micrometrică a paletelor.',
            'tags'        => array('Lame 80-120mm', 'Frezare Simetrică', 'Alamă Forjată'),
            'price'       => '45 - 85 RON',
            'button_text' => 'Cere detalii',
            'button_url'  => '#solicita-duplicare',
        ),
        array(
            'image'       => 'https://lh3.googleusercontent.com/aida/AEtjO1X0oxiR_LYzcTAr5ao-pi1XHWgT6qxn9dEZ5A9hnNeU029ejcTlnoin_ulN3MWg6y-pYbmfzHi5kgAMFn445Bojkrxo_IFNs6oVXjoTrFTubdbvVngfIMPL8RGa6k8eCISTYF-1q4hkmanvJK6trbA8_7qeBQrCgwpXA1Z6UpgobivEeTtYTXf3H8fNRWivDpX8CwtC0CsJHWzp8VsMWmB8NXY-aV1vihEbCkNoWPZcjSOtsMNQLB1umA',
            'badge'       => 'PROFIL REVERSIBIL',
            'icon'        => 'security',
            'title'       => 'Cheie Amprentă Abus',
            'series'      => 'Seria Bravus / D6 / D10 / EC550',
            'description' => 'Duplicare cilindri de siguranță Abus cu cod pe card și amprentă reversibilă. Caneluri laterale complexe pentru rezistență mecanică maximă.',
            'tags'        => array('Protecție Găurire', 'Reversibilă', 'Alpaca Anticoroziune'),
            'price'       => '55 - 110 RON',
            'button_text' => 'Cere detalii',
            'button_url'  => '#solicita-duplicare',
        ),
        array(
            'image'       => 'https://lh3.googleusercontent.com/aida/AEtjO1Vsgc-i0OJuDU6zXANEuvlSs6jLoZ1d-aa-FHDADkztPeV9I2MKfNCklb1MXYkhy-f9q2HRM0PI0NYNUIhw2_5moRKiLsPGy4S8BA59vCBWmYXq8VTfga25Z_yvHjesbcN4UWL2CKhx3wuo3jGMCNNjCOGbavWObnZ_UC2Q4zJNHA_yvM9cfF9lkLGA_MFEwAGjmtRLb-w4ZHsUuENNTj-AJ-MrQEGF8OaNN8KrqJ67_h2-unpP5fmjSiY',
            'badge'       => 'PROFIL CANELAT',
            'icon'        => 'engineering',
            'title'       => 'Cheie Profil Special Yale / Gerda',
            'series'      => 'Seria 1000 / 2000 / Gerda Tytan',
            'description' => 'Chei plane cu caneluri complexe și protecție împotriva copierii neautorizate. Toleranță exactă conform fișei tehnice originale de fabrică.',
            'tags'        => array('Canelură Înaltă', 'Alamă Nichelată', 'Secțiune Tubulară'),
            'price'       => '30 - 60 RON',
            'button_text' => 'Cere detalii',
            'button_url'  => '#solicita-duplicare',
        ),
    );
} else {
    $products_list = array();
    foreach ($products_repeater as $row) {
        $tags_raw = isset($row['tags']) ? $row['tags'] : '';
        $tags_arr = array();
        if (!empty($tags_raw)) {
            $tags_arr = array_map('trim', explode(',', $tags_raw));
        }

        $products_list[] = array(
            'image'       => isset($row['image']) && !empty($row['image']) ? $row['image'] : 'https://lh3.googleusercontent.com/aida/AEtjO1WnE3uDoEGGmGd_FhAJg85_jdQJWd6Gz77emqUWA0ejVofTSpACQa-KkstnAgqmVZe5NMopeT0_r8LfI6MPlGKtvxA11xdwoPMN0UYyPluHky6dl578-vkzoxVh0dxLDMvr2-weddkU23tMLr4k8jvwEmzC2mLp6Cv-878A6CCqjtUX9X_wcROMDXNs3hZcapO14BlJfEc9qtOMEAFNNAwd9Jz4QaIJeZT-3279v36-M-R663g0XKAfCkE',
            'badge'       => isset($row['badge']) ? $row['badge'] : '',
            'icon'        => isset($row['icon']) && !empty($row['icon']) ? $row['icon'] : 'vpn_key',
            'title'       => isset($row['title']) ? $row['title'] : '',
            'series'      => isset($row['series']) ? $row['series'] : '',
            'description' => isset($row['description']) ? $row['description'] : '',
            'tags'        => $tags_arr,
            'price'       => isset($row['price']) ? $row['price'] : '',
            'button_text' => isset($row['button_text']) && !empty($row['button_text']) ? $row['button_text'] : 'Cere detalii',
            'button_url'  => isset($row['button_url']) && !empty($row['button_url']) ? $row['button_url'] : '#solicita-duplicare',
        );
    }
}
$products_count = count($products_list);
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class('bg-surface-container-lowest font-body-md text-on-surface antialiased selection:bg-primary-container selection:text-on-primary-container'); ?>>
<?php wp_body_open(); ?>

<?php echo do_blocks('<!-- wp:template-part {"slug":"header"} /-->'); ?>

<main class="w-full pt-36 md:pt-[145px] bg-surface-container-lowest min-h-screen">
    <div class="flex flex-col w-full">

        <!-- ========================================== -->
        <!-- 1. BREADCRUMB BAR & LIVE STATUS BAND       -->
        <!-- ========================================== -->
        <section class="w-full bg-surface-container-lowest border-b border-surface-container-highest/30">
            <div class="max-w-[1280px] mx-auto px-gutter-mobile lg:px-gutter-desktop py-space-sm flex flex-col sm:flex-row sm:items-center justify-between gap-space-sm">
                <nav aria-label="Breadcrumb" class="flex items-center gap-space-xs text-body-sm font-body-sm text-outline flex-wrap">
                    <a class="hover:text-primary transition-colors" href="<?php echo esc_url(home_url('/')); ?>">Acasă</a>
                    <span class="text-surface-container-highest">/</span>
                    <?php if ($primary_cat): ?>
                    <a class="hover:text-primary transition-colors" href="<?php echo esc_url(get_term_link($primary_cat)); ?>"><?php echo esc_html($primary_cat->name); ?></a>
                    <span class="text-surface-container-highest">/</span>
                    <?php endif; ?>
                    <span class="text-primary font-semibold"><?php echo esc_html(get_the_title()); ?></span>
                </nav>

                <?php if ($status_left || $status_right): ?>
                <div class="inline-flex items-center gap-space-xs px-space-sm py-1 bg-surface-container-high rounded self-start sm:self-auto">
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-container opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-primary-container"></span>
                    </span>
                    <span class="font-label-badge text-label-badge uppercase text-primary tracking-wider">
                        <?php echo esc_html($status_left . ($status_right ? ' • ' . $status_right : '')); ?>
                    </span>
                </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- 2. SPLIT HERO SECTION                      -->
        <!-- ========================================== -->
        <section class="w-full relative overflow-hidden bg-surface-container-lowest border-b border-surface-container-highest">
            <!-- Ambient backlighting -->
            <div class="absolute top-1/4 -left-20 w-96 h-96 bg-primary-container/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 right-10 w-80 h-80 bg-secondary-container/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="max-w-[1280px] mx-auto px-gutter-desktop py-space-2xl lg:py-space-3xl relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-xl items-center">
                    
                    <!-- Left Column: Technical Narrative & Actions (7 cols) -->
                    <div class="lg:col-span-7 flex flex-col gap-space-md">
                        
                        <?php if ($hero_badge_text): ?>
                        <div class="inline-flex items-center gap-space-xs px-space-sm py-space-2xs rounded-lg bg-surface-container border border-primary-container/40 self-start shadow-[0_0_12px_-2px_rgba(255,119,0,0.25)]">
                            <span class="material-symbols-outlined text-primary-container text-[18px]"><?php echo esc_html($hero_badge_icon); ?></span>
                            <span class="font-label-badge text-label-badge uppercase tracking-widest text-primary font-bold"><?php echo esc_html($hero_badge_text); ?></span>
                        </div>
                        <?php endif; ?>

                        <h1 class="font-display-lg text-display-lg text-on-surface tracking-tight uppercase leading-none">
                            <?php echo wp_kses_post($hero_title); ?>
                        </h1>

                        <?php if ($hero_description): ?>
                        <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed">
                            <?php echo nl2br(esc_html($hero_description)); ?>
                        </p>
                        <?php endif; ?>

                        <!-- Micro-spec Pills Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-xs pt-space-xs">
                            <div class="flex items-center gap-space-xs p-space-xs rounded-lg bg-surface-container border border-surface-container-highest">
                                <span class="material-symbols-outlined text-primary-container text-[20px]"><?php echo esc_html($spec1_icon); ?></span>
                                <div class="flex flex-col">
                                    <span class="font-label-badge text-label-badge uppercase tracking-wider text-on-surface-variant"><?php echo esc_html($spec1_label); ?></span>
                                    <span class="font-label-action text-label-action text-on-surface font-semibold"><?php echo esc_html($spec1_val); ?></span>
                                </div>
                            </div>
                            <div class="flex items-center gap-space-xs p-space-xs rounded-lg bg-surface-container border border-surface-container-highest">
                                <span class="material-symbols-outlined text-primary-container text-[20px]"><?php echo esc_html($spec2_icon); ?></span>
                                <div class="flex flex-col">
                                    <span class="font-label-badge text-label-badge uppercase tracking-wider text-on-surface-variant"><?php echo esc_html($spec2_label); ?></span>
                                    <span class="font-label-action text-label-action text-on-surface font-semibold"><?php echo esc_html($spec2_val); ?></span>
                                </div>
                            </div>
                            <div class="flex items-center gap-space-xs p-space-xs rounded-lg bg-surface-container border border-surface-container-highest">
                                <span class="material-symbols-outlined text-primary-container text-[20px]"><?php echo esc_html($spec3_icon); ?></span>
                                <div class="flex flex-col">
                                    <span class="font-label-badge text-label-badge uppercase tracking-wider text-on-surface-variant"><?php echo esc_html($spec3_label); ?></span>
                                    <span class="font-label-action text-label-action text-on-surface font-semibold"><?php echo esc_html($spec3_val); ?></span>
                                </div>
                            </div>
                            <div class="flex items-center gap-space-xs p-space-xs rounded-lg bg-surface-container border border-surface-container-highest">
                                <span class="material-symbols-outlined text-primary-container text-[20px]"><?php echo esc_html($spec4_icon); ?></span>
                                <div class="flex flex-col">
                                    <span class="font-label-badge text-label-badge uppercase tracking-wider text-on-surface-variant"><?php echo esc_html($spec4_label); ?></span>
                                    <span class="font-label-action text-label-action text-on-surface font-semibold"><?php echo esc_html($spec4_val); ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-wrap items-center gap-space-md pt-space-sm">
                            <?php if ($btn1_text): ?>
                            <a class="inline-flex items-center justify-center gap-space-xs font-label-action text-label-action uppercase px-space-xl py-space-sm rounded-lg bg-primary-container text-on-surface-container font-extrabold hover:bg-secondary-container hover:text-on-secondary-container transition-all shadow-[0_0_20px_rgba(255,119,0,0.45)] active:scale-95" href="<?php echo esc_url($btn1_url); ?>">
                                <span><?php echo esc_html($btn1_text); ?></span>
                                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </a>
                            <?php endif; ?>

                            <?php if ($btn2_text): ?>
                            <a class="inline-flex items-center justify-center gap-space-xs font-label-action text-label-action uppercase px-space-lg py-space-sm rounded-lg bg-surface-container border border-surface-container-highest text-on-surface font-bold hover:border-primary-container hover:text-primary transition-all active:scale-95 shadow-md" href="<?php echo esc_url($btn2_url); ?>">
                                <span class="material-symbols-outlined text-primary-container text-[18px]">call</span>
                                <span><?php echo esc_html($btn2_text); ?></span>
                            </a>
                            <?php endif; ?>
                        </div>

                    </div>

                    <!-- Right Column: Visual Component (5 cols) -->
                    <div class="lg:col-span-5 flex flex-col gap-space-sm">
                        <div class="relative rounded-2xl overflow-hidden bg-surface-container border border-surface-container-highest shadow-[0_12px_40px_rgba(0,0,0,0.8)] group">
                            <img class="w-full h-[380px] lg:h-[440px] object-cover transition-transform duration-700 group-hover:scale-105" src="<?php echo esc_url($hero_img); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                            <div class="absolute inset-0 bg-gradient-to-t from-surface-container-lowest via-surface-container-lowest/40 to-transparent"></div>
                            
                            <!-- Floating Stamp -->
                            <?php if ($floating_badge): ?>
                            <div class="absolute top-space-md right-space-md px-space-sm py-space-2xs rounded-lg bg-surface-container-lowest/90 backdrop-blur-md border border-primary-container/60 shadow-[0_0_16px_rgba(255,119,0,0.3)] flex items-center gap-space-2xs">
                                <span class="w-2 h-2 rounded-full bg-primary"></span>
                                <span class="font-label-badge text-label-badge text-on-surface uppercase tracking-wider font-extrabold"><?php echo esc_html($floating_badge); ?></span>
                            </div>
                            <?php endif; ?>

                            <!-- Overlay Bottom Spec Label -->
                            <div class="absolute bottom-space-md left-space-md right-space-md p-space-sm rounded-xl bg-surface-container-low/95 backdrop-blur-md border border-surface-container-highest">
                                <div class="flex items-center justify-between border-b border-surface-container-highest pb-space-2xs mb-space-2xs">
                                    <span class="font-label-badge text-label-badge uppercase tracking-wider text-primary font-bold"><?php echo esc_html($panel_title); ?></span>
                                    <span class="font-body-sm text-body-sm text-on-surface-variant font-mono"><?php echo esc_html($panel_code); ?></span>
                                </div>
                                <p class="font-body-sm text-body-sm text-on-surface leading-tight">
                                    <?php echo esc_html($panel_desc); ?>
                                </p>
                            </div>
                        </div>

                        <!-- Guarantee Strip -->
                        <div class="flex items-center justify-between px-space-md py-space-xs rounded-xl bg-surface-container border border-surface-container-highest">
                            <div class="flex items-center gap-space-xs">
                                <span class="material-symbols-outlined text-primary-container text-[20px]">shield</span>
                                <span class="font-label-badge text-label-badge uppercase tracking-wider text-on-surface"><?php echo esc_html($guarantee_text); ?></span>
                            </div>
                            <div class="flex items-center gap-space-xs">
                                <span class="material-symbols-outlined text-secondary text-[20px]">key</span>
                                <span class="font-label-badge text-label-badge uppercase tracking-wider text-on-surface-variant"><?php echo esc_html($partner_text); ?></span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- 3. KEY PROFILE MATRIX & PRODUCTS GRID      -->
        <!-- ========================================== -->
        <section class="w-full bg-surface-container-lowest py-space-2xl lg:py-space-3xl">
            <div class="max-w-[1280px] mx-auto px-gutter-desktop">
                
                <!-- Section Heading -->
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-space-md border-b border-surface-container-highest pb-space-lg mb-space-2xl">
                    <div class="flex flex-col gap-space-2xs max-w-2xl">
                        <div class="flex items-center gap-space-2xs">
                            <span class="material-symbols-outlined text-primary-container text-[20px]"><?php echo esc_html($prod_badge_icon); ?></span>
                            <span class="font-label-badge text-label-badge uppercase tracking-widest text-primary font-bold"><?php echo esc_html($prod_badge_text); ?></span>
                        </div>
                        <h2 class="font-headline-xl text-headline-xl text-on-surface uppercase tracking-tight"><?php echo esc_html($prod_title); ?></h2>
                        <?php if ($prod_desc): ?>
                        <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                            <?php echo nl2br(esc_html($prod_desc)); ?>
                        </p>
                        <?php endif; ?>
                    </div>
                    
                    <div class="shrink-0 flex items-center gap-space-xs">
                        <span class="inline-flex items-center px-space-sm py-space-2xs rounded-lg bg-surface-container-high border border-surface-container-highest font-label-badge text-label-badge text-on-surface uppercase">
                            <?php echo esc_html($products_count . ' MODELE PRINCIPALE'); ?>
                        </span>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-space-lg">
                    <?php foreach ($products_list as $prod): ?>
                    <div class="flex flex-col justify-between rounded-xl bg-surface-container-low border border-surface-container-highest hover:border-primary-container transition-all duration-300 shadow-lg hover:shadow-[0_0_24px_-4px_rgba(255,119,0,0.3)] p-space-lg group overflow-hidden">
                        
                        <!-- Top Image -->
                        <?php if (!empty($prod['image'])): ?>
                        <div class="relative w-[calc(100%+3rem)] max-w-none h-48 -mt-space-lg -mx-space-lg mb-space-md overflow-hidden rounded-t-xl border-b border-surface-container-highest bg-surface-container-lowest">
                            <img src="<?php echo esc_url($prod['image']); ?>" alt="<?php echo esc_attr($prod['title']); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
                            <div class="absolute inset-0 bg-gradient-to-t from-surface-container-low via-transparent to-transparent"></div>
                        </div>
                        <?php endif; ?>

                        <div>
                            <!-- Badge and Icon Header -->
                            <div class="flex items-center justify-between mb-space-md">
                                <?php if (!empty($prod['badge'])): ?>
                                <span class="px-space-xs py-space-2xs rounded-md bg-surface-container-highest border border-primary-container/40 font-label-badge text-label-badge text-primary uppercase font-bold tracking-wider">
                                    <?php echo esc_html($prod['badge']); ?>
                                </span>
                                <?php else: ?>
                                <span></span>
                                <?php endif; ?>
                                
                                <span class="material-symbols-outlined text-surface-bright group-hover:text-primary-container transition-colors text-[24px]">
                                    <?php echo esc_html($prod['icon'] ?: 'vpn_key'); ?>
                                </span>
                            </div>

                            <!-- Title & Series -->
                            <div class="mb-space-sm">
                                <h3 class="font-headline-sm text-headline-sm text-on-surface uppercase group-hover:text-primary transition-colors">
                                    <?php echo esc_html($prod['title']); ?>
                                </h3>
                                <?php if (!empty($prod['series'])): ?>
                                <span class="font-body-sm text-body-sm text-primary-container font-mono block mt-0.5">
                                    <?php echo esc_html($prod['series']); ?>
                                </span>
                                <?php endif; ?>
                            </div>

                            <!-- Description -->
                            <?php if (!empty($prod['description'])): ?>
                            <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed mb-space-md">
                                <?php echo nl2br(esc_html($prod['description'])); ?>
                            </p>
                            <?php endif; ?>

                            <!-- Tags Pills -->
                            <?php if (!empty($prod['tags']) && is_array($prod['tags'])): ?>
                            <div class="flex flex-wrap gap-space-2xs mb-space-md">
                                <?php foreach ($prod['tags'] as $tag): ?>
                                <span class="px-space-2xs py-1 rounded bg-surface-container-highest text-on-surface font-label-badge text-[10px] tracking-wider uppercase">
                                    <?php echo esc_html($tag); ?>
                                </span>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Footer: Price and CTA -->
                        <div class="border-t border-surface-container-highest pt-space-sm flex items-center justify-between">
                            <div class="flex flex-col">
                                <span class="font-label-badge text-label-badge uppercase tracking-wider text-on-surface-variant">Cost estimativ</span>
                                <span class="font-headline-sm text-headline-sm text-primary font-bold">
                                    <?php echo esc_html($prod['price'] ?: 'La cerere'); ?>
                                </span>
                            </div>
                            <!-- <a class="inline-flex items-center gap-1 font-label-action text-label-action text-on-surface hover:text-primary-container transition-colors uppercase font-bold" href="<?php echo esc_url($prod['button_url'] ?: '#solicita-duplicare'); ?>">
                                <span><?php echo esc_html($prod['button_text'] ?: 'Cere detalii'); ?></span>
                                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                            </a> -->
                        </div>

                    </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </section>

        <!-- ========================================== -->
        <!-- 4. BRAND TRUST BAR (MECATRONIC PROFILES)   -->
        <!-- ========================================== -->
        <section class="w-full bg-surface-container-low border-y border-surface-container-highest py-space-xl">
            <div class="max-w-[1280px] mx-auto px-gutter-desktop">
                <div class="flex flex-col md:flex-row items-center justify-between gap-space-md mb-space-lg">
                    <div class="flex items-center gap-space-xs">
                        <span class="material-symbols-outlined text-primary-container text-[20px]">verified</span>
                        <span class="font-label-badge text-label-badge uppercase tracking-widest text-on-surface font-bold">PROFILE MECATRONICE SUPORTATE</span>
                    </div>
                    <span class="font-body-sm text-body-sm text-on-surface-variant">Semifabricate originale Silca, Errebi, JMA &amp; Ilco</span>
                </div>
                <!-- Brand Logos / Monogram Matrix -->
                <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-space-sm">
                    <div class="p-space-sm rounded-lg bg-surface-container border border-surface-container-highest text-center flex flex-col items-center justify-center hover:border-primary-container/60 transition-colors">
                        <span class="font-headline-sm text-headline-sm text-on-surface font-extrabold tracking-wider">MOTTURA</span>
                        <span class="font-label-badge text-[9px] uppercase tracking-widest text-primary-container mt-0.5">Champions</span>
                    </div>
                    <div class="p-space-sm rounded-lg bg-surface-container border border-surface-container-highest text-center flex flex-col items-center justify-center hover:border-primary-container/60 transition-colors">
                        <span class="font-headline-sm text-headline-sm text-on-surface font-extrabold tracking-wider">CISA</span>
                        <span class="font-label-badge text-[9px] uppercase tracking-widest text-primary-container mt-0.5">Astral &amp; AP4</span>
                    </div>
                    <div class="p-space-sm rounded-lg bg-surface-container border border-surface-container-highest text-center flex flex-col items-center justify-center hover:border-primary-container/60 transition-colors">
                        <span class="font-headline-sm text-headline-sm text-on-surface font-extrabold tracking-wider">MUL-T-LOCK</span>
                        <span class="font-label-badge text-[9px] uppercase tracking-widest text-primary-container mt-0.5">MT5+ / Classic</span>
                    </div>
                    <div class="p-space-sm rounded-lg bg-surface-container border border-surface-container-highest text-center flex flex-col items-center justify-center hover:border-primary-container/60 transition-colors">
                        <span class="font-headline-sm text-headline-sm text-on-surface font-extrabold tracking-wider">ABUS</span>
                        <span class="font-label-badge text-[9px] uppercase tracking-widest text-primary-container mt-0.5">Bravus Security</span>
                    </div>
                    <div class="p-space-sm rounded-lg bg-surface-container border border-surface-container-highest text-center flex flex-col items-center justify-center hover:border-primary-container/60 transition-colors">
                        <span class="font-headline-sm text-headline-sm text-on-surface font-extrabold tracking-wider">SECUREMME</span>
                        <span class="font-label-badge text-[9px] uppercase tracking-widest text-primary-container mt-0.5">Evoluzione K22</span>
                    </div>
                    <div class="p-space-sm rounded-lg bg-surface-container border border-surface-container-highest text-center flex flex-col items-center justify-center hover:border-primary-container/60 transition-colors">
                        <span class="font-headline-sm text-headline-sm text-on-surface font-extrabold tracking-wider">YALE</span>
                        <span class="font-label-badge text-[9px] uppercase tracking-widest text-primary-container mt-0.5">Series 2000</span>
                    </div>
                    <div class="p-space-sm rounded-lg bg-surface-container border border-surface-container-highest text-center flex flex-col items-center justify-center hover:border-primary-container/60 transition-colors">
                        <span class="font-headline-sm text-headline-sm text-on-surface font-extrabold tracking-wider">GERDA</span>
                        <span class="font-label-badge text-[9px] uppercase tracking-widest text-primary-container mt-0.5">Tytan &amp; Rim</span>
                    </div>
                    <div class="p-space-sm rounded-lg bg-surface-container border border-surface-container-highest text-center flex flex-col items-center justify-center hover:border-primary-container/60 transition-colors">
                        <span class="font-headline-sm text-headline-sm text-on-surface font-extrabold tracking-wider">DIERRE</span>
                        <span class="font-label-badge text-[9px] uppercase tracking-widest text-primary-container mt-0.5">Porta Blindata</span>
                    </div>
                    <div class="p-space-sm rounded-lg bg-surface-container border border-surface-container-highest text-center flex flex-col items-center justify-center hover:border-primary-container/60 transition-colors">
                        <span class="font-headline-sm text-headline-sm text-on-surface font-extrabold tracking-wider">ISEO</span>
                        <span class="font-label-badge text-[9px] uppercase tracking-widest text-primary-container mt-0.5">R6 &amp; ISR</span>
                    </div>
                    <div class="p-space-sm rounded-lg bg-surface-container border border-surface-container-highest text-center flex flex-col items-center justify-center hover:border-primary-container/60 transition-colors">
                        <span class="font-headline-sm text-headline-sm text-on-surface font-extrabold tracking-wider">TITAN</span>
                        <span class="font-label-badge text-[9px] uppercase tracking-widest text-primary-container mt-0.5">TL &amp; Dominator</span>
                    </div>
                    <div class="p-space-sm rounded-lg bg-surface-container border border-surface-container-highest text-center flex flex-col items-center justify-center hover:border-primary-container/60 transition-colors">
                        <span class="font-headline-sm text-headline-sm text-on-surface font-extrabold tracking-wider">KABA</span>
                        <span class="font-label-badge text-[9px] uppercase tracking-widest text-primary-container mt-0.5">Gege &amp; Expert</span>
                    </div>
                    <div class="p-space-sm rounded-lg bg-surface-container border border-surface-container-highest text-center flex flex-col items-center justify-center hover:border-primary-container/60 transition-colors">
                        <span class="font-headline-sm text-headline-sm text-on-surface font-extrabold tracking-wider">POTENT</span>
                        <span class="font-label-badge text-[9px] uppercase tracking-widest text-primary-container mt-0.5">Palastro Bit</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- 5. GUTENBERG CONTENT (Optional Extra Content) -->
        <!-- ========================================== -->
        <?php 
        $content = get_the_content();
        if (!empty(trim($content))): ?>
        <section class="w-full bg-surface-container-lowest py-space-xl">
            <div class="max-w-[1280px] mx-auto px-gutter-desktop">
                <?php while (have_posts()) : the_post(); the_content(); endwhile; ?>
            </div>
        </section>
        <?php endif; ?>

        <!-- ========================================== -->
        <!-- 6. QUICK ASSESSMENT & DIAGNOSTIC FUNNEL    -->
        <!-- ========================================== -->
        <?php 
        include get_template_directory() . '/blocks/assessment/assessment.php'; 
        ?>

    </div>
</main>

<?php get_footer(); ?>
