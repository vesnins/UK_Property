<ul class="layout layout_lg">
	@foreach($blog as $val)
		<li>
			<article class="article">
				@php($path = '/images/files/small/')

				@php($img = $val['file']
					? $val['crop'] ? $path . $val['crop'] : $path . $val['file']
					: '/images/files/no-image.jpg'
				)

				<figure style="background-image: url({{ $img }})">
					<a href="/blog/{{ $val['translation'] ?? $val['id'] }}"></a>
				</figure>

				<div class="head">
					<h4 class="title">
						<a href="/blog/{{ $val['translation'] ?? $val['id'] }}">{{  $langSt($val['name']) }}</a>
					</h4>

					<div class="article-data">
						@if($val['date'])
							@php($date = explode('-', $val['date']))
						@else
							@php($date = explode('-', $val['created_at']))
						@endif
							<time>{{ (int) $date['2'] . ' ' . $mount($date['1']) . ' ' . $date['0'] }}</time>

						<span class="views">
							<i><svg><use xlink:href="/images/svg/sprite.svg#ico_blog-eye"></use></svg></i>
							<span>{{ $val['views'] ?? 0 }}</span>
						</span>

						{{--<span class="comments">--}}
							{{--<i><svg><use xlink:href="/images/svg/sprite.svg#ico_blog-message"></use></svg></i>--}}
							{{--<span>{{ $val['comments'] ?? 0 }}</span>--}}
						{{--</span>--}}
					</div>
				</div>
			</article>
		</li>
	@endforeach
</ul>

@if($paginate ?? false)
	{!! $blog->links('site.block.pagination') !!}
@endif
