@push('footer')
<script src="{{ asset('/modules/js/upl_mul/jquery.uploadifive.min.js') }}" type="text/javascript"></script>
@endpush

<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">
		@lang('admin::plugins.' . ($plugin['translateKey'] ?? 'files'))
	</label>

	<div class="col-md-6 col-sm-6 col-xs-12">
		<div class="panel-group" id="accordion{{ $name }}" role="tablist" aria-multiselectable="true">
			<div class="panel panel-default" style="border-radius: 0; border: 1px solid hsl(0, 0%, 80%);">
				<div class="panel-heading" role="tab" id="headingOne{{ $name }}" style="padding:0">
					<h4 class="panel-title">
						<div style="padding: 10px 15px" role="button" data-toggle="collapse" data-parent="#accordion{{ $name }}"
							href="#collapseOne{{ $name }}" aria-expanded="true" aria-controls="collapseOne{{ $name }}"></div>
					</h4>
				</div>
				<div id="collapseOne{{ $name }}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne{{ $name }}">
					<div class="panel-body">

						@if($id_album != '0')
							@php($id_page = 1)
							<div id="cont-file-upload">
								@if($limit > count($files) && $limit != -1)
									<input id="file_upload{{ $name }}" name="file_upload" type="file" multiple="multiple">
								@endif
							</div>

							{{--<form name="" id="imag_main_form">--}}
							<div id="queue{{ $name }}" class="alert queue"></div>
							<div class="response_suss" id="response_suss{{ $name }}">
								@foreach($files as $v)
									<div class="col-md-4 rowID{{ $name }}-{{ $v->id }}">
										<div class="thumbnail">
											<div class="image view view-first pointer" onclick="editFile{{ $name }}({{ $v->id }})">
												@php($ext = explode('.', $v->file)[count(explode('.', $v->file)) - 1])
												@php($ignore = ['jpg' => 'image', 'jpeg' => 'image', 'png' => 'image', 'webm' => 'video', 'mp4' => 'video'])

												@if(isset($ignore[$ext]))
													@php($ext = $ignore[$ext])
												@endif

												<i
													style="font-size: 120px; padding: 5px;"
													class="fas fa-file-{{ $ext }}"
												></i>
											</div>
											<div class="caption" style="padding-bottom: 0">
												<div class="tools tools-bottom" style="text-align: center">
													<a
														href="javascript:void(0)"
														class="btn"
														title="Редактировать"
														onclick="editFile{{ $name }}({{ $v->id }})"
													>
														<i class="fa fa-pencil"></i>
													</a>

													<a
														href="javascript:void(0)"
														class="btn"
														title="Удалить"
														onclick="$.adm.rowDelete('{{ $v->id }}', '\'files\'', '', '{{ $name }}', callDel)"
													>
														<i class="fa fa-times"></i>
													</a>

													<a
														href="javascript:void(0)"
														class="btn"
														title="Сделать главной"
														onclick="toMain{{ $name }}({{ $v->id }})"
													>
														<i
															class="toMain{{ $name }} toMain{{ $name }}{{ $v->id }} glyphicon @if($v->main) glyphicon-check @else glyphicon-unchecked @endif"></i>
													</a>
												</div>
											</div>
										</div>
									</div>
								@endforeach
							</div>

							<input type="hidden" id="vt_i" name="fo[o][id_img]" value="0"/>
							<input type="hidden" id="vt_i" name="fo[id_album]" value="{{ $id_page }}"/>

							@php($timestamp = time())
							<script type="text/javascript">
								function callDel() {
									if(parseInt('{{ $limit }}') > $('#response_suss{{ $name }}').children().length) {
										$('#cont-file-upload').html(
											'<input id="file_upload{{ $name }}" name="file_upload" type="file" multiple="multiple">'
										);

										fileUpload();
									}
								};

								var typeFile = [
									'application/pdf',
									'video/webm',
									'video/mp4',
									'application/msword',
									'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
									'image/jpg',
									'image/png',
									'image/jpeg',
									'image/JPG',
									'image/PNG',
									'image/JPEG'
								];

								var
									fileUpload = function() {
										$('#file_upload{{ $name }}').uploadifive({
											'formData': {
												'timestamp': '{{ $timestamp }}',
												'token': '{{ md5('file_upload' . $timestamp) }}',
												'id_album': '{{ $id_album }}',
												'name_table': '{{ $name_table }}',
												'name_field': '{{ $name }}'
											},

											'debug': true,
											'queueID': 'queue{{ $name }}',
											'buttonText': '@lang('admin::main.selectFiles')',
											'buttonClass': 'btn btn-primary imag_bat',
											'width': 350,
											'height': 40,
											'lineHeight': '20px',
											'fileType': typeFile,
											'fileDesc': 'All supported files types (.pdf, .jpeg)',
											'uploadScript': '/admin/files/upload_files?name_table={{ $name_table }}&name_field={{ $name }}&id_album={{ $id_album }}&timestamp={{ $timestamp }}&token={{ md5('file_upload' . $timestamp) }}',
											'onProgress': 'total',
											'fileSizeLimit': '10048KB',

											'onUploadComplete': function(file, data) {
												var
													ds = JSON.parse(data),
													ext = ds['name'].toString().split('.'),
													ignore = {jpg: 'image', jpeg: 'image', png: 'image', webm: 'video', mp4: 'video'};

												ext =  ext[ext.length - 1];

												if(ignore[ext])
													ext = ignore[ext];

												var file = '<div class="col-md-4 rowID{{ $name }}-' + ds['id'] + '">' +
													'<div class="thumbnail">' +
													'<div class="image view view-first pointer" onclick="editFile{{ $name }}(\' + ds[\'id\'] + \')">' +
													'<i style="font-size: 120px; padding: 5px;" class="fas fa-file-' + ext + '"></i>' +
													'</div>' +
													'<div class="caption" style="padding-bottom: 0">' +
													'<div class="tools tools-bottom" style="text-align: center">' +
													'<a href="javascript:void(0)" onclick="editFile{{ $name }}(' + ds['id'] + ')" class="btn"><i class="fa fa-pencil"></i></a>' +
													'<a href="javascript:void(0)" onclick="$.adm.rowDelete(' + ds['id'] + ', \'files\', \'\' ,\'{{ $name }}\')" class="btn"><i class="fa fa-times"></i></a>' +
													'<a href="javascript:void(0)" class="btn" onclick="toMain{{ $name }}(' + ds['id'] + ')">';

												if(ds['main'] == 1) {
													file += '<i class="toMain{{ $name }} toMain{{ $name }}' + ds['id'] + ' glyphicon glyphicon-check"></i>';
												} else {
													file += '<i class="toMain{{ $name }} toMain{{ $name }}' + ds['id'] + ' glyphicon glyphicon-unchecked"></i>';
												}

												file += '</a>' +
													'</div>' +
													'</div>' +
													'</div>' +
													'</div>';

												$('#response_suss{{ $name }}').append(file);
												$("#vt_a{{ $name }}").show(100);

												if(parseInt('{{ $limit }}') <= $('#response_suss{{ $name }}').children().length && '{!! $limit !!}' != '-1') {
													$('#file_upload{{ $name }}').uploadifive('destroy');
													setTimeout(function() { $('#file_upload{{ $name }}').remove(); }, 0)
												}
											}
										});
									};

								function editFile{{ $name }}(id) {
									$.ajax
									 ({
										 type: "POST",
										 url: "/admin/files/get_edit_file",
										 dataType: 'html',
										 data: {
											 id: id,
											 nameId: '{{ $name }}'
										 },
										 cache: false,
										 success: function(html) {
											 $('.alb-modal{{ $name }} > div > div > div > .modal-title').html('Редактировать описание');
											 $('.modal-lgAl{{ $name }}').css({width: '600px'});
											 $('#alb-modal{{ $name }}').modal('show');
											 $('.bodyModal{{ $name }}').html(html);

											 setTimeout(function() {
												 $('.btnsav{{ $name }}').attr('data-id', '' + id + '')
											 }, 300);
										 }
									 });
								}

								function sendEditFile{{ $name }}(id) {
									$.ajax
									 ({
										 type: "POST",
										 url: "/admin/files/get_edit_file",
										 dataType: 'json',

										 data: {
											 id: id,
											 form: $('[name="edit-form-file"]').serializeArray(),
											 save: true,
											 nameId: '{{ $name }}'
										 },

										 cache: false,
										 success: function(data) { $('#alb-modal{{ $name }}').modal('hide'); }
									 });
								}

								function toMain{{ $name }}(id) {
									$.ajax
									 ({
										 type: "POST",
										 url: "/admin/files/to_main",
										 dataType: 'json',
										 data: {
											 id: id,
											 nameId: '{{ $name }}'
										 },
										 cache: false,
										 success: function(html) {
											 if(html.result == 'ok') {
												 $('.toMain{{ $name }}').removeClass('glyphicon-check');
												 $('.toMain{{ $name }}').addClass('glyphicon-unchecked');

												 $('.toMain{{ $name }}' + id).addClass('glyphicon-check');
												 $('.toMain{{ $name }}' + id).removeClass('glyphicon-unchecked');
											 }
										 }
									 });
								}


								$(document).ready(function() {
									fileUpload();
								});
							</script>

							<br/>
							<span id="status{{ $name }}"></span>
							<ul id="files{{ $name }}"></ul>

							<div id="form_ij" style="width: 500px; margin: 0 auto;">
								<div id="form_ij_img" style="margin-bottom: 10px;text-align: center"></div>
								<!--/ получившийся рисунок /-->
								<div id="form_ij_for"></div>
								<!--/ форма для комментов /-->
							</div>

							<div class="row" id="row_crop">
								<div class="span12">
									<div class="jc-demo-box_e">
										<div class="jc-demo-box">
										</div>
									</div>
								</div>
							</div>

							<div class="error_s"></div>
							<div class="error_ok"></div>
							<div class="result_img" id="result_img"></div>
							<div class="crop_img" id="crop_img"></div>

							<div class="img"></div>

						@else
							<button class="btn btn-primary" formaction="/admin/update/{{ $name_table }}/{{ $id_album }}/1" type="submit">
								@lang('admin::main.enableFile')
							</button>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@push('footer')
<div class="modal fade" tabindex="-1" id="alb-modal{{ $name }}" role="dialog">
	<div class="modal-dialog modal-lg modal-lgAl{{ $name }}">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="bodyModal{{ $name }}"></div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endpush
