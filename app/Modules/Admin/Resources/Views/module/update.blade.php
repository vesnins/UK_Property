@extends('admin::layouts.default')

@section('title', trans('admin::main.namePanel') . ' ' . $version . ' - ' . (isset($data['name'])
	? trans('admin::main.editing') . ' - ' . json_decode($data['name'], true)[App::getLocale()] ?? $data['name']
	: trans('admin::main.creating'))
)

@section('content')

	@include('admin::layouts.left-menu')
	@include('admin::layouts.top-menu')
	<div class="right_col" role="main">
		<br/>

		<div class="row">
			<div class="col-md-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2>
							{{ $modules['translate_key'] ?? '' ? trans('admin::main.' . $modules['translate_key']) : $modules['name_module'] }}

							@if(empty($data))
								<small>@lang('admin::main.creating')</small>
							@else
								<small>@lang('admin::main.editing')</small>
							@endif
						</h2>
						<hr class="clear"/>

						<form method="post" class="form-modules form-horizontal form-label-left">
							<div class="" role="tabpanel" data-example-id="togglable-tabs">
								<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
									@foreach($plugins_tabs as $key => $v)

										<li role="presentation" class="{!! $key == 'basic' ? 'active' : '' !!}">
											<a
												href="#url-{{ $key }}-tab"
												id="{{ $key }}-tab"
												role="tab"
												data-toggle="tab"
												aria-expanded="{!! $key == 'basic' ? 'true' : 'false' !!}"
											>
												@lang('admin::main.' . $key)
											</a>
										</li>
									@endforeach

									@if($show_lang)
										@foreach($lang_array as $key => $val)
											<li role="presentation" class="">
												<a
													href="#url-{{ $key }}-tab"
													id="{{ $key }}-tab"
													role="tab"
													data-toggle="tab"
													aria-expanded="false"
												>
													{{ $val['name'] }}
												</a>
											</li>
										@endforeach
									@endif
								</ul>

								<div id="myTabContent" class="tab-content">
									@foreach($plugins_tabs as $key => $v)
										<div
											role="tabpanel"
											class="tab-pane fade {!! $key == 'basic' ? 'active in' : '' !!}"
											id="url-{{ $key }}-tab"
											aria-labelledby="{{ $key }}-tab"
										>
											@foreach($v as $key => $val)
												{!! $val['html_top'] !!}
												{!! str_replace('-]-options-[-', '', str_replace('--options--', '', $val['html'])) !!}
												{!! $val['html_bottom'] !!}
											@endforeach
										</div>
									@endforeach

									@if($show_lang)
										@foreach($lang_array as $key => $val)
											<div
												role="tabpanel"
												class="tab-pane fade"
												id="url-{{ $key }}-tab"
												aria-labelledby="{{ $key }}-tab"
											>
												<div class="wrapper wrapper-content animated fadeIn">
													@foreach($plugins_lang as $k => $v)
														{!! $v['html_top'] !!}
														{!! str_replace('-]-options-[-', strtolower($val['name']), str_replace('--options--', '[' . strtolower($val['name']) . ']', $v['html'])) !!}
														{!! $v['html_bottom'] !!}
													@endforeach
												</div>
											</div>
										@endforeach
									@endif
								</div>
							</div>

							<div class="text-right">
								<div class="loader"></div>
								<button class="btn btn-success" type="submit">@lang('admin::main.save')</button>

								<button class="btn btn-primary" formaction="/admin/update/{{ $page }}/{{ $id }}/1" type="submit">
									@lang('admin::main.apply')
								</button>

								<button class="btn btn-default" formaction="/admin/index/{{ $page . $url }}" type="submit">
									@lang('admin::main.close')
								</button>
							</div>
						</form>

						@if(!empty($data))
							<script>
								$(document).ready(function() {
									function ucfirst(str) {
										var f = str.charAt(0).toUpperCase();

										return f + str.substr(1, str.length - 1);
									}

									var column, text, typeField;
									var body = {!! json_encode($data) !!};
									var plugins = {!! json_encode($plugins) !!};
									var pluginsLang = {!! json_encode($plugins_lang) !!};

									_.map(pluginsLang, function(v, k) {
										text = _.unescape(body[v.name]);

										try {
											text = JSON.parse(text);
											if(text) {
												$('[name="pl[' + v.name + '][ru]"]').val(_.unescape(text.ru));
												$('[name="pl[' + v.name + '][en]"]').val(_.unescape(text.en));
											}
										} catch(err) {
											// обработка ошибки
											// вставляем текст как он есть в поле которое в последсвии будет преобразовано в
											// json

											$('[name="pl[' + v.name + '][ru]"]').val(text);
											$('[name="pl[' + v.name + '][en]"]').val(text);
										}
									});

									if($('.select2').html())
										$('.select2').select2("destroy");

									_.map(plugins, function(v, k) {
										text = body[k];

										if(v.typeField === 'select' && text) {
											try{
												text = JSON.parse(text);
											} catch(e) {

											}

											$('#select' + ucfirst(k)).val(text || 0).trigger("change");
										} else {
											if(v.typeField === 'functions') {
												$('#' + v.idAttr + 'en').attr('data-init-value', text ? text : 0);
												$('#' + v.idAttr + 'ru').attr('data-init-value', text ? text : 0);
												$('#' + v.idAttr).attr('data-init-value', text ? text : 0);
											} else
												if(v.typeField === 'checkbox') {
													if(text)
														$('[name="pl[' + k + ']"]').iCheck('check');
												} else
													$('[name="pl[' + k + ']"]').val(_.unescape(text));
										}
									});

									if($('.select2').html())
										$(".select2").select2();
								})
							</script>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="{{ asset('/modules/js/modules.js') }}"></script>
	<script type="text/javascript" src="/js/lodash.min.js"></script>
	<script>
		$(window).load(function(){
			if(window.location.hash){
				$('a[href="'+window.location.hash+'"]').trigger('click');
			}
		});

		$(document).on('click', 'a[data-toggle="tab"]', function(){
			window.location.hash = $(this).attr('href');
		});

		$(document).ready(function() {
			modules.initialize({});
		});

		$(window).load(function() {
			var name = '';
				@foreach($js_init_function as $init)
			name = '{{ $init }}';

			if(window[name]) {
				{!! 'window.' . $init . '();'!!}
			}
			@endforeach
			@foreach($plugins_lang ?? [] as $plugins)
			@if($plugins['typeField'] == 'functions')
			@foreach($lang_array ?? [] as $lang)
			name = '{{ $init }}';

			if(window[name]) {
				{!! 'window.' . $plugins['js_init_function'] . $lang['name'] . '(\'  ' . $lang['name'] . ' \');'!!}
			}
			@endforeach
			@endif
			@endforeach
		});
	</script>
@stop
