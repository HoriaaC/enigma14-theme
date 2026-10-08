<?php
/**
 * AJAX Handler for ENIGMA 14 Contact & Key Diagnostic Form
 *
 * @package Enigma14
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handle Contact Form Submission via AJAX
 */
function enigma14_handle_contact_form_submission() {
    // Verify nonce
    $nonce = isset($_POST['contact_nonce']) ? $_POST['contact_nonce'] : '';
    if (!wp_verify_nonce($nonce, 'enigma14_contact_action') && !wp_verify_nonce($nonce, 'enigma14_assessment_action')) {
        wp_send_json_error(array('message' => 'Sesiunea a expirat. Te rugăm să reîncarci pagina și să încerci din nou.'));
    }

    $phone = isset($_POST['contact_phone']) ? sanitize_text_field($_POST['contact_phone']) : '';
    if (empty($phone)) {
        wp_send_json_error(array('message' => 'Numărul de telefon este obligatoriu pentru a te putea contacta.'));
    }

    $name         = isset($_POST['contact_name']) ? sanitize_text_field($_POST['contact_name']) : '';
    $service_type = isset($_POST['service_type']) ? sanitize_text_field($_POST['service_type']) : '';
    $notes        = isset($_POST['contact_notes']) ? sanitize_textarea_field($_POST['contact_notes']) : '';
    $photo_url    = isset($_POST['uploaded_photo_url']) ? esc_url_raw($_POST['uploaded_photo_url']) : '';
    $page_url     = isset($_POST['page_url']) ? esc_url_raw($_POST['page_url']) : '';

    // Handle direct file upload if present and not previously uploaded
    $attachments = array();
    if (!empty($_FILES['key_photo']['name'])) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        $uploaded = wp_handle_upload($_FILES['key_photo'], array('test_form' => false));
        if (isset($uploaded['file']) && !isset($uploaded['error'])) {
            $attachments[] = $uploaded['file'];
            if (empty($photo_url) && isset($uploaded['url'])) {
                $photo_url = $uploaded['url'];
            }
        }
    }

    // Determine recipient email
    $to_email = '';
    if (function_exists('get_field')) {
        $to_email = get_field('email', 'option');
    }
    if (empty($to_email) || !is_email($to_email)) {
        $to_email = 'comenzi@centruldechei.ro';
    }

    // Determine WhatsApp recipient number
    $whatsapp_num = '';
    if (function_exists('get_field')) {
        $whatsapp_num = get_field('whatsapp_number', 'option');
        if (empty($whatsapp_num)) {
            $whatsapp_num = get_field('phone_1', 'option');
        }
    }
    $whatsapp_clean = preg_replace('/[^0-9]/', '', $whatsapp_num ?: '40722000114');
    if (strlen($whatsapp_clean) === 10 && substr($whatsapp_clean, 0, 2) === '07') {
        $whatsapp_clean = '4' . $whatsapp_clean;
    }

    // Build Email
    $client_identifier = $name ? "{$name} ({$phone})" : $phone;
    $subject = "[ENIGMA 14 - Solicitare Ofertă & Diagnoză] {$client_identifier}";

    $message_body = "Ai primit o nouă solicitare din pagina de Contact & Localizare Atelier ENIGMA 14:\n\n";
    $message_body .= "--------------------------------------------------\n";
    if ($name) {
        $message_body .= "Nume Client: {$name}\n";
    }
    $message_body .= "Număr Telefon: {$phone}\n";
    $message_body .= "Serviciu Solicitat: " . ($service_type ?: 'Nespecificat') . "\n";
    if ($notes) {
        $message_body .= "Detalii / Note: {$notes}\n";
    }
    if ($photo_url) {
        $message_body .= "Fotografie Cheie Atașată: {$photo_url}\n";
    }
    $message_body .= "--------------------------------------------------\n";
    if ($page_url) {
        $message_body .= "Pagină sursă: {$page_url}\n";
    }
    $message_body .= "Data & Ora recepției: " . current_time('d.m.Y H:i') . "\n";

    // Sender identity for notifications sent to owners
    $from_name  = 'Client - ENIGMA 14';
    $from_email = 'client@centruldechei.ro';

    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . $from_name . ' <' . $from_email . '>',
        'Reply-To: ' . $from_name . ' <' . $from_email . '>',
    );

    // Send email
    $mail_sent = wp_mail($to_email, $subject, $message_body, $headers, $attachments);

    // Build pre-filled WhatsApp link
    $wa_msg = "Buna ziua, trimit o solicitare din pagina de Contact ENIGMA 14:\n";
    if ($name)         $wa_msg .= "• Nume: {$name}\n";
    $wa_msg .= "• Telefon: {$phone}\n";
    if ($service_type) $wa_msg .= "• Serviciu: {$service_type}\n";
    if ($notes)        $wa_msg .= "• Detalii: {$notes}\n";
    if ($photo_url)    $wa_msg .= "• Foto cheie: {$photo_url}\n";

    $whatsapp_url = "https://wa.me/{$whatsapp_clean}?text=" . rawurlencode($wa_msg);

    wp_send_json_success(array(
        'message'      => 'Solicitarea a fost recepționată! Un tehnician ENIGMA 14 analizează fotografia și te va apela în cel mai scurt timp.',
        'whatsapp_url' => $whatsapp_url,
        'mail_sent'    => $mail_sent
    ));
}
add_action('wp_ajax_enigma14_submit_contact_form', 'enigma14_handle_contact_form_submission');
add_action('wp_ajax_nopriv_enigma14_submit_contact_form', 'enigma14_handle_contact_form_submission');

