@extends('site.layouts.default')

@section('content')
	@php($path = '/images/files/big/')
	@php($img = $page['file'] ? $page['crop'] ? $path . $page['crop'] : $path . $page['file'] : '')

	<section class="simple-page--bg">
		<div class="intro-figure dynamic">
			<figure style="background-image: url('{{ $img }}')"></figure>
		</div>

		<div class="content content_md">
			<header class="light-style">
				<h1 class="headline_main">{{ $langSt($page['name']) }}</h1>

				<div class="article-data">
					@if($page['date'])
						@php($date = explode('-', $page['date']))
					@else
						@php($date = explode('-', $page['created_at']))
					@endif
					<time>{{ (int) $date['2'] . ' ' . $mount($date['1']) . ' ' . $date['0'] }}</time>

					@if($langSt($page['author']))
						<span class="auth">@lang('main.author'): {{ $langSt($page['author']) }}</span>
					@endif
				</div>
			</header>
		</div>
	</section>

	<div class="simple-page--main">
		<div class="content content_sm">
			<div class="location-text text-box">
				{!! $langSt($page['text']) !!}
			</div>
		</div>
	</div>
@endsection