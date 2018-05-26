$(function($) {
	$.pxml = {
		url: '/',

		initialize: function initialize(data) {
			this.conf           = data;
			this.csrf_token     = this.conf.csrf_token;
			this.btnUpload      = $('#upload');
			this.conteiner      = $('#status');
			this.document       = {};
			this.column         = {};
			this.table          = $(".select2").val();
			this.AjaxUploadFunc = null;

			this.AjaxUpload();
			this.tableUp();
		},

		tableUp: function() {
			$(".select2").on("select2:select", function() {
				$.pxml.table = $(".select2").val();
			})
		},

		AjaxUpload: function() {
			this.AjaxUploadFunc = new AjaxUpload(this.btnUpload, {
				action    : '/admin/index/backup/upload-xml',
				name      : 'uploadfile',
				onSubmit  : function(file, ext) {
					if(!(ext && /^(xml|xlsb)$/.test(ext))) {
						$.pxml.conteiner.text('Поддерживаемые форматы xml');

						return false;
					} else {
						$.pxml.AjaxUploadFunc.setData({'table': $.pxml.table});
					}

					$('#text_back').html('');
					$.pxml.conteiner.html('Загрузка.. <i class="fa fa-spinner"></i>');
				},
				onComplete: function(file, response) {
					var
						r = JSON.parse(response);

					$.pxml.document = r.document;
					$.pxml.column   = r.column;
					$.pxml.conteiner.text('');

					if(r['result'] === 'ok') {
						var
							res = '<table class="table">' +
								'<thead><tr>' +
								'<th style="min-width: 150px">Сценарий:</th>' +
								'</tr></thead><tbody>';

						res += '<tr class="panel panel-primary"><td>' +
							'<select class="form-control table-name select2 " name="script">' +
							'<option value="-1">Не использовать</option>';

						for(var yi = 0; r.script.length > yi; yi++) {
							res += '<option value="' + r.script[yi]["id"] + '">' + r.script[yi]["name"] + '</option>';
						}

						res += '</select> ' +
							'</td><td class="text-right">' +
							'<button type="button" class="btn btn-primary" onclick="$.pxml.getScheme()">Применить</button>' +
							'</td></tr>' +

							'<tr class="panel panel-primary"><td>' +
							'<input name="name_script" class="form-control" placeholder="Введите название"/>' +
							'</td><td class="text-right">' +
							'<button type="button" class="btn btn-primary" onclick="$.pxml.saveScheme()">Сохранить сценарий</button>' +
							'</td></tr>' +
							'</tbody><table>' +
							'<br />';

						res += '<table class="table">' +
							'<thead><tr>' +
							'<th style="min-width: 150px">Родитель:</th>' +
							'<th>Поле</th>' +
							'<th>Действие</th>' +
							'</tr></thead><tbody class="parent-input"></tbody>' +
							'</table>' +

							'<p>' +
							'<div class="text-right">' +
							'<button class="btn btn-success btn-sm" onclick="$.pxml.addParentInput(true)">' +
							'<i class="fa fa-plus"></i>' +
							'</button>' +
							'</div>' +
							'</p>' +
							'<br />';

						res += '<table class="table">' +
							'<thead><tr>' +
							'<th>#</th>' +
							'<th>Поля</th>' +
							'<th>Значения</th>' +
							'</tr></thead><tbody>';

						var d = r.document[0];
						for(var i = 0; r.column.length > i; i++) {
							res += '<tr>' +
								'<th scope="row">' + i + '</th>' +
								'<td>' + r.column[i] + '</td>';

							res += '<td>' +
								'<select class="form-control table-column" name="' + r.column[i] + '">' +
								'<option value="-1">Не использовать</option>';

							for(var ii = 0; d.length > ii; ii++) {
								res += '<option value="' + d[ii]['key'] + '"  data-parent="' + r.column[i] + '" >' +
									'' + d[ii]['key'] + ' => ' + d[ii]['val'].toString().substr(0, 100) + '' +
									'</option>';
							}

							res += '</select> </td>';
							res += '</tr>';
						}

						res += '<tr><td colspan="3" class="text-right">' +
							'<button type="button" class="btn btn-primary" onclick="$.pxml.setImport()">Импорт</button>' +
							'</td></tr>';

						res += '</tbody><table>';

						$('.res-parse').html(res);

						setTimeout(function() {
							$.pxml.addParentInput();
						}, 50)
					} else {
						$('<li></li>').appendTo('#files').text(file).addClass('error');
					}
				}
			});

		},

		addParentInput: function(first, number) {
			var
				res,
				column,
				document,
				del = '',
				id;

			if(!number)
				number = 0;

			column   = $.pxml.column;
			document = $.pxml.document;
			id       = Math.floor(Math.random() * (9999 - 1000 + 1)) + 1000;

			res = '<tr id="' + id + '">' +
				'<td>' +
				'<select class="form-control table-name select2 table-key parent_key parent_key-' + number + '" name="parent_key[]">' +
				'<option value="-1">Не использовать</option>';

			for(var qi = 0; column.length > qi; qi++) {
				res += '<option value="' + column[qi] + '" data-parent="' + column[qi] + '" >' + column[qi] + '</option>';
			}

			res += '</select>' +
				'</td>' +
				'<td>' +
				'<select class="form-control table-name select2 table-val parent_val-' + number + '" name="parent_val[]">' +
				'<option value="-1">Не использовать</option>';

			var
				d = document[0];

			for(var wi = 0; d.length > wi; wi++)
				res += '<option value="' + d[wi]['key'] + '"  data-parent="' + d[wi]['key'] + '" >' +
					'' + d[wi]['key'] + ' => ' + d[wi]['val'].toString().substr(0, 100) + '' +
					'</option>';

			if(first)
				del = '<button class="btn btn-danger btn-sm" onclick="$(\'#' + id + '\').remove()">' +
					'<i class="fa fa-minus"></i>' +
					'</button>';

			res += '</select>' +
				'</td>' +
				'<td>' +
				del +
				'</td>' +
				'</tr>';

			$('.parent-input').append(res);
		},

		setImport: function() {
			var
				d = JSON.stringify({
					"parent"  : $.pxml.getWhereParams(),
					"column"  : $.pxml.getSchema(),
					"_token"  : $.pxml.csrf_token,
					"document": $.pxml.document,
					"table"   : $.pxml.table
				});

			$.ajax({
				type       : "post",
				url        : "/admin/index/backup/update-xml",
				data       : d,
				cache      : false,
				contentType: "application/json; charset=utf-8",
				dataType   : "JSON",
				success    : function(data) {
					if(data['result'] == "ok") {
						$('.res-parse').html(
							'Обновлено: ' + data.update + '<br />' +
							'Добавлено: ' + data.create + '<br />'
						);

						$.pxml.addImg(data['request']);
					} else {
						$('<li></li>').appendTo('#files').text(file).addClass('error');
					}
				}
			})
		},

		getWhereParams: function() {
			var parent_key = [],
					parent_val = [];

			$('.table-key option:selected').each(function() {
				if(this.value != -1) parent_key = _.concat(parent_key, [{"column": this.value}])
			});

			$('.table-val option:selected').each(function() {
				if(this.value != -1) parent_val = _.concat(parent_val, [{"document": this.value}])
			});

			return {
				"parent_key": parent_key,
				"parent_val": parent_val
			}
		},

		getSchema: function() {
			var
				arr = [];

			$('.table-column option:selected').each(function() {
				if(this.value != -1) {
					arr = _.concat(arr, [
						{
							"column"  : this.attributes['data-parent'].value,
							"document": this.value
						}
					]);
				}
			});

			return arr;
		},

		saveScheme: function() {
			var
				name = $("[name='name_script']").val();

			if(name.trim() != '') {
				$.ajax
				 ({
					 type    : "post",
					 url     : "/admin/index/backup/save-xml-schema",
					 data    : {
						 "parent": $.pxml.getWhereParams(),
						 "column": $.pxml.getSchema(),
						 "_token": $.pxml.csrf_token,
						 "name"  : name
					 },
					 cache   : false,
					 dataType: "JSON",
					 success : function(data) {
						 if(data.result === 'ok') {
							 $('[name="script"]').append($('<option value="' + data.id + '">' + data.name + '</option>'));
							 $("[name='name_script']").val('')
						 } else {
							 console.log('dataError', data);
						 }
					 }
				 })
			}
		},

		getScheme: function() {
			var
				id = $('[name="script"]').val();

			if(id) {
				$.ajax
				 ({
					 type    : "post",
					 url     : "/admin/index/backup/get-xml-schema",
					 data    : {"id": id, "_token": $.pxml.csrf_token},
					 cache   : false,
					 dataType: "JSON",
					 success : function(data) {
						 if(data.result == 'ok') {
							 $.pxml.setSchema(data.data);

							 console.log('getScheme result', data);
						 } else {
							 console.log('dataError', data);
						 }
					 }
				 })
			}
		},

		setSchema: function(f) {
			if(f.column) {
				for(var ii = 0; (_.get(f, 'parent.parent_key ') || {}).length > ii; ii++) {
					if(ii > 0) {
						$.pxml.addParentInput(true, ii)
					}

					var ci = f.parent.parent_key[ii];
					var cv = f.parent.parent_val[ii];

					$('.parent_key-' + ii + ' [value="' + ci.column + '"]').attr("selected", "selected");
					$('.parent_val-' + ii + ' [value="' + cv.document + '"]').attr("selected", "selected");
				}

				for(var i = 0; f.column.length > i; i++) {
					var c = f.column[i];

					$('[name="' + c.column + '"] [value="' + c.document + '"]').attr("selected", "selected");
				}
			}
		},

		addImgLoad: function addImgLoad(request, l) {
			if(request[l] != undefined) {
				if((request[l]['img']).length < 10) {
					this.addImgLoad(request, (l - 1))
				} else {
					$.ajax
					 ({
						 type    : "post",
						 url     : '/admin/index/backup/upload-img-rooms',
						 data    : {image: request[l]['img'], id_album: request[l]['id']},
						 cache   : false,
						 dataType: "html",
						 success : function(data) {
							 console.log(data);

							 setTimeout(function() {
								 $.pxml.addImgLoad(request, (l - 1))
							 }, 300)
						 }
					 });
				}
			}
		},

		addImg: function addImg(request) {
			var
				obj = [];

			console.log(request);
			console.log(Object.keys(request).length + 'hhh');
			for(var i = 0; Object.keys(request).length > i; i++) {
				console.log(request[i] + ' g ' + i);

				if(request[i] != undefined) {
					var id  = request[i]['id'];
					var img = request[i]['img'];
					if(request[i]['img'].length > 15) {
						obj.push({'id': id, 'img': img});
						console.log({'id': id, 'img': img})
					} else {
						for(var il = 0; request[i]['img'].length > il; il++) {
							img = request[i]['img'][il];

							obj.push({'id': id, 'img': img});
							console.log({'id': id, 'img': img})
						}
					}
				}
			}

			if(Object.keys(obj).length != 0) {
				console.log(request);
				this.addImgLoad(obj, Object.keys(obj).length - 1);
			}
		}
	}
});
