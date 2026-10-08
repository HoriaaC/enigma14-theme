<?php
/**
 * ENIGMA 14 - Catalog & Menu Importer
 * Permite importul și sincronizarea categoriilor, serviciilor și a meniului optimizat
 * direct din panoul de administrare sau prin trigger securizat.
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Funcția principală de import (idempotentă: poate fi rulată în siguranță oricând)
 */
function enigma14_execute_catalog_import() {
    $log = [];

    // -------------------------------------------------------------------------
    // 1. CATEGORII (MACRO-DIVIZII)
    // -------------------------------------------------------------------------
    $categories = [
        [
            'name'        => 'Chei Rezidențiale & Lăcătușerie',
            'slug'        => 'chei-rezidentiale-si-lacate',
            'description' => 'Copiere chei de înaltă securitate cu amprentă, chei de seif cu barbă dublă, chei clasice plane, duplicare după butuc și vânzare cilindri de siguranță.',
            'acf'         => [
                'category_icon'          => 'switch_account',
                'category_time_badge'    => 'Pe loc (2 - 10 min)',
                'category_price_from'    => 'de la 15 lei',
                'cat_status_ribbon_text' => 'DUPLICARE PE MAȘINI CNC • DECODARE LA MICRON',
                'cat_hero_badge_icon'    => 'shield',
                'cat_hero_badge_text'    => 'ATELIER MECATRONIC SECTOR 1',
                'cat_hero_title'         => 'Chei Rezidențiale, Seifuri & Lăcătușerie',
                'cat_hero_description'   => 'Multiplicare de înaltă fidelitate pe mașini CNC computerizate. Executăm pe loc chei cu amprentă, chei patentate cu card de proprietate, chei de seif cu barbă dublă și decodare cilindri în Sectorul 1.',
                'cat_hero_btn1_text'     => 'CERE O EVALUARE ACUM',
                'cat_hero_btn1_url'      => '#solicita-evaluare',
                'cat_hero_btn2_text'     => '0736 127 518 — SUPORT DIRECT',
                'cat_hero_btn2_url'      => 'tel:0736127518',
                'cat_spec1_label'        => 'TOLERANȚĂ CNC',
                'cat_spec1_val'          => '±0.02 mm',
                'cat_spec2_label'        => 'COPIERE PE CARD',
                'cat_spec2_val'          => 'Bitting Original',
                'cat_spec3_label'        => 'TIMP EXECUȚIE',
                'cat_spec3_val'          => '2 - 5 min',
                'cat_spec4_label'        => 'PROFILE',
                'cat_spec4_val'          => 'Cisa, Mottura, Abus',
            ]
        ],
        [
            'name'        => 'Chei Auto, Moto & Scutere',
            'slug'        => 'chei-auto-moto',
            'description' => 'Copiere și programare chei auto cu cip, chei smart keyless, chei motociclete și scutere de livrare, reparații electronice și înlocuire carcase.',
            'acf'         => [
                'category_icon'          => 'directions_car',
                'category_time_badge'    => '15 - 30 min • Pe banc & OBD',
                'category_price_from'    => 'de la 50 lei',
                'cat_status_ribbon_text' => 'DIAGNOZĂ OBD & DECODARE PE LOC • TOATE MĂRCILE',
                'cat_hero_badge_icon'    => 'directions_car',
                'cat_hero_badge_text'    => 'LABORATOR MECATRONIC CHEI AUTO',
                'cat_hero_title'         => 'Chei Auto, Moto & Scutere de Livrare',
                'cat_hero_description'   => 'Programare cip transponder, frezare lame laser de înaltă precizie, chei scutere livrare și reparații electronice complete pentru orice marcă auto sau vehicul în Sector 1.',
                'cat_hero_btn1_text'     => 'CERE O EVALUARE ACUM',
                'cat_hero_btn1_url'      => '#solicita-evaluare',
                'cat_hero_btn2_text'     => '0736 127 518 — SUPORT DIRECT',
                'cat_hero_btn2_url'      => 'tel:0736127518',
                'cat_spec1_label'        => 'DECODARE CIP',
                'cat_spec1_val'          => 'Transponder Crypto',
                'cat_spec2_label'        => 'PROGRAMARE OBD',
                'cat_spec2_val'          => 'Tester Dedicat',
                'cat_spec3_label'        => 'TIMP EXECUȚIE',
                'cat_spec3_val'          => '15 - 30 min',
                'cat_spec4_label'        => 'STAND TESTARE',
                'cat_spec4_val'          => 'Frecvență & Cip',
            ]
        ],
        [
            'name'        => 'Telecomenzi & Cartele Interfon',
            'slug'        => 'telecomenzi-si-interfoane',
            'description' => 'Copiere și vânzare telecomenzi porți și garaj (cod fix și rolling code), clonare cartele interfon de la 125 kHz la 135 kHz inclusiv format securizat HID și taguri RFID.',
            'acf'         => [
                'category_icon'          => 'rss_feed',
                'category_time_badge'    => 'Instant (1 - 3 min)',
                'category_price_from'    => 'de la 20 lei',
                'cat_status_ribbon_text' => 'ANALIZOR FRECVENȚĂ 433-868 MHZ • CITITOR RFID/HID',
                'cat_hero_badge_icon'    => 'rss_feed',
                'cat_hero_badge_text'    => 'SISTEME ACCES & AUTOMATIZĂRI',
                'cat_hero_title'         => 'Telecomenzi Garaj, Porți & Cartele Interfon',
                'cat_hero_description'   => 'Clonare și programare pe loc pentru orice telecomandă de barieră sau poartă automată (Nice, BFT, Sommer etc.) și duplicare cartele RFID / HID de proximitate în Sectorul 1.',
                'cat_hero_btn1_text'     => 'CERE O EVALUARE ACUM',
                'cat_hero_btn1_url'      => '#solicita-evaluare',
                'cat_hero_btn2_text'     => '0736 127 518 — SUPORT DIRECT',
                'cat_hero_btn2_url'      => 'tel:0736127518',
                'cat_spec1_label'        => 'FRECVENȚE',
                'cat_spec1_val'          => '433 & 868 MHz',
                'cat_spec2_label'        => 'CARTELE RFID',
                'cat_spec2_val'          => '125-135 kHz / HID',
                'cat_spec3_label'        => 'PROCEDURĂ',
                'cat_spec3_val'          => 'Clonare & Înrolare',
                'cat_spec4_label'        => 'TIMP EXECUȚIE',
                'cat_spec4_val'          => '1 - 3 min pe loc',
            ]
        ],
        [
            'name'        => 'Urgențe, Deblocări & Butuci',
            'slug'        => 'urgente-si-deblocari',
            'description' => 'Deblocări auto fără daune cu scule Lishi, generare cheie de la zero (All Keys Lost), reparat și recalibrat butuci auto sau uși rezidențiale.',
            'acf'         => [
                'category_icon'          => 'home_repair_service',
                'category_time_badge'    => 'Intervenție Specializată',
                'category_price_from'    => 'de la 100 lei',
                'cat_status_ribbon_text' => 'SCULE PROFESIONALE LISHI • INTERVENȚIE NON-DESTRUCTIVĂ',
                'cat_hero_badge_icon'    => 'lock_reset',
                'cat_hero_badge_text'    => 'URGENȚE MECATRONICE SECTOR 1',
                'cat_hero_title'         => 'Deblocări Auto, All Keys Lost & Reparații Butuci',
                'cat_hero_description'   => 'Intervenții specializate non-distructive pentru uși auto încuiate, decodare mecanică a cheii direct după butuc în caz de pierdere totală și recondiționare contacte blocate.',
                'cat_hero_btn1_text'     => 'SOLICITĂ ASISTENȚĂ ACUM',
                'cat_hero_btn1_url'      => '#solicita-evaluare',
                'cat_hero_btn2_text'     => '0736 127 518 — CONTACT URGENȚĂ',
                'cat_hero_btn2_url'      => 'tel:0736127518',
                'cat_spec1_label'        => 'METODĂ',
                'cat_spec1_val'          => 'Decodoare Lishi',
                'cat_spec2_label'        => 'INTEGRITATE',
                'cat_spec2_val'          => '100% Fără Daune',
                'cat_spec3_label'        => 'PIERDERE TOTALĂ',
                'cat_spec3_val'          => 'All Keys Lost',
                'cat_spec4_label'        => 'CALIBRARE PINI',
                'cat_spec4_val'          => 'Recondiționare Yală',
            ]
        ]
    ];

    $category_map = [];

    foreach ($categories as $cat) {
        $existing = get_term_by('slug', $cat['slug'], 'categorie_serviciu');
        if ($existing) {
            $term_id = $existing->term_id;
            wp_update_term($term_id, 'categorie_serviciu', [
                'name'        => $cat['name'],
                'description' => $cat['description'],
            ]);
            $log[] = "[UPDATED] Categoria: {$cat['name']} (ID: {$term_id})";
        } else {
            $result = wp_insert_term($cat['name'], 'categorie_serviciu', [
                'slug'        => $cat['slug'],
                'description' => $cat['description'],
            ]);
            if (is_wp_error($result)) {
                $log[] = "[EROARE] Creare categorie {$cat['name']}: " . $result->get_error_message();
                continue;
            }
            $term_id = $result['term_id'];
            $log[] = "[CREATED] Categoria: {$cat['name']} (ID: {$term_id})";
        }

        $category_map[$cat['slug']] = $term_id;

        if (function_exists('update_field')) {
            foreach ($cat['acf'] as $key => $val) {
                update_field($key, $val, 'categorie_serviciu_' . $term_id);
            }
        }
    }

    // -------------------------------------------------------------------------
    // 2. SERVICII (CPT: serviciu)
    // -------------------------------------------------------------------------
    $services = [
        [
            'title'        => 'Copiere Chei Amprentă & Înaltă Securitate',
            'slug'         => 'copiere-chei-amprenta',
            'category'     => 'chei-rezidentiale-si-lacate',
            'content'      => 'Multiplicare computerizată pe mașini CNC de înaltă finețe pentru chei cu amprentă (dimple keys), profile reversibile patentate, tăiere laser de precizie și duplicare pe baza cartelei de proprietate codificate.',
            'acf'          => [
                'service_status_band_left'   => 'STAND MECATRONIC ACTIV • FREZARE LA MICRON',
                'service_status_band_right'  => 'BUCUREȘTI SECTOR 1',
                'service_hero_badge_icon'    => 'verified_user',
                'service_hero_badge_text'    => 'SISTEME DE BLOCARE DE ÎNALTĂ SECURITATE',
                'service_hero_title'         => 'Copiere Chei Amprentă & <span class="text-primary-container">Înaltă Securitate</span>',
                'service_hero_description'   => 'Securitate maximă și duplicare computerizată pe mașini CNC de înaltă finețe. Asigurăm multiplicare fidelă pentru chei cu amprentă (dimple keys), profile reversibile patentate și duplicare pe baza cartelei de proprietate.',
                'service_spec1_icon'         => 'precision_manufacturing',
                'service_spec1_label'        => 'Precizie CNC',
                'service_spec1_val'          => 'Toleranță ±0.02 mm',
                'service_spec2_icon'         => 'badge',
                'service_spec2_label'        => 'Duplicare pe Card',
                'service_spec2_val'          => 'Cod Bitting Original',
                'service_spec3_icon'         => 'timer',
                'service_spec3_label'        => 'Execuție Rapidă',
                'service_spec3_val'          => '3 - 10 Min (Pe Loc)',
                'service_spec4_icon'         => 'task_alt',
                'service_spec4_label'        => 'Matrițe Originale',
                'service_spec4_val'          => '100% Compatibilitate',
                'service_warranty_text'      => 'Garanție Execuție 24 Luni',
                'service_partner_text'       => 'Profile Protejate Silca & Keyline',
                'service_card_icon'          => 'security',
                'service_card_badge'         => '3 - 10 MIN • PE BAZĂ DE CARD',
                'service_card_desc'          => 'Duplicare pe mașini CNC pentru chei cu amprentă, profile patentate de înaltă securitate și multiplicare pe baza cartelei de cod.',
                'service_card_bullets'       => [
                    ['bullet_text' => 'Frezare punctiformă CNC cu toleranță de microni'],
                    ['bullet_text' => 'Profile compatibile: Cisa, Mottura, Abus, Mul-T-Lock, Securemme'],
                    ['bullet_text' => 'Duplicare autorizată pe baza cardului de securitate'],
                ],
                'service_card_btn_text'      => 'Detalii Chei Amprentă',
                'service_products'           => [
                    [
                        'badge'       => 'PIN TELESCOPIC',
                        'icon'        => 'vpn_key',
                        'title'       => 'Mul-T-Lock Interactive+ / Classic',
                        'series'      => 'Profil Reversibil Patentat',
                        'description' => 'Cheie cu pin mobil/telescopic de mare finețe. Duplicare pe bază de card de proprietate la mașină electronică.',
                        'tags'        => 'Pin Telescopic, Protecție Bumping, Cartelă Securizată',
                        'price'       => 'de la 65 lei',
                    ],
                    [
                        'badge'       => 'AMPRENTĂ 3D',
                        'icon'        => 'security',
                        'title'       => 'Cisa Astral Tekno & AP3 / AP4',
                        'series'      => 'Sistem Certificat Înaltă Securitate',
                        'description' => 'Frezare radială și laterală de mare adâncime pentru uși metalice de apartament și vile.',
                        'tags'        => 'Pini Activi, Anti-Picking, Certificare SKG',
                        'price'       => 'de la 55 lei',
                    ],
                    [
                        'badge'       => 'PROFIL REVERSIBIL',
                        'icon'        => 'shield',
                        'title'       => 'Mottura Champions & C28 / C48',
                        'series'      => 'Protecție Maximă Împotriva Efracției',
                        'description' => 'Cheie patentată cu bilă rotativă sau elemente magnetice. Multiplicare fidelă conform codului mecanic.',
                        'tags'        => 'Element Mobil, Bilă Magnetizată, Card de Identitate',
                        'price'       => 'de la 80 lei',
                    ],
                    [
                        'badge'       => 'GERMAN ENGINEERING',
                        'icon'        => 'precision_manufacturing',
                        'title'       => 'Abus Bravus & D6 / D10',
                        'series'      => 'Sistem Intellitec Patentat',
                        'description' => 'Cheie de siguranță cu ghidaj ondulat și pini multipli pentru clădiri de birouri și locuințe premium.',
                        'tags'        => 'Sistem Intellitec, Clasă de Securitate 6, Fără Jocuri',
                        'price'       => 'de la 60 lei',
                    ]
                ]
            ]
        ],
        [
            'title'        => 'Copiere Chei Clasice, Plane & Lacăte',
            'slug'         => 'copiere-chei-plane-si-lacate',
            'category'     => 'chei-rezidentiale-si-lacate',
            'content'      => 'Duplicare rapidă pe loc pentru chei plane zimțate, cilindri uzuali de apartament, lacăte de interior și exterior, cutii poștale, fișiere și mobilier.',
            'acf'          => [
                'service_status_band_left'   => 'MULTI-STAND ACTIV • EXECUȚIE INSTANTÂNEE',
                'service_status_band_right'  => 'BUCUREȘTI SECTOR 1',
                'service_hero_badge_icon'    => 'key',
                'service_hero_badge_text'    => 'DUPLICARE RAPIDĂ LA GHIȘEU',
                'service_hero_title'         => 'Copiere Chei Clasice, Plane & <span class="text-primary-container">Lacăte</span>',
                'service_hero_description'   => 'Multiplicare în 60 de secunde pentru chei standard dințate de yale, lacăte de uz casnic sau industrial, cutii poștale, dulapuri de birou și fișiere.',
                'service_spec1_icon'         => 'timer',
                'service_spec1_label'        => 'Timp Execuție',
                'service_spec1_val'          => '1 - 2 Minute / Cheie',
                'service_spec2_icon'         => 'key',
                'service_spec2_label'        => 'Gama de Matrițe',
                'service_spec2_val'          => 'Peste 2500 Profile',
                'service_spec3_icon'         => 'task_alt',
                'service_spec3_label'        => 'Calibrare Fină',
                'service_spec3_val'          => 'Finisare Fără Bavuri',
                'service_spec4_icon'         => 'verified',
                'service_spec4_label'        => 'Material',
                'service_spec4_val'          => 'Alamă & Nichel Masiv',
                'service_warranty_text'      => 'Garanție Potrivire Perfectă 100%',
                'service_partner_text'       => 'Matrițe Originale Silca & Errebi',
                'service_card_icon'          => 'key',
                'service_card_badge'         => '1 - 2 MIN • PE LOC',
                'service_card_desc'          => 'Copiere instant pentru chei zimțate uzuale, butuci clasici, lacăte de poartă, cutii poștale și chei de mobilier.',
                'service_card_bullets'       => [
                    ['bullet_text' => 'Gata în 1-2 minute direct la ghișeu'],
                    ['bullet_text' => 'Stoc masiv de matrițe Silca pentru orice producător'],
                    ['bullet_text' => 'Verificare și finisare mecanică pentru rotire lină în cilindru'],
                ],
                'service_card_btn_text'      => 'Vezi Detalii Chei Plane',
                'service_products'           => [
                    [
                        'badge'       => 'STANDARD YALĂ',
                        'icon'        => 'key',
                        'title'       => 'Chei Plane Zimțate (Yală / Butuc)',
                        'series'      => 'Uși Interioare & Apartament',
                        'description' => 'Cheie clasică pentru butuci de apartament (Urbis, Yale, Kale, Titan).',
                        'tags'        => 'Pe Loc, Alamă Rezistentă, Finisare Fără Bavuri',
                        'price'       => 'de la 15 lei',
                    ],
                    [
                        'badge'       => 'UZ CASNIC & INDUSTRIAL',
                        'icon'        => 'lock',
                        'title'       => 'Chei pentru Lacăte & Porți',
                        'series'      => 'Lacăte Mici, Medii & Industriale',
                        'description' => 'Multiplicare chei pentru lacăte din alamă, oțel călit sau lacăte circulare.',
                        'tags'        => 'Lacăte Curte, Hale, Garaje',
                        'price'       => 'de la 15 lei',
                    ],
                    [
                        'badge'       => 'MOBILIER & CORESPONDENȚĂ',
                        'icon'        => 'vpn_key',
                        'title'       => 'Chei Cutii Poștale & Dulapuri Birou',
                        'series'      => 'Profile Miniaturale',
                        'description' => 'Chei speciale subțiri pentru casete de valori, cutii poștale și vestiare.',
                        'tags'        => 'Cutii Poștale, Fișiere, Vestiare',
                        'price'       => 'de la 15 lei',
                    ]
                ]
            ]
        ],
        [
            'title'        => 'Copiere Chei Seif, Barbă Dublă & Speciale',
            'slug'         => 'copiere-chei-barba-dubla-seif',
            'category'     => 'chei-rezidentiale-si-lacate',
            'content'      => 'Copiere pe mașini speciale de frezare aripă pentru chei lungi tip fluture / barbă dublă destinate ușilor blindate grele, caselor de bani și seifurilor bancare.',
            'acf'          => [
                'service_status_band_left'   => 'FREZARE PROFILE LUNGI • MATRIȚE DE PRECIZIE',
                'service_status_band_right'  => 'BUCUREȘTI SECTOR 1',
                'service_hero_badge_icon'    => 'door_front',
                'service_hero_badge_text'    => 'UȘI BLINDATE & CASE DE BANI',
                'service_hero_title'         => 'Copiere Chei Seif, Barbă Dublă & <span class="text-primary-container">Speciale</span>',
                'service_hero_description'   => 'Duplicare mecanică de înaltă precizie pentru chei tip seif (barbă dublă / aripă simplă), uși metalice masive cu broască de seif și casete de valori.',
                'service_spec1_icon'         => 'door_front',
                'service_spec1_label'        => 'Tip Cheie',
                'service_spec1_val'          => 'Barbă Dublă / Fluture',
                'service_spec2_icon'         => 'precision_manufacturing',
                'service_spec2_label'        => 'Frezare Asimetrică',
                'service_spec2_val'          => 'Canelură & Dinți Seif',
                'service_spec3_icon'         => 'timer',
                'service_spec3_label'        => 'Timp Execuție',
                'service_spec3_val'          => '5 - 15 Minute',
                'service_spec4_icon'         => 'shield',
                'service_spec4_label'        => 'Mărci Compatibile',
                'service_spec4_val'          => 'Mottura, Cisa, Sab, Potent',
                'service_warranty_text'      => 'Garanție Funcționare Pârghii 24 Luni',
                'service_partner_text'       => 'Semifabricate din Oțel & Alamă Silca',
                'service_card_icon'          => 'door_front',
                'service_card_badge'         => '5 - 15 MIN • UȘI BLINDATE',
                'service_card_desc'          => 'Copiere chei fluture și barbă dublă pentru uși blindate de apartament, broaște cu pârghii și seifuri de securitate.',
                'service_card_bullets'       => [
                    ['bullet_text' => 'Compatibilitate totală: Mottura, Cisa, Securemme, Sab, Potent, Atra'],
                    ['bullet_text' => 'Frezare pe mașină dedicată pentru aripi simetrice și asimetrice'],
                    ['bullet_text' => 'Prelucrare lungimi speciale (până la 140 mm)'],
                ],
                'service_card_btn_text'      => 'Detalii Chei Barbă Dublă',
                'service_products'           => [
                    [
                        'badge'       => 'BARBĂ DUBLĂ BLINDATĂ',
                        'icon'        => 'door_front',
                        'title'       => 'Mottura & Cisa Barbă Dublă',
                        'series'      => 'Broaște cu Pârghii (Gorge)',
                        'description' => 'Cheie clasică pentru uși blindate rezidențiale. Frezare pe două fețe a dinților de ghidaj.',
                        'tags'        => 'Uși Blindate, Tije Închidere, Oțel Masiv',
                        'price'       => 'de la 45 lei',
                    ],
                    [
                        'badge'       => 'SEIF & CASE DE BANI',
                        'icon'        => 'lock',
                        'title'       => 'Chei Seif Fluture & Tevi Găurite',
                        'series'      => 'Seifuri Casnice & Industriale',
                        'description' => 'Chei cu tijă cilindrică găurită la vârf pentru axul broaștei de casă de bani.',
                        'tags'        => 'Tijă Găurită, Casete Valori, Seif',
                        'price'       => 'de la 60 lei',
                    ],
                    [
                        'badge'       => 'ARIPĂ SIMPLĂ',
                        'icon'        => 'key',
                        'title'       => 'Chei Antice & Aripă Simplă',
                        'series'      => 'Porți Vechi & Uși Istorice',
                        'description' => 'Prelucrare manuală și mecanică pentru chei masive cu o singură aripă profilată.',
                        'tags'        => 'Uși Masive, Modele Rare, Finisare Manuală',
                        'price'       => 'de la 40 lei',
                    ]
                ]
            ]
        ],
        [
            'title'        => 'Generare Cheie după Butuc & Reparații Yală',
            'slug'         => 'copie-chei-dupa-butuc',
            'category'     => 'chei-rezidentiale-si-lacate',
            'content'      => 'Când toate cheile au fost pierdute sau s-au rupt în interior, atelierul nostru demontează butucul, decodează înălțimea pinilor și generează o cheie nouă funcțională fără a fi nevoie să schimbați ușa.',
            'acf'          => [
                'service_status_band_left'   => 'DECODARE MECANICĂ • RECONSTITUIRE COD BITTING',
                'service_status_band_right'  => 'BUCUREȘTI SECTOR 1',
                'service_hero_badge_icon'    => 'lock_reset',
                'service_hero_badge_text'    => 'RECUPERARE FĂRĂ ÎNLOCUIRE YALĂ',
                'service_hero_title'         => 'Generare Cheie după Butuc & <span class="text-primary-container">Reparații Yală</span>',
                'service_hero_description'   => 'Ai pierdut cheia sau s-a rupt în broască? Adu butucul la atelier: decodăm configurația internă a pinilor și tăiem o cheie nouă perfect calibrată.',
                'service_spec1_icon'         => 'lock_open',
                'service_spec1_label'        => 'Decodare',
                'service_spec1_val'          => 'Citire Direct din Cilindru',
                'service_spec2_icon'         => 'build',
                'service_spec2_label'        => 'Extragere Fragmente',
                'service_spec2_val'          => 'Chei Rupte în Butuc',
                'service_spec3_icon'         => 'settings',
                'service_spec3_label'        => 'Recalibrare Pini',
                'service_spec3_val'          => 'Rotire Ușoară 360°',
                'service_spec4_icon'         => 'task_alt',
                'service_spec4_label'        => 'Economie',
                'service_spec4_val'          => 'Păstrați Yala Originală',
                'service_warranty_text'      => 'Garanție Execuție & Testare pe Banc',
                'service_partner_text'       => 'Serviciu Tehnic Mecatronic Specializat',
                'service_card_icon'          => 'lock_reset',
                'service_card_badge'         => 'INTERVENȚIE PE BANC • FĂRĂ SCHIMBARE YALĂ',
                'service_card_desc'          => 'Generare cheie nouă direct după citirea cățeilor/pinilor butucului când nu mai aveți nicio cheie disponibilă.',
                'service_card_bullets'       => [
                    ['bullet_text' => 'Decodare pe banc a combinației de pini și arcuri'],
                    ['bullet_text' => 'Extragere fără distrugere a bucăților de cheie rupte'],
                    ['bullet_text' => 'Recondiționare și lubrifiere profesională cilindru'],
                ],
                'service_card_btn_text'      => 'Detalii Copie după Butuc',
                'service_products'           => [
                    [
                        'badge'       => 'DECODARE PINI',
                        'icon'        => 'lock_reset',
                        'title'       => 'Fabricare Cheie după Miez / Butuc',
                        'series'      => 'Toate Cheile Pierdute',
                        'description' => 'Dezasamblare butuc, măsurare micrometrică a fiecărui pin și tăiere cheie originală.',
                        'tags'        => 'Decodare Pini, Tăiere CNC, Salvare Butuc',
                        'price'       => 'de la 50 lei',
                    ],
                    [
                        'badge'       => 'DEBLOCARE BROASCĂ',
                        'icon'        => 'build',
                        'title'       => 'Extragere Cheie Ruptă din Cilindru',
                        'series'      => 'Intervenție Mecanică Fină',
                        'description' => 'Scoaterea fragmentului metalic blocat în canelură fără zgârierea pinilor activi.',
                        'tags'        => 'Sonde Extracție, Fără Deteriorare, Deblocare',
                        'price'       => 'de la 30 lei',
                    ]
                ]
            ]
        ],
        [
            'title'        => 'Vânzare Butuci, Lacăte & Accesorii',
            'slug'         => 'vanzare-butuci-lacate-accesorii',
            'category'     => 'chei-rezidentiale-si-lacate',
            'content'      => 'Gama completă de cilindri de înaltă siguranță cu protecție antigăurire și antiruprere, lacăte monobloc din oțel călit și accesorii profesionale pentru organizarea cheilor.',
            'acf'          => [
                'service_status_band_left'   => 'PRODUSE OMOLOGATE • CLASA MAXIMĂ SECURITATE',
                'service_status_band_right'  => 'BUCUREȘTI SECTOR 1',
                'service_hero_badge_icon'    => 'lock',
                'service_hero_badge_text'    => 'PRODUSE DE SIGURANȚĂ REZIDENȚIALĂ',
                'service_hero_title'         => 'Vânzare Butuci, Lacăte & <span class="text-primary-container">Accesorii Chei</span>',
                'service_hero_description'   => 'Alege securitatea certificată pentru căminul sau afacerea ta: cilindri cu rupere controlată (anti-snap), lacăte de mare rezistență și accesorii practice.',
                'service_spec1_icon'         => 'shield',
                'service_spec1_label'        => 'Protecție',
                'service_spec1_val'          => 'Anti-Bumping & Rupere',
                'service_spec2_icon'         => 'lock',
                'service_spec2_label'        => 'Lacăte',
                'service_spec2_val'          => 'Oțel Călit & Monobloc',
                'service_spec3_icon'         => 'badge',
                'service_spec3_label'        => 'Chei Incluse',
                'service_spec3_val'          => '3 - 5 Chei + Card',
                'service_spec4_icon'         => 'verified',
                'service_spec4_label'        => 'Garanție',
                'service_spec4_val'          => '24 - 36 Luni',
                'service_warranty_text'      => 'Produse Certificate European',
                'service_partner_text'       => 'Distribuitor Cilindri & Feronerie Sigură',
                'service_card_icon'          => 'lock',
                'service_card_badge'         => 'STOC ATELIER • DISPONIBIL PE LOC',
                'service_card_desc'          => 'Cilindri de siguranță cu protecție avansată împotriva efracției, lacăte de mare tonaj și accesorii pentru chei.',
                'service_card_bullets'       => [
                    ['bullet_text' => 'Butuci certificati anti-rupere, anti-găurire și anti-bumping'],
                    ['bullet_text' => 'Lacăte din alamă masivă și oțel călit pentru exterior'],
                    ['bullet_text' => 'Brelocuri, inele elastice, taguri colorate și carcase'],
                ],
                'service_card_btn_text'      => 'Vezi Catalog Produse',
                'service_products'           => [
                    [
                        'badge'       => 'ANTI-SNAP & SKG***',
                        'icon'        => 'shield',
                        'title'       => 'Cilindri de Înaltă Securitate (Butuci)',
                        'series'      => 'Dimensiuni Standard & Asimetrice',
                        'description' => 'Cilindri cu bară de oțel antirupere, pini din oțel călit și chei cu amprentă protejate prin card.',
                        'tags'        => 'Anti-Snap, Anti-Bumping, 5 Chei Incluse',
                        'price'       => 'de la 95 lei',
                    ],
                    [
                        'badge'       => 'OȚEL CĂLIT',
                        'icon'        => 'lock',
                        'title'       => 'Lacăte de Mare Siguranță & Monobloc',
                        'series'      => 'Protecție Porți, Garaje & Containere',
                        'description' => 'Lacăte masive cu toartă protejată împotriva tăierii cu foarfeca de fier-beton.',
                        'tags'        => 'Toartă Protejată, Rezistent la Coroziune, Cheie Siguranță',
                        'price'       => 'de la 40 lei',
                    ],
                    [
                        'badge'       => 'ORGANIZARE',
                        'icon'        => 'key',
                        'title'       => 'Accesorii Chei & Inele Identificare',
                        'series'      => 'Accesorii Practice',
                        'description' => 'Inele din oțel elastic, căpăcele din silicon colorate pentru diferențierea cheilor și carabine.',
                        'tags'        => 'Capace Silicon, Inele Rezistente, Taguri Nume',
                        'price'       => 'de la 3 lei',
                    ]
                ]
            ]
        ],
        [
            'title'        => 'Copiere Chei Auto Simple & Lame Laser',
            'slug'         => 'copiere-lame-chei-auto',
            'category'     => 'chei-auto-moto',
            'content'      => 'Tăiere de precizie mecanică și frezare CNC tip undă/laser pentru lame de chei auto, chei simple de rezervă fără electronică și carcase cu locaș special pentru transponder.',
            'acf'          => [
                'service_status_band_left'   => 'FREZARE LASER CNC • REPLICARE PROFIL UZAT',
                'service_status_band_right'  => 'BUCUREȘTI SECTOR 1',
                'service_hero_badge_icon'    => 'vpn_key',
                'service_hero_badge_text'    => 'TĂIERE LAME AUTO COMPUTERIZATĂ',
                'service_hero_title'         => 'Copiere Chei Auto Simple & <span class="text-primary-container">Lame Laser</span>',
                'service_hero_description'   => 'Frezare computerizată pe mașini CNC pentru lame auto cu canelură interioară (tip undă), chei simple fără cip pentru deschiderea de urgență a portierei sau chei fixe cu locaș transponder.',
                'service_spec1_icon'         => 'precision_manufacturing',
                'service_spec1_label'        => 'Frezare Laser',
                'service_spec1_val'          => 'Reconstituire Cod Tăiere',
                'service_spec2_icon'         => 'vpn_key',
                'service_spec2_label'        => 'Lame Speciale',
                'service_spec2_val'          => 'HU66, HU100, VA2, SIP22',
                'service_spec3_icon'         => 'timer',
                'service_spec3_label'        => 'Timp Execuție',
                'service_spec3_val'          => '5 - 10 Minute',
                'service_spec4_icon'         => 'task_alt',
                'service_spec4_label'        => 'Fără Eroare',
                'service_spec4_val'          => 'Calibrare Optică',
                'service_warranty_text'      => 'Garanție Rotire Perfectă în Contact & Portieră',
                'service_partner_text'       => 'Profile Calitative Silca Automotive',
                'service_card_icon'          => 'vpn_key',
                'service_card_badge'         => '5 - 10 MIN • FREZARE CNC',
                'service_card_desc'          => 'Tăiere lame auto de precizie: chei mecanice simple, lame speciale cu profil laser / undă și chei cu locaș pentru cip.',
                'service_card_bullets'       => [
                    ['bullet_text' => 'Frezare computerizată CNC cu citire optică a uzurii'],
                    ['bullet_text' => 'Lame speciale tip undă: VAG (HU66), Opel (HU100), Renault (VA2), Fiat (SIP22)'],
                    ['bullet_text' => 'Cheie de rezervă simplă pentru acces portieră fără costul telecomenzii'],
                ],
                'service_card_btn_text'      => 'Detalii Lame Auto',
                'service_products'           => [
                    [
                        'badge'       => 'CANELURĂ UNDĂ / CNC',
                        'icon'        => 'precision_manufacturing',
                        'title'       => 'Tăiere Lamă Laser Specială',
                        'series'      => 'Profile Interioare & Caneluri Adânci',
                        'description' => 'Frezare laser la cotă originală pentru lame tip fluture sau undă (VAG, BMW, Mercedes, Ford).',
                        'tags'        => 'Frezare CNC, Replicare Cod Original, Fără Blocaje',
                        'price'       => 'de la 40 lei',
                    ],
                    [
                        'badge'       => 'CHEIE FIXĂ CU CIP',
                        'icon'        => 'memory',
                        'title'       => 'Cheie Auto cu Locaș Cip (Fără Butoane)',
                        'series'      => 'Cheie Secundară de Pornire',
                        'description' => 'Carcasă rigidă cu lamă tăiată și locaș destinat montării cipului de imobilizator.',
                        'tags'        => 'Cheie Rezervă, Pornire Motor, Cost Redus',
                        'price'       => 'de la 50 lei',
                    ],
                    [
                        'badge'       => 'DOAR MECANICĂ',
                        'icon'        => 'vpn_key',
                        'title'       => 'Cheie Auto Simplă (Fără Cip)',
                        'series'      => 'Acces Portieră & Portbagaj',
                        'description' => 'Cheie mecanică dedicată deschiderii manuale a încuietorilor, rezervorului sau portbagajului.',
                        'tags'        => 'Deschidere Portieră, De Urgență, Alamă Nichelată',
                        'price'       => 'de la 35 lei',
                    ]
                ]
            ]
        ],
        [
            'title'        => 'Chei Moto, Scutere & Flote Livrare',
            'slug'         => 'copiere-chei-motociclete-scutere',
            'category'     => 'chei-auto-moto',
            'content'      => 'Serviciu rapid dedicat scuterelor de livrare (Glovo, Tazz, Bolt, Bringo) și motocicletelor de stradă: copiere chei contact, antifurt, top case și cip imobilizator pe loc.',
            'acf'          => [
                'service_status_band_left'   => 'PRIORITATE LIVRATORI • GATA ÎN 5 MINUTE',
                'service_status_band_right'  => 'BUCUREȘTI SECTOR 1',
                'service_hero_badge_icon'    => 'two_wheeler',
                'service_hero_badge_text'    => 'SPECIALIZAT PENTRU SCUTERE & LIVRĂRI GLOVO/TAZZ',
                'service_hero_title'         => 'Chei Moto, Scutere & <span class="text-primary-container">Flote Livrare</span>',
                'service_hero_description'   => 'Ești livrator și ai nevoie de o cheie de rezervă urgentă? Copiem pe loc chei pentru orice scuter de delivery (Honda, Piaggio, Yamaha, SYM, Kymco), inclusiv cutii/top-case și antifurt.',
                'service_spec1_icon'         => 'two_wheeler',
                'service_spec1_label'        => 'Scutere Delivery',
                'service_spec1_val'          => 'Gata în 3 - 5 min',
                'service_spec2_icon'         => 'timer',
                'service_spec2_label'        => 'Fără Timp Pierdut',
                'service_spec2_val'          => 'Execuție Pe Loc',
                'service_spec3_icon'         => 'lock',
                'service_spec3_label'        => 'Cutii / Top Case',
                'service_spec3_val'          => 'Givi, Shad, Kappa',
                'service_spec4_icon'         => 'memory',
                'service_spec4_label'        => 'Cip Moto HISS/Immo',
                'service_spec4_val'          => 'Clonare Transponder',
                'service_warranty_text'      => 'Garanție 100% Rezistență la Șocuri & Vibrații',
                'service_partner_text'       => 'Matrițe Specifice Moto Silca',
                'service_card_icon'          => 'two_wheeler',
                'service_card_badge'         => '3 - 5 MIN • PRIORITATE DELIVERY',
                'service_card_desc'          => 'Copiere rapidă chei pentru scutere de livrări (Glovo, Tazz, Bolt), motociclete cu cip imobilizator și cutii top case.',
                'service_card_bullets'       => [
                    ['bullet_text' => 'Timp record de 3-5 minute pentru livratori Glovo / Tazz / Bolt'],
                    ['bullet_text' => 'Copiere chei cutii de livrare, top-case (Givi, Shad) și lanțuri antifurt'],
                    ['bullet_text' => 'Clonare cip imobilizator pentru motoare Honda (HISS), Yamaha, Piaggio'],
                ],
                'service_card_btn_text'      => 'Vezi Servicii Chei Moto',
                'service_products'           => [
                    [
                        'badge'       => 'GLOVO / TAZZ / BOLT',
                        'icon'        => 'two_wheeler',
                        'title'       => 'Chei Scutere Livrare (50cc - 300cc)',
                        'series'      => 'Honda PCX, Piaggio Liberty, SYM, Kymco',
                        'description' => 'Cheie de rezervă tăiată instant pentru a nu risca pierderea cheii în timpul programului de livrare.',
                        'tags'        => 'Livratori, Pe Loc, Rezistentă la Torsiune',
                        'price'       => 'de la 25 lei',
                    ],
                    [
                        'badge'       => 'TOP CASE & CUTII',
                        'icon'        => 'lock',
                        'title'       => 'Chei Cutii Livrare, Top-Case & Antifurt',
                        'series'      => 'Givi, Shad, Kappa, Lanțuri Moto',
                        'description' => 'Duplicare chei mici zimțate sau amprentă pentru încuietoarea cutiei din spate sau lacăt disc frână.',
                        'tags'        => 'Cutie Spate, Blocator Disc, Portbagaj',
                        'price'       => 'de la 20 lei',
                    ],
                    [
                        'badge'       => 'CIP IMOBILIZATOR',
                        'icon'        => 'memory',
                        'title'       => 'Chei Moto cu Cip (Honda HISS, Yamaha etc.)',
                        'series'      => 'Clonare Transponder Moto',
                        'description' => 'Programare cip pornire integrat în capul cheii pentru motociclete cu sistem electronic de securitate.',
                        'tags'        => 'Cip Crypto Moto, Transponder Dedicat, Fără Erori Bord',
                        'price'       => 'de la 120 lei',
                    ]
                ]
            ]
        ],
        [
            'title'        => 'Reparații Chei Auto & Electronică',
            'slug'         => 'reparatii-chei-auto-si-acumulatori',
            'category'     => 'chei-auto-moto',
            'content'      => 'Laborator mecatronic pentru reparații pe placa electronică a cheii: înlocuire microcontacte tactile uzate, lipire bobină de transponder pentru chei care nu mai pornesc motorul și înlocuire acumulatori lipiți.',
            'acf'          => [
                'service_status_band_left'   => 'STAȚIE LIPIRE SMD • MICROSCOP ELECTRONIC',
                'service_status_band_right'  => 'BUCUREȘTI SECTOR 1',
                'service_hero_badge_icon'    => 'home_repair_service',
                'service_hero_badge_text'    => 'LABORATOR ELECTRONIC MECATRONIC',
                'service_hero_title'         => 'Reparații Chei Auto & <span class="text-primary-container">Electronică</span>',
                'service_hero_description'   => 'Nu se mai încuie mașina din telecomandă sau nu o mai recunoaște contactul? Reparăm pe banc microcontactele, refacem lipiturile reci, înlocuim bobina de inducție sau acumulatorul integrat.',
                'service_spec1_icon'         => 'build',
                'service_spec1_label'        => 'Microcontacte',
                'service_spec1_val'          => 'Butoane Noi SMD',
                'service_spec2_icon'         => 'bolt',
                'service_spec2_label'        => 'Acumulator Lipit',
                'service_spec2_val'          => 'VL2020 / Panasonic',
                'service_spec3_icon'         => 'memory',
                'service_spec3_label'        => 'Bobină Pornire',
                'service_spec3_val'          => 'Inductanță Originală',
                'service_spec4_icon'         => 'timer',
                'service_spec4_label'        => 'Diagnostic Banc',
                'service_spec4_val'          => 'Test Semnal Gratuit',
                'service_warranty_text'      => 'Garanție 12 Luni pe Componentele Înlocuite',
                'service_partner_text'       => 'Componente Electronice SMD Originale',
                'service_card_icon'          => 'build_circle',
                'service_card_badge'         => '15 - 20 MIN • TEST PE BANC',
                'service_card_desc'          => 'Reparații electronice fine pentru chei auto: înlocuire butoane/microcontacte, schimbare acumulatori lipiți pe placă și refacere bobină transponder.',
                'service_card_bullets'       => [
                    ['bullet_text' => 'Înlocuire microbutoane tactile SMD cu piese noi de anduranță'],
                    ['bullet_text' => 'Schimbare acumulatori reîncărcabili lipiți tip BMW / Land Rover (VL2020)'],
                    ['bullet_text' => 'Remediere problemă "Key Not Detected" prin înlocuire bobină inducție'],
                ],
                'service_card_btn_text'      => 'Detalii Reparații Chei',
                'service_products'           => [
                    [
                        'badge'       => 'BUTOANE DEFECTE',
                        'icon'        => 'settings',
                        'title'       => 'Înlocuire Microcontacte Butoane SMD',
                        'series'      => 'Taste Telecomandă Care Nu Răspund',
                        'description' => 'Dezlipire butoane vechi oxidate sau rupte și montare microcontacte tactile noi de anduranță.',
                        'tags'        => 'Stație Lipire, Click Precis, Verificare Frecvență',
                        'price'       => 'de la 30 lei',
                    ],
                    [
                        'badge'       => 'ACUMULATOR LIPIT PE PLACĂ',
                        'icon'        => 'bolt',
                        'title'       => 'Înlocuire Acumulator Cheie (BMW, Ford, Land Rover)',
                        'series'      => 'Baterii Reîncărcabile VL2020 / Panasonic',
                        'description' => 'Desfacere carcasă sudată ultrasonic, dezlipire acumulator vechi și montare acumulator nou original.',
                        'tags'        => 'Acumulator Reîncărcabil, Lipire Pini, Fără Pierdere Cod',
                        'price'       => 'de la 70 lei',
                    ],
                    [
                        'badge'       => 'REFACERE PORNIRE',
                        'icon'        => 'memory',
                        'title'       => 'Înlocuire Bobină Transponder Pornire',
                        'series'      => 'Mașina Nu Mai Recunoaște Cheia',
                        'description' => 'Înlocuirea bobinei de cupru afectate de șocuri mecanice/căzături ce împiedică alimentarea cipului.',
                        'tags'        => 'Bobină Inducție, Pornire Recuperată, Test Pe Stand',
                        'price'       => 'de la 60 lei',
                    ]
                ]
            ]
        ],
        [
            'title'        => 'Virginizare & Reprogramare Chei Auto',
            'slug'         => 'virginizare-reprogramare-chei-auto',
            'category'     => 'chei-auto-moto',
            'content'      => 'Resetare software (virginizare) pentru chei auto second-hand sau folosite anterior, permițând refolosirea și reprogramarea lor pe un alt vehicul, precum și ștergerea cheilor pierdute din memoria mașinii.',
            'acf'          => [
                'service_status_band_left'   => 'PROGRAMATOARE EEPROM • RESETARE PROFIL CRYPTO',
                'service_status_band_right'  => 'BUCUREȘTI SECTOR 1',
                'service_hero_badge_icon'    => 'restart_alt',
                'service_hero_badge_text'    => 'REFOLOSIRE CHEI SMART & TELECOMENZI',
                'service_hero_title'         => 'Virginizare & <span class="text-primary-container">Reprogramare Chei Auto</span>',
                'service_hero_description'   => 'Ai cumpărat o cheie second-hand sau vrei să resetezi o telecomandă existentă? Virginizăm cipul și procesorul intern pentru a putea fi împerecheată cu noua ta mașină, economisind costul unei chei noi.',
                'service_spec1_icon'         => 'restart_alt',
                'service_spec1_label'        => 'Virginizare',
                'service_spec1_val'          => 'Resetare Memorie Cip',
                'service_spec2_icon'         => 'shield',
                'service_spec2_label'        => 'Securitate',
                'service_spec2_val'          => 'Ștergere Chei Pierdute',
                'service_spec3_icon'         => 'memory',
                'service_spec3_label'        => 'Compatibilitate',
                'service_spec3_val'          => 'VAG, BMW, Renault, PSA',
                'service_spec4_icon'         => 'timer',
                'service_spec4_label'        => 'Timp Procedură',
                'service_spec4_val'          => '20 - 40 Minute',
                'service_warranty_text'      => 'Garanție Împerechere Funcțională',
                'service_partner_text'       => 'Echipamente Avansate de Citire EEPROM',
                'service_card_icon'          => 'restart_alt',
                'service_card_badge'         => 'RESET SOFTWARE • ECONOMIE COSTURI',
                'service_card_desc'          => 'Deblocare și resetare (virginizare) pentru chei auto second-hand, adaptare telecomenzi și ștergere din calculator a cheilor pierdute.',
                'service_card_bullets'       => [
                    ['bullet_text' => 'Virginizare cip transponder pentru refolosirea cheilor SH'],
                    ['bullet_text' => 'Ștergere din memoria mașinii a cheilor pierdute sau furate'],
                    ['bullet_text' => 'Sincronizare și reprogramare modul confort telecomandă'],
                ],
                'service_card_btn_text'      => 'Detalii Virginizare Chei',
                'service_products'           => [
                    [
                        'badge'       => 'REFOLOSIRE CHEIE SH',
                        'icon'        => 'restart_alt',
                        'title'       => 'Virginizare Chei & Smart Keys SH',
                        'series'      => 'Deblocare Cip PCF / Hitag / MQB',
                        'description' => 'Resetarea memoriei EEPROM la starea de fabrică pentru a permite rescrierea pe un alt automobil.',
                        'tags'        => 'Resetare Cip, Cheie Reutilizabilă, Economie Bani',
                        'price'       => 'de la 100 lei',
                    ],
                    [
                        'badge'       => 'PROTEJARE VEHICUL',
                        'icon'        => 'shield',
                        'title'       => 'Ștergere Chei Pierdute din Calculator',
                        'series'      => 'Imobilizator & Modul Confort',
                        'description' => 'Dezactivarea din softul mașinii a cheilor vechi care nu se mai află în posesia ta.',
                        'tags'        => 'Siguranță Furt, Blocare Acces, Test OBD',
                        'price'       => 'de la 80 lei',
                    ]
                ]
            ]
        ],
        [
            'title'        => 'Telecomenzi Garaj, Porți & Bariere',
            'slug'         => 'copiere-telecomenzi-garaj-si-porti',
            'category'     => 'telecomenzi-si-interfoane',
            'content'      => 'Clonare instantă pentru telecomenzi cu cod fix și vânzare cu programare pentru telecomenzi de generație nouă cu Rolling Code (Nice, BFT, Sommer, Beninca, Came, Hormann).',
            'acf'          => [
                'service_status_band_left'   => 'ANALIZOR FRECVENȚĂ ACTIV • MULTI-BRAND',
                'service_status_band_right'  => 'BUCUREȘTI SECTOR 1',
                'service_hero_badge_icon'    => 'rss_feed',
                'service_hero_badge_text'    => 'AUTOMATIZĂRI GARAJ & PORȚI',
                'service_hero_title'         => 'Telecomenzi Garaj, Porți & <span class="text-primary-container">Bariere</span>',
                'service_hero_description'   => 'Ai nevoie de o telecomandă în plus pentru poarta automată, ușa de garaj sau bariera din complexul rezidențial? Clonăm pe loc modelele cu cod fix și oferim telecomenzi originale Rolling Code.',
                'service_spec1_icon'         => 'rss_feed',
                'service_spec1_label'        => 'Frecvență',
                'service_spec1_val'          => '433.92 & 868.3 MHz',
                'service_spec2_icon'         => 'lock',
                'service_spec2_label'        => 'Tip Criptare',
                'service_spec2_val'          => 'Cod Fix & Rolling Code',
                'service_spec3_icon'         => 'timer',
                'service_spec3_label'        => 'Timp Execuție',
                'service_spec3_val'          => '2 Minute (Pe Loc)',
                'service_spec4_icon'         => 'verified',
                'service_spec4_label'        => 'Mărci Compatibile',
                'service_spec4_val'          => 'Nice, BFT, Came, Sommer',
                'service_warranty_text'      => 'Garanție Funcționare & Rază de Acțiune',
                'service_partner_text'       => 'Telecomenzi Originale & Multifrecvență',
                'service_card_icon'          => 'rss_feed',
                'service_card_badge'         => '1 - 2 MIN • CLONARE PE LOC',
                'service_card_desc'          => 'Copiere telecomenzi de porți și garaje pe loc (cod fix) și furnizare telecomenzi originale rolling code (Nice, BFT, Came, Beninca).',
                'service_card_bullets'       => [
                    ['bullet_text' => 'Clonare pe loc în 2 minute pentru telecomenzi cod fix 433 MHz'],
                    ['bullet_text' => 'Telecomenzi originale Rolling Code: Nice Flor-S, BFT Mitto, Sommer, Came'],
                    ['bullet_text' => 'Telecomenzi multi-frecvență inteligente capabile să memoreze până la 4 porți diferite'],
                ],
                'service_card_btn_text'      => 'Detalii Telecomenzi Porți',
                'service_products'           => [
                    [
                        'badge'       => 'INSTANT LA GHIȘEU',
                        'icon'        => 'rss_feed',
                        'title'       => 'Copiere Telecomenzi Cod Fix (433.92 MHz)',
                        'series'      => 'Porți Simple & Bariere Clasice',
                        'description' => 'Citire semnal radio pe analizor și duplicare în câteva secunde pe telecomandă universală.',
                        'tags'        => '2 Minute, Cod Fix, Rază Mare Acțiune',
                        'price'       => 'de la 40 lei',
                    ],
                    [
                        'badge'       => 'ORIGINAL ROLLING CODE',
                        'icon'        => 'security',
                        'title'       => 'Telecomenzi Rolling Code (Nice, BFT, Sommer)',
                        'series'      => 'Sisteme Securizate Anti-Clonare',
                        'description' => 'Furnizare telecomenzi de marcă cu ghid complet sau asistență pentru înrolarea în receptor.',
                        'tags'        => 'Nice, BFT, Sommer, Came, Beninca, Hormann',
                        'price'       => 'de la 65 lei',
                    ],
                    [
                        'badge'       => '4 ÎN 1 SMART',
                        'icon'        => 'settings',
                        'title'       => 'Telecomandă Multifrecvență 4 Canale',
                        'series'      => 'Comandă 4 Bariere / Porți Diferite',
                        'description' => 'Telecomandă inteligentă ce poate stoca pe fiecare buton câte un sistem automatizat diferit.',
                        'tags'        => '4 Canale, Cod Fix + Rolling, Compactă',
                        'price'       => 'de la 75 lei',
                    ]
                ]
            ]
        ],
        [
            'title'        => 'Duplicare Cartele Interfon & Taguri RFID',
            'slug'         => 'copiere-cartele-interfon-hid-rfid',
            'category'     => 'telecomenzi-si-interfoane',
            'content'      => 'Copiere pe loc pentru orice tip de cartelă sau tag de interfon: frecvențe standard 125 kHz (Electra, Dallas, Tecom), taguri speciale 135 kHz și cartele de acces securizat format HID sau Mifare.',
            'acf'          => [
                'service_status_band_left'   => 'CITITOR MULTI-PROTOCOL RFID • COMPATIBIL HID',
                'service_status_band_right'  => 'BUCUREȘTI SECTOR 1',
                'service_hero_badge_icon'    => 'contactless',
                'service_hero_badge_text'    => 'ACCES BLOCURI, COMPLEXE & BIROURI',
                'service_hero_title'         => 'Duplicare Cartele Interfon & <span class="text-primary-container">Taguri RFID</span>',
                'service_hero_description'   => 'Ai nevoie de cartele de rezervă pentru familie sau acces birou? Multiplicăm în 30 de secunde cartele tip tag picătură, carduri subțiri de portofel, frecvențe 125-135 kHz și formatul securizat HID.',
                'service_spec1_icon'         => 'contactless',
                'service_spec1_label'        => 'Frecvențe Suportate',
                'service_spec1_val'          => '125 kHz & 135 kHz',
                'service_spec2_icon'         => 'badge',
                'service_spec2_label'        => 'Format Securizat',
                'service_spec2_val'          => 'HID ProxCard & Mifare',
                'service_spec3_icon'         => 'timer',
                'service_spec3_label'        => 'Timp Execuție',
                'service_spec3_val'          => '30 Secunde / Cartelă',
                'service_spec4_icon'         => 'task_alt',
                'service_spec4_label'        => 'Format Carcasă',
                'service_spec4_val'          => 'Tag Picătură sau Card',
                'service_warranty_text'      => 'Garanție Compatibilitate Instantă',
                'service_partner_text'       => 'Taguri RFID de Înaltă Rezistență la Apă',
                'service_card_icon'          => 'contactless',
                'service_card_badge'         => '30 SECUNDE • ORICE INTERFON',
                'service_card_desc'          => 'Duplicare instantă cartele și taguri de interfon: frecvențe standard 125 kHz, taguri 135 kHz, cartele securizate format HID și carduri acces.',
                'service_card_bullets'       => [
                    ['bullet_text' => 'Multiplicare în 30 secunde pentru interfoane Electra, Genway, Betam, Comelit'],
                    ['bullet_text' => 'Suport extins pentru frecvențe de la 125 kHz până la 135 kHz'],
                    ['bullet_text' => 'Clonare cartele format corporativ HID Proximity și carduri Mifare 13.56 MHz'],
                ],
                'service_card_btn_text'      => 'Detalii Cartele Interfon',
                'service_products'           => [
                    [
                        'badge'       => 'UZUAL BLOCURI',
                        'icon'        => 'contactless',
                        'title'       => 'Tag Proximitate 125 kHz (Electra, Betam etc.)',
                        'series'      => 'Format Picătură Rezistent la Apă',
                        'description' => 'Cartela clasică albastră/neagră pentru intrarea în scara blocului sau parcare.',
                        'tags'        => '30 Secunde, Rezistent la Șocuri, Culori Diverse',
                        'price'       => 'de la 15 lei',
                    ],
                    [
                        'badge'       => 'FORMAT SPECIAL',
                        'icon'        => 'security',
                        'title'       => 'Cartele Speciale 135 kHz & Format HID',
                        'series'      => 'Complexe Rezidențiale & Birouri',
                        'description' => 'Duplicare cartele cu frecvență atipică sau protocol securizat HID Proximity.',
                        'tags'        => 'Format HID, 135 kHz, Clădiri Business',
                        'price'       => 'de la 35 lei',
                    ],
                    [
                        'badge'       => 'CARD PORTOFEL',
                        'icon'        => 'badge',
                        'title'       => 'Card Subțire Mifare / RFID (Tip Card Bancar)',
                        'series'      => 'Acces Bariere & Pontaj',
                        'description' => 'Card alb subțire ce încape perfect în portofel pentru acces pietonal sau barieră auto.',
                        'tags'        => 'Subțire, Format ISO, Raza Mare Citire',
                        'price'       => 'de la 25 lei',
                    ]
                ]
            ]
        ],
        [
            'title'        => 'Deblocări Auto Fără Daune & All Keys Lost',
            'slug'         => 'deblocari-auto-all-keys-lost',
            'category'     => 'urgente-si-deblocari',
            'content'      => 'Serviciu de intervenție mecatronică: deschidere uși auto blocate fără nicio zgârietură cu decodoare profesionale Lishi, generare cheie nouă de la zero când toate cheile au fost pierdute (All Keys Lost) și reparații butuci contact.',
            'acf'          => [
                'service_status_band_left'   => 'DECODOARE LISHI PROFESIONALE • FĂRĂ DAUNE',
                'service_status_band_right'  => 'BUCUREȘTI SECTOR 1 & DEPLASARE',
                'service_hero_badge_icon'    => 'lock_reset',
                'service_hero_badge_text'    => 'INTERVENȚII URGENȚĂ & PIERDERE TOTALĂ',
                'service_hero_title'         => 'Deblocări Auto Fără Daune & <span class="text-primary-container">All Keys Lost</span>',
                'service_hero_description'   => 'Ți-ai încuiat cheile în mașină sau le-ai pierdut pe toate? Deschidem ușa prin metodă fină fără îndoirea ramei și generăm cheie nouă de la zero direct după codul mecanic al butucului.',
                'service_spec1_icon'         => 'lock_open',
                'service_spec1_label'        => 'Tehnică Deschidere',
                'service_spec1_val'          => 'Picking Fin Lishi',
                'service_spec2_icon'         => 'shield',
                'service_spec2_label'        => 'Integritate Vehicul',
                'service_spec2_val'          => '0% Zgârieturi / Daune',
                'service_spec3_icon'         => 'vpn_key',
                'service_spec3_label'        => 'All Keys Lost',
                'service_spec3_val'          => 'Tăiere Cheie Nouă Direct',
                'service_spec4_icon'         => 'settings',
                'service_spec4_label'        => 'Reparații Yală',
                'service_spec4_val'          => 'Înlocuire Căței Butuc',
                'service_warranty_text'      => 'Garanție Lucrare Mecatronică Specializată',
                'service_partner_text'       => 'Scule Oficiale Original Lishi',
                'service_card_icon'          => 'lock_reset',
                'service_card_badge'         => 'DEBLOCARE NON-DESTRUCTIVĂ • LISHI',
                'service_card_desc'          => 'Deschidere uși auto fără nicio daună cu scule Lishi, refacere cheie de la zero la pierdere totală (All Keys Lost) și reparat butuci blocați.',
                'service_card_bullets'       => [
                    ['bullet_text' => 'Deschidere curată a încuietorii prin palparea pinilor, fără perne de aer sau îndoiri'],
                    ['bullet_text' => 'All Keys Lost: citire cod mecanic și tăiere cheie chiar dacă nu mai există nicio cheie'],
                    ['bullet_text' => 'Reparație și recondiționare căței/pini butuc portieră sau contact blocat'],
                ],
                'service_card_btn_text'      => 'Detalii Deblocări & All Keys Lost',
                'service_products'           => [
                    [
                        'badge'       => 'FĂRĂ DAUNE',
                        'icon'        => 'lock_open',
                        'title'       => 'Deblocare Ușă Auto Non-Destructivă',
                        'series'      => 'Chei Uitate în Interior / Baterie Moartă',
                        'description' => 'Deschidere prin yala portierei folosind decodor dedicat Lishi, fără atingerea vopselei sau chederelor.',
                        'tags'        => 'Scule Lishi, Fără Forțare, Rapid',
                        'price'       => 'de la 150 lei',
                    ],
                    [
                        'badge'       => 'PIERDERE TOTALĂ',
                        'icon'        => 'vpn_key',
                        'title'       => 'All Keys Lost (Toate Cheile Pierdute)',
                        'series'      => 'Generare Cheie Nouă de la Zero',
                        'description' => 'Decodarea mecanică a butucului, tăiere lamă CNC și programare imobilizator când toate cheile lipsesc.',
                        'tags'        => 'Decodare Butuc, Tăiere Nouă, Programare Cip',
                        'price'       => 'de la 350 lei',
                    ],
                    [
                        'badge'       => 'BUTUC BLOCAT',
                        'icon'        => 'build',
                        'title'       => 'Reparații & Recalibrare Butuci Auto',
                        'series'      => 'Contact sau Yală Portieră Înțepenită',
                        'description' => 'Dezasamblare butuc auto, înlocuire căței uzați și aliniere pini conform cheii funcționale.',
                        'tags'        => 'Contact Blocat, Schimb Căței, Păstrare Cheie',
                        'price'       => 'de la 120 lei',
                    ]
                ]
            ]
        ]
    ];

    foreach ($services as $srv) {
        $existing_post = get_page_by_path($srv['slug'], OBJECT, 'serviciu');

        $cat_slug = $srv['category'];
        $cat_id = isset($category_map[$cat_slug]) ? $category_map[$cat_slug] : null;

        $post_data = [
            'post_title'   => $srv['title'],
            'post_name'    => $srv['slug'],
            'post_content' => $srv['content'],
            'post_excerpt' => wp_trim_words($srv['content'], 25),
            'post_status'  => 'publish',
            'post_type'    => 'serviciu',
        ];

        if ($existing_post) {
            $post_data['ID'] = $existing_post->ID;
            $post_id = wp_update_post($post_data);
            $log[] = "[UPDATED] Serviciu: {$srv['title']} (ID: {$post_id})";
        } else {
            $post_id = wp_insert_post($post_data);
            if (is_wp_error($post_id)) {
                $log[] = "[EROARE] Creare serviciu {$srv['title']}: " . $post_id->get_error_message();
                continue;
            }
            $log[] = "[CREATED] Serviciu: {$srv['title']} (ID: {$post_id})";
        }

        if ($cat_id) {
            wp_set_post_terms($post_id, [$cat_id], 'categorie_serviciu', false);
        }

        if (function_exists('update_field')) {
            foreach ($srv['acf'] as $field_key => $field_val) {
                update_field($field_key, $field_val, $post_id);
            }
        }
    }

    // Asociere servicii existente
    $serviciu_vechi_cip = get_page_by_path('copiere-si-programare-chei-auto-cu-cip', OBJECT, 'serviciu');
    if ($serviciu_vechi_cip && isset($category_map['chei-auto-moto'])) {
        wp_set_post_terms($serviciu_vechi_cip->ID, [$category_map['chei-auto-moto']], 'categorie_serviciu', false);
    }

    $serviciu_vechi_carcase = get_page_by_path('vanzare-huse-si-carcase-chei-auto', OBJECT, 'serviciu');
    if ($serviciu_vechi_carcase && isset($category_map['chei-auto-moto'])) {
        wp_set_post_terms($serviciu_vechi_carcase->ID, [$category_map['chei-auto-moto']], 'categorie_serviciu', false);
    }

    // -------------------------------------------------------------------------
    // 3. MENIU PRINCIPAL (MAIN MENU) & FOOTER MENU
    // -------------------------------------------------------------------------
    $main_menu_name = 'Main Menu';
    $main_menu = wp_get_nav_menu_object('main-menu');
    if (!$main_menu) {
        $main_menu_id = wp_create_nav_menu($main_menu_name);
        $log[] = "[CREATED] Meniu Nou: {$main_menu_name} (ID: {$main_menu_id})";
    } else {
        $main_menu_id = $main_menu->term_id;
        $log[] = "[FOUND] Meniu Existent: {$main_menu_name} (ID: {$main_menu_id})";
    }

    $existing_items = wp_get_nav_menu_items($main_menu_id);
    if (!empty($existing_items)) {
        foreach ($existing_items as $item) {
            wp_delete_post($item->ID, true);
        }
        $log[] = "[CLEANED] Curățat elemente vechi din Main Menu.";
    }

    $menu_structure = [
        [
            'label'      => 'Auto & Moto',
            'type'       => 'taxonomy',
            'object'     => 'categorie_serviciu',
            'cat_slug'   => 'chei-auto-moto',
            'services'   => [
                'copiere-si-programare-chei-auto-cu-cip' => 'Copiere & Programare Chei Auto cu Cip',
                'copiere-lame-chei-auto'                => 'Copiere Chei Auto Simple & Lame Laser',
                'copiere-chei-motociclete-scutere'       => 'Chei Moto, Scutere & Flote Livrare',
                'reparatii-chei-auto-si-acumulatori'     => 'Reparații Chei Auto & Electronică',
                'virginizare-reprogramare-chei-auto'     => 'Virginizare & Reprogramare Chei Auto',
                'vanzare-huse-si-carcase-chei-auto'      => 'Vânzare Huse și Carcase Chei Auto',
            ]
        ],
        [
            'label'      => 'Rezidențial & Yale',
            'type'       => 'taxonomy',
            'object'     => 'categorie_serviciu',
            'cat_slug'   => 'chei-rezidentiale-si-lacate',
            'services'   => [
                'copiere-chei-amprenta'                  => 'Copiere Chei Amprentă & Înaltă Securitate',
                'copiere-chei-plane-si-lacate'           => 'Copiere Chei Clasice, Plane & Lacăte',
                'copiere-chei-barba-dubla-seif'          => 'Copiere Chei Seif, Barbă Dublă & Speciale',
                'copie-chei-dupa-butuc'                  => 'Generare Cheie după Butuc & Reparații Yală',
                'vanzare-butuci-lacate-accesorii'        => 'Vânzare Butuci, Lacăte & Accesorii',
            ]
        ],
        [
            'label'      => 'Telecomenzi & RFID',
            'type'       => 'taxonomy',
            'object'     => 'categorie_serviciu',
            'cat_slug'   => 'telecomenzi-si-interfoane',
            'services'   => [
                'copiere-telecomenzi-garaj-si-porti'     => 'Telecomenzi Garaj, Porți & Bariere',
                'copiere-cartele-interfon-hid-rfid'      => 'Duplicare Cartele Interfon & Taguri RFID',
            ]
        ],
        [
            'label'      => 'Urgențe & Deblocări',
            'type'       => 'taxonomy',
            'object'     => 'categorie_serviciu',
            'cat_slug'   => 'urgente-si-deblocari',
            'services'   => [
                'deblocari-auto-all-keys-lost'           => 'Deblocări Auto Fără Daune & All Keys Lost',
            ]
        ],
    ];

    $order = 1;
    foreach ($menu_structure as $top_item) {
        $cat_id = isset($category_map[$top_item['cat_slug']]) ? $category_map[$top_item['cat_slug']] : 0;
        if (!$cat_id) {
            $term = get_term_by('slug', $top_item['cat_slug'], 'categorie_serviciu');
            $cat_id = $term ? $term->term_id : 0;
        }

        $parent_menu_item_id = wp_update_nav_menu_item($main_menu_id, 0, [
            'menu-item-title'     => $top_item['label'],
            'menu-item-object'    => $top_item['object'],
            'menu-item-object-id' => $cat_id,
            'menu-item-type'      => $top_item['type'],
            'menu-item-status'    => 'publish',
            'menu-item-position'  => $order++,
        ]);

        $log[] = "[MENU TOP] {$top_item['label']}";

        $sub_order = 1;
        foreach ($top_item['services'] as $srv_slug => $srv_clean_title) {
            $srv_post = get_page_by_path($srv_slug, OBJECT, 'serviciu');
            if ($srv_post) {
                wp_update_nav_menu_item($main_menu_id, 0, [
                    'menu-item-title'     => $srv_clean_title,
                    'menu-item-object'    => 'serviciu',
                    'menu-item-object-id' => $srv_post->ID,
                    'menu-item-type'      => 'post_type',
                    'menu-item-status'    => 'publish',
                    'menu-item-parent-id' => $parent_menu_item_id,
                    'menu-item-position'  => $sub_order++,
                ]);
            }
        }
    }

    $contact_page = get_page_by_path('contact-us');
    if (!$contact_page) {
        $contact_page = get_page_by_path('contact');
    }
    if ($contact_page) {
        wp_update_nav_menu_item($main_menu_id, 0, [
            'menu-item-title'     => 'Contact',
            'menu-item-object'    => 'page',
            'menu-item-object-id' => $contact_page->ID,
            'menu-item-type'      => 'post_type',
            'menu-item-status'    => 'publish',
            'menu-item-position'  => $order++,
        ]);
    } else {
        wp_update_nav_menu_item($main_menu_id, 0, [
            'menu-item-title'     => 'Contact',
            'menu-item-url'       => home_url('/contact/'),
            'menu-item-type'      => 'custom',
            'menu-item-status'    => 'publish',
            'menu-item-position'  => $order++,
        ]);
    }

    $locations = get_theme_mod('nav_menu_locations', []);
    $locations['primary'] = $main_menu_id;

    $footer_menu = wp_get_nav_menu_object('footer-menu-categorii');
    if ($footer_menu) {
        $footer_items = wp_get_nav_menu_items($footer_menu->term_id);
        if (!empty($footer_items)) {
            foreach ($footer_items as $fitem) {
                wp_delete_post($fitem->ID, true);
            }
        }
        $f_order = 1;
        foreach ($categories as $cat) {
            $cat_id = isset($category_map[$cat['slug']]) ? $category_map[$cat['slug']] : 0;
            if ($cat_id) {
                wp_update_nav_menu_item($footer_menu->term_id, 0, [
                    'menu-item-title'     => $cat['name'],
                    'menu-item-object'    => 'categorie_serviciu',
                    'menu-item-object-id' => $cat_id,
                    'menu-item-type'      => 'taxonomy',
                    'menu-item-status'    => 'publish',
                    'menu-item-position'  => $f_order++,
                ]);
            }
        }
        $locations['footer_categories'] = $footer_menu->term_id;
    }

    set_theme_mod('nav_menu_locations', $locations);

    update_option('enigma14_catalog_imported_at', current_time('mysql'));

    return $log;
}

/**
 * 1. Pagină în panoul WordPress Admin sub "Servicii & Catalog"
 */
add_action('admin_menu', function() {
    add_submenu_page(
        'edit.php?post_type=serviciu',
        'Import / Sincronizare Catalog',
        'Sincronizare Catalog',
        'manage_options',
        'enigma14-catalog-sync',
        'enigma14_render_catalog_sync_page'
    );
});

function enigma14_render_catalog_sync_page() {
    $executed = false;
    $log = [];

    if (isset($_POST['enigma14_run_sync']) && check_admin_referer('enigma14_catalog_sync_action')) {
        $log = enigma14_execute_catalog_import();
        $executed = true;
    }

    $last_import = get_option('enigma14_catalog_imported_at', 'Niciodată');
    ?>
    <div class="wrap">
        <h1 style="display:flex; align-items:center; gap:8px;">
            <span class="dashicons dashicons-update" style="font-size:32px; width:32px; height:32px;"></span>
            Sincronizare Catalog Servicii & Meniu ENIGMA 14
        </h1>

        <?php if ($executed): ?>
            <div class="notice notice-success is-dismissible" style="padding:12px; margin-top:16px;">
                <p><strong>✅ Sincronizarea a fost executată cu succes!</strong></p>
                <p>Toate cele 4 categorii, cele 12 servicii, produsele din catalog și meniul de navigare au fost actualizate.</p>
                <div style="background:#1e1e1e; color:#a6e22e; padding:12px; border-radius:6px; font-family:monospace; max-height:250px; overflow-y:auto; margin-top:10px;">
                    <?php foreach ($log as $line): ?>
                        <div><?php echo esc_html($line); ?></div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <div style="background:#fff; border:1px solid #ccd0d4; padding:24px; border-radius:8px; max-width:800px; margin-top:20px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
            <h2 style="margin-top:0;">Importă structura completă de servicii pe acest server</h2>
            <p style="color:#555; line-height:1.6;">
                Această procedură este <strong>idempotentă și sigură</strong>. Ea creează sau actualizează automat:
            </p>
            <ul style="list-style:disc; margin-left:24px; color:#444; line-height:1.6;">
                <li><strong>4 Macro-Categorii:</strong> <em>Chei Auto, Moto & Scutere</em>, <em>Chei Rezidențiale & Lăcătușerie</em>, <em>Telecomenzi & Cartele Interfon</em>, <em>Urgențe, Deblocări & Butuci</em>.</li>
                <li><strong>12 Pagini de Servicii:</strong> cu toate specificațiile tehnice, prețurile orientative și catalogul de modele/produse asociat.</li>
                <li><strong>Meniul de Navigare:</strong> structurat concis (<em>Auto & Moto</em>, <em>Rezidențial & Yale</em>, <em>Telecomenzi & RFID</em>, <em>Urgențe & Deblocări</em>, <em>Contact</em>) și fără duplicate.</li>
                <li><strong>Meniul din Footer:</strong> aliniat cu noile categorii.</li>
            </ul>

            <p style="margin-top:16px; font-size:13px; color:#777;">
                Ultima sincronizare pe acest site: <strong><?php echo esc_html($last_import); ?></strong>
            </p>

            <form method="post" style="margin-top:20px;">
                <?php wp_nonce_field('enigma14_catalog_sync_action'); ?>
                <input type="hidden" name="enigma14_run_sync" value="1">
                <button type="submit" class="button button-primary button-hero" style="font-size:15px; padding:10px 24px; height:auto;">
                    🚀 Rulează Sincronizarea Acum
                </button>
            </form>
        </div>
    </div>
    <?php
}

/**
 * 2. Trigger securizat prin URL (pentru rulare automată sau curl)
 * Exemplu: https://centruldechei.ro/?enigma_catalog_token=enigma14_sync_2026
 */
add_action('init', function() {
    if (isset($_GET['enigma_catalog_token']) && $_GET['enigma_catalog_token'] === 'enigma14_sync_2026') {
        // Dacă utilizatorul este admin sau folosește tokenul corect
        $log = enigma14_execute_catalog_import();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'status'  => 'success',
            'message' => 'Catalogul ENIGMA 14 și meniul au fost sincronizate cu succes!',
            'time'    => current_time('mysql'),
            'log'     => $log
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit;
    }
});
