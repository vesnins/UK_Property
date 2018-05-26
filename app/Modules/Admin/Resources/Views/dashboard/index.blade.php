@extends('admin::layouts.default')
@section('title', trans('admin::main.namePanel') . ' ' . $version)
@section('content')

	@include('admin::layouts.left-menu')
	@include('admin::layouts.top-menu')
	<div class="right_col" role="main">
		<br/>

		<div class="row">
			@foreach($menu as $val)
				@if(isset($val['r']))
					@if($val['r'])
						@php($m = explode('=>', $val['name_module']))

						@if(!isset($m[1]))
							<a href="/admin/index/{{ $val['link_module'] }}">
								<div class="animated flipInY col-lg-3 col-md-4 col-sm-6 col-xs-12">
									<div class="tile-stats">
										<div class="icon"><i class="{{ $val['class_module'] }}"></i>
										</div>
										<div class="count">
											{{ trans('admin::main.' . $val['translate_key']) ?? $val['name_module'] }}
										</div>

										<h3>&nbsp;
											@if($data[$val['id']])
												{{ $data[$val['id']] }} @lang('admin::main._records')
											@endif
										</h3>
									</div>
								</div>
							</a>
						@endif
					@endif
				@endif
			@endforeach
		</div>
	</div>
@stop