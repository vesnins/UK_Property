@extends('admin::layouts.default')

@section('title', trans('admin::main.namePanel') . ' ' . $version . ' - ' . ($modules['translate_key'] ?? ''
 ? trans('admin::main.' . $modules['translate_key'])
 : $modules['name_module'])
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
						</h2>

						<div class="nav navbar-right panel_toolbox">
							@if($right['w'] && !empty($modules['main_page'] ?? []))
								<a href="/admin/update/{{ $modules['link_module'] }}/main_page" class="btn btn-warning">
									@lang('admin::main.edit_main_page')
								</a>
							@endif

							@if($right['w'])
								<a href="/admin/update/{{ $modules['link_module'] }}" class="btn btn-primary">
									@lang('admin::main.create')
								</a>
							@endif
						</div>
						<div class="clearfix"></div>
						<hr class="clear"/>

						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon">@lang('admin::main.selectActions'): </span>

								<select onchange="$.adm.makeD(this.value)" id="select1" class="form-control select" autocomplete="off">
									<option value="0" id="defo">@lang('admin::main.selectActions')</option>
									<option value="edit">@lang('admin::main.edit')</option>
									<option value="delete">@lang('admin::main.remove')</option>
									<option value="copy">@lang('admin::main.copy')</option>
								</select>
							</div>

							<div class="error"></div>
							<div class="sass"></div>
							<input type="hidden" name="id_mt" class="id_mt"/>
						</div>

						@if($modules['views_module'] == 'wood')
							@include('admin::module/index_wood')
						@else
							@include('admin::module/index_table')
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="{{ asset('/modules/js/adm.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/modules/js/modules.js') }}"></script>
	<script>
		$(document).ready(function() {
			modules.initialize({});

			$.adm.initialize({
				pram: [
					['elementsLoad', true],
					['link_module', '{{ $modules['link_module'] }}']
				]
			});
		});
	</script>
@stop