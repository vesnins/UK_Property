@php($url = [
  'catalog_new_building'         => 'invest-in-a-new-building',
  'catalog_development_projects' => 'invest-in-development-projects',
  'catalog_buy'                  => 'buy',
  'catalog_rent'                 => 'rent',
])

@if($paginator->hasPages())
  @php($current_url = '')
  @php($current = $paginator->currentPage())

  @if(count(explode('search_render_catalog', $paginator->nextPageUrl())) > 1)
    @php($current_url = "/catalog/{$url[$paginator->items()[0]['name_table']]}")
    @php($paginator->setPath($current_url))
  @endif

  {{--_tools/search_render_catalog--}}
  <ul class="pagination" style="clear:both; width: 100%">
    @if($paginator->onFirstPage())
    @else
      <li class="nav-btn prev">
        <a
          href="{{ $paginator->previousPageUrl($current_url ? $current_url : '') }}"
          data-page="{{ ($current > 1 ? $current - 1 : 1) }}"
        >
          <svg>
            <use xlink:href="/images/svg/sprite.svg#arrow-left"></use>
          </svg>
        </a>
      </li>
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
          @if(array_search($page, range($current - 2, $current + 2)) !== false)
            @if($page == $paginator->currentPage())
              <li class="active"><a href="javascript:void(0)">{{ $page }}</a></li>
            @else
              <li>
                <a
                  href="{{ $current_url ? str_replace('/_tools/search_render_catalog', $current_url, $url) : $url }}"
                  data-page="{{ $page }}"
                >
                  {{ $page }}
                </a>
              </li>
            @endif
          @endif
        @endforeach
      @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
      <li class="nav-btn next">
        <a href="{{ $paginator->nextPageUrl($current_url ? $current_url : '') }}" data-page="{{ $current + 1 }}">
          <svg>
            <use xlink:href="/images/svg/sprite.svg#arrow-right"></use>
          </svg>
        </a>
      </li>
    @else

    @endif
  </ul>
@endif