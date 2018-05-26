@extends('site.layouts.default')

@section('content')
	<section class="simple-page--bg">
		<div class="intro-figure dynamic">
			@php($path_small = '/images/files/big/')
			@php($img_small = $menu_segment['file'] ? $menu_segment['crop'] ? $path_small . $menu_segment['crop'] : $path_small . $menu_segment['file'] : '')
			<figure style="background-image: url({{ $img_small }})"></figure>
		</div>

		<div class="content">
			<header class="light-style">
				<h1 class="headline_main">@lang('main.favorites')</h1>
			</header>
		</div>
	</section>

	<div class="simple-page--main bg-grey favorite-box">
		<div class="request-head">
			<div class="request-head--nav" id="favoriteNav">
				<div class="content content_md">
					<div class="btns_box">
						<button type="button" class="btn btn_subm scroll-to-request">
							<span>@lang('main.request_all')</span>
						</button>

						<a href="javascript:void(0);" class="btn btn_nobord show-modal" data-modal="friend-form">
							<i class="ico-send"><svg> <use xlink:href="/images/svg/sprite.svg#ico_action-write"></use> </svg></i>
							<span>@lang('main.send')</span>
						</a>
					</div>
				</div>
			</div>
		</div>

		<div class="villas">
			<div class="content content_md">
				<div class="villas--wrap selResult"></div>
			</div>
		</div>
	</div>

	@include('site.block.favorite_modal')

	<section class="section home-request">
		<div class="content">
			<header>
				<h3 class="headline_main">@lang('main.selection_request')</h3>
				{{--<h4 class="headline_submain">Заполните заявку и получите подборку вилл по вашим кретриям</h4>--}}
			</header>

			<div class="home-request--wrap">
				<div class="home-request--main" style="background-image: url('/images/bg/offer01.jpg')">
					@include('site.block.selection_request')
				</div>
			</div>
		</div>
	</section>

	@push('footer')
	<script>
		$(document).ready(function() {
			filVil.initialize({
				cont      : '.selResult',
				num       : '.selReN > .i',
				pagination: true,
				url_req   : '/',
			});
		});

		$('#header').addClass('static');
	</script>
	@endpush
@endsection