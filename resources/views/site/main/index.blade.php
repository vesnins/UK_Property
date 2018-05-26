@extends('site.layouts.default')

@section('content')
	<div class="section intro">
		<div class="intro-figure">
			@php($path = '/images/files/big/')
			@php($path_small = '/images/files/small/')
			@php($img_big = $main_page['file'] ? $main_page['crop'] ? $path . $main_page['crop'] : $path . $main_page['file'] : '')
			@php($img_small = $img_mobile['file'] ? $img_mobile['crop'] ? $path_small . $img_mobile['crop'] : $path_small . $img_mobile['file'] : '')
			<figure class="mobile" style="background-image: url({{ $img_small }})"></figure>
			<figure class="" style="background-image: url({{ $img_big }})"></figure>

			<video muted autoplay loop>
				@foreach($main_page_video as $video)
					<source src="/images/files/files/{{ $video['file'] }}" type="video/{{ explode('.', $video['file'])[count(explode('.', $video['file'])) - 1] }}">
				@endforeach
			</video>
		</div>

		<div class="intro--main">
			@include('site.block.main_filter')
		</div>

		<div class="intro-values">
			<div class="content content_mx">
				<div class="intro-text">{{ $langSt($params['main_div_bout_us']['key']) }}</div>

				<span class="scroll-down">
					<svg xmlns="http://www.w3.org/2000/svg" width="137" height="137" viewBox="0 0 13700 13700" shape-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd">
						<circle cx="6850" cy="6850" r="6683" fill="none" stroke="#fff" stroke-width="334"/>
						<path d="m4799 6179c-130-130-130-343 0-473 131-130 343-130 473 0l1578 1578 1578-1578c130-130 342-130 473 0 130 130 130 343 0 473l-1815 1814c-130 131-342 131-472 0l-1815-1814" fill="#fff" fill-rule="nonzero"/>
					</svg>
				</span>
			</div>
		</div>
	</div>
	<div class="section offers">
		<div class="content">
			<header>
				<h2 class="headline_main">@lang('main.get_inspired')</h2>
				<h4 class="headline_submain">{{ $langSt($params['browse_Collections_h3']['key']) }}</h4>
			</header>

			@php($i = 4)

			<div class="offers--wrap">
				<div class="offers--grid">
					<div class="item-box item-lg head-top" data-item="1">
						<section class="item">
							<a href="/villas?villas_by_the_sea=1">
								@php($path_big = '/images/files/big/')
								@php($img_big = '')

								@if(isset($collections[0]['file']))
									@php($c = $collections[0])
									@php($img_big = $c['file'] ? $c['crop'] ? $path_big . $c['crop'] : $path_big . $c['file'] : '')
								@endif
								<figure style="background-image: url({{ $img_big  }})"></figure>

								<header>
									<h3 class="title">{{ $langSt($collections[0]['name'] ?? '') }}</h3>
									<h5 class="subtitle">{{ $langSt($collections[0]['text'] ?? '') }}</h5>
									<span class="btn btn_bord">@lang('main.look')</span>
								</header>
							</a>
						</section>
					</div>

					<div class="item-box item-md head-top" data-item="2">
						<section class="item">
							<a href="/villas?villas_with_private_service=1">
								@php($path_big = '/images/files/big/')
								@php($img_big = '')

								@if(isset($collections[1]['file']))
									@php($c = $collections[1])
									@php($img_big = $c['file'] ? $c['crop'] ? $path_big . $c['crop'] : $path_big . $c['file'] : '')
								@endif
								<figure style="background-image: url({{ $img_big  }})"></figure>

								<header>
									<h3 class="title">{{ $langSt($collections[1]['name'] ?? '') }}</h3>
									<h5 class="subtitle">{{ $langSt($collections[1]['text'] ?? '') }}</h5>
									<span class="btn btn_bord">@lang('main.look')</span>
								</header>
							</a>
						</section>
					</div>

					<div class="item-box item-lg head-top" data-item="3">
						<section class="item">
							<a href="/villas?vacation_together=1">
								@php($path_big = '/images/files/big/')
								@php($img_big = '')

								@if(isset($collections[2]['file']))
									@php($c = $collections[2])
									@php($img_big = $c['file'] ? $c['crop'] ? $path_big . $c['crop'] : $path_big . $c['file'] : '')
								@endif
								<figure style="background-image: url({{ $img_big  }})"></figure>

								<header>
									<h3 class="title">{{ $langSt($collections[2]['name'] ?? '') }}</h3>
									<h5 class="subtitle">{{ $langSt($collections[2]['text'] ?? '') }}</h5>
									<span class="btn btn_bord">@lang('main.look')</span>
								</header>
							</a>
						</section>
					</div>

					@foreach($locations_main as $v)
						@php($path_small = '/images/files/small/')
						@php($img_small = $v['file'] ? $v['crop'] ? $path_small . $v['crop'] : $path_small . $v['file'] : '')

						<div class="item-box item-sm head-full" data-item="{{ $i }}">
							<section class="item">
								<a href="/location/{{ empty($v['translation']) ? $v['cat'] : $v['translation'] }}">
									<figure style="background-image: url('{{ $img_small }}')"></figure>
									<header>
										<h3 class="title">{{ $langSt($v['name']) }}</h3>
									</header>
								</a>
							</section>
						</div>

						@php(++$i)
					@endforeach
				</div>
			</div>
		</div>
	</div>

	<section class="section best-offers">
		<div class="content">
			<header>
				<h3 class="headline_main">@lang('main.our_best_offers')</h3>
				<h4 class="headline_submain">{{ $langSt($params['our_best_offers_main_h3']['key']) }}</h4>
			</header>

			<div class="grid">
				@include('site.block.villas_main_list_grid')

				<div class="btns_center">
					<a href="/villas" class="more">@lang('main.more_offers')</a>
				</div>
			</div>
		</div>
	</section>

	<section class="section blog-section">
		<div class="content">
			<header>
				<h3 class="headline_main">@lang('main.blog')</h3>
				<h4 class="headline_submain">{{ $langSt($params['blog_main_h3']['key']) }}</h4>
			</header>
		</div>
		<div class="blog-box">
			<div class="content">
				<div class="blog-box--wrap">
					@include('site.block.blog_main_list')

					<div class="btns_center">
						<a href="/blog" class="more">@lang('main.more_articles')</a>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection
