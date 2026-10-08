// DOM Ready
jQuery(document).ready(function($) {
    var $header = $('.scheduleHeader');
    if ($header.length) {
        var weekdaysStr = $header.attr('data-weekdays') || '08:30 - 19:30';
        var saturdayStr = $header.attr('data-saturday') || '09:00 - 15:00';
        var now = new Date();
        var day = now.getDay();
        var hour = now.getHours();
        var min = now.getMinutes();
        var currentMinutes = hour * 60 + min;
        function parseTime(str) {
            var match = str.match(/(\d{1,2}):(\d{2})\s*-\s*(\d{1,2}):(\d{2})/);
            if (match) {
                return {
                    start: parseInt(match[1], 10) * 60 + parseInt(match[2], 10),
                    end: parseInt(match[3], 10) * 60 + parseInt(match[4], 10)
                };
            }
            return null;
        }
        var isOpen = false;
        if (day >= 1 && day <= 5) {
            var hours = parseTime(weekdaysStr);
            if (hours && currentMinutes >= hours.start && currentMinutes < hours.end) isOpen = true;
        } else if (day === 6) {
            var hours = parseTime(saturdayStr);
            if (hours && currentMinutes >= hours.start && currentMinutes < hours.end) isOpen = true;
        }
        var $dotOuter = $header.find('.animate-ping');
        var $dotInner = $header.find('.relative.inline-flex.rounded-full');
        var $text = $header.find('span.font-bold').last();
        if (isOpen) {
            $dotOuter.removeClass('bg-[#ef4444]').addClass('bg-[#10b981]');
            $dotInner.removeClass('bg-[#ef4444] shadow-[0_0_10px_#ef4444]').addClass('bg-[#10b981] shadow-[0_0_10px_#10b981]');
            $text.text('DESCHIS ACUM - Atelier Mecatronic Sector 1');
        } else {
            $dotOuter.removeClass('bg-[#10b981]').addClass('bg-[#ef4444]');
            $dotInner.removeClass('bg-[#10b981] shadow-[0_0_10px_#10b981]').addClass('bg-[#ef4444] shadow-[0_0_10px_#ef4444]');
            $text.text('ÎNCHIS - Atelier Mecatronic Sector 1');
        }
    }

    // ====================================================
    // ENIGMA 14 Assessment Form AJAX Handler
    // ====================================================
    $(document).on('submit', '.enigma-assessment-form', function(e) {
        e.preventDefault();
        var $form = $(this);
        var $submitBtn = $form.find('button[type="submit"]');
        var $btnText = $submitBtn.find('.btn-text');
        var $btnIcon = $submitBtn.find('.btn-icon');
        var originalBtnHtml = $submitBtn.html();

        var $errorContainer = $form.find('.enigma-form-error');
        $errorContainer.addClass('hidden').empty();

        // Get values
        var formData = $form.serializeArray();
        var dataObj = {
            action: 'enigma14_submit_assessment',
            assessment_nonce: (typeof enigma14_ajax !== 'undefined') ? enigma14_ajax.nonce : $form.find('input[name="assessment_nonce"]').val()
        };

        $.each(formData, function(i, field) {
            dataObj[field.name] = field.value;
        });

        // Set Loading State
        $submitBtn.prop('disabled', true).addClass('opacity-80 cursor-wait');
        $submitBtn.html('<span class="material-symbols-outlined animate-spin text-[18px]">progress_activity</span><span>Se transmite cererea...</span>');

        var ajaxUrl = (typeof enigma14_ajax !== 'undefined') ? enigma14_ajax.ajax_url : '/wp-admin/admin-ajax.php';

        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: dataObj,
            dataType: 'json',
            success: function(res) {
                if (res.success) {
                    var waUrl = res.data.whatsapp_url || '#';
                    var successHtml = '' +
                        '<div class="p-space-md sm:p-space-lg rounded bg-surface-container-high border border-primary-container text-center space-y-space-sm animate-fade-in">' +
                            '<div class="w-12 h-12 mx-auto rounded-full bg-primary-container/20 flex items-center justify-center text-primary-container shadow-[0_0_20px_rgba(255,119,0,0.3)]">' +
                                '<span class="material-symbols-outlined text-[32px]">check_circle</span>' +
                            '</div>' +
                            '<h4 class="font-headline-sm uppercase text-on-surface font-bold text-[16px] tracking-wide">Solicitare Transmisă cu Succes!</h4>' +
                            '<p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">' + (res.data.message || 'Un tehnician ENIGMA 14 te va contacta în sub 15 minute.') + '</p>' +
                            '<div class="pt-space-2xs">' +
                                '<a href="' + waUrl + '" target="_blank" rel="noopener noreferrer" class="enigma-wa-btn inline-flex items-center justify-center gap-2 w-full py-space-sm px-space-md rounded bg-[#25D366] hover:bg-[#20ba59] text-[#072410] hover:text-black font-label-action text-label-action uppercase tracking-wider font-extrabold transition-all shadow-lg hover:shadow-[#25D366]/30">' +
                                    '<span class="material-symbols-outlined text-[18px]">chat</span>' +
                                    '<span>Deschide și pe WhatsApp</span>' +
                                '</a>' +
                            '</div>' +
                        '</div>';
                    $form.replaceWith(successHtml);
                } else {
                    $submitBtn.prop('disabled', false).removeClass('opacity-80 cursor-wait').html(originalBtnHtml);
                    $errorContainer.removeClass('hidden').text(res.data.message || 'A apărut o eroare. Te rugăm să încerci din nou.');
                }
            },
            error: function() {
                $submitBtn.prop('disabled', false).removeClass('opacity-80 cursor-wait').html(originalBtnHtml);
                $errorContainer.removeClass('hidden').text('Eroare de conexiune la server. Te rugăm să ne contactezi telefonic la 0722 000 114.');
            }
        });
    });

    // ====================================================
    // ENIGMA 14 Global Booking & Photo Modal
    // ====================================================
    var $bookingModal = $('#enigma-booking-modal');

    function openBookingModal() {
        if ($bookingModal.length) {
            $bookingModal.removeClass('hidden');
            setTimeout(function() {
                $bookingModal.removeClass('opacity-0').find('.scale-95').removeClass('scale-95').addClass('scale-100');
            }, 10);
            $('body').addClass('overflow-hidden');
        }
    }

    function closeBookingModal() {
        if ($bookingModal.length) {
            $bookingModal.addClass('opacity-0').find('.scale-100').removeClass('scale-100').addClass('scale-95');
            setTimeout(function() {
                $bookingModal.addClass('hidden');
                $('body').removeClass('overflow-hidden');
            }, 300);
        }
    }

    // Open triggers
    $(document).on('click', '.enigma-open-booking-modal, [data-open-modal="booking"]', function(e) {
        e.preventDefault();
        openBookingModal();
    });

    // Close triggers
    $(document).on('click', '.enigma-close-modal', function(e) {
        e.preventDefault();
        closeBookingModal();
    });

    // Escape key closes modal
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' && !$bookingModal.hasClass('hidden')) {
            closeBookingModal();
        }
    });

    // Dropzone interaction
    var $dropzone = $('#enigma-modal-dropzone');
    var $fileInput = $('#enigma-modal-file');
    var $idleState = $('#enigma-dropzone-idle');
    var $previewState = $('#enigma-dropzone-preview');
    var $previewThumb = $('#enigma-preview-thumb');
    var $previewName = $('#enigma-preview-filename');
    var $previewSize = $('#enigma-preview-size');

    $dropzone.on('click', function(e) {
        if (!$(e.target).closest('#enigma-remove-file').length) {
            $fileInput.trigger('click');
        }
    });

    // Instant Quick Photo Upload to Server
    function uploadQuickPhoto(file, $fileInput, $statusContainer) {
        if (!file) return null;
        var formData = new FormData();
        formData.append('action', 'enigma14_quick_photo_upload');
        formData.append('photo', file);
        formData.append('upload_nonce', (typeof enigma14_ajax !== 'undefined' && enigma14_ajax.upload_nonce) ? enigma14_ajax.upload_nonce : '');

        if ($statusContainer && $statusContainer.length) {
            $statusContainer.html('<span class="inline-flex items-center gap-1 text-primary"><span class="material-symbols-outlined text-[13px] animate-spin">sync</span><span>Se procesează poza pentru WhatsApp...</span></span>');
        }

        var ajaxUrl = (typeof enigma14_ajax !== 'undefined') ? enigma14_ajax.ajax_url : '/wp-admin/admin-ajax.php';
        
        var uploadPromise = $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json'
        }).done(function(res) {
            if (res.success && res.data && res.data.url) {
                $fileInput.attr('data-uploaded-url', res.data.url);
                $fileInput.data('uploaded-url', res.data.url);
                if ($statusContainer && $statusContainer.length) {
                    $statusContainer.html('<span class="inline-flex items-center gap-1 text-[#25D366] font-semibold"><span class="material-symbols-outlined text-[14px]">check_circle</span><span>Poză pregătită pentru WhatsApp</span></span>');
                }
            } else {
                if ($statusContainer && $statusContainer.length) {
                    $statusContainer.html('<span class="text-amber-400">Poză selectată local</span>');
                }
            }
        }).fail(function() {
            if ($statusContainer && $statusContainer.length) {
                $statusContainer.html('<span class="text-amber-400">Poză selectată local</span>');
            }
        });

        $fileInput.data('upload-promise', uploadPromise);
        return uploadPromise;
    }

    function handleFile(file) {
        if (!file) return;
        if (!file.type.match('image.*')) {
            alert('Te rugăm să selectezi un fișier de tip imagine (JPG, PNG, WEBP, etc.).');
            return;
        }

        var reader = new FileReader();
        reader.onload = function(e) {
            $previewThumb.attr('src', e.target.result);
            $previewName.text(file.name);
            var sizeKb = Math.round(file.size / 1024);
            $previewSize.text(sizeKb > 1024 ? (sizeKb / 1024).toFixed(1) + ' MB' : sizeKb + ' KB');
            $idleState.addClass('hidden');
            $previewState.removeClass('hidden');

            // Trigger instant upload in background for WhatsApp & Diagnoza
            uploadQuickPhoto(file, $fileInput, $('#enigma-upload-status'));
        };
        reader.readAsDataURL(file);
    }

    $fileInput.on('change', function() {
        if (this.files && this.files[0]) {
            handleFile(this.files[0]);
        }
    });

    // Drag and drop events
    $dropzone.on('dragover dragenter', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $dropzone.addClass('border-primary-container bg-surface-container-high');
    });

    $dropzone.on('dragleave dragend drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $dropzone.removeClass('border-primary-container bg-surface-container-high');
    });

    $dropzone.on('drop', function(e) {
        var dt = e.originalEvent.dataTransfer;
        if (dt && dt.files && dt.files.length) {
            $fileInput[0].files = dt.files;
            handleFile(dt.files[0]);
        }
    });

    // Remove file
    $(document).on('click', '#enigma-remove-file', function(e) {
        e.stopPropagation();
        $fileInput.val('');
        $fileInput.removeAttr('data-uploaded-url');
        $fileInput.removeData('uploaded-url');
        $fileInput.removeData('upload-promise');
        $idleState.removeClass('hidden');
        $previewState.addClass('hidden');
        $previewThumb.attr('src', '');
        $('#enigma-upload-status').empty();
    });

    // Modal AJAX Form Submit
    $('#enigma-booking-form').on('submit', function(e) {
        e.preventDefault();
        var $form = $(this);
        var $submitBtn = $form.find('button[type="submit"]');
        var originalBtnHtml = $submitBtn.html();
        var $errorContainer = $form.find('.enigma-modal-error');

        $errorContainer.addClass('hidden').empty();

        var formData = new FormData(this);
        formData.append('action', 'enigma14_submit_modal_booking');

        $submitBtn.prop('disabled', true).addClass('opacity-80 cursor-wait');
        $submitBtn.html('<span class="material-symbols-outlined animate-spin text-[18px]">progress_activity</span><span>Se transmite...</span>');

        var ajaxUrl = (typeof enigma14_ajax !== 'undefined') ? enigma14_ajax.ajax_url : '/wp-admin/admin-ajax.php';

        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(res) {
                if (res.success) {
                    $form.addClass('hidden');
                    $('#enigma-booking-success').removeClass('hidden');
                    if (res.data.whatsapp_url) {
                        $('#enigma-success-wa-link').attr('href', res.data.whatsapp_url);
                    }
                } else {
                    $submitBtn.prop('disabled', false).removeClass('opacity-80 cursor-wait').html(originalBtnHtml);
                    $errorContainer.removeClass('hidden').text(res.data.message || 'A apărut o eroare. Te rugăm să încerci din nou.');
                }
            },
            error: function() {
                $submitBtn.prop('disabled', false).removeClass('opacity-80 cursor-wait').html(originalBtnHtml);
                $errorContainer.removeClass('hidden').text('Eroare de conexiune la server. Te rugăm să ne contactezi telefonic la 0722 000 114.');
            }
        });
    });

    // ====================================================
    // ENIGMA 14 Universal Dynamic WhatsApp Pre-filled Handler
    // Automatically injects filled form details & Photo URLs into ANY WhatsApp link
    // ====================================================
    $(document).on('click', 'a[href*="wa.me"], a[href*="whatsapp.com"]', function(e) {
        var $btn = $(this);
        var currentHref = $btn.attr('href') || '';

        // Extract clean destination phone number from href
        var phoneMatch = currentHref.match(/wa\.me\/([0-9]+)/) || currentHref.match(/phone=([0-9]+)/);
        var waPhone = phoneMatch ? phoneMatch[1] : '40722000114';

        // 1. Check if inside or related to the Global Booking Modal Form
        var $modalForm = $btn.closest('#enigma-booking-modal').find('#enigma-booking-form');
        if ($btn.hasClass('enigma-wa-modal-btn') || $modalForm.length) {
            var name        = $.trim($modalForm.find('input[name="client_name"]').val());
            var phone       = $.trim($modalForm.find('input[name="phone"]').val());
            var service     = $.trim($modalForm.find('select[name="service_type"]').val());
            var time        = $.trim($modalForm.find('select[name="preferred_time"]').val());
            var notes       = $.trim($modalForm.find('input[name="notes"]').val());
            var $fInput     = $modalForm.find('#enigma-modal-file');
            var file        = ($fInput.length && $fInput[0].files && $fInput[0].files[0]) ? $fInput[0].files[0] : null;
            var uploadedUrl = $fInput.attr('data-uploaded-url') || $fInput.data('uploaded-url') || '';
            var uploadProm  = $fInput.data('upload-promise');

            // Helper to build WhatsApp URL
            function openWhatsAppChat(photoUrl) {
                var waMsg = "Buna ziua, doresc o programare / diagnoza ENIGMA 14:\n";
                if (name)     waMsg += "• Nume: " + name + "\n";
                if (phone)    waMsg += "• Telefon: " + phone + "\n";
                if (service)  waMsg += "• Serviciu: " + service + "\n";
                if (time)     waMsg += "• Interval dorit: " + time + "\n";
                if (notes)    waMsg += "• Detalii: " + notes + "\n";
                if (photoUrl) waMsg += "• Foto piesă/cheie: " + photoUrl + "\n";
                else if (file) waMsg += "• Foto: Am selectat o poză pentru identificare\n";

                var targetUrl = 'https://wa.me/' + waPhone + '?text=' + encodeURIComponent(waMsg);
                window.open(targetUrl, '_blank');
            }

            // If a file is selected and upload is in progress, wait for completion
            if (file && !uploadedUrl && uploadProm && uploadProm.state() === 'pending') {
                e.preventDefault();
                var originalHtml = $btn.html();
                $btn.addClass('opacity-75 pointer-events-none');
                $btn.html('<span class="material-symbols-outlined text-[18px] animate-spin">sync</span><span>Se atașează poza...</span>');

                uploadProm.always(function() {
                    $btn.removeClass('opacity-75 pointer-events-none').html(originalHtml);
                    var finalUrl = $fInput.attr('data-uploaded-url') || $fInput.data('uploaded-url') || '';
                    openWhatsAppChat(finalUrl);
                });
                return;
            }

            if (name || phone || notes || file || uploadedUrl || service) {
                // If on mobile device, try native Web Share API with actual photo file
                var isMobile = /Android|iPhone|iPad|iPod/i.test(navigator.userAgent);
                if (isMobile && file && navigator.canShare && navigator.canShare({ files: [file] })) {
                    e.preventDefault();
                    var shareMsg = "Buna ziua, doresc o programare / diagnoza ENIGMA 14:\n";
                    if (name)    shareMsg += "• Nume: " + name + "\n";
                    if (phone)   shareMsg += "• Telefon: " + phone + "\n";
                    if (service) shareMsg += "• Serviciu: " + service + "\n";
                    if (time)    shareMsg += "• Interval dorit: " + time + "\n";
                    if (notes)   shareMsg += "• Detalii: " + notes + "\n";

                    navigator.share({
                        files: [file],
                        title: 'Programare ENIGMA 14',
                        text: shareMsg
                    }).catch(function() {
                        // User dismissed or failed, fallback to direct WhatsApp URL with uploaded photo link
                        openWhatsAppChat(uploadedUrl);
                    });
                    return;
                }

                // Standard WhatsApp link redirection with uploaded photo URL
                e.preventDefault();
                openWhatsAppChat(uploadedUrl);
                return;
            }
        }

        // 2. Check if inside or associated with the Quick Assessment Form
        var $section = $btn.closest('section');
        var $assessmentForm = $btn.closest('.enigma-assessment-form');
        if (!$assessmentForm.length && $section.length) {
            $assessmentForm = $section.find('.enigma-assessment-form');
        }

        if ($assessmentForm.length) {
            var f1 = $.trim($assessmentForm.find('input[name="field_1"]').val());
            var f2 = $.trim($assessmentForm.find('input[name="field_2"]').val());
            var phone = $.trim($assessmentForm.find('input[name="phone"]').val());
            var service = $.trim($assessmentForm.find('select[name="service_type"]').val());
            var mode = $assessmentForm.find('input[name="form_mode"]').val() || 'auto';

            if (f1 || f2 || phone) {
                var isResidential = (mode === 'residential');
                var label1 = isResidential ? "Tip Cheie / Yală" : "Marca & Modelul Mașinii";
                var label2 = isResidential ? "Cartelă / Serie Cod" : "An Fabricație";

                var waMsg = "Buna ziua, doresc o evaluare rapida ENIGMA 14:\n";
                if (f1)      waMsg += "• " + label1 + ": " + f1 + "\n";
                if (f2)      waMsg += "• " + label2 + ": " + f2 + "\n";
                if (service) waMsg += "• Serviciu: " + service + "\n";
                if (phone)   waMsg += "• Telefon: " + phone + "\n";

                $btn.attr('href', 'https://wa.me/' + waPhone + '?text=' + encodeURIComponent(waMsg));
                return;
            }
        }

        // 3. General Fallback for ANY Form or Section on the site
        var $anyForm = $btn.closest('form');
        if (!$anyForm.length && $section.length) {
            $anyForm = $section.find('form');
        }

        if ($anyForm.length) {
            var lines = [];
            $anyForm.find('input, select, textarea').each(function() {
                var $input = $(this);
                var type = $input.attr('type');
                if (type === 'hidden' || type === 'submit') return;
                
                if (type === 'file') {
                    var uploadedPhoto = $input.attr('data-uploaded-url') || $input.data('uploaded-url');
                    if (uploadedPhoto) {
                        lines.push("• Foto: " + uploadedPhoto);
                    }
                    return;
                }

                var val = $.trim($input.val());
                if (!val) return;

                var label = $input.closest('div').find('label').text() || $input.attr('placeholder') || $input.attr('name');
                label = $.trim(label).replace(/[*:]/g, '');
                if (label && val) {
                    lines.push("• " + label + ": " + val);
                }
            });

            if (lines.length > 0) {
                var waMsg = "Buna ziua, trimit solicitarea mea catre ENIGMA 14:\n" + lines.join("\n");
                $btn.attr('href', 'https://wa.me/' + waPhone + '?text=' + encodeURIComponent(waMsg));
            }
        }
    });

    // ====================================================
    // ENIGMA 14 Mobile Menu Drawer Toggle Handler
    // ====================================================
    var $menuToggle = $('#enigma-mobile-menu-toggle');
    var $mobileMenu = $('#enigma-mobile-menu');
    var $menuIcon   = $('#enigma-mobile-menu-icon');

    function toggleMobileMenu(open) {
        var shouldOpen = (typeof open === 'boolean') ? open : $mobileMenu.hasClass('hidden');
        if (shouldOpen) {
            $mobileMenu.removeClass('hidden');
            $menuToggle.attr('aria-expanded', 'true');
            $menuIcon.text('close');
            $('body').addClass('overflow-hidden lg:overflow-auto');
        } else {
            $mobileMenu.addClass('hidden');
            $menuToggle.attr('aria-expanded', 'false');
            $menuIcon.text('menu');
            $('body').removeClass('overflow-hidden lg:overflow-auto');
        }
    }

    $menuToggle.on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        toggleMobileMenu();
    });

    // Close when clicking any menu link
    $mobileMenu.on('click', 'a', function() {
        toggleMobileMenu(false);
    });

    // Close when clicking outside of header
    $(document).on('click', function(e) {
        if (!$(e.target).closest('header').length && !$mobileMenu.hasClass('hidden')) {
            toggleMobileMenu(false);
        }
    });

    // Close on Escape key
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' && !$mobileMenu.hasClass('hidden')) {
            toggleMobileMenu(false);
        }
    });

    // Auto-close menu if screen resized to desktop (>= 1024px)
    $(window).on('resize', function() {
        if ($(window).width() >= 1024 && !$mobileMenu.hasClass('hidden')) {
            toggleMobileMenu(false);
        }
    });

    // ====================================================
    // ENIGMA 14 Contact Page Form & Photo Upload
    // ====================================================
    var $contactForm = $('#enigma-contact-page-form');
    var $keyUploadInput = $('#key-upload-input');
    var $contactDropZone = $('#drop-zone');
    var $contactUploadStatus = $('#upload-status');
    var $dropZoneIdle = $('#drop-zone-idle');
    var $dropZonePreview = $('#drop-zone-preview');
    var $previewImg = $('#contact-photo-preview-img');
    var $previewName = $('#contact-photo-name');
    var $previewSize = $('#contact-photo-size');

    if ($keyUploadInput.length) {
        // Drag & drop visual states
        $contactDropZone.on('dragover dragenter', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $contactDropZone.addClass('border-primary-container bg-surface-container-high');
        });

        $contactDropZone.on('dragleave dragend drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $contactDropZone.removeClass('border-primary-container bg-surface-container-high');
        });

        $contactDropZone.on('drop', function(e) {
            var dt = e.originalEvent.dataTransfer;
            if (dt && dt.files && dt.files.length) {
                $keyUploadInput[0].files = dt.files;
                handleContactFile(dt.files[0]);
            }
        });

        function handleContactFile(file) {
            if (!file) return;
            if (!file.type.match('image.*')) {
                alert('Te rugăm să selectezi un fișier de tip imagine (JPG, PNG, WEBP, HEIC).');
                return;
            }

            // Show local preview thumbnail instantly
            var reader = new FileReader();
            reader.onload = function(e) {
                if ($previewImg.length) $previewImg.attr('src', e.target.result);
                if ($previewName.length) $previewName.text(file.name);
                var sizeKb = Math.round(file.size / 1024);
                if ($previewSize.length) $previewSize.text(sizeKb > 1024 ? (sizeKb / 1024).toFixed(1) + ' MB' : sizeKb + ' KB');
                if ($dropZoneIdle.length) $dropZoneIdle.addClass('hidden');
                if ($dropZonePreview.length) $dropZonePreview.removeClass('hidden');
            };
            reader.readAsDataURL(file);

            $contactUploadStatus.html('<span class="inline-flex items-center gap-1 text-primary"><span class="material-symbols-outlined text-[13px] animate-spin">sync</span><span>Se optimizează poza cheii...</span></span>');
            
            var uploadPromise = uploadQuickPhoto(file, $keyUploadInput, $contactUploadStatus);
            if (uploadPromise) {
                uploadPromise.done(function(res) {
                    if (res.success && res.data && res.data.url) {
                        $('#uploaded-photo-url').val(res.data.url);
                    }
                });
            }
        }

        $keyUploadInput.on('change', function() {
            if (this.files && this.files[0]) {
                handleContactFile(this.files[0]);
            }
        });
    }

    if ($contactForm.length) {
        $contactForm.on('submit', function(e) {
            e.preventDefault();
            var $form = $(this);
            var $submitBtn = $form.find('button[type="submit"]');
            var originalBtnHtml = $submitBtn.html();
            var $feedback = $('#form-feedback');
            var $feedbackError = $('#form-feedback-error');

            $feedback.addClass('hidden');
            $feedbackError.addClass('hidden').empty();

            var formData = new FormData(this);
            formData.append('action', 'enigma14_submit_contact_form');
            var cNonce = (typeof enigma14_ajax !== 'undefined' && enigma14_ajax.contact_nonce) ? enigma14_ajax.contact_nonce : ($form.find('input[name="contact_nonce"]').val() || '');
            formData.append('contact_nonce', cNonce);

            // Check if photo is still uploading
            var uploadPromise = $keyUploadInput.data('upload-promise');
            function executeSubmit() {
                // Ensure uploaded url is attached if available
                var uploadedUrl = $keyUploadInput.attr('data-uploaded-url') || $keyUploadInput.data('uploaded-url') || $('#uploaded-photo-url').val();
                if (uploadedUrl) {
                    formData.set('uploaded_photo_url', uploadedUrl);
                }

                $submitBtn.prop('disabled', true).addClass('opacity-80 cursor-wait');
                $submitBtn.html('<span class="material-symbols-outlined animate-spin text-[18px]">progress_activity</span><span>Se transmite solicitarea...</span>');

                var ajaxUrl = (typeof enigma14_ajax !== 'undefined') ? enigma14_ajax.ajax_url : '/wp-admin/admin-ajax.php';

                $.ajax({
                    url: ajaxUrl,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(res) {
                        if (res.success) {
                            $form.slideUp(300, function() {
                                $feedback.removeClass('hidden');
                                if (res.data.whatsapp_url) {
                                    $('#contact-success-wa-link').attr('href', res.data.whatsapp_url);
                                }
                            });
                        } else {
                            $submitBtn.prop('disabled', false).removeClass('opacity-80 cursor-wait').html(originalBtnHtml);
                            $feedbackError.removeClass('hidden').text(res.data.message || 'A apărut o eroare. Te rugăm să încerci din nou.');
                        }
                    },
                    error: function() {
                        $submitBtn.prop('disabled', false).removeClass('opacity-80 cursor-wait').html(originalBtnHtml);
                        $feedbackError.removeClass('hidden').text('Eroare de comunicare cu serverul. Te rugăm să ne apelezi la 0722 000 114.');
                    }
                });
            }

            if (uploadPromise && uploadPromise.state() === 'pending') {
                $submitBtn.prop('disabled', true).addClass('opacity-80 cursor-wait');
                $submitBtn.html('<span class="material-symbols-outlined animate-spin text-[18px]">progress_activity</span><span>Se finalizează încărcarea pozei...</span>');
                uploadPromise.always(function() {
                    executeSubmit();
                });
            } else {
                executeSubmit();
            }
        });
    }
});


