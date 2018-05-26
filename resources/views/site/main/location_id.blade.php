@extends('site.layouts.default')

@section('content')
	@php($path = '/images/files/big/')
	@php($img = $location['file'] ? $location['crop'] ? $path . $location['crop'] : $path . $location['file'] : '')

	<section class="simple-page--bg">
		<div class="intro-figure dynamic">
			<figure style="background-image: url({{ $img }})"></figure>
		</div>

		<div class="content">
			<header class="light-style">
				<h1 class="headline_main">{{ $langSt($location['name']) }}</h1>
			</header>
		</div>
	</section>

	<div class="simple-page--main">
		<div class="content content_sm">
			<div class="location-text text-box">
				{!! $langSt($location['text']) !!}
			</div>
		</div>

		<div class="villas bg-grey">
			<div class="content content_md">
				<header>
					<h3 class="headline_main">@lang('main.villas_on') {{ $langSt($location['name_p']) }}</h3>
					<h4 class="headline_submain">{{ $langSt($location['little_description']) }}</h4>
				</header>
			</div>

			<div class="content">
				<div class="half-request double">
					@include('site.block.main_filter', ['locations' => [$location], 'all_destinations' => false])
				</div>
			</div>

			<div class="content content_md">
				<div class="villas--wrap">
					@include('site.block.villas_main_list', ['villas' => $villas])
				</div>
			</div>
		</div>

		<section class="section short-offers">
			<div class="content">
				<div class="grid">
					<ul class="grid-list">
						@foreach($locations as $v)
							@php($path = '/images/files/small/')

							@php($img = $v['file']
								? $v['crop'] ? $path . $v['crop'] : $path . $v['file']
								: '/images/files/no-image.jpg'
							)

							<li>
								<a href="/location/{{ $v['id'] ?? $v['translation'] }}">
									<figure style="background-image: url('{{ $img }}')"></figure>
									<div class="grid--main">
										<h3 class="title">{{ $langSt($v['name']) }}</h3>
									</div>
								</a>
							</li>
						@endforeach
					</ul>
				</div>
			</div>
		</section>
	</div>
@endsection
