var
  catAll = {
    initialize: function initialize(data) {
      this.conf      = data || {};
      this.container = this.conf.container;
      this.isLoad    = this.conf.isLoad == undefined ? true : this.conf.isLoad;
      catAll.loadOnclick();
    },

    loadOnclick: function loadOnclick() {
      setTimeout(function() {
        if(catAll.isLoad)
          catAll.generateUrlCatalog();

        // init cart min
        catAll.addCart(0, 'init', false);
      });
    },

    generateUrlCatalog: function() {
      var
        data = {},
        page    = $('[name="pagination"]').val();

      _.assign(data, {page: page});
      _.assign(data, $('.product-filter-form').serializeArray());

      console.log(data)
      this.selectCatalog(data);
    },

    selectCatalog: function(data) {


      $.ajax({
        type    : "post",
        url     : "/_tools/search_render_catalog",
        cache   : false,
        data    : data,
        dataType: "html",

        success: function(data) {
          $(catAll.container).html(data);
          $(catAll.container).animate({opacity: 1}, 150);

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

         cache: false,
         dataType: "JSON",

         success : function(data) {
           if(data.result === 'ok') {
             var
               fav          = $('.wish-list'),
               selectorLice = $('.like-button');

             fav.find('.qty').html('(' + data.count + ')');

             if(data.count)
               fav.show();
             else
               fav.hide();

             if(window.location.pathname.split('/').indexOf('favorite') !== -1) {
               if(selectorLice.hasClass('like-button-' + id))
                 selectorLice = $('.like-button-' + id);

               if(type === 'add') {
                 selectorLice.addClass('active');
                 selectorLice.attr('onclick', 'catAll.addCart(' + id + ', \'remove\', \'' + nameUrl + '\')');
               } else {
                 selectorLice.removeClass('active');
                 selectorLice.attr('onclick', 'catAll.addCart(' + id + ', \'add\', \'' + nameUrl + '\')');
                 catAll.selectCatalog({session: 1});
               }
             }
           }
         }
       })
    },
  };
