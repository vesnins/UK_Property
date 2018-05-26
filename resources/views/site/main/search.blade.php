@extends('site.layouts.default')

@section('content')
	<section class="simple-page--head results--head" style="background-image: url('/images/bg/account-bg.jpeg')">
		<div class="content">
			<header class="light-style">
				<h1 class="headline_main">@lang('main.search')</h1>
			</header>
		</div>
	</section>
	<div class="results search-results">
		<div class="content">
			<div class="results-box inside-mob">
				<div class="content content_sm">
					<ul class="results-list">
						@foreach($search as $key => $v)
							@php($u = ['str' => '/blog/', 'str_p' => '/pages/', 'villas' => '/villas/'])

							<li>
								<a href="{{ $u[$v->name_table] }}{{ $v->id }}">
									<h3 class="title">{{ $page * ($key + 1) . '. ' }}{{ $langSt($v->name) }}</h3>
									
									<p style="color: #3c3c3c;">
										{!! mb_substr(htmlspecialchars(strip_tags($langSt($v->text))), 0, 300, 'UTF-8') !!}
									</p>
								</a>
							</li>
						@endforeach
					</ul>

					@if(round($count / $limit) > 1)
						<div class="paging_center">
							<div class="paging-list">
								@foreach(range($page - 1, $page + 1) as $key => $v)
									@if($key === 0 && $v)
										<a href="/search/{{ $v }}?q={{ $q }}" class="page-one prev">
											<svg>
												<use xmlns:xlink="http://www.w3.org/1999/xlink"
														 xlink:href="/images/svg/sprite.svg#ico_page-prev"></use>
											</svg>
										</a>

										<a href="/search/{{ $v }}?q={{ $q }}" class="page-one">{{ $v }}</a>
									@endif

									@if($key === 1)
										<a href="/search/{{ $v }}?q={{ $q }}" class="page-one current">{{ $v }}</a>
									@endif

									@if($key === 2 && $v < round($count / $limit))
										<a href="/search/{{ $v }}?q={{ $q }}" class="page-one">{{ $v }}</a>

										<a href="/search/{{ $v }}?q={{ $q }}" class="page-one next">
											<svg>
												<use xmlns:xlink="http://www.w3.org/1999/xlink"
														 xlink:href="/images/svg/sprite.svg#ico_page-next"></use>
											</svg>
										</a>
									@endif
								@endforeach
							</div>

							<span class="total">@lang('main._from') {{ round($count / $limit) }}</span>
						</div>
					@endif
				</div>
			</div>
		</div>
	</div>
@endsection