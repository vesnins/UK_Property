var modules = {

    initialize: function initialize(data) {
        this.conf = data;
        this.url = '/';

        $('.select2_modules').select2({
            placeholder: "Выберите модуль",
            width: "100%"
        }).change(function () {
            modules.addModule(this);
        });
    },

    addModule: function addModule (t) {
        var id = parseInt($(t).val());
        $('.select2_modules').val(0);

        if(id) {
            $('.loader').html('<img src="/admin/images/loader.gif"/>');
            return $.ajax
            ({
                type: "post",
                url: this.url + "admin/engineer/getmodele",
                data: {id: id},
                cache: false,
                dataType: "JSON",
                success: function (data) {
                    if(data['result'] == 'ok') {
                        if($('.plg-' +data['mass']['id']+ '').html() == undefined)
                        {
                            var html;
                            html =
                                '<div class="panel plg-' +data['mass']['id']+ '">' +
                                '<div style="float: right" onclick="$(\'.plg-' + data["mass"]["id"]+ '\').remove()" class="btn btn-danger"><i class="fa fa-times"></i></div>' +
                                '<div class="clear"></div>' +
                                data['mass']['body'] +
                                '<input type="hidden" name="plugins[]" value="' +data['mass']['id']+ '"/>' +
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
            });
        }
    }
};