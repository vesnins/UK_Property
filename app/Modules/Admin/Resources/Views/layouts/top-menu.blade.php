<!-- top navigation -->
<div class="top_nav">

	<div class="nav_menu">
		<nav class="" role="navigation">
			<div class="nav toggle">
				<a id="menu_toggle" style="cursor: pointer"><i class="fa fa-bars"></i></a>
			</div>
			<span style="line-height: 55px">@lang('admin::main.namePanel') {{ $version }}</span>
			<ul class="nav navbar-nav navbar-right">
				<li>
					<a href="/" target="_blank">
						<i class="fa fa-external-link"></i>
						@lang('admin::main.openSite')
					</a>
				</li>
				<li class="">
					<a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
						 aria-expanded="false">
						<img src="/modules/images/user.png" alt="">
						@if (!empty(\App\Modules\Admin\Classes\Base::$user))
							{{ $langSt(\App\Modules\Admin\Classes\Base::$user->name) }}
						@else
							@lang('admin::main.administrator')
						@endif
						<span class=" fa fa-angle-down"></span>
					</a>
					<ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
						<li>
							<a href="/admin/update/users/{{ \App\Modules\Admin\Classes\Base::$user->id }}">
								@lang('admin::main.profile')
							</a>
						</li>

						<li><a href="/admin/docs">@lang('admin::main.help')</a></li>

						<li>
							<a href="/admin/logout">
								<i class="fa fa-sign-out pull-right"></i>
								@lang('admin::main.exit')
							</a>
						</li>
					</ul>
				</li>

				<li>
					<a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						@lang("admin::main.$lang")
						<span class=" fa fa-angle-down"></span>
					</a>
					<ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right" style="min-width: auto">
						<li>
							<a href="?setLang=ru">@lang('admin::main.ru')</a>
						</li>
						<li>
							<a href="?setLang=en">@lang('admin::main.en')</a>
						</li>
					</ul>
				</li>
			</ul>
		</nav>
	</div>

</div>
<!-- /top navigation -->