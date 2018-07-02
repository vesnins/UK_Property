@extends('site.layouts.default')

@section('content')
  @php($path_big = '/images/files/big/')

  <main class="main page-decor-holder ">
    <img class="decor decor_8" src="/images/decor/img_10.png" data-parallax='{"y": -60, "smoothness": 30}' />
    <img class="decor decor_9" src="/images/decor/img_12.png" data-parallax='{"y": -100, "smoothness": 15}' />
    <img class="decor decor_10" src="/images/decor/img_2.png" data-parallax='{"y": -140, "smoothness": 45}' />
    <img class="decor decor_11" src="/images/decor/img_8.png" data-parallax='{"y": -60, "smoothness": 30}' />
    <img class="decor decor_12" src="/images/decor/img_13.png" data-parallax='{"y": -100, "smoothness": 15}' />
    <section class="indent-block">
      <div class="container">
        <h1 class="text-center">{{ $langSt($about['name']) }}</h1>

        <div class="about-info">
          <div class="info-item">
            <div class="img-box">
              @php($img = $images[0]['file']
               ? $images[0]['crop']
                ? $path_big . $images[0]['crop']
                : $path_big . $images[0]['file']
               : '')

              <img src="{{ $img }}" />
            </div>

            <div class="text-box">
              <p>{!! $langSt($about['block_1']) !!}</p>

              <div class="percent-box">
                <p>{{ $langSt($about['block_1_1']) }}</p>
                <span class="percent">{{ $langSt($about['block_1_2']) }}</span>
              </div>
            </div>
          </div>

          <div class="info-item">
            <div class="img-box">
              @php($img = $images[1]['file']
               ? $images[1]['crop']
                ? $path_big . $images[1]['crop']
                : $path_big . $images[1]['file']
               : '')

              <img src="{{ $img }}" />
            </div>

            <div class="text-box">
              <p>{!! $langSt($about['block_2']) !!}</p>
            </div>
          </div>

          <div class="info-item">
            <div class="img-box">
              @php($img = $images[2]['file']
               ? $images[2]['crop']
                ? $path_big . $images[2]['crop']
                : $path_big . $images[2]['file']
               : '')

              <img src="{{ $img }}" />
            </div>

            <div class="text-box">
              <blockquote class="blockquote">
                <p>{!! $langSt($about['block_3']) !!}</p>
                <cite>{!! $langSt($about['block_3_1']) !!}</cite>
              </blockquote>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="indent-block certificate-area">
      <div class="container tab-holder">
        <div class="custom-row">
          <div class="description-box tab-content">
            <div class="tab-item tab-item-tab_1 active"><h3>{!! $langSt($about['block_4_1']) !!}</h3></div>
            <div class="tab-item tab-item-tab_2"><h3>{!! $langSt($about['block_4_2']) !!}</h3></div>

            <ul class="tab-navigation-list">
              <li class="active" data-class="tab_1"><a href="#">{!! $langSt($about['block_4_1']) !!}</a></li>
              <li data-class="tab_2"><a href="#">{!! $langSt($about['block_4_2']) !!}</a></li>
            </ul>
          </div>

          <div class="slider-holder tab-content">
            <div class="tab-item tab-item-tab_1 active">
              <div class="certificate-slider simple-slider">
                @foreach($slider_1 as $sl_1)
                  @php($img = $sl_1['file'] ? $sl_1['crop'] ? $path_big . $sl_1['crop'] : $path_big . $sl_1['file'] : '')
                  <div><img src="{{ $img }}" /></div>
                @endforeach
              </div>
            </div>

            <div class="tab-item tab-item-tab_2">
              <div class="certificate-slider simple-slider">
                @foreach($slider_2 as $sl_2)
                  @php($img = $sl_2['file'] ? $sl_2['crop'] ? $path_big . $sl_2['crop'] : $path_big . $sl_2['file'] : '')
                  <div><img src="{{ $img }}" /></div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="subscribe-section" style="background-image: url('/images/banners/img_2.jpg')">
      <div class="container">
        <div class="row text-center">
          <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
            <div class="section-title">@lang('main.contact_us_for_free_initial_consultation')</div>
            <p>{!! $langSt($params['contact_us_text_contact_an_agent']['key']) !!}</p>

            <a href="#" class="link" data-toggle="modal" data-target=".request-modal">
              @lang('main.contact_an_agent')
            </a>
          </div>
        </div>
      </div>
    </section>

    <section class="indent-block testimonials-section" style="background-image: url('/images/banners/img_10.jpg')">
      <div class="container large">
        <h3>@lang('main.reviews')</h3>

        <div class="testimonials-slider">
          @foreach($reviews as $review)
            <div>
              <div class="inner-box">
                <span class="user-name">{{ $langSt($review['name']) }}</span>
                <span class="location">{{ $langSt($review['location_name']) }}</span>
                <p>{{ $langSt($review['little_description']) }}</p>
              </div>
            </div>
          @endforeach
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