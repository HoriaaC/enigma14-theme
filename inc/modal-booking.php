<?php
/**
 * Global Booking & Photo Diagnostic Popup Modal
 * Fully editable via ACF Setări Site (Options Page)
 *
 * @package Enigma14
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render the Booking Modal in wp_footer
 */
function enigma14_render_booking_modal() {
    if (is_admin()) {
        return;
    }

    // Contact settings from Site Settings
    $phone_1 = function_exists('get_field') ? get_field('phone_1', 'option') : '0722 000 114';
    $whatsapp_num = function_exists('get_field') ? (get_field('whatsapp_number', 'option') ?: $phone_1) : $phone_1;
    $whatsapp_clean = preg_replace('/[^0-9]/', '', $whatsapp_num ?: '40722000114');
    if (strlen($whatsapp_clean) === 10 && substr($whatsapp_clean, 0, 2) === '07') {
        $whatsapp_clean = '4' . $whatsapp_clean;
    }

    // Modal texts from ACF
    $badge_text         = function_exists('get_field') ? (get_field('modal_badge_text', 'option') ?: 'DIAGNOZĂ OPTICĂ & PROGRAMARE RAPIDĂ') : 'DIAGNOZĂ OPTICĂ & PROGRAMARE RAPIDĂ';
    $badge_icon         = function_exists('get_field') ? (get_field('modal_badge_icon', 'option') ?: 'precision_manufacturing') : 'precision_manufacturing';
    $title              = function_exists('get_field') ? (get_field('modal_title', 'option') ?: 'Trimite Poza Cheii sau Solicită Asistență') : 'Trimite Poza Cheii sau Solicită Asistență';
    $subtitle           = function_exists('get_field') ? (get_field('modal_subtitle', 'option') ?: 'Încarcă o poză clară cu cheia sau butucul tău și alege când dorești să ajungi la atelier. Tehnicienii noștri îți confirmă pe loc disponibilitatea și timpul de execuție.') : 'Încarcă o poză clară cu cheia sau butucul tău și alege când dorești să ajungi la atelier. Tehnicienii noștri îți confirmă pe loc disponibilitatea și timpul de execuție.';
    
    $dropzone_title     = function_exists('get_field') ? (get_field('modal_dropzone_title', 'option') ?: 'Încarcă sau Fotografiază Cheia (Opțional)') : 'Încarcă sau Fotografiază Cheia (Opțional)';
    $dropzone_subtitle  = function_exists('get_field') ? (get_field('modal_dropzone_subtitle', 'option') ?: 'Apasă aici sau trage poza direct (JPG, PNG, WEBP, HEIC)') : 'Apasă aici sau trage poza direct (JPG, PNG, WEBP, HEIC)';
    
    $label_name         = function_exists('get_field') ? (get_field('modal_label_name', 'option') ?: 'Numele Tău (Opțional)') : 'Numele Tău (Opțional)';
    $label_phone        = function_exists('get_field') ? (get_field('modal_label_phone', 'option') ?: 'Număr de Telefon *') : 'Număr de Telefon *';
    $label_service      = function_exists('get_field') ? (get_field('modal_label_service', 'option') ?: 'Tip Serviciu Solicitat') : 'Tip Serviciu Solicitat';
    $label_time         = function_exists('get_field') ? (get_field('modal_label_time', 'option') ?: 'Interval Orar / Când dorești să vii?') : 'Interval Orar / Când dorești să vii?';
    $label_notes        = function_exists('get_field') ? (get_field('modal_label_notes', 'option') ?: 'Detalii Adiționale / Marcă & Model Mașină sau Producător Yală (Opțional)') : 'Detalii Adiționale / Marcă & Model Mașină sau Producător Yală (Opțional)';
    
    $submit_btn_text    = function_exists('get_field') ? (get_field('modal_submit_btn_text', 'option') ?: 'Trimite Solicitarea de Programare') : 'Trimite Solicitarea de Programare';
    $whatsapp_btn_text  = function_exists('get_field') ? (get_field('modal_whatsapp_btn_text', 'option') ?: 'Sau Trimite Direct pe WhatsApp') : 'Sau Trimite Direct pe WhatsApp';
    $privacy_note       = function_exists('get_field') ? (get_field('modal_privacy_note', 'option') ?: 'Datele și fotografiile transmise sunt confidențiale și utilizate exclusiv pentru diagnoza tehnică.') : 'Datele și fotografiile transmise sunt confidențiale și utilizate exclusiv pentru diagnoza tehnică.';
    
    // Parse Service Options
    $services_raw = function_exists('get_field') ? get_field('modal_services_options', 'option') : '';
    if (empty(trim($services_raw))) {
        $services_options = array(
            'Copiere / Programare Cheie Auto cu Cip',
            'Copiere Cheie Rezidențială / Amprentă / Yală',
            'Duplicare Cartelă Interfon / Tag RFID',
            'Înlocuire / Recalibrare Butuc Ușă Blindată',
            'Reparație Carcasă / Lamă Cheie',
            'Deblocare / Urgență Lăcătușerie'
        );
    } else {
        $services_options = array_filter(array_map('trim', explode("\n", $services_raw)));
    }

    // Parse Time Options
    $time_raw = function_exists('get_field') ? get_field('modal_time_options', 'option') : '';
    if (empty(trim($time_raw))) {
        $time_options = array(
            'Azi - În timpul programului atelierului',
            'Azi - Urgență la apel',
            'Mâine - Dimineață (08:30 - 13:00)',
            'Mâine - După-amiază (13:00 - 19:30)',
            'În weekend (Sâmbătă 09:00 - 15:00)',
            'Altă zi / Nu sunt sigur (specifică în detalii)'
        );
    } else {
        $time_options = array_filter(array_map('trim', explode("\n", $time_raw)));
    }

    // Default WhatsApp direct jump link
    $wa_direct_jump = "https://wa.me/{$whatsapp_clean}?text=" . rawurlencode('Buna ziua, doresc o programare / diagnoza foto la atelierul ENIGMA 14');

    // Current page info
    $current_page_url   = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $current_page_title = is_singular() ? get_the_title() : (is_tax() ? single_term_title('', false) : get_bloginfo('name'));
    ?>

    <!-- ======================================================== -->
    <!-- ENIGMA 14 GLOBAL BOOKING & PHOTO DIAGNOSTIC POPUP MODAL  -->
    <!-- ======================================================== -->
    <div id="enigma-booking-modal" class="fixed inset-0 z-[9999] flex items-center justify-center p-3 sm:p-5 bg-black/85 backdrop-blur-md hidden opacity-0 transition-opacity duration-300 overflow-y-auto" role="dialog" aria-modal="true" aria-labelledby="modal-title">
        
        <!-- Backdrop click surface to close -->
        <div class="fixed inset-0 cursor-pointer enigma-close-modal" aria-hidden="true"></div>

        <!-- Modal Dialog Card -->
        <div class="relative z-10 w-full max-w-2xl bg-surface-container-low border border-surface-container-highest/80 rounded-xl shadow-[0_16px_60px_rgba(0,0,0,0.9)] overflow-hidden my-auto transform transition-transform duration-300 scale-95" style="font-family: var(--wp--preset--font-family--inter);">
            
            <!-- Orange Ambient Top Accent -->
            <div class="h-1.5 w-full bg-gradient-to-r from-primary-container via-secondary to-primary-container"></div>
            
            <!-- Close 'X' Button -->
            <button type="button" class="enigma-close-modal absolute top-3 right-3 text-outline hover:text-on-surface hover:bg-surface-container-high p-2 rounded-lg transition-colors cursor-pointer z-20" aria-label="Închide fereastra">
                <span class="material-symbols-outlined text-[24px]">close</span>
            </button>

            <div class="p-space-md sm:p-space-lg max-h-[90vh] overflow-y-auto space-y-space-md">
                
                <!-- Modal Header -->
                <div class="space-y-space-2xs pr-8">
                    <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-surface-container border border-primary-container/40">
                        <span class="material-symbols-outlined text-primary-container text-[16px]"><?php echo esc_html($badge_icon); ?></span>
                        <span class="font-label-badge text-[10px] uppercase tracking-widest text-primary font-bold"><?php echo esc_html($badge_text); ?></span>
                    </div>

                    <h3 id="modal-title" class="font-headline-xl text-headline-xl uppercase text-on-surface tracking-tight font-bold" style="font-family: var(--wp--preset--font-family--montserrat);">
                        <?php echo esc_html($title); ?>
                    </h3>

                    <?php if ($subtitle): ?>
                    <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                        <?php echo nl2br(esc_html($subtitle)); ?>
                    </p>
                    <?php endif; ?>
                </div>

                <!-- Main Booking & Photo Form -->
                <form id="enigma-booking-form" class="space-y-space-sm" enctype="multipart/form-data" method="POST">
                    
                    <input type="hidden" name="booking_nonce" value="<?php echo esc_attr(wp_create_nonce('enigma14_booking_action')); ?>" />
                    <input type="hidden" name="page_url" value="<?php echo esc_attr($current_page_url); ?>" />
                    <input type="hidden" name="page_title" value="<?php echo esc_attr($current_page_title); ?>" />

                    <!-- Error Alert Banner -->
                    <div class="enigma-modal-error hidden p-space-xs rounded bg-red-950/50 border border-red-500/60 text-red-200 text-xs font-semibold"></div>

                    <!-- 1. Interactive Drag & Drop Photo Zone -->
                    <div class="enigma-dropzone-wrapper">
                        <input type="file" name="booking_photo" id="enigma-modal-file" accept="image/*" class="hidden" />
                        
                        <div id="enigma-modal-dropzone" class="border-2 border-dashed border-surface-container-highest hover:border-primary-container/80 bg-surface-container/60 hover:bg-surface-container rounded-lg p-space-sm sm:p-space-md text-center cursor-pointer transition-all duration-200 group">
                            
                            <!-- Initial Dropzone State -->
                            <div id="enigma-dropzone-idle" class="flex flex-col items-center gap-1.5">
                                <div class="w-10 h-10 rounded-full bg-surface-container-highest flex items-center justify-center text-primary-container group-hover:scale-110 transition-transform">
                                    <span class="material-symbols-outlined text-[24px]">add_a_photo</span>
                                </div>
                                <span class="font-label-action text-[13px] text-on-surface uppercase font-bold tracking-wider block">
                                    <?php echo esc_html($dropzone_title); ?>
                                </span>
                                <span class="text-[11px] text-outline block">
                                    <?php echo esc_html($dropzone_subtitle); ?>
                                </span>
                            </div>

                            <!-- Selected Preview State -->
                            <div id="enigma-dropzone-preview" class="hidden flex items-center justify-between gap-space-sm p-space-xs bg-surface-container-high rounded border border-primary-container/40">
                                <div class="flex items-center gap-space-xs overflow-hidden">
                                    <img id="enigma-preview-thumb" src="" alt="Previzualizare" class="w-12 h-12 object-cover rounded border border-surface-container-highest shrink-0" />
                                    <div class="text-left overflow-hidden">
                                        <span id="enigma-preview-filename" class="text-on-surface font-mono text-xs block truncate font-semibold">imagine.jpg</span>
                                        <span id="enigma-preview-size" class="text-outline text-[11px] block">1.2 MB</span>
                                        <span id="enigma-upload-status" class="text-[11px] block mt-0.5"></span>
                                    </div>
                                </div>
                                <button type="button" id="enigma-remove-file" class="text-outline hover:text-red-400 p-1.5 rounded transition-colors cursor-pointer" title="Șterge poza">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                </button>
                            </div>

                        </div>
                    </div>

                    <!-- 2. Two-column Input Fields: Contact Info -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-xs">
                        <div>
                            <label class="block font-label-badge text-label-badge uppercase text-outline mb-1"><?php echo esc_html($label_name); ?></label>
                            <input type="text" name="client_name" class="w-full bg-surface p-space-xs text-on-surface text-body-md rounded border border-surface-container-highest focus:border-primary-container focus:outline-none transition-colors" placeholder="ex: Radu Popescu" />
                        </div>
                        <div>
                            <label class="block font-label-badge text-label-badge uppercase text-outline mb-1"><?php echo esc_html($label_phone); ?></label>
                            <input type="tel" name="phone" required class="w-full bg-surface p-space-xs text-on-surface text-body-md rounded border border-surface-container-highest focus:border-primary-container focus:outline-none transition-colors" placeholder="07xx xxx xxx" />
                        </div>
                    </div>

                    <!-- 3. Service Type & Time Window -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-xs">
                        <div>
                            <label class="block font-label-badge text-label-badge uppercase text-outline mb-1"><?php echo esc_html($label_service); ?></label>
                            <select name="service_type" class="w-full bg-surface p-space-xs text-on-surface text-body-md rounded border border-surface-container-highest focus:border-primary-container focus:outline-none transition-colors">
                                <?php foreach ($services_options as $srv_opt): ?>
                                    <option value="<?php echo esc_attr($srv_opt); ?>"><?php echo esc_html($srv_opt); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block font-label-badge text-label-badge uppercase text-outline mb-1"><?php echo esc_html($label_time); ?></label>
                            <select name="preferred_time" class="w-full bg-surface p-space-xs text-on-surface text-body-md rounded border border-surface-container-highest focus:border-primary-container focus:outline-none transition-colors">
                                <?php foreach ($time_options as $time_opt): ?>
                                    <option value="<?php echo esc_attr($time_opt); ?>"><?php echo esc_html($time_opt); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- 4. Notes / Specs Input -->
                    <div>
                        <label class="block font-label-badge text-label-badge uppercase text-outline mb-1"><?php echo esc_html($label_notes); ?></label>
                        <input type="text" name="notes" class="w-full bg-surface p-space-xs text-on-surface text-body-md rounded border border-surface-container-highest focus:border-primary-container focus:outline-none transition-colors" placeholder="ex: Cheie VW Golf 7 an 2018 / Butuc Mottura Champions..." />
                    </div>

                    <!-- 5. Action Buttons Grid -->
                    <div class="pt-space-2xs flex flex-col sm:flex-row items-stretch sm:items-center gap-space-xs">
                        
                        <!-- Primary Submit Button -->
                        <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 bg-primary-container hover:bg-secondary-container text-on-primary-container font-label-action text-label-action py-space-sm px-space-md rounded uppercase tracking-wider font-bold shadow-md shadow-primary-container/20 transition-all cursor-pointer">
                            <span class="material-symbols-outlined text-[18px] btn-icon">send</span>
                            <span class="btn-text"><?php echo esc_html($submit_btn_text); ?></span>
                        </button>

                        <!-- Direct WhatsApp Jump Button -->
                        <a href="<?php echo esc_url($wa_direct_jump); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2 bg-[#25D366] hover:bg-[#20ba59] text-white font-label-action text-label-action py-space-sm px-space-md rounded uppercase tracking-wider font-bold transition-all shadow-md shadow-[#25D366]/20">
                            <span class="material-symbols-outlined text-[18px]">chat</span>
                            <span class="whitespace-nowrap"><?php echo esc_html($whatsapp_btn_text); ?></span>
                        </a>

                    </div>

                    <!-- Privacy Footnote -->
                    <p class="text-[11px] text-outline text-center flex items-center justify-center gap-1 pt-1">
                        <span class="material-symbols-outlined text-primary-container text-[14px]">lock</span>
                        <span><?php echo esc_html($privacy_note); ?></span>
                    </p>

                </form>

                <!-- 6. Success View (Hidden initially) -->
                <div id="enigma-booking-success" class="hidden p-space-lg text-center space-y-space-sm animate-fade-in">
                    <div class="w-14 h-14 mx-auto rounded-full bg-primary-container/20 flex items-center justify-center text-primary-container shadow-[0_0_24px_rgba(255,119,0,0.35)]">
                        <span class="material-symbols-outlined text-[36px]">check_circle</span>
                    </div>
                    
                    <h4 class="font-headline-xl uppercase text-on-surface font-bold text-[18px] tracking-wide" style="font-family: var(--wp--preset--font-family--montserrat);">
                        <?php echo esc_html(function_exists('get_field') ? (get_field('modal_success_title', 'option') ?: 'Solicitare Înregistrată cu Succes!') : 'Solicitare Înregistrată cu Succes!'); ?>
                    </h4>
                    
                    <p class="font-body-md text-body-md text-on-surface-variant max-w-md mx-auto leading-relaxed">
                        <?php echo nl2br(esc_html(function_exists('get_field') ? (get_field('modal_success_message', 'option') ?: 'Un tehnician ENIGMA 14 a recepționat detaliile tale și te va contacta în cel mai scurt timp pentru confirmare.') : 'Un tehnician ENIGMA 14 a recepționat detaliile tale și te va contacta în cel mai scurt timp pentru confirmare.')); ?>
                    </p>

                    <div class="pt-space-xs flex flex-col sm:flex-row items-center justify-center gap-space-xs max-w-md mx-auto">
                        <a id="enigma-success-wa-link" href="#" target="_blank" rel="noopener noreferrer" class="w-full sm:w-auto flex-1 inline-flex items-center justify-center gap-2 py-space-sm px-space-md rounded bg-[#25D366] hover:bg-[#20ba59] text-white font-label-action text-label-action uppercase tracking-wider font-bold transition-all shadow-lg shadow-[#25D366]/30">
                            <span class="material-symbols-outlined text-[18px]">chat</span>
                            <span>Deschide și pe WhatsApp</span>
                        </a>
                        <button type="button" class="enigma-close-modal w-full sm:w-auto inline-flex items-center justify-center px-space-md py-space-sm rounded bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-label-action text-label-action uppercase font-bold tracking-wider transition-colors cursor-pointer">
                            <span>Închide</span>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <?php
}
add_action('wp_footer', 'enigma14_render_booking_modal', 99);

/**
 * Handle Booking Modal AJAX Submission
 */
function enigma14_handle_booking_modal_submission() {
    // Nonce Check
    if (!isset($_POST['booking_nonce']) || !wp_verify_nonce($_POST['booking_nonce'], 'enigma14_booking_action')) {
        wp_send_json_error(array('message' => 'Sesiunea a expirat. Te rugăm să reîncarci pagina și să încerci din nou.'));
    }

    $phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
    if (empty($phone)) {
        wp_send_json_error(array('message' => 'Numărul de telefon este obligatoriu.'));
    }

    $client_name    = isset($_POST['client_name']) ? sanitize_text_field($_POST['client_name']) : '';
    $service_type   = isset($_POST['service_type']) ? sanitize_text_field($_POST['service_type']) : '';
    $preferred_time = isset($_POST['preferred_time']) ? sanitize_text_field($_POST['preferred_time']) : '';
    $notes          = isset($_POST['notes']) ? sanitize_text_field($_POST['notes']) : '';
    $page_url       = isset($_POST['page_url']) ? esc_url_raw($_POST['page_url']) : '';
    $page_title     = isset($_POST['page_title']) ? sanitize_text_field($_POST['page_title']) : '';

    // Recipient email from Site Settings
    $to_email = function_exists('get_field') ? get_field('email', 'option') : '';
    if (empty($to_email) || !is_email($to_email)) {
        $to_email = 'comenzi@centruldechei.ro';
    }

    // WhatsApp number from Site Settings
    $phone_1 = function_exists('get_field') ? get_field('phone_1', 'option') : '0722 000 114';
    $whatsapp_num = function_exists('get_field') ? (get_field('whatsapp_number', 'option') ?: $phone_1) : $phone_1;
    $whatsapp_clean = preg_replace('/[^0-9]/', '', $whatsapp_num ?: '40722000114');
    if (strlen($whatsapp_clean) === 10 && substr($whatsapp_clean, 0, 2) === '07') {
        $whatsapp_clean = '4' . $whatsapp_clean;
    }

    // Handle File Upload if present
    $attachments = array();
    $uploaded_file_url = '';
    if (!empty($_FILES['booking_photo']['name'])) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        $uploaded_file = wp_handle_upload($_FILES['booking_photo'], array('test_form' => false));
        
        if (isset($uploaded_file['file']) && !isset($uploaded_file['error'])) {
            $attachments[] = $uploaded_file['file'];
            $uploaded_file_url = isset($uploaded_file['url']) ? $uploaded_file['url'] : '';
        }
    }

    // Build Email Body
    $subject = "[ENIGMA 14 - Programare & Diagnoză] Solicitare de la " . ($client_name ?: $phone);

    $body  = "Ai primit o nouă solicitare de programare & identificare foto de pe site:\n\n";
    $body .= "--------------------------------------------------\n";
    if ($client_name)    $body .= "Nume Client: {$client_name}\n";
    $body .= "Telefon: {$phone}\n";
    if ($service_type)   $body .= "Serviciu Solicitat: {$service_type}\n";
    if ($preferred_time) $body .= "Interval Preferat: {$preferred_time}\n";
    if ($notes)          $body .= "Detalii / Note: {$notes}\n";
    if ($uploaded_file_url) $body .= "Foto Atașată: {$uploaded_file_url}\n";
    $body .= "--------------------------------------------------\n";
    if ($page_title)     $body .= "Trimis de pe pagina: {$page_title} ({$page_url})\n";
    $body .= "Data & Ora: " . current_time('d.m.Y H:i') . "\n";

    // Sender identity for notifications sent to owners
    $from_name  = 'Client - ENIGMA 14';
    $from_email = 'client@centruldechei.ro';

    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . $from_name . ' <' . $from_email . '>',
        'Reply-To: ' . $from_name . ' <' . $from_email . '>',
    );

    // Send email with attachment
    $mail_sent = wp_mail($to_email, $subject, $body, $headers, $attachments);

    // Build pre-filled WhatsApp message
    $wa_msg = "Buna ziua, doresc o programare / diagnoza ENIGMA 14:\n";
    if ($client_name)       $wa_msg .= "• Nume: {$client_name}\n";
    $wa_msg .= "• Telefon: {$phone}\n";
    if ($service_type)      $wa_msg .= "• Serviciu: {$service_type}\n";
    if ($preferred_time)    $wa_msg .= "• Când doresc să vin: {$preferred_time}\n";
    if ($notes)             $wa_msg .= "• Detalii: {$notes}\n";
    if ($uploaded_file_url) $wa_msg .= "• Foto piesă/cheie: {$uploaded_file_url}\n";

    $whatsapp_url = "https://wa.me/{$whatsapp_clean}?text=" . rawurlencode($wa_msg);

    wp_send_json_success(array(
        'message'      => 'Solicitarea ta a fost transmisă cu succes! Te vom contacta în scurt timp.',
        'whatsapp_url' => $whatsapp_url,
        'mail_sent'    => $mail_sent
    ));
}
add_action('wp_ajax_enigma14_submit_modal_booking', 'enigma14_handle_booking_modal_submission');
add_action('wp_ajax_nopriv_enigma14_submit_modal_booking', 'enigma14_handle_booking_modal_submission');

/**
 * Handle Quick Background Photo Upload for WhatsApp & Diagnoza
 */
function enigma14_handle_quick_photo_upload() {
    $nonce = isset($_POST['upload_nonce']) ? $_POST['upload_nonce'] : '';
    if (!wp_verify_nonce($nonce, 'enigma14_photo_upload_action') && !wp_verify_nonce($nonce, 'enigma14_booking_action')) {
        wp_send_json_error(array('message' => 'Sesiune de încărcare invalidă sau expirată.'));
    }

    $file_field = '';
    if (!empty($_FILES['photo']['name'])) {
        $file_field = 'photo';
    } elseif (!empty($_FILES['booking_photo']['name'])) {
        $file_field = 'booking_photo';
    }

    if (empty($file_field)) {
        wp_send_json_error(array('message' => 'Niciun fișier imagine recepționat.'));
    }

    $allowed_mimes = array(
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif'          => 'image/gif',
        'png'          => 'image/png',
        'webp'         => 'image/webp',
        'heic'         => 'image/heic',
    );

    $file_info = wp_check_filetype($_FILES[$file_field]['name'], $allowed_mimes);
    if (empty($file_info['ext'])) {
        wp_send_json_error(array('message' => 'Format nepermis. Se acceptă doar imagini (JPG, PNG, WEBP, HEIC).'));
    }

    require_once(ABSPATH . 'wp-admin/includes/file.php');
    $upload_overrides = array('test_form' => false, 'mimes' => $allowed_mimes);
    $uploaded_file = wp_handle_upload($_FILES[$file_field], $upload_overrides);

    if (isset($uploaded_file['file']) && !isset($uploaded_file['error'])) {
        wp_send_json_success(array(
            'url'      => esc_url_raw($uploaded_file['url']),
            'filename' => sanitize_file_name(basename($uploaded_file['file'])),
            'message'  => 'Imagine încărcată cu succes.'
        ));
    } else {
        $error = isset($uploaded_file['error']) ? $uploaded_file['error'] : 'Eroare la procesarea fișierului.';
        wp_send_json_error(array('message' => $error));
    }
}
add_action('wp_ajax_enigma14_quick_photo_upload', 'enigma14_handle_quick_photo_upload');
add_action('wp_ajax_nopriv_enigma14_quick_photo_upload', 'enigma14_handle_quick_photo_upload');
