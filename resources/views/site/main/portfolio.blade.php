@extends('site.layouts.default')

@section('content')
  <form action="#" name="catalog_form" class="product-filter-form">
  <main class="main">
    <section class="indent-block">
      <div class="container-fluid">
        <h1 class="text-center">{{ $langSt($meta['title']) ?? 'Portfolio' }}</h1>

        <header class="sort-form-holder">
          <div class="sort-form">
            <label for="sort-select">@lang('main.sort_by')</label>

            <select title="" id="sort-select" name="group">
              {{--<option value="2">@lang('main.popularity_')</option>--}}
              <option value="3">@lang('main.distance_')</option>
              <option value="1">@lang('main.price_')</option>
              <option value="4">@lang('main.area_')</option>
              <option value="5">@lang('main.latest_')</option>
            </select>
            <a
              href="javascript:void(0)"
              class="reverse-btn"

              onclick="
                      if($(this).hasClass('reverse'))
                        $(this).removeClass('reverse');
                      else
                        $(this).addClass('reverse');

                      if($(this).hasClass('reverse'))
                        $('[name=\'sort_by\']').val('DESC');
                      else
                        $('[name=\'sort_by\']').val('ASC');
                    "
            >
              <svg>
                <use xlink:href="/images/svg/sprite.svg#reverse"></use>
              </svg>
            </a>
          </div>
        </header>

        <div class="sys-sel-catalog"></div>
      </div>
    </section>
  </main>

    <input name="pagination" value="{{ $page ?? 1 }}" type="hidden" autocomplete="off" />
    <input type="hidden" name="sort_by" value="ASC" autocomplete="off" />
    <input type="hidden" name="show_like" value="1" autocomplete="off" />
  </form>

  @push('footer')
    <script>
      $(document).ready(function() {
        catAll.initialize({
          container  : '.sys-sel-catalog',
          isLoad     : true,
          num        : '.selReN > .i',
          pagination : true,
          isPortfolio: true,
          url_req    : '/',
        })
      });
    </script>
  @endpush
@endsection
