@php($inc = [0 => 1, 1 => 2, 2 => 2, 3 => 2, 4 => 2, 5 => 1, 6 => 1, 7 => 2, 8 => 2])
@php($i = 0)

@foreach($blog as $key => $val)
	@if($inc[$key] === 1)
		@php($i = 0)
		{!! '<div class="post-group ' . ($inc[$key] === 1 ? 'single' : '') . ' ">' !!}
	@else
		@if($i === 0)
			{!! '<div class="post-group">' !!}
		@endif
	@endif

	@if($inc[$key] === 1)
		@php($path = '/images/files/big/')
	@else
		@php($path = '/images/files/small/')
	@endif

	@php($img = $val['file']
		? $val['crop'] ? $path . $val['crop'] : $path . $val['file']
		: '/images/files/no-image.jpg'
	)

	<a href="/blog/{{ (int) $val['translation'] ? $val['translation'] : $val['id'] }}" class="post">
		<div class="img-box" style="background-image: url('{{ $img }}')"></div>

		<div class="text-box">
			<header>
				@if($val['date'])
					@php($date = explode('/', $val['date']))
				@else
					@php($date = explode('-', $val['created_at']))
				@endif

				<time datetime="{{ $val['date'] }}">{{ $date['0'] . '-' . $date['1'] . '-' . $date['2'] }}</time>

				<span class="post-author">
					<svg><use xlink:href="images/svg/sprite.svg#user"></use></svg>
					{{ $langSt($val['author_name']) ?? $langSt($val['author']) }}
				</span>
			</header>

			<h4>{{ $langSt($val['name']) }}</h4>

			@if($inc[$key] === 1)
				<p>
					{{
						mb_substr(htmlspecialchars(
							$langSt($val['little_description'])),
							0,
							$inc[$key] === 1 ? 150 : 70,
							'UTF-8'
						)
					 }}
				</p>
			@endif
		</div>
	</a>

	@if($inc[$key] === 1)
		{!! '</div>' !!}
	@else
		@php($i++)

		@if($i === 2)
			{!! '</div>' !!}
			@php($i = 0)
		@endif

		@if(!isset($blog[$key + 1]))
			{!! '</div>' !!}
		@endif
	@endif
@endforeach


@if($paginate ?? false)
	{!! $blog->links('site.block.pagination') !!}
@endif
