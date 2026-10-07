<?php
/**
 * Standalone Under Construction / Maintenance Page Template
 *
 * @package Enigma14
 */

if (!defined('ABSPATH')) {
    exit;
}

// Fetch Under Construction settings from ACF Options
$image_data     = function_exists('get_field') ? get_field('under_construction_image', 'option') : null;
$max_width      = function_exists('get_field') ? (get_field('under_construction_max_width', 'option') ?: '680px') : '680px';
$bg_color       = function_exists('get_field') ? (get_field('under_construction_bg_color', 'option') ?: '#0b0c10') : '#0b0c10';
$title          = function_exists('get_field') ? get_field('under_construction_title', 'option') : '';
$message        = function_exists('get_field') ? get_field('under_construction_message', 'option') : '';
$show_contact   = function_exists('get_field') ? get_field('under_construction_show_contact', 'option') : false;

// Resolve image URL accurately (supports Array, Attachment ID, or URL string)
$image_url = '';
$image_alt = 'ENIGMA 14 - În Lucru';

if (!empty($image_data)) {
    if (is_array($image_data)) {
        $image_url = !empty($image_data['url']) ? $image_data['url'] : '';
        $image_alt = !empty($image_data['alt']) ? $image_data['alt'] : 'Site în Lucru';
    } elseif (is_numeric($image_data)) {
        $image_url = wp_get_attachment_image_url($image_data, 'full');
        $alt = get_post_meta($image_data, '_wp_attachment_image_alt', true);
        if ($alt) $image_alt = $alt;
    } elseif (is_string($image_data)) {
        $image_url = $image_data;
    }
}

// Fallback to site logo if no image is uploaded
if (empty($image_url)) {
    $logo_data = function_exists('get_field') ? get_field('site_logo', 'option') : null;
    if (!empty($logo_data)) {
        if (is_array($logo_data)) {
            $image_url = !empty($logo_data['url']) ? $logo_data['url'] : '';
        } elseif (is_numeric($logo_data)) {
            $image_url = wp_get_attachment_image_url($logo_data, 'full');
        } elseif (is_string($logo_data)) {
            $image_url = $logo_data;
        }
        $image_alt = 'ENIGMA 14 Logo';
    }
}

// Contact info from Site Settings
$phone_1        = function_exists('get_field') ? (get_field('phone_1', 'option') ?: '0722 000 114') : '0722 000 114';
$phone_clean    = preg_replace('/[^0-9+]/', '', $phone_1);

$whatsapp_num   = function_exists('get_field') ? (get_field('whatsapp_number', 'option') ?: $phone_1) : $phone_1;
$whatsapp_clean = preg_replace('/[^0-9]/', '', $whatsapp_num ?: '40722000114');
if (strlen($whatsapp_clean) === 10 && substr($whatsapp_clean, 0, 2) === '07') {
    $whatsapp_clean = '4' . $whatsapp_clean;
}
$whatsapp_url   = "https://wa.me/{$whatsapp_clean}?text=" . rawurlencode('Buna ziua, va contactez de pe site-ul ENIGMA 14');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title><?php echo esc_html(get_bloginfo('name') . ' • Site în Lucru / Mentenanță'); ?></title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">

    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        html, body {
            width: 100%;
            height: 100%;
            min-height: 100vh;
        }
        body {
            background-color: <?php echo esc_attr($bg_color); ?>;
            color: #e2e2ec;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.25rem;
            text-align: center;
            position: relative;
            overflow-x: hidden;
        }
        /* Ambient subtle background glow */
        .ambient-glow {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: min(85vw, 650px);
            height: min(85vw, 650px);
            background: radial-gradient(circle, rgba(255, 119, 0, 0.14) 0%, rgba(255, 119, 0, 0) 70%);
            pointer-events: none;
            z-index: 0;
        }
        .main-wrapper {
            position: relative;
            z-index: 10;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            max-width: 1100px;
            margin: auto;
        }
        .image-container {
            width: 100%;
            max-width: <?php echo esc_attr($max_width); ?>;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: <?php echo ($title || $message || $show_contact) ? '1.75rem' : '0'; ?>;
        }
        .centered-image {
            max-width: 100%;
            max-height: 75vh;
            height: auto;
            display: block;
            margin: 0 auto;
            object-fit: contain;
            border-radius: 8px;
            filter: drop-shadow(0 15px 35px rgba(0, 0, 0, 0.65));
            transition: transform 0.3s ease;
        }
        .content-box {
            max-width: 680px;
            margin: 0 auto;
        }
        .page-title {
            font-family: 'Montserrat', sans-serif;
            font-size: clamp(1.4rem, 4vw, 2.25rem);
            font-weight: 800;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: -0.02em;
            margin-bottom: 0.75rem;
            line-height: 1.25;
        }
        .page-message {
            font-size: clamp(0.95rem, 2vw, 1.125rem);
            color: #9d9ea8;
            line-height: 1.6;
            margin-bottom: 1.75rem;
        }
        .contact-actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-top: 1rem;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            text-decoration: none;
            transition: all 0.2s ease;
            box-shadow: 0 4px 16px rgba(0,0,0,0.4);
        }
        .btn-primary {
            background-color: #ff7700;
            color: #000000;
            box-shadow: 0 0 24px rgba(255, 119, 0, 0.35);
        }
        .btn-primary:hover {
            background-color: #ff9100;
            transform: translateY(-2px);
            box-shadow: 0 0 32px rgba(255, 119, 0, 0.5);
        }
        .btn-wa {
            background-color: #25D366;
            color: #ffffff;
            box-shadow: 0 4px 20px rgba(37, 211, 102, 0.25);
        }
        .btn-wa:hover {
            background-color: #20ba59;
            transform: translateY(-2px);
            box-shadow: 0 4px 28px rgba(37, 211, 102, 0.45);
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.35rem 0.85rem;
            border-radius: 9999px;
            background: rgba(255, 119, 0, 0.12);
            border: 1px solid rgba(255, 119, 0, 0.3);
            color: #ff7700;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 1.25rem;
        }
        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #ff7700;
            box-shadow: 0 0 8px #ff7700;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.4; transform: scale(0.85); }
        }
        .footer-note {
            margin-top: 2rem;
            font-size: 0.75rem;
            color: #636573;
            letter-spacing: 0.02em;
        }
    </style>
</head>
<body>

    <!-- Ambient background orange aura -->
    <div class="ambient-glow"></div>

    <div class="main-wrapper">
        
        <!-- Centered Uploaded Image -->
        <?php if (!empty($image_url)): ?>
            <div class="image-container">
                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>" class="centered-image" />
            </div>
        <?php endif; ?>

        <!-- Optional Content Section -->
        <?php if ($title || $message || $show_contact): ?>
            <div class="content-box">

                <?php if ($title): ?>
                    <div class="status-badge">
                        <span class="status-dot"></span>
                        <span><?php _e('MENTENANȚĂ & ACTUALIZĂRI', 'enigma14'); ?></span>
                    </div>

                    <h1 class="page-title"><?php echo esc_html($title); ?></h1>
                <?php endif; ?>

                <?php if ($message): ?>
                    <p class="page-message"><?php echo nl2br(esc_html($message)); ?></p>
                <?php endif; ?>

                <?php if ($show_contact): ?>
                    <div class="contact-actions">
                        <a href="tel:<?php echo esc_attr($phone_clean); ?>" class="btn btn-primary">
                            <span class="material-symbols-outlined" style="font-size: 18px;">phone</span>
                            <span><?php _e('Sună Acum:', 'enigma14'); ?> <?php echo esc_html($phone_1); ?></span>
                        </a>

                        <a href="<?php echo esc_url($whatsapp_url); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-wa">
                            <span class="material-symbols-outlined" style="font-size: 18px;">chat</span>
                            <span><?php _e('Contact WhatsApp', 'enigma14'); ?></span>
                        </a>
                    </div>
                <?php endif; ?>

            </div>
        <?php endif; ?>

        <div class="footer-note">
            &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php _e('Toate drepturile rezervate.', 'enigma14'); ?>
        </div>

    </div>

</body>
</html>

