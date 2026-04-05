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

    const filterForm = document.getElementById('filter-form');
    if (!filterForm) return;

    const filterSelects = filterForm.querySelectorAll('.filter-select');

    // ── Highlight active (non-default) selects ─────────────────────────────
    function refreshActiveStates() {
        filterSelects.forEach((sel) => {
            // A select is "active" when its value is not the first/empty option
            const hasValue = sel.value !== '' && sel.value !== sel.options[0].value;
            sel.classList.toggle('is-active', hasValue);
        });
    }

    // Run on load so page-reload with params shows correct active states
    refreshActiveStates();

    // ── Build URL from current form state ──────────────────────────────────
    function buildFilterURL() {
        const params = new URLSearchParams();

        filterSelects.forEach((sel) => {
            if (sel.value && sel.value !== '') {
                // Use the select's name attribute as the param key
                params.set(sel.name, sel.value);
            }
        });

        const base = filterForm.action || window.location.pathname;
        const qs   = params.toString();
        return qs ? base + '?' + qs : base;
    }

    // ── On change: update URL + reload ─────────────────────────────────────
    filterSelects.forEach((sel) => {
        sel.addEventListener('change', () => {
            refreshActiveStates();

            const newURL = buildFilterURL();

            // Push to history so Back button works correctly
            if (typeof history.pushState === 'function') {
                history.pushState({ filterChange: true }, '', newURL);
                // Trigger page reload at the new URL
                window.location.href = newURL;
            } else {
                window.location.href = newURL;
            }
        });
    });

    // ── Restore scroll position to filter bar after reload ─────────────────
    // If any filter is active, scroll the filter bar into view smoothly
    const hasActiveFilter = Array.from(filterSelects).some(
        (sel) => sel.value !== '' && sel.value !== sel.options[0].value
    );

    if (hasActiveFilter) {
        const filterBar = document.getElementById('filter-bar');
        if (filterBar) {
            // Small delay ensures sticky positioning has settled
            setTimeout(() => {
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

})();
