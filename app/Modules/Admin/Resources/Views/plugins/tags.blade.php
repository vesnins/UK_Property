{!! $field !!}

<script>
	/**
	 * Tags init functions
	 */
	window.tagsInit = function tagsInit() {

		var
			idTags = $('#' + '{{ $plugin['idAttr'] }}').attr('data-init-value');

		try {
			idTags = JSON.parse(idTags);
		} catch(err) {
			idTags = idTags || '';
		}

		$.ajax({
			type: "post",
			url: "/admin/plugins/getTagsList",
			data: {id_tags: idTags},
			cache: false,
			dataType: "json",
			success: function(data) {
				var
					t,
					name;

				for(var i = 0; data.items.length > i; i++) {
					try {
						name = JSON.parse(data.items[i].name)['{{ $lang }}'];
					} catch(err) {
						name = data.items[i].name || '';
					}

					t += '<option value="' + data.items[i].id + '" selected="selected">' + name + '</option>'
				}

				$('#' + '{{ $plugin['idAttr'] }}').html(t);
				initTagSelect2();
			}
		});

		function initTagSelect2() {
			$(".select2-tag").select2({
				multiple: true,
				language: "ru",
				minimumInputLength: 2,
				tags: [],

				ajax: {
					url: "/admin/plugins/getTags",
					dataType: 'json',
					delay: 250,
					type: 'post',
					data: function (params) {
						return {
							q: params.term, // search term
							page: params.page
						};
					},

					processResults: function (data, params) {
						params.page = params.page || 1;

						return {
							results: data.items,

							pagination: {
								more: (params.page * 30) < data.total_count
							}
						};
					},
					cache: true
				},
				escapeMarkup: function (markup) { return markup; },

				templateResult: function(repo) {
					if (repo.loading) return repo.text;
					var
						name = '';

					if(repo.is_new)
						name = repo.name + ' (Новый тег. Добавится после сохранения)';
					else
						name = repo.name;

					return name;
				},

				templateSelection: function(repo) {
					return repo.name || repo.text;
				},

				width: '100%',
			});
		}
	};
</script>