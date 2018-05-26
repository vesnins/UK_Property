@extends('admin::layouts.default')
@section('title', trans('admin::main.namePanel') . ' ' . $version . ' - ' . trans('admin::main.system'))
@section('content')

	@include('admin::layouts.left-menu')
	@include('admin::layouts.top-menu')
	<div class="right_col" role="main">
		<br/>

		<div class="row">
			<div class="col-md-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2>{{ trans('admin::main.system') }}</h2>

						<ul class="nav navbar-right panel_toolbox">
							<li>
								<label class="switch">
									<input
										type="checkbox"
										{!! $send_notifications['active'] ? 'checked="checked"' : '' !!}
										id="send-notifications"
										class="js-switch"
										style="z-index: 101"
									/>

									@lang('admin::main.send_notifications')
								</label>
							</li>
						</ul>

						<hr class="clear"/>
					</div>
				</div>
			</div>

			<div class="col-md-8 col-sm-8 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2></h2>
						<div class="clearfix"></div>
					</div>

					<div class="x_content" >
					</div>
				</div>
			</div>

			<div class="col-md-4 col-sm-4 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2>@lang('admin::main.action_log')</h2>
						<div class="clearfix"></div>
					</div>

					<div class="x_content" >
						<div class="dashboard-widget-content scroll-view scroll-view100" >
							<ul class="list-unstyled timeline widget">
								@foreach($actions_log as $values)
									<li>
										<div class="block">
											<div class="block_content">
												<h2 class="title">
													{{ (json_decode($values['table_tow_name'], true)[App::getLocale()]
													 ?? $values['table_tow_name'])
													 ?? $values['name'] }}
												</h2>

												<div class="byline">
													<span>{{ $values['created_at'] ?? $values['updated_at'] }}</span>
													by

													<a href="/admin/update/users/{{ $values['users_id'] }}">
														{{ $langSt($values['users_name']) }}
													</a>
												</div>

												<p class="excerpt">
													@lang('admin::main.action'): {{ $type_actions[$values['type_actions']] }}
												</p>

												@foreach($lang_s as $v)
													@foreach(json_decode($values['text'], true)['a'] as $kk => $vv)
														@if(!empty(trim($vv[$v['name']] ?? '')))
															<b>{{ $kk }} :</b>
															{!! '<pre class="excerpt">' .trim($vv[$v['name']] ?? '') . '</pre>' !!}
														@endif
													@endforeach
												@endforeach

												@foreach($lang_s as $v)
													@foreach(json_decode($values['text'], true)['b'] as $kk => $vv)
														@if(!empty(trim($vv[$v['name']] ?? '')))
															<b>{{ $kk }} :</b>
															{!! '<pre class="excerpt">' .trim($vv[$v['name']] ?? '') . '</pre>' !!}
														@endif
													@endforeach
												@endforeach

												@if($values['table_name'] && $values['table_row_id'])
													<a href="/admin/update/{{ $values['table_name'] }}/{{ $values['table_row_id'] }}">
														@lang('admin::main.more')
													</a>
												@endif
											</div>
										</div>
									</li>
								@endforeach
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	@push('footer')
	<script>
		$('#send-notifications').click(function() {
			var
				ch = false;

			if($('#send-notifications').prop('checked'))
				ch = true;

			$.ajax({
				type    : "post",
				url     : "/admin/_tools/change_param",
				data    : {active: ch, name: 'send_notifications', table: 'params'},
				cache   : false,
				dataType: "JSON",

				success: function(data) {
					if(data.result === 'ok') {
						if(_.isFunction(callback))
							callback();
					}
				}
			});
		})
	</script>
	@endpush
@stop
