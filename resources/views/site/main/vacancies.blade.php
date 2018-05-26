@extends('site.layouts.default')

@section('content')
	<section class="simple-page--bg">
		<div class="intro-figure dynamic">
			<figure style="background-image: url('/images/bg/vacancy.jpg')"></figure>
		</div>
		<div class="content">
			<header class="light-style">
				<h1 class="headline_main">@lang('main.vacancies')</h1>
			</header>
		</div>
	</section>

	<div class="vacancy">
		<div class="content">
			<div class="vacancy-box inside-mob">
				<div class="content content_md">
					<ul class="vacancy-list">
						@foreach($vacancies as $val)
							<li>
								<a href="/vacancies/{{ $val['id'] }}">
									<h3 class="title">{{ $langSt($val['name']) }}</h3>
									<span class="price">&euro; {{ $val['price_money'] }}</span>

									<span class="place">
										<i><svg> <use xlink:href="/images/svg/sprite.svg#ico_mark"></use> </svg></i>
										<span>{{ $langSt($val['location_name']) }}</span>
									</span>

									<span class="arrow">
										<svg> <use xlink:href="/images/svg/sprite.svg#ico_arrow-right-small"></use> </svg>
									</span>
								</a>
							</li>
						@endforeach
					</ul>

					<header>
						<h2 class="headline_main">@lang('main.advantages')</h2>
						<h4 class="headline_submain">{{ $langSt($params['advantages_vacancy_h3']['key']) }}</h4>
					</header>

					<div class="vacancy-advances">
						<ul>
							@foreach($benefits as $v)
								@php($path_small = '/images/files/small/')
								@php($img_small = $v['file'] ? $v['crop'] ? $path_small . $v['crop'] : $path_small . $v['file'] : '')

								<li>
									<i><img src="{{ $img_small }}" alt="img" /></i>
									<div class="text">
										<h5 class="title">{!! $langSt($v['name']) !!}</h5>
										{!! $langSt($v['text']) !!}
									</div>
								</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>

			<div class="vacancy-quotes">
				<div class="figure dynamic">
					<figure style="background-image: url('/images/items/10911829_78_z.jpg')"></figure>
				</div>

				<div class="text">
					<blockquote>{{ $langSt($main_page['little_description']) }}</blockquote>

					<div class="contacts">
						<ul>
							<li>
								<i class="ico-tel"><svg><use xlink:href="/images/svg/sprite.svg#ico_contact-tel"></use></svg></i>

								<a href="tel:{{ $langSt($params['phone_footer']['key']) }}">
									{{ $langSt($params['phone_footer']['key']) }}
								</a>
							</li>
							<li>
								<i class="ico-fly">
									<svg>
										<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/images/svg/sprite.svg#ico_contact-fly"></use>
									</svg>
								</i>

								<a href="mailto:{{ $langSt($params['email']['key']) }}">{{ $langSt($params['email']['key']) }}</a>
							</li>
						</ul>
					</div>
				</div>
			</div>

			<div class="vacancy-box inside-mob">
				<div class="content content_md">
					<header>
						<h2 class="headline_main">@lang('main.working_conditions')</h2>
						<h4 class="headline_submain">{{ $langSt($params['working_conditions_vacancy_h3']['key']) }}</h4>
					</header>
					<div class="vacancy-terms">
						<ul>
							@foreach($working_conditions as $v)
								@php($path_small = '/images/files/small/')
								@php($img_small = $v['file'] ? $v['crop'] ? $path_small . $v['crop'] : $path_small . $v['file'] : '')

								<li>
									<i><img src="{{ $img_small }}" alt="img" /></i>
									<div class="text">
										<h5 class="title">{!! $langSt($v['name']) !!}</h5>
										{!! $langSt($v['text']) !!}
									</div>
								</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection