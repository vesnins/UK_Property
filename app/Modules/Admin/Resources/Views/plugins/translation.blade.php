<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">@lang('admin::plugins.' . $plugin['translateKey'])</label>

	<div class="col-md-6 col-sm-6 col-xs-12">
		<div class="col-md-1 col-sm-2 col-xs-12">
			<button class="btn btn-warning" type="button" id="lang-convert">
				<i class="fa fa-language"></i>
			</button>
		</div>

		<div class="col-md-11 col-sm-10 col-xs-12">
			<input
				type="text"
				name="{{ $plugin['nameAttr'] }}"
				id="{{ $plugin['idAttr'] }}"
				class="form-control {{ isset($plugin['classAttr']) ? $plugin['classAttr'] : '' }}"
				placeholder="{{ $plugin['translateKey'] ?? false ? trans('admin::plugins.' . $plugin['translateKey']) : $plugin['nameText'] }}"
			/>

			<br class="clear" />
		</div>
	</div>
</div>

<script>
	var
		id = '{{ $plugin['idAttr'] }}';

	$('#lang-convert').click(function() {
		var
			str = $('#inputName').val().toLowerCase().trim().replace(/[^A-Za-zА-Яа-яЁё /]/g, '').replace(/\s+/g, ' '),
			rus = [
				'а',
				'б',
				'в',
				'г',
				'д',
				'е',
				'ё',
				'ж',
				'з',
				'и',
				'й',
				'к',
				'л',
				'м',
				'н',
				'о',
				'п',
				'р',
				'с',
				'т',
				'у',
				'ф',
				'х',
				'ц',
				'ч',
				'ш',
				'щ',
				'ъ',
				'ы',
				'ь',
				'э',
				'ю',
				'я',
				'–'
			],
			eng = [
				'a',
				'b',
				'v',
				'g',
				'd',
				'e',
				'ye',
				'j',
				'z',
				'i',
				'i',
				'k',
				'l',
				'm',
				'n',
				'o',
				'p',
				'r',
				's',
				't',
				'u',
				'f',
				'h',
				'tz',
				'ch',
				'sh',
				'sh',
				"",
				'i',
				'i',
				'e',
				'yu',
				'ya',
				'–'
			],
			val = [];

		for(var i = 0, len = str.length; i < len; i++) {
			if(rus.indexOf(str[i]) !== -1)
				val[i] = eng[rus.indexOf(str[i])];
			else
				val[i] = '-';
		}

		if(!val.join('').trim())
			val = $('[name="pl[name][en]"]')
				.val()
				.toLowerCase()
				.trim()
				.replace(/[^A-Za-zА-Яа-яЁё /]/g, '')
				.replace(/\s+/g, ' ');

		val = _.isArray(val) ? val.join('') : val.replace(/ /g, '-');
		$('#' + id).val(val.length < 4 ? '': val)
	});

	$(window).load(function() {
		$('#' + id).val($('#' + id).data('init-value') == 0 ? '': $('#' + id).data('init-value'))
	})
</script>