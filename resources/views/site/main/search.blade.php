@extends('site.layouts.default')

@section('content')
  <main class="main">
    <div class="subheader fixed-subheader" style="background-image: url('/images/banners/img_7.jpg')">
      <div class="container">
        <h1>@lang('main.search')</h1>
      </div>
    </div>

    <div class="scroll-content">
      <div class="indent-block">
        <div class="container">
          <div class="page-search-form">
            <form role="search" class="search-form" action="/search">
              <input
                type="search"
                name="q"
                placeholder="@lang('main.i_m_searching_for') ..."
                value="{{ $_REQUEST['q'] ?? '' }}"
              />

              <input type="submit" class="button" value="Search" />
            </form>
          </div>

          <div class="articles">
            @foreach($search as $key => $v)
              <article class="article">
                @php(
                  $u = [
                    'str'                          => '/blog/',
                    'str_p'                        => '/pages/',
                    'blog'                         => '/blog/',
                    'catalog_new_building'         => '/catalog/invest-in-a-new-building/',
                    'catalog_development_projects' => '/catalog/invest-in-development-projects/',
                    'catalog_buy'                  => '/catalog/buy/',
                    'catalog_rent'                 => '/catalog/rent/',
                  ]
                )

                <a href="{{ $u[$v->name_table] }}{{ $v->translation ?? $v->id }}" target="_blank">
                  <h3>{{ $page * $limit + ($key + 1) . '. ' }}{{ $langSt($v->name) }}</h3>

                  <p>
                    {!! mb_substr(htmlspecialchars(strip_tags($langSt($v->text))), 0, 300, 'UTF-8') !!}
                  </p>
                </a>
              </article>
            @endforeach
          </div>

          @if(round($count / $limit) > 1)
            <ul class="pagination">
              @foreach(range($page - 1, $page + 1) as $key => $v)
                @if($key === 0 && $v)
                  <li class="nav-btn prev">
                    <a href="/search/{{ $v }}?q={{ $q }}" class="page-one prev">
                      <svg>
                        <use xlink:href="/images/svg/sprite.svg#arrow-left"></use>
                      </svg>
                    </a>
                  </li>

                  <li><a href="/search/{{ $v }}?q={{ $q }}" class="page-one">{{ $v }}</a></li>
                @endif

                @if($key === 1)
                  <li class="active"><a href="/search/{{ $v }}?q={{ $q }}" class="page-one current">{{ $v }}</a></li>
                @endif

                @if($key === 2 && $v < round($count / $limit))
                  <li><a href="/search/{{ $v }}?q={{ $q }}" class="page-one">{{ $v }}</a></li>

                  <li class="nav-btn next">
                    <a href="/search/{{ $v }}?q={{ $q }}" class="page-one next">
                      <svg>
                        <use xlink:href="/images/svg/sprite.svg#arrow-right"></use>
                      </svg>
                    </a>
                  </li>
                @endif
              @endforeach
            </ul>
          @endif
        </div>
      </div>
    </div>
  </main>

  @push('footer')
    <script>
      $(document).ready(function() {
        catAll.initialize({
          container  : '.sys-sel-catalog',
          num        : '.selReN > .i',
          pagination : false,
          isLoad     : false,
          isPortfolio: false,
          url_req    : '/',
        });
      });

      $('#header').addClass('static');
    </script>
  @endpush
@endsection