@extends('site.layouts.default')

@section('content')
	<section class="simple-page--head villa--head">
		<div class="content">
			<header class="light-style">
				<h1 class="headline_main">
					@if($title)
						{{ str_replace(':: ', '', $title) }}
					@else
						@lang('main.villas')
					@endif
				</h1>
			</header>
		</div>

		<div class="half-request">
			@include('site.block.main_filter')
		</div>
	</section>

	<div class="simple-page--main bg-grey">
		<div class="villas">
			<div class="content content_md">
				<div class="villas--wrap sel-villas"></div>
				<input name="pagination" value="1" type="hidden" autocomplete="off"/>
			</div>
		</div>
	</div>

	@push('footer')
	<script>
		$(document).ready(function() {
			filVil.initialize({
				cont      : '.sel-villas',
				isLoad    : true,
				num       : '.selReN > .i',
				pagination: true,
				url_req   : '/',
			});
		});
	</script>
	@endpush
@endsection