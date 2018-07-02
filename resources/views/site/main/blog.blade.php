@extends('site.layouts.default')

@section('content')
  <main class="main page-decor-holder">
    <img class="decor decor_1" src="images/decor/img_10.png" data-parallax='{"y": -60, "smoothness": 30}' alt="">
    <img class="decor decor_2" src="images/decor/img_8.png" data-parallax='{"y": -100, "smoothness": 15}' alt="">
    <img class="decor decor_3" src="images/decor/img_11.png" data-parallax='{"y": -140, "smoothness": 45}' alt="">
    <img class="decor decor_4" src="images/decor/img_2.png" data-parallax='{"y": -60, "smoothness": 30}' alt="">
    <img class="decor decor_5" src="images/decor/img_4.png" data-parallax='{"y": -100, "smoothness": 15}' alt="">
    <img class="decor decor_6" src="images/decor/img_8.png" data-parallax='{"y": -140, "smoothness": 45}' alt="">
    <img class="decor decor_7" src="images/decor/img_3.png" data-parallax='{"y": -60, "smoothness": 30}' alt="">

    <section class="indent-block">
      <div class="container">
        <h1 class="text-center">@lang('main.blog')</h1>

        <div class="collapse-menu-holder">
          <span class="collapse-btn">
            <span class="dt">Show</span>
            <span class="t">Hide</span>
            filters
            <svg>
              <use xlink:href="/images/svg/sprite.svg#arrow-down"></use>
            </svg>
          </span>

          <div class="tag-list hidden-box">
            <a href="/blog">@lang('main.all_articles')</a>

            @foreach($tags as $tag)
              <a
                href="?tag={{ $tag['id'] }}"
                class="{{ array_search($tag['id'], $current_tags) !== false ? 'active' : '' }}"
              >
                {{ $langSt($tag['name']) }}
              </a>
            @endforeach
          </div>
        </div>

        <div class="posts-list">
          @include('site.block.blog_main_list', ['paginate' => true])
        </div>
      </div>
    </section>
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