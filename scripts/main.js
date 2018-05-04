jQuery(function () {
    var isIE = detectIE();
    if (isIE) {
        jQuery('body').addClass('ie-browser');
    }

    var isTouchDevice = /Windows Phone/.test(navigator.userAgent) || ('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch,
        videoPoster = jQuery('.billboard .video-poster');
    if (isTouchDevice === true && jQuery(window).width() < 1200) {
        jQuery('body').addClass('touch-device');
        jQuery('img').removeAttr('data-parallax style');
        if (videoPoster.length !== 0) {
            videoPoster.remove();
        }
    } else if (videoPoster.length !== 0) {
        jQuery('.video-poster').fadeIn();
    }

    svg4everybody();
    pageLoaderInit();
    initSearchFormSwitcher();
    stickyHeader();
    togglePlay();
    mobileMenuInit();
    subMenuNavigation();
    btnPosition.init();

    var customSelect = jQuery('.selectpicker');
    if (customSelect.length !== 0) {
        customSelect.selectpicker();
    }

    var validationForm = jQuery('.validate-form');
    if (validationForm.length !== 0) {
        formValidation();
    }

    var phoneField = jQuery('input[type="tel"]');
    if (phoneField.length !== 0) {
        phoneField.each(function () {
            var thisTel = jQuery(this);
            thisTel.mask('+0 (000) 000-00-00');
        });
    }

    if (jQuery('.billboard-slider').length !== 0) {
        billboardSlider();
    }

    if (jQuery('.service-slider').length !== 0) {
        serviceSlider();
    }

    var venoboxLink = jQuery('.venobox-btn');
    if (venoboxLink.length !== 0) {
        venoboxLink.venobox({
            framewidth: '100vw',
            frameheight: '100vh'
        });
    }

    if (jQuery('.simple-slider').length !== 0) {
        customSliderDots();
    }

    if (jQuery('.product-filter-form').length !== 0) {
        sidebarFilterAccordion(jQuery('.product-filter-form .filter-item'), '.item-title', '.item-info');
    }

    if (jQuery('.tab-holder').length !== 0) {
        customTabInit();
    }

    if (jQuery('.product-grid-section').length !== 0) {
        sidebarViewSwitcher();
    }

    if (jQuery('.range-slider').length !== 0) {
        customRangeSlider();
    }
});

function detectIE() {
    var ua = window.navigator.userAgent;

    var msie = ua.indexOf('MSIE ');
    if (msie > 0) {
        return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
    }

    var trident = ua.indexOf('Trident/');
    if (trident > 0) {
        var rv = ua.indexOf('rv:');
        return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
    }

    var edge = ua.indexOf('Edge/');
    if (edge > 0) {
        return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
    }
    return false;
}

function pageLoaderInit() {
    jQuery(window).on('load', function () {
        var loaderHolder = jQuery('.preloader'),
            loader = loaderHolder.find('.inner-box');
        loader.fadeOut();
        loaderHolder.delay(500).fadeOut('slow');

        jQuery('body').removeClass('not-scroll');
    });
}

function stickyHeader() {
    var mainHeader = jQuery('.site-header'),
        mainContent = jQuery('body:not(.home) .main'),
        headerHeight = mainHeader.height();

    var scrolling = false,
        previousTop = 0,
        currentTop = 0,
        scrollDelta = 10;

    jQuery(window).on('scroll', function () {
        if (!scrolling) {
            scrolling = true;
            (!window.requestAnimationFrame) ? setTimeout(autoHideHeader, 250) : requestAnimationFrame(autoHideHeader);
        }
    });

    jQuery(window).on('resize', function () {
        headerHeight = mainHeader.height();
    });

    function autoHideHeader() {
        var currentTop = jQuery(window).scrollTop();
        checkSimpleNavigation(currentTop);
        previousTop = currentTop;
        scrolling = false;
    }

    function checkSimpleNavigation(currentTop) {
        if (previousTop - currentTop > scrollDelta) {
            mainHeader.removeClass('out-position');
        } else if (currentTop - previousTop > scrollDelta && currentTop > headerHeight) {
            mainHeader.addClass('out-position');
        }
    }

    function checkHeaderHeight() {
        mainContent.css({
            "margin-top": headerHeight
        });
    }

    jQuery(window).on('load resize orientationchange', checkHeaderHeight);
}

function initSearchFormSwitcher() {
    var doc = jQuery(document);

    jQuery('.search-form-holder').each(function () {
        var searchFormHolder = jQuery(this),
            formBox = jQuery(this).find('.search-form'),
            opener = jQuery(this).find('.search-btn');

        function show() {
            formBox.addClass('active');

            opener.off('click', show);
            doc.on('click', outsideClickHandler);
            doc.on('click', keypressHandler);
        }

        function hide() {
            formBox.removeClass('active');

            doc.off('click', outsideClickHandler);
            doc.off('click', keypressHandler);
            opener.on('click', show);
        }

        function outsideClickHandler(e) {
            if (!jQuery(e.target).closest(searchFormHolder).length) {
                hide();
            }
        }

        function keypressHandler(e) {
            doc.keyup(function (e) {
                if (e.keyCode === 27) {
                    hide();
                }
            });
        }

        opener.on('click', show);
    });
}

function mobileMenuInit() {
    var $body = jQuery('body'),
        menuHolder = jQuery('.site-nav'),
        closeBtn = menuHolder.find('.close-btn'),
        openBtn = jQuery('.menu-btn');

    function show() {
        menuHolder.fadeIn().addClass('active');
        $body.addClass('not-scroll');

        openBtn.off('click', show);
        closeBtn.on('click', hide);
    }

    function hide() {
        menuHolder.removeClass('active').css({display: ''});
        $body.removeClass('not-scroll');

        openBtn.on('click', show);
        closeBtn.off('click', hide);
    }

    jQuery(window).on("resize", function () {
        if (jQuery(window).width() > 991 && $body.hasClass('not-scroll')) {
            hide();
        }
    });

    openBtn.on('click', show);
}

function subMenuNavigation() {
    var doc = jQuery(document),
        isTouchDevice = /Windows Phone/.test(navigator.userAgent) || ('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch;

    if (isTouchDevice === true) {
        jQuery('.site-nav .menu .parent-item').each(function () {
            var navItem = jQuery(this).addClass('touch-device'),
                navItemLink = navItem.children('a'),
                dataClick = navItem.attr('data-click', 0),
                subMenu = navItem.children('.sub-menu');

            navItemLink.on('touchstart', function (e) {
                if (navItem.attr('data-click') == 0) {
                    e.preventDefault();

                    navItem.attr('data-click', 1).addClass('open');
                    subMenu.slideDown();
                } else if (navItem.attr('data-click') == 1) {
                    navItem.attr('data-click', 0).removeClass('open');
                    subMenu.slideUp();
                }
            });

            function outsideClickHandler(e) {
                if (!jQuery(e.target).closest(navItem).length) {
                    navItem.removeClass('open').attr('data-click', 0);
                    subMenu.slideUp();
                }
            }

            doc.on('click touchstart', outsideClickHandler);
        });
    }
}

function formValidation() {
    jQuery('.validate-form').each(function () {
        var currentForm = jQuery(this);

        currentForm.validate({
            rules: {
                phone: "required",
                name: "required",
                email: {
                    required: true,
                    email: true
                },
                checkbox: "required"
            },
            messages: {
                phone: "purpose of error",
                email: "purpose of error",
                name: "purpose of error",
                checkbox: "purpose of error"
            }
        });
        jQuery(document).on('af_complete', function (event, response) {
            var form = response.form;
            if (response.success) {
                //AjaxForm.Message.success(response.message);
                form.reset();
                jQuery('.success-message-modal').modal('show');
            }
        });
    });
}

jQuery('a[href*="#"]:not([href="#"])').click(function clickOnAnchorLink() {
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
        var target = jQuery(this.hash);
        target = target.length ? target : jQuery('[name=' + this.hash.slice(1) + ']');
        if (target.length) {
            jQuery('html,body').animate({
                scrollTop: target.offset().top
            }, 1000);
            return false;
        }
    }
});

function togglePlay() {
    var myAudio = jQuery('.audio-record');
    var audioSrc = myAudio.find('source').attr('src');
    var isPlaying = true;
    jQuery('.site-header .sound-switcher').on('click', function (e) {
        e.preventDefault();
        if (audioSrc !== '') {
            jQuery(this).toggleClass('muted');
            if (isPlaying) {
                myAudio.get(0).pause();
                isPlaying = false;
            } else {
                myAudio.get(0).play();
                isPlaying = true;
            }
        }
    });
}

function billboardSlider() {
    var slider = jQuery('.billboard-slider');

    slider.slick({
        arrows: false,
        fade: true,
        autoplay: true,
        autoplaySpeed: 2500
    });
}

function serviceSlider() {
    var slider = jQuery('.service-slider');

    slider.slick({
        slidesToShow: 4,
        arrows: true,
        dots: true,/*
        autoplay: true,
        autoplaySpeed: 6000,*/
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3
                }
            }, {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2
                }
            }, {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });

    var slides = slider.find('.slick-slide');
    slides.on('mouseover', function () {
        var currentSlide = jQuery(this);

        currentSlide.addClass('hover-slide');
        currentSlide.prev('.slick-slide').addClass('prev-slide');
        currentSlide.next('.slick-slide').addClass('next-slide');
    });

    slides.on('mouseout', function () {
        var currentSlide = jQuery(this);

        currentSlide.removeClass('hover-slide');
        currentSlide.prev('.slick-slide').removeClass('prev-slide');
        currentSlide.next('.slick-slide').removeClass('next-slide');
    });
}

function customSliderDots() {
    var simpleSlider = jQuery('.simple-slider.slick-initialized');

    var sliderDotsNav = simpleSlider.find('.slick-dots');
    var activeDots = sliderDotsNav.find('.slick-active');

    sliderDotsNav.append('<li class="circle"></li>');

    var decorCircle = jQuery('.circle'),
        defaultPosition;

    function setDecorLinePosition(activeDots) {
        defaultPosition = activeDots.position().left + activeDots.width() / 2;
        decorCircle.css('left', defaultPosition);
    }

    setDecorLinePosition(activeDots);
    simpleSlider.on('afterChange', function (slick, currentSlide) {
        var activeDots = sliderDotsNav.find('.slick-active');
        setDecorLinePosition(activeDots);
    });
}

var btnPosition = {
    init: function () {
        this.btn = jQuery('.site-footer .go-top');
        this.footer = jQuery('.site-footer');

        this.attachEvent();
    },
    updateState: function () {
        this.footerPosition = this.footer.offset().top;
        this.winHeight = this.browserHeight();
        this.scrollTop = jQuery(document).scrollTop();
    },
    attachEvent: function () {
        var self = this;

        this.btn.on('click', function () {
            jQuery('body, html').animate({scrollTop: 0}, 1200);
            return false;
        });

        this.scrollHandler = function () {
            self.updateState();

            if (self.scrollTop + self.winHeight / 2 >= self.winHeight) {
                self.btn.addClass('fixed').fadeIn();
            } else {
                self.btn.removeClass('fixed').fadeOut();
            }

            if (self.scrollTop + self.winHeight >= self.footerPosition) {
                self.btn.addClass('bottom-position');
            } else {
                self.btn.removeClass('bottom-position');
            }
        };

        jQuery(window).on('load resize orientationchange scroll', this.scrollHandler);
    },
    browserHeight: function () {
        return window.innerHeight || document.documentElement.clientHeight;
    }
};

function sidebarFilterAccordion(listItem, btn, hiddenEl) {
    var item = listItem,
        openerEl = item.find(btn),
        showHideEl = item.find(hiddenEl);

    openerEl.on('click', function (e) {
        e.preventDefault();
        var thisItem = jQuery(this).closest(item),
            thisShowHideEl = thisItem.find(showHideEl);

        thisItem.toggleClass('hidden');
        thisShowHideEl.slideToggle();
    });
}

function customTabInit() {
    var contentItem = jQuery('.tab-content .tab-item');

    function toggleActiveTab(navListItem, locationHash) {
        contentItem.filter('.tab-item-' + locationHash)
            .add(navListItem)
            .addClass('active')
            .siblings()
            .removeClass('active');

        history.pushState('', document.title, window.location.pathname);
        jQuery('.slick-slider').slick('setPosition');
    }

    jQuery('.tab-navigation-list li a').on('click', function (e) {
        e.preventDefault();

        var navItem = jQuery(this).parent('li'),
            itemPosition = navItem.data('class');
        toggleActiveTab(navItem, itemPosition);
    });

    jQuery(window).on('load', function () {
        if (window.location.hash) {
            var itemPosition = location.hash.substring(1),
                navItem = jQuery('.tab-navigation-list li[data-class="' + itemPosition + '"]');
            toggleActiveTab(navItem, itemPosition);
        }
    });
}

function sidebarViewSwitcher() {
    var doc = jQuery(document);
    jQuery('.product-grid-section .sidebar-switcher').on('click', function (e) {
        e.preventDefault();

        jQuery('.product-grid-section').toggleClass('hidden');
    });
}

function customRangeSlider() {
    jQuery('.range-slider').each(function () {
        var slider = jQuery(this).find('.slider'),
            maxValue = jQuery(this).find('.range-value.max'),
            minValue = jQuery(this).find('.range-value.min');

        minValue.mask('0000000000');
        maxValue.mask('0000000000');

        slider.slider({
            tooltip: 'hide'
        }).on('slide', function (slideEvt) {
            minValue.val(slideEvt.value[0]);
            maxValue.val(slideEvt.value[1]);
        }).data('slider');

        var valArray = slider.val().split(',');
        minValue.val(valArray[0]);
        maxValue.val(valArray[1]);

        minValue.on('blur', function () {
            var input = jQuery(this);
            var newValue = parseInt(input.val());
            var dataMin = parseInt(slider.attr('data-slider-min'));
            var dataMax = parseInt(slider.attr('data-slider-max'));

            var valArray = slider.val().split(',');
            var oldMaxValue = parseInt(valArray[1]);

            if (newValue < dataMin) {
                newValue = dataMin;
            } else if (newValue > dataMax) {
                newValue = dataMax;
            }

            if (newValue > oldMaxValue) {
                newValue = oldMaxValue;
            }

            slider.slider('setValue', [newValue, oldMaxValue], true);
        });

        maxValue.on('blur', function () {
            var input = jQuery(this);
            var newValue = parseInt(input.val());
            var dataMin = parseInt(slider.attr('data-slider-min'));
            var dataMax = parseInt(slider.attr('data-slider-max'));

            var valArray = slider.val().split(',');
            var oldMinValue = parseInt(valArray[0]);

            if (newValue > dataMax) {
                newValue = dataMax;
            } else if (newValue < dataMin) {
                newValue = dataMin;
            }

            if (newValue < oldMinValue) {
                newValue = oldMinValue;
            }

            slider.slider('setValue', [oldMinValue, newValue], true);
        });
    });
}

