var modules = {

  initialize: function initialize(data) {
    console.log(data)
    this.conf = data;
    this.url  = '/';

    $('.select2_modules').select2({
      placeholder: "Выберите модуль",
      width      : "100%"
    }).change(function() {
      modules.addModule(this);
    });

    //      $('.select2_modules').trigger('change.select2', function() {
    //        modules.addModule(this);
    //      });

    //      console.log(this.conf)

    if(this.conf.plugins)
      (this.conf.plugins.split(',') || []).map(function(k) {
        console.log(k)
        modules.addModule({}, k);
      })
  },

  addModule: function(t, p) {
    var
      id;

    if(p)
      id = p;
    else
      id = $(t).val();

    if(id) {
      $('.loader').html('<img src="/admin/images/loader.gif"/>');
      $.ajax({
        type    : "post",
        url     : this.url + "admin/engineer/getmodele",
        data    : {id: id},
        cache   : false,
        dataType: "JSON",

        success: function(data) {
          if(data['result'] == 'ok') {
            if($('.plg-' + data['mass']['name']).html() == undefined) {
              var
                html = '<div class="panel plg-' + data['mass']['name'] + '">' +
                  '<div style="float: right" onclick="$(\'.plg-' + data["mass"]["name"] + '\').remove()" class="btn btn-danger"><i class="fa fa-times"></i></div>' +
                  '<div class="clear"></div>' +
                  data['mass']['body'] +
                  '<div class="clear"></div>' +
                  '<input type="hidden" name="plugins[]" value="' + data['mass']['name'] + '"/>' +
                  '</div>';

              $('.cont-form').append(html);
            } else {
              alert('этот плагин уже есть на странце')
            }

            $('.loader').html('');
          } else {
            alert('Плагин не найден')
          }
        }
      })
    }
  }
};