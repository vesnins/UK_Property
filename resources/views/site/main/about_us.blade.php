@extends('site.layouts.default')

@section('content')
	<section class="simple-page--bg">
		<div class="intro-figure dynamic">
			@php($path = '/images/files/big/')

			@if($page['file'])
				@php($img_big = $page['file'] ? $page['crop'] ? $path . $page['crop'] : $path . $page['file'] : '')
			@else
				@php($img_big = $menu_segment['file'] ? $menu_segment['crop'] ? $path . $menu_segment['crop'] : $path . $menu_segment['file'] : '')
			@endif

			<figure style="background-image: url({{ $img_big }})"></figure>
		</div>

		<div class="content">
			<header class="light-style">
				<h1 class="headline_main">{{ $langSt($page['name']) }}</h1>
			</header>
		</div>
	</section>

	<div class="simple-page--main">
		<div class="content content_mx">
			<div class="location-text text-box">
				{!! $langSt($page['text']) !!}
			</div>
		</div>
		<div class="workers">
			<div class="content">
				<div class="workers-box inside-mob">
					<div class="content content_md">
						@foreach($users as $val)
							@php($path = '/images/files/big/')
							@php($img_big = $val['file'] ? $val['crop'] ? $path . $val['crop'] : $path . $val['file'] : '')

							<div class="worker">
								<div class="worker-img">
									<img src="{{ $img_big }}" alt="{{ $langSt($val['name']) }}">
								</div>

								<div class="worker-descr">
									<h3 class="name">{{ $langSt($val['name']) }}</h3>
									<p>{{ $langSt($val['text']) }}</p>
								</div>
							</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection