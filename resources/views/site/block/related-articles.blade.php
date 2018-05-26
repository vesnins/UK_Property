@foreach($blogs as $val)
	<li>
		@php($path = '/images/files/small/')

		@php($img = $val['file']
			? $val['crop'] ? $path . $val['crop']
			: $path . $val['file'] : '/images/files/no-image.jpg'
		)

		<article class="article">
			<figure style="background-image: url({{ $img }})"><a href="/blog/{{ $val['id'] }}"></a></figure>

			<div class="head">
				<h4 class="title"><a href="/blog/{{ $val['id'] }}">{{ $langSt($val['name']) }}</a></h4>
			</div>
		</article>
	</li>
@endforeach
