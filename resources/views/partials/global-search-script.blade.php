<script>
(function () {
    if (window.__siteSearchInitialized) return;
    window.__siteSearchInitialized = true;

    document.addEventListener('DOMContentLoaded', function () {
        var dialog = document.getElementById('siteSearchDialog');
        var input = document.getElementById('siteSearchInput');
        var results = document.getElementById('siteSearchResults');
        if (!dialog || !input || !results) return;

        var endpoint = @json(route('search.programs'));
        var offerUrl = @json(route('dashboard', ['offer' => 1]));
        var timer = null;
        var controller = null;
        var activeIndex = -1;
        var resultLinks = [];
        var lastFocused = null;
        var previousOverflow = '';

        function isEnglish() {
            return window.UISI_LANGUAGE?.get?.() === 'en'
                || window.localStorage.getItem('uisi_language') === 'en';
        }

        function text(idText, enText) {
            return isEnglish() ? enText : idText;
        }

        function icon(kind) {
            var icons = {
                home: '<path d="M4 10.5 12 4l8 6.5V20a1 1 0 0 1-1 1h-5v-6h-4v6H5a1 1 0 0 1-1-1v-9.5Z" stroke-width="1.8" stroke-linejoin="round"/>',
                profile: '<circle cx="12" cy="8" r="3.2" stroke-width="1.8"/><path d="M5.5 20c.6-4 2.8-6 6.5-6s5.9 2 6.5 6" stroke-width="1.8" stroke-linecap="round"/>',
                calendar: '<rect x="4" y="5.5" width="16" height="14.5" rx="2" stroke-width="1.8"/><path d="M8 3v5M16 3v5M4 10h16" stroke-width="1.8" stroke-linecap="round"/>',
                program: '<path d="m3 9 9-5 9 5-9 5-9-5Z" stroke-width="1.8" stroke-linejoin="round"/><path d="M7 12v4.5c2.8 2 7.2 2 10 0V12M21 9v6" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>'
            };
            return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">' + (icons[kind] || icons.program) + '</svg>';
        }

        function createResult(item) {
            var link = document.createElement('a');
            link.className = 'site-search-result';
            link.href = item.url;
            link.setAttribute('role', 'option');

            var resultIcon = document.createElement('span');
            resultIcon.className = 'site-search-result-icon';
            resultIcon.innerHTML = icon(item.kind || 'program');

            var copy = document.createElement('span');
            copy.className = 'site-search-result-copy';
            var title = document.createElement('span');
            title.className = 'site-search-result-title';
            title.textContent = item.title;
            var meta = document.createElement('span');
            meta.className = 'site-search-result-meta';
            meta.textContent = item.meta;
            copy.append(title, meta);

            var side = document.createElement('span');
            side.className = 'site-search-result-side';
            if (item.status) {
                var badge = document.createElement('span');
                badge.className = 'site-search-result-badge' + (/soon|segera/i.test(item.status) ? ' is-soon' : '');
                badge.textContent = item.status;
                side.appendChild(badge);
            }
            side.insertAdjacentHTML('beforeend', '<svg class="site-search-result-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path d="m9 6 6 6-6 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>');
            link.append(resultIcon, copy, side);
            return link;
        }

        function appendGroup(label, items) {
            if (!items.length) return;
            var heading = document.createElement('p');
            heading.className = 'site-search-section-label';
            heading.textContent = label;
            var list = document.createElement('div');
            list.className = 'site-search-result-list';
            items.forEach(function (item) { list.appendChild(createResult(item)); });
            results.append(heading, list);
        }

        function launchOffer(event) {
            if (!window.agendaOfferController?.open) return;
            event.preventDefault();
            close();
            window.setTimeout(function () { window.agendaOfferController.open(); }, 260);
        }

        function initializeOfferPreview(preview, embed) {
            var slides = Array.from(preview.querySelectorAll('[data-agenda-slide]'));
            var dots = Array.from(preview.querySelectorAll('.agenda-offer-dot'));
            var previousButton = preview.querySelector('.site-search-preview-prev');
            var nextButton = preview.querySelector('.site-search-preview-next');
            var counter = preview.querySelector('.site-search-preview-counter');
            var slidesContainer = preview.querySelector('.site-search-preview-slides');
            var currentIndex = 0;
            var autoSlideTimer = null;
            var motionSequence = 0;
            var pointerState = null;
            var slideDuration = 420;
            var slideEasing = 'cubic-bezier(.22, 1, .36, 1)';

            if (!slides.length) return;

            function updateControls() {
                dots.forEach(function (dot, index) {
                    dot.classList.toggle('is-active', index === currentIndex);
                });
                if (counter) counter.textContent = (currentIndex + 1) + ' / ' + slides.length;
                var multiple = slides.length > 1;
                if (previousButton) previousButton.disabled = !multiple;
                if (nextButton) nextButton.disabled = !multiple;
            }

            function renderSlide(index, direction, animate) {
                var nextIndex = (index + slides.length) % slides.length;
                var previousSlide = slides.find(function (slide) { return slide.classList.contains('is-active'); });
                var nextSlide = slides[nextIndex];

                if (previousSlide === nextSlide) {
                    currentIndex = nextIndex;
                    updateControls();
                    return;
                }

                var sequence = ++motionSequence;
                slides.forEach(function (slide) {
                    slide.getAnimations().forEach(function (animation) { animation.cancel(); });
                    slide.style.removeProperty('transform');
                    slide.style.removeProperty('opacity');
                    slide.classList.remove('is-leaving', 'to-right', 'from-left');
                    if (slide !== previousSlide) slide.classList.remove('is-active');
                    slide.setAttribute('aria-hidden', 'true');
                });

                if (previousSlide && previousSlide !== nextSlide) {
                    previousSlide.classList.remove('is-active');
                    if (animate) previousSlide.classList.add('is-leaving');
                }

                nextSlide.classList.remove('is-leaving');
                nextSlide.classList.add('is-active');
                nextSlide.setAttribute('aria-hidden', 'false');
                currentIndex = nextIndex;

                if (animate && previousSlide && previousSlide !== nextSlide) {
                    var sign = direction === 'previous' ? -1 : 1;
                    var outgoing = previousSlide.animate([
                        { opacity: 1, transform: 'translate3d(0, 0, 0) scale(1)' },
                        { opacity: 0, transform: 'translate3d(' + (-20 * sign) + 'px, 0, 0) scale(.994)' }
                    ], { duration: slideDuration, easing: slideEasing, fill: 'both' });
                    var incoming = nextSlide.animate([
                        { opacity: .2, transform: 'translate3d(' + (28 * sign) + 'px, 0, 0) scale(.994)' },
                        { opacity: 1, transform: 'translate3d(0, 0, 0) scale(1)' }
                    ], { duration: slideDuration, easing: slideEasing, fill: 'both' });
                    Promise.allSettled([outgoing.finished, incoming.finished]).then(function () {
                        if (sequence !== motionSequence) return;
                        outgoing.cancel();
                        incoming.cancel();
                        previousSlide.classList.remove('is-leaving');
                    });
                }
                updateControls();
            }

            function scheduleAutoSlide() {
                window.clearTimeout(autoSlideTimer);
                autoSlideTimer = null;
            }

            function navigate(direction) {
                if (slides.length < 2) return;
                renderSlide(currentIndex + direction, direction > 0 ? 'next' : 'previous', true);
                scheduleAutoSlide();
            }

            preview.__searchOfferNavigate = navigate;
            preview.querySelectorAll('a').forEach(function (link) {
                link.addEventListener('click', function (event) { event.stopPropagation(); });
            });

            slidesContainer?.addEventListener('pointerdown', function (event) {
                if (!event.isPrimary || event.button !== 0 || event.target.closest('a, button')) return;
                pointerState = {
                    id: event.pointerId,
                    x: event.clientX,
                    y: event.clientY,
                    time: performance.now(),
                    dragging: false
                };
                slidesContainer.setPointerCapture?.(event.pointerId);
                window.clearTimeout(autoSlideTimer);
            });
            slidesContainer?.addEventListener('pointermove', function (event) {
                if (!pointerState || pointerState.id !== event.pointerId) return;
                var distanceX = event.clientX - pointerState.x;
                var distanceY = event.clientY - pointerState.y;
                if (!pointerState.dragging && Math.abs(distanceX) > 8 && Math.abs(distanceX) > Math.abs(distanceY)) {
                    pointerState.dragging = true;
                    slidesContainer.classList.add('is-dragging');
                }
                if (!pointerState.dragging) return;
                var activeSlide = slides[currentIndex];
                activeSlide.style.transform = 'translate3d(' + (distanceX * .3) + 'px, 0, 0) scale(.997)';
                activeSlide.style.opacity = String(Math.max(.75, 1 - Math.abs(distanceX) / 700));
            });
            slidesContainer?.addEventListener('pointerup', function (event) {
                if (!pointerState || pointerState.id !== event.pointerId) return;
                var distance = event.clientX - pointerState.x;
                var elapsed = Math.max(1, performance.now() - pointerState.time);
                var threshold = Math.min(64, (slidesContainer.clientWidth || 480) * .12);
                var shouldNavigate = pointerState.dragging && (Math.abs(distance) >= threshold || Math.abs(distance) / elapsed > .45);
                var activeSlide = slides[currentIndex];
                slidesContainer.classList.remove('is-dragging');
                pointerState = null;
                activeSlide.style.removeProperty('transform');
                activeSlide.style.removeProperty('opacity');
                if (shouldNavigate) {
                    embed.dataset.ignoreNextOpenUntil = String(Date.now() + 450);
                    navigate(distance > 0 ? -1 : 1);
                } else {
                    scheduleAutoSlide();
                }
            });
            slidesContainer?.addEventListener('pointercancel', function () {
                var activeSlide = slides[currentIndex];
                activeSlide?.style.removeProperty('transform');
                activeSlide?.style.removeProperty('opacity');
                slidesContainer.classList.remove('is-dragging');
                pointerState = null;
                scheduleAutoSlide();
            });

            slides.forEach(function (slide) { slide.classList.remove('is-active', 'is-leaving', 'to-right', 'from-left'); });
            renderSlide(0, 'next', false);
            scheduleAutoSlide();
        }

        function renderOfferShortcut() {
            var heading = document.createElement('p');
            heading.className = 'site-search-section-label';
            heading.textContent = text('Penawaran pilihan', 'Featured offer');

            var sourcePanel = document.querySelector('#agendaOffer .agenda-offer-panel');
            if (sourcePanel) {
                var embed = document.createElement('div');
                embed.className = 'site-search-offer-embed';
                embed.setAttribute('role', 'option');
                embed.addEventListener('click', function (event) {
                    if (Date.now() < Number(embed.dataset.ignoreNextOpenUntil || 0)) {
                        event.preventDefault();
                        return;
                    }
                    launchOffer(event);
                });

                var embedHead = document.createElement('div');
                embedHead.className = 'site-search-offer-embed-head';
                var embedCopy = document.createElement('div');
                embedCopy.className = 'site-search-offer-embed-copy';
                var embedTitle = document.createElement('strong');
                embedTitle.textContent = text('Popup penawaran program', 'Program offer popup');
                var embedMeta = document.createElement('span');
                embedMeta.textContent = text('Klik preview untuk membuka kembali', 'Select the preview to reopen');
                embedCopy.append(embedTitle, embedMeta);
                embedHead.append(embedCopy);

                var preview = sourcePanel.cloneNode(true);
                preview.classList.add('site-search-offer-preview');
                var previewClose = preview.querySelector('#agendaOfferClose');
                if (previewClose) previewClose.classList.add('site-search-preview-close');
                var previewSlides = preview.querySelector('#agendaOfferSlides');
                if (previewSlides) previewSlides.classList.add('site-search-preview-slides');
                var previewPrevious = preview.querySelector('#agendaOfferPrev');
                if (previewPrevious) previewPrevious.classList.add('site-search-preview-prev');
                var previewNext = preview.querySelector('#agendaOfferNext');
                if (previewNext) previewNext.classList.add('site-search-preview-next');
                var previewCounter = preview.querySelector('#agendaOfferCounter');
                if (previewCounter) previewCounter.classList.add('site-search-preview-counter');
                var previewProgress = preview.querySelector('#agendaOfferProgressBar');
                if (previewProgress) previewProgress.classList.add('site-search-preview-progress');
                preview.querySelectorAll('[id]').forEach(function (element) { element.removeAttribute('id'); });
                preview.querySelectorAll('a').forEach(function (element) { element.setAttribute('tabindex', '-1'); });
                preview.querySelectorAll('.is-leaving').forEach(function (slide) { slide.classList.remove('is-leaving', 'to-right'); });
                if (!preview.querySelector('.agenda-offer-slide.is-active')) {
                    var firstSlide = preview.querySelector('.agenda-offer-slide');
                    if (firstSlide) firstSlide.classList.add('is-active');
                }

                embed.append(embedHead, preview);
                results.append(heading, embed);
                initializeOfferPreview(preview, embed);
                return;
            }

            var card = document.createElement('a');
            card.className = 'site-search-offer-card';
            card.href = offerUrl;
            card.setAttribute('role', 'option');

            var cardIcon = document.createElement('span');
            cardIcon.className = 'site-search-offer-icon';
            cardIcon.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path d="M20 12v8H4v-8M2 7h20v5H2V7zm10 13V7m0 0H7.5A2.5 2.5 0 0 1 5 4.5 2.5 2.5 0 0 1 7.5 2C10 2 12 7 12 7Zm0 0h4.5A2.5 2.5 0 0 0 19 4.5 2.5 2.5 0 0 0 16.5 2C14 2 12 7 12 7Z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>';

            var copy = document.createElement('span');
            copy.className = 'site-search-offer-copy';
            var eyebrow = document.createElement('span');
            eyebrow.className = 'site-search-offer-eyebrow';
            eyebrow.textContent = text('Sorotan program UISI', 'UISI program highlights');
            var title = document.createElement('strong');
            title.className = 'site-search-offer-title';
            title.textContent = text('Lihat penawaran program terbaru', 'Explore the latest program offers');
            var meta = document.createElement('span');
            meta.className = 'site-search-offer-meta';
            meta.textContent = text(
                'Temukan program yang sedang dibuka dan agenda pilihan yang akan segera hadir.',
                'Discover open programs and selected upcoming opportunities.'
            );
            var tags = document.createElement('span');
            tags.className = 'site-search-offer-tags';
            [text('Program pilihan', 'Selected programs'), text('Informasi resmi', 'Official information')].forEach(function (label) {
                var tag = document.createElement('span');
                tag.textContent = label;
                tags.appendChild(tag);
            });
            copy.append(eyebrow, title, meta, tags);

            var action = document.createElement('span');
            action.className = 'site-search-offer-action';
            var actionLabel = document.createElement('span');
            actionLabel.textContent = text('Buka popup', 'Open offer');
            action.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path d="m9 6 6 6-6 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
            action.prepend(actionLabel);

            card.append(cardIcon, copy, action);
            card.addEventListener('click', launchOffer);
            results.append(heading, card);
        }

        function syncLinks() {
            resultLinks = Array.from(results.querySelectorAll('.site-search-result, .site-search-offer-card, .site-search-offer-embed'));
            activeIndex = -1;
            resultLinks.forEach(function (link, index) { link.id = 'site-search-option-' + index; });
            input.removeAttribute('aria-activedescendant');
        }

        function renderStart() {
            results.classList.add('is-offer-preview');
            results.replaceChildren();
            renderOfferShortcut();
            results.scrollTop = 0;
            syncLinks();
        }

        function renderLoading() {
            results.classList.remove('is-offer-preview');
            results.innerHTML = '<div class="site-search-loading" aria-label="Memuat hasil"><div class="site-search-loading-row"></div><div class="site-search-loading-row"></div><div class="site-search-loading-row"></div></div>';
            results.scrollTop = 0;
            syncLinks();
        }

        function renderMatches(programs) {
            results.classList.remove('is-offer-preview');
            results.replaceChildren();
            results.scrollTop = 0;
            appendGroup(text('Program', 'Programs'), programs.map(function (program) {
                return Object.assign({ kind: 'program' }, program);
            }));

            if (!programs.length) {
                var empty = document.createElement('div');
                empty.className = 'site-search-empty';
                empty.innerHTML = '<div><span class="site-search-empty-icon">' + icon('program') + '</span><strong></strong><p></p></div>';
                empty.querySelector('strong').textContent = text('Belum ada hasil yang cocok', 'No matching results yet');
                empty.querySelector('p').textContent = text(
                    'Coba kata kunci lain seperti “sertifikasi”, “bahasa”, atau nama program.',
                    'Try another keyword such as “certification”, “language”, or a program name.'
                );
                results.appendChild(empty);
            }
            syncLinks();
        }

        async function search() {
            var query = input.value.trim();
            window.clearTimeout(timer);
            if (controller) controller.abort();
            if (query.length < 2) {
                renderStart();
                return;
            }

            renderLoading();
            controller = new AbortController();
            try {
                var url = new URL(endpoint, window.location.origin);
                url.searchParams.set('q', query);
                url.searchParams.set('lang', isEnglish() ? 'en' : 'id');
                var response = await fetch(url, { headers: { 'Accept': 'application/json' }, signal: controller.signal });
                if (!response.ok) throw new Error('Search request failed');
                var payload = await response.json();
                if (input.value.trim() !== query) return;
                renderMatches(payload.programs || []);
            } catch (error) {
                if (error.name !== 'AbortError') renderMatches([]);
            }
        }

        function updateLanguage() {
            dialog.querySelectorAll('[data-id-text][data-en-text]').forEach(function (element) {
                element.textContent = isEnglish() ? element.dataset.enText : element.dataset.idText;
            });
            document.querySelectorAll('[data-search-trigger-label]').forEach(function (element) {
                element.textContent = text('Cari program', 'Search programs');
            });
            input.placeholder = text('Cari program UISI...', 'Search UISI programs...');
            input.setAttribute('aria-label', input.placeholder);
        }

        function open() {
            if (dialog.classList.contains('is-open')) return;
            var mobileMenu = document.getElementById('mobileMenu');
            if (mobileMenu) mobileMenu.classList.remove('is-open');
            var mobileMenuButton = document.getElementById('mobileMenuBtn');
            if (mobileMenuButton) mobileMenuButton.setAttribute('aria-expanded', 'false');
            var menuIcon = document.getElementById('menuIcon');
            var closeIcon = document.getElementById('closeIcon');
            if (menuIcon) menuIcon.style.display = 'block';
            if (closeIcon) closeIcon.style.display = 'none';
            lastFocused = document.activeElement;
            previousOverflow = document.body.style.overflow;
            document.body.style.overflow = 'hidden';
            updateLanguage();
            dialog.classList.add('is-open');
            dialog.setAttribute('aria-hidden', 'false');
            renderStart();
            window.setTimeout(function () { input.focus(); }, 40);
        }

        function close() {
            if (!dialog.classList.contains('is-open')) return;
            if (controller) controller.abort();
            dialog.classList.remove('is-open');
            dialog.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = previousOverflow;
            input.value = '';
            if (lastFocused && typeof lastFocused.focus === 'function') lastFocused.focus();
        }

        function move(direction) {
            if (!resultLinks.length) return;
            activeIndex = (activeIndex + direction + resultLinks.length) % resultLinks.length;
            resultLinks.forEach(function (link, index) { link.classList.toggle('is-active', index === activeIndex); });
            var active = resultLinks[activeIndex];
            input.setAttribute('aria-activedescendant', active.id);
            active.scrollIntoView({ block: 'nearest' });
        }

        document.querySelectorAll('[data-site-search-open]').forEach(function (button) { button.addEventListener('click', open); });
        document.querySelectorAll('[data-site-search-close]').forEach(function (button) { button.addEventListener('click', close); });
        results.addEventListener('click', function (event) {
            var control = event.target.closest('.site-search-preview-prev, .site-search-preview-next');
            if (!control || !results.contains(control)) return;
            var preview = control.closest('.site-search-offer-preview');
            if (!preview || typeof preview.__searchOfferNavigate !== 'function') return;
            event.preventDefault();
            event.stopImmediatePropagation();
            preview.__searchOfferNavigate(control.classList.contains('site-search-preview-next') ? 1 : -1);
        }, true);
        input.addEventListener('input', function () {
            window.clearTimeout(timer);
            timer = window.setTimeout(search, 180);
        });
        input.addEventListener('keydown', function (event) {
            if (event.key === 'ArrowDown') { event.preventDefault(); move(1); }
            if (event.key === 'ArrowUp') { event.preventDefault(); move(-1); }
            if (event.key === 'Enter' && activeIndex >= 0) {
                event.preventDefault();
                resultLinks[activeIndex].click();
            }
        });
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && dialog.classList.contains('is-open')) {
                event.preventDefault();
                close();
                return;
            }
            var target = event.target;
            var typing = target instanceof HTMLElement && (target.isContentEditable || /^(INPUT|TEXTAREA|SELECT)$/.test(target.tagName));
            if (event.key === '/' && !typing && !event.ctrlKey && !event.metaKey && !event.altKey) {
                event.preventDefault();
                open();
            }
        });
        window.addEventListener('uisi:languagechange', function () {
            updateLanguage();
            if (!dialog.classList.contains('is-open')) return;
            if (input.value.trim().length >= 2) search(); else renderStart();
        });
        updateLanguage();
    });
})();
</script>
