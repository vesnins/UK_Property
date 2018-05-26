@if($paginator->hasPages())
	@php($current = $paginator->currentPage())

	<div class="paging_center">
		<div class="paging-list">
			{{-- Previous Page Link --}}
			@if($paginator->onFirstPage())
				<a class="disabled prev page-one" disabled="disabled">
					<svg>
						<use xlink:href="/images/svg/sprite.svg#ico_page-prev"></use>
					</svg>
				</a>
			@else
				<a class="prev page-one" href="{{ $paginator->previousPageUrl() }}" rel="prev" data-page="{{ $current -1 }}">
					<svg>
						<use xlink:href="/images/svg/sprite.svg#ico_page-prev"></use>
					</svg>
				</a>
			@endif

			{{-- Pagination Elements --}}
			@foreach($elements as $element)
				{{-- "Three Dots" Separator --}}
				@if (is_string($element))
					<a class="disabled page-one" data-page="{{ $current }}">{{ $element }}</a>
				@endif

				{{-- Array Of Links --}}
				@if(is_array($element))
					@foreach($element as $page => $url)
						@if ($page == $paginator->currentPage())
							<a class="page-one current" data-page="{{ $current }}">{{ $page }}</a>
						@else
							<a class="page-one" href="{{ $url }}" data-page="{{ $page }}">{{ $page }}</a>
						@endif
					@endforeach
				@endif
			@endforeach

			{{-- Next Page Link --}}
			@if ($paginator->hasMorePages())
				<a class="next page-one" href="{{ $paginator->nextPageUrl() }}" rel="next" data-page="{{ $current + 1 }}">
					<svg>
						<use xlink:href="/images/svg/sprite.svg#ico_page-next"></use>
					</svg>
				</a>
			@else
				<a class="disabled next page-one" disabled="disabled">
					<svg>
						<use xlink:href="/images/svg/sprite.svg#ico_page-next"></use>
					</svg>
				</a>
			@endif
		</div>

		@if(ceil($paginator->total() / $paginator->perPage()))
			<span class="total">из {{ ceil($paginator->total() / $paginator->perPage()) }}</span>
		@endif
	</div>
@endif