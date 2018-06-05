@extends('site.layouts.default')

@section('content')
	@php($path = '/images/files/big/')
	@php($img = $page['file'] ? $page['crop'] ? $path . $page['crop'] : $path . $page['file'] : '')

	<main class="main">
		<div class="subheader fixed-subheader" style="background-image: url('{{ $img }}')">
			<div class="container"><h1>{{ $langSt($page['name']) }}</h1></div>
		</div>

		<div class="scroll-content">
			<div class="indent-block">
				<div class="container">
					<div class="entry-holder">
						<div class="entry-content">
							{!! $langSt($page['text']) !!}
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
@endsection
