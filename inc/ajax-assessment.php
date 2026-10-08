<?php
/**
 * AJAX Handler for ENIGMA 14 Assessment & Diagnostic Forms
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handle Assessment Form Submission via AJAX
 */
function enigma14_handle_assessment_submission() {
    // Check nonce for security
    if (!isset($_POST['assessment_nonce']) || !wp_verify_nonce($_POST['assessment_nonce'], 'enigma14_assessment_action')) {
        wp_send_json_error(array('message' => 'Sesiune expirată. Te rugăm să reîncarci pagina și să încerci din nou.'));
    }

    $phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
    if (empty($phone)) {
        wp_send_json_error(array('message' => 'Numărul de telefon este obligatoriu.'));
    }

    $form_mode     = isset($_POST['form_mode']) ? sanitize_text_field($_POST['form_mode']) : 'auto';
    $field_1       = isset($_POST['field_1']) ? sanitize_text_field($_POST['field_1']) : '';
    $field_2       = isset($_POST['field_2']) ? sanitize_text_field($_POST['field_2']) : '';
    $service_type  = isset($_POST['service_type']) ? sanitize_text_field($_POST['service_type']) : '';
    $page_url      = isset($_POST['page_url']) ? esc_url_raw($_POST['page_url']) : '';
    $page_title    = isset($_POST['page_title']) ? sanitize_text_field($_POST['page_title']) : '';

    // Field labels depending on mode
    if ($form_mode === 'residential') {
        $label_1 = 'Tip Cheie / Yală / Producător';
        $label_2 = 'Cartelă de Securitate / Serie';
        $subject_prefix = '[ENIGMA 14 - Chei Rezidențiale]';
    } else {
        $label_1 = 'Marca & Modelul Mașinii';
        $label_2 = 'An Fabricație';
        $subject_prefix = '[ENIGMA 14 - Chei Auto]';
    }

    // Determine recipient email
    $to_email = isset($_POST['recipient_email']) && is_email($_POST['recipient_email']) ? sanitize_email($_POST['recipient_email']) : '';
    if (empty($to_email) && function_exists('get_field')) {
        $to_email = get_field('email', 'option');
    }
    if (empty($to_email) || !is_email($to_email)) {
        $to_email = 'comenzi@centruldechei.ro';
    }

    // Determine WhatsApp recipient number
    $whatsapp_num = isset($_POST['whatsapp_number']) ? sanitize_text_field($_POST['whatsapp_number']) : '';
    if (empty($whatsapp_num) && function_exists('get_field')) {
        $whatsapp_num = get_field('whatsapp_number', 'option');
        if (empty($whatsapp_num)) {
            $whatsapp_num = get_field('phone_1', 'option');
        }
    }
    $whatsapp_num_clean = preg_replace('/[^0-9]/', '', $whatsapp_num ?: '40722000114');
    if (strlen($whatsapp_num_clean) === 10 && substr($whatsapp_num_clean, 0, 2) === '07') {
        $whatsapp_num_clean = '4' . $whatsapp_num_clean;
    }

    // Build subject and message
    $subject = "{$subject_prefix} Solicitare de la {$phone} - {$field_1}";

    $message_body = "Ai primit o nouă solicitare de evaluare rapidă de pe site-ul ENIGMA 14:\n\n";
    $message_body .= "--------------------------------------------------\n";
    $message_body .= "Telefon Client: {$phone}\n";
    $message_body .= "{$label_1}: " . ($field_1 ?: 'Nespecificat') . "\n";
    $message_body .= "{$label_2}: " . ($field_2 ?: 'Nespecificat') . "\n";
    $message_body .= "Tip Serviciu Solicitat: " . ($service_type ?: 'Nespecificat') . "\n";
    $message_body .= "--------------------------------------------------\n";
    if ($page_title) {
        $message_body .= "Trimis de pe pagina: {$page_title} ({$page_url})\n";
    }
    $message_body .= "Data & Ora: " . current_time('d.m.Y H:i') . "\n";

    // Sender identity for notifications sent to owners
    $from_name  = 'Client - ENIGMA 14';
    $from_email = 'client@centruldechei.ro';

    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . $from_name . ' <' . $from_email . '>',
        'Reply-To: ' . $from_name . ' <' . $from_email . '>',
    );

    // Send email
    $mail_sent = wp_mail($to_email, $subject, $message_body, $headers);

    // Build WhatsApp formatted message for direct jump
    $wa_text = "Buna ziua, doresc o evaluare rapida ENIGMA 14:\n";
    if ($field_1) $wa_text .= "• {$label_1}: {$field_1}\n";
    if ($field_2) $wa_text .= "• {$label_2}: {$field_2}\n";
    if ($service_type) $wa_text .= "• Serviciu: {$service_type}\n";
    $wa_text .= "• Telefon: {$phone}";

    $whatsapp_url = "https://wa.me/{$whatsapp_num_clean}?text=" . rawurlencode($wa_text);

    wp_send_json_success(array(
        'message'      => 'Cererea ta a fost transmisă cu succes! Un tehnician ENIGMA 14 te va contacta în cel mai scurt timp.',
        'whatsapp_url' => $whatsapp_url,
        'mail_sent'    => $mail_sent
    ));
}
add_action('wp_ajax_enigma14_submit_assessment', 'enigma14_handle_assessment_submission');
add_action('wp_ajax_nopriv_enigma14_submit_assessment', 'enigma14_handle_assessment_submission');
