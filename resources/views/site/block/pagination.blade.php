@if($paginator->hasPages())
  @php($current = $paginator->currentPage())

  <ul class="pagination" style="clear:both; width: 100%">
    @if($paginator->onFirstPage())
    @else
      <li class="nav-btn prev">
        <a  href="{{ $paginator->previousPageUrl() }}">
          <svg><use xlink:href="/images/svg/sprite.svg#arrow-left"></use></svg>
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
          @if ($page == $paginator->currentPage())
              <li class="active"><a href="javascript:void(0)">{{ $page }}</a></li>
          @else
              <li><a href="{{ $url }}">{{ $page }}</a></li>
          @endif
        @endforeach
      @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <li class="nav-btn next">
          <a href="{{ $paginator->nextPageUrl() }}">
            <svg><use xlink:href="/images/svg/sprite.svg#arrow-right"></use></svg>
          </a>
        </li>
    @else

    @endif
  </ul>
@endif