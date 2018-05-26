@extends('site.layouts.default')

@section('content')
	<div class="blog-box">
		<div class="content">
			<div class="error-page">
				<h1 class="title">404</h1>
				<h2 class="headline_submain">@lang('main.there_is_no_such_page')</h2>

				<div class="btns_center">
					<a href="/" class="more">@lang('main.to_main')</a>
				</div>
			</div>
		</div>
	</div>
@endsection
