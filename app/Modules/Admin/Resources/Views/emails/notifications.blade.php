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

										<a href="{{ env('APP_URL') }}/admin/update/users/{{ $values['users_id'] }}">
											{{ $langSt($values['users_name']) }}
										</a>
									</div>

									<p class="excerpt">
										@lang('admin::main.action'): @lang('admin::main.' . $values['type_actions'])
									</p>

									@foreach($lang_s as $v)
										@foreach(json_decode($values['text'], true)['a'] as $kk => $vv)
											@if($vv[$v['name']] ?? false)
												<b>@lang('admin::plugins.' . $plugins[$kk]['translateKey'] ?? $kk) :</b>
												{!! '<pre class="excerpt">' .trim($vv[$v['name']] ?? '') . '</pre>' !!}
											@endif
										@endforeach
									@endforeach

									@foreach($lang_s as $v)
										@foreach(json_decode($values['text'], true)['b'] as $kk => $vv)
											@if($vv[$v['name']] ?? false)
												<b>@lang('admin::plugins.' . $plugins[$kk]['translateKey'] ?? $kk) :</b>
												{!! '<pre class="excerpt">' .trim($vv[$v['name']] ?? '') . '</pre>' !!}
											@endif
										@endforeach
									@endforeach

									@if($values['table_name'] && $values['table_row_id'])
										<a href="{{ env('APP_URL') }}/admin/update/{{ $values['table_name'] }}/{{ $values['table_row_id'] }}">
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