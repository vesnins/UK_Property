<div class="col-md-3 left_col">
	<div class="left_col scroll-view">
		<div class="navbar nav_title" style="border: 0;">
			<a href="/admin/" class="site_title" style="text-align: left">
				<img style="max-width: 205px;" src="/images/svg/logo-green.svg" alt="GrecoBooking" />
			</a>
		</div>
		<div class="clearfix"></div>

		<!-- sidebar menu -->
		<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

			<div class="menu_section">
				<ul class="nav side-menu">
					<li>
						<a href="/admin"><i class="fa fa-desktop"></i> @lang('admin::main.desktop')</a>
					</li>
					{{--<li>--}}
					{{--<a href="/admin/engineer"><i class="fa fa-wrench"></i> Engineer </a>--}}
					{{--</li>--}}
					@foreach($left_menu as $val)
						@if($val['r'] ?? 0)
							@if(isset($val['m']))
								<li>
									<a>
										<i class="fa fa-cubes"></i>
										{{ $val['translate_key'] ? trans('admin::main.' . $val['translate_key']) : $val['name_module'] }}
										<span class="fa fa-chevron-down"></span>
									</a>

									<ul class="nav child_menu">
										<li {!! $segment3 == $val['link_module'] ? 'class="current-page"' : '' !!}>
											<a href="/admin/index/{{ $val['link_module'] }}">
												<i class="{{ $val['class_module'] }}"></i>
												{{ $val['translate_key'] ? trans('admin::main.' . $val['translate_key']) : $val['name_module'] }}
											</a>
										</li>

										@foreach($val['m'] as $v)
											<li {!! $segment3 == $v['link_module'] ? 'class="current-page"' : '' !!}>
												<a href="/admin/index/{{ $v['link_module'] }}">
													<i class="{{ $v['class_module'] }}"></i>
													{{ $v['translate_key'] ? trans('admin::main.' . $v['translate_key']) : $v['name_module'] }}
												</a>
											</li>
										@endforeach
									</ul>
								</li>
							@else
								<li {!! $segment3 == $val['link_module'] ? 'class="current-page"' : '' !!}>
									<a href="/admin/index/{{ $val['link_module'] }}">
										<i class="{{ $val['class_module'] }}"></i>
										{{ $val['translate_key'] ? trans('admin::main.' . $val['translate_key']) : $val['name_module'] }}
									</a>
								</li>
							@endif
						@endif
					@endforeach
				</ul>
			</div>
		</div>
	</div>
</div>