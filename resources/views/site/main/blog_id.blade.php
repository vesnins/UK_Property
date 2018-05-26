@extends('site.layouts.default')

@section('content')
	@php($path = '/images/files/small/')
	@php($img = $blog['file'] ? $blog['crop'] ? $path . $blog['crop'] : $path . $blog['file'] : '')

	<section class="simple-page--bg">
		<div class="intro-figure dynamic">
			<figure style="@if($img)background-image: url({{ $img }})@endif"></figure>
		</div>

		<div class="content content_md">
			<header class="light-style">
				<h1 class="headline_main">{{ $langSt($blog['name']) }}</h1>

				<div class="article-data">
					@if($blog['date'])
						@php($date = explode('-', $blog['date']))
					@else
						@php($date = explode('-', $blog['created_at']))
					@endif
					<time>{{ (int) $date['2'] . ' ' . $mount($date['1']) . ' ' . $date['0'] }}</time>

					@if($langSt($blog['author']))
						<span class="auth">@lang('main.author'): {{ $langSt($blog['author']) }}</span>
					@endif
				</div>
			</header>
		</div>
	</section>

	<div class="simple-page--main">
		<div class="content content_sm"><div class="location-text text-box">{!! $langSt($blog['text']) !!}</div></div>
	</div>

	@push('bottom')
	<div class="blog-box">
		<div class="content">
			<div class="blog-box--wrap">
				<ul class="layout layout_sm">
					@include('site.block.related-articles')
				</ul>
			</div>
		</div>
	</div>
	@endpush
@endsection