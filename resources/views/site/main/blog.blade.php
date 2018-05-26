@extends('site.layouts.default')

@section('content')
	<div class="blog-box">
		<section class="simple-page--head">
			<div class="content">
				<header>
					<h1 class="headline_main">@lang('main.blog')</h1>
				</header>
			</div>
		</section>
		<div class="content">
			<div class="blog-box--wrap">
				<div class="tags">
					<ul>
						<li><a href="/blog">@lang('main.all_articles')</a></li>

						@foreach($tags as $tag)
							<li>
								<a
									href="?tag={{ $tag['id'] }}"
									class="{{ array_search($tag['id'], $current_tags) !== false ? 'active' : '' }}"
								>
									{{ $langSt($tag['name']) }}
								</a>
							</li>
						@endforeach
					</ul>
				</div>

				@include('site.block.blog_main_list', ['paginate' => true])
			</div>
		</div>
	</div>
@endsection