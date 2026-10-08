<?php
/**
 * Register ACF Custom Blocks for ENIGMA 14
 */

if (!defined('ABSPATH')) {
    exit;
}

function enigma14_register_acf_blocks() {
    // Check if ACF is active
    if (!function_exists('acf_register_block_type')) {
        return;
    }

    // 1. Homepage Hero Block
    acf_register_block_type(array(
        'name'              => 'enigma-hero',
        'title'             => __('ENIGMA Hero Banner', 'enigma14'),
        'description'       => __('Sectiunea principala Hero cu background si butoane CTAs.', 'enigma14'),
        'render_template'   => 'blocks/hero/hero.php',
        'category'          => 'design',
        'icon'              => 'cover-image',
        'keywords'          => array('hero', 'banner', 'enigma', 'header'),
        'supports'          => array(
            'align' => array('full'),
            'mode' => true,
            'jsx' => true
        ),
        'align'         => 'full'
    ));

    // 2. Header Block
    acf_register_block_type(array(
        'name'              => 'enigma-header',
        'title'             => __('ENIGMA Header', 'enigma14'),
        'description'       => __('Global Header Navbar (Top bar, logo, and menu).', 'enigma14'),
        'render_template'   => 'blocks/header/header.php',
        'category'          => 'design',
        'icon'              => 'menu',
        'keywords'          => array('header', 'nav', 'menu'),
        'supports'          => array(
            'align' => array('full'),
            'mode' => false, // Prevents switching to edit mode so it's always rendered
            'jsx' => true
        ),
        'align'         => 'full'
    ));

    // 3. Services Grid Block (Divizii Mecatronice)
    acf_register_block_type(array(
        'name'              => 'enigma-services-grid',
        'title'             => __('ENIGMA Divizii & Servicii Grid', 'enigma14'),
        'description'       => __('Grila cu divizii mecatronice, categorii CPT si servicii selectabile.', 'enigma14'),
        'render_template'   => 'blocks/services-grid/services-grid.php',
        'category'          => 'design',
        'icon'              => 'grid-view',
        'keywords'          => array('servicii', 'categorii', 'grid', 'divizii', 'enigma'),
        'supports'          => array(
            'align' => array('full', 'wide'),
            'mode' => true,
            'jsx' => true
        ),
        'align'         => 'full'
    ));

    // 4. About & Workshop Block (Experiență & Mecatronică)
    acf_register_block_type(array(
        'name'              => 'enigma-about',
        'title'             => __('ENIGMA Despre Noi & Tehnologie', 'enigma14'),
        'description'       => __('Sectiunea Despre Noi, tehnologie CNC, mașini laser și statistici atelier mecatronic.', 'enigma14'),
        'render_template'   => 'blocks/about/about.php',
        'category'          => 'design',
        'icon'              => 'hammer',
        'keywords'          => array('despre', 'about', 'experienta', 'enigma', 'tehnologie', 'workshop'),
        'supports'          => array(
            'align' => array('full', 'wide'),
            'mode' => true,
            'jsx' => true
        ),
        'align'         => 'full'
    ));

    // 5. Global Footer Block
    acf_register_block_type(array(
        'name'              => 'enigma-footer',
        'title'             => __('ENIGMA Footer', 'enigma14'),
        'description'       => __('Global Footer (Despre Noi, Contact, Meniu Categorii & Copyright).', 'enigma14'),
        'render_template'   => 'blocks/footer/footer.php',
        'category'          => 'design',
        'icon'              => 'admin-site-alt3',
        'keywords'          => array('footer', 'subsol', 'enigma', 'categorii', 'contact'),
        'supports'          => array(
            'align' => array('full'),
            'mode'  => false,
            'jsx'   => true
        ),
        'align'         => 'full'
    ));

    // 6. Quick Assessment & Diagnostic Form Block
    acf_register_block_type(array(
        'name'              => 'enigma-quick-assessment',
        'title'             => __('ENIGMA Evaluare Rapidă & Diagnoză', 'enigma14'),
        'description'       => __('Caseta de evaluare rapidă cu micro-formular mecatronic (auto sau rezidențial) și asistență WhatsApp.', 'enigma14'),
        'render_template'   => 'blocks/assessment/assessment.php',
        'category'          => 'design',
        'icon'              => 'forms',
        'keywords'          => array('evaluare', 'formular', 'diagnoza', 'auto', 'rezidential', 'whatsapp', 'enigma'),
        'supports'          => array(
            'align' => array('full', 'wide'),
            'mode'  => true,
            'jsx'   => true
        ),
        'align'         => 'full'
    ));
}
add_action('acf/init', 'enigma14_register_acf_blocks');

// Register the Field Group for the Hero Block via PHP
function enigma14_hero_block_fields() {
    if( function_exists('acf_add_local_field_group') ):

        acf_add_local_field_group(array(
            'key' => 'group_enigma_hero_block',
            'title' => 'Block: Hero Banner',
            'fields' => array(
                array(
                    'key' => 'field_hero_badge',
                    'label' => 'Badge Text (Top)',
                    'name' => 'hero_badge',
                    'type' => 'text',
                    'default_value' => 'CENTRUL TEHNIC SPECIALIZAT DE DUPLICARE ȘI DECODARE',
                ),
                array(
                    'key' => 'field_hero_title_line_1',
                    'label' => 'Titlu (Linia 1 - Alb)',
                    'name' => 'hero_title_1',
                    'type' => 'text',
                    'default_value' => 'Servicii Complete',
                ),
                array(
                    'key' => 'field_hero_title_line_2',
                    'label' => 'Titlu (Linia 2 - Orange)',
                    'name' => 'hero_title_2',
                    'type' => 'text',
                    'default_value' => 'de Copiere Chei',
                ),
                array(
                    'key' => 'field_hero_description',
                    'label' => 'Descriere scurtă',
                    'name' => 'hero_desc',
                    'type' => 'textarea',
                    'rows' => 3,
                    'default_value' => 'Precizie și calitate garantată prin mecatronică de înaltă finețe, decodare optico-laser computerizată și programare transponder pe banc.',
                ),
                array(
                    'key' => 'field_hero_bg_image',
                    'label' => 'Imagine Fundal (Background)',
                    'name' => 'hero_bg_image',
                    'type' => 'image',
                    'return_format' => 'url',
                ),
                array(
                    'key' => 'field_hero_btn_1_text',
                    'label' => 'Text Buton Principal (Portocaliu)',
                    'name' => 'hero_btn_1_text',
                    'type' => 'text',
                    'default_value' => 'CERE O OFERTĂ ACUM',
                ),
                array(
                    'key' => 'field_hero_btn_1_link',
                    'label' => 'Link Buton Principal',
                    'name' => 'hero_btn_1_link',
                    'type' => 'url',
                    'default_value' => '#solicita-oferta',
                )
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'block',
                        'operator' => '==',
                        'value' => 'acf/enigma-hero',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        ));
        
    endif;
}
add_action('acf/init', 'enigma14_hero_block_fields');
