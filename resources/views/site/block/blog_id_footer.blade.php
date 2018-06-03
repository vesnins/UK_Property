@foreach($blogs as $blog)
	@php($path = '/images/files/small/')

	@php($img = $blog['file']
		? $blog['crop'] ? $path . $blog['crop'] : $path . $blog['file']
		: env('PATH_TO_IMG_DEFAULT')
	)

	@php($img_author = $blog['users_file']
		? $blog['users_crop'] ? $path . $blog['users_crop'] : $path . $blog['users_file']
		: env('PATH_TO_IMG_DEFAULT')
	)

	@php($translation = ($blog['translation'] !== '0' && $blog['translation'] !== '') ? $blog['translation'] : false)
	<a href="/blog/{{ $translation or $blog['id'] }}">
		<div class="img-box" style="background-image: url('{{ $img }}')"></div>

		<div class="text-box">
			<header>
				@if($blog['date'])
					@php($date = explode('/', $blog['date']))
				@else
					@php($date = explode('-', $blog['created_at']))
				@endif

				<time datetime="{{ $blog['date'] }}">
					{{ $date['0'] . '-' . $date['1'] . '-' . $date['2'] }}
				</time>

				<span class="post-author">
					<svg><use xlink:href="/images/svg/sprite.svg#user"></use></svg>
					{{ $langSt($blog['author_name']) ?? $langSt($blog['author']) }}
				</span>
			</header>

			<h4>{{ $langSt($blog['name']) }}</h4>
		</div>
	</a>
@endforeach
