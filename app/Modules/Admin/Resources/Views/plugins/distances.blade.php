<style>
	.distances-cont {
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
	function deleteDi{{ $langName }} (c) {
		$(c).remove();
	}

	var
		addDistances{{ $langName }} = function(ev, d, l) {
			var
				n = $(this).data('n');

			$(this).data('n', n + 1);

			$('#distances{{ $langName }}').append('<div class="id{{ $langName }}-' + n + ' row" style="margin-bottom: 15px">' +
				'<div class="col-md-5">' +
				'<input placeholder="@lang('admin::plugins.object')" type="text" name="pl[distances]' + '{{ $lang }}' + '[distances][]" class="form-control" value="' + (d || '') + '" />' +
				'</div>' +
				'<div class="col-md-5">' +
				'<input placeholder="@lang('admin::plugins.location')" type="text" name="pl[distances]' + '{{ $lang }}' + '[location][]" class="form-control" value="' + (l || '') + '" />' +
				'</div>' +
				'<div class="col-md-2">' +
				'<button type="button" onclick="deleteDi{{ $langName }}(\'.id{{ $langName }}-' + n + '\')" class="btn btn-danger btn-icon">' +
				'<i class="fa fa-minus"></i>' +
				'</button>' +
				'</div>' +
				'</div>');
		};

	$('.add-distances{{ $langName }}').click(addDistances{{ $langName }});

	/**
	 * Tags init functions
	 */
	window.distancesInit{{ $langName }} = function distancesInit{{ $langName }}(lang) {
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

			for(var i = 0; Object.keys(obj['distances']).length > i; i++) {
				addDistances{{ $langName }}(null, obj['distances'][i], obj['location'][i]);
			}
		} catch(err) {
		}
	};
</script>