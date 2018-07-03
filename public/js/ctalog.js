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
          $(this).html(Math.round(parseFloat($(v).html()) * 3.28))
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
          val = $(this).val(),
          r   = $('[name="slider_area"]'),
          from   = $('[name="data-slider-min"]').val(),
          to   = $('[name="data-slider-max"]').val(),
          min,
          max;

        $(this).val(val === 'ft' ? 'm2' : 'ft');

        if(val === 'ft') {
          min = Math.round(from);
          max = Math.round(to);
        } else {
          min = Math.round(parseFloat(from * 3.28));
          max = Math.round(parseFloat(to * 3.28) + 1);
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

      _.assign(data, {page: page});

      catAll.isPortfolio &&
      _.assign(data, {is_portfolio: 1});

      _.assign(data, $('.product-filter-form').serializeArray());

      this.selectCatalog(data);
    },

    selectCatalog: function(data) {
      if(_.isEqual(data, catAll.currentData))
        return false;

      catAll.currentData = data;

      if(!data.session)
        $(catAll.container).animate({opacity: .5}, 150);

      $.ajax({
        type    : "post",
        url     : "/_tools/search_render_catalog",
        cache   : false,
        data    : data,
        dataType: "html",

        success: function(data) {
          $(catAll.container).html(data);
          $(catAll.container).animate({opacity: 1}, 150);

          setTimeout(function() {
            catAll.reversFtM2();
          }, 50);

          $('[data-page]').click(function(e) {
            e.preventDefault();
            $('[name="pagination"]').val($(this).data('page'));
            catAll.selectCatalog();
          });

          setTimeout(function() {
            var
              page = $('[name="pagination"]').val();

            if(isNaN(parseInt($('[data-page="' + page + '"]').data('page'))) && page > 1) {
              page = page - 1;
              $('[name="pagination"]').val(page);
              catAll.selectCatalog();
            }

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

             //             if(data.count)
             //               fav.show();
             //             else
             //               fav.hide();

             if(selectorLice.hasClass('like-button-' + id))
               selectorLice = $('.like-button-' + id);

             if(type === 'add') {
               selectorLice.addClass('active');
               selectorLice.attr('onclick', 'catAll.addCart(' + id + ', \'remove\', \'' + nameUrl + '\')');
             } else {
               selectorLice.removeClass('active');
               selectorLice.attr('onclick', 'catAll.addCart(' + id + ', \'add\', \'' + nameUrl + '\')');
             }

             if(window.location.pathname.split('/').indexOf('favorite') !== -1) {
               catAll.selectCatalog({session: 1});
             }
           }
         }
       })
    },

    initMap: function() {
      if(!_.isFunction(google))
        return false;

      $('#map').height($(window).height() - 102);

      var
        mapOptions;

      mapOptions = {
        zoom: 17,

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

              map : catAll.map,
              icon: window.location.origin + '/images/pin.png'
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
                  '<a href="' + val.url + '" class="button">' + val.choose + '</a>' +
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
    }
  };
