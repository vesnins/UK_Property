@extends('site.layouts.default')

@section('content')
	@php($path = '/images/files/small/')

	@php($img_author = $blog['users_file']
		? $blog['users_crop'] ? $path . $blog['users_crop'] : $path . $blog['users_file']
		: env('PATH_TO_IMG_DEFAULT')
	)

	<main class="main">
		<section class="indent-block">
			<div class="container">
				<div class="entry-holder">
					<h2>{{ $langSt($blog['name']) }}</h2>

					<div class="author-box">
						<div class="photo">
							<div style="background: url('{{ $img_author }}') 50%/125px; width: 100%; height: 100%"></div>
						</div>

						<div class="ovh-box">
							<span class="author-name">{{ $langSt($blog['author_name']) ?? $langSt($blog['author']) }}</span>

							@if($blog['date'])
								@php($date = explode('/', $blog['date']))
							@else
								@php($date = explode('-', $blog['created_at']))
							@endif

							<time datetime="{{ $blog['date'] }}">
								{{ $date['0'] . '-' . $date['1'] . '-' . $date['2'] }}
							</time>
						</div>
					</div>

					<div class="entry-content">{!! $langSt($blog['text']) !!}</div>
				</div>

				<footer class="entry-footer">
					<div class="row flex-row align-row">
						<div class="col-xs-5">
							<a href="/blog" class="back-btn">
								<svg><use xlink:href="/images/svg/sprite.svg#long-arrow-left"></use></svg>
								@lang('main.back_to_blog')
							</a>
						</div>

						<div class="col-xs-7 text-right">
							<ul class="social-list">
								<li>@lang('main.share'):</li>
								<li><a href="#">
										<svg><use xlink:href="/images/svg/sprite.svg#facebook"></use></svg>
										<span class="qty">123</span></a>
								</li>

								<li><a href="#">
										<svg><use xlink:href="/images/svg/sprite.svg#linkedin"></use></svg>
										<span class="qty">95</span></a>
								</li>
							</ul>
						</div>
					</div>
				</footer>
			</div>
		</section>

		<section class="indent-block related-articles-section">
			<div class="container-fluid">
				<h3 class="text-center">@lang('main.similar_article')</h3>

				<div class="article-slider simple-slider">
					@include('site.block.blog_id_footer', ['blogs' => $blogs])
				</div>
			</div>
		</section>
	</main>
@endsection