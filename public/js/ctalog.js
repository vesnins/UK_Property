var
  catAll = {
    initialize: function initialize(data) {
      this.conf      = data || {};
      this.container = this.conf.container;
      catAll.loadOnclick();
    },

    loadOnclick: function loadOnclick(e) {
      setTimeout(function() {
        catAll.generateUrlCatalog();
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
    }
  };
