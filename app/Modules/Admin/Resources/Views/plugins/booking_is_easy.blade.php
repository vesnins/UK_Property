<style>
	.booking_is_easy-cont {
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
		addBooking_is_easy{{ $langName }} = function(ev, d, l) {
			var n = $(this).data('n');
			$(this).data('n', n + 1);

			$('#booking_is_easy{{ $langName }}').append('<div class="id{{ $langName }}-' + n + ' row" style="margin-bottom: 15px">' +
				'<div class="col-md-10">' +
				'<div class="row">' +
				'<div class="col-md-12">' +
				'<input placeholder="title" type="text" name="pl[booking_is_easy]' + '{{ $lang }}' + '[name][]" class="form-control" style="margin-bottom: 10px;" value="' + (d || '') + '" />' +
				'</div>' +
				'<div class="col-md-12">' +
				'<textarea placeholder="description" type="text" name="pl[booking_is_easy]' + '{{ $lang }}' + '[text][]" class="form-control">' + (l || '') + '</textarea>' +
				'</div>' +
				'</div>' +
				'</div>' +
				'<div class="col-md-2">' +
				'<button type="button" onclick="deleteDi{{ $langName }}(\'.id{{ $langName }}-' + n + '\')" class="btn btn-danger btn-icon">' +
				'<i class="fa fa-minus"></i>' +
				'</button>' +
				'</div>' +
				'</div>');
		};

	$('.add-booking_is_easy{{ $langName }}').click(addBooking_is_easy{{ $langName }});

	/**
	 * Tags init functions
	 */
	window.booking_is_easyInit = window.booking_is_easyInit{{ $langName }} = function booking_is_easyInit{{ $langName }}(lang) {
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

			for(var i = 0; Object.keys(obj['name']).length > i; i++) {
				addBooking_is_easy{{ $langName }}(null, obj['name'][i], obj['text'][i]);
			}
		} catch(err) {
		}
	};
</script>
