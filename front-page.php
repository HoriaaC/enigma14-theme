<?php
/**
 * Template Name: Homepage
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<?php
$hero_bg_desktop = get_field('hero_bg_desktop');
$hero_bg_mobile  = get_field('hero_bg_mobile') ?: $hero_bg_desktop;
?>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if ($hero_bg_desktop): ?>
    <link rel="preload" as="image" href="<?php echo esc_url($hero_bg_desktop); ?>" media="(min-width: 768px)" fetchpriority="high">
    <?php endif; ?>
    <?php if ($hero_bg_mobile): ?>
    <link rel="preload" as="image" href="<?php echo esc_url($hero_bg_mobile); ?>" media="(max-width: 767.98px)" fetchpriority="high">
    <?php endif; ?>
    <?php wp_head(); ?>
</head>
<body <?php body_class('bg-surface font-body-md text-on-surface antialiased selection:bg-primary-container selection:text-on-primary-container'); ?>>
<?php wp_body_open(); ?>

<?php echo do_blocks('<!-- wp:template-part {"slug":"header"} /-->'); ?>

<main class="w-full bg-surface min-h-[calc(100vh-110px)] pt-36 md:pt-[145px]">
    <div class="flex flex-col w-full text-on-surface">
        
        <?php 
        // --- HERO SECTION ---
        // Fetch ACF Fields
        $hero_badge = get_field('hero_badge');
        $hero_location = get_field('hero_location');
        $hero_time = get_field('hero_time');
        $hero_pre_title = get_field('hero_pre_title');
        $hero_title = get_field('hero_title');
        $hero_subtitle = get_field('hero_subtitle');

        // 3 Hardware Badges (CNC, Speed, Storage)
        $hero_box1_icon = get_field('hero_box1_icon') ?: 'straighten';
        $hero_box1_title = get_field('hero_box1_title');
        $hero_box1_subtitle = get_field('hero_box1_subtitle');

        $hero_box2_icon = get_field('hero_box2_icon') ?: 'bolt';
        $hero_box2_title = get_field('hero_box2_title');
        $hero_box2_subtitle = get_field('hero_box2_subtitle');

        $hero_box3_icon = get_field('hero_box3_icon') ?: 'inventory_2';
        $hero_box3_title = get_field('hero_box3_title');
        $hero_box3_subtitle = get_field('hero_box3_subtitle');

        $has_hero_boxes = !empty($hero_box1_title) || !empty($hero_box2_title) || !empty($hero_box3_title);

        $hero_btn1 = get_field('hero_button_primary');
        $hero_btn2 = get_field('hero_button_secondary');

        // Metrology Line (Bottom)
        $hero_equipment = get_field('hero_equipment');
        $hero_partners_label = get_field('hero_partners_label');
        $hero_partners_text = get_field('hero_partners_text');
        
        if($hero_title):
        ?>
        <section class="relative w-full overflow-hidden bg-surface-container-lowest">
            <!-- Atmospheric Ambient Overlays -->
            <div class="absolute inset-0 bg-gradient-to-r from-surface-container-lowest via-surface-container-lowest/90 to-transparent z-10"></div>
            <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-primary-container/10 blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 right-0 w-[500px] h-[500px] rounded-full bg-secondary-container/5 blur-3xl pointer-events-none"></div>
            
            <!-- Workshop Master Photography Background (Discoverable LCP Image with fetchpriority=high) -->
            <picture class="absolute inset-0 z-0 pointer-events-none select-none overflow-hidden">
                <?php if ($hero_bg_desktop): ?>
                    <source media="(min-width: 768px)" srcset="<?php echo esc_url($hero_bg_desktop); ?>">
                <?php endif; ?>
                <img src="<?php echo esc_url($hero_bg_mobile ?: $hero_bg_desktop); ?>" 
                     alt="<?php echo esc_attr($hero_title ?: 'Atelier Mecatronic ENIGMA 14'); ?>" 
                     fetchpriority="high" 
                     loading="eager" 
                     decoding="async" 
                     class="hero-bg w-full h-full object-cover object-center opacity-40 transition-all duration-300">
            </picture>
            
            <div class="relative z-20 max-w-[1280px] mx-auto px-gutter-desktop py-space-3xl flex flex-col justify-between min-h-[620px]">
                
                <!-- Top Technical Status Line -->
                <div class="flex flex-wrap items-center justify-between gap-space-sm pb-space-lg">
                    <?php if($hero_badge): ?>
                    <div class="flex items-center gap-space-xs bg-surface-container-high/90 px-space-sm py-space-2xs rounded backdrop-blur-md">
                        <span class="inline-block w-2.5 h-2.5 rounded-full bg-primary-container shadow-[0_0_10px_#ff7700] animate-pulse"></span>
                        <span class="font-label-badge text-label-badge uppercase tracking-[0.12em] text-on-surface"><?php echo esc_html($hero_badge); ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <div class="hidden lg:flex items-center gap-space-md font-body-sm text-body-sm text-on-surface-variant">
                        <?php if($hero_location): ?>
                        <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-primary-container text-[18px]">verified</span> <?php echo esc_html($hero_location); ?></span>
                        <?php endif; ?>
                        
                        <?php if($hero_time): ?>
                        <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-primary-container text-[18px]">timer</span> <?php echo esc_html($hero_time); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Center Headline Block -->
                <div class="max-w-3xl space-y-space-md my-auto">
                    <?php if($hero_pre_title): ?>
                    <div class="inline-flex items-center gap-2 px-space-xs py-space-2xs rounded bg-surface-container text-primary font-label-badge text-label-badge uppercase tracking-wider">
                        <span class="material-symbols-outlined text-[16px] text-primary-container">lock_reset</span>
                        <?php echo esc_html($hero_pre_title); ?>
                    </div>
                    <?php endif; ?>
                    
                    <h1 class="font-display-lg text-display-lg font-extrabold uppercase text-on-surface tracking-tight leading-none">
                        <?php echo wp_kses_post($hero_title); ?>
                    </h1>
                    
                    <?php if($hero_subtitle): ?>
                    <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl leading-relaxed">
                        <?php echo nl2br(esc_html($hero_subtitle)); ?>
                    </p>
                    <?php endif; ?>

                    <?php if($has_hero_boxes): ?>
                    <!-- Hardware Badges Group (3 Boxes) -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-space-xs pt-space-xs">
                        <?php if(!empty($hero_box1_title)): ?>
                        <div class="flex items-center gap-space-xs p-space-xs rounded bg-surface-container/80 backdrop-blur-sm">
                            <?php if(!empty($hero_box1_icon)): ?>
                            <span class="material-symbols-outlined text-primary-container text-[22px] shrink-0"><?php echo esc_html($hero_box1_icon); ?></span>
                            <?php endif; ?>
                            <div>
                                <p class="font-label-badge text-label-badge uppercase text-on-surface"><?php echo esc_html($hero_box1_title); ?></p>
                                <?php if(!empty($hero_box1_subtitle)): ?>
                                <p class="font-body-sm text-body-sm text-secondary-container font-semibold"><?php echo esc_html($hero_box1_subtitle); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if(!empty($hero_box2_title)): ?>
                        <div class="flex items-center gap-space-xs p-space-xs rounded bg-surface-container/80 backdrop-blur-sm">
                            <?php if(!empty($hero_box2_icon)): ?>
                            <span class="material-symbols-outlined text-primary-container text-[22px] shrink-0"><?php echo esc_html($hero_box2_icon); ?></span>
                            <?php endif; ?>
                            <div>
                                <p class="font-label-badge text-label-badge uppercase text-on-surface"><?php echo esc_html($hero_box2_title); ?></p>
                                <?php if(!empty($hero_box2_subtitle)): ?>
                                <p class="font-body-sm text-body-sm text-secondary-container font-semibold"><?php echo esc_html($hero_box2_subtitle); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if(!empty($hero_box3_title)): ?>
                        <div class="flex items-center gap-space-xs p-space-xs rounded bg-surface-container/80 backdrop-blur-sm">
                            <?php if(!empty($hero_box3_icon)): ?>
                            <span class="material-symbols-outlined text-primary-container text-[22px] shrink-0"><?php echo esc_html($hero_box3_icon); ?></span>
                            <?php endif; ?>
                            <div>
                                <p class="font-label-badge text-label-badge uppercase text-on-surface"><?php echo esc_html($hero_box3_title); ?></p>
                                <?php if(!empty($hero_box3_subtitle)): ?>
                                <p class="font-body-sm text-body-sm text-secondary-container font-semibold"><?php echo esc_html($hero_box3_subtitle); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    
                    <div class="flex flex-wrap items-center gap-space-md pt-space-xs">
                        <?php if($hero_btn1): ?>
                        <a href="<?php echo esc_url($hero_btn1['url']); ?>" target="<?php echo esc_attr(!empty($hero_btn1['target']) ? $hero_btn1['target'] : '_self'); ?>" class="group flex items-center justify-center gap-2 bg-primary-container hover:bg-secondary-container text-on-primary-container font-label-action text-label-action uppercase tracking-wider px-space-lg py-space-sm rounded transition-all duration-300 shadow-[0_0_24px_rgba(255,119,0,0.3)] hover:shadow-[0_0_32px_rgba(255,165,4,0.4)]">
                            <?php echo esc_html($hero_btn1['title']); ?>
                            <span class="material-symbols-outlined text-[18px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </a>
                        <?php endif; ?>
                        
                        <?php if($hero_btn2): ?>
                        <a href="<?php echo esc_url($hero_btn2['url']); ?>" target="<?php echo esc_attr(!empty($hero_btn2['target']) ? $hero_btn2['target'] : '_self'); ?>" class="flex items-center justify-center gap-2 bg-surface-container-high hover:bg-surface-variant text-on-surface font-label-action text-label-action uppercase tracking-wider px-space-lg py-space-sm rounded transition-all duration-300 border border-surface-container-highest">
                            <span class="material-symbols-outlined text-[18px] text-error">emergency</span>
                            <?php echo esc_html($hero_btn2['title']); ?>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if(!empty($hero_equipment) || !empty($hero_partners_text)): ?>
                <!-- Subtle Key Metrology Line -->
                <div class="pt-space-xl flex flex-wrap items-center justify-between gap-space-md text-on-surface-variant font-body-sm text-body-sm">
                    <?php if(!empty($hero_equipment)): ?>
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary-container"></span>
                        <span><?php echo esc_html($hero_equipment); ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if(!empty($hero_partners_text)): ?>
                    <div class="flex items-center gap-4">
                        <?php if(!empty($hero_partners_label)): ?>
                        <span class="text-on-surface font-semibold"><?php echo esc_html($hero_partners_label); ?></span>
                        <?php endif; ?>
                        <span class="tracking-wider text-outline uppercase font-label-badge"><?php echo esc_html($hero_partners_text); ?></span>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                
            </div>
        </section>
        <?php endif; ?>

        <!-- PAGE CONTENT (Gutenberg blocks below hero) -->
        <div class="w-full">
            <?php 
            while (have_posts()) : the_post();
                the_content();
            endwhile; 
            ?>
        </div>
        
    </div>
</main>

<?php get_footer(); ?>
