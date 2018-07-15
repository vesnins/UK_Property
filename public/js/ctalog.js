var
  catAll = {
    initialize: function initialize(data) {
      this.conf        = data || {};
      this.container   = this.conf.container;
      this.isLoad      = this.conf.isLoad == undefined ? true : this.conf.isLoad;
      this.isPortfolio = this.conf.isPortfolio == undefined ? true : this.conf.isPortfolio;
      this.markers     = [];
      this.firstLoad   = false;
      catAll.loadOnclick();
    },

    loadOnclick: function loadOnclick() {
      var
        selectorForm = $('[name="catalog_form"]');
      // init cart min
      catAll.addCart(0, 'init', false);

      setTimeout(function() {
        catAll.reversFtM2Click();
        $('[name="type_ft_m2"]').click();
        $('[name="type_ft_m2"]').click();
      }, 50);

      setTimeout(function() {
        if(catAll.isLoad)
          catAll.generateUrlCatalog();
      }, 100);

      selectorForm.click(function() {
        setTimeout(function() {
          catAll.generateUrlCatalog();
        }, 100);
      });

      selectorForm.mouseup(function() {
        setTimeout(function() {
          catAll.generateUrlCatalog();
        }, 100);
      });

      $(window).resize(function() {
        $('#map').height($(window).height() - 102);
      })
    },

    reversFtM2: function() {
      var
        val = $('[name="type_ft_m2"]').val();

      if(val === 'ft') {
        $('.s-pl').map(function(k, v) {
          console.log(parseFloat($(this).html()))
          $(this).html(Math.round(parseFloat($(this).html()) * 10.7638673611111))
        });

        $('.s-mf').map(function() {
          $(this).html('ft²');
        });
      } else {
        $('.s-mf').map(function() {
          $(this).html('m²');
        });
      }
    },

    reversFtM2Click: function() {
      $('[name="type_ft_m2"]').click(function() {
        var
          val  = $(this).val(),
          r    = $('[name="slider_area"]'),
          from = $('[name="data-slider-min"]').val(),
          to   = $('[name="data-slider-max"]').val(),
          min,
          max;

        $(this).val(val === 'ft' ? 'm2' : 'ft');

        if(val === 'ft') {
          min = Math.round(from);
          max = Math.round(to);
        } else {
          min = Math.round(parseFloat(from * 10.7638673611111));
          max = Math.round(parseFloat(to * 10.7638673611111) + 1);
        }

        r.attr('data-slider-min', min);
        r.attr('data-slider-max', max);
        r.attr('data-value', min + ',' + max);
        r.attr('value', min + ',' + max);
        r.attr('data-slider-value', '[' + min + ',' + max + ']');

        $('[name="area_from"]').val(min);
        $('[name="area_to"]').val(max);
        window['slider_area'].destroy();

        setTimeout(function() {
          if(window.customRangeSlider)
            window.customRangeSlider($('.slider-area'));
        }, 0);
      })
    },

    generateUrlCatalog: function() {
      var
        data = {},
        page = $('[name="pagination"]').val();

      _.assign(data, {page: page, show_items: catAll.conf.show_items});

      catAll.isPortfolio &&
      _.assign(data, {is_portfolio: 1});

      _.assign(data, $('.product-filter-form').serializeArray());

      this.selectCatalog(data);
    },

    selectCatalog: function(data) {
      data = data || {};

      if(!data.session)
        if(_.isEqual(data, catAll.currentData))
          return false;

      catAll.currentData = data;

      if(!data.session)
        $(catAll.container).animate({opacity: .5}, 150);

      if(catAll.currentLoad)
        catAll.currentLoad.abort();

      catAll.currentLoad = $.ajax({
        type    : "post",
        url     : "/_tools/search_render_catalog",
        cache   : false,
        data    : data,
        dataType: "html",

        success: function(res) {
          for(var i = 0; Object.keys(data || {}).length > i; i++) {
            if((data[i] || {}).name === 'pagination') {
              catAll.skipClick = true;
              catAll.currentData[i].value = data[i].value;
              $('[name="pagination"]').val(data[i].value);
            }
          }

          $(catAll.container).html(res);
          $(catAll.container).animate({opacity: 1}, 150);

          $('[data-page]').click(function(e) {
            e.preventDefault();
            $('[name="pagination"]').val($(this).data('page'));
          });

          setTimeout(function() {
            if(catAll.isLoad)
              catAll.addMarker();

            $('.product-details').animate({opacity: 1}, 150);
          }, 200)
        }
      });
    },

    addCart: function(id, type, nameUrl) {
      $.ajax
       ({
         type: "post",
         url : "/_tools/add_favorite",

         data: {
           get_data: true,
           id      : id,
           type    : type,
           name_url: nameUrl,
         },

         cache   : false,
         dataType: "JSON",

         success: function(data) {
           if(data.result === 'ok') {
             var
               fav          = $('.wish-list'),
               selectorLice = $('.like-button');

             fav.find('.qty').html('(' + data.count + ')');

             if(id > 0) {
               if(selectorLice.hasClass('like-button-' + id))
                 selectorLice = $('.like-button-' + id);

               if(type === 'add') {
                 selectorLice.addClass('active');
                 selectorLice.attr('onclick', 'catAll.addCart(' + id + ', \'remove\', \'' + nameUrl + '\')');
               } else {
                 selectorLice.removeClass('active');
                 selectorLice.attr('onclick', 'catAll.addCart(' + id + ', \'add\', \'' + nameUrl + '\')');
               }
             }

             if(window.location.pathname.split('/').indexOf('favorite') !== -1) {
               catAll.selectCatalog({session: 1});
             }
           }
         }
       })
    },

    initMap: function() {
      $('#map').height($(window).height() - 102);

      var
        mapOptions;

      mapOptions = {
        zoom          : 17,
        minZoom       : 6,
        mapTypeControl: false,

        styles     : [
          {"featureType": "road", "stylers": [{"hue": "#5e00ff"}, {"saturation": -79}]},

          {
            "featureType": "poi",

            "stylers": [
              {"saturation": -78},
              {"hue": "#6600ff"},
              {"lightness": -47},
              {"visibility": "off"}
            ]
          },

          {"featureType": "road.local", "stylers": [{"lightness": 22}]},
          {"featureType": "landscape", "stylers": [{"hue": "#6600ff"}, {"saturation": -11}]},
          {},
          {},
          {"featureType": "water", "stylers": [{"saturation": -65}, {"hue": "#1900ff"}, {"lightness": 8}]},
          {"featureType": "road.local", "stylers": [{"weight": 1.3}, {"lightness": 30}]},

          {
            "featureType": "transit",
            "stylers"    : [{"visibility": "simplified"}, {"hue": "#5e00ff"}, {"saturation": -16}]
          },

          {"featureType": "transit.line", "stylers": [{"saturation": -72}]},
          {}
        ],
        scrollwheel: true,
        center     : new google.maps.LatLng(7.893542000, 98.29680200)
      };

      catAll.map = new google.maps.Map(document.getElementById('map'), mapOptions);
    },

    addMarker: function(update) {
      if(!update) {
        var
          val = {};

        catAll.bounds     = new google.maps.LatLngBounds();
        catAll.infoWindow = new google.maps.InfoWindow();

        if(!_.isArray(catAll.markers))
          catAll.markers = [];

        for(var i = 0; (catAll.markers || []).length > i; i++) {
          if(catAll.markers[i])
            catAll.markers[i].setMap(null);
        }

        for(var i = 0; window.objectCurrent.length > i; i++) {
          val = window.objectCurrent[i];

          if(val.coordinates.split(',').length === 2) {
            catAll.markers[i] = new google.maps.Marker({
              position: new google.maps.LatLng(
                parseFloat(val.coordinates.split(',')[0]),
                parseFloat(val.coordinates.split(',')[1])
              ),

              map: catAll.map,

              icon: {
                url       : window.location.origin + '/images/pin.png',
                scaledSize: new google.maps.Size(40, 43), // scaled size
                origin    : new google.maps.Point(0, 0), // origin
                anchor    : new google.maps.Point(20, 22) // anchor
              },
            });

            catAll.markers[i].addListener('click', function(val, i) {
              return function() {
                catAll.infoWindow.setContent(
                  '<div class="location-info">' +
                  '<div class="img-box" style="background-image: url(' + val.img + ')">' +
                  '<a href="javascript:void(0)" class="add-to-wishList" target="_blank">' +
                  '<svg><use xlink:href="images/svg/sprite.svg#heart-icon"></use></svg>' +
                  '</a>' +
                  '</div>' +
                  '<div class="content-box">' +
                  '<div class="scroll-box">' +
                  '<h6>' + (val.name || '') + '</h6>' +
                  '<p>' + (val.little_description || '') + '</p>' +
                  '<ul class="data-list">' +
                  '<li>' + (val.area || '') + '</li>' +
                  '<li>' + (val.bedrooms || '') + '</li>' +
                  '</ul>' +
                  '<span class="price">' + (val.price || '') + '</span>' +
                  '<div class="text-center">' +
                  '<a target="_blank" href="' + val.url + '" class="button">' + val.choose + '</a>' +
                  '</div>' +
                  '</div>' +
                  '</div>' +
                  '</div>'
                );
                catAll.infoWindow.open(catAll.markers[i], this);
              }
            }(val, i));

            catAll.bounds.extend(
              new google.maps.LatLng(
                parseFloat(val.coordinates.split(',')[0]),
                parseFloat(val.coordinates.split(',')[1])
              )
            );
          }
        }
      }

      if(catAll.map && !catAll.firstLoad && update) {
        setTimeout(function() {

          google.maps.event.trigger(catAll.map, "resize");
          catAll.map.fitBounds(catAll.bounds);
          catAll.firstLoad = true;
        }, 1000);
      }
    },

    catalogReset: function() {
      $('[name=\'catalog_form\']')[0].reset();

      // сброс для max
      $('.s-map-reset').map(function() {
        $(this).val($(this)
          .parents('.range-slider')
          .find('.parent-input')
          .attr('data-slider-' + ($(this).hasClass('max') ? 'max' : 'min')));
      });

      setTimeout(function() {
        $('.max').map(function() {
          $(this).focus();
          $(this).focusout();

          setTimeout(function() {
            $('.reset-btn').focus();
          })
        });
      }.bind(this));
      // сброс для max

      // сброс для min
      setTimeout(function() {
        $('.s-map-reset').map(function() {
          $(this).val($(this)
            .parents('.range-slider')
            .find('.parent-input')
            .attr('data-slider-' + ($(this).hasClass('max') ? 'max' : 'min')));
        });

        setTimeout(function() {
          $('.min').map(function() {
            $(this).focus();
            $(this).focusout();

            setTimeout(function() {
              $('.reset-btn').focus();
            })
          });
        }.bind(this));
      }, 300);
      // сброс для max
    }
  };
