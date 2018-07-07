(function($) {
  if(detectIE()) {
    $('body').addClass('ie-browser');
  }

  var
    isTouchDevice = /Windows Phone/.test(navigator.userAgent) ||
      ('ontouchstart' in window) ||
      window.DocumentTouch &&
      document instanceof DocumentTouch,

    videoPoster   = $('.billboard .video-poster'),
    audioTrack    = $('.audio-record');

  if(isTouchDevice === true && $(window).width() < 767 && audioTrack.length > 0) {
    audioTrack.remove();
  }

  if(isTouchDevice === true && $(window).width() < 1200) {
    $('body').addClass('touch-device');
    $('img').removeAttr('data-parallax style');

    if(videoPoster.length !== 0) {
      videoPoster.remove();
    }
  } else {
    if(videoPoster.length !== 0) {
      $('.video-poster').fadeIn();
    }
  }

  function detectIE() {
    var
      ua = window.navigator.userAgent;

    var
      msie = ua.indexOf('MSIE ');

    if(msie > 0) {
      return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
    }

    var
      trident = ua.indexOf('Trident/');

    if(trident > 0) {
      var rv = ua.indexOf('rv:');
      return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
    }

    var
      edge = ua.indexOf('Edge/');

    if(edge > 0) {
      return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
    }

    return false;
  }

  function pageLoaderInit() {
    $(window).on('load', function() {
      var
        loaderHolder = $('.preloader'),
        loader       = loaderHolder.find('.inner-box');

      loader.fadeOut();
      loaderHolder.delay(500).fadeOut('slow');
      $('body').removeClass('not-scroll');
    });
  }

  function stickyHeader() {
    var
      mainHeader   = $('.site-header'),
      mainContent  = $('.main'),
      headerHeight = mainHeader.height();

    if(document.location.pathname === '/')
      mainContent = $('<div />');

    var
      scrolling   = false,
      previousTop = 0,
      currentTop  = 0,
      scrollDelta = 10;

    $(window).on('scroll', function() {
      if(!scrolling) {
        scrolling = true;
        (!window.requestAnimationFrame) ? setTimeout(autoHideHeader, 250) : requestAnimationFrame(autoHideHeader);
      }
    });

    $(window).on('resize', function() {
      headerHeight = mainHeader.height();
    });

    function autoHideHeader() {
      var
        currentTop = $(window).scrollTop();

      checkSimpleNavigation(currentTop);
      previousTop = currentTop;
      scrolling   = false;
    }

    function checkSimpleNavigation(currentTop) {
      if(previousTop - currentTop > scrollDelta) {
        mainHeader.removeClass('out-position');
      } else {
        if(currentTop - previousTop > scrollDelta && currentTop > headerHeight) {
          mainHeader.addClass('out-position');
        }
      }
    }

    function checkHeaderHeight() {
      mainContent.css({
        "margin-top": headerHeight
      });
    }

    $(window).on('load resize orientationchange', checkHeaderHeight);
  }

  function initSearchFormSwitcher() {
    var
      doc = $(document);

    $('.search-form-holder').each(function() {
      var
        searchFormHolder = $(this),
        formBox          = $(this).find('.search-form'),
        opener           = $(this).find('.search-btn');

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
        if(!$(e.target).closest(searchFormHolder).length) {
          hide();
        }
      }

      function keypressHandler(e) {
        doc.keyup(function(e) {
          if(e.keyCode === 27) {
            hide();
          }
        });
      }

      opener.on('click', show);
    });
  }

  function mobileMenuInit() {
    var
      $body      = $('body'),
      menuHolder = $('.site-nav'),
      closeBtn   = menuHolder.find('.close-btn'),
      openBtn    = $('.menu-btn');

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

    $(window).on("resize", function() {
      if($(window).width() > 991 && $body.hasClass('not-scroll')) {
        hide();
      }
    });

    openBtn.on('click', show);
  }

  function subMenuNavigation() {
    var doc           = $(document),
        isTouchDevice = /Windows Phone/.test(navigator.userAgent) ||
          ('ontouchstart' in window) ||
          window.DocumentTouch &&
          document instanceof DocumentTouch;

    if(isTouchDevice === true) {
      $('.site-nav .menu .parent-item').each(function() {
        var navItem     = $(this).addClass('touch-device'),
            navItemLink = navItem.children('a'),
            dataClick   = navItem.attr('data-click', 0),
            subMenu     = navItem.children('.sub-menu');

        navItemLink.on('click touchstart', function(ev) {
          if(navItem.attr('data-click') === '0') {
            ev.preventDefault();

            navItem.attr('data-click', 1).addClass('open');
            subMenu.slideDown();
          } else {
            if(navItem.attr('data-click')) {
              navItem.attr('data-click', 0).removeClass('open');
              subMenu.slideUp();
            }
          }
        });

        function outsideClickHandler(e) {
          if(!$(e.target).closest(navItem).length) {
            navItem.removeClass('open').attr('data-click', 0);
            subMenu.slideUp();
          }
        }

        doc.on('click', outsideClickHandler);
      });
    }
  }

  var fixedSubHeader = {
    init       : function() {
      this.siteHeaderTopArea    = $('.site-header .action-line');
      this.headerNavigationArea = $('.site-header .navigation-area');
      this.fixedSubheader       = $('.fixed-subheader');
      this.scrollContant        = $('.scroll-content');
      this.attachEvent();
    },
    updateState: function() {
      this.topAreaHeight        = this.siteHeaderTopArea.outerHeight(true);
      this.navigationAreaHeight = this.headerNavigationArea.outerHeight(true);
      this.fixedSubheaderHeight = this.fixedSubheader.outerHeight(false);
    },
    attachEvent: function() {
      var self = this;

      this.resizeHandler = function() {
        self.updateState();

        self.fixedSubheader.css({
          "margin-top": self.navigationAreaHeight
        });

        self.scrollContant.css({
          "margin-top": self.fixedSubheaderHeight - self.topAreaHeight
        });
      };
      $(window).on('load resize orientationchange resize', this.resizeHandler);
    }
  };

  if($('.fixed-subheader').length !== 0) {
    fixedSubHeader.init();
  }

  function formValidation() {
    $('.validate-form').each(function() {
      $(this).validate({
        rules: {
          phone           : "required",
          name            : "required",
          full_name       : "required",
          first_name      : "required",
          second_name     : "required",
          price_from      : "required",
          price_to        : "required",
          phone_number    : "required",
          surname         : "required",
          fullName        : "required",
          location        : "required",
          rooms           : "required",
          priceFrom       : "required",
          priceTo         : "required",
          enquirySelect   : "required",
          terms_conditions: "required",

          email: {
            required: true,
            email   : true
          },

          checkbox: "required"
        },

        messages: {
          phone           : "purpose of error",
          email           : "purpose of error",
          name            : "purpose of error",
          full_name       : "purpose of error",
          first_name      : "purpose of error",
          second_name     : "purpose of error",
          price_from      : "purpose of error",
          price_to        : "purpose of error",
          phone_number    : "purpose of error",
          surname         : "purpose of error",
          fullName        : "purpose of error",
          checkbox        : "purpose of error",
          location        : "purpose of error",
          rooms           : "purpose of error",
          priceFrom       : "purpose of error",
          priceTo         : "purpose of error",
          enquirySelect   : "purpose of error",
          terms_conditions: "purpose of error",
        },

        submitHandler: function(form) {
          $.ajax({
            type    : "post",
            url     : "/_tools/submit_required",
            data    : $(form).serializeArray(),
            cache   : false,
            dataType: "JSON",

            success: function(data) {
              if(data.result === 'ok') {
                $(form).find('.success-message').addClass('success').show();
                $(form).reset();
              }
            }
          });

          return false;
        }
      });

      $(document).on('af_complete', function(event, response) {
        if(response.success) {

          //AjaxForm.Message.success(response.message);
          response.form.reset();
          $('.success-message-modal').modal('show');
        }
      });
    });
  }

  $('a[href*="#"]:not([href="#"])').click(function clickOnAnchorLink() {
    if(location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      var
        target       = $(this.hash),
        headerHeight = $('.site-header .navigation-area').outerHeight(true);

      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');

      if(target.length) {
        $('html,body').animate({
          scrollTop: target.offset().top - headerHeight
        }, 1000);
        return false;
      }
    }
  });

  function audioPlaySwitcher() {
    var
      myAudio       = $('.audio-record'),
      audioSrc      = myAudio.find('source').attr('src'),
      isPlaying     = true,
      soundSwitcher = $('.site-header .sound-switcher');

    function getCookie(name) {
      var
        matches = document
          .cookie
          .match(new RegExp("(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"));

      return matches ? decodeURIComponent(matches[1]) : false;
    }

    function setCookie(name, value, options) {
      options = options || {};

      var
        expires = options.expires;

      if(typeof expires == "number" && expires) {
        var d = new Date();
        d.setTime(d.getTime() + expires * 1000);
        expires = options.expires = d;
      }
      if(expires && expires.toUTCString) {
        options.expires = expires.toUTCString();
      }

      value = encodeURIComponent(value);

      var updatedCookie = name + "=" + value;

      for(var propName in options) {
        updatedCookie += "; " + propName;
        var propValue = options[propName];
        if(propValue !== true) {
          updatedCookie += "=" + propValue;
        }
      }

      document.cookie = updatedCookie;
      $('body').trigger('set_cookie');
    }

    function togglePlay() {
      var playState = getCookie('play-state');

      if(playState && playState === 'pause') {
        myAudio.get(0).pause();
        isPlaying = false;
        soundSwitcher.addClass('muted');
        console.log('pause');
      }

      soundSwitcher.on('click', function(e) {
        e.preventDefault();
        if(audioSrc !== '') {
          $(this).toggleClass('muted');
          if(isPlaying) {
            myAudio.get(0).pause();
            setCookie('play-state', 'pause', {expires: 60 * 60 * 24 * 7, path: '/'});
            isPlaying = false;
          } else {
            myAudio.get(0).play();
            setCookie('play-state', 'play', {expires: 60 * 60 * 24 * 7, path: '/'});
            isPlaying = true;
          }
        }
      });
    }

    togglePlay();
  }

  function billboardSlider() {

    $('.billboard-slider').slick({
      arrows       : false,
      fade         : true,
      autoplay     : true,
      autoplaySpeed: 3500
    });
  }

  function serviceSlider() {
    var
      slider = $('.service-slider');

    slider.slick({
      slidesToShow : 4,
      dots         : true,
      infinite     : false,
      autoplay     : true,
      autoplaySpeed: 6000,
      responsive   : [
        {
          breakpoint: 1200,
          settings  : {
            slidesToShow: 3
          }
        }, {
          breakpoint: 767,
          settings  : {
            slidesToShow: 2
          }
        }, {
          breakpoint: 480,
          settings  : {
            slidesToShow: 1
          }
        }
      ]
    });

    var
      slides = slider.find('.slick-slide');
    slides.on('mouseover', function() {
      $(this).addClass('hover-slide');
      $(this).prev('.slick-slide').addClass('prev-slide');
      $(this).next('.slick-slide').addClass('next-slide');
    });

    slides.on('mouseout', function() {
      $(this).removeClass('hover-slide');
      $(this).prev('.slick-slide').removeClass('prev-slide');
      $(this).next('.slick-slide').removeClass('next-slide');
    });
  }

  function productGallerySlider() {
    var
      mainSlider    = $('.product-gallery .image-slider'),
      previewSlider = $('.product-gallery .preview-slider');

    mainSlider.slick({
      arrows  : false,
      fade    : true,
      asNavFor: previewSlider
    });

    previewSlider.slick({
      slidesToShow : 5,
      asNavFor     : mainSlider,
      focusOnSelect: true,
      responsive   : [
        {
          breakpoint: 1200,
          settings  : {
            slidesToShow: 4
          }
        }, {
          breakpoint: 767,
          settings  : {
            slidesToShow: 3
          }
        }, {
          breakpoint: 480,
          settings  : {
            slidesToShow: 2
          }
        }
      ]
    });
  }

  function articlesSlider() {
    $('.article-slider').slick({
      slidesToShow : 4,
      arrows       : false,
      dots         : true,
      autoplay     : true,
      autoplaySpeed: 6000,

      responsive: [
        {breakpoint: 1200, settings: {slidesToShow: 3}},
        {breakpoint: 767, settings: {slidesToShow: 2}},
        {breakpoint: 480, settings: {slidesToShow: 1}},
      ]
    });
  }

  function customSliderDots() {
    var
      simpleSlider  = $('.simple-slider.slick-initialized'),
      sliderDotsNav = simpleSlider.find('.slick-dots');

    if(sliderDotsNav.length !== 0) {
      var
        activeDots = sliderDotsNav.find('.slick-active');

      sliderDotsNav.append('<li class="circle"></li>');

      var decorCircle = $('.circle'),
          defaultPosition;

      function setDecorLinePosition(activeDots) {
        if(activeDots.position()) {
          defaultPosition = activeDots.position().left + activeDots.width() / 2;
          decorCircle.css('left', defaultPosition);
        }
      }

      setDecorLinePosition(activeDots);
      simpleSlider.on('afterChange', function(slick, currentSlide) {
        var activeDots = sliderDotsNav.find('.slick-active');
        setDecorLinePosition(activeDots);
      });
    }
  }

  var
    btnPosition = {
      init: function() {
        this.btn    = $('.site-footer .go-top');
        this.footer = $('.site-footer');

        this.attachEvent();
      },

      updateState: function() {
        this.footerPosition = this.footer.offset().top;
        this.winHeight      = this.browserHeight();
        this.scrollTop      = $(document).scrollTop();
      },

      attachEvent: function() {
        var
          self = this;

        this.btn.on('click', function() {
          $('body, html').animate({scrollTop: 0}, 1200);
          return false;
        });

        this.scrollHandler = function() {
          self.updateState();

          if(self.scrollTop + self.winHeight / 2 >= self.winHeight) {
            self.btn.addClass('fixed').fadeIn();
          } else {
            self.btn.removeClass('fixed').fadeOut();
          }

          if(self.scrollTop + self.winHeight >= self.footerPosition) {
            self.btn.addClass('bottom-position');
          } else {
            self.btn.removeClass('bottom-position');
          }
        };

        $(window).on('load resize orientationchange scroll', this.scrollHandler);
      },

      browserHeight: function() {
        return window.innerHeight || document.documentElement.clientHeight;
      }
    };

  function sidebarFilterAccordion() {
    $('.product-filter-form .filter-item').each(function() {
      var
        item       = $(this),
        itemTitle  = item.find('.item-title'),
        showHideEl = item.find('.item-info');

      if(item.hasClass('active')) {
        showHideEl.slideDown();
      }

      itemTitle.on('click', function(e) {
        e.preventDefault();
        if(item.hasClass('active')) {
          item.removeClass('active');
          showHideEl.slideUp();
        } else {
          item.addClass('active');
          showHideEl.slideDown();
        }

        setTimeout(function() {
          sticky.update();
        }, 500);
      });
    });
  }

  var scrollHolder = jQuery('.product-grid-section .scroll-box');
  if (scrollHolder.length !== 0) {
      scrollHolder.mCustomScrollbar({
          axis: "y",
          theme:"minimal-dark"
      });
  }

  function customTabInit() {
    function toggleActiveTab(navListItem, locationHash) {
      $('.tab-content .tab-item')
        .filter('.tab-item-' + locationHash)
        .add(navListItem)
        .addClass('active')
        .siblings()
        .removeClass('active');

      $('.slick-slider').slick('setPosition');
    }

    function getTabType(currentItem) {
      $('.product-grid-section').attr('data-type', currentItem.data('type'));
    }

    getTabType($('.tab-navigation-list .active'));

    $('.tab-navigation-list li a').on('click', function(e) {
      e.preventDefault();

      var
        navItem      = $(this).parent('li'),
        itemPosition = navItem.data('class');

      getTabType(navItem);
      toggleActiveTab(navItem, itemPosition);
    });

    $('.view-switcher li a').on('click', function() {
      setTimeout(function() {
        sticky.update();
      }, 500);
    });

    $(window).on('load', function() {
      if(window.location.hash) {
        var
          itemPosition = location.hash.substring(1),
          navItem      = $('.tab-navigation-list li[data-class="' + itemPosition + '"]');

        toggleActiveTab(navItem, itemPosition);
      }
    });
  }

  function mobileTabsMenu() {
    var
      doc          = $(document),
      filterHolder = $('.collapse-menu-holder'),
      menuSwitcher = filterHolder.find('.collapse-btn'),
      filterMenu   = filterHolder.find('.product-filter-form, .hidden-box');

    menuSwitcher.on('click', function() {
      menuSwitcher.toggleClass('active');
      filterMenu.slideToggle();
    });

    function outsideClickHandler(e) {
      if(!$(e.target).closest(filterHolder).length) {
        menuSwitcher.removeClass('active');
        filterMenu.slideUp();
      }
    }

    $(window).on('load resize orientaitionchange', function() {
      var
        winWidth = $(window).width();

      if(winWidth < 767) {
        doc.on('click', outsideClickHandler);
      } else
        if(winWidth > 767) {
          menuSwitcher.removeClass('active');
          filterMenu.css({'display': ''});
          doc.off('click', outsideClickHandler);
        }
    });
  }

  function sidebarViewSwitcher() {
    $('.product-grid-section .sidebar-switcher').on('click', function(e) {
      e.preventDefault();

      $('.product-grid-section').toggleClass('hidden');
    });
  }

  function customRangeSlider(t) {
    var
      sl = $('.range-slider');

    if(t)
      sl = t;

    sl.each(function() {
      var
        slider   = $(this).find('.slider'),
        maxValue = $(this).find('.range-value.max'),
        minValue = $(this).find('.range-value.min');

      minValue.mask('0000000000');
      maxValue.mask('0000000000');

      window[slider.attr('name')] = slider.slider({
        tooltip: 'hide'
      }).on('slide', function(slideEvt) {
        minValue.val(slideEvt.value[0]);
        maxValue.val(slideEvt.value[1]);
      }).data('slider');

      var
        valArray = slider.val().split(',');
      minValue.val(valArray[0]);
      maxValue.val(valArray[1]);

      minValue.on('blur', function() {
        var
          input    = $(this),
          newValue = parseInt(input.val()),
          dataMin  = parseInt(slider.attr('data-slider-min')),
          dataMax  = parseInt(slider.attr('data-slider-max'));

        var
          valArray    = slider.val().split(','),
          oldMaxValue = parseInt(valArray[1]);

        if(newValue < dataMin) {
          newValue = dataMin;
        } else {
          if(newValue > dataMax) {
            newValue = dataMax;
          }
        }

        if(newValue > oldMaxValue) {
          newValue = oldMaxValue;
        }

        slider.slider('setValue', [newValue, oldMaxValue], true);
      });

      maxValue.on('blur', function() {
        var
          input       = $(this),
          newValue    = parseInt(input.val()),
          dataMin     = parseInt(slider.attr('data-slider-min')),
          dataMax     = parseInt(slider.attr('data-slider-max')),
          valArray    = slider.val().split(','),
          oldMinValue = parseInt(valArray[0]);

        if(newValue > dataMax) {
          newValue = dataMax;
        } else {
          if(newValue < dataMin) {
            newValue = dataMin;
          }
        }

        if(newValue < oldMinValue) {
          newValue = oldMinValue;
        }

        slider.slider('setValue', [oldMinValue, newValue], true);
      });
    });
  }

  /*--------------------------------------------------------
   * Bootstrap Modal Check Max Height for vertical alignment
   * ------------------------------------------------------ */

  function setModalMaxHeight(element) {
    this.$element = $(element);
    this.$content = this.$element.find('.modal-content');

    var
      borderWidth   = this.$content.outerHeight() - this.$content.innerHeight(),
      dialogMargin  = $(window).width() < 768 ? 20 : 60,
      contentHeight = $(window).height() - (dialogMargin + borderWidth),
      headerHeight  = this.$element.find('.modal-header').outerHeight() || 0,
      footerHeight  = this.$element.find('.modal-footer').outerHeight() || 0,
      maxHeight     = contentHeight - (headerHeight + footerHeight);

    this.$content.css({
      'overflow': 'hidden'
    });

    this.$element
        .find('.modal-body').css({
      'max-height': maxHeight,
      'overflow-y': 'auto'
    });
  }

  $('.modal').on('show.bs.modal', function() {
    $(this).show();
    setModalMaxHeight(this);
  });

  $(window).resize(function() {
    if($('.modal.in').length != 0) {
      setModalMaxHeight($('.modal.in'));
    }
  });

  /*-------------------------------------------------------------
   * Bootstrap Modal Check Max Height for vertical alignment END
   * ---------------------------------------------------------- */

  function addFieldFunction() {
    $('body').on('click', '.custom-fields-group .add-field-btn', function(e) {
      e.preventDefault();
      var currentBtn   = $(this),
          fieldsGroup  = currentBtn.closest('.custom-fields-group'),
          currentField = currentBtn.closest('.input-holder'),
          cloneField   = currentField.clone();

      cloneField.find('input').removeClass('error').val('');
      cloneField.find('label.error').remove();

      cloneField.add(currentField).find('.del-field-btn').show();
      fieldsGroup.append(cloneField);
      currentBtn.hide();
      formValidation();
    });
  }

  function removeFieldFunction() {
    $('body').on('click', '.custom-fields-group .del-field-btn', function(e) {
      e.preventDefault();
      var
        delBtn                = $(this),
        fieldsGroup           = delBtn.closest('.custom-fields-group'),
        currentInputContainer = delBtn.closest('.input-holder');

      if(fieldsGroup.find('.input-holder').length > 1) {
        currentInputContainer.remove();
        fieldsGroup.find('.input-holder:last-child').find('.add-field-btn').show();
      }

      if(fieldsGroup.find('.input-holder').length < 2) {
        fieldsGroup.find('.del-field-btn').hide();
      }
    });
  }

  var
    certificateSlider = {
      init: function() {
        this.slider = $('.certificate-slider');

        this.attachEvent();
      },

      updateState: function() {
        this.winWidth         = $(window).width();
        this.mainContentWidth = $('.certificate-area .container').width();
      },

      attachEvent: function() {
        var self = this;

        this.resizeHandler = function() {
          self.updateState();
          if(self.winWidth > 767) {
            self.slider.css({
              "width": ((self.winWidth - self.mainContentWidth) / 2) + (self.mainContentWidth / 2) - 20
            });
          }
        };

        $(window).on('load resize orientationchange', this.resizeHandler);

        this.slider.slick({
          slidesToShow : 2,
          arrows       : true,
          dots         : false,
          variableWidth: true,
          autoplay     : true,
          autoplaySpeed: 6000,
          responsive   : [{breakpoint: 991, settings: {slidesToShow: 1, variableWidth: false}}]
        });
      }
    };

  function testimonialsSlider() {
    $('.testimonials-slider').slick({
      slidesToShow : 3,
      arrows       : true,
      dots         : true,
      centerMode   : true,
      autoplay     : true,
      autoplaySpeed: 6000,
      responsive   : [
        {
          breakpoint: 767,
          settings  : {
            arrows: false
          }
        }, {
          breakpoint: 767,
          settings  : {
            slidesToShow: 1,
            arrows      : false
          }
        }
      ]
    });
  }

  (function() {
    var
      collapseBox = $('form .collapse-input-group');

    $('form .switcher-checkbox input[type="checkbox"]').on('change', function() {
      if($(this).is(':checked')) {
        collapseBox.slideDown();
      } else {
        collapseBox.slideUp();
      }
    });
  })();

  var
    customSelect = $('.selectpicker');

  if(customSelect.length !== 0) {
    customSelect.selectpicker();
  }

  var validationForm = $('.validate-form');
  if(validationForm.length !== 0) {
    formValidation();
  }

  /* var phoneField = $('input[type="tel"]');
   if (phoneField.length !== 0) {
       phoneField.each(function () {
           var thisTel = $(this);
           thisTel.mask('+0 (000) 000-00-00');
       });
   }*/

  if($('.billboard-slider').length !== 0) {
    billboardSlider();
  }

  if($('.product-gallery').length !== 0) {
    productGallerySlider();
  }

  if($('.service-slider').length !== 0) {
    serviceSlider();
  }

  if($('.testimonials-slider').length !== 0) {
    testimonialsSlider();
  }

  if($('.article-slider').length !== 0) {
    articlesSlider();
  }

  if($('.collapse-menu-holder').length !== 0) {
    mobileTabsMenu();
  }

  var
    venoboxLink = $('.venobox-btn');

  if(venoboxLink.length !== 0) {
    venoboxLink.venobox({
      framewidth : '100vw',
      frameheight: '100vh'
    });
  }

  if($('.simple-slider').length !== 0) {
    customSliderDots();
  }

  if($('.product-filter-form').length !== 0) {
    sidebarFilterAccordion();
  }

  if($('.tab-holder').length !== 0) {
    customTabInit();
  }

  if($('.product-grid-section').length !== 0) {
    sidebarViewSwitcher();
  }

  if($('.range-slider').length !== 0) {
    customRangeSlider();
    window.customRangeSlider = customRangeSlider;
  }

  if($('.certificate-slider').length !== 0) {
    certificateSlider.init();
  }

  if($('[data-sticky-container]').length !== 0) {
    sticky = new Sticky('[data-sticky]', {});
  }

  if($('.custom-fields-group').length !== 0) {
    addFieldFunction();
    removeFieldFunction();
  }

  svg4everybody();
  pageLoaderInit();
  initSearchFormSwitcher();
  stickyHeader();
  mobileMenuInit();
  subMenuNavigation();
  btnPosition.init();
  audioPlaySwitcher();

  $(window).resize(function() {
    var
      sz = $('.depends-on-size');

    if($(window).width() > 767)
      sz.addClass('is-view-pc');
    else
      sz.removeClass('is-view-pc');
  });

  $(document).ready(function() {
    var
      sz = $('.depends-on-size');

    if($(window).width() > 767)
      sz.addClass('is-view-pc');
    else
      sz.removeClass('is-view-pc');
  });
})(jQuery);
