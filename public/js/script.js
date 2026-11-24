(function($) {
    'use strict';

    // Sidebar toggle & backdrop
    function closeSidebar() {
        $('.sidebar').removeClass('show');
        $('.sidebar-backdrop').removeClass('show');
        $('.side-bar-toggle').removeClass('click');
    }

    $('.side-bar-toggle').on('click', function(e) {
        e.preventDefault();
        var opening = !$('.sidebar').hasClass('show');
        $('.sidebar').toggleClass('show', opening);
        $('.sidebar-backdrop').toggleClass('show', opening);
        $(this).toggleClass('click', opening);
    });

    $('.sidebar-backdrop').on('click', closeSidebar);

    $(document).on('keydown', function(e) {
        if (e.key === 'Escape') {
            closeSidebar();
        }
    });

    $('.side-bar-category-toggle').on('click', function() {
        $(this).toggleClass('fa-angle-down fa-angle-up');
    });

    // Navbar mega-menu dropdowns (scoped per category ID)
    var menuCloseTimer = null;

    function hideAllMegaMenus() {
        $('.header-bottom .mega-menu').stop(true, true).fadeOut(150);
    }

    $('.header-bottom .dropdown-toggle[data-mega-target]').on('mouseenter', function() {
        clearTimeout(menuCloseTimer);
        var targetId = $(this).data('mega-target');
        var $menu = $('#' + targetId);
        $('.header-bottom .mega-menu').not($menu).hide();
        $menu.stop(true, true).fadeIn(180);
    }).on('mouseleave', function() {
        menuCloseTimer = setTimeout(hideAllMegaMenus, 220);
    });

    $('.header-bottom .mega-menu').on('mouseenter', function() {
        clearTimeout(menuCloseTimer);
    }).on('mouseleave', function() {
        menuCloseTimer = setTimeout(hideAllMegaMenus, 220);
    });

    // Search form guard
    $('#search-form').on('submit', function(e) {
        var $input = $('#search-field');
        if ($input.length && $.trim($input.val()).length === 0) {
            e.preventDefault();
            $input.focus();
        }
    });

    // Back-to-top button & article reading progress bar
    var $backToTop = $('#back-to-top');
    var $progress = $('#reading-progress');
    var scrollTicking = false;

    function onScroll() {
        scrollTicking = false;
        var scrollY = window.scrollY || window.pageYOffset || 0;

        if ($backToTop.length) {
            $backToTop.toggleClass('visible', scrollY > 400);
        }

        if ($progress.length) {
            var docHeight = document.documentElement.scrollHeight - window.innerHeight;
            var pct = docHeight > 0 ? Math.min(100, Math.max(0, (scrollY / docHeight) * 100)) : 0;
            $progress.css('width', pct + '%');
        }
    }

    window.addEventListener('scroll', function() {
        if (!scrollTicking) {
            window.requestAnimationFrame(onScroll);
            scrollTicking = true;
        }
    }, { passive: true });

    $backToTop.on('click', function() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
})(jQuery);
