<?php
/**
 * Block: Evaluare Rapidă & Diagnoză Tehnică (ENIGMA 14)
 * Context-aware form (Auto & Moto vs. Rezidențial vs. Ghid Foto) with AJAX email & WhatsApp integration.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param (int|string) $post_id The post ID this block is saved to.
 */

// 1. Detect Context / Form Mode
$queried_obj = get_queried_object();
$detected_mode = 'auto';

if ($queried_obj && isset($queried_obj->taxonomy) && $queried_obj->taxonomy === 'categorie_serviciu') {
    if (strpos($queried_obj->slug, 'rezidential') !== false || strpos($queried_obj->slug, 'yale') !== false || strpos($queried_obj->slug, 'lacate') !== false) {
        $detected_mode = 'residential';
    }
} elseif (is_singular('serviciu')) {
    $terms = get_the_terms(get_the_ID(), 'categorie_serviciu');
    if (!empty($terms) && !is_wp_error($terms)) {
        if (strpos($terms[0]->slug, 'rezidential') !== false || strpos($terms[0]->slug, 'yale') !== false) {
            $detected_mode = 'residential';
        }
    }
}

$form_mode = get_field('qa_form_mode') ?: $detected_mode;

// 2. Global Contacts Fallback
$whatsapp_num = get_field('qa_whatsapp_number');
if (empty($whatsapp_num) && function_exists('get_field')) {
    $whatsapp_num = get_field('whatsapp_number', 'option') ?: get_field('phone_1', 'option');
}
$whatsapp_clean = preg_replace('/[^0-9]/', '', $whatsapp_num ?: '40722000114');
if (strlen($whatsapp_clean) === 10 && substr($whatsapp_clean, 0, 2) === '07') {
    $whatsapp_clean = '4' . $whatsapp_clean;
}

$recipient_email = get_field('qa_recipient_email');
if (empty($recipient_email) && function_exists('get_field')) {
    $recipient_email = get_field('email', 'option') ?: get_option('admin_email');
}

// 3. Left Column Content
$badge_icon = get_field('qa_badge_icon');
if (empty($badge_icon)) {
    $badge_icon = ($form_mode === 'residential') ? 'photo_camera' : 'help';
}
$badge_text = get_field('qa_badge_text');
if (empty($badge_text)) {
    $badge_text = ($form_mode === 'residential') ? 'IDENTIFICARE OPTICĂ INSTANTANEE' : 'EVALUARE RAPIDĂ FĂRĂ COSTURI';
}

$title = get_field('qa_title');
if (empty($title)) {
    if ($form_mode === 'residential') {
        $title = 'Ai nevoie de o dublură sau schimbi butucul?';
    } else {
        $title = 'Ai pierdut cheia sau ai nevoie de o dublură auto?';
    }
}

$description = get_field('qa_description');
if (empty($description)) {
    if ($form_mode === 'residential') {
        $description = 'Nu ești sigur ce tip de profil sau butuc folosește ușa ta? Trimite-ne o poză clară a cheii sau a butucului tău. Echipa noastră de tehnicieni identifică profilul exact și îți confirmă disponibilitatea pe loc, fără deplasări inutile.';
    } else {
        $description = 'Nu ești sigur ce tip de cip sau lamă folosește mașina ta? Trimite-ne o poză clară cu cheia existentă sau certificatul mașinii. Echipa noastră de tehnicieni îți confirmă modelul și disponibilitatea exactă pe loc.';
    }
}

$btn_wa_text    = get_field('qa_btn_whatsapp_text') ?: 'TRIMITE PE WHATSAPP';
$btn_sec_text   = get_field('qa_btn_secondary_text') ?: 'MERGI LA CONTACT & IDENTIFICARE FOTO';
$btn_sec_url    = get_field('qa_btn_secondary_url') ?: '#solicita-oferta';

// Pre-filled WhatsApp URL for the static button
$default_wa_message = ($form_mode === 'residential')
    ? 'Buna ziua, doresc o verificare pentru copierea unei chei de locuinta / butuc'
    : 'Buna ziua, doresc o verificare pentru copiere cheie auto';
$wa_direct_url = "https://wa.me/{$whatsapp_clean}?text=" . rawurlencode($default_wa_message);

// Contact quick info
$display_phone = function_exists('get_field') ? (get_field('phone_1', 'option') ?: '0722 000 114') : '0722 000 114';

// 4. Right Form Labels
$card_title    = get_field('qa_form_card_title') ?: 'Solicită Asistență Rapidă';
$response_time = get_field('qa_form_response_time') ?: 'Timp răspuns: < 15 min';
$btn_submit    = get_field('qa_submit_button_text') ?: 'Trimite Spre Verificare';

// 5. Mode 3: Photo Instructions Advice Card Fields
$photo_card_title   = get_field('qa_photo_card_title') ?: 'Instrucțiuni Foto';
$photo_badge_time   = get_field('qa_photo_badge_time') ?: 'Confirmare: < 5 min';
$photo_heading      = get_field('qa_photo_heading') ?: 'CUM SĂ FOTOGRAFIEZI CHEIA:';
$photo_step_1       = get_field('qa_photo_step_1') ?: 'Așază cheia pe o suprafață plană, bine iluminată.';
$photo_step_2       = get_field('qa_photo_step_2') ?: 'Asigură-te că profilul zimților sau amprentelor este focalizat clar.';
$photo_step_3       = get_field('qa_photo_step_3') ?: 'Dacă deții cartela de securitate, trimite și codul alfanumeric.';
$photo_security     = get_field('qa_photo_security_note') ?: 'Datele tale sunt confidențiale și protejate';
$photo_btn_text     = get_field('qa_photo_btn_text') ?: 'Trimite Poza pe WhatsApp';

// Page info for email tracking
$current_page_url   = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$current_page_title = is_singular() ? get_the_title() : (is_tax() ? single_term_title('', false) : get_bloginfo('name'));

// Block ID & Classes
$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = ' id="' . esc_attr($block['anchor']) . '"';
} else {
    $anchor = ' id="solicita-evaluare"';
}
$custom_class = !empty($block['className']) ? ' ' . $block['className'] : '';
?>
<section<?php echo $anchor; ?> class="w-full py-space-3xl bg-surface relative<?php echo esc_attr($custom_class); ?>" style="font-family: var(--wp--preset--font-family--inter);">
    <div id="solicita-duplicare" class="absolute -top-24 pointer-events-none"></div>
    <div class="max-w-[1280px] mx-auto px-gutter-mobile lg:px-gutter-desktop">
        <div class="p-space-lg sm:p-space-2xl rounded bg-surface-container shadow-2xl relative overflow-hidden" style="border: 2px dashed #ff7700; box-shadow: 0 0 24px -4px rgba(255, 119, 0, 0.35);">
            <!-- Ambient corner glow -->
            <div class="absolute -right-20 -top-20 w-64 h-64 bg-primary-container/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-space-xl items-center">
                
                <!-- Left Column: Narrative & Action Links (7 cols) -->
                <div class="lg:col-span-7 space-y-space-md">
                    <div class="inline-flex items-center gap-2 px-space-xs py-1 bg-surface-container-highest rounded">
                        <span class="material-symbols-outlined text-primary-container text-[16px]"><?php echo esc_html($badge_icon); ?></span>
                        <span class="font-label-badge text-label-badge uppercase tracking-wider text-on-surface"><?php echo esc_html($badge_text); ?></span>
                    </div>

                    <h3 class="font-headline-xl text-headline-xl text-on-surface uppercase tracking-tight font-bold" style="font-family: var(--wp--preset--font-family--montserrat);">
                        <?php echo esc_html($title); ?>
                    </h3>

                    <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed">
                        <?php echo nl2br(esc_html($description)); ?>
                    </p>

                    <div class="flex flex-wrap items-center gap-space-md pt-space-xs">
                        <a class="inline-flex items-center gap-2 bg-primary-container hover:bg-secondary-container text-on-primary-container font-label-action text-label-action px-space-lg py-space-sm rounded uppercase tracking-wider transition-all duration-200 font-bold shadow-lg shadow-primary-container/20" href="<?php echo esc_url($wa_direct_url); ?>" rel="noopener noreferrer" target="_blank">
                            <span class="material-symbols-outlined text-[20px]">chat</span>
                            <span><?php echo esc_html($btn_wa_text); ?></span>
                        </a>

                        <?php if ($btn_sec_text): ?>
                        <a class="inline-flex items-center gap-2 bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-label-action text-label-action px-space-lg py-space-sm rounded uppercase tracking-wider transition-colors duration-200 font-bold" href="<?php echo esc_url($btn_sec_url); ?>">
                            <span><?php echo esc_html($btn_sec_text); ?></span>
                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </a>
                        <?php endif; ?>
                    </div>

                    <!-- Trust Quick Stats Strip -->
                    <div class="flex flex-wrap items-center gap-y-space-xs gap-x-space-md pt-space-xs text-body-sm font-body-sm text-outline border-t border-surface-container-highest/60">
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-primary-container text-[16px]">timer</span>
                            <span class="text-on-surface font-medium">Răspuns: &lt; 15 min</span>
                        </div>
                        <span>•</span>
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-primary-container text-[16px]">call</span>
                            <span class="text-on-surface font-medium"><?php echo esc_html($display_phone); ?></span>
                        </div>
                        <span>•</span>
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-primary-container text-[16px]">storefront</span>
                            <span class="text-on-surface font-medium">Sector 1, București</span>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Mode-Specific Form or 3-Step Guide (5 cols) -->
                <div class="lg:col-span-5 bg-surface-container-lowest p-space-md sm:p-space-lg rounded shadow-xl border border-surface-container-highest/60">
                    
                    <?php if ($form_mode === 'photo_instructions'): ?>
                        <!-- Mode 3: 3-Step Photo Photography Advice Card -->
                        <div class="space-y-space-sm">
                            <div class="flex items-center justify-between pb-space-xs mb-space-xs bg-surface-container-high p-space-xs rounded">
                                <span class="font-label-action text-label-action uppercase text-on-surface font-bold"><?php echo esc_html($photo_card_title); ?></span>
                                <span class="text-body-sm text-primary font-semibold"><?php echo esc_html($photo_badge_time); ?></span>
                            </div>
                            <span class="font-label-badge text-label-badge uppercase tracking-wider text-primary font-bold block">
                                <?php echo esc_html($photo_heading); ?>
                            </span>
                            <ul class="space-y-space-xs font-body-sm text-body-sm text-on-surface">
                                <li class="flex items-start gap-space-2xs">
                                    <span class="material-symbols-outlined text-primary-container text-[18px] shrink-0 mt-0.5">looks_one</span>
                                    <span><?php echo esc_html($photo_step_1); ?></span>
                                </li>
                                <li class="flex items-start gap-space-2xs">
                                    <span class="material-symbols-outlined text-primary-container text-[18px] shrink-0 mt-0.5">looks_two</span>
                                    <span><?php echo esc_html($photo_step_2); ?></span>
                                </li>
                                <li class="flex items-start gap-space-2xs">
                                    <span class="material-symbols-outlined text-primary-container text-[18px] shrink-0 mt-0.5">looks_3</span>
                                    <span><?php echo esc_html($photo_step_3); ?></span>
                                </li>
                            </ul>
                            <div class="pt-space-xs border-t border-surface-container-high flex flex-col gap-2">
                                <span class="inline-flex items-center gap-1 text-[11px] font-label-badge uppercase text-outline">
                                    <span class="material-symbols-outlined text-primary-container text-[14px]">lock_reset</span>
                                    <span><?php echo esc_html($photo_security); ?></span>
                                </span>
                                <a href="<?php echo esc_url($wa_direct_url); ?>" target="_blank" rel="noopener noreferrer" class="enigma-wa-btn inline-flex items-center justify-center gap-2 w-full py-space-sm px-space-md rounded bg-[#25D366] hover:bg-[#20ba59] text-[#072410] hover:text-black font-label-action text-label-action uppercase tracking-wider font-extrabold transition-all shadow-md mt-1">
                                    <span class="material-symbols-outlined text-[18px]">chat</span>
                                    <span><?php echo esc_html($photo_btn_text); ?></span>
                                </a>
                            </div>
                        </div>

                    <?php else: ?>
                        <!-- Mode 1 & 2: Interactive Micro-Form (Auto vs. Residential) -->
                        <div class="flex items-center justify-between pb-space-xs mb-space-sm bg-surface-container-high p-space-xs rounded">
                            <span class="font-label-action text-label-action uppercase text-on-surface font-bold"><?php echo esc_html($card_title); ?></span>
                            <span class="text-body-sm text-primary font-semibold"><?php echo esc_html($response_time); ?></span>
                        </div>

                        <form class="space-y-space-xs enigma-assessment-form" method="POST">
                            <!-- Nonce and context inputs -->
                            <input type="hidden" name="assessment_nonce" value="<?php echo esc_attr(wp_create_nonce('enigma14_assessment_action')); ?>" />
                            <input type="hidden" name="form_mode" value="<?php echo esc_attr($form_mode); ?>" />
                            <input type="hidden" name="recipient_email" value="<?php echo esc_attr($recipient_email); ?>" />
                            <input type="hidden" name="whatsapp_number" value="<?php echo esc_attr($whatsapp_clean); ?>" />
                            <input type="hidden" name="page_url" value="<?php echo esc_attr($current_page_url); ?>" />
                            <input type="hidden" name="page_title" value="<?php echo esc_attr($current_page_title); ?>" />

                            <!-- Error Message Banner -->
                            <div class="enigma-form-error hidden p-2 rounded bg-red-950/40 border border-red-500/50 text-red-300 text-xs font-semibold"></div>

                            <?php if ($form_mode === 'residential'): ?>
                                <!-- Residential Fields -->
                                <div>
                                    <label for="qa-residential-field-1" class="block font-label-badge text-label-badge uppercase text-outline mb-1">Tip Cheie / Producător Yală</label>
                                    <input id="qa-residential-field-1" name="field_1" class="w-full bg-surface p-space-xs text-on-surface text-body-md rounded border border-surface-container-highest focus:border-primary-container focus:outline-none transition-colors" placeholder="ex: Cheie cu amprentă, Cisa, Mottura, Cartelă interfon..." type="text" />
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-xs">
                                    <div>
                                        <label for="qa-residential-field-2" class="block font-label-badge text-label-badge uppercase text-outline mb-1">Cartelă / Serie Cod</label>
                                        <input id="qa-residential-field-2" name="field_2" class="w-full bg-surface p-space-xs text-on-surface text-body-md rounded border border-surface-container-highest focus:border-primary-container focus:outline-none transition-colors" placeholder="ex: Cu cartelă de cod / Fără" type="text" />
                                    </div>
                                    <div>
                                        <label for="qa-residential-phone" class="block font-label-badge text-label-badge uppercase text-outline mb-1">Telefon de Contact *</label>
                                        <input id="qa-residential-phone" name="phone" class="w-full bg-surface p-space-xs text-on-surface text-body-md rounded border border-surface-container-highest focus:border-primary-container focus:outline-none transition-colors" placeholder="07xx xxx xxx" required type="tel" />
                                    </div>
                                </div>

                                <div>
                                    <label for="qa-residential-service-type" class="block font-label-badge text-label-badge uppercase text-outline mb-1">Tip Serviciu Necesar</label>
                                    <select id="qa-residential-service-type" name="service_type" aria-label="Tip Serviciu Necesar" class="w-full bg-surface p-space-xs text-on-surface text-body-md rounded border border-surface-container-highest focus:border-primary-container focus:outline-none transition-colors">
                                        <option value="Duplicare cheie de înaltă securitate (amprentă)">Duplicare cheie de înaltă securitate (amprentă)</option>
                                        <option value="Duplicare pe bază de cartelă de proprietate">Duplicare pe bază de cartelă de proprietate</option>
                                        <option value="Copiere cheie clasică / dințată de locuință">Copiere cheie clasică / dințată de locuință</option>
                                        <option value="Duplicare cartelă interfon / tag RFID">Duplicare cartelă interfon / tag RFID</option>
                                        <option value="Înlocuire / Recalibrare butuc ușă blindată">Înlocuire / Recalibrare butuc ușă blindată</option>
                                        <option value="Deblocare / Asistență tehnică de urgență">Deblocare / Asistență tehnică de urgență</option>
                                    </select>
                                </div>

                            <?php else: ?>
                                <!-- Auto & Moto Fields -->
                                <div>
                                    <label for="qa-auto-field-1" class="block font-label-badge text-label-badge uppercase text-outline mb-1">Marca &amp; Modelul Mașinii</label>
                                    <input id="qa-auto-field-1" name="field_1" class="w-full bg-surface p-space-xs text-on-surface text-body-md rounded border border-surface-container-highest focus:border-primary-container focus:outline-none transition-colors" placeholder="ex: VW Golf 7 / Dacia Duster / Yamaha MT-07" type="text" />
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-xs">
                                    <div>
                                        <label for="qa-auto-field-2" class="block font-label-badge text-label-badge uppercase text-outline mb-1">An Fabricație</label>
                                        <input id="qa-auto-field-2" name="field_2" class="w-full bg-surface p-space-xs text-on-surface text-body-md rounded border border-surface-container-highest focus:border-primary-container focus:outline-none transition-colors" placeholder="ex: 2018" type="text" />
                                    </div>
                                    <div>
                                        <label for="qa-auto-phone" class="block font-label-badge text-label-badge uppercase text-outline mb-1">Telefon de Contact *</label>
                                        <input id="qa-auto-phone" name="phone" class="w-full bg-surface p-space-xs text-on-surface text-body-md rounded border border-surface-container-highest focus:border-primary-container focus:outline-none transition-colors" placeholder="07xx xxx xxx" required type="tel" />
                                    </div>
                                </div>

                                <div>
                                    <label for="qa-auto-service-type" class="block font-label-badge text-label-badge uppercase text-outline mb-1">Tip Serviciu Necesar</label>
                                    <select id="qa-auto-service-type" name="service_type" aria-label="Tip Serviciu Necesar" class="w-full bg-surface p-space-xs text-on-surface text-body-md rounded border border-surface-container-highest focus:border-primary-container focus:outline-none transition-colors">
                                        <option value="Cheie completă cu cip & telecomandă">Cheie completă cu cip &amp; telecomandă</option>
                                        <option value="Doar carcasă nouă & tăiere lamă">Doar carcasă nouă &amp; tăiere lamă</option>
                                        <option value="Duplicare cheie mecanică simplă">Duplicare cheie mecanică simplă</option>
                                        <option value="Copiere cheie moto / scuter">Copiere cheie moto / scuter</option>
                                        <option value="Virginizare / Reprogramare cheie SH">Virginizare / Reprogramare cheie SH</option>
                                        <option value="Pierdere totală a cheilor">Pierdere totală a cheilor</option>
                                    </select>
                                </div>
                            <?php endif; ?>

                            <div class="pt-space-2xs flex flex-col sm:flex-row items-stretch sm:items-center gap-space-xs">
                                <button class="flex-1 inline-flex items-center justify-center gap-2 bg-primary-container hover:bg-secondary-container text-on-primary-container font-label-action text-label-action py-space-sm px-space-md rounded uppercase tracking-wider transition-colors duration-200 font-bold shadow-md shadow-primary-container/20 cursor-pointer" type="submit">
                                    <span class="material-symbols-outlined text-[18px] btn-icon">send</span>
                                    <span class="btn-text"><?php echo esc_html($btn_submit); ?></span>
                                </button>
                                <a href="<?php echo esc_url($wa_direct_url); ?>" target="_blank" rel="noopener noreferrer" class="enigma-wa-btn inline-flex items-center justify-center gap-2 bg-[#25D366] hover:bg-[#20ba59] text-[#072410] hover:text-black font-label-action text-label-action py-space-sm px-space-md rounded uppercase tracking-wider font-extrabold transition-all shadow-md shadow-[#25D366]/20">
                                    <span class="material-symbols-outlined text-[18px]">chat</span>
                                    <span class="whitespace-nowrap">WhatsApp</span>
                                </a>
                            </div>
                        </form>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</section>
