<ul class="grid-list" style="width: 100%;">
	@foreach($villas as $val)
		@php($path = '/images/files/small/')

		@php($img = $val['file']
			? $val['crop'] ? $path . $val['crop'] : $path . $val['file']
			: '/images/files/no-image.jpg'
		)

		<li>
			<a href="/villas/{{ $val['id'] }}" target="_blank">
				<figure style="background-image: url({{ $img }})"></figure>

				<div class="grid--main">
					<h3 class="title">{{ $langSt($val['name']) }}</h3>

					<div class="price">
						@lang('main.from_') {{ number_format($val['price_money'], 0, ',', ' ') }} <strong>&euro;</strong>
					</div>

					<div class="includes">
						@if($val['bedroom'])
							<span class="bed">
									<i><svg> <use xlink:href="/images/svg/sprite.svg#ico_villa-bed"></use> </svg></i>
									<span>{{ $val['bedroom'] }}</span>
							</span>
						@endif

						@if($val['bathroom'])
							<span class="bath">
									<i><svg> <use xlink:href="/images/svg/sprite.svg#ico_villa-bath"></use> </svg></i>
									<span>{{ $val['bathroom'] }}</span>
							</span>
						@endif

						<span class="sea">
							<i><svg> <use xlink:href="/images/svg/sprite.svg#ico_villa-sea"></use> </svg></i>

							<span>
								@if($val['sea'] === 1)
									@lang('main.with_access_to_the_beach')
								@elseif($val['sea'] === 2)
									500 @lang('main.m')
								@elseif($val['sea'] === 3)
									1 @lang('main.km')
								@elseif($val['sea'] === 4)
									@lang('main.more_than') 1 @lang('main.km')
								@endif
							</span>
						</span>
					</div>
				</div>
			</a>
	@endforeach
</ul>

@if($paginate ?? false)
	{!! $villas->links('site.block.pagination') !!}
@endif
