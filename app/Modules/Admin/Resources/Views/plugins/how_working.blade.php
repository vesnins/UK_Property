<style>
  .how_working-cont {
    border: solid 1px #e4e4e4;
    padding: 10px;
  }
</style>

<div class="">
  {!! $field !!}
</div>

@php($langName = '-]-options-[-')
@php($lang = '--options--')

<script>
  window.how_workingInit = function(lang) {
  };

  function deleteDi{{ $langName }} (c) {
    $(c).remove();
  }

  var
    addHow_working{{ $langName }} = function(ev, d, l) {
     var
       n = parseInt($('.add-how_working{{ $langName }}').attr('data-n'));

       $('.add-how_working{{ $langName }}').attr('data-n', n + 1);

      $('#how_working{{ $langName }}').append('<div class="cont-hw id{{ $langName }}-' + n + ' row" style="margin-bottom: 15px">' +
        '<div class="col-md-10">' +
        '<div class="col-md-12">' +
        '<input style="margin-bottom: 5px" placeholder="@lang('admin::plugins.title')" type="text" name="pl[how_working]' + '{{ $lang }}' + '[how_working_name][]" class="form-control" value="' + (d || '') + '" />' +
        '</div>' +
        '<div class="col-md-12">' +
        '<textarea placeholder="@lang('admin::plugins.text')" type="text" name="pl[how_working]' + '{{ $lang }}' + '[how_working_text][]" class="form-control">' + (l || '') + '</textarea>' +
        '</div>' +
        '</div>' +
        '<div class="col-md-2">' +
        '<button type="button" onclick="deleteDi{{ $langName }}(\'.id{{ $langName }}-' + n + '\')" class="btn btn-danger btn-icon">' +
        '<i class="fa fa-minus"></i>' +
        '</button>' +
        '</div>' +
        '</div>');
    };

  $('.add-how_working{{ $langName }}').click(addHow_working{{ $langName }});

  /**
   * Tags init functions
   */
  window.how_workingInit{{ $langName }} = function(lang) {
    var
      initValue,
      obj;

    if(lang)
      lang = lang.trim();

    if(lang)
      initValue = $('#' + '{{ $plugin['idAttr'] }}' + lang).attr('data-init-value');
    else
      initValue = $('#' + '{{ $plugin['idAttr'] }}').attr('data-init-value');

    try {
      initValue = JSON.parse(initValue);
      obj       = initValue[lang] || initValue;

      for(var i = 0; Object.keys(obj['how_working_name']).length > i; i++) {
        addHow_working{{ $langName }}(null, obj['how_working_name'][i], obj['how_working_text'][i]);
      }
    } catch(err) {
    }
  };
</script>