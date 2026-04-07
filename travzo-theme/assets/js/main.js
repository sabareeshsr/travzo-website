/* Travzo Holidays – Main JavaScript */

(function () {
    'use strict';

    // ── Scroll shadow on main-nav ──────────────────────────────────────────
    const mainNav = document.getElementById('main-nav');

    if (mainNav) {
        const handleScroll = () => {
            mainNav.classList.toggle('scrolled', window.scrollY > 10);
        };
        window.addEventListener('scroll', handleScroll, { passive: true });
        handleScroll(); // run once on load in case page is already scrolled
    }

    // ── Hero Slideshow ──────────────────────────────────────────────────────
    (function initHeroSlideshow() {
        var container = document.querySelector('.hero-slideshow');
        if (!container) return;

        var heroSection = container.closest('.hero-section');
        var slides   = container.querySelectorAll('.hero-slide');
        var dots     = heroSection.querySelectorAll('.hero-dot');
        var prevBtn  = heroSection.querySelector('.hero-prev');
        var nextBtn  = heroSection.querySelector('.hero-next');
        var interval = parseInt(container.getAttribute('data-interval'), 10) || 5000;
        var current  = 0;
        var timer    = null;

        function showSlide(idx) {
            current = (idx + slides.length) % slides.length;
            for (var i = 0; i < slides.length; i++) {
                slides[i].classList.toggle('active', i === current);
                if (dots[i]) dots[i].classList.toggle('active', i === current);
            }
        }

        function next() { showSlide(current + 1); }
        function prev() { showSlide(current - 1); }

        function startAuto() {
            stopAuto();
            timer = setInterval(next, interval);
        }
        function stopAuto() {
            if (timer) { clearInterval(timer); timer = null; }
        }

        if (prevBtn) prevBtn.addEventListener('click', function () { prev(); startAuto(); });
        if (nextBtn) nextBtn.addEventListener('click', function () { next(); startAuto(); });

        dots.forEach(function (dot) {
            dot.addEventListener('click', function () {
                showSlide(parseInt(this.getAttribute('data-index'), 10));
                startAuto();
            });
        });

        // Pause on hover
        if (heroSection) {
            heroSection.addEventListener('mouseenter', stopAuto);
            heroSection.addEventListener('mouseleave', startAuto);
        }

        // Keyboard navigation
        document.addEventListener('keydown', function (e) {
            if (!heroSection) return;
            var rect = heroSection.getBoundingClientRect();
            if (rect.bottom < 0 || rect.top > window.innerHeight) return;
            if (e.key === 'ArrowLeft')  { prev(); startAuto(); }
            if (e.key === 'ArrowRight') { next(); startAuto(); }
        });

        // Touch swipe support
        var touchStartX = 0;
        container.addEventListener('touchstart', function (e) {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });
        container.addEventListener('touchend', function (e) {
            var diff = e.changedTouches[0].screenX - touchStartX;
            if (Math.abs(diff) > 50) {
                if (diff < 0) next(); else prev();
                startAuto();
            }
        }, { passive: true });

        startAuto();
    })();

    // ── Hamburger / Mobile drawer ──────────────────────────────────────────
    const hamburger   = document.getElementById('hamburger');
    const drawer      = document.getElementById('mobile-drawer');
    const overlay     = document.getElementById('mobile-overlay');
    const drawerClose = document.getElementById('drawer-close');

    function openDrawer() {
        if (!drawer) return;
        drawer.classList.add('open');
        drawer.setAttribute('aria-hidden', 'false');
        overlay && overlay.classList.add('open');
        hamburger && hamburger.classList.add('open');
        hamburger && hamburger.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';

        // Move focus into drawer for accessibility
        const firstFocusable = drawer.querySelector('a, button');
        if (firstFocusable) firstFocusable.focus();
    }

    function closeDrawer() {
        if (!drawer) return;
        drawer.classList.remove('open');
        drawer.setAttribute('aria-hidden', 'true');
        overlay && overlay.classList.remove('open');
        hamburger && hamburger.classList.remove('open');
        hamburger && hamburger.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';

        // Return focus to hamburger
        hamburger && hamburger.focus();
    }

    hamburger   && hamburger.addEventListener('click', openDrawer);
    drawerClose && drawerClose.addEventListener('click', closeDrawer);
    overlay     && overlay.addEventListener('click', closeDrawer);

    // Close drawer on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && drawer && drawer.classList.contains('open')) {
            closeDrawer();
        }
    });

    // ── Mega menu hover (desktop) ──────────────────────────────────────────
    // Primary behaviour is CSS :hover; JS adds .is-open for focus/keyboard
    // and provides a small close-delay so moving the cursor to the panel
    // feels smooth even with minor gaps in hit area.
    const megaItems = document.querySelectorAll('.nav-item.has-mega');

    megaItems.forEach((item) => {
        const panel = item.querySelector('.mega-panel');
        const link  = item.querySelector('.nav-link');
        let closeTimer;

        function showPanel() {
            clearTimeout(closeTimer);
            // Close any other open panel first
            megaItems.forEach((other) => {
                if (other !== item) {
                    other.querySelector('.mega-panel')?.classList.remove('is-open');
                    other.querySelector('.nav-link')?.setAttribute('aria-expanded', 'false');
                }
            });
            panel && panel.classList.add('is-open');
            link  && link.setAttribute('aria-expanded', 'true');
        }

        function hidePanel() {
            closeTimer = setTimeout(() => {
                panel && panel.classList.remove('is-open');
                link  && link.setAttribute('aria-expanded', 'false');
            }, 120); // small delay prevents accidental close
        }

        item.addEventListener('mouseenter', showPanel);
        item.addEventListener('mouseleave', hidePanel);

        // Keep panel open while mouse is over it (redundant with CSS hover
        // but keeps .is-open in sync when JS is the trigger)
        panel && panel.addEventListener('mouseenter', () => clearTimeout(closeTimer));
        panel && panel.addEventListener('mouseleave', hidePanel);

        // Keyboard: open on Enter/Space, close on Escape
        link && link.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                const isOpen = panel && panel.classList.contains('is-open');
                isOpen ? hidePanel() : showPanel();
            }
            if (e.key === 'Escape') {
                hidePanel();
                link.focus();
            }
        });
    });

    // Close all mega menus when clicking outside the header
    document.addEventListener('click', (e) => {
        if (!e.target.closest('#site-header')) {
            megaItems.forEach((item) => {
                item.querySelector('.mega-panel')?.classList.remove('is-open');
                item.querySelector('.nav-link')?.setAttribute('aria-expanded', 'false');
            });
        }
    });

    // ── Mobile accordion ──────────────────────────────────────────────────
    const accordionTriggers = document.querySelectorAll('.mobile-accordion__trigger');

    accordionTriggers.forEach((trigger) => {
        trigger.addEventListener('click', () => {
            const parent = trigger.closest('.mobile-accordion');
            const isOpen = parent.classList.contains('open');

            // Collapse all open accordions
            document.querySelectorAll('.mobile-accordion.open').forEach((openItem) => {
                openItem.classList.remove('open');
                openItem.querySelector('.mobile-accordion__trigger')
                        .setAttribute('aria-expanded', 'false');
            });

            // If this one was closed, open it
            if (!isOpen) {
                parent.classList.add('open');
                trigger.setAttribute('aria-expanded', 'true');
            }
        });
    });

})();

/* ================================================================
   PACKAGE FILTER (archive-package.php)
   ================================================================ */

(function () {
    'use strict';

    var filterForm = document.getElementById('filter-form');
    if (!filterForm) return;

    var filterSelects = filterForm.querySelectorAll('.filter-select');
    var searchInput   = document.getElementById('filter-search');
    var sortSelect    = document.getElementById('filter-sort'); // outside form, in result bar

    // ── Highlight active (non-default) selects ─────────────────────────────
    function refreshActiveStates() {
        filterSelects.forEach(function (sel) {
            var hasValue = sel.value !== '' && sel.value !== sel.options[0].value;
            sel.classList.toggle('is-active', hasValue);
        });
    }

    refreshActiveStates();

    // ── Build URL from current form state ──────────────────────────────────
    function buildFilterURL() {
        var params = new URLSearchParams();

        // Search
        if (searchInput && searchInput.value.trim()) {
            params.set('sq', searchInput.value.trim());
        }

        // Standard selects in form
        filterSelects.forEach(function (sel) {
            if (sel.value && sel.value !== '') {
                params.set(sel.name, sel.value);
            }
        });

        // Hidden inputs from searchable dropdowns
        filterForm.querySelectorAll('.filter-searchable input[type="hidden"]').forEach(function (inp) {
            if (inp.value && inp.value !== '') {
                params.set(inp.name, inp.value);
            }
        });

        // Sort (outside form)
        if (sortSelect && sortSelect.value && sortSelect.value !== 'latest') {
            params.set('sort', sortSelect.value);
        }

        var base = filterForm.action || window.location.pathname;
        var qs   = params.toString();
        return qs ? base + '?' + qs : base;
    }

    function navigateToFilter() {
        refreshActiveStates();
        window.location.href = buildFilterURL();
    }

    // ── On select change: update URL + reload ─────────────────────────────
    filterSelects.forEach(function (sel) {
        sel.addEventListener('change', navigateToFilter);
    });

    // Sort select (outside form)
    if (sortSelect) {
        sortSelect.addEventListener('change', navigateToFilter);
    }

    // ── Debounced search ──────────────────────────────────────────────────
    if (searchInput) {
        var searchTimer = null;
        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                clearTimeout(searchTimer);
                navigateToFilter();
            }
        });
        searchInput.addEventListener('input', function () {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(navigateToFilter, 600);
        });
    }

    // ── Searchable dropdown widgets ──────────────────────────────────────
    var chevronSvg = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>';

    filterForm.querySelectorAll('.filter-searchable').forEach(function (wrap) {
        var hidden      = wrap.querySelector('input[type="hidden"]');
        var dataEl      = wrap.querySelector('.filter-searchable-data');
        var options     = JSON.parse(dataEl.textContent);
        var placeholder = wrap.getAttribute('data-placeholder') || 'Select...';
        var selected    = wrap.getAttribute('data-selected') || '';

        // Build trigger button
        var trigger = document.createElement('button');
        trigger.type = 'button';
        trigger.className = 'filter-searchable__trigger';
        if (selected) trigger.classList.add('is-active');
        trigger.innerHTML = '<span>' + (selected || placeholder) + '</span>' + chevronSvg;
        wrap.appendChild(trigger);

        // Build panel
        var panel = document.createElement('div');
        panel.className = 'filter-searchable__panel';
        var searchBox = document.createElement('input');
        searchBox.type = 'text';
        searchBox.className = 'filter-searchable__search';
        searchBox.placeholder = 'Type to search...';
        panel.appendChild(searchBox);

        var list = document.createElement('ul');
        list.className = 'filter-searchable__list';
        panel.appendChild(list);
        wrap.appendChild(panel);

        function renderList(query) {
            var q = (query || '').toLowerCase();
            list.innerHTML = '';
            var count = 0;
            Object.keys(options).forEach(function (val) {
                var label = options[val];
                if (q && label.toLowerCase().indexOf(q) === -1) return;
                var li = document.createElement('li');
                li.className = 'filter-searchable__option';
                if (val === selected) li.classList.add('is-selected');
                li.textContent = label;
                li.setAttribute('data-value', val);
                li.addEventListener('click', function () {
                    hidden.value = val;
                    selected = val;
                    trigger.querySelector('span').textContent = val ? label : placeholder;
                    trigger.classList.toggle('is-active', !!val);
                    panel.classList.remove('is-open');
                    navigateToFilter();
                });
                list.appendChild(li);
                count++;
            });
            if (count === 0) {
                var empty = document.createElement('div');
                empty.className = 'filter-searchable__empty';
                empty.textContent = 'No matches';
                list.appendChild(empty);
            }
        }

        trigger.addEventListener('click', function (e) {
            e.stopPropagation();
            // Close others
            document.querySelectorAll('.filter-searchable__panel.is-open').forEach(function (p) {
                if (p !== panel) p.classList.remove('is-open');
            });
            panel.classList.toggle('is-open');
            if (panel.classList.contains('is-open')) {
                searchBox.value = '';
                renderList('');
                searchBox.focus();
            }
        });

        searchBox.addEventListener('input', function () {
            renderList(searchBox.value);
        });

        searchBox.addEventListener('click', function (e) { e.stopPropagation(); });
        panel.addEventListener('click', function (e) { e.stopPropagation(); });

        renderList('');
    });

    // Close searchable panels on outside click
    document.addEventListener('click', function () {
        document.querySelectorAll('.filter-searchable__panel.is-open').forEach(function (p) {
            p.classList.remove('is-open');
        });
    });

    // ── Restore scroll position to filter bar after reload ─────────────────
    var hasActiveFilter = Array.from(filterSelects).some(function (sel) {
        return sel.value !== '' && sel.value !== sel.options[0].value;
    }) || (searchInput && searchInput.value.trim());

    if (hasActiveFilter) {
        var filterBar = document.getElementById('filter-bar');
        if (filterBar) {
            setTimeout(function () {
                filterBar.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }, 120);
        }
    }

})();

/* ================================================================
   PACKAGE TABS (single-package.php)
   ================================================================ */

(function () {
    'use strict';

    const tabs   = document.querySelectorAll('.pkg-tab');
    const panels = document.querySelectorAll('.tab-panel');

    if (!tabs.length) return;

    function activateTab(targetId) {
        // Deactivate all tabs
        tabs.forEach((t) => {
            t.classList.remove('active');
            t.setAttribute('aria-selected', 'false');
        });

        // Hide all panels
        panels.forEach((p) => {
            p.classList.remove('active');
            p.hidden = true;
        });

        // Activate clicked tab
        const clickedTab = document.querySelector(`[data-target="${targetId}"]`);
        const targetPanel = document.getElementById(targetId);

        if (clickedTab) {
            clickedTab.classList.add('active');
            clickedTab.setAttribute('aria-selected', 'true');
        }

        if (targetPanel) {
            targetPanel.classList.add('active');
            targetPanel.hidden = false;
            // Smooth opacity re-entry
            targetPanel.style.opacity = '0';
            requestAnimationFrame(() => {
                targetPanel.style.transition = 'opacity 0.2s ease';
                targetPanel.style.opacity = '1';
            });
        }
    }

    tabs.forEach((tab) => {
        tab.addEventListener('click', () => {
            activateTab(tab.dataset.target);
        });

        // Keyboard: left/right arrow navigation between tabs
        tab.addEventListener('keydown', (e) => {
            const tabArray = Array.from(tabs);
            const idx = tabArray.indexOf(tab);
            if (e.key === 'ArrowRight') {
                e.preventDefault();
                tabArray[(idx + 1) % tabArray.length].focus();
            }
            if (e.key === 'ArrowLeft') {
                e.preventDefault();
                tabArray[(idx - 1 + tabArray.length) % tabArray.length].focus();
            }
        });
    });

    // Activate first tab on load
    if (tabs[0]) activateTab(tabs[0].dataset.target);

})();


/* ================================================================
   ACCORDION (single-package.php terms section)
   ================================================================ */

(function () {
    'use strict';

    const accordionItems = document.querySelectorAll('.accordion-item');

    if (!accordionItems.length) return;

    accordionItems.forEach((item) => {
        const trigger = item.querySelector('.accordion-item__trigger');
        const panel   = item.querySelector('.accordion-item__panel');

        if (!trigger || !panel) return;

        trigger.addEventListener('click', () => {
            const isOpen = item.classList.contains('open');

            // Close all items
            accordionItems.forEach((other) => {
                const otherPanel = other.querySelector('.accordion-item__panel');
                const otherTrigger = other.querySelector('.accordion-item__trigger');
                other.classList.remove('open');
                if (otherTrigger) otherTrigger.setAttribute('aria-expanded', 'false');
                if (otherPanel)   otherPanel.style.maxHeight = null;
            });

            // Open clicked item if it was closed
            if (!isOpen) {
                item.classList.add('open');
                trigger.setAttribute('aria-expanded', 'true');
                panel.style.maxHeight = panel.scrollHeight + 'px';
            }
        });
    });

})();


/* ================================================================
   FAQ PAGE (page-faq.php)
   ================================================================ */

(function () {
    'use strict';

    // ── Category filter ────────────────────────────────────────────────────
    const catButtons = document.querySelectorAll('.faq-cat-btn');
    const catGroups  = document.querySelectorAll('.faq-category-group');

    if (catButtons.length) {
        catButtons.forEach((btn) => {
            btn.addEventListener('click', () => {
                catButtons.forEach((b) => {
                    b.classList.remove('active');
                    b.setAttribute('aria-pressed', 'false');
                });
                btn.classList.add('active');
                btn.setAttribute('aria-pressed', 'true');

                const cat = btn.dataset.category;
                catGroups.forEach((group) => {
                    const show = cat === 'all' || group.dataset.category === cat;
                    group.style.display = show ? 'block' : 'none';
                });

                // Clear search when switching categories
                const searchInput = document.getElementById('faq-search');
                if (searchInput) searchInput.value = '';
                document.querySelectorAll('.faq-item').forEach((i) => (i.style.display = ''));
                const noResults = document.querySelector('.faq-no-results');
                if (noResults) noResults.hidden = true;
            });
        });
    }

    // ── FAQ accordion ──────────────────────────────────────────────────────
    const faqItems = document.querySelectorAll('.faq-item');

    faqItems.forEach((item) => {
        const btn    = item.querySelector('.faq-question-btn');
        const answer = item.querySelector('.faq-answer');

        if (!btn || !answer) return;

        btn.addEventListener('click', () => {
            const isOpen = item.classList.contains('open');

            // Close all items
            faqItems.forEach((other) => {
                const otherBtn    = other.querySelector('.faq-question-btn');
                const otherAnswer = other.querySelector('.faq-answer');
                other.classList.remove('open');
                if (otherBtn)    otherBtn.setAttribute('aria-expanded', 'false');
                if (otherAnswer) otherAnswer.hidden = false; // keep in DOM for CSS max-height
            });

            // Open clicked item if it was closed
            if (!isOpen) {
                item.classList.add('open');
                btn.setAttribute('aria-expanded', 'true');
                answer.hidden = false;
            }
        });
    });

    // ── Live search ────────────────────────────────────────────────────────
    const faqSearch = document.getElementById('faq-search');
    const noResults = document.querySelector('.faq-no-results');

    if (faqSearch) {
        faqSearch.addEventListener('input', () => {
            const query = faqSearch.value.toLowerCase().trim();

            // Reset category filter to "All" when searching
            catButtons.forEach((b) => {
                b.classList.remove('active');
                b.setAttribute('aria-pressed', 'false');
            });
            const allBtn = document.querySelector('.faq-cat-btn[data-category="all"]');
            if (allBtn) {
                allBtn.classList.add('active');
                allBtn.setAttribute('aria-pressed', 'true');
            }

            if (!query) {
                faqItems.forEach((item) => (item.style.display = ''));
                catGroups.forEach((group) => (group.style.display = ''));
                if (noResults) noResults.hidden = true;
                return;
            }

            let visibleCount = 0;

            catGroups.forEach((group) => {
                let groupVisible = false;

                group.querySelectorAll('.faq-item').forEach((item) => {
                    const question = item.dataset.question || '';
                    const answerEl = item.querySelector('.faq-answer p');
                    const answerText = answerEl ? answerEl.textContent.toLowerCase() : '';
                    const matches = question.includes(query) || answerText.includes(query);

                    item.style.display = matches ? '' : 'none';
                    if (matches) {
                        groupVisible = true;
                        visibleCount++;
                    }
                });

                group.style.display = groupVisible ? 'block' : 'none';
            });

            if (noResults) noResults.hidden = visibleCount > 0;
        });
    }

})();


/* ================================================================
   MEDIA PAGE (page-media.php)
   ================================================================ */

(function () {
    'use strict';

    // ── Tab switcher ───────────────────────────────────────────────────────
    const mediaTabBtns  = document.querySelectorAll('.media-tab-btn');
    const mediaPanels   = document.querySelectorAll('.media-panel');

    if (mediaTabBtns.length) {
        mediaTabBtns.forEach((btn) => {
            btn.addEventListener('click', () => {
                mediaTabBtns.forEach((b) => {
                    b.classList.remove('active');
                    b.setAttribute('aria-selected', 'false');
                });
                mediaPanels.forEach((p) => {
                    p.classList.remove('active');
                    p.hidden = true;
                });

                btn.classList.add('active');
                btn.setAttribute('aria-selected', 'true');

                const target = document.getElementById('media-' + btn.dataset.tab);
                if (target) {
                    target.classList.add('active');
                    target.hidden = false;
                }
            });
        });
    }

    // ── Photo lightbox ─────────────────────────────────────────────────────
    const lightbox      = document.getElementById('lightbox');
    const lightboxImg   = document.getElementById('lightbox-img');
    const lightboxClose = document.getElementById('lightbox-close');

    function openLightbox(src, alt) {
        if (!lightbox || !lightboxImg) return;
        lightboxImg.src = src;
        lightboxImg.alt = alt || '';
        lightbox.hidden = false;
        lightbox.classList.add('open');
        document.body.style.overflow = 'hidden';
        lightboxClose && lightboxClose.focus();
    }

    function closeLightbox() {
        if (!lightbox) return;
        lightbox.classList.remove('open');
        // Wait for CSS transition before hiding
        lightbox.addEventListener('transitionend', () => {
            if (!lightbox.classList.contains('open')) lightbox.hidden = true;
        }, { once: true });
        document.body.style.overflow = '';
    }

    // Delegate click on photo overlays
    document.addEventListener('click', (e) => {
        const overlay = e.target.closest('.photo-overlay[data-full]');
        if (overlay) {
            const full = overlay.dataset.full;
            const alt  = overlay.closest('.photo-item')?.querySelector('img')?.alt || '';
            openLightbox(full, alt);
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
            const overlay = document.activeElement?.closest('.photo-overlay[data-full]');
            if (overlay) {
                e.preventDefault();
                const full = overlay.dataset.full;
                const alt  = overlay.closest('.photo-item')?.querySelector('img')?.alt || '';
                openLightbox(full, alt);
            }
        }
    });

    lightboxClose && lightboxClose.addEventListener('click', closeLightbox);

    lightbox && lightbox.addEventListener('click', (e) => {
        if (e.target === lightbox) closeLightbox();
    });

    // ── Video modal ────────────────────────────────────────────────────────
    const videoModal      = document.getElementById('video-modal');
    const videoFrame      = document.getElementById('video-frame');
    const videoModalClose = document.getElementById('video-modal-close');

    function buildEmbedURL(url) {
        try {
            const parsed = new URL(url);
            if (parsed.hostname.includes('youtube.com') && parsed.searchParams.get('v')) {
                return 'https://www.youtube.com/embed/' + parsed.searchParams.get('v') + '?autoplay=1';
            }
            if (parsed.hostname === 'youtu.be') {
                return 'https://www.youtube.com/embed/' + parsed.pathname.slice(1) + '?autoplay=1';
            }
            if (parsed.hostname.includes('vimeo.com')) {
                return 'https://player.vimeo.com/video/' + parsed.pathname.slice(1) + '?autoplay=1';
            }
        } catch (_) { /* invalid URL — return as-is */ }
        return url;
    }

    function openVideo(url) {
        if (!videoModal || !videoFrame || !url || url === '#') return;
        videoFrame.src = buildEmbedURL(url);
        videoModal.hidden = false;
        videoModal.classList.add('open');
        document.body.style.overflow = 'hidden';
        videoModalClose && videoModalClose.focus();
    }

    function closeVideo() {
        if (!videoModal) return;
        videoModal.classList.remove('open');
        videoModal.addEventListener('transitionend', () => {
            if (!videoModal.classList.contains('open')) {
                videoModal.hidden = true;
                if (videoFrame) videoFrame.src = '';
            }
        }, { once: true });
        document.body.style.overflow = '';
    }

    // Delegate click on video thumb-wraps
    document.addEventListener('click', (e) => {
        const wrap = e.target.closest('.video-thumb-wrap[data-video]');
        if (wrap) openVideo(wrap.dataset.video);
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
            const wrap = document.activeElement?.closest('.video-thumb-wrap[data-video]');
            if (wrap) { e.preventDefault(); openVideo(wrap.dataset.video); }
        }
    });

    videoModalClose && videoModalClose.addEventListener('click', closeVideo);

    videoModal && videoModal.addEventListener('click', (e) => {
        if (e.target === videoModal) closeVideo();
    });

    // ── Global Escape key ──────────────────────────────────────────────────
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            if (lightbox  && lightbox.classList.contains('open'))  closeLightbox();
            if (videoModal && videoModal.classList.contains('open')) closeVideo();
        }
    });

})();


/* ================================================================
   BLOG PAGES  (archive.php + single.php)
   ================================================================ */

(function () {
    'use strict';

    // ── Scroll-progress bar on single post ────────────────────────────────
    const postBody = document.querySelector('.post-body');

    if (postBody) {
        // Create and inject the progress bar
        const bar = document.createElement('div');
        bar.id = 'read-progress';
        bar.setAttribute('role', 'progressbar');
        bar.setAttribute('aria-valuemin', '0');
        bar.setAttribute('aria-valuemax', '100');
        bar.setAttribute('aria-valuenow', '0');
        bar.setAttribute('aria-label', 'Reading progress');
        document.body.appendChild(bar);

        const updateProgress = () => {
            const bodyRect  = postBody.getBoundingClientRect();
            const bodyTop   = bodyRect.top   + window.scrollY;
            const bodyBot   = bodyRect.bottom + window.scrollY;
            const scrolled  = window.scrollY - bodyTop;
            const total     = bodyBot - bodyTop - window.innerHeight;
            const pct       = total > 0 ? Math.min(100, Math.max(0, (scrolled / total) * 100)) : 0;

            bar.style.width = pct + '%';
            bar.setAttribute('aria-valuenow', Math.round(pct));
        };

        window.addEventListener('scroll', updateProgress, { passive: true });
        updateProgress();
    }

    // ── Sticky "Back to top" button ────────────────────────────────────────
    const backTop = document.createElement('button');
    backTop.id        = 'back-to-top';
    backTop.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="18 15 12 9 6 15"/></svg>';
    backTop.setAttribute('aria-label', 'Back to top');
    document.body.appendChild(backTop);

    window.addEventListener('scroll', () => {
        backTop.classList.toggle('visible', window.scrollY > 600);
    }, { passive: true });

    backTop.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // ── Featured Post Carousel ────────────────────────────────────────────
    function initFeaturedCarousel() {
        var carousel = document.querySelector('.featured-carousel--multi');
        if (!carousel) return;

        var slides = carousel.querySelectorAll('.featured-carousel__slide');
        var dots   = carousel.querySelectorAll('.featured-carousel__dot');
        var prevBtn = carousel.querySelector('.featured-carousel__arrow--prev');
        var nextBtn = carousel.querySelector('.featured-carousel__arrow--next');
        var count  = slides.length;
        var current = 0;
        var autoTimer = null;

        function goTo(idx) {
            if (idx < 0) idx = count - 1;
            if (idx >= count) idx = 0;

            slides[current].classList.remove('active');
            slides[current].setAttribute('aria-hidden', 'true');
            if (dots[current]) dots[current].classList.remove('active');

            current = idx;

            slides[current].classList.add('active');
            slides[current].removeAttribute('aria-hidden');
            if (dots[current]) dots[current].classList.add('active');
        }

        function startAuto() {
            stopAuto();
            autoTimer = setInterval(function() { goTo(current + 1); }, 6000);
        }

        function stopAuto() {
            if (autoTimer) { clearInterval(autoTimer); autoTimer = null; }
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', function() { goTo(current - 1); startAuto(); });
        }
        if (nextBtn) {
            nextBtn.addEventListener('click', function() { goTo(current + 1); startAuto(); });
        }

        dots.forEach(function(dot) {
            dot.addEventListener('click', function() {
                var idx = parseInt(this.getAttribute('data-slide'), 10);
                goTo(idx);
                startAuto();
            });
        });

        // Pause on hover
        carousel.addEventListener('mouseenter', stopAuto);
        carousel.addEventListener('mouseleave', startAuto);

        // Keyboard navigation
        carousel.setAttribute('tabindex', '0');
        carousel.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft')  { goTo(current - 1); startAuto(); }
            if (e.key === 'ArrowRight') { goTo(current + 1); startAuto(); }
        });

        startAuto();
    }

    initFeaturedCarousel();

})();

/* ================================================================
   TRAVZO FORM — AJAX submission
   ================================================================ */

(function () {
    'use strict';

    var forms = document.querySelectorAll('.travzo-form');
    if (!forms.length || typeof travzoAjax === 'undefined') return;

    forms.forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            var submitBtn  = form.querySelector('.form-submit-btn');
            var successEl  = form.querySelector('.form-success');
            var errorEl    = form.querySelector('.form-error');
            if (!submitBtn) return;

            var originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Sending…';
            if (successEl) successEl.style.display = 'none';
            if (errorEl)   errorEl.style.display   = 'none';

            var formData = new FormData(form);

            fetch(travzoAjax.url, {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (data.success) {
                    if (successEl) {
                        successEl.textContent = data.data.message || 'Submitted successfully!';
                        successEl.style.display = 'block';
                    }
                    form.reset();
                    // Re-set hidden fields after reset
                    var hiddens = form.querySelectorAll('input[type="hidden"]');
                    hiddens.forEach(function (h) {
                        if (h.dataset.resetValue) h.value = h.dataset.resetValue;
                    });
                } else {
                    if (errorEl) {
                        errorEl.textContent = (data.data && data.data.message) || 'Something went wrong. Please try again.';
                        errorEl.style.display = 'block';
                    }
                }
            })
            .catch(function () {
                if (errorEl) {
                    errorEl.textContent = 'Network error. Please check your connection and try again.';
                    errorEl.style.display = 'block';
                }
            })
            .finally(function () {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            });
        });
    });
})();


/* ─── Gallery Lightbox ───────────────────────────────────────────────── */
(function () {
    'use strict';

    var galleryLinks = document.querySelectorAll('[data-lightbox="gallery"]');
    if (!galleryLinks.length) return;

    // Collect image URLs
    var images = [];
    galleryLinks.forEach(function (link) {
        images.push(link.href);
    });

    // Build overlay
    var overlay = document.createElement('div');
    overlay.className = 'lightbox-overlay';
    overlay.innerHTML =
        '<button class="lightbox-close" aria-label="Close">&times;</button>' +
        '<button class="lightbox-prev" aria-label="Previous">&#8249;</button>' +
        '<img src="" alt="">' +
        '<button class="lightbox-next" aria-label="Next">&#8250;</button>';
    document.body.appendChild(overlay);

    var lbImg  = overlay.querySelector('img');
    var current = 0;

    function show(idx) {
        current = (idx + images.length) % images.length;
        lbImg.src = images[current];
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function hide() {
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    galleryLinks.forEach(function (link, i) {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            show(i);
        });
    });

    overlay.querySelector('.lightbox-close').addEventListener('click', hide);
    overlay.querySelector('.lightbox-prev').addEventListener('click', function () { show(current - 1); });
    overlay.querySelector('.lightbox-next').addEventListener('click', function () { show(current + 1); });

    overlay.addEventListener('click', function (e) {
        if (e.target === overlay) hide();
    });

    document.addEventListener('keydown', function (e) {
        if (!overlay.classList.contains('active')) return;
        if (e.key === 'Escape')     hide();
        if (e.key === 'ArrowLeft')  show(current - 1);
        if (e.key === 'ArrowRight') show(current + 1);
    });
})();
