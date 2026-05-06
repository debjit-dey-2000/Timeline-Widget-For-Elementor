/**
 * Timeline Widget for Elementor – Frontend JS
 * - Injects .twe-line-track sized from first → last icon centre
 * - Scroll-drives .twe-line-fill from 0 → trackHeight, never beyond
 * - Scroll-triggered item reveal animations
 */
(function ($) {
    'use strict';

    // Each registered timeline: { $track, $fill, $lineEl, lineTop, lineHeight }
    var timelines = [];
    var ticking   = false;

    /* ── Helpers ── */

    function clamp(val, min, max) {
        return Math.min(Math.max(val, min), max);
    }

    /**
     * Find the icon selector for a given track element.
     */
    function iconSelector($track) {
        if ($track.hasClass('twe-timeline'))           return '.twe-icon';
        if ($track.hasClass('twe-timeline-alternate')) return '.twe-alt-icon';
        if ($track.hasClass('twe-timeline-center'))    return '.twe-center-icon';
        return null;
    }

    /**
     * Measure the line: top offset (relative to $track) and total height,
     * anchored to the vertical centre of the first and last icon.
     */
    function measureLine($track) {
        var sel    = iconSelector($track);
        if (!sel) return null;

        var $icons = $track.find(sel);
        if ($icons.length < 1) return null;

        var trackTop = $track.offset().top;

        var $first      = $icons.first();
        var $last       = $icons.last();
        var firstCentre = $first.offset().top - trackTop + $first.outerHeight() / 2;
        var lastCentre  = $last.offset().top  - trackTop + $last.outerHeight()  / 2;

        return {
            top:    firstCentre,
            height: Math.max(0, lastCentre - firstCentre)
        };
    }

    /**
     * Recalculate all line measurements (call on init + resize).
     */
    function recalcAll() {
        timelines.forEach(function (t) {
            var m = measureLine(t.$track);
            if (!m) return;

            t.lineTop    = m.top;
            t.lineHeight = m.height;

            // Size the grey track element
            t.$lineEl.css({ top: m.top + 'px', height: m.height + 'px' });

            // Sync fill's top to match track
            t.$fill.css('top', m.top + 'px');
        });
    }

    /* ── Scroll update ── */

    function updateFills() {
        timelines.forEach(function (t) {
            if (!t.lineHeight) return;

            var trackRect  = t.$track[0].getBoundingClientRect();
            var vpH        = window.innerHeight || document.documentElement.clientHeight;

            // Pixel distance the viewport midpoint has travelled past the line start
            var lineStartY = trackRect.top + t.lineTop;
            var progress   = (vpH / 2) - lineStartY;
            var ratio      = clamp(progress / t.lineHeight, 0, 1);
            var fillPx     = Math.round(t.lineHeight * ratio);

            t.$fill.css('height', fillPx + 'px');
        });
        ticking = false;
    }

    function onScroll() {
        if (!ticking) {
            window.requestAnimationFrame(updateFills);
            ticking = true;
        }
    }

    /* ── Registration ── */

    /**
     * Inject track + fill elements for a timeline container and register it.
     * @param {jQuery} $track   – the positioned timeline container
     * @param {string} fillCls  – CSS class for the fill span
     * @param {jQuery|null} $existingLine – for center layout, the .twe-line element
     */
    function register($track, $existingLine) {
        // Avoid double-init
        if ($track.data('twe-init')) return;
        $track.data('twe-init', true);

        var $lineEl;

        if ($existingLine) {
            // Center layout: reuse the existing .twe-line element as track
            $lineEl = $existingLine;
        } else {
            // Left / alternate: inject a .twe-line-track element
            $lineEl = $('<span class="twe-line-track"></span>');
            $track.prepend($lineEl);
        }

        // Inject fill
        var $fill = $('<span class="twe-line-fill"></span>');
        $track.prepend($fill);

        timelines.push({
            $track:     $track,
            $lineEl:    $lineEl,
            $fill:      $fill,
            lineTop:    0,
            lineHeight: 0
        });
    }

    /* ── Item reveal animations ── */

    function initItemAnimations($wrapper) {
        if ($wrapper.data('animate') !== 'yes') return;

        var $items = $wrapper.find('.twe-animate');
        if (!$items.length) return;

        if ('IntersectionObserver' in window) {
            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        var $el   = $(entry.target);
                        var delay = parseInt($el.data('delay'), 10) || 0;
                        setTimeout(function () { $el.addClass('twe-visible'); }, delay);
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });

            $items.each(function () { observer.observe(this); });
        } else {
            $items.each(function () {
                var $el   = $(this);
                var delay = parseInt($el.data('delay'), 10) || 0;
                setTimeout(function () { $el.addClass('twe-visible'); }, delay);
            });
        }
    }

    /* ── Main init (called per widget scope) ── */

    function initTimeline($scope) {
        var $wrapper = $scope.find('.twe-timeline-wrapper');
        if (!$wrapper.length) return;

        initItemAnimations($wrapper);

        // Layout 1: left
        $wrapper.find('.twe-timeline').each(function () {
            register($(this), null);
        });

        // Layout 2: alternate
        $wrapper.find('.twe-timeline-alternate').each(function () {
            register($(this), null);
        });

        // Layout 3: center
        $wrapper.find('.twe-timeline-center').each(function () {
            register($(this), $(this).find('> .twe-line'));
        });

        // Measure after a short delay so the DOM has fully rendered
        setTimeout(function () {
            recalcAll();
            updateFills();
        }, 100);
    }

    /* ── Global listeners ── */

    $(window).on('scroll.twe', onScroll);

    // Debounced recalc for resize and editor changes
    var recalcTimer = null;
    function debouncedRecalc() {
        clearTimeout(recalcTimer);
        recalcTimer = setTimeout(function () {
            recalcAll();
            updateFills();
        }, 150);
    }

    $(window).on('resize.twe', debouncedRecalc);

    // Elementor frontend hook
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/twe_timeline.default',
            initTimeline
        );

        // Re-measure whenever any Elementor control changes in the editor
        // (handles icon size, spacing, padding changes at any breakpoint)
        if (typeof elementor !== 'undefined') {
            elementor.channels.editor.on('change', debouncedRecalc);
            // Also re-measure when switching between device breakpoints
            elementor.channels.deviceMode.on('change', debouncedRecalc);
        }
    });

}(jQuery));
