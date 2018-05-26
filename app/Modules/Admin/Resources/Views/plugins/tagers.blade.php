{!! $field !!}

<script>
	/**
	 * Tagers init functions
	 */
	window.tagersInit{{ ucfirst(strtolower($class)) }} = function() { };

	window.tagersInit{{ ucfirst(strtolower($class)) }}en = window.tagersInit{{ ucfirst(strtolower($class)) }}ru = function(lang) {
		var
			data = $('#' + '{{ $plugin['idAttr'] }}').attr('data-init-value'),
			t = '';

		if(lang)
			lang = lang.toString().trim();

		try {
			data = JSON.parse(data);

			if(!data[lang])
				data = {ru: [], en: []};
		} catch(err) {
			data = {ru: [], en: []};
		}

		for(var i = 0; data[lang].length > i; i++)
			t += '<option selected="selected">' + data[lang][i] + '</option>'

		$('.{{ $class }}' + lang).html(t);

		function initTagSelect2() {
			$(".select2-{{ $class }}").select2({
				multiple: true,
				language: "ru",
				minimumInputLength: 2,
				tags: [],

				escapeMarkup: function (markup) { return markup; },

				templateResult: function(repo) {
					if(repo.loading)
						return repo.text;

					var
						name = repo.name;

					return name;
				},

				templateSelection: function(repo) {
					return repo.name || repo.text;
				},

				width: '100%',
			});
		}

		initTagSelect2();
	};
</script>