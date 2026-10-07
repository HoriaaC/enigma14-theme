<?php
/**
 * Block: Despre Noi, Tehnologie & Experiență (ENIGMA 14)
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param (int|string) $post_id The post ID this block is saved to.
 */

// Left Column: Header & Narrative
$badge_icon  = get_field('about_badge_icon') ?: 'precision_manufacturing';
$badge_text  = get_field('about_badge_text') ?: 'TEHNOLOGIE, EXPERIENȚĂ & DISCIPLINA PRECIZIEI';
$title       = get_field('about_title') ?: 'Peste 10 Ani de Experiență';
$subtitle    = get_field('about_subtitle') ?: 'Atelier Mecatronic de Elită în Inima Bucureștiului';
$text_p1     = get_field('about_text_p1') ?: 'Fondat pe principiul toleranțelor zero și al decodării exacte, <strong class="text-on-surface">ENIGMA 14</strong> redefinește noțiunea clasică de copiere chei prin fuziunea dintre lăcătușeria tradițională de mare finețe și mecatronica auto de ultimă generație.';
$text_p2     = get_field('about_text_p2') ?: 'Folosim mașini CNC laser cu citire optică (Silca Futura, Keyline Liger) care nu multiplică uzura mecanică a cheii vechi, ci reconstruiesc direct profilul original din fabrică după codul bitting al producătorului. Dacă o cheie copiată la noi nu funcționează ireproșabil, o recalibrăm sau o refacem gratuit, pe loc.';

// 3 Feature Cards
$c1_icon     = get_field('about_c1_icon') ?: 'speed';
$c1_title    = get_field('about_c1_title') ?: 'Serviciu Rapid';
$c1_desc     = get_field('about_c1_desc') ?: 'Duplicare standard în sub 5 minute. Nu lași cheia, pleci direct cu ea funcțională.';

$c2_icon     = get_field('about_c2_icon') ?: 'verified_user';
$c2_title    = get_field('about_c2_title') ?: 'Calitate Garantată';
$c2_desc     = get_field('about_c2_desc') ?: 'Blank-uri din aliaj titanat și carcase OEM ce rezistă la peste 50.000 cicluri de rotire.';

$c3_icon     = get_field('about_c3_icon') ?: 'memory';
$c3_title    = get_field('about_c3_title') ?: 'Experți Mecatronică';
$c3_desc     = get_field('about_c3_desc') ?: 'Tehnicieni autorizați specializați în decodare transponder și sisteme anti-furt.';

// Right Column: Image & Realtime Stats
$image_url   = get_field('about_image');
if (empty($image_url)) {
    $image_url = 'https://lh3.googleusercontent.com/aida-public/AB6AXuAlw1gbXJN692Mi4z8r5_w-OzQ3Gu4Whr3opX34QbdB0Ej1UvrXtMX6vSTO1Y-9zsOrdN3jlC-Th2s9Lpwr1rKDzDV1wYlSf5fMSiyNxGAIfawz-rwhfQDwUpVVznnz51tKeu5Zi1OznalWIY4tLdeu3rs04qv2DcUyboXAUVkcLaVErt12l7BB-cc5oSR8aqBBlAl8X3dUwMpYzUoq30ttk0tX2CEFshQFtf4jH5j8uJ7LgGWwcArk';
}
$image_alt   = get_field('about_image_alt') ?: 'Atelier mecatronic ENIGMA 14 masina CNC copiere chei cu laser';
$audit_label = get_field('about_audit_label') ?: 'AUDIT TEHNIC ENIGMA 14';
$audit_badge = get_field('about_audit_badge') ?: 'VERIFICAT 2025';

$stat1_val   = get_field('about_stat1_val') ?: '99.8%';
$stat1_label = get_field('about_stat1_label') ?: 'Rată Succes';

$stat2_val   = get_field('about_stat2_val') ?: '35k+';
$stat2_label = get_field('about_stat2_label') ?: 'Chei Copiate';

$stat3_val   = get_field('about_stat3_val') ?: '< 5m';
$stat3_label = get_field('about_stat3_label') ?: 'Timp Mediu';

// Block ID & Classes
$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = ' id="' . esc_attr($block['anchor']) . '"';
}
$custom_class = !empty($block['className']) ? ' ' . $block['className'] : '';
?>
<section<?php echo $anchor; ?> class="w-full bg-surface-container-low py-space-3xl relative<?php echo esc_attr($custom_class); ?>">
    <div class="max-w-[1280px] mx-auto px-gutter-mobile lg:px-gutter-desktop">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-2xl items-center">
            
            <!-- Left Column: Story & Principles -->
            <div class="lg:col-span-7 space-y-space-lg">
                <div class="space-y-space-2xs">
                    <?php if ($badge_text): ?>
                    <span class="text-primary-container font-label-badge text-label-badge uppercase tracking-widest flex items-center gap-2">
                        <span class="material-symbols-outlined text-[16px]"><?php echo esc_html($badge_icon); ?></span>
                        <span><?php echo esc_html($badge_text); ?></span>
                    </span>
                    <?php endif; ?>

                    <?php if ($title): ?>
                    <h2 class="font-headline-xl text-headline-xl uppercase font-bold text-on-surface tracking-tight">
                        <?php echo esc_html($title); ?>
                    </h2>
                    <?php endif; ?>

                    <?php if ($subtitle): ?>
                    <p class="font-headline-sm text-headline-sm text-primary uppercase">
                        <?php echo esc_html($subtitle); ?>
                    </p>
                    <?php endif; ?>
                </div>

                <div class="space-y-space-sm font-body-md text-body-md text-on-surface-variant leading-relaxed">
                    <?php if ($text_p1): ?>
                    <p>
                        <?php echo wp_kses_post($text_p1); ?>
                    </p>
                    <?php endif; ?>

                    <?php if ($text_p2): ?>
                    <p>
                        <?php echo wp_kses_post($text_p2); ?>
                    </p>
                    <?php endif; ?>
                </div>

                <!-- Feature Cards Triad -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-space-sm pt-space-xs">
                    
                    <!-- Card 1: Serviciu Rapid -->
                    <div class="p-space-sm rounded-lg bg-surface-container space-y-space-2xs">
                        <div class="w-10 h-10 rounded bg-surface-container-high flex items-center justify-center text-primary-container">
                            <span class="material-symbols-outlined text-[22px]"><?php echo esc_html($c1_icon); ?></span>
                        </div>
                        <h4 class="font-headline-sm text-headline-sm text-on-surface uppercase text-[15px]"><?php echo esc_html($c1_title); ?></h4>
                        <p class="font-body-sm text-body-sm text-on-surface-variant"><?php echo esc_html($c1_desc); ?></p>
                    </div>

                    <!-- Card 2: Calitate Garantată -->
                    <div class="p-space-sm rounded-lg bg-surface-container space-y-space-2xs">
                        <div class="w-10 h-10 rounded bg-surface-container-high flex items-center justify-center text-primary-container">
                            <span class="material-symbols-outlined text-[22px]"><?php echo esc_html($c2_icon); ?></span>
                        </div>
                        <h4 class="font-headline-sm text-headline-sm text-on-surface uppercase text-[15px]"><?php echo esc_html($c2_title); ?></h4>
                        <p class="font-body-sm text-body-sm text-on-surface-variant"><?php echo esc_html($c2_desc); ?></p>
                    </div>

                    <!-- Card 3: Experți Mecatronică -->
                    <div class="p-space-sm rounded-lg bg-surface-container space-y-space-2xs">
                        <div class="w-10 h-10 rounded bg-surface-container-high flex items-center justify-center text-primary-container">
                            <span class="material-symbols-outlined text-[22px]"><?php echo esc_html($c3_icon); ?></span>
                        </div>
                        <h4 class="font-headline-sm text-headline-sm text-on-surface uppercase text-[15px]"><?php echo esc_html($c3_title); ?></h4>
                        <p class="font-body-sm text-body-sm text-on-surface-variant"><?php echo esc_html($c3_desc); ?></p>
                    </div>

                </div>
            </div>

            <!-- Right Column: Visual Workshop Frame & Realtime Stats -->
            <div class="lg:col-span-5 relative">
                <div class="relative rounded-xl overflow-hidden shadow-2xl bg-surface-container">
                    <div class="w-full h-[460px] bg-cover bg-center" style="background-image: url('<?php echo esc_url($image_url); ?>')" role="img" aria-label="<?php echo esc_attr($image_alt); ?>"></div>
                    <!-- Dark Gradient Scrim -->
                    <div class="absolute inset-0 bg-gradient-to-t from-surface-container-lowest via-transparent to-transparent pointer-events-none"></div>
                    
                    <!-- Floating Overlay Card with Metrics -->
                    <div class="absolute bottom-4 left-4 right-4 p-space-md rounded-lg bg-surface-container-lowest/90 backdrop-blur-md space-y-space-xs">
                        <div class="flex items-center justify-between">
                            <span class="font-label-badge text-label-badge uppercase tracking-wider text-primary"><?php echo esc_html($audit_label); ?></span>
                            <?php if ($audit_badge): ?>
                            <span class="inline-flex items-center gap-1 font-body-sm text-body-sm text-secondary-container">
                                <span class="w-2 h-2 rounded-full bg-secondary-container animate-pulse"></span> <?php echo esc_html($audit_badge); ?>
                            </span>
                            <?php endif; ?>
                        </div>
                        <div class="grid grid-cols-3 gap-space-xs pt-space-2xs text-center">
                            <div class="p-space-2xs rounded bg-surface-container">
                                <p class="font-headline-md text-headline-md text-primary-container font-extrabold"><?php echo esc_html($stat1_val); ?></p>
                                <p class="font-body-sm text-body-sm text-on-surface-variant"><?php echo esc_html($stat1_label); ?></p>
                            </div>
                            <div class="p-space-2xs rounded bg-surface-container">
                                <p class="font-headline-md text-headline-md text-on-surface font-extrabold"><?php echo esc_html($stat2_val); ?></p>
                                <p class="font-body-sm text-body-sm text-on-surface-variant"><?php echo esc_html($stat2_label); ?></p>
                            </div>
                            <div class="p-space-2xs rounded bg-surface-container">
                                <p class="font-headline-md text-headline-md text-secondary-container font-extrabold"><?php echo esc_html($stat3_val); ?></p>
                                <p class="font-body-sm text-body-sm text-on-surface-variant"><?php echo esc_html($stat3_label); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
