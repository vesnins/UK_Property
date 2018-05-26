@extends('site.layouts.default')

@section('content')
	<section class="simple-page--bg">
		<div class="intro-figure selection-mode dynamic">
			<figure style="background-image: url('/images/bg/Navagio-beach-featured.jpg')"></figure>
		</div>

		<div class="selection-request">
			<div class="content">
				<header class="light-style">
					<h3 class="headline_main">@lang('main.selection_request')</h3>
				</header>

				@include('site.block.selection_request')
			</div>
		</div>
	</section>
@endsection